<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reasons_master extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/ReasonsMaster_model', 'reasons_model');
			$this->load->library('form_validation');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_reasons', $this->action)) {
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
		return $this->load->view('admin/masters/master_reason/list', $data);
	}

	public function get_list()
	{
		$type = $this->input->get('type');
		$fetch_data = $this->reasons_model->get_list($type);
		// $i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->reason_title_en;
			$sub_array[] = $brand->reason_title_ar;
			$sub_array[] = strtoupper(str_replace('_', ' ', $brand->reason_type));
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'suspend_reasons', 'edit') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" onclick="editModal(' . $brand->id . ')"><i class="mdi mdi-pencil font-size-18"></i></button>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->reasons_model->get_all_data($type),
			"recordsFiltered" => $this->reasons_model->get_filtered_data($type),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_reasons', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/masters/master_reason/components/add_modal');
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_reasons', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->reasons_model->detail($id);
			if ($query->num_rows() > 0) {
				$data['reason_detail'] = $query->row_array();
				$output_data = $this->load->view('admin/masters/master_reason/components/edit_modal', $data, TRUE);
				$result = array("type" => 'success', "message" => '', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Reason not found, try another.');
			}
		}
		echo json_encode($result);
	}

	public function save()
	{
		$this->form_validation->set_rules('reason_title_en', 'Reason Title', 'trim|required');
		$this->form_validation->set_rules('reason_type', 'Reason Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->reasons_model->add();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/master-reason');
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('reason_title_en', 'Reason Title', 'trim|required');
		$this->form_validation->set_rules('reason_type', 'Reason Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->reasons_model->edit();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/master-reason');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'suspend_reasons', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->reasons_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/master-reason');
	}
}
