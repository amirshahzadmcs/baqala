<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Daily_penelty_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	function delete($ids){
		foreach ($ids as $id) {
			$this->db->where('id', $id);
			$this->db->delete('noon_daily_penelty');
		}
		return true;
	}

	/*----- List Info -----*/

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('noon_daily_penelty');
		return $query->row();
	}

	public function list($search = '', $perPage = 50, $start = 0, $date_from = null, $date_to = null)
	{
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'noon_daily_penelty'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns)) {
			$selectedColumns = [
				'noon.id', 'noon.emp_id', 'me.emp_no', 'me.full_name', 'noon.penelty_date', 'noon.vendor_name', 'noon.date', 'noon.city', 'noon.default_fleet', 'noon.da_id', 'noon.payout_type', 'noon.delivered', 'noon.total_rejections', 'noon.rejection_penalty', 'noon.order_number', 'noon.created_at', 'noon.updated_at'
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
		$this->db->from('noon_daily_penelty noon');
		$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $column) {
				$this->db->or_like($column, $sanitizedSearch);
			}
			$this->db->group_end();
		}

		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRowsCount = $totalRowsQuery->get()->num_rows();
		if (!empty($date_from)) {
			$this->db->where('noon.penelty_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('noon.penelty_date <=', date('Y-m-d', strtotime($date_to)));
		}
		// ✅ Only apply order_by if penelty_date is selected
		if (in_array('noon.penelty_date', $selectedColumns)) {
			$this->db->order_by('noon.penelty_date', 'DESC');
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
				'current_page' => $start,
			]
		];
	}

	public function summaryDetailCount($search = '')
	{
		$this->db->from('noon_daily_penelty');

		// Define the columns you want to search in
		$selectedColumns = [
			'vendor_name',
			'date',
			'city',
			'default_fleet',
			'da_id',
			'payout_type',
			'delivered',
			'total_rejections',
			'rejection_penalty',
			'order_number'
		];

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $column) {
				$this->db->or_like("REPLACE($column, ' ', '')", $sanitizedSearch, false);
			}
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
		$this->db->where('da_id', $data['rider_id']);
		$this->db->where('penelty_date', date('Y-m-d', strtotime($data['date_local'])));
		$query = $this->db->get('noon_daily_penelty');
	
		// If a row is returned, it means the data already exists and is a duplicate
		if ($query->num_rows() > 0) {
			return true;
		}
	
		return false;
	}

	public function printPerformanceReport($search, $column_type, $file_format, $date_from, $date_to)
	{
		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(), 
			'module_name' => 'noon_daily_penelty'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			// Default columns if no preferences saved
			$selectedColumns = [
				'noon.id', 'noon.emp_id', 'me.emp_no', 'me.full_name', 'noon.penelty_date', 'noon.vendor_name', 'noon.date', 'noon.city', 'noon.default_fleet', 'noon.da_id', 'noon.payout_type', 'noon.delivered', 'noon.total_rejections', 'noon.rejection_penalty', 'noon.order_number', 'noon.created_at', 'noon.updated_at'
			];
		} else {
			// Add table prefixes
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'noon.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'noon.' . $col);
			}, $selectedColumns);
		}

		// ✅ Check if grouping by emp_no is needed
		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		// ✅ Define which columns should be summed
		$sumColumns = [
			'noon.delivered', 'noon.total_rejections', 'noon.rejection_penalty'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				// ✅ Fix: Remove `mhms.` prefix from alias in SUM() columns
				$alias = str_replace('noon.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('noon_daily_penelty noon');
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
			$this->db->where('noon.penelty_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('noon.penelty_date <=', date('Y-m-d', strtotime($date_to)));
		}
		/*
		if ($isGroupedByRider) {
			$this->db->group_by('me.emp_no');
		}
		*/
		// ✅ Apply ORDER BY emp_no if available
		/*
		if ($isGroupedByRider && in_array('noon.delivered', $selectedColumns)) {
			$this->db->order_by('delivered', 'DESC');
		} elseif (in_array('noon.delivered', $selectedColumns)) {
			$this->db->order_by('noon.delivered', 'DESC');
		}*/
		if (in_array('noon.penelty_date', $selectedColumns)) {
			$this->db->order_by('noon.penelty_date', 'DESC');
		}else{
			$this->db->order_by('noon.penelty_date', 'DESC');
		}	
		$this->db->order_by('noon.delivered', 'DESC');
		// ✅ Clone query for counting total rows
		$totalRowsQuery = clone $this->db;
		$totalRows = $totalRowsQuery->get()->num_rows();

		$result = $this->db->get()->result_array();

		// ✅ Clone and run query for total count
		$totalRows = count($result);

		// ✅ Grand totals (if grouped)
		$totals = [];
		if ($isGroupedByRider) {
			$this->db->select(implode(', ', array_map(function ($column) {
				return "SUM($column) AS " . str_replace('noon.', '', $column);
			}, $sumColumns)));
			$this->db->from('noon_daily_penelty noon');
			$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

			if (!empty($search)) {
				$sanitizedSearch = preg_replace('/\s+/', '', $search);
				$this->db->group_start();
				foreach ($selectedColumns as $column) {
					$this->db->or_like($column, $sanitizedSearch);
				}
				$this->db->group_end();
			}

			$totals = $this->db->get()->row_array();
		}

		return [
			'data' => $result,
			'available_columns' => $selectedColumns,
			'visible_columns' => $visibleColumns,
			'total_rows' => $totalRows,
			'totals' => $totals
		];
	}

	//Print Raw Data
	public function printRawReport($search)
	{
		$selectedColumns = [
			'noon.id', 'noon.emp_id', 'me.emp_no', 'me.full_name', 'noon.penelty_date', 'noon.vendor_name', 'noon.date', 'noon.city', 'noon.default_fleet', 'noon.da_id', 'noon.payout_type', 'noon.delivered', 'noon.total_rejections', 'noon.rejection_penalty', 'noon.order_number', 'noon.created_at', 'noon.updated_at'
		];

		$this->db->select(implode(', ', $selectedColumns));
		$this->db->from('noon_daily_penelty noon');
		$this->db->join('master_employee me', 'noon.emp_id = me.id', 'left');

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search); // Remove spaces
			$this->db->group_start();
			$this->db->like('me.emp_no', $search);
			$this->db->or_like('REPLACE(me.full_name, " ", "")', $sanitizedSearch);
			$this->db->group_end();
		}

		$this->db->order_by('noon.delivered', 'DESC');

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

