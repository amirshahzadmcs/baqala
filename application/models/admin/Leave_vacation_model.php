<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave_vacation_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_leave SET name = '" . $this->db->escape_str($this->input->post('name')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_leave SET name = '" . $this->db->escape_str($this->input->post('name')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM master_leave WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();       
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_leave');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_leave WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_leave WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	// public function get_plan($id)
	// {
	// 	$query = $this->db->query("SELECT id, plan_name FROM master_plans WHERE network_id = '". (int)$id ."' AND status = '1'");
	// 	return $query->result();
	// }
	
}
