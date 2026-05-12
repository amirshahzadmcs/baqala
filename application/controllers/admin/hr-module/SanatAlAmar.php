<?php defined('BASEPATH') or exit('No direct script access allowed');

class SanatAlAmar extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/hr-module/SanatAlAmar_model', 'sanatalamar_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
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
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
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
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr-module/sanat-al-amar/index', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view('admin/hr-module/sanat-al-amar/components/search-form');
	}

	public function edit()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->sanatalamar_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['transaction'] = $query->row_array();
				$emp_id = $data['transaction']['employee_id'];
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '". $emp_id ."')")->row_array();
				$output_data = $this->load->view('admin/hr-module/sanat-al-amar/components/edit-form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Sanat Al Amar detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Sanat Al Amar detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function get_employee_detail()
	{
		$this->form_validation->set_rules('search_employee', 'Employee ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$emp_no = $this->input->post('search_employee');
			$query = $this->db->query("SELECT me.id as employee_id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.status = 'Active' AND me.emp_no ='" . $emp_no . "')");
			if ($query->num_rows() > 0) {
				$data['emp_detail'] = $query->row_array();
				$emp_id = $data['emp_detail']['employee_id'];
				$data['other_detail'] = $this->db->query("SELECT driving_license_number FROM master_employee_info WHERE employee_id = '" . (int)$emp_id . "'")->row_array();
				$data['vehicle_detail'] = $this->db->query("SELECT mv.id, mv.vehicle_type, mv.vehicle_no, mv.vehicle_year, mv.vehicle_make, mv.vehicle_model, mv.gps_device_serial, mvk.make_name FROM master_vehicles mv LEFT JOIN mater_van_make mvk ON (mvk.id = mv.vehicle_make) WHERE mv.alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['sim_detail'] = $this->db->query("SELECT mobile, sim_no, sim_type, alloted_user, status FROM sim_card WHERE alloted_user = '" . (int)$emp_id . "'")->row_array();
				$data['insurance_detail'] = $this->db->query("SELECT mei.employee_id, mei.insurance_company_name, mei.insurance_policy_no, mei.insurance_issue_date, mei.insurance_end_date, mei.category, mei.medical_attachment, mic.company_name as insurance_company FROM master_employee_info mei LEFT JOIN master_insurance_company as mic ON (mei.insurance_company_name = mic.id) WHERE mei.employee_id='" . $emp_id . "'")->row_array();

				$output_data = $this->load->view('admin/hr-module/sanat-al-amar/components/employee-detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Rider detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Rider detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function save()
	{
		// Set validation rules
		$this->form_validation->set_rules('employee_id', 'Select Employee', 'trim|required');
		$this->form_validation->set_rules('sanat_date', 'Sanat Date', 'trim|required');
		$this->form_validation->set_rules(
			'sanat_no',
			'Sanat Number',
			'trim|required|exact_length[16]|numeric',
			array(
				'exact_length' => 'The {field} must be exactly 16 digits long.',
				'numeric' => 'The {field} must contain only numbers.'
			)
		);
		$this->form_validation->set_rules('sanat_owner', 'Sanat Owner', 'trim|required');
		$this->form_validation->set_rules('sanat_amount', 'Sanat Amount', 'trim|required');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			// If validation fails, return errors
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$employee_id = $this->input->post('employee_id');
			$sanat_no = $this->input->post('sanat_no');
			$current_time = date('Y-m-d H:i:s');
			$attachment = '';

			// Check for file upload
			if ($_FILES['attachment']['name']) {
				$attachment = $this->upload_file('attachment');
			}

			// Check for duplicate entry
			$duplicate_check = $this->sanatalamar_model->checkDuplicate($employee_id, $sanat_no);
			if ($duplicate_check) {
				$result = array("type" => 'error', "message" => 'Duplicate entry: This Employee ID or Sanat Number already exist.');
			} else {
				// Prepare data for insertion
				$data = array(
					'employee_id' => $employee_id,
					'sanat_date' => $this->input->post('sanat_date'),
					'sanat_no' => $sanat_no,
					'sanat_amount' => $this->input->post('sanat_amount'),
					'sanat_owner' => $this->input->post('sanat_owner'),
					'description' => $this->input->post('description'),
					'status' => 'open',
					'attachment' => $attachment,
					'created_at' => $current_time
				);

				// Save data using the model
				$query = $this->sanatalamar_model->insertSanat($data);
				if ($query) {
					$result = array("type" => 'success', "message" => 'Sanat Al Amar successfully added.');
				} else {
					$result = array("type" => 'error', "message" => 'Something went wrong, try again.');
				}
			}
		}
		echo json_encode($result);
		return;
	}

	public function upload_file($file)
	{
		$upload_path = './uploads/sanat_al_amar/';

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

	public function update()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('sanat_date', 'Sanat Date', 'trim|required');
		$this->form_validation->set_rules('status', 'Sanat Status', 'trim|required');
		$this->form_validation->set_rules(
			'sanat_no',
			'Sanat Number',
			'trim|required|exact_length[16]|numeric',
			array(
				'exact_length' => 'The {field} must be exactly 16 digits long.',
				'numeric' => 'The {field} must contain only numbers.'
			)
		);
		$this->form_validation->set_rules('sanat_owner', 'Sanat Owner', 'trim|required');
		$this->form_validation->set_rules('sanat_amount', 'Sanat Amount', 'trim|required');
		if ($this->input->post('status') == 'activated') {
			$this->form_validation->set_rules('activation_date', 'Activation Date', 'trim|required');
		} elseif ($this->input->post('status') == 'cancelled') {
			$this->form_validation->set_rules('cancellation_date', 'Cancellation Date', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$employee_id = $this->input->post('employee_id');
			$sanat_no = $this->input->post('sanat_no');
			$current_time = date('Y-m-d H:i:s');
			$attachment = '';
			// Handle file upload if file is present
			if ($_FILES['attachment']['name']) {
				$attachment = $this->upload_file('attachment');
			} else {
				$attachment = $this->input->post('attachment_old');
			}
			// Duplicate check for updates
			$duplicate_check = $this->sanatalamar_model->checkDuplicateOnUpdate($employee_id, $sanat_no, $id);
			if ($duplicate_check) {
				$result = array("type" => 'error', "message" => 'Duplicate entry: This Employee ID or Sanat Number already exist for another record.');
			} else {
				$data = array(
					'sanat_date' => $this->input->post('sanat_date'),
					'sanat_amount' => $this->input->post('sanat_amount'),
					'sanat_no' => $this->input->post('sanat_no'),
					'sanat_owner' => $this->input->post('sanat_owner'),
					'description' => $this->input->post('description'),
					'status' => $this->input->post('status'),
					'attachment' => $attachment,
					'updated_at' => CURRENT_TIME
				);
				if ($this->input->post('status') == 'activated') {
					$data['activation_date'] = $this->input->post('activation_date');
				} elseif ($this->input->post('status') == 'cancelled') {
					$data['cancellation_date'] = $this->input->post('cancellation_date');
				}
				// Save data using the model
				$updated = $this->sanatalamar_model->updateSanat($id, $data);
				if ($updated) {
					$result = array("type" => 'success', "message" => 'Sanat Al Amar successfully updated.');
				} else {
					$result = array("type" => 'error', "message" => 'Sanat Al Amar not updated');
				}
			}
		}
		echo json_encode($result);
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->sanatalamar_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['transaction'] = $query->row_array();
				$data['emp_detail'] = $this->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.iqama_no, me.status, me.nationality, me.employee_pic, me.mobile, mjt.name as designation_name, md.name as department_name, mn.name as nationality_name FROM master_employee me LEFT JOIN master_nationality as mn ON (me.nationality = mn.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE (me.id = '". $data['transaction']['employee_id'] ."')")->row_array();
				$output_data = $this->load->view('admin/hr-module/sanat-al-amar/components/detail', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Sanat Al Amar detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'error', "message" => 'Sanat Al Amar detail not found, try another employee number.');
			}
		}
		echo json_encode($result);
	}

	public function get_ajax_list()
	{
		$fetch_data = $this->sanatalamar_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $key_data) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $key_data['id'] . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data['sanat_no'];
			$sub_array[] = $key_data['emp_no'];
			$sub_array[] = ucfirst($key_data['full_name']);
			$sub_array[] = $key_data['iqama_no'];
			if (
				$key_data['sanat_date'] !== '' &&
				$key_data['sanat_date'] !== '0000-00-00' &&
				$key_data['sanat_date'] !== NULL
			) {
				$sanatDate = date('d-m-Y', strtotime($key_data['sanat_date']));
			} else {
				$sanatDate = 'NA';
			}
			$sub_array[] = $sanatDate;
			$sub_array[] = $key_data['sanat_amount'];
			$sub_array[] = $key_data['sanat_owner'];
			// Add status with badge
			$status = '';
			switch ($key_data['status']) {
				case 'open':
					$status = '<span class="badge badge-pill badge-soft-primary font-size-13">Open</span>';
					break;
				case 'activated':
					$status = '<span class="badge badge-pill badge-soft-success font-size-13">Activated</span>';
					break;
				case 'cancelled':
					$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Cancelled</span>';
					break;
				default:
					$status = '<span class="badge badge-pill badge-soft-secondary font-size-13">Unknown</span>';
					break;
			}
			$sub_array[] = $status;
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data['created_at']));
			$sub_array[] = (!empty($key_data['updated_at'])) ? date('d-m-Y h:i:A', strtotime($key_data['updated_at'])) : 'NA';
			$edit_button = '';
			if (check_action_permission(get_user_role(), 'sanat_al_amar', 'edit') && $key_data['status'] != 'cancelled') {
				$edit_button = '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit load_edit_modal" title="Edit" onclick="editModal(' . $key_data['id'] . ')"><i class="mdi mdi-pencil font-size-18"></i></button>';
			}

			$detail_button = '';
			if (check_action_permission(get_user_role(), 'sanat_al_amar', 'detail')) {
				$detail_button = '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="detailModal(' . $key_data['id'] . ')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button>';
			}
			
			$download_button = '';
			if (!empty($key_data['attachment'])) {
				$download_button = '<a href="' . base_url($key_data['attachment']) . '" download class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Download"><i class="mdi mdi-download font-size-18"></i></a>';
			}
			
			$sub_array[] = $edit_button . $detail_button . $download_button;

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->sanatalamar_model->get_all_data(),
			"recordsFiltered"     =>     $this->sanatalamar_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->sanatalamar_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr-module/sanat-al-amar/list');
	}
	
	public function exportToPDF()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'sanat_al_amar', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		ini_set('memory_limit', '512M');
		set_time_limit(300);

		$data['sanat_list'] = $this->sanatalamar_model->sanat_print_list();
		if (count($data['sanat_list']) == 0) {
			$this->session->set_userdata('info', "2--Data not found!");
			redirect('admin/hr-module/sanat-al-amar/list');
		}
		$this->load->library('Pdf_hunger_report2');
		$data['admin'] = 'Amanullah Kazi';
		//dd($emp_data);
		// Create new PDF document
		$pdf = new Pdf_hunger_report2(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Maha Al Fala');
		$pdf->SetTitle('Sanat Al Amar - ' . date('Ymd_His'));
		$pdf->SetSubject('Sanat Al Amar - ' . date('Ymd_His'));
		$pdf->SetKeywords('Maha Al Fala, PDF, Sanat Al Amar');

		// Load header/footer
		$htmlHeader = $this->load->view('admin/hr-module/sanat-al-amar/print/header', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader); 
		$lastFooter = $this->load->view('admin/hr-module/sanat-al-amar/print/footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(4, 10, 4, true);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(8);
		$pdf->SetAutoPageBreak(true, 15);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		$pdf->AddPage('P', 'A4');
		$pdf->setRTL(false);
		$pdf->Ln();
		$pdf->SetFont('aealarabiya', '', 8);

		$htmlcontent = $this->load->view('admin/hr-module/sanat-al-amar/print/print_sanat', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

		$pdf->Output('BS-sanat-al-amar-' . date('Ymd_His') . '.pdf', 'I');
	}
}
