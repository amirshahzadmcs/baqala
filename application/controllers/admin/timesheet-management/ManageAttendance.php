<?php defined('BASEPATH') or exit('No direct script access allowed');
class ManageAttendance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->admin->isLogged()) {
			$this->load->library('form_validation');
			// $this->load->library('/tcpdf/tcpdf.php');
			require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$vehicles = $this->db->select('master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.full_name')->join('master_employee', 'master_employee.id=master_vehicles.alloted_user', 'left')->get('master_vehicles')->result();
		$employees = $this->db->select('id,emp_no,full_name')->get('master_employee')->result();
		$camps = $this->db->select('id,camp_name')->get('master_camp')->result();
		$platforms = $this->db->select('id,company_name')->get('food_deliv_companies')->result();
		$teams = $this->db->select('id,name')->get('hunger_team')->result();
		return $this->load->view('admin/timesheet-management/manage_attendance', compact('vehicles', 'employees', 'camps', 'platforms', 'teams'));
	}

	// Controller Code
	public function get_list()
	{
		$emp_id = $this->input->get('emp', TRUE);
		$from = $this->input->get('from', TRUE);
		$to = $this->input->get('to', TRUE);
		$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
		$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
		$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;

		$fromDate = (!empty($from)) ? DateTime::createFromFormat('d M, Y', $from)->format('Y-m-d') : null;
		$toDate = (!empty($to)) ? DateTime::createFromFormat('d M, Y', $to)->format('Y-m-d') : null;

		// Select data with JOIN
		$this->db->select("ma.id, ma.emp_id,me.emp_no,me.full_name, ma.date, ma.new_status, ma.remark, ma.created_at, ma.updated_at");
		$this->db->from('manage_attendance ma');
		$this->db->join('master_employee me', 'ma.emp_id = me.id', 'left');
		// Apply filters
		if (!empty($emp_id)) {
			$this->db->where('ma.emp_id', $emp_id);
		}
		if (!empty($fromDate) && !empty($toDate)) {
			$this->db->where('DATE(ma.date) >=', $fromDate);
			$this->db->where('DATE(ma.date) <=', $toDate);
		}

		// Clone query to get filtered count before applying limit
		$countQuery = clone $this->db;
		$recordsFiltered = $countQuery->count_all_results();

		// Apply pagination
		if ($length != -1) {
			$this->db->limit($length, $start);
		}
		$this->db->order_by("ma.date", "desc");
		$query = $this->db->get();
		$fetch_data = $query->result();

		// Process data
		$data = [];
		$i = $start + 1;
		foreach ($fetch_data as $attendance) {
			$data[] = [
				$i++,
				$attendance->emp_no,
				$attendance->full_name,
				date('d M, Y', strtotime($attendance->date)),
				$attendance->new_status,
				$attendance->remark
			];
		}

		echo json_encode([
			"draw" => $draw,
			"recordsTotal" => $recordsFiltered,
			"recordsFiltered" => $recordsFiltered,
			"data" => $data
		]);
	}


	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/timesheet-management/components/search-form');
	}

	public function searchEmp()
	{
		$query = $this->input->get('search');

		$this->db->select('id, emp_no,full_name');
		$this->db->from('master_employee');
		$this->db->like('emp_no', $query);
		$this->db->or_like('full_name', $query);
		$items = $this->db->get()->result();
		echo json_encode($items);
	}

	public function get_employee_detail()
	{
		$this->form_validation->set_rules('search_employee', 'Employee ID', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			exit;
		}

		$emp_no = $this->db->select('me.id')->from('master_employee me')->where('emp_no', $this->input->post('search_employee'))->get()->row()->id;

		// Check if the employee exists in logistic_rider
		$rider = $this->db->select('id')->from('logistic_rider')->where('employee_id', $emp_no)->get()->row_array();
		if (!$rider) {
			echo json_encode(["type" => "error", "message" => "Employee not found in logistic rider."]);
			exit;
		}

		// Fetch Team Details
		$team = $this->db->select('ht.id as team_id, ht.name as team_name, me_leader.full_name as team_leader_name')
			->from('hunger_team ht')
			->join('master_employee me_leader', 'me_leader.id = ht.team_leader', 'left')
			->where("JSON_CONTAINS(ht.team, '\"{$emp_no}\"')", NULL, FALSE)
			->get()->row_array();
		if (!$team) {
			echo json_encode(["type" => "error", "message" => "Employee is not assigned to any team."]);
			exit;
		}

		// Fetch Employee and Related Details
		$this->db->select('me.id as employee_id, me.emp_no, me.full_name, me.employee_arabic_name, 
						   me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, 
						   mjt.name as designation_name, md.name as department_name, mn.name as nationality_name, 
						   mei.driving_license_number, mv.id as vehicle_id, mv.vehicle_no, mv.vehicle_model, 
						   mv.gps_device_serial, mvk.make_name as vehicle_make, sim.mobile as sim_mobile, 
						   sim.sim_no, mei.insurance_company_name, mei.insurance_policy_no, 
						   mei.insurance_end_date, mic.company_name as insurance_company')
			->from('master_employee me')
			->join('master_nationality mn', 'me.nationality = mn.id', 'left')
			->join('master_department md', 'me.department = md.id', 'left')
			->join('master_job_title mjt', 'me.designation = mjt.id', 'left')
			->join('master_employee_info mei', 'mei.employee_id = me.id', 'left')
			->join('master_vehicles mv', 'mv.alloted_user = me.id', 'left')
			->join('mater_van_make mvk', 'mvk.id = mv.vehicle_make', 'left')
			->join('sim_card sim', 'sim.alloted_user = me.id', 'left')
			->join('master_insurance_company mic', 'mei.insurance_company_name = mic.id', 'left')
			->where('me.status', 'Active')
			->where('me.id', $emp_no);

		$employee = $this->db->get()->row_array();

		if (!$employee) {
			echo json_encode(["type" => 'error', "message" => 'Rider detail not found, try another employee number.']);
			exit;
		}

		$employee['team_detail'] = $team;
		$employee['rider_id'] = $rider['id']; // Add team info

		// Load view and return response
		$output_html = $this->load->view('admin/timesheet-management/components/employee-detail', ['emp_detail' => $employee], TRUE);
		echo json_encode(["type" => 'success', "message" => 'Rider detail fetched.', "output_html" => $output_html]);
	}

	public function check_date()
	{
		$emp_id = (int) $this->input->get('emp_id');
		$attendance_date = $this->input->get('date');
		$this->db->select('vt.driver_id, vt.out_time, me.full_name, ma.new_status, ma.remark');
		$this->db->from('vehicle_timesheets vt');
		$this->db->join('master_employee me', 'me.id = vt.driver_id', 'left');
		$this->db->join('manage_attendance ma', 'ma.emp_id = vt.driver_id AND ma.date = DATE(vt.out_time)', 'left');
		$this->db->where('vt.driver_id', $emp_id);
		$this->db->where('DATE(vt.out_time)', $attendance_date);
		$check_date = $this->db->get()->row_array();
		if ($check_date) {
			$message = '<div class="alert alert-success p-2">Status: Present</div>';
			$status = $check_date['new_status'] ?? '';
			$remark = $check_date['remark'] ?? '';
		} else {
			$message = '<div class="alert alert-danger p-2">Status: Absent</div>';
			$status = '';
			$remark = '';
		}

		$result = [
			"type"      => $check_date ? true : false,
			"message"   => $message,
			"status"    => $status,
			"remark"    => $remark,
			"employee"  => $check_date['full_name'] ?? 'Unknown'
		];
		echo json_encode($result);
	}


	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$this->form_validation->set_rules('emp_id', 'Employee ID', 'required|integer');
			$this->form_validation->set_rules('date', 'Attendance Date', 'required');
			$this->form_validation->set_rules('new_status', 'Status', 'required');

			if ($this->form_validation->run() == FALSE) {
				echo json_encode(['type' => 'error', 'message' => validation_errors()]);
				return;
			}

			$data = $this->input->post(['emp_id', 'rider_id', 'date', 'new_status', 'remark'], true);

			$this->db->where(['emp_id' => $data['emp_id'], 'date' => $data['date'], 'rider_id' => $data['rider_id']]);
			$exists = $this->db->get('manage_attendance')->num_rows() > 0;

			$success = $exists ? $this->db->update('manage_attendance', $data, ['emp_id' => $data['emp_id'], 'date' => $data['date'], 'rider_id' => $data['rider_id']]) : $this->db->insert('manage_attendance', $data);

			echo json_encode(['type' => $success ? 'success' : 'error', 'message' => $success ? 'Attendance updated successfully!' : 'Failed to update attendance.']);
		}
	}
}
