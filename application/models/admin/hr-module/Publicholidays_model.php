<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publicholidays_model extends CI_Model{

	public function get_all_holidays() {
		$query = $this->db->get('public_holidays');
		
		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return [];
		}
	}

	public function get_holidays_by_id($id) {
		$query = $this->db->get_where('public_holidays', array('id' => $id));
		return $query->row_array();
	}

	public function add_holidays($data) {
        return $this->db->insert('public_holidays', $data);
    }

	public function update_holidays($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('public_holidays', $data);
    }

	public function delete_holidays($leave_id) {
		// Check if the leave_id exists in the table where leave_group is 'custom'
		$this->db->where('id', $leave_id);
		$this->db->from('public_holidays');
		$exists = $this->db->count_all_results() > 0;
	
		if ($exists) {
			// Attempt to delete the record
			$this->db->where('id', $leave_id);
			$this->db->delete('public_holidays');
	
			// Return true if the deletion was successful
			return $this->db->affected_rows() > 0;
		} else {
			// Record does not exist
			return false;
		}
	}
	
}
