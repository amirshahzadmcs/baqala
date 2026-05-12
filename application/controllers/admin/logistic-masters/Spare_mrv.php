<?php defined('BASEPATH') or exit('No direct script access allowed');

class Spare_mrv extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-masters/Spare_mrv_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_mrv_master', $this->action)) {
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
		$data['po_list'] = $this->Spare_mrv_model->spare_po_list();
		//print_r($data);exit();
		return $this->load->view('admin/logistic-masters/spare-mrv/list', $data);
	}

	public function create()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_mrv_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('po_no', 'PO Number', 'trim|required');
		$this->form_validation->set_rules('mrv_date', 'MRV Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect("admin/spare-parts/mrv/list");
		} else {
			$po_id = $this->Spare_mrv_model->create();
			if ($po_id > 0) {
				redirect("admin/spare-parts/mrv/edit?id=" . $po_id);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
				redirect("admin/spare-parts/mrv/list");
			}
		}
	}

	public function form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_mrv_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data = $this->Spare_mrv_model->get_detail($this->input->get('id'));
			//echo '<pre>';print_r($data);exit();
			return $this->load->view('admin/logistic-masters/spare-mrv/edit', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request Id!!");
			redirect("admin/spare-parts/mrv/list");
		}
	}

	public function update()
	{
		//print_r($this->input->post());exit();
		$this->form_validation->set_rules('mrv_id', 'MRV ID', 'trim|required');
		$this->form_validation->set_rules('part_id[]', 'Part No.', 'trim|required');
		$this->form_validation->set_rules('item_code[]', 'Item Code', 'trim|required');
		$this->form_validation->set_rules('spare_part_name[]', 'Part Name', 'trim|required');
		$this->form_validation->set_rules('qty[]', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('received_qty[]', 'Received Qty.', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('mrv_id')) {
				$query = $this->Spare_mrv_model->edit();
				//print_r($query);exit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect("admin/spare-parts/mrv/edit?id=" . $this->input->post('mrv_id'));
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
				$query = $this->Spare_mrv_model->edit_international();
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
		if (!empty($this->input->get('mrv_no'))) {
			$mrv_no = $this->input->get('mrv_no');
		} else {
			$mrv_no = FALSE;
		}
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
		$fetch_data = $this->Spare_mrv_model->get_list($mrv_no, $po_no, $requisition_no, $startDate, $endDate, $requisition_type, $status);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $job) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $job->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $job->mrv_no;
			$sub_array[] = date("d-m-Y", strtotime($job->mrv_date));
			$sub_array[] = $job->vendor_name;
			$sub_array[] = $job->total_item;
			$sub_array[] = $job->total_qty;
			$sub_array[] = $job->total_fcy;
			$sub_array[] = $job->total_cost;
			$sub_array[] = $job->requisition_no;
			$sub_array[] = $job->po_no;
			$sub_array[] = $job->status == '1' ? '<span class="badge badge-pill badge-soft-warning font-size-13">Open</span>' : '<span class="badge badge-pill badge-soft-success font-size-13">Closed</span>';
			//$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" href="'.base_url().'admin/spare-parts/po/print?id='.$job->id.'" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/spare-parts/po/edit?id='.$job->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/spare-parts/po/detail?id='.$job->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			$sub_array[] = (check_action_permission(get_user_role(), 'sp_mrv_master', 'mrv_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/spare-parts/mrv/detail?id=' . $job->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'sp_mrv_master', 'form') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/spare-parts/mrv/edit?id=' . $job->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Spare_mrv_model->get_all_data(),
			"recordsFiltered"     =>     $this->Spare_mrv_model->get_filtered_data($mrv_no, $po_no, $requisition_no, $startDate, $endDate, $requisition_type, $status),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function mrv_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_mrv_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$data = $this->Spare_mrv_model->get_detail($id);
			//echo '<pre>';print_r($data);exit();
			return $this->load->view('admin/logistic-masters/mrv/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request Id!!");
			redirect("admin/spare-parts/mrv/list");
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sp_mrv_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('check_list');
		$query = $this->Spare_mrv_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/spare-parts/mrv/list');
	}

	function get_po_detail()
	{
		$po_no = $this->input->post('po_no');
		$query = $this->db->query("SELECT spr.*, v.vendor_name, v.vendor_arabic_name, v.cr_no, v.contact_person_name, v.vat_no FROM spare_parts_po spr LEFT JOIN vendors v ON(spr.supplier_id = v.id) WHERE spr.id = '" . (int)$po_no . "'")->row();
		echo json_encode($query);
	}
}
