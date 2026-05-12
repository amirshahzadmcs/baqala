<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval_model extends CI_Model{

	public function getEmployeeRequests($statuses)
    {
        if (!is_array($statuses)) {
            $statuses = explode(',', $statuses); // Ensure statuses are an array
        }
        $loginUserId = $this->admin->getLoginEmpId();

        $this->db->select([
            'er.*',
            'erd.request_detail',
            'erd.request_documents',
            'erd.reason',
            'me.emp_no',
            'me.full_name as employee_name',
            'mjt.name as designation_name',
            'rme.full_name as requester_name',
            'rme.employee_arabic_name as requester_arabic_name',
            '(SELECT ra.approver_id 
                FROM request_approvers ra 
                WHERE ra.request_id = er.id 
                AND ra.approve_status = 1 
                LIMIT 1) as current_approver_id',

            // 👇 Virtual status label
            "CASE 
                WHEN er.request_status = 4 
                    OR (er.request_status IN (1,6) AND er.request_date < DATE_SUB(CURDATE(), INTERVAL 60 DAY))
                THEN 'Expired'
                WHEN er.request_status = 1 THEN 'Pending'
                WHEN er.request_status = 2 THEN 'Approved'
                WHEN er.request_status = 3 THEN 'Rejected'
                WHEN er.request_status = 4 THEN 'Expired'
                WHEN er.request_status = 5 THEN 'Canceled'
                WHEN er.request_status = 6 THEN 'Return for Correction'
                ELSE 'Unknown'
            END as status_label"
        ]);

        $this->db->from('employee_requests er');
        $this->db->join('employee_request_detail erd', 'er.id = erd.request_id', 'left');
        $this->db->join('master_employee me', 'er.employee_id = me.id', 'left');
        $this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
        $this->db->join('master_employee rme', 'er.requested_by = rme.id', 'left');

        // --- Handle Expired Logic ---
        if (in_array(4, $statuses)) {
            // Expired = status 4 OR pending (1,6) but older than 60 days
            $this->db->where("(
                er.request_status = 4 
                OR (er.request_status IN (1,6) AND er.request_date < DATE_SUB(CURDATE(), INTERVAL 60 DAY))
            )");
        } elseif (in_array(1, $statuses) || in_array(6, $statuses)) {
            // Pending = only pending requests within 60 days
            $this->db->where("(
                er.request_status IN (1,6) 
                AND er.request_date >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)
            )");
        } elseif (count($statuses) === 6) { 
            // All statuses = include expired logic
            $this->db->where("(
                er.request_status IN (1,2,3,4,5,6)
                OR (er.request_status IN (1,6) AND er.request_date < DATE_SUB(CURDATE(), INTERVAL 60 DAY))
            )");
        } else {
            // Normal statuses (approved, rejected, canceled, etc.)
            $this->db->where_in('er.request_status', $statuses);
        }


        // Approver check condition
        if ($loginUserId != 1) {
            $this->db->where("EXISTS (
                SELECT 1 
                FROM request_approvers ra 
                WHERE ra.request_id = er.id 
                AND ra.approver_id = '".$loginUserId."'
            )", NULL, FALSE);
        }

        $this->db->order_by('er.id', 'DESC');

        return $this->db->get()->result_array();
    }

	public function getRequestDetail($id) {
        $this->db->select('
            er.*, erd.request_detail, erd.request_documents, erd.uploaded_video, erd.reason, me.emp_no, me.full_name as employee_name, me.employee_arabic_name, me.employee_arabic_name, me.email as employee_email, me.iqama_no as employee_iqama_no, me.department as employee_department, md.name as emp_department_name, me.payment_type_detail as employee_bank_detail, me.work_line_manager as employee_manager, me.department_head as employee_department_head, mjt.name as designation_name, mjt.arabic_name as designation_name_arabic, mn.name as employee_nationality, mn.arabic_name as employee_nationality_arabic, rme.full_name as requester_name, rme.employee_arabic_name as requester_arabic_name,
            (SELECT ra.approver_id FROM request_approvers ra WHERE ra.request_id = er.id AND ra.approve_status = 1 LIMIT 1) as current_approver_id
        ');
        $this->db->from('employee_requests er');
        $this->db->join('employee_request_detail erd', 'er.id = erd.request_id', 'left');
        $this->db->join('master_employee me', 'er.employee_id = me.id', 'left');
        $this->db->join('master_nationality mn', 'me.nationality = mn.id', 'left');
        $this->db->join('master_job_title mjt', 'me.designation = mjt.id', 'left');
        $this->db->join('master_department md', 'me.department = md.id', 'left');
		$this->db->join('master_employee rme', 'er.requested_by = rme.id', 'left');
        $this->db->where('er.id', $id);
        $this->db->order_by('er.id', 'DESC');
        return $this->db->get();
    }

    public function getComments($request_id) {
        $this->db->select('ec.*, me.emp_no, me.full_name as employee_name, me.employee_arabic_name as employee_arabic_name');
        $this->db->from('request_comments ec');
        $this->db->join('master_employee me', 'ec.employee_id = me.id', 'left');
        $this->db->where('ec.request_id', $request_id);
        $this->db->where('ec.comment_type', '1');
        $this->db->order_by('ec.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getCorrectionComments($request_id) {
        $this->db->select('ec.*, me.emp_no, me.full_name as employee_name, me.employee_arabic_name as employee_arabic_name');
        $this->db->from('request_comments ec');
        $this->db->join('master_employee me', 'ec.employee_id = me.id', 'left');
        $this->db->where('ec.request_id', $request_id);
        $this->db->where('ec.comment_type', '2');
        $this->db->order_by('ec.id', 'ASC');
        return $this->db->get()->result_array();
    }
	
	public function markExpiredRequests()
    {
        $this->db->set('request_status', 4); // set status to Expired
        $this->db->set('last_status_date', date('Y-m-d H:i:s')); // update status date
        $this->db->where_in('request_status', [1, 6]); // only pending / return for correction
        $this->db->where('request_date <', date('Y-m-d', strtotime('-60 days')));
        return $this->db->update('employee_requests');
    }
}
