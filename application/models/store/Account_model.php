<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model{
	
	public function get_profile(){
		$query = $this->db->query("SELECT * FROM stores WHERE id = '" . (int)$this->store->getId() . "'")->row();
		return $query;
	}
	
	function store_documents(){
		$query = $this->db->query("SELECT * FROM store_docs WHERE store_id = '" . (int)$this->store->getId() . "'");
		return $query->row();
	}
	
	function store_bank_account(){
		$query = $this->db->query("SELECT * FROM store_bank_account WHERE store_id = '" . (int)$this->store->getId() . "'");
		return $query->row();
	}

	function add_customer(){
		$this->load->helper('string');
		$query = $this->db->query("INSERT INTO users SET name = '" . $this->db->escape_str($this->input->post('name')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', salt = '" . $this->db->escape_str($salt = random_string('alnum', 20)) . "', password = '" . $this->db->escape_str(sha1($salt . sha1($salt . sha1($this->input->post('password'))))) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', status = 1, is_email_verified = 1, created = NOW(), modified = NOW()");
		return $query;
		/* @TODO Mail and SmS */
	}
	
	function edit_customer(){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE users SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', gender = '" . $this->db->escape_str($this->input->post('gender')) . "', modified = NOW() WHERE id = '" . (int)$this->customer->getId() . "'");
		return $query;
	}
	
	function change_password_by_id($id,$password){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE stores SET salt = '" . $this->db->escape_str($salt = random_string('alnum', 20)) . "', password = '" . $password . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function mail_password(){
		return true;
		/* @TODO Mail */
	}
	
	function new_password(){
		return true;
	}
	
	function firm_exists($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('company');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function get_firm(){
		$query = $this->db->query("SELECT * FROM company WHERE id = '" . (int)$this->company->getId() . "'")->row();
		return $query;
	}
	
	public function get_firm_by_id($id){
		$query = $this->db->query("SELECT * FROM company WHERE id = '" . (int)$id . "'")->row();
		return $query;
	}
	
	public function get_customer_by_email($email=''){
		$query = $this->db->query("SELECT * FROM customer WHERE email = '" . $email. "'");
		return $query;
	}
	
}
