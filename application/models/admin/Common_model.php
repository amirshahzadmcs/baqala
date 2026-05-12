<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model{
	
	function get_customer($id){
		$query = $this->db->query("SELECT c.*, r.referral_code FROM customer c LEFT JOIN referrals r ON (c.id = r.user_id) WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
    function get_regions(){
		$query = $this->db->query("SELECT * FROM master_regions ORDER BY region_name ASC");
		return $query;
	}

    public function get_region_cities($id) {
		$query = $this->db->query("SELECT * FROM master_city where region_id=" . $id);
		return $query->result();
	}

	function get_cities(){
		$query = $this->db->query("SELECT master_city.*, master_regions.region_name FROM master_city LEFT JOIN master_regions ON (master_city.region_id = master_regions.id) ORDER BY city_name ASC");
		return $query;
	}

	function get_address($id){
		$query = $this->db->query("SELECT * FROM address WHERE customer_id = '" . (int)$id . "'");
		return $query;
	}

	function master_banks(){
		$query = $this->db->query("SELECT * FROM master_bank WHERE deleted = '0' ORDER BY bank_name ASC");
		return $query->result();
	}

	function color_list(){
		$query = $this->db->query("SELECT * FROM master_color WHERE deleted = '0' AND status = '1'")->result();
		return $query;
	}

	function area_list(){
		$query = $this->db->query("SELECT * FROM service_area WHERE deleted = '0' AND status = '1'")->result();
		return $query;
	}

	function profession_list(){
		$query = $this->db->query("SELECT * FROM master_profession WHERE deleted = '0' AND status = '1'")->result();
		return $query;
	}

	function logistic_partners(){
		$query = $this->db->query("SELECT * FROM delivery_partner WHERE status = '1' ORDER BY cname ASC")->result();
		return $query;
	}
}
