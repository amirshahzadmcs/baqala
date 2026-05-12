<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dlrequest extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Dlrequest_model','dl_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		}			
		else{				
			redirect('admin/common/login');
		}
	}

    public function index()
	{
		if($this->action && !check_action_permission(get_user_role(), 'dl_request', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/dl_request/index',$data);
	}

	public function add(){
		$this->load->view('admin/dl_request/form');
	}
	
	public function edit(){
		if($this->action && !check_action_permission(get_user_role(), 'dl_request', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$query = $this->dl_model->get_detail($this->input->post('id'));
			if(!empty($query)){
				$data['dl_detail'] = $query;
				$emp_id = $query->emp_id;
				$dl_type = $query->dl_type;
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.mobile, me.email, me.iqama_no, me.status, me.nationality, me.employee_pic, me.department, me.designation, me.payment_type, me.payment_type_detail, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE me.id='". $emp_id ."'")->row_array();
				$id = $this->input->post('id');
				$duplicate_check = $this->dl_model->check_duplicate_employee($id, $data['emp_detail']['id'], $dl_type);
				if($duplicate_check > 0) {
					$result = array("type"=>'error', "message"=>'This Employee ID already exists in DL request. Try New.');
				}else{
					if($data['emp_detail']['payment_type'] == 'Bank'){
						$bankDetail = json_decode($data['emp_detail']['payment_type_detail']);
						$data['iban_no'] = $bankDetail->iban_no;
					}else{
						$data['iban_no'] = '';
					}
					$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$data['emp_detail']['id'] . "'")->row_array();
					$output_data = $this->load->view('admin/dl_request/components/edit-dl-request',$data,TRUE);
					$result = array("type"=>'success', "message"=>'DL request detail successfully fetched.', "output_html"=> $output_data);
				}
			}else{
				$result = array("type"=>'error', "message"=>'DL request detail not found, try again');
			}
		}
		echo json_encode($result);
	}

	public function save(){
		if($this->action && !check_action_permission(get_user_role(), 'dl_request', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('emp_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_rules('dl_type', 'Select Vehicle Type', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required|callback_validate_date_not_future');
		$this->form_validation->set_rules('blood_group', 'Blood Group', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
	
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			// Check DL issuance conditions before proceeding
			$emp_id = $this->input->post('emp_id');
			$dl_type = $this->input->post('dl_type');
	
			// Check if the employee has already applied for any DL
			$existing_dl = $this->db->select('*')
				->from('dl_request')
				->where('emp_id', $emp_id)
				->get()
				->result();
	
			if (!empty($existing_dl)) {
				foreach ($existing_dl as $dl) {
					// Condition 1: Same DL type already applied (can't apply again)
					if ($dl->dl_type == $dl_type) {
						$result = array("type" => 'error', "message" => 'You have already applied for this DL type.');
						echo json_encode($result);
						return;
					}
					// Condition 2: If applying for another type, ensure the previous one is completed
					if ($dl->status != 'Completed') {
						$result = array("type" => 'error', "message" => 'Previous DL request must be completed before applying for another type.');
						echo json_encode($result);
						return;
					}
				}
			}
	
			// Upload attachment if available
			$attachment = $_FILES['attachment']['name'] ? $this->upload_file('attachment') : '';
	
			// Deduction month handling
			$deduction_month = $this->input->post('deduction_month') !== ''
				? date('Y-m-d', strtotime($this->input->post('deduction_month')))
				: '';
	
			// Generate request number
			$last_row = $this->db->select('*')->order_by('id', "desc")->limit(1)->get('dl_request')->row();
			$request_no = accountNoFormat($last_row->id + 1);
	
			// Prepare data
			$data = array(
				'request_no' => $request_no,
				'emp_id' => $emp_id,
				'dl_type' => $dl_type,
				'blood_group' => $this->input->post('blood_group'),
				'request_date' => $this->input->post('request_date'),
				'expenses_by_employee' => $this->input->post('expenses_by_employee'),
				'iban_no' => $this->input->post('iban_no'),
				'deduction_month' => $deduction_month,
				'status' => $this->input->post('status'),
				'reason' => $this->input->post('reason'),
				'attachment' => $attachment,
				'created_at' => CURRENT_TIME
			);
	
			// Save data using the model
			$insert_id = $this->dl_model->add($data);
	
			if ($insert_id) {
				$result = array("type" => 'success', "message" => 'DL request successfully added.');
			} else {
				$result = array("type" => 'error', "message" => 'Something went wrong, try again');
			}
		}
		
		echo json_encode($result);
	}	

	public function upload_file($file) {
		$upload_path = './uploads/dl-docs/';
		
		// Check if the folder exists, if not, create it
		if (!file_exists($upload_path)) {
			mkdir($upload_path, 0777, true); // Recursive directory creation
		}
	
		$config['upload_path']   = $upload_path;
		$config['allowed_types'] = 'doc|docx|jpg|png|jpeg|pdf';
		$config['max_size']      = 0;
		$config['max_width']     = 0;
		$config['max_height']    = 0;
		$config['max_filename']  = '50';
		$config['encrypt_name']  = TRUE;
	
		$this->load->library('upload', $config);
	
		if (!$this->upload->do_upload($file)) {
			// Upload failed, display error
			$error = $this->upload->display_errors();
			return $error;
		} else {
			// Upload successful, get file data
			$file_data = $this->upload->data();
			$image = $upload_path . $file_data['file_name'];
	
			return $image;
		}
	}

	public function update(){
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('emp_id', 'Select Employee', 'trim|required|callback_check_emp_duplicate');
		$this->form_validation->set_message('check_emp_duplicate','Already requested for DL, Try new');
		$this->form_validation->set_rules('dl_type', 'Select Vehicle Type', 'trim|required');
		$this->form_validation->set_rules('request_date', 'Request Date', 'trim|required|callback_validate_date_not_future');
		$this->form_validation->set_rules('blood_group', 'Blood Group', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$id = $this->input->post('id');
			if($_FILES['attachment']['name']){
				$attachment = $this->upload_file('attachment');
			}else{
				$attachment = $this->input->post('old_attachment');
			}
			// Deduction month handling
			$deduction_month = $this->input->post('deduction_month') !== ''
				? date('Y-m-d', strtotime($this->input->post('deduction_month')))
				: '';
			$data = array(
				'dl_type' => $this->input->post('dl_type'),
				'dl_request_type' => $this->input->post('dl_request_type'),
				'blood_group' => $this->input->post('blood_group'),
				'request_date' => $this->input->post('request_date'),
				'expenses_by_employee' => $this->input->post('expenses_by_employee'),
				'iban_no' => $this->input->post('iban_no'),
				'deduction_month' => $deduction_month,
				'status' => $this->input->post('status'),
				'reason' => $this->input->post('reason'),
				'attachment' => $attachment,
				'updated_at' => CURRENT_TIME
			);
			// Save data using the model
			$updated = $this->dl_model->update($id,$data);
			if($updated){
				$result = array("type"=>'success', "message"=>'DL request successfully updated.');
			}else{
				$result = array("type"=>'error', "message"=>'DL request not updated');
			}
		}
		echo json_encode($result);
	}

	public function check_emp_duplicate() {
		$id = $this->input->post('id');
		$emp_id = $this->input->post('emp_id');
		$dl_type = $this->input->post('dl_type');
		$duplicate_check = $this->dl_model->check_duplicate_employee($id, $emp_id, $dl_type);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}
	
	public function validate_date_not_future($date)
	{
		$input_date = strtotime($date);
		$current_date = strtotime(date('Y-m-d'));

		if ($input_date > $current_date) {
			$this->form_validation->set_message('validate_date_not_future', 'The {field} cannot be greater than the current date.');
			return false;
		}
		return true;
	}

	public function detail(){
		if($this->input->get('id')){
			$data['dl_detail'] = $this->dl_model->get_detail($this->input->get('id'));
			$this->load->view('admin/dl_request/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid request or unauthorized access!");
			redirect('admin/dl-request/list');
		}
	}

	public function get_ajax_list(){
		$fetch_data = $this->dl_model->get_list();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$current_status_name = 'DL Requested';
			$current_percentage = '0';
			$trans_status = $key_data->trans_status;
			if($trans_status == '10'){
				$current_status_name = 'DL Requested';
				$current_percentage = '0';
			}
			if($trans_status == '0'){
				$current_status_name = 'DL Appointment';
				$current_percentage = '10';
			}
			if($trans_status == '1'){
				$current_status_name = 'DL File';
				$current_percentage = '20';
			}
			if($trans_status == '2'){
				$current_status_name = 'DL Class 1';
				$current_percentage = '30';
			}
			if($trans_status == '3'){
				$current_status_name = 'DL Class 2';
				$current_percentage = '40';
			}
			if($trans_status == '4'){
				$current_status_name = 'DL Computer Exam';
				$current_percentage = '50';
			}
			if($trans_status == '5'){
				$current_status_name = 'DL Final Test';
				$current_percentage = '60';
			}
			if($trans_status == '6'){
				$current_status_name = 'DL Repeat Exam';
				$current_percentage = '70';
			}
			if($trans_status == '7'){
				$current_status_name = 'DL Medical';
				$current_percentage = '80';
			}
			if($trans_status == '8'){
				$current_status_name = 'DL Basma';
				$current_percentage = '90';
			}
			if($trans_status == '9'){
				$current_status_name = 'Dl Issued';
				$current_percentage = '100';
			}
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$key_data->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->request_no;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = $key_data->iqama_no;
			$sub_array[] = $key_data->profession_name;
			$sub_array[] = ($key_data->sim_mobile_number == '') ? 'NA' : $key_data->sim_mobile_number;
			$sub_array[] = ucfirst($key_data->dl_type);
			if($key_data->status == 'Cancelled'){
				$sub_array[] = '<span class="badge badge-pill badge-soft-danger font-size-13">'. $key_data->status .'</span>';
			}else{
				if($trans_status == '9'){
					$sub_array[] = '<div class="dl-progress"><div class="bar bg-success" style="width:'.$current_percentage.'%"><p class="percent">'.$current_percentage.'%</p></div></div><div class="text-center mt-1">'. $current_status_name .'</div>';
				}else{
					$sub_array[] = check_action_permission(get_user_role(),'dl_request','add_trans_form') ? '<div class="small text-center">Click to change...</div><div class="dl-progress" onclick="updateStatus(\''. $key_data->id .'\')"><div class="bar" style="width:'.$current_percentage.'%"><p class="percent">'.$current_percentage.'%</p></div></div><div class="text-center mt-1">'. $current_status_name .'</div>' : '';
				}
			}
			if($key_data->status == 'Cancelled'){
				$sub_array[] = (!empty($key_data->updated_at)) ? date('d-m-Y', strtotime($key_data->updated_at)) : 'NA';
			}else{
				$sub_array[] = (!empty($key_data->transaction_date)) ? date('d-m-Y', strtotime($key_data->transaction_date)) : 'NA';
			}
			$sub_array[] = (!empty($key_data->sponsor_name)) ? $key_data->sponsor_name : 'NA';
			$sub_array[] = $key_data->blood_group;
			$sub_array[] = date('d-m-Y', strtotime($key_data->request_date));
			/*
			$sub_array[] = $key_data->nationality_name;
			$sub_array[] = ($key_data->department_name == '') ? 'NA' : $key_data->department_name;
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			*/
			//$sub_array[] = (!empty($key_data->updated_at)) ? date('d-m-Y h i:A', strtotime($key_data->updated_at)) : 'NA';
			$actions = '';

			if (check_action_permission(get_user_role(), 'dl_request', 'edit')) {
				if ($key_data->trans_status != '9' && $key_data->status != 'Cancelled') {
					$actions .= '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" onclick="editRequest(' . $key_data->id . ')"><i class="mdi mdi-pencil font-size-18"></i></button> ';
					$actions .= '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit Amount" onclick="editTransaction(' . $key_data->id . ')"><i class="mdi mdi-clipboard-edit-outline font-size-18"></i></button> ';
				}

				$actions .= '<a href="' . base_url('admin/dl-request/print/' . $key_data->id) . '" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Print" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>';
			}

			$sub_array[] = $actions;
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->dl_model->get_all_data(),  
			"recordsFiltered"     =>     $this->dl_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function ajax_check_empid() {
		$emp_id = $this->input->get('emp_id');
		$id = '';
		$dl_type = '';
		if($emp_id !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->dl_model->check_duplicate_employee($id, $emp_id, $dl_type);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $emp_id . "</b> This Employee ID already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Employee ID Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Employee ID is required.</span>";
		}
		echo json_encode($data);
	}

	public function delete(){
		if($this->action && !check_action_permission(get_user_role(), 'dl_request', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$ids = $this->input->post('checklist');
		$query = $this->dl_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/dl-request/list');
	}

	public function add_trans_form()
    {
		if($this->action && !check_action_permission(get_user_role(), 'dl_request', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$id = $this->input->post('request_id');
			$req_dl = $this->dl_model->get_detail($id);
			if(empty($req_dl)){
				$result = array("type"=>'error', "message"=>'No detail not found, try again');
			}else{
				$data['dl_detail'] = $req_dl;
				$data['last_transaction_detail'] = $this->dl_model->get_last_transaction($id);
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$data['dl_detail']->emp_id . "'")->row();
				$output_data = $this->load->view('admin/dl_request/status-form',$data,TRUE);
				$result = array("type"=>'success', "message"=>'Employee detail successfully fetched.', "output_html"=> $output_data);
			}
		}
		echo json_encode($result);
    }

	public function edit_trans_form()
    {
		if($this->action && !check_action_permission(get_user_role(), 'dl_request', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('request_id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$id = $this->input->post('request_id');
			$req_dl = $this->dl_model->get_detail($id);
			if(empty($req_dl)){
				$result = array("type"=>'error', "message"=>'No detail not found, try again');
			}else{
				$data['dl_detail'] = $req_dl;
				$data['transaction_list'] = $this->dl_model->get_transaction_list($id);
				//dd($data['transaction_list']);
				$output_data = $this->load->view('admin/dl_request/components/edit-transactions',$data,TRUE);
				$result = array("type"=>'success', "message"=>'Transaction detail successfully fetched.', "output_html"=> $output_data);
			}
		}
		echo json_encode($result);
    }

	public function update_amount() {
		if ($this->input->is_ajax_request()) {
			$id = $this->input->post('id');
			$amount = $this->input->post('trans_amount');
	
			// Validate input
			if (empty($id)) {
				echo json_encode(['status' => 'error', 'message' => 'Transaction ID is required.']);
				return;
			}
	
			if ($amount === null || $amount === '') {
				echo json_encode(['status' => 'error', 'message' => 'Amount is required.']);
				return;
			}
	
			if (!is_numeric($amount)) {
				echo json_encode(['status' => 'error', 'message' => 'Amount must be a number.']);
				return;
			}
	
			// Optional: check if the ID exists in DB
			$exists = $this->db->where('id', $id)->count_all_results('dl_transactions');
			if (!$exists) {
				echo json_encode(['status' => 'error', 'message' => 'Transaction not found.']);
				return;
			}
	
			// Proceed with update
			if ($this->dl_model->updateAmount($id, $amount)) {
				echo json_encode(['status' => 'success', 'message' => 'Amount successfully updated.']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Update failed. Please try again.']);
			}
		} else {
			show_404();
		}
	}
	
	public function get_employee_detail()
    {
		$this->form_validation->set_rules('search_employee', 'Employee No.', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$emp_no = $this->input->post('search_employee');
			$query = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.mobile, me.email, me.iqama_no, me.status, me.nationality, me.employee_pic, me.department, me.designation, me.payment_type, me.payment_type_detail, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE me.emp_no='". $emp_no ."'");
			if($query->num_rows() > 0){
				$data['emp_detail'] = $query->row_array();
				$id = '';
				$dl_type = '';
				$duplicate_check = $this->dl_model->check_duplicate_employee($id, $data['emp_detail']['id'], $dl_type);
				if($duplicate_check > 0) {
					$result = array("type"=>'error', "message"=>'This Employee ID already exists in DL request. Try New.');
				}else{
					if($data['emp_detail']['payment_type'] == 'Bank'){
						$bankDetail = json_decode($data['emp_detail']['payment_type_detail']);
						$data['iban_no'] = $bankDetail->iban_no;
					}else{
						$data['iban_no'] = '';
					}
					$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$data['emp_detail']['id'] . "'")->row_array();
					$output_data = $this->load->view('admin/dl_request/components/dl-request',$data,TRUE);
					$result = array("type"=>'success', "message"=>'Employee detail successfully fetched.', "output_html"=> $output_data);
				}
			}else{
				$result = array("type"=>'error', "message"=>'Employee detail not found, try again');
			}
		}
		echo json_encode($result);
    }

	public function print_dl_request($id)
	{
		$this->load->library('Pdf_employee_offer');
		$data['request_detail'] = $this->dl_model->print_detail($id);
		//dd($data['request_detail']);
		if ($data['request_detail'] !== '') {
			$dl_req_no = $data['request_detail']['request_no'];
			$dl_status = $data['request_detail']['status'];
			$data['dl_transactions'] = $this->dl_model->get_transaction_list($id);
			//dd($data);
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Driving Licence Request Form');
			$pdf->SetSubject('BS - Driving Licence Request Form');
			$pdf->SetKeywords('Baqala Station, PDF, Driving Licence Request Form, Employee');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);
			// set auto page breaks
			//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
				require_once(dirname(__FILE__) . '/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage();
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);
			$pdf->SetFont('aealarabiya', '', 10);

			// Save original position
			$original_y = $pdf->GetY();

			// Draw watermark
			if (strtolower($dl_status) === 'cancelled') {
				$pdf->SetAlpha(0.1);
				$pdf->SetFont('helvetica', 'B', 90);
				$pdf->SetTextColor(255, 102, 102);

				$pageWidth = $pdf->getPageWidth();
				$pageHeight = $pdf->getPageHeight();

				$x = 100;
				$y = 100;

				$pdf->StartTransform();
				$pdf->Rotate(35, $x, $y);
				$pdf->Text($x - 90, $y, 'CANCELLED', false, false, true, 0, 0, '', false, '', 0, false, 'M', 'M');
				$pdf->StopTransform();

				$pdf->SetAlpha(1);
				$pdf->SetTextColor(0, 0, 0);
				$pdf->SetFont('aealarabiya', '', 10);
			}

			// Restore Y
			$pdf->SetY($original_y);

			
			// Arabic and English content
			$htmlcontent = $this->load->view('admin/dl_request/print/dl_request', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Driving Licence Request Form-'. $dl_req_no .'.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--DL request detail not found!");
			redirect('admin/dl-request/list');
		}
	}
	
	public function export_dl_request_excel()
	{
		$records = $this->dl_model->get_export_list();

		// Load PhpSpreadsheet
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// --- Title ---
		$sheet->setCellValue('A1', "Driving Licence Status Report");
		$sheet->mergeCells("A1:S1");
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A1')->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setRGB('99CCFF'); // light blue background for title

		// --- Header Row ---
		$headers = [
			"#", "Request Date", "Emp ID", "Emp Name", "Iqama No", "Profession", "Mobile No", 
			"DL Type", "DL Request Type", "Dallah Location", "DL Trans. Status", "DL Trans. Date", 
			"Employer", "Blood Group", "Bank Name", "Bank IBAN", "DL File", "DL Medical", "DL Issued"
		];

		$col = 1;
		foreach ($headers as $head) {
			$sheet->setCellValueByColumnAndRow($col, 3, $head);
			$sheet->getStyleByColumnAndRow($col, 3)->getFont()->setBold(true);
			$sheet->getStyleByColumnAndRow($col, 3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$col++;
		}

		// Apply sky blue background to header
		$sheet->getStyle("A3:" . $sheet->getCellByColumnAndRow(count($headers), 3)->getColumn() . "3")
			->getFill()
			->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
			->getStartColor()->setRGB('ffeb9c'); // Sky Blue

		// --- Data Rows ---
		$rowNum = 4;
		$i = 1;
		foreach ($records as $row) {
			$sheet->setCellValue("A{$rowNum}", $i++);
			$sheet->setCellValue("B{$rowNum}", date('d-M-Y', strtotime($row['request_date'] ?? '')));
			$sheet->setCellValue("C{$rowNum}", $row['emp_no']);
			$sheet->setCellValue("D{$rowNum}", $row['full_name']);
			$sheet->setCellValue("E{$rowNum}", $row['iqama_no']);
			$sheet->setCellValue("F{$rowNum}", $row['profession_name']);
			$sheet->setCellValue("G{$rowNum}", $row['sim_mobile_number']);
			$sheet->setCellValue("H{$rowNum}", ucfirst($row['dl_type'] ?? ''));
			$sheet->setCellValue("I{$rowNum}", ucfirst($row['dl_request_type'] ?? '') . '');
			$sheet->setCellValue("J{$rowNum}", $row['dallah_location']);
			// 🔹 Map trans_status
			$trans_status = $row['trans_status'] ?? '';
			$current_status_name = '';
			$trans_date = '';

			switch ($trans_status) {
				case '10': $current_status_name = 'DL Requested'; break;
				case '0':  $current_status_name = 'DL Appointment'; break;
				case '1':  $current_status_name = 'DL File'; break;
				case '2':  $current_status_name = 'DL Class 1'; break;
				case '3':  $current_status_name = 'DL Class 2'; break;
				case '4':  $current_status_name = 'DL Computer Exam'; break;
				case '5':  $current_status_name = 'DL Final Test'; break;
				case '6':  $current_status_name = 'DL Repeat Exam'; break;
				case '7':  $current_status_name = 'DL Medical'; break;
				case '8':  $current_status_name = 'DL Basma'; break;
				case '9':  $current_status_name = 'DL Issued'; break;
				default:   $current_status_name = 'Unknown'; break;
			}
			if($row['status'] == 'Cancelled'){
				$current_status_name = 'Cancelled';
				$trans_date = !empty($row['updated_at']) ? date('d-M-Y', strtotime($row['updated_at'])) : '';
			}else{
				$trans_date = !empty($row['transaction_date']) ? date('d-M-Y', strtotime($row['transaction_date'])) : '';
			}
			$sheet->setCellValue("K{$rowNum}", $current_status_name);
			$sheet->setCellValue("L{$rowNum}", $trans_date);
			$sheet->setCellValue("M{$rowNum}", $row['sponsor_name']);
			$sheet->setCellValue("N{$rowNum}", $row['blood_group']);
			// 🔹 Decode payment_type_detail JSON
			$bank_name = '';
			$iban_no = '';
			if (!empty($row['payment_type_detail'])) {
				$payment_detail = json_decode($row['payment_type_detail'], true);
				if (json_last_error() === JSON_ERROR_NONE) {
					$bank_name = $payment_detail['bank_name'] ?? '';
					$iban_no = $payment_detail['iban_no'] ?? '';
				}
			}

			$sheet->setCellValue("O{$rowNum}", $bank_name);
			$sheet->setCellValue("P{$rowNum}", $iban_no);
			$sheet->setCellValue("Q{$rowNum}", $row['dl_file_amount'] ?? '');
			$sheet->setCellValue("R{$rowNum}", $row['dl_medical_amount'] ?? '');
			$sheet->setCellValue("S{$rowNum}", $row['dl_issued_amount'] ?? '');
			$rowNum++;
		}

		// --- Style Adjustments ---
		foreach (range('A', 'S') as $colLetter) {
			$sheet->getColumnDimension($colLetter)->setAutoSize(true);
		}

		$sheet->getStyle("A3:S3")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle("A4:S" . ($rowNum - 1))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR);

		// --- Output Excel ---
		$filename = 'Driving_Licence_Status_Report_' . date('Ymd_His') . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}

