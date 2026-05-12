<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model{
	
	public function profile(){
		$query = $this->db->query("SELECT * FROM hiring_agencies WHERE id = '" . (int)$this->agency->getId() . "'")->row();
		return $query;
	}
	
	function change_password_by_id($password){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE hiring_agencies SET password = '" . $password . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE id = '" . (int)$this->agency->getId() . "'");
		return $query;
	}
}
