<?php defined('BASEPATH') or exit('No direct script access allowed');

class Clinical_vist_report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
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
		if (!check_action_permission(get_user_role(), 'clinical_visit_report', $this->action)) {
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
		$data['clinical_reports'] = $this->list();
		//dd($data['clinical_reports']);
		$this->load->view('admin/hr-module/clinical_report/index', $data);
	}

	public function list()
	{
		$this->db->select([
			'DATE(er.request_date) as request_date',
			'COUNT(er.employee_id) as employee_count'
		]);
		$this->db->from('employee_requests er');
		$this->db->where('er.request_type', 'ClinicalVisitRequest');
		$this->db->where('er.request_status', '2');
		$this->db->group_by('DATE(er.request_date)');
		$this->db->order_by('DATE(er.request_date)', 'DESC');
		return $this->db->get()->result_array();
	}


	public function view_group_detail()
	{
		$request_date = date('Y-m-d', strtotime($this->input->get('request_date')));
		if (empty($request_date)) {
			echo json_encode(['status' => 'error', 'message' => 'Request date required.']);
			return;
		}
		$data['request_date'] = $request_date;
		$data['clinical_detail'] = $this->detail($request_date);
		// Load the view with data
		$this->load->view('admin/hr-module/clinical_report/partials/detail', $data);
	}

	public function detail($date)
	{
		if (!check_action_permission(get_user_role(), 'clinical_visit_report', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->db->select([
			'er.*',
			'erd.request_detail',
			'erd.request_documents',
			'erd.reason',
			'me.emp_no',
			'me.full_name as employee_name',
			'me.iqama_no',
			'mip.policy_number as employee_policy_no',
			'mic.company_name as policy_company_name',
		]);
		$this->db->from('employee_requests er');
		$this->db->join('employee_request_detail erd', 'er.id = erd.request_id', 'left');
		$this->db->join('master_employee me', 'er.employee_id = me.id', 'left');
		$this->db->join('master_employee_info mei', 'er.employee_id = mei.employee_id', 'left');
		$this->db->join('master_insurance_policies mip', 'mei.insurance_policy_no = mip.id', 'left');
		$this->db->join('master_insurance_company mic', 'mip.policy_company = mic.id', 'left');
		$this->db->where('er.request_type', 'ClinicalVisitRequest');
		$this->db->where('er.request_status', '2');
		$this->db->where('DATE(er.request_date)', $date);
		$this->db->order_by('me.emp_no', 'ASC');
		return $this->db->get()->result_array();
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Employeepayslip_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/payslip/list');
	}

	public function print_visit_detail()
	{
		if (!check_action_permission(get_user_role(), 'clinical_visit_report', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');

		$request_date = $this->input->get('request_date');
		$data['request_date'] = $request_date;
		$data['clinical_detail'] = $this->detail($request_date);
		if ($data['clinical_detail'] !== '') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Medical Visit Details');
			$pdf->SetSubject('BS - Medical Visit Details');
			$pdf->SetKeywords('Baqala Station, PDF, Medical Visit Details, Employee');

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
			$htmlcontent = $this->load->view('admin/hr-module/clinical_report/print/report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$visitDateMonth = date('d M Y', strtotime($request_date));
			$pdf->Output('Payslip-' . $visitDateMonth . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Payslip detail not found!");
			redirect('admin/hr/payslip/list');
		}
	}
}
