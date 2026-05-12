<?php defined('BASEPATH') or exit('No direct script access allowed');

class Logistic_partner extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {

			$this->load->model('admin/Logistic_Partner_model');
			$this->load->model('admin/Common_model');
			$this->load->library('form_validation');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->helper('Common_helper');
			$this->load->helper('sendmail_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_logistic_partner', $this->action)) {
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
		//print_r($data);exit();
		$this->load->view('admin/logistic_partner/list', $data);
	}

	public function welcome()
	{
		$this->load->view('admin/attatchment-template/logistic-welcome-mail');
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
		if (!empty($this->input->get('application_status'))) {
			$application_status = $this->input->get('application_status');
		} else {
			$application_status = FALSE;
		}
		if (!empty($this->input->get('vat_no'))) {
			$vat_no = $this->input->get('vat_no');
		} else {
			$vat_no = FALSE;
		}
		if (!empty($this->input->get('cr_no'))) {
			$cr_no = $this->input->get('cr_no');
		} else {
			$cr_no = FALSE;
		}

		$fetch_data = $this->Logistic_Partner_model->get_list($keyword, $status, $application_status, $vat_no, $cr_no);
		// $i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $user) {
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $user->id . '" />';
			if ($user->application_status == 'verified') {
				$profile_status = '<span class="badge badge-pill badge-soft-success font-size-13">Verified</span>';
			} else {
				$profile_status = '<span class="badge badge-pill badge-soft-warning font-size-13">Unverified</span>';
			}
			$sub_array[] = $user->customer_no . '<br>' . $profile_status;
			$sub_array[] = $user->name;
			$sub_array[] = $user->company_name;
			$sub_array[] = $user->cr_no;
			$sub_array[] = $user->email;
			$sub_array[] = $user->mobile;
			$sub_array[] = $user->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : ($user->status == 2 ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>');
			$sub_array[] = date("d-m-y h:i A", strtotime($user->created_at));
			$sub_array[] = date("d-m-y h:i A", strtotime($user->updated_at));
			$sub_array[] = (check_action_permission(get_user_role(), '3p_logistic_partner', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/logistic-partner/add?id=' . $user->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), '3p_logistic_partner', 'details') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/logistic-partner/detail?id=' . $user->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->Logistic_Partner_model->get_all_data(),
			"recordsFiltered" => $this->Logistic_Partner_model->get_filtered_data($keyword, $status, $application_status, $vat_no, $cr_no),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_logistic_partner', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Logistic_Partner_model->get_detail($this->input->get('id'))->row();
			$docs = $this->Logistic_Partner_model->documents($this->input->get('id'));
			$other_info = $this->Logistic_Partner_model->partner_info($this->input->get('id'));
			$bank_info = $this->Logistic_Partner_model->bank_info($this->input->get('id'));
			$commissions = $this->Logistic_Partner_model->commssion_info($this->input->get('id'));
			$data['id'] = $query->id;
			$data['customer_no'] = $query->customer_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['email'] = $query->email;
			$data['status'] = $query->status;
			$data['company_name'] = $query->company_name;
			$data['company_arabic_name'] = $query->company_arabic_name;
			$data['business_nature'] = $query->business_nature;
			$data['account_manager'] = $query->account_manager;
			$data['company_type'] = $query->company_type;
			$data['client_telephone'] = $query->client_telephone;
			$data['client_fax'] = $query->client_fax;
			$data['website'] = $query->website;
			$data['cr_no'] = $query->cr_no;
			$data['cr_expiry'] = $query->cr_expiry;
			$data['vat_no'] = $query->vat_no;
			$data['vat_expiry'] = $query->vat_expiry;
			$data['agreement_start'] = $query->agreement_start;
			$data['agrement_expiry'] = $query->agrement_expiry;
			$data['application_status'] = $query->application_status;
			$data['partner_basic_status'] = $query->partner_basic_status;
			$data['partner_bank_status'] = $query->partner_bank_status;
			$data['partner_docs_status'] = $query->partner_docs_status;

			$data['other_info'] = $other_info;
			$data['documents'] = $docs;
			$data['bank_info'] = $bank_info;
			$data['commissions'] = $commissions;
		} else {
			$last_cno = $this->db->query("SELECT id FROM delivery_partner ORDER BY id DESC")->row();
			if ($last_cno->id > 0) {
				$new_customer_no = str_pad(((int)$last_cno->id + 101), 6, 0, STR_PAD_LEFT);
			} else {
				$new_customer_no = str_pad('101', 6, 0, STR_PAD_LEFT);
			}
			$data['id'] = "";
			$data['customer_no'] = $new_customer_no;
			$data['name'] = "";
			$data['mobile'] = "";
			$data['email'] = "";
			$data['status'] = "";
			$data['company_name'] = "";
			$data['company_arabic_name'] = "";
			$data['account_manager'] = "";
			$data['client_telephone'] = "";
			$data['client_fax'] = "";
			$data['website'] = "";
			$data['cr_no'] = "";
			$data['cr_expiry'] = "";
			$data['vat_no'] = "";
			$data['business_nature'] = "";
			$data['company_type'] = "";
			$data['vat_expiry'] = "";
			$data['agreement_start'] = "";
			$data['agrement_expiry'] = "";

			$data['application_status'] = "";
			$data['partner_basic_status'] = "";
			$data['partner_bank_status'] = "";
			$data['partner_docs_status'] = "";

			$data['other_info']['building_no'] = "";
			$data['other_info']['street_name'] = "";
			$data['other_info']['district'] = "";
			$data['other_info']['region_id'] = "";
			$data['other_info']['city'] = "";
			$data['other_info']['country'] = "";
			$data['other_info']['postal_code'] = "";
			$data['other_info']['additional_no'] = "";
			$data['other_info']['unit_no'] = "";
			$data['other_info']['short_address'] = "";
			$data['other_info']['website'] = "";

			$data['other_info']['authorize_ids'] = "";

			$data['other_info']['director_name1'] = "";
			$data['other_info']['director_id_no1'] = "";
			$data['other_info']['director_mobile1'] = "";
			$data['other_info']['director_email1'] = "";

			$data['other_info']['director_name2'] = "";
			$data['other_info']['director_id_no2'] = "";
			$data['other_info']['director_mobile2'] = "";
			$data['other_info']['director_email2'] = "";

			$data['other_info']['sales_name'] = "";
			$data['other_info']['sales_id_no'] = "";
			$data['other_info']['sales_mobile'] = "";
			$data['other_info']['sales_email'] = "";

			$data['other_info']['finance_name'] = "";
			$data['other_info']['finance_id_no'] = "";
			$data['other_info']['finance_mobile'] = "";
			$data['other_info']['finance_email'] = "";

			$data['documents'] = "";
			$data['bank_info'] = "";
			$data['commissions'] = "";
		}
		//print_r($data['partners']);exit();
		$this->load->view('admin/logistic_partner/form', $data);
	}

	public function save_basic_info()
	{
		//$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
		$this->form_validation->set_rules('company_arabic_name', 'Company Name Arabic', 'trim|required');
		$this->form_validation->set_rules('account_manager', 'Account Manager', 'trim|required');
		$this->form_validation->set_rules('agreement_start', 'Agreement Start Date', 'trim|required');
		$this->form_validation->set_rules('agrement_expiry', 'Agreement End Date', 'trim|required');
		$this->form_validation->set_rules('vat_no', 'VAT Number', 'trim|required');
		$this->form_validation->set_rules('vat_expiry', 'VAT Expiry', 'trim|required');
		$this->form_validation->set_rules('business_nature', 'Nature of Business', 'trim|required');
		$this->form_validation->set_rules('company_type', 'Type of Company', 'trim|required');
		$this->form_validation->set_rules('client_telephone', 'Client Telephone', 'trim|required');
		$this->form_validation->set_rules('client_fax', 'Client Fax', 'trim|required');
		$this->form_validation->set_rules('region_id', 'Region ID', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if (empty($this->input->post('id'))) {
			$this->form_validation->set_rules('mobile', 'Mobile', 'numeric|required|is_unique[delivery_partner.mobile]', array('is_unique' => 'This mobile number is already registered.'));
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[delivery_partner.email]', array('is_unique' => 'This email is already registered.'));
			$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|is_unique[delivery_partner.cr_no]', array('is_unique' => 'This CR Number is already used.'));
		} else {
			$this->form_validation->set_rules('mobile', 'Mobile', 'numeric|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
			$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "0--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Logistic_Partner_model->update_basic();
				if ($query) {
					$this->session->set_userdata('info', "1--Basic detail successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
				redirect('admin/logistic-partner/add?id=' . $this->input->post('id'));
			} else {
				$hashpassword = $this->enc_lib->encrypt(uniqid());
				$query = $this->Logistic_Partner_model->add_basic($hashpassword);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Basic detail successfully added");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/logistic-partner/list');
	}
	/*
	public function save_contact_info(){
		$this->form_validation->set_rules('partner_id', 'Partner ID', 'trim|required');
		$this->form_validation->set_rules('building_no', 'Building Number', 'trim|required');
		$this->form_validation->set_rules('district', 'District', 'trim|required');
		$this->form_validation->set_rules('region_id', 'Region', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$query = $this->Logistic_Partner_model->update_contact_info();
			if($query){
				$this->session->set_userdata('info', "1--Contact detail successfully updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/logistic-partner/add?id='. $this->input->post('partner_id'));
	}
	*/
	public function save_bank_info()
	{
		$this->form_validation->set_rules('partner_id', 'Partner ID', 'trim|required');
		$this->form_validation->set_rules('bank_account_no', 'Bank Accounrt Number', 'trim|required');
		$this->form_validation->set_rules('account_holder_name', 'Holder Name', 'trim|required');
		$this->form_validation->set_rules('iban_number', 'IBAN Number', 'trim|required');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
		$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
		$this->form_validation->set_rules('region', 'Region', 'trim|required');
		$this->form_validation->set_rules('account_currency', 'Account Currency', 'trim|required');
		$this->form_validation->set_rules('bank_city', 'Bank City', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Logistic_Partner_model->update_bank_detail();
			if ($query) {
				$this->session->set_userdata('info', "1--Bank detail successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/logistic-partner/add?id=' . $this->input->post('partner_id'));
	}

	public function save_commission_info()
	{
		$this->form_validation->set_rules('partner_id', 'Partner ID', 'trim|required');
		$this->form_validation->set_rules('min_range[]', 'Minimum Order', 'trim|required');
		$this->form_validation->set_rules('max_range[]', 'Maximum Order', 'trim|required');
		$this->form_validation->set_rules('comm_amount[]', 'Commission Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Logistic_Partner_model->update_commission_detail();
			if ($query) {
				$this->session->set_userdata('info', "1--Commission successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/logistic-partner/add?id=' . $this->input->post('partner_id'));
	}

	# Files Upload Start
	public function upload_cr_certificate()
	{
		$query = $this->Logistic_Partner_model->upload_cr_certificate();
		//'<pre>';print_r($query);'</pre>';exit();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_vat_certificate()
	{
		$query = $this->Logistic_Partner_model->upload_vat_certificate();
		//'<pre>';print_r($query);'</pre>';exit();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_iban_certificate()
	{
		$query = $this->Logistic_Partner_model->upload_iban_certificate();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_owner_id()
	{
		$query = $this->Logistic_Partner_model->upload_owner_id();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_credit_agreement()
	{
		$query = $this->Logistic_Partner_model->upload_credit_agreement();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_authorization_copy()
	{
		$query = $this->Logistic_Partner_model->upload_authorization_copy();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_authorize_person_id()
	{
		$query = $this->Logistic_Partner_model->upload_authorize_person_id();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}
	#End

	public function verify()
	{
		$this->form_validation->set_rules('id', 'Partner ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data['err'] = validation_errors();
		} else {
			$verified_at = CURRENT_TIME;
			$query = $this->db->query("UPDATE delivery_partner SET application_status = 'verified', verified_at = '" . $verified_at . "', updated_at = NOW() WHERE id ='" . (int)$this->input->post('id') . "' LIMIT 1");
			if ($query) {
				$data['succ'] = 'Successfully verified.';
				$emp_detail = $this->db->query("SELECT id, customer_no, cr_no, name, company_name, account_manager, email, password from delivery_partner WHERE id = '" . (int)$this->input->post('id') . "'")->row();
				$email = $emp_detail->email;
				$other['username'] = $emp_detail->cr_no;
				$other['company_name'] = $emp_detail->company_name;
				$hashpassword = $this->enc_lib->dycrypt($emp_detail->password);
				$manager = employeeDetailHelper($emp_detail->account_manager);
				$other['manager_detail'] = $manager;
				send_logistic_credential($email, $hashpassword, $other);
			} else {
				$data['err'] = 'Something went wrong, try again.';
			}
		}
		echo json_encode($data);
	}

	public function get_van_report()
	{
		$id = $this->input->get("id");
		$data['partner_details'] = $this->Logistic_Partner_model->get_category_by_id($id);
		$data['results'] = $this->Logistic_Partner_model->get_van_pid($id);
		//print_r($data['results']);exit();
		$this->load->view('admin/logistic_partner/delivery_van_list', $data);
	}

	public function setStatusEnable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Logistic_Partner_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/logistic_partner');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Logistic_Partner_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/logistic_partner');
		} else {
			redirect('admin');
		}
	}

	public function details()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_logistic_partner', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Logistic_Partner_model->get_detail($this->input->get('id'))->row();
			$docs = $this->Logistic_Partner_model->documents($this->input->get('id'));
			$other_info = $this->Logistic_Partner_model->partner_info($this->input->get('id'));
			$bank_info = $this->Logistic_Partner_model->bank_info($this->input->get('id'));
			$rider_list = $this->Logistic_Partner_model->rider_list($this->input->get('id'));
			$commissions = $this->Logistic_Partner_model->commssion_info($this->input->get('id'));
			$data['id'] = $query->id;
			$data['customer_no'] = $query->customer_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['email'] = $query->email;
			$data['status'] = $query->status;
			$data['company_name'] = $query->company_name;
			$data['company_arabic_name'] = $query->company_arabic_name;
			$data['business_nature'] = $query->business_nature;
			$data['account_manager'] = $query->account_manager;
			$data['company_type'] = $query->company_type;
			$data['client_telephone'] = $query->client_telephone;
			$data['client_fax'] = $query->client_fax;
			$data['cr_no'] = $query->cr_no;
			$data['cr_expiry'] = $query->cr_expiry;
			$data['vat_no'] = $query->vat_no;
			$data['vat_expiry'] = $query->vat_expiry;
			$data['agreement_start'] = $query->agreement_start;
			$data['agrement_expiry'] = $query->agrement_expiry;
			$data['application_status'] = $query->application_status;

			$data['partner_basic_status'] = $query->partner_basic_status;
			$data['partner_bank_status'] = $query->partner_bank_status;
			$data['partner_docs_status'] = $query->partner_docs_status;

			$data['other_info'] = $other_info;
			$data['documents'] = $docs;
			$data['bank_info'] = $bank_info;
			$data['rider_list'] = $rider_list;
			$data['commissions'] = $commissions;
		} else {
			$this->session->set_userdata('info', "2--Invalid User");
			redirect('admin/logistic-partner/list');
		}
		//print_r($data['partners']);exit();
		$this->load->view('admin/logistic_partner/detail', $data);
	}

	public function change_password()
	{
		$this->form_validation->set_rules('id', 'Partner ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[55]', array('min_length' => 'Password Min length should be 6 character'));
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			$this->session->set_userdata('info', "2--" . $msg);
		} else {
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$query = $this->Logistic_Partner_model->change_password($hashpassword);
			if ($query) {
				$this->session->set_userdata('info', "1--Password Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error occured, Try again");
			}
		}
		redirect('admin/logistic-partner/detail?id=' . $this->input->post('id'));
	}

	public function getLoginDetail()
	{
		$login_id = $this->input->post("login_id");
		$result = $this->db->query("SELECT password from delivery_partner WHERE id = '" . $login_id . "'")->row();
		$hashpassword = $this->enc_lib->dycrypt($result->password);
		$data['password'] = $hashpassword;
		echo json_encode($data);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_logistic_partner', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Logistic_Partner_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/logistic_partner');
	}

	public function sendManualCredential()
	{
		$id = $this->input->get("id");
		if ($id > 0) {
			$result = $this->db->query("SELECT id, customer_no, cr_no, name, company_name, account_manager, email, password from delivery_partner WHERE id = '" . $id . "'");
			if ($result->num_rows() > 0) {
				$emp_detail = $result->row();
				$id = $emp_detail->id;
				$hashpassword = $this->enc_lib->dycrypt($emp_detail->password);
				$username = $emp_detail->cr_no;
				$email = $emp_detail->email;
				$manager = employeeDetailHelper($emp_detail->account_manager);
				$data['manager_detail'] = $manager;
				$data['username'] = $username;
				$data['company_name'] = $emp_detail->company_name;
				//print_r($data);exit();
				$response = send_logistic_credential($email, $hashpassword, $data);
				if ($response) {
					$this->session->set_userdata('info', "1--Successfully send");
					redirect('admin/logistic-partner/detail?id=' . $id);
				} else {
					$this->session->set_userdata('info', "2--Error");
				}
			} else {
				$this->session->set_userdata('info', "2--User not found");
			}
		} else {
			$this->session->set_userdata('info', "2--Invalid request");
		}
		redirect('admin/logistic-partner/list');
	}
}
