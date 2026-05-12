<?php defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Purchase_model');
			$this->load->model('admin/Vendor_model');
			$this->load->model('admin/Grv_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}
	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_order_invoice', $this->action)) {
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
		$data['vendor_list'] = $this->Purchase_model->get_vendors();
		$this->load->view('admin/purchase_order/list', $data);
	}

	public function create_order()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_order_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$order_id = $this->Purchase_model->createPurchase();
		if ($order_id > 0) {
			redirect("admin/purchase/add?id=" . $order_id);
		} else {
			$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			redirect("admin/purchase/list");
		}
	}

	public function form()
	{
		if ($this->input->get('id')) {
			$data = $this->Purchase_model->get_order_detail($this->input->get('id'));
			$this->load->view('admin/purchase_order/edit-form', $data);
		} else {
			$this->load->view('admin/purchase_order/list');
		}
	}

	public function edit_form()
	{
		if ($this->input->get('id')) {
			$data = $this->Purchase_model->get_order_detail($this->input->get('id'));
			$this->load->view('admin/purchase_order/edit-form', $data);
		} else {
			$this->load->view('admin/purchase_order/list');
		}
	}

	public function add_order()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('id', 'PO ID', 'trim|required');
		$this->form_validation->set_rules('vendor_id', 'Select Vendor', 'trim|required');
		$this->form_validation->set_rules('prod_id[]', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('size_id[]', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('item_description[]', 'Items Description', 'trim|required');
		$this->form_validation->set_rules('unit_price[]', 'Unit Price', 'trim|required');
		$this->form_validation->set_rules('item_sku[]', 'Item SKU', 'trim|required');
		$this->form_validation->set_rules('item_unit[]', 'Item Unit', 'trim|required');
		$this->form_validation->set_rules('item_total[]', 'Item Total', 'trim|required');
		$this->form_validation->set_rules('sub_total', 'Sub Total', 'trim|required');
		$this->form_validation->set_rules('sale_tax', 'Sales Tax', 'trim|required');
		$this->form_validation->set_rules('sale_tax_amt', 'Sales Tax Amt', 'trim|required');
		$this->form_validation->set_rules('shipping_handling', 'Shipping Handling', 'trim|required');
		$this->form_validation->set_rules('total', 'Total Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Purchase_model->edit();
			} else {
				$query = $this->Purchase_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/purchase/list');
	}

	public function get_list()
	{
		$fetch_data = $this->Purchase_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $order) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $order->invoice_prefix . '-' . $order->po_number;
			$sub_array[] = ($order->reference !== '') ? $order->reference : 'NA';
			$sub_array[] = date("d-m-Y", strtotime($order->po_date));
			$sub_array[] = 'NULL';
			$sub_array[] = $order->vendor_name;
			$sub_array[] = $order->total . ' SAR';
			$sub_array[] = ($order->status == 1) ? '<span class="badge badge-pill badge-soft-warning font-size-13">Pending</span>' : (($order->status == 2) ? '<span class="badge badge-pill badge-soft-info font-size-13">Accepted</span>' : (($order->status == 3) ? '<span class="badge badge-pill badge-soft-success font-size-13">Approved</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>'));
			$sub_array[] = $order->created_by;
			$sub_array[] = (check_action_permission(get_user_role(), 'purchase_order_invoice', 'print_invoice') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="' . base_url() . 'admin/purchase_order/print_invoice?id=' . $order->id . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'purchase_order_invoice', 'purchase_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/purchase_order/purchase_detail?id=' . $order->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Purchase_model->get_all_data(),
			"recordsFiltered"     =>     $this->Purchase_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function vendor_detail()
	{
		$id = $this->input->get('id');
		$output = $this->Purchase_model->get_vendor_detail($id);
		echo json_encode($output);
	}

	public function purchase_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_order_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data = $this->Purchase_model->get_order_detail($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/purchase_order/detail', $data);
	}

	public function setStatusEnable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Purchase_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/purchase/list');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Purchase_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/purchase/list');
		} else {
			redirect('admin');
		}
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Purchase_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/purchase/list');
	}

	/*------ Search product -----*/
	public function get_search_list()
	{
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Purchase_model->get_search_hint($data['term']);
		echo json_encode($data);
	}

	public function print_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_order_invoice', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_purchase');
		$id = $this->input->get('id');
		$order = $this->Purchase_model->get_order_detail($id);
		//print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_purchase(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Purchase Order/Cash Memo');
		$pdf->SetSubject('Purchase Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/purchase_order/invoice_header', $order, true);
		$htmlHeader2 = $this->load->view('admin/purchase_order/invoice_header2', $order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/purchase_order/footer_last', $order, true);
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
		$pdf->SetMargins(12, 60, 5, true);

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
		$htmlcontent = $this->load->view('admin/purchase_order/print_invoice', $order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('Purchase Order ' . $order['order']->po_number . '.pdf', 'I');
	}
}
