<?php defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Department extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr/master/Department_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'departments', $action) && !in_array($action, ['save', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
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
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/department/index', $data);
	}


	public function add()
	{
		if ($this->input->get('id')) {
			$query = $this->Department_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['name_ar'] = $query->name_ar;
			$data['abbreviation'] = $query->abbreviation;
			$data['abbreviation_ar'] = $query->abbreviation_ar;
			$data['description'] = $query->description;
			$data['status'] = $query->status;
			$data['assigned_manager'] = $query->assigned_manager;
		} else {
			$data['id'] = "";
			$data['name'] = "";
			$data['name_ar'] = "";
			$data['abbreviation'] = "";
			$data['abbreviation_ar'] = "";
			$data['description'] = "";
			$data['status'] = "";
			$data['assigned_manager'] = "";
		}

		// print_r($data['nationality_no']);exit();
		$this->load->view('admin/hr/master/department/form', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Department_model->edit();
			} else {
				$query = $this->Department_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/department');
	}

	public function detail()
	{
		if ($this->input->get('id')) {
			$query = $this->Department_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['name_ar'] = $query->name_ar;
			$data['abbreviation'] = $query->abbreviation;
			$data['abbreviation_ar'] = $query->abbreviation_ar;
			$data['description'] = $query->description;
			$data['status'] = $query->status;
			$data['assigned_manager'] = $query->assigned_manager;

			$this->load->view('admin/hr/master/department/detail', $data);
		} else {
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/master/department');
		}
	}

	public function get_list()
	{
		$fetch_data = $this->Department_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $store) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $store->id . '" />';
			$sub_array[] = $store->id;
			$sub_array[] = $store->name;
			$sub_array[] = $store->name_ar;
			$sub_array[] = $store->abbreviation;
			$sub_array[] = $store->manager_name;
			$sub_array[] = ($store->total_employee > 0) 
			? '<a type="button" class="border-bottom border-success" title="View" onclick="viewAllotments('.$store->id.')">' . $store->total_employee . '</a>' 
			: 0;
			$sub_array[] = $store->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			$sub_array[] = check_action_permission(get_user_role(), 'departments', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/hr/master/department/add?id=' . $store->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Department_model->get_all_data(),
			"recordsFiltered"     =>     $this->Department_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Department_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/department');
	}
	
	public function get_employee_list()
    {
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$id = $this->input->post('id');
			$query = $this->Department_model->get_detail($id);
			if($query){
				$data['detail'] = $query;
				$data['dept_employee_list'] = $this->Department_model->getDeptEmpList($id);
				//dd($data['dept_employee_list']);
				$output_data = $this->load->view('admin/hr/master/department/employee_list',$data,TRUE);
				$result = array("type"=>'success', "message"=>'List successfully fetched.', "output_html"=> $output_data);
			}else{
				$result = array("type"=>'success', "message"=>'List not found.');
			}
		}
		echo json_encode($result);
    }
	
	public function export_employee_excel($dept_id)
	{
		$dept_detail = $this->Department_model->get_detail($dept_id);
		$employees = $this->Department_model->getDeptEmpList($dept_id);

		$department_name = $dept_detail->name;
		$department_name_ar = $dept_detail->name_ar;

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// 👉 Set the main heading in the first row
		$title = "Employee List - $department_name ($department_name_ar)";
		$sheet->mergeCells('A1:I1'); // Merge across all columns
		$sheet->setCellValue('A1', $title);

		// Optional: Bold & Center the heading
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// 👉 Table Headers in row 2
		$sheet->setCellValue('A2', 'Emp No');
		$sheet->setCellValue('B2', 'Full Name');
		$sheet->setCellValue('C2', 'Arabic Name');
		$sheet->setCellValue('D2', 'Iqama No');
		$sheet->setCellValue('E2', 'Email');
		$sheet->setCellValue('F2', 'Passport No');
		$sheet->setCellValue('G2', 'Nationality');
		$sheet->setCellValue('H2', 'Designation');
		$sheet->setCellValue('I2', 'Status');

		// 👉 Add background color & style
		$sheet->getStyle('A2:I2')->getFont()->setBold(true);
		$sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
										->getStartColor()->setARGB('FFD9E1F2');

		// 👉 Start populating data from row 3
		$row = 3;
		foreach ($employees as $emp) {
			$sheet->setCellValue("A$row", $emp['emp_no']);
			$sheet->setCellValue("B$row", $emp['full_name']);
			$sheet->setCellValue("C$row", $emp['employee_arabic_name']);
			$sheet->setCellValue("D$row", ' '.$emp['iqama_no']);
			$sheet->setCellValue("E$row", $emp['email']);
			$sheet->setCellValue("F$row", $emp['passport_no']);
			$sheet->setCellValue("G$row", $emp['nationality_name']);
			$sheet->setCellValue("H$row", $emp['designation_name']);
			$sheet->setCellValue("I$row", $emp['emp_status']);
			$row++;
		}

		// Download
		$filename = 'Employee_List_Dept_' . $department_name . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}

	public function print_employee_list($dept_id)
	{
		$this->load->library('Pdf_general'); // assuming you extended TCPDF as a CI library

		$dept = $this->Department_model->get_detail($dept_id);
		$employees = $this->Department_model->getDeptEmpList($dept_id);
		$pdf = new Pdf_general('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Employee List');
		$pdf->SetSubject('Department Employee Report');
		$pdf->SetPrintHeader(false);
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->AddPage();

		$html = '<h3></h3>';
		$html .= '<table border="1" cellspacing="0" cellpadding="4" style="font-size:8px; width:100%; border-collapse:collapse;">
					<tr>
						<td colspan="8" style="text-align:center; font-weight:bold;"><h3>Employee List - ' . $dept->name . '</h3></td>
					</tr>
					<thead>
						<tr style="background-color:#f2f2f2;">
							<th style="width:7%"><b>Emp No</b></th>
							<th style="width:26%"><b>Full Name</b></th>
							<th style="width:10%"><b>Iqama No</b></th>
							<th style="width:19%"><b>Email</b></th>
							<th style="width:10%"><b>Passport No</b></th>
							<th style="width:9%"><b>Nationality</b></th>
							<th style="width:10%"><b>Designation</b></th>
							<th style="width:9%"><b>Status</b></th>
						</tr>
					</thead><tbody>';

		foreach ($employees as $emp) {
			$html .= '<tr>
						<td style="width:7%">' . $emp['emp_no'] . '</td>
						<td style="width:26%">' . $emp['full_name'] . '</td>
						<td style="width:10%">' . $emp['iqama_no'] . '</td>
						<td style="width:19%">' . $emp['email'] . '</td>
						<td style="width:10%">' . $emp['passport_no'] . '</td>
						<td style="width:9%">' . $emp['nationality_name'] . '</td>
						<td style="width:10%">' . $emp['designation_name'] . '</td>
						<td style="width:9%">' . $emp['emp_status'] . '</td>
					</tr>';
		}

		$html .= '</tbody></table>';

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('Employee_List_Dept_' . $dept->name . '.pdf', 'I'); // or 'D' for download
	}
}
