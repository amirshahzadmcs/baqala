<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Van extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Van_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin/common/login');
		}
	}
		
	public function index(){
		$data['result'] = $this->Van_model->get_category();
			
		if($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
			
		}else {
			$data['info'] = '';
			$data['info_type'] = '';
			
		}
		$this->load->view('admin/van/van_list',$data);
	}
	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Van_model->get_category_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
			
				$data['van_no'] = $query->van_no;
				$data['dname'] = $query->dname;
				$data['arabic_name'] = $query->arabic_name;
				$data['driver_mo_no'] = $query->driver_mo_no;
				$data['password'] = $query->password;
				$data['validity'] = $query->validity;
				$data['city'] = $query->city;
				$data['country'] = $query->country;
				$data['parent_id'] = $query->parent_id;
				$data['region'] = $query->region;
				$data['charge'] = $query->charge;
				$data['dcity'] = $query->dcity;	
				$data['area'] = $query->area;
				$data['iqama_no'] = $query->iqama_no;
				$data['iqama_expiry'] = $query->iqama_expiry;
				$data['car_ins_expiry'] = $query->car_ins_expiry;
				$data['stc_pay_no'] = $query->stc_pay_no;
				$data['o_car'] = $query->car;
				$data['o_img'] = $query->image;
				$data['o_icon'] = $query->icon;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['parent_id'] = "";
			$data['van_no'] = "";
			$data['dname'] = "";
			$data['arabic_name'] = "";
			$data['driver_mo_no'] = "";
			$data['password'] = "";
			$data['validity'] = "";
			$data['city'] = "";
			$data['region'] = "";
			$data['country'] = "";
			$data['charge'] = "";
			$data['dcity'] = "";
			$data['area'] = "";
			$data['iqama_no'] = "";
			$data['iqama_expiry'] = "";
			$data['car_ins_expiry'] = "";
			$data['stc_pay_no'] = "";
			$data['o_car'] = "";
			$data['o_img'] = "";
			$data['o_icon'] ="";
		    $data['status'] = "";
		}
// 		$data['parent'] = $this->Delivery_Partner_model->get_category();
		$data['submits'] = $this->Van_model->get_partner_list();
		$this->load->view('admin/van/van_form',$data);
	}
	
	public function add_van(){
		$this->form_validation->set_rules('dname', 'Name', 'trim|required');
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
			
			if($_FILES['car']['name']){
                $con['upload_path']   = './uploads/'; 
                $con['allowed_types'] = 'gif|jpg|png|jpeg|pdf'; 
                $con['max_size']      = 0; 
                $con['max_width']     = 0; 
                $con['max_height']    = 0;  
                $con['max_filename'] = '50';
                $con['encrypt_name'] = TRUE;
                $this->load->library('upload', $con);
				if (!$this->upload->do_upload('car')) {
                   echo $this->upload->display_errors();
				   exit;
                } else {
                $image_data2 = $this->upload->data();
			    $car = "uploads/".$image_data2['file_name'];
               }
		    }
			else{
				$car = $this->input->post('o_car');
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
				//echo $image;exit();
    			$query = $this->Van_model->edit($image, $icon, $car);
    		}
    		else{
    			$query = $this->Van_model->add($image, $icon, $car);
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
			
		}
		redirect('admin/Van');
	}
	
	public function setStatusEnable(){
		if($this->admin->isLogged()){
			$ids = $this->input->post('checklist');
		    $query = $this->Van_model->setStatusEnable($ids);
			if($query){
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/Van');
		}
		else{
			redirect('admin');
		}
	}
	
	public function setStatusDisable(){
		if($this->admin->isLogged()){
			$ids = $this->input->post('checklist');
			//$ids = implode(",", $this->input->post('check_list'));
		    $query = $this->Van_model->setStatusDisable($ids);
    		if($query){
    			$this->session->set_userdata('info', "1--Status Successfully Updated");
    		}
    		else{
    			$this->session->set_userdata('info', "2--Error");
    		}
    		redirect('admin/Van');
    	}else{
			redirect('admin');
		}
	}
	
	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Van_model->delete($ids);
		if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		redirect('admin/Van');
	}
	
	public function get_report(){	
		$id = $this->input->get("id");
		$data['m_details'] = $this->Van_model->get_consig_id($id);
		$data['results'] = $this->Van_model->get_order_by_ids($data['m_details']->order_ids);
		//print_r($data['results']);exit();
		$this->load->view('admin/van/report_detail',$data);
	}
	
	public function get_consignment(){	
		$id = $this->input->get("id");
		$data['results'] = $this->Van_model->get_consignment_by_dboy($id);
		$this->load->view('admin/van/van_report',$data);
	}
	
}
