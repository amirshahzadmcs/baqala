<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderimg_model extends CI_Model{

	function add($image,$oid){
		$query = $this->db->query("INSERT INTO order_image SET order_image = '" . $this->db->escape_str($image) . "', order_id = '" . (int)$oid . "'");
		return $query;
	}

	function edit($image,$oid){
		$query = $this->db->query("UPDATE order_image  SET  order_image = '" . $this->db->escape_str($image) . "', order_id = '" . (int)$oid . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}

	function get_photos(){
		$query = $this->db->query("SELECT * FROM order_image");
		return $query;
	}

	function delete($oid){
		$query = $this->db->query("DELETE FROM order_image WHERE order_id IN (" . $oid . ")");
		return $query;
	}

	function get_photo_by_id($oid){
		$query = $this->db->query("SELECT * FROM order_image WHERE order_id = '" . (int)$oid . "'");
		return $query;
	}
}
