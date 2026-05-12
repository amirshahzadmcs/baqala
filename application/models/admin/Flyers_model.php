<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flyers_model extends CI_Model{

	function add($image){
		$query = $this->db->query("INSERT INTO flyers SET image = '" . $this->db->escape_str($image) . "', name = '" . $this->db->escape_str($this->input->post('name')) . "'");
		return $query;
	}

	function edit($image){
		$query = $this->db->query("UPDATE flyers  SET  image = '" . $this->db->escape_str($image) . "',name = '" . $this->db->escape_str($this->input->post('name')) . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}

	function get_photos(){
		$query = $this->db->query("SELECT * FROM flyers");
		return $query;
	}

	function delete($id){
		$query = $this->db->query("DELETE FROM flyers WHERE id IN (" . $id . ")");
		return $query;
	}

	function get_photo_by_id($id){
		$query = $this->db->query("SELECT * FROM flyers WHERE id = '" . (int)$id . "'");
		return $query;
	}
}
