<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if($this->admin->isLogged()){
			$this->load->model('admin/Delivery_model');
			$this->load->model('admin/Order_process_model');
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
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/delivery/deliveryboy_list',$data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Delivery_model->get_deliverboy($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['name'] = $query->name;
				$data['partner_id'] = $query->partner_id;
				$data['arabic_name'] = $query->arabic_name;
				$data['mobile'] = $query->mobile;
				$data['iqama_no'] = $query->iqama_no;
				$data['iqama_exp'] = $query->iqama_exp;
				$data['address'] = $query->address;
				$data['city'] = $query->city;
				$data['state'] = $query->state;
				$data['country'] = $query->country;
				$data['delivery_charge'] = $query->delivery_charge;
				$data['iban'] = $query->iban;
				$data['bank_name'] = $query->bank_name;
				$data['stc_pay_no'] = $query->stc_pay_no;
				$data['dl_no'] = $query->dl_no;
				$data['dl_expiry'] = $query->dl_expiry;
				
				$data['o_iqama'] = $query->iqama;
				$data['van_no'] = $query->van_no;
				$data['van_color'] = $query->van_color;
				$data['van_model'] = $query->van_model;
				$data['o_dl_image'] = $query->dl_image;
				$data['status'] = $query->status;
				$data['created_at'] = $query->created_at;
			}
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['partner_id'] = "";
			$data['arabic_name'] = "";
			$data['mobile'] = "";
			$data['iqama_no'] = "";
			$data['iqama_exp'] = "";
			$data['address'] = "";
			$data['city'] = "";
			$data['state'] = "";
			$data['country'] = "";
			$data['delivery_charge'] = "";
			$data['iban'] = "";
			$data['bank_name'] = "";
			$data['stc_pay_no'] = "";
			$data['dl_no'] = "";
			$data['dl_expiry'] = "";
			$data['iqama'] = "";
			$data['dl_image'] = "";
			$data['status'] = "";
			$data['van_no'] = '';
			$data['van_color'] = '';
			$data['van_model'] = '';
		}
		$data['partners'] = $this->Delivery_model->get_partner_list();
		$data['master_cities'] = $this->Vendor_model->cities();
		$data['master_banks'] = $this->Vendor_model->master_banks();
		//print_r($data['partners']);exit();
		$this->load->view('admin/delivery/deliveryboy_form',$data);
	}

	public function add_delivery(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'Iqama Number', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($_FILES['iqama']['name']){
				$con['upload_path']   = './uploads/delivery/'; 
				$con['allowed_types'] = 'jpg|png|jpeg|pdf'; 
				$con['max_size']      = 0; 
				$con['max_width']     = 0; 
				$con['max_height']    = 0;  
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('iqama')) {
                   echo $this->upload->display_errors();
				   exit;
                } 
				else {
					$image_data = $this->upload->data();
					$iqama = "uploads/delivery/".$image_data['file_name'];
               }
			}
			else{
				$iqama = $this->input->post('o_iqama');
			}
			if($_FILES['dl_image']['name']){
				$con['upload_path']   = './uploads/delivery/'; 
				$con['allowed_types'] = 'jpg|png|jpeg|pdf'; 
				$con['max_size']      = 0; 
				$con['max_width']     = 0; 
				$con['max_height']    = 0;  
				$con['max_filename'] = '50';
				$con['encrypt_name'] = TRUE;
				$this->load->library('upload', $con);
				if (!$this->upload->do_upload('dl_image')) {
                   echo $this->upload->display_errors();
				   exit;
                } 
				else {
					$image_data = $this->upload->data();
					$dl_image = "uploads/delivery/".$image_data['file_name'];
               }
			}
			else{
				$dl_image = $this->input->post('o_dl_image');
			}
			
			if($this->input->post('id')){
				$query = $this->Delivery_model->edit($iqama,$dl_image);
			}
			else{
				$query = $this->Delivery_model->add($iqama,$dl_image);
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/delivery');
	}
	

	public function manage(){
		$query = $this->Delivery_model->manage();
		if($query){
			$this->session->set_userdata('info', "1--Successfully Updated");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/delivery');
	}
	
	public function change_password(){
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>'. $msg .'</div>';exit();
		}
		else{
			$query = $this->Delivery_model->change_password();
			if($query){
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Password Successfully Changed.</div>';exit();
			}
			else{
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';exit();
			}
		}
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Delivery_model->delete($id);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/delivery');
	}
	
	public function detail(){
		$id = $this->input->get('id');
		if($this->input->get("status")){
			$status = $this->input->get("status");
		}
		else{
			$status = "4";
		}
		if($this->input->get("dateFilter")){
			$taskFor = $this->input->get("dateFilter");
		}
		else{
			$taskFor = "1";
		}
		$data['result'] = $this->Delivery_model->get_deliverboy($id)->row();
		$data['orders'] = $this->Order_process_model->get_orders_by_dboy1($id);
		$data['total_credit'] = $this->Delivery_model->getCreditWallet($id);
		$data['total_debit'] = $this->Delivery_model->getDebitWallet($id);
		$data['total_trans'] = $this->Delivery_model->get_all_report($id);
		//print_r($data['total_trans']);exit();
		$this->load->view('admin/delivery/deliveryboydetail', $data);
	}
	
	public function earnings(){	
	    $id = $this->input->get('id');		
		$data['earnings'] = $this->Delivery_model->get_earnings($id);
		$this->load->view('admin/delivery/dbearnings',$data);
	}
	
	public function get_list(){
	   $fetch_data = $this->Delivery_model->get_list();		   
	//	$i = $_POST['start'] + 1 ;
	   $data = array();  
	   foreach($fetch_data as $user){
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$user->id.'" />';
					
			$sub_array[] = $user->name .'('. $user->arabic_name .')';
			$sub_array[] = $user->mobile;
			$sub_array[] = $user->iqama_no;
			$sub_array[] = $user->count_order;
			$sub_array[] = $user->delivery_charge;
			$sub_array[] = date("d M,Y h:i A");
			$sub_array[] = date("d M,Y h:i A", strtotime($user->created_at));
			$sub_array[] = $user->status == 1 ? '<div class="label label-success">Enabled</div>':'<div class="label label-danger">Blocked</div>';
			$sub_array[] = '<div class="dropdown"><button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button><ul class="dropdown-menu"><li><a title="Wallet Report" href="'.base_url().'admin/delivery/wallet_report?id='.$user->id.'">Wallet Report</a></li><li><a title="Detail" href="'.base_url().'admin/delivery/detail?id='.$user->id.'">Detail</a></li><li><a title="Edit" href="'.base_url().'admin/delivery/add?id='.$user->id.'">Edit</a></li></ul></div>';				 
			
			$data[] = $sub_array;
	   }
	   $output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Delivery_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Delivery_model->get_filtered_data(),  
			"data"                =>     $data  
	   );  
	   echo json_encode($output);
	}
	
	public function wallet_report(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$id = $this->input->get('id');
		$data['result'] = $this->Delivery_model->get_deliverboy($id)->row();
		$data['reports'] = $this->Delivery_model->get_wallet_report($id);
		$data['orders'] = $this->Order_process_model->get_orders_by_dboy1($id);
		$data['total_credit'] = $this->Delivery_model->getCreditWallet($id);
		$data['total_debit'] = $this->Delivery_model->getDebitWallet($id);
		$data['total_trans'] = $this->Delivery_model->get_all_report($id);
		$this->load->view('admin/delivery/wallet_report',$data);
	}
	
	public function update_wallet(){
		$this->form_validation->set_rules('dbid', 'Delivery Boy Id', 'trim|required');
		$this->form_validation->set_rules('wallet', 'Amount', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>'. $msg .'</div>';exit();
		}
		else{
    		if($this->input->post('dbid')){
    			$query = $this->Delivery_model->updateWallet();
    		}
    		else{
    			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';exit();
    		}
    		if($query){
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Wallet Amount Successfully Updated</div>';exit();
			}
			else{
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>Error occured, Try again</div>';exit();
			}
		}
	}
}
