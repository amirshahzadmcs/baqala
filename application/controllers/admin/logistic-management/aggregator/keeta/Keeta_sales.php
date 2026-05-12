<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Keeta_sales extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/aggregators/keeta/Keeta_sales_model', 'keeta_sales_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if (!check_action_permission(get_user_role(), 'keeta_sales_data', $this->action)) {
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
		$data['keeta_summary'] = $this->keeta_sales_model->getSummary();
		$this->load->view("admin/logistic-management/aggregators/keeta_sales/index", $data);
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
		if (!check_action_permission(get_user_role(), 'keeta_sales_data', $this->action)) {
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
			$expected_columns = 22;
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
			$userId = $this->admin->getLoginEmpId();
			// Start transaction
			$this->db->trans_start();

			// Check duplicates in bulk
			$existing_records = $this->keeta_sales_model->checkDuplicateInBulk($summary_date);
			if (!empty($existing_records)) {
				$json = [
					'error_message' => 'Already added sales data for this month. Try another month!',
				];
			} else {
				$data = array(
					'summary_month' => $summary_date,
					'from_date' => $summary_date,
					'to_date' => $last_date_of_month,
					'status' => 1,
					'added_by' => $userId,
					'created_at' => $this->datetime,
					'updated_at' => $this->datetime,
				);
				$this->db->insert('maha_keeta_sales_data', $data);
				$insert_id = $this->db->insert_id();

				$batch_data = [];
				foreach ($sheet_data as $val) {
					$id_number = $this->db->escape_str($val[3]);
					$emp_id = $this->getRiderEmpIdForMonth($id_number, $summary_date, $last_date_of_month);
					//dd($val);
					if (!empty($val[0])) { // Replace with necessary column checks
						$batch_data[] = [
							"main_id" => $insert_id,
							"emp_id" => $emp_id,
							"partner_id" => $val[0],
							"partner_name" => $val[1],
							"billing_cycle" => $val[2],
							"courier_id" => $val[3],
							"courier_name" => $val[4],
							"is_valid" => $val[5],
							"reason" => $val[6],
							"online_days_valid" => $val[7],
							"daily_online_hours_valid" => $val[8],
							"daily_online_hours_peak_valid" => $val[9],
							"delivered_orders" => $val[10],
							"order_based_pricing" => $val[11],
							"valid_da_capacity_incentives" => $val[12],
							"on_time_incentives" => $val[13],
							"subsidy" => $val[14],
							"activities_rewards" => $val[15],
							"deduction" => $val[16],
							"food_compensation" => $val[17],
							"other_adjustment" => $val[18],
							"tips_vat_excluded" => $val[19],
							"tga_deduction_vat_excluded" => $val[20],
							"total_payable_amount" => is_numeric($clean_value = str_replace([',', ' '], '', trim($val[21]))) ? (float) $clean_value : 0.00,
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
		$result = $this->db->insert_batch('maha_keeta_sales_summary', $batch_data);

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

	public function detail($id)
	{
		if (!check_action_permission(get_user_role(), 'keeta_sales_data', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$isAjax = $this->input->is_ajax_request();
		$search = $this->input->get('search') ?? '';
		$page = max(1, (int) $this->input->get('page'));
		$perPage = (int) ($this->input->get('per_page') ?? 50);

		if ($id) {
			$this->load->library('pagination');

			$config['base_url'] = base_url("admin/logistic-management/invoices/keeta-sales/detail/$id");
			$config['suffix'] = "&search=" . urlencode($search) . "&per_page=" . $perPage;
			$config['first_url'] = $config['base_url'] . '?page=1' . $config['suffix'];
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['total_rows'] = $this->keeta_sales_model->summaryDetailCount($id, $search);
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
			$summaryData = $this->keeta_sales_model->get_detail($id);
			$summaryDetails = $this->keeta_sales_model->summaryDetail($id, $search, $perPage, $page);
			//dd($summaryDetails);

			if ($isAjax) {
				$html = $this->load->view('admin/logistic-management/aggregators/keeta_sales/components/summary-data', ['summaryDetails' => $summaryDetails['data'], 'start' => $data['start'], 'availableTableColumns' => $summaryDetails['visible_columns'], 'visibleTableColumns' => $summaryDetails['visible_columns']], TRUE);
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
			$this->load->view('admin/logistic-management/aggregators/keeta_sales/detail', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/logistic-management/invoices/keeta-sales/list');
		}
	}

	public function print_sales_data()
	{
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
		$data['report'] = $this->keeta_sales_model->get_detail($id);
		$data['report_data'] = $this->keeta_sales_model->printSalesReport($id, $search, $column_type, $file_format);
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
		$pdf->SetTitle('Keeta Monthly Sales Report -' . $data['month_of']);
		$pdf->SetSubject('Keeta Monthly Sales Report -' . $data['month_of']);
		$pdf->SetKeywords('Maha Al Fala, PDF, Keeta Monthly Sales Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/aggregators/keeta_sales/print/header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/aggregators/keeta_sales/print/header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/aggregators/keeta_sales/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/aggregators/keeta_sales/print/report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS-Keeta-Station-Sales-Report-' . $data['month_of'] . '.pdf', 'I');
		echo json_encode(["type" => 'error', "message" => 'Report successfully exported.']);
	}

	public function export_sales_data()
	{
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
		$data['report'] = $this->keeta_sales_model->get_detail($id);
		$data['report_data'] = $this->keeta_sales_model->printSalesReport($id, $search, $column_type, $file_format);
		$report_data = $data['report_data']['data'];

		$data['month_of'] = ($data['report']['summary_month']) ? date("F Y", strtotime($data['report']['summary_month'])) : 'NA';
		$data['start_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['end_date'] = ($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		$filename = "Keeta-Sales-Report-" . $data['month_of'] . ".xlsx";

		// Calculate Summary Data
		$uniqueRiders = [];
		$completedDeliveries = 0;
		$totalPaybleAmount = 0;

		foreach ($report_data as $detail) {
			if (!empty($detail['emp_no'])) {
				$uniqueRiders[$detail['emp_no']] = true;
			}
			$completedDeliveries += (int) ($detail['delivered_orders'] ?? 0);
			$totalPaybleAmount += (int) ($detail['total_payable_amount'] ?? 0);
		}

		$nosRiders = count($uniqueRiders);
		$averagePerRider = $nosRiders > 0 ? round($completedDeliveries / $nosRiders, 2) : 0;

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
		$sheet->setCellValue('A1', 'Keeta Monthly Sales Report - ' . $data['month_of']);

		// Set Summary Header
		$sheet->setCellValue('A2', "No's Riders")->setCellValue('B2', $nosRiders);
		$sheet->setCellValue('C2', "Total Completed Orders")->setCellValue('D2', $completedDeliveries);
		$sheet->setCellValue('E2', "Average Per Rider")->setCellValue('F2', $averagePerRider);
		$sheet->setCellValue('G2', "Total Payble Amount")->setCellValue('H2', $totalPaybleAmount);

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
			$cleanedHeader = strtoupper(str_replace(['mkss.', 'me.'], '', $column));
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
				$cleanedColumn = strtolower(str_replace(['mkss.', 'me.'], '', $column));
				$value = $detail[$cleanedColumn] ?? '[NA]';

				// Format numbers with decimal places
				$cellValue = (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : ' ' . $value;
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
		if (!check_action_permission(get_user_role(), 'keeta_sales_data', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->import->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/invoices/keeta-sales/list');
	}
}
