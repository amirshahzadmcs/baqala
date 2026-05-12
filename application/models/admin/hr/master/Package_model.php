<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_salary_packages SET 
		package_name = '" . $this->db->escape_str($this->input->post('package_name')) . "', 
		package_name_ar = '" . $this->db->escape_str($this->input->post('package_name_ar')) . "', 
		basic_salary = '" . $this->db->escape_str($this->input->post('basic_salary')) . "', 
		housing_allow = '" . $this->db->escape_str($this->input->post('housing_allow')) . "', 
		transportation_allow = '" . $this->db->escape_str($this->input->post('transportation_allow')) . "', 
		food_allow = '" . $this->db->escape_str($this->input->post('food_allow')) . "', 
		order_allowance = '" . $this->db->escape_str($this->input->post('order_allowance')) . "', 
		no_of_orders = '" . $this->db->escape_str($this->input->post('no_of_orders')) . "', 
		total_package = '" . $this->db->escape_str($this->input->post('total_package')) . "', 
		vacations = '" . $this->db->escape_str($this->input->post('vacations')) . "', 
		medical_insurance = '" . $this->db->escape_str($this->input->post('medical_insurance')) . "', 
		remarks = '" . $this->db->escape_str($this->input->post('remarks')) . "', 
		offer_validity = '" . $this->db->escape_str($this->input->post('offer_validity')) . "', 
		project_code = '" . $this->db->escape_str($this->input->post('project_code')) . "', 
		project_name = '" . $this->db->escape_str($this->input->post('project_name')) . "', 
		reporting_to = '" . $this->db->escape_str($this->input->post('reporting_to')) . "', 
		department = '" . $this->db->escape_str($this->input->post('department')) . "', 
		work_location = '" . $this->db->escape_str($this->input->post('work_location')) . "', 
		working_hrs = '" . $this->db->escape_str($this->input->post('working_hrs')) . "', 
		probation_period = '" . $this->db->escape_str($this->input->post('probation_period')) . "', 
		contract_period = '" . $this->db->escape_str($this->input->post('contract_period')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		created_at = '" . CURRENT_TIME . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_salary_packages SET 
		package_name = '" . $this->db->escape_str($this->input->post('package_name')) . "', 
		package_name_ar = '" . $this->db->escape_str($this->input->post('package_name_ar')) . "', 
		basic_salary = '" . $this->db->escape_str($this->input->post('basic_salary')) . "', 
		housing_allow = '" . $this->db->escape_str($this->input->post('housing_allow')) . "', 
		transportation_allow = '" . $this->db->escape_str($this->input->post('transportation_allow')) . "', 
		food_allow = '" . $this->db->escape_str($this->input->post('food_allow')) . "', 
		order_allowance = '" . $this->db->escape_str($this->input->post('order_allowance')) . "', 
		no_of_orders = '" . $this->db->escape_str($this->input->post('no_of_orders')) . "', 
		total_package = '" . $this->db->escape_str($this->input->post('total_package')) . "', 
		vacations = '" . $this->db->escape_str($this->input->post('vacations')) . "', 
		medical_insurance = '" . $this->db->escape_str($this->input->post('medical_insurance')) . "', 
		remarks = '" . $this->db->escape_str($this->input->post('remarks')) . "', 
		offer_validity = '" . $this->db->escape_str($this->input->post('offer_validity')) . "', 
		project_code = '" . $this->db->escape_str($this->input->post('project_code')) . "', 
		project_name = '" . $this->db->escape_str($this->input->post('project_name')) . "', 
		reporting_to = '" . $this->db->escape_str($this->input->post('reporting_to')) . "', 
		department = '" . $this->db->escape_str($this->input->post('department')) . "', 
		work_location = '" . $this->db->escape_str($this->input->post('work_location')) . "', 
		working_hrs = '" . $this->db->escape_str($this->input->post('working_hrs')) . "', 
		probation_period = '" . $this->db->escape_str($this->input->post('probation_period')) . "', 
		contract_period = '" . $this->db->escape_str($this->input->post('contract_period')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		updated_at = '" . CURRENT_TIME . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT msp.*, md.name as department_name, mjt.name as designation_name FROM master_salary_packages msp LEFT JOIN master_department md ON (msp.department = md.id) LEFT JOIN master_job_title mjt ON (msp.reporting_to = mjt.id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND msp.package_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		/*
		if(isset($_POST["order"])){             
			$a .= " ORDER BY msp.package_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY msp.package_name ASC";		   
		}*/
		$a .= " ORDER BY msp.created_at DESC";			
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
		$this->db->from('master_salary_packages');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_salary_packages WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_salary_packages WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
