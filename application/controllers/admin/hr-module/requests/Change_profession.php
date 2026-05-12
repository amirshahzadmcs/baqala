<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Change_profession extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/requests/Change_profession_model', 'profession_model');
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
		$data['profession_approvals'] = $this->profession_model->get_list();
		//dd($data['loan_approvals']);
		$this->load->view('admin/requests/profession/index',$data);
	}

	public function add_form() {
        $this->load->view('admin/requests/profession/partials/add_approval');
    }

	public function get_employee_view() {
		$data['employees'] = $this->profession_model->get_all_employees();
        $this->load->view('admin/requests/profession/partials/employee_list', $data);
    }

	public function edit_form() {
		$id = $this->input->get('id');
		$data['profession_requests'] = $this->profession_model->getRequestById($id);
		//dd($data['loan_requests']);
        $this->load->view('admin/requests/profession/partials/edit_approval', $data);
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
			$selectedEmployees = isset($data['selectedEmployees']) && !empty($data['selectedEmployees'])
                ? json_decode($data['selectedEmployees'], true)
                : [];
			// Prepare approver array
            $approvers = [];
            foreach ($data['approver_index'] as $key => $index) {
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
                'approval_types' => 'ChangeProfessionRequest',
                'is_applicable_to_all' => $is_applicable_to_all,
                'employees_ids' => json_encode($selectedEmployees), // will be [] when not posted
                'approver' => json_encode($approvers),
                'status' => 'active',
                'type' => 'custom'
            ];
	
			// Update existing ChangeProfessionRequest records if 'is_applicable_to_all' is 'yes'
			if ($is_applicable_to_all === 'yes') {
				$this->db->where('approval_types', 'ChangeProfessionRequest');
				$this->db->update('request_approval', [
					'is_applicable_to_all' => 'no',
					'employees_ids' => json_encode([])
				]);
			}
	
			// Insert the new approval record
			if ($this->profession_model->insertApporval($insertData)) {
				echo json_encode(['status' => 'success', 'message' => 'Change profession cycles added successfully.']);
				return;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to add change profession cycles.']);
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
		$this->form_validation->set_rules('request_id', 'Request Id', 'required');
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
			$selectedEmployees = isset($data['selectedEmployees']) && !empty($data['selectedEmployees'])
                ? json_decode($data['selectedEmployees'], true)
                : [];
			$requestId = $data['request_id'];
			$professionDetail = $this->profession_model->getRequestById($requestId);

			// Prepare approver array
			$approvers = [];
            foreach ($data['approver_index'] as $key => $index) {
                if (!empty($data['approver_list'][$key])) {
                    $approvers[] = [
                        'approver_index' => $index,
                        'approver_type'  => $data['approver_type'][$key],
                        'approver_list'  => $data['approver_list'][$key]
                    ];
                }
            }

			// Determine type based on request_id
			$type = ($professionDetail->type == 'default') ? 'default' : 'custom';
	
			// Prepare data to update
			$professionData = [
				'name' => $data['name'],
				'approval_types' => 'ChangeProfessionRequest',
				'is_applicable_to_all' => $is_applicable_to_all,
				'approver' => json_encode($approvers),
				'status' => 'active',
				'type' => $type // Set type dynamically
			];

			// Update existing ChangeProfessionRequest records if 'is_applicable_to_all' is 'yes'
			if ($is_applicable_to_all === 'yes') {
				$this->db->query("UPDATE `request_approval` 
						SET `is_applicable_to_all` = 'no', 
							`employees_ids` = JSON_ARRAY() 
						WHERE `approval_types` = 'ChangeProfessionRequest'");
				$professionData['employees_ids'] = json_encode([]);
				$professionData['is_applicable_to_all'] = 'yes';
			}else{
				$professionData['employees_ids'] = json_encode($selectedEmployees);
    			$professionData['is_applicable_to_all'] = 'no';
			}
			// Update the specific change profession record
			if ($this->profession_model->updateApproval($requestId, $professionData)) {
				echo json_encode(['status' => 'success', 'message' => 'Change profession request approval cycles updated successfully.']);
				return;
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to update change profession approval cycles.']);
				return;
			}
		}
	}

	public function delete_approval() {
		$this->form_validation->set_rules('request_id', 'Request ID', 'required');
        $request_id = $this->input->post('request_id');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['status' => 'error', 'message' => 'Select alteast one row to delete.']);
			return;
        } else {
			$result = $this->profession_model->deleteApproval($request_id);
			if ($result) {
				echo json_encode(['status' => 'success', 'message' => 'Change profession approval deleted successfully.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Error deleting change profession approval.']);
			}
		}
    }
	
}
