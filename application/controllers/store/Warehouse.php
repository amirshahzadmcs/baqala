<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->store->isLogged()){		
			$this->load->model('store/Stockreq_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('store/login');			
		}
	}

	public function index(){
		if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//$data['racks'] = $this->Stockreq_model->get_racks();
		$this->load->view('stores/warehouse/dashboard',$data);
	}
	
}