<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('agency/Auth_model');
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->library('Enc_lib');
		$this->load->library('Role');
		$this->load->library('session');
	}

	public function index(){
		if($this->agency->isLogged()){
			$data['total_cv'] = $this->db->query("SELECT count(id) as total FROM master_cv WHERE agency_name = '". (int)$this->agency->getId() ."'")->row_array();
			$data['shortlisted_cv'] = $this->db->query("SELECT count(id) as total FROM master_cv WHERE cv_status = 'shortlisted' AND agency_name = '". (int)$this->agency->getId() ."'")->row_array();
			$data['rejected_cv'] = $this->db->query("SELECT count(id) as total FROM master_cv WHERE interview_status = 'rejected' AND agency_name = '". (int)$this->agency->getId() ."'")->row_array();
			$data['hired'] = $this->db->query("SELECT count(id) as total FROM master_cv WHERE interview_status = 'selected' AND agency_name = '". (int)$this->agency->getId() ."'")->row_array();

			$data['result'] = $this->Auth_model->profile();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("agency/layout/dashboard", $data);
		} else{
			redirect("hiring-agency/login");
		}
	}

	public function login(){
		$this->load->view('agency/auth/login');
	}

	public function submit_login(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('msg_info', "2--".validation_errors());
			redirect('hiring-agency/login');
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$login = $this->agency->login($this->input->post('username'), $hashpassword);
			//print_r($login);exit();
			if($login == '1'){
				if($this->session->userdata("guest")){
					$this->session->unset_userdata("guest");
				}
				$this->session->set_userdata('msg_info', "1--Successfully Login");
				redirect('hiring-agency');
			}
			elseif($login == '2'){
				$this->session->set_userdata('msg_info', "2--Account Inactive, Please Contact to admin.");
				redirect('hiring-agency/login');
			}elseif($login == '3'){
				$this->session->set_userdata('msg_info', "2--Your Contract Expired, Please Contact to admin.");
				redirect('hiring-agency/login');
			}elseif($login == '4'){
				$this->session->set_userdata('msg_info', "2--Your Account Suspended, Please Contact to admin.");
				redirect('hiring-agency/login');
			}else{
				$this->session->set_userdata('msg_info', "2--Username or password did not match.");
				redirect('hiring-agency/login');
			}
		}
	}
	
	public function check_login(){
		//echo '<pre>'; print_r($_POST);die;
		if($this->deliveryboy->login($this->input->post('username'), $this->input->post('password'))){
			redirect('hiring-agency');
		}
		else{
			$this->session->set_userdata('msg_info', "2--Wrong username or password!");
			redirect('hiring-agency/login');
		}
	}
	
	public function logout(){
		$t = $this->agency->logout();
		$this->session->set_userdata('msg_info', "1--Successfully Logout");
		redirect('hiring-agency/login');
	}
	
	public function ForgotPassword(){
		$this->load->view('agency/home/forgot_pasword');
	}
	
	public function sendPassword(){
		$email=$this->input->post('email');
		$email=$this->agency->sendPassword($email);

		echo '<pre>';print_r($email);exit;
	}
}
