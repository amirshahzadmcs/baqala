<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

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

	public function login(){
		$this->load->view('delivery/home/login');
	}
	
	public function change_password(){
		$this->load->view('admin/home/change_password');
	}
	
	public function account(){
		if($this->deliveryboy->isLogged()){
			$this->load->model('deliveryboy/Order_delivered_model');
			$id = $this->session->userdata('deliveryboy_id');
			$data['profile'] = $this->Order_delivered_model->get_detail($id);
			$this->load->view('delivery/home/account', $data);
		}
		else{
			redirect('deliveryboy/common/login');
		}
	}
	
	public function check_login(){
		//echo '<pre>'; print_r($_POST);die;
		if($this->deliveryboy->login($this->input->post('username'), $this->input->post('password'))){
			redirect('deliveryboy/common');
		}
		else{
			$this->session->set_userdata('info', "2--Wrong username or password!");
			redirect('deliveryboy/common/login');
		}
	}
	
	public function logout(){
		$t = $this->admin->logout();
		redirect('deliveryboy/common/login');
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