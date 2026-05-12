<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Newsletter_model');	
			$this->load->library('form_validation');	
		}	
		else{		
			redirect('admin/common/login');			
		}
	}

	public function index(){
		$data['result'] = $this->Newsletter_model->get_newsletter();
			if ($this->admin->getInfo()){
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
		$this->load->view('admin/newsletter/newsletter_list',$data);
	}

	

	public function add(){
		if($this->input->get('id')){
			$query = $this->Newsletter_model->get_newsletter_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;
				$data['email'] = $query->email;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['email'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/newsletter/newsletter_form',$data);
	}

	public function add_newsletter(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Newsletter_model->edit();
			}
			else{
				$query = $this->Newsletter_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/newsletter');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Newsletter_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/newsletter');
	}
}