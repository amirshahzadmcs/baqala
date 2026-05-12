<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Hunger_invoices extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/Hunger_invoice_model', 'invoice_model');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->load->library('phpqrcode/qrlib');
		$this->load->helper('barcode_helper');
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
			$data['riders'] = '';
		}
		$data['riders'] = $this->db->get('logistic_rider')->result();
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view("admin/logistic-management/hunger/invoices", $data);
	}

	/*----- Bulk Import Hunger -----*/
	public function import_file()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_invoice', $this->action)) {
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
			$sheet_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);

			// Initialize transaction
			$this->db->trans_start();
			$batch_data = [];
			$duplicate_rows = [];

			foreach ($sheet_data as $index => $val) {

				if ($val[1] != '') {
					$invoice_month_input = $this->input->post('invoice_month');
					$formated_month = new DateTime($invoice_month_input);
					$invoice_month = $formated_month->format('Y-m-d');
					$isDuplicate = $this->invoice_model->checkDuplicateInBulk([
						"invoice_month" => $invoice_month,
						"rider_id" => $val[0],
					]);
					if (!$isDuplicate) {
						$batch_data[] = [
							"rider_id" => $val[0],
							"contract_name" => $val[1],
							"orders" => str_replace(',', '', $val[2]),
							"TotalAmountSD" => str_replace(',', '', $val[3]),
							"StackingDeduction" => str_replace(',', '', $val[4]),
							"avg_rider_acceptance_rate" => str_replace(',', '', $val[5]),
							"acceptance_rate_deduction_amt" => str_replace(',', '', $val[6]),
							"rider_contact_rate" => str_replace(',', '', $val[7]),
							"rider_contact_rate_amt" => str_replace(',', '', $val[8]),
							"TotalAmountWSD" => str_replace(',', '', $val[9]),
							"VAT" => str_replace(',', '', $val[10]),
							"AmountIncVAT" => str_replace(',', '', $val[11]),
							"CourierBasicPayment" => str_replace(',', '', $val[12]),
							"CourierScoringPayment" => str_replace(',', '', $val[13]),
							"RiderBalance" => str_replace(',', '', $val[14]),
							"NewTotalDeduction" => str_replace(',', '', $val[15]),
							"NewNetAmountToPay" => str_replace(',', '', $this->parseNegativeValue($val[16])),
							"invoice_month" => $invoice_month,
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
					$batch_data = []; // Clear batch data after insertion
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
		$result = $this->db->insert_batch('hunger_invoice', $batch_data);
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

		$fetch_data = $this->invoice_model->get_list($keyword, $rider_id, $start_date, $end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = date('M, Y', strtotime($item->invoice_month));
			$sub_array[] = $item->rider_id;
			$sub_array[] = $item->emp_no;
			$sub_array[] = $item->full_name;
			$sub_array[] = $item->orders;
			$sub_array[] = $item->TotalAmountSD;
			$sub_array[] = $item->StackingDeduction;
			$sub_array[] = $item->TotalAmountWSD;
			$sub_array[] = $item->VAT;
			$sub_array[] = $item->AmountIncVAT;
			$sub_array[] = $item->CourierBasicPayment;
			$sub_array[] = $item->CourierScoringPayment;
			$sub_array[] = $item->RiderBalance;
			$sub_array[] = $item->NewTotalDeduction;
			$sub_array[] = $item->NewNetAmountToPay;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			// $sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/master/employee/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/master/employee/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->invoice_model->get_all_data(),
			"recordsFiltered"     =>     $this->invoice_model->get_filtered_data($keyword, $rider_id, $start_date, $end_date),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->invoice_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/hunger/invoice-list');
	}

	public function print_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		list('invoices' => $invoices, 'sums' => $sums, 'start_date' => $start_date, 'end_date' => $end_date, 'qrCode' => $qrCode) = $this->getInvoices();
		$data['invoices'] = $invoices;
		$data['sums'] = $sums;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['qrCode'] = $qrCode;
		$this->load->library('Pdf_hunger_invoice');
		$pdf = new Pdf_hunger_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Hunger Invoice');
		$pdf->SetSubject('Invoice');
		$pdf->SetKeywords('TCPDF, PDF, Invoice, list');

		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(false);
		$pdf->SetFont('aealarabiya', 'I', 10);
		$htmlHeader = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_header.php', [], true);
		$pdf->setHtmlHeader($htmlHeader);
		// Set margins
		$pdf->SetMargins(5, 1, 5, true);
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		$pdf->SetAutoPageBreak(TRUE, 15);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->AddPage();

		// Load the view and pass the data
		$html = $this->load->view('admin/logistic-management/hunger/print-invoice/print_hunger_invoice.php', $data, true);

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// Close and output PDF document
		$pdf->Output('hunger_invoice ' . 1 . '.pdf', 'I');
	}

	public function getInvoices()
	{
		$date = DateTime::createFromFormat('F Y', $this->input->post('month'));
		$month = $date->format('m');
		$year = $date->format('Y');
		$start_date = date('01/m/Y', strtotime("01-$month-$year"));
		$end_date = date('t/m/Y', strtotime("01-$month-$year"));

		$invoices = $this->db->select('(TotalAmountSD / orders) as rate,
		SUM(TotalAmountWSD) as TotalAmountWSD, SUM(orders) as orders,
		SUM(VAT) as VAT, SUM(AmountIncVAT) as AmountIncVAT, SUM(RiderBalance) as RiderBalance, SUM(NewNetAmountToPay) as NewNetAmountToPay,invoice_month')
			->from('hunger_invoice')
			->where('MONTH(invoice_month)', $month)
			->where('YEAR(invoice_month)', $year)
			->group_by('rate')
			->get()->result();

		$sums = [
			'VAT' => 0,
			'AmountIncVAT' => 0,
			'RiderBalance' => 0,
			'NewNetAmountToPay' => 0,
		];

		$sums = array_reduce($invoices, function ($carry, $invoice) {
			$carry['VAT'] += $invoice->VAT;
			$carry['AmountIncVAT'] += $invoice->AmountIncVAT;
			$carry['RiderBalance'] += $invoice->RiderBalance;
			$carry['NewNetAmountToPay'] += $invoice->NewNetAmountToPay;
			return $carry;
		}, $sums);

		$qrCode = $this->_qrcodeGenerator2('Hunger Invoice', date('d/m/y h:i:s A'), $sums['AmountIncVAT'], $sums['VAT']);

		return ['invoices' => $invoices, 'sums' => $sums, 'start_date' => $start_date, 'end_date' => $end_date, 'qrCode' => $qrCode];
	}



	/*----- For Leagal Use -----*/

	function dec2hex($number)
	{
		if ($number > 15) {
			$hexval = dechex($number);
		} else {
			$hexval = '0' . dechex($number);
		}
		return $hexval;
	}

	public function _qrcodeGenerator2($param, $date, $total_amt, $total_vat)
	{
		$this->load->helper('date');
		// $this->load->library('ciqrcode');

		$Seller_name  = 'Maha Alfala Trading Est.';
		$vat_no = '310069655100003';
		$inv_date = date('Y-m-d\TH:i:s\Z', strtotime($date));
		$invoice_total = $total_amt;
		$vat_total = $total_vat;

		$seller_dec2hex = $this->dec2hex(strlen($Seller_name));
		$vat_no_dec2hex = $this->dec2hex(strlen($vat_no));
		$inv_date_dec2hex = $this->dec2hex(strlen($inv_date));
		$invoice_total_dec2hex = $this->dec2hex(strlen($invoice_total));
		$vat_total_dec2hex = $this->dec2hex(strlen($vat_total));

		$seller_bin2hex = bin2hex($Seller_name);
		$vat_no_bin2hex = bin2hex($vat_no);
		$inv_date_bin2hex = bin2hex($inv_date);
		$invoice_total_bin2hex = bin2hex($invoice_total);
		$vat_total_bin2hex = bin2hex($vat_total);

		$tlv = '01' . $seller_dec2hex . $seller_bin2hex . '02' . $vat_no_dec2hex . $vat_no_bin2hex . '03' . $inv_date_dec2hex . $inv_date_bin2hex . '04' . $invoice_total_dec2hex . $invoice_total_bin2hex . '05' . $vat_total_dec2hex . $vat_total_bin2hex;
		$base_64 = base64_encode(pack('H*', $tlv));

		if (isset($base_64)) {
			$params['data'] = $base_64;
			$params['level'] = 'H';
			$params['size'] = 4;

			// Generate QR code image
			ob_start();
			QRcode::png($params['data'], NULL, $params['level'], $params['size']);
			$image_data = ob_get_contents();
			ob_end_clean();
			$filename = 'admin_assets/images/hunger_invoice/hungerInvoiceQrcode.png';

			// Save QR code image to file
			file_put_contents($filename, $image_data);

			// Return the filename or true/false based on success
			return $filename;
		} else {
			return false;
		}
	}


	function parseNegativeValue($input)
	{

		$cleaned_value = str_replace(array('(', ')', ','), '', $input);

		$float_value = (float) $cleaned_value;

		if (strpos($input, '(') !== false) {
			$float_value = -$float_value;
		}
		return $float_value; // This will output -54242.5
	}

	public function avgRiderAcceptance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hunger_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$month_input = $this->input->post('month');
		$team_name = $this->input->post('team');
		$date = DateTime::createFromFormat('F Y', $month_input);
		$data['avg_report'] = $this->invoice_model->avgRiderReport();
		$data['report_month'] = $month_input;
		$data['team_name'] = $team_name;
		//dd($month_input);
		$this->load->library('Pdf_hunger_report_landscape');
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Average Rider Acceptance Report');
		$pdf->SetSubject('Acceptance Report');
		$pdf->SetKeywords('TCPDF, PDF, Report, Acceptance Report');

		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$pdf->SetFont('aealarabiya', 'I', 10);
		$htmlHeader = $this->load->view('admin/logistic-management/hunger/print-invoice/rider_average_header.php', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print-invoice/rider_average_header.php', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// Set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);

		$pdf->SetAutoPageBreak(TRUE, 11);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// add a page
		$pdf->AddPage('L', 'A4');
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Load the view and pass the data
		$html = $this->load->view('admin/logistic-management/hunger/print-invoice/rider_average_report.php', $data, true);

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// Close and output PDF document
		$pdf->Output('Rider Average Acceptance Report - ' . $data['report_month'] . '.pdf', 'I');
	}
}
