<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
		$this->load->model('admin/Home_admin_model');
		$this->load->model('admin/Category_model');
		$this->load->library('form_validation');
	}
	
	public function add(){
		$id = $this->input->get('id');
		if($id){
			$query = $this->Home_admin_model->getHome($id);

			foreach($query->result() as $query){	
				$data['image1'] = $query->image1;
				$data['image2'] = $query->image2;
				$data['image3'] = $query->image3;
				$data['image4'] = $query->image4;
				$data['url1'] = $query->url1;
				$data['url2'] = $query->url2;
				$data['url3'] = $query->url3;
				$data['url4'] = $query->url4;
				$data['alt1'] = $query->alt1;
				$data['alt2'] = $query->alt2;
				$data['alt3'] = $query->alt3;
				$data['alt4'] = $query->alt4;
				
				$data['sale_image'] = $query->image_sale;
				$data['sale_url'] = $query->url_sale;
				$data['metatitle'] = $query->metatitle;
				$data['metakeyword'] = $query->metakeyword;
				$data['metadescription'] = $query->metadescription;
				$data['description'] = $query->description;
				$data['id'] = $query->home_id;
			}
		}
		else{
			$data['image1'] = "";
			$data['image2'] = "";
			$data['image3'] = "";
			$data['image4'] = "";
			$data['url1'] = "";
			$data['url2'] = "";
			$data['url3'] = "";
			$data['url4'] = "";
			$data['alt1'] = "";
			$data['alt2'] = "";
			$data['alt3'] = "";
			$data['alt4'] = "";
			
			$data['sale_url'] = "";
			$data['sale_image'] = "";
			$data['id'] = "";
			$data['metatitle'] = "";
			$data['description'] = "";
			$data['metakeyword'] = "";
			$data['metadescription'] = "";
		}
		
		$data['home_banner'] = $this->Home_admin_model->home_banner($this->input->get('id'));
		
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/home/home',$data);
	}
	
	public function edit(){
		$this->form_validation->set_rules('url1', 'URL 1', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Home_admin_model->edit();
			}
			else{
				$query = $this->Home_admin_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/home_admin/add?id=1');
	}
	
	
}
