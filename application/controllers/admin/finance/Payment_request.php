<?php defined('BASEPATH') or exit('No direct script access allowed');

class Payment_request extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/finance/Paymentrequest_model', 'payment_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
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
		return $this->load->view('admin/finance/payment_request/index', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->payment_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $item->id . '" name="check_list[]" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->document_no;
			$sub_array[] = ucfirst($item->request_for_type);
			$sub_array[] = ($item->request_for_type == 'employee') ? 'MF'.str_pad($item->request_for_id, 4, '0', STR_PAD_LEFT) : 'NA';
			$sub_array[] = $item->request_name;
			$sub_array[] = $item->requester_name;
			$sub_array[] = $item->method_of_payment;
			$sub_array[] = $item->type_of_payment;
			$sub_array[] = $item->bank_name;
			$sub_array[] = $item->iban_no;
			$sub_array[] = strtoupper($item->currency);
			$sub_array[] = $item->amount;
			$sub_array[] = ((isset($item->request_date)) ? date('d-m-Y', strtotime($item->request_date)) : '');
			$sub_array[] = ((isset($item->finance_payment_date)) ? date('d-m-Y', strtotime($item->finance_payment_date)) : '');
			if ($item->request_status == 'open') {
				$status = '<span class="badge badge-pill badge-soft-info font-size-13">Open</span>';
			} elseif ($item->request_status == 'paid') {
				$status = '<span class="badge badge-pill badge-soft-success font-size-13">Paid</span>';
			} elseif ($item->request_status == 'cancelled') {
				$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Cancelled</span>';
			} else {
				$status = '<span class="badge badge-pill badge-soft-secondary font-size-13">NA</span>';
			}
			$sub_array[] = $status;
			$sub_array[] = $item->created_at;
			$userRole = get_user_role();
			$actionDropdown = '<div class="btn-group ms-2 float-end">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">';

			if ($item->request_type == 'other' && $item->request_status == 'open') {

				// Edit Button
				if (check_action_permission($userRole, 'payment_request_form', 'edit')) {
					$actionDropdown .= '<a class="dropdown-item" href="' . base_url('admin/finance/payment-request/edit/' . $item->id) . '">
						<i class="mdi mdi-pencil me-2"></i> Edit</a>';
				}

				// Detail Button
				if (check_action_permission($userRole, 'payment_request_form', 'detail')) {
					$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/finance/payment-request/detail/' . $item->id) . '">
						<i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail</a>';
				}

				// Update Payment Detail Button
				if (check_action_permission($userRole, 'payment_request_form', 'payment_status_update')) {
					$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item payment-update-btn" href="javascript:void(0);" data-id="' . $item->id . '">
						<i class="mdi mdi-bank-check me-2"></i> Update Payment Detail</a>';
				}

				// Print Button
				if (check_action_permission($userRole, 'payment_request_form', 'print_form_detail')) {
					$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" target="_blank" href="' . base_url('admin/finance/payment-request/payment-request-print/' . $item->id) . '">
						<i class="mdi mdi-printer me-2"></i> Print Payment Request</a>';
				}
				if ($item->request_type == 'loan' && $item->request_for_type == 'employee') {
					if (check_action_permission($userRole, 'payment_request_form', 'print_form_detail')) {
						$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" target="_blank" href="' . base_url('admin/finance/payment-request/print-personal-finance/' . $item->id) . '">
							<i class="mdi mdi-printer me-2"></i> Print Personal Finance Request</a>';
					}
				}
			} else {
				// Not "other" and "open", only show limited actions
				if (check_action_permission($userRole, 'payment_request_form', 'detail')) {
					$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/finance/payment-request/detail/' . $item->id) . '">
						<i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail</a>';
				}
				if (check_action_permission($userRole, 'payment_request_form', 'print_form_detail')) {
					$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" target="_blank" href="' . base_url('admin/finance/payment-request/payment-request-print/' . $item->id) . '">
						<i class="mdi mdi-printer me-2"></i> Print Payment Request</a>';
				}
				if ($item->request_type == 'loan' && $item->request_for_type == 'employee') {
					if (check_action_permission($userRole, 'payment_request_form', 'print_personal_finance_detail')) {
						$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" target="_blank" href="' . base_url('admin/finance/payment-request/print-personal-finance/' . $item->id) . '">
							<i class="mdi mdi-printer me-2"></i> Print Personal Finance Request</a>';
					}
				}
			}

			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->payment_model->get_all_data(),
			"recordsFiltered" => $this->payment_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function fetch_filter_data()
	{
		$filter_type = $this->input->get('filter_type');
		$search_query = $this->input->get('query');

		// Determine which filter data to fetch based on 'filter_type'
		switch ($filter_type) {
			case 'document_no':
				$data = $this->payment_model->get_filtered_document_nos($search_query);
				break;
			case 'requester_id':
				$data = $this->payment_model->get_filtered_requester_users($search_query);
				break;
			default:
				$data = [];
		}
		// Return the result as JSON
		echo json_encode($data);
	}

	public function create()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		return $this->load->view('admin/finance/payment_request/add');
	}

	public function getOptionsByType()
	{
		$request_for_type = $this->input->post('request_for_type');
		$type_of_payment = ($this->input->post('type_of_payment') === 'International') ? 'International' : '';

		if ($request_for_type == 'employee') {
			$result = employeeListHelper();
		} elseif ($request_for_type == 'vendor') {
			$result = vendorsListHelper($type_of_payment);
		} elseif ($request_for_type == 'saddad') {
			$result = saddadListHelper();
		} else {
			$result = [];
		}
		echo json_encode($result);
	}

	// Get Manager and Department Head
	public function get_requester_details()
	{
		$manager_id = $this->input->post('manager_id');
		$head_id = $this->input->post('department_head_id');

		if ($manager_id > 0) {
			$manager_name = employeeDetailHelper($manager_id, 'all');
		} else {
			$manager_name = '';
		}
		if ($head_id > 0) {
			$department_head_name = employeeDetailHelper($head_id, 'all');
		} else {
			$department_head_name = '';
		}

		echo json_encode([
			'manager_name' => $manager_name,
			'department_head_name' => $department_head_name,
		]);
	}

	public function getUserBankDetails()
	{
		$requesterType = $this->input->post('requester_type');
		$requesterId = $this->input->post('requester_id');
		if ($requesterType == 'employee') {
			// Fetch employee details based on requester_id
			$this->db->select('payment_type_detail');
			$this->db->from('master_employee');
			$this->db->where('id', $requesterId);
			$query = $this->db->get();
			$employee = $query->row();

			// Decode JSON
			$paymentDetails = json_decode($employee->payment_type_detail, true);

			// Check if data exists and return response
			if ($paymentDetails) {
				$response = [
					'bank_name' => $paymentDetails['bank_name'] ?? '',
					'iban_no' => $paymentDetails['iban_no'] ?? ''
				];
				echo json_encode($response);
				return;
			} else {
				echo json_encode(['bank_name' => '', 'iban_no' => '']);
				return;
			}
		} elseif ($requesterType == 'vendor' || $requesterType == 'saddad') {
			// Fetch vendors
			$this->db->select('vendor_bank_account.*, master_bank.bank_name as master_bank_name');
			$this->db->from('vendor_bank_account');
			$this->db->join('master_bank', 'vendor_bank_account.bank_name = master_bank.id', 'left');
			$this->db->where('vendor_bank_account.vendor_id', $requesterId);
			$query = $this->db->get();
			$vendor = $query->result();

			// Check if data exists and return response
			if ($vendor) {
				$bankList = [];
				foreach ($vendor as $v) {
					$bankList[] = [
						'bank_name' => $v->master_bank_name ?? '',
						'iban_no' => $v->iban_number ?? ''
					];
				}
				// Set the first bank detail as the default
				$response = [
					'bank_name' => $bankList[0]['bank_name'],
					'iban_no' => $bankList[0]['iban_no'],
					'bank_list' => $bankList
				];
				echo json_encode($response);
				return;
			} else {
				echo json_encode(['bank_name' => '', 'iban_no' => '', 'bank_list' => []]);
				return;
			}
		}
	}

	public function store()
	{
		// Form validation rules
		$this->form_validation->set_rules('method_of_payment', 'Method of Payment', 'required');
		$this->form_validation->set_rules('type_of_payment', 'Type of Payment', 'required');
		$this->form_validation->set_rules('request_for_type', 'Request Type', 'required');
		$this->form_validation->set_rules('request_for_id', 'Vendor/Employee', 'required');
		//$this->form_validation->set_rules('department', 'Department', 'required');
		if ($this->input->post('request_for_type') !== 'saddad') {
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('iban_no', 'IBAN', 'required');
		}
		$this->form_validation->set_rules('currency', 'Currency', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		$this->form_validation->set_rules('requester_id', 'Requester', 'required');
		$this->form_validation->set_rules('manager_id', 'Manager', 'required');
		$this->form_validation->set_rules('department_head', 'Department Head', 'required');
		$this->form_validation->set_rules('finance_accountant', 'Accountant', 'required');
		$this->form_validation->set_rules('finance_manager', 'Finance Manager', 'required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'required');

		if ($this->form_validation->run() == FALSE) {
			// If validation fails, reload the form
			$result = array(
				'type' => 'error',
				'message' => validation_errors()
			);
			echo json_encode($result);
			return;
		} else {
			// Get the form data
			$data = array(
				'method_of_payment' => $this->input->post('method_of_payment'),
				'type_of_payment' => $this->input->post('type_of_payment'),
				'partial_percentage' => $this->input->post('partial_percentage'),
				'request_for_type' => $this->input->post('request_for_type'),
				'request_for_id' => $this->input->post('request_for_id'),
				'department' => $this->input->post('department'),
				'cost_center' => $this->input->post('cost_center'),
				'bank_name' => $this->input->post('bank_name'),
				'iban_no' => $this->input->post('iban_no'),
				'currency' => $this->input->post('currency'),
				'amount' => $this->input->post('amount'),
				'vendor_reference' => $this->input->post('vendor_reference'),
				'invoice_no' => $this->input->post('invoice_no'),
				'instructions' => json_encode($this->input->post('instructions')),
				'requester_id' => $this->input->post('requester_id'),
				'manager_id' => $this->input->post('manager_id'),
				'department_head' => $this->input->post('department_head'),
				'finance_accountant' => $this->input->post('finance_accountant'),
				'finance_manager' => $this->input->post('finance_manager'),
				'request_date' => $this->input->post('request_date'),
			);

			// Save the data using the model
			$insert_id = $this->payment_model->insert($data);
			if ($insert_id) {
				// Generate the document_no based on the inserted ID
				$document_no = 'PRF' . date('Y') . '/' . str_pad($insert_id, 6, '0', STR_PAD_LEFT);
				// Update the record with the generated document_no
				$this->payment_model->update($insert_id, array('document_no' => $document_no));
				$result = array("type" => 'success', "message" => 'Payment request has been submitted successfully.');
			} else {
				$result = array("type" => 'error', "message" => 'There was an error submitting the payment request.');
			}
			echo json_encode($result);
		}
	}

	public function edit($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Fetch payment data by ID
		$payment = $this->payment_model->get_payment_request_by_id($id);

		if ($payment) {
			$data['payment'] = $payment;
			$this->load->view('admin/finance/payment_request/edit', $data);
		} else {
			show_404();
		}
	}

	public function quick_update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$payment = $this->payment_model->get_payment_request_by_id($id);
			if ($payment) {
				$output_data = $this->load->view('admin/finance/payment_request/partials/edit', compact('payment'), TRUE);
				$result = array("type" => 'success', "message" => 'Payment detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Payment detail not found, Try another.');
			}
		}
		echo json_encode($result);
	}

	public function update()
	{
		// Form validation rules
		$this->form_validation->set_rules('id', 'Request ID', 'required');
		$this->form_validation->set_rules('method_of_payment', 'Method of Payment', 'required');
		$this->form_validation->set_rules('type_of_payment', 'Type of Payment', 'required');
		$this->form_validation->set_rules('request_for_type', 'Request Type', 'required');
		$this->form_validation->set_rules('request_for_id', 'Vendor/Employee', 'required');
		//$this->form_validation->set_rules('department', 'Department', 'required');
		if ($this->input->post('request_for_type') !== 'saddad') {
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('iban_no', 'IBAN', 'required');
		}
		$this->form_validation->set_rules('currency', 'Currency', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		$this->form_validation->set_rules('requester_id', 'Requester', 'required');
		$this->form_validation->set_rules('manager_id', 'Manager', 'required');
		$this->form_validation->set_rules('department_head', 'Department Head', 'required');
		$this->form_validation->set_rules('finance_accountant', 'Accountant', 'required');
		$this->form_validation->set_rules('finance_manager', 'Finance Manager', 'required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'required');

		if ($this->form_validation->run() == FALSE) {
			// If validation fails, reload the form
			$result = array(
				'type' => 'error',
				'message' => validation_errors()
			);
			echo json_encode($result);
			return;
		} else {
			$id = $this->input->post('id');
			// Get the form data
			$data = array(
				'method_of_payment' => $this->input->post('method_of_payment'),
				'type_of_payment' => $this->input->post('type_of_payment'),
				'partial_percentage' => $this->input->post('partial_percentage'),
				'request_for_type' => $this->input->post('request_for_type'),
				'request_for_id' => $this->input->post('request_for_id'),
				'department' => $this->input->post('department'),
				'cost_center' => $this->input->post('cost_center'),
				'bank_name' => $this->input->post('bank_name'),
				'iban_no' => $this->input->post('iban_no'),
				'currency' => $this->input->post('currency'),
				'amount' => $this->input->post('amount'),
				'vendor_reference' => $this->input->post('vendor_reference'),
				'invoice_no' => $this->input->post('invoice_no'),
				'instructions' => json_encode($this->input->post('instructions')),
				'requester_id' => $this->input->post('requester_id'),
				'manager_id' => $this->input->post('manager_id'),
				'department_head' => $this->input->post('department_head'),
				'finance_accountant' => $this->input->post('finance_accountant'),
				'finance_manager' => $this->input->post('finance_manager'),
				'request_date' => $this->input->post('request_date')
			);

			// Save the data using the model
			$updated = $this->payment_model->update($id, $data);
			if ($updated) {
				$result = array("type" => 'success', "message" => 'Payment request has been updated successfully.');
			} else {
				$result = array("type" => 'error', "message" => 'There was an error submitting the payment request.');
			}
			echo json_encode($result);
		}
	}

	public function payment_status_update()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Form validation rules
		$this->form_validation->set_rules('id', 'Request ID', 'required');
		$this->form_validation->set_rules('finance_Payment_bank', 'Finance Bank', 'required');
		$this->form_validation->set_rules('finance_payment_date', 'Bank Payment Date', 'required');
		if ($this->input->post('request_status') == 'paid') {
			$this->form_validation->set_rules('attachment', 'Attachment', 'callback_validate_attachment');
		}

		if ($this->form_validation->run() == FALSE) {
			// If validation fails, reload the form
			$result = array(
				'type' => 'error',
				'message' => validation_errors()
			);
			echo json_encode($result);
			return;
		} else {
			$id = $this->input->post('id');
			// Get the form data
			$data = array(
				'finance_Payment_bank' => $this->input->post('finance_Payment_bank'),
				'finance_bank_ref' => $this->input->post('finance_bank_ref'),
				'finance_payment_date' => $this->input->post('finance_payment_date'),
				'daftra_reference' => $this->input->post('daftra_reference'),
				'request_status' => $this->input->post('request_status'),
				'updated_at' => date('Y-m-d H:i:s')
			);

			if (!empty($_FILES['attachment']['name'])) {
				$upload_result = upload_image('attachment', './uploads/payment_request/');
				if ($upload_result['status']) {
					$data['attachment'] = $upload_result['data']; // Save file path
				} else {
					$result = array("type" => 'error', "message" => $upload_result['data']);
					echo json_encode($result);
					return;
				}
			}

			// Save the data using the model
			$updated = $this->payment_model->update($id, $data);
			if ($updated) {
				$result = array("type" => 'success', "message" => 'Payment request has been successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'There was an error submitting the payment request.');
			}
			echo json_encode($result);
		}
	}

	public function validate_attachment()
	{
		if (!isset($_FILES['attachment']) || empty($_FILES['attachment']['name'])) {
			$this->form_validation->set_message('validate_attachment', 'The {field} field is required.');
			return false;
		}
		return true;
	}

	// Custom validation callback for date_of_issue
	public function valid_date($date)
	{
		$today = date('Y-m-d');
		if ($date < $today) {
			$this->form_validation->set_message('valid_date', 'The {field} must be today or a future date.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Fetch payment data by ID
		$payment = $this->payment_model->get_payment_request_by_id($id);

		if ($payment) {
			$data['payment'] = $payment;
			$this->load->view('admin/finance/payment_request/detail', $data);
		} else {
			show_404();
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('check_list');
		if (!empty($ids)) {
			$id_list = implode(',', $ids);
			$query = $this->payment_model->delete($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully deleted");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		} else {
			$this->session->set_userdata('info', "2--No items selected for deletion.");
		}
		redirect('admin/finance/payment-request');
	}

	/*----- Print Start -----*/
	public function print_form_detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$payment_center = $this->payment_model->get_payment_request_by_id($id);
		$doc_type = $payment_center->document_no;
		$data['print_date'] = date('l, d F, Y');
		//$data['signature_date'] = date('jS F Y');
		$data['signature_date'] = date('j-M-Y');
		$data['request_date'] = date('j-M-Y', strtotime($payment_center->request_date));
		//dd($payment_center);
		if ($id > 0) {
			$data['payment'] = $payment_center;
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Payment Request Form');
			$pdf->SetSubject('BS - Payment Request Form');
			$pdf->SetKeywords('Baqala Station, PDF, Payment Request Form');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
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

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(10, 40, 11, true);
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
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/finance/payment_request/print/payment_request_form', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output($doc_type . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/finance/payment-request');
		}
	}

	//Perosnal

	public function print_personal_finance_detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'payment_request_form', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$payment_center = $this->payment_model->get_payment_request_by_id($id);
		//dd($payment_center);
		$doc_no = $payment_center->document_no;
		$data['print_date'] = date('l, d F, Y');
		//$data['signature_date'] = date('jS F Y');
		$data['signature_date'] = date('j-M-Y');
		$data['request_date'] = date('j-M-Y', strtotime($payment_center->request_date));
		$class_name = 'Pdf_general_margin';
		$this->load->library($class_name);

		//print_r($payment_center);exit();
		if ($id > 0) {
			$data['payment'] = $payment_center;
			// create new PDF document
			$pdf = new $class_name(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Personal Finance Request Form');
			$pdf->SetSubject('BS - Personal Finance Request Form');
			$pdf->SetKeywords('Baqala Station, PDF, Personal Finance Request Form, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
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

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			// Conditional top margin setting
			$pdf->SetMargins(10, 40, 11, true);
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
			$pdf->AddPage();
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('dejavusans', '', 10);
			$htmlcontent = $this->load->view('admin/finance/payment_request/print/personal_finance_request', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Personal-Finance-Request-Form' . '_' . $doc_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Request detail not found!");
			redirect('admin/finance/payment-request');
		}
	}
}
