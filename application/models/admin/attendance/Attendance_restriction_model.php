<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_restriction_model extends CI_Model{

	function add(){
		$this->db->trans_start();
		$map = $this->input->post('map');
		$query = $this->db->query("INSERT INTO attendance_restrictions SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		is_allowed_ips = '" . $this->db->escape_str($this->input->post('is_allowed_ips')) . "', 
		ip_validation = '" . $this->db->escape_str($this->input->post('ip_validation')) . "', 
		allowed_ips = '" . preg_replace('/\s+/', '', $this->input->post('allowed_ips')) . "',
		is_location_restricted = '" . $this->db->escape_str($this->input->post('is_location_restricted')) . "', 
		location_validation = '" . $this->db->escape_str($this->input->post('location_validation')) . "', 
		map_location = '" . $this->db->escape_str($this->input->post('map_location')) . "', 
		longitude = '" . $this->db->escape_str($map['longitude']) . "', 
		latitude = '" . $this->db->escape_str($map['latitude']) . "', 
		place_id = '" . $this->db->escape_str($map['place_id']) . "', 
		location_range = '" . $this->db->escape_str($this->input->post('location_range')) . "', 
		range_unit = '" . $this->db->escape_str($this->input->post('range_unit')) . "', 
		is_photo_required = '" . $this->db->escape_str($this->input->post('is_photo_required')) . "', 
		photo_validation = '" . $this->db->escape_str($this->input->post('photo_validation')) . "', 
		created_at = '". CURRENT_TIME ."', 
		updated_at = '". CURRENT_TIME ."'");
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		$map = $this->input->post('map');
		$query = $this->db->query("UPDATE attendance_restrictions SET 
		name = '" . $this->db->escape_str($this->input->post('name')) . "', 
		status = '" . $this->db->escape_str($this->input->post('status')) . "', 
		is_allowed_ips = '" . $this->db->escape_str($this->input->post('is_allowed_ips')) . "', 
		ip_validation = '" . $this->db->escape_str($this->input->post('ip_validation')) . "', 
		allowed_ips = '" . preg_replace('/\s+/', '', $this->input->post('allowed_ips')) . "',
		is_location_restricted = '" . $this->db->escape_str($this->input->post('is_location_restricted')) . "', 
		location_validation = '" . $this->db->escape_str($this->input->post('location_validation')) . "', 
		map_location = '" . $this->db->escape_str($this->input->post('map_location')) . "', 
		longitude = '" . $this->db->escape_str($map['longitude']) . "', 
		latitude = '" . $this->db->escape_str($map['latitude']) . "', 
		place_id = '" . $this->db->escape_str($map['place_id']) . "', 
		location_range = '" . $this->db->escape_str($this->input->post('location_range')) . "', 
		range_unit = '" . $this->db->escape_str($this->input->post('range_unit')) . "', 
		is_photo_required = '" . $this->db->escape_str($this->input->post('is_photo_required')) . "', 
		photo_validation = '" . $this->db->escape_str($this->input->post('photo_validation')) . "', 
		updated_at = '". CURRENT_TIME ."' WHERE id = '". $this->input->post('id') ."'");
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM attendance_restrictions WHERE id > 0";
		return $a;
	}
	
	function get_list($keyword,$status){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (name LIKE '%".$keyword."%' OR id LIKE '%".$keyword."%')";
		}
		if($status){
			$a .= " AND status = '" . $status . "'";
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
			$a .= " AND (name LIKE '%".$keyword."%' OR id LIKE '%".$keyword."%')";
		}
		if($status){
			$a .= " AND status = '" . $status . "'";
		}
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('attendance_restrictions');  
	   return $this->db->count_all_results();
    }
	
	function delete($id){
		if($id > 0){
			$query = $this->db->query("DELETE FROM attendance_restrictions WHERE id = '" . $id . "'");
		}
		return $query;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM attendance_restrictions WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function check_duplicate_title($id, $name){
		$this->db->select("*");  
		$this->db->from('attendance_restrictions'); 
		$this->db->where('id !=',$id);
		$this->db->where('name =',$name);
		return $this->db->count_all_results();  
	}
}
