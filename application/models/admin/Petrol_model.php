<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Petrol_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'petrol_summary';
	}
	
	public function add_hunger_summary($data) {
		$query = $this->db->insert($this->table, $data);
		return $query;
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
		$a = "SELECT * FROM $this->table WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$start_date,$end_date){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (vehicle_no LIKE '%".$keyword."%')";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (filling_date BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND (vehicle_no LIKE '%".$_POST["search"]["value"]."%')";
		}
		if(isset($_POST["order"])){
			$a .= " ORDER BY id ". $_POST['order']['0']['dir'] ."";
		}
        else{
			$a .= " ORDER BY id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$start_date,$end_date){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (vehicle_no LIKE '%".$keyword."%')";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (filling_date BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND (vehicle_no LIKE '%".$_POST["search"]["value"]."%')";
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from($this->table);  
	   return $this->db->count_all_results();
    }
}

