<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instant_visa extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect("admin");
		}
		$this->load->model('admin/Instant_visa_model', 'visa_model');
		$this->load->helper('common_helper');
		$this->load->library('form_validation');
		$this->action = $this->router->fetch_method();
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'visa', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['unified_nos'] = $this->visa_model->get_unified_nos();
		$data['sponsor_names'] = $this->visa_model->get_sponsor_names();
		$data['visa_issue_nos'] = $this->visa_model->get_visa_issue_nos();
		$data['embassys'] = $this->visa_model->get_embassys();
		//'<pre>';print_r($data);'</pre>';exit();
		return $this->load->view('admin/instant-visa/list', $data);
	}

	public function get_list()
	{
		if ($this->input->get('unified_no')) {
			$unified_no = $this->input->get('unified_no');
		} else {
			$unified_no = FALSE;
		}
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if ($this->input->get('from')) {
			$v_from = $this->input->get('from');
		} else {
			$v_from = FALSE;
		}
		if ($this->input->get('to')) {
			$v_to = $this->input->get('to');
		} else {
			$v_to = FALSE;
		}
		if ($this->input->get('visa_issue_no')) {
			$visa_issue_no = $this->input->get('visa_issue_no');
		} else {
			$visa_issue_no = FALSE;
		}
		if ($this->input->get('nationality')) {
			$nationality = $this->input->get('nationality');
		} else {
			$nationality = FALSE;
		}
		if ($this->input->get('occupation')) {
			$occupation = $this->input->get('occupation');
		} else {
			$occupation = FALSE;
		}
		if ($this->input->get('embassy')) {
			$embassy = $this->input->get('embassy');
		} else {
			$embassy = FALSE;
		}
		if ($this->input->get('agency')) {
			$agency = $this->input->get('agency');
		} else {
			$agency = FALSE;
		}
		$fetch_data = $this->visa_model->get_list($unified_no, $keyword, $v_from, $v_to, $visa_issue_no, $nationality, $occupation, $embassy, $agency);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->visa_issue_date));
			$sub_array[] = $item->visa_issue_no;
			$sub_array[] = $item->unified_no;
			$sub_array[] = $item->establishment_name;
			$sub_array[] = $item->sponsor_name;
			$sub_array[] = ($item->no_of_visa);
			$sub_array[] = ($item->used_border_entries);
			$sub_array[] = ($item->no_of_visa - $item->used_border_entries);
			$sub_array[] = $item->nationality_name;
			$sub_array[] = $item->profession_name;
			$sub_array[] = $item->embassy;
			$sub_array[] = ucfirst($item->gender);
			$sub_array[] = ucfirst($item->religion);
			$sub_array[] = ucfirst($item->agency_name);
			if ($item->vstatus == '0') {
				$visa_status = '<span class="badge badge-pill badge-soft-info font-size-13">New</span>';
			} elseif ($item->vstatus == '1') {
				$visa_status = '<span class="badge badge-pill badge-soft-success font-size-13">Wakala Issued</span>';
			} elseif ($item->vstatus == '2') {
				$visa_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Cancelled</span>';
			} else {
				$visa_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $visa_status;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			$sub_array[] = (isset($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : 'NA';
			$sub_array[] = (check_action_permission(get_user_role(), 'visa', 'edit') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/talent-aquisition/visa/edit?id=' . $item->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'visa', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/talent-aquisition/visa/detail?id=' . $item->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'visa', 'print_visa_detail') ? '<a type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit form-edit-btn" data-toggle="tooltip" title="Print" href="' . base_url('admin/talent-aquisition/visa/print-detail/' . $item->id) . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '');

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->visa_model->get_all_data(),
			"recordsFiltered"     =>     $this->visa_model->get_filtered_data($unified_no, $keyword, $v_from, $v_to, $visa_issue_no, $nationality, $occupation, $embassy, $agency),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'visa', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$query = $this->visa_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['visa_detail'] = $query->row();
			$data['visa_list'] =  $this->visa_model->get_group_visas($id);
			return $this->load->view('admin/instant-visa/edit', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/talent-aquisition/visa');
		}
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'visa', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$query = $this->visa_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['visa_detail'] = $query->row();
			$data['visa_list'] =  $this->visa_model->get_group_visas($id);
			return $this->load->view('admin/instant-visa/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/talent-aquisition/visa');
		}
	}

	public function save()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'visa', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('visa_issue_date', 'Visa Issue Date', 'trim|required');
		$this->form_validation->set_rules('unified_no', 'Unified No.', 'trim|required');
		$this->form_validation->set_rules('establishment_name', 'Establishment Name', 'trim|required');
		$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'trim|required');
		$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|required');
		$this->form_validation->set_rules('establishment_no', 'Establishment Number', 'trim|required');
		$this->form_validation->set_rules('visa_issue_no', 'Visa Issue Number', 'trim|required');
		$this->form_validation->set_rules('request_no', 'Request No', 'trim|required');
		$this->form_validation->set_rules('no_of_visa', 'No. of Visa', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('occupation', 'Occupation', 'trim|required');
		$this->form_validation->set_rules('embassy', 'Embassy', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('religion', 'Religion', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			// Handle file upload if file is present
			if ($_FILES['attachment']['name']) {
				$attachment = $this->upload_file('attachment');
			} else {
				$attachment = '';
			}
			$query = $this->visa_model->add($attachment);
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
				redirect('admin/talent-aquisition/visa/edit?id=' . $query);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}
		redirect('admin/talent-aquisition/visa');
	}

	public function update()
	{
		$this->form_validation->set_rules('visa_issue_date', 'Visa Issue Date', 'trim|required');
		$this->form_validation->set_rules('unified_no', 'Unified No.', 'trim|required');
		$this->form_validation->set_rules('establishment_name', 'Establishment Name', 'trim|required');
		$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'trim|required');
		$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|required');
		$this->form_validation->set_rules('establishment_no', 'Establishment Number', 'trim|required');
		$this->form_validation->set_rules('visa_issue_no', 'Visa Issue Number', 'trim|required');
		$this->form_validation->set_rules('request_no', 'Request No', 'trim|required');
		$this->form_validation->set_rules('no_of_visa', 'No. of Visa', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('occupation', 'Occupation', 'trim|required');
		$this->form_validation->set_rules('embassy', 'Embassy', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('religion', 'Religion', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			// Handle file upload if file is present
			if ($_FILES['attachment']['name']) {
				$attachment = $this->upload_file('attachment');
			} else {
				$attachment = $this->input->post('attachment_old');
			}
			$query = $this->visa_model->edit($attachment);
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/talent-aquisition/visa');
	}


	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'visa', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('checklist'));
		$query = $this->visa_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/talent-aquisition/visa');
	}

	/*------- Add Borders in Group ------*/
	public function add_visas()
	{
		//$this->form_validation->set_rules('visa_nos[]', 'Visa Number', 'trim|required');
		$this->form_validation->set_rules('border_nos[]', 'Border Number', 'trim|required');
		$this->form_validation->set_rules('visa_id', 'Visa ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$visa_id = $this->input->post('visa_id');
			//$visa_nos = $this->input->post('visa_nos');
			$border_nos = $this->input->post('border_nos');

			$updateArray = array();

			for ($x = 0; $x < sizeof($border_nos); $x++) {

				$updateArray[] = array(
					'instant_visa_id' => $visa_id,
					'border_nos' => $border_nos[$x]
				);
			}
			$query = $this->db->insert_batch('instant_visa_serials', $updateArray);
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}
		redirect('admin/talent-aquisition/visa/edit?id=' . $visa_id);
	}

	public function update_visas()
	{
		$this->form_validation->set_rules('border_nos[]', 'Border Number', 'trim|required');
		$this->form_validation->set_rules('visa_id', 'Visa ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$visa_id = $this->input->post('visa_id');
			$id = $this->input->post('id');
			$border_nos = $this->input->post('border_nos');

			$updateArray = array();

			for ($x = 0; $x < sizeof($id); $x++) {

				$updateArray[] = array(
					'id' => $id[$x],
					'border_nos' => $border_nos[$x]
				);
			}
			$query = $this->db->update_batch('instant_visa_serials', $updateArray, 'id');
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong!");
			}
		}
		redirect('admin/talent-aquisition/visa/edit?id=' . $visa_id);
	}

	public function upload_file($file)
	{
		$upload_path = './uploads/visa/';

		// Check if the folder exists, if not, create it
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true);
		}

		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
		$config['max_size']      = 0;
		$config['max_width']     = 0;
		$config['max_height']    = 0;
		$config['max_filename']  = '50';
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file)) {
			// Upload failed, display error
			$error = $this->upload->display_errors();
			return $error;
		} else {
			// Upload successful, get file data
			$file_data = $this->upload->data();
			$image = $upload_path . $file_data['file_name'];

			return $image;
		}
	}

	/*----- Print Start -----*/

	public function print_visa_detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'visa', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_general');
		$query = $this->visa_model->get_detail($id);
		$data['print_date'] = date('l, d F, Y');
		//$data['signature_date'] = date('jS F Y');
		$data['signature_date'] = date('j-M-Y');
		//dd($payment_center);
		if ($query->num_rows() > 0) {
			$data['visa_detail'] = $query->row();
			$data['visa_list'] =  $this->visa_model->get_group_visas($id);
			// create new PDF document
			$pdf = new Pdf_general(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Visa Details');
			$pdf->SetSubject('BS - Visa Details');
			$pdf->SetKeywords('Baqala Station, PDF, Visa Details');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(5, 0, 6, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage('L');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 8);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/instant-visa/print-detail', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('instant-visa-report-' . $data['visa_detail']->visa_issue_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Visa detail not found!");
			redirect('admin/talent-aquisition/visa');
		}
	}
}
