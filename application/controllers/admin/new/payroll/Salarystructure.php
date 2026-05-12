<?php
class Salarystructure extends CI_Controller {
	public function index()
	{
		$this->load->view('admin/hr/master/payroll/salary-structure/index');
	}

	public function creat()
	{
		$this->load->view('admin/hr/master/payroll/salary-structure/form');
	}
}
