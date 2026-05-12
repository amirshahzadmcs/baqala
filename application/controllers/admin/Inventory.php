<?php defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Purchase_return_model');
			$this->load->model('admin/Inventory_model');
			$this->load->model('admin/Category_model');
			$this->load->model('admin/Product_model');
			$this->load->library('form_validation');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
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
		if (!empty($this->input->get('category_id'))) {
			$cat_id = $this->input->get('category_id');
		} else {
			$cat_id = FALSE;
		}
		if (!empty($this->input->get('brand'))) {
			$brand = $this->input->get('brand');
		} else {
			$brand = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		$data['categories'] = $this->Category_model->get_category();
		$data['brand_list'] = $this->Product_model->brand_list();
		$data['total_inventory'] = $this->Inventory_model->get_filtered_data($cat_id, $brand, $status, $from, $to);
		$data['total_instock'] = $this->Inventory_model->get_filtered_stock('instock', $cat_id, $brand, $status, $from, $to);
		$data['total_outstock'] = $this->Inventory_model->get_filtered_stock('outstock', $cat_id, $brand, $status, $from, $to);
		$data['total_value'] = $this->Inventory_model->total_value($cat_id, $brand, $status, $from, $to);
		$this->load->view('admin/inventory/stock_list', $data);
	}

	public function add_order()
	{
		$this->form_validation->set_rules('po_id', 'Return PO Id', 'trim|required|is_unique[purchase_return.po_id]', array('is_unique' => 'This PO alredy returned.'));
		$this->form_validation->set_rules('vendor_id', 'Select Vendor', 'trim|required');
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
				//$this->Purchase_return_model->updateStock($return_id);
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/purchase_return');
	}

	public function get_list()
	{
		//echo '<pre>';print_r($this->input->get('status'));exit();'</pre>';
		if (!empty($this->input->get('category_id'))) {
			$cat_id = $this->input->get('category_id');
		} else {
			$cat_id = FALSE;
		}
		if (!empty($this->input->get('brand'))) {
			$brand = $this->input->get('brand');
		} else {
			$brand = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		$fetch_data = $this->Inventory_model->get_list($cat_id, $brand, $status, $from, $to);
		//echo '<pre>';print_r($fetch_data);exit();'</pre>';
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $order) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $order->child_sku;
			$sub_array[] = $order->barcode;
			$sub_array[] = !empty($order->image) ? '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . $order->image . '" width="80px" /> <span class="ms-2">' . $order->product_name . '<br><pre style="direction: rtl;">' . $order->product_arabic_name . '</pre>' . '</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . 'images/notfound.jpg" width="80px" /> <span class="ms-2">' . $order->product_name . '<br><pre style="direction: rtl;">' . $order->product_arabic_name . '</pre></span></div>';
			$sub_array[] = $order->stock;
			$sub_array[] = $order->unit_price;
			$sub_array[] = '<div style="text-align:right">' . $order->stock * $order->unit_price . ' SAR </div>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Inventory_model->get_all_data(),
			"recordsFiltered"     =>     $this->Inventory_model->get_filtered_data($cat_id, $brand, $status, $from, $to),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	/*----- Filtered Data ------*/

	public function filter()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = '';
		}
		if (!empty($this->input->get('category_id'))) {
			$cat_id = $this->input->get('category_id');
		} else {
			$cat_id = FALSE;
		}
		if (!empty($this->input->get('brand'))) {
			$brand = $this->input->get('brand');
		} else {
			$brand = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		$data['categories'] = $this->Category_model->get_category();
		$data['brand_list'] = $this->Product_model->brand_list();
		$data['total_inventory'] = $this->Inventory_model->get_all_stock($keyword);
		$data['total_stock'] = $this->Inventory_model->get_filtered_stock($keyword, $cat_id, $brand, $status, $from, $to);
		$data['total_value'] = $this->Inventory_model->filter_total_value($keyword, $cat_id, $brand, $status, $from, $to);
		$this->load->view('admin/inventory/filter_list', $data);
	}

	public function get_filtered_list()
	{
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = '';
		}
		if (!empty($this->input->get('category_id'))) {
			$cat_id = $this->input->get('category_id');
		} else {
			$cat_id = FALSE;
		}
		if (!empty($this->input->get('brand'))) {
			$brand = $this->input->get('brand');
		} else {
			$brand = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		$fetch_data = $this->Inventory_model->get_filter_inventory($keyword, $cat_id, $brand, $status, $from, $to);
		//echo '<pre>';print_r($fetch_data);exit();'</pre>';
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $order) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $order->child_sku;
			$sub_array[] = $order->barcode;
			$sub_array[] = !empty($order->image) ? '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . $order->image . '" width="80px" /> <span class="ms-2">' . $order->product_name . '<br><pre style="direction: rtl;">' . $order->product_arabic_name . '</pre>' . '</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . 'images/notfound.jpg" width="80px" /> <span class="ms-2">' . $order->product_name . '<br><pre style="direction: rtl;">' . $order->product_arabic_name . '</pre></span></div>';
			$sub_array[] = $order->stock;
			$sub_array[] = $order->unit_price;
			$sub_array[] = '<div style="text-align:right">' . $order->stock * $order->unit_price . ' SAR </div>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Inventory_model->get_all_stock($keyword),
			"recordsFiltered"     =>     $this->Inventory_model->get_filtered_stock($keyword, $cat_id, $brand, $status, $from, $to),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function print_invoice()
	{
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
