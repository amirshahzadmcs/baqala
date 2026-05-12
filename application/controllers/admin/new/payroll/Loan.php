<?php
class Loan extends CI_Controller {
	public function index()
	{
		$this->load->view('admin/hr/master/payroll/loans/index');
	}

	public function creat()
	{
		$this->load->view('admin/hr/master/payroll/loans/forms');
	}
}
