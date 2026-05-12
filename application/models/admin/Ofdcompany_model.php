<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ofdcompany_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO food_deliv_companies SET company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', company_name_ar = '" . $this->db->escape_str($this->input->post('company_name_ar')) . "', id_length = '" . $this->input->post('id_length') . "', max_id_length = '" . $this->input->post('max_id_length') . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE food_deliv_companies SET company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', company_name_ar = '" . $this->db->escape_str($this->input->post('company_name_ar')) . "', id_length = '" . $this->input->post('id_length') . "', max_id_length = '" . $this->input->post('max_id_length') . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM food_deliv_companies WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT fdc.*, (select SUM(pdco.orders) from food_deliv_companies_orders pdco where fdc.id = pdco.company_id) as total_orders FROM food_deliv_companies fdc WHERE fdc.deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND fdc.company_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY fdc.company_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY fdc.company_name ASC";		   
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
		$this->db->from('food_deliv_companies');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE food_deliv_companies SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM food_deliv_companies WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
