<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {

	public function __construct(){
		parent::__construct(); 
		if($this->admin->isLogged()){
			$this->load->model('admin/Plan_model');
			$this->load->model('admin/Network_model');
			$this->load->library('form_validation');
			$action=$this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'plans',$action) && !in_array($action, ['submit','get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		}else{
			redirect('admin/common/login');
		}
	}

	public function index(){
		$data['regions'] = $this->Plan_model->get_list()->result();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/plans/list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Plan_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['plan_name'] = $query->plan_name;
			$data['network_id'] = $query->network_id;
			$data['sim_type'] = $query->sim_type;
			$data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['plan_name'] = "";
			$data['network_id'] = "";
			$data['sim_type'] = "";
			$data['status'] = "";
		}
		$data['network'] = $this->Network_model->networks();
		$this->load->view('admin/plans/form',$data);
	}

	public function submit(){
		$this->form_validation->set_rules('network_id', 'Service Provider', 'trim|required');
		$this->form_validation->set_rules('sim_type', 'Sim Type', 'trim|required');
		$this->form_validation->set_rules('plan_name', 'Plan Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Plan_model->edit();
			}
			else{
				$query = $this->Plan_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/plan');
	}


	public function delete(){
		$this->form_validation->set_rules('check_list', 'Checkbox', 'trim|required');
		if($this->form_validation->run()==FALSE){
		$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$id = implode(',',$this->input->post('check_list'));
			$query = $this->Plan_model->delete($id);
			if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/plan');
	}

}
