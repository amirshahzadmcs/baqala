<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PrepaidMobileInvoice extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/PrepaidMobileInvoice_model', 'PMIM');
			$this->load->model('admin/Sim_model');
			$this->load->model('admin/Plan_model');
			$this->load->model('admin/Network_model');
			$this->load->model('admin/Voucher_model');
			$this->load->library('form_validation');
			$this->load->helper('text');
			$this->load->helper('common_helper');
			$this->action=$this->router->fetch_method();
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index(){
		if($this->action && !check_action_permission(get_user_role(), 'recharges', $this->action)):
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
		$data['inv_count'] = $this->db->query("SELECT id FROM prepaid_mobile_invoice")->num_rows();
		$data['emp_list'] = $this->PMIM->get_inv_emp_list();
		$data['networks'] = $this->Network_model->get_list()->result();
		$data['inv_sim_list'] = $this->PMIM->get_inv_sim_list();
		$data['prepaid_sim_list'] = $this->PMIM->get_sims();
		$data['plans'] = $this->Plan_model->get_list()->result();
		return $this->load->view('admin/mobile-invoice/prepaid/list',$data);
	}
	
	public function get_list(){
		if(!empty($this->input->get('period_start'))){
			$startDate = $this->input->get('period_start');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('period_end'))){
			$endDate = $this->input->get('period_end');
		}
		else{
			$endDate = FALSE;
		}
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('plan'))){
			$plan = $this->input->get('plan');
		}
		else{
			$plan = FALSE;
		}
		if(!empty($this->input->get('owner'))){
			$owner = $this->input->get('owner');
		}
		else{
			$owner = FALSE;
		}
		if(!empty($this->input->get('user'))){
			$user = $this->input->get('user');
		}
		else{
			$user = FALSE;
		}
		$fetch_data = $this->PMIM->get_list($sim_no,$network,$plan,$owner,$startDate,$endDate,$user);
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			//$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$item->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = $item->mobile;
			$sub_array[] = $item->network_name;
			$sub_array[] = (isset($item->emp_no)) ? $item->emp_no : 'NA';
			$sub_array[] = (isset($item->full_name)) ? $item->full_name : 'NA';
			$sub_array[] = date('d-m-Y', strtotime($item->recharge_date));
			$sub_array[] = $item->total_amount;
			$sub_array[] = $item->serial_no;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			$sub_array[] = check_action_permission(get_user_role(), 'recharges', 'recharge_detail_view') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="rechargeDetailView('.$item->id.')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}					
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->PMIM->get_all_data(),  
			"recordsFiltered"     =>     $this->PMIM->get_filtered_data($sim_no,$network,$plan,$owner,$startDate,$endDate,$user),  
			"data"                =>     $data  
		); 
		echo json_encode($output);
	}
	
	public function getActiveVouchers()
	{
		$network_id = $this->input->get('id');
		$query = $this->Voucher_model->getNetworkWiseUnusedVouchers($network_id);
		if($query->num_rows() > 0){
			// $p_data = $query;
			// print_r($this->input->get('plan_id'));exit();
			$data ='';
			$data .= '<option value="">---- Select Recharge Card ---</option>';
			foreach($query->result() as $card){
				$data .= '<option value="' . $card->id . '">' . $card->serial_no . '</option>';
			}
			echo $data;
		}else{
			$data = '<option value="">---- No Recharge Card Found ---</option>';
			echo $data;
		}
	}

	public function add_invoice(){	
		$data['sim_list'] = $this->Sim_model->get_running_sims();
		// print_r($data['sim_list']);die();
		return $this->load->view('admin/mobile-invoice/prepaid/form',$data);
	}

	public function sim_detail_view() {
		$sim_id = $this->input->get('sim_id');
		if($sim_id !== ''){
			// do some database things you need to do e.g.
			$data['sim_detail'] = $this->PMIM->get_sim_detail($sim_id);
			$data['last_recharge_detail'] = $this->PMIM->last_recharge_detail($sim_id);
			$result = $this->load->view('admin/mobile-invoice/prepaid/components/sim-detail',$data,TRUE);
			echo $result;
		}else{
			$result = '';
			echo $result;
		}
	}

	public function voucher_detail_view() {
		$voucher_id = $this->input->get('voucher_id');
		if($voucher_id !== ''){
			// do some database things you need to do e.g.
			$data['voucher_detail'] = $this->Voucher_model->getVouchersDetail($voucher_id);
			$result = $this->load->view('admin/mobile-invoice/prepaid/components/recharge-detail',$data,TRUE);
			echo $result;
		}else{
			$result = '';
			echo $result;
		}
	}

	public function edit_invoice(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$query = $this->PMIM->get_detail($id);
			$data['attachment'] = $this->PMIM->get_docs($id);
			$data['id'] = $query->id;
			$data['sim_id'] = $query->sim_id;
			$data['invoice_no'] = $query->invoice_no;
			$data['recharge_date'] = $query->recharge_date;
			$data['plan_days'] = $query->plan_days;
			//$data['recharge_plan_date'] = $query->recharge_plan_date;
			$data['vat_percent'] = $query->vat_percent;
			$data['total_amount'] = $query->total_amount;
			$data['payment_source'] = $query->payment_source;
		}
		else{
			$data['id'] = "";
			$data['sim_id'] = "";
			$data['invoice_no'] = "";
			$data['recharge_date'] = "";
			$data['plan_days'] = "";
			//$data['recharge_plan_date'] = "";
			$data['vat_percent'] = "";
			$data['total_amount'] = "";
			$data['payment_source'] = "";
			$data['attachment'] = array();
		}		
		$data['sims'] = $this->PMIM->get_sims();
		// print_r($data['sims']);die();
		$this->load->view('admin/mobile-invoice/prepaid/form',$data);
	}

	public function save_invoice(){
		if($this->action && !check_action_permission(get_user_role(), 'recharges', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$this->form_validation->set_rules('sim_id', 'Sim Number', 'trim|required');
		$this->form_validation->set_rules('voucher_id', 'Select Recharge card', 'trim|required|callback_validate_invoice');
		$this->form_validation->set_message('validate_invoice','This Recharge Card already redeemed, Try new');
		$this->form_validation->set_rules('recharge_date', 'Recharge Date', 'trim|required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->PMIM->add();
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/prepaid-mobile-invoice/list');
	}

	public function validate_invoice($voucher_id) {
		$id = $this->input->post('id');
		if (!isset($id)) {
            $id = 0;
        }
        if ($this->PMIM->check_invoice_exists($voucher_id, $id)) {
            return FALSE;
        } else {
            return TRUE;
        }
	}

	public function check_invoiceno($invoice_no) {
		$id = $this->input->post('id');
		if (!isset($id)) {
            $id = 0;
        }
        if ($this->PMIM->check_invoice_no_exists($invoice_no, $id)) {
            return FALSE;
        } else {
            return TRUE;
        }
	}

	public function ajax_check_invoiceno() {
		$invoice_no = $this->input->get('invoice_no');
		$id = $this->input->get('id');
		if($invoice_no !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->PMIM->check_invoice_no_exists($invoice_no,$id);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $invoice_no . "</b> Duplicate Invoice No. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Checked, Ok.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Invoice No. is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_invoice() {
		$sim_id = $this->input->get('sim_id');
		$id = $this->input->get('id');
		$date = date('Y-m-d', strtotime($this->input->get('recharge_date')));
		if($date !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->PMIM->check_invoice_exists($sim_id, $date, $id);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $this->input->get('period') . "</b> Already exist for this month. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Checked, Ok.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Bill Period is required.</span>";
		}
		echo json_encode($data);
	}
	
	public function recharge_detail_view() {
		if($this->action && !check_action_permission(get_user_role(), 'recharges', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$recharge_id = $this->input->get('id');
		if($recharge_id !== ''){
			// do some database things you need to do e.g.
			$data['recharge_detail'] = $this->PMIM->get_detail($recharge_id);
			$result = $this->load->view('admin/mobile-invoice/prepaid/components/invoice-detail',$data,TRUE);
			echo $result;
		}else{
			$result = '';
			echo $result;
		}
	}

	public function getPlans()
	{
		$query = $this->PMIM->get_plan($this->input->get('id'));
		// $p_data = $query;
		// print_r($this->input->get('plan_id'));exit();
		$data ='';
		foreach($query as $plan){
			if ($plan->id == $this->input->get('plan_id')) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$data .= '<option value="' . $plan->id . '" ' . $selected . '>' . $plan->plan_name . '</option>';
		}
		echo $data;
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->PMIM->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/prepaid-mobile-invoice/list');
	}
	
	public function doc_delete(){
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('item_id', 'Item ID', 'trim|required');
			$this->form_validation->set_rules('img_id', 'Image ID', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$data = array("type"=>'error', "message"=>'Invalid Request Type');
			}
			else{
				$query = $this->PMIM->delete_image();
				if($query){
					$data = array("type"=>'success', "message"=>'Image successfully deleted');
				}
				else{
					$data = array("type"=>'error', "message"=>'Something went wrong, Try again');
				}
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
	}

	public function print_report(){
		if($this->action && !check_action_permission(get_user_role(), 'recharges', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
	    $this->load->library('Pdf_mobile_invoice');
		$id = $this->input->get('id');
		if(!empty($this->input->get('period_start'))){
			$startDate = $this->input->get('period_start');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('period_end'))){
			$endDate = $this->input->get('period_end');
		}
		else{
			$endDate = FALSE;
		}
		
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('plan'))){
			$plan = $this->input->get('plan');
		}
		else{
			$plan = FALSE;
		}
		if(!empty($this->input->get('owner'))){
			$owner = $this->input->get('owner');
		}
		else{
			$owner = FALSE;
		}
		if(!empty($this->input->get('user'))){
			$user = $this->input->get('user');
		}
		else{
			$user = FALSE;
		}

		$data['invoice'] = $this->PMIM->print_report($sim_no,$network,$plan,$owner,$startDate,$endDate,$user);

		$data['start'] = $startDate;
		$data['end'] = $endDate;
		$data['user'] = $user;
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_mobile_invoice(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Billing Detail From '.date('d M Y', strtotime($startDate)).' To '.date('d M Y', strtotime($endDate)));
		$pdf->SetSubject('BS - Billing Detail From '.date('d M Y', strtotime($startDate)).' To '.date('d M Y', strtotime($endDate)));
		$pdf->SetKeywords('Baqala Station, PDF, Billing Detail');
		
		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/mobile-invoice/prepaid/header/invoice_header_2',$data, true);
		$htmlHeader2 = $this->load->view('admin/mobile-invoice/prepaid/header/invoice_header2_2',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/mobile-invoice/prepaid/footer/footer_last',$data, true);
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
		$pdf->SetMargins(1, 60, 4, true);

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
		$htmlcontent = $this->load->view('admin/mobile-invoice/prepaid/print_mobile_invoice_report',$data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS - Billing Detail From '.date('d M Y', strtotime($startDate)).' To '.date('d M Y', strtotime($endDate)) .'.pdf', 'I');
	}

	public function consolidate_report()
	{
		if(!empty($this->input->get('period_start'))){
			$startDate = $this->input->get('period_start');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('period_end'))){
			$endDate = $this->input->get('period_end');
		}
		else{
			$endDate = FALSE;
		}
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('plan'))){
			$plan = $this->input->get('plan');
		}
		else{
			$plan = FALSE;
		}
		if(!empty($this->input->get('owner'))){
			$owner = $this->input->get('owner');
		}
		else{
			$owner = FALSE;
		}
		if(!empty($this->input->get('user'))){
			$user = $this->input->get('user');
		}
		else{
			$user = FALSE;
		}
		if ($startDate && $endDate) {
			$data['invoice'] = $this->PMIM->get_consolidate_plans($sim_no,$network,$plan,$owner,$startDate,$endDate,$user);
			//print_r($data);exit();
		} else {
			$data['invoice'] = array();
		}
		$data['inv_count'] = $this->db->query("SELECT id FROM mobile_invoice")->num_rows();
		$data['emp_list'] = $this->PMIM->get_inv_emp_list();
		$data['networks'] = $this->Network_model->get_list()->result();
		$data['inv_sim_list'] = $this->PMIM->get_inv_sim_list();
		$data['plans'] = $this->Plan_model->get_list()->result();
		//print_r($data['emp_list']);exit();
		$this->load->view('admin/mobile-invoice/prepaid/consolidate_report',$data);
	}
	
	public function print_consolidate_report(){
	    $this->load->library('Pdf_mobile_consolidate_report');
		$id = $this->input->get('id');
		// $order = $this->PMIM->get_detail($id);
		// print_r($order);exit();
		if(!empty($this->input->get('period_start'))){
			$startDate = $this->input->get('period_start');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('period_end'))){
			$endDate = $this->input->get('period_end');
		}
		else{
			$endDate = FALSE;
		}
		
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('plan'))){
			$plan = $this->input->get('plan');
		}
		else{
			$plan = FALSE;
		}
		if(!empty($this->input->get('owner'))){
			$owner = $this->input->get('owner');
		}
		else{
			$owner = FALSE;
		}
		if(!empty($this->input->get('user'))){
			$user = $this->input->get('user');
		}
		else{
			$user = FALSE;
		}
		$data['invoice'] = $this->PMIM->get_consolidate_plans($sim_no,$network,$plan,$owner,$startDate,$endDate,$user);
		$data['start'] = date('d M Y', strtotime($startDate));
		$data['end'] = date('d M Y', strtotime($endDate));
		$data['user'] = $user;
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		$pdf = new Pdf_mobile_consolidate_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Consolidated Report From '.date('d M Y', strtotime($startDate)).' To '.date('d M Y', strtotime($endDate)));
		$pdf->SetSubject('BS - Consolidated Report From '.date('d M Y', strtotime($startDate)).' To '.date('d M Y', strtotime($endDate)));
		$pdf->SetKeywords('Baqala Station, PDF, Consolidated Report');
		
		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/mobile-invoice/prepaid/header/invoice_header_2',$data, true);
		$htmlHeader2 = $this->load->view('admin/mobile-invoice/prepaid/header/invoice_header2_2',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);
		
		$lastFooter = $this->load->view('admin/mobile-invoice/prepaid/footer/footer_last',$data, true);
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
		$pdf->SetMargins(1, 60, 4, true);

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
		$pdf->AddPage('L', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/mobile-invoice/prepaid/print_mobile_consolidate_report',$data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS - Consolidated Report From '.date('d M Y', strtotime($startDate)).' To '.date('d M Y', strtotime($endDate)) .'.pdf', 'I');
	}
	
}
