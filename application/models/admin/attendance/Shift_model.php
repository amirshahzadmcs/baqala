<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shift_model extends CI_Model{

	function add(){
		$this->db->trans_start();
		if(count($this->input->post('week_days')) > 0){
			$days_array = $this->input->post('week_days');
			$array_keys = array_keys($days_array);
			$days = implode(', ', $array_keys);
		}else{
			$days = '';
		}
		//print_r($days);exit();
		
		$query = $this->db->query("INSERT INTO shifts SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', 
		type = '" . $this->db->escape_str($this->input->post('type')) . "', 
		week_days = '" . $this->db->escape_str($days) . "', 
		from_time = '" . $this->db->escape_str($this->input->post('from_time')) . "', 
		to_time = '" . $this->db->escape_str($this->input->post('to_time')) . "', 
		beginning_in = '" . $this->db->escape_str($this->input->post('beginning_in')) . "', 
		ending_in = '" . $this->db->escape_str($this->input->post('ending_in')) . "', 
		beginning_out = '" . $this->db->escape_str($this->input->post('beginning_out')) . "', 
		ending_out = '" . $this->db->escape_str($this->input->post('ending_out')) . "', 
		late_time = '" . $this->db->escape_str($this->input->post('late_time')) . "', 
		start_late_time_from_on_duty = '" . $this->db->escape_str($this->input->post('start_late_time_from_on_duty')) . "', 
		created_at = '". CURRENT_TIME ."', 
		updated_at = '". CURRENT_TIME ."'");
		
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		if(count($this->input->post('week_days')) > 0){
			$days_array = $this->input->post('week_days');
			$array_keys = array_keys($days_array);
			$days = implode(', ', $array_keys);
		}else{
			$days = '';
		}
		$query = $this->db->query("UPDATE shifts SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', 
		type = '" . $this->db->escape_str($this->input->post('type')) . "', 
		week_days = '" . $this->db->escape_str($days) . "', 
		from_time = '" . $this->db->escape_str($this->input->post('from_time')) . "', 
		to_time = '" . $this->db->escape_str($this->input->post('to_time')) . "', 
		beginning_in = '" . $this->db->escape_str($this->input->post('beginning_in')) . "', 
		ending_in = '" . $this->db->escape_str($this->input->post('ending_in')) . "', 
		beginning_out = '" . $this->db->escape_str($this->input->post('beginning_out')) . "', 
		ending_out = '" . $this->db->escape_str($this->input->post('ending_out')) . "', 
		late_time = '" . $this->db->escape_str($this->input->post('late_time')) . "', 
		start_late_time_from_on_duty = '" . $this->db->escape_str($this->input->post('start_late_time_from_on_duty')) . "', 
		updated_at = '". CURRENT_TIME ."' WHERE id = '". $this->input->post('id') ."'");
		
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM shifts WHERE id > 0";
		return $a;
	}
	
	function get_list($keyword){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%' OR type LIKE '%".$keyword."%')";
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
			$a .= " AND (name LIKE '%".$keyword."%' OR type LIKE '%".$keyword."%')";
		}
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('shifts');  
	   return $this->db->count_all_results();
    }
	
	function delete($id){
		if($id > 0){
			$query = $this->db->query("DELETE FROM shifts WHERE id = '" . $id . "'");
		}
		return $query;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM shifts WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function check_duplicate_title($id, $name){
		$this->db->select("*");  
		$this->db->from('shifts'); 
		$this->db->where('id !=',$id);
		$this->db->where('name =',$name);
		return $this->db->count_all_results();  
	}
}
