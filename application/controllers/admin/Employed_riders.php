<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employed_riders extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Empriders_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

    public function index()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/employed_riders/index',$data);
	}

	public function add(){
		$data['employs'] = $this->Empriders_model->get_emp_list();
		$this->load->view('admin/employed_riders/form',$data);
	}
	
	public function edit(){
		if($this->input->get('id')){
			$data['emp_detail'] = $this->Empriders_model->get_detail($this->input->get('id'));
			$data['employs'] = $this->Empriders_model->get_emp_list();
			$this->load->view('admin/employed_riders/edit',$data);
		}else{
			redirect('admin/employed-rider/list');
		}
	}

	public function save(){
		$this->form_validation->set_rules('emp_id', 'Select Employee', 'trim|required|callback_check_emp_duplicate');
		$this->form_validation->set_message('check_emp_duplicate','Employee already registered, Try new');
		$this->form_validation->set_rules('vehicle_no', 'Select Vehicle', 'trim|required');
		$this->form_validation->set_rules('personal_mobile', 'Personal Mobile Number', 'trim|required');
		//$this->form_validation->set_rules('platform_id', 'Chosse Platform', 'trim|required');
		$this->form_validation->set_rules('monthly_salary', 'Monthly Salary', 'trim|required');
		$this->form_validation->set_rules('target_order', 'No. of Target Order', 'trim|required');
		$this->form_validation->set_rules('deduction_incentive', 'Incentive Deduction', 'trim|required');
		$this->form_validation->set_rules('add_incentive', 'Incentive Amount', 'trim|required');
		$this->form_validation->set_rules('imei_no', 'IMEI Number', 'trim|required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->Empriders_model->add();
			if($query){
				$this->session->set_userdata('info', "1--Successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/employed-rider/list');
	}
	
	public function update(){
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		$this->form_validation->set_rules('emp_id', 'Select Employee', 'trim|required|callback_check_emp_duplicate');
		$this->form_validation->set_message('check_emp_duplicate','Employee already registered, Try new');
		$this->form_validation->set_rules('vehicle_no', 'Select Vehicle', 'trim|required');
		$this->form_validation->set_rules('personal_mobile', 'Personal Mobile Number', 'trim|required');
		//$this->form_validation->set_rules('platform_id', 'Chosse Platform', 'trim|required');
		$this->form_validation->set_rules('monthly_salary', 'Monthly Salary', 'trim|required');
		$this->form_validation->set_rules('target_order', 'No. of Target Order', 'trim|required');
		$this->form_validation->set_rules('deduction_incentive', 'Incentive Deduction', 'trim|required');
		$this->form_validation->set_rules('add_incentive', 'Incentive Amount', 'trim|required');
		$this->form_validation->set_rules('imei_no', 'IMEI Number', 'trim|required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$id = $this->input->post('id');
			$query = $this->Empriders_model->edit();
			if($query){
				$this->session->set_userdata('info', "1--Successfully updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
			redirect('admin/employed-rider/edit?id='.$id);
		}
		redirect('admin/employed-rider/list');
	}

	public function check_emp_duplicate() {
		$id = $this->input->post('id');
		$emp_id = $this->input->post('emp_id');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Empriders_model->check_duplicate_employee($id, $emp_id);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function detail(){
		if($this->input->get('id')){
			$data['emp_detail'] = $this->Empriders_model->get_detail($this->input->get('id'));
			$data['employs'] = $this->Empriders_model->get_emp_list();
			$this->load->view('admin/employed_riders/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid request or unauthorized access!");
			redirect('admin/employed-rider/list');
		}
	}

	public function get_ajax_list(){
		$fetch_data = $this->Empriders_model->get_list();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$key_data->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->emp_no;
			$sub_array[] = ucfirst($key_data->full_name);
			$sub_array[] = $key_data->iqama_no;
			$sub_array[] = ($key_data->mobile == '') ? 'NA' : $key_data->mobile;
			$sub_array[] = $key_data->vehicle_no .'<br><span class="badge badge-pill badge-soft-info font-size-13">'. $key_data->vehicle_type .'</span>';
			$sub_array[] = $key_data->hunger_platform_id;
			$sub_array[] = $key_data->jahez_platform_id;
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			$sub_array[] = (!empty($key_data->updated_at)) ? date('d-m-Y h i:A', strtotime($key_data->updated_at)) : 'NA';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/employed-rider/edit?id='.$key_data->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/employed-rider/detail?id='.$key_data->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';;
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Empriders_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Empriders_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function ajax_check_empid() {
		$emp_id = $this->input->get('emp_id');
		$id = '';
		if($emp_id !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Empriders_model->check_duplicate_employee($id, $emp_id);
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
		$ids = $this->input->post('checklist');
		$query = $this->Empriders_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/employed-rider/list');
	}
	
	public function getempdetail()
	{
		$empid = $this->input->get('id');
		$emp_detail = employeeDetailHelper($empid);
		echo json_encode($emp_detail);
	}

	public function getBikeDetail()
	{
		$user_id = $this->input->get('id');
		$vehicle_detail = $this->db->query("SELECT master_vehicles.*, mater_van_make.make_name FROM master_vehicles LEFT JOIN mater_van_make ON (master_vehicles.vehicle_make = mater_van_make.id) WHERE (master_vehicles.alloted_user='". $user_id ."' AND master_vehicles.allotment_status='alloted')")->row();
		echo json_encode($vehicle_detail);
	}
	
	public function getSimDetail()
	{
		$sim_id = $this->input->get('id');
		$sim_detail = simDetailHelper($sim_id);
		echo json_encode($sim_detail);
	}

	public function userwiseSimDetail()
	{
		$emp_id = $this->input->get('id');
		$sim_detail = userSimHelper($emp_id);
		echo json_encode($sim_detail);
	}
	
	public function print_employement_contract(){
	    $this->load->library('Pdf_promissory_note');
		$id = $this->input->get('id');
		if($id > 0){
			$emp_detail = $this->Empriders_model->get_detail($id);
			if(!empty($emp_detail)){
				//print_r($cv_detail);exit();
				// create new PDF document
				$pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Employment Contract');
				$pdf->SetSubject('BS - Employment Contract');
				$pdf->SetKeywords('Baqala Station, PDF, Employment Contract, Rider');
				
				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true); 
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);
				
				$lastFooter = '';
				$pdf->setHtmlFooter($lastFooter);
				
				// set default header data
				//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

				// set header and footer fonts
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetMargins(5, 60, 10, true);

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
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/hr/master/employee/print/employement-contract',$emp_detail, true);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('BS Employment Contract '. $emp_detail->emp_no .'.pdf', 'I');
			}else{
				$this->session->set_userdata('info', "2--First complete employee information first.");
				redirect('admin/employed-rider/detail?id='.$id);
			}
		}else{
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/employed-rider/list');
		}
	}

	public function print_vehicle_ack_receipt(){
	    $this->load->library('Pdf_promissory_note');
		$id = $this->input->get('id');
		if($id > 0){
			$emp_detail = $this->Empriders_model->get_detail($id);
			if(!empty($emp_detail)){
				//print_r($cv_detail);exit();
				// create new PDF document
				$pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor('Baqala Station');
				$pdf->SetTitle('BS - Vehicle Acknowledgement Receipt');
				$pdf->SetSubject('BS - Vehicle Acknowledgement Receipt');
				$pdf->SetKeywords('Baqala Station, PDF, Vehicle Acknowledgement Receipt, Rider');
				
				// remove default header/footer
				$pdf->setPrintHeader(true);
				$pdf->SetPrintFooter(true); 
				$htmlHeader = '';
				$htmlHeader2 = '';
				$pdf->setHtmlHeader($htmlHeader);
				$pdf->setHtmlHeader2($htmlHeader2);
				
				$lastFooter = '';
				$pdf->setHtmlFooter($lastFooter);
				
				// set default header data
				//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

				// set header and footer fonts
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				$pdf->SetMargins(5, 60, 10, true);

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
				// Arabic and English content
				// set LTR direction for english translation
				$pdf->setRTL(false);

				// print newline
				$pdf->Ln();
				// set font
				$pdf->SetFont('aealarabiya', '', 10);

				// Arabic and English content
				$htmlcontent = $this->load->view('admin/hr/master/employee/print/vehicle-acknowledgement-receipt',$emp_detail, true);
				$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
				//Close and output PDF document
				$pdf->Output('BS Vehicle Acknowledgement Receipt '. $emp_detail->emp_no .'.pdf', 'I');
			}else{
				$this->session->set_userdata('info', "2--First complete employee information first.");
				redirect('admin/employed-rider/detail?id='.$id);
			}
		}else{
			$this->session->set_userdata('info', "2--Employee detail not found!");
			redirect('admin/employed-rider/list');
		}
	}
}

