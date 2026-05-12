<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jahez extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/logistic-management/Jahez_model', 'jahez_model');
		$this->load->helper('common_helper');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();

	}
	
	public function index() {
		if ($this->action && !check_action_permission(get_user_role(), 'daily_performance', $this->action)) {
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
	    $this->load->view("admin/logistic-management/jahez/jahez_index",$data);
	}
	
	public function upload() {
    	$this->load->view("admin/logistic-management/jahez/import_jahez");
    }

	/*----- Bulk Import Hunger -----*/
	public function import_file() {
		if ($this->action && !check_action_permission(get_user_role(), 'daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$path = 'uploads/imports/jahez/';
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
			$sheet_data = $spreadsheet->getActiveSheet()->toArray();
	
			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);
	
			// Initialize transaction
			$this->db->trans_start();
	
			$batch_data = [];
			$duplicate_rows = [];
	
			foreach ($sheet_data as $key => $val) {
				if ($val[1] != '') {
					$isDuplicate = $this->jahez_model->get([
						"did" => $val[1], 
                    	"ref_id" => $val[2]
					]);
					//print_r($isDuplicate);exit();
					if (!$isDuplicate) {
						$date_local = date('Y-m-d', strtotime($this->input->post('order_date')));

						// Get emp_id from logistic_rider by matching id_number with rider_id from Excel
						$this->db->select('
							logistic_rider.employee_id, 
							master_vehicles.id as vehicle_id, 
							(
								SELECT ht.id
								FROM hunger_team ht
								WHERE ht.team REGEXP CONCAT(\'"\', logistic_rider.employee_id, \'"\')
								ORDER BY ht.id ASC
								LIMIT 1
							) as team_id
						', false);
						$this->db->from('logistic_rider');
						$this->db->join('master_vehicles', 'master_vehicles.alloted_user = logistic_rider.employee_id', 'left');
						$this->db->where('logistic_rider.id_number', $val[5]);
						$rider_info = $this->db->get()->row();

						$emp_id = $rider_info ? $rider_info->employee_id : 0;
						$vehicle_id = $rider_info ? $rider_info->vehicle_id : 0;
						$team_id = $rider_info ? $rider_info->team_id : 0;
						
						$batch_data[] = [
							'emp_id'			=> $emp_id,
							'order_date'		=> $date_local,
							'did'				=> $val[1],
							'ref_id'			=> $val[2],
							'driver_name'		=> $val[3],
							'driver_username'	=> $val[4],
							'driver_id'			=> $val[5],
							'amount'			=> $val[6],
							'price'				=> $val[7],
							'driver_debit_amt'	=> $val[8],
							'driver_credit_amt'	=> $val[9],
							'is_free_order'		=> $val[10],
							'dispatch_time'		=> $val[11],
							'subscriber'		=> $val[12],
							'driver_paid_org'	=> $val[13],
							'org_settled'		=> $val[14],
							'driver_settled'	=> $val[15],
							"alloted_vehicle_id" => $vehicle_id,
							"alloted_team_id" => $team_id,
							'ip_address'		=> $this->ip_address,
							'created_at' 		=> $this->datetime,
						];
					} else {
						// Add the row to the list of duplicates
						$duplicate_rows[] = $val;
					}
				}
	
				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = [];
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
					'error_message' => count($duplicate_rows) .' Duplicate row(s) found. <span class="text-success">Rest all inserted</span>',
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

	private function getReaderByExtension($extension) {
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
	
	private function insertBatchData($batch_data) {
		$result = $this->db->insert_batch('jahez_order_summary', $batch_data);
	
		if (!$result) {
			$json = [
				'error_message' => 'Something went wrong. Please try again.',
			];
			echo json_encode($json);
			exit();
		}
	}
	
	public function upload_config($path) {
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

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('did'))){
			$did = $this->input->get('did');
		}
		else{
			$did = FALSE;
		}
		if(!empty($this->input->get('ref_id'))){
			$ref_id = $this->input->get('ref_id');
		}
		else{
			$ref_id = FALSE;
		}
		if(!empty($this->input->get('driver_username'))){
			$driver_username = $this->input->get('driver_username');
		}
		else{
			$driver_username = FALSE;
		}
		if(!empty($this->input->get('driver_id'))){
			$driver_id = $this->input->get('driver_id');
		}
		else{
			$driver_id = FALSE;
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
		
		$fetch_data = $this->jahez_model->get_list($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$item->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->order_date));
			$sub_array[] = $item->emp_no;
			$sub_array[] = $item->full_name;
			$sub_array[] = $item->did;
			$sub_array[] = $item->ref_id;
			$sub_array[] = $item->driver_name;
			$sub_array[] = $item->driver_username;
			$sub_array[] = $item->driver_id;
			$sub_array[] = $item->amount;
			$sub_array[] = $item->price;
			$sub_array[] = $item->driver_debit_amt;
			$sub_array[] = $item->driver_credit_amt;
			$sub_array[] = $item->is_free_order;
			$sub_array[] = $item->dispatch_time;
			$sub_array[] = $item->subscriber;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			// $sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/master/employee/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/master/employee/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->jahez_model->get_all_data(),  
			"recordsFiltered"     =>     $this->jahez_model->get_filtered_data($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		if ($this->action && !check_action_permission(get_user_role(), 'daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->jahez_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/employed-rider/jahez/index');
	}
	
	public function get_report(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('rider_id'))){
			$rider_id = $this->input->get('rider_id');
		}
		else{
			$rider_id = FALSE;
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
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['search_start_date'] = $start_date;
		$data['search_end_date'] = $end_date;
		$data['reports'] = $this->jahez_model->get_summary($keyword,$rider_id,$start_date,$end_date);
		//echo '<pre>';print_r($data);exit();
		$this->load->view("admin/logistic-management/jahez/jahez_report", $data);
	}
	
	public function print_modal_form($modal_name){
		if($modal_name == 'daywise'){
			$data['title'] = "Day Wise Report";
			$this->load->view('admin/logistic-management/jahez/components/daywise_filter_modal', $data);
		}
		else if($modal_name == 'weekly'){
			$data['title'] = "Weekly Report";
			$this->load->view('admin/logistic-management/jahez/components/weekly_filter_modal', $data);
		}
		else if($modal_name == 'monthly'){
			$data['title'] = "Monthly Report";
			$this->load->view('admin/logistic-management/jahez/components/monthly_filter_modal', $data);
		}
    }
	
	public function print_report(){
		if ($this->action && !check_action_permission(get_user_role(), 'daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
	    $this->load->library('Pdf_hunger_report');
		// print_r($order);exit();
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('did'))){
			$did = $this->input->get('did');
		}
		else{
			$did = FALSE;
		}
		if(!empty($this->input->get('ref_id'))){
			$ref_id = $this->input->get('ref_id');
		}
		else{
			$ref_id = FALSE;
		}
		if(!empty($this->input->get('driver_username'))){
			$driver_username = $this->input->get('driver_username');
		}
		else{
			$driver_username = FALSE;
		}
		if(!empty($this->input->get('driver_id'))){
			$driver_id = $this->input->get('driver_id');
		}
		else{
			$driver_id = FALSE;
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
		//dd($start_date .' - ' . $end_date);
		$reports_detail = $this->jahez_model->get_summary($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date);
		$data['reports'] = $reports_detail['details'];
		$data['completed_delv_count'] = $reports_detail['all_delv_count'];
		//dd($data['completed_delv_count']);
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $driver_id;
		$data['search_start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['search_end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		//dd($data);
		// create new PDF document
		$pdf = new Pdf_hunger_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Jahez Report');
		$pdf->SetSubject('BS - Jahez Report');
		$pdf->SetKeywords('Baqala Station, PDF, Jahez Report');
		
		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/logistic-management/jahez/print/print_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/jahez/print/print_header',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/logistic-management/jahez/print/footer',$data, true);
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
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(2, 60, 4, true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
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
		$htmlcontent = $this->load->view('admin/logistic-management/jahez/print/print_summary_report',$data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if($start_date && $end_date){
			$pdf->Output('BS-Jahez-Report-From '.date('d M Y', strtotime($start_date)).' To '.date('d M Y', strtotime($end_date)) .'.pdf', 'I');
		}else{
			$pdf->Output('BS-Jahez-All-Report.pdf', 'I');
		}
	}

	public function print_detail_report(){
		if ($this->action && !check_action_permission(get_user_role(), 'daily_performance', $this->action)) {
			redirect('admin/unauthorized-request');
		}
	    $this->load->library('Pdf_hunger_report');
		// print_r($order);exit();
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('did'))){
			$did = $this->input->get('did');
		}
		else{
			$did = FALSE;
		}
		if(!empty($this->input->get('ref_id'))){
			$ref_id = $this->input->get('ref_id');
		}
		else{
			$ref_id = FALSE;
		}
		if(!empty($this->input->get('driver_username'))){
			$driver_username = $this->input->get('driver_username');
		}
		else{
			$driver_username = FALSE;
		}
		if(!empty($this->input->get('driver_id'))){
			$driver_id = $this->input->get('driver_id');
		}
		else{
			$driver_id = FALSE;
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
		$data['reports'] = $this->jahez_model->get_detail_summary($keyword,$did,$ref_id,$driver_username,$driver_id,$start_date,$end_date);
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $driver_id;
		$data['search_start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['search_end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		//dd($data);
		// create new PDF document
		$pdf = new Pdf_hunger_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Jahez Detail Report');
		$pdf->SetSubject('BS - Jahez Detail Report');
		$pdf->SetKeywords('Baqala Station, PDF, Jahez Delivery Report');
		
		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/logistic-management/jahez/print/print_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/jahez/print/print_header',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/logistic-management/jahez/print/footer',$data, true);
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
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(2, 60, 4, true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
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
		$htmlcontent = $this->load->view('admin/logistic-management/jahez/print/print_detail_report',$data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if($start_date && $end_date){
			$pdf->Output('BS-Jahez-Report-From '.date('d M Y', strtotime($start_date)).' To '.date('d M Y', strtotime($end_date)) .'.pdf', 'I');
		}else{
			$pdf->Output('BS-Jahez-All-Report.pdf', 'I');
		}
	}
	
	public function print_daywise_report()
	{
		$this->load->library('Pdf_hunger_report_landscape');
		// Fetch form inputs
		$keyword = $this->input->get('filter_keyword') ? $this->input->get('filter_keyword') : FALSE;
		$rider_id = $this->input->get('filter_rider_id') ? $this->input->get('filter_rider_id') : FALSE;
		$month_of = $this->input->get('month_of', TRUE) ?? date('M Y');
		$team = $this->input->get('team') ? $this->input->get('team') : FALSE;

		// Decode and validate month_of
		$month_of = urldecode($month_of);
		// Fetch data from model
		try {
			$data['reports'] = $this->jahez_model->daywise_performance($keyword, $rider_id, $month_of, $team);
		} catch (Exception $e) {
			log_message('error', 'Error fetching performance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}
		//dd($data['reports']);
		// Get team name
		if ($team) {
			$team_name_query = $this->db->select('name')->from('hunger_team')->where('name', $team)->get();
			$team_name = $team_name_query->row() ? $team_name_query->row()->name : '';
		} else {
			$team_name = '';
		}

		// Prepare data for the PDF
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['team_name'] = $team_name ? htmlspecialchars($team_name) : 'ALL';
		$data['search_month'] = $month_of ? htmlspecialchars($month_of) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		// Create PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Daily Performance Report');
		$pdf->SetSubject('Daily Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Daily Performance Report');

		// Remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/jahez/print/jahez_daywise_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/jahez/print/jahez_daywise_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/jahez/print/footer', $data, true);
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
		$pdf->AddPage('L', 'A3');
		$pdf->setRTL(false);
		$pdf->SetFont('aealarabiya', '', 10);
		// Load and write content
		$htmlcontent = $this->load->view('admin/logistic-management/jahez/print/jahez_daywise_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		// Output PDF
		$filename = $month_of
			? 'BS-Jahez-Daywise-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-Jahez-Daywise-Report.pdf';
		$pdf->Output($filename, 'I');
	}
	
	public function print_weekly_report()
	{
		$this->load->library('Pdf_hunger_report2');
		if (!empty($this->input->get('filter_keyword'))) {
			$keyword = $this->input->get('filter_keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('filter_rider_id'))) {
			$rider_id = $this->input->get('filter_rider_id');
		} else {
			$rider_id = FALSE;
		}
		if (!empty($this->input->get('team'))) {
			$team = $this->input->get('team');
		} else {
			$team = FALSE;
		}
		$week = $this->input->get('week');
		if (!$week) {
			// If no week is provided, default to the current week
			$week = date('Y-W');
		}

		try {
			// Get the start and end date of the selected week
			$date_range = $this->get_start_and_end_date($week);

			// Get the weekly deliveries report data for the selected week
			$data['weekly_report'] = $this->jahez_model->get_weekly_deliveries_report($keyword, $rider_id, $team, $date_range['start_date'], $date_range['end_date']);
			$data['search_keyword'] = $keyword;
			$data['search_rider_id'] = $rider_id;
			$data['search_start_date'] = ($date_range['start_date']) ? date("d M Y", strtotime($date_range['start_date'])) : 'NA';
			$data['search_end_date'] = ($date_range['end_date']) ? date("d M Y", strtotime($date_range['end_date'])) : 'NA';
			$data['admin'] = 'Amanullah Kazi';
			//dd($data['weekly_report']);
			if ($team) {
				$team_name = $team;
			} else {
				$team_name = '';
			}
			$data['team_name'] = $team_name;
			// create new PDF document
			$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Jahez Weekly Report');
			$pdf->SetSubject('BS - Jahez Weekly Report');
			$pdf->SetKeywords('Baqala Station, PDF, Jahez Weekly Report');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/logistic-management/jahez/print/jahez_weekly_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/logistic-management/jahez/print/jahez_weekly_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/employed_riders/delivery-summary/print/footer', $data, true);
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
			$pdf->SetMargins(4, 30, 8, true);

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
			$pdf->AddPage('P', 'A4');
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 8);

			$htmlcontent = $this->load->view('admin/logistic-management/jahez/print/jahez_weekly_report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			if ($week) {
				$pdf->Output('BS-Jahez-Weekly-Report-From ' . date('d M Y', strtotime($data['search_start_date'])) . ' To ' . date('d M Y', strtotime($data['search_end_date'])) . '.pdf', 'I');
			} else {
				$pdf->Output('BS-Jahez-Weekly-Report.pdf', 'I');
			}
			// Pass the selected week back to the view for the filter
			//$data['selected_week'] = $week;

			// Load the view and pass the data
			//$this->load->view('admin/logistic-management/hunger/weekly_report', $data);
		} catch (Exception $e) {
			// Handle exceptions (e.g., invalid week format)
			echo "Error: " . $e->getMessage();
		}
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
	
	public function print_monthly_performance()
	{
		$this->load->library('Pdf_hunger_report2');
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
		if (!empty($this->input->get('team'))) {
			$team = $this->input->get('team');
		} else {
			$team = FALSE;
		}
		$data['reports'] = $this->jahez_model->monthly_performance($keyword, $rider_id, $start_date, $end_date, $team);
		if ($team) {
			$team_name = $query = $this->db->query("SELECT `name`, `ar_name` FROM `hunger_team`")->row()->name;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($data['reports'], true) . '</pre>';exit();
		$data['search_keyword'] = $keyword;
		$data['search_rider_id'] = $rider_id;
		$data['team_name'] = $team_name;
		$data['search_start_date'] = ($start_date) ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['search_end_date'] = ($end_date) ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Performance Report');
		$pdf->SetSubject('Monthly Performance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Performance Report');
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/jahez/print/jahez_monthly_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/jahez/print/jahez_monthly_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/jahez/print/footer', $data, true);
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
		$pdf->SetMargins(4, 60, 4, true);

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
		$pdf->AddPage('P', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-management/jahez/print/jahez_monthly_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		if ($start_date && $end_date) {
			$pdf->Output('BS-Jahez-Monthly-Report ' . $data['search_start_date'] . '.pdf', 'I');
		} else {
			$pdf->Output('BS-Jahez-Monthly-Report.pdf', 'I');
		}
	}
}
