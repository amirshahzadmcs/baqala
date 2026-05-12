<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->agency->isLogged()){
			$this->load->model('agency/Profile_model');
			$this->load->library('form_validation');
			$this->load->helper('cookie');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->library('session');
			$this->load->helper('Common_helper');
		} else{
			redirect("hiring-agency/login");
		}
	}

	public function change_password(){
		$data['result'] = $this->Profile_model->profile();
		//print_r($data);exit();
		$this->load->view('agency/auth/change_password', $data);
	}
	
	public function submit_change_password(){
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg_info',validation_errors());
			$this->session->set_flashdata('is_success','0');
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('old_password'));
			$hashpassword_new = $this->enc_lib->encrypt($this->input->post('new_password'));
			if($this->agency->checkPassword($hashpassword)){
				$query = $this->Profile_model->change_password_by_id($hashpassword_new);
				if($query){
					$this->session->set_flashdata('msg_info',"Password has been updated.");
					$this->session->set_flashdata('is_success','1');
					redirect("hiring-agency/logout");
				}
				else{
					$this->session->set_flashdata('msg_info',"Some Error occures!!!");
					$this->session->set_flashdata('is_success','0');
				}
			}
			else{
				$this->session->set_flashdata('msg_info',"Your old password is not correct.");
				$this->session->set_flashdata('is_success','0');
			}
		}
		redirect("hiring-agency/change-password");
	}
	
	public function profile(){
		$data['result'] = $this->Profile_model->profile();
		//print_r($data);exit();
		$this->load->view('agency/auth/profile', $data);
	}
}
