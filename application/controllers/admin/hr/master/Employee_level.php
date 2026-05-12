<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_level extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Employee_level_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/hr/master/employee_level/index',$data);
	}

	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Employee_level_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['status'] = $query->status;
			$data['description'] = $query->description;
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['status'] = "";
			$data['description'] = "";
		}
		$this->load->view('admin/hr/master/employee_level/form',$data);
	}

	public function save(){
		$this->form_validation->set_rules('name', 'Designation Name', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Employee_level_model->edit();
    		}
    		else{
    			$query = $this->Employee_level_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/employee-level');
	}

	public function detail(){
		if($this->input->get('id')){
			$query = $this->Employee_level_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['status'] = $query->status;
			$data['description'] = $query->description;
			
			$this->load->view('admin/hr/master/employee_level/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid ID!!");
			redirect('admin/hr/master/employee-level');
		}
	}

	public function list(){
		$fetch_data = $this->Employee_level_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->name;
			$sub_array[] = $store->arabic_name;
			$sub_array[] = $store->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			$sub_array[] = date('d-m-Y', strtotime($store->updated_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/master/employee-level/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Employee_level_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Employee_level_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Employee_level_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/employee-level');
	}


}
