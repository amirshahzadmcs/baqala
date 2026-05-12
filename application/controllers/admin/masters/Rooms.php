<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rooms extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/Room_model', 'room_model');
			$this->load->helper('common_helper');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'rooms', $action) && !in_array($action, ['save', 'get_list'])):
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
		return $this->load->view('admin/masters/rooms/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->room_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->camp_name;
			$sub_array[] = $brand->room_name;
			$sub_array[] = $brand->room_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'rooms', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/master/rooms/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->room_model->get_all_data(),
			"recordsFiltered" => $this->room_model->get_filtered_data(),
			"data"            => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->room_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['camp_id'] = $query->camp_id;
				$data['room_name'] = $query->room_name;
				$data['room_name_ar'] = $query->room_name_ar;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['camp_id'] = "";
			$data['room_name'] = "";
			$data['room_name_ar'] = "";
			$data['status'] = "";
		}
		return $this->load->view('admin/masters/rooms/form', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('camp_id', 'Camp Name', 'trim|required');
		$this->form_validation->set_rules('room_name', 'Room Name', 'trim|required|callback_check_unique_room');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->room_model->edit();
			} else {
				$query = $this->room_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/rooms');
	}

	public function check_unique_room($room_name)
	{
		$camp_id = $this->input->post('camp_id');
		$id = $this->input->post('id');
		$this->db->where('camp_id', $camp_id);
		$this->db->where('room_name', $room_name);

		if ($id) { // If updating, exclude the current record from the check
			$this->db->where('id !=', $id);
		}

		$query = $this->db->get('master_rooms');
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('check_unique_room', 'The combination of Camp Name and Room Name already exists.');
			return FALSE;
		} else {
			return TRUE;
		}
	}


	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->room_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/rooms');
	}
}
