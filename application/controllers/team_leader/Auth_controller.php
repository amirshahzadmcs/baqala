<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('team_leader/Auth_model');
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->library('Enc_lib');
		$this->load->library('Role');
		$this->load->library('session');
	}

	public function index()
	{
		if ($this->teamleader->isLogged()) {
			$data['result'] = $this->Auth_model->profile();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$team_member=json_decode($this->db->get_where('hunger_team', ['team_leader' => $this->teamleader->getId()])->row()->team ?? '[]', true);
			$data['team'] = count($team_member);
			$data['today_shift'] = $this->db->where('DATE(date)', date('Y-m-d'))->where_in('rider_id',empty($team_member) ? [0] : $team_member)->group_by('id')->count_all_results('hunger_shift');
			$this->load->view("team_leader/layout/dashboard", $data);
		} else {
			redirect("team-leader/login");
		}
	}

	public function login()
	{
		$this->load->view('team_leader/auth/login');
	}

	public function submit_login()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('team-leader/login');
		} else {
			$login = $this->teamleader->login($this->input->post('username'), $this->input->post('password'));
			if ($login == '1') {
				if ($this->session->userdata("guest")) {
					$this->session->unset_userdata("guest");
				}
				$this->session->set_userdata('info', "1--Successfully Login");
				redirect('team-leader');
			} elseif ($login == '2') {
				$this->session->set_userdata('info', "2--Account Inactive, Please Contact to admin.");
				redirect('team-leader/login');
			} elseif ($login == '3') {
				$this->session->set_userdata('info', "2--Your Contract Expired, Please Contact to admin.");
				redirect('team-leader/login');
			} elseif ($login == '4') {
				$this->session->set_userdata('info', "2--Your Account Suspended, Please Contact to admin.");
				redirect('team-leader/login');
			}
			elseif ($login == '5') {
				$this->session->set_userdata('info', "2--Team Leader Not Found, Please Contact to admin.");
				redirect('team-leader/login');
			} else {
				$this->session->set_userdata('info', "2--Username or password did not match.");
				redirect('team-leader/login');
			}
		}
	}

	public function check_login()
	{
		//echo '<pre>'; print_r($_POST);die;
		if ($this->deliveryboy->login($this->input->post('username'), $this->input->post('password'))) {
			redirect('team-leader');
		} else {
			$this->session->set_userdata('info', "2--Wrong username or password!");
			redirect('team-leader/login');
		}
	}

	public function logout()
	{
		$t = $this->teamleader->logout();
		$this->session->set_userdata('info', "1--Successfully Logout");
		redirect('team-leader/login');
	}

	public function ForgotPassword()
	{
		$this->load->view('team_leader/home/forgot_pasword');
	}

	public function sendPassword()
	{
		$email = $this->input->post('email');
		$email = $this->teamleader->sendPassword($email);

		echo '<pre>';
		print_r($email);
		exit;
	}
}
