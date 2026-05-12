<?php defined('BASEPATH') or exit('No direct script access allowed');

class Property extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/facility-management/Property_model', 'property_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->action = $this->router->fetch_method();
			if ($this->action && !check_action_permission(get_user_role(), 'property_list', $this->action) && !in_array($this->action, ['get_list', 'save_property', 'update_property'])):
				redirect('admin/unauthorized-request');
			endif;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'facilities_properties'
		])->row();
		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		$this->load->view('admin/facility-management/property/index', $data);
	}

	public function get_list()
	{
		$search = $this->input->post('search')['value'] ?? '';
		$perPage = $this->input->post('length') ?? 50;
		$start = $this->input->post('start') ?? 0;

		$keyword = $this->input->get('keyword') ?? false;
		$property_type = $this->input->get('property_type') ?? false;
		$property_city = $this->input->get('property_city') ?? false;
		$property_status = $this->input->get('property_status') ?? false;
		$ejar_start_date = $this->input->get('ejar_start_date') ?? false;
		$ejar_end_date = $this->input->get('ejar_end_date') ?? false;
		$filterStatus = $this->input->get('filter_status') ?? false;

		// Fetch user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'facilities_properties'
		])->row();

		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		// Get data from model
		$fetch_data = $this->property_model->propertyList(
			$keyword,
			$property_type,
			$property_city,
			$property_status,
			$ejar_start_date,
			$ejar_end_date,
			$filterStatus,
			$perPage,
			$start
		);

		$i = $start + 1;
		$data = [];

		// Columns to exclude from visible table
		$excludedColumns = ['id'];
		$visibleColumns = array_values(array_filter($visibleColumns, function ($col) use ($excludedColumns) {
			return !in_array($col, $excludedColumns);
		}));

		foreach ($fetch_data['data'] as $property) {
			$sub_array = [];
			$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $property['id'] . '" />';
			$sub_array[] = $i++; // Sr No.

			foreach ($visibleColumns as $colKey) {
				switch ($colKey) {
					case 'property_status':
						$status = ucfirst($property[$colKey] ?? '');
						$badge = ($status == 'Active')
							? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>'
							: '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
						$sub_array[] = $badge;
						break;

					default:
						$value = $property[$colKey] ?? '';
						if ((stripos($colKey, 'date') !== false || stripos($colKey, 'created_at') !== false) && strtotime($value)) {
							$value = date('d-m-Y', strtotime($value));
						}
						// Handle attach_ejar_contract as a View link
						elseif ($colKey === 'attach_ejar_contract' && !empty($value)) {
							$fileUrl = base_url($value);
							$value = '<a href="javascript:void(0);" onclick="window.open(\'' . $fileUrl . '\', \'_blank\', \'width=1000,height=800\');" class="text-danger"><b>View Contract</b></a>';
						}
						$sub_array[] = $value;
						break;
				}
			}

			// Actions
			$sub_array[] = '<div class="btn-group ms-2 float-end">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i></button>
				<div class="dropdown-menu dropdown-menu-end">'
				. (check_action_permission(get_user_role(), 'property_list', 'edit') ? '<a class="dropdown-item" href="' . base_url('admin/facility-management/property/edit/' . $property['id']) . '"><i class="mdi mdi-pencil me-2"></i> Edit</a>' : '')
				. (check_action_permission(get_user_role(), 'property_list', 'view') ? '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/facility-management/property/detail/' . $property['id']) . '"><i class="mdi mdi-eye me-2"></i> View</a>' : '')
				. '</div></div>';

			$data[] = $sub_array;
		}

		echo json_encode([
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $fetch_data['pagination']['total'],
			"recordsFiltered" => $fetch_data['pagination']['total'],
			"data" => $data
		]);
	}

	public function add()
	{
		$last_property = $this->db->query("SELECT id FROM facilities_properties ORDER BY id DESC LIMIT 1")->row();
		$last_id = $last_property ? $last_property->id : 0;
		$data['property_no'] = 'H' . str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);
		$this->load->view('admin/facility-management/property/add', $data);
	}

	public function save_property()
	{
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('property_number', 'Property Number', 'required');
			$this->form_validation->set_rules('property_name', 'Property Name', 'required');
			$this->form_validation->set_rules('property_type', 'Property Type', 'required');
			$this->form_validation->set_rules('property_city', 'Property City', 'required');
			$this->form_validation->set_rules('property_status', 'Property Status', 'required');
			$this->form_validation->set_rules('ejar_contract_number', 'Ejar Contract Number', 'required');

			if ($this->form_validation->run() == FALSE) {
				echo json_encode(['status' => 'error', 'message' => validation_errors()]);
				return;
			}

			$last_property = $this->db->query("SELECT id FROM facilities_properties ORDER BY id DESC LIMIT 1")->row();
			$last_id = $last_property ? $last_property->id : 0;
			$property_no = 'H' . str_pad($last_id + 1, 4, '0', STR_PAD_LEFT);

			$data = [
				'property_number' => $property_no,
				'property_name' => $this->input->post('property_name', true),
				'property_type' => $this->input->post('property_type', true),
				'property_city' => $this->input->post('property_city', true),
				'property_status' => $this->input->post('property_status', true),
				'tenant_company_id' => $this->input->post('tenant_company_id', true),
				'brokerage_entity_name' => $this->input->post('brokerage_entity_name', true),
				'brokerage_entity_address' => $this->input->post('brokerage_entity_address', true),
				'brokerage_landline_no' => $this->input->post('brokerage_landline_no', true),
				'brokerage_cr_no' => $this->input->post('brokerage_cr_no', true),
				'brokerage_vat_no' => $this->input->post('brokerage_vat_no', true),
				'broker_name' => $this->input->post('broker_name', true),
				'broker_nationality' => $this->input->post('broker_nationality', true),
				'broker_id_no' => $this->input->post('broker_id_no', true),
				'broker_person' => $this->input->post('broker_person', true),
				'broker_mobile_no' => $this->input->post('broker_mobile_no', true),
				'broker_email_id' => $this->input->post('broker_email_id', true),
				'account_name' => $this->input->post('account_name', true),
				'bank_name' => $this->input->post('bank_name', true),
				'iban' => $this->input->post('iban', true),
				'ejar_contract_number' => $this->input->post('ejar_contract_number', true),
				'ejar_contract_start_date' => $this->input->post('ejar_contract_start_date', true),
				'ejar_contract_end_date' => $this->input->post('ejar_contract_end_date', true),
				'created_at' => date('Y-m-d H:i:s'),
			];

			if (!empty($_FILES['attach_ejar_contract']['name'])) {
				$config['upload_path'] = './uploads/ejar_contracts/';
				$config['allowed_types'] = 'pdf|doc|docx|xlsx|xls';
				$config['max_filename'] = '50';
				$config['encrypt_name'] = TRUE;
				$config['max_size'] = 2048;
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('attach_ejar_contract')) {
					echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
					return;
				} else {
					$upload_data = $this->upload->data();
					$data['attach_ejar_contract'] = 'uploads/ejar_contracts/' . $upload_data['file_name'];
				}
			}

			$this->db->trans_begin(); // 🔁 Start Transaction

			$property_id = $this->property_model->save_property($data);

			if (!$property_id) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to save property.']);
				return;
			}

			// ===== Save Rent Payment Table =====
			$rent_values     = $this->input->post('rent_value');
			$vats            = $this->input->post('vat');
			$services        = $this->input->post('service');
			$total_values    = $this->input->post('total_value');
			$issue_dates_g   = $this->input->post('issue_date_g');
			$due_dates_g     = $this->input->post('due_date_g');
			$issue_dates_h   = $this->input->post('issue_date_h');
			$due_dates_h     = $this->input->post('due_date_h');

			if ($rent_values && is_array($rent_values)) {
				foreach ($rent_values as $index => $rent) {
					$rentRow = array(
						'property_id'       => $property_id,
						'rent_value'        => $rent ?? 0,
						'vat'               => $vats[$index] ?? 0,
						'service'           => $services[$index] ?? 0,
						'total_value'       => $total_values[$index] ?? 0,
						'issue_date_g'      => $issue_dates_g[$index] ?? null,
						'due_date_g'        => $due_dates_g[$index] ?? null,
						'issue_date_h'      => $issue_dates_h[$index] ?? null,
						'due_date_h'        => $due_dates_h[$index] ?? null,
					);

					// Insert each rent row
					$this->db->insert('rent_payment_schedule', $rentRow);
					$rent_id = $this->db->insert_id();

					if (!$rent_id) {
						$this->db->trans_rollback();
						echo json_encode(['status' => 'error', 'message' => 'Failed to save rent payment.']);
						return;
					}
				}
			}

			$utilities = $this->input->post('utility');
			foreach ($utilities as $util) {
				$this->db->insert('rent_utilities', array(
					'property_id' => $property_id,
					'water' => $util['water'],
					'electricity' => $util['electricity']
				));
				if ($this->db->affected_rows() == 0) {
					$this->db->trans_rollback();
					echo json_encode(['status' => 'error', 'message' => 'Failed to save utilities.']);
					return;
				}
			}

			$facilities = $this->input->post('facility');
			foreach ($facilities as $f) {
				$this->db->insert('rent_facilities', array(
					'property_id' => $property_id,
					'floors' => $f['floors'],
					'rooms' => $f['rooms'],
					'kitchen' => $f['kitchen'],
					'parking' => $f['parking'],
					'elevators' => $f['elevators']
				));
				if ($this->db->affected_rows() == 0) {
					$this->db->trans_rollback();
					echo json_encode(['status' => 'error', 'message' => 'Failed to save facilities.']);
					return;
				}
			}

			$this->db->trans_commit(); // ✅ All good, commit

			echo json_encode([
				'status' => 'success',
				'message' => 'Property saved successfully.',
				'id' => $property_id
			]);
		}
	}

	public function edit($id)
	{
		$data['property'] = $this->property_model->get_by_id($id);
		//dd($data['property']);
		if (!$data['property']) {
			$this->session->set_userdata('info', "2--Property not found.");
			redirect('admin/facility-management/property/list');
		}
		$data['rent_payments'] = $this->property_model->get_full_rent_details($id);
		// Helper data for dropdowns
		$data['cities'] = selectedCitiesHelp(6);
		$data['sponsors'] = sponsorsHelper();
		$data['nationalities'] = nationalityList();
		$data['banks'] = bankList();

		$this->load->view('admin/facility-management/property/edit', $data);
	}

	public function update_property()
	{
		//dd($this->input->post());
		if ($this->input->is_ajax_request()) {

			// Set validation rules
			$this->form_validation->set_rules('property_number', 'Property Number', 'required');
			$this->form_validation->set_rules('property_name', 'Property Name', 'required');
			$this->form_validation->set_rules('property_type', 'Property Type', 'required');
			$this->form_validation->set_rules('property_city', 'Property City', 'required');
			$this->form_validation->set_rules('property_status', 'Property Status', 'required');
			$this->form_validation->set_rules('ejar_contract_number', 'Ejar Contract Number', 'required');

			if ($this->form_validation->run() === FALSE) {
				echo json_encode(['status' => 'error', 'message' => validation_errors()]);
				return;
			}

			// Collect data
			$property_id = $this->input->post('property_id', true);
			$data = [
				'property_name'              => $this->input->post('property_name', true),
				'property_type'              => $this->input->post('property_type', true),
				'property_city'              => $this->input->post('property_city', true),
				'property_status'            => $this->input->post('property_status', true),
				'tenant_company_id'          => $this->input->post('tenant_company_id', true),

				// Brokerage Info
				'brokerage_entity_name'      => $this->input->post('brokerage_entity_name', true),
				'brokerage_entity_address'   => $this->input->post('brokerage_entity_address', true),
				'brokerage_landline_no'      => $this->input->post('brokerage_landline_no', true),
				'brokerage_cr_no'            => $this->input->post('brokerage_cr_no', true),
				'brokerage_vat_no'           => $this->input->post('brokerage_vat_no', true),
				'broker_name'                => $this->input->post('broker_name', true),
				'broker_nationality'         => $this->input->post('broker_nationality', true),
				'broker_id_no'               => $this->input->post('broker_id_no', true),
				'broker_person'              => $this->input->post('broker_person', true),
				'broker_mobile_no'           => $this->input->post('broker_mobile_no', true),
				'broker_email_id'            => $this->input->post('broker_email_id', true),

				// Bank Info
				'account_name'               => $this->input->post('account_name', true),
				'bank_name'                  => $this->input->post('bank_name', true),
				'iban'                       => $this->input->post('iban', true),

				// Ejar Info
				'ejar_contract_number'       => $this->input->post('ejar_contract_number', true),
				'ejar_contract_start_date'   => $this->input->post('ejar_contract_start_date', true),
				'ejar_contract_end_date'     => $this->input->post('ejar_contract_end_date', true),
				'updated_at'                 => date('Y-m-d H:i:s'),
			];

			// Handle ejar contract upload if file exists
			if (!empty($_FILES['attach_ejar_contract']['name'])) {
				$config = [
					'upload_path'   => './uploads/ejar_contracts/',
					'allowed_types' => 'pdf|doc|docx|xlsx|xls',
					'max_size'      => 2048, // 2MB
					'encrypt_name'  => true
				];

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('attach_ejar_contract')) {
					echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
					return;
				} else {
					$upload_data = $this->upload->data();
					$data['attach_ejar_contract'] = 'uploads/ejar_contracts/' . $upload_data['file_name'];
				}
			}

			// Perform the update
			$this->db->trans_begin();

			$updated = $this->property_model->update($property_id, $data);
			if (!$updated) {
				$this->db->trans_rollback();
				echo json_encode(['status' => 'error', 'message' => 'Failed to update property.']);
				return;
			}

			// Step 2: Delete old rent payments
			$this->db->where('property_id', $property_id);
			$this->db->delete('rent_payment_schedule');

			// Step 3: Insert new rent payments
			$rent_values     = $this->input->post('rent_value');
			$vats            = $this->input->post('vat');
			$services        = $this->input->post('service');
			$total_values    = $this->input->post('total_value');
			$issue_dates_g   = $this->input->post('issue_date_g');
			$due_dates_g     = $this->input->post('due_date_g');
			$issue_dates_h   = $this->input->post('issue_date_h');
			$due_dates_h     = $this->input->post('due_date_h');

			if ($rent_values && is_array($rent_values)) {
				foreach ($rent_values as $index => $rent) {
					$rentRow = array(
						'property_id'       => $property_id,
						'rent_value'        => $rent,
						'vat'               => $vats[$index] ?? 0,
						'service'           => $services[$index] ?? 0,
						'total_value'       => $total_values[$index] ?? 0,
						'issue_date_g'      => $issue_dates_g[$index] ?? null,
						'due_date_g'        => $due_dates_g[$index] ?? null,
						'issue_date_h'      => $issue_dates_h[$index] ?? null,
						'due_date_h'        => $due_dates_h[$index] ?? null,
					);

					$this->db->insert('rent_payment_schedule', $rentRow);
					$rent_id = $this->db->insert_id();

					if (!$rent_id) {
						$this->db->trans_rollback();
						echo json_encode(['status' => 'error', 'message' => 'Failed to update rent payment.']);
						return;
					}
				}
			}
			// Delete old and insert new utilities
			$this->db->where('property_id', $property_id)->delete('rent_utilities');
			$utilities = $this->input->post('utility');
			foreach ($utilities as $util) {
				$this->db->insert('rent_utilities', [
					'property_id'    => $property_id,
					'water'      => $util['water'],
					'electricity' => $util['electricity']
				]);
			}

			// Delete old and insert new facilities
			$this->db->where('property_id', $property_id)->delete('rent_facilities');
			$facilities = $this->input->post('facility');
			foreach ($facilities as $f) {
				$this->db->insert('rent_facilities', [
					'property_id' => $property_id,
					'floors'     => $f['floors'],
					'rooms'      => $f['rooms'],
					'kitchen'    => $f['kitchen'],
					'parking'    => $f['parking'],
					'elevators'  => $f['elevators']
				]);
			}

			$this->db->trans_commit();

			echo json_encode([
				'status'  => 'success',
				'message' => 'Property updated successfully.',
				'id'      => $property_id
			]);
		}
	}

	public function view($id)
	{
		$data['property'] = $this->property_model->get_by_id($id);
		//dd($data['property']);
		if (!$data['property']) {
			$this->session->set_userdata('info', "2--Property not found.");
			redirect('admin/facility-management/property/list');
		}
		$data['rent_payments'] = $this->property_model->get_full_rent_details($id);
		// Helper data for dropdowns
		$data['cities'] = selectedCitiesHelp(6);
		$data['sponsors'] = sponsorsHelper();
		$data['nationalities'] = nationalityList();
		$data['banks'] = bankList();

		$this->load->view('admin/facility-management/property/detail', $data);
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->property_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/facility-management/property/list');
	}
	
	/*------- Start Bedding Management -------*/
	public function bedding_list()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/facility-management/beddings/index', $data);
	}

	public function get_bedding_ajax_list()
	{
		$fetch_data = $this->property_model->get_bedding_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $item->id . '" name="checklist[]" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->property_name;
			$sub_array[] = ucfirst($item->floor);
			$sub_array[] = $item->unit_type;
			$sub_array[] = $item->unit_room_no;
			$sub_array[] = $item->bed_type;
			$sub_array[] = $item->bed_capacity;
			$sub_array[] = $item->labour_capacity;
			$sub_array[] = $item->created_at;
			$actionDropdown = '<div class="btn-group ms-2">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">';

			$actionDropdown .= '<a class="dropdown-item" href="javascript:void(0);" onclick="editModal(' . $item->id . ')">
						<i class="mdi mdi-pencil me-2"></i> Edit</a>';
			$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0);" onclick="detailModal(' . $item->id . ')">
						<i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail</a>';

			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->property_model->get_all_bedding_data(),
			"recordsFiltered" => $this->property_model->get_bedding_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add_bedding()
	{
		$data['properties'] = $this->property_model->get_all();
		return $this->load->view('admin/facility-management/beddings/components/add-form', $data);
	}

	public function store_bedding()
	{
		// Validation rules
		$this->form_validation->set_rules('property_id', 'Select Property', 'required');
		$this->form_validation->set_rules('floor', 'Select Floor', 'required');
		$this->form_validation->set_rules('unit_type', 'Unit Type', 'required');
		$this->form_validation->set_rules('unit_room_no', 'Unit/Room No', 'required');
		$this->form_validation->set_rules('bed_type', 'Bed Type', 'required');
		$this->form_validation->set_rules('bed_capacity', 'Bed Capacity', 'required');

		if ($this->form_validation->run() == FALSE) {
			$result = array(
				'type' => 'error',
				'message' => strip_tags(validation_errors())
			);
			echo json_encode($result);
			return;
		}

		$property_id  = $this->input->post('property_id');
		$floor        = $this->input->post('floor');
		$unit_type    = $this->input->post('unit_type');
		$unit_room_no = $this->input->post('unit_room_no');

		// ✅ Check for duplicate
		$exists = $this->db->where([
			'property_id'  => $property_id,
			'floor'        => $floor,
			'unit_type'    => $unit_type,
			'unit_room_no' => $unit_room_no
		])->get('facility_room_bedding')->num_rows();

		if ($exists > 0) {
			$result = array("type" => 'error', "message" => 'This Unit/Room No already exists for the selected property, floor, and unit type.');
			echo json_encode($result);
			return;
		}

		// ✅ Insert data
		$data = array(
			'property_id'     => $property_id,
			'floor'           => $floor,
			'unit_type'       => $unit_type,
			'unit_room_no'    => $unit_room_no,
			'bed_type'        => $this->input->post('bed_type'),
			'bed_capacity'    => $this->input->post('bed_capacity'),
			'labour_capacity' => $this->input->post('labour_capacity')
		);

		$insert_id = $this->property_model->save_bedding($data);
		if ($insert_id) {
			$result = array("type" => 'success', "message" => 'Bedding has been added successfully.');
		} else {
			$result = array("type" => 'error', "message" => 'There was an error adding the bedding.');
		}
		echo json_encode($result);
	}

	public function edit_bedding($id)
	{
		$bedding_detail = $this->property_model->get_bedding_by_id($id);
		//dd($bedding_detail);
		if ($bedding_detail) {
			$data['bedding']    = $bedding_detail;
			$data['properties'] = $this->property_model->get_all();
			return $this->load->view('admin/facility-management/beddings/components/edit-form', $data);
		} else {
			show_404();
		}
	}

	public function update_bedding()
	{
		$this->form_validation->set_rules('property_id', 'Select Property', 'required');
		$this->form_validation->set_rules('floor', 'Select Floor', 'required');
		$this->form_validation->set_rules('unit_type', 'Unit Type', 'required');
		$this->form_validation->set_rules('unit_room_no', 'Unit/Room No', 'required');
		$this->form_validation->set_rules('bed_type', 'Bed Type', 'required');
		$this->form_validation->set_rules('bed_capacity', 'Bed Capacity', 'required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				'type' => 'error',
				'message' => strip_tags(validation_errors())
			]);
			return;
		}

		$id           = $this->input->post('id'); // hidden field
		$property_id  = $this->input->post('property_id');
		$floor        = $this->input->post('floor');
		$unit_type    = $this->input->post('unit_type');
		$unit_room_no = $this->input->post('unit_room_no');

		// ✅ Duplicate check (exclude current record)
		$exists = $this->db->where([
			'property_id'  => $property_id,
			'floor'        => $floor,
			'unit_type'    => $unit_type,
			'unit_room_no' => $unit_room_no
		])->where('id !=', $id)
		->get('facility_room_bedding')
		->num_rows();

		if ($exists > 0) {
			echo json_encode([
				"type" => 'error',
				"message" => 'This Unit/Room No already exists for the selected property, floor, and unit type.'
			]);
			return;
		}

		$data = [
			'property_id'     => $property_id,
			'floor'           => $floor,
			'unit_type'       => $unit_type,
			'unit_room_no'    => $unit_room_no,
			'bed_type'        => $this->input->post('bed_type'),
			'bed_capacity'    => $this->input->post('bed_capacity'),
			'labour_capacity' => $this->input->post('labour_capacity'),
			'updated_at'      => date('Y-m-d H:i:s')
		];

		$updated = $this->property_model->update_bedding($id, $data);

		if ($updated) {
			echo json_encode(["type" => 'success', "message" => 'Bedding updated successfully.']);
		} else {
			echo json_encode(["type" => 'error', "message" => 'No changes made or update failed.']);
		}
	}

	public function bedding_detail($id)
	{
		$bedding_detail = $this->property_model->get_bedding_by_id($id);
		//dd($bedding_detail);
		if ($bedding_detail) {
			$data['bedding']    = $bedding_detail;
			$data['properties'] = $this->property_model->get_all();
			return $this->load->view('admin/facility-management/beddings/components/detail', $data);
		} else {
			show_404();
		}
	}

	public function get_floors_by_property()
	{
		$property_id = $this->input->post('property_id');
		$facilities = $this->property_model->get_floors_by_property($property_id);

		$options = '<option value="">Select Floor</option>';
		if (!empty($facilities)) {
			foreach ($facilities as $facility) {
				$floor = $facility['floors'];
				$options .= '<option value="' . $floor . '">' . $floor . '</option>';
			}
		}else{
			$options .= '<option value="">No Floors Available</option>';
		}
		echo $options;
	}

	public function get_units_by_floor() {
		$property_id = $this->input->post('property_id');
		$floor = $this->input->post('floor');
		
		$facility = $this->property_model->get_units_by_floor($property_id, $floor);

		$options = '<option value="">Select Units</option>';

		if (!empty($facility)) {
			if (!empty($facility['rooms']) && $facility['rooms'] > 0) {
				$options .= '<option value="rooms">Room</option>';
			}
			if (!empty($facility['kitchen']) && $facility['kitchen'] > 0) {
				$options .= '<option value="kitchen">Kitchen</option>';
			}
		} else {
			$options .= '<option value="">No Units Available</option>';
		}

		echo $options;
	}

	public function delete_beddings()
	{
		$ids = $this->input->post('checklist');
		$query = $this->property_model->delete_beddings($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/facility-management/bedding/list');
	}
}
