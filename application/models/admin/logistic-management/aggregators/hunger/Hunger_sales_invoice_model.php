<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Hunger_sales_invoice_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	function delete($ids){
		foreach ($ids as $id) {
			// Delete from maha_hunger_sales_invoice
			$this->db->where('id', $id);
			$this->db->delete('maha_hunger_sales_invoice');
		}
		return true;
	}

	/*----- List Info -----*/

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_hunger_sales_invoice');
		return $query->row();
	}

	public function salesList($search, $perPage, $start)
	{
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'hunger_sales_invoice'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			$selectedColumns = [
				'id', 'invoice_month', 'from_date', 'to_date', 'contract_name', 'vat_no', 'iban_no', 
				'completed_orders', 'basic_payment', 'acceptance_rate_penalties', 'contact_rate_penalties', 
				'stacking_deduction', 'declined_penalties_day_logic', 'google_capped_after', 
				'amount_exlc_vat_before_bonus', '3pl_bonus', 'amount_exlc_vat_with_bonus', 'vat', 
				'amount_incl_vat', 'rider_scoring', 'rider_basic', 'monthly_balance', 'total_deduction', 
				'net_ftr', 'added_by', 'created_at', 'updated_at'
			];
		}

		if (!is_array($visibleColumns) || empty($visibleColumns)) {
			$visibleColumns = $selectedColumns;
		}

		$columnsToShow = array_values(array_intersect($visibleColumns, $selectedColumns));

		$this->db->select(implode(', ', $columnsToShow));
		$this->db->from('maha_hunger_sales_invoice');

		if (!empty($search)) {
			$this->db->group_start();
			foreach ($columnsToShow as $column) {
				$this->db->or_like($column, $search);
			}
			$this->db->group_end();
		}

		if (in_array('invoice_month', $columnsToShow)) {
			$this->db->order_by('invoice_month', 'DESC');
		} else {
			$this->db->order_by('id', 'DESC');
		}

		$totalRowsQuery = clone $this->db;
		$totalRowsCount = $totalRowsQuery->count_all_results();

		$this->db->limit($perPage, $start);

		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $columnsToShow,
			'pagination' => [
				'total' => $totalRowsCount,
				'per_page' => $perPage,
				'current_page' => $start,
			]
		];
	}

	public function summaryDetailCount($main_id, $search = '')
	{
		$this->db->from('maha_hunger_sales_invoice');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('contract_name', $search);
			$this->db->or_like('vat_no', $search);
			$this->db->group_end();
		}

		return $this->db->count_all_results();
	}


	/*----- List Info End -----*/

	public function checkDuplicateInBulk($summary_month) {
		if (empty($summary_month)) {
			return [];
		}
		$this->db->select('invoice_month');
		$this->db->from('maha_hunger_sales_invoice');
		$this->db->where('invoice_month', $summary_month);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function printSalesReport($column_type, $file_format, $search = '')
	{
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'hunger_sales_invoice'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			$selectedColumns = [
				'id', 'invoice_month', 'from_date', 'to_date', 'contract_name', 'vat_no', 'iban_no', 
				'completed_orders', 'basic_payment', 'acceptance_rate_penalties', 'contact_rate_penalties', 
				'stacking_deduction', 'declined_penalties_day_logic', 'google_capped_after', 
				'amount_exlc_vat_before_bonus', '3pl_bonus', 'amount_exlc_vat_with_bonus', 'vat', 
				'amount_incl_vat', 'rider_scoring', 'rider_basic', 'monthly_balance', 'total_deduction', 
				'net_ftr', 'added_by', 'created_at', 'updated_at'
			];
		}else{
			$selectedColumns = $visibleColumns;
		}

		$columnsToShow = $selectedColumns;
		// ✅ Query for total row count
		$this->db->from('maha_hunger_sales_invoice');
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($columnsToShow as $column) {
				$this->db->or_like($column, $search);
			}
			$this->db->group_end();
		}
		$totalRowsCount = $this->db->count_all_results();

		// ✅ Query for fetching data
		$this->db->select(implode(', ', $columnsToShow));
		$this->db->from('maha_hunger_sales_invoice');
		if (!empty($search)) {
			$this->db->group_start();
			foreach ($columnsToShow as $column) {
				$this->db->or_like($column, $search);
			}
			$this->db->group_end();
		}

		// ✅ Order by `invoice_month`, fallback to `id`
		if (in_array('invoice_month', $columnsToShow)) {
			$this->db->order_by('invoice_month', 'DESC');
		}
		if (in_array('id', $columnsToShow)) {
			$this->db->order_by('id', 'DESC');
		}

		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $columnsToShow,
			'total_rows' => $totalRowsCount,
		];
	}


}

