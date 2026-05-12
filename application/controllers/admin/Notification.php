<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Notification_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('admin/common/login');			
		}
	}

	public function index(){
		//$data['result'] = $this->Notification_model->get_list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/notification/notification_list',$data);
	}
	
	public function get_list(){
		$fetch_data = $this->Notification_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $notification){  
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $notification->id .'" name="check_list[]" />';
			$sub_array[] = $notification->title;
			$sub_array[] = $notification->message;
			$sub_array[] = $notification->created_at;
			$sub_array[] = $notification->updated_at;
			$sub_array[] = $notification->ended_on;
			$sub_array[] = $notification->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';
			$sub_array[] = '<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/notification/add?id='.$notification->id.'"><i class="fa fa-edit"></i></a>';
			$data[] = $sub_array;  
		}
		$output = array(  
			"draw"                    =>     intval($_POST["draw"]),  
			"recordsTotal"          =>      $this->Notification_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Notification_model->get_filtered_data(),  
			"data"                    =>     $data  
		);  
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Notification_model->get_notification_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['title'] = $query->title;
				$data['message'] = $query->message;
				$data['ended_on'] = $query->ended_on;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['title'] = "";
			$data['message'] = "";
			$data['ended_on'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/notification/notification_form',$data);
	}

	public function add_notification(){
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		$this->form_validation->set_rules('ended_on', 'End Date', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Notification_model->edit();
			}
			else{
				$query = $this->Notification_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/notification');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Notification_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/notification');
	}
}