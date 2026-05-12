<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shelf_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO store_shelf SET store_id = '" . (int)$this->store->getId() . "', rack_id = '" . (int)$this->input->post('rack_id') . "', shelf_name = '" . $this->db->escape_str($this->input->post('shelf_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE store_shelf SET store_id = '" . (int)$this->store->getId() . "', rack_id = '" . (int)$this->input->post('rack_id') . "', shelf_name = '" . $this->db->escape_str($this->input->post('shelf_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM store_shelf WHERE deleted = '0' AND store_id = '" . (int)$this->store->getId() . "'";
		return $a;
	}

	function get_list(){
		$a = "SELECT rs.*, IF (rs.rack_id > 0, r.rack_name,'') AS rack_name FROM store_shelf rs JOIN product_rack r ON (r.id = rs.rack_id) WHERE rs.deleted = '0' AND rs.store_id = '" . (int)$this->store->getId() . "'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND rs.shelf_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY rs.shelf_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY rs.created_at DESC";		   
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
		$this->db->from('store_shelf');
		//$this->db->where('store_id', '" . (int)$this->store->getId() . "');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE store_shelf SET deleted = 1 WHERE id IN (" . $id . ") AND store_id = '" . (int)$this->store->getId() . "'");
		return $query;
	}
	
	function get_product_shelf_by_id($id){
		$query = $this->db->query("SELECT * FROM store_shelf WHERE id = '" . (int)$id . "' AND store_id = '" . (int)$this->store->getId() . "'");
		return $query;
	}
	
	function get_racks(){
		$query = $this->db->query("SELECT id,rack_name,store_id FROM store_rack WHERE status = 1 AND deleted = '0' AND store_id = '" . (int)$this->store->getId() . "'");
		return $query->result();
	}
	
	function check_duplicate_shelf($id, $rack_id, $shelf_name){
		$this->db->select("*");  
		$this->db->from('store_shelf'); 
		$this->db->where('id !=',$id);
		$this->db->where('rack_id =',$rack_id);
		$this->db->where('shelf_name =',$shelf_name);
		$this->db->where('store_id =', (int)$this->store->getId());
		return $this->db->count_all_results();  
	}

}
