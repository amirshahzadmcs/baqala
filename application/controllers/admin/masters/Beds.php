<?php defined('BASEPATH') or exit('No direct script access allowed');

class Beds extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/Bed_model', 'bed_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'beds', $action) && !in_array($action, ['save', 'get_list'])):
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
		return $this->load->view('admin/masters/beds/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->bed_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->camp_name;
			$sub_array[] = $brand->room_name;
			$sub_array[] = $brand->bed_name;
			$sub_array[] = $brand->bed_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/master/beds/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->bed_model->get_all_data(),
			"recordsFiltered" => $this->bed_model->get_filtered_data(),
			"data"            => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->bed_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['room_id'] = $query->room_id;
				$data['bed_name'] = $query->bed_name;
				$data['bed_name_ar'] = $query->bed_name_ar;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['room_id'] = "";
			$data['bed_name'] = "";
			$data['bed_name_ar'] = "";
			$data['status'] = "";
		}
		return $this->load->view('admin/masters/beds/form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('room_id', 'Room Name', 'trim|required');
			$this->form_validation->set_rules('bed_name', 'Bed Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('room_id', 'Room Name', 'trim|required');
			$this->form_validation->set_rules('bed_name', 'Bed Name', 'trim|required|is_unique[master_bed.bed_name]', array('is_unique' => 'Duplicate Bed Name.'));
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->bed_model->edit();
			} else {
				$query = $this->bed_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/beds');
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->bed_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/beds');
	}
}
