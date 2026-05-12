<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Express_shipping extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		$this->load->model('admin/Expshipping_model');
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
		$data['query'] = $this->Expshipping_model->get_shipping_charges(); 
		$this->load->view('admin/shipping/express_shipping_list', $data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$data['id'] = $this->input->get('id');
			$query = $this->Expshipping_model->get_shipping_charge($data['id']);
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['shipping_type'] = $query->shipping_type;
				$data['express_charge'] = $query->express_charge;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['shipping_type'] = "";
			$data['express_charge'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/shipping/express_shipping',$data);
	}
	
	public function edit(){
		$this->form_validation->set_rules('shipping_type', 'Shippig Type', 'trim|required');
		$this->form_validation->set_rules('express_charge', 'Shipping Charge', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Expshipping_model->edit();
			}
			else{
				$query = $this->Expshipping_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/express_shipping');
	}
	
	public function delete(){
		$query = $this->Expshipping_model->delete($this->input->get('id'));
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/express_shipping');
	}

}
