<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_profession_model extends CI_Model{	

	public function updateProfession($data) {
		$this->db->trans_start();
		//log_message('debug', 'Updating profession data: ' . print_r($data, true));
		// Perform batch update
		$this->db->update_batch('employee_profession_change', $data, 'id');
	
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
				$this->db->where('epc.batch_no', $batch_no);
			}
		}
		if($this->input->get('start_date') && $this->input->get('end_date')) {
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$this->db->where('epc.request_date >=', date("Y-m-d", strtotime($start_date)));
			$this->db->where('epc.request_date <=', date("Y-m-d", strtotime($end_date)));
		}
	}

	public function get_batch_list() {
		$this->db->select('epc.*, COUNT(epc.emp_id) AS member_count');
		$this->db->from('employee_profession_change epc');
		// Apply filters
		$this->apply_filters();  
		$this->db->order_by('epc.request_date', 'DESC');
		$this->db->group_by('epc.batch_no');
		// Check if length is set and not -1 for pagination
		if (isset($_POST["length"]) && $_POST["length"] != -1) {
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		return $this->db->get()->result_array();
	}

	public function get_filtered_data() {
		$this->db->select('epc.*, COUNT(epc.emp_id) AS member_count');
		$this->db->from('employee_profession_change epc');
		
		// Apply filters
		$this->apply_filters();
		$this->db->group_by('epc.batch_no');
		// Run the query
		$query = $this->db->get();  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('employee_profession_change'); 
		$this->db->group_by('batch_no');
		return $this->db->count_all_results();
	}

	public function get_list($batch_no) {
		$this->db->select('epc.*, mpo.profession_name as old_profession_name, mpn.profession_name as new_profession_name, me.emp_no, me.full_name, me.iqama_no, mjt.name as designation_name');
		$this->db->from('employee_profession_change epc');
		$this->db->join('master_employee me', 'epc.emp_id = me.id', 'left');
		$this->db->join('master_profession mpo', 'epc.old_profession_id = mpo.id', 'left');
		$this->db->join('master_profession mpn', 'epc.new_profession_id = mpn.id', 'left');
		$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
		$this->db->where('epc.batch_no', $batch_no);
		$this->db->order_by('me.emp_no', 'DESC');
		return $this->db->get()->result_array();
	}

	public function get_transfer_list($batch_no, $emp_ids) {
		if (!empty($emp_ids) && is_array($emp_ids)) {
			$emp_ids = array_map('intval', $emp_ids);

			// Select the columns you need from the joined tables
			$this->db->select('epc.*, mpo.profession_name as old_profession_name, mpn.profession_name as new_profession_name, me.emp_no, me.full_name, me.iqama_no, mjt.name as designation_name');
			$this->db->from('employee_profession_change epc');
			$this->db->join('master_employee me', 'epc.emp_id = me.id', 'left');
			$this->db->join('master_profession mpo', 'epc.old_profession_id = mpo.id', 'left');
			$this->db->join('master_profession mpn', 'epc.new_profession_id = mpn.id', 'left');
			$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
			$this->db->where('epc.batch_no', $batch_no);
			$this->db->where_in('epc.id', $emp_ids);

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
						  ->from('employee_profession_change')
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

	public function get_profession_detail($profession_id) {
		if (!empty($profession_id)) {
			$this->db->select('epc.*, mpo.profession_name as old_profession_name, mpn.profession_name as new_profession_name, me.emp_no, me.full_name, me.iqama_no, mjt.name as designation_name, (SELECT document FROM master_employee_doc med WHERE me.id = med.emp_id AND med.doc_type = "Iqama Copy" LIMIT 1) AS iqama_copy');
			$this->db->from('employee_profession_change epc');
			$this->db->join('master_employee me', 'epc.emp_id = me.id', 'left');
			$this->db->join('master_profession mpo', 'epc.old_profession_id = mpo.id', 'left');
			$this->db->join('master_profession mpn', 'epc.new_profession_id = mpn.id', 'left');
			$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
			$this->db->where('epc.id', $profession_id);
			$result = $this->db->get();
			return $result->row_array();
		}
		return false;
	}

}
