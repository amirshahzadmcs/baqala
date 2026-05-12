<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends CI_Controller {

	public function __construct(){
        parent::__construct();				
		if($this->admin->isLogged()){
			$this->load->model('admin/masters/Country_model');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'countries',$action) && !in_array($action, ['save','get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		}else{
			redirect('admin/common/login');
		}
	}

	public function index(){
		$data['countries'] = $this->Country_model->country_list()->result();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/masters/country/list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Country_model->get_detail($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;
				$data['arabic_name'] = $query->arabic_name;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['status'] = "";
		}
		// $data['regions'] = $this->Region_model->get_list()->result();
		return $this->load->view('admin/masters/country/form',$data);
	}

	public function save(){
		$this->form_validation->set_rules('name', 'Country Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Country_model->edit();
			}
			else{
				$query = $this->Country_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/country');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Country_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/country');
	}

}
