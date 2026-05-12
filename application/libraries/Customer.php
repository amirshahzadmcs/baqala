<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer {
	protected $CI;

	public function __construct() {
		$CI =& get_instance();
		if(!$CI->session->userdata('session_id')){
			$CI->session->set_userdata('session_id', md5(time().rand().time()));
		}
		if(!$CI->session->userdata('currency')){
			$this->setCurrency($id = '2');
		}
	}

	public function getSpalsh(){
		$CI =& get_instance();
		$splash = $CI->session->userdata('isSessionActive');
		if ($splash == true)
		{
			return $splash;
		}
		else{
			return false;
		}
	}
    /*
	public function getLang(){
		$CI =& get_instance();
		$lang = $CI->session->userdata('isLangEn');
		if ($lang == true)
		{
			return $lang;
		}
		else{
			return false;
		}
	}
	*/
	public function selLang(){
		$CI =& get_instance();
		$lang = $CI->session->userdata("site_lang");
		return $lang;
	}

	function obfuscate_email($email)
	{
		$em   = explode("@",$email);
		$name = implode('@', array_slice($em, 0, count($em)-1));
		$len  = floor(strlen($name)/2);

		return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
	}

	public function login($email, $username, $password){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM corporate_logins WHERE corporate_id = '" . $CI->db->escape_str($email) . "' AND username  = '" . $CI->db->escape_str($username) . "' AND is_deleted  = '0' AND password = '" .$password. "'");
		if ($customer_query->num_rows()) {
			$row = $customer_query->row();
			$status = $row->status;
			$is_deleted = $row->is_deleted;
			if($status == 'active'){
				$CI->session->set_userdata('corporate_id', $row->main_id);
				$CI->session->set_userdata('customer_id', $row->id);
				$CI->session->set_userdata('customer_name', $row->display_name);
				$CI->session->set_userdata('customer_role', $row->login_role);
				$this->customer_id = $row->id;
				$CI->db->query("UPDATE corporate_logins SET login_ip = '" . $_SERVER['REMOTE_ADDR'] . "', last_login = NOW() WHERE id = '" . (int)$this->customer_id . "'");
				return 1;
			}else{
				return 2;
			}
		} else {
			return 0;
		}
	}

	public function logout() {
		$CI =& get_instance();
		$CI->session->unset_userdata('corporate_id');
		$CI->session->unset_userdata('customer_id');
		$CI->session->unset_userdata('customer_name');
		$CI->session->unset_userdata('customer_role');
		$CI->session->sess_destroy();
		$this->customer_id = '';
	}

	public function getId(){
		$CI =& get_instance();
		$customer_id = $CI->session->userdata('customer_id');
		if (!empty($customer_id))
		{
			return (int)$customer_id;
		}
		else{
			return null;
		}
	}

	public function getCorporateId(){
		$CI =& get_instance();
		$corporate_id = $CI->session->userdata('corporate_id');
		if (!empty($corporate_id))
		{
			return (int)$corporate_id;
		}
		else{
			return null;
		}
	}

	public function getRole(){
		$CI =& get_instance();
		$role_id = $CI->session->userdata('customer_role');
		if (!empty($role_id))
		{
			return (int)$role_id;
		}
		else{
			return null;
		}
	}

	public function getLocations(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT id, name, loc_email FROM location WHERE status = '1'");
		return $query;
	}

	public function getLocation(){
		$CI =& get_instance();
		if($CI->session->userdata('location')){
			return $CI->session->userdata('location');
		} else{
			return false;
		}
	}

	public function getLocationName(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT name FROM location WHERE id = '" . (int)$this->getLocation() . "'");
		if($query->num_rows()){
			return $query->row()->name;
		} else{
			return 'Select Location';
		}
	}

	public function getPincode(){
		$CI =& get_instance();
		if($CI->session->userdata('pincode')){
			return $CI->session->userdata('pincode');
		} else{
			return false;
		}
	}

	public function isLogged(){
		$CI =& get_instance();
		return (bool) $CI->session->userdata('customer_id');
	}

	public function addSession(){
		$CI =& get_instance();
		$CI->session->set_userdata('session_id', md5(time().rand().time()));
	}

	public function getSessionId(){
		$CI =& get_instance();
		$session_id = $CI->session->userdata('session_id');
		if (!empty($session_id)){
			return $session_id;
		}
		return false;
	}

	public function emailSetting(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM mail_setting WHERE status = '1'");
		return $query->row();
	}

	public function getShipping($order_total){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM shipping_charges WHERE ('" . $order_total . "' BETWEEN min_amt AND max_amt) AND status = '1'");
		if($query->num_rows()) {
			$shipping = $query->row();
			return $shipping->shipping_charge;
		}
		else{
			return 0;
		}
	}

	public function getShippingDetail($order_total){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM `shipping_charge` WHERE `start_price` <= '" . $order_total . "' AND `end_price` >= '" . $order_total . "' AND status = '1'");
		if($query->num_rows()) {
			$shipping = $query->row();
			return $shipping->end_price;
		}
		else{
			return 0;
		}
	}

	public function getExpressCharge(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT `express_charge` FROM express_delivery_charge WHERE status = '1'")->row();
		return $query->express_charge;
	}
	/*
	public function isSlotAvailable($slot){
		$CI =& get_instance();
		$t1 = date("H:i", strtotime($slot));
		$d1 = $CI->session->userdata("delv_date");
		date_default_timezone_set('Asia/Kolkata');
		$current_time = date("H:i");
		$current_date = date('Y-m-d');
		//print_r($current_date);exit();
		if($d1 == $current_date && $current_time < $t1){
			return false;
		}else{
			return true;
		}


		if($query->num_rows()){
			return $query->row()->name;
		} else{
			return 'Select Location';
		}
	}
	*/
	public function get_rewards(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT rewards FROM customer WHERE id = '" . (int)$this->getId() . "'")->row();
		$rewards_amt = $query->rewards;
		if($rewards_amt > 5){
			return 5;
		}else{
			return $rewards_amt;
		}
	}

	function total_order_price(){
	    $CI =& get_instance();
	    $total = 0;
		$order_total = 0;
		$promo_code = 'N/A';
		$promo_code_name = 'N/A';
		$promo_code_price = 0;
		if($CI->session->userdata("promotion_code")){
    		$prs = $CI->session->userdata("promotion_code");
    		$promo_code = $prs['code'];
    		$promo_code_name = $prs['name'];
    		$promo_code_price = $prs['discount_amount'];
		}
		$cart = $CI->db->query("SELECT c.*, p.seo,p.image,p.name as product_name,p.sku,IF(pp.discounted_price > 0, pp.discounted_price, pp.price) as price,pp.size, pp.price as real_price FROM cart c LEFT JOIN product p ON (p.id = c.product_id) LEFT JOIN product_size pp ON (c.size_id = pp.id) WHERE (c.customer_id = '" . (int)$this->getId() . "' AND c.customer_id != '0') OR c.session_id = '" . $CI->db->escape_str($this->getSessionId()) . "'");

		foreach($cart->result() as $cart){
			$order_price = $cart->price * $cart->quantity;
			$total = $total + $order_price;
		}

		$order_total = $total - $promo_code_price;
		$time_slot = $CI->session->userdata("delv_time");
		if($time_slot == '60 - 120 min'){
			$shipping = $this->getExpressCharge();
			$shipping_type = 1;
		}else{
			$shipping = $this->getShipping($order_total);
		}

		$data['total'] = $order_total + $shipping;
		return $data;
	}

	public function isCategory($cid){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT id, name, slug, arabic_name, description, image, icon, metatitle, heading_text, metadescription, metakeyword, parent_id FROM category WHERE id = '" . $cid . "' AND status = '1'");
		if ($query->num_rows()) {
			$cat_detail = $query->row();
			$data['id'] = $cat_detail->id;
			$data['slug'] = $cat_detail->slug;
			$data['parent_id'] = $cat_detail->parent_id;
			$data['name'] = $cat_detail->name;
			$data['arabic_name'] = $cat_detail->arabic_name;
			$data['heading_text'] = $cat_detail->heading_text;
			$data['description'] = $cat_detail->description;
			$data['image'] = $cat_detail->image;
			$data['icon'] = $cat_detail->icon;
			$data['metatitle'] = $cat_detail->metatitle;
			$data['metadescription'] = $cat_detail->metadescription;
			$data['metakeyword'] = $cat_detail->metakeyword;
			return $data;
		}
		else{
			return false;
		}
	}

	public function isProduct($pid){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT ps.id, ps.product_id, p.meta_title, p.meta_description, p.meta_keyword FROM product_size ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE ps.id = '" . $pid . "' AND p.status = '1'");
		if ($customer_query->num_rows()) {
			$prod_detail = $customer_query->row();
			$data['prod_id'] = $prod_detail->product_id;
			$data['metatitle'] = $prod_detail->meta_title;
			$data['metadescription'] = $prod_detail->meta_description;
			$data['metakeyword'] = $prod_detail->meta_keyword;
			return $data;
		}
		else{
			return false;
		}
	}

	public function isPage($slug){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT id FROM cms WHERE slug = '" . $slug . "'");
		if ($customer_query->num_rows()) {
		$id = $customer_query->row();
			$id = $id->id;
			return $id;
		}
		else{
			return false;
		}
	}

	public function isBlog($slug){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT id FROM blog WHERE slug = '" . $slug . "'");
		if($customer_query->num_rows()) {
			$id = $customer_query->row();
			$id = $id->id;
			return $id;
		}
		else{
			return false;
		}
	}

	public function getInfo(){
		$CI =& get_instance();
		$info = $CI->session->userdata('info');
		if (!empty($info)){
			return $info;
		}
		else{
			return null;
		}
	}

	public function removeInfo(){
		$CI =& get_instance();
		$CI->session->unset_userdata('info');
	}

	public function getCategoryTree(){
		$CI =& get_instance();
		$data['categories'] = array();
		$sql = "SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug as seo, c.image FROM category c WHERE c.parent_id = '0' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes' AND product.status = '1')) ORDER BY c.name ASC";
		//$sql = "SELECT id, name, arabic_name, parent_id, slug as seo, image FROM category WHERE parent_id = '0' AND status = '1' ORDER BY name ASC";
		$pc_query = $CI->db->query($sql);
		if ($pc_query->num_rows()){
			foreach($pc_query->result() as $query){
				$children_data = array();
				/*
				$children = $CI->db->query("SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug as seo, c.image FROM category c WHERE c.parent_id = '" .$query->id."' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes' AND product.status = '1')) ORDER BY c.name ASC");
				foreach($children->result() as $child) {
					$sub_children_data = array();
					$sub_children = $CI->db->query("SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug as seo, c.image FROM category c WHERE c.parent_id = '" .$child->id."' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes' AND product.status = '1')) ORDER BY c.name ASC");
					foreach($sub_children->result() as $sub_child) {
						// Level 3
						$sub_children_data[] = array(
							'name'     => $sub_child->name,
							'arabic_name'     => $sub_child->arabic_name,
							'href'     => $sub_child->seo
						);
					}
					// Level 2
					$children_data[] = array(
						'name'     => $child->name,
						'arabic_name'     => $child->arabic_name,
						'href'     => $child->seo,
						'children' => $sub_children_data
					);
				}*/
				// Level 1
				$data['categories'][] = array(
					'name'     => $query->name,
					'arabic_name'     => $query->arabic_name,
					'id'     => $query->id,
					'children' => $children_data,
					'href'     => $query->seo,
					'image' => $query->image
				);

			}
		}
		return $data['categories'];
	}

	public function getCategoryTreenews($id){
		$CI =& get_instance();
		$data['categories'] = array();
		$sql = "SELECT id, name, parent_id, slug as seo, image FROM category WHERE slug = '".$id."' AND status = '1' ORDER BY name ASC";
		$query = $CI->db->query($sql);
		if ($query->num_rows()){
			foreach($query->result() as $query){
				$children_data = array();
				$children = $CI->db->query("SELECT id, name, parent_id, slug as seo FROM category WHERE parent_id = '" .$query->id."' AND status = '1' ORDER BY name ASC");
				foreach($children->result() as $child) {
					$sub_children_data = array();
					$sub_children = $CI->db->query("SELECT id, name, parent_id, slug as seo FROM category WHERE parent_id = '" .$child->id."' AND status = '1' ORDER BY name ASC");
					foreach($sub_children->result() as $sub_child) {
						// Level 3
						$sub_children_data[] = array(
							'name'     => $sub_child->name,
							'href'     => $sub_child->seo
						);
					}
					// Level 2
					$children_data[] = array(
						'name'     => $child->name,
						'href'     => $child->seo,
						'children' => $sub_children_data
					);
				}
				// Level 1
				$data['categories'][] = array(
					'name'     => $query->name,
						'id'     => $query->id,
					'children' => $children_data,
					'href'     => $query->seo,
					'image' => $query->image
				);

			}
		}
		return $data['categories'];
	}

	public function getMainCategory(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT name,slug, arabic_name,image FROM category WHERE parent_id = '0' AND status = '1'")->result_array();
		return $query;
	}

	public function getSubCategory($id){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug FROM category c WHERE c.parent_id = '" .$id."' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes')) ORDER BY c.name")->result_array();
		return $query;
	}

	public function getSubCategory1($id){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug FROM category c WHERE c.parent_id = '" .$id."' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes')) ORDER BY c.name")->result_array();
		return $query;
	}

	public function inCart(){
		$CI =& get_instance();
		$w = $CI->db->query("SELECT SUM(quantity) as total FROM cart WHERE (customer_id = '" . (int)$this->getId() . "' AND customer_id != 0) OR session_id = '" . $CI->db->escape_str($this->getSessionId()) . "'")->row();
		return $w->total ? $w->total : 0;
	}

	public function countNotification(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT COUNT(id) AS NumberOfNoti FROM notification WHERE status = '1' AND `ended_on` >= '" . date('Y-m-d') ."'")->row();
		return $query->NumberOfNoti ? $query->NumberOfNoti : 0;
	}

	public function getCredit(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * from credit_account WHERE user_id ='". (int)$this->getId() ."'");
		if($query->num_rows()) {
			$credits = $query->row();
			return $credits;
		}
		else{
			return 0;
		}
	}

	public function refDetail($id){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * from referrals WHERE user_id ='". (int)$id ."' AND status ='1'")->row();
		if($query->refered_code !== '' && $query->is_ref_used < 1) {
			//print_r($query);exit();
			$referer_uid = $CI->db->query("SELECT user_id from referrals WHERE referral_code ='". $query->refered_code ."'")->row();

			$refer_amt = $CI->db->query("SELECT * FROM referral_setting WHERE status ='1'")->row();

			$data['referer_uid'] = $referer_uid->user_id;
			$data['referer_amt'] = $refer_amt->refferer_amount;

			$data['refered_code'] = $query->refered_code;
			$data['refered_amt'] = $refer_amt->referral_charge;
			return $data;
		}else{
			return 0;
		}
	}

	public function getAllCurrency(){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM currency WHERE status = '1'")->result();
		return $query;
	}

	public function setCurrency($id){
		$CI =& get_instance();
		$query = $CI->db->query("SELECT * FROM currency WHERE id = '" . (int)$id . "'");
		if($query->num_rows()){
			$q = $query->row();
			$CI->session->set_userdata("currency", $id);
			$CI->session->set_userdata("currency_icon", $q->icon);
			$CI->session->set_userdata("currency_rate", $q->price);
			$CI->session->set_userdata("currency_name", $q->name);
		}
		else{
			$CI->session->set_userdata("currency", 1);
			$CI->session->set_userdata("currency_icon", '<i class="fa fa-inr"></i>');
			$CI->session->set_userdata("currency_rate", 1);
			$CI->session->set_userdata("currency_name", 'INR');
		}
		return $CI->session->userdata("currency_name");
	}

	public function getRealRate($price){
		$CI =& get_instance();
		if($CI->session->userdata("currency") == 1){
			$rate = $CI->session->userdata("currency_icon").ceil($price * $CI->session->userdata('currency_rate'));
		} else{
			$rate = $CI->session->userdata("currency_icon").number_format($price * $CI->session->userdata('currency_rate'), 2);
		}
		return $rate;
	}

	public function checkPassword($old){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM corporate_logins WHERE id = '" . $this->getId() . "' AND password = '" . $old . "'");
		if($customer_query->num_rows()){
			return true;
		}
		else{
			return false;
		}
	}

	function getResizeImage($filename, $width, $height){
		$CI =& get_instance();
		if($filename){
			$filename = explode('/',$filename);
			$directory = $filename[0];
			$filename = $filename[1];
			if(file_exists("thumb/thumb" . $width . "X" . $height . "/" .$filename)){
				$path = "thumb/thumb" . $width. "X" . $height . "/" . $filename;
			}
			else{
				copy($directory."/" . $filename,  "thumb/thumb" . $width . "X" . $height . "/" .$filename);
				//$go['image_library'] = 'GD2';
				$go['source_image'] = "thumb/thumb" . $width . "X" . $height . "/" .$filename;
				$go['maintain_ratio'] = TRUE;
				$go['width'] = $width;
				$go['height'] = $height;
				// $go['wm_text'] = '@jindalgemsjaipur';
                // $go['wm_type'] = 'text';
                // $go['wm_font_size'] = '500';
                // $go['wm_font_color'] = '000000';
                // $go['wm_vrt_alignment'] = 'middle';
                // $go['wm_hor_alignment'] = 'center';

                //$go['wm_overlay_path'] = './images/watermarkimg.png';
                //$go['wm_type'] = 'overlay';
                //$go['wm_opacity'] = '100';
                //$go['wm_vrt_alignment'] = 'middle';
                //$go['wm_hor_alignment'] = 'center';

				$CI->image_lib->initialize($go);
				//$CI->image_lib->watermark();
				$CI->image_lib->resize();
				$CI->image_lib->clear();
				$path = "thumb/thumb" . $width . "X" . $height . "/" .$filename;
			}
			return $path;
		}
		else{
			return "";
		}
	}

	public function getToken($id){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM corporate_logins WHERE id = '". (int)$id ."'");
		foreach($customer_query->result() as $row){
			$this->token = $row->salt;
		}
		if ($this->token)
		{
			return $this->token;
		}
		else{
			return null;
		}
	}

	public function userd($admin_id){
		$CI =& get_instance();
		$customer_query = $CI->db->query("SELECT * FROM admin WHERE admin_id = '". (int)$admin_id ."'");
	    return $customer_query->row();
	}

	public function invoiceNmFormat($number){
		$formated_no = str_pad($number, 6, 0, STR_PAD_LEFT);
		return $formated_no;
	}

	public function formatedDate($date){
		$formated_date = date('d-m-Y h:i:s', strtotime($date));
		return $formated_date;
	}
}
