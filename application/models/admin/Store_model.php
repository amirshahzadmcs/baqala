<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store_model extends CI_Model{

	function add($password,$agrement_num){
		$con['upload_path']   = './uploads/store_doc/'; 
		$con['allowed_types'] = 'pdf|docx|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;

		$query = $this->db->query("INSERT INTO stores SET store_type = '" . $this->db->escape_str((int)$this->input->post('store_type')) . "', store_name = '" . $this->db->escape_str($this->input->post('store_name')) . "', cat_name_4 = '" . $this->db->escape_str($this->input->post('cat_name_4')) . "', monthly_sub_4 = '" . $this->db->escape_str($this->input->post('monthly_sub_4')) . "', online_payment_fee_4 = '" . $this->db->escape_str($this->input->post('online_payment_fee_4')) . "', online_payment_fee_3 = '" . $this->db->escape_str($this->input->post('online_payment_fee_3')) . "', monthly_sub_3 = '" . $this->db->escape_str($this->input->post('monthly_sub_3')) . "', cat_name_3 = '" . $this->db->escape_str($this->input->post('cat_name_3')) . "', online_payment_fee_2 = '" . $this->db->escape_str($this->input->post('online_payment_fee_2')) . "', monthly_sub_2 = '" . $this->db->escape_str($this->input->post('monthly_sub_2')) . "', cat_name_2 = '" . $this->db->escape_str($this->input->post('cat_name_2')) . "', cat_name_1 = '" . $this->db->escape_str($this->input->post('cat_name_1')) . "', legal_position = '" . $this->db->escape_str($this->input->post('legal_position')) . "', finance_position = '" . $this->db->escape_str($this->input->post('finance_position')) . "', sales_position = '" . $this->db->escape_str($this->input->post('sales_position')) . "', other_position = '" . $this->db->escape_str($this->input->post('other_position')) . "', other_id = '" . $this->db->escape_str($this->input->post('other_id')) . "', legal_id = '" . $this->db->escape_str($this->input->post('legal_id')) . "', finance_id = '" . $this->db->escape_str($this->input->post('finance_id')) . "', sales_id = '" . $this->db->escape_str($this->input->post('sales_id')) . "', email_invoice = '" . $this->db->escape_str($this->input->post('email_invoice')) . "', trademark = '" . $this->db->escape_str($this->input->post('trademark')) . "', monthly_sub_1 = '" . $this->db->escape_str($this->input->post('monthly_sub_1')) . "', online_payment_fee_1 = '" . $this->db->escape_str($this->input->post('online_payment_fee_1')) . "', price = '" . $this->db->escape_str($this->input->post('price')) . "', discount = '" . $this->db->escape_str($this->input->post('discount')) . "', brand_name = '" . $this->db->escape_str($this->input->post('brand_name')) . "', agrement_start = '" . $this->db->escape_str($this->input->post('agrement_start')) . "', agrement_num = '" . $this->db->escape_str($agrement_num) . "', store_name_arabic = '" . $this->db->escape_str($this->input->post('store_name_arabic')) . "', store_id = '" . $this->db->escape_str($this->input->post('store_id')) . "', store_incharge = '" . $this->db->escape_str($this->input->post('store_incharge')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', contact_number = '" . $this->db->escape_str($this->input->post('contact_number')) . "', google_coordinates_lat = '" . $this->db->escape_str($this->input->post('google_coordinates_lat')) . "', google_coordinates_long = '" . $this->db->escape_str($this->input->post('google_coordinates_long')) . "', store_radius = '" . $this->db->escape_str((int)$this->input->post('store_radius')) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', fax = '" . $this->db->escape_str($this->input->post('fax')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', payment_terms = '" . $this->db->escape_str($this->input->post('payment_terms')) . "', order_currency = '" . $this->db->escape_str($this->input->post('order_currency')) . "', credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', avl_credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', store_location = '" . $this->db->escape_str($this->input->post('store_location')) . "', password = '" . $password . "', ip = '".$this->input->ip_address()."', status = '" . $this->db->escape_str((int)$this->input->post('status')) . "', created_at = NOW(), updated_at = now()");
		$store_id = $this->db->insert_id();
		
		if($store_id && $this->input->post('bank_account_no') !== ''){
			$query1 = $this->db->query("INSERT INTO store_bank_account SET store_id = '" . $this->db->escape_str((int)$store_id) . "', bank_account_no = '" . $this->db->escape_str($this->input->post('bank_account_no')) . "', account_holder_name = '" . $this->db->escape_str($this->input->post('account_holder_name')) . "', iban_number = '" . $this->db->escape_str($this->input->post('iban_number')) . "', bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', region = '" . $this->db->escape_str($this->input->post('region')) . "', account_currency = '" . $this->db->escape_str($this->input->post('account_currency')) . "', swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', bank_city = '" . $this->db->escape_str($this->input->post('bank_city')) . "', created_at = NOW(), updated_at = now()");
		}
		if($store_id && $this->input->post('store_type') == '2'){
			if($_FILES['cr_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('cr_certificate');
				$image_data1 = $this->upload->data();
				$cr_certificate = "uploads/store_doc/".$image_data1['file_name'];
			}
			else{
				$cr_certificate = "";
			}
			
			if($_FILES['vat_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('vat_certificate');
				$image_data2 = $this->upload->data();
				$vat_certificate = "uploads/store_doc/".$image_data2['file_name'];
			}
			else{
				$vat_certificate = "";
			}
			
			if($_FILES['national_address']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('national_address');
				$image_data3 = $this->upload->data();
				$national_address = "uploads/store_doc/".$image_data3['file_name'];
			}
			else{
				$national_address = "";
			}
			
			if($_FILES['iban_letter']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('iban_letter');
				$image_data4 = $this->upload->data();
				$iban_letter = "uploads/store_doc/".$image_data4['file_name'];
			}
			else{
				$iban_letter = "";
			}
			
			if($_FILES['credit_agreements']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('credit_agreements');
				$image_data5 = $this->upload->data();
				$credit_agreements = "uploads/store_doc/".$image_data5['file_name'];
			}
			else{
				$credit_agreements = "";
			}
			
			if($_FILES['authorization']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorization');
				$image_data6 = $this->upload->data();
				$authorization = "uploads/store_doc/".$image_data6['file_name'];
			}
			else{
				$authorization = "";
			}
			
			if($_FILES['baladiya']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('baladiya');
				$image_data7 = $this->upload->data();
				$baladiya = "uploads/store_doc/".$image_data7['file_name'];
			}
			else{
				$baladiya = "";
			}
			
			if($_FILES['franchisee']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('franchisee');
				$image_data8 = $this->upload->data();
				$franchisee = "uploads/store_doc/".$image_data8['file_name'];
			}
			else{
				$franchisee = "";
			}
			$query2 = $this->db->query("INSERT INTO store_docs SET store_id = '" . $this->db->escape_str((int)$store_id) . "', cr_certificate = '" . $this->db->escape_str($cr_certificate) . "', vat_certificate = '" . $this->db->escape_str($vat_certificate) . "', national_address = '" . $this->db->escape_str($national_address) . "', iban_letter = '" . $this->db->escape_str($iban_letter) . "', credit_agreements = '" . $this->db->escape_str($credit_agreements) . "', authorization = '" . $this->db->escape_str($authorization) . "', baladiya = '" . $this->db->escape_str($baladiya) . "', franchisee = '" . $this->db->escape_str($franchisee) . "', created_at =  NOW(), updated_at = NOW()");
		}
		return $query;
	}
	
	function edit(){
		$con['upload_path']   = './uploads/store_doc/'; 
		$con['allowed_types'] = 'pdf|docx|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;

		$query = $this->db->query("UPDATE stores SET store_type = '" . $this->db->escape_str((int)$this->input->post('store_type')) . "', store_name = '" . $this->db->escape_str($this->input->post('store_name')) . "', cat_name_4 = '" . $this->db->escape_str($this->input->post('cat_name_4')) . "', monthly_sub_4 = '" . $this->db->escape_str($this->input->post('monthly_sub_4')) . "', online_payment_fee_4 = '" . $this->db->escape_str($this->input->post('online_payment_fee_4')) . "', online_payment_fee_3 = '" . $this->db->escape_str($this->input->post('online_payment_fee_3')) . "', monthly_sub_3 = '" . $this->db->escape_str($this->input->post('monthly_sub_3')) . "', cat_name_3 = '" . $this->db->escape_str($this->input->post('cat_name_3')) . "', online_payment_fee_2 = '" . $this->db->escape_str($this->input->post('online_payment_fee_2')) . "', monthly_sub_2 = '" . $this->db->escape_str($this->input->post('monthly_sub_2')) . "', cat_name_2 = '" . $this->db->escape_str($this->input->post('cat_name_2')) . "', cat_name_1 = '" . $this->db->escape_str($this->input->post('cat_name_1')) . "', legal_position = '" . $this->db->escape_str($this->input->post('legal_position')) . "', finance_position = '" . $this->db->escape_str($this->input->post('finance_position')) . "', sales_position = '" . $this->db->escape_str($this->input->post('sales_position')) . "', other_position = '" . $this->db->escape_str($this->input->post('other_position')) . "', other_id = '" . $this->db->escape_str($this->input->post('other_id')) . "', legal_id = '" . $this->db->escape_str($this->input->post('legal_id')) . "', finance_id = '" . $this->db->escape_str($this->input->post('finance_id')) . "', sales_id = '" . $this->db->escape_str($this->input->post('sales_id')) . "', email_invoice = '" . $this->db->escape_str($this->input->post('email_invoice')) . "', trademark = '" . $this->db->escape_str($this->input->post('trademark')) . "', monthly_sub_1 = '" . $this->db->escape_str($this->input->post('monthly_sub_1')) . "', online_payment_fee_1 = '" . $this->db->escape_str($this->input->post('online_payment_fee_1')) . "', price = '" . $this->db->escape_str($this->input->post('price')) . "', discount = '" . $this->db->escape_str($this->input->post('discount')) . "', brand_name = '" . $this->db->escape_str($this->input->post('brand_name')) . "', agrement_start = '" . $this->db->escape_str($this->input->post('agrement_start')) . "', agrement_num = '" . $this->db->escape_str($this->input->post('agrement_num')) . "', store_name_arabic = '" . $this->db->escape_str($this->input->post('store_name_arabic')) . "', store_id = '" . $this->db->escape_str($this->input->post('store_id')) . "', store_incharge = '" . $this->db->escape_str($this->input->post('store_incharge')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', contact_number = '" . $this->db->escape_str($this->input->post('contact_number')) . "', google_coordinates_lat = '" . $this->db->escape_str($this->input->post('google_coordinates_lat')) . "', google_coordinates_long = '" . $this->db->escape_str($this->input->post('google_coordinates_long')) . "', store_radius = '" . $this->db->escape_str((int)$this->input->post('store_radius')) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', fax = '" . $this->db->escape_str($this->input->post('fax')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', payment_terms = '" . $this->db->escape_str($this->input->post('payment_terms')) . "', order_currency = '" . $this->db->escape_str($this->input->post('order_currency')) . "', credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', avl_credit_limit = '" . $this->db->escape_str($this->input->post('credit_limit')) . "', store_location = '" . $this->db->escape_str($this->input->post('store_location')) . "', password = '" . $this->db->escape_str($this->input->post('oldPass')) . "', ip = '".$this->input->ip_address()."', status = '" . $this->db->escape_str((int)$this->input->post('status')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		
		if($this->input->post('id') !== ''){
			$this->db->query("DELETE FROM store_bank_account WHERE store_id = '" . (int)$this->input->post('id') . "'");
			$query1 = $this->db->query("INSERT INTO store_bank_account SET store_id = '" . $this->db->escape_str((int)$this->input->post('id')) . "', bank_account_no = '" . $this->db->escape_str($this->input->post('bank_account_no')) . "', account_holder_name = '" . $this->db->escape_str($this->input->post('account_holder_name')) . "', iban_number = '" . $this->db->escape_str($this->input->post('iban_number')) . "', bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', region = '" . $this->db->escape_str($this->input->post('region')) . "', account_currency = '" . $this->db->escape_str($this->input->post('account_currency')) . "', swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', bank_city = '" . $this->db->escape_str($this->input->post('bank_city')) . "', created_at = NOW(), updated_at = now()");
		}
		
		$this->db->query("DELETE FROM store_docs WHERE store_id = '" . (int)$this->input->post('id') . "'");
		if($this->input->post('id') !== '' && $this->input->post('store_type') == '2'){
			if($_FILES['cr_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('cr_certificate');
				$image_data1 = $this->upload->data();
				$cr_certificate = "uploads/store_doc/".$image_data1['file_name'];
			}
			else{
				$cr_certificate = $this->input->post('old_cr_certificate');
			}
			
			if($_FILES['vat_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('vat_certificate');
				$image_data2 = $this->upload->data();
				$vat_certificate = "uploads/store_doc/".$image_data2['file_name'];
			}
			else{
				$vat_certificate = $this->input->post('old_vat_certificate');
			}
			
			if($_FILES['national_address']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('national_address');
				$image_data3 = $this->upload->data();
				$national_address = "uploads/store_doc/".$image_data3['file_name'];
			}
			else{
				$national_address = $this->input->post('old_national_address');
			}
			
			if($_FILES['iban_letter']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('iban_letter');
				$image_data4 = $this->upload->data();
				$iban_letter = "uploads/store_doc/".$image_data4['file_name'];
			}
			else{
				$iban_letter = $this->input->post('old_iban_letter');
			}
			
			if($_FILES['credit_agreements']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('credit_agreements');
				$image_data5 = $this->upload->data();
				$credit_agreements = "uploads/store_doc/".$image_data5['file_name'];
			}
			else{
				$credit_agreements = $this->input->post('old_credit_agreements');
			}
			
			if($_FILES['authorization']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorization');
				$image_data6 = $this->upload->data();
				$authorization = "uploads/store_doc/".$image_data6['file_name'];
			}
			else{
				$authorization = $this->input->post('old_authorization');
			}
			
			if($_FILES['baladiya']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('baladiya');
				$image_data6 = $this->upload->data();
				$baladiya = "uploads/store_doc/".$image_data6['file_name'];
			}
			else{
				$baladiya = $this->input->post('old_baladiya');
			}
			
			if($_FILES['franchisee']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('franchisee');
				$image_data6 = $this->upload->data();
				$franchisee = "uploads/store_doc/".$image_data6['file_name'];
			}
			else{
				$franchisee = $this->input->post('old_franchisee');
			}
			$query2 = $this->db->query("INSERT INTO store_docs SET store_id = '" . $this->db->escape_str((int)$this->input->post('id')) . "', cr_certificate = '" . $this->db->escape_str($cr_certificate) . "', vat_certificate = '" . $this->db->escape_str($vat_certificate) . "', national_address = '" . $this->db->escape_str($national_address) . "', iban_letter = '" . $this->db->escape_str($iban_letter) . "', credit_agreements = '" . $this->db->escape_str($credit_agreements) . "', authorization = '" . $this->db->escape_str($authorization) . "', baladiya = '" . $this->db->escape_str($baladiya) . "', franchisee = '" . $this->db->escape_str($franchisee) . "', created_at =  NOW(), updated_at = NOW()");
		}
		return $query;
	}
	
	function make_query(){
		$a = "SELECT s.* FROM stores s WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND s.store_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND s.store_name_arabic LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY s.store_name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY s.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('stores');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM stores WHERE id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM store_docs WHERE store_id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM store_bank_account WHERE store_id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	public function getLoginDetail($store_id) {
        $sql = "SELECT s.store_id, s.password FROM stores s WHERE s.id = '" . (int)$store_id . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM stores WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function get_last_agement(){
		$query = $this->db->query("SELECT agrement_num FROM stores WHERE store_type = 2 ORDER BY created_at DESC LIMIT 1");
		return $query->row();
	}
	
	function store_documents($id){
		$query = $this->db->query("SELECT * FROM store_docs WHERE store_id = '" . $id . "'");
		return $query->row();
	}
	
	function store_bank_account($id){
		$query = $this->db->query("SELECT * FROM store_bank_account WHERE store_id = '" . $id . "'");
		return $query->row();
	}
	
	function cities(){
		$query = $this->db->query("SELECT * FROM master_city WHERE status = 1 ORDER BY city_name ASC");
		return $query->result();
	}

	public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE stores SET status = '1' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE stores SET status = '0' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}

	public function changePassword($password) {
	    $query = $this->db->query("UPDATE stores SET password = '" . $password . "', ip = '".$this->input->ip_address()."', updated_at = now() WHERE id = '". $this->input->post('id') ."' LIMIT 1");
	    return $query;
	}

	public function getAllData($id)
	{
		$query = $this->db->query("SELECT s.*,b.account_holder_name,b.iban_number,b.bank_name FROM stores s, store_bank_account b WHERE s.id = '" . (int)$id . "' AND s.id = b.store_id");
		return $query->row();
	}
	
}
