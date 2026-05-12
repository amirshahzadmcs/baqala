<?php defined('BASEPATH') or exit('No direct script access allowed');

class Cv_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Cv_model');
			$this->load->model('admin/Edu_model');
			$this->load->model('admin/Job_title_model');
			$this->load->model('admin/masters/City_model');
			$this->load->model('admin/hr/master/Nationality_model');
			$this->load->model('admin/hr/master/Department_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index_cv()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
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
		$data['positions'] = allDesignation();
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/recruitment/cv/index', $data);
	}

	public function add_cv()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['positions'] = allDesignation();
		$data['educations'] = $this->Edu_model->get_list();
		$data['cities'] = $this->City_model->get_cities()->result();
		$data['departments'] = $this->Department_model->get_data();
		$data['nationalities'] = $this->Nationality_model->get_data();
		$data['borders_list'] = $this->Cv_model->get_borders_list();
		$data['cv_id'] = $this->db->query("SELECT id FROM master_cv ORDER BY id desc limit 1")->row();
		// print_r($data['cv_no']);exit();
		$this->load->view('admin/hr/recruitment/cv/form', $data);
	}

	public function edit_cv()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data['cv_detail'] = $this->Cv_model->get_detail($this->input->get('id'));
			if (!empty($data['cv_detail'])) {
				$data['documents'] = $this->Cv_model->get_cv_docs($this->input->get('id'));
				$data['families'] = $this->Cv_model->get_cv_families($this->input->get('id'));
				$data['backoffice_package'] = $this->Cv_model->get_backoffice_package($this->input->get('id'));
				$data['positions'] = allDesignation();
				$data['educations'] = $this->Edu_model->get_list();
				$data['cities'] = $this->City_model->get_cities()->result();
				$data['departments'] = $this->Department_model->get_data();
				$data['nationalities'] = $this->Nationality_model->get_data();
				$data['borders_list'] = $this->Cv_model->get_borders_list();
				//echo '<pre>';print_r($data);exit();
				return $this->load->view('admin/hr/recruitment/cv/edit', $data);
			} else {
				$this->session->set_userdata('info', "2--Cv not found!");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function save_cv()
	{
		$this->form_validation->set_rules('cv_no', 'CV Number', 'trim|required');
		$this->form_validation->set_rules('hiring_type', 'Hiring Type', 'trim|required');
		$this->form_validation->set_rules('applicant_country', 'Applicant Country', 'trim|required');
		$this->form_validation->set_rules('applicant_type', 'Applicant Type', 'trim|required');
		$this->form_validation->set_rules('applied_for', 'Applied For', 'trim|required');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('candidate_arabic_name', 'Candidate Arabic Name', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('age', 'Age', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('imo_available', 'Imo Available', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('passport_issue_country', 'Passport Issue Country', 'trim|required');
		$this->form_validation->set_rules('passport_issue_city', 'Passport Issue City', 'trim|required');
		$this->form_validation->set_rules('passport_exp', 'Passport Expiry Date', 'trim|required');
		$this->form_validation->set_rules('passport_no', 'Passport Number', 'trim|required|callback_check_passport_duplicate');
		$this->form_validation->set_message('check_passport_duplicate', 'Passport Number already registered, Try new');
		if ($this->input->post('border_entry_no')) {
			$this->form_validation->set_rules('border_entry_no', 'Border Entry Number', 'required|callback_check_border_entry');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Cv_model->add();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully added");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, try again!");
			}
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function update_cv()
	{
		$this->form_validation->set_rules('id', 'CV ID', 'trim|required');
		$this->form_validation->set_rules('cv_no', 'CV Number', 'trim|required');
		$this->form_validation->set_rules('hiring_type', 'Hiring Type', 'trim|required');
		$this->form_validation->set_rules('applicant_country', 'Applicant Country', 'trim|required');
		$this->form_validation->set_rules('applicant_type', 'Applicant Type', 'trim|required');
		$this->form_validation->set_rules('applied_for', 'Applied For', 'trim|required');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('candidate_arabic_name', 'Candidate Arabic Name', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('age', 'Age', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('imo_available', 'Imo Available', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('passport_issue_country', 'Passport Issue Country', 'trim|required');
		$this->form_validation->set_rules('passport_issue_city', 'Passport Issue City', 'trim|required');
		$this->form_validation->set_rules('passport_exp', 'Passport Expiry Date', 'trim|required');
		$this->form_validation->set_rules('passport_no', 'Passport Number', 'trim|required|callback_check_passport_duplicate');
		$this->form_validation->set_message('check_passport_duplicate', 'Passport Number already registered, Try new');
		if ($this->input->post('border_entry_no')) {
			$this->form_validation->set_rules('border_entry_no', 'Border Entry Number', 'required|callback_check_border_entry');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$id = $this->input->post('id');
				$query = $this->Cv_model->edit();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
				redirect('admin/hr/recruitment/cv/edit?id=' . $id);
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function check_passport_duplicate()
	{
		$id = $this->input->post('id');
		$passport_no = $this->input->post('passport_no');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Cv_model->check_duplicate_passport($id, $passport_no);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function ajax_check_passport()
	{
		$passport_no = $this->input->post('passport_no');
		$id = $this->input->post('id');
		if ($passport_no !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Cv_model->check_duplicate_passport($id, $passport_no);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $passport_no . "</b> This passport already used. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Passport Checked.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Passport is required.</span>";
		}
		echo json_encode($data);
	}

	public function check_border_entry()
	{
		$id = $this->input->post('id');
		$border_entry_no = $this->input->post('border_entry_no');
		$this->db->where('border_entry_no', $border_entry_no);
		$this->db->where('id !=', $id);
		$query = $this->db->get('master_cv');
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('check_border_entry', 'This border entry has already been issued.');
			return FALSE;
		} else {
			return true;
		}
	}

	public function ajax_check_border_entry()
	{
		$this->form_validation->set_rules('id', 'CV ID', 'trim|required');
		$this->form_validation->set_rules('border_entry_no', 'Border Number', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array(
				'type' => 'error',
				'message' => validation_errors()
			);
			echo json_encode($result);
			return;
		} else {
			$id = $this->input->post('id');
			$border_entry_no = $this->input->post('border_entry_no');
			$this->db->where('border_entry_no', $border_entry_no);
			$this->db->where('id !=', $id);
			$query = $this->db->get('master_cv');
			if ($query->num_rows() > 0) {
				$result = array(
					'type' => 'error',
					'message' => 'This border entry has already been issued. Try New'
				);
				echo json_encode($result);
				return;
			} else {
				$result = array(
					'type' => 'success',
					'message' => ''
				);
				echo json_encode($result);
				return;
			}
		}
	}

	public function cv_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$data['cv_detail'] = $this->Cv_model->get_detail($this->input->get('id'));
			if (!empty($data['cv_detail'])) {
				$data['documents'] = $this->Cv_model->get_cv_docs($this->input->get('id'));
				$data['families'] = $this->Cv_model->get_cv_families($this->input->get('id'));
				$data['backoffice_package'] = $this->Cv_model->get_backoffice_package($this->input->get('id'));
				$data['positions'] = allDesignation();
				$data['educations'] = $this->Edu_model->get_list();
				$data['cities'] = $this->City_model->get_cities()->result();
				$data['departments'] = $this->Department_model->get_data();
				$data['nationalities'] = $this->Nationality_model->get_data();
				//echo '<pre>';print_r($data);exit();
				return $this->load->view('admin/hr/recruitment/cv/detail', $data);
			} else {
				$this->session->set_userdata('info', "2--Invalid request or unauthorized access!");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function get_cv_list()
	{
		$fetch_data = $this->Cv_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $cv) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $cv->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $cv->cv_no;
			$sub_array[] = (($cv->first_name !== '') ? $cv->first_name : '') . (($cv->middle_name !== '') ? ' ' . $cv->middle_name : '') . (($cv->third_name !== '') ? ' ' . $cv->third_name : '') . (($cv->surname !== '') ? ' ' . $cv->surname : '');
			$sub_array[] = $cv->nationality;
			$age = age_calculate($cv->dob);
			if ($age > 35) {
				$sub_array[] = "<span style='color: red;font-weight:700;'>$age</span>";
			} else {
				$sub_array[] = "<span>$age</span>";
			}
			$sub_array[] = $cv->passport_no;
			$sub_array[] = $cv->pos_name;
			$sub_array[] = $cv->hiring_agency_name;
			$sub_array[] = $cv->sponsor_id;
			$sub_array[] = $cv->border_entry_no;
			$sub_array[] = (isset($cv->arrival_date) && $cv->arrival_date !== '0000-00-00') ? date('d-m-Y', strtotime($cv->arrival_date)) : 'NA';
			if ($cv->cv_status == 'new') {
				$cv_status = '<span class="badge badge-pill badge-soft-info font-size-13">New</span>';
			} elseif ($cv->cv_status == 'shortlisted') {
				$cv_status = '<span class="badge badge-pill badge-soft-success font-size-13">Shortlisted</span>';
			} elseif ($cv->cv_status == 'not_qualified') {
				$cv_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Not Qualified</span>';
			} else {
				$cv_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $cv_status;

			if ($cv->interview_status == 'selected') {
				$int_status = '<span class="badge badge-pill badge-soft-success font-size-13">Selected</span>';
			} elseif ($cv->interview_status == 'rejected') {
				$int_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>';
			} else {
				$int_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $int_status;

			if ($cv->offer_letter_status == 'accepted') {
				$arrival_status = '<span class="fas fa-check-circle text-success font-size-24"></span>';
			} elseif ($cv->arrival_status == 'rejected') {
				$arrival_status = '<span class="fas fa-times-circle text-danger font-size-24">Cancelled</span>';
			} else {
				$arrival_status = 'NA';
			}
			$sub_array[] = '<div class="text-center">' . $arrival_status . '</div>';

			if ($cv->deployment_status == 'arrived') {
				$arrival_status = '<span class="badge badge-pill badge-soft-success font-size-13">Arrived</span>';
			} elseif ($cv->arrival_status == 'cancelled') {
				$arrival_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Cancelled</span>';
			} else {
				$arrival_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $arrival_status;

			$sub_array[] = date('d-m-Y', strtotime($cv->created_at));
			if ($cv->cv_status == 'new') {
				$tools = (check_action_permission(get_user_role(), 'manage_cv', 'edit_cv') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/recruitment/cv/edit?id=' . $cv->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> ' : '') . (check_action_permission(get_user_role(), 'manage_cv', 'cv_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/recruitment/cv/detail?id=' . $cv->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			} elseif ($cv->interview_status == 'selected' && $cv->offer_letter_status == 'pending') {
				$tools = (check_action_permission(get_user_role(), 'manage_cv', 'edit_cv') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/recruitment/cv/edit?id=' . $cv->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> ' : '') .
					(check_action_permission(get_user_role(), 'manage_cv', 'cv_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/recruitment/cv/detail?id=' . $cv->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'manage_cv', 'upload_certificate_form') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit upload-certificates" title="Offer Letter" data-id="' . $cv->id . '" data-type="offer_letter" onclick="uploadCertificate(this)"><i class="mdi mdi-file-document-edit-outline font-size-18"></i></button>' : '');
			} else {
				$tools = (check_action_permission(get_user_role(), 'manage_cv', 'edit_cv') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/recruitment/cv/edit?id=' . $cv->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '')
					. (check_action_permission(get_user_role(), 'manage_cv', 'cv_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/recruitment/cv/detail?id=' . $cv->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			}
			// if ($cv->cv_status == 'new') {
			// 	$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/recruitment/cv/edit?id=' . $cv->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> 
			// 	<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/recruitment/cv/detail?id=' . $cv->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			// } elseif ($cv->interview_status == 'selected' && $cv->offer_letter_status == 'pending') {
			// 	$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/recruitment/cv/edit?id=' . $cv->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> 
			// 	<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/recruitment/cv/detail?id=' . $cv->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a> 
			// 	<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit upload-certificates" title="Offer Letter" data-id="' . $cv->id . '" data-type="offer_letter" onclick="uploadCertificate(this)"><i class="mdi mdi-file-document-edit-outline font-size-18"></i></button>';
			// } else {
			// 	$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/recruitment/cv/edit?id=' . $cv->id . '"><i class="mdi mdi-pencil font-size-18"></i></a> 
			// 	<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/hr/recruitment/cv/detail?id=' . $cv->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			// }
			$sub_array[] = $tools;

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Cv_model->get_all_data(),
			"recordsFiltered"     =>     $this->Cv_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete_cv()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Cv_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function getAgency()
	{
		$country_id = $this->input->post('country_id');
		$data = agencyCountrywiseHelper($country_id);
		echo json_encode($data);
	}

	public function getDesignation()
	{
		$hiring_type = $this->input->post('hiring_type');
		if ($hiring_type == 'Rider') {
			$position_type = 1;
		} else {
			$position_type = 0;
		}
		$data = $this->Cv_model->cv_designations($position_type);
		echo json_encode($data);
	}

	/*--- New ----*/
	//Upload Certificates

	public function upload_certificate_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_cv', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';
			exit();
		} else {
			$query = $this->db->query("SELECT * FROM master_cv WHERE id = '" . $this->input->post('id') . "'");
			if ($query->num_rows() > 0) {
				$cv_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['type'] = $this->input->post('type');
				$data['name'] = (($cv_info->first_name !== '') ? $cv_info->first_name : '') . (($cv_info->middle_name !== '') ? ' ' . $cv_info->middle_name : '') . (($cv_info->third_name !== '') ? ' ' . $cv_info->third_name : '') . (($cv_info->surname !== '') ? ' ' . $cv_info->surname : '');
				if ($data['type'] == 'medical') {
					$output_data = $this->load->view('admin/partials/upload-medical', $data, TRUE);
				} elseif ($data['type'] == 'visa') {
					$output_data = $this->load->view('admin/partials/upload-visa', $data, TRUE);
				} elseif ($data['type'] == 'ticket') {
					$output_data = $this->load->view('admin/partials/upload-ticket', $data, TRUE);
				} elseif ($data['type'] == 'offer_letter') {
					$output_data = $this->load->view('admin/partials/upload-offer-letter', $data, TRUE);
				}
				echo $output_data;
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';
				exit();
			}
		}
	}

	public function upload_medical_certificate()
	{
		$this->form_validation->set_rules('cv_id', 'ID', 'trim|required');
		$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required');
		$this->form_validation->set_rules('medical_status', 'Medical Status', 'trim|required');
		if (empty($_FILES['attachments']['name'])) {
			$this->form_validation->set_rules('attachments[]', 'attachment', 'required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->db->query("SELECT * FROM master_cv WHERE id = '" . $this->input->post('cv_id') . "'");
			if ($query->num_rows() > 0) {
				$query = $this->Cv_model->uploadMedicalCertificate();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, try again");
				}
			} else {
				$this->session->set_userdata('info', "2--Unauthorized request");
			}
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function upload_certificate()
	{
		$this->form_validation->set_rules('cv_id', 'ID', 'trim|required');
		$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required');
		if (empty($_FILES['attachments']['name'])) {
			$this->form_validation->set_rules('attachments[]', 'attachment', 'required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->db->query("SELECT * FROM master_cv WHERE id = '" . $this->input->post('cv_id') . "'");
			if ($query->num_rows() > 0) {
				$query = $this->Cv_model->uploadCertificate();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, try again");
				}
			} else {
				$this->session->set_userdata('info', "2--Unauthorized request");
			}
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function delete_image()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('cv_id', 'CV ID', 'trim|required');
			$this->form_validation->set_rules('img_id', 'Image ID', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array("type" => 'error', "message" => 'Invalid Request Type');
			} else {
				$query = $this->Cv_model->delete_image();
				if ($query) {
					$data = array("type" => 'success', "message" => 'Image successfully deleted');
				} else {
					$data = array("type" => 'error', "message" => 'Something went wrong, Try again');
				}
			}
		} else {
			$data = array("type" => 'error', "message" => 'Session expired, Please login again. <a href="' . base_url('admin') . '" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
	}

	public function print_offer_letter()
	{
		$this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$data['cv_detail'] = $this->Cv_model->get_detail($id);

		if ($data['cv_detail'] !== '') {
			$package_id = $data['cv_detail']->rider_package_id;
			if ($package_id > 0) {
				$data['package_detail'] = salaryPackageDetail($package_id);
				// print_r($order);exit();
				// create new PDF document
				$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Offer Letter');
				$pdf->SetSubject('BS - Offer Letter');
				$pdf->SetKeywords('Baqala Station, PDF, Offer Letter, Employee');

				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);

				$lastFooter = '';
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
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print_offer_letter', $data, true);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('BS Offer Letter - ' . $data['cv_detail']->cv_no . '.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--First add salary package of rider.");
				redirect('admin/hr/recruitment/cv/detail?id=' . $data['cv_detail']->id);
			}
		} else {
			$this->session->set_userdata('info', "2--CV detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	public function print_security_letter()
	{
		$this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$data['cv_detail'] = $this->Cv_model->get_detail($id);
		$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		//print_r($data['cv_detail']);exit();
		if ($data['cv_detail'] !== '') {
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Security Deposit Letter');
			$pdf->SetSubject('BS - Security Deposit Letter');
			$pdf->SetKeywords('Baqala Station, PDF, Security Deposit Letter, Employee');

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
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 12);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print_deposit_letter', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Security Deposit Letter - ' . $data['cv_detail']->cv_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--CV detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	public function print_dl_letter()
	{
		$this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$data['cv_detail'] = $this->Cv_model->get_detail($id);
		$data['print_date'] = date('d M, Y');
		//$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		//print_r($data['cv_detail']);exit();
		if ($data['cv_detail'] !== '') {
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Deduction for Saudi Driving License Expenses');
			$pdf->SetSubject('BS - Deduction for Saudi Driving License Expenses');
			$pdf->SetKeywords('Baqala Station, PDF, Deduction for Saudi Driving License Expenses, Employee');

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
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('aealarabiya', '', 10);
			$pdf->SetFont('dejavusans', '', 12);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print/print_driving_license_letter', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Deduction for Saudi Driving License Expenses - ' . $data['cv_detail']->cv_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--CV detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	//Back Office Offer Letter
	public function print_backoffice_offer()
	{
		$this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$data['cv_detail'] = $this->Cv_model->get_detail($id);

		if ($data['cv_detail'] !== '') {
			if ($data['cv_detail']->hiring_type == 'Back Office') {
				$data['package_detail'] = $this->Cv_model->get_backoffice_package($id);
			} else {
				$data['package_detail'] = '';
			}
			if ($data['package_detail'] !== '') {
				// print_r($order);exit();
				// create new PDF document
				$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Offer Letter');
				$pdf->SetSubject('BS - Offer Letter');
				$pdf->SetKeywords('Baqala Station, PDF, Offer Letter, Job Application');

				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);

				$lastFooter = '';
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
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print/job-offer-backoffice', $data, true);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('BS Offer Letter - ' . $data['cv_detail']->cv_no . '.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--Please complete offer letter information first.");
				redirect('admin/hr/recruitment/cv/detail?id=' . $data['cv_detail']->id);
			}
		} else {
			$this->session->set_userdata('info', "2--CV detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	public function print_promissory_note()
	{
		$this->load->library('Pdf_promissory_note');
		$id = $this->input->get('id');
		if ($id > 0) {
			$cv_detail = $this->Cv_model->get_detail($id);
			if (!empty($cv_detail)) {
				// print_r($order);exit();
				// create new PDF document
				$pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Rider Promissory Note');
				$pdf->SetSubject('BS - Rider Promissory Note');
				$pdf->SetKeywords('Baqala Station, PDF, Promissory Note, Rider');

				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);

				$lastFooter = '';
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
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetMargins(5, 60, 10, true);

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
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print/promissory_note', $cv_detail, true);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('BS Promissory Note ' . $cv_detail->cv_no . '.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--First complete cv information first.");
				redirect('admin/hr/recruitment/cv/detail?id=' . $id);
			}
		} else {
			$this->session->set_userdata('info', "2--CV detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	//Food Advance Request Form
	public function print_food_req_form()
	{
		$this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$data['cv_detail'] = $this->Cv_model->get_detail($id);
		if ($data['cv_detail'] !== '') {
			$package_id = $data['cv_detail']->rider_package_id;
			$data['package_detail'] = salaryPackageDetail($package_id);
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - New Arrival Food Advance Request Form');
			$pdf->SetSubject('BS - New Arrival Food Advance Request Form');
			$pdf->SetKeywords('Baqala Station, PDF, New Arrival Food Advance Request Form, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
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
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print/print_food_req_form', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			//$pdf->Output('New Arrival Food Advance Request Form - '. $data['emp_detail']->emp_no .'.pdf', 'I');
			$pdf->Output('NewArrivalFoodAdvanceRequestForm-' . $data['emp_detail']->emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	//Food Advance Request Form
	public function print_contract_form()
	{
		$this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$data['cv_detail'] = $this->Cv_model->get_detail($id);
		if ($data['cv_detail'] !== '') {
			$package_id = $data['cv_detail']->rider_package_id;
			$data['package_detail'] = salaryPackageDetail($package_id);
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Employment Contract');
			$pdf->SetSubject('BS - Employment Contract');
			$pdf->SetKeywords('Baqala Station, PDF, Employment Contract, Rider');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
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
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr/recruitment/cv/print/employement-contract', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			//$pdf->Output('New Arrival Food Advance Request Form - '. $data['emp_detail']->emp_no .'.pdf', 'I');
			$pdf->Output('EmployeeContractForm-' . $data['emp_detail']->emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/hr/recruitment/cv');
		}
	}
}
