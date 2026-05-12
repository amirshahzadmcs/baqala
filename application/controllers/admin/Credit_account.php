<?php defined('BASEPATH') or exit('No direct script access allowed');

class Credit_account extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {

			$this->load->model('admin/Credit_model');
			$this->load->model('admin/User_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(),'manage_credit_accounts',$this->action)) {
			redirect('admin/unauthorized-request');
		};
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/credit/credit_list', $data);
	}

	public function add_credits()
	{
		$this->form_validation->set_rules('user_id', 'User Id', 'trim|required|is_unique[credit_account.user_id]');
		$this->form_validation->set_rules('credit_avilable', 'Credit', 'trim|required');
		$this->form_validation->set_rules('max_credit_limit', 'Max Credit Limit', 'trim|required');
		$this->form_validation->set_rules('credit_days', 'Credit Overdues Date', 'trim|required');
		//$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_message('is_unique', 'Already have an account of this user');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>' . $msg . '</div>';
			exit();
		} else {
			if ($this->input->post('id')) {
				$query = $this->Credit_model->edit();
			} else {
				$query = $this->Credit_model->add();
			}
			if ($query) {
				//$this->session->set_userdata('info', "Successfully Done");
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>Successfully Created</div>';
				exit();
			} else {
				//$this->session->set_userdata('info', "Error!!!");
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>Error occured, Try again</div>';
				exit();
			}
		}
	}

	public function edit()
	{
		$id = $this->input->get('id');
		$data = $this->Credit_model->get_credit_by_id($id);
		$this->load->view('admin/credit/credit_form', $data);
	}

	public function update_credits()
	{
		$this->form_validation->set_rules('id', 'Credit Id', 'trim|required');
		$this->form_validation->set_rules('uid', 'User Id', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$this->session->set_userdata('info', '2--' . $msg);
		} else {
			if ($this->input->post('id')) {
				$query = $this->Credit_model->updateCredit();
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully Updated Account Of " . $this->input->post('name'));
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/credit-account/list');
	}

	public function update_credits_report()
	{
		$this->form_validation->set_rules('id', 'Report Id', 'trim|required');
		$this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
		$this->form_validation->set_rules('credit', 'Amount', 'trim|required');
		$this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$this->session->set_userdata('info', '2--' . $msg);
		} else {
			if ($this->input->post('id')) {
				$query = $this->Credit_model->updateCreditReport();
			} else {
				$this->session->set_userdata('info', "2--Payment Error (check order id)!!!");
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/credit-account/list');
	}

	public function update_limit()
	{
		$this->form_validation->set_rules('id', 'Credit Id', 'trim|required');
		$this->form_validation->set_rules('max_credit_limit', 'Max Credit Limit', 'trim|required');
		$this->form_validation->set_rules('old_credit_limit', 'Old Credit Limit', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$this->session->set_userdata('info', '2--' . $msg);
		} else {
			$max_credit_limit = $this->input->post('max_credit_limit');
			$old_credit_limit = $this->input->post('old_credit_limit');
			if ($max_credit_limit > $old_credit_limit) {
				if ($this->input->post('id')) {
					$query = $this->Credit_model->updateMaxlimit();
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully Updated Account Of " . $this->input->post('name'));
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
			} else {
				$this->session->set_userdata('info', "2--New credit limit must greater than old credit limit!!!");
			}
		}
		redirect('admin/credit-account/list');
	}
	public function setStatus()
	{
		if ($this->admin->isLogged()) {
			$id = $this->input->post('uid');
			$query = $this->Credit_model->update_credit_account($id);
			if ($query) {
				echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>Status Successfully Updated</div>';
				exit();
			} else {
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>Error occured, Try again</div>';
				exit();
			}
		} else {
			redirect('admin');
		}
	}

	public function get_list()
	{
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		$fetch_data = $this->Credit_model->get_list($keyword, $status);
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $credits) {
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $credits->name;
			$sub_array[] = $credits->account_no;
			$sub_array[] = $credits->company_name;
			//$sub_array[] = $credits->mobile;
			$sub_array[] = $credits->max_credit_limit;
			$sub_array[] = $credits->credit_avilable;
			$sub_array[] = formatedDateTime($credits->created_at);
			$sub_array[] = formatedDateTime($credits->updated_at);
			$sub_array[] = ($credits->account_status == 0) ? '<span class="badge badge-pill badge-soft-warning font-size-13">Not Open</span>' : (($credits->account_status == 1) ? '<span class="badge badge-pill badge-soft-primary font-size-13">Not Active</span>' : (($credits->account_status == 2) ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Suspended</span>'));

			$sub_array[] = check_action_permission(get_user_role(), 'manage_credit_accounts', 'report') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Detail" href="' . base_url() . 'admin/credit-account/report?id=' . $credits->user_id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Credit_model->get_all_data(),
			"recordsFiltered"     =>     $this->Credit_model->get_filtered_data($keyword, $status),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function report()
	{
		if ($this->action && !check_action_permission(get_user_role(),'manage_credit_accounts',$this->action)) {
			redirect('admin/unauthorized-request');
		};
		$id = $this->input->get('id');
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['user'] = $this->User_model->get_customer($id)->row();
		$data['credit_account'] = $this->Credit_model->get_credit_by_uid($id);
		$data['debit_reports'] = $this->Credit_model->make_report_query($id, 'debit')->result();
		$data['credit_reports'] = $this->Credit_model->make_report_query($id, 'credit')->result();
		//print_r($data['credit_account']);exit();
		$this->load->view('admin/credit/credit_report', $data);
	}

	public function reportSearch()
	{
		$id = $this->input->get('id');
		$report = $this->Credit_model->get_report_by_uid($id);
		echo json_encode($report);
		//$this->load->view('admin/catalog/product_list', $data);
	}
	/*
	public function report_list(){
		$id = $this->input->get('id');
		$fetch_data = $this->Credit_model->get_report_list($id);		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $reports){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $reports->order_id;
			$sub_array[] = $reports->trans_id;
			$sub_array[] = $reports->debit;
			$sub_array[] = $reports->credit;
			$sub_array[] = $reports->avl_bal;
			$sub_array[] = date("d M,Y h:i A", strtotime($reports->created_at));
			$sub_array[] = date("d M,Y h:i A", strtotime($reports->updated_at));		 
			$data[] = $sub_array;
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Credit_model->get_all_report_data($id),  
			"recordsFiltered"     =>     $this->Credit_model->get_report_filtered_data($id),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	*/
	public function delete()
	{
		$ids = $this->input->post('checklist');
		$query = $this->Credit_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/Role');
	}

	public function get_report()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$id = $this->input->get('nameFilter');
		if ($id) {
			$data['user_detail'] = $this->User_model->get_customer($id)->row();
			$data['user_address'] = $this->User_model->get_info($id);
			$data['credit_account'] = $this->Credit_model->get_credit_by_uid($id);
			$data['debit_reports'] = $this->Credit_model->get_debit_report();
			$data['credit_reports'] = $this->Credit_model->get_credit_report();
			$data['debit_age'] = $this->Credit_model->get_debit_age($id);
			$data['credit_age'] = $this->Credit_model->get_credit_age($id);
			$data['current_debit_balance'] = $this->Credit_model->current_debit_balance($id);
			$data['current_credit_balance'] = $this->Credit_model->current_credit_balance($id);
		} else {
			$data['user_detail'] = '';
			$data['user_address'] = '';
			$data['credit_account'] = '';
			$data['credit_reports'] = '';
			$data['debit_age'] = '';
			$data['credit_age'] = '';
			$data['current_debit_balance'] = '';
			$data['current_credit_balance'] = '';
			//$this->session->set_userdata('info', "2--Select customer from list!");
		}
		$data['user_list'] = $this->Credit_model->get_customers();
		//print_r($data['credit_age']);exit();
		$this->load->view('admin/credit/report', $data);
	}

	public function print_statement()
	{
		$this->load->library('Pdf_account');
		$id = $this->input->get('nameFilter');
		if ($id) {
			$data['user_detail'] = $this->User_model->get_customer($id)->row();
			$data['user_address'] = $this->User_model->get_info($id);
			$data['credit_account'] = $this->Credit_model->get_credit_by_uid($id);
			$data['debit_reports'] = $this->Credit_model->get_debit_report();
			$data['credit_reports'] = $this->Credit_model->get_credit_report();
			$data['debit_age'] = $this->Credit_model->get_debit_age($id);
			$data['credit_age'] = $this->Credit_model->get_credit_age($id);
			$data['current_debit_balance'] = $this->Credit_model->current_debit_balance($id);
			$data['current_credit_balance'] = $this->Credit_model->current_credit_balance($id);
		} else {
			$data['user_detail'] = '';
			$data['user_address'] = '';
			$data['credit_account'] = '';
			$data['credit_reports'] = '';
			$data['debit_age'] = '';
			$data['credit_age'] = '';
			$data['current_debit_balance'] = '';
			$data['current_credit_balance'] = '';
			$this->session->set_userdata('info', "2--Select customer from list!");
		}
		// create new PDF document
		$pdf = new Pdf_account(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Credit Account Statement');
		$pdf->SetSubject('Credit Account Statement');
		$pdf->SetKeywords('Baqala Station, PDF, Credit Account Statement');

		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		$htmlHeader = $this->load->view('admin/credit/report_header', $data, true);
		$htmlHeader2 = $this->load->view('admin/credit/report_header2', $data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/credit/report_footer', $data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(1, 87, 4, true);

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
		$pdf->SetFont('aealarabiya', '', 10);
		$data['PgNo'] = $pdf->getAliasNumPage() . " of " . $pdf->getAliasNbPages();
		// Arabic and English content
		$htmlcontent = $this->load->view('admin/credit/print_report', $data, true);;
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('bs-credit-report-' . $id . '.pdf', 'I');
	}
}
