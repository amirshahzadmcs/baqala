<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if( ! function_exists('getstock')){
	function getstock($id){
		$CI =& get_instance();
       	$CI->load->database();
		 $query = $CI->db->query("SELECT * FROM store_inventory  WHERE product_id='". $id ."'  ");
		 return $query->row();
	}


}
