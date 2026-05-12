<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model
{

	function add()
	{
		$query = $this->db->query("INSERT INTO  admin SET  
		name = '" . $this->db->escape_str($this->input->post('name')) . "',
		employee_id = '" . $this->db->escape_str($this->input->post('employee_id')) . "',
		username = '" . $this->db->escape_str($this->input->post('username')) . "',
		email = '" . $this->db->escape_str($this->input->post('email')) . "',
		mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "',
		role = '" . $this->db->escape_str($this->input->post('role')) . "',
		password = '" . $this->db->escape_str(md5($this->input->post('password'))) . "',
		status = '" . (int)$this->input->post('status') . "', 
		created = NOW()");
		return $query;
	}

	function edit()
	{
		$query = $this->db->query("UPDATE  admin SET  name = '" . $this->db->escape_str($this->input->post('name')) . "',
		username = '" . $this->db->escape_str($this->input->post('username')) . "',
		email = '" . $this->db->escape_str($this->input->post('email')) . "',
		mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "',
		role = '" . $this->db->escape_str($this->input->post('role')) . "',
		password = '" . $this->db->escape_str($this->input->post('password1')) . "',
		status = '" . (int)$this->input->post('status') . "' WHERE 
		admin_id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}

	function get_list()
	{
		$query = $this->db->query("SELECT admin.*,roles.name as role_name FROM  admin Left Join roles ON (admin.role=roles.id) WHERE admin.admin_id != 1");
		return $query->result();
	}

	function delete($ids)
	{
		$count = count($ids);
		for ($i = 0; $i < $count; $i++) {
			$this->db->query("DELETE FROM admin WHERE admin_id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail_by_id($id)
	{
		$query = $this->db->query("SELECT * FROM  admin WHERE admin_id = '" . (int)$id . "'");
		return $query;
	}

	public function setStatusEnable($ids)
	{
		foreach ($ids as $id) {
			$this->db->query("UPDATE  admin SET status = '1' WHERE admin_id IN ('" . $id . "')");
		}
		return true;
	}

	public function setStatusDisable($ids)
	{
		foreach ($ids as $id) {
			$this->db->query("UPDATE  admin SET status = '0' WHERE admin_id IN ('" . $id . "')");
		}
		return true;
	}
}
