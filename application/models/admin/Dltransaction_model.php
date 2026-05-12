<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dltransaction_model extends CI_Model{
	function add()
	{
		$cost_involve = !empty($this->input->post('cost_involve')) ? 'yes' : 'no';
		$transaction_type = $this->input->post('transaction_type');
		$request_id = $this->input->post('request_id');
		$trans_amount = $this->input->post('trans_amount') ?: 0;
		$trans_date = $this->input->post('trans_date');

		// Start transaction
		$this->db->trans_begin();

		// Insert transaction
		$this->db->insert('dl_transactions', [
			'request_id'       => $request_id,
			'transaction_type' => $transaction_type,
			'cost_involve'     => $cost_involve,
			'trans_amount'     => $trans_amount,
			'trans_date'       => $trans_date,
			'created_at'       => CURRENT_TIME
		]);

		$inserted_id = $this->db->insert_id();

		if ($inserted_id) {
			// Generate transaction number
			$transaction_no = str_pad($inserted_id + 100, 6, '0', STR_PAD_LEFT);
			$this->db->update('dl_transactions', ['trans_id' => $transaction_no], ['id' => $inserted_id]);

			// Prepare dl_request update data
			$update_data = ['trans_status' => $transaction_type];

			// If type = 9, mark completed and save DL info
			if ($transaction_type == 9) {
				$update_data['status'] = 'Completed';

				$dl_request = $this->db->get_where('dl_request', ['id' => $request_id])->row();

				if ($dl_request) {
					$emp_id = $dl_request->emp_id;
					$dlType = ($dl_request->dl_type == 'car')
						? 'Heavy Vehicle Driving License'
						: 'Motorcycle Driving License';

					$dlExpiryDate = ($dl_request->dl_type == 'car')
						? date('Y-m-d', strtotime("$trans_date +2 years"))
						: date('Y-m-d', strtotime("$trans_date +10 years"));

					$emp = $this->db->select('iqama_no')->get_where('master_employee', ['id' => $emp_id])->row();

					if ($emp) {
						$dl_data = [
							'driving_license_number'        => $emp->iqama_no,
							'driving_license_type'          => $dlType,
							'driving_license_issue_country' => '6',
							'driving_license_issue_city'    => '14',
							'driving_license_issue_date'    => $trans_date,
							'driving_license_exp_date'      => $dlExpiryDate,
							'created_at'                    => date('Y-m-d H:i:s')
						];

						// Fetch and append JSON data
						$row = $this->db->select('secondary_dl_details')
										->get_where('master_employee_info', ['employee_id' => $emp_id])
										->row();

						if ($row) {
							$existing_data = json_decode($row->secondary_dl_details, true) ?: [];
							$existing_data[] = $dl_data;

							$this->db->update('master_employee_info', [
								'secondary_dl_details' => json_encode($existing_data),
								'updated_at'           => date('Y-m-d H:i:s')
							], ['employee_id' => $emp_id]);
						}
					}
				}
			}

			// Update dl_request
			$this->db->update('dl_request', $update_data, ['id' => $request_id]);
		}

		// Commit or rollback
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return $inserted_id;
		}
	}
	
	function edit(){
		if($this->input->post('trans_amount') > 0) {
			$cost_involve = 'yes';
		} else {
			$cost_involve = 'no';
		}
		$query = $this->db->query("UPDATE dl_transactions SET 
		cost_involve = '" . $cost_involve . "', 
		trans_amount = '" . $this->db->escape_str($this->input->post('trans_amount')) . "',  
		updated_at = '" . CURRENT_TIME ."'
		WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT dt.*, dr.dl_type, dr.request_no, dr.request_date, me.emp_no, me.full_name, me.iqama_no, me.iqama_expiry_date, me.nationality, me.mobile, me.passport_no, me.designation, mjt.name as designation_name, md.name as department_name FROM dl_transactions dt LEFT JOIN dl_request dr ON (dt.request_id = dr.id) LEFT JOIN master_employee me ON (dr.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%' OR dr.request_no LIKE '%".$keyword."%' OR dt.trans_id LIKE '%".$keyword."%')";
            }
        }
		
		$trans_type = $this->input->get('trans_type');
		if ($trans_type !== null && $trans_type !== '') {
			$a .= " AND dt.transaction_type = '" . $trans_type . "'";
		}

		if($this->input->get('req_from') AND $this->input->get('req_to')){
			$v_from = $this->input->get('req_from');
			$v_to = $this->input->get('req_to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dr.request_date BETWEEN '". date("Y-m-d", strtotime($v_from)) ."' AND '". $d_to ."')";
			}
		}

		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dt.trans_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		$a .= " ORDER BY dt.trans_date DESC, dt.created_at DESC";
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }       
		//log_message('error', $a);        
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_data(){
	   	$a = $this->make_query();
		if($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
            if($keyword != ''){
                $a .= " AND (me.full_name LIKE '%".$keyword."%' OR me.emp_no LIKE '%".$keyword."%' OR dr.request_no LIKE '%".$keyword."%' OR dt.trans_id LIKE '%".$keyword."%')";
            }
        }
		
		$trans_type = $this->input->get('trans_type');
		if ($trans_type !== null && $trans_type !== '') {
			$a .= " AND dt.transaction_type = '" . $trans_type . "'";
		}

		if($this->input->get('req_from') AND $this->input->get('req_to')){
			$v_from = $this->input->get('req_from');
			$v_to = $this->input->get('req_to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dr.request_date BETWEEN '". date("Y-m-d", strtotime($v_from)) ."' AND '". $d_to ."')";
			}
		}
		
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND (dt.trans_date BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}
		
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('dl_transactions');  
	   return $this->db->count_all_results();
    }
	
	function get_detail($id){
		$query = $this->db->query("SELECT dt.*, dr.request_no, dr.dl_type, dr.request_date, me.emp_no, me.full_name, me.employee_pic, me.iqama_no, me.iqama_expiry_date, me.nationality, me.mobile, me.passport_no, me.designation, mjt.name as designation_name, md.name as department_name FROM dl_transactions dt LEFT JOIN dl_request dr ON (dt.request_id = dr.id) LEFT JOIN master_employee me ON (dr.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE dt.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function check_duplicate_employee($id, $request_id, $transaction_type)
	{
		$this->db->from('dl_transactions AS dt');
		$this->db->join('dl_request AS dr', 'dr.id = dt.request_id', 'left');

		$this->db->where('dt.id !=', $id);
		$this->db->where('dt.request_id', $request_id);
		$this->db->where('dt.transaction_type', $transaction_type);

		// Optionally check request status as well (uncomment if needed)
		$this->db->where('dr.status !=', 'Cancelled');

		return $this->db->count_all_results();
	}

	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM dl_transactions WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function dl_request_list(){
		$query = $this->db->query("SELECT dr.*, me.emp_no, me.full_name, me.iqama_no, me.iqama_expiry_date, me.nationality, me.mobile, me.passport_no, me.designation, mjt.name as designation_name, md.name as department_name FROM dl_request dr LEFT JOIN master_employee me ON (dr.emp_id = me.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1");
		return $query->result();
	}
}
