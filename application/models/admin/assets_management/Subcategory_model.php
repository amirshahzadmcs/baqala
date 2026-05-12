<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subcategory_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO assets_subcategory SET parent_id = '" . (int)$this->input->post('parent_id') . "', subcategory_name = '" . $this->db->escape_str($this->input->post('subcategory_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE assets_subcategory SET parent_id = '" . (int)$this->input->post('parent_id') . "', subcategory_name = '" . $this->db->escape_str($this->input->post('subcategory_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT asubc.*, ac.category_name FROM assets_subcategory asubc LEFT JOIN assets_category ac ON (ac.id = asubc.parent_id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND subcategory_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY subcategory_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY subcategory_name ASC";		   
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
		$this->db->from('assets_subcategory');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM assets_subcategory WHERE id IN (" . $id . ")");
		return $query;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM assets_subcategory WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_categories(){
		$query = $this->db->query("SELECT id,category_name FROM assets_category WHERE status = 'active'");
		return $query->result();
	}
	
	function check_cat_exist(){
		$parent_id = $this->input->post('parent_id');
		$subcategory_name = $this->input->post('subcategory_name');
		$query = $this->db->query("SELECT id FROM assets_subcategory WHERE parent_id = '" . (int)$parent_id . "' AND subcategory_name = '" . $subcategory_name . "'");
		if($query->num_rows()){
			return false; 
		}
		else{
			return true;
		}
	}

}
