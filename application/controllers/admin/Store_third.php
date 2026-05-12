<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Store_third extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Store_model');
			$this->load->model('admin/Common_model');
			$this->load->library('form_validation');
			$this->load->helper('text');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
	
	public function add_thirdparty(){
		if($this->input->get('id')){
			$query = $this->Store_model->get_detail($this->input->get('id'));
			$store_docs = $this->Store_model->store_documents($this->input->get('id'));
			$store_bank = $this->Store_model->store_bank_account($this->input->get('id'));
			$data['id'] = $query->id;
			$data['store_name'] = $query->store_name;
			$data['store_name_arabic'] = $query->store_name_arabic;
			$data['store_id'] = $query->store_id;
			$data['store_incharge'] = $query->store_incharge;
			$data['email'] = $query->email;
			$data['contact_number'] = $query->contact_number;
			$data['google_coordinates_lat'] = $query->google_coordinates_lat;
			$data['google_coordinates_long'] = $query->google_coordinates_long;
			$data['store_radius'] = $query->store_radius;
			$data['store_location'] = $query->store_location;
		    $data['status'] = $query->status;

		    $data['cat_name_1'] = $query->cat_name_1;
		    $data['monthly_sub_1'] = $query->monthly_sub_1;
		    $data['online_payment_fee_1'] = $query->online_payment_fee_1;
		    $data['cat_name_2'] = $query->cat_name_2;
		    $data['monthly_sub_2'] = $query->monthly_sub_2;
		    $data['online_payment_fee_2'] = $query->online_payment_fee_2;
		    $data['cat_name_3'] = $query->cat_name_3;
		    $data['monthly_sub_3'] = $query->monthly_sub_3;
		    $data['online_payment_fee_3'] = $query->online_payment_fee_3;
		    $data['cat_name_4'] = $query->cat_name_4;
		    $data['monthly_sub_4'] = $query->monthly_sub_4;
		    $data['online_payment_fee_4'] = $query->online_payment_fee_4;
		    $data['password'] = $query->password;
		    $data['price'] = $query->price;
		    $data['discount'] = $query->discount;
		    $data['agrement_start'] = $query->agrement_start;
		    $data['brand_name'] = $query->brand_name;
		    $data['agrement_num'] = $query->agrement_num;
		    $data['trademark'] = $query->trademark;
		    $data['email_invoice'] = $query->email_invoice;

			$data['agrement_expiry'] = $query->agrement_expiry;
			$data['cr_no'] = $query->cr_no;
			$data['cr_expiry'] = $query->cr_expiry;
			$data['vat_no'] = $query->vat_no;
			$data['vat_expiry'] = $query->vat_expiry;
			$data['fax'] = $query->fax;
			$data['website'] = $query->website;
			
			$data['sales_name'] = $query->sales_name;
			$data['sales_mobile'] = $query->sales_mobile;
			$data['sales_email'] = $query->sales_email;
			$data['sales_id'] = $query->sales_id;
			$data['sales_position'] = $query->sales_position;
			$data['finance_name'] = $query->finance_name;
			$data['finance_mobile'] = $query->finance_mobile;
			$data['finance_email'] = $query->finance_email;
			$data['finance_id'] = $query->finance_id;
			$data['finance_position'] = $query->finance_position;
			$data['legal_name'] = $query->legal_name;
			$data['legal_mobile'] = $query->legal_mobile;
			$data['legal_email'] = $query->legal_email;
			$data['legal_id'] = $query->legal_id;
			$data['legal_position'] = $query->legal_position;
			$data['other_name'] = $query->other_name;
			$data['other_mobile'] = $query->other_mobile;
			$data['other_email'] = $query->other_email;
			$data['other_id'] = $query->other_id;
			$data['other_position'] = $query->other_position;
			
			$data['building_no'] = $query->building_no;
			$data['street_name'] = $query->street_name;
			$data['district'] = $query->district;
			// $data['region_id'] = $query->region_id;
			$data['city'] = $query->city;
			$data['country'] = $query->country;
			$data['postal_code'] = $query->postal_code;
			$data['additional_no'] = $query->additional_no;
			$data['unit_no'] = $query->unit_no;
		    $data['short_address'] = $query->short_address;
		    $data['payment_terms'] = $query->payment_terms;
		    $data['order_currency'] = $query->order_currency;
		    $data['credit_limit'] = $query->credit_limit;
			if(!empty($store_bank)){
				$data['bank_account_no'] = $store_bank->bank_account_no;
				$data['account_holder_name'] = $store_bank->account_holder_name;
				$data['iban_number'] = $store_bank->iban_number;
				$data['bank_name'] = $store_bank->bank_name;
				$data['branch_name'] = $store_bank->branch_name;
				$data['region'] = $store_bank->region;
				$data['account_currency'] = $store_bank->account_currency;
				$data['swift_code'] = $store_bank->swift_code;
				$data['bank_city'] = $store_bank->bank_city;
			}else{
				$data['bank_account_no'] = "";
				$data['account_holder_name'] = "";
				$data['iban_number'] = "";
				$data['bank_name'] = "";
				$data['branch_name'] = "";
				$data['region'] = "";
				$data['account_currency'] = "";
				$data['swift_code'] = "";
				$data['bank_city'] = "";
			}
			if(!empty($store_docs)){
				$data['cr_certificate'] = $store_docs->cr_certificate;
				$data['vat_certificate'] = $store_docs->vat_certificate;
				$data['national_address'] = $store_docs->national_address;
				$data['iban_letter'] = $store_docs->iban_letter;
				$data['credit_agreements'] = $store_docs->credit_agreements;
				$data['authorization'] = $store_docs->authorization;
				$data['baladiya'] = $store_docs->baladiya;
				$data['franchisee'] = $store_docs->franchisee;
			}else{
				$data['cr_certificate'] = "";
				$data['vat_certificate'] = "";
				$data['national_address'] = "";
				$data['iban_letter'] = "";
				$data['credit_agreements'] = "";
				$data['authorization'] = "";
				$data['baladiya'] = "";
				$data['franchisee'] = "";
			}
		}
		else{
			$data['id'] = "";
			$data['store_name'] = "";
			$data['store_name_arabic'] = "";
			$data['store_id'] = "";
			$data['store_incharge'] = "";
			$data['email'] = "";
			$data['contact_number'] = "";
			$data['google_coordinates_lat'] = "";
			$data['google_coordinates_long'] = "";
			$data['store_radius'] = "";
			$data['store_location'] = "";
		    $data['status'] = "";

		    $data['cat_name_1'] = "";
		    $data['monthly_sub_1'] = "";
		    $data['online_payment_fee_1'] = "";
		    $data['cat_name_2'] = "";
		    $data['monthly_sub_2'] = "";
		    $data['online_payment_fee_2'] = "";
		    $data['cat_name_3'] = "";
		    $data['monthly_sub_3'] = "";
		    $data['online_payment_fee_3'] = "";
		    $data['cat_name_4'] = "";
		    $data['monthly_sub_4'] = "";
		    $data['online_payment_fee_4'] = "";
		    $data['password'] = "";
		    $data['price'] = "";
		    $data['discount'] = "";
		    $data['agrement_start'] = "";
		    $data['brand_name'] = "";
		    $data['agrement_num'] = "";
		    $data['trademark'] = "";
		    $data['email_invoice'] = "";

			$data['agrement_expiry'] = "";
			$data['cr_no'] = "";
			$data['cr_expiry'] = "";
			$data['vat_no'] = "";
			$data['vat_expiry'] = "";
			$data['fax'] = "";
			$data['website'] = "";
			
			$data['sales_name'] = "";
			$data['sales_mobile'] = "";
			$data['sales_email'] = "";
			$data['sales_id'] = "";
			$data['sales_position'] = "";
			$data['finance_name'] = "";
			$data['finance_mobile'] = "";
			$data['finance_email'] = "";
			$data['finance_id'] = "";
			$data['finance_position'] = "";
			$data['legal_name'] = "";
			$data['legal_mobile'] = "";
			$data['legal_email'] = "";
			$data['legal_id'] = "";
			$data['legal_position'] = "";
			$data['other_name'] = "";
			$data['other_mobile'] = "";
			$data['other_email'] = "";
			$data['other_id'] = "";
			$data['other_position'] = "";
			
			$data['building_no'] = "";
			$data['street_name'] = "";
			$data['district'] = "";
			// $data['region_id'] = "";
			$data['city'] = "";
			$data['country'] = "";
			$data['postal_code'] = "";
			$data['additional_no'] = "";
			$data['unit_no'] = "";
			$data['short_address'] = "";
			$data['payment_terms'] = "";
			$data['order_currency'] = "";
			$data['credit_limit'] = "";
			
			$data['bank_account_no'] = "";
		    $data['account_holder_name'] = "";
		    $data['iban_number'] = "";
		    $data['bank_name'] = "";
		    $data['branch_name'] = "";
		    $data['region'] = "";
		    $data['account_currency'] = "";
		    $data['swift_code'] = "";
		    $data['bank_city'] = "";
			
			$data['cr_certificate'] = "";
		    $data['vat_certificate'] = "";
		    $data['national_address'] = "";
		    $data['iban_letter'] = "";
		    $data['credit_agreements'] = "";
		    $data['authorization'] = "";
			$data['baladiya'] = "";
			$data['franchisee'] = "";
		}
		$data['regions'] = $this->Common_model->get_regions()->result();
		$data['master_cities'] = $this->Store_model->cities();
		$this->load->view('admin/store/form-third-party',$data);
	}
	
	public function save_thirdparty(){
		$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
		$this->form_validation->set_rules('store_name_arabic', 'Arabic Name', 'trim|required');
		$this->form_validation->set_rules('store_id', 'Store ID', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('store_incharge', 'Store Incharge', 'trim|required');
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required');
		$this->form_validation->set_rules('agrement_start', 'Agrement Start', 'trim|required');
		$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
		$this->form_validation->set_rules('google_coordinates_lat', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('google_coordinates_long', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('store_radius', 'Store Radius', 'trim|required');
		$this->form_validation->set_rules('store_location', 'Complete Address', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Store_model->edit();
    		}
    		else{
				$data = $this->Store_model->get_last_agement();
				if(isset($data->agrement_num)){
					$agrement_num = $data->agrement_num + 1;
				} else {
					$agrement_num = '1';
				}
				$password = $this->role->get_random_password($chars_min = 8, $chars_max = 8, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
    			$hashpassword = $this->enc_lib->encrypt($password);
    			$query = $this->Store_model->add($hashpassword,$agrement_num);
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/store/list');
	}

	public function thirdparty_detail(){
		if($this->input->get('id')){
			$query = $this->Store_model->get_detail($this->input->get('id'));
			$store_docs = $this->Store_model->store_documents($this->input->get('id'));
			$store_bank = $this->Store_model->store_bank_account($this->input->get('id'));
			$data['id'] = $query->id;
			$data['store_name'] = $query->store_name;
			$data['store_name_arabic'] = $query->store_name_arabic;
			$data['store_id'] = $query->store_id;
			$data['store_incharge'] = $query->store_incharge;
			$data['email'] = $query->email;
			$data['contact_number'] = $query->contact_number;
			$data['google_coordinates_lat'] = $query->google_coordinates_lat;
			$data['google_coordinates_long'] = $query->google_coordinates_long;
			$data['store_radius'] = $query->store_radius;
			$data['store_location'] = $query->store_location;
		    $data['status'] = $query->status;

		    $data['cat_name_1'] = $query->cat_name_1;
		    $data['monthly_sub_1'] = $query->monthly_sub_1;
		    $data['online_payment_fee_1'] = $query->online_payment_fee_1;
		    $data['cat_name_2'] = $query->cat_name_2;
		    $data['monthly_sub_2'] = $query->monthly_sub_2;
		    $data['online_payment_fee_2'] = $query->online_payment_fee_2;
		    $data['cat_name_3'] = $query->cat_name_3;
		    $data['monthly_sub_3'] = $query->monthly_sub_3;
		    $data['online_payment_fee_3'] = $query->online_payment_fee_3;
		    $data['cat_name_4'] = $query->cat_name_4;
		    $data['monthly_sub_4'] = $query->monthly_sub_4;
		    $data['online_payment_fee_4'] = $query->online_payment_fee_4;
		    $data['password'] = $query->password;
		    $data['price'] = $query->price;
		    $data['discount'] = $query->discount;
		    $data['agrement_start'] = $query->agrement_start;
		    $data['brand_name'] = $query->brand_name;
		    $data['brand_name'] = $query->brand_name;
		    $data['agrement_num'] = $query->agrement_num;
		    $data['trademark'] = $query->trademark;
		    $data['email_invoice'] = $query->email_invoice;

			$data['agrement_expiry'] = $query->agrement_expiry;
			$data['cr_no'] = $query->cr_no;
			$data['cr_expiry'] = $query->cr_expiry;
			$data['vat_no'] = $query->vat_no;
			$data['vat_expiry'] = $query->vat_expiry;
			$data['fax'] = $query->fax;
			$data['website'] = $query->website;
			
			$data['sales_name'] = $query->sales_name;
			$data['sales_mobile'] = $query->sales_mobile;
			$data['sales_email'] = $query->sales_email;
			$data['sales_id'] = $query->sales_id;
			$data['sales_position'] = $query->sales_position;
			$data['finance_name'] = $query->finance_name;
			$data['finance_mobile'] = $query->finance_mobile;
			$data['finance_email'] = $query->finance_email;
			$data['finance_id'] = $query->finance_id;
			$data['finance_position'] = $query->finance_position;
			$data['legal_name'] = $query->legal_name;
			$data['legal_mobile'] = $query->legal_mobile;
			$data['legal_email'] = $query->legal_email;
			$data['legal_id'] = $query->legal_id;
			$data['legal_position'] = $query->legal_position;
			$data['other_name'] = $query->other_name;
			$data['other_mobile'] = $query->other_mobile;
			$data['other_email'] = $query->other_email;
			$data['other_id'] = $query->other_id;
			$data['other_position'] = $query->other_position;
			
			$data['building_no'] = $query->building_no;
			$data['street_name'] = $query->street_name;
			$data['district'] = $query->district;
			$data['city'] = $query->city;
			$data['country'] = $query->country;
			$data['postal_code'] = $query->postal_code;
			$data['additional_no'] = $query->additional_no;
			$data['unit_no'] = $query->unit_no;
		    $data['short_address'] = $query->short_address;
		    $data['payment_terms'] = $query->payment_terms;
		    $data['order_currency'] = $query->order_currency;
		    $data['credit_limit'] = $query->credit_limit;
			if(!empty($store_bank)){
				$data['bank_account_no'] = $store_bank->bank_account_no;
				$data['account_holder_name'] = $store_bank->account_holder_name;
				$data['iban_number'] = $store_bank->iban_number;
				$data['bank_name'] = $store_bank->bank_name;
				$data['branch_name'] = $store_bank->branch_name;
				$data['region'] = $store_bank->region;
				$data['account_currency'] = $store_bank->account_currency;
				$data['swift_code'] = $store_bank->swift_code;
				$data['bank_city'] = $store_bank->bank_city;
			}else{
				$data['bank_account_no'] = "";
				$data['account_holder_name'] = "";
				$data['iban_number'] = "";
				$data['bank_name'] = "";
				$data['branch_name'] = "";
				$data['region'] = "";
				$data['account_currency'] = "";
				$data['swift_code'] = "";
				$data['bank_city'] = "";
			}
			if(!empty($store_docs)){
				$data['cr_certificate'] = $store_docs->cr_certificate;
				$data['vat_certificate'] = $store_docs->vat_certificate;
				$data['national_address'] = $store_docs->national_address;
				$data['iban_letter'] = $store_docs->iban_letter;
				$data['credit_agreements'] = $store_docs->credit_agreements;
				$data['authorization'] = $store_docs->authorization;
				$data['baladiya'] = $store_docs->baladiya;
				$data['franchisee'] = $store_docs->franchisee;
			}else{
				$data['cr_certificate'] = "";
				$data['vat_certificate'] = "";
				$data['national_address'] = "";
				$data['iban_letter'] = "";
				$data['credit_agreements'] = "";
				$data['authorization'] = "";
				$data['baladiya'] = "";
				$data['franchisee'] = "";
			}
			
			$data['master_cities'] = $this->Store_model->cities();
			$this->load->view('admin/store/third-party-detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Store!!!");
			redirect('admin/store/list');
		}
	}

	public function changePassword(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
				$password = $this->input->post('password');
    			$hashpassword = $this->enc_lib->encrypt($password);
				//print_r('edfdf');exit();
				$query = $this->Store_model->changePassword($hashpassword);
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Password successfully changed");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/store/third-party-detail?id='.$id);
	}

	public function print_third(){
	    $this->load->library('Pdf_store_third');
		$id = $this->input->get('id');
		$order = $this->Store_model->getAllData($id);
		// print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_store_third(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Franchisee Store Agreement');
		$pdf->SetSubject('Franchisee Store Agreement');
		$pdf->SetKeywords('Baqala Station, PDF, Agreement, Franchisee Store');
		
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = '';
		$htmlHeader2 = '';
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = '';
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
		$htmlcontent = $this->load->view('admin/store/print_third_party',$order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('Franchisee Store Agreement '. $order->brand_name .'.pdf', 'I');
	}
	
}
