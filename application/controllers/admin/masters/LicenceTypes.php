<?php defined('BASEPATH') or exit('No direct script access allowed');

class LicenceTypes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/LicenceType_model', 'licencetype_model');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'licence_types', $action) && !in_array($action, ['save', 'get_list'])):
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
		return $this->load->view('admin/masters/licence-types/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->licencetype_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->licence_type;
			$sub_array[] = $brand->licence_type_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'licence_types', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/master/licence-type/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->licencetype_model->get_all_data(),
			"recordsFiltered" => $this->licencetype_model->get_filtered_data(),
			"data"            => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->licencetype_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['licence_type'] = $query->licence_type;
				$data['licence_type_ar'] = $query->licence_type_ar;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['licence_type'] = "";
			$data['licence_type_ar'] = "";
			$data['status'] = "";
		}
		return $this->load->view('admin/masters/licence-types/form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('licence_type', 'Licence Type', 'trim|required');
		} else {
			$this->form_validation->set_rules('licence_type', 'Licence Type', 'trim|required|is_unique[master_licence_type.licence_type]', array('is_unique' => 'Duplicate Licence Type.'));
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->licencetype_model->edit();
			} else {
				$query = $this->licencetype_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/licence-type');
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->licencetype_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/licence-type');
	}
}
