<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Racks_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO admin_product_rack SET rack_name = '" . $this->db->escape_str($this->input->post('rack_name')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE admin_product_rack SET rack_name = '" . $this->db->escape_str($this->input->post('rack_name')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM admin_product_rack WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT pr.*, (select count(ps.id) from product_size ps where pr.id = ps.rack) as total_products FROM admin_product_rack pr WHERE pr.deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND pr.rack_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY pr.rack_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY pr.rack_name ASC";		   
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
		$this->db->from('admin_product_rack');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE admin_product_rack SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_product_rack_by_id($id){
		$query = $this->db->query("SELECT * FROM admin_product_rack WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
