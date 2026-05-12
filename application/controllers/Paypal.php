<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Paypal extends CI_Controller 
    {
         function  __construct(){
            parent::__construct();
            $this->load->library('paypal_lib');
            $this->load->model('Order_model');
            $this->load->model('admin/Order_process_model');
         }
         
		 function buy(){
			if(!$this->customer->isLogged() AND !$this->session->userdata("guest")){
			redirect("/");
			exit();
			}
			$data = $this->Order_model->order_fridge();
			
			$returnURL = base_url().'paypal/success'; //payment success url
			$cancelURL = base_url().'paypal/cancel'; //payment cancel url
			$notifyURL = base_url().'paypal/ipn'; //ipn url
			//get particular product data
			//$product = $this->product->getRows($id);
			/* $userID = $data['cust_id']; */
			$logo = base_url().'images/logo.jpg';

			
			$this->paypal_lib->add_field('return', $returnURL);
			$this->paypal_lib->add_field('cancel_return', $cancelURL);
			$this->paypal_lib->add_field('notify_url', $notifyURL);
			$this->paypal_lib->add_field('item_name', 'Saugat Gift');
			$this->paypal_lib->add_field('custom', $data['orderid']);
			//$this->paypal_lib->add_field('custom', 333);
			$this->paypal_lib->add_field('item_number', $data['orderid']);    
			//$this->paypal_lib->add_field('item_number', 333);    
			$this->paypal_lib->add_field('amount', round($data['total']));        
			//$this->paypal_lib->add_field('amount', 1);        
			$this->paypal_lib->image($logo);
			
			$this->paypal_lib->paypal_auto_form();
		 }
		 
         function success(){
			$con = $this->input->post();
			$type = 'PayPal';
			$this->Order_model->pay_confirm($con['txn_id'], $con['custom'], $type);
			$conf['result'] = $this->Order_process_model->get_order($con['custom']);
			
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
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | Order Received'); 
			$this->email->to($conf['result']['order']['email']);
			$this->email->subject($subject);
			$this->email->message($message);
			$send = $this->email->send();
		
		
		$subject = 'Order Received | '.$eSetting->website_name;
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | Order Received'); 
			$this->email->to($this->session->userdata("location_email"));
			$this->email->cc($eSetting->receiver_mail);
			$this->email->subject($subject);
			$this->email->message($message);
			$send = $this->email->send();
				 
				/*SMS*
			$msg = urlencode('Order Placed - Your Order with Order ID - '.$con['custom'].' amounting of Rs. '.$con['mc_gross'].' has been received. You can expect delivery within 7 days. We will send you an update when your Order will shipped.');
			$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=saugatt&password=83b828317cXX&mobiles=' . $conf['result']['order']['mobile'] . '&sms='.$msg.'&senderid=Saugat';
			$response = file_get_contents($sms);
			/*SMS END*/
			/*SMS*
			$msg = urlencode('New Order Recieved - with Order ID - '.$con['custom'].' amounting of Rs. '.$con['mc_gross'].' has been received.');
			$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=saugatt&password=83b828317cXX&mobiles=9829321136&sms='.$msg.'&senderid=Saugat';
			$response = file_get_contents($sms);
			/*SMS END*/
			$data['order_id'] = $con['custom'];
			$this->load->view("front/order/thanks_order", $data);
         }
         
         function cancel(){
            redirect("order-error");
         }
         
         function ipn(){
            //paypal return transaction details array
            $paypalInfo    = $this->input->post();
			echo "<pre>";print_r($paypalInfo);
            $data['user_id'] = $paypalInfo['custom'];
            $data['product_id']    = $paypalInfo["item_number"];
            $data['txn_id']    = $paypalInfo["txn_id"];
            $data['payment_gross'] = $paypalInfo["payment_gross"];
            $data['currency_code'] = $paypalInfo["mc_currency"];
            $data['payer_email'] = $paypalInfo["payer_email"];
            $data['payment_status']    = $paypalInfo["payment_status"];

            $paypalURL = $this->paypal_lib->paypal_url;        
            $result    = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
            
            //check whether the payment is verified
            if(preg_match("/VERIFIED/i",$result)){
                //insert the transaction data into the database
                print_r($data);
            }
        }
    }
?>