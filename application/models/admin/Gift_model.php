<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gift_model extends CI_Model{

	function edit(){
		$query = $this->db->query("UPDATE gift_cards SET voucher_name = '" . $this->input->post('voucher_name') . "', voucher_code = '" . $this->input->post('voucher_code') . "', voucher_value = '" . $this->input->post('voucher_value') . "', expiry_date = '" . $this->input->post('expiry_date') . "', g_status = '" . $this->input->post('g_status') . "', is_used = '" . $this->input->post('is_used') . "', updated_at = now() WHERE g_id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM gift_cards WHERE g_id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM gift_cards WHERE g_id = '" . $id . "'");
		return $query;
	}
	
	function get_list(){
		$query = $this->db->query("SELECT gc.*, c.email, o.order_total, o.invoice_prefix FROM gift_cards gc LEFT JOIN customer c ON (c.id = gc.user_id) LEFT JOIN orders o ON (o.id = gc.order_id)");
		return $query->result();
	}
	
	public function setStatusEnable() {
	    $query = $this->db->query("UPDATE gift_cards SET g_status = '1', updated_at = NOW() WHERE g_id >= '" . $this->input->post('from') . "' AND g_id <='" . $this->input->post('to')  . "'");
	    return $query;
	}
	
	public function setStatusDisable() {
	    $query = $this->db->query("UPDATE gift_cards SET g_status = '0', updated_at = NOW() WHERE g_id >= '" . $this->input->post('from') . "' AND g_id <='" . $this->input->post('to')  . "'");
	    return $query;
	}
	
	function total_gift(){
		$this->db->select("*");  
		$this->db->from('gift_cards');  
		return $this->db->count_all_results();  
	} 
	
	function active_gift(){
		$this->db->select("*");  
		$this->db->from('gift_cards');
		$this->db->where('g_status','1');
		return $this->db->count_all_results();  
	}
	
	function deactive_gift(){
		$this->db->select("*");  
		$this->db->from('gift_cards');
		$this->db->where('g_status','0');
		return $this->db->count_all_results();  
	} 
	
	function used_gift(){
		$this->db->select("*");  
		$this->db->from('gift_cards');
		$this->db->where('is_g_used','1');
		return $this->db->count_all_results();  
	} 
	
	function unused_gift(){
		$this->db->select("*");  
		$this->db->from('gift_cards'); 
		$this->db->where('is_g_used','0');
		return $this->db->count_all_results();  
	} 
	
	function duplicate_gift(){
		$query = $this->db->query("SELECT g_code, COUNT(g_code) FROM gift_cards GROUP BY g_code HAVING COUNT(g_code) > 1")->result_array();
		return $query;  
	}
	
}

