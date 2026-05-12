<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->action = $this->router->method;
		$this->load->helper('sendmail_helper');
	}

	public function index()
	{
		if ($this->admin->isLogged()) {
			// Prevent caching
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
			$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
			$this->output->set_header("Pragma: no-cache");
			$data['total_users'] = $this->db->query("SELECT count(id) as total FROM customer")->result_array();
			$data['total_orders'] = $this->db->query("SELECT count(id) as total FROM orders")->result_array();
			$data['total_product'] = $this->db->query("SELECT count(id) as total FROM product")->result_array();
			$data['total_category'] = $this->db->query("SELECT count(id) as total FROM category")->result_array();
			$data['total_partner'] = $this->db->query("SELECT count(id) as total FROM delivery_partner")->result_array();
			$data['total_credit_ac'] = $this->db->query("SELECT count(id) as total FROM credit_account")->result_array();
			$data['new_orders'] = $this->db->query("SELECT * FROM orders WHERE order_status_id < 2")->result();
			// print_r($data['new_orders']);exit();
			$this->load->view('admin/home/dashboard', $data);
		} else {
			redirect('admin/login');
		}
	}

	public function login()
	{
		// If already logged in, redirect to dashboard
		if ($this->session->userdata('admin_id')) {
			redirect('admin'); // or base_url('admin') if needed
		}
		$this->session->unset_userdata(['admin_login_data', 'otp', 'otp_expiry', 'otp_attempts']);
		// Prevent browser caching
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->load->view('admin/home/login');
	}

	public function access_denied()
	{
		$this->load->view('admin/errors/unauthorized');
	}

	public function unauthorized_request()
	{
		$this->load->view('admin/errors/unauthorized_request');
	}

	public function change_password()
	{
		$this->load->view('admin/home/change_password');
	}

	public function change_password_user()
	{
		$data['id'] = $this->input->get('id');
		$this->load->view('admin/home/change_password_user', $data);
	}

	public function check_login()
	{
		$email = trim((string) $this->input->post('username'));
		$password = (string) $this->input->post('password');

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo json_encode([
				'success' => false,
				'message' => 'Please enter a valid email address.',
			]);
			return;
		}

		if ($password === '') {
			echo json_encode([
				'success' => false,
				'message' => 'Please enter your password.',
			]);
			return;
		}

		$employee = $this->db
			->where('email', $email)
			->where('password', md5($password))
			->where('status', 1)
			->get('admin')
			->row_array();

		if ($employee) {
			$this->session->sess_regenerate(true);
			$this->session->unset_userdata(['admin_login_data', 'otp', 'otp_expiry', 'otp_attempts']);
			$this->session->set_userdata('admin_id', $employee['admin_id']);
			$this->session->set_userdata('admin_name', $employee['name']);
			$this->session->set_userdata('login_employee_id', $employee['employee_id']);
			$this->session->set_userdata('role', $employee['role']);
			echo json_encode([
				'success' => true,
				'redirect_url' => base_url('admin'),
			]);
		} else {
			echo json_encode([
				'success' => false,
				'message' => 'Invalid credentials.',
			]);
		}
	}

	public function sendOtp()
	{
		if (!$this->session->userdata('admin_login_data')) {
			$this->session->set_flashdata('error', 'Session expired, please login again.');
			redirect('admin/login');
		}

		$otp = rand(100000, 999999);
		$otpExpiry = time() + (10 * 60); // 10 minutes

		$this->session->set_userdata('otp', $otp);
		$this->session->set_userdata('otp_expiry', $otpExpiry);

		$empData = $this->session->userdata('admin_login_data');
		log_message('debug', 'Admin OTP generated for '.$empData['email']);

		if (empty($empData['email'])) {
			$this->session->unset_userdata(['admin_login_data', 'otp', 'otp_expiry']);
			$this->session->set_flashdata('error', 'Session expired, please login again.');
			redirect('admin/login');
		}

		if ($this->isLocalOtpDebugEnabled()) {
			$this->session->set_userdata('otp_attempts', 0);
			$this->session->set_flashdata('debug_otp', $otp);
			$this->session->set_flashdata('login_error', 'Local debug mode is enabled. Use the OTP shown below to sign in.');
			$this->session->set_flashdata('is_success', '1');
			redirect('admin/otp');
		}
		//Send Mail
		$email_data = array(
			'request_type' => 'admin_login',
			'email' => $empData['email'],
			'name' => $empData['emp_name'],
			'otp' => $otp,
			'subject' => 'OTP for Login Verification',
			'template' => 'admin/attatchment-template/otp_login'
		);
		$isSent = send_global_mail_helper($email_data);

		if ($isSent) {
			$this->session->set_userdata('otp_attempts', 0);
			$this->session->set_flashdata('success', 'OTP sent to your registered email. It will expire in 10 minutes.');
		} else {
			$this->session->set_flashdata('error', 'Failed to send OTP. Please try again later.');
		}

		redirect('admin/otp');
	}

	private function isLocalOtpDebugEnabled()
	{
		$serverName = strtolower((string) $this->input->server('SERVER_NAME'));
		$httpHost = strtolower((string) $this->input->server('HTTP_HOST'));
		$remoteAddr = (string) $this->input->server('REMOTE_ADDR');

		if (ENVIRONMENT === 'development') {
			return true;
		}

		return in_array($serverName, ['localhost'], true)
			|| in_array($httpHost, ['localhost', '127.0.0.1'], true)
			|| in_array($remoteAddr, ['127.0.0.1', '::1'], true);
	}
	
	public function change_user()
	{
		$this->session->unset_userdata(['admin_login_data', 'otp', 'otp_expiry']);
		redirect('admin/login', 'refresh');
	}

	public function otp_form()
	{
		if (!$this->session->userdata('admin_login_data')) {
			$this->session->set_flashdata('error', 'Invalid session. Please login again.');
			redirect('admin/login');
		}
		// Prevent caching
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->load->view('admin/home/otp');
	}

	public function verify_otp()
	{
		// Set validation rule
		$this->form_validation->set_rules('otp', 'OTP', 'required|numeric|exact_length[6]');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'success' => false,
				'message' => validation_errors()
			]);
			return;
		}

		$otpInput = $this->input->post('otp');
		$storedOtp = $this->session->userdata('otp');
		$otpExpiry = $this->session->userdata('otp_expiry');
		$attempts   = $this->session->userdata('otp_attempts') ?? 0;

		// Step 2: Check if too many attempts
		if ($attempts >= 5) {
			echo json_encode([
				'success' => false,
				'message' => 'Too many failed attempts. Please request a new OTP.'
			]);
			return;
		}
	
		// Step 3: Check if OTP is set
		if (!$storedOtp || !$otpExpiry) {
			echo json_encode([
				'success' => false,
				'message' => 'OTP not found. Please request a new OTP.'
			]);
			return;
		}

		// Check expiration
		if (time() > $otpExpiry) {
			$this->session->unset_userdata(['otp', 'otp_expiry']);
			echo json_encode([
				'success' => false,
				'message' => 'OTP has expired. Please request a new OTP.'
			]);
			return;
		}

		// OTP matches
		if ((string)$otpInput === (string)$storedOtp) {
			// Remove OTP from session
			$this->session->unset_userdata(['otp', 'otp_expiry']);

			// After OTP matches:
			$empData = $this->session->userdata('admin_login_data');
			$user_query = $this->db->get_where('admin', [
				'email' => $empData['email'],
				'status' => 1
			]);			

			if ($user_query->num_rows() == 1) {
				$empDetail = $user_query->row_array();
				$this->session->set_userdata('admin_id', $empDetail['admin_id']);
				$this->session->set_userdata('admin_name', $empDetail['name']);
				$this->session->set_userdata('login_employee_id', $empDetail['employee_id']);
				$this->session->set_userdata('role', $empDetail['role']);
			} else {
				$this->session->set_flashdata('error', 'Invalid credentials.');
				echo json_encode([
					'success' => false,
					'message' => 'Invalid credentials.'
				]);
				return;
			}
			$this->session->unset_userdata('admin_login_data');
			$this->session->set_flashdata('success', 'Login successful!');
			echo json_encode([
				'success' => true,
				'redirect_url' => base_url('admin') // or use site_url('admin')
			]);
			return;
		} else {
			// Step 6: OTP doesn't match – increment attempt count
			$this->session->set_userdata('otp_attempts', $attempts + 1);
			echo json_encode([
				'success' => false,
				'message' => 'Invalid OTP. Please try again.'
			]);
			return;
		}
	}


	/*
	public function check_login()
	{
		if ($this->admin->login($this->input->post('username'), $this->input->post('password'))) {
			redirect('admin/common');
		} else {
			$this->session->set_flashdata('login_error', 'Username or password did not match.');
			$this->session->set_flashdata('is_success', '0');
			redirect('admin/common/login');
		}
	}*/

	public function logout()
	{
		$t = $this->admin->logout();
		$this->session->unset_userdata(['admin_login_data', 'otp', 'otp_expiry', 'otp_attempts']);
		redirect('admin/common/login');
	}

	public function check_change_password()
	{
		$new_password = md5($this->input->post('new'));
		$old_password = md5($this->input->post('old'));
		$sql = $this->db->query("SELECT * FROM admin WHERE admin_id = '" . (int)$this->session->userdata('admin_id') . "' AND password = '" . $old_password . "'");
		if ($sql->num_rows()) {
			$q = $this->db->query("UPDATE admin SET password = '" . $new_password . "' WHERE admin_id = '" . (int)$this->session->userdata('admin_id') . "'");
			if ($q) {
				$msg_data = "Password Changed. Now You can login with new password";
			} else {
				$msg_data = "Database Error !!!!";
			}
		} else {
			$msg_data = "Don't you have your password";
		}
		redirect('admin/common/change_password?msg=' . $msg_data);
	}
	public function check_change_password_user()
	{
		$new_password = md5($this->input->post('new'));
		$admin_id = $this->input->post('id');
		// 		print_r($admin_id);exit();
		if (!empty($admin_id)) {
			$q = $this->db->query("UPDATE admin SET password = '" . $new_password . "' WHERE admin_id = '" . (int)$admin_id . "'");
			if ($q) {
				$msg_data = "Password Changed. Now You can login with new password";
			} else {
				$msg_data = "Database Error !!!!";
			}
		} else {
			$msg_data = "Don't you have your password";
		}
		redirect('admin/common/change_password_user?msg=' . $msg_data);
	}

	public function edit()
	{
		if (!check_action_permission(get_user_role(), 'profile', 'can_edit')) {
			redirect('admin/unauthorized');
		}
		$query = $this->db->query("SELECT * FROM admin WHERE admin_id = '" . $this->admin->getId() . "'");
		foreach ($query->result() as $query) {
			$data['id'] = $query->admin_id;
			$data['name'] = $query->name;
			$data['email'] = $query->email;
			$data['mobile'] = $query->mobile;
			$data['username'] = $query->username;
			$data['image'] = $query->image;
		}
		$this->load->view('admin/home/change_password', $data);
	}

	public function edit_admin()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($_FILES['image']['name']) {
				$con['upload_path']   = './uploads/';
				$con['allowed_types'] = 'gif|jpg|png|jpeg';
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
					$this->session->set_userdata('info', "2--" . $this->upload->display_errors());
					exit;
				} else {
					$image_data = $this->upload->data();
					$image = "uploads/" . $image_data['file_name'];
					$go['source_image'] = $image;
					$go['maintain_ratio'] = TRUE;
					$go['width'] = 200;
					$this->load->library('image_lib', $go);
					$this->image_lib->resize();
				}
			} else {
				$image = $this->input->post('o_image');
			}
			$query = $this->db->query("UPDATE admin SET name = '" . $this->db->escape_str($this->input->post('name')) . "', email = '" . $this->db->escape_str($this->input->post('email')) . "', username = '" . $this->db->escape_str($this->input->post('username')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', image = '" . $image . "'");
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/common');
	}

	public function pages()
	{
		$data['pages'] = $this->Master_model->get_pages();
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/master/page_list', $data);
	}

	public function pages_add()
	{
		if ($this->input->get('id')) {
			$query = $this->Master_model->get_page_by_id($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->page_id;
				$data['name'] = $query->name;
				$data['seo'] = $query->slug;
				$data['data'] = $query->_data;
				$data['metatitle'] = $query->metatitle;
				$data['metadescription'] = $query->metadescription;
				$data['metakeyword'] = $query->metakeyword;
				$data['o_img'] = $query->image;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['name'] = "";
			$data['data'] = "";
			$data['seo'] = "";
			$data['metatitle'] = "";
			$data['metadescription'] = "";
			$data['o_img'] = "";
			$data['metakeyword'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/master/page', $data);
	}

	public function add_pages()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($_FILES['image']['name']) {
				$con['upload_path']   = './uploads/';
				$con['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
					echo $this->upload->display_errors();
					exit;
				} else {
					$image_data = $this->upload->data();
					$image = "uploads/" . $image_data['file_name'];
				}
			} else {
				$image = $this->input->post('o_image');
			}
			if ($this->input->post('id')) {
				$query = $this->Master_model->edit_page($image);
			} else {
				$query = $this->Master_model->add_page($image);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
			redirect('admin/common/pages');
		}
	}

	public function delete_page()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Master_model->delete_page($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/common/pages');
	}

	public function backup()
	{
		if ($this->admin->isLogged()) {
			$this->load->view('admin/home/backup');
		}
	}

	public function db_backup()
	{
		if ($this->admin->isLogged() && $this->admin->hasPrivilege('settings')) {
			$this->load->helper('url');
			$this->load->helper('file');
			$this->load->helper('download');
			$this->load->library('zip');
			$this->load->dbutil();
			$db_format = array('format' => 'zip', 'filename' => 'baqala.sql');
			$backup = &$this->dbutil->backup($db_format);
			$dbname = 'backup-on-' . date('Y-m-d') . '.zip';
			$save = 'assets/db_backup/' . $dbname;
			write_file($save, $backup);
			force_download($dbname, $backup);
		} else {
			redirect('admin');
		}
	}
}
