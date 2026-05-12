<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Export_model extends CI_Model {
	
	function export_order($id){
		$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, db.dname as db_name, db.driver_mo_no as db_mob, om.order_image FROM `orders` o LEFT JOIN van db ON(o.delivery_boy = db.id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) WHERE o.id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getId() . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "'")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}  
	
	function export_quotation($id){
		$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, ad.name as associate_name, ad.username as associate_username, om.order_image FROM `quotation` o LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) WHERE o.id = '" . (int)$id . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM quotation_product WHERE quotation_id = '" . (int)$id . "' ORDER BY id ASC")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}  
	
}

