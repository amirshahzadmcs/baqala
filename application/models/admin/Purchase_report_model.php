<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_report_model extends CI_Model{

	
	function make_vendor_query(){
		$a = "SELECT v.*, (select count(po.id) from purchase_order po where po.vendor_id = v.id) as total_orders, (select sum(po.total) from purchase_order po where po.vendor_id = v.id) as total_order_value FROM vendors v WHERE 1=1 ORDER BY v.vendor_name asc";
		return $a;
	}
	
	function get_vendor_list(){
		$a = $this->make_vendor_query();      
        $query = $this->db->query($a);  
        return $query->result();  
    }

	public function get_grv_list($supplier_id,$start_date,$end_date)
	{
		$a = "SELECT grv.*,v.vat_no as vat_no FROM grv LEFT JOIN vendors as v ON v.vendor_name = grv.vendor WHERE 1=1";
		if (($supplier_id != '')) {
			$a .= ' AND grv.vendor = "'.$supplier_id.'"';
		}
		if (($start_date != '') && ($end_date != '')) {
			$a .= ' AND grv.invoice_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
		}
		
		$query = $this->db->query($a);
		return $query->result();
	}

	public function get_filter_vendor_list($city,$country,$group_by)
	{
		$a = "SELECT v.*, (select count(po.id) from purchase_order po where po.vendor_id = v.id) as total_orders, (select sum(po.total) from purchase_order po where po.vendor_id = v.id) as total_order_value FROM vendors v WHERE 1=1";
		if (($city != '')) {
			$a .= ' AND v.city = "'.$city.'"';
		}
		if (($country != '')) {
			$a .= ' AND v.country = "'.$country.'"';
		}
        $query = $this->db->query($a);
        return $query->result();
	}

	public function purchase_orders($supplier,$start_date,$end_date,$group_by,$order_by)
	{
		$a = "SELECT po.*, pi.item_description as description, pi.id as pid, pi.item_unit as units, pi.unit_price, pi.item_total as sub_total, pi.vat_price as vat, pi.amt_incl_vat as total, pi.created_at as date, pi.prod_id FROM purchase_order po LEFT JOIN purchase_items as pi ON pi.p_order_id = po.id WHERE 1=1";
		if (($supplier != '')) {
			if($supplier == '1'){
				$a .= ' ORDER BY pi.id DESC';
			} else {
				$a .= ' AND po.vendor_name = "'.$supplier.'"';
			}
		}
		if (($start_date != '') && ($end_date != '')) {
			$a .= ' AND pi.created_at BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
		}
		if ($group_by != '') {
			if ($group_by == 'Yearly') {
				$cur = date('Y-m-d');
				$dated = date('Y-m-d', strtotime('-1 year'));
				$a .= ' AND pi.created_at BETWEEN "'.$dated.'" AND "'.$cur.'"';
			}
			if ($group_by == 'Monthly') {
				$cur = date('Y-m-d');
				$dated = date('Y-m-d', strtotime('-31 days'));
				$a .= ' AND pi.created_at BETWEEN "'.$dated.'" AND "'.$cur.'"';
			}
			if ($group_by == 'Weekly') {
				$cur = date('Y-m-d');
				$dated = date('Y-m-d', strtotime('-7 days'));
				$a .= ' AND pi.created_at BETWEEN "'.$dated.'" AND "'.$cur.'"';
			}
			if ($group_by == 'Daily') {
				$cur = date('Y-m-d');
				// $dated = date('Y-m-d', strtotime('-7 days'));
				$a .= ' AND pi.created_at = "'.$cur.'"';
			}
		}
		if (($order_by != '')) {
			if ($order_by == 'dd') {
				$a .= ' ORDER BY pi.created_at DESC';
			}
			if ($order_by == 'da') {
				$a .= ' ORDER BY pi.created_at ASC';
			}
			if ($order_by == 'na') {
				$a .= ' ORDER BY pi.id ASC';
			}
			if ($order_by == 'nd') {
				$a .= ' ORDER BY pi.id DESC';
			}
		}
		
		$query = $this->db->query($a);
        return $query->result();
	}
	  
}
