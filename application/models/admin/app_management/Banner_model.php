<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner_model extends CI_Model{
	//Slider
	function add($image,$image2){
		$query = $this->db->query("INSERT INTO app_banners SET banner_name = '" . $this->db->escape_str($this->input->post('banner_name')) . "', banner_title = '" . $this->db->escape_str($this->input->post('banner_title')) . "', banner_subtitle = '" . $this->db->escape_str($this->input->post('banner_subtitle')) . "', banner_type = '" . $this->db->escape_str($this->input->post('banner_type')) . "', banner_image = '" . $this->db->escape_str($image) . "', banner_name_ar = '" . $this->db->escape_str($this->input->post('banner_name_ar')) . "', banner_title_ar = '" . $this->db->escape_str($this->input->post('banner_title_ar')) . "', banner_subtitle_ar = '" . $this->db->escape_str($this->input->post('banner_subtitle_ar')) . "', banner_image_ar = '" . $this->db->escape_str($image2) . "', linked_category = '" . $this->db->escape_str($this->input->post('linked_category')) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "'");
		return $query;
	}
	function edit($image,$image2){
		$query = $this->db->query("UPDATE app_banners SET banner_name = '" . $this->db->escape_str($this->input->post('banner_name')) . "', banner_title = '" . $this->db->escape_str($this->input->post('banner_title')) . "', banner_subtitle = '" . $this->db->escape_str($this->input->post('banner_subtitle')) . "', banner_type = '" . $this->db->escape_str($this->input->post('banner_type')) . "', banner_image = '" . $this->db->escape_str($image) . "', banner_name_ar = '" . $this->db->escape_str($this->input->post('banner_name_ar')) . "', banner_title_ar = '" . $this->db->escape_str($this->input->post('banner_title_ar')) . "', banner_subtitle_ar = '" . $this->db->escape_str($this->input->post('banner_subtitle_ar')) . "', banner_image_ar = '" . $this->db->escape_str($image2) . "', linked_category = '" . $this->db->escape_str($this->input->post('linked_category')) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	function list($type){
		$query = $this->db->query("SELECT * FROM app_banners WHERE banner_type = '" . $type . "' ORDER BY sort_order ASC");
		return $query;
	}
	function delete($id){
		$query = $this->db->query("DELETE FROM app_banners WHERE id IN (" . $id . ")");
		return $query;
	}
	function get_banner_by_id($id,$type){
		$query = $this->db->query("SELECT * FROM app_banners WHERE id = '" . (int)$id . "' AND banner_type = '" . $type . "'");
		return $query;
	}
}
