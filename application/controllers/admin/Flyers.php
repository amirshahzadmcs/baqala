<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Flyers extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		$this->load->model('admin/Flyers_model');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['result'] = $this->Flyers_model->get_photos();
			if ($this->admin->getInfo()){
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
		$this->load->view('admin/flyers/flyers_list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Flyers_model->get_photo_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;
				$data['o_img'] = $query->image;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['o_img'] = "";
		}
		$this->load->view('admin/flyers/flyers_form',$data);
	}

	public function add_photo(){
		if($_FILES['image']['name']){
			$con['upload_path']   = './uploads/flyer/';
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
				$image = "uploads/flyer/".$image_data['file_name'];
           }
		}
		else{
			$image = $this->input->post('o_img');
		}
		if($this->input->post('id')){
			$query = $this->Flyers_model->edit($image);
		}
		else{
			$query = $this->Flyers_model->add($image);
		}
		if($query){
			$this->session->set_userdata('info', "1--Successfully done");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}

		redirect('admin/flyers');
	}


	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Flyers_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/flyers');
	}
}
