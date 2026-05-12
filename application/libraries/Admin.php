<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Admin {
	protected $CI;
	private $user_id;
	private $username;

	public function __construct() {
	
	}

	public function login($username, $password) {
		 $CI =& get_instance();
		$user_query = $CI->db->query("SELECT * FROM admin WHERE username = '" . $CI->db->escape_str($username) . "' AND password = md5('" . $CI->db->escape_str($password) . "')");

		if ($user_query->num_rows() == 1) {
			foreach($user_query->result() as $row){
				$CI->session->set_userdata('admin_id', $row->admin_id);
				$CI->session->set_userdata('admin_name', $row->name);
				$CI->session->set_userdata('login_employee_id', $row->employee_id);
				$CI->session->set_userdata('role', $row->role);
				return true;
			}
		} else {
			return false;
		}
	}
	
	function hasPrivilege($category = null) {
		$CI =& get_instance();
        $perm = trim($category);
        $logged_user_role = $CI->session->userdata('role');
        $logged_id = $CI->session->userdata('admin_id');
		$permission = $CI->db->query("SELECT ".$category." FROM admin WHERE admin_id = '" . $CI->db->escape_str((int)$logged_id) . "' AND role = '" . $CI->db->escape_str($logged_user_role) . "'")->row();
		if($logged_user_role == 'Admin' && $logged_id == 1) {
            return true;
        }elseif($logged_user_role !== 'Admin' && $logged_id !== '1' && $permission->$category == 1){
			//echo  "<pre>";print_r($permission);echo "</pre>";exit;
			return true;
		}else{
			return false;
		}
    }

	public function logout() {
		$CI =& get_instance();
		$CI->session->unset_userdata('admin_id');
		$CI->session->unset_userdata('admin_name');
		$CI->session->unset_userdata('login_employee_id');
		$CI->session->unset_userdata('role');
		$this->user_id = '';
		$this->username = '';
	}

	
	public function isLogged()
	{
		$CI =& get_instance();
		return (bool) $CI->session->userdata('admin_id');
	}

	/**
	 * logged_in
	 **/
	public function getId(){ 
		$CI =& get_instance();
		$user_id = $CI->session->userdata('admin_id');
		if (!empty($user_id)){
			return $user_id;
		}
		return null;
	}
	
	public function getLoginEmpId(){ 
		$CI =& get_instance();
		$login_id = $CI->session->userdata('login_employee_id');
		if (!empty($login_id)){
			return $login_id;
		}
		return null;
	}
	
	public function adminName($id) {
		$CI =& get_instance();
		if($id === 1){
			$user_name = $CI->db->query("SELECT name, email, image, username FROM admin WHERE admin_id = '" . $CI->db->escape_str($id) . "'")->row();
		}else{
			$user_name = $CI->db->query("SELECT admin.name, admin.email, admin.username, master_employee.employee_pic as image FROM admin LEFT JOIN master_employee ON (admin.employee_id = master_employee.id) WHERE admin.admin_id = '" . $CI->db->escape_str($id) . "'")->row();
		}
        return $user_name;
	}
	
	public function checkPassword($id, $password){
		 $CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM admin WHERE admin_id = '" . (int)$id . "' AND admin_password = md5('" . $CI->db->escape_str($password) . "')");
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

	public function getStatus(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM stock_request_status WHERE status = '1'")->result();
		return $query;
	}
	
	public function getWarehouseDetail(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM warehouse WHERE status = '1'")->row();
		return $query;
	}
	
	public function getBreadcrumbTree($id){
		$CI =& get_instance();
		$data['categories'] = array();
		$temp_parent = 0;
		$sql = $CI->db->query("SELECT branch_id, branch_name, code, main_account FROM chart_of_accounts WHERE branch_id = '" .$id."'");
		if($sql->num_rows() > 0){
			$query = $sql->row_array();
			$temp_parent = $query['main_account'];
			// $data['categories'] = array(
			// 	'id'     => $query['branch_id'],
			// 	'name'     => $query['branch_name'],
			// 	'code' => $query['code'],
			// 	'parent_id' => $query['main_account']
			// );
			for($i=0;$temp_parent > 0;$i++){
				$query_child = $CI->db->query("SELECT branch_id, branch_name, code, main_account FROM chart_of_accounts WHERE branch_id = '" .$temp_parent."'");
				if($query_child->num_rows() > 0){
					$query2 = $query_child->row_array();
					$temp_parent = $query2['main_account'];
					$data['categories'][] = array(
						'id'     => $query2['branch_id'],
						'name'     => $query2['branch_name'],
						'code' => $query2['code'],
						'parent_id' => $query2['main_account']
					);
				}
			}
		}
		return $data;
	}
}