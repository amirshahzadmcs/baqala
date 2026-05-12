<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OfferLetter extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Loi_model');
			$this->load->model('admin/Job_title_model');
			$this->load->model('admin/hr/recruitment/Ol_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index_ol()
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
		$this->load->view('admin/hr/recruitment/ol/index',$data);
	}

	
	public function add_ol(){
		if($this->input->get('id')){
			$query = $this->Ol_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['offer_no'] = $query->offer_no;
			$data['loi_no'] = $query->loi_no;
			$data['cv_no'] = $query->cv_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['open_date'] = $query->open_date;
			$data['position'] = $query->position;
			$data['iqama_no'] = $query->iqama_no;
			$data['address_1'] = $query->address_1;
			$data['address_2'] = $query->address_2;
			$data['address_3'] = $query->address_3;
			$data['joining_date'] = $query->joining_date;
			$data['ctc'] = $query->ctc;
			$data['ctc_word'] = $query->ctc_word;
		}
		else{
			$data['id'] = "";
			$data['offer_no'] = "";
			$data['loi_no'] = "";
			$data['cv_no'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['open_date'] = "";
			$data['position'] = "";
			$data['iqama_no'] = "";
			$data['address_1'] = "";
			$data['address_2'] = "";
			$data['address_3'] = "";
			$data['joining_date'] = "";
			$data['ctc'] = "";
			$data['ctc_word'] = "";
		}
		
		$data['lois'] = $this->Loi_model->get_data();
		$data['positions'] = $this->Job_title_model->get_list();
		$data['ol_id'] = $this->db->query("SELECT id FROM offer_letter ORDER BY id desc limit 1")->row();
		// print_r($data['ol_no']);exit();
		$this->load->view('admin/hr/recruitment/ol/form',$data);
	}

	public function save_ol(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Ol_model->edit();
    		}
    		else{
    			$query = $this->Ol_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/ol');
	}

	public function ol_detail(){
		if($this->input->get('id')){
			$query = $this->Ol_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['offer_no'] = $query->offer_no;
			$data['loi_no'] = $query->loi_no;
			$data['cv_no'] = $query->cv_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['open_date'] = $query->open_date;
			$data['position'] = $query->position;
			$data['iqama_no'] = $query->iqama_no;
			$data['address_1'] = $query->address_1;
			$data['address_2'] = $query->address_2;
			$data['address_3'] = $query->address_3;
			$data['joining_date'] = $query->joining_date;
			$data['ctc'] = $query->ctc;
			$data['ctc_word'] = $query->ctc_word;
			
			$data['lois'] = $this->Loi_model->get_data();
			$data['ol_id'] = $this->db->query("SELECT id FROM offer_letter ORDER BY id desc limit 1")->row();
			$this->load->view('admin/hr/recruitment/ol/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/ol');
		}
	}

	public function get_ol_list(){
		$fetch_data = $this->Ol_model->get_list();
// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->offer_no;
			$sub_array[] = $store->name;
			$sub_array[] = $store->mobile;
			$sub_array[] = $store->cv_no;
			$sub_array[] = $store->loi_num;
			$sub_array[] = date('d-m-Y', strtotime($store->joining_date));
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/ol/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/ol/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Ol_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Ol_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete_ol(){
		$ids = $this->input->post('checklist');
		$query = $this->Ol_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/ol');
	}

	public function get_loi_detail()
	{
		$id = $this->input->get('id');
		$data = $this->Loi_model->get_detail($id);
		// $data['age'] = age_calculate($data['loi']->dob);
		$final = array(
			'name' => $data->name,
			'mobile' => $data->mobile,
			'iqama_no' => $data->iqama_no,
			'cv_num' => $data->cv_num,
			'position' => $data->position,
			'address_1' => $data->address_1,
			'address_2' => $data->address_2,
			'address_3' => $data->address_3,
			'joining_date' => $data->joining_date,
		);

		echo json_encode($final);
	}

	public function print(){
	    $this->load->library('Pdf_offer_letter');
		$id = $this->input->get('id');
		$order = $this->Ol_model->get_offer_detail($id);
		// print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_offer_letter(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Offer Letter Of '.$order->name);
		$pdf->SetSubject('BS - Offer Letter Of '.$order->name);
		$pdf->SetKeywords('Baqala Station, PDF, Offer Letter');
		
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/hr/recruitment/ol/invoice_header',$order, true);
		$htmlHeader2 = $this->load->view('admin/hr/recruitment/ol/invoice_header',$order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/hr/recruitment/ol/footer_last',$order, true);
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
		$htmlcontent = $this->load->view('admin/hr/recruitment/ol/print_offer',$order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS - Offer Letter Of '. $order->name .'.pdf', 'I');
	}
	
}
