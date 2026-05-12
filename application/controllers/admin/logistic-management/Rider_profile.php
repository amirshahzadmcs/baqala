<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rider_profile extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-management/Rider_model', 'rider_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
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
		//print_r($data['reports']);exit();
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view('admin/logistic-management/rider/index', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/logistic-management/rider/components/search-form');
	}

	public function getPlatformIds()
	{
		$platform_id = $this->input->post('platform');
		$employee_id = $this->input->post('employee_id'); // Added to support editing scenario

		$id_numbers = $this->rider_model->get_unalloted_aggregator($platform_id, $employee_id);
		if ($id_numbers) {
			echo json_encode(['status' => 'success', 'message' => 'Successfully fetched.', 'output' => $id_numbers]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'No unalloted aggregator ID found in selected aggregator.', 'output' => '']);
		}
	}

	public function getAggregatorIdDetail()
	{
		$id_number = $this->input->post('id_number');
		$id_detail = $this->rider_model->get_aggregator_detail($id_number);
		if ($id_detail) {
			echo json_encode(['status' => 'success', 'message' => 'Successfully fetched.', 'output' => $id_detail]);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Aggregator Id detail not found.', 'output' => '']);
		}
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->rider_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['profile'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'active' AND me.id = '" . $data['profile']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/rider/components/edit-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function get_employee_detail()
	{
		$this->form_validation->set_rules('search_employee', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_no = $this->input->post('search_employee');
			$query = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'active' AND me.emp_no='" . $emp_no . "' AND (me.designation = '3' OR me.designation = '18'))");
			if ($query->num_rows() > 0) {
				$data['emp_detail'] = $query->row_array();
				$emp_id = $data['emp_detail']['id'];
				$check_emp_exist = $this->rider_model->get_detail_by_empid($emp_id);
				if ($check_emp_exist->num_rows() > 0) {
					$result = array("type" => 'error', "message" => 'This rider is already registered, try another employee number.');
					echo json_encode($result);
					return;
				} else {
					$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
					if (empty($data['other_detail']['driving_license_number'])) {
						$result = array("type" => 'error', "message" => 'Rider don`t have Driving licence, try another employee number.');
					} else {
						$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
						if (empty($data['vehicle_detail']['vehicle_no'])) {
							$result = array("type" => 'error', "message" => "Rider don't have vehicle, allot vehicle first!");
						} else {
							if (empty($data['vehicle_detail']['gps_device_serial'])) {
								$result = array("type" => 'error', "message" => "Vehicle don't have GPS tracking!");
							} else {
								$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
								if (empty($data['sim_detail']['mobile'])) {
									$result = array("type" => 'error', "message" => "Rider don't have flex number, allot flex first!");
								} else {
									$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
									$output_data = $this->load->view('admin/logistic-management/rider/components/employee-detail', $data, TRUE);
									$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
								}
							}
						}
					}
				}
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function save()
	{
		$this->form_validation->set_rules('employee_id', 'Select Employee', 'trim|required|callback_check_emp_duplicate');
		$this->form_validation->set_message('check_emp_duplicate', 'Employee already registered, Try new');
		$this->form_validation->set_rules('platform', 'Platform', 'trim|required');
		$this->form_validation->set_rules('id_number', 'Platform ID', 'trim|required');
		$this->form_validation->set_rules('rider_status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// if($_FILES['attachment']['name']){
			// $attachment = $this->upload_file('attachment');
			// }else{
			// $attachment = '';
			// }
			$data = array(
				'employee_id' => $this->input->post('employee_id'),
				'platform' => $this->input->post('platform'),
				'id_number' => $this->input->post('id_number'),
				'rider_status' => $this->input->post('rider_status'),
				'incentive_id' => $this->input->post('incentive_id'),
				'allotment_status' => 1,
				'allotment_date' => date('Y-m-d'),
				'created_at' => CURRENT_TIME
			);
			// Save data using the model
			$insert_id = $this->rider_model->add($data);
			if ($insert_id) {
				$result = array("type" => 'success', "message" => 'Rider profile successfully added.');
			} else {
				$result = array("type" => 'error', "message" => 'Something went wrong, try again');
			}
		}
		echo json_encode($result);
	}

	public function upload_file($file)
	{
		$upload_path = './uploads/dl-docs/';

		// Check if the folder exists, if not, create it
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true); // Recursive directory creation
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
		$config['max_size'] = 0;
		$config['max_width'] = 0;
		$config['max_height'] = 0;
		$config['max_filename'] = '50';
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file)) {
			// Upload failed, display error
			$error = $this->upload->display_errors();
			return $error;
		} else {
			// Upload successful, get file data
			$file_data = $this->upload->data();
			$image = $upload_path . $file_data['file_name'];

			return $image;
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_message('check_emp_duplicate', 'Employee already registered, try a new one');
		$this->form_validation->set_rules('rider_status', 'Status', 'trim|required');

		// Agar inactive hai to date & reason bhi required karo
		if ($this->input->post('rider_status') === 'inactive') {
			$this->form_validation->set_rules('inactive_date', 'Inactive Date', 'trim|required');
			$this->form_validation->set_rules('inactive_reason', 'Inactive Reason', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');

			$data = array(
				'rider_status' => $this->input->post('rider_status'),
				'incentive_id' => $this->input->post('incentive_id'),
				'updated_at' => CURRENT_TIME
			);

			// Agar inactive hai to extra fields save karo
			if ($this->input->post('rider_status') === 'inactive') {
				$data['inactive_date']   = $this->input->post('inactive_date');
				$data['inactive_reason'] = $this->input->post('inactive_reason');
			} elseif ($this->input->post('rider_status') === 'active') {
				// Active par fields null karna ho to uncomment karein
				$data['inactive_date'] = NULL;
				$data['inactive_reason'] = NULL;
			}

			// Save data using the model
			$updated = $this->rider_model->update($id, $data);
			if ($updated) {
				$result = array("type" => 'success', "message" => 'Rider detail successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not updated');
			}
		}
		echo json_encode($result);
	}

	public function check_emp_duplicate($employee_id)
	{
		$id = $this->input->post('id');
		//$platform = $this->input->post('platform');
		//$platform_id = $this->input->post('id_number');

		// Check for duplicates using the model method
		if ($this->rider_model->check_duplicate_employee($id, $employee_id)) {
			$this->form_validation->set_message('check_emp_duplicate', 'Employee already registered, try a new one');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->rider_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['profile'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '" . $data['profile']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/rider/components/profile-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function profile_transfer()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->rider_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['profile'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'active' AND me.id = '" . $data['profile']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/rider/components/profile-transfer', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function profile_suspend()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->rider_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['profile'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'active' AND me.id = '" . $data['profile']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/rider/components/profile-suspend', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function allotId()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->rider_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['profile'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '" . $data['profile']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/rider/components/allotment-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function unallotId()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->rider_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['profile'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '" . $data['profile']['employee_id'] . "')")->row_array();
				$emp_id = $data['emp_detail']['id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/logistic-management/rider/components/unallotment-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function save_transfer_data()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('transfer_date', 'Transfer Date', 'trim|required');
		$this->form_validation->set_rules('id_type', 'ID Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			// Check if already suspended
			$is_transfered = $this->rider_model->is_already_transfered($id);
			if ($is_transfered) {
				$result = array("type" => 'error', "message" => 'Rider is already transfered.');
			} else {
				$data = array(
					'last_transfer_date' => $this->input->post('transfer_date'),
					'id_type' => $this->input->post('id_type'),
					'updated_at' => CURRENT_TIME
				);
				// Save data using the model
				$updated = $this->rider_model->update($id, $data);
				if ($updated) {
					$log_data = array(
						'transfer_date' => $this->input->post('transfer_date'),
						'id_type' => $this->input->post('id_type'),
						'employee_id' => $this->input->post('employee_id')
					);
					$insert_data = array(
						'logistic_rider_id' => $this->input->post('id'),
						'log_type' => 'transfer',
						'log_detail' => json_encode($log_data)
					);
					$this->rider_model->add_log($insert_data);
					$result = array("type" => 'success', "message" => 'Transfer request successfully updated.');
				} else {
					$result = array("type" => 'error', "message" => 'Transfer request not updated');
				}
			}
		}
		echo json_encode($result);
	}

	public function save_suspend_data()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('suspend_from', 'Suspend From', 'trim|required|callback_valid_date');
		$this->form_validation->set_rules('suspend_to', 'Suspend To', 'trim|required|callback_valid_date|callback_valid_date_range');
		$this->form_validation->set_rules('rider_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('reason', 'Suspend Reason', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id', TRUE);
			$employee_id = $this->input->post('employee_id', TRUE);
			$suspend_from = $this->input->post('suspend_from', TRUE);
			$suspend_to = $this->input->post('suspend_to', TRUE);
			$rider_status = $this->input->post('rider_status', TRUE);
			$reason = $this->input->post('reason', TRUE);

			$riderAllotedId = $this->db->query("SELECT lr.platform, lr.id_number, mli.id_type as aggregator_type FROM logistic_rider lr LEFT JOIN master_logistic_ids mli ON (lr.id_number = mli.id_number) WHERE lr.id = '" . $id . "'")->row();
			//dd($riderAllotedId);
			// Check if already suspended
			$is_suspended = $this->rider_model->is_already_suspended($id, $rider_status);
			if ($is_suspended) {
				$result = array("type" => 'error', "message" => 'Rider is already suspended.');
			} else {
				$data = array(
					'suspend_from' => $suspend_from,
					'suspend_to' => $suspend_to,
					'rider_status' => $rider_status,
					'updated_at' => CURRENT_TIME
				);

				// Save data using the model
				$updated = $this->rider_model->update($id, $data);
				if ($updated) {
					$log_data = array(
						'rider_status' => $rider_status,
						'employee_id' => $employee_id,
						'suspend_from' => $suspend_from,
						'suspend_to' => $suspend_to,
						'aggregator' => (!empty($riderAllotedId)) ? $riderAllotedId->platform : '',
						'aggregator_id' => (!empty($riderAllotedId)) ? $riderAllotedId->id_number : '',
						'aggregator_type' => (!empty($riderAllotedId)) ? $riderAllotedId->aggregator_type : '',
						'status' => 'Suspend'
					);
					$insert_data = array(
						'logistic_rider_id' => $id,
						'log_type' => 'status',
						'status_type' => 'Suspend',
						'reason' => $reason,
						'log_detail' => json_encode($log_data)
					);
					$this->rider_model->add_log($insert_data);
					$result = array("type" => 'success', "message" => 'Suspend request successfully updated.');
				} else {
					$result = array("type" => 'error', "message" => 'Suspend request not updated.');
				}
			}
		}
		echo json_encode($result);
	}

	// Callback functions for date validation
	public function valid_date($date)
	{
		$formatDate = date('Y-m-d', strtotime($date));
		if (DateTime::createFromFormat('Y-m-d', $formatDate) !== FALSE) {
			return TRUE;
		} else {
			$this->form_validation->set_message('valid_date', 'The {field} field must be a valid date.');
			return FALSE;
		}
	}

	public function valid_date_range($date_to)
	{
		$date_from = $this->input->post('suspend_from');
		if (strtotime($date_to) >= strtotime($date_from)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('valid_date_range', 'The Suspend To date must be later than the Suspend From date.');
			return FALSE;
		}
	}

	public function get_ajax_list()
	{
		$fetch_data = $this->rider_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $key_data) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $key_data->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = ($key_data->flex_no == '') ? 'NA' : $key_data->flex_no;
			$sub_array[] = !empty($key_data->vehicle_type)
			? (($key_data->vehicle_type === 'bike' ? '<i class="fa fa-motorcycle"></i>' : '<i class="fa fa-car"></i>') . ' ' . ($key_data->vehicle_no ?? ''))
			: '';
			$sub_array[] = $key_data->team_name;
			$sub_array[] = $key_data->food_company;
			$sub_array[] = $key_data->id_type;
			$sub_array[] = $key_data->id_number;
			$sub_array[] = $key_data->camp_name;
			$sub_array[] = $key_data->monthly_target;

			// Determine row class and overlay
			$status_classes = array('Inactive', 'Terminated', 'Resigned', 'Absconded', 'Final Exit');
			$row_class = in_array($key_data->emp_status, $status_classes) ? 'table-overlay' : '';
			$overlay_div = ($row_class) ? '<div class="overlay"></div>' : '';

			// Status badge
			$status_badge = $key_data->rider_status == 'active'
				? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>'
				: ($key_data->rider_status == 'inactive'
					? '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>'
					: '<span class="badge badge-pill badge-soft-warning font-size-13">Suspend</span>');

			$sub_array[] = $status_badge;

			if ($key_data->allotment_status == '0') {
				$allotment_status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
			}
			if ($key_data->allotment_status == '1') {
				$allotment_status = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
			}
			if ($key_data->allotment_status == '2') {
				$allotment_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';
			}
			$sub_array[] = $allotment_status;
			$sub_array[] = ($key_data->allotment_date !== '' && $key_data->allotment_date !== '0000-00-00' && $key_data->allotment_date !== NULL) ? date('d-m-Y', strtotime($key_data->allotment_date)) : 'NA';

			if (($key_data->allotment_status == '0' || $key_data->allotment_status == '2') && check_action_permission(get_user_role(), 'rider_profile', 'allotId')) {
				$allot_button = '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Allot" data-id="' . $key_data->id . '" data-type="allotment" onclick="allotModal(' . $key_data->id . ')"><i class="mdi mdi-hand-heart-outline font-size-18"></i></button>';
			} elseif ($key_data->allotment_status == '1' && check_action_permission(get_user_role(), 'rider_profile', 'unallotId')) {
				$allot_button = '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Unallotment" data-id="' . $key_data->id . '" data-type="unallotment" onclick="swapModal(' . $key_data->id . ')"><i class="mdi mdi-undo-variant font-size-18"></i></button>';
			} else {
				$allot_button = '';
			}

			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));

			// Buttons
			$suspendBtn = ($key_data->rider_status !== 'suspend' && check_action_permission(get_user_role(), 'rider_profile', 'profile_suspend'))
				? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Profile Suspend" onclick="suspendModal(' . $key_data->id . ')"><i class="mdi mdi-block-helper font-size-18"></i></button>'
				: '';

			$swapBtn = (!empty($key_data->food_company) && !empty($key_data->id_number) && check_action_permission(get_user_role(), 'rider_profile', 'unallotId'))
				? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="ID Swap" onclick="swapModal(' . $key_data->id . ')"><i class="mdi mdi-swap-horizontal font-size-18"></i></button>'
				: '';

			$transferBtn = ($key_data->last_transfer_date !== '' && $key_data->last_transfer_date !== '0000-00-00' && $key_data->last_transfer_date !== NULL)
				? ''
				: '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Profile Transfer" onclick="transferModal(' . $key_data->id . ')"><i class="mdi mdi-account-arrow-right-outline font-size-18"></i></button>';

			if($key_data->emp_status == 'Terminated'){
				$sub_array[] = (check_action_permission(get_user_role(), 'rider_profile', 'detail') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="detailModal(' . $key_data->id . ')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>' : '');
			}else{
				$sub_array[] = (check_action_permission(get_user_role(), 'rider_profile', 'detail') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit load_edit_modal" title="Edit" onclick="editModal(' . $key_data->id . ')"><i class="mdi mdi-pencil font-size-18"></i></button> <button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="detailModal(' . $key_data->id . ')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>' : '') . $suspendBtn . $allot_button;
			}
			$sub_array[] = $key_data->emp_status;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->rider_model->get_all_data(),
			"recordsFiltered" => $this->rider_model->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function ajax_check_empid()
	{
		$emp_id = $this->input->get('employee_id');
		$id = $this->input->get('id');
		$platform = $this->input->get('platform');
		$platform_id = $this->input->get('id_number');
		if ($emp_id !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->rider_model->check_duplicate_employee($id, $emp_id);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'>This Employee already registered. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Platform Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Employee ID is required.</span>";
		}
		echo json_encode($data);
	}

	public function check_id_number()
	{
		$rider_id = $this->input->post('rider_id');
		$this->load->model('Rider_model');
		$id_number = $this->Rider_model->get_id_number($rider_id);
		if ($id_number) {
			echo json_encode(['status' => 'error', 'message' => '<i class="mdi mdi-information-outline"></i> An ID number is already assigned to this user. Assigning a new one will deactivate the existing ID']);
		} else {
			echo json_encode(['status' => 'success']);
		}
	}

	public function saveUnallotment()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('reason', 'Unallot Reason', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id', TRUE);
			$employee_id = $this->input->post('employee_id', TRUE);
			$reason = $this->input->post('reason', TRUE);
			// Check if same rider
			$old_rider_info = $this->rider_model->get_detail($id);
			if ($old_rider_info->num_rows() > 0) {
				$rider_detail = $old_rider_info->row();
				//dd($new_rider_detail);
				$rider_id = $rider_detail->id;
				$allotment_status = $rider_detail->allotment_status;
				if ($allotment_status == '1') {
					// Update Old User
					$data = array(
						'id_number' => '',
						'platform' => '',
						'allotment_status' => '2',
						'allotment_date' => '',
						'updated_at' => CURRENT_TIME
					);
					$updated = $this->rider_model->update($id, $data);
					if ($updated) {
						// Insert Log
						$old_user_log_data = array(
							'rider_status' => $rider_detail->rider_status,
							'employee_id' => $rider_detail->employee_id,
							'id_number' => $rider_detail->id_number,
							'platform' => $rider_detail->platform,
							'id_type' => $rider_detail->id_type,
							'status' => 'unallot'
						);

						$insert_old_user_log_data = array(
							'logistic_rider_id' => $id,
							'log_type' => 'unallot',
							'status_type' => 'id_unallot',
							'reason' => $reason,
							'log_detail' => json_encode($old_user_log_data)
						);
						$this->rider_model->add_log($insert_old_user_log_data);
						$this->rider_model->removeRiderFromAllTeams($employee_id);
					}
					$result = array("type" => 'success', "message" => 'Unallotment id request successfully updated.');
				} else {
					$result = array("type" => 'error', "message" => 'This aggregator id is already unalloted or new.');
				}
			} else {
				$result = array("type" => 'error', "message" => 'No detail found of selected rider.');
			}
		}
		echo json_encode($result);
	}

	public function saveAllotment()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('reason', 'Message', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id', TRUE);
			$employee_id = $this->input->post('employee_id', TRUE);
			$reason = $this->input->post('reason', TRUE);
			// Check if same rider
			$old_rider_info = $this->rider_model->get_detail($id);
			if ($old_rider_info->num_rows() > 0) {
				$rider_detail = $old_rider_info->row();
				//dd($new_rider_detail);
				$rider_id = $rider_detail->id;
				$allotment_status = $rider_detail->allotment_status;
				if ($allotment_status == '0' || $allotment_status == '2') {
					// Update Old User
					$data = array(
						'platform' => $this->input->post('platform'),
						'id_number' => $this->input->post('id_number'),
						'allotment_status' => '1',
						'allotment_date' => date('Y-m-d'),
						'created_at' => CURRENT_TIME
					);
					$updated = $this->rider_model->update($id, $data);
					if ($updated) {
						$id_number = $this->input->post('id_number');
						$aggregator_detail = $this->rider_model->get_aggregator_detail($id_number);
						// Insert Log
						$allotment_log_data = array(
							'rider_status' => $rider_detail->rider_status,
							'employee_id' => $rider_detail->employee_id,
							'id_number' => $this->input->post('id_number'),
							'platform' => $this->input->post('platform'),
							'id_type' => $aggregator_detail->id_type,
							'status' => 'allot'
						);

						$insert_user_log_data = array(
							'logistic_rider_id' => $id,
							'log_type' => 'allot',
							'status_type' => 'id_allot',
							'reason' => $reason,
							'log_detail' => json_encode($allotment_log_data)
						);
						$this->rider_model->add_log($insert_user_log_data);
					}
					$result = array("type" => 'success', "message" => 'Allotment aggregator id request successfully updated.');
				} else {
					$result = array("type" => 'error', "message" => 'This aggregator id is already alloted or new.');
				}
			} else {
				$result = array("type" => 'error', "message" => 'No detail found of selected rider.');
			}
		}
		echo json_encode($result);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'rider_profile', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->rider_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic-management/rider/list');
	}
	
	public function print_overall_deliv_report()
	{
		$this->load->library('Pdf_hunger_report_landscape');
		$search = $this->input->get('search_employee') ?? $this->input->get('search_employee') ?? false;
		$date_from = $this->input->get('date_from') ?? false;
		$date_to = $this->input->get('date_to') ?? false;
		$employer_id = $this->input->get('employer') ?? false;
		$team = $this->input->get('team') ?? false;
		//$data['reports'] = $this->rider_model->overall_report($search, $date_from, $date_to, $employer_id, $team);
		//dd($date_from);
        $data['details']['hunger_maha'] = $this->rider_model->get_maha_hunger_data($date_from, $date_to, $search);
        $data['details']['hunger_wazer'] = $this->rider_model->get_wazer_hunger_data($date_from, $date_to, $search);
        $data['details']['hunger_outsource'] = $this->rider_model->get_outsource_hunger_data($date_from, $date_to, $search);
        $data['details']['jahez'] = $this->rider_model->get_jahez_data($date_from, $date_to, $search);
        $data['details']['noon'] = $this->rider_model->get_noon_data($date_from, $date_to, $search);

        //Attendance breakdown
        $data['attendance']['hunger_maha'] = $this->rider_model->maha_absent_summary($date_to, $search);
        $data['attendance']['hunger_wazer'] = $this->rider_model->wazer_absent_summary($date_to, $search);
        $data['attendance']['hunger_outsource'] = $this->rider_model->outsource_absent_summary($date_to, $search);
        $data['attendance']['jahez'] = $this->rider_model->jahez_absent_summary($date_to, $search);
        $data['attendance']['nonoperational'] = $this->rider_model->nonoperational_absent_summary($date_to, $search);
		//dd($data['attendance']);

		//Employees in above reports
		$emp_data['maha_employees'] = $this->rider_model->maha_employee_order_report($date_from, $date_to, $search);
        $emp_data['wazer_employees'] = $this->rider_model->wazer_employee_order_report($date_from, $date_to, $search);
        $emp_data['outsource_employees'] = $this->rider_model->outsource_hunger_employees($date_from, $date_to, $search);
        $emp_data['jahez_employees'] = $this->rider_model->jahez_orders_employees($date_from, $date_to, $search);

		// Hunger employees < 13 deliveries
		$emp_data['low_hunger'] = $this->rider_model->hunger_low_delivery_employees($date_to, 'hunger', $search);
		// Jahez employees < 13 deliveries
		$emp_data['low_jahez'] = $this->rider_model->jahez_low_delivery_employees($date_to, 'jahez', $search);

		// Jahez employees Cash and Debit Collection
		$emp_data['jahez_cash_employees'] = $this->rider_model->jahez_with_cod_employees($date_to, 'jahez', $search);
		$emp_data['jahez_debit_employees'] = $this->rider_model->jahez_with_debit_employees($date_to, 'jahez', $search);

		// Employee Attendance
        $emp_data['hunger_maha_attend'] = $this->rider_model->maha_absent_employees($date_to, $search);
        $emp_data['hunger_wazer_attend'] = $this->rider_model->wazer_absent_employees($date_to, $search);
        $emp_data['outsource_attend'] = $this->rider_model->outsource_absent_employees($date_to, $search);
        $emp_data['jahez_attend'] = $this->rider_model->jahez_absent_employees($date_to, $search);
        $emp_data['nonoperational_attend'] = $this->rider_model->nonoperational_absent_employees($date_to, $search);
		//dd($emp_data['nonoperational_attend']);
		if ($team) {
			$team_name = $query = $this->db->query("SELECT `name`, `ar_name` FROM `hunger_team`")->row()->name;
		} else {
			$team_name = '';
		}
		//echo '<pre>' . print_r($data['reports'], true) . '</pre>';exit();
		$data['search_keyword'] = $search;
		$data['employer_name'] = ($employer_id) ? $this->db->where('id', $employer_id)->get('sponsors')->row()->employer_name : NULL;
		$data['team_name'] = $team_name;
		$data['date_from'] = $date_from ? htmlspecialchars($date_from) : 'NA';
		$data['date_to'] = $date_to ? htmlspecialchars($date_to) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Maha Al Fala Delivery Report');
		$pdf->SetSubject('Maha Al Fala Delivery Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Maha Al Fala Delivery Report');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/logistic-management/rider/print/rider_report_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/logistic-management/rider/print/rider_report_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/rider/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');
		// Arabic and English content
		// Set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('helvetica', '', 10);

		// First page: Report
		$htmlcontent = $this->load->view('admin/logistic-management/rider/print/riders_overall_report', $data, true);
		$pdf->writeHTML($htmlcontent, true, 0, true, 0);

		// Add a new page before employees list
		$pdf->AddPage('P', 'A4');

		// Employees List (next pages)
		$htmlcontent2 = $this->load->view('admin/logistic-management/rider/print/emp_list_overall_report', $emp_data, true);
		$pdf->writeHTML($htmlcontent2, true, 0, true, 0);

		$filename = $date_from
			? 'BS-Overall-Delivery-Report-' . htmlspecialchars($date_from) . '-' . htmlspecialchars($date_to) . '.pdf'
			: 'BS-Overall-Delivery-Report.pdf';
		$pdf->Output($filename, 'I');
	}
}
