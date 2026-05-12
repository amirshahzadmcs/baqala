<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->deliveryboy->isLogged()){
			$this->load->model('deliveryboy/Profile_model');
			$this->load->library('form_validation');
			$this->load->helper('cookie');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->library('session');
			$this->load->helper('Common_helper');
		} else{
			redirect("delivery-partner/login");
		}
	}

	public function index(){
		$data['result'] = $this->Profile_model->profile();
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$query = $this->Profile_model->get_detail($this->input->get('id'));
		$docs = $this->Profile_model->documents($this->input->get('id'));
		$salary = $this->Profile_model->emp_salary($this->input->get('id'));
		$data['id'] = $query->id;
		$data['driver_id'] = $query->driver_id;
		$data['application_status'] = $query->application_status;
		$data['region_id'] = $query->region_id;
		$data['city'] = $query->city;
		$data['city_name'] = $query->city_name;
		$data['district'] = $query->district;
		$data['partner_id'] = $query->partner_id;
		$data['name'] = $query->name;
		$data['arabic_name'] = $query->arabic_name;
		$data['email'] = $query->email;
		$data['mobile'] = $query->mobile;
		$data['imei_no'] = $query->imei_no;
		$data['iqama_no'] = $query->iqama_no;
		$data['iqama_exp'] = $query->iqama_exp;
		$data['address'] = $query->address;
		$data['state'] = $query->state;
		$data['country'] = $query->country;
		$data['delivery_charge'] = $query->delivery_charge;
		$data['iban'] = $query->iban;
		$data['bank_name'] = $query->bank_name;
		$data['stc_pay_no'] = $query->stc_pay_no;
		$data['dl_no'] = $query->dl_no;
		$data['dl_expiry'] = $query->dl_expiry;
		
		$data['service_type'] = $query->service_type;
		$data['van_no'] = $query->van_no;
		$data['van_color'] = $query->van_color;
		$data['van_model'] = $query->van_model;
		$data['van_make'] = $query->van_make;
		$data['make_name'] = $query->make_name;
		$data['vehicle_expiry'] = $query->vehicle_expiry;
		$data['vehicle_year'] = $query->vehicle_year;
		$data['purchse_date'] = $query->purchse_date;
		$data['chassis_no'] = $query->chassis_no;
		$data['insurance_no'] = $query->insurance_no;
		$data['insurance_expiry'] = $query->insurance_expiry;
		$data['sequel_no'] = $query->sequel_no;
		$data['service_area'] = $query->service_area;
		$data['sponsor_name'] = $query->sponsor_name;
		$data['profession'] = $query->profession;
		$data['status'] = $query->status;
		$data['created_at'] = $query->created_at;
		$data['block_reason'] = $query->block_reason;
		$data['doc_reason'] = $query->doc_reason;

		$data['nationality'] = $query->nationality;
		$data['passport'] = $query->passport;
		$data['passport_expiry'] = $query->passport_expiry;
		$data['passport_issued_city'] = $query->passport_issued_city;
		$data['passport_issued_city_ar'] = $query->passport_issued_city_ar;
		$data['dob'] = $query->dob;
		$data['doj'] = $query->doj;
		$data['marital_status'] = $query->marital_status;
		$data['profile_info_status'] = $query->profile_info_status;
		$data['vehicle_info_status'] = $query->vehicle_info_status;
		$data['bank_info_status'] = $query->bank_info_status;
		$data['doc_info_status'] = $query->doc_info_status;
		$data['documents'] = $docs;
		$data['salary'] = $salary;
		$this->load->view("delivery/layout/profile", $data);
	}

	public function application_form(){
		$data['result'] = $this->Profile_model->profile();
		$data['documents'] = $this->Profile_model->documents();
		//print_r($data['result']);exit();
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$this->load->view("delivery/layout/application-form", $data);
	}

	public function save_basic_info(){
		$this->form_validation->set_rules('region_id', 'Region', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('district', 'District', 'trim|required');
		$this->form_validation->set_rules('arabic_name', 'Arabic Name', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		$this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('passport', 'Passport', 'trim|required');
		$this->form_validation->set_rules('passport_expiry', 'Passport Expiry', 'trim|required');
		$this->form_validation->set_rules('iqama_exp', 'Iqama Expiry', 'trim|required');
		$this->form_validation->set_rules('dl_no', 'Driving Licence Number', 'trim|required');
		$this->form_validation->set_rules('dl_expiry', 'Driving Licence Expiry', 'trim|required');
		$this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'trim|required');
		$this->form_validation->set_rules('profession', 'Profession', 'trim|required');

		$this->form_validation->set_rules('iqama_no', 'Iqama Number', 'trim|required|callback_check_iqama_duplicate');
		$this->form_validation->set_message('check_iqama_duplicate','Iqama Number already used, Try new');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|callback_check_mobile_duplicate');
		$this->form_validation->set_message('check_mobile_duplicate','Mobile number already registered, Try new');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
		}
		else{
			if($this->deliveryboy->isLogged()){
				$query = $this->Profile_model->update_basic();
			}
			else{
				redirect("delivery-partner/login");
			}
			if($query){
				$this->session->set_userdata('status_info', "1--Basic detail successfully updated");
			}
			else{
				$this->session->set_userdata('status_info', "2--Error!!!");
			}
		}
		redirect('delivery-partner/application-form');
	}
	
	public function check_iqama_duplicate() {
		$id = $this->input->post('id');
		$iqama_no = $this->input->post('iqama_no');
		//print_r($iqama_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Profile_model->check_duplicate_iqama($id, $iqama_no);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function check_email_duplicate() {
		$id = $this->input->post('id');
		$email = $this->input->post('email');
		$duplicate_check = $this->Profile_model->check_duplicate_email($id, $email);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}
	
	public function check_mobile_duplicate() {
		$id = $this->input->post('id');
		$mobile = $this->input->post('mobile');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Profile_model->check_duplicate_mobile($id, $mobile);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function ajax_check_iqama() {
		$iqama_no = $this->input->get('iqama_no');
		$id = $this->input->get('id');
		if($iqama_no !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Profile_model->check_duplicate_iqama($id, $iqama_no);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $iqama_no . "</b> This Iqama number already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Iqama number Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Iqama number is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_email() {
		$email = $this->input->get('email');
		$id = $this->input->get('id');
		if($email !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Profile_model->check_duplicate_email($id, $email);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $email . "</b> This Email ID already used. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Email ID Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Email ID is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_mobile() {
		$mobile = $this->input->get('mobile');
		$id = $this->input->get('id');
		if($mobile !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Profile_model->check_duplicate_mobile($id, $mobile);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $mobile . "</b> This Mobile Number already used. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Mobile Number Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Mobile Number is required.</span>";
		}
		echo json_encode($data);
	}

	public function save_vehicle_info(){
		$this->form_validation->set_rules('service_type', 'Service Type', 'trim|required');
		$this->form_validation->set_rules('van_no', 'Vehicle Plate Numbe', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate','Vehicle already alloted, Try new');
		$this->form_validation->set_rules('vehicle_expiry', 'Vehicle Expiry Date', 'trim|required');
		$this->form_validation->set_rules('vehicle_year', 'Vehicle Year', 'trim|required');
		$this->form_validation->set_rules('van_color', 'Vehicle Color', 'trim|required');
		$this->form_validation->set_rules('van_make', 'Vehicle Make', 'trim|required');
		$this->form_validation->set_rules('van_model', 'Vehicle Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
		}
		else{
			if($this->deliveryboy->isLogged()){
				$query = $this->Profile_model->update_vehicle();
			}
			else{
				redirect("delivery-partner/login");
			}
			if($query){
				$this->session->set_userdata('status_info', "1--Vehicle detail successfully updated");
			}
			else{
				$this->session->set_userdata('status_info', "2--Error!!!");
			}
		}
		redirect('delivery-partner/application-form');
	}

	public function check_duplicate() {
		$van_no = $this->input->post('van_no');
		$rider_id = $this->input->post('id');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Profile_model->check_duplicate($van_no, $rider_id);
		//print_r($sku_check);exit();
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function save_bank_info(){
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
		if($this->input->post('bank_name') == '3'){
			$this->form_validation->set_rules('stc_pay_no', 'STC Pay No', 'trim|required');
		}else{
			$this->form_validation->set_rules('iban', 'IBAN No', 'trim|required');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('status_info', "2--".validation_errors());
		}
		else{
			if($this->deliveryboy->isLogged()){
				$query = $this->Profile_model->update_bank_detail();
			}
			else{
				redirect("delivery-partner/login");
			}
			if($query){
				$this->session->set_userdata('status_info', "1--Bank detail successfully updated");
			}
			else{
				$this->session->set_userdata('status_info', "2--Error!!!");
			}
		}
		redirect('delivery-partner/application-form');
	}

	public function upload_profile_pic(){
		$query = $this->Profile_model->upload_profile_image();
		//'<pre>';print_r($query);'</pre>';exit();
		//echo $this->input->post();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_iqama_front(){
		$query = $this->Profile_model->upload_iqama_front();
		//'<pre>';print_r($query);'</pre>';exit();
		//echo $this->input->post();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_iqama_back(){
		$query = $this->Profile_model->upload_iqama_back();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_licence_front(){
		$query = $this->Profile_model->upload_licence_front();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_licence_back(){
		$query = $this->Profile_model->upload_licence_back();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_iban(){
		$query = $this->Profile_model->upload_iban_pic();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_reg_front(){
		$query = $this->Profile_model->upload_car_reg_front();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_reg_back(){
		$query = $this->Profile_model->upload_car_reg_back();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_insurance(){
		$query = $this->Profile_model->upload_car_insurance();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_front(){
		$query = $this->Profile_model->upload_car_front();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_back(){
		$query = $this->Profile_model->upload_car_back();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_left(){
		$query = $this->Profile_model->upload_car_left();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function upload_car_right(){
		$query = $this->Profile_model->upload_car_right();
		if($query){
			echo 'ok';exit();
		}else{
			echo 'err';exit();
		}
	}

	public function change_password(){
		$data['result'] = $this->Profile_model->profile();
		$this->load->view('delivery/auth/change_password', $data);
	}
	
	public function submit_change_password(){
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('status_info',validation_errors());
			$this->session->set_flashdata('is_success','0');
		}
		else{
			$hashpassword = $this->enc_lib->encrypt($this->input->post('old_password'));
			$hashpassword_new = $this->enc_lib->encrypt($this->input->post('new_password'));
			if($this->deliveryboy->checkPassword($hashpassword)){
				$query = $this->Profile_model->change_password_by_id($hashpassword_new);
				if($query){
					$this->session->set_flashdata('status_info',"Password has been updated.");
					$this->session->set_flashdata('is_success','1');
					redirect("logout");
				}
				else{
					$this->session->set_flashdata('status_info',"Some Error occures!!!");
					$this->session->set_flashdata('is_success','0');
				}
			}
			else{
				$this->session->set_flashdata('status_info',"Your old password is not correct.");
				$this->session->set_flashdata('is_success','0');
			}
		}
		redirect("delivery-partner/change-password");
	}

	function get_region_cities() {
		$id = $this->input->post('region_id');
		$query = $this->db->query("SELECT * FROM master_city where region_id=" . $id)->result();
		echo json_encode($query);
	}

	function vehicle_make_list()
	{
		$service_id = $this->input->post('service_id');
		$query = $this->db->query("SELECT * FROM mater_van_make WHERE service_type = '". $service_id ."' AND deleted = '0' AND status = '1'")->result();
		echo json_encode($query);
	}

	function get_vehicle_type() {
		$make_id = $this->input->post('make_id');
		$query = $this->db->query("SELECT * FROM master_vehicle_type WHERE make_id = '". $make_id ."' AND status = '1'")->result();
		echo json_encode($query);
	}
}
