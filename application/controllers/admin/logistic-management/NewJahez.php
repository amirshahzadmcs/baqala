<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class NewJahez extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/jahez/Jahez_model', 'jahez_model');
		$this->load->helper('common_helper');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();

	}
	/**
	 * List Page for Jahez Daily Summary
	 */
	public function list_page()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}

		$data['search'] = '';
		$data['perPage'] = 50;

		// ✅ Load user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'jahez_order_summary'
		])->row();

		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view("admin/logistic-management/new_jahez/jahez_index", $data);
	}

	public function get_list()
	{
		$search = $this->input->post('search') ?? $this->input->post('keyword') ?? '';
		$perPage = $this->input->post('length') ?? 50;
		$start = $this->input->post('start') ?? 0;

		$date_from = $this->input->post('date_from') ?? null;
		$date_to = $this->input->post('date_to') ?? null;
		$driver_id = $this->input->post('driver_id') ?? null;
		$vehicle_type = $this->input->post('vehicle_type') ?? null;
		$vehicle_no = $this->input->post('vehicle_no') ?? null;
		$team = $this->input->post('team') ?? null;

		$fetch_data = $this->jahez_model->list($search, $perPage, $start, $date_from, $date_to, $driver_id, $vehicle_type, $vehicle_no, $team);

		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $item) {
			$sub_array = [];
			if (isset($item['id'])) {
				$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $item['id'] . '" />';
			}else{
				$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="" />';
			}
			$sub_array[] = $i++;

			foreach ($fetch_data['visible_columns'] as $column) {
				if ($column == 'id') continue; // ✅ Skip rendering ID in table rows

				$value = $item[$column] ?? '';

				if ($column == 'full_name') {
					$sub_array[] = '<div class="text-start">' . htmlspecialchars($value) . '</div>';
				} elseif (in_array($column, ['order_date', 'summary_date', 'settled_on', 'created_at', 'updated_at']) && !empty($value)) {
					$sub_array[] = date('d-m-Y', strtotime($value));
				} elseif (is_numeric($value) && (
					strpos($column, 'amount') !== false ||
					strpos($column, 'price') !== false ||
					strpos($column, 'collection') !== false ||
					strpos($column, 'credit') !== false ||
					strpos($column, 'debit') !== false ||
					strpos($column, 'bonus') !== false ||
					strpos($column, 'tip') !== false ||
					strpos($column, 'penalty') !== false)) {
					$sub_array[] = number_format($value, 2);
				} else {
					$sub_array[] = htmlspecialchars($value);
				}
			}

			$data[] = $sub_array;
		}

		$output = [
			"draw" => intval($this->input->post("draw")),
			"recordsTotal" => $fetch_data['pagination']['total'],
			"recordsFiltered" => $fetch_data['pagination']['total'],
			"data" => $data,
			"search" => $search,
			"perPage" => $perPage,
			"current_page" => $fetch_data['pagination']['current_page']
		];

		echo json_encode($output);
	}

	/*----- Bulk Import Hunger -----*/
	public function import_file() {
		$path = 'uploads/imports/jahez/';
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

			// Remove header
			array_shift($sheet_data);

			$this->db->trans_start();

			$batch_data = [];
			$duplicate_rows = [];

			foreach ($sheet_data as $val) {
				// Skip if Driver ID or Date is empty
				if (!empty($val[0]) && !empty($val[1])) {

					$order_date = $this->input->post('order_date'); // Column B
					$driver_id = trim($val[0]); // Column A

					// Check for duplicates
					$isDuplicate = $this->jahez_model->get([
						"driver_id" => $driver_id,
						"order_date" => $order_date
					]);

					if (!$isDuplicate) {
						// Get emp_id, vehicle_id, team_id using driver_id
						$this->db->select('
							logistic_rider.employee_id, 
							master_vehicles.id as vehicle_id,
							(
								SELECT ht.id
								FROM hunger_team ht
								WHERE ht.team REGEXP CONCAT(\'"\', logistic_rider.employee_id, \'"\')
								ORDER BY ht.id ASC
								LIMIT 1
							) as team_id
						', false);
						$this->db->from('logistic_rider');
						$this->db->join('master_vehicles', 'master_vehicles.alloted_user = logistic_rider.employee_id', 'left');
						$this->db->where('logistic_rider.id_number', $driver_id);
						$rider_info = $this->db->get()->row();

						$emp_id = $rider_info->employee_id ?? 0;
						$vehicle_id = $rider_info->vehicle_id ?? 0;
						$team_id = $rider_info->team_id ?? 0;

						$batch_data[] = [
							'emp_id'            => $emp_id,
							'order_date'        => $order_date,
							'driver_id'         => $val[0],   
							'summary_date'      => date('Y-m-d H:i:s', strtotime($val[1])),   
							'delivery_price'    => abs((float) $val[2]),   
							'cash_collection'   => abs((float) $val[3]),  
							'driver_credit'     => abs((float) $val[4]),    
							'driver_debit'      => abs((float) $val[5]),     
							'bonuses'           => abs((float) $val[6]),          
							'tips'              => abs((float) $val[7]),             
							'penalty'           => abs((float) $val[8]),          
							'service_deduction' => abs((float) $val[9]),
							'total_amount'      => abs((float) $val[10]),    
							'settled_amount'    => abs((float) $val[11]),  
							'unsettled_amount'  => abs((float) $val[12]),
							'settled_on'        => (!empty($val[13]) ? date('Y-m-d', strtotime($val[13])) : null),
							'orders'            => $val[14],
							'alloted_vehicle_id'=> $vehicle_id,
							'alloted_team_id'   => $team_id,
							'ip_address'        => $this->ip_address,
							'added_by'          => $this->admin->getLoginEmpId(),
							'created_at'        => $this->datetime,
						];
					} else {
						$duplicate_rows[] = $val;
					}
				}

				// Insert in batches
				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = [];
				}
			}

			if (!empty($batch_data)) {
				$this->insertBatchData($batch_data);
			}

			$this->db->trans_complete();

			if (file_exists($file_name)) {
				unlink($file_name);
			}

			if (!empty($duplicate_rows)) {
				$json = [
					'error_message' => count($duplicate_rows) . ' duplicate row(s) found. <span class="text-success">Rest all inserted</span>',
					'duplicate_rows' => $duplicate_rows
				];
			} else {
				$json = [
					'success_message' => 'All entries have been imported successfully.',
				];
			}
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$json = [
				'error_message' => $e->getMessage()
			];
		}

		echo json_encode($json);
		exit();
	}

	private function getReaderByExtension($extension) {
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
	
	private function insertBatchData($batch_data) {
		$result = $this->db->insert_batch('maha_jahez_daily_summary', $batch_data);
	
		if (!$result) {
			$json = [
				'error_message' => 'Something went wrong. Please try again.',
			];
			echo json_encode($json);
			exit();
		}
	}
	
	public function upload_config($path) {
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

	/*----- Bulk Import Jahez End -----*/
	/**
	 * Delete selected records
	 */
	public function delete(){
		$ids = $this->input->post('checklist');
		if (!is_array($ids) || empty($ids)) {
			$this->session->set_userdata('info', "2--No valid items selected or ID column is hidden.");
			redirect('admin/logistic-management/new-jahez/list');
		}
		$query = $this->jahez_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/new-jahez/list');
	}

	public function delete_by_date()
	{
		$date = $this->input->post('date');
		if (!$date) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => false, 'message' => 'Date is required']));
		}
		$deleted = $this->jahez_model->delete_by_date($date);
		if ($deleted) {
			$response = ['status' => true, 'message' => 'Records deleted successfully'];
		} else {
			$response = ['status' => false, 'message' => 'No records deleted or invalid date'];
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
	
	public function print_modal_form($modal_name){
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		if($modal_name == 'daily_performance'){
			$data['filter_title'] = "Daily Performance Report";
			$this->load->view('admin/logistic-management/new_jahez/components/daily_filter_modal', $data);
		}
		else if($modal_name == 'daywise'){
			$data['filter_title'] = "Day Wise Report";
			$this->load->view('admin/logistic-management/new_jahez/components/daywise_filter_modal', $data);
		}
		else if($modal_name == 'weekly'){
			$data['filter_title'] = "Weekly Report";
			$this->load->view('admin/logistic-management/new_jahez/components/weekly_filter_modal', $data);
		}
		else if($modal_name == 'monthly'){
			$data['filter_title'] = "Monthly Report";
			$this->load->view('admin/logistic-management/new_jahez/components/monthly_filter_modal', $data);
		}
		else if($modal_name == 'revenue'){
			$data['filter_title'] = "Monthly Revenue Report";
			$this->load->view('admin/logistic-management/new_jahez/components/revenue_filter_modal', $data);
		}
		else if($modal_name == 'cash_summary'){
			$data['filter_title'] = "Cash Summary Report";
			$this->load->view('admin/logistic-management/new_jahez/components/cash_summary_filter_modal', $data);
		}
    }
	/*
	public function print_monthly_performance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		ini_set('memory_limit', '512M');
		set_time_limit(300);
		$this->form_validation->set_rules('column_type', 'Column Type', 'required');
		$this->form_validation->set_rules('file_format', 'Format Type', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$this->load->library('Pdf_hunger_report2');
		$search = $this->input->post('searched_value');
		$start_date = $this->input->post('date_from');
		$end_date = $this->input->post('date_to');
		$column_type = $this->input->post('column_type');
		$file_format = $this->input->post('file_format');

		$data['report_data'] = $this->jahez_model->printPerformanceReportJahez($search, $column_type, $file_format, $start_date, $end_date);
		$data['start_date'] = $start_date ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['end_date'] = $end_date ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['searched'] = $search ?: '';
		$data['admin'] = 'Amanullah Kazi';
		dd($data['report_data']);
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Jahez Daily Performance Report');
		$pdf->SetSubject('Jahez Daily Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Jahez Daily Performance Report');

		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader);

		$lastFooter = $this->load->view('admin/logistic-management/new_jahez/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		$pdf->SetMargins(4, 10, 4, true);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage('L', 'A4');
		$pdf->setRTL(false);
		$pdf->Ln();
		$pdf->SetFont('helvetica', '', 8);

		$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		$filename = 'BS-Jahez-Daily-Report';
		if (!empty($start_date) && !empty($end_date)) {
			$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
		}
		$filename .= '.pdf';

		$pdf->Output($filename, 'I');
		echo json_encode(["type" => 'success', "message" => 'Report successfully exported.']);
	}

	public function export_order_data()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'jahez_daily_performance', 'print_monthly_performance')) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('column_type', 'Column Type', 'required');
		$this->form_validation->set_rules('file_format', 'Format Type', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$column_type = $this->input->post('column_type');
		$file_format = $this->input->post('file_format');
		$search = $this->input->post('searched_value');
		$start_date = $this->input->post('date_from');
		$end_date = $this->input->post('date_to');

		$reportData = $this->jahez_model->printPerformanceReportJahez($search, $column_type, $file_format, $start_date, $end_date);
		$data['start_date'] = $start_date ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['end_date'] = $end_date ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['searched'] = $search ?: '';

		if (empty($reportData['data'])) {
			echo json_encode(["type" => 'error', "message" => 'No data found']);
			return;
		}

		$filename = "Jahez-Daily-Summary";
		if (!empty($start_date) && !empty($end_date)) {
			$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
		}
		$filename .= '.xlsx';

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:Z1');
		$sheet->setCellValue('A1', 'Jahez Daily Summary');
		$sheet->getStyle('A1')->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		]);

		$headerRow = 3;
		$colIndex = 2;
		$sheet->setCellValue('A' . $headerRow, '#');

		foreach ($reportData['available_columns'] as $column) {
			$cleanedHeader = strtoupper(str_replace(['jos.', 'me.'], '', $column));
			$excelCol = Coordinate::stringFromColumnIndex($colIndex);
			$sheet->setCellValue($excelCol . $headerRow, str_replace('_', ' ', $cleanedHeader));
			$colIndex++;
		}

		$lastHeaderCol = Coordinate::stringFromColumnIndex($colIndex - 1);
		$sheet->getStyle("A{$headerRow}:{$lastHeaderCol}{$headerRow}")->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFF5D880']
			]
		]);

		$rowIndex = $headerRow + 1;
		$serialNumber = 1;

		foreach ($reportData['data'] as $detail) {
			$sheet->setCellValue("A" . $rowIndex, $serialNumber++);
			$colIndex = 2;
			foreach ($reportData['available_columns'] as $column) {
				$cleanedColumn = strtolower(str_replace(['jos.', 'me.'], '', $column));
				$value = $detail[$cleanedColumn] ?? '[NA]';

				if (in_array($cleanedColumn, ['order_date', 'summary_date', 'settled_on', 'created_at', 'updated_at']) && !empty($value)) {
					$value = date("d-m-Y", strtotime($value));
				} elseif (is_numeric($value) && strpos($value, '.') !== false) {
					$value = number_format($value, 2);
				}
				$excelCol = Coordinate::stringFromColumnIndex($colIndex);
				$sheet->setCellValue($excelCol . $rowIndex, $value);
				$colIndex++;
			}
			$rowIndex++;
		}

		for ($i = 1; $i <= Coordinate::columnIndexFromString($lastHeaderCol); $i++) {
			$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
	*/

	public function get_start_and_end_date($date)
	{
		$date = new DateTime($date);
		$dayOfWeek = $date->format('w');

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
	
	public function print_daily_performance()
	{
		$this->load->library('Pdf_hunger_report');
		$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
		$date_from = $this->input->get('date_from') ?? false;
		$date_to = $this->input->get('date_to') ?? false;
		$driver_id = $this->input->get('driver_id') ?? false;
		$vehicle_type = $this->input->get('vehicle_type') ?? false;
		$vehicle_no = $this->input->get('vehicle_no') ?? false;
		$team = $this->input->get('team') ?? false;
		$data['reports'] = $this->jahez_model->daily_performance($search, $date_from, $date_to, $driver_id, $vehicle_type, $vehicle_no, $team);
		//dd($data);
		if ($team) {
			$team_name = $team;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($team_name, true) . '</pre>';exit();
		$data['search_keyword'] = $search;
		$data['vehicle_type'] = $vehicle_type;
		$data['vehicle_no'] = $vehicle_no;
		$data['team_name'] = $team_name;
		$data['search_start_date'] = ($date_from) ? date("d M Y", strtotime($date_from)) : 'NA';
		$data['search_end_date'] = ($date_to) ? date("d M Y", strtotime($date_to)) : 'NA';
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
		$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/print_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/new_jahez/print/print_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/new_jahez/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/print_summary_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($date_from && $date_to) {
			$pdf->Output('BS-Jahez-Report-From ' . $data['search_start_date'] . ' To ' . $data['search_end_date'] . '.pdf', 'I');
		} else {
			$pdf->Output('BS-Jahez-All-Report.pdf', 'I');
		}
	}

	public function print_daywise_report()
	{
		$this->load->library('Pdf_hunger_report_landscape');
		// Fetch form inputs
		$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
		$month_of = $this->input->get('month_of', TRUE) ?? date('M Y');
		$driver_id = $this->input->get('driver_id') ?? false;
		$vehicle_type = $this->input->get('vehicle_type') ?? false;
		$vehicle_no = $this->input->get('vehicle_no') ?? false;
		$team = $this->input->get('team') ?? false;

		// Decode and validate month_of
		$month_of = urldecode($month_of);
		// Fetch data from model
		try {
			$data['reports'] = $this->jahez_model->daywise_performance($search, $month_of, $driver_id, $vehicle_type, $vehicle_no, $team);
		} catch (Exception $e) {
			log_message('error', 'Error fetching performance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}
		//dd($data['reports']);
		// Get team name
		if ($team) {
			$team_name_query = $this->db->select('name')->from('hunger_team')->where('name', $team)->get();
			$team_name = $team_name_query->row() ? $team_name_query->row()->name : '';
		} else {
			$team_name = '';
		}

		// Prepare data for the PDF
		$data['search_keyword'] = $search;
		$data['vehicle_type'] = $vehicle_type;
		$data['vehicle_no'] = $vehicle_no;
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
		$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/jahez_daywise_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/new_jahez/print/jahez_daywise_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/new_jahez/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/jahez_daywise_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		// Output PDF
		$filename = $month_of
			? 'BS-Jahez-Daywise-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-Jahez-Daywise-Report.pdf';
		$pdf->Output($filename, 'I');
	}

	public function print_weekly_report()
	{
		$this->load->library('Pdf_hunger_report2');
		$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
		$week_date = $this->input->get('week_date', TRUE) ?? date('Y-m-d');
		$employer_id = $this->input->get('employer') ?? false;
		$vehicle_type = $this->input->get('vehicle_type') ?? false;
		$vehicle_no = $this->input->get('vehicle_no') ?? false;
		$team = $this->input->get('team') ?? false;
		//dd($employer_id);
		$date_range = $this->get_start_and_end_date($week_date);
		try {
			// Get the weekly deliveries report data for the selected week
			$data['weekly_report'] = $this->jahez_model->get_weekly_deliveries_report($search, $vehicle_type, $vehicle_no, $team, $employer_id, $date_range['start_date'], $date_range['end_date']);
			//dd($data['weekly_report']);
			$data['search_keyword'] = $search;
			$data['employer_name'] = ($employer_id) ? $this->db->where('id', $employer_id)->get('sponsors')->row()->employer_name : NULL;
			$data['search_start_date'] = ($date_range['start_date']) ? date("d M Y", strtotime($date_range['start_date'])) : 'NA';
			$data['search_end_date'] = ($date_range['end_date']) ? date("d M Y", strtotime($date_range['end_date'])) : 'NA';
			$data['admin'] = 'Amanullah Kazi';

			if ($team) {
				$team_name = $team;
			} else {
				$team_name = '';
			}
			$data['team_name'] = $team_name;
			// create new PDF document
			$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Jahez Weekly Report');
			$pdf->SetSubject('BS - Jahez Weekly Report');
			$pdf->SetKeywords('Baqala Station, PDF, Jahez Weekly Report');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/jahez_weekly_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/logistic-management/new_jahez/print/jahez_weekly_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/employed_riders/delivery-summary/print/footer', $data, true);
			$pdf->setHtmlFooter($lastFooter);
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

			$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/print_jahez_weekly_report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			if ($week_date) {
				$pdf->Output('BS-Jahez-Weekly-Report-From ' . date('d M Y', strtotime($data['search_start_date'])) . ' To ' . date('d M Y', strtotime($data['search_end_date'])) . '.pdf', 'I');
			} else {
				$pdf->Output('BS-Jahez-Weekly-Report.pdf', 'I');
			}
		} catch (Exception $e) {
			// Handle exceptions (e.g., invalid week format)
			echo "Error: " . $e->getMessage();
		}
	}
	
	public function print_monthly_performance()
	{
		$this->load->library('Pdf_hunger_report_landscape');
		$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
		$month_of = $this->input->get('month_of', TRUE) ?? date('M Y');
		$employer_id = $this->input->get('employer') ?? false;
		$vehicle_type = $this->input->get('vehicle_type') ?? false;
		$vehicle_no = $this->input->get('vehicle_no') ?? false;
		$team = $this->input->get('team') ?? false;
		$data['reports'] = $this->jahez_model->monthly_performance($search, $month_of, $employer_id, $vehicle_type, $vehicle_no, $team);
		//dd($data['reports']);
		if ($team) {
			$team_name = $query = $this->db->query("SELECT `name`, `ar_name` FROM `hunger_team`")->row()->name;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($data['reports'], true) . '</pre>';exit();
		$data['search_keyword'] = $search;
		$data['employer_name'] = ($employer_id) ? $this->db->where('id', $employer_id)->get('sponsors')->row()->employer_name : NULL;
		$data['team_name'] = $team_name;
		$data['search_month'] = $month_of ? htmlspecialchars($month_of) : 'NA';
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
		$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/jahez_monthly_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/new_jahez/print/jahez_monthly_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/new_jahez/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/jahez_monthly_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$filename = $month_of
			? 'BS-Jahez-Monthly-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-Jahez-Monthly-Report.pdf';
		$pdf->Output($filename, 'I');
	}
	
	public function print_monthly_revenue()
	{
		$this->load->library('Pdf_hunger_report_landscape');
		$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
		$month_of = $this->input->get('month_of', TRUE) ?? date('M Y');
		$employer_id = $this->input->get('employer') ?? false;
		$vehicle_type = $this->input->get('vehicle_type') ?? false;
		$vehicle_no = $this->input->get('vehicle_no') ?? false;
		$team = $this->input->get('team') ?? false;
		$data['reports'] = $this->jahez_model->monthly_revenue($search, $month_of, $employer_id, $vehicle_type, $vehicle_no, $team);
		//dd($data['reports']);
		if ($team) {
			$team_name = $query = $this->db->query("SELECT `name`, `ar_name` FROM `hunger_team`")->row()->name;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($data['reports'], true) . '</pre>';exit();
		$data['search_keyword'] = $search;
		$data['employer_name'] = ($employer_id) ? $this->db->where('id', $employer_id)->get('sponsors')->row()->employer_name : NULL;
		$data['team_name'] = $team_name;
		$data['search_month'] = $month_of ? htmlspecialchars($month_of) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Revenue Report');
		$pdf->SetSubject('Monthly Revenue Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Revenue Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/jahez_revenue_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/new_jahez/print/jahez_revenue_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/new_jahez/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/jahez_revenue_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$filename = $month_of
			? 'BS-Jahez-Monthly-Revenue-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-Jahez-Monthly-Revenue-Report.pdf';
		$pdf->Output($filename, 'I');
	}
	
	public function print_cash_report()
	{
		$this->load->library('Pdf_hunger_report2');
		$search = $this->input->get('search') ?? $this->input->get('keyword') ?? false;
		$date_from = $this->input->get('date_from') ?? false;
		$date_to = $this->input->get('date_to') ?? false;
		$driver_id = $this->input->get('driver_id') ?? false;
		$vehicle_type = $this->input->get('vehicle_type') ?? false;
		$vehicle_no = $this->input->get('vehicle_no') ?? false;
		$team = $this->input->get('team') ?? false;
		$data['reports'] = $this->jahez_model->jahez_cod_debit_report($search, $date_from, $date_to, $driver_id, $vehicle_type, $vehicle_no, $team);
		//dd($data);
		if ($team) {
			$team_name = $team;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($team_name, true) . '</pre>';exit();
		$data['search_keyword'] = $search;
		$data['vehicle_type'] = $vehicle_type;
		$data['vehicle_no'] = $vehicle_no;
		$data['team_name'] = $team_name;
		$data['search_start_date'] = ($date_from) ? date("d M Y", strtotime($date_from)) : 'NA';
		$data['search_end_date'] = ($date_to) ? date("d M Y", strtotime($date_to)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Cash Summary Report');
		$pdf->SetSubject('Cash Summary Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Cash Summary Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/new_jahez/print/print_cash_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/new_jahez/print/print_cash_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/new_jahez/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/new_jahez/print/print_cash_summary_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($date_from && $date_to) {
			$pdf->Output('BS-Jahez-Cash-Report-' . $data['search_start_date'] . ' To ' . $data['search_end_date'] . '.pdf', 'I');
		} else {
			$pdf->Output('BS-Jahez-All-Cash-Report.pdf', 'I');
		}
	}
}
