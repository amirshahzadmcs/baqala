<?php defined('BASEPATH') or exit('No direct script access allowed');

class Camps extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/Camp_model', 'camp_model');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'camps', $action) && !in_array($action, ['save', 'get_list'])):
				redirect('admin/common/permission');
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
		return $this->load->view('admin/masters/camps/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->camp_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $brand) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $brand->id . '" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->camp_name;
			$sub_array[] = $brand->camp_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(), 'camps', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/master/camps/add?id=' . $brand->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->camp_model->get_all_data(),
			"recordsFiltered" => $this->camp_model->get_filtered_data(),
			"data"            => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->camp_model->detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['camp_name'] = $query->camp_name;
				$data['camp_name_ar'] = $query->camp_name_ar;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['camp_name'] = "";
			$data['camp_name_ar'] = "";
			$data['status'] = "";
		}
		return $this->load->view('admin/masters/camps/form', $data);
	}

	public function save()
	{
		if ($this->input->post('id')) {
			$this->form_validation->set_rules('camp_name', 'Camp Name', 'trim|required');
		} else {
			$this->form_validation->set_rules('camp_name', 'Camp Name', 'trim|required|is_unique[master_camp.camp_name]', array('is_unique' => 'Duplicate Camp Name.'));
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->camp_model->edit();
			} else {
				$query = $this->camp_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/camps');
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->camp_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/camps');
	}
}
