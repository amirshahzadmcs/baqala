<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Best_selling extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin/common/login');
		}
		$this->load->model('admin/app_management/Best_selling_model', 'best_selling');
		$this->load->model('admin/Category_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['results'] = $this->best_selling->list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['results']);exit();
		$this->load->view('admin/app_setting/best-selling/list',$data);
	}

	public function add(){
		$data['categories'] = $this->Category_model->get_category();
		$this->load->view('admin/app_setting/best-selling/form',$data);
	}
	
	public function edit(){
		$query = $this->best_selling->detail($this->input->get('id'))->row();
		$data['id'] = $query->id;
		$data['group_name'] = $query->group_name;
		$data['group_name_arabic'] = $query->group_name_arabic;
		$data['category_id'] = $query->category_id;
		$data['status'] = $query->status;
		$data['sort_order'] = $query->sort_order;
		$data['categories'] = $this->Category_model->get_category();
		$this->load->view('admin/app_setting/best-selling/edit',$data);
	}

	public function save(){
		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('category_id[]', 'Categories', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$query = $this->best_selling->add();
			if($query){
				$this->session->set_userdata('info', "1--Successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong, try again.");
			}
		}
		redirect('admin/app/best-selling/list');
	}
	
	public function update(){
		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('category_id[]', 'Categories', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->best_selling->edit();
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated.");
				}
				else{
					$this->session->set_userdata('info', "2--Something went wrong, try again.");
				}
			}
		}
		redirect('admin/app/best-selling/list');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->best_selling->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}else{
			$this->session->set_userdata('info', "2--Something went wrong, try again.");
		}
		redirect('admin/app/best-selling/list');
	}
}
