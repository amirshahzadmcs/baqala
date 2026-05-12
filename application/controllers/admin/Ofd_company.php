<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ofd_company extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Ofdcompany_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'online_food_delivery_company', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		//$data['result'] = $this->Ofdcompany_model->get_list();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/ofd_company/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Ofdcompany_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $company) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $company->id . '" name="check_list[]" />';
			$sub_array[] = $company->company_name . ' - ' . $company->company_name_ar;
			$sub_array[] = $company->total_orders;
			$sub_array[] = $company->id_length .' - '. $company->max_id_length;
			$sub_array[] = $company->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Deactive</span>';
			$sub_array[] = $company->created_at;
			$sub_array[] = $company->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'online_food_delivery_company', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/ofd-company/edit?id=' . $company->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Ofdcompany_model->get_all_data(),
			"recordsFiltered"     =>     $this->Ofdcompany_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function form()
	{
		if ($this->input->get('id')) {
			$query = $this->Ofdcompany_model->get_detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['company_name'] = $query->company_name;
				$data['company_name_ar'] = $query->company_name_ar;
				$data['id_length'] = $query->id_length;
				$data['max_id_length'] = $query->max_id_length;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['company_name'] = "";
			$data['company_name_ar'] = "";
			$data['id_length'] = "";
			$data['max_id_length'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/ofd_company/form', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'online_food_delivery_company', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
			$this->form_validation->set_rules('id_length', 'Id number length (Min)', 'trim|required');
			$this->form_validation->set_rules('max_id_length', 'Id number length (Max)', 'trim|required');
		} else {
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|is_unique[food_deliv_companies.company_name]', array('is_unique' => 'Duplicate company name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
			$this->form_validation->set_rules('id_length', 'Id number length (Min)', 'trim|required');
			$this->form_validation->set_rules('max_id_length', 'Id number length (Max)', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Ofdcompany_model->edit();
			} else {
				$query = $this->Ofdcompany_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/ofd-company/list');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'online_food_delivery_company', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Ofdcompany_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/ofd-company/list');
	}
}
