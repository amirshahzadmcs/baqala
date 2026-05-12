<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timeslot extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin/common/login');
		}
		$this->load->model('admin/Timeslot_model');
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
		$data['query'] = $this->Timeslot_model->get_timeslots(); 
		$this->load->view('admin/timeslots/slot_list', $data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$data['id'] = $this->input->get('id');
			$query = $this->Timeslot_model->get_slot($data['id']);
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['short_name'] = $query->short_name;
			$data['time_from'] = $query->time_from;
			$data['time_to'] = $query->time_to;
			$data['slot_order'] = $query->slot_order;
			$data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['short_name'] = "";
			$data['time_from'] = "";
			$data['time_to'] = "";
			$data['slot_order'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/timeslots/slot_form',$data);
	}
	
	public function edit(){
		$this->form_validation->set_rules('name', 'Slot Name', 'trim|required');
		$this->form_validation->set_rules('short_name', 'Short Slot Name', 'trim|required');
		$this->form_validation->set_rules('time_from', 'Slot Time From', 'trim|required');
		$this->form_validation->set_rules('time_to', 'Slot Time To', 'trim|required');
		$this->form_validation->set_rules('slot_order', 'Slot Order', 'trim|required');
		$this->form_validation->set_rules('status', 'Slot Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Timeslot_model->edit();
			}
			else{
				$query = $this->Timeslot_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/timeslot');
	}
	
	public function delete(){
		$query = $this->Timeslot_model->delete($this->input->get('id'));
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/timeslot');
	}

}
