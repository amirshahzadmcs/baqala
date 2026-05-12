<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Images extends CI_Controller {

	public function __construct() {
        parent::__construct();
		if($this->admin->isLogged()){
			$this->load->model('admin/Images_model');
			$this->load->library('form_validation');
		}
		else{
			redirect('admin/common/login');
		}
     
	}

	public function index(){			
	$data['users'] = $this->Images_model->get_users();	
	if($this->input->get('user')){			
	$user = $this->input->get('user');		
	}		
	else{		
	$user = '';		
	}
		$data['result'] = $this->Images_model->get_images($user);
			if ($this->admin->getInfo()){
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
		$this->load->view('admin/images/images_list',$data);
	}
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Images_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/images');
	}
}