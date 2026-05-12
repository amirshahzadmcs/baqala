<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashreasons_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_cash_reasons SET reason_title_en = '" . $this->db->escape_str($this->input->post('reason_title_en')) . "', reason_title_ar = '" . $this->db->escape_str($this->input->post('reason_title_ar')) . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_cash_reasons SET reason_title_en = '" . $this->db->escape_str($this->input->post('reason_title_en')) . "', reason_title_ar = '" . $this->db->escape_str($this->input->post('reason_title_ar')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM master_cash_reasons WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM master_cash_reasons WHERE deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND reason_title_en LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY reason_title_en ". $_POST['order']['0']['dir'] ."";
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
		$this->db->from('master_cash_reasons');  
		$this->db->where('deleted','0');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE master_cash_reasons SET deleted = '1' WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM master_cash_reasons WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
