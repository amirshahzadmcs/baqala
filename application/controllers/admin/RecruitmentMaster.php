<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RecruitmentMaster extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Cv_model');
			$this->load->model('admin/Loi_model');
			$this->load->model('admin/Loui_model');
			$this->load->model('admin/Cl_model');
			$this->load->model('admin/Edu_model');
			$this->load->model('admin/Job_title_model');
			$this->load->model('admin/City_model');
			$this->load->model('admin/hr/master/Nationality_model');
			$this->load->model('admin/hr/master/Department_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	// ------ Candidate CV

	public function index_cv()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/recruitment/cv/index',$data);
	}

	public function add_cv(){
		if($this->input->get('id')){
			$query = $this->Cv_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['cv_no'] = $query->cv_no;
			$data['hiring_type'] = $query->hiring_type;
			$data['applicant_country'] = $query->applicant_country;
			$data['agency_name'] = $query->agency_name;
			$data['applied_for'] = $query->applied_for;
			$data['first_name'] = $query->first_name;
			$data['middle_name'] = $query->middle_name;
			$data['third_name'] = $query->third_name;
			$data['surname'] = $query->surname;
			$data['dob'] = $query->dob;
			$data['gender'] = $query->gender;
			$data['marital_status'] = $query->marital_status;
			$data['mobile'] = $query->mobile;
			$data['email'] = $query->email;
			$data['f_name'] = $query->f_name;
			$data['father_mobile_no'] = $query->father_mobile_no;
			$data['m_name'] = $query->m_name;
			$data['mother_mob_no'] = $query->mother_mob_no;
			$data['spouse_name'] = $query->spouse_name;
			$data['spouse_mob_no'] = $query->spouse_mob_no;
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
			$data['current_dl'] = $query->current_dl;
			$data['current_dl_expiry'] = $query->current_dl_expiry;

			$data['address_1'] = $query->address_1;
			$data['address_2'] = $query->address_2;
			$data['address_3'] = $query->address_3;
			$data['area'] = $query->area;
			$data['city'] = $query->city;
			$data['state'] = $query->state;
			$data['country'] = $query->country;
			$data['postal_code'] = $query->postal_code;
			$data['emergency_no'] = $query->emergency_no;
		}
		else{
			$data['id'] = "";
			$data['cv_no'] = "";
			$data['hiring_type'] = "";
			$data['applicant_country'] = "";
			$data['agency_name'] = "";
			$data['applied_for'] = "";
			$data['first_name'] = "";
			$data['middle_name'] = "";
			$data['third_name'] = "";
			$data['surname'] = "";
			$data['dob'] = "";
			$data['gender'] = "";
			$data['marital_status'] = "";
			$data['mobile'] = "";
			$data['email'] = "";
			$data['f_name'] = "";
			$data['father_mobile_no'] = "";
			$data['m_name'] = "";
			$data['mother_mob_no'] = "";
			$data['spouse_name'] = "";
			$data['spouse_mob_no'] = "";
			$data['passport_no'] = "";
			$data['passport_exp'] = "";
			$data['passport_issue_country'] = "";
			$data['passport_issue_city'] = "";
			$data['dl_no'] = "";
			$data['dl_available'] = "";
			$data['dl_expiry'] = "";

			$data['iqama_no'] = "";
			$data['iqama_exp'] = "";
			
			$data['iqama_issue_country'] = "";
			$data['iqama_issue_city'] = "";
			$data['current_dl'] = "";
			$data['current_dl_expiry'] = "";

			$data['address_1'] = "";
			$data['address_2'] = "";
			$data['address_3'] = "";
			$data['area'] = "";
			$data['city'] = "";
			$data['state'] = "";
			$data['country'] = "";
			$data['postal_code'] = "";
			$data['emergency_no'] = "";
		}
		$data['positions'] = $this->Job_title_model->get_list();
		$data['educations'] = $this->Edu_model->get_list();
		$data['cities'] = $this->City_model->get_cities()->result();
		$data['departments'] = $this->Department_model->get_data();
		$data['nationalities'] = $this->Nationality_model->get_data();
		$data['cv_id'] = $this->db->query("SELECT id FROM master_cv ORDER BY id desc limit 1")->row();
		// print_r($data['cv_no']);exit();
		$this->load->view('admin/hr/recruitment/cv/form',$data);
	}

	public function save_cv(){
		$this->form_validation->set_rules('first_name', 'Person First Name', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Cv_model->edit();
    		}
    		else{
    			$query = $this->Cv_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/cv');
	}

	public function cv_detail(){
		if($this->input->get('id')){
			$query = $this->Cv_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['cv_no'] = $query->cv_no;
			$data['hiring_type'] = $query->hiring_type;
			$data['applicant_country'] = $query->applicant_country;
			$data['agency_name'] = $query->agency_name;
			$data['applied_for'] = $query->applied_for;
			$data['first_name'] = $query->first_name;
			$data['middle_name'] = $query->middle_name;
			$data['third_name'] = $query->third_name;
			$data['surname'] = $query->surname;
			$data['dob'] = $query->dob;
			$data['gender'] = $query->gender;
			$data['marital_status'] = $query->marital_status;
			$data['mobile'] = $query->mobile;
			$data['email'] = $query->email;
			$data['f_name'] = $query->f_name;
			$data['father_mobile_no'] = $query->father_mobile_no;
			$data['m_name'] = $query->m_name;
			$data['mother_mob_no'] = $query->mother_mob_no;
			$data['spouse_name'] = $query->spouse_name;
			$data['spouse_mob_no'] = $query->spouse_mob_no;
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
			$data['current_dl'] = $query->current_dl;
			$data['current_dl_expiry'] = $query->current_dl_expiry;

			$data['address_1'] = $query->address_1;
			$data['address_2'] = $query->address_2;
			$data['address_3'] = $query->address_3;
			$data['area'] = $query->area;
			$data['city'] = $query->city;
			$data['state'] = $query->state;
			$data['country'] = $query->country;
			$data['postal_code'] = $query->postal_code;
			$data['emergency_no'] = $query->emergency_no;
			
			$data['positions'] = $this->Job_title_model->get_list();
			$data['educations'] = $this->Edu_model->get_list();
			$data['cities'] = $this->City_model->get_cities()->result();
			$data['departments'] = $this->Department_model->get_data();
			$data['nationalities'] = $this->Nationality_model->get_data();
			$this->load->view('admin/hr/recruitment/cv/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/cv');
		}
	}

	public function get_cv_list(){
		$fetch_data = $this->Cv_model->get_list();
		// print_r($fetch_data);die();
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
			if($cv->interview_status == 'selected'){
				$int_status = '<span class="badge badge-pill badge-soft-success font-size-13">Selected</span>';
			}elseif($cv->interview_status == 'rejected'){
				$int_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>';
			}else{
				$int_status = '<span class="badge badge-pill badge-soft-dark font-size-13">NA</span>';
			}
			$sub_array[] = $int_status;
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
			$sub_array[] = date('d-m-Y', strtotime($cv->created_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/cv/add?id='.$cv->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/cv/detail?id='.$cv->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
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

	public function delete_cv(){
		$ids = $this->input->post('checklist');
		$query = $this->Cv_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
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

	// ------ Candidate LOI

	public function index_loi()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/recruitment/loi/index',$data);
	}

	public function add_loi(){
		if($this->input->get('id')){
			$query = $this->Loi_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['loi_no'] = $query->loi_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['open_date'] = $query->open_date;
			$data['cv_no'] = $query->cv_no;
			$data['position'] = $query->position;
			$data['interview_date'] = $query->interview_date;
			$data['joining_date'] = $query->joining_date;
			$data['print_date'] = $query->print_date;
			$data['valid_upto'] = $query->valid_upto;
			
		}
		else{
			$data['id'] = "";
			$data['loi_no'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['iqama_no'] = "";
			$data['open_date'] = "";
			$data['cv_no'] = "";
			$data['position'] = "";
			$data['interview_date'] = "";
			$data['joining_date'] = "";
			$data['print_date'] = "";
			$data['valid_upto'] = "";
		}
		$data['positions'] = $this->Job_title_model->get_list();
		$data['cvs'] = $this->Cv_model->get_data();
		$data['loi_id'] = $this->db->query("SELECT id FROM master_loi ORDER BY id desc limit 1")->row();
		// print_r($data);exit();
		$this->load->view('admin/hr/recruitment/loi/form',$data);
	}

	public function save_loi(){
		$this->form_validation->set_rules('name', 'Education Name', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Loi_model->edit();
    		}
    		else{
    			$query = $this->Loi_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/loi');
	}

	public function loi_detail(){
		if($this->input->get('id')){
			$query = $this->Loi_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['loi_no'] = $query->loi_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['open_date'] = $query->open_date;
			$data['cv_no'] = $query->cv_no;
			$data['position'] = $query->position;
			$data['interview_date'] = $query->interview_date;
			$data['joining_date'] = $query->joining_date;
			$data['print_date'] = $query->print_date;
			$data['valid_upto'] = $query->valid_upto;
			
			$data['positions'] = $this->Job_title_model->get_list();
			$data['cvs'] = $this->Cv_model->get_data();
			
			$this->load->view('admin/hr/recruitment/loi/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/loi');
		}
	}

	public function get_loi_list(){
		$fetch_data = $this->Loi_model->get_list();
        // print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->loi_no;
			$sub_array[] = $store->name;
			$sub_array[] = $store->mobile;
			$sub_array[] = $store->position;
			$sub_array[] = $store->cv_num;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/loi/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/loi/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Loi_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Loi_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete_loi(){
		$ids = $this->input->post('checklist');
		$query = $this->Loi_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/loi');
	}

	public function get_cv_detail()
	{
		$id = $this->input->get('id');
		$data = $this->Cv_model->get_detail($id);
		echo json_encode($data);
	}


	// ------ Candidate LOUI

	public function index_loui()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/recruitment/loui/index',$data);
	}

	
	public function add_loui(){
		if($this->input->get('id')){
			$query = $this->Loui_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['loui_no'] = $query->loui_no;
			$data['loi_no'] = $query->loi_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['open_date'] = $query->open_date;
			$data['cv_no'] = $query->cv_no;
			$data['position'] = $query->position;
			$data['print_date'] = $query->print_date;
			$data['valid_upto'] = $query->valid_upto;
			$data['begin_date'] = $query->begin_date;
			$data['end_date'] = $query->end_date;
			$data['employer_name'] = $query->employer_name;
			$data['employer_position'] = $query->employer_position;
		}
		else{
			$data['id'] = "";
			$data['loui_no'] = "";
			$data['loi_no'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['iqama_no'] = "";
			$data['open_date'] = "";
			$data['cv_no'] = "";
			$data['position'] = "";
			$data['print_date'] = "";
			$data['valid_upto'] = "";
			$data['begin_date'] = "";
			$data['end_date'] = "";
			$data['employer_name'] = "";
			$data['employer_position'] = "";
		}
		$data['lois'] = $this->Loi_model->get_data();
		$data['loui_id'] = $this->db->query("SELECT id FROM master_loui ORDER BY id desc limit 1")->row();
		// print_r($data);exit();
		$this->load->view('admin/hr/recruitment/loui/form',$data);
	}

	public function save_loui(){
		$this->form_validation->set_rules('name', 'Education Name', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Loui_model->edit();
    		}
    		else{
    			$query = $this->Loui_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/loui');
	}

	public function loui_detail(){
		if($this->input->get('id')){
			$query = $this->Loui_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['loui_no'] = $query->loui_no;
			$data['loi_no'] = $query->loi_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['open_date'] = $query->open_date;
			$data['cv_no'] = $query->cv_no;
			$data['position'] = $query->position;
			$data['print_date'] = $query->print_date;
			$data['valid_upto'] = $query->valid_upto;
			$data['begin_date'] = $query->begin_date;
			$data['end_date'] = $query->end_date;
			$data['employer_name'] = $query->employer_name;
			$data['employer_position'] = $query->employer_position;
			
			$data['lois'] = $this->Loi_model->get_data();
			$data['loui_id'] = $this->db->query("SELECT id FROM master_loui ORDER BY id desc limit 1")->row();
			
			$this->load->view('admin/hr/recruitment/loui/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/loui');
		}
	}

	public function get_loui_list(){
		$fetch_data = $this->Loui_model->get_list();
// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->loui_no;
			$sub_array[] = $store->name;
			$sub_array[] = $store->mobile;
			$sub_array[] = $store->position;
			$sub_array[] = $store->loi_num;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/loui/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/loui/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Loui_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Loui_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete_loui(){
		$ids = $this->input->post('checklist');
		$query = $this->Loui_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/loui');
	}

	public function get_loi_detail()
	{
		$id = $this->input->get('id');
		$data = $this->Loi_model->get_detail($id);
		// $data['age'] = age_calculate($data['loi']->dob);
		$final = array(
			'name' => $data->name,
			'mobile' => $data->mobile,
			'iqama_no' => $data->iqama_no,
			'cv_num' => $data->cv_num,
			'position' => $data->position,
			'print_date' => $data->print_date,
			'valid_upto' => $data->valid_upto,
			'dob' => $data->dob,
			'city' => $data->city,
			'state' => $data->state,
			'age' => age_calculate($data->dob)
		);

		echo json_encode($final);
	}

	

	// ------ Candidate Contract Letter

	public function index_cl()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/recruitment/cl/index',$data);
	}

	
	public function add_cl(){
		if($this->input->get('id')){
			$query = $this->Cl_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['contract_no'] = $query->contract_no;
			$data['loi_no'] = $query->loi_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['open_date'] = $query->open_date;
			$data['cv_no'] = $query->cv_no;
			$data['position'] = $query->position;
			$data['print_date'] = $query->print_date;
			$data['dob'] = $query->dob;
			$data['age'] = $query->age;
			$data['city'] = $query->city;
			$data['state'] = $query->state;
			$data['employer_name'] = $query->employer_name;
			$data['employer_position'] = $query->employer_position;
		}
		else{
			$data['id'] = "";
			$data['contract_no'] = "";
			$data['loi_no'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['iqama_no'] = "";
			$data['open_date'] = "";
			$data['cv_no'] = "";
			$data['position'] = "";
			$data['print_date'] = "";
			$data['dob'] = "";
			$data['age'] = "";
			$data['city'] = "";
			$data['state'] = "";
			$data['employer_name'] = "";
			$data['employer_position'] = "";
		}
		$data['lois'] = $this->Loi_model->get_data();
		$data['cl_id'] = $this->db->query("SELECT id FROM contract_letter ORDER BY id desc limit 1")->row();
		// print_r($data);exit();
		$this->load->view('admin/hr/recruitment/cl/form',$data);
	}

	public function save_cl(){
		$this->form_validation->set_rules('name', 'Education Name', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Cl_model->edit();
    		}
    		else{
    			$query = $this->Cl_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/cl');
	}

	public function cl_detail(){
		if($this->input->get('id')){
			$query = $this->Cl_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['contract_no'] = $query->contract_no;
			$data['loi_no'] = $query->loi_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['open_date'] = $query->open_date;
			$data['cv_no'] = $query->cv_no;
			$data['position'] = $query->position;
			$data['print_date'] = $query->print_date;
			$data['dob'] = $query->dob;
			$data['age'] = $query->age;
			$data['city'] = $query->city;
			$data['state'] = $query->state;
			$data['employer_name'] = $query->employer_name;
			$data['employer_position'] = $query->employer_position;
			
			$data['lois'] = $this->Loi_model->get_data();
			$data['cl_id'] = $this->db->query("SELECT id FROM contract_letter ORDER BY id desc limit 1")->row();
			
			$this->load->view('admin/hr/recruitment/cl/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/cl');
		}
	}

	public function get_cl_list(){
		$fetch_data = $this->Cl_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->contract_no;
			$sub_array[] = $store->name;
			$sub_array[] = $store->mobile;
			$sub_array[] = $store->position;
			$sub_array[] = $store->loi_num;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/cl/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/cl/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Cl_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Cl_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete_cl(){
		$ids = $this->input->post('checklist');
		$query = $this->Cl_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/cl');
	}

}
