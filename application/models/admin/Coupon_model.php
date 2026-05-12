<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon_model extends CI_Model{
	function add(){
		$query = $this->db->query("INSERT INTO coupons SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		max_price = '" . $this->db->escape_str($this->input->post('max_price')) . "', 
		min_price = '" . $this->db->escape_str($this->input->post('min_price')) . "', 
		type = '" . $this->db->escape_str($this->input->post('discount_type')) . "', 
		discount = '" . $this->db->escape_str($this->input->post('discount')) . "', 
		code = '" . $this->db->escape_str($this->input->post('coupon_code')) . "', 
		total_coupons = '" . $this->db->escape_str($this->input->post('total_coupons')) . "', 
		date_start = '" . $this->db->escape_str($this->input->post('date_start')) . "', 
		date_end = '" . $this->db->escape_str($this->input->post('date_end')) . "', 
		max_discount = '" . $this->db->escape_str($this->input->post('max_discount')) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		description2 = '" . $this->db->escape_str($this->input->post('description2')) . "', 
		created_at = '" . CURRENT_TIME ."', 
		status = '" . (int)$this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE coupons SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		max_price = '" . $this->db->escape_str($this->input->post('max_price')) . "', 
		min_price = '" . $this->db->escape_str($this->input->post('min_price')) . "', 
		type = '" . $this->db->escape_str($this->input->post('discount_type')) . "', 
		discount = '" . $this->db->escape_str($this->input->post('discount')) . "', 
		code = '" . $this->db->escape_str($this->input->post('coupon_code')) . "', 
		total_coupons = '" . $this->db->escape_str($this->input->post('total_coupons')) . "', 
		date_start = '" . $this->db->escape_str($this->input->post('date_start')) . "', 
		date_end = '" . $this->db->escape_str($this->input->post('date_end')) . "', 
		max_discount = '" . $this->db->escape_str($this->input->post('max_discount')) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		description2 = '" . $this->db->escape_str($this->input->post('description2')) . "', 
		status = '" . (int)$this->input->post('status') . "', 
		updated_at =  '" . CURRENT_TIME ."' 
		WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_coupons(){
		$query = $this->db->query("SELECT * FROM coupons ORDER BY id DESC");
		return $query->result_array();
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM coupons WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_coupon_detail($id){
		$query = $this->db->query("SELECT * FROM coupons WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
}
