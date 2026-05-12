<?php defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Brand_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_brands', $this->action)) {
			redirect('admin/unauthrorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/brand/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Brand_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->brand_name;
			$sub_array[] = $brand->brand_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = $brand->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = check_action_permission(get_user_role(), 'manage_brands', 'add_brand') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/brand/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Brand_model->get_all_data(),
			"recordsFiltered"     =>     $this->Brand_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Brand_model->get_master_brands_by_id($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['brand_name'] = $query->brand_name;
				$data['brand_name_ar'] = $query->brand_name_ar;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['brand_name'] = "";
			$data['brand_name_ar'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/brand/form', $data);
	}

	public function add_brand()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_brands', $this->action)) {
			redirect('admin/unauthrorized-request');
		}
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|is_unique[master_brands.brand_name]', array('is_unique' => 'Duplicate brand name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Brand_model->edit();
			} else {
				$query = $this->Brand_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/brand');
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_brands', $this->action)) {
			redirect('admin/unauthrorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Brand_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/brand');
	}
}
