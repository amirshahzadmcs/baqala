<?php defined('BASEPATH') or exit('No direct script access allowed');
class TimesheetController extends CI_Controller
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

	public function get_timesheet()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$vehicles = $this->db->select('master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.full_name')->join('master_employee', 'master_employee.id=master_vehicles.alloted_user', 'left')->get('master_vehicles')->result();
		$employees = $this->db->select('id,emp_no,full_name')->get('master_employee')->result();
		$camps = $this->db->select('id,camp_name')->get('master_camp')->result();
		$platforms = $this->db->select('id,company_name')->get('food_deliv_companies')->result();
		$teams = $this->db->select('id,name')->get('hunger_team')->result();
		return $this->load->view('admin/timesheet-management/timesheet-list', compact('vehicles', 'employees', 'camps', 'platforms', 'teams'));
	}

	public function get_list()
	{
		$emp = $this->input->get('emp', TRUE);
		$platform = $this->input->get('platform', TRUE);
		$camp = $this->input->get('camp', TRUE);
		$from = $this->input->get('from', TRUE);
		$to = $this->input->get('to', TRUE);
		$team = (int)$this->input->get('team', TRUE);
		$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
		$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
		$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
		if ($from != '' && $to != '') {
			$fromDate = DateTime::createFromFormat('d M, Y', $from)->format('Y-m-d');
			$toDate = DateTime::createFromFormat('d M, Y', $to)->format('Y-m-d');
		} else {
			$fromDate = null;
			$toDate = null;
		}

		if ($team) {
			$member = json_decode($this->db->where('id', $team)->get('hunger_team')->row()->team);
		}

		$this->db->select(
			'vehicle_timesheets.*, 
                       master_vehicles.id as vehicle_id, 
                       master_vehicles.vehicle_no, 
                       master_employee.id as employee_id, 
                       master_employee.emp_no, 
                       master_employee.full_name as employee_name, 
                       food_deliv_companies.company_name,
                       lr.id_number, 
                       hos.working_hours, 
                       hos.completed_deliveries,
                       (
                           SELECT GROUP_CONCAT(ht.name) 
                           FROM hunger_team ht 
                           WHERE ht.team REGEXP CONCAT(\'"\', master_employee.id, \'"\')
                       ) as team_name'
		);
		$this->db->from('vehicle_timesheets');
		$this->db->join('master_vehicles', 'vehicle_timesheets.vehicle_id = master_vehicles.id', 'left');
		$this->db->join('master_employee', 'vehicle_timesheets.driver_id = master_employee.id', 'left');
		$this->db->join('food_deliv_companies', 'vehicle_timesheets.delivery_platform = food_deliv_companies.id', 'left');
		$this->db->join('logistic_rider lr', 'vehicle_timesheets.driver_id = lr.employee_id', 'left');
		$this->db->join('hunger_order_summary hos', 'lr.id_number = hos.rider_id AND DATE(vehicle_timesheets.created_at) = DATE(hos.date_local)', 'left');

		if ($emp) {
			$this->db->where('vehicle_timesheets.driver_id', $emp);
		}

		if ($platform) {
			$this->db->where('delivery_platform', $platform);
		}

		if ($camp) {
			$this->db->join('master_camp', 'master_employee.camp = master_camp.id');
			$this->db->where('master_camp.id', $camp);
		}

		if (!empty($fromDate) && !empty($toDate)) {
			$v_from = date("Y-m-d", strtotime($fromDate));
			$d_to = date("Y-m-d", strtotime($toDate));
			$this->db->where('DATE(vehicle_timesheets.out_time) >=', $v_from);
			$this->db->where('DATE(vehicle_timesheets.out_time) <=', $d_to);
		}


		if ($team) {
			$this->db->where_in('vehicle_timesheets.driver_id', empty($member) ? [0] : $member);
		}

		$countQuery = clone $this->db;
		$recordsFiltered = $countQuery->count_all_results();

		if ($length != -1) {
			$this->db->limit($length, $start);
		}

		$this->db->order_by("time_id", "desc");

		$query = $this->db->get();
		$fetch_data = $query->result();

		$data = array();
		$i = $start + 1;
		foreach ($fetch_data as $timesheet) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $timesheet->emp_no;
			$sub_array[] = $timesheet->employee_name;
			$sub_array[] = $timesheet->vehicle_no;
			$sub_array[] = $timesheet->company_name;
			$sub_array[] = $this->format_date($timesheet->out_time);
			$sub_array[] = $timesheet->working_hours;
			$sub_array[] = $timesheet->completed_deliveries;
			$sub_array[] = (int)$timesheet->out_km;
			$sub_array[] = $timesheet->out_battery;
			$sub_array[] = $timesheet->team_name; // Added team_name
			$sub_array[] = '<a class="btn btn-outline-info btn-custom-light btn-sm edit" onclick="adminViewTimesheet(this)" title="View" href="javascript:void(0)" vehicle_no="' . $timesheet->vehicle_no . '" emp_no="' . $timesheet->emp_no . '" emp_name="' . $timesheet->employee_name . '" checkIn_km="' . $timesheet->in_km . '" checkOut_km="' . $timesheet->out_km . '" checkIn_battery="' . $timesheet->in_battery . '" checkOut_battery="' . $timesheet->out_battery . '" checkIn_time="' . $this->format_date($timesheet->in_time) . '" checkOut_time="' . $this->format_date($timesheet->out_time) . '"><i class="mdi mdi-eye font-size-18"></i></a>';
			$data[] = $sub_array;
		}

		$output = array(
			"draw" => $draw,
			"recordsTotal" => $recordsFiltered,
			"recordsFiltered" => $recordsFiltered,
			"data" => $data
		);

		echo json_encode($output);
	}


	// Helper function to format dates
	private function format_date($date)
	{
		return date('d-m-Y H:i a', strtotime($date));
	}


	public function check_emp_detail()
	{
		$employee_no = $this->input->get('employee_no');
		$employee = $this->db->get_where('master_employee', ['emp_no' => $employee_no])->row();
		if ($employee) {
			$emp = $this->db
				->select('
                master_employee.*,
                master_vehicles.id as vehicle_id,
                master_vehicles.vehicle_no as vehicle_no,
				master_vehicles.vehicle_model as vehicle_model,
				mvm.make_name as vehicle_brand_name,
                mjt.id as job_title_id,
				mjt.name as job_name,
				md.id as department_id,
				md.name as department_name,
				mc.camp_name as camp_name,
				mr.room_name as room_name,
				mb.bed_name as bed_name,
            ')
				->from('master_employee')
				->join('master_vehicles', 'master_employee.id = master_vehicles.alloted_user', 'left')
				->join('master_job_title mjt', 'master_employee.designation = mjt.id', 'left')
				->join('master_department md', 'master_employee.department = md.id', 'left')
				->join('mater_van_make mvm', 'master_vehicles.vehicle_make = mvm.id', 'left')
				->join('master_camp mc', 'master_employee.camp = mc.id', 'left')
				->join('master_rooms mr', 'master_employee.room = mr.id', 'left')
				->join('master_bed mb', 'master_employee.bed = mb.id', 'left')
				->where('master_employee.id', $employee->id)
				->get()
				->row();
			echo json_encode(['status' => true, 'message' => 'Employee Detail Fetched', 'employee' => $emp]);
		} else {
			echo json_encode(['status' => false, 'error' => 'Employee Not Found']);
		}
	}


	public function send_otp()
	{
		if ($this->input->get('km')) {
			$this->session->set_userdata('vehicle_km', $this->input->get('km'));
		}
		if ($this->input->get('email') == '') {
			echo json_encode(['status' => false, 'message' => 'Email is Required for Otp']);
		} else {

			$emp_id = $this->input->get('emp_id');
			$rec_email = $this->input->get('email');
			$otp = 123456; //rand(000000, 999999);
			$this->db->insert(
				'driver_otp_verification',
				[
					'emp_id' => $emp_id,
					'email' => $rec_email,
					'otp' => $otp,
					'ip_address' => $this->ip_address
				]
			);
			// $eSetting = $this->customer->emailSetting();
			// $config = array(
			// 'protocol' => $eSetting->protocol,
			// 'smtp_host' => $eSetting->smtp_host,
			// 'smtp_port' => $eSetting->smtp_port,
			// 'smtp_user' => $eSetting->smtp_user,
			// 'smtp_pass' => $eSetting->smtp_pass,
			// 'mailtype' => 'html'
			// );
			// $message = 'Your Parking Otp is:' . $otp;

			// $subject = 'Otp | ' . $eSetting->website_name;
			// $this->load->library('email');
			// $this->email->initialize($config);
			// $this->email->set_newline("\r\n");
			// $this->email->from($eSetting->smtp_user, $eSetting->website_name . ' | Otp');
			// $this->email->to($rec_email);
			// $this->email->subject($subject);
			// $this->email->message($message);
			// $send = $this->email->send();
			// if ($send) {
			echo json_encode(['status' => true, 'message' => 'Otp Send to Driver Email', 'emp_id' => $emp_id]);
			// }
		}
	}

	public function submit_otp()
	{
		// Get employee ID and OTP from the request
		$emp_id = $this->input->get('employee_id');
		$otp = $this->input->get('otp');

		// Verify OTP
		$otpVerify = $this->db->get_where('driver_otp_verification', ['emp_id' => $emp_id, 'otp' => $otp])->row();

		if ($otpVerify) {
			// Fetch employee details along with their vehicle ID
			$employee = $this->db->select('master_employee.*, master_vehicles.id as vehicle_id')
				->join('master_vehicles', 'master_employee.id = master_vehicles.alloted_user', 'left')
				->where('master_employee.id', $emp_id)
				->get('master_employee')
				->row();
			$platforms = $this->db->select('id,company_name')->get('food_deliv_companies')->get();

			// Ensure employee exists and has vehicle details
			if ($employee && isset($employee->vehicle_id)) {
				// Count parking records
				$parking_count = $this->db->where(['driver_id' => $emp_id, 'vehicle_id' => $employee->vehicle_id])
					->from('vehicle_timesheets')
					->count_all_results();

				if ($parking_count > 0) {
					// Parking records found, proceed with your logic here
					$active_record = $this->db->select('in_time, out_time')
						->where(['driver_id' => $emp_id, 'vehicle_id' => $employee->vehicle_id, 'in_time' => null])
						->order_by('in_time', 'DESC')
						->get('vehicle_timesheets')
						->row();

					if ($active_record) {
						// If an active record exists, open the check-out form
						echo json_encode([
							'status' => true,
							'message' => 'Please Enter Vehicle Detail',
							'form' => 'Check In',
							'employee' => $employee,
							'km' => $this->session->userdata('vehicle_km')
						]);
					} else {
						// No active record, open the check-in form
						echo json_encode([
							'status' => true,
							'message' => 'Please Enter Vehicle Detail',
							'form' => 'Check Out',
							'employee' => $employee,
							'platforms' => $platforms,
							'km' => $this->session->userdata('vehicle_km')
						]);
					}
				} else {
					// No parking records found, request vehicle detail entry
					echo json_encode([
						'status' => true,
						'message' => 'Please Enter Vehicle Detail',
						'form' => 'Check Out',
						'employee' => $employee,
						'platforms' => $platforms,
						'km' => $this->session->userdata('vehicle_km')
					]);
				}
			} else {
				// Employee or vehicle details not found
				echo json_encode([
					'status' => false,
					'message' => 'Employee or Vehicle details not found'
				]);
			}
		} else {
			// Invalid OTP
			echo json_encode([
				'status' => false,
				'message' => 'Please Enter Valid Otp'
			]);
		}
	}


	public function checkout()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('driver_id', 'Driver', 'required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
		$this->form_validation->set_rules('km_driven', 'Kilometers Driven', 'required|integer');
		$this->form_validation->set_rules('battery_status', 'Battery Status', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/vehicle/get-timesheet');
		} else {
			$out_time = date('Y-m-d H:i:s');
			$driver_id = $this->input->post('driver_id');
			$vehicle_id = $this->input->post('vehicle_id');
			$km_driven = $this->input->post('km_driven');
			$battery_status = $this->input->post('battery_status');
			$delivery_platform = $this->input->post('delivery_paltform');
			$current_date = date('Y-m-d');

			$existing_record = $this->db->get_where('vehicle_timesheets', [
				'driver_id' => $driver_id,
				'vehicle_id' => $vehicle_id,
				'DATE(out_time)' => $current_date
			])->row();

			if ($existing_record) {
				$this->session->set_userdata('info', "2--Attendance already recorded for today.");
				return redirect('admin/vehicle/get-timesheet');
			}

			$data = [
				'driver_id' => $driver_id,
				'vehicle_id' => $vehicle_id,
				'out_time' => $out_time,
				'out_km' => $km_driven,
				'out_battery' => $battery_status,
				'delivery_platform' => $delivery_platform
			];

			$insert = $this->db->insert('vehicle_timesheets', $data);
			if ($insert) {
				$this->session->set_userdata('info', "1--Successfully done");
				return redirect('admin/vehicle/get-timesheet');
			} else {
				$this->session->set_userdata('info', "2--Something Went Wrong");
				return redirect('admin/vehicle/get-timesheet');
			}
		}
	}


	public function checkIn()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('driver_id', 'Driver', 'required');
		$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
		$this->form_validation->set_rules('km_driven', 'Kilometers Driven', 'required|integer');
		$this->form_validation->set_rules('battery_status', 'Battery Status', 'required');

		if ($this->form_validation->run() === FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			return redirect('admin/vehicle/get-timesheet');
		} else {
			$in_time = date('Y-m-d H:i:s');
			$driver_id = $this->input->post('driver_id');
			$vehicle_id = $this->input->post('vehicle_id');
			$km_driven = $this->input->post('km_driven');
			$battery_status = $this->input->post('battery_status');

			$parking_slot = $this->db->select('time_id,in_time, out_time')
				->where(['driver_id' => $driver_id, 'vehicle_id' => $vehicle_id, 'in_time' => null])
				->order_by('in_time', 'DESC')
				->get('vehicle_timesheets')
				->row();

			$data = [
				'in_time' => $in_time,
				'in_km' => $km_driven,
				'in_battery' => $battery_status
			];

			$update = $this->db->update('vehicle_timesheets', $data, ['time_id' => $parking_slot->time_id]);
			if ($update) {
				$this->session->set_userdata('info', "1--Successfully done");
				return redirect('admin/vehicle/get-timesheet');
			} else {
				$this->session->set_userdata('info', "2--Something Went Wrong");
				return redirect('admin/vehicle/get-timesheet');
			}
		}
	}

	public function delete()
	{
		$delete = $this->db->where('time_id', $this->input->get('id'))->delete('vehicle_timesheets');
		if ($delete) {
			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('admin/vehicle/get-timesheet');
		} else {
			$this->session->set_userdata('info', "2--Something Went Wrong");
			return redirect('admin/vehicle/get-timesheet');
		}
	}



	public function print_timesheet()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('from') == '' && $this->input->get('to') == '') {
			$this->session->set_userdata('info', "2--The date must be between [start date] and [end date].");
			return redirect('admin/vehicle/get-timesheet');
		}
		$data['timesheet'] = $this->get_all_data();
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// Set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Vehicle Timesheet');
		$pdf->SetSubject('Timesheet');
		$pdf->SetKeywords('TCPDF, PDF, Timesheet, list');

		// Set default header data
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// Set margins
		if ($pdf->PageNo() == 1) {
			$pdf->SetMargins(0, 0, 0);
		} else {
			$pdf->SetMargins(0, 4, 0, true);
		}
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// Set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);


		// Set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// Add a page
		$pdf->AddPage();

		// Load the view and pass the data
		$html = $this->load->view('admin/timesheet-management/print_timesheet', $data, true);

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// Close and output PDF document
		$pdf->Output('timesheet ' . 1 . '.pdf', 'I');
	}

	public function print_monthly_report()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$reports = $this->get_monthReport();
		$this->load->library('Pdf_timesheet_monthly_report');
		$pdf = new Pdf_timesheet_monthly_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// Set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Attendance Report');
		$pdf->SetSubject('Report');
		$pdf->SetKeywords('TCPDF, PDF, Attendance, Report');

		// Load the header HTML
		$firstHeader = $this->load->view('admin/timesheet-management/print_monthlyReport_header', [], true);
		$pdf->setHtmlHeader($firstHeader);

		// Setmargin
		$pdf->setHeaderMargin(0);
		$pdf->SetMargins(0, 28, 4, true);
		// $pdf->setFooterMargin(0);

		$pdf->AddPage();
		$html = $this->load->view('admin/timesheet-management/print_rider_monthlyReport', $reports, true);
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		$pdf->Output('Attendance Report' . date('Y-m-d_H-i-s') . '.pdf', 'I');
	}

	public function get_all_data()
	{
		// Get input parameters and sanitize them
		$emp = $this->input->get('emp', TRUE);
		$platform = $this->input->get('platform', TRUE);
		$camp = $this->input->get('camp', TRUE);
		$from = $this->input->get('from', TRUE);
		$to = $this->input->get('to', TRUE);
		$fromDate = DateTime::createFromFormat('d M, Y', $from)->format('Y-m-d');
		$toDate = DateTime::createFromFormat('d M, Y', $to)->format('Y-m-d');

		// Initialize query builder
		// $this->db->select('vehicle_timesheets.*, master_vehicles.id as vehicle_id, master_vehicles.vehicle_no, master_employee.id as employee_id, master_employee.emp_no, master_employee.full_name as employee_name,food_deliv_companies.company_name,logistic_rider.id_number,hunger_order_summary.working_hours');
		// $this->db->from('vehicle_timesheets');
		// $this->db->join('master_vehicles', 'vehicle_timesheets.vehicle_id = master_vehicles.id', 'left');
		// $this->db->join('master_employee', 'vehicle_timesheets.driver_id = master_employee.id', 'left');
		// $this->db->join('food_deliv_companies', 'vehicle_timesheets.delivery_platform = food_deliv_companies.id', 'left');
		// $this->db->join('logistic_rider','vehicle_timesheets.driver_id=logistic_rider.employee_id','left');
		// $this->db->join('hunger_order_summary','logistic_rider.id_number = hunger_order_summary.rider_id AND DATE(vehicle_timesheets.created_at) = DATE(hunger_order_summary.date_local)', 'left');

		$this->db->distinct();
		$this->db->select('vt.*,mv.id as vehicle_id, mv.vehicle_no,me.id as employee_id,me.emp_no,me.full_name as employee_name,fdc.company_name,lr.id_number,hos.working_hours,hos.completed_deliveries,ma.new_status as logs');
		$this->db->from('vehicle_timesheets vt');
		$this->db->join('master_vehicles mv', 'vt.vehicle_id = mv.id', 'left');
		$this->db->join('master_employee me', 'vt.driver_id = me.id', 'left');
		$this->db->join('food_deliv_companies fdc', 'vt.delivery_platform = fdc.id', 'left');
		$this->db->join('logistic_rider lr', 'vt.driver_id = lr.employee_id', 'left');
		$this->db->join('hunger_order_summary hos', 'lr.id_number = hos.rider_id AND DATE(vt.created_at) = DATE(hos.date_local)', 'left');
		$this->db->join('manage_attendance ma', 'DATE(vt.out_time) = ma.date AND vt.driver_id = ma.emp_id', 'left');
		// Apply filters
		if ($emp) {
			$this->db->where('vt.driver_id', $emp);
		}

		if ($platform) {
			$this->db->where('vt.delivery_platform', $platform);
		}

		if ($camp) {
			$this->db->join('master_camp', 'me.camp = master_camp.id');
			$this->db->where('master_camp.id', $camp);
		}

		if ($from && $to) {
			$v_from = date("Y-m-d", strtotime($fromDate));
			$d_to = date("Y-m-d", strtotime($toDate));
			$this->db->where('DATE(vt.out_time) >=', $v_from);
			$this->db->where('DATE(vt.out_time) <=', $d_to);
		}
		$this->db->where('me.status', 'Active');
		$this->db->order_by("vt.time_id", "desc");

		$fetch_data = $this->db->get()->result();

		return $fetch_data;
	}

	public function get_monthReport()
	{
		$rider_id = $this->input->post('emp_id');
		$date = DateTime::createFromFormat('F Y', $this->input->post('month'));
		$month = $date->format('m');
		$year = $date->format('Y');

		$start_date = date('01/m/Y', strtotime("01-$month-$year"));
		$end_date = date('t/m/Y', strtotime("01-$month-$year"));
		$financial_year_start_date = date('01/01/Y', strtotime("01-$month-$year"));

		$dates = generate_dates_for_month($year, $month);

		// Retrieve timesheet data
		$timesheet = $this->db->select('vehicle_timesheets.*, logistic_rider.id_number, hunger_order_summary.working_hours, hunger_order_summary.created_at as attendance_created_at')
			->from('vehicle_timesheets')
			->join('logistic_rider', 'vehicle_timesheets.driver_id = logistic_rider.employee_id')
			->join('hunger_order_summary', 'logistic_rider.id_number = hunger_order_summary.rider_id AND DATE(vehicle_timesheets.created_at) = DATE(hunger_order_summary.created_at)', 'left')
			->where('vehicle_timesheets.driver_id', $rider_id)
			->where('MONTH(vehicle_timesheets.created_at)', $month)
			->where('YEAR(vehicle_timesheets.created_at)', $year)
			->get()
			->result();

		$data['rider_name'] = $this->db->where('id', $rider_id)->get('master_employee')->row()->full_name;
		$final_report = merge_with_timesheet($dates, $timesheet);
		$total_working_hours = calculate_total_working_hours($final_report);
		list($present_days, $absent_days, $total_leaves, $sign_in_only_days, $sign_out_only_days) = calculate_presence_absence_days($final_report);

		$data['final_report'] = $final_report;
		$data['rider_id'] = $rider_id;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['financial_year_start_date'] = $financial_year_start_date;
		$data['total_working_hours'] = $total_working_hours;
		$data['present_days'] = $present_days;
		$data['absent_days'] = $absent_days;
		$data['total_leaves'] = $total_leaves;
		$data['sign_in_only_days'] = $sign_in_only_days;
		$data['sign_out_only_days'] = $sign_out_only_days;
		return $data;
	}

	public function get_monthly_attendance()
	{
		$vehicles = $this->db->select('master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.full_name')->join('master_employee', 'master_employee.id=master_vehicles.alloted_user', 'left')->get('master_vehicles')->result();
		$employees = $this->db->select('id,emp_no,full_name')->get('master_employee')->result();
		$camps = $this->db->select('id,camp_name')->get('master_camp')->result();
		$platforms = $this->db->select('id,company_name')->get('food_deliv_companies')->result();
		$last_date = $this->db->select('out_time')->from('vehicle_timesheets')->order_by('out_time', 'DESC')->limit(1)->get()->row();
		$filter_date = date("Y-m-d", strtotime($last_date->out_time));
		if (!empty($this->input->get('emp'))) {
			$emp = $this->input->get('emp');
		} else {
			$emp = FALSE;
		}
		if (!empty($this->input->get('platform'))) {
			$platform = $this->input->get('platform');
		} else {
			$platform = FALSE;
		}
		if (!empty($this->input->get('camp'))) {
			$camp = $this->input->get('camp');
		} else {
			$camp = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$start_date = date("Y-m-d", strtotime($this->input->get('from')));
		} else {
			$start_date = $filter_date;
		}
		if (!empty($this->input->get('to'))) {
			$end_date = date("Y-m-d", strtotime($this->input->get('to')));
		} else {
			$end_date = FALSE;
		}
		if (!empty($this->input->get('attendance_status'))) {
			$attend_status = $this->input->get('attendance_status');
		} else {
			$attend_status = FALSE;
		}

		$this->load->model('admin/logistic-management/Timesheet_model');
		$timesheet = $this->Timesheet_model->print_monthly_attendance($emp, $platform, $camp, $start_date, $end_date, $attend_status);
		return $this->load->view('admin/timesheet-management/monthly-attendance', compact('vehicles', 'employees', 'camps', 'start_date', 'platforms', 'timesheet'));
	}

	public function get_monthly_attendance_list()
	{
		if (!empty($this->input->get('emp'))) {
			$emp = $this->input->get('emp');
		} else {
			$emp = FALSE;
		}
		if (!empty($this->input->get('platform'))) {
			$platform = $this->input->get('platform');
		} else {
			$platform = FALSE;
		}
		if (!empty($this->input->get('camp'))) {
			$camp = $this->input->get('camp');
		} else {
			$camp = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$start_date = date("Y-m-d", strtotime($this->input->get('from')));
		} else {
			$start_date = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$end_date = date("Y-m-d", strtotime($this->input->get('to')));
		} else {
			$end_date = FALSE;
		}
		if (!empty($this->input->get('attendance_status'))) {
			$attend_status = $this->input->get('attendance_status');
		} else {
			$attend_status = FALSE;
		}

		$this->load->model('admin/logistic-management/Timesheet_model');
		$attendance_report = $this->Timesheet_model->get_monthly_attendance($emp, $platform, $camp, $start_date, $end_date, $attend_status);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($attendance_report as $timesheet) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $timesheet->emp_no;
			$sub_array[] = $timesheet->employee_name;
			$sub_array[] = $timesheet->vehicle_no;
			$sub_array[] = $timesheet->company_name;
			$sub_array[] = (!empty($timesheet->out_time)) ? $this->format_date($timesheet->out_time) : 'NA';
			$sub_array[] = $timesheet->working_hours;
			$sub_array[] = $timesheet->completed_deliveries;
			$sub_array[] = (int)$timesheet->out_km;
			$sub_array[] = $timesheet->out_battery;
			$sub_array[] = '<a class="btn btn-outline-info btn-custom-light btn-sm edit" onclick="adminViewTimesheet(this)" title="View" href="javascript:void(0)" vehicle_no="' . $timesheet->vehicle_no . '" emp_no="' . $timesheet->emp_no . '" emp_name="' . $timesheet->employee_name . '" checkIn_km="' . $timesheet->in_km . '" checkOut_km="' . $timesheet->out_km . '" checkIn_battery="' . $timesheet->in_battery . '" checkOut_battery="' . $timesheet->out_battery . '" checkIn_time="' . $this->format_date($timesheet->in_time) . '" checkOut_time="' . $this->format_date($timesheet->out_time) . '"><i class="mdi mdi-eye font-size-18"></i></a>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->Timesheet_model->get_all_data(),
			"recordsFiltered" => $this->Timesheet_model->get_filtered_data($emp, $platform, $camp, $start_date, $end_date, $attend_status),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function print_attendance_summary()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if (!empty($this->input->get('emp'))) {
			$emp = $this->input->get('emp');
		} else {
			$emp = FALSE;
		}
		if (!empty($this->input->get('platform'))) {
			$platform = $this->input->get('platform');
		} else {
			$platform = FALSE;
		}
		if (!empty($this->input->get('camp'))) {
			$camp = $this->input->get('camp');
		} else {
			$camp = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$start_date = (!empty($this->input->get('from'))) ? DateTime::createFromFormat('d M, Y', $this->input->get('from'))->format('Y-m-d') : null;
		} else {
			$start_date = $filter_date;
		}
		if (!empty($this->input->get('to'))) {
			$end_date = date("Y-m-d", strtotime($this->input->get('to')));
		} else {
			$end_date = FALSE;
		}
		if (!empty($this->input->get('attendance_status'))) {
			$attend_status = $this->input->get('attendance_status');
		} else {
			$attend_status = FALSE;
		}
		$this->load->model('admin/logistic-management/Timesheet_model');
		$last_date = $this->db->select('out_time')->from('vehicle_timesheets')->order_by('out_time', 'DESC')->limit(1)->get()->row();
		$filter_date = date("Y-m-d", strtotime($last_date->out_time));
		$data['timesheet'] = $this->Timesheet_model->print_monthly_attendance($emp, $platform, $camp, $start_date, $end_date, $attend_status);
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// Set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Vehicle Timesheet');
		$pdf->SetSubject('Timesheet');
		$pdf->SetKeywords('TCPDF, PDF, Timesheet, list');

		// Set default header data
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// Set margins
		if ($pdf->PageNo() == '1') {
			$pdf->SetMargins(5, 0, 5);
		} else {
			$pdf->SetMargins(0, 4, 0, true);
		}
		$pdf->SetHeaderMargin(0);
		$pdf->SetFooterMargin(0);

		// Set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 15);


		// Set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// Add a page
		$pdf->AddPage();
		// Load the view and pass the data
		$html = $this->load->view('admin/timesheet-management/print_attendance_summary', $data, true);

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// Close and output PDF document
		$pdf->Output('timesheet_attendance ' . 1 . '.pdf', 'I');
	}

	public function print_monthly_attendance_report() {
		if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->model('admin/logistic-management/Timesheet_model');
		$this->load->library('Pdf_hunger_report_landscape');
		// Fetch form inputs
		$rider_id = $this->input->post('emp_id') ? $this->input->post('emp_id') : FALSE;
		$team_id = $this->input->post('team') ? $this->input->post('team') : FALSE;
		$month_of = $this->input->post('month', TRUE) ?? 'Jan 2025';
	
		// Decode and validate month_of
		$month_of = urldecode($month_of);
		// Fetch data from model
		//dd($month_of);
		try {
			$data['reports'] = $this->Timesheet_model->monthly_attendance_report($month_of,$rider_id,$team_id);
		} catch (Exception $e) {
			log_message('error', 'Error fetching performance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}
		// Prepare data for the PDF
		$data['search_rider_id'] = $rider_id;
		$data['search_team_id'] = $team_id;
		$data['search_team_name'] = !empty($data['reports']) ? $data['reports'][0]->team_name : null;
		$data['search_month'] = $month_of ? htmlspecialchars($month_of) : 'NA';
		$data['admin'] = 'Amanullah Kazi';
	
		// Create PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Attendance Report');
		$pdf->SetSubject('Monthly Attendance Report');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Attendance Report');
	
		// Remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/timesheet-management/monthly_attendance_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/timesheet-management/monthly_attendance_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
	
		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);
	
		// Set default monospaced font and margins
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetMargins(4, 60, 4, true);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
		// Language-dependent strings
		if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
			require_once(dirname(__FILE__) . '/lang/eng.php');
			$pdf->setLanguageArray($l);
		}
	
		// Add a page and set font
		$pdf->AddPage('L', 'A3');
		$pdf->setRTL(false);
		//$pdf->SetFont('aealarabiya', '', 10);
		// Load and write content
		$htmlcontent = $this->load->view('admin/timesheet-management/print_monthly_attendance', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
	
		// Output PDF
		$filename = $month_of
			? 'BS-Monthly-Attendance-Report-' . htmlspecialchars($month_of) . '.pdf'
			: 'BS-Monthly-Attendance-All-Report.pdf';
		$pdf->Output($filename, 'I');
	}
}
