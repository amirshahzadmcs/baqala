<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Hunger_invoice_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'hunger_invoice';
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM $this->table WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "SELECT hi.*, er.employee_id, me.emp_no, me.full_name, me.mobile FROM $this->table hi LEFT JOIN logistic_rider er ON (hi.rider_id = er.id_number) LEFT JOIN master_employee me ON (er.employee_id = me.id) WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$rider_id,$start_date,$end_date){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (me.full_name LIKE '%". $keyword ."%' OR me.emp_no LIKE '%". $keyword ."%')";
		}
		if($rider_id){
			$a .= " AND hi.rider_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hi.invoice_month BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		if(isset($_POST["order"])){
			$a .= " ORDER BY hi.invoice_month DESC";
		}
        else{
			$a .= " ORDER BY hi.invoice_month DESC";		   
        }   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$rider_id,$start_date,$end_date){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (me.full_name LIKE '%". $keyword ."%' OR me.emp_no LIKE '%". $keyword ."%')";
		}
		if($rider_id){
			$a .= " AND hi.rider_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hi.invoice_month BETWEEN '". $period_start ."' AND '".$period_end."')";
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
		if (!isset($data['rider_id']) || !isset($data['invoice_month'])) {
			throw new InvalidArgumentException("Missing necessary keys in data array.");
		}
	
		// Query the database to check for duplicates based on rider_id and date
		$this->db->where('rider_id', $data['rider_id']);
		$this->db->where('invoice_month', date('Y-m-d', strtotime($data['invoice_month'])));
		$query = $this->db->get('hunger_invoice');
	
		// If a row is returned, it means the data already exists and is a duplicate
		if ($query->num_rows() > 0) {
			return true; // Indicate that a duplicate was found
		}
		return false; // No duplicates found
	}
	
	function avgRiderReport() {
		// Fetch the month input and team filter from the POST data
		$month_input = $this->input->post('month');
		$team = $this->input->post('team');
		$date = DateTime::createFromFormat('F Y', $month_input);
	
		if ($date) {
			// Extract month and year from the DateTime object
			$month = $date->format('m');
			$year = $date->format('Y');
			$start_date = "01-$month-$year";
			$end_date = date('t-m-Y', strtotime($start_date));
	
			// Base SQL Query to fetch the required data with sums, averages, and team name
			$sql = "
				SELECT 
					hi.`rider_id`, 
					hi.`contract_name`, 
					er.employee_id, 
					me.emp_no, 
					me.full_name, 
					me.mobile,
					(
						SELECT GROUP_CONCAT(ht.name SEPARATOR ', ')
						FROM hunger_team ht
						WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					) AS `Team Name`,
					SUM(hi.`orders`) AS `total_orders`, 
					SUM(hi.`TotalAmountSD`) AS `total_amount_sd`, 
					SUM(hi.`StackingDeduction`) AS `total_stacking_deduction`, 
					AVG(hi.`avg_rider_acceptance_rate`) AS `average_acceptance_rate`, 
					SUM(hi.`acceptance_rate_deduction_amt`) AS `total_acceptance_rate_deduction_amt`, 
					AVG(hi.`rider_contact_rate`) AS `average_rider_contact_rate`, 
					SUM(hi.`rider_contact_rate_amt`) AS `total_rider_contact_rate_amt`, 
					SUM(hi.`TotalAmountWSD`) AS `total_amount_wsd`, 
					SUM(hi.`VAT`) AS `total_vat`, 
					SUM(hi.`AmountIncVAT`) AS `total_amount_inc_vat`, 
					SUM(hi.`CourierBasicPayment`) AS `total_courier_basic_payment`, 
					SUM(hi.`CourierScoringPayment`) AS `total_courier_scoring_payment`, 
					SUM(hi.`RiderBalance`) AS `total_rider_balance`, 
					SUM(hi.`NewTotalDeduction`) AS `total_new_total_deduction`, 
					SUM(hi.`NewNetAmountToPay`) AS `total_new_net_amount_to_pay`, 
					hi.`invoice_month`,
					MIN(hi.`created_at`) AS `first_created_at`, -- Optional
					MAX(hi.`updated_at`) AS `last_updated_at`   -- Optional
				FROM 
					$this->table hi
				LEFT JOIN 
					logistic_rider er ON hi.rider_id = er.id_number 
				LEFT JOIN 
					master_employee me ON er.employee_id = me.id 
				WHERE 
					hi.invoice_month BETWEEN ? AND ?";
	
			// Add the team filter directly into the SQL query if provided
			if ($team) {
				$sql .= " AND EXISTS (
					SELECT 1 
					FROM hunger_team ht 
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					AND ht.name LIKE ?
				)";
			}
	
			$sql .= " GROUP BY 
						hi.`rider_id`, 
						hi.`invoice_month`
					  ORDER BY 
						`average_acceptance_rate` ASC";
	
			// Prepare the query parameters
			$params = [
				date('Y-m-d', strtotime($start_date)),
				date('Y-m-d', strtotime($end_date))
			];
	
			// Add team parameter if filtering by team
			if ($team) {
				$params[] = '%' . $team . '%';
			}
	
			// Execute the query
			$query = $this->db->query($sql, $params);
	
			// Return the query result as an array of objects
			return $query->result_array();
		} else {
			// Handle invalid date input here
			return [];
		}
	}
}

