<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Coupon_model');	 
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}else{				
			redirect("admin");	
		}
	}
	
	public function index(){
		$data['results'] = $this->Coupon_model->get_coupons();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/coupon/list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->Coupon_model->get_coupon_detail($this->input->get('id'))->row();
			$data['id'] = $query->id;
			$data['name'] = $query->name;
			$data['max_price'] = $query->max_price;
			$data['min_price'] = $query->min_price;
			$data['discount_type'] = $query->type;
			$data['discount'] = $query->discount;
			$data['coupon_code'] = $query->code;
			$data['total_coupons'] = $query->total_coupons;
			$data['date_start'] = $query->date_start;
			$data['date_end'] = $query->date_end;
			$data['max_discount'] = $query->max_discount;
			$data['status'] = $query->status;
			$data['description'] = $query->description;
			$data['description2'] = $query->description2;
		}
		else{
			$data['id'] = "";
			$data['name'] = "";
			$data['max_price'] = "";
			$data['min_price'] = "";
			$data['discount_type'] = "";
			$data['discount'] = "";
			$data['coupon_code'] = "";
			$data['total_coupons'] = "";
			$data['date_start'] = "";
			$data['date_end'] = "";
			$data['max_discount'] = "";
			$data['status'] = "";
			$data['description'] = "";
			$data['description2'] = "";
		}
		$this->load->view('admin/coupon/form',$data);
	}

	public function add_coupon(){
		$this->form_validation->set_rules('name', 'Coupon Name', 'trim|required');
		$this->form_validation->set_rules('min_price', 'Min Price', 'trim|required');
		$this->form_validation->set_rules('discount_type', 'Discount Type', 'trim|required');
		$this->form_validation->set_rules('discount', 'Discount', 'trim|required');
		$this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');
		$this->form_validation->set_rules('date_start', 'Coupon Start Date', 'trim|required');
		$this->form_validation->set_rules('date_end', 'Coupon End Date', 'trim|required');
		$this->form_validation->set_rules('total_coupons', 'Total No. of Coupons', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Coupon_model->edit();
			}
			else{
				$query = $this->Coupon_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/coupon/list');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Coupon_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/coupon/list');
	}
	
}