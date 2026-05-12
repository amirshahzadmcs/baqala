<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ChartAccount_model extends CI_Model
{
	function add()
	{
		$query = $this->db->query("INSERT INTO chart_of_accounts SET 
		branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', 
		account_type = '" . $this->db->escape_str($this->input->post('account_type')) . "', 
		code = '" . $this->input->post('code') . "', 
		main_account = '" . $this->input->post('main_account') . "', 
		journal_cat_type = '" . $this->input->post('journal_cat_type') . "'");
		return $query;
	}

	function check_duplicate_code($folderid, $code, $account_type){
		$this->db->select("*");  
		$this->db->from('chart_of_accounts'); 
		$this->db->where('branch_id !=',$folderid);
		$this->db->where('code =',$code);
		$this->db->where('account_type =',$account_type);
		return $this->db->count_all_results();  
	}

	function main_accounts()
	{
		$query = $this->db->query("SELECT * FROM chart_of_accounts WHERE main_account='0'")->result_array();
		return $query;
	}

	function account_detail($id)
	{
		$query = $this->db->query("SELECT * FROM chart_of_accounts WHERE branch_id='" . $id . "'")->row_array();
		return $query;
	}

	function update_main_account()
	{
		$id = $this->input->post('folderid');
		$query = $this->db->query("UPDATE chart_of_accounts SET 
		branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', 
		code = '" . $this->input->post('code') . "', 
		journal_cat_type = '" . $this->input->post('journal_cat_type') . "' WHERE branch_id = '". $id ."'");
		return $query;
	}

	function delete($id){
		$query = $this->db->query("DELETE FROM chart_of_accounts WHERE branch_id = '" . $id . "' LIMIT 1");
		return $query;
	}

	function check_branch_available($id)
	{
		$query = $this->db->query("SELECT * FROM chart_of_accounts WHERE main_account = '" . $id . "'");
		return $query;
	}

	function sub_branch($id)
	{
		$result = $this->db->query("SELECT * FROM chart_of_accounts WHERE main_account='" . $id . "'");
		return $result;
	}
	



	function maccount()
	{
		$acc = $this->db->query("SELECT * FROM chart_of_accounts WHERE account_type='2'")->result();

		return $acc;
	}

	function valid()
	{

		$id = $this->input->post('id');
		$validid = $this->db->query("SELECT * FROM chart_of_accounts WHERE branch_id='" . $id . "'")->result();

		return $validid;
	}

	function editinhead()
	{

		$id = $this->input->post('id');
		$editdata = $this->db->query("SELECT * FROM chart_of_accounts WHERE branch_id='" . $id . "'")->result();

		return $editdata;
	}

	function fupdate()
	{


		$editdata = $this->db->query("UPDATE chart_of_accounts SET  code = '" . $this->input->post('code') . "',branch_name = '" . $this->input->post('branch_name') . "',main_account = '" . $this->input->post('main_account') . "', credit = '" . $this->input->post('credit') . "', debit = '" . $this->input->post('debit') . "' WHERE branch_id = '" . $this->input->post('branch_id') . "'");
		// $insert_id = $this->input->post('id');

		return $editdata;
	}

	function innerhad()
	{

		$id = $this->input->post('id');
		$inner = $this->db->query("SELECT * FROM chart_of_accounts WHERE branch_id='" . $id . "'")->result();

		return $inner;
	}

	function edittop()
	{

		$id = $this->input->post('id');
		$topquery = $this->db->query("SELECT * FROM chart_of_accounts WHERE branch_id='" . $id . "'")->result();

		return $topquery;
	}
}
