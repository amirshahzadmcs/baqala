<?php defined('BASEPATH') or exit('No direct script access allowed');

class Requisition extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-masters/Requisition_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_requisition_master', $this->action)) {
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
		//print_r($data['vehicles_list']);exit();
		return $this->load->view('admin/logistic-masters/requisition/list', $data);
	}

	public function create_requisition()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_requisition_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		//$this->form_validation->set_rules('requisition_id', 'Requisition ID', 'trim|required');
		$this->form_validation->set_rules('supplier_id', 'Supplier', 'trim|required');
		$this->form_validation->set_rules('requisition_type', 'Requisition Type', 'trim|required');
		$this->form_validation->set_rules('requisition_date', 'Requisition Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect("admin/spare-parts/requisition/list");
		} else {
			$requisition_id = $this->Requisition_model->createRequisition();
			if ($requisition_id > 0) {
				redirect("admin/spare-parts/requisition/edit?id=" . $requisition_id);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
				redirect("admin/spare-parts/requisition/list");
			}
		}
	}

	public function form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_requisition_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data = $this->Requisition_model->get_detail($this->input->get('id'));
			//echo '<pre>';print_r($data);exit();
			return $this->load->view('admin/logistic-masters/requisition/edit', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request Id!!");
			redirect("admin/spare-parts/requisition/list");
		}
	}

	public function update()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('requisition_id', 'Requisition ID', 'trim|required');
		$this->form_validation->set_rules('part_id[]', 'Part No.', 'trim|required');
		$this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('requisition_id')) {
				$query = $this->Requisition_model->edit();
				//print_r($query);exit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect("admin/spare-parts/requisition/list");
	}

	public function get_list()
	{
		if (!empty($this->input->get('requisition_no'))) {
			$requisition_no = $this->input->get('requisition_no');
		} else {
			$requisition_no = FALSE;
		}
		if (!empty($this->input->get('requisition_type'))) {
			$requisition_type = $this->input->get('requisition_type');
		} else {
			$requisition_type = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$startDate = $this->input->get('from');
		} else {
			$startDate = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$endDate = $this->input->get('to');
		} else {
			$endDate = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		$fetch_data = $this->Requisition_model->get_list($requisition_no, $startDate, $endDate, $requisition_type, $status);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $job) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $job->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $job->requisition_no;
			$sub_array[] = date("d-m-Y", strtotime($job->requisition_date));
			$sub_array[] = $job->vendor_name;
			$sub_array[] = $job->total_item;
			$sub_array[] = $job->total_qty;
			$sub_array[] = $job->status == '1' ? '<span class="badge badge-pill badge-soft-warning font-size-13">Open</span>' : '<span class="badge badge-pill badge-soft-success font-size-13">Closed</span>';
			$sub_array[] =  (check_action_permission(get_user_role(), 'sp_requisition_master', 'print_requisition') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="' . base_url() . 'admin/spare-parts/requisition/print?id=' . $job->id . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'sp_requisition_master', 'form') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/spare-parts/requisition/edit?id=' . $job->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Requisition_model->get_all_data(),
			"recordsFiltered"     =>     $this->Requisition_model->get_filtered_data($requisition_no, $startDate, $endDate, $requisition_type, $status),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function requisition_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_requisition_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$data = $this->Requisition_model->get_detail($id);
			//echo '<pre>';print_r($data);exit();
			return $this->load->view('admin/logistic-masters/requisition/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request Id!!");
			redirect("admin/spare-parts/requisition/list");
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_requisition_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('check_list');
		$query = $this->Requisition_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/spare-parts/requisition/list');
	}

	function get_spare_suppliers()
	{
		$vendor_type = $this->input->post('supplier_type');
		$query = $this->db->query("SELECT * FROM vendors WHERE (vendor_type = '" . $vendor_type . "' AND spare_part_supplier = '1' AND status = '1')")->result();
		echo json_encode($query);
	}

	/*------ Search product -----*/
	public function get_search_list()
	{
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Requisition_model->get_search_hint($data['term']);
		echo json_encode($data);
	}

	public function print_requisition()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_requisition_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_requisition');
		$id = $this->input->get('id');
		$order = $this->Requisition_model->get_detail($id);
		//print_r($order);exit();
		// create new PDF document
		$pdf = new Pdf_requisition(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('SP Requisition Master');
		$pdf->SetSubject('SP Requisition Master');
		$pdf->SetKeywords('Baqala Station, PDF, SP Requisition Master, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-masters/requisition/print/header', $order, true);
		$htmlHeader2 = $this->load->view('admin/logistic-masters/requisition/print/header2', $order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-masters/requisition/print/footer', $order, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(0, 60, 0, true);

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
		$pdf->AddPage();
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/logistic-masters/requisition/print/print', $order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('SP Requisition Master' . $order['order']->id . '.pdf', 'I');
	}
}
