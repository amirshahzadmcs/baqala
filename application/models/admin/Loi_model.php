<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loi_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_loi SET name = '" . $this->db->escape_str($this->input->post('name')) . "', cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', loi_no = '" . $this->db->escape_str($this->input->post('loi_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', open_date = '" . $this->db->escape_str($this->input->post('open_date')) . "', interview_date = '" . $this->db->escape_str($this->input->post('interview_date')) . "', joining_date = '" . $this->db->escape_str($this->input->post('joining_date')) . "', print_date = '" . $this->db->escape_str($this->input->post('print_date')) . "', valid_upto = '" . $this->db->escape_str($this->input->post('valid_upto')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_loi SET name = '" . $this->db->escape_str($this->input->post('name')) . "', cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', loi_no = '" . $this->db->escape_str($this->input->post('loi_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', open_date = '" . $this->db->escape_str($this->input->post('open_date')) . "', interview_date = '" . $this->db->escape_str($this->input->post('interview_date')) . "', joining_date = '" . $this->db->escape_str($this->input->post('joining_date')) . "', print_date = '" . $this->db->escape_str($this->input->post('print_date')) . "', valid_upto = '" . $this->db->escape_str($this->input->post('valid_upto')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT loi.*, cv.cv_no as cv_num FROM master_loi loi LEFT JOIN master_cv cv ON (loi.cv_no = cv.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND loi.name LIKE '%".$_POST["search"]["value"]."%' OR loi.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.cv_no LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY loi.name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY loi.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

	// public function get_data()
	// {
	// 	$a = "SELECT loi.*, pos.name as pos_name FROM master_loi loi LEFT JOIN master_job_title pos ON (loi.id = pos.id) WHERE 1=1";
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
	   $this->db->from('master_loi');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_loi WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT loi.*, cv.cv_no as cv_num, cv.dob, cv.state, ct.city_name as city, cv.address_1, cv.address_2, cv.address_3 FROM master_loi loi LEFT JOIN master_cv cv ON (loi.cv_no = cv.id) LEFT JOIN master_city ct ON (cv.city = ct.id) WHERE loi.id = '" . (int)$id . "'");
		return $query->row();
	}

	
}
