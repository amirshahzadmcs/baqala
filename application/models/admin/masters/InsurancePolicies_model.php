<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class InsurancePolicies_model extends CI_Model{

	public function insert_policy($data) {
		$query = $this->db->insert('master_insurance_policies', $data);
		return $query;
	}
	
	public function update_policy($id, $data) {
		$this->db->where('id', $id);
		$query = $this->db->update('master_insurance_policies', $data);
		return $query;
	}

	function make_query(){
		$a = "SELECT 
				mip.*, 
				mic.company_name, 
				CASE 
					WHEN mip.policy_type = 'Employee' THEN (SELECT COUNT(*) FROM master_employee_info mei WHERE mei.insurance_policy_no = mip.id)
					WHEN mip.policy_type = 'Vehicles' THEN (SELECT COUNT(*) FROM master_vehicles mv WHERE mv.insurance_no = mip.id)
					ELSE 0
				END AS used_policies_count 
			  FROM master_insurance_policies mip 
			  LEFT JOIN master_insurance_company mic ON mip.policy_company = mic.id 
			  WHERE 1=1";
		return $a;
	}	

	function get_list(){
		$a = $this->make_query();
		
		// Search functionality
		if(isset($_POST["search"]["value"])){
			$a .= " AND mip.policy_number LIKE '%".$_POST["search"]["value"]."%'";
		}
	
		// Ordering logic
		if(isset($_POST["order"])){             
			$a .= " ORDER BY mip.policy_number ". $_POST['order']['0']['dir'] ."";
		} else {  
			$a .= " ORDER BY mip.id DESC";		   
		}
	
		// Pagination logic
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
		$this->db->from('master_insurance_policies');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM master_insurance_policies WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT mip.*, mic.company_name FROM master_insurance_policies mip LEFT JOIN master_insurance_company mic ON (mip.policy_company = mic.id) WHERE mip.id = '" . (int)$id . "'");
		return $query;
	}
	
	function getPolicyAllotments($id, $type) {
		if ($type === 'Employee') {
			$query = $this->db->query("
				SELECT 
					mei.employee_id,
					me.full_name, 
					me.emp_no, 
					me.employee_arabic_name,
					me.employee_pic,
					me.iqama_no,
					me.email,
					me.status as emp_status,
					mei.insurance_policy_no,
					mei.insurance_issue_date,
					mei.insurance_end_date
				FROM master_employee_info mei
				LEFT JOIN master_employee me ON mei.employee_id = me.id
				WHERE mei.insurance_policy_no = ? 
			", [$id]); // Using parameter binding
		} else {
			$query = $this->db->query("
				SELECT 
					mv.id,
					mv.vehicle_no, 
					mv.vehicle_type, 
					mv.vehicle_make,
					mv.vehicle_model,
					mv.vehicle_year,
					mv.insurance_no,
					mv.insurance_issue_date,
					mv.insurance_expiry,
					mv.status,
					mv.sequel_no,
					mvm.make_name,
					me.full_name as alloted_employee, 
					me.emp_no as alloted_employee_no 
				FROM master_vehicles mv 
				LEFT JOIN mater_van_make mvm ON mv.vehicle_make = mvm.id 
				LEFT JOIN master_employee me ON mv.alloted_user = me.id 
				WHERE mv.insurance_no = ? 
			", [$id]); // Using parameter binding
		}
	
		return $query->result_array();
	}

}
