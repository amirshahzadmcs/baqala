<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_city SET city_name = '" . $this->db->escape_str($this->input->post('city_name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', country_id = '" . $this->db->escape_str((int)$this->input->post('country_id')) . "', status = '" . (int)$this->input->post('status') . "', created_at = NOW(), updated_at = NOW()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_city SET city_name = '" . $this->db->escape_str($this->input->post('city_name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', country_id = '" . $this->db->escape_str((int)$this->input->post('country_id')) . "', status = '" . (int)$this->input->post('status') . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_cities(){
		$query = $this->db->query("SELECT master_city.*, master_country.name as country_name FROM master_city LEFT JOIN master_country ON (master_city.country_id = master_country.id) ORDER BY city_name ASC");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_city WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_city_by_id($id){
		$query = $this->db->query("SELECT * FROM master_city WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
