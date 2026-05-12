<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_vehicle_model extends CI_Model{

	public function add($data)
	{
		$this->db->trans_start();
		$this->db->insert('master_vehicles', $data);
		$this->db->trans_complete();

		return $this->db->trans_status(); // true/false
	}
	
	public function edit($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('master_vehicles', $data);
	}

	function get_data(){
		$a = "SELECT * FROM master_vehicles WHERE 1 = 1";
		$query = $this->db->query($a);  
		return $query->result();
	}
	
	function make_query(){
		$a = "SELECT mv.*, mc.color_name, mvk.make_name FROM master_vehicles mv LEFT JOIN master_color mc ON (mc.id = mv.vehicle_color) LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE 1 = 1";
		return $a;
	}

	public function list($filters = [], $perPage = 50, $start = 0)
	{
		// -------------------------------
		// Step 1: Parse filters & keyword
		// -------------------------------
		$keyword = trim($filters['keyword'] ?? '');

		// -------------------------------------------------------------
		// Load user column preferences
		// -------------------------------------------------------------
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'vehicles'
		])->row();

		$visibleColumns   = json_decode($userPreferences->visible_columns ?? '[]', true);
		$availableColumns = json_decode($userPreferences->available_columns ?? '[]', true);

		// -------------------------------------------------------------
		// Column map
		// -------------------------------------------------------------
		$columnMap = [
			"id"                         => "mv.id",
			"vehicle_ownership"          => "mv.vehicle_ownership",
			"owner_name_select"          => "mv.owner_name_select",
			"vehicle_type"               => "mv.vehicle_type",
			"vehicle_no"                 => "mv.vehicle_no",
			"vehicle_expiry"             => "mv.vehicle_expiry",
			"vehicle_year"               => "mv.vehicle_year",
			"vehicle_color"              => "mc.color_name AS vehicle_color",
			"vehicle_make"               => "mvk.make_name AS vehicle_make",
			"vehicle_model"              => "mv.vehicle_model",
			"purchase_date"              => "mv.purchase_date",
			"chassis_no"                 => "mv.chassis_no",
			"vehicle_category"           => "mv.vehicle_category",
			"insurance_no"               => "mv.insurance_no",
			"insurance_company_name"     => "mv.insurance_company_name",
			"insurance_issue_date"       => "mv.insurance_issue_date",
			"insurance_class"            => "mv.insurance_class",
			"insurance_expiry"           => "mv.insurance_expiry",
			"sequel_no"                  => "mv.sequel_no",
			"status"                     => "mv.status",
			"inactive_reason"            => "mv.inactive_reason",
			"allotment_status"           => "mv.allotment_status",
			"status_reason"              => "mv.status_reason",
			"status_date"                => "mv.status_date",
			"alloted_user"               => "mv.alloted_user",
			"allotment_date"             => "mv.allotment_date",
			"ip"                         => "mv.ip",
			"gps_installed"              => "mv.gps_installed",
			"gps_device_serial"          => "mv.gps_device_serial",
			"gsp_mobile_no"              => "mv.gsp_mobile_no",
			"gps_installation_date"      => "mv.gps_installation_date",
			"gps_expiry_date"            => "mv.gps_expiry_date",
			"custom_card_no"             => "mv.custom_card_no",
			"gasoline_chip_status"       => "mv.gasoline_chip_status",
			"gasoline_installation_date" => "mv.gasoline_installation_date",
			"registration_certificate"   => "mv.registration_certificate",
			"insurance_certificate"      => "mv.insurance_certificate",
			"operation_card_no"          => "mv.operation_card_no",
			"operation_card_issue_date"  => "mv.operation_card_issue_date",
			"operation_card_expiry_date" => "mv.operation_card_expiry_date",
			"attached_file"              => "mv.attached_file",
			"tamm_attachment"            => "mv.tamm_attachment",
			"created_at"                 => "mv.created_at",
			"updated_at"                 => "mv.updated_at",
			"make_name"                  => "mvk.make_name",
			"color_name"                 => "mc.color_name",
			"location" 			 		 => "mp.parking_name AS location",
			"city_of_operation" 		 => "mcity.city_name AS city_of_operation",
		];

		// -------------------------------------------------------------
		// Default visible columns
		// -------------------------------------------------------------
		if (empty($visibleColumns)) {
			$visibleColumns = array_keys($columnMap);
		}

		if (empty($availableColumns)) {
			$availableColumns = array_keys($columnMap);
		}

		// -------------------------------------------------------------
		// SELECT only visible columns
		// -------------------------------------------------------------
		$selectList = [];
		foreach ($visibleColumns as $col) {
			if (isset($columnMap[$col])) {
				$selectList[] = $columnMap[$col];
			}
		}

		if (empty($selectList)) {
			$selectList = ["mv.id"];
		}

		// -------------------------------------------------------------
		// Base Query
		// -------------------------------------------------------------
		$this->db->select(implode(", ", $selectList), false);
		$this->db->from("master_vehicles mv");
		$this->db->join("master_color mc", "mc.id = mv.vehicle_color", "left");
		$this->db->join("mater_van_make mvk", "mvk.id = mv.vehicle_make", "left");
		$this->db->join("master_parkings mp", "mp.id = mv.location", "left");
		$this->db->join("master_city mcity", "mcity.id = mv.city_of_operation", "left");
		// -------------------------------------------------------------
		// Search only in visible columns
		// -------------------------------------------------------------
		if (!empty($keyword)) {
			$this->db->group_start();

			foreach ($visibleColumns as $col) {
				if (isset($columnMap[$col])) {
					$field = $columnMap[$col];
					if (stripos($field, ' AS ') !== false) {
						$field = explode(" AS ", $field)[0];
					}
					$this->db->or_like($field, $keyword);
				}
			}

			$this->db->group_end();
		}

		// -------------------------------------------------------------
		// Apply filters (JSON URL filters)
		// -------------------------------------------------------------
		$allowedFilters = [
			"vehicle_no"        => "mv.vehicle_no",
			"sequel_no"         => "mv.sequel_no",
			"vehicle_type"      => "mv.vehicle_type",
			"vehicle_make"      => "mv.vehicle_make",
			"vehicle_model"     => "mv.vehicle_model",
			"vehicle_color"     => "mv.vehicle_color",
			"vehicle_year"      => "mv.vehicle_year",
			"status"            => "mv.status",
			"alloted_user"      => "mv.alloted_user",
			"vehicle_ownership" => "mv.vehicle_ownership",
			"owner_select"      => "mv.owner_name_select",
		];

		foreach ($allowedFilters as $key => $dbField) {
			if (!empty($filters[$key])) {
				$this->db->where($dbField, $filters[$key]);
			}
		}

		// Date filter
		if (!empty($filters['from']) && !empty($filters['to'])) {
			$from = date('Y-m-d', strtotime($filters['from']));
			$to   = date('Y-m-d', strtotime($filters['to']));
			$this->db->where("mv.created_at >=", $from);
			$this->db->where("mv.created_at <=", $to);
		}

		// -------------------------------------------------------------
		// Total count BEFORE paging
		// -------------------------------------------------------------
		$countDB = clone $this->db;
		$totalCount = $countDB->count_all_results();

		// -------------------------------------------------------------
		// Pagination + Ordering
		// -------------------------------------------------------------
		$this->db->order_by("mv.created_at", "DESC");
		$this->db->limit($perPage, $start);

		$data = $this->db->get()->result_array();

		return [
			"data" => $data,
			"visible_columns" => $visibleColumns,
			"pagination" => [
				"total"         => $totalCount,
				"start"         => $start,
				"per_page"      => $perPage,
				"current_page"  => floor($start / $perPage),
				"last_page"     => ceil($totalCount / $perPage),
			]
		];
	}

	function filter_suggestions(){
		$a = "SELECT mv.*, mc.color_name, mvk.make_name FROM master_vehicles mv LEFT JOIN master_color mc ON (mc.id = mv.vehicle_color) LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE 1 = 1";
		$query = $this->db->query($a);  
		return $query->result();
	}
	
	function unalloted_vehicles(){
		$a = "SELECT mv.*, mc.color_name, mvk.make_name FROM master_vehicles mv LEFT JOIN master_color mc ON (mc.id = mv.vehicle_color) LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.status = 'active' AND (mv.alloted_user IS NULL OR mv.alloted_user = '' OR mv.alloted_user = 0) ORDER BY mv.vehicle_no ASC";
		$query = $this->db->query($a);  
		return $query->result_array();
	}

	public function check_allotment_status($vehicle_id) {
		$this->db->select('id');
		$this->db->from('master_vehicles');
		$this->db->where('id', $vehicle_id);
		$this->db->where('alloted_user IS NOT NULL AND alloted_user != "" AND alloted_user != 0');
		$query = $this->db->get();
		return $query->num_rows() > 0;
	}

	/*-------- Filters -----*/

	// Fetch filtered vehicle types
    public function get_filtered_vehicle_nos($search_query) {
        $this->db->select('vehicle_no, vehicle_no as key_value');
        $this->db->from('master_vehicles');
        if (!empty($search_query)) {
            $this->db->like('vehicle_no', $search_query);
        }
        $query = $this->db->get();
        return $query->result();
    }

	// Fetch filtered vehicle types
    public function get_filtered_sequel_nos($search_query) {
        $this->db->select('sequel_no, sequel_no as key_value');
        $this->db->from('master_vehicles');
        if (!empty($search_query)) {
            $this->db->like('sequel_no', $search_query);
        }
        $query = $this->db->get();
        return $query->result();
    }

    // Fetch filtered vehicle models
    public function get_filtered_vehicle_models($search_query) {
		$this->db->distinct();
		$this->db->select('vehicle_model, vehicle_model as key_value');
		$this->db->from('master_vehicles');
		if (!empty($search_query)) {
			$this->db->like('vehicle_model', $search_query);
		}
		$this->db->group_by('vehicle_model');
		$query = $this->db->get();
		return $query->result();
	}		

    // Fetch filtered vehicle colors
    public function get_filtered_alloted_users($search_query) {
        $this->db->select('mv.alloted_user as key_value, me.full_name, me.emp_no');
        $this->db->from('master_vehicles mv');
		$this->db->join('master_employee me', 'mv.alloted_user = me.id', 'left');
        if (!empty($search_query)) {
            $this->db->like('me.full_name', $search_query);
			$this->db->or_like('me.emp_no', $search_query);
        }
        $query = $this->db->get();
        return $query->result();
    }
	
	/*----- Filters End -----*/

	function delete($id){
		$query = $this->db->query("DELETE FROM master_vehicles WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT mv.*, mc.color_name, mvk.make_name, mp.parking_name, mcity.city_name as operation_city, sc.mobile as gps_mobile FROM master_vehicles mv LEFT JOIN master_color mc ON (mc.id = mv.vehicle_color) LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_parkings mp ON (mp.id = mv.location) LEFT JOIN master_city mcity ON (mcity.id = mv.city_of_operation) LEFT JOIN sim_card sc ON (mv.id = sc.gps_installed_vehicle) WHERE mv.id = '" . (int)$id . "'");
		return $query;
	}
	
	public function get_last_meter_reading($vehicle_id)
	{
		return $this->db->select('meter_reading')
						->from('vehicle_log')
						->where('vehicle_id', $vehicle_id)
						->order_by('id', 'DESC')
						->limit(1)
						->get()
						->row_array();
	}

	public function get_unalloted_employees()
	{
		$a = "SELECT me.*, me.emp_no, me.full_name, mjt.name as pos_name FROM master_employee me LEFT JOIN master_job_title mjt ON (me.designation = mjt.id) WHERE (me.status = 'Active' AND me.id NOT IN (SELECT alloted_user FROM master_vehicles WHERE alloted_user IS NOT NULL))";
		$query = $this->db->query($a);
        return $query->result_array(); 
	}

	function alloted_emp_detail($id){
		$query = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.iqama_no, me.passport_no, me.nationality, me.work_joining_date, mei.driving_license_number, mei.driving_license_issue_date, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_job_title mjt ON (me.designation = mjt.id) LEFT JOIN master_department md ON (me.department = md.id) LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_employee_info as mei ON (me.id = mei.employee_id) WHERE me.id = '" . (int)$id . "'");
		return $query->row();
	}

	function update_allotment_status($tamm_attachment = ''){
	    if($this->input->post('allotment_status') == 'alloted' || $this->input->post('allotment_status') == 'unalloted'){
	        $user_id = $this->db->escape_str($this->input->post('alloted_user'));
	    }else{
	        $user_id = '';
	    }
		if ($this->input->post('allotment_status') == 'unalloted' || $this->input->post('allotment_status') == 'return') {
			$location = $this->db->escape_str($this->input->post('location'));
		}else{
			$location = '';
		}
		$query = $this->db->query("UPDATE master_vehicles SET allotment_date = '" . $this->db->escape_str($this->input->post('status_date')) . "', alloted_user = '" . $user_id . "', allotment_status = '" . $this->db->escape_str($this->input->post('allotment_status')) . "', tamm_attachment = '" . $this->db->escape_str($tamm_attachment) . "', location = '" . $location . "', updated_at = now() WHERE id = '" . (int)$this->input->post('vehicle_id') . "'");
		if($query){
			$this->db->query("INSERT INTO vehicle_log SET status_date = '" . $this->db->escape_str($this->input->post('status_date')) . "', vehicle_id = '" . $this->db->escape_str($this->input->post('vehicle_id')) . "', rider_id = '" . $this->db->escape_str($this->input->post('alloted_user')) . "', log_status = '" . $this->db->escape_str($this->input->post('allotment_status')) . "', meter_reading = '" . $this->db->escape_str($this->input->post('meter_reading')) . "', remarks = '" . $this->db->escape_str($this->input->post('remarks')) . "', location = '" . $location . "', tamm_attachment = '" . $this->db->escape_str($tamm_attachment) . "', created_at = NOW(), updated_at = now()");
		}
		return $query;
	}
}
