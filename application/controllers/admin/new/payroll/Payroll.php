<?php
class Payroll extends CI_Controller {
	public function index_contract()
	{
		$this->load->view('admin/hr/master/payroll/contract/index');
	}
}
