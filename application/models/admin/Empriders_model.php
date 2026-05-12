<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empriders_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO employed_riders SET 
		emp_id = '" . $this->db->escape_str($this->input->post('emp_id')) . "', 
		personal_mobile = '" . $this->db->escape_str($this->input->post('personal_mobile')) . "', 
		imei_no = '" . $this->db->escape_str($this->input->post('imei_no')) . "', 
		hunger_platform_id = '" . $this->db->escape_str($this->input->post('hunger_platform_id')) . "', 
		jahez_platform_id = '" . $this->db->escape_str($this->input->post('jahez_platform_id')) . "', 
		monthly_salary = '" . $this->db->escape_str($this->input->post('monthly_salary')) . "', 
		target_order = '" . $this->db->escape_str($this->input->post('target_order')) . "', 
		deduction_incentive = '" . $this->db->escape_str($this->input->post('deduction_incentive')) . "', 
		add_incentive = '" . $this->db->escape_str($this->input->post('add_incentive')) . "', 
		created_at = '" . CURRENT_TIME ."'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE employed_riders SET 
		personal_mobile = '" . $this->db->escape_str($this->input->post('personal_mobile')) . "', 
		imei_no = '" . $this->db->escape_str($this->input->post('imei_no')) . "', 
		hunger_platform_id = '" . $this->db->escape_str($this->input->post('hunger_platform_id')) . "', 
		jahez_platform_id = '" . $this->db->escape_str($this->input->post('jahez_platform_id')) . "',  
		monthly_salary = '" . $this->db->escape_str($this->input->post('monthly_salary')) . "', 
		target_order = '" . $this->db->escape_str($this->input->post('target_order')) . "', 
		deduction_incentive = '" . $this->db->escape_str($this->input->post('deduction_incentive')) . "', 
		add_incentive = '" . $this->db->escape_str($this->input->post('add_incentive')) . "', 
		updated_at = '" . CURRENT_TIME ."'
		WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT er.*, me.emp_no, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name, me.iqama_no, me.iqama_exp, mv.id as vehicle_id, mv.vehicle_type, mv.vehicle_no, mv.sequel_no, mv.vehicle_make, mv.vehicle_model, sc.mobile, sc.network, sc.plan FROM employed_riders er LEFT JOIN master_employee me ON (er.emp_id = me.id) LEFT JOIN sim_card sc ON (er.emp_id = sc.alloted_user) LEFT JOIN master_vehicles mv ON (er.emp_id = mv.alloted_user) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.first_name LIKE '%".$keyword."%' OR me.middle_name LIKE '%".$keyword."%' OR me.third_name LIKE '%".$keyword."%' OR me.surname LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
            }
        }
		
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($this->input->get('hunger_id')) {
			$hunger_id = $this->input->get('hunger_id');
            if($hunger_id != ''){
                $a .= " AND er.hunger_platform_id = '" . $hunger_id . "'";
            }
        }

		if($this->input->get('jahez_id')) {
			$jahez_id = $this->input->get('jahez_id');
            if($jahez_id != ''){
                $a .= " AND er.jahez_platform_id = '" . $jahez_id . "'";
            }
        }

		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%'";
		// }
		if(isset($_POST["order"])){             
			$a .= " ORDER BY me.first_name ". $_POST['order']['0']['dir'] ."";
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
                $a .= " AND (me.first_name LIKE '%".$keyword."%' OR me.middle_name LIKE '%".$keyword."%' OR me.third_name LIKE '%".$keyword."%' OR me.surname LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
            }
        }
		
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('hunger_id')) {
			$hunger_id = $this->input->get('hunger_id');
            if($hunger_id != ''){
                $a .= " AND er.hunger_platform_id = '" . $hunger_id . "'";
            }
        }

		if($this->input->get('jahez_id')) {
			$jahez_id = $this->input->get('jahez_id');
            if($jahez_id != ''){
                $a .= " AND er.jahez_platform_id = '" . $jahez_id . "'";
            }
        }
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('employed_riders');  
	   return $this->db->count_all_results();
    }
	
	function get_detail($id){
		$query = $this->db->query("SELECT er.*, me.emp_no, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name, me.employee_arabic_name, me.iqama_no, me.iqama_exp, me.nationality, me.passport_no, me.designation, mv.id as vehicle_id, mv.vehicle_type, mv.vehicle_no, mv.sequel_no, mv.vehicle_make, mv.vehicle_model, sc.mobile as company_mobile, sc.sim_no as company_sim_no, sc.network as sim_network, sc.plan as sim_plan FROM employed_riders er LEFT JOIN master_employee me ON (er.emp_id = me.id) LEFT JOIN sim_card sc ON (er.emp_id = sc.alloted_user) LEFT JOIN master_vehicles mv ON (er.emp_id = mv.alloted_user AND mv.allotment_status='alloted') WHERE er.id = '" . (int)$id . "'");
		return $query->row();
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
