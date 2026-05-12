<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('getJournalAccount')){
	function getJournalAccount($pid){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT ja.*, ca.branch_name FROM journal_attrebuit ja LEFT JOIN chart_of_accounts ca ON (ja.journal_account_id = ca.branch_id) WHERE ja.journal_id='". $pid ."' AND ja.deleted= '0' GROUP BY ja.journal_id");
		return $query->result_array();
	}
}
if( ! function_exists('getJournalEntries')){
	function getJournalEntries($journal_id){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT ja.*, ca.branch_name, ca.code FROM journal_attrebuit ja LEFT JOIN chart_of_accounts ca ON (ja.journal_account_id = ca.branch_id) WHERE ja.journal_id='". $journal_id ."' AND ja.deleted= '0'");
		return $query->result_array();
	}
}
if( ! function_exists('getCostCentDetail')){
	function getCostCentDetail($id){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM cost_center WHERE id='". $id ."'");
		return $query->row();
	}
}
if( ! function_exists('getJournalAccountLog')){
	function getJournalAccountLog($pid){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM journal_log WHERE entry_id='". $pid ."'  ");
		return $query->result_array();
	}
}
if( ! function_exists('getJournalentry')){
	function getJournalentry($entryid){
		$CI =& get_instance();
       	$CI->load->database();
		$query = $CI->db->query("SELECT * FROM journal_entry_master WHERE id='". $entryid ."'  ");
		return $query->row();
	}
}

