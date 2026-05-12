<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Hunger_sales_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getSummary() {
        $this->db->select("
            mhsd.id,
            mhsd.summary_month,
			mhsd.from_date,
			mhsd.to_date,
            CONCAT(mhsd.from_date, ' -> ', mhsd.to_date) AS From_To,
            mhsd.status,
            mhsd.created_at,
            (
                SELECT COUNT(*) 
                FROM maha_hunger_sales_summary mhss 
                WHERE mhss.main_id  = mhsd.id
            ) AS Total_Employees,
            (
                SELECT SUM(mhss.completed_orders) 
                FROM maha_hunger_sales_summary mhss 
                WHERE mhss.main_id  = mhsd.id
            ) AS Completed_Orders,
            (
                SELECT SUM(mhss.basic_payment) 
                FROM maha_hunger_sales_summary mhss 
                WHERE mhss.main_id  = mhsd.id
            ) AS Total_Basic_Payment,
			(
                SELECT SUM(mhss.monthly_balance) 
                FROM maha_hunger_sales_summary mhss 
                WHERE mhss.main_id  = mhsd.id
            ) AS Total_Monthly_Balance
        ");
        $this->db->from('maha_hunger_sales_data mhsd');
        $this->db->order_by('mhsd.summary_month', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array(); // Return as an array of results
    }

	function delete($ids){
		foreach ($ids as $id) {
			// Delete from maha_hunger_sales_data
			$this->db->where('id', $id);
			$this->db->delete('maha_hunger_sales_data');

			// Delete related records from maha_hunger_sales_summary first
			$this->db->where('main_id', $id);
			$this->db->delete('maha_hunger_sales_summary');
		}
		return true;
	}	

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_hunger_sales_summary');
		return $query->row();
	}

	/*----- List Info -----*/
	
	function get_detail($id){
		$query = $this->db->query("SELECT maha_hunger_sales_data.* FROM maha_hunger_sales_data WHERE maha_hunger_sales_data.id = '" . (int)$id . "'");
		return $query->row_array();
	}

	public function summaryDetail($main_id, $search = '', $perPage = 50, $page = 1)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'hunger_sales_data'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mhss.id', 'mhss.emp_id', 'me.emp_no', 'me.full_name', 'mhss.rider_id', 
				'mhss.contract_name', 'mhss.completed_orders', 'mhss.basic_payment',
				'mhss.acceptance_rate_penalties', 'mhss.contact_rate_penalties', 'mhss.stacking_deduction', 'mhss.declined_penalties_day_logic',
				'mhss.google_capped_after', 'mhss.rider_scoring', 'mhss.rider_basic',
				'mhss.monthly_balance', 'mhss.created_at', 'mhss.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mhss.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mhss.' . $col);
			}, $selectedColumns);
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_hunger_sales_summary mhss');
		$this->db->join('master_employee me', 'mhss.emp_id = me.id', 'left');
		$this->db->where('mhss.main_id', $main_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('me.full_name', $search);
			$this->db->group_end();
		}

		// ✅ Apply ORDER BY if completed_orders is selected
		if (in_array('mhss.completed_orders', $selectedColumns)) {
			$this->db->order_by('mhss.completed_orders', 'DESC');
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();

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
		$this->db->from('maha_hunger_sales_summary mhss');
		$this->db->join('master_employee me', 'mhss.emp_id = me.id', 'left');
		$this->db->where('mhss.main_id', $main_id);

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
		$this->db->from('maha_hunger_sales_data');
		$this->db->where('summary_month', $summary_month);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function printSalesReport($main_id, $search, $column_type, $file_format)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(), 
			'module_name' => 'hunger_sales_data'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			// Default columns if no preferences saved
			$selectedColumns = [
				'mhss.id', 'mhss.emp_id', 'me.emp_no', 'me.full_name', 'mhss.rider_id', 
				'mhss.contract_name', 'mhss.completed_orders', 'mhss.basic_payment',
				'mhss.acceptance_rate_penalties', 'mhss.contact_rate_penalties', 'mhss.stacking_deduction', 'mhss.declined_penalties_day_logic',
				'mhss.google_capped_after', 'mhss.rider_scoring', 'mhss.rider_basic',
				'mhss.monthly_balance', 'mhss.created_at', 'mhss.updated_at'
			];
		} else {
			// Add table prefixes
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mhss.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mhss.' . $col);
			}, $selectedColumns);
		}

		// ✅ Check if grouping by emp_no is needed
		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		// ✅ Define which columns should be summed
		$sumColumns = [
			'mhss.completed_orders', 'mhss.basic_payment',
			'mhss.acceptance_rate_penalties', 'mhss.contact_rate_penalties', 'mhss.stacking_deduction', 'mhss.declined_penalties_day_logic',
			'mhss.google_capped_after', 'mhss.rider_scoring', 'mhss.rider_basic',
			'mhss.monthly_balance'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				// ✅ Fix: Remove `mhss.` prefix from alias in SUM() columns
				$alias = str_replace('mhss.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $finalColumns));
		$this->db->from('maha_hunger_sales_summary mhss');
		$this->db->join('master_employee me', 'mhss.emp_id = me.id', 'left');
		$this->db->where('mhss.main_id', $main_id);

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

		// ✅ Apply ORDER BY if completed_orders is selected
		if (in_array('mhss.completed_orders', $selectedColumns)) {
			$this->db->order_by('mhss.completed_orders', 'DESC');
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

}

