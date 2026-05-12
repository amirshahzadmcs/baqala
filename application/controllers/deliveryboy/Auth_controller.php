<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('deliveryboy/Auth_model');
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
			redirect('deliveryboy/common/login');
		}
	}
	*/
	public function index(){
		if($this->deliveryboy->isLogged()){
		    $this->load->helper('Common_helper');
			$data['result'] = $this->Auth_model->profile();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("delivery/layout/dashboard", $data);
		} else{
			redirect("delivery-partner/login");
		}
	}

	public function login(){
		$this->load->view('delivery/auth/login');
	}

	public function signup(){
		$this->session->unset_userdata('signup_email');	
		$this->load->view('delivery/auth/signup');
	}

	public function otp_verification(){
		if(!empty($this->session->userdata('signup_email'))){
			$this->load->view('delivery/auth/otp-verification');
		}else{
			$this->session->set_userdata('status_info', "2--Session Expired, Try Again");
			redirect('delivery-partner/registation');
		}
	}

	public function signup_password(){
		if($this->session->userdata('is_otp_verified')){
			$this->load->view('delivery/auth/password');
		}else{
			$this->session->set_userdata('status_info', "2--Session Expired, Try Again");
			redirect('delivery-partner/registation');
		}
	}

	public function submit_signup_email(){
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[delivery_vehicles.email]', array('is_unique' => 'This email is taken, try another.'));
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
			redirect('delivery-partner/registation');
		}
		else{
			$data['email'] = $this->input->post('email');
			$last_otp = $this->Auth_model->otp_timeout($data['email']);
			$current_time = CURRENT_TIME;
			if(!empty($last_otp)){
				$expiry_date = $last_otp->expired_at;
				$rest_time = (strtotime($expiry_date) - strtotime($current_time)) / 60;
			}else{
				$expiry_date = date('Y-m-d H:i:s', strtotime($current_time. ' -3 minute'));
				$rest_time = (strtotime($expiry_date) - strtotime($current_time)) / 60;
			}
			if(strtotime($expiry_date) > strtotime($current_time)){
				return $this->load->view("delivery/auth/otp-verification", $data);
			}else{
				$send_otp = $this->send_otp();
				$this->session->set_userdata('signup_email', $data['email']);
				return $this->load->view("delivery/auth/otp-verification", $data);
			}
		}
	}

	public function send_otp(){
		$otp = mt_rand(100000, 999999);
		$email = $this->input->post('email');
		$query = $this->Auth_model->resend_otp($otp, $email);
		if($query){
			$eSetting = $this->customer->emailSetting();
			$config = Array(
				'protocol' => $eSetting->protocol,
				'smtp_host' => $eSetting->smtp_host,
				'smtp_port' => $eSetting->smtp_port,
				'smtp_user' => $eSetting->smtp_user,
				'smtp_pass' => $eSetting->smtp_pass,
				'mailtype' => 'html'
			);
			$data = array(
    		    'otp' => $otp,
    		    'email' => $email,
    		);
    		$subject = 'Please use the OTP to verify your email address with Baqala Station.';
	        $message = $this->load->view("mail/otp-verification", $data, true);
			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from($eSetting->smtp_user, 'Baqala Station | Verification Mail');
			$this->email->to($this->input->post('email'));
			$this->email->subject($subject);
			$this->email->message($message);
			$send = $this->email->send();
		}
	}

	public function verify_otp(){
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
			redirect('delivery-partner/otp-verification');
		}
		else{
			$data['email'] = $this->input->post('email');
			$otp = $this->input->post('otp');
			$last_otp = $this->Auth_model->otp_timeout($data['email']);
			$current_time = CURRENT_TIME;
			$expiry_date = $last_otp->expired_at;
			//print_r ($expiry_date);exit();
			if(strtotime($expiry_date) < strtotime($current_time)){
				$this->session->set_userdata('status_info', "2--OTP Expired, Try again!");
				redirect('delivery-partner/otp-verification','refresh');
			}else{
				$is_verify = $this->Auth_model->otp_verify($data['email'],$otp);
				if($is_verify){
					$this->session->set_userdata('status_info', "1--'OTP successfully verified!");
					$this->session->set_userdata('is_otp_verified', 'true');
					return $this->load->view("delivery/auth/password", $data);
				}else{
					$this->session->set_userdata('status_info', "2--'OTP does not match!");
					redirect('delivery-partner/otp-verification','refresh');
				}
			}
		}
	}

	public function submit_registration(){
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[delivery_vehicles.email]', array('is_unique' => 'This email is taken, try another.'));
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
			redirect('delivery-partner/password');
		}
		else{
			$email = $this->input->post('email');
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			//print_r ($is_timeout->row());exit();
			$current_time = CURRENT_TIME;
			$query = $this->Auth_model->basic_registration($email,$hashpassword);
			if($query){
				$login = $this->deliveryboy->login($this->input->post('email'), $hashpassword);
				if($login == '1'){
					if($this->session->userdata("guest")){
						$this->session->unset_userdata("guest");
					}
					$this->session->set_userdata('status_info', "1--Thank you to join with us.");
					redirect('delivery-partner');
				}
				elseif($login == '2'){
					$this->session->set_userdata('status_info', "2--Account Deactive, Please Contact to admin.");
					redirect('delivery-partner/login');
				}else{
					$this->session->set_userdata('status_info', "2--Username or password did not match.");
					redirect('delivery-partner/login');
				}
			}	
		}
	}

	public function resend_otp(){
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
		if($this->form_validation->run()==FALSE){
			echo 'Session expired, go back and enter email.';exit();
		}
		else{
			$otp = mt_rand(100000, 999999);
			$email = $this->input->post('email');
			$last_otp = $this->Auth_model->otp_timeout($email);
			//print_r($is_timeout->row());exit();
			$current_time = CURRENT_TIME;
			$expiry_date = $last_otp->expired_at;
			$rest_time = (strtotime($expiry_date) - strtotime($current_time)) / 60;
			//$rest_in_sec = date('i:s', $rest_time);
			//print_r($rest_time * 60);exit();
			if(strtotime($expiry_date) > strtotime($current_time)){
				echo 'You can re-send otp after <span id="time">'. bcdiv($rest_time, 1, 2) .'</span> minutes.';
			}else{
				$query = $this->Auth_model->resend_otp($otp, $email);
				if($query){
					$eSetting = $this->customer->emailSetting();
					$config = Array(
						'protocol' => $eSetting->protocol,
						'smtp_host' => $eSetting->smtp_host,
						'smtp_port' => $eSetting->smtp_port,
						'smtp_user' => $eSetting->smtp_user,
						'smtp_pass' => $eSetting->smtp_pass,
						'mailtype' => 'html'
					);
					$data = array(
						'otp' => $otp,
						'email' => $email,
					);
					$subject = 'Please use the OTP to verify your email address with Baqala Station.';
					$message = $this->load->view("mail/otp-verification", $data, true);
					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->set_newline("\r\n");
					$this->email->from($eSetting->smtp_user, 'Baqala Station | Verification mail');
					$this->email->to($this->input->post('email'));
					$this->email->subject($subject);
					$this->email->message($message);
					$send = $this->email->send();
					echo 'OTP re-send successfully.';
				}
				else{
					echo 'Something went wrong, please contact to customer care.';
				}
			}
		}
	}
	
	public function submit_login(){
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
			redirect('delivery-partner/login');
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$login = $this->deliveryboy->login($this->input->post('email'), $hashpassword);
			if($login == '1'){
				if($this->session->userdata("guest")){
					$this->session->unset_userdata("guest");
				}
				$this->session->set_userdata('status_info', "1--Successfully Login");
				redirect('delivery-partner');
			}
			elseif($login == '2'){
				$this->session->set_userdata('status_info', "2--Account Deactive, Please Contact to admin.");
				redirect('delivery-partner/login');
			}else{
				$this->session->set_userdata('status_info', "2--Username or password did not match.");
				redirect('delivery-partner/login');
			}
		}
	}
	
	public function check_login(){
		//echo '<pre>'; print_r($_POST);die;
		if($this->deliveryboy->login($this->input->post('username'), $this->input->post('password'))){
			redirect('delivery-partner');
		}
		else{
			$this->session->set_userdata('status_info', "2--Wrong username or password!");
			redirect('delivery-partner/login');
		}
	}
	
	public function logout(){
		$t = $this->deliveryboy->logout();
		$this->session->set_userdata('status_info', "1--Successfully Logout");
		redirect('delivery-partner/login');
	}
	
	public function ForgotPassword(){
		$this->load->view('delivery/home/forgot_pasword');
	}
	
	public function sendPassword(){
		$email=$this->input->post('email');
		$email=$this->deliveryboy->sendPassword($email);

		echo '<pre>';print_r($email);exit;
	}
}
