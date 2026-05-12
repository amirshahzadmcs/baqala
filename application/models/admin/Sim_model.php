<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sim_model extends CI_Model{

	function add(){
	    if(!empty($_POST['is_gps_sim'])) {
			$is_gps_sim = 'on';
		} else {
			$is_gps_sim = 'off';
		}
		$owner_name = $this->input->post('ownership_type') == 'corporate' 
			? $this->input->post('owner_name_dropdown')  // Save sponsor ID
			: $this->input->post('owner_name_text');  // Save entered name
		$query = $this->db->query("INSERT INTO sim_card SET sim_type = '" . $this->db->escape_str($this->input->post('sim_type')) . "', is_gps_sim = '" . $this->db->escape_str($is_gps_sim) . "', gps_installed_vehicle = '" . $this->db->escape_str($this->input->post('gps_installed_vehicle')) . "', date_of_purchase = '" . $this->db->escape_str($this->input->post('date_of_purchase')) . "', network = '" . $this->db->escape_str($this->input->post('network')) . "', plan = '" . $this->db->escape_str($this->input->post('plan')) . "', internet_data = '" . $this->db->escape_str($this->input->post('internet_data')) . "', sim_no = '" . $this->db->escape_str($this->input->post('sim_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', ownership_type = '" . $this->db->escape_str($this->input->post('ownership_type')) . "', owner_name = '" . $this->db->escape_str($owner_name) . "', owner_id = '" . $this->db->escape_str($this->input->post('owner_id')) . "', status = '0', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
	    if(!empty($_POST['is_gps_sim'])) {
			$is_gps_sim = 'on';
		} else {
			$is_gps_sim = 'off';
		}
		$owner_name = $this->input->post('ownership_type') == 'corporate' 
			? $this->input->post('owner_name_dropdown')  // Save sponsor ID
			: $this->input->post('owner_name_text');  // Save entered name
		$query = $this->db->query("UPDATE sim_card SET sim_type = '" . $this->db->escape_str($this->input->post('sim_type')) . "', is_gps_sim = '" . $this->db->escape_str($is_gps_sim) . "', gps_installed_vehicle = '" . $this->db->escape_str($this->input->post('gps_installed_vehicle')) . "', date_of_purchase = '" . $this->db->escape_str($this->input->post('date_of_purchase')) . "', network = '" . $this->db->escape_str($this->input->post('network')) . "', plan = '" . $this->db->escape_str($this->input->post('plan')) . "', internet_data = '" . $this->db->escape_str($this->input->post('internet_data')) . "', sim_no = '" . $this->db->escape_str($this->input->post('sim_no')) . "', mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', ownership_type = '" . $this->db->escape_str($this->input->post('ownership_type')) . "', owner_name = '" . $this->db->escape_str($owner_name) . "', owner_id = '" . $this->db->escape_str($this->input->post('owner_id')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "' AND status != '3'");
		return $query;
	}
	
	public function get_sim_status($id)
	{
		$this->db->select('status, allotment');
		$this->db->from('sim_card');
		$this->db->where('id', $id);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return NULL;
		}
	}

	public function update_sim_status($id, $alloted_user, $data)
	{
		$this->db->where('id', $id);
		$query = $this->db->update('sim_card', $data);
		if ($data['status'] != '2') {
			$status_date = date('Y-m-d');
			$status = 4;
		}else{
			$status_date = $data['date_of_discontinued'];
			$status = 5;
		}
		if ($query) {
			$this->db->query("INSERT INTO sim_logs SET 
				status_date = '" . $this->db->escape_str($status_date) . "', 
				sim_id = '" . $id . "', 
				user_id = '" . $alloted_user . "', 
				status = '" . $status . "', 
				created_at = NOW(), 
				updated_at = NOW()");
		}
		return $query;
	}

	function make_query($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no){
		$a = "SELECT s.*, mp.plan_name, mn.network_name, me.emp_no, me.full_name as emp_full_name FROM sim_card s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN master_plans as mp ON (s.plan = mp.id) LEFT JOIN master_network as mn ON (s.network = mn.id) WHERE 1=1";
		if($network){
			$a .= " AND s.network = '" . $network . "'";
		}
		if($user){
			$a .= " AND s.alloted_user = '" . $user . "'";
		}
		if($plan){
			$a .= " AND s.plan = '" . $plan . "'";
		}
		if($status){
			if($status == 'new'){
				$a .= " AND s.status = '0'";
			}
			if($status == 'active'){
				$a .= " AND s.status = '1'";
			}
			if($status == 'discontinued'){
				$a .= " AND s.status = '2'";
			}
			if($status == 'port'){
				$a .= " AND s.status = '3'";
			}
		}
		if($sim_type){
			$a .= " AND s.sim_type = '" . $sim_type . "'";
		}
		if($is_gps_sim){
			$a .= " AND s.is_gps_sim = '" . $is_gps_sim . "'";
		}
		if($allot_status){
			if($allot_status == 'new'){
				$a .= " AND s.allotment = '0'";
			}
			if($allot_status == 'alloted'){
				$a .= " AND s.allotment = '1'";
			}
			if($allot_status == 'unalloted'){
				$a .= " AND s.allotment = '2'";
			}
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND s.activation_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if($keyword){
			$a .= " AND (s.owner_name LIKE '%".$keyword."%' OR s.owner_id LIKE '%".$keyword."%' OR s.mobile LIKE '%".$keyword."%')";
		}
		if($sim_no){
			$a .= " AND s.sim_no LIKE '%".$sim_no."%'";
		}
		return $a;
	}
	
	function get_list($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no){
		$a = $this->make_query($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no);
		/*
		if(isset($_POST["order"])){             
			$a .= " ORDER BY s.owner_name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY s.created_at DESC";		   
        }*/
		$a .= " ORDER BY s.created_at DESC";
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no){
	   $a = $this->make_query($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('sim_card');  
	   return $this->db->count_all_results();
    }

	function print_list($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no){
		$a = $this->make_query($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no);
		$a .= " ORDER BY s.created_at DESC";     
        $query = $this->db->query($a);  
        return $query->result();  
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM sim_card WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM sim_card WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	function get_sim_detail($id) {
		$this->db->select('
			s.*, 
			mp.plan_name, 
			mn.network_name, 
			me.full_name AS emp_full_name, 
			me.emp_no, 
			me.iqama_no, 
			me.passport_no, 
			me.nationality, 
			mjt.name AS designation_name, 
			md.name AS department_name, 
			mnn.name AS nationality_name
		');
		$this->db->from('sim_card s');
		$this->db->join('master_employee me', 's.alloted_user = me.id', 'left');
		$this->db->join('master_plans mp', 's.plan = mp.id', 'left');
		$this->db->join('master_network mn', 's.network = mn.id', 'left');
		$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
		$this->db->join('master_department md', 'me.department = md.id', 'left');
		$this->db->join('master_nationality mnn', 'me.nationality = mnn.id', 'left');
		$this->db->where('s.id', (int)$id);
		
		$query = $this->db->get();
		return $query->row();
	}

	function get_print_detail($id) {
		$this->db->select('
			s.*, 
			mp.plan_name, 
			mn.network_name, 
			me.full_name AS emp_full_name, 
			me.emp_no, 
			me.iqama_no, 
			me.passport_no, 
			me.nationality, 
			mei.driving_license_number,
			mjt.name AS designation_name, 
			md.name AS department_name, 
			mnn.name AS nationality_name,
			lr.id_number AS aggregator_id_number,
			fdc.company_name AS aggregator_name,
		');
		$this->db->from('sim_card s');
		$this->db->join('master_employee me', 's.alloted_user = me.id', 'left');
		$this->db->join('master_employee_info mei', 's.alloted_user = mei.employee_id', 'left');
		$this->db->join('master_plans mp', 's.plan = mp.id', 'left');
		$this->db->join('master_network mn', 's.network = mn.id', 'left');
		$this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
		$this->db->join('master_department md', 'me.department = md.id', 'left');
		$this->db->join('master_nationality mnn', 'me.nationality = mnn.id', 'left');
		$this->db->join('logistic_rider lr', 's.alloted_user = lr.employee_id', 'left');
		$this->db->join('food_deliv_companies fdc', 'lr.platform = fdc.id', 'left');
		$this->db->where('s.id', (int)$id);
		
		$query = $this->db->get();
		return $query->row();
	}
	
	public function employeeHasActiveSim($employee_id, $exclude_sim_id = null)
	{
		$this->db->from('sim_card');
		$this->db->where('alloted_user', $employee_id);
		$this->db->where('allotment', 1); // active allotment

		// optional safety: ignore discontinued sims
		$this->db->where('status !=', 'discontinued');

		// used when updating same SIM
		if ($exclude_sim_id) {
			$this->db->where('id !=', $exclude_sim_id);
		}

		return $this->db->count_all_results() > 0;
	}

	// public function get_unalloted_employees()
	// {
	// 	//$query = $this->db->query("SELECT me.* FROM master_employee me WHERE (me.status = 'Active' AND me.id NOT IN (SELECT alloted_user FROM sim_card WHERE alloted_user IS NOT NULL))");
	// 	$query = $this->db->query("SELECT me.* FROM master_employee me WHERE (me.status = 'Active')");
    //     return $query->result_array(); 
	// }
	public function get_unalloted_employees()
	{
		$query = $this->db->query("
			SELECT 
				me.*, 
				COUNT(sc.id) AS sim_count 
			FROM 
				master_employee me 
			LEFT JOIN 
				sim_card sc 
			ON 
				me.id = sc.alloted_user 
			WHERE 
				me.status = 'Active'
			GROUP BY 
				me.id
		");
		return $query->result_array(); 
	}

	public function get_unalloted_vehicle()
	{
		$query = $this->db->query("SELECT mv.* FROM master_vehicles mv WHERE (mv.status = 'active' AND mv.id NOT IN (SELECT gps_installed_vehicle FROM sim_card WHERE gps_installed_vehicle IS NOT NULL))");
        return $query->result_array(); 
	}

	public function get_unalloted_vehicle2($current_user)
	{
		$query = $this->db->query("SELECT mv.* FROM master_vehicles mv WHERE (mv.status = 'active' AND mv.id NOT IN (SELECT gps_installed_vehicle FROM sim_card WHERE gps_installed_vehicle != '". $current_user ."' AND gps_installed_vehicle IS NOT NULL))");
        return $query->result_array(); 
	}

	public function get_plan($id,$sim_type)
	{
		$query = $this->db->query("SELECT id, plan_name, sim_type FROM master_plans WHERE network_id = '". (int)$id ."' AND sim_type = '". $sim_type ."' AND status = '1'");
		return $query->result();
	}

// 	public function getUnallotedSims()
// 	{
// 		$query = $this->db->query("SELECT s.* FROM sim_card s WHERE s.status = '1' AND s.mobile NOT IN (SELECT sim.sim_no from sim_allot as sim WHERE sim.status=1)");
// 		return $query->result();
// 	}
	
// 	public function getAllotedSims()
// 	{
// 		$query = $this->db->query("SELECT s.* FROM sim_card s WHERE s.status = '1' AND s.mobile IN (SELECT sim.sim_no from sim_allot as sim WHERE sim.status=1) AND 1=1");
// 		return $query->result();
// 	}

	public function get_sims()
	{
		$a = "SELECT s.*, s.status as allot_status FROM sim_card s WHERE s.allotment > 0 ORDER BY s.owner_name ASC";
		$query = $this->db->query($a);  
        return $query->result();
	}

	function check_duplicate_mobile($id, $mobile_no){
		$this->db->select("*");  
		$this->db->from('sim_card'); 
		$this->db->where('id !=',$id);
		$this->db->where('status !=','3');
		$this->db->where('mobile =',$mobile_no);
		return $this->db->count_all_results();  
	}

	function check_duplicate_simno($id, $sim_no){
		$this->db->select("*");  
		$this->db->from('sim_card'); 
		$this->db->where('id !=',$id);
		$this->db->where('sim_no =',$sim_no);
		return $this->db->count_all_results();  
	}
	
	function update_allotment_status(){
	    if($this->input->post('allot_status') == '1'){
	        $user_id = $this->db->escape_str($this->input->post('alloted_user'));
	    }else{
	        $user_id = '';
	    }
		$query = $this->db->query("UPDATE sim_card SET allotment_date = '" . $this->db->escape_str($this->input->post('status_date')) . "', alloted_user = '" . $user_id . "', allotment = '" . $this->db->escape_str($this->input->post('allot_status')) . "', status = '1', updated_at = now() WHERE id = '" . (int)$this->input->post('sim_id') . "'");
		if($query){
			$this->db->query("INSERT INTO sim_logs SET status_date = '" . $this->db->escape_str($this->input->post('status_date')) . "', sim_id = '" . $this->db->escape_str($this->input->post('sim_id')) . "', user_id = '" . $this->db->escape_str($this->input->post('alloted_user')) . "', status = '" . $this->db->escape_str($this->input->post('allot_status')) . "', created_at = NOW(), updated_at = now()");
		}
		return $query;
	}
	
	public function getLogs($id)
	{
		$query = $this->db->query("SELECT sl.*, sc.mobile, sc.sim_no, me.full_name FROM sim_logs sl LEFT JOIN sim_card sc ON (sl.sim_id = sc.id) LEFT JOIN master_employee me ON (sl.user_id = me.id) WHERE sl.sim_id = '" . $id . "' ORDER BY id DESC");
		return $query->result();
	}

	/*------- Port Inn -----*/

	public function get_running_sims()
	{
		$a = "SELECT s.*, s.status as allot_status FROM sim_card s WHERE s.allotment > 0 AND s.status != '3' ORDER BY s.owner_name ASC";
		$query = $this->db->query($a);  
        return $query->result();
	}

	function make_port_query($network,$startDate,$endDate,$keyword){
		$a = "SELECT p.*, mp.plan_name, omp.network_name as old_provider_name, mn.network_name as new_provider_name FROM sim_port_history p LEFT JOIN master_plans as mp ON (p.new_plan = mp.id) LEFT JOIN master_network as omp ON (p.old_service_provider = omp.id) LEFT JOIN master_network as mn ON (p.new_service_provider = mn.id) WHERE 1=1";
		if($network){
			$a .= " AND (p.old_service_provider = '" . $network . "' OR p.new_service_provider = '" . $network . "')";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND (p.port_date BETWEEN '".$period_start."' AND '".$period_end."')";
		}
		if($keyword){
			$a .= " AND (p.mobile_no LIKE '%".$keyword."%')";
		}
		return $a;
	}
	
	function get_port_list($network,$startDate,$endDate,$keyword){
		$a = $this->make_port_query($network,$startDate,$endDate,$keyword);
		
		if(isset($_POST["order"])){             
			$a .= " ORDER BY p.mobile_no ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY p.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_port_data($network,$startDate,$endDate,$keyword){
	   $a = $this->make_port_query($network,$startDate,$endDate,$keyword);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_port_data(){
	   $this->db->select("*");  
	   $this->db->from('sim_port_history');  
	   return $this->db->count_all_results();
    }
	
	
	public function update_replace_sim($id, $new_data) {
        $this->db->where('id', $id);
        return $this->db->update('sim_card', $new_data);
    }

	public function log_replacement($log_data) {
        $log_data_json = json_encode($log_data);
        return $this->db->insert('sim_replace_log', array('sim_id'=>$log_data['sim_id'], 'log_detail' => $log_data_json, 'created_at' => $log_data['created_at']));
    }
	
	public function get_log_history($id) {
        $this->db->select('id, sim_id, log_detail, created_at');
        $this->db->from('sim_replace_log');
		$this->db->where('sim_id', $id);
        $this->db->order_by('created_at', 'DESC'); // Order by most recent first
        $query = $this->db->get();
        return $query->result_array(); // Return results as an associative array
    }
}
