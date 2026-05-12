<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referral extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
		$this->load->model('admin/Referral_model');
		$this->load->library('form_validation');
	}
		
	public function index(){		
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['list'] = $this->Referral_model->get_list(); 
		$this->load->view('admin/referral/referral', $data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$query = $this->Referral_model->get_charge($id)->row();
            $data['id'] = $query->id;
            $data['referral_type'] = $query->referral_type;
            $data['heading_arabic'] = $query->heading_arabic;
            $data['referral_charge'] = $query->referral_charge;
            $data['refferer_amount'] = $query->refferer_amount;
            $data['content'] = $query->content;
            $data['content_arabic'] = $query->content_arabic;
            $data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['referral_type'] = "";
			$data['heading_arabic'] = "";
			$data['referral_charge'] = "";
			$data['refferer_amount'] = "";
			$data['content'] = "";
			$data['content_arabic'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/referral/referral_form',$data);
	}
	
	public function edit(){
		$this->form_validation->set_rules('referral_type', 'Referral Type', 'trim|required');
		$this->form_validation->set_rules('referral_charge', 'Referral Charge', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Referral_model->edit();
			}
			else{
				$query = $this->Referral_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/referral');
	}
	
	public function delete(){
		$query = $this->Referral_model->delete($this->input->get('id'));
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/referral');
	}

}
