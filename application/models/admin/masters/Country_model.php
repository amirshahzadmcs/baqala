<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Country_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_country SET name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', status = '" . (int)$this->input->post('status') . "', created_at = NOW(), updated_at = NOW()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_country SET name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', status = '" . (int)$this->input->post('status') . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function country_list(){
		$query = $this->db->query("SELECT * FROM master_country ORDER BY name ASC");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_country WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_country WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
