<?php defined('BASEPATH') or exit('No direct script access allowed');

class Corporate_user extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->admin->isLogged()) {
			$this->load->model('admin/User_model');
			$this->load->model('admin/Common_model');
			$this->load->library('form_validation');
			/*----- Encryption -------*/
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			/*----- Encryption End -------*/
			$this->load->helper('Common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function business_user()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_corporate_clients', $this->action)) {
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
		$this->load->view('admin/user/business_user_list', $data);
	}

	public function add_business()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_corporate_clients', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$id = $this->input->get('id');
			$query = $this->User_model->get_customer($id)->row();
			$user_info = $this->User_model->get_info($id);
			$user_bank_info = $this->User_model->get_bank_info($id);
			$user_docs = $this->User_model->get_docs($id);
			$data['corporate_address'] = $this->User_model->get_corporate_address($id);
			$data['corporate_logins'] = $this->User_model->get_corporate_logins($id);
			$data['id'] = $query->id;
			$data['customer_no'] = $query->customer_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['role_id'] = $query->role_id;
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
			if (!empty($user_info)) {
				$data['building_no'] = $user_info->building_no;
				$data['street_name'] = $user_info->street_name;
				$data['district'] = $user_info->district;
				$data['region_id'] = $user_info->region_id;
				$data['city'] = $user_info->city;
				$data['country'] = $user_info->country;
				$data['postal_code'] = $user_info->postal_code;
				$data['additional_no'] = $user_info->additional_no;
				$data['unit_no'] = $user_info->unit_no;
				$data['short_address'] = $user_info->short_address;
				$data['website'] = $user_info->website;

				$data['authorize_ids'] = $user_info->authorize_ids;
				$data['director_name1'] = $user_info->director_name1;
				$data['director_id_no1'] = $user_info->director_id_no1;
				$data['director_mobile1'] = $user_info->director_mobile1;
				$data['director_email1'] = $user_info->director_email1;

				$data['director_name2'] = $user_info->director_name2;
				$data['director_id_no2'] = $user_info->director_id_no2;
				$data['director_mobile2'] = $user_info->director_mobile2;
				$data['director_email2'] = $user_info->director_email2;

				$data['sales_name'] = $user_info->sales_name;
				$data['sales_id_no'] = $user_info->sales_id_no;
				$data['sales_mobile'] = $user_info->sales_mobile;
				$data['sales_email'] = $user_info->sales_email;

				$data['finance_name'] = $user_info->finance_name;
				$data['finance_id_no'] = $user_info->finance_id_no;
				$data['finance_mobile'] = $user_info->finance_mobile;
				$data['finance_email'] = $user_info->finance_email;

				$data['legal_name'] = $user_info->legal_name;
				$data['legal_id_no'] = $user_info->legal_id_no;
				$data['legal_mobile'] = $user_info->legal_mobile;
				$data['legal_email'] = $user_info->legal_email;

				$data['other_name'] = $user_info->other_name;
				$data['other_id_no'] = $user_info->other_id_no;
				$data['other_mobile'] = $user_info->other_mobile;
				$data['other_email'] = $user_info->other_email;
			} else {
				$data['building_no'] = "";
				$data['street_name'] = "";
				$data['district'] = "";
				$data['region_id'] = "";
				$data['city'] = "";
				$data['country'] = "";
				$data['postal_code'] = "";
				$data['additional_no'] = "";
				$data['unit_no'] = "";
				$data['short_address'] = "";
				$data['website'] = "";

				$data['authorize_ids'] = "";

				$data['director_name1'] = "";
				$data['director_id_no1'] = "";
				$data['director_mobile1'] = "";
				$data['director_email1'] = "";

				$data['director_name2'] = "";
				$data['director_id_no2'] = "";
				$data['director_mobile2'] = "";
				$data['director_email2'] = "";

				$data['sales_name'] = "";
				$data['sales_id_no'] = "";
				$data['sales_mobile'] = "";
				$data['sales_email'] = "";

				$data['finance_name'] = "";
				$data['finance_id_no'] = "";
				$data['finance_mobile'] = "";
				$data['finance_email'] = "";

				$data['legal_name'] = "";
				$data['legal_id_no'] = "";
				$data['legal_mobile'] = "";
				$data['legal_email'] = "";

				$data['other_name'] = "";
				$data['other_id_no'] = "";
				$data['other_mobile'] = "";
				$data['other_email'] = "";
			}

			if (!empty($user_bank_info)) {
				$data['bank_account_no'] = $user_bank_info->bank_account_no;
				$data['account_holder_name'] = $user_bank_info->account_holder_name;
				$data['iban_number'] = $user_bank_info->iban_number;
				$data['bank_name'] = $user_bank_info->bank_name;
				$data['branch_name'] = $user_bank_info->branch_name;
				$data['region'] = $user_bank_info->region;
				$data['account_currency'] = $user_bank_info->account_currency;
				$data['swift_code'] = $user_bank_info->swift_code;
				$data['bank_city'] = $user_bank_info->bank_city;
			} else {
				$data['bank_account_no'] = "";
				$data['account_holder_name'] = "";
				$data['iban_number'] = "";
				$data['bank_name'] = "";
				$data['branch_name'] = "";
				$data['region'] = "";
				$data['account_currency'] = "";
				$data['swift_code'] = "";
				$data['bank_city'] = "";
			}

			if (!empty($user_docs)) {
				$data['cr_certificate'] = $user_docs->cr_certificate;
				$data['iban_certificate'] = $user_docs->iban_certificate;
				$data['owner_id'] = $user_docs->owner_id;
				$data['credit_agreement'] = $user_docs->credit_agreement;
				$data['authorization_copy'] = $user_docs->authorization_copy;
				$data['authorize_person_id'] = $user_docs->authorize_person_id;
				$data['vat_certificate'] = $user_docs->vat_certificate;
			} else {
				$data['cr_certificate'] = "";
				$data['iban_certificate'] = "";
				$data['owner_id'] = "";
				$data['credit_agreement'] = "";
				$data['authorization_copy'] = "";
				$data['authorize_person_id'] = "";
				$data['vat_certificate'] = "";
			}
		} else {
			$last_cno = $this->db->query("SELECT id FROM customer ORDER BY id DESC")->row();
			$new_customer_no = str_pad(((int)$last_cno->id + 101), 6, 0, STR_PAD_LEFT);
			$data['id'] = "";
			$data['customer_no'] = $new_customer_no;
			$data['name'] = "";
			$data['mobile'] = "";
			$data['role_id'] = "";
			$data['email'] = "";
			$data['status'] = "";
			$data['company_name'] = "";
			$data['company_arabic_name'] = "";
			$data['account_manager'] = "";
			$data['client_telephone'] = "";
			$data['client_fax'] = "";
			$data['cr_no'] = "";
			$data['cr_expiry'] = "";
			$data['vat_no'] = "";
			$data['business_nature'] = "";
			$data['company_type'] = "";
			$data['vat_expiry'] = "";
			$data['agreement_start'] = "";
			$data['agrement_expiry'] = "";

			$data['building_no'] = "";
			$data['street_name'] = "";
			$data['district'] = "";
			$data['region_id'] = "";
			$data['city'] = "";
			$data['country'] = "";
			$data['postal_code'] = "";
			$data['additional_no'] = "";
			$data['unit_no'] = "";
			$data['short_address'] = "";
			$data['website'] = "";

			$data['authorize_ids'] = "";
			$data['director_name1'] = "";
			$data['director_id_no1'] = "";
			$data['director_mobile1'] = "";
			$data['director_email1'] = "";

			$data['director_name2'] = "";
			$data['director_id_no2'] = "";
			$data['director_mobile2'] = "";
			$data['director_email2'] = "";

			$data['sales_name'] = "";
			$data['sales_id_no'] = "";
			$data['sales_mobile'] = "";
			$data['sales_email'] = "";

			$data['finance_name'] = "";
			$data['finance_id_no'] = "";
			$data['finance_mobile'] = "";
			$data['finance_email'] = "";

			$data['legal_name'] = "";
			$data['legal_id_no'] = "";
			$data['legal_mobile'] = "";
			$data['legal_email'] = "";

			$data['other_name'] = "";
			$data['other_id_no'] = "";
			$data['other_mobile'] = "";
			$data['other_email'] = "";

			$data['bank_account_no'] = "";
			$data['account_holder_name'] = "";
			$data['iban_number'] = "";
			$data['bank_name'] = "";
			$data['branch_name'] = "";
			$data['region'] = "";
			$data['account_currency'] = "";
			$data['swift_code'] = "";
			$data['bank_city'] = "";

			$data['cr_certificate'] = "";
			$data['iban_certificate'] = "";
			$data['owner_id'] = "";
			$data['credit_agreement'] = "";
			$data['authorization_copy'] = "";
			$data['authorize_person_id'] = "";
			$data['vat_certificate'] = "";
		}
		$data['regions'] = $this->Common_model->get_regions()->result();
		$data['cities'] = $this->Common_model->get_cities()->result();
		$data['master_banks'] = $this->User_model->master_banks();
		$this->load->view('admin/user/user_form', $data);
	}

	public function save_business_customer()
	{
		$this->form_validation->set_rules('company_name', 'Legal Name', 'trim|required');
		$this->form_validation->set_rules('role_id', 'Please select valid account type', 'numeric|required');
		//$this->form_validation->set_rules('ref_code', 'Invalid Referal Code', 'callback_referal_exists');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if (empty($this->input->post('id'))) {
			$this->form_validation->set_rules('mobile', 'Mobile', 'numeric|required|is_unique[customer.mobile]', array('is_unique' => 'This mobile number is already registered.'));
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[customer.email]', array('is_unique' => 'This email is already registered.'));
			$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|is_unique[customer.cr_no]', array('is_unique' => 'This CR Number is already used.'));
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		} else {
			$this->form_validation->set_rules('mobile', 'Mobile', 'numeric|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
			$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "0--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				//print_r($this->input->post());exit();
				$query = $this->User_model->manage_business_customer();
			} else {
				$query = $this->User_model->add_business_customer();
			}
			if ($query) {
				if ($this->input->post('id')) {
					$this->session->set_userdata('info', "1--Client successfully updated");
				} else {
					$this->session->set_userdata('info', "1--Client successfully created");
				}
			} else {
				$this->session->set_userdata('info', "0--Some error occured");
			}
		}
		redirect('admin/business-user/list');
	}

	function insert_ref_code($user_id, $refered_code, $email)
	{
		$Random2Digit = mt_rand(10, 99);
		$RefCode = $Random2Digit . 'BS' . $user_id;
		$is_ref_used = 0;
		$query = $this->db->query("INSERT INTO referrals SET referral_code = '" . $this->db->escape_str($RefCode) . "', user_id = '" . $this->db->escape_str((int)$user_id) . "', refered_code = '" . $refered_code . "', user_email = '" . $email . "', is_ref_used = '" . $is_ref_used . "', updated_at = NOW()");
		return $query;
	}

	public function delete_corporate()
	{
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->User_model->delete_corporate($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/business-user/list');
	}

	public function corporate_detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_corporate_clients', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		$query = $this->User_model->get_customer($id)->row();
		$user_info = $this->User_model->get_info($id);
		$user_bank_info = $this->User_model->get_bank_info($id);
		$user_docs = $this->User_model->get_docs($id);

		$data['id'] = $query->id;
		$data['customer_no'] = $query->customer_no;
		$data['name'] = $query->name;
		$data['mobile'] = $query->mobile;
		$data['role_id'] = $query->role_id;
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
		$data['credit_account'] = $query->credit_account;
		$data['wallet'] = $query->wallet;
		$data['rewards'] = $query->rewards;
		if (!empty($user_info)) {
			$data['building_no'] = $user_info->building_no;
			$data['street_name'] = $user_info->street_name;
			$data['district'] = $user_info->district;
			$data['region_id'] = $user_info->region_id;
			$data['city'] = $user_info->city;
			$data['country'] = $user_info->country;
			$data['postal_code'] = $user_info->postal_code;
			$data['additional_no'] = $user_info->additional_no;
			$data['unit_no'] = $user_info->unit_no;
			$data['short_address'] = $user_info->short_address;
			$data['website'] = $user_info->website;

			$data['authorize_ids'] = $user_info->authorize_ids;
			$data['director_name1'] = $user_info->director_name1;
			$data['director_id_no1'] = $user_info->director_id_no1;
			$data['director_mobile1'] = $user_info->director_mobile1;
			$data['director_email1'] = $user_info->director_email1;

			$data['director_name2'] = $user_info->director_name2;
			$data['director_id_no2'] = $user_info->director_id_no2;
			$data['director_mobile2'] = $user_info->director_mobile2;
			$data['director_email2'] = $user_info->director_email2;

			$data['sales_name'] = $user_info->sales_name;
			$data['sales_id_no'] = $user_info->sales_id_no;
			$data['sales_mobile'] = $user_info->sales_mobile;
			$data['sales_email'] = $user_info->sales_email;

			$data['finance_name'] = $user_info->finance_name;
			$data['finance_id_no'] = $user_info->finance_id_no;
			$data['finance_mobile'] = $user_info->finance_mobile;
			$data['finance_email'] = $user_info->finance_email;

			$data['legal_name'] = $user_info->legal_name;
			$data['legal_id_no'] = $user_info->legal_id_no;
			$data['legal_mobile'] = $user_info->legal_mobile;
			$data['legal_email'] = $user_info->legal_email;

			$data['other_name'] = $user_info->other_name;
			$data['other_id_no'] = $user_info->other_id_no;
			$data['other_mobile'] = $user_info->other_mobile;
			$data['other_email'] = $user_info->other_email;
		} else {
			$data['building_no'] = "";
			$data['street_name'] = "";
			$data['district'] = "";
			$data['region_id'] = "";
			$data['city'] = "";
			$data['country'] = "";
			$data['postal_code'] = "";
			$data['additional_no'] = "";
			$data['unit_no'] = "";
			$data['short_address'] = "";
			$data['website'] = "";

			$data['authorize_ids'] = "";
			$data['director_name1'] = "";
			$data['director_id_no1'] = "";
			$data['director_mobile1'] = "";
			$data['director_email1'] = "";

			$data['director_name2'] = "";
			$data['director_id_no2'] = "";
			$data['director_mobile2'] = "";
			$data['director_email2'] = "";

			$data['sales_name'] = "";
			$data['sales_id_no'] = "";
			$data['sales_mobile'] = "";
			$data['sales_email'] = "";

			$data['finance_name'] = "";
			$data['finance_id_no'] = "";
			$data['finance_mobile'] = "";
			$data['finance_email'] = "";

			$data['legal_name'] = "";
			$data['legal_id_no'] = "";
			$data['legal_mobile'] = "";
			$data['legal_email'] = "";

			$data['other_name'] = "";
			$data['other_id_no'] = "";
			$data['other_mobile'] = "";
			$data['other_email'] = "";
		}

		if (!empty($user_bank_info)) {
			$data['bank_account_no'] = $user_bank_info->bank_account_no;
			$data['account_holder_name'] = $user_bank_info->account_holder_name;
			$data['iban_number'] = $user_bank_info->iban_number;
			$data['bank_name'] = $user_bank_info->bank_name;
			$data['branch_name'] = $user_bank_info->branch_name;
			$data['region'] = $user_bank_info->region;
			$data['account_currency'] = $user_bank_info->account_currency;
			$data['swift_code'] = $user_bank_info->swift_code;
			$data['bank_city'] = $user_bank_info->bank_city;
		} else {
			$data['bank_account_no'] = "";
			$data['account_holder_name'] = "";
			$data['iban_number'] = "";
			$data['bank_name'] = "";
			$data['branch_name'] = "";
			$data['region'] = "";
			$data['account_currency'] = "";
			$data['swift_code'] = "";
			$data['bank_city'] = "";
		}

		if (!empty($user_docs)) {
			$data['cr_certificate'] = $user_docs->cr_certificate;
			$data['iban_certificate'] = $user_docs->iban_certificate;
			$data['owner_id'] = $user_docs->owner_id;
			$data['credit_agreement'] = $user_docs->credit_agreement;
			$data['authorization_copy'] = $user_docs->authorization_copy;
			$data['authorize_person_id'] = $user_docs->authorize_person_id;
			$data['vat_certificate'] = $user_docs->vat_certificate;
		} else {
			$data['cr_certificate'] = "";
			$data['iban_certificate'] = "";
			$data['owner_id'] = "";
			$data['credit_agreement'] = "";
			$data['authorization_copy'] = "";
			$data['authorize_person_id'] = "";
			$data['vat_certificate'] = "";
		}
		$data['addresses'] = $this->User_model->get_address($id);
		$data['corporate_logins'] = $this->User_model->get_corporate_logins($id);
		$data['docs'] = $this->User_model->get_docs($id);
		$data['corporate_address'] = $this->User_model->get_corporate_address($id);
		$data['orders'] = $this->User_model->get_orders_by_id($id);
		$data['credit_account_info'] = $this->User_model->get_credit_by_id($id);
		$data['regions'] = $this->Common_model->get_regions()->result();
		$data['cities'] = $this->Common_model->get_cities()->result();
		$data['master_banks'] = $this->User_model->master_banks();
		//print_r($data['corporate_address']);exit();
		$this->load->view('admin/user/corporate-detail', $data);
	}

	public function getCities()
	{
		$cities = $this->User_model->get_cities($this->input->post('parent'));
		echo json_encode($cities);
	}

	public function referral_report()
	{
		$ref_code = $this->input->get('ref_code');
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['reports'] = $this->User_model->get_referal_report($ref_code);
		//echo '<pre>';print_r($data['result']);'</pre>';exit();
		$this->load->view('admin/user/ref_report', $data);
	}

	public function orders()
	{
		$id = $this->input->get('id');
		$data['orders'] = $this->User_model->get_orders_by_id($id);
		//print_r($data['orders']);exit();
		$this->load->view('admin/user/order_list', $data);
	}

	public function get_business_list()
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
		if (!empty($this->input->get('company_type'))) {
			$company_type = $this->input->get('company_type');
		} else {
			$company_type = FALSE;
		}
		if (!empty($this->input->get('account_manager'))) {
			$account_manager = $this->input->get('account_manager');
		} else {
			$account_manager = FALSE;
		}
		if (!empty($this->input->get('business_nature'))) {
			$business_nature = $this->input->get('business_nature');
		} else {
			$business_nature = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		$fetch_data = $this->User_model->get_business_list($keyword, $status, $company_type, $account_manager, $business_nature, $from, $to);
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $user) {
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $user->id . '" />';
			$sub_array[] = $user->customer_no;
			$sub_array[] = $user->company_name;
			$sub_array[] = $user->email;
			$sub_array[] = $user->mobile;
			$sub_array[] = $user->role_id == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Normal</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Business</span>';
			$sub_array[] = ($user->credit_account == 0) ? '<span class="badge badge-pill badge-soft-warning font-size-13">Not Open</span>' : (($user->credit_account == 1) ? '<span class="badge badge-pill badge-soft-primary font-size-13">Not Active</span>' : (($user->credit_account == 2) ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Suspended</span>'));
			$sub_array[] = $user->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : ($user->status == 2 ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>');
			$sub_array[] = $user->total_orders;
			$sub_array[] = $user->total_order_value;
			$sub_array[] = $user->wallet;
			$sub_array[] = date("d-m-y h:i A", strtotime($user->created));
			$sub_array[] = (check_action_permission(get_user_role(), 'manage_corporate_clients', 'add_business') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/user/business-form?id=' . $user->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'manage_corporate_clients', 'corporate_detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="' . base_url() . 'admin/user/corporate-detail?id=' . $user->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');
			$data[] = $sub_array;
		}

		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->User_model->get_all_business_data(),
			"recordsFiltered"     =>     $this->User_model->get_filtered_business_data($keyword, $status, $company_type, $account_manager, $business_nature, $from, $to),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function update_rewards()
	{
		$this->form_validation->set_rules('uid', 'User Id', 'trim|required');
		$this->form_validation->set_rules('rewards', 'Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>' . $msg . '</div>';
			exit();
		} else {
			if ($this->input->post('uid')) {
				$query = $this->User_model->updateRewards();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
			if ($query) {
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Rewards Amount Successfully Updated</div>';
				exit();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
		}
	}

	public function update_wallet()
	{
		$this->form_validation->set_rules('uid', 'User Id', 'trim|required');
		$this->form_validation->set_rules('wallet', 'Amount', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>' . $msg . '</div>';
			exit();
		} else {
			if ($this->input->post('uid')) {
				$query = $this->User_model->updateWallet();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
			if ($query) {
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Wallet Amount Successfully Updated</div>';
				exit();
			} else {
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';
				exit();
			}
		}
	}

	public function edit_docs()
	{
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['docs'] = $this->User_model->get_docs($id);
		$this->load->view('admin/user/docs_form', $data);
	}

	public function submit_docs()
	{
		if ($this->input->post('id')) {
			$query = $this->User_model->update_docs();
			if ($query) {
				$this->session->set_userdata('info', "1--You have successfully updated documents");
				redirect('admin/business-user/list');
			} else {
				$this->session->set_userdata('danger', "2--Some error occures!!!");
				redirect('admin/business-user/list');
			}
		} else {
			$query = $this->User_model->add_docs();
			if ($query) {
				$this->session->set_userdata('info', "1--You have successfully updated documents");
				redirect('admin/business-user/list');
			} else {
				$this->session->set_userdata('danger', "2--Some error occures!!!");
				redirect('admin/business-user/list');
			}
		}
	}

	public function wallet_report()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['reports'] = $this->User_model->get_wallet_report($id);
		$data['total_credit'] = $this->User_model->getCreditWallet($id);
		$data['total_debit'] = $this->User_model->getDebitWallet($id);
		$data['total_trans'] = $this->User_model->get_all_report($id);
		$this->load->view('admin/user/wallet_report', $data);
	}

	public function rewards_report()
	{
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$id = $this->input->get('id');
		$data['result'] = $this->User_model->get_customer($id)->row();
		$data['reports'] = $this->User_model->get_rewards_report($id);
		$data['total_credit'] = $this->User_model->getCreditRewards($id);
		$data['total_debit'] = $this->User_model->getDebitRewards($id);
		$data['total_trans'] = $this->User_model->get_all_rewards_report($id);
		$this->load->view('admin/user/rewards_report', $data);
	}

	public function add_corporate_address()
	{
		$this->form_validation->set_rules('customer_id', 'Customer ID', 'required');
		$this->form_validation->set_rules('person_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');
		$this->form_validation->set_rules('house_type', 'Address Type', 'required');
		$this->form_validation->set_rules('address_type', 'Address Label', 'required');
		$this->form_validation->set_rules('villa_building', 'Villa or Building Number', 'required');
		$this->form_validation->set_rules('postal', 'Postal', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('email', 'Mobile', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		$this->form_validation->set_rules('lat', 'Select valid address from map', 'required');
		$this->form_validation->set_rules('lng', 'Select valid address from map', 'required');
		$this->form_validation->set_rules('place_id', 'Select valid address from map', 'required');
		$this->form_validation->set_rules('complete_address', 'Select valid address from map', 'required');
		$id = $this->input->post('customer_id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('admin/user/business-form?id=' . $id);
		} else {
			$address_id = $this->input->post('address_id');
			if ($address_id > 0) {
				$query = $this->User_model->edit_corporate_address($address_id);
			} else {
				$query = $this->User_model->add_corporate_address();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Address successfully updated");
				redirect('admin/user/business-form?id=' . $id);
			} else {
				$this->session->set_userdata('info', "2--Some error occured!!!");
				redirect('admin/user/business-form?id=' . $id);
			}
		}
	}

	public function edit_corporate_address()
	{
		$this->form_validation->set_rules('id', 'Address ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('msg', validation_errors());
			$this->session->set_flashdata('is_success', '0');
			echo 'Invalid Address ID';
		} else {
			$id = $this->input->post('id');
			$result = $this->User_model->get_corporate_address_single($id);
			$data = $this->load->view('admin/user/quick-address-edit', $result, TRUE);
			echo $data;
		}
	}

	public function delete_address()
	{
		$address_id = $this->input->get('id');
		if ($address_id > 0) {
			$query = $this->User_model->delete_address($address_id);
		} else {
			$this->session->set_userdata('info', "2--Invalid ID!!!");
			redirect('admin/business-user/list');
		}
		if ($query) {
			$this->session->set_userdata('info', "1--Address successfully deleted");
			redirect('admin/business-user/list');
		} else {
			$this->session->set_userdata('info', "2--Some error occured!!!");
			redirect('admin/business-user/list');
		}
	}

	/*------- Corporate Logins ------*/

	public function add_login_ajax()
	{
		$this->form_validation->set_rules('main_id', 'Client ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('msg', validation_errors());
			$this->session->set_flashdata('is_success', '0');
			echo 'Invalid Client ID';
		} else {
			$main_id = $this->input->post('main_id');
			$result = $this->db->query("SELECT id FROM customer WHERE id='" . $main_id . "' AND role_id = '2'")->num_rows();
			if ($result > 0) {
				$loginInfo['main_id'] = $main_id;
				$loginInfo['login_id'] = '';
				$loginInfo['display_name'] = '';
				$loginInfo['username'] = '';
				$loginInfo['login_role'] = '';
				$loginInfo['login_status'] = '';
				$loginInfo['login_email'] = '';
				$loginInfo['login_phone'] = '';
				$data = $this->load->view('admin/user/user_login_ajax', $loginInfo, TRUE);
			}
			echo $data;
		}
	}

	public function edit_login_ajax()
	{
		$this->form_validation->set_rules('login_id', 'Login ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('msg', validation_errors());
			$this->session->set_flashdata('is_success', '0');
			echo 'Invalid Client ID';
		} else {
			$login_id = $this->input->post('login_id');
			$result = $this->User_model->get_corporate_login_single($login_id);
			if ($result) {
				$loginInfo['main_id'] = $result->main_id;
				$loginInfo['login_id'] = $result->id;
				$loginInfo['display_name'] = $result->display_name;
				$loginInfo['username'] = $result->username;
				$loginInfo['login_role'] = $result->login_role;
				$loginInfo['login_status'] = $result->status;
				$loginInfo['login_email'] = $result->login_email;
				$loginInfo['login_phone'] = $result->login_phone;
				$data = $this->load->view('admin/user/user_login_ajax', $loginInfo, TRUE);
			}
			echo $data;
		}
	}

	public function add_corporate_login()
	{
		$this->form_validation->set_rules('main_id', 'Corporate ID', 'required', array('required' => 'Invalid Corporate User'));
		if ($this->input->post('login_id') > 0) {
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
		} else {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[corporate_logins.username]', array('is_unique' => 'This username is already taken, try new.'));
		}
		$this->form_validation->set_rules('display_name', 'Person Name', 'required');
		$this->form_validation->set_rules('login_role', 'Role type', 'required');

		$id = $this->input->post('main_id');
		$login_id = $this->input->post('login_id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('admin/user/business-form?id=' . $id);
		} else {
			$password = $this->role->get_random_password($chars_min = 8, $chars_max = 14, $use_upper_case = true, $include_numbers = true, $include_special_chars = true);
			$hashpassword = $this->enc_lib->encrypt($password);
			if ($login_id > 0) {
				$query = $this->User_model->update_corporate_login();
			} else {
				$query = $this->User_model->add_corporate_logins($hashpassword);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Login detail successfully added!");
				redirect('admin/user/business-form?id=' . $id);
			} else {
				$this->session->set_userdata('info', "2--Some error occured!!!");
				redirect('admin/user/business-form?id=' . $id);
			}
		}
	}

	public function getCorporateLoginDetail()
	{
		$login_id = $this->input->post("login_id");
		$result = $this->User_model->getLoginDetail($login_id);
		$hashpassword = $this->enc_lib->dycrypt($result->password);
		$data['password'] = $hashpassword;
		echo json_encode($data);
	}

	public function delete_corporate_login()
	{
		$id = $this->input->get('id');
		$main_id = $this->input->get('main_id');
		if ($id > 0) {
			$query = $this->User_model->delete_corporate_login($id, $main_id);
		} else {
			$this->session->set_userdata('info', "2--Invalid ID!!!");
			redirect('admin/user/business-form?id=' . $main_id);
		}
		if ($query) {
			$this->session->set_userdata('info', "1--Login successfully deleted");
			redirect('admin/user/business-form?id=' . $main_id);
		} else {
			$this->session->set_userdata('info', "2--Some error occured!!!");
			redirect('admin/user/business-form?id=' . $main_id);
		}
	}

	public function print_credit_application()
	{
		$this->load->library('Pdf_credit_application');
		$id = $this->input->get('id');
		$data['user'] = $this->User_model->get_credit_user($id)->row();
		$data['user_info'] = $this->User_model->get_info($id);
		$data['bank_info'] = $this->User_model->get_bank_info($id);
		//print_r($data['bank_info']);exit();
		// create new PDF document
		$pdf = new Pdf_credit_application(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('BS - Application For Credit Facility');
		$pdf->SetSubject('BS - Application For Credit Facility');
		$pdf->SetKeywords('Baqala Station, PDF, Application For Credit Facility');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true);
		// $htmlHeader = $this->load->view('admin/mobile-invoice/header/invoice_header_2',$order, true);
		// $htmlHeader2 = $this->load->view('admin/mobile-invoice/header/invoice_header2_2',$order, true);
		$htmlHeader = '';
		$htmlHeader2 = '';
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		// $lastFooter = $this->load->view('admin/mobile-invoice/footer/footer_last',$order, true);
		$lastFooter = '';
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
		$pdf->SetMargins(1, 60, 4, true);

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

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/user/print_creadit_application', $data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$pdf->Output('BS - Application For Credit Facility' . '.pdf', 'I');
	}
}
