<?php defined('BASEPATH') or exit('No direct script access allowed');

class Admin_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Admin_model');
			$this->load->library('form_validation');
			$this->load->library('user_agent');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'users', $action)) {
				redirect('admin/unauthorized-request');
			}
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		$data['results'] = $this->Admin_model->get_list();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/users/list', $data);
	}

	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Admin_model->get_detail_by_id($this->input->get('id'))->row();
			if ($query) {
				$data['id'] = $query->admin_id;

				$data['name'] = $query->name;
				$data['username'] = $query->username;
				$data['email'] = $query->email;
				$data['mobile'] = $query->mobile;
				$data['role'] = $query->role;
				$data['password'] = $query->password;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['name'] = "";
			$data['username'] = "";
			$data['email'] = "";
			$data['mobile'] = "";
			$data['role'] = "";
			$data['password'] = "";
			$data['status'] = "";
		}
		$data['parent'] = $this->Admin_model->get_list();
		$data['employees'] = $this->db
			->select('emp.full_name, emp.emp_no, emp.id, emp.designation, sc.mobile as alloted_mobile')
			->from('master_employee emp')
			->join('sim_card sc', 'sc.alloted_user = emp.id', 'left')
			->where('emp.status', 'Active')
			->get()
			->result();
		$data['roles'] = $this->db->where('is_superadmin', 0)->where('is_active', 1)->where('deleted', 0)->order_by('name','asc')->get('roles')->result();
		$this->load->view('admin/users/form', $data);
	}

	public function add_user()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {

			if ($this->input->post('id')) {
				$query = $this->Admin_model->edit();
			} else {
				$query = $this->Admin_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
			redirect('admin/users/list');
		}
	}
	public function setStatusEnable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Admin_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/users/list');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Admin_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/users/list');
		} else {
			redirect('admin');
		}
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Admin_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/users/list');
	}

	public function changePassword()
	{
		$this->form_validation->set_rules('emp_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[6]|max_length[50]|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect($this->agent->referrer());
		} else {
			$hashed_password = md5($this->input->post('password'));
			$query = $this->db->update(
				'admin',
				['password' => $hashed_password],
				['admin_id' => $this->input->post('emp_id')]
			);

			if ($query) {
				$this->session->set_userdata('info', "1--Password successfully updated");
				redirect($this->agent->referrer());
			} else {
				$this->session->set_userdata('info', "2--Problem in updating new password.");
			}
		}
		redirect($this->agent->referrer());
	}
	
	public function search_emp()
	{
		$emp_id = $this->input->get('emp_id');
		$employee = $this->db
			->select('emp.*, sc.mobile AS alloted_mobile')
			->from('master_employee emp')
			->join('sim_card sc', 'sc.alloted_user = emp.id', 'left')
			->where('emp.id', $emp_id)
			->get()
			->row();
		echo json_encode(['status' => true, 'employee' => $employee]);
	}
}
