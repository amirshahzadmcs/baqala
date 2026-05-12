<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insurance_type_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_insurance_type SET insurance_type = '" . $this->db->escape_str($this->input->post('insurance_type')) . "', insurance_type_ar = '" . $this->db->escape_str($this->input->post('insurance_type_ar')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_insurance_type SET insurance_type = '" . $this->db->escape_str($this->input->post('insurance_type')) . "', insurance_type_ar = '" . $this->db->escape_str($this->input->post('insurance_type_ar')) . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM master_insurance_type WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND insurance_type LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY insurance_type ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY insurance_type ASC";		   
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
		$this->db->from('master_insurance_type');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_insurance_type WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_insurance_type WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
