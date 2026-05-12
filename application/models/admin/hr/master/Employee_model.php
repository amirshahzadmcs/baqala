<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model{

	function add($hashpassword){
		$this->db->trans_start();
		
		$query = $this->db->query("INSERT INTO master_employee SET 
		emp_no = '" . $this->db->escape_str($this->input->post('emp_no')) . "', 
		cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', 
		hiring_type = '" . $this->db->escape_str($this->input->post('hiring_type')) . "', 
		applicant_country = '" . $this->db->escape_str($this->input->post('applicant_country')) . "',  
		agency_name = '" . $this->db->escape_str($this->input->post('agency_name')) . "', 
		line_manager = '" . $this->db->escape_str($this->input->post('line_manager')) . "', 
		applicant_type = '" . $this->db->escape_str($this->input->post('applicant_type')) . "', 
		first_name = '" . $this->db->escape_str($this->input->post('first_name')) . "', 
		middle_name = '" . $this->db->escape_str($this->input->post('middle_name')) . "', 
		third_name = '" . $this->db->escape_str($this->input->post('third_name')) . "', 
		surname = '" . $this->db->escape_str($this->input->post('surname')) . "', 
		employee_arabic_name = '" . $this->db->escape_str($this->input->post('employee_arabic_name')) . "', 
		dob = '" . $this->db->escape_str($this->input->post('dob')) . "', 
		age = '" . $this->db->escape_str($this->input->post('age')) . "', 
		age_remarks = '" . $this->db->escape_str($this->input->post('age_remarks')) . "', 
		gender = '" . $this->db->escape_str($this->input->post('gender')) . "', 
		marital_status = '" . $this->db->escape_str($this->input->post('marital_status')) . "', 
		employee_mode = '" . $this->db->escape_str($this->input->post('employee_mode')) . "', 
		nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
		mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
		email = '" . $this->db->escape_str($this->input->post('email')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		allow_access = '" . $this->db->escape_str($this->input->post('allow_access')) . "', 
		bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', 
		iban = '" . $this->db->escape_str($this->input->post('iban')) . "', 
		stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "', 
		passport_no = '" . $this->db->escape_str($this->input->post('passport_no')) . "', 
		passport_exp = '" . $this->db->escape_str($this->input->post('passport_exp')) . "', 
		passport_issue_country = '" . $this->db->escape_str($this->input->post('passport_issue_country')) . "', 
		passport_issue_city = '" . $this->db->escape_str($this->input->post('passport_issue_city')) . "', 
		dl_available = '" . $this->db->escape_str($this->input->post('dl_available')) . "', 
		dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "', 
		dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "', 
		iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', 
		iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "', 
		iqama_issue_country = '" . $this->db->escape_str($this->input->post('iqama_issue_country')) . "', 
		iqama_issue_city = '" . $this->db->escape_str($this->input->post('iqama_issue_city')) . "', 
		saudi_dl_available = '" . $this->db->escape_str($this->input->post('saudi_dl_available')) . "', 
		dl_type = '" . $this->db->escape_str($this->input->post('dl_type')) . "', 
		dl_issuing_authority = '" . $this->db->escape_str($this->input->post('dl_issuing_authority')) . "', 
		current_dl = '" . $this->db->escape_str($this->input->post('current_dl')) . "', 
		current_dl_expiry = '" . $this->db->escape_str($this->input->post('current_dl_expiry')) . "', 
		designation = '" . $this->db->escape_str($this->input->post('designation')) . "', 
		department = '" . $this->db->escape_str($this->input->post('department')) . "', 
		
		joining_date = '" . $this->db->escape_str($this->input->post('joining_date')) . "', 
		branch = '" . $this->db->escape_str($this->input->post('branch')) . "', 
		work_type = '" . $this->db->escape_str($this->input->post('work_type')) . "', 
		insurance_number = '" . $this->db->escape_str($this->input->post('insurance_number')) . "', 
		insurance_expiry = '" . $this->db->escape_str($this->input->post('insurance_expiry')) . "', 
		attendance_shift = '" . $this->db->escape_str($this->input->post('attendance_shift')) . "', 
		holiday_list = '" . $this->db->escape_str($this->input->post('holiday_list')) . "', 
		leave_policy = '" . $this->db->escape_str($this->input->post('leave_policy')) . "', 
		attendance_restriction = '" . $this->db->escape_str($this->input->post('attendance_restriction')) . "', 
		send_credential = '" . $this->db->escape_str($this->input->post('send_credential')) . "', 
		display_language = '" . $this->db->escape_str($this->input->post('display_language')) . "', 
		employee_role = '" . $this->db->escape_str($this->input->post('employee_role')) . "', 
		branches = '" . $this->db->escape_str($this->input->post('branches')) . "', 
		password = '" . $hashpassword . "', 
		created_at = NOW(), 
		updated_at = now()");
		$insert_id = $this->db->insert_id();
		if($query){
			$cv_docs = $this->db->query("SELECT * FROM upload_cv_doc WHERE cv_id = '". (int)$this->input->post('cv_no') ."'")->result_array();
			//print_r($cv_docs);exit();
			if($cv_docs){
				foreach($cv_docs as $doc){
					$this->db->query("INSERT INTO master_employee_doc SET emp_id = '" . (int)$insert_id . "', document = '" . $this->db->escape_str($doc['document']) . "', doc_type = '" . $this->db->escape_str($doc['doc_type']) . "'");
				}
			}
			
			if($this->input->post('family_name') && !empty($this->input->post('family_name'))){
				$member_count = count($this->input->post('family_name'));
				for($r=0;$r<$member_count;$r++){
					$family_iqama = $this->input->post('family_iqama');
					$family_name = $this->input->post('family_name');
					$family_relation = $this->input->post('family_relation');
					$family_dob = $this->input->post('family_dob');
					$family_insurance = $this->input->post('family_insurance');
					$this->db->query("INSERT INTO emp_family_members SET emp_id = '" . (int)$insert_id . "', family_iqama = '" . $this->db->escape_str($family_iqama[$r]) . "', family_name = '" . $this->db->escape_str($family_name[$r]) . "', family_relation = '" . $this->db->escape_str($family_relation[$r]) . "', family_dob = '" . $this->db->escape_str($family_dob[$r]) . "', family_insurance = '" . $this->db->escape_str($family_insurance[$r]) . "'");
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		
		$query = $this->db->query("UPDATE master_employee SET 
		hiring_type = '" . $this->db->escape_str($this->input->post('hiring_type')) . "', 
		applicant_country = '" . $this->db->escape_str($this->input->post('applicant_country')) . "',  
		agency_name = '" . $this->db->escape_str($this->input->post('agency_name')) . "', 
		line_manager = '" . $this->db->escape_str($this->input->post('line_manager')) . "', 
		applicant_type = '" . $this->db->escape_str($this->input->post('applicant_type')) . "', 
		first_name = '" . $this->db->escape_str($this->input->post('first_name')) . "', 
		middle_name = '" . $this->db->escape_str($this->input->post('middle_name')) . "', 
		third_name = '" . $this->db->escape_str($this->input->post('third_name')) . "', 
		surname = '" . $this->db->escape_str($this->input->post('surname')) . "', 
		employee_arabic_name = '" . $this->db->escape_str($this->input->post('employee_arabic_name')) . "', 
		dob = '" . $this->db->escape_str($this->input->post('dob')) . "', 
		age = '" . $this->db->escape_str($this->input->post('age')) . "', 
		age_remarks = '" . $this->db->escape_str($this->input->post('age_remarks')) . "', 
		gender = '" . $this->db->escape_str($this->input->post('gender')) . "', 
		marital_status = '" . $this->db->escape_str($this->input->post('marital_status')) . "', 
		employee_mode = '" . $this->db->escape_str($this->input->post('employee_mode')) . "', 
		nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
		mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
		email = '" . $this->db->escape_str($this->input->post('email')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', 
		iban = '" . $this->db->escape_str($this->input->post('iban')) . "', 
		stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "', 
		allow_access = '" . $this->db->escape_str($this->input->post('allow_access')) . "', 
		passport_no = '" . $this->db->escape_str($this->input->post('passport_no')) . "', 
		passport_exp = '" . $this->db->escape_str($this->input->post('passport_exp')) . "', 
		passport_issue_country = '" . $this->db->escape_str($this->input->post('passport_issue_country')) . "', 
		passport_issue_city = '" . $this->db->escape_str($this->input->post('passport_issue_city')) . "', 
		dl_available = '" . $this->db->escape_str($this->input->post('dl_available')) . "', 
		dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "', 
		dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "', 
		iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', 
		iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "', 
		iqama_issue_country = '" . $this->db->escape_str($this->input->post('iqama_issue_country')) . "', 
		iqama_issue_city = '" . $this->db->escape_str($this->input->post('iqama_issue_city')) . "', 
		saudi_dl_available = '" . $this->db->escape_str($this->input->post('saudi_dl_available')) . "', 
		dl_type = '" . $this->db->escape_str($this->input->post('dl_type')) . "', 
		dl_issuing_authority = '" . $this->db->escape_str($this->input->post('dl_issuing_authority')) . "', 
		current_dl = '" . $this->db->escape_str($this->input->post('current_dl')) . "', 
		current_dl_expiry = '" . $this->db->escape_str($this->input->post('current_dl_expiry')) . "', 
		designation = '" . $this->db->escape_str($this->input->post('designation')) . "', 
		department = '" . $this->db->escape_str($this->input->post('department')) . "', 
		
		joining_date = '" . $this->db->escape_str($this->input->post('joining_date')) . "', 
		branch = '" . $this->db->escape_str($this->input->post('branch')) . "', 
		work_type = '" . $this->db->escape_str($this->input->post('work_type')) . "', 
		insurance_number = '" . $this->db->escape_str($this->input->post('insurance_number')) . "', 
		insurance_expiry = '" . $this->db->escape_str($this->input->post('insurance_expiry')) . "', 
		attendance_shift = '" . $this->db->escape_str($this->input->post('attendance_shift')) . "', 
		holiday_list = '" . $this->db->escape_str($this->input->post('holiday_list')) . "', 
		leave_policy = '" . $this->db->escape_str($this->input->post('leave_policy')) . "', 
		attendance_restriction = '" . $this->db->escape_str($this->input->post('attendance_restriction')) . "', 
		send_credential = '" . $this->db->escape_str($this->input->post('send_credential')) . "', 
		display_language = '" . $this->db->escape_str($this->input->post('display_language')) . "', 
		employee_role = '" . $this->db->escape_str($this->input->post('employee_role')) . "', 
		branches = '" . $this->db->escape_str($this->input->post('branches')) . "', 
		updated_at = now() WHERE id = '". $this->input->post('id') ."'");
		$insert_id = $this->input->post('id');
		if($query){
			$this->db->query("DELETE FROM emp_family_members WHERE emp_id = '" . (int)$insert_id . "'");
			if($this->input->post('family_name') && !empty($this->input->post('family_name'))){
				$member_count = count($this->input->post('family_name'));
				for($r=0;$r<$member_count;$r++){
					$family_iqama = $this->input->post('family_iqama');
					$family_name = $this->input->post('family_name');
					$family_relation = $this->input->post('family_relation');
					$family_dob = $this->input->post('family_dob');
					$family_insurance = $this->input->post('family_insurance');
					$this->db->query("INSERT INTO emp_family_members SET emp_id = '" . (int)$insert_id . "', family_iqama = '" . $this->db->escape_str($family_iqama[$r]) . "', family_name = '" . $this->db->escape_str($family_name[$r]) . "', family_relation = '" . $this->db->escape_str($family_relation[$r]) . "', family_dob = '" . $this->db->escape_str($family_dob[$r]) . "', family_insurance = '" . $this->db->escape_str($family_insurance[$r]) . "'");
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT emp.*, cv.cv_no as cv_num, mjt.name as designation_name, md.name as department_name FROM master_employee emp LEFT JOIN master_cv cv ON (emp.cv_no = cv.id) LEFT JOIN master_job_title mjt ON (emp.designation = mjt.id) LEFT JOIN master_department md ON (emp.department = md.id) WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$status,$mode,$role,$branch,$department,$designation,$attendance_restriction,$emp_id){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (emp.first_name LIKE '%".$keyword."%' OR emp.local_email LIKE '%".$keyword."%')";
		}
		if($status){
			$a .= " AND emp.status = '" . $status . "'";
		}
		if($mode){
			$a .= " AND emp.employee_mode = '" . $mode . "'";
		}
		if($role){
			$a .= " AND emp.employee_role = '" . $role . "'";
		}
		if($branch){
			$a .= " AND emp.branch = '" . $branch . "'";
		}
		if($department){
			$a .= " AND emp.department = '" . $department . "'";
		}
		if($designation){
			$a .= " AND emp.designation = '" . $designation . "'";
		}
		if($attendance_restriction){
			$a .= " AND emp.attendance_restriction = '" . $attendance_restriction . "'";
		}
		if($emp_id){
			$a .= " AND emp.emp_no = '" . $emp_id . "'";
		}
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND emp.first_name LIKE '%".$_POST["search"]["value"]."%' OR emp.emp_no LIKE '%".$_POST["search"]["value"]."%' OR cv.cv_no LIKE '%".$_POST["search"]["value"]."%' OR emp.email LIKE '%".$_POST["search"]["value"]."%'";
		// }
		if(isset($_POST["order"])){
			$a .= " ORDER BY emp.emp_no DESC";
		}
        else{
			$a .= " ORDER BY emp.emp_no DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$status,$mode,$role,$branch,$department,$designation,$attendance_restriction,$emp_id){
	   $a = $this->make_query();
	   if($keyword){
			$a .= " AND (emp.first_name LIKE '%".$keyword."%' OR emp.local_email LIKE '%".$keyword."%')";
		}
		if($status){
			$a .= " AND emp.status = '" . $status . "'";
		}
		if($mode){
			$a .= " AND emp.employee_mode = '" . $mode . "'";
		}
		if($role){
			$a .= " AND emp.employee_role = '" . $role . "'";
		}
		if($branch){
			$a .= " AND emp.branch = '" . $branch . "'";
		}
		if($department){
			$a .= " AND emp.department = '" . $department . "'";
		}
		if($designation){
			$a .= " AND emp.designation = '" . $designation . "'";
		}
		if($attendance_restriction){
			$a .= " AND emp.attendance_restriction = '" . $attendance_restriction . "'";
		}
		if($emp_id){
			$a .= " AND emp.emp_no = '" . $emp_id . "'";
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_employee');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_employee WHERE id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM master_employee_doc WHERE emp_id = '". (int)$ids[$i] ."'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT master_employee.*, master_cv.cv_no as cv_num FROM master_employee LEFT JOIN master_cv ON (master_employee.cv_no = master_cv.id) WHERE master_employee.id = '" . (int)$id . "'");
		return $query->row();
	}

	function get_emp_docs($id){
		$this->db->select("*");  
		$this->db->from('master_employee_doc');  
		$this->db->where('emp_id', (int)$id);  
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_emp_family($id){
		$this->db->select("*");  
		$this->db->from('emp_family_members');  
		$this->db->where('emp_id', (int)$id);  
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_cv_data()
	{
		$a = "SELECT cv.*, mjt.name as pos_name FROM master_cv cv LEFT JOIN master_job_title mjt ON (cv.applied_for = mjt.id) WHERE cv.arrival_status = '1' AND cv.id NOT IN (SELECT cv_no FROM master_employee WHERE 1=1)";
		$query = $this->db->query($a);  
        return $query->result(); 
	}
	
	function delete_image(){
		$id = $this->input->post('img_id');
		$empid = $this->input->post('emp_id');
		$query = $this->db->query("DELETE FROM master_employee_doc WHERE id = '" . (int)$id . "' AND emp_id = '". (int)$empid ."' LIMIT 1");
		return $query;
	}

	function check_duplicate_passport($id, $passport_no){
		$this->db->select("*");  
		$this->db->from('master_employee'); 
		$this->db->where('id !=',$id);
		$this->db->where('passport_no =',$passport_no);
		return $this->db->count_all_results();  
	}
	
	function check_duplicate_empid($id, $emp_no){
		$this->db->select("*");  
		$this->db->from('master_employee'); 
		$this->db->where('id !=',$id);
		$this->db->where('emp_no =',$emp_no);
		return $this->db->count_all_results();  
	}
	
	function check_duplicate_email($id, $email){
		$this->db->select("*");  
		$this->db->from('master_employee'); 
		$this->db->where('id !=',$id);
		$this->db->where('email =',$email);
		return $this->db->count_all_results();  
	}

	function uploadDocuments(){
		$query = FALSE;
		$this->db->trans_start();
		if($_FILES['attachments']['name'][0] !== '' && count($_FILES['attachments']['tmp_name']) > 0){
			//print_r($_FILES['documents']);exit();
			$con['upload_path']   = './uploads/cv/'; 
			$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
			$con['maintain_ratio'] = TRUE;
			$con['max_filename'] = '50';
			$con['encrypt_name'] = TRUE;
			$image_count = count($_FILES['attachments']['name']);
			for($o=0;$o<$image_count;$o++){
				$_FILES['attachments']['name']= $_FILES['attachments']['name'][$o];
				$_FILES['attachments']['type']= $_FILES['attachments']['type'][$o];
				$_FILES['attachments']['tmp_name']= $_FILES['attachments']['tmp_name'][$o];
				$_FILES['attachments']['error']= $_FILES['attachments']['error'][$o];
				$_FILES['attachments']['size']= $_FILES['attachments']['size'][$o];    
				
				$this->load->library('upload', $con);
				$this->upload->do_upload('attachments');
				$image_da = $this->upload->data();
				$attachments = "uploads/cv/".$image_da['file_name'];
				if($image_da['file_name'] !== ''){
					$query = $this->db->query("INSERT INTO master_employee_doc SET emp_id = '" . (int)$this->input->post('emp_id') . "', document = '" . $this->db->escape_str($attachments) . "', doc_type = '" . $this->db->escape_str($this->input->post('doc_type')) . "', doc_category = '" . $this->db->escape_str($this->input->post('doc_category')) . "'");
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}
}
