<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class Employee extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/city_model');
			$this->load->model('admin/hr-module/Employee_model');
			$this->load->model('admin/masters/InsurancePolicies_model', 'policy_model');
			$this->load->model('admin/logistic-masters/Master_vehicle_model', 'vehicle_model');
			$this->load->model('admin/logistic-masters/Vehicle_log_model');
			$this->load->model('admin/Sim_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('request_helper');
			$this->load->helper('sendmail_helper');
			$this->load->helper('attendance_helper');
			$this->load->library('user_agent');
			/*----- Encryption -------*/
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			/*----- Encryption End -------*/
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index($status = null)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!$status) {
			$status = 'all';
		}

		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1] ?? '';
			$data['info_type'] = $info[0] ?? '';
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['emp_status'] = $status;
		//dd($data['emp_status']);
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'master_employees_data'
		])->row();
		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		return $this->load->view('admin/hr-module/employees/index', $data);
	}

	public function get_list()
	{
		// DataTable search & pagination
		$search   = $this->input->post('search')['value'] ?? '';
		$perPage  = $this->input->post('length') ?? 50;
		$start    = $this->input->post('start') ?? 0;

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

		// Status mapping (active, terminated, all)
		$empStatus = strtolower($filters['filter_status'] ?? 'all');
		$statusMapping = [
			'active'     => ['Active'],
			'terminated' => ['Terminated'],
			'all'        => ['Active', 'Terminated'],
		];
		$filters['status'] = $statusMapping[$empStatus] ?? $statusMapping['all'];

		// Get user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id'     => $this->admin->getLoginEmpId(),
			'module_name' => 'master_employees_data'
		])->row();

		$visibleColumns = json_decode($userPreferences->visible_columns ?? '[]', true);

		// Fetch data from model (pass filters array)
		$fetch_data = $this->Employee_model->employeeList($filters, $perPage, $start);

		// Remove excluded columns
		$excludedColumns = ['employee_pic', 'id'];
		$visibleColumns = array_values(array_filter($visibleColumns, function ($col) use ($excludedColumns) {
			return !in_array($col, $excludedColumns);
		}));

		// Prepare response data
		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $employee) {
			$sub_array = [];
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $employee['id'] . '" />';
			$sub_array[] = $i++; // Sr No.

			foreach ($visibleColumns as $colKey) {
				switch ($colKey) {
					case 'full_name':
						$profile_pic = !empty($employee['employee_pic'])
							? base_url($employee['employee_pic'])
							: base_url('images/user-img.png');
						$sub_array[] = '<div class="d-flex align-items-center">
                        <img src="' . $profile_pic . '" alt="Employee Pic" class="rounded-circle me-2" width="30" height="30">
                        <span>' . ($employee['full_name'] ?? '') . '</span></div>';
						break;

					case 'iqama_no':
						$iqamaNo = $employee['iqama_no'] ?? '';
						$statusBadge = '';

						if (in_array('iqama_expiry_date', $visibleColumns)) {
							$expiry = new DateTime($employee['iqama_expiry_date'] ?? 'now');
							$today  = new DateTime();

							$statusBadge = $expiry < $today
								? '<span class="badge badge-pill badge-soft-danger font-size-13">Expired</span>'
								: ($expiry->format('Y-m-d') === $today->format('Y-m-d')
									? '<span class="badge badge-pill badge-soft-warning font-size-13">Expires Today</span>'
									: '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>');
						}

						$sub_array[] = $iqamaNo . ($statusBadge ? '<br>' . $statusBadge : '');
						break;

					case 'payment_type_detail':
						$details = json_decode($employee['payment_type_detail'] ?? '', true);

						$accountType = $details['account_type'] ?? '';
						$bankName    = $details['bank_name'] ?? '';
						$ibanNo      = $details['iban_no'] ?? '';

						$sub_array[] = $accountType;
						$sub_array[] = $bankName;
						$sub_array[] = $ibanNo;
						break;

					case 'gender':
					case 'marital_status':
					case 'religion':
						$sub_array[] = ucfirst($employee[$colKey] ?? '');
						break;

					case 'status':
						$sub_array[] = ($employee['status'] == 'Active')
							? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>'
							: '<span class="badge badge-pill badge-soft-danger font-size-13">Terminated</span>';
						break;

					case 'terminate_reason':
						$sub_array[] = ($employee['status'] == 'Active')
							? ''
							: $employee['terminate_reason'];
						break;

					default:
						$value = $employee[$colKey] ?? '';
						if ((stripos($colKey, 'date') !== false || stripos($colKey, 'dob') !== false) && strtotime($value)) {
							$value = date('d-m-Y', strtotime($value));
						}
						$sub_array[] = $value;
						break;
				}
			}

			// Action buttons dropdown
			$actionDropdown = '<div class="btn-group ms-2 float-end">
            <button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="dripicons-dots-3"></i></button>
            <div class="dropdown-menu dropdown-menu-end">';

			if (check_action_permission(get_user_role(), 'view_employees', 'edit_step1')) {
				$actionDropdown .= '<a class="dropdown-item" href="' . base_url('admin/hr/employees/edit/step-1/' . $employee['id']) . '"><i class="mdi mdi-pencil me-2"></i> Edit</a>';
			}

			if (check_action_permission(get_user_role(), 'view_employees', 'view_step1')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/employees/view/step-1/' . $employee['id']) . '"><i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail</a>';
			}

			if (check_action_permission(get_user_role(), 'view_employees', 'show_status_form')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0);" onclick="statusModal(' . $employee['id'] . ')"><i class="mdi mdi-account-cog me-2"></i> Manage Status</a>';
			}
			
			if (check_action_permission(get_user_role(), 'view_employees', 'edit_step1')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0);" onclick="iqamaModal(' . $employee['id'] . ')"><i class="mdi mdi-card-account-details-star me-2"></i> Manage Iqama</a>';
			}

			$designationName = $employee['designation_name'] ?? '';
			if (in_array($designationName, ['Delivery Associate - Car', 'Delivery Associate - Bike'])) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/employees/print-offer-letter/' . $employee['id']) . '" target="_blank"><i class="mdi mdi-file-pdf-outline me-2"></i> Print Job Offer</a>';
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/employees/print-promissory-note/' . $employee['id']) . '" target="_blank"><i class="mdi mdi-file-pdf-outline me-2"></i> Print Promissory Note</a>';
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/employees/print-contract-letter/' . $employee['id']) . '" target="_blank"><i class="mdi mdi-file-pdf-outline me-2"></i> Print Contract Letter</a>';
			}

			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;
			$data[] = $sub_array;
		}

		// Send response to DataTables
		echo json_encode([
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $fetch_data['pagination']['total'],
			"recordsFiltered" => $fetch_data['pagination']['total'],
			"data"            => $data
		]);
	}

	public function getCities()
	{
		$country_id = $this->input->post('country_id');
		$data = selectedCitiesHelp($country_id);
		echo json_encode($data);
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

	public function add_step1()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['last_emp_no'] = $this->db->query("SELECT id FROM master_employee ORDER BY id desc limit 1")->row();
		$this->load->view('admin/hr-module/employees/add/step-form1', $data);
	}

	public function save_step1()
	{
		$this->form_validation->set_rules('emp_no', 'Employee Number', 'trim|required|callback_check_empid_duplicate');
		$this->form_validation->set_message('check_empid_duplicate', 'Employee ID taken, Try new');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email_duplicate');
		$this->form_validation->set_message('check_email_duplicate', 'Email id already registered, Try new');

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('full_name', 'Full Name (EN)', 'trim|required');
		$this->form_validation->set_rules('employee_arabic_name', 'Employee Arabic Name', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
		$this->form_validation->set_rules('religion', 'Religion', 'trim|required');
		//$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('absher_mobile', 'Absher Mobile No.', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('sponsor_id', 'Employer', 'trim|required');
		//$this->form_validation->set_rules('passport_issue_date', 'Passport Issue Date', 'trim|required');
		if ($this->input->post('nationality') !== "6") {
			$this->form_validation->set_rules('passport_no', 'Passport Number', 'trim|required|callback_check_passport_duplicate');
			$this->form_validation->set_message('check_passport_duplicate', 'Passport Number already registered, Try new');
			$this->form_validation->set_rules('passport_expiry_date', 'Passport Expiry Date', 'trim|required');
			$this->form_validation->set_rules('passport_issue_country', 'Passport Issue Country', 'trim|required');
			$this->form_validation->set_rules('passport_issue_city', 'Passport Issue City', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$password = $this->role->get_random_password($chars_min = 10, $chars_max = 10, $use_upper_case = true, $include_numbers = true, $include_special_chars = true);
			//$hashpassword = $this->enc_lib->encrypt($password);
			$hashpassword = password_hash($password, PASSWORD_DEFAULT);
			$query = $this->Employee_model->add_step1($hashpassword);
			if ($query > 0) {
				$employeeInfoData = [
					'employee_id' => $query,
					'insurance_company_name' => null,
					'insurance_policy_no' => null,
					'insurance_issue_date' => null,
					'insurance_end_date' => null,
					'updated_at' => date('Y-m-d H:i:s')
				];
				$this->Employee_model->add_employee_info($employeeInfoData);
				// if($this->input->post('send_credential') == 'on'){
				// 	$email = $this->input->post('local_email');
				// 	send_employee_credential($email,$password);
				// }
				$this->session->set_userdata('info', "1--Employee successfully created");
				return redirect('admin/hr/employees/add/step-2/' . $query);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, Try again!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function edit_step1($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($id);
			$alloted_sim_detail = $this->db->query("SELECT mobile FROM sim_card WHERE (alloted_user = '" . (int)$id . "' AND allotment = '1')")->row();
			$data['alloted_mobile_no'] = $alloted_sim_detail->mobile ?? '';
			//print_r($data['emp_detail']);exit();
			$this->load->view('admin/hr-module/employees/add/edit-step1', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/hr/employees');
		}
	}

	public function update_step1()
	{
		$this->form_validation->set_rules('id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('emp_no', 'Employee Number', 'trim|required|callback_check_empid_duplicate');
		$this->form_validation->set_message('check_empid_duplicate', 'Employee ID taken, Try new');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email_duplicate');
		$this->form_validation->set_message('check_email_duplicate', 'Email id already registered, Try new');

		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
		$this->form_validation->set_rules('full_name', 'Full Name (EN)', 'trim|required');
		$this->form_validation->set_rules('employee_arabic_name', 'Employee Arabic Name', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
		$this->form_validation->set_rules('religion', 'Religion', 'trim|required');
		//$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('absher_mobile', 'Absher Mobile No.', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('sponsor_id', 'Employer', 'trim|required');
		//$this->form_validation->set_rules('passport_issue_date', 'Passport Issue Date', 'trim|required');
		if ($this->input->post('nationality') !== "6") {
			$this->form_validation->set_rules('passport_no', 'Passport Number', 'trim|required|callback_check_passport_duplicate');
			$this->form_validation->set_message('check_passport_duplicate', 'Passport Number already registered, Try new');
			$this->form_validation->set_rules('passport_expiry_date', 'Passport Expiry Date', 'trim|required');
			$this->form_validation->set_rules('passport_issue_country', 'Passport Issue Country', 'trim|required');
			$this->form_validation->set_rules('passport_issue_city', 'Passport Issue City', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			//print_r($this->input->post());exit();
			$id = $this->input->post('id');
			if ($id > 0) {
				// Get old email from DB
				$old_data = $this->Employee_model->get_employee_by_id($id);
				$new_email = $this->input->post('email');
				$query = $this->Employee_model->update_step1($id);
				if ($query > 0) {
					// Check if email has changed
					if ($old_data && $old_data->email !== $new_email) {
						$this->Employee_model->update_email_in_admin_table($id, $new_email);
					}
					$this->session->set_userdata('info', "1--Employee successfully updated");
					return redirect('admin/hr/employees/add/step-2/' . $id);
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function add_step2()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			// print_r($data['cvs']);exit();
			return $this->load->view('admin/hr-module/employees/add/step-form2', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function save_step2()
	{
		$this->form_validation->set_rules('id', 'Employee ID', 'trim|required');
		//$this->form_validation->set_rules('home_address[]', 'Home Address', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			//print_r($this->input->post());exit();
			$id = $this->input->post('id');
			if ($id > 0) {
				$data = array(
					'home_address' => json_encode($this->input->post('home_address')),
					'saudi_address' => json_encode($this->input->post('saudi_address')),
					'emergency_contact_detail' => json_encode($this->input->post('emergency')),
					'family_contact_detail' => json_encode($this->input->post('family'))
				);
				$this->db->where('id', $id);
				$query = $this->db->update('master_employee', $data);
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated step 2.");
					return redirect('admin/hr/employees/add/step-3/' . $id);
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function add_step3()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['salary_logs'] = $this->Employee_model->get_salary_logs(0);
			$data['active_contract'] = $this->Employee_model->get_active_contract($emp_id);
			$data['expired_contract'] = $this->Employee_model->get_expired_contract($emp_id);
			// print_r($data['cvs']);exit();
			return $this->load->view('admin/hr-module/employees/add/step-form3', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function getDesignation()
	{
		$department_id = $this->input->post('department_id');
		$data = masterDesignation($department_id);
		echo json_encode($data);
	}

	public function getBeds()
	{
		$room_id = $this->input->post('room_id');
		$data = selectedBedHelper($room_id);
		echo json_encode($data);
	}

	public function getRooms()
	{
		$camp_id = $this->input->post('camp_id');
		$data = selectedRoomHelper($camp_id);
		echo json_encode($data);
	}

	public function getHijriDate()
	{
		$gdate = $this->input->get('gregorian_date');
		$data = '';
		if (!empty($gdate)) {
			$data = Greg2Hijri($gdate);
		}
		return $data;
	}

	public function returnHijriDate($gregorian_date)
	{
		$gdate = $gregorian_date;
		$data = '';
		if (!empty($gdate)) {
			$data = Greg2Hijri($gdate);
		}
		return $data;
	}

	/*------- Ajax call date conversion -------*/
	public function getGregorianDateFormat()
	{
		$hijri_date = $this->input->post('hijri_date'); // Expecting '16-01-1447'
		$data = '';

		if (!empty($hijri_date)) {
			$hijri = ReturnHijri2Greg($hijri_date); // should return yyyy-mm-dd
			$parts = explode('-', $hijri);
			if (count($parts) === 3) {
				$data = $parts[0] . '-' . $parts[1] . '-' . $parts[2]; // return dd-mm-yyyy
			}
		}
		echo $data;
	}


	public function getHijriDateFormat()
	{
		$gregorian_date = $this->input->post('gregorian_date');
		$data = '';
		if (!empty($gregorian_date)) {
			$hijri = Greg2Hijri($gregorian_date); // should return yyyy-mm-dd
			$parts = explode('-', $hijri);
			if (count($parts) === 3) {
				$data = $parts[0] . '-' . $parts[1] . '-' . $parts[2]; // return dd-mm-yyyy
			}
		}
		echo $data;
	}

	//End of Hijri Date Conversion

	public function save_step3()
	{
		$this->form_validation->set_rules('id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('work_joining_date', 'Joining Date', 'trim|required');
		$this->form_validation->set_rules('work_operational_date', 'Active in operation', 'trim|required');
		$this->form_validation->set_rules('designation', 'Job Title', 'trim|required');
		$this->form_validation->set_rules('department', 'Department', 'trim|required');
		$this->form_validation->set_rules('work_location', 'Work Location', 'trim|required');
		// $this->form_validation->set_rules('work_city', 'City', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('id');
			if ($emp_id > 0) {
				$query = $this->Employee_model->update_step3($emp_id);
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated step 3.");
					return redirect('admin/hr/employees/add/step-4/' . $emp_id);
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function add_step4()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			//dd($data['emp_info']);exit();
			if (!empty($data['emp_info'])) {
				return $this->load->view('admin/hr-module/employees/add/step-form4', $data);
			} else {
				return $this->load->view('admin/hr-module/employees/add/add-step-form4', $data);
			}
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function save_step4()
	{
		$this->form_validation->set_rules('id', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('id');
			if ($emp_id > 0) {
				// Get existing insurance policy before updating
				$this->db->where('employee_id', $emp_id);
				$query = $this->db->get('master_employee_info');
				$old_data = $query->row();

				if ($_FILES['medical_attachment']['name']) {
					$con['upload_path']   = './uploads/employee-docs/';
					$con['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
					$con['max_size']      = 0;
					$con['max_width']     = 0;
					$con['max_height']    = 0;
					$con['max_filename'] = '50';
					$con['encrypt_name'] = TRUE;
					$this->load->library('upload', $con);
					if (!$this->upload->do_upload('medical_attachment')) {
						echo $this->upload->display_errors();
						exit;
					} else {
						$image_data = $this->upload->data();
						$image = "uploads/employee-docs/" . $image_data['file_name'];
					}
				} else {
					$image = $this->input->post('old_medical_attachment');
				}

				$new_policy_no = $this->input->post('insurance_policy_no');
				$data = array(
					'employee_id' => $this->input->post('id'),
					'insurance_company_name' => $this->input->post('insurance_company_name'),
					'insurance_policy_no' => $new_policy_no,
					'insurance_issue_date' => $this->input->post('insurance_issue_date'),
					'insurance_end_date' => $this->input->post('insurance_end_date'),
					'category' => $this->input->post('category'),
					'cost' => $this->input->post('cost'),
					'availability_in_cchi' => $this->input->post('availability_in_cchi'),
					'cchi_effective_date' => $this->input->post('cchi_effective_date'),
					'medical_attachment' => $image,
					'driving_license_number' => $this->input->post('driving_license_number'),
					'driving_license_type' => $this->input->post('driving_license_type'),
					'driving_license_issue_country' => $this->input->post('driving_license_issue_country'),
					'driving_license_issue_city' => $this->input->post('driving_license_issue_city'),
					'driving_license_issue_date' => $this->input->post('driving_license_issue_date'),
					'driving_license_exp_date' => $this->input->post('driving_license_exp_date'),
					'driving_license_exp_date_hijri' => $this->input->post('driving_license_exp_date_hijri'),
					'driver_card_no' => $this->input->post('driver_card_no'),
					'driver_card_type' => $this->input->post('driver_card_type'),
					'driver_card_issue_date' => $this->input->post('driver_card_issue_date'),
					'driver_card_expiry_date' => $this->input->post('driver_card_expiry_date'),
					'updated_at' => CURRENT_TIME
				);
				$this->db->where('employee_id', $emp_id);
				$q = $this->db->get('master_employee_info');
				if ($q->num_rows() > 0) {
					$this->db->where('employee_id', $emp_id);
					$query = $this->db->update('master_employee_info', $data);
				} else {
					$this->db->set('employee_id', $emp_id);
					$query = $this->db->insert('master_employee_info', $data);
				}
				if ($query) {
					// Check if policy number has changed
					if (!empty($new_policy_no) && $old_data && $old_data->insurance_policy_no != $new_policy_no) {
						$empDetail = employeeDetailHelper($emp_id);
						$insuranceDetail = $this->db->query("
							SELECT 
								mip.id, 
								mip.policy_number, 
								mip.policy_company, 
								mic.company_name as insurance_company_name, 
								mip.policy_date, 
								mip.policy_expiry 
							FROM master_insurance_policies mip 
							LEFT JOIN master_insurance_company mic ON (mip.policy_company = mic.id) 
							WHERE mip.id = '" . $new_policy_no . "'")->row_array();

						$email_data = array(
							'employee_id' => $empDetail->id,
							'request_type' => 'insurance_update',
							'email' => $empDetail->email,
							'name' => $empDetail->full_name,
							'insurance_company_name' => $insuranceDetail['insurance_company_name'],
							'insurance_policy_no' => $insuranceDetail['policy_number'],
							'insurance_end_date' => $insuranceDetail['policy_expiry'],
							'subject' => 'Group Health Insurance Activation Notification',
							'template' => 'admin/attatchment-template/insurance_updation_email'
						);
						//dd($insuranceDetail);
						send_global_mail_helper($email_data);
					}
					$this->session->set_userdata('info', "1--Successfully updated step 4.");
					return redirect('admin/hr/employees/add/step-5/' . $emp_id);
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function add_secondary_dl_form()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$response = [
				'status' => 'error',
				'message' => validation_errors()
			];
			echo json_encode($response);
			return;
		}

		$emp_id = $this->input->post('emp_id');
		$employee_info = $this->Employee_model->get_detail($emp_id);

		if (!empty($employee_info)) {
			$data['emp_detail'] = $employee_info;
			$output_data = $this->load->view('admin/hr-module/employees/components/add_dl_form', $data, TRUE);

			$response = [
				'status' => 'success',
				'html' => $output_data
			];
		} else {
			$response = [
				'status' => 'error',
				'message' => 'No employee data found.'
			];
		}

		echo json_encode($response);
	}

	public function save_secondary_dl()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('driving_license_number', 'DL Number', 'trim|required');
		$this->form_validation->set_rules('driving_license_type', 'DL Type', 'trim|required');
		$this->form_validation->set_rules('driving_license_issue_country', 'DL Issue Countrty', 'trim|required');
		$this->form_validation->set_rules('driving_license_issue_city', 'DL issue city', 'trim|required');
		$this->form_validation->set_rules('driving_license_issue_date', 'DL Issue Date', 'trim|required');
		$this->form_validation->set_rules('driving_license_exp_date', 'DL Expiry Date', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo json_encode(['type' => 'error', 'message' => $msg]);
			return;
		}
		$emp_id = $this->input->post('emp_id');
		$dl_data = [
			'driving_license_number' => $this->input->post('driving_license_number', true),
			'driving_license_type' => $this->input->post('driving_license_type', true),
			'driving_license_issue_country' => $this->input->post('driving_license_issue_country', true),
			'driving_license_issue_city' => $this->input->post('driving_license_issue_city', true),
			'driving_license_issue_date' => $this->input->post('driving_license_issue_date', true),
			'driving_license_exp_date' => $this->input->post('driving_license_exp_date', true),
			'created_at' => date('Y-m-d H:i:s')
		];

		// Optional: Validate input fields here

		$saved = $this->Employee_model->save_secondary_dl($emp_id, $dl_data);

		if ($saved) {
			echo json_encode(['type' => 'success', 'message' => 'Driving license added successfully']);
		} else {
			echo json_encode(['type' => 'error', 'message' => 'Failed to add driving license']);
		}
	}

	public function delete_secondary_dl()
	{
		$employee_id = $this->input->post('emp_id');
		$dl_index = $this->input->post('dl_index');

		// Basic validation
		if (empty($employee_id) || !is_numeric($dl_index)) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'Invalid request data.']));
		}

		// Fetch employee by employee_id
		$employee = $this->Employee_model->get_by_employee_id($employee_id);

		if (!$employee) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'Employee not found.']));
		}

		// Decode secondary DL data
		$dl_data = json_decode($employee->secondary_dl_details ?? '[]', true);

		if (!is_array($dl_data) || !isset($dl_data[$dl_index])) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'DL entry not found.']));
		}

		// Remove the specified DL
		unset($dl_data[$dl_index]);
		$dl_data = array_values($dl_data); // Reindex

		// Update the record
		$updated = $this->Employee_model->update_secondary_dl($employee_id, $dl_data);

		if ($updated) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'success', 'message' => 'DL entry deleted successfully.']));
		} else {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => 'error', 'message' => 'Failed to update database.']));
		}
	}

	public function add_contract_form()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('redirect', 'Redirect Page', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$emp_id = $this->input->post('emp_id');
			$employee_info = $this->Employee_model->get_detail($emp_id);
			if (!empty($employee_info)) {
				$data['emp_detail'] = $employee_info;
				$data['redirect_path'] = $this->input->post('redirect');
				$output_data = $this->load->view('admin/hr-module/employees/components/add-contract-form', $data, TRUE);
				echo $output_data;
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}

	public function add_contract()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('contract_type', 'Contract Type', 'trim|required');
		$this->form_validation->set_rules('contract_duration', 'Contract Duration', 'trim|required');
		$this->form_validation->set_rules('contract_start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('contract_end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('contract_status', 'Contract Status', 'trim|required');
		$this->form_validation->set_rules('redirect_path', 'Redirect Path', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			$redirectTo = $this->input->post('redirect_path');
			if ($_FILES['attachment']['name']) {
				$con['upload_path']   = './uploads/employee-docs/';
				$con['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('attachment')) {
					echo $this->upload->display_errors();
					exit;
				} else {
					$image_data = $this->upload->data();
					$image = "uploads/employee-docs/" . $image_data['file_name'];
				}
			} else {
				$image = '';
			}
			$data = array(
				'employee_id' => $this->input->post('emp_id'),
				'contract_type' => $this->input->post('contract_type'),
				'contract_duration' => $this->input->post('contract_duration'),
				'contract_start_date' => $this->input->post('contract_start_date'),
				'contract_end_date' => $this->input->post('contract_end_date'),
				'start_date_hijri' => $this->input->post('start_date_hijri'),
				'end_date_hijri' => $this->input->post('end_date_hijri'),
				'is_probation_period' => $this->input->post('is_probation_period'),
				'probation_days' => $this->input->post('probation_days'),
				'contract_status' => $this->input->post('contract_status'),
				'attachment' => $image,
				'updated_at' => CURRENT_TIME
			);
			$this->db->where('employee_id', $emp_id);
			$this->db->where('contract_end_date >=', date('Y-m-d'));
			$q = $this->db->get('master_employee_contracts');
			if ($q->num_rows() > 0) {
				$this->session->set_userdata('info', "2--Contract already exist.");
			} else {
				$this->db->set('employee_id', $emp_id);
				$query = $this->db->insert('master_employee_contracts', $data);
				if ($query) {
					$this->session->set_userdata('info', "1--Contract successfully updated.");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			}
		}
		return redirect('admin/hr/employees/' . $redirectTo . '/step-3/' . $emp_id);
	}

	public function update_contract_form()
	{
		$this->form_validation->set_rules('id', 'Contract ID', 'trim|required');
		$this->form_validation->set_rules('redirect', 'Redirect Page', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$query = $this->db->query("SELECT * FROM master_employee_contracts WHERE id = '" . $this->input->post('id') . "'");
			if ($query->num_rows() > 0) {
				$contract_info = $query->row();
				$data['redirect_path'] = $this->input->post('redirect');
				$data['contract_info'] = $contract_info;
				$output_data = $this->load->view('admin/hr-module/employees/components/update-contract-form', $data, TRUE);
				echo $output_data;
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}

	public function update_contract()
	{
		$this->form_validation->set_rules('id', 'Contract ID', 'trim|required');
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('contract_type', 'Contract Type', 'trim|required');
		$this->form_validation->set_rules('contract_duration', 'Contract Duration', 'trim|required');
		$this->form_validation->set_rules('contract_start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('contract_end_date', 'End Date', 'trim|required');
		$this->form_validation->set_rules('contract_status', 'Contract Status', 'trim|required');
		$this->form_validation->set_rules('redirect_path', 'Redirect Path', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$id = $this->input->post('id');
			$emp_id = $this->input->post('emp_id');
			$redirectTo = $this->input->post('redirect_path');
			if ($_FILES['attachment']['name']) {
				$con['upload_path']   = './uploads/employee-docs/';
				$con['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('attachment')) {
					echo $this->upload->display_errors();
					exit;
				} else {
					$image_data = $this->upload->data();
					$image = "uploads/employee-docs/" . $image_data['file_name'];
				}
			} else {
				$image = $this->input->post('old_attachment');
			}
			$data = array(
				'employee_id' => $this->input->post('emp_id'),
				'contract_type' => $this->input->post('contract_type'),
				'contract_duration' => $this->input->post('contract_duration'),
				'contract_start_date' => $this->input->post('contract_start_date'),
				'contract_end_date' => $this->input->post('contract_end_date'),
				'start_date_hijri' => $this->input->post('start_date_hijri'),
				'end_date_hijri' => $this->input->post('end_date_hijri'),
				'is_probation_period' => $this->input->post('is_probation_period'),
				'probation_days' => $this->input->post('probation_days'),
				'contract_status' => $this->input->post('contract_status'),
				'attachment' => $image,
				'updated_at' => CURRENT_TIME
			);
			$this->db->where('id', $id);
			$q = $this->db->get('master_employee_contracts');
			if ($q->num_rows() > 0) {
				$this->db->set('employee_id', $emp_id);
				$this->db->where('id', $id);
				$query = $this->db->update('master_employee_contracts', $data);
				if ($query) {
					$this->session->set_userdata('info', "1--Contract successfully updated.");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Contract not exist.");
			}
		}
		return redirect('admin/hr/employees/' . $redirectTo . '/step-3/' . $emp_id);
	}

	public function add_salary_form()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('redirect', 'Redirect Page', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$emp_id = $this->input->post('emp_id');
			$employee_info = $this->Employee_model->get_detail($emp_id);
			if (!empty($employee_info)) {
				$data['emp_detail'] = $employee_info;
				$data['redirect_path'] = $this->input->post('redirect');
				$output_data = $this->load->view('admin/hr-module/employees/components/add-salary-form', $data, TRUE);
				echo $output_data;
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}

	public function update_salary()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('basic_salary', 'Basic Salary', 'trim|required');
		$this->form_validation->set_rules('total_package', 'Total Package', 'trim|required');
		$this->form_validation->set_rules('redirect_path', 'Redirect Path', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			$redirectTo = $this->input->post('redirect_path');

			// Create an empty array and add only posted fields
			$data = array();

			if ($this->input->post('basic_salary') !== null) {
				$data['basic_salary'] = $this->input->post('basic_salary');
			}
			if ($this->input->post('housing_allowance') !== null) {
				$data['housing_allowance'] = $this->input->post('housing_allowance');
			}
			if ($this->input->post('is_housing_provided') !== null) {
				$data['is_housing_provided'] = $this->input->post('is_housing_provided');
			}
			if ($this->input->post('camp') !== null) {
				$data['camp'] = $this->input->post('camp');
			}
			if ($this->input->post('room') !== null) {
				$data['room'] = $this->input->post('room');
			}
			if ($this->input->post('bed') !== null) {
				$data['bed'] = $this->input->post('bed');
			}
			if ($this->input->post('transport_allowance') !== null) {
				$data['transport_allowance'] = $this->input->post('transport_allowance');
			}
			if ($this->input->post('food_allowance') !== null) {
				$data['food_allowance'] = $this->input->post('food_allowance');
			}
			if ($this->input->post('mobile_allowance') !== null) {
				$data['mobile_allowance'] = $this->input->post('mobile_allowance');
			}
			if ($this->input->post('other_allowance') !== null) {
				$data['other_allowance'] = $this->input->post('other_allowance');
			}
			if ($this->input->post('total_package') !== null) {
				$data['total_package'] = $this->input->post('total_package');
			}

			$data['updated_at'] = CURRENT_TIME;

			$this->db->where('id', $emp_id);
			$q = $this->db->get('master_employee');

			if ($q->num_rows() > 0) {
				$this->db->where('id', $emp_id);
				$query = $this->db->update('master_employee', $data);
				if ($query) {
					// Log the salary update
					$log_data = array(
						'employee_id' => $emp_id,
						'log_detail' => json_encode($data),
						'created_at' => CURRENT_TIME,
						'updated_at' => CURRENT_TIME
					);

					// Insert the log into employee_salary_log table
					$this->db->insert('employee_salary_log', $log_data);
					$result = array("type" => 'success', "message" => 'Salary detail successfully updated.');
				} else {
					$result = array("type" => 'error', "message" => 'Something went wrong, Try again!');
				}
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found!');
			}
		}
		echo json_encode($result);
	}

	public function salary_log_detail()
	{
		$this->form_validation->set_rules('id', 'Log ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$id = $this->input->post('id');
			$salary_info = $this->Employee_model->get_salary_log_detail($id);
			if (!empty($salary_info)) {
				$data['log_single'] = $salary_info;
				$output_data = $this->load->view('admin/hr-module/employees/components/salary-log-detail', $data, TRUE);
				echo $output_data;
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}

	public function getLineManageOfLm()
	{
		$this->form_validation->set_rules('emp_id', 'Line Manager', 'trim|required');
		$this->form_validation->set_rules('main_emp_id', 'Employee ID', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$html = '<option value="">' . $msg . '</option>';
		} else {
			$emp_id = $this->input->post('emp_id');
			$main_emp_id = $this->input->post('main_emp_id');
			$employee_info = $this->Employee_model->get_detail($emp_id);

			if (!empty($employee_info)) {
				$department_head = $this->Employee_model->get_detail($employee_info->work_line_manager);
				$main_employee_info = $this->Employee_model->get_detail($main_emp_id);
				
				//dd($main_employee_info);
				if (!empty($department_head) && !empty($main_employee_info)) {
					// Check if department_head->id matches main_employee_info->department_head
					$selected = ($department_head->id == $main_employee_info->department_head) ? 'selected="selected"' : '';
					$html = '<option value="">Select Department Head</option>';
					$html .= '<option value="' . $department_head->id . '" ' . $selected . '>' . $department_head->full_name . '</option>';
				} else {
					$html = '<option value="">No Department Head Found</option>';
				}
			} else {
				$html = '<option value="">No Department Head Found</option>';
			}
		}

		echo $html;
		exit();
	}

	public function add_family_form()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('redirect', 'Redirect Page', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . $this->input->post('emp_id') . "'");
			if ($query->num_rows() > 0) {
				$employee_info = $query->row();
				$data['redirect_path'] = $this->input->post('redirect');
				$data['emp_detail'] = $employee_info;
				$output_data = $this->load->view('admin/hr-module/employees/components/add-family-form', $data, TRUE);
				echo $output_data;
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}

	public function add_family()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'ID or Inqama Number', 'trim|required');
		$this->form_validation->set_rules('redirect_path', 'Redirect Path', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			$redirectTo = $this->input->post('redirect_path');
			// Get the existing JSON data from the database based on the $id
			$query = $this->db->get_where('master_employee', array('id' => $emp_id));
			$emp_row = $query->row();
			if ($emp_row) {
				// Parse the JSON data into a PHP array
				$jsonData = json_decode($emp_row->family_contact_detail, true);
			}
			$newData = array(
				'employee_id' => $this->input->post('emp_id'),
				'name' => $this->input->post('name'),
				'name_ar' => $this->input->post('name_ar'),
				'gender' => $this->input->post('gender'),
				'relationship' => $this->input->post('relationship'),
				'nationality' => $this->input->post('nationality'),
				'marital_status' => $this->input->post('marital_status'),
				'dob' => $this->input->post('dob'),
				'iqama_no' => $this->input->post('iqama_no'),
				'iqama_issue_date' => $this->input->post('iqama_issue_date'),
				'iqama_expiry_date' => $this->input->post('iqama_expiry_date'),
				'iqama_issue_date_hijri' => $this->input->post('iqama_issue_date_hijri'),
				'passport_no' => $this->input->post('passport_no'),
				'passport_expiry_date' => $this->input->post('passport_expiry_date'),
				'medical_expiry_date' => $this->input->post('medical_expiry_date'),
				'insurance_no' => $this->input->post('insurance_no')
			);

			// Assuming you want to push the new data as a new entry with the next numeric index
			$jsonData[] = $newData;

			// Convert the modified array back to JSON
			$updatedJsonData = json_encode($jsonData);

			// Update the JSON column in the database with the modified JSON data
			$this->db->set('family_contact_detail', $updatedJsonData);
			$this->db->where('id', $emp_id);
			$query = $this->db->update('master_employee');
			$this->db->where('employee_id', $emp_id);
			if ($query) {
				$this->session->set_userdata('info', "1--Family successfully updated.");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, Try again!");
			}
		}
		return redirect('admin/hr/employees/' . $redirectTo . '/step-2/' . $emp_id);
	}

	public function update_family_form()
	{
		$this->form_validation->set_rules('key_id', 'ID', 'trim|required');
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('redirect', 'Redirect Page', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . $this->input->post('emp_id') . "'");
			if ($query->num_rows() > 0) {
				$employee_info = $query->row();
				$data['redirect_path'] = $this->input->post('redirect');
				$data['emp_detail'] = $employee_info;
				// Extract JSON data from the column
				$jsonData = json_decode($employee_info->family_contact_detail, true); // true to get associative array
				$json_key = $this->input->post('key_id');
				// Check if the JSON data exists and contains the item you need
				if ($jsonData && isset($jsonData[$json_key])) {
					$data['fam_contact'] = $jsonData[$json_key];
					$data['key_id'] = $json_key;
					$output_data = $this->load->view('admin/hr-module/employees/components/update-family-form', $data, TRUE);
					echo $output_data;
					exit();
				} else {
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
					exit();
				}
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}

	public function update_family()
	{
		$this->form_validation->set_rules('key_id', 'Key ID', 'trim|required');
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'ID or Inqama Number', 'trim|required');
		$this->form_validation->set_rules('redirect_path', 'Redirect Path', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$json_key = $this->input->post('key_id');
			$emp_id = $this->input->post('emp_id');
			$redirectTo = $this->input->post('redirect_path');
			// Get the existing JSON data from the database based on the $id
			$query = $this->db->get_where('master_employee', array('id' => $emp_id));
			$emp_row = $query->row();
			if ($emp_row) {
				// Parse the JSON data into a PHP array
				$jsonData = json_decode($emp_row->family_contact_detail, true);
			}
			$jsonData[$json_key]['employee_id'] = $this->input->post('emp_id');
			$jsonData[$json_key]['name'] = $this->input->post('name');
			$jsonData[$json_key]['name_ar'] = $this->input->post('name_ar');
			$jsonData[$json_key]['gender'] = $this->input->post('gender');
			$jsonData[$json_key]['relationship'] = $this->input->post('relationship');
			$jsonData[$json_key]['nationality'] = $this->input->post('nationality');
			$jsonData[$json_key]['marital_status'] = $this->input->post('marital_status');
			$jsonData[$json_key]['dob'] = $this->input->post('dob');
			$jsonData[$json_key]['iqama_no'] = $this->input->post('iqama_no');
			$jsonData[$json_key]['iqama_issue_date'] = $this->input->post('iqama_issue_date');
			$jsonData[$json_key]['iqama_expiry_date'] = $this->input->post('iqama_expiry_date');
			$jsonData[$json_key]['iqama_issue_date_hijri'] = $this->input->post('iqama_issue_date_hijri');
			$jsonData[$json_key]['passport_no'] = $this->input->post('passport_no');
			$jsonData[$json_key]['passport_expiry_date'] = $this->input->post('passport_expiry_date');
			$jsonData[$json_key]['medical_expiry_date'] = $this->input->post('medical_expiry_date');
			$jsonData[$json_key]['insurance_no'] = $this->input->post('insurance_no');

			// Convert the modified array back to JSON
			$updatedJsonData = json_encode($jsonData);

			// Update the JSON column in the database with the modified JSON data
			$this->db->set('family_contact_detail', $updatedJsonData);
			$this->db->where('id', $emp_id);
			$query = $this->db->update('master_employee');
			$this->db->where('employee_id', $emp_id);
			if ($query) {
				$this->session->set_userdata('info', "1--Family successfully updated.");
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, Try again!");
			}
		}
		return redirect('admin/hr/employees/' . $redirectTo . '/step-2/' . $emp_id);
	}

	public function deleteFamilyMem($id, $keyToDelete, $redirectTo)
	{
		// Fetch the row from the database
		$row = $this->db->get_where('master_employee', ['id' => $id])->row();

		// Check if row exists
		if ($row) {
			// Extract JSON data from the column
			$jsonData = json_decode($row->family_contact_detail, true); // true to get associative array

			// Check if the JSON data exists
			if ($jsonData) {
				// Unset the key you want to delete
				unset($jsonData[$keyToDelete]);

				// Encode the modified JSON data
				$updatedJsonData = json_encode($jsonData);

				// Update the row in the database with the modified JSON data
				$this->db->where('id', $id);
				$this->db->update('master_employee', ['family_contact_detail' => $updatedJsonData]);
				$this->session->set_userdata('info', "1--Family successfully deleted.");
				return redirect('admin/hr/employees/' . $redirectTo . '/step-2/' . $id);
			} else {
				$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				return redirect('admin/hr/employees/' . $redirectTo . '/step-2/' . $id);
			}
		} else {
			$this->session->set_userdata('info', "2--No data found!");
		}
		return redirect('admin/hr/employees/' . $redirectTo . '/step-2/' . $id);
	}

	public function add_step5()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			// print_r($data['cvs']);exit();
			return $this->load->view('admin/hr-module/employees/add/step-form5', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function save_step5()
	{
		$this->form_validation->set_rules('id', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('id');
			if ($emp_id > 0) {
				$data1 = array(
					'payment_type' => $this->input->post('bank_account_type'),
					'payment_type_detail' => (!empty($this->input->post('payment_type_detail')) ? json_encode($this->input->post('payment_type_detail')) : ''),
				);
				$this->db->where('id', $emp_id);
				$this->db->limit(1);
				$this->db->update('master_employee', $data1);
				$data = array(
					'employee_id' => $this->input->post('id'),
					'gosi_contract_status' => $this->input->post('gosi_contract_status'),
					'gosi_contract_sign_date' => $this->input->post('gosi_contract_sign_date'),
					'gosi_deductible' => $this->input->post('gosi_deductible'),
					'gosi_id' => $this->input->post('gosi_id'),
					'employee_share' => $this->input->post('employee_share'),
					'qiwa_contract_no' => $this->input->post('qiwa_contract_no'),
					'qiwa_contract_status' => $this->input->post('qiwa_contract_status'),
					'qiwa_contract_sign_date' => $this->input->post('qiwa_contract_sign_date'),
					'qiwa_contract_end_date' => $this->input->post('qiwa_contract_end_date'),
					'updated_at' => CURRENT_TIME
				);
				$this->db->where('employee_id', $emp_id);
				$q = $this->db->get('master_employee_info');
				if ($q->num_rows() > 0) {
					$this->db->where('employee_id', $emp_id);
					$query = $this->db->update('master_employee_info', $data);
				} else {
					$this->db->set('employee_id', $emp_id);
					$query = $this->db->insert('master_employee_info', $data);
				}
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully updated step 5.");
					return redirect('admin/hr/employees/add/step-6/' . $emp_id);
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function add_step6()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			$data['emp_docs'] = $this->Employee_model->get_emp_docs($emp_id);
			$data['company_docs'] = $this->Employee_model->get_company_docs($emp_id);
			// print_r($data['cvs']);exit();
			return $this->load->view('admin/hr-module/employees/add/step-form6', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function add_step7()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			$data['trans_info'] = $this->Employee_model->get_trans_info($emp_id);
			// print_r($data['cvs']);exit();
			return $this->load->view('admin/hr-module/employees/add/step-form7', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function save_step7()
	{
		$this->form_validation->set_rules('id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('req_page', 'Request Page From', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('id');
			if ($emp_id > 0) {
				if ($_FILES['trans_attachment']['name']) {
					$con['upload_path']   = './uploads/employee-docs/';
					$con['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
					$con['max_size']      = 0;
					$con['max_width']     = 0;
					$con['max_height']    = 0;
					$con['max_filename'] = '50';
					$con['encrypt_name'] = TRUE;
					$this->load->library('upload', $con);
					if (!$this->upload->do_upload('trans_attachment')) {
						echo $this->upload->display_errors();
						exit;
					} else {
						$image_data = $this->upload->data();
						$image = "uploads/employee-docs/" . $image_data['file_name'];
					}
				} else {
					$image = '';
				}
				$data = array(
					'employee_id' => $this->input->post('id'),
					'type_of_transaction' => $this->input->post('type_of_transaction'),
					'amount' => $this->input->post('amount'),
					'payroll_type' => $this->input->post('payroll_type'),
					'effective_date' => $this->input->post('effective_date'),
					'payment_date' => $this->input->post('payment_date'),
					'trans_attachment' => $image,
					'description' => $this->input->post('description'),
					'created_at' => CURRENT_TIME
				);
				$this->db->set('employee_id', $emp_id);
				$query = $this->db->insert('master_employee_transactions', $data);
				if ($query) {
					$page_redirect = $this->input->post('req_page');
					$this->session->set_userdata('info', "1--Transaction successfully added.");
					return redirect('admin/hr/employees/' . $page_redirect . '/step-7/' . $emp_id);
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Invalid request id!");
			}
		}
		redirect('admin/hr/employees');
	}

	public function add_step8()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$emp_detail = $this->Employee_model->get_detail($emp_id);
			if (isset($emp_detail)) {
				$this->db->select('emp.*, mjt.name as designation_name, md.name as department_name');
				$this->db->from('master_employee emp');
				$this->db->join('master_job_title mjt', 'emp.designation = mjt.id', 'left');
				$this->db->join('master_department md', 'emp.department = md.id', 'left');
				$this->db->where('emp.work_line_manager', $emp_detail->id);
				$this->db->where('emp.work_line_manager IS NOT NULL');
				$this->db->where('emp.work_line_manager !=', 0);
				$team_query = $this->db->get();

				$team_members = $team_query->result();
			} else {
				$team_members = [];
			}
			// Load view and pass team members data
			$data['team_members'] = $team_members;
			$data['emp_detail'] = $emp_detail;
			//print_r($data);exit();
			return $this->load->view('admin/hr-module/employees/add/step-form8', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	// public function upload_profile_pic()
	// {
	// 	$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
	// 	if (empty($_FILES['employee_pic']['name'])) {
	// 		$this->form_validation->set_rules('employee_pic', 'Employee Profile Pic', 'required');
	// 	}
	// 	if ($this->form_validation->run() == FALSE) {
	// 		$data = array("type" => 'error', "message" => validation_errors());
	// 	} else {
	// 		$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . $this->input->post('emp_id') . "'");
	// 		if ($query->num_rows() > 0) {
	// 			$query2 = $this->Employee_model->uploadProfilePic();
	// 			if ($query2) {
	// 				$profile_pic = $this->db->query("SELECT employee_pic FROM master_employee WHERE id = '" . $this->input->post('emp_id') . "'")->row();
	// 				$profile_picture_url = $profile_pic->employee_pic;
	// 				$data = array("type" => 'success', "message" => 'Profile picture successfully updated', "profile_picture_url" => $profile_picture_url);
	// 			} else {
	// 				$data = array("type" => 'error', "message" => 'Something went wrong, try again');
	// 			}
	// 		} else {
	// 			$data = array("type" => 'error', "message" => 'Unauthorized request');
	// 		}
	// 	}
	// 	echo json_encode($data);
	// }

	public function upload_profile_pic()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(["type" => "error", "message" => validation_errors()]);
			return;
		}

		if (!isset($_FILES['employee_pic'])) {
			echo json_encode(["type" => "error", "message" => "No image received"]);
			return;
		}

		$emp_id = $this->input->post('emp_id');

		// call model
		$result = $this->Employee_model->uploadProfilePic($emp_id);

		if ($result['status'] === true) {
			echo json_encode([
				"type" => "success",
				"message" => "Profile picture updated",
				"profile_picture_url" => $result['image']
			]);
		} else {
			echo json_encode([
				"type" => "error",
				"message" => $result['error']
			]);
		}
	}
	
	public function remove_profile_pic()
	{
		$emp_id = $this->input->post('emp_id');

		if (!$emp_id) {
			echo json_encode(["type" => "error", "message" => "Invalid request"]);
			return;
		}

		$emp = $this->db->get_where("master_employee", ["id" => $emp_id])->row();

		if (!$emp) {
			echo json_encode(["type" => "error", "message" => "Employee not found"]);
			return;
		}

		// Delete file if exists
		if (!empty($emp->employee_pic) && file_exists(FCPATH . $emp->employee_pic)) {
			unlink(FCPATH . $emp->employee_pic);
		}

		// Update DB to empty
		$this->db->where("id", $emp_id)->update("master_employee", [
			"employee_pic" => ""
		]);

		echo json_encode(["type" => "success", "message" => "Profile picture removed successfully"]);
	}

	/*------ Employee Detail Start -----*/

	public function view_step1($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($id);
			$alloted_sim_detail = $this->db->query("SELECT mobile FROM sim_card WHERE (alloted_user = '" . (int)$id . "' AND allotment = '1')")->row();
			$data['alloted_mobile_no'] = $alloted_sim_detail->mobile ?? '';
			$this->load->view('admin/hr-module/employees/view/step-form1', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/hr/employees');
		}
	}

	public function view_step2()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			return $this->load->view('admin/hr-module/employees/view/step-form2', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step3()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['active_contract'] = $this->Employee_model->get_active_contract($emp_id);
			$data['expired_contract'] = $this->Employee_model->get_expired_contract($emp_id);
			return $this->load->view('admin/hr-module/employees/view/step-form3', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step4()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			if (!empty($data['emp_info'])) {
				return $this->load->view('admin/hr-module/employees/view/step-form4', $data);
			} else {
				$this->session->set_userdata('info', "2--No data found, Please add data of step 4 first!");
				return redirect('admin/hr/employees/view/step-3/' . $emp_id);
			}
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step5()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			if (!empty($data['emp_info'])) {
				return $this->load->view('admin/hr-module/employees/view/step-form5', $data);
			} else {
				$this->session->set_userdata('info', "2--No data found, Please add data of step 4 first!");
				return redirect('admin/hr/employees/view/step-3/' . $emp_id);
			}
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step6()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			$data['emp_docs'] = $this->Employee_model->get_emp_docs($emp_id);
			$data['company_docs'] = $this->Employee_model->get_company_docs($emp_id);
			return $this->load->view('admin/hr-module/employees/view/step-form6', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step7()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			$data['trans_info'] = $this->Employee_model->get_trans_info($emp_id);
			return $this->load->view('admin/hr-module/employees/view/step-form7', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step8()
	{
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$emp_detail = $this->Employee_model->get_detail($emp_id);
			if (isset($emp_detail)) {
				$this->db->select('emp.*, mjt.name as designation_name, md.name as department_name');
				$this->db->from('master_employee emp');
				$this->db->join('master_job_title mjt', 'emp.designation = mjt.id', 'left');
				$this->db->join('master_department md', 'emp.department = md.id', 'left');
				$this->db->where('emp.work_line_manager', $emp_detail->id);
				$this->db->where('emp.work_line_manager IS NOT NULL');
				$this->db->where('emp.work_line_manager !=', 0);
				$team_query = $this->db->get();

				$team_members = $team_query->result();
			} else {
				$team_members = [];
			}
			// Load view and pass team members data
			$data['team_members'] = $team_members;
			$data['emp_detail'] = $emp_detail;
			//print_r($data);exit();
			return $this->load->view('admin/hr-module/employees/view/step-form8', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step9()
	{
		$this->load->model('admin/hr-module/Accident_model');
		$emp_id = $this->uri->segment(6);

		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			$logs = $this->Vehicle_log_model->employee_wise_log($emp_id);

			$grouped_logs = [];

			foreach ($logs as $log) {
				$vehicle_id = $log['vehicle_id'];
				$log_status = $log['log_status'];

				// Initialize vehicle block if not exists
				if (!isset($grouped_logs[$vehicle_id])) {
					$grouped_logs[$vehicle_id] = [
						'vehicle_id' => $vehicle_id
					];
				}

				// Assign log under its status (alloted, unalloted, return)
				$grouped_logs[$vehicle_id][$log_status] = $log;
			}

			// Re-index to ensure numeric array for views
			$data['vehicle_logs'] = array_values($grouped_logs);
			$data['accident_logs'] = $this->Accident_model->employeewise_accident_log($emp_id);

			//dd($logs); // You can remove this after verification

			return $this->load->view('admin/hr-module/employees/view/step-form9', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	public function view_step10()
	{
		$this->load->model('admin/hr-module/Accident_model');
		$emp_id = $this->uri->segment(6);
		if ($emp_id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($emp_id);
			$data['emp_info'] = $this->Employee_model->get_emp_info($emp_id);
			$data['sim_logs'] = $this->Employee_model->getSimLogsByUser($emp_id);
			$data['assets_logs'] = [];
			//dd($data['sim_logs']);
			return $this->load->view('admin/hr-module/employees/view/step-form10', $data);
		} else {
			redirect('admin/hr/employees');
		}
	}

	/*------ Employee Detail Routes End -----*/

	/*------ Employee Request Start -----*/

	public function add_request_form()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('request_type', 'Request Type', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid Request ID</strong></div>';
			exit();
		} else {
			$emp_id = $this->input->post('emp_id');
			$request_type = $this->input->post('request_type');
			$employee_info = $this->Employee_model->get_detail($emp_id);
			if (!empty($employee_info)) {
				$data['emp_detail'] = $employee_info;
				if ($request_type == 'Loan request') {
					$output_data = $this->load->view('admin/hr-module/employees/requests/loan-request', $data, TRUE);
				} elseif ($request_type == 'Asset request') {
					$output_data = $this->load->view('admin/hr-module/employees/requests/asset_request', $data, TRUE);
				} elseif ($request_type == 'Driving license request') {
					$output_data = $this->load->view('admin/hr-module/employees/components/dl-request', $data, TRUE);
				} elseif ($request_type == 'Clinical visit request') {
					$output_data = $this->load->view('admin/hr-module/employees/components/clinical-visit-request', $data, TRUE);
				} elseif ($request_type == 'offer_letter') {
					$output_data = $this->load->view('admin/hr-module/employees/components/loan-request', $data, TRUE);
				} elseif ($request_type == 'Leave request') {
					$output_data = $this->load->view('admin/hr-module/employees/components/add-leave-request', $data, TRUE);
				} elseif ($request_type == 'Employee notices and warnings') {
					$output_data = $this->load->view('admin/hr-module/employees/components/notices-warning', $data, TRUE);
				} elseif ($request_type == 'Transfer request') {
					$data['current_employer'] = $this->db->query("SELECT id, employer_id, employer_name FROM sponsors where id = ".$employee_info->sponsor_id)->row_array();
					$output_data = $this->load->view('admin/hr-module/employees/components/transfer-request', $data, TRUE);
				} elseif ($request_type == 'Change profession request') {
					$output_data = $this->load->view('admin/hr-module/employees/components/change_profession_request', $data, TRUE);
				} elseif ($request_type == 'Vehicle allotment request') {
					$data['alloted_vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mv.gasoline_chip_status, mv.chassis_no, mv.sequel_no, mv.vehicle_ownership, mv.owner_name_select, mv.allotment_status, mv.alloted_user, mvk.make_name, mc.color_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_color mc ON (mc.id = mv.vehicle_color) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
					$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
					//dd($data);
					if(!empty($data['alloted_vehicle_detail'])){
						$current_allotment_status = $data['alloted_vehicle_detail']['allotment_status'];
						$data['last_meter_reading'] = $this->vehicle_model->get_last_meter_reading($data['alloted_vehicle_detail']['id']);
						//If vehicle is already alloted to employee then show unallotment request form
						if($current_allotment_status == 'alloted'){
							$output_data = $this->load->view('admin/hr-module/employees/components/vehicle-unallotment-request', $data, TRUE);
						}elseif($current_allotment_status == 'unalloted'){
							$output_data = $this->load->view('admin/hr-module/employees/components/vehicle-return-request', $data, TRUE);
						}
					}else{
						$data['unalloted_vehicles'] = $this->vehicle_model->unalloted_vehicles();
						$data['existing_employee_request'] = $this->Employee_model->check_existing_employee_request('VehicleAllotmentRequest', $emp_id);
						$output_data = $this->load->view('admin/hr-module/employees/components/vehicle-allotment-request', $data, TRUE);
					}
				}
				echo $output_data;
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>No data found</strong></div>';
				exit();
			}
		}
	}
	
	public function get_vehicle_detail()
	{
		$this->form_validation->set_rules('vehicle_id', 'Vehicle ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$vehicle_id = $this->input->post('vehicle_id');
			$data['vehicle_detail'] = $this->vehicle_model->detail($vehicle_id)->row_array();
			$data['last_meter_reading'] = $this->vehicle_model->get_last_meter_reading($vehicle_id);
			$output_data = $this->load->view('admin/hr-module/employees/components/vehicle_detail', $data, TRUE);
			$result = array("type" => 'success', "message" => '', "output_html" => $output_data);
		}
		echo json_encode($result);
	}

	public function add_loan()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('loan_type', 'Contract Type', 'trim|required');
		$this->form_validation->set_rules('loan_amount', 'Contract Duration', 'trim|required');
		$this->form_validation->set_rules('deduction_start_date', 'Start Date', 'trim|required');
		$this->form_validation->set_rules('calculation_type', 'End Date', 'trim|required');
		$this->form_validation->set_rules('specified_value', 'Contract Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$emp_id = $this->input->post('emp_id');
			if ($_FILES['attachment']['name']) {
				$con['upload_path']   = './uploads/employee-docs/';
				$con['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
				$con['max_size']      = 0;
				$con['max_width']     = 0;
				$con['max_height']    = 0;
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('attachment')) {
					echo $this->upload->display_errors();
					exit;
				} else {
					$image_data = $this->upload->data();
					$image = "uploads/employee-docs/" . $image_data['file_name'];
				}
			} else {
				$image = '';
			}
			//print_r(date('Y-m-d', strtotime($this->input->post('deduction_start_date'))));exit();
			$data = array(
				'employee_id' => $this->input->post('emp_id'),
				'loan_type' => $this->input->post('loan_type'),
				'loan_amount' => $this->input->post('loan_amount'),
				'deduction_start_date' => date('Y-m-d', strtotime($this->input->post('deduction_start_date'))),
				'calculation_type' => $this->input->post('calculation_type'),
				'specified_value' => $this->input->post('specified_value'),
				'loan_reason' => $this->input->post('loan_reason'),
				'attachment' => $image,
				'updated_at' => CURRENT_TIME
			);
			$this->db->where('id', $emp_id);
			$q = $this->db->get('master_employee');
			if ($q->num_rows() > 0) {
				$this->db->set('employee_id', $emp_id);
				$query = $this->db->insert('loan_request', $data);
				if ($query) {
					$this->session->set_userdata('info', "1--Loan successfully added.");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, Try again!");
				}
			} else {
				$this->session->set_userdata('info', "2--Requested employee not exist.");
			}
		}
		return redirect('admin/hr/employees/view/step-1/' . $emp_id);
	}

	//Loan Request Form
	public function print_loan_req_form()
	{
		$this->load->library('Pdf_employee_offer');

		$id = $this->input->get('id');
		$data['emp_detail'] = $this->Employee_model->get_detail($id);
		if ($data['emp_detail'] !== '') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Personal Finance Request Form');
			$pdf->SetSubject('BS - Personal Finance Request Form');
			$pdf->SetKeywords('Baqala Station, PDF, Personal Finance Request Form, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 10, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
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
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/employees/requests/print_loan_request', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			//$pdf->Output('New Arrival Food Advance Request Form - '. $data['emp_detail']->emp_no .'.pdf', 'I');
			$pdf->Output('LoanRequestForm-' . $data['emp_detail']->emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/hr/employees');
		}
	}

	//Absconded Request Form
	public function print_reporting_absconded()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');

		$id = $this->input->get('id');
		$data['emp_detail'] = $this->Employee_model->get_detail($id);
		if ($data['emp_detail'] !== '') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Personal Finance Request Form');
			$pdf->SetSubject('BS - Personal Finance Request Form');
			$pdf->SetKeywords('Baqala Station, PDF, Personal Finance Request Form, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 10, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
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
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/employees/requests/reporting_absconded', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			//$pdf->Output('New Arrival Food Advance Request Form - '. $data['emp_detail']->emp_no .'.pdf', 'I');
			$pdf->Output('Reporting-Absconded-' . $data['emp_detail']->emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/hr/employees');
		}
	}

	//Absence Notification
	public function print_absence_notification()
	{
		$this->load->library('Pdf_employee_offer');

		$id = $this->input->get('id');
		$data['emp_detail'] = $this->Employee_model->get_detail($id);
		$data['rider_order_summary'] = $this->Employee_model->get_last_rider_order_summary($id);
		//echo '<pre>'; print_r($data);exit();
		if ($data['emp_detail'] !== '') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Absence from the Workplace Notification');
			$pdf->SetSubject('BS - Absence from the Workplace Notification');
			$pdf->SetKeywords('Baqala Station, PDF, Absence from the Workplace Notification, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 10, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
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
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/employees/requests/absence_notification', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			//$pdf->Output('New Arrival Food Advance Request Form - '. $data['emp_detail']->emp_no .'.pdf', 'I');
			$pdf->Output('Absence-Notification-' . $data['emp_detail']->emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/hr/employees');
		}
	}

	// Job Offer Letter
	public function print_job_offer($id)
	{
		$this->load->library('Pdf_salary_structure');
		$data['emp_detail'] = $this->Employee_model->get_detail($id);
		if ($data['emp_detail'] !== '') {
			$emp_no = $data['emp_detail']->emp_no;
			//dd($data);
			// create new PDF document
			$pdf = new Pdf_salary_structure(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$pdf->showBackground = true;
			$pdf->setWatermark(FCPATH . 'admin_assets/images/stamp-signature.png');
			$pdf->setPrintHeader(true);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Job Offer Letter');
			$pdf->SetSubject('BS - Job Offer Letter');
			$pdf->SetKeywords('Baqala Station, PDF, Job Offer Letter, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 0, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(false, 2);
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
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English 
			if ($data['emp_detail']->designation == '18') {
				$htmlcontent = $this->load->view('admin/hr-module/employees/print/car-job-offer', $data, true);
			} else {
				$htmlcontent = $this->load->view('admin/hr-module/employees/print/bike-job-offer', $data, true);
			}
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Job-Offer-' . $emp_no . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/hr/employees');
		}
	}

	public function print_promissory_note($id = 0)
	{
		$this->load->library('Pdf_promissory_note');
		if ($id > 0) {
			$data['emp_detail'] = $this->Employee_model->get_detail($id);
			if ($data['emp_detail'] !== '') {
				$emp_no = $data['emp_detail']->emp_no;
				// print_r($order);exit();
				// create new PDF document
				$pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Rider Promissory Note');
				$pdf->SetSubject('BS - Rider Promissory Note');
				$pdf->SetKeywords('Baqala Station, PDF, Promissory Note, Rider');

				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);

				$lastFooter = '';
				$pdf->setHtmlFooter($lastFooter);

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
				$pdf->SetMargins(5, 60, 10, true);

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
				$pdf->AddPage();
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/hr-module/employees/print/promissory_note', $data, true);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('BS Promissory Note ' . $emp_no . '.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--Employee detail not found.");
				redirect('admin/hr/employees');
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/hr/employees');
		}
	}

	public function print_contract_letter($id = 0)
	{
		if ($id > 0) {
			$this->load->library('Pdf_employee_contract');
			$data['emp_detail'] = $this->Employee_model->get_detail($id);
			if ($data['emp_detail'] !== '') {
				$emp_no = $data['emp_detail']->emp_no;
				$emp_name = $data['emp_detail']->full_name;
				$file_name = $emp_no . '_' . $emp_name;
				// print_r($order);exit();
				// create new PDF document
				$pdf = new Pdf_employee_contract(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->setWatermark($file_name);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Employment Contract');
				$pdf->SetSubject('BS - Employment Contract');
				$pdf->SetKeywords('Baqala Station, PDF, Employment Contract, Rider');

				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true);
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);

				$lastFooter = '';
				$pdf->setHtmlFooter($lastFooter);

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
				$pdf->SetMargins(10, 10, 11, true);
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, 15);
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
				$pdf->AddPage();
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				if ($data['emp_detail']->designation == '18') {
					$htmlcontent = $this->load->view('admin/hr-module/employees/print/car-driver-contract', $data, true);
				} else {
					$htmlcontent = $this->load->view('admin/hr-module/employees/print/bike-rider-contract', $data, true);
				}
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('Contract_' . $file_name . '.pdf', 'I');
			} else {
				$this->session->set_userdata('info', "2--Employee detail not found!");
				redirect('admin/hr/employees');
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/hr/employees');
		}
	}

	public function sendManualCredential()
	{
		$id = $this->input->get("id");
		if ($id > 0) {
			$result = $this->db->query("SELECT id, local_email, password from master_employee WHERE id = '" . $id . "'");
			if ($result->num_rows() > 0) {
				$emp_detail = $result->row();
				$id = $emp_detail->id;
				$email = $emp_detail->local_email;
				$password = $this->role->get_random_password($chars_min = 10, $chars_max = 10, $use_upper_case = true, $include_numbers = true, $include_special_chars = true);
				$hashpassword = password_hash($password, PASSWORD_DEFAULT);
				//password_verify('rasmuslerdorf', $hash)
				$update_password = $this->db->query("UPDATE master_employee SET password = '" . $hashpassword . "'  WHERE id = '" . $id . "' LIMIT 1");
				if ($update_password) {
					$response = send_employee_credential($email, $password);
					if ($response) {
						$this->session->set_userdata('info', "1--Successfully send");
						redirect('admin/hr/employees/detail?id=' . $id);
					} else {
						$this->session->set_userdata('info', "2--Error");
					}
				} else {
					$this->session->set_userdata('info', "2--Problem in generating new password.");
				}
			} else {
				$this->session->set_userdata('info', "2--User not found");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request");
		}
		redirect('admin/hr/employees');
	}

	public function change_password()
	{
		$this->form_validation->set_rules('emp_id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|min_length[6]|max_length[50]|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('admin/hr/employees');
		} else {
			$id  = $this->input->post('emp_id');
			$result = $this->db->query("SELECT id, emp_no, email, password from master_employee WHERE id = '" . $id . "'");
			if ($result->num_rows() > 0) {
				$emp_detail = $result->row();
				$id = $emp_detail->id;
				$email = $emp_detail->email;
				$emp_no = $emp_detail->emp_no;
				$password = $this->input->post('password');
				$hashpassword = password_hash($password, PASSWORD_DEFAULT);
				$update_password = $this->db->query("UPDATE master_employee SET password = '" . $hashpassword . "', send_credential = '" . $this->input->post('send_credential') . "' WHERE id = '" . $id . "' LIMIT 1");
				if ($update_password) {
					if ($this->input->post('send_credential') == 'on') {
						send_employee_credential($emp_no, $email, $password);
					}
					$this->session->set_userdata('info', "1--Password successfully updated");
					redirect('admin/hr/employees/edit/step-1/' . $id);
				} else {
					$this->session->set_userdata('info', "2--Problem in updating new password.");
				}
			} else {
				$this->session->set_userdata('info', "2--User not found");
			}
		}
		redirect('admin/hr/employees/edit/step-1/' . $id);
	}

	public function check_passport_duplicate()
	{
		$id = $this->input->post('id');
		$passport_no = $this->input->post('passport_no');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Employee_model->check_duplicate_passport($id, $passport_no);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function check_email_duplicate()
	{
		$id = $this->input->post('id');
		$email = $this->input->post('email');
		$duplicate_check = $this->Employee_model->check_duplicate_email($id, $email);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function check_empid_duplicate()
	{
		$id = $this->input->post('id');
		$emp_no = $this->input->post('emp_no');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Employee_model->check_duplicate_empid($id, $emp_no);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function ajax_check_passport()
	{
		$passport_no = $this->input->post('passport_no');
		$id = $this->input->post('id');
		if ($passport_no !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Employee_model->check_duplicate_passport($id, $passport_no);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $passport_no . "</b> This passport already used. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Passport Checked.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Passport is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_empid()
	{
		$emp_no = $this->input->get('emp_no');
		$id = '';
		if ($emp_no !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Employee_model->check_duplicate_empid($id, $emp_no);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $emp_no . "</b> This Employee ID already exists. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Employee ID Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Employee ID is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_email()
	{
		$email = $this->input->get('email');
		$id = $this->input->get('id');
		if ($email !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Employee_model->check_duplicate_email($id, $email);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $email . "</b> This Email ID already used. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Email ID Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Email ID is required.</span>";
		}
		echo json_encode($data);
	}

	public function detail()
	{
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$data['emp_detail'] = $this->Employee_model->get_detail($id);

			$this->load->view('admin/hr-module/employees/detail', $data);
		} else {
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/hr/employees');
		}
	}

	public function show_status_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->Employee_model->get_detail($id);
			if ($query) {
				$data['emp_detail'] = $query;
				$emp_id = $query->id;
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/hr-module/employees/components/manage-status', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Employee detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Employee detail not found, try another employee id.');
			}
		}
		echo json_encode($result);
	}

	public function update_status_form()
	{
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required|integer');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[Active,Terminated]');

		if ($this->input->post('status') === 'Terminated') {
			$this->form_validation->set_rules('terminate_reason', 'Terminate Reason', 'trim|required');
			$this->form_validation->set_rules('last_working_date', 'Last Working Date', 'trim|required|callback_validate_date');
		}

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(array("type" => 'error', "message" => validation_errors()));
			return;
		}

		$id = $this->input->post('employee_id', TRUE);
		$status = $this->input->post('status', TRUE);
		$reason = $this->input->post('terminate_reason', TRUE);
		$last_working_date = $this->input->post('last_working_date', TRUE);
		$isRemovalSelected = $this->input->post('remove_reporting_roles', TRUE);

		// --- Business validations ---
		if ($status === 'Terminated' && $reason !== 'Absconded') {
			// vehicle check
			$vehicleDetail = $this->Employee_model->getVehicleByUser($id);
			if ($vehicleDetail) {
				echo json_encode([
					"type" => 'error',
					"message" => 'Vehicle (#' . $vehicleDetail->vehicle_no . ') is alloted to this employee, Unallot first.'
				]);
				return;
			}

			// sim check
			$simDetail = $this->Employee_model->getSimByUser($id);
			if ($simDetail) {
				echo json_encode([
					"type" => 'error',
					"message" => 'SIM Card (#' . $simDetail->sim_no . ') is alloted to this employee, Unallot first.'
				]);
				return;
			}

			// aggregator check
			$allotedAggregator = $this->Employee_model->getAggregatorId($id);
			if ($allotedAggregator && $allotedAggregator->allotment_status === '1') {
				echo json_encode([
					"type" => 'error',
					"message" => 'Rider ID (#' . $allotedAggregator->id_number . ') is alloted to this employee, Unallot Rider Id First.'
				]);
				return;
			}

			// DL status check
			$dlStatus = $this->Employee_model->getDlStatus($id);
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

		// --- Prepare data for update ---
		$data = [
			'status'      => $status,
			'status_date' => date('Y-m-d H:i:s'),
			'updated_at'  => date('Y-m-d H:i:s')
		];

		if ($status === 'Terminated') {
			$data['terminate_reason']  = $reason;
			$data['last_working_date'] = date('Y-m-d', strtotime($last_working_date));
		} else {
			$data['terminate_reason']  = NULL;
			$data['last_working_date'] = NULL;
		}

		// --- Transaction start ---
		$this->db->trans_start();

		$this->Employee_model->update_status($id, $data);

		if ($isRemovalSelected) {
			$this->Employee_model->remove_reporting_roles($id);
		}

		// ✅ If Terminated, mark rider inactive
		if ($status === 'Terminated') {
			$this->db->where('employee_id', $id);
			$this->db->update('logistic_rider', [
				'rider_status' => 'inactive',
				'updated_at'   => date('Y-m-d H:i:s')
			]);
		}

		$this->db->trans_complete();
		// --- Transaction end ---

		if ($this->db->trans_status() === FALSE) {
			$result = ["type" => 'error', "message" => 'Status not updated. Transaction failed!'];
		} else {
			$result = ["type" => 'success', "message" => 'Status successfully updated.'];
		}

		echo json_encode($result);
	}

	// Callback for date validation
	public function validate_date($date)
	{
		if (!strtotime($date)) {
			$this->form_validation->set_message('validate_date', 'The {field} is not a valid date.');
			return false;
		}

		if (strtotime($date) > strtotime(date('Y-m-d'))) {
			$this->form_validation->set_message('validate_date', 'The {field} cannot be a future date.');
			return false;
		}

		return true;
	}
	
	public function show_iqama_form()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->Employee_model->get_detail($id);
			if ($query) {
				$data['emp_detail'] = $query;
				$emp_id = $query->id;
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$output_data = $this->load->view('admin/hr-module/employees/components/update_iqama_detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Iqama detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Iqama detail not found, try another employee id.');
			}
		}
		echo json_encode($result);
	}
	
	public function update_iqama_detail()
	{
		$this->form_validation->set_rules('employee_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'ID/Iqama Number', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo json_encode(['type' => 'error', 'message' => $msg]);
			return;
		}

		$emp_id = $this->input->post('employee_id');
		$iqama_issue_date  = $this->input->post('iqama_issue_date', true);
		$iqama_expiry_date = $this->input->post('iqama_expiry_date', true);

		// ✅ Server-side validation — Expiry date must be greater than Issue date
		if (!empty($iqama_issue_date) && !empty($iqama_expiry_date)) {
			if (strtotime($iqama_expiry_date) <= strtotime($iqama_issue_date)) {
				echo json_encode([
					'type' => 'error',
					'message' => 'Iqama Expiry Date must be greater than Iqama Issue Date.'
				]);
				return;
			}
		}

		// Hijri conversion
		$iqama_issue_date_hijri  = ($iqama_issue_date) ? ReturnGreg2Hijri($iqama_issue_date) : '';
		$iqama_expiry_date_hijri = ($iqama_expiry_date) ? ReturnGreg2Hijri($iqama_expiry_date) : '';

		$iqama_data = [
			'iqama_no' => $this->input->post('iqama_no', true),
			'iqama_name_en' => $this->input->post('iqama_name_en', true),
			'iqama_name_ar' => $this->input->post('iqama_name_ar', true),
			'iqama_profession' => $this->input->post('iqama_profession', true),
			'iqama_issue_date' => $iqama_issue_date,
			'iqama_expiry_date' => $iqama_expiry_date,
			'iqama_issue_date_hijri' => $iqama_issue_date_hijri,
			'iqama_expiry_date_hijri' => $iqama_expiry_date_hijri,
			'iqama_issue_city' => $this->input->post('iqama_issue_city', true),
			'updated_at' => date('Y-m-d H:i:s')
		];

		$saved = $this->Employee_model->update_iqama_detail($emp_id, $iqama_data);

		if ($saved) {
			echo json_encode(['type' => 'success', 'message' => 'Iqama detail updated successfully']);
			return;
		} else {
			echo json_encode(['type' => 'error', 'message' => 'Failed to update Iqama detail']);
			return;
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Employee_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/employees');
	}

	public function delete_image()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
			$this->form_validation->set_rules('img_id', 'Image ID', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array("type" => 'error', "message" => 'Invalid Request Type');
			} else {
				$query = $this->Employee_model->delete_image();
				if ($query) {
					$data = array("type" => 'success', "message" => 'Image successfully deleted');
				} else {
					$data = array("type" => 'error', "message" => 'Something went wrong, Try again');
				}
			}
		} else {
			$data = array("type" => 'error', "message" => 'Session expired, Please login again. <a href="' . base_url('admin') . '" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
	}

	public function show_documents_form()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('empid', 'ID', 'trim|required');
			$this->form_validation->set_rules('type', 'Type', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg = validation_errors();
				$data = array("type" => 'error', "message" => 'Unauthorized access');
			} else {
				$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . $this->input->post('empid') . "'");
				if ($query->num_rows() > 0) {
					$cv_info = $query->row();
					$data['empid'] = $this->input->post('empid');
					$data['type'] = $this->input->post('type');
					$data = array("type" => 'success', "message" => $this->load->view('admin/hr/employees/upload-documents', $data, TRUE));
				} else {
					$data = array("type" => 'success', "message" => 'Unauthorized access');
				}
			}
		} else {
			$data = array("type" => 'error', "message" => 'Session expired, Please login again. <a href="' . base_url('admin') . '" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
	}

	public function upload_documents_form()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('doc_type', 'Document Type', 'trim|required');
		//$this->form_validation->set_rules('doc_category', 'Document Category', 'trim|required');
		if (empty($_FILES['document']['name'])) {
			$this->form_validation->set_rules('document', 'Employee Document', 'required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('admin/hr/employees');
		} else {
			$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . $this->input->post('emp_id') . "'");
			if ($query->num_rows() > 0) {
				$query2 = $this->Employee_model->uploadDocuments();
				if ($query2) {
					$this->session->set_userdata('info', "1--Document successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, try again");
				}
			} else {
				$this->session->set_userdata('info', "2--Unauthorized request");
			}
		}
		redirect('admin/hr/employees/add/step-6/' . $this->input->post('emp_id'));
	}

	public function upload_comp_documents()
	{
		$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
		$this->form_validation->set_rules('doc_type', 'Company Document Type', 'trim|required');
		//$this->form_validation->set_rules('doc_category', 'Document Category', 'trim|required');
		if (empty($_FILES['document']['name'])) {
			$this->form_validation->set_rules('document', 'Company Document', 'required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('admin/hr/employees');
		} else {
			$query = $this->db->query("SELECT * FROM master_employee WHERE id = '" . $this->input->post('emp_id') . "'");
			if ($query->num_rows() > 0) {
				$query2 = $this->Employee_model->uploadCompanyDocuments();
				if ($query2) {
					$this->session->set_userdata('info', "1--Document successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, try again");
				}
			} else {
				$this->session->set_userdata('info', "2--Unauthorized request");
			}
		}
		redirect('admin/hr/employees/add/step-6/' . $this->input->post('emp_id'));
	}

	/*----- Bulk Import Employee -----*/
	public function import_file()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$path = 'uploads/imports/employee/';
		$json = [];

		$this->upload_config($path);

		try {
			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors());
			}

			$file_data = $this->upload->data();
			$file_name = $path . $file_data['file_name'];
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);

			if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
				throw new Exception('Unsupported file format.');
			}

			$reader = $this->getReaderByExtension($extension);
			$spreadsheet = $reader->load($file_name);
			$sheet_data = $spreadsheet->getActiveSheet()->toArray();

			// Validate the number of columns
			//$this->validateColumnCount($sheet_data);

			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);

			// Initialize transaction
			$this->db->trans_start();

			$batch_data = [];
			$duplicate_rows = [];

			foreach ($sheet_data as $val) {
				//print_r(dateFormatHelper($val[8]));exit();
				if ($val[1] != '') {
					$result = $this->Employee_model->checkDuplicateInBulk([
						"emp_no" => $val[1],
						"iqama_no" => $val[14],
						"passport_no" => $val[22]
					]);
					if (!$result) {
						// Your existing logic to prepare data for insertion
						$password = $this->role->get_random_password($chars_min = 10, $chars_max = 10, $use_upper_case = true, $include_numbers = true, $include_special_chars = true);
						$hashpassword = password_hash($password, PASSWORD_DEFAULT);
						if ($val[39] !== '') {
							$payment_detail = [
								"bank_account_type" => "Bank",
								"account_type" => "Bank Account",
								"bank_name" => $val[39],
								"iban_no" => $val[40]
							];
						} else {
							$payment_detail = [
								"bank_account_type" => "Bank",
								"account_type" => "Bank Account",
								"bank_name" => '',
								"iban_no" => ''
							];
						}
						if ($val[49] !== '') {
							$joining_date = dateFormatHelper($val[49]);
							$joining_date_hijri = ReturnGreg2Hijri($joining_date);
						} else {
							$joining_date = '';
							$joining_date_hijri = '';
						}

						$batch_data[] = [
							"emp_no" => $val[1],
							"first_name" => $val[2],
							"second_name" => $val[3],
							"third_name" => $val[4],
							"last_name" => $val[5],
							"full_name" => $val[6],
							"employee_arabic_name" => $val[7],
							"dob" => (($val[8] != '') ? dateFormatHelper($val[8]) : ''),
							"gender" => $val[9],
							"marital_status" => $val[10],
							"religion" => $val[11],
							"mobile" => $val[12],
							"email" => $val[13],
							"iqama_no" => $val[14],
							"iqama_name_en" => $val[15],
							"iqama_name_ar" => $val[16],
							"iqama_profession" => $val[17],
							"iqama_issue_city" => $val[18],
							"iqama_issue_date" => (($val[19] != '') ? dateFormatHelper($val[19]) : ''),
							"iqama_expiry_date" => (($val[20] != '') ? dateFormatHelper($val[20]) : ''),
							"nationality" => $val[21],
							"passport_no" => $val[22],
							"passport_issue_date" => (($val[23] != '') ? dateFormatHelper($val[23]) : ''),
							"passport_expiry_date" => (($val[24] != '') ? dateFormatHelper($val[24]) : ''),
							"passport_issue_country" => $val[25],
							"passport_issue_city" => $val[26],

							"status" => 'Active',
							"password" => $hashpassword,
							"login_ip" => $this->ip_address,

							"department" => $val[27],
							"designation" => $val[28],
							"business_unit" => $val[29],
							"work_line_manager" => $val[30],
							"direct_manager" => $val[31],
							"department_head" => $val[32],
							"employment_type" => $val[33],
							"working_hours" => $val[34],
							"working_days" => $val[35],
							"work_location" => $val[36],
							"work_country" => $val[37],
							"work_city" => $val[38],
							"payment_type" => 'Bank',
							"payment_type_detail" => json_encode($payment_detail),
							"basic_salary" => $val[41],
							"housing_allowance" => $val[42],
							"transport_allowance" => $val[43],
							"food_allowance" => $val[44],
							"mobile_allowance" => $val[45],
							"other_allowance" => $val[46],
							"total_package" => $val[47],
							"annual_leave_entitlement" => $val[48],
							"absher_mobile" => $val[49],
							"work_joining_date" => $joining_date,
							"joining_date_hijri" => $joining_date_hijri,
							"created_at" => $this->datetime,
							"updated_at" => $this->datetime
						];
					} else {
						// Add the row to the list of duplicates
						$duplicate_rows[] = $val;
					}
				}

				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = []; // Clear batch data after insertion
				}
			}

			// Insert any remaining data
			if (!empty($batch_data)) {
				$this->insertBatchData($batch_data);
			}

			// Commit transaction
			$this->db->trans_complete();

			// Delete the file
			if (file_exists($file_name)) {
				unlink($file_name);
			}

			// Check if there were any duplicate rows
			if (!empty($duplicate_rows)) {
				$json = [
					'error_message' => 'Duplicate rows found, rest all inserted.',
					'duplicate_rows' => $duplicate_rows
				];
			} else {
				$json = [
					'success_message' => 'All Entries are imported successfully.',
				];
			}
		} catch (Exception $e) {
			// Rollback transaction if any error occurs
			$this->db->trans_rollback();
			$json = [
				'error_message' => $e->getMessage()
			];
		}

		echo json_encode($json);
		exit();
	}

	private function getReaderByExtension($extension)
	{
		switch ($extension) {
			case 'csv':
				return new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			case 'xlsx':
			case 'xls':
				return new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			default:
				throw new Exception('Unsupported file format.');
		}
	}

	private function insertBatchData($batch_data)
	{
		$result = $this->db->insert_batch('master_employee', $batch_data);

		if (!$result) {
			$json = [
				'error_message' => 'Something went wrong. Please try again.',
			];
			echo json_encode($json);
			exit();
		}
	}

	// private function validateColumnCount($sheet_data) {
	// 	foreach ($sheet_data as $index => $row) {
	// 		if (count($row) !== 49) {
	// 			throw new Exception("Row " . ($index + 1) . " does not have exactly 50 columns." . count($row));
	// 		}
	// 	}
	// }

	public function upload_config($path)
	{
		if (!is_dir($path)) {
			mkdir($path, 0777, TRUE);
		}

		$config['upload_path'] = './' . $path;
		$config['allowed_types'] = 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename'] = '255';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = 4096;
		$this->load->library('upload', $config);
	}

	public function exportEmployees()
	{
		$this->load->model('Employee_model'); // adjust if your model has a different name
		$this->load->helper(['download', 'file']);
		//dd($this->input->get());
		// Get filters from POST
		$column_type = $this->input->get('column_type');
		$file_format = $this->input->get('file_format');
		$filters = json_decode($this->input->get('filters'), true) ?? [];

		// Fallback if filters empty
		if (empty($filters)) {
			$filters = $this->input->get() ?? [];
		}

		// Add search keyword to filters
		if (!empty($search)) {
			$filters['keyword'] = $search;
		}

		// ✅ Get selected IDs (checkbox values)
		$selected_ids = $this->input->get('checklist') ?? [];

		if (!empty($selected_ids)) {
			// Pass them into filters for model use
			$filters['selected_ids'] = $selected_ids;
		}
		
		// Status mapping (active, terminated, all)
		$empStatus = strtolower($filters['filter_status'] ?? 'all');
		$statusMapping = [
			'active'     => ['Active'],
			'terminated' => ['Terminated'],
			'all'        => ['Active', 'Terminated'],
		];
		$filters['status'] = $statusMapping[$empStatus] ?? $statusMapping['all'];

		//$selected_ids = $this->input->get('selected_ids') ?? [];
		// Get employee data
		$result = $this->Employee_model->employeeList(
			$filters,
			0,
			0,
			$column_type
		);

		$data = $result['data'];
		$columns = $result['visible_columns'];
		//dd($filters);
		// Prepare header titles from keys
		$headers = array_map(function ($col) {
			return ucwords(str_replace('_', ' ', $col));
		}, $columns);

		// Handle export type
		if ($file_format === 'file_format_pdf') {
			$this->exportToPDF($headers, $data);
		} else {
			$this->exportToExcel($headers, $data);
		}
	}

	private function exportToExcel($headers, $data)
	{
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Expand Payment Type Detail into subfields
		$includePaymentDetails = in_array('Payment Type Detail', $headers);
		if ($includePaymentDetails) {
			$headers = array_diff($headers, ['Payment Type Detail']);
			$headers = array_merge($headers, ['Account Type', 'Bank Name', 'IBAN No']);
		}

		// Generate headerKeyMap from first data row
		$headerKeyMap = [];
		if (!empty($data)) {
			foreach ($data[0] as $key => $val) {
				$label = ucwords(str_replace('_', ' ', $key));
				$headerKeyMap[$label] = $key;
			}

			// Add mappings for Payment Type Detail fields
			$headerKeyMap['Account Type'] = 'payment_type_detail';
			$headerKeyMap['Bank Name'] = 'payment_type_detail';
			$headerKeyMap['IBAN No'] = 'payment_type_detail';
		}

		// Title row
		$lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
		$sheet->mergeCells("A1:{$lastColumn}1");
		$sheet->setCellValue("A1", "Employee List");
		$sheet->getStyle("A1")->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
		]);

		// Header row
		$colIndex = 1;
		foreach ($headers as $header) {
			$columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
			$sheet->setCellValueByColumnAndRow($colIndex, 2, $header);
			$sheet->getColumnDimension($columnLetter)->setAutoSize(true);
			$colIndex++;
		}

		// Header styling
		$sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'CBDBF7'],
			],
		]);

		// Data rows
		$rowIndex = 3;
		foreach ($data as $row) {
			$colIndex = 1;

			// Decode payment detail
			$paymentDetails = [];
			if (!empty($row['payment_type_detail'])) {
				$decoded = json_decode($row['payment_type_detail'], true);

				// Handle double-encoded JSON
				if (is_string($decoded)) {
					$decoded = json_decode($decoded, true);
				}

				if (is_array($decoded)) {
					$paymentDetails = $decoded;
				}
			}

			foreach ($headers as $header) {
				$value = '';
				$key = $headerKeyMap[$header] ?? null;

				// Special handling for payment subfields
				if (in_array($header, ['Account Type', 'Bank Name', 'IBAN No'])) {
					$jsonKey = strtolower(str_replace(' ', '_', $header)); // account_type, bank_name, iban_no
					$value = $paymentDetails[$jsonKey] ?? '-';
				} elseif ($key === 'terminate_reason') {
					$value = ($row['status'] == 'Active') ? '-' : ($row['terminate_reason'] ?? '-');
					$value = ($value === null || $value === '') ? '-' : $value;
				} elseif ($key && isset($row[$key])) {
					$value = $row[$key];
					$value = ($value === null || $value === '') ? '-' : $value;
				} else {
					$value = '-';
				}

				// Format date fields
				if ((stripos($header, 'date') !== false || stripos($header, 'dob') !== false) && $value && strtotime($value)) {
					$sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, \PhpOffice\PhpSpreadsheet\Shared\Date::stringToExcel($value));
					$sheet->getStyleByColumnAndRow($colIndex, $rowIndex)->getNumberFormat()->setFormatCode('dd-mm-yyyy');
				} elseif (is_numeric($value) && strlen((string)$value) > 11) {
					$sheet->setCellValueExplicitByColumnAndRow($colIndex, $rowIndex, (string)$value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
				} else {
					$sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $value);
				}

				$colIndex++;
			}

			$rowIndex++;
		}

		// Output file
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$filename = 'employees_export_' . date('Ymd_His') . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment;filename=\"$filename\"");
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

	public function exportToPDF($headers, $emp_data)
	{
		ini_set('memory_limit', '512M');
		set_time_limit(300);

		if (empty($headers)) {
			$this->session->set_userdata('info', "2--Data not found!");
			redirect('admin/hr/employees');
		}

		// Expand Payment Type Detail into subfields
		$includePaymentDetails = in_array('Payment Type Detail', $headers);
		if ($includePaymentDetails) {
			$headers = array_diff($headers, ['Payment Type Detail']);
			$headers = array_merge($headers, ['Account Type', 'Bank Name', 'IBAN No']);
		}

		// Fix: Build label => key map
		$headerKeyMap = [];
		if (!empty($emp_data)) {
			foreach ($emp_data[0] as $key => $val) {
				$label = ucwords(str_replace('_', ' ', $key));
				$headerKeyMap[$label] = $key;
			}

			// Add mappings for Payment Type Detail fields ONLY if selected
			if ($includePaymentDetails) {
				$headerKeyMap['Account Type'] = 'payment_type_detail';
				$headerKeyMap['Bank Name'] = 'payment_type_detail';
				$headerKeyMap['IBAN No'] = 'payment_type_detail';
			}
		}

		$this->load->library('Pdf_hunger_report2');
		$data['headers'] = $headerKeyMap;
		$data['emp_list'] = $emp_data;
		$data['admin'] = 'Amanullah Kazi';
		//dd($emp_data);
		// Create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Employee List - ' . date('Ymd_His'));
		$pdf->SetSubject('Employee List - ' . date('Ymd_His'));
		$pdf->SetKeywords('Maha Al Fala, PDF, Employee List');

		// Load header/footer
		$htmlHeader = $this->load->view('admin/hr-module/employees/print/employee_list_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader);
		$lastFooter = $this->load->view('admin/hr-module/employees/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(4, 10, 4, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetAutoPageBreak(true, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->AddPage('L', 'A4');
		$pdf->setRTL(false);
		$pdf->Ln();
		$pdf->SetFont('aealarabiya', '', 8);

		$htmlcontent = $this->load->view('admin/hr-module/employees/print/employee_list', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		$pdf->Output('BS-Employee-List-' . date('Ymd_His') . '.pdf', 'I');
	}

	public function iqama_list()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'iqama_renewal_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1] ?? '';
			$data['info_type'] = $info[0] ?? '';
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/hr-module/employees/iqama-list', $data);
	}

	public function get_iqama_insurance_status()
	{
		$postData = $this->input->post();
		$result = $this->Employee_model->getIqamaList($postData);

		$i = $postData['start'] + 1;
		$data = [];
		// Optimized DL status map

		$dl_status_map = [
			'0' => 'DL Appointment',
			'1' => 'DL File',
			'2' => 'DL Class 1',
			'3' => 'DL Class 2',
			'4' => 'DL Computer Exam',
			'5' => 'DL Final Test',
			'6' => 'DL Repeat Exam',
			'7' => 'DL Medical',
			'8' => 'DL Basma',
			'9' => 'DL Issued',
		];
		foreach ($result['data'] as $item) {
			if (!empty($item->driving_license_number)) {
				$current_status_name = 'DL Issued';
			} else {
				if ($item->dl_status2 == 'Cancelled') {
					$current_status_name = 'Cancelled';
				} else {
					$current_status_name = isset($dl_status_map[$item->dl_status]) ? $dl_status_map[$item->dl_status] : 'NA';
				}
			}
			$data[] = [
				$i++,
				$item->emp_no,
				$item->full_name,
				$item->designation_name,
				$item->profession_name,
				$item->iqama_no,
				$item->nationality_name,
				$item->employer_id,
				!empty($item->iqama_expiry_date) ? date('d-m-Y', strtotime($item->iqama_expiry_date)) : '',
				$item->iqama_status_category,
				!empty($item->policy_expiry) ? date('d-m-Y', strtotime($item->policy_expiry)) : '',
				$item->insurance_status_category,
				$current_status_name,
				$item->driver_card_no ?? 'NA',
				$item->driver_card_type ?? 'NA'
			];
		}

		$output = [
			"draw" => intval($postData["draw"]),
			"recordsTotal" => $result['recordsTotal'],
			"recordsFiltered" => $result['recordsFiltered'],
			"data" => $data
		];

		echo json_encode($output);
	}

	// Export Iqama List as PDF
	public function print_iqama_insurance_status()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'iqama_renewal_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->library('Pdf_employee_offer');
		$postData = $this->input->post();
		$query = $this->Employee_model->getIqamaList($postData);
		if ($query && $query['data']) {
			$data['filter_applied'] = $postData;
			$data['detail'] = $query;
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Iqama Renewal');
			$pdf->SetSubject('BS - Iqama Renewal');
			$pdf->SetKeywords('Baqala Station, PDF, Iqama Renewal, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 8);
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
			$pdf->AddPage('L', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);
			$htmlcontent = $this->load->view('admin/hr-module/employees/print/iqama-renewal-list', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Iqama-renewal-list-' . date('d-m-Y') . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Iqama renewal detail not found!");
			redirect('admin/hr/employees');
		}
	}

	public function exportIqamaToExcel()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'iqama_renewal_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->helper('download');
		$this->load->model('Employee_model');

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$postData = $this->input->post();
		$query = $this->Employee_model->getIqamaList($postData);

		if (!$query || empty($query['data'])) {
			$this->session->set_userdata('info', "2--Iqama renewal detail not found!");
			redirect('admin/hr/employees');
		}

		$data = $query['data'];

		// Column headers and styles
		$headers = [
			'S.No.',
			'Emp. No.',
			'Employee Name',
			'Job Title',
			'Profession',
			'Iqama No.',
			'Nationality',
			'Employer ID',
			'Iqama Expiry',
			'Iqama Status',
			'Policy Expiry',
			'Policy Status',
			'DL Status'
		];

		// Title Row: Row 1
		$lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($headers));
		$sheet->mergeCells("A1:{$lastColumn}1");
		$sheet->setCellValue("A1", "Iqama Renewal List");
		$sheet->getStyle("A1")->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['rgb' => 'D9E1F2'],
			],
		]);

		// Row 2: Summary Titles
		$summaryTitles = ['Employer Name', 'Total Employee', 'Total Expired Iqama', 'Total Expiring Iqama', 'Total Valid Iqama', 'Total Expired Policy', 'Total Valid Policy'];
		$colIndex = 1;
		foreach ($summaryTitles as $title) {
			$sheet->setCellValueByColumnAndRow($colIndex, 2, $title);
			$sheet->getStyleByColumnAndRow($colIndex, 2)->applyFromArray([
				'font' => ['bold' => true],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'BDD7EE'],
				],
				'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			]);
			$colIndex++;
		}

		// Totals (Row 3)
		$totalEmployee = $totalExpired = $totalExpiringSoon = $totalValid = $totalPolicyExpired = $totalPolicyValid = 0;
		foreach ($data as $row) {
			$totalEmployee++;
			if ($row->iqama_status_category == 'Expired') $totalExpired++;
			elseif ($row->iqama_status_category == 'Expiring Soon') $totalExpiringSoon++;
			elseif (strpos($row->iqama_status_category, 'Valid') !== false) $totalValid++;

			if ($row->insurance_status_category == 'Expired') $totalPolicyExpired++;
			elseif (strpos($row->insurance_status_category, 'Valid') !== false) $totalPolicyValid++;
		}

		$employer_name = !empty($postData['employeer_id']) ?
			($this->db->get_where('sponsors', ['id' => $postData['employeer_id']])->row()->employer_name ?? 'All Employers') :
			'All Employers';

		$summaryValues = [$employer_name, $totalEmployee, $totalExpired, $totalExpiringSoon, $totalValid, $totalPolicyExpired, $totalPolicyValid];
		$colIndex = 1;
		foreach ($summaryValues as $val) {
			$sheet->setCellValueByColumnAndRow($colIndex, 3, $val);
			$colIndex++;
		}

		// Row 5: Header Titles
		$colIndex = 1;
		foreach ($headers as $header) {
			$sheet->setCellValueByColumnAndRow($colIndex, 5, $header);
			$sheet->getStyleByColumnAndRow($colIndex, 5)->applyFromArray([
				'font' => ['bold' => true],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => 'D9D9D9'],
				],
				'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			]);
			$colIndex++;
		}

		$rowNum = 6;
		$i = 1;
		$dl_status_map = [
			'0' => 'DL Appointment',
			'1' => 'DL File',
			'2' => 'DL Class 1',
			'3' => 'DL Class 2',
			'4' => 'DL Computer Exam',
			'5' => 'DL Final Test',
			'6' => 'DL Repeat Exam',
			'7' => 'DL Medical',
			'8' => 'DL Basma',
			'9' => 'DL Issued'
		];

		foreach ($data as $row) {
			$dl_status = 'NA';
			if (!empty($row->driving_license_number)) $dl_status = 'DL Issued';
			elseif ($row->dl_status2 == 'Cancelled') $dl_status = 'Cancelled';
			elseif (isset($dl_status_map[$row->dl_status])) $dl_status = $dl_status_map[$row->dl_status];

			// Fill row
			$sheet->setCellValueByColumnAndRow(1, $rowNum, $i++);
			$sheet->setCellValueByColumnAndRow(2, $rowNum, $row->emp_no);
			$sheet->setCellValueByColumnAndRow(3, $rowNum, $row->full_name);
			$sheet->setCellValueByColumnAndRow(4, $rowNum, $row->designation_name);
			$sheet->setCellValueByColumnAndRow(5, $rowNum, $row->profession_name);
			$sheet->setCellValueByColumnAndRow(6, $rowNum, $row->iqama_no);
			$sheet->setCellValueByColumnAndRow(7, $rowNum, $row->nationality_name);
			$sheet->setCellValueByColumnAndRow(8, $rowNum, $row->employer_id);
			$sheet->setCellValueByColumnAndRow(9, $rowNum, !empty($row->iqama_expiry_date) ? date('d-m-Y', strtotime($row->iqama_expiry_date)) : '');
			$sheet->setCellValueByColumnAndRow(10, $rowNum, $row->iqama_status_category);
			$sheet->setCellValueByColumnAndRow(11, $rowNum, !empty($row->policy_expiry) ? date('d-m-Y', strtotime($row->policy_expiry)) : '');
			$sheet->setCellValueByColumnAndRow(12, $rowNum, $row->insurance_status_category);
			$sheet->setCellValueByColumnAndRow(13, $rowNum, $dl_status);

			// Color row based on iqama_status_category
			$color = null;
			if ($row->iqama_status_category == 'Expired') {
				$color = 'FFC7CE'; // red
			} elseif ($row->iqama_status_category == 'Expiring Soon') {
				$color = 'FFEB9C'; // yellow
			} elseif (strpos($row->iqama_status_category, 'Valid') !== false) {
				$color = 'C6EFCE'; // green
			}

			$sheet->getStyle("A{$rowNum}:M{$rowNum}")->applyFromArray([
				'borders' => [
					'allBorders' => [
						'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						'color' => ['argb' => 'FFCCCCCC'],
					],
				],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => $color],
				],
			]);
			$rowNum++;
		}
		// Auto-size all columns
		foreach (range('A', 'M') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Output file
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$filename = 'Iqama-Renewal-List-' . date('d-m-Y_H-i-s') . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment;filename=\"$filename\"");
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
		exit;
	}

	public function export_combined_pdf($id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'view_employees', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($id < 1 || !is_numeric($id)) {
			$this->session->set_userdata('info', "2--Invalid employee ID: $id");
			redirect('admin/hr/employees/view/step-6/' . $id);
		}

		$emp_detail = $this->Employee_model->get_employee_by_id($id);
		if (!$emp_detail) {
			$this->session->set_userdata('info', "2--Employee not found with ID: $id");
			redirect('admin/hr/employees');
		}

		$docs = $this->Employee_model->get_emp_docs($id);
		if (empty($docs)) {
			$this->session->set_userdata('info', "2--No documents found for employee ID: $id");
			redirect('admin/hr/employees/view/step-6/' . $id);
		}

		$emp_no   = $emp_detail->emp_no ?? '';
		$emp_name = $emp_detail->full_name ?? '';

		$this->load->library('PdfFpdi');
		$pdf = new PdfFpdi();
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Employee Documents - ' . $emp_no . ' - ' . $emp_name);
		$pdf->SetSubject('Employee Documents - ' . $emp_no . ' - ' . $emp_name);
		$pdf->SetKeywords('Maha Al Fala, PDF, Employee Documents');

		$pdf->SetPrintHeader(false);
		$pdf->SetPrintFooter(true);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTopMargin(10); // Decrease top margin
		$pdf->SetAutoPageBreak(true, 20); // Bottom margin

		foreach ($docs as $doc) {
			$file  = FCPATH . $doc['document'];
			$title = $doc['doc_type'];
			$ext   = strtolower(pathinfo($file, PATHINFO_EXTENSION));

			if (!file_exists($file)) continue;

			$pdf->footer_title = $title;

			if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
				$pdf->AddPage();
				$pdf->Image($file, 10, 25, 190, 0, '', '', '', false, 300, '', false, false, 0);
			} elseif ($ext === 'pdf') {
				$pageCount = $pdf->setSourceFile($file);
				for ($i = 1; $i <= $pageCount; $i++) {
					$tplId = $pdf->importPage($i);
					$size = $pdf->getTemplateSize($tplId);

					$pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
					$pdf->useTemplate($tplId, 0, 0, $size['width'], $size['height'], true);
				}
			}
		}

		$filename = 'employee_docs_' . $emp_no . '_' . $emp_name . '.pdf';
		$pdf->Output($filename, 'I');
	}
	
	/*--- Bulk Iqama Renewal Update ---*/

	public function bulkUpdateIqamaRenewal()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'iqama_renewal_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$path = 'uploads/imports/iqama_renewal/';
		$json = [];
		$lock_name = 'iqama_bulk_update_lock';

		$this->upload_config($path);

		try {

			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors());
			}

			/* ===============================
			ACQUIRE GLOBAL DB LOCK (CI3 SAFE)
			=============================== */
			$lock = $this->db->query(
				"SELECT GET_LOCK(?, 10) AS locked",
				[$lock_name]
			)->row();

			if (!$lock || (int)$lock->locked !== 1) {
				throw new Exception(
					'IQAMA bulk update is already in progress from another panel. Please try again later.'
				);
			}

			$file_data = $this->upload->data();
			$file_name = $path . $file_data['file_name'];
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);

			if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
				throw new Exception('Unsupported file format.');
			}

			$reader = $this->getReaderByExtension($extension);
			$sheet  = $reader->load($file_name)->getActiveSheet()->toArray();

			array_shift($sheet); // remove header

			$this->db->trans_begin();

			foreach ($sheet as $row) {

				$iqama_no    = trim($row[0] ?? '');
				$expiry_date = trim($row[2] ?? '');

				if ($iqama_no === '' || $expiry_date === '') {
					continue;
				}

				$expiry_date = date(
					'Y-m-d',
					strtotime(str_replace('/', '-', $expiry_date))
				);

				if (!$expiry_date || $expiry_date === '1970-01-01') {
					continue;
				}

				$expiry_hijri = ReturnGreg2Hijri($expiry_date);

				$this->db->where('iqama_no', $iqama_no);
				$this->db->update('master_employee', [
					'iqama_expiry_date'       => $expiry_date,
					'iqama_expiry_date_hijri' => $expiry_hijri,
				]);
			}

			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Database transaction failed.');
			}

			$this->db->trans_commit();

			/* ===============================
			RELEASE LOCK (MANDATORY)
			=============================== */
			$this->db->query("SELECT RELEASE_LOCK(?)", [$lock_name]);

			if (file_exists($file_name)) {
				unlink($file_name);
			}

			$json = [
				'success_message' => 'IQAMA expiry dates updated successfully.'
			];

		} catch (Exception $e) {

			$this->db->trans_rollback();

			// Always attempt to release lock
			$this->db->query("SELECT RELEASE_LOCK(?)", [$lock_name]);

			$json = [
				'error_message' => $e->getMessage()
			];
		}

		echo json_encode($json);
		exit();
	}

	//End of Bulk Import
	
    public function bulkProfessionUpdateModal()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'employee_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$path      = 'uploads/imports/iqama_profession/';
		$json      = [];
		$lock_name = 'iqama_profession_bulk_update_lock';

		$this->upload_config($path);

		try {

			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors());
			}

			/* ===============================
			ACQUIRE GLOBAL DB LOCK
			=============================== */
			$lock = $this->db->query(
				"SELECT GET_LOCK(?, 10) AS locked",
				[$lock_name]
			)->row();

			if (!$lock || (int)$lock->locked !== 1) {
				throw new Exception(
					'Bulk update already in progress. Please try again later.'
				);
			}

			$file_data = $this->upload->data();
			$file_name = $path . $file_data['file_name'];
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);

			if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
				throw new Exception('Unsupported file format.');
			}

			$reader = $this->getReaderByExtension($extension);
			$sheet  = $reader->load($file_name)->getActiveSheet()->toArray();

			array_shift($sheet); // remove header

			$this->db->trans_begin();

			foreach ($sheet as $row) {
				$iqama_no          = trim($row[0] ?? '');
				$profession_name   = trim($row[2] ?? '');
				$designation_name  = trim($row[3] ?? '');

				if ($iqama_no === '' || $profession_name === '' || $designation_name === '') {
					continue;
				}

				/* ===============================
				FETCH PROFESSION ID
				=============================== */
				$profession = $this->db
					->select('id')
					->where('profession_name', $profession_name)
					->get('master_profession')
					->row();

				if (!$profession) {
					continue; // No profession match → skip
				}

				/* ===============================
				FETCH DESIGNATION ID
				=============================== */
				$designation = $this->db
					->select('id')
					->where('name', $designation_name)
					->get('master_job_title')
					->row();

				if (!$designation) {
					continue; // No designation match → skip
				}

				/* ===============================
				UPDATE EMPLOYEE BY IQAMA NO
				=============================== */
				$this->db->where('iqama_no', $iqama_no);
				$this->db->update('master_employee', [
					'iqama_profession' => $profession->id,
					'designation'     => $designation->id,
				]);
			}

			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Database transaction failed.');
			}

			$this->db->trans_commit();

			/* ===============================
			RELEASE LOCK
			=============================== */
			$this->db->query("SELECT RELEASE_LOCK(?)", [$lock_name]);

			if (file_exists($file_name)) {
				unlink($file_name);
			}

			$json = [
				'success_message' => 'IQAMA profession and designation updated successfully.'
			];

		} catch (Exception $e) {

			$this->db->trans_rollback();

			$this->db->query("SELECT RELEASE_LOCK(?)", [$lock_name]);

			$json = [
				'error_message' => $e->getMessage()
			];
		}

		echo json_encode($json);
		exit();
	}
	
	//Bulk Import Driver Card
	public function bulkDriverCardUpdateModal()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'employee_list', $this->action)) {
			redirect('admin/unauthorized-request');
		}

		$path      = 'uploads/imports/driver_card/';
		$json      = [];
		$lock_name = 'driver_card_bulk_update_lock';

		$this->upload_config($path);

		try {

			if (!$this->upload->do_upload('file')) {
				throw new Exception($this->upload->display_errors());
			}

			/* ===============================
			ACQUIRE GLOBAL DB LOCK
			=============================== */
			$lock = $this->db->query(
				"SELECT GET_LOCK(?, 10) AS locked",
				[$lock_name]
			)->row();

			if (!$lock || (int)$lock->locked !== 1) {
				throw new Exception(
					'Bulk update already in progress. Please try again later.'
				);
			}

			$file_data = $this->upload->data();
			$file_name = $path . $file_data['file_name'];
			$extension = pathinfo($file_name, PATHINFO_EXTENSION);

			if (!in_array($extension, ['csv', 'xlsx', 'xls'], true)) {
				throw new Exception('Unsupported file format.');
			}

			$reader = $this->getReaderByExtension($extension);
			$sheet  = $reader->load($file_name)->getActiveSheet()->toArray();

			array_shift($sheet); // remove header

			$this->db->trans_begin();

			foreach ($sheet as $row) {
				$iqama_no     = trim($row[1] ?? '');
				$issue_date   = trim($row[2] ?? '');
				$expiry_date  = trim($row[3] ?? '');
				$driver_card_no  = trim($row[4] ?? '');
				$driver_card_type = trim($row[5] ?? '');

				if ($iqama_no === '' || $issue_date === '' || $expiry_date === '' || $driver_card_no === '' || $driver_card_type === '') {
					continue;
				}

				// ✅ Convert DD-MM-YYYY → YYYY-MM-DD
				$issue_date  = normalize_excel_date($row[2] ?? '');
				$expiry_date = normalize_excel_date($row[3] ?? '');

				if (!$issue_date || !$expiry_date) {
					continue; // Skip invalid date rows
				}

				/* ===============================
				FETCH EMPLOYEE BY IQAMA NO
				=============================== */
				$employee = $this->db
					->select('id')
					->where('iqama_no', $iqama_no)
					->get('master_employee')
					->row();

				if (!$employee) {
					continue; // No employee match → skip
				}
				/* ===============================
				UPDATE EMPLOYEE BY IQAMA NO
				=============================== */
				$this->db->where('employee_id', $employee->id);
				$this->db->update('master_employee_info', [
					'driver_card_issue_date'   => $issue_date,
					'driver_card_expiry_date'  => $expiry_date,
					'driver_card_no'           => $driver_card_no,
					'driver_card_type'         => $driver_card_type,
				]);
			}

			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Database transaction failed.');
			}

			$this->db->trans_commit();

			/* ===============================
			RELEASE LOCK
			=============================== */
			$this->db->query("SELECT RELEASE_LOCK(?)", [$lock_name]);
			if (file_exists($file_name)) {
				unlink($file_name);
			}
			$json = [
				'success_message' => 'Driver card updated successfully.'
			];

		} catch (Exception $e) {
			$this->db->trans_rollback();
			$this->db->query("SELECT RELEASE_LOCK(?)", [$lock_name]);
			$json = [
				'error_message' => $e->getMessage()
			];
		}

		echo json_encode($json);
		exit();
	}

}

