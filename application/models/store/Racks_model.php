<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Racks_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO store_rack SET store_id = '" . (int)$this->store->getId() . "', rack_name = '" . $this->db->escape_str($this->input->post('rack_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE store_rack SET store_id = '" . (int)$this->store->getId() . "', rack_name = '" . $this->db->escape_str($this->input->post('rack_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM store_rack WHERE deleted = '0' AND store_id = '" . (int)$this->store->getId() . "'";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM store_rack WHERE deleted = '0' AND store_id = '" . (int)$this->store->getId() . "'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND rack_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY rack_name ". $_POST['order']['0']['dir'] ."";
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
		$this->db->from('store_rack');  
		$this->db->where('store_id', '" . (int)$this->store->getId() . "');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE store_rack SET deleted = 1 WHERE id IN (" . $id . ") AND store_id = '" . (int)$this->store->getId() . "'");
		return $query;
	}
	
	function get_store_rack_by_id($id){
		$query = $this->db->query("SELECT * FROM store_rack WHERE id = '" . (int)$id . "' AND store_id = '" . (int)$this->store->getId() . "'");
		return $query;
	}
    
    function check_duplicate_rack($id, $rack_name){
		$this->db->select("*");  
		$this->db->from('store_rack'); 
		$this->db->where('id !=',$id);
		$this->db->where('rack_name =',$rack_name);
		$this->db->where('store_id =', (int)$this->store->getId());
		return $this->db->count_all_results();  
	}
}
