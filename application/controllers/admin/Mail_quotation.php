<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_quotation extends CI_Controller {

	public function __construct() {

        parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
		$this->load->model('admin/Quotation_model');
		$this->load->model('Order_model');
		$this->load->library('form_validation');
		$this->load->library('ci_qr_code');
        $this->config->load('qr_code');
		$this->load->helper('url');
	}
	
	public function send_mail(){
		$id = $this->input->get('id');
		$page = $this->uri->segment(3);
		$data['result'] = $this->Quotation_model->get_order($id);
		//print_r($data['result']);exit();
		if($page == 'send-mail' && $id !== ''){
			$subject = 'Quotation BS-'. $data['result']['order']['id'] .' is issued.';
			$message =  $this->load->view("admin/attatchment-template/email_quotation", $data, true);
			$attatchment = $this->generate_quotation($data['result']['order']['id']);
			
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
    		$this->email->to($data['result']['order']['email']);
    		$this->email->subject($subject);
    		$this->email->message($message);
			$this->email->attach($attatchment);
    		$send = $this->email->send();
    		/**********************/
			if($send){
				$this->session->set_userdata('info', "1--Quotation Successfully Send");
			}else{
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
			redirect("admin/quotation/form?id=".$id,'refresh');
		}else{
			$this->session->set_userdata('info', "2--Invalid Request, Check and try again!");
			
		}
		redirect("admin/quotation");

	}
	
	function generate_quotation($id){
		//get main CodeIgniter object
		$CI =& get_instance();
       	//load databse library
       	$CI->load->database();
		$CI->load->helper('url');
		// You may need to load the model if it hasn't been pre-loaded
    	$CI->load->model('Quotation_model');
		$CI->load->library('Pdf_quotation');
		$data['result'] = $CI->Quotation_model->get_order($id);
		// create new PDF document
		$Pdf_quotation = new Pdf_quotation(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_quotation->SetCreator(PDF_CREATOR);
		$Pdf_quotation->SetAuthor('Baqala Station');
		$Pdf_quotation->SetTitle('Quotation/Bill of Supply/Cash Memo');
		$Pdf_quotation->SetSubject('Order Invoice');
		$Pdf_quotation->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$Pdf_quotation->setPrintHeader(true);
		$Pdf_quotation->SetPrintFooter(true); 
		$htmlHeader = $CI->load->view('admin/quotation/invoice_header',$data, true);
		$htmlHeader2 = $CI->load->view('admin/quotation/invoice_header2',$data, true);
		$Pdf_quotation->setHtmlHeader($htmlHeader);
		$Pdf_quotation->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $CI->load->view('admin/quotation/footer_last',$data['result'], true);
		$Pdf_quotation->setHtmlFooter($lastFooter);
		// set header and footer fonts
		$Pdf_quotation->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_quotation->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$Pdf_quotation->SetMargins(6, 4, 4, true);
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
		
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_quotation->setRTL(false);

		// print newline
		$Pdf_quotation->Ln();
		// set font
		$Pdf_quotation->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $CI->load->view('admin/quotation/print_quotation',$data, true);;
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$path = FILE_PATH_QUOTE;
		$filename = 'baqala-quotation-'.$id;
		$Pdf_quotation->Output($path.$filename.'.pdf', 'F');
		return $path.$filename.'.pdf';
	}
	
}
