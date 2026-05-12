<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stockrequest extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Stockrequest_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('admin/login');			
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
		$data['stores'] = $this->Stockrequest_model->get_stores();
		$this->load->view('admin/stock-request/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Stockrequest_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $request){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $request->request_id;
			$sub_array[] = $request->store_name;
			$sub_array[] = $request->target_store_name;
			$sub_array[] = date("d-m-Y h:i A", strtotime($request->created_at));
			$sub_array[] = date("d-m-Y", strtotime($request->expected_date));
			$sub_array[] = '<span class="badge badge-pill badge-soft-'.$request->status_type.' font-size-13">'.$request->status_name.'</span>';
			$sub_array[] = $request->total_sku;
			$sub_array[] = $request->total_qty;
			$sub_array[] = $request->reason;
			$sub_array[] = $request->store_name;
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/stockrequest/detail?id='.$request->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>&nbsp;<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Quick View" onClick="quickView('.$request->id.')" href="javascript:;"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>&nbsp;<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print" href="'.base_url().'admin/stockrequest/print_invoice?id='.$request->id.'" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>';		
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Stockrequest_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Stockrequest_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function detail(){
		$id = $this->input->get('id');
		$data = $this->Stockrequest_model->get_request_detail($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/stock-request/detail',$data);
	}
	
	public function quick_view()
    {
        $reqid = $this->input->post("id");
        $result = $this->Stockrequest_model->get_request_detail($reqid);
		$data = $this->load->view('admin/stock-request/quick-view',$result,TRUE);
		//echo '<pre>';print_r($data);exit();
        //echo json_encode($data);
		echo $data;
    }

	public function approved_request(){
		$this->form_validation->set_rules('request_id[]', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('size_id[]', 'Size ID', 'trim|required');
		$this->form_validation->set_rules('item_req_id[]', 'Item ID', 'trim|required');
		$this->form_validation->set_rules('approved_unit[]', 'Approved Unit', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('request_id')){
    			$query = $this->Stockrequest_model->edit();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		
		}
		redirect('admin/stockrequest/detail?id='.$this->input->post('request_id'));
	}
	
	public function assign_vehicle(){
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->Stockrequest_model->assign_vehicle();
    		if($query){
				$this->session->set_userdata('info', "1--Successfully Assigned");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		
		}
		redirect('admin/stockrequest/detail?id='.$this->input->post('request_id'));
	}

	public function update_status(){
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('status', 'Status ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->Stockrequest_model->update_status();
    		if($query){
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		
		}
		redirect('admin/stockrequest/detail?id='.$this->input->post('request_id'));
	}

	public function print_invoice(){
	    $this->load->library('Pdf_stock');
		$id = $this->input->get('id');
		$order = $this->Stockrequest_model->get_request_detail($id);
		//print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_stock(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Stock Transfer Request/Cash Memo');
		$pdf->SetSubject('Stock Transfer Request');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
		
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/stock-request/invoice_header',$order, true);
		$htmlHeader2 = $this->load->view('admin/stock-request/invoice_header2',$order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/stock-request/footer_last',$order, true);
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
		$htmlcontent = $this->load->view('admin/stock-request/print_invoice',$order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('STR '. $order['order']->request_id .'.pdf', 'I');
	}
	
}
