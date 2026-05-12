<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shelf_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO admin_product_shelf SET rack_id = '" . (int)$this->input->post('rack_id') . "', shelf_name = '" . $this->db->escape_str($this->input->post('shelf_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE admin_product_shelf SET rack_id = '" . (int)$this->input->post('rack_id') . "', shelf_name = '" . $this->db->escape_str($this->input->post('shelf_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM admin_product_shelf WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT rs.*, IF (rs.rack_id > 0, r.rack_name,'') AS rack_name, (select count(ps.id) from product_size ps where rs.id = ps.shelf) as total_products FROM admin_product_shelf rs JOIN admin_product_rack r ON (r.id = rs.rack_id) WHERE rs.deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND shelf_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY shelf_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY shelf_name ASC";		   
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
		$this->db->from('admin_product_shelf');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE admin_product_shelf SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_product_shelf_by_id($id){
		$query = $this->db->query("SELECT * FROM admin_product_shelf WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_racks(){
		$query = $this->db->query("SELECT id,rack_name FROM admin_product_rack WHERE status = 1 AND deleted = '0'");
		return $query->result();
	}
	
	function check_shelf_exist(){
		$rack = $this->input->post('rack_id');
		$shelf = $this->input->post('shelf_name');
		$query = $this->db->query("SELECT id FROM admin_product_shelf WHERE rack_id = '" . (int)$rack . "' AND shelf_name = '" . $shelf . "'");
		if($query->num_rows()){
			return false; 
		}
		else{
			return true;
		}
	}

}
