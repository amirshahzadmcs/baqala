<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Jahez_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'jahez_order_summary';
	}
	
	public function update($where, $data) {
		return $this->db->update($this->table, $data, $where);
	}

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM $this->table WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	public function add_batch($data) {
		return $this->db->insert_batch($this->table, $data);
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "SELECT jos.*, (SUBSTRING_INDEX(jos.dispatch_time, ' ', 1)) AS dtime, me.emp_no, me.full_name FROM jahez_order_summary jos LEFT JOIN master_employee me ON (jos.emp_id = me.id) WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date){
		$a = $this->make_query();
		if ($keyword) {
			$a .= " AND (me.full_name LIKE '%" . $keyword . "%' OR me.emp_no LIKE '%" . $keyword . "%')";
		}
		if($did){
			$a .= " AND jos.did= '" . $did . "'";
		}
		if($ref_id){
			$a .= " AND jos.ref_id = '" . $ref_id . "'";
		}
		if($driver_username){
			$a .= " AND jos.driver_username = '" . $driver_username . "'";
		}
		if($driver_id){
			$a .= " AND jos.driver_id = '" . $driver_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (jos.order_date BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND emp.first_name LIKE '%".$_POST["search"]["value"]."%' OR emp.emp_no LIKE '%".$_POST["search"]["value"]."%' OR cv.cv_no LIKE '%".$_POST["search"]["value"]."%' OR emp.email LIKE '%".$_POST["search"]["value"]."%'";
		// }
		/*
		if(isset($_POST["order"])){
			$a .= "  ORDER BY dispatch_time DESC";
		}
        else{
			$a .= " ORDER BY dispatch_time DESC";   
        }*/	 
        $a .= " ORDER BY jos.order_date DESC";
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date){
	   	$a = $this->make_query();
	   	if ($keyword) {
			$a .= " AND (me.full_name LIKE '%" . $keyword . "%' OR me.emp_no LIKE '%" . $keyword . "%')";
		}
		if($did){
			$a .= " AND jos.did= '" . $did . "'";
		}
		if($ref_id){
			$a .= " AND jos.ref_id = '" . $ref_id . "'";
		}
		if($driver_username){
			$a .= " AND jos.driver_username = '" . $driver_username . "'";
		}
		if($driver_id){
			$a .= " AND jos.driver_id = '" . $driver_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (jos.order_date BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('jahez_order_summary');  
	   return $this->db->count_all_results();
    }
	
	
	public function get_summary($keyword, $did, $ref_id, $driver_username, $driver_id, $start_date, $end_date) {
		// Common keyword filter logic
		$apply_keyword_filter = function () use ($keyword) {
			if (!empty($keyword)) {
				$keyword = preg_replace('/\s+/', '', $keyword);
				$this->db->group_start();
				$this->db->like('REPLACE(me.full_name, " ", "")', $keyword);
				$this->db->or_like('me.emp_no', $keyword);
				$this->db->group_end();
			}
		};
	
		// ---------- MAIN REPORT QUERY ----------
		$this->db->select("
			jahez.*, 
			SUM(jahez.driver_debit_amt) as total_fine, 
			SUM(jahez.driver_credit_amt) as total_reversal, 
			SUM(jahez.amount) as total_amount, 
			SUM(jahez.price) as total_price, 
			COUNT(jahez.id) as total_deliveries, 
			er.employee_id, 
			me.emp_no, 
			me.full_name
		");
		$this->db->from($this->table . ' jahez');
		$this->db->join('logistic_rider er', 'jahez.driver_id = er.id_number', 'left');
		$this->db->join('master_employee me', 'er.employee_id = me.id', 'left');
	
		$apply_keyword_filter();
	
		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}
		if (!empty($did)) {
			$this->db->where('jahez.did', $did);
		}
		if (!empty($ref_id)) {
			$this->db->where('jahez.ref_id', $ref_id);
		}
		if (!empty($driver_username)) {
			$this->db->where('jahez.driver_username', $driver_username);
		}
		if (!empty($start_date) && !empty($end_date)) {
			$this->db->where("jahez.order_date >=", date('Y-m-d', strtotime($start_date)));
			$this->db->where("jahez.order_date <=", date('Y-m-d', strtotime($end_date)));
		}
	
		$this->db->group_by('jahez.driver_id');
		$this->db->order_by('total_deliveries', 'DESC');
		$report = $this->db->get()->result_array();
	
	
		// ---------- COUNT COMPLETED DELIVERIES QUERY ----------
		$this->db->select("
			COUNT(jahez.id) as total_deliveries, 
			er.employee_id, 
			me.emp_no, 
			me.full_name
		");
		$this->db->from($this->table . ' jahez');
		$this->db->join('logistic_rider er', 'jahez.driver_id = er.id_number', 'left');
		$this->db->join('master_employee me', 'er.employee_id = me.id', 'left');
	
		$apply_keyword_filter();
	
		if (!empty($driver_id)) {
			$this->db->where('jahez.driver_id', $driver_id);
		}
		if (!empty($did)) {
			$this->db->where('jahez.did', $did);
		}
		if (!empty($ref_id)) {
			$this->db->where('jahez.ref_id', $ref_id);
		}
		if (!empty($driver_username)) {
			$this->db->where('jahez.driver_username', $driver_username);
		}
		if (!empty($start_date)) {
			// Count till the end of the same month if only one day selected, else for the full range
			$from_date = date('Y-m-01', strtotime($start_date));
			$to_date = (!empty($end_date) && $start_date !== $end_date) 
				? date('Y-m-d', strtotime($end_date)) 
				: date('Y-m-d', strtotime($start_date));
			$this->db->where("jahez.order_date >=", $from_date);
			$this->db->where("jahez.order_date <=", $to_date);
		}
	
		$this->db->order_by('total_deliveries', 'DESC');
		$count_completed_delv_till = $this->db->get()->row_array();
	
		return [
			'all_delv_count' => $count_completed_delv_till,
			'details' => $report
		];
	}	

	public function get_detail_summary($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date) {
        $this->db->select("
            jahez.*, 
            er.employee_id, 
            me.emp_no, 
            me.full_name
        ");
        $this->db->from($this->table . ' jahez');
        $this->db->join('logistic_rider er', 'jahez.driver_id = er.id_number', 'left');
        $this->db->join('master_employee me', 'er.employee_id = me.id', 'left');

        if (!empty($keyword)) {
			$keyword = preg_replace('/\s+/', '', $keyword);
			$this->db->group_start(); // Start grouping the OR conditions
			$this->db->like('REPLACE(me.full_name, " ", "")', $keyword);
			$this->db->or_like('me.emp_no', $keyword);
			$this->db->group_end(); // End grouping
		}


        if (!empty($driver_id)) {
            $this->db->where('jahez.driver_id', $driver_id);
        }

        if (!empty($did)) {
            $this->db->where('jahez.did', $did);
        }

        if (!empty($ref_id)) {
            $this->db->where('jahez.ref_id', $ref_id);
        }

        if (!empty($driver_username)) {
            $this->db->where('jahez.driver_username', $driver_username);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where("jahez.order_date >=", date('Y-m-d', strtotime($start_date)));
            $this->db->where("jahez.order_date <=", date('Y-m-d', strtotime($end_date)));
        }

        $this->db->order_by('jahez.order_date', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function daywise_performance($keyword, $rider_id, $month_of, $team){
		// Prepare and validate the date range
        $date = DateTime::createFromFormat('M Y', $month_of);
        if ($date === false) {
            throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
        }
        $start_date = $date->format('Y-m-01');
        $end_date = $date->format('Y-m-t');
		$a = "
		SELECT 
			jahez.*, 
			er.employee_id, 
			me.emp_no, 
			me.full_name, 
			me.mobile,
			1 AS completed_deliveries,  -- Treat each row as one completed delivery
			(
				SELECT GROUP_CONCAT(ht.name) 
				FROM hunger_team ht 
				WHERE ht.team REGEXP CONCAT('\"', jahez.emp_id, '\"')
			) as team_name 
		FROM $this->table jahez 
		LEFT JOIN logistic_rider er ON (jahez.driver_id = er.id_number) 
		LEFT JOIN master_employee me ON (jahez.emp_id = me.id) 
		WHERE 1=1";

		if($keyword){
			$a .= " AND (me.full_name LIKE '%". $keyword ."%' OR me.emp_no LIKE '%". $keyword ."%')";
		}
		if($rider_id){
			$a .= " AND jahez.driver_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$a .= " AND (jahez.order_date BETWEEN '". $start_date ."' AND '".$end_date."')";
		}
		// Apply team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', jahez.emp_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}
		$a .= " ORDER BY jahez.order_date ASC";
		$query = $this->db->query($a);
		return $query->result();
	}
	
	public function get_weekly_deliveries_report($keyword, $rider_id, $team, $start_date, $end_date)
	{
		$total_target = 15 * 7; // Weekly target
		$current_date = new DateTime();
		$start_date_obj = new DateTime($start_date);
		$days_passed = $current_date->diff($start_date_obj)->days;
		$days_passed = $days_passed < 7 ? $days_passed : 7;
		$remaining_days = max(0, 7 - $days_passed);

		$this->db->query("SET @row_number := 0;");

		$this->db->select("@row_number := @row_number + 1 AS `Sr. No`", FALSE)
				->select('me.emp_no AS `Emp ID`')
				->select('me.full_name AS `Rider Name`')
				->select('jahez.driver_id AS `Jahez ID`')
				->select("(
						SELECT GROUP_CONCAT(ht.name SEPARATOR ', ')
						FROM hunger_team ht
						WHERE ht.team REGEXP CONCAT('\"', lr.employee_id, '\"')
				) AS `Team Name`", FALSE)
				->select("$total_target AS `Target Delivery`", FALSE)
				->select("COUNT(jahez.id) AS `Completed Delivery`", FALSE)
				->select("GREATEST($total_target - COUNT(jahez.id), 0) AS `Pending Delivery`", FALSE)
				->select("$remaining_days AS `Remaining Days`", FALSE)
				->select("ROUND(COUNT(jahez.id) / $days_passed, 2) AS `Daily Average`", FALSE)
				->select("CASE 
						WHEN ROUND(COUNT(jahez.id) / $days_passed, 2) >= 15 THEN 'Good'
						WHEN ROUND(COUNT(jahez.id) / $days_passed, 2) >= 10 THEN 'Needs Focus'
						ELSE 'Low Performer'
				END AS `Remark`", FALSE)
				->from('jahez_order_summary jahez')
				->join('logistic_rider lr', 'jahez.driver_id = lr.id_number', 'left')
				->join('master_employee me', 'lr.employee_id = me.id', 'left')
				->join('incentives inc', 'lr.incentive_id = inc.id', 'left')
				->where('jahez.order_date >=', $start_date)
				->where('jahez.order_date <=', $end_date);

		// Apply filters
		if ($keyword) {
			$this->db->group_start()
					->like('me.full_name', $keyword)
					->or_like('me.emp_no', $keyword)
					->group_end();
		}
		if ($rider_id) {
			$this->db->where('jahez.driver_id', $rider_id);
		}
		if ($team) {
			$team = $this->db->escape_like_str($team);
			$this->db->where("EXISTS (
				SELECT 1
				FROM hunger_team ht
				WHERE ht.team REGEXP CONCAT('\"', lr.employee_id, '\"')
				AND ht.name LIKE '%" . $team . "%'
			)", NULL, FALSE);
		}

		$this->db->group_by('me.emp_no, jahez.driver_id')
		->order_by('SUM(jahez.id)', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}
	
	//Monthly Summary Report
	public function monthly_performance($keyword, $rider_id, $start_date, $end_date, $team) {
		// Format dates
		$period_start = $start_date ? date('Y-m-d', strtotime($start_date)) : null;
		$period_end   = $end_date ? date('Y-m-d', strtotime($end_date)) : null;
	
		// Base FROM and JOINs
		$base_query = "FROM $this->table jahez
			LEFT JOIN logistic_rider er ON jahez.driver_id = er.id_number
			LEFT JOIN master_employee me ON jahez.emp_id = me.id
			WHERE 1=1";
	
		// Filters
		if ($keyword) {
			$keyword = $this->db->escape_like_str($keyword);
			$base_query .= " AND (me.full_name LIKE '%{$keyword}%' OR me.emp_no LIKE '%{$keyword}%')";
		}
	
		if ($rider_id) {
			$rider_id = $this->db->escape($rider_id);
			$base_query .= " AND jahez.driver_id = {$rider_id}";
		}
	
		if ($period_start && $period_end) {
			$base_query .= " AND jahez.order_date BETWEEN '{$period_start}' AND '{$period_end}'";
		}
	
		if ($team) {
			$team = $this->db->escape_like_str($team);
			$base_query .= " AND EXISTS (
				SELECT 1 FROM hunger_team ht
				WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
				AND ht.name LIKE '%{$team}%'
			)";
		}
	
		// Totals by year and month
		$totals_query = "
			SELECT 
				YEAR(jahez.order_date) AS year,
				MONTH(jahez.order_date) AS month,
				COUNT(DISTINCT jahez.driver_id) AS total_riders,
				COUNT(jahez.id) AS total_completed_deliveries,
				SUM(jahez.amount) AS total_amount,
				SUM(jahez.price) AS total_price,
				SUM(jahez.driver_debit_amt) AS total_driver_debit_amt,
				SUM(jahez.driver_credit_amt) AS total_driver_credit_amt
			{$base_query}
			GROUP BY YEAR(jahez.order_date), MONTH(jahez.order_date)
			ORDER BY year, month
		";
	
		$totals_result = $this->db->query($totals_query)->row_array(); // fixed from row_array()
	
		// Detailed records per rider per month
		$details_query = "
			SELECT 
				jahez.driver_id,
				YEAR(jahez.order_date) AS year,
				MONTH(jahez.order_date) AS month,
				er.employee_id,
				me.emp_no,
				me.full_name,
				me.mobile,
				COUNT(jahez.id) AS total_completed_deliveries,
				SUM(jahez.amount) AS total_amount,
				SUM(jahez.price) AS total_price,
				SUM(jahez.driver_debit_amt) AS total_driver_debit_amt,
				SUM(jahez.driver_credit_amt) AS total_driver_credit_amt
			{$base_query}
			GROUP BY jahez.driver_id, YEAR(jahez.order_date), MONTH(jahez.order_date)
			ORDER BY year DESC, month DESC, total_completed_deliveries DESC
		";
	
		$details_result = $this->db->query($details_query)->result_array();
	
		return ['totals' => $totals_result, 'details' => $details_result];
	}	
}

