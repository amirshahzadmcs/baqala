<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class Interview_controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/InterviewForm_model');
			$this->load->model('admin/masters/city_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['positions'] = allDesignation();
		$data['search'] = '';
		$data['perPage'] = 50;

		// ✅ Load user column preferences
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'interview_forms'
		])->row();

		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr-module/interview/index', $data);
	}

	/*----- Dashboard Start -----*/
	
	public function dashboard()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'local_dashboard', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		// Donut chart (status distribution)
		$donut = $this->getInterviewStatusChartData();
		// Monthly bar metrics
		$monthly = $this->getMonthlyInterviewMetrics(12);
		// Recruitment funnel data
		$funnel  = $this->getRecruitmentFunnelData();
		$application_sources = $this->getApplicationSourceMetrics();
		$decline_reasons = $this->getDeclineReasonMetrics();
		$active_pipeline = $this->getActivePipelineMetrics();
		$data = [
			'chart_labels'   => $donut['labels'],
			'chart_values'   => $donut['values'],
			'chart_total'    => $donut['total'],
			'monthly_metrics'=> $monthly,
			'funnel_data'    => $funnel,
			'application_sources' => $application_sources,
			'decline_reasons'    => $decline_reasons,
			'active_pipeline'    => $active_pipeline,
		];

		$this->load->view('admin/hr-module/interview/dashboard', $data);
	}

	private function getInterviewStatusChartData()
	{
		$result = $this->db
			->select('status, COUNT(*) as total')
			->from('interview_forms')
			->group_by('status')
			->get()
			->result_array();

		$allowedStatuses = [
			'Screening',
			'Phone Interview',
			'Onsite Interview',
			'Rejected',
			'Document Verification',
			'Hold - Need Clarification',
			'Qiwa Requested',
			'Qiwa Rejected',
			'Resend Qiwa',
			'Onboarding',
			'Hired'
		];

		$statusMap = array_fill_keys($allowedStatuses, 0);
		$totalApplicants = 0;

		foreach ($result as $row) {
			if (isset($statusMap[$row['status']])) {
				$statusMap[$row['status']] = (int) $row['total'];
				$totalApplicants += (int) $row['total'];
			}
		}

		return [
			'labels' => array_keys($statusMap),
			'values' => array_values($statusMap),
			'total'  => $totalApplicants
		];
	}

	private function getMonthlyInterviewMetrics()
	{
		// Get min & max created dates
		$range = $this->db->query("
			SELECT
				MIN(created_at) AS min_date,
				MAX(created_at) AS max_date
			FROM interview_forms
		")->row_array();

		if (empty($range['min_date']) || empty($range['max_date'])) {
			return [];
		}

		$start = new DateTime(date('Y-m-01', strtotime($range['min_date'])));
		$end   = new DateTime(date('Y-m-01', strtotime($range['max_date'])));

		// Calculate month difference
		$monthsDiff = ($end->format('Y') - $start->format('Y')) * 12
					+ ($end->format('m') - $start->format('m'));

		$limit = $monthsDiff + 1;

		$rows = $this->db->query("
			SELECT
				m.month_key,
				m.month_label,

				COUNT(DISTINCT f.id) AS total_applications,
				COUNT(DISTINCT h.id) AS hired_count

			FROM (
				SELECT
					DATE_FORMAT(DATE_ADD('{$start->format('Y-m-01')}', INTERVAL seq MONTH), '%Y-%m') AS month_key,
					DATE_FORMAT(DATE_ADD('{$start->format('Y-m-01')}', INTERVAL seq MONTH), '%b %Y') AS month_label
				FROM (
					SELECT @row := @row + 1 AS seq
					FROM information_schema.COLUMNS, (SELECT @row := -1) r
					LIMIT {$limit}
				) t
			) m

			LEFT JOIN interview_forms f
				ON DATE_FORMAT(f.created_at, '%Y-%m') = m.month_key

			LEFT JOIN interview_forms h
				ON h.status = 'Hired'
				AND DATE_FORMAT(h.hired_date, '%Y-%m') = m.month_key

			GROUP BY m.month_key
			ORDER BY m.month_key DESC
		")->result_array();

		if (empty($rows)) {
			return [];
		}

		// Normalize bar widths
		$maxHired = max(array_column($rows, 'hired_count')) ?: 1;
		$maxTotal = max(array_column($rows, 'total_applications')) ?: 1;

		foreach ($rows as &$row) {
			$row['hired_width'] = round(($row['hired_count'] / $maxHired) * 100);
			$row['total_width'] = round(($row['total_applications'] / $maxTotal) * 100);
		}

		return $rows;
	}

	/**
	 * Prepare recruitment funnel data (percentage by status)
	 *
	 * @return array
	 */
	private function getRecruitmentFunnelData()
	{
		// Get total applications
		$total = $this->db->count_all('interview_forms');

		if ($total == 0) {
			return [];
		}

		// Get status-wise count
		$rows = $this->db
			->select('status, COUNT(*) as total')
			->from('interview_forms')
			->group_by('status')
			->get()
			->result_array();

		$funnel = [];

		foreach ($rows as $row) {
			$percentage = round(($row['total'] / $total) * 100);

			$funnel[] = [
				'status'     => $row['status'],
				'count'      => (int) $row['total'],
				'percentage' => $percentage,
				'width'      => max($percentage, 5) // minimum visible width
			];
		}

		// Order by highest percentage first
		usort($funnel, function ($a, $b) {
			return $b['percentage'] <=> $a['percentage'];
		});

		return $funnel;
	}

	private function getApplicationSourceMetrics()
	{
		$rows = $this->db->query("
			SELECT
				e.emp_no,
				e.full_name,

				COUNT(f.id) AS total_applications,
				SUM(CASE WHEN f.status = 'Hired' THEN 1 ELSE 0 END) AS hired_count

			FROM interview_forms f
			LEFT JOIN master_employee e
				ON e.id = f.added_by

			GROUP BY f.added_by
			ORDER BY hired_count DESC
		")->result_array();

		if (empty($rows)) {
			return [];
		}

		$totalHired = array_sum(array_column($rows, 'hired_count')) ?: 1;
		$maxConvRate = 0;

		foreach ($rows as &$row) {
			$row['hire_percentage'] = round(($row['hired_count'] / $totalHired) * 100);

			$row['conversion_rate'] = $row['total_applications'] > 0
				? round(($row['hired_count'] / $row['total_applications']) * 100)
				: 0;

			$maxConvRate = max($maxConvRate, $row['conversion_rate']);
		}

		// Normalize bar width
		foreach ($rows as &$row) {
			$row['conv_width'] = $maxConvRate
				? max(5, round(($row['conversion_rate'] / $maxConvRate) * 100))
				: 5;
		}

		return $rows;
	}

	private function getDeclineReasonMetrics($topLimit = 8)
	{
		$rows = $this->db->query("
			SELECT
				remarks AS reason,
				COUNT(*) AS total_count
			FROM interview_forms
			WHERE status IN ('Rejected', 'Qiwa Rejected')
			AND remarks IS NOT NULL
			AND remarks != ''
			GROUP BY remarks
			ORDER BY total_count DESC
		")->result_array();

		if (empty($rows)) {
			return [
				'rows' => [],
				'others' => ['count' => 0, 'percentage' => 0]
			];
		}

		$totalRejected = array_sum(array_column($rows, 'total_count')) ?: 1;
		$topRows = array_slice($rows, 0, $topLimit);
		$otherRows = array_slice($rows, $topLimit);

		$maxCount = max(array_column($topRows, 'total_count')) ?: 1;
		$othersCount = array_sum(array_column($otherRows, 'total_count'));

		foreach ($topRows as &$row) {
			$row['percentage'] = round(($row['total_count'] / $totalRejected) * 100);
			$row['bar_width'] = max(5, round(($row['total_count'] / $maxCount) * 100));
		}

		return [
			'rows' => $topRows,
			'others' => [
				'count' => $othersCount,
				'percentage' => round(($othersCount / $totalRejected) * 100)
			]
		];
	}

	private function getActivePipelineMetrics()
	{
		$activeStatuses = [
			'Screening',
			'Phone Interview',
			'Onsite Interview',
			'Qiwa Requested',
			'Onboarding'
		];

		$rows = $this->db
			->select('status, COUNT(*) AS total_count')
			->from('interview_forms')
			->where_in('status', $activeStatuses)
			->group_by('status')
			->order_by('total_count', 'DESC') // ✅ HIGH → LOW
			->having('total_count >', 0)
			->get()
			->result_array();

		if (empty($rows)) {
			return [];
		}

		$total = array_sum(array_column($rows, 'total_count')) ?: 1;

		foreach ($rows as &$row) {

			// SQRT scaling for visual balance
			$scaled      = sqrt($row['total_count']);
			$scaledTotal = sqrt($total);

			$percentage = round(($scaled / $scaledTotal) * 100);

			// visual safeguards
			$percentage = max(10, $percentage);
			$percentage = min(85, $percentage);

			$row['percentage'] = $percentage;
		}

		return $rows;
	}

	/*----- Dashboard End -----*/

	public function get_interview_list()
	{
		$search       = $this->input->post('search') ?? $this->input->post('keyword') ?? '';
		$perPage      = $this->input->post('length') ?? 50;
		$start        = $this->input->post('start') ?? 0;

		$date_from    = $this->input->post('date_from') ?? null;
		$date_to      = $this->input->post('date_to') ?? null;
		$applied_for  = $this->input->post('applied_for') ?? null;
		$status       = $this->input->post('status') ?? null;
		$nationality   = $this->input->post('nationality') ?? null;
		$preferred_city   = $this->input->post('preferred_city') ?? null;
		$iqama_profession   = $this->input->post('iqama_profession') ?? null;
		$no_of_transfer   = $this->input->post('no_of_transfer') ?? null;
		$has_driving_license   = $this->input->post('has_driving_license') ?? null;
		$driving_license_type   = $this->input->post('driving_license_type') ?? null;
		$driving_license_expiry_from   = $this->input->post('driving_license_expiry_from') ?? null;
		$driving_license_expiry_to   = $this->input->post('driving_license_expiry_to') ?? null;
		$arrival_date_from   = $this->input->post('arrival_date_from') ?? null;
		$arrival_date_to   = $this->input->post('arrival_date_to') ?? null;

		// Fetch data from newly updated model (like reference)
		$fetch_data = $this->InterviewForm_model->list(
			$search,
			$perPage,
			$start,
			$applied_for,
			$date_from,
			$date_to,
			$status,
			$nationality,
			$preferred_city,
			$iqama_profession,
			$no_of_transfer,
			$has_driving_license,
			$driving_license_type,
			$driving_license_expiry_from,
			$driving_license_expiry_to,
			$arrival_date_from,
			$arrival_date_to
		);

		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $item) {

			$sub_array = [];

			// Checkbox
			$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . ($item['id'] ?? '') . '" />';

			// S.No.
			$sub_array[] = $i++;

			// Loop visible columns like reference controller
			foreach ($fetch_data['visible_columns'] as $column) {

				// skip id
				if ($column == 'id') continue;

				$value = $item[$column] ?? '';

				// Applicant Name formatting
				if ($column == 'applicant_name') {
					$sub_array[] = '<div class="text-start">' . htmlspecialchars($value) . '</div>';
					continue;
				}

				// Date formatting
				if (in_array($column, ['interview_date', 'date_of_birth', 'iqama_expiry', 'arrival_date', 'hired_date', 'created_at', 'updated_at'])) {
					if (!empty($value) && $value !== '0000-00-00') {
						$sub_array[] = date('d-m-Y', strtotime($value));
					} else {
						$sub_array[] = 'NA';
					}
					continue;
				}

				// IQAMA Status Badge
				if ($column == 'iqama_status') {

					$expiry_date = $item['iqama_expiry'] ?? null;

					if (!empty($expiry_date) && $expiry_date !== '0000-00-00') {
						$expiry = new DateTime($expiry_date);
						$today  = new DateTime();

						$iqamaStatus = $expiry < $today
							? '<span class="badge badge-pill badge-soft-danger font-size-13">Expired</span>'
							: '<span class="badge badge-pill badge-soft-success font-size-13">Valid</span>';
					} else {
						$iqamaStatus = '<span class="badge badge-pill badge-soft-secondary font-size-13">NA</span>';
					}

					$sub_array[] = $iqamaStatus;
					continue;
				}

				$statusBadges = [
					'Screening'     => 'badge-soft-warning',   // Yellow
					'Phone Interview'  => 'badge-soft-info',      // Blue
					'Onsite Interview'  => 'bg-info',      // Blue
					'Qiwa Requested'     => 'badge-soft-primary',   // Dark Blue
					'Qiwa Rejected'     => 'badge-soft-danger',   // Red
					'Resend Qiwa'  => 'badge-soft-secondary', // Grey
					'Onboarding'    => 'badge-soft-success',   // Green
					'Rejected'    => 'bg-danger',   // Red
					'Document Verification'    => 'badge-soft-info',   // Blue
					'Hold - Need Clarification'    => 'badge-soft-warning',   // Yellow
					'Hired'    => 'bg-success',   // Dark Green
				];

				// Status Badge
				if ($column == 'status') {

					$status = trim($value);

					if (isset($statusBadges[$status])) {
						$sub_array[] = '<span class="badge badge-pill ' . $statusBadges[$status] . ' font-size-13">'
							. ucwords($status) .
							'</span>';
					} else {
						$sub_array[] = '<span class="badge badge-pill badge-soft-secondary font-size-13">'
							. htmlspecialchars($value) .
							'</span>';
					}

					continue;
				}
				// Default safe output
				$sub_array[] = htmlspecialchars($value);
			}

			// Action Buttons
			$actionDropdown = '';
			// Action buttons dropdown
			$actionDropdown = '<div class="btn-group ms-2 float-end">
            <button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                <i class="dripicons-dots-3"></i></button>
            <div class="dropdown-menu dropdown-menu-end">';

			if (check_action_permission(get_user_role(), 'manage_interview', 'editInterviewForm') && ($item['status'] != 'Hired')) {
				$actionDropdown .= '<a type="button" class="dropdown-item" onclick="editInterviewPopup(' . $item['id'] . ')"><i class="mdi mdi-pencil me-2"></i> Edit</a>';
			}

			if (check_action_permission(get_user_role(), 'manage_interview', 'interviewDetail')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0);" onclick="detailInterviewPopup(' . $item['id'] . ')"><i class="mdi mdi-stretch-to-page-outline me-2"></i> Detail</a>';
			}

			if (check_action_permission(get_user_role(), 'manage_interview', 'status_form') && ($item['status'] != 'Hired')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a type="button" class="dropdown-item" onclick="changeStatusPopup(' . $item['id'] . ')"><i class="mdi mdi-circle-edit-outline me-2"></i> Update Status</a>';
			}
			
			if (check_action_permission(get_user_role(), 'manage_interview', 'download_txt')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/recruitment/interview/download-txt/' . $item['id']) . '" target="_blank"><i class="mdi mdi-file-document-outline me-2"></i> Download As TXT</a>';
			}

			if (check_action_permission(get_user_role(), 'manage_interview', 'print_job_application_form')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/recruitment/interview/print-job-application-form/' . $item['id']) . '" target="_blank"><i class="mdi mdi-printer me-2"></i> Print Form</a>';
			}
			/*
			if (check_action_permission(get_user_role(), 'manage_interview', 'print_cash_advance_letter')) {
				$actionDropdown .= '<div class="dropdown-divider"></div><a class="dropdown-item" href="' . base_url('admin/hr/recruitment/interview/print-cash-advance-letter/' . $item['id']) . '" target="_blank"><i class="mdi mdi-printer me-2"></i> Print Cash Advance Letter</a>';
			}
			*/
			$actionDropdown .= '</div></div>';
			$sub_array[] = $actionDropdown;

			$data[] = $sub_array;
		}

		// Final output like reference
		$output = [
			"draw"              => intval($this->input->post("draw")),
			"recordsTotal"      => $fetch_data['pagination']['total'],
			"recordsFiltered"   => $fetch_data['pagination']['total'],
			"data"              => $data,
			"search"            => $search,
			"perPage"           => $perPage,
			"current_page"      => $fetch_data['pagination']['current_page'],
		];

		echo json_encode($output);
	}

	public function status_form()
	{
		if($this->action && !check_action_permission(get_user_role(),'manage_interview', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			$result = array("type"=>'error', "message"=>$msg);
		}
		else{
			$id = $this->input->post('id');
			$data['interview_detail'] = $this->InterviewForm_model->get_detail($id);

			if (empty($data['interview_detail'])) {
				$result = array("type"=>'error', "message"=>'Interview record not found!');
				echo json_encode($result);
				return;
			}
			
			if ($data['interview_detail']->status == 'Transfer Completed') {
				$result = array("type"=>'error', "message"=>"Cannot update status after Transfer Completed!!");
				echo json_encode($result);
				return;
			}
			$output_data = $this->load->view('admin/hr-module/interview/components/update-status',$data,TRUE);
			$result = array("type"=>'success', "message"=>'Interview detail successfully fetched.', "output_html"=> $output_data);
		}
		echo json_encode($result);
	}

	public function update_status()
	{
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('status', 'Interview Status', 'trim|required');

		$id               = $this->input->post('id');
		$status           = $this->input->post('status');
		$remarks          = $this->input->post('remarks');
		$hired_date       = $this->input->post('hired_date');
		$qiwa_request_date = $this->input->post('qiwa_request_date');

		/*
		|----------------------------------------------------------------------
		| Conditional Validation
		|----------------------------------------------------------------------
		*/
		if (in_array($status, ['Rejected', 'Qiwa Rejected', 'Resend Qiwa'])) {
			$this->form_validation->set_rules('remarks', 'Remarks', 'trim|required');
		}

		if ($status === 'Hired') {
			$this->form_validation->set_rules('hired_date', 'Hired Date', 'trim|required');
		}

		if ($status === 'Qiwa Requested') {
			$this->form_validation->set_rules('qiwa_request_date', 'Qiwa Requested Date', 'trim|required');
		}

		// Run validation FIRST
		if ($this->form_validation->run() === FALSE) {
			echo json_encode([
				'type'    => 'error',
				'message' => validation_errors()
			]);
			return;
		}

		/*
		|----------------------------------------------------------------------
		| Fetch Interview Record
		|----------------------------------------------------------------------
		*/
		$interview_detail = $this->InterviewForm_model->get_detail($id);
		if (!$interview_detail) {
			echo json_encode([
				'type'    => 'error',
				'message' => 'Interview record not found!'
			]);
			return;
		}

		if ($interview_detail->status === 'Hired') {
			echo json_encode([
				'type'    => 'error',
				'message' => 'Cannot update status after Hired!'
			]);
			return;
		}

		/*
		|----------------------------------------------------------------------
		| Hired Document Validation & Upload
		|----------------------------------------------------------------------
		*/
		$hired_doc_path = null;

		if ($status === 'Hired') {

			if (empty($_FILES['hired_doc']['name'])) {
				echo json_encode([
					'type'    => 'error',
					'message' => 'Hired document is required.'
				]);
				return;
			}

			$config['upload_path']   = './uploads/interviews/';
			$config['allowed_types'] = 'pdf|doc|docx|xls|xlsx|png|jpg|jpeg';
			$config['max_size']      = 5120;
			$config['encrypt_name']  = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('hired_doc')) {
				echo json_encode([
					'type'    => 'error',
					'message' => $this->upload->display_errors('', '')
				]);
				return;
			}

			$upload_data    = $this->upload->data();
			$hired_doc_path = 'uploads/interviews/' . $upload_data['file_name'];
		}

		/*
		|----------------------------------------------------------------------
		| Prepare Update Data
		|----------------------------------------------------------------------
		*/
		$update_data = [
			'status'     => $status,
			'remarks'    => in_array($status, ['Rejected', 'Qiwa Rejected', 'Resend Qiwa']) ? $remarks : null,
			'updated_at' => date('Y-m-d H:i:s'),
			'hired_date' => null,
			'qiwa_request_date' => null
		];

		if ($status === 'Hired') {
			$update_data['hired_date'] = $hired_date;
			$update_data['hired_doc']  = $hired_doc_path;
		}

		if ($status === 'Qiwa Requested') {
			$update_data['qiwa_request_date'] = $qiwa_request_date;
		}

		/*
		|----------------------------------------------------------------------
		| Update
		|----------------------------------------------------------------------
		*/
		$this->db->where('id', $id)->update('interview_forms', $update_data);

		echo json_encode([
			'type'    => 'success',
			'message' => 'Interview status updated successfully.'
		]);
	}

	public function addInterviewForm()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$data['positions'] = allDesignation();
		$data['cities'] = $this->city_model->get_cities()->result();
		$data['interview_id'] = $this->db->query("SELECT id FROM interview_forms ORDER BY id desc limit 1")->row();
		$output_data = $this->load->view('admin/hr-module/interview/components/add-form', $data, TRUE);
		echo $output_data;
	}

	public function editInterviewForm()
	{
		// Permission Check
		if ($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)) {
			echo "<div class='alert alert-danger'>Unauthorized access!</div>";
			return; // IMPORTANT
		}

		$id = $this->input->get('id');

		if (!$id) {
			echo "<div class='alert alert-danger'>Invalid request ID!</div>";
			return;
		}

		// Fetch record
		$data['interview_detail'] = $this->InterviewForm_model->get_detail($id);

		if (empty($data['interview_detail'])) {
			echo "<div class='alert alert-danger'>Interview record not found!</div>";
			return;
		}
		
		if ($data['interview_detail']->status == 'Transfer Completed') {
			echo "<div class='alert alert-danger'>Cannot update detail after Transfer Completed!!</div>";
			return;
		}

		// Load required dropdown data
		$data['positions'] = allDesignation();
		$data['cities'] = $this->city_model->get_cities()->result();

		// Return HTML to AJAX
		$html = $this->load->view(
			'admin/hr-module/interview/components/edit-form',
			$data,
			TRUE
		);

		echo $html;
	}

	public function save()
	{
		$this->form_validation->set_rules('interview_no', 'Interview Number', 'trim|required|is_unique[interview_forms.interview_no]');
		$this->form_validation->set_rules('interview_date', 'Interview Date', 'trim|required');
		$this->form_validation->set_rules('position_applied', 'Position Applied', 'trim|required');
		$this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('preferred_city', 'Preferred City', 'trim|required');
		$this->form_validation->set_rules('iban_number', 'IBAN Number', 'trim|required');
		$this->form_validation->set_rules(
			'iqama_number',
			'Iqama Number',
			'trim|required|is_unique[interview_forms.iqama_number]'
		);
		$this->form_validation->set_rules('iqama_expiry', 'Iqama Expiry', 'trim|required');
		$this->form_validation->set_rules('iqama_profession', 'Iqama Profession', 'trim|required');
		$this->form_validation->set_rules('huroob_status', 'Huroob Status', 'trim|required');
		$this->form_validation->set_rules('has_driving_license', 'Driving License', 'trim|required');
		$this->form_validation->set_message(
			'is_unique',
			'This {field} already exists.'
		);


		if ($this->form_validation->run() == FALSE) {
			echo json_encode([
				"status" => "error",
				"msg" => validation_errors()
			]);
			return;  // STOP EXECUTION
		}

		// -------------------------------
		// Auto Iqama Calculations
		// -------------------------------
		$iqama_expiry = $this->input->post('iqama_expiry');
		$today = date('Y-m-d');

		$iqama_status = ($iqama_expiry >= $today) ? "Valid" : "Expired";
		$iqama_days = (strtotime($iqama_expiry) - strtotime($today)) / 86400;

		// BLOCK SAVE IF EXPIRED > 90 DAYS
		if ($iqama_days < -90) {
			echo json_encode([
				"status" => "error",
				"msg" => "Iqama is expired for more than 90 days. Interview cannot be saved."
			]);
			return;
		}

		// -------------------------------
		// File Uploads
		// -------------------------------
		$iqama_copy = $this->upload_file('iqama_copy');
		$dl_copy = $this->upload_file('driving_license_copy');
		$iban_copy = $this->upload_file('iban_certificate');

		// -------------------------------
		// If DL = NO, remove DL fields
		// -------------------------------
		$has_dl = $this->input->post('has_driving_license');

		$driving_license_number = ($has_dl == "yes") ? $this->input->post('driving_license_number') : null;
		$driving_license_type = ($has_dl == "yes") ? $this->input->post('driving_license_type') : null;
		$driving_license_expiry = ($has_dl == "yes") ? $this->input->post('driving_license_expiry') : null;
		$arrival_date = ($has_dl == "home_land") ? $this->input->post('arrival_date') : null;

		// -------------------------------
		// Prepare Data
		// -------------------------------
		$data = [
			"interview_no" => $this->input->post('interview_no'),

			"interview_date" => $this->input->post('interview_date'),
			"position_applied" => $this->input->post('position_applied'),

			"applicant_name" => $this->input->post('applicant_name'),
			"date_of_birth" => $this->input->post('date_of_birth'),
			"mobile_number" => $this->input->post('mobile_number'),
			"email" => $this->input->post('email'),
			"nationality" => $this->input->post('nationality'),
			"preferred_city" => $this->input->post('preferred_city'),
			"iban_number" => $this->input->post('iban_number'),

			"iqama_number" => $this->input->post('iqama_number'),
			"iqama_expiry" => $iqama_expiry,
			"huroob_status" => $this->input->post('huroob_status'),
			"iqama_profession" => $this->input->post('iqama_profession'),
			"no_of_transfer" => $this->input->post('no_of_transfer'),

			"has_driving_license" => $has_dl,
			"driving_license_number" => $driving_license_number,
			"driving_license_type" => $driving_license_type,
			"driving_license_expiry" => $driving_license_expiry,
			"arrival_date" => $arrival_date,

			"has_hunger_station" => $this->input->post('has_hunger_station') ? 1 : 0,
			"has_jahez" => $this->input->post('has_jahez') ? 1 : 0,
			"has_keeta" => $this->input->post('has_keeta') ? 1 : 0,
			"has_noon" => $this->input->post('has_noon') ? 1 : 0,
			"has_toyou" => $this->input->post('has_toyou') ? 1 : 0,
			"has_marsool" => $this->input->post('has_marsool') ? 1 : 0,
			"has_chefz" => $this->input->post('has_chefz') ? 1 : 0,

			"long_term_relation" => $this->input->post('long_term_relation'),
			"transfer_sponsorship" => $this->input->post('transfer_sponsorship'),
			"recommendation" => $this->input->post('recommendation'),
			"remarks" => $this->input->post('remarks'),

			"iqama_copy" => $iqama_copy,
			"driving_license_copy" => $dl_copy,
			"iban_certificate" => $iban_copy,
			"added_by" => $this->admin->getLoginEmpId(),
		];

		// -------------------------------
		// SAVE
		// -------------------------------
		$id = $this->InterviewForm_model->save($data);

		echo json_encode([
			"status" => "success",
			"msg" => "Interview saved successfully!",
			"id" => $id
		]);
	}

    private function upload_file($field)
    {
        if (!empty($_FILES[$field]['name'])) {

            $config['upload_path'] = './uploads/interviews/';
            $config['allowed_types'] = 'jpg|png|jpeg|pdf';
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload($field)) {
                return 'uploads/interviews/' . $this->upload->data('file_name');
            }
        }

        return null;
    }

	public function update_interview()
	{
		$id = $this->input->post('id');

		if (empty($id)) {
			echo json_encode([
				"status" => "error",
				"msg" => "<p>Invalid interview ID!</p>"
			]);
			return;
		}

		// -------------------------------
		// Validation Rules
		// -------------------------------
		$this->form_validation->set_rules('interview_date', 'Interview Date', 'trim|required');
		$this->form_validation->set_rules('position_applied', 'Position Applied', 'trim|required');
		$this->form_validation->set_rules('applicant_name', 'Applicant Name', 'trim|required');
		$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('preferred_city', 'Preferred City', 'trim|required');
		$this->form_validation->set_rules('iban_number', 'IBAN Number', 'trim|required');
		$this->form_validation->set_rules('iqama_number', 'Iqama Number', 'trim|required');
		$this->form_validation->set_rules('iqama_expiry', 'Iqama Expiry', 'trim|required');
		$this->form_validation->set_rules('iqama_profession', 'Iqama Profession', 'trim|required');
		$this->form_validation->set_rules('huroob_status', 'Huroob Status', 'trim|required');
		$this->form_validation->set_rules('has_driving_license', 'Driving License', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode([
				"status" => "error",
				"msg" => validation_errors()
			]);
			return; 
		}

		// -------------------------------
		// Auto Iqama Status
		// -------------------------------
		$iqama_expiry = $this->input->post('iqama_expiry');
		$today = date('Y-m-d');

		$iqama_status = ($iqama_expiry >= $today) ? "Valid" : "Expired";

		// -------------------------------
		// File Uploads (Keep old if new not uploaded)
		// -------------------------------
		$existing = $this->InterviewForm_model->get_detail($id);
		
		if ($existing->status == 'Transfer Completed') {
			echo json_encode([
				"status" => "error",
				"msg" => "Cannot update detail after Transfer Completed!!"
			]);
			return;
		}

		$iqama_copy = $this->upload_file('iqama_copy') ?: $existing->iqama_copy;
		$dl_copy    = $this->upload_file('driving_license_copy') ?: $existing->driving_license_copy;
		$iban_copy  = $this->upload_file('iban_certificate') ?: $existing->iban_certificate;

		// -------------------------------
		// Driving License Conditions
		// -------------------------------
		$has_dl = $this->input->post('has_driving_license');

		$driving_license_number  = ($has_dl == "yes") ? $this->input->post('driving_license_number') : null;
		$driving_license_type    = ($has_dl == "yes") ? $this->input->post('driving_license_type') : null;
		$driving_license_expiry  = ($has_dl == "yes") ? $this->input->post('driving_license_expiry') : null;
		$arrival_date = ($has_dl == "home_land") ? $this->input->post('arrival_date') : null;

		// -------------------------------
		// Data Array
		// -------------------------------
		$data = [
			"interview_date"       => $this->input->post('interview_date'),
			"position_applied"     => $this->input->post('position_applied'),

			"applicant_name"       => $this->input->post('applicant_name'),
			"date_of_birth"        => $this->input->post('date_of_birth'),
			"mobile_number"        => $this->input->post('mobile_number'),
			"email"                => $this->input->post('email'),
			"preferred_city"       => $this->input->post('preferred_city'),
			"iban_number" 		   => $this->input->post('iban_number'),

			"iqama_number"         => $this->input->post('iqama_number'),
			"iqama_expiry"         => $iqama_expiry,
			"huroob_status"        => $this->input->post('huroob_status'),
			"iqama_profession" 	   => $this->input->post('iqama_profession'),
			"no_of_transfer" 	   => $this->input->post('no_of_transfer'),

			"has_driving_license"  => $has_dl,
			"driving_license_number" => $driving_license_number,
			"driving_license_type" => $driving_license_type,
			"driving_license_expiry" => $driving_license_expiry,
			"arrival_date"         => $arrival_date,

			"has_hunger_station" => $this->input->post('has_hunger_station') ? 1 : 0,
			"has_jahez"          => $this->input->post('has_jahez') ? 1 : 0,
			"has_keeta"          => $this->input->post('has_keeta') ? 1 : 0,
			"has_noon"           => $this->input->post('has_noon') ? 1 : 0,
			"has_toyou"          => $this->input->post('has_toyou') ? 1 : 0,
			"has_marsool"        => $this->input->post('has_marsool') ? 1 : 0,
			"has_chefz"          => $this->input->post('has_chefz') ? 1 : 0,

			"long_term_relation"   => $this->input->post('long_term_relation'),
			"transfer_sponsorship" => $this->input->post('transfer_sponsorship'),
			"recommendation"       => $this->input->post('recommendation'),
			"remarks"              => $this->input->post('remarks'),

			"iqama_copy"           => $iqama_copy,
			"driving_license_copy" => $dl_copy,
			"iban_certificate"     => $iban_copy,
			"updated_by" 		   => $this->admin->getLoginEmpId(),
		];

		// -------------------------------
		// Update Record
		// -------------------------------
		$updated = $this->InterviewForm_model->update($id, $data);

		echo json_encode([
			"status" => "success",
			"msg" => "Interview updated successfully!",
			"id" => $id
		]);
	}

	public function interviewDetail()
	{
		// Permission Check
		if ($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)) {
			echo "<div class='alert alert-danger'>Unauthorized access!</div>";
			return; // IMPORTANT
		}

		$id = $this->input->get('id');

		if (!$id) {
			echo "<div class='alert alert-danger'>Invalid request ID!</div>";
			return;
		}

		// Fetch record
		$data['interview_detail'] = $this->InterviewForm_model->get_detail($id);

		if (empty($data['interview_detail'])) {
			echo "<div class='alert alert-danger'>Interview record not found!</div>";
			return;
		}

		// Load required dropdown data
		$data['positions'] = allDesignation();
		$data['cities'] = $this->city_model->get_cities()->result();

		// Return HTML to AJAX
		$html = $this->load->view(
			'admin/hr-module/interview/components/detail',
			$data,
			TRUE
		);

		echo $html;
	}

	public function delete_interview()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->InterviewForm_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/interview');
	}
	
	public function delete_document()
    {
        $id = $this->input->post('id');
        $field = $this->input->post('field');

        // Safety Check
        $allowedFields = ['iqama_copy', 'driving_license_copy', 'iban_certificate'];

        if (!in_array($field, $allowedFields)) {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid document type']);
            return;
        }

        // Get record
        $detail = $this->InterviewForm_model->get_detail($id);
        if (!$detail) {
            echo json_encode(['status' => 'error', 'msg' => 'Record not found']);
            return;
        }

        $filePath = $detail->$field;

        if (!empty($filePath) && file_exists(FCPATH . $filePath)) {
            unlink(FCPATH . $filePath); // delete file
        }

        // Update DB field to empty
        $this->InterviewForm_model->update($id, [ $field => NULL ]);

        echo json_encode([
            'status' => 'success',
            'msg' => ucfirst(str_replace('_', ' ', $field)) . " deleted successfully"
        ]);
    }
	
	public function print_job_application_form($id){
		if($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$interview_detail = $this->InterviewForm_model->get_detail($id);
		$data['print_date'] = date('l, d F, Y', strtotime($interview_detail->interview_date));
		$data['signature_date'] = date('jS F Y');
		$data['issue_date'] = date('jS M Y', strtotime($interview_detail->interview_date));
		$class_name = 'Pdf_general_margin';
		$this->load->library($class_name);
	    
		//print_r($data['cv_detail']);exit();
		if(!empty($interview_detail)){
			// create new PDF document
			$pdf = new $class_name(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Job Application Form');
			$pdf->SetSubject('BS - Job Application Form');
			$pdf->SetKeywords('Baqala Station, PDF, Job Application Form, Employee');
			
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
			// Conditional top margin setting
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
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('dejavusans', '', 9);
			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/interview/print/job_application_form',compact('interview_detail', 'data'),TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

			if($interview_detail->position_applied == '3'){
				$pdf->AddPage();
				$html = $this->load->view('admin/hr-module/interview/print/bike_offer_letter',compact('interview_detail', 'data'),TRUE);
				$pdf->WriteHTML($html, true, 0, true, 0);
			}

			if($interview_detail->position_applied == '18'){
				$pdf->AddPage();
				$html = $this->load->view('admin/hr-module/interview/print/car_offer_letter',compact('interview_detail', 'data'),TRUE);
				$pdf->WriteHTML($html, true, 0, true, 0);
			}
			
			if($interview_detail->iqama_profession == '15'){
				$pdf->AddPage();
				$html = $this->load->view('admin/hr-module/interview/print/cash_advance_profession_letter',compact('interview_detail', 'data'),TRUE);
				$pdf->WriteHTML($html, true, 0, true, 0);
			}

			if((!empty($interview_detail->no_of_transfer) && ($interview_detail->no_of_transfer == '2nd - 4000' || $interview_detail->no_of_transfer == '3rd - 6000'))){
				$pdf->AddPage();
				$html = $this->load->view('admin/hr-module/interview/print/cash_advance_transfer_letter',compact('interview_detail', 'data'),TRUE);
				$pdf->WriteHTML($html, true, 0, true, 0);
			}

			$pdf->AddPage();
			$html = $this->load->view('admin/hr-module/interview/print/cash_advance_ltv_licence_letter',compact('interview_detail', 'data'),TRUE);
			$pdf->WriteHTML($html, true, 0, true, 0);

			$pdf->AddPage();
			$html = $this->load->view('admin/hr-module/interview/print/hunger_compliance',compact('interview_detail', 'data'),TRUE);
			$pdf->WriteHTML($html, true, 0, true, 0);
			// -----------------------------------------------------
			// SECOND PART – ATTACHMENTS (1 DOC = 1 PAGE)
			// -----------------------------------------------------
			$basePath = FCPATH;

			$iqama = (!empty($interview_detail->iqama_copy) && file_exists($basePath.$interview_detail->iqama_copy))
						? $basePath.$interview_detail->iqama_copy : null;

			$dl = (!empty($interview_detail->driving_license_copy) && file_exists($basePath.$interview_detail->driving_license_copy))
						? $basePath.$interview_detail->driving_license_copy : null;

			$iban = (!empty($interview_detail->iban_certificate) && file_exists($basePath.$interview_detail->iban_certificate))
						? $basePath.$interview_detail->iban_certificate : null;


			// ----- IQAMA PAGE -----
			if ($iqama) {
				$this->addDocumentPage($pdf, 'Iqama Copy', $iqama);
			}

			// ----- DRIVING LICENSE PAGE -----
			if ($dl) {
				$this->addDocumentPage($pdf, 'Driving License Copy', $dl);
			}

			// ----- IBAN CERTIFICATE PAGE -----
			if ($iban) {
				$this->addDocumentPage($pdf, 'IBAN Certificate', $iban);
			}

			//Close and output PDF document
			$pdf->Output($interview_detail->applicant_name.'_'. $interview_detail->interview_no .'.pdf', 'I');
		}else{
			$this->session->set_userdata('info', "2--Interview detail not found!");
			redirect('admin/hr/recruitment/interview');
		}
	}
	
	public function print_cash_advance_letter($id){
		if($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$interview_detail = $this->InterviewForm_model->get_detail($id);
		$data['print_date'] = date('l, d F, Y');
		$data['signature_date'] = date('jS F Y');
		$data['issue_date'] = date('jS M Y', strtotime($interview_detail->interview_date));
		$class_name = 'Pdf_general_margin';
		$this->load->library($class_name);
	    
		//print_r($data['cv_detail']);exit();
		if(!empty($interview_detail)){
			if(empty($interview_detail->no_of_transfer)){
				$this->session->set_userdata('info', "2--There is no transfer option available!");
				redirect('admin/hr/recruitment/interview');
			}
			// create new PDF document
			$pdf = new $class_name(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Personal Loan as Cash Advance');
			$pdf->SetSubject('BS - Personal Loan as Cash Advance');
			$pdf->SetKeywords('Baqala Station, PDF, Personal Loan as Cash Advance, Employee');
			
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
			// Conditional top margin setting
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
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('dejavusans', '', 9);
			// Arabic and English content
			$htmlcontent = $this->load->view('admin/hr-module/interview/print/cash_advance_letter',compact('interview_detail', 'data'),TRUE);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Personal_Loan_'.$interview_detail->applicant_name.'_'. $interview_detail->interview_no .'.pdf', 'I');
		}else{
			$this->session->set_userdata('info', "2--Interview detail not found!");
			redirect('admin/hr/recruitment/interview');
		}
	}

	function addDocumentPage($pdf, $title, $file)
	{
		$pdf->AddPage();
		$pdf->SetFont('dejavusans', 'B', 14);
		$pdf->Cell(0, 10, $title, 0, 1, 'C');
		$pdf->Ln(3);

		$x = 10;
		$y = 25;
		$maxW = 190;
		$maxH = 250;

		$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

		// ==========================================
		// PDF FILE
		// ==========================================
		if ($ext === 'pdf') {
			try {
				$imagick = new Imagick();
				$imagick->setResolution(150, 150);       // adjust quality
				$imagick->readImage($file."[0]");        // first page
				$imagick->setImageFormat("jpg");

				// Important: Set white background for transparency
				$imagick->setImageBackgroundColor('white');
				$imagick = $imagick->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

				// Save temporary image
				$tmpImg = FCPATH . 'uploads/tmp_' . uniqid() . '.jpg';
				$imagick->writeImage($tmpImg);

				$imagick->clear();
				$imagick->destroy();

				// Get size & resize
				list($w, $h) = getimagesize($tmpImg);
				$ratio = min(190 / $w, 250 / $h);
				$newW = $w * $ratio;
				$newH = $h * $ratio;

				$pdf->Image($tmpImg, 10, 25, $newW, $newH);

				unlink($tmpImg); // delete temp
			} catch (Exception $e) {
				$pdf->SetFont('dejavusans', '', 12);
				$pdf->SetTextColor(255, 0, 0);
				$pdf->MultiCell(0, 8, "PDF preview failed: " . $e->getMessage(), 0, 'L');
				$pdf->SetTextColor(0, 0, 255);
				$pdf->Write(8, "Open PDF", base_url('uploads/interview/' . basename($file)));
			}
			return;
		}


		// ==========================================
		// WORD FILE (.doc / .docx)
		// ==========================================
		if ($ext === 'doc' || $ext === 'docx') {

			$pdf->SetFont('dejavusans', '', 12);
			$pdf->SetTextColor(0, 0, 255);

			$pdf->MultiCell(
				0,
				8,
				"Word file attached:\n" . basename($file) . "\n(Word preview not supported)",
				0,
				'L'
			);
			return;
		}

		// ==========================================
		// IMAGE FILE
		// ==========================================
		$imgInfo = @getimagesize($file);

		if ($imgInfo === false || $imgInfo[0] == 0 || $imgInfo[1] == 0) {
			$pdf->SetFont('dejavusans', '', 12);
			$pdf->SetTextColor(255, 0, 0);
			$pdf->Cell(0, 10, 'Invalid or unreadable image: ' . basename($file), 0, 1);
			return;
		}

		list($origW, $origH) = $imgInfo;

		$ratio = min($maxW / $origW, $maxH / $origH);

		$newW = $origW * $ratio;
		$newH = $origH * $ratio;

		$pdf->Image($file, $x, $y, $newW, $newH);
	}
	
	public function download_txt($id)
	{
		if($this->action && !check_action_permission(get_user_role(), 'manage_interview', $this->action)){
			redirect('admin/unauthorized-request');
		}
		// Fetch data
		$data = $this->InterviewForm_model->get_detail($id);

		if (!$data) {
			show_error('Record not found');
		}

		// Prepare TXT content
		$txt  = "Name: " . $data->applicant_name . "\n";
		$txt .= "Iqama ID: " . $data->iqama_number . "\n";
		$txt .= "Date of Birth: " . date('d-m-Y', strtotime($data->date_of_birth)) . "\n";
		$txt .= "Absher Mobile Number: " . $data->mobile_number . "\n";
		$txt .= "Email: " . $data->email . "\n";
		$txt .= "IBAN: " . $data->iban_number . "\n";
		$txt .= "City: " . $data->city_name . "\n";

		// File name
		$filename = "Interview_Details_" . $data->applicant_name .'_'. $data->interview_no .".txt";

		// Force download
		header('Content-Type: text/plain');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Content-Length: ' . strlen($txt));

		echo $txt;
		exit;
	}

	public function export_excel()
    {
        // -------------------------------------------------
        // Filters
        // -------------------------------------------------
        $search       = $this->input->get('keyword') ?? '';
        $applied_for  = $this->input->get('applied_for') ?? null;
        $date_from    = $this->input->get('from') ?? null;
        $date_to      = $this->input->get('to') ?? null;

		$status       = $this->input->get('status') ?? null;
		$nationality   = $this->input->get('nationality') ?? null;
		$preferred_city   = $this->input->get('preferred_city') ?? null;
		$iqama_profession   = $this->input->get('iqama_profession') ?? null;
		$no_of_transfer   = $this->input->get('no_of_transfer') ?? null;
		$has_driving_license   = $this->input->get('has_driving_license') ?? null;
		$driving_license_type   = $this->input->get('driving_license_type') ?? null;
		$driving_license_expiry_from   = $this->input->get('driving_license_expiry_from') ?? null;
		$driving_license_expiry_to   = $this->input->get('driving_license_expiry_to') ?? null;
		$arrival_date_from   = $this->input->get('arrival_date_from') ?? null;
		$arrival_date_to   = $this->input->get('arrival_date_to') ?? null;

        // Export options
        $column_type  = $this->input->get('column_type') ?? 'visible_columns';
        $file_format  = $this->input->get('file_format') ?? 'file_format_xlsx';

        // Selected IDs
        $selectedIds = $this->input->get('checklist');
        if (!is_array($selectedIds)) {
            $selectedIds = [];
        }
        // -------------------------------------------------
        // Fetch export data
        // -------------------------------------------------
        $result = $this->InterviewForm_model->export_list(
            $search,
            $applied_for,
            $date_from,
            $date_to,
			$status,
			$nationality,
			$preferred_city,
			$iqama_profession,
			$no_of_transfer,
			$has_driving_license,
			$driving_license_type,
			$driving_license_expiry_from,
			$driving_license_expiry_to,
			$arrival_date_from,
			$arrival_date_to,
            $selectedIds,
            $column_type
        );

        if (empty($result['data'])) {
            show_error('No data available for export');
        }

        // -------------------------------------------------
        // File format switch
        // -------------------------------------------------
        if ($file_format === 'file_format_pdf') {
            // Placeholder for PDF export
            show_error('PDF export not implemented yet');
        }

        // -------------------------------------------------
        // XLSX Export
        // -------------------------------------------------
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $colIndex = 1;
        foreach ($result['headers'] as $header) {
            $sheet->setCellValueByColumnAndRow(
                $colIndex++,
                1,
                ucwords(str_replace('_', ' ', $header))
            );
        }

		// -------------------------------------------------
		// Header styling
		// -------------------------------------------------
		$lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
			count($result['headers'])
		);

		$headerRange = 'A1:' . $lastColumn . '1';

		$sheet->getStyle($headerRange)->applyFromArray([
			'font' => [
				'bold' => true,
				'color' => ['rgb' => 'FFFFFF']
			],
			'fill' => [
				'fillType' => Fill::FILL_SOLID,
				'startColor' => ['rgb' => '4472C4'] // Blue background
			],
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
				'vertical'   => Alignment::VERTICAL_CENTER
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN
				]
			]
		]);

		// Increase header row height (optional)
		$sheet->getRowDimension(1)->setRowHeight(22);

        // Data
        $rowIndex = 2;
        foreach ($result['data'] as $row) {
            $colIndex = 1;
            foreach ($result['headers'] as $key) {
                $sheet->setCellValueByColumnAndRow(
                    $colIndex++,
                    $rowIndex,
                    $row[$key] ?? ''
                );
            }
            $rowIndex++;
        }

        // Auto-size columns
        foreach (range(1, count($result['headers'])) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        // Download
        $filename = 'Interview_List_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}
