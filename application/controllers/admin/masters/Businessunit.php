<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Businessunit extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/masters/Businessunit_model', 'business_unit');	
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'business_units',$action) && !in_array($action, ['save','get_list'])):
				redirect('admin/common/permission');
			endif;
		}		
		else{		
			redirect('admin');			
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
		return $this->load->view('admin/masters/business-unit/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->business_unit->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $brand){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $brand->id .'" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->department_name;
			$sub_array[] = $brand->business_unit_name;
			$sub_array[] = $brand->business_unit_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/master/business-unit/add?id='.$brand->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"            => intval($_POST["draw"]),  
			"recordsTotal"    => $this->business_unit->get_all_data(),  
			"recordsFiltered" => $this->business_unit->get_filtered_data(),  
			"data"            => $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->business_unit->detail($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['department_id'] = $query->department_id;
				$data['business_unit_name'] = $query->business_unit_name;
				$data['business_unit_name_ar'] = $query->business_unit_name_ar;
			}
		}
		else{
			$data['id'] = "";
			$data['department_id'] = "";
			$data['business_unit_name'] = "";
			$data['business_unit_name_ar'] = "";
		}
		return $this->load->view('admin/masters/business-unit/form',$data);
	}

	public function save(){
		if($this->input->post('id')){
			$this->form_validation->set_rules('department_id', 'Department Name', 'trim|required');
			$this->form_validation->set_rules('business_unit_name', 'Business Unit Name', 'trim|required');
		}else{
			$this->form_validation->set_rules('department_id', 'Department Name', 'trim|required');
			$this->form_validation->set_rules('business_unit_name', 'Business Unit Name', 'trim|required|is_unique[master_business_unit.business_unit_name]', array('is_unique' => 'Duplicate Business Unit Name.'));
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->business_unit->edit();
			}
			else{
				$query = $this->business_unit->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/business-unit');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->business_unit->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/business-unit');
	}
}