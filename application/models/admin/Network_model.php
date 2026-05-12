<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Network_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_network SET network_name = '" . $this->db->escape_str($this->input->post('network_name')) . "', status = '" . (int)$this->input->post('status') . "', created_at = NOW(), updated_at = NOW()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_network SET network_name = '" . $this->db->escape_str($this->input->post('network_name')) . "', status = '" . (int)$this->input->post('status') . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_list(){
		$query = $this->db->query("SELECT * FROM master_network ORDER BY network_name ASC");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_network WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_network WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function networks(){
		$query = $this->db->query("SELECT * FROM master_network WHERE status = '1' ORDER BY network_name ASC");
		return $query->result();
	}

}
