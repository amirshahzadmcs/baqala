<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Store_model');
			$this->load->library('form_validation');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/store/list',$data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Store_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['store_name'] = $query->store_name;
			$data['store_name_arabic'] = $query->store_name_arabic;
			$data['store_id'] = $query->store_id;
			$data['store_incharge'] = $query->store_incharge;
			$data['email'] = $query->email;
			$data['contact_number'] = $query->contact_number;
			$data['google_coordinates_lat'] = $query->google_coordinates_lat;
			$data['google_coordinates_long'] = $query->google_coordinates_long;
			$data['store_radius'] = $query->store_radius;
			$data['store_location'] = $query->store_location;
		    $data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['store_name'] = "";
			$data['store_name_arabic'] = "";
			$data['store_id'] = "";
			$data['store_incharge'] = "";
			$data['email'] = "";
			$data['contact_number'] = "";
			$data['google_coordinates_lat'] = "";
			$data['google_coordinates_long'] = "";
			$data['store_radius'] = "";
			$data['store_location'] = "";
		    $data['status'] = "";
		}
		$this->load->view('admin/store/form',$data);
	}
	
	public function add_store(){
		$this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
		$this->form_validation->set_rules('store_name_arabic', 'Arabic Name', 'trim|required');
		$this->form_validation->set_rules('store_id', 'Store ID', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('store_incharge', 'Store Incharge', 'trim|required');
		$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
		$this->form_validation->set_rules('google_coordinates_lat', 'Latitude', 'trim|required');
		$this->form_validation->set_rules('google_coordinates_long', 'Longitude', 'trim|required');
		$this->form_validation->set_rules('store_radius', 'Store Radius', 'trim|required');
		$this->form_validation->set_rules('store_location', 'Complete Address', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if(empty($this->input->post('id'))){
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Store_model->edit();
    		}
    		else{
				//print_r('edfdf');exit();
				$password = $this->role->get_random_password($chars_min = 6, $chars_max = 6, $use_upper_case = false, $include_numbers = true, $include_special_chars = false);
    			$hashpassword = $this->enc_lib->encrypt($password);
				
				$query = $this->Store_model->add($hashpassword);
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/store');
	}

	public function add_thirdparty(){
		$this->load->view('admin/store/form-third-party');
	}
	
	public function get_list(){
		$fetch_data = $this->Store_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->store_id;
			$sub_array[] = $store->store_name . '<br/>' . $store->store_name_arabic;
			$sub_array[] = $store->store_incharge;
			$sub_array[] = $store->email;
			$sub_array[] = $store->contact_number;
			$sub_array[] = $store->store_radius;
			$sub_array[] = $store->store_location;
			$sub_array[] = $store->status == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Disabled</div>';
			$sub_array[] = '<a class="btn btn-warning btn-sm" title="Edit" href="'.base_url().'admin/store/add?id='.$store->id.'"><i class="fa fa-edit"></i></a> <a class="btn btn-primary btn-sm" title="Detail" href="'.base_url().'admin/store/detail?id='.$store->id.'"><i class="fa fa-eye"></i></a>';				 
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Store_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Store_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function detail(){
		$id = $this->input->get('id');
		$data['result'] = $this->Store_model->get_detail($id);
		$this->load->view('admin/store/detail', $data);
	}
	
	public function setStatusEnable(){
		if($this->admin->isLogged()){
			$ids = $this->input->post('checklist');
		    $query = $this->Store_model->setStatusEnable($ids);
			if($query){
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/store');
		}
		else{
			redirect('admin');
		}
	}
	
	public function setStatusDisable(){
		if($this->admin->isLogged()){
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
		    $query = $this->Store_model->setStatusDisable($ids);
    		if($query){
    			$this->session->set_userdata('info', "1--Status Successfully Updated");
    		}
    		else{
    			$this->session->set_userdata('info', "2--Error");
    		}
    		redirect('admin/store');
    	}else{
			redirect('admin');
		}
	}
	
	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Store_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/store');
	}

}
