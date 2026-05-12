<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SalesReport extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){		
			$this->load->model('admin/Sales_report_model');
			$this->load->model('admin/Vendor_model');
			// $this->load->model('admin/Order_process_model');
			// $this->load->model('admin/Purchase_report_model');
			$this->load->library('form_validation');
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
		$this->load->view('admin/report/sales/index',$data);
	}

	public function revenue()
	{
		$data['clients'] = $this->Sales_report_model->get_client_list();
		$supplier_id = '';
		$start_date='';
		$end_date='';
		if ($this->input->get('client')) {
			$supplier_id = $this->input->get('client');
		}
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}
		if($this->input->get('client') || ($this->input->get('start') && $this->input->get('end'))) {
			$data['orders'] = $this->Sales_report_model->get_supplier_orders($supplier_id,$start_date,$end_date);
		} else {
			$data['orders'] = array();
		}
		
		$this->load->view('admin/report/sales/revenue', $data);
	}
	public function payments()
	{
		$data['clients'] = $this->Sales_report_model->get_client_list();
		$supplier_id = '';
		$start_date='';
		$end_date='';
		if ($this->input->get('client')) {
			$supplier_id = $this->input->get('client');
		}
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}
		if($this->input->get('client') || ($this->input->get('start') && $this->input->get('end'))) {
			$data['orders'] = $this->Sales_report_model->get_supplier_orders($supplier_id,$start_date,$end_date);
		} else {
			$data['orders'] = array();
		}
		$this->load->view('admin/report/sales/payment', $data);
	}
	public function stock_transactions_profit()
	{
		$this->load->view('admin/report/sales/stock_transactions_profit');
	}
	public function products()
	{
		$data['clients'] = $this->Sales_report_model->get_client_list();
		$data['brands'] = $this->Sales_report_model->get_brand_list();
		$data['parent'] = $this->Sales_report_model->get_category_list();
		// $data['products'] = $this->Sales_report_model->get_product_list();
		$supplier_id = '';
		$category = '';
		$brand = '';
		$start_date='';
		$end_date='';
		$product='';
		if ($this->input->get('client')) {
			$supplier_id = $this->input->get('client');
		}
		if ($this->input->get('category')) {
			$category = $this->input->get('category');
		}
		if ($this->input->get('brand')) {
			$brand = $this->input->get('brand');
		}
		if ($this->input->get('item')) {
			$product = $this->input->get('item');
		}
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}
		if($this->input->get('client') || ($this->input->get('start') && $this->input->get('end')) || $this->input->get('category') || $this->input->get('brand') || $this->input->get('item')) {
			$data['sales'] = $this->Sales_report_model->get_all_sales($supplier_id,$start_date,$end_date,$category,$brand,$product);
		} else {
			$data['sales'] = array();
		}
		// print_r($data['sales']);exit();
		$this->load->view('admin/report/sales/products', $data);
	}
	public function products_profit()
	{
		$this->load->view('admin/report/sales/products_profit');
	}

	public function print_report(){
		$this->load->library('Pdf_sales_report');
		$supplier_id ='';
		$start_date='';
		$end_date='';
		// for slaes by item
		$category = '';
		$brand = '';
		$product='';
		if ($this->input->get('client')) {
			$supplier_id = $this->input->get('client');
		}
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}
		// for sales by item
		if ($this->input->get('category')) {
			$category = $this->input->get('category');
		}
		if ($this->input->get('brand')) {
			$brand = $this->input->get('brand');
		}
		if ($this->input->get('item')) {
			$product = $this->input->get('item');
		}

		if (($this->input->get('page') == 'Item Sales by Item') || ($this->input->get('page') == 'Item Sales by Brand') || ($this->input->get('page') == 'Item Sales by Category')) {
			$data['order'] = $this->Sales_report_model->get_all_sales($supplier_id,$start_date,$end_date,$category,$brand,$product);
		} else {
			$data['order'] = $this->Sales_report_model->get_supplier_orders($supplier_id,$start_date,$end_date);
		}
		// print_r($data['order']);exit();
		// create new PDF document
		$Pdf_quotation = new Pdf_sales_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_quotation->SetCreator(PDF_CREATOR);
		$Pdf_quotation->SetAuthor('Baqala Station');
		$Pdf_quotation->SetTitle(''.$this->input->get('page').'');
		$Pdf_quotation->SetSubject('Purchase Report');
		$Pdf_quotation->SetKeywords('Baqala Station, PDF, Purchase Report, Purchase, '. $this->input->get('page').'');
		
		// remove default header/footer
		$Pdf_quotation->setPrintHeader(true);
		$Pdf_quotation->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/report/print/header/invoice_sales_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/report/print/header/invoice_sales_header2',$data, true);
		$Pdf_quotation->setHtmlHeader($htmlHeader);
		$Pdf_quotation->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/report/print/footer/footer_sales_last',$data, true);
		$Pdf_quotation->setHtmlFooter($lastFooter);
		// set header and footer fonts
		$Pdf_quotation->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_quotation->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$Pdf_quotation->SetMargins(1, 4, 4, true);
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf_quotation->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf_quotation->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$Pdf_quotation->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$Pdf_quotation->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_quotation->AddPage();
		/*
		// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
		// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

		// create some HTML content
		$html = $this->load->view('admin/order/print_page',$data, true);
		//echo '<pre>';print_r($html);'</pre>';exit();
		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, 'left');
		
		$pdf->Output('baqala-invoice.pdf', 'I');*/
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_quotation->setRTL(false);

		// print newline
		$Pdf_quotation->Ln();
		// set font
		$Pdf_quotation->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/report/print/print_sales_page',$data, true);;
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_quotation->Output(''.$this->input->get('page').' '.$this->input->get('client').'.pdf', 'I');
	}

}
