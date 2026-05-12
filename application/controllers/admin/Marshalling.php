<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Marshalling extends CI_Controller {

	public function __construct() {

		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Marshalling_model');
			$this->load->model('admin/Delivery_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		$data['results'] = $this->Marshalling_model->get_marshalling_list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['delivery_list'] = $this->Delivery_model->all_dboy_list();
		//echo '<pre>';print_r($data['delivery_list']);exit();
		$this->load->view('admin/marshalling/marshalling_list',$data);
	}
	
	public function print_sheet(){
	    $this->load->library('Pdf');
		$id = $this->input->get('id');
		$data['m_details'] = $this->Marshalling_model->get_marshalling_list_by_id($id);
		$data['results'] = $this->Marshalling_model->get_order_by_ids($data['m_details']->order_ids);
		$data['total_boxes'] = $this->Marshalling_model->total_shipment_box($data['m_details']->order_ids);
		//print_r($data['m_details']);exit();
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Marshalling Sheet | Baqala Station');
		$pdf->SetSubject('Order Marshalling Sheet');
		$pdf->SetKeywords('Baqala Station, PDF, Marshalling Sheet, Order, Groceries');
		
		// remove default header/footer
		$pdf->setPrintHeader(false);
		
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

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/marshalling/print_page',$data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('baqala-marshalling.pdf', 'I');
	}
	
}
