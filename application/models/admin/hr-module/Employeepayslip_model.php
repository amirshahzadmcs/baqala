<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employeepayslip_model extends CI_Model{
	/*
	function make_query(){
		$a = "SELECT ep.* FROM employee_payslip ep WHERE 1=1";
		return $a;
	}
	
	function get_list($keyword,$designation,$department,$iqama,$start_date,$end_date){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (ep.employee_name LIKE '%".$keyword."%' OR ep.emp_id LIKE '%".$keyword."%')";
		}
		if($designation){
			$a .= " AND ep.designation = '" . $designation . "'";
		}
		if($department){
			$a .= " AND ep.department = '" . $department . "'";
		}
		if($iqama){
			$a .= " AND ep.iqama_no = '" . $iqama . "'";
		}
		if ($start_date && $end_date) {
			$start = date("Y-m-d", strtotime($start_date));
			$end = date("Y-m-d", strtotime($end_date));
			$a .= " AND (ep.salary_month BETWEEN '" . $start . "' AND '" . $end . "')";
		}
		
		$a .= " ORDER BY ep.salary_month DESC";		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    function get_filtered_data($keyword,$designation,$department,$iqama,$start_date,$end_date){
	   	$a = $this->make_query();
		   if($keyword){
			$a .= " AND (ep.employee_name LIKE '%".$keyword."%' OR ep.emp_id LIKE '%".$keyword."%')";
		}
		if($designation){
			$a .= " AND ep.designation = '" . $designation . "'";
		}
		if($department){
			$a .= " AND ep.department = '" . $department . "'";
		}
		if($iqama){
			$a .= " AND ep.iqama_no = '" . $iqama . "'";
		}
		if ($start_date && $end_date) {
			$start = date("Y-m-d", strtotime($start_date));
			$end = date("Y-m-d", strtotime($end_date));
			$a .= " AND (ep.salary_month BETWEEN '" . $start . "' AND '" . $end . "')";
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('employee_payslip');  
	   return $this->db->count_all_results();
    }
	*/

	public function getPayrollSummary() {
        $this->db->select("
            ep.id,
            ep.payroll_month,
			ep.from_date,
			ep.to_date,
            CONCAT(ep.from_date, ' -> ', ep.to_date) AS From_To,
            ep.status,
            ep.closing_date,
            ep.created_at,
            (
                SELECT COUNT(*) 
                FROM employee_payslip eps 
                WHERE eps.payroll_id = ep.id
            ) AS Total_Employees,
            (
                SELECT SUM(eps.net_pay) 
                FROM employee_payslip eps 
                WHERE eps.payroll_id = ep.id
            ) AS Net_Total
        ");
        $this->db->from('employee_payroll ep');
        $this->db->order_by('ep.payroll_month', 'DESC');
        
        $query = $this->db->get();
        return $query->result_array(); // Return as an array of results
    }

	public function checkDuplicatesPayroll($payroll_month) {
		if (empty($payroll_month)) {
			return [];
		}
	
		$this->db->select('payroll_month');
		$this->db->from('employee_payroll');
		$this->db->where('payroll_month', $payroll_month);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function delete($payroll_id)
	{
		$this->db->trans_start(); // Start transaction

		// First, delete all associated records from employee_payslip
		$this->db->where('payroll_id', $payroll_id);
		$this->db->delete('employee_payslip');

		// Then, delete the main payroll record
		$this->db->where('id', $payroll_id);
		$this->db->delete('employee_payroll');

		$this->db->trans_complete(); // Complete transaction

		return $this->db->trans_status(); // Returns true if successful, false otherwise
	}

	function get_detail($id){
		$query = $this->db->query("SELECT employee_payroll.* FROM employee_payroll WHERE employee_payroll.id = '" . (int)$id . "'");
		return $query->row_array();
	}
	
	public function getSummaryData($id) {
        // Query for summary cards
        return [
            'total_salaries' => $this->db->select_sum('salary_earned')->where('payroll_id',$id)->get('employee_payslip')->row()->salary_earned ?? 0,
            'total_additions' => $this->db->select_sum('total_earnings')->where('payroll_id',$id)->get('employee_payslip')->row()->commission ?? 0,
            'total_deductions' => $this->db->select_sum('total_deduction')->where('payroll_id',$id)->get('employee_payslip')->row()->total_deduction ?? 0,
            'net_salaries' => $this->db->select_sum('net_pay')->where('payroll_id',$id)->get('employee_payslip')->row()->net_pay ?? 0
        ];
    }

    public function getPayrollDetails($id) {
        // Query to fetch detailed payroll data
        $this->db->select('ep.*');
        $this->db->from('employee_payslip ep');
		$this->db->where('payroll_id',$id);
        $this->db->order_by('ep.emp_id', 'ASC');
        return $this->db->get()->result_array();
    }
	
	public function payslipDetail($id) {
		if (empty($id)) {
			return null;
		}
		// Query to fetch detailed payroll data
		$this->db->select('eps.*, ep.payroll_month, ep.from_date, ep.to_date, ep.status, ep.closing_date, mei.gosi_id, mei.qiwa_contract_no, mei.qiwa_contract_end_date');
		$this->db->from('employee_payslip eps');
		$this->db->join('employee_payroll ep', 'eps.payroll_id = ep.id', 'left');
		$this->db->join('master_employee me', 'eps.emp_id = me.emp_no', 'left');
		$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
		$this->db->where('eps.id', $id);
		$result = $this->db->get()->row_array();
		if (empty($result)) {
			return null;
		}
		return $result;
	}
	
	public function printAllPayslips($payroll_id) {
		if (empty($payroll_id)) {
			return null;
		}
		// Query to fetch detailed payroll data
		$this->db->select('eps.*, ep.payroll_month, ep.from_date, ep.to_date, ep.status, ep.closing_date, mei.gosi_id, mei.qiwa_contract_no');
		$this->db->from('employee_payslip eps');
		$this->db->join('employee_payroll ep', 'eps.payroll_id = ep.id', 'left');
		$this->db->join('master_employee me', 'eps.emp_id = me.emp_no', 'left');
		$this->db->join('master_employee_info mei', 'me.id = mei.employee_id', 'left');
		$this->db->where('eps.payroll_id', $payroll_id);
		$result = $this->db->get()->result_array();
		if (empty($result)) {
			return null;
		}
		return $result;
	}
	
	public function updateStatus($id, $data) {
		$this->db->where('id', $id);
		return $this->db->update('employee_payroll', $data);
	}
}

