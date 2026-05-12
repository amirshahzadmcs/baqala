<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Collection_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('common_helper');
	}
	
	public function add($data) {
        // Insert data into the database
        $this->db->insert('cash_collection', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }

	public function update($id,$data) {
        // Update data into the database
		$this->db->where('id', $id);
        $this->db->update('cash_collection', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }
	
	public function add_log($data) {
        // Insert data into the database
        $this->db->insert('cash_collection_log', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	public function get_pending_cash_collection($emp_id)
	{
		$this->db->select("
			m.id,
			m.emp_id,
			m.driver_id,
			m.order_date,
			((m.cash_collection - m.driver_credit) - IFNULL(SUM(c.paid_amount), 0)) AS cash_collection,
			m.driver_credit,
			IFNULL(SUM(c.paid_amount), 0) AS total_paid,
			((m.cash_collection - m.driver_credit) - IFNULL(SUM(c.paid_amount), 0)) AS balance_due
		");
		$this->db->from('maha_jahez_daily_summary m');
		$this->db->join('cash_collection c', 'm.id = c.order_id', 'left');
		$this->db->where('m.emp_id', $emp_id);
		$this->db->where('m.order_date >=', '2025-10-01');
		$this->db->group_by(['m.id','m.order_date','m.cash_collection','m.driver_credit']);
		$this->db->having('balance_due >', 0);
		$this->db->order_by('m.order_date', 'DESC');

		$query = $this->db->get();
		return $query->result();
	}

	public function get_monthly_pending_cash_collections($start_date = null, $end_date = null, $employee_id = null, $team_leader_id = null, $driver_id = null)
	{
		$this->db->select("
			m.emp_id,
			m.driver_id,
			me.emp_no,
			me.full_name,
			DATE_FORMAT(m.order_date, '%Y-%m') AS month_year,
			SUM((m.cash_collection - m.driver_credit) - IFNULL(c.total_paid, 0)) AS total_pending,
			ht.team_leader,
			tl.emp_no AS team_leader_emp_no,
			tl.full_name AS team_leader_name
		");
		$this->db->from('maha_jahez_daily_summary m');
		$this->db->join('master_employee me', 'm.emp_id = me.id', 'left');

		// Join cash collection totals
		$this->db->join("
			(SELECT order_id, SUM(paid_amount) AS total_paid 
			FROM cash_collection 
			GROUP BY order_id
			) c", 'm.id = c.order_id', 'left');

		// Join hunger_team based on emp_id in JSON
		$this->db->join('hunger_team ht', "ht.team REGEXP CONCAT('\"', m.emp_id, '\"')", 'left');

		// Join team leader info
		$this->db->join('master_employee tl', 'ht.team_leader = tl.id', 'left');

		// ================= Filters =================
		if ($start_date && $end_date) {
			$this->db->where("m.order_date BETWEEN '".$start_date."' AND '".$end_date."'", NULL, FALSE);
		}
		if ($employee_id) {
			$this->db->where('m.emp_id', $employee_id);
		}
		if ($team_leader_id) {
			$this->db->where('tl.id', $team_leader_id); // Use team leader join for filter
		}
		if ($driver_id) {
			$this->db->where('m.driver_id', $driver_id);
		}

		// ================= Grouping & Having =================
		$this->db->group_by(['m.emp_id', 'month_year']);
		$this->db->having('total_pending !=', 0);

		// ================= Ordering =================
		$this->db->order_by('total_pending', 'DESC'); // highest pending first
		$this->db->order_by('month_year', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_pending_cash_collection_details_by_month($start_date = null, $end_date = null, $employee_id = null, $team_leader_id = null, $driver_id = null)
	{
		$this->db->select("
			m.emp_id,
			m.driver_id,
			me.emp_no,
			me.full_name,
			DATE(m.order_date) AS order_date,
			SUM((m.cash_collection - m.driver_credit) - IFNULL(c.total_paid, 0)) AS pending_amount
		");
		$this->db->from('maha_jahez_daily_summary m');
		$this->db->join('master_employee me', 'm.emp_id = me.id', 'left');

		// Join hunger_team based on emp_id existing in the 'team' field (JSON format)
		$this->db->join('hunger_team ht', "ht.team REGEXP CONCAT('\"', m.emp_id, '\"')", 'left');

		// Join with master_employee to get team leader name
		$this->db->join('master_employee tl', 'ht.team_leader = tl.id', 'left');

		// Join cash collection totals
		$this->db->join("
			(SELECT order_id, SUM(paid_amount) AS total_paid 
			FROM cash_collection 
			GROUP BY order_id
			) c", 'm.id = c.order_id', 'left');

		// ================= Filters =================
		if ($start_date && $end_date) {
			$this->db->where("m.order_date BETWEEN '".$start_date."' AND '".$end_date."'", NULL, FALSE);
		}
		if ($employee_id) {
			$this->db->where('m.emp_id', $employee_id);
		}
		if ($team_leader_id) {
			$this->db->where('tl.id', $team_leader_id); // ✅ Use tl.id for team leader filter
		}
		if ($driver_id) {
			$this->db->where('m.driver_id', $driver_id);
		}

		// ================= Grouping & Having =================
		$this->db->group_by(['m.emp_id', 'DATE(m.order_date)']);
		$this->db->having('pending_amount !=', 0);

		// ================= Ordering =================
		//$this->db->order_by('pending_amount', 'DESC');
		//$this->db->order_by('me.full_name', 'ASC');
		$this->db->order_by('order_date', 'DESC');

		$query = $this->db->get();
		return $query->result_array();
	}


	function make_query(){
		$a = "SELECT 
				er.id,
				er.employee_id,
				er.transaction_date,
				er.due_amount,
				er.paid_amount,
				er.balance_amount,
				er.created_at,
				er.updated_at,
				m.summary_date,
				m.driver_id,
				m.driver_credit,
				m.driver_debit,
				m.delivery_price,
				m.cash_collection,
				m.bonuses,
				m.tips,
				m.penalty,
				m.service_deduction,
				(m.cash_collection - m.driver_credit) AS total_amount,
				me.emp_no, 
				me.full_name, 
				me.iqama_no, 
				me.iqama_expiry_date, 
				me.nationality, 
				me.mobile, 
				me.passport_no, 
				me.designation, 
				me.sponsor_id,
				mjt.name AS designation_name, 
				md.name AS department_name, 
				mn.name AS nationality_name,
				added_admin.username AS added_by_username,
				added_admin.name AS added_by_name,
				updated_admin.username AS updated_by_username,
				updated_admin.name AS updated_by_name,
				(
					SELECT GROUP_CONCAT(ht.name) 
					FROM hunger_team ht 
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
				) AS team_name 
			FROM cash_collection er
			LEFT JOIN master_employee me ON er.employee_id = me.id
			LEFT JOIN maha_jahez_daily_summary m ON er.order_id = m.id
			LEFT JOIN master_department md ON me.department = md.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN master_nationality mn ON me.nationality = mn.id 
			LEFT JOIN admin AS added_admin ON er.added_by = added_admin.employee_id
			LEFT JOIN admin AS updated_admin ON er.updated_by = updated_admin.employee_id
			WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();

		// Keyword filter
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
			}
		}

		// Driver ID filter
		if($this->input->get('driver_id')) {
			$driver_id = $this->input->get('driver_id');
			if($driver_id != ''){
				$a .= " AND m.driver_id = '".$driver_id."'";
			}
		}

		// Date filter
		if($this->input->get('start_date') && $this->input->get('end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('end_date')));
			if($v_from && $v_to){
				$a .= " AND (er.transaction_date BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		// COD Date filter
		if($this->input->get('order_start_date') && $this->input->get('order_end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('order_start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('order_end_date')));
			if($v_from && $v_to){
				$a .= " AND (DATE(m.summary_date) BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		// Voucher filter
		if($this->input->get('voucher_no')) {
			$id_number = $this->input->get('voucher_no');
			if($id_number != ''){
				$a .= " AND er.transaction_id = '".$id_number."'";
			}
		}

		// Receipt reason filter
		if($this->input->get('receipt_reason')) {
			$receipt_reason = $this->input->get('receipt_reason');
			if($receipt_reason != ''){
				$a .= " AND er.receipt_reason = '".$receipt_reason."'";
			}
		}

		// Employer filter
		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
			if($employer != ''){
				$a .= " AND me.sponsor_id = '".$employer."'";
			}
		}

		// Team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					AND ht.name LIKE '%".$team."%'
				)";
			}
		}

		$a .= " ORDER BY er.transaction_date DESC";
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}

		$query = $this->db->query($a);
		return $query->result();
	}

	function get_filtered_data(){
		$a = $this->make_query();

		// Keyword filter
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
			}
		}

		// Driver ID filter
		if($this->input->get('driver_id')) {
			$driver_id = $this->input->get('driver_id');
			if($driver_id != ''){
				$a .= " AND m.driver_id = '".$driver_id."'";
			}
		}

		// Date filter
		if($this->input->get('start_date') && $this->input->get('end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('end_date')));
			if($v_from && $v_to){
				$a .= " AND (er.transaction_date BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		// COD Date filter
		if($this->input->get('order_start_date') && $this->input->get('order_end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('order_start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('order_end_date')));
			if($v_from && $v_to){
				$a .= " AND (DATE(m.summary_date) BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		// Voucher filter
		if($this->input->get('voucher_no')) {
			$id_number = $this->input->get('voucher_no');
			if($id_number != ''){
				$a .= " AND er.transaction_id = '".$id_number."'";
			}
		}

		// Receipt reason filter
		if($this->input->get('receipt_reason')) {
			$receipt_reason = $this->input->get('receipt_reason');
			if($receipt_reason != ''){
				$a .= " AND er.receipt_reason = '".$receipt_reason."'";
			}
		}

		// Employer filter
		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
			if($employer != ''){
				$a .= " AND me.sponsor_id = '".$employer."'";
			}
		}

		// Team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					AND ht.name LIKE '%".$team."%'
				)";
			}
		}

		$query = $this->db->query($a);
		return $query->num_rows();
	}
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('cash_collection');  
	   return $this->db->count_all_results();
    }

	function print_list(){
		$a = $this->make_query();
		// Keyword filter
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
			}
		}
		
		// Driver ID filter
		if($this->input->get('driver_id')) {
			$driver_id = $this->input->get('driver_id');
			if($driver_id != ''){
				$a .= " AND m.driver_id = '".$driver_id."'";
			}
		}

		// Date filter
		if($this->input->get('start_date') && $this->input->get('end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('end_date')));
			if($v_from && $v_to){
				$a .= " AND (er.transaction_date BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		// COD Date filter
		if($this->input->get('order_start_date') && $this->input->get('order_end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('order_start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('order_end_date')));
			if($v_from && $v_to){
				$a .= " AND (DATE(m.summary_date) BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		// Voucher filter
		if($this->input->get('voucher_no')) {
			$id_number = $this->input->get('voucher_no');
			if($id_number != ''){
				$a .= " AND er.transaction_id = '".$id_number."'";
			}
		}

		// Receipt reason filter
		if($this->input->get('receipt_reason')) {
			$receipt_reason = $this->input->get('receipt_reason');
			if($receipt_reason != ''){
				$a .= " AND er.receipt_reason = '".$receipt_reason."'";
			}
		}

		// Employer filter
		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
			if($employer != ''){
				$a .= " AND me.sponsor_id = '".$employer."'";
			}
		}

		// Team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
					AND ht.name LIKE '%".$team."%'
				)";
			}
		}

		$a .= " ORDER BY er.transaction_date DESC";
        $query = $this->db->query($a);  
        return $query->result_array();  
    }

	function print_employewise_list(){ 
		$a = "SELECT 
				er.employee_id,
				m.driver_id,
				SUM(er.due_amount) AS total_due,
				SUM(er.paid_amount) AS total_paid,
				SUM(er.balance_amount) AS total_balance,
				SUM(m.driver_credit) AS total_driver_credit,
				SUM(m.driver_debit) AS total_driver_debit,
				me.emp_no, 
				me.full_name, 
				me.iqama_no, 
				me.iqama_expiry_date, 
				me.nationality, 
				me.mobile, 
				me.passport_no, 
				me.designation, 
				mjt.name AS designation_name, 
				md.name AS department_name, 
				mn.name AS nationality_name,
				(
					SELECT GROUP_CONCAT(ht.name) 
					FROM hunger_team ht 
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
				) AS team_name 
			FROM cash_collection er
			LEFT JOIN master_employee me ON er.employee_id = me.id
			LEFT JOIN maha_jahez_daily_summary m ON er.order_id = m.id
			LEFT JOIN master_department md ON me.department = md.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN master_nationality mn ON me.nationality = mn.id
			WHERE 1=1";

		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
			}
		}
		
		// Driver ID filter
		if($this->input->get('driver_id')) {
			$driver_id = $this->input->get('driver_id');
			if($driver_id != ''){
				$a .= " AND m.driver_id = '".$driver_id."'";
			}
		}

		if($this->input->get('start_date') && $this->input->get('end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('end_date')));
			if($v_from && $v_to){
				$a .= " AND (er.transaction_date BETWEEN '". $v_from ."' AND '". $v_to ."')";
			}
		}

		if($this->input->get('voucher_no')) {
			$id_number = $this->input->get('voucher_no');
			if($id_number != ''){
				$a .= " AND er.transaction_id = '" . $id_number . "'";
			}
		}

		if($this->input->get('receipt_reason')) {
			$receipt_reason = $this->input->get('receipt_reason');
			if($receipt_reason != ''){
				$a .= " AND er.receipt_reason = '" . $receipt_reason . "'";
			}
		}

		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
			if($employer != ''){
				$a .= " AND me.sponsor_id = '" . $employer . "'";
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

		// Grouping by employee + driver
		$a .= " GROUP BY er.employee_id, m.driver_id 
				ORDER BY total_balance DESC";

		$query = $this->db->query($a);  
		return $query->result_array();  
	}
	
	function print_collection_wise_list(){ 
		$a = "SELECT 
				er.employee_id,
				er.transaction_date,
				er.due_amount,
				er.paid_amount,
				er.balance_amount,
				m.summary_date,
				m.driver_id,
				m.driver_credit,
				m.driver_debit,
				m.delivery_price,
				m.cash_collection,
				m.bonuses,
				m.tips,
				m.penalty,
				m.service_deduction,
				(m.cash_collection - m.driver_credit) AS total_amount,
				me.emp_no, 
				me.full_name, 
				me.iqama_no, 
				me.iqama_expiry_date, 
				me.nationality, 
				me.mobile, 
				me.passport_no, 
				me.designation, 
				mjt.name AS designation_name, 
				md.name AS department_name, 
				mn.name AS nationality_name,
				added_admin.username AS added_by_username,
				added_admin.name AS added_by_name,
				updated_admin.username AS updated_by_username,
				updated_admin.name AS updated_by_name,
				(
					SELECT GROUP_CONCAT(ht.name) 
					FROM hunger_team ht 
					WHERE ht.team REGEXP CONCAT('\"', er.employee_id, '\"')
				) AS team_name 
			FROM cash_collection er
			LEFT JOIN master_employee me ON er.employee_id = me.id
			LEFT JOIN maha_jahez_daily_summary m ON er.order_id = m.id
			LEFT JOIN master_department md ON me.department = md.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN master_nationality mn ON me.nationality = mn.id
			LEFT JOIN admin AS added_admin ON er.added_by = added_admin.employee_id
			LEFT JOIN admin AS updated_admin ON er.updated_by = updated_admin.employee_id
			WHERE 1=1";

		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
			}
		}
		
		// Driver ID filter
		if($this->input->get('driver_id')) {
			$driver_id = $this->input->get('driver_id');
			if($driver_id != ''){
				$a .= " AND m.driver_id = '".$driver_id."'";
			}
		}

		if($this->input->get('start_date') && $this->input->get('end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('end_date')));
			if($v_from && $v_to){
				$a .= " AND (er.transaction_date BETWEEN '". $v_from ."' AND '". $v_to ."')";
			}
		}

		// COD Date filter
		if($this->input->get('order_start_date') && $this->input->get('order_end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('order_start_date')));
			$v_to = date("Y-m-d", strtotime($this->input->get('order_end_date')));
			if($v_from && $v_to){
				$a .= " AND (DATE(m.summary_date) BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		if($this->input->get('voucher_no')) {
			$id_number = $this->input->get('voucher_no');
			if($id_number != ''){
				$a .= " AND er.transaction_id = '" . $id_number . "'";
			}
		}

		if($this->input->get('receipt_reason')) {
			$receipt_reason = $this->input->get('receipt_reason');
			if($receipt_reason != ''){
				$a .= " AND er.receipt_reason = '" . $receipt_reason . "'";
			}
		}

		if($this->input->get('employer')) {
			$employer = $this->input->get('employer');
			if($employer != ''){
				$a .= " AND me.sponsor_id = '" . $employer . "'";
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

		// Grouping by employee + driver
		$a .= " ORDER BY er.balance_amount DESC";

		$query = $this->db->query($a);  
		return $query->result_array();  
	}
	
	function print_full_cash_collection_list() {
		$a = "SELECT 
				m.driver_id,
				m.emp_id AS employee_id,

				me.emp_no, 
				me.full_name, 
				me.iqama_no, 
				me.iqama_expiry_date, 
				me.nationality, 
				me.mobile, 
				me.passport_no, 
				me.designation, 
				mjt.name AS designation_name, 
				md.name AS department_name, 
				mn.name AS nationality_name,

				-- Cash collection totals
				SUM(cc.due_amount) AS total_due,
				SUM(cc.paid_amount) AS total_paid,
				SUM(cc.balance_amount) AS total_balance,

				-- Maha Jahez Summary
				SUM(m.orders) AS total_orders,
				SUM(m.driver_credit) AS total_driver_credit,
				SUM(m.cash_collection) AS total_cash_collection,
				SUM(m.driver_debit) AS total_driver_debit,
				SUM(m.delivery_price) AS total_delivery_price,
				SUM(m.total_amount) AS total_total_amount,

				(
					SELECT GROUP_CONCAT(ht.name)
					FROM hunger_team ht 
					WHERE ht.team REGEXP CONCAT('\"', m.emp_id, '\"')
				) AS team_name

			FROM maha_jahez_daily_summary m

			-- LEFT JOIN on order ID (your requirement)
			LEFT JOIN cash_collection cc ON cc.order_id = m.id

			LEFT JOIN master_employee me ON m.emp_id = me.id
			LEFT JOIN master_department md ON me.department = md.id
			LEFT JOIN master_job_title mjt ON me.designation = mjt.id
			LEFT JOIN master_nationality mn ON me.nationality = mn.id
			WHERE 1=1";

		// ---------------- FILTERS ----------------

		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			if($keyword != ''){
				$a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%')";
			}
		}
		
		// Driver ID filter
		if($this->input->get('driver_id')) {
			$driver_id = $this->input->get('driver_id');
			if($driver_id != ''){
				$a .= " AND m.driver_id = '".$driver_id."'";
			}
		}

		// Date filter based on maha_jahez_daily_summary.order_date
		if($this->input->get('start_date') && $this->input->get('end_date')){
			$v_from = date("Y-m-d", strtotime($this->input->get('start_date')));
			$v_to   = date("Y-m-d", strtotime($this->input->get('end_date')));
			if($v_from && $v_to){
				$a .= " AND (m.order_date BETWEEN '".$v_from."' AND '".$v_to."')";
			}
		}

		if($this->input->get('voucher_no')) {
			$vno = $this->input->get('voucher_no');
			if($vno != ''){
				$a .= " AND cc.transaction_id = '" . $vno . "'";
			}
		}

		if($this->input->get('receipt_reason')) {
			$reason = $this->input->get('receipt_reason');
			if($reason != ''){
				$a .= " AND cc.receipt_reason = '" . $reason . "'";
			}
		}

		if($this->input->get('employer')) {
			$emp = $this->input->get('employer');
			if($emp != ''){
				$a .= " AND me.sponsor_id = '" . $emp . "'";
			}
		}

		// Team filter
		if($this->input->get('team')) {
			$team = $this->input->get('team');
			if($team != ''){
				$team = $this->db->escape_like_str($team);
				$a .= " AND EXISTS (
					SELECT 1
					FROM hunger_team ht
					WHERE ht.team REGEXP CONCAT('\"', m.emp_id, '\"')
					AND ht.name LIKE '%" . $team . "%'
				)";
			}
		}

		// -------- GROUPING ----------
		$a .= " GROUP BY m.emp_id, m.driver_id
				ORDER BY total_orders DESC";

		$query = $this->db->query($a);
		return $query->result_array();
	}

	function get_detail($id)
	{
		return $this->db->select('cc.*, mds.driver_id')
			->from('cash_collection cc')
			->join('maha_jahez_daily_summary mds', 'cc.order_id = mds.id', 'left')
			->where('cc.id', (int)$id)
			->get();
	}

	function check_duplicate_employee($id, $emp_id, $platform){
		$this->db->select("*");  
		$this->db->from('cash_collection'); 
		$this->db->where('id !=',$id);
		$this->db->where('platform =',$platform);
		$this->db->where('employee_id =',$emp_id);
		return $this->db->count_all_results();  
	}
	
	public function delete($ids)
	{
		if (empty($ids) || !is_array($ids)) {
			log_message('error', 'Delete failed: invalid $ids');
			return false;
		}

		$this->db->where_in('id', $ids);
		$this->db->delete('cash_collection');

		$error = $this->db->error();
		log_message('debug', 'Delete SQL: ' . $this->db->last_query());
		log_message('debug', 'Delete error: ' . print_r($error, true));

		if ($error['code'] != 0) {
			log_message('error', 'Delete query error: ' . $error['message']);
			return false;
		}

		$affected = $this->db->affected_rows();
		log_message('debug', 'Delete affected rows: ' . $affected);

		return ($affected > 0);
	}

	public function insert_otp($data) {
        return $this->db->insert('cash_otp_verification', $data);
    }

    public function get_otp($employee_id) {
        $this->db->where('employee_id', $employee_id);
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('cash_otp_verification');
        return $query->row();
    }
}
