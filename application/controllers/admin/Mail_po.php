<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_po extends CI_Controller {

	public function __construct() {

        parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
		$this->load->model('admin/Purchase_model');
		$this->load->model('admin/Vendor_model');
		$this->load->model('admin/Grv_model');
		$this->load->library('form_validation');
		$this->load->library('phpqrcode/qrlib');
		$this->load->helper('url');
	}
	
	public function send_mail(){
		$id = $this->input->get('id');
		$page = $this->uri->segment(3);
		$data = $this->Purchase_model->get_order_detail($id);
		//print_r($data['order']->id);exit();
		if($page == 'send-mail' && $id !== ''){
			$subject = 'Purchase Order PO-'. $data['order']->id .' is issued.';
			$message = $this->load->view("admin/attatchment-template/email_po", $data, true);
			$attatchment = $this->generate_po($data['order']->id);
			
    		/*********Email*************/
    		$eSetting = $this->customer->emailSetting();
    		$config = Array(
    			'protocol' => $eSetting->protocol,		
    			'smtp_host' => $eSetting->smtp_host,		
    			'smtp_port' => $eSetting->smtp_port,			
    			'smtp_user' => $eSetting->smtp_user,		
    			'smtp_pass' => $eSetting->smtp_pass,	
    			'mailtype' => 'html'
    		);
    	
    		$this->load->library('email');
    		$this->email->initialize($config);
    		$this->email->set_newline("\r\n");
    		$this->email->from($eSetting->smtp_user, $subject); 
    		$this->email->to($data['order']->vendor_email);
    		$this->email->subject($subject);
    		$this->email->message($message);
			$this->email->attach($attatchment);
    		$send = $this->email->send();
    		/**********************/
			if($send){
				$this->session->set_userdata('info', "1--PO Successfully Send");
			}else{
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
			redirect("admin/purchase_order/purchase_detail?id=".$id);
		}else{
			$this->session->set_userdata('info', "2--Invalid Request, Check and try again!");
			
		}
		
		redirect("admin/purchase_order");

	}
	
	public function generate_po($id){
	    $this->load->library('Pdf_purchase');
		$order = $this->Purchase_model->get_order_detail($id);
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
		$htmlHeader = $this->load->view('admin/purchase_order/invoice_header',$order, true);
		$htmlHeader2 = $this->load->view('admin/purchase_order/invoice_header2',$order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/purchase_order/footer_last',$order, true);
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
		$pdf->AddPage();
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/purchase_order/print_invoice',$order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document

		$path = FILE_PATH_PO;
		$filename = 'purchase-invoice-'.$id;
		$pdf->Output($path.$filename.'.pdf', 'F');
		return $path.$filename.'.pdf';
	}
	
}
