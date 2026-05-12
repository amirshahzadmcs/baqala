<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sells_model extends CI_Model{
	
	function add(){
		$query = $this->db->query("INSERT INTO sells_man SET company_id = '". (int)$this->company->getId() ."', name = '" . $this->input->post('name') . "', email = '" . $this->input->post('email') . "', mobile = '" . $this->input->post('mobile') . "', updated_at = NOW(), password = '" . $this->db->escape_str(md5($this->input->post('password'))) . "', status = '" . (int)$this->input->post('status') . "'");
		return $query;
	}
	
	function manage(){
		$query = $this->db->query("UPDATE sells_man SET company_id = '". (int)$this->company->getId() ."', name = '" . $this->input->post('name') . "', email = '" . $this->input->post('email') . "', mobile = '" . $this->input->post('mobile') . "', updated_at = NOW(), status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "' AND company_id = '". (int)$this->company->getId() ."'");
		return $query;
	}
	
	function get_user($id){
		$query = $this->db->query("SELECT * FROM sells_man WHERE id = '" . (int)$id . "' AND company_id = '". (int)$this->company->getId() ."'");
		return $query;
	}

	function delete($id){
		$query = $this->db->query("DELETE FROM sells_man WHERE company_id = '". (int)$this->company->getId() ."' AND id IN (" . $id . ")");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM sells_man WHERE company_id = '". (int)$this->company->getId() ."'";
		return $a;
	}
	  
	function get_list(){
		$a = $this->make_query();      
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
	   $this->db->from('sells_man');  
	   $this->db->where('company_id', (int)$this->company->getId());  
	   return $this->db->count_all_results();  
	}
}
