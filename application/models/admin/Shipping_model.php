<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shipping_model extends CI_Model{
	
	function add(){
		$query = $this->db->query("INSERT INTO shipping_charge SET name = '" . $this->input->post('name') . "', start_price = '" . $this->input->post('start_price') . "', end_price = '" . $this->input->post('end_price') . "', amount = '" . $this->input->post('amount') . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}

	function edit(){
		$query = $this->db->query("UPDATE shipping_charge SET name = '" . $this->input->post('name') . "', start_price = '" . $this->input->post('start_price') . "', end_price = '" . $this->input->post('end_price') . "', amount = '" . $this->input->post('amount') . "', status = '" . $this->input->post('status') . "' WHERE shipping_charge_id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM shipping_charge WHERE shipping_charge_id = '" . $id . "'");
		return $query;
	}
	
	function get_shipping_charge($id){
		$query = $this->db->query("SELECT * FROM shipping_charge WHERE shipping_charge_id = '" . $id . "'");
		return $query;
	}
	
	function get_shipping_charges(){
		$query = $this->db->query("SELECT * FROM shipping_charge");
		return $query;
	}
	
}

