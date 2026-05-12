<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends CI_Controller {

	public function __construct() {

		parent::__construct();									
		if($this->admin->isLogged()){	
		   
			$this->load->model('admin/Delivery_Partner_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		$data['result'] = $this->Delivery_Partner_model->get_category();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/delivery_partner/delivery_partner_list',$data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Delivery_Partner_model->get_category_by_id($this->input->get('id'));
			$data['id'] = $query->id;
		
			$data['cname'] = $query->cname;
			$data['arabic_name'] = $query->arabic_name;
			$data['cr_no'] = $query->cr_no;
			$data['vat_no'] = $query->vat_no;
			$data['contact_p'] = $query->contact_p;
			$data['mobile'] = $query->mobile;
			$data['bank_name'] = $query->bank_name;
			$data['iban_no'] = $query->iban_no;
			$data['o_img'] = $query->image;
			$data['o_icon'] = $query->icon;
		    $data['status'] = $query->status;
		}
		else{
			$data['id'] = "";
			$data['cname'] = "";
			$data['cr_no'] = "";
			$data['arabic_name'] = "";
			$data['vat_no'] = "";
			$data['contact_p'] = "";
			$data['mobile'] = "";
			$data['bank_name'] = "";
			$data['iban_no'] = "";
			$data['o_img'] = "";
			$data['o_icon'] = "";
		    $data['status'] = "";
		}
// 		$data['parent'] = $this->Delivery_Partner_model->get_category();
		$this->load->view('admin/delivery_partner/delivery_partner_form',$data);
	}
	
	public function add_category(){
		$this->form_validation->set_rules('cname', 'Name', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($_FILES['image']['name']){
                $con['upload_path']   = './uploads/'; 
                $con['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
                $con['max_size']      = 0; 
                $con['max_width']     = 0; 
                $con['max_height']    = 0;  
                $con['max_filename'] = '50';
                $con['encrypt_name'] = TRUE;
                $this->load->library('upload', $con);
				if (!$this->upload->do_upload('image')) {
                   echo $this->upload->display_errors();
				   exit;
                } else {
                    $image_data = $this->upload->data();
			        $image = "uploads/".$image_data['file_name'];
               }
		    }
			else{
				$image = $this->input->post('o_img');
			}
			
			if($_FILES['icon']['name']){
                $con['upload_path']   = './uploads/'; 
                $con['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
                $con['max_size']      = 0; 
                $con['max_width']     = 0; 
                $con['max_height']    = 0;  
                $con['max_filename'] = '50';
                $con['encrypt_name'] = TRUE;
                $this->load->library('upload', $con);
				if (!$this->upload->do_upload('icon')) {
                   echo $this->upload->display_errors();
				   exit;
                } else {
                $image_data1 = $this->upload->data();
			    $icon = "uploads/".$image_data1['file_name'];
               }
		    }
			else{
				$icon = $this->input->post('o_icon');
			}
    		if($this->input->post('id')){
    			$query = $this->Delivery_Partner_model->edit($image, $icon);
    		}
    		else{
    			$query = $this->Delivery_Partner_model->add($image, $icon);
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		
		}
			redirect('admin/Partner');
	}
	
	public function get_van_report(){	
		$id = $this->input->get("id");
		$data['partner_details'] = $this->Delivery_Partner_model->get_category_by_id($id);
		$data['results'] = $this->Delivery_Partner_model->get_van_pid($id);
		//print_r($data['results']);exit();
		$this->load->view('admin/delivery_partner/delivery_van_list',$data);
	}
	
	public function setStatusEnable(){
		if($this->admin->isLogged()){
			$ids = $this->input->post('checklist');
		    $query = $this->Delivery_Partner_model->setStatusEnable($ids);
			if($query){
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/Partner');
		}
		else{
			redirect('admin');
		}
	}
	
	public function setStatusDisable(){
		if($this->admin->isLogged()){
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
		    $query = $this->Delivery_Partner_model->setStatusDisable($ids);
    		if($query){
    			$this->session->set_userdata('info', "1--Status Successfully Updated");
    		}
    		else{
    			$this->session->set_userdata('info', "2--Error");
    		}
    		redirect('admin/Partner');
    	}else{
			redirect('admin');
		}
	}
	
	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Delivery_Partner_model->delete($ids);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/Partner');
	}
	
}
