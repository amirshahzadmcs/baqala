<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_banners extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin/common/login');
		}
		$this->load->model('admin/app_management/Banner_model');
		$this->load->model('admin/Category_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$type = 'trending_offers';
		$data['results'] = $this->Banner_model->list($type);
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['results']);exit();
		$this->load->view('admin/app_setting/offer-banner/list',$data);
	}

	public function add(){
		$data['categories'] = $this->Category_model->get_category();
		$this->load->view('admin/app_setting/offer-banner/form',$data);
	}
	
	public function edit(){
		$type = 'trending_offers';
		$id = $this->input->get('id');
		$query = $this->Banner_model->get_banner_by_id($id,$type)->row();
		$data['id'] = $query->id;
		$data['o_img'] = $query->banner_image;
		$data['banner_name'] = $query->banner_name;
		$data['banner_title'] = $query->banner_title;
		$data['banner_subtitle'] = $query->banner_subtitle;
		$data['o_img_ar'] = $query->banner_image_ar;
		$data['banner_name_ar'] = $query->banner_name_ar;
		$data['banner_title_ar'] = $query->banner_title_ar;
		$data['banner_subtitle_ar'] = $query->banner_subtitle_ar;
		$data['banner_type'] = $query->banner_type;
		$data['linked_category'] = $query->linked_category;
		$data['status'] = $query->status;
		$data['sort_order'] = $query->sort_order;
		$data['categories'] = $this->Category_model->get_category();
		$this->load->view('admin/app_setting/offer-banner/edit',$data);
	}

	public function save(){
		$this->form_validation->set_rules('banner_name', 'Banner Name', 'trim|required');
		$this->form_validation->set_rules('banner_type', 'Banner Type', 'trim|required');
		$this->form_validation->set_rules('linked_category', 'Select Linked Category', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($_FILES['banner_image']['name']){
				$con['upload_path']   = './uploads/app_banner';
				$con['allowed_types'] = 'gif|jpg|png|jpeg';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('banner_image')) {
                   echo $this->upload->display_errors();
				   exit;
                }
				else {
					$image_data = $this->upload->data();
					$image = "uploads/app_banner/".$image_data['file_name'];
               }
			}
			else{
				$image = '';
			}
			if($_FILES['banner_image_ar']['name']){
				$con['upload_path']   = './uploads/app_banner';
				$con['allowed_types'] = 'gif|jpg|png|jpeg';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('banner_image_ar')) {
                   echo $this->upload->display_errors();
				   exit;
                }
				else {
					$image_data2 = $this->upload->data();
					$image2 = "uploads/app_banner/".$image_data2['file_name'];
               }
			}
			else{
				$image2 = '';
			}
			$query = $this->Banner_model->add($image,$image2);
			if($query){
				$this->session->set_userdata('info', "1--Successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong, try again.");
			}
		}
		redirect('admin/app/trending-offers/list');
	}
	
	public function update(){
		$this->form_validation->set_rules('banner_name', 'Banner Name', 'trim|required');
		$this->form_validation->set_rules('banner_type', 'Banner Type', 'trim|required');
		$this->form_validation->set_rules('linked_category', 'Select Linked Category', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($_FILES['banner_image']['name']){
				$con['upload_path']   = './uploads/app_banner';
				$con['allowed_types'] = 'gif|jpg|png|jpeg';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('banner_image')) {
                   echo $this->upload->display_errors();
				   exit;
                }
				else {
					$image_data = $this->upload->data();
					$image = "uploads/app_banner/".$image_data['file_name'];
               }
			}
			else{
				$image = $this->input->post('o_img');
			}
			if($_FILES['banner_image_ar']['name']){
				$con['upload_path']   = './uploads/app_banner';
				$con['allowed_types'] = 'gif|jpg|png|jpeg';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('banner_image_ar')) {
                   echo $this->upload->display_errors();
				   exit;
                }
				else {
					$image_data2 = $this->upload->data();
					$image2 = "uploads/app_banner/".$image_data2['file_name'];
               }
			}
			else{
				$image2 = $this->input->post('o_img_ar');
			}
			if($this->input->post('id')){
				$query = $this->Banner_model->edit($image,$image2);
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated.");
				}
				else{
					$this->session->set_userdata('info', "2--Something went wrong, try again.");
				}
			}
		}
		redirect('admin/app/trending-offers/list');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Banner_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}else{
			$this->session->set_userdata('info', "2--Something went wrong, try again.");
		}
		redirect('admin/app/trending-offers/list');
	}
}
