<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Logistic_Partner_model extends CI_Model
{
    public function __construct() {
		parent::__construct();
		$this->load->helper('sendmail_helper');
		$this->load->helper('Common_helper');
		$this->load->library('Enc_lib');
		$this->load->library('Role');
	}
	
    public function add_basic($hashpassword)
    {
        $created_at = CURRENT_TIME;
		
		$this->db->trans_start();
		$this->db->query("INSERT INTO delivery_partner SET 
			name = '" . $this->db->escape_str($this->input->post('company_name')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			website = '" . $this->db->escape_str($this->input->post('website')) . "', 
			company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', 
			company_arabic_name = '" . $this->db->escape_str($this->input->post('company_arabic_name')) . "', 
			business_nature = '" . $this->db->escape_str($this->input->post('business_nature')) . "', 
			company_type = '" . $this->db->escape_str($this->input->post('company_type')) . "', 
			vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', 
			vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', 
			cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', 
			cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', 
			agreement_start = '" . $this->db->escape_str($this->input->post('agreement_start')) . "', 
			agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', 
			client_telephone = '" . $this->db->escape_str($this->input->post('client_telephone')) . "', 
			client_fax = '" . $this->db->escape_str($this->input->post('client_fax')) . "', 
			account_manager = '" . $this->db->escape_str($this->input->post('account_manager')) . "',
			ip = '" . $_SERVER['REMOTE_ADDR'] . "', 
			status = '" . $this->db->escape_str($this->input->post('status')) . "', 
			password = '". $hashpassword ."', 
			created_at = '". $created_at ."', 
			updated_at = '". $created_at ."'");
		$user_id = $this->db->insert_id();
		
		if($user_id){
			$cust_account_no = $user_id + 100;
			$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
			$this->db->query("UPDATE delivery_partner SET customer_no = '". $final_account_no ."', partner_basic_status = '1' WHERE id = '". $user_id ."' LIMIT 1");
			$this->db->query("INSERT INTO del_partner_info SET partner_id = '" . $this->db->escape_str((int)$user_id) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', region_id = '" . $this->db->escape_str($this->input->post('region_id')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_id_no = '" . $this->db->escape_str($this->input->post('sales_id_no')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_id_no = '" . $this->db->escape_str($this->input->post('finance_id_no')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', director_name1 = '" . $this->db->escape_str($this->input->post('director_name1')) . "', director_id_no1 = '" . $this->db->escape_str($this->input->post('director_id_no1')) . "', director_mobile1 = '" . $this->db->escape_str($this->input->post('director_mobile1')) . "', director_email1 = '" . $this->db->escape_str($this->input->post('director_email1')) . "', director_name2 = '" . $this->db->escape_str($this->input->post('director_name2')) . "', director_id_no2 = '" . $this->db->escape_str($this->input->post('director_id_no2')) . "', director_mobile2 = '" . $this->db->escape_str($this->input->post('director_mobile2')) . "', director_email2 = '" . $this->db->escape_str($this->input->post('director_email2')) . "', created_at = '". $created_at ."', updated_at = '". $created_at ."'");
			$this->db->query("INSERT INTO del_partner_docs SET partner_id = '" . $this->db->escape_str((int)$user_id) . "', created_at = '". $created_at ."', updated_at = '". $created_at ."'");
			$this->db->query("INSERT INTO del_partner_bank SET partner_id = '" . $this->db->escape_str((int)$user_id) . "', created_at = '". $created_at ."', updated_at = '". $created_at ."'");
		}
		$this->db->trans_complete();
// 		if($this->db->trans_status() === TRUE){
// 		    $emp_detail = $this->db->query("SELECT id, customer_no, cr_no, name, company_name, account_manager, email, password from delivery_partner WHERE id = '". $user_id ."'")->row();
// 		    $email = $emp_detail->email;
// 			$data['username'] = $emp_detail->cr_no;
// 			$data['company_name'] = $emp_detail->company_name;
// 			$hashpassword = $this->enc_lib->dycrypt($emp_detail->password);
// 			$manager = employeeDetailHelper($emp_detail->account_manager);
// 			$data['manager_detail'] = $manager;
// 			send_logistic_credential($email,$hashpassword,$data);
// 		}
		return $this->db->trans_status() === FALSE ? FALSE : TRUE ;
    }
	
    public function update_basic()
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
        $this->db->query("UPDATE delivery_partner SET 
			name = '" . $this->db->escape_str($this->input->post('company_name')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			website = '" . $this->db->escape_str($this->input->post('website')) . "', 
			company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', 
			company_arabic_name = '" . $this->db->escape_str($this->input->post('company_arabic_name')) . "', 
			business_nature = '" . $this->db->escape_str($this->input->post('business_nature')) . "', 
			company_type = '" . $this->db->escape_str($this->input->post('company_type')) . "', 
			vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', 
			vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', 
			cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', 
			cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', 
			agreement_start = '" . $this->db->escape_str($this->input->post('agreement_start')) . "', 
			agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', 
			client_telephone = '" . $this->db->escape_str($this->input->post('client_telephone')) . "', 
			client_fax = '" . $this->db->escape_str($this->input->post('client_fax')) . "', 
			account_manager = '" . $this->db->escape_str($this->input->post('account_manager')) . "',
			ip = '" . $_SERVER['REMOTE_ADDR'] . "', 
			status = '" . $this->db->escape_str($this->input->post('status')) . "', 
			updated_at = '". $created_at ."'
			WHERE id = '" . (int)$this->input->post('id') . "'");

		$this->db->query("UPDATE del_partner_info SET 
			building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', 
			street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', 
			district = '" . $this->db->escape_str($this->input->post('district')) . "', 
			region_id = '" . $this->db->escape_str($this->input->post('region_id')) . "', 
			city = '" . $this->db->escape_str($this->input->post('city')) . "', 
			country = '" . $this->db->escape_str($this->input->post('country')) . "', 
			postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', 
			additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', 
			unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', 
			short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', 
			website = '" . $this->db->escape_str($this->input->post('website')) . "', 
			sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', 
			sales_id_no = '" . $this->db->escape_str($this->input->post('sales_id_no')) . "', 
			sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', 
			sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', 
			finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', 
			finance_id_no = '" . $this->db->escape_str($this->input->post('finance_id_no')) . "', 
			finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', 
			finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', 
			updated_at = '" . $created_at ."' 
			WHERE partner_id = '" . (int)$this->input->post('id') . "'");
        $this->db->trans_complete();
        return $this->db->trans_status() === FALSE ? FALSE : TRUE;
    }
	/*
    public function update_contact_info()
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
        $this->db->query("UPDATE del_partner_info SET 
			building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', 
			street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', 
			district = '" . $this->db->escape_str($this->input->post('district')) . "', 
			region_id = '" . $this->db->escape_str($this->input->post('region_id')) . "', 
			city = '" . $this->db->escape_str($this->input->post('city')) . "', 
			country = '" . $this->db->escape_str($this->input->post('country')) . "', 
			postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', 
			additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', 
			unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', 
			short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', 
			website = '" . $this->db->escape_str($this->input->post('website')) . "', 
			sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', 
			sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', 
			sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', 
			finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', 
			finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', 
			finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', 
			legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', 
			legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', 
			legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', 
			other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', 
			other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', 
			other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', 
			updated_at = '" . $created_at ."' 
			WHERE partner_id = '" . (int)$this->input->post('partner_id') . "'");

		$this->db->query("UPDATE delivery_partner SET partner_info_status = '1' WHERE id = '" . (int)$this->input->post('partner_id') . "'");
        $this->db->trans_complete();
        return $this->db->trans_status() === FALSE ? FALSE : TRUE;
    }
	*/
	public function update_bank_detail()
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
        $query = $this->db->query("UPDATE del_partner_bank SET 
			bank_account_no = '" . $this->db->escape_str($this->input->post('bank_account_no')) . "', 
			account_holder_name = '" . $this->db->escape_str($this->input->post('account_holder_name')) . "', 
			iban_number = '" . $this->db->escape_str($this->input->post('iban_number')) . "', 
			bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', 
			branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', 
			region = '" . $this->db->escape_str($this->input->post('region')) . "', 
			account_currency = '" . $this->db->escape_str($this->input->post('account_currency')) . "', 
			swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', 
			bank_city = '" . $this->db->escape_str($this->input->post('bank_city')) . "', 
			updated_at = '" . $created_at ."' 
			WHERE partner_id = '" . (int)$this->input->post('partner_id') . "'"); 
		if($query){
			$this->db->query("UPDATE delivery_partner SET partner_bank_status = '1' WHERE id = '" . (int)$this->input->post('partner_id') . "'");
		}
        $this->db->trans_complete();
        return $query;
    }
    
	public function update_commission_detail()
    {
		$query = false;
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
		$partner_id = (int)$this->input->post('partner_id');
		$this->db->query("DELETE FROM logistic_commission_structure WHERE partner_id = '" . $partner_id . "'");
		if($this->input->post('min_range')){
			$range_count = count($this->input->post('min_range'));
			for($r=0;$r<$range_count;$r++){
				$min_range = $this->input->post('min_range');
				$max_range = $this->input->post('max_range');
				$comm_amount = $this->input->post('comm_amount');
				$query = $this->db->query("INSERT INTO logistic_commission_structure SET partner_id = '" . $partner_id . "', min_range = '" . $this->db->escape_str($min_range[$r]) . "', max_range = '" . $this->db->escape_str($max_range[$r]) . "', comm_amount = '" . $this->db->escape_str($comm_amount[$r]) . "'");
			}
		}
        $this->db->trans_complete();
        return $query;
    }

    #Upload Files Start

    function upload_cr_certificate(){
		$this->load->helper('string');
		//print_r($this->input->post());exit();
		
		$path = './uploads/logistic-partner/cr/';
		if (!is_dir('uploads/logistic-partner/cr/')) {
			mkdir($path, 0777, TRUE);
		}
		//$con['image_library'] = 'gd2';
		//$con['source_image'] = $path;
		//$con['create_thumb'] = TRUE;
		//$con['maintain_ratio'] = TRUE;
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx'; 
		//$con['quality'] = '60%';  
		//$con['width'] = 200;  
		//$con['height'] = 200;
		//$con['rotation_angle'] = 270;
		//$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		//$this->upload->initialize($con);
		//$this->image_lib->resize();
		if($_FILES['cr_certificate']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('cr_certificate');
			$image_data1 = $this->upload->data();
			$cr_certificate = "uploads/logistic-partner/cr/".$image_data1['file_name'];
		}
		else{
			$cr_certificate = $this->input->post('o_cr_certificate');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET cr_certificate='" . $cr_certificate . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
		/* @TODO Mail and SmS */
	}

	function upload_vat_certificate(){
		$this->load->helper('string');
		
		$path = './uploads/logistic-partner/vat/';
		if (!is_dir('uploads/logistic-partner/vat/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['vat_certificate']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('vat_certificate');
			$image_data1 = $this->upload->data();
			$vat_certificate = "uploads/logistic-partner/vat/".$image_data1['file_name'];
		}
		else{
			$vat_certificate = $this->input->post('o_vat_certificate');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET vat_certificate='" . $vat_certificate . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_iban_certificate(){
		$this->load->helper('string');
		
		$path = './uploads/logistic-partner/iban/';
		if (!is_dir('uploads/logistic-partner/iban/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['iban_certificate']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('iban_certificate');
			$image_data1 = $this->upload->data();
			$iban_certificate = "uploads/logistic-partner/iban/".$image_data1['file_name'];
		}
		else{
			$iban_certificate = $this->input->post('o_iban_certificate');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET iban_certificate='" . $iban_certificate . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_owner_id(){
		$this->load->helper('string');
		
		$path = './uploads/logistic-partner/ownerid/';
		if (!is_dir('uploads/logistic-partner/ownerid/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['owner_id']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('owner_id');
			$image_data1 = $this->upload->data();
			$owner_id = "uploads/logistic-partner/ownerid/".$image_data1['file_name'];
		}
		else{
			$owner_id = $this->input->post('o_owner_id');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET owner_id='" . $owner_id . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_credit_agreement(){
		$this->load->helper('string');
		
		$path = './uploads/logistic-partner/credit/';
		if (!is_dir('uploads/logistic-partner/credit/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['credit_agreement']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('credit_agreement');
			$image_data1 = $this->upload->data();
			$credit_agreement = "uploads/logistic-partner/credit/".$image_data1['file_name'];
		}
		else{
			$credit_agreement = $this->input->post('o_credit_agreement');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET credit_agreement='" . $credit_agreement . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_authorization_copy(){
		$this->load->helper('string');
		
		$path = './uploads/logistic-partner/authorization/';
		if (!is_dir('uploads/logistic-partner/authorization/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['authorization_copy']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('authorization_copy');
			$image_data1 = $this->upload->data();
			$authorization_copy = "uploads/logistic-partner/authorization/".$image_data1['file_name'];
		}
		else{
			$authorization_copy = $this->input->post('o_authorization_copy');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET authorization_copy='" . $authorization_copy . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_authorize_person_id(){
		$this->load->helper('string');
		
		$path = './uploads/logistic-partner/person_id/';
		if (!is_dir('uploads/logistic-partner/person_id/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['authorize_person_id']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('authorize_person_id');
			$image_data1 = $this->upload->data();
			$authorize_person_id = "uploads/logistic-partner/person_id/".$image_data1['file_name'];
		}
		else{
			$authorize_person_id = $this->input->post('o_authorize_person_id');
		}
			
		$query = $this->db->query("UPDATE del_partner_docs SET authorize_person_id='" . $authorize_person_id . "', updated_at = now() WHERE partner_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

    #Upload Files End

    function make_query(){
		$a = "SELECT dp.* FROM delivery_partner dp WHERE 1=1";
	   return $a;
	}
	
	function get_list($keyword,$status,$application_status,$vat_no,$cr_no){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (dp.name LIKE '%".$keyword."%' OR dp.company_name LIKE '%".$keyword."%' OR dp.email LIKE '%".$keyword."%' OR dp.customer_no LIKE '%".$keyword."%')";
		}
		if($status){
			if($status == 'pending'){
				$a .= " AND dp.status = '0'";
			}
			if($status == 'active'){
				$a .= " AND dp.status = '1'";
			}
			if($status == 'blocked'){
				$a .= " AND dp.status = '2'";
			}
		}
		if($application_status){
			$a .= " AND dp.application_status = '" . $application_status . "'";
		}
		if($vat_no){
			$a .= " AND dp.vat_no = '" . $vat_no . "'";
		}
		if($cr_no){
			$a .= " AND dp.cr_no = '" . $cr_no . "'";
		}
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = date("Y-m-d", strtotime($this->input->get('from')));
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (dp.created_at BETWEEN '". $v_from ."' AND '". $d_to ."')";
			}
		}
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND dp.name LIKE '%".$_POST["search"]["value"]."%' OR dp.company_name LIKE '%".$_POST["search"]["value"]."%' OR dp.email LIKE '%".$_POST["search"]["value"]."%'";
		// }
		if(isset($_POST["order"])){             
			$a .= " ORDER BY dp.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY dp.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($keyword,$status,$application_status,$vat_no,$cr_no){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (dp.name LIKE '%".$_POST["search"]["value"]."%' OR dp.company_name LIKE '%".$_POST["search"]["value"]."%' OR dp.email LIKE '%".$_POST["search"]["value"]."%' OR dp.customer_no LIKE '%".$_POST["search"]["value"]."%')";
		}
		if($status){
			if($status == 'pending'){
				$a .= " AND dp.status = '0'";
			}
			if($status == 'active'){
				$a .= " AND dp.status = '1'";
			}
			if($status == 'blocked'){
				$a .= " AND dp.status = '2'";
			}
		}
		if($application_status){
			$a .= " AND dp.application_status = '" . $application_status . "'";
		}
		if($vat_no){
			$a .= " AND dp.vat_no = '" . $vat_no . "'";
		}
		if($cr_no){
			$a .= " AND dp.cr_no = '" . $cr_no . "'";
		}
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = date("Y-m-d", strtotime($this->input->get('from')));
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (dp.created_at BETWEEN '". $v_from ."' AND '". $d_to ."')";
			}
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('delivery_partner');  
	   return $this->db->count_all_results();
    }

	public function get_detail($id)
    {
        $query = $this->db->query("SELECT dp.* FROM delivery_partner dp WHERE dp.id = '" . (int) $id . "'");
        return $query;
    }

	public function documents($id){
		$query = $this->db->query("SELECT * FROM del_partner_docs WHERE partner_id = '" . (int) $id . "'")->row();
		return $query;
	}

	public function partner_info($id){
		$query = $this->db->query("SELECT * FROM del_partner_info WHERE partner_id = '" . (int) $id . "'")->row_array();
		return $query;
	}

	public function bank_info($id){
		$query = $this->db->query("SELECT * FROM del_partner_bank WHERE partner_id = '" . (int) $id . "'")->row();
		return $query;
	}
    
	public function commssion_info($id){
		$query = $this->db->query("SELECT * FROM logistic_commission_structure WHERE partner_id = '" . (int) $id . "'")->result_array();
		return $query;
	}

    public function rider_list($id){
		$query = $this->db->query("SELECT * FROM delivery_vehicles WHERE partner_id = '" . (int) $id . "'")->result();
		return $query;
	}
	
    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM delivery_partner WHERE id IN (" . $id . ")");
        $query = $this->db->query("DELETE FROM del_partner_info WHERE partner_id IN (" . $id . ")");
        $query = $this->db->query("DELETE FROM del_partner_bank WHERE partner_id IN (" . $id . ")");
        $query = $this->db->query("DELETE FROM del_partner_docs WHERE partner_id IN (" . $id . ")");
        $query = $this->db->query("DELETE FROM logistic_commission_structure WHERE partner_id IN (" . $id . ")");
        return $query;
    }

	public function change_password($hashpassword)
    {
        //echo $this->input->post('status');exit();
        $query = $this->db->query("UPDATE delivery_partner SET password = '" . $hashpassword . "', updated_at = NOW(), ip = '" . $this->input->ip_address() . "' WHERE id = '" . (int) $this->input->post('id') . "' LIMIT 1");
        return $query;
    }
	
}
