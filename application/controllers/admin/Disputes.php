<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Disputes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/Disputes_model', 'dispute');
		$this->load->library('form_validation');
		$this->load->helper('common_helper');
		$this->load->helper('sendmail_helper');
		$this->load->helper('request_helper');
		$this->load->library('user_agent');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'dispute_list', $this->action)) {
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
		$data['dispute_types'] = $this->dispute->master_disputes_type();
		$this->load->view("admin/disputes/index", $data);
	}

	public function get_list()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('ref_no'))) {
			$ref_no = $this->input->get('ref_no');
		} else {
			$ref_no = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('start_date'))) {
			$start_date = $this->input->get('start_date');
		} else {
			$start_date = FALSE;
		}
		if (!empty($this->input->get('end_date'))) {
			$end_date = $this->input->get('end_date');
		} else {
			$end_date = FALSE;
		}
		$fetch_data = $this->dispute->get_list($keyword, $ref_no, $status, $start_date, $end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->driver_id;
			$sub_array[] = $item->driver_username;
			$sub_array[] = $item->ref_id;
			$sub_array[] = $item->rider_name;
			$sub_array[] = $item->dispute_type_en;
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->dispatch_date));
			$sub_array[] = $item->debit_amount;
			$sub_array[] = match($item->dispute_status) {
				'1' => '<span class="badge badge-pill badge-soft-success font-size-13">Approved</span>',
				'2' => '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>',
				'3' => '<span class="badge badge-pill badge-soft-info font-size-13">Partial Approved</span>',
				default => '<span class="badge badge-pill badge-soft-secondary font-size-13">Open</span>',
			};
			$sub_array[] = match($item->approver_status) {
				'1' => '<span class="badge badge-pill badge-soft-success font-size-13">Approved</span>',
				'2' => '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>',
				default => '<span class="badge badge-pill badge-soft-secondary font-size-13">Pending for Approval</span>',
			};

			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			if ($item->dispute_status == '0') {
				$status_button = check_action_permission(get_user_role(), 'dispute_list', 'update_status') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Update Status" data-id="' . $item->id . '" data-refid="' . $item->ref_id . '" data-dname="' . $item->rider_name . '" onclick="statusPopup(this)"><i class="mdi mdi-checkbox-multiple-marked-circle-outline font-size-18"></i></a>' : '';
			} else {
				$status_button = '';
			}
			$detail_button = '';
			if (check_action_permission(get_user_role(), 'dispute_list', 'dispute_detail')) {
				$detail_button = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/disputes/dispute-detail?id=' . $item->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			}
			$sub_array[] = $status_button . $detail_button;

			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->dispute->get_all_data(),
			"recordsFiltered" => $this->dispute->get_filtered_data($keyword, $ref_no, $status, $start_date, $end_date),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'dispute_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->dispute->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/disputes/list');
	}

	public function reference_list() {
		$search = $this->input->post('search');

		$this->db->select('jos.id, jos.emp_id, jos.order_date, jos.ref_id, me.full_name as employee_name');
		$this->db->from('jahez_order_summary jos');
		$this->db->join('master_employee me', 'me.id = jos.emp_id', 'left');

		if (!empty($search)) {
			$this->db->like('jos.ref_id', $search);
		}

		$query = $this->db->get();
		$result = $query->result();

		$response = [];
		foreach ($result as $row) {
			$response[] = [
				'id' => $row->id,
				'employee_id' => $row->emp_id,
				'employee_name' => $row->employee_name,
				'order_date' => $row->order_date,
				'ref_id' => $row->ref_id,
			];
		}

		echo json_encode($response);
	}

	public function dispute_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'dispute_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data = $this->dispute->dispute_detail($id);
		if (!empty($data)) {
			return $this->load->view("admin/disputes/detail", $data);
		} else {
			$this->session->set_userdata('info', "2--No detail found!");
			redirect('admin/disputes/list');
		}
	}

	public function get_summary_detail()
	{
		$this->form_validation->set_rules('id', 'Reference ID', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Enter valid reference id.</span>";
		} else {
			$ref_id = $this->input->post('id');
			$order_detail = $this->dispute->get_summary_detail($ref_id);
			if (!empty($order_detail)) {
				$debit_amt = $order_detail->driver_debit_amt;
				if ($debit_amt > 0) {
					$data['status'] = 'success';
					$data['order_detail'] = $order_detail;
					$data['msg'] = "<span style='color:green;'>Reference detail successfully fetched.</span>";
				} else {
					$data['status'] = 'error';
					$data['msg'] = "<span style='color:red;'>Reference ID is not eligible for Dispute.</span>";
				}
			} else {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'>Reference detail not available.</span>";
			}
		}
		echo json_encode($data);
	}

	public function add_dispute()
	{
		if (isset($this->action) && !check_action_permission(get_user_role(), 'dispute_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('ref_id', 'Reference ID', 'trim|required');
		$this->form_validation->set_rules('dispute_type', 'Dispute Type', 'trim|required');
		$this->form_validation->set_rules('explanations', 'Explanations', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			//print_r($this->input->post());exit();
			if (isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'])) {
				$con['upload_path'] = './uploads/disputes/';
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);

				if (!$this->upload->do_upload('attachment')) {
					$this->session->set_userdata('info', "2--" . $this->upload->display_errors());
					redirect('admin/disputes/list');
				} else {
					$image_data = $this->upload->data();
					$attachment = "uploads/disputes/" . $image_data['file_name'];
				}
			} else {
				$attachment = '';
			}

			$ref_id = $this->input->post('ref_id', true);
			$summary_detail = $this->dispute->get_summary_detail($ref_id);

			if (!empty($summary_detail) && $summary_detail->driver_debit_amt > 0) {
				$data = [
					'driver_id'       => $summary_detail->driver_id,
					'driver_username' => $summary_detail->driver_username,
					'ref_id'          => $summary_detail->ref_id,
					'dispute_type'    => $this->input->post('dispute_type', true),
					'debit_amount'    => $summary_detail->driver_debit_amt,
					'dispatch_date'   => date('Y-m-d H:i:s', strtotime($summary_detail->dispatch_time)),
					'rider_name'      => $summary_detail->driver_name,
					'explanations'    => $this->input->post('explanations', true),
					'attach_file'     => $attachment,
					'dispute_status'  => '0',
					'emp_id'          => $summary_detail->emp_id,
					'vehicle_id'      => $summary_detail->vehicle_id,
					'created_at'      => CURRENT_TIME
				];

				$insert_id = $this->dispute->add($data);
				if ($insert_id) {
					$this->send_mail($insert_id);
					$result = ["type" => 'success', "message" => 'Dispute successfully submitted.'];
				} else {
					$result = ["type" => 'error', "message" => 'Something went wrong, try again'];
				}
			} else {
				$result = ["type" => 'error', "message" => 'Reference ID is not eligible for Dispute or invalid.'];
			}

		}
		echo json_encode($result);
	}

	public function disputeDetail($id) {
		if($id > 0){
			$data = [];
			$order_detail = $this->dispute->dispute_detail($id);
			if (!empty($order_detail)) {
				$data['status'] = 'success';
				$data['order_detail'] = $order_detail;
				$data['msg'] = "<span style='color:green;'>Dispute detail successfully fetched.</span>";
			} else {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'>Dispute detail not available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Enter valid dispute id.</span>";
		}
		echo json_encode($data);
	}

	public function update_status()
	{
		// Authorization check
		if ($this->action && !check_action_permission(get_user_role(), 'dispute_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		// Validate required fields
		$this->form_validation->set_rules('dispute_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('status_updated_date', 'Date', 'trim|required');
		$this->form_validation->set_rules('dispute_status', 'Dispute Status', 'trim|required');

		$dispute_status = $this->input->post('dispute_status');

		// Additional rule for partial approval
		if ($dispute_status === '3') {
			$this->form_validation->set_rules('approved_amount', 'Approved Amount', 'trim|required|numeric|greater_than_equal_to[0]');
		}

		if ($this->form_validation->run() === FALSE) {
			$result = [
				"type" => 'error',
				"message" => validation_errors()
			];
		} else {
			$data = [
				'status_updated_date' => $this->input->post('status_updated_date'),
				'dispute_status' => $dispute_status,
				'updated_at' => date('Y-m-d H:i:s')
			];

			// Set approved amount only if status is 3
			if ($dispute_status === '3') {
				$data['approved_amount'] = $this->input->post('approved_amount');
			} else {
				$data['approved_amount'] = null; // clear previous value if not partial
			}

			$this->db->where('id', $this->input->post('dispute_id'));
			$updated = $this->db->update('diputes_management', $data);
			if ($updated) {
				$dispute_id = $this->input->post('dispute_id');
				$this->save_dispute_request($dispute_id);
			}
			$result = $updated
				? ["type" => 'success', "message" => 'Dispute successfully updated.']
				: ["type" => 'error', "message" => 'Something went wrong, try again.'];
		}

		echo json_encode($result);
	}

	public function send_mail($dispute_id)
	{
		$id = $dispute_id;
		$data['dispute'] = $this->dispute->dispute_detail($id);
		if (!empty($data)) {
			$subject = 'Dispute #' . $data["dispute"]->ref_id;
			$message = $this->load->view("admin/attatchment-template/disputes-mail", $data, true);
			if (!empty($data["dispute"]->attach_file)) {
				//print_r($lang);exit();
				$attatchment = base_url($data["dispute"]->attach_file);
			}

			/*********Email*************/
			$eSetting = $this->customer->emailSetting();
			$config = array(
				'protocol' => $eSetting->protocol,
				'smtp_host' => $eSetting->smtp_host,
				'smtp_port' => $eSetting->smtp_port,
				'smtp_user' => $eSetting->smtp_user,
				'smtp_pass' => $eSetting->smtp_pass,
				'mailtype' => 'html'
			);

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from($eSetting->smtp_user, $subject);
			$primaryRecipient = !empty($eSetting->receiver_mail) ? $eSetting->receiver_mail : (DISPUTE_TO_EMAIL !== '' ? DISPUTE_TO_EMAIL : $eSetting->smtp_user);
			$this->email->to($primaryRecipient);
			$cc_list = array_filter(array_map('trim', explode(',', DISPUTE_CC_EMAILS)));
			if (!empty($cc_list)) {
				$this->email->cc($cc_list);
			}
			$this->email->subject($subject);
			$this->email->message($message);
			if (!empty($data["dispute"]->attach_file)) {
				$this->email->attach($attatchment);
			}
			$send = $this->email->send();
			/**********************/
			return $send;
		}
	}

	public function manual_send_mail()
	{
		$id = $this->input->get('id');
		$data['dispute'] = $this->dispute->dispute_detail($id);
		if (!empty($data)) {
			$subject = 'Dispute #' . $data["dispute"]->ref_id;
			$message = $this->load->view("admin/attatchment-template/disputes-mail", $data, true);
			if (!empty($data["dispute"]->attach_file)) {
				//print_r($lang);exit();
				$attatchment = base_url($data["dispute"]->attach_file);
			}

			/*********Email*************/
			$eSetting = $this->customer->emailSetting();
			$config = array(
				'protocol' => $eSetting->protocol,
				'smtp_host' => $eSetting->smtp_host,
				'smtp_port' => $eSetting->smtp_port,
				'smtp_user' => $eSetting->smtp_user,
				'smtp_pass' => $eSetting->smtp_pass,
				'mailtype' => 'html'
			);

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from($eSetting->smtp_user, $subject);
			$primaryRecipient = !empty($eSetting->receiver_mail) ? $eSetting->receiver_mail : (DISPUTE_TO_EMAIL !== '' ? DISPUTE_TO_EMAIL : $eSetting->smtp_user);
			$this->email->to($primaryRecipient);
			$cc_list = array_filter(array_map('trim', explode(',', DISPUTE_CC_EMAILS)));
			if (!empty($cc_list)) {
				$this->email->cc($cc_list);
			}
			$this->email->subject($subject);
			$this->email->message($message);
			if (!empty($data["dispute"]->attach_file)) {
				$this->email->attach($attatchment);
			}
			$send = $this->email->send();
			/**********************/
			return $send;
		}
	}

	//Disputes Request
	private function save_dispute_request($dispute_id)
	{
		$order_detail = $this->dispute->dispute_detail($dispute_id);
		if (!empty($order_detail)) {
			// Always required fields
			$this->db->trans_start();

			$requestType = 'Disputes';
			$requestedImpID = $order_detail->emp_id;
			$req_date = $order_detail->status_updated_date;
			$driver_id = $order_detail->driver_id;
			$driver_username = $order_detail->driver_username;
			$ref_id = $order_detail->ref_id;
			$dispute_type = $order_detail->dispute_type_en;
			$debit_amount = $order_detail->debit_amount;
			$dispatch_date = $order_detail->dispatch_date;
			$explanations = $order_detail->explanations;
			$attach_file = $order_detail->attach_file;
			$vehicle_id = $order_detail->vehicle_id;
			$approved_amount = $order_detail->approved_amount;
			
			//Get approvers
			$approvers_persons = [];
			$dispute_approver = getApprovers($requestedImpID, 'Disputes');
			if (!empty($dispute_approver)) {
				$first_approver = $dispute_approver[0];
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
				'type' => $dispute_type,
				'driver_id' => $driver_id,
				'driver_username' => $driver_username,
				'ref_id' => $ref_id,
				'debit_amount' => $debit_amount,
				'dispatch_date' => $dispatch_date,
				'vehicle_id' => $vehicle_id,
				'approved_amount' => $approved_amount,
				'request_date' => $req_date ? $req_date : '',
			);
			// Insert into `employee_request_detail`
			$detail_data = array(
				'request_id'     => $request_id,
				'reason'         => $explanations,
				'request_detail' => json_encode($secondary_data, JSON_UNESCAPED_UNICODE),
				'request_documents' => !empty($attach_file) ? json_encode($attach_file) : null,
			);
			$this->db->insert('employee_request_detail', $detail_data);

			//Insert Approvers
			if (!empty($dispute_approver)) {
				$approver_log = [];
				$is_first_approver = true;
				foreach ($dispute_approver as $approver) {
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
			} else {
				send_mail_to_approvers($approvers_persons);
			}
		}
	}
}
