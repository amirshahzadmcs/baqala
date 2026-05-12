<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Jahez_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getSummary() {
		$this->db->select("
			mjm.id,
			mjm.summary_month,
			mjm.from_date,
			mjm.to_date,
			CONCAT(mjm.from_date, ' -> ', mjm.to_date) AS From_To,
			mjm.status,
			mjm.created_at,
			(
				SELECT COUNT(DISTINCT mjms.driver_id) 
				FROM maha_jahez_monthly_summary mjms 
				WHERE mjms.main_id = mjm.id
			) AS Total_Employees,
			(
				SELECT SUM(mjms.price) 
				FROM maha_jahez_monthly_summary mjms 
				WHERE mjms.main_id = mjm.id
			) AS Total_Price
		");
		$this->db->from('maha_jahez_monthly mjm');
		$this->db->order_by('mjm.summary_month', 'ASC');
	
		$query = $this->db->get();
		return $query->result_array();
	}

	function delete($ids){
		foreach ($ids as $id) {
			// Delete from maha_jahez_monthly
			$this->db->where('id', $id);
			$this->db->delete('maha_jahez_monthly');

			// Delete related records from maha_jahez_monthly_summary first
			$this->db->where('main_id', $id);
			$this->db->delete('maha_jahez_monthly_summary');
		}
		return true;
	}

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_jahez_monthly_summary');
		return $query->row();
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "
		SELECT 
		mjms.*, me.emp_no, me.full_name, me.mobile 
		FROM maha_jahez_monthly_summary mjms 
		LEFT JOIN master_employee me ON (mjms.emp_id = me.id) WHERE 1=1";
		return $a;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT maha_jahez_monthly.* FROM maha_jahez_monthly WHERE maha_jahez_monthly.id = '" . (int)$id . "'");
		return $query->row_array();
	}

	public function summaryDetail($main_id, $search = '', $perPage = 50, $page = 1)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'jahez_monthly_summary'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mjms.id', 'mjms.did', 'mjms.ref_id', 'mjms.emp_id', 'me.emp_no', 'me.full_name', 'mjms.driver_name', 'mjms.driver_username', 'mjms.driver_id', 'mjms.amount', 'mjms.price', 'mjms.driver_debit_amount', 'mjms.driver_credit_amount', 'mjms.is_free_order', 'mjms.dispatch_time', 'mjms.subscriber', 'mjms.driver_paid_org', 'mjms.org_settled', 'mjms.driver_settled', 'mjms.created_at', 'mjms.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mjms.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mjms.' . $col);
			}, $selectedColumns);
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_jahez_monthly_summary mjms');
		$this->db->join('master_employee me', 'mjms.emp_id = me.id', 'left');
		$this->db->where('mjms.main_id', $main_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('me.full_name', $search);
			$this->db->group_end();
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();
		if (in_array('mjms.dispatch_time', $selectedColumns)) {
			$this->db->order_by('mjms.dispatch_time', 'DESC');
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
		$this->db->from('maha_jahez_monthly_summary mjms');
		$this->db->join('master_employee me', 'mjms.emp_id = me.id', 'left');
		$this->db->where('mjms.main_id', $main_id);

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
		$this->db->from('maha_jahez_monthly');
		$this->db->where('summary_month', $summary_month);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function printPerformanceReport($main_id, $search, $column_type, $file_format, $limit = 1000, $offset = 0)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'jahez_monthly_summary'
		])->row();

		$selectedColumns = !empty($userPreferences) ? json_decode($userPreferences->available_columns ?? '[]', true) : [];
		$visibleColumns = !empty($userPreferences) ? json_decode($userPreferences->visible_columns ?? '[]', true) : [];

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			$selectedColumns = [
				'mjms.id', 'mjms.did', 'mjms.ref_id', 'mjms.emp_id', 'me.emp_no', 'me.full_name',
				'mjms.driver_name', 'mjms.driver_username', 'mjms.driver_id', 'mjms.amount', 'mjms.price',
				'mjms.driver_debit_amount', 'mjms.driver_credit_amount', 'mjms.is_free_order',
				'mjms.dispatch_time', 'mjms.subscriber', 'mjms.driver_paid_org', 'mjms.org_settled',
				'mjms.driver_settled', 'mjms.created_at', 'mjms.updated_at'
			];
		} else {
			$selectedColumns = array_map(function ($col) {
				return in_array($col, ['emp_no', 'full_name']) ? "me.$col" : "mjms.$col";
			}, $selectedColumns);
		}

		// ✅ Fields to SUM when grouped
		$sumColumns = [
			'mjms.amount',
			'mjms.price',
			'mjms.driver_debit_amount',
			'mjms.driver_credit_amount',
			'mjms.driver_paid_org',
			'mjms.org_settled',
			'mjms.driver_settled',
		];

		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				$alias = str_replace(['mjms.', 'me.'], '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		// ✅ Add emp_no if missing
		if ($isGroupedByRider && !in_array('me.emp_no', $finalColumns)) {
			$finalColumns[] = 'me.emp_no';
		}

		// ✅ Add order count per rider
		if ($isGroupedByRider) {
			$finalColumns[] = 'COUNT(mjms.id) AS order_count';
		}

		// ✅ Build the query
		$this->db->select(implode(', ', $finalColumns));
		$this->db->from('maha_jahez_monthly_summary AS mjms');
		$this->db->join('master_employee AS me', 'mjms.emp_id = me.id', 'left');
		$this->db->where('mjms.main_id', $main_id);

		// ✅ Search
		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('REPLACE(me.full_name, " ", "")', $sanitizedSearch);
			$this->db->group_end();
		}

		// ✅ Grouping
		if ($isGroupedByRider) {
			$this->db->group_by('me.emp_no');
		}

		// ✅ Order by dispatch_time if selected
		if (in_array('mjms.dispatch_time', $selectedColumns)) {
			$this->db->order_by('mjms.dispatch_time', 'DESC');
		}

		// ✅ Pagination
		$this->db->limit($limit, $offset);

		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
		];
	}

	public function countTotalRecords($main_id)
	{
		if (empty($main_id)) {
			return 0; // Return 0 if no ID is provided
		}

		return $this->db->from('maha_jahez_monthly_summary')
						->where('main_id', $main_id)
						->count_all_results(); // ✅ Counts total rows
	}

}

