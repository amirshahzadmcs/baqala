<?php defined('BASEPATH') or exit('No direct script access allowed');

class Qiwastatus extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/Qiwastatus_model', 'qiwa_status');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'qiwa_status', $action) && !in_array($action, ['save', 'get_list'])):
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
		return $this->load->view('admin/masters/qiwa-status/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->qiwa_status->get_list();
		// $i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->qiwa_status_name;
			$sub_array[] = $brand->qiwa_status_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'qiwa_status', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/master/qiwa-status/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->qiwa_status->get_all_data(),
			"recordsFiltered" => $this->qiwa_status->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->qiwa_status->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['qiwa_status_name'] = $query->qiwa_status_name;
				$data['qiwa_status_name_ar'] = $query->qiwa_status_name_ar;
			}
		} else {
			$data['id'] = "";
			$data['qiwa_status_name'] = "";
			$data['qiwa_status_name_ar'] = "";
		}
		return $this->load->view('admin/masters/qiwa-status/form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('qiwa_status_name', 'Status Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('qiwa_status_name', 'Status Name', 'trim|required|is_unique[master_qiwa_status.qiwa_status_name]', array('is_unique' => 'Duplicate Qiwa Status.'));
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->qiwa_status->edit();
			} else {
				$query = $this->qiwa_status->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/qiwa-status');
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->qiwa_status->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/qiwa-status');
	}
}
