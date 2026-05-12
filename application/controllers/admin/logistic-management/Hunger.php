<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Hunger extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/Hunger_model', 'import');
		$this->load->library('form_validation');
		$this->load->helper('common_helper');
		$this->load->helper('sendmail_helper');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
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
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view("admin/logistic-management/hunger/index", $data);
	}

	public function upload()
	{
		$this->load->view("admin/logistic-management/hunger/import_hunger");
	}

	/*----- Bulk Import Hunger -----*/
	public function import_file()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$path = 'uploads/imports/deliveries/';
		$json = [];

		$this->upload_config($path);

		try {
			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors());
			}

			$file_data = $this->upload->data();
			$file_name = $path . $file_data['file_name'];
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);

			if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
				throw new Exception('Unsupported file format.');
			}

			$reader = $this->getReaderByExtension($extension);
			$spreadsheet = $reader->load($file_name);
			$sheet_data = $spreadsheet->getActiveSheet()->toArray();

			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);

			// Initialize transaction
			$this->db->trans_start();

			$batch_data = [];
			$duplicate_rows = [];

			foreach ($sheet_data as $val) {
				if ($val[0] != '') {
					$date_local = date('Y-m-d', strtotime($this->input->post('order_date')));
					if ($date_local == '') {
						$json = [
							'error_message' => 'Invalid date format'
						];
						echo json_encode($json);
						exit();
					}
					//dd($date_local);
					$isDuplicate = $this->import->checkDuplicateInBulk([
						"rider_id" => $val[0],
						"date_local" => $date_local,
					]);
					//print_r($isDuplicate);exit();
					if (!$isDuplicate) {
						// Get emp_id from logistic_rider by matching id_number with rider_id from Excel
						$riderInfo = getRiderInfoForDayHelper($val[0], $date_local);

						$emp_id     = $riderInfo['emp_id'];
						$vehicle_id = $riderInfo['vehicle_id'];
						$team_id    = $riderInfo['team_id'];

						$batch_data[] = [
							"emp_id" => $emp_id,
							"rider_id" => $val[0],
							"city_name" => $val[1],
							"tga_status" => $val[2],
							"date_local" => $date_local,
							"error_codes" => $val[4],
							"working_days" => $val[5],
							"batch_number" => $val[6],
							"planned_working_hours" => $val[7],
							"working_hours" => $val[8],
							"attendance_rate" => $val[9],
							"avg_working_hours" => $val[10],
							"break_hours" => $val[11],
							"number_of_shifts" => $val[12],
							"no_shows" => $val[13],
							"no_shows_percent" => $val[14],
							"notified_deliveries" => $val[15],
							"accepted_deliveries" => $val[16],
							"completed_deliveries" => $val[17],
							"not_accepted_deliveries" => $val[18],
							"declined_deliveries" => $val[19],
							"cancelled_deliveries" => $val[20],
							"acceptance_rate" => $val[21],
							"lost_hours" => $val[22],
							"contact_rate" => $val[23],
							"alloted_vehicle_id" => $vehicle_id,
							"alloted_team_id" => $team_id,
							"ip_address" => $this->ip_address,
							"created_at" => $this->datetime,
							"updated_at" => $this->datetime
						];
					} else {
						// Add the row to the list of duplicates
						$duplicate_rows[] = $val;
					}
				}

				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = [];
				}
			}
			// Insert any remaining data
			if (!empty($batch_data)) {
				$this->insertBatchData($batch_data);
			}

			// Commit transaction
			$this->db->trans_complete();

			// Delete the file
			if (file_exists($file_name)) {
				unlink($file_name);
			}

			// Check if there were any duplicate rows
			if (!empty($duplicate_rows)) {
				$json = [
					'error_message' => count($duplicate_rows) . ' Duplicate row(s) found. <span class="text-success">Rest all inserted</span>',
					'duplicate_rows' => $duplicate_rows
				];
			} else {
				//$this->sendWeeklyReports($date_local);
				$json = [
					'success_message' => 'All Entries are imported successfully.',
				];
			}
		} catch (Exception $e) {
			// Rollback transaction if any error occurs
			$this->db->trans_rollback();
			$json = [
				'error_message' => $e->getMessage()
			];
		}

		echo json_encode($json);
		exit();
	}

	private function getReaderByExtension($extension)
	{
		switch ($extension) {
			case 'csv':
				return new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			case 'xlsx':
			case 'xls':
				return new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			default:
				throw new Exception('Unsupported file format.');
		}
	}

	private function insertBatchData($batch_data)
	{
		$result = $this->db->insert_batch('hunger_order_summary', $batch_data);

		if (!$result) {
			$json = [
				'error_message' => 'Something went wrong. Please try again.',
			];
			echo json_encode($json);
			exit();
		}
	}

	public function upload_config($path)
	{
		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}

		$config['upload_path'] = './' . $path;
		$config['allowed_types'] = 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = 4096;
		$this->load->library('upload', $config);
	}

	/*----- Bulk Import Hunger End -----*/
	
	/*----- Send Progress Mail -----*/
	private function sendWeeklyReports($date_local)
	{
		//$date_local = '2025-07-22';

		// Determine Sunday–Saturday week range
		$timestamp = strtotime($date_local);

		// Find Sunday
		$start_date = date('Y-m-d', strtotime('last sunday', $timestamp));
		if (date('w', $timestamp) == 0) {
			$start_date = date('Y-m-d', $timestamp);
		}

		// Find Saturday
		$end_date = date('Y-m-d', strtotime('next saturday', $timestamp));
		if (date('w', $timestamp) == 6) {
			$end_date = date('Y-m-d', $timestamp);
		}

		// Get all unique employees in this week
		$employees = $this->db->select('hos.emp_id, me.email, me.full_name')
			->from('hunger_order_summary hos')
			->join('master_employee me', 'me.id = hos.emp_id', 'left')
			->where('hos.date_local >=', $start_date)
			->where('hos.date_local <=', $end_date)
			->group_by('hos.emp_id')
			->get()
			->result();

		foreach ($employees as $emp) {
			$reportData = $this->getWeeklyReportData($emp->emp_id, $start_date, $end_date);

			if (!empty($reportData)) {
				//$htmlContent = $this->generateReportHTML($reportData, $emp->full_name, $start_date, $end_date);
				// Prepare email data for helper
				$email_data = [
					'email'     => $emp->email,
					'name'     => $emp->full_name,
					'subject'   => "Delivery Summary for ($start_date to $end_date)",
					'template'  => 'admin/attatchment-template/hunger_weekly_performance',
					'data'      => $reportData
				];

				// Send via helper
				send_global_mail_helper($email_data);
			}
		}
	}

	private function getWeeklyReportData($emp_id, $start_date, $end_date)
	{
		$dailyTarget = 15; // Fixed per day

		// Fetch achievement per day
		$this->db->select('date_local, SUM(completed_deliveries) as achievement');
		$this->db->from('hunger_order_summary');
		$this->db->where('emp_id', $emp_id);
		$this->db->where('date_local >=', $start_date);
		$this->db->where('date_local <=', $end_date);
		$this->db->group_by('date_local');
		$result = $this->db->get()->result_array();

		// Map DB results
		$dataMap = [];
		foreach ($result as $row) {
			$dataMap[$row['date_local']] = [
				'achievement' => (float)$row['achievement']
			];
		}

		// Build complete week
		$dailyData = [];
		$current = strtotime($start_date);
		$end = strtotime($end_date);

		while ($current <= $end) {
			$dateStr = date('Y-m-d', $current);

			$achievement = isset($dataMap[$dateStr]) ? $dataMap[$dateStr]['achievement'] : 0;
			$pending = max(0, $dailyTarget - $achievement);

			// Calculate daily status
			$percentage = ($achievement / $dailyTarget) * 100;
			if ($percentage >= 90) {
				$status = 'Excellent';
			} elseif ($percentage >= 60) {
				$status = 'Good';
			} else {
				$status = 'Poor';
			}

			$dailyData[] = [
				'date_local'  => $dateStr,
				'target'      => $dailyTarget,
				'achievement' => $achievement,
				'pending'     => $pending,
				'status'      => $status
			];

			$current = strtotime('+1 day', $current);
		}

		// Weekly summary
		$totalTarget = $dailyTarget * 7;
		$totalAchieved = array_sum(array_column($dailyData, 'achievement'));
		$pendingTotal = $totalTarget - $totalAchieved;

		// Days remaining (0 if week already passed)
		$today = date('Y-m-d');
		if ($end_date < $today) {
			$daysRemaining = 0;
		} else {
			$daysRemaining = floor((strtotime($end_date) - strtotime($today)) / 86400) + 1;
			if ($daysRemaining < 0) $daysRemaining = 0;
		}

		// Weekly rating
		$percentageWeekly = ($totalTarget > 0) ? ($totalAchieved / $totalTarget) * 100 : 0;
		if ($percentageWeekly >= 90) {
			$weeklyRating = 'Excellent';
		} elseif ($percentageWeekly >= 60) {
			$weeklyRating = 'Good';
		} else {
			$weeklyRating = 'Poor';
		}

		return [
			'summary' => [
				'target'         => $totalTarget,
				'achievement'    => $totalAchieved,
				'pending'        => $pendingTotal,
				'days_remaining' => $daysRemaining,
				'rating'         => $weeklyRating
			],
			'daily' => $dailyData
		];
	}

	/*----- Send Progress Mail End -----*/

	public function get_list()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('rider_id'))) {
			$rider_id = $this->input->get('rider_id');
		} else {
			$rider_id = FALSE;
		}
		if (!empty($this->input->get('vehicle_type'))) {
			$vehicle_type = $this->input->get('vehicle_type');
		} else {
			$vehicle_type = FALSE;
		}
		if (!empty($this->input->get('city'))) {
			$city = $this->input->get('city');
		} else {
			$city = FALSE;
		}
		if (!empty($this->input->get('employer'))) {
			$employer = $this->input->get('employer');
		} else {
			$employer = FALSE;
		}
		if (!empty($this->input->get('deliveries_less_than'))) {
			$deliveries_less_than = $this->input->get('deliveries_less_than');
		} else {
			$deliveries_less_than = FALSE;
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

		$fetch_data = $this->import->get_list($keyword, $rider_id, $vehicle_type, $start_date, $end_date, $deliveries_less_than, $city, $employer);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->rider_id;
			$sub_array[] = $item->emp_no;
			$sub_array[] = $item->full_name;
			$sub_array[] = $item->team_name;
			$sub_array[] = $item->alloted_mobile_number;
			$sub_array[] = $item->city_name;
			$sub_array[] = date('d-m-Y', strtotime($item->date_local));
			$sub_array[] = $item->completed_deliveries;
			$sub_array[] = $item->cancelled_deliveries;
			$sub_array[] = $item->notified_deliveries;
			$sub_array[] = $item->declined_deliveries;
			$sub_array[] = $item->accepted_deliveries;
			$sub_array[] = $item->not_accepted_deliveries;
			$sub_array[] = $item->monthly_wallet_balance;
			$sub_array[] = $item->rider_earnings;
			$sub_array[] = $item->acceptance_rate . '%';
			$sub_array[] = $item->rider_delivery_time;
			$sub_array[] = $item->working_hours;
			$sub_array[] = $item->vehicle_type;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			// $sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/master/employee/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/master/employee/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->import->get_all_data(),
			"recordsFiltered"     =>     $this->import->get_filtered_data($keyword, $rider_id, $vehicle_type, $start_date, $end_date, $deliveries_less_than, $city, $employer),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function print_daily_performance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_hunger_report');
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('rider_id'))) {
			$rider_id = $this->input->get('rider_id');
		} else {
			$rider_id = FALSE;
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
		if (!empty($this->input->get('team'))) {
			$team = $this->input->get('team');
		} else {
			$team = FALSE;
		}
		if (!empty($this->input->get('vehicle_type'))) {
			$vehicle_type = $this->input->get('vehicle_type');
		} else {
			$vehicle_type = FALSE;
		}
		if (!empty($this->input->get('deliveries_less_than'))) {
			$deliveries_less_than = $this->input->get('deliveries_less_than');
		} else {
			$deliveries_less_than = FALSE;
		}
		$row_count = $this->import->daily_performance_row_count(
			$keyword,
			$rider_id,
			$vehicle_type,
			$start_date,
			$end_date,
			$team,
			$deliveries_less_than
		);

		if ($row_count > 1000) {
			$this->session->set_userdata('info', "2--Too much data to generate PDF ({$row_count} rows). Please narrow your filters (date, team, rider).");
			redirect('admin/logistic-management/hunger/list');
			exit;
		}
		$data['reports'] = $this->import->daily_performance($keyword, $rider_id, $vehicle_type, $start_date, $end_date, $team, $deliveries_less_than);
		if ($team) {
			$team_name = $this->db->select('name')->from('hunger_team')->where('id', $team)->get()->row()->name;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($team_name, true) . '</pre>';exit();
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['team_name'] = $team_name;
		$data['search_start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['search_end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Daily Performance Report');
		$pdf->SetSubject('Daily Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Daily Performance Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/hunger/print/hunger_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print/hunger_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('P', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-management/hunger/print/print_hunger_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($start_date && $end_date) {
			$pdf->Output('BS-Hunger-Station-Report-From ' . $data['search_start_date'] . ' To ' . $data['search_end_date'] . '.pdf', 'I');
		} else {
			$pdf->Output('BS-Hunger-Station-All-Report.pdf', 'I');
		}
	}

	public function print_daily_performance2()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_hunger_report_landscape');
		// Fetch form inputs
		$keyword = $this->input->get('filter_keyword') ? $this->input->get('filter_keyword') : FALSE;
		$rider_id = $this->input->get('filter_rider_id') ? $this->input->get('filter_rider_id') : FALSE;
		$month_of = $this->input->get('month_of', TRUE) ?? 'Aug 2024';
		$team = $this->input->get('team') ? $this->input->get('team') : FALSE;
		$vehicle_type = $this->input->get('vehicle_type') ? $this->input->get('vehicle_type') : FALSE;
		// Decode and validate month_of
		$month_of = urldecode($month_of);
		// Fetch data from model
		try {
			$data['reports'] = $this->import->daily_performance2($keyword, $rider_id, $vehicle_type, $month_of, $team);
		} catch (Exception $e) {
			log_message('error', 'Error fetching performance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}

		// Get team name
		if ($team) {
			$team_name_query = $this->db->select('name')->from('hunger_team')->where('id', $team)->get();
			$team_name = $team_name_query->row() ? $team_name_query->row()->name : '';
		} else {
			$team_name = '';
		}

		// Prepare data for the PDF
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['team_name'] = $team_name ? htmlspecialchars($team_name) : 'ALL';
		$data['search_month'] = $month_of ? htmlspecialchars($month_of) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		// Create PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Daily Performance Report');
		$pdf->SetSubject('Daily Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Daily Performance Report');

		// Remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/hunger/print/hunger_daily_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print/hunger_daily_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// Set default monospaced font and margins
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// Language-dependent strings
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// Add a page and set font
		$pdf->AddPage('L', 'A3');
		$pdf->setRTL(false);
		$pdf->SetFont('aealarabiya', '', 10);
		// Load and write content
		$htmlcontent = $this->load->view('admin/logistic-management/hunger/print/print_hunger_report2', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		// Output PDF
		$filename = $month_of
			? 'BS-Hunger-Station-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-Hunger-Station-All-Report.pdf';
		$pdf->Output($filename, 'I');
	}

	public function print_monthly_performance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_hunger_report_landscape');
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('rider_id'))) {
			$rider_id = $this->input->get('rider_id');
		} else {
			$rider_id = FALSE;
		}
		if (!empty($this->input->get('vehicle_type'))) {
			$vehicle_type = $this->input->get('vehicle_type');
		} else {
			$vehicle_type = FALSE;
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
		if (!empty($this->input->get('team'))) {
			$team = $this->input->get('team');
		} else {
			$team = FALSE;
		}
		$row_count = $this->import->monthly_performance_row_count(
			$keyword,
			$rider_id,
			$vehicle_type,
			$start_date,
			$end_date,
			$team
		);

		if ($row_count > 1000) {
			$this->session->set_userdata('info', "2--Too much data to generate PDF ({$row_count} rows). Please narrow your filters (date, team, rider).");
			redirect('admin/logistic-management/hunger/list');
			exit;
		}
		$data['reports'] = $this->import->monthly_performance($keyword, $rider_id, $vehicle_type, $start_date, $end_date, $team);
		if ($team) {
			$team_name = $query = $this->db->query("SELECT `name`, `ar_name` FROM `hunger_team`")->row()->name;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($data['reports'], true) . '</pre>';exit();
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['team_name'] = $team_name;
		$data['search_start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['search_end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Performance Report');
		$pdf->SetSubject('Monthly Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Performance Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/hunger/print/hunger_monthly_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print/hunger_monthly_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
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
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-management/hunger/print/hunger_monthly_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($start_date && $end_date) {
			$pdf->Output('BS-Hunger-Station-Report-From ' . $data['search_start_date'] . '.pdf', 'I');
		} else {
			$pdf->Output('BS-Hunger-Station-Monthly-Report.pdf', 'I');
		}
	}
	
	public function print_monthly_revenue()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_hunger_report_landscape');
		if (!empty($this->input->get('month_of'))) {
			$month_of = $this->input->get('month_of');
		} else {
			$month_of = FALSE;
		}
		if (!empty($this->input->get('vehicle_type'))) {
			$vehicle_type = $this->input->get('vehicle_type');
		} else {
			$vehicle_type = FALSE;
		}
		if (!empty($this->input->get('employer'))) {
			$employer = $this->input->get('employer');
		} else {
			$employer = FALSE;
		}
		$data['reports'] = $this->import->monthly_revenue($month_of, $vehicle_type, $employer);
		//echo '<pre>' . print_r($data['reports'], true) . '</pre>';exit();
		$data['search_vehicle_type'] = ($vehicle_type) ? $vehicle_type : '';
		$data['search_employer'] = ($employer) ? $this->db->query("SELECT employer_name FROM sponsors WHERE id = " . (int)$employer)->row()->employer_name : '';
		$data['search_month_of'] = ($month_of) ? date("M Y", strtotime($month_of)) : '';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Performance Report');
		$pdf->SetSubject('Monthly Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Performance Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/hunger/print/hunger_revenue_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print/hunger_revenue_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
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
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-management/hunger/print/hunger_monthly_revenue_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($month_of) {
			$pdf->Output('Hunger Revenue Report-From ' . $data['search_month_of'] . '.pdf', 'I');
		} else {
			$pdf->Output('Hunger Monthly Revenue Report.pdf', 'I');
		}
	}
	/*
	public function get_report(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('rider_id'))){
			$rider_id = $this->input->get('rider_id');
		}
		else{
			$rider_id = FALSE;
		}
		if(!empty($this->input->get('start_date'))){
			$start_date = $this->input->get('start_date');
		}
		else{
			$start_date = FALSE;
		}
		if(!empty($this->input->get('end_date'))){
			$end_date = $this->input->get('end_date');
		}
		else{
			$end_date = FALSE;
		}
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['search_start_date'] = $start_date;
		$data['search_end_date'] = $end_date;
		$data['reports'] = $this->import->get_summary($keyword,$rider_id,$start_date,$end_date);
		//echo '<pre>';print_r($data);exit();
		$this->load->view("admin/employed_riders/delivery-summary/hunger_report", $data);
	}
	
	public function get_daywise_report(){
		if(!empty($this->input->get('start_date'))){
			$start_date = $this->input->get('start_date');
		}
		else{
			$start_date = FALSE;
		}
		if(!empty($this->input->get('end_date'))){
			$end_date = $this->input->get('end_date');
		}
		else{
			$end_date = FALSE;
		}
		$data['search_start_date'] = $start_date;
		$data['search_end_date'] = $end_date;
		$data['reports'] = $this->import->get_daywise_summary($start_date,$end_date);
		//echo '<pre>';print_r($data);exit();
		$this->load->view("admin/employed_riders/delivery-summary/hunger_daywise_report", $data);
	}
	
	public function get_userwise_report()
    {
		$this->form_validation->set_rules('rider_id', 'Ider ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'. $msg .'</strong></div>';exit();
		}
		else{
            $rider_id = $this->input->post('rider_id');
			if(!empty($this->input->post('start_date'))){
				$start_date = $this->input->post('start_date');
			}
			else{
				$start_date = FALSE;
			}
			if(!empty($this->input->post('end_date'))){
				$end_date = $this->input->post('end_date');
			}
			else{
				$end_date = FALSE;
			}
			$data['search_start_date'] = $start_date;
			$data['search_end_date'] = $end_date;
			$data['user_info'] = $this->db->query("SELECT er.emp_id, er.hunger_platform_id, me.full_name, me.mobile FROM employed_riders er LEFT JOIN master_employee me ON (er.emp_id = me.id) WHERE er.hunger_platform_id = '". $rider_id ."'")->row_array();
			$data['reports'] = $this->import->get_userwise_summary($rider_id,$start_date,$end_date);
			$output_data = $this->load->view('admin/employed_riders/delivery-summary/user-wise-summary',$data,TRUE);
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
    }
	*/
	public function print_report()
	{
		$this->load->library('Pdf_mobile_consolidate_report');
		$id = $this->input->get('id');
		// $order = $this->Mobile_invoices->get_detail($id);
		// print_r($order);exit();
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('rider_id'))) {
			$rider_id = $this->input->get('rider_id');
		} else {
			$rider_id = FALSE;
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
		$data['reports'] = $this->import->get_list($keyword, $rider_id, $start_date, $end_date);
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['search_start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['search_end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_mobile_consolidate_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Hunger Station Report');
		$pdf->SetSubject('BS - Hunger Station Report');
		$pdf->SetKeywords('Baqala Station, PDF, Hunger Station Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/employed_riders/delivery-summary/print/hunger_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/employed_riders/delivery-summary/print/hunger_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/employed_riders/delivery-summary/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(4, 60, 8, true);

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
		$pdf->AddPage('P', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-management/hunger/print/print_hunger_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($start_date && $end_date) {
			$pdf->Output('BS-Hunger-Station-Report-From ' . date('d M Y', strtotime($startDate)) . ' To ' . date('d M Y', strtotime($endDate)) . '.pdf', 'I');
		} else {
			$pdf->Output('BS-Hunger-Station-All-Report.pdf', 'I');
		}
	}

	public function weekly_report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_hunger_report2');
		if (!empty($this->input->get('filter_keyword'))) {
			$keyword = $this->input->get('filter_keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('filter_rider_id'))) {
			$rider_id = $this->input->get('filter_rider_id');
		} else {
			$rider_id = FALSE;
		}
		if (!empty($this->input->get('team'))) {
			$team = $this->input->get('team');
		} else {
			$team = FALSE;
		}
		if (!empty($this->input->get('employer'))) {
			$employer_id = $this->input->get('employer');
		} else {
			$employer_id = FALSE;
		}
		$week_date = $this->input->get('week_date');
		if (!$week_date) {
			$week_date = date('Y-m-d'); // fallback to today
		}
		//dd($employer_id);
		$date_range = $this->get_start_and_end_date($week_date);
		try {
			// Get the weekly deliveries report data for the selected week
			$data['weekly_report'] = $this->import->get_weekly_deliveries_report($keyword, $rider_id, $team, $date_range['start_date'], $date_range['end_date'], $employer_id);
			//dd($data['weekly_report']);
			$data['search_keyword'] = $keyword;
			$data['search_rider_id'] = $rider_id;
			$data['employer_name'] = ($employer_id) ? $this->db->where('id', $employer_id)->get('sponsors')->row()->employer_name : NULL;
			$data['search_start_date'] = ($date_range['start_date']) ? date("d M Y", strtotime($date_range['start_date'])) : 'NA';
			$data['search_end_date'] = ($date_range['end_date']) ? date("d M Y", strtotime($date_range['end_date'])) : 'NA';
			$data['admin'] = 'Amanullah Kazi';

			if ($team) {
				$team_name = $this->db->select('name')->from('hunger_team')->where('id', $team)->get()->row()->name;
			} else {
				$team_name = '';
			}
			$data['team_name'] = $team_name;
			// create new PDF document
			$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Hunger Station Weekly Report');
			$pdf->SetSubject('BS - Hunger Station Weekly Report');
			$pdf->SetKeywords('Baqala Station, PDF, Hunger Station Weekly Report');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/logistic-management/hunger/print/hunger_weekly_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print/hunger_weekly_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/employed_riders/delivery-summary/print/footer', $data, true);
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(4, 30, 8, true);

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
			$pdf->AddPage('P', 'A4');
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			$htmlcontent = $this->load->view('admin/logistic-management/hunger/print/print_hunger_weekly_report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			if ($week_date) {
				$pdf->Output('BS-Hunger-Station-Weekly-Report-From ' . date('d M Y', strtotime($data['search_start_date'])) . ' To ' . date('d M Y', strtotime($data['search_end_date'])) . '.pdf', 'I');
			} else {
				$pdf->Output('BS-Hunger-Station-Weekly-Report.pdf', 'I');
			}
			// Pass the selected week back to the view for the filter
			//$data['selected_week'] = $week;

			// Load the view and pass the data
			//$this->load->view('admin/logistic-management/hunger/weekly_report', $data);
		} catch (Exception $e) {
			// Handle exceptions (e.g., invalid week format)
			echo "Error: " . $e->getMessage();
		}
	}

	public function get_start_and_end_date($date)
	{
		$date = new DateTime($date);
		$dayOfWeek = $date->format('w'); // 0 (Sunday) - 6 (Saturday)

		// Get Sunday of the week
		$sunday = clone $date;
		$sunday->modify("-{$dayOfWeek} days");

		// Get Saturday of the week
		$saturday = clone $sunday;
		$saturday->modify('+6 days');

		return [
			'start_date' => $sunday->format('Y-m-d'),
			'end_date' => $saturday->format('Y-m-d')
		];
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->import->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/hunger/list');
	}
	
	public function delete_by_date()
	{
		$date = $this->input->post('date');
		if (!$date) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => false, 'message' => 'Date is required']));
		}
		$deleted = $this->import->delete_by_date($date);
		if ($deleted) {
			$response = ['status' => true, 'message' => 'Records deleted successfully'];
		} else {
			$response = ['status' => false, 'message' => 'No records deleted or invalid date'];
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
}
