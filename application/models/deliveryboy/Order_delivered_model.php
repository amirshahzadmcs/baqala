<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_delivered_model extends CI_Model{
	
	function get_detail($id){
		$query = $this->db->query("SELECT deliveryboy.*, delivery_partner.cname, count(orders.id) as count_order FROM deliveryboy LEFT JOIN delivery_partner ON (delivery_partner.id = deliveryboy.partner_id) LEFT JOIN orders ON (deliveryboy.id = orders.delivery_boy) WHERE deliveryboy.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function process($id, $status, $collected_amt, $canreason, $delivery_payment, $delivery_amt){
		$query = $this->db->query("UPDATE `orders` SET order_status_id = '" . (int)$status . "', collected_amt = '" . $this->db->escape_str($collected_amt) . "',  cancelreason = '" . $this->db->escape_str($canreason) . "', delivery_payment = '" . $this->db->escape_str($delivery_payment) . "', d_charge = '" . $this->db->escape_str($delivery_amt) . "', delivery_date = NOW() WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function deliveryProcess($id, $dbid, $status, $collected_amt, $delivery_payment, $delivery_amt,$delv_time_status){
		$query = $this->db->query("INSERT `delivery_payments` SET deliveryboy_id = '" . (int)$dbid . "', order_id = '" . (int)$id . "', delivery_status = '" . (int)$status . "', collected_amount = '" . $collected_amt . "', delivery_amt = '" . $delivery_amt . "',  payment_type = '" . $this->db->escape_str($delivery_payment) . "', delivery_t_status = '" . (int)$delv_time_status . "', created_at = NOW()");
		return $query;
	}
	
	function get_deliverboy_price($id){
		$query = $this->db->query("SELECT delivery_charge FROM deliveryboy WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_order($id, $dbid){
		$query = $this->db->query("SELECT o.*, db.name as db_name, db.mobile as db_mob FROM `orders` o LEFT JOIN deliveryboy db ON(o.delivery_boy = db.id) WHERE o.id = '" . (int)$id . "' AND o.delivery_boy = '" . (int)$dbid . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "'")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}
	
	function get_status_by_dboy($id){
		$query = $this->db->query("SELECT order_status_id FROM `orders` WHERE delivery_boy = '" . (int)$id . "' AND order_status_id > 4 ORDER BY id ASC");
		return $query->result();
	}
	
	function get_order_summery($id, $dbid){
		$query = $this->db->query("SELECT * FROM `orders` WHERE id = '" . (int)$id . "' AND delivery_boy = '" . $dbid . "'");
		return $query->row();
	}
	
	function get_pending_by_dboy($id){
		$query = $this->db->query("SELECT * FROM `orders` WHERE delivery_boy = '" . (int)$id . "' AND order_status_id = '" . 5 . "' ORDER BY id ASC");
		return $query->result();
	}
	
	function upcoming_delivery($id){
		$query = $this->db->query("SELECT * FROM `orders` WHERE delivery_boy = '" . (int)$id . "' AND order_status_id = '" . 5 . "' ORDER BY id ASC LIMIT 1");
		return $query->row();
	}
	
	function get_completed_by_dboy($id){
		$query = $this->db->query("SELECT * FROM `orders` WHERE delivery_boy = '" . (int)$id . "' AND order_status_id = '" . 6 . "' ORDER BY id DESC");
		return $query->result();
	}
	
	function get_canceled_by_dboy($id){
		$query = $this->db->query("SELECT * FROM `orders` WHERE delivery_boy = '" . (int)$id . "' AND order_status_id = '" . 7 . "' ORDER BY id DESC");
		return $query->result();
	}
	
	function get_earnings($id){
		$query = $this->db->query("SELECT * FROM delivery_payments WHERE deliveryboy_id = '" . (int)$id . "' AND delivery_status > 5");
		return $query->result();
	}
	
	function total_delv_earnings($id){
		$query = $this->db->query("SELECT SUM(delivery_amt) AS total_income, SUM(collected_amount) as total_collection FROM delivery_payments WHERE deliveryboy_id = '" . (int)$id . "' AND delivery_status > 5");
		return $query->row();
	}
	
	function todays_earnings($id){
		$query = $this->db->query("SELECT SUM(delivery_amt) AS today_income FROM delivery_payments WHERE deliveryboy_id = '" . (int)$id . "' AND delivery_status > 5 AND created_at >=  CURDATE()");
		return $query->row();
	}
	
	function ontime_delivery($id){
		$query = $this->db->query("SELECT * FROM delivery_payments WHERE deliveryboy_id = '" . (int)$id . "' AND delivery_t_status = '1' AND delivery_status = '6'");
		return $query->result();
	}
	
	function delay_delivery($id){
		$query = $this->db->query("SELECT * FROM delivery_payments WHERE deliveryboy_id = '" . (int)$id . "' AND delivery_t_status = '2' AND delivery_status = '6'");
		return $query->result();
	}
	
	function deliver_charge($id){
		$query = $this->db->query("SELECT * FROM delivery_payments WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function updateCancelCredit($o_id, $trans_id, $uid){
		if($o_id > 0){
			$c_query = $this->db->query("SELECT car.id, car.debit, ca.credit_avilable FROM credit_account_report car LEFT JOIN credit_account ca ON (car.user_id = ca.user_id) WHERE car.trans_id = '" . $this->db->escape_str($trans_id) . "' AND car.user_id = '" . (int)$uid . "'")->row();
			
			$car_id = $c_query->id;
			$credit_amt = $c_query->debit;
			$avl_amt = $c_query->credit_avilable;
			$current_amt = $credit_amt + $avl_amt;
			$new_trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
			//print_r($c_query);exit();
			
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', updated_at = NOW() WHERE user_id = '" . $this->db->escape_str((int)$uid) . "'");
			
			$query = $this->db->query("UPDATE credit_account_report SET remarks = 'Cancellation Refund Order ID #BS". $o_id ."', age = '0', status =  '2', payment_date =  now(), updated_at = NOW() WHERE id =  '" . $this->db->escape_str((int)$car_id) . "'");
			
			$query = $this->db->query("INSERT INTO credit_account_report SET node =  '" . $car_id . "', trans_id =  '" . $new_trans_id . "', avl_bal =  '" . $current_amt . "', debit =  0, credit =  '" . $credit_amt . "', trans_type =  'credit', remarks = 'Cancellation Refund Order ID - #BS". $o_id ."', user_id =  '" . $this->db->escape_str((int)$uid) . "', status =  '2', updated_at = now(), payment_date =  now()");
		}
		return $query;
	}
	
	function get_wallet_history($dbid){
		$query = $this->db->query("SELECT * FROM dboy_wallet_report WHERE dboy_id = '" . (int)$dbid . "' ORDER BY id desc")->result();
		return $query;
		
	}
	
	public function verify_customer($username){
		$query = $this->db->query("SELECT id,name,email,mobile FROM customer WHERE email = '" . $username . "' OR mobile = '" . $username . "'")->row();
		return $query;
	}
	
	function refundExtraAmount($r_cid, $r_oid, $amount){
		$dbid = $this->session->userdata('deliveryboy_id');
		$c_wallet = $this->db->query("SELECT wallet,mobile FROM customer WHERE id = '" . (int)$r_cid . "'")->row();
		$d_wallet = $this->db->query("SELECT wallet FROM deliveryboy WHERE id = '" . (int)$dbid ."'")->row();
		$oid = $r_oid;
		$trans_id = strtoupper('D'.uniqid());
		$mob = $c_wallet->mobile;
		$u_remarks = 'Extra Change Credit ';
		$d_remarks = 'Extra Change - ';
		$newCustWallet = $c_wallet->wallet + $amount;
		$newDelWallet = $d_wallet->wallet - $amount;
		
		$query = $this->db->query("UPDATE customer SET wallet = '" . $newCustWallet . "', modified = NOW() WHERE id = '" . (int)$r_cid . "'");
		
		if($query){
			$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$r_cid . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $u_remarks . $amount .' SAR'."', updated_at = NOW()");
			
			$this->db->query("UPDATE deliveryboy SET wallet = '" . $newDelWallet . "', updated_at = NOW() WHERE id = '" . (int)$dbid . "'");
			
			$this->db->query("INSERT INTO dboy_wallet_report SET dboy_id =  '" . (int)$dbid . "', amount =  '" . $amount . "', transaction_id =  '" . $trans_id . "', trans_type =  'debit', order_id =  '" . $oid . "', remarks =  '" . $d_remarks.$mob ."', updated_at = NOW()");
		}
		return $query;
	}
	
	function creditCashback($cid, $oid, $amount){
		$wallet = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$cid . "'")->row();
		$remarks = 'Cashback credit order id '.$oid;
		$newWallet = $wallet->wallet + $amount;
		$query = $this->db->query("UPDATE customer SET wallet = '" . $newWallet . "', modified = NOW() WHERE id = '" . (int)$cid . "'");
		
		$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$cid . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = NOW()");
		
		return $query;
	}
	
	function rechargeCustomerWallet(){
		$dbid = $this->session->userdata('deliveryboy_id');
		$c_wallet = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->input->post('r_cid') . "'")->row();
		$d_wallet = $this->db->query("SELECT wallet FROM deliveryboy WHERE id = '" . (int)$dbid ."'")->row();
		$oid = $this->input->post('r_oid');
		$trans_id = strtoupper('D'.uniqid());
		$mob = $this->input->post('r_mob');
		$amount = $this->input->post('recharge_amt');
		$u_remarks = 'eTopup Credit ';
		$d_remarks = 'eTopup - ';
		$newCustWallet = $c_wallet->wallet + $amount;
		$newDelWallet = $d_wallet->wallet - $amount;
		
		$query = $this->db->query("UPDATE customer SET wallet = '" . $newCustWallet . "', modified = NOW() WHERE id = '" . (int)$this->input->post('r_cid') . "'");
		
		if($query){
			$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$this->input->post('r_cid') . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $u_remarks . $amount .'SAR'."', updated_at = NOW()");
			
			$this->db->query("UPDATE deliveryboy SET wallet = '" . $newDelWallet . "', updated_at = NOW() WHERE id = '" . (int)$dbid . "'");
			
			$this->db->query("INSERT INTO dboy_wallet_report SET dboy_id =  '" . (int)$dbid . "', amount =  '" . $amount . "', transaction_id =  '" . $trans_id . "', trans_type =  'debit', order_id =  '" . $oid . "', remarks =  '" . $d_remarks.$mob ."', updated_at = NOW()");
		}
		return $query;
	}
	
	function updateReferral($user_id){
		$is_ref_used = 1;
		$query = $this->db->query("UPDATE referrals SET is_ref_used = '" . $is_ref_used . "', updated_at = NOW() WHERE user_id = '" . $this->db->escape_str((int)$user_id) . "'");
		return $query;
	}
}
