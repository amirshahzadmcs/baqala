<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle_allotment extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/requests/Vehicle_allotment_model', 'vehicle_allotment_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('request_helper');
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
		$data['vehicle_allotment_approvals'] = $this->vehicle_allotment_model->get_list();
		//dd($data['loan_approvals']);
		$this->load->view('admin/requests/vehicle_allotment/index',$data);
	}

	public function add_form() {
        $this->load->view('admin/requests/vehicle_allotment/partials/add_approval');
    }

	public function get_employee_view() {
		$data['employees'] = $this->vehicle_allotment_model->get_all_employees();
        $this->load->view('admin/requests/vehicle_allotment/partials/employee_list', $data);
    }

	public function edit_form() {
		$id = $this->input->get('id');
		$data['vehicle_allotment_requests'] = $this->vehicle_allotment_model->getRequestById($id);
		//dd($data['loan_requests']);
        $this->load->view('admin/requests/vehicle_allotment/partials/edit_approval', $data);
    }

	public function save_approval() {
		$is_applicable_to_all = $this->input->post('is_applicable_to_all') ? 'yes' : 'no';
	
		// Validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('approver_list[]', 'Approver', 'callback_validate_approvers');
	
		if ($is_applicable_to_all === 'no') {
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
	
			// Prepare data to insert
			$insertData = [
				'name' => $data['name'],
				'approval_types' => 'VehicleAllotmentRequest',
				'is_applicable_to_all' => $is_applicable_to_all,
				'employees_ids' => json_encode($selectedEmployees),
				'approver' => json_encode($approvers),
				'status' => 'active',
				'type' => 'custom'
			];
            // Update existing VehicleAllotmentRequest records if 'is_applicable_to_all' is 'yes'
			if ($is_applicable_to_all === 'yes') {
				$this->db->where('approval_types', 'VehicleAllotmentRequest');
				$this->db->update('request_approval', [
					'is_applicable_to_all' => 'no',
					'employees_ids' => json_encode([])
				]);
			}
	
			// Insert the new approval record
			if ($this->vehicle_allotment_model->insertApporval($insertData)) {
				echo json_encode(['status' => 'success', 'message' => 'Vehicle allotment approval cycles added successfully.']);
				return;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to add vehicle allotment approval cycles.']);
				return;
			}
		}
	}	

	// Custom validation for both approver list and approver type
	public function validate_approvers() {
		$approver_list = $this->input->post('approver_list');
		$approver_type = $this->input->post('approver_type');

		$hasValidEntry = false;

		foreach ($approver_list as $key => $approver) {
			if (!empty($approver) && !empty($approver_type[$key])) {
				$hasValidEntry = true;
			}
		}

		if ($hasValidEntry) {
			return TRUE;
		} else {
			$this->form_validation->set_message('validate_approvers', 'At least one approver must be selected.');
			return FALSE;
		}
	}

	public function update_approval() {
		$is_applicable_to_all = $this->input->post('is_applicable_to_all') ? 'yes' : 'no';
	
		// Validation rules
		$this->form_validation->set_rules('vehicle_allotment_id', 'Vehicle Allotment Id', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('approver_list[]', 'Approver', 'callback_validate_approvers');
	
		if ($is_applicable_to_all === 'no') {
			$this->form_validation->set_rules('selectedEmployees[]', 'Approver', 'required');
		}
	
		// Run validation
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			return;
		} else {
			$data = $this->input->post();
			$selectedEmployees = json_decode($data['selectedEmployees'], true);
			$dlId = $data['vehicle_allotment_id'];
			$dlDetail = $this->vehicle_allotment_model->getRequestById($dlId);
	
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
	
			// Determine type based on dl_id
			$type = ($dlDetail->type == 'default') ? 'default' : 'custom';
	
			// Prepare data to update
			$dlData = [
				'name' => $data['name'],
				'approval_types' => 'VehicleAllotmentRequest',
				'is_applicable_to_all' => $is_applicable_to_all,
				'approver' => json_encode($approvers),
				'status' => 'active',
				'type' => $type // Set type dynamically
			];
	
			// Update existing VehicleAllotmentRequest records if 'is_applicable_to_all' is 'yes'
			if ($is_applicable_to_all === 'yes') {
				$this->db->query("UPDATE `request_approval` 
						SET `is_applicable_to_all` = 'no', 
							`employees_ids` = JSON_ARRAY() 
						WHERE `approval_types` = 'VehicleAllotmentRequest'");
				$dlData['employees_ids'] = json_encode([]);
				$dlData['is_applicable_to_all'] = 'yes';
			}else{
				$dlData['employees_ids'] = json_encode($selectedEmployees);
    			$dlData['is_applicable_to_all'] = 'no';
			}
			// Update the specific dl record
			if ($this->vehicle_allotment_model->updateApporval($dlId, $dlData)) {
				echo json_encode(['status' => 'success', 'message' => 'Vehicle Allotment approval cycles updated successfully.']);
				return;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to update Vehicle Allotment approval cycles.']);
				return;
			}
		}
	}	

	public function delete_approval() {
		$this->form_validation->set_rules('vehicle_allotment_id', 'Request ID', 'required');
        $vehicle_allotment_id = $this->input->post('vehicle_allotment_id');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Select alteast one row to delete.']);
			return;
        } else {
			$result = $this->vehicle_allotment_model->deleteApproval($vehicle_allotment_id);
			if ($result) {
				echo json_encode(['status' => 'success', 'message' => 'Vehicle Allotment approval deleted successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Error deleting Vehicle Allotment approval.']);
			}
		}
    }
	
}
