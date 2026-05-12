<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends CI_Model{

	public function generate_attendance_for_month($month, $overwrite = false)
	{
		try {
			$month = date('Y-m', strtotime($month)); // e.g. "2025-06"
		} catch (Exception $e) {
			throw new Exception("Invalid month format: $month");
		}

		$startDate = date('Y-m-d', strtotime("$month-01"));
		$today = date('Y-m-d');
		$currentMonth = date('Y-m');

		if ($month === $currentMonth) {
			$endDate = date('Y-m-d', strtotime('-1 day')); // till yesterday
		} else {
			$endDate = date('Y-m-t', strtotime($startDate)); // full month
		}

		log_message('info', "Generating attendance for month: $month ($startDate to $endDate), overwrite: " . ($overwrite ? 'true' : 'false'));

		// Overwrite existing records (only auto-generated ones)
		if ($overwrite) {
			$this->db->where('date_of_attend >=', $startDate);
			$this->db->where('date_of_attend <=', $endDate);
			$this->db->where('is_manual', 0); // ❗ preserve manual entries
			$this->db->delete('maha_employee_attendance');
		}

		// Fetch employees
		$this->db->select('master_employee.id');
		$this->db->from('master_employee');
		$this->db->join('logistic_rider', 'logistic_rider.employee_id = master_employee.id', 'inner');
		$this->db->where('master_employee.status', 'Active');
		$this->db->where('logistic_rider.rider_status', 'active');
		$employees = $this->db->get()->result_array();

		$period = new DatePeriod(
			new DateTime($startDate),
			new DateInterval('P1D'),
			(new DateTime($endDate))->modify('+1 day')
		);

		foreach ($period as $dateObj) {
			$date = $dateObj->format('Y-m-d');
			$presentEmpIds = [];
			$aggregatorMap = [];
			$vehicleMap = [];
			$teamMap = [];
			$deliveryCountMap = [];

			// Hunger
			$this->db->select('emp_id, rider_id, completed_deliveries, alloted_vehicle_id, alloted_team_id');
			$this->db->where('DATE(date_local)', $date);
			$this->db->where('completed_deliveries >', 0);
			$hunger = $this->db->get('hunger_order_summary')->result_array();
			foreach ($hunger as $row) {
				if (!empty($row['emp_id'])) {
					$empId = $row['emp_id'];
					$presentEmpIds[] = $empId;
					$aggregatorMap[$empId] = $row['rider_id'] ?? null;
					$vehicleMap[$empId] = $row['alloted_vehicle_id'] ?? null;
					$teamMap[$empId] = $row['alloted_team_id'] ?? null;
					$deliveryCountMap[$empId] = ($deliveryCountMap[$empId] ?? 0) + (int)$row['completed_deliveries'];
				}
			}

			// Jahez
			$this->db->select('emp_id, driver_id, orders, alloted_vehicle_id, alloted_team_id');
			$this->db->where('DATE(order_date)', $date);
			$this->db->where('orders >', 0);
			$jahez = $this->db->get('maha_jahez_daily_summary')->result_array();
			foreach ($jahez as $row) {
				if (!empty($row['emp_id'])) {
					$empId = $row['emp_id'];
					$presentEmpIds[] = $empId;
					$aggregatorMap[$empId] = $row['driver_id'] ?? null;
					$vehicleMap[$empId] = $row['alloted_vehicle_id'] ?? null;
					$teamMap[$empId] = $row['alloted_team_id'] ?? null;
					$deliveryCountMap[$empId] = ($deliveryCountMap[$empId] ?? 0) + (int)$row['orders'];
				}
			}

			// Noon
			$this->db->select('emp_id, da_id, delivered_orders, alloted_vehicle_id, alloted_team_id');
			$this->db->where('DATE(local_date)', $date);
			$this->db->where('delivered_orders >', 0);
			$noon = $this->db->get('noon_order_summary')->result_array();
			foreach ($noon as $row) {
				if (!empty($row['emp_id'])) {
					$empId = $row['emp_id'];
					$presentEmpIds[] = $empId;
					$aggregatorMap[$empId] = $row['da_id'] ?? null;
					$vehicleMap[$empId] = $row['alloted_vehicle_id'] ?? null;
					$teamMap[$empId] = $row['alloted_team_id'] ?? null;
					$deliveryCountMap[$empId] = ($deliveryCountMap[$empId] ?? 0) + (int)$row['delivered_orders'];
				}
			}

			// Keeta
			$this->db->select('emp_id, courier_id, delivered_tasks, alloted_vehicle_id, alloted_team_id');
			$this->db->where('DATE(order_date)', $date);
			$this->db->where('delivered_tasks >', 0);
			$keeta = $this->db->get('keeta_order_summary')->result_array();
			foreach ($keeta as $row) {
				if (!empty($row['emp_id'])) {
					$empId = $row['emp_id'];
					$presentEmpIds[] = $empId;
					$aggregatorMap[$empId] = $row['courier_id'] ?? null;
					$vehicleMap[$empId] = $row['alloted_vehicle_id'] ?? null;
					$teamMap[$empId] = $row['alloted_team_id'] ?? null;
					$deliveryCountMap[$empId] = ($deliveryCountMap[$empId] ?? 0) + (int)$row['delivered_tasks'];
				}
			}

			$presentEmpIds = array_unique($presentEmpIds);

			// Insert attendance
			foreach ($employees as $emp) {
				if (empty($emp['id'])) continue;

				$emp_id = $emp['id'];
				$attendType = in_array($emp_id, $presentEmpIds) ? 'P' : 'A';

				$aggregator_id = $aggregatorMap[$emp_id] ?? ($this->db->query("
					SELECT lr.id_number
					FROM logistic_rider lr
					WHERE lr.employee_id = $emp_id
					ORDER BY lr.id DESC
					LIMIT 1
				")->row()->id_number ?? null);

				$vehicle_id = $vehicleMap[$emp_id] ?? ($this->db->query("
					SELECT mv.id
					FROM master_vehicles mv
					WHERE mv.alloted_user = $emp_id
					AND mv.status = 'active'
					ORDER BY mv.id ASC
					LIMIT 1
				")->row()->id ?? null);

				$team_id = $teamMap[$emp_id] ?? (
					$this->db->query("
						SELECT ht.id
						FROM hunger_team ht
						WHERE ht.team REGEXP '\"{$emp_id}\"'
						ORDER BY ht.id ASC
						LIMIT 1
					")->row()->id ?? null
				);

				// Check if attendance already exists
				$existing = $this->db->get_where('maha_employee_attendance', [
					'emp_id' => $emp_id,
					'date_of_attend' => $date
				])->row();

				$yesterday = date('Y-m-d', strtotime('-1 day'));

				if ($existing) {
					// ✅ Skip update if record is manually set
					if ($existing->is_manual == 1) {
						continue;
					}

					// Update only if yesterday
					if ($date == $yesterday) {
						$updateData = [
							'attend_type'      => $attendType,
							'aggregator_id'    => $aggregator_id,
							'vehicle_id'       => $vehicle_id,
							'team_id'          => $team_id,
							'total_deliveries' => $deliveryCountMap[$emp_id] ?? 0,
							'remarks'          => 'Auto-generated',
							'is_manual'        => 0,
							'updated_at'       => date('Y-m-d H:i:s')
						];
						$this->db->where('id', $existing->id);
						$this->db->update('maha_employee_attendance', $updateData);
					}
				} else {
					// Insert new record (auto-generated)
					$this->db->insert('maha_employee_attendance', [
						'emp_id'           => $emp_id,
						'attend_type'      => $attendType,
						'date_of_attend'   => $date,
						'aggregator_id'    => $aggregator_id,
						'vehicle_id'       => $vehicle_id,
						'team_id'          => $team_id,
						'total_deliveries' => $deliveryCountMap[$emp_id] ?? 0,
						'remarks'          => 'Auto-generated',
						'is_manual'        => 0,
						'created_at'       => date('Y-m-d H:i:s')
					]);
				}
			}
		}
		return true;
	}

	public function getAttendanceSummaryByMonth()
	{
		$this->db->select("
			DATE_FORMAT(date_of_attend, '%Y-%m') AS attendance_month,
			DATE_FORMAT(MIN(date_of_attend), '%b %d') AS start_date,
			DATE_FORMAT(MAX(date_of_attend), '%b %d') AS end_date,
			COUNT(DISTINCT emp_id) AS total_employees,
			SUM(CASE WHEN attend_type = 'P' THEN 1 ELSE 0 END) AS total_present,
			SUM(CASE WHEN attend_type = 'A' THEN 1 ELSE 0 END) AS total_absent,
			COUNT(*) AS total_records
		");
		$this->db->from('maha_employee_attendance');
		$this->db->group_by("DATE_FORMAT(date_of_attend, '%Y-%m')");
		$this->db->order_by("YEAR(date_of_attend)", "DESC");
		$this->db->order_by("MONTH(date_of_attend)", "DESC");

		$query = $this->db->get();
		$result = $query->result_array();

		// Add final display format like "Nov 01 → Nov 30"
		foreach ($result as &$row) {
			$row['month_range'] = $row['start_date'] . ' → ' . $row['end_date'];
		}

		return $result;
	}
	
	// Function to apply common filters
    private function apply_filters(&$a) {
        if ($this->input->get('keyword')) {
			$keyword = $this->db->escape_like_str($this->input->get('keyword'));
			$a .= " AND emp.id = '" . $keyword . "'";
		}

		if($this->input->get('attendance_type')) {
            $attendance_type = $this->input->get('attendance_type');
            if($attendance_type != '') {
                $a .= " AND attendance.attend_type = '" . $attendance_type . "'";
            }
        }
		
		if($this->input->get('platform')) {
            $platform = $this->input->get('platform');
            if($platform != '') {
                $a .= " AND mli.platform_id = '" . $platform . "'";
            }
        }
		
		if($this->input->get('employer')) {
            $employer = $this->input->get('employer');
            if($employer != '') {
                $a .= " AND emp.sponsor_id = '" . $employer . "'";
            }
        }

		if($this->input->get('team')) {
            $team = $this->input->get('team');
            if($team != '') {
                $a .= " AND ht.name = '" . $team . "'";
            }
        }
		
		if($this->input->get('vehicle_no')) {
            $vehicle_no = $this->input->get('vehicle_no');
            if($vehicle_no != '') {
                $a .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
            }
        }
		
		if($this->input->get('vehicle_type')) {
            $vehicle_type = $this->input->get('vehicle_type');
            if($vehicle_type != '') {
                $a .= " AND mv.vehicle_type = '" . $vehicle_type . "'";
            }
        }

        if($this->input->get('date_from') && $this->input->get('date_to')) {
            $v_from = $this->input->get('date_from');
            $v_to = $this->input->get('date_to');
			$d_from = date("Y-m-d", strtotime($v_from));
            $d_to = date("Y-m-d", strtotime($v_to));
            if($v_from && $v_to) {
                $a .= " AND (attendance.date_of_attend BETWEEN '" . date("Y-m-d", strtotime($d_from)) . "' AND '" . $d_to . "')";
            }
        }
    }
	
	function make_query($month)
	{
		$sql = "SELECT attendance.*, 
					emp.emp_no, 
					emp.full_name as emp_full_name, 
					emp.employee_arabic_name, 
					emp.iqama_no, 
					emp.nationality,
					fdc.company_name as aggregator_name,
					mv.vehicle_type,
					mv.vehicle_no,
					mli.platform_id,
					ht.name as team_name 
				FROM maha_employee_attendance AS attendance 
				LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id 
				LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number 
				LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id 
				LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id 
				LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id 
				WHERE 1=1";
		// ✅ Filter by month (format: YYYY-MM)
		if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
			$sql .= " AND DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);
		}
		return $sql;
	}


	function get_list($month)
	{
		$sql = $this->make_query($month);
		$this->apply_filters($sql);

		// Order (fixed — no dynamic input, safe)
		$sql .= " ORDER BY attendance.date_of_attend DESC";

		// Pagination (improvement: sanitize inputs)
		$start = intval($_POST['start'] ?? 0);
		$length = intval($_POST['length'] ?? 10);

		if ($length != -1) {
			$sql .= " LIMIT $start, $length";
		}

		$query = $this->db->query($sql);
		return $query->result();
	}

    function get_filtered_data($month)
	{
		$sql = $this->make_query($month);
		$this->apply_filters($sql);
		$query = $this->db->query($sql);
		return $query->num_rows();
	}
     
    function get_all_data()
	{
		$month = $this->uri->segment(5); // Use correct URI segment

		$this->db->from('maha_employee_attendance');

		if ($month && preg_match('/^\d{4}-\d{2}$/', $month)) {
			$this->db->where("DATE_FORMAT(date_of_attend, '%Y-%m') =", $month);
		}

		return $this->db->count_all_results();
	}
	
	public function delete_attendance_by_month($month)
	{
		if (!$month || !preg_match('/^\d{4}-\d{2}$/', $month)) {
			return false;
		}

		$start = date("$month-01");
		$end   = date("Y-m-t", strtotime($start));

		$this->db->where("date_of_attend >=", $start);
		$this->db->where("date_of_attend <=", $end);
		return $this->db->delete('maha_employee_attendance');
	}

	function monthly_attendance_summary($month, $keyword = null, $aggregator_id = null, $attend_type = null)
	{
		$sql = $this->make_query($month, $keyword, $aggregator_id, $attend_type);

		// Order
		$sql .= " ORDER BY attendance.date_of_attend ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_attendance_by_id($id) {
		$this->db->select('attendance.*, 
			emp.emp_no, 
			emp.employee_pic,
			emp.full_name AS emp_full_name, 
			emp.employee_arabic_name, 
			emp.iqama_no, 
			emp.nationality,
			fdc.company_name AS aggregator_name,
			mv.vehicle_type,
			mv.vehicle_no,
			mli.platform_id,
			ht.name AS team_name
		');
		$this->db->from('maha_employee_attendance AS attendance');
		$this->db->join('master_employee AS emp', 'attendance.emp_id = emp.id', 'left');
		$this->db->join('master_logistic_ids AS mli', 'attendance.aggregator_id = mli.id_number', 'left');
		$this->db->join('food_deliv_companies AS fdc', 'mli.platform_id = fdc.id', 'left');
		$this->db->join('master_vehicles AS mv', 'attendance.vehicle_id = mv.id', 'left');
		$this->db->join('hunger_team AS ht', 'attendance.team_id = ht.id', 'left');
		$this->db->where('attendance.id', (int)$id);
		return $this->db->get()->row_array();
	}
	
	/**
	 * Update attendance record
	 * @param int $attendance_id
	 * @param array $data
	 * @return bool
	 */
	public function update_attendance($attendance_id, $data)
	{
		// Get old record
		$old_data = $this->db->get_where('maha_employee_attendance', ['id' => $attendance_id])->row_array();

		if (!$old_data) {
			return false;
		}

		// Insert log in log table
		$log_data = [
			'attendance_id' => $attendance_id,
			'emp_id'        => $old_data['emp_id'],
			'log_details'   => json_encode($old_data), // save old record as JSON
			'created_at'    => date('Y-m-d H:i:s')
		];
		$this->db->insert('maha_emp_attendance_log', $log_data);

		// Update main table with new data
		$this->db->where('id', $attendance_id);
		return $this->db->update('maha_employee_attendance', $data);
	}

	public function get_logs_by_attendance_id($attendance_id)
	{
		$this->db->select('id, attendance_id, emp_id, log_details, created_at');
		$this->db->from('maha_emp_attendance_log');
		$this->db->where('attendance_id', (int)$attendance_id);
		$this->db->order_by('created_at', 'DESC');
		$query = $this->db->get();
		$logs = $query->result_array();

		foreach ($logs as &$log) {
			$details = json_decode($log['log_details'], true);

			// Fetch related details if missing
			if (!isset($details['emp_no'])) {
				$emp = $this->db->select('emp_no, full_name AS emp_full_name, iqama_no')
								->where('id', $details['emp_id'])
								->get('master_employee')->row_array();
				$details = array_merge($details, $emp ?? []);
			}

			if (!isset($details['vehicle_no']) && !empty($details['vehicle_id'])) {
				$veh = $this->db->select('vehicle_no, vehicle_type')
								->where('id', $details['vehicle_id'])
								->get('master_vehicles')->row_array();
				$details = array_merge($details, $veh ?? []);
			}

			if (!isset($details['aggregator_name']) && !empty($details['aggregator_id'])) {
				$agg = $this->db->select('fdc.company_name AS aggregator_name')
								->join('master_logistic_ids mli', 'mli.id_number = ' . $details['aggregator_id'])
								->join('food_deliv_companies fdc', 'fdc.id = mli.platform_id')
								->get('master_logistic_ids')->row_array();
				$details = array_merge($details, $agg ?? []);
			}

			if (!isset($details['team_name']) && !empty($details['team_id'])) {
				$team = $this->db->select('name AS team_name')
								->where('id', $details['team_id'])
								->get('hunger_team')->row_array();
				$details = array_merge($details, $team ?? []);
			}

			$log['log_details'] = $details;
		}

		return $logs;
	}
	
	function get_employee_attendance($emp_id, $month = null) {
		$this->db->select('attendance.*, hos.working_hours');
		$this->db->from('maha_employee_attendance AS attendance');

		// Add LEFT JOIN
		$this->db->join(
			'hunger_order_summary hos',
			'hos.emp_id = attendance.emp_id AND DATE(hos.date_local) = DATE(attendance.date_of_attend)',
			'left'
		);

		$this->db->where('attendance.emp_id', (int)$emp_id);

		if ($month) {
			// Expecting YYYY-MM format
			$this->db->where('DATE_FORMAT(attendance.date_of_attend, "%Y-%m") = "'.$month.'"', NULL, FALSE);
		}

		return $this->db->get()->result_array();
	}
	
	/*---- Attendance Reports -----*/
	// 1️⃣ Employees with 26 or more Present days (attend_type = 'P')
	public function get_employees_with_26_present_days($month, $filters = [])
	{
		// Base condition
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				COUNT(CASE WHEN attendance.attend_type = 'P' THEN 1 END) AS total_present_days
			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_present_days >= 26
			ORDER BY total_present_days DESC
		";

		return $this->db->query($sql)->result();
	}

	// 1.1 Employees with less than 26 Present days (attend_type = 'P')
	public function get_employees_less_26_present_days($month, $filters = [])
	{
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . 
				$this->db->escape($filters['date_from']) . " AND " . 
				$this->db->escape($filters['date_to']);
		}

		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}

		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}

		if (!empty($filters['team'])) {
			$where .= " AND ht.id = " . $this->db->escape($filters['team']);
		}

		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}

		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}

		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,

				-- Count attendance types
				COALESCE(SUM(CASE WHEN attendance.attend_type = 'P' THEN 1 ELSE 0 END), 0) AS total_present_days,
				COALESCE(SUM(CASE WHEN attendance.attend_type != 'P' THEN 1 ELSE 0 END), 0) AS total_non_present_days,
				COUNT(attendance.id) AS total_days_recorded

			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING COALESCE(total_present_days, 0) < 26
			ORDER BY total_present_days DESC
		";

		return $this->db->query($sql)->result();
	}

	// 2️⃣ Employees who had NO week off (Thu, Fri, Sat)
	public function get_employees_with_no_week_off($month, $filters = [])
	{
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters (same as before)
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name,
				emp.iqama_no,
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				COUNT(
					CASE 
						WHEN attendance.attend_type = 'A' 
						AND DAYNAME(attendance.date_of_attend) IN ('Thursday', 'Friday', 'Saturday') 
						THEN 1 
					END
				) AS total_weekoffs
			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_weekoffs = 0
			ORDER BY emp.full_name ASC
		";

		return $this->db->query($sql)->result();
	}

	// 2️⃣b Employees showing TOTAL week-offs (Thu, Fri, Sat)
	public function get_employees_with_total_week_offs($month, $filters = [])
	{
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters (same as before)
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name,
				emp.iqama_no,
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				COUNT(
					CASE 
						WHEN attendance.attend_type = 'A' 
						AND DAYNAME(attendance.date_of_attend) IN ('Thursday', 'Friday', 'Saturday') 
						THEN 1 
					END
				) AS total_weekoffs
			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_weekoffs > 0
			ORDER BY total_weekoffs DESC
		";

		return $this->db->query($sql)->result();
	}

	// 3️⃣ Employees who had NO off days in the last week (25–31)
	public function get_employees_with_no_last_week_off($month, $filters = [])
	{
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				COUNT(
					CASE 
						WHEN attendance.attend_type = 'A' 
						AND attendance.date_of_attend >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)
						THEN 1 
					END
				) AS total_off_last_week
			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_off_last_week = 0
			ORDER BY emp.full_name ASC
		";

		return $this->db->query($sql)->result();
	}

	public function get_employees_with_total_last_week_off($month, $filters = [])
	{
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				COUNT(
					CASE 
						WHEN attendance.attend_type = 'A' 
						AND attendance.date_of_attend >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)
						THEN 1 
					END
				) AS total_off_last_week
			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_off_last_week > 0
			ORDER BY emp.full_name ASC
		";

		return $this->db->query($sql)->result();
	}

	// 4 Employees showing TOTAL hours worked >= 9 hours/day
	public function get_employees_with_9_hours_plus($month, $filters = [])
	{
		// Base condition
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " 
						AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name,
				emp.iqama_no,
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				ROUND(AVG(hos.working_hours), 2) AS avg_working_hours,
				COUNT(DISTINCT attendance.date_of_attend) AS total_attendance_days
			FROM maha_employee_attendance AS attendance
			LEFT JOIN hunger_order_summary AS hos 
				ON hos.emp_id = attendance.emp_id 
				AND DATE(hos.date_local) = DATE(attendance.date_of_attend)
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING avg_working_hours >= 9
			ORDER BY avg_working_hours DESC
		";

		return $this->db->query($sql)->result();
	}

	public function get_employees_with_less_than_9_hours($month, $filters = [])
	{
		// Base condition
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " 
						AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name,
				emp.iqama_no,
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,
				ROUND(AVG(hos.working_hours), 2) AS avg_working_hours,
				COUNT(DISTINCT attendance.date_of_attend) AS total_attendance_days
			FROM maha_employee_attendance AS attendance
			LEFT JOIN hunger_order_summary AS hos 
				ON hos.emp_id = attendance.emp_id 
				AND DATE(hos.date_local) = DATE(attendance.date_of_attend)
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING avg_working_hours < 9
			ORDER BY avg_working_hours ASC
		";

		return $this->db->query($sql)->result();
	}

	// 5️⃣ Employees showing TOTAL orders >= 450
	public function get_employees_450_plus($month, $filters = [])
	{
		// Base month condition
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . 
				$this->db->escape($filters['date_from']) . " AND " . 
				$this->db->escape($filters['date_to']);
		}

		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}

		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}

		if (!empty($filters['team'])) {
			$where .= " AND ht.id = " . $this->db->escape($filters['team']);
		}

		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}

		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}

		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		// Main query
		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,

				-- Attendance stats
				COALESCE(SUM(CASE WHEN attendance.attend_type = 'P' THEN 1 ELSE 0 END), 0) AS total_present_days,
				COALESCE(SUM(CASE WHEN attendance.attend_type != 'P' THEN 1 ELSE 0 END), 0) AS total_non_present_days,
				COUNT(attendance.id) AS total_days_recorded,

				-- Total deliveries in the month
				COALESCE(SUM(attendance.total_deliveries), 0) AS total_deliveries_in_month

			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_deliveries_in_month >= 450
			ORDER BY total_deliveries_in_month DESC
		";

		return $this->db->query($sql)->result();
	}

	// 6️⃣ Employees showing TOTAL orders < 450
	public function get_employees_below_450($month, $filters = [])
	{
		// Base month condition
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . 
				$this->db->escape($filters['date_from']) . " AND " . 
				$this->db->escape($filters['date_to']);
		}

		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}

		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}

		if (!empty($filters['team'])) {
			$where .= " AND ht.id = " . $this->db->escape($filters['team']);
		}

		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}

		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}

		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		// Main query
		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,

				-- Attendance stats
				COALESCE(SUM(CASE WHEN attendance.attend_type = 'P' THEN 1 ELSE 0 END), 0) AS total_present_days,
				COALESCE(SUM(CASE WHEN attendance.attend_type != 'P' THEN 1 ELSE 0 END), 0) AS total_non_present_days,
				COUNT(attendance.id) AS total_days_recorded,

				-- Total deliveries in the month
				COALESCE(SUM(attendance.total_deliveries), 0) AS total_deliveries_in_month

			FROM maha_employee_attendance AS attendance
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING total_deliveries_in_month < 450
			ORDER BY total_deliveries_in_month DESC
		";

		return $this->db->query($sql)->result();
	}

	// 4️⃣ Employees meeting ALL 5 conditions
	public function get_employees_meeting_all_conditions($month, $filters = [])
	{
		// Base condition for month
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " . $this->db->escape($filters['date_from']) . " 
						AND " . $this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		// Main query combining attendance, working hours, and delivery count
		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,

				-- Attendance stats
				COUNT(CASE WHEN attendance.attend_type = 'P' THEN 1 END) AS total_present_days,
				COUNT(CASE WHEN attendance.attend_type = 'A' 
							AND DAYNAME(attendance.date_of_attend) IN ('Thursday', 'Friday', 'Saturday') 
							THEN 1 END) AS total_weekoffs,
				COUNT(
					CASE 
						WHEN attendance.attend_type = 'A' 
						AND attendance.date_of_attend >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)
						THEN 1 
					END
				) AS total_off_last_week,

				-- Average working hours
				ROUND(AVG(hos.working_hours), 2) AS avg_working_hours,

				-- Total deliveries
				COALESCE(SUM(attendance.total_deliveries), 0) AS total_deliveries_in_month

			FROM maha_employee_attendance AS attendance
			LEFT JOIN hunger_order_summary AS hos 
				ON hos.emp_id = attendance.emp_id 
				AND DATE(hos.date_local) = DATE(attendance.date_of_attend)
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			HAVING 
				total_present_days >= 26 
				AND total_weekoffs = 0 
				AND total_off_last_week = 0
				AND avg_working_hours >= 9
				AND total_deliveries_in_month >= 450
			ORDER BY emp.full_name ASC
		";

		return $this->db->query($sql)->result();
	}

	// 🟢 Master Report: Show All Employees + Condition Status
	public function get_employees_condition_summary($month, $filters = [])
	{
		// Base month condition
		$where = "DATE_FORMAT(attendance.date_of_attend, '%Y-%m') = " . $this->db->escape($month);

		// Apply filters
		if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
			$where .= " AND attendance.date_of_attend BETWEEN " .
				$this->db->escape($filters['date_from']) . " AND " .
				$this->db->escape($filters['date_to']);
		}
		if (!empty($filters['keyword'])) {
			$where .= " AND emp.id = " . $this->db->escape_like_str($filters['keyword']);
		}
		if (!empty($filters['employer'])) {
			$where .= " AND emp.sponsor_id = " . $this->db->escape($filters['employer']);
		}
		if (!empty($filters['team'])) {
			$where .= " AND ht.name = " . $this->db->escape($filters['team']);
		}
		if (!empty($filters['platform'])) {
			$where .= " AND fdc.id = " . $this->db->escape($filters['platform']);
		}
		if (!empty($filters['vehicle_no'])) {
			$where .= " AND mv.vehicle_no LIKE '%" . $this->db->escape_like_str($filters['vehicle_no']) . "%'";
		}
		if (!empty($filters['vehicle_type'])) {
			$where .= " AND mv.vehicle_type = " . $this->db->escape($filters['vehicle_type']);
		}

		// Main query
		$sql = "
			SELECT 
				attendance.*,
				emp.id AS emp_id,
				emp.emp_no,
				emp.full_name AS emp_full_name, 
				emp.iqama_no, 
				emp.work_joining_date,
				fdc.company_name AS aggregator_name,
				mv.vehicle_type,
				mv.vehicle_no,
				mli.platform_id,
				ht.name AS team_name,

				-- Total present days
				COUNT(CASE WHEN attendance.attend_type = 'P' THEN 1 END) AS total_present_days,

				-- Week off (Thu, Fri, Sat)
				COUNT(CASE WHEN attendance.attend_type = 'A' 
							AND DAYNAME(attendance.date_of_attend) IN ('Thursday', 'Friday', 'Saturday')
							THEN 1 END) AS total_weekoffs,

				-- Off in last week (22-31)
				COUNT(
					CASE 
						WHEN attendance.attend_type = 'A' 
						AND attendance.date_of_attend >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)
						THEN 1 
					END
				) AS total_off_last_week,

				-- Average working hours (from hunger_order_summary)
				ROUND(AVG(hos.working_hours), 2) AS avg_working_hours,

				-- Total deliveries in month
				COALESCE(SUM(attendance.total_deliveries), 0) AS total_deliveries_in_month

			FROM maha_employee_attendance AS attendance
			LEFT JOIN hunger_order_summary AS hos 
				ON hos.emp_id = attendance.emp_id 
				AND DATE(hos.date_local) = DATE(attendance.date_of_attend)
			LEFT JOIN master_employee AS emp ON attendance.emp_id = emp.id
			LEFT JOIN master_logistic_ids AS mli ON attendance.aggregator_id = mli.id_number
			LEFT JOIN food_deliv_companies AS fdc ON mli.platform_id = fdc.id
			LEFT JOIN master_vehicles AS mv ON attendance.vehicle_id = mv.id
			LEFT JOIN hunger_team AS ht ON attendance.team_id = ht.id
			WHERE {$where}
			GROUP BY emp.id
			ORDER BY emp.full_name ASC
		";

		return $this->db->query($sql)->result();
	}

}
