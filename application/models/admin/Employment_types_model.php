<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employment_types_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO employment_types SET name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE employment_types SET name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM employment_types WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();  
		if($this->input->get('title')) {
			$title = $this->input->get('title');
			if($title != ''){
				$a .= " AND (name LIKE '%". $title ."%' OR arabic_name LIKE '%". $title ."%')";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND `status` = '" . $status . "'";
			}
		}    
		$a .= " ORDER BY name ASC";       
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data(){
	   	$a = $this->make_query();
	   	if($this->input->get('title')) {
			$title = $this->input->get('title');
			if($title != ''){
				$a .= " AND (name LIKE '%". $title ."%' OR arabic_name LIKE '%". $title ."%')";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND `status` = '" . $status . "'";
			}
		} 
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('employment_types');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM employment_types WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM employment_types WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

}
