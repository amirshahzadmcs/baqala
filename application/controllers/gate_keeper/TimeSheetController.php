<?php defined('BASEPATH') or exit('No direct script access allowed');

class TimeSheetController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		if ($this->gatekeeper->isLogged()) {
			$this->load->library('form_validation');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
		} else {
			redirect("gate-keeper/login");
		}
	}

	public function get_timesheet()
	{
		$vehicles = $this->db->select('master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.full_name')->join('master_employee', 'master_employee.id=master_vehicles.alloted_user', 'left')->get('master_vehicles')->result();

		return $this->load->view('gate_keeper/pages/vehicle_timesheet/index', compact('vehicles'));
	}

	public function get_list()
	{
		$this->db->select('vehicle_timesheets.*,master_vehicles.id as vehicle_id,master_vehicles.vehicle_no,master_employee.id as employee_id,master_employee.emp_no,master_employee.full_name as employee_name,food_deliv_companies.company_name');
		$this->db->join('master_vehicles', 'vehicle_timesheets.vehicle_id = master_vehicles.id', 'left');
		$this->db->join('master_employee', 'vehicle_timesheets.driver_id = master_employee.id', 'left');
		$this->db->join('food_deliv_companies', 'vehicle_timesheets.delivery_platform = food_deliv_companies.id', 'left');
		//$this->db->where('vehicle_timesheets.created_by',$this->gatekeeper->getId()); // Assuming driver_id is the correct field
		if ($_POST["length"] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$this->db->order_by("time_id", "desc");
		$fetch_data = $this->db->where('DATE(vehicle_timesheets.created_at)', date('Y-m-d'))->get('vehicle_timesheets')->result();
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
			// $sub_array[] = $timesheet->in_time != null ? date('d-m-Y H:i a', strtotime($timesheet->in_time)) : '';
			$sub_array[] = (int)$timesheet->out_km;
			$sub_array[] = $timesheet->out_battery;
			$sub_array[] = '<a class="btn btn-outline-info btn-custom-light btn-sm edit" onclick="geteKeeperViewTimesheet(this)" title="View" href="javascript:void(0)" vehicle_no="' . $timesheet->vehicle_no . '" emp_no="' . $timesheet->emp_no . '" emp_name="' . $timesheet->employee_name . '" checkIn_km="' . $timesheet->in_km . '" checkOut_km="' . $timesheet->out_km . '" checkIn_battery="' . $timesheet->in_battery . '" checkOut_battery="' . $timesheet->out_battery . '" checkIn_time="' . date('d-m-Y H:i a', strtotime($timesheet->in_time)) . '" checkOut_time="' . date('d-m-Y H:i a', strtotime($timesheet->out_time)) . '"><i class="mdi mdi-eye font-size-18"></i></a>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->db->from("vehicle_timesheets")->where('DATE(vehicle_timesheets.created_at)', date('Y-m-d'))->count_all_results(),
			"recordsFiltered"     =>     count($fetch_data),
			"data"                =>     $data
		);
		echo json_encode($output);
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
						'error' => 'Employee Status Not Active'
					]);
				} else {
					if ($emp->rider_status != 'active') {
						echo json_encode([
							'status' => false,
							'error' => 'Rider Status Not Active'
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



			// Ensure employee exists and has vehicle details
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
					// 'platforms' => $platforms,
					'km' => $this->session->userdata('vehicle_km')
				]);
				// }
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
			$delivery_platform = $this->input->post('delivery_platform');

			$data = [
				'driver_id' => $driver_id,
				'vehicle_id' => $vehicle_id,
				'out_time' => $out_time,
				'out_km' => $km_driven,
				'out_battery' => $battery_status,
				'delivery_platform' => $delivery_platform,
				'created_by' => $this->gatekeeper->getId(),
			];

			$insert = $this->db->insert('vehicle_timesheets', $data);
			if ($insert) {
				$this->session->set_userdata('info', "1--Successfully done");
				return redirect('gate-keeper');
			} else {
				$this->session->set_userdata('info', "2--Something Went Wrong");
				return redirect('gate-keeper');
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
				'in_battery' => $battery_status,
				'created_by' => $this->gatekeeper->getId()
			];

			$update = $this->db->update('vehicle_timesheets', $data, ['time_id' => $parking_slot->time_id]);
			if ($update) {
				$this->session->set_userdata('info', "1--Successfully done");
				return redirect('gate-keeper');
			} else {
				$this->session->set_userdata('info', "2--Something Went Wrong");
				return redirect('gate-keeper');
			}
		}
	}

	public function delete()
	{
		$delete = $this->db->where('time_id', $this->input->get('id'))->delete('vehicle_timesheets');
		if ($delete) {
			$this->session->set_userdata('info', "1--Successfully done");
			return redirect('gate-keeper/vehicle/get-timesheet');
		} else {
			$this->session->set_userdata('info', "2--Something Went Wrong");
			return redirect('gate-keeper/vehicle/get-timesheet');
		}
	}
}
