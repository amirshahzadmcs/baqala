<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Hunger_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getHungerSummary() {
        $this->db->select("
            mhm.id,
            mhm.summary_month,
			mhm.from_date,
			mhm.to_date,
            CONCAT(mhm.from_date, ' -> ', mhm.to_date) AS From_To,
            mhm.status,
            mhm.created_at,
            (
                SELECT COUNT(*) 
                FROM maha_hunger_monthly_summary mhms 
                WHERE mhms.main_id  = mhm.id
            ) AS Total_Employees,
            (
                SELECT SUM(mhms.notified_deliveries) 
                FROM maha_hunger_monthly_summary mhms 
                WHERE mhms.main_id  = mhm.id
            ) AS Total_Notified_Deliveries,
            (
                SELECT SUM(mhms.completed_deliveries) 
                FROM maha_hunger_monthly_summary mhms 
                WHERE mhms.main_id  = mhm.id
            ) AS Total_Completed_Deliveries
        ");
        $this->db->from('maha_hunger_monthly mhm');
        $this->db->order_by('mhm.summary_month', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array(); // Return as an array of results
    }

	public function delete($main_id)
    {
        $this->db->trans_start();

        // Delete from child table
        $this->db->where('main_id', $main_id);
        $this->db->delete('maha_hunger_monthly_summary');

        // Delete from main table
        $this->db->where('id', $main_id);
        $this->db->delete('maha_hunger_monthly');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_hunger_monthly_summary');
		return $query->row();
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "
		SELECT 
		mhm.*, me.emp_no, me.full_name, me.mobile, 
		(
			SELECT GROUP_CONCAT(ht.name) 
			FROM hunger_team ht 
			WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
		) as team_name 
		FROM maha_hunger_monthly_summary mhm 
		LEFT JOIN master_employee me ON (mhm.emp_id = me.id) WHERE 1=1";
		return $a;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT maha_hunger_monthly.* FROM maha_hunger_monthly WHERE maha_hunger_monthly.id = '" . (int)$id . "'");
		return $query->row_array();
	}

	public function summaryDetail($main_id, $search = '', $perPage = 50, $page = 1)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'hunger_monthly_summary'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mhms.id', 'mhms.emp_id', 'me.emp_no', 'me.full_name', 'mhms.rider_id', 
				'mhms.city_name', 'mhms.contract_name', 'mhms.vehicle_name', 'mhms.batch_number',
				'mhms.tga_status', 'mhms.error_codes', 'mhms.shifts', 'mhms.working_days',
				'mhms.planned_working_hours', 'mhms.actual_working_hours', 'mhms.avg_working_hours',
				'mhms.attendance_rate', 'mhms.break_hours', 'mhms.lost_hours', 'mhms.acceptance_rate',
				'mhms.contact_rate', 'mhms.no_shows', 'mhms.no_shows_percent', 'mhms.notified_deliveries',
				'mhms.completed_deliveries', 'mhms.accepted_deliveries', 'mhms.not_accepted_deliveries',
				'mhms.stacked_deliveries', 'mhms.declined_deliveries', 'mhms.cancelled_deliveries',
				'mhms.created_at', 'mhms.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mhms.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mhms.' . $col);
			}, $selectedColumns);
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_hunger_monthly_summary mhms');
		$this->db->join('master_employee me', 'mhms.emp_id = me.id', 'left');
		$this->db->where('mhms.main_id', $main_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('me.full_name', $search);
			$this->db->group_end();
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();
		if (in_array('mhms.completed_deliveries', $selectedColumns)) {
			$this->db->order_by('mhms.completed_deliveries', 'DESC');
		}
		// ✅ Offset Calculation
		$offset = max(0, ($page - 1) * $perPage);

		$this->db->limit($perPage, $offset);
		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'pagination' => [
				'total' => $totalRows,
				'per_page' => $perPage,
				'current_page' => $page,
			]
		];
	}


	public function summaryDetailCount($main_id, $search = '')
	{
		$this->db->from('maha_hunger_monthly_summary mhms');
		$this->db->join('master_employee me', 'mhms.emp_id = me.id', 'left');
		$this->db->where('mhms.main_id', $main_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('me.full_name', $search);
			$this->db->group_end();
		}

		return $this->db->count_all_results();
	}


    
	/*----- List Info End -----*/

	public function checkDuplicateInBulk($summary_month) {
		if (empty($summary_month)) {
			return [];
		}
		$this->db->select('summary_month');
		$this->db->from('maha_hunger_monthly');
		$this->db->where('summary_month', $summary_month);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	/*
	public function printPerformanceReport($main_id, $column_type, $file_format)
	{
		if (empty($main_id)) {
			return null;
		}
		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'hunger_monthly_summary'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mhms.id', 'mhms.emp_id', 'me.emp_no', 'me.full_name', 'mhms.rider_id', 
				'mhms.city_name', 'mhms.contract_name', 'mhms.vehicle_name', 'mhms.batch_number',
				'mhms.tga_status', 'mhms.error_codes', 'mhms.shifts', 'mhms.working_days',
				'mhms.planned_working_hours', 'mhms.actual_working_hours', 'mhms.avg_working_hours',
				'mhms.attendance_rate', 'mhms.break_hours', 'mhms.lost_hours', 'mhms.acceptance_rate',
				'mhms.contact_rate', 'mhms.no_shows', 'mhms.no_shows_percent', 'mhms.notified_deliveries',
				'mhms.completed_deliveries', 'mhms.accepted_deliveries', 'mhms.not_accepted_deliveries',
				'mhms.stacked_deliveries', 'mhms.declined_deliveries', 'mhms.cancelled_deliveries',
				'mhms.created_at', 'mhms.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mhms.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mhms.' . $col);
			}, $selectedColumns);
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_hunger_monthly_summary mhms');
		$this->db->join('master_employee me', 'mhms.emp_id = me.id', 'left');
		$this->db->where('mhms.main_id', $main_id);

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();

		$result = $this->db->get()->result_array();
		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'total_rows' => $totalRows,
		];
	}*/
	
	public function printPerformanceReport($main_id, $search, $column_type, $file_format)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(), 
			'module_name' => 'hunger_monthly_summary'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			// Default columns if no preferences saved
			$selectedColumns = [
				'mhms.id', 'mhms.emp_id', 'me.emp_no', 'me.full_name', 'mhms.rider_id', 
				'mhms.city_name', 'mhms.contract_name', 'mhms.vehicle_name', 'mhms.batch_number',
				'mhms.tga_status', 'mhms.error_codes', 'mhms.shifts', 'mhms.working_days',
				'mhms.planned_working_hours', 'mhms.actual_working_hours', 'mhms.avg_working_hours',
				'mhms.attendance_rate', 'mhms.break_hours', 'mhms.lost_hours', 'mhms.acceptance_rate',
				'mhms.contact_rate', 'mhms.no_shows', 'mhms.no_shows_percent', 'mhms.notified_deliveries',
				'mhms.completed_deliveries', 'mhms.accepted_deliveries', 'mhms.not_accepted_deliveries',
				'mhms.stacked_deliveries', 'mhms.declined_deliveries', 'mhms.cancelled_deliveries',
				'mhms.created_at', 'mhms.updated_at'
			];
		} else {
			// Add table prefixes
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mhms.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mhms.' . $col);
			}, $selectedColumns);
		}

		// ✅ Check if grouping by emp_no is needed
		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		// ✅ Define which columns should be summed
		$sumColumns = [
			'mhms.shifts', 'mhms.working_days', 'mhms.planned_working_hours', 'mhms.actual_working_hours', 
			'mhms.break_hours', 'mhms.lost_hours', 'mhms.no_shows', 'mhms.no_shows_percent', 
			'mhms.notified_deliveries', 'mhms.completed_deliveries', 'mhms.accepted_deliveries', 
			'mhms.not_accepted_deliveries', 'mhms.stacked_deliveries', 'mhms.declined_deliveries', 
			'mhms.cancelled_deliveries'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				// ✅ Fix: Remove `mhms.` prefix from alias in SUM() columns
				$alias = str_replace('mhms.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $finalColumns));
		$this->db->from('maha_hunger_monthly_summary mhms');
		$this->db->join('master_employee me', 'mhms.emp_id = me.id', 'left');
		$this->db->where('mhms.main_id', $main_id);

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search); // Remove spaces for flexibility
		
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('REPLACE(me.full_name, " ", "")', $sanitizedSearch);
			$this->db->group_end();
		}	
		
		if ($isGroupedByRider) {
			$this->db->group_by('me.emp_no');
		}

		// ✅ Apply ORDER BY emp_no if available
		if ($isGroupedByRider && in_array('mhms.completed_deliveries', $selectedColumns)) {
			$this->db->order_by('completed_deliveries', 'DESC');
		} elseif (in_array('mhms.completed_deliveries', $selectedColumns)) {
			$this->db->order_by('mhms.completed_deliveries', 'DESC');
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();

		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'total_rows' => $totalRows,
		];
	}
	
	public function printRawReport($main_id, $search)
	{
		if (empty($main_id)) {
			return null;
		}

		$selectedColumns = [
			'mhms.emp_id', 'me.emp_no', 'me.full_name', 'mhms.rider_id', 
			'mhms.city_name', 'mhms.contract_name', 'mhms.vehicle_name', 'mhms.batch_number',
			'mhms.tga_status', 'mhms.error_codes', 'mhms.shifts', 'mhms.working_days',
			'mhms.planned_working_hours', 'mhms.actual_working_hours', 'mhms.avg_working_hours',
			'mhms.attendance_rate', 'mhms.break_hours', 'mhms.lost_hours', 'mhms.acceptance_rate',
			'mhms.contact_rate', 'mhms.no_shows', 'mhms.no_shows_percent', 'mhms.notified_deliveries',
			'mhms.completed_deliveries', 'mhms.accepted_deliveries', 'mhms.not_accepted_deliveries',
			'mhms.stacked_deliveries', 'mhms.declined_deliveries', 'mhms.cancelled_deliveries',
			'mhms.created_at'
		];

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_hunger_monthly_summary mhms');
		$this->db->join('master_employee me', 'mhms.emp_id = me.id', 'left');
		$this->db->where('mhms.main_id', $main_id);

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search); // Remove spaces
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('REPLACE(me.full_name, " ", "")', $sanitizedSearch);
			$this->db->group_end();
		}

		$this->db->order_by('mhms.completed_deliveries', 'DESC');

		// Get data
		$result = $this->db->get()->result_array();
		$totalRows = count($result);

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $selectedColumns,
			'total_rows' => $totalRows,
		];
	}

}

