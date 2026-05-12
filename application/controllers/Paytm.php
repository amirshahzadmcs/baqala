<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paytm extends CI_Controller {
    
	public function __construct() {
        parent::__construct();
    	$this->load->model('Order_model');
    	$this->load->model('admin/Order_process_model');
	}

	function paytm(){
		$data=array();
		$data['query'] = $this->Order_model->order_fridge();
		$this->load->view('TxnTest',$data);
	}
	
	function pgResponse(){
		header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        // following files need to be included
        require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
        require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");
        
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum);
    		
		if($isValidChecksum == "TRUE" AND $_POST['STATUS'] == 'TXN_SUCCESS') {
			$type = 'PayTm';
			
			$this->Order_model->pay_confirm($_POST['TXNID'], $_POST['ORDERID'], $type);
			$conf['result'] = $this->Order_process_model->get_order($_POST['ORDERID']);
			
			// If you want to add log file to your project, use below code
            //$post_data = json_encode($paramList, JSON_UNESCAPED_SLASHES);
            //echo '<pre>';print_r($post_data);'</pre>';exit();
            //log_message('debug', $post_data);
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
    			
    			if (defined('SMS_GATEWAY_BASE_URL') && SMS_GATEWAY_BASE_URL !== '') {
    				$msg = urlencode('Order Placed - Your Order with Order ID - #00'.$_POST['ORDERID'].' amounting of Rs. '.$_POST['TXNAMOUNT'].' has been received. We will send you an update when your Order will shipped.');
			    	$sms = SMS_GATEWAY_BASE_URL.'?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=+91'.$conf['result']['order']['mobile'].'&sms='.$msg;
			    	$response = @file_get_contents($sms);
    			}
    			/*SMS END*/
    			
    			/*SMS*/
    			if (defined('SMS_GATEWAY_BASE_URL') && SMS_GATEWAY_BASE_URL !== '') {
    				$msg = urlencode('New Order Recieved - with Order ID - #00'.$_POST['ORDERID'].' amounting of Rs. '.$_POST['TXNAMOUNT'].' has been received through Paytm.');
    				$sms = SMS_GATEWAY_BASE_URL.'?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=9220202038&sms='.$msg;
    				$response = @file_get_contents($sms);
    			}
    			
    			/*SMS END*/
    			$data['order_id'] = $_POST['ORDERID'];
    			$this->load->view("front/order/thanks_order", $data);
    		 
    	}
    	else{
    		redirect("order-error");
    	}
    }
    
	function paytmpost(){
		
		 header("Pragma: no-cache");
		 header("Cache-Control: no-cache");
		 header("Expires: 0");

		 // following files need to be included
		 require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
		 require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");

		 $checkSum = "";
		 $paramList = array();

		 $ORDER_ID = $_POST["ORDER_ID"];
		 $CUST_ID = $_POST["CUST_ID"];
		 $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
		 $CHANNEL_ID = $_POST["CHANNEL_ID"];
		 $TXN_AMOUNT = $_POST["TXN_AMOUNT"];
		  
		// Create an array having all required parameters for creating checksum.
		 $paramList["MID"] = PAYTM_MERCHANT_MID;
		 $paramList["ORDER_ID"] = $ORDER_ID;
		 $paramList["CUST_ID"] = $CUST_ID;
		 $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
		 $paramList["CHANNEL_ID"] = $CHANNEL_ID;
		 $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
		
		 $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
		 //echo '<pre>';print_r($paramList);exit();
		 $paramList["CALLBACK_URL"] = base_url()."Paytm/pgResponse";
		// $paramList["CALLBACK_URL"] = "http://www.apnikirana.com/paytm/paytmCallback";
		 //echo '<pre>';print_r($paramList);exit();
		// $paramList["CALLBACK_URL"] = CALLBACK_URL;
		 /*
		 $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
		 $paramList["EMAIL"] = $EMAIL; //Email ID of customer
		 $paramList["VERIFIED_BY"] = "EMAIL"; //
		 $paramList["IS_USER_VERIFIED"] = "YES"; //

		 */
		 //echo '<pre>';print_r($paramList);exit();
		//Here checksum string will return by getChecksumFromArray() function.
		 $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
		 echo "<html>
		<head>
		<title>Merchant Check Out Page</title>
		</head>
		<body>
			<center><h1>Please do not refresh this page...</h1></center>
				<form method='post' action='".PAYTM_TXN_URL."' name='f1'>
		<table border='1'>
		 <tbody>";

		 foreach($paramList as $name => $value) {
		 echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
		 }

		 echo "<input type='hidden' name='CHECKSUMHASH' value='". $checkSum . "'>
		 </tbody>
		</table>
		
		</form>
		
		<script type=\"text/javascript\">
		window.onload = function(){
		document.forms['f1'].submit();
		} 
		</script>
		</body>
		</html>";

	} 
	
	function getTxnStatus(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        
        // following files need to be included
        require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
        require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");
        
        $ORDER_ID = "";
        $requestParamList = array();
        $responseParamList = array();
        
        $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => "18"); 
        
        $checkSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
        $requestParamList['CHECKSUMHASH'] = urlencode($checkSum);
        
        $data_string = "JsonData=".json_encode($requestParamList);
        //echo $data_string;
        
        $ch = curl_init(); // initiate curl
        $url = PAYTM_STATUS_QUERY_URL; //Paytm server where you want to post data
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); // define what you want to post
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec($ch); // execute
        $info = curl_getinfo($ch);
        
        $data = json_decode($output, true);
        echo "<pre>";
        print_r($output);
        echo "</pre>";
        exit();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
	}

	function paytmCallback(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        
        // following files need to be included
        require_once(APPPATH . "/third_party/paytmlib/config_paytm.php");
        require_once(APPPATH . "/third_party/paytmlib/encdec_paytm.php");
        
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";
        
        $paramList = $_POST;
        
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
        //echo 'isValidChecksum:-'.$isValidChecksum ;exit();

        if($isValidChecksum == "TRUE") {
        	echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
        	if ($_POST["STATUS"] == "TXN_SUCCESS") {
        		echo '<pre>';print_r($_POST);exit();
        	}
        	else {
        		echo "<b>Transaction status is failure</b>" . "<br/>";
        	}
        
        	if (isset($_POST) && count($_POST)>0 )
        	{ 
        		foreach($_POST as $paramName => $paramValue) {
        				echo "<br/>" . $paramName . " = " . $paramValue;
        		}
        	}
        }
        else {
        echo "<b>Checksum mismatched.</b>";
        //Process transaction as suspicious.
        }
        /* 	  	$this->load->view('front/order/thank'); */
    }
}
