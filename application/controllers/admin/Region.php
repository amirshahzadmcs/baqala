<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Region extends CI_Controller {

	public function __construct(){
        parent::__construct();				
		if($this->admin->isLogged()){
			$this->load->model('admin/Region_model');
			$this->load->library('form_validation');
			$action=$this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'regions',$action) && !in_array($action, ['submit','get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		}else{
			redirect('admin/common/login');
		}
	}

	public function index(){
		$data['regions'] = $this->Region_model->get_list()->result();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/regions/list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Region_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['region_name'] = $query->region_name;
			$data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['region_name'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/regions/form',$data);
	}

	public function submit(){
		$this->form_validation->set_rules('region_name', 'Region Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Region_model->edit();
			}
			else{
				$query = $this->Region_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/region');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Region_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/region');
	}

}
