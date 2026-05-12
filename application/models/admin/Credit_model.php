<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_model extends CI_Model{

	function add(){
		$userid = $this->input->post('user_id');
		$account_no = str_pad($userid, 6, 0, STR_PAD_LEFT);
		//$account_no = sprintf("%10005d", $userid);
		//print_r($account_no);exit();
		$this->db->query("INSERT INTO credit_account SET  
		user_id = '" . $this->db->escape_str($this->input->post('user_id')) . "',
		account_no = '" . $account_no . "',
		credit_avilable = '" . $this->db->escape_str($this->input->post('credit_avilable')) . "',
		max_credit_limit = '" . $this->db->escape_str($this->input->post('max_credit_limit')) . "',
		credit_days = '" . (int)$this->input->post('credit_days') . "',
		status = '1', created_at = NOW(), updated_at = NOW()");
		$insert_id = $this->db->insert_id();
		if($insert_id > 0){
			$this->db->query("UPDATE customer SET credit_account = '1', ip = '" . $_SERVER['REMOTE_ADDR'] . "', modified = NOW() WHERE id = '" . (int)$this->input->post('user_id') . "'");
		}
		return $insert_id;
	}
	
	function updateMaxlimit(){
	    if($this->input->post('max_credit_limit') > 0){
			$c_query = $this->db->query("SELECT credit_avilable FROM credit_account WHERE id = '" . $this->db->escape_str((int)$this->input->post('id')) . "'")->row();
			$credit_amt = $c_query->credit_avilable;
			$diff_maxlimit = $this->input->post('max_credit_limit') - $this->input->post('old_credit_limit');
			$current_amt = $credit_amt + $diff_maxlimit;
			$query = $this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', max_credit_limit = '" . $this->db->escape_str($this->input->post('max_credit_limit')) . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		}
		return $query;
	}
	
	function updateCredit(){
		$amount = (float)$this->input->post('amount');
		$id = $this->input->post('id');
		$uid = $this->input->post('uid');
		$order_id = 0;
		$trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		if($amount > 0){
			$c_query = $this->db->query("SELECT credit_avilable FROM credit_account WHERE id = '" . $this->db->escape_str((int)$id) . "'")->row();
			$credit_amt = $c_query->credit_avilable;
			$current_amt = $credit_amt + $amount;
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', updated_at = NOW() WHERE id = '" . (int)$id . "'");
			$query = $this->db->query("INSERT INTO credit_account_report SET order_id =  '" . $order_id . "', trans_id =  '" . $trans_id . "', avl_bal =  '" . $current_amt . "', debit =  0, credit =  '" . $amount . "', trans_type =  'credit', remarks = '". $this->db->escape_str($this->input->post('remarks')) ."', user_id =  '" . $this->db->escape_str((int)$uid) . "'");
		}
		return $query;
	}
	
	function dateDifference($start_date, $end_date)
	{
		// calulating the difference in timestamps 
		$diff = strtotime($start_date) - strtotime($end_date);
		// 1 day = 24 hours 
		// 24 * 60 * 60 = 86400 seconds
		return ceil(abs($diff / 86400));
	}
		
	function updateCreditReport(){
		$amount = (float)$this->input->post('credit');
		$id = $this->input->post('id');
		$uid = $this->input->post('user_id');
		$start_date = date("d-m-Y", strtotime($this->input->post('report_date')));
		$end_date = date("d-m-Y", strtotime($this->input->post('payment_date')));
		$age = $this->dateDifference($start_date, $end_date);
		$new_trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		//print_r($age);exit();
		if($amount > 0){
			$c_query = $this->db->query("SELECT credit_avilable FROM credit_account WHERE user_id = '" . $this->db->escape_str((int)$uid) . "'")->row();
			$car_query = $this->db->query("SELECT * FROM credit_account_report WHERE id = '" . $this->db->escape_str((int)$id) . "'")->row();
			$prev_credit = $car_query->credit;
			$credit_avl = $c_query->credit_avilable + $amount;
			$running_bal = $car_query->running_bal;
			$avl_bal = $car_query->avl_bal - ($running_bal + $amount);
			$final_amount = $running_bal + $amount;
			//print_r($current_amt);exit();
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $credit_avl . "', updated_at = NOW() WHERE user_id = '" . (int)$uid . "'");
			$this->db->trans_start();
			$this->db->query("INSERT INTO credit_account_report SET node =  '" . $this->db->escape_str((int)$id) . "', order_id =  '" . $car_query->order_id . "', invoice_no =  '', trans_id =  '" . $car_query->trans_id . "', account_no =  '" . $car_query->account_no . "', avl_bal =  '" . $avl_bal . "', credit =  '" . $amount . "', trans_type =  'credit', trnx_for =  'PRV', po_no =  '" . $car_query->invoice_no . "', user_id =  '" . (int)$car_query->user_id . "', remarks = '". $this->db->escape_str($this->input->post('remarks')) ."', age = '". $this->db->escape_str($age) ."', status =  '". $this->db->escape_str($this->input->post('status')) ."',  payment_date =  '". $this->input->post('payment_date') ."', created_at = NOW()");
			$lastId = $this->db->insert_id();
			$this->db->query("UPDATE credit_account_report SET invoice_no =  'PRV-" . $lastId . "', updated_at = NOW() WHERE id =  '" . $this->db->escape_str((int)$lastId) . "'");
			$this->db->trans_complete();
			$query = $this->db->query("UPDATE credit_account_report SET running_bal =  '" . $final_amount . "', age = '". $this->db->escape_str($age) ."', status =  '". $this->db->escape_str($this->input->post('status')) ."',  payment_date =  '". $this->input->post('payment_date') ."', updated_at = NOW() WHERE id =  '" . $this->db->escape_str((int)$id) . "'");
		}
		return $query;
	}
	
	function make_query($keyword,$status){
		$a = "SELECT ca.*, c.name, c.mobile, c.company_name, c.credit_account as account_status  FROM  credit_account ca JOIN customer c ON (ca.user_id = c.id)";
		if($keyword){
			$a .= " AND (c.company_name LIKE '%".$keyword."%' OR ca.account_no LIKE '%".$keyword."%')";
		}
		if($status){
			if($status == 'notopen'){
				$a .= " AND c.credit_account = '0'";
			}elseif($status == 'inactive'){
				$a .= " AND c.credit_account = '1'";
			}elseif($status == 'active'){
				$a .= " AND c.credit_account = '2'";
			}elseif($status == 'suspended'){
				$a .= " AND c.credit_account = '3'";
			}
		}
		return $a;
	}
	  
	function get_list($keyword,$status){
		$a = $this->make_query($keyword,$status);
		if(isset($_POST["search"]["value"])){
			$a .= " AND name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY created DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($keyword,$status){
	   $a = $this->make_query($keyword,$status);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
	
	function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('credit_account');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM credit_account WHERE admin_id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	function get_credit_by_id($id){
		$query = $this->db->query("SELECT ca.*, c.id as uid, c.name, c.company_name, c.mobile, c.credit_account as account_status  FROM  credit_account ca JOIN customer c ON (ca.user_id = c.id) WHERE ca.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_credit_by_uid($id){
		$query = $this->db->query("SELECT * FROM credit_account WHERE user_id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function update_credit_account($id){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE customer SET credit_account = '" . $this->db->escape_str($this->input->post('credit_status')) . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', modified = NOW() WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function make_report_query($id,$type){
		$a = "SELECT * FROM credit_account_report WHERE user_id = '". (int)$id ."' AND trans_type = '". $type ."'";
		$query = $this->db->query($a); 
		return $query;
	}
	
	function get_report_by_uid($id){
		$query = $this->db->query("SELECT * FROM credit_account_report WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function get_customers(){
		$query = $this->db->query("SELECT id, name, mobile, email, company_name FROM customer where status = '1' AND role_id = '2'")->result();
		return $query;
	}

	//SELECT ca.*, c.id as uid, c.name, c.company_name, c.mobile, c.credit_account as account_status  FROM  credit_account ca JOIN customer c ON (ca.user_id = c.id) WHERE ca.id = '" . (int)$id . "'"
	function get_credit_report(){
		$sql = "SELECT car.* FROM credit_account_report car WHERE trans_type = 'credit'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND car.created_at >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND car.created_at <='" . $d_to . "'";
			}
		}
		
		if($this->input->get('nameFilter')) {
			$user_name = $this->input->get('nameFilter');
            if($user_name != ''){
                $sql .= " AND car.user_id = '" . $user_name . "'";
            }
        }
        
        $sql .= " ORDER BY car.id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_debit_report(){
		$sql = "SELECT car.* FROM credit_account_report car WHERE trans_type = 'debit' AND is_delivered = '1'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND car.created_at >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND car.created_at <='" . $d_to . "'";
			}
		}
		
		if($this->input->get('nameFilter')) {
			$user_name = $this->input->get('nameFilter');
            if($user_name != ''){
                $sql .= " AND car.user_id = '" . $user_name . "'";
            }
        }
        
        $sql .= " ORDER BY car.id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function get_debit_age($uid){
		$data['balance'] = $this->db->query("SELECT sum(car.debit) as debit_bal FROM credit_account_report car WHERE user_id = '". $uid ."' AND trans_type = 'debit' AND is_delivered = '1'")->row();
		$data['day_30'] = $this->db->query("SELECT sum(car.debit) as total_debit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 30 DAY) AND user_id = '". $uid ."' AND trans_type = 'debit' AND is_delivered = '1'")->row();
		$data['day_90'] = $this->db->query("SELECT sum(car.debit) as total_debit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 90 DAY) AND user_id = '". $uid ."' AND trans_type = 'debit' AND is_delivered = '1'")->row();
		$data['day_180'] = $this->db->query("SELECT sum(car.debit) as total_debit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 180 DAY) AND user_id = '". $uid ."' AND trans_type = 'debit' AND is_delivered = '1'")->row();
		$data['day_270'] = $this->db->query("SELECT sum(car.debit) as total_debit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 270 DAY) AND user_id = '". $uid ."' AND trans_type = 'debit' AND is_delivered = '1'")->row();
		$data['day_365'] = $this->db->query("SELECT sum(car.debit) as total_debit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 365 DAY) AND user_id = '". $uid ."' AND trans_type = 'debit' AND is_delivered = '1'")->row();
		return $data;
	}

	function get_credit_age($uid){
		$data['balance'] = $this->db->query("SELECT sum(car.credit) as credit_bal FROM credit_account_report car WHERE user_id = '". $uid ."' AND trans_type = 'credit'")->row();
		$data['day_30'] = $this->db->query("SELECT sum(car.credit) as total_credit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 30 DAY) AND user_id = '". $uid ."' AND trans_type = 'credit'")->row();
		$data['day_90'] = $this->db->query("SELECT sum(car.credit) as total_credit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 90 DAY) AND user_id = '". $uid ."' AND trans_type = 'credit'")->row();
		$data['day_180'] = $this->db->query("SELECT sum(car.credit) as total_credit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 180 DAY) AND user_id = '". $uid ."' AND trans_type = 'credit'")->row();
		$data['day_270'] = $this->db->query("SELECT sum(car.credit) as total_credit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 270 DAY) AND user_id = '". $uid ."' AND trans_type = 'credit'")->row();
		$data['day_365'] = $this->db->query("SELECT sum(car.credit) as total_credit FROM credit_account_report car WHERE car.created_at >= DATE(NOW() - INTERVAL 365 DAY) AND user_id = '". $uid ."' AND trans_type = 'credit'")->row();
		return $data;
	}

	function current_debit_balance($uid){
		$sql = "SELECT sum(car.debit) as current_debit_bal FROM credit_account_report car WHERE trans_type = 'debit' AND car.user_id = '" . $uid . "' AND is_delivered = '1'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND car.created_at >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND car.created_at <='" . $d_to . "'";
			}
		}
		
		$query = $this->db->query($sql);
		return $query->row();
	}

	function current_credit_balance($uid){
		$sql = "SELECT sum(car.credit) as current_credit_bal FROM credit_account_report car WHERE trans_type = 'credit' AND car.user_id = '" . $uid . "'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND car.created_at >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND car.created_at <='" . $d_to . "'";
			}
		}
		
		$query = $this->db->query($sql);
		return $query->row();
	}
	/*
	function get_report_list($id){
		$a = $this->make_report_query();
		$a .= " AND user_id = '". (int)$id ."'";
		$a .= " ORDER BY created_at DESC";
	
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_report_filtered_data($id){
	   $a = "SELECT * FROM credit_account_report WHERE user_id = '". (int)$id ."'";
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
	
	function get_all_report_data($id){
	   $this->db->select("*");  
	   $this->db->from("credit_account_report"); 
	   $this->db->where("user_id", $id); 
	   return $this->db->count_all_results();
    }
	*/
}
