<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model{

	function get_home(){
		//$data = $this->db->query("SELECT * FROM home")->row_array();
		//$data['banners'] = $this->db->query("SELECT * FROM home_banner order by sort_order ASC")->result_array();
		$data['categories'] = $this->db->query("SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug FROM category c WHERE c.parent_id = '0' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes' AND product.status = '1' AND product.is_deleted = '0')) ORDER BY c.name")->result_array();
		return $data;
	}
	
	function get_category($id, $start, $limit){
		$data = array();
		$query = $this->db->query("SELECT ps.id as size_id, ps.product_id, ps.size, ps.size_unit, ps.barcode, ps.product_sku, ps.seller_sku, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku, p.is_deleted, p.status, p.b2b_availability, mu.unit_name, IF(c.quantity > 0, c.quantity, '') AS cart_quantity, IF(ps.discounted_price > 0, ps.discounted_price, ps.price) AS real_price, IF( ps.price - ps.discounted_price > 0, (ps.price - ps.discounted_price) / ps.price *100, 0 ) AS percent FROM product_size ps LEFT JOIN product p ON (ps.product_id = p.id) LEFT JOIN master_unit mu ON (ps.size_unit = mu.id) LEFT JOIN cart c ON ( c.size_id = ps.id AND c.customer_id = '" . (int)$this->customer->getId() . "') WHERE p.status = '1' AND p.b2b_availability = 'yes' AND p.is_deleted = '0' AND ps.is_deleted = '0' AND ps.product_id IN (SELECT product_id FROM product_to_category WHERE category_id = '" . (int)$id . "') order by p.id DESC LIMIT " . $start . ", " . $limit . "");
		foreach($query->result() as $pdata){
			$data[] = array("id" => $pdata->size_id,
							"prod_id" => $pdata->prod_id,
							"name" => $pdata->name,
							"name_arabic" => $pdata->name_ar,
							"image" => $pdata->image,
							"sku" => $pdata->product_sku,
							"parent_sku" => $pdata->parent_sku,
							"seller_sku" => $pdata->seller_sku,
							"size" => $pdata->size,
							"size_id" => $pdata->size_id,
							"unit" => $pdata->size_unit,
							"unit_name" => $pdata->unit_name,
							"barcode" => $pdata->barcode,
							"cart_quantity" => $pdata->cart_quantity,
							"price" => $pdata->real_price);
		}
		return $data;
	}
	
	function get_category_count($id){
		$query = $this->db->query("SELECT COUNT(pc.product_id) as total FROM product_to_category pc WHERE pc.category_id = '" . (int)$id . "' AND 1 = (SELECT status FROM product WHERE id = pc.product_id) AND 'b2b_availability' = (SELECT status FROM product WHERE id = pc.product_id)");
		return $query->row()->total;
	}

	function get_other_category($cat, $start, $limit){
		$data = array();
		$query = $this->db->query("SELECT name, id, name_hindi, image, sku, seo FROM product WHERE status = '1' AND b2b_availability = 'yes' AND is_deleted = '0' AND ". $cat ."= '1' order by id DESC LIMIT " . $start . ", " . $limit . "");
		foreach($query->result() as $query){
			$sql = $this->db->query("SELECT ps . * , IF(c.quantity > 0, c.quantity, 0) AS cart_quantity, IF( ps.price - ps.discounted_price >0, (ps.price - ps.discounted_price) / ps.price *100, 0 ) AS percent FROM product_size ps LEFT JOIN cart c ON ( c.size_id = ps.id AND c.customer_id = '" . (int)$this->customer->getId() . "') WHERE ps.product_id = '" . (int)$query->id . "' AND ps.is_deleted = '0'");
			$data[] = array("name" => $query->name,
							"id" => $query->id,
							"name_hindi" => $query->name_hindi,
							"image" => $query->image,
							"sku" => $query->sku,
							"seo" => $query->seo,
							"prices" => $sql->result_array());
		}
		return $data;
	}

	function get_other_category_count($cat){
		$query = $this->db->query("SELECT COUNT(p.id) as total FROM product p WHERE status = '1' AND b2b_availability = 'yes' AND is_deleted = '0' AND ". $cat ."= '1'");
		return $query->row()->total;
	}

	function get_search($term){
		$data = array();
		$query = $this->db->query("SELECT name, id, image, name_hindi, sku, is_gift, seo FROM product WHERE status = '1' AND is_deleted = '0' AND name LIKE '%" . $this->db->escape_str($term) . "%'");
		foreach($query->result() as $query){
			$sql = $this->db->query("SELECT ps . * , IF(c.quantity > 0, c.quantity, 0) AS cart_quantity, IF( ps.price - ps.discounted_price >0, (ps.price - ps.discounted_price) / ps.price *100, 0 ) AS percent FROM product_size ps LEFT JOIN cart c ON ( c.size_id = ps.id AND c.customer_id = '" . (int)$this->customer->getId() . "') WHERE ps.product_id = '" . (int)$query->id . "' AND ps.is_deleted = '0'");
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

	function get_search_hint($term, $start, $limit){
		$data = array();
		$query = $this->db->query("SELECT ps.id as size_id, ps.product_id, ps.size, ps.size_unit, ps.barcode, ps.product_sku, ps.seller_sku, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku, p.is_deleted, p.status, p.b2b_availability, mu.unit_name, IF(c.quantity > 0, c.quantity, '') AS cart_quantity, IF(ps.discounted_price > 0, ps.discounted_price, ps.price) AS real_price, IF( ps.price - ps.discounted_price > 0, (ps.price - ps.discounted_price) / ps.price *100, 0 ) AS percent FROM product_size ps LEFT JOIN product p ON (ps.product_id = p.id) LEFT JOIN master_unit mu ON (ps.size_unit = mu.id) LEFT JOIN cart c ON ( c.size_id = ps.id AND c.customer_id = '" . (int)$this->customer->getId() . "') WHERE p.status = '1' AND p.b2b_availability = 'yes' AND p.is_deleted = '0' AND ps.is_deleted = '0' AND p.name LIKE '%" . $this->db->escape_str($term) . "%' order by p.id DESC LIMIT " . $start . ", " . $limit . "");
		foreach($query->result() as $pdata){
			$data[] = array("id" => $pdata->size_id,
							"prod_id" => $pdata->prod_id,
							"name" => $pdata->name,
							"name_arabic" => $pdata->name_ar,
							"image" => $pdata->image,
							"sku" => $pdata->product_sku,
							"parent_sku" => $pdata->parent_sku,
							"seller_sku" => $pdata->seller_sku,
							"size" => $pdata->size,
							"size_id" => $pdata->size_id,
							"unit" => $pdata->size_unit,
							"unit_name" => $pdata->unit_name,
							"barcode" => $pdata->barcode,
							"cart_quantity" => $pdata->cart_quantity,
							"price" => $pdata->real_price);
		}
		return $data;
	}

	function get_product($id,$sid){
		$data = $this->db->query("SELECT p.*, mb.brand_name FROM product p LEFT JOIN master_brands mb ON (p.brand_id = mb.id) WHERE p.id = '" . (int)$id . "' AND p.status = '1' AND p.b2b_availability = 'yes' AND p.is_deleted = '0'")->row_array();
		$data['attributes'] = $this->db->query("SELECT * FROM product_attribute WHERE product_id = '" . (int)$id . "'")->result_array();
		$data['sizes'] = $this->db->query("SELECT ps.*, mu.unit_name, IF(ps.price - ps.discounted_price > 0, (ps.price - ps.discounted_price)/ps.price * 100, 0) as percent, (SELECT SUM(quantity) FROM cart c WHERE c.size_id = ps.id  AND c.customer_id = '" . (int)$this->customer->getId() . "') AS cart_quantity FROM product_size ps LEFT JOIN master_unit mu ON (ps.size_unit = mu.id) WHERE ps.id = '" . (int)$sid . "' AND ps.is_deleted = '0'")->row_array();
		$data['images'] = $this->db->query("SELECT * FROM product_image WHERE product_id = '" . (int)$id . "'")->row_array();
		$data['categories'] = $this->db->query("SELECT pc.category_id, c.name FROM product_to_category pc LEFT JOIN category c ON (pc.category_id = c.id) WHERE product_id = '" . (int)$id . "' ORDER BY pc.level DESC")->result_array();
		/*
		$config = array();
		$query = $this->db->query("SELECT name, id, image, sku, name_hindi, seo FROM product WHERE status = '1' AND id IN (SELECT product_id FROM product_to_category WHERE category_id = (SELECT category_id FROM product_to_category WHERE product_id = '" . (int)$id . "' LIMIT 1)) AND id !='". (int)$id ."' LIMIT 6");
		foreach($query->result() as $query){
			$sql = $this->db->query("SELECT ps . * , IF(c.quantity > 0, c.quantity, 0) AS cart_quantity, IF( ps.price - ps.discounted_price >0, (ps.price - ps.discounted_price) / ps.price *100, 0 ) AS percent FROM product_size ps LEFT JOIN cart c ON ( c.size_id = ps.id AND c.session_id = '" . $this->customer->getSessionId() . "') WHERE ps.product_id = '" . (int)$query->id . "'")->result_array();
			$config[] = array("name" => $query->name,
							"id" => $query->id,
							"image" => $query->image,
							"sku" => $query->sku,
							"name_hindi" => $query->name_hindi,
							"seo" => $query->seo,
							"prices" => $sql);
		}

		$data['similar'] = $config;
		*/
		return $data;
	}

	function get_noncod(){
		$query = $this->db->query("SELECT * FROM non_cod");
		return $query;
	}

	function get_page($id){
		$query = $this->db->query("SELECT * FROM cms WHERE id = '" . (int)$id . "'");
		return $query;
	}

	function get_blogs(){
		$query = $this->db->query("SELECT * FROM blog WHERE status = '1'");
		return $query;
	}

	function recent_blogs(){
		$query = $this->db->query("SELECT * FROM blog WHERE status = '1'");
		return $query;
	}

	function get_blog($id){
		$query = $this->db->query("SELECT * FROM blog WHERE id = '" . (int)$id . "' AND status = '1'");
		return $query;
	}

	function get_notification(){
		$query = $this->db->query("SELECT * FROM notification WHERE status = '1' AND `ended_on` >= '" . date('Y-m-d') ."'");
		return $query->result();
	}

	function submit_contact_us(){
		$query = $this->db->query("INSERT INTO contact SET name = '" . $this->db->escape_str($this->input->post('name')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', subject = '" . $this->db->escape_str($this->input->post('subject')) . "', message = '" . $this->db->escape_str($this->input->post('message')) . "', status = '2', created = NOW()");

		/* Send mail */
		return $query;
	}

	function submit_return(){
		$query = $this->db->query("INSERT INTO return SET name = '" . $this->db->escape_str($this->input->post('name')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', product_name = '" . $this->db->escape_str($this->input->post('product_name')) . "', product_code = '" . $this->db->escape_str($this->input->post('product_code')) . "', order_id = '" . (int)$this->input->post('order_id') . "', order_date = '" . date("Y-m-d", strtotime($this->input->post('order_date'))) . "', quantity = '" . (int)$this->input->post('quantity') . "', return_reason = '" . $this->db->escape_str($this->input->post('return_reason')) . "', is_opened = '" . (int)$this->input->post('is_opened') . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '1', created = NOW()");

		/* Send mail */
		return $query;
	}

	function submit_newsletter(){
		$query = $this->db->query("INSERT INTO newsletter SET email = '" . $this->db->escape_str($this->input->post('email')) . "', name = '" . $this->db->escape_str($this->input->post('name')) . "', created = NOW()");
		return $query;
	}

	function pin_exists(){
		$pincode = $this->input->post('pin_code');
		$query = $this->db->query("SELECT * FROM pincodes WHERE pincode = '" . (int)$pincode . "'");
		return $query->row();
	}

	function email_exists(){
		$query = $this->db->query("SELECT * FROM newsletter WHERE email = '" . $this->db->escape_str($this->input->post('email')) . "'");
		return $query->row();
	}

	function unsubscribe_newsletter(){
		$query = $this->db->query("UPDATE newsletter SET status = 'unsubscribe', created = NOW() WHERE email = '" . $this->db->escape_str($this->input->post('email')) . "'");
		return $query;
	}
}
