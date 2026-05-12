<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('upload_image')){
	
	function upload_image($field_name, $upload_path, $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'pdf', 'doc', 'docx'], $max_size = 2048)
	{
		$CI =& get_instance();
		$CI->load->library('upload');
		
		// Ensure upload directory exists
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, TRUE);
		}

		$config = array(
			'upload_path'   => $upload_path,
			'allowed_types' => implode('|', $allowed_types),
			'max_size'      => $max_size,
			'encrypt_name'  => TRUE,
		);

		$CI->upload->initialize($config);

		if ($CI->upload->do_upload($field_name)) {
			$uploaded_data = $CI->upload->data();
			return array('status' => true, 'data' => $upload_path . $uploaded_data['file_name']);
		} else {
			return array('status' => false, 'data' => $CI->upload->display_errors());
		}
	}
}
