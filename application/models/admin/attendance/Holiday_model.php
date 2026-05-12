<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Holiday_model extends CI_Model{

	function add(){
		$this->db->trans_start();
		$query = $this->db->query("INSERT INTO holiday_list SET 
		group_title = '" . $this->db->escape_str($this->input->post('group_title')) . "', 
		group_title_ar = '" . $this->db->escape_str($this->input->post('group_title_ar')) . "', 
		created_at = '". CURRENT_TIME ."', 
		updated_at = '". CURRENT_TIME ."'");
		$insert_id = $this->db->insert_id();
		if($query){
			if($this->input->post('title')){
				$days_count = count($this->input->post('title'));
				for($r=0;$r<$days_count;$r++){
					$date_off = $this->input->post('date_off');
					$title = $this->input->post('title');
					$title_ar = $this->input->post('title_ar');
					$this->db->query("INSERT INTO holiday_days SET group_id = '" . (int)$insert_id . "', date_off = '" . $this->db->escape_str($date_off[$r]) . "', title = '" . $this->db->escape_str($title[$r]) . "', title_ar = '" . $this->db->escape_str($title_ar[$r]) . "', created_at = '". CURRENT_TIME ."'");
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$this->db->trans_start();
		$query = $this->db->query("UPDATE holiday_list SET 
		group_title = '" . $this->db->escape_str($this->input->post('group_title')) . "', 
		group_title_ar = '" . $this->db->escape_str($this->input->post('group_title_ar')) . "', 
		updated_at = '". CURRENT_TIME ."' WHERE id = '". $this->input->post('id') ."'");
		$insert_id = $this->input->post('id');
		if($query){
			$this->db->query("DELETE FROM holiday_days WHERE group_id = '" . (int)$insert_id . "'");
			if($this->input->post('title')){
				$days_count = count($this->input->post('title'));
				for($r=0;$r<$days_count;$r++){
					$date_off = $this->input->post('date_off');
					$title = $this->input->post('title');
					$title_ar = $this->input->post('title_ar');
					$this->db->query("INSERT INTO holiday_days SET group_id = '" . (int)$insert_id . "', date_off = '" . $this->db->escape_str($date_off[$r]) . "', title = '" . $this->db->escape_str($title[$r]) . "', title_ar = '" . $this->db->escape_str($title_ar[$r]) . "', created_at = '". CURRENT_TIME ."'");
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT hl.*, (select count(hd.group_id) from holiday_days hd where hl.id = hd.group_id) as total_days FROM holiday_list hl WHERE hl.id > 0";
		return $a;
	}
	
	function get_list($keyword){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (hl.group_title LIKE '%".$keyword."%' OR hl.id LIKE '%".$keyword."%')";
		}
		if(isset($_POST["order"])){
			$a .= " ORDER BY hl.group_title ". $_POST['order']['0']['dir'] ."";
		}
        else{
			$a .= " ORDER BY hl.id DESC";		   
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
			$a .= " AND (group_title LIKE '%".$keyword."%' OR id LIKE '%".$keyword."%')";
		}
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('holiday_list');  
	   return $this->db->count_all_results();
    }
	
	function delete($id){
		if($id > 0){
			$query = $this->db->query("DELETE FROM holiday_list WHERE id = '" . $id . "'");
			$this->db->query("DELETE FROM holiday_days WHERE group_id = '". (int)$id ."'");
		}
		return $query;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM holiday_list WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function get_holiday_days($id){
		$this->db->select("*");  
		$this->db->from('holiday_days');  
		$this->db->where('group_id', (int)$id);  
		$query = $this->db->get();
		return $query->result_array();
	}

	function check_duplicate_title($id, $group_title){
		$this->db->select("*");  
		$this->db->from('holiday_list'); 
		$this->db->where('id !=',$id);
		$this->db->where('group_title =',$group_title);
		return $this->db->count_all_results();  
	}
}
