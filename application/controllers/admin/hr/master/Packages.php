<?php defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr/master/Package_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'packages', $action) && !in_array($action, ['save', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/hr/master/package/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Package_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $pack) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $pack->id . '" name="check_list[]" />';
			$sub_array[] = $pack->package_name . '<br>' . $pack->package_name_ar;
			$sub_array[] = $pack->basic_salary;
			$sub_array[] = $pack->housing_allow;
			$sub_array[] = $pack->no_of_orders;
			$sub_array[] = $pack->total_package;
			$sub_array[] = $pack->department_name . '/' . $pack->designation_name;
			$sub_array[] = ($pack->status == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $pack->created_at;
			$sub_array[] = $pack->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'packages', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/hr/master/package/add?id=' . $pack->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Package_model->get_all_data(),
			"recordsFiltered"     =>     $this->Package_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Package_model->get_detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['package_name'] = $query->package_name;
				$data['package_name_ar'] = $query->package_name_ar;
				$data['basic_salary'] = $query->basic_salary;
				$data['housing_allow'] = $query->housing_allow;
				$data['transportation_allow'] = $query->transportation_allow;
				$data['food_allow'] = $query->food_allow;
				$data['order_allowance'] = $query->order_allowance;
				$data['no_of_orders'] = $query->no_of_orders;
				$data['total_package'] = $query->total_package;
				$data['vacations'] = $query->vacations;
				$data['medical_insurance'] = $query->medical_insurance;
				$data['remarks'] = $query->remarks;
				$data['offer_validity'] = $query->offer_validity;

				$data['project_code'] = $query->project_code;
				$data['project_name'] = $query->project_name;
				$data['reporting_to'] = $query->reporting_to;
				$data['department'] = $query->department;
				$data['work_location'] = $query->work_location;
				$data['working_hrs'] = $query->working_hrs;
				$data['probation_period'] = $query->probation_period;
				$data['contract_period'] = $query->contract_period;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['package_name'] = "";
			$data['package_name_ar'] = "";
			$data['basic_salary'] = "";
			$data['housing_allow'] = "";
			$data['transportation_allow'] = "";
			$data['food_allow'] = "";
			$data['order_allowance'] = "";
			$data['no_of_orders'] = "";
			$data['total_package'] = "";
			$data['vacations'] = "";
			$data['medical_insurance'] = "";
			$data['remarks'] = "";
			$data['offer_validity'] = "";

			$data['project_code'] = "";
			$data['project_name'] = "";
			$data['reporting_to'] = "";
			$data['department'] = "";
			$data['work_location'] = "";
			$data['working_hrs'] = "";
			$data['probation_period'] = "";
			$data['contract_period'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/hr/master/package/form', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('package_name', 'Package Name', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate', 'Package already exist, Try new');
		$this->form_validation->set_rules('basic_salary', 'Basic Salary', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Package_model->edit();
			} else {
				$query = $this->Package_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/package/list');
	}

	public function check_duplicate()
	{
		$package_name = $this->input->post('package_name');
		$id = $this->input->post('id');
		if ($id !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->db->query("SELECT * FROM master_salary_packages WHERE package_name = '" . $package_name . "' AND id != '" . $id . "'");
			//print_r($sku_check);exit();
			if ($duplicate_check->num_rows() > 0) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Package_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/package/list');
	}

	public function get_designations()
	{
		$department_id = $this->input->post('department_id');
		$data = masterDesignation($department_id);
		echo json_encode($data);
	}
}
