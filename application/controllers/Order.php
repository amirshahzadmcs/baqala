<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->customer->isLogged()){	
			$this->load->model('Home_model');	
			$this->load->model('admin/Quotation_model');
			$this->load->model('Order_model');		
			$this->load->library('form_validation');
			$this->load->library('phpqrcode/qrlib');
			$this->load->helper('url');	
			$this->load->helper('sendmail_helper');
		}else{
			redirect('login');
		}
	}
	
	public function index(){
		return true;
	}
	
	public function order_status_manage(){
		return true;
	}
	
	public function getGeoAddress(){
		$terms = $this->input->post('product_id');

		$data = file_get_contents("https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".$terms."&types=geocode&key=AIzaSyDtcqgdP5G4BU2eX1iuV6NVyc3cTfc7MOM");

		$arr = array();
		$i=0;
		foreach(json_decode($data)->predictions as $item){
			$arr[$i] = array(
				'id' => $i,
				'text' => $item->description
			);
			$i++;
		}

		echo json_encode($arr);
	}

	public function wishlist(){
		$data['addons'] = $this->Home_model->get_addons();
		$data['result'] = $this->Order_model->get_wishlist();
		$this->load->view("front/order/wishlist", $data);
	}
	
	public function wishlist_ajax(){
		$data['result'] = $this->Order_model->get_wishlist();
		$this->load->view("front/order/wishlist_ajax", $data);
	}
	
	public function buy_now_gift(){
		if($this->customer->isLogged()){
			$pid =  $this->input->get('gid');
			//print_r($pid);exit();
			//$data['personal'] = $this->Order_model->get_personal()->row();
			//$data['addresses'] = $this->Order_model->get_addresses();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/order/gift_form");
		}
		else{
			redirect("login?auth='".md5(time())."'&arial_path=buy_now_gift");
		}
	}
	
	public function add_to_cart(){
		$config['product_id'] = $this->input->post('product_id');
		$config['quantity'] = $this->input->post('quantity');
		$config['size_id'] = $this->input->post('size_id');
		$query = $this->Order_model->add_to_cart($config);
		if($query){
			if($query == 2){
				$data['success'] = "2";
				$data['message'] = "Quantity must greater than 0.";
			}elseif($query == 3){
				$data['success'] = "1";
				$data['message'] = "Cart successfully updated.";
			}else{
				$data['success'] = "1";
				$data['message'] = "Item added to cart.";
			}
		}
		else{
			$data['success'] = "0";
			$data['message'] = "Error!!!";
		} 
		$data['in_cart'] = $this->customer->inCart();
		echo json_encode($data);
	}
	
	public function remove_cart(){
		$id = $this->input->post('id');
		$data = $this->Order_model->remove_cart($id);
		
		$data['in_cart'] = $this->customer->inCart();
		echo json_encode($data);
	}
	
	public function remove_all_items(){
		$data = $this->Order_model->remove_all_cart();
		//$data['in_cart'] = $this->customer->inCart();
		return redirect('cart');
	}

	public function update_cart(){
		$id = $this->input->post("id");
		$quantity = $this->input->post("quantity");
		$total_exist = $this->Order_model->exist_quantity($id);
		if($total_exist >= $quantity){
			$query = $this->Order_model->update_cart($id, $quantity);
			$data['success'] = "1";
			$data['message'] = "Quantity successfully updated.";
			$data['in_cart'] = $this->customer->inCart();
		} else{
			$data['success'] = "2";
			$data['message'] = "Maximum available pcs are <strong>" . $total_exist . "</strong>";
			$data['in_cart'] = $this->customer->inCart();
		}
		echo json_encode($data);
	}
	
	public function add_to_wishlist(){
		if($this->customer->isLogged()){
			$id = $this->input->post('id');
			$query = $this->Order_model->add_wishlist($id);
			if($query){
				$data['success'] = "1";
				$data['message'] = "Item added to your wishlist. <a href=\"wishlist\"> View Wishlist</a>";
			}
			else{
				$data['success'] = "0";
				$data['message'] = "Error!!!";
			}
		} else{
			$data['success'] = "2";
			$data['message'] = "Please login first to create wishlist. ";
		}
		echo json_encode($data);
	}
	
	public function remove_from_wishist(){
		$id = $this->input->post('id');
		$this->Order_model->remove_wishlist($id);
		echo $id;
	}
	
	public function cart(){
	    $data['sel_lang'] = $this->session->userdata("site_lang");
		$data['results'] = $this->Order_model->cart_products();
		//echo '<pre>';print_r($data['results']->result_array());'</pre>';exit();
		$this->load->view('front/order/cart',$data);
	}
	
	public function cart_ajax(){
	    $data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Order_model->cart_products();
		$this->load->view('front/order/cart_ajax',$data);
	}
	
	public function set_promotion(){
		$code = $this->input->post('code');
		$total_price = $this->input->post("total_price");
		$query = $this->Order_model->set_promotion($code);
		if($query->num_rows()){
			$sql = $query->row();
			$data['code'] = $sql->code;
			$data['name'] = $sql->name;
			$data['type'] = $sql->type;
			$data['discount'] = $sql->discount;
			$min_price = $sql->min_price;
			$max_price = $sql->max_price;
			
			if($total_price < $min_price){
				/*
				$data['success'] = "2";
				$data['message'] = 'Min Price to use promo code is ' . $this->customer->getRealRate($min_price);
				*/
				$this->session->set_flashdata('msg','Min Price to use promo code is ' . $this->customer->getRealRate($min_price));
				$this->session->set_flashdata('is_success','2');
			} else{
				if($data['type'] = '1'){
    				$discount_amount = $total_price * ($data['discount']/100);
    			}
    			else{
    				$discount_amount = $data['discount'];
    			}
    			if($discount_amount > $max_price){
    				$data['discount_amount'] = $max_price;
    			}
    			else{
    				$data['discount_amount'] = $discount_amount;
    			}
				/*
				$data['success'] = "1";
				$data['message'] = "Promotion code applied";
				*/
				$this->session->set_userdata("promotion_code", $data);
				$this->session->set_flashdata('msg','Promotion code applied');
				$this->session->set_flashdata('is_success','1');
			}
		}
		else{
			/*
			$data['success'] = "2";
			$data['message'] = 'Promotion code is not valid';
			*/
			$this->session->set_flashdata('msg','Promotion code not valid');
			$this->session->set_flashdata('is_success','2');
		}
		//echo json_encode($data);exit();
		redirect("cart");
	}
	
	public function remove_promotion(){
		$this->session->unset_userdata("promotion_code");
		$this->session->set_flashdata('msg','Promotion code removed');
		$this->session->set_flashdata('is_success','1');
		redirect("cart");
	}
	
	public function checkout_address(){
		if($this->customer->inCart() == '0'){
			redirect("/");
		}
		//echo '<pre>';print_r($this->customer->total_order_price()['total']);'</pre>';exit();
		$total_cart_price = $this->customer->total_order_price()['total'];
		/*
		if($total_cart_price < '199'){
			$data['success'] = "0";
			$this->session->set_flashdata('msg', 'Minimum Order Value is Rs. 199');
		    redirect("cart");
		}*/
		if($this->customer->isLogged()){
			$data['personal'] = $this->Order_model->get_personal()->row();
			$data['addresses'] = $this->Order_model->get_addresses();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view('front/order/order_address',$data);
		}
		else{
			redirect("login?auth='".md5(time())."'&arial_path=order-address");
		}
	}
	
	public function search_address(){
		if($this->customer->isLogged()){
			$data['personal'] = $this->Order_model->get_personal()->row();
			$data['addresses'] = $this->Order_model->get_addresses();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view('front/order/order_address_search',$data);
		}
		else{
			redirect("login?auth='".md5(time())."'&arial_path=order-address");
		}
	}
	
	public function delivery_slot(){
		if($this->customer->inCart() == '0'){
			redirect("/");
		}
		if($this->customer->isLogged()){
			//$this->session->unset_userdata('delv_date');
			$data['personal'] = $this->Order_model->get_personal()->row();
			$total_order_price = $this->customer->total_order_price();
			//print_r($total_order_price['total']);exit();
			$data['shipping_charge'] = $this->customer->getShipping($total_order_price['total']);
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view('front/order/delivery-time',$data);
		}
		else{
			redirect("login?auth='".md5(time())."'&arial_path=delivery-slots");
		}
	}

	public function delivery_slot_ajax(){
		$this->session->unset_userdata('delv_time');
		$date_slot = $this->input->post('delv_date');
		$data['time_slots'] = $this->Order_model->get_time_slots($date_slot);
		$total_order_price = $this->customer->total_order_price();
		//print_r($total_order_price['total']);exit();
		$data['shipping_charge'] = $this->customer->getShipping($total_order_price['total']);
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$output=$this->load->view("front/order/delivery-time-ajax",$data);
		echo json_encode($output);
	}

	public function set_delivery_date_slot(){
		$delv_date = $this->input->post("delv_date");
		$this->session->set_userdata('delv_date', $delv_date);
		if($this->session->userdata("delv_date")){
			$this->session->unset_userdata('delv_time');
			return true;
		}else{
			return false;
		}
	}

	public function set_delivery_time_slot(){
		$delv_time = $this->input->post("delv_time");
		$delv_time_short = $this->input->post("shortname");
		$newdata = array( 
		   'delv_time'  => $delv_time,
		   'delv_time_short'     => $delv_time_short
		);  
		$this->session->set_userdata($newdata);
		if($this->session->userdata("delv_time")){
			return true;
		}else{
			return false;
		}
	}

	public function set_contactless(){
		$contactless = $this->input->post("contactless");
		$this->session->set_userdata('contactless', $contactless);
		if($this->session->userdata("contactless")){
			return true;
		}else{
			return false;
		}
	}
	
	public function checkout(){
		if($this->customer->inCart() == '0'){
			redirect("/");
		}
		if($this->customer->isLogged()){
			$data['personal'] = $this->Order_model->get_personal()->row();
			$data['address'] = $this->Order_model->get_addresses();
			$data['results'] = $this->Order_model->cart_products();
			$data['b2b_availability'] = 'yes';
			foreach($data['results']->result() as $products){
				if($products->b2b_availability == 'yes'){
					$data['b2b_availability'] = 'no';
				}
			}
			//echo '<pre>';print_r($data['address']);'</pre>';exit();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view('front/order/checkout',$data);
		}
		else{
			redirect("login?auth='".md5(time())."'&arial_path=checkout");
		}
	}
	
	public function set_guestcheckout(){
		$data['email'] = $this->input->post('email');
		$data['name'] = $this->input->post('name');
		$data['address1'] = $this->input->post('address1');
		$data['address2'] = $this->input->post('address2');
		$data['mobile'] = $this->input->post('mobile');
		$data['city'] = $this->input->post('city');
		$data['state'] = $this->input->post('state');
		$data['pincode'] = $this->input->post('postal');
		$data['svc'] = $this->input->post('svc');
		if($this->session->userdata("guest")){
			$this->session->unset_userdata("guest", $data);
		}
		$this->session->set_userdata("guest", $data);
	}
	
	public function set_giftckout(){
		if($this->customer->isLogged()){
			$data['gid'] = $this->input->post('gid');
			$data['recipient_name'] = $this->input->post('recipient_name');
			$data['g_to'] = $this->input->post('g_to');
			$data['g_from'] = $this->input->post('g_from');
			$data['g_message'] = $this->input->post('g_message');
			if($this->session->userdata("gift_detail")){
				$this->session->unset_userdata("gift_detail", $data);
			}
			$this->session->set_userdata("gift_detail", $data);
			$data['prod_detail'] = $this->Order_model->gift_products($this->input->post('gid'))->row();
			$data['personal'] = $this->Order_model->get_personal()->row();
			//echo '<pre>';print_r($data);'</pre>';exit();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view('front/order/gift_checkout',$data);
		}else{
			redirect("login?auth='".md5(time())."'");
		}
	}
	
	public function giftckoutpage(){
		if($this->customer->isLogged()){
			if($this->session->userdata("gift_detail")){
				$query = $this->Order_model->get_personal()->row();
			}else{
				redirect("/");
			}
		}else{
			redirect("login?auth='".md5(time())."'");
		}
	}
	
	public function set_delievery_address(){
		$id = $this->input->post("ship_id");
		$this->session->set_userdata('delievery_id', $id);
		//echo (int)$this->session->userdata('delievery_id');
	}
	
	public function get_address_ajax(){
		$data['addresses'] = $this->Order_model->get_addresses();
		//print_r($data['result']->result());exit();
		$this->load->view('front/order/checkout_address_ajax', $data);
	}
	
	public function checkout_quotation_order(){
		$query = $this->Order_model->createOrder();
		
		if($query['query']){
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->session->set_flashdata('order_id', $query['orderid']);
			redirect("thanks-for-order");
		} else{
			redirect("order-error");
		}
	}
	
	public function order_list(){
	    $data['sel_lang'] = $this->session->userdata("site_lang");
		$data['orders'] = $this->Order_model->order_list();
		//echo '<pre>';print_r($data['results']);'</pre>';exit();
		$this->load->view('front/account/order_history',$data);
	}

	public function order_detail($id){
	    $data['sel_lang'] = $this->session->userdata("site_lang");
		$data['order_info'] = $this->Order_model->get_order_details($id);
		//echo '<pre>';print_r($data['quotations']);'</pre>';exit();
		$this->load->view('front/account/order_detail',$data);
	}

	public function quotation_list(){
	    $data['sel_lang'] = $this->session->userdata("site_lang");
		$data['quotations'] = $this->Order_model->quotation_list();
		//echo '<pre>';print_r($data['quotations']);'</pre>';exit();
		$this->load->view('front/account/quotation_history',$data);
	}

	public function quotation_detail($id){
	    $data['sel_lang'] = $this->session->userdata("site_lang");
		$data['order_info'] = $this->Order_model->get_quotation_details($id);
		//echo '<pre>';print_r($data['quotations']);'</pre>';exit();
		$this->load->view('front/account/quotation_detail',$data);
	}

	public function approve_quotation(){
		$quote_id = $this->input->get('qid');
		if($quote_id > 0){
			$query = $this->Order_model->approve_quotation($quote_id);
			if($query){
				$data['success'] = "1";
				$data['message'] = "Status successfully updated.";
			}
			else{
				$data['success'] = "0";
				$data['message'] = "Error!!!";
			} 
		}else{
			$data['success'] = "0";
			$data['message'] = "Invalid Quotation!!!";
		}
		redirect("quotation-detail/". $quote_id);
	}

	public function copy_order_basket(){
		$query = $this->Order_model->copy_to_basket();
		if($query){
			$data['success'] = "1";
			$data['message'] = "Items successfully copied to cart.";
		}
		else{
			$data['success'] = "0";
			$data['message'] = "Error!!!";
		} 
		$data['in_cart'] = $this->customer->inCart();
		echo json_encode($data);
	}

	public function copy_quotation_basket(){
		$query = $this->Order_model->quotation_to_basket();
		if($query){
			$data['success'] = "1";
			$data['message'] = "Items successfully copied to cart.";
		}
		else{
			$data['success'] = "0";
			$data['message'] = "Error!!!";
		} 
		$data['in_cart'] = $this->customer->inCart();
		echo json_encode($data);
	}

	public function cod_confirm_order(){
		$type = $this->db->escape_str($this->input->get('type'));
		$wallet_checked = $this->db->escape_str($this->input->get('wallet'));
		$rewards_checked = $this->db->escape_str($this->input->get('rewards'));	
		$query = $this->Order_model->order_fridge($wallet_checked,$rewards_checked);
		
		//print_r($wallet_checked);exit();
		if($query){
			$txnid = '';
			$productinfo = $query['orderid'];
			$this->load->model("admin/Order_process_model");
			$this->Order_model->pay_confirm($txnid, $productinfo, $type);
			if($query['wallet_amt'] > 0){
				$this->Order_model->wallet_debit($query['wallet_amt'], $productinfo);
			}
			if($query['rewards_amt'] > 0){
				$this->Order_model->rewards_update($query['rewards_amt'],$query['orderid']);
			}
			$conf['result'] = $this->Order_process_model->get_order($productinfo);
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
			/*
			$msg = urlencode('Order Placed - Your Order with Order ID - #00'.$productinfo.' amounting of Rs. '.$conf['result']['order']['order_total'].' has been ordered successfully. We will send you an update when your Order will shipped.');
		    $sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=+91'.$conf['result']['order']['mobile'].'&sms='.$msg;
		    $response = file_get_contents($sms);
			
			
			$msg = urlencode('New Order Recieved - with Order ID - #00'.$productinfo.' amounting of Rs. '.$conf['result']['order']['order_total'].' has been received.');
			$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=9220202038&sms='.$msg;
			$response = file_get_contents($sms);*/
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->session->set_flashdata('order_id', $productinfo);
			redirect("thanks-for-order");
		} else{
			redirect("order-error");
		}
	}
	
	public function credit_order(){
		$type = 'Credit Account';
		$wallet_checked = $this->db->escape_str($this->input->get('wallet'));
		$rewards_checked = $this->db->escape_str($this->input->get('rewards'));
		$query = $this->Order_model->order_fridge($wallet_checked,$rewards_checked);
		
		//print_r($query);exit();
		if($query){
			$txnid = '';
			$productinfo = $query['orderid'];
			$this->load->model("admin/Order_process_model");
			$this->Order_model->pay_confirm($txnid, $productinfo, $type);
			$this->Order_model->credit_update($query['total'],$productinfo,$query['trans_id']);
			if($query['wallet_amt'] > 0){
				$this->Order_model->wallet_debit($query['wallet_amt'], $productinfo);
			}
			if($query['rewards_amt'] > 0){
				$this->Order_model->rewards_update($query['rewards_amt'],$query['orderid']);
			}
			$conf['result'] = $this->Order_process_model->get_order($productinfo);
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
			/*
			$msg = urlencode('Order Placed - Your Order with Order ID - #00'.$productinfo.' amounting of Rs. '.$conf['result']['order']['order_total'].' has been ordered successfully. We will send you an update when your Order will shipped.');
		    $sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=+91'.$conf['result']['order']['mobile'].'&sms='.$msg;
		    $response = file_get_contents($sms);
			
			
			$msg = urlencode('New Order Recieved - with Order ID - #00'.$productinfo.' amounting of Rs. '.$conf['result']['order']['order_total'].' has been received.');
			$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=berskasm&password=e796253cafXX&senderid=APNICH&mobiles=9220202038&sms='.$msg;
			$response = file_get_contents($sms);*/
			$this->session->set_flashdata('order_id', $productinfo);
			redirect("thanks-for-order");
		} else{
			redirect("order-error");
		}
	}
		
	public function pay_confirm_order(){
		$query = $this->Order_model->order_fridge();
		if($query){
			$this->load->model("admin/Order_process_model");
			$result = $this->Order_process_model->get_order($query['orderid']);
			
            $amount =  round($result['order']['order_total']);
            $product_info = $result['order']['id'];
            $customer_name = $result['order']['payment_firstname'];
            $customer_email = $result['order']['email'];
            $customer_mobile = $result['order']['mobile'];
            $customer_address = $result['order']['payment_address1'].", ".$result['order']['payment_address2'].", ".$result['order']['payment_city'].", ".$result['order']['payment_state'].", ".$result['order']['payment_country']." - ".$result['order']['payment_postcode'];
            
            //payumoney details
            $MERCHANT_KEY = "lndZoTfF"; 
            $SALT = "IOHHwhDyKr";  
            
            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
            //optional udf values 
            $udf1 = '';
            $udf2 = '';
            $udf3 = '';
            $udf4 = '';
            $udf5 = '';
            
            $hashstring = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $product_info . '|' . $customer_name . '|' . $customer_email . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT;
            $hash = strtolower(hash('sha512', $hashstring));
         
            $success = base_url() . 'order/payu_status';  
            $fail = base_url() . 'order/payu_status';
            $cancel = base_url() . 'order/payu_status';
            
            
             $data = array(
                'mkey' => $MERCHANT_KEY,
                'tid' => $txnid,
                'hash' => $hash,
                'amount' => $amount,           
                'name' => $customer_name,
                'productinfo' => $product_info,
                'mailid' => $customer_email,
                'phoneno' => $customer_mobile,
                'address' => $customer_address,
                'action' => "https://secure.payu.in",
                'sucess' => $success,
                'failure' => $fail,
                'cancel' => $cancel,
    			'service_provider' => 'payu_paisa',
    			'abc' => $hashstring
            );
            $this->load->view('front/order/payu_confirm', $data);
		}else{
			redirect("order-error");
		}
	}
	
	function payu_status(){
		$status = $this->input->post('status');
        if (empty($status)) {
            redirect('/');
        }
		
        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');
        $email = $this->input->post('email');
        $salt = "IOHHwhDyKr";
        $add = $this->input->post('additionalCharges');
        If (isset($add)) {
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $data['hash'] = hash("sha512", $retHashSeq); 
		  
        if($status == 'success'){
			$type = 'PayUMoney';
			$this->load->model("admin/Order_process_model");
			$this->Order_model->pay_confirm($txnid, $productinfo, $type);
			$conf['result'] = $this->Order_process_model->get_order($productinfo);
			
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
			 
			/*SMS
			$msg = urlencode('Order Placed - Your Order with Order ID - '.$productinfo.' amounting of Rs. '.$amount.' has been received. You can expect delivery within 7 days. We will send you an update when your Order will shipped.');
			$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=saugatt&password=83b828317cXX&mobiles=' . $conf['result']['order']['mobile'] . '&sms='.$msg.'&senderid=Saugat';
			$response = file_get_contents($sms);
			SMS END*/
			/*SMS
			$msg = urlencode('New Order Recieved - with Order ID - '.$productinfo.' amounting of Rs. '.$amount.' has been received.');
			$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=saugatt&password=83b828317cXX&mobiles=9829321136&sms='.$msg.'&senderid=Saugat';
			$response = file_get_contents($sms);
			SMS END*/
			$data['order_id'] = $productinfo;
			$this->load->view("front/order/thanks_order", $data);
		  }
          else{
              redirect('order-error');
          }
	}

	public function thanks_order(){
		$id = $this->session->flashdata('order_id');
		if($id !== ''){
			$this->session->unset_userdata("promotion_code");
			$data['order_info'] = $this->Order_model->get_quotation_details($id);
			quotation_received_mail($id); // Mail to admin
			$this->Order_model->remove_all_cart();
			//$this->_qrcodeGenerator($data['order_info']->trans_id);
			//echo '<pre>';print_r($data['order_info']);'</pre>';exit();
			$this->load->view('front/order/thanks_order', $data);
		}else{
			redirect('/');
		}
	}
	
	public function order_error(){
		$this->load->view('front/order/order_cancel');
	}
    
    private function _qrcodeGenerator($param)
	{	
		$qrtext = 'Click below link to download invoice. https://baqalastation.com/app/download-invoice?id='.$param;	
		if(isset($qrtext))
		{
			$SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/app/uploads/qrcodes/';
			$text = $qrtext;
			//$text1= substr('123', 0,9);	
			$text1= $param;	
			$folder = $SERVERFILEPATH;
			$file_name1 = $text1."-Qrcode.png";
			$file_name = $folder.$file_name1;
			QRcode::png($text,$file_name);		
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	public function invoice_page(){
	    $this->load->view('front/order/download_page');
	}
	
	public function print_invoice_by_qr(){
	    $this->load->library('Pdf');
		$id = $this->input->get('id');
		if($id){
    		$data['result'] = $this->Order_model->get_order_details($id);
    		//print_r($data['result']);exit();
    		// create new PDF document
    		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    		// set document information
    		$pdf->SetCreator(PDF_CREATOR);
    		$pdf->SetAuthor('Baqala Station');
    		$pdf->SetTitle('Tax Invoice/Bill of Supply/Cash Memo');
    		$pdf->SetSubject('Order Invoice');
    		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');
    		
    		// remove default header/footer
    		$pdf->setPrintHeader(false);
    		
    		// set default header data
    		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);
    
    		// set header and footer fonts
    		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    		// set default monospaced font
    		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    		// set margins
    		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    		// set auto page breaks
    		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    		// set image scale factor
    		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    		// set some language-dependent strings (optional)
    		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    			require_once(dirname(__FILE__).'/lang/eng.php');
    			$pdf->setLanguageArray($l);
    		}
    
    		// ---------------------------------------------------------
    		// add a page
    		$pdf->AddPage();
    		$pdf->setRTL(false);
    
    		// print newline
    		$pdf->Ln();
    		// set font
    		$pdf->SetFont('aealarabiya', '', 10);
    
    		// Arabic and English content
    		$htmlcontent = $this->load->view('front/order/print_page',$data, true);;
    		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    		//Close and output PDF document
    		$status = $pdf->Output('baqala-invoice-'.$id.'.pdf', 'D');
            if($status==true){
                return 'https://baqalastation.com/';
            }else{
                return 'https://baqalastation.com/';
            }
		}else{
		    return 'https://baqalastation.com/';
		}
	}
	
	public function manage_status(){
		if($this->customer->isLogged()){
			$id = $this->input->get('id');
			$trans_id = $this->input->get('trans_id');
			//print_r($trans_id);exit();
			$query = $this->Order_model->cancel_order($id);
			if($query){
				$conf['result'] = $this->Order_model->get_order($id);
				if($conf['result']['payment_method'] == 'Credit Account'){
					$this->Order_model->updateCancelCredit($id,$trans_id);
				}
				if($conf['result']['cashback_applied'] > 0){
					$rewards_point = $conf['result']['cashback_applied'];
					$this->Order_model->rewards_refund($rewards_point,$id);
				}
				if($conf['result']['wallet_applied'] > 0){
					$wallet_point = $conf['result']['wallet_applied'];
					$this->Order_model->wallet_credit($wallet_point,$id);
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
				$message = $this->load->view("admin/order/email_deny", $conf,true);
			 
				$this->load->library('email');
				$this->email->initialize($config);
				$this->email->set_newline("\r\n");
				$this->email->from($eSetting->smtp_user, $subject); 
				$this->email->to($order->email);
				$this->email->subject($subject);
				$this->email->message($message);
				$send = $this->email->send();
				
				/*$msg = urlencode('This order with order id ' . $conf['result']['order']['id'] . ' has been canceled by user.');
				$sms = 'http://sms.arinfotech.org/sendsms.jsp?user=saugatt&password=83b828317cXX&mobiles=9829321136&sms='.$msg.'&senderid=Saugat';
				$response = file_get_contents($sms); */
			}
			redirect("account/order_history");
		}else{
			redirect("login?auth='".md5(time())."'&arial_path=order_history");
		}
	}	
	
}
