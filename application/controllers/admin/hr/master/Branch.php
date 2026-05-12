<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/hr/master/Branch_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'branches',$action) && !in_array($action, ['save','get_list'])):
				redirect('admin/common/permission');
			endif;
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
		$this->load->view('admin/hr/master/branch/index',$data);
	}

	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Branch_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['branch_name'] = $query->branch_name;
			$data['branch_name_ar'] = $query->branch_name_ar;
			$data['description'] = $query->description;
			$data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['branch_name'] = "";
			$data['branch_name_ar'] = "";
			$data['description'] = "";
			$data['status'] = "";
		}

		// print_r($data['nationality_no']);exit();
		$this->load->view('admin/hr/master/branch/form',$data);
	}

	public function save(){
		$this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Branch_model->edit();
    		}
    		else{
    			$query = $this->Branch_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/branch');
	}

	public function detail(){
		if($this->input->get('id')){
			$query = $this->Branch_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['branch_name'] = $query->branch_name;
			$data['branch_name_ar'] = $query->branch_name_ar;
			$data['description'] = $query->description;
			$data['status'] = $query->status;
			
			$this->load->view('admin/hr/master/branch/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Request!!!");
			redirect('admin/hr/master/branch');
		}
	}

	public function get_list(){
		$fetch_data = $this->Branch_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $branch){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$branch->id.'" />';
			$sub_array[] = $branch->branch_name;
			$sub_array[] = $branch->branch_name_ar;
			$sub_array[] = $branch->description;
			$sub_array[] = $branch->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y', strtotime($branch->created_at));
			$sub_array[] = date('d-m-Y', strtotime($branch->updated_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/master/branch/add?id='.$branch->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Branch_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Branch_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Branch_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/branch');
	}

}
