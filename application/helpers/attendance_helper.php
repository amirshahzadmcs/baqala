<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('getAddtendaceShift')){
	function getAddtendaceShift(){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM shifts ORDER BY name ASC");
		return $query->result_array();
	}
}

if( ! function_exists('getLeavePolicy')){
	function getLeavePolicy(){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM leave_policies ORDER BY name ASC");
		return $query->result_array();
	}
}

if( ! function_exists('getHolidayList')){
	function getHolidayList(){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM holiday_list ORDER BY group_title ASC");
		return $query->result_array();
	}
}

if( ! function_exists('getAttendanceRestriction')){
	function getAttendanceRestriction(){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM attendance_restrictions ORDER BY name ASC");
		return $query->result_array();
	}
}
