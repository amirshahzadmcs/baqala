<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function get_monthly_attendance($emp, $platform, $camp, $start_date, $end_date, $attend_status)
	{
		$this->db->select('
			r.id AS rider_id,
			r.employee_id,
			r.request_date,
			r.activate_date,
			r.platform,
			r.id_type,
			r.id_number,
			r.rider_status,
			r.last_transfer_date,
			t.time_id,
			t.vehicle_id,
			t.in_time,
			t.out_time,
			t.in_km,
			t.in_battery,
			t.out_km,
			t.out_battery,
			t.delivery_platform,
			t.is_otp_verified,
			mv.id as vehicle_id, 
			mv.vehicle_no,
			me.emp_no,
			me.full_name as employee_name,
			fdc.company_name,
			hos.working_hours,
			hos.completed_deliveries
		');
		$this->db->from('logistic_rider r');

		// Left join for timesheets
		$this->db->join('vehicle_timesheets t', 'r.employee_id = t.driver_id', 'left');

		// Apply the date filter on the 'out_time' column
		if ($start_date && $end_date) {
			$this->db->group_start(); // Open a group for the condition
			$this->db->where("DATE(t.out_time) BETWEEN '{$start_date}' AND '{$end_date}'", NULL, FALSE);
			$this->db->or_where('t.out_time IS NULL'); // Include records without timesheet entries
			$this->db->group_end(); // Close the group
		}

		// Additional joins
		$this->db->join('master_vehicles mv', 't.vehicle_id = mv.id', 'left');
		$this->db->join('master_employee me', 'r.employee_id = me.id', 'left');
		$this->db->join('food_deliv_companies fdc', 't.delivery_platform = fdc.id', 'left');
		$this->db->join('hunger_order_summary hos', 'r.id_number = hos.rider_id AND DATE(t.out_time) = DATE(hos.date_local)', 'left');

		// Filter for active riders
		$this->db->where('r.rider_status', 'active');

		// Additional filters based on parameters
		if ($emp) {
			$this->db->where('r.employee_id', $emp);
		}

		if ($platform) {
			$this->db->where('t.delivery_platform', $platform);
		}

		// if ($attend_status) {
		// 	if($attend_status == 'P') {
		// 		$this->db->where('t.out_time IS NOT NULL');
		// 	} else {
		// 		$this->db->where('t.out_time IS NULL');
		// 	}
		// }

		if ($camp) {
			$this->db->join('master_camp', 'me.camp = master_camp.id', 'left');
			$this->db->where('master_camp.id', $camp);
		}

		$this->db->order_by('t.out_time', 'DESC');

		// Pagination: use limit and offset from POST data
		if (isset($_POST["length"]) && $_POST["length"] != -1) {
			$this->db->limit($_POST["length"], $_POST["start"]);
		}

		// Execute the query
		$query = $this->db->get();
		$attendance_report = $query->result();

		return $attendance_report;
	}

	public function get_filtered_data($emp, $platform, $camp, $start_date, $end_date, $attend_status)
	{
		$this->db->select('
			r.id AS rider_id,
			r.employee_id,
			mli.request_date,
			mli.activate_date,
			fdc.company_name as platform,
			mli.id_type,
			mli.id_number,
			mli.rider_status,
			mli.last_transfer_date,
			t.time_id,
			t.vehicle_id,
			t.in_time,
			t.out_time,
			t.in_km,
			t.in_battery,
			t.out_km,
			t.out_battery,
			t.delivery_platform,
			t.is_otp_verified,
			me.emp_no,
			me.full_name as employee_name
		');
		$this->db->from('logistic_rider r');

		// Left join for timesheets
		$this->db->join('vehicle_timesheets t', 'r.employee_id = t.driver_id', 'left');
		$this->db->join('master_logistic_ids mli', 'r.id_number=mli.id_number', 'left');
		$this->db->join('food_deliv_companies fdc', 'mli.platform_id=fdc.id', 'left');

		if ($start_date && $end_date) {
			$this->db->group_start(); // Open a group for the condition
			$this->db->where("DATE(t.out_time) BETWEEN '{$start_date}' AND '{$end_date}'", NULL, FALSE);
			$this->db->or_where('t.out_time IS NULL'); // Include records without timesheet entries
			$this->db->group_end(); // Close the group
		}

		// Additional joins
		$this->db->join('master_employee me', 'r.employee_id = me.id', 'left');

		// Filter for active riders
		$this->db->where('r.rider_status', 'active');

		// Additional filters based on parameters
		if ($emp) {
			$this->db->where('r.employee_id', $emp);
		}

		if ($platform) {
			$this->db->where('t.delivery_platform', $platform);
		}

		if ($camp) {
			$this->db->join('master_camp', 'me.camp = master_camp.id', 'left');
			$this->db->where('master_camp.id', $camp);
		}

		// if ($attend_status) {
		// 	if($attend_status == 'P'){
		// 		$this->db->where('t.out_time !=', '');
		// 	}else{
		// 		$this->db->where('t.out_time', '');
		// 	}
		// }

		$this->db->order_by('r.employee_id');

		// Execute the query
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function get_all_data()
	{
		$this->db->select('
			r.id AS rider_id,
			r.employee_id,
			r.request_date,
			r.activate_date,
			r.platform,
			r.id_type,
			r.id_number,
			r.rider_status,
			r.last_transfer_date,
			t.time_id,
			t.vehicle_id,
			t.in_time,
			t.out_time,
			t.in_km,
			t.in_battery,
			t.out_km,
			t.out_battery,
			t.delivery_platform,
			t.is_otp_verified
		');
		$this->db->from('logistic_rider r');
		$this->db->join('vehicle_timesheets t', 'r.employee_id = t.driver_id', 'left');
		$this->db->where('r.rider_status', 'active');
		return $this->db->count_all_results();
	}

	public function print_monthly_attendance($emp, $platform, $camp, $start_date, $end_date, $attend_status)
	{
		$this->db->select('
			r.id AS rider_id,
			r.employee_id,
			mli.request_date,
			mli.activation_date,
			fdc.company_name as platform,
			mli.id_type,
			mli.id_number,
			r.rider_status,
			r.last_transfer_date,
			t.time_id,
			t.vehicle_id,
			t.in_time,
			t.out_time,
			t.in_km,
			t.in_battery,
			t.out_km,
			t.out_battery,
			t.delivery_platform,
			t.is_otp_verified,
			mv.id as vehicle_id, 
			mv.vehicle_no,
			me.emp_no,
			me.full_name as employee_name,
			fdc.company_name,
			hos.working_hours,
			hos.completed_deliveries,
			ma.new_status as logs
		');
		$this->db->from('logistic_rider r');

		// Left join for timesheets
		$this->db->join('vehicle_timesheets t', 'r.employee_id = t.driver_id AND DATE(t.out_time) BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($start_date), 'left');

		// Additional joins
		$this->db->join('master_vehicles mv', 't.vehicle_id = mv.id', 'left');
		$this->db->join('master_employee me', 'r.employee_id = me.id', 'left');
		$this->db->join('food_deliv_companies fdc', 't.delivery_platform = fdc.id', 'left');
		$this->db->join('hunger_order_summary hos', 'r.id_number = hos.rider_id AND DATE(t.out_time) = DATE(hos.date_local)', 'left');
		$this->db->join('master_logistic_ids mli', 'r.id_number=mli.id_number', 'left');
		$this->db->join(
			'manage_attendance ma',
			"(DATE(t.out_time) = ma.date AND r.employee_id = ma.emp_id) OR (ma.date = " . $this->db->escape($start_date) . " AND r.employee_id = ma.emp_id)",
			'left'
		);
		// $this->db->join('manage_attendance ma', 'DATE(t.out_time) = ma.date AND r.employee_id = ma.emp_id', 'left');

		// Filter for active riders

		// Additional filters based on parameters
		if ($emp) {
			$this->db->where('r.employee_id', $emp);
		}

		if ($platform) {
			$this->db->where('t.delivery_platform', $platform);
		}

		if ($attend_status) {
			if ($attend_status == 'P') {
				$this->db->where('t.out_time IS NOT NULL');
			} else {
				$this->db->where('t.out_time IS NULL');
			}
		}

		if ($camp) {
			$this->db->join('master_camp', 'me.camp = master_camp.id', 'left');
			$this->db->where('master_camp.id', $camp);
		}
		// Group by date to prevent duplicate entries per date
		$this->db->where('me.status', 'Active');
		$this->db->group_by('r.employee_id');
		$this->db->order_by('t.out_time', 'DESC');

		// Execute the query
		$query = $this->db->get();
		$attendance_report = $query->result();
		return $attendance_report;
	}

	public function monthly_attendance_report($month_of, $rider_id, $team_id)
	{
		// Prepare and validate the date range
		$date = DateTime::createFromFormat('M Y', $month_of);
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
		}
		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');
		//dd($end_date);
		$this->db->select('
			r.id AS rider_id,
			r.employee_id,
			r.rider_status,
			r.last_transfer_date,
			t.time_id,
			t.in_time,
			t.out_time,
			t.is_otp_verified,
			me.emp_no,
			me.full_name as employee_name,
			ht.name as team_name,
			ht.id as team_id,
			ma.new_status as logs
		');
		$this->db->from('logistic_rider r');

		// Left join for timesheets
		$this->db->join('vehicle_timesheets t', 'r.employee_id = t.driver_id AND DATE(t.out_time) BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date), 'left');
		// Additional joins
		$this->db->join('master_employee me', 'r.employee_id = me.id', 'left');
		// Join with hunger_team table
		$this->db->join('hunger_team ht', 'ht.team REGEXP CONCAT(\'"\', me.id, \'"\')', 'left');
		$this->db->join('manage_attendance ma', 'DATE(t.out_time) = ma.date AND r.employee_id = ma.emp_id', 'left');
		// Additional filters based on parameters
		if ($rider_id) {
			$this->db->where('r.employee_id', $rider_id);
		}
		if ($team_id) {
			$this->db->where('ht.id', $team_id);
		}
		// Group by date to prevent duplicate entries per date
		$this->db->where('me.status', 'Active');
		$this->db->order_by('t.out_time', 'DESC');

		// Execute the query
		$query = $this->db->get();
		$attendance_report = $query->result();
		return $attendance_report;
	}
}
