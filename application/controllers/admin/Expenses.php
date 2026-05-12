<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){	
			$this->load->model('admin/Expenses_model');
			//$this->load->model('admin/Purchase_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['results'] = $this->Expenses_model->get_list();
		$this->load->view('admin/expenses/list',$data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Expenses_model->get_expenses_by_id($this->input->get('id'));
			$data['id'] = $query->id;
			$data['branch_code'] = $query->branch_code;
			$data['date'] = $query->date;
			$data['invoice_number'] = $query->invoice_number;
			$data['item_description'] = $query->item_description;
			$data['supplier_name'] = $query->supplier_name;
			$data['supplier_arabic_name'] = $query->supplier_arabic_name;
			$data['supplier_vat_no'] = $query->supplier_vat_no;
			$data['cr_no'] = $query->cr_no;
			$data['o_img'] = $query->image;
			$data['amt_bef_vat'] = $query->amt_bef_vat;
			$data['tax'] = $query->tax;
			$data['total'] = $query->total;
			$data['created_at'] = $query->created_at;
			$data['updated_at'] = $query->updated_at;
		}
		else{
			$data['id'] = "";
			$data['branch_code'] = "";
			$data['date'] = "";
			$data['invoice_number'] = "";
			$data['item_description'] = "";
			$data['supplier_name'] = "";
			$data['supplier_arabic_name'] = "";
			$data['supplier_vat_no'] = "";
			$data['cr_no'] = "";
			$data['o_img'] = "";
			$data['amt_bef_vat'] = "";
			$data['tax'] = "";
			$data['total'] = "";
			$data['created_at'] = "";
			$data['updated_at'] = "";
		}
		$this->load->view('admin/expenses/form',$data);
	}
	
	public function add_expenses(){
		$this->form_validation->set_rules('invoice_number', 'Invoice Number', 'trim|required');
		$this->form_validation->set_rules('item_description', 'Item Description', 'trim|required');
		$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');
		$this->form_validation->set_rules('supplier_vat_no', 'Supplier VAT No', 'trim|required');
		$this->form_validation->set_rules('total', 'Inclusive', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($_FILES['image']['name']){
				$con['upload_path']   = './uploads/'; 
				$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
				$con['max_size']      = 0; 
				$con['max_width']     = 0; 
				$con['max_height']    = 0;  
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
                   echo $this->upload->display_errors();
				   exit;
                } 
				else {
					$image_data = $this->upload->data();
					$image = "uploads/".$image_data['file_name'];
               }
			}
			else{
				$image = $this->input->post('o_img');
			}
    		if($this->input->post('id')){
    			$query = $this->Expenses_model->edit($image);
    		}
    		else{
    			$query = $this->Expenses_model->add($image);
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/expenses');
	}
	
	public function detail(){
		$id = $this->input->get('id');
		$data['result'] = $this->Expenses_model->get_expenses_by_id($id);
		$this->load->view('admin/expenses/detail', $data);
	}
	
	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Expenses_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/expenses');
	}
	
	public function print_invoice(){
	    $this->load->library('Pdf_expenses');
		$id = $this->input->get('id');
		$order = $this->Expenses_model->get_expenses_by_id($id);
		//print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_expenses(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Expenses Invoice/Expenses Invoice/Cash Memo');
		$pdf->SetSubject('Expenses Invoice');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		//$htmlHeader = $this->load->view('admin/expenses/invoice_header',$order, true);
		//$htmlHeader2 = $this->load->view('admin/expenses/invoice_header2',$order, true);
		//pdf->setHtmlHeader($htmlHeader);
		//$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/expenses/footer_last',$order, true);
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
		$htmlcontent = $this->load->view('admin/expenses/print_invoice',$order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('expense-invoice-'.$id.'.pdf', 'I');
	}
}
