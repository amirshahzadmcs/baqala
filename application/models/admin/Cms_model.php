<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_model extends CI_Model{

	function add($image){
		$query = $this->db->query("INSERT INTO cms SET name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', slug = '" . $this->db->escape_str($this->input->post('seo')) . "', text_data = '" . $this->db->escape_str($this->input->post('data')) . "', arabic_text_data = '" . $this->db->escape_str($this->input->post('arabic_text_data')) . "', image = '" . $this->db->escape_str($image) . "', metatitle = '" . $this->db->escape_str($this->input->post('metatitle')) . "', metakeyword = '" . $this->db->escape_str($this->input->post('metakeyword')) . "', metadescription = '" . $this->db->escape_str($this->input->post('metadescription')) . "', status = '" . (int)$this->input->post('status') . "'");
		return $query;
	}
	
	function edit($image){
		$query = $this->db->query("UPDATE cms SET name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "',  slug = '" . $this->db->escape_str($this->input->post('seo')) . "', text_data = '" . $this->db->escape_str($this->input->post('data')) . "', arabic_text_data = '" . $this->db->escape_str($this->input->post('arabic_text_data')) . "', image = '" . $this->db->escape_str($image) . "', metatitle = '" . $this->db->escape_str($this->input->post('metatitle')) . "', metakeyword = '" . $this->db->escape_str($this->input->post('metakeyword')) . "', metadescription = '" . $this->db->escape_str($this->input->post('metadescription')) . "', status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_cms(){
		$query = $this->db->query("SELECT * FROM cms");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM cms WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_cms_by_id($id){
		$query = $this->db->query("SELECT * FROM cms WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
