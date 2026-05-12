<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logistic_ids_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('common_helper');
	}
	
	public function add($data) {
        // Insert data into the database
        $this->db->insert('master_logistic_ids', $data);
        return $this->db->insert_id();
    }

	public function update($id,$data) {
        // Update data into the database
		$this->db->where('id', $id);
        $this->db->update('master_logistic_ids', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function add_log($data) {
        // Insert data into the database
        $this->db->insert('master_logistic_ids_log', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	// Function to apply common filters
    private function apply_filters(&$a) {
        if($this->input->get('alloted_to')) {
			$alloted_to = $this->input->get('alloted_to');
            if($alloted_to != ''){
                $a .= " AND (lrr.employee_id = '".$alloted_to."')";
            }
        }

        if($this->input->get('owner')) {
			$owner = $this->input->get('owner');
            if($owner != ''){
                $a .= " AND (me.id = '".$owner."')";
            }
        }

        if($this->input->get('r_from') && $this->input->get('r_to')) {
            $r_from = $this->input->get('r_from');
            $r_to = $this->input->get('r_to');
            $format_to = date("Y-m-d", strtotime($r_to));
            if($r_from && $format_to) {
                $a .= " AND (er.request_date BETWEEN '" . date("Y-m-d", strtotime($r_to)) . "' AND '" . $format_to . "')";
            }
        }

        if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (er.activation_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
                $a .= " AND er.id_number = '" . $id_number . "'";
            }
        }
		
		if($this->input->get('status')) {
			$status = $this->input->get('status');
            if($status != ''){
                $a .= " AND er.status = '" . $status . "'";
            }
        }
		
		if($this->input->get('allotment_status')) {
			$allotment_status = $this->input->get('allotment_status');
			if($allotment_status == 'alloted') {
				$a .= " AND lrr.employee_id IS NOT NULL";
			} elseif($allotment_status == 'not_alloted') {
				$a .= " AND (lrr.employee_id IS NULL OR lrr.employee_id = '')";
			}
		}
		
		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
                $a .= " AND er.platform_id = '" . $platform . "'";
            }
        }
		
		if($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if($id_type != ''){
				$a .= " AND er.id_type = '" . $id_type . "'";
			}
		}
    }

	function make_query() {
		$query = "
		SELECT 
			er.*, 
			me.emp_no, 
			me.full_name, 
			me.iqama_no, 
			me.iqama_expiry_date, 
			me.nationality, 
			me.mobile, 
			me.passport_no, 
			me.designation, 
			me.status as emp_status,
			mjt.name as designation_name, 
			md.name as department_name, 
			mn.name as nationality_name, 
			lrr.employee_id as alloted_user, 
			(SELECT sc.mobile FROM sim_card sc WHERE sc.alloted_user = er.owner_id LIMIT 1) as flex_no, 
			fdc.company_name as food_company
		FROM 
			master_logistic_ids er 
		LEFT JOIN 
			master_employee me ON (er.owner_id = me.id) 
		LEFT JOIN 
			master_department md ON (me.department = md.id) 
		LEFT JOIN 
			master_job_title mjt ON (me.designation = mjt.id) 
		LEFT JOIN 
			food_deliv_companies fdc ON (er.platform_id = fdc.id) 
		LEFT JOIN 
			master_nationality mn ON (me.nationality = mn.id) 
		LEFT JOIN 
			logistic_rider lrr ON (er.id_number = lrr.id_number) 
		WHERE 
			1=1";
		return $query;
	}

	function get_list(){
		$a = $this->make_query();
		$this->apply_filters($a);
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%'";
		// }
		$a .= " ORDER BY er.activation_date DESC";	   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }   
	
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   	$a = $this->make_query();
		$this->apply_filters($a);
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('master_logistic_ids');  
	   return $this->db->count_all_results();
    }

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_logistic_ids WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	public function get_id_number($rider_id) {
		$this->db->select('id_number');
		$this->db->from('master_logistic_ids');
		$this->db->where('id', $rider_id);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->row()->id_number;
		} else {
			return false;
		}
	}

	function get_detail_by_empid($empid){
		$query = $this->db->query("SELECT * FROM master_logistic_ids WHERE employee_id = '" . (int)$empid . "'");
		return $query;
	}

	function checkDuplicatePlatform($id, $owner_id, $platform_id) {
		$this->db->select('id');
		$this->db->from('master_logistic_ids');
		if (!empty($id)) {
			$this->db->where('id !=', $id);
		}
		$this->db->where('owner_id', $owner_id);
		$this->db->where('platform_id', $platform_id);
		$this->db->where('status !=', 'terminated');
		$query = $this->db->get();
		return ($query->num_rows() > 0);
	}	

	function checkDuplicateId($id, $owner_id, $id_number = null) {
		// Construct the query to check for duplicate employees
		$this->db->select('id');  
		$this->db->from('master_logistic_ids'); 
		$this->db->where('id !=', $id);
		$this->db->where('owner_id', $owner_id);
		$this->db->where('id_number', $id_number);

		$query = $this->db->get();
		return $query->num_rows() > 0;
	}

	//Check if the id_number is alloted to any other employee
	function checkIdNumberAlloted($id_number) {
		$this->db->select('id');
		$this->db->from('logistic_rider');
		$this->db->where('id_number', $id_number);
		$query = $this->db->get();
		return $query->num_rows() > 0;
	}
	
	function delete($ids){
		$count = count($ids);
		$result = []; // Array to track deletion status
	
		for ($i = 0; $i < $count; $i++) {
			// Get the id_number for the current id from master_logistic_ids
			$this->db->select('id_number');
			$this->db->from('master_logistic_ids');
			$this->db->where('id', $ids[$i]);
			$id_number_row = $this->db->get()->row();
	
			if ($id_number_row) {
				$id_number = $id_number_row->id_number;
	
				// Check if id_number exists in logistic_rider
				$this->db->select('id');
				$this->db->from('logistic_rider');
				$this->db->where('id_number', $id_number);
				$exists = $this->db->get()->row();
	
				if ($exists) {
					// Add to result array if not deleted, with the reason
					$result[] = [
						'id' => $ids[$i],
						'status' => 'error',
						'message' => 'Because it exists in logistic_rider.'
					];
				} else {
					// Delete the record if id_number is not found in logistic_rider
					$this->db->where('id', $ids[$i]);
					$this->db->delete('master_logistic_ids');
	
					// Add to result array indicating success
					$result[] = [
						'id' => $ids[$i],
						'status' => 'success',
						'message' => 'Successfully deleted.'
					];
				}
			} else {
				$result[] = [
					'id' => $ids[$i],
					'status' => 'error',
					'message' => 'ID not found.'
				];
			}
		}
		
		return $result; // Return the array with all deletion statuses
	}
	

	/*-------- Filters -----*/

	// Fetch filtered vehicle types
    public function get_filtered_id_numbers($search_query) {
		$this->db->distinct();
        $this->db->select('id_number, id_number as key_value');
        $this->db->from('master_logistic_ids');
        if (!empty($search_query)) {
            $this->db->like('id_number', $search_query);
        }
		$this->db->group_by('id_number');
        $query = $this->db->get();
        return $query->result();
    }

    // Fetch filtered vehicle colors
    public function get_filtered_owner($search_query) {
		$this->db->distinct();
		$this->db->select('mli.owner_id as key_value, me.full_name, me.emp_no');
		$this->db->from('master_logistic_ids mli');
		$this->db->join('master_employee me', 'mli.owner_id = me.id', 'left');
		
		if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('me.full_name', $search_query);
			$this->db->or_like('me.emp_no', $search_query);
			$this->db->group_end();
		}
		$this->db->group_by('mli.owner_id');
		$query = $this->db->get();
		return $query->result();
	}   

    // Fetch filtered vehicle colors
    public function get_filtered_alloted_to($search_query) {
		$this->db->distinct();
        $this->db->select('lr.employee_id as key_value, me.full_name, me.emp_no');
        $this->db->from('master_logistic_ids mli');
		$this->db->join('logistic_rider lr', 'mli.id_number = lr.id_number', 'left');
		$this->db->join('master_employee me', 'lr.employee_id = me.id', 'left');
        if (!empty($search_query)) {
			$this->db->group_start();
			$this->db->like('me.full_name', $search_query);
			$this->db->or_like('me.emp_no', $search_query);
			$this->db->group_end();
        }
		$this->db->group_by('lr.employee_id');
        $query = $this->db->get();
        return $query->result();
    }
	
	/*----- Filters End -----*/
}
