<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Hunger_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'hunger_order_summary';
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM $this->table WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	public function delete_by_date($date)
	{
		if (!$date) {
			return false;
		}

		$this->db->where('DATE(date_local)', $date);
		return $this->db->delete('hunger_order_summary');
	}

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	/*----- List Info -----*/
	/*
	function make_query(){
		$a = "
		SELECT 
		hos.*, er.employee_id, me.emp_no, me.full_name, me.mobile, mv.vehicle_type, mv.vehicle_no,
		(
			SELECT GROUP_CONCAT(ht.name) 
			FROM hunger_team ht 
			WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
		) as team_name 
		FROM $this->table hos 
		LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number) 
		LEFT JOIN master_employee me ON (hos.emp_id = me.id) 
		LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id) 
		WHERE 1=1";
		return $a;
	}*/
	function make_query(){
		$a = "
		SELECT 
		hos.*, er.employee_id, me.emp_no, me.full_name, me.mobile, mv.vehicle_type, mv.vehicle_no, ht.name as team_name, sc.mobile as alloted_mobile_number 
		FROM $this->table hos 
		LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number) 
		LEFT JOIN master_employee me ON (hos.emp_id = me.id) 
		LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id) 
		LEFT JOIN hunger_team ht ON (hos.alloted_team_id = ht.id) 
		LEFT JOIN (
			SELECT sc1.*
			FROM sim_card sc1
			INNER JOIN (
				SELECT alloted_user, MAX(id) AS max_id
				FROM sim_card
				GROUP BY alloted_user
			) sc2
			ON sc1.alloted_user = sc2.alloted_user
			AND sc1.id = sc2.max_id
		) sc ON sc.alloted_user = hos.emp_id
		WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$rider_id,$vehicle_type,$start_date,$end_date, $deliveries_less_than = FALSE, $city = FALSE, $employer = FALSE)     {  
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (me.full_name LIKE '%". $keyword ."%' OR me.emp_no LIKE '%". $keyword ."%')";
		}
		if($rider_id){
			$a .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if($vehicle_type){
			$a .= " AND mv.vehicle_type= '" . $vehicle_type . "'";
		}
		if($city){
			$a .= " AND hos.city_name= '" . $city . "'";
		}
		if($employer){
			$a .= " AND me.sponsor_id= '" . $employer . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hos.date_local BETWEEN '". $period_start ."' AND '".$period_end."')";
		}

		// ✅ New filter for completed deliveries
		if($deliveries_less_than){
			if($deliveries_less_than == 13){
				$a .= " AND hos.completed_deliveries < 13";
			} elseif($deliveries_less_than == 15){
				$a .= " AND hos.completed_deliveries < 15";
			}
		}
		
		// Apply team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND ht.id = '" . $team . "'";
			}
		}
		
		if(isset($_POST["order"])){
			$a .= " ORDER BY hos.date_local DESC";
		}
        else{
			$a .= " ORDER BY hos.date_local DESC";		   
        }   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$rider_id,$vehicle_type,$start_date,$end_date, $deliveries_less_than = FALSE, $city = FALSE, $employer = FALSE){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (me.full_name LIKE '%". $keyword ."%' OR me.emp_no LIKE '%". $keyword ."%')";
		}
		if($rider_id){
			$a .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if($vehicle_type){
			$a .= " AND mv.vehicle_type= '" . $vehicle_type . "'";
		}
		if($city){
			$a .= " AND hos.city_name= '" . $city . "'";
		}
		if($employer){
			$a .= " AND me.sponsor_id= '" . $employer . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hos.date_local BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		// ✅ New filter for completed deliveries
		if($deliveries_less_than){
			if($deliveries_less_than == 13){
				$a .= " AND hos.completed_deliveries < 13";
			} elseif($deliveries_less_than == 15){
				$a .= " AND hos.completed_deliveries < 15";
			}
		}
		// Apply team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND hos.alloted_team_id = '" . $team . "'";
			}
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from($this->table);  
	   return $this->db->count_all_results();
    }
    
	/*----- List Info End -----*/

	public function checkDuplicateInBulk($data) {
		// Check if necessary keys are present in the $data array
		if (!isset($data['rider_id']) || !isset($data['date_local'])) {
			throw new InvalidArgumentException("Missing necessary keys in data array.");
		}
	
		// Query the database to check for duplicates based on rider_id and date
		$this->db->where('rider_id', $data['rider_id']);
		$this->db->where('date_local', date('Y-m-d', strtotime($data['date_local'])));
		$query = $this->db->get('hunger_order_summary');
	
		// If a row is returned, it means the data already exists and is a duplicate
		if ($query->num_rows() > 0) {
			return true; // Indicate that a duplicate was found
		}
	
		return false; // No duplicates found
	}

    //Print Daily Summary Report
    function daily_performance_row_count($keyword, $rider_id, $vehicle_type, $start_date, $end_date, $team, $deliveries_less_than)
	{
		$sql = "SELECT COUNT(*) AS total_rows
				FROM $this->table hos
				LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number)
				LEFT JOIN master_employee me ON (hos.emp_id = me.id)
				LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id)
				WHERE 1=1";

		if ($keyword) {
			$sql .= " AND (me.full_name LIKE '%{$keyword}%' OR me.emp_no LIKE '%{$keyword}%')";
		}
		if ($rider_id) {
			$sql .= " AND hos.rider_id = '{$rider_id}'";
		}
		if ($vehicle_type) {
			$sql .= " AND mv.vehicle_type = '{$vehicle_type}'";
		}
		if ($start_date && $end_date) {
			$sql .= " AND hos.date_local BETWEEN '{$start_date}' AND '{$end_date}'";
		}
		if ($deliveries_less_than) {
			if ($deliveries_less_than == 13) {
				$sql .= " AND hos.completed_deliveries < 13";
			} elseif ($deliveries_less_than == 15) {
				$sql .= " AND hos.completed_deliveries < 15";
			}
		}
		if ($team) {
			$sql .= " AND hos.alloted_team_id = '{$team}'";
		}

		return $this->db->query($sql)->row()->total_rows;
	}
	
	function daily_performance($keyword, $rider_id, $vehicle_type, $start_date, $end_date,$team, $deliveries_less_than) {
		// Prepare the base query
		$base_query = " FROM $this->table hos 
						LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number) 
						LEFT JOIN master_employee me ON (hos.emp_id = me.id) 
						LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id) 
						LEFT JOIN hunger_team ht ON (hos.alloted_team_id = ht.id) 
						WHERE 1=1";
		// Add conditions
		if ($keyword) {
			$base_query .= " AND (me.full_name LIKE '%" . $keyword . "%' OR me.emp_no LIKE '%" . $keyword . "%')";
		}
		if ($rider_id) {
			$base_query .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if($vehicle_type){
			$base_query .= " AND mv.vehicle_type= '" . $vehicle_type . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$base_query .= " AND (hos.date_local BETWEEN '" . $period_start . "' AND '" . $period_end . "')";
		}
		// ✅ New filter for completed deliveries
		if($deliveries_less_than){
			if($deliveries_less_than == 13){
				$base_query .= " AND hos.completed_deliveries < 13";
			} elseif($deliveries_less_than == 15){
				$base_query .= " AND hos.completed_deliveries < 15";
			}
		}
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$base_query .= " AND hos.alloted_team_id = '" . $team . "'";
			}
		}
		// Query to get the totals
		$totals_query = "SELECT 
							COUNT(DISTINCT hos.rider_id) as total_riders, 
							SUM(hos.completed_deliveries) as total_completed_deliveries, 
							SUM(hos.cancelled_deliveries) as total_cancelled_deliveries, 
							SUM(hos.notified_deliveries) as total_notified_deliveries, 
							SUM(hos.declined_deliveries) as total_declined_deliveries, 
							SUM(hos.accepted_deliveries) as total_accepted_deliveries, 
							SUM(hos.not_accepted_deliveries) as total_not_accepted_deliveries" 
						 . $base_query;
	
		$totals_result = $this->db->query($totals_query)->row_array();
	
		// Query to get the detailed records
		$details_query = "SELECT 
							hos.*, 
							er.employee_id, 
							me.emp_no, 
							me.full_name, 
							me.mobile,
							mv.vehicle_type,
							mv.vehicle_no,
							ht.name as team_name " 
						 . $base_query 
						 . " ORDER BY hos.date_local DESC, hos.completed_deliveries DESC";
	
		$details_result = $this->db->query($details_query)->result_array();
		
		// Query to get total completed deliveries till start date of month
		$count_completed_query = "SELECT SUM(hos.completed_deliveries) as total_completed_deliveries FROM $this->table hos 
								  LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number) 
								  LEFT JOIN master_employee me ON (hos.emp_id = me.id) 
								  LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id) 
								  WHERE 1=1";
		if ($keyword) {
			$count_completed_query .= " AND (me.full_name LIKE '%" . $keyword . "%' OR me.emp_no LIKE '%" . $keyword . "%')";
		}
		if ($rider_id) {
			$count_completed_query .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if($vehicle_type){
			$count_completed_query .= " AND mv.vehicle_type= '" . $vehicle_type . "'";
		}
		if ($start_date && $end_date) {
			if ($start_date == $end_date) {
				$endDayOfMonth = date('Y-m-d', strtotime($start_date));
				$firstDayOfMonth = date('Y-m-01', strtotime($endDayOfMonth));
				$count_completed_query .= " AND (hos.date_local BETWEEN '" . $firstDayOfMonth . "' AND '" . $endDayOfMonth . "')";
			} else {
				$startDayOfMonth = date('Y-m-d', strtotime($start_date));
				$endDayOfMonth = date('Y-m-d', strtotime($end_date));
				$count_completed_query .= " AND (hos.date_local BETWEEN '" . $startDayOfMonth . "' AND '" . $endDayOfMonth . "')";
			}
		}
		if($deliveries_less_than){
			if($deliveries_less_than == 13){
				$count_completed_query .= " AND hos.completed_deliveries < 13";
			} elseif($deliveries_less_than == 15){
				$count_completed_query .= " AND hos.completed_deliveries < 15";
			}
		}
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$count_completed_query .= " AND hos.alloted_team_id = '" . $team . "'";
			}
		}
		$count_completed_query .= " ORDER BY hos.date_local DESC, hos.completed_deliveries DESC";
		$count_completed_delv_till = $this->db->query($count_completed_query)->row_array();
		//print_r($count_completed_delv_till);exit();
	
		// Return both the totals and the details
		return ['totals' => $totals_result, 'all_delv_count' => $count_completed_delv_till, 'details' => $details_result];
	}
	
	public function daily_performance2($keyword, $rider_id, $vehicle_type, $month_of, $team)
	{
		// Prepare and validate the date range
		$date = DateTime::createFromFormat('M Y', $month_of);
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
		}

		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');

		$a = "
			SELECT 
				hos.*, 
				er.employee_id, 
				me.emp_no, 
				me.full_name, 
				me.mobile, 
				ht.name AS team_name
			FROM {$this->table} hos
			LEFT JOIN logistic_rider er ON hos.rider_id = er.id_number
			LEFT JOIN master_employee me ON hos.emp_id = me.id
			LEFT JOIN master_vehicles mv ON hos.alloted_vehicle_id = mv.id
			LEFT JOIN hunger_team ht ON hos.alloted_team_id = ht.id
			WHERE 1=1
		";

		// Keyword filter
		if (!empty($keyword)) {
			$keyword = $this->db->escape_like_str($keyword);
			$a .= " AND (me.full_name LIKE '%{$keyword}%' OR me.emp_no LIKE '%{$keyword}%')";
		}

		// Rider filter
		if (!empty($rider_id)) {
			$a .= " AND hos.rider_id = " . $this->db->escape($rider_id);
		}

		// Vehicle type filter
		if (!empty($vehicle_type)) {
			$a .= " AND mv.vehicle_type = " . $this->db->escape($vehicle_type);
		}

		// Date range filter
		$a .= " AND hos.date_local BETWEEN " . $this->db->escape($start_date) . " AND " . $this->db->escape($end_date);

		// Team filter
		if (!empty($team)) {
			$a .= " AND hos.alloted_team_id = " . $this->db->escape($team);
		}

		$a .= " ORDER BY hos.date_local DESC";

		$query = $this->db->query($a);
		return $query->result();
	}
	
	//Monthly Summary Report
	function monthly_performance_row_count($keyword, $rider_id, $vehicle_type, $start_date, $end_date, $team)
	{
		$sql = "SELECT COUNT(*) AS total_rows FROM (
					SELECT hos.rider_id, YEAR(hos.date_local), MONTH(hos.date_local)
					FROM $this->table hos
					LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number)
					LEFT JOIN master_employee me ON (hos.emp_id = me.id)
					LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id)
					WHERE 1=1";

		if ($keyword) {
			$sql .= " AND (me.full_name LIKE '%{$keyword}%' OR me.emp_no LIKE '%{$keyword}%')";
		}
		if ($rider_id) {
			$sql .= " AND hos.rider_id = '{$rider_id}'";
		}
		if ($vehicle_type) {
			$sql .= " AND mv.vehicle_type = '{$vehicle_type}'";
		}
		if ($start_date && $end_date) {
			$sql .= " AND hos.date_local BETWEEN '{$start_date}' AND '{$end_date}'";
		}
		if ($team) {
			$sql .= " AND hos.alloted_team_id = '{$team}'";
		}

		$sql .= " GROUP BY hos.rider_id, YEAR(hos.date_local), MONTH(hos.date_local)
				) AS grouped_data";

		return $this->db->query($sql)->row()->total_rows;
	}
	
	function monthly_performance($keyword, $rider_id, $vehicle_type, $start_date, $end_date,$team) {
		// Prepare the base query
		$base_query = " FROM $this->table hos 
						LEFT JOIN logistic_rider er ON (hos.rider_id = er.id_number) 
						LEFT JOIN master_employee me ON (hos.emp_id = me.id) 
						LEFT JOIN master_vehicles mv ON (hos.alloted_vehicle_id = mv.id) 
						WHERE 1=1";
		// Add conditions
		if ($keyword) {
			$base_query .= " AND (me.full_name LIKE '%" . $keyword . "%' OR me.emp_no LIKE '%" . $keyword . "%')";
		}
		if ($rider_id) {
			$base_query .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if($vehicle_type){
			$base_query .= " AND mv.vehicle_type= '" . $vehicle_type . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$base_query .= " AND (hos.date_local BETWEEN '" . $period_start . "' AND '" . $period_end . "')";
		}
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$base_query .= " AND hos.alloted_team_id = '" . $team . "'";
			}
		}
		// Query to get the totals grouped by month and year
		$totals_query = "SELECT 
							YEAR(hos.date_local) as year, 
							MONTH(hos.date_local) as month, 
							COUNT(DISTINCT hos.rider_id) as total_riders,
							SUM(hos.completed_deliveries) as total_completed_deliveries, 
							SUM(hos.cancelled_deliveries) as total_cancelled_deliveries, 
							SUM(hos.notified_deliveries) as total_notified_deliveries, 
							SUM(hos.declined_deliveries) as total_declined_deliveries, 
							SUM(hos.accepted_deliveries) as total_accepted_deliveries, 
							SUM(hos.not_accepted_deliveries) as total_not_accepted_deliveries" 
						 . $base_query . 
						" GROUP BY YEAR(hos.date_local), MONTH(hos.date_local)
						  ORDER BY YEAR(hos.date_local), MONTH(hos.date_local)";
		
		$totals_result = $this->db->query($totals_query)->row_array();
	
		// Query to get the detailed records
		$details_query = "SELECT 
							hos.*, 
							er.employee_id, 
							me.emp_no, 
							me.full_name, 
							me.mobile,
							SUM(hos.completed_deliveries) as total_completed_deliveries, 
							SUM(hos.cancelled_deliveries) as total_cancelled_deliveries, 
							SUM(hos.notified_deliveries) as total_notified_deliveries, 
							SUM(hos.declined_deliveries) as total_declined_deliveries, 
							SUM(hos.accepted_deliveries) as total_accepted_deliveries, 
							SUM(hos.not_accepted_deliveries) as total_not_accepted_deliveries,
							SUM(hos.monthly_wallet_balance) as total_monthly_wallet_balance,
							SUM(hos.working_hours) as total_working_hours,
							AVG(hos.acceptance_rate) AS average_acceptance_rate,
							SUM(hos.rider_earnings) as total_rider_earnings"
						 . $base_query . 
						" GROUP BY hos.rider_id, YEAR(hos.date_local), MONTH(hos.date_local)
						  ORDER BY YEAR(hos.date_local) DESC, MONTH(hos.date_local) DESC, SUM(hos.completed_deliveries) DESC";
	
		$details_result = $this->db->query($details_query)->result_array();
		
		// Return both the totals and the details
		return ['totals' => $totals_result, 'details' => $details_result];
	}
	
	//Monthly Revenue Report
	function monthly_revenue($month_of, $vehicle_type, $employer) {
		$base_query = " FROM {$this->table} hos 
						LEFT JOIN logistic_rider er ON hos.rider_id = er.id_number 
						LEFT JOIN master_employee me ON hos.emp_id = me.id 
						LEFT JOIN master_vehicles mv ON me.id = mv.alloted_user 
						LEFT JOIN logistic_rider lr ON me.id = lr.employee_id 
						LEFT JOIN incentives inc ON lr.incentive_id = inc.id 
						WHERE 1=1";

		// Parse month and year from input (e.g., "July 2025")
		if ($month_of) {
			$timestamp = strtotime($month_of);
			if ($timestamp) {
				$start_date = date('Y-m-01', $timestamp); // first day of month
				$end_date = date('Y-m-t', $timestamp);    // last day of month
				$base_query .= " AND hos.date_local BETWEEN " . $this->db->escape($start_date) . " AND " . $this->db->escape($end_date);
			}
		}

		if ($vehicle_type) {
			$base_query .= " AND mv.vehicle_type = " . $this->db->escape($vehicle_type);
		}

		if ($employer) {
			$base_query .= " AND me.sponsor_id = " . $this->db->escape($employer);
		}

		// Details query
		$details_query = "SELECT 
							hos.emp_id,
							hos.date_local,
							me.emp_no,
							me.full_name,
							me.iqama_no,
							me.sponsor_id,
							hos.rider_id,
							mv.vehicle_type,
							me.basic_salary AS salary,
							inc.target AS monthly_target,
							YEAR(hos.date_local) AS year,
							MONTH(hos.date_local) AS month,
							SUM(hos.completed_deliveries) AS total_completed_deliveries,
							AVG(hos.completed_deliveries) AS avg_completed_deliveries,
							SUM(hos.working_days) AS working_days,
							(SUM(hos.completed_deliveries) * 10) AS order_value, -- Placeholder
							SUM(hos.rider_earnings) AS revenue,
							(SUM(hos.rider_earnings) + SUM(hos.fine)) AS cost
						" . $base_query . "
						GROUP BY hos.emp_id, YEAR(hos.date_local), MONTH(hos.date_local)
						ORDER BY YEAR(hos.date_local) DESC, MONTH(hos.date_local) DESC, SUM(hos.completed_deliveries) DESC";

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
							COUNT(DISTINCT hos.rider_id) AS total_riders,
							SUM(hos.completed_deliveries) AS total_completed_deliveries,
							SUM(hos.cancelled_deliveries) AS total_cancelled_deliveries,
							SUM(hos.notified_deliveries) AS total_notified_deliveries,
							SUM(hos.declined_deliveries) AS total_declined_deliveries,
							SUM(hos.accepted_deliveries) AS total_accepted_deliveries,
							SUM(hos.not_accepted_deliveries) AS total_not_accepted_deliveries
						" . $base_query;

		$totals_result = $this->db->query($totals_query)->row_array();

		return ['totals' => $totals_result, 'details' => $details_result];
	}
	//End Monthly Revenue Report
	
	public function get_weekly_deliveries_report($keyword, $rider_id, $team, $start_date, $end_date, $employer_id = null)
	{
		$total_target = 15 * 7; // Weekly target
		$current_date = new DateTime();
		$start_date_obj = new DateTime($start_date);
		$days_passed = $current_date->diff($start_date_obj)->days;
		$days_passed = $days_passed < 7 ? $days_passed : 7; // Limit days_passed to 7
		$remaining_days = 7 - $days_passed;

		// Ensure remaining_days is not negative
		$remaining_days = max(0, $remaining_days);

		$this->db->query("SET @row_number := 0;");
		
		// Reuse the same CASE expression for select + having
		$remarkCase = "CASE 
			WHEN ROUND(SUM(hos.completed_deliveries) / $days_passed, 2) >= 15 THEN 'Good'
			WHEN ROUND(SUM(hos.completed_deliveries) / $days_passed, 2) >= 10 THEN 'Needs Focus'
			ELSE 'Low Performer'
		END";

		$this->db->select("@row_number := @row_number + 1 AS `Sr. No`", FALSE)
				->select('me.emp_no AS `Emp ID`')
				->select('me.full_name AS `Rider Name`')
				->select('hos.rider_id AS `Hunger ID`')
				->select("MAX(ht.name) AS `Team Name`", FALSE)
				->select("$total_target AS `Target Delivery`", FALSE)
				->select('SUM(hos.completed_deliveries) AS `Completed Delivery`')
				->select("GREATEST($total_target - SUM(hos.completed_deliveries), 0) AS `Pending Delivery`", FALSE)
				->select("GREATEST($remaining_days, 0) AS `Remaining Days`", FALSE)
				->select("ROUND(SUM(hos.completed_deliveries) / $days_passed, 2) AS `Daily Average`", FALSE)
            	->select("CASE 
                        WHEN ROUND(SUM(hos.completed_deliveries) / $days_passed, 2) >= 15 THEN 'Good'
                        WHEN ROUND(SUM(hos.completed_deliveries) / $days_passed, 2) >= 10 THEN 'Needs Focus'
                        ELSE 'Low Performer'
                    END AS `Remark`", FALSE)
				->from('hunger_order_summary hos')
				->join('logistic_rider lr', 'hos.rider_id = lr.id_number', 'left')
				->join('master_employee me', 'lr.employee_id = me.id', 'left')
				->join('hunger_team ht', 'hos.alloted_team_id = ht.id', 'left')
				->join('incentives inc', 'lr.incentive_id = inc.id', 'left')
				->where('hos.date_local >=', $start_date)
				->where('hos.date_local <=', $end_date);

		// Apply filters
		if ($keyword) {
			$this->db->group_start()
					->like('me.full_name', $keyword)
					->or_like('me.emp_no', $keyword)
					->group_end();
		}
		if ($employer_id) {
			$this->db->where('me.sponsor_id', $employer_id);
		}
		if ($rider_id) {
			$this->db->where('hos.rider_id', $rider_id);
		}
		if ($team) {
			$team = $this->db->escape_like_str($team);
			$this->db->where('hos.alloted_team_id', $team);
		}
		
		// ✅ Performance filter
		$performance = $this->input->get('performance');
		if (!empty($performance)) {
			$this->db->having($remarkCase . ' = ' . $this->db->escape($performance), NULL, FALSE);
			//          ^ build full condition and escape only the value
		}

		$this->db->group_by(array('me.emp_no', 'hos.rider_id', 'ht.name'))
        	->order_by('SUM(hos.completed_deliveries)', 'DESC');

		// Get the result
		$query = $this->db->get();

		// Return the result as an array
		return $query->result_array();
	}
	/*
    function get_summary($keyword,$rider_id,$start_date,$end_date){
		$a = $a = "SELECT hos.*, count(hos.id) as total_ids, SUM(hos.fine) as total_fine, SUM(hos.completed_deliveries) as total_completed_deliveries, SUM(hos.cancelled_deliveries) as total_cancelled_deliveries, SUM(hos.notified_deliveries) as total_notified_deliveries, SUM(hos.declined_deliveries) as total_declined_deliveries, SUM(hos.accepted_deliveries) as total_accepted_deliveries, SUM(hos.not_accepted_deliveries) as total_not_accepted_deliveries, SUM(hos.avg_rider_acceptance_rate) as total_avg_rider_acceptance_rate, SUM(hos.working_hours) as total_working_hours, er.emp_id, me.emp_no, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name  FROM $this->table hos LEFT JOIN employed_riders er ON (hos.rider_id = er.hunger_platform_id) LEFT JOIN master_employee me ON (er.emp_id = me.id) WHERE 1=1";
		if($keyword){
			$a .= " AND me.first_name LIKE '%".preg_replace('/\s+/', '', $keyword)."%')";
		}
		if($rider_id){
			$a .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hos.date_local BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND emp.first_name LIKE '%".$_POST["search"]["value"]."%' OR emp.emp_no LIKE '%".$_POST["search"]["value"]."%' OR cv.cv_no LIKE '%".$_POST["search"]["value"]."%' OR emp.email LIKE '%".$_POST["search"]["value"]."%'";
		// }
		//print_r($period_start);exit();
		$a .= " GROUP BY hos.rider_id";
        $query = $this->db->query($a);
        return $query->result_array();
    }
    
    function get_daywise_summary($start_date,$end_date){
		$a = $a = "SELECT hos.*, count(hos.id) as total_ids, count(hos.rider_id) as total_riders, SUM(hos.fine) as total_fine, SUM(hos.completed_deliveries) as total_completed_deliveries, SUM(hos.cancelled_deliveries) as total_cancelled_deliveries, SUM(hos.notified_deliveries) as total_notified_deliveries, SUM(hos.declined_deliveries) as total_declined_deliveries, SUM(hos.accepted_deliveries) as total_accepted_deliveries, SUM(hos.not_accepted_deliveries) as total_not_accepted_deliveries, SUM(hos.avg_rider_acceptance_rate) as total_avg_rider_acceptance_rate, SUM(hos.working_hours) as total_working_hours FROM $this->table hos WHERE 1=1";
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hos.date_local BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		//print_r($period_start);exit();
		$a .= " GROUP BY hos.date_local";
		$a .= " ORDER BY hos.date_local DESC";
        $query = $this->db->query($a);
        return $query->result_array();
    }
    
    function get_userwise_summary($rider_id,$start_date,$end_date){
		$a = $a = "SELECT hos.* FROM $this->table hos WHERE hos.rider_id = '". $rider_id ."'";
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hos.date_local BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		//print_r($period_start);exit();
		$a .= " ORDER BY hos.date_local DESC";
        $query = $this->db->query($a);
        return $query->result_array();
    }
	*/
}

