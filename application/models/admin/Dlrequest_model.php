<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dlrequest_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('common_helper');
	}
	
	public function add($data) {
        // Insert data into the database
        $this->db->insert('dl_request', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }

	public function update($id,$data) {
        // Update data into the database
		$this->db->where('id', $id);
        $this->db->update('dl_request', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query()
	{
		$sql = "
			SELECT 
				dr.*,
				me.emp_no, 
				me.full_name, 
				me.iqama_no, 
				me.iqama_expiry_date, 
				me.nationality, 
				me.mobile, 
				me.passport_no, 
				me.designation, 
				me.payment_type_detail, 
				mjt.name AS designation_name, 
				md.name AS department_name, 
				mn.name AS nationality_name, 
				dt.transaction_date,
				s.employer_name AS sponsor_name,
				mp.profession_name,
				sc.mobile AS sim_mobile_number,
				dt_file.trans_amount   AS dl_file_amount,
				dt_medical.trans_amount AS dl_medical_amount,
				dt_issued.trans_amount  AS dl_issued_amount
			FROM dl_request dr
			LEFT JOIN master_employee me ON dr.emp_id = me.id
			LEFT JOIN sponsors s ON me.sponsor_id = s.id
			LEFT JOIN master_department md ON me.department = md.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN master_nationality mn ON me.nationality = mn.id
			LEFT JOIN master_profession mp ON me.iqama_profession = mp.id
			LEFT JOIN (
				SELECT request_id, MAX(trans_date) AS transaction_date
				FROM dl_transactions
				GROUP BY request_id
			) dt ON dt.request_id = dr.id
			LEFT JOIN (
				SELECT sc1.*
				FROM sim_card sc1
				INNER JOIN (
					SELECT alloted_user, MAX(id) AS max_id
					FROM sim_card
					GROUP BY alloted_user
				) sc2
				ON sc1.alloted_user = sc2.alloted_user
				AND sc1.id = sc2.max_id
			) sc ON sc.alloted_user = me.id
			LEFT JOIN (
				SELECT t1.request_id, t1.trans_amount
				FROM dl_transactions t1
				INNER JOIN (
					SELECT request_id, MAX(id) AS max_id
					FROM dl_transactions
					WHERE transaction_type = 1
					GROUP BY request_id
				) t2 ON t1.id = t2.max_id
			) dt_file ON dt_file.request_id = dr.id

			LEFT JOIN (
				SELECT t1.request_id, t1.trans_amount
				FROM dl_transactions t1
				INNER JOIN (
					SELECT request_id, MAX(id) AS max_id
					FROM dl_transactions
					WHERE transaction_type = 7
					GROUP BY request_id
				) t2 ON t1.id = t2.max_id
			) dt_medical ON dt_medical.request_id = dr.id

			LEFT JOIN (
				SELECT t1.request_id, t1.trans_amount
				FROM dl_transactions t1
				INNER JOIN (
					SELECT request_id, MAX(id) AS max_id
					FROM dl_transactions
					WHERE transaction_type = 9
					GROUP BY request_id
				) t2 ON t1.id = t2.max_id
			) dt_issued ON dt_issued.request_id = dr.id

			WHERE 1=1
		";
		return $sql;
	}

	function get_list(){
		//dd($this->input->get('transaction_from'));
		$a = $this->make_query();
		$keyword = trim($this->input->get('keyword'));
		if (!empty($keyword)) {
			$keyword = $this->db->escape_like_str($keyword);
			$a .= " AND (me.full_name LIKE '%$keyword%' OR me.emp_no LIKE '%$keyword%')";
		}
		
		// $trans_type = $this->input->get('trans_type');
		// if ($trans_type !== null && $trans_type !== '') {
		// 	$a .= " AND dr.trans_status = '" . $trans_type . "'";
		// 	$a .= " AND dr.status != 'Cancelled'";
		// }

		$trans_type = $this->input->get('trans_type');
		//log_message('error', 'DL Transaction Type: ' . $trans_type);
		// 🔹 Multiple appointment types filter
		if (!empty($trans_type)) {
			if (is_array($trans_type)) {
				// Filter out empty or non-numeric values
				$types = array_filter($trans_type, function ($v) {
					return is_numeric($v);
				});

				if (!empty($types)) {
					$types = array_map('intval', $types);
					$a .= " AND dr.trans_status IN (" . implode(',', $types) . ")";
					$a .= " AND dr.status != 'Cancelled'";
				}
			} else {
				// Single value case
				$type = intval($trans_type);
				$a .= " AND dr.trans_status = '" . $type . "'";
				$a .= " AND dr.status != 'Cancelled'";
			}
		}

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dr.request_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		// 🔹 Transaction Date filter — only if Transaction Type is selected
		//if($trans_type !== null && $trans_type !== '') {
			if($this->input->get('transaction_from') && $this->input->get('transaction_to')){
				$t_from = $this->input->get('transaction_from');
				$t_to = $this->input->get('transaction_to');
				$t_to_plus = date("Y-m-d", strtotime($t_to));
				$a .= " AND (dt.transaction_date BETWEEN '". date("Y-m-d", strtotime($t_from)) ."' AND '". $t_to_plus ."')";
			}
		//}
		$a .= " GROUP BY dr.id ORDER BY dr.request_date DESC";
		// if(isset($_POST["order"])){             
		// 	$a .= " ORDER BY me.first_name ". $_POST['order']['0']['dir'] ."";
		// }  
        // else{  
		// 	$a .= " ORDER BY er.created_at DESC";		   
        // }
		//$a .= " ORDER BY dr.request_date DESC";		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   	$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
            }
        }
		
		$trans_type = $this->input->get('trans_type');
		//log_message('error', 'DL Transaction Type: ' . $trans_type);
		// 🔹 Multiple appointment types filter
		if (!empty($trans_type)) {
			if (is_array($trans_type)) {
				// Filter out empty or non-numeric values
				$types = array_filter($trans_type, function ($v) {
					return is_numeric($v);
				});

				if (!empty($types)) {
					$types = array_map('intval', $types);
					$a .= " AND dr.trans_status IN (" . implode(',', $types) . ")";
					$a .= " AND dr.status != 'Cancelled'";
				}
			} else {
				// Single value case
				$type = intval($trans_type);
				$a .= " AND dr.trans_status = '" . $type . "'";
				$a .= " AND dr.status != 'Cancelled'";
			}
		}

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dr.request_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		// Filter by Transaction Date
		//if($trans_type !== null && $trans_type !== '') {
			if($this->input->get('transaction_from') && $this->input->get('transaction_to')){
				$t_from = $this->input->get('transaction_from');
				$t_to = $this->input->get('transaction_to');
				$t_to_plus = date("Y-m-d", strtotime($t_to));
				$a .= " AND (dt.transaction_date BETWEEN '". date("Y-m-d", strtotime($t_from)) ."' AND '". $t_to_plus ."')";
			}
		//}
		$a .= " GROUP BY dr.id";
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('dl_request');  
	   return $this->db->count_all_results();
    }
	
	function get_detail($id){
		$query = $this->db->query("SELECT dr.*, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.iqama_expiry_date, me.mobile, me.employee_pic, me.nationality, me.passport_no, me.designation, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM dl_request dr LEFT JOIN master_employee me ON (dr.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) LEFT JOIN master_nationality mn ON (me.nationality = mn.id) WHERE dr.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function check_duplicate_employee($id, $emp_id, $dl_type){
		$this->db->select("*");  
		$this->db->from('dl_request'); 
		$this->db->where('id !=',$id);
		$this->db->where('emp_id =',$emp_id);
		$this->db->where('dl_type =',$dl_type);
		return $this->db->count_all_results();  
	}
	
	function check_dl_exist($emp_id, $dl_type){
		$this->db->select("*");  
		$this->db->from('dl_request');
		$this->db->where('emp_id =',$emp_id);
		$this->db->where('dl_type =',$dl_type);
		$this->db->where('status !=','Cancelled');
		return $this->db->count_all_results();  
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM dl_request WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	function print_detail($id){
		$query = $this->db->query("SELECT dr.*, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.iqama_expiry_date, me.mobile, me.employee_pic, me.nationality, me.passport_no, me.designation, me.department, me.work_joining_date, me.payment_type_detail, mei.driving_license_number, mei.gosi_id, mei.qiwa_contract_no, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM dl_request dr LEFT JOIN master_employee me ON (dr.emp_id = me.id) LEFT JOIN master_employee_info mei ON (dr.emp_id = mei.employee_id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) LEFT JOIN master_nationality mn ON (me.nationality = mn.id) WHERE dr.id = '" . (int)$id . "'");
		return $query->row_array();
	}
	
	public function get_transaction_list($request_id)
	{
		$this->db->select("*");  
		$this->db->from('dl_transactions');
		$this->db->where('request_id', $request_id);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_last_transaction($request_id)
	{
		$this->db->select("*");  
		$this->db->from('dl_transactions');
		$this->db->where('request_id', $request_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		return $query->row();
	}
	
	public function updateAmount($id, $amount) {
		if($amount > 0){
			$cost_involve = 'yes';
		}else{
			$cost_involve = 'no';
		}
        $data = [
            'trans_amount' => $amount,
            'cost_involve' => $cost_involve,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        return $this->db->update('dl_transactions', $data);
    }
	
	//Export DL Request List to Excel
	function get_export_list(){
		$a = $this->make_query();
		// -----------------------------
		// 🔹 Step 1: Handle selected IDs
		// -----------------------------
		$selected_ids = $this->input->get('selected_ids');
		$ids_array = [];

		if (!empty($selected_ids)) {
			// Allow comma-separated or array input
			if (is_string($selected_ids)) {
				$ids_array = explode(',', $selected_ids);
			} elseif (is_array($selected_ids)) {
				$ids_array = $selected_ids;
			}

			$ids_array = array_filter($ids_array, 'is_numeric');
			if (!empty($ids_array)) {
				$a .= " AND dr.id IN (" . implode(',', $ids_array) . ")";
			}
		}
		
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
            }
        }

		$trans_type = $this->input->get('trans_type');
		// 🔹 Multiple appointment types filter
		if (!empty($trans_type)) {
			if (is_array($trans_type)) {
				// Filter out empty or non-numeric values
				$types = array_filter($trans_type, function ($v) {
					return is_numeric($v);
				});

				if (!empty($types)) {
					$types = array_map('intval', $types);
					$a .= " AND dr.trans_status IN (" . implode(',', $types) . ")";
					$a .= " AND dr.status != 'Cancelled'";
				}
			} else {
				// Single value case
				$type = intval($trans_type);
				$a .= " AND dr.trans_status = '" . $type . "'";
				$a .= " AND dr.status != 'Cancelled'";
			}
		}

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dr.request_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($this->input->get('transaction_from') && $this->input->get('transaction_to')){
			$t_from = $this->input->get('transaction_from');
			$t_to = $this->input->get('transaction_to');
			$t_to_plus = date("Y-m-d", strtotime($t_to));
			$a .= " AND (dt.transaction_date BETWEEN '". date("Y-m-d", strtotime($t_from)) ."' AND '". $t_to_plus ."')";
		}
		$a .= " GROUP BY dr.id ORDER BY dr.request_date DESC";              
        $query = $this->db->query($a);  
        return $query->result_array();  
    }
}
