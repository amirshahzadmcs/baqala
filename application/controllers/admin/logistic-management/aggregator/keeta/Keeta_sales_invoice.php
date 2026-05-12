<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Keeta_sales_invoice extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/aggregators/keeta/Keeta_sales_invoice_model', 'keeta_invoice_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if (!check_action_permission(get_user_role(), 'keeta_sales_invoice', $this->action)) {
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
		//$data['hunger_summary'] = $this->keeta_invoice_model->getSummary();
		// ✅ Fetch User Preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'keeta_sales_invoice'
		])->row();
		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		$this->load->view("admin/logistic-management/aggregators/keeta_invoice/index", $data);
	}

	public function ajax_list()
	{
		$search = $this->input->post('search') ?? '';
		$perPage = $this->input->post('length') ?? 50;
		$start = $this->input->post('start') ?? 0;

		$fetch_data = $this->keeta_invoice_model->salesList($search, $perPage, $start);

		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $item) {
			$sub_array = [];
			//$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $item['id'] . '" />';
			$sub_array[] = $i++;

			foreach ($fetch_data['visible_columns'] as $column) {
				// ✅ Format date columns (if they exist)
				if ($column == 'invoice_month' && !empty($item[$column])) {
					$sub_array[] = date('M Y', strtotime($item[$column]));
				} elseif (in_array($column, ['from_date', 'to_date']) && !empty($item[$column])) {
					$sub_array[] = date('d-m-Y', strtotime($item[$column]));
				} else {
					$sub_array[] = $item[$column] ?? '';
				}
			}
			$data[] = $sub_array;
		}

		$output = [
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $fetch_data['pagination']['total'],
			"recordsFiltered" => $fetch_data['pagination']['total'],
			"data" => $data
		];

		echo json_encode($output);
	}


	/*----- Bulk Import Hunger -----*/
	public function import_file()
	{
		if (!check_action_permission(get_user_role(), 'keeta_sales_invoice', $this->action)) {
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

			// Validate the number of columns (expected 16 columns)
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
			$existing_records = $this->keeta_invoice_model->checkDuplicateInBulk($summary_date);
			if (!empty($existing_records)) {
				$json = [
					'error_message' => 'Already added sales data for this month. Try another month!',
				];
			} else {
				$batch_data = [];
				foreach ($sheet_data as $val) {
					if (!empty($val[0])) {
						$batch_data[] = [
							"invoice_month" => $summary_date,
							"from_date" => $summary_date,
							"to_date" => $last_date_of_month,
							"partner_id" => $val[0],
							"partner_name" => $val[1],
							"billing_cycle" => $val[2],
							"order_based_pricing" => $val[3],
							"valid_da_capacity_incentives" => $val[4],
							"on_time_incentives" => $val[5],
							"subsidy" => $val[6],
							"activities_other_rewards" => $val[7],
							"deduction" => $val[8],
							"food_compensation" => $val[9],
							"other_adjustment" => $val[10],
							"tax_amount" => $val[11],
							"tips_vat_excluded" => $val[12],
							"tga_deduction_vat_excluded" => $val[13],
							"invoice_amount" => is_numeric($clean_value = preg_replace('/[^\d.-]/', '', str_replace(' ', '', trim($val[14])))) ? (float) $clean_value : 0.00,
							"total_payable_amount" => is_numeric($clean_value = preg_replace('/[^\d.-]/', '', str_replace(' ', '', trim($val[15])))) ? (float) $clean_value : 0.00,
							'added_by' => $userId,
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
		$result = $this->db->insert_batch('maha_keeta_sales_invoice', $batch_data);

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

	public function print_sales_data()
	{
		if (!check_action_permission(get_user_role(), 'keeta_sales_invoice', $this->action)) {
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
		$column_type = $this->input->post('column_type');
		$search = $this->input->post('searched_value');
		$file_format = $this->input->post('file_format');
		$data['report_data'] = $this->keeta_invoice_model->printSalesReport($column_type, $file_format, $search);
		//echo '<pre>' . print_r($data, true) . '</pre>';exit();
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Keeta Monthly Sales Invoice -' . $data['month_of']);
		$pdf->SetSubject('Keeta Monthly Sales Invoice -' . $data['month_of']);
		$pdf->SetKeywords('Maha Al Fala, PDF, Keeta Monthly Sales Invoice');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/aggregators/keeta_invoice/print/header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/aggregators/keeta_invoice/print/header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/aggregators/keeta_invoice/print/footer', $data, true);
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
		$htmlcontent = $this->load->view('admin/logistic-management/aggregators/keeta_invoice/print/report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS-Keeta-Sales-Invoice.pdf', 'I');
		echo json_encode(["type" => 'error', "message" => 'Report successfully exported.']);
	}
	public function export_sales_data()
	{
		if (!check_action_permission(get_user_role(), 'keeta_sales_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('column_type', 'Column Type', 'required');
		$this->form_validation->set_rules('file_format', 'Format Type', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$column_type = $this->input->post('column_type');
		$search = $this->input->post('searched_value');
		$file_format = $this->input->post('file_format');
		$reportData = $this->keeta_invoice_model->printSalesReport($column_type, $file_format, $search);

		if (empty($reportData['data'])) {
			echo json_encode(["type" => 'error', "message" => 'No sales data found']);
			return;
		}

		$filename = "Keeta-Sales-Invoice.xlsx";
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Report Title
		$sheet->mergeCells('A1:H1');
		$sheet->setCellValue('A1', 'Keeta Monthly Sales Invoice');
		$sheet->getStyle('A1')->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		]);

		// Column Headers
		$headerRow = 3;
		$colIndex = 'A';
		$sheet->setCellValue($colIndex++ . $headerRow, '#');

		foreach ($reportData['available_columns'] as $column) {
			$cleanedHeader = strtoupper(str_replace(['mkss.', 'me.'], '', $column));
			$sheet->setCellValue($colIndex . $headerRow, str_replace('_', ' ', $cleanedHeader));
			$colIndex++;
		}

		// Apply Header Styling
		$sheet->getStyle("A{$headerRow}:" . $colIndex . "{$headerRow}")->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF5D880']]
		]);

		// Data Rows
		$rowIndex = $headerRow + 1;
		$serialNumber = 1;

		foreach ($reportData['data'] as $detail) {
			$colIndex = 'A';
			$sheet->setCellValue($colIndex++ . $rowIndex, $serialNumber++);

			foreach ($reportData['available_columns'] as $column) {
				$cleanedColumn = strtolower(str_replace(['mkss.', 'me.'], '', $column));
				$value = $detail[$cleanedColumn] ?? '[NA]';

				// Format invoice_month (e.g., "Apr 2025")
				if ($cleanedColumn == 'invoice_month' && !empty($value)) {
					$value = date("M Y", strtotime($value));
				}
				// Format from_date & to_date (e.g., "01 Apr 2025")
				elseif (in_array($cleanedColumn, ['from_date', 'to_date']) && !empty($value)) {
					$value = date("d M Y", strtotime($value));
				}
				// Format numbers properly
				elseif (is_numeric($value) && strpos($value, '.') !== false) {
					$value = number_format($value, 2);
				}

				$sheet->setCellValue($colIndex . $rowIndex, $value);
				$colIndex++;
			}
			$rowIndex++;
		}

		// Auto-size Columns
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
		if (!check_action_permission(get_user_role(), 'keeta_sales_invoice', $this->action)) {
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
