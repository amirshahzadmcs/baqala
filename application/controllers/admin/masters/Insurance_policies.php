<?php defined('BASEPATH') or exit('No direct script access allowed');

class Insurance_policies extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/masters/InsurancePolicies_model', 'policies_model');
			$this->load->model('admin/masters/Insurance_comp_model', 'company_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if ($action && !check_action_permission(get_user_role(), 'insurance_policies', $action) && !in_array($action, ['update', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		} else {
			redirect('admin/login');
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
		$data['company_list'] = $this->company_model->company_list();
		return $this->load->view('admin/masters/insurance_policies/list', $data);
	}

	public function get_list(){
		$fetch_data = $this->policies_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $cat){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $cat->id .'" name="check_list[]" />';
			$sub_array[] = $cat->company_name;
			$sub_array[] = $cat->policy_number;
			$sub_array[] = $cat->policy_type;
			$sub_array[] = formatedDate($cat->policy_expiry);
			$sub_array[] = ($cat->used_policies_count > 0) 
			? '<a type="button" class="border-bottom border-success" title="View" onclick="viewAllotments('.$cat->id.')">' . $cat->used_policies_count . '</a>' 
			: 0;
			// Get current date and policy expiry date as timestamps
			$current_date = strtotime(date('Y-m-d'));
			$expiry_date = strtotime($cat->policy_expiry);
	
			// Calculate the difference in days between the current date and the expiry date
			$days_remaining = ($expiry_date - $current_date) / (60 * 60 * 24);
	
			if ($expiry_date >= $current_date) {
				// Policy is valid
				if ($days_remaining <= 30) {
					$sub_array[] = '<span class="badge badge-pill badge-soft-warning font-size-13">Valid <i class="mdi mdi-clock-outline"></i></span>';
				} else {
					$sub_array[] = '<span class="badge badge-pill badge-soft-success font-size-13">Valid</span>';
				}
			} else {
				$sub_array[] = '<span class="badge badge-pill badge-soft-danger font-size-13">Expired</span>';
			}
			$sub_array[] = formatedDateTime($cat->created_at);
			$sub_array[] = ($cat->updated_at !== '' && $cat->updated_at !== NULL) ?  formatedDateTime($cat->updated_at) : 'NA';
			$sub_array[] = '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" data-id="'.$cat->id.'" onclick="editModal('.$cat->id.')"><i class="mdi mdi-pencil font-size-18"></i></button> <a href="'. base_url('admin/master/insurance-policies/print-allotments/'.$cat->id) .'" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Print" target="_blank"><i class="mdi mdi-printer font-size-18"></i></a>';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->policies_model->get_all_data(),  
			"recordsFiltered"     =>     $this->policies_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function add()
	{
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$result = array("type" => 'error', "message" => validation_errors());
		} else {
			$id = $this->input->post('id');
			$query = $this->policies_model->get_detail($id);
			if ($query->num_rows() > 0) {
				$data['detail'] = $query->row();
				$data['company_list'] = $this->company_model->company_list();
				$output_data = $this->load->view('admin/masters/insurance_policies/form', $data, TRUE);
				$result = array("type" => 'success', "message" => 'Policy detail successfully fetched.', "output_html" => $output_data);
			} else {
				$result = array("type" => 'success', "message" => 'Policy detail not found.');
			}
		}
		echo json_encode($result);
	}

	public function view_allotments()
    {
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$id = $this->input->post('id');
			$query = $this->policies_model->get_detail($id);
			if($query->num_rows() > 0){
				$data['detail'] = $query->row();
				$policyType = $data['detail']->policy_type;
				if($policyType === 'Employee'){
					$data['allotments_list'] = $this->policies_model->getPolicyAllotments($id, $policyType);
					$output_data = $this->load->view('admin/masters/insurance_policies/alloted_employees',$data,TRUE);
				}else{
					$data['allotments_list'] = $this->policies_model->getPolicyAllotments($id, $policyType);
					$output_data = $this->load->view('admin/masters/insurance_policies/alloted_vehicles',$data,TRUE);
				}
				$result = array("type"=>'success', "message"=>'Allotment detail successfully fetched.', "output_html"=> $output_data);
			}else{
				$result = array("type"=>'success', "message"=>'Allotment detail not found.');
			}
		}
		echo json_encode($result);
    }
	
	public function create()
	{
		$this->form_validation->set_rules('policy_type', 'Policy Type', 'trim|required');
		$this->form_validation->set_rules('policy_company', 'Policy Comapny', 'trim|required');
		$this->form_validation->set_rules('policy_number', 'Policy Number', 'trim|required');
		$this->form_validation->set_rules('policy_date', 'Policy start Date', 'trim|required');
		$this->form_validation->set_rules('policy_expiry', 'Policy Expiry Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			// Handle form submission
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$data = array(
					'policy_type' => $this->input->post('policy_type'),
					'policy_company' => $this->input->post('policy_company'),
					'policy_number' => $this->input->post('policy_number'),
					'policy_date' => $this->input->post('policy_date'),
					'policy_expiry' => $this->input->post('policy_expiry'),
					'alloted_to' => $this->input->post('alloted_to'),
					'policy_class' => json_encode($this->input->post('policy_class'))
				);
				$response = $this->policies_model->insert_policy($data);
				if ($response) {
					$this->session->set_userdata('info', "1--Successfully added");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/master/insurance-policies/list');
	}

	public function update()
	{
		$this->form_validation->set_rules('id', 'Policy ID', 'trim|required');
		$this->form_validation->set_rules('policy_type', 'Policy Type', 'trim|required');
		$this->form_validation->set_rules('policy_company', 'Policy Comapny', 'trim|required');
		$this->form_validation->set_rules('policy_number', 'Policy Number', 'trim|required');
		$this->form_validation->set_rules('policy_date', 'Policy start Date', 'trim|required');
		$this->form_validation->set_rules('policy_expiry', 'Policy Expiry Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			// Handle form submission
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$id = $this->input->post('id');
				$data = array(
					'policy_type' => $this->input->post('policy_type'),
					'policy_company' => $this->input->post('policy_company'),
					'policy_number' => $this->input->post('policy_number'),
					'policy_date' => $this->input->post('policy_date'),
					'policy_expiry' => $this->input->post('policy_expiry'),
					'alloted_to' => $this->input->post('alloted_to'),
					'policy_class' => json_encode($this->input->post('policy_class'))
				);
				$response = $this->policies_model->update_policy($id, $data);
				if ($response) {
					$this->session->set_userdata('info', "1--Successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/master/insurance-policies/list');
	}

	public function delete()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->policies_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/insurance-policies/list');
	}
	
	public function print_allotment_detail($id)
	{
		$this->load->library('Pdf_employee_offer');
		$query = $this->policies_model->get_detail($id);
		if($query->num_rows() > 0){
			$data['detail'] = $query->row();
			$policyType = $data['detail']->policy_type;
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Insurance Policies Details');
			$pdf->SetSubject('BS - Insurance Policies Details');
			$pdf->SetKeywords('Baqala Station, PDF, Insurance Policies Details, Employee');

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

			// print newline
			$pdf->Ln();
			// set font
			//$pdf->SetFont('helvetica', '', 10);
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content+
			if($policyType === 'Employee'){
				$data['allotments_list'] = $this->policies_model->getPolicyAllotments($id, $policyType);
				$htmlcontent = $this->load->view('admin/masters/insurance_policies/print-allotments', $data, true);
			}else{
				$data['allotments_list'] = $this->policies_model->getPolicyAllotments($id, $policyType);
				$htmlcontent = $this->load->view('admin/masters/insurance_policies/print-allotments-vehicles', $data, true);
			}
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('Insurance-policy-' . $data['detail']->policy_number . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Insurance detail not found!");
			redirect('admin/master/insurance-policies/list');
		}
	}
}
