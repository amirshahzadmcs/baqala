<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfer_model extends CI_Model{

	public function insertTransfer($data) {
		// Start a transaction for safety
		$this->db->trans_start();
	
		// Log the data being inserted for debugging
		//log_message('debug', 'Inserting data: ' . print_r($data, true));
	
		// Insert data in batch
		$this->db->insert_batch('employee_transfer', $data);
	
		// Complete the transaction
		$this->db->trans_complete();
	
		// Check transaction status and log any errors
		if ($this->db->trans_status() === FALSE) {
			// Log the error message if the transaction failed
			$error = $this->db->error();
			log_message('error', 'Database insert error: ' . $error['message']);
			return false;
		}
	
		// Return the status or last insert ID as needed
		return true;
	}	

	public function updateTransfer($data) {
		$this->db->trans_start();
		//log_message('debug', 'Updating transfer data: ' . print_r($data, true));
		// Perform batch update
		$this->db->update_batch('employee_transfer', $data, 'id');
	
		// Complete the transaction
		$this->db->trans_complete();
	
		// Check transaction status and handle errors
		if ($this->db->trans_status() === FALSE) {
			$error = $this->db->error();
			log_message('error', 'Database update error: ' . $error['message'] . ' | Code: ' . $error['code']);
			
			log_message('error', 'Failed Query: ' . $this->db->last_query());
			
			return false;
		}
		return true;
	}	

	// Function to apply common filters using Query Builder
	private function apply_filters() {
		if($this->input->get('batch_no')) {
			$batch_no = $this->input->get('batch_no');
			if($batch_no != '') {
				$this->db->where('et.batch_no', $batch_no);
			}
		}
		if($this->input->get('start_date') && $this->input->get('end_date')) {
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$this->db->where('et.request_date >=', date("Y-m-d", strtotime($start_date)));
			$this->db->where('et.request_date <=', date("Y-m-d", strtotime($end_date)));
		}
	}

	public function get_batch_list() {
		$this->db->select('et.*, COUNT(et.emp_id) AS member_count');
		$this->db->from('employee_transfer et');
		// Apply filters
		$this->apply_filters();  
		$this->db->order_by('et.request_date', 'DESC');
		$this->db->group_by('et.batch_no');
		// Check if length is set and not -1 for pagination
		if (isset($_POST["length"]) && $_POST["length"] != -1) {
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		return $this->db->get()->result_array();
	}

	public function get_filtered_data() {
		$this->db->select('et.*, COUNT(et.emp_id) AS member_count');
		$this->db->from('employee_transfer et');
		
		// Apply filters
		$this->apply_filters();
		$this->db->group_by('et.batch_no');
		// Run the query
		$query = $this->db->get();  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('employee_transfer'); 
		$this->db->group_by('batch_no');
		return $this->db->count_all_results();
	}

	public function get_list($batch_no) {
		$this->db->select('et.*, spo.employer_id as old_employer_id, spo.employer_name as old_employer_name, spn.employer_id as new_employer_id, spn.employer_name as new_employer_name, me.emp_no, me.full_name, me.iqama_no, me.sponsor_id, mei.qiwa_contract_no, mei.qiwa_contract_status, mei.qiwa_contract_sign_date, mei.qiwa_contract_end_date, mjt.name as designation_name');
		$this->db->from('employee_transfer et');
		$this->db->join('master_employee me', 'et.emp_id = me.id', 'left');
		$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
		$this->db->join('sponsors spo', 'et.old_employer = spo.id', 'left');
		$this->db->join('sponsors spn', 'et.new_employer = spn.id', 'left');
		$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
		$this->db->where('et.batch_no', $batch_no);
		$this->db->order_by('me.emp_no', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_transfer_list($batch_no, $emp_ids) {
		if (!empty($emp_ids) && is_array($emp_ids)) {
			$emp_ids = array_map('intval', $emp_ids);

			// Select the columns you need from the joined tables
			$this->db->select('et.*, spo.employer_id as old_employer_id, spo.employer_name as old_employer_name, spn.employer_id as new_employer_id, spn.employer_name as new_employer_name, me.emp_no, me.full_name, me.iqama_no, me.sponsor_id, mei.qiwa_contract_no, mei.qiwa_contract_status, mei.qiwa_contract_sign_date, mei.qiwa_contract_end_date, mjt.name as designation_name');
			$this->db->from('employee_transfer et');
			$this->db->join('master_employee me', 'et.emp_id = me.id', 'left');
			$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
			$this->db->join('sponsors spo', 'et.old_employer = spo.id', 'left');
			$this->db->join('sponsors spn', 'et.new_employer = spn.id', 'left');
			$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
			$this->db->where('et.batch_no', $batch_no);
			$this->db->where_in('et.id', $emp_ids);

			// Order by emp_no in descending order
			$this->db->order_by('me.emp_no', 'DESC');
			$result = $this->db->get();
			return $result->result_array();
		}
		return [];
	}

	public function getDistinctBatchNosBetwYear($startYear, $endYear) {
		if (empty($startYear) || empty($endYear)) {
			return [];
		}
	
		// Query to get distinct batch_no
		$query = $this->db->select('batch_no')
						  ->distinct()
						  ->from('employee_transfer')
						  ->where('request_date >=', $startYear . '-01-01')
						  ->where('request_date <=', $endYear . '-12-31')
						  ->get();
	
		// Fetch results as an array
		$result = $query->result_array();
	
		// Add serial number to each record
		$serialNumber = 1;
		foreach ($result as &$row) {
			$row['serial_no'] = $serialNumber++;
		}
	
		return $result;
	}	
	
	public function get_transfer_detail($transfer_id) {
		if (!empty($transfer_id)) {
			$this->db->select('et.*, spo.employer_id as old_employer_id, spo.employer_name as old_employer_name, spn.employer_id as new_employer_id, spn.employer_name as new_employer_name, me.emp_no, me.full_name, me.iqama_no, me.sponsor_id, mei.qiwa_contract_no, mei.qiwa_contract_status, mei.qiwa_contract_sign_date, mei.qiwa_contract_end_date, mjt.name as applied_for_job');
			$this->db->from('employee_transfer et');
			$this->db->join('master_employee me', 'et.emp_id = me.id', 'left');
			$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
			$this->db->join('sponsors spo', 'et.old_employer = spo.id', 'left');
			$this->db->join('sponsors spn', 'et.new_employer = spn.id', 'left');
			$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
			$this->db->where('et.id', $transfer_id);
			$result = $this->db->get();
			return $result->row_array();
		}
		return false;
	}

	// Update transfer request status with transaction
	public function update_transfer_status($transfer_id, $updateData) {
		if (!$transfer_id || empty($updateData)) {
			return false;
		}

		// Start transaction
		$this->db->trans_start();

		// Update employee_transfer table
		$this->db->where('id', $transfer_id);
		$this->db->update('employee_transfer', $updateData);

		if ($this->db->affected_rows() <= 0) {
			// No rows affected, rollback
			$this->db->trans_complete();
			return false;
		}

		// Get transfer details
		$transfer = $this->db->get_where('employee_transfer', ['id' => $transfer_id])->row_array();
		$old_sponsor = null;

		if ($transfer && $updateData['status'] == 3) { // Approved
			// Get old sponsor
			$emp = $this->db->get_where('master_employee', ['id' => $transfer['emp_id']])->row_array();
			if ($emp) {
				$old_sponsor = $emp['sponsor_id'];
			}

			// Update master_employee
			$employeeUpdate = [
				'sponsor_id' => $transfer['new_employer'],
				'updated_at' => date('Y-m-d H:i:s'),
			];

			if (!empty($updateData['update_operation_date']) && $updateData['update_operation_date'] === 'yes') {
				$employeeUpdate['work_operational_date'] = date('Y-m-d');
			}

			$this->db->where('id', $transfer['emp_id']);
			$this->db->update('master_employee', $employeeUpdate);

			// Update master_employee_info
			$employeeInfoUpdate = [];
			if (!empty($updateData['qiwa_contract_no'])) {
				$employeeInfoUpdate['qiwa_contract_no']        = $updateData['qiwa_contract_no'];
				$employeeInfoUpdate['qiwa_contract_sign_date'] = $updateData['qiwa_start_date'];
				$employeeInfoUpdate['qiwa_contract_end_date']  = $updateData['qiwa_end_date'];
				$employeeInfoUpdate['updated_at']              = date('Y-m-d H:i:s');
			}

			if (!empty($employeeInfoUpdate)) {
				$this->db->where('employee_id', $transfer['emp_id']);
				$this->db->update('master_employee_info', $employeeInfoUpdate);
			}
		}

		// Log the action
		$message = "Transfer request #{$transfer_id} for Employee {$transfer['emp_id']} updated to status {$updateData['status']}";

		$log_json = json_encode([
			'transfer_id' => $transfer_id,
			'emp_id'      => $transfer['emp_id'],
			'action'      => $updateData['status'],
			'old_sponsor' => $old_sponsor,
			'new_sponsor' => $transfer['new_employer'],
			'changed_by'  => $updateData['updated_by'] ?? null,
			'timestamp'   => date('Y-m-d H:i:s'),
			'message'     => $message
		]);

		$this->db->insert('employee_logs', [
			'emp_id'     => $transfer['emp_id'],
			'log_detail' => $log_json,
			'created_at' => date('Y-m-d H:i:s')
		]);

		// Complete transaction
		$this->db->trans_complete();

		// Return true only if all queries succeeded
		return $this->db->trans_status();
	}

}
