<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_return_model extends CI_Model{
	
	function get_grv_list(){
		$query = $this->db->query("SELECT * FROM grv WHERE grv_status = 'closed'");
		return $query->result();
	}
	
	function add(){
		$query = $this->db->query("SELECT v.*, mc.city_name FROM vendors v LEFT JOIN master_city mc ON(v.city = mc.id) WHERE v.id = '" . (int)$this->input->post('vendor_id') . "'")->row();
		if($query){
			$this->db->query("INSERT INTO purchase_return SET po_id = '" . (int)$this->input->post('po_id') . "', po_number = '" . $this->db->escape_str($this->input->post('po_number')) . "', vendor_id = '" . (int)$query->id . "', vendor_name = '" . $this->db->escape_str($query->vendor_name) . "', b_contact = '" . $this->db->escape_str($query->telephone) . "', b_short_address = '" . $this->db->escape_str($query->short_address) . "', b_building_no = '" . $this->db->escape_str($query->building_no) . "', b_street_name = '" . $this->db->escape_str($query->street_name) . "', b_district = '" . $this->db->escape_str($query->district) . "', b_additional_no = '" . $this->db->escape_str($query->additional_no) . "', b_unit_no = '" . $this->db->escape_str($query->unit_no) . "', b_city_name = '" . $this->db->escape_str($query->city_name) . "', b_zip_code = '" . $this->db->escape_str($query->postal_code) . "', delivery_name = '" . $this->db->escape_str($query->contact_person_name) . "', d_contact = '" . $this->db->escape_str($query->telephone) . "', d_short_address = '" . $this->db->escape_str($query->short_address) . "', d_building_no = '" . $this->db->escape_str($query->building_no) . "', d_street_name = '" . $this->db->escape_str($query->street_name) . "', d_district = '" . $this->db->escape_str($query->district) . "', d_additional_no = '" . $this->db->escape_str($query->additional_no) . "', d_unit_no = '" . $this->db->escape_str($query->unit_no) . "', d_city_name = '" . $this->db->escape_str($query->city_name) . "', d_zip_code = '" . $this->db->escape_str($query->postal_code) . "', po_date = NOW(), po_terms = '" . $this->db->escape_str($query->payment_terms) . "', po_contact = '" . $this->db->escape_str($query->telephone) . "', sub_total = '" . $this->db->escape_str($this->input->post('sub_total')) . "', sale_tax = '" . $this->db->escape_str((int)$this->input->post('sale_tax')) . "', sale_tax_amt = '" . $this->db->escape_str($this->input->post('sale_tax_amt')) . "', shipping_handling = '" . $this->db->escape_str($this->input->post('shipping_handling')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', total_qty = '" . count($this->input->post('item_sku')) . "', created_by = '" . $this->db->escape_str($this->session->userdata('admin_name')) . "', created_by_id = '" . $this->db->escape_str($this->admin->getId()) . "', status = 1, created_at = NOW(), updated_at = now()");
			$return_id = $this->db->insert_id();
		
			if($this->input->post('item_description')){
				$item_count = count($this->input->post('item_description'));
				for($m=0;$m<$item_count;$m++){
					$prod_id = $this->input->post('prod_id');
					$size_id = $this->input->post('size_id');
					$item_description = $this->input->post('item_description');
					$item_desc_arabic = $this->input->post('item_desc_arabic');
					$item_sku = $this->input->post('item_sku');
					$seller_sku = $this->input->post('seller_sku');
					$barcode = $this->input->post('barcode');
					$item_unit = $this->input->post('item_unit');
					$received_qty = $this->input->post('received_qty');
					$sellable_qty = $this->input->post('sellable_qty');
					$unit_price = $this->input->post('unit_price');
					$item_total = $this->input->post('item_total');
					$tax_sum = ($item_total[$m] / 100) * (int)$this->input->post('sale_tax');
					$vat_price = $tax_sum;
					$final_amount = $item_total[$m]+$vat_price;
					
					$query = $this->db->query("INSERT INTO purchase_return_items SET p_order_id = '" . (int)$return_id . "', prod_id = '" . $this->db->escape_str($prod_id[$m]) . "', size_id = '" . $this->db->escape_str($size_id[$m]) . "', item_description = '" . $this->db->escape_str($item_description[$m]) . "', item_desc_arabic = '" . $this->db->escape_str($item_desc_arabic[$m]) . "', item_sku = '" . $item_sku[$m] . "', seller_sku = '" . $seller_sku[$m] . "', received_qty = '" . $received_qty[$m] . "', sellable_qty = '" . $sellable_qty[$m] . "', barcode = '" . $barcode[$m] . "', item_unit = '" . $item_unit[$m] . "', unit_price = '" . $unit_price[$m] . "', item_total = '" . $item_total[$m] . "', vat_price = '" . $vat_price . "', amt_incl_vat = '" . $final_amount . "', created_at = NOW(), updated_at = NOW()");
				}
			}
		}
		if($query){
			return $return_id;
		}else{
			return false;
		}
	}
	/*
	function updateStock($id){
		$query = $this->db->query("SELECT * FROM purchase_return WHERE id = '" . $id . "'")->row();
		if($query){
			$purchaseItems = $this->db->query("SELECT item_sku,barcode,p_order_id,item_unit,unit_price FROM purchase_return_items WHERE p_order_id = '" . (int)$query->id . "'")->result_array();
			if(count($purchaseItems) > 0){
				foreach($purchaseItems as $item){
					$sku = $item['item_sku'];
					$quantity = $item['item_unit'];
					$product = $this->db->query("SELECT p.id, ps.id as size_id, ps.quantity FROM product p LEFT JOIN product_size ps ON(ps.product_id = p.id) WHERE sku = '" . $sku . "'")->row_array();
					$avl_qty = $product['quantity'];
					$size_id = $product['size_id'];
					$final_qty = $avl_qty - $quantity;
					$query2 = $this->db->query("UPDATE product_size SET quantity = '" . $final_qty . "' WHERE id = '" . $size_id . "'");
				}
			}
			return true;
		}else{
			return false;
		}
	}
	*/
	function make_query(){
		$a = "SELECT * FROM purchase_return WHERE 1=1";
	   return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND vendor_name LIKE '%".$_POST["search"]["value"]."%'";
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
	   $this->db->from('purchase_return');  
	   return $this->db->count_all_results();
    }
	
	function get_purchase_detail($id){
		$query = $this->db->query("SELECT po.*, v.vat_no, v.contact_person_name, v.country, gv.grv_no, gv.created_at as grv_date FROM purchase_order po LEFT JOIN vendors v ON (v.id = po.vendor_id) LEFT JOIN grv gv ON (gv.po_id = po.id) WHERE po.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM purchase_items WHERE p_order_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "products"=>$sql);
		return $data;
	}
	
	function order_items($id){
		$query = $this->db->query("SELECT * FROM purchase_return_items WHERE p_order_id = '" . $id . "'");
		return $query->result();
	}
	
	function get_order_detail($id){
		$query = $this->db->query("SELECT po.*, v.vat_no, v.vat_no, v.contact_person_name, v.country, gv.grv_no, gv.created_at as grv_date FROM purchase_return po LEFT JOIN vendors v ON (v.id = po.vendor_id) LEFT JOIN grv gv ON (gv.po_id = po.id) WHERE po.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM purchase_return_items WHERE p_order_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "products"=>$sql);
		return $data;
	}
	
	function get_vendors(){
		$query = $this->db->query("SELECT * FROM vendors WHERE 1=1");
		return $query->result();
	}
	
	function get_vendor_detail($id){
		$query = $this->db->query("SELECT v.*, mc.city_name FROM vendors v LEFT JOIN master_city mc ON(v.city = mc.id) WHERE v.id = '" . $id . "'");
		return $query->row();
	}
	
}
