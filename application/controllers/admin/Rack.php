<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rack extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Racks_model');	
			$this->load->library('form_validation');
			$this->action=$this->router->method;
		}		
		else{		
			redirect('admin/login');			
		}
	}

	public function index(){
		if($this->action && !check_action_permission(get_user_role(),'manage_rack',$this->action)){
			redirect('admin/unauthorized-request');
		}
		//$data['result'] = $this->Racks_model->get_list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/rack/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Racks_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $rack){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $rack->id .'" name="check_list[]" />';
			$sub_array[] = $rack->id;
			$sub_array[] = $rack->rack_name;
			$sub_array[] = $rack->total_products;
			$sub_array[] = $rack->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';
			$sub_array[] = $rack->created_at;
			$sub_array[] = $rack->updated_at;
			$sub_array[] = check_action_permission(get_user_role(),'manage_rack','add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/rack/add?id='.$rack->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Racks_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Racks_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->action && !check_action_permission(get_user_role(),'manage_rack',$this->action)){
			redirect('admin/unauthorized-request');
		}
		if($this->input->get('id')){
			$query = $this->Racks_model->get_product_rack_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['rack_name'] = $query->rack_name;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['rack_name'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/rack/form',$data);
	}

	public function add_rack(){
		if($this->input->post('id')){
			$this->form_validation->set_rules('rack_name', 'Rack Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		}else{
			$this->form_validation->set_rules('rack_name', 'Rack Name', 'trim|required|is_unique[product_rack.rack_name]', array('is_unique' => 'Duplicate rack name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Racks_model->edit();
			}
			else{
				$query = $this->Racks_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/rack/list');
	}

	public function delete(){
		if($this->action && !check_action_permission(get_user_role(),'manage_rack',$this->action)){
			redirect('admin/unauthorized-request');
		}
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Racks_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/rack/list');
	}
}
