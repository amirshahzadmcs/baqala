<?php defined('BASEPATH') or exit('No direct script access allowed');

class Servicearea extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Servicearea_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_area_master', $this->action)) {
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
		$this->load->view('admin/delivery-master/service-area-list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Servicearea_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->area_name;
			$sub_array[] = $brand->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'delivery_area_master', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/servicearea/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Servicearea_model->get_all_data(),
			"recordsFiltered"     =>     $this->Servicearea_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_area_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Servicearea_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['area_name'] = $query->area_name;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['area_name'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/delivery-master/service-area-form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('area_name', 'Area Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		} else {
			$this->form_validation->set_rules('area_name', 'Area Name', 'trim|required|is_unique[service_area.area_name]', array('is_unique' => 'Duplicate area name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Servicearea_model->edit();
			} else {
				$query = $this->Servicearea_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/servicearea');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'delivery_area_master', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Servicearea_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/servicearea');
	}
}
