<?php defined('BASEPATH') or exit('No direct script access allowed');

class HrFilters extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
		} else {
			redirect('admin/common/login');
		}
	}

	public function nationality_list()
	{
		$nationalities = nationalityList();
		$options = array_map(function($row) {
			return [
				'label' => $row->name,
				'value' => $row->id
			];
		}, $nationalities);

		echo json_encode($options);
	}

	public function get_designations() {
		$data = array_map(function($d) {
			return ['label' => $d->name, 'value' => $d->id];
		}, allDesignation());
		echo json_encode($data);
	}

	public function get_departments() {
		$data = array_map(function($d) {
			return ['label' => $d->name, 'value' => $d->id];
		}, masterDepartments());
		echo json_encode($data);
	}

	public function get_employers() {
		$data = array_map(function($e) {
			return ['label' => $e['employer_name'], 'value' => $e['id']];
		}, sponsorsHelper());
		echo json_encode($data);
	}

	public function get_camps() {
		$data = array_map(function($e) {
			return ['label' => $e->camp_name, 'value' => $e->id];
		}, masterCampHelper());
		echo json_encode($data);
	}

	public function get_rooms() {
		$data = array_map(function($e) {
			return ['label' => $e->camp_name .' - '. $e->room_name, 'value' => $e->id];
		}, masterRoomHelper());
		echo json_encode($data);
	}

	public function get_beds() {
		$data = array_map(function($e) {
			return ['label' => $e->room_name .' - '. $e->bed_name, 'value' => $e->id];
		}, masterBedHelper());
		echo json_encode($data);
	}

	public function get_department_heads() {
		$data = array_map(function($e) {
			return ['label' => $e['emp_no'] .' - '. $e['full_name'], 'value' => $e['id']];
		}, departmentHeadsHelper());
		echo json_encode($data);
	}

	public function get_line_managers() {
		$data = array_map(function($e) {
			return ['label' => $e['emp_no'] .' - '. $e['full_name'], 'value' => $e['id']];
		}, lineManagerHelper());
		echo json_encode($data);
	}

	public function get_employment_types() {
		$data = array_map(function($e) {
			return ['label' => $e->name, 'value' => $e->id];
		}, employmentTypeHelper());
		echo json_encode($data);
	}

	public function get_cities() {
		$data = array_map(function($e) {
			return ['label' => $e->city_name .' - '. $e->country_name, 'value' => $e->id];
		}, getCities());
		echo json_encode($data);
	}

	public function get_countries() {
		$data = array_map(function($e) {
			return ['label' => $e->name, 'value' => $e->id];
		}, masterCountries());
		echo json_encode($data);
	}

	public function get_status() {
		echo json_encode([
			['label' => 'Active', 'value' => 'Active'],
			['label' => 'Terminated', 'value' => 'Terminated']
		]);
	}
	
	public function get_work_location() {
		$data = array_map(function($e) {
			return ['label' => $e->location_name, 'value' => $e->id];
		}, masterLocationHelper());
		echo json_encode($data);
	}

	public function get_genders() {
		echo json_encode([
			['label' => 'Male', 'value' => 'male'],
			['label' => 'female', 'value' => 'Female'],
			['label' => 'other', 'value' => 'Other']
		]);
	}

	public function get_marital_status() {
		echo json_encode([
			['label' => 'Single', 'value' => 'Single'],
			['label' => 'Married', 'value' => 'Married'],
			['label' => 'Divorced', 'value' => 'Divorced'],
			['label' => 'Widow', 'value' => 'Widow']
		]);
	}

	public function get_iqama_status() {
		echo json_encode([
			['label' => 'Active', 'value' => 'active'],
			['label' => 'Expired', 'value' => 'expired']
		]);
	}

	public function get_religions() {
		echo json_encode([
			['label' => 'Muslim', 'value' => 'Muslim'],
			['label' => 'Non Muslim', 'value' => 'Non Muslim']
		]);
	}

	public function get_terminate_reasons()
	{
		echo json_encode([
			['label' => 'Final Exit - Attendance No Show', 'value' => 'Final Exit - Attendance No Show'],
			['label' => 'Final Exit - Contract Completed', 'value' => 'Final Exit - Contract Completed'],
			['label' => 'Final Exit - Refusal to Work', 'value' => 'Final Exit - Refusal to Work'],
			['label' => 'Final Exit - Resigned', 'value' => 'Final Exit - Resigned'],
			['label' => 'Resigned - Final Exit', 'value' => 'Resigned - Final Exit'],
			['label' => 'Resigned - Local Transferred', 'value' => 'Resigned - Local Transferred'],
			['label' => 'Terminated - Absconded', 'value' => 'Terminated - Absconded'],
			['label' => 'Terminated - Drop Off', 'value' => 'Terminated - Drop Off'],
			['label' => 'Terminated - Management', 'value' => 'Terminated - Management'],
			['label' => 'Terminated - Refusal to Work', 'value' => 'Terminated - Refusal to Work'],
		]);
	}

}