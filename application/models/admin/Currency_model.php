<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO currency SET name = '" . $this->db->escape_str($this->input->post('name')) . "', price = '" . $this->db->escape_str($this->input->post('price')) . "', icon = '" . $this->db->escape_str($this->input->post('icon')) . "', status = '" . (int)$this->input->post('status') . "', created = NOW()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE currency SET name = '" . $this->db->escape_str($this->input->post('name')) . "', price = '" . $this->db->escape_str($this->input->post('price')) . "', icon = '" . $this->db->escape_str($this->input->post('icon')) . "', status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_currencies(){
		$query = $this->db->query("SELECT * FROM currency");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM currency WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_currency_by_id($id){
		$query = $this->db->query("SELECT * FROM currency WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
