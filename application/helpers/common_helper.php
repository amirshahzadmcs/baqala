<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use HanifHefaz\Dcter\Dcter;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

if( ! function_exists('age_calculate')){
	function age_calculate($date){
		if($date !== ''){
			$dateOfBirth = $date;
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));
			$output = $diff->format('%y');
			return $output;
		}
	}
}

if( ! function_exists('dateDiffHelper')){
	function dateDiffHelper($date, $differenceFormat = '%r%a'){
		if($date !== ''){
			$today = date("Y-m-d");
			$diff = date_diff(date_create($today), date_create($date));
			$expiryInDays = $diff->format($differenceFormat);
			return $expiryInDays;
		}else{
			return false;
		}
	}
}

if( ! function_exists('convertSecToHrs')){
	function convertSecToHrs($param){
		if($param !== ''){
		    $init = $param;
            $hours = floor($init / 3600);
            $minutes = floor(($init / 60) % 60);
            $seconds = $init % 60;
            $formatedTime = sprintf('%02d:%02d:%02d',$hours,$minutes,$seconds);
			return $formatedTime;
		}else{
			return false;
		}
	}
}


if( ! function_exists('dateFormatHelper')){
	function dateFormatHelper($date){
		if($date !== ''){
			$dateTime = DateTime::createFromFormat('d/M/Y', $date);
			if (!$dateTime) {
				// If the first format fails, try the second format
				$dateTime = DateTime::createFromFormat('d-M-Y', $date);
			}
			
			if ($dateTime) {
				// Format the DateTime object into the desired format
				$formattedDate = $dateTime->format('Y-m-d');
				return $formattedDate; // Output: 1984-09-14
			}
		}else{
			return false;
		}
	}
}

if( ! function_exists('docAlertHelper')){
	function docAlertHelper($date, $doctype, $differenceFormat = '%r%a'){
		if($date !== ''){
			$today = date("Y-m-d");
			$diff = date_diff(date_create($today), date_create($date));
			$expiryInDays = $diff->format($differenceFormat);
			if($expiryInDays < 31 && $expiryInDays > 0){
				$showAlert = '<a href="javascript:;" class="float-end" onclick="return confirm(\'Your '. $doctype .' will be expiring soon, check detail page!\')"><span class="dripicons-information ms-1 text-warning font-size-18"></span></a>';
			}elseif($expiryInDays < 1){
				$showAlert = '<a href="javascript:;" class="float-end" onclick="return confirm(\'Your '. $doctype .' is expired, check detail page!\')"><span class="dripicons-information ms-1 text-danger font-size-18"></span></a>';
			}else{
				$showAlert = '';
			}
			return $showAlert;
		}else{
			return false;
		}
	}
}

if( ! function_exists('iqamaExpAlert')){
	function iqamaExpAlert($date, $differenceFormat = '%r%a'){
		if($date !== ''){
			$today = date("Y-m-d");
			$diff = date_diff(date_create($today), date_create($date));
			$expiryInDays = $diff->format($differenceFormat);
			if($expiryInDays < 31 && $expiryInDays > 0){
				$showAlert = '<div class="alert alert-danger" role="alert">Your Iqama will be expired in '. $expiryInDays .' Days. Please renew before it expired.</div>';
			}elseif($expiryInDays < 1){
				$showAlert = '<div class="alert bg-danger text-white" role="alert">Your Iqama is expired, please renew and contact to senior authority.</div>';
			}else{
				$showAlert = '';
			}
			return $showAlert;
		}else{
			return false;
		}
	}
}

if( ! function_exists('dlExpAlert')){
	function dlExpAlert($date, $differenceFormat = '%r%a'){
		if($date !== ''){
			$today = date("Y-m-d");
			$diff = date_diff(date_create($today), date_create($date));
			$expiryInDays = $diff->format($differenceFormat);
			if($expiryInDays < 31 && $expiryInDays > 0){
				$showAlert = '<div class="alert alert-danger" role="alert">Your Driving Licence will be expired in '. $expiryInDays .' Days. Please renew before it expired.</div>';
			}elseif($expiryInDays < 1){
				$showAlert = '<div class="alert bg-danger text-white" role="alert">Your Driving Licence is expired, please renew and contact to senior authority.</div>';
			}else{
				$showAlert = '';
			}
			return $showAlert;
		}else{
			return false;
		}
	}
}

if( ! function_exists('formatedDateTime')){
	function formatedDateTime($date){
		$formated_date = date('d-m-Y h:i:s', strtotime($date));
		return $formated_date;
	}
}

if( ! function_exists('formatedDate')){
	function formatedDate($date){
		$formated_date = date('d-m-Y', strtotime($date));
		return $formated_date;
	}
}

if( ! function_exists('invoiceNmFormat')){
	function invoiceNmFormat($number){
		$formated_no = str_pad($number, 6, 0, STR_PAD_LEFT);
		return $formated_no;
	}
}

if( ! function_exists('accountNoFormat')){
	function accountNoFormat($number){
		$formated_no = str_pad($number, 6, 0, STR_PAD_LEFT);
		return $formated_no;
	}
}

if( ! function_exists('getRegions')){
	function getRegions(){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_regions ORDER BY region_name ASC");
		return $query->result();
	}
}

if( ! function_exists('masterCountries')){
	function masterCountries()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_country ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('getCities')){
	function getCities(){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT master_city.*, master_country.name as country_name FROM master_city LEFT JOIN master_country ON (master_city.country_id = master_country.id) ORDER BY city_name ASC");
		return $query;
	}
}

if( ! function_exists('cityDetailHelper')){
	function cityDetailHelper($city_id){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_city where id='" . $city_id ."'");
		return $query->row();
	}
}

if( ! function_exists('countryDetailHelper')){
	function countryDetailHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_country where id='" . $id ."'")->row();
		return $query;
	}
}

if( ! function_exists('selectedCitiesHelp')){
	function selectedCitiesHelp($country_id){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_city where country_id='" . $country_id ."' ORDER BY city_name ASC");
		return $query->result();
	}
}

if( ! function_exists('makeList')){
	function makeList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM mater_van_make WHERE deleted = '0' AND status = '1' ORDER BY make_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('vehicleType')){
	function vehicleType()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_vehicle_type WHERE status = '1' ORDER BY vehicle_type ASC")->result();
		return $query;
	}
}

if( ! function_exists('colorList')){
	function colorList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_color WHERE deleted = '0' AND status = '1' ORDER BY color_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('bankList')){
	function bankList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_bank WHERE deleted = '0' AND status = '1' ORDER BY bank_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('areaList')){
	function areaList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM service_area WHERE deleted = '0' AND status = '1' ORDER BY area_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('professionList')){
	function professionList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_profession WHERE deleted = '0' AND status = '1' ORDER BY profession_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('nationalityList')){
	function nationalityList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_nationality ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('teamList')){
	function teamList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT id, name, ar_name, status FROM `hunger_team` WHERE status = '1' ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('activeSalaryPackage')){
	function activeSalaryPackage()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_salary_packages WHERE status = '1' ORDER BY package_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('salaryPackage')){
	function salaryPackage()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_salary_packages ORDER BY package_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('salaryPackageDetail')){
	function salaryPackageDetail($package_id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT msp.*, md.name as department_name FROM master_salary_packages msp LEFT JOIN master_department md ON (msp.department = md.id) WHERE msp.id = '". $package_id ."'")->row();
		return $query;
	}
}

if( ! function_exists('rolesList')){
	function rolesList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM roles WHERE deleted = '0' ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('logisticPartnerList')){
	function logisticPartnerList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM delivery_partner WHERE status = '1' ORDER BY company_name ASC")->result();
		return $query;
	}
}
if( ! function_exists('deliveryBoyList')){
	function deliveryBoyList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT me.*, mjt.name as designation_name, md.name as department_name FROM master_employee me LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE me.status = 'active' AND (me.designation = '3' OR me.designation = '18') ORDER BY me.full_name ASC");
		return $query;
	}
}

if( ! function_exists('inhouseDeliveryBoy')){
	function inhouseDeliveryBoy()
	{
		$CI =& get_instance();
       	$CI->load->database();
		   $query = $CI->db->query("SELECT me.*, mjt.name as designation_name FROM master_employee me LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE me.status = 'active' AND (me.designation = '3' OR me.designation = '18') ORDER BY me.full_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('employeeListHelper')){
	function employeeListHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT me.*, mjt.name as designation_name, md.name as department_name FROM master_employee me LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE me.status = 'Active' ORDER BY me.full_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('roleWiseEmpListHelper')){
	function roleWiseEmpListHelper($role, $employee_id = null)
	{
		$CI =& get_instance();
		$CI->load->database();

		// Build the query string
		$sql = "SELECT me.*, mjt.name as designation_name, md.name as department_name 
				FROM master_employee me 
				LEFT JOIN master_department as md ON me.department = md.id 
				LEFT JOIN master_job_title as mjt ON me.designation = mjt.id 
				WHERE me.status = 'active' 
				AND (me.designation = ?";

		$params = [$role];

		// If employee_id is passed, include it in the condition
		if ($employee_id !== null) {
			$sql .= " OR me.id = ?";
			$params[] = $employee_id;
		}

		$sql .= ") ORDER BY me.full_name ASC";

		$query = $CI->db->query($sql, $params)->result();
		return $query;
	}
}

if (!function_exists('allEmployeeListHelper')) {
    function allEmployeeListHelper($keyword)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->select('id, emp_no, full_name');
        $CI->db->from('master_employee me');

        $CI->db->group_start()
               ->like('me.emp_no', $keyword)
               ->or_like('me.full_name', $keyword)
               ->group_end();

        $items = $CI->db->get()->result();
        return $items;
    }
}

if (!function_exists('riderSearchListHelper')) {
    function riderSearchListHelper($keyword)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->select('id, emp_no, full_name');
        $CI->db->from('master_employee me');
        $CI->db->where_in('me.designation', [3, 18]); // ÃƒÂ¢Ã…â€œÃ¢â‚¬Â¦ designation filter

        $CI->db->group_start()
               ->like('me.emp_no', $keyword)
               ->or_like('me.full_name', $keyword)
               ->group_end();

        $items = $CI->db->get()->result();
        return $items;
    }
}

if (!function_exists('teamLeaderListHelper')) {
    function teamLeaderListHelper($keyword)
    {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->select('team_leader, tl.id, tl.emp_no, tl.full_name');
        $CI->db->from('hunger_team ht');
		$CI->db->join('master_employee tl', 'ht.team_leader = tl.id', 'left');

        $CI->db->group_start()
               ->like('tl.emp_no', $keyword)
               ->or_like('tl.full_name', $keyword)
               ->group_end();

        $items = $CI->db->get()->result();
        return $items;
    }
}

if( ! function_exists('professionDetailHelper')){
	function professionDetailHelper($id = null)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_profession WHERE id = ? ORDER BY profession_name ASC", [$id])->row();
		return $query;
	}
}

if( ! function_exists('employeeDetailHelper')){
	function employeeDetailHelper($id, $status = 'Active')
	{
		$CI =& get_instance();
		$CI->load->database();

		$sql = "
			SELECT 
				me.*, 
				mei.gosi_id, 
				mei.qiwa_contract_no, 
				mjt.name as designation_name, 
				md.name as department_name 
			FROM master_employee me 
			LEFT JOIN master_department as md ON (me.department = md.id) 
			LEFT JOIN master_employee_info as mei ON (me.id = mei.employee_id) 
			LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) 
			WHERE me.id = ?
		";

		$params = [$id];

		// Status condition handling
		if ($status !== 'all') {
			$sql .= " AND me.status = ?";
			$params[] = $status;
		}

		$query = $CI->db->query($sql, $params)->row();
		return $query;
	}
}

if( ! function_exists('searchEmployeeHelper')){
	function searchEmployeeHelper($emp_no, $status = null)
	{
		$CI =& get_instance();
       	$CI->load->database();
		
		// Base Query
		$sql = "SELECT 
					me.id, me.emp_no, me.full_name, me.employee_arabic_name, 
					me.iqama_no, me.passport_no, me.passport_issue_country, me.status, 
					me.nationality, me.employee_pic, me.mobile, me.work_joining_date, 
					me.last_working_date, me.sponsor_id, me.payment_type, me.payment_type_detail,
					mjt.name as designation_name, me.basic_salary, me.food_allowance, 
					me.transport_allowance, me.total_package, me.housing_allowance, 
					mjt.arabic_name as designation_arabic_name, 
					md.name as department_name, md.name_ar as department_arabic_name, 
					mn.name as nationality_name, mn.arabic_name as nationality_name_arabic, 
					mc.name as passport_country_name, mc.arabic_name as passport_country_arabic, 
					sponsors.employer_name as sponsor_name, 
					sponsors.employer_arabic_name as sponsor_arabic_name 
				FROM master_employee me 
				LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) 
				LEFT JOIN master_country as mc ON (me.passport_issue_country = mc.id) 
				LEFT JOIN master_department as md ON (me.department = md.id) 
				LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) 
				LEFT JOIN sponsors as sponsors ON (me.sponsor_id = sponsors.id) 
				WHERE me.emp_no = ?";

		// status filter
		if ($status === null) {
			// default only active
			$sql .= " AND me.status = 'Active'";
		} elseif ($status !== 'all') {
			// any specific status
			$sql .= " AND me.status = " . $CI->db->escape($status);
		}
		// if $status = 'all' ÃƒÂ¢Ã¢â‚¬Â Ã¢â‚¬â„¢ no filter applied

		$query = $CI->db->query($sql, [$emp_no]);

		if($query->num_rows() > 0){
			$data['emp_detail'] = $query->row_array();
			$emp_id = $data['emp_detail']['id'];

			$data['other_detail'] = $CI->db->query("
				SELECT driving_license_number, driving_license_issue_date, gosi_id, qiwa_contract_no 
				FROM master_employee_info 
				WHERE employee_id = ?", [(int)$emp_id])->row_array();

			$data['vehicle_detail'] = $CI->db->select('mv.id,mv.vehicle_type,mv.vehicle_no,mv.vehicle_year,mv.vehicle_make,mv.vehicle_model,mv.gps_device_serial,mv.gasoline_chip_status,mv.chassis_no,mv.sequel_no,mv.vehicle_ownership,mv.owner_name_select,evs.emp_id,evs.shift_key,evs.effective_date,evs.status,mvk.make_name,mc.color_name')->from('employee_vehicle_shift evs')->join('master_vehicles mv','mv.id = evs.vehicle_id')->join('mater_van_make mvk','mvk.id = mv.vehicle_make','left')->join('master_color mc','mc.id = mv.vehicle_color','left')->where('evs.emp_id',(int)$emp_id)->order_by('evs.effective_date','DESC')->limit(1)->get()->row_array();

			$data['sim_detail'] = $CI->db->query("
				SELECT mobile, sim_no, sim_type, alloted_user, status 
				FROM sim_card 
				WHERE alloted_user = ?", [(int)$emp_id])->row_array();

			$data['status'] = true;
		}else{
			$data['status'] = false;
		}

		return $data;
	}
}

if (!function_exists('masterDesignation')) {
    function masterDesignation($department_id)
    {
        $CI =& get_instance();
        $CI->load->database();

        if ($department_id > 0) {
            // Escape the department_id and convert it to a string
            $escaped_department_id = $CI->db->escape($department_id);

            // Use JSON_CONTAINS to search within the JSON array
            $query = $CI->db->query("
                SELECT * 
                FROM master_job_title 
                WHERE JSON_CONTAINS(department_id, ?) 
                ORDER BY name ASC
            ", array('"' . $department_id . '"'))->result(); // Wrap the department_id in double quotes
        } else {
            $query = [];
        }

        return $query;
    }
}

if( ! function_exists('allDesignation')){
	function allDesignation()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_job_title ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterDepartments')){
	function masterDepartments()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_department ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('departmentsDetailHelper')){
	function departmentsDetailHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_department WHERE id='". $id ."'")->row();
		return $query;
	}
}

if( ! function_exists('masterVehicleHelper')){
	function masterVehicleHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_vehicles ORDER BY vehicle_no ASC")->result();
		return $query;
	}
}

if( ! function_exists('vehicleDetailHelper')){
	function vehicleDetailHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT master_vehicles.*, mater_van_make.make_name FROM master_vehicles LEFT JOIN mater_van_make ON (master_vehicles.vehicle_make = mater_van_make.id) WHERE master_vehicles.id='". $id ."' ORDER BY master_vehicles.vehicle_no ASC")->row();
		return $query;
	}
}

if (!function_exists('vehicleSearchHelper')) {
	function vehicleSearchHelper($search)
	{
		$CI =& get_instance();
	   	$CI->load->database();
		
		$CI->db->like('vehicle_no', $search);
		$CI->db->or_like('vehicle_model', $search);
		$CI->db->where('status !=', 'discontinued'); // fixed typo

		$query = $CI->db->get('master_vehicles');
		$result = $query->result();

		$response = [];
		foreach ($result as $row) {
			$response[] = [
				'id' => $row->id,
				'vehicle_no' => $row->vehicle_no,
				'vehicle_model' => $row->vehicle_model,
				'vehicle_type' => $row->vehicle_type,
			];
		}

		return $response; // ÃƒÂ¢Ã…â€œÃ¢â‚¬Â¦ Return instead of echo
	}
}

if( ! function_exists('taxHelper')){
	function taxHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM tax_settings ORDER BY id ASC")->result();
		return $query;
	}
}

if( ! function_exists('simListHelper')){
	function simListHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM sim_card ORDER BY owner_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('unallotedSimHelper')){
	function unallotedSimHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM sim_card WHERE (allotment = '0' OR allotment = '2')  AND (status = '0' OR status = '5') ORDER BY owner_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('simDetailHelper')){
	function simDetailHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT sim_card.*, master_plans.plan_name, master_network.network_name FROM sim_card LEFT JOIN master_network ON (sim_card.network = master_network.id) LEFT JOIN master_plans ON (sim_card.plan = master_plans.id) WHERE sim_card.id='". $id ."'")->row();
		return $query;
	}
}

if( ! function_exists('userSimHelper')){
	function userSimHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT sim_card.*, master_plans.plan_name, master_network.network_name FROM sim_card LEFT JOIN master_network ON (sim_card.network = master_network.id) LEFT JOIN master_plans ON (sim_card.plan = master_plans.id) WHERE alloted_user='". $id ."'")->row();
		return $query;
	}
}

if( ! function_exists('corporateAllotedSimsHelper')){
	function corporateAllotedSimsHelper($emp_id)
	{
		if($emp_id !== ''){
			$CI =& get_instance();
			$CI->load->database();
			$query = $CI->db->query("SELECT sim_card.*, master_plans.plan_name, master_network.network_name FROM sim_card LEFT JOIN master_network ON (sim_card.network = master_network.id) LEFT JOIN master_plans ON (sim_card.plan = master_plans.id) WHERE sim_card.alloted_user='". $emp_id ."' AND sim_card.status ='1' AND sim_card.ownership_type ='corporate'");
			return $query->result_array();
		}else{
			return false;
		}
	}
}

if( ! function_exists('simNetworkHelper')){
	function simNetworkHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_network WHERE id='". $id ."'")->row();
		return $query;
	}
}

if( ! function_exists('simPlanHelper')){
	function simPlanHelper($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_plans WHERE id='". $id ."'")->row();
		return $query;
	}
}

if (!function_exists('vendorsListHelper')) {
    function vendorsListHelper($vendor_type = null) {
        $CI =& get_instance();
        $CI->load->database();

        $CI->db->select('id, vendor_name, vendor_type');
        $CI->db->from('vendors');

        // Check if vendor_type is provided and not empty
        if (!empty($vendor_type)) {
            $CI->db->where('vendor_type', strtolower($vendor_type));
        }

        $CI->db->order_by('vendor_name', 'ASC');
        return $CI->db->get()->result();
    }
}

if( ! function_exists('saddadListHelper')){
	function saddadListHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT id,vendor_name FROM vendors WHERE vendor_type = 'saddad' ORDER BY vendor_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('fdCompanyHelper')){
	function fdCompanyHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM food_deliv_companies WHERE status = 'active' AND deleted = '0' ORDER BY company_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('blockReasonsHelper')){
	function blockReasonsHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_block_reasons WHERE status = '1' ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('docReasonsHelper')){
	function docReasonsHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_doc_reasons WHERE status = '1' ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('payMethodsHelper')){
	function payMethodsHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM payment_methods WHERE status = 'active' ORDER BY sort_order ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterNetworkHelper')){
	function masterNetworkHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_network WHERE status = '1' ORDER BY network_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('agencyListHelper')){
	function agencyListHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM hiring_agencies ORDER BY agency_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('agencyCountrywiseHelper')){
	function agencyCountrywiseHelper($country_id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM hiring_agencies WHERE country_id = '". $country_id ."' ORDER BY agency_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('old_value')){
	function old_value($post_value, $default)
	{
		$CI =& get_instance();
		$post_data = $CI->session->userdata('post_input');
		if(count($post_data) > 0){
			$old_value = $post_data[$post_value];
		}elseif (!empty($default)) {
			$old_value = $default;
		}else{
			$old_value = '';
		}
		return $old_value;
	}
}


if( ! function_exists('insuCompanyHelper')){
	function insuCompanyHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_insurance_company ORDER BY company_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('insuTypeHelper')){
	function insuTypeHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_insurance_type ORDER BY insurance_type ASC")->result();
		return $query;
	}
}

if( ! function_exists('empPolicyList')){
	function empPolicyList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_insurance_policies WHERE policy_type = 'Employee' AND status = 'Valid' ORDER BY policy_number ASC")->result();
		return $query;
	}
}

if( ! function_exists('vehiclePolicyList')){
	function vehiclePolicyList()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_insurance_policies WHERE policy_type = 'Vehicles' AND status = 'Valid' ORDER BY policy_number ASC")->result();
		return $query;
	}
}

if( ! function_exists('remunerationHelper')){
	function remunerationHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_remuneration ORDER BY remuneration_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('employmentTypesHelper')){
	function employmentTypesHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM employment_types ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('employeLevelHelper')){
	function employeLevelHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM employee_levels ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('branchHelper')){
	function branchHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_branch ORDER BY branch_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('nationalityArabic')){
	function nationalityArabic($name)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT arabic_name FROM master_nationality WHERE name = '". $name ."'");
		if($query->num_rows() > 0){
			$nationality = $query->row()->arabic_name;
		}else{
			$nationality = 'NA';
		}
		return $nationality;
	}
}

if( ! function_exists('designationInfo')){
	function designationInfo($id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT name, arabic_name FROM master_job_title WHERE id = '". $id ."'");
		if($query->num_rows() > 0){
			$nationality = $query->row();
		}else{
			$nationality = 'NA';
		}
		return $nationality;
	}
}

/*---- Employee -----*/
if( ! function_exists('majorEduHelper')){
	function majorEduHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM major_main_stream ORDER BY stream_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('degreeEduHelper')){
	function degreeEduHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_edu ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('gradeEduHelper')){
	function gradeEduHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_grade ORDER BY grade_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('gradeEduHelper')){
	function gradeEduHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_grade ORDER BY grade_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('allBusinessUnitHelper')){
	function allBusinessUnitHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_business_unit ORDER BY business_unit_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('businessUnitHelper')){
	function businessUnitHelper($department_id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		   if($department_id > 0){
			$query = $CI->db->query("SELECT * FROM master_business_unit WHERE department_id = '". $department_id ."' ORDER BY business_unit_name ASC")->result();
		}else{
			$query = '';
		}
		return $query;
	}
}

if( ! function_exists('employmentTypeHelper')){
	function employmentTypeHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM employment_types ORDER BY name ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterLocationHelper')){
	function masterLocationHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_location ORDER BY location_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterParkingHelper')){
	function masterParkingHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_parkings ORDER BY parking_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterCampHelper')){
	function masterCampHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_camp ORDER BY camp_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterRoomHelper')){
	function masterRoomHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT mr.*, mc.id as mcamp_id, mc.camp_name FROM master_rooms mr LEFT JOIN master_camp mc ON (mr.camp_id = mc.id) ORDER BY mr.room_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('selectedRoomHelper')){
	function selectedRoomHelper($camp_id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_rooms WHERE camp_id = '". $camp_id ."' ORDER BY room_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterBedHelper')){
	function masterBedHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT master_bed.*, master_rooms.room_name FROM master_bed LEFT JOIN master_rooms ON (master_bed.room_id = master_rooms.id) ORDER BY master_bed.bed_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('selectedBedHelper')){
	function selectedBedHelper($room_id)
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_bed WHERE room_id = '". $room_id ."' ORDER BY bed_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('contractStatusHelper')){
	function contractStatusHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_contract_status ORDER BY status_type ASC")->result();
		return $query;
	}
}

if( ! function_exists('licenceTypeHelper')){
	function licenceTypeHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_licence_type ORDER BY licence_type ASC")->result();
		return $query;
	}
}

if( ! function_exists('QiwaStatusHelper')){
	function QiwaStatusHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_qiwa_status ORDER BY qiwa_status_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('FileTypesHelper')){
	function FileTypesHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_file_types where deleted='0' ORDER BY sort_order ASC")->result();
		return $query;
	}
}

if( ! function_exists('TransTypesHelper')){
	function TransTypesHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_transaction_types ORDER BY transaction_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('incentiveListHelper')){
	function incentiveListHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM incentives WHERE status='active' ORDER BY incentive_name ASC")->result();
		return $query;
	}
}

if( ! function_exists('cashReasonsHelper')){
	function cashReasonsHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM master_cash_reasons WHERE deleted='0' ORDER BY reason_title_en ASC")->result();
		return $query;
	}
}

if( ! function_exists('masterReasons')){
    function masterReasons($orderType)
    {
        $CI =& get_instance();
        $CI->load->database();

        return $CI->db->where('reason_type', $orderType)
                      ->order_by('reason_title_en', 'ASC')
                      ->get('master_reasons')
                      ->result();
    }
}

if( ! function_exists('sponsorsHelper')){
	function sponsorsHelper()
	{
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM sponsors ORDER BY employer_name ASC")->result_array();
		return $query;
	}
}

if( ! function_exists('decimalToHours')){
	function decimalToHours($decimalHours) {
		$hours = floor($decimalHours);
		$minutes = round(($decimalHours - $hours) * 60);
		return sprintf("%02d:%02d", $hours, $minutes);
	}
}

if (!function_exists('departmentHeadsHelper')) {
    function departmentHeadsHelper()
    {
        $CI =& get_instance();
        $CI->load->database();

        return $CI->db->select('dh.id, dh.emp_no, dh.full_name')
            ->from('master_employee e')
            ->join('master_employee dh', 'e.department_head = dh.id', 'inner')
            ->where('e.department_head IS NOT NULL')
            ->where('e.department_head !=', '')
            ->group_by('dh.id')
            ->get()
            ->result_array();
    }
}

if (!function_exists('lineManagerHelper')) {
    function lineManagerHelper()
    {
        $CI =& get_instance();
        $CI->load->database();

        return $CI->db->select('lm.id, lm.emp_no, lm.full_name')
            ->from('master_employee e')
            ->join('master_employee lm', 'e.work_line_manager = lm.id', 'inner')
            ->where('e.work_line_manager IS NOT NULL')
            ->where('e.work_line_manager !=', '')
            ->group_by('lm.id')
            ->get()
            ->result_array();
    }
}

if (!function_exists('getRiderInfoForDayHelper')) {

    function getRiderInfoForDayHelper($id_number, $summary_date)
    {
        $CI =& get_instance();

        $result = [
            'emp_id'     => 0,
            'vehicle_id' => 0,
            'team_id'    => 0
        ];

        $summary_date = date('Y-m-d', strtotime($summary_date));

        /**
         * STEP 1: Get emp_id from rider table
         * (ID number ÃƒÂ¢Ã¢â‚¬Â Ã¢â‚¬â„¢ employee is stable)
         */
        $rider = $CI->db->select('employee_id')
            ->from('logistic_rider')
            ->where('id_number', $id_number)
            ->get()
            ->row();

        if (!$rider || !$rider->employee_id) {
            return $result;
        }

        $emp_id = (int) $rider->employee_id;
        $result['emp_id'] = $emp_id;

        /**
         * STEP 2: Get vehicle allotment for that day
         * Source of truth: employee_vehicle_shift
         */
        $allotment = $CI->db->select('vehicle_id, status')
            ->from('employee_vehicle_shift')
            ->where('emp_id', $emp_id)
            ->where('effective_date <=', $summary_date)
            ->order_by('effective_date', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if ($allotment && strtolower($allotment->status) === 'allotted') {
            $result['vehicle_id'] = (int) $allotment->vehicle_id;
        }

        /**
         * STEP 3: Get team_id
         */
        $pattern = '"' . $emp_id . '"';

        $team = $CI->db->select('ht.id AS team_id')
            ->from('hunger_team ht')
            ->where(
                "JSON_CONTAINS(ht.team, " . $CI->db->escape($pattern) . ")",
                null,
                false
            )
            ->order_by('ht.id', 'ASC')
            ->limit(1)
            ->get()
            ->row();

        $result['team_id'] = $team->team_id ?? 0;

        return $result;
    }
}

if (!function_exists('getVehicleEmpInfoForDayHelper')) {

    function getVehicleEmpInfoForDayHelper($vehicle_no, $fuel_date)
    {
        $CI =& get_instance();

        $result = [
            'emp_id'           => 0,
            'vehicle_id'       => 0,
            'team_id'          => 0,
            'allotment_status' => null,
        ];

        $fuel_date = date('Y-m-d', strtotime($fuel_date));

        /**
         * STEP 1: Get vehicle_id
         */
        $vehicle = $CI->db->select('id')
            ->from('master_vehicles')
            ->where('vehicle_no', $vehicle_no)
            ->get()
            ->row();

        if (!$vehicle) {
            return $result;
        }

        $vehicle_id = (int) $vehicle->id;
        $result['vehicle_id'] = $vehicle_id;

        /**
         * STEP 2: HISTORICAL CHECK (vehicle_log)
         * This is mandatory because emp_vehicle_shift rows are deleted
         */
        $log = $CI->db->select('rider_id, log_status')
            ->from('vehicle_log')
            ->where('vehicle_id', $vehicle_id)
            ->where('status_date <=', $fuel_date . ' 23:59:59')
            ->order_by('status_date', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if ($log) {

            $result['allotment_status'] = $log->log_status;

            if (strtolower($log->log_status) === 'alloted') {
                $result['emp_id'] = (int) $log->rider_id;
            }

        } else {

            /**
             * STEP 3: FALLBACK TO CURRENT STATE
             * emp_vehicle_shift has ONLY current active records
             */
            $current = $CI->db->select('emp_id, status')
                ->from('emp_vehicle_shift')
                ->where('vehicle_id', $vehicle_id)
                ->limit(1)
                ->get()
                ->row();

            if ($current) {
                $result['allotment_status'] = $current->status;

                if (strtolower($current->status) === 'alloted') {
                    $result['emp_id'] = (int) $current->emp_id;
                }
            }
        }

        /**
         * STEP 4: Find team_id (JSON based)
         */
        if ($result['emp_id'] > 0) {

            $pattern = '"' . $result['emp_id'] . '"';

            $team = $CI->db->select('ht.id AS team_id')
                ->from('hunger_team ht')
                ->where(
                    "JSON_CONTAINS(ht.team, " . $CI->db->escape($pattern) . ")",
                    null,
                    false
                )
                ->order_by('ht.id', 'ASC')
                ->limit(1)
                ->get()
                ->row();

            $result['team_id'] = $team->team_id ?? 0;
        }

        return $result;
    }
}


function Greg2Hijri($date) {
    //$date = "2023-04-08";
    $hijriDate = Dcter::GregorianToHijri($date);
    echo $hijriDate; // returns 1444-09-17
}

function ReturnGreg2Hijri($date) {
    //$date = "2023-04-08";
    $hijriDate = Dcter::GregorianToHijri($date);
    return $hijriDate; // returns 1444-09-17
}

function ReturnHijri2Greg($hijriDate) {
    //$hijriDate = "1444-09-17";
    $gregorianDate = Dcter::HijriToGregorian($hijriDate);
    return $gregorianDate; // e.g., returns 2023-04-08
}

function convert_number_to_words($number) {
    $words = [
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
    ];

    if ($number <= 20) {
        return $words[$number];
    }

    if ($number < 100) {
        $tens = floor($number / 10) * 10;
        $units = $number % 10;
        return $units > 0 ? $words[$tens] . ' ' . $words[$units] : $words[$tens];
    }

    if ($number < 1000) {
        $hundreds = floor($number / 100);
        $remainder = $number % 100;
        return $remainder > 0
            ? $words[$hundreds] . ' Hundred ' . convert_number_to_words($remainder)
            : $words[$hundreds] . ' Hundred';
    }

    // Add support for larger numbers (thousands, millions, etc.)
    $levels = ['', 'Thousand', 'Million', 'Billion'];
    $level = 0;
    $output = '';

    while ($number > 0) {
        $chunk = $number % 1000;
        if ($chunk > 0) {
            $output = convert_number_to_words($chunk) . ' ' . $levels[$level] . ' ' . $output;
        }
        $number = floor($number / 1000);
        $level++;
    }

    return trim($output);
}

function convert_sar_to_words($amount) {
    // Split the amount into whole and decimal parts
    $whole_part = floor($amount);
    $decimal_part = round(($amount - $whole_part) * 100);

    // Convert the whole part to words
    $whole_in_words = convert_number_to_words($whole_part);

    // Convert the decimal part (cents or Hala) to words
    if ($decimal_part > 0) {
        $decimal_in_words = convert_number_to_words($decimal_part);
        return $whole_in_words . ' Saudi Riyals and ' . $decimal_in_words . ' Halala';
    }

    return $whole_in_words . ' Saudi Riyals';
}

if (!function_exists('formatVehiclePlate')) {
	function formatVehiclePlate($plate)
	{
		$plate = strtoupper(trim((string) $plate));
		preg_match('/(\d+)\s*([A-Z]+)/', $plate, $match);

		if (empty($match[1]) || empty($match[2])) {
			return htmlspecialchars($plate, ENT_QUOTES, 'UTF-8');
		}

		$num_eng = $match[1];
		$let_eng = $match[2];

		// Keep entities ASCII-safe so display is stable even if file encoding changes.
		$arabic_digits = [
			'0' => '&#1632;', '1' => '&#1633;', '2' => '&#1634;', '3' => '&#1635;', '4' => '&#1636;',
			'5' => '&#1637;', '6' => '&#1638;', '7' => '&#1639;', '8' => '&#1640;', '9' => '&#1641;'
		];
		$num_ar = strtr($num_eng, $arabic_digits);

		$arabic_letters = [
			'A' => '&#1575;',
			'B' => '&#1576;',
			'C' => '&#1580;',
			'D' => '&#1583;',
			'E' => '&#1607;',
			'F' => '&#1601;',
			'G' => '&#1602;',
			'H' => '&#1581;',
			'I' => '&#1591;',
			'J' => '&#1610;',
			'K' => '&#1603;',
			'L' => '&#1604;',
			'M' => '&#1605;',
			'N' => '&#1606;',
			'O' => '&#1608;',
			'P' => '&#1587;',
			'Q' => '&#1589;',
			'R' => '&#1585;',
			'S' => '&#1588;',
			'T' => '&#1578;',
			'U' => '&#1593;',
			'V' => '&#1579;',
			'W' => '&#1582;',
			'X' => '&#1584;',
			'Y' => '&#1590;',
			'Z' => '&#1592;'
		];

		$let_ar_parts = [];
		foreach (str_split($let_eng) as $ch) {
			$let_ar_parts[] = $arabic_letters[$ch] ?? htmlspecialchars($ch, ENT_QUOTES, 'UTF-8');
		}
		$let_ar = implode(' ', $let_ar_parts);

		// Keep each HTML entity token separated to match plate styling.
		$num_ar_spaced  = implode(' ', preg_split('/\s+/', trim($num_ar)));
		$num_eng_spaced = implode(' ', str_split($num_eng));
		$let_eng_spaced = implode(' ', str_split($let_eng));

		// Saudi plate styling (compact)
		return "
		<div class='saudi-plate'>
			<div class='plate-row ar'>{$num_ar_spaced}</div>
			<div class='plate-row ar'>{$let_ar}</div>
			<div class='plate-row en'>{$num_eng_spaced}</div>
			<div class='plate-row en'>{$let_eng_spaced}</div>
		</div>
		";
	}
}


/*---- Shift Management ----*/
/**
 * Return all available shifts
 */
if (!function_exists('get_shifts')) {
    function get_shifts()
    {
        $CI = &get_instance();

        $rows = $CI->db
            ->select('shift_key, name, start_time, end_time')
            ->from('hunger_shift_master')
            ->where('status', '1')
            ->order_by('id', 'ASC')
            ->get()
            ->result_array();

        $shifts = [];
        foreach ($rows as $row) {
            $shifts[$row['shift_key']] = [
                'key'   => $row['shift_key'],
                'name'  => $row['name'],
                'start' => substr($row['start_time'], 0, 5),
                'end'   => substr($row['end_time'], 0, 5),
            ];
        }

        return $shifts;
    }
}

/**
 * Get single shift by key
 */
if (!function_exists('get_shift')) {
    function get_shift($shiftKey)
    {
        $shifts = get_shifts();
        return $shifts[$shiftKey] ?? null;
    }
}

/**
 * Check if a given time falls inside a shift
 * 
 * @param string $shiftKey
 * @param string $time (H:i or H:i:s)
 */
if (!function_exists('is_time_in_shift')) {
    function is_time_in_shift($shiftKey, $time)
    {
        $shift = get_shift($shiftKey);
        if (!$shift) {
            return false;
        }

        $time  = strtotime($time);
        $start = strtotime($shift['start']);
        $end   = strtotime($shift['end']);

        return ($time >= $start && $time <= $end);
    }
}

if (!function_exists('normalize_excel_date')) {

    function normalize_excel_date($value)
    {
        if (empty($value)) {
            return null;
        }

        // Trim spaces
        $value = trim($value);

        
        if (is_numeric($value)) {
            try {
                return date('Y-m-d', ExcelDate::excelToTimestamp($value));
            } catch (Exception $e) {
                return null;
            }
        }

        
        $value = str_replace('/', '-', $value);

        
        $formats = [
            'd-m-Y',
            'Y-m-d',
            'd-m-y',
            'Y-m-d H:i:s',
        ];

        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $value);
            if ($date && $date->format($format) === $value) {
                return $date->format('Y-m-d');
            }
        }

        
        $timestamp = strtotime($value);
        if ($timestamp !== false) {
            return date('Y-m-d', $timestamp);
        }

        
        return null;
    }
}
