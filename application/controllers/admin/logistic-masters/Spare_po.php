<?php defined('BASEPATH') or exit('No direct script access allowed');

class Spare_po extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-masters/Spare_po_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_purchase_order_master', $this->action)) {
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
		$data['requisition_list'] = $this->Spare_po_model->requisition_list();
		//print_r($data);exit();
		return $this->load->view('admin/logistic-masters/spare-po/list', $data);
	}

	public function create_po()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_purchase_order_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('requisition_no', 'Requisition No.', 'trim|required');
		$this->form_validation->set_rules('po_date', 'PO Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect("admin/spare-parts/po/list");
		} else {
			$po_id = $this->Spare_po_model->createPO();
			if ($po_id > 0) {
				redirect("admin/spare-parts/po/edit?id=" . $po_id);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
				redirect("admin/spare-parts/po/list");
			}
		}
	}

	public function form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_purchase_order_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data = $this->Spare_po_model->get_detail($this->input->get('id'));
			//echo '<pre>';print_r($data);exit();
			if ($data['order']->requisition_type == 'local') {
				return $this->load->view('admin/logistic-masters/spare-po/edit', $data);
			} else {
				return $this->load->view('admin/logistic-masters/spare-po/edit-international', $data);
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request Id!!");
			redirect("admin/spare-parts/po/list");
		}
	}

	public function update()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('po_id', 'PO ID', 'trim|required');
		$this->form_validation->set_rules('part_id[]', 'Part No.', 'trim|required');
		$this->form_validation->set_rules('item_code[]', 'Item Code', 'trim|required');
		$this->form_validation->set_rules('spare_part_name[]', 'Part Name', 'trim|required');
		$this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('price[]', 'Unit Price', 'trim|required');
		$this->form_validation->set_rules('line_total[]', 'Line Total', 'trim|required');
		$this->form_validation->set_rules('sub_total', 'Sub Total', 'trim|required');
		$this->form_validation->set_rules('total', 'Final Total', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('po_id')) {
				//echo '<pre>';print_r($this->input->post());exit();
				$query = $this->Spare_po_model->edit();
				//print_r($query);exit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect("admin/spare-parts/po/edit?id=" . $this->input->post('po_id'));
	}

	public function update_international()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('po_id', 'PO ID', 'trim|required');
		$this->form_validation->set_rules('part_id[]', 'Part No.', 'trim|required');
		$this->form_validation->set_rules('item_code[]', 'Item Code', 'trim|required');
		$this->form_validation->set_rules('spare_part_name[]', 'Part Name', 'trim|required');
		$this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('fcy[]', 'FCY', 'trim|required');
		$this->form_validation->set_rules('line_total[]', 'Line Total', 'trim|required');
		$this->form_validation->set_rules('sub_total', 'Sub Total', 'trim|required');
		$this->form_validation->set_rules('total', 'Final Total', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('po_id')) {
				//echo '<pre>';print_r($this->input->post());exit();
				$query = $this->Spare_po_model->edit_international();
				//print_r($query);exit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect("admin/spare-parts/po/edit?id=" . $this->input->post('po_id'));
	}

	public function get_list()
	{
		if (!empty($this->input->get('po_no'))) {
			$po_no = $this->input->get('po_no');
		} else {
			$po_no = FALSE;
		}
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
		$fetch_data = $this->Spare_po_model->get_list($po_no, $requisition_no, $startDate, $endDate, $requisition_type, $status);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $job) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $job->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $job->po_no;
			$sub_array[] = date("d-m-Y", strtotime($job->po_date));
			$sub_array[] = $job->vendor_name;
			$sub_array[] = $job->total_item;
			$sub_array[] = $job->total_qty;
			$sub_array[] = $job->total_fcy;
			$sub_array[] = $job->total_cost;
			$sub_array[] = $job->requisition_no;
			$sub_array[] = $job->mrv_no;
			$sub_array[] = $job->delivery_date;
			$sub_array[] = $job->status == '1' ? '<span class="badge badge-pill badge-soft-warning font-size-13">Open</span>' : '<span class="badge badge-pill badge-soft-success font-size-13">Closed</span>';
			//$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="'.base_url().'admin/spare-parts/po/print?id='.$job->id.'" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/spare-parts/po/edit?id='.$job->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/spare-parts/po/detail?id='.$job->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			$sub_array[] = (check_action_permission(get_user_role(), 'sp_purchase_order_master', 'po_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/spare-parts/po/detail?id=' . $job->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'sp_purchase_order_master', 'form') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/spare-parts/po/edit?id=' . $job->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Spare_po_model->get_all_data(),
			"recordsFiltered"     =>     $this->Spare_po_model->get_filtered_data($po_no, $requisition_no, $startDate, $endDate, $requisition_type, $status),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function po_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_purchase_order_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$data = $this->Spare_po_model->get_detail($id);
			//echo '<pre>';print_r($data);exit();
			return $this->load->view('admin/logistic-masters/spare-po/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request Id!!");
			redirect("admin/spare-parts/po/list");
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_purchase_order_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('check_list');
		$query = $this->Spare_po_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/spare-parts/requisition/list');
	}

	function get_requisition_detail()
	{
		$requisition_no = $this->input->post('requisition_no');
		$query = $this->db->query("SELECT spr.*, v.vendor_name, v.vendor_arabic_name, v.cr_no, v.contact_person_name, v.vat_no FROM spare_parts_requisition spr LEFT JOIN vendors v ON(spr.supplier_id = v.id) WHERE spr.id = '" . (int)$requisition_no . "'")->row();
		echo json_encode($query);
	}

	/*------ Search product -----*/
	public function get_search_list()
	{
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Spare_po_model->get_search_hint($data['term']);
		echo json_encode($data);
	}

	public function print_requisition()
	{
		$this->load->library('Pdf_requisition');
		$id = $this->input->get('id');
		$order = $this->Spare_po_model->get_detail($id);
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
