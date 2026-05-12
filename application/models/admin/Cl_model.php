<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cl_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO contract_letter SET name = '" . $this->db->escape_str($this->input->post('name')) . "', cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', loi_no = '" . $this->db->escape_str($this->input->post('loi_no')) . "', contract_no = '" . $this->db->escape_str($this->input->post('contract_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', open_date = '" . $this->db->escape_str($this->input->post('open_date')) . "', dob = '" . $this->db->escape_str($this->input->post('dob')) . "', age = '" . $this->db->escape_str($this->input->post('age')) . "', print_date = '" . $this->db->escape_str($this->input->post('print_date')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', state = '" . $this->db->escape_str($this->input->post('state')) . "', employer_name = '" . $this->db->escape_str($this->input->post('employer_name')) . "', employer_position = '" . $this->db->escape_str($this->input->post('employer_position')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE contract_letter SET name = '" . $this->db->escape_str($this->input->post('name')) . "', cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', loi_no = '" . $this->db->escape_str($this->input->post('loi_no')) . "', contract_no = '" . $this->db->escape_str($this->input->post('contract_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', open_date = '" . $this->db->escape_str($this->input->post('open_date')) . "', dob = '" . $this->db->escape_str($this->input->post('dob')) . "', age = '" . $this->db->escape_str($this->input->post('age')) . "', print_date = '" . $this->db->escape_str($this->input->post('print_date')) . "', city = '" . $this->db->escape_str($this->input->post('city')) . "', state = '" . $this->db->escape_str($this->input->post('state')) . "', employer_name = '" . $this->db->escape_str($this->input->post('employer_name')) . "', employer_position = '" . $this->db->escape_str($this->input->post('employer_position')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT cl.*, loi.loi_no as loi_num FROM contract_letter cl LEFT JOIN master_loi loi ON (cl.loi_no = loi.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND cl.name LIKE '%".$_POST["search"]["value"]."%' OR cl.mobile LIKE '%".$_POST["search"]["value"]."%' OR loi.loi_no LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY cl.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY cl.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

	// public function get_data()
	// {
	// 	$a = "SELECT loi.*, pos.name as pos_name FROM contract_letter loi LEFT JOIN master_job_title pos ON (loi.id = pos.id) WHERE 1=1";
	// 	$query = $this->db->query($a);  
    //     return $query->result();
	// }
	  
    function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('contract_letter');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM contract_letter WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT cl.*, loi.loi_no as loi_num, cv.cv_no as cv_num FROM contract_letter cl LEFT JOIN master_loi loi ON (cl.loi_no = loi.id) LEFT JOIN master_cv cv ON (loi.cv_no = cv.id) WHERE cl.id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}

	
}
