<?php defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Change_profession_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Change_profession_model', 'profession_model');
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
		if ($this->action && !check_action_permission(get_user_role(), 'change_profession', $this->action)) {
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
		//$allowance_list = $this->profession_model->get_batch_list(); 
		//dd($allowance_list);
		$this->load->view('admin/hr-module/change_profession/index', $data);
	}

	public function get_list()
	{
		$transfer_list = $this->profession_model->get_batch_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($transfer_list as $key => $value) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $value['batch_no'];
			$sub_array[] = date('d-m-Y', strtotime($value['request_date']));
			$sub_array[] = $value['member_count'];
			$sub_array[] = date('d-m-Y H:i A', strtotime($value['created_at']));
			$printButtons = '';
			$detailButtons = '';

			$printButtons .= '<div class="dropdown float-start">
				<button class="btn nav-btn dropdown-toggle btn-custom-light btn-sm edit" type="button" data-bs-toggle="dropdown">
					<i class="mdi mdi-dots-vertical font-size-18"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">';

			// PDF permission
			if (check_action_permission(get_user_role(), 'change_profession', 'print_batch_detail')) {
				$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/change-profession/export-pdf/' . $value['batch_no']) . '" target="_blank">
					Export Transfer [PDF]
				</a>';
			}

			// Excel permission
			if (check_action_permission(get_user_role(), 'change_profession', 'export_batch_excel')) {
				$printButtons .= '<a class="dropdown-item" href="' . base_url('admin/hr/change-profession/export-excel/' . $value['batch_no']) . '" target="_blank">
					Export Transfer [Excel]
				</a>';

				$detailButtons .= '<button type="button" 
					class="btn btn-outline-secondary btn-custom-light btn-sm edit view-batch-detail float-start" 
					title="Detail" 
					data-batch_no="' . $value['batch_no'] . '" 
					onclick="viewBatchDetail(\'' . $value['batch_no'] . '\')">
					<i class="mdi mdi-stretch-to-page-outline font-size-18"></i>
				</button>';
			}

			$printButtons .= '</div></div>';

			$sub_array[] = $detailButtons . $printButtons;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->profession_model->get_all_data(),
			"recordsFiltered" => $this->profession_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function view_batch_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'change_profession', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$batch_no = $this->input->get('batch_no');

		if (empty($batch_no)) {
			echo json_encode(['status' => 'error', 'message' => 'Batch number required.']);
			return;
		}
		$data['batch_no'] = $batch_no;
		$data['profession_list'] = $this->profession_model->get_list($batch_no);
		// Load the view with data
		$this->load->view('admin/hr-module/change_profession/partials/batch_detail', $data);
	}

	/*----- Export Excel ----*/
	public function export_batch_excel($batch_no)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'change_profession', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (empty($batch_no)) {
			show_error('Batch number is required.');
		}

		// ✅ Get data from model
		$transfer_list = $this->profession_model->get_list($batch_no);

		if (empty($transfer_list)) {
			show_error('No records found for this batch.');
		}

		// ✅ Status mapping
		$statuses = [
			1 => 'Pending Employee Approval',
			2 => 'Pending Current Employer Approval',
			3 => 'Completing',
			4 => 'Rejected'
		];

		$transferTypes = [
			1 => 'Transfer Laborer from another Establishment',
			2 => 'Internal Transfer'
		];

		// ✅ Create spreadsheet
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// ===== 🎯 First Row (Batch Info) =====
		$batchNo       = $transfer_list[0]['batch_no'];
		$requestDate   = date('d-m-Y', strtotime($transfer_list[0]['request_date']));
		$totalEmployees = count($transfer_list);

		$sheet->setCellValue('A1', 'Batch No.');
		$sheet->setCellValue('B1', $batchNo);
		$sheet->setCellValue('C1', 'Request Date');
		$sheet->setCellValue('D1', $requestDate);
		$sheet->setCellValue('E1', 'Total Employees');
		$sheet->setCellValue('F1', $totalEmployees);

		// ✅ Style for first row (different color, bold text)
		$sheet->getStyle('A1:F1')->applyFromArray([
			'font' => ['bold' => true],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFE2EFDA'] // light green shade
			]
		]);

		// ===== 🎯 Second Row (Headers) =====
		$headers = [
			'S.No.', 'Batch No.', 'Emp No.', 'Employee Name', 'Designation',
			'Iqama No.', 'Old Employer', 'New Employer', 'Transfer Type',
			'Request Date', 'Update Joining Date', 'Reason', 'Contract ID',
			'Contract Period', 'Contract Start Date', 'Contract End Date', 'Status'
		];

		$col = 'A';
		foreach ($headers as $header) {
			$sheet->setCellValue($col.'2', $header);
			$col++;
		}

		// ✅ Style headers with sky color
		$sheet->getStyle('A2:Q2')->applyFromArray([
			'font' => ['bold' => true],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFB7DEE8'] // light sky blue
			]
		]);

		// ===== 🎯 Fill Data (start from Row 3) =====
		$row = 3;
		$count = 1;
		foreach ($transfer_list as $value) {
			$sheet->setCellValue('A'.$row, $count++);
			$sheet->setCellValue('B'.$row, $value['batch_no']);
			$sheet->setCellValue('C'.$row, $value['emp_no']);
			$sheet->setCellValue('D'.$row, $value['full_name']);
			$sheet->setCellValue('E'.$row, $value['designation_name']);
			$sheet->setCellValue('F'.$row, $value['iqama_no']);
			$sheet->setCellValue('G'.$row, $value['old_employer_id'].' - '.$value['old_employer_name']);
			$sheet->setCellValue('H'.$row, $value['new_employer_id'].' - '.$value['new_employer_name']);
			$sheet->setCellValue('I'.$row, $transferTypes[$value['transfer_type']] ?? $value['transfer_type']);
			$sheet->setCellValue('J'.$row, date('d-m-Y', strtotime($value['request_date'])));
			$sheet->setCellValue('K'.$row, ucfirst($value['update_joining_date']));
			$sheet->setCellValue('L'.$row, $value['reason'] ?? 'NA');
			$sheet->setCellValue('M'.$row, $value['contract_id'] ?? 'NA');
			$sheet->setCellValue('N'.$row, $value['contract_period'] ?? 'NA');
			$sheet->setCellValue('O'.$row, $value['contract_start_date'] ? date('d-m-Y', strtotime($value['contract_start_date'])) : 'NA');
			$sheet->setCellValue('P'.$row, $value['contract_end_date'] ? date('d-m-Y', strtotime($value['contract_end_date'])) : 'NA');
			$sheet->setCellValue('Q'.$row, $statuses[$value['status']] ?? $value['status']);
			$row++;
		}

		// ✅ Set auto width
		foreach (range('A','Q') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// ✅ Download as Excel
		$filename = "batch_transfer_{$batch_no}.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	/*----- Print Start -----*/

	public function print_batch_detail($batch_no)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'change_profession', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (empty($batch_no)) {
			show_error('Batch number is required.');
		}
		$this->load->library('Pdf_general_margin');
		$query = $this->profession_model->get_list($batch_no);
		if (count($query) > 0) {
			$data['batch_detail'] = $query;
			$data['batch_list'] = array(
				'batch_no' => $data['batch_detail'][0]['batch_no'],
				'request_date' => $data['batch_detail'][0]['request_date'],
				'total_employees' => count($query)
			);
			// create new PDF document
			$pdf = new Pdf_general_margin(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Employee Transfer List');
			$pdf->SetSubject('BS - Employee Transfer List');
			$pdf->SetKeywords('Baqala Station, PDF, Employee Transfer List');

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
			$htmlcontent = $this->load->view('admin/hr-module/change_profession/print/print-profession', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Employee-Profession-' . $batch_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Profession Change detail not found!");
			redirect('admin/hr/change-profession/index');
		}
	}

	public function print_employee_batch_detail($profession_id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'change_profession', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_general_margin');
		$query = $this->profession_model->get_profession_detail($profession_id);
		if (count($query) > 0) {
			$data['profession_detail'] = $query;
			// create new PDF document
			$pdf = new Pdf_general_margin(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Change Profession Detail');
			$pdf->SetSubject('BS - Change Profession Detail');
			$pdf->SetKeywords('Baqala Station, PDF, Change Profession Detail');

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
			$pdf->SetFont('aealarabiya', '', 10);
			//$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/change_profession/print/print-profession-detail', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$emp_no = $query['emp_no'] ?? 'unknown';
			$pdf->Output('change-profession-detail-' . $emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Change profession detail not found!");
			redirect('admin/hr/change-profession/index');
		}
	}

}
