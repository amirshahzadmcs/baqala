<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_plans SET plan_name = '" . $this->db->escape_str($this->input->post('plan_name')) . "', network_id = '" . $this->db->escape_str($this->input->post('network_id')) . "', sim_type = '" . $this->db->escape_str($this->input->post('sim_type')) . "', status = '" . (int)$this->input->post('status') . "', created_at = NOW(), updated_at = NOW()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_plans SET plan_name = '" . $this->db->escape_str($this->input->post('plan_name')) . "', network_id = '" . $this->db->escape_str($this->input->post('network_id')) . "', sim_type = '" . $this->db->escape_str($this->input->post('sim_type')) . "', status = '" . (int)$this->input->post('status') . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_list(){
		$query = $this->db->query("SELECT p.*, n.network_name FROM master_plans p LEFT JOIN master_network n ON n.id = p.network_id ORDER BY p.plan_name ASC");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_plans WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_plans WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function plans(){
		$query = $this->db->query("SELECT * FROM master_plans WHERE status = 1 ORDER BY plan_name ASC");
		return $query->result();
	}

}
