<?php
class Payslip extends CI_Controller {
	public function index()
	{
		$this->load->view('admin/hr/master/payroll/payslip/index');
	}

	public function creat()
	{
		$this->load->view('admin/hr/master/payroll/payslip/form');
	}
}
