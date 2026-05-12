<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expshipping_model extends CI_Model{
	
	function add(){
		$query = $this->db->query("INSERT INTO express_delivery_charge SET shipping_type = '" . $this->input->post('shipping_type') . "', express_charge = '" . $this->input->post('express_charge') . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}

	function edit(){
		$query = $this->db->query("UPDATE express_delivery_charge SET shipping_type = '" . $this->input->post('shipping_type') . "', express_charge = '" . $this->input->post('express_charge') . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM express_delivery_charge WHERE id = '" . $id . "'");
		return $query;
	}
	
	function get_shipping_charge($id){
		$query = $this->db->query("SELECT * FROM express_delivery_charge WHERE id = '" . $id . "'");
		return $query;
	}
	
	function get_shipping_charges(){
		$query = $this->db->query("SELECT * FROM express_delivery_charge");
		return $query;
	}
	
}

