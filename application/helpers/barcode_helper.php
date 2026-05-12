<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('generate_barcode')){
	function generate_barcode($code){
		if($code !== ''){
			$data=[];
			//get main CodeIgniter object
			$CI =& get_instance();
			//load library
			$CI->load->library('zend');
			//load in folder Zend
			$CI->zend->load('Zend/Barcode');
			//generate barcode
			$imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
			imagepng($imageResource, 'barcodes/'.$code.'.png');

			$data['barcode'] = 'barcodes/'.$code.'.png';
			return $data;
		}
	}
}