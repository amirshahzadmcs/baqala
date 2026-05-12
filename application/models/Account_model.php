<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model{
	
	public function get_customer(){
		$query = $this->db->query("SELECT cl.*, c.company_name FROM corporate_logins cl LEFT JOIN customer c ON (cl.main_id = c.id) WHERE cl.id = '" . (int)$this->customer->getId() . "'")->row();
		return $query;
	}
	
	function edit_customer(){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE customer SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', modified = NOW() WHERE id = '" . (int)$this->customer->getId() . "'");
		return $query;
	}
	
	public function get_docs(){
		$query = $this->db->query("SELECT * FROM user_docs WHERE user_id = '" . (int)$this->customer->getId() . "'")->row();
		return $query;
	}
	
	public function add_docs(){
		$con['upload_path']   = './uploads/user_docs/'; 
		$con['allowed_types'] = 'gif|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '30';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['commercial_reg']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('commercial_reg');
			$image_data1 = $this->upload->data();
			$commercial_reg = "uploads/user_docs/".$image_data1['file_name'];
		}
		else{
			$commercial_reg = "";
		}
		
		if($_FILES['national_id']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('national_id');
			$image_data2 = $this->upload->data();
			$national_id = "uploads/user_docs/".$image_data2['file_name'];
		}
		else{
			$national_id = "";
		}
		
		if($_FILES['agreement_copy']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('agreement_copy');
			$image_data4 = $this->upload->data();
			$agreement_copy = "uploads/user_docs/".$image_data4['file_name'];
		}
		else{
			$agreement_copy = "";
		}
		
		if($_FILES['auth_copy']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('auth_copy');
			$image_data5 = $this->upload->data();
			$auth_copy = "uploads/user_docs/".$image_data5['file_name'];
		}
		else{
			$auth_copy = "";
		}
		
		if($_FILES['auth_p_id']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('auth_p_id');
			$image_data6 = $this->upload->data();
			$auth_p_id = "uploads/user_docs/".$image_data6['file_name'];
		}
		else{
			$auth_p_id = "";
		}
		$query = $this->db->query("INSERT INTO user_docs SET commercial_reg = '" . $this->db->escape_str($commercial_reg) . "', national_id = '" . $this->db->escape_str($national_id) . "', agreement_copy = '" . $this->db->escape_str($agreement_copy) . "', auth_copy = '" . $this->db->escape_str($auth_copy) . "', auth_p_id = '" . $this->db->escape_str($auth_p_id) . "', user_id =  '" . (int)$this->customer->getId() . "', created_at =  NOW(), updated_at = NOW()");
		return $query;
	}
	
	public function update_docs(){
		$con['upload_path']   = './uploads/user_docs/'; 
		$con['allowed_types'] = 'gif|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '90';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['commercial_reg']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('commercial_reg');
			$image_data1 = $this->upload->data();
			$commercial_reg = "uploads/user_docs/".$image_data1['file_name'];
		}
		else{
			$commercial_reg = $this->input->post('old_commercial_reg');
		}
		
		if($_FILES['national_id']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('national_id');
			$image_data2 = $this->upload->data();
			$national_id = "uploads/user_docs/".$image_data2['file_name'];
		}
		else{
			$national_id = $this->input->post('old_national_id');
		}
		
		if($_FILES['agreement_copy']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('agreement_copy');
			$image_data4 = $this->upload->data();
			$agreement_copy = "uploads/user_docs/".$image_data4['file_name'];
		}
		else{
			$agreement_copy = $this->input->post('old_agreement_copy');
		}
		
		if($_FILES['auth_copy']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('auth_copy');
			$image_data5 = $this->upload->data();
			$auth_copy = "uploads/user_docs/".$image_data5['file_name'];
		}
		else{
			$auth_copy = $this->input->post('old_auth_copy');
		}
		
		if($_FILES['auth_p_id']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('auth_p_id');
			$image_data6 = $this->upload->data();
			$auth_p_id = "uploads/user_docs/".$image_data6['file_name'];
		}
		else{
			$auth_p_id = $this->input->post('old_auth_p_id');
		}
		$query = $this->db->query("UPDATE user_docs SET commercial_reg = '" . $this->db->escape_str($commercial_reg) . "', national_id = '" . $this->db->escape_str($national_id) . "', agreement_copy = '" . $this->db->escape_str($agreement_copy) . "', auth_copy = '" . $this->db->escape_str($auth_copy) . "', auth_p_id = '" . $this->db->escape_str($auth_p_id) . "', user_id =  '" . (int)$this->customer->getId() . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function change_password_by_id($id,$password){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE corporate_logins SET salt = '" . $this->db->escape_str($salt = random_string('alnum', 20)) . "', password = '" . $password . "', login_ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function mail_password(){
		return true;
		/* @TODO Mail */
	}
	
	function new_password(){
		return true;
	}
	
	public function getAddress($id){
		$sql = $this->db->query("SELECT * FROM corporate_address WHERE id = '" . (int)$id . "'");
		return $sql;
	}
	
	public function deleteAddress($id){
		$sql = $this->db->query("DELETE FROM address WHERE id = '" . (int)$id . "'");
		return $sql;
	}
	
	public function edit_address(){
		$sql = $this->db->query("SELECT id FROM address WHERE id = '" . (int)$this->input->post('id') . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
		if($sql->num_rows()){
			$query = $this->db->query("UPDATE address SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', house_no = '" . $this->db->escape_str($this->input->post('house_no')) . "', street = '" . $this->db->escape_str($this->input->post('street')) . "', sector = '" . $this->db->escape_str($this->input->post('sector')) . "', locality = '" . $this->db->escape_str($this->input->post('locality')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', state = '" . $this->db->escape_str($this->input->post('state')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postcode = '" . $this->db->escape_str($this->input->post('postal_code')) . "', lat = '" . $this->db->escape_str($this->input->post('lat')) . "', lng = '" . $this->db->escape_str($this->input->post('lng')) . "', place_id = '" . $this->db->escape_str($this->input->post('place_id')) . "', complete_address = '" . $this->db->escape_str($this->input->post('complete_address')) . "', instruction = '" . $this->db->escape_str($this->input->post('instruction')) . "', address_type = '" . $this->db->escape_str($this->input->post('address_type')) . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		}
		else{
			$query = false;
		}
		return $query;
	}
	
	public function add_address(){	
		$query = $this->db->query("INSERT INTO address SET name = '" . $this->db->escape_str($this->input->post('name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', house_no = '" . $this->db->escape_str($this->input->post('house_no')) . "', street = '" . $this->db->escape_str($this->input->post('street')) . "', sector = '" . $this->db->escape_str($this->input->post('sector')) . "', locality = '" . $this->db->escape_str($this->input->post('locality')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', state = '" . $this->db->escape_str($this->input->post('state')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "', postcode = '" . $this->db->escape_str($this->input->post('postal_code')) . "', lat = '" . $this->db->escape_str($this->input->post('lat')) . "', lng = '" . $this->db->escape_str($this->input->post('lng')) . "', place_id = '" . $this->db->escape_str($this->input->post('place_id')) . "', complete_address = '" . $this->db->escape_str($this->input->post('complete_address')) . "', instruction = '" . $this->db->escape_str($this->input->post('instruction')) . "', house_type = '" . $this->db->escape_str($this->input->post('house_type')) . "', villa_building = '" . $this->db->escape_str($this->input->post('villa_building')) . "', address_type = '" . $this->db->escape_str($this->input->post('address_type')) . "', customer_id = '" . (int)$this->customer->getId() . "'");
		return $query;
	}
	
	public function get_orders(){
		$query = $this->db->query("SELECT * FROM orders WHERE customer_id = '" . (int)$this->customer->getId() . "' ORDER BY id DESC");
		return $query;
	}
	
	public function get_credit_report(){
		$query = $this->db->query("SELECT * FROM credit_account_report WHERE user_id = '" . (int)$this->customer->getId() . "' ORDER BY id DESC");
		return $query;
	}
	
	public function get_wallet_report(){
		$query = $this->db->query("SELECT * FROM wallet_report WHERE user_id = '" . (int)$this->customer->getId() . "' ORDER BY id DESC");
		return $query->result();
	}
	
	public function get_rewards_report(){
		$query = $this->db->query("SELECT * FROM rewards_report WHERE user_id = '" . (int)$this->customer->getId() . "' ORDER BY id DESC");
		return $query->result();
	}

	public function getAddresses(){
		$sql = $this->db->query("SELECT * FROM address WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		return $sql;
	}
	
	public function get_rewards(){
		$query = $this->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$this->customer->getId() . "'")->row();
		$rewards_amt = $query->rewards;
		if($rewards_amt > 50){
			return 50;
		}else{
			return $rewards_amt;
		}
	}
	
	public function get_customer_by_email($email=''){
		$query = $this->db->query("SELECT * FROM customer WHERE email = '" . $email. "'");
		return $query;
	}
	
	function email_verify($email){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE customer SET email_verify = '1', ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE email = '" . $email . "'");
		return $query;
	}
	
	function resend_otp($otp, $email){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE customer SET otp = '" . $otp . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE email = '" . $email . "'");
		return $query;
	}
	
	public function Referrals(){
		$query = $this->db->query("SELECT * FROM referral_setting WHERE status ='1'")->row();
		return $query;
	}
	
	public function Ref_code(){
		$query = $this->db->query("SELECT * FROM referrals WHERE user_id = '" . (int)$this->customer->getId() . "' AND status ='1'")->row();
		return $query;
	}
	
	function referal_exists($code)
	{
		$this->db->where('referral_code',$code);
		$query = $this->db->get('referrals');
		if ($query->num_rows() > 0){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function voucher_detail($code){
		$date = date('Y-m-d');
		$query = $this->db->query("SELECT * FROM recharge_vouchers WHERE voucher_code = '" . $this->db->escape_str($this->input->post('code')) . "' AND expiry_date > '" . $date . "' AND status ='1' AND is_used = '0'")->row();
		return $query;
	}
	
	public function voucher_exists($code){
		$this->db->where('voucher_code',$code);
		$query = $this->db->get('recharge_vouchers');
		if ($query->num_rows() > 0){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function redeem_voucher($v_id){
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->library('user_agent');
		
		$browser = $this->agent->browser();
		$platform = $this->agent->platform();

		$query = $this->db->query("INSERT INTO recharge_report SET voucher_id = '" . $this->db->escape_str((int)$v_id) . "', user_id = '" . $this->db->escape_str((int)$this->customer->getId()) . "', browser = '" . $this->db->escape_str($browser) . "', platform = '" . $this->db->escape_str($platform) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', created_at = NOW()");
	}
	
	function update_voucher($v_id){
		$query = $this->db->query("UPDATE recharge_vouchers SET status = '1', is_used = '1', updated_at = now() WHERE voucher_id = '" . (int)$v_id . "'");
		return $query;
	}
	
	/*---- Redeem Gift Card -----*/
	
	public function card_detail($code){
		$date = date('Y-m-d');
		$useremail = $this->db->query("SELECT email FROM customer WHERE id = '" . (int)$this->customer->getId() . "'")->row();
		$query = $this->db->query("SELECT * FROM gift_cards WHERE g_code = '" . $this->db->escape_str($this->input->post('code')) . "' AND expiry_date > '" . $date . "' AND g_status ='1' AND is_g_used = '0' AND to_email = '" . $useremail->email . "'")->row();
		return $query;
	}
	
	public function card_exists($code){
		$this->db->where('g_code',$code);
		$query = $this->db->get('gift_cards');
		if ($query->num_rows() > 0){
			return 1;
		}
		else{
			return 0;
		}
	}
	
	public function redeem_card($gift_id){
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->library('user_agent');
		
		$browser = $this->agent->browser();
		$platform = $this->agent->platform();

		$query = $this->db->query("INSERT INTO giftcard_report SET giftcard_id = '" . $this->db->escape_str((int)$gift_id) . "', user_id = '" . $this->db->escape_str((int)$this->customer->getId()) . "', browser = '" . $this->db->escape_str($browser) . "', platform = '" . $this->db->escape_str($platform) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', created_at = NOW()");
	}
	
	function update_card($gift_id){
		$query = $this->db->query("UPDATE gift_cards SET is_g_used = '1', updated_at = now() WHERE g_id = '" . (int)$gift_id . "'");
		return $query;
	}
	
	public function redeemed_card_list(){
		$query = $this->db->query("SELECT gr.*, gc.to_name, gc.to_email, gc.from_name, gc.message, gc.g_value, gc.g_code, gc.expiry_date, gc.is_g_used FROM giftcard_report gr LEFT JOIN gift_cards gc ON (gc.g_id = gr.giftcard_id) WHERE gr.user_id = '" . (int)$this->customer->getId() . "'")->result();
		return $query;
	}
	
	public function redeemed_vouchers_list(){
		$query = $this->db->query("SELECT rr.*, rv.s_no, rv.voucher_name, rv.expiry_date, rv.voucher_value, rv.is_used FROM recharge_report rr LEFT JOIN recharge_vouchers rv ON (rv.voucher_id = rr.voucher_id) WHERE rr.user_id = '" . (int)$this->customer->getId() . "'")->result();
		return $query;
	}
}
