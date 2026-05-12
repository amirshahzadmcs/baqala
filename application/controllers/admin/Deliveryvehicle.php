<?php defined('BASEPATH') or exit('No direct script access allowed');

class Deliveryvehicle extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		if ($this->admin->isLogged()) {
			$this->load->model('admin/Deliveryvehicle_model');
			//$this->load->model('admin/Order_process_model');
			$this->load->model('admin/Common_model');
			$this->load->helper('Common_helper');
			$this->load->library('form_validation');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->action = $this->router->method;
		} else {
			redirect('admin');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_rider', $this->action)) {
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
		$this->load->view('admin/delivery-vehicles/list', $data);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_rider', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$query = $this->Deliveryvehicle_model->get_detail($this->input->get('id'))->row();
			$docs = $this->Deliveryvehicle_model->documents($this->input->get('id'));
			$salary = $this->Deliveryvehicle_model->emp_salary($this->input->get('id'));
			$data['id'] = $query->id;
			$data['application_status'] = $query->application_status;
			$data['region_id'] = $query->region_id;
			$data['city'] = $query->city;
			$data['district'] = $query->district;
			$data['partner_id'] = $query->partner_id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['rider_type'] = $query->rider_type;
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
			$data['color_name'] = $query->color_name;
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
		} else {
			$data['id'] = "";
			$data['application_status'] = "";
			$data['region_id'] = "";
			$data['district'] = "";
			$data['city'] = "";
			$data['partner_id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['rider_type'] = "";
			$data['email'] = "";
			$data['mobile'] = "";
			$data['imei_no'] = "";
			$data['iqama_no'] = "";
			$data['iqama_exp'] = "";
			$data['address'] = "";
			$data['state'] = "";
			$data['country'] = "";
			$data['delivery_charge'] = "";
			$data['iban'] = "";
			$data['bank_name'] = "";
			$data['stc_pay_no'] = "";
			$data['dl_no'] = "";
			$data['dl_expiry'] = "";
			$data['dl_image'] = "";
			$data['status'] = "";
			$data['block_reason'] = "";
			$data['doc_reason'] = "";

			$data['service_type'] = "";
			$data['van_no'] = '';
			$data['van_color'] = '';
			$data['van_model'] = '';
			$data['van_make'] = "";
			$data['vehicle_expiry'] = "";
			$data['vehicle_year'] = "";
			$data['purchse_date'] = "";
			$data['chassis_no'] = "";
			$data['insurance_no'] = "";
			$data['insurance_expiry'] = "";
			$data['sequel_no'] = "";
			$data['service_area'] = "";
			$data['sponsor_name'] = "";
			$data['profession'] = "";

			$data['nationality'] = "";
			$data['passport'] = "";
			$data['passport_expiry'] = "";
			$data['passport_issued_city'] = "";
			$data['passport_issued_city_ar'] = "";
			$data['dob'] = "";
			$data['doj'] = "";
			$data['marital_status'] = "";

			$data['profile_info_status'] = "";
			$data['vehicle_info_status'] = "";
			$data['bank_info_status'] = "";
			$data['doc_info_status'] = "";
			$data['documents'] = "";
			$data['salary'] = "";
		}
		//print_r($data['partners']);exit();
		$this->load->view('admin/delivery-vehicles/form', $data);
	}

	public function save_basic_info()
	{
		$this->form_validation->set_rules('region_id', 'Region', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('district', 'District', 'trim|required');
		$this->form_validation->set_rules('arabic_name', 'Arabic Name', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('rider_type', 'Rider Type', 'trim|required');
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
		$this->form_validation->set_rules('service_area', 'Service Area', 'trim|required');
		$this->form_validation->set_rules('partner_id', 'Logistic Partner', 'trim|required');
		$this->form_validation->set_rules('doj', 'Date of Joining', 'trim|required');
		$this->form_validation->set_rules('status', 'Rider Status', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'Iqama Number', 'trim|required|callback_check_iqama_duplicate');
		$this->form_validation->set_message('check_iqama_duplicate', 'Iqama Number already used, Try new');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email_duplicate');
		$this->form_validation->set_message('check_email_duplicate', 'Email id already registered, Try new');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|callback_check_mobile_duplicate');
		$this->form_validation->set_message('check_mobile_duplicate', 'Mobile number already registered, Try new');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Deliveryvehicle_model->update_basic();
				if ($query) {
					$this->session->set_userdata('info', "1--Basic detail successfully updated");
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
				}
				redirect('admin/deliveryvehicle/add?id=' . $this->input->post('id'));
			} else {
				$hashpassword = $this->enc_lib->encrypt(uniqid());
				$query = $this->Deliveryvehicle_model->add_basic($hashpassword);
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Basic detail successfully added");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/deliveryvehicle');
	}

	public function check_iqama_duplicate()
	{
		$id = $this->input->post('id');
		$iqama_no = $this->input->post('iqama_no');
		//print_r($iqama_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Deliveryvehicle_model->check_duplicate_iqama($id, $iqama_no);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function check_email_duplicate()
	{
		$id = $this->input->post('id');
		$email = $this->input->post('email');
		$duplicate_check = $this->Deliveryvehicle_model->check_duplicate_email($id, $email);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function check_mobile_duplicate()
	{
		$id = $this->input->post('id');
		$mobile = $this->input->post('mobile');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Deliveryvehicle_model->check_duplicate_mobile($id, $mobile);
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function ajax_check_iqama()
	{
		$iqama_no = $this->input->get('iqama_no');
		$id = $this->input->get('id');
		if ($iqama_no !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Deliveryvehicle_model->check_duplicate_iqama($id, $iqama_no);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $iqama_no . "</b> This Iqama number already exists. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Iqama number Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Iqama number is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_email()
	{
		$email = $this->input->get('email');
		$id = $this->input->get('id');
		if ($email !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Deliveryvehicle_model->check_duplicate_email($id, $email);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $email . "</b> This Email ID already used. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Email ID Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Email ID is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_mobile()
	{
		$mobile = $this->input->get('mobile');
		$id = $this->input->get('id');
		if ($mobile !== '') {
			// do some database things you need to do e.g.
			$duplicate_check = $this->Deliveryvehicle_model->check_duplicate_mobile($id, $mobile);
			if ($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>" . $mobile . "</b> This Mobile Number already used. Try New.</span>";
			} else {
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Mobile Number Available.</span>";
			}
		} else {
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Mobile Number is required.</span>";
		}
		echo json_encode($data);
	}

	public function save_vehicle_info()
	{
		$this->form_validation->set_rules('id', 'Rider ID', 'trim|required');
		$this->form_validation->set_rules('service_type', 'Service Type', 'trim|required');
		$this->form_validation->set_rules('van_no', 'Vehicle Plate Numbe', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate', 'Vehicle already alloted, Try new');
		$this->form_validation->set_rules('vehicle_year', 'Vehicle Year', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Deliveryvehicle_model->update_vehicle();
			if ($query) {
				$this->session->set_userdata('info', "1--Vehicle detail successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/deliveryvehicle/add?id=' . $this->input->post('id'));
	}

	public function check_duplicate()
	{
		$van_no = $this->input->post('van_no');
		$rider_id = $this->input->post('id');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Deliveryvehicle_model->check_duplicate($van_no, $rider_id);
		//print_r($sku_check);exit();
		if ($duplicate_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function save_bank_info()
	{
		$this->form_validation->set_rules('id', 'Rider ID', 'trim|required');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
		if ($this->input->post('bank_name') == '3') {
			$this->form_validation->set_rules('stc_pay_no', 'STC Pay No', 'trim|required');
		} else {
			$this->form_validation->set_rules('iban', 'IBAN No', 'trim|required');
		}
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Deliveryvehicle_model->update_bank_detail();
			if ($query) {
				$this->session->set_userdata('info', "1--Bank detail successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/deliveryvehicle/add?id=' . $this->input->post('id'));
	}

	public function save_salary_info()
	{
		$this->form_validation->set_rules('daily_orders', 'Minimum Daily Orders', 'trim|required');
		$this->form_validation->set_rules('monthly_orders', 'Minimum Monthly Orders', 'trim|required');
		$this->form_validation->set_rules('rejection_rate', 'Rejection Rate of Orders', 'trim|required');
		$this->form_validation->set_rules('basic', 'Basic Salary', 'trim|required');
		$this->form_validation->set_rules('total_salary', 'Total Salary', 'trim|required');
		$this->form_validation->set_rules('food', 'Food', 'trim|required');
		$this->form_validation->set_rules('daily_commision', 'Bonus Commision', 'trim|required');
		$this->form_validation->set_rules('rider_payout_structure', 'Rider Payout Structure', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$query = $this->Deliveryvehicle_model->update_salary_detail();
			if ($query) {
				$this->session->set_userdata('info', "1--Salary detail successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/deliveryvehicle/add?id=' . $this->input->post('id'));
	}

	# Files Upload Start
	public function upload_profile_pic()
	{
		$query = $this->Deliveryvehicle_model->upload_profile_image();
		//'<pre>';print_r($query);'</pre>';exit();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_iqama_front()
	{
		$query = $this->Deliveryvehicle_model->upload_iqama_front();
		//'<pre>';print_r($query);'</pre>';exit();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_iqama_back()
	{
		$query = $this->Deliveryvehicle_model->upload_iqama_back();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_licence_front()
	{
		$query = $this->Deliveryvehicle_model->upload_licence_front();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_licence_back()
	{
		$query = $this->Deliveryvehicle_model->upload_licence_back();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_iban()
	{
		$query = $this->Deliveryvehicle_model->upload_iban_pic();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_reg_front()
	{
		$query = $this->Deliveryvehicle_model->upload_car_reg_front();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_reg_back()
	{
		$query = $this->Deliveryvehicle_model->upload_car_reg_back();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_insurance()
	{
		$query = $this->Deliveryvehicle_model->upload_car_insurance();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_front()
	{
		$query = $this->Deliveryvehicle_model->upload_car_front();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_back()
	{
		$query = $this->Deliveryvehicle_model->upload_car_back();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_left()
	{
		$query = $this->Deliveryvehicle_model->upload_car_left();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	public function upload_car_right()
	{
		$query = $this->Deliveryvehicle_model->upload_car_right();
		if ($query) {
			echo 'ok';
			exit();
		} else {
			echo 'err';
			exit();
		}
	}

	# Files Upload End

	public function change_password()
	{
		$this->form_validation->set_rules('id', 'Rider ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[55]', array('min_length' => 'PasswordmMin length should be 6 character'));
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$hashpassword = $this->enc_lib->encrypt($this->input->post('password'));
			$query = $this->Deliveryvehicle_model->change_password($hashpassword);
			if ($query) {
				echo '<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Password Successfully Changed.</strong></div>';
				exit();
			} else {
				echo '<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Error occured, Try again</strong></div>';
				exit();
			}
		}
	}

	public function getLoginDetail()
	{
		$login_id = $this->input->post("login_id");
		$result = $this->db->query("SELECT password from delivery_vehicles WHERE id = '" . $login_id . "'")->row();
		$hashpassword = $this->enc_lib->dycrypt($result->password);
		$data['password'] = $hashpassword;
		echo json_encode($data);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_rider', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Deliveryvehicle_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/deliveryvehicle');
	}

	public function detail()
	{
		if ($this->action && !check_action_permission(get_user_role(), '3p_rider', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		if ($id > 0) {
			$query = $this->Deliveryvehicle_model->get_detail($this->input->get('id'))->row();
			$docs = $this->Deliveryvehicle_model->documents($this->input->get('id'));
			$salary = $this->Deliveryvehicle_model->emp_salary($this->input->get('id'));
			$data['id'] = $query->id;
			$data['driver_id'] = $query->driver_id;
			$data['application_status'] = $query->application_status;
			$data['region_id'] = $query->region_id;
			$data['city'] = $query->city;
			$data['district'] = $query->district;
			$data['partner_id'] = $query->partner_id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['rider_type'] = $query->rider_type;
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
		} else {
			$this->session->set_userdata('info', "2--Invalid Rider!!!");
			redirect('admin/deliveryvehicle');
		}
		//$data['result'] = $this->Deliveryvehicle_model->get_detail($id)->row();
		//print_r($data['total_trans']);exit();
		$this->load->view('admin/delivery-vehicles/detail', $data);
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
		if (!empty($this->input->get('rider_type'))) {
			$rider_type = $this->input->get('rider_type');
		} else {
			$rider_type = FALSE;
		}
		if (!empty($this->input->get('partner_id'))) {
			$partner_id = $this->input->get('partner_id');
		} else {
			$partner_id = FALSE;
		}
		if (!empty($this->input->get('iqama_no'))) {
			$iqama_no = $this->input->get('iqama_no');
		} else {
			$iqama_no = FALSE;
		}
		if (!empty($this->input->get('plate_no'))) {
			$plate_no = $this->input->get('plate_no');
		} else {
			$plate_no = FALSE;
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
		$fetch_data = $this->Deliveryvehicle_model->get_list($keyword, $status, $application_status, $rider_type, $partner_id, $iqama_no, $plate_no, $from, $to);
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $user) {
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $user->id . '" />';
			if ($user->profile_info_status > 0 && $user->vehicle_info_status > 0 && $user->bank_info_status > 0) {
				$profile_status = '';
			} else {
				$profile_status = '<span class="badge badge-pill badge-soft-warning font-size-13">Incomplete</span>';
			}
			$sub_array[] = $user->driver_id;
			$sub_array[] = ($user->name !== '') ? $user->name . docAlertHelper($user->iqama_exp, 'Iqama') . docAlertHelper($user->dl_expiry, 'Driving Licence') . ' <br>(' . $user->arabic_name . ')' : $user->email . '<br>' . $profile_status;
			$sub_array[] = $user->mobile;
			$sub_array[] = $user->iqama_no;
			$sub_array[] = $user->van_no;
			$sub_array[] = $user->partner_name;
			$sub_array[] = 'NA';
			$sub_array[] = 'NA';
			$sub_array[] = (!empty($user->last_login_at)) ? date("d-m-y h:i A", strtotime($user->last_login_at)) : 'N/A';
			$sub_array[] = '<div style="width: 130px;">' . date("d-m-y h:i A", strtotime($user->created_at)) . '</div>';
			$sub_array[] = ($user->status == '0') ? '<span class="badge badge-pill badge-soft-secondary font-size-13">Deactive</span>' : (($user->status == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : (($user->status == '2') ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-info font-size-13">NULL</span>'));
			$sub_array[] = ($user->application_status == 'verified') ? '<span class="badge badge-pill badge-soft-success font-size-13">Verified</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Unverified</span>';
			$sub_array[] = (check_action_permission(get_user_role(), '3p_rider', 'add')) ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/deliveryvehicle/add?id=' . $user->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '' . (check_action_permission(get_user_role(), '3p_rider', 'detail') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Detail" href="' . base_url() . 'admin/deliveryvehicle/detail?id=' . $user->id . '"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '');

			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Deliveryvehicle_model->get_all_data(),
			"recordsFiltered"     =>     $this->Deliveryvehicle_model->get_filtered_data($keyword, $status, $application_status, $rider_type, $partner_id, $iqama_no, $plate_no, $from, $to),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function print_agreement()
	{
		$this->load->library('Pdf_rider_agreement');
		$id = $this->input->get('id');
		$data['order'] = $this->Deliveryvehicle_model->getAllData($id);
		$data['salary'] = $this->Deliveryvehicle_model->emp_salary($id);
		if ($data['order']->application_status == 'verified') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_rider_agreement(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Rider Agreement');
			$pdf->SetSubject('BS - Rider Agreement');
			$pdf->SetKeywords('Baqala Station, PDF, Rider Agreement, Rider');

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
			$htmlcontent = $this->load->view('admin/delivery-vehicles/print_rider_agreement', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS Rider Agreement ' . $data['order']->name . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Unverified user or something went wong!");
			redirect('admin/deliveryvehicle');
		}
	}

	public function print_job_letter()
	{
		$this->load->library('Pdf_rider_offer_letter');
		$id = $this->input->get('id');
		$data['order'] = $this->Deliveryvehicle_model->getAllData($id);
		$data['salary'] = $this->Deliveryvehicle_model->emp_salary($id);
		if ($data['order']->application_status == 'verified') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_rider_offer_letter(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Offer Letter Of ' . $data['order']->name);
			$pdf->SetSubject('BS - Offer Letter Of ' . $data['order']->name);
			$pdf->SetKeywords('Baqala Station, PDF, Rider Job Offer, Rider');

			// remove default header/footer
			$pdf->setPrintHeader(true);
			$pdf->SetPrintFooter(true);
			$htmlHeader = $this->load->view('admin/delivery-vehicles/offer-letter/print_header', $data['order'], true);
			$htmlHeader2 = $this->load->view('admin/delivery-vehicles/offer-letter/print_header2', $data['order'], true);
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
			$htmlcontent = $this->load->view('admin/delivery-vehicles/offer-letter/print_offer', $data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS Rider Agreement ' . $data['order']->name . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Unverified user or something went wong!");
			redirect('admin/deliveryvehicle');
		}
	}

	public function print_note()
	{
		$this->load->library('Pdf_promissory_note');
		$id = $this->input->get('id');
		$order = $this->Deliveryvehicle_model->getAllData($id);
		if ($order->application_status == 'verified') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_promissory_note(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Rider Promissory Note');
			$pdf->SetSubject('BS - Rider Promissory Note');
			$pdf->SetKeywords('Baqala Station, PDF, Promissory Note, Rider');

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
			$htmlcontent = $this->load->view('admin/delivery-vehicles/print_promissory_note', $order, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS Promissory Note ' . $order->name . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Unverified user or something went wong!");
			redirect('admin/deliveryvehicle');
		}
	}

	public function print_contract()
	{
		$this->load->library('Pdf_employment_contract');
		$id = $this->input->get('id');
		$order = $this->Deliveryvehicle_model->getAllData($id);
		if ($order->application_status == 'verified') {
			// print_r($order);exit();
			// create new PDF document
			$pdf = new Pdf_employment_contract(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('BS - Rider Employment Contract');
			$pdf->SetSubject('BS - Rider Employment Contract');
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
			$htmlcontent = $this->load->view('admin/delivery-vehicles/print_employment_contract', $order, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$pdf->Output('BS Employement Contract ' . $order->name . '.pdf', 'I');
		} else {
			$this->session->set_userdata('info', "2--Unverified user or something went wong!");
			redirect('admin/deliveryvehicle');
		}
	}

	function get_region_cities()
	{
		$id = $this->input->post('region_id');
		$query = $this->db->query("SELECT * FROM master_city where region_id=" . $id)->result();
		echo json_encode($query);
	}

	function vehicle_make_list()
	{
		$service_id = $this->input->post('service_id');
		$query = $this->db->query("SELECT * FROM mater_van_make WHERE service_type = '" . $service_id . "' AND deleted = '0' AND status = '1'")->result();
		echo json_encode($query);
	}

	function get_vehicle_type()
	{
		$make_id = $this->input->post('make_id');
		$query = $this->db->query("SELECT * FROM master_vehicle_type WHERE make_id = '" . $make_id . "' AND status = '1'")->result();
		echo json_encode($query);
	}

	public function verify()
	{
		$this->form_validation->set_rules('id', 'Rider ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data['err'] = validation_errors();
		} else {
			$verified_at = CURRENT_TIME;
			$query = $this->db->query("UPDATE delivery_vehicles SET application_status = 'verified', verified_at = '" . $verified_at . "', updated_at = NOW() WHERE id ='" . (int)$this->input->post('id') . "' LIMIT 1");
			if ($query) {
				$data['succ'] = 'Successfully verified.';
			} else {
				$data['err'] = 'Something went wrong, try again.';
			}
		}
		echo json_encode($data);
	}

	public function document_verify()
	{
		$this->form_validation->set_rules('id', 'Rider ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$current_date = CURRENT_TIME;
			$query = $this->db->query("UPDATE delivery_vehicles SET doc_info_status = '" . $this->input->post('doc_info_status') . "', doc_reason = '" . $this->input->post('doc_reason') . "', updated_at = '" . $current_date . "' WHERE id ='" . (int)$this->input->post('id') . "' LIMIT 1");
			if ($query) {
				$this->session->set_userdata('info', "1--Status successfully updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
			redirect('admin/deliveryvehicle/add?id=' . $this->input->post('id'));
		}
		redirect('admin/deliveryvehicle/add');
	}

	public function vehicle_detail()
	{
		$id = $this->input->get('id');
		$output = $this->Deliveryvehicle_model->get_vehicle_detail($id);
		echo json_encode($output);
	}
}
