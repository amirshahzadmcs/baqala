<?php defined('BASEPATH') or exit('No direct script access allowed');

class DisputeTypes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/DisputeType_model', 'dispute_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'master_disputes_type', $this->action)) {
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
		//print_r($data['reports']);exit();
		return $this->load->view('admin/masters/dispute-types/index', $data);
	}


	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->dispute_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['dispute_type_en'] = $query->dispute_type_en;
			$data['dispute_type_ar'] = $query->dispute_type_ar;
		} else {
			$data['id'] = "";
			$data['dispute_type_en'] = "";
			$data['dispute_type_ar'] = "";
		}
		// print_r($data['nationality_no']);exit();
		return $this->load->view('admin/masters/dispute-types/form', $data);
	}

	public function save()
	{

		if ($this->action && !check_action_permission(get_user_role(), 'master_disputes_type', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('dispute_type_en', 'Dispute Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->dispute_model->edit();
			} else {
				$query = $this->dispute_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/masters/dispute-types');
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'master_disputes_type', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->dispute_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['dispute_type_en'] = $query->dispute_type_en;
			$data['dispute_type_ar'] = $query->dispute_type_ar;

			return $this->load->view('admin/masters/dispute-types/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/masters/dispute-types');
		}
	}

	public function get_list()
	{
		$fetch_data = $this->dispute_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $item->dispute_type_en;
			$sub_array[] = $item->dispute_type_ar;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			$sub_array[] = (!empty($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : 'NA';
			$sub_array[] = check_action_permission(get_user_role(), 'master_disputes_type', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/masters/dispute-types/add?id=' . $item->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';

			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->dispute_model->get_all_data(),
			"recordsFiltered" => $this->dispute_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'master_disputes_type', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->dispute_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/masters/dispute-types');
	}
}
