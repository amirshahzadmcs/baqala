<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if( ! function_exists('getstock')){
	function getstock($id){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT * FROM store_inventory WHERE product_id='". $id ."' AND store_id = '". (int)$CI->store->getId() ."'");
		 return $query->row();
	}
}

if( ! function_exists('getRackName')){
	function getRackName($id){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT rack_name FROM store_rack WHERE id='". $id ."' AND store_id = '". (int)$CI->store->getId() ."'");
		 if($query->num_rows() > 0){
		     $rack_name = $query->row()->rack_name;
		 }else{
		     $rack_name = 'NA';
		 }
		 return $rack_name;
	}
}

if( ! function_exists('getShelfName')){
	function getShelfName($id){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT shelf_name FROM store_shelf WHERE id='". $id ."' AND store_id = '". (int)$CI->store->getId() ."'");
		 if($query->num_rows() > 0){
		     $shelf_name = $query->row()->shelf_name;
		 }else{
		     $shelf_name = 'NA';
		 }
		 return $shelf_name;
	}
}

if( ! function_exists('getRackShelf')){
	function getRackShelf($rackid){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT * FROM store_shelf WHERE rack_id='". $rackid ."' AND store_id = '". (int)$CI->store->getId() ."'");
		 if($query->num_rows() > 0){
		     $rack_shelves = $query->result_array();
		 }else{
		     $rack_shelves = array();
		 }
		 return $rack_shelves;
	}
}

if( ! function_exists('getBrandName')){
	function getBrandName($id){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT brand_name FROM master_brands WHERE id='". $id ."'");
		 if($query->num_rows() > 0){
		     $brand_name = $query->row()->brand_name;
		 }else{
		     $brand_name = 'NA';
		 }
		 return $brand_name;
	}
}

if( ! function_exists('getCategoryName')){
	function getCategoryName($id){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT name FROM category WHERE id='". $id ."'");
		 if($query->num_rows() > 0){
		     $category_name = $query->row()->name;
		 }else{
		     $category_name = 'NA';
		 }
		 return $category_name;
	}
}