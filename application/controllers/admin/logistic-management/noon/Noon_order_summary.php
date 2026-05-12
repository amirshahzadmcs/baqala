<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Noon_order_summary extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/noon/Daily_summary_model', 'noon_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'noon_daily_performance', $this->action)) {
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
		//$data['hunger_summary'] = $this->noon_model->getSummary();
		// Default values for search and pagination
		$data['search'] = '';
		$data['perPage'] = 50;
		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'noon_order_summary'
		])->row();
		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		$this->load->view("admin/logistic-management/noon/index", $data);
	}

	public function ajax_list()
	{
		$search = $this->input->post('search') ?? $this->input->post('keyword') ?? '';
		$perPage = $this->input->post('length') ?? 50;
		$start = $this->input->post('start') ?? 0;

		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');

		$fetch_data = $this->noon_model->list($search, $perPage, $start, $date_from, $date_to);

		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $item) {
			$sub_array = [];
			//$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $item['id'] . '" />';
			$sub_array[] = $i++;

			foreach ($fetch_data['visible_columns'] as $column) {
				$value = $item[$column] ?? '';
				if ($column == 'full_name') {
					$sub_array[] = '<div class="text-start">' . htmlspecialchars($value) . '</div>';
				} elseif (in_array($column, ['local_date', 'date', 'created_at', 'updated_at', 'last_order_date']) && !empty($value)) {
					$sub_array[] = date('d-m-Y', strtotime($value));
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
	private function getRiderEmpIdForDay($id_number, $summary_date)
	{
		$id_number = $this->db->escape_str($id_number);
		$emp_id = 0;

		// Step 1: Get last allot log before or on the given date
		$this->db->select('log_detail, created_at');
		$this->db->where('log_type', 'allot');
		$this->db->where('status_type', 'id_allot');
		$this->db->where("JSON_UNQUOTE(JSON_EXTRACT(log_detail, '$.id_number')) = '{$id_number}'", null, false);
		$this->db->where('created_at <=', $summary_date . ' 23:59:59');
		$this->db->order_by('created_at', 'DESC');
		$this->db->limit(1);
		$allot_log = $this->db->get('logistic_rider_log')->row();

		if ($allot_log) {
			$log_detail = json_decode($allot_log->log_detail, true);
			$allot_emp_id = $log_detail['employee_id'] ?? 0;
			$allot_date = $allot_log->created_at;

			// Step 2: Check for unallot log after allot and before/equal to summary_date
			$this->db->select('created_at');
			$this->db->where('log_type', 'unallot');
			$this->db->where('status_type', 'id_unallot');
			$this->db->where("JSON_UNQUOTE(JSON_EXTRACT(log_detail, '$.id_number')) = '{$id_number}'", null, false);
			$this->db->where('created_at >=', $allot_date);
			$this->db->where('created_at <=', $summary_date . ' 23:59:59');
			$this->db->order_by('created_at', 'ASC');
			$this->db->limit(1);
			$unallot_log = $this->db->get('logistic_rider_log')->row();

			if (!$unallot_log) {
				$emp_id = $allot_emp_id; // Still allotted
			}
		}

		// Optional fallback
		if ($emp_id == 0) {
			$this->db->select('employee_id');
			$this->db->where('id_number', $id_number);
			$rider_info = $this->db->get('logistic_rider')->row();
			$emp_id = $rider_info->employee_id ?? 0;
		}

		return $emp_id;
	}

	public function import_file()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'noon_daily_performance', $this->action)) {
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
			$addedBy = $this->admin->getLoginEmpId();

			foreach ($sheet_data as $val) {
				//dd($val); // Debugging line, remove in production
				if ($val[1] != '') {
					$date_local = date('Y-m-d', strtotime($this->input->post('summary_date')));
					if ($date_local == '') {
						$json = [
							'error_message' => 'Invalid date format'
						];
						echo json_encode($json);
						exit();
					}
					//dd($date_local);
					$isDuplicate = $this->noon_model->checkDuplicateInBulk([
						"rider_id" => $val[1],
						"date_local" => $date_local,
					]);

					//print_r($isDuplicate);exit();
					if (!$isDuplicate) {

						$id_number = $this->db->escape_str($val[1]);
						// Get emp_id from logistic_rider by matching id_number with rider_id from Excel
						$emp_id = $this->getRiderEmpIdForDay($id_number, $date_local);
						$vehicle_id = $this->db->get_where('master_vehicles', ['alloted_user' => $emp_id])->row()->id ?? 0;
						$team_id = $this->db->select('id')->where("team REGEXP", '"'.$emp_id.'"')->order_by('id', 'ASC')->limit(1)->get('hunger_team')->row()->id ?? 0;
						$date = date('Y-m-d', strtotime(str_replace('/', '-', $val[0])));
						$last_order_date = date('Y-m-d', strtotime(str_replace('/', '-', $val[18])));

						$login_hrs = is_numeric(trim($val[9])) ? floatval(trim($val[9])) : 0;
						$ontime = is_numeric(trim($val[13])) ? floatval(trim($val[13])) : 0;
						$delivery_rating = is_numeric(trim($val[17])) ? floatval(trim($val[17])) : null;

						$batch_data[] = [
							"local_date" => $date_local,
							"emp_id" => $emp_id,
							"date" => $date,
							"da_id" => $val[1],
							"payout_mot" => $val[2],
							"fleet_zone" => trim($val[3]),
							"da_mtd_score" => rtrim($val[4], '%'),
							"da_mtd_rank" => $val[5],
							"calendar_days_mtd" => $val[6],
							"present_days_mtd" => $val[7],
							"da_shift" => trim($val[8]),
							"login_hrs" => $login_hrs,
							"rejections" => intval($val[10]),
							"unassignments" => intval($val[11]),
							"delivered_orders" => intval($val[12]),
							"ontime" => $ontime,
							"fm_distance" => floatval($val[14]),
							"lm_distance" => floatval($val[15]),
							"in_shift_login_hrs" => floatval($val[16]),
							"delivery_rating" => $delivery_rating,
							"last_order_date" => $last_order_date,
							"not_working_since_days" => intval($val[19] ?? 0),
							"added_by" => $addedBy,
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
		$result = $this->db->insert_batch('noon_order_summary', $batch_data);

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

	//End of Bulk Import

	public function print_monthly_performance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'noon_daily_performance', $this->action)) {
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

		$data['report_data'] = $this->noon_model->printPerformanceReport($search, $column_type, $file_format, $start_date, $end_date);
		$data['start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['searched'] = $search ? $search : '';
		//echo '<pre>' . print_r($this->input->post(), true) . '</pre>';exit();
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Noon Daily Performance Report');
		$pdf->SetSubject('Noon Daily Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Noon Daily Performance Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/noon/print/header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/noon/print/header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/noon/print/footer', $data, true);
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
		$pdf->SetMargins(4, 10, 4, true);

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
		$pdf->SetFont('helvetica', '', 8);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-management/noon/print/report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		// Output PDF with date in filename if filter is used
		$filename = 'BS-Noon-Daily-Report';
		if (!empty($start_date) && !empty($end_date)) {
			$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
		}
		$filename .= '.pdf';

		$pdf->Output($filename, 'I');
		echo json_encode(["type" => 'success', "message" => 'Report successfully exported.']);
	}

	public function export_order_data()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'noon_daily_performance', 'print_monthly_performance')) {
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

		$reportData = $this->noon_model->printPerformanceReport($search, $column_type, $file_format, $start_date, $end_date);
		$data['start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['searched'] = $search ? $search : '';
		//dd($reportData); // Debugging line, remove in production
		if (empty($reportData['data'])) {
			echo json_encode(["type" => 'error', "message" => 'No data found']);
			return;
		}

		$filename = "Noon-Daily-Summary";
		if (!empty($start_date) && !empty($end_date)) {
			$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
		}
		$filename .= '.xlsx';
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Report Title
		$sheet->mergeCells('A1:Z1');
		$sheet->setCellValue('A1', 'Noon Daily Summary');
		$sheet->getStyle('A1')->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		]);

		// Column Headers
		$headerRow = 3;
		$colIndex = 2; // Start from column 2 (B) since A is for serial number
		$sheet->setCellValue('A' . $headerRow, '#');

		foreach ($reportData['available_columns'] as $column) {
			$cleanedHeader = strtoupper(str_replace(['noon.', 'me.'], '', $column));
			$excelCol = Coordinate::stringFromColumnIndex($colIndex);
			$sheet->setCellValue($excelCol . $headerRow, str_replace('_', ' ', $cleanedHeader));
			$colIndex++;
		}

		// Apply Header Styling
		$lastHeaderCol = Coordinate::stringFromColumnIndex($colIndex - 1);
		$sheet->getStyle("A{$headerRow}:{$lastHeaderCol}{$headerRow}")->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFF5D880']
			]
		]);

		// Data Rows
		$rowIndex = $headerRow + 1;
		$serialNumber = 1;

		foreach ($reportData['data'] as $detail) {
			$sheet->setCellValue("A" . $rowIndex, $serialNumber++);
			$colIndex = 2; // Start from B

			foreach ($reportData['available_columns'] as $column) {
				$cleanedColumn = strtolower(str_replace(['noon.', 'me.'], '', $column));
				$value = $detail[$cleanedColumn] ?? '[NA]';

				// Format date fields
				if (in_array($cleanedColumn, ['local_date', 'date', 'created_at', 'updated_at', 'last_order_date']) && !empty($value)) {
					$value = date("d-m-Y", strtotime($value));
				}
				// Format decimals
				elseif (is_numeric($value) && strpos($value, '.') !== false) {
					$value = number_format($value, 2);
				}

				$excelCol = Coordinate::stringFromColumnIndex($colIndex);
				$sheet->setCellValue($excelCol . $rowIndex, $value);
				$colIndex++;
			}
			$rowIndex++;
		}

		// Auto-size columns
		$lastDataColIndex = Coordinate::columnIndexFromString($lastHeaderCol);
		for ($i = 1; $i <= $lastDataColIndex; $i++) {
			$colLetter = Coordinate::stringFromColumnIndex($i);
			$sheet->getColumnDimension($colLetter)->setAutoSize(true);
		}

		// Output Excel File
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function get_start_and_end_date($week)
	{
		// Extract year and week number from the week parameter
		list($year, $week) = explode('-W', $week);

		// Calculate the start date of the week
		$start_date = new DateTime();
		$start_date->setISODate($year, $week, 1); // 1 represents Monday

		// Calculate the end date of the week
		$end_date = new DateTime();
		$end_date->setISODate($year, $week, 7); // 7 represents Sunday

		// Return the start and end date in YYYY-MM-DD format
		return [
			'start_date' => $start_date->format('Y-m-d'),
			'end_date' => $end_date->format('Y-m-d')
		];
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->noon_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/noon/list');
	}
}
