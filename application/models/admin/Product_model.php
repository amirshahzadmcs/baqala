<?php
class Product_model extends CI_Model {
	
	public function create(){
		if(!empty($_POST['is_variation'])) {
			$variation = 'yes';
		} else {
			$variation = 'no';
		}
		if(!empty($_POST['cod_available'])) {
			$cod_available = '1';
		} else {
			$cod_available = '0';
		}
		if(!empty($_POST['b2b_availability'])) {
			$b2b_availability = 'yes';
		} else {
			$b2b_availability = 'no';
		}
		if(!empty($_POST['status'])) {
			$status = '1';
		} else {
			$status = '0';
		}
		$query = $this->db->query("INSERT INTO product SET brand_id = '" . $this->db->escape_str($this->input->post('brand_id')) . "', parent_sku = '" . $this->db->escape_str($this->input->post('parent_sku')) . "', is_variation = '" . $this->db->escape_str($variation) . "', b2b_availability = '" . $this->db->escape_str($b2b_availability) . "', main_category = '" . $this->db->escape_str((int)$this->input->post('category_id')) . "', status = '" . $this->db->escape_str($status) . "', cod_available = '" . $this->db->escape_str($cod_available) . "', name = 'NULL'");
		$product_id = $this->db->insert_id();
		if($query){
			if($this->input->post('category_id')){
				$sql = $this->db->query("SELECT id, parent_id FROM category WHERE id = '".$this->input->post('category_id')."'")->row();
				$level = 1;
				$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$sql->id . "', level = '" . (int)$level . "'");
				$p_id = $sql->parent_id;
				if($p_id > 0){
					for($j=0;$j<$p_id;$j++) {
						$level++;
						$child = $this->db->query("SELECT id, parent_id FROM category WHERE id = '".$p_id."'")->row();
						$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$child->id . "', level = '" . (int)$level . "'");
						$p_id = $child->parent_id;
					}
				}
			}
		}
		//$this->db->query("INSERT INTO product_info SET product_id = '" . $this->db->escape_str((int)$product_id) . "', created_at = NOW(), updated_at = NOW()");
		return $product_id;
	}
	
	public function update(){
		$product_id = $this->input->post('main_id');
		if(!empty($_POST['cod_available'])) {
			$cod_available = '1';
		} else {
			$cod_available = '0';
		}
		if(!empty($_POST['status'])) {
			$status = '1';
		} else {
			$status = '0';
		}
		if(!empty($_POST['is_variation'])) {
			$variation = 'yes';
		} else {
			$variation = 'no';
		}
		if(!empty($_POST['b2b_availability'])) {
			$b2b_availability = 'yes';
		} else {
			$b2b_availability = 'no';
		}
		//print_r($cod_available);exit();
		$query = $this->db->query("UPDATE product SET parent_sku = '" . $this->db->escape_str($this->input->post('parent_sku')) . "', brand_id = '" . $this->db->escape_str($this->input->post('brand_id')) . "', main_category = '" . $this->db->escape_str((int)$this->input->post('category_id')) . "', status = '" . $this->db->escape_str($status) . "', cod_available = '" . $this->db->escape_str((int)$cod_available) . "', b2b_availability = '" . $this->db->escape_str($b2b_availability) . "', is_variation = '" . $this->db->escape_str($variation) . "' WHERE id = '". $product_id ."' LIMIT 1");
		if($query){
			if($this->input->post('category_id')){
				$this->db->query("DELETE FROM product_to_category WHERE product_id = '" . (int)$product_id . "'");
				$sql = $this->db->query("SELECT id, parent_id FROM category WHERE id = '".$this->input->post('category_id')."'")->row();
				$level = 1;
				$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$sql->id . "', level = '" . (int)$level . "'");
				$p_id = $sql->parent_id;
				if($p_id > 0){
					for($j=0;$j<$p_id;$j++) {
						$level++;
						$child = $this->db->query("SELECT id, parent_id FROM category WHERE id = '".$p_id."'")->row();
						$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$child->id . "', level = '" . (int)$level . "'");
						$p_id = $child->parent_id;
					}
				}
			}
		}
		return $query;
	}
	
	public function edit(){
		$con['upload_path']   = './products_image/'; 
		$con['allowed_types'] = 'gif|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['main_image']['name']){
			//print_r($_FILES['main_image']['name']);exit();
			$this->load->library('upload', $con);
			$this->upload->do_upload('main_image');
			$image_da = $this->upload->data();
			$imagef = "products_image/".$image_da['file_name'];
		}
		else{
			$imagef = $this->input->post('old_main_image');
		}
		
		$product_id = $this->input->post('product_id');
		$this->db->trans_start();
		$query = $this->db->query("UPDATE product SET name = '" . $this->db->escape_str($this->input->post('name')) . "', name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', description_ar = '" . $this->db->escape_str($this->input->post('description_ar')) . "', image = '" . $imagef . "', moq = '" . (int)$this->input->post('moq') . "', meta_title = '" . $this->db->escape_str($this->input->post('meta_title')) . "', meta_description = '" . $this->db->escape_str($this->input->post('meta_description')) . "', meta_keyword = '" . $this->db->escape_str($this->input->post('meta_keyword')) . "',  updated_at = NOW() WHERE id = '" . (int)$product_id . "' LIMIT 1");
		
		/*---- Insert Other Image -----*/
		$this->db->query("DELETE FROM product_image WHERE product_id = '" . (int)$product_id . "'");	
		if(!empty($_FILES['other_img1']['name'])){
			$_FILES['product_images1']['name']= $_FILES['other_img1']['name'];
			$_FILES['product_images1']['type']= $_FILES['other_img1']['type'];
			$_FILES['product_images1']['tmp_name']= $_FILES['other_img1']['tmp_name'];
			$_FILES['product_images1']['error']= $_FILES['other_img1']['error'];
			$_FILES['product_images1']['size']= $_FILES['other_img1']['size'];    

			$this->load->library('upload', $con);
			$this->upload->do_upload('product_images1');
			$image_data1 = $this->upload->data();
			$image1 = "products_image/".$image_data1['file_name'];
		}
		else{
			$image1 = $this->input->post('old_other_img1');
		}
		if(!empty($_FILES['other_img2']['name'])){
			$_FILES['product_images2']['name']= $_FILES['other_img2']['name'];
			$_FILES['product_images2']['type']= $_FILES['other_img2']['type'];
			$_FILES['product_images2']['tmp_name']= $_FILES['other_img2']['tmp_name'];
			$_FILES['product_images2']['error']= $_FILES['other_img2']['error'];
			$_FILES['product_images2']['size']= $_FILES['other_img2']['size'];    

			$this->load->library('upload', $con);
			$this->upload->do_upload('product_images2');
			$image_data2 = $this->upload->data();
			$image2 = "products_image/".$image_data2['file_name'];
		}
		else{
			$image2 = $this->input->post('old_other_img2');
		}
		if(!empty($_FILES['other_img3']['name'])){
			$_FILES['product_images3']['name']= $_FILES['other_img3']['name'];
			$_FILES['product_images3']['type']= $_FILES['other_img3']['type'];
			$_FILES['product_images3']['tmp_name']= $_FILES['other_img3']['tmp_name'];
			$_FILES['product_images3']['error']= $_FILES['other_img3']['error'];
			$_FILES['product_images3']['size']= $_FILES['other_img3']['size'];    

			$this->load->library('upload', $con);
			$this->upload->do_upload('product_images3');
			$image_data3 = $this->upload->data();
			$image3 = "products_image/".$image_data3['file_name'];
		}
		else{
			$image3 = $this->input->post('old_other_img3');
		}
		if(!empty($_FILES['other_img4']['name'])){
			$_FILES['product_images4']['name']= $_FILES['other_img4']['name'];
			$_FILES['product_images4']['type']= $_FILES['other_img4']['type'];
			$_FILES['product_images4']['tmp_name']= $_FILES['other_img4']['tmp_name'];
			$_FILES['product_images4']['error']= $_FILES['other_img4']['error'];
			$_FILES['product_images4']['size']= $_FILES['other_img4']['size'];    

			$this->load->library('upload', $con);
			$this->upload->do_upload('product_images4');
			$image_data4 = $this->upload->data();
			$image4 = "products_image/".$image_data4['file_name'];
		}
		else{
			$image4 = $this->input->post('old_other_img4');
		}
		$this->db->query("INSERT INTO product_image SET product_id = '" . (int)$product_id . "', other_img1 = '" . $this->db->escape_str($image1) . "', other_img2 = '" . $this->db->escape_str($image2) . "', other_img3 = '" . $this->db->escape_str($image3) . "', other_img4 = '" . $this->db->escape_str($image4) . "'");
		
		/*---- Insert Other Image END -----*/
		//print_r($this->input->post('attribute_name'));exit();
		$this->db->query("DELETE FROM product_attribute WHERE product_id = '" . (int)$product_id . "'");
		if ($this->input->post('attribute_name')){
			$attribute_count = count($this->input->post('attribute_name'));
			for($l=0;$l<$attribute_count;$l++){
				$attribute_name = $this->input->post('attribute_name');
				$attribute_value = $this->input->post('attribute_value');
				$attribute_name_ar = $this->input->post('attribute_name_ar');
				$attribute_value_ar = $this->input->post('attribute_value_ar');
				$this->db->query("INSERT INTO product_attribute SET product_id = '" . (int)$product_id . "', attribute_value = '" . $this->db->escape_str($attribute_value[$l]) . "', attribute_name = '" . $this->db->escape_str($attribute_name[$l]) . "', attribute_value_ar = '" . $this->db->escape_str($attribute_value_ar[$l]) . "', attribute_name_ar = '" . $this->db->escape_str($attribute_name_ar[$l]) . "'");
			}
		}
		
		if ($this->input->post('size')){
			$size_count = count($this->input->post('size'));
			for($m=0;$m<$size_count;$m++){
				$size = $this->input->post('size');
				$size_arabic = $this->input->post('size_arabic');
				$size_unit = $this->input->post('size_unit');
				$price = $this->input->post('price');
				$discounted_price = $this->input->post('discounted_price');
				$disc_expiry = $this->input->post('disc_expiry');
				$barcode = $this->input->post('barcode');
				$cashback = $this->input->post('cashback');
				$cashback_expiry = $this->input->post('cashback_expiry');
				$product_sku = $this->input->post('product_sku')[$m];
				$seller_sku = $this->input->post('seller_sku');
				$rack = $this->input->post('rack_id');
				$shelf = $this->input->post('shelf_id');
				if($product_sku !== ''){
					$sku = $product_sku;
				}else{
					$sku = (int)$m+1;
				}
				$size_id = $this->input->post('size_id');

				$check_size = $this->db->get_where('product_size', array(
					'id' => $size_id[$m]
				));
				$is_size_exist = $check_size->num_rows(); //counting result from query

				if($is_size_exist > 0){
					$this->db->query("UPDATE product_size SET product_id = '" . (int)$product_id . "', size = '" . $this->db->escape_str($size[$m]) . "', size_arabic = '" . $this->db->escape_str($size_arabic[$m]) . "', size_unit = '" . $this->db->escape_str($size_unit[$m]) . "', price = '" . $price[$m] . "', discounted_price = '" . $discounted_price[$m] . "', disc_expiry = '" . $disc_expiry[$m] . "', barcode = '" . $barcode[$m] . "', cashback = '" . $cashback[$m] . "', cashback_expiry = '" . $cashback_expiry[$m] . "', product_sku = '" . $sku . "', seller_sku = '" . $seller_sku[$m] . "', rack = '" . $rack[$m] . "', shelf = '" . $shelf[$m] . "' WHERE id = '". $size_id[$m] ."'");
				}else{
					$this->db->query("INSERT INTO product_size SET product_id = '" . (int)$product_id . "', size = '" . $this->db->escape_str($size[$m]) . "', size_arabic = '" . $this->db->escape_str($size_arabic[$m]) . "', size_unit = '" . $this->db->escape_str($size_unit[$m]) . "', price = '" . $price[$m] . "', discounted_price = '" . $discounted_price[$m] . "', disc_expiry = '" . $disc_expiry[$m] . "', barcode = '" . $barcode[$m] . "', cashback = '" . $cashback[$m] . "', cashback_expiry = '" . $cashback_expiry[$m] . "', product_sku = '" . $sku . "', seller_sku = '" . $seller_sku[$m] . "', rack = '" . $rack[$m] . "', shelf = '" . $shelf[$m] . "'");
				}
			}
		}
		
		$this->db->query("DELETE FROM product_review WHERE product_id = '" . (int)$product_id . "'");
		if($this->input->post('rating')){
			$rating_count = count($this->input->post('rating'));
			for($r=0;$r<$rating_count;$r++){
				$rating = $this->input->post('rating');
				$review_text = $this->input->post('review_text');
				$rating_person = $this->input->post('rating_person');
				$this->db->query("INSERT INTO product_review SET product_id = '" . (int)$product_id . "', rating = '" . $this->db->escape_str($rating[$r]) . "', review_text = '" . $this->db->escape_str($review_text[$r]) . "', rating_person = '" . $this->db->escape_str($rating_person[$r]) . "'");
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function add_bulk($data = array()){
		if(isset($data) && !empty($data['parent_sku'])){
			$query = $this->db->query("INSERT INTO product SET brand_id = '" . $this->db->escape_str($data['brand_id']) . "', parent_sku = '" . $this->db->escape_str($data['parent_sku']) . "', is_variation = '" . $this->db->escape_str($data['is_variation']) . "', main_category = '" . $this->db->escape_str((int)$data['category_id']) . "', status = '" . $this->db->escape_str((int)$data['status']) . "', cod_available = '" . $this->db->escape_str((int)$data['cod_available']) . "', name = '" . $this->db->escape_str($data['name']) . "', name_ar = '" . $data['name_ar'] . "', description = '" . $this->db->escape_str($data['description']) . "', description_ar = '" . $this->db->escape_str($data['description_ar']) . "', moq = '" . (int)$data['moq'] . "', meta_title = '" . $this->db->escape_str($data['meta_title']) . "', meta_description = '" . $this->db->escape_str($data['meta_description']) . "', meta_keyword = '" . $this->db->escape_str($data['meta_keyword']) . "', created_at = NOW(), updated_at = NOW()");
			$product_id = $this->db->insert_id();
			//print_r($product_id);exit();
			if($query){
				if(isset($data['category_id']) && !empty($data['category_id'])){
					$sql = $this->db->query("SELECT id, parent_id FROM category WHERE id = '".$data['category_id']."'")->row();
					$level = 1;
					$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$sql->id . "', level = '" . (int)$level . "'");
					$p_id = $sql->parent_id;
					if($p_id > 0){
						for($j=0;$j<$p_id;$j++) {
							$level++;
							$child = $this->db->query("SELECT id, parent_id FROM category WHERE id = '".$p_id."'")->row();
							$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$child->id . "', level = '" . (int)$level . "'");
							$p_id = $child->parent_id;
						}
					}
				}
				if (isset($data['size']) && !empty($data['size'])){
					$this->db->query("INSERT INTO product_size SET product_id = '" . (int)$product_id . "', size = '" . $this->db->escape_str($data['size']) . "', size_arabic = '" . $this->db->escape_str($data['size_arabic']) . "', size_unit = '" . $this->db->escape_str($data['size_unit']) . "', price = '" . $data['price'] . "', discounted_price = '" . $data['discounted_price'] . "', disc_expiry = '" . $data['disc_expiry'] . "', barcode = '" . $data['barcode'] . "', cashback = '" . $data['cashback'] . "', cashback_expiry = '" . $data['cashback_expiry'] . "', product_sku = '1', seller_sku = '" . $data['seller_sku'] . "', rack = '" . $data['rack'] . "', shelf = '" . $data['shelf'] . "'");
				}
			}
			return $query;
		}else{
			return true;
		}
		
	}
	
	public function copy(){
		$copy_prod_id = $this->input->get('id');
		$main = $this->db->query("SELECT p.* FROM product p WHERE p.id = '" . (int)$copy_prod_id . "'")->row();
		$old_product_attribute = $this->db->query("SELECT * FROM product_attribute WHERE product_id = '" . $copy_prod_id . "'");
		$old_product_size = $this->db->query("SELECT * FROM product_size WHERE product_id = '" . $copy_prod_id . "' AND is_deleted = '0' ORDER BY id ASC");
		$old_product_category = $this->db->query("SELECT * FROM product_to_category WHERE product_id = '" . $copy_prod_id . "'");
		$old_product_image = $this->db->query("SELECT * FROM product_image WHERE product_id = '" . $copy_prod_id . "'");
		$prod_info = array(
			'brand_id' => $main->brand_id,
			'parent_sku' => $main->parent_sku.'-COPY',
			'is_variation' => $main->is_variation,
			'status' => $main->status,
			'cod_available' => $main->cod_available,
			'b2b_availability' => $main->b2b_availability,
			'is_deleted' => $main->is_deleted,
			'main_category' => $main->main_category,
			'name' => $main->name,
			'name_ar' => $main->name_ar,
			'description' => $main->description,
			'description_ar' => $main->description_ar,
			'country_id' => $main->country_id,
			'country_id_ar' => $main->country_id_ar,
			'image' => $main->image,
			'moq' => $main->moq,
			'meta_title' => $main->meta_title,
			'meta_description' => $main->meta_description,
			'meta_keyword' => $main->meta_keyword,
		);
		$this->db->trans_start();

		$query = $this->db->insert('product',$prod_info);
		$new_prod_id = $this->db->insert_id();
		if($query){
			if($old_product_attribute->num_rows() > 0){
				foreach($old_product_attribute->result() as $attribute){
					$this->db->query("INSERT INTO product_attribute SET product_id = '" . (int)$new_prod_id . "', attribute_value = '" . $this->db->escape_str($attribute->attribute_value) . "', attribute_name = '" . $this->db->escape_str($attribute->attribute_name) . "', attribute_value_ar = '" . $this->db->escape_str($attribute->attribute_value_ar) . "', attribute_name_ar = '" . $this->db->escape_str($attribute->attribute_name_ar) . "'");
				}
			}

			if($old_product_category->num_rows() > 0){
				foreach($old_product_category->result() as $category){
					$this->db->query("INSERT INTO product_to_category SET product_id = '" . (int)$new_prod_id . "', category_id = '" . (int)$category->category_id . "', level = '" . (int)$category->level . "'");
				}
			}

			if($old_product_size->num_rows() > 0){
				$size_count = 0;
				foreach($old_product_size->result() as $psize){
					$size = $psize->size;
					$size_arabic = $psize->size_arabic;
					$size_unit = $psize->size_unit;
					$price = $psize->price;
					$discounted_price = $psize->discounted_price;
					$disc_expiry = $psize->disc_expiry;
					$barcode = $psize->barcode;
					$cashback = $psize->cashback;
					$cashback_expiry = $psize->cashback_expiry;
					$product_sku = $psize->product_sku;
					$seller_sku = $psize->seller_sku;
					$rack = $psize->rack;
					$shelf = $psize->shelf;
					if($product_sku !== ''){
						$sku = $product_sku;
					}else{
						$sku = $size_count++;
					}
					$this->db->query("INSERT INTO product_size SET product_id = '" . (int)$new_prod_id . "', size = '" . $this->db->escape_str($size) . "', size_arabic = '" . $this->db->escape_str($size_arabic) . "', size_unit = '" . $this->db->escape_str($size_unit) . "', price = '" . $price . "', discounted_price = '" . $discounted_price . "', disc_expiry = '" . $disc_expiry . "', barcode = '" . $barcode . "', cashback = '" . $cashback . "', cashback_expiry = '" . $cashback_expiry . "', product_sku = '" . $sku . "', seller_sku = '" . $seller_sku . "', rack = '" . $rack . "', shelf = '" . $shelf . "'");
				}
			}

			if($old_product_image->num_rows() > 0){
			    $prod_images = $old_product_image->row();
				$this->db->query("INSERT INTO product_image SET product_id = '" . (int)$new_prod_id . "', other_img1 = '" . $this->db->escape_str($prod_images->other_img1) . "', other_img2 = '" . $this->db->escape_str($prod_images->other_img2) . "', other_img3 = '" . $this->db->escape_str($prod_images->other_img3) . "', other_img4 = '" . $this->db->escape_str($prod_images->other_img4) . "'");
			}

			$this->db->trans_complete();
		}
		return $new_prod_id;
	}
	
	/*----- Rack Shelf ------*/
	function get_racks(){
		$query = $this->db->query("SELECT id,rack_name FROM admin_product_rack WHERE status = 1 AND deleted = 0");
		return $query->result_array();
	}
	
	function get_shelfs(){
		$query = $this->db->query("SELECT id,shelf_name FROM admin_product_shelf WHERE status = 1 AND deleted = 0");
		return $query->result_array();
	}
	
	function get_shelf_by_rack($rack_id){
		$query = $this->db->query("SELECT id,shelf_name FROM admin_product_shelf WHERE rack_id = '" . (int)$rack_id . "'");
		return $query->result_array();
	}

	private function getSlug($page_name){
		$rs = preg_replace(array( '/\(+/', '/\)+/','/\/+/','/\*+/','/\?+/','/\|+/', ), '-', strtolower($page_name));
		$page_slug = preg_replace('/\s+/', '-', trim($rs));
		$customer_query = $this->db->query("SELECT id FROM product WHERE seo = '" . $this->db->escape_str($page_slug) . "'");
		if(!$customer_query->num_rows()){
			$customer_slug = $page_slug;
		}
		else{
			$customer_slug = $page_slug.'-'.rand();
		}
		return $customer_slug;
	}
	
	public function soft_delete($product_id) {
		$count = count($product_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("UPDATE product SET is_deleted = '1' WHERE id = '" . (int)$product_id[$i] . "'");
			$this->db->query("UPDATE product_size SET is_deleted = '1' WHERE product_id = '" . (int)$product_id[$i] . "'");
		}
		return true;
	}

	public function restore_product($product_id) {
		$count = count($product_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("UPDATE product SET is_deleted = '0' WHERE id = '" . (int)$product_id[$i] . "'");
			$this->db->query("UPDATE product_size SET is_deleted = '0' WHERE product_id = '" . (int)$product_id[$i] . "'");
		}
		return true;
	}

	public function permanent_delete($product_id) {
		$count = count($product_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM product WHERE id = '" . (int)$product_id[$i] . "'");
			$this->db->query("DELETE FROM product_attribute WHERE product_id = '" . (int)$product_id[$i] . "'");
			$this->db->query("DELETE FROM product_image WHERE product_id = '" . (int)$product_id[$i] . "'");
			$this->db->query("DELETE FROM product_size WHERE product_id = '" . (int)$product_id[$i] . "'");
			$this->db->query("DELETE FROM product_review WHERE product_id = '" . (int)$product_id[$i] . "'");
			$this->db->query("DELETE FROM product_to_category WHERE product_id = '" . (int)$product_id[$i] . "'");
		}
		/*
		$this->db->query("DELETE FROM product WHERE id > 4622");
		$this->db->query("DELETE FROM product_attribute WHERE product_id  > 4622");
		$this->db->query("DELETE FROM product_image WHERE product_id > 4622");
		$this->db->query("DELETE FROM product_size WHERE product_id > 4622");
		$this->db->query("DELETE FROM product_review WHERE product_id > 4622");
		$this->db->query("DELETE FROM product_to_category WHERE product_id > 4622");
		*/
		return true;
	}

	public function delete_sizebyid() {
		$size_id = $this->input->post('id');
	    $query = $this->db->query("UPDATE product_size SET is_deleted = '1' WHERE id ='". $size_id ."' LIMIT 1");
		return $query;
	}
	
	public function setCod() {
		$id = $this->input->post('id');
		$cod = $this->input->post('cod');
		if($cod == 'true') {
			$setcod = '1';
		} else {
			$setcod = '0';
		}
	    $query = $this->db->query("UPDATE product SET cod_available = '" . $setcod . "', updated_at = NOW() WHERE id ='". $id ."'");
	    return $query;
	}

	public function setB2B() {
		$id = $this->input->post('id');
		$b2b = $this->input->post('b2b');
		if($b2b == 'true') {
			$setb2b = 'yes';
		} else {
			$setb2b = 'no';
		}
	    $query = $this->db->query("UPDATE product SET b2b_availability = '" . $setb2b . "', updated_at = NOW() WHERE id ='". $id ."'");
	    return $query;
	}
	
	public function setStatus() {
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		if($status == 'true') {
			$setstatus = '1';
		} else {
			$setstatus = '0';
		}
	    $query = $this->db->query("UPDATE product SET status = '" . $setstatus . "', updated_at = NOW() WHERE id ='". $id ."'");
	    return $query;
	}
	
	public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE product SET status = '1', updated_at = NOW() WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE product SET status = '0', updated_at = NOW() WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function lastAdded() {
		$query = $this->db->query("SELECT seo, sku FROM product order by id DESC LIMIT 1")->row();
		return $query;
	}
	
	function get_category($d){
		$query = $this->db->query("select c.name as node_name, c.id as node_id, c1.name as cd1_name, c2.name as cd2_name, c3.name as cd3_name,c4.name as cd4_name from category as c 
				LEFT OUTER JOIN category as c1 ON(c1.id=c.parent_id) 
				LEFT OUTER JOIN category as c2 ON(c2.id=c1.parent_id) 
				LEFT OUTER JOIN category as c3 ON(c3.id=c2.parent_id) 
				LEFT OUTER JOIN category as c4 ON(c4.id=c3.parent_id) 
				WHERE c.name LIKE '%" . $d . "%' order
				by node_name  LIMIT 10");
		return $query;
	}
	
	/*------ Product Sub Table ------*/
	
	public function mainProduct($product_id) {
		$query = $this->db->query("SELECT p.*, mb.brand_name, c.name as main_cat_name FROM product p LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) WHERE p.id = '" . (int)$product_id . "'");
		return $query->row();
	}
	
	public function singleProduct($product_id) {
		$query = $this->db->query("SELECT p.* FROM product p WHERE p.id = '" . (int)$product_id . "'");
		return $query->row();
	}
	
	function product_category($d){
		$query = $this->db->query("select c.name as node_name, c.id as node_id, c1.name as cd1_name, c2.name as cd2_name, c3.name as cd3_name,c4.name as cd4_name from category as c 
				LEFT OUTER JOIN category as c1 ON(c1.id=c.parent_id) 
				LEFT OUTER JOIN category as c2 ON(c2.id=c1.parent_id) 
				LEFT OUTER JOIN category as c3 ON(c3.id=c2.parent_id) 
				LEFT OUTER JOIN category as c4 ON(c4.id=c3.parent_id) 
		WHERE c.id IN (SELECT category_id FROM product_to_category WHERE product_id = '" . $d . "')");
		return $query;
	}
	function product_attribute($d){
		$query = $this->db->query("SELECT * FROM product_attribute WHERE product_id = '" . $d . "'");
		return $query;
	}
	
	function product_review($d){
		$query = $this->db->query("SELECT * FROM product_review WHERE product_id = '" . $d . "'");
		return $query;
	}
		
	function product_image($d){
		$query = $this->db->query("SELECT * FROM product_image WHERE product_id = '" . $d . "'");
		return $query->row();
	}
		
		
	function product_size($d){
		$query = $this->db->query("SELECT * FROM product_size WHERE product_id = '" . $d . "' AND is_deleted = '0' ORDER BY id ASC");
		return $query->result();
	}
	
	/*------ Product Sub Table END ------*/
		
	function get_product($d){
		$query = $this->db->query("SELECT * FROM product WHERE name LIKE '%" . $d . "%' LIMIT 10");
		return $query;
	}
	
	function sub_product($d){
		$query = $this->db->query("SELECT * FROM product WHERE id IN (SELECT sub_product_id FROM product_sub WHERE product_id = '" . $d . "')");
		return $query;
	}
	
	function get_out_of_stock(){
		$query = $this->db->query("SELECT p.* FROM product p LEFT JOIN product_size ps ON(p.id = ps.product_id) WHERE ps.quantity < 1");
		return $query;
	}
	
	function make_query($keyword,$barcode,$cat_id,$cod,$brand,$status,$from,$to,$btob){
		$a = "SELECT * FROM product WHERE id > 0 AND is_deleted = '0'";
		if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%' OR parent_sku LIKE '%".$keyword."%' OR name_ar LIKE '%".$keyword."%')";
		}
		if($barcode){
			$a .= " AND id IN (SELECT product_id FROM product_size WHERE barcode = '" . $barcode . "')";
		}
		if($cat_id){
			$a .= " AND main_category = '" . $cat_id . "'";
		}
		
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($status){
			if($status == 'yes'){
				$a .= " AND status = '1'";
			}else{
				$a .= " AND status = '0'";
			}
		}
		if($btob){
			$a .= " AND b2b_availability = '". $btob ."'";
		}
		
		if($cod){
			if($cod == 'yes'){
				$a .= " AND cod_available = '1'";
			}else{
				$a .= " AND cod_available = '0'";
			}
		}
		if($brand){
			$a .= " AND brand_id = '" . $brand . "'";
		}
	    return $a;
	}
	
	function get_list($keyword,$barcode,$cat_id,$cod,$brand,$status,$from,$to,$btob){
		$a = $this->make_query($keyword,$barcode,$cat_id,$cod,$brand,$status,$from,$to,$btob);
		//return $a;
		
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
	
	function get_filtered_data($keyword,$barcode,$cat_id,$cod,$brand,$status,$from,$to,$btob){
		//$a = "SELECT * FROM product WHERE id > 0";
		$a = $this->make_query($keyword,$barcode,$cat_id,$cod,$brand,$status,$from,$to,$btob);
		
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('product');  
		return $this->db->count_all_results();
	}
	
	function get_deleted_product(){
		$this->db->select("*");  
		$this->db->from('product');  
		$this->db->where('is_deleted', '1');  
		return $this->db->get()->result();
	}

	function tax_class(){
		$query = $this->db->query("SELECT * FROM tax_class");
		return $query;
	}
	
	function product_categoryp($d){	
		$data = array();	
		$query = $this->db->query("SELECT category_id FROM product_to_category WHERE product_id = '" . $d . "'");
		foreach($query->result() as $query){
			array_push($data, $query->category_id);		
		}	
		return $data;	
	}		

	function get_locations(){
		$query = $this->db->query("SELECT * FROM location");
		return $query;
	}
	
	function get_parent_category(){
		$query = $this->db->query("SELECT c.id,c.name FROM category c WHERE c.parent_id = '0'");
		return $query;
	}
	
	function getSubCategory($id){
		$query = $this->db->query("SELECT c.id,c.name FROM category c WHERE c.parent_id = '" . $id . "'");
		return $query;
	}

	function get_categories(){
		$data = array();
		$parent_categories = $this->db->query("select id, parent_id, name FROM category WHERE parent_id = '0' AND status = '1' ORDER BY name");
		foreach($parent_categories->result() as $parent_category){
			$child = array();
			$child_categories = $this->db->query("select id, name, parent_id FROM category WHERE parent_id = '" . (int)$parent_category->id . "' AND status = '1' ORDER BY name");
			foreach($child_categories->result() as $child_category){
				$sub_child = $this->db->query("select id, name FROM category WHERE parent_id = '" . (int)$child_category->id . "' AND status = '1' ORDER BY name")->result_array();
				$child[] = array("id" => $child_category->id,
								 "name" => $child_category->name,
								 "child" => $sub_child);
			}
		$data[] = array("id" => $parent_category->id,
						"name" => $parent_category->name,
						"child" => $child);
		}
		return $data;
	}
	
	function getProductSearch($term){
		$query = $this->db->query("SELECT p.id, p.name, p.name_hindi, p.image, ps.size, ps.quantity, ps.price, ps.discounted_price, ps.cashback, ps.barcode, ps.id as size_id FROM product p JOIN product_size ps ON (ps.product_id = p.id) WHERE p.sku = '".$term."' OR ps.barcode = '".$term."'");
		return $query->row();
	}
	
	function updateStock(){
		if ($this->input->post('size_id')){
			$size_count = count($this->input->post('size'));
			for($m=0;$m<$size_count;$m++){
				$size_id = $this->input->post('size_id');
				$quantity = $this->input->post('quantity');
				$query = $this->db->query("UPDATE product_size SET quantity = '" . $quantity[$m] . "' WHERE id = '" . $size_id . "'");
			}
		}
		return $query;
	}
	
	function get_purchase_order(){
		$sql = "SELECT o.id as order_id, op.product_name, op.arabic_name, op.product_sku, op.barcode, op.product_image, SUM(op.quantity) as quantity FROM `orders` o JOIN order_product op ON (op.order_id = o.id) WHERE o.order_status_id = '2' GROUP BY op.product_id";
		$sql .= " ORDER BY o.id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function brand_list(){
		$query = $this->db->query("SELECT * FROM master_brands WHERE deleted = '0' AND status = '1' ORDER BY brand_name ASC")->result();
		return $query;
	}
	
	function unit_list(){
		$query = $this->db->query("SELECT * FROM master_unit WHERE is_deleted = '0' AND status = 'active'")->result();
		return $query;
	}
	
	function country_list(){
		$query = $this->db->query("SELECT * FROM countries")->result();
		return $query;
	}
	
	/*------ Product accordign to missing attributes ----*/
	
	function get_filter_products($keyword,$value){
	    if($keyword == 'image'){
	       $a = "SELECT p.* FROM product p WHERE `image` = '' OR image IS NULL";
	    }else{
	        $a = "SELECT p.* FROM product p WHERE $keyword = '". $value ."'";
	    }
		
		if(isset($_POST["search"]["value"])){
			$a .= " AND (p.name LIKE '%".$_POST["search"]["value"]."%' OR p.parent_sku = '".$_POST["search"]["value"]."' OR p.id = '".$_POST["search"]["value"]."' OR p.name_ar = '".$_POST["search"]["value"]."')";
		}
		$a .= " ORDER BY p.id DESC";	   
		if(isset($_POST["length"])){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}
	  
	function get_filtered_product($keyword,$value){
	    if($keyword == 'image'){
	       $a = "SELECT p.* FROM product p WHERE `image` = '' OR image IS NULL";
	    }else{
	        $a = "SELECT p.* FROM product p WHERE $keyword = '". $value ."'";
	    }
		
		if(isset($_POST["search"]["value"])){
			$a .= " AND (p.name LIKE '%".$_POST["search"]["value"]."%' OR p.parent_sku = '".$_POST["search"]["value"]."' OR p.id = '".$_POST["search"]["value"]."' OR p.name_ar = '".$_POST["search"]["value"]."')";
		} 
	    $query = $this->db->query($a);  
	    return $query->num_rows();  
	}
     
	function get_all_product($keyword,$value){
		$this->db->select("*");  
		$this->db->from('product'); 
		return $this->db->count_all_results();  
	}
	
	function check_sku($parent_sku, $id){
		$this->db->select("*");  
		$this->db->from('product'); 
		$this->db->where('parent_sku',$parent_sku);
		$this->db->where('id !=',$id);
		//$this->db->or_where('library.available_until =', "00-00-00 00:00:00");
		return $this->db->count_all_results();  
	}
	
	public function update_size(){
		$product_id = $this->input->post('product_id');
		if ($this->input->post('size_id') && $product_id > 0){
			$size_count = count($this->input->post('size_id'));
			for($m=0;$m<$size_count;$m++){
				$size_id = $this->input->post('size_id')[$m];
				//$size = $this->input->post('size');
				//$size_arabic = $this->input->post('size_arabic');
				//$size_unit = $this->input->post('size_unit');
				$price = $this->input->post('price');
				$discounted_price = $this->input->post('discounted_price');
				$disc_expiry = $this->input->post('disc_expiry');
				//$barcode = $this->input->post('barcode');
				$cashback = $this->input->post('cashback');
				$cashback_expiry = $this->input->post('cashback_expiry');
				//$seller_sku = $this->input->post('seller_sku');
				//$rack = $this->input->post('rack_id');
				//$shelf = $this->input->post('shelf_id');
				
				$query = $this->db->query("UPDATE product_size SET price = '" . $price[$m] . "', discounted_price = '" . $discounted_price[$m] . "', disc_expiry = '" . $disc_expiry[$m] . "', cashback = '" . $cashback[$m] . "', cashback_expiry = '" . $cashback_expiry[$m] . "' WHERE id = '" . (int)$size_id . "' AND product_id = '" . (int)$product_id . "' LIMIT 1");
			}
		}
		return $query;
	}
}

