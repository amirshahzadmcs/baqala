<?php
class Telr extends CI_Controller {

	function  __construct(){
		parent::__construct();
		$this->load->model('Order_model');
		$this->load->model('admin/Order_process_model');
	}

	/**
	 * Index Page for this controller.
	 *
	 */
	public function buy()
	{
		$wallet_checked = $this->db->escape_str($this->input->get('wallet'));
		$rewards_checked = $this->db->escape_str($this->input->get('rewards'));
		$orderdata = $this->Order_model->order_fridge($wallet_checked,$rewards_checked);
// 		print_r($orderdata);exit();
		
		$rid = $orderdata['orderid'];
		$txn_amt = $orderdata['net_payble_amt'];
// 		print_r($txn_amt);exit();
		$params = array(
			'ivp_method'  => 'create',
			'ivp_store'   => 24759,
			'ivp_authkey' => 'Rqfg@wd3xg#m63Hf',
			'ivp_cart'    => $rid,  
			'ivp_test'    => 1,
			'ivp_amount'  => $txn_amt,
			'ivp_currency'=> 'SAR',
			'ivp_desc'    => 'Product Of Bakala Station',
			'return_auth' => base_url('Telr/success'),
			'return_can'  => base_url().'Telr/cancel',
			'return_decl' => base_url('order-error'),
			'bill_country'  => $orderdata['details']->country,
			'bill_city'  => $orderdata['details']->city,
			'bill_region'  => $orderdata['details']->state,
			'bill_zip'  => $orderdata['details']->postcode,
			'bill_email'  => $orderdata['details']->c_email,
// 			'bill_zip'  => $orderdata['details']->postcode,
			'bill_addr1'  => $orderdata['details']->complete_address
// 			'ivp_amount'  => $orderdata['details']['c_email'],
// 			'ivp_amount'  => $orderdata['details']['c_email'],
		);
		
		//print_r($params['return_auth']);exit();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$results = curl_exec($ch);

		curl_close($ch);
		$results = json_decode($results,true);

		$ref= trim($results['order']['ref']);
		$url= trim($results['order']['url']);
		$this->session->set_userdata("ref" , $ref);
		redirect($url);

		if (empty($ref) || empty($url)) {
		# Failed to create order
		}
		// print_r($params);exit();
		// $this->load->view('front/order/telr_confirm', $params);
	}
	
	function success(){
		$ref=$this->session->userdata("ref");
		// print_r($ref);exit();
    	$params = array(
			'ivp_method'  => 'check',
			'ivp_store'   => 24759,
			'ivp_authkey' => 'Rqfg@wd3xg#m63Hf',
			'order_ref'    => $ref
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
		curl_setopt($ch, CURLOPT_POST, count($params));
		curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$results = curl_exec($ch);

		curl_close($ch);
		$results = json_decode($results,true);
		$ref= trim($results['order']['transaction']['ref']);
		$cartid= trim($results['order']['cartid']);
		$paymethod= trim($results['order']['paymethod']);
		// echo json_encode($results);

		$this->Order_model->pay_confirm($ref, $cartid, $paymethod);
		$conf['result'] = $this->Order_process_model->get_order($cartid);
		$wallet_amount = $conf['result']['order']['wallet_applied'];
		$rewards_amount = $conf['result']['order']['cashback_applied'];
		if($wallet_amount > 0){
			$this->Order_model->wallet_debit($wallet_amount, $cartid);
		}
		if($rewards_amount > 0){
			$this->Order_model->rewards_update($rewards_amount,$cartid);
		}
		// print_r($conf['result']);exit();
		$eSetting = $this->customer->emailSetting();
		
		$config = Array(
			'protocol' => $eSetting->protocol,		
			'smtp_host' => $eSetting->smtp_host,		
			'smtp_port' => $eSetting->smtp_port,			
			'smtp_user' => $eSetting->smtp_user,		
			'smtp_pass' => $eSetting->smtp_pass,	
			'mailtype' => 'html'
		);
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
			 
		$this->session->set_flashdata('order_id', $cartid);
		redirect("thanks-for-order");
	}
   
	function cancel(){
		redirect("order-error");
	}
	
}
