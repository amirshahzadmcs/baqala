<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_rooms SET camp_id = '" . $this->db->escape_str($this->input->post('camp_id')) . "', room_name = '" . $this->db->escape_str($this->input->post('room_name')) . "', room_name_ar = '" . $this->db->escape_str($this->input->post('room_name_ar')) . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_rooms SET camp_id = '" . $this->db->escape_str($this->input->post('camp_id')) . "', room_name = '" . $this->db->escape_str($this->input->post('room_name')) . "', room_name_ar = '" . $this->db->escape_str($this->input->post('room_name_ar')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT master_rooms.*, master_camp.camp_name FROM master_rooms LEFT JOIN master_camp ON (master_rooms.camp_id = master_camp.id) WHERE master_rooms.deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT master_rooms.*, master_camp.camp_name FROM master_rooms LEFT JOIN master_camp ON (master_rooms.camp_id = master_camp.id) WHERE master_rooms.deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND master_rooms.room_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY master_rooms.room_name ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY master_rooms.created_at DESC";		   
		}		   
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
		$this->db->from('master_rooms');  
		$this->db->where('deleted','0');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE master_rooms SET deleted = '1' WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM master_rooms WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
