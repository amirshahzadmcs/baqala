<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Hunger_compliance_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'hunger_daily_compliance';
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
		$a = "SELECT hdc.*, er.employee_id, me.emp_no, me.full_name, me.mobile FROM $this->table hdc LEFT JOIN logistic_rider er ON (hdc.rider_id = er.id_number) LEFT JOIN master_employee me ON (er.employee_id = me.id) WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$rider_id,$start_date,$end_date){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (me.full_name LIKE '%". $keyword ."%' OR me.emp_no LIKE '%". $keyword ."%')";
		}
		if($rider_id){
			$a .= " AND hdc.rider_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hdc.operation_date BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		if(isset($_POST["order"])){
			$a .= " ORDER BY hdc.operation_date DESC";
		}
        else{
			$a .= " ORDER BY hdc.operation_date DESC";		   
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
			$a .= " AND hdc.rider_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hdc.operation_date BETWEEN '". $period_start ."' AND '".$period_end."')";
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
		if (!isset($data['rider_id']) || !isset($data['operation_date'])) {
			throw new InvalidArgumentException("Missing necessary keys in data array.");
		}
	
		// Query the database to check for duplicates based on rider_id and date
		$this->db->where('rider_id', $data['rider_id']);
		$this->db->where('operation_date', date('Y-m-d', strtotime($data['operation_date'])));
		$query = $this->db->get('hunger_daily_compliance');
	
		// If a row is returned, it means the data already exists and is a duplicate
		if ($query->num_rows() > 0) {
			return true; // Indicate that a duplicate was found
		}
		return false; // No duplicates found
	}

}

