<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->admin->isLogged()){
			$this->load->model('admin/Agent_model');
			$this->load->library('form_validation');
		}
		else{
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/agent/user_list',$data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Agent_model->get_customer($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;
				$data['email'] = $query->email;
				$data['phone'] = $query->phone;
				$data['account_no'] = $query->account_no;
				$data['bank_name'] = $query->bank_name;
				$data['ifsc'] = $query->ifsc;
				$data['ref_code'] = $query->ref_code;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['email'] = "";
			$data['phone'] = "";
			$data['account_no'] = "";
			$data['bank_name'] = "";
			$data['ifsc'] = "";
			$data['ref_code'] = "";
			$data['status'] = "";
		}
		$this->load->view('admin/agent/user_form',$data);
	}

	public function add_agent(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('account_no', 'Account No', 'trim|required');
		$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required');
		$this->form_validation->set_rules('ifsc', 'IFSC', 'trim|required');
		$this->form_validation->set_rules('ref_code', 'Referal Code', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Agent_model->manage();
			}
			else{
				$query = $this->Agent_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/agent');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Agent_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/agent');
	}
	
	public function detail(){
		$id = $this->input->get('id');
		$data['result'] = $this->Agent_model->get_customer($id)->row();
		$this->load->view('admin/agent/detail', $data);
	}
	
	public function get_list(){
	   $fetch_data = $this->Agent_model->get_list();		   
	//	$i = $_POST['start'] + 1 ;
	   $data = array();  
	   foreach($fetch_data as $user){
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$user->id.'" />';
					
			$sub_array[] = $user->name;
			$sub_array[] = $user->email;
			$sub_array[] = $user->phone;
			$sub_array[] = $user->ref_code;
			$sub_array[] = date("d M,Y h:i A", strtotime($user->created_at));
			$sub_array[] = $user->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Deactive</div>';
			$sub_array[] = '<a class="btn btn-warning btn-sm" data-toggle="tooltip" title="Block" href="'.base_url().'admin/agent/add?id='.$user->id.'"><i class="fa fa-edit"></i></a><a class="btn btn-info btn-sm" data-toggle="tooltip" title="Detail" href="'.base_url().'admin/agent/detail?id='.$user->id.'"><i class="fa fa-eye"></i></a>';				 
			$data[] = $sub_array;
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Agent_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Agent_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	
}
