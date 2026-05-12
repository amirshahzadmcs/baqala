<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_report_model extends CI_Model{

	
	function make_vendor_query(){
		$a = "SELECT v.*, (select count(po.id) from purchase_order po where po.vendor_id = v.id) as total_orders, (select sum(po.total) from purchase_order po where po.vendor_id = v.id) as total_order_value FROM vendors v WHERE 1=1 ORDER BY v.vendor_name asc";
		return $a;
	}
	
	function get_vendor_list(){
		$a = $this->make_vendor_query();      
        $query = $this->db->query($a);  
        return $query->result();  
    }

	public function get_orders($supplier_id,$start_date,$end_date)
	{
		$a = "SELECT *, TIMESTAMPDIFF(HOUR, '2022-12-30 13:16:55', '2022-12-31 13:13:55') as hour_diff, TIMESTAMPDIFF(MINUTE, '2022-12-30 13:16:55', '2022-12-31 13:13:55') as minute_diff FROM orders WHERE 1=1";
		
		if (($supplier_id != '')) {
			$a .= ' AND grv.vendor = "'.$supplier_id.'"';
		}
		if (($start_date != '') && ($end_date != '')) {
			$a .= ' AND grv.invoice_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
		}
		// print_r($a);die();
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
		// print_r($a);die();
		$query = $this->db->query($a);
        return $query->result();
	}

	public function get_client_list()
	{
		$a = "SELECT id, name, company_name, company_arabic_name from customer WHERE role_id = 2 AND 1=1";
		$query = $this->db->query($a);
		return $query->result();
	}
	
	public function get_supplier_orders($supplier_id,$start_date,$end_date)
	{
		$a = "SELECT *, cus.name as cus_name FROM orders LEFT JOIN customer cus ON (orders.customer_id = cus.id) WHERE order_status_id = '6'";
		// print_r($this->db->query($a)->row());exit();
		if (($supplier_id != '')) {
			$a .= ' AND customer_id = "'.$supplier_id.'"';
		}
		if (($start_date != '') && ($end_date != '')) {
			$a .= ' AND delivery_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
		}
		// print_r($a);die();
		$query = $this->db->query($a);
		return $query->result();
	}
	
	public function get_all_sales($supplier_id,$start_date,$end_date,$category,$brand,$product)
	{
		$a = "SELECT prod.*, delivery_date, invoice_prefix, order_no, cus.name as cus_name, cus.vat_no as c_vat FROM orders LEFT JOIN customer cus ON (orders.customer_id = cus.id) LEFT JOIN order_product prod ON (orders.id = prod.order_id) WHERE order_status_id = '6'";
		// print_r($this->db->query($a)->row());exit();
		if (($supplier_id != '')) {
			$a .= ' AND customer_id = "'.$supplier_id.'"';
		}
		if (($product != '')) {
			$a .= ' AND prod.product_id = "'.$product.'"';
		}
		if (($category != '')) {
			$a .= ' AND prod.category_id = "'.$category.'"';
		}
		if (($brand != '')) {
			$a .= ' AND prod.brand_id = "'.$brand.'"';
		}
		if (($start_date != '') && ($end_date != '')) {
			$a .= ' AND delivery_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"';
		}
		// print_r($a);die();
		$query = $this->db->query($a);
		return $query->result();
	}

	public function get_brand_list()
	{
		$a = "SELECT * FROM master_brands WHERE deleted = '0'";
		$query = $this->db->query($a);
		return $query->result();
	}

	public function get_category_list()
	{
		$data = array();
		$parent_categories = $this->db->query("select id, parent_id, name, arabic_name, status FROM category WHERE parent_id = '0' ORDER BY name");
		foreach($parent_categories->result() as $parent_category){
			$child = array();
			$child_categories = $this->db->query("select id, name, arabic_name, parent_id, status FROM category WHERE parent_id = '" . (int)$parent_category->id . "' ORDER BY name");
			foreach($child_categories->result() as $child_category){
				$sub_child = $this->db->query("select id, arabic_name, name, status FROM category WHERE parent_id = '" . (int)$child_category->id . "' ORDER BY name")->result_array();
				$child[] = array("id" => $child_category->id,
								 "name" => $child_category->name,
								 "arabic_name" => $child_category->arabic_name,
								 "status" => $child_category->status,
								 "child" => $sub_child);
			}
			$data[] = array("id" => $parent_category->id,
						"name" => $parent_category->name,
						"arabic_name" => $parent_category->arabic_name,
						"status" => $parent_category->status,
						"child" => $child);
		}
		return $data;
	}

// 	public function get_product_list()
// 	{
// 		$a = "SELECT * FROM product WHERE id > 0";
// 		$query = $this->db->query($a);  
//         return $query->result();
// 	}
	  
}
