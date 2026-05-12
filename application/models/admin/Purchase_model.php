<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_model extends CI_Model{

	function createPurchase(){
		$query = $this->db->query("SELECT v.*, mc.city_name FROM vendors v LEFT JOIN master_city mc ON(v.city = mc.id) WHERE v.id = '" . (int)$this->input->post('vendor_id') . "'")->row();
		if($query){
			$con['upload_path']   = './uploads/po/'; 
			$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx'; 
			$con['maintain_ratio'] = TRUE;
			$con['max_filename'] = '50';
			$con['encrypt_name'] = TRUE;
			
			if($_FILES['image']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('image');
				$image_da = $this->upload->data();
				$imagef = "uploads/po/".$image_da['file_name'];
			}
			else{
				$imagef = "";
			}
			$this->db->query("INSERT INTO purchase_order SET po_date = '" . $this->input->post('po_date') . "', vendor_id = '" . (int)$query->id . "', vendor_name = '" . $this->db->escape_str($query->vendor_name) . "', b_contact = '" . $this->db->escape_str($query->telephone) . "', b_short_address = '" . $this->db->escape_str($query->short_address) . "', b_building_no = '" . $this->db->escape_str($query->building_no) . "', b_street_name = '" . $this->db->escape_str($query->street_name) . "', b_district = '" . $this->db->escape_str($query->district) . "', b_additional_no = '" . $this->db->escape_str($query->additional_no) . "', b_unit_no = '" . $this->db->escape_str($query->unit_no) . "', b_city_name = '" . $this->db->escape_str($query->city) . "', b_zip_code = '" . $this->db->escape_str($query->postal_code) . "', delivery_name = '" . $this->db->escape_str($query->contact_person_name) . "', d_contact = '" . $this->db->escape_str($query->telephone) . "', d_short_address = '" . $this->db->escape_str($query->short_address) . "', d_building_no = '" . $this->db->escape_str($query->building_no) . "', d_street_name = '" . $this->db->escape_str($query->street_name) . "', d_district = '" . $this->db->escape_str($query->district) . "', d_additional_no = '" . $this->db->escape_str($query->additional_no) . "', d_unit_no = '" . $this->db->escape_str($query->unit_no) . "', d_city_name = '" . $this->db->escape_str($query->city_name) . "', d_zip_code = '" . $this->db->escape_str($query->postal_code) . "', po_terms = '" . $this->db->escape_str($query->payment_terms) . "', po_contact = '" . $this->db->escape_str($query->telephone) . "', attachment = '" . $this->db->escape_str($imagef) . "', created_by = '" . $this->db->escape_str($this->session->userdata('admin_name')) . "', reference = '" . $this->db->escape_str($this->input->post('reference')) . "', created_by_id = '" . $this->db->escape_str($this->admin->getId()) . "', status = 1, created_at = NOW(), updated_at = now()");
			$order_id = $this->db->insert_id();
			if($order_id > 0){
				$po_number = str_pad($order_id, 6, 0, STR_PAD_LEFT);
				$this->db->query("UPDATE purchase_order SET po_number = '" . $this->db->escape_str($po_number) . "', updated_at = now() WHERE id = '". (int)$order_id ."'");
			}
			return $order_id;
		}else{
			return false;
		}
	}

	function add(){
		$id = $this->input->post('id');
		if($id > 0){
			$this->db->query("UPDATE purchase_order SET sub_total = '" . $this->db->escape_str($this->input->post('sub_total')) . "', sale_tax = '" . $this->db->escape_str((int)$this->input->post('sale_tax')) . "', sale_tax_amt = '" . $this->db->escape_str($this->input->post('sale_tax_amt')) . "', shipping_handling = '" . $this->db->escape_str($this->input->post('shipping_handling')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', total_qty = '" . count($this->input->post('item_sku')) . "', updated_at = now() WHERE id = '". (int)$id ."'");
			$order_id = $id;
		
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
					$unit_price = $this->input->post('unit_price');
					$item_total = $this->input->post('item_total');
					$tax_sum = ($item_total[$m] / 100) * (int)$this->input->post('sale_tax');
					$vat_price = $tax_sum;
					$final_amount = $item_total[$m]+$vat_price;
					
					$query = $this->db->query("INSERT INTO purchase_items SET p_order_id = '" . (int)$order_id . "', prod_id = '" . $this->db->escape_str($prod_id[$m]) . "', size_id = '" . $this->db->escape_str($size_id[$m]) . "', item_description = '" . $this->db->escape_str($item_description[$m]) . "', item_desc_arabic = '" . $this->db->escape_str($item_desc_arabic[$m]) . "', item_sku = '" . $item_sku[$m] . "', seller_sku = '" . $seller_sku[$m] . "', barcode = '" . $barcode[$m] . "', item_unit = '" . $item_unit[$m] . "', unit_price = '" . $unit_price[$m] . "', item_total = '" . $item_total[$m] . "', vat_price = '" . $vat_price . "', amt_incl_vat = '" . $final_amount . "', created_at = NOW(), updated_at = NOW()");
				}
			}
		}
		if($query){
			return true;
		}else{
			return false;
		}
	}
    
    function edit(){
		$id = $this->input->post('id');
		if($id > 0){
			$query = $this->db->query("UPDATE purchase_order SET sub_total = '" . $this->db->escape_str($this->input->post('sub_total')) . "', sale_tax = '" . $this->db->escape_str((int)$this->input->post('sale_tax')) . "', sale_tax_amt = '" . $this->db->escape_str($this->input->post('sale_tax_amt')) . "', shipping_handling = '" . $this->db->escape_str($this->input->post('shipping_handling')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', total_qty = '" . count($this->input->post('item_sku')) . "', updated_at = now() WHERE id = '". (int)$id ."'");
			$order_id = $id;
			$this->db->query("DELETE FROM purchase_items WHERE p_order_id = '" . (int)$order_id . "'");
			if($this->input->post('item_description')){
				$item_count = count($this->input->post('item_description'));
				for($m=0;$m<$item_count;$m++){
					$prod_id = $this->input->post('prod_id');
					$size_id = $this->input->post('size_id');
					$item_description = $this->input->post('item_description');
					$item_desc_arabic = $this->input->post('item_desc_arabic');
					$item_sku = $this->input->post('item_sku');

					$seller_sku = ($this->input->post('seller_sku') !== '') ? $this->input->post('seller_sku') : '';
					$barcode = ($this->input->post('barcode') !== '') ? $this->input->post('barcode') : ''; 
					
					//$seller_sku = $this->input->post('seller_sku');
					//$barcode = $this->input->post('barcode');
					$item_unit = $this->input->post('item_unit');
					$unit_price = $this->input->post('unit_price');
					$item_total = $this->input->post('item_total');
					$tax_sum = ($item_total[$m] / 100) * (int)$this->input->post('sale_tax');
					$vat_price = $tax_sum;
					$final_amount = $item_total[$m]+$vat_price;
					
					$query1 = $this->db->query("INSERT INTO purchase_items SET p_order_id = '" . (int)$order_id . "', prod_id = '" . $this->db->escape_str($prod_id[$m]) . "', size_id = '" . $this->db->escape_str($size_id[$m]) . "', item_description = '" . $this->db->escape_str($item_description[$m]) . "', item_desc_arabic = '" . $this->db->escape_str($item_desc_arabic[$m]) . "', item_sku = '" . $item_sku[$m] . "', seller_sku = '" . $seller_sku[$m] . "', barcode = '" . $barcode[$m] . "', item_unit = '" . $item_unit[$m] . "', unit_price = '" . $unit_price[$m] . "', item_total = '" . $item_total[$m] . "', vat_price = '" . $vat_price . "', amt_incl_vat = '" . $final_amount . "', updated_at = NOW()");
				}
			}
		}
		return $query;
	}
	 
	function make_query(){
		$a = "SELECT * FROM purchase_order WHERE 1=1";
	   return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (po_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('min_price') AND $this->input->get('max_price')){
			$min_price = $this->input->get('min_price');
			$max_price = $this->input->get('max_price');
			if($min_price AND $max_price){
				$a .= " AND (total BETWEEN '".$min_price."' AND '".$max_price."')";
			}
		}

		if($this->input->get('supplier')) {
			$supplier = $this->input->get('supplier');
            if($supplier != ''){
                $a .= " AND `vendor_id` = '" . $supplier . "'";
            }
        }

		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status != ''){
                $a .= " AND `status` = '" . $status . "'";
            }
        }

		if($this->input->get('po_number')) {
			$po_number = $this->input->get('po_number');
            if($po_number != ''){
                $a .= " AND `id` = '" . $po_number . "'";
            }
        }
		if(isset($_POST["search"]["value"])){
			$a .= " AND vendor_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY po_no ". $_POST['order']['0']['dir'] ."";
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
	   	if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (po_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('min_price') AND $this->input->get('max_price')){
			$min_price = $this->input->get('min_price');
			$max_price = $this->input->get('max_price');
			if($min_price AND $max_price){
				$a .= " AND (total BETWEEN '".$min_price."' AND '".$max_price."')";
			}
		}

		if($this->input->get('supplier')) {
			$supplier = $this->input->get('supplier');
			if($supplier != ''){
				$a .= " AND `vendor_id` = '" . $supplier . "'";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND `status` = '" . $status . "'";
			}
		}

		if($this->input->get('po_number')) {
			$po_number = $this->input->get('po_number');
			if($po_number != ''){
				$a .= " AND `id` = '" . $po_number . "'";
			}
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND vendor_name LIKE '%".$_POST["search"]["value"]."%'";
		}
	   	$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('purchase_order');  
	   return $this->db->count_all_results();
    }
	
	public function delete($order_id) {
		$count = count($order_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM purchase_order WHERE id = '" . (int)$order_id[$i] . "'");
			$this->db->query("DELETE FROM purchase_items WHERE p_order_id = '" . (int)$order_id[$i] . "'");
		}
		return true;
	}
	
	function order_items($id){
		$query = $this->db->query("SELECT * FROM purchase_items WHERE p_order_id = '" . $id . "'");
		return $query->result();
	}
	
	function get_order_detail($id){
		$query = $this->db->query("SELECT po.*, v.vat_no, v.contact_person_name, v.country, v.vendor_email, mc.city_name as billing_city_name FROM purchase_order po LEFT JOIN vendors v ON (v.id = po.vendor_id) LEFT JOIN master_city mc ON(po.b_city_name = mc.id) WHERE po.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM purchase_items WHERE p_order_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "products"=>$sql);
		return $data;
	}
	
	public function setStatusEnable($id) {
	    $this->db->query("UPDATE purchase_order SET status = '2' WHERE id = '" . $id . "'");
	    return true;
	}
	
	public function setStatusDisable($ids){
	    foreach($ids as $id){
	        $this->db->query("UPDATE purchase_order SET status = '4' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	function get_vendors(){
		$query = $this->db->query("SELECT * FROM vendors WHERE 1=1 ORDER BY vendor_name ASC");
		return $query->result();
	}
	
	function get_vendor_detail($id){
		$query = $this->db->query("SELECT v.*, mc.city_name FROM vendors v LEFT JOIN master_city mc ON(v.city = mc.id) WHERE v.id = '" . $id . "'");
		return $query->row();
	}

	/*-------- Get Orders By Vendor ---------*/
	function make_order_query($id){
		$a = "SELECT p.* FROM purchase_order p WHERE p.vendor_id = '" . (int)$id . "'";
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
		$this->db->from('purchase_order');
		$this->db->where('vendor_id', (int)$id);	   
		return $this->db->count_all_results();
    }
    
	/*------ Search Product -----*/
	function get_search($term){
		$data = array();
		$query = $this->db->query("SELECT name, id, image, name_ar, parent_sku, status FROM product WHERE is_deleted = '0' AND (name LIKE '%" . $this->db->escape_str($term) . "%' OR parent_sku LIKE '%" . $this->db->escape_str($term) . "%')");
		foreach($query->result() as $query){
			$sql = $this->db->query("SELECT ps . * , IF(c.quantity > 0, c.quantity, 0) AS cart_quantity, IF( ps.price - ps.discounted_price >0, (ps.price - ps.discounted_price) / ps.price *100, 0 ) AS percent FROM product_size ps LEFT JOIN cart c ON ( c.size_id = ps.id AND c.session_id = '" . $this->customer->getSessionId() . "') WHERE ps.product_id = '" . (int)$query->id . "' AND ps.is_deleted = '0'");
			$data[] = array("name" => $query->name,
							"id" => $query->id,
							"name_hindi" => $query->name_hindi,
							"image" => $query->image,
							"sku" => $query->sku,
							"seo" => $query->seo,
							"is_gift" => $query->is_gift,
							"prices" => $sql->result_array());
		}
		return $data;
	}

	function get_search_hint($term){
		$data = array();
		$search_term = $this->db->escape_str($term);
		$this->db->select('s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku');
		$this->db->from('product_size s');
		$this->db->join('product p', 's.product_id = p.id', 'left');
		$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
		$this->db->where('p.is_deleted', '0');
		$this->db->where('s.is_deleted', '0');
		$this->db->where("(s.product_sku LIKE '%".$search_term."%' OR p.parent_sku LIKE '%".$search_term."%' OR s.barcode LIKE '%".$search_term."%' OR p.name LIKE '%".$search_term."%' OR p.name_ar LIKE '%".$search_term."%')", NULL, FALSE);
		
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
							"unit" => $pdata->size_unit,
							"unit_name" => $pdata->unit_name,
							"barcode" => $pdata->barcode);
		}
		return $data;
	}
}
