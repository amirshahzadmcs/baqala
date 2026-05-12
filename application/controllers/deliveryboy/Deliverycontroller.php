<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Deliverycontroller extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if($this->deliveryboy->isLogged()){
			$this->load->model('admin/Delivery_model');
			$this->load->model('admin/Order_process_model');
			$this->load->model('admin/Orderimg_model');
			$this->load->model('deliveryboy/Order_delivered_model');
			$this->load->library('form_validation');
		}
		else{
			redirect('deliveryboy/common/login');
		}
	}
		
	public function index(){
		$id = $this->session->userdata('deliveryboy_id');
		//echo $id;exit();
		$data['orders'] = $this->Order_delivered_model->get_pending_by_dboy($id);
		//echo '<pre>';print_r($data['coming_order']);'</pre>';exit();
		if ($this->deliveryboy->getInfo()){
			$info = explode('--', $this->deliveryboy->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('delivery/task/pendinglist',$data);
	}
	
	public function detail(){	
		$id = $this->input->get("id");
		$dbid = $this->session->userdata('deliveryboy_id');
		$data['result'] = $this->Order_delivered_model->get_order($id, $dbid);
		$this->load->view('delivery/task/detail',$data);
	}
	
	public function orderDelivered(){
		$id = $this->input->post('id');
		$isRefund = $this->input->post('is_refund');
		$refund_amt = $this->input->post('refund_amt');
		$dbid = $this->session->userdata('deliveryboy_id');
		
		$data['result'] = $this->Order_delivered_model->get_order($id, $dbid);
		$delv_date = $data['result']['order']['shipping_date_slot'];
		$delv_time = $data['result']['order']['shipping_time_slot'];
		$current_date = date("Y-m-d");
		$current_time = date('h:i:s');
		$t1 = explode("-",$delv_time);
		$t2 = date('h:i:s',strtotime($t1[1]));
		if($delv_date <= $current_date && $t2 <= $current_date){
			$delv_time_status = 1;
		}else{
			$delv_time_status = 2;
		}
		$status = $this->input->post('status');	
		$mobile = $this->input->post("mobile");
		$collected_amt = $this->input->post("collected_amt");
		$delivery_payment = $this->input->post("delivery_payment");
		$canreason = $this->input->post("canreason");
        
        $delivery_charge = $this->Order_delivered_model->get_deliverboy_price($dbid);
        $delivery_amt = $delivery_charge->delivery_charge;
		
		//print_r($delv_time_status);exit();
		$query = $this->Order_delivered_model->process($id, $status, $collected_amt, $canreason, $delivery_payment, $delivery_amt);
		if($query){
    		$this->Order_delivered_model->deliveryProcess($id, $dbid, $status, $collected_amt, $delivery_payment, $delivery_amt,$delv_time_status);
    		
    		if($status == '3'){
    			$subject = 'Order Denied | Baqala Station';
    			$message = $this->load->view("admin/order/email_deny", $data, true);
    		}
    		
    		if($status == '6'){
    			$cust_id = $data['result']['order']['customer_id'];
    			$p_cashback = $data['result']['order']['total_cashback'];
    			$isRef = $this->customer->refDetail($cust_id);
    			//print_r($isRef);exit();
    			if($isRef !== '' && $isRef > 0){
    				$referer_uid = $isRef['referer_uid'];
    				$referer_amt = $isRef['referer_amt'];
    				$remarks = 'Reward points credited for referral.';
    				
    				$refered_code = $isRef['refered_code'];
    				$refered_amt = $isRef['refered_amt'];
    				
    				$query_ref = $this->Order_process_model->reward_refund($referer_uid, $referer_amt, $remarks);
    				if($query_ref){
    				    $this->Order_process_model->reward_refund($cust_id, $refered_amt, $remarks);
    				    $this->Order_delivered_model->updateReferral($cust_id);
    				}
    			}
				if($isRefund == '1'){
					$this->Order_delivered_model->refundExtraAmount($cust_id, $id, $refund_amt);
				}
				if($p_cashback > 0){
					$this->Order_delivered_model->creditCashback($cust_id, $id, $p_cashback);
				}
				if($_FILES['image']['name']){
					$con['upload_path']   = './uploads/order_image/';
					$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$con['max_size']      = 0;
					$con['max_width']     = 0;
					$con['max_height']    = 0;
					$con['max_filename'] = '60';
					$con['encrypt_name'] = TRUE;
					$this->load->library('upload', $con);
					if (!$this->upload->do_upload('image')) {
					   echo $this->upload->display_errors();
					   exit;
					}
					else {
						$image_data = $this->upload->data();
						$image = "uploads/order_image/".$image_data['file_name'];
						$this->Orderimg_model->add($image,$id);
					}
				}
				
				if($_FILES['image1']['name']){
					$con['upload_path']   = './uploads/order_image/';
					$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
					$con['max_size']      = 0;
					$con['max_width']     = 0;
					$con['max_height']    = 0;
					$con['max_filename'] = '60';
					$con['encrypt_name'] = TRUE;
					$this->load->library('upload', $con);
					if (!$this->upload->do_upload('image1')) {
					   echo $this->upload->display_errors();
					   exit;
					}
					else {
						$image_data = $this->upload->data();
						$image = "uploads/order_image/".$image_data['file_name'];
						$this->Orderimg_model->add($image,$id);
					}
				}
    			$subject = 'Order Delievered | Baqala Station';
    			$message = $this->load->view("delivery/task/email_deliever", $data, true);
    		}
    		
    		if($status == '7'){
    			$o_id = $data['result']['order']['id'];
    			$trans_id = $data['result']['order']['trans_id'];
    			$trans_method = $data['result']['order']['payment_method'];
    			$rewards_point = $data['result']['order']['cashback_applied'];
    			$wallet_point = $data['result']['order']['wallet_applied'];
    			$uid = $data['result']['order']['customer_id'];
    			//print_r($trans_method);exit();
    			if($trans_method == 'Credit Account'){
    				$this->Order_delivered_model->updateCancelCredit($o_id, $trans_id, $uid);
    			}
    			if($rewards_point > 0){
    				$remarks = 'Rewards Refund for Order ID '. $o_id;
    				$this->Order_process_model->reward_refund($uid, $rewards_point, $remarks);
    			}
				if($wallet_point > 0){
    				$remarks = 'Amount Refund for Order ID '. $o_id;
    				$this->Order_process_model->wallet_refund($uid, $wallet_point, $remarks);
    			}
    			$subject = 'Order Canceled | Baqala Station';
    			$message = $this->load->view("delivery/task/email_cancel", $data, true);
    		}
    		$eSetting = $this->customer->emailSetting();
    		/*********Email*************/
    		$config = Array(
    			'protocol' => $eSetting->protocol,		
    			'smtp_host' => $eSetting->smtp_host,		
    			'smtp_port' => $eSetting->smtp_port,			
    			'smtp_user' => $eSetting->smtp_user,		
    			'smtp_pass' => $eSetting->smtp_pass,	
    			'mailtype' => 'html'
    		);
    	
    		$this->load->library('email');
    		$this->email->initialize($config);
    		$this->email->set_newline("\r\n");
    		$this->email->from($eSetting->smtp_user, $eSetting->website_name.' | '.$subject);
    		$this->email->to($this->input->post('email'));
    		$this->email->subject($subject);
    		$this->email->message($message);
    		$send = $this->email->send();
    		/**********************/
		}
		//redirect("deliveryboy/Deliverycontroller/detail?id=".$id);
		redirect("deliveryboy/Deliverycontroller");

	}
	
	public function wallet_history(){
		$dbid = $this->session->userdata('deliveryboy_id');
		$data['user_info'] = $this->Order_delivered_model->get_detail($dbid);
		$data['wallet_reports'] = $this->Order_delivered_model->get_wallet_history($dbid);
		$this->load->view('delivery/home/wallet_history',$data);
	}
	
	public function recharge(){	
		$id = $this->session->userdata('deliveryboy_id');		
		//$data['orders'] = $this->Order_delivered_model->get_completed_by_dboy($id);
		$this->load->view('delivery/home/recharge');
	}
	
	function verify_user(){
		$username = $this->input->post('username');
		$query = $this->Order_delivered_model->verify_customer($username);
		if(!empty($query)){
			$data['result'] = $query;
			//echo '<pre>';print_r($query);exit();
			$this->load->view('delivery/home/recharge-verified',$data);
		}
		else{
			$this->session->set_flashdata('msg','Invalid account'); 
			$this->session->set_flashdata('is_success','0');
			redirect('deliveryboy/Deliverycontroller/recharge');
			//exit();
		}
	}
	
	public function recharge_customer(){
		if($this->deliveryboy->isLogged()){
			//$this->form_validation->set_rules('r_oid', 'Order Id', 'trim|required');
			$this->form_validation->set_rules('r_cid', 'Customer Id', 'trim|required');
			$this->form_validation->set_rules('recharge_amt', 'Amount', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>'. $msg .'</div>';exit();
			}
			else{
				$query = $this->Order_delivered_model->rechargeCustomerWallet();
				if($query){
					echo '<div class="bg-success text-center p-2"><div class="button-pulse p-5"><button class="pulse-button"><i class="icofont-check-circled text-success"></i></button></div><div class="success-text"><h4 class="text-white">Customer wallet successfully recharge.</h4></div><div class="success-text"><div class="bg-white rounded p-3 m-3 text-center"><button onclick="location.reload()" class="btn btn-warning btn-sm m-1">Recharge again</button><a href="recharge" class="btn btn-success btn-sm m-1">Go Back</button></div></div></a>';exit();
				}
				else{
					echo '<div class="bg-danger text-center p-2"><div class="button-pulse p-5"><button class="pulse-button" style="box-shadow: 0 0 0 0 #f44336;"><i class="icofont-close-circled text-danger"></i></button></div><div class="success-text"><h4 class="text-white">Recharge Failed.</h4></div><div class="success-text"><div class="bg-white rounded p-3 m-3 text-center"><button onclick="location.reload()" class="btn btn-warning btn-sm m-1">Try gain</button><a href="recharge" class="btn btn-success btn-sm m-1">Go Back</a></div></div></div>';exit();
				}
			}
		}else{
			redirect('deliveryboy/common/login');
		}
	}
	
	public function getOrderDetail(){	
		$id = $this->input->post('id');
		$dbid = $this->session->userdata('deliveryboy_id');		
		$orderDet = $this->Order_delivered_model->get_order_summery($id, $dbid);
		echo json_encode($orderDet);
	}
	
	public function completedOrders(){	
		$id = $this->session->userdata('deliveryboy_id');		
		$data['orders'] = $this->Order_delivered_model->get_completed_by_dboy($id);
		$this->load->view('delivery/task/list',$data);
	}
	
	public function canceledOrders(){	
		$id = $this->session->userdata('deliveryboy_id');		
		$data['orders'] = $this->Order_delivered_model->get_canceled_by_dboy($id);
		$this->load->view('delivery/task/cancelledlist',$data);
	}
	
	public function earnings(){	
		$id = $this->session->userdata('deliveryboy_id');		
		$data['earnings'] = $this->Order_delivered_model->get_earnings($id);
		$this->load->view('delivery/delivery/earning',$data);
	}
	
	public function ontimeDelivery(){	
		$id = $this->session->userdata('deliveryboy_id');		
		$data['deliveries'] = $this->Order_delivered_model->ontime_delivery($id);
		$this->load->view('delivery/delivery/ontime',$data);
	}
	
	public function delayDelivery(){	
		$id = $this->session->userdata('deliveryboy_id');		
		$data['deliveries'] = $this->Order_delivered_model->delay_delivery($id);
		$this->load->view('delivery/delivery/delay',$data);
	}
	
	public function help_desk(){
		$this->load->view('delivery/home/help');
	}
	
	public function manage_duty(){
		$this->load->view('delivery/home/delivery-time');
	}
	
}
