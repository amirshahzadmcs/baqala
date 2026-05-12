<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('logistic/Auth_model');
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->library('Enc_lib');
		$this->load->library('Role');
		$this->load->library('session');
	}

	/*
	public function index(){
		if($this->deliveryboy->isLogged()){
		    $id = $this->session->userdata('deliveryboy_id');
			$this->load->model('deliveryboy/Order_delivered_model');
		    $data['orders'] = $this->Order_delivered_model->get_status_by_dboy($id);
			$data['coming_order'] = $this->Order_delivered_model->upcoming_delivery($id);
			$data['total_delv_earn'] = $this->Order_delivered_model->total_delv_earnings($id);
			$data['todays_earning'] = $this->Order_delivered_model->todays_earnings($id);
			$data['dcharge'] = $this->Order_delivered_model->deliver_charge($id);
			$data['ontime_delivery'] = $this->Order_delivered_model->ontime_delivery($id);
			$data['delay_delivery'] = $this->Order_delivered_model->delay_delivery($id);
			//echo '<pre>';print_r($data['ontime_delivery']);'<pre>';exit();
			$this->load->view('delivery/home/dashboard', $data);	
		}
		else{
			redirect('logistic/common/login');
		}
	}
	*/
	public function index(){
		if($this->logistic->isLogged()){
			$data['result'] = $this->Auth_model->profile();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("logistic/layout/dashboard", $data);
		} else{
			redirect("logistic-partner/login");
		}
	}

	public function login(){
		$this->load->view('logistic/auth/login');
	}

	public function submit_login(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('msg_info', "2--".validation_errors());
			redirect('logistic-partner/login');
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$login = $this->logistic->login($this->input->post('username'), $hashpassword);
			if($login == '1'){
				if($this->session->userdata("guest")){
					$this->session->unset_userdata("guest");
				}
				$this->session->set_userdata('msg_info', "1--Successfully Login");
				redirect('logistic-partner');
			}
			elseif($login == '2'){
				$this->session->set_userdata('msg_info', "2--Account Deactive, Please Contact to admin.");
				redirect('logistic-partner/login');
			}elseif($login == '3'){
				$this->session->set_userdata('msg_info', "2--Your account is under review, Please wait till approved.");
				redirect('logistic-partner/login');
			}else{
				$this->session->set_userdata('msg_info', "2--Username or password did not match.");
				redirect('logistic-partner/login');
			}
		}
	}
	
	public function check_login(){
		//echo '<pre>'; print_r($_POST);die;
		if($this->deliveryboy->login($this->input->post('username'), $this->input->post('password'))){
			redirect('logistic-partner');
		}
		else{
			$this->session->set_userdata('msg_info', "2--Wrong username or password!");
			redirect('logistic-partner/login');
		}
	}
	
	public function logout(){
		$t = $this->logistic->logout();
		$this->session->set_userdata('msg_info', "1--Successfully Logout");
		redirect('logistic-partner/login');
	}
	
	public function ForgotPassword(){
		$this->load->view('delivery/home/forgot_pasword');
	}
	
	public function sendPassword(){
		$email=$this->input->post('email');
		$email=$this->logistic->sendPassword($email);

		echo '<pre>';print_r($email);exit;
	}
}
