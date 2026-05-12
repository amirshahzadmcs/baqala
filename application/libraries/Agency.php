<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agency {
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
		$dboy_query = $CI->db->query("SELECT * FROM hiring_agencies WHERE user_id = '" . $CI->db->escape_str($username) . "' AND password = '" . $password . "' AND status > 0");
		
		if($dboy_query->num_rows()) {
			$row = $dboy_query->row();
			$status = $row->status;
			//echo '<pre>';print_r($row);'<pre>';exit();
			if($status == '1'){
				$CI->session->set_userdata('agency_id', $row->id);
				$CI->session->set_userdata('agency_name', $row->agency_name);
				$CI->session->set_userdata('agency_name_ar', $row->agency_name_ar);
				$this->logistic_id = $row->id;
				$CI->db->query("UPDATE hiring_agencies SET ip = '" . $ip . "', last_login_at = '" . $login_time . "' WHERE id = '" . (int)$this->logistic_id . "'");
				return 1;
			}elseif($status == '2'){
				return 2;
			}elseif($status == '3'){
				return 3;
			}elseif($status == '4'){
				return 4;
			}else{
				return 5;
			}
		}else{
			return 0;
		}
	}
	
	public function isLogged(){
		$CI =& get_instance();
		//echo '<pre>';print_r($CI->session->userdata('deliveryboy_id'));'<pre>';exit();
		return (bool) $CI->session->userdata('agency_id');
	}
	
	public function logout() {
		$CI =& get_instance();			
		$CI->session->unset_userdata('agency_id');				
		$CI->session->unset_userdata('agency_name');
		$CI->session->unset_userdata('agency_name_ar');
		$this->agency_name = '';
	}
	
	public function getId(){
		$CI =& get_instance();
		$agency_id = $CI->session->userdata('agency_id');
		if (!empty($agency_id))
		{
			return (int)$agency_id;
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
		$customer_query = $CI->db->query("SELECT * FROM hiring_agencies WHERE id = '" . $this->getId() . "' AND password = '" . $CI->db->escape_str($old) . "'");
		if($customer_query->num_rows()){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getToken($id){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM hiring_agencies WHERE id = '". (int)$id ."'");
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
