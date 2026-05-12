<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Businessunit_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_business_unit SET department_id = '" . $this->db->escape_str($this->input->post('department_id')) . "', business_unit_name = '" . $this->db->escape_str($this->input->post('business_unit_name')) . "', business_unit_name_ar = '" . $this->db->escape_str($this->input->post('business_unit_name_ar')) . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_business_unit SET department_id = '" . $this->db->escape_str($this->input->post('department_id')) . "', business_unit_name = '" . $this->db->escape_str($this->input->post('business_unit_name')) . "', business_unit_name_ar = '" . $this->db->escape_str($this->input->post('business_unit_name_ar')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT mbu.*, md.name as department_name FROM master_business_unit mbu LEFT JOIN master_department md ON (mbu.department_id = md.id) WHERE mbu.deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT mbu.*, md.name as department_name FROM master_business_unit mbu LEFT JOIN master_department md ON (mbu.department_id = md.id) WHERE mbu.deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND mbu.business_unit_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY mbu.business_unit_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY mbu.created_at DESC";		   
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
		$this->db->from('master_business_unit');  
		$this->db->where('deleted','0');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE master_business_unit SET deleted = '1' WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM master_business_unit WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
