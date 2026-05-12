<?php defined('BASEPATH') or exit('No direct script access allowed');

class FoodAllowance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Food_allowance_model', 'food_allowance_model');
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
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
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
		$data['positions'] = allDesignation();
		//$allowance_list = $this->food_allowance_model->get_batch_list(); 
		//dd($allowance_list);
		$this->load->view('admin/hr-module/food_allowance/index', $data);
	}

	public function get_list()
	{
		$allowance_list = $this->food_allowance_model->get_batch_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($allowance_list as $key => $value) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $value['batch_no'];
			$sub_array[] = date('d-m-Y', strtotime($value['arrival_date']));
			$sub_array[] = $value['member_count'];
			$sub_array[] = date('d-m-Y H:i A', strtotime($value['created_at']));
			if ($value['slots_paid'] == '4') {
				$updateBtn = '';
			} else {
				$updateBtn = check_action_permission(get_user_role(), 'food_allowance_request', 'update_allowance') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit float-start" title="Update Payment" data-batch_no="' . $value['batch_no'] . '" onclick="getBatchCv(\'' . $value['batch_no'] . '\')"><i class="mdi mdi-cash-plus font-size-18"></i></button>' : '';
			}
			$printButtons = '';
			if (
				check_action_permission(get_user_role(), 'food_allowance_request', 'print_batch_detail') ||
				check_action_permission(get_user_role(), 'food_allowance_request', 'print_iqama_cost') ||
				check_action_permission(get_user_role(), 'food_allowance_request', 'print_recruitment_invoice')
			) {
				$printButtons .= '<div class="dropdown float-start">
					<button class="btn nav-btn dropdown-toggle btn-custom-light btn-sm edit" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="mdi mdi-dots-vertical font-size-18"></i>
					</button>
					<div class="dropdown-menu dropdown-menu-end">';

				if (check_action_permission(get_user_role(), 'food_allowance_request', 'print_batch_detail')) {
					$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/food-allowance/print-detail?batch_no=' . $value['batch_no']) . '" target="_blank">
						Print Food Allowance [PDF]
					</a>';
					$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/food-allowance/print-detail2?batch_no=' . $value['batch_no']) . '" target="_blank">
						Print Food Allowance 2 [PDF]
					</a>';
				}
				if (check_action_permission(get_user_role(), 'food_allowance_request', 'export_food_allowance_detail')) {
					$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/food-allowance/export-excel?batch_no=' . $value['batch_no']) . '" target="_blank">Export Food Allowance [Excel]</a>';
				}

				if (check_action_permission(get_user_role(), 'food_allowance_request', 'print_iqama_cost')) {
					$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/food-allowance/print-iqama-cost?batch_no=' . $value['batch_no']) . '" target="_blank">
						Print Iqama Issue Cost
					</a>';
				}
				/*
				if (check_action_permission(get_user_role(), 'food_allowance_request', 'print_recruitment_invoice')) {
					$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/food-allowance/print-recruitment-invoice?batch_no=' . $value['batch_no']) . '" target="_blank">
						Print Recruitment Invoice
					</a>';
				}
				*/
				$printButtons .= '</div></div>';
			}
			$sub_array[] = (check_action_permission(get_user_role(), 'food_allowance_request', 'view_batch_detail') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit view-batch-detail float-start" title="Detail" data-batch_no="' . $value['batch_no'] . '" onclick="viewBatchDetail(\'' . $value['batch_no'] . '\')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button> ' : '') . $updateBtn . ' ' . $printButtons;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->food_allowance_model->get_all_data(),
			"recordsFiltered" => $this->food_allowance_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add_allowance_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/hr-module/food_allowance/partials/add_allowance_request');
	}

	public function get_employee_view()
	{
		$arrival_date = $this->input->get('arrival_date');

		if (empty($arrival_date)) {
			$data['error'] = 'Arrival date is required to filter employees.';
			$this->load->view('admin/hr-module/food_allowance/partials/employee_list');
			return;
		}

		// Parse the year and month from the date
		$arrival_year = date('Y', strtotime($arrival_date));
		$arrival_month = date('m', strtotime($arrival_date));
		$current_day = date('j', strtotime($arrival_date));
		// Get the number of days in the specified month
		//$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $arrival_month, $arrival_year);
		$daysInMonth = 30;
		$data['arrival_month_days'] = $daysInMonth;

		// Calculate remaining days in the month
		$arrival_day = date('d', strtotime($arrival_date));
		$remaining_days = $daysInMonth - $arrival_day;
		$data['remaining_days_in_month'] = $remaining_days;
		$data['current_day'] = $current_day;

		// Fetch employees based on the arrival date
		$data['employees'] = $this->food_allowance_model->get_cv_not_in_food_allowance($arrival_date);
		$data['selected_emp'] = [];

		// Load the view with data
		$this->load->view('admin/hr-module/food_allowance/partials/employee_list', $data);
	}

	public function save_allowance()
	{
		// Validation rules
		$this->form_validation->set_rules('arrival_date', 'Arrival Date', 'required');
		$this->form_validation->set_rules('selected_cvs[]', 'Select Cv', 'callback_validate_cvs');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
		}

		$data = $this->input->post();
		$arrival_date = $data['arrival_date'];
		$cv_ids = $data['selected_cvs'];

		// Prepare date calculations only once
		$arrival_year = date('Y', strtotime($arrival_date));
		$arrival_month = date('m', strtotime($arrival_date));
		//$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $arrival_month, $arrival_year);
		$daysInMonth = 30;
		$arrival_day = date('d', strtotime($arrival_date));
		$remaining_days = $daysInMonth - $arrival_day;
		$current_day = date('j', strtotime($arrival_date));

		// Generate a random 6-digit number for the batch number
		$batch_no = 'RA' . date("Ymd", strtotime($arrival_date));

		// Prepare allowance data
		$allowance_entries = [];
		foreach ($cv_ids as $cv_id) {
			$cv_detail = $this->food_allowance_model->get_cv_detail($cv_id);

			// Validate cv_detail response
			if (!$cv_detail) {
				echo json_encode(['status' => 'error', 'message' => "CV ID {$cv_id} not found."]);
				return;
			}
			$food_allow = $cv_detail['food_allow'];
			$per_day_allowance = $food_allow / $daysInMonth;
			if ($current_day <= 15) {
				$remaining_days_in_period = 15 - $current_day + 1;
			} else {
				$remaining_days_in_period = $daysInMonth - $current_day + 1;
			}
			$rest_allowance = $per_day_allowance * $remaining_days_in_period;

			$first_payment = [
				'payment_date' => $arrival_date,
				'payment_amt' => number_format($rest_allowance, 2, '.', '')
			];

			$allowance_entries[] = [
				'batch_no' => $batch_no,
				'cv_id' => $cv_detail['id'],
				'salary_package' => $cv_detail['salary_package'],
				'arrival_date' => $arrival_date,
				'food_allowance' => $food_allow,
				'slots_paid' => 1,
				'first_payment' => json_encode($first_payment)
			];
		}
		// Insert data into the database
		if ($this->food_allowance_model->insertAllowance($allowance_entries)) {
			echo json_encode(['status' => 'success', 'message' => 'Food allowance added successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to add food allowance. Please try again.']);
		}
	}

	public function validate_cvs()
	{
		$cv_list = $this->input->post('selected_cvs');

		if (empty($cv_list)) {
			$this->form_validation->set_message('validate_cvs', 'No CV selected.');
			return FALSE;
		}

		foreach ($cv_list as $value) {
			if (!empty($value)) {
				$this->db->where('cv_id', $value);
				$query = $this->db->get('food_allowance_distribution');

				if ($query->num_rows() > 0) {
					$this->form_validation->set_message('validate_cvs', 'Selected CV ID ' . $value . ' already exists in food allowance.');
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	public function view_batch_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$batch_no = $this->input->get('batch_no');

		if (empty($batch_no)) {
			echo json_encode(['status' => 'error', 'message' => 'Batch number required.']);
			return;
		}
		$data['batch_no'] = $batch_no;
		$data['allowance_list'] = $this->food_allowance_model->get_list($batch_no);
		// Load the view with data
		$this->load->view('admin/hr-module/food_allowance/partials/batch_detail', $data);
	}

	public function get_batch_cv()
	{
		$batch_no = $this->input->get('batch_no');

		if (empty($batch_no)) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid batch number!']);
			return;
		}
		$query = $this->food_allowance_model->get_list($batch_no);
		if (count($query) > 0) {
			$data['allowance_list'] = $query;
			if ($data['allowance_list'][0]['slots_paid'] == '1') {
				$last_payment_info = $data['allowance_list'][0]['first_payment'];
			} elseif ($data['allowance_list'][0]['slots_paid'] == '2') {
				$last_payment_info = $data['allowance_list'][0]['second_payment'];
			} elseif ($data['allowance_list'][0]['slots_paid'] == '3') {
				$last_payment_info = $data['allowance_list'][0]['third_payment'];
			} elseif ($data['allowance_list'][0]['slots_paid'] == '4') {
				$last_payment_info = $data['allowance_list'][0]['fourth_payment'];
			}
			$last_payment_date = date('d-m-Y', strtotime(json_decode($last_payment_info)->payment_date));
			// Get the first payment date from JSON
			$lastPaymentData = json_decode($last_payment_info, true);
			$lastPaymentDate = new DateTime($lastPaymentData['payment_date']);

			// Logic to determine second payment date
			if ((int)$lastPaymentDate->format('d') <= 15) {
				$currentPaymentDate = $lastPaymentDate->format('Y-m-16');
			} else {
				$currentPaymentDate = $lastPaymentDate->modify('first day of next month')->format('Y-m-01');
			}

			$data['batch_detail'] = array(
				'batch_no' => $data['allowance_list'][0]['batch_no'],
				'arrival_date' => $data['allowance_list'][0]['arrival_date'],
				'last_payment_date' => $last_payment_date,
				'scheduled_payment_date' => $currentPaymentDate,
				'total_cvs' => count($query)
			);
			$this->load->view('admin/hr-module/food_allowance/partials/batch_payment_update', $data);
			return;
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No data found!']);
			return;
		}
	}

	public function update_allowance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Validation rules
		$this->form_validation->set_rules('batch_no', 'Batch No.', 'required');
		$this->form_validation->set_rules('selected_cvs[]', 'Select Cv', 'required');
		// Set validation rules for 'confirm_payment'
		$this->form_validation->set_rules('confirm_payment', 'Transaction Confirmation', 'required|in_list[1]', [
			'required' => 'You must confirm to complete the transaction.',
			'in_list' => 'Invalid transaction confirmation.'
		]);

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
		}

		$data = $this->input->post();
		$batch_no = $data['batch_no'];
		$cv_ids = $data['selected_cvs'];

		$query = $this->food_allowance_model->get_allowance_list($batch_no, $cv_ids);
		if (count($query) > 0) {
			$allowance_list = $query;
			$slot_paid = $allowance_list[0]['slots_paid'];

			// Simplified lookup for last_payment_info
			$payment_fields = [
				'1' => 'first_payment',
				'2' => 'second_payment',
				'3' => 'third_payment',
				'4' => 'fourth_payment'
			];

			$last_payment_info = $allowance_list[0][$payment_fields[$slot_paid] ?? ''];
			$lastPaymentData = json_decode($last_payment_info, true);
			$lastPaymentDate = new DateTime($lastPaymentData['payment_date']);

			// Function to calculate the next payment date
			function getNextPaymentDate(DateTime $lastPaymentDate)
			{
				if ((int)$lastPaymentDate->format('d') <= 15) {
					return $lastPaymentDate->format('Y-m-16');
				} else {
					return $lastPaymentDate->modify('first day of next month')->format('Y-m-01');
				}
			}

			// Calculate next payment date
			$scheduled_payment_date = getNextPaymentDate($lastPaymentDate);

			// Prepare allowance entries
			$allowance_entries = [];
			foreach ($allowance_list as $cv) {
				$food_allow = $cv['food_allowance'];
				$current_slot = $cv['slots_paid'] + 1;
				$nextPaymentDate = date('d-m-Y', strtotime($scheduled_payment_date));
				$arrival_year = date('Y', strtotime($nextPaymentDate));
				$arrival_month = date('m', strtotime($nextPaymentDate));
				//$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $arrival_month, $arrival_year);
				$daysInMonth = 30;
				$current_day = date('j', strtotime($nextPaymentDate));

				$remaining_allowance = ($food_allow / $daysInMonth) * (($current_day <= 15) ? (15 - $current_day + 1) : ($daysInMonth - $current_day + 1));

				// Determine slot_name
				$slot_name = ['2' => 'second_payment', '3' => 'third_payment', '4' => 'fourth_payment'][$current_slot] ?? 'NULL';

				$payment_info = [
					'payment_date' => $nextPaymentDate,
					'payment_amt' => number_format($remaining_allowance, 2, '.', '')
				];

				$allowance_entries[] = [
					'id' => $cv['id'],
					'slots_paid' => $current_slot,
					$slot_name => json_encode($payment_info)
				];
			}

			// Update allowance entries in the database
			if ($this->food_allowance_model->updateAllowance($allowance_entries)) {
				echo json_encode(['status' => 'success', 'message' => 'Food allowance updated successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to add food allowance. Please try again.']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No CV found in this batch.']);
		}
	}

	/*----- Print Start -----*/

	public function print_batch_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$batch_no = $this->input->get('batch_no');
		$this->load->library('Pdf_general_margin');
		$query = $this->food_allowance_model->get_list($batch_no);
		if (count($query) > 0) {
			$data['batch_detail'] = $query;
			$data['batch_list'] = array(
				'batch_no' => $data['batch_detail'][0]['batch_no'],
				'arrival_date' => $data['batch_detail'][0]['arrival_date'],
				'total_cvs' => count($query)
			);
			// create new PDF document
			$pdf = new Pdf_general_margin(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Food Allowance Distribution List');
			$pdf->SetSubject('BS - Food Allowance Distribution List');
			$pdf->SetKeywords('Baqala Station, PDF, Food Allowance Distribution List');

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
			$pdf->SetMargins(5, 0, 6, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 15);
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
			$pdf->AddPage('L');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/food_allowance/print/print-allowance', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('food-allowance-distribution-' . $batch_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Food allowance detail not found!");
			redirect('admin/hr/food-allowance/index');
		}
	}
	
	public function print_batch_detail_new()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$batch_no = $this->input->get('batch_no');
		$this->load->library('Pdf_general_margin');
		$query = $this->food_allowance_model->get_list($batch_no);
		if (count($query) > 0) {
			$data['batch_detail'] = $query;
			$data['batch_list'] = array(
				'batch_no' => $data['batch_detail'][0]['batch_no'],
				'arrival_date' => $data['batch_detail'][0]['arrival_date'],
				'total_cvs' => count($query)
			);
			// create new PDF document
			$pdf = new Pdf_general_margin(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Food Allowance Distribution List');
			$pdf->SetSubject('BS - Food Allowance Distribution List');
			$pdf->SetKeywords('Baqala Station, PDF, Food Allowance Distribution List');

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
			$pdf->SetMargins(5, 0, 6, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 15);
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
			$pdf->AddPage('L');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/food_allowance/print/print-allowance-200', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('food-allowance-distribution-' . $batch_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Food allowance detail not found!");
			redirect('admin/hr/food-allowance/index');
		}
	}

	public function print_iqama_cost()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$batch_no = $this->input->get('batch_no');
		$this->load->library('Pdf_general_margin');
		$query = $this->food_allowance_model->get_list($batch_no);
		if (count($query) > 0) {
			$data['batch_detail'] = $query;
			$data['batch_list'] = array(
				'batch_no' => $data['batch_detail'][0]['batch_no'],
				'arrival_date' => $data['batch_detail'][0]['arrival_date'],
				'total_cvs' => count($query)
			);
			// create new PDF document
			$pdf = new Pdf_general_margin(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Iqama Issue Cost Breakdown');
			$pdf->SetSubject('BS - Iqama Issue Cost Breakdown');
			$pdf->SetKeywords('Baqala Station, PDF, Iqama Issue Cost Breakdown List');

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
			$pdf->SetMargins(5, 0, 6, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 15);
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
			$pdf->AddPage('L');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/food_allowance/print/print-iqama-issue-breakdown', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('iqama-issue-cost-breakdown-' . $batch_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--No detail not found!");
			redirect('admin/hr/food-allowance/index');
		}
	}

	public function print_food_receipt()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		$fd_id = $this->input->get('id');
		$this->load->library('Pdf_general_margin');
		$query = $this->food_allowance_model->get_allowance_detail($fd_id);
		//dd($query);
		if ($query) {
			$data['batch_detail'] = $query;
			$data['issue_date'] = date('j-M-Y', strtotime($data['batch_detail']['arrival_date']));
			$data['cv_no'] = $data['batch_detail']['cv_no'];
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Food Receipt Voucher');
			$pdf->SetSubject('BS - Food Receipt Voucher');
			$pdf->SetKeywords('Baqala Station, PDF, Food Receipt Voucher, Employee');

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
			$pdf->SetFont('dejavusans', '', 10);
			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/food_allowance/print/print-allowance-receipt', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			$pdf->Output('food-receipt-voucher-' . $data['cv_no'] . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--No detail not found!");
			redirect('admin/hr/food-allowance/index');
		}
	}

	public function print_recruitment_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$batch_no = $this->input->get('batch_no');
		$this->load->library('Pdf_employee_offer');
		//$this->load->library('Pdf_employee_offer');
		$query = $this->food_allowance_model->get_list($batch_no);
		if (count($query) > 0) {
			$data['batch_detail'] = $query;
			$searchBatchNo = $data['batch_detail'][0]['batch_no'];
			$arrivalDate = $data['batch_detail'][0]['arrival_date'];

			$data['batch_list'] = array(
				'batch_no' => $searchBatchNo,
				'arrival_date' => $arrivalDate,
				'total_cvs' => count($query)
			);

			$data['print_date'] = date('d.m.Y');
			$data['signature_date'] = date('jS F Y');

			$year = date("Y", strtotime($arrivalDate));
			$next_year = $year + 1;

			$batch_nos = $this->food_allowance_model->getDistinctBatchNosBetwYear($year, $next_year);

			// Ensure $batch_nos contains valid data
			if (empty($batch_nos)) {
				// Handle the case when no data is returned
				log_message('error', 'No batch numbers found for the given year range.');
				// You can either return an error message or set a default value
				$data['batch_list']['batch_no'] = 'N/A'; // For example, set a default batch number
				$data['batch_list']['total_cvs'] = 0; // Default to 0 if no batch numbers are found
			} else {
				// Filter the array to get entries that match the search term in 'batch_no'
				$filteredData = array_filter($batch_nos, function ($item) use ($searchBatchNo) {
					return strpos($item['batch_no'], $searchBatchNo) !== false;
				});

				// Reset the array keys to avoid gaps in keys after filtering
				$filteredData = array_values($filteredData);

				// Ensure there is data after filtering
				if (empty($filteredData)) {
					log_message('error', 'No matching batch numbers found for batch_no: ' . $searchBatchNo);
					$unique_id = '000';
				} else {
					$unique_id = str_pad($filteredData[0]['serial_no'], 3, '0', STR_PAD_LEFT);
				}
			}
			$data['invoice_no'] = $unique_id . '/' . $year . '-' . substr($next_year, -2);
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Recruitment Invoice');
			$pdf->SetSubject('BS - Recruitment Invoice');
			$pdf->SetKeywords('Baqala Station, PDF, Recruitment Invoice List');

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
			$pdf->SetMargins(5, 0, 6, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 15);
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
			$pdf->AddPage('P');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/food_allowance/print/print-recruitment-invoice', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('recruitment-invoice-' . $batch_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--No detail not found!");
			redirect('admin/hr/food-allowance/index');
		}
	}

	public function delete_food_allowance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('leave_id', 'Request ID', 'required');
		$leave_id = $this->input->post('leave_id');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Select alteast one row to delete.']);
			return;
		} else {
			$result = $this->food_allowance_model->delete_approval($leave_id);
			if ($result) {
				echo json_encode(['status' => 'success', 'message' => 'Leave approval deleted successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Error deleting leave.']);
			}
		}
	}

	public function refresh_user_allowance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'food_allowance_request', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Validate the incoming request
		$this->form_validation->set_rules('id', 'Request ID', 'required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
		}

		$id = $this->input->post('id');
		$allowance_detail = $this->food_allowance_model->get_allowance_detail($id);

		if (!empty($allowance_detail)) {
			$cv_id = $allowance_detail['cv_id'];
			$cv_detail = $this->food_allowance_model->get_cv_detail($cv_id);

			if (!empty($cv_detail)) {
				$food_allowance = $cv_detail['food_allow'];
				$salary_package = $cv_detail['salary_package'];
				$slots_paid = $allowance_detail['slots_paid'];
				$arrival_date = $allowance_detail['arrival_date'];

				// Constants for calculations
				$days_in_month = 30; // Assuming fixed days in a month
				$arrival_day = (int)date('d', strtotime($arrival_date));
				$per_day_allowance = $food_allowance / $days_in_month;

				// Payment calculations
				$payments = [];
				// First payment: remaining days in the arrival month
				if ($slots_paid >= 1) {
					$remaining_days_slot1 = $days_in_month - $arrival_day + 1;
					$payments['first_payment'] = [
						'payment_date' => $arrival_date,
						'payment_amt' => number_format($per_day_allowance * $remaining_days_slot1, 2, '.', '')
					];
				}

				// Second payment: full allowance for the next month
				if ($slots_paid >= 2) {
					$payments['second_payment'] = [
						'payment_date' => date('Y-m-d', strtotime("+1 month", strtotime($arrival_date))),
						'payment_amt' => number_format($food_allowance, 2, '.', '')
					];
				}

				// Third payment: full allowance for the month after the second
				if ($slots_paid >= 3) {
					$payments['third_payment'] = [
						'payment_date' => date('Y-m-d', strtotime("+2 months", strtotime($arrival_date))),
						'payment_amt' => number_format($food_allowance, 2, '.', '')
					];
				}

				// Fourth payment: full allowance for the month after the third
				if ($slots_paid >= 4) {
					$payments['fourth_payment'] = [
						'payment_date' => date('Y-m-d', strtotime("+3 months", strtotime($arrival_date))),
						'payment_amt' => number_format($food_allowance, 2, '.', '')
					];
				}

				// Assign NULL to remaining slots
				$payments['first_payment'] = $payments['first_payment'] ?? NULL;
				$payments['second_payment'] = $payments['second_payment'] ?? NULL;
				$payments['third_payment'] = $payments['third_payment'] ?? NULL;
				$payments['fourth_payment'] = $payments['fourth_payment'] ?? NULL;

				//dd($payments);
				// Prepare the updated data array
				$updated_data = [
					'salary_package' => $salary_package,
					'food_allowance' => $food_allowance,
					'first_payment' => !is_null($payments['first_payment']) ? json_encode($payments['first_payment']) : NULL,
					'second_payment' => !is_null($payments['second_payment']) ? json_encode($payments['second_payment']) : NULL,
					'third_payment' => !is_null($payments['third_payment']) ? json_encode($payments['third_payment']) : NULL,
					'fourth_payment' => !is_null($payments['fourth_payment']) ? json_encode($payments['fourth_payment']) : NULL,
				];

				// Update the database
				$update_success = $this->food_allowance_model->refreshAllowance($id, $updated_data);

				if ($update_success) {
					echo json_encode(['status' => 'success', 'message' => 'Food allowance updated successfully.']);
				} else {
					echo json_encode(['status' => 'error', 'message' => 'Failed to update food allowance. Please try again.']);
				}
			} else {
				echo json_encode(['status' => 'error', 'message' => 'CV details not found.']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Allowance detail not found.']);
		}
	}
}
