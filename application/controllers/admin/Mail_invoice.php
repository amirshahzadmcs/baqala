<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_invoice extends CI_Controller {

	public function __construct() {

        parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
		$this->load->model('admin/Order_process_model');
		$this->load->library('form_validation');
		$this->load->library('phpqrcode/qrlib');
		$this->load->helper('url');
	}
	
	public function send_mail(){
		$id = $this->input->get('id');
		$lang = $this->input->get('lang');
		$page = $this->uri->segment(3);
		$data['result'] = $this->Order_process_model->get_order($id);
		//print_r($lang);exit();
		
		if($page == 'invoice'){
			$subject = 'Ebill for your order #'. $data["result"]["order"]["invoice_prefix"] .'-'. $data["result"]["order"]["id"];
			$message = $this->load->view("admin/attatchment-template/email_deliever", $data, true);
			if($lang == 'ar'){
				//print_r($lang);exit();
				$attatchment = $this->generate_arabic_invoice($data["result"]["order"]["id"]);
			}else{
				$attatchment = $this->generate_invoice($data["result"]["order"]["id"]);
			}
			
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
    		$this->email->to($data["result"]["order"]["email"]);
    		$this->email->subject($subject);
    		$this->email->message($message);
			$this->email->attach($attatchment);
    		$send = $this->email->send();
    		/**********************/
			if($send){
				$this->session->set_userdata('info', "1--Invoice Successfully Send");
			}else{
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}elseif($page == 'delivery-note'){
			$subject = 'Your order id '. $data["result"]["order"]["invoice_prefix"] .'-'. $data["result"]["order"]["id"] .' with Baqala Station has been delivered.';
			$message = $this->load->view("admin/attatchment-template/email_deliever", $data, true);
			$attatchment = $this->generate_delivery_note($data["result"]["order"]["id"]);
			
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
    		$this->email->to($data["result"]["order"]["email"]);
    		$this->email->subject($subject);
    		$this->email->message($message);
			$this->email->attach($attatchment);
    		$send = $this->email->send();
    		/**********************/
			if($send){
				$this->session->set_userdata('info', "1--Delivery Note Successfully Send");
			}else{
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}else{
			$this->session->set_userdata('info', "2--Invalid Request, Check and try again!");
		}
		redirect("admin/order/detail?id=".$data["result"]["order"]["id"]);
		//redirect("admin/order_process");
	}
	
	public function generate_invoice($id){
	    $this->load->library('Pdf_invoice');
		$data['result'] = $this->Order_process_model->get_order($id);
		//$this->_qrcodeGenerator($data['result']['order']['trans_id']);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if($data['result']['order']['order_status_id'] == '6'){
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		// create new PDF document
		$pdf = new Pdf_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/order/invoice_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/order/invoice_header2',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/order/footer_last',$data, true);
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
		$pdf->SetMargins(1, 87, 4, true);

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
		$htmlcontent = $this->load->view('admin/order/print_page',$data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$path = FILE_PATH_INVOICE;
		$filename = 'baqala-invoice-'.$id;
		$pdf->Output($path.$filename.'.pdf', 'F');
		return $path.$filename.'.pdf';
	}
	
	public function generate_arabic_invoice($id){
	    $this->load->library('Pdf_invoice');
		$data['result'] = $this->Order_process_model->get_order($id);
		//$this->_qrcodeGenerator($data['result']['order']['trans_id']);
		$trans_id = $data['result']['order']['trans_id'];
		$vat_amt = $data['result']['order']['order_total'] - $data['result']['order']['total_vat'];
		if($data['result']['order']['order_status_id'] == '6'){
			$this->_qrcodeGenerator2($trans_id, $data['result']['order']['delivery_date'], $data['result']['order']['order_total'], $vat_amt);
		}
		// create new PDF document
		$pdf = new Pdf_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
		$pdf->SetSubject('Order Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/order/inv_header_arabic1',$data, true);
		$htmlHeader2 = $this->load->view('admin/order/inv_header_arabic2',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/order/print_footer_arabic',$data, true);
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
		$pdf->SetMargins(1, 87, 4, true);

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
		$htmlcontent = $this->load->view('admin/order/inv_arabic',$data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$path = FILE_PATH_INVOICE;
		$filename = 'baqala-invoice-'.$id;
		$pdf->Output($path.$filename.'.pdf', 'F');
		return $path.$filename.'.pdf';
	}
	
	//Delivery Note
	public function generate_delivery_note($id){
	    $this->load->library('Pdf_delivery');
		$data['result'] = $this->Order_process_model->get_order($id);
		// create new PDF document
		$Pdf_delivery = new Pdf_delivery(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_delivery->SetCreator(PDF_CREATOR);
		$Pdf_delivery->SetAuthor('Baqala Station');
		$Pdf_delivery->SetTitle('Delivery Note/Bill of Supply/Cash Memo');
		$Pdf_delivery->SetSubject('Delivery Note');
		$Pdf_delivery->SetKeywords('Baqala Station, PDF, Delivery Note, Order, Groceries');
		
		// remove default header/footer
		$Pdf_delivery->setPrintHeader(true);
		$Pdf_delivery->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/delivery_note/invoice_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/delivery_note/invoice_header2',$data, true);
		$Pdf_delivery->setHtmlHeader($htmlHeader);
		$Pdf_delivery->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/delivery_note/footer_last',$data, true);
		$Pdf_delivery->setHtmlFooter($lastFooter);

		// set header and footer fonts
		$Pdf_delivery->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_delivery->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$Pdf_delivery->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf_delivery->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf_delivery->SetFooterMargin(PDF_MARGIN_FOOTER);
		$Pdf_delivery->SetMargins(2, 70, 5, true);

		// set image scale factor
		$Pdf_delivery->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$Pdf_delivery->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_delivery->AddPage();
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_delivery->setRTL(false);

		// print newline
		$Pdf_delivery->Ln();
		// set font
		$Pdf_delivery->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/delivery_note/print_page',$data, true);;
		$Pdf_delivery->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$path = FILE_PATH_INVOICE;
		$filename = 'delivery-note-'.$id;
		$Pdf_delivery->Output($path.$filename.'.pdf', 'F');
		return $path.$filename.'.pdf';
	}
	
	/*----- For Leagal Use -----*/
	
	function dec2hex($number)
	{
		if($number > 15)
		{
			$hexval = dechex($number);
		}else{
			$hexval = '0'.dechex($number);
		}
		return $hexval;
	}

	public function _qrcodeGenerator2($param, $date, $total_amt, $total_vat)
	{	
		$this->load->helper('date');
		/*
		$qrtext  = 'Company Name: Maha Alfala Trading Est. '."\n";
        $qrtext .= 'VAT No: 300034911400003'."\n";
        $qrtext .= 'Date Stamp: '.$date."\n";
        $qrtext .= 'Invoice Amount: '.$total_amt."\n";
        $qrtext .= 'VAT Amount: '.$total_vat."\n";
		*/
		$Seller_name  = 'Maha Alfala Trading Est.';
        $vat_no = '300034911400003';
		$inv_date = date('Y-m-d\TH:i:s\Z', strtotime($date));
        $invoice_total = $total_amt;
        $vat_total = $total_vat;

		$seller_dec2hex = $this->dec2hex(strlen($Seller_name));
		$vat_no_dec2hex = $this->dec2hex(strlen($vat_no));
		$inv_date_dec2hex = $this->dec2hex(strlen($inv_date));
		$invoice_total_dec2hex = $this->dec2hex(strlen($invoice_total));
		$vat_total_dec2hex = $this->dec2hex(strlen($vat_total));

		$seller_bin2hex = bin2hex($Seller_name);
		$vat_no_bin2hex = bin2hex($vat_no);
		$inv_date_bin2hex = bin2hex($inv_date);
		$invoice_total_bin2hex = bin2hex($invoice_total);
		$vat_total_bin2hex = bin2hex($vat_total);

		$tlv = '01'.$seller_dec2hex.$seller_bin2hex.'02'.$vat_no_dec2hex.$vat_no_bin2hex.'03'.$inv_date_dec2hex.$inv_date_bin2hex.'04'.$invoice_total_dec2hex.$invoice_total_bin2hex.'05'.$vat_total_dec2hex.$vat_total_bin2hex;
		$base_64 = base64_encode(pack('H*',$tlv));
		//print_r($base_64);exit();
		//print_r('<img src="data:image/png;base64, ARhNYWhhIEFsZmFsYSBUcmFkaW5nIEVzdC4CDzMwMDAzNDkxMTQwMDAwMwMUMjAyMi0xMi0xM1QxNDo1MTo1MFoEBzExMzguNTAFBTE0OC41==" alt="Red dot" />');exit();
		if(isset($base_64))
		{
			$SERVERFILEPATH = FILE_PATH_QR; //Server
			$text = $base_64;
			//$text1= substr('123', 0,9);	
			$text1= $param;	
			$folder = $SERVERFILEPATH;
			$file_name1 = $text1."-Qrcode.png";
			$file_name = $folder.$file_name1;
			QRcode::png($text,$file_name);		
			return true;
		}
		else
		{
			return false;
		}	
	}
	
}
