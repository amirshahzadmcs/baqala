<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_model extends CI_Model{
	
	function add(){
		$query = $this->db->query("INSERT agent SET  name = '" . $this->input->post('name') . "', email = '" . $this->input->post('email') . "', phone = '" . $this->input->post('phone') . "', account_no = '" . $this->input->post('account_no') . "', bank_name = '" . $this->input->post('bank_name') . "', ifsc = '" . $this->input->post('ifsc') . "', ref_code = '" . $this->input->post('ref_code') . "', updated_at = NOW(), status = '" . (int)$this->input->post('status') . "'");
		return $query;
	}
	
	function manage(){
		$query = $this->db->query("UPDATE agent SET name = '" . $this->input->post('name') . "', email = '" . $this->input->post('email') . "', phone = '" . $this->input->post('phone') . "', account_no = '" . $this->input->post('account_no') . "', bank_name = '" . $this->input->post('bank_name') . "', ifsc = '" . $this->input->post('ifsc') . "', ref_code = '" . $this->input->post('ref_code') . "', updated_at = NOW(), status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_customer($id){
		$query = $this->db->query("SELECT * FROM agent WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_address($id){
		$query = $this->db->query("SELECT * FROM address WHERE customer_id = '" . (int)$id . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM agent WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function make_query(){
     	$a = "SELECT * FROM agent WHERE 1 = 1";
	   return $a;
	}
	  
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
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
		$this->db->from('agent');  
		return $this->db->count_all_results();  
    }
    
    function getAgentCode(){
        $a = "SELECT `name`, `phone`, `ref_code` FROM `agent` WHERE `status` = '1'";
        $query = $this->db->query($a);  
        return $query->result();
	}
	
}
