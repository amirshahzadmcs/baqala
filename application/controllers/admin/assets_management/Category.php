<?php defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/assets_management/Category_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'category', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		//$data['result'] = $this->Category_model->get_list();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/assets-category/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Category_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $cat) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $cat->id . '" name="check_list[]" />';
			$sub_array[] = $cat->category_name;
			$sub_array[] = $cat->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $cat->created_at;
			$sub_array[] = $cat->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'category', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/assets/category/edit?id=' . $cat->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Category_model->get_all_data(),
			"recordsFiltered"     =>     $this->Category_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'category', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Category_model->get_detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['category_name'] = $query->category_name;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['category_name'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/assets-category/form', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate', 'Category already exist, Try new');
		$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Category_model->edit();
			} else {
				$query = $this->Category_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/assets/category/list');
	}

	public function check_duplicate()
	{
		$category_name = $this->input->post('category_name');
		$id = $this->input->post('id');
		if ($id !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->db->query("SELECT * FROM assets_category WHERE category_name = '" . $category_name . "' AND id != '" . $id . "'");
			//print_r($sku_check);exit();
			if ($duplicate_check->num_rows() > 0) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'category', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Category_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/assets/category/list');
	}
}
