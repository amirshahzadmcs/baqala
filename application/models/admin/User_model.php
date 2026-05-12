<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	
	function add_customer(){
		$this->load->helper('string');
		$query = $this->db->query("INSERT INTO customer SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', role_id = '" . (int)$this->input->post('role_id') . "', email_verify = '1', salt = '" . $this->db->escape_str($salt = random_string('alnum', 20)) . "', password = '" . $this->db->escape_str(sha1($salt . sha1($salt . sha1($this->input->post('password'))))) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', created = NOW(), modified = NOW()");
		$user_id = $this->db->insert_id();
		if($query){
			$cust_account_no = $user_id + 100;
			$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
			$this->db->query("UPDATE customer SET customer_no = '". $final_account_no ."' WHERE id = '". $user_id ."' LIMIT 1");
		}
		return $query;
		/* @TODO Mail and SmS */
	}
	
	function manage(){
		$query = $this->db->query("UPDATE customer SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', modified = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}

	function add_business_customer(){
		$this->load->helper('string');
		$con['upload_path']   = './uploads/user_docs/'; 
		$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '30';
		$con['encrypt_name'] = TRUE;
        
		$query = $this->db->query("INSERT INTO customer SET name = '" . $this->db->escape_str($this->input->post('company_name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', company_arabic_name = '" . $this->db->escape_str($this->input->post('company_arabic_name')) . "', business_nature = '" . $this->db->escape_str($this->input->post('business_nature')) . "', company_type = '" . $this->db->escape_str($this->input->post('company_type')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', agreement_start = '" . $this->db->escape_str($this->input->post('agreement_start')) . "', agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', client_telephone = '" . $this->db->escape_str($this->input->post('client_telephone')) . "', client_fax = '" . $this->db->escape_str($this->input->post('client_fax')) . "', account_manager = '" . $this->db->escape_str($this->input->post('account_manager')) . "', email_verify = '1', role_id = '" . (int)$this->input->post('role_id') . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', created = NOW(), modified = NOW()");
		$user_id = $this->db->insert_id();
		
		if($user_id){
			$cust_account_no = $user_id + 100;
			$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
			if(!empty($this->input->post('authsign'))){
				$sign_id = implode(',',$this->input->post('authsign'));
			}else{
				$sign_id = '';
			}
			$this->db->query("UPDATE customer SET customer_no = '". $final_account_no ."' WHERE id = '". $user_id ."' LIMIT 1");
			$query1 = $this->db->query("INSERT INTO customer_info SET user_id = '" . $this->db->escape_str((int)$user_id) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', region_id = '" . $this->db->escape_str($this->input->post('region_id')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', authorize_ids = '" . $this->db->escape_str($sign_id) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_id_no = '" . $this->db->escape_str($this->input->post('sales_id_no')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_id_no = '" . $this->db->escape_str($this->input->post('finance_id_no')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', legal_id_no = '" . $this->db->escape_str($this->input->post('legal_id_no')) . "', legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', other_id_no = '" . $this->db->escape_str($this->input->post('other_id_no')) . "', other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', director_name1 = '" . $this->db->escape_str($this->input->post('director_name1')) . "', director_id_no1 = '" . $this->db->escape_str($this->input->post('director_id_no1')) . "', director_mobile1 = '" . $this->db->escape_str($this->input->post('director_mobile1')) . "', director_email1 = '" . $this->db->escape_str($this->input->post('director_email1')) . "', director_name2 = '" . $this->db->escape_str($this->input->post('director_name2')) . "', director_id_no2 = '" . $this->db->escape_str($this->input->post('director_id_no2')) . "', director_mobile2 = '" . $this->db->escape_str($this->input->post('director_mobile2')) . "', director_email2 = '" . $this->db->escape_str($this->input->post('director_email2')) . "', created_at = NOW(), updated_at = now()");
		}

		if($user_id && $this->input->post('bank_account_no') !== ''){
			$query2 = $this->db->query("INSERT INTO user_bank_account SET user_id = '" . $this->db->escape_str((int)$user_id) . "', bank_account_no = '" . $this->db->escape_str($this->input->post('bank_account_no')) . "', account_holder_name = '" . $this->db->escape_str($this->input->post('account_holder_name')) . "', iban_number = '" . $this->db->escape_str($this->input->post('iban_number')) . "', bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', region = '" . $this->db->escape_str($this->input->post('region')) . "', account_currency = '" . $this->db->escape_str($this->input->post('account_currency')) . "', swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', bank_city = '" . $this->db->escape_str($this->input->post('bank_city')) . "', created_at = NOW(), updated_at = now()");
		}
		
		if($user_id){
			if($_FILES['cr_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('cr_certificate');
				$image_data1 = $this->upload->data();
				$cr_certificate = "uploads/user_docs/".$image_data1['file_name'];
			}
			else{
				$cr_certificate = "";
			}
			
			if($_FILES['vat_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('vat_certificate');
				$image_data2 = $this->upload->data();
				$vat_certificate = "uploads/user_docs/".$image_data2['file_name'];
			}
			else{
				$vat_certificate = "";
			}
			
			if($_FILES['iban_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('iban_certificate');
				$image_data3 = $this->upload->data();
				$iban_certificate = "uploads/user_docs/".$image_data3['file_name'];
			}
			else{
				$iban_certificate = "";
			}
			
			if($_FILES['owner_id']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('owner_id');
				$image_data4 = $this->upload->data();
				$owner_id = "uploads/user_docs/".$image_data4['file_name'];
			}
			else{
				$owner_id = "";
			}
			
			if($_FILES['credit_agreement']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('credit_agreement');
				$image_data5 = $this->upload->data();
				$credit_agreement = "uploads/user_docs/".$image_data5['file_name'];
			}
			else{
				$credit_agreement = "";
			}
			
			if($_FILES['authorization_copy']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorization_copy');
				$image_data6 = $this->upload->data();
				$authorization_copy = "uploads/user_docs/".$image_data6['file_name'];
			}
			else{
				$authorization_copy = "";
			}

			if($_FILES['authorize_person_id']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorize_person_id');
				$image_data6 = $this->upload->data();
				$authorize_person_id = "uploads/user_docs/".$image_data6['file_name'];
			}
			else{
				$authorize_person_id = "";
			}
			$query3 = $this->db->query("INSERT INTO user_docs SET cr_certificate = '" . $this->db->escape_str($cr_certificate) . "', vat_certificate = '" . $this->db->escape_str($vat_certificate) . "', iban_certificate = '" . $this->db->escape_str($iban_certificate) . "', owner_id = '" . $this->db->escape_str($owner_id) . "', credit_agreement = '" . $this->db->escape_str($credit_agreement) . "', authorization_copy = '" . $this->db->escape_str($authorization_copy) . "', authorize_person_id = '" . $this->db->escape_str($authorize_person_id) . "', user_id =  '" . (int)$user_id . "', created_at =  NOW(), updated_at = NOW()");
		}
		return $query;
		/* @TODO Mail and SmS */
	}
	
	function manage_business_customer(){
		$con['upload_path']   = './uploads/user_docs/'; 
		$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '90';
		$con['encrypt_name'] = TRUE;
        
		$query = $this->db->query("UPDATE customer SET name = '" . $this->db->escape_str($this->input->post('company_name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', company_arabic_name = '" . $this->db->escape_str($this->input->post('company_arabic_name')) . "', business_nature = '" . $this->db->escape_str($this->input->post('business_nature')) . "', company_type = '" . $this->db->escape_str($this->input->post('company_type')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', vat_expiry = '" . $this->db->escape_str($this->input->post('vat_expiry')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', cr_expiry = '" . $this->db->escape_str($this->input->post('cr_expiry')) . "', agreement_start = '" . $this->db->escape_str($this->input->post('agreement_start')) . "', agrement_expiry = '" . $this->db->escape_str($this->input->post('agrement_expiry')) . "', client_telephone = '" . $this->db->escape_str($this->input->post('client_telephone')) . "', client_fax = '" . $this->db->escape_str($this->input->post('client_fax')) . "', account_manager = '" . $this->db->escape_str($this->input->post('account_manager')) . "', role_id = '" . (int)$this->input->post('role_id') . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', modified = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		$cr_no = $this->db->escape_str($this->input->post('cr_no'));
		$this->db->query("UPDATE corporate_logins SET corporate_id = '" . $cr_no . "', updated_at = NOW() WHERE main_id ='". (int)$this->input->post('id') ."'");
		if($this->input->post('id') !== ''){
			if(!empty($this->input->post('authsign'))){
				$sign_id = implode(',',$this->input->post('authsign'));
			}else{
				$sign_id = '';
			}
			$this->db->query("DELETE FROM customer_info WHERE user_id = '" . (int)$this->input->post('id') . "'");
			$query1 = $this->db->query("INSERT INTO customer_info SET user_id = '" . $this->db->escape_str((int)$this->input->post('id')) . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district = '" . $this->db->escape_str($this->input->post('district')) . "', region_id = '" . $this->db->escape_str($this->input->post('region_id')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postal_code = '" . $this->db->escape_str($this->input->post('postal_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', short_address = '" . $this->db->escape_str($this->input->post('short_address')) . "', website = '" . $this->db->escape_str($this->input->post('website')) . "', authorize_ids = '" . $this->db->escape_str($sign_id) . "', sales_name = '" . $this->db->escape_str($this->input->post('sales_name')) . "', sales_id_no = '" . $this->db->escape_str($this->input->post('sales_id_no')) . "', sales_mobile = '" . $this->db->escape_str($this->input->post('sales_mobile')) . "', sales_email = '" . $this->db->escape_str($this->input->post('sales_email')) . "', finance_name = '" . $this->db->escape_str($this->input->post('finance_name')) . "', finance_id_no = '" . $this->db->escape_str($this->input->post('finance_id_no')) . "', finance_mobile = '" . $this->db->escape_str($this->input->post('finance_mobile')) . "', finance_email = '" . $this->db->escape_str($this->input->post('finance_email')) . "', legal_name = '" . $this->db->escape_str($this->input->post('legal_name')) . "', legal_id_no = '" . $this->db->escape_str($this->input->post('legal_id_no')) . "', legal_mobile = '" . $this->db->escape_str($this->input->post('legal_mobile')) . "', legal_email = '" . $this->db->escape_str($this->input->post('legal_email')) . "', other_name = '" . $this->db->escape_str($this->input->post('other_name')) . "', other_id_no = '" . $this->db->escape_str($this->input->post('other_id_no')) . "', other_mobile = '" . $this->db->escape_str($this->input->post('other_mobile')) . "', other_email = '" . $this->db->escape_str($this->input->post('other_email')) . "', director_name1 = '" . $this->db->escape_str($this->input->post('director_name1')) . "', director_id_no1 = '" . $this->db->escape_str($this->input->post('director_id_no1')) . "', director_mobile1 = '" . $this->db->escape_str($this->input->post('director_mobile1')) . "', director_email1 = '" . $this->db->escape_str($this->input->post('director_email1')) . "', director_name2 = '" . $this->db->escape_str($this->input->post('director_name2')) . "', director_id_no2 = '" . $this->db->escape_str($this->input->post('director_id_no2')) . "', director_mobile2 = '" . $this->db->escape_str($this->input->post('director_mobile2')) . "', director_email2 = '" . $this->db->escape_str($this->input->post('director_email2')) . "', created_at = NOW(), updated_at = now()");
		}

		if($this->input->post('id') !== '' && $this->input->post('bank_account_no') !== ''){
			$this->db->query("DELETE FROM user_bank_account WHERE user_id = '" . (int)$this->input->post('id') . "'");
			$query2 = $this->db->query("INSERT INTO user_bank_account SET user_id = '" . $this->db->escape_str((int)$this->input->post('id')) . "', bank_account_no = '" . $this->db->escape_str($this->input->post('bank_account_no')) . "', account_holder_name = '" . $this->db->escape_str($this->input->post('account_holder_name')) . "', iban_number = '" . $this->db->escape_str($this->input->post('iban_number')) . "', bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', region = '" . $this->db->escape_str($this->input->post('region')) . "', account_currency = '" . $this->db->escape_str($this->input->post('account_currency')) . "', swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', bank_city = '" . $this->db->escape_str($this->input->post('bank_city')) . "', created_at = NOW(), updated_at = now()");
		}
		
		if($this->input->post('id') !== ''){
			$this->db->query("DELETE FROM user_docs WHERE user_id = '" . (int)$this->input->post('id') . "'");
			if($_FILES['cr_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('cr_certificate');
				$image_data1 = $this->upload->data();
				$cr_certificate = "uploads/user_docs/".$image_data1['file_name'];
			}
			else{
				$cr_certificate = $this->input->post('old_cr_certificate');
			}
			
			if($_FILES['vat_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('vat_certificate');
				$image_data2 = $this->upload->data();
				$vat_certificate = "uploads/user_docs/".$image_data2['file_name'];
			}
			else{
				$vat_certificate = $this->input->post('old_vat_certificate');
			}
			
			if($_FILES['iban_certificate']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('iban_certificate');
				$image_data3 = $this->upload->data();
				$iban_certificate = "uploads/user_docs/".$image_data3['file_name'];
			}
			else{
				$iban_certificate = $this->input->post('old_iban_certificate');
			}
			
			if($_FILES['owner_id']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('owner_id');
				$image_data4 = $this->upload->data();
				$owner_id = "uploads/user_docs/".$image_data4['file_name'];
			}
			else{
				$owner_id = $this->input->post('old_owner_id');
			}
			
			if($_FILES['credit_agreement']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('credit_agreement');
				$image_data5 = $this->upload->data();
				$credit_agreement = "uploads/user_docs/".$image_data5['file_name'];
			}
			else{
				$credit_agreement = $this->input->post('old_credit_agreement');
			}
			
			if($_FILES['authorization_copy']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorization_copy');
				$image_data6 = $this->upload->data();
				$authorization_copy = "uploads/user_docs/".$image_data6['file_name'];
			}
			else{
				$authorization_copy = $this->input->post('old_authorization_copy');
			}

			if($_FILES['authorize_person_id']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('authorize_person_id');
				$image_data6 = $this->upload->data();
				$authorize_person_id = "uploads/user_docs/".$image_data6['file_name'];
			}
			else{
				$authorize_person_id = $this->input->post('old_authorize_person_id');
			}
			$query3 = $this->db->query("INSERT INTO user_docs SET cr_certificate = '" . $this->db->escape_str($cr_certificate) . "', vat_certificate = '" . $this->db->escape_str($vat_certificate) . "', iban_certificate = '" . $this->db->escape_str($iban_certificate) . "', owner_id = '" . $this->db->escape_str($owner_id) . "', credit_agreement = '" . $this->db->escape_str($credit_agreement) . "', authorization_copy = '" . $this->db->escape_str($authorization_copy) . "', authorize_person_id = '" . $this->db->escape_str($authorize_person_id) . "', user_id =  '" . (int)$this->input->post('id') . "', created_at =  NOW(), updated_at = NOW()");
			
		}
		return $query;
	}
	
	function get_customer($id){
		$query = $this->db->query("SELECT c.*, r.referral_code FROM customer c LEFT JOIN referrals r ON (c.id = r.user_id) WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	public function get_cities($id) {
		$query = $this->db->query("SELECT * FROM master_city where region_id=" . $id);
		return $query->result();
	}

	public function get_referal_count($referral_code){
		//$ref_code = $this->db->query("SELECT * FROM referrals WHERE user_id = '" . (int)$id . "'")->row();
		//$referral_code = $ref_code->referral_code;
		$query = $this->db->query("SELECT count(referral_id) as total_referred FROM referrals WHERE refered_code = '" . $referral_code . "'")->result_array();
		//print_r($query);exit();
		return $query;
	}
	
	public function get_referal_report($referral_code){
		$query = $this->db->query("SELECT r.*, c.name, c.email FROM referrals r LEFT JOIN customer c ON (r.user_id = c.id) WHERE refered_code = '" . $referral_code . "'")->result();
		return $query;
	}
	
	function updateRewards(){
		$init_rewards = $this->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$this->input->post('uid') . "'")->row();
		$rewards = $this->input->post('rewards');
		$remarks = $this->input->post('remarks');
		$newRewards = $init_rewards->rewards + $rewards;
		$query = $this->db->query("UPDATE customer SET rewards = '" . $newRewards . "', modified = NOW() WHERE id = '" . (int)$this->input->post('uid') . "'");
		
		$this->db->query("INSERT INTO rewards_report SET user_id =  '" . (int)$this->input->post('uid') . "', amount =  '" . $rewards . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = NOW()");
		return $query;
	}
	
	function updateWallet(){
		$wallet = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->input->post('uid') . "'")->row();
		$amount = $this->input->post('wallet');
		$remarks = $this->input->post('remarks');
		$newWallet = $wallet->wallet + $amount;
		$query = $this->db->query("UPDATE customer SET wallet = '" . $newWallet . "', modified = NOW() WHERE id = '" . (int)$this->input->post('uid') . "'");
		
		$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$this->input->post('uid') . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = NOW()");
		
		return $query;
	}
	
	function get_address($id){
		$query = $this->db->query("SELECT * FROM address WHERE customer_id = '" . (int)$id . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM customer WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function delete_corporate($id){
		$query = $this->db->query("DELETE FROM customer WHERE id IN (" . $id . ")");
		if($query){
			$this->db->query("DELETE FROM customer_info WHERE user_id IN (" . $id . ")");
			$this->db->query("DELETE FROM credit_account WHERE user_id IN (" . $id . ")");
			$this->db->query("DELETE FROM user_bank_account WHERE user_id IN (" . $id . ")");
			$this->db->query("DELETE FROM user_docs WHERE user_id IN (" . $id . ")");
			$this->db->query("DELETE FROM corporate_logins WHERE main_id IN (" . $id . ")");
		}
		return $query;
	}
	
	function make_query(){
		$a = "SELECT c.*, (select count(o.id) from orders o where o.customer_id = c.id AND o.order_status_id = 6) as total_orders, (select sum(o.order_total) from orders o where o.customer_id = c.id AND o.order_status_id = 6) as total_order_value FROM customer c WHERE c.role_id = '1'";
	   return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND c.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY c.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY c.created DESC";		   
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
	   $this->db->from('customer');  
	   $this->db->where('role_id', '=', '1'); 
	   return $this->db->count_all_results();
    }

	/*---- Business Customer ------*/
	function make_query_business($keyword,$status,$company_type,$account_manager,$business_nature,$from,$to){
		$a = "SELECT c.*, (select count(o.id) from orders o where o.customer_id = c.id AND o.order_status_id = 6) as total_orders, (select sum(o.order_total) from orders o where o.customer_id = c.id AND o.order_status_id = 6) as total_order_value FROM customer c WHERE c.role_id = '2'";
		if($keyword){
			$a .= " AND (c.name LIKE '%".$keyword."%' OR c.email LIKE '%".$keyword."%')";
		}
		if($status){
			if($status == 'active'){
				$a .= " AND c.status = '1'";
			}elseif($status == 'inactive'){
				$a .= " AND c.status = '0'";
			}elseif($status == 'blocked'){
				$a .= " AND c.status = '2'";
			}
		}
		if($company_type){
			$a .= " AND c.company_type = '" . $company_type . "'";
		}
		if($account_manager){
			$a .= " AND c.account_manager = '" . $account_manager . "'";
		}
		if($business_nature){
			$a .= " AND c.business_nature = '" . $business_nature . "'";
		}
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (created BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
	   return $a;
	}
	
	function get_business_list($keyword,$status,$company_type,$account_manager,$business_nature,$from,$to){
		$a = $this->make_query_business($keyword,$status,$company_type,$account_manager,$business_nature,$from,$to);
		if(isset($_POST["search"]["value"])){
			$a .= " AND c.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY c.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY c.created DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_business_data($keyword,$status,$company_type,$account_manager,$business_nature,$from,$to){
	   $a = $this->make_query_business($keyword,$status,$company_type,$account_manager,$business_nature,$from,$to);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_business_data(){
	   $this->db->select("*");  
	   $this->db->from('customer');  
	   $this->db->where('role_id', '=', '2');  
	   return $this->db->count_all_results();
    }
	
	public function get_docs($id){
		$query = $this->db->query("SELECT * FROM user_docs WHERE user_id = '" . (int)$id . "'")->row();
		return $query;
	}

	function get_credit_user($id){
		$query = $this->db->query("SELECT c.* FROM customer c WHERE c.id = '" . (int)$id . "'");
		return $query;
	}

	public function get_info($id){
		$query = $this->db->query("SELECT ci.*, mc.city_name FROM customer_info ci LEFT JOIN master_city mc ON (ci.city = mc.id) WHERE ci.user_id = '" . (int)$id . "'")->row();
		return $query;
	}

	public function get_bank_info($id){
		$query = $this->db->query("SELECT * FROM user_bank_account WHERE user_id = '" . (int)$id . "'")->row();
		return $query;
	}

	function edit_customer(){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE customer SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', vat_no = '" . $this->db->escape_str($this->input->post('vat_no')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', role_id = '" . (int)$this->input->post('role_id') . "', status = '" . (int)$this->input->post('status') . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', building_no = '" . $this->db->escape_str($this->input->post('building_no')) . "', street_name = '" . $this->db->escape_str($this->input->post('street_name')) . "', district_name = '" . $this->db->escape_str($this->input->post('district_name')) . "', city_name = '" . $this->db->escape_str($this->input->post('city_name')) . "', zip_code = '" . $this->db->escape_str($this->input->post('zip_code')) . "', additional_no = '" . $this->db->escape_str($this->input->post('additional_no')) . "', unit_no = '" . $this->db->escape_str($this->input->post('unit_no')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', modified = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_orders_by_id($id){
		$sql = "SELECT o.*, db.dname as db_name FROM `orders` o LEFT JOIN van db ON(o.delivery_boy = db.id) WHERE o.customer_id = '" . (int)$id . "'";
		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status == '6'){
                $sql .= " AND o.order_status_id = '" . (int)$status . "'";
            }
			if($status == '1'){
                $sql .= " AND o.order_status_id IN (1,2,4,5)";
            }
			if($status == '9'){
                $sql .= " AND o.order_status_id IN (3,7,8,9)";
            }
        }
		$sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_credit_by_id($id){
		$query = $this->db->query("SELECT * FROM credit_account WHERE user_id = '" . (int)$id . "'");
		return $query->row();
	}
	
	/*---- Wallet Report -----*/
	function get_wallet_report($uid){
		$sql = "SELECT * FROM `wallet_report` WHERE `user_id` = '" . (int)$uid . "'";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `created_at` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `created_at` <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_all_report($uid){
	   $this->db->select("*");  
	   $this->db->from('wallet_report');  
	   $this->db->where('user_id', $uid);  
	   return $this->db->count_all_results();  
	}
	
	function getCreditWallet($id){
		$this->db->select('(SELECT SUM(dbr.amount) FROM wallet_report dbr WHERE dbr.user_id='. $id .' AND dbr.trans_type= "credit") AS amount_reveived', FALSE);
		$query = $this->db->get();
		return $query->row();
	}
	
	function getDebitWallet($id){
		$this->db->select('(SELECT SUM(dbr.amount) FROM wallet_report dbr WHERE dbr.user_id='. $id .' AND dbr.trans_type= "debit") AS amount_paid', FALSE);
		$query = $this->db->get();
		return $query->row();
	}
	
	/*---- Rewards Report -----*/
	function get_rewards_report($uid){
		$sql = "SELECT * FROM `rewards_report` WHERE `user_id` = '" . (int)$uid . "'";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `created_at` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `created_at` <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_all_rewards_report($uid){
	   $this->db->select("*");  
	   $this->db->from('rewards_report');  
	   $this->db->where('user_id', $uid);  
	   return $this->db->count_all_results();  
	}
	
	
	function getCreditRewards($id){
		$this->db->select('(SELECT SUM(dbr.amount) FROM rewards_report dbr WHERE dbr.user_id='. $id .' AND dbr.trans_type= "credit") AS amount_reveived', FALSE);
		$query = $this->db->get();
		return $query->row();
	}
	
	function getDebitRewards($id){
		$this->db->select('(SELECT SUM(dbr.amount) FROM rewards_report dbr WHERE dbr.user_id='. $id .' AND dbr.trans_type= "debit") AS amount_paid', FALSE);
		$query = $this->db->get();
		return $query->row();
	}

	function cities(){
		$query = $this->db->query("SELECT * FROM master_city WHERE status = 1 ORDER BY city_name ASC");
		return $query->result();
	}

	function master_banks(){
		$query = $this->db->query("SELECT * FROM master_bank WHERE deleted = '0' ORDER BY bank_name ASC");
		return $query->result();
	}

	function add_corporate_address(){
		$this->load->helper('string');
		$query = $this->db->query("INSERT INTO corporate_address SET customer_id = '" . $this->db->escape_str((int)$this->input->post('customer_id')) . "', address_label = '" . $this->db->escape_str($this->input->post('address_type')) . "', person_name = '" . $this->db->escape_str($this->input->post('person_name')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', state = '" . $this->db->escape_str($this->input->post('state')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', street = '" . $this->db->escape_str($this->input->post('street')) . "', sector = '" . $this->db->escape_str($this->input->post('sector')) . "', locality = '" . $this->db->escape_str($this->input->post('locality')) . "', shipping_lat = '" . $this->db->escape_str($this->input->post('lat')) . "', shipping_lng = '" . $this->db->escape_str($this->input->post('lng')) . "', shipping_place_id = '" . $this->db->escape_str($this->input->post('place_id')) . "', complete_address = '" . $this->db->escape_str($this->input->post('complete_address')) . "', address_type = '" . $this->db->escape_str($this->input->post('house_type')) . "', building_villa_no = '" . $this->db->escape_str($this->input->post('villa_building')) . "', postal = '" . $this->db->escape_str($this->input->post('postal')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', phone = '" . $this->db->escape_str($this->input->post('phone')) . "', extension = '" . $this->db->escape_str($this->input->post('extension')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', reference = '" . $this->db->escape_str($this->input->post('reference')) . "', created_at = NOW(), updated_at = NOW()");
		return $query;
		/* @TODO Mail and SmS */
	}

	function get_corporate_address($id){
		$query = $this->db->query("SELECT * FROM corporate_address WHERE customer_id = '" . (int)$id . "'");
		return $query->result();
	}

	function get_corporate_address_single($id){
		$query = $this->db->query("SELECT * FROM corporate_address WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function edit_corporate_address($address_id){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE corporate_address SET customer_id = '" . $this->db->escape_str((int)$this->input->post('customer_id')) . "', address_label = '" . $this->db->escape_str($this->input->post('address_label')) . "', person_name = '" . $this->db->escape_str($this->input->post('person_name')) . "', company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', region_id = '" . $this->db->escape_str($this->input->post('region_id')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', street = '" . $this->db->escape_str($this->input->post('street')) . "', floor = '" . $this->db->escape_str($this->input->post('floor')) . "', postal = '" . $this->db->escape_str($this->input->post('postal')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', phone = '" . $this->db->escape_str($this->input->post('phone')) . "', extension = '" . $this->db->escape_str($this->input->post('extension')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', reference = '" . $this->db->escape_str($this->input->post('reference')) . "', map_location = '" . $this->db->escape_str($this->input->post('map_location')) . "', updated_at = NOW() WHERE id = '" . (int)$address_id . "' LIMIT 1");
		return $query;
		/* @TODO Mail and SmS */
	}

	function delete_address($id){
		$query = $this->db->query("DELETE FROM corporate_address WHERE id = '" . $id . "' LIMIT 1");
		return $query;
	}

	/*---- Corporate Logins -----*/

	function add_corporate_logins($hashpassword){
		$this->load->helper('string');
		$parent_id = $this->input->post('main_id');
		$main_user_detail = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$parent_id . "'")->row();
		if($main_user_detail){
			$query = $this->db->query("INSERT INTO corporate_logins SET main_id = '" . $this->db->escape_str((int)$main_user_detail->id) . "', corporate_id = '" . $this->db->escape_str($main_user_detail->cr_no) . "', parent_username = '" . $this->db->escape_str($main_user_detail->email) . "', display_name = '" . $this->db->escape_str($this->input->post('display_name')) . "', login_email = '" . $this->db->escape_str($this->input->post('login_email')) . "', login_phone = '" . $this->db->escape_str($this->input->post('login_phone')) . "', username = '" . $this->db->escape_str($this->input->post('username')) . "', login_role = '" . $this->db->escape_str($this->input->post('login_role')) . "', status = '" . $this->db->escape_str($this->input->post('login_status')) . "', salt = '" . $this->db->escape_str($salt = random_string('alnum', 20)) . "', password = '" . $hashpassword . "', added_by = '" . $this->db->escape_str((int)$this->admin->getId()) . "', created_at = NOW(), updated_at = NOW()");
		}
		return $query;
		/* @TODO Mail and SmS */
	}

	public function getLoginDetail($login_id) {
        $sql = "SELECT cl.id, cl.password FROM corporate_logins cl WHERE cl.id = '" . (int)$login_id . "' AND cl.is_deleted = '0'";
        $query = $this->db->query($sql);
        return $query->row();
    }

	function get_corporate_logins($main_id){
		$query = $this->db->query("SELECT cl.*, a.name as added_by_name FROM corporate_logins cl LEFT JOIN admin a ON (cl.added_by = a.admin_id) WHERE cl.main_id = '" . (int)$main_id . "' AND is_deleted = '0'");
		return $query->result();
	}

	function get_corporate_login_single($id){
		$query = $this->db->query("SELECT * FROM corporate_logins WHERE id = '" . (int)$id . "' AND is_deleted = '0'");
		return $query->row();
	}

	function update_corporate_login(){
		$this->load->helper('string');
		$parent_id = $this->input->post('main_id');
		$id = $this->input->post('login_id');
		$main_user_detail = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$parent_id . "'")->row();
		if($main_user_detail){
			$query = $this->db->query("UPDATE corporate_logins SET  display_name = '" . $this->db->escape_str($this->input->post('display_name')) . "', corporate_id = '" . $this->db->escape_str($main_user_detail->cr_no) . "', login_role = '" . $this->db->escape_str($this->input->post('login_role')) . "', login_email = '" . $this->db->escape_str($this->input->post('login_email')) . "', login_phone = '" . $this->db->escape_str($this->input->post('login_phone')) . "', added_by = '" . $this->db->escape_str((int)$this->admin->getId()) . "', status = '" . $this->db->escape_str($this->input->post('login_status')) . "', updated_at = NOW() WHERE id ='". $id ."' AND main_id ='". $parent_id ."'");
		}
		return $query;
		/* @TODO Mail and SmS */
	}
	
	function delete_corporate_login($id,$main_id){
		$query = $this->db->query("UPDATE corporate_logins SET is_deleted = '1' WHERE id = '" . $id . "' AND main_id = '" . $main_id . "' LIMIT 1");
		return $query;
	}
}
