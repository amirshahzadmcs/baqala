<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Costcenter extends CI_Model
{
	function add()
	{
		
		$query = $this->db->query("INSERT INTO cost_center  SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		code = '" . $this->input->post('code') . "', 
		parent_id = '" . $this->input->post('parent_id') . "', 
		is_parent = '" . $this->input->post('is_parent') . "'");
		return $query;
	}

	function check_duplicate_code($folderid, $code){
		$this->db->select("*");  
		$this->db->from('cost_center'); 
		$this->db->where('id !=',$folderid);
		$this->db->where('code =',$code);
		
		return $this->db->count_all_results();  
	}

	function main_accounts()
	{
		$query = $this->db->query("SELECT * FROM cost_center WHERE parent_id='0'")->result_array();
		return $query;
	}

	function account_detail($id)
	{
		$query = $this->db->query("SELECT * FROM cost_center WHERE id='" . $id . "'")->row_array();
		return $query;
	}

	function update_main_account()
	{
		$id = $this->input->post('folderid');
		$query = $this->db->query("UPDATE cost_center SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		code = '" . $this->input->post('code') . "',
		is_parent = '" . $this->input->post('is_parent') . "',
		parent_id = '" . $this->input->post('parent_id') . "'
		WHERE id='" . $id . "'");
		return $query;
	}

	function delete($id){
		$query = $this->db->query("DELETE FROM cost_center WHERE id = '" . $id . "' LIMIT 1");
		return $query;
	}

	function check_branch_available($id)
	{
		$query = $this->db->query("SELECT * FROM cost_center WHERE parent_id = '" . $id . "'");
		
		return $query;
	}

	function sub_branch($id)
	{
		$result = $this->db->query("SELECT * FROM cost_center WHERE parent_id='" . $id . "'");
		return $result;
	}
	



	function maccount()
	{
		$acc = $this->db->query("SELECT * FROM cost_center WHERE account_type='2'")->result();

		return $acc;
	}

	function valid()
	{

		$id = $this->input->post('id');
		$validid = $this->db->query("SELECT * FROM cost_center WHERE branch_id='" . $id . "'")->result();

		return $validid;
	}

	function editinhead()
	{

		$id = $this->input->post('id');
		$editdata = $this->db->query("SELECT * FROM cost_center WHERE branch_id='" . $id . "'")->result();

		return $editdata;
	}

	function fupdate()
	{


		$editdata = $this->db->query("UPDATE cost_center SET  code = '" . $this->input->post('code') . "',branch_name = '" . $this->input->post('branch_name') . "',main_account = '" . $this->input->post('main_account') . "', credit = '" . $this->input->post('credit') . "', debit = '" . $this->input->post('debit') . "' WHERE branch_id = '" . $this->input->post('branch_id') . "'");
		// $insert_id = $this->input->post('id');

		return $editdata;
	}

	function innerhad()
	{

		$id = $this->input->post('id');
		$inner = $this->db->query("SELECT * FROM cost_center WHERE branch_id='" . $id . "'")->result();

		return $inner;
	}

	function edittop()
	{

		$id = $this->input->post('id');
		$topquery = $this->db->query("SELECT * FROM cost_center WHERE branch_id='" . $id . "'")->result();

		return $topquery;
	}
}
