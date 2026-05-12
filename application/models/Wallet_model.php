<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet_model extends CI_Model{
		
	function get_wallet_report(){
		return true;
	}
	
	function wallet_debit($amount){
		if($amount > 0){
			$query = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->customer->getId() . "'")->row();
			$rewards_amt = $query->wallet;
			$current_amt = $rewards_amt - $amount;
			$this->db->query("UPDATE customer SET wallet =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$this->customer->getId() . "'");
		}
		return true;
	}
	
	function wallet_credit($amount, $remarks){
		if($amount > 0){
			$query = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->customer->getId() . "'")->row();
			$wallet_amt = $query->wallet;
			$current_amt = $wallet_amt + $amount;
			$this->db->query("UPDATE customer SET wallet =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$this->customer->getId() . "'");
			
			$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$this->customer->getId() . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = NOW()");
		}
		return true;
	}
	

}
