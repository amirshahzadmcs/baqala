<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if($this->company->isLogged()){
			$this->load->model('company/Sells_model');
			$this->load->library('form_validation');
		}
		else{
			redirect('company');
		}
	}
	
	public function index(){
		if ($this->company->getInfo()){
			$info = explode('--', $this->company->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('company/sales/list',$data);
	}
	
	public function edit(){
		if($this->input->get('id')){
			$query = $this->Sells_model->get_user($this->input->get('id'));
			foreach($query->result() as $user){
				$data['id'] = $user->id;
				$data['name'] = $user->name;
				$data['mobile'] = $user->mobile;
				$data['email'] = $user->email;
				$data['status'] = $user->status;
				$data['password'] = $user->password;
				$data['created_at'] = $user->created_at;
			}
		}
		else{
			$data['id'] = '';
			$data['name'] = '';
			$data['mobile'] = '';
			$data['email'] = '';
			$data['status'] = '';
			$data['password'] = '';
			$data['created_at'] = '';
		}
		$this->load->view('company/sales/form',$data);
	}
    
	public function add_sales(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim');
		$this->form_validation->set_rules('password', 'Password', 'trim');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			/*
			if($_FILES['image']['name']){
				$con['upload_path']   = './uploads/profile/'; 
				$con['allowed_types'] = 'jpg|jpeg|png'; 
				$con['max_size']      = 2048; 
				$con['max_width']     = 1500; 
				$con['max_height']    = 1000;  
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
				   echo $this->upload->display_errors();
				   exit;
				} 
				else {
					$image_data = $this->upload->data();
					$image = "uploads/profile/".$image_data['file_name'];
               }
			}
			else{
				$image = $this->input->post('o_img');
			}*/
			if($this->input->post('id')){
				$query = $this->Sells_model->manage();
			}
			else{
				$query = $this->Sells_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
			}
		}
		
		redirect('sales-list');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Sells_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Something went wrong, try again!!!");
		}
		redirect('sales-list');
	}
	
	public function detail(){
		$id = $this->input->get('id');
		$data['result'] = $this->Sells_model->get_user($id)->row();
		$this->load->view('company/company/user_detail', $data);
	}
	
	public function get_list(){
		$fetch_data = $this->Sells_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $user){
			$sub_array = array();
			$sub_array[] = ' '. $i++;
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$user->id.'" />';	
			$sub_array[] = $user->name;
			$sub_array[] = $user->email;
			$sub_array[] = $user->mobile;
			$sub_array[] = $user->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Pending</div>';
			$sub_array[] = date("d M,Y h:i A", strtotime($user->created_at));
			$sub_array[] = '<a class="btn btn-danger btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'add-sales?id='.$user->id.'"><i class="fa fa-edit"></i></a> <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Detail" href="'.base_url().'company/sales/detail?id='.$user->id.'"><i class="fa fa-eye"></i></a>';				 
			$data[] = $sub_array;
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Sells_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Sells_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
}
