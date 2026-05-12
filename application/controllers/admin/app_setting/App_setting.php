<?php defined('BASEPATH') OR exit('No direct script access allowed');

class App_setting extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');	
		}		
		else{		
			redirect('admin/login');			
		}
	}

	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/app_setting/dashboard',$data);
	}
	
}
