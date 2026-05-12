<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendancelog_model extends CI_Model{

	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT er.*, me.emp_no, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name, me.iqama_no, me.iqama_exp, me.department, md.name as department_name, mjt.name as designation_name FROM employee_attendance er LEFT JOIN master_employee me ON (er.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND me.id = '" . $keyword . "'";
            }
        }
		
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }
        
		if($this->input->get('department')) {
			$department = $this->input->get('department');
            if($department != ''){
                $a .= " AND me.department = '" . $department . "'";
            }
        }
        
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.attendance_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if(isset($_POST["order"])){             
			$a .= " ORDER BY er.created_at DESC";
		}  
        else{  
			$a .= " ORDER BY er.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   	$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND me.id = '" . $keyword . "'";
            }
        }
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }
        if($this->input->get('department')) {
			$department = $this->input->get('department');
            if($department != ''){
                $a .= " AND me.department = '" . $department . "'";
            }
        }
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.attendance_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
    
    function print_log(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND me.id = '" . $keyword . "'";
            }
        }
		
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }
        
		if($this->input->get('department')) {
			$department = $this->input->get('department');
            if($department != ''){
                $a .= " AND me.department = '" . $department . "'";
            }
        }
        
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.attendance_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
        $a .= " ORDER BY er.created_at DESC";             
        $query = $this->db->query($a);  
        return $query->result();  
    }
    
	function get_detail($id){
		$query = $this->db->query("SELECT er.*, me.emp_no, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name, me.iqama_no, me.iqama_exp, me.department, md.name as department_name, mjt.name as designation_name FROM employee_attendance er LEFT JOIN master_employee me ON (er.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id)  WHERE er.id = '" . (int)$id . "'");
		return $query->row();
	}

    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('employee_attendance');  
	   return $this->db->count_all_results();
    }
	
	function check_duplicate_employee($id, $emp_id){
		$this->db->select("*");  
		$this->db->from('employed_riders'); 
		$this->db->where('id !=',$id);
		$this->db->where('emp_id =',$emp_id);
		return $this->db->count_all_results();  
	}
	
	public function get_emp_list()
	{
		$a = "SELECT me.*, me.emp_no, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name, mjt.name as pos_name FROM master_employee me LEFT JOIN master_job_title mjt ON (me.designation = mjt.id) WHERE (me.designation = '3' OR me.designation = '18') AND me.id NOT IN (SELECT emp_id FROM employed_riders WHERE 1=1)";
		$query = $this->db->query($a);
        return $query->result(); 
	}
}
