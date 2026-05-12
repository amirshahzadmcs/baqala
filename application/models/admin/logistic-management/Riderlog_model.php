<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riderlog_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('common_helper');
	}
	
	function make_query(){
		$a = "SELECT lrl.*, lr.id as rider_id, mli.platform_id, mli.id_type, lr.employee_id, lr.id_number, me.emp_no, me.full_name, me.iqama_no, me.mobile, me.passport_no, me.designation, fdc.company_name as food_company FROM logistic_rider_log lrl LEFT JOIN logistic_rider lr ON (lrl.logistic_rider_id = lr.id) LEFT JOIN master_employee me ON (lr.employee_id = me.id) LEFT JOIN master_logistic_ids mli ON (lr.id_number = mli.id_number) LEFT JOIN food_deliv_companies fdc ON (lr.platform = fdc.id) WHERE lrl.log_type = 'transfer'";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.emp_no LIKE '%".$keyword."%' OR me.full_name LIKE '%".$keyword."%')";
            }
        }
		
		if ($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if ($id_type != '') {
				$escaped_id_type = $this->db->escape($id_type);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.id_type')) = $escaped_id_type";
			}
		}

		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
                $a .= " AND mli.platform_id = '" . $platform . "'";
            }
        }

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
                $a .= " AND lr.id_number = '" . $id_number . "'";
            }
        }

		if ($this->input->get('from') AND $this->input->get('to')) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if ($v_from AND $v_to) {
				$a .= " AND (JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.transfer_date')) BETWEEN '". date("Y-m-d", strtotime($v_from)) ."' AND '". $d_to ."')";
			}
		}

		if(isset($_POST["order"])){             
			$a .= " ORDER BY me.full_name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY lrl.id DESC";		   
        }		   
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
                $a .= " AND (me.emp_no LIKE '%".$keyword."%' OR me.full_name LIKE '%".$keyword."%')";
            }
        }
		
		if ($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if ($id_type != '') {
				$escaped_id_type = $this->db->escape($id_type);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.id_type')) = $escaped_id_type";
			}
		}

		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
                $a .= " AND mli.platform_id = '" . $platform . "'";
            }
        }

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
                $a .= " AND lr.id_number = '" . $id_number . "'";
            }
        }

		if ($this->input->get('from') AND $this->input->get('to')) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if ($v_from AND $v_to) {
				$a .= " AND (JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.transfer_date')) BETWEEN '". date("Y-m-d", strtotime($v_from)) ."' AND '". $d_to ."')";
			}
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('logistic_rider_log');
	   $this->db->where('log_type','transfer');
	   return $this->db->count_all_results();
    }

	// Suspend Log
	function make_query2() {
		$a = "SELECT 
				lrl.*, 
				lr.id AS rider_id, 
				mli.platform_id, 
				lr.employee_id, 
				mli.id_type, 
				mli.id_number, 
				me.emp_no, 
				me.full_name, 
				me.iqama_no, 
				me.mobile, 
				me.passport_no, 
				me.designation, 
				fdc.company_name AS food_company 
			FROM 
				logistic_rider_log lrl
			LEFT JOIN 
				logistic_rider lr ON lrl.logistic_rider_id = lr.id
			LEFT JOIN 
				master_employee me ON JSON_EXTRACT(lrl.log_detail, '$.employee_id') = CAST(me.id AS CHAR)
			LEFT JOIN 
				master_logistic_ids mli ON JSON_EXTRACT(lrl.log_detail, '$.aggregator_id') = CAST(mli.id_number AS CHAR) 
			LEFT JOIN 
				food_deliv_companies fdc ON mli.platform_id = fdc.id
			WHERE 
				lrl.log_type = 'status'";
		return $a;
	}

	function suspend_list() {
		$a = $this->make_query2(); // Base query
		$conditions = []; // Array to hold additional WHERE conditions

		// Add keyword filter
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if ($keyword != '') {
				$conditions[] = "(me.emp_no LIKE '%" . $this->db->escape_like_str($keyword) . "%' OR me.full_name LIKE '%" . $this->db->escape_like_str($keyword) . "%')";
			}
		}

		// Add ID type filter
		if ($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if ($id_type != '') {
				$conditions[] = "mli.id_type = " . $this->db->escape($id_type);
			}
		}

		// Add platform filter
		if ($this->input->get('platform')) {
			$platform = $this->input->get('platform');
			if ($platform != '') {
				$conditions[] = "mli.platform_id = '" . $this->db->escape_str($platform) . "'";
			}
		}

		// Add ID number filter
		if ($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
			if ($id_number != '') {
				$conditions[] = "mli.id_number = '" . $this->db->escape_str($id_number) . "'";
			}
		}

		// Add date range filter
		if ($this->input->get('from') && $this->input->get('to')) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if ($v_from && $v_to) {
				$conditions[] = "(DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_from'))) >= '" . date("Y-m-d", strtotime($v_from)) . "' 
								AND DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_to'))) <= '" . $d_to . "')";
			}
		}

		// Combine all conditions
		if (!empty($conditions)) {
			$a .= " AND " . implode(" AND ", $conditions);
		}

		// Add order and limit
		$a .= " ORDER BY created_at DESC";
		if ($_POST["length"] != -1) {
			$a .= " LIMIT " . (int)$_POST['start'] . " ," . (int)$_POST['length'];
		}

		// Execute the query
		$query = $this->db->query($a);
		return $query->result();
	}

	function get_filtered_suspend() {
		$a = $this->make_query2(); // Base query
		$conditions = []; // Array to hold additional WHERE conditions

		// Add keyword filter
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if ($keyword != '') {
				$conditions[] = "(me.emp_no LIKE '%" . $this->db->escape_like_str($keyword) . "%' OR me.full_name LIKE '%" . $this->db->escape_like_str($keyword) . "%')";
			}
		}

		// Add platform filter
		if ($this->input->get('platform')) {
			$platform = $this->input->get('platform');
			if ($platform != '') {
				$conditions[] = "mli.platform_id = '" . $this->db->escape_str($platform) . "'";
			}
		}

		// Add ID number filter
		if ($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
			if ($id_number != '') {
				$conditions[] = "mli.id_number = '" . $this->db->escape_str($id_number) . "'";
			}
		}

		// Add date range filter
		if ($this->input->get('from') && $this->input->get('to')) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if ($v_from && $v_to) {
				$conditions[] = "(DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_from'))) >= '" . date("Y-m-d", strtotime($v_from)) . "' 
								AND DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_to'))) <= '" . $d_to . "')";
			}
		}

		// Combine all conditions
		if (!empty($conditions)) {
			$a .= " AND " . implode(" AND ", $conditions);
		}

		$query = $this->db->query($a);
		return $query->num_rows();
	}

	function get_all_suspend() {
		$this->db->select("*");
		$this->db->from('logistic_rider_log');
		$this->db->where('log_type', 'status');
		return $this->db->count_all_results();
	}
	
	function monthly_suspended_log($keyword, $id_type, $month_of, $platform, $id_number){
		//$month_of = $this->input->get('month_of');
		if (!$month_of) {
			throw new Exception("Date parameter 'month_of' is missing");
		}
	
		// Try parsing the date with the expected format 'M Y'
		$date = DateTime::createFromFormat('M Y', $month_of);
		
		// If parsing fails, provide better feedback and debugging information
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of) . ". Expected format: 'M Y' (e.g., 'Sep 2024').");
		}
	
		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');
	
		$a = "SELECT lr.id as rider_id, 
					 mli.platform_id, 
					 mli.id_type, 
					 mli.id_number,
					 lr.employee_id, 
					 me.emp_no, 
					 me.full_name, 
					 me.iqama_no, 
					 me.mobile, 
					 me.passport_no, 
					 me.designation, 
					 fdc.company_name as food_company,
					 COUNT(lrl.id) as suspend_count,  -- Count number of suspensions
					 SUM(DATEDIFF(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_to')), JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_from')))) as total_suspended_days  -- Sum total suspension days
			  FROM logistic_rider_log lrl 
			  LEFT JOIN logistic_rider lr ON (lrl.logistic_rider_id = lr.id) 
			  LEFT JOIN master_employee me ON JSON_EXTRACT(lrl.log_detail, '$.employee_id') = CAST(me.id AS CHAR) 
			  LEFT JOIN master_logistic_ids mli ON JSON_EXTRACT(lrl.log_detail, '$.aggregator_id') = CAST(mli.id_number AS CHAR) 
			  LEFT JOIN food_deliv_companies fdc ON mli.platform_id = fdc.id 
			  WHERE lrl.log_type = 'status' AND lrl.status_type = 'Suspend'";
	
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if ($keyword != '') {
				$a .= " AND (me.emp_no LIKE '%" . $keyword . "%' OR me.full_name LIKE '%" . $keyword . "%')";
			}
		}

		if ($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if ($id_type != '') {
				$escaped_id_type = $this->db->escape($id_type);
				$a .= " AND mli.id_type = $escaped_id_type";
			}
		}

		if ($this->input->get('platform')) {
			$platform = $this->input->get('platform');
			if ($platform != '') {
				$a .= " AND mli.platform_id = '" . $platform . "'";
			}
		}

		if ($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
			if ($id_number != '') {
				$a .= " AND mli.id_number = '" . $id_number . "'";
			}
		}
	
		if ($start_date && $end_date) {
			$a .= " AND (DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_from'))) >= '". date("Y-m-d", strtotime($start_date)) ."' 
						AND DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_to'))) <= '". date("Y-m-d", strtotime($end_date)) ."')";
		}
	
		// Group by employee to calculate number of suspend marks and total suspension days
		$a .= " GROUP BY lr.employee_id";
	
		// Order by both total suspension days and number of suspensions
		$a .= " ORDER BY total_suspended_days DESC, suspend_count DESC";
	
		$query = $this->db->query($a);
		return $query->result_array();
	}

	function daily_suspended_log($keyword, $id_type, $date_from, $date_to, $platform, $id_number){
		$a = "SELECT lrl.*, lr.id as rider_id, mli.platform_id, lr.employee_id, mli.id_type, mli.id_number, me.emp_no, me.full_name, me.iqama_no, me.mobile, me.passport_no, me.designation, fdc.company_name as food_company FROM logistic_rider_log lrl 
		LEFT JOIN logistic_rider lr ON (lrl.logistic_rider_id = lr.id) 
		LEFT JOIN master_employee me ON JSON_EXTRACT(lrl.log_detail, '$.employee_id') = CAST(me.id AS CHAR) 
		LEFT JOIN master_logistic_ids mli ON JSON_EXTRACT(lrl.log_detail, '$.aggregator_id') = CAST(mli.id_number AS CHAR) 
		LEFT JOIN food_deliv_companies fdc ON mli.platform_id = fdc.id 
		WHERE (lrl.log_type = 'status' AND lrl.status_type = 'Suspend')";
		if($keyword){
			$a .= " AND (me.emp_no LIKE '%".$keyword."%' OR me.full_name LIKE '%".$keyword."%')";
		}
		
		if ($id_type != '') {
			$escaped_id_type = $this->db->escape($id_type);
			$a .= " AND mli.id_type = $escaped_id_type";
		}

		if($platform != ''){
			$a .= " AND mli.platform_id = '" . $platform . "'";
		}

		if($id_number != ''){
			$a .= " AND mli.id_number = '" . $id_number . "'";
		}

		if ($date_from AND $date_to) {
			$d_to = date("Y-m-d", strtotime($date_to));
			if ($date_from AND $d_to) {
				$a .= " AND (DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_from'))) >= '". date("Y-m-d", strtotime($date_from)) ."' 
						AND DATE(JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.suspend_to'))) <= '". date("Y-m-d", strtotime($d_to)) ."')";
			}
		}

		$a .= " ORDER BY created_at DESC";         
        $query = $this->db->query($a);  
        return $query->result_array(); 
	}

	/*----- Swapping -------*/

	function make_swap_query(){
		$a = "SELECT 
			lrl.*, 
			e.emp_no, 
			e.full_name, 
			e.iqama_no, 
			e.mobile, 
			e.passport_no, 
			e.designation,
			e.department,
			fdc.company_name as food_company
		FROM 
			logistic_rider_log AS lrl 
		LEFT JOIN 
			master_employee AS e 
			ON JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.employee_id')) = e.id 
		LEFT JOIN 
			food_deliv_companies AS fdc 
			ON JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.platform')) = fdc.id 
		WHERE (lrl.log_type = 'unallot' OR lrl.log_type = 'allot')";
		return $a;
	}
	
	function get_swap_list(){
		$a = $this->make_swap_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (e.emp_no LIKE '%".$keyword."%' OR e.full_name LIKE '%".$keyword."%')";
            }
        }
		
		if ($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if ($id_type != '') {
				$escaped_id_type = $this->db->escape($id_type);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.id_type')) = $escaped_id_type";
			}
		}

		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
				$escaped_platform = $this->db->escape($platform);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.platform')) = $escaped_platform";
            }
        }

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
				$escaped_id_number = $this->db->escape($id_number);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.id_number')) = $escaped_id_number";
            }
        }

		if ($this->input->get('from') AND $this->input->get('to')) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_from = date("Y-m-d", strtotime($v_from));
			$d_to = date("Y-m-d", strtotime($v_to));
		
			if ($v_from AND $v_to) {
				$a .= " AND (DATE(lrl.created_at) BETWEEN '" . $d_from . "' AND '" . $d_to . "')";
			}
		}		

		if(isset($_POST["order"])){             
			$a .= " ORDER BY lrl.id DESC";
		}  
        else{  
			$a .= " ORDER BY lrl.id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_swap_filtered_data(){
	   	$a = $this->make_swap_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (e.emp_no LIKE '%".$keyword."%' OR e.full_name LIKE '%".$keyword."%')";
            }
        }
		
		if ($this->input->get('id_type')) {
			$id_type = $this->input->get('id_type');
			if ($id_type != '') {
				$escaped_id_type = $this->db->escape($id_type);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.id_type')) = $escaped_id_type";
			}
		}

		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
				$escaped_platform = $this->db->escape($platform);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.platform')) = $escaped_platform";
            }
        }

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
				$escaped_id_number = $this->db->escape($id_number);
				$a .= " AND JSON_UNQUOTE(JSON_EXTRACT(lrl.log_detail, '$.id_number')) = $escaped_id_number";
            }
        }

		if ($this->input->get('from') AND $this->input->get('to')) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_from = date("Y-m-d", strtotime($v_from));
			$d_to = date("Y-m-d", strtotime($v_to));
		
			if ($v_from AND $v_to) {
				$a .= " AND (DATE(lrl.created_at) BETWEEN '" . $d_from . "' AND '" . $d_to . "')";
			}
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_swap_data(){
	   $this->db->select("*");  
	   $this->db->from('logistic_rider_log');
	   $this->db->where('log_type','unallot');
	   $this->db->or_where('log_type','allot');
	   return $this->db->count_all_results();
    }
}
