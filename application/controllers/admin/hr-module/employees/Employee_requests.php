<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_requests extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/hr-module/Employee_model');
			$this->load->model('admin/Dlrequest_model');
			$this->load->model('admin/logistic-masters/Master_vehicle_model', 'vehicle_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
			$this->load->helper('request_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function save_request_asset()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('category[]', 'Asset Items', 'required');
		$this->form_validation->set_rules('reason', 'Reason', 'required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			if (!is_array($this->input->post('category')) || empty($this->input->post('category'))) {
				$result = array("type" => 'error', "message" => 'Invalid asset items.');
				echo json_encode($result);
				return;
			}

			// Upload multiple files if provided
			$uploaded_files = array();
			if (!empty($_FILES['attachment']['name'][0])) {
				$file_count = count($_FILES['attachment']['name']);
				for ($i = 0; $i < $file_count; $i++) {
					$_FILES['file']['name'] = $_FILES['attachment']['name'][$i];
					$_FILES['file']['type'] = $_FILES['attachment']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['attachment']['error'][$i];
					$_FILES['file']['size'] = $_FILES['attachment']['size'][$i];

					$upload_result = upload_image('file', './uploads/assets/');
					if ($upload_result['status']) {
						$uploaded_files[] = $upload_result['data']; // Save file path
					} else {
						$result = array("type" => 'error', "message" => $upload_result['data']);
						echo json_encode($result);
						return;
					}
				}
			}

			// Transaction Start
			$this->db->trans_start();

			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $this->input->post('emp_id'),
				'request_type'   => $this->input->post('request_type'),
				'requested_by'   => $this->admin->getLoginEmpId(),
				'request_status' => '1',
				'request_date'   => date('Y-m-d H:i:s'),
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'assets_ids' => $this->input->post('category'),
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'        => $request_id,
				'reason'            => $this->input->post('reason'),
				'request_detail'    => json_encode($secondary_data),
				'request_documents' => !empty($uploaded_files) ? json_encode($uploaded_files) : null, // Store file paths as JSON
			);
			$this->db->insert('employee_request_detail', $detail_data);

			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Assets request submission failed. Please try again.');
			} else {
				$result = array("type" => 'success', "message" => 'Assets request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	//Loan Request
	public function save_loan_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('loan_type', 'Loan Type', 'trim|required');
		$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'trim|required');
		$this->form_validation->set_rules('deduction_start_date', 'Deduction Start Date', 'trim|required');
		$this->form_validation->set_rules('calculation_type', 'Calculation Type', 'trim|required');
		$this->form_validation->set_rules('specified_value', 'Specified Value', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Upload multiple files if provided
			$uploaded_files = array();
			if (!empty($_FILES['attachment']['name'][0])) {
				$file_count = count($_FILES['attachment']['name']);
				for ($i = 0; $i < $file_count; $i++) {
					$_FILES['file']['name'] = $_FILES['attachment']['name'][$i];
					$_FILES['file']['type'] = $_FILES['attachment']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['attachment']['error'][$i];
					$_FILES['file']['size'] = $_FILES['attachment']['size'][$i];

					$upload_result = upload_image('file', './uploads/loan/');
					if ($upload_result['status']) {
						$uploaded_files[] = $upload_result['data']; // Save file path
					} else {
						$result = array("type" => 'error', "message" => $upload_result['data']);
						echo json_encode($result);
						return;
					}
				}
			}

			// Transaction Start
			$this->db->trans_start();

			//Get approvers
			$approvers_persons = [];
			$loan_approver = getApprovers($this->input->post('emp_id'), 'LoanRequest');
			/*
			foreach ($loan_approver as $approver) {
				$approvers_persons[] = [
					'name' => $approver->full_name,
					'arabic_name' => $approver->employee_arabic_name,
					'email' => $approver->email
				];
			}*/

			if (!empty($loan_approver)) {
				$first_approver = $loan_approver[0];
				$approvers_persons[] = [
					'emp_id' => $first_approver->id,
					'name' => $first_approver->full_name,
					'arabic_name' => $first_approver->employee_arabic_name,
					'email' => $first_approver->email,
				];
			}

			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $this->input->post('emp_id'),
				'request_type'   => $this->input->post('request_type'),
				'requested_by'   => $this->admin->getLoginEmpId(),
				'request_status' => '1',
				'request_date'   => date('Y-m-d H:i:s'),
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'type' => $this->input->post('loan_type'), 
				'amount' => $this->input->post('loan_amount'), 
				'deduction_start_date' => date('Y-m-d', strtotime($this->input->post('deduction_start_date'))), 
				'calculation_type' => $this->input->post('calculation_type'), 
				'specified_value' => $this->input->post('specified_value'), 
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'        => $request_id,
				'reason'            => $this->input->post('reason'),
				'request_detail'    => json_encode($secondary_data),
				'request_documents' => !empty($uploaded_files) ? json_encode($uploaded_files) : null,
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			if (!empty($loan_approver)) {
				$approver_log = [];
				$is_first_approver = true; // Flag to identify the first approver
			
				foreach ($loan_approver as $approver) {
					$approver_log[] = [
						'request_id' => $request_id,
						'approver_id' => $approver->id,
						'approver_email' => $approver->email,
						'approve_status' => $is_first_approver ? '1' : '0',
						'created_at' => date('Y-m-d H:i:s'),
					];
					$is_first_approver = false;
				}
			
				$this->db->insert_batch('request_approvers', $approver_log);
			}			

			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Loan request submission failed. Please try again.');
			} else {
				send_mail_to_approvers($approvers_persons);
				$result = array("type" => 'success', "message" => 'Loan request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	//Transaction Request
	public function save_transaction_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('type_of_transaction', 'Transaction Type', 'trim|required');
		$this->form_validation->set_rules('amount', 'Transaction Amount', 'trim|required');
		$this->form_validation->set_rules('payroll_type', 'Payroll Type', 'trim|required');
		$this->form_validation->set_rules('effective_date', 'Effective Date', 'trim|required');
		if($this->input->type="out_payroll"){
			$this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
		}

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Define the upload path
			$upload_path = './uploads/transactions/';

			// Check if the folder exists, if not, create it
			if (!is_dir($upload_path)) {
				if (!mkdir($upload_path, 0755, true)) {
					$result = array("type" => 'error', "message" => 'Failed to create upload folder.');
					echo json_encode($result);
					return;
				}
			}
			// Upload multiple files if provided
			$uploaded_files = array();
			if (!empty($_FILES['attachment']['name'][0])) {
				$file_count = count($_FILES['attachment']['name']);
				for ($i = 0; $i < $file_count; $i++) {
					$_FILES['file']['name'] = $_FILES['attachment']['name'][$i];
					$_FILES['file']['type'] = $_FILES['attachment']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['attachment']['error'][$i];
					$_FILES['file']['size'] = $_FILES['attachment']['size'][$i];

					$upload_result = upload_image('file', $upload_path);
					if ($upload_result['status']) {
						$uploaded_files[] = $upload_result['data']; // Save file path
					} else {
						$result = array("type" => 'error', "message" => $upload_result['data']);
						echo json_encode($result);
						return;
					}
				}
			}

			// Transaction Start
			$this->db->trans_start();

			//Get approvers
			$approvers_persons = [];
			$loan_approver = getApprovers($this->input->post('emp_id'), 'LoanRequest');

			if (!empty($loan_approver)) {
				$first_approver = $loan_approver[0];
				$approvers_persons[] = [
					'emp_id' => $first_approver->id,
					'name' => $first_approver->full_name,
					'arabic_name' => $first_approver->employee_arabic_name,
					'email' => $first_approver->email,
				];
			}

			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $this->input->post('emp_id'),
				'request_type'   => $this->input->post('request_type'),
				'requested_by'   => $this->admin->getLoginEmpId(),
				'approver'   	 => json_encode($approvers_persons),
				'request_status' => '1',
				'request_date'   => date('Y-m-d H:i:s'),
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'type' => $this->input->post('type_of_transaction'), 
				'amount' => $this->input->post('amount'), 
				'payroll_type' => $this->input->post('payroll_type'), 
				'effective_date' => date('Y-m-d', strtotime($this->input->post('effective_date'))),
				'payment_date' => $this->input->post('payment_date'),  
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'        => $request_id,
				'reason'            => $this->input->post('reason'),
				'request_detail'    => json_encode($secondary_data),
				'request_documents' => !empty($uploaded_files) ? json_encode($uploaded_files) : null, // Store file paths as JSON
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			if (!empty($loan_approver)) {
				$approver_log = [];
				$is_first_approver = true; // Flag to identify the first approver
			
				foreach ($loan_approver as $approver) {
					$approver_log[] = [
						'request_id' => $request_id,
						'approver_id' => $approver->id,
						'approver_email' => $approver->email,
						'approve_status' => $is_first_approver ? '1' : '0',
						'created_at' => date('Y-m-d H:i:s'),
					];
					$is_first_approver = false;
				}
			
				$this->db->insert_batch('request_approvers', $approver_log);
			}
			
			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Transaction request submission failed. Please try again.');
			} else {
				send_mail_to_approvers($approvers_persons);
				$result = array("type" => 'success', "message" => 'Transaction request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	//DL Request
	public function save_dl_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('dl_type', 'DL Type', 'trim|required');
		$this->form_validation->set_rules('dl_request_type', 'DL Request Type', 'trim|required');
		$this->form_validation->set_rules('dallah_location', 'Dallah Location', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Upload multiple files if provided
			$uploaded_files = array();
			if (!empty($_FILES['attachment']['name'][0])) {
				$file_count = count($_FILES['attachment']['name']);
				for ($i = 0; $i < $file_count; $i++) {
					$_FILES['file']['name'] = $_FILES['attachment']['name'][$i];
					$_FILES['file']['type'] = $_FILES['attachment']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['attachment']['error'][$i];
					$_FILES['file']['size'] = $_FILES['attachment']['size'][$i];

					$upload_result = upload_image('file', './uploads/dl_request/');
					if ($upload_result['status']) {
						$uploaded_files[] = $upload_result['data']; // Save file path
					} else {
						$result = array("type" => 'error', "message" => $upload_result['data']);
						echo json_encode($result);
						return;
					}
				}
			}

			// Transaction Start
			$this->db->trans_start();
			$requestType = $this->input->post('request_type');
			$requestedImpID = $this->input->post('emp_id');
			$dl_type = $this->input->post('dl_type');
			// Check Previous DL request is pending or not
			$checkingRequest = $this->check_existing_dl_request($requestType, $requestedImpID);
			if ($checkingRequest) {
				$result = array("type" => 'error', "message" => 'DL request already submitted. Please wait for approval.');
				echo json_encode($result);
				return;
			}

			//Check in dl request table
			$dlIssued = $this->Dlrequest_model->check_dl_exist($requestedImpID, $dl_type);
			if($dlIssued){
				$result = array("type" => 'error', "message" => 'DL already issued.');
				echo json_encode($result);
				return;
			}
			//Get approvers
			$approvers_persons = [];
			$dl_approver = getApprovers($this->input->post('emp_id'), 'DlRequest');
			if (!empty($dl_approver)) {
				$first_approver = $dl_approver[0];
				$approvers_persons[] = [
					'emp_id' => $first_approver->id,
					'name' => $first_approver->full_name,
					'arabic_name' => $first_approver->employee_arabic_name,
					'email' => $first_approver->email,
				];
			}
			
			//echo json_encode($dl_approver);exit;
			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $this->input->post('emp_id'),
				'request_type'   => $this->input->post('request_type'),
				'requested_by'   => $this->admin->getLoginEmpId(),
				'request_status' => '1',
				'request_date'   => date('Y-m-d H:i:s'),
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'dl_type' => $this->input->post('dl_type'), 
				'dl_request_type' => $this->input->post('dl_request_type'), 
				'dallah_location' => $this->input->post('dallah_location'), 
				'request_date' => $this->input->post('request_date') ? date('Y-m-d', strtotime($this->input->post('request_date'))) : '',
				'expiry_date' => $this->input->post('expiry_date') ? date('Y-m-d', strtotime($this->input->post('expiry_date'))) : '',
				'blood_group' => $this->input->post('blood_group'), 
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'        => $request_id,
				'reason'            => $this->input->post('reason'),
				'request_detail'    => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
				'request_documents' => !empty($uploaded_files) ? json_encode($uploaded_files) : null,
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			if (!empty($dl_approver)) {
				$approver_log = [];
				$is_first_approver = true; // Flag to identify the first approver
			
				foreach ($dl_approver as $approver) {
					$approver_log[] = [
						'request_id' => $request_id,
						'approver_id' => $approver->id,
						'approver_email' => $approver->email,
						'approve_status' => $is_first_approver ? '1' : '0',
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					];
					$is_first_approver = false;
				}
			
				$this->db->insert_batch('request_approvers', $approver_log);
			}		

			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'DL request submission failed. Please try again.');
			} else {
				send_mail_to_approvers($approvers_persons);
				$result = array("type" => 'success', "message" => 'DL request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	//Check Existing Request
	public function check_existing_dl_request($requestType, $empID)
	{
		$this->db->select('emp_req.*');
		$this->db->from('employee_requests emp_req');
		$this->db->where('emp_req.request_type', $requestType);
		$this->db->where('emp_req.employee_id', $empID);
		$this->db->where_in('emp_req.request_status', [1, 6]); // Block if Pending OR Return for Correction
		$query = $this->db->get();

		return $query->num_rows() > 0;
	}
	
	//Vehicle Allotment Request
	public function save_vehicle_allotment_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('meter_reading', 'Meter Reading', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// ---------------------------------------------------
			// Upload vehicle photos + tamm attachment
			// ---------------------------------------------------
			$file_fields = [
				'vehicle_front_photo',
				'vehicle_back_photo',
				'vehicle_right_photo',
				'vehicle_left_photo',
				'tamm_attachment'
			];

			$uploaded_files = [];

			foreach ($file_fields as $field) {
				if (!empty($_FILES[$field]['name'])) {
					$upload_result = upload_image($field, './uploads/vehicle_allotment_request/');

					if ($upload_result['status']) {
						$uploaded_files[$field] = $upload_result['data'];
					} else {
						echo json_encode(["type" => "error", "message" => $upload_result['data']]);
						return;
					}
				} else {
					$uploaded_files[$field] = null;
				}
			}

			// JSON for DB
			$request_documents = json_encode($uploaded_files);

			// Transaction Start
			$this->db->trans_start();
			$requestType = $this->input->post('request_type');
			$requestedImpID = $this->input->post('emp_id');
			$vehicle_id = $this->input->post('vehicle_id');
			$meter_reading = $this->input->post('meter_reading');
			// Check Previous employee request is pending or not
			$checkingRequest = $this->check_existing_employee_request($requestType, $requestedImpID);
			if ($checkingRequest) {
				$result = array("type" => 'error', "message" => 'Allotment request already submitted for this employee. Please wait for approval.');
				echo json_encode($result);
				return;
			}

			// Check Previous vehicle request is pending or not
			$checkingRequest = $this->check_existing_vehicle_allotment_request($requestType, $vehicle_id);
			if ($checkingRequest) {
				$result = array("type" => 'error', "message" => 'Allotment request already submitted for this vehicle. Please wait for approval.');
				echo json_encode($result);
				return;
			}

			//Check in master vehicle table
			$vehicleIssued = $this->vehicle_model->check_allotment_status($vehicle_id);
			if($vehicleIssued){
				$result = array("type" => 'error', "message" => 'This vehicle already allotted.');
				echo json_encode($result);
				return;
			}

			//Check meter reading
			$last_meter_reading = $this->vehicle_model->get_last_meter_reading($vehicle_id);
			$previous_reading = $last_meter_reading ? $last_meter_reading['meter_reading'] : 0;
			if($previous_reading > $meter_reading){
				$result = array("type" => 'error', "message" => 'Meter reading cannot be less than the last recorded reading.');
				echo json_encode($result);
				return;
			}

			//Get approvers
			$approvers_persons = [];
			$allotmentApprover = getApprovers($this->input->post('emp_id'), 'VehicleAllotmentRequest');
			if (!empty($allotmentApprover)) {
				$first_approver = $allotmentApprover[0];
				$approvers_persons[] = [
					'emp_id' => $first_approver->id,
					'name' => $first_approver->full_name,
					'arabic_name' => $first_approver->employee_arabic_name,
					'email' => $first_approver->email,
				];
			}
			
			//echo json_encode($dl_approver);exit;
			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $this->input->post('emp_id'),
				'request_type'   => $this->input->post('request_type'),
				'requested_by'   => $this->admin->getLoginEmpId(),
				'request_status' => '1',
				'request_date'   => date('Y-m-d H:i:s'),
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'vehicle_id' => $this->input->post('vehicle_id'), 
				'meter_reading' => $this->input->post('meter_reading'), 
				'request_date' => $this->input->post('request_date') ? date('Y-m-d', strtotime($this->input->post('request_date'))) : '',
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'        => $request_id,
				'request_detail'    => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
				'request_documents' => !empty($request_documents) ? $request_documents : null,
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			if (!empty($allotmentApprover)) {
				$approver_log = [];
				$is_first_approver = true; // Flag to identify the first approver
			
				foreach ($allotmentApprover as $approver) {
					$approver_log[] = [
						'request_id' => $request_id,
						'approver_id' => $approver->id,
						'approver_email' => $approver->email,
						'approve_status' => $is_first_approver ? '1' : '0',
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					];
					$is_first_approver = false;
				}
			
				$this->db->insert_batch('request_approvers', $approver_log);
			}		

			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Vehicle allotment request submission failed. Please try again.');
			} else {
				send_mail_to_approvers($approvers_persons);
				$result = array("type" => 'success', "message" => 'Vehicle allotment request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	//Check Existing Request
	public function check_existing_vehicle_allotment_request($requestType, $vehicle_id)
	{
		$this->db->select('emp_req.id');
		$this->db->from('employee_requests emp_req');
		$this->db->join('employee_request_detail emp_det', 'emp_det.request_id = emp_req.id', 'left');

		// Check request type
		$this->db->where('emp_req.request_type', $requestType);

		// Check status (1 = Pending, 6 = Return for Correction)
		$this->db->where_in('emp_req.request_status', [1, 6]);

		// Check inside JSON column
		$this->db->where("JSON_EXTRACT(emp_det.request_detail, '$.vehicle_id') =", $vehicle_id);

		$query = $this->db->get();

		return $query->num_rows() > 0;
	}

	public function check_existing_employee_request($requestType, $empID)
	{
		$this->db->select('emp_req.*');
		$this->db->from('employee_requests emp_req');
		$this->db->where('emp_req.request_type', $requestType);
		$this->db->where('emp_req.employee_id', $empID);
		$this->db->where_in('emp_req.request_status', [1, 6]); // Block if Pending OR Return for Correction
		$query = $this->db->get();

		return $query->num_rows() > 0;
	}
	
	//Transfer Request
	public function save_transfer_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('transfer_type', 'Transfer Type', 'trim|required');
		$this->form_validation->set_rules('new_employer', 'New Employer', 'trim|required');
		$this->form_validation->set_rules('current_employer', 'Current Employer', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
			echo json_encode($result);
			return;
		}

		// Get old and new employer
		$old_employer = $this->input->post('current_employer');
		$new_employer = $this->input->post('new_employer');

		// Check if old and new employer are same
		if ($old_employer == $new_employer) {
			$result = array("type" => 'error', "message" => 'Old employer and new employer cannot be the same.');
			echo json_encode($result);
			return;
		}

		// Transaction Start
		$this->db->trans_start();

		$requestType     = $this->input->post('request_type');
		$requestedImpID  = $this->input->post('emp_id');
		$transfer_type   = $this->input->post('transfer_type');

		// Check previous transfer request is pending or not
		$checkingRequest = $this->check_existing_request($requestType, $requestedImpID);
		if ($checkingRequest) {
			$result = array("type" => 'error', "message" => 'Transfer request already submitted. Please wait for approval.');
			echo json_encode($result);
			return;
		}

		// Get approvers
		$approvers_persons = [];
		$transfer_approver = getApprovers($this->input->post('emp_id'), 'TransferRequest');
		if (!empty($transfer_approver)) {
			$first_approver = $transfer_approver[0];
			$approvers_persons[] = [
				'emp_id'      => $first_approver->id,
				'name'        => $first_approver->full_name,
				'arabic_name' => $first_approver->employee_arabic_name,
				'email'       => $first_approver->email,
			];
		}

		// Insert into `employee_requests`
		$request_data = array(
			'employee_id'    => $this->input->post('emp_id'),
			'request_type'   => $this->input->post('request_type'),
			'requested_by'   => $this->admin->getLoginEmpId(),
			'request_status' => '1',
			'request_date'   => date('Y-m-d H:i:s'),
			'created_at'     => date('Y-m-d H:i:s'),
			'updated_at'     => date('Y-m-d H:i:s'),
		);
		$this->db->insert('employee_requests', $request_data);
		$request_id = $this->db->insert_id();

		$secondary_data = array(
			'current_employer'     => $old_employer, 
			'transfer_type'        => $transfer_type, 
			'request_date'         => $this->input->post('request_date') ? date('Y-m-d', strtotime($this->input->post('request_date'))) : '',
			'new_employer'         => $new_employer,
			'update_joining_date'  => $this->input->post('update_joining_date') ? 'yes' : 'no',
			'contract_id'          => $this->input->post('contract_id'),
			'contract_period'      => $this->input->post('contract_period'),
			'contract_start_date'  => $this->input->post('contract_start_date'),
			'contract_end_date'    => $this->input->post('contract_end_date')
		);

		// Insert into `employee_request_detail`
		$detail_data = array(
			'request_id'        => $request_id,
			'reason'            => $this->input->post('reason'),
			'request_detail'    => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
			'request_documents' => null,
		);
		$this->db->insert('employee_request_detail', $detail_data);

		// Insert Approvers
		if (!empty($transfer_approver)) {
			$approver_log = [];
			$is_first_approver = true;

			foreach ($transfer_approver as $approver) {
				$approver_log[] = [
					'request_id'      => $request_id,
					'approver_id'     => $approver->id,
					'approver_email'  => $approver->email,
					'approve_status'  => $is_first_approver ? '1' : '0',
					'created_at'      => date('Y-m-d H:i:s'),
					'updated_at'      => date('Y-m-d H:i:s'),
				];
				$is_first_approver = false;
			}

			$this->db->insert_batch('request_approvers', $approver_log);
		}       

		// Transaction Complete
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$result = array("type" => 'error', "message" => 'Transfer request submission failed. Please try again.');
		} else {
			send_mail_to_approvers($approvers_persons);
			$result = array("type" => 'success', "message" => 'Transfer request successfully submitted.');
		}

		// Return the result as JSON
		echo json_encode($result);
		return;
	}
	
	//Profession Request
	public function save_profession_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('current_profession', 'Current Profession', 'trim|required');
		$this->form_validation->set_rules('new_profession', 'New Profession', 'trim|required');
		$this->form_validation->set_rules('debit_cost_to', 'Debit Cost to', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
			echo json_encode($result);
			return;
		}

		// Get old and new profession
		$old_profession = $this->input->post('current_profession');
		$new_profession = $this->input->post('new_profession');

		// Check if old and new profession are same
		if ($old_profession == $new_profession) {
			$result = array("type" => 'error', "message" => 'Old profession and new profession cannot be the same.');
			echo json_encode($result);
			return;
		}

		// Transaction Start
		$this->db->trans_start();

		$requestType     = $this->input->post('request_type');
		$requestedImpID  = $this->input->post('emp_id');

		// Check previous transfer request is pending or not
		$checkingRequest = $this->check_existing_request($requestType, $requestedImpID);
		if ($checkingRequest) {
			$result = array("type" => 'error', "message" => 'Change profession request already submitted. Please wait for approval.');
			echo json_encode($result);
			return;
		}

		// Get approvers
		$approvers_persons = [];
		$profession_approver = getApprovers($this->input->post('emp_id'), 'ChangeProfessionRequest');
		if (!empty($profession_approver)) {
			$first_approver = $profession_approver[0];
			$approvers_persons[] = [
				'emp_id'      => $first_approver->id,
				'name'        => $first_approver->full_name,
				'arabic_name' => $first_approver->employee_arabic_name,
				'email'       => $first_approver->email,
			];
		}

		// Insert into `employee_requests`
		$request_data = array(
			'employee_id'    => $this->input->post('emp_id'),
			'request_type'   => $this->input->post('request_type'),
			'requested_by'   => $this->admin->getLoginEmpId(),
			'request_status' => '1',
			'request_date'   => date('Y-m-d H:i:s'),
			'created_at'     => date('Y-m-d H:i:s'),
			'updated_at'     => date('Y-m-d H:i:s'),
		);
		$this->db->insert('employee_requests', $request_data);
		$request_id = $this->db->insert_id();

		$secondary_data = array(
			'current_profession'=> $old_profession,
			'request_date'      => $this->input->post('request_date') ? date('Y-m-d', strtotime($this->input->post('request_date'))) : '',
			'new_profession'    => $new_profession,
			'debit_cost_to'     => $this->input->post('debit_cost_to'),
			'fee_amount'      	=> 1000,
		);

		// Insert into `employee_request_detail`
		$detail_data = array(
			'request_id'        => $request_id,
			'request_detail'    => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
			'request_documents' => null,
		);
		$this->db->insert('employee_request_detail', $detail_data);

		// Insert Approvers
		if (!empty($profession_approver)) {
			$approver_log = [];
			$is_first_approver = true;

			foreach ($profession_approver as $approver) {
				$approver_log[] = [
					'request_id'      => $request_id,
					'approver_id'     => $approver->id,
					'approver_email'  => $approver->email,
					'approve_status'  => $is_first_approver ? '1' : '0',
					'created_at'      => date('Y-m-d H:i:s'),
					'updated_at'      => date('Y-m-d H:i:s'),
				];
				$is_first_approver = false;
			}

			$this->db->insert_batch('request_approvers', $approver_log);
		}       

		// Transaction Complete
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$result = array("type" => 'error', "message" => 'Change profession request submission failed. Please try again.');
		} else {
			send_mail_to_approvers($approvers_persons);
			$result = array("type" => 'success', "message" => 'Change profession request successfully submitted.');
		}

		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	//Check Existing Request
	public function check_existing_request($requestType, $empID)
	{
		$this->db->select('emp_req.*');
		$this->db->from('employee_requests emp_req');
		$this->db->where('emp_req.request_type', $requestType);
		$this->db->where('emp_req.employee_id', $empID);
		$this->db->where_not_in('emp_req.request_status', [3,4,5]);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	//Send OTP
	public function send_otp() {
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			$empDetail = employeeDetailHelper($emp_id);
			if ($empDetail) {
				// Generate a random OTP
				$otp = rand(100000, 999999);
		
				// Store OTP in session
				$this->session->set_userdata('otp_data', [
					'otp' => $otp,
					'emp_id' => $empDetail->id,
					'emp_email' => $empDetail->email,
					'created_at' => time() // Store the time to handle expiration
				]);
		
				// Simulate OTP sending (via SMS or Email)
				$email_data = array(
					'employee_id' => $empDetail->id,
					'request_type' => 'ClinicalVisitRequest',
					'email' => $empDetail->email,
					'name' => $empDetail->full_name,
					'otp' => $otp
				);
				send_otp_mail($email_data);
				$result = array("type" => 'success', "message" => 'OTP sent successfully.');
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found.');
			}
		}
		echo json_encode($result);
		return;
	}
	
	public function resend_otp() {
		$otp_data = $this->session->userdata('otp_data');
	
		if ($otp_data) {
			// Check if the session contains OTP data
			$otp = $otp_data['otp'];
			$emp_id = $otp_data['emp_id'];
			$emp_email = $otp_data['emp_email'];
	
			// Resend OTP (Simulate SMS or Email delivery)
			$empDetail = employeeDetailHelper($emp_id);
			$email_data = array(
				'employee_id' => $empDetail->id,
				'request_type' => 'ClinicalVisitRequest',
				'email' => $empDetail->email,
				'name' => $empDetail->full_name,
				'otp' => $otp
			);
			send_otp_mail($email_data);
			$result = array("type" => 'error', "message" => 'OTP resent successfully.');
		} else {
			$result = array("type" => 'error', "message" => 'OTP sending failed, Refresh page and try to send OTP again.');
		}
		echo json_encode($result);
		return;
	}
	
	public function verify_otp() {
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
			echo json_encode($result);
			return;
		} else {
			$user_otp = $this->input->post('otp');
			$otp_data = $this->session->userdata('otp_data');
			//print_r($user_otp);exit();
			if ($otp_data) {
				$stored_otp = $otp_data['otp'];
				$otp_created_at = $otp_data['created_at'];
				$current_time = time();
		
				// Check if the OTP is expired (e.g., valid for 10 minutes)
				if ($current_time - $otp_created_at > 600) { // 600 seconds = 10 minutes
					$result = array("type" => 'error', "message" => 'OTP has expired.');
					echo json_encode($result);return;
				}
		
				// Validate the entered OTP
				if ($user_otp == $stored_otp) {
					$result = array("type" => 'success', "message" => 'OTP verified successfully.');
					echo json_encode($result);return;
					//$this->session->unset_userdata('otp_data'); // Clear OTP from session
				} else {
					$result = array("type" => 'error', "message" => 'You have entered wrong OTP.');
					echo json_encode($result);return;
				}
			} else {
				$result = array("type" => 'error', "message" => 'OTP verification failed, Refresh page and try to send OTP again.');
				echo json_encode($result);return;
			}
		}
	}
	
	//Check Existing Request
	public function ajax_slot_availability(){
		$reqDate = $this->input->post('request_date');
		$isAvailable = $this->verify_slot_availability($reqDate);
		if ($isAvailable > 13) {
			echo json_encode([
				"type" => "error",
				"message" => "No slots available. You cannot book more than 13 Clinical Visit Requests in a day."
			]);
			return;
		}else{
			echo json_encode([
				"type" => "success",
				"message" => "Slot available."
			]);
			return;
		}
	}

	public function verify_slot_availability($date, $emp_id = null)
	{
		// Count the total number of ClinicalVisitRequest for the given date
		$this->db->select('COUNT(*) AS total_requests');
		$this->db->from('employee_requests emp_req');
		$this->db->where('emp_req.request_type', 'ClinicalVisitRequest');
		$this->db->where('DATE(emp_req.request_date)', $date);
		if($emp_id){
			$this->db->where('emp_req.employee_id', $emp_id);
		}
		$this->db->where_not_in('emp_req.request_status', [0,1,3,4,5,6,7]);
		$query = $this->db->get();
		$result = $query->row();
		return $result->total_requests;
	}

	public function save_clinical_request()
	{
		// Form validation rules
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('visit_type', 'Visit Type', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Clinical Visit Date', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Upload multiple files if provided
			$uploaded_files = array();
			if (!empty($_FILES['attachment']['name'][0])) {
				$file_count = count($_FILES['attachment']['name']);
				for ($i = 0; $i < $file_count; $i++) {
					$_FILES['file']['name'] = $_FILES['attachment']['name'][$i];
					$_FILES['file']['type'] = $_FILES['attachment']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['attachment']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['attachment']['error'][$i];
					$_FILES['file']['size'] = $_FILES['attachment']['size'][$i];

					$upload_result = upload_image('file', './uploads/dl_request/');
					if ($upload_result['status']) {
						$uploaded_files[] = $upload_result['data']; // Save file path
					} else {
						$result = array("type" => 'error', "message" => $upload_result['data']);
						echo json_encode($result);
						return;
					}
				}
			}

			// Transaction Start
			$this->db->trans_start();
			$requestType = $this->input->post('request_type');
			$requestedImpID = $this->input->post('emp_id');
			$visit_type = $this->input->post('visit_type');
			$req_date = $this->input->post('request_date');
			// Check Prevoiuse Dl request is pending or not
			$isAvailable = $this->verify_slot_availability($req_date);
			if ($isAvailable) {
				$result = array("type" => 'error', "message" => 'No slots available. You cannot book more than 13 Clinical Visit Requests in a day.');
				echo json_encode($result);
				return;
			}

			//Check in dl request table
			$visitIssued = $this->verify_slot_availability($req_date, $requestedImpID);
			if($visitIssued){
				$result = array("type" => 'error', "message" => 'Clinical visit already requested.');
				echo json_encode($result);
				return;
			}
			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $this->input->post('emp_id'),
				'request_type'   => $requestType,
				'requested_by'   => $this->admin->getLoginEmpId(),
				'request_status' => '2',
				'final_approver' => $this->admin->getLoginEmpId(),
				'request_date'   => date('Y-m-d H:i:s'),
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'visit_type' => $visit_type,
				'request_date' => $this->input->post('request_date') ? date('Y-m-d', strtotime($this->input->post('request_date'))) : ''
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'        => $request_id,
				'reason'            => $this->input->post('reason'),
				'request_detail'    => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
				'request_documents' => !empty($uploaded_files) ? json_encode($uploaded_files) : null,
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			$approverDetails = employeeDetailHelper($this->admin->getLoginEmpId());
			if (!empty($approverDetails)) {
				$approver_log = [
					'request_id' => $request_id,
					'approver_id' => $approverDetails->id,
					'approver_email' => $approverDetails->email,
					'approve_status' => '2',
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$this->db->insert('request_approvers', $approver_log);
			}

			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Clinical visit request submission failed. Please try again.');
			} else {
				// Simulate OTP sending (via SMS or Email)
				$empDetail = employeeDetailHelper($request_data['employee_id']);
				$email_data = array(
					'employee_id' => $request_data['employee_id'],
					'request_type' => 'ClinicalVisitRequest',
					'email' => $empDetail->email,
					'visit_type' => $visit_type,
					'visit_date' => $req_date,
					'name' => $empDetail->full_name
				);
				send_booking_confirmation_mail($email_data);
				$this->session->unset_userdata('otp_data');
				$result = array("type" => 'success', "message" => 'Clinical visit request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}
	
	//Notices and Warning Request

	public function save_warning_request()
	{
		// Always required fields
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required');
		$this->form_validation->set_rules('warning_type', 'Warning Type', 'required');

		$warningType = $this->input->post('warning_type');

		// Only validate text fields if NOT "Absconded"
		if ($warningType !== 'Absconded') {
			$this->form_validation->set_rules('title_arabic', 'Title Arabic', 'trim|required');
			$this->form_validation->set_rules('title_english', 'Title English', 'trim|required');
			$this->form_validation->set_rules('description_arabic', 'Description Arabic', 'trim|required');
			$this->form_validation->set_rules('description_english', 'Description English', 'trim|required');
		}

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Transaction Start
			$this->db->trans_start();

			$requestType = $this->input->post('request_type');
			$requestedImpID = $this->input->post('emp_id');
			$req_date = $this->input->post('request_date');
			$title_arabic = $this->input->post('title_arabic');
			$title_english = $this->input->post('title_english');
			$description_arabic = $this->input->post('description_arabic');
			$description_english = $this->input->post('description_english');
			
			//Get approvers
			$approvers_persons = [];
			$notice_approver = getApprovers($requestedImpID, 'NoticesAndWarning');
			if (!empty($notice_approver)) {
				$first_approver = $notice_approver[0];
				$approvers_persons[] = [
					'emp_id' => $first_approver->id,
					'name' => $first_approver->full_name,
					'arabic_name' => $first_approver->employee_arabic_name,
					'email' => $first_approver->email,
				];
			}
			
			// Insert into `employee_requests`
			$request_data = array(
				'employee_id'    => $requestedImpID,
				'request_type'   => $requestType,
				'requested_by'   => $this->admin->getLoginEmpId(),
				'request_status' => '1',
				'final_approver' => $this->admin->getLoginEmpId(),
				'request_date'   => $req_date,
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			);
			$this->db->insert('employee_requests', $request_data);
			$request_id = $this->db->insert_id();

			$secondary_data = array(
				'type' => $warningType,
				'title_arabic' => $warningType !== 'Absconded' ? $title_arabic : ' تغيب بشأن إش',
				'title_english' => $warningType !== 'Absconded' ? $title_english : 'Absence of Employee Notification',
				'description_arabic' => $warningType !== 'Absconded' ? $description_arabic : null,
				'description_english' => $warningType !== 'Absconded' ? $description_english : null,
				'request_date' => $req_date ? $req_date : '',
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'     => $request_id,
				'reason'         => $warningType !== 'Absconded' ? $title_english : 'Absence of Employee Notification',
				'request_detail' => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			if (!empty($notice_approver)) {
				$approver_log = [];
				$is_first_approver = true;
				foreach ($notice_approver as $approver) {
					$approver_log[] = [
						'request_id'      => $request_id,
						'approver_id'     => $approver->id,
						'approver_email'  => $approver->email,
						'approve_status'  => $is_first_approver ? '1' : '0',
						'created_at'      => date('Y-m-d H:i:s'),
						'updated_at'      => date('Y-m-d H:i:s'),
					];
					$is_first_approver = false;
				}
				$this->db->insert_batch('request_approvers', $approver_log);
			}

			// Transaction Complete
			$this->db->trans_complete();

			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => $warningType.' request submission failed. Please try again.');
			} else {
				send_mail_to_approvers($approvers_persons);
				$result = array("type" => 'success', "message" => $warningType.' request successfully submitted.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

}
