<?php defined('BASEPATH') or exit('No direct script access allowed');

class Nationality extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr/master/Nationality_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'nationalities', $action) && !in_array($action, ['save', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		} else {
			redirect('admin/common/login');
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
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/nationality/index', $data);
	}


	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Nationality_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
		} else {
			$data['id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
		}

		// print_r($data['nationality_no']);exit();
		$this->load->view('admin/hr/master/nationality/form', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Nationality_model->edit();
			} else {
				$query = $this->Nationality_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/nationality');
	}

	public function detail()
	{
		if ($this->input->get('id')) {
			$query = $this->Nationality_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;

			$this->load->view('admin/hr/master/nationality/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/master/nationality');
		}
	}

	public function get_list()
	{
		$fetch_data = $this->Nationality_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->id;
			$sub_array[] = $store->name;
			$sub_array[] = $store->arabic_name;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = check_action_permission(get_user_role(), 'nationalities', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/nationality/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/master/nationality/detail?id=' . $store->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Nationality_model->get_all_data(),
			"recordsFiltered"     =>     $this->Nationality_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Nationality_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/nationality');
	}
}
