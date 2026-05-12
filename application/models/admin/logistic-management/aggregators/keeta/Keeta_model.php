<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Keeta_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getSummary() {
		$this->db->select("
			mkm.id,
			mkm.summary_month,
			mkm.from_date,
			mkm.to_date,
			CONCAT(mkm.from_date, ' -> ', mkm.to_date) AS From_To,
			mkm.status,
			mkm.created_at,
			(
				SELECT COUNT(DISTINCT mkms.emp_id) 
				FROM maha_keeta_monthly_summary mkms 
				WHERE mkms.main_id = mkm.id
			) AS Total_Employees,
			(
				SELECT SUM(mkms.total_payable_amount) 
				FROM maha_keeta_monthly_summary mkms 
				WHERE mkms.main_id = mkm.id
			) AS Total_Payble_Amount
		");
		$this->db->from('maha_keeta_monthly mkm');
		$this->db->order_by('mkm.summary_month', 'ASC');
	
		$query = $this->db->get();
		return $query->result_array();
	}	

	function delete($ids){
		foreach ($ids as $id) {
			// Delete from maha_keeta_monthly
			$this->db->where('id', $id);
			$this->db->delete('maha_keeta_monthly');

			// Delete related records from maha_keeta_monthly_summary first
			$this->db->where('main_id', $id);
			$this->db->delete('maha_keeta_monthly_summary');
		}
		return true;
	}

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_keeta_monthly_summary');
		return $query->row();
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "
		SELECT 
		mhm.*, me.emp_no, me.full_name, me.mobile 
		FROM maha_keeta_monthly_summary mkms 
		LEFT JOIN master_employee me ON (mkms.emp_id = me.id) WHERE 1=1";
		return $a;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT maha_keeta_monthly.* FROM maha_keeta_monthly WHERE maha_keeta_monthly.id = '" . (int)$id . "'");
		return $query->row_array();
	}

	public function summaryDetail($main_id, $search = '', $perPage = 50, $page = 1)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'keeta_monthly_summary'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mkms.id', 'mkms.main_id', 'mkms.emp_id', 'me.emp_no', 'me.full_name', 'mkms.partner_id', 'mkms.partner_name', 'mkms.billing_cycle', 'mkms.courier_id', 'mkms.courier_name', 'mkms.transaction_type', 'mkms.business_id', 'mkms.note', 'mkms.detail_amount', 'mkms.total_payable_amount', 'mkms.ticket_id', 'mkms.violation_id', 'mkms.violation_type', 'mkms.punishment_methods', 'mkms.created_at', 'mkms.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mkms.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mkms.' . $col);
			}, $selectedColumns);
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_keeta_monthly_summary mkms');
		$this->db->join('master_employee me', 'mkms.emp_id = me.id', 'left');
		$this->db->where('mkms.main_id', $main_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('me.full_name', $search);
			$this->db->group_end();
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();
		if (in_array('mkms.total_payable_amount', $selectedColumns)) {
			$this->db->order_by('mkms.total_payable_amount', 'DESC');
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
		$this->db->from('maha_keeta_monthly_summary mkms');
		$this->db->join('master_employee me', 'mkms.emp_id = me.id', 'left');
		$this->db->where('mkms.main_id', $main_id);

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
		$this->db->from('maha_keeta_monthly');
		$this->db->where('summary_month', $summary_month);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function printPerformanceReport($main_id, $search, $column_type, $file_format)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'keeta_monthly_summary'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mkms.id', 'mkms.main_id', 'mkms.emp_id', 'me.emp_no', 'me.full_name', 'mkms.partner_id', 'mkms.partner_name', 'mkms.billing_cycle', 'mkms.courier_id', 'mkms.courier_name', 'mkms.transaction_type', 'mkms.business_id', 'mkms.note', 'mkms.detail_amount', 'mkms.total_payable_amount', 'mkms.ticket_id', 'mkms.violation_id', 'mkms.violation_type', 'mkms.punishment_methods', 'mkms.created_at', 'mkms.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mkms.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mkms.' . $col);
			}, $selectedColumns);
		}

		// ✅ Check if grouping by emp_no is needed
		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		// ✅ Define which columns should be summed
		$sumColumns = [
			'mkms.total_payable_amount'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				// ✅ Fix: Remove `mkms.` prefix from alias in SUM() columns
				$alias = str_replace('mkms.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $finalColumns));
		$this->db->from('maha_keeta_monthly_summary mkms');
		$this->db->join('master_employee me', 'mkms.emp_id = me.id', 'left');
		$this->db->where('mkms.main_id', $main_id);

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
		if (in_array('mkms.total_payable_amount', $selectedColumns)) {
			$this->db->order_by('mkms.total_payable_amount', 'DESC');
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

