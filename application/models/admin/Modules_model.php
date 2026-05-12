<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Modules_model extends CI_Model
{

	function add()
	{
		$method_keys = $this->input->post('method_key', TRUE);
		$method_values = $this->input->post('method_value', TRUE);

		$data = [];
		if (!empty($method_keys) && !empty($method_values)) {
			foreach ($method_keys as $index => $key) {
				$data[] = [
					'method_key' => $key,
					'method_value' => $method_values[$index]
				];
			}
		}

		$query = $this->db->query("INSERT INTO permission_category SET perm_group_id = '" . $this->db->escape_str($this->input->post('perm_group_id')) . "', name = '" . $this->db->escape_str($this->input->post('name')) . "', status = '" . (int)$this->input->post('status') . "', short_code = '" . $this->db->escape_str($this->input->post('short_code')) . "', methods = '" . json_encode($data) . "'");
		return $query;
	}

	function edit()
	{
		$method_keys = $this->input->post('method_key', TRUE);
		$method_values = $this->input->post('method_value', TRUE);

		$data = [];
		if (!empty($method_keys) && !empty($method_values)) {
			foreach ($method_keys as $index => $key) {
				$data[] = [
					'method_key' => $key,
					'method_value' => $method_values[$index]
				];
			}
		}

		$query = $this->db->query("UPDATE permission_category SET perm_group_id = '" . $this->db->escape_str($this->input->post('perm_group_id')) . "', name = '" . $this->db->escape_str($this->input->post('name')) . "', status = '" . (int)$this->input->post('status') . "', short_code = '" . $this->db->escape_str($this->input->post('short_code')) . "', methods = '" . json_encode($data) . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}

	function get_modules()
	{
		$data = array();
		$parent_categories = $this->db->query("select id, perm_group_id, name, short_code, enable_view, enable_add, enable_edit, enable_delete, status FROM permission_category WHERE perm_group_id = '0' AND deleted = '0' ORDER BY name");
		foreach ($parent_categories->result() as $parent_category) {
			$child = array();
			$child_categories = $this->db->query("select id, perm_group_id, name, short_code, enable_view, enable_add, enable_edit, enable_delete, status FROM permission_category WHERE perm_group_id = '" . (int)$parent_category->id . "' AND deleted = '0' ORDER BY name");
			foreach ($child_categories->result() as $child_category) {
				$grand_child = array();
				$sub_child_categories = $this->db->query("select id, perm_group_id, name, short_code, enable_view, enable_add, enable_edit, enable_delete, status FROM permission_category WHERE perm_group_id = '" . (int)$child_category->id . "' AND deleted = '0' ORDER BY name");
				foreach ($sub_child_categories->result() as $sub_child_category) {
					$grand_sub_child = array();
					$grand_child_categories = $this->db->query("select id, perm_group_id, name, short_code, enable_view, enable_add, enable_edit, enable_delete, status FROM permission_category WHERE perm_group_id = '" . (int)$sub_child_category->id . "' AND deleted = '0' ORDER BY name");
					foreach ($grand_child_categories->result() as $grand_sub_child_category) {
						$grand_sub_child_categories = $this->db->query("select id, perm_group_id, name, short_code, enable_view, enable_add, enable_edit, enable_delete, status FROM permission_category WHERE perm_group_id = '" . (int)$grand_sub_child_category->id . "' AND deleted = '0' ORDER BY name")->result_array();
						$grand_sub_child[] = array(
							"id" => $grand_sub_child_category->id,
							"name" => $grand_sub_child_category->name,
							"perm_group_id" => $grand_sub_child_category->perm_group_id,
							"short_code" => $grand_sub_child_category->short_code,
							"status" => $grand_sub_child_category->status,
							"child" => $grand_sub_child_categories
						);
					}
					$grand_child[] = array(
						"id" => $sub_child_category->id,
						"name" => $sub_child_category->name,
						"perm_group_id" => $sub_child_category->perm_group_id,
						"short_code" => $sub_child_category->short_code,
						"status" => $sub_child_category->status,
						"child" => $grand_sub_child
					);
				}
				$child[] = array(
					"id" => $child_category->id,
					"name" => $child_category->name,
					"perm_group_id" => $child_category->perm_group_id,
					"short_code" => $child_category->short_code,
					"status" => $child_category->status,
					"child" => $grand_child
				);
			}
			$data[] = array(
				"id" => $parent_category->id,
				"name" => $parent_category->name,
				"perm_group_id" => $parent_category->perm_group_id,
				"short_code" => $parent_category->short_code,
				"status" => $parent_category->status,
				"child" => $child
			);
		}
		return $data;
	}

	function delete($id)
	{
		$query = $this->db->query("UPDATE permission_category SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}

	function get_detail($id)
	{
		$query = $this->db->query("SELECT * FROM permission_category WHERE id = '" . (int)$id . "'");
		return $query;
	}

	function check_data_exists($name, $id)
	{
		$this->db->where('short_code', $name);
		$this->db->where('id !=', $id);
		$query = $this->db->get('permission_category');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
