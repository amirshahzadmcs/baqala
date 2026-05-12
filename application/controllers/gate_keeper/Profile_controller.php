<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->gatekeeper->isLogged()) {
			$this->load->library('form_validation');
			$this->load->helper('cookie');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->library('session');
			$this->load->helper('Common_helper');
		} else {
			redirect("gete_keeper/login");
		}
	}

	public function change_password()
	{
		$data['result'] = $this->db->get_where('master_employee', ['id' => $this->gatekeeper->getId()])->row();
		// print_r($data);exit();
		$this->load->view('gate_keeper/auth/change_password', $data);
	}

	public function submit_change_password()
	{
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('info', "2--" . validation_errors());
		} else {
			$hashpassword = $this->enc_lib->encrypt($this->input->post('old_password'));
			$hashpassword_new = $this->enc_lib->encrypt($this->input->post('new_password'));
			if ($this->gatekeeper->checkPassword($hashpassword)) {
				$query = $this->db->update(
					'master_employee',
					[
						'password' => $hashpassword_new
					],
					['id' => $this->gatekeeper->getId()]
				);
				if ($query) {
					$this->session->set_flashdata('info', "1--Password has been updated.");
					redirect("gate-keeper/change-password");
				} else {
					$this->session->set_flashdata('info', "2--Some Error occures!!!");
					$this->session->set_flashdata('is_success', '0');
				}
			} else {
				$this->session->set_flashdata('info', "2--Your old password is not correct.");
				$this->session->set_flashdata('is_success', '0');
			}
		}
		redirect("gate-keeper/change-password");
	}

	public function profile()
	{
		$data['result'] = employeeDetailHelper($this->gatekeeper->getId());
		// echo '<pre>';
		// print_r($data);exit();
		$this->load->view('gate_keeper/auth/profile', $data);
	}
}
