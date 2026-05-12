<?php defined('BASEPATH') or exit('No direct script access allowed');

class Accident_management extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Employee_model', 'employee_model');
			$this->load->model('admin/hr-module/AccidentManagement_model', 'accident_model');
			$this->load->library('form_validation');
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
		if ($this->action && !check_action_permission(get_user_role(), 'accident_list', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/hr-module/accident_management/index', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'accident_list', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->load->view('admin/hr-module/accident_management/components/add-form');
	}

	public function vehicle_list()
	{
		$search = $this->input->post('search');

		$this->db->like('vehicle_no', $search);
		$this->db->or_like('vehicle_model', $search);
		$query = $this->db->get('master_vehicles');

		$result = $query->result();

		$response = [];
		foreach ($result as $row) {
			$response[] = [
				'id' => $row->id,
				'vehicle_no' => $row->vehicle_no,
				'vehicle_model' => $row->vehicle_model,
				'vehicle_type' => $row->vehicle_type,
			];
		}

		echo json_encode($response);
	}

	public function get_vehicle_detail()
	{
		$this->form_validation->set_rules('search_vehicle', 'Vehicle ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$vehicle_id = $this->input->post('search_vehicle');
			$query = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.vehicle_ownership, mv.insurance_no, mv.insurance_company_name, mv.insurance_issue_date, mv.insurance_expiry, mvk.make_name, mic.company_name, mip.policy_number FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_insurance_policies as mip ON (mv.insurance_no = mip.id) LEFT JOIN master_insurance_company as mic ON (mv.insurance_company_name = mic.id) WHERE mv.id = '" . (int)$vehicle_id . "'");
			if ($query->num_rows() > 0) {
				$data['vehicle_detail'] = $query->row_array();
				//dd($data['vehicle_detail']);
				$vehicle_no = $data['vehicle_detail']['vehicle_no'];
				$vehicle_type = $data['vehicle_detail']['vehicle_type'];
				$vehicle_model = $data['vehicle_detail']['vehicle_model'];
				$output_data = $this->load->view('admin/hr-module/accident_management/components/vehicle-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Vehicle detail successfully fetched.', "output_html" => $output_data, "vehicle_no" => $vehicle_no, "vehicle_model" => $vehicle_model, "vehicle_type" => $vehicle_type);
			} else {
				$result = array("type" => 'error', "message" => 'Vehicle detail not found, try again');
			}
		}
		echo json_encode($result);
	}

	public function get_employee_detail()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			$query = $this->db->query("SELECT me.id as employee_id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'Active' AND me.id='" . $emp_id . "')");
			if ($query->num_rows() > 0) {
				$data['emp_detail'] = $query->row_array();
				$emp_id = $data['emp_detail']['employee_id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/hr-module/accident_management/components/employee-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Employee detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found or inactive, try again');
			}
		}
		echo json_encode($result);
	}

	public function save()
	{
		$this->form_validation->set_rules('employee_id', 'Employee Detail', 'trim|required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle Detail', 'trim|required');
		// $this->form_validation->set_rules('insurance_provider', 'Insurance Service Provider', 'trim|required');
		// $this->form_validation->set_rules('ins_policy_no', 'Insurance Policy Number', 'trim|required');
		// $this->form_validation->set_rules('ins_start_date', 'Insurance Start Date', 'trim|required');
		// $this->form_validation->set_rules('ins_end_date', 'Insurance End Date', 'trim|required');
		// $this->form_validation->set_rules('ins_status', 'Insurance Status', 'trim|required');
		$this->form_validation->set_rules('accident_date', 'Accident Date', 'trim|required');
		$this->form_validation->set_rules('accident_attended_by', 'Accident Attended By', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// ✅ Manual check for insurance details
			if (
				empty($this->input->post('insurance_provider')) ||
				empty($this->input->post('ins_policy_no')) ||
				empty($this->input->post('ins_start_date')) ||
				empty($this->input->post('ins_end_date'))
			) {
				$result = array("type" => 'error', "message" => 'Please add insurance details first before submitting the accident.');
				echo json_encode($result);
				exit; // Stop further execution
			}

			if (isset($_FILES['hhdr_report_attachment']) && !empty($_FILES['hhdr_report_attachment']['name'])) {
				$hhdr_report_attachment = $this->input->post('hhdr_report_attachment');
				$upload_hhdr_report = $this->upload_file('hhdr_report_attachment');
			} else {
				$upload_hhdr_report = '';
			}
			if (isset($_FILES['attach_da_final_report']) && !empty($_FILES['attach_da_final_report']['name'])) {
				$attach_da_final_report = $this->input->post('attach_da_final_report');
				$upload_da_final_report = $this->upload_file('attach_da_final_report');
			} else {
				$upload_da_final_report = '';
			}
			if (isset($_FILES['ld_report_attachment']) && !empty($_FILES['ld_report_attachment']['name'])) {
				$ld_report_attachment = $this->input->post('ld_report_attachment');
				$upload_ld_report = $this->upload_file('ld_report_attachment');
			} else {
				$upload_ld_report = '';
			}
			if (isset($_FILES['attach_maroor_report']) && !empty($_FILES['attach_maroor_report']['name'])) {
				$attach_maroor_report = $this->input->post('attach_maroor_report');
				$upload_maroor_report = $this->upload_file('attach_maroor_report');
			} else {
				$upload_maroor_report = '';
			}
			$data = array(
				'employee_id' => $this->input->post('employee_id'),
				'vehicle_id' => $this->input->post('vehicle_id'),
				'insurance_provider' => $this->input->post('insurance_provider'),
				'ins_policy_no' => $this->input->post('ins_policy_no'),
				'ins_start_date' => $this->input->post('ins_start_date'),
				'ins_end_date' => $this->input->post('ins_end_date'),
				'accident_date' => $this->input->post('accident_date'),
				'accident_time' => $this->input->post('accident_time'),
				'accident_location' => $this->input->post('accident_location'),
				'accident_attended_by' => $this->input->post('accident_attended_by'),
				'ambulance' => $this->input->post('ambulance'),
				'injury_description' => $this->input->post('injury_description'),
				'hhdr_report_no' => $this->input->post('hhdr_report_no'),
				'hhdr_report_attachment' => $upload_hhdr_report,
				'ld_report_no' => $this->input->post('ld_report_no'),
				'ld_report_attachment' => $upload_ld_report,
				'maroor_report_no' => $this->input->post('maroor_report_no'),
				'attach_maroor_report' => $upload_maroor_report,
				'da_liability_perc' => $this->input->post('da_liability_perc'),
				'taqdeer_inspection_date' => $this->input->post('taqdeer_inspection_date'),
				'da_final_report_no' => $this->input->post('da_final_report_no'),
				'attach_da_final_report' => $upload_da_final_report,
				'taqdeer_da_fees' => $this->input->post('taqdeer_da_fees'),
				'insurance_claim_fees' => $this->input->post('insurance_claim_fees'),
				'other_cost' => $this->input->post('other_cost'),
				'final_assessment_cost' => $this->input->post('final_assessment_cost')
			);
			// Save data using the model
			$insert_id = $this->accident_model->save_accident_data($data);
			if ($insert_id) {
				if (!empty($_FILES['document_file']['name'][0])) {  // check first element to avoid errors
					$filesCount = count($_FILES['document_file']['name']);
					$document_names = $this->input->post('document_name');

					for ($i = 0; $i < $filesCount; $i++) {

						// ✅ skip if no file selected for this index
						if (empty($_FILES['document_file']['name'][$i])) {
							continue;
						}

						$_FILES['file']['name']     = $_FILES['document_file']['name'][$i];
						$_FILES['file']['type']     = $_FILES['document_file']['type'][$i];
						$_FILES['file']['tmp_name'] = $_FILES['document_file']['tmp_name'][$i];
						$_FILES['file']['error']    = $_FILES['document_file']['error'][$i];
						$_FILES['file']['size']     = $_FILES['document_file']['size'][$i];

						$file_name = $this->upload_file('file');

						if ($file_name) {
							$attachment_data = array(
								'accident_id'    => $insert_id,
								'document_name'  => $document_names[$i],
								'attachment'     => $file_name,
								'created_at'     => date('Y-m-d H:i:s')
							);

							$this->accident_model->save_attachment_data($attachment_data);
						}
					}
				}
				$result = array("type" => 'success', "message" => 'Accident detail successfully added.');
			} else {
				$result = array("type" => 'error', "message" => 'Something went wrong, try again');
			}
		}
		echo json_encode($result);
	}

	public function upload_file($file)
	{
		$upload_path = './uploads/accident-docs/';

		// Check if the folder exists, if not, create it
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true); // Recursive directory creation
		}

		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
		$config['max_size']      = 0;
		$config['max_width']     = 0;
		$config['max_height']    = 0;
		$config['max_filename']  = '50';
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file)) {
			// Upload failed, display error
			$error = $this->upload->display_errors();
			log_message('error', 'File upload error: ' . $error);
			return false;
		} else {
			// Upload successful, get file data
			$file_data = $this->upload->data();
			$image = $upload_path . $file_data['file_name'];

			// Now you can use $image for further processing (e.g., save file path to database)
			return $image;
		}
	}

	public function edit($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'accident_list', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($id > 0) {
			$query = $this->accident_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['accident_detail'] = $query->row_array();
				$data['accident_attachments'] = $this->accident_model->get_attachments($id);
				$emp_id = $data['accident_detail']['employee_id'];
				$vehicle_id = $data['accident_detail']['vehicle_id'];
				$data['emp_detail'] = $this->db->query("SELECT me.id as employee_id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'Active' AND me.id='" . $emp_id . "')")->row_array();
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.vehicle_ownership, mv.insurance_no, mv.insurance_company_name, mv.insurance_issue_date, mv.insurance_expiry, mvk.make_name, mic.company_name, mip.policy_number FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_insurance_policies as mip ON (mv.insurance_no = mip.id) LEFT JOIN master_insurance_company as mic ON (mv.insurance_company_name = mic.id) WHERE mv.id = '" . (int)$vehicle_id . "'")->row_array();
			} else {
				$result = array("type" => 'error', "message" => 'Accident detail not found, try again');
			}
			//dd($data['vehicle_detail']);
			$output_data = $this->load->view('admin/hr-module/accident_management/components/edit-form', $data, TRUE);
			$result = array("type" => 'success', "message" => 'Accident detail successfully fetched.', "output_html" => $output_data);
		} else {
			$result = array("type" => 'error', "message" => 'Invalid request ID!');
		}
		echo json_encode($result);
	}

	public function update()
	{
		$this->load->library('upload');
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Employee Detail', 'trim|required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle Detail', 'trim|required');
		// $this->form_validation->set_rules('insurance_provider', 'Insurance Service Provider', 'trim|required');
		// $this->form_validation->set_rules('ins_policy_no', 'Insurance Policy Number', 'trim|required');
		// $this->form_validation->set_rules('ins_start_date', 'Insurance Start Date', 'trim|required');
		// $this->form_validation->set_rules('ins_end_date', 'Insurance End Date', 'trim|required');
		// $this->form_validation->set_rules('ins_status', 'Insurance Status', 'trim|required');
		$this->form_validation->set_rules('accident_date', 'Accident Date', 'trim|required');
		$this->form_validation->set_rules('accident_attended_by', 'Accident Attended By', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			if (isset($_FILES['hhdr_report_attachment']) && !empty($_FILES['hhdr_report_attachment']['name'])) {
				$upload_hhdr_report = $this->upload_file('hhdr_report_attachment');
			} else {
				$upload_hhdr_report = $this->input->post('old_hhdr_report_attachment');
			}

			if (isset($_FILES['attach_da_final_report']) && !empty($_FILES['attach_da_final_report']['name'])) {
				$upload_da_final_report = $this->upload_file('attach_da_final_report');
			} else {
				$upload_da_final_report = $this->input->post('old_attach_da_final_report');
			}

			if (isset($_FILES['ld_report_attachment']) && !empty($_FILES['ld_report_attachment']['name'])) {
				$upload_ld_report = $this->upload_file('ld_report_attachment');
			} else {
				$upload_ld_report = $this->input->post('old_ld_report_attachment');
			}

			if (isset($_FILES['attach_maroor_report']) && !empty($_FILES['attach_maroor_report']['name'])) {
				$upload_maroor_report = $this->upload_file('attach_maroor_report');
			} else {
				$upload_maroor_report = $this->input->post('old_attach_maroor_report');
			}

			$id = $this->input->post('id');
			/*
			'employee_id' => $this->input->post('employee_id'),
			'vehicle_id' => $this->input->post('vehicle_id'),
			'insurance_provider' => $this->input->post('insurance_provider'),
			'ins_policy_no' => $this->input->post('ins_policy_no'),
			'ins_start_date' => $this->input->post('ins_start_date'),
			'ins_end_date' => $this->input->post('ins_end_date'),
			*/
			$data = array(
				'accident_date' => $this->input->post('accident_date'),
				'accident_time' => $this->input->post('accident_time'),
				'accident_location' => $this->input->post('accident_location'),
				'accident_attended_by' => $this->input->post('accident_attended_by'),
				'ambulance' => $this->input->post('ambulance'),
				'injury_description' => $this->input->post('injury_description'),
				'hhdr_report_no' => $this->input->post('hhdr_report_no'),
				'hhdr_report_attachment' => $upload_hhdr_report,
				'ld_report_no' => $this->input->post('ld_report_no'),
				'ld_report_attachment' => $upload_ld_report,

				'maroor_report_no' => $this->input->post('maroor_report_no'),
				'attach_maroor_report' => $upload_maroor_report,
				'da_liability_perc' => $this->input->post('da_liability_perc'),
				'taqdeer_inspection_date' => $this->input->post('taqdeer_inspection_date'),
				'da_final_report_no' => $this->input->post('da_final_report_no'),
				'attach_da_final_report' => $upload_da_final_report,
				'taqdeer_da_fees' => $this->input->post('taqdeer_da_fees'),
				'insurance_claim_fees' => $this->input->post('insurance_claim_fees'),
				'other_cost' => $this->input->post('other_cost'),
				'final_assessment_cost' => $this->input->post('final_assessment_cost')
			);
			// Save data using the model
			$updated = $this->accident_model->update_accident_data($id, $data);
			if ($updated) {
				// ==== Handle Existing Attachments ====
				$existing_ids = $this->input->post('attachment_id');
				$existing_names = $this->input->post('document_name_existing');
				$existing_paths = $this->input->post('existing_attachment');

				$existing_files = $_FILES['document_file_existing'] ?? null;

				if (!empty($existing_ids)) {
					foreach ($existing_ids as $index => $attach_id) {
						$attach_data = [
							'document_name' => $existing_names[$index],
						];

						if ($existing_files && !empty($existing_files['name'][$index])) {
							$_FILES['file']['name'] = $existing_files['name'][$index];
							$_FILES['file']['type'] = $existing_files['type'][$index];
							$_FILES['file']['tmp_name'] = $existing_files['tmp_name'][$index];
							$_FILES['file']['error'] = $existing_files['error'][$index];
							$_FILES['file']['size'] = $existing_files['size'][$index];

							$config['upload_path'] = './uploads/accident_attachments/';
							$config['allowed_types'] = '*';
							$config['encrypt_name'] = true;

							$this->upload->initialize($config);

							if ($this->upload->do_upload('file')) {
								$uploadData = $this->upload->data();
								$attach_data['attachment'] = base_url('uploads/accident_attachments/' . $uploadData['file_name']);

								// Delete old file
								if (!empty($existing_paths[$index]) && file_exists(str_replace(base_url(), FCPATH, $existing_paths[$index]))) {
									unlink(str_replace(base_url(), FCPATH, $existing_paths[$index]));
								}
							}
						} else {
							$attach_data['attachment'] = $existing_paths[$index];
						}

						$this->accident_model->update_attachment($attach_id, $attach_data);
					}
				}

				// ==== Handle New Attachments ====
				$new_names = $this->input->post('document_name');
				$new_files = $_FILES['document_file_new'] ?? null;

				if (!empty($new_names)) {
					foreach ($new_names as $index => $name) {
						if (!empty($new_files['name'][$index])) {
							$_FILES['file']['name'] = $new_files['name'][$index];
							$_FILES['file']['type'] = $new_files['type'][$index];
							$_FILES['file']['tmp_name'] = $new_files['tmp_name'][$index];
							$_FILES['file']['error'] = $new_files['error'][$index];
							$_FILES['file']['size'] = $new_files['size'][$index];

							$config['upload_path'] = './uploads/accident_attachments/';
							$config['allowed_types'] = '*';
							$config['encrypt_name'] = true;

							$this->upload->initialize($config);
							if ($this->upload->do_upload('file')) {
								$uploadData = $this->upload->data();
								$attachment_data = [
									'accident_id' => $id,
									'document_name' => $name,
									'attachment' => 'uploads/accident_attachments/' . $uploadData['file_name']
								];
								$this->accident_model->insert_attachment($attachment_data);
							}
						}
					}
				}

				$result = array("type" => 'success', "message" => 'Accident detail successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'Something went wrong, try again');
			}
		}
		echo json_encode($result);
	}

	public function detail($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'accident_list', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($id > 0) {
			$query = $this->accident_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['accident_detail'] = $query->row_array();
				$data['accident_attachments'] = $this->accident_model->get_attachments($id);
				$emp_id = $data['accident_detail']['employee_id'];
				$vehicle_id = $data['accident_detail']['vehicle_id'];
				$data['emp_detail'] = $this->db->query("SELECT me.id as employee_id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'Active' AND me.id='" . $emp_id . "')")->row_array();
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.vehicle_ownership, mv.insurance_no, mv.insurance_company_name, mv.insurance_issue_date, mv.insurance_expiry, mvk.make_name, mic.company_name, mip.policy_number FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_insurance_policies as mip ON (mv.insurance_no = mip.id) LEFT JOIN master_insurance_company as mic ON (mv.insurance_company_name = mic.id) WHERE mv.id = '" . (int)$vehicle_id . "'")->row_array();
			} else {
				$result = array("type" => 'error', "message" => 'Accident detail not found, try again');
			}
			//dd($data['vehicle_detail']);
			$output_data = $this->load->view('admin/hr-module/accident_management/components/detail', $data, TRUE);
			$result = array("type" => 'success', "message" => 'Accident detail successfully fetched.', "output_html" => $output_data);
		} else {
			$result = array("type" => 'error', "message" => 'Accident detail not found, try again');
		}
		echo json_encode($result);
	}

	public function get_list()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('vehicle_no'))) {
			$vehicle_no = $this->input->get('vehicle_no');
		} else {
			$vehicle_no = FALSE;
		}
		if (!empty($this->input->get('insurance_provider'))) {
			$insurance_provider = $this->input->get('insurance_provider');
		} else {
			$insurance_provider = FALSE;
		}
		$fetch_data = $this->accident_model->get_list($keyword, $vehicle_no, $insurance_provider);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $item->id . '" />';
			$sub_array[] = $item->emp_no;
			$sub_array[] = (($item->emp_full_name !== '') ? $item->emp_full_name : '') . '' . (($item->employee_arabic_name !== '') ? ' / ' . $item->employee_arabic_name : '');
			$sub_array[] = $item->iqama_no;
			$sub_array[] = ucfirst($item->vehicle_type);
			$sub_array[] = $item->vehicle_no;
			$sub_array[] = $item->vehicle_model;
			$sub_array[] = $item->hhdr_report_no;
			$sub_array[] = ((isset($item->accident_date)) ? date('d-m-Y', strtotime($item->accident_date)) : '');
			$sub_array[] = (isset($item->da_liability_perc)) ? $item->da_liability_perc : 'NA';
			$sub_array[] = $item->insurance_claim_fees;
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			$userRole = get_user_role();
			$actionDropdown = '<div class="btn-group ms-2 float-end">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">';
			if (check_action_permission($userRole, 'accident_list', 'edit')) {
				$actionDropdown .= '<a type="button" class="dropdown-item px-3 py-0 load_edit_modal" title="Edit" data-id="' . $item->id . '">
					<i class="mdi mdi-pencil font-size-16"></i> Edit Accident
				</a>';
			}

			// Detail Button
			if (check_action_permission($userRole, 'accident_list', 'detail')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a type="button" class="dropdown-item px-3 py-0 load_detail_modal" title="Detail" data-id="' . $item->id . '">
					<i class="mdi mdi-stretch-to-page-outline font-size-16"></i> Accident Detail
				</a>';
			}

			if (check_action_permission($userRole, 'accident_list', 'print_injury_form')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item px-3 py-0" target="_blank" href="' . base_url('admin/hr/accident-management/print-injury-form/' . $item->id) . '">
					<i class="mdi mdi-printer font-size-16"></i> Print Injury Description
				</a>';
			}
			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->accident_model->get_all_data(),
			"recordsFiltered"     =>     $this->accident_model->get_filtered_data($keyword, $vehicle_no, $insurance_provider),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'accident_list', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->accident_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/accident-management');
	}

	public function print_injury_form($id)
	{
		if (!$this->action || !check_action_permission(get_user_role(), 'accident_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$query = $this->accident_model->get_detail($id);
		if ($query->num_rows() > 0) {
			$data['accident_detail'] = $query->row_array();
			$emp_id = $data['accident_detail']['employee_id'];
			// Employee Detail
			$this->db->select('me.id as employee_id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, me.work_joining_date, mei.gosi_id, sp.employer_id, sp.employer_name, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name');
			$this->db->from('master_employee me');
			$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
			$this->db->join('sponsors sp', 'me.sponsor_id = sp.id', 'left');
			$this->db->join('master_nationality mn', 'me.nationality = mn.id', 'left');
			$this->db->join('master_department md', 'me.department = md.id', 'left');
			$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
			$this->db->where('me.status', 'Active');
			$this->db->where('me.id', $emp_id);
			$data['emp_detail'] = $this->db->get()->row_array();

			$data['print_date'] = date('l, d F, Y');
			//$data['signature_date'] = date('jS F Y');
			$data['signature_date'] = date('j-M-Y');
			$data['request_date'] = date('j-M-Y', strtotime($data['accident_detail']['accident_date']));
			$class_name = 'Pdf_general_margin';
			$this->load->library($class_name);

			// create new PDF document
			$pdf = new $class_name(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Injury Description form');
			$pdf->SetSubject('BS - Injury Description form');
			$pdf->SetKeywords('Baqala Station, PDF, Injury Description form, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			// Conditional top margin setting
			$pdf->SetMargins(10, 40, 11, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage();
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);
			$htmlcontent = $this->load->view('admin/hr-module/accident_management/print/print_injury_form', $data, TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Injury-Description-Form' . '-' . $data['emp_detail']['emp_no'] . '_' . $data['emp_detail']['full_name'] . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Request detail not found!");
			redirect('admin/hr/accident-management');
		}
	}
}
