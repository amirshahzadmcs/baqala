<?php defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_summary extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Attendance_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'attendance_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!empty($this->input->get('rider_filter'))) {
			$riderFilter = $this->input->get('rider_filter');
		} else {
			$riderFilter = FALSE;
		}
		if (!empty($this->input->get('month_of'))) {
			$attendanceMonth = $this->input->get('month_of');
		} else {
			$attendanceMonth = FALSE;
		}
		//print_r($attendanceMonth);exit();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		if ($attendanceMonth) {
			$data['attend_results'] = $this->Attendance_model->get_summary($riderFilter, $attendanceMonth);
			$data["attendance_month"] = $attendanceMonth;
		} else {
			$data['results'] = array();
		}
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/attendance-summary/list', $data);
	}

	public function summary_old()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'attendance_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!empty($this->input->get('rider_filter'))) {
			$riderFilter = $this->input->get('rider_filter');
		} else {
			$riderFilter = FALSE;
		}
		if (!empty($this->input->get('month_of'))) {
			$attendanceMonth = $this->input->get('month_of');
		} else {
			$attendanceMonth = FALSE;
		}
		//print_r($attendanceMonth);exit();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		if ($attendanceMonth) {
			$data['attend_results'] = $this->Attendance_model->get_summary_old($riderFilter, $attendanceMonth);
			$data["attendance_month"] = $attendanceMonth;
		} else {
			$data['results'] = array();
		}
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/attendance-summary/list_old', $data);
	}

	public function attendance_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'attendance_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/attendance-summary/form');
	}

	public function add_attendance()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('attend_date', 'Date of Attendance', 'trim|required|callback_valid_check_exists');
			$this->form_validation->set_message('valid_check_exists', 'Record already exists for this date, Try new');
			$this->form_validation->set_rules('rider_id[]', 'Rider', 'trim|required');
			$this->form_validation->set_rules('mark_attend[]', 'Attendance Status', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
			} else {
				$query = $this->Attendance_model->add_attendance();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully Added");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
			redirect('admin/attendance/add');
		} else {
			redirect('admin');
		}
	}

	public function valid_check_exists()
	{
		$attend_date = $this->input->post('attend_date');
		if (!isset($id)) {
			$id = 0;
		}
		if ($this->Attendance_model->check_data_exists($attend_date)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function print_summary()
	{
		$this->load->library('Pdf_mobile_invoice');
		if (!empty($this->input->get('rider_filter'))) {
			$riderFilter = $this->input->get('rider_filter');
		} else {
			$riderFilter = FALSE;
		}
		if (!empty($this->input->get('start_filter'))) {
			$startDate = $this->input->get('start_filter');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('end_filter'))) {
			$endDate = $this->input->get('end_filter');
		} else {
			$endDate = FALSE;
		}
		if ($startDate && $endDate) {
			$data['results'] = $this->Attendance_model->get_summary($riderFilter, $startDate, $endDate);
			$data['admin'] = 'Amanullah Kazi';
			$data['start'] = date('d M Y', strtotime($startDate));
			$data['end'] = date('d M Y', strtotime($endDate));
			// create new PDF document
			$pdf = new Pdf_mobile_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Daily Delivery Summary From ' . date('d M Y', strtotime($startDate)) . ' To ' . date('d M Y', strtotime($endDate)));
			$pdf->SetSubject('BS - Daily Delivery Summary From ' . date('d M Y', strtotime($startDate)) . ' To ' . date('d M Y', strtotime($endDate)));
			$pdf->SetKeywords('Baqala Station, PDF, Daily Delivery Summary');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/attendance-summary/header-footer/invoice_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/delivery-summary/header-footer/invoice_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/attendance-summary/header-footer/footer_last', $data, true);
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
			$pdf->SetMargins(2, 60, 4, true);

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
			$pdf->AddPage('L', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/attendance-summary/print-summary', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS - Daily Delivery Summary From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)) . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Select valid date!");
			redirect('admin/attendance-summary/list');
		}
	}
}
