<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model{
	/*
	function get_po_report(){
		$query = $this->db->query("SELECT g.po_id, g.grv_no, g.grv_status, g.created_at, g.po_no, po.vendor_id, po.vendor_name, po.po_terms, po.sub_total, po.sale_tax, po.sale_tax_amt, po.shipping_handling, po.total, po.total_qty, v.vat_no FROM grv g LEFT JOIN purchase_order po ON (po.id = g.po_id) LEFT JOIN vendors v ON (v.id = po.vendor_id) WHERE 1=1")->result();
		return $query;
	}
	*/
	function get_po_report(){
		$sql = "SELECT g.id, g.po_id, g.grv_no, g.grv_status, g.created_at, g.po_no, g.sup_invoice_no, g.invoice_date, g.vendor, po.vendor_id, po.vendor_name, po.po_terms, po.sub_total, po.sale_tax, po.sale_tax_amt, po.shipping_handling, po.total, po.total_qty, v.vat_no FROM grv g LEFT JOIN purchase_order po ON (po.id = g.po_id) LEFT JOIN vendors v ON (v.id = po.vendor_id) WHERE 1=1";
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND g.invoice_date >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND g.invoice_date <='" . $d_to . "'";
			}
		}
		
		if($this->input->get('nameFilter')) {
			$vendor_name = $this->input->get('nameFilter');
            if($vendor_name != ''){
                $sql .= " AND po.vendor_id = '" . $vendor_name . "'";
            }
        }
        
        $sql .= " ORDER BY g.id ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_vendors(){
		$query = $this->db->query("SELECT * FROM vendors WHERE 1=1");
		return $query->result();
	}
}
