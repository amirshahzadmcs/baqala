<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instant_visa_model extends CI_Model{

	function add($attachment){
		$query = $this->db->query("INSERT INTO instant_visa_work SET 
		unified_no = '" . $this->input->post('unified_no') . "', 
		establishment_name = '" . $this->input->post('establishment_name') . "', 
		sponsor_name = '" . $this->input->post('sponsor_name') . "', 
		cr_no = '" . $this->input->post('cr_no') . "', 
		establishment_no = '" . $this->input->post('establishment_no') . "', 
		visa_issue_no = '" . $this->input->post('visa_issue_no') . "', 
		request_no = '" . $this->input->post('request_no') . "', 
		no_of_visa = '" . $this->input->post('no_of_visa') . "', 
		nationality = '" . $this->input->post('nationality') . "', 
		occupation = '" . $this->input->post('occupation') . "', 
		embassy = '" . $this->input->post('embassy') . "', 
		gender = '" . $this->input->post('gender') . "', 
		religion = '" . $this->input->post('religion') . "', 
		agency = '" . $this->input->post('agency') . "', 
		visa_country = '" . $this->input->post('visa_country') . "', 
		vstatus = '" . $this->input->post('vstatus') . "', 
		visa_issue_date = '" . $this->input->post('visa_issue_date') . "', 
		attachment = '" . $attachment . "', 
		created_at = '" . CURRENT_TIME . "'");
		$insert_id = $this->db->insert_id();
		if($query){
			return $insert_id;
		}else{
			return false;
		}
	}

	function edit($attachment){
		$query = $this->db->query("UPDATE instant_visa_work SET 
		unified_no = '" . $this->input->post('unified_no') . "', 
		establishment_name = '" . $this->input->post('establishment_name') . "', 
		sponsor_name = '" . $this->input->post('sponsor_name') . "', 
		cr_no = '" . $this->input->post('cr_no') . "', 
		establishment_no = '" . $this->input->post('establishment_no') . "', 
		visa_issue_no = '" . $this->input->post('visa_issue_no') . "', 
		request_no = '" . $this->input->post('request_no') . "', 
		nationality = '" . $this->input->post('nationality') . "', 
		occupation = '" . $this->input->post('occupation') . "', 
		embassy = '" . $this->input->post('embassy') . "', 
		gender = '" . $this->input->post('gender') . "', 
		religion = '" . $this->input->post('religion') . "', 
		agency = '" . $this->input->post('agency') . "', 
		visa_country = '" . $this->input->post('visa_country') . "', 
		vstatus = '" . $this->input->post('vstatus') . "', 
		visa_issue_date = '" . $this->input->post('visa_issue_date') . "', 
		attachment = '" . $attachment . "', 
		updated_at = now() WHERE id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM instant_visa_work WHERE id IN (" . $id . ")");
		if($query){
			$this->db->query("DELETE FROM instant_visa_serials WHERE instant_visa_id IN (" . $id . ")");
		}
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT 
			instant_visa_work.*, 
			master_nationality.name as nationality_name, 
			mp.profession_name, 
			ha.agency_name, 
			(
				SELECT COUNT(*)
				FROM master_cv mc
				WHERE EXISTS (
					SELECT 1
					FROM instant_visa_serials ivs
					WHERE ivs.instant_visa_id = instant_visa_work.id 
					AND ivs.border_nos = mc.border_entry_no
				)
			) AS used_border_entries 
			FROM instant_visa_work 
			LEFT JOIN master_nationality ON (instant_visa_work.nationality = master_nationality.id) 
			LEFT JOIN master_profession mp ON (instant_visa_work.occupation = mp.id) 
			LEFT JOIN hiring_agencies ha ON (instant_visa_work.agency = ha.id)
			WHERE instant_visa_work.id = '" . $id . "'
		");
		return $query;
	}

	function get_group_visas($id){
		$query = $this->db->query("SELECT ivs.*, mc.cv_no, IF (ivs.border_nos > 0, CONCAT_WS(' ', mc.first_name, mc.middle_name, mc.third_name, mc.surname), 'NA') full_name, mc.passport_no, mc.visa_status FROM instant_visa_serials ivs LEFT JOIN master_cv mc ON (ivs.border_nos = mc.border_entry_no) WHERE ivs.instant_visa_id = '" . $id . "'");
		return $query;
	}

	function make_query(){
		$a = "SELECT 
			ivw.*, 
			mn.name as nationality_name, 
			mp.profession_name, 
			ha.agency_name, 
			(
				SELECT COUNT(ivs.id) 
				FROM instant_visa_serials ivs 
				WHERE 
				ivs.instant_visa_id = ivw.id
			) as total_borders_entry,
			(
				SELECT COUNT(*)
				FROM master_cv mc
				WHERE EXISTS (
					SELECT 1
					FROM instant_visa_serials ivs
					WHERE ivs.instant_visa_id = ivw.id 
					AND ivs.border_nos = mc.border_entry_no
				)
			) AS used_border_entries 
			FROM instant_visa_work ivw LEFT JOIN master_nationality mn ON (ivw.nationality = mn.id) LEFT JOIN master_profession mp ON (ivw.occupation = mp.id) LEFT JOIN hiring_agencies ha ON (ivw.agency = ha.id) WHERE 1=1";
		return $a;
	}
	
	function get_list($unified_no,$keyword,$v_from,$v_to,$visa_issue_no,$nationality,$occupation,$embassy,$agency){
		$a = $this->make_query();
		if($keyword) {
			$a .= " AND (ivw.sponsor_name LIKE '%".$keyword."%')";
		}
		
		if($unified_no){
			$a .= " AND ivw.unified_no = '" . $unified_no . "'";
		}

		if($visa_issue_no){
			$a .= " AND ivw.visa_issue_no = '" . $visa_issue_no . "'";
		}

		if($v_from AND $v_to){
			$v_from = date("Y-m-d", strtotime($this->input->get('from')));
			$d_to = date("Y-m-d", strtotime($this->input->get('to') . ' +1 day'));
			$a .= " AND (ivw.visa_issue_date BETWEEN '". $v_from ."' AND '". $d_to ."')";
		}
		
		if($nationality){
			$a .= " AND ivw.nationality = '" . $nationality . "'";
		}

		if($occupation){
			$a .= " AND ivw.occupation = '" . $occupation . "'";
		}

		if($embassy) {
			$a .= " AND (ivw.embassy LIKE '%".$embassy."%')";
		}
		if($agency) {
			$a .= " AND (ivw.agency LIKE '%".$agency."%')";
		}
		$a .= " ORDER BY ivw.created_at DESC";		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($unified_no,$keyword,$v_from,$v_to,$visa_issue_no,$nationality,$occupation,$embassy,$agency){
	   $a = $this->make_query();
	   if($keyword) {
			$a .= " AND (ivw.sponsor_name LIKE '%".$keyword."%')";
		}
		
		if($unified_no){
			$a .= " AND ivw.unified_no = '" . $unified_no . "'";
		}

		if($visa_issue_no){
			$a .= " AND ivw.visa_issue_no = '" . $visa_issue_no . "'";
		}

		if($v_from AND $v_to){
			$v_from = date("Y-m-d", strtotime($this->input->get('from')));
			$d_to = date("Y-m-d", strtotime($this->input->get('to') . ' +1 day'));
			$a .= " AND (ivw.visa_issue_date BETWEEN '". $v_from ."' AND '". $d_to ."')";
		}
		
		if($nationality){
			$a .= " AND ivw.nationality = '" . $nationality . "'";
		}

		if($occupation){
			$a .= " AND ivw.occupation = '" . $occupation . "'";
		}

		if($embassy) {
			$a .= " AND (ivw.embassy LIKE '%".$embassy."%')";
		}
		if($agency) {
			$a .= " AND (ivw.agency LIKE '%".$agency."%')";
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('instant_visa_serials');  
	   return $this->db->count_all_results();
    }

	function check_duplicate_voucher($id, $visa_no){
		$this->db->select("*");  
		$this->db->from('instant_visa_serials'); 
		$this->db->where('id !=',$id);
		$this->db->where('visa_nos =',$visa_no);
		return $this->db->count_all_results();  
	}
	
	function get_unified_nos(){
		$this->db->distinct();
		$this->db->select("unified_no");  
		$this->db->from('instant_visa_work');  
		$query = $this->db->get();
		return $query->result();  
	}
	
	function get_sponsor_names(){
		$this->db->distinct();
		$this->db->select("sponsor_name");  
		$this->db->from('instant_visa_work');  
		$query = $this->db->get();
		return $query->result();  
	}
	
	function get_visa_issue_nos(){
		$this->db->distinct();
		$this->db->select("visa_issue_no");  
		$this->db->from('instant_visa_work');  
		$query = $this->db->get();
		return $query->result();  
	}
	
	function get_embassys(){
		$this->db->distinct();
		$this->db->select("embassy");  
		$this->db->from('instant_visa_work');  
		$query = $this->db->get();
		return $query->result();  
	}
}

