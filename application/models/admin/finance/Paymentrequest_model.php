<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paymentrequest_model extends CI_Model{

	public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $query = $this->db->get('payment_request_form');
        return $query->result_array();
    }

	// Fetch details of a single payment request by ID
	public function get_payment_request_by_id($id) {
		$this->db->select("prf.*, 
							CASE 
								WHEN prf.request_for_type = 'employee' THEN emp.full_name
								WHEN prf.request_for_type = 'vendor' OR prf.request_for_type = 'saddad' THEN vnd.vendor_name
								ELSE 'Unknown'
							END AS request_name");
		$this->db->from('payment_request_form prf');
		$this->db->join('master_employee emp', 'prf.request_for_id = emp.id AND prf.request_for_type = "employee"', 'left');
		$this->db->join('vendors vnd', 'prf.request_for_id = vnd.id AND (prf.request_for_type = "vendor" OR prf.request_for_type = "saddad")', 'left');
		$this->db->where('prf.id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	

	// Update payment request details
	public function update_payment_request($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('payment_request_form', $data);
	}
	
    public function insert($data) {
		$this->db->insert('payment_request_form', $data);
		return $this->db->insert_id();
	}

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('payment_request_form', $data);
    }
	
	// Function to apply common filters
    private function apply_filters(&$a) {
        if($this->input->get('document_no')) {
            $document_no = $this->input->get('document_no');
            if($document_no != '') {
                $a .= " AND prf.document_no = '" . $document_no . "'";
            }
        }

		if($this->input->get('request_for_type')) {
            $request_for_type = $this->input->get('request_for_type');
            if($request_for_type != '') {
                $a .= " AND prf.request_for_type = '" . $request_for_type . "'";
            }
        }

        if($this->input->get('from') && $this->input->get('to')) {
            $v_from = $this->input->get('from');
            $v_to = $this->input->get('to');
            $d_to = date("Y-m-d", strtotime($v_to));
            if($v_from && $v_to) {
                $a .= " AND (prf.request_date BETWEEN '" . date("Y-m-d", strtotime($v_from)) . "' AND '" . $d_to . "')";
            }
        }

		if($this->input->get('p_from') && $this->input->get('to')) {
            $v_from1 = $this->input->get('p_from');
            $v_to = $this->input->get('p_to');
            $d_to1 = date("Y-m-d", strtotime($v_to));
            if($v_from1 && $d_to1) {
                $a .= " AND (prf.finance_payment_date BETWEEN '" . date("Y-m-d", strtotime($v_from1)) . "' AND '" . $d_to1 . "')";
            }
        }

        if($this->input->get('request_for_id')) {
            $request_for_id = $this->input->get('request_for_id');
			$request_for_type = $this->input->get('request_for_type');
            if($request_for_id != '') {
                $a .= " AND (prf.request_for_type = '" . $request_for_type . "' AND prf.request_for_id = '" . $request_for_id . "')";
            }
        }

        if($this->input->get('requester_id')) {
            $requester_id = $this->input->get('requester_id');
            if($requester_id != '') {
                $a .= " AND prf.requester_id = '" . $requester_id . "'";
            }
        }

        if($this->input->get('method_of_payment')) {
            $method_of_payment = $this->input->get('method_of_payment');
            if($method_of_payment != '') {
                $a .= " AND prf.method_of_payment = '" . $method_of_payment . "'";
            }
        }

        if($this->input->get('type_of_payment')) {
            $type_of_payment = $this->input->get('type_of_payment');
            if($type_of_payment != '') {
                $a .= " AND prf.type_of_payment = '" . $type_of_payment . "'";
            }
        }

        if($this->input->get('currency')) {
            $currency = $this->input->get('currency');
            if($currency != '') {
                $a .= " AND prf.currency = '" . $currency . "'";
            }
        }

        if($this->input->get('status')) {
            $status = $this->input->get('status');
            if($status != '') {
                $a .= " AND prf.status = '" . $status . "'";
            }
        }
		
		if ($this->input->get('comments')) {
            $search = $this->db->escape_like_str($this->input->get('comments'));
            $a .= " AND JSON_SEARCH(prf.instructions COLLATE utf8mb4_general_ci, 'all', '%" . $search . "%') IS NOT NULL";
        }
    }

	function make_query(){
		$a = "SELECT 
				prf.*, req_emp.full_name as requester_name, 
				CASE 
					WHEN prf.request_for_type = 'employee' THEN emp.full_name
					WHEN prf.request_for_type = 'vendor' OR prf.request_for_type = 'saddad' THEN vnd.vendor_name
					ELSE 'Unknown'
				END AS request_name
			  FROM payment_request_form prf
			  LEFT JOIN master_employee emp ON prf.request_for_id = emp.id AND prf.request_for_type = 'employee' 
			  LEFT JOIN master_employee req_emp ON prf.requester_id = req_emp.id  
			  LEFT JOIN vendors vnd ON prf.request_for_id = vnd.id AND (prf.request_for_type = 'vendor' OR prf.request_for_type = 'saddad') WHERE 1 = 1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		$this->apply_filters($a);
		$a .= " ORDER BY prf.id DESC";
		if ($_POST["length"] != -1) {
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}
		$query = $this->db->query($a);  
		return $query->result();
	}
	
	function get_filtered_data(){
		$a = $this->make_query();
		$this->apply_filters($a);
		$query = $this->db->query($a);  
		return $query->num_rows();  // Get the number of filtered rows
	}
	
	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('payment_request_form');  
		return $this->db->count_all_results();  // Get the total number of rows in the table
	}
	
	/*-------- Filters -----*/

    public function get_filtered_document_nos($search_query) {
        $this->db->select('document_no, document_no as key_value');
        $this->db->from('payment_request_form');
        if (!empty($search_query)) {
            $this->db->like('document_no', $search_query);
        }
        $query = $this->db->get();
        return $query->result();
    }
	
    public function get_filtered_requester_users($search_query) {
        $this->db->select('prf.requester_id as key_value, me.full_name, me.emp_no');
        $this->db->from('payment_request_form prf');
		$this->db->join('master_employee me', 'prf.requester_id = me.id', 'left');
        if (!empty($search_query)) {
            $this->db->like('me.full_name', $search_query);
        }
        $query = $this->db->get();
        return $query->result();
    }
	
	/*----- Filters End -----*/

	public function delete($ids){
		if (is_array($ids)) {
			$this->db->where_in('id', $ids);
		} else {
			$this->db->where('id', $ids);
		}
		return $this->db->delete('payment_request_form');
	}	
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM payment_request_form WHERE id = '" . (int)$id . "'");
		return $query;
	}

}
