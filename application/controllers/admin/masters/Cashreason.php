<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cashreason extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/Cashreasons_model', 'cash_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'cash_collection_reasons', $this->action)) {
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
		return $this->load->view('admin/masters/cash-reason/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->cash_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->reason_title_en;
			$sub_array[] = $brand->reason_title_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'cash_collection_reasons', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/master/cash-reason/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->cash_model->get_all_data(),
			"recordsFiltered" => $this->cash_model->get_filtered_data(),
			"data"            => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'cash_collection_reasons', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->cash_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['reason_title_en'] = $query->reason_title_en;
				$data['reason_title_ar'] = $query->reason_title_ar;
			}
		} else {
			$data['id'] = "";
			$data['reason_title_en'] = "";
			$data['reason_title_ar'] = "";
		}
		return $this->load->view('admin/masters/cash-reason/form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('reason_title_en', 'Reason Title', 'trim|required');
		} else {
			$this->form_validation->set_rules('reason_title_en', 'Reason Title', 'trim|required|is_unique[master_cash_reasons.reason_title_en]', array('is_unique' => 'Duplicate reason title.'));
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->cash_model->edit();
			} else {
				$query = $this->cash_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/cash-reason');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'cash_collection_reasons', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->cash_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/cash-reason');
	}
}
