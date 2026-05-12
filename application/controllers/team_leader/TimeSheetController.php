<?php defined('BASEPATH') or exit('No direct script access allowed');

class TimeSheetController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->teamleader->isLogged()) {
			$this->load->library('form_validation');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->load->library('user_agent');
			require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
		} else {
			redirect("team-leader/login");
		}
	}

	public function get_timesheet()
	{
		$hunger_team = json_decode($this->db->get_where('hunger_team', ['team_leader' => $this->teamleader->getId()])->row()?->team ?? '[]');
		$vehicles = $this->db->select('master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.full_name')->join('master_employee', 'master_employee.id=master_vehicles.alloted_user', 'left')->get('master_vehicles')->result();
		$employees = $this->db->select('id,emp_no,full_name')->where_in('id', empty($hunger_team) ? [0] : $hunger_team)->get('master_employee')->result();
		return $this->load->view('team_leader/hunger/attendance_list', compact('vehicles', 'employees'));
	}

	public function get_list()
	{
		$emp = $this->input->get('emp', TRUE);
		$from = $this->input->get('from', TRUE);
		$to = $this->input->get('to', TRUE);
		$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
		$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
		$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;

		$hunger_team = json_decode($this->db->get_where('hunger_team', ['team_leader' => $this->teamleader->getId()])->row()?->team ?? '[]');
		$this->db->select('vehicle_timesheets.*,master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.emp_no,master_employee.full_name as employee_name,food_deliv_companies.company_name');
		$this->db->from('vehicle_timesheets');
		$this->db->join('master_vehicles', 'vehicle_timesheets.vehicle_id = master_vehicles.id', 'left');
		$this->db->join('master_employee', 'vehicle_timesheets.driver_id = master_employee.id', 'left');
		$this->db->join('food_deliv_companies', 'vehicle_timesheets.delivery_platform = food_deliv_companies.id', 'left');
		$this->db->where_in('vehicle_timesheets.driver_id', empty($hunger_team) ? [0] : $hunger_team);

		if ($emp) {
			$this->db->where('vehicle_timesheets.driver_id', $emp);
		}

		if ($from && $to) {
			$v_from = date("Y-m-d", strtotime($from));
			$d_to = date("Y-m-d", strtotime($to . ' +1 day'));

			$this->db->where('vehicle_timesheets.out_time >=', $v_from);
			$this->db->where('vehicle_timesheets.out_time <', $d_to);
		}

		$countQuery = clone $this->db;
		$recordsFiltered = $countQuery->count_all_results();

		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}

		$fetch_data = $this->db->order_by("vehicle_timesheets.time_id", "desc")->get()->result();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $timesheet) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $timesheet->vehicle_no;
			$sub_array[] = $timesheet->emp_no;
			$sub_array[] = $timesheet->employee_name;
			$sub_array[] = $timesheet->company_name;
			$sub_array[] = date('d-m-Y H:i a', strtotime($timesheet->out_time));
			$sub_array[] = (int)$timesheet->out_km;
			$sub_array[] = $timesheet->out_battery;
			$sub_array[] = '<a class="btn btn-outline-info btn-custom-light btn-sm edit" onclick="geteKeeperViewTimesheet(this)" title="View" href="javascript:void(0)" vehicle_no="' . $timesheet->vehicle_no . '" emp_no="' . $timesheet->emp_no . '" emp_name="' . $timesheet->employee_name . '" checkIn_km="' . $timesheet->in_km . '" checkOut_km="' . $timesheet->out_km . '" checkIn_battery="' . $timesheet->in_battery . '" checkOut_battery="' . $timesheet->out_battery . '" checkIn_time="' . date('d-m-Y H:i a', strtotime($timesheet->in_time)) . '" checkOut_time="' . date('d-m-Y H:i a', strtotime($timesheet->out_time)) . '"><i class="mdi mdi-eye font-size-18"></i></a>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $recordsFiltered,
			"recordsFiltered"     =>     $recordsFiltered,
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function check_emp_detail()
	{
		$employee_no = $this->input->get('employee_no');
		$employee = $this->db->get_where('master_employee', ['emp_no' => $employee_no])->row();

		if ($employee) {
			$hunger_team = $this->db->where('team_leader', $this->teamleader->getId())
				->where("JSON_CONTAINS(team, '[\"{$employee->id}\"]')", null, false)
				->get('hunger_team')
				->row();
			if (!$hunger_team) {
				echo json_encode(['status' => false, 'error' => 'Rider Not Found']);
				return;
			}
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
				lr.rider_status,
            ')
				->from('master_employee')
				->join('master_vehicles', 'master_employee.id = master_vehicles.alloted_user', 'left')
				->join('master_job_title mjt', 'master_employee.designation = mjt.id', 'left')
				->join('master_department md', 'master_employee.department = md.id', 'left')
				->join('mater_van_make mvm', 'master_vehicles.vehicle_make = mvm.id', 'left')
				->join('master_camp mc', 'master_employee.camp = mc.id', 'left')
				->join('master_rooms mr', 'master_employee.room = mr.id', 'left')
				->join('master_bed mb', 'master_employee.bed = mb.id', 'left')
				->join('logistic_rider lr', 'master_employee.id = lr.employee_id', 'right')
				->where('master_employee.id', $employee->id)
				->get()
				->row();
			if ($emp) {
				if ($emp->status != 'Active') {
					echo json_encode([
						'status' => false,
						'error' => 'Employee Status is '.ucfirst($emp->status)
					]);
				} else {
					if ($emp->rider_status != 'active') {
						echo json_encode([
							'status' => false,
							'error' => 'Rider Status is '.ucfirst($emp->rider_status)
						]);
					} else {

						echo json_encode(['status' => true, 'message' => 'Rider Detail Fetched', 'employee' => $emp]);
					}
				}
			} else {
				echo json_encode(['status' => false, 'error' => 'Rider Not Found']);
			}
		} else {
			echo json_encode(['status' => false, 'error' => 'Rider Not Found']);
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
			$otp = rand(000000, 999999);
			$this->db->insert(
				'driver_otp_verification',
				[
					'emp_id' => $emp_id,
					'email' => $rec_email,
					'otp' => $otp,
					'ip_address' => $this->ip_address
				]
			);
			$eSetting = $this->customer->emailSetting();
			$this->load->library('phpmailer_lib');
			$mail = $this->phpmailer_lib->load();

			$mail->SMTPDebug = 0;
			$mail->isSMTP();
			$mail->Protocol = $eSetting->protocol;
			$mail->Host       = $eSetting->smtp_host;
			$mail->SMTPAuth   = true;
			$mail->Username   = $eSetting->smtp_user;
			$mail->Password   = $eSetting->smtp_pass;
			$mail->SMTPSecure = 'ssl';
			$mail->Port       = $eSetting->smtp_port;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			$mail->setFrom($eSetting->smtp_user, $eSetting->website_name);
			$mail->addAddress($rec_email);
			$mail->addReplyTo($eSetting->smtp_user, $eSetting->website_name);

			$mail->isHTML(true);
			$mail->Subject = 'Your Timesheet  One-Time Password (OTP)';
			$mail->Body    = 'Dear Rider,<br><br>Your one-time password (OTP) for Timesheet  is: ' . $otp . '<br><br>Please use this code to access your parking spot.<br><br>Thank you.<br><br>Best regards,<br>HR Department';

			if ($mail->send()) {
				echo json_encode(['status' => true, 'message' => 'OTP sent to driver email', 'emp_id' => $emp_id]);
			} else {
				echo json_encode(['status' => false, 'message' => 'Failed to send OTP', 'error' => $this->email->print_debugger()]);
			}
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
			$employee = $this->db->select('master_employee.*, master_vehicles.id as vehicle_id,lr.rider_status,fdc.id as platform_id,fdc.company_name')
				->join('master_vehicles', 'master_employee.id = master_vehicles.alloted_user', 'left')
				->join('logistic_rider lr', 'master_employee.id=lr.employee_id', 'left')
				->join('food_deliv_companies as fdc', 'lr.platform=fdc.id', 'left')
				->where('master_employee.id', $emp_id)
				->get('master_employee')
				->row();
			if ($employee && isset($employee->vehicle_id)) {
				// Count parking records
				// $parking_count = $this->db->where(['driver_id' => $emp_id, 'vehicle_id' => $employee->vehicle_id])
				// 	->from('vehicle_timesheets')
				// 	->count_all_results();
				// $platforms = $this->db->select('id,company_name')->get('food_deliv_companies')->result();

				// if ($parking_count > 0) {
				// 	// Parking records found, proceed with your logic here
				// 	$active_record = $this->db->select('in_time, out_time')
				// 		->where(['driver_id' => $emp_id, 'vehicle_id' => $employee->vehicle_id, 'in_time' => null])
				// 		->order_by('in_time', 'DESC')
				// 		->get('vehicle_timesheets')
				// 		->row();

				// 	if ($active_record) {
				// 		// If an active record exists, open the check-out form
				// 		echo json_encode([
				// 			'status' => true,
				// 			'message' => 'Please Enter Vehicle Detail',
				// 			'form' => 'Check In',
				// 			'employee' => $employee,
				// 			'km' => $this->session->userdata('vehicle_km')
				// 		]);
				// 	} else {
				// 		// No active record, open the check-in form
				// 		echo json_encode([
				// 			'status' => true,
				// 			'message' => 'Please Enter Vehicle Detail',
				// 			'form' => 'Check Out',
				// 			'employee' => $employee,
				// 			// 'platforms' => $platforms,
				// 			'km' => $this->session->userdata('vehicle_km')
				// 		]);
				// 	}
				// } else {
				// No parking records found, request vehicle detail entry
				echo json_encode([
					'status' => true,
					'message' => 'Please Enter Vehicle Detail',
					'form' => 'Check Out',
					'employee' => $employee,
					'km' => $this->session->userdata('vehicle_km')
				]);
				// }
			} else {
				echo json_encode([
					'status' => false,
					'message' => 'Employee or Vehicle details not found'
				]);
			}
		} else {
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
			return redirect('team-leader/vehicle/get-timesheet');
		} else {
			$out_time = date('Y-m-d H:i:s');
			$driver_id = $this->input->post('driver_id');
			$vehicle_id = $this->input->post('vehicle_id');
			$km_driven = $this->input->post('km_driven');
			$battery_status = $this->input->post('battery_status');
			$delivery_platform = $this->input->post('delivery_platform');
			$current_date = date('Y-m-d');

			$existing_record = $this->db->get_where('vehicle_timesheets', [
				'driver_id' => $driver_id,
				'vehicle_id' => $vehicle_id,
				'DATE(out_time)' => $current_date
			])->row();

			if ($existing_record) {
				$this->session->set_userdata('info', "2--Attendance already recorded for today.");
				return redirect('team-leader/vehicle/get-timesheet');
			}

			$data = [
				'driver_id' => $driver_id,
				'vehicle_id' => $vehicle_id,
				'out_time' => $out_time,
				'out_km' => $km_driven,
				'out_battery' => $battery_status,
				'delivery_platform' => $delivery_platform,
				'created_by' => $this->teamleader->getId(),
			];

			$insert = $this->db->insert('vehicle_timesheets', $data);
			if ($insert) {
				$this->session->set_userdata('info', "1--Successfully done");
				return redirect('team-leader/vehicle/get-timesheet');
			} else {
				$this->session->set_userdata('info', "2--Something Went Wrong");
				return redirect('team-leader/vehicle/get-timesheet');
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
			return redirect('team-leader/vehicle/get-timesheet');
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
				'in_battery' => $battery_status,
				'created_by' => $this->teamleader->getId()
			];

			$update = $this->db->update('vehicle_timesheets', $data, ['time_id' => $parking_slot->time_id]);
			if ($update) {
				$this->session->set_userdata('info', "1--Successfully done");
				return redirect('team-leader');
			} else {
				$this->session->set_userdata('info', "2--Something Went Wrong");
				return redirect('team-leader');
			}
		}
	}

	public function delete()
	{
		$delete = $this->db->where('time_id', $this->input->get('id'))->delete('vehicle_timesheets');
		if ($delete) {
			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('team-leader/vehicle/get-timesheet');
		} else {
			$this->session->set_userdata('info', "2--Something Went Wrong");
			return redirect('team-leader/vehicle/get-timesheet');
		}
	}

	public function print_timesheet()
	{
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

	public function get_all_data()
	{
		$emp = $this->input->get('emp', TRUE);
		$from = $this->input->get('from', TRUE);
		$to = $this->input->get('to', TRUE);
		$hunger_team = json_decode($this->db->get_where('hunger_team', ['team_leader' => $this->teamleader->getId()])->row()?->team ?? '[]');

		$this->db->distinct();
		$this->db->select('vt.*,mv.id as vehicle_id, mv.vehicle_no,me.id as employee_id,me.emp_no,me.full_name as employee_name,fdc.company_name,lr.id_number,hos.working_hours,hos.completed_deliveries,ma.new_status as logs');
		$this->db->from('vehicle_timesheets vt');
		$this->db->join('master_vehicles mv', 'vt.vehicle_id = mv.id', 'left');
		$this->db->join('master_employee me', 'vt.driver_id = me.id', 'left');
		$this->db->join('food_deliv_companies fdc', 'vt.delivery_platform = fdc.id', 'left');
		$this->db->join('logistic_rider lr', 'vt.driver_id = lr.employee_id', 'left');
		$this->db->join('hunger_order_summary hos', 'lr.id_number = hos.rider_id AND DATE(vt.created_at) = DATE(hos.date_local)', 'left');
		$this->db->where_in('vt.driver_id', empty($hunger_team) ? [0] : $hunger_team);
		$this->db->join('manage_attendance ma', 'DATE(vt.out_time) = ma.date AND vt.driver_id = ma.emp_id', 'left');

		// Apply filters
		if ($emp) {
			$this->db->where('vt.driver_id', $emp);
		}

		if ($from && $to) {
			$v_from = date("Y-m-d", strtotime($from));
			$d_to = date("Y-m-d", strtotime($to . ' +1 day'));

			$this->db->where('vt.out_time >=', $v_from);
			$this->db->where('vt.out_time <', $d_to);
		}
		$this->db->where('me.status','Active');
		$this->db->order_by("time_id", "desc");

		$fetch_data = $this->db->get()->result();

		return $fetch_data;
	}
}
