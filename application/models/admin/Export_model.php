<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Export_model extends CI_Model {
	
	function export_products(){
		$a = "SELECT ps.*, p.*, IF(p.cod_available > 0, 'YES', 'NO') as cod_availability, IF(p.status > 0, 'Active', 'Inactive') as status_availability, mb.brand_name, c.name as sub_cat_name, mu.unit_name, apr.rack_name, aps.shelf_name, (select ct.name from product_to_category ptc LEFT JOIN category ct ON (ct.id = ptc.category_id) WHERE ptc.product_id = p.id AND ptc.level = '2') as main_cat_name FROM product_size ps LEFT JOIN product p ON (ps.product_id = p.id) LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) LEFT JOIN master_unit mu ON (ps.size_unit = mu.id) LEFT JOIN admin_product_rack apr ON (ps.rack = apr.id) LEFT JOIN admin_product_shelf aps ON (ps.shelf = aps.id) WHERE p.id > 0 ORDER BY p.id ASC";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}  
	
	function export_active_products(){
		$a = "SELECT p.*, IF(p.cod_available > 0, 'YES', 'NO') as cod_availability, IF(p.status > 0, 'Active', 'Inactive') as status_availability, mb.brand_name, c.name as sub_cat_name, (select ct.name from product_to_category ptc LEFT JOIN category ct ON (ct.id = ptc.category_id) WHERE ptc.product_id = p.id AND ptc.level = '2') as main_cat_name FROM product p LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) WHERE p.status = '1'";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}
	
	function export_deactive_products(){
		$a = "SELECT p.*, IF(p.cod_available > 0, 'YES', 'NO') as cod_availability, IF(p.status > 0, 'Active', 'Inactive') as status_availability, mb.brand_name, c.name as sub_cat_name, (select ct.name from product_to_category ptc LEFT JOIN category ct ON (ct.id = ptc.category_id) WHERE ptc.product_id = p.id AND ptc.level = '2') as main_cat_name FROM product p LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) WHERE p.status = '0'";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}
	
	function export_missimg_products(){
		$a = "SELECT p.*, IF(p.cod_available > 0, 'YES', 'NO') as cod_availability, IF(p.status > 0, 'Active', 'Inactive') as status_availability, mb.brand_name, c.name as sub_cat_name, (select ct.name from product_to_category ptc LEFT JOIN category ct ON (ct.id = ptc.category_id) WHERE ptc.product_id = p.id AND ptc.level = '2') as main_cat_name FROM product p LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) WHERE p.image = '' OR p.image IS NULL";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}
	
	function export_missarabic_products(){
		$a = "SELECT p.*, IF(p.cod_available > 0, 'YES', 'NO') as cod_availability, IF(p.status > 0, 'Active', 'Inactive') as status_availability, mb.brand_name, c.name as sub_cat_name, (select ct.name from product_to_category ptc LEFT JOIN category ct ON (ct.id = ptc.category_id) WHERE ptc.product_id = p.id AND ptc.level = '2') as main_cat_name FROM product p LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) WHERE p.name_ar = ''";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}
	
	function export_misssku_products(){
		$a = "SELECT p.*, IF(p.cod_available > 0, 'YES', 'NO') as cod_availability, IF(p.status > 0, 'Active', 'Inactive') as status_availability, mb.brand_name, c.name as sub_cat_name, (select ct.name from product_to_category ptc LEFT JOIN category ct ON (ct.id = ptc.category_id) WHERE ptc.product_id = p.id AND ptc.level = '2') as main_cat_name FROM product p LEFT JOIN master_brands mb ON (mb.id = p.brand_id) LEFT JOIN category c ON (c.id = p.main_category) WHERE p.parent_sku = ''";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}

	/*----- Inventory -----*/

	function export_product_stock(){
		$a = "SELECT ps.*, (ps.unit_price*stock) AS total_price, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE p.id > 0";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	}

	function export_inventory_instock(){
		$a = "SELECT ps.*, (ps.unit_price*stock) AS total_price, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE ps.stock > 0";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	} 

	function export_inventory_outstock(){
		$a = "SELECT ps.*, (ps.unit_price*stock) AS total_price, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE ps.stock <= 0";
		$queries = $this->db->query($a);
		return $queries->result_array();  
	} 
	
	function print_sim_list($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no){
	    $a = "SELECT s.*, mp.plan_name, mn.network_name, IF (s.allotment > 0, me.full_name, 'NA') whole_name, IF (s.allotment > 0, me.emp_no, 'NA') emp_id FROM sim_card s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN master_plans as mp ON (s.plan = mp.id) LEFT JOIN master_network as mn ON (s.network = mn.id) WHERE 1=1";
		//$a = "SELECT s.*, mp.plan_name, mn.network_name, IF (s.allotment > 0, (SELECT CONCAT_WS(master_employee.first_name, ' ', master_employee.surname) AS whole_name FROM sim_allot LEFT JOIN master_employee ON (sim_allot.user_no = master_employee.id) LIMIT 1), 'NA') alloted_user FROM sim_card s LEFT JOIN master_plans as mp ON (s.plan = mp.id) LEFT JOIN master_network as mn ON (s.network = mn.id) WHERE 1=1";
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
			if($status == 'blocked'){
				$a .= " AND s.status = '3'";
			}
			if($status == 'suspended'){
				$a .= " AND s.status = '4'";
			}
			if($status == 'free'){
				$a .= " AND s.status = '5'";
			}
		}
		if($sim_type){
			$a .= " AND s.sim_type = '" . $sim_type . "'";
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
		if($is_gps_sim){
			$a .= " AND s.is_gps_sim = '" . $is_gps_sim . "'";
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
		$a .= " ORDER BY s.created_at DESC";     
        $query = $this->db->query($a);  
        return $query->result();  
    }
    
    function attendance_log_excel(){
        $a = "SELECT er.*, me.emp_no, me.full_name, me.iqama_no, me.iqama_exp, me.department, md.name as department_name, mjt.name as designation_name FROM employee_attendance er LEFT JOIN master_employee me ON (er.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1";
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND me.id = '" . $keyword . "'";
            }
        }
		
		if($this->input->get('iqama_no')) {
			$iqama_no = $this->input->get('iqama_no');
            if($iqama_no != ''){
                $a .= " AND me.iqama_no = '" . $iqama_no . "'";
            }
        }
        
		if($this->input->get('department')) {
			$department = $this->input->get('department');
            if($department != ''){
                $a .= " AND me.department = '" . $department . "'";
            }
        }
        
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (er.attendance_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
        $a .= " ORDER BY er.created_at DESC";             
        $query = $this->db->query($a);  
        return $query->result();  
    }
    
    function hunger_summary_report($keyword,$rider_id,$start_date,$end_date){
		$a = $a = "SELECT hos.*, count(hos.id) as total_ids, SUM(hos.fine) as total_fine, SUM(hos.completed_deliveries) as total_completed_deliveries, SUM(hos.cancelled_deliveries) as total_cancelled_deliveries, SUM(hos.notified_deliveries) as total_notified_deliveries, SUM(hos.declined_deliveries) as total_declined_deliveries, SUM(hos.accepted_deliveries) as total_accepted_deliveries, SUM(hos.not_accepted_deliveries) as total_not_accepted_deliveries, SUM(hos.avg_rider_acceptance_rate) as total_avg_rider_acceptance_rate, SUM(hos.working_hours) as total_working_hours, er.emp_id, me.emp_no, me.full_name  FROM hunger_order_summary hos LEFT JOIN employed_riders er ON (hos.rider_id = er.hunger_platform_id) LEFT JOIN master_employee me ON (er.emp_id = me.id) WHERE 1=1";
		if($keyword){
			$a .= " AND (me.full_name LIKE '%".$keyword."%')";
		}
		if($rider_id){
			$a .= " AND hos.rider_id= '" . $rider_id . "'";
		}
		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date));
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND (hos.date_local BETWEEN '". $period_start ."' AND '".$period_end."')";
		}
		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND emp.first_name LIKE '%".$_POST["search"]["value"]."%' OR emp.emp_no LIKE '%".$_POST["search"]["value"]."%' OR cv.cv_no LIKE '%".$_POST["search"]["value"]."%' OR emp.email LIKE '%".$_POST["search"]["value"]."%'";
		// }
		//print_r($period_start);exit();
		$a .= " GROUP BY hos.rider_id";
        $query = $this->db->query($a);
        return $query->result_array();
    }
    
    function cv_export($keyword,$applied_for,$start_date,$end_date,$cv_status,$interview_status,$agency_name,$sponsor_id,$arrival_from,$arrival_to,$selected_ids,$nationality){
		$a = "SELECT cv.*, mc.name as applicant_country_name, mc1.name as passport_country_name, pos.name as pos_name, ha.agency_name as hiring_agency_name FROM master_cv cv LEFT JOIN master_job_title pos ON (cv.applied_for = pos.id) LEFT JOIN hiring_agencies ha ON (cv.agency_name = ha.id) LEFT JOIN master_country mc ON (cv.applicant_country = mc.id) LEFT JOIN master_country mc1 ON (cv.passport_issue_country = mc1.id) WHERE 1=1";
		if($keyword){
			$a .= " AND (cv.first_name LIKE '%".$keyword."%' OR cv.middle_name LIKE '%".$keyword."%' OR cv.third_name LIKE '%".$keyword."%' OR cv.surname LIKE '%".$keyword."%' OR cv.cv_no LIKE '%".$keyword."%')";
		}
		if($applied_for){
			$a .= " AND cv.applied_for = '" . $applied_for . "'";
		}
		if($start_date && $end_date) {
			$d_to = date("Y-m-d", strtotime($end_date));
			$a .= " AND (cv.created_at BETWEEN '". date("Y-m-d", strtotime($start_date)) ."' AND '". $d_to ."')";
		}
		if($sponsor_id) {
			$a .= " AND cv.sponsor_id = '" . $sponsor_id . "'";
        }
        if($arrival_from && $arrival_to) {
			$f_to = date("Y-m-d", strtotime($arrival_to));
			$a .= " AND (cv.arrival_date BETWEEN '". date("Y-m-d", strtotime($arrival_from)) ."' AND '". $f_to ."')";
		}
		if($cv_status){
			$a .= " AND cv.cv_status = '" . $cv_status . "'";
		}
		if($interview_status){
			$a .= " AND cv.interview_status = '" . $interview_status . "'";
		}
		if($agency_name){
			$a .= " AND cv.agency_name = '" . $agency_name . "'";
		}
		if($nationality){
			$a .= " AND cv.nationality = '" . $nationality . "'";
		}
		// Apply selected IDs filtering
		if (!empty($selected_ids)) {
			$selected_ids = implode(',', array_map('intval', $selected_ids));
			$a .= " AND cv.id IN (" . $selected_ids . ")";
		}
		//print_r($period_start);exit();
		$a .= " ORDER BY cv.created_at DESC";
        $query = $this->db->query($a);
        return $query->result_array();
    }
    
    function employee_export($keyword,$designation,$nationality,$department,$iqama_status,$status,$iqama,$start_date,$end_date,$iqama_start_date,$iqama_end_date,$selected_ids){
		$a = "SELECT emp.*, mjt.name as designation_name, md.name as department_name, mp.profession_name, ml.location_name, 
		mc.name as work_country_name, mcity.city_name as work_city_name, mn.name as nationality_name, saa.sanat_no, mcamp.camp_name, 
		mr.room_name, mb.bed_name, sps.employer_id, sps.employer_name, sps.employer_cr_no, 
		mip.policy_number as employee_policy_no, mic.company_name as policy_company_name, mei.insurance_issue_date, mei.insurance_end_date, mei.qiwa_contract_no 
		FROM master_employee emp 
		LEFT JOIN master_employee_info mei ON (emp.id = mei.employee_id) 
		LEFT JOIN master_insurance_policies mip ON (mei.insurance_policy_no = mip.id) 
        LEFT JOIN master_insurance_company mic ON (mip.policy_company = mic.id) 
		LEFT JOIN master_job_title mjt ON (emp.designation = mjt.id) 
		LEFT JOIN master_department md ON (emp.department = md.id) 
		LEFT JOIN master_profession mp ON (emp.iqama_profession = mp.id) 
		LEFT JOIN master_location ml ON (emp.work_location = ml.id) 
		LEFT JOIN master_country mc ON (emp.work_country = mc.id) 
		LEFT JOIN master_city mcity ON (emp.work_city = mcity.id) 
		LEFT JOIN master_nationality as mn ON (emp.nationality = mn.id) 
		LEFT JOIN master_camp mcamp ON (emp.camp = mcamp.id) 
		LEFT JOIN master_rooms mr ON (emp.room = mr.id) 
		LEFT JOIN master_bed mb ON (emp.bed = mb.id) 
		LEFT JOIN sponsors sps ON (emp.sponsor_id = sps.id) 
		LEFT JOIN (
			SELECT employee_id, MAX(sanat_no) AS sanat_no
			FROM sanat_al_amar
			GROUP BY employee_id
		) saa ON emp.id = saa.employee_id 
		WHERE 1=1";
		if($keyword){
			$a .= " AND (emp.full_name LIKE '%".$keyword."%' OR emp.emp_no LIKE '%".$keyword."%')";
		}
		if($nationality){
			$a .= " AND emp.nationality = '" . $nationality . "'";
		}
		if($designation){
			$a .= " AND emp.designation = '" . $designation . "'";
		}
		if($department){
			$a .= " AND emp.department = '" . $department . "'";
		}
		if ($iqama_status) {
			$current_date = date("Y-m-d");
			if ($iqama_status == 'active') {
				$a .= " AND emp.iqama_expiry_date >= '" . $current_date . "'";
			} elseif ($iqama_status == 'expired') {
				$a .= " AND emp.iqama_expiry_date < '" . $current_date . "'";
			}
		}
		if ($iqama_start_date && $iqama_end_date) {
			$iqama_start = date("Y-m-d", strtotime($iqama_start_date));
			$iqama_end = date("Y-m-d", strtotime($iqama_end_date));
			$a .= " AND (emp.iqama_expiry_date BETWEEN '" . $iqama_start . "' AND '" . $iqama_end . "')";
		}
		if($status){
			$a .= " AND emp.status = '" . $status . "'";
		}
		if($iqama){
			$a .= " AND emp.iqama_no = '" . $iqama . "'";
		}
		if ($start_date && $end_date) {
			$start = date("Y-m-d", strtotime($start_date));
			$end = date("Y-m-d", strtotime($end_date));
			$a .= " AND (emp.work_joining_date BETWEEN '" . $start . "' AND '" . $end . "')";
		}
		// Apply selected IDs filtering
		if (!empty($selected_ids)) {
			$selected_ids = implode(',', array_map('intval', $selected_ids));
			$a .= " AND emp.id IN (" . $selected_ids . ")";
		}
		//print_r($period_start);exit();
		$a .= " ORDER BY emp.emp_no DESC";
        $query = $this->db->query($a);
        return $query->result_array();
    }
	
	public function vehicle_export()
	{
		$sql = "
			SELECT 
				mv.*,
				mc.color_name,
				mvk.make_name,
				mip.policy_number AS insurance_policy_no, 
				mic.company_name AS insurance_company_names, 
				me.emp_no,
				me.full_name AS alloted_user_name,
				sc.mobile AS gps_mobile,
				mp.parking_name AS parking_name,
				mcity.city_name as operation_city,
				mr.reason_title_en AS status_reasons 
			FROM master_vehicles mv
			LEFT JOIN master_color mc ON mc.id = mv.vehicle_color 
			LEFT JOIN mater_van_make mvk ON mvk.id = mv.vehicle_make 
			LEFT JOIN sim_card sc ON sc.gps_installed_vehicle = mv.id 
			LEFT JOIN master_insurance_policies mip ON mip.id = mv.insurance_no 
			LEFT JOIN master_insurance_company mic ON mic.id = mv.insurance_company_name 
			LEFT JOIN master_employee me ON me.id = mv.alloted_user
			LEFT JOIN master_reasons mr ON mr.id = mv.inactive_reason 
			LEFT JOIN master_parkings mp ON mp.id = mv.location 
			LEFT JOIN master_city mcity ON (mcity.id = mv.city_of_operation)
			WHERE 1=1
		";

		$bindings = [];
		$this->apply_filters($sql, $bindings);

		$sql .= " ORDER BY mv.created_at DESC";

		$query = $this->db->query($sql, $bindings);
		return $query->result_array();
	}

	private function apply_filters(&$sql, &$bindings)
	{
		if ($this->input->get('vehicle_no') !== null && $this->input->get('vehicle_no') !== '') {
			$sql .= " AND mv.vehicle_no = ?";
			$bindings[] = $this->input->get('vehicle_no');
		}

		if ($this->input->get('sequel_no') !== null && $this->input->get('sequel_no') !== '') {
			$sql .= " AND mv.sequel_no = ?";
			$bindings[] = $this->input->get('sequel_no');
		}

		if ($this->input->get('from') !== null && $this->input->get('to') !== null) {
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			if ($v_from !== '' && $v_to !== '') {
				$sql .= " AND mv.created_at BETWEEN ? AND ?";
				$bindings[] = date("Y-m-d", strtotime($v_from));
				$bindings[] = date("Y-m-d", strtotime($v_to));
			}
		}

		if ($this->input->get('vehicle_type') !== null && $this->input->get('vehicle_type') !== '') {
			$sql .= " AND mv.vehicle_type = ?";
			$bindings[] = $this->input->get('vehicle_type');
		}

		if ($this->input->get('vehicle_make') !== null && $this->input->get('vehicle_make') !== '') {
			$sql .= " AND mv.vehicle_make = ?";
			$bindings[] = $this->input->get('vehicle_make');
		}

		if ($this->input->get('vehicle_model') !== null && $this->input->get('vehicle_model') !== '') {
			$sql .= " AND mv.vehicle_model = ?";
			$bindings[] = $this->input->get('vehicle_model');
		}

		if ($this->input->get('vehicle_color') !== null && $this->input->get('vehicle_color') !== '') {
			$sql .= " AND mv.vehicle_color = ?";
			$bindings[] = $this->input->get('vehicle_color');
		}

		if ($this->input->get('vehicle_year') !== null && $this->input->get('vehicle_year') !== '') {
			$sql .= " AND mv.vehicle_year = ?";
			$bindings[] = $this->input->get('vehicle_year');
		}

		if ($this->input->get('status') !== null && $this->input->get('status') !== '') {
			$sql .= " AND mv.status = ?";
			$bindings[] = $this->input->get('status');
		}

		if ($this->input->get('alloted_user') !== null && $this->input->get('alloted_user') !== '') {
			$sql .= " AND mv.alloted_user = ?";
			$bindings[] = $this->input->get('alloted_user');
		}

		if ($this->input->get('vehicle_ownership') !== null && $this->input->get('vehicle_ownership') !== '') {
			$sql .= " AND mv.vehicle_ownership = ?";
			$bindings[] = $this->input->get('vehicle_ownership');
		}
	}
	
	function rider_export(){
		$a = "
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
			incentives.target as monthly_target, 
			mv.id as vehicle_id, mv.vehicle_ownership, mv.vehicle_type, mv.vehicle_no, mv.sequel_no, mv.vehicle_model, mv.vehicle_year, vm.make_name as vehicle_brand, 
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
		LEFT JOIN mater_van_make vm ON (mv.vehicle_make = vm.id) 
		LEFT JOIN master_camp mc ON (me.camp = mc.id) 
		LEFT JOIN incentives ON (er.incentive_id = incentives.id) 
		WHERE 
			1=1";
		
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
		
		$a .= " ORDER BY me.emp_no DESC";
		$query = $this->db->query($a);
		return $query->result_array();
	}

	
	function rider_export2(){
		$a = "
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
			mv.id as vehicle_id, mv.vehicle_ownership, mv.vehicle_type, mv.vehicle_no, mv.sequel_no, mv.vehicle_model, mv.vehicle_year, vm.make_name as vehicle_brand, 
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
		LEFT JOIN mater_van_make vm ON (mv.vehicle_make = vm.id) 
		LEFT JOIN master_camp mc ON (me.camp = mc.id) 
		WHERE 
			1=1";
		
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
		//print_r($period_start);exit();
		$a .= " ORDER BY me.emp_no DESC";
        $query = $this->db->query($a);
        return $query->result_array();
    }
	
	//Export Employee for Salary File

	function employee_salary_export(){
		$a = "SELECT emp.*, mjt.name as designation_name, md.name as department_name, mp.profession_name, ml.location_name, mc.name as work_country_name, mcity.city_name as work_city_name, mn.name as nationality_name, mei.gosi_id, mei.qiwa_contract_status, lr.id_number as aggregator_id, lr.platform, lr.incentive_id, fdc.company_name as aggregator_name, incentives.target as monthly_target FROM master_employee emp LEFT JOIN master_job_title mjt ON (emp.designation = mjt.id) LEFT JOIN master_department md ON (emp.department = md.id) LEFT JOIN master_profession mp ON (emp.iqama_profession = mp.id) LEFT JOIN master_location ml ON (emp.work_location = ml.id) LEFT JOIN master_country mc ON (emp.work_country = mc.id) LEFT JOIN master_city mcity ON (emp.work_city = mcity.id) LEFT JOIN master_nationality as mn ON (emp.nationality = mn.id) LEFT JOIN master_employee_info mei ON (emp.id = mei.employee_id) LEFT JOIN logistic_rider lr ON (emp.id = lr.employee_id) LEFT JOIN incentives ON (lr.incentive_id = incentives.id) LEFT JOIN food_deliv_companies fdc ON (lr.platform = fdc.id) WHERE emp.status = 'Active'";
		//print_r($period_start);exit();
		$a .= " ORDER BY emp.emp_no DESC";
        $query = $this->db->query($a);
        return $query->result_array();
    }
	
	public function getPayrollDetails($id) {
        // Query to fetch detailed payroll data
        $this->db->select('eps.*,ep.payroll_month');
        $this->db->from('employee_payslip eps');
		$this->db->join('employee_payroll ep', 'eps.payroll_id = ep.id', 'left');
		$this->db->where('eps.payroll_id',$id);
        $this->db->order_by('eps.emp_id', 'ASC');
        return $this->db->get()->result_array();
    }
	
	public function getHungerTeam($team_id)
    {
        $team = $this->db->select('hunger_team.*,me.id as emp_id,me.full_name,me.mobile')
            ->join('master_employee me', 'hunger_team.team_leader=me.id', 'left')
            ->where('hunger_team.id', $team_id)->get('hunger_team')->row();
        $emp_ids = json_decode($team->team, true);

        if (!empty($emp_ids)) {
            $riders = $this->db->where_in('master_employee.id', $emp_ids)
                ->select('master_employee.*,mli.id_number as hunger_id,mli.id_type,lr.rider_status,mv.vehicle_no,fdc.company_name')
                ->join('logistic_rider lr', 'lr.employee_id=master_employee.id', 'left')
                ->join('master_logistic_ids mli', 'lr.id_number = mli.id_number', 'left')
                ->join('food_deliv_companies fdc', 'mli.platform_id=fdc.id', 'left')
                ->join('master_vehicles mv', 'master_employee.id = mv.alloted_user', 'left')
                ->get('master_employee')->result();
        } else {
            $riders = array();
        }

        return [$team, $riders];
    }
	
	//Export Aggregator List
	function exportAggregatorDetail() {
		$a = "
		SELECT 
			er.*, 
			me.emp_no, 
			me.full_name, 
			me.iqama_no, 
			me.mobile, 
			me.status as emp_status,
			lrr.employee_id as alloted_user, 
			(SELECT sc.mobile FROM sim_card sc WHERE sc.alloted_user = er.owner_id LIMIT 1) as owner_flex_no, 
			fdc.company_name as food_company,
			allot_emp.full_name as alloted_to_name,
			allot_emp.emp_no as alloted_to_emp_no,
			allot_vehicle.vehicle_type as alloted_vehicle_type,
			allot_vehicle.vehicle_no as alloted_vehicle_no,
			allot_vehicle.operation_card_no as operation_card_no,
			allot_vehicle.operation_card_issue_date as operation_card_issue_date,
			allot_vehicle.operation_card_issue_date as operation_card_issue_date,
			sponsors.employer_id as sponsor_id,
			sponsors.employer_name as sponsor_name 
		FROM 
			master_logistic_ids er 
		LEFT JOIN 
			master_employee me ON (er.owner_id = me.id) 
		LEFT JOIN 
			food_deliv_companies fdc ON (er.platform_id = fdc.id) 
		LEFT JOIN 
			logistic_rider lrr ON (er.id_number = lrr.id_number) 
		LEFT JOIN 
			master_employee allot_emp ON (lrr.employee_id = allot_emp.id) 
		LEFT JOIN 
			master_vehicles allot_vehicle ON (lrr.employee_id = allot_vehicle.alloted_user) 
		LEFT JOIN 
			sponsors ON (allot_emp.sponsor_id = sponsors.id) 
		WHERE 
			1=1";
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
		$a .= " ORDER BY er.activation_date DESC";
		$query = $this->db->query($a);
		return $query->result();
	}
	
	//Monthly Attendance Report

	public function monthly_attendance_report($month_of, $rider_id = null, $team_id = null) {
		// Prepare and validate the date range
		$date = DateTime::createFromFormat('M Y', $month_of);
		if ($date === false) {
			throw new Exception("Invalid date format: " . htmlspecialchars($month_of));
		}
		$start_date = $date->format('Y-m-01');
		$end_date = $date->format('Y-m-t');
	
		// Select relevant fields
		$this->db->select('
			r.id AS rider_id,
			r.employee_id,
			r.rider_status,
			me.emp_no,
			me.full_name AS employee_name,
			DATE(t.out_time) AS attendance_date,
			t.out_time AS out_time,
			ht.name as team_name,
			ht.id as team_id
		');
		$this->db->from('logistic_rider r');
		
		// Left join with timesheets for attendance
		$this->db->join(
			'vehicle_timesheets t',
			'r.employee_id = t.driver_id AND DATE(t.out_time) BETWEEN ' . $this->db->escape($start_date) . ' AND ' . $this->db->escape($end_date),
			'left'
		);
		$this->db->join('master_employee me', 'r.employee_id = me.id', 'left');
		// Join with hunger_team table
		$this->db->join('hunger_team ht', 'ht.team REGEXP CONCAT(\'"\', me.id, \'"\')', 'left');
		// Apply filters
		if ($rider_id) {
			$this->db->where('r.employee_id', $rider_id);
		}
		if ($team_id) {
			$this->db->where('ht.id', $team_id);
		}
		$this->db->where('me.status', 'Active');
		$this->db->order_by('r.employee_id', 'ASC');
		$this->db->order_by('t.out_time', 'ASC');
	
		// Execute the query
		$query = $this->db->get();
		$raw_data = $query->result();
	
		// Process and group data
		$attendance_report = [];
		$days_in_month = (int)$date->format('t');
	
		foreach ($raw_data as $row) {
			$emp_id = $row->employee_id;
	
			// Initialize employee entry if not already done
			if (!isset($attendance_report[$emp_id])) {
				$attendance_report[$emp_id] = (object)[
					'emp_no' => $row->emp_no,
					'employee_name' => $row->employee_name,
					'team_name' => $row->team_name,
					'attendance' => array_fill(1, $days_in_month, 'A'), // Default all days to 'Absent'
					'total_present' => 0,
					'total_absent' => $days_in_month,
				];
			}
	
			// Mark attendance for specific days
			if (!empty($row->attendance_date)) {
				$day = (int)date('j', strtotime($row->attendance_date)); // Get the day of the month
				$attendance_report[$emp_id]->attendance[$day] = 'P'; // Mark as 'Present'
				$attendance_report[$emp_id]->total_present++;
				$attendance_report[$emp_id]->total_absent--; // Decrement absent count
			}
		}
	
		// Return as indexed array
		return array_values($attendance_report);
	}
	
	//Food Allowance Detail
	public function get_food_allowance($batch_no) {
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
}

