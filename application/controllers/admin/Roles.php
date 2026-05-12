<?php defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Roles_model');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'roles', $action) && $action != 'get_list') {
				redirect('admin/unauthorized-request');
			}
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		//$data['result'] = $this->Roles_model->get_list();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/roles/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Roles_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $role) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $role->id . '" name="check_list[]" />';
			$sub_array[] = $role->name;
			$sub_array[] = $role->arabic_name ?? '';
			$sub_array[] = $role->is_active == '1' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $role->is_superadmin == '1' ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span>' : '<span class="badge badge-pill badge-soft-dark font-size-13">No</span>';
			$sub_array[] = $role->created_at;
			$sub_array[] = check_action_permission(get_user_role(), 'roles', 'quick_edit') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="quickEdit(' . $role->id . ')"><i class="mdi mdi-pencil font-size-18"></i></button>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Roles_model->get_all_data(),
			"recordsFiltered"     =>     $this->Roles_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function quick_edit()
	{
		$this->form_validation->set_rules('role_id', 'Role ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$data = $this->Roles_model->get_detail($this->input->post('role_id'))->row();
			$output_data = $this->load->view('admin/roles/edit-form', $data, TRUE);
			//echo json_encode($data);
			echo $output_data;
		}
	}

	public function add()
	{
		$this->form_validation->set_rules('name', 'Role Name', 'trim|required|callback_valid_check_exists');
		$this->form_validation->set_message('valid_check_exists', 'Record already exists, Try new');

		$this->form_validation->set_rules('is_active', 'Status', 'trim|required');
		// $this->form_validation->set_rules('is_superadmin', 'Is Superadmin', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Roles_model->edit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			} else {
				$query = $this->Roles_model->add();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully added");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/roles/list');
	}

	public function valid_check_exists($str)
	{
		$name = $this->input->post('name');
		$id = $this->input->post('id');

		if (!isset($id)) {
			$id = 0;
		}
		if ($this->Roles_model->check_data_exists($name, $id)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Roles_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/roles/list');
	}
}
