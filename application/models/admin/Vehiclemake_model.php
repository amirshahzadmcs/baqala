<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehiclemake_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO mater_van_make SET service_type = '" . $this->db->escape_str($this->input->post('service_type')) . "', make_name = '" . $this->db->escape_str($this->input->post('make_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE mater_van_make SET service_type = '" . $this->db->escape_str($this->input->post('service_type')) . "', make_name = '" . $this->db->escape_str($this->input->post('make_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM mater_van_make WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM mater_van_make WHERE deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND make_name LIKE '%".$_POST["search"]["value"]."%' OR service_type LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY make_name ". $_POST['order']['0']['dir'] ."";
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
		$this->db->from('mater_van_make');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE mater_van_make SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function van_make_by_id($id){
		$query = $this->db->query("SELECT * FROM mater_van_make WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
