<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cash_collection extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-management/Collection_model', 'cash_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
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
		//print_r($data['reports']);exit();
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view('admin/logistic-management/cash-collection/index', $data);
	}

	public function search_employee()
	{
		$keyword = $this->input->get('search'); 
		$items = riderSearchListHelper($keyword);
		echo json_encode($items);
	}

	public function search_team_leader()
	{
		$keyword = $this->input->get('search'); 
		$items = teamLeaderListHelper($keyword);
		echo json_encode($items);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/logistic-management/cash-collection/components/search-form');
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->cash_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['transaction'] = $query->row_array();
				//dd($data['transaction']);
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '" . $data['transaction']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/cash-collection/components/edit-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Transaction detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Transaction detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function get_employee_detail()
	{
		$this->form_validation->set_rules('search_employee', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_no = $this->input->post('search_employee');
			$query = $this->db->query("SELECT lr.id, lr.employee_id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM logistic_rider lr LEFT JOIN master_employee me ON (lr.employee_id = me.id) LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.emp_no='" . $emp_no . "' AND (me.designation = '3' OR me.designation = '18'))");
			if ($query->num_rows() > 0) {
				$data['emp_detail'] = $query->row_array();
				$emp_id = $data['emp_detail']['employee_id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['total_outstanding'] = $this->cash_model->get_pending_cash_collection($emp_id);
				$output_data = $this->load->view('admin/logistic-management/cash-collection/components/employee-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function save()
	{
		// Set validation rules
		$this->form_validation->set_rules('record_id', 'Record ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_rules('transaction_date', 'COD Date', 'trim|required');
		$this->form_validation->set_rules('due_amount', 'COD Amount', 'trim|required');
		$this->form_validation->set_rules('amount_collected', 'Amount Collected', 'trim|required');
		$this->form_validation->set_rules('outstanding_amount', 'Outstanding Amount', 'trim|required');
		//$this->form_validation->set_rules('receipt_reason', 'Receipt Reason', 'trim|required');
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			// If validation fails, return errors
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$input_otp = $this->input->post('otp');
			$employee_id = $this->input->post('employee_id');
			$current_time = date('Y-m-d H:i:s');
			// Retrieve the latest OTP entry for the employee
			$otp_entry = $this->cash_model->get_otp($employee_id);
			if ($otp_entry && $otp_entry->otp == $input_otp && strtotime($otp_entry->expired_at) > time()) {
				// Handle file upload if file is present
				/*
				if ($_FILES['attachment']['name']) {
					$attachment = $this->upload_file('attachment');
				} else {
					$attachment = '';
				}*/

				// Prepare data for insertion
				$data = array(
					'employee_id' => $this->input->post('employee_id'),
					'order_id' => $this->input->post('record_id'),
					'transaction_date' => $this->input->post('transaction_date'),
					'due_amount' => $this->input->post('due_amount'),
					'paid_amount' => $this->input->post('amount_collected'),
					'balance_amount' => $this->input->post('outstanding_amount'),
					'receipt_reason' => 'Jahez Cash',
					'description' => '',
					'attachment' => '',
					'added_by'   => $this->admin->getLoginEmpId(),
					'created_at' => CURRENT_TIME
				);

				// Save data using the model
				$insert_id = $this->cash_model->add($data);
				if ($insert_id) {
					// Generate voucher ID and update record
					$voucher_id = invoiceNmFormat($insert_id);
					$this->cash_model->update($insert_id, ['transaction_id' => $voucher_id]);
					// Update the OTP's expired_at to the current time
					$this->db->where('employee_id', $employee_id);
					$this->db->where('otp', $input_otp);
					$this->db->update('cash_otp_verification', ['expired_at' => time()]);

					//Send Mail
					$empDetail = employeeDetailHelper($employee_id);
					$email_data = array(
						'employee_id' => $empDetail->id,
						'request_type' => 'cash_collection',
						'email' => $empDetail->email,
						'name' => $empDetail->full_name,
						'emp_no' => $empDetail->emp_no,
						'date_of_collection' => $data['transaction_date'],
						'collection_amount' => $data['due_amount'],
						'submitted_amount' => $data['paid_amount'],
						'collection_balance' => $data['balance_amount'],
						'reason' => $data['receipt_reason'],
						'subject' => 'Cash Collection Acknowledge Receipt',
						'template' => 'admin/attatchment-template/cash_collection_acknowledge_receipt'
					);
					send_global_mail_helper($email_data);

					$result = array("type" => 'success', "message" => 'Cash collection successfully added.');
				} else {
					$result = array("type" => 'error', "message" => 'Something went wrong, try again');
				}
			} else {
				$result = array("type" => 'error', "message" => 'Invalid OTP or may expired.');
			}
		}

		// Return result as JSON
		echo json_encode($result);
	}

	public function upload_file($file)
	{
		$upload_path = './uploads/cash-collection/';

		// Check if the folder exists, if not, create it
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true); // Recursive directory creation
		}

		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
		$config['max_size']      = 0;
		$config['max_width']     = 0;
		$config['max_height']    = 0;
		$config['max_filename']  = '50';
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file)) {
			// Upload failed, display error
			$error = $this->upload->display_errors();
			return $error;
		} else {
			// Upload successful, get file data
			$file_data = $this->upload->data();
			$image = $upload_path . $file_data['file_name'];

			return $image;
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');

		$this->form_validation->set_rules('employee_id', 'Select Employee', 'trim|required');
		//$this->form_validation->set_rules('transaction_date', 'COD Date', 'trim|required');
		$this->form_validation->set_rules('due_amount', 'COD Amount', 'trim|required');
		$this->form_validation->set_rules('paid_amount', 'Amount Collected', 'trim|required');
		$this->form_validation->set_rules('balance_amount', 'Outstanding Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			// Handle file upload if file is present
			/*
			if ($_FILES['attachment']['name']) {
				$attachment = $this->upload_file('attachment');
			} else {
				$attachment = $this->input->post('attachment_old');
			}*/
			$data = array(
				'due_amount' => $this->input->post('due_amount'),
				'paid_amount' => $this->input->post('paid_amount'),
				'balance_amount' => $this->input->post('balance_amount'),
				'receipt_reason' => 'Jahez Cash',
				'description' => '',
				'attachment' => '',
				'updated_by' => $this->admin->getLoginEmpId(),
				'updated_at' => CURRENT_TIME
			);
			// Save data using the model
			$updated = $this->cash_model->update($id, $data);
			if ($updated) {
				$result = array("type" => 'success', "message" => 'Cash collection successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'Cash collection not updated');
			}
		}
		echo json_encode($result);
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->cash_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['transaction'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '" . $data['transaction']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/cash-collection/components/profile-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Cash collection detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Cash collection detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function get_ajax_list()
	{
		$fetch_data = $this->cash_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();

		foreach ($fetch_data as $row) {
			$delivery_price = is_numeric($row->delivery_price) ? (float)$row->delivery_price : 0;
			$cash_collection = is_numeric($row->cash_collection) ? (float)$row->cash_collection : 0;
			$credit = is_numeric($row->driver_credit) ? (float)$row->driver_credit : 0;
			$debit = is_numeric($row->driver_debit) ? (float)$row->driver_debit : 0;
			$bonuses = is_numeric($row->bonuses) ? (float)$row->bonuses : 0;
			$tips = is_numeric($row->tips) ? (float)$row->tips : 0;
			$penalty = is_numeric($row->penalty) ? (float)$row->penalty : 0;
			$service_deduction = is_numeric($row->service_deduction) ? (float)$row->service_deduction : 0;
			$total_amount_val = is_numeric($row->total_amount) ? (float)$row->total_amount : 0;
			$paid = is_numeric($row->paid_amount) ? (float)$row->paid_amount : 0;
			$balance = is_numeric($row->balance_amount) ? (float)$row->balance_amount : 0;

			$sub_array = array();

			// Checkbox + index
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $row->id . '" />';
			$sub_array[] = $i++;

			// Employee info
			$sub_array[] = (!empty($row->emp_no)) ? $row->emp_no : 'NA';
			$sub_array[] = (!empty($row->full_name)) ? ucfirst($row->full_name) : 'NA';
			$sub_array[] = (!empty($row->driver_id)) ? $row->driver_id : 'NA';

			// Summary Date
			$sub_array[] = (!empty($row->summary_date) && $row->summary_date !== '0000-00-00')
				? date('d-m-Y', strtotime($row->summary_date))
				: 'NA';

			// Numeric columns
			$sub_array[] = number_format($delivery_price, 2);
			$sub_array[] = number_format($cash_collection, 2);
			$sub_array[] = number_format($credit, 2);
			$sub_array[] = number_format($debit, 2);
			$sub_array[] = number_format($bonuses, 2);
			$sub_array[] = number_format($tips, 2);
			$sub_array[] = number_format($penalty, 2);
			$sub_array[] = number_format($service_deduction, 2);
			$sub_array[] = number_format($total_amount_val, 2);

			// Transaction Date
			$sub_array[] = (!empty($row->transaction_date) && $row->transaction_date !== '0000-00-00')
				? date('d-m-Y', strtotime($row->transaction_date))
				: 'NA';

			// Paid & Balance
			$sub_array[] = number_format($paid, 2);
			$sub_array[] = number_format($balance, 2);
			$sub_array[] = (!empty($row->added_by_name)) ? $row->added_by_username .'-'. ucfirst($row->added_by_name) : 'NA';
			//$sub_array[] = (!empty($row->updated_by_name)) ? $row->updated_by_username .'-'. ucfirst($row->updated_by_name) : 'NA';
			$sub_array[] = date('d-m-Y h:i A', strtotime($row->created_at));
			$sub_array[] = (!empty($row->updated_at)) ? date('d-m-Y h:i:A', strtotime($row->updated_at)) : 'NA';

			// Actions (Edit + Detail)
			$actions = '';
			if (check_action_permission(get_user_role(), 'riders_cash_collection', 'edit')) {
				$actions .= '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit load_edit_modal" title="Edit" onclick="editModal(' . $row->id . ')"><i class="mdi mdi-pencil font-size-18"></i></button>';
			}
			if (check_action_permission(get_user_role(), 'riders_cash_collection', 'detail')) {
				$actions .= '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="detailModal(' . $row->id . ')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>';
			}
			$sub_array[] = $actions;

			$data[] = $sub_array;
		}

		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->cash_model->get_all_data(),
			"recordsFiltered" => $this->cash_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$ids = $this->input->post('checklist');
		//log_message('debug', 'Delete checklist data: ' . print_r($ids, true));
		if (empty($ids)) {
			$this->session->set_userdata('info', "2--No records selected!");
			redirect('admin/logistic-management/cash-collection/list');
		}

		$query = $this->cash_model->delete($ids);

		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error deleting record(s)");
		}

		redirect('admin/logistic-management/cash-collection/list');
	}

	public function generate_otp()
	{
		$this->form_validation->set_rules('rider_id', 'Rider ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_rules('transaction_date', 'COD Date', 'trim|required');
		$this->form_validation->set_rules('due_amount', 'COD Amount', 'trim|required');
		$this->form_validation->set_rules('amount_collected', 'Amount Collected', 'trim|required');
		$this->form_validation->set_rules('outstanding_amount', 'Outstanding Amount', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$rider_id = $this->input->post('rider_id');
			//log_message('debug', 'Received employee_id: ' . $rider_id); // Add this line for debugging
			$query = $this->db->query("SELECT lr.id, lr.employee_id, me.emp_no, me.full_name, me.email FROM logistic_rider lr LEFT JOIN master_employee me ON (lr.employee_id = me.id) WHERE (lr.rider_status = 'active' AND lr.id='" . $rider_id . "')");
			if ($query->num_rows() > 0) {
				$data['emp_detail'] = $query->row_array();
				$email = $data['emp_detail']['email'];
				$employee_id = $data['emp_detail']['employee_id'];
				$emp_name = $data['emp_detail']['full_name'];

				if (empty($email)) {
					$result = array("type" => 'error', "message" => 'Email is Required for OTP');
				} else {
					// Generate OTP
					$otp = rand(100000, 999999);
					$ip = $this->input->ip_address();
					$created_at = date('Y-m-d H:i:s');
					$expired_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));
					log_message('debug', 'Cash collection OTP generated for employee_id ' . $employee_id);
					// Prepare data for insertion
					$otp_data = [
						'employee_id' => $employee_id,
						'email' => $email,
						'otp' => $otp,
						'ip' => $ip,
						'created_at' => $created_at,
						'expired_at' => $expired_at
					];

					// Insert OTP details into the database
					if ($this->cash_model->insert_otp($otp_data)) {
						// Send OTP to user's email
						$eSetting = $this->customer->emailSetting();
						$this->load->library('phpmailer_lib');
						$mail = $this->phpmailer_lib->load();

						$mail->isSMTP();
						$mail->Host = $eSetting->smtp_host;
						$mail->SMTPAuth = true;
						$mail->Username = $eSetting->smtp_user;
						$mail->Password = $eSetting->smtp_pass;
						$mail->SMTPSecure = 'ssl';
						$mail->Port = $eSetting->smtp_port;
						$mail->SMTPOptions = array(
							'ssl' => array(
								'verify_peer' => false,
								'verify_peer_name' => false,
								'allow_self_signed' => true
							)
						);

						$mail->setFrom($eSetting->smtp_user, $eSetting->website_name);
						$mail->addAddress($email);
						$mail->addReplyTo($eSetting->smtp_user, $eSetting->website_name);

						$mail->isHTML(true);
						$mail->Subject = 'Your Secure Code for Cash Collection Voucher';
						$mail->Body = 'Dear ' . $emp_name . ',<br><br>To complete your cash collection voucher transaction, please use the following one-time password (OTP) : <b>' . $otp . '</b><br><br>For your security, please enter this code on the cash collection screen within the next 10 minutes to proceed.<br>If you didn’t request this code, please ignore this email.<br><br>Note: This is an automated email. Please do not reply.<br><br>Kind Regards,<br>System Admin.';
						if ($mail->send()) {
							$result = array("type" => 'success', "message" => 'OTP sent to registered email id ' . $email . '. Please verify');
						} else {
							$result = array("type" => 'error', "message" => 'Failed to send OTP: ' . $mail->ErrorInfo);
						}
					} else {
						$result = array("type" => 'error', "message" => 'Something went wrong, try again!');
					}
				}
			} else {
				$result = array("type" => 'error', "message" => 'User detail not found or may be suspended!');
			}
		}

		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function print_cash_report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$data['cash_reports'] = $this->cash_model->print_list();
		// ✅ Check number of rows
		if (!empty($data['cash_reports']) && count($data['cash_reports']) > 1000) {
			$this->session->set_userdata('info', "2--Printing limited to 1000 rows. Please use filters to refine your report.");
			redirect('admin/logistic-management/cash-collection/list');
		}
		//dd($data['cash_reports']);
		if (!empty($data['cash_reports']) && count($data['cash_reports']) > 0) {
			// print_r($order);exit();
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$data['start_date'] = ($start_date) ? date("d/m/Y", strtotime($start_date)) : 'NA';
			$data['end_date'] = ($end_date) ? date("d/m/Y", strtotime($end_date)) : 'NA';
			$data['print_date'] = date('d/m/Y');
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Cash Collection Report');
			$pdf->SetSubject('BS - Cash Collection Report');
			$pdf->SetKeywords('Baqala Station, PDF, Cash Collection Report, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage('L', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/cash-collection/print/statements', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = 'Cash-Collection-Statement';
			if (!empty($start_date) && !empty($end_date)) {
				$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
			}
			$filename .= '.pdf';
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2--Cash detail not found!");
			redirect('admin/logistic-management/cash-collection/list');
		}
	}

	public function print_employewise_summary()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$data['cash_reports'] = $this->cash_model->print_employewise_list();
		//dd($data['cash_reports']);
		if ($data['cash_reports'] !== '') {
			// print_r($order);exit();
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$data['start_date'] = ($start_date) ? date("d/m/Y", strtotime($start_date)) : 'NA';
			$data['end_date'] = ($end_date) ? date("d/m/Y", strtotime($end_date)) : 'NA';
			$data['print_date'] = date('d/m/Y');
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Cash Collection Report');
			$pdf->SetSubject('BS - Cash Collection Report');
			$pdf->SetKeywords('Baqala Station, PDF, Cash Collection Report, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
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
			$pdf->SetMargins(6, 5, 8, true);
			$pdf->SetAutoPageBreak(TRUE, 2);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->AddPage('P', 'A4');
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/cash-collection/print/report-summary', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = 'Cash-Collection-Report';
			if (!empty($start_date) && !empty($end_date)) {
				$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
			}
			$filename .= '.pdf';
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2--Cash detail not found!");
			redirect('admin/logistic-management/cash-collection/list');
		}
	}
	
	public function print_collection_wise_summary()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$data['cash_reports'] = $this->cash_model->print_collection_wise_list();
		//dd($data['cash_reports']);
		// ✅ Check number of rows
		if (!empty($data['cash_reports']) && count($data['cash_reports']) > 1000) {
			$this->session->set_userdata('info', "2--Printing limited to 1000 rows. Please use filters to refine your report.");
			redirect('admin/logistic-management/cash-collection/list');exit();
		}
		if ($data['cash_reports'] !== '') {
			// print_r($order);exit();
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$data['start_date'] = ($start_date) ? date("d/m/Y", strtotime($start_date)) : 'NA';
			$data['end_date'] = ($end_date) ? date("d/m/Y", strtotime($end_date)) : 'NA';
			$data['print_date'] = date('d/m/Y');
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Cash Collection Report');
			$pdf->SetSubject('BS - Cash Collection Report');
			$pdf->SetKeywords('Baqala Station, PDF, Cash Collection Report, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
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
			$pdf->SetMargins(4, 5, 6, true);
			$pdf->SetAutoPageBreak(TRUE, 2);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->AddPage('L', 'A4');
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/cash-collection/print/collection_report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = 'Cash-Collection-Report';
			if (!empty($start_date) && !empty($end_date)) {
				$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
			}
			$filename .= '.pdf';
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2--Cash detail not found!");
			redirect('admin/logistic-management/cash-collection/list');
		}
	}

	public function print_pending_collection_report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_hunger_report_landscape');
		$month_start_date = $this->input->get('start_date');
		$month_end_date = $this->input->get('end_date');
		$employee_id = $this->input->get('keyword');
    	$team_leader_id = $this->input->get('team_leader');
		$driver_id = $this->input->get('driver_id');
	
		if(empty($month_start_date) || empty($month_end_date)){
			$this->session->set_userdata('info', "2--Please select date range to generate report!");
			redirect('admin/logistic-management/cash-collection/list');exit();
		}
		$data['cash_reports'] = $this->cash_model->get_monthly_pending_cash_collections($month_start_date, $month_end_date, $employee_id, $team_leader_id, $driver_id);
		//dd($month);
		// ✅ Check number of rows
		if (!empty($data['cash_reports']) && count($data['cash_reports']) > 1000) {
			$this->session->set_userdata('info', "2--Printing limited to 1000 rows. Please use filters to refine your report.");
			redirect('admin/logistic-management/cash-collection/list');exit();
		}
		if ($data['cash_reports'] !== '') {
			$data['cash_details'] = $this->cash_model->get_pending_cash_collection_details_by_month($month_start_date, $month_end_date, $employee_id, $team_leader_id, $driver_id);
			// print_r($order);exit();
			$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
			$data['search_keyword'] = $search;
			$data['search_start_date'] = $month_start_date ? htmlspecialchars($month_start_date) : 'NA';
			$data['search_end_date'] = $month_end_date ? htmlspecialchars($month_end_date) : 'NA';
			$data['admin'] = 'Amanullah Kazi';
			$data['print_date'] = date('d/m/Y');
			// create new PDF document
			$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Cash Collection Report');
			$pdf->SetSubject('BS - Cash Collection Report');
			$pdf->SetKeywords('Baqala Station, PDF, Cash Collection Report, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(true);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/logistic-management/cash-collection/print/footer', $data, true);
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(4, 10, 6, true);
			$pdf->SetAutoPageBreak(TRUE, 15);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->AddPage('P', 'A4');
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('dejavusans', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/cash-collection/print/monthly_pending_report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

			// Add a new page before employees list
			$pdf->AddPage('P', 'A4');
			// Employees List (next pages)
			$htmlcontent2 = $this->load->view('admin/logistic-management/cash-collection/print/monthly_pending_detail_report', $data, true);
			$pdf->writeHTML($htmlcontent2, true, 0, true, 0);
			//Close and output PDF document
			$filename = 'Pending-Cash-Collection-Report';
			if (!empty($month_start_date) && !empty($month_end_date)) {
				$filename .= '-' . $month_start_date . '-' . $month_end_date;
			}
			$filename .= '.pdf';
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2--Cash detail not found!");
			redirect('admin/logistic-management/cash-collection/list');
		}
	}
	
	public function print_full_cash_report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'riders_cash_collection', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$data['cash_reports'] = $this->cash_model->print_full_cash_collection_list();
		//dd($data['cash_reports']);
		if ($data['cash_reports'] !== '') {
			// print_r($order);exit();
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$data['start_date'] = ($start_date) ? date("d/m/Y", strtotime($start_date)) : 'NA';
			$data['end_date'] = ($end_date) ? date("d/m/Y", strtotime($end_date)) : 'NA';
			$data['print_date'] = date('d/m/Y');
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Full Cash Collection Report');
			$pdf->SetSubject('BS - Full Cash Collection Report');
			$pdf->SetKeywords('Baqala Station, PDF, Full Cash Collection Report, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/logistic-management/cash-collection/print/footer', $data, true);
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(4, 5, 6, true);
			$pdf->SetAutoPageBreak(TRUE, 15);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->AddPage('P', 'A4');
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/cash-collection/print/full_cash_collection_report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = 'Full-Cash-Collection-Report';
			if (!empty($start_date) && !empty($end_date)) {
				$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
			}
			$filename .= '.pdf';
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2--Cash detail not found!");
			redirect('admin/logistic-management/cash-collection/list');
		}
	}

	public function filter_modal_form($modal_name){
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		if($modal_name == 'monthly_collection'){
			$data['filter_title'] = "Monthly Collection Report";
			$this->load->view('admin/logistic-management/cash-collection/components/monthly_collection_filter_modal', $data);
		}elseif($modal_name == 'full_collection_report'){
			$data['filter_title'] = "Full Collection Report";
			$this->load->view('admin/logistic-management/cash-collection/components/full_collection_filter_modal', $data);
		}elseif($modal_name == 'collection_report'){
			$data['filter_title'] = "Collection Report";
			$this->load->view('admin/logistic-management/cash-collection/components/collection_report_filter_modal', $data);
		}
    }
}
