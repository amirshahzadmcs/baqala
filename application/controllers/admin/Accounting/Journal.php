<?php defined('BASEPATH') or exit('No direct script access allowed');

class Journal extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Accounting/Journalentry');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('accounting_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['result'] = $this->Journalentry->entrydata();
		$this->load->view('admin/accounting/journalentries/journal_list', $data);
	}

	public function createjournal()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['costcenters'] = $this->Journalentry->allcostcenters();
		$data['journalnumber'] = $this->db->query("SELECT * FROM journal_entry_master ORDER BY id DESC")->row();
		$this->load->view('admin/accounting/journalentries/journal_create', $data);
	}

	public function multi_center()
	{
		$id = $this->input->get("id");
		$data['id'] = $id;
		$data['costcenters'] = $this->Journalentry->allcostcenters();
		$output_data = $this->load->view('admin/accounting/journalentries/multiple-center-partial', $data, TRUE);
		//echo '<pre>';print_r($data);exit();
		//echo json_encode($data);
		echo $output_data;
	}

	public function edit($entryid)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['result'] = $this->Journalentry->viewdetail($entryid);
		// echo"<pre>";
		// print_r($data);
		// exit;
		$this->load->view('admin/accounting/journalentries/journaledit', $data);
	}

	public function searchaccount()
	{
		if (!empty($_GET['type']) && $_GET['type'] == 'account_search') {
			$search_term = !empty($_GET['search']) ? $_GET['search'] : '';
			$query = $this->db->query("SELECT * FROM chart_of_accounts WHERE branch_name LIKE '%" . $search_term . "%'")->result_array();
			// Return results as json encoded array 
			echo json_encode($query);
		}
	}

	public function searchacostcenter()
	{
		if (!empty($_GET['type']) && $_GET['type'] == 'center_search') {
			$search_term = !empty($_GET['search']) ? $_GET['search'] : '';
			$query = $this->db->query("SELECT * FROM cost_center WHERE name LIKE '%" . $search_term . "%'")->result_array();
			// Return results as json encoded array 
			echo json_encode($query);
		}
	}

	public function journallogs()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['result'] = $this->Journalentry->entrydata();
		$journallogs = array();
		foreach ($data['result'] as $row) {
			$journallogs[] = getJournalAccountLog($row->entry_id);
		}
		$loglists['list'] = $journallogs;

		$this->load->view('admin/accounting/journalentries/journal_logs', $loglists);
	}
	public function journaldetails($entryid)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$data['result'] = $this->Journalentry->viewdetail($entryid);
		$this->load->view('admin/accounting/journalentries/journaldetails', $data);
	}

	public function journalpdf($entryid)
	{
		$this->load->library('Pdf_general');
		$data['result'] = $this->Journalentry->pdfview($entryid);

		$Pdf_quotation = new Pdf_general(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_quotation->SetCreator(PDF_CREATOR);
		$Pdf_quotation->SetAuthor('Baqala Station');
		$Pdf_quotation->SetTitle('jOURNAL ENTRY/ENTRY DETAILS');
		$Pdf_quotation->SetSubject('ACCOUNTING');
		$Pdf_quotation->SetKeywords('Baqala Station, PDF, ACCOUNTING, JOURNAL, ENTRY');

		// set header and footer fonts
		$Pdf_quotation->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_quotation->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$Pdf_quotation->SetMargins(10, 1, 10, true);
		$Pdf_quotation->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf_quotation->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf_quotation->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$Pdf_quotation->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$Pdf_quotation->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_quotation->AddPage();

		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_quotation->setRTL(false);

		// print newline
		$Pdf_quotation->Ln();
		// set font
		$Pdf_quotation->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/accounting/journalentries/logpdf', $data, true);;
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_quotation->Output('journallog.pdf', 'D');
	}

	public function journalprint($entryid)
	{
		$this->load->library('Pdf_general');
		$data['result'] = $this->Journalentry->pdfview($entryid);

		$Pdf_quotation = new Pdf_general(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$Pdf_quotation->SetCreator(PDF_CREATOR);
		$Pdf_quotation->SetAuthor('Baqala Station');
		$Pdf_quotation->SetTitle('jOURNAL ENTRY/ENTRY DETAILS');
		$Pdf_quotation->SetSubject('ACCOUNTING');
		$Pdf_quotation->SetKeywords('Baqala Station, PDF, ACCOUNTING, JOURNAL, ENTRY');

		// set header and footer fonts
		$Pdf_quotation->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$Pdf_quotation->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$Pdf_quotation->SetMargins(10, 1, 10, true);
		$Pdf_quotation->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$Pdf_quotation->SetHeaderMargin(PDF_MARGIN_HEADER);
		$Pdf_quotation->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$Pdf_quotation->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$Pdf_quotation->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$Pdf_quotation->AddPage();

		// Arabic and English content
		// set LTR direction for english translation
		$Pdf_quotation->setRTL(false);

		// print newline
		$Pdf_quotation->Ln();
		// set font
		$Pdf_quotation->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/accounting/journalentries/logpdf', $data, true);
		$Pdf_quotation->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$Pdf_quotation->Output('journallog', 'I');
	}

	public function add()
	{
		$this->form_validation->set_rules('journal_date', 'Journal Date', 'trim|required');
		$this->form_validation->set_rules('currency', 'Currency', 'trim|required');
		$this->form_validation->set_rules('journal_no', 'Journal Number', 'trim|required|callback_check_journal_duplicate');
		$this->form_validation->set_message('check_journal_duplicate', 'Journal number already exists, Try new');
		$this->form_validation->set_rules('journal_account_id[]', 'Account', 'trim|required');
		$this->form_validation->set_rules('debit[]', 'Debit', 'trim|required');
		$this->form_validation->set_rules('credit[]', 'Credit', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			//print_r($this->input->post());exit();
			$query = $this->Journalentry->add();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!!!");
			}
		}
		redirect('admin/accounting/journal/list');
	}

	public function check_journal_duplicate()
	{
		$id = $this->input->post('id');
		$journal_no = $this->input->post('journal_no');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Journalentry->check_duplicate_journal($id, $journal_no);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function ajax_check_journal()
	{
		$journal_no = $this->input->get('journal_no');
		$id = '';
		if ($journal_no !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Journalentry->check_duplicate_journal($id, $journal_no);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $journal_no . "</b> This Journal no. already exists. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Journal No. Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Journal no. is required.</span>";
		}
		echo json_encode($data);
	}

	public function cloneadd()
	{
		$add = $this->Journalentry->add();
		redirect('admin/accounting/journal/list');
	}

	public function update()
	{
		$update = $this->Journalentry->update_entry();
		redirect('admin/accounting/journal/list');
	}
	public function delete($entry_id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$delete = $this->Journalentry->delete_entry($entry_id);
		redirect('admin/accounting/journal/list');
	}

	public function clone($entry_id)
	{
		$clone['result'] = $this->Journalentry->viewdetail($entry_id);

		$this->load->view('admin/accounting/journalentries/journalclone', $clone);
	}

	//Reccurring Journal Profile

	public function recurring_profile($entry_id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'journal_entry_', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id['entry'] = $entry_id;
		$this->load->view('admin/accounting/journalentries/recurring_profile', $id);
	}

	public function addprofile()
	{
		$addre = $this->Journalentry->addprecurring();
		redirect('admin/accounting/recurring/recurring-profile');
	}

	public function recurringlist()
	{
		$recurring['profiles'] = $this->Journalentry->profilelist();
		$this->load->view('admin/accounting/journalentries/recurring_list', $recurring);
	}
	public function profiledetail($id)
	{
		$recurring['result'] = $this->Journalentry->detailrecurring($id);
		$this->load->view('admin/accounting/journalentries/recurring_profile_detail', $recurring);
	}
	public function editrecurring($id)
	{
		$recurring['result'] = $this->Journalentry->detailrecurring($id);

		$this->load->view('admin/accounting/journalentries/editrecurring', $recurring);
	}

	public function updateprofile()
	{
		// echo"<pre>";
		// print_r($this->input->post());
		// exit;
		$recurring[] = $this->Journalentry->updaterecurring();
		redirect('admin/accounting/recurring/recurring-profile');

		// $this->load->view('admin/accounting/journalentries/editrecurring',$recurring);

	}
}
