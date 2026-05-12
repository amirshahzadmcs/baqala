<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model{
	
	public function profile(){
		$query = $this->db->query("SELECT * FROM delivery_partner WHERE id = '" . (int)$this->logistic->getId() . "'")->row();
		return $query;
	}

	public function get_detail()
    {
        $query = $this->db->query("SELECT dp.* FROM delivery_partner dp WHERE dp.id = '" . (int)$this->logistic->getId() . "'");
        return $query;
    }

	public function documents(){
		$query = $this->db->query("SELECT * FROM del_partner_docs WHERE partner_id = '" . (int)$this->logistic->getId() . "'")->row();
		return $query;
	}

	public function partner_info(){
		$query = $this->db->query("SELECT * FROM del_partner_info WHERE partner_id = '" . (int)$this->logistic->getId() . "'")->row_array();
		return $query;
	}

	public function bank_info(){
		$query = $this->db->query("SELECT * FROM del_partner_bank WHERE partner_id = '" . (int)$this->logistic->getId() . "'")->row();
		return $query;
	}
    
	public function commssion_info(){
		$query = $this->db->query("SELECT * FROM logistic_commission_structure WHERE partner_id = '" . (int)$this->logistic->getId() . "'")->result_array();
		return $query;
	}

    public function rider_list(){
		$query = $this->db->query("SELECT * FROM delivery_vehicles WHERE partner_id = '" . (int)$this->logistic->getId() . "'")->result();
		return $query;
	}
}
