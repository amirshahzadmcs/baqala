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
			agency_name = '" . (int)$this->agency->getId() . "', 
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
			nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			imo_available = '" . $this->db->escape_str($this->input->post('imo_available')) . "', 
			cv_status = 'new', 
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
			current_dl = '" . $this->db->escape_str($this->input->post('current_dl')) . "', 
			current_dl_expiry = '" . $this->db->escape_str($this->input->post('current_dl_expiry')) . "', 
			
			created_at = NOW(), 
			updated_at = now()");
		$insert_id = $this->db->insert_id();
		if($query){
			if($_FILES['documents']['name'][0] !== '' && count($_FILES['documents']['tmp_name']) > 0){
    			$image_count = count($_FILES['documents']['name']);
    			for($o=0;$o<$image_count;$o++){
                    $_FILES['documents']['name']= $_FILES['documents']['name'][$o];
                    $_FILES['documents']['type']= $_FILES['documents']['type'][$o];
                    $_FILES['documents']['tmp_name']= $_FILES['documents']['tmp_name'][$o];
                    $_FILES['documents']['error']= $_FILES['documents']['error'][$o];
                    $_FILES['documents']['size']= $_FILES['documents']['size'][$o];    
                    
                    $this->load->library('upload', $con);
					$this->upload->do_upload('documents');
					$image_da = $this->upload->data();
					$documents = "uploads/cv/".$image_da['file_name'];
    				$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$insert_id . "', document = '" . $this->db->escape_str($documents) . "', doc_type = 'others'");
    			}
    		}
			
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
			cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', 
			hiring_type = '" . $this->db->escape_str($this->input->post('hiring_type')) . "', 
			applicant_country = '" . $this->db->escape_str($this->input->post('applicant_country')) . "', 
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
			nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			imo_available = '" . $this->db->escape_str($this->input->post('imo_available')) . "', 
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
			current_dl = '" . $this->db->escape_str($this->input->post('current_dl')) . "', 
			current_dl_expiry = '" . $this->db->escape_str($this->input->post('current_dl_expiry')) . "', 
			
			updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "' AND agency_name = '" . (int)$this->agency->getId() . "'
		");
		if($query){
			if($_FILES['documents']['name'][0] !== '' && count($_FILES['documents']['tmp_name']) > 0){
				//print_r($_FILES['documents']);exit();
				$con['upload_path']   = './uploads/cv/'; 
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
    			$image_count = count($_FILES['documents']['name']);
    			for($o=0;$o<$image_count;$o++){
                    $_FILES['documents']['name']= $_FILES['documents']['name'][$o];
                    $_FILES['documents']['type']= $_FILES['documents']['type'][$o];
                    $_FILES['documents']['tmp_name']= $_FILES['documents']['tmp_name'][$o];
                    $_FILES['documents']['error']= $_FILES['documents']['error'][$o];
                    $_FILES['documents']['size']= $_FILES['documents']['size'][$o];    
                    
                    $this->load->library('upload', $con);
					$this->upload->do_upload('documents');
					$image_da = $this->upload->data();
					$documents = "uploads/cv/".$image_da['file_name'];
					if($image_da['file_name'] !== ''){
						$this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('id') . "', document = '" . $this->db->escape_str($documents) . "', doc_type = 'others'");
					}
    			}
    		}
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
		
		if($_FILES['attachments']['name'][0] !== '' && count($_FILES['attachments']['tmp_name']) > 0){
			//print_r($_FILES['documents']);exit();
			$con['upload_path']   = './uploads/cv/'; 
			$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
			$con['maintain_ratio'] = TRUE;
			$con['max_filename'] = '50';
			$con['encrypt_name'] = TRUE;
			$image_count = count($_FILES['attachments']['name']);
			$query = false;
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
					$query = $this->db->query("INSERT INTO upload_cv_doc SET cv_id = '" . (int)$this->input->post('cv_id') . "', document = '" . $this->db->escape_str($attachments) . "', doc_type = 'medical'");
				}
			}
			if($query){
				$this->db->query("UPDATE master_cv SET medical_status = 'received', updated_at = now() WHERE id = '" . (int)$this->input->post('cv_id') . "'");
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
			if($query){
				if($this->input->post('doc_type') == 'visa'){
					$this->db->query("UPDATE master_cv SET visa_status = 'received', updated_at = now() WHERE id = '" . (int)$this->input->post('cv_id') . "'");
				}elseif($this->input->post('doc_type') == 'offer_letter'){
					$this->db->query("UPDATE master_cv SET offer_letter_status = 'received', updated_at = now() WHERE id = '" . (int)$this->input->post('cv_id') . "'");
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
		$a = "SELECT cv.*, pos.name as pos_name FROM master_cv cv LEFT JOIN master_job_title pos ON (cv.applied_for = pos.id) WHERE cv.agency_name = '". (int)$this->agency->getId() ."'";
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

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (cv.created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
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
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND (cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%')";
		// }
		if(isset($_POST["order"])){             
			//$a .= " ORDER BY cv.first_name ". $_POST['order']['0']['dir'] ."";
			$a .= " ORDER BY cv.id DESC";	
		}  
        else{  
			$a .= " ORDER BY cv.id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_cv');  
	   $this->db->where('agency_name', (int)$this->agency->getId());  
	   return $this->db->count_all_results();
    }
	
	//Filters CV 
	function get_filter_list($page_name){
		$a = $this->make_query();
		if($page_name == 'new' || $page_name == 'shortlisted' || $page_name == 'not_qualified'){
			$a .= " AND cv.cv_status = '". $page_name ."'";
		}elseif($page_name == 'selected' || $page_name == 'rejected'){
			$a .= " AND cv.interview_status = '". $page_name ."'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND (cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%')";
		}
		if(isset($_POST["order"])){             
			//$a .= " ORDER BY cv.first_name ". $_POST['order']['0']['dir'] ."";
			$a .= " ORDER BY cv.id DESC";	
		}  
        else{  
			$a .= " ORDER BY cv.id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filter_cv_data($page_name){
		$a = $this->make_query();
		if($page_name == 'new' || $page_name == 'shortlisted' || $page_name == 'not_qualified'){
			$a .= " AND cv.cv_status = '". $page_name ."'";
		}elseif($page_name == 'selected' || $page_name == 'rejected'){
			$a .= " AND cv.interview_status = '". $page_name ."'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND (cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%')";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND (cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%')";
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_filter_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_cv');  
	   $this->db->where('agency_name', (int)$this->agency->getId());  
	   return $this->db->count_all_results();
    }
	 //End Filter

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_cv WHERE id = '" . $ids[$i] . "' AND agency_name = '". (int)$this->agency->getId() ."'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT cv.*, pos.name as pos_name FROM master_cv cv LEFT JOIN master_job_title pos ON (cv.applied_for = pos.id) WHERE cv.id = '" . (int)$id . "' AND agency_name = '". (int)$this->agency->getId() ."'");
		return $query->row();
	}
	
	function get_cv_docs($id){
	   $this->db->select("*");  
	   $this->db->from('upload_cv_doc');  
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

	function check_duplicate_passport($id, $passport_no){
		$this->db->select("*");  
		$this->db->from('master_cv'); 
		$this->db->where('id !=',$id);
		$this->db->where('passport_no =',$passport_no);
		return $this->db->count_all_results();  
	}
}
