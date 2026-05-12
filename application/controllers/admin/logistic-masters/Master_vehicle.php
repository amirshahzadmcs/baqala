<?php defined('BASEPATH') or exit('No direct script access allowed');

class Master_vehicle extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-masters/Master_vehicle_model');
			$this->load->model('admin/masters/InsurancePolicies_model', 'policy_model');
			$this->load->model('admin/masters/Sponsor_model');
			$this->load->library(['form_validation', 'upload']);
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
			$this->load->library('zip');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['sponsors'] = $this->Sponsor_model->get_all_sponsors(); 
		$data['search'] = '';
		$data['perPage'] = 50;

		// ✅ Load user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'vehicles'
		])->row();

		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		$this->load->view('admin/logistic-masters/master-vehicle/list', $data);
	}

	public function get_list()
	{
		$search      = $this->input->post('search')['value'] ?? $this->input->post('keyword') ?? '';
		$perPage     = intval($this->input->post('length') ?? 50);
		$start       = intval($this->input->post('start') ?? 0);

		// Get filters from URL (JSON)
		$filters = json_decode($this->input->get('filters'), true) ?? [];

		// Fallback if filters empty
		if (empty($filters)) {
			$filters = $this->input->get() ?? [];
		}

		// Add search keyword to filters
		if (!empty($search)) {
			$filters['keyword'] = $search;
		}

		// Fetch updated list with pagination and visible columns
		$fetch_data = $this->Master_vehicle_model->list(
			$filters,
			$perPage,
			$start,
		);

		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $item) {
			$sub_array = [];
			// Checkbox
			$sub_array[] = '<input type="checkbox" class="checkbox" name="check_list[]" value="' . $item['id'] . '" />';
			// S.No.
			$sub_array[] = $i++;

			// Loop through visible columns
			foreach ($fetch_data['visible_columns'] as $column) {
				// Skip ID
				if ($column == 'id') continue;
				$value = $item[$column] ?? '';
				// FORMAT: Vehicle Number Plate
				if ($column == 'vehicle_no') {
					$sub_array[] = formatVehiclePlate($value);
					continue;
				}
				// FORMAT: Allotment Status Badge
				if ($column == 'allotment_status') {
					switch ($value) {
						case 'alloted':
							$badge = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
							break;
						case 'unalloted':
							$badge = '<span class="badge badge-pill badge-soft-primary font-size-13">Unalloted</span>';
							break;
						case 'return':
							$badge = '<span class="badge badge-pill badge-soft-danger font-size-13">Return</span>';
							break;
						default:
							$badge = '<span class="badge badge-pill badge-soft-secondary font-size-13">None</span>';
					}
					$sub_array[] = $badge;
					continue;
				}
				// FORMAT: Status Badge
				if ($column == 'status') {
					switch ($value) {
						case 'active':
							$badge = '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
							break;
						case 'inactive':
							$badge = '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
							break;
						case 'discontinued':
							$badge = '<span class="badge badge-pill badge-soft-warning font-size-13">Discontinued</span>';
							break;
						case 'workshop':
							$badge = '<span class="badge badge-pill badge-soft-info font-size-13">Workshop</span>';
							break;
						default:
							$badge = '<span class="badge badge-pill badge-soft-secondary font-size-13">Unknown</span>';
					}
					$sub_array[] = $badge;
					continue;
				}
				// FORMAT: Date Fields
				if (in_array($column, ['created_at', 'updated_at'])) {
					if (!empty($value) && $value !== '0000-00-00 00:00:00') {
						$sub_array[] = date('d-m-Y H:i:s', strtotime($value));
					} else {
						$sub_array[] = 'NA';
					}
					continue;
				}

				// FORMAT: Alloted User
				if ($column == 'alloted_user') {
					$employee = employeeDetailHelper($value);
					if (!empty($employee) && isset($employee->full_name)) {
						$employeeName = $employee->emp_no . '-' . $employee->full_name;
					} else {
						$employeeName = 'NA';
					}
					$sub_array[] = '<div class="text-start" style="text-wrap: auto;width:200px;">' . $employeeName . '</div>';
					continue;
				}

				// Default safe output
				$sub_array[] = htmlspecialchars($value);
			}

			// ACTION DROPDOWN
			$actionDropdown = '<div class="btn-group ms-2 float-end">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">';

			// Edit
			if (check_action_permission(get_user_role(), 'vehicles', 'editVehicleForm')) {
				$actionDropdown .= '<a class="dropdown-item" onclick="editVehiclePopup(' . $item['id'] . ')">
					<i class="mdi mdi-pencil me-2"></i>Edit</a>';
			}

			// Quick View
			if (check_action_permission(get_user_role(), 'vehicles', 'single_vehicle_log')) {
				$actionDropdown .= '<div class="dropdown-divider"></div>
					<a class="dropdown-item" onclick="quickView(' . $item['id'] . ')">
					<i class="ti-server me-2"></i>Quick View</a>';
			}

			// Allot / Unallot / Return Logic
			if ($item['status'] != 'discontinued') {

				if ($item['allotment_status'] == 'none' || $item['allotment_status'] == 'return') {
					/*
					if (check_action_permission(get_user_role(), 'vehicles', 'allotForm')) {
						$actionDropdown .= '<div class="dropdown-divider"></div>
							<a class="dropdown-item" onclick="allotmentPopup(this)" data-id="' . $item['id'] . '" data-type="alloted">
							<i class="mdi mdi-account-check me-2"></i> Allot Vehicle</a>';
					}
					*/

					if (check_action_permission(get_user_role(), 'vehicles', 'parkingAllotmentForm')) {
						$actionDropdown .= '<div class="dropdown-divider"></div>
							<a class="dropdown-item" onclick="parkingPopup(this)" data-id="' . $item['id'] . '">
							<i class="mdi mdi-car-brake-parking me-2"></i> Park Vehicle</a>';
					}

				} elseif ($item['allotment_status'] == 'alloted') {
					/*
					if (check_action_permission(get_user_role(), 'vehicles', 'allotForm')) {
						$actionDropdown .= '<div class="dropdown-divider"></div>
							<a class="dropdown-item" onclick="allotmentPopup(this)" data-id="' . $item['id'] . '" data-type="unalloted">
							<i class="mdi mdi-account-cancel me-2"></i> Unallot</a>';
					}
					*/

					if (check_action_permission(get_user_role(), 'vehicles', 'download_documents')) {
						$actionDropdown .= '<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="' . base_url('admin/master-vehicle/export-vehicle-documents/' . $item['id']) . '" target="_blank">
							<i class="mdi mdi-download me-2"></i>Download Documents</a>';
					}
				}
			}

			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;

			$data[] = $sub_array;
		}

		// Final output for DataTables
		$output = [
			"draw"            => intval($this->input->post("draw")),
			"recordsTotal"    => $fetch_data['pagination']['total'],
			"recordsFiltered" => $fetch_data['pagination']['total'],
			"data"            => $data,
			"search"          => $search,
			"perPage"         => $perPage,
			"current_page"    => $fetch_data['pagination']['current_page'],
		];

		echo json_encode($output);
	}

	public function addVehicleForm()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$data['sponsors'] = $this->Sponsor_model->get_all_sponsors(); 
		$output_data = $this->load->view('admin/logistic-masters/master-vehicle/components/add-form', $data, TRUE);
		echo $output_data;
	}

	public function editVehicleForm($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			echo json_encode(['type' => 'error', 'message' => 'Unauthorized access!']);
			return;
		}

		if ((int)$id > 0) {
			$query = $this->Master_vehicle_model->detail($id);

			if ($query->num_rows() > 0) {  // fixed from num_row()
				$data['vehicle_details'] = $query->row_array(); // single row
				$data['sponsors'] = $this->Sponsor_model->get_all_sponsors(); 

				$output_data = $this->load->view(
					'admin/logistic-masters/master-vehicle/components/edit-form', 
					$data, 
					TRUE
				);
				echo $output_data;
			} else {
				echo json_encode(['type' => 'error', 'message' => 'Vehicle detail not found!']);
			}
		} else {
			echo json_encode(['type' => 'error', 'message' => 'Invalid request ID!']);
		}
	}

	public function saveForm()
	{
		$this->_validate_vehicle_form(); // Custom validation function

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['type' => 'error', 'message' => validation_errors()]);
			return;
		}

		// Upload files
		$registration_certificate = $this->_upload_file('registration_certificate', null);
		if ($registration_certificate === false) return;

		$insurance_certificate = $this->_upload_file('insurance_certificate', null);
		if ($insurance_certificate === false) return;

		$attached_file = $this->_upload_file('attached_file', null);
		if ($attached_file === false) return;

		// Prepare data array
		$data = [
			'vehicle_ownership'         => $this->input->post('vehicle_ownership'),
			'owner_name_select'         => $this->input->post('owner_name_select'),
			'vehicle_type'              => $this->input->post('vehicle_type'),
			'purchase_date'             => $this->input->post('purchase_date'),
			'vehicle_no'                => $this->input->post('vehicle_no'),
			'chassis_no'                => $this->input->post('chassis_no'),
			'vehicle_expiry'            => $this->input->post('vehicle_expiry'),
			'vehicle_year'              => $this->input->post('vehicle_year'),
			'vehicle_make'              => $this->input->post('vehicle_make'),
			'vehicle_model'             => $this->input->post('vehicle_model'),
			'vehicle_color'             => $this->input->post('vehicle_color'),
			'vehicle_category'          => $this->input->post('vehicle_category'),
			'sequel_no'          		=> $this->input->post('sequel_no'),
			'custom_card_no'          	=> $this->input->post('custom_card_no'),
			'gasoline_chip_status'      => $this->input->post('gasoline_chip_status'),
			'insurance_no'              => $this->input->post('insurance_no'),
			'insurance_company_name'    => $this->input->post('insurance_company_name'),
			'insurance_class'           => $this->input->post('insurance_class'),
			'insurance_issue_date'      => $this->input->post('insurance_issue_date'),
			'insurance_expiry'          => $this->input->post('insurance_expiry'),
			'gps_installed'             => $this->input->post('gps_installed') ?? 0,
			'gps_device_serial'         => $this->input->post('gps_device_serial'),
			'gps_installation_date'     => $this->input->post('gps_installation_date'),
			'gps_expiry_date'           => $this->input->post('gps_expiry_date'),
			'gsp_mobile_no'             => $this->input->post('gsp_mobile_no'),
			'operation_card_no'         => $this->input->post('operation_card_no'),
			'operation_card_issue_date' => $this->input->post('operation_card_issue_date'),
			'operation_card_expiry_date'=> $this->input->post('operation_card_expiry_date'),
			'registration_certificate'  => $registration_certificate,
			'insurance_certificate'     => $insurance_certificate,
			'attached_file'             => $attached_file,
			'status'                    => $this->input->post('status'),
			'city_of_operation'         => $this->input->post('city_of_operation'),
			'inactive_reason'           => $this->input->post('status_reason'),
			'status_date'               => $this->input->post('status_date'),
			'created_at'                => date('Y-m-d H:i:s'),
			'ip'                        => $this->input->ip_address()
		];

		$query = $this->Master_vehicle_model->add($data);

		if ($query) {
			echo json_encode(['type' => 'success', 'message' => 'Vehicle added successfully.']);
		} else {
			echo json_encode(['type' => 'error', 'message' => 'Error while adding vehicle.']);
		}
	}

	public function update()
	{
		$id = $this->input->post('id');
		if (!$id) {
			echo json_encode(['type' => 'error', 'message' => 'Invalid request ID.']);
			return;
		}

		$this->_validate_vehicle_form($id);

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['type' => 'error', 'message' => validation_errors()]);
			return;
		}

		// Get existing data to fetch old file paths
    	$vehicle = $this->Master_vehicle_model->detail($id)->row();
		//dd($vehicle->registration_certificate);
		// Upload files (or fallback to old files if no new file uploaded)
		$registration_certificate = $this->_upload_file('registration_certificate', $vehicle->registration_certificate);
		if ($registration_certificate === false) return;

		$insurance_certificate = $this->_upload_file('insurance_certificate', $vehicle->insurance_certificate);
		if ($insurance_certificate === false) return;

		$attached_file = $this->_upload_file('attached_file', $vehicle->attached_file);
		if ($attached_file === false) return;

		// Prepare data
		$data = [
			'vehicle_ownership'         => $this->input->post('vehicle_ownership'),
			'owner_name_select'         => $this->input->post('owner_name_select'),
			'vehicle_type'              => $this->input->post('vehicle_type'),
			'purchase_date'             => $this->input->post('purchase_date'),
			'vehicle_no'                => $this->input->post('vehicle_no'),
			'chassis_no'                => $this->input->post('chassis_no'),
			'vehicle_expiry'            => $this->input->post('vehicle_expiry'),
			'vehicle_year'              => $this->input->post('vehicle_year'),
			'vehicle_make'              => $this->input->post('vehicle_make'),
			'vehicle_model'             => $this->input->post('vehicle_model'),
			'vehicle_color'             => $this->input->post('vehicle_color'),
			'vehicle_category'          => $this->input->post('vehicle_category'),
			'sequel_no'                 => $this->input->post('sequel_no'),
			'custom_card_no'            => $this->input->post('custom_card_no'),
			'gasoline_chip_status'      => $this->input->post('gasoline_chip_status'),
			'insurance_no'              => $this->input->post('insurance_no'),
			'insurance_company_name'    => $this->input->post('insurance_company_name'),
			'insurance_class'           => $this->input->post('insurance_class'),
			'insurance_issue_date'      => $this->input->post('insurance_issue_date'),
			'insurance_expiry'          => $this->input->post('insurance_expiry'),
			'gps_installed'             => $this->input->post('gps_installed') ?? 0,
			'gps_device_serial'         => $this->input->post('gps_device_serial'),
			'gps_installation_date'     => $this->input->post('gps_installation_date'),
			'gps_expiry_date'           => $this->input->post('gps_expiry_date'),
			'gsp_mobile_no'             => $this->input->post('gsp_mobile_no'),
			'operation_card_no'         => $this->input->post('operation_card_no'),
			'operation_card_issue_date' => $this->input->post('operation_card_issue_date'),
			'operation_card_expiry_date'=> $this->input->post('operation_card_expiry_date'),
			'registration_certificate'  => $registration_certificate,
			'insurance_certificate'     => $insurance_certificate,
			'attached_file'             => $attached_file,
			'status'                    => $this->input->post('status'),
			'city_of_operation'         => $this->input->post('city_of_operation'),
			'inactive_reason'           => $this->input->post('status_reason'),
			'status_date'               => $this->input->post('status_date'),
			'updated_at'                => date('Y-m-d H:i:s'),
			'ip'                        => $this->input->ip_address()
		];

		$query = $this->Master_vehicle_model->edit($id, $data);

		if ($query) {
			echo json_encode(['type' => 'success', 'message' => 'Vehicle updated successfully.']);
		} else {
			echo json_encode(['type' => 'error', 'message' => 'Error while updating vehicle.']);
		}
	}

	private function _validate_vehicle_form($id = null)
	{
		$this->form_validation->set_rules('vehicle_ownership', 'Vehicle Ownership', 'trim|required');
		$this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'trim|required');
		$this->form_validation->set_rules('purchase_date', 'Purchase Date', 'trim|required');
		$this->form_validation->set_rules('vehicle_expiry', 'Vehicle Expiry Date', 'trim|required');
		$this->form_validation->set_rules('vehicle_year', 'Vehicle Year', 'trim|required');
		$this->form_validation->set_rules('vehicle_color', 'Vehicle Color', 'trim|required');
		$this->form_validation->set_rules('vehicle_make', 'Vehicle Make', 'trim|required');
		$this->form_validation->set_rules('vehicle_model', 'Vehicle Model', 'trim|required');
		$this->form_validation->set_rules('status', 'Vehicle Status', 'trim|required');
		$this->form_validation->set_rules('vehicle_category', 'Vehicle Category', 'trim|required');
		$this->form_validation->set_rules('status', 'Vehicle Status', 'trim|required');

		if ($id) {
			$this->form_validation->set_rules('vehicle_no', 'Vehicle Plate Number', 'trim|required|callback_check_unique_vehicle_no[' . $id . ']');
		} else {
			$this->form_validation->set_rules('owner_name_select', 'Owner Name', 'trim|required');
			$this->form_validation->set_rules(
				'vehicle_no',
				'Vehicle Plate Number',
				'trim|required|is_unique[master_vehicles.vehicle_no]',
				['is_unique' => 'This vehicle already exists.']
			);
		}
	}

	private function _upload_file($field_name, $old_file_path = null)
	{
		if (!empty($_FILES[$field_name]['name'])) {
			$config['upload_path'] = './uploads/delivery-vehicle/certificates/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
			$config['encrypt_name'] = TRUE;

			if (!is_dir($config['upload_path'])) {
				mkdir($config['upload_path'], 0755, true);
			}

			if (!is_writable($config['upload_path'])) {
				echo json_encode(['type' => 'error', 'message' => 'Upload path is NOT writable: ' . $config['upload_path']]);
				return false;
			}

			$this->upload->initialize($config);

			if (!$this->upload->do_upload($field_name)) {
				echo json_encode(['type' => 'error', 'message' => $this->upload->display_errors()]);
				return false;
			}

			$data = $this->upload->data();
			return 'uploads/delivery-vehicle/certificates/' . $data['file_name'];
		}

		// No new file uploaded, keep the old one
		return $old_file_path;
	}

/*
	public function save()
	{
		$this->form_validation->set_rules('vehicle_ownership', 'Vehicle Ownership', 'trim|required');
		$this->form_validation->set_rules('vehicle_type', 'Vehicle Type', 'trim|required');
		$this->form_validation->set_rules('vehicle_expiry', 'Vehicle Expiry Date', 'trim|required');
		$this->form_validation->set_rules('vehicle_year', 'Vehicle Year', 'trim|required');
		$this->form_validation->set_rules('vehicle_color', 'Vehicle Color', 'trim|required');
		$this->form_validation->set_rules('vehicle_make', 'Vehicle Make', 'trim|required');
		$this->form_validation->set_rules('vehicle_model', 'Vehicle Type', 'trim|required');
		$this->form_validation->set_rules('status', 'Vehicle Status', 'trim|required');
		if ($this->input->post('id')) {
			$id = $this->input->post('id');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle Plate Number', 'trim|required|callback_check_unique_vehicle_no[' . $id . ']');
		} else {
			$this->form_validation->set_rules(
				'vehicle_no',
				'Vehicle Plate Number',
				'trim|required|is_unique[master_vehicles.vehicle_no]',
				array('is_unique' => 'This vehicle already added, try another.')
			);
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($_FILES['registration_certificate']['name']) {
				$con['upload_path']   = './uploads/delivery-vehicle/certificates/';
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('registration_certificate')) {
					$this->session->set_userdata('info', "2--" . $this->upload->display_errors());
					redirect('admin/master-vehicle/list');
				} else {
					$image_data = $this->upload->data();
					$registration_certificate = "uploads/delivery-vehicle/certificates/" . $image_data['file_name'];
				}
			} else {
				$registration_certificate = $this->input->post('o_registration_certificate');
			}
			if ($_FILES['insurance_certificate']['name']) {
				$con['upload_path']   = './uploads/delivery-vehicle/certificates/';
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('insurance_certificate')) {
					$this->session->set_userdata('info', "2--" . $this->upload->display_errors());
					redirect('admin/master-vehicle/list');
				} else {
					$image_data1 = $this->upload->data();
					$insurance_certificate = "uploads/delivery-vehicle/certificates/" . $image_data1['file_name'];
				}
			} else {
				$insurance_certificate = $this->input->post('o_insurance_certificate');;
			}
			if ($_FILES['attached_file']['name']) {
				$con['upload_path']   = './uploads/delivery-vehicle/certificates/';
				$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf';
				$con['maintain_ratio'] = TRUE;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('attached_file')) {
					$this->session->set_userdata('info', "2--" . $this->upload->display_errors());
					redirect('admin/master-vehicle/list');
				} else {
					$image_data2 = $this->upload->data();
					$attached_file = "uploads/delivery-vehicle/certificates/" . $image_data2['file_name'];
				}
			} else {
				$attached_file = $this->input->post('o_attached_file');;
			}
			if ($this->input->post('id')) {
				$query = $this->Master_vehicle_model->edit($registration_certificate, $insurance_certificate, $attached_file);
			} else {
				$query = $this->Master_vehicle_model->add($registration_certificate, $insurance_certificate, $attached_file);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master-vehicle/list');
	}
*/
	// Callback function to check unique vehicle_no for updates
	public function check_unique_vehicle_no($vehicle_no, $id)
	{
		$this->db->where('vehicle_no', $vehicle_no);
		$this->db->where('id !=', $id);
		$query = $this->db->get('master_vehicles');
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('check_unique_vehicle_no', 'This vehicle already added, try another.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Master_vehicle_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master-vehicle/list');
	}

	public function allotForm()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';
			exit();
		} else {
			$query = $this->db->query("SELECT * FROM master_vehicles WHERE id = '" . $this->input->post('id') . "'");
			if ($query->num_rows() > 0) {
				$vehicle_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['type'] = $this->input->post('type');
				$data['vehicle_detail'] = $vehicle_info;
				$data['employee_list'] = $this->Master_vehicle_model->get_unalloted_employees();
				if ($data['type'] != '') {
					$output_data = $this->load->view('admin/logistic-masters/master-vehicle/vehicle-allotment', $data, TRUE);
				}
				echo $output_data;
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';
				exit();
			}
		}
	}

	public function updateAllotment()
	{
		$this->form_validation->set_rules('vehicle_id', 'Vehicle ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Request Type', 'trim|required');
		$this->form_validation->set_rules('allotment_status', 'Allotment Status', 'trim|required');
		$this->form_validation->set_rules('status_date', 'Date of Allotment', 'trim|required');
		$this->form_validation->set_rules('alloted_user', 'Select Rider', 'trim|required');
		$this->form_validation->set_rules('meter_reading', 'Meter Reading', 'trim|required');
		if ($this->input->post('allotment_status') == 'alloted') {
			$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		}
		if ($this->input->post('allotment_status') == 'return') {
			$this->form_validation->set_rules('location', 'Location', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$result = array("type" => 'error', "message" => validation_errors());
			echo json_encode($result);
			return;
		} else {
			$otp_data = $this->session->userdata('vehicle_otp_data');
			$stored_otp = $otp_data['otp'];
			$vehicle_id = $this->input->post('vehicle_id');
			$user_otp = $this->input->post('otp');
			$requestEmpId = $this->input->post('alloted_user');
			$empDetail = employeeDetailHelper($requestEmpId);
			$vehicleDetail = vehicleDetailHelper($vehicle_id);
			$tamm_attachment = null;
			if (!empty($_FILES['tamm_attachment']['name'])) {
				$config['upload_path'] = './uploads/delivery-vehicle/tamm_attachment/';
				$config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|xls|xlsx';
				$config['encrypt_name'] = TRUE;

				if (!is_dir($config['upload_path'])) {
					mkdir($config['upload_path'], 0755, true);
				}

				$this->upload->initialize($config);

				if ($this->upload->do_upload('tamm_attachment')) {
					$uploadData = $this->upload->data();
					$tamm_attachment = 'uploads/delivery-vehicle/tamm_attachment/' . $uploadData['file_name'];
				} else {
					//log_message('error', 'File upload failed: ' . $this->upload->display_errors());
					echo json_encode(['type' => 'error', 'message' => strip_tags($this->upload->display_errors())]);
					return;
				}
			}
			if ($this->input->post('allotment_status') == 'alloted') {
				if (empty($vehicleDetail->owner_name_select) || empty($vehicleDetail->vehicle_type) || empty($vehicleDetail->gasoline_chip_status == 'on')) {
					echo json_encode([
						'type' => 'error',
						'message' => 'Cannot allot vehicle. Please ensure Owner Name, Category, and Gasoline Chip are filled.'
					]);
					return;
				}
				if ($vehicleDetail->status == 'discontinued') {
					echo json_encode([
						'type' => 'error',
						'message' => 'Action not allowed. Vehicle is discontinued.'
					]);
					return;
				}
				if (($user_otp == $stored_otp) && ($requestEmpId == $otp_data['emp_id'])) {
					$query = $this->Master_vehicle_model->update_allotment_status($tamm_attachment);
					if ($query) {
						$this->session->unset_userdata('vehicle_otp_data');
						$email_data = array(
							'employee_id' => $requestEmpId,
							'request_type' => 'vehicle_allotment',
							'email' => $empDetail->email,
							'name' => $empDetail->full_name,
							'allotment_date' => $this->input->post('status_date'),
							'meter_reading' => $this->input->post('meter_reading'),
							'vehicle_no' => $vehicleDetail->vehicle_no,
							'vehicle_model' => $vehicleDetail->vehicle_model,
							'vehicle_make' => $vehicleDetail->make_name,
							'subject' => 'Company Vehicle Allotment  Confirmation',
							'template' => 'admin/attatchment-template/vehicle_confirmation_email'
						);
						send_global_mail_helper($email_data);
						$result = array("type" => 'success', "message" => 'Vehicle successfully alloted.');
						echo json_encode($result);
						return;
					} else {
						$result = array("type" => 'error', "message" => 'Vehicle allotment submission failed. Please try again.');
						echo json_encode($result);
						return;
					}
				} else {
					$result = array("type" => 'error', "message" => 'Invalid OTP, try again!');
					echo json_encode($result);
					return;
				}
			} else {
				$query = $this->Master_vehicle_model->update_allotment_status($tamm_attachment);
				if ($query) {
					if ($this->input->post('allotment_status') == 'unalloted') {
						$email_data = array(
							'employee_id' => $requestEmpId,
							'request_type' => 'vehicle_return',
							'email' => $empDetail->email,
							'name' => $empDetail->full_name,
							'allotment_date' => $this->input->post('status_date'),
							'meter_reading' => $this->input->post('meter_reading'),
							'vehicle_no' => $vehicleDetail->vehicle_no,
							'vehicle_model' => $vehicleDetail->vehicle_model,
							'vehicle_make' => $vehicleDetail->make_name,
							'subject' => 'Company Vehicle Un-Allotment Confirmation',
							'template' => 'admin/attatchment-template/vehicle_unallotment_email'
						);
						send_global_mail_helper($email_data);
					}
					$result = array("type" => 'success', "message" => 'Vehicle ' . $this->input->post('allotment_status') . ' successfully.');
					echo json_encode($result);
					return;
				} else {
					$result = array("type" => 'error', "message" => 'Vehicle ' . $this->input->post('allotment_status') . ' failed. Please try again.');
					echo json_encode($result);
					return;
				}
			}
		}
	}
	
	public function parkingAllotmentForm()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';
			exit();
		} else {
			$query = $this->db->query("SELECT * FROM master_vehicles WHERE id = '" . $this->input->post('id') . "'");
			if ($query->num_rows() > 0) {
				$vehicle_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['vehicle_detail'] = $vehicle_info;
				$data['employee_list'] = $this->Master_vehicle_model->get_unalloted_employees();
				$output_data = $this->load->view('admin/logistic-masters/master-vehicle/components/parking-allotment', $data, TRUE);
				echo $output_data;
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Vehicle Detail Not Found</strong></div>';
				exit();
			}
		}
	}

	public function parkingAllotmentUpdate()
	{
		$this->form_validation->set_rules('vehicle_id', 'Vehicle ID', 'trim|required');
		$this->form_validation->set_rules('location', 'Location', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				"type" => 'error',
				"message" => strip_tags(validation_errors())
			]);
			return;
		}
		$vehicle_id = $this->input->post('vehicle_id');
		$vehicleDetail = vehicleDetailHelper($vehicle_id);
		$is_alloted = $vehicleDetail->allotment_status;
		// Check if already allotted
		if ($is_alloted == 'alloted') {
			echo json_encode([
				'type' => 'error',
				'message' => 'Vehicle is already allotted. Un-allot before assigning new parking.'
			]);
			return;
		}
		// Update parking allotment
		$data = [
			'location' => $this->input->post('location'),
			'updated_at' => date('Y-m-d H:i:s'),
			'ip' => $this->input->ip_address()
		];
		$update = $this->Master_vehicle_model->edit($vehicle_id, $data);
		if ($update) {
			echo json_encode([
				"type" => "success",
				"message" => "Vehicle parked successfully."
			]);
		} else {
			echo json_encode([
				"type" => "error",
				"message" => "Failed to update vehicle. Try again."
			]);
		}
	}

	public function print_handover_form()
	{
		$id = $this->input->get('id');
		if ($id > 0) {
			$this->load->library('Pdf_mobile_consolidate_report');
			$data['vehicle_detail'] = $this->Master_vehicle_model->detail($id)->row();
			$alloted_id = $data['vehicle_detail']->alloted_user;
			$data['emp_detail'] = $this->Master_vehicle_model->alloted_emp_detail($alloted_id);
			//print_r($data);exit();
			// create new PDF document
			ini_set('memory_limit', '-1');
			$pdf = new Pdf_mobile_consolidate_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('Baqala Station - Vehicle Handover Form');
			$pdf->SetSubject('Baqala Station - Vehicle Handover Form');
			$pdf->SetKeywords('Baqala Station, PDF, Vehicle Handover Form');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(10, 60, 10, true);

			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage('P', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-masters/master-vehicle/print_handover_letter', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = "vehicle_handover_form_" . $id . ".pdf";
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/master-vehicle/list');
		}
	}

	public function download_documents()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		if ($id > 0) {
			$this->load->library('Pdf_general_margin');
			$data['vehicle_detail'] = $this->Master_vehicle_model->detail($id)->row();
			$alloted_id = $data['vehicle_detail']->alloted_user;
			$data['emp_detail'] = $this->Master_vehicle_model->alloted_emp_detail($alloted_id);
			//print_r($data);exit();
			// create new PDF document
			ini_set('memory_limit', '-1');
			$pdf = new Pdf_general_margin(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('Baqala Station - Vehicle Handover Form');
			$pdf->SetSubject('Baqala Station - Vehicle Handover Form');
			$pdf->SetKeywords('Baqala Station, PDF, Vehicle Handover Form');

			// print_r($data);exit();
			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(10, 60, 10, true);

			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			// Add the first page
			$pdf->AddPage('P', 'A4');

			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);
			// Check first page content
			$htmlcontent_page1 = $this->load->view('admin/logistic-masters/master-vehicle/print_handover_letter', $data, true);
			if (empty($htmlcontent_page1)) {
				throw new Exception("First page content is empty.");
			}
			$pdf->WriteHTML($htmlcontent_page1, true, 0, true, 0);
			// Close and output PDF document
			// $filename = "vehicle_handover_form_" . $id . ".pdf";
			// $pdf->Output($filename, 'I');

			
			// Add a new page
			$pdf->AddPage('P', 'A4');

			// Check second page content
			$htmlcontent_page2 = $this->load->view('admin/logistic-masters/master-vehicle/print_handover_letter_page2', $data, true);
			if (empty($htmlcontent_page2)) {
				throw new Exception("Second page content is empty.");
			}
			$pdf->WriteHTML($htmlcontent_page2, true, 0, true, 0);
			//Close and output PDF document
			$filename = "vehicle_handover_form_" . $id . ".pdf";
			//D->Download, I->View, F->Save
			/*
			$pdf->Output(FILE_PATH_DOWNLOAD . 'downloads/' . $filename, 'F');
			$this->zip->read_file(FILE_PATH_DOWNLOAD . 'downloads/' . $filename);
			if (isset($data['vehicle_detail']->registration_certificate)) {
				$this->zip->read_file(FILE_PATH_DOWNLOAD . $data['vehicle_detail']->registration_certificate);
			}
			if (isset($data['vehicle_detail']->insurance_certificate)) {
				$this->zip->read_file(FILE_PATH_DOWNLOAD . $data['vehicle_detail']->insurance_certificate);
			}
			unlink(FILE_PATH_DOWNLOAD . 'downloads/' . $filename);
			$this->zip->download('' . time() . '.zip');
			*/
			$pdf->Output($filename, 'I'); // I->Inline view
			
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/master-vehicle/list');
		}
	}

	public function export_combined_pdf($id)
	{
		if ($id < 1 || !is_numeric($id)) {
			$this->session->set_userdata('info', "2--Invalid employee ID: $id");
			redirect('admin/master-vehicle/list');
		}

		$data['vehicle_detail'] = $this->Master_vehicle_model->detail($id)->row();
		if (!$data['vehicle_detail']) {
			$this->session->set_userdata('info', "2--Vehicle not found with ID: $id");
			redirect('admin/master-vehicle/list');
		}

		$alloted_id = $data['vehicle_detail']->alloted_user;
		$data['emp_detail'] = $this->Master_vehicle_model->alloted_emp_detail($alloted_id);
		if (!$data['emp_detail']) {
			$this->session->set_userdata('info', "2--Employee not found with alloted ID: $alloted_id");
			redirect('admin/master-vehicle/list');
		}

		$emp_no   = $data['emp_detail']->emp_no ?? '';
		$emp_name = $data['emp_detail']->full_name ?? '';
		$vehicle_type = strtolower(trim($data['vehicle_detail']->vehicle_type ?? ''));

		$this->load->library('PdfFpdi');
		$pdf = new PdfFpdi();
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Vehicle Documents - ' . $emp_no . ' - ' . $emp_name);
		$pdf->SetSubject('Vehicle Documents');
		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(true);
		$pdf->SetFont('aealarabiya', '', 8);
		$pdf->SetMargins(5, 5, 5);
		$pdf->SetAutoPageBreak(true, 15);

		// Page 1
		$htmlcontent_page1 = $this->load->view('admin/logistic-masters/master-vehicle/print_handover_letter', $data, true);
		$pdf->AddPage();
		$pdf->writeHTML($htmlcontent_page1, true, false, true, false, '');

		// Page 2
		if ($vehicle_type === 'car') {
			$htmlcontent_page2 = $this->load->view('admin/logistic-masters/master-vehicle/print_handover_letter_page2', $data, true);
			
			if (!empty(trim($htmlcontent_page2))) { // extra safety check
				$pdf->AddPage();
				$pdf->writeHTML($htmlcontent_page2, true, false, true, false, '');
			}
		}

		// Include other attachments (RC, Insurance, etc.)
		$documents = [
			'registration_certificate' => 'RC',
			'insurance_certificate' => 'Insurance',
			// Add more if needed
		];

		foreach ($documents as $field => $label) {
			if (!empty($data['vehicle_detail']->$field)) {
				$file = FILE_PATH_DOWNLOAD . $data['vehicle_detail']->$field;
				$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

				if (file_exists($file)) {
					if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
						$pdf->AddPage();
						$pdf->Image($file, 10, 25, 190, 0, '', '', '', false, 300, '', false, false, 0);
					} elseif ($ext === 'pdf') {
						$pageCount = $pdf->setSourceFile($file);
						for ($i = 1; $i <= $pageCount; $i++) {
							$tplId = $pdf->importPage($i);
							$size = $pdf->getTemplateSize($tplId);

							$pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
							$pdf->useTemplate($tplId);
						}
					}
				}
			}
		}

		$filename = 'vehicle_documents_' . $emp_no . '_' . $emp_name . '.pdf';
		$pdf->Output($filename, 'I');
	}

	public function getPolicyDetail()
	{
		$policy_id = $this->input->post('policy_id');
		$policy_data = $this->policy_model->get_detail($policy_id)->row();

		if ($policy_data) {
			// Decode the policy_class array
			$policy_class_ids = json_decode($policy_data->policy_class, true);

			if (is_array($policy_class_ids)) {
				// Fetch details from master_insurance_type
				//$this->load->model('insurance_type_model');
				$this->db->where_in('id', $policy_class_ids);
				$insurance_types = $this->db->get('master_insurance_type')->result();

				// Add insurance type details to policy data
				$policy_data->insurance_type_details = $insurance_types;
			} else {
				$policy_data->insurance_type_details = [];
			}
		}
		echo json_encode($policy_data);
	}

	public function fetch_filter_data()
	{
		$filter_type = $this->input->get('filter_type');
		$search_query = $this->input->get('query');

		// Determine which filter data to fetch based on 'filter_type'
		switch ($filter_type) {
			case 'vehicle_no':
				$data = $this->Master_vehicle_model->get_filtered_vehicle_nos($search_query);
				break;
			case 'sequel_no':
				$data = $this->Master_vehicle_model->get_filtered_sequel_nos($search_query);
				break;
			case 'vehicle_model':
				$data = $this->Master_vehicle_model->get_filtered_vehicle_models($search_query);
				break;
			case 'alloted_user':
				$data = $this->Master_vehicle_model->get_filtered_alloted_users($search_query);
				break;
			default:
				$data = [];
		}

		// Return the result as JSON
		echo json_encode($data);
	}

	//Send OTP
	public function send_otp()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			$empDetail = employeeDetailHelper($emp_id);
			if ($empDetail) {
				// Generate a random OTP
				$otp = rand(100000, 999999);

				// Store OTP in session
				$this->session->set_userdata('vehicle_otp_data', [
					'otp' => $otp,
					'emp_id' => $empDetail->id,
					'emp_email' => $empDetail->email,
					'created_at' => time() // Store the time to handle expiration
				]);

				// Simulate OTP sending (via SMS or Email)
				$email_data = array(
					'employee_id' => $empDetail->id,
					'request_type' => 'vehicle_allotment',
					'email' => $empDetail->email,
					'name' => $empDetail->full_name,
					'otp' => $otp,
					'subject' => 'Company Vehicle Allotment OTP',
					'template' => 'admin/attatchment-template/vehicle_allotment_otp'
				);
				send_global_mail_helper($email_data);
				$result = array("type" => 'success', "message" => 'OTP sent successfully.');
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found.');
			}
		}
		echo json_encode($result);
		return;
	}

	public function resend_otp()
	{
		$otp_data = $this->session->userdata('vehicle_otp_data');

		if ($otp_data) {
			// Check if the session contains OTP data
			$otp = $otp_data['otp'];
			$emp_id = $otp_data['emp_id'];
			$emp_email = $otp_data['emp_email'];

			// Resend OTP (Simulate SMS or Email delivery)
			$empDetail = employeeDetailHelper($emp_id);
			$email_data = array(
				'employee_id' => $empDetail->id,
				'request_type' => 'vehicle_allotment',
				'email' => $empDetail->email,
				'name' => $empDetail->full_name,
				'otp' => $otp,
				'subject' => 'Company Vehicle Allotment OTP',
				'template' => 'admin/attatchment-template/vehicle_allotment_otp'
			);
			send_global_mail_helper($email_data);
			$result = array("type" => 'error', "message" => 'OTP resent successfully.');
		} else {
			$result = array("type" => 'error', "message" => 'OTP sending failed, Refresh page and try to send OTP again.');
		}
		echo json_encode($result);
		return;
	}

	public function verify_otp()
	{
		$this->form_validation->set_rules('otp', 'OTP', 'trim|required');
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() === FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
			echo json_encode($result);
			return;
		} else {
			$user_otp = $this->input->post('otp');
			$requestEmpId = $this->input->post('emp_id');
			$otp_data = $this->session->userdata('vehicle_otp_data');
			//print_r($user_otp);exit();
			if ($otp_data) {
				$stored_otp = $otp_data['otp'];
				$otp_created_at = $otp_data['created_at'];
				$current_time = time();

				// Check if the OTP is expired (e.g., valid for 10 minutes)
				if ($current_time - $otp_created_at > 600) { // 600 seconds = 10 minutes
					$result = array("type" => 'error', "message" => 'OTP has expired.');
					echo json_encode($result);
					return;
				}

				// Validate the entered OTP
				if (($user_otp == $stored_otp) && ($requestEmpId == $otp_data['emp_id'])) {
					$result = array("type" => 'success', "message" => 'OTP verified successfully.');
					echo json_encode($result);
					return;
					//$this->session->unset_userdata('otp_data'); // Clear OTP from session
				} else {
					$result = array("type" => 'error', "message" => 'You have entered wrong OTP.');
					echo json_encode($result);
					return;
				}
			} else {
				$result = array("type" => 'error', "message" => 'OTP verification failed, Refresh page and try to send OTP again.');
				echo json_encode($result);
				return;
			}
		}
	}

	// function downloadZip()
	// {
	// 	if ($this->input->post('images')) {
	// 		$this->load->library('zip');
	// 		$images = $this->input->post('images');
	// 		foreach ($images as $image) {
	// 			$this->zip->read_file($image);
	// 		}
	// 		$this->zip->download('' . time() . '.zip');
	// 	}
	// }

}
