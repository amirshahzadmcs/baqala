<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ol_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO offer_letter SET name = '" . $this->db->escape_str($this->input->post('name')) . "', cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', loi_no = '" . $this->db->escape_str($this->input->post('loi_no')) . "', offer_no = '" . $this->db->escape_str($this->input->post('offer_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', open_date = '" . $this->db->escape_str($this->input->post('open_date')) . "', address_1 = '" . $this->db->escape_str($this->input->post('address_1')) . "', address_2 = '" . $this->db->escape_str($this->input->post('address_2')) . "', address_3 = '" . $this->db->escape_str($this->input->post('address_3')) . "', ctc = '" . $this->db->escape_str($this->input->post('ctc')) . "', ctc_word = '" . $this->db->escape_str($this->input->post('ctc_word')) . "', joining_date = '" . $this->db->escape_str($this->input->post('joining_date')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE offer_letter SET name = '" . $this->db->escape_str($this->input->post('name')) . "', cv_no = '" . $this->db->escape_str($this->input->post('cv_no')) . "', loi_no = '" . $this->db->escape_str($this->input->post('loi_no')) . "', offer_no = '" . $this->db->escape_str($this->input->post('offer_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', position = '" . $this->db->escape_str($this->input->post('position')) . "', iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', open_date = '" . $this->db->escape_str($this->input->post('open_date')) . "', address_1 = '" . $this->db->escape_str($this->input->post('address_1')) . "', address_2 = '" . $this->db->escape_str($this->input->post('address_2')) . "', address_3 = '" . $this->db->escape_str($this->input->post('address_3')) . "', ctc = '" . $this->db->escape_str($this->input->post('ctc')) . "', ctc_word = '" . $this->db->escape_str($this->input->post('ctc_word')) . "', joining_date = '" . $this->db->escape_str($this->input->post('joining_date')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT cl.*, loi.loi_no as loi_num FROM offer_letter cl LEFT JOIN master_loi loi ON (cl.loi_no = loi.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND cl.name LIKE '%".$_POST["search"]["value"]."%' OR cl.mobile LIKE '%".$_POST["search"]["value"]."%' OR loi.loi_no LIKE '%".$_POST["search"]["value"]."%' OR cl.cv_no LIKE '%".$_POST["search"]["value"]."%'";
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
	// 	$a = "SELECT loi.*, pos.name as pos_name FROM offer_letter loi LEFT JOIN master_job_title pos ON (loi.id = pos.id) WHERE 1=1";
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
	   $this->db->from('offer_letter');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM offer_letter WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT cl.*, loi.loi_no as loi_num, cv.cv_no as cv_num FROM offer_letter cl LEFT JOIN master_loi loi ON (cl.loi_no = loi.id) LEFT JOIN master_cv cv ON (loi.cv_no = cv.id) WHERE cl.id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}
    
    public function get_offer_detail($id)
	{
		$query = $this->db->query("SELECT cl.*, emp.housing_allow, emp.food_allow, emp.basic_pay, emp.food_allow, emp.petrol_allow, emp.mobile_allow, emp.add_allow, cv.nationality, loi.joining_date FROM offer_letter cl LEFT JOIN master_loi loi ON (cl.loi_no = loi.id) LEFT JOIN master_cv cv ON (loi.cv_no = cv.id) LEFT JOIN master_employee emp ON (emp.cv_no = cv.id) WHERE cl.id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}
	
}
