<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incentives_model extends CI_Model{

	public function delete($id) {
        // Start transaction to ensure data consistency
        $this->db->trans_start();
    
        // Delete related slabs (commissions) first
        $this->db->where_in('incentive_id', explode(',', $id));
        $this->db->delete('incentive_range');
    
        // Delete the main incentive record
        $this->db->where_in('id', explode(',', $id));
        $this->db->delete('incentives');
    
        // Complete transaction
        $this->db->trans_complete();
    
        return $this->db->trans_status(); // Returns true if successful, false if failed
    }
    
	
	function get_incentives($id){
		$query = $this->db->query("SELECT * FROM incentives WHERE id = '" . $id . "'")->row();
		return $query;
	}
	
	function get_incentive_slabs($id){
		$query = $this->db->query("SELECT * FROM incentive_range WHERE incentive_id = '" . $id . "'")->result_array();
		return $query;
	}
	
	function make_query() {
		$a = "SELECT 
				incentives.*, 
				(
					SELECT COUNT(lr.id)
					FROM logistic_rider lr
					JOIN master_employee me ON lr.employee_id = me.id
					WHERE incentives.id = lr.incentive_id
					AND me.status = 'Active'
				) AS total_riders
			FROM incentives
			WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		$a .= " ORDER BY incentives.created_at DESC";		   
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
	   $this->db->from('incentives');  
	   return $this->db->count_all_results();
    }

	function get_incentive_employees($incentive_id){
		$query = $this->db->query("
			SELECT 
			lr.id_number,
			mli.id_type, 
			mli.request_date, 
			mli.activation_date, 
			mli.owner_id,
			me.emp_no, 
			me.full_name, 
			me.employee_arabic_name, 
			me.employee_pic, 
			me.iqama_no, 
			me.iqama_expiry_date, 
			me.nationality, 
			me.mobile, 
			me.passport_no, 
			me.designation, 
			me.status as emp_status,
			mv.id as vehicle_id, 
			mv.vehicle_type, 
			mv.vehicle_no, 
			mv.sequel_no, 
			fdc.company_name as food_company 
			FROM logistic_rider lr 
			LEFT JOIN master_logistic_ids mli ON (lr.id_number = mli.id_number)
			LEFT JOIN master_employee me ON (lr.employee_id = me.id) 
			LEFT JOIN food_deliv_companies fdc ON (lr.platform = fdc.id) 
			LEFT JOIN master_vehicles mv ON (lr.employee_id = mv.alloted_user) 
			WHERE lr.incentive_id = '" . $incentive_id . "' AND me.status = 'Active'")->result_array();
		return $query;
	}
	
	function print_incentive(){
		$a = "SELECT 
			incentives.*, 
			(
				SELECT COUNT(lr.id)
				FROM logistic_rider lr
				JOIN master_employee me ON lr.employee_id = me.id
				WHERE incentives.id = lr.incentive_id
				AND me.status = 'Active'
			) AS total_riders
		FROM incentives
		WHERE 1=1";
		$query = $this->db->query($a);  
        return $query->result();
	}
	
}

