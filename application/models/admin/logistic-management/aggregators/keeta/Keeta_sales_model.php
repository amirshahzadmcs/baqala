<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Keeta_sales_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getSummary() {
        $this->db->select("
            mksd.id,
            mksd.summary_month,
			mksd.from_date,
			mksd.to_date,
            CONCAT(mksd.from_date, ' -> ', mksd.to_date) AS From_To,
            mksd.status,
            mksd.created_at,
            (
                SELECT COUNT(*) 
                FROM maha_keeta_sales_summary mkss 
                WHERE mkss.main_id  = mksd.id
            ) AS Total_Employees,
            (
                SELECT SUM(mkss.delivered_orders) 
                FROM maha_keeta_sales_summary mkss 
                WHERE mkss.main_id  = mksd.id
            ) AS Delivered_Orders,
            (
                SELECT SUM(mkss.order_based_pricing) 
                FROM maha_keeta_sales_summary mkss 
                WHERE mkss.main_id  = mksd.id
            ) AS Order_Based_Pricing,
			(
                SELECT SUM(mkss.total_payable_amount) 
                FROM maha_keeta_sales_summary mkss 
                WHERE mkss.main_id  = mksd.id
            ) AS Total_Payble_Amount
        ");
        $this->db->from('maha_keeta_sales_data mksd');
        $this->db->order_by('mksd.summary_month', 'ASC');
        
        $query = $this->db->get();
        return $query->result_array(); // Return as an array of results
    }

	function delete($ids){
		foreach ($ids as $id) {
			// Delete from maha_hunger_sales_data
			$this->db->where('id', $id);
			$this->db->delete('maha_keeta_sales_data');

			// Delete related records from maha_hunger_sales_summary first
			$this->db->where('main_id', $id);
			$this->db->delete('maha_keeta_sales_summary');
		}
		return true;
	}	

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_keeta_sales_summary');
		return $query->row();
	}

	/*----- List Info -----*/
	
	function get_detail($id){
		$query = $this->db->query("SELECT maha_keeta_sales_data.* FROM maha_keeta_sales_data WHERE maha_keeta_sales_data.id = '" . (int)$id . "'");
		return $query->row_array();
	}

	public function summaryDetail($main_id, $search = '', $perPage = 50, $page = 1)
	{
		if (empty($main_id)) {
			return null;
		}

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', ['user_id' => $this->admin->getLoginEmpId(), 'module_name' => 'keeta_sales_data'])->row();
		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			// Fallback if no preferences are saved
			$selectedColumns = [
				'mkss.id', 'mkss.main_id', 'mkss.emp_id', 'me.emp_no', 'me.full_name', 'mkss.partner_id', 'mkss.partner_name', 'mkss.billing_cycle', 'mkss.courier_id', 'mkss.courier_name', 'mkss.is_valid', 'mkss.reason', 'mkss.online_days_valid', 'mkss.daily_online_hours_valid', 'mkss.daily_online_hours_peak_valid', 'mkss.delivered_orders', 'mkss.order_based_pricing', 'mkss.valid_da_capacity_incentives', 'mkss.on_time_incentives', 'mkss.subsidy', 'mkss.activities_rewards', 'mkss.deduction', 'mkss.food_compensation', 'mkss.other_adjustment', 'mkss.tips_vat_excluded', 'mkss.tga_deduction_vat_excluded', 'mkss.total_payable_amount', 'mkss.created_at', 'mkss.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mkss.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mkss.' . $col);
			}, $selectedColumns);
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('maha_keeta_sales_summary mkss');
		$this->db->join('master_employee me', 'mkss.emp_id = me.id', 'left');
		$this->db->where('mkss.main_id', $main_id);

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('me.full_name', $search);
			$this->db->group_end();
		}

		// ✅ Apply ORDER BY if completed_orders is selected
		if (in_array('mkss.completed_orders', $selectedColumns)) {
			$this->db->order_by('mkss.completed_orders', 'DESC');
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
		$this->db->from('maha_keeta_sales_summary mkss');
		$this->db->join('master_employee me', 'mkss.emp_id = me.id', 'left');
		$this->db->where('mkss.main_id', $main_id);

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
		$this->db->from('maha_keeta_sales_data');
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
			'module_name' => 'keeta_sales_data'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			// Default columns if no preferences saved
			$selectedColumns = [
				'mkss.id', 'mkss.main_id', 'mkss.emp_id', 'me.emp_no', 'me.full_name', 'mkss.partner_id', 'mkss.partner_name', 'mkss.billing_cycle', 'mkss.courier_id', 'mkss.courier_name', 'mkss.is_valid', 'mkss.reason', 'mkss.online_days_valid', 'mkss.daily_online_hours_valid', 'mkss.daily_online_hours_peak_valid', 'mkss.delivered_orders', 'mkss.order_based_pricing', 'mkss.valid_da_capacity_incentives', 'mkss.on_time_incentives', 'mkss.subsidy', 'mkss.activities_rewards', 'mkss.deduction', 'mkss.food_compensation', 'mkss.other_adjustment', 'mkss.tips_vat_excluded', 'mkss.tga_deduction_vat_excluded', 'mkss.total_payable_amount', 'mkss.created_at', 'mkss.updated_at'
			];
		} else {
			// Add table prefixes
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'mkss.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'mkss.' . $col);
			}, $selectedColumns);
		}

		// ✅ Check if grouping by emp_no is needed
		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		// ✅ Define which columns should be summed
		$sumColumns = [
			'mkss.online_days_valid', 'mkss.daily_online_hours_valid', 'mkss.daily_online_hours_peak_valid', 'mkss.delivered_orders', 'mkss.order_based_pricing', 'mkss.valid_da_capacity_incentives', 'mkss.on_time_incentives', 'mkss.subsidy', 'mkss.activities_rewards', 'mkss.deduction', 'mkss.food_compensation', 'mkss.other_adjustment', 'mkss.tips_vat_excluded', 'mkss.tga_deduction_vat_excluded', 'mkss.total_payable_amount'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				// ✅ Fix: Remove `mhss.` prefix from alias in SUM() columns
				$alias = str_replace('mkss.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $finalColumns));
		$this->db->from('maha_keeta_sales_summary mkss');
		$this->db->join('master_employee me', 'mkss.emp_id = me.id', 'left');
		$this->db->where('mkss.main_id', $main_id);

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
		if (in_array('mkss.completed_orders', $selectedColumns)) {
			$this->db->order_by('mkss.completed_orders', 'DESC');
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

