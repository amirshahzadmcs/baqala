<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicearea_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO service_area SET area_name = '" . $this->db->escape_str($this->input->post('area_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE service_area SET area_name = '" . $this->db->escape_str($this->input->post('area_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM service_area WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM service_area WHERE deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND area_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY area_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY created_at DESC";		   
		}		   
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}        
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
		$this->db->from('service_area');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE service_area SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM service_area WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
