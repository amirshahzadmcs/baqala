<?php defined('BASEPATH') or exit('No direct script access allowed');

class Grv extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Purchase_model');
			$this->load->model('admin/Vendor_model');
			$this->load->model('admin/Grv_model');
			$this->load->model('admin/Inventory_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'goods_received_voucher', $this->action)) {
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
		$this->load->view('admin/grv/list', $data);
	}

	public function generate_grv()
	{
		$this->form_validation->set_rules('id', 'PO ID', 'trim|required');
		$this->form_validation->set_rules('sup_invoice_no', 'Supplier Invoice No', 'trim|required');
		$this->form_validation->set_rules('invoice_date', 'Invoice Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$id = (int)$this->input->post('id');
			if ($id > 0) {
				$query = $this->Grv_model->add($id);
				if ($query > 0) {
					$this->Purchase_model->setStatusEnable($id);
					$this->session->set_userdata('info', "1--GRV Successfully Generated");
					redirect("admin/grv/add?id=" . $query);
					exit();
				} else {
					$this->session->set_userdata('info', "2--Error");
				}
			} else {
				$this->session->set_userdata('info', "2--Not Valid");
			}
		}
		$data = $this->Purchase_model->get_order_detail($id);
		$this->load->view('admin/purchase_order/detail', $data);
	}

	public function form()
	{
		if ($this->input->get('id')) {
			$data = $this->Grv_model->get_detail($this->input->get('id'));
			$this->load->view('admin/grv/grv-form', $data);
		} else {
			$this->load->view('admin/grv/list');
		}
	}

	public function update_grv()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('id', 'GRV ID', 'trim|required');
		$this->form_validation->set_rules('po_id', 'PO ID', 'trim|required');
		$this->form_validation->set_rules('item_id[]', 'Item ID', 'trim|required');
		$this->form_validation->set_rules('received_qty[]', 'Select Vendor', 'trim|required');
		$this->form_validation->set_rules('sellable_qty[]', 'Sellable Qty', 'trim|required');
		$this->form_validation->set_rules('unsellable_qty[]', 'Unsellable Qty', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			$id = $this->input->post('id');
			redirect('admin/grv/add?id=' . $id);
		} else {
			if ($this->input->post('po_id')) {
				$query = $this->Grv_model->updateGrv();
			} else {
				$this->session->set_userdata('info', "2--Invalid GRV");
				$id = $this->input->post('id');
				redirect('admin/grv/add?id=' . $id);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
				$id = $this->input->post('id');
				redirect('admin/grv/add?id=' . $id);
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
				$id = $this->input->post('id');
				redirect('admin/grv/add?id=' . $id);
			}
		}
		$id = $this->input->post('id');
		redirect('admin/grv/add?id=' . $id);
	}

	public function get_list()
	{
		$fetch_data = $this->Grv_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $order) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $order->invoice_prefix . '-' . $order->grv_no;
			$sub_array[] = $order->po_no;
			$sub_array[] = $order->vendor;
			$sub_array[] = date("d-m-Y", strtotime($order->created_at));
			$sub_array[] = $order->grv_value . ' SAR';
			$sub_array[] = ($order->grv_status == 'open') ? '<span class="badge badge-pill badge-soft-info font-size-13">Open</span>' : (($order->grv_status == 'closed') ? '<span class="badge badge-pill badge-soft-success font-size-13">Closed</span>' : (($order->grv_status == 'rejected') ? '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>' : '<span class="badge badge-pill badge-soft-warning font-size-13">NULL</span>'));
			$sub_array[] = date("d-m-Y h:i A", strtotime($order->created_at));
			$sub_array[] = date("d-m-Y h:i A", strtotime($order->updated_at));
			$sub_array[] = (check_action_permission(get_user_role(), 'goods_received_voucher', 'print_invoice') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="' . base_url() . 'admin/grv/print_invoice?id=' . $order->id . '" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'goods_received_voucher', 'grv_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/grv/detail?id=' . $order->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->Grv_model->get_all_data(),
			"recordsFiltered" => $this->Grv_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function setStatusEnable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Purchase_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/purchase_order');
		} else {
			redirect('admin');
		}
	}

	public function grv_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'goods_received_voucher', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data = $this->Grv_model->get_detail($this->input->get('id'));
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/grv/detail', $data);
	}

	public function close_grv()
	{
		$id = $this->input->get('id');
		$query = $this->Grv_model->close_grv($id);
		if ($query) {
			$this->Inventory_model->updateStock($id);
			$this->session->set_userdata('info', "1--GRV Successfully Closed");
		} else {
			$this->session->set_userdata('info', "2--Something went wrong.");
		}
		//echo '<pre>';print_r($data);exit();
		redirect("admin/grv/detail?id=" . $id);
	}

	public function reject_grv()
	{
		$id = $this->input->get('id');
		$query = $this->Grv_model->reject_grv($id);
		if ($query) {
			$this->session->set_userdata('info', "1--GRV Successfully Rejected");
		} else {
			$this->session->set_userdata('info', "2--Something went wrong.");
		}
		//echo '<pre>';print_r($data);exit();
		redirect("admin/grv/detail?id=" . $id);
	}

	public function print_invoice()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'goods_received_voucher', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_grv');
		$id = $this->input->get('id');
		$order = $this->Grv_model->get_detail($id);
		// create new PDF document
		$pdf = new Pdf_grv(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Tax Invoice/Good Received Voucher/Cash Memo');
		$pdf->SetSubject('Good Received Voucher');
		$pdf->SetKeywords('Baqala Station, PDF, Invoice, Order, Groceries');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/grv/invoice_header', $order, true);
		$htmlHeader2 = $this->load->view('admin/grv/invoice_header2', $order, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/grv/footer_last', $order, true);
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
		$pdf->SetMargins(1, 60, 4, true);

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
		$htmlcontent = $this->load->view('admin/grv/print_invoice', $order, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('good-received-voucher-' . $id . '.pdf', 'I');
	}
}
