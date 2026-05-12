<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{
	
	public function otp_timeout($email){
		$current_time = CURRENT_TIME;
		$query = $this->db->query("SELECT id, expired_at, email FROM otp_verification WHERE email = '" . $email . "' ORDER BY id DESC LIMIT 1")->row();
		return $query;
	}
	
	function resend_otp($otp, $email){
		$this->load->helper('string');
		$created_at = CURRENT_TIME;
		//$current_time = strtotime(CURRENT_TIME);
		$expired_at = date('Y-m-d H:i:s', strtotime($created_at. ' +3 minute'));
		$query = $this->db->query("INSERT INTO otp_verification SET otp = '" . $otp . "', email = '" . $email . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', created_at = '" . $created_at . "', expired_at = '" . $expired_at . "'");
		return $query;
	}

	public function otp_verify($email,$otp){
		$query = $this->db->query("SELECT id, email FROM otp_verification WHERE email = '" . $email . "' AND otp = '" . $otp . "' ORDER BY id DESC LIMIT 1");
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	function basic_registration($email,$hashpassword){
		$this->load->helper('string');
		$created_at = CURRENT_TIME;
		$this->db->trans_start();
		$query = $this->db->query("INSERT INTO delivery_vehicles SET email = '" . $email . "', password = '" . $hashpassword . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', created_at = '" . $created_at . "', status = '1', rider_type = '2', application_status = 'unverified'");
		$boy_id = $this->db->insert_id();
		if($query){
		    $cust_account_no = $boy_id + 100;
			$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
			$this->db->query("UPDATE delivery_vehicles SET driver_id = '" . $final_account_no . "' WHERE id = '" . (int)$boy_id . "'");
			$this->db->query("INSERT INTO delivery_boy_documents SET deliveryboy_id = '" . (int)$boy_id . "', created_at = '" . $created_at . "', status = '0'");
			$this->db->query("INSERT INTO deliveryvehicle_salary SET deliveryboy_id = '" . (int)$boy_id . "', created_at = '" . $created_at . "'");
		}
		$this->db->trans_complete();
		return $query;
	}

	public function profile(){
		$query = $this->db->query("SELECT * FROM delivery_vehicles WHERE id = '" . (int)$this->deliveryboy->getId() . "'")->row();
		return $query;
	}
}
