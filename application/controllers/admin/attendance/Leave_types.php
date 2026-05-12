<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_types extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){
			$this->load->model('admin/attendance/Leave_model');
			$this->load->library('form_validation');	
			$this->load->helper('common_helper');	
		}		
		else{		
			redirect('admin/login');			
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
		$this->load->view('admin/attendance/leave/index',$data);
	}
	
	public function add(){
		$this->load->view('admin/attendance/leave/form');
	}

	public function edit(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$data['leaves'] = $this->Leave_model->get_detail($id);
			//print_r($data['family_members']);exit();
			$this->load->view('admin/attendance/leave/edit',$data);
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/attendance/leave-list');
		}
	}

	public function save(){
		$this->form_validation->set_rules('name', 'Leave Name', 'trim|required|callback_check_leave_duplicate');
		$this->form_validation->set_message('check_leave_duplicate','Leave name already used.');
		$this->form_validation->set_rules('color_code', 'Color', 'trim|required');
		$this->form_validation->set_rules('days_allowed_per_year', 'Max Days Allowed Per Year', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Leave_model->edit();
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated");
				}
				else{
					$this->session->set_userdata('info', "2--Error in updating.");
				}
    		}
    		else{
    			$query = $this->Leave_model->add();
				if($query){
					$this->session->set_userdata('info', "1--Successfully added");
				}
				else{
					$this->session->set_userdata('info', "2--Error in adding.");
				}
    		}
		}
		redirect('admin/attendance/leave-list');
	}

	public function check_leave_duplicate() {
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$duplicate_check = $this->Leave_model->check_duplicate_title($id, $name);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function ajax_leave_duplicate() {
		$name = $this->input->get('name');
		$id = $this->input->get('id');;
		if($name !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Leave_model->check_duplicate_title($id, $name);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $name . "</b> This Title already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Title Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Title is required.</span>";
		}
		echo json_encode($data);
	}

	public function detail(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$data['leaves'] = $this->Leave_model->get_detail($id);
			$this->load->view('admin/attendance/leave/detail',$data);
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/attendance/leave-list');
		}
	}

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		$fetch_data = $this->Leave_model->get_list($keyword);
		//print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $item->name .'<br>'. $item->name_ar;
			$sub_array[] = $item->days_allowed_per_year;
			$sub_array[] = $item->continuous_days_applicable;
			$sub_array[] = date('d-m-Y H:i A', strtotime($item->created_at));
			$sub_array[] = date('d-m-Y H:i A', strtotime($item->updated_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/attendance/leave/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/attendance/leave/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Delete" onclick="return confirm(\'Are you sure you want to delete this item?\');" href="'.base_url().'admin/attendance/leave/delete?id='.$item->id.'"><i class="mdi mdi-trash-can-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Leave_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Leave_model->get_filtered_data($keyword),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$id = $this->input->get('id');
		$query = $this->Leave_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/attendance/leave-list');
	}
}
