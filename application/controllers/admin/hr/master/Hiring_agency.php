<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hiring_agency extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr/master/Agency_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('session');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hiring_agencies', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		//$data['result'] = $this->Agency_model->get_list();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/hr/master/agency/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Agency_model->get_list();
		// $i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $cat) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $cat->id . '" name="check_list[]" />';
			$sub_array[] = $cat->agency_code;
			$sub_array[] = $cat->agency_name . '<br>' . $cat->agency_name_ar;
			$sub_array[] = $cat->user_id;
			$sub_array[] = $cat->country_name;
			$sub_array[] = '<div style="width: 80px;">' . date("d-m-Y", strtotime($cat->agreement_e_date)) . '</div>';
			if ($cat->status == '1') {
				$status = '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
			} elseif ($cat->status == '2') {
				$status = '<span class="badge badge-pill badge-soft-primary font-size-13">Inactive</span>';
			} elseif ($cat->status == '3') {
				$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Contract Expired</span>';
			} elseif ($cat->status == '4') {
				$status = '<span class="badge badge-pill badge-soft-warning font-size-13">Suspended</span>';
			} else {
				$status = '<span class="badge badge-pill badge-soft-dark font-size-13">NULL</span>';
			}
			$sub_array[] = $status;
			$sub_array[] = $cat->created_at;
			$sub_array[] = $cat->updated_at;
			$sub_array[] = (check_action_permission(get_user_role(), 'hiring_agencies', 'edit') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit me-1" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/hr/master/agency/edit?id=' . $cat->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') .
				(check_action_permission(get_user_role(), 'hiring_agencies', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Detail" href="' . base_url() . 'admin/hr/master/agency/detail?id=' . $cat->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->Agency_model->get_all_data(),
			"recordsFiltered" => $this->Agency_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hiring_agencies', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['agency_id'] = $this->db->query("SELECT id FROM hiring_agencies ORDER BY id desc limit 1")->row();
		$this->load->view('admin/hr/master/agency/form', $data);
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hiring_agencies', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data['result'] = $this->Agency_model->get_detail($this->input->get('id'));
		} else {
			$this->session->set_userdata('info', "2--Invalid ID!");
			redirect('admin/hr/master/agency/list');
		}
		$this->load->view('admin/hr/master/agency/edit', $data);
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'hiring_agencies', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data['result'] = $this->Agency_model->get_detail($this->input->get('id'));
		} else {
			$this->session->set_userdata('info', "2--Invalid ID!");
			redirect('admin/hr/master/agency/list');
		}
		$this->load->view('admin/hr/master/agency/detail', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('agency_name', 'Agency Name', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User ID', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate', 'User ID already exist, Try new');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[55]', array('min_length' => 'Password min length should be 6 character'));
		$this->form_validation->set_rules('country_id', 'Country Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Agency_model->edit();
			} else {
				$password = $this->input->post('password');
				$hashpassword = $this->enc_lib->encrypt($password);
				$query = $this->Agency_model->add($hashpassword);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/agency/list');
	}

	public function check_duplicate()
	{
		$user_id = $this->input->post('user_id');
		$id = $this->input->post('id');
		if ($id !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->db->query("SELECT * FROM hiring_agencies WHERE user_id = '" . $user_id . "' AND id != '" . $id . "'");
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
		if ($this->action && !check_action_permission(get_user_role(), 'hiring_agencies', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Agency_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/agency/list');
	}

	public function change_password()
	{
		$this->form_validation->set_rules('id', 'Agency ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[55]', array('min_length' => 'PasswordmMin length should be 6 character'));
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo $msg;
		} else {
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$query = $this->Agency_model->change_password($hashpassword);
			if ($query) {
				echo 'Password Successfully Changed.';
				exit();
			} else {
				echo 'Error occured, Try again';
				exit();
			}
		}
	}

	public function getLoginDetail()
	{
		$login_id = $this->input->post("login_id");
		$result = $this->db->query("SELECT password from hiring_agencies WHERE id = '" . $login_id . "'")->row();
		$hashpassword = $this->enc_lib->dycrypt($result->password);
		$data['password'] = $hashpassword;
		echo json_encode($data);
	}
}
