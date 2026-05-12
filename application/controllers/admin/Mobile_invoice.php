<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mobile_invoice extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/MobInvoice_model', 'invoice_model');
			$this->load->model('admin/Sim_model');
			$this->load->model('admin/Plan_model');
			$this->load->model('admin/Network_model');
			$this->load->library('form_validation');
			$this->load->helper('text');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sim_invoices', $this->action)):
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
		$data['inv_count'] = $this->db->query("SELECT id FROM mobile_invoice")->num_rows();
		$data['emp_list'] = $this->invoice_model->get_inv_emp_list();
		$data['networks'] = $this->Network_model->get_list()->result();
		$data['inv_sim_list'] = $this->invoice_model->get_inv_sim_list();
		$data['plans'] = $this->Plan_model->get_list()->result();
		$data['sims'] = $this->invoice_model->get_sims();
		//print_r($data['sims']);exit();
		$this->load->view('admin/mobile-invoice/list', $data);
	}

	public function get_list()
	{
		if (!empty($this->input->get('period_start'))) {
			$startDate = $this->input->get('period_start');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('period_end'))) {
			$endDate = $this->input->get('period_end');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('inv_no'))) {
			$inv_no = $this->input->get('inv_no');
		} else {
			$inv_no = FALSE;
		}
		if (!empty($this->input->get('sim_no'))) {
			$sim_no = $this->input->get('sim_no');
		} else {
			$sim_no = FALSE;
		}
		if (!empty($this->input->get('network'))) {
			$network = $this->input->get('network');
		} else {
			$network = FALSE;
		}
		if (!empty($this->input->get('is_gps_sim'))) {
			$is_gps_sim = $this->input->get('is_gps_sim');
		} else {
			$is_gps_sim = FALSE;
		}
		if (!empty($this->input->get('plan'))) {
			$plan = $this->input->get('plan');
		} else {
			$plan = FALSE;
		}
		if (!empty($this->input->get('owner'))) {
			$owner = $this->input->get('owner');
		} else {
			$owner = FALSE;
		}
		if (!empty($this->input->get('user'))) {
			$user = $this->input->get('user');
		} else {
			$user = FALSE;
		}
		if (!empty($this->input->get('is_gps_sim'))) {
			$is_gps_sim = $this->input->get('is_gps_sim');
		} else {
			$is_gps_sim = FALSE;
		}
		$fetch_data = $this->invoice_model->get_list($inv_no, $sim_no, $network, $plan, $owner, $startDate, $endDate, $user, $is_gps_sim);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$pre_bal = $item->previous_bal;
			$total = ($item->fee + $item->off_plan + $item->add_on) - ($item->adjustment + $item->discount);
			$final_amt = $total + (($total * 15) / 100) + $pre_bal;
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->invoice_no;
			$sub_array[] = $item->mobile . ' (' . $item->sim_no . ')';
			$sub_array[] = date('M, Y', strtotime($item->period));
			$sub_array[] = $item->network_name;
			$sub_array[] = (($item->is_gps_sim == 'on') ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span><br>' : '<span class="badge badge-pill badge-soft-dark font-size-13">No</span>') . '<br>' . (($item->gps_installed_vehicle !== '') ? vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_no . ' ' . vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_type : '');
			$sub_array[] = $item->plan_name;
			$sub_array[] = (($item->first_name !== '') ? $item->first_name : '') . (($item->middle_name !== '') ? ' ' . $item->middle_name : '') . (($item->third_name !== '') ? ' ' . $item->third_name : '') . (($item->surname !== '') ? ' ' . $item->surname : '');
			$sub_array[] = bcdiv($item->total_amount, 1, 2);
			$sub_array[] = ($item->status == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Paid</span><br>' : '<span class="badge badge-pill badge-soft-dark font-size-13">Unpaid</span>';
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			if ($item->date_of_payment == '') {
				$pay_button = check_action_permission(get_user_role(), 'sim_invoices', 'update_payment') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Update Payment" data-id="' . $item->id . '" onclick="paymentPopup(this)"><i class="mdi mdi-checkbox-multiple-marked-circle-outline font-size-18"></i></a>' : '';
			} else {
				$pay_button = '';
			}
			$sub_array[] = (check_action_permission(get_user_role(), 'sim_invoices', 'sim_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/mobile-invoice/detail?id=' . $item->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a> ' : '') . $pay_button;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->invoice_model->get_all_data(),
			"recordsFiltered" => $this->invoice_model->get_filtered_data($inv_no, $sim_no, $network, $plan, $owner, $startDate, $endDate, $user, $is_gps_sim),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function edit_sim()
	{
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$query = $this->invoice_model->get_detail($id);
			$data['attachment'] = $this->invoice_model->get_docs($id);
		} else {
		}
		$data['sims'] = $this->invoice_model->get_sims();
		// print_r($data['sims']);die();
		$this->load->view('admin/mobile-invoice/form', $data);
	}

	public function get_sim_detail()
	{
		$this->form_validation->set_rules('id', 'Sim ID', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Select valid sim card.</span>";
		} else {
			$id = $this->input->post('id');
			$sim_detail = $this->invoice_model->get_sim_detail($id);
			if (!empty($sim_detail)) {
				$data['status'] = 'success';
				$data['sim_detail'] = $sim_detail;
				$data['msg'] = "<span style='color:green;'>Sim detail successfully fetched.</span>";
			} else {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'>Sim detail not available.</span>";
			}
		}
		echo json_encode($data);
	}

	public function save_sim()
	{
		if($this->action && !check_action_permission(get_user_role(), 'sim_invoices', $this->action)):
			redirect('admin/unauthorized-request');
			endif; 
		$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|callback_check_invoiceno', array('check_invoiceno' => 'Duplicate Invoice Number, Try new'));
		$this->form_validation->set_message('check_invoiceno', 'Duplicate Invoice Number, Try new');
		$this->form_validation->set_rules('sim_id', 'Sim Number', 'trim|required');
		$this->form_validation->set_rules('fee', 'Monthly Fee', 'trim|required');
		$this->form_validation->set_rules('period', 'Period', 'trim|required');
		$this->form_validation->set_rules('total_amount', 'Total Amount', 'trim|required');
		//$this->form_validation->set_rules('period', 'Period', 'trim|required|callback_validate_invoice');
		//$this->form_validation->set_message('valid_validate_invoice','Invoice already exists for this month, Try new');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->invoice_model->add();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/mobile-invoice/list');
	}

	public function update_sim()
	{
		$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'trim|required|callback_check_invoiceno', array('check_invoiceno' => 'Duplicate Invoice Number, Try new'));
		//$this->form_validation->set_message('valid_check_invoiceno','Duplicate Invoice Number, Try new');
		$this->form_validation->set_rules('sim_id', 'Sim Number', 'trim|required');
		$this->form_validation->set_rules('fee', 'Monthly Fee', 'trim|required');
		$this->form_validation->set_rules('period', 'Period', 'trim|required|callback_validate_invoice');
		$this->form_validation->set_message('valid_validate_invoice', 'Invoice already exists for this month, Try new');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->invoice_model->edit();
			} else {
				$query = $this->invoice_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/mobile-invoice/list');
	}

	public function validate_invoice($period)
	{
		$sim_no = $this->input->post('sim_no');
		$id = $this->input->post('id');
		$date = date('Y-m-01', strtotime($period));
		if (!isset($id)) {
			$id = 0;
		}
		if ($this->invoice_model->check_invoice_exists($sim_no, $period, $id)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function prevoius_invoice()
	{
		$sim_no = $this->input->post('sim_no');
		$id = $this->input->post('id');
		if (!isset($id)) {
			$id = 0;
		}
		if ($this->invoice_model->check_prevoius_paid($sim_no, $id)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_invoiceno($invoice_no)
	{
		$id = $this->input->post('id');
		$group_invoice = $this->input->post('group_invoice');
		if ($group_invoice == 'on') {
			return TRUE;
		} else {
			if (!isset($id)) {
				$id = 0;
			}
			if ($this->invoice_model->check_invoice_no_exists($invoice_no, $id)) {
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function ajax_check_invoiceno()
	{
		$invoice_no = $this->input->get('invoice_no');
		$group_invoice = $this->input->get('group_invoice');
		$id = $this->input->get('id');
		if ($invoice_no !== '') {
			if ($group_invoice == 'yes') {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Group Invoice, Ok.</span>";
			} else {
				// do some database things you need to do e.g.
				$duplicate_check = $this->invoice_model->check_invoice_no_exists($invoice_no, $id);
				if ($duplicate_check > 0) {
					$data['status'] = 'error';
					$data['msg'] = "<span style='color:red;'><b>" . $invoice_no . "</b> Duplicate Invoice No. Try New.</span>";
				} else {
					$data['status'] = 'success';
					$data['msg'] = "<span style='color:green;'>Checked, Ok.</span>";
				}
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Invoice No. is required.</span>";
		}
		echo json_encode($data);
		exit();
	}

	public function ajax_check_invoice()
	{
		$sim_id = $this->input->get('sim_id');
		$id = $this->input->get('id');
		$date = date('Y-m-01', strtotime($this->input->get('period')));
		if ($date !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->invoice_model->check_invoice_exists($sim_id, $date, $id);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $this->input->get('period') . "</b> Already exist for this month. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Checked, Ok.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Bill Period is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_prevoiuse_invoice()
	{
		$sim_id = $this->input->get('sim_id');
		$id = $this->input->get('id');
		if ($sim_id !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->invoice_model->check_prevoius_paid($sim_id, $id);
			if ($duplicate_check) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'>Prevoius bill is unpaid.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Previous bill paid.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Mobile no. is required.</span>";
		}
		echo json_encode($data);
	}

	public function update_payment()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sim_invoices', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('invoice_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('amount_paid', 'Amount Paid', 'trim|required');
		$this->form_validation->set_rules('payment_source', 'Source of Payment', 'trim|required');
		$this->form_validation->set_rules('date_of_payment', 'Date of Payment', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->invoice_model->update_payment();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/mobile-invoice/list');
	}

	public function sim_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sim_invoices', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->invoice_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['invoice_no'] = $query->invoice_no;
			$data['sim_id'] = $query->sim_id;
			$data['period'] = $query->period;
			$data['previous_bal'] = $query->previous_bal;
			$data['fee'] = $query->fee;
			$data['off_plan'] = $query->off_plan;
			$data['add_on'] = $query->add_on;
			$data['adjustment'] = $query->adjustment;
			$data['discount'] = $query->discount;
			$data['installment'] = $query->installment;
			$data['vat_percent'] = $query->vat_percent;
			$data['offplan_deduct_payslip'] = $query->offplan_deduct_payslip;
			$data['addon_deduct_payslip'] = $query->addon_deduct_payslip;
			$data['total_amount'] = $query->total_amount;
			$data['amount_paid'] = $query->amount_paid;
			$data['payment_source'] = $query->payment_source;
			$data['date_of_payment'] = $query->date_of_payment;
			$data['attachment'] = $this->invoice_model->get_docs($this->input->get('id'));
			$data['emp_list'] = $this->invoice_model->get_inv_emp_list();
			$data['inv_sim_list'] = $this->invoice_model->get_inv_sim_list();
			$data['sims'] = $this->Sim_model->get_sims();
			$this->load->view('admin/mobile-invoice/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/mobile-invoice/list');
		}
	}

	public function getPlans()
	{
		$query = $this->invoice_model->get_plan($this->input->get('id'));
		// $p_data = $query;
		// print_r($this->input->get('plan_id'));exit();
		$data = '';
		foreach ($query as $plan) {
			if ($plan->id == $this->input->get('plan_id')) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$data .= '<option value="' . $plan->id . '" ' . $selected . '>' . $plan->plan_name . '</option>';
		}
		echo $data;
	}

	public function delete()
	{
		if($this->action && !check_action_permission(get_user_role(), 'sim_invoices', $this->action)):
			redirect('admin/unauthorized-request');
			endif; 
		$ids = $this->input->post('checklist');
		$query = $this->invoice_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/mobile-invoice/list');
	}

	public function doc_delete()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('item_id', 'Item ID', 'trim|required');
			$this->form_validation->set_rules('img_id', 'Image ID', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array("type" => 'error', "message" => 'Invalid Request Type');
			} else {
				$query = $this->invoice_model->delete_image();
				if ($query) {
					$data = array("type" => 'success', "message" => 'Image successfully deleted');
				} else {
					$data = array("type" => 'error', "message" => 'Something went wrong, Try again');
				}
			}
		} else {
			$data = array("type" => 'error', "message" => 'Session expired, Please login again. <a href="' . base_url('admin') . '" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
	}

	public function print()
	{
		$this->load->library('Pdf_mobile_invoice');
		$id = $this->input->get('id');
		$table = $this->input->get('table');
		$order = $this->invoice_model->get_detail($id, $table);
		// print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_mobile_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Billing Detail For Month - ' . date('M Y', strtotime($order->period)));
		$pdf->SetSubject('BS - Billing Detail For Month - ' . date('M Y', strtotime($order->period)));
		$pdf->SetKeywords('Baqala Station, PDF, Billing Detail');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/mobile-invoice/header/invoice_header', $order, true);
		$htmlHeader2 = $this->load->view('admin/mobile-invoice/header/invoice_header2', $order, true);
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
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(1, 60, 4, true);

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
		$htmlcontent = $this->load->view('admin/mobile-invoice/print_mobile_invoice', $order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('Billing Details For Month ' . date('M Y', strtotime($order->period)) . '.pdf', 'I');
	}

	public function print_report()
	{
		if($this->action && !check_action_permission(get_user_role(), 'sim_invoices', $this->action)):
			redirect('admin/unauthorized-request');
			endif; 
		$this->load->library('Pdf_mobile_invoice');
		$id = $this->input->get('id');
		if (!empty($this->input->get('period_start'))) {
			$startDate = $this->input->get('period_start');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('period_end'))) {
			$endDate = $this->input->get('period_end');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('inv_no'))) {
			$inv_no = $this->input->get('inv_no');
		} else {
			$inv_no = FALSE;
		}
		if (!empty($this->input->get('sim_no'))) {
			$sim_no = $this->input->get('sim_no');
		} else {
			$sim_no = FALSE;
		}
		if (!empty($this->input->get('network'))) {
			$network = $this->input->get('network');
		} else {
			$network = FALSE;
		}
		if (!empty($this->input->get('plan'))) {
			$plan = $this->input->get('plan');
		} else {
			$plan = FALSE;
		}
		if (!empty($this->input->get('owner'))) {
			$owner = $this->input->get('owner');
		} else {
			$owner = FALSE;
		}
		if (!empty($this->input->get('user'))) {
			$user = $this->input->get('user');
		} else {
			$user = FALSE;
		}
		if (!empty($this->input->get('is_gps_sim'))) {
			$is_gps_sim = $this->input->get('is_gps_sim');
		} else {
			$is_gps_sim = FALSE;
		}
		$data['invoice'] = $this->invoice_model->print_report($inv_no, $sim_no, $network, $plan, $owner, $startDate, $endDate, $user, $is_gps_sim);
		$data['start'] = $startDate;
		$data['end'] = $endDate;
		$data['user'] = $user;
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_mobile_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Billing Detail From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)));
		$pdf->SetSubject('BS - Billing Detail From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)));
		$pdf->SetKeywords('Baqala Station, PDF, Billing Detail');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/mobile-invoice/header/invoice_header_2', $data, true);
		$htmlHeader2 = $this->load->view('admin/mobile-invoice/header/invoice_header2_2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/mobile-invoice/footer/footer_last', $data, true);
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
		$pdf->SetMargins(1, 60, 4, true);

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
		$htmlcontent = $this->load->view('admin/mobile-invoice/print_mobile_invoice_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS - Billing Detail From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)) . '.pdf', 'I');
	}

	public function consolidate_report()
	{
		if($this->action && !check_action_permission(get_user_role(), 'invoice_reports', $this->action)):
			redirect('admin/unauthorized-request');
		endif; 
		$this->load->library('Pdf_mobile_invoice');
		if (!empty($this->input->get('period_start'))) {
			$startDate = $this->input->get('period_start');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('period_end'))) {
			$endDate = $this->input->get('period_end');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('inv_no'))) {
			$inv_no = $this->input->get('inv_no');
		} else {
			$inv_no = FALSE;
		}
		if (!empty($this->input->get('sim_no'))) {
			$sim_no = $this->input->get('sim_no');
		} else {
			$sim_no = FALSE;
		}
		if (!empty($this->input->get('network'))) {
			$network = $this->input->get('network');
		} else {
			$network = FALSE;
		}
		if (!empty($this->input->get('plan'))) {
			$plan = $this->input->get('plan');
		} else {
			$plan = FALSE;
		}
		if (!empty($this->input->get('owner'))) {
			$owner = $this->input->get('owner');
		} else {
			$owner = FALSE;
		}
		if (!empty($this->input->get('user'))) {
			$user = $this->input->get('user');
		} else {
			$user = FALSE;
		}
		if (!empty($this->input->get('is_gps_sim'))) {
			$is_gps_sim = $this->input->get('is_gps_sim');
		} else {
			$is_gps_sim = FALSE;
		}
		if ($startDate && $endDate) {
			$data['invoice'] = $this->invoice_model->get_consolidate_plans($inv_no, $sim_no, $network, $plan, $owner, $startDate, $endDate, $user, $is_gps_sim);
			// print_r($data);exit();
		} else {
			$data['invoice'] = array();
		}
		$data['inv_count'] = $this->db->query("SELECT id FROM mobile_invoice")->num_rows();
		$data['emp_list'] = $this->invoice_model->get_inv_emp_list();
		$data['networks'] = $this->Network_model->get_list()->result();
		$data['inv_sim_list'] = $this->invoice_model->get_inv_sim_list();
		$data['plans'] = $this->Plan_model->get_list()->result();
		//print_r($data['emp_list']);exit();
		$this->load->view('admin/mobile-invoice/consolidate_report', $data);
	}

	public function print_consolidate_report()
	{
		if($this->action && !check_action_permission(get_user_role(), 'invoice_reports', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->load->library('Pdf_mobile_consolidate_report');
		$id = $this->input->get('id');
		// $order = $this->invoice_model->get_detail($id);
		// print_r($order);exit();
		if (!empty($this->input->get('period_start'))) {
			$startDate = $this->input->get('period_start');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('period_end'))) {
			$endDate = $this->input->get('period_end');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('inv_no'))) {
			$inv_no = $this->input->get('inv_no');
		} else {
			$inv_no = FALSE;
		}
		if (!empty($this->input->get('sim_no'))) {
			$sim_no = $this->input->get('sim_no');
		} else {
			$sim_no = FALSE;
		}
		if (!empty($this->input->get('network'))) {
			$network = $this->input->get('network');
		} else {
			$network = FALSE;
		}
		if (!empty($this->input->get('plan'))) {
			$plan = $this->input->get('plan');
		} else {
			$plan = FALSE;
		}
		if (!empty($this->input->get('owner'))) {
			$owner = $this->input->get('owner');
		} else {
			$owner = FALSE;
		}
		if (!empty($this->input->get('user'))) {
			$user = $this->input->get('user');
		} else {
			$user = FALSE;
		}
		if (!empty($this->input->get('is_gps_sim'))) {
			$is_gps_sim = $this->input->get('is_gps_sim');
		} else {
			$is_gps_sim = FALSE;
		}
		$data['invoice'] = $this->invoice_model->get_consolidate_plans($inv_no, $sim_no, $network, $plan, $owner, $startDate, $endDate, $user, $is_gps_sim);
		$data['start'] = date('M Y', strtotime($startDate));
		$data['end'] = date('M Y', strtotime($endDate));
		$data['user'] = $user;
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_mobile_consolidate_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Consolidated Report From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)));
		$pdf->SetSubject('BS - Consolidated Report From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)));
		$pdf->SetKeywords('Baqala Station, PDF, Consolidated Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/mobile-invoice/header/invoice_header_2', $data, true);
		$htmlHeader2 = $this->load->view('admin/mobile-invoice/header/invoice_header2_2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/mobile-invoice/footer/footer_last', $data, true);
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
		$pdf->SetMargins(1, 60, 4, true);

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
		$htmlcontent = $this->load->view('admin/mobile-invoice/print_mobile_consolidate_report', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS - Consolidated Report From ' . date('M Y', strtotime($startDate)) . ' To ' . date('M Y', strtotime($endDate)) . '.pdf', 'I');
	}
}
