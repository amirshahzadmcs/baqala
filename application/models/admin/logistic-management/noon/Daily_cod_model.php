<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Daily_cod_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	function delete($ids){
		foreach ($ids as $id) {
			$this->db->where('id', $id);
			$this->db->delete('noon_cod_summary');
		}
		return true;
	}

	/*----- List Info -----*/

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('noon_cod_summary');
		return $query->row();
	}

	public function list($search = '', $perPage = 50, $start = 0, $date_from = null, $date_to = null)
	{
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'noon_cod_summary'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			$selectedColumns = [
				'noon.id', 'noon.ops_date', 'noon.emp_id', 'me.emp_no', 'me.full_name', 'noon.id_user', 'noon.user_type', 'noon.vendor_code', 'noon.vendor_name', 'noon.order_cash_collected', 'noon.cash_deposited', 'noon.balance_total', 'noon.final_balance_closing', 'noon.created_at', 'noon.updated_at'
			];
		} else {
			// Add table prefixes to selected columns
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'noon.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'noon.' . $col);
			}, $selectedColumns);
		}	

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('noon_cod_summary noon');
		$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $column) {
				$this->db->or_like($column, $sanitizedSearch);
			}
			$this->db->group_end();
		}

		if (!empty($date_from)) {
			$this->db->where('noon.ops_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('noon.ops_date <=', date('Y-m-d', strtotime($date_to)));
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRowsCount = $totalRowsQuery->get()->num_rows();
		/*
		if (in_array('noon.delivered_orders', $selectedColumns)) {
			$this->db->order_by('noon.delivered_orders', 'DESC');
		}
		*/
		if (in_array('noon.ops_date', $selectedColumns)) {
			$this->db->order_by('noon.ops_date', 'DESC');
		}else{
			$this->db->order_by('noon.id', 'DESC');
		}
		
		// ✅ Offset Calculation
		$offset = max(0, $start);
    	$this->db->limit($perPage, $offset);
		$result = $this->db->get()->result_array();

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'pagination' => [
				'total' => $totalRowsCount,
				'per_page' => $perPage,
				'current_page' => ($start / $perPage) + 1
			]
		];
	}

	public function summaryDetailCount($main_id, $search = '')
	{
		$this->db->from('noon_cod_summary');

		if (!empty($search)) {
			$this->db->group_start();
			$this->db->like('vendor_name', $search);
			$this->db->or_like('id_user', $search);
			$this->db->group_end();
		}
		return $this->db->count_all_results();
	}


	/*----- List Info End -----*/

	public function checkDuplicateInBulk($data) {
		// Check if necessary keys are present in the $data array
		if (!isset($data['rider_id']) || !isset($data['date_local'])) {
			throw new InvalidArgumentException("Missing necessary keys in data array.");
		}
	
		// Query the database to check for duplicates based on rider_id and date
		$this->db->where('id_user', $data['rider_id']);
		$this->db->where('ops_date', date('Y-m-d', strtotime($data['date_local'])));
		$query = $this->db->get('noon_cod_summary');
	
		// If a row is returned, it means the data already exists and is a duplicate
		if ($query->num_rows() > 0) {
			return true;
		}
	
		return false;
	}

	public function printPerformanceReport($search, $column_type, $file_format, $date_from, $date_to)
	{
		// ✅ Master list of all possible columns
		$allColumns = [
			'noon.id', 'noon.ops_date', 'noon.emp_id', 'me.emp_no', 'me.full_name',
			'noon.id_user', 'noon.user_type', 'noon.vendor_code', 'noon.vendor_name',
			'noon.order_cash_collected', 'noon.cash_deposited', 'noon.balance_total',
			'noon.final_balance_closing', 'noon.created_at', 'noon.updated_at'
		];

		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'noon_cod_summary'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		// ✅ If "all columns" option is selected, override preferences
		if ($column_type === 'all_columns' || empty($selectedColumns)) {
			$selectedColumns = $allColumns;
			$visibleColumns = $allColumns; // show all in view
		} else {
			// Prefix columns
			$selectedColumns = array_map(function ($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'noon.') === 0)
					? $col
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'noon.' . $col);
			}, $selectedColumns);
		}

		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		$sumColumns = [
			'noon.order_cash_collected', 'noon.cash_deposited', 'noon.balance_total', 'noon.final_balance_closing'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				$alias = str_replace('noon.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('noon_cod_summary noon');
		$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $column) {
				$this->db->or_like($column, $sanitizedSearch);
			}
			$this->db->group_end();
		}

		if (!empty($date_from)) {
			$this->db->where('noon.ops_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('noon.ops_date <=', date('Y-m-d', strtotime($date_to)));
		}

		if (in_array('noon.ops_date', $selectedColumns)) {
			$this->db->order_by('noon.ops_date', 'DESC');
		} else {
			$this->db->order_by('noon.id', 'DESC');
		}

		$this->db->order_by('noon.final_balance_closing', 'DESC');

		$result = $this->db->get()->result_array();
		$totalRows = count($result);

		// ✅ Grand Totals (optional if grouped)
		$totals = [];
		if ($isGroupedByRider) {
			$this->db->select(implode(', ', array_map(function ($column) {
				return "SUM($column) AS " . str_replace('noon.', '', $column);
			}, $sumColumns)));
			$this->db->from('noon_cod_summary noon');
			$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

			if (!empty($search)) {
				$sanitizedSearch = preg_replace('/\s+/', '', $search);
				$this->db->group_start();
				foreach ($selectedColumns as $column) {
					$this->db->or_like($column, $sanitizedSearch);
				}
				$this->db->group_end();
			}

			if (!empty($date_from)) {
				$this->db->where('noon.ops_date >=', date('Y-m-d', strtotime($date_from)));
			}
			if (!empty($date_to)) {
				$this->db->where('noon.ops_date <=', date('Y-m-d', strtotime($date_to)));
			}

			$totals = $this->db->get()->row_array();
		}

		// Strip table prefixes for display and access in view
		$cleanColumnName = function ($col) {
			return str_replace(['noon.', 'me.'], '', $col);
		};

		return [
			'data' => array_map(function($row) use ($cleanColumnName, $selectedColumns) {
				$cleaned = [];
				foreach ($selectedColumns as $col) {
					$cleaned[$cleanColumnName($col)] = $row[$cleanColumnName($col)] ?? $row[$col] ?? '';
				}
				return $cleaned;
			}, $result),
			'available_columns' => array_map($cleanColumnName, $selectedColumns),
			'visible_columns' => array_map($cleanColumnName, $visibleColumns),
			'total_rows' => $totalRows,
			'totals' => array_combine(
				array_map($cleanColumnName, array_keys($totals)),
				array_values($totals)
			)
		];
	}

	//Print Raw Data
	public function printRawReport($search)
	{
		$selectedColumns = [
			'noon.id', 'noon.ops_date', 'noon.emp_id', 'me.emp_no', 'me.full_name', 'noon.id_user', 'noon.user_type', 'noon.vendor_code', 'noon.vendor_name', 'noon.order_cash_collected', 'noon.cash_deposited', 'noon.balance_total', 'noon.final_balance_closing', 'noon.created_at', 'noon.updated_at'
		];

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('noon_cod_summary noon');
		$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search); // Remove spaces
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('REPLACE(me.full_name, " ", "")', $sanitizedSearch);
			$this->db->group_end();
		}
		
		$this->db->order_by('noon.final_balance_closing', 'DESC');

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

