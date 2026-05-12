<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('agency/Auth_model');
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->library('Enc_lib');
		$this->load->library('Role');
		$this->load->library('session');
	}

	public function index()
	{
		if ($this->gatekeeper->isLogged()) {
			$data['result'] = $this->Auth_model->profile();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$data['today_entries'] = count($this->db->where('DATE(created_at)', date('Y-m-d'))->get('vehicle_timesheets')->result());
			$data['total_entries'] = count($this->db->get('vehicle_timesheets')->result());
			$this->load->view("gate_keeper/layout/dashboard", $data);
		} else {
			redirect("gate-keeper/login");
		}
	}

	public function login()
	{
		$this->load->view('gate_keeper/auth/login');
	}

	public function submit_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('gate-keeper/login');
		} else {
			$login = $this->gatekeeper->login($this->input->post('username'), $this->input->post('password'));
			//print_r($login);exit();
			if ($login == '1') {
				if ($this->session->userdata("guest")) {
					$this->session->unset_userdata("guest");
				}
				$this->session->set_userdata('info', "1--Successfully Login");
				redirect('gate-keeper');
			} elseif ($login == '2') {
				$this->session->set_userdata('info', "2--Account Inactive, Please Contact to admin.");
				redirect('gate-keeper/login');
			} elseif ($login == '3') {
				$this->session->set_userdata('info', "2--Your Contract Expired, Please Contact to admin.");
				redirect('gate-keeper/login');
			} elseif ($login == '4') {
				$this->session->set_userdata('info', "2--Your Account Suspended, Please Contact to admin.");
				redirect('gate-keeper/login');
			} else {
				$this->session->set_userdata('info', "2--Username or password did not match.");
				redirect('gate-keeper/login');
			}
		}
	}

	public function check_login()
	{
		//echo '<pre>'; print_r($_POST);die;
		if ($this->deliveryboy->login($this->input->post('username'), $this->input->post('password'))) {
			redirect('gate_keeper');
		} else {
			$this->session->set_userdata('info', "2--Wrong username or password!");
			redirect('gate_keeper/login');
		}
	}

	public function logout()
	{
		$t = $this->gatekeeper->logout();
		$this->session->set_userdata('info', "1--Successfully Logout");
		redirect('gate-keeper/login');
	}

	public function ForgotPassword()
	{
		$this->load->view('gate_keeper/home/forgot_pasword');
	}

	public function sendPassword()
	{
		$email = $this->input->post('email');
		$email = $this->gatekeeper->sendPassword($email);

		echo '<pre>';
		print_r($email);
		exit;
	}
}
