<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('store/Account_model');
		$this->load->library('form_validation');
		$this->load->helper('text');
		$this->load->library('Enc_lib');
		$this->load->library('Role');
	}
	
	public function index(){
		if($this->store->isLogged()){
			if ($this->store->getInfo()){
				$info = explode('--', $this->store->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
			$data['result'] = $this->Account_model->get_profile();
			$this->load->view("stores/layout/dashboard",$data);
		} else{
			redirect("store/login");
		}
	}
	
	public function login(){
		$this->load->view("stores/auth/login");
	}
	/*
	public function new_user(){
	    //google login url
		$data['loginURL'] = $this->google->loginURL();
		$this->load->view("retailer/auth/register",$data);
	}
	*/
	public function submit_login(){
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[30]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[50]');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg',validation_errors()); 
			$this->session->set_flashdata('is_success','0');
			redirect('store/login');
		}
		else{		
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$login = $this->store->login($this->input->post('username'), $hashpassword);
			if($login){
				redirect('store/account');
			}
			else{
				$this->session->set_flashdata('msg','Username or password did not match.'); 
				$this->session->set_flashdata('is_success','0');
				redirect('store/login');
			}
		}
	}
	
	public function edit(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg',validation_errors()); 
			$this->session->set_flashdata('is_success','0');
			redirect('account');
		}
		else{
			$query = $this->Account_model->edit_store();
			if($query){
				$this->session->set_flashdata('msg','Profile successfully updated');
				$this->session->set_flashdata('is_success','1');
				redirect('account');
			}
			else{
				$this->session->set_flashdata('msg','Some error occured.'); 
				$this->session->set_flashdata('is_success','0');
				redirect('account');
			}
		}
	}
	
	public function profile(){
		if($this->store->isLogged()){
			if ($this->store->getInfo()){
				$info = explode('--', $this->store->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
			$data['result'] = $this->Account_model->get_profile();
			$data['id'] = $data['result']->id;
			$data['store_name'] = $data['result']->store_name;
			$data['store_type'] = $data['result']->store_type;
			$data['store_name_arabic'] = $data['result']->store_name_arabic;
			$data['store_id'] = $data['result']->store_id;
			$data['store_incharge'] = $data['result']->store_incharge;
			$data['email'] = $data['result']->email;
			$data['contact_number'] = $data['result']->contact_number;
			$data['google_coordinates_lat'] = $data['result']->google_coordinates_lat;
			$data['google_coordinates_long'] = $data['result']->google_coordinates_long;
			$data['store_radius'] = $data['result']->store_radius;
			$data['store_location'] = $data['result']->store_location;
			$data['status'] = $data['result']->status;

			$data['agrement_expiry'] = $data['result']->agrement_expiry;
			$data['cr_no'] = $data['result']->cr_no;
			$data['cr_expiry'] = $data['result']->cr_expiry;
			$data['vat_no'] = $data['result']->vat_no;
			$data['vat_expiry'] = $data['result']->vat_expiry;
			$data['fax'] = $data['result']->fax;
			$data['website'] = $data['result']->website;
			
			$data['sales_name'] = $data['result']->sales_name;
			$data['sales_mobile'] = $data['result']->sales_mobile;
			$data['sales_email'] = $data['result']->sales_email;
			$data['finance_name'] = $data['result']->finance_name;
			$data['finance_mobile'] = $data['result']->finance_mobile;
			$data['finance_email'] = $data['result']->finance_email;
			$data['legal_name'] = $data['result']->legal_name;
			$data['legal_mobile'] = $data['result']->legal_mobile;
			$data['legal_email'] = $data['result']->legal_email;
			$data['other_name'] = $data['result']->other_name;
			$data['other_mobile'] = $data['result']->other_mobile;
			$data['other_email'] = $data['result']->other_email;
			
			$data['building_no'] = $data['result']->building_no;
			$data['street_name'] = $data['result']->street_name;
			$data['district'] = $data['result']->district;
			$data['city'] = $data['result']->city;
			$data['country'] = $data['result']->country;
			$data['postal_code'] = $data['result']->postal_code;
			$data['additional_no'] = $data['result']->additional_no;
			$data['unit_no'] = $data['result']->unit_no;
			$data['short_address'] = $data['result']->short_address;
			$data['payment_terms'] = $data['result']->payment_terms;
			$data['order_currency'] = $data['result']->order_currency;
			$data['credit_limit'] = $data['result']->credit_limit;
			
			if($data['result']->store_type == '2'){
				$store_docs = $this->Account_model->store_documents();
				$store_bank = $this->Account_model->store_bank_account();
				
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
				}else{
					$data['cr_certificate'] = "";
					$data['vat_certificate'] = "";
					$data['national_address'] = "";
					$data['iban_letter'] = "";
					$data['credit_agreements'] = "";
					$data['authorization'] = "";
				}
			}
			$this->load->view("stores/layout/profile",$data);
		} else{
			redirect("login");
		}
	}

	public function change_password(){
		if($this->store->isLogged()){
			if ($this->store->getInfo()){
				$info = explode('--', $this->store->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			}
			else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
			$data['result'] = $this->Account_model->get_profile();
			$this->load->view("stores/auth/change_password",$data);
		} else{
			redirect("login");
		}
	}
	
	public function submit_change_password(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$old_password = $this->input->post('old_password');
			$new_password = $this->input->post('new_password');
    		$old_hashpassword = $this->enc_lib->encrypt($old_password);
    		$new_hashpassword = $this->enc_lib->encrypt($new_password);
			if($this->store->checkPassword($this->store->getId(),$old_hashpassword)){
				$query = $this->Account_model->change_password_by_id($this->store->getId(),$new_hashpassword);
				if($query){
					$this->session->set_userdata('info', "1--Password has been updated.");
				}
				else{
					$this->session->set_userdata('info', "2--Some Error occured!!!");
				}
			}
			else{
				$this->session->set_userdata('info', "2--Your old password is not correct.");
			}
		}
		redirect("store/change-password");
	}
	
	public function password_forget(){
		$this->load->view('retailer/auth/forget_password');
	}
	
	function check_user(){
		$query = $this->Account_model->get_store_by_email($_POST['email']);
		//echo '<pre>';print_r($query->row());exit();
		if($query->num_rows()<1){
			echo "Sorry!!! This email is not registered with us Please register.";
		}
		else
		{
			$for = $query->row();
			//echo '<pre>';print_r($for);exit();
			$token =  $for->salt;
			$id = $for->id;
			$name = $for->name;
			$email = $for->email;

			$eSetting = $this->store->emailSetting();
			$config = Array(
				'protocol' => $eSetting->protocol,		
				'smtp_host' => $eSetting->smtp_host,		
				'smtp_port' => $eSetting->smtp_port,			
				'smtp_user' => $eSetting->smtp_user,		
				'smtp_pass' => $eSetting->smtp_pass,	
				'mailtype' => 'html'
			);
			$message = '<table cellpadding="0" cellspacing="15" border="0" bgcolor="#2d3e50" width="100%" style="margin:0 auto;max-width:440px;font-family:arial">
			<tbody>
			<tr bgcolor="#ffffff">
			<td>
			<table cellpadding="15" cellspacing="0" border="0" width="100%">
			<tbody>
			<tr>
			<td valign="middle" style="text-align: center;">
			<img src="'.base_url().'images/logo.png" alt="logo" style="vertical-align:middle;"></td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>

			<tr bgcolor="#ffffff">
			<td>
			<table cellpadding="0" cellspacing="0" border="0">
			<tbody>

			<tr>
			<td>
			<table cellpadding="15" cellspacing="0" border="0" width="100%">
			<tbody>
			<tr>
			<td>
			<p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:18px;padding-bottom:10px">Hello '.$name.', </p>

			<p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:18px;padding-bottom:10px">You Recently requested to reset your password for your store account.</p>
			<table width="300px">
			<br/><br/><a href="'.base_url().'account/mail_password/?st='.$token.'-'.$id.'">Click here to change your password</a><br/><br/>
			if you are not accepting this email please contact us.
			</td></tr>

			</table>
			</td>
			</tr>
			</tbody></table>
			</td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>


			<tr bgcolor="#ffffff"><td>
			<table cellpadding="0" cellspacing="15" border="0" width="100%"><tbody><tr><td>
			<p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:20px;padding-bottom:20px">
			For any queries or concerns, write to us at <a href="mailto:infos@store.com"
			style="color:#38bef0;text-decoration:none" target="_blank">info@store.com</a></p></td>
			</tr><tr><td><p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:20px">Best Wishes,<br>store Team</p>
			</td></tr>
			</tbody></table>
			</td></tr>
			<tr>
			<td><p style="margin:0;padding:0px;font-family:arial;font-size:9px;color:#121212;line-height:20px;">
			This is a system generated mail. Please Do not reply of this mail .</p>
			</td>
			</tr>
			</tbody>
			</table>';
			//echo $message;exit();
			$subject = 'Forget Password | store';
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from('infos@store.com', 'store | Forget Password ');  // change it to yours
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($message);
			if($this->email->send()){
				echo 'A link has been sent to your registered email id . Please Follow the link to update your password.';
			}else{
				echo 'Email is not sent. Please try after some time.';
			}
		}
	}
	
	public function mail_password(){
		//echo '<pre>';print_r($_GET);exit();
		$st = $this->input->get('st');
		$ex = explode('-',$st);
		$token = $ex[0];
		$id = $ex[1];

		if($id AND $token){
			if($this->store->getToken($id) == $token){
				$data['id'] = $id;

			$this->load->view('retailer/account/new_password', $data);
			}
			else{
				redirect(base_url());
			}
		}
	}
	
	function new_password1(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

		if($this->form_validation->run()==FALSE){

			$this->session->set_flashdata('msg',validation_errors());
			$this->session->set_flashdata('is_success','0');

			redirect('account/mail_password/?st='.$this->input->post('st'));
		}
		else{
		$query = $this->Account_model->change_password_by_id($this->input->post('for_id'));
			if($query){
				//flash "Password has been changed<br/>You May Login With NEW PASSWORD.";

			}
			else{

			}
				redirect('/');
		}
	}
	
	public function new_password(){
			
	}
	
	public function submit_new_password(){
		
	}
	
	public function logout(){
		$this->store->logout();
		redirect("/store");
	}
	
	public function get_address(){
		if($this->store->isLogged()){
		$id = $this->input->post("id");
		$query = $this->Account_model->getAddress($id);
		if($query->num_rows()){
			$q = $query->row();
			$data['id'] = $q->id;
			$data['name'] = $q->name;
			$data['mobile'] = $q->mobile;
			$data['address1'] = $q->address_1;
			$data['address2'] = $q->address_2;
			$data['city'] = $q->city;
			$data['state'] = $q->state;
			$data['postal'] = $q->postcode;
			$data['country'] = $q->country_id;
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['address1'] = "";
			$data['address2'] = "";
			$data['city'] = "";
			$data['state'] = "";
			$data['postal'] = "";
			$data['country'] = "";
		}
		echo json_encode($data);
		} else{
			redirect("login");
		}
	}
	
	public function address(){
		if($this->store->isLogged()){
		    $data['addresses'] = $this->Account_model->getAddresses();
		    $data['result'] = $this->Account_model->get_store();
		    $this->load->view('front/account/manage_address',$data);
		} else{
			redirect("login");
		}
	}
	
	public function add_address(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('address1', 'Address1', 'trim|required');
		$this->form_validation->set_rules('address2', 'Address2', 'trim');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('postal', 'Postal Code', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg',validation_errors()); 
			$this->session->set_flashdata('is_success','0');
		}
		else{
			if($this->input->post('id')){
				$query = $this->Account_model->edit_address();
			}
			else{
				$query = $this->Account_model->add_address();
			}
			
			if($query){
				echo "Profile Updated Successfully.";
				
				/* $this->session->set_flashdata('msg','Profile edit successfully.'); 
				$this->session->set_flashdata('is_success','1');
				redirect($this->input->post('arial_path')); */
			}
			else{
				echo "Some error occures.";
				/* $this->session->set_flashdata('msg','Some error occure.'); 
				$this->session->set_flashdata('is_success','0');
				redirect($this->input->post('arial_path')); */
			}
		}
	}
	
	public function delete_address(){
		if($this->store->isLogged()){
		$id = $this->input->post("id");
		$query = $this->Account_model->deleteAddress($id);
		} else{
			redirect("login");
		}
	}
	
	public function order_history(){
		if($this->store->isLogged()){
		$data['orders'] = $this->Account_model->get_orders();
		$this->load->view("front/account/order_history", $data);
		} else{
			redirect("login");
		}
	}

	public function detail(){
		if($this->store->isLogged()){
		$id = $this->input->get('id');
		$this->load->model("admin/Order_process_model");
		$data['result'] = $this->Order_process_model->get_order($id);
		$this->load->view("front/account/detail", $data);
		} else{
			redirect("login");
		}
	}
}
