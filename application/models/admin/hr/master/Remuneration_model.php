<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remuneration_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_remuneration SET remuneration_name = '" . $this->db->escape_str($this->input->post('remuneration_name')) . "', remuneration_name_ar = '" . $this->db->escape_str($this->input->post('remuneration_name_ar')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_remuneration SET remuneration_name = '" . $this->db->escape_str($this->input->post('remuneration_name')) . "', remuneration_name_ar = '" . $this->db->escape_str($this->input->post('remuneration_name_ar')) . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM master_remuneration WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND remuneration_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY remuneration_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY remuneration_name ASC";		   
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
		$this->db->from('master_remuneration');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_remuneration WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_remuneration WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
