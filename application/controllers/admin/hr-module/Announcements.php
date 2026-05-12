<?php defined('BASEPATH') or exit('No direct script access allowed');

class Announcements extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Employee_model', 'employee_model');
			$this->load->model('admin/hr-module/Announcements_model', 'announcements_model');
			$this->load->library(['form_validation', 'upload']);
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if (!check_action_permission(get_user_role(), 'memos_list', $this->action)) {
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
		$this->load->view('admin/hr-module/announcements/index', $data);
	}

	public function add()
	{
		if (!check_action_permission(get_user_role(), 'memos_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/hr-module/announcements/components/add');
	}

	public function save()
	{
		$this->form_validation->set_rules('employee_group', 'Employee Detail', 'trim|required');
		$this->form_validation->set_rules('notification_icon', 'Notification Icon', 'trim|required');
		$this->form_validation->set_rules('title_arabic', 'Title Arabic', 'trim|required');
		$this->form_validation->set_rules('title_english', 'Title English', 'trim|required');
		$this->form_validation->set_rules('body_arabic', 'Body Arabic', 'trim|required');
		$this->form_validation->set_rules('body_english', 'Body English', 'trim|required');

		$employee_group = $this->input->post('employee_group');
		if (in_array($employee_group, ['department', 'specific'])) {
			$this->form_validation->set_rules('group_detail[]', 'Group Detail', 'required');
		}


		if ($this->input->post('enable_notify_date')) {
			$this->form_validation->set_rules('notify_date_date', 'Notification Date', 'trim|required');
			$this->form_validation->set_rules('notify_date_time', 'Notification Time', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$result = ["type" => 'error', "message" => validation_errors()];
		} else {
			$data = [
				'employee_group' => $this->input->post('employee_group', true),
				'notification_icon' => $this->input->post('notification_icon', true),
				'title_arabic' => $this->input->post('title_arabic', true),
				'title_english' => $this->input->post('title_english', true),
				'body_arabic' => $this->input->post('body_arabic', true),
				'body_english' => $this->input->post('body_english', true),
				'send_via_email' => $this->input->post('send_via_email') ? 1 : 0,
				'show_after_login' => $this->input->post('show_after_login') ? 1 : 0,
				'enable_notify_date' => $this->input->post('enable_notify_date') ? 1 : 0,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			$groupDetail = $this->input->post('group_detail');
			$data['group_detail'] = !empty($groupDetail) ? json_encode($groupDetail) : json_encode([]);

			if ($this->input->post('enable_notify_date')) {
				$date = $this->input->post('notify_date_date');
				$time = $this->input->post('notify_date_time');
				$data['notify_date'] = $date;
				$data['notify_time'] = $time;
				$data['status'] = '0';
			} else {
				$data['notify_date'] = null;
				$data['notify_time'] = null;
				$data['status'] = '1';
			}

			if (!empty($_FILES['attachment']['name'])) {
				$config['upload_path'] = './uploads/notifications/';
				$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
				$config['encrypt_name'] = TRUE;

				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0755, true);
				}

				$this->upload->initialize($config);

				if ($this->upload->do_upload('attachment')) {
					$uploadData = $this->upload->data();
					$data['file_path'] = 'uploads/notifications/' . $uploadData['file_name'];
				} else {
					log_message('error', 'File upload failed: ' . $this->upload->display_errors());
					echo json_encode(['type' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
					return;
				}
			}

			$insert_id = $this->announcements_model->save_announcement_data($data);

			if ($insert_id) {
				// Send email if required
				if ($data['send_via_email']) {
					$this->sendAnnouncementMail($insert_id);
				}
				$result = ["type" => 'success', "message" => 'Notification saved successfully.'];
			} else {
				$result = ["type" => 'error', "message" => 'Something went wrong, try again'];
			}
		}

		echo json_encode($result);
	}

	/**
	 * Send announcement mail to employees
	 * @param int $id
	 * @return void
	 */
	private function sendAnnouncementMail($id)
	{
		$query = $this->announcements_model->get_detail($id);

		if ($query->num_rows() > 0) {
			$data['announcement_detail'] = $query->row_array();

			$groupType = $data['announcement_detail']['employee_group'];
			$groupDetail = $data['announcement_detail']['group_detail'];
			$title_arabic = $data['announcement_detail']['title_arabic'];
			$title_english = $data['announcement_detail']['title_english'];
			$file_path = $data['announcement_detail']['file_path'];
			$send_via_email = $data['announcement_detail']['send_via_email'];

			$employee_ids = [];

			// Decode groupDetail (JSON-encoded string)
			$groupDetailArray = json_decode($groupDetail, true);

			if ($groupType === 'specific_employees' && !empty($groupDetailArray)) {
				// groupDetail is a list of employee IDs
				$employee_ids = $groupDetailArray;
			} elseif ($groupType === 'department' && !empty($groupDetailArray)) {
				// groupDetail is a list of department IDs
				$this->db->select('id');
				$this->db->from('master_employee');
				$this->db->where_in('department', $groupDetailArray);
				$employeeQuery = $this->db->get();
				$employee_ids = array_column($employeeQuery->result_array(), 'id');
			} elseif ($groupType === 'all_employees') {
				$this->db->select('id');
				$this->db->from('master_employee');
				$all_employees_query = $this->db->get();
				$employee_ids = array_column($all_employees_query->result_array(), 'id');
			}

			// Proceed only if email sending is enabled and employee list is not empty
			if ($send_via_email && !empty($employee_ids)) {
				// Get employee emails
				$this->db->select('email');
				$this->db->from('master_employee');
				$this->db->where_in('id', $employee_ids);
				$this->db->where('email IS NOT NULL', null, false);
				$email_query = $this->db->get();

				$emails = [];
				if ($email_query->num_rows() > 0) {
					foreach ($email_query->result() as $emp) {
						if (filter_var($emp->email, FILTER_VALIDATE_EMAIL)) {
							$emails[] = $emp->email;
						}
					}
				}

				if (!empty($emails)) {
					$email_data = array(
						'email' => $emails,
						'attachment' => FCPATH . $file_path,
						'request_type' => 'Announcement',
						'subject' => $title_arabic . ' || ' . $title_english,
						'announcement_detail' => $data['announcement_detail'],
						'template' => 'admin/attatchment-template/announcements'
					);
					send_global_mail_helper($email_data);
				}
			}
		}
	}

	public function edit($id)
	{
		if (!$this->action || !check_action_permission(get_user_role(), 'memos_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($id > 0) {
			$query = $this->announcements_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['announcement_detail'] = $query->row_array();
				$output_data = $this->load->view('admin/hr-module/announcements/components/edit-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Announcement detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Announcement detail not found, try again');
			}
		} else {
			$result = array("type" => 'error', "message" => 'Invalid request ID!');
		}
		echo json_encode($result);
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Memo ID', 'trim|required');
		$this->form_validation->set_rules('employee_group', 'Employee Detail', 'trim|required');
		$this->form_validation->set_rules('notification_icon', 'Notification Icon', 'trim|required');
		$this->form_validation->set_rules('title_arabic', 'Title Arabic', 'trim|required');
		$this->form_validation->set_rules('title_english', 'Title English', 'trim|required');
		$this->form_validation->set_rules('body_arabic', 'Body Arabic', 'trim|required');
		$this->form_validation->set_rules('body_english', 'Body English', 'trim|required');

		$employee_group = $this->input->post('employee_group');
		if (in_array($employee_group, ['department', 'specific_employees'])) {
			$this->form_validation->set_rules('group_detail[]', 'Group Detail', 'required');
		}

		if ($this->input->post('enable_notify_date')) {
			$this->form_validation->set_rules('notify_date_date', 'Notification Date', 'trim|required');
			$this->form_validation->set_rules('notify_date_time', 'Notification Time', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$result = ["type" => 'error', "message" => validation_errors()];
		} else {
			$id = $this->input->post('id');

			$data = [
				'employee_group' => $this->input->post('employee_group', true),
				'notification_icon' => $this->input->post('notification_icon', true),
				'title_arabic' => $this->input->post('title_arabic', true),
				'title_english' => $this->input->post('title_english', true),
				'body_arabic' => $this->input->post('body_arabic', true),
				'body_english' => $this->input->post('body_english', true),
				'send_via_email' => $this->input->post('send_via_email') ? 1 : 0,
				'show_after_login' => $this->input->post('show_after_login') ? 1 : 0,
				'enable_notify_date' => $this->input->post('enable_notify_date') ? 1 : 0,
				'updated_at' => date('Y-m-d H:i:s'),
			];

			$groupDetail = $this->input->post('group_detail');
			$data['group_detail'] = !empty($groupDetail) ? json_encode($groupDetail) : json_encode([]);

			if ($this->input->post('enable_notify_date')) {
				$data['notify_date'] = $this->input->post('notify_date_date', true);
				$data['notify_time'] = $this->input->post('notify_date_time', true);
			} else {
				$data['notify_date'] = null;
				$data['notify_time'] = null;
			}

			if (!empty($_FILES['attachment']['name'])) {
				$config['upload_path'] = './uploads/notifications/';
				$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
				$config['encrypt_name'] = TRUE;

				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0755, true);
				}

				$this->upload->initialize($config);

				if ($this->upload->do_upload('attachment')) {
					$uploadData = $this->upload->data();
					$data['attachment'] = 'uploads/notifications/' . $uploadData['file_name'];
				} else {
					log_message('error', 'File upload failed: ' . $this->upload->display_errors());
					echo json_encode(['type' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
					return;
				}
			}
			$updated = $this->announcements_model->update_announcement_data($id, $data);
			if ($updated) {
				$result = ["type" => 'success', "message" => 'Notification updated successfully.'];
			} else {
				$result = ["type" => 'error', "message" => 'Update failed or no changes made.'];
			}
		}
		echo json_encode($result);
	}

	public function detail($id)
	{
		if (!$this->action || !check_action_permission(get_user_role(), 'memos_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($id > 0) {
			$query = $this->announcements_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['announcement_detail'] = $query->row_array();
				$output_data = $this->load->view('admin/hr-module/announcements/components/detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Announcement detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Announcement detail not found, try again');
			}
		} else {
			$result = array("type" => 'error', "message" => 'Invalid request ID!');
		}
		echo json_encode($result);
	}

	public function get_list()
	{
		$fetch_data = $this->announcements_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $item->employee_group;
			$sub_array[] = ucfirst($item->notification_icon);
			$sub_array[] = ucfirst($item->title_english);
			$sub_array[] = $item->send_via_email ? 'Yes' : 'No';
			$sub_array[] = $item->show_after_login ? 'Yes' : 'No';
			$sub_array[] = $item->enable_notify_date ? 'Yes' : 'No';
			$sub_array[] = ((isset($item->notify_date)) ? date('d-m-Y', strtotime($item->notify_date)) : 'NA');
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			$actionDropdown = '';

			if (
				check_action_permission(get_user_role(), 'memos_list', 'edit') ||
				check_action_permission(get_user_role(), 'memos_list', 'delete') ||
				check_action_permission(get_user_role(), 'memos_list', 'detail')
			) {

				$actionDropdown = '<div class="btn-group ms-2 float-end">
        <button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
            <i class="dripicons-dots-3"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-end">';

				if (check_action_permission(get_user_role(), 'memos_list', 'edit')) {
					$actionDropdown .= '<a type="button" class="dropdown-item px-3 py-2 load_edit_modal" title="Edit" data-id="' . $item->id . '">
            <i class="mdi mdi-pencil font-size-16 me-2"></i> Edit Memo
        </a>';
				}
				if (check_action_permission(get_user_role(), 'memos_list', 'detail')) {
					if (check_action_permission(get_user_role(), 'memos_list', 'edit')) {
						$actionDropdown .= '<div class="dropdown-divider"></div>';
					}
					$actionDropdown .= '<a type="button" class="dropdown-item px-3 py-2 load_detail_modal" title="Detail" data-id="' . $item->id . '">
            <i class="mdi mdi-stretch-to-page-outline font-size-16 me-2"></i> View Detail
        </a>';
				}

				$actionDropdown .= '</div></div>';
			}

			$sub_array[] = $actionDropdown;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->announcements_model->get_all_data(),
			"recordsFiltered" => $this->announcements_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if (!$this->action || !check_action_permission(get_user_role(), 'memos_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->announcements_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/announcements');
	}
}
