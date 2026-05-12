<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->admin->isLogged()) {
			$this->load->model('admin/User_model');
			$this->load->model('admin/Common_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_individual_clients', $this->action)) {
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
		$this->load->view('admin/user/user_list', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_individual_clients', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$query = $this->User_model->get_customer($id)->row();
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['role_id'] = $query->role_id;
			$data['email'] = $query->email;
			$data['password'] = $query->password;
			$data['status'] = $query->status;
		} else {
			$data['id'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['role_id'] = "";
			$data['email'] = "";
			$data['password'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/user/add', $data);
	}

	public function add_customer()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('role_id', 'Please select valid account type', 'numeric|required');
		//$this->form_validation->set_rules('ref_code', 'Invalid Referal Code', 'callback_referal_exists');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if (empty($this->input->post('id'))) {
			$this->form_validation->set_rules('mobile', 'Mobile', 'numeric|required|is_unique[customer.mobile]', array('is_unique' => 'This mobile number is already registered.'));
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[customer.email]', array('is_unique' => 'This email is already registered.'));
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		} else {
			$this->form_validation->set_rules('mobile', 'Mobile', 'numeric|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				//print_r($this->input->post());exit();
				$query = $this->User_model->manage();
			} else {
				$query = $this->User_model->add_customer();
				$user_id = $this->db->insert_id();
				$refered_code = '';
				$email = $this->input->post('email');
				$this->insert_ref_code($user_id, $refered_code, $email);
			}
			if ($query) {
				if ($this->input->post('id')) {
					$this->session->set_userdata('info', "1--User successfully updated");
				} else {
					$this->session->set_userdata('info', "1--User successfully created");
				}
			} else {
				$this->session->set_userdata('info', "2--Some error occured");
			}
		}
		redirect('admin/user/list');
	}

	function insert_ref_code($user_id, $refered_code, $email)
	{
		$Random2Digit = mt_rand(10, 99);
		$RefCode = $Random2Digit . 'BS' . $user_id;
		$is_ref_used = 0;
		$query = $this->db->query("INSERT INTO referrals SET referral_code = '" . $this->db->escape_str($RefCode) . "', user_id = '" . $this->db->escape_str((int)$user_id) . "', refered_code = '" . $refered_code . "', user_email = '" . $email . "', is_ref_used = '" . $is_ref_used . "', updated_at = NOW()");
		return $query;
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_individual_clients', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->User_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/user/list');
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_individual_clients', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['addresses'] = $this->User_model->get_address($id);
		$data['docs'] = $this->User_model->get_docs($id);
		$data['orders'] = $this->User_model->get_orders_by_id($id);
		$data['referral_count'] = $this->User_model->get_referal_count($data['result']->referral_code);
		//print_r($data['referral_count']['total_referred']);exit();
		$this->load->view('admin/user/detail', $data);
	}

	public function getCities()
	{
		$cities = $this->User_model->get_cities($this->input->post('parent'));
		echo json_encode($cities);
	}

	public function referral_report()
	{
		$ref_code = $this->input->get('ref_code');
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['reports'] = $this->User_model->get_referal_report($ref_code);
		//echo '<pre>';print_r($data['result']);'</pre>';exit();
		$this->load->view('admin/user/ref_report', $data);
	}

	public function orders()
	{
		$id = $this->input->get('id');
		$data['orders'] = $this->User_model->get_orders_by_id($id);
		//print_r($data['orders']);exit();
		$this->load->view('admin/user/order_list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->User_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $user) {
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $user->id . '" />';
			$sub_array[] = $user->customer_no;
			$sub_array[] = $user->name;
			$sub_array[] = $user->email;
			$sub_array[] = $user->mobile;
			$sub_array[] = $user->role_id == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Normal</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Business</span>';
			$sub_array[] = $user->total_orders;
			$sub_array[] = $user->total_order_value;
			$sub_array[] = $user->wallet;
			$sub_array[] = date("d-m-y h:i A", strtotime($user->created));
			$sub_array[] = $user->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : ($user->status == 2 ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>');
			$sub_array[] = (check_action_permission(get_user_role(), 'manage_individual_clients', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/user/add?id=' . $user->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'manage_individual_clients', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/user/detail?id=' . $user->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}

		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->User_model->get_all_data(),
			"recordsFiltered"     =>     $this->User_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function update()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('msg', validation_errors());
			$this->session->set_flashdata('is_success', '0');
			redirect('user');
		} else {
			$query = $this->User_model->edit_customer();
			if ($query) {
				$this->session->set_flashdata('msg', 'Profile successfully updated');
				$this->session->set_flashdata('is_success', '1');
				redirect('admin/user');
			} else {
				$this->session->set_flashdata('msg', 'Some error occured.');
				$this->session->set_flashdata('is_success', '0');
				redirect('admin/user');
			}
		}
	}

	public function update_rewards()
	{
		$this->form_validation->set_rules('uid', 'User Id', 'trim|required');
		$this->form_validation->set_rules('rewards', 'Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>' . $msg . '</div>';
			exit();
		} else {
			if ($this->input->post('uid')) {
				$query = $this->User_model->updateRewards();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
			if ($query) {
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Rewards Amount Successfully Updated</div>';
				exit();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
		}
	}

	public function update_wallet()
	{
		$this->form_validation->set_rules('uid', 'User Id', 'trim|required');
		$this->form_validation->set_rules('wallet', 'Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>' . $msg . '</div>';
			exit();
		} else {
			if ($this->input->post('uid')) {
				$query = $this->User_model->updateWallet();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
			if ($query) {
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Wallet Amount Successfully Updated</div>';
				exit();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
		}
	}

	public function wallet_report()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['reports'] = $this->User_model->get_wallet_report($id);
		$data['total_credit'] = $this->User_model->getCreditWallet($id);
		$data['total_debit'] = $this->User_model->getDebitWallet($id);
		$data['total_trans'] = $this->User_model->get_all_report($id);
		$this->load->view('admin/user/wallet_report', $data);
	}

	public function rewards_report()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['reports'] = $this->User_model->get_rewards_report($id);
		$data['total_credit'] = $this->User_model->getCreditRewards($id);
		$data['total_debit'] = $this->User_model->getDebitRewards($id);
		$data['total_trans'] = $this->User_model->get_all_rewards_report($id);
		$this->load->view('admin/user/rewards_report', $data);
	}
}
