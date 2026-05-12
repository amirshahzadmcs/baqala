<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deliveryboy {
	protected $CI;

	public function __construct() {
		$CI =& get_instance();
		if(!$CI->session->userdata('session_id')){
			$CI->session->set_userdata('session_id', md5(time().rand().time()));
		}
		if(!$CI->session->userdata('currency')){
			$this->setCurrency($id = 1);
		}
	}
	
	public function login($username, $password){
		$ip = $_SERVER['REMOTE_ADDR'];
        $login_time = CURRENT_TIME;
		$CI =& get_instance();
		$dboy_query = $CI->db->query("SELECT * FROM delivery_vehicles WHERE email = '" . $CI->db->escape_str($username) . "' AND password = '" . $password . "' AND status = '1'");
		if($dboy_query->num_rows()) {
			$row = $dboy_query->row();
			$status = $row->status;
			//echo '<pre>';print_r($row);'<pre>';exit();
			if($status == '1'){
				$CI->session->set_userdata('partner_id', $row->partner_id);
				$CI->session->set_userdata('deliveryboy_id', $row->id);
				$CI->session->set_userdata('deliveryboy_name', $row->name);
				$this->deliveryboy_id = $row->id;
				$CI->db->query("UPDATE delivery_vehicles SET ip = '" . $ip . "', last_login_at = '" . $login_time . "' WHERE id = '" . (int)$this->deliveryboy_id . "'");
				return 1;
			}else{
				return 2;
			}
		} else{
			return 0;
		}
	}
	
	public function isLogged(){
		$CI =& get_instance();
		//echo '<pre>';print_r($CI->session->userdata('deliveryboy_id'));'<pre>';exit();
		return (bool) $CI->session->userdata('deliveryboy_id');
	}
	
	public function logout() {
		$CI =& get_instance();			
		$CI->session->unset_userdata('partner_id');				
		$CI->session->unset_userdata('deliveryboy_id');				
		$CI->session->unset_userdata('deliveryboy_name');
		$this->deliveryboy_name = '';
	}
	
	public function getId(){
		$CI =& get_instance();
		$deliveryboy_id = $CI->session->userdata('deliveryboy_id');
		if (!empty($deliveryboy_id))
		{
			return (int)$deliveryboy_id;
		}
		else{
			return null;
		}
	}
	
	public function addSession(){
		$CI =& get_instance();
		$CI->session->set_userdata('session_id', md5(time().rand().time()));
	}
	
	public function getSessionId(){
		$CI =& get_instance();
		$session_id = $CI->session->userdata('session_id');
		if (!empty($session_id)){
			return $session_id;
		}
		return false;
	}
	
	public function getInfo(){
		$CI =& get_instance();
		$info = $CI->session->userdata('status_info');
		if (!empty($info)){
			return $info;
		}
		else{
		return null;
		}
	}
	
	public function removeInfo(){
		$CI =& get_instance();
		$CI->session->unset_userdata('status_info');
	}

	public function checkPassword($old){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM delivery_vehicles WHERE id = '" . $this->getId() . "' AND password = '" . $CI->db->escape_str($old) . "'");
		if($customer_query->num_rows()){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getToken($id){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM delivery_vehicles WHERE id = '". (int)$id ."'");
		foreach($customer_query->result() as $row){
			$this->token = $row->salt;
		}
		if ($this->token)
		{
			return $this->token;
		}
		else{
			return null;
		}
	}
}
