<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Food_allowance_model extends CI_Model{

	public function insertAllowance($data) {
		// Start a transaction for safety
		$this->db->trans_start();
	
		// Log the data being inserted for debugging
		log_message('debug', 'Inserting data: ' . print_r($data, true));
	
		// Insert data in batch
		$this->db->insert_batch('food_allowance_distribution', $data);
	
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

	public function updateAllowance($data) {
		$this->db->trans_start();
	
		log_message('debug', 'Updating allowance data: ' . print_r($data, true));
	
		// Perform batch update
		$this->db->update_batch('food_allowance_distribution', $data, 'id');
	
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
		/*
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != '') {
				$this->db->like("CONCAT_WS(' ', mc.first_name, mc.middle_name, mc.third_name, mc.surname)", $keyword);
			}
		}

		if($this->input->get('cv_no')) {
			$cv_no = $this->input->get('cv_no');
			if($cv_no != '') {
				$this->db->where('mc.cv_no', $cv_no);
			}
		}

		if($this->input->get('applied_for')) {
			$applied_for = $this->input->get('applied_for');
			if($applied_for != '') {
				$this->db->where('mc.applied_for', $applied_for);
			}
		}

		if($this->input->get('country')) {
			$country = $this->input->get('country');
			if($country != '') {
				$this->db->where('mc.country', $country);
			}
		}
		*/
		if($this->input->get('batch_no')) {
			$batch_no = $this->input->get('batch_no');
			if($batch_no != '') {
				$this->db->where('fad.batch_no', $batch_no);
			}
		}
		if($this->input->get('start_date') && $this->input->get('end_date')) {
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$this->db->where('fad.arrival_date >=', date("Y-m-d", strtotime($start_date)));
			$this->db->where('fad.arrival_date <=', date("Y-m-d", strtotime($end_date)));
		}
	}

	public function get_batch_list() {
		$this->db->select('fad.*, COUNT(fad.cv_id) AS member_count');
		$this->db->from('food_allowance_distribution fad');
		// Apply filters
		$this->apply_filters();  
		$this->db->order_by('fad.arrival_date', 'DESC');
		$this->db->group_by('fad.batch_no');
		// Check if length is set and not -1 for pagination
		if (isset($_POST["length"]) && $_POST["length"] != -1) {
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		return $this->db->get()->result_array();
	}

	public function get_filtered_data() {
		$this->db->select('fad.*, COUNT(fad.cv_id) AS member_count');
		$this->db->from('food_allowance_distribution fad');
		
		// Apply filters
		$this->apply_filters();
		$this->db->group_by('fad.batch_no');
		// Run the query
		$query = $this->db->get();  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('food_allowance_distribution'); 
		$this->db->group_by('batch_no');
		return $this->db->count_all_results();
	}

	/*
	// Function to apply common filters using Query Builder
	private function apply_filters() {
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != '') {
				$this->db->like("CONCAT_WS(' ', mc.first_name, mc.middle_name, mc.third_name, mc.surname)", $keyword);
			}
		}

		if($this->input->get('cv_no')) {
			$cv_no = $this->input->get('cv_no');
			if($cv_no != '') {
				$this->db->where('mc.cv_no', $cv_no);
			}
		}

		if($this->input->get('start_date') && $this->input->get('end_date')) {
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$this->db->where('fad.arrival_date >=', date("Y-m-d", strtotime($start_date)));
			$this->db->where('fad.arrival_date <=', date("Y-m-d", strtotime($end_date)));
		}

		if($this->input->get('applied_for')) {
			$applied_for = $this->input->get('applied_for');
			if($applied_for != '') {
				$this->db->where('mc.applied_for', $applied_for);
			}
		}

		if($this->input->get('country')) {
			$country = $this->input->get('country');
			if($country != '') {
				$this->db->where('mc.country', $country);
			}
		}

		if($this->input->get('batch_no')) {
			$batch_no = $this->input->get('batch_no');
			if($batch_no != '') {
				$this->db->where('fad.batch_no', $batch_no);
			}
		}
	}
	*/
	public function get_list($batch_no) {
		$this->db->select('fad.*, mc.cv_no, mc.first_name, mc.middle_name, mc.third_name, mc.surname, mc.candidate_arabic_name, mc.hiring_type, mc.applicant_country, mc.applied_for, mc.border_entry_no, mc.passport_no, mc.visa_no, msp.package_name, msp.project_name, msp.basic_salary, m_country.name as country_name, mjt.name as applied_for_job');
		$this->db->from('food_allowance_distribution fad');
		$this->db->join('master_cv mc', 'fad.cv_id = mc.id', 'left');
		$this->db->join('master_salary_packages msp', 'mc.rider_package_id = msp.id', 'left');
		$this->db->join('master_country m_country', 'mc.applicant_country = m_country.id', 'left');
		$this->db->join('master_job_title mjt', 'mc.applied_for = mjt.id', 'left');
		$this->db->where('fad.batch_no', $batch_no);
		$this->db->order_by('mc.cv_no', 'DESC');
		return $this->db->get()->result_array();
	}
	
	public function get_allowance_list($batch_no, $cv_ids) {
		if (!empty($cv_ids) && is_array($cv_ids)) {
			$cv_ids = array_map('intval', $cv_ids);
	
			// Select the columns you need from the joined tables
			$this->db->select('fad.*, mc.cv_no, mc.first_name, mc.middle_name, mc.third_name, mc.surname, mc.candidate_arabic_name, mc.hiring_type, mc.applicant_country, mc.applied_for, mc.border_entry_no, mc.visa_no');
			$this->db->from('food_allowance_distribution fad');
			$this->db->join('master_cv mc', 'fad.cv_id = mc.id', 'left');
			$this->db->where('fad.batch_no', $batch_no);
			$this->db->where_in('fad.id', $cv_ids);
			
			// Order by cv_no in descending order
			$this->db->order_by('mc.cv_no', 'DESC');
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
						  ->from('food_allowance_distribution')
						  ->where('arrival_date >=', $startYear . '-01-01')
						  ->where('arrival_date <=', $endYear . '-12-31')
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
	
	public function get_allowance_detail($fd_id) {
		if (!empty($fd_id)) {
			$this->db->select('fad.*, mc.cv_no, mc.first_name, mc.middle_name, mc.third_name, mc.surname, mc.candidate_arabic_name, mc.hiring_type, mc.applicant_country, mc.applied_for, mc.border_entry_no, mc.passport_no, mc.visa_no, mjt.name as applied_for_job');
			$this->db->from('food_allowance_distribution fad');
			$this->db->join('master_cv mc', 'fad.cv_id = mc.id', 'left');
			$this->db->join('master_job_title mjt', 'mc.applied_for = mjt.id', 'left');
			$this->db->where('fad.id', $fd_id);
			$result = $this->db->get();
			return $result->row_array();
		}
		return false;
	}
	
	public function get_cv_not_in_food_allowance($arrival_date) {
		$this->db->select('mc.id, mc.cv_no, mc.first_name, mc.middle_name, mc.third_name, mc.surname, mc.candidate_arabic_name, msp.package_name, msp.basic_salary, msp.food_allow, msp.total_package as salary_package');
		$this->db->from('master_cv mc');
		$this->db->join('food_allowance_distribution fad', 'mc.id = fad.cv_id', 'left');
		$this->db->join('master_salary_packages msp', 'mc.rider_package_id = msp.id', 'left');
		$this->db->where('fad.cv_id IS NULL');
		$this->db->where('mc.arrival_date', $arrival_date);
		$this->db->order_by('mc.cv_no', 'DESC');
		
		$query = $this->db->get();
		return $query->result_array();
	}	

	public function get_cv_detail($cv_id) {
		$this->db->select('mc.id, mc.cv_no, mc.first_name, mc.middle_name, mc.third_name, mc.surname, mc.candidate_arabic_name, msp.package_name, msp.basic_salary, msp.food_allow, msp.total_package as salary_package');
		$this->db->from('master_cv mc');
		$this->db->join('master_salary_packages msp', 'mc.rider_package_id = msp.id', 'left');
		$this->db->where('mc.id', $cv_id);
		$this->db->order_by('mc.cv_no', 'DESC');
		
		$query = $this->db->get();
		return $query->row_array();
	}	
	
	public function refreshAllowance($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('food_allowance_distribution', $data);
	}
}
