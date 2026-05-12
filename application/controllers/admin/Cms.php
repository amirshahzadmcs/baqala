<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

	public function __construct() {
        parent::__construct();				
		if($this->admin->isLogged()){			 
			$this->load->model('admin/Cms_model');	 
			$this->load->library('form_validation');			
		}			
		else{				
			redirect('admin');			
		}
		if(!$this->admin->hasPrivilege('settings')){
			redirect("admin");
		}
	}

	public function index(){
		$data['result'] = $this->Cms_model->get_cms();
			if ($this->admin->getInfo()){
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
		$this->load->view('admin/cms/cms_list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Cms_model->get_cms_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;
				$data['arabic_name'] = $query->arabic_name;
				$data['seo'] = $query->slug;
				$data['data'] = $query->text_data;
				$data['arabic_text_data'] = $query->arabic_text_data;
				$data['metatitle'] = $query->metatitle;
				$data['metadescription'] = $query->metadescription;
				$data['metakeyword'] = $query->metakeyword;
				$data['o_img'] = $query->image;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['data'] = "";
			$data['arabic_text_data'] = "";
			$data['seo'] = "";
			$data['metatitle'] = "";
			$data['metadescription'] = "";
			$data['o_img'] = "";
			$data['metakeyword'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/cms/cms_form',$data);
	}

	public function add_cms(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($_FILES['image']['name']){
				$con['upload_path']   = './uploads/'; 
				$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
				$con['max_size']      = 0; 
				$con['max_width']     = 0; 
				$con['max_height']    = 0;  
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
                   echo $this->upload->display_errors();
				   exit;
                } 
				else {
					$image_data = $this->upload->data();
					$image = "uploads/".$image_data['file_name'];
               }
			}
			else{
				$image = $this->input->post('o_image');
			}
			if($this->input->post('id')){
				$query = $this->Cms_model->edit($image);
			}
			else{
				$query = $this->Cms_model->add($image);
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/cms');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Cms_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/cms');
	}
}