<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shipping extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin/common/login');
		}
		$this->load->model('admin/Shipping_model');
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
		$data['query'] = $this->Shipping_model->get_shipping_charges(); 
		$this->load->view('admin/shipping/shipping_list', $data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$data['id'] = $this->input->get('id');
			$query = $this->Shipping_model->get_shipping_charge($data['id']);
			foreach($query->result() as $query){
				$data['shipping_charge_id'] = $query->shipping_charge_id;
				$data['name'] = $query->name;
				$data['amount'] = $query->amount;
				$data['start_price'] = $query->start_price;
				$data['end_price'] = $query->end_price;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['amount'] = "";
			$data['start_price'] = "";
			$data['end_price'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/shipping/shipping',$data);
	}
	
	public function edit(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Shipping_model->edit();
			}
			else{
				$query = $this->Shipping_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/shipping');
	}
	
	public function delete(){
		$query = $this->Shipping_model->delete($this->input->get('id'));
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/shipping');
	}

}
