<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{
	
	public function profile(){
		$query = $this->db->query("SELECT * FROM delivery_partner WHERE id = '" . (int)$this->logistic->getId() . "'")->row();
		return $query;
	}
}
