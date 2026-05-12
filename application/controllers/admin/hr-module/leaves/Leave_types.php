<?php defined('BASEPATH') or exit('No direct script access allowed');

class Leave_types extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Leave_types_model', 'leave_types_model');
			$this->load->model('admin/hr-module/Employee_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && (!check_action_permission(get_user_role(), 'leave_types', $this->action) || !check_action_permission(get_user_role(), 'holidays_request', $this->action))) {
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
		$data['settings'] = $this->leave_types_model->get_all_settings();
		//print_r($data['settings']);exit();
		$this->load->view('admin/hr-module/leaves/index', $data);
	}

	public function save_entitlement_days()
	{
		$setting_id = $this->input->post('setting_id'); // Assuming you have a setting ID
		$new_days = $this->input->post('days'); // Expecting an array of new days

		if (isset($new_days)) {
			if ($this->leave_types_model->update_entitlement_days($setting_id, $new_days)) {
				echo json_encode(array('status' => 'success'));
				return;
			} else {
				echo json_encode(array('status' => 'error', 'message' => 'Setting ID not found'));
				return;
			}
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Invalid data'));
			return;
		}
	}

	public function delete_entitlement()
	{
		// Get POST data
		$setting_id = $this->input->post('setting_id');
		$day_to_delete = $this->input->post('day_to_delete');

		// Call the model method to delete the entitlement
		$result = $this->leave_types_model->delete_entitlement_day($setting_id, $day_to_delete);

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Entitlement deleted successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error deleting entitlement.']);
		}
	}

	public function get_entitlements()
	{
		// Fetch updated entitlements
		$data['settings'] = $this->leave_types_model->get_all_settings();
		// Load the view and return the table body HTML
		$this->load->view('admin/hr-module/leaves/partials/entitlements_table_body', $data);
	}

	public function update_leave_calculation()
	{
		$setting_id = $this->input->post('setting_id');
		$leave_calculation = $this->input->post('leave_calculation');

		// Perform the update in the database
		$result = $this->leave_types_model->update_leave_calculation($setting_id, $leave_calculation);

		// Retrieve the current value from the database
		$current_value = $this->leave_types_model->get_all_settings();

		if ($result) {
			// Return the response
			echo json_encode([
				'status' => 'success',
				'message' => 'Leave calculation method updated successfully.',
				'current_value' => $current_value['annual_leave_calculation']
			]);
		} else {
			// Return the response
			echo json_encode([
				'status' => 'error',
				'message' => 'Error updating leave calculation method.',
				'current_value' => $current_value['annual_leave_calculation']
			]);
		}
	}

	public function update_half_day()
	{
		$setting_id = $this->input->post('setting_id');
		$enable_half_day = $this->input->post('enable_half_day');

		$result = $this->leave_types_model->update_half_day($setting_id, $enable_half_day);

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Half day leave setting updated successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error updating half day leave setting.']);
		}
	}

	public function update_starting_balance()
	{
		$setting_id = $this->input->post('setting_id');
		$starting_balance = $this->input->post('starting_balance');

		// Perform the update in the database
		$result = $this->leave_types_model->update_starting_balance($setting_id, $starting_balance);

		// Retrieve the current value from the database
		$current_value = $this->leave_types_model->get_all_settings();

		if ($result) {
			// Return the response
			echo json_encode([
				'status' => 'success',
				'message' => 'Starting balance updated successfully.',
				'current_value' => $current_value['starting_balance']
			]);
		} else {
			// Return the response
			echo json_encode([
				'status' => 'error',
				'message' => 'Error updating leave starting balance.',
				'current_value' => $current_value['starting_balance']
			]);
		}
	}

	public function update_leave_auto_upgrade()
	{
		$setting_id = $this->input->post('setting_id');
		$leave_auto_upgrade = $this->input->post('leave_auto_upgrade', TRUE) ? 'yes' : 'no';

		// Perform the update in the database
		$result = $this->leave_types_model->update_leave_auto_upgrade($setting_id, $leave_auto_upgrade);

		if ($result) {
			// Return the response
			echo json_encode([
				'status' => 'success',
				'message' => 'Leave auto-upgrade updated successfully.'
			]);
		} else {
			// Return the response
			echo json_encode([
				'status' => 'error',
				'message' => 'Error updating leave auto-upgrade.'
			]);
		}
	}

	public function get_employee_view()
	{
		$data['employees'] = $this->leave_types_model->get_all_employees();
		$selected_emp = $this->leave_types_model->get_all_settings();
		$data['selected_emp'] = $selected_emp['employee_ids'];
		$this->load->view('admin/hr-module/leaves/partials/employee_list', $data);
	}

	public function add_selected_employees()
	{
		// Get selected employees from POST data
		$selected_employees = $this->input->post('selected_employees');
		$setting_id = $this->input->post('setting_id');

		if (is_array($selected_employees) && !empty($selected_employees)) {
			// Save selected employees using the model
			$result = $this->leave_types_model->save_selected_employees($setting_id, $selected_employees);

			if ($result) {
				$response = array('status' => 'success', 'message' => 'Selected employees saved successfully.');
			} else {
				$response = array('status' => 'error', 'message' => 'Failed to save selected employees.');
			}
		} else {
			$response = array('status' => 'error', 'message' => 'No employees selected.');
		}

		// Send JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function save_auto_upgrade_settings()
	{
		// Load necessary libraries or helpers if not already loaded
		$this->load->library('form_validation');
		$this->load->helper('security');

		// Set validation rules
		$this->form_validation->set_rules('setting_id', 'Setting ID', 'required|integer');
		$this->form_validation->set_rules('when_employee_completes_year', 'When Employee Completes Year', 'required|integer');
		$this->form_validation->set_rules('increase_balance_to', 'Increase Balance To', 'required|integer');
		//$this->form_validation->set_rules('leave_auto_upgrade', 'Leave Auto Upgrade', 'required|integer');
		$this->form_validation->set_rules('is_all_employee_selected', 'Is All Employee Selected', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'status' => 'error',
				'message' => validation_errors()
			);
		} else {
			// Retrieve and sanitize POST data
			$setting_id = $this->input->post('setting_id', TRUE);
			$when_employee_completes_year = $this->input->post('when_employee_completes_year', TRUE);
			$increase_balance_to = $this->input->post('increase_balance_to', TRUE);
			$leave_auto_upgrade = $this->input->post('leave_auto_upgrade', TRUE) ? 'yes' : 'no';
			$is_all_employee_selected = $this->input->post('is_all_employee_selected', TRUE);

			$data = array(
				'when_employee_completes_year' => $when_employee_completes_year,
				'increase_balance_to' => $increase_balance_to,
				'leave_auto_upgrade' => $leave_auto_upgrade,
				'is_all_employee_selected' => $is_all_employee_selected
			);

			// Perform the update in the database
			$result = $this->leave_types_model->save_auto_upgrade_settings($setting_id, $data);

			// Return the response
			if ($result) {
				$response = array('status' => 'success', 'message' => 'Settings saved successfully.');
			} else {
				$response = array('status' => 'error', 'message' => 'Failed to save settings.');
			}
		}

		// Send JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function save_return_confirmation()
	{
		// Load necessary libraries or helpers if not already loaded
		$this->load->library('form_validation');
		$this->load->helper('security');

		// Set validation rules
		//$this->form_validation->set_rules('setting_id', 'Setting ID', 'required|integer');
		$this->form_validation->set_rules('require_return_confirmation', 'Select Return Confirmation', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'status' => 'error',
				'message' => validation_errors()
			);
		} else {
			// Retrieve and sanitize POST data
			$setting_id = 1;
			$require_return_confirmation = $this->input->post('leave_auto_upgrade', TRUE) ? 'yes' : 'no';
			$resumption_period = $this->input->post('resumption_period', TRUE);

			$data = array(
				'require_return_confirmation' => $require_return_confirmation,
				'resumption_period' => $resumption_period
			);

			// Perform the update in the database
			$result = $this->leave_types_model->save_return_confirmation($setting_id, $data);

			// Return the response
			if ($result) {
				$response = array('status' => 'success', 'message' => 'Return confirmation saved successfully.');
			} else {
				$response = array('status' => 'error', 'message' => 'Failed to save Return confirmation.');
			}
		}

		// Send JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function save_remaining_balance()
	{
		// Load necessary libraries or helpers if not already loaded
		$this->load->library('form_validation');
		$this->load->helper('security');

		// Set validation rules
		$this->form_validation->set_rules('remaining_balance', 'Select Remaining Balance Options', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'status' => 'error',
				'message' => validation_errors()
			);
		} else {
			// Retrieve and sanitize POST data
			$setting_id = 1;
			$remaining_balance = $this->input->post('remaining_balance', TRUE);
			$number_of_days = $this->input->post('number_of_days', TRUE);

			$data = array(
				'remaining_balance' => $remaining_balance,
				'number_of_days' => $number_of_days
			);

			// Perform the update in the database
			$result = $this->leave_types_model->save_remaining_balance($setting_id, $data);

			// Return the response
			if ($result) {
				$response = array('status' => 'success', 'message' => 'Remaining balance saved successfully.');
			} else {
				$response = array('status' => 'error', 'message' => 'Failed to save Remaining Balance.');
			}
		}

		// Send JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	/*----- Labout Law ------*/
	public function labour_law()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['labour_laws'] = $this->leave_types_model->get_labour_laws();
		$this->load->view('admin/hr-module/leaves/labour-law', $data);
	}

	public function get_labour_law_form()
	{
		$id = $this->input->get('id');
		$data['labour_laws'] = $this->leave_types_model->get_labour_law_by_id($id);
		$this->load->view('admin/hr-module/leaves/partials/labour_law_form', $data);
	}

	// Method to update leave type
	public function update_labour_law()
	{
		// Retrieve form data
		$id = $this->input->post('id');
		$days_allowed_per_year = $this->input->post('days_allowed_per_year');
		$extend_probation = $this->input->post('extend_probation') ? 'yes' : 'no';

		// Validation rules
		$this->form_validation->set_rules('id', 'ID', 'required|numeric|callback_validate_id');
		$this->form_validation->set_rules('days_allowed_per_year', 'Days Allowed Per Year', 'required|numeric|greater_than[0]|less_than[365]');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "0--" . validation_errors());
			redirect('admin/hr-module/leave-types/labour-law'); // Redirect or load the form again
		} else {
			// Validation passed, prepare data
			$data = array(
				'days_allowed_per_year' => $days_allowed_per_year,
				'extend_probation' => $extend_probation
			);

			// Update the leave type
			if ($this->leave_types_model->update_labour_law($id, $data)) {
				$this->session->set_userdata('info', "1--Leave type updated successfully.");
			} else {
				$this->session->set_userdata('info', "0--Failed to update leave type.");
			}
			redirect('admin/hr-module/leave-types/labour-law'); // Redirect as needed
		}
	}

	// Custom callback to validate ID exists in the database
	public function validate_id($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('leave_types');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			$this->form_validation->set_message('validate_id', 'The {field} does not exist.');
			return FALSE;
		}
	}

	public function update_labour_law_status()
	{
		// Set validation rules
		$this->form_validation->set_rules('id', 'Request Id', 'required');

		if ($this->form_validation->run() == FALSE) {
			$response = array(
				'status' => 'error',
				'message' => validation_errors()
			);
		} else {
			// Retrieve and sanitize POST data
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			// Validate status value
			if (!in_array($status, ['active', 'inactive'])) {
				$response = array('status' => 'success', 'message' => 'Invalid status value.');
				return;
			}
			$data = array(
				'status' => $status
			);

			// Perform the update in the database
			$result = $this->leave_types_model->update_labour_law($id, $data);

			// Return the response
			if ($result) {
				$response = array('status' => 'success', 'message' => 'Labour law leaves updated successfully.');
			} else {
				$response = array('status' => 'error', 'message' => 'Failed to update Labour law leaves.');
			}
		}

		// Send JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	/*----- Custom Leaves ------*/
	public function custom_leaves()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['custom_leaves'] = $this->leave_types_model->get_custom_leaves();
		$this->load->view('admin/hr-module/leaves/custom-leaves', $data);
	}

	public function add_custom_leave_form()
	{
		$this->load->view('admin/hr-module/leaves/partials/add_custom_leave');
	}

	public function edit_custom_leave_form()
	{
		$id = $this->input->get('id');
		$data['custom_leave'] = $this->leave_types_model->get_custom_leave_by_id($id);
		$this->load->view('admin/hr-module/leaves/partials/update_custom_leave', $data);
	}

	public function save_custom_leave()
	{
		// Retrieve form data
		$name = $this->input->post('name');
		$name_ar = $this->input->post('name_ar');
		$days_allowed_per_year = $this->input->post('days_allowed_per_year');
		$extend_probation = $this->input->post('extend_probation') ? 'yes' : 'no';

		// Validation rules
		$this->form_validation->set_rules('name', 'Name in English', 'required');
		$this->form_validation->set_rules('name_ar', 'Name in Arabic', 'required');
		$this->form_validation->set_rules('days_allowed_per_year', 'Days Allowed Per Year', 'required|numeric|greater_than[0]|less_than[365]');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "0--" . validation_errors());
			redirect('admin/hr-module/leave-types/custom-leaves'); // Redirect or load the form again
		} else {
			// Validation passed, prepare data
			$data = array(
				'name' => $name,
				'name_ar' => $name_ar,
				'days_allowed_per_year' => $days_allowed_per_year,
				'leave_group' => 'custom',
				'extend_probation' => $extend_probation
			);

			// Update the leave type
			if ($this->leave_types_model->add_custom_leave($data)) {
				$this->session->set_userdata('info', "1--Custom leave added successfully.");
			} else {
				$this->session->set_userdata('info', "0--Failed to add custom leave.");
			}
			redirect('admin/hr-module/leave-types/custom-leaves'); // Redirect as needed
		}
	}

	public function update_custom_leave()
	{
		// Retrieve form data
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$name_ar = $this->input->post('name_ar');
		$days_allowed_per_year = $this->input->post('days_allowed_per_year');
		$extend_probation = $this->input->post('extend_probation') ? 'yes' : 'no';

		// Validation rules
		$this->form_validation->set_rules('id', 'ID', 'required|numeric|callback_validate_id');
		$this->form_validation->set_rules('name', 'Name in English', 'required');
		$this->form_validation->set_rules('name_ar', 'Name in Arabic', 'required');
		$this->form_validation->set_rules('days_allowed_per_year', 'Days Allowed Per Year', 'required|numeric|greater_than[0]|less_than[365]');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "0--" . validation_errors());
			redirect('admin/hr-module/leave-types/custom-leaves'); // Redirect or load the form again
		} else {
			// Validation passed, prepare data
			$data = array(
				'name' => $name,
				'name_ar' => $name_ar,
				'days_allowed_per_year' => $days_allowed_per_year,
				'leave_group' => 'custom',
				'extend_probation' => $extend_probation
			);

			// Update the leave type
			if ($this->leave_types_model->update_custom_leave($id, $data)) {
				$this->session->set_userdata('info', "1--Custom leave updated successfully.");
			} else {
				$this->session->set_userdata('info', "0--Failed to update custom leave.");
			}
			redirect('admin/hr-module/leave-types/custom-leaves'); // Redirect as needed
		}
	}

	public function delete_custom_leave()
	{
		// Get POST data
		$leave_id = $this->input->post('leave_id');

		// Call the model method to delete the entitlement
		$result = $this->leave_types_model->delete_custom_leave($leave_id);

		if ($result) {
			echo json_encode(['status' => 'success', 'message' => 'Leave deleted successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Error deleting leave.']);
		}
	}
}
