<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Account_model');
		$this->load->model("Wallet_model");
		$this->load->library('Enc_lib');
		$this->load->library('Role');
		$this->load->library('form_validation');
		$this->load->helper('cookie');
	}

	public function index(){
		if($this->customer->isLogged()){
			$data['result'] = $this->Account_model->get_customer();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/profile", $data);
		} else{
			redirect("login?auth=3d6ea8e00d490d9e93f8d4a5f8ef2354&arial_path=" . base_url() . "account");
		}
	}

	public function dashboard(){
		if($this->customer->isLogged()){
			$data['result'] = $this->Account_model->get_customer();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/dashboard", $data);
		} else{
			redirect("login?auth=3d6ea8e00d490d9e93f8d4a5f8ef2354&arial_path=" . base_url() . "account");
		}
	}

	public function docsForm(){
		$roleid = $this->customer->getRole();
		if($this->customer->isLogged() && $roleid == 2){
			$data['result'] = $this->Account_model->get_customer();
			$data['docs'] = $this->Account_model->get_docs();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/update_docs", $data);
		} else{
			redirect("account");
		}
	}

	public function creditDetail(){
		$roleid = $this->customer->getRole();
		if($this->customer->isLogged() && $roleid == 2){
			$data['reports'] = $this->Account_model->get_credit_report()->result();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/credit_balance", $data);
		} else{
			redirect("account");
		}
	}

	public function login(){
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$this->load->view("front/account/login");
	}

	public function wallet_history(){
		if($this->customer->isLogged()){
			$data['user_info'] = $this->Account_model->get_customer();
			$data['wallet_reports'] = $this->Account_model->get_wallet_report();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/wallet_history", $data);
		} else{
			redirect("account");
		}
	}

	public function rewards_history(){
		if($this->customer->isLogged()){
			$data['user_info'] = $this->Account_model->get_customer();
			$data['reward_reports'] = $this->Account_model->get_rewards_report();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/reward_history", $data);
		} else{
			redirect("account");
		}
	}

	public function referral(){
	    $data['referrals'] = $this->Account_model->Referrals();
	    $data['referral_code'] = $this->Account_model->Ref_code();
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$this->load->view("front/account/referal",$data);
	}

	function insert_ref_code($user_id,$refered_code,$email){
		$Random2Digit = mt_rand(10,99);
		$RefCode = $Random2Digit.'BS'.$user_id;
		$is_ref_used = 0;
		$query = $this->db->query("INSERT INTO referrals SET referral_code = '" . $this->db->escape_str($RefCode) . "', user_id = '" . $this->db->escape_str((int)$user_id) . "', refered_code = '" . $refered_code . "', user_email = '" . $email . "', is_ref_used = '" . $is_ref_used . "', updated_at = NOW()");
		return $query;
	}

	public function verification(){
		if($this->session->userdata("regEmail")){
			$this->load->view("front/account/verificaion");
		}
		else{
			redirect('login');
		}
	}

	public function business_account(){
		$this->load->view("front/account/business_account");
	}

	public function submit_login(){
		$this->form_validation->set_rules('email', 'Corporate ID', 'trim|required');
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('login_msg',validation_errors());
			$this->session->set_flashdata('is_success','0');
			redirect('login?auth='.$this->input->post('auth').'arial_path='.$this->input->post('redirection_path'));
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$login = $this->customer->login($this->input->post('email'), $this->input->post('username'), $hashpassword);
			$nspl_email = $this->input->post('email');
			$nspl_username = $this->input->post('username');
            $nspl_password = $this->input->post('password');
			//print_r($login);exit();
			if($login == '1'){
				if($this->session->userdata("guest")){
					$this->session->unset_userdata("guest");
				}
				redirect($this->input->post('redirection_path'));
			}elseif($login == '2'){
			    $this->session->set_flashdata('login_msg','Account Deactive, Please Contact to admin.');
				$this->session->set_flashdata('is_success','0');
				$redirect = $this->input->post('redirection_path') ? $this->input->post('redirection_path'):'/';
				redirect('login?arial_path='.$this->input->post('redirection_path'));
			}elseif($login == '3'){
				$this->session->set_userdata('regEmail', $this->input->post('username'));
			    $this->session->set_flashdata('login_msg','Please verify account first.');
				$this->session->set_flashdata('is_success','0');
				redirect('verify-email');
			}else{
				$this->session->set_flashdata('login_msg','Username or password did not match.');
				$this->session->set_flashdata('is_success','0');
				//echo $this->input->post('redirection_path');exit();
				$redirect = $this->input->post('redirection_path') ? $this->input->post('redirection_path'):'/';
				redirect('login?arial_path='.$this->input->post('redirection_path'));
			}
		}
	}

	public function submit_docs(){
		if($this->input->post('id')){
			$query = $this->Account_model->update_docs();

			if($query){
				$this->session->set_flashdata('msg','You have successfully updated documents. Thank you');
				$this->session->set_flashdata('is_success','1');
				redirect('kyc');
			}else{
				$this->session->set_flashdata('msg','Some error occures.');
				$this->session->set_flashdata('is_success','0');
				redirect('kyc');
			}
		}else{
		     if (empty($_FILES['commercial_reg']['name']))
                {
                    $this->form_validation->set_rules('commercial_reg', 'Commercial Registration', 'required');
                }
			 if (empty($_FILES['national_id']['name']))
                {
                    $this->form_validation->set_rules('national_id', 'National ID', 'required');
                }

             if (empty($_FILES['agreement_copy']['name']))
                {
                    $this->form_validation->set_rules('agreement_copy', 'Agreement Copy', 'required');
                }
             if (empty($_FILES['auth_copy']['name']))
                {
                    	$this->form_validation->set_rules('auth_copy', 'Authorization Copy', 'required');
                }
             if (empty($_FILES['auth_p_id']['name']))
                {
                    $this->form_validation->set_rules('auth_p_id', 'Authorized Person ID', 'required');
                }
                $this->form_validation->set_rules('none', 'none', 'required');
            if($this->form_validation->run()==FALSE){
		    	$this->session->set_flashdata('msg',validation_errors());
				$this->session->set_flashdata('is_success','0');
				redirect('kyc');
			}
			else{
				$query = $this->Account_model->add_docs();

				if($query){
					$this->session->set_flashdata('msg','You have successfully updated documents. Thank you');
					$this->session->set_flashdata('is_success','1');
					redirect('kyc');
				}else{
					$this->session->set_flashdata('msg','Some error occures.');
					$this->session->set_flashdata('is_success','0');
					redirect('kyc');
				}
			}
		}
	}

	public function edit(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg',validation_errors());
			$this->session->set_flashdata('is_success','0');
			redirect('account');
		}
		else{
			$query = $this->Account_model->edit_customer();
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

	public function change_password(){
		if($this->customer->isLogged()){
		$this->load->view("front/account/change_password");
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
			$this->session->set_flashdata('msg',validation_errors());
			$this->session->set_flashdata('is_success','0');
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('old_password'));
			$hashpassword_new = $this->enc_lib->encrypt($this->input->post('new_password'));
			if($this->customer->checkPassword($hashpassword)){
				$query = $this->Account_model->change_password_by_id($this->customer->getId(),$hashpassword_new);
				if($query){
					$this->session->set_flashdata('msg',"Password has been updated.");
					$this->session->set_flashdata('is_success','1');
					redirect("logout");
				}
				else{
					$this->session->set_flashdata('msg',"Some Error occures!!!");
					$this->session->set_flashdata('is_success','0');
				}
			}
			else{
				$this->session->set_flashdata('msg',"Your old password is not correct.");
				$this->session->set_flashdata('is_success','0');

			}
		}
		redirect("change-password");
	}

	function forgot_password(){
		$this->load->view('front/account/forget_password');
	}

	function check_user(){
		$query = $this->Account_model->get_customer_by_email($_POST['email']);
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
            $eSetting = $this->customer->emailSetting();
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
			<img src="'.base_url().'images/logo-white.jpg" alt="Baqala Station" style="vertical-align:middle;width:220px;"></td>
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

			<p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:18px;padding-bottom:10px">You Recently requested to reset your password for your Baqala Station account.</p>
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
			For any queries or concerns, write to us at <a href="mailto:info@baqalastation.com"
			style="color:#38bef0;text-decoration:none" target="_blank">info@baqalastation.com</a></p></td>
			</tr><tr><td><p style="margin:0;padding:0px;font-family:arial;font-size:13px;color:#121212;line-height:20px">Best Wishes,<br>Baqala Station Team</p>
			</td></tr>
			</tbody></table>
			</td></tr>
			<tr>
			<td><p style="margin:0;padding:0px;font-family:arial;font-size:9px;color:#fff;line-height:20px;">
			This is a system generated mail. Please Do not reply of this mail .</p>
			</td>
			</tr>
			</tbody>
			</table>';
			//echo $message;exit();
			$subject = 'Forget Password | Baqala Station';
			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from('info@baqalastation.com', 'Baqala Station | Forget Password ');  // change it to yours
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
			if($this->customer->getToken($id) == $token){
				$data['id'] = $id;
				$this->load->view('front/account/new_password', $data);
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

	public function logout(){
		$this->customer->logout();
		redirect("/");
	}

	public function get_address(){
		if($this->customer->isLogged()){
			$id = $this->input->post("address_id");
			$query = $this->Account_model->getAddress($id);
			if($query->num_rows()){
				$q = $query->row();
				$data['id'] = $q->id;
				$data['person_name'] = $q->person_name;
				$data['mobile'] = $q->mobile;
				$data['phone'] = $q->phone;
				$data['extension'] = $q->extension;
				$data['email'] = $q->email;
				$data['reference'] = $q->reference;
				$data['building_villa_no'] = $q->building_villa_no;
				$data['street'] = $q->street;
				$data['sector'] = $q->sector;
				$data['locality'] = $q->locality;
				$data['city'] = $q->city;
				$data['state'] = $q->state;
				$data['country'] = $q->country;
				$data['postal'] = $q->postal;
				$data['shipping_lat'] = $q->shipping_lat;
				$data['shipping_lng'] = $q->shipping_lng;
				$data['shipping_place_id'] = $q->shipping_place_id;
				$data['complete_address'] = $q->complete_address;
				$data['address_type'] = $q->address_type;
				$data['address_label'] = $q->address_label;
			}
			else{
				$data['id'] = "";
				$data['person_name'] = "";
				$data['mobile'] = "";
				$data['phone'] = "";
				$data['extension'] = "";
				$data['email'] = "";
				$data['reference'] = "";
				$data['building_villa_no'] = "";
				$data['street'] = "";
				$data['sector'] = "";
				$data['locality'] = "";
				$data['city'] = "";
				$data['state'] = "";
				$data['country'] = "";
				$data['postal'] = "";
				$data['shipping_lat'] = "";
				$data['shipping_lng'] = "";
				$data['shipping_place_id'] = "";
				$data['complete_address'] = "";
				$data['address_type'] = "";
				$data['address_label'] = "";
			}
			echo json_encode($data);
		}else{
			redirect("login");
		}
	}

	public function address(){
		if($this->customer->isLogged()){
		$data['addresses'] = $this->Account_model->getAddresses();
		$this->load->view('front/account/manage_address',$data);
		} else{
			redirect("login");
		}
	}

	public function add_address(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('locality', 'Locality', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('state', 'State', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		//$this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required');
		$this->form_validation->set_rules('place_id', 'Place Id', 'required');
		$this->form_validation->set_rules('complete_address', 'Address', 'required');
		$this->form_validation->set_rules('address_type', 'Address Type', 'required');
		$this->form_validation->set_rules('house_type', 'House Type', 'required');
		$this->form_validation->set_rules('villa_building', 'Enter villa or flat number', 'required');
		if($this->form_validation->run()==FALSE){
			//$this->session->set_flashdata('msg',validation_errors());
			//$this->session->set_flashdata('is_success','0');
			echo "Please check inputs.";
		}
		else{
			if($this->input->post('id')){
				$query = $this->Account_model->edit_address();
			}
			else{
				$query = $this->Account_model->add_address();
			}

			if($query){
				echo "Address Updated Successfully.";

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
		if($this->customer->isLogged()){
			$id = $this->input->post("id");
			$query = $this->Account_model->deleteAddress($id);
			if($query){
				$this->session->unset_userdata('delievery_id');
			}
		} else{
			redirect("login");
		}
	}

	public function order_history(){
		if($this->customer->isLogged()){
			$data['orders'] = $this->Account_model->get_orders();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/order_history", $data);
		} else{
			redirect("login");
		}
	}

	public function getWallet(){
		if($this->customer->isLogged()){
			$data['rewards_price'] = $this->Account_model->get_rewards();
			echo json_encode($data);
		}else{
			redirect("login");
		}
	}

	public function detail(){
		if($this->customer->isLogged()){
			$id = $this->input->get('id');
			$this->load->model("admin/Order_process_model");
			$data['result'] = $this->Order_process_model->get_order($id);
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/account/detail", $data);
		} else{
			redirect("login");
		}
	}

}
