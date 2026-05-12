<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rider_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('common_helper');
	}
	
	public function add($data) {
        $this->db->insert('logistic_rider', $data);
        return $this->db->insert_id();
    }

	public function update($id,$data) {
		$this->db->where('id', $id);
        $this->db->update('logistic_rider', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function is_already_suspended($id, $rider_status) {
        $this->db->where('id', $id);
        $this->db->where('rider_status =', $rider_status);
        $query = $this->db->get('logistic_rider');
        return $query->num_rows() > 0;
    }
	
	public function is_already_transfered($id) {
        $this->db->where('id', $id);
        $this->db->where('last_transfer_date !=', '');
        $this->db->where('last_transfer_date !=', '0000-00-00');
    	$this->db->where('last_transfer_date IS NOT NULL', null, false);
        $query = $this->db->get('logistic_rider'); // Assuming your table name is 'suspensions'
        return $query->num_rows() > 0;
    }
	
	public function add_log($data) {
        // Insert data into the database
        $this->db->insert('logistic_rider_log', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }
	
	public function unsuspend_riders() {
		$current_time = date('Y-m-d H:i:s');
	
		// Capture rider details before updating the status
		$updated_riders_ids = $this->db->select('lr.id, lr.employee_id, lr.platform, lr.id_number, lr.suspend_from, lr.suspend_to, mli.id_type as aggregator_type')
                               ->from('logistic_rider lr')
                               ->join('master_logistic_ids mli', 'lr.id_number = mli.id_number', 'left')
                               ->where('lr.suspend_to <=', $current_time)
                               ->where('lr.rider_status', 'suspend')
                               ->get()
                               ->result_array();

	
		// Start a transaction to ensure atomicity
		$this->db->trans_start();
	
		// Update rider status
		$this->db->set('rider_status', 'active');
		$this->db->set('suspend_from', NULL);
		$this->db->set('suspend_to', NULL);
		$this->db->where('suspend_to <=', $current_time);
		$this->db->where('rider_status', 'suspend');
		$this->db->update('logistic_rider');
	
		// Create log entries for each updated rider
		foreach ($updated_riders_ids as $rider) {
			$log_data = array(
				'rider_status' => 'active',
				'employee_id' => $rider['employee_id'],
				'suspend_from' => $rider['suspend_from'],
				'suspend_to' => $rider['suspend_to'],
				'aggregator' => (!empty($rider['platform'])) ? $rider['platform'] : '',
				'aggregator_id' => (!empty($rider['id_number'])) ? $rider['id_number'] : '',
				'aggregator_type' => (!empty($rider['aggregator_type'])) ? $rider['aggregator_type'] : '',
				'status' => 'Released',
			);
			$insert_data = array(
				'logistic_rider_id' => $rider['id'],
				'log_type' => 'status',
				'status_type' => 'Released',
				'log_detail' => json_encode($log_data)
			);
			$log_id = $this->add_log($insert_data);
			if ($log_id === false) {
				// Log the error if the insert failed
				log_message('error', 'Failed to insert log for rider ID: ' . $rider['id']);
			}
		}
	
		// Complete the transaction
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE) {
			log_message('error', 'Transaction failed: ' . $this->db->error());
			return "Error: Transaction failed.";
		} else {
			return count($updated_riders_ids) . " riders unsuspended and logged.";
		}
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query() {
		$query = "
		SELECT 
			er.*, 
			mli.id_type, 
			mli.request_date, 
			mli.activation_date, 
			mli.owner_id,
			me.emp_no, 
			me.full_name, 
			me.iqama_no, 
			me.iqama_expiry_date, 
			me.nationality, 
			me.mobile, 
			me.passport_no, 
			me.designation, 
			me.status as emp_status,
			me.camp, 
			mc.camp_name, 
			mjt.name as designation_name, 
			md.name as department_name, 
			mn.name as nationality_name, 
			mv.id as vehicle_id, 
			mv.vehicle_type, 
			mv.vehicle_no, 
			mv.sequel_no, 
			incentives.target as monthly_target, 
			(SELECT sc.mobile FROM sim_card sc WHERE sc.alloted_user = er.employee_id LIMIT 1) as flex_no, 
			fdc.company_name as food_company,
			(
				SELECT GROUP_CONCAT(ht.name) 
				FROM hunger_team ht 
				WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
			) as team_name 
		FROM 
			logistic_rider er 
		LEFT JOIN 
			master_logistic_ids mli ON (er.id_number = mli.id_number)
		LEFT JOIN 
			master_employee me ON (er.employee_id = me.id) 
		LEFT JOIN 
			master_department md ON (me.department = md.id) 
		LEFT JOIN 
			master_job_title mjt ON (me.designation = mjt.id) 
		LEFT JOIN 
			food_deliv_companies fdc ON (er.platform = fdc.id) 
		LEFT JOIN 
			master_nationality mn ON (me.nationality = mn.id) 
		LEFT JOIN 
			master_vehicles mv ON (er.employee_id = mv.alloted_user) 
		LEFT JOIN master_camp mc ON (me.camp = mc.id) 
		LEFT JOIN incentives ON (er.incentive_id = incentives.id) 
		WHERE 
			1=1";
		return $query;
	}

	function get_list(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
            }
        }
		
		if($this->input->get('vehicle_no')) {
			$vehicle_no = $this->input->get('vehicle_no');
            if($vehicle_no != ''){
                $a .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
            }
        }

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (mli.activation_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
                $a .= " AND er.id_number = '" . $id_number . "'";
            }
        }
		
		if($this->input->get('rider_status')) {
			$rider_status = $this->input->get('rider_status');
            if($rider_status != ''){
                $a .= " AND er.rider_status = '" . $rider_status . "'";
            }
        }
		
		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
                $a .= " AND er.platform = '" . $platform . "'";
            }
        }
		
		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
            if($employer != ''){
                $a .= " AND me.sponsor_id = '" . $employer . "'";
            }
        }
		
		if($this->input->get('housing')) {
			$housing = $this->input->get('housing');
			if($housing != ''){
				$a .= " AND me.camp = '" . $housing . "'";
			}
		}

		// Apply team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%'";
		// }
		$a .= " ORDER BY me.emp_no DESC";	   
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
		
		if($this->input->get('vehicle_no')) {
			$vehicle_no = $this->input->get('vehicle_no');
            if($vehicle_no != ''){
                $a .= " AND mv.vehicle_no = '" . $vehicle_no . "'";
            }
        }

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (mli.activation_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($this->input->get('id_number')) {
			$id_number = $this->input->get('id_number');
            if($id_number != ''){
                $a .= " AND er.id_number = '" . $id_number . "'";
            }
        }
		
		if($this->input->get('rider_status')) {
			$rider_status = $this->input->get('rider_status');
            if($rider_status != ''){
                $a .= " AND er.rider_status = '" . $rider_status . "'";
            }
        }
		
		if($this->input->get('platform')) {
			$platform = $this->input->get('platform');
            if($platform != ''){
                $a .= " AND er.platform = '" . $platform . "'";
            }
        }
		
		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
            if($employer != ''){
                $a .= " AND me.sponsor_id = '" . $employer . "'";
            }
        }
		
		if($this->input->get('housing')) {
			$housing = $this->input->get('housing');
			if($housing != ''){
				$a .= " AND me.camp = '" . $housing . "'";
			}
		}

		// Apply team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('logistic_rider');  
	   return $this->db->count_all_results();
    }

	function get_detail($id){
		$query = $this->db->query("SELECT lr.*, mli.id_type, mli.request_date, mli.activation_date, mli.owner_id FROM logistic_rider lr LEFT JOIN master_logistic_ids mli ON (lr.id_number = mli.id_number) WHERE lr.id = '" . (int)$id . "'");
		return $query;
	}
	
	public function getSwapRiders($old_emp_id) {
		// Select the necessary fields from both tables
		$this->db->select('logistic_rider.*, master_employee.emp_no, master_employee.full_name, master_employee.employee_arabic_name, master_employee.designation, master_job_title.name as designation_name');
		$this->db->from('logistic_rider');
		$this->db->join('master_employee', 'logistic_rider.employee_id = master_employee.id', 'left');
		$this->db->join('master_job_title', 'master_employee.designation = master_job_title.id', 'left');
		$this->db->where('logistic_rider.employee_id !=', $old_emp_id);
		$this->db->where('logistic_rider.rider_status', 'active');
		
		// Execute the query
		$query = $this->db->get();
		
		// Return the result as an array
		return $query->result_array();
	}
	
	public function get_id_number($rider_id) {
		$this->db->select('id_number');
		$this->db->from('logistic_rider');
		$this->db->where('id', $rider_id);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->row()->id_number;
		} else {
			return false;
		}
	}

	function get_detail_by_empid($empid){
		$query = $this->db->query("SELECT * FROM logistic_rider WHERE employee_id = '" . (int)$empid . "'");
		return $query;
	}

	function check_duplicate_employee($id, $emp_id) {
		// Construct the query to check for duplicate employees
		$this->db->select('id');  
		$this->db->from('logistic_rider'); 
		$this->db->where('id !=', $id);
		$this->db->where('employee_id', $emp_id);

		$query = $this->db->get();
		return $query->num_rows() > 0;
	}

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM logistic_rider WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

    public function get_unalloted_aggregator($platform, $employee_id = null)
	{
		$this->db->select('master_logistic_ids.*');
		$this->db->from('master_logistic_ids');
		$this->db->join('logistic_rider', 'master_logistic_ids.id_number = logistic_rider.id_number', 'left');
		$this->db->where('master_logistic_ids.platform_id', $platform);
		$this->db->where('master_logistic_ids.status', 'active');

		$this->db->group_start();
		$this->db->where('logistic_rider.id_number IS NULL');
		$this->db->or_where('logistic_rider.id_number', '');
		if (!empty($employee_id)) {
			$this->db->or_where('logistic_rider.employee_id', $employee_id);
		}
		$this->db->group_end();

		$query = $this->db->get();
		return $query->result();
	}

	function get_aggregator_detail($id){
		$query = $this->db->query("SELECT mli.*, me.emp_no, me.full_name FROM master_logistic_ids mli LEFT JOIN master_employee me ON (mli.owner_id = me.id) WHERE mli.id_number = '".$id."'");
		return $query->row();
	}
	
	public function removeRiderFromAllTeams($riderId) {
        $this->db->select('id, team');
        $this->db->from('hunger_team');
        $this->db->like('team', '"' . $riderId . '"');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $team = json_decode($row->team, true);
                if (($key = array_search($riderId, $team)) !== false) {
                    unset($team[$key]);
                }
                $updatedTeam = json_encode(array_values($team));
                $this->db->where('id', $row->id);
                $this->db->update('hunger_team', ['team' => $updatedTeam]);
            }
            return true; 
        }
        return false;
    }
	
	/*------ Overall Report -------*/

	public function get_maha_hunger_data($from, $to, $search = null) {
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			DATE_FORMAT(MIN(hos.date_local), '%e/%b/%Y') AS from_date,
			DATE_FORMAT(MAX(hos.date_local), '%e/%b/%Y') AS to_date,
			'Hunger-Maha' AS aggregator,

			-- ✅ Total deliveries (full range, sponsor filter ke sath)
			SUM(CASE WHEN me.sponsor_id IN (1,2) THEN hos.completed_deliveries ELSE 0 END) AS total_deliveries,

			-- ✅ Notified deliveries (last date only, sponsor filter)
			SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.notified_deliveries ELSE 0 END) AS notified_deliveries,

			-- ✅ Completed deliveries (last date only, sponsor filter)
			SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.completed_deliveries ELSE 0 END) AS completed_deliveries,

			-- ✅ Total Ops Riders (active in logistic_rider + sponsor filter)
			(
				SELECT COUNT(DISTINCT lr.employee_id)
				FROM logistic_rider lr
				JOIN master_employee me2 ON me2.id = lr.employee_id
				WHERE lr.platform = '2'
				AND lr.rider_status = 'active'
				AND me2.sponsor_id IN (1, 2)
			) AS total_ops_riders,

			-- ✅ Active riders (last date only + sponsor filter)
			COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND hos.working_hours > 0 
				AND me.sponsor_id IN (1,2) 
				THEN hos.emp_id 
			END) AS active_riders,

			-- ✅ Planned hours (active_riders * 10)
			(COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND hos.working_hours > 0 
				AND me.sponsor_id IN (1,2) 
				THEN hos.emp_id 
			END) * 10) AS planned_hours,

			-- ✅ Avg. working hours variance
			(
				(COUNT(DISTINCT CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND hos.working_hours > 0 
					AND me.sponsor_id IN (1,2) 
					THEN hos.emp_id 
				END) * 10)
				- SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.planned_working_hours ELSE 0 END)
			) AS avg_hours_variance,

			-- ✅ Avg deliveries per rider
			ROUND(
				SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.completed_deliveries ELSE 0 END) /
				NULLIF(COUNT(DISTINCT CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND hos.working_hours > 0 
					AND me.sponsor_id IN (1,2) 
					THEN hos.emp_id 
				END), 0)
			) AS avg_dlvy_per_rider,

			-- ✅ % Difference (Notified vs Completed, sponsor filter)
			CONCAT(
				ROUND(
					(
						(
							SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.notified_deliveries ELSE 0 END) 
							- SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.completed_deliveries ELSE 0 END)
						)
						/ NULLIF(SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id IN (1,2) THEN hos.notified_deliveries ELSE 0 END), 0)
					) * 100, 0
				),
				'%'
			) AS percentage_difference,

			-- ✅ Riders with < 13 completed deliveries (last date only)
			COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND me.sponsor_id IN (1,2) 
				AND hos.completed_deliveries < 13 
				THEN hos.emp_id 
			END) AS riders_lt_13_orders
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');

		// ✅ Full range filter
		$this->db->where("hos.date_local >=", date('Y-m-d', strtotime($from)));
		$this->db->where("hos.date_local <=", date('Y-m-d', strtotime($to)));

		// ✅ Sponsor filter (Maha only)
		$this->db->where_in('me.sponsor_id', [1, 2]);

		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}

		return $this->db->get()->row_array();
	}

	//Get Employee in Maha Report
	public function maha_employee_order_report($from, $to, $search = null)
	{
		$this->db->select("
			hos.rider_id AS rider_id,
			me.emp_no AS emp_id,
			me.full_name AS emp_name,
			hos.completed_deliveries AS completed_deliveries,
			hos.working_hours AS online_hours,
			mv.vehicle_type,
			ROUND(hos.acceptance_rate) AS acceptance_rate
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = hos.alloted_vehicle_id', 'left');

		// ✅ Date filter (only $to)
		$this->db->where("hos.date_local", date('Y-m-d', strtotime($to)));

		// ✅ Sponsor filter
		$this->db->where_in('me.sponsor_id', [1, 2]);

		// ✅ Active riders only
		$this->db->where("hos.working_hours >", 0);
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}
		// ✅ Order by completed deliveries
		$this->db->order_by("hos.completed_deliveries", "DESC");

		$result = $this->db->get()->result_array();

		// ✅ Add Sr. No manually
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	// Hunger Wazer Report Data
	public function get_wazer_hunger_data($from, $to, $search = null) {
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			DATE_FORMAT(MIN(hos.date_local), '%e/%b/%Y') AS from_date,
			DATE_FORMAT(MAX(hos.date_local), '%e/%b/%Y') AS to_date,
			'Hunger-Wazer' AS aggregator,

			-- ✅ Total deliveries (full range)
			SUM(CASE WHEN me.sponsor_id = 5 THEN hos.completed_deliveries ELSE 0 END) AS total_deliveries,

			-- ✅ Notified deliveries (last date only)
			SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.notified_deliveries ELSE 0 END) AS notified_deliveries,

			-- ✅ Completed deliveries (last date only)
			SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.completed_deliveries ELSE 0 END) AS completed_deliveries,

			-- ✅ Total Ops Riders
			(
				SELECT COUNT(DISTINCT lr.employee_id)
				FROM logistic_rider lr
				JOIN master_employee me2 ON me2.id = lr.employee_id
				WHERE lr.platform = '2'
				AND lr.rider_status = 'active'
				AND me2.sponsor_id = 5
			) AS total_ops_riders,

			-- ✅ Active riders (last date only)
			COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND hos.working_hours > 0 
				AND me.sponsor_id = 5 
				THEN hos.emp_id 
			END) AS active_riders,

			-- ✅ Planned hours (active_riders * 10)
			(COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND hos.working_hours > 0 
				AND me.sponsor_id = 5 
				THEN hos.emp_id 
			END) * 10) AS planned_hours,

			-- ✅ Avg. working hours variance
			(
				(COUNT(DISTINCT CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND hos.working_hours > 0 
					AND me.sponsor_id = 5 
					THEN hos.emp_id 
				END) * 10)
				- SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.planned_working_hours ELSE 0 END)
			) AS avg_hours_variance,

			-- ✅ Avg deliveries per rider
			ROUND(
				SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.completed_deliveries ELSE 0 END) /
				NULLIF(COUNT(DISTINCT CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND hos.working_hours > 0 
					AND me.sponsor_id = 5 
					THEN hos.emp_id 
				END), 0)
			) AS avg_dlvy_per_rider,

			-- ✅ % Difference
			CONCAT(
				ROUND(
					(
						(
							SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.notified_deliveries ELSE 0 END) 
							- SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.completed_deliveries ELSE 0 END)
						)
						/ NULLIF(SUM(CASE WHEN hos.date_local = '{$last_date}' AND me.sponsor_id = 5 THEN hos.notified_deliveries ELSE 0 END), 0)
					) * 100, 0
				),
				'%'
			) AS percentage_difference,

			-- ✅ Riders with < 13 completed deliveries (last date only)
			COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND me.sponsor_id = 5 
				AND hos.completed_deliveries < 13 
				THEN hos.emp_id 
			END) AS riders_lt_13_orders
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');

		// Full range filter
		$this->db->where("hos.date_local >=", date('Y-m-d', strtotime($from)));
		$this->db->where("hos.date_local <=", date('Y-m-d', strtotime($to)));

		// Sponsor filter (Wazer only)
		$this->db->where('me.sponsor_id', 5);
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}
		return $this->db->get()->row_array();
	}

	//Get Employee in Maha Wazer Report
	public function wazer_employee_order_report($from, $to, $search = null)
	{
		$this->db->select("
			hos.rider_id AS rider_id,
			me.emp_no AS emp_id,
			me.full_name AS emp_name,
			hos.completed_deliveries AS completed_deliveries,
			hos.working_hours AS online_hours,
			mv.vehicle_type,
			ROUND(hos.acceptance_rate) AS acceptance_rate
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = hos.alloted_vehicle_id', 'left');

		// ✅ Date filter (only $to)
		$this->db->where("hos.date_local", date('Y-m-d', strtotime($to)));

		// ✅ Sponsor filter (only Wazer sponsor id = 5)
		$this->db->where('me.sponsor_id', 5);

		// ✅ Active riders only
		$this->db->where("hos.working_hours >", 0);
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}
		// ✅ Order by completed deliveries
		$this->db->order_by("hos.completed_deliveries", "DESC");

		$result = $this->db->get()->result_array();

		// ✅ Add Sr. No manually
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	// Hunger Outsource Report Data
	public function get_outsource_hunger_data($from, $to, $search = null) {
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			DATE_FORMAT(MIN(hos.date_local), '%e/%b/%Y') AS from_date,
			DATE_FORMAT(MAX(hos.date_local), '%e/%b/%Y') AS to_date,
			'Hunger-Outsource' AS aggregator,

			-- ✅ Total deliveries (full range)
			COALESCE(SUM(CASE 
				WHEN hos.emp_id = 0 OR me.sponsor_id = 4 
				THEN hos.completed_deliveries ELSE 0 END),0) AS total_deliveries,

			-- ✅ Notified deliveries (last date only)
			COALESCE(SUM(CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
				THEN hos.notified_deliveries ELSE 0 END),0) AS notified_deliveries,

			-- ✅ Completed deliveries (last date only)
			COALESCE(SUM(CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
				THEN hos.completed_deliveries ELSE 0 END),0) AS completed_deliveries,

			-- ✅ Total Ops Riders (exclude emp_id=0)
			(
				SELECT COUNT(DISTINCT lr.employee_id)
				FROM logistic_rider lr
				JOIN master_employee me2 ON me2.id = lr.employee_id
				WHERE lr.platform = '2'
				AND lr.rider_status = 'active'
				AND me2.sponsor_id = 4
			) AS total_ops_riders,

			-- ✅ Active riders (last date only)
			COALESCE(COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND hos.working_hours > 0 
				AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
				THEN hos.emp_id END),0) AS active_riders,

			-- ✅ Planned hours = active_riders * 10
			(COALESCE(COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND hos.working_hours > 0 
				AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
				THEN hos.emp_id END),0) * 10) AS planned_hours,

			-- ✅ Avg. working hours variance
			(
				(COALESCE(COUNT(DISTINCT CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND hos.working_hours > 0 
					AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
					THEN hos.emp_id END),0) * 10)
				- COALESCE(SUM(CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
					THEN hos.planned_working_hours ELSE 0 END),0)
			) AS avg_hours_variance,

			-- ✅ Avg deliveries per rider
			COALESCE(ROUND(
				SUM(CASE WHEN hos.date_local = '{$last_date}' 
						 AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
						 THEN hos.completed_deliveries ELSE 0 END) /
				NULLIF(COUNT(DISTINCT CASE 
					WHEN hos.date_local = '{$last_date}' 
					AND hos.working_hours > 0 
					AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
					THEN hos.emp_id END),0)
			),0) AS avg_dlvy_per_rider,

			-- ✅ % Difference (never NULL, default 0%)
			COALESCE(
				CONCAT(
					ROUND(
						(
							(
								SUM(CASE WHEN hos.date_local = '{$last_date}' 
										 AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
										 THEN hos.notified_deliveries ELSE 0 END) 
								- SUM(CASE WHEN hos.date_local = '{$last_date}' 
										   AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
										   THEN hos.completed_deliveries ELSE 0 END)
							)
							/ NULLIF(SUM(CASE WHEN hos.date_local = '{$last_date}' 
											  AND (hos.emp_id = 0 OR me.sponsor_id = 4) 
											  THEN hos.notified_deliveries ELSE 0 END), 0)
						) * 100, 0
					),
					'%'
				),
				'0%'
			) AS percentage_difference,

			-- ✅ Riders with < 13 completed deliveries (last date only)
			COUNT(DISTINCT CASE 
				WHEN hos.date_local = '{$last_date}' 
				AND me.sponsor_id = 4 
				AND hos.completed_deliveries < 13 
				THEN hos.emp_id 
			END) AS riders_lt_13_orders
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');

		// Full range filter
		$this->db->where("hos.date_local >=", date('Y-m-d', strtotime($from)));
		$this->db->where("hos.date_local <=", date('Y-m-d', strtotime($to)));

		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}
		return $this->db->get()->row_array();
	}

	//Get Employee in Maha Outsource Report
	public function outsource_hunger_employees($from, $to, $search = null)
	{
		$this->db->select("
			me.id AS emp_id,
			me.emp_no,
			me.full_name AS emp_name,
			hos.rider_id,
			hos.completed_deliveries AS completed_deliveries,
			hos.working_hours AS online_hours,
			mv.vehicle_type,
			ROUND(hos.acceptance_rate) AS acceptance_rate
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = hos.alloted_vehicle_id', 'left');

		// ✅ Date filter (only $to date)
		$this->db->where("hos.date_local", date('Y-m-d', strtotime($to)));

		// ✅ Outsource filter (emp_id=0 OR sponsor_id=4)
		$this->db->where("(hos.emp_id = 0 OR me.sponsor_id = 4)");

		// ✅ Active riders only
		$this->db->where("hos.working_hours >", 0);
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}
		// ✅ Order by completed deliveries
		$this->db->order_by("hos.completed_deliveries", "DESC");

		$result = $this->db->get()->result_array();

		// ✅ Add Sr. No
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

    // Jahez Report Data
    public function get_jahez_data($from, $to, $search = null) {
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			DATE_FORMAT(MIN(order_date), '%e/%b/%Y') AS from_date,
			DATE_FORMAT(MAX(order_date), '%e/%b/%Y') AS to_date,
			'Jahez' AS aggregator,

			-- Total Deliveries (full range)
			SUM(orders) AS total_deliveries,

			-- Notified Deliveries (always 0 for Jahez)
			SUM(CASE WHEN order_date = '{$last_date}' THEN orders ELSE 0 END) AS notified_deliveries,

			-- Completed Deliveries (last date only)
			SUM(CASE WHEN order_date = '{$last_date}' THEN orders ELSE 0 END) AS completed_deliveries,

			-- KPIs for last date only
			-- Total ops riders from logistic_rider table (with sponsor filter)
			(
			SELECT COUNT(DISTINCT lr2.employee_id)
			FROM logistic_rider lr2
			WHERE lr2.platform = '1'
				AND lr2.rider_status = 'active'
			) AS total_ops_riders,
			COUNT(DISTINCT CASE WHEN order_date = '{$last_date}' AND orders > 0 THEN emp_id END) AS active_riders,

			-- Planned hours = Total Ops Riders × 10
			(COUNT(DISTINCT CASE WHEN order_date = '{$last_date}' THEN emp_id END) * 10) AS planned_hours,

			0 AS avg_hours_variance,
			ROUND(
				SUM(CASE WHEN order_date = '{$last_date}' THEN orders ELSE 0 END) /
				NULLIF(COUNT(DISTINCT CASE WHEN order_date = '{$last_date}' AND orders > 0 THEN emp_id END), 0)
			) AS avg_dlvy_per_rider,
			'0%' AS percentage_difference,

			-- ✅ Riders with < 13 completed deliveries (last date only)
			COUNT(DISTINCT CASE 
				WHEN order_date = '{$last_date}' 
				AND orders < 13 
				THEN emp_id 
			END) AS riders_lt_13_orders
		");
		$this->db->from('maha_jahez_daily_summary');
		$this->db->join('logistic_rider lr', 'lr.employee_id = maha_jahez_daily_summary.emp_id', 'left');
		// Full range filter for total deliveries
		$this->db->where("order_date >=", date('Y-m-d', strtotime($from)));
		$this->db->where("order_date <=", date('Y-m-d', strtotime($to)));
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('maha_jahez_daily_summary.emp_id', $search);
		}
		return $this->db->get()->row_array();
	}

	//Get Employee in Maha Outsource Report
	public function jahez_orders_employees($from, $to, $search = null)
	{
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			lr.employee_id AS emp_id,
			me.emp_no,
			me.full_name AS emp_name,
			mjds.driver_id as rider_id,

			-- ✅ Deliveries in full range
			SUM(mjds.orders) AS total_deliveries,
			
			-- ✅ Completed Deliveries (last date only)
			SUM(CASE WHEN mjds.order_date = '{$last_date}' THEN mjds.orders ELSE 0 END) AS completed_deliveries,
			
			-- ✅ Active (yes/no for last date)
			CASE 
				WHEN SUM(CASE WHEN mjds.order_date = '{$last_date}' AND mjds.orders > 0 THEN 1 ELSE 0 END) > 0 
				THEN 'Active' 
				ELSE 'Inactive' 
			END AS status,
			
			-- ✅ Vehicle Type
			GROUP_CONCAT(DISTINCT mv.vehicle_type) AS vehicle_type,
			
			-- ✅ Avg deliveries (last date only)
			ROUND(
				SUM(CASE WHEN mjds.order_date = '{$last_date}' THEN mjds.orders ELSE 0 END) /
				NULLIF(COUNT(DISTINCT CASE WHEN mjds.order_date = '{$last_date}' THEN mjds.emp_id END), 0),
				2
			) AS avg_dlvy,

			-- ✅ Cash / Credits / Debits (last date only)
			SUM(CASE WHEN mjds.order_date = '{$last_date}' THEN mjds.cash_collection ELSE 0 END) AS last_cash_collection,
			SUM(CASE WHEN mjds.order_date = '{$last_date}' THEN mjds.driver_credit ELSE 0 END)   AS last_driver_credit,
			SUM(CASE WHEN mjds.order_date = '{$last_date}' THEN mjds.driver_debit ELSE 0 END)    AS last_driver_debit
		");
		$this->db->from('maha_jahez_daily_summary mjds');
		$this->db->join('logistic_rider lr', 'lr.employee_id = mjds.emp_id', 'left');
		$this->db->join('master_employee me', 'me.id = mjds.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = mjds.alloted_vehicle_id', 'left');

		// Date range
		$this->db->where("mjds.order_date >=", date('Y-m-d', strtotime($from)));
		$this->db->where("mjds.order_date <=", date('Y-m-d', strtotime($to)));
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('mjds.emp_id', $search);
		}
		// ✅ Only active Jahez riders (platform=1)
		$this->db->where("lr.platform", 1);
		$this->db->where("lr.rider_status", "active");
		$this->db->order_by("SUM(mjds.orders)", "DESC");
		$this->db->group_by("mjds.emp_id");

		$result = $this->db->get()->result_array();

		// Add Sr. No
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	public function hunger_low_delivery_employees($to, $platform = 'hunger', $search = null)
	{
		$this->db->select("
			me.id AS emp_id,
			me.emp_no,
			me.full_name AS emp_name,
			hos.rider_id,
			hos.completed_deliveries AS completed_deliveries,
			hos.working_hours AS online_hours,
			mv.vehicle_type,
			ROUND(hos.acceptance_rate) AS acceptance_rate
		");
		$this->db->from('hunger_order_summary hos');
		$this->db->join('master_employee me', 'me.id = hos.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = hos.alloted_vehicle_id', 'left');

		// ✅ Date filter (only $to)
		$this->db->where("hos.date_local", date('Y-m-d', strtotime($to)));

		// ✅ Platform filter
		//$this->db->where_in('me.sponsor_id', [1, 2, 5, 4]); // hunger (maha, wazer, outsource)

		// ✅ Active riders only
		$this->db->where("hos.working_hours >", 0);

		// ✅ Less than 13 deliveries
		$this->db->where("hos.completed_deliveries <", 13);
		if (!empty($search)) {
			$this->db->where('hos.emp_id', $search);
		}
		// ✅ Order by completed deliveries ASC
		$this->db->order_by("hos.completed_deliveries", "DESC");

		$result = $this->db->get()->result_array();

		// ✅ Add Sr. No
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	public function jahez_low_delivery_employees($to, $platform = 'jahez', $search = null)
	{
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			mjds.emp_id,
			me.emp_no,
			me.full_name AS emp_name,
			mjds.driver_id AS rider_id,
			SUM(mjds.orders) AS completed_deliveries,
			SUM(mjds.cash_collection) AS cash_collection,
			SUM(mjds.driver_credit)   AS driver_credit,
			SUM(mjds.driver_debit)    AS driver_debit,
			GROUP_CONCAT(DISTINCT mv.vehicle_type) AS vehicle_type
		");
		$this->db->from('maha_jahez_daily_summary mjds');
		$this->db->join('master_employee me', 'me.id = mjds.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = mjds.alloted_vehicle_id', 'left');

		$this->db->where('mjds.order_date', $last_date);
		
		$search = trim($search);
		if ($search !== '' && $search !== null) {
			$this->db->where('mjds.emp_id', $search);
		}

		$this->db->group_by('mjds.emp_id');
		$this->db->having('completed_deliveries <', 13);
		$this->db->order_by('completed_deliveries', 'DESC');
		$result = $this->db->get()->result_array();

		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	public function jahez_with_cod_employees($to, $platform = 'jahez', $search = null)
	{
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			mjds.emp_id,
			me.emp_no,
			me.full_name AS emp_name,
			mjds.driver_id AS rider_id,
			SUM(mjds.orders) AS completed_deliveries,
			SUM(mjds.cash_collection) AS cash_collection,
			SUM(mjds.driver_credit)   AS driver_credit,
			SUM(mjds.driver_debit)    AS driver_debit,
			GROUP_CONCAT(DISTINCT mv.vehicle_type) AS vehicle_type
		");
		$this->db->from('maha_jahez_daily_summary mjds');
		$this->db->join('master_employee me', 'me.id = mjds.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = mjds.alloted_vehicle_id', 'left');

		// ✅ Only filter by $to date
		$this->db->where("mjds.order_date", $last_date);
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('mjds.emp_id', $search);
		}
		// ✅ Group by employee
		$this->db->group_by("mjds.emp_id");

		// ✅ Only riders with cash
		$this->db->having("SUM(mjds.cash_collection) >", 0);

		$this->db->order_by("SUM(mjds.cash_collection)", "DESC");

		$result = $this->db->get()->result_array();

		// Add Sr. No
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	public function jahez_with_debit_employees($to, $platform = 'jahez', $search = null)
	{
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			mjds.emp_id,
			me.emp_no,
			me.full_name AS emp_name,
			mjds.driver_id AS rider_id,
			SUM(mjds.orders) AS completed_deliveries,
			SUM(mjds.cash_collection) AS cash_collection,
			SUM(mjds.driver_credit)   AS driver_credit,
			SUM(mjds.driver_debit)    AS driver_debit,
			GROUP_CONCAT(DISTINCT mv.vehicle_type) AS vehicle_type
		");
		$this->db->from('maha_jahez_daily_summary mjds');
		$this->db->join('master_employee me', 'me.id = mjds.emp_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = mjds.alloted_vehicle_id', 'left');

		// ✅ Only filter by $to date
		$this->db->where("mjds.order_date", $last_date);
		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('mjds.emp_id', $search);
		}
		// ✅ Group by employee
		$this->db->group_by("mjds.emp_id");

		// ✅ Only riders with debit
		$this->db->having("SUM(mjds.driver_debit) >", 0);

		$this->db->order_by("SUM(mjds.driver_debit)", "DESC");

		$result = $this->db->get()->result_array();

		// Add Sr. No
		foreach ($result as $i => &$row) {
			$row['sr_no'] = $i + 1;
		}

		return $result;
	}

	
    // Noon Report Data
	public function get_noon_data($from, $to, $search = null) {
		$last_date = date('Y-m-d', strtotime($to));

		$this->db->select("
			DATE_FORMAT(MIN(local_date), '%e/%b/%Y') AS from_date,
			DATE_FORMAT(MAX(local_date), '%e/%b/%Y') AS to_date,
			'Noon' AS aggregator,

			-- ✅ Total Deliveries (full range)
			SUM(delivered_orders) AS total_deliveries,

			-- ✅ Notified Deliveries (same as completed for Noon)
			SUM(CASE WHEN local_date = '{$last_date}' THEN delivered_orders ELSE 0 END) AS notified_deliveries,

			-- ✅ Completed Deliveries (last date only)
			SUM(CASE WHEN local_date = '{$last_date}' THEN delivered_orders ELSE 0 END) AS completed_deliveries,

			-- ✅ Total ops riders (count all riders on last_date)
			COUNT(DISTINCT CASE 
				WHEN local_date = '{$last_date}' 
				THEN emp_id 
			END) AS total_ops_riders,

			-- ✅ Active riders (last date only, >0 deliveries)
			COUNT(DISTINCT CASE 
				WHEN local_date = '{$last_date}' 
				AND delivered_orders > 0 
				THEN emp_id 
			END) AS active_riders,

			-- ✅ Planned hours (not applicable for Noon → always 0)
			0 AS planned_hours,

			-- ✅ Avg. working hours variance (not applicable for Noon → always 0)
			0 AS avg_hours_variance,

			-- ✅ Avg deliveries per rider
			ROUND(
				SUM(CASE WHEN local_date = '{$last_date}' THEN delivered_orders ELSE 0 END) /
				NULLIF(COUNT(DISTINCT CASE 
					WHEN local_date = '{$last_date}' 
					AND delivered_orders > 0 
					THEN emp_id 
				END), 0)
			) AS avg_dlvy_per_rider,

			-- ✅ % Difference (not applicable → always 0%)
			'0%' AS percentage_difference,

			-- ✅ Riders with < 13 completed deliveries (last date only)
			COUNT(DISTINCT CASE 
				WHEN local_date = '{$last_date}' 
				AND delivered_orders < 13 
				THEN emp_id 
			END) AS riders_lt_13_orders
		");
		$this->db->from('noon_order_summary');

		// ✅ Full range filter for total deliveries
		$this->db->where("local_date >=", date('Y-m-d', strtotime($from)));
		$this->db->where("local_date <=", date('Y-m-d', strtotime($to)));

		// ✅ Emp ID filter (agar diya ho)
		if (!empty($search)) {
			$this->db->where('noon_order_summary.emp_id', $search);
		}

		return $this->db->get()->row_array();
	}


	//New Attendance Summary
	private function get_attendance_summary_fields()
	{
		return "
			SUM(CASE WHEN mea.attend_type = 'A'  THEN 1 ELSE 0 END) AS Absent,
			SUM(CASE WHEN mea.attend_type = 'L'  THEN 1 ELSE 0 END) AS `Leave`,
			SUM(CASE WHEN mea.attend_type = 'AC' THEN 1 ELSE 0 END) AS Accident,
			SUM(CASE WHEN mea.attend_type = 'AL' THEN 1 ELSE 0 END) AS Annual_Leave,
			SUM(CASE WHEN mea.attend_type = 'BT' THEN 1 ELSE 0 END) AS Business_Trip,
			SUM(CASE WHEN mea.attend_type = 'CL' THEN 1 ELSE 0 END) AS Casual_Leave,
			SUM(CASE WHEN mea.attend_type = 'COL' THEN 1 ELSE 0 END) AS Compassionate_Leave,
			SUM(CASE WHEN mea.attend_type = 'HI' THEN 1 ELSE 0 END) AS Health_Issue,
			SUM(CASE WHEN mea.attend_type = 'ID' THEN 1 ELSE 0 END) AS ID_Issue,
			SUM(CASE WHEN mea.attend_type = 'IQ' THEN 1 ELSE 0 END) AS Iqama_Issue,
			SUM(CASE WHEN mea.attend_type = 'MAR' THEN 1 ELSE 0 END) AS Marriage_Leave,
			SUM(CASE WHEN mea.attend_type = 'MI' THEN 1 ELSE 0 END) AS Mobile_Issue,
			SUM(CASE WHEN mea.attend_type = 'ML' THEN 1 ELSE 0 END) AS Maternity_Leave,
			SUM(CASE WHEN mea.attend_type = 'PL' THEN 1 ELSE 0 END) AS Paternity_Leave,
			SUM(CASE WHEN mea.attend_type = 'SI' THEN 1 ELSE 0 END) AS Sponsorship_Issue,
			SUM(CASE WHEN mea.attend_type = 'SL' THEN 1 ELSE 0 END) AS Sick_Leave,
			SUM(CASE WHEN mea.attend_type = 'UL' THEN 1 ELSE 0 END) AS Unpaid_Leave,
			SUM(CASE WHEN mea.attend_type = 'WL' THEN 1 ELSE 0 END) AS Widow_Leave,
			SUM(CASE WHEN mea.attend_type = 'WO' THEN 1 ELSE 0 END) AS Week_Off
		";
	}

	public function maha_absent_summary($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));

		$this->db->select($this->get_attendance_summary_fields(), false);
		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');

		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');
		$this->db->where('ml.platform_id', '2');
		$this->db->where_in('me.sponsor_id', [1, 2]);
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->group_by('ml.platform_id');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function wazer_absent_summary($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));

		$this->db->select($this->get_attendance_summary_fields(), false);
		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');

		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');
		$this->db->where('ml.platform_id', '2');
		$this->db->where('me.sponsor_id', '5');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->group_by('ml.platform_id');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function outsource_absent_summary($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));

		$this->db->select($this->get_attendance_summary_fields(), false);
		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');

		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');
		$this->db->where('ml.platform_id', '2');
		$this->db->where('me.sponsor_id', '4');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->group_by('ml.platform_id');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function jahez_absent_summary($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));

		$this->db->select($this->get_attendance_summary_fields(), false);
		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');

		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');
		$this->db->where('ml.platform_id', '1');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->group_by('ml.platform_id');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function nonoperational_absent_summary($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));

		$this->db->select($this->get_attendance_summary_fields(), false);
		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');

		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->group_start()
			->where('mea.aggregator_id', '')
			->or_where('mea.aggregator_id IS NULL', null, false)
		->group_end();
		$query = $this->db->get();
		return $query->result_array();
	}


	// Hunger Maha, Wazer, Outsource and Jahez Absent Employees List
	public function maha_absent_employees($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));
		$this->db->select("
			me.id AS emp_id,
			me.emp_no AS emp_code,
			me.full_name AS emp_name,
			ml.id_number AS rider_id,
			mv.vehicle_type,
			mea.attend_type AS attendance,
			CASE 
				WHEN mea.attend_type = 'A'  THEN 'Absent'
				WHEN mea.attend_type = 'L'  THEN 'Leave'
				WHEN mea.attend_type = 'AC' THEN 'Accident'
				WHEN mea.attend_type = 'AL' THEN 'Annual Leave'
				WHEN mea.attend_type = 'BT' THEN 'Business Trip'
				WHEN mea.attend_type = 'CL' THEN 'Casual Leave'
				WHEN mea.attend_type = 'COL' THEN 'Compassionate Leave'
				WHEN mea.attend_type = 'HI' THEN 'Health Issue'
				WHEN mea.attend_type = 'ID' THEN 'ID Issue'
				WHEN mea.attend_type = 'IQ' THEN 'Iqama Issue'
				WHEN mea.attend_type = 'MAR' THEN 'Marriage Leave'
				WHEN mea.attend_type = 'MI' THEN 'Mobile Issue'
				WHEN mea.attend_type = 'ML' THEN 'Maternity Leave'
				WHEN mea.attend_type = 'PL' THEN 'Paternity Leave'
				WHEN mea.attend_type = 'SI' THEN 'Sponsorship Issue'
				WHEN mea.attend_type = 'SL' THEN 'Sick Leave'
				WHEN mea.attend_type = 'UL' THEN 'Unpaid Leave'
				WHEN mea.attend_type = 'WL' THEN 'Widow Leave'
				WHEN mea.attend_type = 'WO' THEN 'Week Off'
				ELSE 'Other'
			END AS reason,
			me.sponsor_id
		", false);

		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');
		$this->db->join('master_vehicles mv', 'mv.id = mea.vehicle_id', 'left');

		// Filter date & absent only
		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');

		// Platform filter (Hunger)
		$this->db->where('ml.platform_id', '2');

		// Sponsor filter
		$this->db->where_in('me.sponsor_id', [1, 2]);
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->order_by('mea.attend_type ASC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function wazer_absent_employees($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));
		$this->db->select("
			me.id AS emp_id,
			me.emp_no AS emp_code,
			me.full_name AS emp_name,
			ml.id_number AS rider_id,
			mv.vehicle_type,
			mea.attend_type AS attendance,
			CASE 
				WHEN mea.attend_type = 'A'  THEN 'Absent'
				WHEN mea.attend_type = 'L'  THEN 'Leave'
				WHEN mea.attend_type = 'AC' THEN 'Accident'
				WHEN mea.attend_type = 'AL' THEN 'Annual Leave'
				WHEN mea.attend_type = 'BT' THEN 'Business Trip'
				WHEN mea.attend_type = 'CL' THEN 'Casual Leave'
				WHEN mea.attend_type = 'COL' THEN 'Compassionate Leave'
				WHEN mea.attend_type = 'HI' THEN 'Health Issue'
				WHEN mea.attend_type = 'ID' THEN 'ID Issue'
				WHEN mea.attend_type = 'IQ' THEN 'Iqama Issue'
				WHEN mea.attend_type = 'MAR' THEN 'Marriage Leave'
				WHEN mea.attend_type = 'MI' THEN 'Mobile Issue'
				WHEN mea.attend_type = 'ML' THEN 'Maternity Leave'
				WHEN mea.attend_type = 'PL' THEN 'Paternity Leave'
				WHEN mea.attend_type = 'SI' THEN 'Sponsorship Issue'
				WHEN mea.attend_type = 'SL' THEN 'Sick Leave'
				WHEN mea.attend_type = 'UL' THEN 'Unpaid Leave'
				WHEN mea.attend_type = 'WL' THEN 'Widow Leave'
				WHEN mea.attend_type = 'WO' THEN 'Week Off'
				ELSE 'Other'
			END AS reason,
			me.sponsor_id
		", false);

		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');
		$this->db->join('master_vehicles mv', 'mv.id = mea.vehicle_id', 'left');

		// Only absent on last day
		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');

		// Platform filter
		$this->db->where('ml.platform_id', '2');
		$this->db->where('me.sponsor_id', '5');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->order_by('mea.attend_type ASC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function outsource_absent_employees($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));
		$this->db->select("
			me.id AS emp_id,
			me.emp_no AS emp_code,
			me.full_name AS emp_name,
			ml.id_number AS rider_id,
			mv.vehicle_type,
			mea.attend_type AS attendance,
			CASE 
				WHEN mea.attend_type = 'A'  THEN 'Absent'
				WHEN mea.attend_type = 'L'  THEN 'Leave'
				WHEN mea.attend_type = 'AC' THEN 'Accident'
				WHEN mea.attend_type = 'AL' THEN 'Annual Leave'
				WHEN mea.attend_type = 'BT' THEN 'Business Trip'
				WHEN mea.attend_type = 'CL' THEN 'Casual Leave'
				WHEN mea.attend_type = 'COL' THEN 'Compassionate Leave'
				WHEN mea.attend_type = 'HI' THEN 'Health Issue'
				WHEN mea.attend_type = 'ID' THEN 'ID Issue'
				WHEN mea.attend_type = 'IQ' THEN 'Iqama Issue'
				WHEN mea.attend_type = 'MAR' THEN 'Marriage Leave'
				WHEN mea.attend_type = 'MI' THEN 'Mobile Issue'
				WHEN mea.attend_type = 'ML' THEN 'Maternity Leave'
				WHEN mea.attend_type = 'PL' THEN 'Paternity Leave'
				WHEN mea.attend_type = 'SI' THEN 'Sponsorship Issue'
				WHEN mea.attend_type = 'SL' THEN 'Sick Leave'
				WHEN mea.attend_type = 'UL' THEN 'Unpaid Leave'
				WHEN mea.attend_type = 'WL' THEN 'Widow Leave'
				WHEN mea.attend_type = 'WO' THEN 'Week Off'
				ELSE 'Other'
			END AS reason,
			me.sponsor_id
		", false);

		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');
		$this->db->join('master_vehicles mv', 'mv.id = mea.vehicle_id', 'left');

		// Only absent on last day
		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');

		// Platform filter
		$this->db->where('ml.platform_id', '2');
		$this->db->where('me.sponsor_id', '4');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->order_by('mea.attend_type ASC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function jahez_absent_employees($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));
		$this->db->select("
			me.id AS emp_id,
			me.emp_no AS emp_code,
			me.full_name AS emp_name,
			ml.id_number AS rider_id,
			mv.vehicle_type,
			mea.attend_type AS attendance,
			CASE 
				WHEN mea.attend_type = 'A'  THEN 'Absent'
				WHEN mea.attend_type = 'L'  THEN 'Leave'
				WHEN mea.attend_type = 'AC' THEN 'Accident'
				WHEN mea.attend_type = 'AL' THEN 'Annual Leave'
				WHEN mea.attend_type = 'BT' THEN 'Business Trip'
				WHEN mea.attend_type = 'CL' THEN 'Casual Leave'
				WHEN mea.attend_type = 'COL' THEN 'Compassionate Leave'
				WHEN mea.attend_type = 'HI' THEN 'Health Issue'
				WHEN mea.attend_type = 'ID' THEN 'ID Issue'
				WHEN mea.attend_type = 'IQ' THEN 'Iqama Issue'
				WHEN mea.attend_type = 'MAR' THEN 'Marriage Leave'
				WHEN mea.attend_type = 'MI' THEN 'Mobile Issue'
				WHEN mea.attend_type = 'ML' THEN 'Maternity Leave'
				WHEN mea.attend_type = 'PL' THEN 'Paternity Leave'
				WHEN mea.attend_type = 'SI' THEN 'Sponsorship Issue'
				WHEN mea.attend_type = 'SL' THEN 'Sick Leave'
				WHEN mea.attend_type = 'UL' THEN 'Unpaid Leave'
				WHEN mea.attend_type = 'WL' THEN 'Widow Leave'
				WHEN mea.attend_type = 'WO' THEN 'Week Off'
				ELSE 'Other'
			END AS reason,
			me.sponsor_id
		", false);

		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'inner');
		$this->db->join('master_vehicles mv', 'mv.id = mea.vehicle_id', 'left');

		// Only absent on last day
		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');

		// Platform filter
		$this->db->where('ml.platform_id', '1');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->order_by('mea.attend_type ASC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function nonoperational_absent_employees($last_day, $search = null)
	{
		$last_day = date('Y-m-d', strtotime($last_day));
		$this->db->select("
			me.id AS emp_id,
			me.emp_no AS emp_code,
			me.full_name AS emp_name,
			ml.id_number AS rider_id,
			mv.vehicle_type,
			mea.attend_type AS attendance,
			CASE 
				WHEN mea.attend_type = 'A'  THEN 'Absent'
				WHEN mea.attend_type = 'L'  THEN 'Leave'
				WHEN mea.attend_type = 'AC' THEN 'Accident'
				WHEN mea.attend_type = 'AL' THEN 'Annual Leave'
				WHEN mea.attend_type = 'BT' THEN 'Business Trip'
				WHEN mea.attend_type = 'CL' THEN 'Casual Leave'
				WHEN mea.attend_type = 'COL' THEN 'Compassionate Leave'
				WHEN mea.attend_type = 'HI' THEN 'Health Issue'
				WHEN mea.attend_type = 'ID' THEN 'ID Issue'
				WHEN mea.attend_type = 'IQ' THEN 'Iqama Issue'
				WHEN mea.attend_type = 'MAR' THEN 'Marriage Leave'
				WHEN mea.attend_type = 'MI' THEN 'Mobile Issue'
				WHEN mea.attend_type = 'ML' THEN 'Maternity Leave'
				WHEN mea.attend_type = 'PL' THEN 'Paternity Leave'
				WHEN mea.attend_type = 'SI' THEN 'Sponsorship Issue'
				WHEN mea.attend_type = 'SL' THEN 'Sick Leave'
				WHEN mea.attend_type = 'UL' THEN 'Unpaid Leave'
				WHEN mea.attend_type = 'WL' THEN 'Widow Leave'
				WHEN mea.attend_type = 'WO' THEN 'Week Off'
				ELSE 'Other'
			END AS reason,
			me.sponsor_id
		", false);

		$this->db->from('maha_employee_attendance mea');
		$this->db->join('master_employee me', 'me.id = mea.emp_id', 'left');
		$this->db->join('master_logistic_ids ml', 'ml.id_number = mea.aggregator_id', 'left');
		$this->db->join('master_vehicles mv', 'mv.id = mea.vehicle_id', 'left');

		// Only absent on last day
		$this->db->where('mea.date_of_attend', $last_day);
		$this->db->where('mea.attend_type !=', 'P');
		if (!empty($search)) {
			$this->db->where('mea.emp_id', $search);
		}
		$this->db->group_start()
			->where('mea.aggregator_id', '')
			->or_where('mea.aggregator_id IS NULL', null, false)
		->group_end();
		$this->db->order_by('mea.attend_type ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	/*------ Overall Report End ------*/
}
