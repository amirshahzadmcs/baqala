<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disputes_model extends CI_Model{

	function insertApporval($data) {
        $this->db->insert('request_approval', $data);
        return $this->db->insert_id();
    }

	public function updateApporval($dlId, $data)
    {
        $this->db->where('id', $dlId);
        return $this->db->update('request_approval', $data);
    }

	function make_query() {
		$sql = "SELECT la.* FROM request_approval la WHERE la.approval_types = 'Disputes'";
		return $sql;
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
	   $this->db->from('request_approval');  
	   $this->db->where('approval_types', 'Disputes');
	   return $this->db->count_all_results();
    }

	public function getRequestById($dlId)
    {
        $this->db->select('*');
        $this->db->from('request_approval');
        $this->db->where('id', $dlId);
        $this->db->where('approval_types', 'Disputes');
        $query = $this->db->get();
        return $query->row();
    }

	public function deleteApproval($loan_id) {
		$this->db->where('id', $loan_id);
		$this->db->where('type', 'custom');
		$this->db->where('approval_types', 'Disputes');
		$this->db->from('request_approval');
		$exists = $this->db->count_all_results() > 0;
	
		if ($exists) {
			$this->db->where('id', $loan_id);
			$this->db->where('type', 'custom');
			$this->db->where('approval_types', 'Disputes');
			$this->db->delete('request_approval');
	
			// Return true if the deletion was successful
			return $this->db->affected_rows() > 0;
		} else {
			// Record does not exist
			return false;
		}
	}
	
	public function get_all_employees() {
		// Check if any Disputes has `is_applicable_to_all = yes`
		$this->db->select('is_applicable_to_all, employees_ids');
		$this->db->where('approval_types', 'Disputes');
		$query = $this->db->get('request_approval');
		$dlRequests = $query->result();
	
		$excludeEmployees = []; // Array to store employees to exclude
	
		foreach ($dlRequests as $dlRequest) {
			if ($dlRequest->is_applicable_to_all === 'yes') {
				// If `is_applicable_to_all = yes`, return an empty array
				return [];
			} elseif ($dlRequest->is_applicable_to_all === 'no' && !empty($dlRequest->employees_ids)) {
				// If `is_applicable_to_all = no`, collect employees_ids to exclude
				$excludeEmployees = array_merge($excludeEmployees, json_decode($dlRequest->employees_ids, true));
			}
		}
	
		// Remove duplicate employee IDs
		$excludeEmployees = array_unique($excludeEmployees);
	
		// Get all active employees excluding the ones in `excludeEmployees`
		$this->db->where('status', 'Active');
		if (!empty($excludeEmployees)) {
			$this->db->where_not_in('id', $excludeEmployees);
		}
		$this->db->order_by('full_name', 'ASC');
		$query = $this->db->get('master_employee');
	
		return $query->result();
	}
	
}
