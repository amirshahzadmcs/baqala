<?php
class Payrun extends CI_Controller {
	public function index()
	{
		$this->load->view('admin/hr/master/payroll/payrun/index');
	}

	public function creat()
	{
		$this->load->view('admin/hr/master/payroll/payrun/create');
	}
}
