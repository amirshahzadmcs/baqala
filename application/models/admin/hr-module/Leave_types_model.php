<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave_types_model extends CI_Model{

	public function get_all_settings() {
        // Fetch all data from the annual_leaves_settings table
        $query = $this->db->get('annual_leaves_settings');
        
        // Return the result as an array
        return $query->row_array();
    }

	public function update_entitlement_days($setting_id, $days) {
		// Fetch the current JSON data
		$this->db->select('annual_leave_entitlement'); // Assuming 'annual_leave_entitlement' is the JSON column
		$this->db->from('annual_leaves_settings');
		$this->db->where('id', $setting_id);
		$query = $this->db->get();
		
		if ($query->num_rows() == 1) {
			$row = $query->row();
			$data = json_decode($row->annual_leave_entitlement, true);
	
			if (!is_array($data)) {
				$data = [];
			}
	
			// Add the new days if it is not already in the array
			if (!in_array($days, $data)) {
				$data[] = $days;
			}
	
			// Remove duplicates from the array
			$data = array_unique($data);
	
			// Save the updated JSON data back to the database
			$this->db->where('id', $setting_id);
			return $this->db->update('annual_leaves_settings', ['annual_leave_entitlement' => json_encode($data)]);
		} else {
			return false;
		}
	}	
	
	public function delete_entitlement_day($setting_id, $day_to_delete) {
        // Fetch the current JSON data
        $this->db->select('annual_leave_entitlement');
        $this->db->from('annual_leaves_settings');
        $this->db->where('id', $setting_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $data = json_decode($row->annual_leave_entitlement, true);

            // Remove the specific day from the JSON data
            if (($key = array_search($day_to_delete, $data)) !== false) {
                unset($data[$key]);
            }

            // Reindex array
            $data = array_values($data);

            // Save the updated JSON data back to the database
            $this->db->where('id', $setting_id);
            return $this->db->update('annual_leaves_settings', ['annual_leave_entitlement' => json_encode($data)]);
        } else {
            return false;
        }
    }

	public function update_leave_calculation($setting_id, $leave_calculation) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', ['annual_leave_calculation' => $leave_calculation]);
    }

    public function update_half_day($setting_id, $enable_half_day) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', ['enable_half_day_leave' => $enable_half_day ? 'yes' : 'no']);
    }
	
	public function update_starting_balance($setting_id, $starting_balance) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', ['starting_balance' => $starting_balance]);
    }

	public function update_leave_auto_upgrade($setting_id, $leave_auto_upgrade) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', ['leave_auto_upgrade' => $leave_auto_upgrade]);
    }

	public function get_all_employees() {
		$this->db->where('status', 'Active');
		$this->db->order_by('full_name', 'ASC');
		$query = $this->db->get('master_employee');
		return $query->result();
	}
	
	public function save_selected_employees($setting_id, $employee_ids) {
        $data = array('employee_ids' => json_encode($employee_ids));
		$this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', $data);
    }

	public function save_auto_upgrade_settings($setting_id, $data) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', $data);
    }

	public function save_return_confirmation($setting_id, $data) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', $data);
    }

	public function save_remaining_balance($setting_id, $data) {
        $this->db->where('id', $setting_id);
        return $this->db->update('annual_leaves_settings', $data);
    }

	/*----- Labour Laws -----*/
	public function get_labour_laws() {
		$this->db->where('leave_group', 'labour_law');
		$query = $this->db->get('leave_types');
		
		if ($query->num_rows() > 0) {
			return $query->result_array(); // Use result_array() if expecting multiple rows
		} else {
			return []; // Return an empty array or handle as needed
		}
	}

	public function get_labour_law_by_id($id) {
        $query = $this->db->get_where('leave_types', array('id' => $id));
        return $query->row(); // Returns a single row
    }
	
	public function update_labour_law($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('leave_types', $data);
    }

	/*----- Custom Leave -----*/

	public function get_custom_leaves() {
		$this->db->where('leave_group', 'custom');
		$query = $this->db->get('leave_types');
		
		if ($query->num_rows() > 0) {
			return $query->result_array(); // Use result_array() if expecting multiple rows
		} else {
			return []; // Return an empty array or handle as needed
		}
	}

	public function get_custom_leave_by_id($id) {
        $query = $this->db->get_where('leave_types', array('id' => $id, 'leave_group' => 'custom'));
        return $query->row(); // Returns a single row
    }

	public function add_custom_leave($data) {
        return $this->db->insert('leave_types', $data);
    }

	public function update_custom_leave($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('leave_types', $data);
    }

	public function delete_custom_leave($leave_id) {
		// Check if the leave_id exists in the table where leave_group is 'custom'
		$this->db->where('id', $leave_id);
		$this->db->where('leave_group', 'custom');
		$this->db->from('leave_types');
		$exists = $this->db->count_all_results() > 0;
	
		if ($exists) {
			// Attempt to delete the record
			$this->db->where('id', $leave_id);
			$this->db->where('leave_group', 'custom');
			$this->db->delete('leave_types');
	
			// Return true if the deletion was successful
			return $this->db->affected_rows() > 0;
		} else {
			// Record does not exist
			return false;
		}
	}
	
}
