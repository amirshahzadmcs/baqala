<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseReport extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){		
			$this->load->model('admin/Grv_model');
			$this->load->model('admin/Purchase_model');
			$this->load->model('admin/Purchase_report_model');
			$this->load->model('admin/Vendor_model');
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
		$this->load->view('admin/report/purchase/index',$data);
	}

	public function purchases()
	{
		$data['supplier'] = $this->Purchase_report_model->get_vendor_list();
		$supplier_id ='';
		$start_date='';
		$end_date='';
		if ($this->input->get('supplier')) {
			$supplier_id = $this->input->get('supplier');
		}
		// print_r($this->input->get('start'));die();
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			// print_r($sdate);die();
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}
		if($this->input->get('supplier') || ($this->input->get('start') && $this->input->get('end'))) {
			$data['grv'] = $this->Purchase_report_model->get_grv_list($supplier_id,$start_date,$end_date);
		} else {
			$data['grv'] = array();
		}
		// print_r($data['grv']);exit();
		$this->load->view('admin/report/purchase/purchase',$data);
	}
	public function supplier()
	{
		$data['supplier'] = $this->Purchase_report_model->get_vendor_list();
		$data['city'] = $this->Vendor_model->cities();
		$city = '';
		$country = '';
		$group_by = '';
		if ($this->input->get('city')) {
			$city = $this->input->get('city');
		}
		if ($this->input->get('country')) {
			$country = $this->input->get('country');
		}
		if ($this->input->get('group_by')) {
			$group_by = $this->input->get('group_by');
		}

		$data['supplier'] = $this->Purchase_report_model->get_filter_vendor_list($city,$country,$group_by);
		// print_r($data['supplier'][0]);exit();
		$this->load->view('admin/report/purchase/supplier',$data);
	}
	public function supplier_balance()
	{
		$this->load->view('admin/report/purchase/supplier_balance');
	}
	public function purchase()
	{
		$data['supplier'] = $this->Purchase_report_model->get_vendor_list();
		$supplier_id ='';
		$start_date='';
		$end_date='';
		if ($this->input->get('supplier')) {
			$supplier_id = $this->input->get('supplier');
		}
		// print_r($this->input->get('start'));die();
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			// print_r($sdate);die();
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}

		if($this->input->get('supplier') || ($this->input->get('start') && $this->input->get('end'))) {
			$data['grv'] = $this->Purchase_report_model->get_grv_list($supplier_id,$start_date,$end_date);
			// print_r($data['grv'][0]);die();
		} else {
			$data['grv'] = array();
		}
		
		$this->load->view('admin/report/purchase/purchasess',$data);
	}
	public function paid_purchases()
	{
		$this->load->view('admin/report/purchase/paid_purchases');
	}
	public function journal_transactions()
	{
		$this->load->view('admin/report/purchase/journal_transactions');
	}
	public function product_purchases()
	{
		$data['supplier'] = $this->Purchase_report_model->get_vendor_list();
		$supplier = '';
		$start_date='';
		$end_date='';
		$order_by='';
		$group_by='Product';
		if ($this->input->get('supplier')) {
			$supplier = $this->input->get('supplier');
		}
		if ($this->input->get('group_by')) {
			$group_by = $this->input->get('group_by');
		}
		if ($this->input->get('order_by')) {
			$order_by = $this->input->get('order_by');
		}
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			// print_r($sdate);die();
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}
		if($this->input->get('supplier') || ($this->input->get('start') && $this->input->get('end'))) {
			$data['purchases'] = $this->Purchase_report_model->purchase_orders($supplier,$start_date,$end_date,$group_by,$order_by);
		} else {
			$data['purchases'] = array();
		}
		
		// print_r($data['purchases'][0]);die();
		$this->load->view('admin/report/purchase/product_purchases', $data);
	}
	public function popayments()
	{
		$this->load->view('admin/report/purchase/popayments');
	}
	
	public function print_report(){
		$this->load->library('Pdf_purchase_report');
		// $id = $this->input->get('id');
		// $data['result'] = $this->Quotation_model->get_order($id);
		// $data['supplier'] = $this->Purchase_report_model->get_vendor_list();
		$supplier_id ='';
		$start_date='';
		$end_date='';
		if ($this->input->get('supplier')) {
			$supplier_id = $this->input->get('supplier');
		}
		// print_r($this->input->get('start'));die();
		if ($this->input->get('start') && $this->input->get('end')) {
			$sdate = str_replace(",","",$this->input->get('start'));
			$edate = str_replace(",","",$this->input->get('end'));
			// print_r($sdate);die();
			$start_date = date('Y-m-d', strtotime($sdate));
			$end_date = date('Y-m-d', strtotime($edate));
		}

		$data['grv'] = $this->Purchase_report_model->get_grv_list($supplier_id,$start_date,$end_date);
		
		// create new PDF document
		$Pdf_quotation = new Pdf_purchase_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_quotation->SetCreator(PDF_CREATOR);
		$Pdf_quotation->SetAuthor('Baqala Station');
		$Pdf_quotation->SetTitle(''.$this->input->get('page').'');
		$Pdf_quotation->SetSubject('Purchase Report');
		$Pdf_quotation->SetKeywords('Baqala Station, PDF, Purchase Report, Purchase, '. $this->input->get('page').'');
		
		// remove default header/footer
		$Pdf_quotation->setPrintHeader(true);
		$Pdf_quotation->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/report/print/header/invoice_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/report/print/header/invoice_header2',$data, true);
		$Pdf_quotation->setHtmlHeader($htmlHeader);
		$Pdf_quotation->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/report/print/footer/footer_last',$data, true);
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
		$htmlcontent = $this->load->view('admin/report/print/print_page',$data, true);;
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_quotation->Output(''.$this->input->get('page').' '.$this->input->get('supplier').'.pdf', 'I');
	}
	

}
