<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if($this->company->isLogged()){
			$this->load->model('company/Product_model');
			$this->load->library('form_validation');
		}
		else{
			redirect('company-login');
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
		$this->load->view('company/product/list',$data);
	}

	public function edit(){
		if($this->input->get('id')){
			$query = $this->Product_model->get_product($this->input->get('id'));
			foreach($query->result() as $user){
				$data['id'] = $user->id;
				$data['name'] = $user->name;
				$data['name_arabic'] = $user->name_arabic;
				$data['sku'] = $user->sku;
				$data['qty'] = $user->qty;
				$data['cost_price'] = $user->cost_price;
				$data['selling_price'] = $user->selling_price;
				$data['status'] = $user->status;
				$data['created_at'] = $user->created_at;
			}
		}
		else{
			$data['id'] = '';
			$data['name'] = '';
			$data['name_arabic'] = '';
			$data['sku'] = '';
			$data['qty'] = '';
			$data['cost_price'] = '';
			$data['selling_price'] = '';
			$data['status'] = '';
			$data['created_at'] = '';
		}
		$this->load->view('company/product/form',$data);
	}

	public function add_product(){
		$this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if($this->input->post('id') == ''){
			$this->form_validation->set_rules('sku', 'SKU', 'trim|is_unique[product.sku]');
		}
		$this->form_validation->set_rules('cost_price', 'Cost Price', 'required');
		$this->form_validation->set_rules('selling_price', 'Selling Price', 'required');
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
				$query = $this->Product_model->manage();
			}
			else{
				$query = $this->Product_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Product successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong!!!");
			}
		}
		
		redirect('product-list');
	}

	public function delete(){
		$checkid = $this->input->post('check_list');
		if($checkid){
			$id = implode(',',$this->input->post('check_list'));
			$query = $this->Product_model->delete($id);
			if($query){
				$this->session->set_userdata('info', "1--Product successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong!!!");
			}
			redirect('product-list');
		}else{
			$this->session->set_userdata('info', "2--Select product to delete!!!");
			redirect('product-list');
		}
	}
	
	public function detail(){
		$id = $this->input->get('id');
		$data['result'] = $this->Product_model->get_user($id)->row();
		$this->load->view('company/product/product_detail', $data);
	}
	
	public function get_list(){
		$fetch_data = $this->Product_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $user){
			$sub_array = array();
			$sub_array[] = ' '. $i++;
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$user->id.'" />';	
			$sub_array[] = $user->name;
			$sub_array[] = $user->name_arabic;
			$sub_array[] = $user->sku;
			$sub_array[] = $user->qty;
			$sub_array[] = $user->cost_price;
			$sub_array[] = $user->selling_price;
			$sub_array[] = $user->status == 1 ? '<div class="label label-success">Active</div>':'<div class="label label-danger">Pending</div>';
			$sub_array[] = date("d M,Y h:i A", strtotime($user->created_at));
			$sub_array[] = '<a class="btn btn-danger btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'add-product?id='.$user->id.'"><i class="fa fa-edit"></i></a> <a class="btn btn-info btn-sm" data-toggle="tooltip" title="Detail" href="'.base_url().'product-detail?id='.$user->id.'"><i class="fa fa-eye"></i></a>';				 
			$data[] = $sub_array;
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Product_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Product_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	
}
