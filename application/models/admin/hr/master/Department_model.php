<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_department SET name = '" . $this->db->escape_str($this->input->post('name')) . "', name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', abbreviation = '" . $this->db->escape_str($this->input->post('abbreviation')) . "', abbreviation_ar = '" . $this->db->escape_str($this->input->post('abbreviation_ar')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', assigned_manager = '" . $this->db->escape_str($this->input->post('assigned_manager')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_department SET name = '" . $this->db->escape_str($this->input->post('name')) . "', name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', abbreviation = '" . $this->db->escape_str($this->input->post('abbreviation')) . "', abbreviation_ar = '" . $this->db->escape_str($this->input->post('abbreviation_ar')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', assigned_manager = '" . $this->db->escape_str($this->input->post('assigned_manager')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT md.*, emp.full_name as manager_name, (select count(me.id) from master_employee me where (md.id = me.department AND me.status = 'Active')) as total_employee FROM master_department md LEFT JOIN master_employee emp ON (md.assigned_manager = emp.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('title')) {
			$title = $this->input->get('title');
            if($title != ''){
                $a .= " AND (md.name LIKE '%". $title ."%' OR md.abbreviation LIKE '%". $title ."%' OR md.name_ar LIKE '%". $title ."%')";
            }
        }

		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status != ''){
                $a .= " AND `md.status` = '" . $status . "'";
            }
        }
		if(isset($_POST["order"])){             
			$a .= " ORDER BY md.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY md.name ASC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   $a = $this->make_query();
	   if($this->input->get('title')) {
			$title = $this->input->get('title');
			if($title != ''){
				$a .= " AND (md.name LIKE '%". $title ."%' OR md.abbreviation LIKE '%". $title ."%' OR md.name_ar LIKE '%". $title ."%')";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND `md.status` = '" . $status . "'";
			}
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_department');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_department WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_department WHERE id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}

	function getDeptEmpList($dept_id){
		$query = $this->db->query("
			SELECT 
				me.id,
				me.full_name, 
				me.emp_no, 
				me.employee_arabic_name,
				me.employee_pic,
				me.iqama_no,
				me.email,
				me.passport_no,
				me.status as emp_status,
				mei.insurance_policy_no,
				mei.insurance_issue_date,
				mei.insurance_end_date,
				mn.name as nationality_name,
				mjt.name as designation_name
			FROM master_employee me 
			LEFT JOIN master_employee_info mei ON me.id = mei.employee_id 
			LEFT JOIN master_nationality mn ON me.nationality = mn.id 
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id 
			WHERE me.status = 'Active' AND me.department = ?
		", [$dept_id]);
	
		return $query->result_array();
	}	
}
