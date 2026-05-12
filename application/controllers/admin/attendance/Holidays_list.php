<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Holidays_list extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){
			$this->load->model('admin/attendance/Holiday_model');
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
		$this->load->view('admin/attendance/holiday_lists/index',$data);
	}
	
	public function add(){
		$this->load->view('admin/attendance/holiday_lists/form');
	}

	public function edit(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$data['group'] = $this->Holiday_model->get_detail($id);
			$data['days'] = $this->Holiday_model->get_holiday_days($id);
			//print_r($data['family_members']);exit();
			$this->load->view('admin/attendance/holiday_lists/edit',$data);
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/attendance/holidays-list');
		}
	}

	public function save(){
		$this->form_validation->set_rules('group_title', 'Holiday Name', 'trim|required|callback_check_holiday_duplicate');
		$this->form_validation->set_message('check_holiday_duplicate','Holiday name already used.');
		$this->form_validation->set_rules('date_off[]', 'Date', 'trim|required');
		$this->form_validation->set_rules('title[]', 'Day OFF Title', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Holiday_model->edit();
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated");
				}
				else{
					$this->session->set_userdata('info', "2--Error in updating.");
				}
    		}
    		else{
    			$query = $this->Holiday_model->add();
				if($query){
					$this->session->set_userdata('info', "1--Successfully added");
				}
				else{
					$this->session->set_userdata('info', "2--Error in adding.");
				}
    		}
		}
		redirect('admin/attendance/holidays-list');
	}

	public function check_holiday_duplicate() {
		$id = $this->input->post('id');
		$group_title = $this->input->post('group_title');
		$duplicate_check = $this->Holiday_model->check_duplicate_title($id, $group_title);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function ajax_holiday_duplicate() {
		$group_title = $this->input->get('group_title');
		$id = $this->input->get('id');;
		if($group_title !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Holiday_model->check_duplicate_title($id, $group_title);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $group_title . "</b> This Title already exists. Try New.</span>";
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
			$data['group'] = $this->Holiday_model->get_detail($id);
			$data['days'] = $this->Holiday_model->get_holiday_days($id);
			$this->load->view('admin/attendance/holiday_lists/detail',$data);
		}else{
			$this->session->set_userdata('msg_info', "2--Invalid request!");
			redirect('admin/attendance/holidays-list');
		}
	}

	public function get_list(){
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		$fetch_data = $this->Holiday_model->get_list($keyword);
		//print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $item->group_title .'<br>'. $item->group_title_ar;
			$sub_array[] = $item->total_days;
			$sub_array[] = date('d-m-Y H:i A', strtotime($item->created_at));
			$sub_array[] = date('d-m-Y H:i A', strtotime($item->updated_at));
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/attendance/holidays/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/attendance/holidays/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Delete" onclick="return confirm(\'Are you sure you want to delete this item?\');" href="'.base_url().'admin/attendance/holidays/delete?id='.$item->id.'"><i class="mdi mdi-trash-can-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Holiday_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Holiday_model->get_filtered_data($keyword),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$id = $this->input->get('id');
		$query = $this->Holiday_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/attendance/holidays-list');
	}
}
