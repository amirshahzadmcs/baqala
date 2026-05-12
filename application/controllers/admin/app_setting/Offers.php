<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin/common/login');
		}
		$this->load->model('admin/app_management/Offers_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['results'] = $this->Offers_model->list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['results']);exit();
		$this->load->view('admin/app_setting/offers/list',$data);
	}

	public function add(){
		$this->load->view('admin/app_setting/offers/form');
	}
	
	public function edit(){
		$query = $this->Offers_model->detail($this->input->get('id'))->row();
		$data['id'] = $query->id;
		$data['offer_title'] = $query->offer_title;
		$data['offer_sub_title'] = $query->offer_sub_title;
		$data['offer_title_ar'] = $query->offer_title_ar;
		$data['offer_sub_title_ar'] = $query->offer_sub_title_ar;
		$data['coupon_code'] = $query->coupon_code;
		$data['offer_ends_on'] = $query->offer_ends_on;
		$data['status'] = $query->status;
		$data['sort_order'] = $query->sort_order;
		$this->load->view('admin/app_setting/offers/edit',$data);
	}

	public function save(){
		$this->form_validation->set_rules('offer_title', 'Offer Title', 'trim|required');
		$this->form_validation->set_rules('offer_sub_title', 'Offer Sub Title', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		$this->form_validation->set_rules('offer_ends_on', 'Offer Ends Date', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$query = $this->Offers_model->add();
			if($query){
				$this->session->set_userdata('info', "1--Successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong, try again.");
			}
		}
		redirect('admin/app/offers/list');
	}
	
	public function update(){
		$this->form_validation->set_rules('offer_title', 'Offer Title', 'trim|required');
		$this->form_validation->set_rules('offer_sub_title', 'Offer Sub Title', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		$this->form_validation->set_rules('offer_ends_on', 'Offer Ends Date', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Offers_model->edit($image,$image2);
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated.");
				}
				else{
					$this->session->set_userdata('info', "2--Something went wrong, try again.");
				}
			}
		}
		redirect('admin/app/offers/list');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Offers_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}else{
			$this->session->set_userdata('info', "2--Something went wrong, try again.");
		}
		redirect('admin/app/offers/list');
	}
}
