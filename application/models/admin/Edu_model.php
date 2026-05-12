<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edu_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_edu SET name = '" . $this->db->escape_str($this->input->post('name')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_edu SET name = '" . $this->db->escape_str($this->input->post('name')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query() {
		// Start with a basic SQL query
		$query = "SELECT * FROM master_edu WHERE 1=1 ORDER BY name ASC";
		return $query;
	}

	function get_list($conditions = array()) {
		// Generate the dynamic query
		$query = $this->make_query();
		// Add conditions dynamically
		/*
		if (!empty($conditions)) {
			foreach ($conditions as $field => $value) {
				// You might want to sanitize input here to prevent SQL injection
				$query .= " AND $field = '$value'";
			}
		}
		// Order the results by name in ascending order
		$this->db->order_by("name", "ASC");
		*/
		// Execute the query
		$result = $this->db->query($query);

		// Return the result
		return $result->result();
	}
	  
    function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_edu');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_edu WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_edu WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	// public function get_plan($id)
	// {
	// 	$query = $this->db->query("SELECT id, plan_name FROM master_plans WHERE network_id = '". (int)$id ."' AND status = '1'");
	// 	return $query->result();
	// }
	
}
