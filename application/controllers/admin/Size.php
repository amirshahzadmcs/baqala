<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Size extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Size_model');	
			$this->load->library('form_validation');	
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
		$this->load->view('admin/size/list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Size_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $size){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $size->id .'" name="check_list[]" />';
			$sub_array[] = $size->size_name;
			$sub_array[] = $size->sort_order;
			$sub_array[] = $size->created_at;
			$sub_array[] = $size->updated_at;
			$sub_array[] = $size->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/size/add?id='.$size->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Size_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Size_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Size_model->get_size_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['size_name'] = $query->size_name;
				$data['sort_order'] = $query->sort_order;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['size_name'] = "";
			$data['sort_order'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/size/form',$data);
	}

	public function add_size(){
		if($this->input->post('id')){
			$this->form_validation->set_rules('size_name', 'Size Name', 'trim|required');
			$this->form_validation->set_rules('status', 'Status Name', 'trim|required');
		}else{
			$this->form_validation->set_rules('size_name', 'Size Name', 'trim|required|is_unique[master_size.size_name]', array('is_unique' => 'Duplicate size name.'));
			$this->form_validation->set_rules('status', 'Status', 'trim|required');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Size_model->edit();
			}
			else{
				$query = $this->Size_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/size');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Size_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/size');
	}
}