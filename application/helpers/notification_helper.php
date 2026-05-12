<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('employeeIqamaExpNoti')){
	function employeeIqamaExpNoti(){
		$CI =& get_instance();
       	$CI->load->database();
		$today = date("Y-m-d");
		$query = $CI->db->query("SELECT me.*, DATEDIFF(me.iqama_exp,NOW()) as remaining_days, CONCAT_WS(' ', me.first_name, me.middle_name, me.third_name, me.surname) full_name, mjt.name as designation_name, md.name as department_name FROM master_employee me LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE me.iqama_exp < DATE(NOW() + INTERVAL 30 DAY) ORDER BY me.iqama_exp ASC")->result_array();
		return $query;
	}
}
