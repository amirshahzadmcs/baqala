<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave_model extends CI_Model{

	function add(){
		$this->db->trans_start();
		$query = $this->db->query("INSERT INTO leave_types SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', 
		color_code = '" . $this->db->escape_str($this->input->post('color_code')) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		description_ar = '" . $this->db->escape_str($this->input->post('description_ar')) . "', 
		days_allowed_per_year = '" . $this->db->escape_str($this->input->post('days_allowed_per_year')) . "', 
		continuous_days_applicable = '" . $this->db->escape_str($this->input->post('continuous_days_applicable')) . "', 
		applicable_after = '" . $this->db->escape_str($this->input->post('applicable_after')) . "', 
		need_permission = '" . $this->db->escape_str($this->input->post('need_permission')) . "', 
		created_at = '". CURRENT_TIME ."', 
		updated_at = '". CURRENT_TIME ."'");
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		$query = $this->db->query("UPDATE leave_types SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', 
		color_code = '" . $this->db->escape_str($this->input->post('color_code')) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		description_ar = '" . $this->db->escape_str($this->input->post('description_ar')) . "', 
		days_allowed_per_year = '" . $this->db->escape_str($this->input->post('days_allowed_per_year')) . "', 
		continuous_days_applicable = '" . $this->db->escape_str($this->input->post('continuous_days_applicable')) . "', 
		applicable_after = '" . $this->db->escape_str($this->input->post('applicable_after')) . "', 
		need_permission = '" . $this->db->escape_str($this->input->post('need_permission')) . "', 
		updated_at = '". CURRENT_TIME ."' WHERE id = '". $this->input->post('id') ."'");
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM leave_types WHERE id > 0";
		return $a;
	}
	
	function get_list($keyword){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%' OR id LIKE '%".$keyword."%')";
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

    function get_filtered_data($keyword){
	   	$a = $this->make_query();
	   	if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%' OR id LIKE '%".$keyword."%')";
		}
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('leave_types');  
	   return $this->db->count_all_results();
    }
	
	function delete($id){
		if($id > 0){
			$query = $this->db->query("DELETE FROM leave_types WHERE id = '" . $id . "'");
		}
		return $query;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM leave_types WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function check_duplicate_title($id, $name){
		$this->db->select("*");  
		$this->db->from('leave_types'); 
		$this->db->where('id !=',$id);
		$this->db->where('name =',$name);
		return $this->db->count_all_results();  
	}
}
