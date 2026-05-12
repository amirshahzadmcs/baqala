<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_ids extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-management/Logistic_ids_model', 'ids_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'aggregator_id', $this->action)) {
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
		$this->load->view('admin/logistic-management/logistic_ids/index', $data);
	}

	public function get_ajax_list()
	{
		$fetch_data = $this->ids_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $key_data) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $key_data->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = $key_data->food_company;
			$sub_array[] = $key_data->id_number;
			//$sub_array[] = $key_data->id_type;
			$sub_array[] = ($key_data->flex_no == '') ? 'NA' : $key_data->flex_no;
			//$sub_array[] = ($key_data->request_date !== '' && $key_data->request_date !== '0000-00-00' && $key_data->request_date !== NULL) ? date('d-m-Y', strtotime($key_data->request_date)) : 'NA';
			$sub_array[] = ($key_data->activation_date !== '' && $key_data->activation_date !== '0000-00-00' && $key_data->activation_date !== NULL) ? date('d-m-Y', strtotime($key_data->activation_date)) : 'NA';

			// Status badge
			$status_badge = $key_data->status == 'active'
				? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>'
				: ($key_data->status == 'inactive'
					? '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'
					: ($key_data->status == 'suspend'
						? '<span class="badge badge-pill badge-soft-warning font-size-13">Suspend</span>'
						: ($key_data->status == 'terminated'
							? '<span class="badge badge-pill badge-soft-dark font-size-13">Terminated</span>'
							: '<span class="badge badge-pill badge-soft-info font-size-13">Requested</span>'
						)
					)
				);

			$sub_array[] = $status_badge;
			$allotedPerson = employeeDetailHelper($key_data->alloted_user);
			$sub_array[] = (!empty($allotedPerson)) ? $allotedPerson->emp_no . ' - ' . $allotedPerson->full_name : 'NA';
			$sub_array[] = (!empty($allotedPerson)) ? '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Not Alloted</span>';
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));

			$sub_array[] = (check_action_permission(get_user_role(), 'aggregator_id', 'edit') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit load_edit_modal" title="Edit" onclick="editModal(' . $key_data->id . ')"><i class="mdi mdi-pencil font-size-18"></i></button>' : '') . (check_action_permission(get_user_role(), 'aggregator_id', 'detail') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="detailModal(' . $key_data->id . ')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>' : '');
			$sub_array[] = $key_data->emp_status;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->ids_model->get_all_data(),
			"recordsFiltered" => $this->ids_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'aggregator_id', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/logistic-management/logistic_ids/components/add-form');
	}

	public function save()
	{
		$this->form_validation->set_rules('owner_id', 'Select Id Owner', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');
		$this->form_validation->set_rules('activation_date', 'Activation Date', 'trim|required');
		$this->form_validation->set_rules('platform_id', 'Platform', 'trim|required|callback_check_duplicate_platform');
		$this->form_validation->set_message('check_duplicate_platform', 'Owner with this aggregator already registered, Try new');
		$this->form_validation->set_rules('id_number', 'Id Number', 'trim|required|callback_check_id_duplicate');
		$this->form_validation->set_message('check_id_duplicate', 'Owner with this id number already registered, Try new');
		$this->form_validation->set_rules('id_type', 'Id TYpe', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$data = array(
				'owner_id' => $this->input->post('owner_id'),
				'request_date' => $this->input->post('request_date'),
				'activation_date' => $this->input->post('activation_date'),
				'platform_id' => $this->input->post('platform_id'),
				'id_type' => $this->input->post('id_type'),
				'id_number' => $this->input->post('id_number'),
				'status' => $this->input->post('status'),
				'created_at' => CURRENT_TIME
			);
			// Save data using the model
			$insert_id = $this->ids_model->add($data);
			if ($insert_id) {
				$result = array("type" => 'success', "message" => 'Id successfully added.');
			} else {
				$result = array("type" => 'error', "message" => 'Something went wrong, try again');
			}
		}
		echo json_encode($result);
	}

	public function check_duplicate_platform($platform_id)
	{
		$id = $this->input->post('id');
		$owner_id = $this->input->post('owner_id');

		// Check for duplicates using the model method
		if ($this->ids_model->checkDuplicatePlatform($id, $owner_id, $platform_id)) {
			$this->form_validation->set_message('check_duplicate_platform', 'This owner already registered for selected aggregator, try a new one');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_id_duplicate($id_number)
	{
		$id = $this->input->post('id');
		$owner_id = $this->input->post('owner_id');

		// Check for duplicates using the model method
		if ($this->ids_model->checkDuplicateId($id, $owner_id, $id_number)) {
			$this->form_validation->set_message('check_id_duplicate', 'This owner already registered for selected id number, try a new one');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'aggregator_id', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->ids_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['id_detail'] = $query->row_array();
				$output_data = $this->load->view('admin/logistic-management/logistic_ids/components/edit-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Id detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Id detail not found, try another id number.');
			}
		}
		echo json_encode($result);
	}

	public function get_city_details()
	{
		if ($this->input->post('city_id')) {
			$city_id = $this->input->post('city_id');
			$city_details = cityDetailHelper($city_id);
			echo is_object($city_details) ? $city_details->city_name : $city_details;
		}
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'aggregator_id', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->ids_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['id_detail'] = $query->row_array();
				$output_data = $this->load->view('admin/logistic-management/logistic_ids/components/detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Id detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Id detail not found, try another id number.');
			}
		}
		echo json_encode($result);
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request Id', 'trim|required');
		$this->form_validation->set_rules('owner_id', 'Select Id Owner', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');
		$this->form_validation->set_rules('activation_date', 'Activation Date', 'trim|required');
		$this->form_validation->set_rules('platform_id', 'Platform', 'trim|required|callback_check_duplicate_platform');
		$this->form_validation->set_message('check_duplicate_platform', 'Owner with this platform already registered, Try new');
		$this->form_validation->set_rules('id_number', 'Id Number', 'trim|required|callback_check_id_duplicate');
		$this->form_validation->set_message('check_id_duplicate', 'Owner with this id number already registered, Try new');
		$this->form_validation->set_rules('id_type', 'Id TYpe', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			if ($this->input->post('status') == 'terminated') {
				$this->form_validation->set_rules('termination_date', 'Terminate Date', 'trim|required');
				$this->form_validation->set_rules('reason', 'Terminate Reason', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
					$result = array("type" => 'error', "message" => validation_errors());
					echo json_encode($result);
					exit();
				}
				//Check plateform id is alloted to any other user
				$alloted_user = $this->ids_model->checkIdNumberAlloted($this->input->post('id_number'));
				if ($alloted_user) {
					$result = array("type" => 'error', "message" => 'First unallocate this id number from rider');
					echo json_encode($result);
					exit();
				}
			}
			$data = array(
				'owner_id' => $this->input->post('owner_id'),
				'request_date' => $this->input->post('request_date'),
				'activation_date' => $this->input->post('activation_date'),
				'platform_id' => $this->input->post('platform_id'),
				'id_type' => $this->input->post('id_type'),
				//'id_number' => $this->input->post('id_number'),
				'status' => $this->input->post('status'),
				'created_at' => CURRENT_TIME
			);
			if ($this->input->post('status') == 'terminated') {
				$data['termination_date'] = $this->input->post('termination_date');
				$data['reason'] = $this->input->post('reason');
			}
			// Save data using the model
			$updated = $this->ids_model->update($id, $data);
			if ($updated) {
				$result = array("type" => 'success', "message" => 'Id detail successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'Id detail not updated');
			}
		}
		echo json_encode($result);
	}

	// Callback functions for date validation
	public function valid_date($date)
	{
		$formatDate = date('Y-m-d', strtotime($date));
		if (DateTime::createFromFormat('Y-m-d', $formatDate) !== FALSE) {
			return TRUE;
		} else {
			$this->form_validation->set_message('valid_date', 'The {field} field must be a valid date.');
			return FALSE;
		}
	}

	public function valid_date_range($date_to)
	{
		$date_from = $this->input->post('suspend_from');
		if (strtotime($date_to) >= strtotime($date_from)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('valid_date_range', 'The Suspend To date must be later than the Suspend From date.');
			return FALSE;
		}
	}

	public function check_id_number()
	{
		$rider_id = $this->input->post('rider_id');
		$this->load->model('ids_model');
		$id_number = $this->ids_model->get_id_number($rider_id);
		if ($id_number) {
			echo json_encode(['status' => 'error', 'message' => '<i class="mdi mdi-information-outline"></i> An ID number is already assigned to this user. Assigning a new one will deactivate the existing ID']);
		} else {
			echo json_encode(['status' => 'success']);
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'aggregator_id', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$delete_result = $this->ids_model->delete($ids);

		$success_ids = [];
		$error_messages = [];

		foreach ($delete_result as $result) {
			if ($result['status'] == 'success') {
				$success_ids[] = $result['id'];
			} else {
				$error_messages[] = $result['id'] . " - " . $result['message'];
			}
		}

		// Prepare the final message for the session
		if (!empty($success_ids)) {
			$this->session->set_flashdata('info', "1--Successfully deleted IDs: " . implode(', ', $success_ids));
		}

		if (!empty($error_messages)) {
			$this->session->set_flashdata('info', "2--Failed to delete some IDs: " . implode(' | ', $error_messages));
		}

		// Redirect back to the list
		redirect('admin/logistic-management/platform-id/list');
	}

	public function fetch_filter_data()
	{
		$filter_type = $this->input->get('filter_type');
		$search_query = $this->input->get('query');

		// Determine which filter data to fetch based on 'filter_type'
		switch ($filter_type) {
			case 'id_number':
				$data = $this->ids_model->get_filtered_id_numbers($search_query);
				break;
			case 'owner':
				$data = $this->ids_model->get_filtered_owner($search_query);
				break;
			case 'alloted_to':
				$data = $this->ids_model->get_filtered_alloted_to($search_query);
				break;
			default:
				$data = [];
		}
		// Return the result as JSON
		echo json_encode($data);
	}
}
