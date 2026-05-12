<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SanatAlAmar_model extends CI_Model{

	public function insertSanat($data) {
		if (empty($data)) {
			log_message('error', 'Insert failed: Data array is empty.');
			return false;
		}
	
		$this->db->trans_start();
		$this->db->insert('sanat_al_amar', $data);
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE) {
			$error = $this->db->error();
			log_message('error', 'Database insert error: ' . $error['message'] . ' | Code: ' . $error['code']);
			log_message('error', 'Failed Query: ' . $this->db->last_query());
			return false;
		}
		return true;
	}
	
	public function updateSanat($id,$data) {
		if (empty($data) || empty($id)) {
			log_message('error', 'Update failed: Data array or ID is missing.');
			return false;
		}
	
		$this->db->trans_start();
		$this->db->update('sanat_al_amar', $data, ['id' => $id]);
		$this->db->trans_complete();
	
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
		
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != '') {
				$this->db->like("me.full_name", $keyword);
				$this->db->or_like("me.emp_no", $keyword);
			}
		}

		if($this->input->get('sanat_owner')) {
			$sanat_owner = $this->input->get('sanat_owner');
			if($sanat_owner != '') {
				$this->db->like("sal.sanat_owner", $sanat_owner);
			}
		}

		if($this->input->get('sanat_no')) {
			$sanat_no = $this->input->get('sanat_no');
			if($sanat_no != '') {
				$this->db->where('sal.sanat_no', $sanat_no);
			}
		}

		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
			if($iqama_no != '') {
				$this->db->where('me.iqama_no', $iqama_no);
			}
		}

		if($this->input->get('status')) {
			$status = $this->input->get('status');
			if($status != '') {
				$this->db->where('sal.status', $status);
			}
		}

		if($this->input->get('start_date') && $this->input->get('end_date')) {
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$this->db->where('sal.sanat_date >=', date("Y-m-d", strtotime($start_date)));
			$this->db->where('sal.sanat_date <=', date("Y-m-d", strtotime($end_date)));
		}
	}

	public function get_list() {
		$this->db->select('sal.*, me.full_name, me.emp_no, me.iqama_no');
		$this->db->from('sanat_al_amar sal');
		$this->db->join('master_employee me', 'sal.employee_id = me.id', 'left');
		// Apply filters
		$this->apply_filters();  
		$this->db->order_by('sal.sanat_date', 'DESC');
		if (isset($_POST["length"]) && $_POST["length"] != -1) {
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		return $this->db->get()->result_array();
	}

	public function get_filtered_data() {
		$this->db->select('sal.*, me.full_name, me.emp_no, me.iqama_no');
		$this->db->from('sanat_al_amar sal');
		$this->db->join('master_employee me', 'sal.employee_id = me.id', 'left');
		$this->apply_filters();
		$query = $this->db->get();  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('sanat_al_amar');  
		return $this->db->count_all_results();
	}

	public function get_detail($id) {
		if (!empty($id)) {
			$this->db->select('sal.*');
			$this->db->from('sanat_al_amar sal');
			$this->db->where('sal.id', $id);
			$result = $this->db->get();
			return $result;
		}
		return false;
	}
	
	public function sanat_print_list() {
		$this->db->select('sal.*, me.full_name, me.emp_no, me.iqama_no');
		$this->db->from('sanat_al_amar sal');
		$this->db->join('master_employee me', 'sal.employee_id = me.id', 'left');
		// Apply filters
		$this->apply_filters();  
		$this->db->order_by('sal.sanat_date', 'DESC');
		return $this->db->get()->result_array();
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->select('*');
			$this->db->from('sanat_al_amar');
			$this->db->where('id', $ids[$i]);
			$images = $this->db->get()->row();
			$query = $this->db->query("DELETE FROM sanat_al_amar WHERE id = '" . $ids[$i] . "'");
			if ($query) {
				if ($query && file_exists($images->attachment)) {
					if (unlink($images->attachment));
				}
			}
		}
		return true;
	}
	
	public function checkDuplicate($employee_id, $sanat_no){
		$this->db->where('employee_id', $employee_id);
		$this->db->or_where('sanat_no', $sanat_no);
		$query = $this->db->get('sanat_al_amar');
		return $query->num_rows() > 0;
	}

	public function checkDuplicateOnUpdate($employee_id, $sanat_no, $id){
		$this->db->where('employee_id', $employee_id);
		$this->db->or_where('sanat_no', $sanat_no);
		if($id){
			$this->db->where('id !=', $id);
		}
		$query = $this->db->get('sanat_al_amar');
		return $query->num_rows() > 0;
	}
}
