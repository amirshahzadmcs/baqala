<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sponsor_model extends CI_Model{

	function save($data){
		$this->db->insert('sponsors', $data);
        return $this->db->insert_id();
	}
	
	function update($id,$data){
		$this->db->where('id', $id);
        $this->db->update('sponsors', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	public function get_all_sponsors() {
        $this->db->select('*');
        $this->db->from('sponsors');
        return $this->db->get()->result();
    }
	
	function make_query() {
		$a = "SELECT 
				sponsors.*, 
				(
					SELECT COUNT(me.id)
					FROM master_employee me
					WHERE sponsors.id = me.sponsor_id
					AND me.status = 'Active'
				) AS total_riders
			FROM sponsors
			WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND (employer_id LIKE '%".$_POST["search"]["value"]."%' OR employer_name LIKE '%".$_POST["search"]["value"]."%' OR employer_cr_no LIKE '%".$_POST["search"]["value"]."%')";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY employer_id ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY employer_id ASC";		   
		}		   
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}        
		$query = $this->db->query($a);  
		return $query->result();  
	}

	function get_filtered_data(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND (employer_id LIKE '%".$_POST["search"]["value"]."%' OR employer_name LIKE '%".$_POST["search"]["value"]."%' OR employer_cr_no LIKE '%".$_POST["search"]["value"]."%')";
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('sponsors');  
		return $this->db->count_all_results();  
	}

	function get_sponsors_employees($sponsor_id){
		$query = $this->db->query("
			SELECT 
			me.emp_no, 
			me.full_name, 
			me.employee_arabic_name, 
			me.employee_pic, 
			me.iqama_no, 
			me.iqama_expiry_date, 
			me.nationality, 
			me.mobile, 
			me.passport_no, 
			me.designation, 
			me.status as emp_status 
			FROM master_employee me
			WHERE me.sponsor_id = '" . $sponsor_id . "' AND me.status = 'Active'")->result_array();
		return $query;
	}
	
	function delete($ids){
		if (is_array($ids)) {
			$ids = implode(',', array_map('intval', $ids));
		}
		$query = $this->db->query("DELETE FROM sponsors WHERE id IN ($ids)");
		return $query;
	}
	
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM sponsors WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
