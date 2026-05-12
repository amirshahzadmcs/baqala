<?php defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ThreePlApplication extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin');
		}
		// Load Model
		$this->load->model('admin/3pl/ThreePl_model', 'three_pl_model');
		$this->load->helper('common_helper');
		$this->load->library('form_validation');
		$this->ip_address = $_SERVER['REMOTE_ADDR'];
		$this->datetime = date("Y-m-d H:i:s");
		$this->action = $this->router->fetch_method();
	}

	/**
	 * List Page for 3PL Rider Applications
	 */
	public function list_page()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}

		$data['search'] = '';
		$data['perPage'] = 50;

		// ✅ Load user column preferences for 3pl_rider_applications
		$userPreferences = $this->db->get_where('user_column_preferences', [
			'user_id' => $this->admin->getLoginEmpId(),
			'module_name' => 'threepl_rider_applications'
		])->row();

		$data['selectedTableColumns'] = json_decode($userPreferences->available_columns ?? '[]', true);
		$data['visibleTableColumns'] = json_decode($userPreferences->visible_columns ?? '[]', true);

		$this->load->view("admin/3pl/index", $data);
	}

	/**
	 * Get List (AJAX DataTable)
	 */
	public function get_list()
	{
		$search = $this->input->post('search') ?? $this->input->post('keyword') ?? '';
		$perPage = $this->input->post('length') ?? 50;
		$start = $this->input->post('start') ?? 0;

		$date_from = $this->input->post('date_from') ?? null;
		$date_to = $this->input->post('date_to') ?? null;

		$fetch_data = $this->three_pl_model->list($search, $perPage, $start, $date_from, $date_to);

		$i = $start + 1;
		$data = [];

		foreach ($fetch_data['data'] as $item) {
			$sub_array = [];
			if (isset($item['id'])) {
				$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="' . $item['id'] . '" />';
			}else{
				$sub_array[] = '<input type="checkbox" name="checklist[]" class="checkbox" value="" />';
			}
			$sub_array[] = $i++;

			$image_columns = ['iqama_file', 'license_file', 'iban_file', 'photo_file'];

			foreach ($fetch_data['visible_columns'] as $column) {
				if ($column == 'id') continue;

				$value = $item[$column] ?? '';

				if (in_array($column, $image_columns) && !empty($value)) {
					$file_url = base_url($value);
					$sub_array[] = '<img src="'.$file_url.'" class="img-clickable" style="height:50px;width:50px;object-fit:cover;border-radius:5px;cursor:pointer;" data-file="'.$file_url.'" />';
				} 
				elseif (in_array($column, ['rider_iqama_expiry', 'dob', 'created_at', 'updated_at']) && !empty($value)) {
					$sub_array[] = date('d-m-Y', strtotime($value));
				} 
				elseif (is_numeric($value) && strpos($column, 'iban') !== false) {
					$sub_array[] = htmlspecialchars((string)$value);
				} 
				else {
					$sub_array[] = htmlspecialchars($value);
				}
			}

			$data[] = $sub_array;
		}

		$output = [
			"draw" => intval($this->input->post("draw")),
			"recordsTotal" => $fetch_data['pagination']['total'],
			"recordsFiltered" => $fetch_data['pagination']['total'],
			"data" => $data,
			"search" => $search,
			"perPage" => $perPage,
			"current_page" => $fetch_data['pagination']['current_page']
		];

		echo json_encode($output);
	}

	/**
	 * Delete selected records
	 */
	public function delete(){
		$ids = $this->input->post('checklist');
		if (!is_array($ids) || empty($ids)) {
			$this->session->set_userdata('info', "2--No valid items selected or ID column is hidden.");
			redirect('admin/3pl/application/list_page');
		}
		$query = $this->three_pl_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/3pl/application/list_page');
	}

	/**
	 * Delete by date (created_at)
	 */
	public function delete_by_date()
	{
		$date = $this->input->post('date');
		if (!$date) {
			return $this->output
				->set_content_type('application/json')
				->set_output(json_encode(['status' => false, 'message' => 'Date is required']));
		}
		$deleted = $this->three_pl_model->delete_by_date($date);
		if ($deleted) {
			$response = ['status' => true, 'message' => 'Records deleted successfully'];
		} else {
			$response = ['status' => false, 'message' => 'No records deleted or invalid date'];
		}
		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function export_rider_applications()
	{
		$this->form_validation->set_rules('column_type', 'Column Type', 'required');
		$this->form_validation->set_rules('file_format', 'Format Type', 'required');

		if ($this->form_validation->run() === FALSE) {
			echo json_encode(["type" => 'error', "message" => validation_errors()]);
			return;
		}

		$column_type = $this->input->post('column_type');
		$file_format = $this->input->post('file_format');
		$search = $this->input->post('searched_value');
		$start_date = $this->input->post('date_from');
		$end_date = $this->input->post('date_to');

		$reportData = $this->three_pl_model->getRiderApplicationsReport($search, $column_type, 'excel', $start_date, $end_date);

		$data['start_date'] = $start_date ? date("d M Y", strtotime($start_date)) : 'NA';
		$data['end_date'] = $end_date ? date("d M Y", strtotime($end_date)) : 'NA';
		$data['searched'] = $search ?: '';

		if (empty($reportData['data'])) {
			echo json_encode(["type" => 'error', "message" => 'No data found']);
			return;
		}

		$filename = "3PL-Rider-Applications";
		if (!empty($start_date) && !empty($end_date)) {
			$filename .= '-' . date('d-M-Y', strtotime($start_date)) . '_to_' . date('d-M-Y', strtotime($end_date));
		}
		$filename .= '.xlsx';

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Header Title
		$sheet->mergeCells('A1:Z1');
		$sheet->setCellValue('A1', '3PL Rider Applications');
		$sheet->getStyle('A1')->applyFromArray([
			'font' => ['bold' => true, 'size' => 14],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		]);

		// Table Headers
		$headerRow = 3;
		$colIndex = 2;
		$sheet->setCellValue('A' . $headerRow, '#');

		foreach ($reportData['available_columns'] as $column) {
			$excelCol = Coordinate::stringFromColumnIndex($colIndex);
			$sheet->setCellValue($excelCol . $headerRow, strtoupper(str_replace('_', ' ', $column)));
			$colIndex++;
		}

		$lastHeaderCol = Coordinate::stringFromColumnIndex($colIndex - 1);
		$sheet->getStyle("A{$headerRow}:{$lastHeaderCol}{$headerRow}")->applyFromArray([
			'font' => ['bold' => true],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => 'FFF5D880']
			]
		]);

		// Table Data
		$rowIndex = $headerRow + 1;
		$serialNumber = 1;

		foreach ($reportData['data'] as $row) {
			$sheet->setCellValue("A" . $rowIndex, $serialNumber++);
			$colIndex = 2;

			foreach ($reportData['available_columns'] as $column) {
				$value = $row[$column] ?? '[NA]';

				// Format dates
				if (in_array($column, ['rider_iqama_expiry', 'dob', 'created_at', 'updated_at']) && !empty($value)) {
					$value = date("d-m-Y", strtotime($value));
				}

				// For file columns, just show filename in Excel
				if (in_array($column, ['iqama_file', 'license_file', 'iban_file', 'photo_file']) && !empty($value)) {
					$value = basename($value);
				}

				$excelCol = Coordinate::stringFromColumnIndex($colIndex);
				$sheet->setCellValue($excelCol . $rowIndex, $value);
				$colIndex++;
			}
			$rowIndex++;
		}

		// Auto-size columns
		for ($i = 1; $i <= Coordinate::columnIndexFromString($lastHeaderCol); $i++) {
			$sheet->getColumnDimension(Coordinate::stringFromColumnIndex($i))->setAutoSize(true);
		}

		// Output Excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$filename}\"");
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
