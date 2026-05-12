<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendancelog extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/attendance/Attendancelog_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

    public function index()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/attendance/attendance_logs/index',$data);
	}

	public function get_ajax_list(){
		$fetch_data = $this->Attendancelog_model->get_list();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$key_data->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name) .'<br>#'. $key_data->designation_name;
			$sub_array[] = $key_data->department_name;
			$sub_array[] = date('d-m-Y', strtotime($key_data->attendance_date));
			$sub_array[] =  (!empty($key_data->time_in)) ? date('h:i:s a ', strtotime($key_data->time_in)) : "";
			$sub_array[] =  (!empty($key_data->time_out)) ? date('h:i:s a ', strtotime($key_data->time_out)) : "";
			$sub_array[] = ($key_data->status == 'in') ? '<span class="badge badge-pill badge-soft-success font-size-13">In</span>' : '<span class="badge badge-pill badge-soft-dark font-size-13">Out</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="javascript:;"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'. base_url('admin/attendance-logs/detail?id='.$key_data->id) .'" target="_blank"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Attendancelog_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Attendancelog_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function add_attendance()
	{
		$this->load->view('admin/attendance/attendance_logs/form');
	}
	
	public function detail(){
		if($this->input->get('id')){
			$data['attend_detail'] = $this->Attendancelog_model->get_detail($this->input->get('id'));
			$this->load->view('admin/attendance/attendance_logs/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid request or unauthorized access!");
			redirect('admin/attendance/attendance_logs/list');
		}
	}

	public function edit(){
		$this->load->view('admin/attendance/edit');
	}
	
	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Empriders_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/employed-rider/list');
	}
	
	public function export_attendance_log(){
	    $this->load->library('Pdf_mobile_consolidate_report');
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('iqama_no'))){
			$iqama_no = $this->input->get('iqama_no');
		}
		else{
			$iqama_no = FALSE;
		}
		if(!empty($this->input->get('department'))){
			$department = $this->input->get('department');
		}
		else{
			$department = FALSE;
		}
		if(!empty($this->input->get('from'))){
			$from = $this->input->get('from');
		}
		else{
			$from = FALSE;
		}
		if(!empty($this->input->get('to'))){
			$to = $this->input->get('to');
		}
		else{
			$to = FALSE;
		}
		
		$data['attendance_logs'] = $this->Attendancelog_model->print_log();
		//print_r($data['invoice']);exit();
		$data['start'] = $from;
		$data['end'] = $to;
		$data['user'] = $keyword;
		$data['department'] = $department;
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		ini_set('memory_limit', '-1');
		$pdf = new Pdf_mobile_consolidate_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Baqala Station - Employee Attendance Logs');
		$pdf->SetSubject('Baqala Station - Employee Attendance Logs');
		$pdf->SetKeywords('Baqala Station, PDF, Employee Attendance Logs');
		
		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/attendance/attendance_logs/print_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/attendance/attendance_logs/print_header',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/attendance/attendance_logs/print_footer',$data, true);
		$pdf->setHtmlFooter($lastFooter);
		
		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(1, 60, 4, true);

		// set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('P', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/attendance/attendance_logs/print_logs',$data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$date = date('d-m-y-'.substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "attendance_logs".$date.".pdf";
		$pdf->Output($filename, 'I');
	}
	
}

