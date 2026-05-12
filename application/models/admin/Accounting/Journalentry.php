<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Journalentry extends CI_Model
{
	public function allcostcenters()
	{
		$query = $this->db->query("SELECT * FROM cost_center ORDER BY name ASC")->result_array();
		return $query;
	}

	function add()
	{
		$con['upload_path']   = './uploads/journal/';
		$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;

		if ($_FILES['attachments']['name']) {
			//print_r($_FILES['main_image']['name']);exit();
			$con['upload_path']   = './uploads/journal/';
			$this->load->library('upload', $con);
			$this->upload->do_upload('attachments');
			$image_da = $this->upload->data();
			$journal_file = "uploads/journal/" . $image_da['file_name'];
		} else {
			$journal_file = '';
		}

		$query = $this->db->query("INSERT INTO journal_entry_master 
		 SET journal_date = '" . date('Y-m-d', strtotime($this->input->post('journal_date'))) . "', 
		  attachments = '" . $journal_file . "',
		  currency = '" . $this->db->escape_str($this->input->post('currency')) . "',
		  journal_no = '" . $this->db->escape_str($this->input->post('journal_no')) . "', 
		  journal_description = '" . $this->input->post('journal_description') . "',
		  debit_total = '" . $this->input->post('debit_total') . "',
		  credit_total = '" . $this->input->post('credit_total') . "'");
		$journal_id = $this->db->insert_id();
		$entry = $this->input->post();
		$main_entry = array();
		for ($i = 0; $i < sizeof($entry['journal_account_id']); $i++) {
			$arr = array(
				'journal_account_id' => ($entry['journal_account_id'][$i]),
				'cost_center' => ($entry['cost_center'][$i]),
				'description' => ($entry['description'][$i]),
				'credit' => ($entry['credit'][$i]),
				'debit' => ($entry['debit'][$i]),
				'tax_id' => ($entry['tax_id'][$i]),
				'journal_id' => ($journal_id),
				'deleted' => ('0')

			);
			$main_entry[] = $arr;
		}
		$resp = $this->db->insert_batch('journal_attrebuit', $main_entry);
		$journal_date = date('Y-m-d', strtotime($this->input->post('journal_date')));
		$logentry = $this->input->post();
		$generate_log = array();
		for ($i = 0; $i < sizeof($logentry['journal_account_id']); $i++) {
			$lgg = array(
				'account_name' => ($logentry['journal_account_id'][$i]),
				'action' => ('add'),
				'staff_member' => ('add'),
				'journal_number' => ($this->input->post('journal_no')),
				'currency_code' => ($this->input->post('currency')),
				'entry_date' => ($journal_date),
				'cost_center' => ($logentry['cost_center'][$i]),
				'description' => ($logentry['description'][$i]),
				'credit' => ($logentry['credit'][$i]),
				'debit' => ($logentry['debit'][$i]),
				'local_debit' => ($logentry['debit'][$i]),
				'local_credit' => ($logentry['credit'][$i]),
				'entry_id' => ($journal_id)

			);
			$generate_log[] = $lgg;
		}
		$resp = $this->db->insert_batch('journal_log', $generate_log);
		return $query;
	}
    
    function check_duplicate_journal($id, $journal_no){
		$this->db->select("*");  
		$this->db->from('journal_entry_master'); 
		$this->db->where('id !=',$id);
		$this->db->where('journal_no =',$journal_no);
		return $this->db->count_all_results();  
	}
	
	function entrydata()
	{
		$data = $this->db->query("SELECT * FROM journal_entry_master WHERE deleted = '0' ORDER BY id desc");
		return $data;
	}

	function viewdetail($entryid)
	{
		$data = $this->db->query("SELECT * FROM journal_entry_master WHERE id= '" . $entryid . "'")->row();
		return $data;
	}

	public function pdfview($entryid)
	{
		$data = $this->db->query("SELECT * FROM journal_entry_master WHERE id= '" . $entryid . "'")->row();
		return $data;
	}
	function update_entry()
	{

		$entryid = $this->input->post("entry_id");
		$data = $this->db->query("DELETE FROM journal_attrebuit WHERE entry_id = '" . $entryid . "'");


		$con['upload_path']   = './uploads/journal/';
		$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;

		if ($_FILES['filename']['name']) {

			$con['upload_path']   = './uploads/journal/';
			$this->load->library('upload', $con);
			$this->upload->do_upload('filename');
			$image_da = $this->upload->data();
			$journal_file = "uploads/journal/" . $image_da['file_name'];
		} else {
			$journal_file = '';
		}
		$query = $this->db->query("UPDATE journal_entry_master 
		 SET journal_date = '" . date('Y-m-d', strtotime($this->input->post('journal_date'))) . "',
		  docs = '" . $journal_file . "',
		  currency = '" . $this->db->escape_str($this->input->post('currency')) . "',
		  number = '" . $this->db->escape_str($this->input->post('number')) . "',description = '" . $this->input->post('desc') . "',debit_total = '" . $this->input->post('debit_total') . "',credit_total = '" . $this->input->post('credit_total') . "' WHERE entry_id = '" . $entryid . "'");
		$entry = $this->input->post();
		$main_entry = array();
		for ($i = 0; $i < sizeof($entry['acc_name']); $i++) {
			$arr = array(
				'account_name' => ($entry['acc_name'][$i]),
				'cost_center' => ($entry['costcenter'][$i]),
				'description' => ($entry['description'][$i]),
				'credit' => ($entry['credit'][$i]),
				'debit' => ($entry['debit'][$i]),
				'total' => ($entry['debit_total'][$i]),
				'entry_id' => ($entryid),
				'deleted' => ('0')

			);
			$main_entry[] = $arr;
		}

		$resp = $this->db->insert_batch('journal_attrebuit', $main_entry);

		$logentry = $this->input->post();
		$generate_log = array();
		for ($i = 0; $i < sizeof($logentry['acc_name']); $i++) {
			$lgg = array(
				'account_name' => ($logentry['acc_name'][$i]),
				'action' => ('update'),
				'staff_member' => ('unknown'),
				'journal_number' => ($this->input->post('number')),
				'currency_code' => ($this->input->post('currency')),
				'entry_date' => ($this->input->post('startdate')),
				'cost_center' => ($logentry['costcenter'][$i]),
				'description' => ($logentry['description'][$i]),
				'credit' => ($logentry['credit'][$i]),
				'debit' => ($logentry['debit'][$i]),
				'local_debit' => ($logentry['debit'][$i]),
				'local_credit' => ($logentry['credit'][$i]),
				'entry_id' => ($entryid)

			);
			$generate_log[] = $lgg;
		}
		$resp = $this->db->insert_batch('journal_log', $generate_log);
		return $query;
	}
	function delete_entry($entry_id)
	{
		$data = $this->db->query("UPDATE journal_attrebuit SET deleted = '1' WHERE entry_id = '" . $entry_id . "'");
		$data = $this->db->query("UPDATE journal_entry_master SET deleted = '1' WHERE entry_id = '" . $entry_id . "'");
		return $data;
	}
	function addprecurring()
	{
		$this->db->query("INSERT INTO recurring_journal_entry  SET start_date = '" . $this->input->post('startdate') . "',
		 frequency = '" . $this->db->escape_str($this->input->post('frequency')) . "',frequency_period = '" . $this->db->escape_str($this->input->post('frequencyr_period')) . "',name = '" . $this->input->post('name') . "',end_date = '" . $this->input->post('enddate') . "',entry_id = '" . $this->input->post('entry_id') . "'");
		$data = $this->db->query("SELECT * FROM recurring_journal_entry ORDER BY id desc")->row();

		return true;
	}
	function profilelist()
	{
		//$data=$this->db->query("SELECT * FROM recurring_journal_entry ORDER BY id desc")->result();
		$data = $this->db->query("SELECT recurring_journal_entry.*, journal_entry_master.* FROM recurring_journal_entry LEFT JOIN journal_entry_master ON recurring_journal_entry.entry_id = journal_entry_master.entry_id
		ORDER BY recurring_journal_entry.id DESC")->result();

		return $data;
	}
	function detailrecurring($id)
	{
		//$data=$this->db->query("SELECT * FROM recurring_journal_entry ORDER BY id desc")->result();
		$data = $this->db->query("SELECT recurring_journal_entry.*, journal_entry_master.* FROM recurring_journal_entry LEFT JOIN journal_entry_master ON recurring_journal_entry.entry_id = journal_entry_master.entry_id
		WHERE recurring_journal_entry.id = '" . $id . "' ORDER BY recurring_journal_entry.id DESC")->row();
		return $data;
	}
	function updaterecurring()
	{
		// echo"<pre>";
		// print_r($this->input->post());
		// exit;

		$query = $this->db->query("UPDATE recurring_journal_entry  SET name = '" . $this->input->post('name') . "', start_date = '" . $this->input->post('startdate') . "',
		frequency = '" . $this->db->escape_str($this->input->post('frequency')) . "',
		frequency_period = '" . $this->db->escape_str($this->input->post('frequencyr_period')) . "',end_date = '" . $this->input->post('enddate') . "' WHERE id = '" . $this->input->post('id')  . "'");
		return true;
	}

	function findcostcenter()
	{
		$data = $this->db->query("SELECT * FROM cost_center WHERE is_parent= '0'")->result();
		return $data;
	}

	function findaccount()
	{
		$account = $this->db->query("SELECT * FROM  chart_of_accounts  WHERE account_type = '1'")->result();

		return $account;
	}
}
