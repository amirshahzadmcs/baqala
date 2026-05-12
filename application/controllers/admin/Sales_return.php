<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_return extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){	
			$this->load->model('admin/Sales_return_model');
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
		}else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['order_list'] = $this->Sales_return_model->get_order_list();
		$this->load->view('admin/sales-return/list',$data);
	}
	
	public function return_form(){
		if($this->input->get('o_id')){
			$data['result'] = $this->Sales_return_model->get_order($this->input->get('o_id'));
			//print_r($data);exit();
			$this->load->view('admin/sales-return/edit-form',$data);
		}else{
			$this->load->view('admin/sales-return/list');
		}
	}
	
	public function return_order(){
		$this->form_validation->set_rules('order_id', 'Return Invoice Id', 'trim|required|is_unique[sales_return.order_id]', array('is_unique' => 'This Sales order already returned.'));
		$this->form_validation->set_rules('po_number', 'PO Number', 'trim|required');
		$this->form_validation->set_rules('po_date', 'PO Date', 'trim|required');
		$this->form_validation->set_rules('quotation_no', 'Quotation No', 'trim|required');
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required');
		$this->form_validation->set_rules('product_id[]', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('size_id[]', 'Size ID', 'trim|required');
		$this->form_validation->set_rules('price[]', 'Price', 'trim|required');
		$this->form_validation->set_rules('product_name[]', 'Product Name', 'trim|required');
		$this->form_validation->set_rules('gst_rate[]', 'GST Rate', 'trim|required');
		$this->form_validation->set_rules('product_slug[]', 'Product Slug', 'trim|required');
		$this->form_validation->set_rules('size[]', 'Size', 'trim|required');
		$this->form_validation->set_rules('gift_value[]', 'Gift Value', 'trim|required');
		$this->form_validation->set_rules('product_sku[]', 'Product SKU', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->Sales_return_model->add_to_return();
    		if(!empty($query) && $query > 0){
				$return_id = $query;
				$this->Sales_return_model->updateStock($return_id);
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/sales_return');
	}
	
	public function get_list(){
		$fetch_data = $this->Sales_return_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $order){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = 'SRV-'.$order->id;
			$sub_array[] = 'BS#-'.$order->order_id;
			$sub_array[] = 'BS#-'.$order->quotation_no;
			$sub_array[] = $order->c_company;
			$sub_array[] = date("d-m-Y", strtotime($order->po_date));
			$sub_array[] = $order->order_total .' SAR';
			$sub_array[] = $order->payment_method;
			$sub_array[] = ($order->status == 1) ? '<div class="label label-warning">Return</div>' : (($order->status == 2) ? '<div class="label label-gray bg-primary">Return</div>' : (($order->status == 3) ? '<div class="label label-success">Return</div>' : '<div class="label label-danger">Return</div>'));
			$sub_array[] = date("d-m-Y h:i A", strtotime($order->created_at));
			$sub_array[] = date("d-m-Y h:i A", strtotime($order->updated_at));
			$sub_array[] = '<a class="btn btn-primary btn-sm" title="Print" href="'.base_url().'admin/sales_return/print_invoice?id='.$order->id.'" target="_blank"><i class="fa fa-print"></i></a><a class="btn btn-success btn-sm" title="Detail" href="'.base_url().'admin/sales_return/sales_detail?id='.$order->id.'"><i class="fa fa-eye"></i></a>';				 
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Sales_return_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Sales_return_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function sales_detail(){
		$id = $this->input->get('id');
		$data['result'] = $this->Sales_return_model->get_sales_detail($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/sales-return/detail',$data);
	}
	
	public function print_invoice(){
		$this->load->library('Pdf_quotation');
		$id = $this->input->get('id');
		$data['result'] = $this->Sales_return_model->get_sales_detail($id);
		// create new PDF document
		$Pdf = new Pdf_quotation(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf->SetCreator(PDF_CREATOR);
		$Pdf->SetAuthor('Baqala Station');
		$Pdf->SetTitle('Sales Return/Bill of Supply/Cash Memo');
		$Pdf->SetSubject('Sales Return Invoice');
		$Pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$Pdf->setPrintHeader(true);
		$Pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/sales-return/invoice_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/sales-return/invoice_header2',$data, true);
		$Pdf->setHtmlHeader($htmlHeader);
		$Pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/sales-return/footer_last',$data, true);
		$Pdf->setHtmlFooter($lastFooter);
		// set header and footer fonts
		$Pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$Pdf->SetMargins(1, 4, 4, true);
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$Pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$Pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf->AddPage();
		// Arabic and English content
		// set LTR direction for english translation
		$Pdf->setRTL(false);

		// print newline
		$Pdf->Ln();
		// set font
		$Pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/sales-return/print_invoice',$data, true);;
		$Pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf->Output('sales-return-voucher-'.$id.'.pdf', 'I');
	}
	
}
