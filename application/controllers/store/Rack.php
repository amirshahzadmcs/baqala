<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rack extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->store->isLogged()){		
			$this->load->model('store/Racks_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('store/login');			
		}
	}

	public function index(){
		//$data['result'] = $this->Racks_model->get_list();
		if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('stores/rack/list',$data);
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
			$sub_array[] = $rack->created_at;
			$sub_array[] = $rack->updated_at;
			$sub_array[] = $rack->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';
			$sub_array[] = '<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'store/rack/add?id='.$rack->id.'"><i class="fa fa-edit"></i></a>';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                    =>     intval($_POST["draw"]),  
			"recordsTotal"          =>      $this->Racks_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Racks_model->get_filtered_data(),  
			"data"                    =>     $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Racks_model->get_store_rack_by_id($this->input->get('id'));
			if($query->num_rows() > 0){
			    $detail = $query->row();
    			$data['id'] = $detail->id;
    			$data['rack_name'] = $detail->rack_name;
    			$data['status'] = $detail->status;
			}else{
			    $this->session->set_userdata('info', "2--Unauthorized!!!");
			    redirect('store/rack/list');
			}
		}
		else{
			$data['id'] = "";
			$data['rack_name'] = "";
			$data['status'] = "";
		}
		$this->load->view('stores/rack/form',$data);
	}

	public function add_rack(){
		$this->form_validation->set_rules('rack_name', 'Rack Name', 'trim|required|callback_check_rack_duplicate');
    	$this->form_validation->set_message('check_rack_duplicate','Rack already exists, Try new');
		$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
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
		redirect('store/rack/list');
	}
	
	public function check_rack_duplicate() {
		$id = $this->input->post('id');
		$rack_name = $this->input->post('rack_name');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Racks_model->check_duplicate_rack($id, $rack_name);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Racks_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('store/rack/list');
	}
}