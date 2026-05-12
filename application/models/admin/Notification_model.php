<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO notification SET title = '" . $this->db->escape_str($this->input->post('title')) . "', message = '" . $this->db->escape_str($this->input->post('message')) . "', ended_on = '" . $this->db->escape_str($this->input->post('ended_on')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE notification SET title = '" . $this->db->escape_str($this->input->post('title')) . "', message = '" . $this->db->escape_str($this->input->post('message')) . "', ended_on = '" . $this->db->escape_str($this->input->post('ended_on')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM notification WHERE 1 = 1";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM notification WHERE 1 = 1";
		if(isset($_POST["search"]["value"])){
			$a .= " AND title LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY title ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY created_at DESC";		   
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
		$this->db->from('notification');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM notification WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_notification_by_id($id){
		$query = $this->db->query("SELECT * FROM notification WHERE id = '" . (int)$id . "'");
		return $query;
	}

	/*---- B2B Notifications -----*/
	function quotation_noti($notification_message,$qcid,$qsid){
		$query = $this->db->query("INSERT INTO b2b_notification SET notification_text = '" . $this->db->escape_str($notification_message) . "', user_id = '" . (int)$this->db->escape_str($qcid) . "', staff_id = '" . (int)$this->db->escape_str($qsid) . "', status = 'unread', created_at = now()");
		return $query;
	}
}
