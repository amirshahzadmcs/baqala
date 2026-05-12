<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offers_model extends CI_Model{
	function add(){
		$query = $this->db->query("INSERT INTO app_offer_banners SET offer_title = '" . $this->db->escape_str($this->input->post('offer_title')) . "', offer_sub_title = '" . $this->db->escape_str($this->input->post('offer_sub_title')) . "', offer_title_ar = '" . $this->db->escape_str($this->input->post('offer_title_ar')) . "', offer_sub_title_ar = '" . $this->db->escape_str($this->input->post('offer_sub_title_ar')) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', coupon_code = '" . $this->db->escape_str($this->input->post('coupon_code')) . "', offer_ends_on = '" . $this->db->escape_str($this->input->post('offer_ends_on')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "'");
		return $query;
	}
	function edit(){
		$query = $this->db->query("UPDATE app_offer_banners SET offer_title = '" . $this->db->escape_str($this->input->post('offer_title')) . "', offer_sub_title = '" . $this->db->escape_str($this->input->post('offer_sub_title')) . "', offer_title_ar = '" . $this->db->escape_str($this->input->post('offer_title_ar')) . "', offer_sub_title_ar = '" . $this->db->escape_str($this->input->post('offer_sub_title_ar')) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', coupon_code = '" . $this->db->escape_str($this->input->post('coupon_code')) . "', offer_ends_on = '" . $this->db->escape_str($this->input->post('offer_ends_on')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	function list(){
		$query = $this->db->query("SELECT * FROM app_offer_banners ORDER BY sort_order ASC");
		return $query;
	}
	function delete($id){
		$query = $this->db->query("DELETE FROM app_offer_banners WHERE id IN (" . $id . ")");
		return $query;
	}
	function detail($id){
		$query = $this->db->query("SELECT * FROM app_offer_banners WHERE id = '" . (int)$id . "'");
		return $query;
	}
}
