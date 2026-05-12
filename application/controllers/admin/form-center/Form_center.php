<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Form_center extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/form-center/Form_center_model', 'formcenter_model');	
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');
			$this->action=$this->router->fetch_method();
		}		
		else{		
			redirect('admin');			
		}
	}

	public function index(){
		if($this->action && !check_action_permission(get_user_role(), 'form_center', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/form_center/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->formcenter_model->get_list(); 
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $item){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $item->id .'" name="check_list[]" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->document_no;
			$sub_array[] = $item->emp_no;
			$sub_array[] = $item->full_name;
			$sub_array[] = $item->iqama_no;
			$sub_array[] = $item->mobile;
			$sub_array[] = $item->designation_name;
			$sub_array[] = $item->department_name;
			$documentTypeMap = [
				'atm_handover' => 'ATM Card Handover Form',
				'sim_cancellation' => 'SIM Card Cancellation Form',
				'staff_exit_checklist' => 'Staff Exit Checklist',
				'salary_certificate' => 'Salary Certificate',
				'uniform_handover' => 'Asset Handover Form',
				'voluntary_resignation' => 'Acknowledgment of Voluntary Resignation',
				'warning_letter' => ucfirst($item->letter_type) .' Warning Letter',
				'employee_entitlements' => 'Employee Entitlements Schedule',
				'pledge_letter' => 'Pledge Letter',
				'probation_extension' => 'Extension of Probation Period',
				'experience_certificate' => 'Experience Certificate',
				'training_form' => 'Training Form',
				'grantor_form' => 'Guarantee the Payment Form',
				'resignation_letter' => 'Resignation Letter',
				'voluntary_payroll_deduction' => 'Voluntary Payroll Deduction Authorization Form',
			];
			$documentType = $item->document_type;
			$fullTitle = isset($documentTypeMap[$documentType]) ? $documentTypeMap[$documentType] : 'Unknown Document Type';

			$sub_array[] = htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8');
			$sub_array[] = ((isset($item->date_of_issue)) ? date('d-m-Y', strtotime($item->date_of_issue)) : '');
			$sub_array[] = (check_action_permission(get_user_role(), 'form_center', 'edit') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit form-edit-btn" data-toggle="tooltip" title="Edit" data-id="'.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></button>' : '').(check_action_permission(get_user_role(), 'form_center', 'detail') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit form-detail-btn" data-toggle="tooltip" title="Detail" data-id="'.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>' : '').(check_action_permission(get_user_role(), 'form_center', 'print_form_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print" href="'.base_url().'admin/form-center/print-detail?id='.$item->id.'" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>' : '');
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"            => intval($_POST["draw"]),  
			"recordsTotal"    => $this->formcenter_model->get_all_data(),  
			"recordsFiltered" => $this->formcenter_model->get_filtered_data(),  
			"data"            => $data  
		);  
		echo json_encode($output);
	}
	
	public function employee_list() {
		$search = $this->input->post('search');

		$this->db->select('me.id, me.emp_no, me.full_name as employee_name');
		$this->db->from('master_employee me');

		if (!empty($search)) {
			$this->db->group_start()
				->like('me.emp_no', $search)
				->or_like('me.full_name', $search)
			->group_end();
		}

		// status filter: Active OR Terminated
		$this->db->group_start()
			->where('me.status', 'Active')
			->or_where('me.status', 'Terminated')
		->group_end();

		$query = $this->db->get();
		$result = $query->result();

		$response = [];
		foreach ($result as $row) {
			$response[] = [
				'id' => $row->id,
				'employee_id' => $row->emp_no,
				'employee_name' => $row->employee_name
			];
		}

		echo json_encode($response);
	}

	public function create()
    {
		$this->form_validation->set_rules('search_employee', 'Employee ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$emp_no = $this->input->post('search_employee');
			$employee_data = searchEmployeeHelper($emp_no, 'all');
			if($employee_data['status']) {
				$output_data = $this->load->view('admin/form_center/partials/add',$employee_data,TRUE);
				$result = array("type"=>'success', "message"=>'Employee detail successfully fetched.', "output_html"=> $output_data);
			} else {
				$result = array("type"=>'error', "message"=>'Employee detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
    }

	public function store() {
		if($this->action && !check_action_permission(get_user_role(), 'form_center', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('date_of_issue', 'Date of Issue', 'required|callback_valid_date');
		$this->form_validation->set_rules('document_type', 'Document Type', 'required');
		
		// Get the document type
		$document_type = $this->input->post('document_type');
		
		// Apply conditional validation rules based on document type
		if ($document_type == 'atm_handover') {
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('atm_card_no', 'ATM Card No', 'required');
		} elseif ($document_type == 'sim_cancellation') {
			$this->form_validation->set_rules('sim_id', 'Select Sim Number', 'required');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
		} elseif ($document_type == 'voluntary_resignation') {
			$this->form_validation->set_rules('agency_name', 'Agency Name', 'required');
			$this->form_validation->set_rules('clearance_month', 'Clearance Month', 'required');
		} elseif ($document_type == 'probation_extension') {
			$this->form_validation->set_rules('start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('end_date', 'End Date', 'required');
		} elseif ($document_type == 'uniform_handover') {
			$uniform_items = $this->input->post('uniform_items');
			$uniform_quantities = $this->input->post('uniform_quantities');

			// Loop through uniform items and validate quantities
			if (!empty($uniform_items) && is_array($uniform_items)) {
				foreach ($uniform_items as $key => $item) {
					if (!empty($item)) {
						$this->form_validation->set_rules("uniform_quantities[$key]", "Quantity for $item", 'required|integer');
					}
				}
			}
		} elseif ($document_type == 'warning_letter') {
			$this->form_validation->set_rules('letter_type', 'Letter Type', 'required|callback_check_existing_letter');
		} elseif ($this->input->post('document_type') === 'grantor_form') { 
			$grantor_fields = $this->input->post('guarantor_name');
			$grantor_amounts = $this->input->post('amount');
			$due_amount = $this->input->post('due_amount');

			$this->form_validation->set_rules('due_amount', 'Due Amount', 'required|numeric|greater_than[0]');

			if (!empty($grantor_fields) && is_array($grantor_fields)) {
				foreach ($grantor_fields as $key => $guarantor_id) {
					$this->form_validation->set_rules(
						"guarantor_name[$key]",
						"Guarantor",
						'required|numeric'
					);
				}
			}

			if (!empty($grantor_amounts) && is_array($grantor_amounts)) {
				foreach ($grantor_amounts as $key => $amount) {
					$this->form_validation->set_rules(
						"amount[$key]",
						"Amount for Guarantor #" . ($key + 1),
						'required|numeric|greater_than[0]'
					);
				}
			}
			
			// ✅ Prevent duplicate guarantors
			if (!empty($grantor_fields) && is_array($grantor_fields)) {
				$duplicate_check = array_filter(array_count_values($grantor_fields), function($count) {
					return $count > 1;
				});

				if (!empty($duplicate_check)) {
					$result = array(
						'type' => 'error',
						'message' => 'Each guarantor can only be selected once. Duplicate guarantors found.'
					);
					echo json_encode($result);
					return;
				}
			}

			// ✅ Custom validation: Check if sum of guarantor amounts equals due amount
			$total_guarantor_amount = 0;
			if (!empty($grantor_amounts) && is_array($grantor_amounts)) {
				foreach ($grantor_amounts as $amt) {
					$total_guarantor_amount += (float)$amt;
				}
			}

			if ((float)$due_amount !== $total_guarantor_amount) {
				$result = array(
					'type' => 'error',
					'message' => 'The total of guarantor amounts (' . $total_guarantor_amount . ') must match the Due Amount (' . $due_amount . ').'
				);
				echo json_encode($result);
				return;
			}
		} elseif ($document_type == 'resignation_letter') {
			$this->form_validation->set_rules('last_working_date', 'Last Working Date', 'required');
		}
		
		// Check if form validation passed
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, return errors
			$result = array(
				'type' => 'error',
				'message' => validation_errors()
			);
			echo json_encode($result);
			return;
		}
		// Before assigning to $data
		$clearance_month = $this->input->post('clearance_month');

		// If user selected month, append day as 01
		if (!empty($clearance_month)) {
			$clearance_month = $clearance_month . '-01';
		}
		// Gather the form data
		$data = array(
			'employee_id'     => $this->input->post('employee_id'),
			'date_of_issue'   => $this->input->post('date_of_issue'),
			'document_type'   => $document_type,
			'bank_name'       => $this->input->post('bank_name'), 
			'atm_card_no'     => $this->input->post('atm_card_no'),
			'reason'          => $this->input->post('reason'),
			'sim_id'          => $this->input->post('sim_id'),
			'agency_name'     => $this->input->post('agency_name'),
			'clearance_month' => $clearance_month,
		);

		$data['other_details'] = null;
		
		if ($document_type === 'warning_letter') {
			$data['letter_type'] = $this->input->post('letter_type');
		}

		if ($document_type === 'probation_extension') {
			$secondary_data = array(
				'start_date' => $this->input->post('start_date'),
				'end_date'   => $this->input->post('end_date'),
			);
			$data['other_details'] = json_encode($secondary_data);
		}

		if ($document_type === 'resignation_letter') {
			$secondary_data = array(
				'last_working_date' => $this->input->post('last_working_date'),
			);
			$data['other_details'] = json_encode($secondary_data);
		}

		if ($document_type === 'training_form') {
			$emp_id = $data['employee_id'];
			// Fetch license details for the employee
			$licenceDetail = $this->db->query("SELECT * FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
		
			// Check if the query returned results
			if (!$licenceDetail) {
				$result = array('type' => 'error', 'message' => 'Employee licence detail not found. Please check the Employee ID.');
				echo json_encode($result);
				return;
			}
		
			// Fetch team details
			$this->db->select('id, name, ar_name, team_leader, team');
			$this->db->from('hunger_team');
			$this->db->where("JSON_CONTAINS(`team`, '\"$emp_id\"')", NULL, FALSE);
			$query = $this->db->get();
			$teamDetail = $query->row_array();
		
			// Validate driving license details
			if (empty($licenceDetail['driving_license_number'])) {
				$result = array('type' => 'error', 'message' => 'DL number missing, please update DL number first.');
				echo json_encode($result);
				return;
			}
		
			if (empty($licenceDetail['driving_license_issue_date']) || $licenceDetail['driving_license_issue_date'] === '0000-00-00') {
				$result = array('type' => 'error', 'message' => 'DL issue date missing, please update DL issue date first.');
				echo json_encode($result);
				return;
			}
		
			// Validate team details
			if (empty($teamDetail)) {
				$result = array('type' => 'error', 'message' => 'Team detail missing, please update team detail first.');
				echo json_encode($result);
				return;
			}
		}
		
		// Handle uniform items if document type is 'uniform_handover'
		if ($document_type == 'uniform_handover') {
			$uniform_data = array();

			// Combine items and quantities into an associative array
			foreach ($uniform_items as $key => $item) {
				$quantity = isset($uniform_quantities[$key]) ? $uniform_quantities[$key] : null;
				if (!empty($item) && !is_null($quantity)) {
					$uniform_data[] = array(
						'item_name' => $item,
						'quantity'  => $quantity,
					);
				}
			}
			
			// Encode the array as JSON and save it in the uniform_items column
			$data['uniform_items'] = json_encode($uniform_data);
		} else {
			$data['uniform_items'] = null;
		}

		// Handle guarantor data if the section is shown
		if ($document_type == 'grantor_form') {
			$due_amount = $this->input->post('due_amount');
			$grantor_fields = $this->input->post('guarantor_name');
			$grantor_amounts = $this->input->post('amount');

			if (!empty($grantor_fields) && is_array($grantor_fields) && !empty($grantor_amounts) && is_array($grantor_amounts)) {
				$guarantor_data = [];
				foreach ($grantor_fields as $key => $guarantor_id) {
					$amount = isset($grantor_amounts[$key]) ? $grantor_amounts[$key] : 0;
					if (!empty($guarantor_id) && $amount > 0) {
						$guarantor_data[] = [
							'guarantor_id' => $guarantor_id,
							'amount'       => (float)$amount
						];
					}
				}

				// Merge with existing other_details (like probation_extension)
				$other_details = [];
				if (!empty($data['other_details'])) {
					$other_details = json_decode($data['other_details'], true);
					if (!is_array($other_details)) $other_details = [];
				}

				// Add guarantors and due_amount
				$other_details['guarantors'] = $guarantor_data;
				$other_details['due_amount'] = !empty($due_amount) ? (float)$due_amount : 0;

				$data['other_details'] = json_encode($other_details);
			}
		}

		if ($document_type == 'staff_exit_checklist') {
			//Already Exist
			$query = $this->db->get_where('form_centers', array('employee_id' => $data['employee_id'], 'document_type' => 'staff_exit_checklist'));
			if ($query->num_rows() > 0) {
				$result = array("type" => 'error', "message" => 'Staff already exists in Staff Exit Checklist.');
				echo json_encode($result);
				return;
			}
			// Check vehicle
			$vehicleDetail = $this->Employee_model->getVehicleByUser($data['employee_id']);
			if ($vehicleDetail) {
				echo json_encode([
					"type" => 'error',
					"message" => 'Vehicle (#' . $vehicleDetail->vehicle_no . ') is alloted to this employee, Unallot first.'
				]);
				return;
			}

			// Check SIM
			$simDetail = $this->Employee_model->getSimByUser($data['employee_id']);
			if ($simDetail) {
				echo json_encode([
					"type" => 'error',
					"message" => 'SIM Card (#' . $simDetail->sim_no . ') is alloted to this employee, Unallot first.'
				]);
				return;
			}

			// Check aggregator
			$allotedAggregator = $this->Employee_model->getAggregatorId($data['employee_id']);
			if ($allotedAggregator && $allotedAggregator->allotment_status === '1') {
				echo json_encode([
					"type" => 'error',
					"message" => 'Rider ID (#' . $allotedAggregator->id_number . ') is alloted to this employee, Unallot Rider Id First.'
				]);
				return;
			}

			// Check DL status
			$dlStatus = $this->Employee_model->getDlStatus($data['employee_id']);
			if (
				$dlStatus &&
				!in_array($dlStatus->status, ['Cancelled', 'Completed']) &&
				!in_array($dlStatus->trans_status, ['0', '9'])
			) {
				echo json_encode([
					"type" => 'error',
					"message" => 'Rider applied for licence (#' . $dlStatus->request_no . '), cancel licence first.'
				]);
				return;
			}
		}

		// Prevent duplicate pledge_letter entry for same employee
		if ($document_type == 'pledge_letter') {
			$existing = $this->db
				->where('employee_id', $data['employee_id'])
				->where('document_type', 'pledge_letter')
				->get('form_centers')
				->row();

			if ($existing) {
				echo json_encode([
					"type" => 'error',
					"message" => 'This employee already has a Pledge Letter record.'
				]);
				return;
			}
		}
		
		// Save the form data in the database
		$this->load->model('formcenter_model');
		$insert_id = $this->formcenter_model->insert($data);
		
		if ($insert_id) {
			// Generate the document_no based on the inserted ID
			$document_no = 'DOC-' . str_pad($insert_id, 6, '0', STR_PAD_LEFT);
			// Update the record with the generated document_no
			$this->formcenter_model->update($insert_id, array('document_no' => $document_no));
			$result = array("type" => 'success', "message" => 'Form data saved successfully!');
		} else {
			$result = array("type" => 'error', "message" => 'Failed to save form data.');
		}
		
		echo json_encode($result);
	}

	public function edit()
    {
		if($this->action && !check_action_permission(get_user_role(), 'form_center', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$form_id = $this->input->post('id');
			$form_center = $this->formcenter_model->get_by_id($form_id);
			$emp_id = $form_center['employee_id'];
			if($emp_id > 0){
				$emp_no = $this->db->query("SELECT emp_no FROM master_employee WHERE id='". $emp_id ."'")->row()->emp_no;
				$result = array("type"=>'error', "message"=>$emp_no);
				$employee_data = searchEmployeeHelper($emp_no, 'all');
				if($employee_data['status']) {
					$data['employee_data'] = $employee_data;
					$output_data = $this->load->view('admin/form_center/partials/edit',compact('form_center','employee_data'),TRUE);
					$result = array("type"=>'success', "message"=>'Form detail successfully fetched.', "output_html"=> $output_data);
				} else {
					$result = array("type"=>'error', "message"=>'Form detail not found, try another form id.');
				}
			}else{
				$result = array("type"=>'error', "message"=>'Employee detail not found, try another form id.');
			}
		}
		echo json_encode($result);
    }

	public function update() {
		// Load form validation library
		$this->load->library('form_validation');
	
		// Set validation rules
		$this->form_validation->set_rules('id', 'Request ID', 'required');
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'required|integer');
		$this->form_validation->set_rules('document_type', 'Document Type', 'required');
		$this->form_validation->set_rules('date_of_issue', 'Date of Issue', 'required|callback_valid_date');
		
		// Get the document type
		$document_type = $this->input->post('document_type');
		
		// Apply conditional validation rules based on document type
		if ($document_type == 'atm_handover') {
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('atm_card_no', 'ATM Card No', 'required');
		} elseif ($document_type == 'sim_cancellation') {
			$this->form_validation->set_rules('sim_id', 'Select Sim Number', 'required');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
		} elseif ($document_type == 'voluntary_resignation') {
			$this->form_validation->set_rules('agency_name', 'Agency Name', 'required');
			$this->form_validation->set_rules('clearance_month', 'Clearance Month', 'required');
		} elseif ($document_type == 'probation_extension') {
			$this->form_validation->set_rules('start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('end_date', 'End Date', 'required');
		} elseif ($document_type == 'uniform_handover') {
			$uniform_items = $this->input->post('uniform_items');
			$uniform_quantities = $this->input->post('uniform_quantities');

			// Loop through uniform items and validate quantities
			if (!empty($uniform_items) && is_array($uniform_items)) {
				foreach ($uniform_items as $key => $item) {
					if (!empty($item)) {
						$this->form_validation->set_rules("uniform_quantities[$key]", "Quantity for $item", 'required|integer');
					}
				}
			}
		} elseif ($document_type == 'warning_letter') {
			$this->form_validation->set_rules('letter_type', 'Letter Type', 'required|callback_check_existing_letter');
		} elseif ($this->input->post('document_type') === 'grantor_form') { 
			$grantor_fields = $this->input->post('guarantor_name');
			$grantor_amounts = $this->input->post('amount');
			$due_amount = $this->input->post('due_amount');

			$this->form_validation->set_rules('due_amount', 'Due Amount', 'required|numeric|greater_than[0]');

			if (!empty($grantor_fields) && is_array($grantor_fields)) {
				foreach ($grantor_fields as $key => $guarantor_id) {
					$this->form_validation->set_rules(
						"guarantor_name[$key]",
						"Guarantor",
						'required|numeric'
					);
				}
			}

			if (!empty($grantor_amounts) && is_array($grantor_amounts)) {
				foreach ($grantor_amounts as $key => $amount) {
					$this->form_validation->set_rules(
						"amount[$key]",
						"Amount for Guarantor #" . ($key + 1),
						'required|numeric|greater_than[0]'
					);
				}
			}
			
			// ✅ Prevent duplicate guarantors
			if (!empty($grantor_fields) && is_array($grantor_fields)) {
				$duplicate_check = array_filter(array_count_values($grantor_fields), function($count) {
					return $count > 1;
				});

				if (!empty($duplicate_check)) {
					$result = array(
						'type' => 'error',
						'message' => 'Each guarantor can only be selected once. Duplicate guarantors found.'
					);
					echo json_encode($result);
					return;
				}
			}

			// ✅ Custom validation: Check if sum of guarantor amounts equals due amount
			$total_guarantor_amount = 0;
			if (!empty($grantor_amounts) && is_array($grantor_amounts)) {
				foreach ($grantor_amounts as $amt) {
					$total_guarantor_amount += (float)$amt;
				}
			}

			if ((float)$due_amount !== $total_guarantor_amount) {
				$result = array(
					'type' => 'error',
					'message' => 'The total of guarantor amounts (' . $total_guarantor_amount . ') must match the Due Amount (' . $due_amount . ').'
				);
				echo json_encode($result);
				return;
			}
		} elseif ($document_type == 'resignation_letter') {
			$this->form_validation->set_rules('last_working_date', 'Last Working Date', 'required');
		}
		// Check if form validation passed
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, return errors
			$result = array(
				'type' => 'error',
				'message' => validation_errors()
			);
			echo json_encode($result);
			return;
		} else {
			$id = $this->input->post('id');
			// Before assigning to $data
			$clearance_month = $this->input->post('clearance_month');

			// If user selected month, append day as 01
			if (!empty($clearance_month)) {
				$clearance_month = $clearance_month . '-01';
			}
			$data = array(
				'employee_id'    => $this->input->post('employee_id'),
				'date_of_issue'  => $this->input->post('date_of_issue'),
				'document_type'  => $this->input->post('document_type'),
				'bank_name'      => $this->input->post('bank_name'), 
				'atm_card_no'    => $this->input->post('atm_card_no'),
				'reason'         => $this->input->post('reason'),
				'sim_id'          => $this->input->post('sim_id'),
				'agency_name'    => $this->input->post('agency_name'),
				'clearance_month' => $clearance_month,
			);

			$data['other_details'] = null;

			if ($document_type === 'warning_letter') {
				$data['letter_type'] = $this->input->post('letter_type');
			}
			if ($document_type === 'training_form') {
				$emp_id = $data['employee_id'];
				// Fetch license details for the employee
				$licenceDetail = $this->db->query("SELECT * FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
			
				// Check if the query returned results
				if (!$licenceDetail) {
					$result = array('type' => 'error', 'message' => 'Employee licence detail not found. Please check the Employee ID.');
					echo json_encode($result);
					return;
				}
			
				// Fetch team details
				$this->db->select('id, name, ar_name, team_leader, team');
				$this->db->from('hunger_team');
				$this->db->where("JSON_CONTAINS(`team`, '\"$emp_id\"')", NULL, FALSE);
				$query = $this->db->get();
				$teamDetail = $query->row_array();
			
				// Validate driving license details
				if (empty($licenceDetail['driving_license_number'])) {
					$result = array('type' => 'error', 'message' => 'DL number missing, please update DL number first.');
					echo json_encode($result);
					return;
				}
			
				if (empty($licenceDetail['driving_license_issue_date']) || $licenceDetail['driving_license_issue_date'] === '0000-00-00') {
					$result = array('type' => 'error', 'message' => 'DL issue date missing, please update DL issue date first.');
					echo json_encode($result);
					return;
				}
			
				// Validate team details
				if (empty($teamDetail)) {
					$result = array('type' => 'error', 'message' => 'Team detail missing, please update team detail first.');
					echo json_encode($result);
					return;
				}
			}
			// Handle uniform items if document type is 'uniform_handover'
			if ($this->input->post('document_type') == 'uniform_handover') {
				$uniform_items = $this->input->post('uniform_items');
				$uniform_quantities = $this->input->post('uniform_quantities');
	
				// Combine items and quantities into an associative array
				$uniform_data = array();
				if (!empty($uniform_items)) {
					foreach ($uniform_items as $key => $item) {
						// Ensure quantity is not empty
						$quantity = isset($uniform_quantities[$key]) ? $uniform_quantities[$key] : '';
						$uniform_data[] = array(
							'item_name'   => $item,
							'quantity'    => $quantity,
						);
					}
				}
				// Encode the array as JSON and save it in the uniform_items column
				$data['uniform_items'] = json_encode($uniform_data);
			} else {
				// If not 'uniform_handover', ensure that the uniform_items column is empty
				$data['uniform_items'] = null;
			}

			// Handle guarantor data if the section is shown
			if ($document_type == 'grantor_form') {
				$due_amount = $this->input->post('due_amount');
				$grantor_fields = $this->input->post('guarantor_name');
				$grantor_amounts = $this->input->post('amount');

				if (!empty($grantor_fields) && is_array($grantor_fields) && !empty($grantor_amounts) && is_array($grantor_amounts)) {
					$guarantor_data = [];
					foreach ($grantor_fields as $key => $guarantor_id) {
						$amount = isset($grantor_amounts[$key]) ? $grantor_amounts[$key] : 0;
						if (!empty($guarantor_id) && $amount > 0) {
							$guarantor_data[] = [
								'guarantor_id' => $guarantor_id,
								'amount'       => (float)$amount
							];
						}
					}

					// Merge with existing other_details (like probation_extension)
					$other_details = [];
					if (!empty($data['other_details'])) {
						$other_details = json_decode($data['other_details'], true);
						if (!is_array($other_details)) $other_details = [];
					}

					// Add guarantors and due_amount
					$other_details['guarantors'] = $guarantor_data;
					$other_details['due_amount'] = !empty($due_amount) ? (float)$due_amount : 0;

					$data['other_details'] = json_encode($other_details);
				}
			}

			if ($document_type === 'resignation_letter') {
				$last_working_date = $this->input->post('last_working_date');
				$secondary_data = array(
					'last_working_date' => $last_working_date,
				);
				$data['other_details'] = json_encode($secondary_data);
			}

			if ($document_type == 'staff_exit_checklist') {
				//Already Exist
				$query = $this->db->get_where('form_centers', array('employee_id' => $data['employee_id'], 'document_type' => 'staff_exit_checklist'));
				if ($query->num_rows() > 0) {
					$result = array("type" => 'error', "message" => 'Staff already exists in Staff Exit Checklist.');
					echo json_encode($result);
					return;
				}
				// Check vehicle
				$vehicleDetail = $this->Employee_model->getVehicleByUser($data['employee_id']);
				if ($vehicleDetail) {
					echo json_encode([
						"type" => 'error',
						"message" => 'Vehicle (#' . $vehicleDetail->vehicle_no . ') is alloted to this employee, Unallot first.'
					]);
					return;
				}

				// Check SIM
				$simDetail = $this->Employee_model->getSimByUser($data['employee_id']);
				if ($simDetail) {
					echo json_encode([
						"type" => 'error',
						"message" => 'SIM Card (#' . $simDetail->sim_no . ') is alloted to this employee, Unallot first.'
					]);
					return;
				}

				// Check aggregator
				$allotedAggregator = $this->Employee_model->getAggregatorId($data['employee_id']);
				if ($allotedAggregator && $allotedAggregator->allotment_status === '1') {
					echo json_encode([
						"type" => 'error',
						"message" => 'Rider ID (#' . $allotedAggregator->id_number . ') is alloted to this employee, Unallot Rider Id First.'
					]);
					return;
				}

				// Check DL status
				$dlStatus = $this->Employee_model->getDlStatus($data['employee_id']);
				if (
					$dlStatus &&
					!in_array($dlStatus->status, ['Cancelled', 'Completed']) &&
					!in_array($dlStatus->trans_status, ['0', '9'])
				) {
					echo json_encode([
						"type" => 'error',
						"message" => 'Rider applied for licence (#' . $dlStatus->request_no . '), cancel licence first.'
					]);
					return;
				}
			}

			// Update the form data in the database
			$updated = $this->formcenter_model->update($id, $data);
	
			if ($updated) {
				$result = array("type" => 'success', "message" => 'Form successfully updated.');
			} else {
				$result = array("type" => 'error', "message" => 'Error updating form data.');
			}
		}
		echo json_encode($result);
	}
	
	// Custom validation callback for date_of_issue
	public function valid_date($date) {
		$today = date('Y-m-d');
		if ($date > $today) {
			$this->form_validation->set_message('valid_date', 'The {field} must be today or a past date.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	// Custom validation callback for letter_type
	public function check_existing_letter($letter_type) {
		$employee_id = $this->input->post('employee_id');
	
		// Check if the letter type has already been issued to the employee
		$this->db->where('employee_id', $employee_id);
		$this->db->where('letter_type', $letter_type);
		$this->db->where('document_type', 'warning_letter');
		$query = $this->db->get('form_centers');
	
		if ($query->num_rows() > 0) {
			// Letter has already been issued
			$this->form_validation->set_message('check_existing_letter', 'This warning letter has already been issued.');
			return FALSE;
		}
	
		// Check the sequence of warning letters
		$this->db->select('letter_type');
		$this->db->where('employee_id', $employee_id);
		$this->db->where('document_type', 'warning_letter');
		$this->db->order_by('date_of_issue', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('form_centers');
	
		$last_letter = $query->row_array();
	
		if ($last_letter) {
			// Check if the letter type is in sequence
			if ($letter_type === 'first' && $last_letter['letter_type'] !== null) {
				$this->form_validation->set_message('check_existing_letter', 'Previous warning letter(s) issued.');
				return FALSE;
			} elseif ($letter_type === 'second' && $last_letter['letter_type'] === 'final') {
				$this->form_validation->set_message('check_existing_letter', 'Cannot issue 2nd Warning Letter after Final Warning Letter.');
				return FALSE;
			} elseif ($letter_type === 'final' && $last_letter['letter_type'] !== 'second') {
				$this->form_validation->set_message('check_existing_letter', 'Final Warning Letter can only be issued after 2nd Warning Letter.');
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			if ($letter_type !== 'first') {
				$this->output->set_output(json_encode(array('type' => 'error', 'message' => '1st Warning Letter must be issued first.')));
			} else {
				return TRUE;
			}
		}
	}	

	public function check_warning_issued() {
		$employee_id = $this->input->post('employee_id');
		$letter_type = $this->input->post('letter_type');
	
		// Validate inputs
		if (empty($employee_id) || empty($letter_type)) {
			$response = array('type' => 'error', 'message' => 'Invalid input.');
			echo json_encode($response);
			return;
		}

		// Check if the letter type has already been issued to the employee
		$this->db->where('employee_id', $employee_id);
		$this->db->where('letter_type', $letter_type);
		$this->db->where('document_type', 'warning_letter');
		$query = $this->db->get('form_centers');
	
		if ($query->num_rows() > 0) {
			// Letter has already been issued
			$this->output->set_output(json_encode(array('type' => 'error', 'message' => 'This warning letter has already been issued.')));
			return;
		}
	
		// Check the sequence of warning letters
		$this->db->select('letter_type');
		$this->db->where('employee_id', $employee_id);
		$this->db->where('document_type', 'warning_letter');
		$this->db->order_by('date_of_issue', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get('form_centers');
	
		$last_letter = $query->row_array();
	
		if ($last_letter) {
			// Check if the letter type is in sequence
			if ($letter_type === 'first' && $last_letter['letter_type'] !== null) {
				$this->output->set_output(json_encode(array('type' => 'error', 'message' => 'Previous warning letter(s) issued.')));
			} elseif ($letter_type === 'second' && $last_letter['letter_type'] === 'final') {
				$this->output->set_output(json_encode(array('type' => 'error', 'message' => 'Cannot issue 2nd Warning Letter after Final Warning Letter.')));
			} elseif ($letter_type === 'final' && $last_letter['letter_type'] !== 'second') {
				$this->output->set_output(json_encode(array('type' => 'error', 'message' => 'Final Warning Letter can only be issued after 2nd Warning Letter.')));
			} else {
				$this->output->set_output(json_encode(array('type' => 'success')));
			}
		} else {
			if ($letter_type !== 'first') {
				$this->output->set_output(json_encode(array('type' => 'error', 'message' => '1st Warning Letter must be issued first.')));
			} else {
				$this->output->set_output(json_encode(array('type' => 'success')));
			}
		}
	}

	public function detail()
    {
		if($this->action && !check_action_permission(get_user_role(), 'form_center', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$form_id = $this->input->post('id');
			$form_center = $this->formcenter_model->get_by_id($form_id);
			$emp_id = $form_center['employee_id'];
			if($emp_id > 0){
				$emp_no = $this->db->query("SELECT emp_no FROM master_employee WHERE id='". $emp_id ."'")->row()->emp_no;
				$result = array("type"=>'error', "message"=>$emp_no);
				$employee_data = searchEmployeeHelper($emp_no, 'all');
				if($employee_data['status']) {
					$data['employee_data'] = $employee_data;
					$output_data = $this->load->view('admin/form_center/partials/detail',compact('form_center','employee_data'),TRUE);
					$result = array("type"=>'success', "message"=>'Form detail successfully fetched.', "output_html"=> $output_data);
				} else {
					$result = array("type"=>'error', "message"=>'Form detail not found, try another form id.');
				}
			}else{
				$result = array("type"=>'error', "message"=>'Employee detail not found, try another form id.');
			}
		}
		echo json_encode($result);
    }

	public function delete(){
		if($this->action && !check_action_permission(get_user_role(), 'form_center', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('check_list');
		if (!empty($ids)) {
			$id_list = implode(',', $ids);
			$query = $this->formcenter_model->delete($ids);
			if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		} else {
			$this->session->set_userdata('info', "2--No items selected for deletion.");
		}
		redirect('admin/form-center/list');
	}
	
	/*----- Print Start -----*/

	public function print_form_detail(){
		if($this->action && !check_action_permission(get_user_role(), 'form_center', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$form_center = $this->formcenter_model->get_by_id($id);
		$emp_id = $form_center['employee_id'];
		$doc_type = $form_center['document_type'];
		$letter_type = $form_center['letter_type'];
		$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		$data['issue_date'] = date('jS F Y', strtotime($form_center['date_of_issue']));
		if ($doc_type === 'uniform_handover' || $doc_type === 'staff_exit_checklist' || $doc_type === 'voluntary_payroll_deduction') {
			$class_name = 'Pdf_general_margin';
		} else {
			$class_name = 'Pdf_employee_offer';
		}
		$this->load->library($class_name);
	    
		//print_r($data['cv_detail']);exit();
		if($emp_id > 0){
			$emp_no = $this->db->query("SELECT emp_no FROM master_employee WHERE id='". $emp_id ."'")->row()->emp_no;
			$result = array("type"=>'error', "message"=>$emp_no);
			$employee_data = searchEmployeeHelper($emp_no, 'all');
			//dd($employee_data);
			if($employee_data['status']) {

				// create new PDF document
				$pdf = new $class_name(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Form Center');
				$pdf->SetSubject('BS - Form Center');
				$pdf->SetKeywords('Baqala Station, PDF, Form Center, Employee');
				
				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true); 
				if($doc_type !== 'training_form'){
					$htmlHeader = '';
					$htmlHeader2 = '';
				}else{
					$htmlHeader = $this->load->view('admin/form_center/print/training_form_header',$data, true);
					$htmlHeader2 = '';
				}
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);
				
				$lastFooter = '';
				$pdf->setHtmlFooter($lastFooter);
				// set header and footer fonts
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				// Conditional top margin setting
				if ($doc_type === 'training_form') {
					$pdf->SetMargins(5, 40, 8, true);
				} else {
					$pdf->SetMargins(10, 40, 11, true);
				}
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, 2);
				// set auto page breaks
				//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
					require_once(dirname(__FILE__).'/lang/eng.php');
					$pdf->setLanguageArray($l);
				}

				// ---------------------------------------------------------
				// add a page
				$pdf->AddPage();
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				if(($doc_type !== 'training_form') && ($doc_type !== 'grantor_form') && ($doc_type !== 'resignation_letter')){
					$pdf->SetFont('aealarabiya', '', 10);
				}else{
					$pdf->SetFont('helvetica', '', 10);
				}
				// Arabic and English content
				if($doc_type == 'atm_handover'){
					$htmlcontent = $this->load->view('admin/form_center/print/atm_handover',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'sim_cancellation'){
					$htmlcontent = $this->load->view('admin/form_center/print/sim_cancellation',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'employee_entitlements'){
					$htmlcontent = $this->load->view('admin/form_center/print/employee_entitlements',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'probation_extension'){
					$htmlcontent = $this->load->view('admin/form_center/print/probation_extension',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'experience_certificate'){
					//dd($employee_data);
					$htmlcontent = $this->load->view('admin/form_center/print/experience_certificate',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'salary_certificate'){
					//dd($employee_data);
					$htmlcontent = $this->load->view('admin/form_center/print/salary_certificate',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'training_form'){
					// Fetch team details along with the team leader's name
					$this->db->select('ht.name, ht.ar_name, ht.team_leader, ht.team, 
					me.emp_no AS leader_emp_no, me.full_name AS leader_full_name');
					$this->db->from('hunger_team ht');
					$this->db->join('master_employee me', 'ht.team_leader = me.id', 'left');
					$this->db->where("JSON_CONTAINS(ht.team, '\"$emp_id\"')", NULL, FALSE);
					$query = $this->db->get();
					$team_detail = $query->row_array();

					$htmlcontent = $this->load->view('admin/form_center/print/training_form',compact('form_center','employee_data', 'team_detail', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'uniform_handover'){
					$htmlcontent = $this->load->view('admin/form_center/print/uniform_handover-new',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'staff_exit_checklist'){
					$htmlcontent = $this->load->view('admin/form_center/print/staff_exit_checklist',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'pledge_letter'){
					$id_number = $this->db->query("SELECT id_number  FROM logistic_rider WHERE employee_id ='". $emp_id ."'")->row()->id_number;
					$htmlcontent = $this->load->view('admin/form_center/print/pledge_letter',compact('form_center','employee_data', 'data', 'id_number'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'voluntary_resignation'){
					// First page content
					$html = $this->load->view('admin/form_center/print/voluntary_resignation',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($html, true, 0, true, 0);

					// Second page content
					$pdf->AddPage();
					$html = $this->load->view('admin/form_center/print/undertaking_letter_for_voluntary_resignation',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($html, true, 0, true, 0);

					// Third page content
					$pdf->AddPage();
					$html = $this->load->view('admin/form_center/print/no_dues_certificate',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($html, true, 0, true, 0);

					// Forth page content
					$pdf->AddPage();
					$html = $this->load->view('admin/form_center/print/acknowledgment_of_voluntary_resignation',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($html, true, 0, true, 0);
				}
				elseif($doc_type == 'warning_letter'){
					if($letter_type == 'first'){
						$htmlcontent = $this->load->view('admin/form_center/print/first_warning_letter',compact('form_center','employee_data', 'data'),TRUE);
						$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
					}elseif($letter_type == 'second'){
						$htmlcontent = $this->load->view('admin/form_center/print/second_warning_letter',compact('form_center','employee_data', 'data'),TRUE);
						$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
					}elseif($letter_type == 'final'){
						$htmlcontent = $this->load->view('admin/form_center/print/third_warning_letter',compact('form_center','employee_data', 'data'),TRUE);
						$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
					}
				}
				elseif ($doc_type == 'grantor_form') {
					$other_details = json_decode($form_center['other_details'], true);
					$guarantors = isset($other_details['guarantors']) ? $other_details['guarantors'] : [];

					if (!empty($guarantors) && is_array($guarantors)) {
						foreach ($guarantors as $index => $guarantor) {

							// ✅ This contains guarantor-specific data (e.g. name, iqama, amount)
							$due_amount = $other_details['due_amount'] ?? 0;
							$guarantor_data = $guarantor;
							$guarantor_emp_no = $this->db->query("SELECT emp_no FROM master_employee WHERE id='". $guarantor['guarantor_id'] ."'")->row()->emp_no;
							$guarantor_detail = searchEmployeeHelper($guarantor_emp_no, 'all');
							//dd($guarantor_detail);
							if ($guarantor_detail['status']) {
								$guarantor_data['full_name'] = $guarantor_detail['emp_detail']['full_name'];
								$guarantor_data['emp_no'] = $guarantor_detail['emp_detail']['emp_no'];
								$guarantor_data['designation'] = $guarantor_detail['emp_detail']['designation_name'];
								$guarantor_data['department'] = $guarantor_detail['emp_detail']['department_name'];
								$guarantor_data['contact_no'] = $guarantor_detail['emp_detail']['mobile'];
								$guarantor_data['iqama_no'] = $guarantor_detail['emp_detail']['iqama_no'];
								$guarantor_data['nationality'] = $guarantor_detail['emp_detail']['nationality_name'];
							} else {
								$guarantor_data['full_name'] = 'N/A';
								$guarantor_data['emp_no'] = 'N/A';
								$guarantor_data['designation'] = 'N/A';
								$guarantor_data['department'] = 'N/A';
								$guarantor_data['contact_no'] = 'N/A';
								$guarantor_data['iqama_no'] = 'N/A';
								$guarantor_data['nationality'] = 'N/A';
							}

							// ✅ Load one common view for each guarantor
							$htmlcontent = $this->load->view(
								'admin/form_center/print/guarantor_letter',
								compact('form_center', 'employee_data', 'data', 'guarantor_data', 'due_amount'),
								TRUE
							);

							// Add a new page for each guarantor except the first
							if ($index > 0) {
								$pdf->AddPage();
							}

							$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
						}
					}
				}
				elseif($doc_type == 'voluntary_payroll_deduction'){
					$htmlcontent = $this->load->view('admin/form_center/print/voluntary_payroll_deduction',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				elseif($doc_type == 'resignation_letter'){
					$htmlcontent = $this->load->view('admin/form_center/print/resignation_letter',compact('form_center','employee_data', 'data'),TRUE);
					$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				}
				//Close and output PDF document
				$pdf->Output($doc_type.'_'. $form_center['document_no'] .'.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--Form detail not found, try another form id!");
				redirect('admin/form-center/list');
			}
		}else{
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/form-center/list');
		}
	}

	public function print_form_detail2(){
	    $this->load->library('Pdf_employee_offer');
		$id = $this->input->get('id');
		$form_center = $this->formcenter_model->get_by_id($id);
		$emp_id = $form_center['employee_id'];
		$doc_type = $form_center['document_type'];
		$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		//print_r($data['cv_detail']);exit();
		if($emp_id > 0){
			$emp_no = $this->db->query("SELECT emp_no FROM master_employee WHERE id='". $emp_id ."'")->row()->emp_no;
			$result = array("type"=>'error', "message"=>$emp_no);
			$employee_data = searchEmployeeHelper($emp_no, 'all');
			if($employee_data['status']) {
				// create new PDF document
				$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Form Center');
				$pdf->SetSubject('BS - Form Center');
				$pdf->SetKeywords('Baqala Station, PDF, Form Center, Employee');
				
				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true); 
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);
				
				$lastFooter = '';
				$pdf->setHtmlFooter($lastFooter);
				// set header and footer fonts
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetMargins(10, 40, 11, true);
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, 2);
				// set auto page breaks
				//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
					require_once(dirname(__FILE__).'/lang/eng.php');
					$pdf->setLanguageArray($l);
				}

				// ---------------------------------------------------------
				// add a page
				$pdf->AddPage();
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				//$pdf->SetFont('aealarabiya', '', 10);
				$pdf->SetFont('dejavusans', '', 8);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/form_center/print/payment_request_form',compact('form_center','employee_data', 'data'),TRUE);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output($doc_type.'_'. $form_center['document_no'] .'.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--Form detail not found, try another form id!");
				redirect('admin/form-center/list');
			}
		}else{
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/form-center/list');
		}
	}

}
