<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Job_title_model extends CI_Model{

	public function insert_designation($data) {
        return $this->db->insert('master_job_title', $data);
    }

    public function update_designation($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('master_job_title', $data);
    }
	
	function make_query() {
		$a = "SELECT mjt.id, 
					 mjt.name, 
					 mjt.arabic_name, 
					 mjt.description, 
					 mjt.position_type, 
					 mjt.status, 
					 mjt.created_at, 
					 mjt.updated_at, 
					 mjt.department_id,
					 (SELECT COUNT(me.id) 
					  FROM master_employee me 
					  WHERE me.designation = mjt.id) AS employee_count
			  FROM master_job_title mjt 
			  WHERE 1=1";
		return $a;
	}			
	
	function get_list() {
		$a = $this->make_query();
	
		if ($this->input->get('title')) {
			$title = $this->input->get('title');
			if ($title != '') {
				$a .= " AND (mjt.name LIKE '%" . $title . "%' OR mjt.arabic_name LIKE '%" . $title . "%')";
			}
		}
	
		if ($this->input->get('status')) {
			$status = $this->input->get('status');
			if ($status != '') {
				$a .= " AND mjt.status = '" . $status . "'";
			}
		}
	
		$a .= " ORDER BY mjt.name ASC";
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        } 
		$query = $this->db->query($a);  
		$results = $query->result();
	
		// Fetch department names
		$this->db->select('id, name');
		$this->db->from('master_department');
		$departments = $this->db->get()->result_array();
		$department_map = array_column($departments, 'name', 'id');
	
		// Add department names and employee count to results
		foreach ($results as $result) {
			$department_ids = json_decode($result->department_id, true);
			$department_names = array();
			foreach ($department_ids as $id) {
				if (isset($department_map[$id])) {
					$department_names[] = $department_map[$id];
				}
			}
			$result->department_names = implode(', ', $department_names);
			$result->employee_count = $result->employee_count;
		}
	
		return $results;
	}		
	  
    function get_filtered_data(){
	   $a = $this->make_query();
	   if($this->input->get('title')) {
			$title = $this->input->get('title');
			if($title != ''){
				$a .= " AND (mjt.name LIKE '%". $title ."%' OR mjt.arabic_name LIKE '%". $title ."%')";
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != ''){
				$a .= " AND `mjt.status` = '" . $status . "'";
			}
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_job_title');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_job_title WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_job_title WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

}
