<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_group_model extends CI_Model{
	
	function add(){
		$post_products = $this->input->post('products');
		$products = array();
		if(count($post_products['size_id']) > 0){
			$total_products = count($post_products['size_id']);
			for($j=0;$j<$total_products;$j++) {
				$size_id = $post_products['size_id'][$j];
				$prod_id = $post_products['prod_id'][$j];
				$sort_order = $post_products['sort_order'][$j];
				$products[] = array('s_id'=>$size_id,'pid'=>$prod_id,'sort'=>$sort_order);
			}
		}else{
			$products = '';
		}
		//echo '<pre>';print_r(json_encode($products));exit();
		$query = $this->db->query("INSERT INTO app_product_groups SET group_name = '" . $this->db->escape_str($this->input->post('group_name')) . "', group_name_arabic = '" . $this->db->escape_str($this->input->post('group_name_arabic')) . "', group_title = '" . $this->db->escape_str($this->input->post('group_title')) . "', group_title_arabic = '" . $this->db->escape_str($this->input->post('group_title_arabic')) . "', group_url = '" . $this->db->escape_str($this->input->post('group_url')) . "', products = '" . $this->db->escape_str(json_encode($products)) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "'");
		return $query;
	}
	
	function edit(){
		$post_products = $this->input->post('products');
		$products = array();
		if(count($post_products['size_id']) > 0){
			$total_products = count($post_products['size_id']);
			for($j=0;$j<$total_products;$j++) {
				$size_id = $post_products['size_id'][$j];
				$prod_id = $post_products['prod_id'][$j];
				$sort_order = $post_products['sort_order'][$j];
				$products[] = array('s_id'=>$size_id,'pid'=>$prod_id,'sort'=>$sort_order);
			}
		}else{
			$products = '';
		}
		$query = $this->db->query("UPDATE app_product_groups SET group_name = '" . $this->db->escape_str($this->input->post('group_name')) . "', group_name_arabic = '" . $this->db->escape_str($this->input->post('group_name_arabic')) . "', group_title = '" . $this->db->escape_str($this->input->post('group_title')) . "', group_title_arabic = '" . $this->db->escape_str($this->input->post('group_title_arabic')) . "', group_url = '" . $this->db->escape_str($this->input->post('group_url')) . "', products = '" . $this->db->escape_str(json_encode($products)) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = NOW() WHERE group_id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function list(){
		$query = $this->db->query("SELECT * FROM app_product_groups ORDER BY sort_order ASC");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM app_product_groups WHERE group_id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM app_product_groups WHERE group_id = '" . (int)$id . "'");
		return $query;
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

	function check_duplicate_url($id, $url){
		$this->db->select("*");  
		$this->db->from('app_product_groups'); 
		$this->db->where('group_id !=',$id);
		$this->db->where('group_url =',$url);
		return $this->db->count_all_results();  
	}
}
