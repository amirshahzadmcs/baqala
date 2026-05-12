<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Best_selling_model extends CI_Model{
	function add(){
		if(count($this->input->post('category_id')) > 0){
			$categories = $this->input->post('category_id');
			$cate_ids = implode(",",$categories);
		}else{
			$cate_ids = $this->input->post('category_id');
		}
		$query = $this->db->query("INSERT INTO best_selling_category SET group_name = '" . $this->db->escape_str($this->input->post('group_name')) . "', group_name_arabic = '" . $this->db->escape_str($this->input->post('group_name_arabic')) . "', category_id = '" . $this->db->escape_str($cate_ids) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "'");
		return $query;
	}
	function edit(){
		if(count($this->input->post('category_id')) > 0){
			$categories = $this->input->post('category_id');
			$cate_ids = implode(",",$categories);
		}else{
			$cate_ids = $this->input->post('category_id');
		}
		$query = $this->db->query("UPDATE best_selling_category SET group_name = '" . $this->db->escape_str($this->input->post('group_name')) . "', group_name_arabic = '" . $this->db->escape_str($this->input->post('group_name_arabic')) . "', category_id = '" . $this->db->escape_str($cate_ids) . "', sort_order = '" . $this->db->escape_str($this->input->post('sort_order')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = NOW() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	function list(){
		$query = $this->db->query("SELECT * FROM best_selling_category ORDER BY sort_order ASC");
		return $query;
	}
	function delete($id){
		$query = $this->db->query("DELETE FROM best_selling_category WHERE id IN (" . $id . ")");
		return $query;
	}
	function detail($id){
		$query = $this->db->query("SELECT * FROM best_selling_category WHERE id = '" . (int)$id . "'");
		return $query;
	}
}
