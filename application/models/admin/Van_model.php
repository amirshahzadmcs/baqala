<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Van_model extends CI_Model{

	function add($image, $icon, $car){
		$query = $this->db->query("INSERT INTO van SET icon = '" . $icon . "',car = '" . $car . "', van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', dname = '" . $this->db->escape_str($this->input->post('dname')) . "',parent_id = '" . $this->db->escape_str($this->input->post('parent_id')) . "',country = '" . $this->db->escape_str($this->input->post('country')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', driver_mo_no = '" . $this->db->escape_str($this->input->post('driver_mo_no')) . "', password = '" . $this->db->escape_str(md5($this->input->post('password'))) . "', image = '" . $image . "', validity = '" . $this->db->escape_str($this->input->post('validity')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', region = '" . $this->db->escape_str($this->input->post('region')) . "',charge = '" . $this->db->escape_str($this->input->post('charge')) . "', dcity = '" . $this->db->escape_str($this->input->post('dcity')) . "',area = '" . $this->db->escape_str($this->input->post('area')) . "',iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "',iqama_expiry = '" . $this->db->escape_str($this->input->post('iqama_expiry')) . "',car_ins_expiry = '" . $this->db->escape_str($this->input->post('car_ins_expiry')) . "',stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "',  status = '" . (int)$this->input->post('status') . "',created = NOW()");
		return $query;
	}
	
	function edit($image, $icon, $car){
		$query = $this->db->query("UPDATE van SET icon = '" . $icon . "',car = '" . $car . "', parent_id = '" . $this->db->escape_str($this->input->post('parent_id')) . "',van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', dname = '" . $this->db->escape_str($this->input->post('dname')) . "',country = '" . $this->db->escape_str($this->input->post('country')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', driver_mo_no = '" . $this->db->escape_str($this->input->post('driver_mo_no')) . "', password = '" . $this->db->escape_str(md5($this->input->post('password'))) . "', image = '" . $image . "', validity = '" . $this->db->escape_str($this->input->post('validity')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', region = '" . $this->db->escape_str($this->input->post('region')) . "',charge = '" . $this->db->escape_str($this->input->post('charge')) . "', dcity = '" . $this->db->escape_str($this->input->post('dcity')) . "',area = '" . $this->db->escape_str($this->input->post('area')) . "',iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "',iqama_expiry = '" . $this->db->escape_str($this->input->post('iqama_expiry')) . "',car_ins_expiry = '" . $this->db->escape_str($this->input->post('car_ins_expiry')) . "',stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "',  status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_category(){
		$parent_categories = $this->db->query("select * FROM van");
		return $parent_categories->result_array();
	}
	
	function get_consignment_by_dboy($id){
		$sql = "SELECT * FROM `consignments` WHERE van_id = '" . (int)$id . "'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `created_at` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `created_at` <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_order_by_ids($ids){
		$query = $this->db->query("SELECT id, invoice_prefix, collected_amt, payment_method, date_added, order_total, order_status_id, tracking, delivery_date, delivery_payment, d_charge, cancelreason FROM `orders` WHERE ID IN (" .$ids. ")");
		return $query->result();
	}
	
	function get_consig_id($id){
		$query = $this->db->query("SELECT * FROM `consignments` WHERE id ='" . $id . "'");	
		return $query->row();
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM van WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}
	function active_dboy_list(){
		$query = $this->db->query("SELECT id, dname, driver_mo_no FROM van WHERE status = '1'");
		return $query->result();
	}
	function get_deliverboy_mobile($id){
		$query = $this->db->query("SELECT driver_mo_no FROM van WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	function all_dboy_list(){
		$query = $this->db->query("SELECT id, dname, driver_mo_no FROM van WHERE 1 = 1");
		return $query->result();
	}
	function get_category_by_id($id){
		$query = $this->db->query("SELECT * FROM van WHERE id = '" . (int)$id . "'");
		return $query;
	}
	function get_partner_list(){
		$query = $this->db->query("SELECT id,cname FROM delivery_partner ");
		return $query->result();
	}
	function get_id($id){
		$query = $this->db->query("select node.name as node_name, node.arabic_name as arabic_name, node.id as node_id 
		, up1.name as up1_name
		, up2.name as up2_name
		, up3.name as up3_name  from van as node
		left outer 
		  join van as up1 
			on up1.id = node.parent_id  
		left outer 
		  join van as up2
			on up2.id = up1.parent_id  
		left outer 
		  join van as up3
			on up3.id = up2.parent_id
		WHERE node.id = '".$id."'
		order
		by node_name");
		return $query;
	}
	
	public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE van SET status = '1' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE van SET status = '0' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
}
