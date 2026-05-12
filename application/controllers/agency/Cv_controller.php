<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cv_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->agency->isLogged()){
			$this->load->model('agency/Cv_model');
			$this->load->model('agency/Profile_model');
			$this->load->model('admin/Edu_model');
			$this->load->model('admin/Job_title_model');
			$this->load->model('admin/masters/City_model');
			$this->load->model('admin/hr/master/Nationality_model');
			$this->load->model('admin/hr/master/Department_model');
			$this->load->library('form_validation');
			$this->load->helper('cookie');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->library('session');
			$this->load->helper('Common_helper');
		} else{
			redirect("hiring-agency/login");
		}
	}

	public function index()
	{
		if ($this->agency->getInfo()){
			$info = explode('--', $this->agency->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['positions'] = $this->Job_title_model->get_list();
		//print_r($data['reports']);exit();
		$this->load->view('agency/pages/cv/index',$data);
	}

	public function add_cv(){
		$data['id'] = "";
		$data['cv_no'] = "";
		$data['hiring_type'] = "";
		$data['applicant_country'] = "";
		$data['agency_name'] = "";
		$data['applicant_type'] = "";
		$data['applied_for'] = "";
		$data['first_name'] = "";
		$data['middle_name'] = "";
		$data['third_name'] = "";
		$data['surname'] = "";
		$data['candidate_arabic_name'] = "";
		$data['dob'] = "";
		$data['age'] = "";
		$data['age_remarks'] = "";
		$data['gender'] = "";
		$data['marital_status'] = "";
		$data['nationality'] = "";
		$data['mobile'] = "";
		$data['email'] = "";
		$data['imo_available'] = "";
		
		$data['passport_no'] = "";
		$data['passport_exp'] = "";
		$data['passport_issue_country'] = "";
		$data['passport_issue_city'] = "";
		$data['dl_no'] = "";
		$data['dl_available'] = "";
		$data['dl_expiry'] = "";
		
		$data['interviewer'] = "";
		$data['interview_date'] ="";
		$data['interview_status'] = "";
		$data['rejection_reason'] = "";
		$data['cv_status'] = "";
		
		$data['iqama_no'] = "";
		$data['iqama_exp'] = "";
		
		$data['iqama_issue_country'] = "";
		$data['iqama_issue_city'] = "";
		$data['saudi_dl_available'] = "";
		$data['dl_type'] = "";
		$data['current_dl'] = "";
		$data['current_dl_expiry'] = "";

		$data['documents'] = array();
		$data['positions'] = $this->Job_title_model->get_list();
		$data['cities'] = $this->City_model->get_cities()->result();
		$data['nationalities'] = $this->Nationality_model->get_data();
		$data['agency_info'] = $this->Profile_model->profile();
		$data['cv_id'] = $this->db->query("SELECT id FROM master_cv ORDER BY id desc limit 1")->row();
		// print_r($data['cv_no']);exit();
		$this->load->view('agency/pages/cv/form',$data);
	}

	public function save_cv(){
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
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('imo_available', 'Imo Available', 'trim|required');
		$this->form_validation->set_rules('passport_issue_country', 'Passport Issue Country', 'trim|required');
		$this->form_validation->set_rules('passport_issue_city', 'Passport Issue City', 'trim|required');
		$this->form_validation->set_rules('passport_exp', 'Passport Expiry Date', 'trim|required');
		$this->form_validation->set_rules('passport_no', 'Passport Number', 'trim|required|callback_check_passport_duplicate');
		$this->form_validation->set_message('check_passport_duplicate','Passport Number already registered, Try new');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('msg_info', "2--".validation_errors());
		}
		else{
    		$query = $this->Cv_model->add();
    		if($query){
				$this->session->set_userdata('msg_info', "1--Successfully submitted");
			}
			else{
				$this->session->set_userdata('msg_info', "2--Error!!!");
			}
		}
		redirect('hiring-agency/cv/list');
	}

	public function check_passport_duplicate() {
		$id = $this->input->post('id');
		$passport_no = $this->input->post('passport_no');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Cv_model->check_duplicate_passport($id, $passport_no);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function cv_detail(){
		if($this->input->get('id')){
			$query = $this->Cv_model->get_detail($this->input->get('id'));
			if(!empty($query)){
				$data['id'] = $query->id;
				$data['cv_no'] = $query->cv_no;
				$data['hiring_type'] = $query->hiring_type;
				$data['applicant_country'] = $query->applicant_country;
				$data['agency_name'] = $query->agency_name;
				$data['applicant_type'] = $query->applicant_type;
				$data['applied_for'] = $query->applied_for;
				$data['first_name'] = $query->first_name;
				$data['middle_name'] = $query->middle_name;
				$data['third_name'] = $query->third_name;
				$data['surname'] = $query->surname;
				$data['candidate_arabic_name'] = $query->candidate_arabic_name;
				$data['dob'] = $query->dob;
				$data['age'] = $query->age;
				$data['age_remarks'] = $query->age_remarks;
				$data['gender'] = $query->gender;
				$data['marital_status'] = $query->marital_status;
				$data['nationality'] = $query->nationality;
				$data['mobile'] = $query->mobile;
				$data['email'] = $query->email;
				$data['imo_available'] = $query->imo_available;
				
				$data['interviewer'] = $query->interviewer;
				$data['interview_date'] = $query->interview_date;
				$data['interview_status'] = $query->interview_status;
				$data['rejection_reason'] = $query->rejection_reason;
				$data['cv_status'] = $query->cv_status;
				$data['passport_no'] = $query->passport_no;
				$data['passport_exp'] = $query->passport_exp;
				$data['passport_issue_country'] = $query->passport_issue_country;
				$data['passport_issue_city'] = $query->passport_issue_city;
				$data['dl_available'] = $query->dl_available;
				$data['dl_no'] = $query->dl_no;
				$data['dl_expiry'] = $query->dl_expiry;

				$data['iqama_no'] = $query->iqama_no;
				$data['iqama_exp'] = $query->iqama_exp;
				
				$data['iqama_issue_country'] = $query->iqama_issue_country;
				$data['iqama_issue_city'] = $query->iqama_issue_city;
				$data['saudi_dl_available'] = $query->saudi_dl_available;
				$data['dl_type'] = $query->dl_type;
				$data['current_dl'] = $query->current_dl;
				$data['current_dl_expiry'] = $query->current_dl_expiry;

				$data['documents'] = $this->Cv_model->get_cv_docs($this->input->get('id'));
				$data['positions'] = $this->Job_title_model->get_list();
				$data['cities'] = $this->City_model->get_cities()->result();
				$data['nationalities'] = $this->Nationality_model->get_data();
				$data['agency_info'] = $this->Profile_model->profile();
				$this->load->view('agency/pages/cv/detail',$data);
			}else{
				$this->session->set_userdata('msg_info', "2--Invalid request or unauthorized access!");
				redirect('hiring-agency/cv/list');
			}
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('hiring-agency/cv/list');
		}
	}

	public function get_cv_list(){
		$fetch_data = $this->Cv_model->get_list();
		//print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $cv){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $cv->cv_no;
			$sub_array[] = ucfirst($cv->applicant_type);
			$sub_array[] = (($cv->first_name !=='') ? $cv->first_name : ''). (($cv->middle_name !=='') ? ' '.$cv->middle_name : ''). (($cv->third_name !=='') ? ' '.$cv->third_name : ''). (($cv->surname !=='') ? ' '.$cv->surname : '');
			$sub_array[] = $cv->applicant_country;
			$sub_array[] = $cv->age;
			$sub_array[] = $cv->passport_no;
			$sub_array[] = date('d-m-Y', strtotime($cv->passport_exp));
			$sub_array[] = $cv->pos_name;
			if($cv->cv_status == 'new'){
				$cv_status = '<span class="badge badge-pill badge-soft-info font-size-13">New</span>';
			}elseif($cv->cv_status == 'shortlisted'){
				$cv_status = '<span class="badge badge-pill badge-soft-success font-size-13">Shortlisted</span>';
			}elseif($cv->cv_status == 'not_qualified'){
				$cv_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Not Qualified</span>';
			}else{
				$cv_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $cv_status;
			if($cv->interview_status == 'selected'){
				$int_status = '<span class="badge badge-pill badge-soft-success font-size-13">Selected</span>';
			}elseif($cv->interview_status == 'rejected'){
				$int_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>';
			}else{
				$int_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $int_status;
			$sub_array[] = ($cv->medical_status == '') ? 'NA' : ucfirst($cv->medical_status);
			
			
			$sub_array[] = date('d-m-Y', strtotime($cv->created_at));
			if($cv->cv_status == 'new'){
				$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			}elseif($cv->interview_status == 'selected' && $cv->offer_letter_status == 'pending'){
				$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a> 
				<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit upload-certificates" title="Offer Letter" data-id="'. $cv->id .'" data-type="offer_letter" onclick="uploadCertificate(this)"><i class="mdi mdi-file-document-edit-outline font-size-18"></i></button>';
			}elseif($cv->interview_status == 'selected' && $cv->offer_letter_status == 'accepted' && $cv->medical_status == 'pending'){
				$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
				<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit upload-certificates" title="Medical Certificate" data-id="'. $cv->id .'" data-type="medical" onclick="uploadCertificate(this)"><i class="fas fa-file-medical-alt font-size-18"></i></button>';
			}elseif($cv->interview_status == 'selected' && $cv->medical_status == 'accepted' && $cv->offer_letter_status == 'accepted' && $cv->visa_status == 'pending'){
				$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
				<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit upload-certificates" title="Visa Copy" data-id="'. $cv->id .'" data-type="visa" onclick="uploadCertificate(this)"><i class="mdi mdi-card-account-details-star font-size-18"></i></button>';
			}elseif($cv->interview_status == 'selected' && $cv->medical_status == 'accepted' && $cv->offer_letter_status == 'accepted' && $cv->visa_status == 'accepted' && $cv->arrival_status == '0'){
				$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
				<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit upload-certificates" title="Ticket" data-id="'. $cv->id .'" data-type="ticket" onclick="uploadCertificate(this)"><i class="mdi mdi-ticket-confirmation-outline font-size-18"></i></button>';
			}else{
				$tools = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			}
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

	//Filters Cv's

	public function filter_cv()
	{
		if ($this->agency->getInfo()){
			$info = explode('--', $this->agency->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['page_name'] = $this->uri->segment(4);
		//print_r($data['reports']);exit();
		$this->load->view('agency/pages/cv/filter-cv',$data);
	}

	public function filter_cv_ajax(){
		$page_name = $this->uri->segment(4);
		$fetch_data = $this->Cv_model->get_filter_list($page_name);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $cv){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $cv->cv_no;
			$sub_array[] = ucfirst($cv->hiring_type);
			$sub_array[] = (($cv->first_name !=='') ? $cv->first_name : ''). (($cv->middle_name !=='') ? ' '.$cv->middle_name : ''). (($cv->third_name !=='') ? ' '.$cv->third_name : ''). (($cv->surname !=='') ? ' '.$cv->surname : '');
			$sub_array[] = $cv->applicant_country;
			$sub_array[] = $cv->age;
			$sub_array[] = $cv->passport_no;
			$sub_array[] = date('d-m-Y', strtotime($cv->passport_exp));
			$sub_array[] = $cv->pos_name;
			if($cv->cv_status == 'new'){
				$cv_status = '<span class="badge badge-pill badge-soft-info font-size-13">New</span>';
			}elseif($cv->cv_status == 'shortlisted'){
				$cv_status = '<span class="badge badge-pill badge-soft-success font-size-13">Shortlisted</span>';
			}elseif($cv->cv_status == 'not_qualified'){
				$cv_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Not Qualified</span>';
			}else{
				$cv_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $cv_status;
			if($cv->interview_status == 'selected'){
				$int_status = '<span class="badge badge-pill badge-soft-success font-size-13">Selected</span>';
			}elseif($cv->interview_status == 'rejected'){
				$int_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>';
			}else{
				$int_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $int_status;
			$sub_array[] = ($cv->medical_status == '') ? 'NA' : $cv->medical_status;
			
			$sub_array[] = date('d-m-Y', strtotime($cv->created_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'hiring-agency/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Cv_model->get_filter_all_data(),  
			"recordsFiltered"     =>     $this->Cv_model->get_filter_cv_data($page_name),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	//Upload Certificates
	public function upload_certificate_form()
    {
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';exit();
		}
		else{
			$query = $this->db->query("SELECT * FROM master_cv WHERE id = '". $this->input->post('id') ."' AND agency_name = '". (int)$this->agency->getId() ."'");
			if($query->num_rows() > 0){
				$cv_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['type'] = $this->input->post('type');
				$data['name'] = (($cv_info->first_name !=='') ? $cv_info->first_name : ''). (($cv_info->middle_name !=='') ? ' '.$cv_info->middle_name : ''). (($cv_info->third_name !=='') ? ' '.$cv_info->third_name : ''). (($cv_info->surname !=='') ? ' '.$cv_info->surname : '');
				if($data['type'] == 'medical'){
					$output_data = $this->load->view('agency/partials/upload-medical',$data,TRUE);
				}elseif($data['type'] == 'visa'){
					$output_data = $this->load->view('agency/partials/upload-visa',$data,TRUE);
				}elseif($data['type'] == 'ticket'){
					$output_data = $this->load->view('agency/partials/upload-ticket',$data,TRUE);
				}elseif($data['type'] == 'offer_letter'){
					$output_data = $this->load->view('agency/partials/upload-offer-letter',$data,TRUE);
				}
				echo $output_data;
			}else{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';exit();
			}
		}
    }

	public function upload_medical_certificate()
    {
		$this->form_validation->set_rules('cv_id', 'ID', 'trim|required');
		$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required');
		if(empty($_FILES['attachments']['name']))
		{
			$this->form_validation->set_rules('attachments[]', 'attachment', 'required');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('msg_info', "2--".validation_errors());
		}
		else{
			$query = $this->db->query("SELECT * FROM master_cv WHERE id = '". $this->input->post('cv_id') ."' AND agency_name = '". (int)$this->agency->getId() ."'");
			if($query->num_rows() > 0){
				$query = $this->Cv_model->uploadMedicalCertificate();
				if($query){
					$this->session->set_userdata('msg_info', "1--Successfully updated");
				}else{
					$this->session->set_userdata('msg_info', "2--Something went wrong, try again");
				}
			}else{
				$this->session->set_userdata('msg_info', "2--Unauthorized request");
			}
		}
		redirect('hiring-agency/cv/list');
    }

	public function upload_certificate()
    {
		$this->form_validation->set_rules('cv_id', 'ID', 'trim|required');
		$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required');
		if(empty($_FILES['attachments']['name']))
		{
			$this->form_validation->set_rules('attachments[]', 'attachment', 'required');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('msg_info', "2--".validation_errors());
		}
		else{
			$query = $this->db->query("SELECT * FROM master_cv WHERE id = '". $this->input->post('cv_id') ."' AND agency_name = '". (int)$this->agency->getId() ."'");
			if($query->num_rows() > 0){
				$query = $this->Cv_model->uploadCertificate();
				if($query){
					$this->session->set_userdata('msg_info', "1--Successfully updated");
				}else{
					$this->session->set_userdata('msg_info', "2--Something went wrong, try again");
				}
			}else{
				$this->session->set_userdata('msg_info', "2--Unauthorized request");
			}
		}
		redirect('hiring-agency/cv/list');
    }
	/*
	public function delete_cv(){
		$ids = $this->input->post('checklist');
		$query = $this->Cv_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('agency/hr/recruitment/cv');
	}
	*/
	
	public function delete_image(){
		if($this->agency->isLogged()){
			$this->form_validation->set_rules('cv_id', 'CV ID', 'trim|required');
			$this->form_validation->set_rules('img_id', 'Image ID', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$data = array("type"=>'error', "message"=>'Invalid Request Type');
			}
			else{
				$query = $this->Cv_model->delete_image();
				if($query){
					$data = array("type"=>'success', "message"=>'Image successfully deleted');
				}
				else{
					$data = array("type"=>'error', "message"=>'Something went wrong, Try again');
				}
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
	}
}
