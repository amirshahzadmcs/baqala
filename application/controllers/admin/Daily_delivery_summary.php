<?php defined('BASEPATH') or exit('No direct script access allowed');

class Daily_delivery_summary extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Dailydelivery_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/unauthorized');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
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
			if ($this->admin->getInfo()) {
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			} else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
			if ($startDate && $endDate) {
				$data['results'] = $this->Dailydelivery_model->get_summary($riderFilter, $startDate, $endDate);
			} else {
				$data['results'] = array();
			}
			//echo '<pre>';print_r($data['results']);exit();
			$this->load->view('admin/delivery-summary/list', $data);
		} else {
			redirect('admin/unauthorized');
		}
	}

	public function get_list()
	{
		$data['results'] = $this->Dailydelivery_model->get_list();
		echo json_encode($data);
	}

	public function form()
	{
		if ($this->input->get('id')) {
			$query = $this->Dailydelivery_model->get_detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['company_id'] = $query->company_id;
				$data['rider_id'] = $query->rider_id;
				$data['orders'] = $query->orders;
				$data['total_earning'] = $query->total_earning;
				$data['traffic_fine'] = $query->traffic_fine;
				$data['wallet_received'] = $query->wallet_received;
				$data['cash_received'] = $query->cash_received;
				$data['pos_received'] = $query->pos_received;
				$data['stcpay'] = $query->stcpay;
				$data['stcpaym'] = $query->stcpaym;
				$data['delivery_date'] = $query->delivery_date;
				$data['fuel_topup'] = $query->fuel_topup;
				$data['hunger_topup'] = $query->hunger_topup;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['company_id'] = "";
			$data['rider_id'] = "";
			$data['orders'] = "";
			$data['total_earning'] = "";
			$data['traffic_fine'] = "";
			$data['wallet_received'] = "";
			$data['cash_received'] = "";
			$data['pos_received'] = "";
			$data['stcpay'] = "";
			$data['stcpaym'] = "";
			$data['delivery_date'] = "";
			$data['fuel_topup'] = "";
			$data['hunger_topup'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/delivery-summary/add', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('company_id', 'Company Name', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate', 'Duplicate entry for this date, Try new');
		$this->form_validation->set_rules('rider_id', 'Select Rider', 'trim|required');
		$this->form_validation->set_rules('cash_received', 'Cash', 'trim|required');
		$this->form_validation->set_rules('pos_received', 'POS', 'trim|required');
		$this->form_validation->set_rules('stcpay', 'StcPay', 'trim|required');
		$this->form_validation->set_rules('stcpaym', 'StcPayM', 'trim|required');
		$this->form_validation->set_rules('orders', 'Orders', 'trim|required');
		$this->form_validation->set_rules('total_earning', 'Total Earning', 'trim|required');
		$this->form_validation->set_rules('traffic_fine', 'Traffic Fine', 'trim|required');
		$this->form_validation->set_rules('id_fine', 'ID Fine', 'trim|required');
		$this->form_validation->set_rules('wallet_received', 'Wallet Payment', 'trim|required');
		$this->form_validation->set_rules('delivery_date', 'Delivery Date', 'trim|required');
		$this->form_validation->set_rules('fuel_topup', 'Fuel', 'trim|required');
		$this->form_validation->set_rules('hunger_topup', 'Hunger Topup', 'trim|required');
		$this->form_validation->set_rules('online_hrs', 'Online Hours', 'trim|required');
		$this->form_validation->set_rules('online_min', 'Online Minutes', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			//print_r($this->input->post());exit();
			//$total_sum = $this->input->post('cash_received') + $this->input->post('pos_received') + $this->input->post('stcpay') + $this->input->post('stcpaym') + $this->input->post('wallet_received');
			if ($this->input->post('total_earning') >= 0) {
				$query = $this->Dailydelivery_model->add();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully done");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			} else {
				$this->session->set_userdata('info', "2--Total earning should not zero!!!");
			}
		}
		redirect('admin/daily-delivery-summary/list');
	}

	public function check_duplicate()
	{
		$company_id = $this->input->post('company_id');
		$rider_id = $this->input->post('rider_id');
		$delivery_date = $this->input->post('delivery_date');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Dailydelivery_model->check_duplicate($company_id, $rider_id, $delivery_date);
		//print_r($sku_check);exit();
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function view_detail_summary()
	{
		$this->form_validation->set_rules('fdco_id', 'FDC ID', 'trim|required');
		$this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$is_available = $this->Dailydelivery_model->summary_detail_availbility();
			if ($is_available) {
				$data = $this->Dailydelivery_model->get_quick_detail();
				$output_data = $this->load->view('admin/delivery-summary/quick-view-detail', $data, TRUE);
			} else {
				$data = $this->Dailydelivery_model->get_quick_basic_detail();
				$output_data = $this->load->view('admin/delivery-summary/quick-view', $data, TRUE);
			}

			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}

	public function view_userwise_summary()
	{
		$this->form_validation->set_rules('rider_id', 'Rider ID', 'trim|required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('end_date', 'End Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$rider_id = $this->input->post('rider_id');
			$startDate = $this->input->post('start_date');
			$endDate = $this->input->post('end_date');
			$data['result'] = $this->Dailydelivery_model->get_summary_detail($rider_id, $startDate, $endDate);
			$data['rider_id'] = $rider_id;
			$data['start_date'] = $startDate;
			$data['end_date'] = $endDate;
			$output_data = $this->load->view('admin/delivery-summary/quick-view-userwise', $data, TRUE);

			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}

	public function add_detail_summary()
	{
		$this->form_validation->set_rules('fdco_id', 'FDC ID', 'trim|required');
		$this->form_validation->set_rules('entry_date', 'Entry Date', 'trim|required');
		$this->form_validation->set_rules('ref_id[]', 'Reference ID', 'trim|required');
		$this->form_validation->set_rules('collection_amt[]', 'Collection Amount', 'trim|required');
		$this->form_validation->set_rules('free_order_count[]', 'Free Order Count', 'trim|required');
		$this->form_validation->set_rules('driver_credit[]', 'Driver Credit', 'trim|required');
		$this->form_validation->set_rules('driver_debit[]', 'Driver Debit', 'trim|required');
		$this->form_validation->set_rules('service_deduction[]', 'Service Deduction', 'trim|required');
		$this->form_validation->set_rules('driver_tips[]', 'Driver Tips', 'trim|required');
		$this->form_validation->set_rules('settled_by[]', 'Settled By', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$output_data['success'] = '0';
			$output_data['message'] = validation_errors();
		} else {
			$is_available = $this->Dailydelivery_model->summary_detail_availbility();
			if ($is_available) {
				$output_data['success'] = '0';
				$output_data['message'] = 'Already submitted.';
			} else {
				$query = $this->Dailydelivery_model->add_detail();
				//print_r($query);exit();
				if ($query) {
					$output_data['success'] = '1';
					$output_data['message'] = 'Summary successfully added';
				} else {
					$output_data['success'] = '0';
					$output_data['message'] = 'Something went wrong, try again';
				}
			}
		}
		echo json_encode($output_data);
	}

	public function edit_detail_summary()
	{
		$id = $this->input->get('fdc');
		if ($id > 0) {
			$data['result'] = $this->Dailydelivery_model->single_summary_detail($id);
			//echo '<pre>';print_r($data);exit();
			$this->load->view('admin/delivery-summary/edit-summary', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!!!");
			redirect('admin/daily-delivery-summary/list');
		}
	}

	public function edit()
	{
		$this->form_validation->set_rules('id', 'Order ID', 'trim|required');
		$this->form_validation->set_rules('cash_received', 'Cash', 'trim|required');
		$this->form_validation->set_rules('pos_received', 'POS', 'trim|required');
		$this->form_validation->set_rules('stcpay', 'StcPay', 'trim|required');
		$this->form_validation->set_rules('stcpaym', 'StcPayM', 'trim|required');
		$this->form_validation->set_rules('total_earning', 'Total Earning', 'trim|required');
		$this->form_validation->set_rules('traffic_fine', 'Traffic Fine', 'trim|required');
		$this->form_validation->set_rules('id_fine', 'ID Fine', 'trim|required');
		$this->form_validation->set_rules('wallet_received', 'Wallet Payment', 'trim|required');
		$this->form_validation->set_rules('fuel_topup', 'Fuel', 'trim|required');
		$this->form_validation->set_rules('hunger_topup', 'Hunger Topup', 'trim|required');
		$this->form_validation->set_rules('online_hrs', 'Online Hours', 'trim|required');
		$this->form_validation->set_rules('online_min', 'Online Minutes', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$id = $this->input->post('id');
			$this->session->set_userdata('info', "2--" . validation_errors());
			if ($id > 0) {
				redirect('admin/daily-delivery-summary/edit-detail-summary?fdc=' . $id);
			}
		} else {
			//print_r($this->input->post());exit();
			if ($this->input->post('total_earning') >= 0) {
				$query = $this->Dailydelivery_model->edit();
				if ($query) {
					$id = $this->input->post('id');
					$this->session->set_userdata('info', "1--Successfully updated");
					redirect('admin/daily-delivery-summary/edit-detail-summary?fdc=' . $id);
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			} else {
				$this->session->set_userdata('info', "2--Total earning should not zero!!!");
			}
		}
		redirect('admin/daily-delivery-summary/list');
	}

	public function edit_detail()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('fdc_id', 'Order ID', 'trim|required');
		$this->form_validation->set_rules('ref_id', 'Reference ID', 'trim|required');
		$this->form_validation->set_rules('collection_amt', 'Collection Amount', 'trim|required');
		$this->form_validation->set_rules('free_order_count', 'Free Order Count', 'trim|required');
		$this->form_validation->set_rules('driver_credit', 'Driver Credit', 'trim|required');
		$this->form_validation->set_rules('driver_debit', 'Driver Debit', 'trim|required');
		$this->form_validation->set_rules('service_deduction', 'Service Deduction', 'trim|required');
		$this->form_validation->set_rules('driver_tips', 'Driver Tips', 'trim|required');
		$this->form_validation->set_rules('settled_by', 'Settled By', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$fdc_id = $this->input->post('fdc_id');
			$this->session->set_userdata('info', "2--" . validation_errors());
			if ($fdc_id > 0) {
				redirect('admin/daily-delivery-summary/edit-detail-summary?fdc=' . $fdc_id);
			}
		} else {
			$query = $this->Dailydelivery_model->edit_detail();
			if ($query) {
				$fdc_id = $this->input->post('fdc_id');
				$this->session->set_userdata('info', "1--Summary detail successfully updated");
				redirect('admin/daily-delivery-summary/edit-detail-summary?fdc=' . $fdc_id);
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/daily-delivery-summary/list');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Dailydelivery_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/daily-delivery-summary/list');
	}

	public function print_summary()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_summary', $this->action)) {
			redirect('admin/unauthorized-request');
		}
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
			$data['results'] = $this->Dailydelivery_model->get_summary($riderFilter, $startDate, $endDate);
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
			$htmlHeader = $this->load->view('admin/delivery-summary/header-footer/invoice_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/delivery-summary/header-footer/invoice_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/delivery-summary/header-footer/footer_last', $data, true);
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
			$htmlcontent = $this->load->view('admin/delivery-summary/print-summary', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS - Daily Delivery Summary From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)) . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Select valid date!");
			redirect('admin/daily-delivery-summary/list');
		}
	}

	public function print_detail_summary()
	{
		$this->load->library('Pdf_mobile_invoice');
		if (!empty($this->input->get('rider_id'))) {
			$rider_id = $this->input->get('rider_id');
		} else {
			$rider_id = FALSE;
		}
		if (!empty($this->input->get('company_id'))) {
			$company_id = $this->input->get('company_id');
		} else {
			$company_id = FALSE;
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
		if ($rider_id && $company_id && $startDate && $endDate) {
			$data['results'] = $this->Dailydelivery_model->get_fdco_detail($rider_id, $company_id, $startDate, $endDate);
			$data['admin'] = 'Amanullah Kazi';
			$data['start'] = date('d M Y', strtotime($startDate));
			$data['end'] = date('d M Y', strtotime($endDate));
			//echo '<pre>';print_r($data);exit();
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
			$htmlHeader = $this->load->view('admin/delivery-summary/header-footer/detail_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/delivery-summary/header-footer/detail_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/delivery-summary/header-footer/footer_last', $data, true);
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
			$pdf->SetMargins(4, 60, 4, true);

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
			$htmlcontent = $this->load->view('admin/delivery-summary/print-detail', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS - Daily Delivery Summary From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)) . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Select valid date!");
			redirect('admin/daily-delivery-summary/list');
		}
	}
}
