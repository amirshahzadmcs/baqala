<?php defined('BASEPATH') or exit('No direct script access allowed');

class Accident extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Employee_model', 'employee_model');
			$this->load->model('admin/hr-module/Accident_model', 'accident_model');
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
		$this->load->view('admin/hr-module/accidents/index', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'accident_list', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->load->view('admin/hr-module/accidents/add');
	}

	public function get_employee_detail()
	{
		$this->form_validation->set_rules('search_employee', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_id = $this->input->post('search_employee');
			$query = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.iqama_no, me.status, me.nationality, me.employee_pic, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) WHERE me.status = 'active' AND me.id='" . $emp_id . "'");
			if ($query->num_rows() > 0) {
				$data['emp_detail'] = $query->row_array();
				$emp_name = $data['emp_detail']['full_name'];
				$emp_pic = $data['emp_detail']['employee_pic'];
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/hr-module/accidents/components/employee-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Employee detail successfully fetched.', "output_html" => $output_data, "profile_picture_url" => $emp_pic, "emp_name" => $emp_name);
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found, try again');
			}
		}
		echo json_encode($result);
	}

	public function save()
	{
		$this->form_validation->set_rules('employee_id', 'Employee Detail', 'trim|required');
		// $this->form_validation->set_rules('vehicle_id', 'Vehicle Detail', 'trim|required');
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
			if (isset($_FILES['attach_hhdr_report']) && !empty($_FILES['attach_hhdr_report']['name'])) {
				$attach_hhdr_report = $this->input->post('attach_hhdr_report');
				$upload_hhdr_report = $this->upload_file('attach_hhdr_report');
			} else {
				$upload_hhdr_report = '';
			}
			if (isset($_FILES['attach_da_final_report']) && !empty($_FILES['attach_da_final_report']['name'])) {
				$attach_da_final_report = $this->input->post('attach_da_final_report');
				$upload_da_final_report = $this->upload_file('attach_da_final_report');
			} else {
				$upload_da_final_report = '';
			}
			if (isset($_FILES['attach_ld_report']) && !empty($_FILES['attach_ld_report']['name'])) {
				$attach_ld_report = $this->input->post('attach_ld_report');
				$upload_ld_report = $this->upload_file('attach_ld_report');
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
				'ins_status' => $this->input->post('ins_status'),
				'accident_date' => $this->input->post('accident_date'),
				'accident_attended_by' => $this->input->post('accident_attended_by'),
				'hhdr_report_no' => $this->input->post('hhdr_report_no'),
				'attach_hhdr_report' => $upload_hhdr_report,
				'da_final_report_no' => $this->input->post('da_final_report_no'),
				'attach_da_final_report' => $upload_da_final_report,
				'ld_report_no' => $this->input->post('ld_report_no'),
				'attach_ld_report' => $upload_ld_report,
				'employee_liability_perc' => $this->input->post('employee_liability_perc'),
				'maroor_report_no' => $this->input->post('maroor_report_no'),
				'attach_maroor_report' => $upload_maroor_report,
				'taqdeer_inspection_date' => $this->input->post('taqdeer_inspection_date'),
				'taqdeer_da_fees' => $this->input->post('taqdeer_da_fees'),
				'insurance_claim_fees' => $this->input->post('insurance_claim_fees'),
				'other_cost' => $this->input->post('other_cost'),
				'final_assessment_cost' => $this->input->post('final_assessment_cost')
			);
			// Save data using the model
			$insert_id = $this->accident_model->save_accident_data($data);
			if ($insert_id) {
				$result = array("type" => 'success', "message" => 'Accident detail successfully added.');
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found, try again');
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
			return $error;
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
				$emp_id = $data['accident_detail']['employee_id'];
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.iqama_no, me.status, me.nationality, me.employee_pic, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) WHERE me.status = 'active' AND me.id='" . $emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
			} else {
				$this->session->set_userdata('info', "2--Accident detail not found, try again!");
			}
			return $this->load->view('admin/hr-module/accidents/edit', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request!");
			redirect('admin/hr/accidents');
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('employee_id', 'Employee Detail', 'trim|required');
		// $this->form_validation->set_rules('vehicle_id', 'Vehicle Detail', 'trim|required');
		// $this->form_validation->set_rules('insurance_provider', 'Insurance Service Provider', 'trim|required');
		// $this->form_validation->set_rules('ins_policy_no', 'Insurance Policy Number', 'trim|required');
		// $this->form_validation->set_rules('ins_start_date', 'Insurance Start Date', 'trim|required');
		// $this->form_validation->set_rules('ins_end_date', 'Insurance End Date', 'trim|required');
		// $this->form_validation->set_rules('ins_status', 'Insurance Status', 'trim|required');
		$this->form_validation->set_rules('accident_date', 'Accident Date', 'trim|required');
		$this->form_validation->set_rules('accident_attended_by', 'Accident Attended By', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if (isset($_FILES['attach_hhdr_report']) && !empty($_FILES['attach_hhdr_report']['name'])) {
				$upload_hhdr_report = $this->upload_file('attach_hhdr_report');
			} else {
				$upload_hhdr_report = $this->input->post('old_attach_hhdr_report');
			}
			if (isset($_FILES['attach_da_final_report']) && !empty($_FILES['attach_da_final_report']['name'])) {
				$upload_da_final_report = $this->upload_file('attach_da_final_report');
			} else {
				$upload_da_final_report = $this->input->post('old_attach_da_final_report');
			}
			if (isset($_FILES['attach_ld_report']) && !empty($_FILES['attach_ld_report']['name'])) {
				$upload_ld_report = $this->upload_file('attach_ld_report');
			} else {
				$upload_ld_report = $this->input->post('old_attach_ld_report');
			}
			if (isset($_FILES['attach_maroor_report']) && !empty($_FILES['attach_maroor_report']['name'])) {
				$upload_maroor_report = $this->upload_file('attach_maroor_report');
			} else {
				$upload_maroor_report = $this->input->post('old_attach_maroor_report');
			}
			$id = $this->input->post('id');
			$data = array(
				'employee_id' => $this->input->post('employee_id'),
				'vehicle_id' => $this->input->post('vehicle_id'),
				'insurance_provider' => $this->input->post('insurance_provider'),
				'ins_policy_no' => $this->input->post('ins_policy_no'),
				'ins_start_date' => $this->input->post('ins_start_date'),
				'ins_end_date' => $this->input->post('ins_end_date'),
				'ins_status' => $this->input->post('ins_status'),
				'accident_date' => $this->input->post('accident_date'),
				'accident_attended_by' => $this->input->post('accident_attended_by'),
				'hhdr_report_no' => $this->input->post('hhdr_report_no'),
				'attach_hhdr_report' => $upload_hhdr_report,
				'da_final_report_no' => $this->input->post('da_final_report_no'),
				'attach_da_final_report' => $upload_da_final_report,
				'ld_report_no' => $this->input->post('ld_report_no'),
				'attach_ld_report' => $upload_ld_report,
				'employee_liability_perc' => $this->input->post('employee_liability_perc'),
				'maroor_report_no' => $this->input->post('maroor_report_no'),
				'attach_maroor_report' => $upload_maroor_report,
				'taqdeer_inspection_date' => $this->input->post('taqdeer_inspection_date'),
				'taqdeer_da_fees' => $this->input->post('taqdeer_da_fees'),
				'insurance_claim_fees' => $this->input->post('insurance_claim_fees'),
				'other_cost' => $this->input->post('other_cost'),
				'final_assessment_cost' => $this->input->post('final_assessment_cost')
			);
			// Save data using the model
			$updated = $this->accident_model->update_accident_data($id, $data);
			if ($updated) {
				$this->session->set_userdata('info', "1--Accident detail successfully updated.");
			} else {
				$this->session->set_userdata('info', "2--Accident detail not updated.");
			}
		}
		redirect('admin/hr/accidents/edit/' . $id);
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
				$emp_id = $data['accident_detail']['employee_id'];
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.iqama_no, me.status, me.nationality, me.employee_pic, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) WHERE me.status = 'active' AND me.id='" . $emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
			} else {
				$this->session->set_userdata('info', "2--Accident detail not found, try again!");
			}
			return $this->load->view('admin/hr-module/accidents/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid request!");
			redirect('admin/hr/accidents');
		}
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
			$sub_array[] = ((isset($item->accident_date)) ? date('d-m-Y', strtotime($item->accident_date)) : '');
			$sub_array[] = (isset($item->employee_liability_perc)) ? $item->employee_liability_perc . '%' : 'NA';
			$sub_array[] = $item->insurance_claim_fees;
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			$sub_array[] = (check_action_permission(get_user_role(), 'accident_list', 'edit') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/accidents/edit/' . $item->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'accident_list', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/accidents/detail/' . $item->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');

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
		redirect('admin/hr/accidents');
	}
}
