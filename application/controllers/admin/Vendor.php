<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/Vendor_model');
			//$this->load->model('admin/Purchase_model');
			$this->load->library('form_validation');
			$this->action = $this->router->method;
		} else {
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_suppliers', $this->action)) {
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
		$this->load->view('admin/vendor/list', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_suppliers', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Vendor_model->get_vendor_by_id($this->input->get('id'));
			$vendor_docs = $this->Vendor_model->vendor_documents($this->input->get('id'));
			$vendor_bank = $this->Vendor_model->vendor_bank_account($this->input->get('id'));
			$data['id'] = $query->id;
			$data['vendor_name'] = $query->vendor_name;
			$data['vendor_arabic_name'] = $query->vendor_arabic_name;
			$data['contact_person_name'] = $query->contact_person_name;
			$data['vendor_type'] = $query->vendor_type;
			$data['spare_part_supplier'] = $query->spare_part_supplier;
			$data['agrement_expiry'] = $query->agrement_expiry;
			$data['cr_no'] = $query->cr_no;
			$data['cr_expiry'] = $query->cr_expiry;
			$data['vat_no'] = $query->vat_no;
			$data['vat_expiry'] = $query->vat_expiry;
			$data['fax'] = $query->fax;
			$data['telephone'] = $query->telephone;
			$data['vendor_email'] = $query->vendor_email;
			$data['website'] = $query->website;

			$data['sales_name'] = $query->sales_name;
			$data['sales_mobile'] = $query->sales_mobile;
			$data['sales_email'] = $query->sales_email;
			$data['finance_name'] = $query->finance_name;
			$data['finance_mobile'] = $query->finance_mobile;
			$data['finance_email'] = $query->finance_email;
			$data['legal_name'] = $query->legal_name;
			$data['legal_mobile'] = $query->legal_mobile;
			$data['legal_email'] = $query->legal_email;
			$data['other_name'] = $query->other_name;
			$data['other_mobile'] = $query->other_mobile;
			$data['other_email'] = $query->other_email;

			$data['building_no'] = $query->building_no;
			$data['street_name'] = $query->street_name;
			$data['district'] = $query->district;
			$data['city'] = $query->city;
			$data['country'] = $query->country;
			$data['postal_code'] = $query->postal_code;
			$data['additional_no'] = $query->additional_no;
			$data['unit_no'] = $query->unit_no;
			$data['short_address'] = $query->short_address;
			$data['payment_terms'] = $query->payment_terms;
			$data['order_currency'] = $query->order_currency;
			$data['credit_limit'] = $query->credit_limit;
			if (!empty($vendor_bank)) {
				$data['payment_info'] = $vendor_bank;
			} else {
				$data['payment_info'] = "";
			}
			if (!empty($vendor_docs)) {
				$data['cr_certificate'] = $vendor_docs->cr_certificate;
				$data['vat_certificate'] = $vendor_docs->vat_certificate;
				$data['national_address'] = $vendor_docs->national_address;
				$data['iban_letter'] = $vendor_docs->iban_letter;
				$data['credit_agreements'] = $vendor_docs->credit_agreements;
				$data['authorization'] = $vendor_docs->authorization;
			} else {
				$data['cr_certificate'] = "";
				$data['vat_certificate'] = "";
				$data['national_address'] = "";
				$data['iban_letter'] = "";
				$data['credit_agreements'] = "";
				$data['authorization'] = "";
			}

			$data['status'] = $query->status;
		} else {
			$data['id'] = "";
			$data['vendor_name'] = "";
			$data['vendor_arabic_name'] = "";
			$data['contact_person_name'] = "";
			$data['vendor_type'] = "";
			$data['spare_part_supplier'] = "";
			$data['agrement_expiry'] = "";
			$data['cr_no'] = "";
			$data['cr_expiry'] = "";
			$data['vat_no'] = "";
			$data['vat_expiry'] = "";
			$data['fax'] = "";
			$data['telephone'] = "";
			$data['vendor_email'] = "";
			$data['website'] = "";

			$data['sales_name'] = "";
			$data['sales_mobile'] = "";
			$data['sales_email'] = "";
			$data['finance_name'] = "";
			$data['finance_mobile'] = "";
			$data['finance_email'] = "";
			$data['legal_name'] = "";
			$data['legal_mobile'] = "";
			$data['legal_email'] = "";
			$data['other_name'] = "";
			$data['other_mobile'] = "";
			$data['other_email'] = "";

			$data['building_no'] = "";
			$data['street_name'] = "";
			$data['district'] = "";
			$data['city'] = "";
			$data['country'] = "";
			$data['postal_code'] = "";
			$data['additional_no'] = "";
			$data['unit_no'] = "";
			$data['short_address'] = "";
			$data['payment_terms'] = "";
			$data['order_currency'] = "";
			$data['credit_limit'] = "";

			$data['payment_info'] = "";

			$data['cr_certificate'] = "";
			$data['vat_certificate'] = "";
			$data['national_address'] = "";
			$data['iban_letter'] = "";
			$data['credit_agreements'] = "";
			$data['authorization'] = "";

			$data['status'] = "";
		}
		$data['master_cities'] = $this->Vendor_model->cities();
		$data['master_banks'] = $this->Vendor_model->master_banks();
		$this->load->view('admin/vendor/form', $data);
	}

	public function add_vendor()
	{
		$this->form_validation->set_rules('vendor_type', 'Vendor Type', 'trim|required');
		$this->form_validation->set_rules('vendor_name', 'Vendor Name', 'trim|required');
		$this->form_validation->set_rules('vendor_arabic_name', 'Arabic Name', 'trim|required');
		if ($this->input->post('vendor_type') !== 'saddad') {
			$this->form_validation->set_rules('contact_person_name', 'Contact Person', 'trim|required');
		}
		if ($this->input->post('vendor_type') == 'local') {
			$this->form_validation->set_rules('cr_no', 'CR Number', 'trim|required');
			$this->form_validation->set_rules('vat_no', 'VAT Number', 'trim|required');
		}
		//$this->form_validation->set_rules('agrement_expiry', 'Agreement Expiry Date', 'trim|required');
		//$this->form_validation->set_rules('vendor_email', 'Email ID', 'trim|required');
		//$this->form_validation->set_rules('telephone', 'Telephone', 'trim|required');
		//$this->form_validation->set_rules('sales_name', 'Sales Person Name', 'trim|required');
		//$this->form_validation->set_rules('sales_mobile', 'Sales Mobile No', 'trim|required');
		//$this->form_validation->set_rules('sales_email', 'Sales Email ID', 'trim|required');
		//$this->form_validation->set_rules('credit_limit', 'Credit Limit', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Vendor_model->edit();
			} else {
				$query = $this->Vendor_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/vendor');
	}

	public function get_list()
	{
		$fetch_data = $this->Vendor_model->get_list();
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $user) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="' . $user->id . '" />';
			$sub_array[] = $i++;
			$sub_array[] = $user->vendor_name . '<br/>' . $user->vendor_arabic_name;
			$sub_array[] = $user->contact_person_name;
			$sub_array[] = $user->vendor_email;
			$sub_array[] = $user->telephone;
			$sub_array[] = $user->iban_number;
			$sub_array[] = $user->total_orders;
			$sub_array[] = round($user->total_order_value, 2) . ' SAR';
			$sub_array[] = $user->agrement_expiry;
			$sub_array[] = $user->credit_limit;
			$sub_array[] = $user->avl_credit_limit;
			$sub_array[] = $user->status == 1 ? '<div class="label label-success">Enabled</div>' : '<div class="label label-danger">Disabled</div>';
			$sub_array[] = $user->short_address;
			$sub_array[] = date('d-m-Y H:i A', strtotime($user->created_at));
			$sub_array[] = check_action_permission(get_user_role(), 'manage_suppliers', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="' . base_url() . 'admin/vendor/add?id=' . $user->id . '"><span class="mdi mdi-pencil font-size-18"></span></a>' : '';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Vendor_model->get_all_data(),
			"recordsFiltered"     =>     $this->Vendor_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function detail()
	{
		$id = $this->input->get('id');
		$data['result'] = $this->Vendor_model->get_vendor_by_id($id);
		$data['docs'] = $this->Vendor_model->vendor_documents($id);
		$this->load->view('admin/vendor/detail', $data);
	}

	public function get_order_list()
	{
		$id = $this->input->get('id');
		$fetch_data = $this->Purchase_model->get_order_list($id);
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $order) {
			$sub_array = array();
			$sub_array[] = $order->purchaser_name;
			$sub_array[] = $order->p_address_line1 . ',' . $order->p_address_line2;
			$sub_array[] = $order->p_phone;
			$sub_array[] = $order->s_recipient_name;
			$sub_array[] = $order->s_address_line1 . ',' . $order->s_address_line2;
			$sub_array[] = $order->s_phone;
			$sub_array[] = $order->po_number;
			$sub_array[] = $order->po_address_line1 . ',' . $order->po_address_line2;
			$sub_array[] = $order->po_phone;
			$sub_array[] = $order->po_date;
			$sub_array[] = $order->requisitioner;
			$sub_array[] = $order->shipped_via;
			$sub_array[] = $order->fob_point;
			$sub_array[] = $order->terms;
			$sub_array[] = $order->sub_total;
			$sub_array[] = $order->sale_tax;
			$sub_array[] = $order->shipping_handling;
			$sub_array[] = $order->total;
			$sub_array[] = $order->status == 1 ? '<div class="label label-success">Active</div>' : '<div class="label label-danger">Deactive</div>';
			$sub_array[] = date("d M,Y h:i A", strtotime($order->created_at));
			$sub_array[] = date("d M,Y h:i A", strtotime($order->updated_at));
			$sub_array[] = '<a class="btn btn-warning" title="Edit" href="' . base_url() . 'admin/purchase_order/form?id=' . $order->id . '"><i class="fa fa-edit"></i></a>&nbsp;<a class="btn btn-primary" title="Print" href="' . base_url() . 'admin/purchase_order/print_invoice?id=' . $order->id . '"><i class="fa fa-print"></i></a>';
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Purchase_model->get_all_order_data($id),
			"recordsFiltered"     =>     $this->Purchase_model->get_filtered_order_data($id),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function setStatusEnable()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_suppliers', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			$query = $this->Vendor_model->setStatusEnable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/vendor');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_suppliers', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Vendor_model->setStatusDisable($ids);
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/vendor');
		} else {
			redirect('admin');
		}
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_suppliers', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Vendor_model->delete($ids);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/vendor');
	}
}
