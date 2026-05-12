<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PayrollReport extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){		
			// $this->load->model('admin/Sell_report_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/report/payroll/index',$data);
	}

	public function payslips()
	{
		$this->load->view('admin/report/payroll/payslip');
	}
	

}
