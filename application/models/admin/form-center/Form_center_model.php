<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form_center_model extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $query = $this->db->get('form_centers');
        return $query->result_array();
    }

    public function get_by_id($id) {
        $query = $this->db->get_where('form_centers', array('id' => $id));
        return $query->row_array();
    }

    public function insert($data) {
		$this->db->insert('form_centers', $data);
		return $this->db->insert_id();
	}

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('form_centers', $data);
    }
	
	function make_query(){
		$a = "SELECT 
		fc.*, 
		me.emp_no, 
		me.full_name, 
		me.iqama_no, 
		me.nationality, 
		me.mobile, 
		me.designation, 
		mjt.name as designation_name, 
		md.name as department_name, 
		mn.name as nationality_name 
		FROM form_centers fc 
		LEFT JOIN 
			master_employee me ON (fc.employee_id = me.id) 
		LEFT JOIN 
			master_department md ON (me.department = md.id) 
		LEFT JOIN 
			master_job_title mjt ON (me.designation = mjt.id) 
		LEFT JOIN 
			master_nationality mn ON (me.nationality = mn.id)";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND (fc.document_no LIKE '%".$_POST["search"]["value"]."%' OR me.emp_no LIKE '%".$_POST["search"]["value"]."%' OR me.full_name LIKE '%".$_POST["search"]["value"]."%' OR me.iqama_no LIKE '%".$_POST["search"]["value"]."%')";
		}
		$a .= " ORDER BY fc.document_no DESC";		   
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}        
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
		$this->db->from('form_centers');  
		return $this->db->count_all_results();  
	}
	
	public function delete($ids){
		if (is_array($ids)) {
			$this->db->where_in('id', $ids);
		} else {
			$this->db->where('id', $ids);
		}
		return $this->db->delete('form_centers');
	}	
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM form_centers WHERE id = '" . (int)$id . "'");
		return $query;
	}

	// Get SIM details by employee ID
    public function getSimDetailByEmployee($emp_id) {
        $this->db->select('*');
        $this->db->from('sim_card');
        $this->db->where('alloted_user', $emp_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->row_array();
    }

	public function is_warning_letter_issued($employee_id, $letter_type) {
        $this->db->where('employee_id', $employee_id);
		$this->db->where('letter_type', $letter_type);
		$this->db->where('document_type', 'warning_letter');
		$query = $this->db->get('form_centers');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

	public function can_issue_warning_letter($employee_id, $letter_type) {
		// Define the order of warning letters
		$letter_order = array('first', 'second', 'third'); // Add more if needed
		// Check if the current letter type is valid
		if (!in_array($letter_type, $letter_order)) {
			return false; // Invalid letter type
		}
		$current_index = array_search($letter_type, $letter_order);

		// Check if all previous warning letters have been issued
		for ($i = 0; $i < $current_index; $i++) {
			$this->db->where('employee_id', $employee_id);
			$this->db->where('letter_type', $letter_order[$i]);
			$this->db->where('document_type', 'warning_letter');
			$query = $this->db->get('form_centers');
	
			if ($query->num_rows() == 0) {
				return false; // Previous letter is missing
			}
		}
		return true;
    }
}
