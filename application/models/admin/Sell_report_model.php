<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell_report_model extends CI_Model{
	
	function get_orders(){
		$sql = "SELECT * FROM orders WHERE order_status_id = '6'";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `date_modified` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `date_modified` <='" . $d_to . "'";
			}
		}
		
		if($this->input->get('nameFilter')) {
			$cusomer_name = $this->input->get('nameFilter');
            if($cusomer_name != ''){
                $sql .= " AND customer_id = '" . $cusomer_name . "'";
            }
        }
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_customer(){
		$query = $this->db->query("SELECT id,name,email,mobile,vat_no,role_id FROM customer WHERE 1=1");
		return $query->result();
	}
}
