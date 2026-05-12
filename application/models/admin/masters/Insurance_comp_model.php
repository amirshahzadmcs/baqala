<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insurance_comp_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_insurance_company SET company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', company_name_ar = '" . $this->db->escape_str($this->input->post('company_name_ar')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_insurance_company SET company_name = '" . $this->db->escape_str($this->input->post('company_name')) . "', company_name_ar = '" . $this->db->escape_str($this->input->post('company_name_ar')) . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT mic.*, (select count(id) from master_insurance_policies mip where mic.id = mip.policy_company) as total_policies FROM master_insurance_company mic WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND mic.company_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY mic.company_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY mic.company_name ASC";		   
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
		$this->db->from('master_insurance_company');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_insurance_company WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_insurance_company WHERE id = '" . (int)$id . "'");
		return $query;
	}

	public function company_list() {
        $query = $this->db->get('master_insurance_company');
        return $query->result(); // Returns an array of objects
    }
}
