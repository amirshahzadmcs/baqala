<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation_model extends CI_Model{
	
	function make_query(){
		$a = "SELECT q.*, ad.name as associate_name, ad.username as associate_username FROM quotation q LEFT JOIN admin ad ON(q.associate_id = ad.admin_id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (q.date_added BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('min_price') AND $this->input->get('max_price')){
			$min_price = $this->input->get('min_price');
			$max_price = $this->input->get('max_price');
			if($min_price AND $max_price){
				$a .= " AND (q.order_total BETWEEN '".$min_price."' AND '".$max_price."')";
			}
		}

		if($this->input->get('client')) {
			$client = $this->input->get('client');
            if($client != ''){
                $a .= " AND q.customer_id = '" . $client . "'";
            }
        }

		if($this->input->get('added_by')) {
			$added_by = $this->input->get('added_by');
            if($added_by != ''){
                $a .= " AND q.associate_id = '" . $added_by . "'";
            }
        }

		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status != ''){
                $a .= " AND q.quotation_status = '" . $status . "'";
            }
        }

		if($this->input->get('estimate_no')) {
			$estimate_no = $this->input->get('estimate_no');
            if($estimate_no != ''){
                $a .= " AND q.quotation_no = '" . $estimate_no . "'";
            }
        }
		if(isset($_POST["search"]["value"])){
			$a .= " AND q.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY q.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY q.id DESC";		   
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
				$a .= " AND (q.date_added BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('min_price') AND $this->input->get('max_price')){
			$min_price = $this->input->get('min_price');
			$max_price = $this->input->get('max_price');
			if($min_price AND $max_price){
				$a .= " AND (q.order_total BETWEEN '".$min_price."' AND '".$max_price."')";
			}
		}

		if($this->input->get('client')) {
			$client = $this->input->get('client');
			if($client != ''){
				$a .= " AND q.customer_id = '" . $client . "'";
			}
		}

		if($this->input->get('added_by')) {
			$added_by = $this->input->get('added_by');
			if($added_by != ''){
				$a .= " AND q.associate_id = '" . $added_by . "'";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND q.quotation_status = '" . $status . "'";
			}
		}

		if($this->input->get('estimate_no')) {
			$estimate_no = $this->input->get('estimate_no');
			if($estimate_no != ''){
				$a .= " AND q.quotation_no = '" . $estimate_no . "'";
			}
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('quotation');  
	   return $this->db->count_all_results();
    }
	
	function get_customer(){
		$query = $this->db->query("SELECT * FROM customer WHERE role_id = 2");
		return $query->result();
	}
	
	public function delete($ids) {
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM quotation WHERE id = '" . (int)$ids[$i] . "'");
			$this->db->query("DELETE FROM quotation_product WHERE quotation_id = '" . (int)$ids[$i] . "'");
		}
		return true;
	}
	
	function createOrder(){
		$q_date = $this->input->post('date_added');
		//$q_date = strtotime($q_date);
		//$date_format = strtotime("+15 day", $q_date);
		//$expiry_date = date("Y-m-d", $date_format);
		$expiry_date = date('Y-m-d', strtotime($q_date. ' + 15 days'));
		//print_r($expiry_date);exit();
		$c_detail = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$this->input->post('customer_id') . "'")->row();
		$c_info = $this->db->query("SELECT * FROM customer_info WHERE user_id = '" . (int)$c_detail->id . "'")->row();
		$s_address = $this->db->query("SELECT * FROM corporate_address WHERE (customer_id = '" . (int)$this->input->post('customer_id') . "' AND id = '" . (int)$this->input->post('address_id') . "')")->row();

		$data = array(
			'customer_id' => (int)$c_detail->id, 
			'name' => $this->db->escape_str($c_detail->name), 
			'mobile' => $this->db->escape_str($c_detail->mobile), 
			'email' => $this->db->escape_str($c_detail->email), 
			'c_role' => $this->db->escape_str($c_detail->role_id), 
			'c_vat' => $this->db->escape_str($c_detail->vat_no), 
			'c_company' => $this->db->escape_str($c_detail->company_name), 
			'building_no' => $this->db->escape_str($c_info->building_no), 
			'street_name' => $this->db->escape_str($c_info->street_name), 
			'district_name' => $this->db->escape_str($c_info->district), 
			'city_name' => $this->db->escape_str($c_info->city), 
			'zip_code' => $this->db->escape_str($c_info->postal_code), 
			'additional_no' => $this->db->escape_str($c_info->additional_no), 
			'unit_no' => $this->db->escape_str($c_info->unit_no), 
			'country' => $this->db->escape_str($c_info->country), 
			'payment_method' => $this->db->escape_str($this->input->post('payment_method')), 
			'payment_code' => '', 
			'shipping_code' => '', 
			'address_id' => $this->db->escape_str($s_address->id), 
			's_email' => $this->db->escape_str($s_address->email), 
			's_mobile' => $this->db->escape_str($s_address->mobile), 
			's_phone' => $this->db->escape_str($s_address->phone), 
			's_extension' => $this->db->escape_str($s_address->extension), 
			's_reference' => $this->db->escape_str($s_address->reference), 
			's_person_name' => $this->db->escape_str($s_address->person_name), 
			's_address_label' => $this->db->escape_str($s_address->address_label), 
			's_address_type' => $this->db->escape_str($s_address->address_type), 
			's_building_villa_no' => $this->db->escape_str($s_address->building_villa_no), 
			's_street' => $this->db->escape_str($s_address->street), 
			's_city' => $this->db->escape_str($s_address->city),  
			's_country' => $this->db->escape_str($s_address->country), 
			's_postal' => $this->db->escape_str($s_address->postal), 
			'shipping_lat' => $this->db->escape_str($s_address->shipping_lat), 
			'shipping_lng' => $this->db->escape_str($s_address->shipping_lng), 
			'shipping_place_id' => $this->db->escape_str($s_address->shipping_place_id), 
			's_map_location' => $this->db->escape_str($s_address->complete_address), 
			'shipping_instruction' => $this->db->escape_str($this->input->post('instruction')),
			'order_type' => 1, 
			'date_added' => $this->db->escape_str($this->input->post('date_added')), 
			'date_modified' => CURRENT_TIME,  
			'associate_id' => (int)$this->admin->getId(), 
			'order_status_id' => '1', 
			'ip' => $_SERVER['REMOTE_ADDR'], 
			'quotation_expiry_date' => $expiry_date
		);
		$query = $this->db->insert('quotation',$data);
		$order_id = $this->db->insert_id();
		if($query){
			$quotation_number = str_pad($order_id, 6, 0, STR_PAD_LEFT);
			$this->db->query("UPDATE quotation SET quotation_no = '" . $this->db->escape_str($quotation_number) . "', date_modified = '".CURRENT_TIME."' WHERE id = '". (int)$order_id ."'");
			return $order_id;
		}else{
			return false;
		}
	}
	
	function updateOrderInfo(){
		$q_date = $this->input->post('date_added');
		$id = $this->input->post('quote_id');
		$address_id = $this->input->post('address_id');
		$customer_id = $this->input->post('customer_id');
		$expiry_date = date('Y-m-d', strtotime($q_date. ' + 15 days'));
		//print_r($expiry_date);exit();
		$c_detail = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$customer_id . "'")->row();
		$c_info = $this->db->query("SELECT * FROM customer_info WHERE user_id = '" . (int)$c_detail->id . "'")->row();
		$s_address = $this->db->query("SELECT * FROM corporate_address WHERE (customer_id = '" . (int)$customer_id . "' AND id = '" . (int)$address_id . "')")->row();

		$data = array(
			'customer_id' => (int)$c_detail->id, 
			'name' => $this->db->escape_str($c_detail->name), 
			'mobile' => $this->db->escape_str($c_detail->mobile), 
			'email' => $this->db->escape_str($c_detail->email), 
			'c_role' => $this->db->escape_str($c_detail->role_id), 
			'c_vat' => $this->db->escape_str($c_detail->vat_no), 
			'c_company' => $this->db->escape_str($c_detail->company_name), 
			'building_no' => $this->db->escape_str($c_info->building_no), 
			'street_name' => $this->db->escape_str($c_info->street_name), 
			'district_name' => $this->db->escape_str($c_info->district), 
			'city_name' => $this->db->escape_str($c_info->city), 
			'zip_code' => $this->db->escape_str($c_info->postal_code), 
			'additional_no' => $this->db->escape_str($c_info->additional_no), 
			'unit_no' => $this->db->escape_str($c_info->unit_no), 
			'country' => $this->db->escape_str($c_info->country), 
			'payment_method' => $this->db->escape_str($this->input->post('payment_method')), 
			'payment_code' => '', 
			'shipping_code' => '', 
			'address_id' => $this->db->escape_str($s_address->id), 
			's_email' => $this->db->escape_str($s_address->email), 
			's_mobile' => $this->db->escape_str($s_address->mobile), 
			's_phone' => $this->db->escape_str($s_address->phone), 
			's_extension' => $this->db->escape_str($s_address->extension), 
			's_reference' => $this->db->escape_str($s_address->reference), 
			's_person_name' => $this->db->escape_str($s_address->person_name), 
			's_address_label' => $this->db->escape_str($s_address->address_label), 
			's_address_type' => $this->db->escape_str($s_address->address_type), 
			's_building_villa_no' => $this->db->escape_str($s_address->building_villa_no), 
			's_street' => $this->db->escape_str($s_address->street), 
			's_city' => $this->db->escape_str($s_address->city),  
			's_country' => $this->db->escape_str($s_address->country), 
			's_postal' => $this->db->escape_str($s_address->postal), 
			'shipping_lat' => $this->db->escape_str($s_address->shipping_lat), 
			'shipping_lng' => $this->db->escape_str($s_address->shipping_lng), 
			'shipping_place_id' => $this->db->escape_str($s_address->shipping_place_id), 
			's_map_location' => $this->db->escape_str($s_address->complete_address), 
			'shipping_instruction' => $this->db->escape_str($this->input->post('instruction')),
			'order_type' => 1, 
			'date_added' => $this->db->escape_str($this->input->post('date_added')), 
			'date_modified' => CURRENT_TIME,  
			'associate_id' => (int)$this->admin->getId(), 
			'order_status_id' => '1', 
			'ip' => $_SERVER['REMOTE_ADDR'], 
			'quotation_expiry_date' => $expiry_date
		);
		$this->db->where('id', $id);
		$query = $this->db->update('quotation', $data);
		return $query;
	}

	function get_search_hint($term){
		$data = array();
		$search_term = $this->db->escape_str($term);
		$this->db->select('s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku, p.b2b_availability');
		$this->db->from('product_size s');
		$this->db->join('product p', 's.product_id = p.id', 'left');
		$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
		$this->db->where('p.b2b_availability', 'yes');
		$this->db->where('p.is_deleted', '0');
		$this->db->where('s.is_deleted', '0');
		$this->db->where("(s.product_sku LIKE '%".$search_term."%' OR p.parent_sku LIKE '%".$search_term."%' OR s.barcode LIKE '%".$search_term."%' OR p.name LIKE '%".$search_term."%' OR p.name_ar LIKE '%".$search_term."%')", NULL, FALSE);
		$query = $this->db->get()->result();
		foreach($query as $pdata){
			//$sql = $this->db->query("SELECT ps.barcode FROM product_size ps WHERE ps.product_id = '" . (int)$pdata->id . "'")->row();
			if($pdata->size_id > 0){
				$data[] = array("id" => $pdata->product_id,
							"prod_id" => $pdata->product_id,
							"name" => $pdata->name,
							"name_arabic" => $pdata->name_ar,
							"image" => $pdata->image,
							"sku" => $pdata->parent_sku .'-'. $pdata->product_sku,
							"parent_sku" => $pdata->parent_sku,
							"seller_sku" => $pdata->seller_sku,
							"size_id" => $pdata->size_id,
							"unit" => $pdata->size_unit,
							"unit_name" => $pdata->unit_name,
							"barcode" => $pdata->barcode);
			}
		}
		return $data;
	}
	
	function get_order($id){
		$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, ad.name as associate_name, ad.username as associate_username, om.order_image FROM `quotation` o LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) WHERE o.id = '" . (int)$id . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM quotation_product WHERE quotation_id = '" . (int)$id . "' ORDER BY id ASC")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}
	
	function check_duplicate($id,$product_id){
		$query = $this->db->query("SELECT * FROM quotation_product WHERE quotation_id = '" . (int)$id . "' AND product_id = '" . (int)$product_id . "'");
		$count = $query->num_rows();
		if($count > 0){
			return true;
		}else{
			return false;
		}
	}
	
	function add_to_quotation(){
		$total = 0;
		$order_total = 0;
		$total_cashback = 0;
		$net_payble_amt = 0;
		$rewards_applied = 0;
		$wallet_applied = 0;
		$vat_rate = 15;
		$promo_code = 'N/A';
		$promo_code_name = 'N/A';
		$promo_code_price = 0;

		$order_id = $this->input->post('order_id');
		$size_id = $this->input->post('size_id');
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		
		$order_info = $this->db->query("SELECT * FROM quotation o WHERE o.id = '". $order_id ."'")->row();
		
		$prev_total = $order_info->net_payble_amt;
		$prev_shipping = $order_info->shipping_charge;
		$prev_promo_code = $order_info->promo_code;
		$prev_promo_price = $order_info->promo_code_price;
		$prev_rewards = $order_info->cashback_applied;
		$prev_wallet = $order_info->wallet_applied;
		
		$product_detail = $this->db->query("SELECT p.image,p.name as product_name,p.name_ar as arabic_name, p.parent_sku,mb.brand_name FROM product p LEFT JOIN master_brands mb ON (p.brand_id = mb.id) WHERE p.id = '". $product_id ."'")->row();	
		$product_size_detail = $this->db->query("SELECT pp.discounted_price,IF(pp.discounted_price > 0, pp.discounted_price, pp.price) as price, pp.barcode, pp.size, pp.product_sku, mu.unit_name, pp.seller_sku, pp.cashback, pp.cashback_expiry, pp.price as real_price FROM product_size pp LEFT JOIN master_unit mu ON (pp.size_unit = mu.id) WHERE pp.id = '" . $size_id . "'")->row();	
		//print_r($size_id);exit();
		$discounted_price = $product_size_detail->discounted_price;
		if($discounted_price > 0){
			$order_price = $discounted_price * $quantity;
		}else{
			$order_price = $product_size_detail->price * $quantity;
		}	
		$today = date("Y-m-d");
		$expire = $product_size_detail->cashback_expiry; //from database
		
		$today_time = strtotime($today);
		$expire_time = strtotime($expire);
		
		//echo $expire_time;exit();
		if ($expire_time > $today_time) { 
			$total_cashback += $product_size_detail->cashback;
			//echo $total_cashback;exit();
		}
		
		$base_price = round((($order_price * 100) / 115),2);
		$vat_price = round(($order_price - $base_price),2);
		$productname = $product_detail->product_name;
		
		$this->db->query("INSERT INTO quotation_product SET quotation_id = '" . (int)$order_id . "', product_id = '" . (int)$product_id . "', product_name = '" . $this->db->escape_str($product_detail->product_name) . "', seller_sku = '" . $this->db->escape_str($product_size_detail->seller_sku) . "', arabic_name = '" . $this->db->escape_str($product_detail->arabic_name) . "', gst_rate = '" . $this->db->escape_str($vat_rate) . "', vat_price = '" . $this->db->escape_str($vat_price) . "', barcode = '" . $this->db->escape_str($product_size_detail->barcode) . "', product_brand = '" . $this->db->escape_str($product_detail->brand_name) . "', size = '" . $this->db->escape_str($product_size_detail->size) . $product_size_detail->unit_name . "', size_id = '" . (int)$size_id . "', quantity = '" . $this->db->escape_str($quantity) . "', real_price = '" . $this->db->escape_str($product_size_detail->real_price) . "', discounted_price = '" . $this->db->escape_str($discounted_price) . "', order_price = '" . $this->db->escape_str($order_price) . "', product_sku = '" . $product_detail->parent_sku .'-'. $product_size_detail->product_sku . "', product_image = '" . $this->db->escape_str($product_detail->image) . "'");
		
		$total = $prev_total + $order_price;
		//
		$total_vat_price = round((($total * 100) / 115),2);
		if($prev_promo_price > 0){
    		//$prs = $this->check_Coupan($prev_promo_code,$total);
			$prs = '';
    		$promo_code = $prs['code'];
    		$promo_code_name = $prs['name'];
    		$promo_code_price = $prs['discount_amount'];
		}
		$order_total = $total - $promo_code_price;
		
		//$shipping = 50;
		//$shipping = $this->customer->getShipping($order_total);
		$shipping = 0;
		$order_total += $shipping;
		$net_payble_amt = $order_total;
		if($prev_rewards > 0){
			$rewards_applied = $prev_rewards;
			$net_payble_amt = $order_total - $rewards_applied;
		}
		if($prev_wallet > 0){
			$wallet_applied = $prev_wallet;
		}
					
		$net_payble_amt = $net_payble_amt - $wallet_applied;
		
		$query = $this->db->query("UPDATE quotation SET shipping_charge = '" . $shipping . "', total_vat = '" . $total_vat_price . "', item_total_price = '" . (float)$total . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', total_cashback = '" . (float)$total_cashback . "', cashback_applied = '" . (float)$rewards_applied . "', wallet_applied = '" . (float)$wallet_applied . "', promo_code = '" . $this->db->escape_str($promo_code) . "', promo_code_name = '" . $this->db->escape_str($promo_code_name) . "', promo_code_price = '" . (float)$promo_code_price . "' WHERE id = '" . (int)$order_id . "'");
		
		return $query;
	}
	
	function update_quotation(){
		$total = 0;
		$order_total = 0;
		$total_cashback = 0;
		$net_payble_amt = 0;
		$rewards_applied = 0;
		$wallet_applied = 0;
		$vat_rate = 15;
		$promo_code = 'N/A';
		$promo_code_name = 'N/A';
		$promo_code_price = 0;
		
		$order_id = $this->input->post('order_id');
		$query = '';
    	if(!empty($order_id)){
			$this->db->trans_start();
        	$this->db->trans_strict(FALSE);	

    		$order_info = $this->db->query("SELECT * FROM quotation o WHERE o.id = '". $order_id ."'")->row();
    		
    		$prev_total = $order_info->net_payble_amt;
			$prev_shipping = $order_info->shipping_charge;
			$prev_promo_code = $order_info->promo_code;
			$prev_promo_price = $order_info->promo_code_price;
			$prev_rewards = $order_info->cashback_applied;
			$prev_wallet = $order_info->wallet_applied;
    		if($order_info->quotation_status !== 'accept'){
				if($this->input->post('product_id')){
					$this->db->query("DELETE FROM quotation_product WHERE quotation_id = '" . (int)$order_id . "'");
					$product_count = count($this->input->post('product_id'));
					for($p=0;$p<$product_count;$p++){
						$size_id = $this->input->post('size_id');
						$product_id = $this->input->post('product_id');
						$quantity = $this->input->post('quantity');
						$price = $this->input->post('price');
						$seller_sku = $this->input->post('seller_sku');
						$barcode = $this->input->post('barcode');
						$size = $this->input->post('size');
						$product_sku = $this->input->post('product_sku');
						
						$product_detail = $this->db->query("SELECT p.image, p.name as product_name, p.name_ar as arabic_name, p.parent_sku, p.main_category, p.brand_id, mb.brand_name FROM product p LEFT JOIN master_brands mb ON (p.brand_id = mb.id) WHERE p.id = '". $product_id[$p] ."'")->row();	
						$product_size_detail = $this->db->query("SELECT pp.discounted_price,IF(pp.discounted_price > 0, pp.discounted_price, pp.price) as price, pp.barcode, pp.size, pp.product_sku, mu.unit_name, pp.seller_sku, pp.cashback, pp.cashback_expiry, pp.price as real_price FROM product_size pp LEFT JOIN master_unit mu ON (pp.size_unit = mu.id) WHERE pp.id = '" . $size_id[$p] . "'")->row();	
						//print_r($product_size_detail);
						$discounted_price = 0;
						$order_price = $price[$p] * $quantity[$p];
						
						$today = date("Y-m-d");
						//$expire = $product_size_detail->cashback_expiry; //from database
						$expire = 0; //from database
						
						$today_time = strtotime($today);
						$expire_time = strtotime($expire);
						
						//echo $expire_time;exit();
						if ($expire_time > $today_time) { 
							$total_cashback += 0;
							//echo $total_cashback;exit();
						}
						
						$base_price = round((($order_price * 100) / 115),2);
						$vat_price = round(($order_price - $base_price),2);
						
						$product = array(
							'quotation_id' => (int)$order_id, 
							'product_id' => (int)$product_id[$p], 
							'product_name' => $this->db->escape_str($product_detail->product_name), 
							'category_id' => $this->db->escape_str($product_detail->main_category), 
							'product_brand' => $this->db->escape_str($product_detail->brand_name), 
							'brand_id' => $this->db->escape_str($product_detail->brand_id), 
							'arabic_name' => $this->db->escape_str($product_detail->arabic_name), 
							'gst_rate' => $this->db->escape_str($vat_rate), 
							'vat_price' => $this->db->escape_str($vat_price), 
							'seller_sku' => $this->db->escape_str($seller_sku[$p]), 
							'barcode' => $this->db->escape_str($barcode[$p]), 
							'size' => $this->db->escape_str($size[$p]), 
							'size_id' => (int)$size_id[$p], 
							'quantity' => $this->db->escape_str($quantity[$p]), 
							'real_price' => $this->db->escape_str($price[$p]), 
							'discounted_price' => $this->db->escape_str($discounted_price), 
							'order_price' => $this->db->escape_str($order_price), 
							'product_sku' => $this->db->escape_str($product_sku[$p]), 
							'product_image' => $this->db->escape_str($product_detail->image)
						);
						$this->db->insert('quotation_product',$product);
					}
					$order_price_sum = $this->db->query("SELECT SUM(order_price) as total FROM quotation_product WHERE quotation_id = '" . (int)$order_id . "'")->row();	
					$total = $order_price_sum->total;
					//print_r($total);exit();
					$total_vat_price = round((($total * 100) / 115),2);
					if($prev_promo_price > 0){
						//$prs = $this->check_Coupan($prev_promo_code,$total);
						$prs = '';
						$promo_code = $prs['code'];
						$promo_code_name = $prs['name'];
						$promo_code_price = $prs['discount_amount'];
					}
					$order_total = $total;
					
					//$shipping = $this->customer->getShipping($order_total);
					$shipping = 0;
					$order_total += $shipping;
					$net_payble_amt = $order_total;
					if($prev_rewards > 0){
						$rewards_applied = $prev_rewards;
						$net_payble_amt = $order_total - $rewards_applied;
					}
					if($prev_wallet > 0){
						$wallet_applied = $prev_wallet;
					}
					
					$net_payble_amt = $net_payble_amt - $wallet_applied;
					
					$query = $this->db->query("UPDATE quotation SET shipping_charge = '" . $shipping . "', total_vat = '" . $total_vat_price . "', item_total_price = '" . (float)$total . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', total_cashback = '" . (float)$total_cashback . "', cashback_applied = '" . (float)$rewards_applied . "', wallet_applied = '" . (float)$wallet_applied . "', promo_code = '" . $this->db->escape_str($promo_code) . "', promo_code_name = '" . $this->db->escape_str($promo_code_name) . "', promo_code_price = '" . (float)$promo_code_price . "' WHERE id = '" . (int)$order_id . "'");
				}
			}else{
				return false;
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
			} else {
				$this->db->trans_commit();
				return TRUE;
			}
	    }
		return $query;
	}
	
	function convert_order($data,$date_slot,$time_slot,$po_number,$po_date,$payment_method){
		$trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		//echo '<pre>';print_r($data['result']['product']);exit();
		$insertData = array(
			'customer_id' => (int)$data['result']['order']['customer_id'],
			'staff_id' => (int)$data['result']['order']['staff_id'],
			'associate_id' => (int)$data['result']['order']['associate_id'],
			'email' => $data['result']['order']['email'], 
			'name' => $this->db->escape_str($data['result']['order']['name']), 
			'mobile' => $this->db->escape_str($data['result']['order']['mobile']), 
			'building_no' => $this->db->escape_str($data['result']['order']['building_no']), 
			'street_name' => $this->db->escape_str($data['result']['order']['street_name']), 
			'district_name' => $this->db->escape_str($data['result']['order']['district_name']), 
			'city_name' => $this->db->escape_str($data['result']['order']['city_name']), 
			'zip_code' => $this->db->escape_str($data['result']['order']['zip_code']), 
			'additional_no' => $this->db->escape_str($data['result']['order']['additional_no']), 
			'unit_no' => $this->db->escape_str($data['result']['order']['unit_no']), 
			'country' => $this->db->escape_str($data['result']['order']['country']), 
			'c_role' => $this->db->escape_str($data['result']['order']['c_role']), 
			'c_vat' => $this->db->escape_str($data['result']['order']['c_vat']), 
			'c_company' => $this->db->escape_str($data['result']['order']['c_company']), 
			'payment_method' => $this->db->escape_str($payment_method), 
			'payment_code' => '',
			'shipping_email' => $this->db->escape_str($data['result']['order']['s_email']), 
			'shipping_person_name' => $this->db->escape_str($data['result']['order']['s_person_name']), 
			'villa_building' => $this->db->escape_str($data['result']['order']['s_address_type']), 
			'shipping_house_no' => $this->db->escape_str($data['result']['order']['s_building_villa_no']), 
			'shipping_street' => $this->db->escape_str($data['result']['order']['s_street']), 
			'shipping_sector' => '', 
			'shipping_locality' => '', 
			'shipping_city' => $this->db->escape_str($data['result']['order']['s_city']), 
			'shipping_state' => $this->db->escape_str($data['result']['order']['s_state']), 
			'shipping_country' => $this->db->escape_str($data['result']['order']['s_country']), 
			'shipping_postcode' => $this->db->escape_str($data['result']['order']['s_postal']), 
			'shipping_lat' => $this->db->escape_str($data['result']['order']['shipping_lat']), 
			'shipping_lng' => $this->db->escape_str($data['result']['order']['shipping_lng']), 
			'shipping_place_id' => $this->db->escape_str($data['result']['order']['shipping_place_id']), 
			'shipping_complete_address' => $this->db->escape_str($data['result']['order']['s_map_location']), 
			'shipping_instruction' => $this->db->escape_str($data['result']['order']['shipping_instruction']), 
			'quotation_no' => $this->db->escape_str($data['result']['order']['id']), 
			'shipping_addrstype' => $this->db->escape_str($data['result']['order']['s_address_label']), 
			'shipping_date_slot' => $date_slot, 
			'shipping_time_slot' => $time_slot, 
			'contactless' =>  '',
			'shipping_mobile' => $this->db->escape_str($data['result']['order']['s_mobile']), 
			'shipping_method' => '', 
			'shipping_code' => '', 
			'shipping_charge' => 0, 
			'item_total_price' => (float)$data['result']['order']['item_total_price'], 
			'promo_code' => '',    
			'promo_code_name' => '',   
			'promo_code_price' => '',  
			'order_total' => (float)$data['result']['order']['order_total'], 
			'total_vat' => $data['result']['order']['total_vat'], 
			'net_payble_amt' => (float)$data['result']['order']['net_payble_amt'], 
			'order_status_id' => '1',
			'trans_id' => $trans_id, 
			'po_number' => $po_number, 
			'po_date' => $po_date, 
			'ip' => $_SERVER['REMOTE_ADDR'], 
			'date_added' => CURRENT_TIME, 
			'date_modified' => CURRENT_TIME
		);
		if($insertData){
			$query = $this->db->insert('orders',$insertData);
		}
		
		$order_id = $this->db->insert_id();
		if($order_id){
			if($order_id > 0){
				$order_number = str_pad($order_id, 6, 0, STR_PAD_LEFT);
				$this->db->query("UPDATE orders SET order_no = '" . $this->db->escape_str($order_number) . "', date_modified = now() WHERE id = '". (int)$order_id ."'");
			}
			foreach($data['result']['product'] as $cart){
				$product = array(
					'order_id' => (int)$order_id,
					'product_id' => (int)$cart['product_id'],
					'category_id' => $cart['category_id'],
					'brand_id' => $cart['brand_id'],
					'product_brand' => $this->db->escape_str($cart['product_brand']),
					'product_name' => $this->db->escape_str($cart['product_name']), 
					'short_name' => $this->db->escape_str($cart['short_name']), 
					'arabic_name' => $this->db->escape_str($cart['arabic_name']), 
					'gst_rate' => $this->db->escape_str($cart['gst_rate']), 
					'vat_price' => $this->db->escape_str($cart['vat_price']), 
					'barcode' => $this->db->escape_str($cart['barcode']), 
					'size' => $this->db->escape_str($cart['size']), 
					'size_id' => (int)$cart['size_id'], 
					'quantity' => $this->db->escape_str($cart['quantity']), 
					'real_price' => $this->db->escape_str($cart['real_price']), 
					'discounted_price' => $this->db->escape_str($cart['discounted_price']), 
					'order_price' => $this->db->escape_str($cart['order_price']), 
					'gift_value' => $this->db->escape_str($cart['gift_value']), 
					'product_sku' => $this->db->escape_str($cart['product_sku']), 
					'seller_sku' => $this->db->escape_str($cart['seller_sku']), 
					'product_image' => $this->db->escape_str($cart['product_image'])
				);
				$this->db->insert('order_product',$product);
			}
		}
		return $order_id;
	}
	
	function get_time_slots($date_slot){
		$current_time = date("H:i", strtotime('+3 hours'));
		$current_date = date('Y-m-d');
		//$sel_date_slot = date('Y-m-d', $date_slot);
		//print_r($current_time);exit();
		if($date_slot == $current_date){
			$query = $this->db->query("SELECT * FROM `delivery_time_slots` WHERE `time_from` > '" . $current_time . "' AND status = '1' ORDER BY slot_order ASC");
		}else{
			$query = $this->db->query("SELECT * FROM `delivery_time_slots` WHERE status = '1' ORDER BY slot_order ASC");
		}
		return $query->result();
	}
	
	function set_status_converted($id,$payment_method){
		$query = $this->db->query("UPDATE quotation SET order_status_id = '2', payment_method = '" . $this->db->escape_str($payment_method) . "', quotation_status = 'converted' WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function updateStock($id){
		$query = $this->db->query("SELECT * FROM orders WHERE id = '" . $id . "'")->row();
		if($query){
			$purchaseItems = $this->db->query("SELECT product_id, size_id, barcode, order_id, quantity FROM order_product WHERE order_id = '" . (int)$query->id . "'")->result_array();
			if(count($purchaseItems) > 0){
				foreach($purchaseItems as $item){
				    $size_id = $item['size_id'];
					$quantity = $item['quantity'];
					$product = $this->db->query("SELECT stock FROM product_stock ps WHERE ps.size_id = '" . $size_id . "'")->row_array();
					if(!empty($product)){
    					$avl_qty = $product['stock'];
    					$final_qty = $avl_qty - $quantity;
    					$query2 = $this->db->query("UPDATE product_stock SET stock = '" . $final_qty . "' WHERE size_id = '" . $size_id . "'");
					}
				}
			}
			return true;
		}else{
			return false;
		}
	}

	function checkAccount($userid){
		$query = $this->db->query("SELECT credit_account FROM customer WHERE id = '" . (int)$userid . "'")->row();
		if($query->credit_account == '2'){
			return true;
		}else{
			return false;
		}
	}

	function checkCreditBal($userid){
		$query = $this->db->query("SELECT credit_avilable FROM credit_account WHERE user_id = '" . (int)$userid . "'")->row();
		return $query;
	}

	function credit_update($data,$po_number){
		if($data->net_payble_amt > 0){
			$query = $this->db->query("SELECT credit_avilable, account_no, credit_days FROM credit_account WHERE user_id = '" . (int)$data->customer_id . "'")->row();
			$account_no = $query->account_no;
			$credit_amt = $query->credit_avilable;
			$current_amt = $credit_amt - $data->net_payble_amt;
			$credit_days = $query->credit_days;
			$current_date = strtotime(CURRENT_TIME);
			$date_final = strtotime("+". $credit_days ." day", $current_date);
			$overdue_on = date('Y-m-d', $date_final);
			$remarks = 'Amount debited for Order No. '. $data->invoice_prefix .'-'. $data->order_no;
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', updated_at = NOW() WHERE user_id = '" . (int)$data->customer_id . "'");
			$this->db->query("INSERT INTO credit_account_report SET order_id =  '" . $data->id . "', invoice_no =  '". $data->order_no ."', trans_id =  '" . $data->trans_id . "', avl_bal =  '" . $data->net_payble_amt . "', debit =  '" . $data->net_payble_amt . "', account_no =  '" . $account_no . "', trnx_for =  'INV', po_no =  '" . $po_number . "', remarks =  '" . $remarks . "', credit =  0, trans_type =  'debit', user_id =  '" . (int)$data->customer_id . "', created_at = NOW()");
		}
		return true;
	}

	function get_address($userid){
		$query = $this->db->query("SELECT * FROM corporate_address WHERE customer_id = '" . (int)$userid . "'")->result();
		return $query;
	}

	function get_address_detail($id){
		$query = $this->db->query("SELECT * FROM corporate_address WHERE id = '" . (int)$id . "'")->row();
		return $query;
	}

	function set_quotation_status(){
		$query = $this->db->query("UPDATE quotation SET quotation_status = '" . $this->db->escape_str($this->input->post('quotation_status')) . "' WHERE id = '" . (int)$this->input->post('quotation_id') . "' LIMIT 1");
		return $query;
	}
}
