<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MajorStream_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO major_main_stream SET stream_name = '" . $this->db->escape_str($this->input->post('stream_name')) . "', stream_name_ar = '" . $this->db->escape_str($this->input->post('stream_name_ar')) . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE major_main_stream SET stream_name = '" . $this->db->escape_str($this->input->post('stream_name')) . "', stream_name_ar = '" . $this->db->escape_str($this->input->post('stream_name_ar')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM major_main_stream WHERE deleted = '0'";
		return $a;
	}

	function get_list(){
		$a = "SELECT * FROM major_main_stream WHERE deleted = '0'";
		if(isset($_POST["search"]["value"])){
			$a .= " AND stream_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY stream_name ". $_POST['order']['0']['dir'] ."";
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
		$this->db->from('major_main_stream');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE major_main_stream SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM major_main_stream WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
