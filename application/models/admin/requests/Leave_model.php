<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave_model extends CI_Model{

	function insertLeave($data) {
        $this->db->insert('request_approval', $data);
        return $this->db->insert_id();
    }

	public function updateLeaveRequest($leaveId, $data)
    {
        $this->db->where('id', $leaveId);
        return $this->db->update('request_approval', $data);
    }

	function make_query() {
		$sql = "SELECT la.*, lt.name AS leave_type_name FROM request_approval la LEFT JOIN leave_types lt ON JSON_EXTRACT(la.approval_detail, '$.leave_types') = CAST(lt.id AS CHAR) WHERE la.approval_types = 'LeaveRequest'";
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
		$this->db->where('approval_types', 'LoanRequest');
	   	return $this->db->count_all_results();
    }

	public function get_leave_types() {
		$this->db->where('leave_group', 'labour_law');
		$this->db->or_where('leave_group', 'custom');
		$this->db->where('status', 'active');
		$query = $this->db->get('leave_types');
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}

	public function getLeaveRequestById($leaveId)
    {
        $this->db->select('*');
        $this->db->from('request_approval');
        $this->db->where('id', $leaveId);
		$this->db->where('approval_types', 'LoanRequest');
        $query = $this->db->get();
        return $query->row();
    }

	public function delete_approval($leave_id) {
		$this->db->where('id', $leave_id);
		$this->db->where('type', 'custom');
		$this->db->where('approval_types', 'LoanRequest');
		$this->db->from('request_approval');
		$exists = $this->db->count_all_results() > 0;
	
		if ($exists) {
			$this->db->where('id', $leave_id);
			$this->db->where('type', 'custom');
			$this->db->where('approval_types', 'LoanRequest');
			$this->db->delete('request_approval');
	
			// Return true if the deletion was successful
			return $this->db->affected_rows() > 0;
		} else {
			// Record does not exist
			return false;
		}
	}
}
