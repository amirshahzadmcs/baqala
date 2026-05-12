<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Team_requests extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/hr-module/Approval_model');
			$this->load->model('admin/Dlrequest_model','dl_model');
			$this->load->model('admin/finance/Paymentrequest_model', 'payment_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('request_helper');
			$this->load->helper('sendmail_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->action=$this->router->fetch_method();
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index($status = null)
	{
		if($this->action && !check_action_permission(get_user_role(), 'team_request', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if (!$status) {
			redirect('404', 'refresh');
			return;
		}

		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1] ?? '';
			$data['info_type'] = $info[0] ?? '';
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}

		$statusMapping = [
			'pending' => ['status' => [1, 6]],
			'approved' => ['status' => [2]],
			'rejected' => ['status' => [3]],
			'expired' => ['status' => [4]],
			'canceled' => ['status' => [5]],
			'all' => ['status' => [1, 2, 3, 4, 5, 6]],
		];

		$reqStatus = $statusMapping[$status] ?? $statusMapping['all'];
		$data['requests'] = $this->Approval_model->getEmployeeRequests($reqStatus['status']);
		return $this->load->view('admin/hr-module/request-approvals/index', $data);
	}

	public function request_detail()
	{
		if($this->action && !check_action_permission(get_user_role(), 'team_request', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$id = $this->input->get('request_id');
			if ($id <= 0) {
				$response = array("type" => 'error', "message" => 'Invalid request ID.');
			} else {
				$query = $this->Approval_model->getRequestDetail($id);
				if ($query->num_rows() > 0) {
					$data['request_info'] = $query->row_array();
					$data['comments'] = $this->Approval_model->getComments($id);
					$data['corrections'] = $this->Approval_model->getCorrectionComments($id);
					// Render the view as a string
					$html = $this->load->view('admin/hr-module/request-approvals/components/request-detail', $data, TRUE);
					$response = array("type" => 'success', "message" => $html);
				} else {
					$response = array("type" => 'error', "message" => 'Request details not found.');
				}
			}
		} else {
			$response = array("type" => 'error', "message" => 'Session expired. Please login again.');
		}
		echo json_encode($response);
	}

	public function save_comment()
	{
		// Form validation rules
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('comment', 'Comment', 'required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Upload file if provided
			$upload_result = upload_image('attachment', './uploads/comments/');
			$file_path = $upload_result['status'] ? $upload_result['data'] : null;

			if (!$upload_result['status'] && $_FILES['attachment']['name']) {
				// File upload failed and a file was submitted
				$result = array("type" => 'error', "message" => $upload_result['data']);
			} else {
				// Transaction Start
				$this->db->trans_start();

				// Insert comment into database
				$comment_data = [
					'request_id' => $this->input->post('request_id'),
					'employee_id' => $this->admin->getLoginEmpId(),
					'comment' => $this->input->post('comment'),
					'comment_type' => '1',
					'attachment' => $file_path,
					'created_at' => date('Y-m-d H:i:s'),
				];
				$this->db->insert('request_comments', $comment_data);
				$comment_data['id'] = $this->db->insert_id();
				// Transaction Complete
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE) {
					$result = array("type" => 'error', "message" => 'Comment submission failed. Please try again.');
				} else {
					$result = array("type" => 'success', "message" => 'Comment successfully submitted.');
				}
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	public function get_comments()
	{
		$request_id = $this->input->get('request_id');
		$comments = $this->Approval_model->getComments($request_id);
		// Load the comments view with the fetched comments
		$data['comments'] = $comments;
		echo $this->load->view('admin/hr-module/request-approvals/components/comments', $data, true);
	}

	// Correction Comments Start

	public function get_correction_form()
	{
		if ($this->admin->isLogged()) {
			$id = $this->input->get('request_id');
			if ($id <= 0) {
				$response = array("type" => 'error', "message" => 'Invalid request ID.');
			} else {
				$query = $this->Approval_model->getRequestDetail($id);
				if ($query->num_rows() > 0) {
					$data['request_info'] = $query->row_array();
					// Render the view as a string
					$html = $this->load->view('admin/hr-module/request-approvals/components/correction_form', $data, TRUE);
					$response = array("type" => 'success', "message" => $html);
				} else {
					$response = array("type" => 'error', "message" => 'Request details not found.');
				}
			}
		} else {
			$response = array("type" => 'error', "message" => 'Session expired. Please login again.');
		}
		echo json_encode($response);
	}

	public function save_correction_comment()
	{
		// Form validation rules
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('comment', 'Comment', 'required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Transaction Start
			$this->db->trans_start();

			$request_id = $this->input->post('request_id');
			// Get existing request data
			$this->db->select('employee_id, request_type');
			$this->db->from('employee_requests');
			$this->db->where('id', $request_id);
			$existing_request = $this->db->get()->row_array();
			
			// Get approvers
			$approvers_persons = [];
			$loan_approver = getApprovers($existing_request['employee_id'], $existing_request['request_type']);

			if (!empty($loan_approver)) {
				$first_approver = $loan_approver[0];
				$approvers_persons[] = [
					'emp_id' => $first_approver->id,
					'name' => $first_approver->full_name,
					'arabic_name' => $first_approver->employee_arabic_name,
					'email' => $first_approver->email,
				];
			}
			
			// Insert comment into database
			$comment_data = [
				'request_id' => $request_id,
				'employee_id' => $this->admin->getLoginEmpId(),
				'comment' => $this->input->post('comment'),
				'comment_type' => '2',
				'created_at' => date('Y-m-d H:i:s'),
			];
			$this->db->insert('request_comments', $comment_data);

			// Update the request status only after successful insert
			if ($this->db->affected_rows() > 0) {
				$request_data = [
					'request_status' => '6',
					'updated_at'     => date('Y-m-d H:i:s'),
				];
				$this->db->where('id', $request_id);
				$this->db->update('employee_requests', $request_data);

				// Insert Approvers
				if (!empty($loan_approver)) {
					$this->db->where('request_id', $request_id)->delete('request_approvers');

					$approver_log = [];
					$is_first_approver = true;

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
			}

			// Transaction Complete
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Correction submission failed. Please try again.');
			} else {
				$result = array("type" => 'success', "message" => 'Correction successfully sent.');
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	public function get_correction_comments()
	{
		$request_id = $this->input->get('request_id');
		$comments = $this->Approval_model->getCorrectionComments($request_id);
		$data['corrections'] = $comments;
		echo $this->load->view('admin/hr-module/request-approvals/components/correction_comments', $data, true);
	}

	// Correction Comments End

	// Request Status Update Start

	public function get_status_form()
	{
		if ($this->admin->isLogged()) {
			$id = $this->input->get('request_id');
			if ($id <= 0) {
				$response = array("type" => 'error', "message" => 'Invalid request ID.');
			} else {
				$query = $this->Approval_model->getRequestDetail($id);
				if ($query->num_rows() > 0) {
					$data['request_info'] = $query->row_array();
					// Render the view as a string
					$html = $this->load->view('admin/hr-module/request-approvals/components/status_form', $data, TRUE);
					$response = array("type" => 'success', "message" => $html);
				} else {
					$response = array("type" => 'error', "message" => 'Request details not found.');
				}
			}
		} else {
			$response = array("type" => 'error', "message" => 'Session expired. Please login again.');
		}
		echo json_encode($response);
	}

	public function update_request_status()
	{
		// Form validation rules
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('comment', 'Comment', 'required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Transaction Start
			$this->db->trans_start();

			// Insert comment into database
			$comment_data = [
				'request_id' => $this->input->post('request_id'),
				'employee_id' => $this->admin->getLoginEmpId(),
				'comment' => $this->input->post('comment'),
				'comment_type' => '1',
				'created_at' => date('Y-m-d H:i:s'),
			];
			$this->db->insert('request_comments', $comment_data);

			// Update the request status only after successful insert
			if ($this->db->affected_rows() > 0) {
				$request_id = $this->input->post('request_id');
				$request_data = [
					'request_status' => '3',
					'final_approver' => $this->admin->getLoginEmpId(),
					'last_status_date' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$this->db->where('id', $request_id);
				$this->db->update('employee_requests', $request_data);
			}

			// Transaction Complete
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Rejection submission failed. Please try again.');
			} else {
				$result = array("type" => 'success', "message" => 'Request successfully rejected.', "reload" => true);
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	/*-------------------------*/
	// Approved Request Start
	/*-------------------------*/

	public function approve_request_status()
	{
		// Form validation rules
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Transaction Start
			$this->db->trans_start();
			$request_id = $this->input->post('request_id');
			$approverEmpId = $this->admin->getLoginEmpId();
			if($this->admin->getId() === '1'){
				$request_data = [
					'request_status' => '2',
					'final_approver' => $approverEmpId,
					'last_status_date' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$this->db->where('id', $request_id);
				$this->db->update('employee_requests', $request_data);
				$requestType = $this->db->select('request_type')->from('employee_requests')->where('id', $request_id)->get()->row('request_type');
				if ($requestType === 'DlRequest') {
					$this->insertInDLRequest($request_id);
				}else if ($requestType === 'TransferRequest') {
					$this->insertInTransferRequest($request_id);
				}else if ($requestType === 'LoanRequest') {
					$this->insertInPaymentRequest($request_id);
				}else if($requestType === 'NoticesAndWarning'){
					$this->save_warning_notices($request_id);
				}else if($requestType === 'Disputes'){
					$requestStatus = '1';
					$this->updateDisputeRequest($request_id, $requestStatus);
				}else if($requestType === 'VehicleAllotmentRequest'){
					$this->updateInMasterVehicle($request_id);
				}else if ($requestType === 'ChangeProfessionRequest') {
					$this->insertInProfessionRequest($request_id);
				}
			}else{
				$approver_data = [
					'approve_status' => '2',
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$this->db->where('request_id', $request_id);
				$this->db->where('approver_id', $approverEmpId);
				$this->db->where('approve_status !=', '2');
				if ($this->db->update('request_approvers', $approver_data)) {
					if ($this->db->affected_rows() > 0) {
						// Check if all approvers have approved
						$pendingApprover = getPendingApprover($request_id);
						if (empty($pendingApprover)) {
							$request_data = [
								'request_status' => '2',
								'final_approver' => $approverEmpId,
								'last_status_date' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
							];
							$this->db->where('id', $request_id);
							$this->db->update('employee_requests', $request_data);
							$requestType = $this->db->select('request_type')->from('employee_requests')->where('id', $request_id)->get()->row('request_type');
							if ($requestType === 'DlRequest') {
								$this->insertInDLRequest($request_id);
							}else if ($requestType === 'TransferRequest') {
								$this->insertInTransferRequest($request_id);
							}else if ($requestType === 'LoanRequest') {
								$this->insertInPaymentRequest($request_id);
							}else if($requestType === 'NoticesAndWarning'){
								$this->save_warning_notices($request_id);
							}else if($requestType === 'Disputes'){
								$requestStatus = '1';
								$this->updateDisputeRequest($request_id, $requestStatus);
							}else if($requestType === 'VehicleAllotmentRequest'){
								$this->updateInMasterVehicle($request_id);
							}else if ($requestType === 'ChangeProfessionRequest') {
					            $this->insertInProfessionRequest($request_id);
				            }
						}else{
							// Send email to next approver
							$nextApprover = $pendingApprover;
							$nextApproverDetail = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.mobile, me.email, me.employee_pic, me.designation, me.department, me.status FROM master_employee me WHERE me.status = 'active' AND me.id='" . $nextApprover['approver_id'] . "'")->row();
							if ($nextApproverDetail) {
								$next_approver_data = [
									'approve_status' => '1',
									'updated_at' => date('Y-m-d H:i:s'),
								];
								$this->db->where('request_id', $request_id);
								$this->db->where('approver_id', $nextApproverDetail->id);
								$this->db->where('approve_status !=', '2');
								$this->db->update('request_approvers', $next_approver_data);

								if ($this->db->affected_rows() > 0) {
									// Send email to next approver
									$next_approvers_detail = [
										'emp_id' => $nextApproverDetail->id,
										'name' => $nextApproverDetail->full_name,
										'arabic_name' => $nextApproverDetail->employee_arabic_name,
										'email' => $nextApproverDetail->email,
									];
									send_mail_to_approvers($next_approvers_detail);
								}
							}
						}
					}
				}
			}

			// Transaction Complete
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$result = array("type" => 'error', "message" => 'Approve request failed. Please try again.');
			} else {
				$result = array("type" => 'success', "message" => 'Request successfully approved.', "reload" => true);
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}
	
	public function insertInDLRequest($request_id = null) {
		if ($request_id) {
			$last_row = $this->db->select('*')->order_by('id', "desc")->limit(1)->get('dl_request')->row();
			$request_no = accountNoFormat($last_row->id + 1);
	
			$requestData = $this->Approval_model->getRequestDetail($request_id);
			if ($requestData->num_rows() > 0) {
				$request_info = $requestData->row_array();
				$requestDetails = json_decode($request_info['request_detail']);
	
				if (json_last_error() !== JSON_ERROR_NONE) {
					log_message('error', 'Failed to decode JSON for request ID: ' . $request_id);
					return false;
				}
	
				$data = [
					'request_no' => $request_no,
					'emp_id' => $request_info['employee_id'],
					'dl_type' => $requestDetails->dl_type,
					'dl_request_type' => $requestDetails->dl_request_type,
					'dallah_location' => $requestDetails->dallah_location,
					'blood_group' => $requestDetails->blood_group,
					'request_date' => $requestDetails->request_date,
					'status' => 'Pending',
					'reason' => $request_info['reason'],
					'trans_status' => 10,
					'attachment' => $request_info['request_documents'],
					'created_at' => CURRENT_TIME
				];
	
				$request_id = $this->dl_model->add($data);
				if($request_id){
					// Insert into dl_transactions
					$data = [
						'request_id'       => $request_id,
						'transaction_type' => 10,
						'cost_involve'     => 'no',
						'trans_amount'     => 0,
						'trans_date'       => date('Y-m-d'),
						'created_at'       => date('Y-m-d H:i:s')
					];

					$this->db->insert('dl_transactions', $data);
					$inserted_id = $this->db->insert_id();

					if ($inserted_id) {
						// Generate transaction_no
						$transaction_no = $inserted_id + 100;
						$transaction_no = str_pad($transaction_no, 6, '0', STR_PAD_LEFT);

						// Update dl_transactions with trans_id
						$this->db->where('id', $inserted_id)
								->limit(1)
								->update('dl_transactions', ['trans_id' => $transaction_no]);
					}

				}
			}
		}
	}	

	public function updateInMasterVehicle($request_id = null)
	{
		if (!$request_id) {
			log_message('error', 'updateInMasterVehicle called without request_id');
			return false;
		}

		$requestData = $this->Approval_model->getRequestDetail($request_id);

		if ($requestData->num_rows() === 0) {
			log_message('error', 'No request found for ID: ' . $request_id);
			return false;
		}

		$request_info = $requestData->row_array();

		// Decode JSON fields safely
		$requestDetails  = json_decode($request_info['request_detail']);
		$attachments     = json_decode($request_info['request_documents']);

		if (json_last_error() !== JSON_ERROR_NONE) {
			log_message('error', 'Failed to decode JSON for request ID: ' . $request_id);
			return false;
		}

		if (empty($requestDetails->vehicle_id)) {
			log_message('error', 'No vehicle_id found in request_detail for request ID: ' . $request_id);
			return false;
		}

		// Update master_vehicles
		$data = [
			'allotment_date'    => $request_info['request_date'],
			'alloted_user'      => $request_info['employee_id'],
			'allotment_status'  => 'alloted',
			'tamm_attachment'   => $attachments->tamm_attachment ?? '',
			'updated_at'        => CURRENT_TIME
		];

		$this->db->update('master_vehicles', $data, ['id' => $requestDetails->vehicle_id]);

		// Insert into dl_transactions
		$logData = [
			'status_date' => $request_info['request_date'],
			'vehicle_id'  => $requestDetails->vehicle_id,
			'meter_reading'  => $requestDetails->meter_reading,
			'log_status'      => 'alloted',
			'rider_id' => $request_info['employee_id'],
			'tamm_attachment'   => $attachments->tamm_attachment ?? '',
			'attachments'  => $request_info['request_documents'],
			'created_at'  => CURRENT_TIME,
			'updated_at'  => CURRENT_TIME
		];

		$this->db->insert('vehicle_log', $logData);

		return true;
	}
	
	public function insertInTransferRequest($request_id = null) {
		if ($request_id) {
			$batch_no = 'TF' . date('Ymd');

			$requestData = $this->Approval_model->getRequestDetail($request_id);
			if ($requestData->num_rows() > 0) {
				$request_info = $requestData->row_array();
				$requestDetails = json_decode($request_info['request_detail']);
	
				if (json_last_error() !== JSON_ERROR_NONE) {
					log_message('error', 'Failed to decode JSON for request ID: ' . $request_id);
					return false;
				}
	
				$data = [
					'batch_no' => $batch_no,
					'emp_id' => $request_info['employee_id'],
					'old_employer' => $requestDetails->current_employer,
					'new_employer' => $requestDetails->new_employer,
					'request_date' => $requestDetails->request_date,
					'status' => '1',
					'transfer_type' => $requestDetails->transfer_type,
					'update_joining_date' => $requestDetails->update_joining_date,
					'contract_id' => $requestDetails->contract_id,
					'contract_period' => $requestDetails->contract_period,
					'contract_start_date' => $requestDetails->contract_start_date,
					'contract_end_date' => $requestDetails->contract_end_date,
					'reason' => $request_info['reason'],
					'created_at' => CURRENT_TIME
				];
				$this->db->insert('employee_transfer', $data);
			}
		}
	}
	
	public function insertInProfessionRequest($request_id = null) {
		if ($request_id) {
			$batch_no = 'CP' . date('Ymd');

			$requestData = $this->Approval_model->getRequestDetail($request_id);
			if ($requestData->num_rows() > 0) {
				$request_info = $requestData->row_array();
				$requestDetails = json_decode($request_info['request_detail']);
	
				if (json_last_error() !== JSON_ERROR_NONE) {
					log_message('error', 'Failed to decode JSON for request ID: ' . $request_id);
					return false;
				}
	
				$data = [
					'batch_no' => $batch_no,
					'emp_id' => $request_info['employee_id'],
					'old_profession_id' => $requestDetails->current_profession,
					'new_profession_id' => $requestDetails->new_profession,
					'request_date' => $requestDetails->request_date,
					'status' => '1',
					'debit_cost_to' => $requestDetails->debit_cost_to,
					'fee_amount' => $requestDetails->fee_amount,
					'added_by' => $request_info['requested_by'],
					'created_at' => CURRENT_TIME
				];
				$this->db->insert('employee_profession_change', $data);
				// Update profession in master_employee
				$this->db->where('id', $request_info['employee_id']);
				$this->db->update('master_employee',['iqama_profession' => $requestDetails->new_profession]);
			}
		}
	}
	
	public function updateDisputeRequest($request_id = null, $requestStatus) {
		if ($request_id) {
			$requestData = $this->Approval_model->getRequestDetail($request_id);
			if ($requestData->num_rows() > 0) {
				$request_info = $requestData->row_array();
				$requestDetails = json_decode($request_info['request_detail']);
				$ref_no = $requestDetails->ref_id;
				$data = [
					'approver_status' => $requestStatus,
					'updated_at' => date('Y-m-d H:i:s')
				];
				
				$this->db->where('ref_id', $ref_no);
				$updated = $this->db->update('diputes_management', $data);
			}
		}
	}	
	
	//Insert in Payment Request
	public function insertInPaymentRequest($request_id = null) {
		if ($request_id) {
			$requestData = $this->Approval_model->getRequestDetail($request_id);
			if ($requestData->num_rows() > 0) {
				$request_info = $requestData->row_array();
				$requestDetails = json_decode($request_info['request_detail']);
				$bankDetails = json_decode($request_info['employee_bank_detail']);
				if ($bankDetails) {
					$empBankInfo = [
						'bank_name' => $bankDetails->bank_name ?? '',
						'iban_no' => $bankDetails->iban_no ?? ''
					];
				} else {
					$empBankInfo = ['bank_name' => '', 'iban_no' => ''];
				}
				$instructions = [$requestDetails->type,$request_info['reason']];
				$data = array(
					'request_type' => 'loan',
					'method_of_payment' => 'Bank Transfer',
					'type_of_payment' => 'Advance Payment',
					'request_for_type' => 'employee',
					'requester_id' => $request_info['employee_id'],
					'request_for_id' => $request_info['employee_id'],
					'department' => $request_info['employee_department'],
					'bank_name' => $empBankInfo['bank_name'],
					'iban_no' => $empBankInfo['iban_no'],
					'currency' => 'sar',
					'amount' => $requestDetails->amount ?? 0,
					'manager_id' => $request_info['employee_manager'],
					'department_head' => $request_info['employee_department_head'],
					'finance_accountant' => 427,
					'finance_manager' => 173,
					'request_date' => !empty($request_info['request_date']) 
						? date('Y-m-d', strtotime($request_info['request_date'])) 
						: date('Y-m-d'),
					'request_detail' => $request_info['request_detail'],
					'instructions' => json_encode($instructions),
					'attachment' => $request_info['request_documents'],
					'reason' => $request_info['reason'],
				);
	
				$insert_id = $this->payment_model->insert($data);
				if ($insert_id) {
					$document_no = 'PRF' . date('Y') . '/' . str_pad($insert_id, 6, '0', STR_PAD_LEFT);
					$this->payment_model->update($insert_id, array('document_no' => $document_no));
				}
			}
		}
	}	
	
	// Approved Request End

	public function reject_request_status()
	{
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$request_id = $this->input->post('request_id');
			$requestedData = $this->Approval_model->getRequestDetail($request_id);

			if ($requestedData && $requestedData->num_rows() > 0) {
				$request_info = $requestedData->row_array();
				$requestType = $request_info['request_type'];

				$this->db->trans_start();

				$request_data = [
					'request_status' => '3',
					'final_approver' => $this->admin->getLoginEmpId(),
					'last_status_date' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$this->db->where('id', $request_id);
				$this->db->update('employee_requests', $request_data);

				if ($requestType === 'Disputes') {
					$this->updateDisputeRequest($request_id, '2');
				}

				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$result = array("type" => 'error', "message" => 'Reject request failed. Please try again.');
				} else {
					$result = array("type" => 'success', "message" => 'Request successfully rejected.', "reload" => true);
				}
			} else {
				$result = array("type" => 'error', "message" => 'Reject request failed. Please try again.');
			}
		}

		echo json_encode($result);
	}

	// Request Status Update End

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
			// Upload file if provided
			$upload_result = upload_image('attachment', './uploads/assets/');
			$file_path = $upload_result['status'] ? $upload_result['data'] : null;

			if (!$upload_result['status'] && $_FILES['attachment']['name']) {
				// File upload failed and a file was submitted
				$result = array("type" => 'error', "message" => $upload_result['data']);
			} else {
				// Transaction Start
				$this->db->trans_start();

				// Insert into `employee_requests`
				$request_data = array(
					'employee_id'    => $this->input->post('emp_id'),
					'request_type'   => $this->input->post('request_type'),
					'request_status' => '1',
					'request_date'   => date('Y-m-d H:i:s'),
					'created_at'     => date('Y-m-d H:i:s'),
					'updated_at'     => date('Y-m-d H:i:s'),
				);
				$this->db->insert('employee_requests', $request_data);
				$request_id = $this->db->insert_id();
				
				$secondary_data = array(
					'assets_ids'     => $this->input->post('category'),
				);
				// Insert into `employee_request_detail`
				$detail_data = array(
					'request_id'        => $request_id,
					'reason'            => $this->input->post('reason'),
					'request_detail'    => json_encode($secondary_data),
					'request_documents' => $file_path,
				);
				$this->db->insert('employee_request_detail', $detail_data);

				// Transaction Complete
				$this->db->trans_complete();

				if ($this->db->trans_status() === FALSE) {
					$result = array("type" => 'error', "message" => 'Request submission failed. Please try again.');
				} else {
					$result = array("type" => 'success', "message" => 'Request successfully submitted.');
				}
			}
		}
		// Return the result as JSON
		echo json_encode($result);
		return;
	}

	
	//Update Loan Request
	public function get_team_request_data($request_id)
	{
		$this->db->select('er.id, er.employee_id, er.requested_by, er.request_type, er.request_status, er.request_date, 
						erd.request_detail, erd.request_documents, erd.reason');
		$this->db->from('employee_requests er');
		$this->db->join('employee_request_detail erd', 'er.id = erd.request_id', 'left');
		$this->db->where('er.id', $request_id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$data = $query->row_array();
			$data['request_detail'] = json_decode($data['request_detail'], true) ?? [];
			$data['request_documents'] = json_decode($data['request_documents'], true) ?? [];
			$data['correction_comments'] = $this->Approval_model->getCorrectionComments($request_id);
			// Improved handling for attachments display
			$data['existing_attachments_html'] = '';
			if (!empty($data['request_documents'])) {
				foreach ($data['request_documents'] as $file) {
					$data['existing_attachments_html'] .= "<p><a href='".base_url($file)."' target='_blank'>".basename($file)."</a></p>";
				}
			}
			//dd($data);
			if($data['request_type'] == 'LoanRequest'){
				$html = $this->load->view('admin/hr-module/request-approvals/components/update_loan_form', $data, TRUE);
			}else{
				echo json_encode(['status' => 'error', 'message' => 'Request data not found.']);
			}
			echo json_encode(['status' => 'success', 'data' => $html]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Request data not found.']);
		}
	}


	public function update_loan_request()
	{
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('loan_type', 'Loan Type', 'trim|required');
		$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'trim|required');
		$this->form_validation->set_rules('deduction_start_date', 'Deduction Start Date', 'trim|required');
		$this->form_validation->set_rules('calculation_type', 'Calculation Type', 'trim|required');
		$this->form_validation->set_rules('specified_value', 'Specified Value', 'trim|required');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$request_id = $this->input->post('request_id');
		if (!$request_id) {
			echo json_encode(["type" => 'error', "message" => 'Request ID is required.']);
			return;
		}

		$uploaded_files = [];
		$failed_files = [];

		if (!empty($_FILES['attachment']['name'][0])) {
			$file_count = count($_FILES['attachment']['name']);
			for ($i = 0; $i < $file_count; $i++) {
				$_FILES['file'] = [
					'name' => $_FILES['attachment']['name'][$i],
					'type' => $_FILES['attachment']['type'][$i],
					'tmp_name' => $_FILES['attachment']['tmp_name'][$i],
					'error' => $_FILES['attachment']['error'][$i],
					'size' => $_FILES['attachment']['size'][$i]
				];

				$upload_result = upload_image('file', './uploads/loan/');
				if ($upload_result['status']) {
					$uploaded_files[] = $upload_result['data'];
				} else {
					$failed_files[] = $_FILES['file']['name'];
				}
			}

			if (!empty($failed_files)) {
				echo json_encode(["type" => 'error', "message" => 'Failed to upload: ' . implode(', ', $failed_files)]);
				return;
			}
		}

		$this->db->trans_start();

		// Get approvers
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

		// Fetch existing documents
		$this->db->select('request_documents');
		$this->db->from('employee_request_detail');
		$this->db->where('request_id', $request_id);
		$existing_request = $this->db->get()->row_array();

		$existing_files = !empty($existing_request['request_documents']) 
							? json_decode($existing_request['request_documents'], true) 
							: [];

		// Merge old and new files
		$all_files = array_merge($existing_files, $uploaded_files);

		$secondary_data = [
			'type' => $this->input->post('loan_type'),
			'amount' => $this->input->post('loan_amount'),
			'deduction_start_date' => date('Y-m-d', strtotime($this->input->post('deduction_start_date'))),
			'calculation_type' => $this->input->post('calculation_type'),
			'specified_value' => $this->input->post('specified_value'),
		];

		$update_data = [
			'request_detail' => json_encode($secondary_data),
			'request_documents' => !empty($all_files) ? json_encode($all_files) : null,
		];
		$this->db->where('request_id', $request_id)->update('employee_request_detail', $update_data);
		$this->db->where('id', $request_id)->update('employee_requests', ['request_status' => '1']);

		// Insert comment into database
		$comment_data = [
			'request_id' => $this->input->post('request_id'),
			'employee_id' => $this->admin->getLoginEmpId(),
			'comment' => $this->input->post('comment'),
			'comment_type' => '1',
			'created_at' => date('Y-m-d H:i:s'),
		];
		$this->db->insert('request_comments', $comment_data);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(["type" => 'error', "message" => 'Loan request update failed. Please try again.']);
		} else {
			$this->db->trans_commit();
			if (!empty($approvers_persons)) {
				send_mail_to_approvers($approvers_persons);
			}
			echo json_encode(["type" => 'success', "message" => 'Loan request successfully updated.']);
		}
	}
	
	public function download_documents()
    {
		if($this->action && !check_action_permission(get_user_role(), 'team_request', $this->action)){
			redirect('admin/unauthorized-request');
		}
        $documentsJson = $this->input->get('documents');
        if (!empty($documentsJson)) {
            $documents = json_decode($documentsJson, true);

            if (is_array($documents) && count($documents) > 0) {
                // Use helper to zip and download files
                download_files_as_zip($documents, 'loan_documents');
            } else {
                show_error('No valid documents found.', 400);
            }
        } else {
            show_error('No documents specified.', 400);
        }
    }

	public function view_all_docs()
    {
		if($this->action && !check_action_permission(get_user_role(), 'team_request', $this->action)){
			redirect('admin/unauthorized-request');
		}
        $documentsJson = $this->input->get('documents');
        if (!empty($documentsJson)) {
            $documents = json_decode($documentsJson, true);
            if (is_array($documents) && count($documents) > 0) {
                $data['documents'] = $documents;
                $this->load->view('admin/hr-module/request-approvals/components/view-documents', $data);
            } else {
                show_error('No valid documents found.', 400);
            }
        } else {
            show_error('No documents specified.', 400);
        }
    }
	
	//Warning Request Details
	public function save_warning_notices($id)
	{
		$this->load->library('Pdf_employee_offer');
		$query = $this->Approval_model->getRequestDetail($id);

		if ($query->num_rows() > 0) {
			$data['request_info'] = $query->row_array();
			$requestDetails = $data['request_info']['request_detail'];
			$requestDetailArray = json_decode($requestDetails);
			$requestType = $data['request_info']['request_type'];
			$requestStatus = $data['request_info']['request_status'];
			$username = $data['request_info']['emp_no'];
			$employee_email = $data['request_info']['employee_email'];
			$employee_name = $data['request_info']['employee_name'];
			$emp_id = $data['request_info']['employee_id'];

			// Create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// Add watermark if not approved
			if ($requestStatus != 2) {
				$pdf->setWatermark('APPROVAL PENDING');
				$pdf->setPrintHeader(true);
			}

			// PDF settings
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - '. $requestDetailArray->title_english);
			$pdf->SetSubject('BS - '. $requestDetailArray->title_english);
			$pdf->SetKeywords('Baqala Station, PDF, Warning Notice,'. $requestDetailArray->title_english);

			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(false);
			$pdf->setHtmlHeader('');
			$pdf->setHtmlHeader2('');
			$pdf->setHtmlFooter('');
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(6, 10, 8, true);
			$pdf->SetAutoPageBreak(TRUE, 2);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			$pdf->AddPage();
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);
			if($requestDetailArray->type == 'Absconded'){
				$htmlcontent = $this->load->view('admin/hr-module/request-approvals/print/warning_absconded', $data, true);
			}elseif($requestDetailArray->type == 'Refusal to Work'){
				$htmlcontent = $this->load->view('admin/hr-module/request-approvals/print/work_refusal', $data, true);
			}else{
				$htmlcontent = $this->load->view('admin/hr-module/request-approvals/print/warning_notices', $data, true);
			}
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

			// Output the PDF
			$savePath = FCPATH . 'uploads/employee-docs/';
			if (!is_dir($savePath)) {
				mkdir($savePath, 0755, true);
			}

			$filename = $requestDetailArray->type .'-'. $username . '-' . date('YmdHis') . '.pdf';
			$pdf->Output($savePath . $filename, 'F'); // Save to server
			//Insert into database
			$insertData = [
				'emp_id' => $emp_id,
				'doc_type' => 'Warning Letter',
				'document' => 'uploads/employee-docs/' . $filename,
				'doc_category' => 'my_documents',
				'description' => $requestDetailArray->type . ' - ' . $requestDetailArray->title_english
			];
			$this->db->insert('master_employee_doc', $insertData);
			//Send Mail
			if($requestDetailArray->type == 'Absconded'){
				$mailcontent = 'admin/hr-module/request-approvals/mail/warning_absconded';
			}elseif($requestDetailArray->type == 'Refusal to Work'){
				$mailcontent = 'admin/hr-module/request-approvals/mail/work_refusal';
			}else{
				$mailcontent = 'admin/hr-module/request-approvals/mail/warning_notices';
			}
			$email_data = array(
				'employee_id' => $emp_id,
				'emp_no' => $username,
				'email' => $employee_email,
				'name' => $employee_name,
				//'attachment' => $savePath . $filename,
				'request_type' => $requestDetailArray->type,
				'subject' => $requestDetailArray->title_english,
				//'template' => 'admin/attatchment-template/warning_letters',
				'request_info' => $data['request_info'],
				'template' => $mailcontent
			);
			//dd($insuranceDetail);
			send_global_mail_helper($email_data);
		}
	}
	
	public function print_warning_notices($id)
	{
		$this->load->library('Pdf_employee_offer');
		$query = $this->Approval_model->getRequestDetail($id);
		if ($query->num_rows() > 0) {
			$data['request_info'] = $query->row_array();
			$requestDetails = $data['request_info']['request_detail'];
			$requestDetailArray = json_decode($requestDetails);
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$requestStatus = $data['request_info']['request_status'];
			if ($requestStatus != 2) {
				$pdf->setWatermark('APPROVAL PENDING');
				$pdf->setPrintHeader(true);
			}
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - '. $requestDetailArray->title_english);
			$pdf->SetSubject('BS - '. $requestDetailArray->title_english);
			$pdf->SetKeywords('Baqala Station, PDF, Warning Notice,'. $requestDetailArray->title_english);

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(6, 10, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			if($requestDetailArray->type == 'Absconded'){
				$htmlcontent = $this->load->view('admin/hr-module/request-approvals/print/warning_absconded', $data, true);
			}elseif($requestDetailArray->type == 'Refusal to Work'){
				$htmlcontent = $this->load->view('admin/hr-module/request-approvals/print/work_refusal', $data, true);
			}else{
				$htmlcontent = $this->load->view('admin/hr-module/request-approvals/print/warning_notices', $data, true);
			}
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			//$pdf->Output('New Arrival Food Advance Request Form - '. $data['emp_detail']->emp_no .'.pdf', 'I');
			$pdf->Output($requestDetailArray->title_english . '-' . $data['request_info']['emp_no'] . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Detail not found!");
			redirect('admin/hr-module/requests/team-requests/pending');
		}
	}
	
}
