<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Region_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_regions SET region_name = '" . $this->db->escape_str($this->input->post('region_name')) . "', status = '" . (int)$this->input->post('status') . "', created_at = NOW(), updated_at = NOW()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_regions SET region_name = '" . $this->db->escape_str($this->input->post('region_name')) . "', status = '" . (int)$this->input->post('status') . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_list(){
		$query = $this->db->query("SELECT * FROM master_regions ORDER BY region_name ASC");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_regions WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_regions WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

}
