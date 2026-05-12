<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockreq_model extends CI_Model{

	function add(){
		$total_qty = 0;
		$total_sku = 0;
		$total_amt_excl_vat = 0;
		$total_vat_amt = 0;
		$total_tax_inclusive = 0;
		$shipping_handling = 0;
		$total_amount = 0;
		
		$query = $this->db->query("INSERT INTO stock_request SET store_id = '" . (int)$this->store->getId() . "', target_store_id = '" . (int)$this->input->post('target_store_id') . "', expected_date = '" . $this->input->post('expected_date') . "', status = 1, created_at = NOW(), updated_at = now()");
		
		$order_id = $this->db->insert_id();
		
		if($query){
			if($this->input->post('item_description')){
				$item_count = count($this->input->post('item_description'));
				$total_sku = $item_count;
				for($m=0;$m<$item_count;$m++){
					$item_description = $this->input->post('item_description')[$m];
					$item_desc_arabic = $this->input->post('item_desc_arabic')[$m];
					$item_psku = $this->input->post('item_parentsku')[$m];
					
					$size_id = $this->input->post('size_id')[$m];
					$item_unit = $this->input->post('item_unit')[$m];
					$item_size = $this->input->post('item_size')[$m];
					
					$product_size_detail = $this->db->query("SELECT ps.* FROM product_size ps WHERE ps.id = '" . $size_id . "'")->row();
					
					$item_sku = $product_size_detail->product_sku;
					$barcode = $product_size_detail->barcode;
					$prod_id = $product_size_detail->product_id;
					$unit_price = $product_size_detail->price;
					$amt_incl_vat = $unit_price * $item_unit;
					
					$base_unit_price = round((($unit_price * 100) / 115),2);
					$vat_unit_price = round(($unit_price - $base_unit_price),2);
					$vat_amt = $vat_unit_price * $item_unit;
					$amt_excl_vat = $amt_incl_vat - $vat_amt;
					$vat_percent = '15.00%';
					
					$query = $this->db->query("INSERT INTO stock_request_items SET request_id = '" . (int)$order_id . "', product_id = '" . (int)$prod_id . "', size_id = '" . (int)$size_id . "', item_description = '" . $this->db->escape_str($item_description) . "', item_desc_arabic = '" . $this->db->escape_str($item_desc_arabic) . "', size = '" . $this->db->escape_str($item_size) . "', parent_sku = '" . $item_psku . "', item_sku = '" . $item_sku . "', barcode = '" . $barcode . "', item_unit = '" . $item_unit . "', unit_price = '" . $base_unit_price . "', amt_excl_vat = '" . $amt_excl_vat . "', vat_percent = '" . $vat_percent . "', vat_amt = '" . $vat_amt . "', amt_incl_vat = '" . $amt_incl_vat . "', created_at = NOW(), updated_at = NOW()");
					
					$total_qty += $item_unit;
					$total_amt_excl_vat += $amt_excl_vat;
					$total_vat_amt += $vat_amt;
					$total_tax_inclusive += $amt_incl_vat;
				}
				
				$total_amount = $total_tax_inclusive + $shipping_handling;
				$req_id = str_pad($order_id, 6, 0, STR_PAD_LEFT);
				$this->db->query("UPDATE stock_request SET request_id = '" . 'ST'.$req_id . "', total_qty = '" . (int)$total_qty . "', total_sku = '" . (int)$total_sku . "', total_amt_excl_vat = '" . $total_amt_excl_vat . "', vat_amt = '" . $total_vat_amt . "', total_tax_inclusive = '" . $total_tax_inclusive . "', shipping_handling = '" . $shipping_handling . "', total_amount = '" . $total_amount . "', updated_at = now() WHERE id = '" . (int)$order_id . "'");
			}
		}
		if($query){
			return true;
		}else{
			return false;
		}
	}

	function edit(){
		$order_id = $this->input->post('id');
		$query = $this->db->query("UPDATE stock_request SET sub_total = '" . $this->db->escape_str($this->input->post('sub_total')) . "', sale_tax = '" . $this->db->escape_str((int)$this->input->post('sale_tax')) . "', sale_tax_amt = '" . $this->db->escape_str($this->input->post('sale_tax_amt')) . "', shipping_handling = '" . $this->db->escape_str($this->input->post('shipping_handling')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', total_qty = '" . count($this->input->post('item_sku')) . "', updated_at = now() WHERE id = '" . (int)$order_id . "'");
		
		$this->db->query("DELETE FROM stock_request_items WHERE p_order_id = '" . (int)$order_id . "'");
		if($this->input->post('item_description')){
			$item_count = count($this->input->post('item_description'));
			for($m=0;$m<$item_count;$m++){
				$product_id = $this->input->post('product_id');
				$size_id = $this->input->post('size_id');
				$item_description = $this->input->post('item_description');
				$item_desc_arabic = $this->input->post('item_desc_arabic');
				$item_sku = $this->input->post('item_sku');
				$barcode = $this->input->post('barcode');
				$item_unit = $this->input->post('item_unit');
				$unit_price = $this->input->post('unit_price');
				$item_total = $this->input->post('item_total');
				$item_size = $this->input->post('item_size');
				
				$query = $this->db->query("INSERT INTO stock_request_items SET p_order_id = '" . (int)$order_id . "', product_id = '" . $product_id[$m] . "', size_id = '" . $size_id[$m] . "', item_description = '" . $this->db->escape_str($item_description[$m]) . "', item_desc_arabic = '" . $this->db->escape_str($item_desc_arabic[$m]) . "', size = '" . $this->db->escape_str($item_size[$m]) . "', item_sku = '" . $item_sku[$m] . "', barcode = '" . $barcode[$m] . "', item_unit = '" . $item_unit[$m] . "', unit_price = '" . $unit_price[$m] . "', item_total = '" . $item_total[$m] . "', created_at = NOW(), updated_at = NOW()");
			}
		}
		return $query;
	}
	 
	function make_query(){
		$a = "SELECT sr.*, srs.status_name, srs.status_type, s.store_id as storeid, s.store_name, w.name_english as target_store_name, w.partner_code FROM stock_request sr LEFT JOIN stock_request_status srs ON (srs.id = sr.status) LEFT JOIN stores s ON (sr.store_id = s.id) LEFT JOIN warehouse w ON (sr.target_store_id = w.id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(!empty($this->input->get('from')) AND !empty($this->input->get('to'))){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND created_at <='" . $d_to . "'";
			}
		}
		if(!empty($this->input->get('status'))){
			$a .= " AND sr.status = '" . $this->input->get('status') . "'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND s.store_id LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND s.store_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY id ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
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
		$this->db->from('stock_request');  
		return $this->db->count_all_results();  
	}
	
	public function delete($order_id) {
		$count = count($order_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM stock_request WHERE id = '" . (int)$order_id[$i] . "' AND store_id = '". (int)$this->customer->getId() ."'");
			$this->db->query("DELETE FROM stock_request_items WHERE request_id = '" . (int)$order_id[$i] . "'");
		}
		return true;
	}
	
	function order_items($id){
		$query = $this->db->query("SELECT * FROM stock_request_items WHERE request_id = '" . $id . "'");
		return $query->result();
	}
	
	function get_request_detail($id){
		$query = $this->db->query("SELECT sr.*, srs.status_name, srs.status_type, s.store_id as storeid, s.store_name, s.store_incharge, s.email, s.contact_number, s.store_location FROM stock_request sr LEFT JOIN stock_request_status srs ON (srs.id = sr.status) LEFT JOIN stores s ON (s.id = sr.store_id) WHERE sr.id = '" . (int)$id . "' AND sr.store_id = '". (int)$this->store->getId() ."'")->row();
		$sql = $this->db->query("SELECT * FROM stock_request_items WHERE request_id = '" . $id . "'")->result();
		$warehouse = $this->db->query("SELECT name_english, contact_person, warehouse_email, warehouse_phone, complete_address FROM warehouse WHERE 1")->row();
		$data = array("order"=>$query, "products"=>$sql, "warehouse_address"=>$warehouse);
		return $data;
	}
	
	public function setStatusEnable($id) {
	    $this->db->query("UPDATE stock_request SET status = '2' WHERE id = '" . $id . "'");
	    return true;
	}
	
	public function setStatusDisable($ids){
	    foreach($ids as $id){
	        $this->db->query("UPDATE stock_request SET status = '4' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	function get_vendors(){
		$query = $this->db->query("SELECT * FROM vendors WHERE 1=1");
		return $query->result();
	}
	
	function get_vendor_detail($id){
		$query = $this->db->query("SELECT v.*, mc.city_name FROM vendors v LEFT JOIN master_city mc ON(v.city = mc.id) WHERE v.id = '" . $id . "'");
		return $query->row();
	}
	/*-------- Get Orders By Vendor ---------*/
	function make_order_query($id){
		$a = "SELECT p.* FROM stock_request p WHERE p.vendor_id = '" . (int)$id . "'";
	   return $a;
	}
	
	function get_order_list($id){
		$a = $this->make_order_query($id);
		if(isset($_POST["search"]["value"])){
			$a .= " AND p.purchaser_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY p.purchaser_name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY p.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_order_data($id){
		$a = $this->make_order_query($id);
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_order_data($id){
		$this->db->select("*");
		$this->db->from('stock_request');
		$this->db->where('vendor_id', (int)$id);	   
		return $this->db->count_all_results();
    }
    
	
	/*------ Search Product -----*/
	
	function get_search_list($term){
		$data = array();
		$this->db->select('s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku');
		$this->db->from('product_size s');
		$this->db->like('s.product_sku', $this->db->escape_str($term));
		$this->db->or_like('p.parent_sku', $this->db->escape_str($term));
		$this->db->or_like('s.barcode', $this->db->escape_str($term));
		$this->db->or_like('p.name', $this->db->escape_str($term));
		$this->db->or_like('p.name_ar', $this->db->escape_str($term));
		$this->db->join('product p', 's.product_id = p.id', 'left');
		$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
		$query = $this->db->get()->result();
		foreach($query as $pdata){
			//$sql = $this->db->query("SELECT ps.barcode FROM product_size ps WHERE ps.product_id = '" . (int)$pdata->id . "'")->row();
			$data[] = array("id" => $pdata->size_id,
							"prod_id" => $pdata->prod_id,
							"name" => $pdata->name,
							"name_arabic" => $pdata->name_ar,
							"image" => $pdata->image,
							"sku" => $pdata->product_sku,
							"parent_sku" => $pdata->parent_sku,
							"seller_sku" => $pdata->seller_sku,
							"size_id" => $pdata->size_id,
							"size" => $pdata->size,
							"unit_name" => $pdata->unit_name,
							"barcode" => $pdata->barcode);
		}
		return $data;
	}

}
