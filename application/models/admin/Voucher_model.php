<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Voucher_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO sim_recharge_vouchers SET sim_network = '" . $this->input->post('sim_network') . "', total_vouchers = '" . $this->input->post('total_vouchers') . "', voucher_value = '" . $this->input->post('voucher_value') . "', voucher_vat = '" . $this->input->post('voucher_vat') . "', voucher_total = '" . $this->input->post('voucher_total') . "', purchase_date = '" . $this->input->post('purchase_date') . "', expiry_date = '" . $this->input->post('expiry_date') . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}

	function edit(){
		$query = $this->db->query("UPDATE sim_recharge_vouchers SET sim_network = '" . $this->input->post('sim_network') . "', total_vouchers = '" . $this->input->post('total_vouchers') . "', voucher_value = '" . $this->input->post('voucher_value') . "', voucher_vat = '" . $this->input->post('voucher_vat') . "', voucher_total = '" . $this->input->post('voucher_total') . "', purchase_date = '" . $this->input->post('purchase_date') . "', expiry_date = '" . $this->input->post('expiry_date') . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM sim_recharge_vouchers WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT sim_recharge_vouchers.*, master_network.network_name FROM sim_recharge_vouchers JOIN master_network ON (sim_recharge_vouchers.sim_network = master_network.id) WHERE sim_recharge_vouchers.id = '" . $id . "'");
		return $query;
	}

	function get_group_vouchers($id){
		$query = $this->db->query("SELECT srvl.*, sc.mobile as mobile_no, pmi.alloted_user, me.emp_no, IF (pmi.alloted_user > 0, me.full_name, 'NA') emp_full_name, mv.vehicle_no FROM sim_recharge_vouchers_list srvl LEFT JOIN sim_card sc ON (srvl.sim_id = sc.id) LEFT JOIN prepaid_mobile_invoice pmi ON (srvl.invoice_id = pmi.id) LEFT JOIN master_employee me ON (pmi.alloted_user = me.id) LEFT JOIN master_vehicles mv ON (pmi.alloted_vehicle = mv.id) WHERE srvl.group_id = '" . $id . "'");
		return $query;
	}

	function getNetworkWiseUnusedVouchers($provider_id){
		$query = $this->db->query("SELECT srvl.*, srv.id as main_id, srv.sim_network FROM sim_recharge_vouchers_list srvl LEFT JOIN sim_recharge_vouchers srv ON (srvl.group_id = srv.id) WHERE srv.sim_network = '" . $provider_id . "' AND srvl.status = '0'");
		return $query;
	}

	function getVouchersDetail($voucher_id){
		$query = $this->db->query("SELECT srvl.*, srv.id as main_id, srv.sim_network, srv.voucher_value as unit_price, srv.voucher_vat as unit_vat FROM sim_recharge_vouchers_list srvl LEFT JOIN sim_recharge_vouchers srv ON (srvl.group_id = srv.id) WHERE srvl.id = '" . $voucher_id . "'");
		return $query->row();
	}
	
	function make_query($network,$status,$purchase_from,$purchase_to,$startDate,$endDate,$keyword){
		$a = "SELECT sim_recharge_vouchers.*, master_network.network_name FROM sim_recharge_vouchers LEFT JOIN master_network ON (sim_recharge_vouchers.sim_network = master_network.id) WHERE 1=1";
		if($network){
			$a .= " AND sim_recharge_vouchers.sim_network = '" . $network . "'";
		}
		if($status){
			if($status == 'new'){
				$a .= " AND sim_recharge_vouchers.status = '0'";
			}
			if($status == 'used'){
				$a .= " AND sim_recharge_vouchers.status = '1'";
			}
			if($status == 'expired'){
				$a .= " AND sim_recharge_vouchers.status = '2'";
			}
		}
		if ($purchase_from && $purchase_to) {
			$purchase_start = date('Y-m-d', strtotime($purchase_from));
			$purchase_end = date('Y-m-d', strtotime($purchase_to));
			$a .= " AND sim_recharge_vouchers.purchase_date BETWEEN '".$purchase_start."' AND '".$purchase_end."'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND sim_recharge_vouchers.used BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		// if($keyword){
		// 	$a .= " AND (serial_no LIKE '%".$keyword."%')";
		// }
		return $a;
	}
	
	function get_list($network,$status,$purchase_from,$purchase_to,$startDate,$endDate,$keyword){
		$a = $this->make_query($network,$status,$purchase_from,$purchase_to,$startDate,$endDate,$keyword);
		$a .= " ORDER BY sim_recharge_vouchers.created_at DESC";		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($network,$status,$purchase_from,$purchase_to,$startDate,$endDate,$keyword){
	   $a = $this->make_query($network,$status,$purchase_from,$purchase_to,$startDate,$endDate,$keyword);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('sim_recharge_vouchers');  
	   return $this->db->count_all_results();
    }

	function check_duplicate_voucher($id, $serial_no){
		$this->db->select("*");  
		$this->db->from('sim_recharge_vouchers'); 
		$this->db->where('id !=',$id);
		//$this->db->where('serial_number =',$serial_no);
		return $this->db->count_all_results();  
	}
	
	function add_bulk($data = array()){
		$this->db->query("INSERT INTO sim_recharge_vouchers SET sim_network = '" . $this->input->post('sim_network') . "', serial_number = '" . $this->input->post('serial_number') . "', voucher_value = '" . $this->input->post('voucher_value') . "', voucher_vat = '" . $this->input->post('voucher_vat') . "', voucher_total = '" . $this->input->post('voucher_total') . "', expiry_date = '" . $this->input->post('expiry_date') . "', status = '" . $this->input->post('status') . "', created_at = NOW(), updated_at = NOW()");
		return true;
	}
	
	public function setStatusEnable() {
	    $query = $this->db->query("UPDATE sim_recharge_vouchers SET status = '1', updated_at = NOW() WHERE id >= '" . $this->input->post('from') . "' AND id <='" . $this->input->post('to')  . "'");
	    return $query;
	}
	
	public function setStatusDisable() {
	    $query = $this->db->query("UPDATE sim_recharge_vouchers SET status = '0', updated_at = NOW() WHERE id >= '" . $this->input->post('from') . "' AND id <='" . $this->input->post('to')  . "'");
	    return $query;
	}
	
	function total_voucher(){
		$this->db->select("*");  
		$this->db->from('sim_recharge_vouchers');  
		return $this->db->count_all_results();  
	} 
	
	function active_voucher(){
		$this->db->select("*");  
		$this->db->from('sim_recharge_vouchers');
		$this->db->where('status','0');
		return $this->db->count_all_results();  
	}
	
	function used_voucher(){
		$this->db->select("*");  
		$this->db->from('sim_recharge_vouchers');
		$this->db->where('status','1');
		return $this->db->count_all_results();  
	} 
	
	function expired_voucher(){
		$this->db->select("*");  
		$this->db->from('sim_recharge_vouchers'); 
		$this->db->where('status','2');
		return $this->db->count_all_results();  
	} 
	
	// function duplicate_voucher(){
	// 	$query = $this->db->query("SELECT serial_number, COUNT(serial_number) FROM sim_recharge_vouchers GROUP BY serial_number HAVING COUNT(serial_number) > 1")->result_array();
	// 	return $query;  
	// }
	
	/*----- Recharge Report -------*
	function make_report_query(){
		$a = "SELECT rr.*, rv.s_no, rv.serial_number, rv.expiry_date, rv.voucher_value, rv.is_used, c.name, c.mobile, c.email FROM sim_recharge_logs rr LEFT JOIN sim_recharge_vouchers rv ON(rr.id = rv.id) LEFT JOIN customer c ON(c.id = rr.user_id)";
	   return $a;
	}
	  
	function get_report_list(){
		$a = $this->make_report_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND c.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY c.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY c.created DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_report_filtered_data(){
	   $a = $this->make_report_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_report_data(){
	   $this->db->select("*");  
	   $this->db->from('sim_recharge_logs');  
	   return $this->db->count_all_results();
    }
	*/
}

