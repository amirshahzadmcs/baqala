<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shelf extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->store->isLogged()){		
			$this->load->model('store/Shelf_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('store/login');			
		}
	}

	public function index(){
		if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['racks'] = $this->Shelf_model->get_racks();
		$this->load->view('stores/shelf/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Shelf_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $shelf){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $shelf->id .'" name="check_list[]" />';
			$sub_array[] = $shelf->rack_id;
			$sub_array[] = $shelf->rack_name;
			$sub_array[] = $shelf->shelf_name;
			$sub_array[] = $shelf->id;
			$sub_array[] = $shelf->created_at;
			$sub_array[] = $shelf->updated_at;
			$sub_array[] = $shelf->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';
			$sub_array[] = '<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'store/shelf/edit?id='.$shelf->id.'"><i class="fa fa-edit"></i></a>';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                    =>     intval($_POST["draw"]),  
			"recordsTotal"          =>      $this->Shelf_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Shelf_model->get_filtered_data(),  
			"data"                    =>     $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Shelf_model->get_product_shelf_by_id($this->input->get('id'))->row();
			$data['id'] = $query->id;
			$data['rack_id'] = $query->rack_id;
			$data['shelf_name'] = $query->shelf_name;
			$data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['rack_id'] = "";
			$data['shelf_name'] = "";
			$data['status'] = "";
		}
		$data['racks'] = $this->Shelf_model->get_racks();
		$this->load->view('stores/shelf/form',$data);
	}

	public function add_shelf(){
	    $this->form_validation->set_rules('shelf_name', 'Shelf Name', 'trim|required|callback_check_shelf_duplicate');
    	$this->form_validation->set_message('check_shelf_duplicate','Shelf already exists, Try new');
		$this->form_validation->set_rules('rack_id', 'Select Rack', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Shelf_model->edit();
				if($query){
    				$this->session->set_userdata('info', "1--Successfully updated");
    			}
    			else{
    				$this->session->set_userdata('info', "2--Error!!!");
    			}
			}
			else{
				$query = $this->Shelf_model->add();
				if($query){
    				$this->session->set_userdata('info', "1--Successfully added");
    			}
    			else{
    				$this->session->set_userdata('info', "2--Error!!!");
    			}
			}
		}
		redirect('store/shelf/list');
	}
    
    public function check_shelf_duplicate() {
		$id = $this->input->post('id');
		$shelf_name = $this->input->post('shelf_name');
		$rack_id = $this->input->post('rack_id');
		// do some database things you need to do e.g.
		$duplicate_check = $this->Shelf_model->check_duplicate_shelf($id, $rack_id, $shelf_name);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}
	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Shelf_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('store/shelf/list');
	}
}