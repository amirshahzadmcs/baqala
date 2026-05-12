<?php
class Telr2 extends CI_Controller {

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
		$orderdata = $this->Order_model->order_gift($wallet_checked);
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
			'ivp_desc'    => 'Gift Card',
			'return_auth' => base_url('Telr2/success'),
			'return_can'  => base_url().'Telr2/cancel',
			'return_decl' => base_url('order-error'),
			'bill_email'  => $orderdata['details']->g_to,
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
		$this->load->view("front/order/thanks_order", $conf);
	}
   
	function cancel(){
		redirect("order-error");
	}
	
}
