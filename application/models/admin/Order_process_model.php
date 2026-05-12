<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order_process_model extends CI_Model{

	function get_orders(){
		$sql = "SELECT *, TIMESTAMPDIFF(HOUR, '2022-12-30 13:16:55', '2022-12-31 13:13:55') as hour_diff, TIMESTAMPDIFF(MINUTE, '2022-12-30 13:16:55', '2022-12-31 13:13:55') as minute_diff FROM orders WHERE 1=1";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$sql .= " AND (date_added BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('order_no')) {
			$order_no = $this->input->get('order_no');
            if($order_no != ''){
                $sql .= " AND order_no = '" . $order_no . "'";
            }
        }

		if($this->input->get('min_price') AND $this->input->get('max_price')){
			$min_price = $this->input->get('min_price');
			$max_price = $this->input->get('max_price');
			if($min_price AND $max_price){
				$sql .= " AND (order_total BETWEEN '".$min_price."' AND '".$max_price."')";
			}
		}

		if($this->input->get('delivery_id')) {
			$delivery_id = $this->input->get('delivery_id');
            if($delivery_id != ''){
                $sql .= " AND delivery_boy = '" . $delivery_id . "'";
            }
        }

		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status != ''){
                $sql .= " AND order_status_id = '" . $status . "'";
            }
        }

		if($this->input->get('slotFilter')) {
			$slot = $this->input->get('slotFilter');
            if($slot != ''){
                $sql .= " AND `shipping_time_slot` = '" . $slot . "'";
            }
        }
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query;
	}
    
    function get_orders_collection(){
		$sql = "SELECT * FROM `orders` WHERE order_status_id = '5'";
		//collected_amt != 'NULL' AND payment_method != 'PayTm'
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `date_modified` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `date_modified` <='" . $d_to . "'";
			}
		}
		if($this->input->get('nameFilter')) {
			$taskFor = $this->input->get('nameFilter');
            if($taskFor != ''){
                $sql .= " AND `delivery_boy` = '" . (int)($this->input->get('nameFilter')) . "'";
            }
        }
		
		if($this->input->get('paymentFilter')) {
			$taskFor = $this->input->get('paymentFilter');
            if($taskFor != ''){
                $sql .= " AND `payment_method` = '" . $this->input->get('paymentFilter') . "'";
            }
        }
		
		$sql .= " ORDER BY date_modified ASC";
		$query = $this->db->query($sql);
		return $query;

	}
	
	function paytm_pmt_collection(){
		$sql = "SELECT id, order_total FROM `orders` WHERE payment_method = 'PayTm' AND order_status_id = '5'";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function dcharge_collection(){
		$sql = "SELECT delivery_amt FROM `delivery_payments`";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_completed_orders(){
		$sql = "SELECT * FROM `orders` WHERE order_status_id = '5'";
		if($this->input->get('date_from') AND $this->input->get('date_to')){
			$sql .= " AND date_added >= '" . date("Y-m-d", strtotime($this->input->get('date_from'))) . "' AND date_added <= '" . date("Y-m-d", strtotime($this->input->get('date_to'))) . "'";
		}
		$sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query;

	}

	function get_order($id){
		$query = $this->db->query("SELECT o.*, db.name as db_name, db.mobile as db_mob, db.email as db_email, om.order_image, mc.city_name as sel_city_name, ad.name as associate_name, ad.username as associate_username, cl.username as staff_username, cl.display_name as staff_display_name FROM `orders` o LEFT JOIN delivery_vehicles db ON(o.delivery_boy = db.id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE o.id = '" . (int)$id . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "'")->result_array();
		$logs = $this->db->query("SELECT * FROM status_change_log WHERE order_id = '" . (int)$id . "'")->result_array();
		$data = array("order"=>$query, "product"=>$sql, "logs"=>$logs);
		return $data;
	}
	
	function create_log($order_id, $status_type, $description, $remarks, $created_by){
		$query = $this->db->query("INSERT INTO status_change_log SET order_id =  '" . $order_id . "', status_type =  '" . $status_type . "', description =  '" . $description . "', remarks =  '" . $remarks . "', updated_by =  '" . $created_by . "', created_at = NOW()");
		return $query;
	}

	function log_check($order_id, $status_type){
		$query = $this->db->query("SELECT * from status_change_log WHERE order_id =  '" . $order_id . "' AND status_type =  '" . $status_type . "'");
		return $query->num_rows();
	}

	function process($id, $status, $tracking_id, $delivery_id, $canreason, $packets){
		$query = $this->db->query("UPDATE `orders` SET order_status_id = '" . (int)$status . "', tracking = '" . $this->db->escape_str($tracking_id) . "', packets = '" . (int)$this->db->escape_str($packets) . "', delivery_boy = '" . $this->db->escape_str($delivery_id) . "', cancelreason = '" . $this->db->escape_str($canreason) . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function updateCancelCredit($o_id, $trans_id, $uid){
		if($o_id > 0){
			$c_query = $this->db->query("SELECT car.id, car.debit, car.invoice_no, ca.credit_avilable FROM credit_account_report car LEFT JOIN credit_account ca ON (car.user_id = ca.user_id) WHERE car.trans_id = '" . $this->db->escape_str($trans_id) . "' AND car.user_id = '" . (int)$uid . "'")->row();
			
			$car_id = $c_query->id;
			$credit_amt = $c_query->debit;
			$avl_amt = $c_query->credit_avilable;
			$current_amt = $credit_amt + $avl_amt;
			$new_trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
			//print_r($c_query);exit();
			
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', updated_at = NOW() WHERE user_id = '" . $this->db->escape_str((int)$uid) . "'");
			
			$query = $this->db->query("UPDATE credit_account_report SET age = '0', status =  '2', payment_date =  now(), updated_at = NOW() WHERE id =  '" . $this->db->escape_str((int)$car_id) . "'");
			
			$query = $this->db->query("INSERT INTO credit_account_report SET node =  '" . $car_id . "', trans_id =  '" . $new_trans_id . "', avl_bal =  '" . $current_amt . "', debit =  0, credit =  '" . $credit_amt . "', trans_type =  'credit', remarks = 'Amount refunded of order id #". $c_query->invoice_no ."', user_id =  '" . $this->db->escape_str((int)$uid) . "', status =  '2', updated_at = now(), payment_date =  now()");
		}
		return $query;
	}
	
	function updateCreditStatus($o_id){
		if($o_id > 0){
			$c_query = $this->db->query("SELECT car.id, car.user_id FROM credit_account_report car WHERE car.order_id = '" . $this->db->escape_str($o_id) . "' AND car.node = '0'")->row();
			$account_detail = $this->db->query("SELECT credit_avilable, account_no, credit_days FROM credit_account WHERE user_id = '" . (int)$c_query->user_id . "'")->row();
			$current_date = strtotime(CURRENT_TIME);
			$delivery_date = date('Y-m-d', $current_date);
			$car_id = $c_query->id;

			$credit_days = $account_detail->credit_days;
			$date_final = strtotime("+". $credit_days ." day", $current_date);
			$overdue_date = date('Y-m-d', $date_final);
			//print_r($c_query);exit();
			$query = $this->db->query("UPDATE credit_account_report SET overdue_date = '". $overdue_date ."', is_delivered =  '1', delivery_date =  '". $delivery_date ."', updated_at = NOW() WHERE id =  '" . $this->db->escape_str((int)$car_id) . "'");
		}
		return $query;
	}
	
	function wallet_refund($uid, $wallet_amount, $remarks){
		if($wallet_amount > 0){
			$query = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$uid . "'")->row();
			$wallet_amt = $query->wallet;
			$current_amt = $wallet_amt + $wallet_amount;
			$this->db->query("UPDATE customer SET wallet =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$uid . "'");
			$this->db->query("INSERT INTO wallet_report SET user_id =  '" . $uid . "', amount =  '" . $wallet_amount . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = now()");
		}
		return true;
	}
	
	function reward_refund($uid, $rewards_point, $remarks){
		if($rewards_point > 0){
			$query = $this->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$uid . "'")->row();
			$wallet_amt = $query->wallet;
			$current_amt = $wallet_amt + $rewards_point;
			$this->db->query("UPDATE customer SET rewards =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$uid . "'");
			$this->db->query("INSERT INTO rewards_report SET user_id =  '" . $uid . "', amount =  '" . $rewards_point . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = now()");
		}
		return true;
	}

	/*
	function createWalletReport($id,$refund_id, $status){
		$query = $this->db->query("INSERT INTO wallet_report SET user_id =  '" . $uid . "', amount =  '" . $uid . "', trans_type =  '" . $uid . "', remarks =  '" . $uid . "', order_id =  '" . $uid . "', modified = NOW() WHERE id = '" . (int)$uid . "'");
		return $query;
	}
	*/
	function refund($id,$refund_id, $status){
		$query = $this->db->query("UPDATE `orders` SET refund_id = '" . (int)$refund_id . "', order_status_id = '" . (int)$status . "', date_modified = NOW() WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_orders_by_dboy($id, $status){
	    $query = "SELECT * FROM orders WHERE delivery_boy = '" . (int)$id . "'";
        if (isset($status)) {
            $query .= " AND `order_status_id` = '" . (int)$status . "'";
        }
        if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$query .= " AND `date_modified` >= '".date("Y-m-d", strtotime($this->input->get('from')))."' AND date_modified <= '".$d_to."'";
			}
		}
        $query .= " ORDER BY date_modified DESC";
        $result = $this->db->query($query);
		return $result->result();
	}

	function get_orders_by_dboy1($id){
		$query = "SELECT * FROM orders WHERE delivery_boy = '" . (int)$id . "'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$query .= " AND `date_modified` >= '".date("Y-m-d", strtotime($this->input->get('from')))."' AND date_modified <= '".$d_to."'";
			}
		}
        $query .= " ORDER BY date_modified DESC";
        $result = $this->db->query($query);
		return $result->result();
	}
	
	function get_report($from, $to){
		$query = $this->db->query("SELECT o.id, op.order_price, gst_rate, o.promo_code_price FROM `orders` o LEFT JOIN order_product op ON(o.id = op.order_id) WHERE o.order_status_id > 0 AND o.date_added BETWEEN '" . date("Y-m-d", strtotime($from)) . "' AND '" . date("Y-m-d", strtotime($to)) . "'");
		return $query;
	}
	
	function get_timeslots(){
		$query = $this->db->query("SELECT * FROM delivery_time_slots WHERE id != 1");
		return $query->result();
	}
}

