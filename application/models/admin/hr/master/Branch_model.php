<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_branch SET branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', branch_name_ar = '" . $this->db->escape_str($this->input->post('branch_name_ar')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_branch SET branch_name = '" . $this->db->escape_str($this->input->post('branch_name')) . "', branch_name_ar = '" . $this->db->escape_str($this->input->post('branch_name_ar')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT * FROM master_branch WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('title')) {
			$title = $this->input->get('title');
            if($title != ''){
                $a .= " AND (branch_name LIKE '%". $title ."%' OR branch_name_ar LIKE '%". $title ."%')";
            }
        }

		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status != ''){
                $a .= " AND `status` = '" . $status . "'";
            }
        }
		if(isset($_POST["order"])){             
			$a .= " ORDER BY branch_name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY branch_name ASC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   $a = $this->make_query();
	   if($this->input->get('title')) {
			$title = $this->input->get('title');
			if($title != ''){
				$a .= " AND (branch_name LIKE '%". $title ."%' OR branch_name_ar LIKE '%". $title ."%')";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND `status` = '" . $status . "'";
			}
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_branch');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_branch WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_branch WHERE id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}
	
}
