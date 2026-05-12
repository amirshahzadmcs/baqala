<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Newsletter_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO newsletter SET name = '" . $this->db->escape_str($this->input->post('name')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE newsletter SET name = '" . $this->db->escape_str($this->input->post('name')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_newsletter(){
		$query = $this->db->query("SELECT * FROM newsletter");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM newsletter WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_newsletter_by_id($id){
		$query = $this->db->query("SELECT * FROM newsletter WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
