<?php defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Fuel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/Employee_model', 'employee_model');
			$this->load->model('admin/logistic-management/Fuel_model', 'fuel_model');
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
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['fuel_summary'] = $this->fuel_model->getFuelSummaryByMonth();
		return $this->load->view('admin/logistic-management/fuel/index', $data);
	}

	/*----- Fuel Management Start -----*/

	public function vehicle_list()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		return $this->load->view('admin/logistic-management/fuel/vehicle-list', $data);
	}

	public function vehicle_list_ajax()
	{
		// Optional filters (you can extend to read from POST if needed)
		$start_date = $this->input->post('start_date');
		$end_date   = $this->input->post('end_date');

		// Fetch vehicle data from model
		$fetch_data = $this->fuel_model->get_vehicle_list($start_date, $end_date);
		$i = $_POST['start'] + 1;
		$data = [];

		foreach ($fetch_data as $item) {
			$sub = [];

			// --- BASIC INFO ---
			$sub[] = $i++;
			$sub[] = ucfirst($item->vehicle_no ?? 'NA');
			$sub[] = ucfirst($item->vehicle_type ?? 'NA');

			// --- ALLOTMENT STATUS BADGE ---
			switch ($item->allotment_status) {
				case 'alloted':
					$allot_status = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
					break;
				case 'unalloted':
					$allot_status = '<span class="badge badge-pill badge-soft-primary font-size-13">Unalloted</span>';
					break;
				case 'return':
					$allot_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Return</span>';
					break;
				default:
					$allot_status = '<span class="badge badge-pill badge-soft-secondary font-size-13">NA</span>';
			}
			$sub[] = $allot_status;

			// --- VEHICLE CATEGORY / EMPLOYEE ---
			$sub[] = ucfirst($item->vehicle_category ?? 'NA');
			$sub[] = !empty($item->emp_no) ? $item->emp_no : 'NA';
			$sub[] = !empty($item->full_name) ? $item->full_name : 'NA';
			$sub[] = !empty($item->fuel_date) ? date('d-m-Y', strtotime($item->fuel_date)) : 'NA';

			// --- FUEL & ORDER DATA ---
			$total_fuel     = (float) ($item->liters ?? 0);
			$total_cost     = (float) ($item->cost ?? 0);
			$total_orders   = (int) (($item->hunger_orders ?? 0) + ($item->jahez_orders ?? 0) + ($item->noon_orders ?? 0));

			// Averages
			$avg_per_order  = ($total_orders > 0) ? round($total_cost / $total_orders, 2) : '-';
			$avg_order_day  = '-';
			$working_days   = '-';
			$order_group    = '-';
			$fuel_group     = '-';

			// Aggregator Info (from your join)
			$aggregator     = !empty($item->company_name) ? ucfirst($item->company_name) : '-';
			$aggregator_id  = !empty($item->id_number) ? $item->id_number : '-';

			// --- BUILD TABLE ROW ---
			$sub[] = number_format($total_cost, 2);
			$sub[] = $total_orders;
			$sub[] = $avg_per_order;
			$sub[] = $avg_order_day;
			$sub[] = $working_days;
			$sub[] = $order_group;
			$sub[] = $fuel_group;
			$sub[] = $aggregator;
			$sub[] = $aggregator_id;

			// --- TOOLS BUTTON ---

			$data[] = $sub;
		}

		// --- OUTPUT FOR DATATABLE ---
		$output = [
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->fuel_model->get_all_vehicle_data(),
			"recordsFiltered" => $this->fuel_model->get_filtered_vehicle_data($start_date, $end_date),
			"data" => $data
		];

		echo json_encode($output);
	}

	public function add_vehicles()
	{
		$this->load->view('admin/logistic-management/fuel/components/add-vehicle-form');
	}
	
	public function filter_modal()
	{
		$data['teams'] = $this->db->query("
			SELECT id, name, ar_name, status
			FROM hunger_team
			WHERE status = '1'
		")->result();

		$this->load->view('admin/logistic-management/fuel/components/print_filter_modal', $data);
	}

	public function vehicle_search_list()
	{
		$search = $this->input->post('search');
		$response = vehicleSearchHelper($search);
		echo json_encode($response);
	}

	public function get_vehicle_detail()
	{
		$this->form_validation->set_rules('search_vehicle', 'Vehicle ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$vehicle_id = $this->input->post('search_vehicle');
			$query = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.vehicle_ownership, mv.insurance_no, mv.insurance_company_name, mv.insurance_issue_date, mv.insurance_expiry, mv.gasoline_chip_status, mvk.make_name, mic.company_name, mip.policy_number FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) LEFT JOIN master_insurance_policies as mip ON (mv.insurance_no = mip.id) LEFT JOIN master_insurance_company as mic ON (mv.insurance_company_name = mic.id) WHERE mv.id = '" . (int)$vehicle_id . "'");
			if ($query->num_rows() > 0) {
				$data['vehicle_detail'] = $query->row_array();
				//dd($data['vehicle_detail']);
				$vehicle_no = $data['vehicle_detail']['vehicle_no'];
				$vehicle_type = $data['vehicle_detail']['vehicle_type'];
				$vehicle_model = $data['vehicle_detail']['vehicle_model'];
				$output_data = $this->load->view('admin/logistic-management/fuel/components/vehicle-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Vehicle detail successfully fetched.', "output_html" => $output_data, "vehicle_no" => $vehicle_no, "vehicle_model" => $vehicle_model, "vehicle_type" => $vehicle_type);
			} else {
				$result = array("type" => 'error', "message" => 'Vehicle detail not found, try again');
			}
		}
		echo json_encode($result);
	}

	public function submit_vehicle()
	{
		$this->form_validation->set_rules(
			'vehicle_id',
			'Vehicle Number',
			'trim|required|is_unique[fuel_vehicle.vehicle_id]',
			['is_unique' => 'This vehicle already exists.']
		);

		$vehicle_id = (int)$this->input->post('vehicle_id');

		// Fetch vehicle data
		$query = $this->db->query("SELECT id, vehicle_no, gasoline_chip_status FROM master_vehicles WHERE id = {$vehicle_id}");
		if ($query->num_rows() > 0) {
			$vehicle_data = $query->row_array();
			// If chip is not installed, require additional fields
			if ($vehicle_data['gasoline_chip_status'] !== 'on') {
				$this->form_validation->set_rules('gasoline_chip_status', 'Gasoline Chip Status', 'trim|required');
				$this->form_validation->set_rules('gasoline_installation_date', 'Gasoline Installation Date', 'trim|required');
			}
		}

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['type' => 'error', 'message' => validation_errors()]);
			return;
		}

		// Start transaction
		$this->db->trans_start();

		// Insert into fuel_vehicle
		$insert_data = [
			'vehicle_id' => $vehicle_id,
			'vehicle_no' => $vehicle_data['vehicle_no'],
			'created_at' => date('Y-m-d H:i:s')
		];
		$this->db->insert('fuel_vehicle', $insert_data);
		if( !$this->db->affected_rows() ) {
			echo json_encode(['type' => 'error', 'message' => 'Error while adding vehicle.']);
			return;
		}
		// Prepare master_vehicles update data
		$update_data = [
			'gasoline_chip_status' => $this->input->post('gasoline_chip_status'),
			'gasoline_installation_date' => $this->input->post('gasoline_installation_date'),
			'updated_at' => date('Y-m-d H:i:s'),
			'ip' => $this->input->ip_address()
		];
		$this->db->where('id', $vehicle_id);
		$this->db->update('master_vehicles', $update_data);

		// Complete transaction
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// Rollback
			$this->db->trans_rollback();
			echo json_encode(['type' => 'error', 'message' => 'Error while adding vehicle.']);
		} else {
			// Commit
			$this->db->trans_commit();
			echo json_encode(['type' => 'success', 'message' => 'Vehicle added successfully.']);
		}
	}

	/*----- Fuel Management End -----*/
	
	public function search_employee()
	{
		$keyword = $this->input->get('search'); 
		$items = allEmployeeListHelper($keyword);
		echo json_encode($items);
	}

	/*----- Bulk Import Fuel -----*/

	public function import_file()
	{
		$path = 'uploads/imports/fuel/';
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

			// Remove header row (assuming it's the first row)
			array_shift($sheet_data);

			// Step 1: Prepare Excel data
			$excel_data = [];
			foreach ($sheet_data as $val) {
				if (!empty($val[1])) {
					$excel_data[] = [
						'vehicle_no' => trim($val[1]),
						'cost' => isset($val[2]) && is_numeric($val[2]) ? (float)$val[2] : 0
					];
				}
			}

			// Step 2: Fetch all existing vehicles
			$allVehicles = $this->db->select('vehicle_no')->from('fuel_vehicle')->get()->result_array();
			$existing_vehicle_nos = array_column($allVehicles, 'vehicle_no');

			// Step 3: Initialize tracking variables
			$this->db->trans_start();
			$batch_data = [];
			$duplicate_rows = [];
			$missing_vehicles = [];
			$date_local = date('Y-m-d', strtotime($this->input->post('fuel_date')));
			$rowNumber = 2; // Excel starts at row 2 (header skipped)

			foreach ($excel_data as $row) {
				$vehicle_no = $row['vehicle_no'];
				$cost = $row['cost'];

				// ✅ Check if vehicle exists in DB
				if (!in_array($vehicle_no, $existing_vehicle_nos)) {
					$missing_vehicles[] = [$rowNumber, $vehicle_no, $cost];
					$rowNumber++;
					continue;
				}

				// ✅ Check for duplicate (same vehicle, same date)
				$isDuplicate = $this->fuel_model->checkDuplicateInBulk([
					"vehicle_no" => $vehicle_no,
					"fuel_date" => $date_local,
				]);

				if ($isDuplicate) {
					$duplicate_rows[] = [$rowNumber, $vehicle_no, $cost];
					$rowNumber++;
					continue;
				}

				// ✅ Fetch employee + team info for vehicle
				$empInfo = getVehicleEmpInfoForDayHelper($vehicle_no, $date_local);

				$vehicle_id = $empInfo['vehicle_id'] ?? null;
				$emp_id = $empInfo['emp_id'] ?? null;
				$team_id = $empInfo['team_id'] ?? null;
				$allotment_status = $empInfo['allotment_status'] ?? null;

				$batch_data[] = [
					"vehicle_id" => $vehicle_id,
					"vehicle_no" => $vehicle_no,
					"allotment_status" => $allotment_status,
					"emp_id"     => $emp_id,
					"team_id"    => $team_id,
					"cost"       => $cost,
					"fuel_date"  => $date_local,
					"added_by"   => $this->admin->getId(),
					"ip_address" => $this->ip_address,
					"created_at" => $this->datetime,
					"updated_at" => $this->datetime
				];

				// Insert in batches of 100
				if (count($batch_data) >= 100) {
					$this->insertBatchData($batch_data);
					$batch_data = [];
				}

				$rowNumber++;
			}

			// Insert remaining
			if (!empty($batch_data)) {
				$this->insertBatchData($batch_data);
			}

			$this->db->trans_complete();

			// Delete the uploaded file
			if (file_exists($file_name)) {
				unlink($file_name);
			}

			// ✅ Unified JSON response
			$json = [
				'success_message'  => (!empty($batch_data) ? count($batch_data) . ' record(s) imported successfully.' : ''),
				'duplicate_rows'   => $duplicate_rows,
				'missing_vehicles' => $missing_vehicles,
			];

			// Add readable message if nothing inserted
			if (empty($batch_data) && empty($duplicate_rows) && empty($missing_vehicles)) {
				$json['error_message'] = 'No valid data found in Excel.';
			}
		} catch (Exception $e) {
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
		$result = $this->db->insert_batch('fuel_consumptions', $batch_data);

		if (!$result) {
			$json = [
				'error_message' => 'Something went wrong. Please try again.',
			];
			echo json_encode($json);
			exit();
		}
	}

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

	/*----- Bulk Import Fuel End -----*/

	public function detail()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['teams'] = $query = $this->db->query("SELECT `id`, `name`, `ar_name`, `status` FROM `hunger_team` WHERE status = '1'")->result();
		$this->load->view('admin/logistic-management/fuel/detail', $data);
	}

	public function view_monthly_fuel_summary($month = null)
	{
		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/logistic-management/fuel/list');
		}

		try {
			$records = $this->fuel_model->get_employee_monthly_fuel($month);

			// Group data by Vehicle + Employee combo
			$employees = [];
			foreach ($records as $row) {
				$empKey   = $row->emp_no ?? 'NA';
				$vehKey   = $row->vehicle_no ?? 'Unknown';
				$groupKey = $vehKey . '_' . $empKey; // unique key per vehicle+employee

				if (!isset($employees[$groupKey])) {
					$employees[$groupKey] = [
						'vehicle_no'       => $row->vehicle_no,
						'vehicle_type'     => $row->vehicle_type,
						'allotment_status' => $row->allotment_status,
						'emp_no'           => $row->emp_no ?? 'NA',
						'full_name'        => $row->full_name ?? 'NA',
						'team_name'        => $row->team_name ?? '',
						//'team_leader'      => $row->team_leader ?? '',
						'days'             => [],
						'total_cost'       => 0,
						'total_orders'     => 0,
					];
				}

				$dateKey = date('j', strtotime($row->fuel_date)); // day of month

				// Orders (priority: hunger > jahez > noon)
				$orders = 0;
				if (!empty($row->hunger_orders)) {
					$orders = $row->hunger_orders;
				} elseif (!empty($row->jahez_orders)) {
					$orders = $row->jahez_orders;
				} elseif (!empty($row->noon_orders)) {
					$orders = $row->noon_orders;
				}

				// Save day-wise
				$employees[$groupKey]['days'][$dateKey] = [
					'fuel_date' => $row->fuel_date,
					'liters'    => $row->liters,
					'cost'      => $row->cost,
					'orders'    => $orders,
					'remarks'   => $row->remarks,
				];

				// Totals
				$employees[$groupKey]['total_cost']   += (float)$row->cost;
				$employees[$groupKey]['total_orders'] += (int)$orders;
			}

		} catch (Exception $e) {
			log_message('error', 'Error fetching monthly fuel data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}

		// PDF variables
		$search_month = $month ?: 'NA';
		$printed_by   = $this->session->userdata('admin_name') ?? 'System User';

		return $this->load->view('admin/logistic-management/fuel/monthly-detail', [
			'month'        => $month,
			'search_month' => $search_month,
			'printed_by'   => $printed_by,
			'employees'    => $employees
		]);
	}

	public function get_list($month = null)
	{
		$fetch_data = $this->fuel_model->get_list($month);
		$i = $_POST['start'] + 1;
		$data = array();

		foreach ($fetch_data as $item) {
			$sub_array = array();

			$sub_array[] = $i++; // S.No.
			
			// Vehicle
			$sub_array[] = $item->vehicle_no;
			$sub_array[] = $item->vehicle_type ? ucfirst($item->vehicle_type) : '-';
			$sub_array[] = $item->allotment_status ? ucfirst($item->allotment_status) : '-';

			// Employee No + Name → Prefer Hunger else Jahez else Noon
			$emp_no   = $item->employee_no ?? 'NA';
			$emp_name = $item->employee_name ?? 'NA';
			$sub_array[] = $emp_no;
			$sub_array[] = $emp_name;
			// Fuel
			$sub_array[] = date('d-m-Y', strtotime($item->fuel_date));
			$sub_array[] = $item->cost;

			// Orders completed → prefer aggregator wise
			$orders = $item->hunger_orders ?? $item->jahez_orders ?? $item->noon_orders ?? 0;
			$sub_array[] = $orders;
			// Average Per Order
			if ($orders > 0 && $item->cost > 0) {
				$avg_per_order = round($item->cost / $orders, 2);
			} else {
				$avg_per_order = 0;
			}

			// Threshold check
			$highlight = '';
			if ($item->vehicle_type == 'car' && $avg_per_order <= 2.67) {
				$highlight = 'style="color:red;font-weight:bold;"';
			} elseif ($item->vehicle_type == 'bike' && $avg_per_order <= 0.89) {
				$highlight = 'style="color:red;font-weight:bold;"';
			}

			// Show with formatting
			$sub_array[] = $avg_per_order > 0 ? "<span $highlight>$avg_per_order</span>" : '-';


			// Aggregator
			$aggregator_id = $item->hunger_rider_id ?? $item->jahez_driver_id ?? $item->noon_da_id ?? 0;
			$sub_array[] = $aggregator_id;

			// Remarks
			$sub_array[] = $item->remarks ?? '-';

			//$designation = $item->designation_name ?? 'NA';
			//$team_name = $item->team_name ?? 'NA';

			// Created / Updated
			$sub_array[] = date('d-m-Y H:i:s', strtotime($item->created_at));
			$sub_array[] = $item->updated_at ? date('d-m-Y', strtotime($item->updated_at)) : '';

			// Tools (actions dropdown)
			$actionDropdown = '<div class="btn-group ms-2 float-end">
				<button class="btn btn-light-grey btn-sm dropdown-toggle" data-bs-toggle="dropdown">
					<i class="dripicons-dots-3"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">
					<a class="dropdown-item" href="#"><i class="mdi mdi-pencil me-2"></i>Edit</a>
					<a class="dropdown-item" href="#"><i class="mdi mdi-delete me-2"></i>Delete</a>
				</div>
			</div>';
			$sub_array[] = $actionDropdown;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"            => intval($_POST["draw"]),
			"recordsTotal"    => $this->fuel_model->get_all_data(),
			"recordsFiltered" => $this->fuel_model->get_filtered_data($month),
			"data"            => $data
		);

		echo json_encode($output);
	}

	public function delete($month = null)
	{
		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/logistic-management/fuel/list');
		}

		$this->load->model('fuel_model');
		$deleted = $this->fuel_model->delete_fuel_by_month($month);

		if ($deleted) {
			$this->session->set_userdata('info', "1--Fuel consumption for " . date('F Y', strtotime($month)) . " deleted successfully.");
		} else {
			$this->session->set_userdata('info', "2--Failed to delete fuel consumption or Fuel consumption not found.");
		}
		redirect('admin/logistic-management/fuel/list');
	}

	public function print_monthly_fuel_summary($month = null)
	{
		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/logistic-management/fuel/list');
		}

		$this->load->library('Pdf_hunger_report_landscape');

		try {
			$records = $this->fuel_model->get_employee_monthly_fuel($month);

			// Group data by employee
			$employees = [];
			foreach ($records as $row) {
				$empKey = $row->emp_no ?? 'Unknown';
				if (!isset($employees[$empKey])) {
					$employees[$empKey] = [
						'emp_no'       => $row->emp_no,
						'full_name'    => $row->full_name,
						'vehicle_no'   => $row->vehicle_no,
						'vehicle_type' => $row->vehicle_type,
						'days'         => [],
						'total_cost'   => 0,
						'total_orders' => 0,
					];
				}

				$dateKey = date('j', strtotime($row->fuel_date)); // day of month
				$orders  = $row->hunger_orders ?? $row->jahez_orders ?? $row->noon_orders ?? 0;

				$employees[$empKey]['days'][$dateKey] = [
					'cost'   => $row->cost,
					'orders' => $orders,
				];

				$employees[$empKey]['total_cost']   += $row->cost;
				$employees[$empKey]['total_orders'] += $orders;
			}

		} catch (Exception $e) {
			log_message('error', 'Error fetching fuel data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}

		// PDF variables
		$search_month = $month ?: 'NA';
		$printed_by   = $this->session->userdata('admin_name') ?? 'System User';

		// Init PDF
		$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Monthly Fuel Summary');
		$pdf->SetSubject('Monthly Fuel Summary');
		$pdf->SetKeywords('Maha Al Fala, PDF, Monthly Fuel Summary');

		// Header/Footer
		$pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);

		$htmlHeader = $this->load->view('admin/logistic-management/fuel/print/monthly_fuel_header', [
			'month'        => $month,
			'search_month' => $search_month,
			'printed_by'   => $printed_by,
			'employees'    => $employees
		], true);
		$pdf->setHtmlHeader($htmlHeader);

		$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', [
			'month'        => $month,
			'search_month' => $search_month,
			'printed_by'   => $printed_by,
			'employees'    => $employees
		], true);
		$pdf->setHtmlFooter($lastFooter);

		// PDF Settings
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(4, 60, 4, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// Large reports ke liye safe execution
		ini_set('memory_limit', '512M');
		ini_set('max_execution_time', 300);

		// Page
		$pdf->AddPage('L', 'A1');
		$pdf->setRTL(false);

		// Render view
		$htmlcontent = $this->load->view('admin/logistic-management/fuel/print/print_monthly_fuel', [
			'month'        => $month,
			'search_month' => $search_month,
			'printed_by'   => $printed_by,
			'employees'    => $employees
		], true);

		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		// Clean buffer and output
		ob_end_clean();
		$filename = $month
			? 'BS-Monthly-Fuel-Summary-' . htmlspecialchars($month) . '.pdf'
			: 'BS-Monthly-Fuel-All-Summary.pdf';

		$pdf->Output($filename, 'I');
	}

	public function export_monthly_fuel_summary_excel($month = null)
	{
		if (!$month) {
			$this->session->set_userdata('info', "2--Invalid month specified.");
			redirect('admin/logistic-management/fuel/list');
		}

		try {
			$records = $this->fuel_model->get_employee_monthly_fuel($month);

			// Group data by employee
			$employees = [];
			foreach ($records as $row) {
				$empKey = $row->emp_no ?? 'Unknown';
				if (!isset($employees[$empKey])) {
					$employees[$empKey] = [
						'emp_no'       => $row->emp_no,
						'full_name'    => $row->full_name,
						'vehicle_no'   => $row->vehicle_no,
						'vehicle_type' => $row->vehicle_type,
						'allotment'    => $row->allotment_status ?? '',
						'team_name'    => $row->team_name ?? '',
						'team_leader'  => $row->team_leader ?? '',
						'days'         => [],
						'total_cost'   => 0,
						'total_orders' => 0,
					];
				}

				$dateKey = date('j', strtotime($row->fuel_date));
				$orders  = $row->hunger_orders ?? $row->jahez_orders ?? $row->noon_orders ?? 0;

				$employees[$empKey]['days'][$dateKey] = [
					'cost'   => $row->cost,
					'orders' => $orders,
				];

				$employees[$empKey]['total_cost']   += $row->cost;
				$employees[$empKey]['total_orders'] += $orders;
			}

		} catch (Exception $e) {
			log_message('error', 'Error fetching fuel data: ' . $e->getMessage());
			show_error($e->getMessage(), 500);
			return;
		}

		// Prepare Excel
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$dateObj   = DateTime::createFromFormat('Y-m', $month);
		$num_days  = $dateObj->format('t');
		$monthName = $dateObj->format('F Y');

		// Title
		$sheet->setCellValue('A1', "Monthly Fuel Report — " . $monthName);
		$sheet->mergeCells("A1:" . 'H1'); 
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// --- Header Row 1 ---
		$headers = [
			"#", "Emp ID", "Name", "Vehicle No", "Vehicle Type",
			"Allotment Status", "Team", "Team Leader", "Fuel Consumption", "Order Completed"
		];
		$colWidths = [5, 12, 30, 15, 12, 18, 25, 25, 20, 20]; // adjusted widths
		$col = 1;

		foreach ($headers as $index => $head) {
			$sheet->setCellValueByColumnAndRow($col, 3, $head);
			$sheet->getStyleByColumnAndRow($col, 3)->getFont()->setBold(true);
			$sheet->getStyleByColumnAndRow($col, 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getColumnDimensionByColumn($col)->setWidth($colWidths[$index]);
			$col++;
		}

		// Apply light grey background to header row (A3:J3)
		$lastHeaderCol = $col - 1; // J (10th column)
		$sheet->getStyle("A3:" . $sheet->getCellByColumnAndRow($lastHeaderCol, 3)->getColumn() . "3")
			->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setRGB('D3D3D3'); // light grey

		// --- Dynamic Days Header (Row 3 - merged) ---
		for ($day = 1; $day <= $num_days; $day++) {
			$colIndex = $col;
			$sheet->mergeCellsByColumnAndRow($colIndex, 3, $colIndex + 1, 3);
			$sheet->setCellValueByColumnAndRow($colIndex, 3, $day . ' ' . $dateObj->format('M'));
			$sheet->getStyleByColumnAndRow($colIndex, 3)->getFont()->setBold(true);
			$sheet->getStyleByColumnAndRow($colIndex, 3)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyleByColumnAndRow($colIndex, 3)->getFill()
				->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setRGB('99CC66');
			$col += 2;
		}

		// --- Header Row 2 (F/O) ---
		$col = 11;
		for ($day = 1; $day <= $num_days; $day++) {
			$sheet->setCellValueByColumnAndRow($col, 4, "F");
			$sheet->getStyleByColumnAndRow($col, 4)->getFont()->setBold(true);
			$sheet->getStyleByColumnAndRow($col, 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyleByColumnAndRow($col, 4)->getFill()
				->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setRGB('66CCCC');

			$sheet->setCellValueByColumnAndRow($col + 1, 4, "O");
			$sheet->getStyleByColumnAndRow($col + 1, 4)->getFont()->setBold(true);
			$sheet->getStyleByColumnAndRow($col + 1, 4)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
			$sheet->getStyleByColumnAndRow($col + 1, 4)->getFill()
				->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setRGB('FFCC33');

			$col += 2;
		}

		// --- Data Rows ---
		$rowNum = 5;
		$i = 1;
		$grand_total_cost = 0;
		$grand_total_orders = 0;
		$daily_totals = [];

		foreach ($employees as $emp) {
			$sheet->setCellValue("A$rowNum", $i++);
			$sheet->setCellValue("B$rowNum", $emp['emp_no']);
			$sheet->setCellValue("C$rowNum", $emp['full_name']);
			$sheet->setCellValue("D$rowNum", $emp['vehicle_no']);
			$sheet->setCellValue("E$rowNum", ucfirst($emp['vehicle_type']));
			$sheet->setCellValue("F$rowNum", ucfirst($emp['allotment']));
			$sheet->setCellValue("G$rowNum", $emp['team_name']);
			$sheet->setCellValue("H$rowNum", $emp['team_leader']);
			$sheet->setCellValue("I$rowNum", $emp['total_cost']);
			$sheet->setCellValue("J$rowNum", $emp['total_orders']);

			$col = 11;
			for ($day = 1; $day <= $num_days; $day++) {
				$cost   = $emp['days'][$day]['cost'] ?? 0;
				$orders = $emp['days'][$day]['orders'] ?? 0;

				if (!isset($daily_totals[$day])) {
					$daily_totals[$day] = ['cost' => 0, 'orders' => 0];
				}
				$daily_totals[$day]['cost']   += $cost;
				$daily_totals[$day]['orders'] += $orders;

				$sheet->setCellValueByColumnAndRow($col, $rowNum, $cost);
				$sheet->setCellValueByColumnAndRow($col + 1, $rowNum, $orders);

				$col += 2;
			}

			$grand_total_cost += $emp['total_cost'];
			$grand_total_orders += $emp['total_orders'];

			$rowNum++;
		}

		// --- Footer Row (Grand Totals) ---
		$sheet->setCellValue("A$rowNum", "Grand Total");
		$sheet->mergeCells("A$rowNum:H$rowNum");
		$sheet->getStyle("A$rowNum")->getFont()->setBold(true);
		$sheet->getStyle("A$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A$rowNum:H$rowNum")->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setRGB('FFD700');

		// Fuel Consumption and Order Completed columns
		$sheet->setCellValue("I$rowNum", $grand_total_cost);
		$sheet->setCellValue("J$rowNum", $grand_total_orders);

		$sheet->getStyle("I$rowNum:J$rowNum")->getFont()->setBold(true);
		$sheet->getStyle("I$rowNum:J$rowNum")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("I$rowNum:J$rowNum")->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setRGB('FFD700');

		// Daily totals columns
		$col = 11;
		for ($day = 1; $day <= $num_days; $day++) {
			$sheet->setCellValueByColumnAndRow($col, $rowNum, $daily_totals[$day]['cost']);
			$sheet->setCellValueByColumnAndRow($col + 1, $rowNum, $daily_totals[$day]['orders']);

			$sheet->getStyleByColumnAndRow($col, $rowNum)->getFill()
				->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setRGB('FFD700');

			$sheet->getStyleByColumnAndRow($col + 1, $rowNum)->getFill()
				->setFillType(Fill::FILL_SOLID)
				->getStartColor()->setRGB('FFD700');

			$col += 2;
		}

		// Auto-size first 10 columns
		foreach (range('A', 'J') as $colLetter) {
			$sheet->getColumnDimension($colLetter)->setAutoSize(true);
		}

		// Output Excel
		$filename = $month ? 'Monthly-Fuel-Summary-' . $month . '.xlsx' : 'Monthly-Fuel-Summary.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
	
	public function daily_consumption_report()
	{
		$this->load->library('Pdf_hunger_report_landscape');
		// Optional filters (you can extend to read from POST if needed)
		$start_date = $this->input->get('start_date');
		$end_date   = $this->input->get('end_date');
		// Fetch vehicle data from model
		$data['fuel_reports'] = $this->fuel_model->daily_consumption_report($start_date, $end_date);
		//dd($data['fuel_reports']);
		// ✅ Check number of rows
		if (!empty($data['fuel_reports']) && count($data['fuel_reports']) > 1000) {
			$this->session->set_userdata('info', "2--Printing limited to 1000 rows. Please use filters to refine your report.");
			redirect('admin/logistic-management/fuel-management/list');exit();
		}
		if ($data['fuel_reports'] !== '') {
			// print_r($order);exit();
			$start_date = $this->input->get('start_date');
			$end_date = $this->input->get('end_date');
			$data['start_date'] = ($start_date) ? date("d-m-Y", strtotime($start_date)) : 'NA';
			$data['end_date'] = ($end_date) ? date("d-m-Y", strtotime($end_date)) : 'NA';
			$data['print_date'] = date('d/m/Y');
			$printed_by   = $this->session->userdata('admin_name') ?? 'System User';
			// create new PDF document
			$pdf = new Pdf_hunger_report_landscape(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Daily Fuel Consumption Report');
			$pdf->SetSubject('BS - Daily Fuel Consumption Report');
			$pdf->SetKeywords('Baqala Station, PDF, Daily Fuel Consumption Report, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/logistic-management/fuel/print/daily_consumption_header', $data, true);
			$htmlHeader2 = $this->load->view('admin/logistic-management/fuel/print/daily_consumption_header', $data, true);
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', [
				'printed_by'   => $printed_by,
				'print_date'    => $data['print_date']
			], true);
			$pdf->setHtmlFooter($lastFooter);
			// set header and footer fonts
			$pdf->SetMargins(4, 65, 5, true);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(8);
			$pdf->SetAutoPageBreak(TRUE, 15);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}
			$pdf->AddPage('L', 'A4');
			$pdf->setRTL(false);
			$pdf->Ln();
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/logistic-management/fuel/print/print_daily_consumption', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = 'Daily-Fuel-Consumption-Report';
			if (!empty($start_date) && !empty($end_date)) {
				$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
			}
			$filename .= '.pdf';
			$pdf->Output($filename, 'I');
		} else {
			$this->session->set_userdata('info', "2-- Fuel consumption detail not found!");
			redirect('admin/logistic-management/fuel-management/list');
		}
	}
	
}
