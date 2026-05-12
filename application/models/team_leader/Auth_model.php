<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{
	
	public function profile(){
		$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . (int)$this->teamleader->getId() . "'")->row();
		return $query;
	}
}
