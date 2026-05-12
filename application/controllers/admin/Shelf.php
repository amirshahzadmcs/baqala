<?php defined('BASEPATH') or exit('No direct script access allowed');

class Shelf extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Shelf_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_shelves', $this->action)) {
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
		$data['racks'] = $this->Shelf_model->get_racks();
		$this->load->view('admin/shelf/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Shelf_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $shelf) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $shelf->id . '" name="check_list[]" />';
			$sub_array[] = $shelf->rack_id;
			$sub_array[] = $shelf->rack_name;
			$sub_array[] = $shelf->shelf_name;
			$sub_array[] = $shelf->id;
			$sub_array[] = $shelf->total_products;
			$sub_array[] = $shelf->status == 1 ? '<div class="label label-success">Active</div>' : '<div class="label label-danger">Deactive</div>';
			$sub_array[] = $shelf->created_at;
			$sub_array[] = $shelf->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'manage_shelves', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/shelf/add?id=' . $shelf->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                    =>     intval($_POST["draw"]),
			"recordsTotal"          =>      $this->Shelf_model->get_all_data(),
			"recordsFiltered"     =>     $this->Shelf_model->get_filtered_data(),
			"data"                    =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_shelves', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Shelf_model->get_product_shelf_by_id($this->input->get('id'))->row();
			$data['id'] = $query->id;
			$data['rack_id'] = $query->rack_id;
			$data['shelf_name'] = $query->shelf_name;
			$data['status'] = $query->status;
		} else {
			$data['id'] = "";
			$data['rack_id'] = "";
			$data['shelf_name'] = "";
			$data['status'] = "";
		}
		$data['racks'] = $this->Shelf_model->get_racks();
		$this->load->view('admin/shelf/form', $data);
	}

	public function add_shelf()
	{
		$this->form_validation->set_rules('rack_id', 'Select Rack', 'trim|required');
		$this->form_validation->set_rules('shelf_name', 'Shelf Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$is_exist = $this->Shelf_model->check_shelf_exist();
			if ($is_exist) {
				if ($this->input->post('id')) {
					$query = $this->Shelf_model->edit();
				} else {
					$query = $this->Shelf_model->add();
				}
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully done");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			} else {
				$this->session->set_userdata('info', "2--Already exist!!!");
			}
		}
		redirect('admin/shelf/list');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_shelves', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Shelf_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/shelf/list');
	}
}
