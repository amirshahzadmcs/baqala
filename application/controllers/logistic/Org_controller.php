<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Org_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->model('logistic/Auth_model');
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->library('session');
	}

	public function index(){
		$this->load->view('logistic/pages/org-tracking/index');
	}
}
