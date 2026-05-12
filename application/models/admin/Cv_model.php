<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cv_model extends CI_Model{

	function add(){
		$con['upload_path']   = './uploads/cv/'; 
		$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;

		$this->db->trans_start();
		$query = $this->db->query("INSERT INTO master_cv SET 
			cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', 
			hiring_type = '" . $this->db->escape_str($this->input->post('hiring_type')) . "', 
			applicant_country = '" . $this->db->escape_str($this->input->post('applicant_country')) . "', 
			agency_name = '" . $this->db->escape_str($this->input->post('agency_name')) . "', 
			applicant_type = '" . $this->db->escape_str($this->input->post('applicant_type')) . "', 
			applied_for = '" . $this->db->escape_str($this->input->post('applied_for')) . "', 
			first_name = '" . $this->db->escape_str($this->input->post('first_name')) . "', 
			middle_name = '" . $this->db->escape_str($this->input->post('middle_name')) . "', 
			third_name = '" . $this->db->escape_str($this->input->post('third_name')) . "', 
			surname = '" . $this->db->escape_str($this->input->post('surname')) . "', 
			candidate_arabic_name = '" . $this->db->escape_str($this->input->post('candidate_arabic_name')) . "', 
			dob = '" . $this->db->escape_str($this->input->post('dob')) . "', 
			age = '" . $this->db->escape_str($this->input->post('age')) . "', 
			age_remarks = '" . $this->db->escape_str($this->input->post('age_remarks')) . "', 
			gender = '" . $this->db->escape_str($this->input->post('gender')) . "', 
			marital_status = '" . $this->db->escape_str($this->input->post('marital_status')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			imo_available = '" . $this->db->escape_str($this->input->post('imo_available')) . "', 
			nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
			interviewer = '" . $this->db->escape_str($this->input->post('interviewer')) . "', 
			interview_date = '" . $this->db->escape_str($this->input->post('interview_date')) . "', 
			interview_status = '" . $this->db->escape_str($this->input->post('interview_status')) . "', 
			rejection_reason = '" . $this->db->escape_str($this->input->post('rejection_reason')) . "', 
			cv_status = '" . $this->db->escape_str($this->input->post('cv_status')) . "', 
			offer_letter_status = '" . $this->db->escape_str($this->input->post('offer_letter_status')) . "', 
			deployment_status = '" . $this->db->escape_str($this->input->post('deployment_status')) . "', 
			offer_reject_reason = '" . $this->db->escape_str($this->input->post('offer_reject_reason')) . "', 
			
			visa_entry_date = '" . $this->db->escape_str($this->input->post('visa_entry_date')) . "', 
			visa_expiry = '" . $this->db->escape_str($this->input->post('visa_expiry')) . "', 
			visa_no = '" . $this->db->escape_str($this->input->post('visa_no')) . "', 
			border_entry_no = '" . $this->db->escape_str($this->input->post('border_entry_no')) . "', 
			arrival_date = '" . $this->db->escape_str($this->input->post('arrival_date')) . "', 
			sponsor_id = '" . $this->db->escape_str($this->input->post('sponsor_id')) . "', 
			sponsor_name = '" . $this->db->escape_str($this->input->post('sponsor_name')) . "', 
			blood_group = '" . $this->db->escape_str($this->input->post('blood_group')) . "', 

			passport_no = '" . $this->db->escape_str($this->input->post('passport_no')) . "', 
			passport_exp = '" . $this->db->escape_str($this->input->post('passport_exp')) . "', 
			passport_issue_country = '" . $this->db->escape_str($this->input->post('passport_issue_country')) . "', 
			passport_issue_city = '" . $this->db->escape_str($this->input->post('passport_issue_city')) . "', 
			dl_available = '" . $this->db->escape_str($this->input->post('dl_available')) . "', 
			dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "', 
			dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "', 
			saudi_dl_available = '" . $this->db->escape_str($this->input->post('saudi_dl_available')) . "', 
			dl_type = '" . $this->db->escape_str($this->input->post('dl_type')) . "', 
			current_dl = '" . $this->db->escape_str($this->input->post('current_dl')) . "', 
			current_dl_expiry = '" . $this->db->escape_str($this->input->post('current_dl_expiry')) . "', 

			rider_package_id = '" . $this->db->escape_str($this->input->post('rider_package_id')) . "', 
			
			created_at = NOW(), 
			updated_at = now()");
		$insert_id = $this->db->insert_id();
		if($query){
			
			if($this->input->post('person_name') && !empty($this->input->post('person_name'))){
				$member_count = count($this->input->post('person_name'));
				for($r=0;$r<$member_count;$r++){
					$family_name = $this->input->post('person_name');
					$family_relation = $this->input->post('relationship');
					$family_contact = $this->input->post('contact_no');
					$this->db->query("INSERT INTO master_cv_contacts SET cv_id = '" . (int)$insert_id . "', person_name = '" . $this->db->escape_str($family_name[$r]) . "', relationship = '" . $this->db->escape_str($family_relation[$r]) . "', contact_no = '" . $this->db->escape_str($family_contact[$r]) . "'");
				}
			}
			
			if($this->input->post('hiring_type') == 'Back Office'){
				$this->db->query("INSERT INTO master_cv_package SET cv_id = '" . (int)$insert_id . "',
				total_salary_en = '" . $this->db->escape_str($this->input->post('total_salary_en')) . "', 
				total_salary_ar = '" . $this->db->escape_str($this->input->post('total_salary_ar')) . "', 
				basic_salary_en = '" . $this->db->escape_str($this->input->post('basic_salary_en')) . "', 
				basic_salary_ar = '" . $this->db->escape_str($this->input->post('basic_salary_ar')) . "', 
				housing_allowance_en = '" . $this->db->escape_str($this->input->post('housing_allowance_en')) . "', 
				housing_allowance_ar = '" . $this->db->escape_str($this->input->post('housing_allowance_ar')) . "', 
				transport_allowance_en = '" . $this->db->escape_str($this->input->post('transport_allowance_en')) . "', 
				transport_allowance_ar = '" . $this->db->escape_str($this->input->post('transport_allowance_ar')) . "', 
				order_allowance_en = '" . $this->db->escape_str($this->input->post('order_allowance_en')) . "', 
				order_allowance_ar = '" . $this->db->escape_str($this->input->post('order_allowance_ar')) . "', 
				other_en = '" . $this->db->escape_str($this->input->post('other_en')) . "', 
				other_ar = '" . $this->db->escape_str($this->input->post('other_ar')) . "', 
				annual_vacation_en = '" . $this->db->escape_str($this->input->post('annual_vacation_en')) . "', 
				annual_vacation_ar = '" . $this->db->escape_str($this->input->post('annual_vacation_ar')) . "', 
				medical_insurance_en = '" . $this->db->escape_str($this->input->post('medical_insurance_en')) . "', 
				medical_insurance_ar = '" . $this->db->escape_str($this->input->post('medical_insurance_ar')) . "', 
				contract_period_en = '" . $this->db->escape_str($this->input->post('contract_period_en')) . "', 
				contract_period_ar = '" . $this->db->escape_str($this->input->post('contract_period_ar')) . "'
				");
			}

			// if($_FILES['documents']['name'][0] !== '' && count($_FILES['documents']['tmp_name']) > 0){
    		// 	$image_count = count($_FILES['documents']['name']);
    		// 	for($o=0;$o<$image_count;$o++){
            //         $_FILES['documents']['name']= $_FILES['documents']['name'][$o];
            //         $_FILES['documents']['type']= $_FILES['documents']['type'][$o];
            //         $_FILES['documents']['tmp_name']= $_FILES['documents']['tmp_name'][$o];
            //         $_FILES['documents']['error']= $_FILES['documents']['error'][$o];
            //         $_FILES['documents']['size']= $_FILES['documents']['size'][$o];    
                    
            //         $this->load->library('upload', $con);
			// 		$this->upload->do_upload('documents');
			// 		$image_da = $this->upload->data();
			// 		$documents = "uploads/cv/".$image_da['file_name'];
    		// 		$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$insert_id . "', document = '" . $this->db->escape_str($documents) . "', doc_type = 'others'");
    		// 	}
    		// }
			
			if($_FILES['dl_documents']['name'][0] !== '' && count($_FILES['dl_documents']['tmp_name']) > 0){
    			$image_count = count($_FILES['dl_documents']['name']);
    			for($o=0;$o<$image_count;$o++){
                    $_FILES['dl_documents']['name']= $_FILES['dl_documents']['name'][$o];
                    $_FILES['dl_documents']['type']= $_FILES['dl_documents']['type'][$o];
                    $_FILES['dl_documents']['tmp_name']= $_FILES['dl_documents']['tmp_name'][$o];
                    $_FILES['dl_documents']['error']= $_FILES['dl_documents']['error'][$o];
                    $_FILES['dl_documents']['size']= $_FILES['dl_documents']['size'][$o];    
                    
                    $this->load->library('upload', $con);
					$this->upload->do_upload('dl_documents');
					$image_dl = $this->upload->data();
					$dl_documents = "uploads/cv/".$image_dl['file_name'];
    				$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$insert_id . "', document = '" . $this->db->escape_str($dl_documents) . "', doc_type = 'dl'");
    			}
    		}
			
			if($_FILES['saudi_dl_documents']['name'][0] !== '' && count($_FILES['saudi_dl_documents']['tmp_name']) > 0){
    			$image_count = count($_FILES['saudi_dl_documents']['name']);
    			for($o=0;$o<$image_count;$o++){
                    $_FILES['saudi_dl_documents']['name']= $_FILES['saudi_dl_documents']['name'][$o];
                    $_FILES['saudi_dl_documents']['type']= $_FILES['saudi_dl_documents']['type'][$o];
                    $_FILES['saudi_dl_documents']['tmp_name']= $_FILES['saudi_dl_documents']['tmp_name'][$o];
                    $_FILES['saudi_dl_documents']['error']= $_FILES['saudi_dl_documents']['error'][$o];
                    $_FILES['saudi_dl_documents']['size']= $_FILES['saudi_dl_documents']['size'][$o];    
                    
                    $this->load->library('upload', $con);
					$this->upload->do_upload('saudi_dl_documents');
					$image_saudi_dl = $this->upload->data();
					$saudi_dl_documents = "uploads/cv/".$image_saudi_dl['file_name'];
    				$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$insert_id . "', document = '" . $this->db->escape_str($saudi_dl_documents) . "', doc_type = 'saudi_dl'");
    			}
    		}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		$query = $this->db->query("UPDATE master_cv SET 
			hiring_type = '" . $this->db->escape_str($this->input->post('hiring_type')) . "', 
			applicant_country = '" . $this->db->escape_str($this->input->post('applicant_country')) . "', 
			agency_name = '" . $this->db->escape_str($this->input->post('agency_name')) . "', 
			applicant_type = '" . $this->db->escape_str($this->input->post('applicant_type')) . "', 
			applied_for = '" . $this->db->escape_str($this->input->post('applied_for')) . "', 
			first_name = '" . $this->db->escape_str($this->input->post('first_name')) . "', 
			middle_name = '" . $this->db->escape_str($this->input->post('middle_name')) . "', 
			third_name = '" . $this->db->escape_str($this->input->post('third_name')) . "', 
			surname = '" . $this->db->escape_str($this->input->post('surname')) . "', 
			candidate_arabic_name = '" . $this->db->escape_str($this->input->post('candidate_arabic_name')) . "', 
			dob = '" . $this->db->escape_str($this->input->post('dob')) . "', 
			age = '" . $this->db->escape_str($this->input->post('age')) . "', 
			age_remarks = '" . $this->db->escape_str($this->input->post('age_remarks')) . "', 
			gender = '" . $this->db->escape_str($this->input->post('gender')) . "', 
			marital_status = '" . $this->db->escape_str($this->input->post('marital_status')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			imo_available = '" . $this->db->escape_str($this->input->post('imo_available')) . "', 
			nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
			interviewer = '" . $this->db->escape_str($this->input->post('interviewer')) . "', 
			interview_date = '" . $this->db->escape_str($this->input->post('interview_date')) . "', 
			interview_status = '" . $this->db->escape_str($this->input->post('interview_status')) . "', 
			rejection_reason = '" . $this->db->escape_str($this->input->post('rejection_reason')) . "', 
			cv_status = '" . $this->db->escape_str($this->input->post('cv_status')) . "', 
			offer_letter_status = '" . $this->db->escape_str($this->input->post('offer_letter_status')) . "', 
			deployment_status = '" . $this->db->escape_str($this->input->post('deployment_status')) . "', 
			offer_reject_reason = '" . $this->db->escape_str($this->input->post('offer_reject_reason')) . "', 
			
			visa_entry_date = '" . $this->db->escape_str($this->input->post('visa_entry_date')) . "', 
			visa_expiry = '" . $this->db->escape_str($this->input->post('visa_expiry')) . "', 
			visa_no = '" . $this->db->escape_str($this->input->post('visa_no')) . "', 
			border_entry_no = '" . $this->db->escape_str($this->input->post('border_entry_no')) . "', 
			arrival_date = '" . $this->db->escape_str($this->input->post('arrival_date')) . "', 
			sponsor_id = '" . $this->db->escape_str($this->input->post('sponsor_id')) . "', 
			sponsor_name = '" . $this->db->escape_str($this->input->post('sponsor_name')) . "', 
			blood_group = '" . $this->db->escape_str($this->input->post('blood_group')) . "', 

			passport_no = '" . $this->db->escape_str($this->input->post('passport_no')) . "', 
			passport_exp = '" . $this->db->escape_str($this->input->post('passport_exp')) . "', 
			passport_issue_country = '" . $this->db->escape_str($this->input->post('passport_issue_country')) . "', 
			passport_issue_city = '" . $this->db->escape_str($this->input->post('passport_issue_city')) . "', 
			dl_available = '" . $this->db->escape_str($this->input->post('dl_available')) . "', 
			dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "', 
			dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "', 
			saudi_dl_available = '" . $this->db->escape_str($this->input->post('saudi_dl_available')) . "', 
			dl_type = '" . $this->db->escape_str($this->input->post('dl_type')) . "', 
			current_dl = '" . $this->db->escape_str($this->input->post('current_dl')) . "', 
			current_dl_expiry = '" . $this->db->escape_str($this->input->post('current_dl_expiry')) . "', 

			rider_package_id = '" . $this->db->escape_str($this->input->post('rider_package_id')) . "', 
			
			updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'"
		);
		$cv_id = (int)$this->input->post('id');
		if($query && $cv_id > 0){

			$this->db->query("DELETE FROM master_cv_contacts WHERE cv_id = '" . (int)$cv_id . "'");
			if($this->input->post('person_name') && !empty($this->input->post('person_name'))){
				$member_count = count($this->input->post('person_name'));
				for($r=0;$r<$member_count;$r++){
					$family_name = $this->input->post('person_name');
					$family_relation = $this->input->post('relationship');
					$family_contact = $this->input->post('contact_no');
					$this->db->query("INSERT INTO master_cv_contacts SET cv_id = '" . (int)$cv_id . "', person_name = '" . $this->db->escape_str($family_name[$r]) . "', relationship = '" . $this->db->escape_str($family_relation[$r]) . "', contact_no = '" . $this->db->escape_str($family_contact[$r]) . "'");
				}
			}

			if($this->input->post('hiring_type') == 'Back Office'){
				$package_exist = $this->db->query("SELECT * FROM master_cv_package WHERE cv_id = '" . (int)$cv_id . "'")->num_rows();
				//print_r($package_exist);exit();
				if($package_exist > 0){
					$this->db->query("UPDATE master_cv_package SET 
					total_salary_en = '" . $this->db->escape_str($this->input->post('total_salary_en')) . "', 
					total_salary_ar = '" . $this->db->escape_str($this->input->post('total_salary_ar')) . "', 
					basic_salary_en = '" . $this->db->escape_str($this->input->post('basic_salary_en')) . "', 
					basic_salary_ar = '" . $this->db->escape_str($this->input->post('basic_salary_ar')) . "', 
					housing_allowance_en = '" . $this->db->escape_str($this->input->post('housing_allowance_en')) . "', 
					housing_allowance_ar = '" . $this->db->escape_str($this->input->post('housing_allowance_ar')) . "', 
					transport_allowance_en = '" . $this->db->escape_str($this->input->post('transport_allowance_en')) . "', 
					transport_allowance_ar = '" . $this->db->escape_str($this->input->post('transport_allowance_ar')) . "', 
					order_allowance_en = '" . $this->db->escape_str($this->input->post('order_allowance_en')) . "', 
					order_allowance_ar = '" . $this->db->escape_str($this->input->post('order_allowance_ar')) . "', 
					other_en = '" . $this->db->escape_str($this->input->post('other_en')) . "', 
					other_ar = '" . $this->db->escape_str($this->input->post('other_ar')) . "', 
					annual_vacation_en = '" . $this->db->escape_str($this->input->post('annual_vacation_en')) . "', 
					annual_vacation_ar = '" . $this->db->escape_str($this->input->post('annual_vacation_ar')) . "', 
					medical_insurance_en = '" . $this->db->escape_str($this->input->post('medical_insurance_en')) . "', 
					medical_insurance_ar = '" . $this->db->escape_str($this->input->post('medical_insurance_ar')) . "', 
					contract_period_en = '" . $this->db->escape_str($this->input->post('contract_period_en')) . "', 
					contract_period_ar = '" . $this->db->escape_str($this->input->post('contract_period_ar')) . "' 
					WHERE cv_id = '" . (int)$cv_id . "' LIMIT 1");
				}else{
					$this->db->query("INSERT INTO master_cv_package SET cv_id = '" . (int)$cv_id . "',
					total_salary_en = '" . $this->db->escape_str($this->input->post('total_salary_en')) . "', 
					total_salary_ar = '" . $this->db->escape_str($this->input->post('total_salary_ar')) . "', 
					basic_salary_en = '" . $this->db->escape_str($this->input->post('basic_salary_en')) . "', 
					basic_salary_ar = '" . $this->db->escape_str($this->input->post('basic_salary_ar')) . "', 
					housing_allowance_en = '" . $this->db->escape_str($this->input->post('housing_allowance_en')) . "', 
					housing_allowance_ar = '" . $this->db->escape_str($this->input->post('housing_allowance_ar')) . "', 
					transport_allowance_en = '" . $this->db->escape_str($this->input->post('transport_allowance_en')) . "', 
					transport_allowance_ar = '" . $this->db->escape_str($this->input->post('transport_allowance_ar')) . "', 
					order_allowance_en = '" . $this->db->escape_str($this->input->post('order_allowance_en')) . "', 
					order_allowance_ar = '" . $this->db->escape_str($this->input->post('order_allowance_ar')) . "', 
					other_en = '" . $this->db->escape_str($this->input->post('other_en')) . "', 
					other_ar = '" . $this->db->escape_str($this->input->post('other_ar')) . "', 
					annual_vacation_en = '" . $this->db->escape_str($this->input->post('annual_vacation_en')) . "', 
					annual_vacation_ar = '" . $this->db->escape_str($this->input->post('annual_vacation_ar')) . "', 
					medical_insurance_en = '" . $this->db->escape_str($this->input->post('medical_insurance_en')) . "', 
					medical_insurance_ar = '" . $this->db->escape_str($this->input->post('medical_insurance_ar')) . "', 
					contract_period_en = '" . $this->db->escape_str($this->input->post('contract_period_en')) . "', 
					contract_period_ar = '" . $this->db->escape_str($this->input->post('contract_period_ar')) . "'
					");
				}
			}
			
			// if($_FILES['documents']['name'][0] !== '' && count($_FILES['documents']['tmp_name']) > 0){
			// 	//print_r($_FILES['documents']);exit();
			// 	$con['upload_path']   = './uploads/cv/'; 
			// 	$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
			// 	$con['maintain_ratio'] = TRUE;
			// 	$con['max_filename'] = '50';
			// 	$con['encrypt_name'] = TRUE;
    		// 	$image_count = count($_FILES['documents']['name']);
    		// 	for($o=0;$o<$image_count;$o++){
            //         $_FILES['documents']['name']= $_FILES['documents']['name'][$o];
            //         $_FILES['documents']['type']= $_FILES['documents']['type'][$o];
            //         $_FILES['documents']['tmp_name']= $_FILES['documents']['tmp_name'][$o];
            //         $_FILES['documents']['error']= $_FILES['documents']['error'][$o];
            //         $_FILES['documents']['size']= $_FILES['documents']['size'][$o];    
                    
            //         $this->load->library('upload', $con);
			// 		$this->upload->do_upload('documents');
			// 		$image_da = $this->upload->data();
			// 		$documents = "uploads/cv/".$image_da['file_name'];
			// 		if($image_da['file_name'] !== ''){
			// 			$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('id') . "', document = '" . $this->db->escape_str($documents) . "', doc_type = 'others'");
			// 		}
    		// 	}
    		// }
			if($_FILES['dl_documents']['name'][0] !== '' && count($_FILES['dl_documents']['tmp_name']) > 0){
				$con['upload_path']   = './uploads/cv/'; 
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
    			$image_count = count($_FILES['dl_documents']['name']);
    			for($o=0;$o<$image_count;$o++){
                    $_FILES['dl_documents']['name']= $_FILES['dl_documents']['name'][$o];
                    $_FILES['dl_documents']['type']= $_FILES['dl_documents']['type'][$o];
                    $_FILES['dl_documents']['tmp_name']= $_FILES['dl_documents']['tmp_name'][$o];
                    $_FILES['dl_documents']['error']= $_FILES['dl_documents']['error'][$o];
                    $_FILES['dl_documents']['size']= $_FILES['dl_documents']['size'][$o];    
                    
                    $this->load->library('upload', $con);
					$this->upload->do_upload('dl_documents');
					$image_dl = $this->upload->data();
					$dl_documents = "uploads/cv/".$image_dl['file_name'];
					if($image_dl['file_name'] !== ''){
						$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('id') . "', document = '" . $this->db->escape_str($dl_documents) . "', doc_type = 'dl'");
					}
    			}
    		}
			
			if($_FILES['saudi_dl_documents']['name'][0] !== '' && count($_FILES['saudi_dl_documents']['tmp_name']) > 0){
				$con['upload_path']   = './uploads/cv/'; 
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
    			$image_count = count($_FILES['saudi_dl_documents']['name']);
    			for($o=0;$o<$image_count;$o++){
                    $_FILES['saudi_dl_documents']['name']= $_FILES['saudi_dl_documents']['name'][$o];
                    $_FILES['saudi_dl_documents']['type']= $_FILES['saudi_dl_documents']['type'][$o];
                    $_FILES['saudi_dl_documents']['tmp_name']= $_FILES['saudi_dl_documents']['tmp_name'][$o];
                    $_FILES['saudi_dl_documents']['error']= $_FILES['saudi_dl_documents']['error'][$o];
                    $_FILES['saudi_dl_documents']['size']= $_FILES['saudi_dl_documents']['size'][$o];    
                    
                    $this->load->library('upload', $con);
					$this->upload->do_upload('saudi_dl_documents');
					$image_saudi_dl = $this->upload->data();
					$saudi_dl_documents = "uploads/cv/".$image_saudi_dl['file_name'];
					if($image_saudi_dl['file_name'] !== ''){
						$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('id') . "', document = '" . $this->db->escape_str($saudi_dl_documents) . "', doc_type = 'saudi_dl'");
					}
    				
    			}
    		}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function uploadMedicalCertificate(){
		$this->db->trans_start();
		$query = $this->db->query("UPDATE master_cv SET medical_status = '" . $this->db->escape_str($this->input->post('medical_status')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('cv_id') . "'");
		if($query){
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
						$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('cv_id') . "', document = '" . $this->db->escape_str($attachments) . "', doc_type = 'medical'");
					}
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}

	function uploadCertificate(){
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
					$query = $this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('cv_id') . "', document = '" . $this->db->escape_str($attachments) . "', doc_type = '" . $this->db->escape_str($this->input->post('doc_type')) . "'");
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
		$a = "SELECT cv.*, pos.name as pos_name, ha.agency_code, ha.agency_name as hiring_agency_name FROM master_cv cv LEFT JOIN master_job_title pos ON (cv.applied_for = pos.id) LEFT JOIN hiring_agencies ha ON (cv.agency_name = ha.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (cv.first_name LIKE '%".$keyword."%' OR cv.middle_name LIKE '%".$keyword."%' OR cv.third_name LIKE '%".$keyword."%' OR cv.surname LIKE '%".$keyword."%' OR cv.cv_no LIKE '%".$keyword."%')";
            }
        }
		
		if($this->input->get('applied_for')) {
			$applied_for = $this->input->get('applied_for');
            if($applied_for != ''){
                $a .= " AND cv.applied_for = '" . $applied_for . "'";
            }
        }
		
		if($this->input->get('nationality')) {
			$nationality = $this->input->get('nationality');
            if($nationality != ''){
                $a .= " AND cv.nationality = '" . $nationality . "'";
            }
        }

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (cv.created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
        if($this->input->get('sponsor_id')) {
			$sponsor_id = $this->input->get('sponsor_id');
            if($sponsor_id != ''){
                $a .= " AND cv.sponsor_id = '" . $sponsor_id . "'";
            }
        }
        
		if($this->input->get('arrival_from') AND $this->input->get('arrival_to')){
			$a_from = $this->input->get('arrival_from');
			$a_to = $this->input->get('arrival_to');
			$f_to = date("Y-m-d", strtotime($a_to));
			if($a_from AND $a_to){
				$a .= " AND (cv.arrival_date BETWEEN '". date("Y-m-d", strtotime($a_from)) ."' AND '". $f_to ."')";
			}
		}
		
		if($this->input->get('cv_status')) {
			$cv_status = $this->input->get('cv_status');
            if($cv_status != ''){
                $a .= " AND cv.cv_status = '" . $cv_status . "'";
            }
        }

		if($this->input->get('interview_status')) {
			$interview_status = $this->input->get('interview_status');
            if($interview_status != ''){
                $a .= " AND cv.interview_status = '" . $interview_status . "'";
            }
        }
        
        if($this->input->get('agency_name')) {
			$agency_name = $this->input->get('agency_name');
            if($agency_name != ''){
                $a .= " AND cv.agency_name = '" . $agency_name . "'";
            }
        }
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%'";
		// }
// 		if(isset($_POST["order"])){             
// 			$a .= " ORDER BY cv.cv_no ". $_POST['order']['0']['dir'] ."";
// 		}  
//         else{  
// 			$a .= " ORDER BY cv.cv_no ASC";		   
//         }	
        $a .= " ORDER BY cv.cv_no DESC";	
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

	// public function get_data()
	// {
	// 	$a = "SELECT cv.*, pos.name as pos_name FROM master_cv cv LEFT JOIN master_job_title pos ON (cv.id = pos.id) WHERE 1=1";
	// 	$query = $this->db->query($a);  
    //     return $query->result();
	// }
	  
    function get_filtered_data(){
	   	$a = $this->make_query();
	   	if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (cv.first_name LIKE '%".$keyword."%' OR cv.middle_name LIKE '%".$keyword."%' OR cv.third_name LIKE '%".$keyword."%' OR cv.surname LIKE '%".$keyword."%' OR cv.cv_no LIKE '%".$keyword."%')";
			}
		}
		
		if($this->input->get('applied_for')) {
			$applied_for = $this->input->get('applied_for');
			if($applied_for != ''){
				$a .= " AND cv.applied_for = '" . $applied_for . "'";
			}
		}
		if($this->input->get('nationality')) {
			$nationality = $this->input->get('nationality');
            if($nationality != ''){
                $a .= " AND cv.nationality = '" . $nationality . "'";
            }
        }
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (cv.created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
        if($this->input->get('sponsor_id')) {
			$sponsor_id = $this->input->get('sponsor_id');
            if($sponsor_id != ''){
                $a .= " AND cv.sponsor_id = '" . $sponsor_id . "'";
            }
        }
        
		if($this->input->get('arrival_from') AND $this->input->get('arrival_to')){
			$a_from = $this->input->get('arrival_from');
			$a_to = $this->input->get('arrival_to');
			$f_to = date("Y-m-d", strtotime($a_to . ' +1 day'));
			if($a_from AND $a_to){
				$a .= " AND (cv.arrival_date BETWEEN '". date("Y-m-d", strtotime($a_from)) ."' AND '". $f_to ."')";
			}
		}
		
		if($this->input->get('cv_status')) {
			$cv_status = $this->input->get('cv_status');
			if($cv_status != ''){
				$a .= " AND cv.cv_status = '" . $cv_status . "'";
			}
		}

		if($this->input->get('interview_status')) {
			$interview_status = $this->input->get('interview_status');
			if($interview_status != ''){
				$a .= " AND cv.interview_status = '" . $interview_status . "'";
			}
		}
		if($this->input->get('agency_name')) {
			$agency_name = $this->input->get('agency_name');
            if($agency_name != ''){
                $a .= " AND cv.agency_name = '" . $agency_name . "'";
            }
        }
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_cv');  
	   return $this->db->count_all_results();
    }
	
	function get_borders_list(){
		$query = $this->db->query("SELECT ivs.instant_visa_id, ivs.border_nos, ivw.unified_no, ivw.sponsor_name FROM instant_visa_serials ivs LEFT JOIN instant_visa_work ivw ON (ivs.instant_visa_id = ivw.id) ORDER BY ivw.id DESC");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT cv.*, pos.name as pos_name, pos.arabic_name as pos_arabic_name, mn.name as nationality_name, mn.arabic_name as arabic_nationality FROM master_cv cv LEFT JOIN master_job_title pos ON (cv.applied_for = pos.id) LEFT JOIN master_nationality mn ON (cv.nationality = mn.name) WHERE cv.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_cv_docs($id){
	   $this->db->select("*");  
	   $this->db->from('upload_cv_doc');  
	   $this->db->where('cv_id', (int)$id);  
	   $query = $this->db->get();
	   return $query->result_array();
    }

	function get_backoffice_package($id){
		$this->db->select("*");  
		$this->db->from('master_cv_package');  
		$this->db->where('cv_id', (int)$id);  
		$query = $this->db->get();
		return $query->row_array();
	}

	function get_cv_families($id){
		$this->db->select("*");  
		$this->db->from('master_cv_contacts');  
		$this->db->where('cv_id', (int)$id);  
		$query = $this->db->get();
		return $query->result_array();
	 }

	function delete_image(){
		$id = $this->input->post('img_id');
		$cvid = $this->input->post('cv_id');
		$query = $this->db->query("DELETE FROM upload_cv_doc WHERE id = '" . (int)$id . "' AND cv_id = '". (int)$cvid ."' LIMIT 1");
		return $query;
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_cv WHERE id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM upload_cv_doc WHERE cv_id = '". $ids[$i] ."'");
			$this->db->query("DELETE FROM master_cv_contacts WHERE cv_id = '". $ids[$i] ."'");
			$this->db->query("DELETE FROM master_cv_package WHERE cv_id = '". $ids[$i] ."'");
		}
		return true;
	}

	function check_duplicate_passport($id, $passport_no){
		$this->db->select("*");  
		$this->db->from('master_cv'); 
		$this->db->where('id !=',$id);
		$this->db->where('passport_no =',$passport_no);
		return $this->db->count_all_results();  
	}

    /*----- Get Postions Using Hirign Type ----*/
    
    function cv_designations($position_type){
        $this->db->select("*");  
        $this->db->from('master_job_title');  
        $this->db->where('position_type',$position_type);  
        $this->db->order_by('name','ASC');  
        $query = $this->db->get();
        return $query->result();
    }
}
