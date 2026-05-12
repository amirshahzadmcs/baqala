<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Human_resources extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/hr/master/HR_model');	
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');	
			//$this->load->helper('notification_helper');	
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
		$this->load->model('HR_model', 'dashboard_model');

		$data['summary']            = $this->dashboard_model->employee_summary();
		$data['nationality']        = $this->dashboard_model->nationality_summary();
		$data['gender']             = $this->dashboard_model->gender_summary();
		$data['vehicle']            = $this->dashboard_model->vehicle_summary();
		$data['by_department']      = $this->dashboard_model->employees_by_department();
		$data['by_city']            = $this->dashboard_model->riders_by_city();
		$data['operational_staff']  = $this->dashboard_model->operational_staff_summary();
		//dd($data);
		$this->load->view('admin/hr/dashboard',$data);
	}
	
}
