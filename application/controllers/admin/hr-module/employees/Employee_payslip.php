<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Employee_payslip extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Employeepayslip_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
			$this->load->helper('request_helper');
			$this->load->helper('attendance_helper');
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
		if ($this->action && !check_action_permission(get_user_role(), 'employees_payslip', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['payroll_summary'] = $this->Employeepayslip_model->getPayrollSummary();
		//dd($data['payroll_summary']);
		$this->load->view('admin/hr-module/employee_temp_salary/index', $data);
	}
	/*
	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		
		if(!empty($this->input->get('designation'))){
			$designation = $this->input->get('designation');
		}
		else{
			$designation = FALSE;
		}
		if(!empty($this->input->get('department'))){
			$department = $this->input->get('department');
		}
		else{
			$department = FALSE;
		}
		
		if(!empty($this->input->get('iqama'))){
			$iqama = $this->input->get('iqama');
		}
		else{
			$iqama = FALSE;
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
		$fetch_data = $this->Employeepayslip_model->get_list($keyword,$designation,$department,$iqama,$start_date,$end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $employee){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$employee->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($employee->salary_month));
			$sub_array[] = $employee->emp_id;
			$sub_array[] = $employee->employee_name;
			$sub_array[] = $employee->iqama_no;
			$sub_array[] = $employee->designation;
			$sub_array[] = $employee->department;
			$sub_array[] = ((isset($employee->joining_date)) ? date('d-m-Y', strtotime($employee->joining_date)) : '');
			$sub_array[] = $employee->payable_days;
			$sub_array[] = $employee->net_pay;
			$sub_array[] = date('d-m-Y', strtotime($employee->created_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="javascript:;"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="javscript:;"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>  <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'. base_url('admin/hr/payslip/print?id='.$employee->id) .'" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Employeepayslip_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Employeepayslip_model->get_filtered_data($keyword,$designation,$department,$iqama,$start_date,$end_date),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	*/
	public function detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'employees_payslip', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($id) {
			$payroll = $this->Employeepayslip_model->get_detail($id);
			$summaryData = $this->Employeepayslip_model->getSummaryData($id);
			$payrollDetails = $this->Employeepayslip_model->getPayrollDetails($id);
			$data = [
				'payrollData' => $payroll,
				'summaryData' => $summaryData,
				'payrollDetails' => $payrollDetails
			];
			//dd($data);
			$this->load->view('admin/hr-module/employee_temp_salary/detail', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/hr/payslip/list');
		}
	}

	public function delete($id)
	{
		if (!$id) {
			$this->session->set_flashdata('info', "2--Invalid request!");
			redirect('admin/hr/payslip/list');
		}

		$deleted = $this->Employeepayslip_model->delete($id);

		if ($deleted) {
			$this->session->set_flashdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_flashdata('info', "2--Error while deleting!");
		}

		redirect('admin/hr/payslip/list');
	}

	/*----- Bulk Import Employee Payslip -----*/
	public function import_file()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'employees_payslip', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$path = 'uploads/imports/payslip/';
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
			$expected_columns = 67;
			foreach ($sheet_data as $row) {
				if (count($row) < $expected_columns) {
					throw new Exception("Invalid file format: Each row must have $expected_columns columns.");
				}
			}

			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);

			// Parse salary date
			$salary_date = date('Y-m-d', strtotime($this->input->post('salary_month')));
			$last_date_of_month = date('Y-m-t', strtotime($salary_date));

			// Start transaction
			$this->db->trans_start();

			// Check duplicates in bulk
			$existing_records = $this->Employeepayslip_model->checkDuplicatesPayroll($salary_date);
			if (!empty($existing_records)) {
				$json = [
					'error_message' => 'Already added payroll of this month. Try another month!',
				];
			} else {
				$data = array(
					'payroll_month' => $salary_date,
					'from_date' => $salary_date,
					'to_date' => $last_date_of_month,
					'status' => 1,
					'created_at' => $this->datetime,
					'updated_at' => $this->datetime,
				);
				$this->db->insert('employee_payroll', $data);
				$insert_id = $this->db->insert_id();

				$batch_data = [];
				foreach ($sheet_data as $val) {
					//dd($val);
					if (!empty($val[1]) && !empty($val[2])) { // Replace with necessary column checks
						$batch_data[] = [
							"payroll_id" => $insert_id,
							"emp_id" => $val[1],
							"employee_name" => $val[2],
							"iqama_no" => $val[3],
							"joining_date" => (!empty($val[4]) ?
								(is_numeric($val[4]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val[4])->format('Y-m-d') : date('Y-m-d', strtotime($val[4])))
								: ''),
							"designation" => $val[5],
							"department" => $val[6],
							"aggregator_name" => $val[7],
							"aggregator_id" => $val[8],
							"payment_mode" => $val[9],
							"bank_name" => $val[10],
							"bank_iban_no" => $val[11],
							"package" => $val[12],
							"monthly_target" => $val[13],
							"target_achieve" => $val[14],
							"progress" => $val[15],
							"total_working_days" => $val[16],
							"loss_of_pay_days" => $val[17],
							"actual_payable_days" => $val[18],
							"payable_date" => (!empty($val[19]) ?
								(is_numeric($val[19]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val[19])->format('Y-m-d') : date('Y-m-d', strtotime($val[19])))
								: ''),
							"opening_balance" => $val[20],
							"new_loan" => $val[21],
							"deduction" => $val[22],
							"balance_due" => $val[23],
							"basic_salary" => $val[24],
							"food" => $val[25],
							"housing" => $val[26],
							"transportation" => $val[27],
							"other" => $val[28],
							"salary_earned" => $val[29],
							"adjustment_commission" => $val[30],
							"hunger_adjustment" => $val[31],
							"online_hours_incentive" => $val[32],
							"reimbursements" => $val[33],
							"target_based_commission" => $val[34],
							"tips" => $val[35],
							"wallet_cash" => $val[36],
							"total_earnings" => $val[37],
							"gosi_employee" => $val[38],
							"total_contribution" => $val[39],
							"acceptance_contact_penalty" => $val[40],
							"accident_claim" => $val[41],
							"aggregator_penalty" => $val[42],
							"compliance_penalty" => $val[43],
							"jahez_debit" => $val[44],
							"adjustments" => $val[45],
							"bike_spare_parts" => $val[46],
							"carry_forward_salary" => $val[47],
							"basic_paid" => $val[48],
							"cash_advance" => $val[49],
							"contact_penalties" => $val[50],
							"days_deduction" => $val[51],
							"declined_penalties" => $val[52],
							"hunger_cash_shortage" => $val[53],
							"id_suspension_penalty" => $val[54],
							"jahez_cash_shortage" => $val[55],
							"license_deduction" => $val[56],
							"medical_expenses" => $val[57],
							"mobile_deduction" => $val[58],
							"noon_cash_shortage" => $val[59],
							"online_hours_incentive_deduction" => $val[60],
							"personal_sim_card" => $val[61],
							"target_based_deduction" => $val[62],
							"traffic_violation" => $val[63],
							"unpaid_leave" => $val[64],
							"wallet_balance" => $val[65],
							"total_deduction" => $val[66],
							"net_pay" => $val[67],
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
		$result = $this->db->insert_batch('employee_payslip', $batch_data);

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
	// Bulk Upload End

	public function print_payslip()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'employees_payslip', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->load->library('Pdf_employee_offer');

		$id = $this->input->get('id');
		$data['payslip_detail'] = $this->Employeepayslip_model->payslipDetail($id);
		//dd($data['payslip_detail']);
		if ($data['payslip_detail'] !== '') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - PAYSLIP');
			$pdf->SetSubject('BS - PAYSLIP');
			$pdf->SetKeywords('Baqala Station, PDF, PAYSLIP, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 5, 8, true);
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
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/employee_temp_salary/print/payslip', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$payslipMonth = date('M Y', strtotime($data['payslip_detail']['payroll_month']));
			$pdf->Output($payslipMonth . ' Payslip - ' . $data['payslip_detail']['employee_name'] . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Payslip detail not found!");
			redirect('admin/hr/payslip/list');
		}
	}
	
	public function download_selected($payrollId)
	{
		if (empty($payrollId)) {
			show_error('No Payroll ID specified.', 400);
			return;
		}

		$this->load->library('Pdf_employee_offer');
		$payslipDetails = $this->Employeepayslip_model->printAllPayslips($payrollId);

		if (empty($payslipDetails)) {
			show_error('No payslip records found for the specified Payroll ID.', 400);
			return;
		}

		$filePaths = [];

		foreach ($payslipDetails as $payslip) {
			$data['payslip_detail'] = $payslip;

			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - PAYSLIP');
			$pdf->SetSubject('BS - PAYSLIP');
			$pdf->SetKeywords('Baqala Station, PDF, PAYSLIP, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
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
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->AddPage();
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);

			$htmlcontent = $this->load->view('admin/hr-module/employee_temp_salary/print/payslip', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

			$payslipMonth = date('M Y', strtotime($payslip['payroll_month']));
			$fileName = preg_replace('/[^A-Za-z0-9_\- .]/', '', $payslipMonth . ' Payslip - ' . $data['payslip_detail']['employee_name'] . '.pdf');
			$pdfFilePath = FCPATH . 'uploads/tmp/' . $fileName;
			$pdf->Output($pdfFilePath, 'F');

			$filePaths[] = 'uploads/tmp/' . $fileName;

		}

		if (!empty($filePaths)) {
			download_files_as_zip($filePaths, 'Payslip_Documents');
		} else {
			show_error('No valid payslip documents found.', 400);
		}
	}

	public function update_status()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'employees_payslip', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		// Validate the incoming request
		$this->form_validation->set_rules('id', 'Request ID', 'required');
		$this->form_validation->set_rules('status', 'Request Status', 'required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
		}

		$id = $this->input->post('id');
		$payroll_detail = $this->Employeepayslip_model->get_detail($id);

		if (!empty($payroll_detail)) {
			$payroll_id = $payroll_detail['id'];
			$status = $this->input->post('status');
			if ($status <= '3') {
				$update_data = [
					'status' => $status,
					'updated_by' => $this->admin->getId(),
					'updated_at' => $this->datetime,
				];
				// Add closing_date if status is 3
				if ($status == '3') {
					$update_data['closing_date'] = $this->datetime;
				}
				// Update the database
				$update_status = $this->Employeepayslip_model->updateStatus($payroll_id, $update_data);

				if ($update_status) {
					echo json_encode(['status' => 'success', 'message' => 'Status updated successfully.']);
					return;
				} else {
					echo json_encode(['status' => 'error', 'message' => 'Failed to update status. Please try again.']);
					return;
				}
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Something went wrong.']);
				return;
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Payroll detail not found.']);
			return;
		}
	}
}
