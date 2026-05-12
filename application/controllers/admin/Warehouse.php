<?php defined('BASEPATH') or exit('No direct script access allowed');

class Warehouse extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Warehouse_model');
			$this->load->library('form_validation');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_warehouse', $this->action)) {
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
		$this->load->view('admin/warehouse/list', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_warehouse', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Warehouse_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name_english'] = $query->name_english;
			$data['name_arabic'] = $query->name_arabic;
			$data['contact_person'] = $query->contact_person;
			$data['warehouse_email'] = $query->warehouse_email;
			$data['warehouse_phone'] = $query->warehouse_phone;
			$data['partner_code'] = $query->partner_code;
			$data['processing_time'] = $query->processing_time;
			$data['warehouse_map'] = $query->warehouse_map;
			$data['complete_address'] = $query->complete_address;
			$data['status'] = $query->status;
		} else {
			$data['id'] = "";
			$data['name_english'] = "";
			$data['name_arabic'] = "";
			$data['contact_person'] = "";
			$data['warehouse_email'] = "";
			$data['warehouse_phone'] = "";
			$data['partner_code'] = "";
			$data['processing_time'] = "";
			$data['warehouse_map'] = "";
			$data['complete_address'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/warehouse/form', $data);
	}

	public function add_warehouse()
	{
		$this->form_validation->set_rules('name_english', 'Warehouse Name', 'trim|required');
		$this->form_validation->set_rules('name_arabic', 'Arabic Name', 'trim|required');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
		$this->form_validation->set_rules('warehouse_email', 'Warehouse Email', 'trim|required');
		$this->form_validation->set_rules('warehouse_phone', 'Warehouse Phone', 'trim|required');
		$this->form_validation->set_rules('partner_code', 'Partner Code', 'trim|required');
		$this->form_validation->set_rules('warehouse_map', 'Warehouse Map', 'trim|required');
		$this->form_validation->set_rules('complete_address', 'Complete Address', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Warehouse_model->edit();
			} else {
				$query = $this->Warehouse_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/warehouse');
	}

	public function get_list()
	{
		$fetch_data = $this->Warehouse_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $warehouse) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $warehouse->id . '" />';
			$sub_array[] = $warehouse->id;
			$sub_array[] = $warehouse->name_english . '<br/>' . $warehouse->name_arabic;
			$sub_array[] = $warehouse->contact_person;
			$sub_array[] = $warehouse->warehouse_email;
			$sub_array[] = $warehouse->warehouse_phone;
			$sub_array[] = $warehouse->partner_code;
			$sub_array[] = $warehouse->complete_address;
			$sub_array[] = $warehouse->status == 1 ? '<div class="label label-success">Enabled</div>' : '<div class="label label-danger">Disabled</div>';
			$sub_array[] = (check_action_permission(get_user_role(), 'manage_warehouse', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/warehouse/add?id=' . $warehouse->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'manage_warehouse', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/warehouse/detail?id=' . $warehouse->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Warehouse_model->get_all_data(),
			"recordsFiltered"     =>     $this->Warehouse_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_warehouse', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data['result'] = $this->Warehouse_model->get_detail($id);
		$this->load->view('admin/warehouse/detail', $data);
	}

	public function setStatusEnable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Warehouse_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/warehouse');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Warehouse_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/warehouse');
		} else {
			redirect('admin');
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_warehouse', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Warehouse_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/warehouse');
	}
}
