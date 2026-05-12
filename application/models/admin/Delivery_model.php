<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_model extends CI_Model{
	
	function add($iqama,$dl_image){
		$query = $this->db->query("INSERT INTO deliveryboy SET name = '" . $this->db->escape_str($this->input->post('name')) . "', partner_id = '" . $this->db->escape_str((int)$this->input->post('partner_id')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "', van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', van_color = '" . $this->db->escape_str($this->input->post('van_color')) . "', van_model = '" . $this->db->escape_str($this->input->post('van_model')) . "', address = '" . $this->input->post('address') . "',city = '" . $this->db->escape_str($this->input->post('city')) . "',state = '" . $this->db->escape_str($this->input->post('state')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "',delivery_charge = '" . $this->db->escape_str($this->input->post('delivery_charge')) . "', iban = '" . $this->db->escape_str($this->input->post('iban')) . "', bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "',stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "',dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "',dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "', iqama = '" . $this->db->escape_str($iqama) . "', dl_image = '" . $this->db->escape_str($dl_image) . "', password = '" . md5($this->input->post('password')) . "', ip = '" . $this->input->ip_address() . "', status = '" . (int)$this->input->post('status') . "'");
		return $query;
	}
	
	function edit($iqama,$dl_image){
		$query = $this->db->query("UPDATE deliveryboy SET name = '" . $this->db->escape_str($this->input->post('name')) . "', partner_id = '" . $this->db->escape_str((int)$this->input->post('partner_id')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "', van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', van_color = '" . $this->db->escape_str($this->input->post('van_color')) . "', van_model = '" . $this->db->escape_str($this->input->post('van_model')) . "', address = '" . $this->input->post('address') . "',city = '" . $this->db->escape_str($this->input->post('city')) . "',state = '" . $this->db->escape_str($this->input->post('state')) . "', country = '" . $this->db->escape_str($this->input->post('country')) . "',delivery_charge = '" . $this->db->escape_str($this->input->post('delivery_charge')) . "', iban = '" . $this->db->escape_str($this->input->post('iban')) . "', bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "',stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "',dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "',dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "',iqama = '" . $this->db->escape_str($iqama) . "', dl_image = '" . $this->db->escape_str($dl_image) . "', status = '" . (int)$this->input->post('status') . "', updated_at = now(), ip = '" . $this->input->ip_address() . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function manage(){
		$query = $this->db->query("UPDATE deliveryboy SET modified = NOW(), status = '" . (int)$this->input->get('status') . "', ip = '" . $this->input->ip_address() . "' WHERE id = '" . (int)$this->input->get('id') . "'");
		return $query;
	}
	
	function change_password(){
		//echo $this->input->post('status');exit();
		$new_password = md5($this->input->post('password'));
		$query = $this->db->query("UPDATE deliveryboy SET password = '" . $new_password . "', updated_at = NOW(), ip = '" . $this->input->ip_address() . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_deliverboy($id){
		$query = $this->db->query("SELECT deliveryboy.*, delivery_partner.cname, count(orders.id) as count_order FROM deliveryboy LEFT JOIN delivery_partner ON (delivery_partner.id = deliveryboy.partner_id) LEFT JOIN orders ON (deliveryboy.id = orders.delivery_boy) WHERE deliveryboy.id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_deliverboy_mobile($id){
		$query = $this->db->query("SELECT mobile FROM deliveryboy WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_address($id){
		$query = $this->db->query("SELECT * FROM address WHERE customer_id = '" . (int)$id . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM deliveryboy WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT deliveryboy.*, count(orders.id) as count_order FROM deliveryboy LEFT JOIN orders ON (deliveryboy.id = orders.delivery_boy) WHERE 1 = 1";
	   return $a;
	}
	  
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND deliveryboy.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY deliveryboy.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY deliveryboy.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
	function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
	}

	function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('deliveryboy');  
	   return $this->db->count_all_results();  
	}
	
	function get_partner_list(){
		$query = $this->db->query("SELECT id,cname FROM delivery_partner ");
		return $query->result();
	}
	
	function active_dboy_list(){
		$query = $this->db->query("SELECT id, name, mobile FROM deliveryboy WHERE status = '1'");
		return $query->result();
	}
	
	function all_dboy_list(){
		$query = $this->db->query("SELECT id, name, mobile FROM deliveryboy WHERE 1 = 1");
		return $query->result();
	}
	
	function get_earnings($id){
		$query = $this->db->query("SELECT * FROM delivery_payments WHERE deliveryboy_id = '" . (int)$id . "'");
		return $query->result();
	}
	
	/*---- Wallet Report -----*/
	function get_wallet_report($dbid){
		$sql = "SELECT * FROM `dboy_wallet_report` WHERE `dboy_id` = '" . (int)$dbid . "'";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `created_at` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `created_at` <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_all_report($dbid){
	   $this->db->select("*");  
	   $this->db->from('dboy_wallet_report');  
	   $this->db->where('dboy_id', $dbid);  
	   return $this->db->count_all_results();  
	}
	
	function updateWallet(){
		$wallet = $this->db->query("SELECT wallet FROM deliveryboy WHERE id = '" . (int)$this->input->post('dbid') . "'")->row();
		$rec_amt = $this->input->post('rec_amt');
		$trans_id = strtoupper('A'.uniqid());
		$amount = $this->input->post('wallet');
		$remarks = $this->input->post('remarks');
		$remarks2 = 'Credit top up: Admin';
		$newWallet = $wallet->wallet + $amount;
		$query = $this->db->query("UPDATE deliveryboy SET wallet = '" . $newWallet . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('dbid') . "'");
		
		$this->db->query("INSERT INTO dboy_wallet_report SET dboy_id =  '" . (int)$this->input->post('dbid') . "', amount =  '" . $amount . "', transaction_id =  '" . $trans_id . "', rec_amt = '" . $rec_amt . "', trans_type =  'credit', remarks =  '" . $remarks2 . "', updated_at = NOW()");
		
		return $query;
	}

	function getCreditWallet($dbid){
		$this->db->select('(SELECT SUM(dbr.amount) FROM dboy_wallet_report dbr WHERE dbr.dboy_id='. $dbid .' AND dbr.trans_type= "credit") AS amount_reveived', FALSE);
		$query = $this->db->get();
		return $query->row();
	}
	
	function getDebitWallet($dbid){
		$this->db->select('(SELECT SUM(dbr.amount) FROM dboy_wallet_report dbr WHERE dbr.dboy_id='. $dbid .' AND dbr.trans_type= "debit") AS amount_paid', FALSE);
		$query = $this->db->get();
		return $query->row();
	}

	function cities(){
		$query = $this->db->query("SELECT * FROM master_city WHERE status = 1 ORDER BY city_name ASC");
		return $query->result();
	}

	function master_banks(){
		$query = $this->db->query("SELECT * FROM master_bank WHERE deleted = '0' ORDER BY bank_name ASC");
		return $query->result();
	}
}
