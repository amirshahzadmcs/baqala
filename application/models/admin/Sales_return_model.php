<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_return_model extends CI_Model{
	
	function get_order_list(){
		$query = $this->db->query("SELECT * FROM orders WHERE quotation_no != '' AND quotation_no > 0 AND order_status_id = '6'");
		return $query->result();
	}
	
	function make_query(){
		$a = "SELECT sr.*, o.id as orderid, o.invoice_prefix, o.c_company, o.customer_id, o.name, o.email, o.mobile, o.shipping_complete_address FROM sales_return sr LEFT JOIN orders o ON (o.id = sr.order_id) WHERE 1=1";
	   return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND o.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY id ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY created_at DESC";		   
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
	   $this->db->from('sales_return');  
	   return $this->db->count_all_results();
    }
	
	function get_order($id){
		$query = $this->db->query("SELECT * FROM `orders` o WHERE o.id = '" . (int)$id . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "' ORDER BY id ASC")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}
	
	function get_sales_detail($id){
		$query = $this->db->query("SELECT sr.*, o.id as orderid, o.invoice_prefix, o.customer_id, o.name, o.email, o.mobile, o.building_no, o.street_name, o.district_name, o.city_name, o.zip_code, o.additional_no, o.unit_no, o.country, o.payment_code, o.order_type, o.shipping_firstname, o.villa_building, o.shipping_house_no, o.shipping_street, o.shipping_sector, o.shipping_locality, o.shipping_city, o.shipping_state, o.shipping_country, o.shipping_postcode, o.shipping_lat, o.shipping_lng, o.shipping_place_id, o.shipping_instruction, o.shipping_addrstype, o.shipping_date_slot, o.shipping_time_slot, o.shipping_mobile, o.shipping_email, o.shipping_method, o.shipping_code, o.comment, o.shipping_charge, o.shipping_type, o.c_role, o.c_vat, o.c_company, o.promo_code, o.promo_code_name, o.promo_code_price, o.ref_code, o.order_status_id, o.tracking, o.packets, o.contactless, o.refund_id, o.delivery_boy, o.collected_amt, o.product_cashback, o.total_cashback, o.cashback_applied, o.wallet_applied, o.delivery_date, o.payment_method, o.delivery_payment, o.d_charge, o.cancelreason, o.trans_id, o.ip, o.date_added, o.date_modified FROM sales_return sr LEFT JOIN orders o ON (o.id = sr.order_id) WHERE sr.id = '" . (int)$id . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM sales_return_product WHERE return_id = '" . $id . "'")->result_array();
		$data = array("order"=>$query, "products"=>$sql);
		return $data;
	}
	
	function add_to_return(){
		$total = 0;
		$order_total = 0;
		$total_before_vat = 0;
		$total_vat = 0;
		$vat_rate = 15;

		$order_id = $this->input->post('order_id');
		$po_number = $this->input->post('po_number');
		$po_date = $this->input->post('po_date');
		$quotation_no = $this->input->post('quotation_no');
		$payment_method = $this->input->post('payment_method');
		$shipping_charge = $this->input->post('shipping_charge');
		
		$size_id = $this->input->post('size_id');
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$price = $this->input->post('price');
		$product_name = $this->input->post('product_name');
		$short_name = $this->input->post('short_name');
		$arabic_name = $this->input->post('arabic_name');
		$gst_rate = $this->input->post('gst_rate');
		$product_slug = $this->input->post('product_slug');
		$size = $this->input->post('size');
		$discounted_price = $this->input->post('discounted_price');
		$gift_value = $this->input->post('gift_value');
		$product_sku = $this->input->post('product_sku');
		$barcode = $this->input->post('barcode');
		$product_image = $this->input->post('product_image');
		
		$query = $this->db->query("INSERT INTO sales_return SET order_id = '" . (int)$order_id . "', po_number = '" . $po_number . "', po_date = '" . $this->db->escape_str($po_date) . "', quotation_no = '" . $this->db->escape_str($quotation_no) . "', payment_method = '" . $this->db->escape_str($payment_method) . "', item_total_price = '" . $this->db->escape_str($total) . "', order_total = '" . $this->db->escape_str($order_total) . "', total_vat = '" . $this->db->escape_str($total_vat) . "', total_before_vat = '" . $this->db->escape_str($total_before_vat) . "', shipping_charge = '" . $this->db->escape_str($shipping_charge) . "', status = 1, created_at = NOW(), updated_at = NOW()");
		$return_id = $this->db->insert_id();
		
		if($query){
			$product_count = count($product_id);
			for($p=0;$p<$product_count;$p++){
				
				if($discounted_price[$p]> 0){
					$order_price = $discounted_price[$p] * $quantity[$p];
				}else{
					$order_price = $price[$p] * $quantity[$p];
				}
				
				$base_price = round((($order_price * 100) / 115),2);
				$vat_price = round(($order_price - $base_price),2);
				
				$this->db->query("INSERT INTO sales_return_product SET return_id = '" . (int)$return_id . "', product_id = '" . (int)$product_id[$p] . "', product_name = '" . $this->db->escape_str($product_name[$p]) . "', short_name = '" . $this->db->escape_str($short_name[$p]) . "', arabic_name = '" . $this->db->escape_str($arabic_name[$p]) . "', gst_rate = '" . $this->db->escape_str($gst_rate[$p]) . "', vat_price = '" . $this->db->escape_str($vat_price) . "', barcode = '" . $this->db->escape_str($barcode[$p]) . "', product_slug = '" . $this->db->escape_str($product_slug[$p]) . "', size = '" . $this->db->escape_str($size[$p]) . "', size_id = '" . (int)$size_id[$p] . "', quantity = '" . $this->db->escape_str($quantity[$p]) . "', real_price = '" . $this->db->escape_str($price[$p]) . "', discounted_price = '" . $this->db->escape_str($discounted_price[$p]) . "', order_price = '" . $this->db->escape_str($order_price) . "', gift_value = '" . $this->db->escape_str($gift_value[$p]) . "', product_sku = '" . $this->db->escape_str($product_sku[$p]) . "', product_image = '" . $this->db->escape_str($product_image[$p]) . "'");
				
				$total = $total + $order_price;
			}
		}
		
		$total_before_vat = round((($total * 100) / 115),2);
		$order_total = $total;
		$total_vat = $order_total - $total_vat;
		
		$query_update = $this->db->query("UPDATE sales_return SET  item_total_price = '" . (float)$this->db->escape_str($total) . "', order_total = '" . (float)$this->db->escape_str($order_total) . "', total_vat = '" . (float)$this->db->escape_str($total_vat) . "', total_before_vat = '" . (float)$this->db->escape_str($total_before_vat) . "' WHERE id = '" . (int)$return_id . "'");
		
		return $return_id;
	}
	
	function updateStock($id){
		$query = $this->db->query("SELECT * FROM sales_return WHERE id = '" . $id . "'")->row();
		if($query){
			$purchaseItems = $this->db->query("SELECT product_sku,barcode,return_id,quantity FROM sales_return_product WHERE return_id = '" . (int)$query->id . "'")->result_array();
			if(count($purchaseItems) > 0){
				foreach($purchaseItems as $item){
					$sku = $item['product_sku'];
					$quantity = $item['quantity'];
					$product = $this->db->query("SELECT p.id, ps.id as size_id, ps.quantity FROM product p LEFT JOIN product_size ps ON(ps.product_id = p.id) WHERE p.sku = '" . $sku . "'")->row_array();
					$avl_qty = $product['quantity'];
					$size_id = $product['size_id'];
					$final_qty = $avl_qty + $quantity;
					$query2 = $this->db->query("UPDATE product_size SET quantity = '" . $final_qty . "' WHERE id = '" . $size_id . "'");
				}
			}
			return true;
		}else{
			return false;
		}
	}
}
