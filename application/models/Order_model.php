<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Order_model extends CI_Model{
	
	function get_order($id){
		$query = $this->db->query("SELECT * FROM `orders` WHERE id = '" . $id . "'")->row_array();
		//'<pre>';print_r($query);'</pre>';exit();
		return $query;
	}
	
	function get_wishlist(){
		$query = $this->db->query("SELECT w.id as wishlist_id, p.*, ps.*, (SELECT SUM(quantity) FROM product_size pt WHERE pt.product_id = p.id) as quantity FROM wishlist w LEFT JOIN product p ON(w.product_id = p.id) JOIN (SELECT id as size_id, discounted_price, price, product_id, (price - discounted_price)/price * 100 as percent FROM product_size pp GROUP BY product_id ORDER BY percent DESC, price ASC) ps ON ( ps.product_id = p.id ) WHERE w.customer_id = '" . (int)$this->customer->getCorporateId() . "'");
		return $query;
	}
	
	function is_wishlist($product_id){
		$query = $this->db->query("SELECT id FROM wishlist WHERE customer_id = '" . (int)$this->customer->getCorporateId() . "' AND product_id = '" . (int)$product_id . "'");
		return $query->num_rows();
	}
	
	function add_wishlist($id){
		if($this->is_wishlist($id) > 0){
			return true;
		}else{
			$query = $this->db->query("INSERT INTO wishlist SET customer_id = '" . (int)$this->customer->getCorporateId() . "', product_id = '" . (int)$id . "', created = NOW()");
			return $query;
		}
	}
	
	function remove_wishlist($id){
		$query = $this->db->query("DELETE FROM wishlist WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_personal(){
		$query = $this->db->query("SELECT name, mobile, email, company_name, company_arabic_name, rewards, wallet, credit_account, ci.*, mc.city_name FROM customer LEFT JOIN customer_info ci ON (customer.id = ci.user_id) LEFT JOIN master_city mc ON (ci.city = mc.id) WHERE customer.id = '" . (int)$this->customer->getCorporateId() . "'");
		return $query;
	}
	
	function is_cart($product_id, $size_id){
		$query = $this->db->query("SELECT id FROM cart WHERE (customer_id = '" . (int)$this->customer->getCorporateId() . "' AND customer_id != 0 AND staff_id = '" . (int)$this->customer->getId() . "') AND product_id = '" . (int)$product_id . "' AND size_id = '" . (int)$size_id . "'");
		return $query;
	}
	
	function add_to_cart($data = array()){
		if($this->is_cart($data['product_id'], $data['size_id'])->num_rows() > 0){
			$this->db->query("DELETE FROM cart WHERE id = '" . (int)$this->is_cart($data['product_id'],$data['size_id'])->row()->id . "'");
			if($data['quantity'] == '0' || $data['quantity'] == ''){
				//$this->db->query("DELETE FROM cart WHERE id = '" . (int)$this->is_cart($data['product_id'],$data['size_id'])->row()->id . "'");
				//$query = $this->update_cart($this->is_cart($data['product_id'], $data['size_id'])->row()->id, $data['quantity']);
				return 3;
			}else{
				$query = $this->db->query("INSERT INTO cart SET session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "', customer_id = '" . (int)$this->customer->getCorporateId() . "', staff_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$data['product_id'] . "', quantity = '" . (int)$data['quantity'] . "', size_id = '" . (int)$data['size_id'] . "', created = NOW()");
				return $this->is_cart($data['product_id'],$data['size_id'])->row()->id;
			}
		}else{
			if($data['quantity'] > 0 && $data['quantity'] !== ''){
				$query = $this->db->query("INSERT INTO cart SET session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "', customer_id = '" . (int)$this->customer->getCorporateId() . "', staff_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$data['product_id'] . "', quantity = '" . (int)$data['quantity'] . "', size_id = '" . (int)$data['size_id'] . "', created = NOW()");
				return $this->db->insert_id();
			}else{
				return 2;
			}
		}
	}
	
	function remove_cart($id){
		$q = $this->db->query("SELECT * FROM cart WHERE id = '" . (int)$id . "'")->row();
		$data['product_id'] = $q->product_id;
		$data['size_id'] = $q->size_id;
		$query = $this->db->query("DELETE FROM cart WHERE id = '" . (int)$id . "'");
		return $data;
	}

	function remove_all_cart(){
		$query = $this->db->query("DELETE FROM cart WHERE customer_id = '" . (int)$this->customer->getCorporateId() . "' AND staff_id = '" . (int)$this->customer->getId() . "'");
		return $query;
	}
	
	function update_cart($id, $quantity){
		$query = $this->db->query("UPDATE cart SET quantity = '" . (int)$quantity . "' WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function gift_products($id){
		$query = $this->db->query("SELECT p.name,p.name_hindi,p.seo, p.image, p.cod_available, ps.* FROM product p JOIN (SELECT id as size_id, price as real_price, size, IF(discounted_price > 0, discounted_price, price) as price, product_id, (price - discounted_price) / price * 100 AS percent FROM product_size pp)ps ON ( ps.product_id = p.id ) WHERE (p.id = '" . (int)$id . "')");
		return $query;
	}
	
	function cart_products(){
		$query = $this->db->query("SELECT c.* , ps.*, mu.unit_name, p.name,p.name_ar, p.image, p.cod_available, p.parent_sku, p.is_deleted, p.status, p.b2b_availability FROM cart c LEFT JOIN product p ON ( p.id = c.product_id ) JOIN (SELECT id as size_id, size_unit, barcode, product_sku, price as real_price, size, IF(discounted_price > 0, discounted_price, price) as price, product_id, (price - discounted_price) / price * 100 AS percent FROM product_size pp)ps ON ( ps.size_id = c.size_id ) LEFT JOIN master_unit mu ON (ps.size_unit = mu.id) WHERE (c.customer_id = '" . (int)$this->customer->getCorporateId() . "' AND c.customer_id != 0) AND staff_id = '" . (int)$this->customer->getId() . "'");
		return $query;
	}
	
	function exist_quantity($id){
		$query = $this->db->query("SELECT p.quantity as quantity FROM product_size p LEFT JOIN cart c ON(p.id = c.size_id) WHERE c.id = '" . (int)$id . "'")->row();
		return $query->quantity;
	}
	
	function set_promotion($code){
		$query = $this->db->query("SELECT * FROM coupon WHERE code = '" . $this->db->escape_str($code) . "' AND date_start < NOW() AND date_end > NOW()");
		return $query;
	}
	
	function get_addresses(){
		$query = $this->db->query("SELECT a.* FROM corporate_address a WHERE a.customer_id = '" . (int)$this->customer->getCorporateId() . "'");
		return $query;
	}
	
	function get_time_slots($date_slot){
		$current_time = date("H:i", strtotime('+3 hours'));
		$current_date = date('Y-m-d');
		//print_r($current_time);exit();
		if($date_slot == $current_date){
			$query = $this->db->query("SELECT * FROM `delivery_time_slots` WHERE `time_from` > '" . $current_time . "' AND status = '1' ORDER BY slot_order ASC");
		}else{
			$query = $this->db->query("SELECT * FROM `delivery_time_slots` WHERE status = '1' ORDER BY slot_order ASC");
		}
		return $query->result();
	}
	
	function get_addressesby_id($address_id){
		$query = $this->db->query("SELECT a.* FROM corporate_address a WHERE a.id = '" . (int)$address_id . "'");
		return $query;
	}
	
	public function get_rewards(){
		$query = $this->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
		$rewards_amt = $query->rewards;
		if($rewards_amt > 5){
			return 5;
		}else{
			return $rewards_amt;
		}
	}
	
	public function get_wallet($order_total){
		$query = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
		$wallet_amt = $query->wallet;
		if($wallet_amt >= $order_total){
			return $order_total;
		}else{
			return $wallet_amt;
		}
	}
	
	function createOrder(){
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

		$q_date = CURRENT_TIME;
		$expiry_date = date('Y-m-d', strtotime($q_date. ' + 15 days'));
		$c_detail = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
		$c_info = $this->db->query("SELECT * FROM customer_info WHERE user_id = '" . (int)$c_detail->id . "'")->row();
		$s_address = $this->db->query("SELECT * FROM corporate_address WHERE (customer_id = '" . (int)$this->customer->getCorporateId() . "' AND id = '" . $this->input->post('delivery_address_id') . "')")->row();
		$carts = $this->db->query("SELECT c.* FROM cart c WHERE (c.customer_id = '" . (int)$this->customer->getCorporateId() . "' AND c.staff_id = '" . (int)$this->customer->getId() . "' AND c.customer_id != '0')");
		//print_r($this->input->post('delivery_address_id'));exit();
		if($carts->num_rows() && !empty($s_address)){	
			$data = array(
				'customer_id' => (int)$c_detail->id,
				'staff_id' => (int)$this->customer->getId(),
				'customer_po_ref' => $this->db->escape_str($this->input->post('po_number')), 
				'customer_note' => $this->db->escape_str($this->input->post('customer_note')), 
				'email' => $c_detail->email, 
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
				'payment_method' => '', 
				'payment_code' => '', 
				'shipping_code' => '', 
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
				'shipping_instruction' => '',
				'order_type' => 1, 
				'date_added' => CURRENT_TIME, 
				'date_modified' => CURRENT_TIME,  
				'associate_id' => 0, 
				'order_status_id' => '1', 
				'ip' => $_SERVER['REMOTE_ADDR'], 
				'quotation_expiry_date' => $expiry_date
			);
			$query = $this->db->insert('quotation',$data);
			$order_id = $this->db->insert_id();
			if($query){
				$quotation_number = str_pad($order_id, 6, 0, STR_PAD_LEFT);
				
				$order_info = $this->db->query("SELECT * FROM quotation o WHERE o.id = '". $order_id ."'")->row();
    		
				$prev_total = $order_info->net_payble_amt;
				$prev_shipping = $order_info->shipping_charge;
				$prev_promo_code = $order_info->promo_code;
				$prev_promo_price = $order_info->promo_code_price;
				$prev_rewards = $order_info->cashback_applied;
				$prev_wallet = $order_info->wallet_applied;
				
				foreach($carts->result() as $cart){
					$size_id = $cart->size_id;
    				$product_id = $cart->product_id;
    				$quantity = $cart->quantity;

					$product_detail = $this->db->query("SELECT p.image, p.name as product_name, p.name_ar as arabic_name, p.parent_sku, p.main_category, p.brand_id, mb.brand_name FROM product p LEFT JOIN master_brands mb ON (p.brand_id = mb.id) WHERE p.id = '". $product_id ."'")->row();	
					$product_size_detail = $this->db->query("SELECT pp.discounted_price,IF(pp.discounted_price > 0, pp.discounted_price, pp.price) as price, pp.barcode, pp.size, pp.product_sku, mu.unit_name, pp.seller_sku, pp.cashback, pp.cashback_expiry, pp.price as real_price FROM product_size pp LEFT JOIN master_unit mu ON (pp.size_unit = mu.id) WHERE pp.id = '" . $size_id . "'")->row();	
					//print_r($product_size_detail);exit();

					$order_price = $product_size_detail->price * $quantity;
					$discounted_price = 0;
    				
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
						'product_id' => (int)$product_id, 
						'product_name' => $this->db->escape_str($product_detail->product_name), 
						'category_id' => $this->db->escape_str($product_detail->main_category), 
						'product_brand' => $this->db->escape_str($product_detail->brand_name),
						'brand_id' => $this->db->escape_str($product_detail->brand_id), 
						'arabic_name' => $this->db->escape_str($product_detail->arabic_name), 
						'gst_rate' => $this->db->escape_str($vat_rate), 
						'vat_price' => $this->db->escape_str($vat_price), 
						'seller_sku' => $this->db->escape_str($product_size_detail->seller_sku), 
						'barcode' => $this->db->escape_str($product_size_detail->barcode), 
						'size' => $this->db->escape_str($product_size_detail->size) .' '. $product_size_detail->unit_name, 
						'size_id' => (int)$size_id, 
						'quantity' => $this->db->escape_str($quantity), 
						'real_price' => $this->db->escape_str($product_size_detail->price), 
						'discounted_price' => $this->db->escape_str($discounted_price), 
						'order_price' => $this->db->escape_str($order_price), 
						'product_sku' => $product_detail->parent_sku .'-'. $product_size_detail->product_sku, 
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
        		$order_total = $total - $promo_code_price;
        		
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
        		$query_final = $this->db->query("UPDATE quotation SET quotation_no = '" . $this->db->escape_str($quotation_number) . "', shipping_charge = '" . $shipping . "', total_vat = '" . $total_vat_price . "', item_total_price = '" . (float)$total . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', total_cashback = '" . (float)$total_cashback . "', cashback_applied = '" . (float)$rewards_applied . "', wallet_applied = '" . (float)$wallet_applied . "', promo_code = '" . $this->db->escape_str($promo_code) . "', promo_code_name = '" . $this->db->escape_str($promo_code_name) . "', promo_code_price = '" . (float)$promo_code_price . "', date_modified = '".CURRENT_TIME."' WHERE id = '" . (int)$order_id . "'");
				$final_data['query']=$query_final;
				$final_data['orderid']=$order_id;
				return $final_data;
			}else{
				return $final_data['query'] = false;
			}
		}else{
			return $final_data['query'] = false;
		}
	}

	function order_gift_from_wallet($wallet_checked){
		if(!$this->customer->isLogged()){
			redirect("/");
		}
		if($this->session->userdata("gift_detail")){
			$gift_detail = $this->session->userdata("gift_detail");
		}else{
			redirect("/");
		}
		$total = 0;
		$order_total = 0;
		$net_payble_amt = 0;
		$total_cashback = 0;
		$wallet_applied = 0;
		$vat_rate = 15;
		$promo_code = 'N/A';
		$promo_code_name = 'N/A';
		$promo_code_price = 0;
		$shipping_type = 0;
		$trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		
		if($this->customer->isLogged()){
			$c_info = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
			
			$this->db->query("INSERT INTO orders SET customer_id = '" . (int)$this->customer->getCorporateId() . "', email = '" . $c_info->email . "', name = '" . $this->db->escape_str($gift_detail['g_from']) . "', mobile = '" . $this->db->escape_str($c_info->mobile) . "', c_role = '" . $this->db->escape_str($c_info->role_id) . "', c_vat = '" . $this->db->escape_str($c_info->vat_no) . "', c_company = '" . $this->db->escape_str($c_info->company_name) . "', comment = '" . $this->db->escape_str($gift_detail['g_message']) . "', payment_method = '', payment_code = '', shipping_firstname = '" . $this->db->escape_str($gift_detail['recipient_name']) . "', shipping_email = '" . $this->db->escape_str($gift_detail['g_to']) . "', shipping_method = 'N/A', shipping_code = 'N/A', shipping_charge = '0', item_total_price = '" . (float)$total . "', promo_code = '" . $this->db->escape_str($promo_code) . "', promo_code_name = '" . $this->db->escape_str($promo_code_name) . "', promo_code_price = '" . (float)$promo_code_price . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', order_status_id = '0', trans_id = '" . $trans_id . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', date_added = NOW(), date_modified = NOW()");
		
		
			$order_id = $this->db->insert_id();
			$cart = $this->db->query("SELECT p.seo,p.image,p.name as product_name,p.short_name as short_name,p.name_hindi as arabic_name,p.sku, p.gift_value, pp.discounted_price, pp.price,pp.barcode,pp.size, pp.id as size_id, pp.price as real_price FROM product p LEFT JOIN product_size pp ON (p.id = pp.product_id) WHERE p.id = '" . (int)$gift_detail['gid'] . "'")->row();	
			
			if($cart->discounted_price == 0){
				$order_price = $cart->price * 1;
			}else{
				$order_price = $cart->discounted_price * 1;
			}
			$base_price = round((($order_price * 100) / 115),2);
			$vat_price = round(($order_price - $base_price),2);
			$productname=$cart->product_name;
			$this->db->query("INSERT INTO order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$gift_detail['gid'] . "', product_name = '" . $this->db->escape_str($cart->product_name) . "', short_name = '" . $this->db->escape_str($cart->short_name) . "', arabic_name = '" . $this->db->escape_str($cart->arabic_name) . "', gst_rate = '" . $this->db->escape_str($vat_rate) . "', vat_price = '" . $this->db->escape_str($vat_price) . "', barcode = '" . $this->db->escape_str($cart->barcode) . "', product_slug = '" . $this->db->escape_str($cart->seo) . "', size = '" . $this->db->escape_str($cart->size) . "', size_id = '" . (int)$cart->size_id . "', quantity = '1', real_price = '" . $this->db->escape_str($cart->real_price) . "', discounted_price = '" . $this->db->escape_str($cart->discounted_price) . "', order_price = '" . $this->db->escape_str($order_price) . "', gift_value = '" . $this->db->escape_str($cart->gift_value) . "', product_sku = '" . $this->db->escape_str($cart->sku) . "', product_image = '" . $this->db->escape_str($cart->image) . "'");
			
			$total = $total + $order_price;
			
			//$total_vat_price = ($vat_rate / 100) * $total;
			$total_vat_price = round((($total * 100) / 115),2);
			$order_total = $total - $promo_code_price;
			$shipping_method = "PAID";
			$shipping_code = "PAID";
			$shipping = 0;
			if($this->customer->isLogged()){
				if($wallet_checked > 0){
					$wallet_applied = $this->get_wallet($order_total);
					$net_payble_amt = $wallet_applied;
				}else{
					$net_payble_amt = $order_total;
				}
				$this->db->query("UPDATE orders SET shipping_method = '" . $shipping_method . "', shipping_code = '" . $shipping_method . "', shipping_charge = '" . $shipping . "', shipping_type = '" . $shipping_type . "', total_vat = '" . $total_vat_price . "', item_total_price = '" . (float)$total . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', total_cashback = '" . (float)$total_cashback . "', wallet_applied = '" . (float)$wallet_applied . "' WHERE id = '" . (int)$order_id . "'");
			}
			 
			/****Clear order history****/
			$this->session->unset_userdata("promotion_code");
			$data['details']=$gift_detail;
			$data['orderid']=$order_id;
			$data['trans_id']=$trans_id;
			$data['wallet_amt']= $wallet_applied;
			$data['cust_id']=(int)$this->customer->getCorporateId();
			$data['total'] = $order_total;
			$data['net_payble_amt'] = $net_payble_amt;
			//print_r($data);exit();
			return $data;
		}else{
			redirect("login");
		}
	}
	
	function order_gift($wallet_checked){
		if(!$this->customer->isLogged() AND !$this->session->userdata('gift_detail')){
			redirect("/");
		}
		$total = 0;
		$order_total = 0;
		$net_payble_amt = 0;
		$total_cashback = 0;
		$wallet_applied = 0;
		$vat_rate = 15;
		$promo_code = 'N/A';
		$promo_code_name = 'N/A';
		$promo_code_price = 0;
		$shipping_type = 0;
		$trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		
		if($this->session->userdata("gift_detail")){
			$gift_detail = $this->session->userdata("gift_detail");
		}
		if($this->customer->isLogged()){
			$c_info = $this->db->query("SELECT * FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
			
			$this->db->query("INSERT INTO orders SET customer_id = '" . (int)$this->customer->getCorporateId() . "', email = '" . $c_info->email . "', name = '" . $this->db->escape_str($gift_detail['g_from']) . "', mobile = '" . $this->db->escape_str($c_info->mobile) . "', c_role = '" . $this->db->escape_str($c_info->role_id) . "', c_vat = '" . $this->db->escape_str($c_info->vat_no) . "', c_company = '" . $this->db->escape_str($c_info->company_name) . "', comment = '" . $this->db->escape_str($gift_detail['g_message']) . "', payment_method = '', payment_code = '', shipping_firstname = '" . $this->db->escape_str($gift_detail['recipient_name']) . "', shipping_email = '" . $this->db->escape_str($gift_detail['g_to']) . "', shipping_method = 'N/A', shipping_code = 'N/A', shipping_charge = '0', item_total_price = '" . (float)$total . "', promo_code = '" . $this->db->escape_str($promo_code) . "', promo_code_name = '" . $this->db->escape_str($promo_code_name) . "', promo_code_price = '" . (float)$promo_code_price . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', order_status_id = '0', trans_id = '" . $trans_id . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', date_added = NOW(), date_modified = NOW()");
		}
		
		$order_id = $this->db->insert_id();
		$cart = $this->db->query("SELECT p.seo,p.image,p.name as product_name,p.short_name as short_name,p.name_hindi as arabic_name,p.sku, p.gift_value, pp.discounted_price, pp.price,pp.barcode,pp.size, pp.id as size_id, pp.price as real_price FROM product p LEFT JOIN product_size pp ON (p.id = pp.product_id) WHERE p.id = '" . (int)$gift_detail['gid'] . "'")->row();	
		
		if($cart->discounted_price == 0){
			$order_price = $cart->price * 1;
		}else{
			$order_price = $cart->discounted_price * 1;
		}
		$base_price = round((($order_price * 100) / 115),2);
		$vat_price = round(($order_price - $base_price),2);
		$productname=$cart->product_name;
		$this->db->query("INSERT INTO order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$gift_detail['gid'] . "', product_name = '" . $this->db->escape_str($cart->product_name) . "', short_name = '" . $this->db->escape_str($cart->short_name) . "', arabic_name = '" . $this->db->escape_str($cart->arabic_name) . "', gst_rate = '" . $this->db->escape_str($vat_rate) . "', vat_price = '" . $this->db->escape_str($vat_price) . "', barcode = '" . $this->db->escape_str($cart->barcode) . "', product_slug = '" . $this->db->escape_str($cart->seo) . "', size = '" . $this->db->escape_str($cart->size) . "', size_id = '" . (int)$cart->size_id . "', quantity = '1', real_price = '" . $this->db->escape_str($cart->real_price) . "', discounted_price = '" . $this->db->escape_str($cart->discounted_price) . "', order_price = '" . $this->db->escape_str($order_price) . "', gift_value = '" . $this->db->escape_str($cart->gift_value) . "', product_sku = '" . $this->db->escape_str($cart->sku) . "', product_image = '" . $this->db->escape_str($cart->image) . "'");
		
		$total = $total + $order_price;
		
		$total_vat_price = round((($total * 100) / 115),2);
		$order_total = $total - $promo_code_price;
		$shipping_method = "PAID";
		$shipping_code = "PAID";
		$shipping = 0;
		if($this->customer->isLogged()){
			if($wallet_checked > 0){
				$wallet_applied = $this->get_wallet($order_total);
				$net_payble_amt = $order_total - $wallet_applied;
			}else{
				$net_payble_amt = $order_total;
			}
			$this->db->query("UPDATE orders SET shipping_method = '" . $shipping_method . "', shipping_code = '" . $shipping_method . "', shipping_charge = '" . $shipping . "', shipping_type = '" . $shipping_type . "', total_vat = '" . $total_vat_price . "', item_total_price = '" . (float)$total . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', total_cashback = '" . (float)$total_cashback . "', wallet_applied = '" . (float)$wallet_applied . "' WHERE id = '" . (int)$order_id . "'");
		}
		 
		/****Clear order history****/
		$this->session->unset_userdata("promotion_code");
		$data['details']=$gift_detail;
		$data['orderid']=$order_id;
		$data['trans_id']=$trans_id;
		$data['wallet_amt']= $wallet_applied;
		$data['cust_id']=(int)$this->customer->getCorporateId();
		$data['total'] = $order_total;
		$data['net_payble_amt'] = $net_payble_amt;
		//print_r($data);exit();
		return $data;
	}

	function order_fridge($wallet_checked,$rewards_checked){
		if(!$this->customer->isLogged() AND !$this->session->userdata('delievery_id')){
			redirect("/");
		}
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
		$shipping_type = 0;
		$trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		$contactless = $this->session->userdata("contactless");

		if($this->session->userdata("promotion_code")){
    		$prs = $this->session->userdata("promotion_code");
    		$promo_code = $prs['code'];
    		$promo_code_name = $prs['name'];
    		$promo_code_price = $prs['discount_amount'];
		}
		$date_slot = $this->session->userdata("delv_date");
		$time_slot = $this->session->userdata("delv_time");
		$short_time_slot = $this->session->userdata("delv_time_short");
		if($this->customer->isLogged()){
			$address = $this->db->query("SELECT a.*,c.name as c_name, c.email as c_email, c.mobile as c_mobile, c.role_id as c_role, c.company_name as c_company, c.vat_no as c_vat FROM address a LEFT JOIN customer c On (c.id = a.customer_id) WHERE a.id = '" . (int)$this->session->userdata('delievery_id') . "'")->row();
			//print_r($address);exit();
			$this->db->query("INSERT INTO orders SET customer_id = '" . (int)$this->customer->getCorporateId() . "', email = '" . $address->c_email . "', name = '" . $this->db->escape_str($address->c_name) . "', mobile = '" . $this->db->escape_str($address->c_mobile) . "', c_role = '" . $this->db->escape_str($address->c_role) . "', c_vat = '" . $this->db->escape_str($address->c_vat) . "', c_company = '" . $this->db->escape_str($address->c_company) . "', payment_method = '', payment_code = '',  shipping_email = '" . $this->db->escape_str($address->c_email) . "', shipping_firstname = '" . $this->db->escape_str($address->name) . "', villa_building = '" . $this->db->escape_str($address->villa_building) . "', shipping_house_no = '" . $this->db->escape_str($address->house_no) . "', shipping_street = '" . $this->db->escape_str($address->street) . "', shipping_sector = '" . $this->db->escape_str($address->sector) . "', shipping_locality = '" . $this->db->escape_str($address->locality) . "', shipping_city = '" . $this->db->escape_str($address->city) . "', shipping_state = '" . $this->db->escape_str($address->state) . "', shipping_country = '" . $this->db->escape_str($address->country) . "', shipping_postcode = '" . $this->db->escape_str($address->postcode) . "', shipping_lat = '" . $this->db->escape_str($address->lat) . "', shipping_lng = '" . $this->db->escape_str($address->lng) . "', shipping_place_id = '" . $this->db->escape_str($address->place_id) . "', shipping_complete_address = '" . $this->db->escape_str($address->complete_address) . "', shipping_instruction = '" . $this->db->escape_str($address->instruction) . "', shipping_addrstype = '" . $this->db->escape_str($address->address_type) . "', shipping_date_slot = '" . $date_slot . "', shipping_time_slot = '" . $time_slot . "', contactless = '" . (int)$contactless . "',  shipping_mobile = '" . $this->db->escape_str($address->mobile) . "', shipping_method = 'N/A', shipping_code = 'N/A', shipping_charge = '0', item_total_price = '" . (float)$total . "', promo_code = '" . $this->db->escape_str($promo_code) . "', promo_code_name = '" . $this->db->escape_str($promo_code_name) . "', promo_code_price = '" . (float)$promo_code_price . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', order_status_id = '0', trans_id = '" . $trans_id . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "', date_added = NOW(), date_modified = NOW()");
			
			$sms_mobile = $address->mobile;
		}
		$order_id = $this->db->insert_id();
		
		$cart = $this->db->query("SELECT c.*, p.seo,p.image,p.name as product_name,p.short_name as short_name,p.name_hindi as arabic_name, p.gift_value,p.sku, pp.discounted_price, pp.price,pp.barcode,pp.size, pp.cashback, pp.cashback_expiry, pp.price as real_price FROM cart c LEFT JOIN product p ON (p.id = c.product_id) LEFT JOIN product_size pp ON (c.size_id = pp.id) WHERE (c.customer_id = '" . (int)$this->customer->getCorporateId() . "' AND c.customer_id != '0') OR c.session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "'");	
		
		foreach($cart->result() as $cart){
		    if($cart->discounted_price == 0){
				$order_price = $cart->price * $cart->quantity;
		    }else{
		        $order_price = $cart->discounted_price * $cart->quantity;
		    }
			
			$today = date("Y-m-d");
			$expire = $cart->cashback_expiry; //from database
			
			$today_time = strtotime($today);
			$expire_time = strtotime($expire);
			
			//echo $expire_time;exit();
			if ($expire_time > $today_time) { 
				$total_cashback += $cart->cashback;
				//echo $total_cashback;exit();
			}
			
			$base_price = round((($order_price * 100) / 115),2);
			$vat_price = round(($order_price - $base_price),2);
			$productname=$cart->product_name;
			$this->db->query("INSERT INTO order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$cart->product_id . "', product_name = '" . $this->db->escape_str($cart->product_name) . "', short_name = '" . $this->db->escape_str($cart->short_name) . "', arabic_name = '" . $this->db->escape_str($cart->arabic_name) . "', gst_rate = '" . $this->db->escape_str($vat_rate) . "', vat_price = '" . $this->db->escape_str($vat_price) . "', barcode = '" . $this->db->escape_str($cart->barcode) . "', product_slug = '" . $this->db->escape_str($cart->seo) . "', size = '" . $this->db->escape_str($cart->size) . "', size_id = '" . (int)$cart->size_id . "', quantity = '" . $this->db->escape_str($cart->quantity) . "', real_price = '" . $this->db->escape_str($cart->real_price) . "', discounted_price = '" . $this->db->escape_str($cart->discounted_price) . "', order_price = '" . $this->db->escape_str($order_price) . "', gift_value = '" . $this->db->escape_str($cart->gift_value) . "', product_sku = '" . $this->db->escape_str($cart->sku) . "', product_image = '" . $this->db->escape_str($cart->image) . "'");
			
			$total = $total + $order_price;
		}
		$total_vat_price = round((($total * 100) / 115),2);
		$order_total = $total - $promo_code_price;
		
		//$shipping = 50;
		$shipping_method = "PAID";
		$shipping_code = "PAID";
		//$shipping = $this->customer->getShipping($order_total);
		$shipping = 0;
		if($time_slot == '60 - 120 min'){
			$shipping = $this->customer->getExpressCharge();
			$shipping_type = 1;
		}else{
			$shipping_type = $short_time_slot;
		}
		$order_total += $shipping;
		$net_payble_amt = $order_total;
		if($this->customer->isLogged()){
			if($rewards_checked > 0){
				$rewards_applied = $this->get_rewards();
				$net_payble_amt = $order_total - $rewards_applied;
			}
			if($wallet_checked > 0){
				$wallet_applied = $this->get_wallet($net_payble_amt);
			}
			
			$net_payble_amt = $net_payble_amt - $wallet_applied;
			
			$this->db->query("UPDATE orders SET shipping_method = '" . $shipping_method . "', shipping_code = '" . $shipping_method . "', shipping_charge = '" . $shipping . "', shipping_type = '" . $shipping_type . "', total_vat = '" . $total_vat_price . "', item_total_price = '" . (float)$total . "', order_total = '" . (float)$order_total . "', net_payble_amt = '" . (float)$net_payble_amt . "', total_cashback = '" . (float)$total_cashback . "', cashback_applied = '" . (float)$rewards_applied . "', wallet_applied = '" . (float)$wallet_applied . "' WHERE id = '" . (int)$order_id . "'");
		}
		 
		/****Clear order history****/
		$this->session->unset_userdata("promotion_code");
		$this->session->unset_userdata("contactless");
		$data['details']=$address;
		$data['orderid']=$order_id;
		$data['trans_id']=$trans_id;
		$data['rewards_amt']= $rewards_applied;
		$data['wallet_amt']= $wallet_applied;
		$data['cust_id']=(int)$this->customer->getCorporateId();
		$data['total'] = $order_total;
		$data['net_payble_amt'] = $net_payble_amt;
		
		return $data;
	}
	
	function rewards_update($amount, $orderid){
		if($amount > 0){
			$query = $this->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
			$rewards_amt = $query->rewards;
			$remarks = 'Reward points debited for order id '. $orderid;
			$current_amt = $rewards_amt - $amount;
			$this->db->query("UPDATE customer SET rewards =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$this->customer->getCorporateId() . "'");
			
			$this->db->query("INSERT INTO rewards_report SET user_id =  '" . (int)$this->customer->getCorporateId() . "', amount =  '" . $amount . "', trans_type =  'debit', remarks =  '" . $remarks . "', order_id =  '" . $orderid . "', updated_at = NOW()");
		}
		return true;
	}
	
	function rewards_refund($amount,$id){
		if($amount > 0){
			$query = $this->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
			$remarks = 'Reward points refund for order id'.$id;
			$rewards_amt = $query->rewards;
			$current_amt = $rewards_amt + $amount;
			$this->db->query("UPDATE customer SET rewards =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$this->customer->getCorporateId() . "'");
			
			$this->db->query("INSERT INTO rewards_report SET user_id =  '" . (int)$this->customer->getCorporateId() . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $remarks . "', updated_at = NOW()");
		}
		return true;
	}
	
	function wallet_debit($amount, $oid){
		if($this->customer->isLogged()){
			if($amount > 0){
				$query = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
				$remarks = 'Payment Debit for Order ID '.$oid;
				$wallet_amt = $query->wallet;
				$current_amt = $wallet_amt - $amount;
				$this->db->query("UPDATE customer SET wallet =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$this->customer->getCorporateId() . "'");
				
				$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$this->customer->getCorporateId() . "', amount =  '" . $amount . "', trans_type =  'debit', remarks =  '" . $remarks . "', order_id =  '" . $oid . "', updated_at = NOW()");
			}
			return true;
		}else{
			redirect("/");
		}
	}
	
	function wallet_credit($amount, $oid){
		if($this->customer->isLogged()){
			if($amount > 0){
				$query = $this->db->query("SELECT wallet FROM customer WHERE id = '" . (int)$this->customer->getCorporateId() . "'")->row();
				$remarks = 'Cancellation Refund Order ID '.$oid;
				$wallet_amt = $query->wallet;
				$current_amt = $wallet_amt + $amount;
				$this->db->query("UPDATE customer SET wallet =  '" . $current_amt . "', modified = NOW() WHERE id = '" . (int)$this->customer->getCorporateId() . "'");
				
				$this->db->query("INSERT INTO wallet_report SET user_id =  '" . (int)$this->customer->getCorporateId() . "', amount =  '" . $amount . "', trans_type =  'credit', remarks =  '" . $remarks . "', order_id =  '" . $oid . "', updated_at = NOW()");
			}
			return true;
		}else{
			redirect("/");
		}
	}
	
	function create_gcard($gift_detail){
		if($this->customer->isLogged()){
			$StartingDate = date("Y-m-d");  // todays date as a timestamp
			$newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($StartingDate)) . " + 365 day"));
			$this->db->query("INSERT INTO gift_cards SET user_id =  '" . (int)$this->customer->getCorporateId() . "', order_id =  '" . $gift_detail['order_id'] . "', to_name =  '" . $gift_detail['to_name'] . "', to_email =  '" . $gift_detail['gift_to'] . "', from_name =  '" . $gift_detail['from_name'] . "', message =  '" . $gift_detail['gift_message'] . "', g_value =  '" . $gift_detail['gift_value'] . "', g_code =  '" . $gift_detail['gift_code'] . "', expiry_date =  '" . $newEndingDate . "', updated_at = NOW()");
			return true;
		}else{
			redirect("/");
		}
	}
	
	function credit_update($amount,$order_id,$trans_id){
		if($amount > 0){
			$query = $this->db->query("SELECT credit_avilable FROM credit_account WHERE user_id = '" . (int)$this->customer->getCorporateId() . "'")->row();
			$credit_amt = $query->credit_avilable;
			$current_amt = $credit_amt - $amount;
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', updated_at = NOW() WHERE user_id = '" . (int)$this->customer->getCorporateId() . "'");
			$this->db->query("INSERT INTO credit_account_report SET order_id =  '" . $order_id . "', trans_id =  '" . $trans_id . "', avl_bal =  '" . $current_amt . "', debit =  '" . $amount . "', credit =  0, trans_type =  'debit', user_id =  '" . (int)$this->customer->getCorporateId() . "', created_at = NOW()");
		}
		return true;
	}
	
	function update_qty($id){
		$query = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . $id . "'");
		
		foreach($query->result() as $q){
			//echo '<pre>';print_r($q->size_id);'</pre>';exit();
			$p_qty = $this->db->query("SELECT quantity FROM product_size WHERE id = '" . $q->size_id . "'")->row();
			
			$this->db->query("UPDATE product_size SET quantity = " . (int)$p_qty->quantity .'-'. (int)$q->quantity . " WHERE id = '" . $q->size_id . "'");
		}
		return true;
	}
	
	function pay_confirm($txn, $id, $type){
		$this->db->query("DELETE FROM cart WHERE customer_id = '" . (int)$this->customer->getCorporateId() . "' OR session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "'");
		$this->db->query("UPDATE `orders` SET `payment_method` = '" . $type . "', `payment_code` = '" . $txn . "', `order_status_id` = '1' WHERE id = '" . $id . "'");
		$query = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . $id . "'");
		foreach($query->result() as $q){
			$p_qty = $this->db->query("SELECT quantity FROM product_size WHERE id = '" . $q->size_id . "'")->row();
			$this->db->query("UPDATE product_size SET quantity = " . (int)$p_qty->quantity .'-'. (int)$q->quantity . " WHERE id = '" . $q->size_id . "'");
		}
		$this->session->unset_userdata("shipping");
		$this->session->unset_userdata("delievery_id");
		$this->session->unset_userdata("gift_detail");
		return true;
	}
	
	function pay_confirm_gift($txn, $id, $type){
		$this->db->query("UPDATE `orders` SET `payment_method` = '" . $type . "', `payment_code` = '" . $txn . "', `order_status_id` = '6', `order_type` = '2' WHERE id = '" . $id . "'");
		$query = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . $id . "'");
		foreach($query->result() as $q){
			$p_qty = $this->db->query("SELECT quantity FROM product_size WHERE id = '" . $q->size_id . "'")->row();
			$this->db->query("UPDATE product_size SET quantity = " . (int)$p_qty->quantity .'-'. (int)$q->quantity . " WHERE id = '" . $q->size_id . "'");
		}
		$this->session->unset_userdata("shipping");
		$this->session->unset_userdata("delievery_id");
		$this->session->unset_userdata("gift_detail");
		return true;
	}
	
	function manage_status($id, $status){
		$query = $this->db->query("UPDATE `orders` SET order_status_id = '" . (int)$status . "' WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function cancel_order($id){
		$query = $this->db->query("UPDATE `orders` SET order_status_id = 9 WHERE id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "'");
		return $query;
	}
	
	function updateCancelCredit($id,$trans_id){
		if($this->customer->isLogged()){
			$c_query = $this->db->query("SELECT car.id, car.debit, ca.credit_avilable FROM credit_account_report car LEFT JOIN credit_account ca ON (car.user_id = ca.user_id) WHERE car.trans_id = '" . $this->db->escape_str($trans_id) . "' AND car.user_id = '" . (int)$this->customer->getCorporateId() . "'")->row();
			
			$car_id = $c_query->id;
			$credit_amt = $c_query->debit;
			$avl_amt = $c_query->credit_avilable;
			$current_amt = $credit_amt + $avl_amt;
			$new_trans_id = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
			//print_r($c_query);exit();
			
			$this->db->query("UPDATE credit_account SET credit_avilable =  '" . $current_amt . "', updated_at = NOW() WHERE user_id = '" . (int)$this->customer->getCorporateId() . "'");
			
			$query = $this->db->query("UPDATE credit_account_report SET remarks = 'Amount refunded of order id - #BS". $id ."', age = '0', status =  '2', payment_date =  now(), updated_at = NOW() WHERE id =  '" . $this->db->escape_str((int)$car_id) . "'");
			
			$query = $this->db->query("INSERT INTO credit_account_report SET node =  '" . $car_id . "', trans_id =  '" . $new_trans_id . "', avl_bal =  '" . $current_amt . "', debit =  0, credit =  '" . $credit_amt . "', trans_type =  'credit', remarks = 'Amount refunded of order id - #BS". $id ."', user_id =  '" . $this->db->escape_str((int)$this->customer->getCorporateId()) . "', status =  '2', updated_at = now(), payment_date =  now()");
		}
		return $query;
	}
    
    function get_order_detail($id){
		if($this->customer->getRole() == 'main'){
			$query = $this->db->query("SELECT * FROM `orders` WHERE id = '" . (int)$id . "'")->row();
		}else{
			$query = $this->db->query("SELECT * FROM `orders` WHERE id = '" . (int)$id . "' AND staff_id = '" . (int)$this->customer->getId() . "'")->row();
		}
		//'<pre>';print_r($query);'</pre>';exit();
		return $query;
	}
	
	function get_order_details($id){
		if($this->customer->getRole() == 'main'){
			$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, db.dname as db_name, db.driver_mo_no as db_mob, om.order_image, ad.name as associate_name, ad.username as associate_username, cl.username as staff_username, cl.display_name as staff_display_name FROM `orders` o LEFT JOIN van db ON(o.delivery_boy = db.id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE o.id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "'")->row_array();
		}else{
			$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, db.dname as db_name, db.driver_mo_no as db_mob, om.order_image, ad.name as associate_name, ad.username as associate_username, cl.username as staff_username, cl.display_name as staff_display_name FROM `orders` o LEFT JOIN van db ON(o.delivery_boy = db.id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE o.id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "' AND staff_id = '" . (int)$this->customer->getId() . "'")->row_array();
		}
		$sql = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "'")->result_array();
		$logs = $this->db->query("SELECT * FROM status_change_log WHERE order_id = '" . (int)$id . "'")->result_array();
		$data = array("order"=>$query, "product"=>$sql, "logs"=>$logs);
		return $data;
	}

	
	function get_quotation_details($id){
		if($this->customer->getRole() == 'main'){
			$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, ad.name as associate_name, ad.username as associate_username, om.order_image, cl.username as staff_username, cl.display_name as staff_display_name FROM `quotation` o LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE o.id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "'")->row_array();
		}else{
			$query = $this->db->query("SELECT o.*, mc.city_name as sel_city_name, ad.name as associate_name, ad.username as associate_username, om.order_image, cl.username as staff_username, cl.display_name as staff_display_name FROM `quotation` o LEFT JOIN admin ad ON(o.associate_id = ad.admin_id) LEFT JOIN order_image om ON(o.id = om.order_id) LEFT JOIN master_city mc ON(o.city_name = mc.id) LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE o.id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "' AND staff_id = '" . (int)$this->customer->getId() . "'")->row_array();
		}
		$sql = $this->db->query("SELECT * FROM quotation_product WHERE quotation_id = '" . (int)$id . "' ORDER BY id ASC")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}

	function quotation_list(){
		if($this->customer->getRole() == 'main'){
			$query = $this->db->query("SELECT q.*, cl.username as staff_username, cl.display_name as staff_display_name FROM quotation q LEFT JOIN corporate_logins cl ON (q.staff_id = cl.id) WHERE customer_id = '" . (int)$this->customer->getCorporateId() . "' ORDER BY q.id DESC")->result_array();
		}else{
			$query = $this->db->query("SELECT q.*, cl.username as staff_username, cl.display_name as staff_display_name FROM quotation q LEFT JOIN corporate_logins cl ON (q.staff_id = cl.id) WHERE q.customer_id = '" . (int)$this->customer->getCorporateId() . "' AND q.staff_id = '" . (int)$this->customer->getId() . "' ORDER BY q.id DESC")->result_array();
		}
		//'<pre>';print_r($query);'</pre>';exit();
		return $query;
	}

	function order_list(){
		if($this->customer->getRole() == 'main'){
			$query = $this->db->query("SELECT o.*, cl.username as staff_username, cl.display_name as staff_display_name FROM orders o LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE customer_id = '" . (int)$this->customer->getCorporateId() . "' ORDER BY o.id DESC")->result_array();
		}else{
			$query = $this->db->query("SELECT o.*, cl.username as staff_username, cl.display_name as staff_display_name FROM orders o LEFT JOIN corporate_logins cl ON (o.staff_id = cl.id) WHERE customer_id = '" . (int)$this->customer->getCorporateId() . "' AND  staff_id = '" . (int)$this->customer->getId() . "' ORDER BY o.id DESC")->result_array();
		}
		//'<pre>';print_r($query);'</pre>';exit();
		return $query;
	}

	function approve_quotation($quote_id){
		$quote = $this->db->query("SELECT * FROM quotation WHERE id = '" . (int)$quote_id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "' AND staff_id = '" . (int)$this->customer->getId() . "' AND quotation_status = 'review'");
		if($quote->num_rows() > 0){
			$query = $this->db->query("UPDATE quotation SET quotation_status = 'approved' WHERE id = '" . $quote_id . "' LIMIT 1");
			return $query;
		}else{
			return FALSE;
		}
	}

	function copy_to_basket(){
		$id =  $this->input->post('order_id');
		$order = $this->db->query("SELECT * FROM orders WHERE id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "' AND staff_id = '" . (int)$this->customer->getId() . "'");
		if($order->num_rows() > 0){
			$products = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "'")->result_array();
			if($products){
				foreach($products as $product){
					$product_id = $product['product_id'];
					$size_id = $product['size_id'];
					$qty = $product['quantity'];
					$isB2B = $this->db->query("SELECT * FROM product WHERE id = '" . (int)$product_id . "' AND b2b_availability = 'yes'");
					if($isB2B->num_rows() > 0){
						if($this->is_cart($product_id, $size_id)->num_rows() > 0){
							$this->db->query("DELETE FROM cart WHERE id = '" . (int)$this->is_cart($product_id,$size_id)->row()->id . "'");
							if($qty == '0' || $qty == ''){
								
							}else{
								$query = $this->db->query("INSERT INTO cart SET session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "', customer_id = '" . (int)$this->customer->getCorporateId() . "', staff_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$qty . "', size_id = '" . (int)$size_id . "', created = NOW()");
							}
						}else{
							if($qty > 0 && $qty !== ''){
								$query = $this->db->query("INSERT INTO cart SET session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "', customer_id = '" . (int)$this->customer->getCorporateId() . "', staff_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$qty . "', size_id = '" . (int)$size_id . "', created = NOW()");
							}
						}
					}
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function quotation_to_basket(){
		$id =  $this->input->post('quotation_id');
		$order = $this->db->query("SELECT * FROM quotation WHERE id = '" . (int)$id . "' AND customer_id = '" . (int)$this->customer->getCorporateId() . "' AND staff_id = '" . (int)$this->customer->getId() . "'");
		if($order->num_rows() > 0){
			$products = $this->db->query("SELECT * FROM quotation_product WHERE quotation_id = '" . (int)$id . "'")->result_array();
			if($products){
				foreach($products as $product){
					$product_id = $product['product_id'];
					$size_id = $product['size_id'];
					$qty = $product['quantity'];
					$isB2B = $this->db->query("SELECT * FROM product WHERE id = '" . (int)$product_id . "' AND b2b_availability = 'yes'");
					if($isB2B->num_rows() > 0){
						if($this->is_cart($product_id, $size_id)->num_rows() > 0){
							$this->db->query("DELETE FROM cart WHERE id = '" . (int)$this->is_cart($product_id,$size_id)->row()->id . "'");
							if($qty == '0' || $qty == ''){
								
							}else{
								$query = $this->db->query("INSERT INTO cart SET session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "', customer_id = '" . (int)$this->customer->getCorporateId() . "', staff_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$qty . "', size_id = '" . (int)$size_id . "', created = NOW()");
							}
						}else{
							if($qty > 0 && $qty !== ''){
								$query = $this->db->query("INSERT INTO cart SET session_id = '" . $this->db->escape_str($this->customer->getSessionId()) . "', customer_id = '" . (int)$this->customer->getCorporateId() . "', staff_id = '" . (int)$this->customer->getId() . "', product_id = '" . (int)$product_id . "', quantity = '" . (int)$qty . "', size_id = '" . (int)$size_id . "', created = NOW()");
							}
						}
					}
				}
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
}
