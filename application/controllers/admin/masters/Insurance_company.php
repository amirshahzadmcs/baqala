<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Insurance_company extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/masters/Insurance_comp_model');	
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');
			$action = $this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(), 'insurance_companies', $action) && !in_array($action, ['save', 'get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		}		
		else{		
			redirect('admin/login');			
		}
	}

	public function index(){
		//$data['result'] = $this->Insurance_comp_model->get_list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/masters/insurance_company/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Insurance_comp_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $cat){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $cat->id .'" name="check_list[]" />';
			$sub_array[] = $cat->company_name;
			$sub_array[] = $cat->company_name_ar;
			$sub_array[] = $cat->total_policies;;
			$sub_array[] = $cat->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $cat->created_at;
			$sub_array[] = $cat->updated_at;
			$sub_array[] = check_action_permission(get_user_role(),'insurance_companies','add') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" data-id="'.$cat->id.'" onclick="editModal('.$cat->id.')"><i class="mdi mdi-pencil font-size-18"></i></button>' : '';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Insurance_comp_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Insurance_comp_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function add()
    {
		$this->form_validation->set_rules('id', 'Request ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$result = array("type"=>'error', "message"=>validation_errors());
		}
		else{
			$id = $this->input->post('id');
			$query = $this->Insurance_comp_model->get_detail($id);
			if($query->num_rows() > 0){
				$data['detail'] = $query->row();
				$output_data = $this->load->view('admin/masters/insurance_company/form',$data,TRUE);
				$result = array("type"=>'success', "message"=>'Insurance company detail successfully fetched.', "output_html"=> $output_data);
			}else{
				$result = array("type"=>'success', "message"=>'Insurance company detail not found.');
			}
		}
		echo json_encode($result);
    }
	
	public function save(){
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate','Company already exist, Try new');
		$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Insurance_comp_model->edit();
			}
			else{
				$query = $this->Insurance_comp_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/insurance-company/list');
	}

	public function check_duplicate() {
		$company_name = $this->input->post('company_name');
		$id = $this->input->post('id');
		if($id !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->db->query("SELECT * FROM master_insurance_company WHERE company_name = '". $company_name ."' AND id != '". $id ."'");
			//print_r($sku_check);exit();
			if($duplicate_check->num_rows() > 0) {
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Insurance_comp_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/insurance-company/list');
	}
}
