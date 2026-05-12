<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leavepolicy_model extends CI_Model{

	function add(){
		$this->db->trans_start();
		if(count($this->input->post('leave_types')) > 0){
			$leave_types_array = $this->input->post('leave_types');
			$leave_types = implode(', ', $leave_types_array);
		}else{
			$leave_types = '';
		}
		//print_r($days);exit();
		
		$query = $this->db->query("INSERT INTO leave_policies SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		leave_types = '" . $this->db->escape_str($leave_types) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		description_ar = '" . $this->db->escape_str($this->input->post('description_ar')) . "', 
		created_at = '". CURRENT_TIME ."', 
		updated_at = '". CURRENT_TIME ."'");
		
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		if(count($this->input->post('leave_types')) > 0){
			$leave_types_array = $this->input->post('leave_types');
			$leave_types = implode(', ', $leave_types_array);
		}else{
			$leave_types = '';
		}
		$query = $this->db->query("UPDATE leave_policies SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		leave_types = '" . $this->db->escape_str($leave_types) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		description_ar = '" . $this->db->escape_str($this->input->post('description_ar')) . "', 
		updated_at = '". CURRENT_TIME ."' WHERE id = '". $this->input->post('id') ."'");
		
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM leave_policies WHERE id > 0";
		return $a;
	}
	
	function get_list($keyword,$status){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%')";
		}
		if($status){
			$a .= " AND (status = '".$status."')";
		}
		if(isset($_POST["order"])){
			$a .= " ORDER BY name ". $_POST['order']['0']['dir'] ."";
		}
        else{
			$a .= " ORDER BY id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$status){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%')";
		}
		if($status){
			$a .= " AND (status = '".$status."')";
		}
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('leave_policies');  
	   return $this->db->count_all_results();
    }
	
	function delete($id){
		if($id > 0){
			$query = $this->db->query("DELETE FROM leave_policies WHERE id = '" . $id . "'");
		}
		return $query;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM leave_policies WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function check_duplicate_title($id, $name){
		$this->db->select("*");  
		$this->db->from('leave_policies'); 
		$this->db->where('id !=',$id);
		$this->db->where('name =',$name);
		return $this->db->count_all_results();  
	}
	
	function leave_types(){
	   $this->db->select("*");  
	   $this->db->from('leave_types');  
	   $query = $this->db->get();
       return $query->result_array();
    }
}
