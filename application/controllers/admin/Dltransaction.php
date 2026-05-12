<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dltransaction extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Dltransaction_model', 'Dt_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'dl_transactions', $this->action)):
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
		$data['dl_requests'] = $this->Dt_model->dl_request_list();
		$this->load->view('admin/dl_transaction/index', $data);
	}

	public function add()
	{
		$this->load->view('admin/dl_transaction/form');
	}

	public function edit($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'dl_transactions', $this->action)):
			redirect('admin/unauthorized-request');

		endif;
		if ($id > 0) {
			$data['dl_detail'] = $this->Dt_model->get_detail($id); // <== FIXED
			$output_data = $this->load->view('admin/dl_transaction/edit', $data, TRUE);
			$result = array(
				"type" => 'success',
				"message" => 'Transaction detail successfully fetched.',
				"output_html" => $output_data
			);
		} else {
			$result = array(
				"type" => 'error',
				"message" => 'Invalid request ID!'
			);
		}
		echo json_encode($result);
	}

	public function save()
	{
		$this->form_validation->set_rules(
			'transaction_type',
			'Appointment Type',
			'trim|required|callback_check_trans_duplicate'
		);
		$this->form_validation->set_message(
			'check_trans_duplicate',
			'Appointment type already exist, Try new'
		);
		$this->form_validation->set_rules('request_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_rules('trans_date', 'Transaction Date', 'trim|required');
		//$this->form_validation->set_rules('trans_date', 'Transaction Date', 'trim|required|callback_validate_date_not_past');

		$currentStatus  = (int) $this->input->post('current_status');
		$selectedStatus = (int) $this->input->post('transaction_type');
		$requestType    = $this->input->post('dl_request_type');

		/*
		|-------------------------------------------------
		| STATUS FLOWS
		|-------------------------------------------------
		*/
		$directFlow = [10, 0, 9];
		$normalFlow = [10, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

		$statusFlow = ($requestType === 'Direct') ? $directFlow : $normalFlow;

		$currentIndex = array_search($currentStatus, $statusFlow, true);

		// Safety check
		if ($currentIndex === false) {
			$this->session->set_userdata('info', "2--Invalid current status.");
			redirect('admin/dl-request/list');
			return;
		}

		$nextIndex = $currentIndex + 1;

		// Skip Repeat Exam (6) ONLY for normal flow
		if ($requestType !== 'Direct'
			&& isset($statusFlow[$nextIndex])
			&& $statusFlow[$nextIndex] === 6
		) {
			$nextIndex++;
		}

		$allowedStatuses = [$currentStatus];

		if (isset($statusFlow[$nextIndex])) {
			$allowedStatuses[] = $statusFlow[$nextIndex];
		}

		if (!in_array($selectedStatus, $allowedStatuses, true)) {
			$this->session->set_userdata(
				'info',
				"2--You can only select the current status or the next allowed step."
			);
			redirect('admin/dl-request/list');
			return;
		}

		/*
		|-------------------------------------------------
		| FORM VALIDATION & SAVE
		|-------------------------------------------------
		*/
		if ($this->form_validation->run() === FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Dt_model->add();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}

		redirect('admin/dl-request/list');
	}

	public function update()
	{


		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		//$this->form_validation->set_message('check_trans_duplicate','Appointment type already exist, Try new');
		//$this->form_validation->set_rules('request_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_rules('trans_amount', 'Amount', 'trim|required');
		//$this->form_validation->set_rules('trans_date', 'Transaction Date', 'trim|required|callback_validate_date_not_past');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->Dt_model->edit();
			if ($query) {
				$result = array("type" => 'success', "message" => 'Tranasction amount successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'Something went wrong, try again');
			}
		}
		echo json_encode($result);
	}

	public function validate_date_not_past($date)
	{
		$input_date = DateTime::createFromFormat('Y-m-d', $date);
		if (!$input_date) {
			$this->form_validation->set_message('validate_date_not_past', 'The {field} is not in a valid date format.');
			return false;
		}
		$input_timestamp = $input_date->getTimestamp();
		$two_days_ago = strtotime('-2 days');

		if ($input_timestamp < $two_days_ago) {
			$this->form_validation->set_message('validate_date_not_past', 'The {field} cannot be more than two days in the past.');
			return false;
		}

		return true;
	}

	public function check_trans_duplicate()
	{
		$id = $this->input->post('id');
		$transaction_type = $this->input->post('transaction_type');
		$request_id = $this->input->post('request_id');
		$duplicate_check = $this->Dt_model->check_duplicate_employee($id, $request_id, $transaction_type);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function detail()
	{
		if ($this->input->get('id')) {
			$data['trans_detail'] = $this->Dt_model->get_detail($this->input->get('id'));
			$this->load->view('admin/dl_transaction/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request or unauthorized access!");
			redirect('admin/dl-transaction/list');
		}
	}

	public function get_ajax_list()
	{
		$fetch_data = $this->Dt_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $key_data) {
			$current_status_name = 'DL Requested';
			$trans_status = $key_data->transaction_type;
			if ($trans_status == '10') {
				$current_status_name = 'DL Requested';
			}
			if ($trans_status == '0') {
				$current_status_name = 'DL Appointment';
			}
			if ($trans_status == '1') {
				$current_status_name = 'DL File';
			}
			if ($trans_status == '2') {
				$current_status_name = 'DL Class 1';
			}
			if ($trans_status == '3') {
				$current_status_name = 'DL Class 2';
			}
			if ($trans_status == '4') {
				$current_status_name = 'DL Computer Exam';
			}
			if ($trans_status == '5') {
				$current_status_name = 'DL Final Test';
			}
			if ($trans_status == '6') {
				$current_status_name = 'DL Repeat Exam';
			}
			if ($trans_status == '7') {
				$current_status_name = 'DL Medical';
			}
			if ($trans_status == '8') {
				$current_status_name = 'DL Basma';
			}
			if ($trans_status == '9') {
				$current_status_name = 'Dl Issued';
			}
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $key_data->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->trans_id;
			$sub_array[] = $key_data->request_no;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = ucfirst($key_data->dl_type);
			$sub_array[] = $current_status_name;
			$sub_array[] = $key_data->cost_involve;
			$sub_array[] = $key_data->trans_amount;
			$sub_array[] = (!empty($key_data->request_date)) ? date('d-m-Y', strtotime($key_data->request_date)) : 'NA';
			$sub_array[] = (!empty($key_data->trans_date)) ? date('d-m-Y', strtotime($key_data->trans_date)) : 'NA';
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			$sub_array[] = check_action_permission(get_user_role(), 'dl_transactions', 'edit') ? '<a type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit load_edit_modal" title="Edit" data-id="' . $key_data->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Dt_model->get_all_data(),
			"recordsFiltered"     =>     $this->Dt_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'dl_transactions', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->Dt_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/dl-transaction/list');
	}
}
