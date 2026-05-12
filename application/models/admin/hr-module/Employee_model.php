<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_model extends CI_Model{

	function add_step1($hashpassword){
		$this->db->trans_start();
	
		$data = array(
			'emp_no' => $this->input->post('emp_no', true),
			'first_name' => $this->input->post('first_name', true),
			'second_name' => $this->input->post('second_name', true),
			'third_name' => $this->input->post('third_name', true),
			'last_name' => $this->input->post('last_name', true),
			'full_name' => $this->input->post('full_name', true),
			'employee_arabic_name' => $this->input->post('employee_arabic_name', true),
			'dob' => $this->input->post('dob', true),
			'gender' => $this->input->post('gender', true),
			'marital_status' => $this->input->post('marital_status', true),
			'religion' => $this->input->post('religion', true),
			//'mobile' => $this->input->post('mobile', true),
			'personal_email' => $this->input->post('personal_email', true),
			'email' => $this->input->post('email', true),
			'absher_mobile' => $this->input->post('absher_mobile', true),
			'sponsor_id' => $this->input->post('sponsor_id', true),
			'iqama_no' => $this->input->post('iqama_no', true),
			'iqama_name_en' => $this->input->post('iqama_name_en', true),
			'iqama_name_ar' => $this->input->post('iqama_name_ar', true),
			'iqama_profession' => $this->input->post('iqama_profession', true),
			'iqama_issue_date' => $this->input->post('iqama_issue_date', true),
			'iqama_issue_date_hijri' => $this->input->post('iqama_issue_date_hijri', true),
			'iqama_expiry_date' => $this->input->post('iqama_expiry_date', true),
			'iqama_expiry_date_hijri' => $this->input->post('iqama_expiry_date_hijri', true),
			'iqama_issue_city' => $this->input->post('iqama_issue_city', true),
			'iqama_status' => $this->input->post('iqama_status', true),
			'nationality' => $this->input->post('nationality', true),
			'passport_no' => $this->input->post('passport_no', true),
			'passport_issue_date' => $this->input->post('passport_issue_date', true),
			'passport_expiry_date' => $this->input->post('passport_expiry_date', true),
			'passport_issue_country' => $this->input->post('passport_issue_country', true),
			'passport_issue_city' => $this->input->post('passport_issue_city', true),
			'status' => 'Active',
			'password' => $hashpassword,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('master_employee', $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
	
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return $insert_id;
		}
	}	

	public function add_employee_info($data) {
		return $this->db->insert('master_employee_info', $data);
	}

	function update_step1($id){
		$this->db->trans_start();
		
		$data = array(
			'first_name' => $this->db->escape_str($this->input->post('first_name')),
			'second_name' => $this->db->escape_str($this->input->post('second_name')),
			'third_name' => $this->db->escape_str($this->input->post('third_name')),
			'last_name' => $this->db->escape_str($this->input->post('last_name')),
			'full_name' => $this->db->escape_str($this->input->post('full_name')),
			'employee_arabic_name' => $this->db->escape_str($this->input->post('employee_arabic_name')),
			'dob' => $this->db->escape_str($this->input->post('dob')),
			'gender' => $this->db->escape_str($this->input->post('gender')),
			'marital_status' => $this->db->escape_str($this->input->post('marital_status')),
			'religion' => $this->db->escape_str($this->input->post('religion')),
			//'mobile' => $this->db->escape_str($this->input->post('mobile')),
			'personal_email' => $this->db->escape_str($this->input->post('personal_email')),
			'email' => $this->db->escape_str($this->input->post('email')),
			'absher_mobile' => $this->input->post('absher_mobile', true),
			//'sponsor_id' => $this->input->post('sponsor_id', true),
			'iqama_no' => $this->db->escape_str($this->input->post('iqama_no')),
			'iqama_name_en' => $this->db->escape_str($this->input->post('iqama_name_en')),
			'iqama_name_ar' => $this->db->escape_str($this->input->post('iqama_name_ar')),
			'iqama_profession' => $this->db->escape_str($this->input->post('iqama_profession')),
			'iqama_issue_date' => $this->db->escape_str($this->input->post('iqama_issue_date')),
			'iqama_issue_date_hijri' => $this->db->escape_str($this->input->post('iqama_issue_date_hijri')),
			'iqama_expiry_date' => $this->db->escape_str($this->input->post('iqama_expiry_date')),
			'iqama_expiry_date_hijri' => $this->db->escape_str($this->input->post('iqama_expiry_date_hijri')),
			'iqama_issue_city' => $this->db->escape_str($this->input->post('iqama_issue_city')),
			'iqama_status' => $this->db->escape_str($this->input->post('iqama_status')),
			'nationality' => $this->db->escape_str($this->input->post('nationality')),
			'passport_no' => $this->db->escape_str($this->input->post('passport_no')),
			'passport_issue_date' => $this->db->escape_str($this->input->post('passport_issue_date')),
			'passport_expiry_date' => $this->db->escape_str($this->input->post('passport_expiry_date')),
			'passport_issue_country' => $this->db->escape_str($this->input->post('passport_issue_country')),
			'passport_issue_city' => $this->db->escape_str($this->input->post('passport_issue_city')),
			'updated_at' => CURRENT_TIME
		);

		$this->db->where('id', $id);
		$query = $this->db->update('master_employee', $data);
		
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	function update_step3($id){
		$this->db->trans_start();
		//echo '<pre>';print_r($this->input->post());exit();
		//echo '<pre>';print_r(json_encode($this->input->post('family')));exit();
		$query = $this->db->query("UPDATE master_employee SET 
		edu_degree = '" . $this->db->escape_str($this->input->post('edu_degree')) . "', 
		work_joining_date = '" . $this->db->escape_str($this->input->post('work_joining_date')) . "', 
		joining_date_hijri = '" . $this->db->escape_str($this->input->post('joining_date_hijri')) . "', 
		work_operational_date = '" . $this->db->escape_str($this->input->post('work_operational_date')) . "', 
		designation = '" . $this->db->escape_str($this->input->post('designation')) . "', 
		department = '" . $this->db->escape_str($this->input->post('department')) . "', 
		work_line_manager = '" . $this->db->escape_str($this->input->post('work_line_manager')) . "', 
		department_head = '" . $this->db->escape_str($this->input->post('department_head')) . "', 
		employment_type = '" . $this->db->escape_str($this->input->post('employment_type')) . "', 
		working_hours = '" . $this->db->escape_str($this->input->post('working_hours')) . "', 
		working_days = '" . $this->db->escape_str($this->input->post('working_days')) . "', 
		work_location = '" . $this->db->escape_str($this->input->post('work_location')) . "', 

		annual_leave_entitlement = '" . $this->db->escape_str($this->input->post('annual_leave_entitlement')) . "', 
		updated_at = '". CURRENT_TIME ."' WHERE id = '". $id ."' LIMIT 1");
		$this->db->trans_complete();
		return $query;
	}

	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT emp.*, mjt.name as designation_name, md.name as department_name FROM master_employee emp LEFT JOIN master_job_title mjt ON (emp.designation = mjt.id) LEFT JOIN master_department md ON (emp.department = md.id) WHERE 1=1";
		return $a;
	}
	
	/*------- Employee List Page -------*/

	public function employeeList($filters = [], $perPage = 0, $start = 0, $column_preferences = 'selected_columns')
	{
		// -------------------------------
		// Step 0: Parse & sanitize filters
		// -------------------------------
		$keyword            = trim($filters['keyword'] ?? '');
		$designation        = $this->_parseMulti($filters['designation'] ?? '');
		$nationality        = $this->_parseMulti($filters['nationality'] ?? '');
		$department         = $this->_parseMulti($filters['department'] ?? '');
		$status             = $filters['status'] ?? ['Active', 'Terminated'];
		$viewType           = $filters['view_type'] ?? 'all';

		$bed_name          = $this->_parseMulti($filters['bed_name'] ?? '');
		$camp_name         = $this->_parseMulti($filters['camp_name'] ?? '');
		$department_head   = $this->_parseMulti($filters['department_head'] ?? '');
		$work_line_manager = $this->_parseMulti($filters['work_line_manager'] ?? '');
		$employer = $this->_parseMulti($filters['employer'] ?? '');
		$employee_policy_no= trim($filters['employee_policy_no'] ?? '');
		$gender            = $this->_parseMulti($filters['gender'] ?? '');
		$marital_status    = $this->_parseMulti($filters['marital_status'] ?? '');
		$iqama_status      = $this->_parseMulti($filters['iqama_status'] ?? '');
		$religion          = $this->_parseMulti($filters['religion'] ?? '');
		$iqama       = trim($filters['iqama'] ?? '');
		$passport_no       = trim($filters['passport_no'] ?? '');
		$passport_issue_country = $this->_parseMulti($filters['passport_issue_country'] ?? '');
		$passport_issue_city    = $this->_parseMulti($filters['passport_issue_city'] ?? '');
		$iqama_issue_city       = $this->_parseMulti($filters['iqama_issue_city'] ?? '');
		$terminate_reason  = $this->_parseMulti($filters['terminate_reason'] ?? '');

		// Date ranges
		$dob_start             = trim($filters['date_of_birth_start'] ?? '');
		$dob_end               = trim($filters['date_of_birth_end'] ?? '');
		$passport_issue_start  = trim($filters['passport_issue_date_start'] ?? '');
		$passport_issue_end    = trim($filters['passport_issue_date_end'] ?? '');
		$passport_expiry_start = trim($filters['passport_expiry_date_start'] ?? '');
		$passport_expiry_end   = trim($filters['passport_expiry_date_end'] ?? '');
		$insurance_issue_start = trim($filters['insurance_issue_date_start'] ?? '');
		$insurance_issue_end   = trim($filters['insurance_issue_date_end'] ?? '');
		$insurance_end_start   = trim($filters['insurance_end_date_start'] ?? '');
		$insurance_end_end     = trim($filters['insurance_end_date_end'] ?? '');
		$start_date         = trim($filters['start_date'] ?? '');
		$end_date           = trim($filters['end_date'] ?? '');
		$iqama_issue_start_date   = trim($filters['iqama_issue_date_start'] ?? '');
		$iqama_issue_end_date     = trim($filters['iqama_issue_date_end'] ?? '');
		$last_working_start = trim($filters['last_working_start_date'] ?? '');
		$last_working_end   = trim($filters['last_working_end_date'] ?? '');
		$work_location   = $this->_parseMulti($filters['work_location'] ?? '');

		// -------------------------------
		// Step 1: Load user column preferences
		// -------------------------------
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'master_employees_data'
		])->row();

		$selectedColumns = json_decode($userPreferences->available_columns ?? '[]', true);
		$visibleColumns  = json_decode($userPreferences->visible_columns ?? '[]', true);

		// Fallback: show all columns if no preference
		$allColumnKeys = [
			"id", "emp_no", "sanat_no", "employee_pic", "full_name", "employee_arabic_name",
			"iqama_no", "dob", "gender", "marital_status", "religion", "mobile", "email", "absher_mobile",
			"work_joining_date", "status", "last_working_date", "terminate_reason",
			"iqama_name_en", "iqama_name_ar", "profession_name", "iqama_issue_city",
			"iqama_issue_date", "iqama_expiry_date", "nationality_name", "passport_no",
			"passport_issue_date", "passport_expiry_date", "passport_issue_country",
			"passport_issue_city", "department_name", "designation_name", "work_line_manager",
			"department_head", "employment_type", "working_hours", "working_days",
			"location_name", "payment_type_detail",
			"basic_salary", "housing_allowance", "transport_allowance", "food_allowance",
			"mobile_allowance", "other_allowance", "total_package", "annual_leave_entitlement",
			"camp_name", "room_name", "bed_name", "employer_id", "employer_name",
			"employer_cr_no", "employee_policy_no", "policy_company_name",
			"insurance_issue_date", "insurance_end_date", "qiwa_contract_no"
		];

		if ($column_preferences === 'all_columns' || empty($selectedColumns)) {
			$visibleColumns = $allColumnKeys;
		} elseif (empty($visibleColumns)) {
			$visibleColumns = $selectedColumns;
		}

		// -------------------------------
		// Step 2: Column mapping
		// -------------------------------
		$columnMap = [
			"id" => "emp.id",
			"emp_no" => "emp.emp_no",
			"sanat_no" => "saa.sanat_no",
			"employee_pic" => "emp.employee_pic",
			"full_name" => "emp.full_name",
			"employee_arabic_name" => "emp.employee_arabic_name",
			"iqama_no" => "emp.iqama_no",
			"dob" => "emp.dob",
			"gender" => "emp.gender",
			"marital_status" => "emp.marital_status",
			"religion" => "emp.religion",
			"mobile" => "sc.mobile",
			"email" => "emp.email",
			"absher_mobile" => "emp.absher_mobile",
			"work_joining_date" => "emp.work_joining_date",
			"status" => "emp.status",
			"status_date" => "emp.status_date",
			"last_working_date" => "emp.last_working_date",
			"terminate_reason" => "emp.terminate_reason",
			"iqama_name_en" => "emp.iqama_name_en",
			"iqama_name_ar" => "emp.iqama_name_ar",
			"profession_name" => "mp.profession_name",
			"iqama_issue_city" => "mcityiqama.city_name AS iqama_issue_city",
			"iqama_issue_date" => "emp.iqama_issue_date",
			"iqama_expiry_date" => "emp.iqama_expiry_date",
			"nationality_name" => "mn.name AS nationality_name",
			"passport_no" => "emp.passport_no",
			"passport_issue_date" => "emp.passport_issue_date",
			"passport_expiry_date" => "emp.passport_expiry_date",
			"passport_issue_country" => "mcp.name AS passport_issue_country",
			"passport_issue_city" => "mcitypp.city_name AS passport_issue_city",
			"department_name" => "md.name AS department_name",
			"designation_name" => "mjt.name AS designation_name",
			"work_line_manager" => "mlineman.full_name AS work_line_manager",
			"department_head" => "mdhead.full_name AS department_head",
			"employment_type" => "emp.employment_type",
			"working_hours" => "emp.working_hours",
			"working_days" => "emp.working_days",
			"location_name" => "ml.location_name",
			"payment_type_detail" => "emp.payment_type_detail",
			"basic_salary" => "emp.basic_salary",
			"housing_allowance" => "emp.housing_allowance",
			"transport_allowance" => "emp.transport_allowance",
			"food_allowance" => "emp.food_allowance",
			"mobile_allowance" => "emp.mobile_allowance",
			"other_allowance" => "emp.other_allowance",
			"total_package" => "emp.total_package",
			"annual_leave_entitlement" => "emp.annual_leave_entitlement",
			"camp_name" => "mcamp.camp_name",
			"room_name" => "mr.room_name",
			"bed_name" => "mb.bed_name",
			"employer_id" => "sps.employer_id",
			"employer_name" => "sps.employer_name",
			"employer_cr_no" => "sps.employer_cr_no",
			"employee_policy_no" => "mip.policy_number AS employee_policy_no",
			"policy_company_name" => "mic.company_name AS policy_company_name",
			"insurance_issue_date" => "mei.insurance_issue_date",
			"insurance_end_date" => "mei.insurance_end_date",
			"qiwa_contract_no" => "mei.qiwa_contract_no",
		];

		// -------------------------------
		// Step 3: SELECT columns
		// -------------------------------
		$columnsToSelect = [];
		foreach ($visibleColumns as $col) {
			if (isset($columnMap[$col])) {
				$columnsToSelect[] = $columnMap[$col];
			}
		}
		if (empty($columnsToSelect)) {
			$columnsToSelect[] = "emp.emp_no";
		}

		// -------------------------------
		// Step 4: FROM + JOINs
		// -------------------------------
		$baseFrom = " FROM master_employee emp
			LEFT JOIN master_employee_info mei ON emp.id = mei.employee_id
			LEFT JOIN master_insurance_policies mip ON mei.insurance_policy_no = mip.id
			LEFT JOIN master_insurance_company mic ON mip.policy_company = mic.id
			LEFT JOIN master_job_title mjt ON emp.designation = mjt.id
			LEFT JOIN master_department md ON emp.department = md.id
			LEFT JOIN master_profession mp ON emp.iqama_profession = mp.id
			LEFT JOIN master_location ml ON emp.work_location = ml.id
			LEFT JOIN master_nationality mn ON emp.nationality = mn.id
			LEFT JOIN master_camp mcamp ON emp.camp = mcamp.id
			LEFT JOIN master_rooms mr ON emp.room = mr.id
			LEFT JOIN master_bed mb ON emp.bed = mb.id
			LEFT JOIN sponsors sps ON emp.sponsor_id = sps.id 
			LEFT JOIN sim_card sc ON emp.id = sc.alloted_user 
			LEFT JOIN master_country mcp ON emp.passport_issue_country = mcp.id 
			LEFT JOIN master_city mcitypp ON emp.passport_issue_city = mcitypp.id 
			LEFT JOIN master_city mcityiqama ON emp.iqama_issue_city = mcityiqama.id 
			LEFT JOIN master_employee mlineman ON emp.work_line_manager = mlineman.id 
			LEFT JOIN master_employee mdhead ON emp.department_head = mdhead.id 
			LEFT JOIN (
				SELECT employee_id, MAX(sanat_no) AS sanat_no
				FROM sanat_al_amar
				GROUP BY employee_id
			) saa ON emp.id = saa.employee_id
			WHERE 1=1";

		// -------------------------------
		// Step 5: Filters
		// -------------------------------
		$where = "";

		// Keyword search
		if ($keyword) {
			$kw = $this->db->escape_like_str($keyword);

			$searchParts = [];
			foreach ($visibleColumns as $col) {
				if (isset($columnMap[$col])) {
					// Remove alias like "AS xyz" for search
					$searchCol = preg_replace('/\s+AS\s+\w+$/i', '', $columnMap[$col]);
					$searchParts[] = "{$searchCol} LIKE '%{$kw}%'";
				}
			}

			if (!empty($searchParts)) {
				$where .= " AND (" . implode(' OR ', $searchParts) . ")";
			}
		}

		// Multi filters
		if (!empty($nationality)) {
			$where .= " AND emp.nationality IN (" . implode(',', $nationality) . ")";
		}

		if (!empty($designation)) {
			$where .= " AND emp.designation IN (" . implode(',', $designation) . ")";
		}

		if (!empty($department)) {
			$where .= " AND emp.department IN (" . implode(',', $department) . ")";
		}

		if (!empty($employer)) {
			$where .= " AND emp.sponsor_id IN (" . implode(',', $employer) . ")";
		}

		// Iqama status
		if ($iqama_status) {
			$today = date("Y-m-d");
			if ($iqama_status === 'active') {
				$where .= " AND emp.iqama_expiry_date >= '{$today}'";
			} elseif ($iqama_status === 'expired') {
				$where .= " AND emp.iqama_expiry_date < '{$today}'";
			}
		}

		// Bed name
		if (!empty($bed_name)) {
			$where .= " AND emp.bed IN (" . implode(',', $bed_name) . ")";
		}

		// Camp name
		if (!empty($camp_name)) {
			$where .= " AND emp.camp IN (" . implode(',', $camp_name) . ")";
		}

		// Department head
		if (!empty($department_head)) {
			$where .= " AND emp.department_head IN (" . implode(',', $department_head) . ")";
		}

		// Work line manager
		if (!empty($work_line_manager)) {
			$where .= " AND emp.work_line_manager IN (" . implode(',', $work_line_manager) . ")";
		}

		// Gender
		if (!empty($gender)) {
			$gender_escaped = array_map([$this->db, 'escape'], $gender); // safely wrap in quotes
			$where .= " AND emp.gender IN (" . implode(',', $gender_escaped) . ")";
		}

		// Marital Status
		if (!empty($marital_status)) {
			$marital_status_escaped = array_map([$this->db, 'escape'], $marital_status); // safely wrap in quotes
			$where .= " AND emp.marital_status IN (" . implode(',', $marital_status_escaped) . ")";
		}

		// Religion
		if (!empty($religion)) {
			$religion_escaped = array_map([$this->db, 'escape'], $religion); // safely wrap in quotes
			$where .= " AND emp.religion IN (" . implode(',', $religion_escaped) . ")";
		}

		// Passport no (text)
		if ($passport_no) {
			$where .= " AND emp.passport_no LIKE '%" . $this->db->escape_str($passport_no) . "%'";
		}

		// Employee Policy no (text)
		if ($employee_policy_no) {
			$where .= " AND mip.policy_number LIKE '%" . $this->db->escape_str($employee_policy_no) . "%'";
		}

		// Passport issue country
		if (!empty($passport_issue_country)) {
			$where .= " AND emp.passport_issue_country IN (" . implode(',', $passport_issue_country) . ")";
		}

		// Iqama number filter
		if ($iqama) {
			$where .= " AND emp.iqama_no = '" . $this->db->escape_str($iqama) . "'";
		}

		// Passport issue city
		if (!empty($passport_issue_city)) {
			$where .= " AND emp.passport_issue_city IN (" . implode(',', $passport_issue_city) . ")";
		}

		// Iqama issue city
		if (!empty($iqama_issue_city)) {
			$where .= " AND emp.iqama_issue_city IN (" . implode(',', $iqama_issue_city) . ")";
		}
		
		// Work Location
		if (!empty($work_location)) {
			$where .= " AND emp.work_location IN (" . implode(',', $work_location) . ")";
		}

		// Terminate reason
		if (!empty($terminate_reason)) {
			$terminate_reason_escaped = array_map([$this->db, 'escape'], $terminate_reason);
			$where .= " AND emp.terminate_reason IN (" . implode(',', $terminate_reason_escaped) . ")";
		}

		// Iqama expiry date range
		if ($iqama_issue_start_date && $iqama_issue_end_date) {
			$startDate = date("Y-m-d", strtotime($iqama_issue_start_date));
			$endDate   = date("Y-m-d", strtotime($iqama_issue_end_date));
			$where .= " AND (emp.iqama_expiry_date BETWEEN '{$startDate}' AND '{$endDate}')";
		}

		// Last working date range
		if ($last_working_start && $last_working_end) {
			$lastWorkingStart = date("Y-m-d", strtotime($last_working_start));
			$lastWorkingEnd   = date("Y-m-d", strtotime($last_working_end));
			$where .= " AND (emp.last_working_date BETWEEN '{$lastWorkingStart}' AND '{$lastWorkingEnd}')";
		}

		// Status + viewType logic
		if ($viewType === 'all' && !empty($status)) {
			$statuses = array_map([$this->db, 'escape_str'], $status);
			$where .= " AND emp.status IN ('" . implode("','", $statuses) . "')";
		} elseif ($viewType === 'active') {
			$where .= " AND emp.status = 'Active'";
		} elseif ($viewType === 'terminated') {
			$where .= " AND emp.status = 'Terminated'";
		}

		// Joining date range
		if ($start_date && $end_date) {
			$joinStart = date("Y-m-d", strtotime($start_date));
			$joinEnd   = date("Y-m-d", strtotime($end_date));
			$where .= " AND (emp.work_joining_date BETWEEN '{$joinStart}' AND '{$joinEnd}')";
		}

		// Date of Birth
		if ($dob_start && $dob_end) {
			$start = date("Y-m-d", strtotime($dob_start));
			$end   = date("Y-m-d", strtotime($dob_end));
			$where .= " AND (emp.dob BETWEEN '{$start}' AND '{$end}')";
		}

		// Passport Issue Date
		if ($passport_issue_start && $passport_issue_end) {
			$start = date("Y-m-d", strtotime($passport_issue_start));
			$end   = date("Y-m-d", strtotime($passport_issue_end));
			$where .= " AND (emp.passport_issue_date BETWEEN '{$start}' AND '{$end}')";
		}

		// Passport Expiry Date
		if ($passport_expiry_start && $passport_expiry_end) {
			$start = date("Y-m-d", strtotime($passport_expiry_start));
			$end   = date("Y-m-d", strtotime($passport_expiry_end));
			$where .= " AND (emp.passport_expiry_date BETWEEN '{$start}' AND '{$end}')";
		}

		// Insurance Issue Date
		if ($insurance_issue_start && $insurance_issue_end) {
			$start = date("Y-m-d", strtotime($insurance_issue_start));
			$end   = date("Y-m-d", strtotime($insurance_issue_end));
			$where .= " AND (mei.insurance_issue_date BETWEEN '{$start}' AND '{$end}')";
		}

		// Insurance End Date
		if ($insurance_end_start && $insurance_end_end) {
			$start = date("Y-m-d", strtotime($insurance_end_start));
			$end   = date("Y-m-d", strtotime($insurance_end_end));
			$where .= " AND (mei.insurance_end_date BETWEEN '{$start}' AND '{$end}')";
		}

		// Selected checkbox filter
		if (!empty($filters['selected_ids'])) {
			$ids = array_map('intval', $filters['selected_ids']); // sanitize IDs
			$where .= " AND emp.id IN (" . implode(',', $ids) . ")";
		}
		// -------------------------------
		// Step 6: Pagination count
		// -------------------------------
		$countQuery = "SELECT COUNT(*) AS total" . $baseFrom . $where;
		$totalRowsCount = $this->db->query($countQuery)->row()->total;

		// -------------------------------
		// Step 7: Final data query
		// -------------------------------
		$dataQuery = "SELECT " . implode(', ', $columnsToSelect) . $baseFrom . $where . " GROUP BY emp.id ORDER BY emp.emp_no DESC";
		if ($perPage > 0) {
			$dataQuery .= " LIMIT " . intval($perPage) . " OFFSET " . intval($start);
		}

		$result = $this->db->query($dataQuery)->result_array();

		// -------------------------------
		// Step 8: Return result
		// -------------------------------
		return [
			'data' => $result,
			'available_columns' => $allColumnKeys,
			'visible_columns' => $visibleColumns,
			'pagination' => [
				'total' => (int)$totalRowsCount,
				'per_page' => (int)$perPage,
				'current_page' => (int)$start
			]
		];
	}

	/**
	 * Helper: Parse comma-separated or array values into clean array of ints
	 */
	private function _parseMulti($value)
	{
		if (is_array($value)) {
			return array_map('trim', $value); // Keep strings, remove spaces
		} elseif (is_string($value) && strpos($value, ',') !== false) {
			return array_map('trim', explode(',', $value)); // Split and trim
		} elseif (strlen(trim($value)) > 0) {
			return [trim($value)]; // Single value
		}
		return [];
	}
	
	//End
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_employee WHERE id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM master_employee_info WHERE employee_id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM master_employee_contracts WHERE employee_id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM master_employee_transactions WHERE employee_id = '" . $ids[$i] . "'");
			$this->db->query("DELETE FROM master_employee_doc WHERE emp_id = '". (int)$ids[$i] ."'");
		}
		return true;
	}

	public function get_last_rider_order_summary($employee_id) {
		$this->db->select('hos.*, lr.activate_date');
		$this->db->from('logistic_rider as lr');
		$this->db->join('hunger_order_summary as hos', 'lr.id_number = hos.rider_id', 'left');
		$this->db->where('lr.employee_id', $employee_id);
		$this->db->order_by('hos.date_local', 'DESC');
		$this->db->limit(1);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return the last row as an associative array
		} else {
			return null; // Return null if no rows are found
		}
	}
	
	function get_detail($id) {
		$this->db->select('master_employee.*, 
						mei.qiwa_contract_no,
						mei.driving_license_number,
						mjt.name as designation_name, 
						mjt.arabic_name as designation_name_ar, 
						md.name as department_name, 
						mn.name as nationality_name, 
						mn.arabic_name as nationality_name_ar,
						ml.location_name as work_location_name,
						mp.profession_name,
						sp.employer_name as sponsor_name,
						sp.employer_id as sponsor_employer_id,
						sp.employer_arabic_name as sponsor_arabic_name,
						sp.employer_cr_no as sponsor_cr_no,
						sp.mol_id as sponsor_mol_id,
						sp.employer_address as sponsor_address,
						sp.employer_email as sponsor_email,
						sp.represented_by,
						sp.employer_work_location as sponsor_work_location');
		$this->db->from('master_employee');
		$this->db->join('master_employee_info mei', 'master_employee.id = mei.employee_id', 'left');
		$this->db->join('master_job_title mjt', 'master_employee.designation = mjt.id', 'left');
		$this->db->join('master_department md', 'master_employee.department = md.id', 'left');
		$this->db->join('master_nationality mn', 'master_employee.nationality = mn.id', 'left');
		$this->db->join('master_profession mp', 'master_employee.iqama_profession = mp.id', 'left');
		$this->db->join('master_location ml', 'master_employee.work_location = ml.id', 'left');
		$this->db->join('sponsors sp', 'master_employee.sponsor_id = sp.id', 'left');
		$this->db->where('master_employee.id', (int)$id);
		
		$query = $this->db->get();
		return $query->row();
	}

	public function get_employee_by_id($id)
	{
		return $this->db->get_where('master_employee', ['id' => $id])->row();
	}

	public function update_email_in_admin_table($employee_id, $new_email)
	{
		$this->db->where('employee_id', $employee_id);
		$this->db->update('admin', ['email' => $new_email]);
	}

	function get_emp_info($id){
		$query = $this->db->query("SELECT master_employee_info.* FROM master_employee_info WHERE master_employee_info.employee_id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_active_contract($id){
		$this->db->where('employee_id',$id);
		$this->db->where('contract_end_date >=',date('Y-m-d'));
		$q = $this->db->get('master_employee_contracts');
		return $q->result_array();
	}

	function get_expired_contract($id){
		$this->db->where('employee_id',$id);
		$this->db->where('contract_end_date <=',date('Y-m-d'));
		$q = $this->db->get('master_employee_contracts');
		return $q->result_array();
	}

	function get_salary_logs($id){
		$this->db->where('employee_id',$id);
		$q = $this->db->get('employee_salary_log');
		return $q->result_array();
	}

	function get_salary_log_detail($id){
		$this->db->where('id',$id);
		$q = $this->db->get('employee_salary_log');
		return $q->row();
	}
	
	function get_emp_docs($id){
		$this->db->select("*");  
		$this->db->from('master_employee_doc');  
		$this->db->where('emp_id', (int)$id);  
		$this->db->where('doc_category', 'my_documents');  
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_company_docs($id){
		$this->db->select("*");  
		$this->db->from('master_employee_doc');  
		$this->db->where('emp_id', (int)$id);  
		$this->db->where('doc_category', 'my_hr_letter');  
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_trans_info($id){
		$this->db->select('er.*, erd.request_detail, erd.request_documents, erd.reason, me.emp_no, me.full_name as employee_name, mjt.name as designation_name, rme.full_name as requester_name, rme.employee_arabic_name as requester_arabic_name');
        $this->db->from('employee_requests er');
        $this->db->join('employee_request_detail erd', 'er.id = erd.request_id', 'left');
        $this->db->join('master_employee me', 'er.employee_id = me.id', 'left');
        $this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
        $this->db->join('master_employee rme', 'er.requested_by = rme.id', 'left');
		$this->db->where('er.employee_id', (int)$id); 
		// Grouping WHERE conditions for request_type
		$this->db->group_start();
		$this->db->where('er.request_type', 'LoanRequest');
		$this->db->or_where('er.request_type', 'TransactionRequest');
		$this->db->group_end();
        $this->db->order_by('er.id', 'DESC');
        return $this->db->get()->result_array();
	}

	function get_emp_family($id){
		$this->db->select("*");  
		$this->db->from('emp_family_members');  
		$this->db->where('emp_id', (int)$id);  
		$query = $this->db->get();
		return $query->result_array();
	}

	function delete_image(){
		$id = $this->input->post('img_id');
		$empid = $this->input->post('emp_id');
		$query = $this->db->query("DELETE FROM master_employee_doc WHERE id = '" . (int)$id . "' AND emp_id = '". (int)$empid ."' LIMIT 1");
		return $query;
	}

	function check_duplicate_passport($id, $passport_no){
		$this->db->select("*");  
		$this->db->from('master_employee'); 
		$this->db->where('id !=',$id);
		$this->db->where('passport_no =',$passport_no);
		return $this->db->count_all_results();  
	}
	
	function check_duplicate_empid($id, $emp_no){
		$this->db->select("*");  
		$this->db->from('master_employee'); 
		$this->db->where('id !=',$id);
		$this->db->where('emp_no =',$emp_no);
		return $this->db->count_all_results();  
	}
	
	function check_duplicate_email($id, $email){
		$this->db->select("*");  
		$this->db->from('master_employee'); 
		$this->db->where('id !=',$id);
		$this->db->where('email =',$email);
		return $this->db->count_all_results();  
	}

	// function uploadProfilePic(){
	// 	$query = FALSE;
	// 	$this->db->trans_start();
	// 	if($_FILES['employee_pic']['name'][0] !== ''){
	// 		//print_r($_FILES['documents']);exit();
	// 		$con['upload_path']   = './uploads/employee_pic/'; 
	// 		$con['allowed_types'] = 'jpg|png|jpeg'; 
	// 		$con['maintain_ratio'] = TRUE;
	// 		$con['max_filename'] = '50';
	// 		$con['encrypt_name'] = TRUE;

	// 		$this->load->library('upload', $con);
	// 		$this->upload->do_upload('employee_pic');
	// 		$image_da = $this->upload->data();
	// 		$attachments = "uploads/employee_pic/".$image_da['file_name'];
	// 		if($image_da['file_name'] !== ''){
	// 			$query = $this->db->query("UPDATE master_employee SET employee_pic = '" . $this->db->escape_str($attachments) . "' WHERE id = '" . (int)$this->input->post('emp_id') . "'");
	// 		}
	// 	}
	// 	$this->db->trans_complete();
	// 	return $query;
	// }

	public function uploadProfilePic($emp_id)
	{
		$path = './uploads/employee_pic/';

		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		$newName = 'emp_'.$emp_id.'_'.time().'.png';

		$config = [
			'upload_path'   => $path,
			'allowed_types' => 'jpg|jpeg|png|gif|webp',
			'file_name'     => $newName,
			'overwrite'     => TRUE,
			'detect_mime'   => TRUE
		];

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('employee_pic')) {
			return [
				"status" => false,
				"error"  => $this->upload->display_errors()
			];
		}

		$file = $this->upload->data();
		$image = 'uploads/employee_pic/'.$file['file_name'];

		// update DB
		$this->db->where('id', $emp_id);
		$this->db->update('master_employee', [
			"employee_pic" => $image
		]);

		return [
			"status" => true,
			"image"  => base_url($image)
		];
	}
	
	function uploadDocuments(){
		$query = FALSE;
		$this->db->trans_start();
		if($_FILES['document']['name'][0] !== ''){
			//print_r($_FILES['documents']);exit();
			$con['upload_path']   = './uploads/employee-docs/'; 
			$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
			$con['maintain_ratio'] = TRUE;
			$con['max_filename'] = '50';
			$con['encrypt_name'] = TRUE;

			$this->load->library('upload', $con);
			$this->upload->do_upload('document');
			$image_da = $this->upload->data();
			$attachments = "uploads/employee-docs/".$image_da['file_name'];
			if($image_da['file_name'] !== ''){
				$query = $this->db->query("INSERT INTO master_employee_doc SET emp_id = '" . (int)$this->input->post('emp_id') . "', document = '" . $this->db->escape_str($attachments) . "', doc_type = '" . $this->db->escape_str($this->input->post('doc_type')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "'");
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function uploadCompanyDocuments(){
		$query = FALSE;
		$this->db->trans_start();
		if($_FILES['document']['name'][0] !== ''){
			//print_r($_FILES['documents']);exit();
			$con['upload_path']   = './uploads/employee-docs/'; 
			$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
			$con['maintain_ratio'] = TRUE;
			$con['max_filename'] = '50';
			$con['encrypt_name'] = TRUE;

			$this->load->library('upload', $con);
			$this->upload->do_upload('document');
			$image_da = $this->upload->data();
			$attachments = "uploads/employee-docs/".$image_da['file_name'];
			if($image_da['file_name'] !== ''){
				$query = $this->db->query("INSERT INTO master_employee_doc SET emp_id = '" . (int)$this->input->post('emp_id') . "', document = '" . $this->db->escape_str($attachments) . "', doc_type = '" . $this->db->escape_str($this->input->post('doc_type')) . "', doc_category = 'my_hr_letter', description = '" . $this->db->escape_str($this->input->post('description')) . "'");
			}
		}
		$this->db->trans_complete();
		return $query;
	}

	public function checkDuplicateInBulk($data) {
        // Query the database to check for duplicates based on emp_no, iqama_no, passport_no
        $this->db->group_start();
        $this->db->where('emp_no', $data['emp_no']);
		if($data['iqama_no'] !== '' && !empty($data['iqama_no'])){
			$this->db->or_where('iqama_no', $data['iqama_no']);
		}
        if($data['passport_no'] !== '' && !empty($data['passport_no'])){
			$this->db->or_where('passport_no', $data['passport_no']);
		}
        $this->db->group_end();
        $query = $this->db->get('master_employee');

        // If a row is returned, it means the data already exists and is a duplicate
        return $query->row();
    }

	public function getVehicleByUser($userId) {
		$this->db->select('mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name');
		$this->db->from('master_vehicles mv');
		$this->db->join('mater_van_make mvk', 'mvk.id = mv.vehicle_make', 'left');
		$this->db->where('mv.alloted_user', $userId);
		return $this->db->get()->row();
	}

	public function getSimByUser($userId) {
		$this->db->select('mobile, sim_no, sim_type, alloted_user, status');
		$this->db->from('sim_card');
		$this->db->where('alloted_user', $userId);
		return $this->db->get()->row();
	}

	public function getAggregatorId($userId) {
		$this->db->select('id_number,allotment_status');
		$this->db->from('logistic_rider');
		$this->db->where('employee_id', $userId);
		return $this->db->get()->row();
	}
	
	public function getDlStatus($userId) {
		$this->db->select('request_no, status, trans_status');
		$this->db->from('dl_request');
		$this->db->where('emp_id', $userId);
		$this->db->order_by('id', 'DESC');
		return $this->db->get()->row();
	}
	/*
	public function getSimLogsByUser($userId) {
        $this->db->select('srl.id, srl.sim_id, srl.user_id, srl.status_date, srl.status, sim_card.sim_no, sim_card.mobile, sim_card.sim_type, sim_card.network, mn.network_name');
        $this->db->from('sim_logs srl');
		$this->db->join('sim_card', 'srl.sim_id = sim_card.id', 'left');
		$this->db->join('master_network mn', 'sim_card.network = mn.id', 'left');
		$this->db->where('srl.user_id', $userId);
        $this->db->order_by('srl.created_at', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
	*/
	public function getSimLogsByUser($userId)
	{
		$sql = "
			SELECT 
				s1.id,
				s1.sim_id,
				sc.sim_no,
				sc.mobile,
				sc.sim_type,
				mn.network_name,
				s1.status_date AS allot_date,
				(
					SELECT MIN(s2.status_date)
					FROM sim_logs s2
					WHERE s2.sim_id = s1.sim_id 
					AND s2.status = 2
					AND s2.status_date > s1.status_date
					AND s2.user_id = s1.user_id
				) AS unallot_date
			FROM sim_logs s1
			LEFT JOIN sim_card sc ON s1.sim_id = sc.id
			LEFT JOIN master_network mn ON sc.network = mn.id
			WHERE s1.status = 1
			AND s1.user_id = ?
			GROUP BY s1.sim_id, s1.status_date
			ORDER BY s1.status_date DESC
		";

		$query = $this->db->query($sql, [$userId]);
		return $query->result_array();
	}

	public function update_status($id, $data) {
		if (empty($id) || empty($data) || !is_array($data)) {
			return false; // Ensure valid input
		}
	
		$this->db->where('id', $id);
		return $this->db->update('master_employee', $data);
	}
	
	function remove_reporting_roles($id) {
		$this->db->trans_start();

		$sql = "
			UPDATE master_employee
			SET 
				work_line_manager = CASE 
					WHEN work_line_manager = ? THEN '' 
					ELSE work_line_manager 
				END,
				department_head = CASE 
					WHEN department_head = ? THEN '' 
					ELSE department_head 
				END,
				updated_at = '" . CURRENT_TIME . "'
			WHERE work_line_manager = ? OR department_head = ?
		";

		$query = $this->db->query($sql, [$id, $id, $id, $id]);

		$this->db->trans_complete();
		return $query;
	}

	public function getIqamaList($postData)
	{
		$column_order = ['me.emp_no', 'me.full_name', 'me.iqama_no', 'sp.employer_name', 'me.iqama_expiry_date', 'mjt.name as designation_name', 'mp.profession_name', 'dlr.trans_status as dl_status', 'dlr.status as dl_status2'];
		$order_by = 'me.iqama_expiry_date';

		// ================================
		// Step 1: Base query (used for total count)
		// ================================
		$this->db->from('master_employee me');
		$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
		$this->db->join('master_insurance_policies mip', 'mei.insurance_policy_no = mip.id', 'left');
        $this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
		$this->db->join('master_nationality mn', 'me.nationality = mn.id', 'left');
		$this->db->join('master_profession mp', 'me.iqama_profession = mp.id', 'left');
		$this->db->join('sponsors sp', 'me.sponsor_id = sp.id', 'left');
		$this->db->join('(SELECT * FROM dl_request dr1 WHERE dr1.id = (SELECT MAX(id) FROM dl_request WHERE emp_id = dr1.emp_id)) dlr', 'me.id = dlr.emp_id', 'left');
		$this->db->where('me.iqama_expiry_date IS NOT NULL');
		$this->db->where('me.status', 'Active');

		$totalCount = $this->db->count_all_results();

		// ================================
		// Step 2: Full SELECT with filters
		// ================================
		$this->db->select("
			me.id, me.emp_no, me.full_name, me.iqama_no, me.nationality, mei.driving_license_number, mp.profession_name,
			mn.name as nationality_name, mjt.name as designation_name, dlr.trans_status as dl_status, dlr.status as dl_status2, sp.employer_id, sp.employer_name,
			me.iqama_expiry_date, mip.policy_expiry,
			CASE 
				WHEN me.iqama_expiry_date IS NULL OR me.iqama_expiry_date = '' THEN 'NA'
				WHEN me.iqama_expiry_date < CURDATE() THEN 'Expired'
				WHEN me.iqama_expiry_date >= CURDATE() AND me.iqama_expiry_date < DATE_ADD(CURDATE(), INTERVAL 15 DAY) THEN 'Expiring Soon'
				WHEN me.iqama_expiry_date >= DATE_ADD(CURDATE(), INTERVAL 15 DAY) AND me.iqama_expiry_date < DATE_ADD(CURDATE(), INTERVAL 2 MONTH) THEN 'Valid'
				ELSE 'Valid'
			END AS iqama_status_category,
			CASE 
				WHEN mip.policy_expiry IS NULL OR mip.policy_expiry = '' THEN 'NA'
				WHEN mip.policy_expiry < CURDATE() THEN 'Expired'
				WHEN mip.policy_expiry >= CURDATE() AND mip.policy_expiry < DATE_ADD(CURDATE(), INTERVAL 1 MONTH) THEN 'Expiring Soon'
				WHEN mip.policy_expiry >= DATE_ADD(CURDATE(), INTERVAL 1 MONTH) AND mip.policy_expiry < DATE_ADD(CURDATE(), INTERVAL 2 MONTH) THEN 'Valid'
				ELSE 'Valid'
			END AS insurance_status_category
		", false);

		$this->db->from('master_employee me');
		$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
		$this->db->join('master_insurance_policies mip', 'mei.insurance_policy_no = mip.id', 'left');
        $this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
		$this->db->join('master_nationality mn', 'me.nationality = mn.id', 'left');
		$this->db->join('master_profession mp', 'me.iqama_profession = mp.id', 'left');
		$this->db->join('sponsors sp', 'me.sponsor_id = sp.id', 'left');
		$this->db->join('(SELECT * FROM dl_request dr1 WHERE dr1.id = (SELECT MAX(id) FROM dl_request WHERE emp_id = dr1.emp_id)) dlr', 'me.id = dlr.emp_id', 'left');
		$this->db->where('me.iqama_expiry_date IS NOT NULL');
		$this->db->where('me.status', 'Active');
		$this->db->order_by($order_by, 'ASC');

		// ================================
		// Step 3: Apply filters
		// ================================
		if (!empty($postData['keyword'])) {
			$this->db->group_start();
			$this->db->like('me.emp_no', $postData['keyword']);
			$this->db->or_like('me.full_name', $postData['keyword']);
			$this->db->group_end();
		}

		if (!empty($postData['iqama_no'])) {
			$this->db->like('me.iqama_no', $postData['iqama_no']);
		}

		if (!empty($postData['start_date'])) {
			$start_date = DateTime::createFromFormat('d-m-Y', $postData['start_date'])->format('Y-m-d');
			$this->db->where('me.iqama_expiry_date >=', $start_date);
		}

		if (!empty($postData['end_date'])) {
			$end_date = DateTime::createFromFormat('d-m-Y', $postData['end_date'])->format('Y-m-d');
			$this->db->where('me.iqama_expiry_date <=', $end_date);
		}

		if (!empty($postData['employeer_id'])) {
			$this->db->like('me.sponsor_id', $postData['employeer_id']);
		}

		if (!empty($postData['nationality'])) {
			$this->db->where('me.nationality', $postData['nationality']);
		}

		if (!empty($postData['designation'])) {
			$this->db->where('me.designation', $postData['designation']);
		}

		if (!empty($postData['iqama_status'])) {
			switch ($postData['iqama_status']) {
				case 'Expired':
					$this->db->where('me.iqama_expiry_date <', date('Y-m-d'));
					break;
				case 'Expiring Soon':
					$this->db->where('me.iqama_expiry_date >=', date('Y-m-d'));
					$this->db->where('me.iqama_expiry_date <', date('Y-m-d', strtotime('+15 days')));
					break;
				case 'Valid':
					$this->db->where('me.iqama_expiry_date >=', date('Y-m-d', strtotime('+1 month')));
					$this->db->where('me.iqama_expiry_date <', date('Y-m-d', strtotime('+2 month')));
					break;
			}
		}

		// ================================
		// Step 4: Get filtered count before pagination
		// ================================
		$filteredQuery = clone $this->db;
		$recordsFiltered = $filteredQuery->count_all_results('', false);

		// ================================
		// Step 5: Pagination
		// ================================
		if (isset($postData['length']) && $postData['length'] != -1) {
			$this->db->limit($postData['length'], $postData['start']);
		}

		$query = $this->db->get();
		$data = $query->result();

		return [
			'data' => $data,
			'recordsTotal' => $totalCount,
			'recordsFiltered' => $recordsFiltered,
		];
	}

	//Secondary DL
	public function save_secondary_dl($emp_id, $dl_data)
	{
		// Fetch current JSON data
		$this->db->select('secondary_dl_details');
		$this->db->where('employee_id', $emp_id);
		$query = $this->db->get('master_employee_info');

		if ($query->num_rows() > 0) {
			$result = $query->row();
			$existing_data = json_decode($result->secondary_dl_details, true);

			if (!is_array($existing_data)) {
				$existing_data = [];
			}

			// Push new DL data to array
			$existing_data[] = $dl_data;

			// Update JSON column
			$this->db->where('employee_id', $emp_id);
			return $this->db->update('master_employee_info', [
				'secondary_dl_details' => json_encode($existing_data),
				'updated_at' => date('Y-m-d H:i:s')
			]);
		}

		return false;
	}

	public function get_by_employee_id($employee_id)
	{
		return $this->db->get_where('master_employee_info', ['employee_id' => $employee_id])->row();
	}

	public function update_secondary_dl($employee_id, $dl_array)
	{
		return $this->db
			->where('employee_id', $employee_id)
			->update('master_employee_info', ['secondary_dl_details' => json_encode($dl_array)]);
	}

	public function update_iqama_detail($emp_id, $iqama_array)
	{
		$exists = $this->db->where('id', $emp_id)->get('master_employee')->num_rows();

		if ($exists == 0) {
			return false;
		}

		$this->db->where('id', $emp_id)->update('master_employee', $iqama_array);

		return $this->db->affected_rows() > 0;
	}
	
	public function check_existing_employee_request($requestType, $empID)
	{
		$this->db->select('emp_req.*, erd.request_detail, erd.request_documents, erd.uploaded_video, erd.reason');
		$this->db->from('employee_requests emp_req');
		$this->db->join('employee_request_detail erd', 'emp_req.id = erd.request_id', 'left');
		$this->db->where('emp_req.request_type', $requestType);
		$this->db->where('emp_req.employee_id', $empID);
		$this->db->where_in('emp_req.request_status', [1, 6]);
		$this->db->order_by('emp_req.id', 'DESC'); // latest record
		$this->db->limit(1); // only 1 row

		$query = $this->db->get();
		return $query->row_array();
	}
}
