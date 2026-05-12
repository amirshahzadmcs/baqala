<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Roles_model extends CI_Model
{

	function add()
	{
		$query = $this->db->query("INSERT INTO roles SET name = '" . $this->db->escape_str($this->input->post('name')) . "',arabic_name = '" .$this->input->post('ar_name') . "', is_active = '" . (int)$this->input->post('is_active') . "', is_superadmin = '" . (int)$this->input->post('is_superadmin') . "'");
		return $query;
	}

	function edit()
	{
		$query = $this->db->query("UPDATE roles SET name = '" . $this->db->escape_str($this->input->post('name')) . "',arabic_name = '" .$this->input->post('ar_name') . "', is_active = '" . (int)$this->input->post('is_active') . "', is_superadmin = '" . (int)$this->input->post('is_superadmin') . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}

	function make_query()
	{
		$a = "SELECT * FROM roles WHERE deleted = '0'";
		return $a;
	}

	function get_list()
	{
		$a = "SELECT * FROM roles r WHERE (r.deleted = '0' AND id != '1' AND is_superadmin != '1')";
		if (isset($_POST["search"]["value"])) {
			$a .= " AND r.name LIKE '%" . $_POST["search"]["value"] . "%'";
		}
		if (isset($_POST["order"])) {
			$a .= " ORDER BY r.name " . $_POST['order']['0']['dir'] . "";
		} else {
			$a .= " ORDER BY r.name ASC";
		}
		if ($_POST["length"] != -1) {
			$a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
		}
		$query = $this->db->query($a);
		return $query->result();
	}

	function get_filtered_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);
		return $query->num_rows();
	}

	function get_all_data()
	{
		$this->db->select("*");
		$this->db->from('roles');
		$this->db->where('id!=', 1)->where('is_superadmin!=', 1);
		return $this->db->count_all_results();
	}

	function delete($id)
	{
		$query = $this->db->query("UPDATE roles SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}

	function get_detail($id)
	{
		$query = $this->db->query("SELECT * FROM roles WHERE id = '" . (int)$id . "'");
		return $query;
	}

	function check_data_exists($name, $id)
	{
		$this->db->where('name', $name);
		$this->db->where('id !=', $id);
		$query = $this->db->get('roles');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
