<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model{
	
	public function profile(){
		$query = $this->db->query("SELECT * FROM delivery_vehicles WHERE id = '" . (int)$this->deliveryboy->getId() . "'")->row();
		return $query;
	}

	public function get_detail()
    {
        $query = $this->db->query("SELECT db.*, mct.city_name as city_name, mc.color_name, mp.profession_name, mvk.make_name, sa.area_name, dp.company_name as logistic_partner FROM delivery_vehicles db LEFT JOIN master_city mct ON (db.city = mct.id) LEFT JOIN master_color mc ON (mc.id = db.van_color) LEFT JOIN master_profession mp ON (mp.id = db.profession) LEFT JOIN mater_van_make mvk ON (mvk.id = db.van_make) LEFT JOIN service_area sa ON (sa.id = db.service_area) LEFT JOIN delivery_partner dp ON (db.partner_id = dp.id) WHERE db.id = '" . (int)$this->deliveryboy->getId() . "'")->row();
        return $query;
    }

	public function documents(){
		$query = $this->db->query("SELECT * FROM delivery_boy_documents WHERE deliveryboy_id = '" . (int)$this->deliveryboy->getId() . "'")->row();
		return $query;
	}
	
	public function emp_salary(){
		$query = $this->db->query("SELECT * FROM deliveryvehicle_salary WHERE deliveryboy_id = '" . (int)$this->deliveryboy->getId() . "'")->row();
		return $query;
	}

	public function update_basic()
    {
        $query = $this->db->query("UPDATE delivery_vehicles SET 
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
			updated_at = now(), 
			ip = '" . $this->input->ip_address() . "' 
			WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
		if($query){
			$this->db->query("UPDATE delivery_vehicles SET profile_info_status = '1' WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
		}
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
			WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
		if($query){
			$this->db->query("UPDATE delivery_vehicles SET vehicle_info_status = '1' WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
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
        $query = $this->db->query("UPDATE delivery_vehicles SET 
			bank_name = '" . $this->db->escape_str($this->input->post('bank_name')) . "',
			iban = '" . $this->db->escape_str($this->input->post('iban')) . "', 
			stc_pay_no = '" . $this->db->escape_str($this->input->post('stc_pay_no')) . "', 
			updated_at = now(), 
			ip = '" . $this->input->ip_address() . "' 
			WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
		if($query){
			$this->db->query("UPDATE delivery_vehicles SET bank_info_status = '1' WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
		}
        return $query;
    }

	function upload_profile_image(){
		$this->load->helper('string');
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
			$applicant_pic = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET profile_picture='" . $applicant_pic . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
		/* @TODO Mail and SmS */
	}

	function upload_iqama_front(){
		$this->load->helper('string');
		
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
			$iqama_image_front = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET iqama_image_front='" . $iqama_image_front . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_iqama_back(){
		$this->load->helper('string');
		
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
			$iqama_image_back = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET iqama_image_back='" . $iqama_image_back . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_licence_front(){
		$this->load->helper('string');
		
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
			$driving_licence_front = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET driving_licence_front='" . $driving_licence_front . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_licence_back(){
		$this->load->helper('string');
		
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
			$driving_licence_back = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET driving_licence_back='" . $driving_licence_back . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_iban_pic(){
		$this->load->helper('string');
		
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
			$iban_certificate = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET iban_certificate='" . $iban_certificate . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_reg_front(){
		$this->load->helper('string');
		
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
			$car_registration_front = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_registration_front='" . $car_registration_front . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_reg_back(){
		$this->load->helper('string');
		
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
			$car_registration_back = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_registration_back='" . $car_registration_back . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_insurance(){
		$this->load->helper('string');
		
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
			$car_insurance_picture = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_insurance_picture ='" . $car_insurance_picture . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_front(){
		$this->load->helper('string');
		
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
			$car_front_side = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_front_side ='" . $car_front_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_back(){
		$this->load->helper('string');
		
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
			$car_back_side = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_back_side ='" . $car_back_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_left(){
		$this->load->helper('string');
		
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
			$car_left_side = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_left_side ='" . $car_left_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function upload_car_right(){
		$this->load->helper('string');
		
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
			$car_right_side = "";
		}
			
		$query = $this->db->query("UPDATE delivery_boy_documents SET car_right_side ='" . $car_right_side . "', updated_at = now() WHERE deliveryboy_id = '". (int)$this->deliveryboy->getId() ."'");
		
		return $query;
	}

	function change_password_by_id($password){
		$this->load->helper('string');
		$query = $this->db->query("UPDATE delivery_vehicles SET salt = '" . $this->db->escape_str($salt = random_string('alnum', 20)) . "', password = '" . $password . "', ip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE id = '" . (int)$this->deliveryboy->getId() . "'");
		return $query;
	}
}
