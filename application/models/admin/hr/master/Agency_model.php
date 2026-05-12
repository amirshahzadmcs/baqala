<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agency_model extends CI_Model{
	function add($password){
		$created_at = CURRENT_TIME;
		$con['upload_path']   = './uploads/signed_contract/'; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
		
		if($_FILES['upload_signed_contract']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('upload_signed_contract');
			$image_da = $this->upload->data();
			$contract_image = "uploads/signed_contract/".$image_da['file_name'];
		}
		else{
			$contract_image = "";
		}
		$this->db->trans_start();
		$query = $this->db->query("INSERT INTO hiring_agencies SET 
		agency_name = '" . $this->db->escape_str($this->input->post('agency_name')) . "', 
		agency_name_ar = '" . $this->db->escape_str($this->input->post('agency_name_ar')) . "', 
		country_id = '" . $this->input->post('country_id') . "', 
		agency_city = '" . $this->db->escape_str($this->input->post('agency_city')) . "', 
		office_licence_no = '" . $this->db->escape_str($this->input->post('office_licence_no')) . "', 
		agreement_s_date = '" . $this->db->escape_str($this->input->post('agreement_s_date')) . "', 
		agreement_e_date = '" . $this->db->escape_str($this->input->post('agreement_e_date')) . "', 
		user_id = '" . $this->db->escape_str($this->input->post('user_id')) . "', 
		upload_signed_contract = '" . $this->db->escape_str($contract_image) . "', 
		contact_person_1 = '" . $this->db->escape_str($this->input->post('contact_person_1')) . "', 
		mobile_no_1 = '" . $this->db->escape_str($this->input->post('mobile_no_1')) . "', 
		email_id_1 = '" . $this->db->escape_str($this->input->post('email_id_1')) . "', 
		contact_person_2 = '" . $this->db->escape_str($this->input->post('contact_person_2')) . "', 
		mobile_no_2 = '" . $this->db->escape_str($this->input->post('mobile_no_2')) . "', 
		email_id_2 = '" . $this->db->escape_str($this->input->post('email_id_2')) . "', 
		account_name = '" . $this->db->escape_str($this->input->post('account_name')) . "', 
		bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', 
		account_no = '" . $this->db->escape_str($this->input->post('account_no')) . "', 
		ifsc_code = '" . $this->db->escape_str($this->input->post('ifsc_code')) . "', 
		swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', 
		bank_address = '" . $this->db->escape_str($this->input->post('bank_address')) . "', 
		password = '" . $password . "', 
		created_at = '" . $created_at . "', 
		ip = '" . $this->input->ip_address() . "', 
		status = '" . $this->input->post('status') . "'");
		$insert_id = $this->db->insert_id();
		if($query){
            $cust_account_no = $insert_id + 100;
		    $final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
		    $this->db->query("UPDATE hiring_agencies SET agency_code = '" . $final_account_no . "' WHERE id = '" . (int)$insert_id . "'");
        }
        $this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$updated_at = CURRENT_TIME;
		$con['upload_path']   = './uploads/signed_contract/'; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
		
		if($_FILES['upload_signed_contract']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('upload_signed_contract');
			$image_da = $this->upload->data();
			$contract_image = "uploads/signed_contract/".$image_da['file_name'];
		}
		else{
			$contract_image = $this->input->post('old_signed_contract');
		}
		$this->db->trans_start();
		$query = $this->db->query("UPDATE hiring_agencies SET 
		agency_name = '" . $this->db->escape_str($this->input->post('agency_name')) . "', 
		agency_name_ar = '" . $this->db->escape_str($this->input->post('agency_name_ar')) . "', 
		country_id = '" . $this->input->post('country_id') . "', 
		agency_city = '" . $this->db->escape_str($this->input->post('agency_city')) . "', 
		office_licence_no = '" . $this->db->escape_str($this->input->post('office_licence_no')) . "', 
		agreement_s_date = '" . $this->db->escape_str($this->input->post('agreement_s_date')) . "', 
		agreement_e_date = '" . $this->db->escape_str($this->input->post('agreement_e_date')) . "',
		upload_signed_contract = '" . $this->db->escape_str($contract_image) . "', 
		contact_person_1 = '" . $this->db->escape_str($this->input->post('contact_person_1')) . "', 
		mobile_no_1 = '" . $this->db->escape_str($this->input->post('mobile_no_1')) . "', 
		email_id_1 = '" . $this->db->escape_str($this->input->post('email_id_1')) . "', 
		contact_person_2 = '" . $this->db->escape_str($this->input->post('contact_person_2')) . "', 
		mobile_no_2 = '" . $this->db->escape_str($this->input->post('mobile_no_2')) . "', 
		email_id_2 = '" . $this->db->escape_str($this->input->post('email_id_2')) . "', 
		account_name = '" . $this->db->escape_str($this->input->post('account_name')) . "', 
		bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "', 
		account_no = '" . $this->db->escape_str($this->input->post('account_no')) . "', 
		ifsc_code = '" . $this->db->escape_str($this->input->post('ifsc_code')) . "', 
		swift_code = '" . $this->db->escape_str($this->input->post('swift_code')) . "', 
		bank_address = '" . $this->db->escape_str($this->input->post('bank_address')) . "', 
		updated_at = '" . $updated_at . "', 
		ip = '" . $this->input->ip_address() . "', 
		status = '" . $this->input->post('status') . "' 
		WHERE id = '" . (int)$this->input->post('id') . "'");
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT ha.*, mc.name as country_name FROM hiring_agencies ha LEFT JOIN master_country mc ON (ha.country_id = mc.id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND ha.agency_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY ha.agency_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY ha.agency_name ASC";		   
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
		$this->db->from('hiring_agencies');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM hiring_agencies WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM hiring_agencies WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	public function change_password($hashpassword)
    {
        //echo $this->input->post('status');exit();
        $query = $this->db->query("UPDATE hiring_agencies SET password = '" . $hashpassword . "', updated_at = NOW(), ip = '" . $this->input->ip_address() . "' WHERE id = '" . (int) $this->input->post('id') . "' LIMIT 1");
        return $query;
    }
}
