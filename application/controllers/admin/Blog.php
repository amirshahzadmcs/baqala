<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {
	
	public function index(){
		$this->load->model("admin/Blog_model");
		$data=array();
		$data['blog']=$this->Blog_model->getBlog();
		//echo '<pre>'; print_r($data['blog']);die;
		$this->load->view('admin/blog/blog_list', $data);
	}
	
	public function add(){
		$this->load->view('admin/blog/blog_add');
	}
	
	public function addBlogCode(){
		//echo '<pre>'; print_r($_POST);die;
		$this->load->model("admin/Blog_model");
		$this->form_validation->set_rules('title','Title','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('meta_title','Meta Title','trim|required');
		$this->form_validation->set_rules('meta_keyword','Meta Keyword','trim|required');
		$this->form_validation->set_rules('meta_description','Meta Description','trim|required');
		if($this->form_validation->run() == false){
				$this->session->set_flashdata('message', '<p class="alert alert-danger">Please Enter Required Details</p>');
				$this->load->view("admin/blog/blog_add");
		}else{
			if(!empty($_FILES)){
				$config['upload_path'] = 'upload/blog/';
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('blogimg')){
					$image='';
				}else{
					$imageDetailArray = $this->upload->data();
					$image =  $imageDetailArray['file_name'];
				}
			}
			$data=array('title'=>$_POST['title'],'slug'=>$_POST['slug'],'image'=>$image,'description'=>$_POST['description'],'meta_title'=>$_POST['meta_title'],'meta_keyword'=>$_POST['meta_keyword'],'meta_description'=>$_POST['meta_description'],'status'=>$_POST['status'],'created'=>time());
			// /titleecho '<pre>'; print_r($data);die;
			$save=$this->Blog_model->saveBlog($data);
			if($save){
				$this->session->set_flashdata('message', '<p class="alert alert-success">Save Successfully</p>');
				redirect("admin/Blog");
			}
		}
	}
	public function edit(){
		$this->load->model("admin/Blog_model");
		$id=$this->uri->segment(4);
		$data=array();
		$data['blog']=$this->Blog_model->editBlog($id);
		//echo '<pre>'; print_r($data['blog']);die;
		$this->load->view("admin/blog/blog_edit",$data);
	}
	public function updateBlogCode(){
		//echo '<pre>'; print_r($_POST);die;
		$this->load->model("admin/Blog_model");
		$id=$_POST['id'];
		$this->form_validation->set_rules('title','Title','trim|required');
		$this->form_validation->set_rules('description','Description','trim|required');
		$this->form_validation->set_rules('meta_title','Meta Title','trim|required');
		$this->form_validation->set_rules('meta_keyword','Meta Keyword','trim|required');
		$this->form_validation->set_rules('meta_description','Meta Description','trim|required');
		if($this->form_validation->run() == false){

			$data['blog']=$this->Blog_model->editBlog($id);
			$this->session->set_flashdata('message', '<p class="alert alert-danger">Please Enter Required Details</p>');
			$this->load->view("admin/blog/blog_edit",$data);
		}else{
			if(!empty($_FILES)){
				$config['upload_path'] = 'upload/blog/';
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('blogimg')){
					$image=$this->input->post('imagepath');

				}else{
					$imageDetailArray = $this->upload->data();
					$image =  $imageDetailArray['file_name'];
				}
			}
			$data=array('title'=>$_POST['title'],'slug'=>$_POST['slug'],'image'=>$image,'description'=>$_POST['description'],'meta_title'=>$_POST['meta_title'],'meta_keyword'=>$_POST['meta_keyword'],'meta_description'=>$_POST['meta_description'],'status'=>$_POST['status'],'created'=>time());
			//echo '<pre>'; print_r($data);die;
			$update=$this->Blog_model->updateBlog($data,$id);
			if($update){
				$this->session->set_flashdata('message', '<p class="alert alert-success">Update Successfully</p>');
				redirect("admin/Blog");		
			}
		}
	}
	public function delete(){
		$this->load->model("admin/Blog_model");
		$id=$this->uri->segment(4);
		$delete=$this->Blog_model->deleteBlog($id);
		//echo $delete;die;
		if($delete==1){
			$this->session->set_flashdata('message', '<p class="alert alert-success">Delete Successfully</p>');
			redirect("admin/Blog");
		}
	}
}
?>