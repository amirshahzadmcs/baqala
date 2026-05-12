<?php defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Employee_model', 'employee_model');
			$this->load->model('admin/hr-module/Attendance_model', 'attendance_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->helper('sendmail_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['attendance_summary'] = $this->attendance_model->getAttendanceSummaryByMonth();
		$this->load->view('admin/hr-module/attendance/index', $data);
	}

	public function generate_monthly_attendance()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$month = $this->input->post('month');
		$overwrite = $this->input->post('overwrite');

		if (!$month) {
			echo json_encode(['message' => 'Month is required']);
			return;
		}

		$this->load->model('Attendance_model');
		$result = $this->attendance_model->generate_attendance_for_month($month, $overwrite);

		echo json_encode(['message' => $result ? 'Attendance generated successfully.' : 'Failed to generate attendance.']);
	}

	public function check_month_exists()
	{
		$monthInput = $this->input->post('month'); // e.g., "June 2025"
		if (!$monthInput) {
			echo json_encode(['exists' => false]);
			return;
		}

		// Convert to YYYY-MM
		$month = date('Y-m', strtotime($monthInput));

		$this->db->from('maha_employee_attendance');
		$this->db->where("DATE_FORMAT(date_of_attend, '%Y-%m') =", $month);
		$exists = $this->db->count_all_results() > 0;

		header('Content-Type: application/json');
		echo json_encode(['exists' => $exists]);
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view('admin/hr-module/attendance/detail', $data);
	}

	public function get_list($month = null)
	{
		if (!$month) {
			$this->session->set_flashdata('error', 'Invalid month specified.');
			redirect('admin/hr/attendance/list');
		}
		$fetch_data = $this->attendance_model->get_list($month);
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $item) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $item->emp_no;
			$sub_array[] = (($item->emp_full_name !== '') ? $item->emp_full_name : '');
			$sub_array[] = $item->iqama_no;
			$sub_array[] = ((isset($item->date_of_attend)) ? date('d-m-Y', strtotime($item->date_of_attend)) : '');
			$sub_array[] = '<a href="javascript:void(0)" 
                  class="border-bottom border-dark text-dark edit-attendance" 
                  data-id="'.$item->id.'" 
                  data-empname="'.htmlspecialchars($item->emp_full_name).'" 
                  data-date="'.date('d-m-Y', strtotime($item->date_of_attend)).'" 
                  data-attendtype="'.$item->attend_type.'">
                    '.ucfirst($item->attend_type).'
               </a>';
			$sub_array[] = $item->vehicle_no ? $item->vehicle_no : '-';
			$sub_array[] = $item->vehicle_type ? $item->vehicle_type : '-';
			$sub_array[] = $item->aggregator_id ? $item->aggregator_id : '-';
			$sub_array[] = $item->aggregator_name ? $item->aggregator_name : '-';
			$sub_array[] = $item->total_deliveries ? $item->total_deliveries : '-';
			$sub_array[] = $item->team_name ? $item->team_name : '-';
			$sub_array[] = $item->remarks ? $item->remarks : '-';
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			$sub_array[] = ((isset($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : '');
			$userRole = get_user_role();
			$actionDropdown = '<div class="btn-group ms-2 float-end">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">';
				$actionDropdown .= '<a type="button" class="dropdown-item px-3 py-0 load_logs_modal" title="Logs" data-id="' . $item->id . '">
					<i class="mdi mdi-timer-sand font-size-16"></i> View Logs
				</a>';
				$actionDropdown .= '<div class="dropdown-divider"></div><a href="'. base_url('admin/hr/attendance/print-employee-attendance/'. $item->id) .'" class="dropdown-item px-3 py-0" title="Print Attendance" target="_blank" data-id="' . $item->id . '">
					<i class="mdi mdi-printer font-size-16"></i> All Attendance of ' . date('F Y', strtotime($item->date_of_attend)) . '
				</a>';
			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->attendance_model->get_all_data(),
			"recordsFiltered"     =>     $this->attendance_model->get_filtered_data($month),
			"data"                =>     $data
		);
		echo json_encode($output);
	}
	
	public function filter_modal_form($month){
		$data['monthParam'] = $month;
		if($data['monthParam']){
			$data['filter_title'] = "Apply Filter - " . date('M Y', strtotime($month));
			$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
			$this->load->view('admin/hr-module/attendance/components/filter_modal', $data);
		}
    }

	public function export_modal_form($month){
		$data['monthParam'] = $month;
		if($data['monthParam']){
			$data['filter_title'] = "Compliance Report Filter - " . date('M Y', strtotime($month));
			$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
			$this->load->view('admin/hr-module/attendance/components/export_filter_modal', $data);
		}
    }

	public function delete($month = null)
	{

		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/hr/attendance/list');
		}

		$this->load->model('Attendance_model');
		$deleted = $this->Attendance_model->delete_attendance_by_month($month);

		if ($deleted) {
			$this->session->set_userdata('info', "1--Attendance for " . date('F Y', strtotime($month)) . " deleted successfully.");
		} else {
			$this->session->set_userdata('info', "2--Failed to delete attendance or attendance not found.");
		}
		redirect('admin/hr/attendance/list');
	}

	public function edit_attendance_detail($id)
	{
		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid attendance ID.']);
			return;
		}
		$attendance = $this->attendance_model->get_attendance_by_id($id);
		if (!$attendance) {
			echo json_encode(['status' => 'error', 'message' => 'Attendance record not found.']);
			return;
		}
		$data['attendance_detail'] = $attendance;
		// IMPORTANT: Return view as string
		$view_render = $this->load->view('admin/hr-module/attendance/components/edit_attendance', $data, TRUE);
		echo json_encode(['status' => 'success', 'html' => $view_render]);
	}

	public function view_logs($attendance_id)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if (!$attendance_id) {
			echo json_encode(['status' => 'error', 'message' => 'Invalid attendance ID']);
			return;
		}

		$this->load->model('attendance_model');
		$logs = $this->attendance_model->get_logs_by_attendance_id($attendance_id);
		// Decode JSON for each log
		foreach ($logs as &$log) {
			if (!is_array($log['log_details'])) {
				$log['log_details'] = json_decode(html_entity_decode($log['log_details']), true);
			}
		}

		// Render partial view
		$data['logs'] = $logs;
		$html = $this->load->view('admin/hr-module/attendance/components/log_modal_content', $data, TRUE);

		echo json_encode(['status' => 'success', 'html' => $html]);
	}

	public function update()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		// Load form validation library
		$this->load->library('form_validation');

		// Validation rules
		$this->form_validation->set_rules('attendance_id', 'Attendance ID', 'required|integer');
		//$this->form_validation->set_rules('attendance_type', 'Attendance Type', 'required|in_list[P,L,A,WO,AL,SL,CL,ML,PL,COL,BT,UL,MAR,WL]');
		$this->form_validation->set_rules('attendance_type', 'Attendance Type', 'required');
		$this->form_validation->set_rules('remarks', 'Remarks', 'trim|max_length[500]');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode([
				'status' => 'error',
				'message' => validation_errors()
			]);
			return;
		}

		$attendance_id = (int) $this->input->post('attendance_id');
		$attendance_type = $this->input->post('attendance_type', TRUE);
		$is_manual = 1;
		$remarks = $this->input->post('remarks', TRUE);

		// Prepare data to update
		$update_data = [
			'attend_type' => $attendance_type,
			'remarks' => $remarks,
			'is_manual' => $is_manual,
			'updated_at' => date('Y-m-d H:i:s')
		];

		$this->load->model('attendance_model');
		$result = $this->attendance_model->update_attendance($attendance_id, $update_data);

		if ($result) {
			echo json_encode([
				'status' => 'success',
				'message' => 'Attendance updated successfully'
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Failed to update attendance. Please try again.'
			]);
		}
	}

	public function print_monthly_attendance_summary($month = null)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/hr/attendance/list');
		}

		$this->load->model('admin/logistic-management/Timesheet_model');
		$this->load->library('Pdf_hunger_report_landscape');
		try {
			$data['reports'] = $this->attendance_model->monthly_attendance_summary($month, null, null, null);
		} catch (Exception $e) {
			log_message('error', 'Error fetching attendance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}
		//dd($data['reports']);
		// Prepare data for the PDF
		$data['search_month'] = $month ? htmlspecialchars($month) : 'NA';
		$data['admin'] = 'Amanullah Kazi';

		// Create PDF document
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Attendance Summary');
		$pdf->SetSubject('Monthly Attendance Summary');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Attendance Summary');

		// Remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/hr-module/attendance/print/monthly_attendance_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/hr-module/attendance/print/monthly_attendance_header', $data, true);
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
		$htmlcontent = $this->load->view('admin/hr-module/attendance/print/print_monthly_attendance', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		// Output PDF
		$filename = $month
			? 'BS-Monthly-Attendance-Summary-' . htmlspecialchars($month) . '.pdf'
			: 'BS-Monthly-Attendance-All-Summary.pdf';
		$pdf->Output($filename, 'I');
	}
	
	public function print_employee_attendance($id = null)
	{
		if (!$id) {
			$this->session->set_userdata('info', "2--Invalid employee ID specified.");
			redirect('admin/hr/attendance/list');
		}

		$this->load->library('Pdf_employee_offer');

		try {
			$attendance = $this->db->get_where('maha_employee_attendance', ['id' => $id])->row_array();
		} catch (Exception $e) {
			log_message('error', 'Error fetching attendance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}

		if (!empty($attendance)) {
			$emp_id = $attendance['emp_id'];

			// Format month to YYYY-MM for filtering
			$month = date('Y-m', strtotime($attendance['date_of_attend']));
			$data['month_of'] = date('F Y', strtotime($attendance['date_of_attend']));
			$data['emp_detail'] = employeeDetailHelper($emp_id, 'all');
			$data['attenance_list'] = $this->attendance_model->get_employee_attendance($emp_id, $month);

			$emp_no = $data['emp_detail']->emp_no ?? 'Unknown';
			// Debug only if needed
			//dd($data);

			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Employee Attendance Details - ' . $emp_no);
			$pdf->SetSubject('BS - Employee Attendance Details - ' . $emp_no);
			$pdf->SetKeywords('Baqala Station, PDF, Employee Attendance Details, Employee');

			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$pdf->setHtmlHeader('');
			$pdf->setHtmlHeader2('');
			$pdf->setHtmlFooter('');

			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(6, 5, 8, true);
			$pdf->SetAutoPageBreak(TRUE, 2);
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			$pdf->AddPage();
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);

			$htmlcontent = $this->load->view('admin/hr-module/attendance/print/single_employe_attendance', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

			// Use attendance date instead of undefined $request_date
			$visitDateMonth = date('F Y', strtotime($attendance['date_of_attend']));
			$pdf->Output("Attendance-".$emp_no."-".$visitDateMonth.".pdf", 'I');
		} else {
			$this->session->set_userdata('info', "2--Attendance detail not found!");
			redirect('admin/hr/attendance/list');
		}
	}
	
	public function print_attendance_report($month = null)
	{
		if ($this->action && !check_action_permission(get_user_role(), 'new_attendance', $this->action)):
			redirect('admin/unauthorized-request');
		endif;

		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/hr/attendance/list');
		}

		// Get filters
		$filters = [
			'date_from'       => $this->input->get('date_from'),
			'date_to'         => $this->input->get('date_to'),
			'keyword'         => $this->input->get('keyword'),
			'employer'        => $this->input->get('employer'),
			'team'            => $this->input->get('team'),
			'platform'        => $this->input->get('platform'),
			'vehicle_no'      => $this->input->get('vehicle_no'),
			'vehicle_type'    => $this->input->get('vehicle_type'),
			'compliance_wise' => $this->input->get('compliance_wise'),
		];

		$this->load->library('Pdf_hunger_report_landscape');

		try {
			// Initialize with empty arrays (so view won't error)
			$data['present_days_26'] = [];
			$data['no_week_off'] = [];
			$data['no_last_week_off'] = [];

			switch ($filters['compliance_wise']) {
				case '1': // 26 Days Present
					$data['report_type'] = 'Riders With 26 Days Present';
					//$data['all_compliance_data'] = $this->attendance_model->get_employees_meeting_all_conditions($month, $filters);
					//$data['compliance_summary'] = $this->attendance_model->get_employees_condition_summary($month, $filters);
					$data['present_days_26'] = $this->attendance_model->get_employees_with_26_present_days($month, $filters);
					$data['present_days_less_26'] = $this->attendance_model->get_employees_less_26_present_days($month, $filters);
					break;

				case '2': // 9+ Hours Average
					$data['report_type'] = 'Riders With 9+ Hours Average';
					//$data['all_compliance_data'] = $this->attendance_model->get_employees_meeting_all_conditions($month, $filters);
					$data['working_hours_9_plus'] = $this->attendance_model->get_employees_with_9_hours_plus($month, $filters);
					$data['working_hours_9_less'] = $this->attendance_model->get_employees_with_less_than_9_hours($month, $filters);
					break;

				case '3': // No Week Off
					$data['report_type'] = 'No Week off (Thursday, Friday & Saturday)';
					//$data['all_compliance_data'] = $this->attendance_model->get_employees_meeting_all_conditions($month, $filters);
					$data['no_week_off'] = $this->attendance_model->get_employees_with_no_week_off($month, $filters);
					$data['total_week_off'] = $this->attendance_model->get_employees_with_total_week_offs($month, $filters);
					break;

				case '4': // No Last Week Off
					$data['report_type'] = 'No Off in Last Week';
					//$data['all_compliance_data'] = $this->attendance_model->get_employees_meeting_all_conditions($month, $filters);
					$data['no_last_week_off'] = $this->attendance_model->get_employees_with_no_last_week_off($month, $filters);
					$data['total_last_week_off'] = $this->attendance_model->get_employees_with_total_last_week_off($month, $filters);
					break;

				case '5': // 450+ Orders
					$data['report_type'] = 'Riders With 450+ Orders';
					//$data['all_compliance_data'] = $this->attendance_model->get_employees_meeting_all_conditions($month, $filters);
					$data['orders_450_plus'] = $this->attendance_model->get_employees_450_plus($month, $filters);
					$data['total_orders_below_450'] = $this->attendance_model->get_employees_below_450($month, $filters);
					break;

				default: // All
					$data['report_type'] = 'All Attendance Data';
					$data['all_compliance_data'] = $this->attendance_model->get_employees_meeting_all_conditions($month, $filters);
					$data['compliance_summary'] = $this->attendance_model->get_employees_condition_summary($month, $filters);
					$data['present_days_26'] = $this->attendance_model->get_employees_with_26_present_days($month, $filters);
					$data['present_days_less_26'] = $this->attendance_model->get_employees_less_26_present_days($month, $filters);
					$data['no_week_off'] = $this->attendance_model->get_employees_with_no_week_off($month, $filters);
					$data['total_week_off'] = $this->attendance_model->get_employees_with_total_week_offs($month, $filters);
					$data['working_hours_9_plus'] = $this->attendance_model->get_employees_with_9_hours_plus($month, $filters);
					$data['working_hours_9_less'] = $this->attendance_model->get_employees_with_less_than_9_hours($month, $filters);
					$data['no_last_week_off'] = $this->attendance_model->get_employees_with_no_last_week_off($month, $filters);
					$data['total_last_week_off'] = $this->attendance_model->get_employees_with_total_last_week_off($month, $filters);
					$data['orders_450_plus'] = $this->attendance_model->get_employees_450_plus($month, $filters);
					$data['total_orders_below_450'] = $this->attendance_model->get_employees_below_450($month, $filters);
					break;
			}

			$data['filters'] = $filters;
		} catch (Exception $e) {
			log_message('error', 'Error fetching attendance data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}

		$data['search_month'] = $month;
		$data['admin'] = 'Amanullah Kazi';

		// ------------------------------------------------
		// 📊 COMPLIANCE SUMMARY FOR PIE CHARTS
		// ------------------------------------------------

		// ✅ Fetch summary data for full/partial/non-compliance
		$data['compliance_summary'] = $this->attendance_model->get_employees_condition_summary($month, $filters);
		$total_riders = count($data['compliance_summary'] ?? []);

		$full_compliance = 0;
		$partial_compliance = 0;
		$non_compliance = 0;

		if (!empty($data['compliance_summary'])) {
			foreach ($data['compliance_summary'] as $rider) {
				$conditions_met = 0;

				if (!empty($rider->total_present_days) && $rider->total_present_days >= 26) $conditions_met++;
				if (!empty($rider->avg_working_hours) && $rider->avg_working_hours >= 9) $conditions_met++;
				if (isset($rider->total_weekoffs) && $rider->total_weekoffs == 0) $conditions_met++;
				if (isset($rider->total_off_last_week) && $rider->total_off_last_week == 0) $conditions_met++;
				if (!empty($rider->total_deliveries_in_month) && $rider->total_deliveries_in_month >= 450) $conditions_met++;

				if ($conditions_met == 5) {
					$full_compliance++;
				} elseif ($conditions_met > 0 && $conditions_met < 5) {
					$partial_compliance++;
				} else {
					$non_compliance++;
				}
			}
		}

		// ✅ Build overall summary
		$data['chart_data'] = [
			'total_riders'       => $total_riders,
			'full_compliance'    => $full_compliance,
			'partial_compliance' => $partial_compliance,
			'non_compliance'     => $non_compliance,
		];

		// ✅ Generate new Full / Partial / Non-Compliance pie chart
		$data['chart_path'] = $this->generate_three_segment_pie_chart(
			$full_compliance,
			$partial_compliance,
			$non_compliance
		);

		// ✅ Keep existing breakdown charts (no change)
		$compliance_counts = [
			'26+ Present Days'   => count($data['present_days_26'] ?? []),
			'9+ Hrs Working'     => count($data['working_hours_9_plus'] ?? []),
			'No Week Off'        => count($data['no_week_off'] ?? []),
			'No Last Week Off'   => count($data['no_last_week_off'] ?? []),
			'450+ Orders'        => count($data['orders_450_plus'] ?? []),
		];

		$non_compliance_counts = [
			'Below 26 Days'      => count($data['present_days_less_26'] ?? []),
			'Below 9 Hrs'        => count($data['working_hours_9_less'] ?? []),
			'Has Week Off'       => count($data['total_week_off'] ?? []),
			'Has Last Week Off'  => count($data['total_last_week_off'] ?? []),
			'Below 450 Orders'   => count($data['total_orders_below_450'] ?? []),
		];

		// These two remain as they were
		$data['breakdown_chart_path'] = $this->generate_breakdown_pie_chart($compliance_counts);
		$data['non_breakdown_chart_path'] = $this->generate_non_compliance_pie_chart($non_compliance_counts);


		// Initialize PDF
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Maha Al Fala - Monthly Compliance Report');
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);

		$htmlHeader = $this->load->view('admin/hr-module/attendance/print/attendance_report_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/hr-module/attendance/print/attendance_report_header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/logistic-management/rider/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		$pdf->SetMargins(4, 65, 5, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->AddPage('L', 'A4');
		$pdf->setRTL(false);
		$pdf->SetFont('helvetica', '', 9);

		$htmlcontent = $this->load->view('admin/hr-module/attendance/print/attendance_report', $data, true);
		$pdf->writeHTML($htmlcontent, true, 0, true, 0);

		$filename = 'Monthly-Compliance-Report-' . htmlspecialchars($month) . '.pdf';
		$pdf->Output($filename, 'I');
	}

	// ===============================
	// 1️⃣ Full / Partial / Non Compliance Pie
	// ===============================
	private function generate_three_segment_pie_chart($full, $partial, $non)
	{
		$width = 480; 
		$height = 260;
		$image = imagecreate($width, $height);

		$white  = imagecolorallocate($image, 255, 255, 255);
		$green  = imagecolorallocate($image, 76, 175, 80);   // Full
		$yellow = imagecolorallocate($image, 255, 193, 7);   // Partial
		$red    = imagecolorallocate($image, 244, 67, 54);   // Non
		$black  = imagecolorallocate($image, 0, 0, 0);

		$total = $full + $partial + $non;
		if ($total == 0) $total = 1;

		// Calculate percentages and angles
		$segments = [
			['label' => 'Full Compliance', 'value' => $full, 'color' => $green],
			['label' => 'Partial Compliance', 'value' => $partial, 'color' => $yellow],
			['label' => 'Non-Compliance', 'value' => $non, 'color' => $red],
		];

		$centerX = 100;
		$centerY = 140;
		$diameter = 180;
		$start = 0;

		// Draw pie dynamically (only draw if value > 0)
		foreach ($segments as $seg) {
			if ($seg['value'] > 0) {
				$angle = ($seg['value'] / $total) * 360;
				imagefilledarc($image, $centerX, $centerY, $diameter, $diameter, $start, $start + $angle, $seg['color'], IMG_ARC_PIE);
				$start += $angle;
			}
		}

		// Add title
		imagestring($image, 5, 160, 10, "Overall Compliance Distribution", $black);

		// Draw legend
		$y = 60;
		foreach ($segments as $seg) {
			$percent = round(($seg['value'] / $total) * 100, 1);
			imagefilledrectangle($image, 210, $y, 230, $y + 20, $seg['color']);
			imagestring($image, 4, 240, $y + 5, "{$seg['label']}: {$seg['value']} ({$percent}%)", $black);
			$y += 35;
		}

		// Save image
		$path = FCPATH . 'uploads/tmp/full_partial_non_compliance_pie.png';
		imagepng($image, $path);
		imagedestroy($image);

		return $path;
	}

	private function generate_breakdown_pie_chart($compliance_counts)
	{
		$width = 480; 
		$height = 270;
		$image = imagecreate($width, $height);

		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);

		$colors = [
			imagecolorallocate($image, 76, 175, 80),
			imagecolorallocate($image, 33, 150, 243),
			imagecolorallocate($image, 255, 193, 7),
			imagecolorallocate($image, 156, 39, 176),
			imagecolorallocate($image, 255, 87, 34),
		];

		$total = array_sum($compliance_counts);
		if ($total == 0) $total = 1;

		imagestring($image, 5, 140, 10, "Compliance Breakdown", $black);

		$centerX = 110; // ✅ moved slightly left
		$centerY = 140;
		$diameter = 180;
		$start = 0;
		$i = 0;

		foreach ($compliance_counts as $label => $value) {
			if ($value > 0) {
				$angle = ($value / $total) * 360;
				imagefilledarc($image, $centerX, $centerY, $diameter, $diameter, $start, $start + $angle, $colors[$i], IMG_ARC_PIE);
				$start += $angle;
			}
			$i++;
		}

		// ✅ Bring legend closer
		$y = 60;
		$i = 0;
		foreach ($compliance_counts as $label => $value) {
			$percent = round(($value / $total) * 100, 1);
			imagefilledrectangle($image, 220, $y, 240, $y + 20, $colors[$i]);
			imagestring($image, 4, 250, $y + 5, "{$label}: {$value} ({$percent}%)", $black);
			$y += 35;
			$i++;
		}

		$path = FCPATH . 'uploads/tmp/breakdown_pie_chart.png';
		imagepng($image, $path);
		imagedestroy($image);
		return $path;
	}

	private function generate_non_compliance_pie_chart($non_compliance_counts)
	{
		$width = 500;
		$height = 270;
		$image = imagecreate($width, $height);

		// Background and text
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);

		// Palette (5 colors)
		$palette = [
			[244, 67, 54],   // Red
			[255, 152, 0],   // Orange
			[255, 235, 59],  // Yellow
			[121, 85, 72],   // Brown
			[96, 125, 139],  // Blue Grey
		];

		// Preallocate color resources and assign to labels in order
		$colors = [];
		$i = 0;
		foreach ($palette as $rgb) {
			$colors[] = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
			$i++;
		}

		// Build segments array with deterministic color mapping
		$segments = [];
		$idx = 0;
		foreach ($non_compliance_counts as $label => $value) {
			$segments[] = [
				'label' => $label,
				'value' => $value,
				// map label index to palette index (wrap if more than 5 labels)
				'color' => $colors[$idx % count($colors)],
				'palette_index' => $idx % count($colors),
			];
			$idx++;
		}

		// Calculate total
		$total = 0;
		foreach ($segments as $seg) {
			$total += $seg['value'];
		}
		if ($total <= 0) $total = 1; // avoid division by zero

		// Title
		imagestring($image, 5, 120, 10, "Non-Compliance Breakdown", $black);

		// Draw pie: only draw segments with value > 0
		$centerX = 100;
		$centerY = 140;
		$diameter = 180;
		$start = 0.0;

		$drawnAny = false;
		foreach ($segments as $seg) {
			if ($seg['value'] <= 0) {
				continue; // skip zero slices (they still keep their assigned color in legend)
			}
			$angle = ($seg['value'] / $total) * 360.0;
			// Draw the slice using the assigned color
			imagefilledarc($image, $centerX, $centerY, $diameter, $diameter, $start, $start + $angle, $seg['color'], IMG_ARC_PIE);
			$start += $angle;
			$drawnAny = true;
		}

		// Edge case: if nothing was drawn (all values were 0), draw an empty circle (light grey)
		if (!$drawnAny) {
			$bgGrey = imagecolorallocate($image, 240, 240, 240);
			imagefilledarc($image, $centerX, $centerY, $diameter, $diameter, 0, 360, $bgGrey, IMG_ARC_PIE);
		}

		// Draw legend — use the same deterministic color mapping even for zero items
		$y = 60;
		foreach ($segments as $seg) {
			$percent = round(($seg['value'] / $total) * 100, 1);
			// color box
			imagefilledrectangle($image, 230, $y, 250, $y + 20, $seg['color']);
			// label with value and percent (show 0 if zero)
			imagestring($image, 4, 260, $y + 5, "{$seg['label']}: {$seg['value']} ({$percent}%)", $black);
			$y += 35;
		}

		// Save PNG
		$path = FCPATH . 'uploads/tmp/non_compliance_pie_chart.png';
		imagepng($image, $path);
		imagedestroy($image);
		return $path;
	}

}
