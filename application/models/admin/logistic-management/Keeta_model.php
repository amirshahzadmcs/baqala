<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Keeta_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->table = 'keeta_order_summary';
	}
	
	public function update($where, $data) {
		return $this->db->update($this->table, $data, $where);
	}

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM $this->table WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	public function get($where = 0) {
		if($where) 
			$this->db->where($where);
		$query = $this->db->get($this->table);
		return $query->row();
	}

	public function add_batch($data) {
		return $this->db->insert_batch($this->table, $data);
	}

	/*----- List Info -----*/
	function make_query(){
		$a = "SELECT * FROM $this->table WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword, $courier_id, $start_date, $end_date) {
		$a = $this->make_query();

		if ($keyword) {
			$a .= " AND (courier_first_name LIKE '%" . $this->db->escape_like_str($keyword) . "%' OR courier_last_name LIKE '%" . $this->db->escape_like_str($keyword) . "%')";
		}

		if ($courier_id) {
			$a .= " AND courier_id= '" . $this->db->escape($courier_id) . "'";
		}

		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date)); // Use Y-m-d format for SQL
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND order_date BETWEEN '" . $period_start . "' AND '" . $period_end . "'";
		}

		$a .= " ORDER BY order_date DESC";

		if ($_POST["length"] != -1) {
			$a .= " LIMIT " . (int)$_POST['start'] . ", " . (int)$_POST['length'];
		}

		$query = $this->db->query($a);
		return $query->result();
	}

    function get_filtered_data($keyword, $courier_id, $start_date, $end_date) {
		$a = $this->make_query();

		if ($keyword) {
			$a .= " AND (courier_first_name LIKE '%" . $this->db->escape_like_str($keyword) . "%' OR courier_last_name LIKE '%" . $this->db->escape_like_str($keyword) . "%')";
		}

		if ($courier_id) {
			$a .= " AND courier_id= '" . $this->db->escape($courier_id) . "'";
		}

		if ($start_date && $end_date) {
			$period_start = date('Y-m-d', strtotime($start_date)); // Use Y-m-d format
			$period_end = date('Y-m-d', strtotime($end_date));
			$a .= " AND order_date BETWEEN '" . $period_start . "' AND '" . $period_end . "'";
		}

		$query = $this->db->query($a);
		return $query->num_rows();
	}
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from($this->table);  
	   return $this->db->count_all_results();
    }
	
}

