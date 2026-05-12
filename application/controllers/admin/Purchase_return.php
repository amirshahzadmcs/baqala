<?php defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_return extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Purchase_return_model');
			$this->load->model('admin/Vendor_model');
			$this->load->model('admin/Grv_model');
			$this->load->model('admin/Inventory_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_return', $this->action)) {
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
		$data['grv_list'] = $this->Purchase_return_model->get_grv_list();
		$this->load->view('admin/purchase-return/list', $data);
	}

	public function return_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_return', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('po_id')) {
			$data = $this->Purchase_return_model->get_purchase_detail($this->input->get('po_id'));
			$this->load->view('admin/purchase-return/edit-form', $data);
		} else {
			$this->load->view('admin/purchase-return/list');
		}
	}

	public function add_order()
	{
		$this->form_validation->set_rules('po_id', 'Return PO Id', 'trim|required|is_unique[purchase_return.po_id]', array('is_unique' => 'This PO alredy returned.'));
		$this->form_validation->set_rules('vendor_id', 'Select Vendor', 'trim|required');
		$this->form_validation->set_rules('prod_id[]', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('size_id[]', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('item_description[]', 'Items Description', 'trim|required');
		$this->form_validation->set_rules('unit_price[]', 'Unit Price', 'trim|required');
		$this->form_validation->set_rules('item_sku[]', 'Iten SKU', 'trim|required');
		$this->form_validation->set_rules('item_unit[]', 'Item Unit', 'trim|required');
		$this->form_validation->set_rules('item_total[]', 'Item Total', 'trim|required');
		$this->form_validation->set_rules('received_qty[]', 'Received Qty', 'trim|required');
		$this->form_validation->set_rules('sellable_qty[]', 'Sellable Qty', 'trim|required');
		$this->form_validation->set_rules('sub_total', 'Sub Total', 'trim|required');
		$this->form_validation->set_rules('sale_tax', 'Sales Tax', 'trim|required');
		$this->form_validation->set_rules('sale_tax_amt', 'Sales Tax Amt', 'trim|required');
		$this->form_validation->set_rules('shipping_handling', 'Shipping Handling', 'trim|required');
		$this->form_validation->set_rules('total', 'Total Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Purchase_return_model->add();
			if (!empty($query) && $query > 0) {
				$return_id = $query;
				$this->Inventory_model->updateReturnStock($return_id);
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/purchase_return');
	}

	public function get_list()
	{
		$fetch_data = $this->Purchase_return_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $order) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = 'PR-' . $order->id;
			$sub_array[] = $order->po_number;
			$sub_array[] = $order->vendor_name;
			$sub_array[] = date("d-m-Y", strtotime($order->po_date));
			$sub_array[] = $order->total . ' SAR';
			$sub_array[] = $order->po_terms;
			$sub_array[] = ($order->status == 1) ? '<div class="label label-warning">Return</div>' : (($order->status == 2) ? '<div class="label label-gray bg-primary">Return</div>' : (($order->status == 3) ? '<div class="label label-success">Return</div>' : '<div class="label label-danger">Return</div>'));
			$sub_array[] = date("d-m-Y h:i A", strtotime($order->created_at));
			$sub_array[] = date("d-m-Y h:i A", strtotime($order->updated_at));
			$sub_array[] = (check_action_permission(get_user_role(), 'purchase_return', 'print_invoice') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="' . base_url() . 'admin/pr/print?id=' . $order->id . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'purchase_return', 'purchase_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/pr/detail?id=' . $order->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Purchase_return_model->get_all_data(),
			"recordsFiltered"     =>     $this->Purchase_return_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function vendor_detail()
	{
		$id = $this->input->get('id');
		$output = $this->Purchase_return_model->get_vendor_detail($id);
		echo json_encode($output);
	}

	public function purchase_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_return', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data = $this->Purchase_return_model->get_order_detail($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/purchase-return/detail', $data);
	}

	public function print_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'purchase_return', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_preturn');
		$id = $this->input->get('id');
		$order = $this->Purchase_return_model->get_order_detail($id);
		// create new PDF document
		$pdf = new Pdf_preturn(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Purchase Return/Cash Memo');
		$pdf->SetSubject('Purchase Return Voucher');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/purchase-return/invoice_header', $order, true);
		$htmlHeader2 = $this->load->view('admin/purchase-return/invoice_header2', $order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/purchase-return/footer_last', $order, true);
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
		$htmlcontent = $this->load->view('admin/purchase-return/print_invoice', $order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('purchase-return-' . $id . '.pdf', 'I');
	}
}
