<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Disputes_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'diputes_management';
	}
	
	public function add($data) {
		$query = $this->db->insert($this->table, $data);
		return $query;
	}

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM $this->table WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	public function get_summary_detail($ref_id) {
		$this->db->select('jos.*, me.full_name AS employee_name, me.emp_no, me.mobile, me.iqama_no, me.employee_pic, mv.id as vehicle_id, mv.vehicle_no, mv.vehicle_model, mv.vehicle_type');
		$this->db->from('jahez_order_summary jos');
		$this->db->join('master_employee me', 'me.id = jos.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.alloted_user = me.id', 'left');
		$this->db->where('jos.ref_id', $ref_id);
		
		$query = $this->db->get();
		return $query->row();
	}

	public function dispute_detail($id) {
		$this->db->select('d.*, mdt.dispute_type_en, mdt.dispute_type_ar, me.full_name AS employee_name, me.emp_no, me.iqama_no, me.mobile, mv.id as vehicle_id, mv.vehicle_no, mv.vehicle_model, mv.vehicle_type');
		$this->db->from("$this->table d");
		$this->db->join('master_dispute_types mdt', 'd.dispute_type = mdt.id', 'left');
		$this->db->join('master_employee me', 'd.emp_id = me.id', 'left');
		$this->db->join('master_vehicles mv', 'd.vehicle_id = mv.id', 'left');
		$this->db->where('d.id', $id);

		$query = $this->db->get();
		return $query->row();
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "SELECT d.*, mdt.dispute_type_en, mdt.dispute_type_ar FROM $this->table d LEFT JOIN master_dispute_types mdt ON (d.dispute_type = mdt.id) WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$ref_no,$status,$start_date,$end_date){
		$a = $this->make_query();
		
		if($keyword){
			$a .= " AND (d.driver_id LIKE '%".$keyword."%' OR d.rider_name LIKE '%".$keyword."%')";
		}
		if($ref_no){
			$a .= " AND d.ref_id = '" . $ref_no . "'";
		}
		if($status){
			$a .= " AND d.dispute_status = '" . $status . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('d-m-Y', strtotime($start_date));
			$period_end = date('d-m-Y', strtotime($end_date));
			$a .= " AND (SUBSTRING_INDEX(d.dispatch_time, ' ', 1) BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
        $a .= " ORDER BY d.id DESC";
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$ref_no,$status,$start_date,$end_date){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (d.driver_id LIKE '%".$keyword."%' OR d.rider_name LIKE '%".$keyword."%')";
		}
		if($ref_no){
			$a .= " AND d.ref_id = '" . $ref_no . "'";
		}
		if($status){
			$a .= " AND d.dispute_status = '" . $status . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('d-m-Y', strtotime($start_date));
			$period_end = date('d-m-Y', strtotime($end_date));
			$a .= " AND (SUBSTRING_INDEX(d.dispatch_time, ' ', 1) BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from($this->table);  
	   return $this->db->count_all_results();
    }
	
	function master_disputes_type(){
		$query = $this->db->query("SELECT * FROM master_dispute_types WHERE 1=1");
		return $query->result();
	}
}

