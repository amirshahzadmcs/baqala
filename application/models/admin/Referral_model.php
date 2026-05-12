<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referral_model extends CI_Model{
	
	function add(){
		$query = $this->db->query("INSERT INTO referral_setting SET referral_type = '" . $this->input->post('referral_type') . "', heading_arabic = '" . $this->input->post('heading_arabic') . "', referral_charge = '" . $this->input->post('referral_charge') . "', refferer_amount = '" . $this->input->post('refferer_amount') . "',  content = '" . $this->input->post('content') . "', content_arabic = '" . $this->input->post('content_arabic') . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}

	function edit(){
		$query = $this->db->query("UPDATE referral_setting SET referral_type = '" . $this->input->post('referral_type') . "', heading_arabic = '" . $this->input->post('heading_arabic') . "', referral_charge = '" . $this->input->post('referral_charge') . "', refferer_amount = '" . $this->input->post('refferer_amount') . "', content = '" . $this->input->post('content') . "', content_arabic = '" . $this->input->post('content_arabic') . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM referral_setting WHERE id = '" . $id . "'");
		return $query;
	}
	
	function get_charge($id){
		$query = $this->db->query("SELECT * FROM referral_setting WHERE id = '" . $id . "'");
		return $query;
	}
	
	function get_list(){
		$query = $this->db->query("SELECT * FROM referral_setting");
		return $query->result();
	}
	
}

