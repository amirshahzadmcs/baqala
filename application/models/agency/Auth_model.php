<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{
	
	public function profile(){
		$query = $this->db->query("SELECT * FROM hiring_agencies WHERE id = '" . (int)$this->agency->getId() . "'")->row();
		return $query;
	}
}
