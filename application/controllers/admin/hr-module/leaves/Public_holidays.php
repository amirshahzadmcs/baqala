<?php defined('BASEPATH') or exit('No direct script access allowed');

class Public_holidays extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Publicholidays_model', 'holidays_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->aciton = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'holidays', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['holidays'] = $this->holidays_model->get_all_holidays();
		$this->load->view('admin/hr-module/leaves/holidays', $data);
	}

	public function add_holidays_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'public_holidays', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/hr-module/leaves/partials/add_holidays');
	}

	public function edit_holidays_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'public_holidays', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Get the holiday ID from the query string
		$id = $this->input->get('id');

		// Ensure ID is provided and valid
		if (!$id) {
			// Handle missing ID error
			show_error('Holiday ID is required.');
			return;
		}

		// Retrieve holiday data from the model
		$data['holidays'] = $this->holidays_model->get_holidays_by_id($id);

		// Check if data is retrieved
		if (!$data['holidays']) {
			// Handle data not found error
			show_error('Holiday not found.');
			return;
		}

		// Load the view and pass the holiday data
		$this->load->view('admin/hr-module/leaves/partials/update_holidays', $data);
	}

	public function save_holidays()
	{
		// Retrieve form data
		$holiday_name = $this->input->post('holiday_name');
		$holiday_name_ar = $this->input->post('holiday_name_ar');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$group_type = $this->input->post('group_type') == 'category_type' ? 'category_type' : 'all_company';
		$extend_probation = $this->input->post('extend_probation') ? 'yes' : 'no';

		// Check if inputs are in JSON format and decode accordingly
		$location = $this->input->post('location');
		$departments = $this->input->post('departments');
		$business_unit = $this->input->post('business_unit');

		// Decode JSON only if the data is a string
		$location = is_string($location) ? json_decode($location, true) : [];
		$departments = is_string($departments) ? json_decode($departments, true) : [];
		$business_unit = is_string($business_unit) ? json_decode($business_unit, true) : [];

		// Validation rules
		$this->form_validation->set_rules('holiday_name', 'Name in English', 'required');
		$this->form_validation->set_rules('holiday_name_ar', 'Name in Arabic', 'required');
		$this->form_validation->set_rules('date_from', 'Date From', 'required');
		$this->form_validation->set_rules('date_to', 'Date To', 'required');
		$this->form_validation->set_rules('group_type', 'Group Type', 'required');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('info', "0--" . validation_errors());
			redirect('admin/hr-module/leave-types/holidays'); // Redirect or load the form again
		} else {
			// Validation passed, prepare data
			$data = array(
				'holiday_name' => $holiday_name,
				'holiday_name_ar' => $holiday_name_ar,
				'date_from' => $date_from,
				'date_to' => $date_to,
				'group_type' => $group_type,
				'location' => json_encode($location), // Ensure that arrays are properly encoded
				'departments' => json_encode($departments),
				'business_unit' => json_encode($business_unit),
				'extend_probation' => $extend_probation
			);

			// Update the leave type
			if ($this->holidays_model->add_holidays($data)) {
				$this->session->set_flashdata('info', "1--Holidays added successfully.");
			} else {
				$this->session->set_flashdata('info', "0--Failed to add holidays.");
			}
			redirect('admin/hr-module/leave-types/holidays'); // Redirect as needed
		}
	}

	public function update_holidays()
	{
		// Retrieve form data
		$id = $this->input->post('id');
		$holiday_name = $this->input->post('holiday_name');
		$holiday_name_ar = $this->input->post('holiday_name_ar');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$group_type = $this->input->post('group_type') == 'category_type' ? 'category_type' : 'all_company';
		$extend_probation = $this->input->post('extend_probation') ? 'yes' : 'no';

		// Check if inputs are in JSON format and decode accordingly
		$location = $this->input->post('location');
		$departments = $this->input->post('departments');
		$business_unit = $this->input->post('business_unit');

		// Decode JSON only if the data is a string
		$location = is_string($location) ? json_decode($location, true) : [];
		$departments = is_string($departments) ? json_decode($departments, true) : [];
		$business_unit = is_string($business_unit) ? json_decode($business_unit, true) : [];

		// Validation rules
		$this->form_validation->set_rules('id', 'Request ID', 'required');
		$this->form_validation->set_rules('holiday_name', 'Name in English', 'required');
		$this->form_validation->set_rules('holiday_name_ar', 'Name in Arabic', 'required');
		$this->form_validation->set_rules('date_from', 'Date From', 'required');
		$this->form_validation->set_rules('date_to', 'Date To', 'required');
		$this->form_validation->set_rules('group_type', 'Group Type', 'required');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('info', "0--" . validation_errors());
			redirect('admin/hr-module/leave-types/holidays'); // Redirect or load the form again
		} else {
			// Validation passed, prepare data
			$data = array(
				'holiday_name' => $holiday_name,
				'holiday_name_ar' => $holiday_name_ar,
				'date_from' => $date_from,
				'date_to' => $date_to,
				'group_type' => $group_type,
				'location' => json_encode($location), // Ensure that arrays are properly encoded
				'departments' => json_encode($departments),
				'business_unit' => json_encode($business_unit),
				'extend_probation' => $extend_probation
			);

			// Update the leave type
			if ($this->holidays_model->update_holidays($id, $data)) {
				$this->session->set_flashdata('info', "1--Holidays updated successfully.");
			} else {
				$this->session->set_flashdata('info', "0--Failed to updated holidays.");
			}
			redirect('admin/hr-module/leave-types/holidays'); // Redirect as needed
		}
	}

	public function delete_holidays()
	{
		// Get POST data
		$leave_id = $this->input->post('leave_id');

		// Call the model method to delete the entitlement
		$result = $this->holidays_model->delete_holidays($leave_id);

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Leave deleted successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error deleting leave.']);
		}
	}
}
