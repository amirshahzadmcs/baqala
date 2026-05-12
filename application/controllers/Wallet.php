<?php
class Wallet extends CI_Controller {

	function  __construct(){
		parent::__construct();
		$this->load->model('Order_model');
		$this->load->model('Wallet_model');
		$this->load->model('admin/Order_process_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 */
	public function buy_product()
	{
		if($this->customer->isLogged()){
			$wallet_checked = $this->db->escape_str($this->input->get('wallet'));
			$rewards_checked = $this->db->escape_str($this->input->get('rewards'));
			$orderdata = $this->Order_model->order_fridge($wallet_checked,$rewards_checked);
			if(!empty($orderdata) && count($orderdata) > 0){
				$this->product_success($orderdata); //passing data into another function
			}else {
				$this->cancel();
			}
		}else{
			redirect('login');
		}
	}
	
	function product_success($orderdata = ''){
		$results = $orderdata;
		$ref= trim(uniqid());
		$cartid= trim($results['orderid']);
		$paymethod= 'Wallet';
		//echo json_encode($results);

		$this->Order_model->pay_confirm($ref, $cartid, $paymethod);
		$conf['result'] = $this->Order_process_model->get_order($cartid);
		$rewards_amt = $conf['result']['order']['cashback_applied'];
		$wallet_amount = $conf['result']['order']['wallet_applied'];
		
		if($wallet_amount > 0){
			$this->Order_model->wallet_debit($wallet_amount, $cartid);
		}
		if($rewards_amt > 0){
			$this->Order_model->rewards_update($rewards_amt, $cartid);
		}
		
		$eSetting = $this->customer->emailSetting();
	
		$config = Array(
			'protocol' => $eSetting->protocol,		
			'smtp_host' => $eSetting->smtp_host,		
			'smtp_port' => $eSetting->smtp_port,			
			'smtp_user' => $eSetting->smtp_user,		
			'smtp_pass' => $eSetting->smtp_pass,	
			'mailtype' => 'html'
		);
		$message = $this->load->view("admin/order/email_received", $conf,true);
		
		$subject = 'Order Received | '.$eSetting->website_name;
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | Order Received'); 
		$this->email->to($conf['result']['order']['email']);
		$this->email->subject($subject);
		$this->email->message($message);
		$send = $this->email->send();
		
		
		$subject = 'Order Received | '.$eSetting->website_name;
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | Order Received'); 
		$this->email->to($this->session->userdata("location_email"));
		$this->email->cc($eSetting->receiver_mail);
		$this->email->subject($subject);
		$this->email->message($message);
		$send = $this->email->send();
		
		$conf['order_id'] = $cartid;
		$this->session->set_flashdata('order_id', $cartid);
		redirect("thanks-for-order");
	}
	
	public function gift_buy()
	{
		if($this->customer->isLogged()){
			$wallet_checked = $this->db->escape_str($this->input->get('wallet'));
			$orderdata = $this->Order_model->order_gift_from_wallet($wallet_checked);
			if(!empty($orderdata) && count($orderdata) > 0){
				$this->gift_success($orderdata); //passing data into another function
			}else {
				$this->cancel();
			}
		}else{
			redirect('login');
		}
	}
	
	function gift_success($orderdata = ''){
		$results = $orderdata;
		$ref= trim(uniqid());
		$cartid= trim($results['orderid']);
		$paymethod= 'Wallet';
		//echo json_encode($results);

		$this->Order_model->pay_confirm_gift($ref, $cartid, $paymethod);
		$conf['result'] = $this->Order_process_model->get_order($cartid);
		$wallet_amount = $conf['result']['order']['wallet_applied'];
		
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$hashed = hash('sha512', uniqid().str_shuffle($chars));
		$gift_code = substr($hashed, 0, 16);
		
		if($wallet_amount > 0){
			$this->Order_model->wallet_debit($wallet_amount, $cartid);
		}
		//print_r($conf['result']);exit();
		$gift_detail = array(
			'gift_to' => $conf['result']['order']['shipping_email'],
			'to_name' => $conf['result']['order']['shipping_firstname'],
			'from_name' => $conf['result']['order']['name'],
			'gift_value' => $conf['result']['product'][0]['gift_value'],
			'gift_code' => $gift_code,
			'gift_message' => $conf['result']['order']['comment'],
			'order_id' => $conf['result']['order']['id'],
			'date_added' => $conf['result']['order']['date_added'],
		);
		
		$this->Order_model->create_gcard($gift_detail);
		//print_r($conf['result']);exit();
		
		$eSetting = $this->customer->emailSetting();
		$config = Array(
			'protocol' => $eSetting->protocol,		
			'smtp_host' => $eSetting->smtp_host,		
			'smtp_port' => $eSetting->smtp_port,			
			'smtp_user' => $eSetting->smtp_user,		
			'smtp_pass' => $eSetting->smtp_pass,	
			'mailtype' => 'html'
		);
		
		if($gift_detail['gift_to'] !== ''){
			$g_message = $this->load->view("admin/order/email_gift", $gift_detail, true);
		
			$subject = 'Gift Card Received | '.$eSetting->website_name;
			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | Order Confirmation'); 
			$this->email->to($gift_detail['gift_to']);
			$this->email->subject($subject);
			$this->email->message($g_message);
			$send = $this->email->send();
		}
		
		$message = $this->load->view("admin/order/email_confirmation", $conf, true);
		
		$subject = 'Order Confirmation | '.$eSetting->website_name;
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | Order Confirmation'); 
		$this->email->to($conf['result']['order']['email']);
		$this->email->subject($subject);
		$this->email->message($message);
		$send = $this->email->send();

		$subject = 'Order Confirmation | '.$eSetting->website_name;
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$this->email->from($eSetting->smtp_user,  $eSetting->website_name.' | Order Confirmation'); 
		$this->email->to($eSetting->receiver_mail);
		$this->email->subject($subject);
		$this->email->message($message);
		$send = $this->email->send();
		
		$conf['order_id'] = $cartid;
		$this->session->set_flashdata('order_id', $cartid);
		redirect("thanks-for-order");
	}
   
	function cancel(){
		redirect("order-error");
	}
	
}
