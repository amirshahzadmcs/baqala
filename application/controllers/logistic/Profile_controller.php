<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->logistic->isLogged()){
			$this->load->model('logistic/Profile_model');
			$this->load->library('form_validation');
			$this->load->helper('cookie');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->library('session');
			$this->load->helper('Common_helper');
		} else{
			redirect("logistic-partner/login");
		}
	}

	public function change_password(){
		$data['result'] = $this->Profile_model->profile();
		//print_r($data);exit();
		$this->load->view('logistic/auth/change_password', $data);
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
			if($this->deliveryboy->checkPassword($hashpassword)){
				$query = $this->Profile_model->change_password_by_id($hashpassword_new);
				if($query){
					$this->session->set_flashdata('msg_info',"Password has been updated.");
					$this->session->set_flashdata('is_success','1');
					redirect("logout");
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
		redirect("logistic-partner/change-password");
	}

	public function profile(){
		$query = $this->Profile_model->get_detail()->row();
		$docs = $this->Profile_model->documents();
		$other_info = $this->Profile_model->partner_info();
		$bank_info = $this->Profile_model->bank_info();
		$rider_list = $this->Profile_model->rider_list();
		$commissions = $this->Profile_model->commssion_info();
		$data['id'] = $query->id;
		$data['customer_no'] = $query->customer_no;
		$data['name'] = $query->name;
		$data['mobile'] = $query->mobile;
		$data['email'] = $query->email;
		$data['status'] = $query->status;
		$data['company_name'] = $query->company_name;
		$data['company_arabic_name'] = $query->company_arabic_name;
		$data['business_nature'] = $query->business_nature;
		$data['account_manager'] = $query->account_manager;
		$data['company_type'] = $query->company_type;
		$data['client_telephone'] = $query->client_telephone;
		$data['client_fax'] = $query->client_fax;
		$data['cr_no'] = $query->cr_no;
		$data['cr_expiry'] = $query->cr_expiry;
		$data['vat_no'] = $query->vat_no;
		$data['vat_expiry'] = $query->vat_expiry;
		$data['agreement_start'] = $query->agreement_start;
		$data['agrement_expiry'] = $query->agrement_expiry;
		$data['application_status'] = $query->application_status;
		
		$data['partner_basic_status'] = $query->partner_basic_status;
		$data['partner_bank_status'] = $query->partner_bank_status;
		$data['partner_docs_status'] = $query->partner_docs_status;

		$data['other_info'] = $other_info;
		$data['documents'] = $docs;
		$data['bank_info'] = $bank_info;
		$data['rider_list'] = $rider_list;
		$data['commissions'] = $commissions;
		//print_r($data);exit();
		$this->load->view('logistic/pages/profile/profile', $data);
	}
}
