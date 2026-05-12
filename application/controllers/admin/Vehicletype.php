<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vehicletype extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Vehicletype_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_type_master', $this->action)):
			redirect('admin/unauthorized');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/delivery-master/vehicle-type-list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Vehicletype_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $value) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $value->id . '" name="check_list[]" />';
			$sub_array[] = $value->id;
			$sub_array[] =  ucfirst($value->vehicle_type);
			$sub_array[] = $value->make_name;
			$sub_array[] = $value->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $value->created_at;
			$sub_array[] = $value->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'vehicle_type_master', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/vehicletype/add?id=' . $value->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Vehicletype_model->get_all_data(),
			"recordsFiltered"     =>     $this->Vehicletype_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_type_master', $this->action)):
			redirect('admin/unauthorized');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Vehicletype_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['vehicle_type'] = $query->vehicle_type;
				$data['make_id'] = $query->make_id;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['vehicle_type'] = "";
			$data['make_id'] = "";
			$data['status'] = "";
		}
		$data['make_list'] = $this->Vehicletype_model->vehicle_make_list();
		//print_r($data);exit();
		$this->load->view('admin/delivery-master/vehicle-type-form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('make_id', 'Vehicle Make', 'trim|required');
			$this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('make_id', 'Vehicle Make', 'trim|required');
			$this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'trim|required|is_unique[master_vehicle_type.vehicle_type]', array('is_unique' => 'Duplicate make name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Vehicletype_model->edit();
			} else {
				$query = $this->Vehicletype_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/vehicletype');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicle_type_master', $this->action)):
			redirect('admin/unauthorized');
		endif;
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Vehicletype_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/vehicletype');
	}
}
