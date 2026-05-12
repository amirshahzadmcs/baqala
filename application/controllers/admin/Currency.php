<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Currency extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Currency_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['result'] = $this->Currency_model->get_currencies();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/currency/currency_list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Currency_model->get_currency_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;			
				$data['price'] = $query->price;				
				$data['icon'] = $query->icon;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";					
			$data['price'] = "";				
			$data['icon'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/currency/currency_form',$data);
	}

	public function add_currency(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Currency_model->edit();
			}
			else{
				$query = $this->Currency_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/currency');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Currency_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/currency');
	}
}