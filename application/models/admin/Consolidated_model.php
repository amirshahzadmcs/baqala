<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consolidated_model extends CI_Model{
	
	function get_purchase_report(){
		$sql = "SELECT g.id, g.po_id, g.grv_no, g.grv_status, g.created_at, g.po_no, po.sub_total, po.sale_tax, po.sale_tax_amt, po.shipping_handling, SUM(po.shipping_handling) as total_shipping, SUM(po.sub_total) as total_bef_vat, SUM(po.sale_tax_amt) as total_vat, (round(((SUM(po.shipping_handling) * 100) / 115),2)) as shipping_bef_vat, (round((SUM(po.shipping_handling) - ((SUM(po.shipping_handling) * 100) / 115)),2)) as shipping_vat FROM grv g LEFT JOIN purchase_order po ON (po.id = g.po_id) WHERE 1=1";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND g.invoice_date >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND g.invoice_date <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY g.id ASC";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function get_po_return_report(){
		$sql = "SELECT pr.id, pr.po_id, pr.vendor_id, pr.sub_total, pr.sale_tax, pr.sale_tax_amt, pr.shipping_handling, pr.total, pr.created_at, SUM(pr.shipping_handling) as total_shipping, SUM(pr.sub_total) as total_bef_vat, SUM(pr.sale_tax_amt) as total_vat, (round(((SUM(pr.shipping_handling) * 100) / 115),2)) as shipping_bef_vat, (round((SUM(pr.shipping_handling) - ((SUM(pr.shipping_handling) * 100) / 115)),2)) as shipping_vat FROM purchase_return pr WHERE 1=1";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND pr.created_at >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND pr.created_at <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY pr.id ASC";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function get_cash_sales(){
		$sql = "SELECT sr.id, sr.invoice_prefix, sr.customer_id, sr.total_vat, sr.item_total_price, sr.order_total, sr.shipping_charge, sr.date_added, SUM(sr.shipping_charge) as total_shipping, SUM(sr.total_vat) as total_bef_vat, (round(((SUM(sr.shipping_charge) * 100) / 115),2)) as shipping_bef_vat, (round((SUM(sr.item_total_price) - (SUM(sr.total_vat))),2)) as total_prod_vat, (round((SUM(sr.shipping_charge) - ((SUM(sr.shipping_charge) * 100) / 115)),2)) as shipping_vat FROM orders sr WHERE (sr.payment_method != 'Credit Wallet' OR sr.payment_method != 'Credit')";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND sr.date_added >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND sr.date_added <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY sr.id ASC";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function get_credit_sales(){
		$sql = "SELECT sr.id, sr.invoice_prefix, sr.customer_id, sr.total_vat, sr.item_total_price, sr.order_total, sr.shipping_charge, sr.date_added, SUM(sr.shipping_charge) as total_shipping, SUM(sr.total_vat) as total_bef_vat, (round(((SUM(sr.shipping_charge) * 100) / 115),2)) as shipping_bef_vat, (round((SUM(sr.item_total_price) - (SUM(sr.total_vat))),2)) as total_prod_vat, (round((SUM(sr.shipping_charge) - ((SUM(sr.shipping_charge) * 100) / 115)),2)) as shipping_vat FROM orders sr WHERE (sr.payment_method = 'Credit Wallet' OR sr.payment_method = 'Credit')";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND sr.date_added >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND sr.date_added <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY sr.id ASC";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function get_return_sales(){
		$sql = "SELECT sr.id, sr.order_id, sr.po_number, sr.quotation_no, sr.total_vat, sr.item_total_price, sr.order_total, sr.shipping_charge, sr.created_at, SUM(sr.shipping_charge) as total_shipping, SUM(sr.total_vat) as total_bef_vat, (round(((SUM(sr.shipping_charge) * 100) / 115),2)) as shipping_bef_vat, (round((SUM(sr.item_total_price) - (SUM(sr.total_vat))),2)) as total_prod_vat, (round((SUM(sr.shipping_charge) - ((SUM(sr.shipping_charge) * 100) / 115)),2)) as shipping_vat FROM sales_return sr WHERE 1=1";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND sr.created_at >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND sr.created_at <='" . $d_to . "'";
			}
		}
        
        $sql .= " ORDER BY sr.id ASC";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function get_expenses_list(){
		$sql = "SELECT e.amt_bef_vat, SUM(e.tax) as total_vat, SUM(e.amt_bef_vat) as total_bef_vat, SUM(e.total) as total_aft_vat from expenses_vat_entry e WHERE 1=1";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND e.date >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND e.date <='" . $d_to . "'";
			}
		}
		$sql .= " ORDER BY e.id ASC";       
        $query = $this->db->query($sql);  
        return $query->row();  
    }
	
	
	function get_vendors(){
		$query = $this->db->query("SELECT * FROM vendors WHERE 1=1");
		return $query->result();
	}
}
