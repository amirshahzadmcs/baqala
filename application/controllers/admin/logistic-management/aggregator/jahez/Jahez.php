<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Jahez extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/aggregators/jahez/Jahez_model', 'jahez_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if (!check_action_permission(get_user_role(), 'jahez_monthly_performance', $this->action)) {
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
		$data['jahez_summary'] = $this->jahez_model->getSummary();
		$this->load->view("admin/logistic-management/aggregators/jahez/index", $data);
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
		if (!check_action_permission(get_user_role(), 'jahez_monthly_performance', $this->action)) {
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
			$expected_columns = 16;
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
			$existing_records = $this->jahez_model->checkDuplicateInBulk($summary_date);
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
					'added_by' => $userId,
					'created_at' => $this->datetime,
					'updated_at' => $this->datetime,
				);
				$this->db->insert('maha_jahez_monthly', $data);
				$insert_id = $this->db->insert_id();

				$batch_data = [];
				foreach ($sheet_data as $val) {
					$id_number = $this->db->escape_str($val[5]);
					$emp_id = $this->getRiderEmpIdForMonth($id_number, $summary_date, $last_date_of_month);
					//dd($val);
					if (!empty($val[3])) { // Replace with necessary column checks
						$batch_data[] = [
							"main_id" => $insert_id,
							"emp_id" => $emp_id,
							"did" => $val[1],
							"ref_id" => $val[2],
							"driver_name" => $val[3],
							"driver_username" => $val[4],
							"driver_id" => $val[5],
							"amount" => $val[6],
							"price" => $val[7],
							"driver_debit_amount" => $val[8],
							"driver_credit_amount" => $val[9],
							"is_free_order" => $val[10],
							"dispatch_time" => $formattedDate = date("Y-m-d H:i:s", strtotime($val[11])),
							"subscriber" => $val[12],
							"driver_paid_org" => $val[13],
							"org_settled" => $val[14],
							"driver_settled" => $val[15],
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
		$result = $this->db->insert_batch('maha_jahez_monthly_summary', $batch_data);

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

	public function detail($id)
	{
		if (!check_action_permission(get_user_role(), 'jahez_monthly_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$isAjax = $this->input->is_ajax_request();
		$search = $this->input->get('search') ?? '';
		$page = max(1, (int) $this->input->get('page'));
		$perPage = (int) ($this->input->get('per_page') ?? 50);

		if ($id) {
			$this->load->library('pagination');

			$config['base_url'] = base_url("admin/logistic-management/invoices/jahez/detail/$id");
			$config['suffix'] = "&search=" . urlencode($search) . "&per_page=" . $perPage;
			$config['first_url'] = $config['base_url'] . '?page=1' . $config['suffix'];
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$config['total_rows'] = $this->jahez_model->summaryDetailCount($id, $search);
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
			$summaryData = $this->jahez_model->get_detail($id);
			$summaryDetails = $this->jahez_model->summaryDetail($id, $search, $perPage, $page);
			//dd($summaryDetails);

			if ($isAjax) {
				$html = $this->load->view('admin/logistic-management/aggregators/jahez/components/summary-data', ['summaryDetails' => $summaryDetails['data'], 'start' => $data['start'], 'availableTableColumns' => $summaryDetails['visible_columns'], 'visibleTableColumns' => $summaryDetails['visible_columns']], TRUE);
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
			$this->load->view('admin/logistic-management/aggregators/jahez/detail', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/logistic-management/invoices/jahez/list');
		}
	}

	public function print_monthly_performance()
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

		$data['report'] = $this->jahez_model->get_detail($id);
		$totalRows = $this->jahez_model->countTotalRecords($id);
		$batchSize = 1000;
		$offset = 0;

		$data['month_of'] = !empty($data['report']['summary_month']) ? date("F Y", strtotime($data['report']['summary_month'])) : 'NA';
		$data['start_date'] = !empty($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['end_date'] = !empty($data['report']['to_date']) ? date("d M Y", strtotime($data['report']['to_date'])) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Jahez Monthly Performance Report - ' . $data['month_of']);
		$pdf->SetSubject('Jahez Monthly Performance Report - ' . $data['month_of']);
		$pdf->SetKeywords('Maha Al Fala, PDF, Jahez Monthly Performance Report');

		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/aggregators/jahez/print/jahez_monthly_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlFooter($this->load->view('admin/logistic-management/aggregators/jahez/print/footer', $data, true));

		$pdf->SetMargins(4, 10, 4, true);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->SetFont('helvetica', '', 7);

		while ($offset < $totalRows) {
			$batchData = $this->jahez_model->printPerformanceReport($id, $search, $column_type, $file_format, $batchSize, $offset);

			if (!empty($batchData['data'])) {
				$data['report_data'] = $batchData; // ✅ Correct: Pass batch data to view
				$htmlcontent = $this->load->view('admin/logistic-management/aggregators/jahez/print/jahez_monthly_report', $data, true);

				$pdf->AddPage('L', 'A4');
				$pdf->WriteHTML($htmlcontent, true, false, true, false, '');
			}

			$offset += $batchSize; // ✅ Move to next batch
		}

		$pdf->Output('BS-Jahez-Monthly-Report-' . $data['month_of'] . '.pdf', 'I');
		echo json_encode(["type" => 'success', "message" => 'Report successfully exported.']);
	}


	public function export_monthly_performance()
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

		// Fetch report details
		$data['report'] = $this->jahez_model->get_detail($id);
		$totalRecords = $this->jahez_model->countTotalRecords($id); // ✅ Get total count
		$batchSize = 1000; // Process in batches of 1000
		$offset = 0;

		$data['month_of'] = !empty($data['report']['summary_month']) ? date("F Y", strtotime($data['report']['summary_month'])) : 'NA';
		$data['start_date'] = !empty($data['report']['from_date']) ? date("d M Y", strtotime($data['report']['from_date'])) : 'NA';
		$data['end_date'] = !empty($data['report']['to_date']) ? date("d M Y", strtotime($data['report']['to_date'])) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		$filename = "Jahez-Performance-Report-" . $data['month_of'] . ".xlsx";

		// ✅ Initialize Excel
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Apply styles for summary
		$headerStyle = [
			'font' => ['bold' => true],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFC7CE']],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		];
		$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
		$sheet->mergeCells('A1:H1'); // Company name and report title in one row
		$sheet->setCellValue('A1', 'Jahez Monthly Delivery Report - ' . $data['month_of']);

		// Set Summary Header
		$sheet->setCellValue('A2', "Total Riders")->setCellValue('B2', 0);
		$sheet->setCellValue('C2', "Total Price")->setCellValue('D2', 0);
		$sheet->setCellValue('E2', "Total Orders")->setCellValue('F2', 0);

		// Column Headers
		$colIndex = 'A';
		$sheet->setCellValue($colIndex++ . '3', '#');

		// ✅ Fetch first batch to get available columns
		$batchData = $this->jahez_model->printPerformanceReport($id, $search, $column_type, $file_format, $batchSize, $offset);
		$availableColumns = $batchData['available_columns'];

		foreach ($availableColumns as $column) {
			$cleanedHeader = strtoupper(str_replace(['mjms.', 'me.'], '', $column));
			$sheet->setCellValue($colIndex . '3', str_replace('_', ' ', $cleanedHeader));
			$colIndex++;
		}

		$sheet->setCellValue($colIndex . '3', 'Total Orders');
		$orderColumnIndex = $colIndex; // Save this to auto-size later
		$colIndex++;


		// Apply Header Styling
		$sheet->getStyle('A3:' . $colIndex . '3')->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5D880']]
		]);

		// ✅ Process data in batches
		$rowIndex = 4;
		$serialNumber = 1;
		$uniqueRiders = [];
		$totalPrice = 0;
		$totalOrders = 0;

		while ($offset < $totalRecords) {
			$batchData = $this->jahez_model->printPerformanceReport($id, $search, $column_type, $file_format, $batchSize, $offset);

			foreach ($batchData['data'] as $detail) {
				$colIndex = 'A';
				$sheet->setCellValue($colIndex++ . $rowIndex, $serialNumber++);

				foreach ($availableColumns as $column) {
					$cleanedColumn = strtolower(str_replace(['mjms.', 'me.'], '', $column));
					$value = $detail[$cleanedColumn] ?? '[NA]';

					// Format numbers properly
					$cellValue = (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : ' ' . $value;
					$sheet->setCellValue($colIndex . $rowIndex, $cellValue);
					$colIndex++;
				}
				$sheet->setCellValue($colIndex . $rowIndex, (int) ($detail['order_count'] ?? 0));

				// ✅ Track total price & unique riders
				if (!empty($detail['emp_no'])) {
					$uniqueRiders[$detail['emp_no']] = true;
				}
				$totalPrice += (int) ($detail['price'] ?? 0);
				$totalOrders += (int) ($detail['order_count'] ?? 0);
				$rowIndex++;
			}

			$offset += $batchSize; // ✅ Move to next batch
		}

		// ✅ Update summary values
		$sheet->setCellValue('B2', count($uniqueRiders));
		$sheet->setCellValue('D2', $totalPrice);
		$sheet->setCellValue('F2', $totalOrders);

		// Auto-size columns
		foreach (range('A', $colIndex) as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}

		// ✅ Output Excel File
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename={$filename}");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->import->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/jahez/list');
	}
}
