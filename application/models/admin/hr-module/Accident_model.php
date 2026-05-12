<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accident_model extends CI_Model{

	public function save_accident_data($data) {
        // Insert data into the database
        $this->db->insert('accident_management', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }

	public function update_accident_data($id,$data) {
        // Update data into the database
		$this->db->where('id', $id);
        $this->db->update('accident_management', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

	function make_query($keyword,$vehicle_no,$insurance_provider){
		$a = "SELECT accident.*, emp.emp_no, emp.full_name as emp_full_name, emp.employee_arabic_name, emp.iqama_no, emp.nationality, mv.vehicle_type, mv.vehicle_no, mv.vehicle_make, mv.vehicle_model, mv.chassis_no FROM accident_management accident LEFT JOIN master_employee emp ON (accident.employee_id = emp.id) LEFT JOIN master_vehicles mv ON (accident.vehicle_id = mv.id) WHERE 1=1";
		if($keyword){
			$a .= " AND (emp.full_name LIKE '%".$keyword."%' OR emp.iqama_no LIKE '%".$keyword."%')";
		}
		if($vehicle_no){
			$a .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
		}
		if($insurance_provider){
			$a .= " AND accident.insurance_provider = '" . $insurance_provider . "'";
		}
		return $a;
	}

	function get_list($keyword,$vehicle_no,$insurance_provider){
		$a = $this->make_query($keyword,$vehicle_no,$insurance_provider);
		if(isset($_POST["order"])){
			$a .= " ORDER BY accident.id DESC";
		}
        else{
			$a .= " ORDER BY accident.accident_date DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$vehicle_no,$insurance_provider){
	   $a = $this->make_query($keyword,$vehicle_no,$insurance_provider);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('accident_management');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->select('attach_hhdr_report, attach_da_final_report, attach_maroor_report');
			$this->db->from('accident_management');
			$this->db->where('id', $ids[$i]);
			$images = $this->db->get()->row();
			$query = $this->db->query("DELETE FROM accident_management WHERE id = '" . $ids[$i] . "'");
			if ($query) {
				if ($query && file_exists($images->attach_hhdr_report)) {
					// Unlink (delete) the image file
					if (unlink($images->attach_hhdr_report));
				}
				if ($query && file_exists($images->attach_da_final_report)) {
					// Unlink (delete) the image file
					if (unlink($images->attach_da_final_report));
				}
				if ($query && file_exists($images->attach_maroor_report)) {
					// Unlink (delete) the image file
					if (unlink($images->attach_maroor_report));
				}
			}
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM accident_management WHERE id = '" . (int)$id . "'");
		return $query;
	}

	function get_emp_info($id){
		$query = $this->db->query("SELECT master_employee_info.* FROM master_employee_info WHERE master_employee_info.employee_id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function employeewise_accident_log($empid){
		$query = $this->db->query("SELECT accident.*, mv.vehicle_type, mv.vehicle_no, mv.vehicle_make, mv.vehicle_model, mv.chassis_no, mvk.make_name FROM accident_management accident LEFT JOIN master_vehicles mv ON (accident.vehicle_id = mv.id) LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE accident.employee_id = '" . (int)$empid . "'");
		return $query->result_array();
	}
	
}
