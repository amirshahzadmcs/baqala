<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){		
			$this->load->model('admin/Report_model');
			$this->load->model('admin/Vendor_model');
			$this->load->model('admin/Grv_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		$data['reports'] = array();
		$data['vendors'] = $this->Report_model->get_vendors();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/reports/po_report',$data);
	}
	
	public function report(){
		$data['reports'] = $this->Report_model->get_po_report();
		$data['vendors'] = $this->Report_model->get_vendors();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/reports/po_report',$data);
	}
	
	public function print_report(){
	    $this->load->library('Pdf_report');
		$date_from = $this->input->get('from');
		$date_to = $this->input->get('to');
		$supp_name = $this->input->get('nameFilter');
		$other_info = array('date_from'=>$date_from,'date_to'=>$date_to,'supp_name'=>$supp_name);
		$order['results'] = $this->Report_model->get_po_report();
		//print_r($other_info['date_from']);exit();
		// create new PDF document
		$pdf = new Pdf_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Purchase Vat Report/Cash Memo');
		$pdf->SetSubject('Purchase Vat Report');
		$pdf->SetKeywords('Baqala Station, PDF, Purchase Vat Report');
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/reports/report_header',$other_info, true);
		$htmlHeader2 = $this->load->view('admin/reports/report_header2',$other_info, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		$lastFooter = $this->load->view('admin/reports/report_footer',$other_info, true);
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
		$pdf->AddPage('L', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);
		
		// Arabic and English content
		$htmlcontent = $this->load->view('admin/reports/print_report',$order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		
		//Close and output PDF document
		$pdf->Output('purchase-vat-report-'.$date_from.'.pdf', 'I');
	}
}
