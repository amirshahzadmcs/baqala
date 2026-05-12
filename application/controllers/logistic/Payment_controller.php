<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if($this->logistic->isLogged()){
            $this->load->model('logistic/Report_model');
            $this->load->library('form_validation');
            $this->load->helper('cookie');
            $this->load->library('session');
            $this->load->helper('Common_helper');
        } else{
			redirect("logistic-partner/login");
		}
	}

	public function index(){
        $data['riders_list'] = $this->Report_model->verifiedRiderList();
		$this->load->view('logistic/pages/payment-report/index',$data);
	}

    public function Payment_organisation(){
        $data['riders_list'] = $this->Report_model->verifiedRiderList();
		$this->load->view('logistic/pages/payment-report/organisation-payment',$data);
	}
}
