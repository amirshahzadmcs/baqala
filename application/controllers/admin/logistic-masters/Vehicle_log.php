<?php defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
class Vehicle_log extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/logistic-masters/Vehicle_log_model');
			$this->load->model('admin/logistic-masters/Master_vehicle_model');
			$this->load->library('form_validation');
			$this->load->helper('Common_helper');
			$this->action = $this->router->fetch_method();
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', 'all_logs')) {
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
		$this->load->view('admin/logistic-masters/log/list', $data);
	}

	public function get_list()
    {
        $filters = [
			'vehicle_no'      => $this->input->get('vehicle_no'),
			'sequel_no'       => $this->input->get('sequel_no'),
			'vehicle_type'    => $this->input->get('vehicle_type'),
			'vehicle_make'    => $this->input->get('vehicle_make'),
			'vehicle_model'   => $this->input->get('vehicle_model'),
			'vehicle_color'   => $this->input->get('vehicle_color'),
			'vehicle_year'    => $this->input->get('vehicle_year'),
			'status'          => $this->input->get('status'),
			'alloted_user'    => $this->input->get('alloted_user'),
			'vehicle_ownership' => $this->input->get('vehicle_ownership'),
			'from_date'       => $this->input->get('from'),
			'to_date'         => $this->input->get('to')
		];

        $list = $this->Vehicle_log_model->get_datatables($filters);

        $data = [];
        $no = $_POST['start'] + 1;

        foreach ($list as $row) {
            $sub = [];

            $sub[] = $no++;
            $sub[] = $row['emp_no'];
            $sub[] = $row['full_name'];
            $sub[] = $row['iqama_no'];
            $sub[] = $row['designation_name'];
            $sub[] = $row['department_name'];
            $sub[] = $row['vehicle_type'];
            $sub[] = $row['vehicle_no'];
            $sub[] = $row['vehicle_make_name'];
            $sub[] = $row['vehicle_model'];
            $sub[] = $row['vehicle_color_name'];
            $sub[] = $row['chassis_no'];
            $sub[] = $row['sequel_no'];
            $sub[] = $row['vehicle_year'];
            $sub[] = $row['status'];
            $sub[] = !empty($row['status_date']) ? date('d-m-Y', strtotime($row['status_date'])) : '';

            $lastStatus = ucfirst($row['log_status']);
			$badgeClass = match ($lastStatus) {
				'Alloted' => 'success',
				'Unalloted' => 'primary',
				'Return' => 'warning',
				default => 'secondary'
			};
			$sub[] = '<span class="badge badge-pill badge-soft-' . $badgeClass . ' font-size-13">' . $lastStatus . '</span>';
            $sub[] = $row['vehicle_ownership'];

            // Attachment link
            $sub[] = !empty($row['tamm_attachment'])
                ? '<a href="' . base_url($row['tamm_attachment']) . '" target="_blank"><i class="fa fa-paperclip font-size-20"></i></a>'
                : 'N/A';

            $data[] = $sub;
        }

        $output = [
            "draw" => intval($_POST['draw']),
            "recordsTotal" => $this->Vehicle_log_model->count_all($filters),
            "recordsFiltered" => $this->Vehicle_log_model->count_filtered($filters),
            "data" => $data,
        ];

        echo json_encode($output);
    }


	public function single_vehicle_log()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'vehicles', $this->action)) {
			return redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('vehicle_no', 'Vehicle Number', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$vehicle_id = $this->input->post('vehicle_no');
			$data['vehicle_info'] = $this->Master_vehicle_model->detail($vehicle_id)->row_array();
			$data['logs'] = $this->Vehicle_log_model->vehicle_wise_log($vehicle_id);
			$output_data = $this->load->view('admin/logistic-masters/log/quick-log', $data, TRUE);
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}

	public function export_excel()
	{
		$filters = [
			'vehicle_no'      => $this->input->get('vehicle_no'),
			'sequel_no'       => $this->input->get('sequel_no'),
			'vehicle_type'    => $this->input->get('vehicle_type'),
			'vehicle_make'    => $this->input->get('vehicle_make'),
			'vehicle_model'   => $this->input->get('vehicle_model'),
			'vehicle_color'   => $this->input->get('vehicle_color'),
			'vehicle_year'    => $this->input->get('vehicle_year'),
			'status'          => $this->input->get('status'),
			'alloted_user'    => $this->input->get('alloted_user'),
			'vehicle_ownership' => $this->input->get('vehicle_ownership'),
			'from_date'       => $this->input->get('from'),
			'to_date'         => $this->input->get('to')
		];
		//dd($filters);

		$data = $this->Vehicle_log_model->get_vehicle_allotment_report($filters);
		//dd($data);
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Updated headers (19 columns)
		$headers = [
			'Sr. No', 'EMP ID', 'EMP Name', 'Iqama / ID No', 'Designation Name', 'Department',
			'Vehicle Type', 'Vehicle No.', 'Vehicle Make', 'Vehicle Model', 'Vehicle Color',
			'Vehicle Chassis No.', 'Vehicle Sequel No.', 'Vehicle Year', 'Vehicle Status',
			'Alloted Date', 'UnAlloted Date', 'Last Log Status', 'Ownership Type', 'Tamm Auth./Cancl.'
		];

		// Set headers
		$col = 'A';
		foreach ($headers as $header) {
			$sheet->setCellValue($col . '1', $header);
			$col++;
		}

		// Style header (A1:T1 now, 20 columns)
		$sheet->getStyle('A1:T1')->applyFromArray([
			'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color' => ['rgb' => '4F81BD']
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000']
				]
			]
		]);

		// Fill data rows
		$row = 2;
		$srNo = 1;
		foreach ($data as $log) {
			// Determine last log status
        	$lastStatus = !empty($log['unallot_date']) ? 'Unalloted' : 'Alloted';
			$sheet->setCellValue('A' . $row, $srNo++);
			$sheet->setCellValue('B' . $row, $log['emp_no']);
			$sheet->setCellValue('C' . $row, $log['full_name']);
			$sheet->setCellValue('D' . $row, $log['iqama_no']);
			$sheet->setCellValue('E' . $row, $log['designation_name']);
			$sheet->setCellValue('F' . $row, $log['department_name']);
			$sheet->setCellValue('G' . $row, $log['vehicle_type']);
			$sheet->setCellValue('H' . $row, $log['vehicle_no']);
			$sheet->setCellValue('I' . $row, $log['vehicle_make_name']);
			$sheet->setCellValue('J' . $row, $log['vehicle_model']);
			$sheet->setCellValue('K' . $row, $log['vehicle_color_name']);
			$sheet->setCellValue('L' . $row, $log['chassis_no']);
			$sheet->setCellValue('M' . $row, $log['sequel_no']);
			$sheet->setCellValue('N' . $row, $log['vehicle_year']);
			$sheet->setCellValue('O' . $row, $log['status']);
			$sheet->setCellValue('P' . $row, isset($log['allot_date']) ? date('d-m-Y', strtotime($log['allot_date'])) : '');
			$sheet->setCellValue('Q' . $row, isset($log['unallot_date']) ? date('d-m-Y', strtotime($log['unallot_date'])) : '');
			$sheet->setCellValue('R' . $row, $lastStatus);
			$sheet->setCellValue('S' . $row, $log['vehicle_ownership']);
			$sheet->setCellValue('T' . $row, isset($log['tamm_attachment']) ? 'Yes' : 'No');
			$row++;
		}

		// Borders for all cells
		$sheet->getStyle('A1:T' . ($row - 1))->applyFromArray([
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['rgb' => '000000']
				]
			]
		]);

		// Auto-size all columns
		foreach (range('A', 'T') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Output file
		$filename = 'Vehicle_Allotment_Report_' . date('Ymd_His') . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
	}
}
