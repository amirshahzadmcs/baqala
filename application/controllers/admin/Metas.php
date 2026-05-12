<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Metas extends CI_Controller{
		
	 public function __construct() {
        parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
    	$this->load->model('admin/Meta_model');
		$this->load->library('form_validation');
	}
	
	function index(){
		if($this->admin->isLogged()){
			$data['result'] = $this->Meta_model->get_metas();
			$this->load->view('admin/meta/meta_list', $data);
		}
		else{
			redirect('admin/home');
		}
	}
	
	function add_form(){
		if($this->admin->isLogged()){
			if($this->input->get('id')){
			$query = $this->Meta_model->get_meta_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['url'] = $query->url;
				$data['title'] = $query->title;
				$data['metadescription'] = $query->metadescription;
				$data['metakeyword'] = $query->metakeyword;
			}
			}
			else{
				$data['id'] = "";
				$data['url'] = "";
				$data['title'] = "";
				$data['metadescription'] = "";
				$data['metakeyword'] = "";
			}
			$this->load->view('admin/meta/meta_form', $data);
		}
		else{
			redirect('admin/home');
		}
	}
	
	function add(){
		if($this->admin->isLogged()){
		$this->form_validation->set_rules('url', 'URL', 'trim|required');
		if($this->form_validation->run()==FALSE){
		$this->session->set_userdata('info', "2--".validation_errors());
		}else{
			if($this->input->post('id')){
				$query = $this->Meta_model->edit();
			}
			else{
				$query = $this->Meta_model->add();
			}
		
		if($query){
				$this->session->set_flashdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_flashdata('info', "2--Error!!!");
			}
		}
		redirect('admin/metas');
		}
		else{
			redirect('admin/home');
		}
	}
	
	function delete(){
		if($this->admin->isLogged()){
		$ids = $this->input->post('check_list');
		$query = $this->Meta_model->delete($ids);
			
			if($query){
				$this->session->set_flashdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_flashdata('info', "2--Error!!!");
			}
				redirect('admin/metas');
		}
		else{
			redirect('admin/home');
		}
	}
			
}