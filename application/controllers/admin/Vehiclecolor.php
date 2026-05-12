<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vehiclecolor extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Vehiclecolor_model');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'branches', $action) && !in_array($action, ['save', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/delivery-master/vehicle-color-list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Vehiclecolor_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->color_name;
			$sub_array[] = $brand->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'colors', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/vehiclecolor/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Vehiclecolor_model->get_all_data(),
			"recordsFiltered"     =>     $this->Vehiclecolor_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Vehiclecolor_model->van_make_by_id($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['color_name'] = $query->color_name;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['color_name'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/delivery-master/vehicle-color-form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('color_name', 'Color Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('color_name', 'Color Name', 'trim|required|is_unique[master_color.color_name]', array('is_unique' => 'Duplicate make name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Vehiclecolor_model->edit();
			} else {
				$query = $this->Vehiclecolor_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/vehiclecolor');
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Vehiclecolor_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/vehiclecolor');
	}
}
