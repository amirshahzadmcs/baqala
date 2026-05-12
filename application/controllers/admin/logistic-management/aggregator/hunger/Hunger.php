<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Hunger extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/aggregators/hunger/Hunger_model', 'hunger_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'monthly_performance', $this->action)) {
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
		$data['hunger_summary'] = $this->hunger_model->getHungerSummary();
		$this->load->view("admin/logistic-management/aggregators/hunger/index", $data);
	}

	/*----- Bulk Import Hunger -----*/
	private function getRiderEmpIdForMonth($id_number, $summary_date, $last_date_of_month)
	{
		$id_number = $this->db->escape_str($id_number);
		$emp_id = 0;

		// Step 1: Get all allot logs before or within the month
		$this->db->select('log_detail, created_at');
		$this->db->where('log_type', 'allot');
		$this->db->where('status_type', 'id_allot');
		$this->db->where("JSON_UNQUOTE(JSON_EXTRACT(log_detail, '$.id_number')) = '{$id_number}'", null, false);
		$this->db->where('created_at <=', $last_date_of_month);
		$this->db->order_by('created_at', 'DESC');
		$allot_logs = $this->db->get('logistic_rider_log')->result();

		foreach ($allot_logs as $allot_log) {
			$log_detail = json_decode($allot_log->log_detail, true);
			$allot_emp_id = $log_detail['employee_id'] ?? 0;
			$allot_date = $allot_log->created_at;

			// Step 2: Get unallot log (if any) after this allotment
			$this->db->select('created_at');
			$this->db->where('log_type', 'unallot');
			$this->db->where('status_type', 'id_unallot');
			$this->db->where("JSON_UNQUOTE(JSON_EXTRACT(log_detail, '$.id_number')) = '{$id_number}'", null, false);
			$this->db->where('created_at >=', $allot_date);
			$this->db->order_by('created_at', 'ASC');
			$this->db->limit(1);
			$unallot_log = $this->db->get('logistic_rider_log')->row();

			// Check if this allotment was active at any point in the summary month
			if ($unallot_log) {
				$unallot_date = $unallot_log->created_at;

				// Allotment must start before end of month AND unallot after summary starts
				if ($unallot_date >= $summary_date && $allot_date <= $last_date_of_month) {
					$emp_id = $allot_emp_id;
					break;
				}
			} else {
				// No unallot means still assigned — valid
				if ($allot_date <= $last_date_of_month) {
					$emp_id = $allot_emp_id;
					break;
				}
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
		if ($this->action && !check_action_permission(get_user_role(), 'monthly_performance', $this->action)) {
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

			// Read and clean data
			$sheet_data = [];
			foreach ($spreadsheet->getActiveSheet()->getRowIterator() as $row) {
				$rowData = [];
				foreach ($row->getCellIterator() as $cell) {
					$rowData[] = $cell->getCalculatedValue(); // Get calculated value
				}
				$sheet_data[] = array_map(function ($value) {
					return is_string($value) ? trim($value) : $value; // Clean strings
				}, $rowData);
			}

			// Validate the number of columns (expected 49 columns)
			$expected_columns = 25;
			foreach ($sheet_data as $row) {
				if (count($row) < $expected_columns) {
					throw new Exception("Invalid file format: Each row must have $expected_columns columns.");
				}
			}

			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);

			// Parse salary date
			$summary_date = date('Y-m-d', strtotime($this->input->post('summary_month')));
			$last_date_of_month = date('Y-m-t', strtotime($summary_date));

			// Start transaction
			$this->db->trans_start();

			// Check duplicates in bulk
			$existing_records = $this->hunger_model->checkDuplicateInBulk($summary_date);
			if (!empty($existing_records)) {
				$json = [
					'error_message' => 'Already added summary of this month. Try another month!',
				];
			} else {
				$data = array(
					'summary_month' => $summary_date,
					'from_date' => $summary_date,
					'to_date' => $last_date_of_month,
					'status' => 1,
					'created_at' => $this->datetime,
					'updated_at' => $this->datetime,
				);
				$this->db->insert('maha_hunger_monthly', $data);
				$insert_id = $this->db->insert_id();

				$batch_data = [];
				foreach ($sheet_data as $val) {
					// Step 1: Get latest rider log before or on summary_date
					$id_number = $this->db->escape_str($val[0]);
					/*
					$this->db->select('log_detail, created_at');
					$this->db->where('log_type', 'allot');
					$this->db->where('status_type', 'id_allot');
					$this->db->where("JSON_UNQUOTE(JSON_EXTRACT(log_detail, '$.id_number')) = '{$id_number}'", null, false);
					$this->db->where('created_at <=', $last_date_of_month); // Include logs before or in the month
					$this->db->order_by('created_at', 'DESC');
					$this->db->limit(1);
					$rider_log = $this->db->get('logistic_rider_log')->row();

					if ($rider_log) {
						$log_detail = json_decode($rider_log->log_detail, true);
						$emp_id = $log_detail['employee_id'] ?? 0;
					} else {
						// Fallback if no log found
						$this->db->select('employee_id');
						$this->db->where('id_number', $val[0]);
						$rider_info = $this->db->get('logistic_rider')->row();
						$emp_id = $rider_info ? $rider_info->employee_id : 0;
					}
					*/
					$emp_id = $this->getRiderEmpIdForMonth($id_number, $summary_date, $last_date_of_month);
					//dd($val);
					if (!empty($val[1])) { // Replace with necessary column checks
						$batch_data[] = [
							"main_id" => $insert_id,
							"emp_id" => $emp_id,
							"rider_id" => $val[0],
							"city_name" => $val[1],
							"contract_name" => $val[2],
							"vehicle_name" => $val[3],
							"batch_number" => $val[4],
							"tga_status" => $val[5],
							"error_codes" => $val[6],
							"shifts" => $val[7],
							"working_days" => $val[8],
							"planned_working_hours" => $val[9],
							"actual_working_hours" => $val[10],
							"avg_working_hours" => $val[11],
							"attendance_rate" => $val[12],
							"break_hours" => $val[13],
							"lost_hours" => $val[14],
							"acceptance_rate" => $val[15],
							"contact_rate" => $val[16],
							"no_shows" => $val[17],
							"no_shows_percent" => $val[18],
							"notified_deliveries" => $val[19],
							"completed_deliveries" => $val[20],
							"accepted_deliveries" => $val[21],
							"not_accepted_deliveries" => $val[22],
							"stacked_deliveries" => $val[23],
							"declined_deliveries" => $val[24],
							"cancelled_deliveries" => $val[25],
							"created_at" => $this->datetime,
							"updated_at" => $this->datetime,
						];

						if (count($batch_data) >= 100) {
							$this->insertBatchData($batch_data);
							$batch_data = [];
						}
					}
				}

				// Insert remaining data
				if (!empty($batch_data)) {
					$this->insertBatchData($batch_data);
				}

				// Commit transaction
				$this->db->trans_complete();

				// Delete the file
				if (file_exists($file_name)) {
					unlink($file_name);
				}

				// Prepare response
				$json = [
					'success_message' => 'All Entries are imported successfully.',
				];
			}
		} catch (Exception $e) {
			// Rollback transaction if error occurs
			$this->db->trans_rollback();
			$json = [
				'error_message' => $e->getMessage(),
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
		$result = $this->db->insert_batch('maha_hunger_monthly_summary', $batch_data);

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
	/*
	public function detail($id)
	{
		if ($id) {
			$summaryData = $this->hunger_model->get_detail($id);
			$summaryDetails = $this->hunger_model->summaryDetail($id);
			$data = [
				'summaryData' => $summaryData,
				'summaryDetails' => $summaryDetails
			];
			//dd($data);
			$this->load->view('admin/logistic-management/aggregators/hunger/detail', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/logistic-management/invoices/hunger/list');
		}
	}*/
	public function detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'monthly_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$isAjax = $this->input->is_ajax_request();
		$search = $this->input->get('search') ?? '';
		$page = max(1, (int) $this->input->get('page'));
		$perPage = (int) ($this->input->get('per_page') ?? 50);

		if ($id) {
			$this->load->library('pagination');

			$config['base_url'] = base_url("admin/logistic-management/invoices/hunger/detail/$id");
			$config['suffix'] = "&search=" . urlencode($search) . "&per_page=" . $perPage;
			$config['first_url'] = $config['base_url'] . '?page=1' . $config['suffix'];
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['total_rows'] = $this->hunger_model->summaryDetailCount($id, $search);
			$config['per_page'] = $perPage;
			$config['use_page_numbers'] = TRUE;

			$config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center mb-0">';
			$config['full_tag_close'] = '</ul></nav>';

			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0)" class="page-link">';
			$config['cur_tag_close'] = '</a></li>';

			// ✅ Disable 'Previous' link when on the first page
			if ($page <= 1) {
				$config['prev_link'] = '&laquo;';
				$config['prev_tag_open'] = '<li class="page-item disabled"><span class="page-link">';
				$config['prev_tag_close'] = '</span></li>';
			} else {
				$config['prev_link'] = '&laquo;';
				$config['prev_tag_open'] = '<li class="page-item">';
				$config['prev_tag_close'] = '</li>';
			}

			// ✅ Disable 'Next' link when on the last page
			$totalPages = ceil($config['total_rows'] / $config['per_page']);
			if ($page >= $totalPages) {
				$config['next_link'] = '&raquo;';
				$config['next_tag_open'] = '<li class="page-item disabled"><span class="page-link">';
				$config['next_tag_close'] = '</span></li>';
			} else {
				$config['next_link'] = '&raquo;';
				$config['next_tag_open'] = '<li class="page-item">';
				$config['next_tag_close'] = '</li>';
			}

			$config['attributes'] = ['class' => 'page-link'];


			$this->pagination->initialize($config);

			// ✅ Correct offset calculation to avoid negative values
			$offset = max(0, ($page - 1) * $perPage);
			$data['start'] = $offset + 1;
			$data['end'] = min($offset + $perPage, $config['total_rows']); // Avoids overflow
			$data['total'] = $config['total_rows'];
			$summaryData = $this->hunger_model->get_detail($id);
			$summaryDetails = $this->hunger_model->summaryDetail($id, $search, $perPage, $page);
			//dd($summaryDetails);

			if ($isAjax) {
				$html = $this->load->view('admin/logistic-management/aggregators/hunger/components/summary-data', ['summaryDetails' => $summaryDetails['data'], 'start' => $data['start'], 'availableTableColumns' => $summaryDetails['visible_columns'], 'visibleTableColumns' => $summaryDetails['visible_columns']], TRUE);
				echo json_encode([
					'html' => $html,
					'available_columns' => $summaryDetails['visible_columns'],
					'visibleTableColumns' => $summaryDetails['visible_columns'],
					'pagination_links' => $this->pagination->create_links(),
					'page_offset' => $offset,
					'start' => $data['start'],
					'end' => $data['end'],
					'total' => $data['total'],
				]);
				return;
			}

			$data = [
				'summaryData' => $summaryData,
				'summaryDetails' => $summaryDetails['data'],
				'availableTableColumns' => $summaryDetails['visible_columns'],
				'visibleTableColumns' => $summaryDetails['visible_columns'],
				'pagination_links' => $this->pagination->create_links(),
				'search' => $search,
				'perPage' => $perPage,
				'page_offset' => $offset
			];
			//dd($data);
			$this->load->view('admin/logistic-management/aggregators/hunger/detail', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/logistic-management/invoices/hunger/list');
		}
	}

	public function print_monthly_performance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'monthly_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		ini_set('memory_limit', '512M');
		set_time_limit(300);
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('column_type', 'Column Type', 'required');
		$this->form_validation->set_rules('file_format', 'Format Type', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$this->load->library('Pdf_hunger_report2');
		$id = $this->input->post('request_id');
		$search = $this->input->post('searched_value');
		$column_type = $this->input->post('column_type');
		$file_format = $this->input->post('file_format');
		$data['report'] = $this->hunger_model->get_detail($id);
		$data['report_data'] = $this->hunger_model->printPerformanceReport($id, $search, $column_type, $file_format);
		//echo '<pre>' . print_r($data, true) . '</pre>';exit();
		$data['month_of'] = ($data['report']['summary_month']) ? date("F Y", strtotime($data['report']['summary_month'])) : 'NA';
		$data['start_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['end_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Hunger Monthly Performance Report -' . $data['month_of']);
		$pdf->SetSubject('Hunger Monthly Performance Report -' . $data['month_of']);
		$pdf->SetKeywords('Maha Al Fala, PDF, Hunger Monthly Performance Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/aggregators/hunger/print/hunger_monthly_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/aggregators/hunger/print/hunger_monthly_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/aggregators/hunger/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/aggregators/hunger/print/hunger_monthly_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS-Hunger-Station-Report-' . $data['month_of'] . '.pdf', 'I');
		echo json_encode(["type" => 'error', "message" => 'Report successfully exported.']);
	}

	public function export_monthly_performance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'monthly_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('column_type', 'Column Type', 'required');
		$this->form_validation->set_rules('file_format', 'Format Type', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$id = $this->input->post('request_id');
		$search = $this->input->post('searched_value');
		$column_type = $this->input->post('column_type');
		$file_format = $this->input->post('file_format');
		$data['report'] = $this->hunger_model->get_detail($id);
		$data['report_data'] = $this->hunger_model->printPerformanceReport($id, $search, $column_type, $file_format);
		$report_data = $data['report_data']['data'];

		$data['month_of'] = ($data['report']['summary_month']) ? date("F Y", strtotime($data['report']['summary_month'])) : 'NA';
		$data['start_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['end_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		$filename = "Hunger-Performance-Report-" . $data['month_of'] . ".xlsx";

		// Calculate Summary Data
		$uniqueRiders = [];
		$totalDelivery = 0;
		$completedDeliveries = 0;

		foreach ($report_data as $detail) {
			if (!empty($detail['rider_id'])) {
				$uniqueRiders[$detail['rider_id']] = true;
			}
			$totalDelivery += (int) ($detail['notified_deliveries'] ?? 0);
			$completedDeliveries += (int) ($detail['completed_deliveries'] ?? 0);
		}

		$nosRiders = count($uniqueRiders);
		$averagePerRider = $nosRiders > 0 ? round($totalDelivery / $nosRiders, 2) : 0;

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Apply styles for summary
		$headerStyle = [
			'font' => ['bold' => true],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFC7CE']],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		];
		$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
		// Merge the first row for the company name and report title
		$sheet->mergeCells('A1:H1'); // Company name and report title in one row
		$sheet->setCellValue('A1', 'Hunger Monthly Delivery Report - ' . $data['month_of']);

		// Set Summary Header
		$sheet->setCellValue('A2', "No's Riders")->setCellValue('B2', $nosRiders);
		$sheet->setCellValue('C2', "Total Delivery")->setCellValue('D2', $totalDelivery);
		$sheet->setCellValue('E2', "Average Per Rider")->setCellValue('F2', $averagePerRider);
		$sheet->setCellValue('G2', "Completed Deliveries")->setCellValue('H2', $completedDeliveries);

		$headerStyle = [
			'font' => ['bold' => true],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD3D3D3']],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		];
		$sheet->getStyle('A2:H2')->applyFromArray($headerStyle);

		// Add Column Headers
		$colIndex = 'A';
		$sheet->setCellValue($colIndex++ . '3', '#');
		foreach ($data['report_data']['available_columns'] as $column) {
			$cleanedHeader = strtoupper(str_replace(['mhms.', 'me.'], '', $column));
			$sheet->setCellValue($colIndex . '3', str_replace('_', ' ', $cleanedHeader));
			$colIndex++;
		}

		// Apply Header Styling
		$sheet->getStyle('A3:' . $colIndex . '3')->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5D880']]
		]);

		// Add Data Rows
		$rowIndex = 4;
		$serialNumber = 1;
		foreach ($report_data as $detail) {
			$colIndex = 'A';
			$sheet->setCellValue($colIndex++ . $rowIndex, $serialNumber++);

			foreach ($data['report_data']['available_columns'] as $column) {
				$cleanedColumn = strtolower(str_replace(['mhms.', 'me.'], '', $column));
				$percentageColumns = ['avg_working_hours', 'attendance_rate', 'acceptance_rate', 'contact_rate', 'no_shows_percent'];
				$value = $detail[$cleanedColumn] ?? '[NA]';
				if (in_array($cleanedColumn, $percentageColumns) && is_numeric($value)) {
					$value = round($value * 100) . '%';
				}
				// Format numbers with decimal places
				$cellValue = (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : $value;
				$sheet->setCellValue($colIndex . $rowIndex, $cellValue);
				$colIndex++;
			}
			$rowIndex++;
		}

		// Auto-size columns
		foreach (range('A', $colIndex) as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

		// Output Excel File
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename={$filename}");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function export_raw_data($main_id)
	{
		$id = $main_id;
		$search = $this->input->get('search') ?? '';
		$data['report'] = $this->hunger_model->get_detail($id);
		$data['report_data'] = $this->hunger_model->printRawReport($id, $search);
		$report_data = $data['report_data']['data'];
		//dd($report_data);
		$data['month_of'] = ($data['report']['summary_month']) ? date("F Y", strtotime($data['report']['summary_month'])) : 'NA';
		$data['start_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['end_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		$filename = "Hunger-Monthly-Data-" . $data['month_of'] . ".xlsx";

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Apply styles for summary
		$headerStyle = [
			'font' => ['bold' => true],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFC7CE']],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		];
		$sheet->getStyle('A1:AE1')->applyFromArray($headerStyle);
		// Merge the first row for the company name and report title
		$sheet->mergeCells('A1:AE1'); // Company name and report title in one row
		$sheet->setCellValue('A1', 'Hunger Monthly Delivery Data - ' . $data['month_of']);

		// Add Column Headers
		$colIndex = 'A';
		$sheet->setCellValue($colIndex++ . '3', '#');
		foreach ($data['report_data']['available_columns'] as $column) {
			$cleanedHeader = strtoupper(str_replace(['mhms.', 'me.'], '', $column));
			$sheet->setCellValue($colIndex . '3', str_replace('_', ' ', $cleanedHeader));
			$colIndex++;
		}

		// Apply Header Styling
		$sheet->getStyle('A3:' . $colIndex . '3')->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5D880']]
		]);

		// Add Data Rows
		$rowIndex = 4;
		$serialNumber = 1;
		foreach ($report_data as $detail) {
			$colIndex = 'A';
			$sheet->setCellValue($colIndex++ . $rowIndex, $serialNumber++);

			foreach ($data['report_data']['available_columns'] as $column) {
				$cleanedColumn = strtolower(str_replace(['mhms.', 'me.'], '', $column));
				$percentageColumns = ['avg_working_hours', 'attendance_rate', 'acceptance_rate', 'contact_rate', 'no_shows_percent'];
				$value = $detail[$cleanedColumn] ?? '[NA]';
				if (in_array($cleanedColumn, $percentageColumns) && is_numeric($value)) {
					$value = round($value * 100) . '%';
				}
				// Format numbers with decimal places
				$cellValue = (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : $value;
				$sheet->setCellValue($colIndex . $rowIndex, $cellValue);
				$colIndex++;
			}
			$rowIndex++;
		}

		// Auto-size columns
		foreach (range('A', $colIndex) as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

		// Output Excel File
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename={$filename}");
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
		if ($this->action && !check_action_permission(get_user_role(), 'monthly_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->post('id');
		log_message('error', 'Delete ID received: ' . $id); // Log to check if ID is coming

		if (!$id) {
			http_response_code(400);
			echo json_encode(['status' => 'missing_id']);
			return;
		}
		if ($this->hunger_model->delete($id)) {
			echo json_encode(['status' => 'success']);
		} else {
			http_response_code(500);
			echo json_encode(['status' => 'error']);
		}
	}
}
