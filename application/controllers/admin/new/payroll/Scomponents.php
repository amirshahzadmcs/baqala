<?php
class Scomponents extends CI_Controller {
	public function index()
	{
		$this->load->view('admin/hr/master/payroll/salary-components/index');
	}

	public function creat()
	{
		$this->load->view('admin/hr/master/payroll/salary-components/forms');
	}
}
