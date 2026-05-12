<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logistic {
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
		$dboy_query = $CI->db->query("SELECT * FROM delivery_partner WHERE cr_no = '" . $CI->db->escape_str($username) . "' AND password = '" . $password . "' AND status = '1'");
		
		if($dboy_query->num_rows()) {
			$row = $dboy_query->row();
			$status = $row->status;
			$application_status = $row->application_status;
			//echo '<pre>';print_r($row);'<pre>';exit();
			if($application_status == 'verified'){
				if($status == '1'){
					$CI->session->set_userdata('logistic_id', $row->id);
					$CI->session->set_userdata('logistic_name', $row->company_name);
					$CI->session->set_userdata('logistic_name_ar', $row->company_arabic_name);
					$this->logistic_id = $row->id;
					$CI->db->query("UPDATE delivery_partner SET ip = '" . $ip . "', last_login_at = '" . $login_time . "' WHERE id = '" . (int)$this->logistic_id . "'");
					return 1;
				}else{
					return 2;
				}
			}else{
				return 3;
			}
		}else{
			return 0;
		}
	}
	
	public function isLogged(){
		$CI =& get_instance();
		//echo '<pre>';print_r($CI->session->userdata('deliveryboy_id'));'<pre>';exit();
		return (bool) $CI->session->userdata('logistic_id');
	}
	
	public function logout() {
		$CI =& get_instance();			
		$CI->session->unset_userdata('logistic_id');				
		$CI->session->unset_userdata('logistic_name');
		$CI->session->unset_userdata('logistic_name_ar');
		$this->logistic_name = '';
	}
	
	public function getId(){
		$CI =& get_instance();
		$logistic_id = $CI->session->userdata('logistic_id');
		if (!empty($logistic_id))
		{
			return (int)$logistic_id;
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
		$info = $CI->session->userdata('msg_info');
		if (!empty($info)){
			return $info;
		}
		else{
			return null;
		}
	}
	
	public function removeInfo(){
		$CI =& get_instance();
		$CI->session->unset_userdata('msg_info');
	}

	public function checkPassword($old){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM delivery_partner WHERE id = '" . $this->getId() . "' AND password = '" . $CI->db->escape_str($old) . "'");
		if($customer_query->num_rows()){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getToken($id){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM delivery_partner WHERE id = '". (int)$id ."'");
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
