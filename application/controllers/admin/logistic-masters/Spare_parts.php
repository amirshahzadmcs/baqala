<?php defined('BASEPATH') or exit('No direct script access allowed');

class Spare_parts extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-masters/Spare_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_spare_parts', $this->action)) {
			redirect('admin/unauthorezed-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/logistic-masters/spare-parts/list', $data);
	}

	public function get_list()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
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
		$fetch_data = $this->Spare_model->get_list($keyword, $startDate, $endDate, $status);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $spare) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $spare->id . '" name="check_list[]" />';
			$sub_array[] = $i++;
			$sub_array[] = $spare->make_name;
			$sub_array[] = $spare->vehicle_model;
			$sub_array[] = $spare->item_code;
			$sub_array[] = $spare->part_name_en . '<br>' . $spare->part_name_ar;
			/*
			$sub_array[] = $spare->quantity;
			$sub_array[] = $spare->cost_price;
			$sub_array[] =  ($spare->available_qty > 0) ? $spare->available_qty. ' <button type="button" class="btn btn-link btn-sm text-dark log-button" onclick="quickView('. $spare->id .')"><i class="mdi mdi-history font-size-20"></i></button>' : $spare->available_qty;
			$sub_array[] = (isset($spare->qty_in)) ? $spare->qty_in : '0';
			$sub_array[] = (isset($spare->qty_out)) ? $spare->qty_out.'<button type="button" class="btn btn-link btn-sm text-dark log-button" onclick="quickViewJob('. $spare->id .')"><i class="mdi mdi-history font-size-20"></i></button>' : '0';
			*/
			$sub_array[] = $spare->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y H:i:s', strtotime($spare->created_at));
			$sub_array[] = isset($spare->updated_at) ? date('d-m-Y H:i:s', strtotime($spare->updated_at)) : '';
			$sub_array[] =  (check_action_permission(get_user_role(), 'vehicle_spare_parts', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/spare-parts/add?id=' . $spare->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'vehicle_spare_parts', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/spare-parts/detail?id=' . $spare->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Spare_model->get_all_data(),
			"recordsFiltered"     =>     $this->Spare_model->get_filtered_data($keyword, $startDate, $endDate, $status),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_spare_parts', $this->action)) {
			redirect('admin/unauthorezed-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Spare_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['vehicle_make'] = $query->vehicle_make;
				$data['vehicle_model'] = $query->vehicle_model;
				$data['item_code'] = $query->item_code;
				$data['part_name_en'] = $query->part_name_en;
				$data['part_name_ar'] = $query->part_name_ar;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['vehicle_make'] = "";
			$data['vehicle_model'] = "";
			$data['item_code'] = "";
			$data['part_name_en'] = "";
			$data['part_name_ar'] = "";
			$data['status'] = "";
		}
		$data['vehicle_makes'] = $this->db->query("SELECT * FROM mater_van_make WHERE service_type = 'bike' AND deleted = '0' AND status = '1'")->result();
		$this->load->view('admin/logistic-masters/spare-parts/form', $data);
	}

	function get_vehicle_type()
	{
		$make_id = $this->input->post('make_id');
		$query = $this->db->query("SELECT * FROM master_vehicle_type WHERE make_id = '" . $make_id . "' AND status = '1'")->result();
		echo json_encode($query);
	}

	public function save()
	{
		$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required');
		$this->form_validation->set_rules('part_name_en', 'Parts Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Spare_model->edit();
			} else {
				$query = $this->Spare_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/spare-parts/list');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_spare_parts', $this->action)) {
			redirect('admin/unauthorezed-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Spare_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/spare-parts/list');
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_spare_parts', $this->action)) {
			redirect('admin/unauthorezed-request');
		}
		$id = $this->input->get('id');
		//print_r($id);exit();
		if ($id) {
			$detail = $this->Spare_model->detail($id)->row();
			//print_r($detail);exit();
			if (!empty($detail)) {
				return $this->load->view('admin/logistic-masters/spare-parts/detail', $detail);
			} else {
				$this->session->set_userdata('info', "2--Detail not found!!!");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!!");
		}
		redirect('admin/spare-parts/list');
	}

	public function update_stock()
	{
		$this->form_validation->set_rules('prod_id', 'Item Id', 'trim|required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');
		$this->form_validation->set_rules('stock_type', 'Stock Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$this->session->set_userdata('info', '2--' . $msg);
		} else {
			if ($this->input->post('stock_type') == 'in') {
				$query = $this->Spare_model->stock_in();
				if ($query) {
					$this->session->set_userdata('info', "1--Stock successfully In.");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			} else {
				$query = $this->Spare_model->stock_out();
				if ($query) {
					$this->session->set_userdata('info', "1--Stock successfully Out.");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/spare-parts/list');
	}

	//Inventory Log
	public function inventory_log()
	{
		$this->form_validation->set_rules('prod_id', 'Item ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$data = $this->Spare_model->get_quick_detail();
			$output_data = $this->load->view('admin/logistic-masters/spare-parts/spare-log', $data, TRUE);
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}

	//Partial Job card List
	public function log_job_cards()
	{
		$this->form_validation->set_rules('prod_id', 'Item ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$data = $this->Spare_model->get_log_jobcard();
			if ($data) {
				$output_data = $this->load->view('admin/logistic-masters/spare-parts/job-card-list', $data, TRUE);
			} else {
				$output_data = 'Data not found';
			}
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}
}
