<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Rider_model extends CI_Model
{

    public function add_basic($hashpassword)
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
        $query = $this->db->query("INSERT INTO delivery_vehicles SET 
			region_id = '" . $this->input->post('region_id') . "',
			city = '" . $this->db->escape_str($this->input->post('city')) . "',
			district = '" . $this->db->escape_str($this->input->post('district')) . "',
			arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', 
			name = '" . $this->db->escape_str($this->input->post('name')) . "', 
			email = '" . $this->db->escape_str($this->input->post('email')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			imei_no = '" . $this->db->escape_str($this->input->post('imei_no')) . "', 
			dob = '" . $this->db->escape_str($this->input->post('dob')) . "', 
			marital_status = '" . $this->db->escape_str($this->input->post('marital_status')) . "',
			nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
			passport = '" . $this->db->escape_str($this->input->post('passport')) . "', 
			passport_expiry = '" . $this->db->escape_str($this->input->post('passport_expiry')) . "', 
			passport_issued_city = '" . $this->db->escape_str($this->input->post('passport_issued_city')) . "', 
			passport_issued_city_ar = '" . $this->db->escape_str($this->input->post('passport_issued_city_ar')) . "', 
			iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', 
			iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "',
			dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "',
			dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "',
			sponsor_name = '" . $this->db->escape_str($this->input->post('sponsor_name')) . "', 
			profession = '" . $this->db->escape_str($this->input->post('profession')) . "', 
            doj = '" . $this->db->escape_str($this->input->post('doj')) . "', 
            partner_id = '" . (int)$this->logistic->getId() . "', 
            service_area = '" . $this->db->escape_str($this->input->post('service_area')) . "', 
            status = '0', 
			rider_type = '1', 
            block_reason = '" . $this->db->escape_str($this->input->post('block_reason')) . "',
            password = '" . $hashpassword . "',
			created_at = '" . $created_at ."', 
			updated_at = '" . $created_at ."', 
			ip = '" . $this->input->ip_address() . "'");
            $insert_id = $this->db->insert_id();
            if($query){
				$cust_account_no = $insert_id + 100;
				$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
                $this->db->query("UPDATE delivery_vehicles SET driver_id = '" . $final_account_no . "', profile_info_status = '1' WHERE id = '" . (int)$insert_id . "'");
                $this->db->query("INSERT INTO delivery_boy_documents SET deliveryboy_id = '" . (int)$insert_id . "', created_at = '" . $created_at . "', status = '0'");
                $this->db->query("INSERT INTO deliveryvehicle_salary SET deliveryboy_id = '" . (int)$insert_id . "', created_at = '" . $created_at . "'");
            }
            $this->db->trans_complete();
        return $query;
    }

    public function update_basic()
    {
        $created_at = CURRENT_TIME;
        $this->db->trans_start();
		$cust_account_no = (int)$this->input->post('id') + 100;
		$final_account_no = str_pad($cust_account_no, 6, 0, STR_PAD_LEFT);
        $query = $this->db->query("UPDATE delivery_vehicles SET 
			driver_id = '" . $final_account_no . "',
			region_id = '" . $this->input->post('region_id') . "',
			city = '" . $this->db->escape_str($this->input->post('city')) . "',
			district = '" . $this->db->escape_str($this->input->post('district')) . "',
			arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', 
			name = '" . $this->db->escape_str($this->input->post('name')) . "', 
			mobile = '" . $this->db->escape_str($this->input->post('mobile')) . "', 
			imei_no = '" . $this->db->escape_str($this->input->post('imei_no')) . "', 
			dob = '" . $this->db->escape_str($this->input->post('dob')) . "', 
			marital_status = '" . $this->db->escape_str($this->input->post('marital_status')) . "',
			nationality = '" . $this->db->escape_str($this->input->post('nationality')) . "', 
			passport = '" . $this->db->escape_str($this->input->post('passport')) . "', 
			passport_expiry = '" . $this->db->escape_str($this->input->post('passport_expiry')) . "', 
			passport_issued_city = '" . $this->db->escape_str($this->input->post('passport_issued_city')) . "', 
			passport_issued_city_ar = '" . $this->db->escape_str($this->input->post('passport_issued_city_ar')) . "', 
			iqama_no = '" . $this->db->escape_str($this->input->post('iqama_no')) . "', 
			iqama_exp = '" . $this->db->escape_str($this->input->post('iqama_exp')) . "',
			dl_no = '" . $this->db->escape_str($this->input->post('dl_no')) . "',
			dl_expiry = '" . $this->db->escape_str($this->input->post('dl_expiry')) . "',
			sponsor_name = '" . $this->db->escape_str($this->input->post('sponsor_name')) . "', 
			profession = '" . $this->db->escape_str($this->input->post('profession')) . "',
            doj = '" . $this->db->escape_str($this->input->post('doj')) . "',
            service_area = '" . $this->db->escape_str($this->input->post('service_area')) . "',
            block_reason = '" . $this->db->escape_str($this->input->post('block_reason')) . "',
			updated_at = '" . $created_at ."', 
			rider_type = '1', 
			ip = '" . $this->input->ip_address() . "'  
			WHERE id = '" . (int)$this->input->post('id') . "'");
            $this->db->trans_complete();
        return $query;
    }

	function check_duplicate_iqama($id, $iqama_no){
		$this->db->select("*");  
		$this->db->from('delivery_vehicles'); 
		$this->db->where('id !=',$id);
		$this->db->where('iqama_no =',$iqama_no);
		return $this->db->count_all_results();  
	}
	
	function check_duplicate_mobile($id, $mobile){
		$this->db->select("*");  
		$this->db->from('delivery_vehicles'); 
		$this->db->where('id !=',$id);
		$this->db->where('mobile =',$mobile);
		return $this->db->count_all_results();  
	}
	
	function check_duplicate_email($id, $email){
		$this->db->select("*");  
		$this->db->from('delivery_vehicles'); 
		$this->db->where('id !=',$id);
		$this->db->where('email =',$email);
		return $this->db->count_all_results();  
	}

    public function update_vehicle()
    {
        $created_at = CURRENT_TIME;
        $checkPartner = $this->isValidLogistic($this->input->post('id'));
        if($checkPartner){
            $this->db->trans_start();
            $query = $this->db->query("UPDATE delivery_vehicles SET 
                service_type = '" . $this->db->escape_str($this->input->post('service_type')) . "', 
                van_no = '" . $this->db->escape_str($this->input->post('van_no')) . "', 
                vehicle_expiry = '" . $this->db->escape_str($this->input->post('vehicle_expiry')) . "',
                vehicle_year = '" . $this->db->escape_str($this->input->post('vehicle_year')) . "',  
                van_color = '" . $this->db->escape_str($this->input->post('van_color')) . "',  
                van_make = '" . $this->db->escape_str($this->input->post('van_make')) . "', 
                van_model = '" . $this->db->escape_str($this->input->post('van_model')) . "', 
				purchse_date = '" . $this->db->escape_str($this->input->post('purchse_date')) . "', 
				chassis_no = '" . $this->db->escape_str($this->input->post('chassis_no')) . "', 
				insurance_no = '" . $this->db->escape_str($this->input->post('insurance_no')) . "', 
				insurance_expiry = '" . $this->db->escape_str($this->input->post('insurance_expiry')) . "', 
				sequel_no = '" . $this->db->escape_str($this->input->post('sequel_no')) . "', 
                updated_at = '" . $created_at ."', 
                ip = '" . $this->input->ip_address() . "' 
                WHERE id = '" . (int)$this->input->post('id') . "'");
            if($query){
                $this->db->query("UPDATE delivery_vehicles SET vehicle_info_status = '1' WHERE id = '" . (int)$this->input->post('id') . "'");
            }
            $this->db->trans_complete();
        }else{
            $query = false;
        }
        return $query;
    }

	function check_duplicate($van_no, $rider_id){
		$this->db->select("*");  
		$this->db->from('delivery_vehicles'); 
		$this->db->where('id !=',$rider_id);
		$this->db->where('van_no =',$van_no);
		return $this->db->count_all_results();  
	}

	public function update_bank_detail()
    {
        $created_at = CURRENT_TIME;
        $checkPartner = $this->isValidLogistic($this->input->post('id'));
        if($checkPartner){
            $this->db->trans_start();
            $query = $this->db->query("UPDATE delivery_vehicles SET 
                bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "',
                iban = '" . $this->db->escape_str($this->input->post('iban')) . "', 
                stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "', 
                updated_at = '" . $created_at ."', 
                ip = '" . $this->input->ip_address() . "' 
                WHERE id = '" . (int)$this->input->post('id') . "'"); 
            if($query){
                $this->db->query("UPDATE delivery_vehicles SET bank_info_status = '1' WHERE id = '" . (int)$this->input->post('id') . "'");
            }
            $this->db->trans_complete();
        }else{
            $query = false;
        }
        return $query;
    }
    
    public function update_salary_detail()
    {
        $created_at = CURRENT_TIME;
        $checkPartner = $this->isValidLogistic($this->input->post('id'));
        if($checkPartner){
            $this->db->trans_start();
            $query = $this->db->query("UPDATE deliveryvehicle_salary SET 
                daily_orders = '" . $this->db->escape_str($this->input->post('daily_orders')) . "', 
                monthly_orders = '" . $this->db->escape_str($this->input->post('monthly_orders')) . "', 
                rejection_rate = '" . $this->db->escape_str($this->input->post('rejection_rate')) . "', 
                housing = '" . $this->db->escape_str($this->input->post('housing')) . "', 
                housing_ar = '" . $this->db->escape_str($this->input->post('housing_ar')) . "', 
                internet = '" . $this->db->escape_str($this->input->post('internet')) . "', 
                internet_ar = '" . $this->db->escape_str($this->input->post('internet_ar')) . "', 
                bike_allowance = '" . $this->db->escape_str($this->input->post('bike_allowance')) . "', 
                bike_allowance_ar = '" . $this->db->escape_str($this->input->post('bike_allowance_ar')) . "', 
                transport_allowance = '" . $this->db->escape_str($this->input->post('transport_allowance')) . "', 
                transport_allowance_ar = '" . $this->db->escape_str($this->input->post('transport_allowance_ar')) . "', 
                bike_maintain = '" . $this->db->escape_str($this->input->post('bike_maintain')) . "', 
                bike_maintain_ar = '" . $this->db->escape_str($this->input->post('bike_maintain_ar')) . "', 
                petrol = '" . $this->db->escape_str($this->input->post('petrol')) . "', 
                petrol_ar = '" . $this->db->escape_str($this->input->post('petrol_ar')) . "', 
                medical_insurance = '" . $this->db->escape_str($this->input->post('medical_insurance')) . "', 
                medical_insurance_ar = '" . $this->db->escape_str($this->input->post('medical_insurance_ar')) . "', 
                food = '" . $this->db->escape_str($this->input->post('food')) . "', 
                total_salary = '" . $this->db->escape_str($this->input->post('total_salary')) . "', 
                basic = '" . $this->db->escape_str($this->input->post('basic')) . "', 
                daily_commision = '" . $this->db->escape_str($this->input->post('daily_commision')) . "',
                annual_vacation = '" . $this->db->escape_str($this->input->post('annual_vacation')) . "',
                annual_vacation_ar = '" . $this->db->escape_str($this->input->post('annual_vacation_ar')) . "',
                contract_period = '" . $this->db->escape_str($this->input->post('contract_period')) . "',
                contract_period_ar = '" . $this->db->escape_str($this->input->post('contract_period_ar')) . "',
                deduction = '" . $this->db->escape_str($this->input->post('deduction')) . "',
                deduction_ar = '" . $this->db->escape_str($this->input->post('deduction_ar')) . "',
                rider_payout_structure = '" . $this->db->escape_str($this->input->post('rider_payout_structure')) . "',
                updated_at = '" . $created_at ."', 
                ip = '" . $this->input->ip_address() . "' 
                WHERE deliveryboy_id = '" . (int)$this->input->post('id') . "'");
            $this->db->trans_complete();
        }else{
            $query = false;
        }
        return $query;
    }

    public function isValidLogistic($id){
        $query = $this->db->query("SELECT id FROM delivery_vehicles WHERE partner_id = '". (int)$this->logistic->getId() ."' AND id = '" . (int)$id . "' LIMIT 1");
        if($query->num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    #Upload Files Start

    function upload_profile_image(){
		$this->load->helper('string');
        $checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		//print_r($this->input->post());exit();
		
		$path = './uploads/delivery-vehicle/profile/';
		if (!is_dir('uploads/delivery-vehicle/profile/')) {
			mkdir($path, 0777, TRUE);
		}
		//$con['image_library'] = 'gd2';
		//$con['source_image'] = $path;
		//$con['create_thumb'] = TRUE;
		//$con['maintain_ratio'] = TRUE;
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx'; 
		//$con['quality'] = '60%';  
		//$con['width'] = 200;  
		//$con['height'] = 200;
		//$con['rotation_angle'] = 270;
		//$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		//$this->upload->initialize($con);
		//$this->image_lib->resize();
		if($_FILES['profile_picture']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('profile_picture');
			$image_data1 = $this->upload->data();
			$applicant_pic = "uploads/delivery-vehicle/profile/".$image_data1['file_name'];
		}
		else{
			$applicant_pic = $this->input->post('o_profile_picture');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET profile_picture='" . $applicant_pic . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
		/* @TODO Mail and SmS */
	}

	function upload_iqama_front(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/iqama/';
		if (!is_dir('uploads/delivery-vehicle/iqama/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['iqama_image_front']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('iqama_image_front');
			$image_data1 = $this->upload->data();
			$iqama_image_front = "uploads/delivery-vehicle/iqama/".$image_data1['file_name'];
		}
		else{
			$iqama_image_front = $this->input->post('o_iqama_image_front');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET iqama_image_front='" . $iqama_image_front . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_iqama_back(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/iqama/';
		if (!is_dir('uploads/delivery-vehicle/iqama/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['iqama_image_back']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('iqama_image_back');
			$image_data1 = $this->upload->data();
			$iqama_image_back = "uploads/delivery-vehicle/iqama/".$image_data1['file_name'];
		}
		else{
			$iqama_image_back = $this->input->post('o_iqama_image_back');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET iqama_image_back='" . $iqama_image_back . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_licence_front(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/licence/';
		if (!is_dir('uploads/delivery-vehicle/licence/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['driving_licence_front']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('driving_licence_front');
			$image_data1 = $this->upload->data();
			$driving_licence_front = "uploads/delivery-vehicle/licence/".$image_data1['file_name'];
		}
		else{
			$driving_licence_front = $this->input->post('o_driving_licence_front');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET driving_licence_front='" . $driving_licence_front . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_licence_back(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/licence/';
		if (!is_dir('uploads/delivery-vehicle/licence/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['driving_licence_back']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('driving_licence_back');
			$image_data1 = $this->upload->data();
			$driving_licence_back = "uploads/delivery-vehicle/licence/".$image_data1['file_name'];
		}
		else{
			$driving_licence_back = $this->input->post('o_driving_licence_back');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET driving_licence_back='" . $driving_licence_back . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_iban_pic(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/iban/';
		if (!is_dir('uploads/delivery-vehicle/iban/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['iban_certificate']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('iban_certificate');
			$image_data1 = $this->upload->data();
			$iban_certificate = "uploads/delivery-vehicle/iban/".$image_data1['file_name'];
		}
		else{
			$iban_certificate = $this->input->post('o_iban_certificate');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET iban_certificate='" . $iban_certificate . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_reg_front(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/car_reg/';
		if (!is_dir('uploads/delivery-vehicle/car_reg/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_registration_front']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_registration_front');
			$image_data1 = $this->upload->data();
			$car_registration_front = "uploads/delivery-vehicle/car_reg/".$image_data1['file_name'];
		}
		else{
			$car_registration_front = $this->input->post('o_car_registration_front');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_registration_front='" . $car_registration_front . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_reg_back(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/car_reg/';
		if (!is_dir('uploads/delivery-vehicle/car_reg/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_registration_back']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_registration_back');
			$image_data1 = $this->upload->data();
			$car_registration_back = "uploads/delivery-vehicle/car_reg/".$image_data1['file_name'];
		}
		else{
			$car_registration_back = $this->input->post('o_car_registration_back');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_registration_back='" . $car_registration_back . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_insurance(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/insurance/';
		if (!is_dir('uploads/delivery-vehicle/insurance/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_insurance_picture']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_insurance_picture');
			$image_data1 = $this->upload->data();
			$car_insurance_picture = "uploads/delivery-vehicle/insurance/".$image_data1['file_name'];
		}
		else{
			$car_insurance_picture = $this->input->post('o_car_insurance_picture');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_insurance_picture ='" . $car_insurance_picture . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_front(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/car/';
		if (!is_dir('uploads/delivery-vehicle/car/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_front_side']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_front_side');
			$image_data1 = $this->upload->data();
			$car_front_side = "uploads/delivery-vehicle/car/".$image_data1['file_name'];
		}
		else{
			$car_front_side = $this->input->post('o_car_front_side');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_front_side ='" . $car_front_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_back(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/car/';
		if (!is_dir('uploads/delivery-vehicle/car/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_back_side']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_back_side');
			$image_data1 = $this->upload->data();
			$car_back_side = "uploads/delivery-vehicle/car/".$image_data1['file_name'];
		}
		else{
			$car_back_side = $this->input->post('o_car_back_side');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_back_side ='" . $car_back_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_left(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/car/';
		if (!is_dir('uploads/delivery-vehicle/car/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_left_side']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_left_side');
			$image_data1 = $this->upload->data();
			$car_left_side = "uploads/delivery-vehicle/car/".$image_data1['file_name'];
		}
		else{
			$car_left_side = $this->input->post('o_car_left_side');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_left_side ='" . $car_left_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

	function upload_car_right(){
		$this->load->helper('string');
		$checkPartner = $this->isValidLogistic($this->input->post('id'));
        if(!$checkPartner){
            return false;
        }
		$path = './uploads/delivery-vehicle/car/';
		if (!is_dir('uploads/delivery-vehicle/car/')) {
			mkdir($path, 0777, TRUE);
		}
		$con['upload_path']   = $path; 
		$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx';
		$con['max_filename'] = '99';
		$con['encrypt_name'] = TRUE;
        
		if($_FILES['car_right_side']['name']){
			$this->load->library('upload', $con);
			$this->upload->do_upload('car_right_side');
			$image_data1 = $this->upload->data();
			$car_right_side = "uploads/delivery-vehicle/car/".$image_data1['file_name'];
		}
		else{
			$car_right_side = $this->input->post('o_car_right_side');
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_right_side ='" . $car_right_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->input->post('id') ."'");
		
		return $query;
	}

    #Upload Files End

    public function get_detail($id)
    {
        $query = $this->db->query("SELECT db.*, mb.bank_name as bankname, mc.color_name, mp.profession_name, mvk.make_name, sa.area_name, dp.company_name as logistic_partner FROM delivery_vehicles db LEFT JOIN master_bank mb ON (mb.id = db.bank_name) LEFT JOIN master_color mc ON (mc.id = db.van_color) LEFT JOIN master_profession mp ON (mp.id = db.profession) LEFT JOIN mater_van_make mvk ON (mvk.id = db.van_make) LEFT JOIN service_area sa ON (sa.id = db.service_area) LEFT JOIN delivery_partner dp ON (db.partner_id = dp.id) WHERE db.id = '" . (int) $id . "' AND partner_id = '" . (int)$this->logistic->getId() . "'");
        return $query;
    }

	public function documents($id){
		$query = $this->db->query("SELECT * FROM delivery_boy_documents WHERE deliveryboy_id = '" . (int) $id . "'")->row();
		return $query;
	}

	public function emp_salary($id){
		$query = $this->db->query("SELECT * FROM deliveryvehicle_salary WHERE deliveryboy_id = '" . (int) $id . "'")->row();
		return $query;
	}

    public function delete($id)
    {
        $query = $this->db->query("DELETE FROM delivery_vehicles WHERE partner_id = '" . (int)$this->logistic->getId() . "' AND id IN (" . $id . ")");
        if($query){
            $query = $this->db->query("DELETE FROM deliveryvehicle_salary WHERE deliveryboy_id IN (" . $id . ")");
            $query = $this->db->query("DELETE FROM delivery_boy_documents WHERE deliveryboy_id IN (" . $id . ")");
        }
        return $query;
    }

    public function make_query()
    {
        $a = "SELECT db.*, (SELECT IF(lp.id > 0, lp.company_name, 'N/A') FROM delivery_partner lp WHERE db.partner_id = lp.id) as partner_name FROM delivery_vehicles db WHERE db.partner_id = '". (int)$this->logistic->getId() ."'";
        return $a;
    }
    
    public function get_list()
    {
        $a = $this->make_query();
        if (isset($_POST["search"]["value"])) {
            $a .= " AND db.name LIKE '%" . $_POST["search"]["value"] . "%'";
        }
        // if (isset($_POST["search"]["value"])) {
        //     $a .= " AND lp.company_name LIKE '%" . $_POST["search"]["value"] . "%'";
        // }
        if (isset($_POST["order"])) {
            $a .= " ORDER BY db.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY db.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    public function get_filtered_data()
    {
        $a = $this->make_query();
        $query = $this->db->query($a);
        return $query->num_rows();
    }

    public function get_all_data()
    {
        $this->db->select("*");
        $this->db->from('delivery_vehicles');
        $this->db->where('partner_id', '=', (int)$this->logistic->getId());
        return $this->db->count_all_results();
    }

    public function make_list()
    {
        $query = $this->db->query("SELECT * FROM mater_van_make WHERE deleted = '0' AND status = '1'")->result();
        return $query;
    }

    public function color_list()
    {
        $query = $this->db->query("SELECT * FROM master_color WHERE deleted = '0' AND status = '1'")->result();
        return $query;
    }

    public function bank_list()
    {
        $query = $this->db->query("SELECT * FROM master_bank WHERE deleted = '0' AND status = '1'")->result();
        return $query;
    }

    public function area_list()
    {
        $query = $this->db->query("SELECT * FROM service_area WHERE deleted = '0' AND status = '1'")->result();
        return $query;
    }

    public function profession_list()
    {
        $query = $this->db->query("SELECT * FROM master_profession WHERE deleted = '0' AND status = '1'")->result();
        return $query;
    }

	public function getAllData($id)
	{
		$query = $this->db->query("SELECT dv.*, dp.company_name, dp.arabic_name as ar_name, dp.contact_p, sr.area_name as area_name, vm.make_name FROM delivery_vehicles dv, delivery_partner dp, service_area sr, mater_van_make vm WHERE dv.id = '" . (int)$id . "' AND dv.partner_id = dp.id AND sr.id = dv.service_area AND vm.id = dv.van_make");
		return $query->row();
	}
	
	public function verified_driver_list()
    {
		$a = "SELECT dv.* FROM delivery_vehicles dv WHERE dv.partner_id = '". (int)$this->logistic->getId() ."' AND dv.application_status = 'verified'";
        if (isset($_POST["search"]["value"])) {
            $a .= " AND (dv.name LIKE '%" . $_POST["search"]["value"] . "%' OR dv.mobile LIKE '%" . $_POST["search"]["value"] . "%')";
        }
        if (isset($_POST["order"])) {
            $a .= " ORDER BY dv.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY dv.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->result();
    }

    public function filter_verified_driver()
    {
        $a = "SELECT dv.* FROM delivery_vehicles dv WHERE dv.partner_id = '". (int)$this->logistic->getId() ."' AND dv.application_status = 'verified'";
        if (isset($_POST["search"]["value"])) {
            $a .= " AND (dv.name LIKE '%" . $_POST["search"]["value"] . "%' OR dv.mobile LIKE '%" . $_POST["search"]["value"] . "%')";
        }
        if (isset($_POST["order"])) {
            $a .= " ORDER BY dv.name " . $_POST['order']['0']['dir'] . "";
        } else {
            $a .= " ORDER BY dv.created_at DESC";
        }
        if ($_POST["length"] != -1) {
            $a .= " LIMIT " . $_POST['start'] . " ," . $_POST['length'] . "";
        }
        $query = $this->db->query($a);
        return $query->num_rows();
    }

    public function get_all_verified_driver()
    {
        $this->db->select("*");
        $this->db->from('delivery_vehicles');
        $this->db->where('partner_id =', (int)$this->logistic->getId());
        $this->db->where('application_status =', 'verified');
        return $this->db->count_all_results();
    }
}
