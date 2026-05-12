<?php defined('BASEPATH') or exit('No direct script access allowed');

class HrMaster extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Edu_model');
			$this->load->model('admin/Allowance_model');
			$this->load->model('admin/Leave_vacation_model');
			$this->load->model('admin/Job_title_model');
			$this->load->model('admin/Pay_head_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index_edu()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'educations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/education/index', $data);
	}


	public function add_edu()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'educations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Edu_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
		} else {
			$data['id'] = "";
			$data['name'] = "";
		}
		$this->load->view('admin/hr/master/education/form', $data);
	}

	public function save_edu()
	{
		$this->form_validation->set_rules('name', 'Education Name', 'trim|required');
		if (empty($this->input->post('id'))) {
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Edu_model->edit();
			} else {
				$query = $this->Edu_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/education');
	}

	public function edu_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'educations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Edu_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;

			$this->load->view('admin/hr/master/education/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/master/education');
		}
	}

	public function get_edu_list()
	{
		$fetch_data = $this->Edu_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->id;
			$sub_array[] = $store->name;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = (check_action_permission(get_user_role(), 'educations', 'add_edu') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/education/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'educations', 'edu_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/master/education/detail?id=' . $store->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Edu_model->get_all_data(),
			"recordsFiltered"     =>     $this->Edu_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	// public function getPlans()
	// {
	// 	$query = $this->Edu_model->get_plan($this->input->get('id'));
	// 	// $p_data = $query;
	// 	// print_r($this->input->get('plan_id'));exit();
	// 	$data ='';
	// 	foreach($query as $plan){
	// 		if ($plan->id == $this->input->get('plan_id')) {
	// 			$selected = "selected";
	// 		} else {
	// 			$selected = "";
	// 		}
	// 		$data .= '<option value="' . $plan->id . '" ' . $selected . '>' . $plan->plan_name . '</option>';
	// 	}
	// 	echo $data;
	// }

	public function delete_edu()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'educations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->Edu_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/education');
	}

	// job title

	public function index_job_title()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'designations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/jobTitle/index', $data);
	}


	public function add_job_title()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'designations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Job_title_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['department_id'] = $query->department_id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['status'] = $query->status;
			$data['description'] = $query->description;
			return $this->load->view('admin/hr/master/jobTitle/edit', $data);
		} else {
			$data['id'] = "";
			$data['department_id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['status'] = "";
			$data['description'] = "";
			return $this->load->view('admin/hr/master/jobTitle/form', $data);
		}
	}

	public function save_job_title()
	{
		$this->form_validation->set_rules('department_id[]', 'Department Name', 'trim|required');
		$this->form_validation->set_rules('name', 'Designation Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, load the form again
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$id = $this->input->post('id');
			$data = array(
				'name' => $this->input->post('name'),
				'arabic_name' => $this->input->post('arabic_name'),
				'status' => $this->input->post('status'),
				'description' => $this->input->post('description'),
				'department_id' => json_encode($this->input->post('department_id'))
			);

			if ($id) {
				// Update existing record
				$this->Job_title_model->update_designation($id, $data);
				$this->session->set_userdata('info', "1--Successfully updated.");
			} else {
				// Insert new record
				$this->Job_title_model->insert_designation($data);
				$this->session->set_userdata('info', "1--Successfully added.");
			}

			// Redirect or load success view
			redirect('admin/hr/master/designations');
		}
	}

	public function job_title_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'designations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Job_title_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['department_id'] = $query->department_id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['status'] = $query->status;
			$data['description'] = $query->description;

			$this->load->view('admin/hr/master/jobTitle/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid ID!!");
			redirect('admin/hr/master/designations');
		}
	}

	public function get_job_title_list()
	{
		$fetch_data = $this->Job_title_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->id;
			$sub_array[] = $store->name;
			$sub_array[] = $store->arabic_name;
			$sub_array[] = $store->department_names;  // Show department names here
			$sub_array[] = $store->employee_count;    // Show employee count here
			$sub_array[] = $store->status == 'active' ?
				'<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' :
				'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			$sub_array[] = check_action_permission(get_user_role(), 'designations', 'add_job_title') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/designations/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->Job_title_model->get_all_data(),
			"recordsFiltered" => $this->Job_title_model->get_filtered_data(),
			"data"            => $data
		);
		echo json_encode($output);
	}

	public function delete_job_title()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'designations', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->Job_title_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/designations');
	}

	// Allowance

	public function index_allowance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'allowance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/allowance/index', $data);
	}


	public function add_allowance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'allowance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Allowance_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
		} else {
			$data['id'] = "";
			$data['name'] = "";
		}
		$this->load->view('admin/hr/master/allowance/form', $data);
	}

	public function save_allowance()
	{
		$this->form_validation->set_rules('name', 'Allowance Name', 'trim|required');
		if (empty($this->input->post('id'))) {
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Allowance_model->edit();
			} else {
				$query = $this->Allowance_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/allowance');
	}

	public function allowance_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'allowance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Allowance_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;

			$this->load->view('admin/hr/master/allowance/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/master/allowance');
		}
	}

	public function get_allowance_list()
	{
		$fetch_data = $this->Allowance_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->name;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = (check_action_permission(get_user_role(), 'allowance', 'add_allowance') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/allowance/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'allowance', 'allowance_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/master/allowance/detail?id=' . $store->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Allowance_model->get_all_data(),
			"recordsFiltered"     =>     $this->Allowance_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}
	public function delete_allowance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'allowance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->Allowance_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/allowance');
	}

	// Leave/Vacation

	public function index_leave()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/leave/index', $data);
	}


	public function add_leave()
	{
		if ($this->input->get('id')) {
			$query = $this->Leave_vacation_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
		} else {
			$data['id'] = "";
			$data['name'] = "";
		}
		$this->load->view('admin/hr/master/leave/form', $data);
	}

	public function save_leave()
	{
		$this->form_validation->set_rules('name', 'Allowance Name', 'trim|required');
		if (empty($this->input->post('id'))) {
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Leave_vacation_model->edit();
			} else {
				$query = $this->Leave_vacation_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/leave');
	}

	public function leave_detail()
	{
		if ($this->input->get('id')) {
			$query = $this->Leave_vacation_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;

			$this->load->view('admin/hr/master/leave/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/master/leave');
		}
	}

	public function get_leave_list()
	{
		$fetch_data = $this->Leave_vacation_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->name;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/leave/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/master/leave/detail?id=' . $store->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Leave_vacation_model->get_all_data(),
			"recordsFiltered"     =>     $this->Leave_vacation_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete_leave()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Leave_vacation_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/leave');
	}

	// Pay head

	public function index_pay_head()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'pay_heads', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/pay_head/index', $data);
	}


	public function add_pay_head()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'pay_heads', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Pay_head_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['type'] = $query->type;
			$data['calculate_on'] = $query->calculate_on;
		} else {
			$data['id'] = "";
			$data['name'] = "";
			$data['type'] = "";
			$data['calculate_on'] = "";
		}
		$this->load->view('admin/hr/master/pay_head/form', $data);
	}

	public function save_pay_head()
	{
		$this->form_validation->set_rules('name', 'Allowance Name', 'trim|required');
		if (empty($this->input->post('id'))) {
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Pay_head_model->edit();
			} else {
				$query = $this->Pay_head_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/pay_head');
	}

	public function pay_head_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'pay_heads', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Pay_head_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['type'] = $query->type;
			$data['calculate_on'] = $query->calculate_on;

			$this->load->view('admin/hr/master/pay_head/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/master/pay_head');
		}
	}

	public function get_pay_head_list()
	{
		$fetch_data = $this->Pay_head_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->name;
			$sub_array[] = $store->type;
			$sub_array[] = $store->calculate_on;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = (check_action_permission(get_user_role(), 'pay_heads', 'add_pay_head') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/pay_head/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'pay_heads', 'pay_head_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/master/pay_head/detail?id=' . $store->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Pay_head_model->get_all_data(),
			"recordsFiltered"     =>     $this->Pay_head_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete_pay_head()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'pay_heads', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->Pay_head_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/pay_head');
	}
}
