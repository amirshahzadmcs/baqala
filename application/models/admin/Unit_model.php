<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_unit SET unit_name = '" . $this->db->escape_str($this->input->post('unit_name')) . "', unit_name_ar = '" . $this->db->escape_str($this->input->post('unit_name_ar')) . "', status = '" . $this->input->post('status') . "', sort_order = '" . $this->input->post('sort_order') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_unit SET unit_name = '" . $this->db->escape_str($this->input->post('unit_name')) . "', unit_name_ar = '" . $this->db->escape_str($this->input->post('unit_name_ar')) . "', updated_at = now(), status = '" . $this->input->post('status') . "', sort_order = '" . $this->input->post('sort_order') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM master_unit WHERE is_deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM master_unit WHERE is_deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND unit_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY unit_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY sort_order ASC";		   
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
		$this->db->from('master_unit');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE master_unit SET is_deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_unit_by_id($id){
		$query = $this->db->query("SELECT * FROM master_unit WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
