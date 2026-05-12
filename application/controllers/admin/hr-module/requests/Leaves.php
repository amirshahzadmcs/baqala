<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/requests/Leave_model', 'leave_model');
			$this->load->model('admin/hr-module/Leave_types_model', 'leave_types_model');
			#$this->load->model('admin/hr-module/Employee_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
		}			
		else{
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['leave_approval'] = $this->leave_model->get_list();
		$data['leave_lists'] = $this->leave_model->get_leave_types();
		//dd($data['leave_approval']);
		$this->load->view('admin/requests/leave/index',$data);
	}

	public function add_leave_form() {
		$data['leave_lists'] = $this->leave_model->get_leave_types();
        $this->load->view('admin/requests/leave/partials/add_leave_request',$data);
    }

	public function get_employee_view() {
		$data['employees'] = $this->leave_types_model->get_all_employees();
		$selected_emp = $this->leave_types_model->get_all_settings();
		$data['selected_emp'] = $selected_emp['employee_ids'];
        $this->load->view('admin/requests/leave/partials/employee_list', $data);
    }

	public function edit_leave_form() {
		$id = $this->input->get('id');
		$data['leave_requests'] = $this->leave_model->getLeaveRequestById($id);
		$data['leave_lists'] = $this->leave_model->get_leave_types();
		//dd($data['leave_requests']);
        $this->load->view('admin/requests/leave/partials/edit_leave_request', $data);
    }

	public function save_leave_approval() {
        $is_applicable_to_all = $this->input->post('is_applicable_to_all') ? 'yes' : 'no';

        // Validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('leave_types', 'Leave Type', 'required');
		$this->form_validation->set_rules('approver_list[]', 'Approver', 'callback_validate_approvers');

		if($is_applicable_to_all === 'no'){
			$this->form_validation->set_rules('selectedEmployees[]', 'Approver', 'required');
		}

        // Run validation
        if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
        } else {
            $data = $this->input->post();
			$selectedEmployees = json_decode($data['selectedEmployees'], true);
			// Prepare approver array
			$approvers = [];
			foreach ($data['approver_index'] as $key => $index) {
				// Only add if approver_list is not empty
				if (!empty($data['approver_list'][$key])) {
					$approvers[] = [
						'approver_index' => $index,
						'approver_type'  => $data['approver_type'][$key],
						'approver_list'  => $data['approver_list'][$key]
					];
				}
			}

			$approval_detail = array(
				'leave_types' => $this->input->post('leave_types'),
			);

			// Prepare data to insert
			$leaveData = [
				'name' => $data['name'],
				'approval_types' => 'LeaveRequest',
				'approval_detail' => json_encode($approval_detail),
				'is_applicable_to_all' => $is_applicable_to_all,
				'employees_ids' => json_encode($selectedEmployees),
                'approver' => json_encode($approvers),
                'status' => 'active',
                'type' => 'custom'
			];

            // Update the leave type
            if ($this->leave_model->insertLeave($leaveData)) {
				echo json_encode(['status' => 'success', 'message' => 'Leave approval cycles added successfully.']);
				return;
            } else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to add leave approval cycles.']);
				return;
            }
        }
    }

	// Custom validation for both approver list and approver type
	public function validate_approvers() {
		$approver_list = $this->input->post('approver_list');
		$approver_type = $this->input->post('approver_type');

		$hasValidEntry = false; // To check if at least one valid entry exists

		foreach ($approver_list as $key => $approver) {
			if (!empty($approver) && !empty($approver_type[$key])) {
				$hasValidEntry = true; // At least one valid pair found
			}
		}

		if ($hasValidEntry) {
			return TRUE; // Passes validation if at least one valid entry
		} else {
			$this->form_validation->set_message('validate_approvers', 'At least one approver must be selected.');
			return FALSE; // Fails validation if no valid pair exists
		}
	}

	public function update_leave_approval() {
        $is_applicable_to_all = $this->input->post('is_applicable_to_all') ? 'yes' : 'no';

        // Validation rules
        $this->form_validation->set_rules('leave_id', 'Request ID', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('leave_types', 'Leave Type', 'required');
        $this->form_validation->set_rules('approver_list[]', 'Approver', 'callback_validate_approvers');

		if($is_applicable_to_all === 'no'){
			$this->form_validation->set_rules('selectedEmployees[]', 'Approver', 'required');
		}

        // Run validation
        if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
        } else {
            $data = $this->input->post();
			$selectedEmployees = json_decode($data['selectedEmployees'], true);
			$leaveId = $data['leave_id'];
			// Prepare approver array
			$approvers = [];
			foreach ($data['approver_index'] as $key => $index) {
				// Only add if approver_list is not empty
				if (!empty($data['approver_list'][$key])) {
					$approvers[] = [
						'approver_index' => $index,
						'approver_type'  => $data['approver_type'][$key],
						'approver_list'  => $data['approver_list'][$key]
					];
				}
			}
			$approval_detail = array(
				'leave_types' => $this->input->post('leave_types'),
			);
			// Prepare data to insert
			$leaveData = [
				'name' => $data['name'],
				'approval_types' => 'LeaveRequest',
				'approval_detail' => json_encode($approval_detail),
				'is_applicable_to_all' => $is_applicable_to_all,
				'employees_ids' => json_encode($selectedEmployees),
                'approver' => json_encode($approvers),
                'status' => 'active',
                'type' => 'custom'
			];

            // Update the leave type
            if ($this->leave_model->updateLeaveRequest($leaveId,$leaveData)) {
				echo json_encode(['status' => 'success', 'message' => 'Leave approval cycles updated successfully.']);
				return;
            } else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to update leave approval cycles.']);
				return;
            }
        }
    }

	public function delete_leave_approval() {
		$this->form_validation->set_rules('leave_id', 'Request ID', 'required');
        $leave_id = $this->input->post('leave_id');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Select alteast one row to delete.']);
			return;
        } else {
			$result = $this->leave_model->delete_approval($leave_id);
			if ($result) {
				echo json_encode(['status' => 'success', 'message' => 'Leave approval deleted successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Error deleting leave.']);
			}
		}
    }
	
}
