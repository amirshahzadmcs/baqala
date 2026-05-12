<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store {
	protected $CI;
	private $store_id;
	private $username;
	public function __construct() {
	}
	
	public function login($username, $password) {
		$CI =& get_instance();
		//print_r($password);exit();
		$user_query = $CI->db->query("SELECT * FROM stores WHERE store_id = '" . $CI->db->escape_str($username) . "' AND password = '" .$password. "'");

		if ($user_query->num_rows() == 1) {
			foreach($user_query->result() as $row)
			$CI->session->set_userdata('store_id', $row->id);
			$CI->session->set_userdata('username', $row->store_id);
			$CI->session->set_userdata('stores_name', $row->store_name);
			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		$CI =& get_instance();
		$CI->session->unset_userdata('store_id');
		$CI->session->unset_userdata('username');
		$CI->session->sess_destroy();
		$this->store_id = '';
		$this->username = '';
	}

	public function isLogged()
	{
		$CI =& get_instance();
		return (bool) $CI->session->userdata('store_id');
	}

	/**

	 * logged_in

	 *

	 * @return integer

	 * @author jrmadsen67

	 **/

	public function getId(){ 
		$CI =& get_instance();
		$store_id = $CI->session->userdata('store_id');
		if (!empty($store_id)){
			return $store_id;
		}
		return null;
	}

	public function checkPassword($id, $password){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM stores WHERE id = '" . (int)$id . "' AND password = '" . $password . "'");
		if ($query->num_rows()) {
			return true;
		}
		else{
			return false;
		}
	}

	public function getInfo(){
		$CI =& get_instance();
		$info = $CI->session->userdata('info');
		if (!empty($info)){
			return $info;
		}
		else{
			return null;
		}
	}

	public function removeInfo(){
		$CI =& get_instance();
		$CI->session->unset_userdata('info');
	}

}
