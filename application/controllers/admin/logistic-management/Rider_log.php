<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rider_log extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/logistic-management/Riderlog_model','rider_log');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action=$this->router->fetch_method();
		}			
		else{				
			redirect('admin/common/login');
		}
	}
    public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'transfer_log', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/logistic-management/rider-log/transfer',$data);
	}

	public function get_ajax_list(){
		$fetch_data = $this->rider_log->get_list();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = $key_data->id_number;
			$sub_array[] = $key_data->food_company;
			$log_detail = json_decode($key_data->log_detail);
			$sub_array[] = $log_detail->id_type;
			$sub_array[] = date('d-m-Y', strtotime($log_detail->transfer_date));
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->rider_log->get_all_data(),  
			"recordsFiltered"     =>     $this->rider_log->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	// Suspend Log

	public function suspend_index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_log', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/logistic-management/rider-log/suspend',$data);
	}

	public function get_suspend_ajax_list(){
		$fetch_data = $this->rider_log->suspend_list();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = $key_data->id_number;
			$sub_array[] = $key_data->food_company;
			$sub_array[] = $key_data->id_type;
			$log_detail = json_decode($key_data->log_detail);
			$sub_array[] = date('d-m-Y h:i A', strtotime($log_detail->suspend_from)) .' -> '. date('d-m-Y h:i A', strtotime($log_detail->suspend_to));
			$suspend_from = new DateTime($log_detail->suspend_from);
			$suspend_to = new DateTime($log_detail->suspend_to);
			$interval = $suspend_from->diff($suspend_to);
			$suspend_duration = $interval->format('%d days %h hours');
			$sub_array[] = $suspend_duration;
			$sub_array[] = ($key_data->status_type == 'Suspend') ? '<span class="badge badge-pill badge-soft-danger font-size-13">Suspend</span>' : '<span class="badge badge-pill badge-soft-success font-size-13">Released</span>';
			$sub_array[] = $key_data->reason;
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->rider_log->get_all_suspend(),  
			"recordsFiltered"     =>     $this->rider_log->get_filtered_suspend(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function printMonthlySuspendLogs() {
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_log', 'printMonthlySuspendLogs')) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_general');
		// Fetch form inputs
		$keyword = $this->input->get('keyword') ? $this->input->get('keyword') : FALSE;
		$id_type = $this->input->get('id_type') ? $this->input->get('id_type') : FALSE;
		$month_of = $this->input->get('month_of', TRUE) ?? 'Aug 2024';
		$platform = $this->input->get('platform') ? $this->input->get('platform') : FALSE;
		$id_number = $this->input->get('id_number') ? $this->input->get('id_number') : FALSE;
	
		// Decode and validate month_of
		$month_of = urldecode($month_of);
		// Fetch data from model
		try {
			$data['reports'] = $this->rider_log->monthly_suspended_log($keyword, $id_type, $month_of, $platform, $id_number);
		} catch (Exception $e) {
			log_message('error', 'Error fetching performance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}
		//dd($data['reports']);
		// Prepare data for the PDF
		$data['search_keyword'] = $keyword;
		$data['search_id_type'] = $id_type;
		$data['search_platform'] = $platform ? htmlspecialchars($platform) : 'ALL';
		$data['search_id_number'] = $id_number ? htmlspecialchars($id_number) : 'ALL';
		$data['search_month'] = $month_of ? htmlspecialchars($month_of) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
	
		// Create PDF document
		$pdf = new Pdf_general(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Suspend Report');
		$pdf->SetSubject('Monthly Suspend Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Suspend Report');
	
		// Remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = '';
		$htmlHeader2 = '';
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
	
		$lastFooter = $this->load->view('admin/logistic-management/rider-log/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);
	
		// Set default monospaced font and margins
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
		// Language-dependent strings
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
	
		// Add a page and set font
		$pdf->AddPage('P', 'A4');
		$pdf->setRTL(false);
		$pdf->SetFont('dejavusans', '', 10);
		// Load and write content
		$htmlcontent = $this->load->view('admin/logistic-management/rider-log/print/print_suspend_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
	
		// Output PDF
		$filename = $month_of
			? 'BS-Monthly-Suspend-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-All-Suspend-Report.pdf';
		$pdf->Output($filename, 'I');
	}
	
	public function printDailySuspendLogs() {
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_log', 'printMonthlySuspendLogs')) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_promissory_note');
		// Fetch form inputs
		$keyword = $this->input->get('keyword') ? $this->input->get('keyword') : FALSE;
		$id_type = $this->input->get('id_type') ? $this->input->get('id_type') : FALSE;
		$date_from = $this->input->get('from') ? $this->input->get('from') : FALSE;
		$date_to = $this->input->get('to') ? $this->input->get('to') : FALSE;
		$platform = $this->input->get('platform') ? $this->input->get('platform') : FALSE;
		$id_number = $this->input->get('id_number') ? $this->input->get('id_number') : FALSE;
	
		// Decode and validate month_of
		$date_of = urldecode($date_from);
		// Fetch data from model
		try {
			$data['reports'] = $this->rider_log->daily_suspended_log($keyword, $id_type, $date_from, $date_to, $platform, $id_number);
		} catch (Exception $e) {
			log_message('error', 'Error fetching performance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}
		//dd($data['reports']);
		// Prepare data for the PDF
		$data['search_keyword'] = $keyword;
		$data['search_id_type'] = $id_type;
		$data['search_platform'] = $platform ? htmlspecialchars($platform) : 'ALL';
		$data['search_id_number'] = $id_number ? htmlspecialchars($id_number) : 'ALL';
		$data['search_datefrom'] = $date_from ? date('d-m-Y', strtotime($date_from)) : 'NA';
		$data['search_dateto'] = $date_to ? date('d-m-Y', strtotime($date_to)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
	
		// Create PDF document
		$pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Daily Suspend Report');
		$pdf->SetSubject('Daily Suspend Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Daily Suspend Report');
	
		// Remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/rider-log/print/suspend_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/rider-log/print/suspend_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
	
		$lastFooter = $this->load->view('admin/logistic-management/rider-log/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);
	
		// Set default monospaced font and margins
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
		// Language-dependent strings
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
	
		// Add a page and set font
		$pdf->AddPage('L', 'A4');
		$pdf->setRTL(false);
		$pdf->SetFont('dejavusans', '', 10);
		// Load and write content
		$htmlcontent = $this->load->view('admin/logistic-management/rider-log/print/daily_suspend_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
	
		// Output PDF
		$filename = $date_of
			? 'BS-Daily-Suspend-Report-' . htmlspecialchars($date_of) . '.pdf'
			: 'BS-All-Suspend-Report.pdf';
		$pdf->Output($filename, 'I');
	}	

	// ID Allot Unallot Log

	public function swap_index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'allotment_and_unallotment_log', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/logistic-management/rider-log/swap',$data);
	}

	public function get_swap_ajax_list(){
		$fetch_data = $this->rider_log->get_swap_list();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$log_detail = json_decode($key_data->log_detail);
			$sub_array[] = $log_detail->id_number;
			$sub_array[] = $key_data->food_company;
			$sub_array[] = $log_detail->id_type;
			$sub_array[] = ($key_data->status_type == 'id_allot') ? '<span class="badge badge-pill badge-soft-success font-size-13">Allotment</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Unallotment</span>';
			$sub_array[] = $key_data->reason;
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->rider_log->get_all_swap_data(),  
			"recordsFiltered"     =>     $this->rider_log->get_swap_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
}

