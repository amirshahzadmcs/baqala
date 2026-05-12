<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Jahez_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'maha_jahez_daily_summary';
	}
	
	public function update($where, $data) {
		return $this->db->update($this->table, $data, $where);
	}

	public function delete($ids) {
		if (!is_array($ids) || empty($ids)) {
			return false;
		}

		$this->db->where_in('id', $ids);
		$this->db->delete($this->table);

		return $this->db->affected_rows() > 0;
	}

	public function delete_by_date($date)
	{
		if (!$date) {
			return false;
		}

		$this->db->where('DATE(order_date)', $date);
		return $this->db->delete($this->table);
	}

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get('maha_jahez_daily_summary');
		return $query->row();
	}

	public function add_batch($data) {
		return $this->db->insert_batch($this->table, $data);
	}

	/*----- List Info -----*/
	public function list(
		$search = '', $perPage = 50, $start = 0,
		$date_from = null, $date_to = null, $driver_id = null,
		$vehicle_type = null, $vehicle_no = null, $team = null
	) {
		// Fetch user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'jahez_order_summary'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		// Fallback default columns
		if (empty($selectedColumns)) {
			$selectedColumns = [
				'jos.id', 'jos.emp_id', 'me.emp_no', 'me.full_name', 'jos.order_date', 'jos.driver_id',
				'jos.summary_date', 'jos.delivery_price', 'jos.cash_collection', 'jos.driver_credit',
				'jos.driver_debit', 'jos.bonuses', 'jos.tips', 'jos.penalty', 'jos.service_deduction',
				'jos.total_amount', 'jos.settled_amount', 'jos.unsettled_amount', 'jos.settled_on', 'jos.orders',
				'jos.alloted_vehicle_id', 'jos.alloted_team_id', 'jos.ip_address', 'jos.added_by',
				'jos.created_at', 'jos.updated_at',
				'mv.vehicle_type', 'mv.vehicle_no',
				'team_name' // subquery alias (handled below)
			];
		}

		// Prefix and handle subquery columns
		$selectedColumns = array_map(function ($col) {
			// Skip subqueries
			if (stripos($col, ' AS ') !== false || strpos($col, '(') !== false) {
				return $col;
			}

			// Special case: team_name (subquery)
			if ($col === 'team_name') {
				return '(SELECT GROUP_CONCAT(ht.name) FROM hunger_team ht WHERE ht.team REGEXP CONCAT(\'"\', jos.emp_id, \'"\')) AS team_name';
			}

			// Already prefixed
			if (strpos($col, 'jos.') === 0 || strpos($col, 'me.') === 0 || strpos($col, 'mv.') === 0) {
				return $col;
			}

			// Short-name mapping
			if (in_array($col, ['emp_no', 'full_name'])) {
				return 'me.' . $col;
			} elseif (in_array($col, ['vehicle_type', 'vehicle_no'])) {
				return 'mv.' . $col;
			} else {
				return 'jos.' . $col;
			}
		}, $selectedColumns);

		// Begin building query
		$this->db->select(implode(', ', $selectedColumns), false);
		$this->db->from('maha_jahez_daily_summary jos');
		$this->db->join('master_employee me', 'jos.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'jos.alloted_vehicle_id = mv.id', 'left');

		// Search
		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $column) {
				if (stripos($column, ' AS ') === false && strpos($column, '(') === false) {
					$this->db->or_like($column, $sanitizedSearch);
				}
			}
			$this->db->group_end();
		}

		// Filters
		if (!empty($date_from)) {
			$this->db->where('jos.order_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('jos.order_date <=', date('Y-m-d', strtotime($date_to)));
		}
		if (!empty($driver_id)) {
			$this->db->where('jos.driver_id', $driver_id);
		}
		if (!empty($vehicle_type)) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}
		if (!empty($vehicle_no)) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}
		if (!empty($team)) {
			$this->db->where("EXISTS (
				SELECT 1 FROM hunger_team ht 
				WHERE ht.team REGEXP CONCAT('\"', jos.emp_id, '\"')
				AND ht.name = " . $this->db->escape($team) . "
			)", null, false);
		}

		// Clone for total row count
		$totalRowsQuery = clone $this->db;
		$totalRowsCount = $totalRowsQuery->get()->num_rows();

		// Pagination & ordering
		$this->db->order_by('jos.order_date', 'DESC');
		$this->db->limit($perPage, max(0, $start));
		$result = $this->db->get()->result_array();

		// Final return
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

	public function getWhere($where = [])
	{
		if (!empty($where)) {
			$this->db->where($where);
		}
		$this->db->from('maha_jahez_daily_summary jos');
		$this->db->join('master_employee me', 'jos.emp_id = me.id', 'left');
		return $this->db->get()->row();
	}

	public function daily_performance($search, $date_from, $date_to, $driver_id, $vehicle_type, $vehicle_no, $team)
	{
		// Keyword filter
		$apply_keyword_filter = function () use ($search) {
			if (!empty($search)) {
				$search = preg_replace('/\s+/', '', $search);
				$this->db->group_start();
				$this->db->like('REPLACE(me.full_name, " ", "")', $search);
				$this->db->or_like('me.emp_no', $search);
				$this->db->or_like('jahez.driver_id', $search);
				$this->db->or_like('jahez.emp_id', $search);
				$this->db->or_like('jahez.order_date', $search);
				$this->db->or_like('jahez.summary_date', $search);
				$this->db->or_like('jahez.delivery_price', $search);
				$this->db->or_like('jahez.cash_collection', $search);
				$this->db->or_like('jahez.driver_credit', $search);
				$this->db->or_like('jahez.driver_debit', $search);
				$this->db->or_like('jahez.bonuses', $search);
				$this->db->or_like('jahez.tips', $search);
				$this->db->or_like('jahez.penalty', $search);
				$this->db->or_like('jahez.service_deduction', $search);
				$this->db->or_like('jahez.total_amount', $search);
				$this->db->or_like('jahez.settled_amount', $search);
				$this->db->or_like('jahez.unsettled_amount', $search);
				$this->db->or_like('jahez.settled_on', $search);
				$this->db->or_like('jahez.orders', $search);
				$this->db->or_like('jahez.alloted_vehicle_id', $search);
				$this->db->or_like('jahez.alloted_team_id', $search);
				$this->db->or_like('jahez.ip_address', $search);
				$this->db->or_like('jahez.added_by', $search);
				$this->db->or_like('jahez.created_at', $search);
				$this->db->or_like('jahez.updated_at', $search);
				$this->db->group_end();
			}
		};

		// ---------- MAIN REPORT ----------
		$this->db->select("
			jahez.driver_id,
			jahez.emp_id,
			jahez.order_date,
			jahez.driver_debit AS fine,
			jahez.penalty,
			jahez.service_deduction,
			jahez.tips,
			jahez.driver_credit,
			jahez.total_amount,
			jahez.delivery_price,
			jahez.cash_collection,
			jahez.orders AS deliveries,
			me.emp_no,
			me.full_name,
			mv.vehicle_type, 
			mv.vehicle_no,
			ht.name AS team_name
		");
		$this->db->from($this->table . ' jahez');
		$this->db->join('master_employee me', 'jahez.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'jahez.alloted_vehicle_id = mv.id', 'left');
		$this->db->join('hunger_team ht', 'ht.team REGEXP CONCAT(\'"\', jahez.emp_id, \'"\')', 'left');

		$apply_keyword_filter();

		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}

		if (!empty($vehicle_type)) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}

		if (!empty($vehicle_no)) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}

		if (!empty($team)) {
			$this->db->where('jahez.alloted_team_id', $team);
		}

		if (!empty($date_from)) {
			$this->db->where('jahez.order_date >=', date('Y-m-d', strtotime($date_from)));
		}

		if (!empty($date_to)) {
			$this->db->where('jahez.order_date <=', date('Y-m-d', strtotime($date_to)));
		}

		$this->db->order_by('jahez.order_date', 'DESC');
		$this->db->order_by('jahez.orders', 'DESC');

		$report = $this->db->get()->result_array();

		// ---------- TOTAL DELIVERIES ----------
		$this->db->select("SUM(jahez.orders) AS total_deliveries");
		$this->db->from($this->table . ' jahez');
		$this->db->join('master_employee me', 'jahez.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'jahez.alloted_vehicle_id = mv.id', 'left');
		$apply_keyword_filter();

		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}

		if (!empty($vehicle_type)) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}

		if (!empty($vehicle_no)) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}

		if (!empty($team)) {
			$this->db->where('jahez.alloted_team_id', $team);
		}

		if (!empty($date_from)) {
			$from_date = date('Y-m-d', strtotime($date_from));
			$to_date = (!empty($date_to) && $date_from !== $date_to)
				? date('Y-m-d', strtotime($date_to))
				: date('Y-m-d', strtotime($date_from));
			$this->db->where("jahez.order_date >=", $from_date);
			$this->db->where("jahez.order_date <=", $to_date);
		}

		$total_deliveries = $this->db->get()->row_array();

		// ---------- UNIQUE RIDER COUNT ----------
		$this->db->select("COUNT(DISTINCT jahez.emp_id) AS total_riders");
		$this->db->from($this->table . ' jahez');
		$this->db->join('master_employee me', 'jahez.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'jahez.alloted_vehicle_id = mv.id', 'left');
		$apply_keyword_filter();

		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}

		if (!empty($vehicle_type)) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}

		if (!empty($vehicle_no)) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}

		if (!empty($team)) {
			$this->db->where('jahez.alloted_team_id', $team);
		}

		if (!empty($date_from)) {
			$from_date = date('Y-m-d', strtotime($date_from));
			$to_date = (!empty($date_to) && $date_from !== $date_to)
				? date('Y-m-d', strtotime($date_to))
				: date('Y-m-d', strtotime($date_from));
			$this->db->where("jahez.order_date >=", $from_date);
			$this->db->where("jahez.order_date <=", $to_date);
		}

		$total_riders = $this->db->get()->row_array();

		return [
			'total_deliveries' => $total_deliveries['total_deliveries'] ?? 0,
			'total_riders' => $total_riders['total_riders'] ?? 0,
			'details' => $report
		];
	}

	public function daywise_performance($search, $month_of, $driver_id, $vehicle_type, $vehicle_no, $team){
		// Parse and validate month
		$date = DateTime::createFromFormat('M Y', $month_of);
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
		}
		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');

		// Start query
		$a = "
		SELECT 
			ja.*, me.emp_no, me.full_name, me.mobile, mv.vehicle_type, mv.vehicle_no,
			(
				SELECT GROUP_CONCAT(ht.name) 
				FROM hunger_team ht 
				WHERE ht.team REGEXP CONCAT('\"', ja.emp_id, '\"')
			) as team_name
		FROM maha_jahez_daily_summary ja
		LEFT JOIN master_employee me ON (ja.emp_id = me.id)
		LEFT JOIN master_vehicles mv ON (ja.alloted_vehicle_id = mv.id)
		WHERE 1=1";

		// Filters
		if ($search) {
			$a .= " AND (me.full_name LIKE '%" . $search . "%' OR me.emp_no LIKE '%" . $search . "%')";
		}
		if ($driver_id) {
			$a .= " AND ja.driver_id = '" . $driver_id . "'";
		}
		if ($vehicle_type) {
			$a .= " AND mv.vehicle_type = '" . $vehicle_type . "'";
		}
		if ($vehicle_no) {
			$a .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
		}
		if ($start_date && $end_date) {
			$a .= " AND (ja.order_date BETWEEN '" . $start_date . "' AND '" . $end_date . "')";
		}

		// Team filter
		if ($this->input->get('team')) {
			$team = $this->input->get('team');
			if ($team != '') {
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1 FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', ja.emp_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}

		$a .= " ORDER BY ja.order_date DESC";
		$query = $this->db->query($a);
		return $query->result();
	}

	public function get_weekly_deliveries_report($search, $vehicle_type, $vehicle_no, $team, $employer_id = null, $start_date, $end_date) 
	{
		$today = new DateTime();
		$start_date_obj = new DateTime($start_date);
		$end_date_obj   = new DateTime($end_date);

		// Fixed weekly target (15 × 7)
		$total_target = 15 * 7;

		// Days passed logic
		if ($today >= $start_date_obj && $today <= $end_date_obj) {
			// Current running week
			$days_passed = $today->diff($start_date_obj)->days + 1;
			$days_passed = min($days_passed, 7);
		} else {
			// Past week (or future week)
			$days_passed = 7;
		}

		$remaining_days = 7 - $days_passed;
		$remaining_days = max(0, $remaining_days);

		$this->db->query("SET @row_number := 0;");

		$this->db->select("@row_number := @row_number + 1 AS `Sr. No`", FALSE)
			->select('me.emp_no AS `Emp ID`')
			->select('me.full_name AS `Rider Name`')
			->select('me.sponsor_id AS `Sponsor ID`')
			->select('jos.driver_id AS `Jahez ID`')
			->select('mv.vehicle_no AS `Vehicle No`')
			->select('mv.vehicle_type AS `Vehicle Type`')
			->select("(
				SELECT GROUP_CONCAT(jt.name SEPARATOR ', ')
				FROM hunger_team jt
				WHERE jt.team REGEXP CONCAT('\"', jos.emp_id, '\"')
			) AS `Team Name`", FALSE)   // ✅ original alias restored
			->select("$total_target AS `Target Delivery`", FALSE)
			->select('SUM(jos.orders) AS `Completed Delivery`')
			->select("GREATEST($total_target - SUM(jos.orders), 0) AS `Pending Delivery`", FALSE)
			->select("GREATEST($remaining_days, 0) AS `Remaining Days`", FALSE)
			->select("CASE 
				WHEN SUM(jos.orders) >= (15 * $days_passed) THEN 'Good'
				WHEN SUM(jos.orders) >= (10 * $days_passed) THEN 'Needs Focus'
				ELSE 'Low Performer'
			END AS `Remark`", FALSE)
			->from('maha_jahez_daily_summary jos')
			->join('master_employee me', 'jos.emp_id = me.id', 'left')
			->join('master_vehicles mv', 'jos.alloted_vehicle_id = mv.id', 'left')
			->join('logistic_rider lr', 'jos.emp_id = lr.employee_id', 'left')
			->join('incentives inc', 'lr.incentive_id = inc.id', 'left')
			->where('jos.order_date >=', $start_date)
			->where('jos.order_date <=', $end_date);

		// Apply filters
		if ($search) {
			$this->db->group_start()
				->like('me.full_name', $search)
				->or_like('me.emp_no', $search)
				->or_like('jos.driver_id', $search)
				->group_end();
		}
		if ($employer_id) {
			$this->db->where('me.sponsor_id', $employer_id);
		}
		if ($vehicle_type) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}
		if ($vehicle_no) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}
		if ($team) {
			$team = $this->db->escape_like_str($team);
			$this->db->where("EXISTS (
				SELECT 1
				FROM hunger_team jt
				WHERE jt.team REGEXP CONCAT('\"', lr.employee_id, '\"')
				AND jt.name LIKE '%" . $team . "%'
			)", NULL, FALSE);
		}

		$this->db->group_by('me.emp_no, jos.driver_id')
			->order_by('SUM(jos.orders)', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Monthly Summary Report
	function monthly_performance($search, $month_of, $employer_id = null, $vehicle_type, $vehicle_no, $team) {
		$date = DateTime::createFromFormat('M Y', $month_of);
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
		}
		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');
		// Prepare the base query
		$base_query = " FROM $this->table jos 
						LEFT JOIN master_employee me ON (jos.emp_id = me.id) 
						LEFT JOIN master_vehicles mv ON (jos.alloted_vehicle_id = mv.id) 
						WHERE 1=1";
		// Add conditions
		if ($search) {
			$base_query .= " AND (me.full_name LIKE '%" . $search . "%' OR me.emp_no LIKE '%" . $search . "%' OR jos.driver_id LIKE '%" . $search . "%')";
		}
		if ($vehicle_type) {
			$base_query .= " AND mv.vehicle_type = '" . $vehicle_type . "'";
		}
		if ($vehicle_no) {
			$base_query .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
		}
		if ($employer_id) {
			$base_query .= " AND me.sponsor_id = '" . $employer_id . "'";
		}
		if ($start_date && $end_date) {
			$base_query .= " AND (jos.order_date BETWEEN '" . $start_date . "' AND '" . $end_date . "')";
		}

		// Team filter
		if ($this->input->get('team')) {
			$team = $this->input->get('team');
			if ($team != '') {
				$team = $this->db->escape_like_str($team);
				$base_query .= " AND EXISTS (
					SELECT 1 FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', jos.emp_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}
		// Query to get the totals grouped by month and year
		$totals_query = "SELECT 
							YEAR(jos.order_date) as year, 
							MONTH(jos.order_date) as month, 
							COUNT(DISTINCT jos.driver_id) as total_riders,
							SUM(jos.orders) as total_orders, 
							SUM(jos.total_amount) as sum_total_amount, 
							SUM(jos.driver_debit) as total_driver_debit, 
							SUM(jos.driver_credit) as total_driver_credit, 
							SUM(jos.bonuses) as total_bonuses, 
							SUM(jos.tips) as total_tips,
							SUM(jos.cash_collection) as total_cash_collection" 
						 . $base_query . 
						" GROUP BY YEAR(jos.order_date), MONTH(jos.order_date)
						  ORDER BY YEAR(jos.order_date), MONTH(jos.order_date)";
		
		$totals_result = $this->db->query($totals_query)->row_array();
	
		// Query to get the detailed records
		$details_query = "SELECT 
							jos.*, 
							me.emp_no, 
							me.full_name, 
							me.mobile,
							mv.vehicle_type,
							mv.vehicle_no,
							SUM(jos.orders) as total_orders, 
							SUM(jos.total_amount) as sum_total_amount, 
							SUM(jos.driver_debit) as total_driver_debit, 
							SUM(jos.driver_credit) as total_driver_credit, 
							SUM(jos.bonuses) as total_bonuses, 
							SUM(jos.tips) as total_tips,
							SUM(jos.cash_collection) as total_cash_collection"
						 . $base_query . 
						" GROUP BY jos.driver_id, YEAR(jos.order_date), MONTH(jos.order_date)
						  ORDER BY YEAR(jos.order_date) DESC, MONTH(jos.order_date) DESC, SUM(jos.orders) DESC";
	
		$details_result = $this->db->query($details_query)->result_array();
		
		// Return both the totals and the details
		return ['totals' => $totals_result, 'details' => $details_result];
	}
	
	//Monthly Revenue Report
	function monthly_revenue($search, $month_of, $employer_id = null, $vehicle_type, $vehicle_no, $team) {
		$date = DateTime::createFromFormat('M Y', $month_of);
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
		}
		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');
		
		$base_query = " FROM {$this->table} jos 
						LEFT JOIN master_employee me ON jos.emp_id = me.id 
						LEFT JOIN logistic_rider lr ON me.id = lr.employee_id 
						LEFT JOIN master_vehicles mv ON me.id = mv.alloted_user 
						LEFT JOIN incentives inc ON lr.incentive_id = inc.id 
						WHERE 1=1";

		// Add conditions
		if ($search) {
			$base_query .= " AND (me.full_name LIKE '%" . $search . "%' OR me.emp_no LIKE '%" . $search . "%' OR jos.driver_id LIKE '%" . $search . "%')";
		}
		if ($vehicle_type) {
			$base_query .= " AND mv.vehicle_type = '" . $vehicle_type . "'";
		}
		if ($vehicle_no) {
			$base_query .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
		}
		if ($employer_id) {
			$base_query .= " AND me.sponsor_id = '" . $employer_id . "'";
		}
		if ($month_of) {
			$timestamp = strtotime($month_of);
			if ($timestamp) {
				$start_date = date('Y-m-01', $timestamp);
				$end_date = date('Y-m-t', $timestamp);
				$base_query .= " AND jos.order_date BETWEEN " . $this->db->escape($start_date) . " AND " . $this->db->escape($end_date);
			}
		}

		// Team filter
		if ($this->input->get('team')) {
			$team = $this->input->get('team');
			if ($team != '') {
				$team = $this->db->escape_like_str($team);
				$base_query .= " AND EXISTS (
					SELECT 1 FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', jos.emp_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}

		$details_query = "SELECT 
			jos.emp_id,
			jos.order_date,
			me.emp_no,
			me.full_name,
			me.iqama_no,
			me.sponsor_id,
			jos.driver_id,
			mv.vehicle_type,
			mv.vehicle_no,
			me.basic_salary AS salary,
			inc.target AS monthly_target,
			YEAR(jos.order_date) AS year,
			MONTH(jos.order_date) AS month,
			SUM(jos.orders) AS total_orders,
			AVG(jos.orders) AS avg_orders,
			COUNT(DISTINCT CASE WHEN jos.orders > 0 THEN jos.order_date END) AS working_days, -- calculated here
			(SUM(jos.orders) * 10) AS order_value, -- Placeholder
			SUM(jos.delivery_price) AS revenue,
			(SUM(jos.delivery_price) + SUM(jos.cash_collection) + SUM(jos.service_deduction) + SUM(jos.penalty)) AS cost
		" . $base_query . "
		GROUP BY jos.emp_id, YEAR(jos.order_date), MONTH(jos.order_date)
		ORDER BY YEAR(jos.order_date) DESC, MONTH(jos.order_date) DESC, SUM(jos.orders) DESC";

		$details_result = $this->db->query($details_query)->result_array();

		// Post-processing: calculate daily target
		foreach ($details_result as &$row) {
			$days_in_month = cal_days_in_month(CAL_GREGORIAN, $row['month'], $row['year']);
			$row['daily_target'] = ($row['monthly_target'] && $days_in_month)
				? round($row['monthly_target'] / $days_in_month, 2)
				: 0;
		}

		// Totals query
		$totals_query = "SELECT 
							COUNT(DISTINCT jos.driver_id) as total_riders,
							SUM(jos.orders) as total_orders, 
							SUM(jos.total_amount) as sum_total_amount, 
							SUM(jos.driver_debit) as total_driver_debit, 
							SUM(jos.driver_credit) as total_driver_credit, 
							SUM(jos.bonuses) as total_bonuses, 
							SUM(jos.tips) as total_tips,
							SUM(jos.cash_collection) as total_cash_collection
						" . $base_query;

		$totals_result = $this->db->query($totals_query)->row_array();

		return ['totals' => $totals_result, 'details' => $details_result];
	}
	
	public function jahez_cod_debit_report($search, $date_from, $date_to, $driver_id, $vehicle_type, $vehicle_no, $team)
	{
		// Reusable keyword filter
		$apply_keyword_filter = function () use ($search) {
			if (!empty($search)) {
				$search = preg_replace('/\s+/', '', $search);
				$this->db->group_start();
				$this->db->like('REPLACE(me.full_name, " ", "")', $search);
				$this->db->or_like('me.emp_no', $search);
				$this->db->or_like('jahez.driver_id', $search);
				$this->db->or_like('jahez.emp_id', $search);
				$this->db->or_like('jahez.order_date', $search);
				$this->db->or_like('jahez.cash_collection', $search);
				$this->db->or_like('jahez.driver_debit', $search);
				$this->db->group_end();
			}
		};

		// ---------- COD REPORT ----------
		$this->db->select("
			jahez.driver_id,
			jahez.emp_id,
			me.emp_no,
			me.full_name,
			mv.vehicle_type,
			mv.vehicle_no,
			SUM(jahez.orders) AS total_deliveries,
			SUM(jahez.cash_collection) AS total_cod
		");
		$this->db->from($this->table . ' jahez');
		$this->db->join('master_employee me', 'jahez.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'jahez.alloted_vehicle_id = mv.id', 'left');
		$this->db->join('hunger_team ht', 'ht.team REGEXP CONCAT(\'"\', jahez.emp_id, \'"\')', 'left');

		$apply_keyword_filter();

		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}
		if (!empty($vehicle_type)) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}
		if (!empty($vehicle_no)) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}
		if (!empty($team)) {
			$this->db->where('jahez.alloted_team_id', $team);
		}
		if (!empty($date_from)) {
			$this->db->where('jahez.order_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('jahez.order_date <=', date('Y-m-d', strtotime($date_to)));
		}

		$this->db->group_by('jahez.emp_id');
		$this->db->order_by('me.emp_no', 'DESC');
		$cod_report = $this->db->get()->result_array();

		// ---------- DEBIT REPORT ----------
		$this->db->select("
			jahez.driver_id,
			jahez.emp_id,
			me.emp_no,
			me.full_name,
			mv.vehicle_type,
			mv.vehicle_no,
			SUM(jahez.orders) AS total_deliveries,
			SUM(jahez.driver_debit) AS total_debit
		");
		$this->db->from($this->table . ' jahez');
		$this->db->join('master_employee me', 'jahez.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'jahez.alloted_vehicle_id = mv.id', 'left');
		$this->db->join('hunger_team ht', 'ht.team REGEXP CONCAT(\'"\', jahez.emp_id, \'"\')', 'left');

		$apply_keyword_filter();

		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}
		if (!empty($vehicle_type)) {
			$this->db->where('mv.vehicle_type', $vehicle_type);
		}
		if (!empty($vehicle_no)) {
			$this->db->where('mv.vehicle_no', $vehicle_no);
		}
		if (!empty($team)) {
			$this->db->where('jahez.alloted_team_id', $team);
		}
		if (!empty($date_from)) {
			$this->db->where('jahez.order_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('jahez.order_date <=', date('Y-m-d', strtotime($date_to)));
		}

		$this->db->group_by('jahez.emp_id');
		$this->db->order_by('me.emp_no', 'DESC');
		$debit_report = $this->db->get()->result_array();

		// ---------- TOTALS ----------
		$total_cod = array_sum(array_column($cod_report, 'total_cod'));
		$total_debit = array_sum(array_column($debit_report, 'total_debit'));
		$total_deliveries = array_sum(array_column($cod_report, 'total_deliveries'));

		return [
			'cod_report'     => $cod_report,
			'debit_report'   => $debit_report,
			'total_cod'      => $total_cod,
			'total_debit'    => $total_debit,
			'total_deliveries' => $total_deliveries
		];
	}
	//End Monthly Revenue Report
	/*
	public function printPerformanceReportJahez($search, $column_type, $file_format, $date_from, $date_to)
	{
		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(), 
			'module_name' => 'jahez_order_summary'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		if (empty($selectedColumns) || $column_type == 'all_columns') {
			$selectedColumns = [
				'maha.id', 'maha.emp_id', 'me.emp_no', 'me.full_name', 'maha.order_date', 'maha.driver_id',
				'maha.summary_date', 'maha.delivery_price', 'maha.cash_collection', 'maha.driver_credit',
				'maha.driver_debit', 'maha.bonuses', 'maha.tips', 'maha.penalty', 'maha.service_deduction',
				'maha.total_amount', 'maha.settled_amount', 'maha.unsettled_amount', 'maha.settled_on', 'jos.orders',
				'maha.alloted_vehicle_id', 'maha.alloted_team_id', 'maha.ip_address', 'maha.added_by',
				'maha.created_at', 'maha.updated_at'
			];
		} else {
			// Add table prefixes
			$selectedColumns = array_map(function($col) {
				return (strpos($col, 'me.') === 0 || strpos($col, 'maha.') === 0) 
					? $col 
					: (in_array($col, ['emp_no', 'full_name']) ? 'me.' . $col : 'maha.' . $col);
			}, $selectedColumns);
		}

		$isGroupedByRider = in_array('me.emp_no', $selectedColumns);

		$sumColumns = [
			'maha.delivery_price', 'maha.cash_collection', 'maha.driver_credit', 'maha.driver_debit',
			'maha.bonuses', 'maha.tips', 'maha.penalty', 'maha.service_deduction',
			'maha.total_amount', 'maha.settled_amount', 'maha.unsettled_amount'
		];

		$finalColumns = [];
		foreach ($selectedColumns as $column) {
			if ($isGroupedByRider && in_array($column, $sumColumns)) {
				$alias = str_replace('maha.', '', $column);
				$finalColumns[] = "SUM($column) AS $alias";
			} else {
				$finalColumns[] = $column;
			}
		}

		$this->db->select(implode(', ', $finalColumns));
		$this->db->from('maha_jahez_daily_summary maha');
		$this->db->join('master_employee me', 'maha.emp_id = me.id', 'left');

		if (!empty($search)) {
			$sanitizedSearch = preg_replace('/\s+/', '', $search);
			$this->db->group_start();
			foreach ($selectedColumns as $column) {
				$this->db->or_like($column, $sanitizedSearch);
			}
			$this->db->group_end();
		}

		if (!empty($date_from)) {
			$this->db->where('maha.order_date >=', date('Y-m-d', strtotime($date_from)));
		}
		if (!empty($date_to)) {
			$this->db->where('maha.order_date <=', date('Y-m-d', strtotime($date_to)));
		}

		if (in_array('maha.order_date', $selectedColumns)) {
			$this->db->order_by('maha.order_date', 'DESC');
		} else {
			$this->db->order_by('maha.summary_date', 'DESC');
		}

		$this->db->order_by('maha.delivery_price', 'DESC'); // Optional secondary sort

		// ✅ Execute Query
		$result = $this->db->get()->result_array();
		$totalRows = count($result);

		// ✅ Grand Totals
		$totals = [];
		if ($isGroupedByRider) {
			$this->db->select(implode(', ', array_map(function ($column) {
				return "SUM($column) AS " . str_replace('maha.', '', $column);
			}, $sumColumns)));
			$this->db->from('maha_jahez_daily_summary maha');
			$this->db->join('master_employee me', 'maha.emp_id = me.id', 'left');

			if (!empty($search)) {
				$sanitizedSearch = preg_replace('/\s+/', '', $search);
				$this->db->group_start();
				foreach ($selectedColumns as $column) {
					$this->db->or_like($column, $sanitizedSearch);
				}
				$this->db->group_end();
			}
			if (!empty($date_from)) {
				$this->db->where('maha.order_date >=', date('Y-m-d', strtotime($date_from)));
			}
			if (!empty($date_to)) {
				$this->db->where('maha.order_date <=', date('Y-m-d', strtotime($date_to)));
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
		*/
	//End List Info

}

