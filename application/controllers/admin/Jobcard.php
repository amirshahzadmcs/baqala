<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jobcard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Jobcard_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
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
		$data['vehicles_list'] = $this->Jobcard_model->get_vehicles();
		$data['riders_list'] = $this->Jobcard_model->get_jobcard_vehicles();
		//print_r($data['vehicles_list']);exit();
		$this->load->view('admin/job-card/list', $data);
	}

	public function create_job()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Get bike_no from the post data
		$bike_no = $this->input->post('bike_no');

		// Check if the vehicle exists in master_vehicles
		$this->db->select('alloted_user');
		$this->db->from('master_vehicles');
		$this->db->where('vehicle_no', $bike_no);
		$vehicle_query = $this->db->get();

		// Check if vehicle exists
		if ($vehicle_query->num_rows() > 0) {
			$vehicle = $vehicle_query->row();
			$alloted_user = $vehicle->alloted_user;

			$query = $this->Jobcard_model->createJob($alloted_user);

			if ($query) {
				$job_id = $this->db->insert_id();
				$this->session->set_userdata('info', "1--Job successfully created, add job detail!!!");
				redirect("admin/job-card/add?id=" . $job_id);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
				redirect("admin/job-card/list");
			}
		} else {
			$this->session->set_userdata('info', "2--Vehicle not found, please check the vehicle number!!!");
			redirect("admin/job-card/list");
		}
	}

	public function form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data = $this->Jobcard_model->get_job_detail($this->input->get('id'));
			$this->load->view('admin/job-card/edit-form', $data);
		} else {
			$this->load->view('admin/job-card/list');
		}
	}

	public function update_job()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('job_id', 'Job ID', 'trim|required');
		$this->form_validation->set_rules('item_code[]', 'Item Code', 'trim|required');
		$this->form_validation->set_rules('spare_part_name[]', 'Spare Part Name', 'trim|required');
		$this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('cost[]', 'Cost', 'trim|required');
		$this->form_validation->set_rules('item_id[]', 'Item ID', 'trim|required');
		$this->form_validation->set_rules('line_amount[]', 'Item Total', 'trim|required');
		$this->form_validation->set_rules('sub_total', 'Sub Total', 'trim|required');
		$this->form_validation->set_rules('sale_tax', 'Sales Tax', 'trim|required');
		$this->form_validation->set_rules('sale_tax_amt', 'Sales Tax Amt', 'trim|required');
		$this->form_validation->set_rules('shipping_handling', 'Shipping Handling', 'trim|required');
		$this->form_validation->set_rules('total', 'Total Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('job_id')) {
				$query = $this->Jobcard_model->edit();
				//print_r($query);exit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully done");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/job-card/list');
	}

	public function get_list()
	{
		if (!empty($this->input->get('vehicle_filter'))) {
			$vehicleFilter = $this->input->get('vehicle_filter');
		} else {
			$vehicleFilter = FALSE;
		}
		if (!empty($this->input->get('job_number'))) {
			$job_number = $this->input->get('job_number');
		} else {
			$job_number = FALSE;
		}
		if (!empty($this->input->get('rider_name'))) {
			$rider_name = $this->input->get('rider_name');
		} else {
			$rider_name = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$startDate = $this->input->get('from');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$endDate = $this->input->get('to');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('job_type'))) {
			$job_type = $this->input->get('job_type');
		} else {
			$job_type = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		$fetch_data = $this->Jobcard_model->get_list($vehicleFilter, $job_number, $startDate, $endDate, $job_type, $rider_name, $status);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $job) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = 'JC-' . invoiceNmFormat($job->id);
			$sub_array[] = date("d-m-Y", strtotime($job->job_date));
			$sub_array[] = $job->job_type;
			$sub_array[] = $job->rider_name;
			$sub_array[] = $job->bike_no;
			$sub_array[] = $job->vehicle_year;
			$sub_array[] = $job->vehicle_make;
			$sub_array[] = $job->vehicle_type;
			$sub_array[] = round($job->meter_reading, 2);
			$sub_array[] = $job->total . ' SAR';
			$sub_array[] = $job->status == 'open' ? '<span class="badge badge-pill badge-soft-warning font-size-13">Open</span>' : '<span class="badge badge-pill badge-soft-success font-size-13">Closed</span>';
			$sub_array[] = (check_action_permission(get_user_role(), 'job_cards', 'print_invoice') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="' . base_url() . 'admin/job-card/print-invoice?id=' . $job->id . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'job_cards', 'purchase_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/job-card/detail?id=' . $job->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Jobcard_model->get_all_data(),
			"recordsFiltered"     =>     $this->Jobcard_model->get_filtered_data($vehicleFilter, $job_number, $startDate, $endDate, $job_type, $rider_name, $status),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function vehicle_detail()
	{
		$id = $this->input->get('id');
		$output = $this->Jobcard_model->get_vehicle_detail($id);
		echo json_encode($output);
	}

	public function purchase_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data = $this->Jobcard_model->get_job_detail($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/job-card/detail', $data);
	}

	public function lock_job()
	{
		$job_id = $this->input->get('id');
		if ($job_id > 0) {
			$query = $this->Jobcard_model->lockJob($job_id);
			if ($query) {
				$this->session->set_userdata('info', "1--Job card successfully locked!");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid job card!");
		}
		redirect("admin/job-card/detail?id=" . $job_id);
	}

	public function setStatusEnable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Jobcard_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/job-card/list');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Jobcard_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/job-card/list');
		} else {
			redirect('admin');
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Jobcard_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/job-card/list');
	}

	/*------ Search product -----*/
	public function get_search_list()
	{
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Jobcard_model->get_search_hint($data['term']);
		echo json_encode($data);
	}

	public function print_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_jobcard');
		$id = $this->input->get('id');
		$order = $this->Jobcard_model->get_job_detail($id);
		//print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_jobcard(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Job Card/Cash Memo');
		$pdf->SetSubject('Job Card Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/job-card/invoice_header', $order, true);
		$htmlHeader2 = $this->load->view('admin/job-card/invoice_header2', $order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/job-card/footer_last', $order, true);
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
		$pdf->SetMargins(0, 60, 0, true);

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
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/job-card/print_invoice', $order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('Job Card ' . $order['order']->id . '.pdf', 'I');
	}

	public function report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!empty($this->input->get('vehicle_filter'))) {
			$vehicleFilter = $this->input->get('vehicle_filter');
		} else {
			$vehicleFilter = FALSE;
		}
		if (!empty($this->input->get('job_number'))) {
			$job_number = $this->input->get('job_number');
		} else {
			$job_number = FALSE;
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
		if (isset($_GET['vehicle_filter'])) {
			$job_cards = $this->Jobcard_model->get_report($vehicleFilter, $job_number, $startDate, $endDate);
			if ($job_cards) {
				$data['results'] = $job_cards;
			} else {
				$data['results'] = array();
			}
		} else {
			$data['results'] = array();
		}
		$data['riders_list'] = $this->Jobcard_model->get_jobcard_vehicles();
		//echo '<pre>';print_r($data['results']);exit();
		$this->load->view('admin/job-card/job-report', $data);
	}

	public function print_report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'job_cards', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_jcard_report');
		if (!empty($this->input->get('vehicle_filter'))) {
			$vehicleFilter = $this->input->get('vehicle_filter');
		} else {
			$vehicleFilter = FALSE;
		}
		if (!empty($this->input->get('job_number'))) {
			$job_number = $this->input->get('job_number');
		} else {
			$job_number = FALSE;
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
		if (isset($_GET['vehicle_filter'])) {
			$data['results'] = $this->Jobcard_model->get_report($vehicleFilter, $job_number, $startDate, $endDate);
			$data['admin'] = 'Amanullah Kazi';
			$data['start'] = date('d M Y', strtotime($startDate));
			$data['end'] = date('d M Y', strtotime($endDate));
			//echo '<pre>';print_r($data);exit();
			// create new PDF document
			$pdf = new Pdf_jcard_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Job Card Report');
			$pdf->SetSubject('BS - Job Card Report');
			$pdf->SetKeywords('Baqala Station, PDF, Job Card Report');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/job-card/header-footer/invoice_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/job-card/header-footer/invoice_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/job-card/header-footer/footer_last', $data, true);
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
			$pdf->SetMargins(4, 65, 4, true);

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
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/job-card/print-report', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$date_n = date('d-m-y-' . substr((string)microtime(), 1, 8));
			$date_n = str_replace(".", "", $date_n);
			$pdf->Output('BS - Job Card Report - ' . $date_n . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Select valid filter!");
			redirect('admin/job-card/report');
		}
	}
}
