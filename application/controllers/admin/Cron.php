<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		$this->load->model('admin/logistic-management/Rider_model','rider_model');
		$this->load->model('admin/hr-module/Approval_model','approval_model');
		$this->load->helper('sendmail_helper');
		$this->load->library('form_validation');
	}

	public function unsuspend_riders() {
        $result = $this->rider_model->unsuspend_riders();
		$res = array("status" => 'success', "code" => 200, "message" => $result, "data" => array());
        echo json_encode($res, 200);
    }
	
	public function send_insurance_expiry_notifications() {
        $today = date('Y-m-d');

        // Fetch employees whose insurance expires in 15 or 7 days
        $query = $this->db->query("
            SELECT 
                e.id, 
                e.full_name, 
                e.email, 
                ei.insurance_company_name, 
                ei.insurance_policy_no, 
                ei.insurance_end_date
            FROM master_employee_info ei
            JOIN master_employee e ON ei.employee_id = e.id
            WHERE ei.insurance_end_date IN (DATE_ADD('$today', INTERVAL 15 DAY), DATE_ADD('$today', INTERVAL 7 DAY)) AND e.status = 'Active'
        ");

        $employees = $query->result_array();
		//dd($employees);
        if (!empty($employees)) {
            foreach ($employees as $employee) {
				$email_data = array(
					'employee_id' => $employee['id'],
					'request_type' => 'insurance_expiry',
					'email' => $employee['email'],
					'name' => $employee['full_name'],
					'insurance_company_name' => $employee['insurance_company_name'],
					'insurance_policy_no' => $employee['insurance_policy_no'],
					'insurance_end_date' => $employee['insurance_end_date'],
					'subject' => 'Group Health Insurance Expiry Notification',
					'template' => 'admin/attatchment-template/insurance_expiry_email'
				);
                send_notification_mail($email_data);
            }
			$res = array("status" => 'success', "code" => 200, "message" => count($employees) . " insurance expiry email notifications sent successfully!", "data" => array());
        	echo json_encode($res, 200);
        } else {
			$res = array("status" => 'success', "code" => 200, "message" => "No employees found for insurance expiry notification.", "data" => array());
        	echo json_encode($res, 200);
        }
    }
	
	public function expire_requests()
	{
		$updated = $this->approval_model->markExpiredRequests();
		if ($updated) {
			$res = array(
				"status"  => 'success',
				"code"    => 200,
				"message" => 'Expired requests updated successfully',
				"data"    => array()
			);
		} else {
			$res = array(
				"status"  => 'success',
				"code"    => 200,
				"message" => "No request found to update.",
				"data"    => array()
			);
		}
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($res));
	}

	
}
