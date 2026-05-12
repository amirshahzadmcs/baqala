<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Remuneration extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/hr/master/Remuneration_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$action=$this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'remunerations',$action) && !in_array($action, ['save','get_list'])):
				redirect('admin/unauthorized-request');
			endif;
		}		
		else{		
			redirect('admin/login');			
		}
	}
	
	public function index(){
		//$data['result'] = $this->Remuneration_model->get_list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/hr/master/remuneration/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Remuneration_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $cat){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $cat->id .'" name="check_list[]" />';
			$sub_array[] = $cat->remuneration_name .'<br>'. $cat->remuneration_name_ar;
			$sub_array[] = $cat->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $cat->created_at;
			$sub_array[] = $cat->updated_at;
			$sub_array[] = check_action_permission(get_user_role(),'remunerations','add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/hr/master/remuneration/add?id='.$cat->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Remuneration_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Remuneration_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Remuneration_model->get_detail($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['remuneration_name'] = $query->remuneration_name;
				$data['remuneration_name_ar'] = $query->remuneration_name_ar;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['remuneration_name'] = "";
			$data['remuneration_name_ar'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/hr/master/remuneration/form',$data);
	}

	public function save(){
		$this->form_validation->set_rules('remuneration_name', 'Remuneration Name', 'trim|required|callback_check_duplicate');
		$this->form_validation->set_message('check_duplicate','Remuneration already exist, Try new');
		$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Remuneration_model->edit();
			}
			else{
				$query = $this->Remuneration_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/master/remuneration/list');
	}

	public function check_duplicate() {
		$remuneration_name = $this->input->post('remuneration_name');
		$id = $this->input->post('id');
		if($id !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->db->query("SELECT * FROM master_remuneration WHERE remuneration_name = '". $remuneration_name ."' AND id != '". $id ."'");
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
		$query = $this->Remuneration_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/master/remuneration/list');
	}
}
