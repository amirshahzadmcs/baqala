<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_restrictions extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){
			$this->load->model('admin/attendance/Attendance_restriction_model');
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');	
		}		
		else{		
			redirect('admin/login');			
		}
	}

	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/attendance/restrictions/index',$data);
	}
	
	public function add(){
		$this->load->view('admin/attendance/restrictions/form');
	}

	public function edit(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$data['restriction'] = $this->Attendance_restriction_model->get_detail($id);
			//print_r($data['shifts']);exit();
			$this->load->view('admin/attendance/restrictions/edit',$data);
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/attendance/restriction-list');
		}
	}

	public function save(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required|callback_check_title_duplicate');
		$this->form_validation->set_message('check_title_duplicate','Restrictions name already used.');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->input->post('is_allowed_ips') == 'on'){
			$this->form_validation->set_rules('ip_validation', 'IP Validation', 'trim|required');
			$this->form_validation->set_rules('allowed_ips', 'Allowed IPs', 'trim|required');
		}
		if($this->input->post('is_location_restricted') == 'on'){
			$this->form_validation->set_rules('location_validation', 'Location Validation', 'trim|required');
			$this->form_validation->set_rules('map_location', 'Map', 'trim|required');
			$this->form_validation->set_rules('map[]', 'Select valid map', 'trim|required');
			$this->form_validation->set_rules('location_range', 'Location Range', 'trim|required');
			$this->form_validation->set_rules('range_unit', 'Range Unit', 'trim|required');
		}
		if($this->input->post('is_photo_required') == 'on'){
			$this->form_validation->set_rules('photo_validation', 'Photo Validation', 'trim|required');
		}
		//$this->form_validation->set_rules('is_allowed_ips', 'Restricted by IPs', 'trim|required');
		//$this->form_validation->set_rules('is_location_restricted', 'Beginning In', 'trim|required');
		//$this->form_validation->set_rules('is_photo_required', 'Ending Out', 'trim|required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			//$post_data = $this->input->post();
			//print_r($post_data['map']);exit();
    		if($this->input->post('id')){
    			$query = $this->Attendance_restriction_model->edit();
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated");
				}
				else{
					$this->session->set_userdata('info', "2--Error in updating.");
				}
    		}
    		else{
    			$query = $this->Attendance_restriction_model->add();
				if($query){
					$this->session->set_userdata('info', "1--Successfully added");
				}
				else{
					$this->session->set_userdata('info', "2--Error in adding.");
				}
    		}
		}
		redirect('admin/attendance/restriction-list');
	}

	public function check_title_duplicate() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$duplicate_check = $this->Attendance_restriction_model->check_duplicate_title($id, $name);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function ajax_title_duplicate() {
		$name = $this->input->get('name');
		$id = $this->input->get('id');;
		if($name !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Attendance_restriction_model->check_duplicate_title($id, $name);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $name . "</b> This Title already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Title Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Title is required.</span>";
		}
		echo json_encode($data);
	}

	public function detail(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$data['restriction'] = $this->Attendance_restriction_model->get_detail($id);
			$this->load->view('admin/attendance/restrictions/detail',$data);
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/attendance/restriction-list');
		}
	}

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('status'))){
			$status = $this->input->get('status');
		}
		else{
			$status = FALSE;
		}
		$fetch_data = $this->Attendance_restriction_model->get_list($keyword,$status);
		//print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $item->name;
			$sub_array[] = $item->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y H:i A', strtotime($item->created_at));
			$sub_array[] = date('d-m-Y H:i A', strtotime($item->updated_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/attendance/restriction/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/attendance/restriction/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Delete" onclick="return confirm(\'Are you sure you want to delete this item?\');" href="'.base_url().'admin/attendance/restriction/delete?id='.$item->id.'"><i class="mdi mdi-trash-can-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Attendance_restriction_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Attendance_restriction_model->get_filtered_data($keyword,$status),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$id = $this->input->get('id');
		$query = $this->Attendance_restriction_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/attendance/restriction-list');
	}

	public function ajax_map() {
		$output_data = $this->load->view('admin/attendance/restrictions/partial-map','',TRUE);
		echo $output_data;
	}
}
