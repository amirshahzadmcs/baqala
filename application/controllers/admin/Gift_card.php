<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift_card extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect("admin");
		}
		$this->load->model('admin/Gift_model');
		$this->load->library('form_validation');
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
		$data['list'] = $this->Gift_model->get_list();
		$data['total_gift'] = $this->Gift_model->total_gift();
		$data['active_gift'] = $this->Gift_model->active_gift();
		$data['disable_gift'] = $this->Gift_model->deactive_gift();
		$data['used_gift'] = $this->Gift_model->used_gift();
		$data['unused_gift'] = $this->Gift_model->unused_gift();
		$data['duplicate_gift'] = $this->Gift_model->duplicate_gift();
		
		//'<pre>';print_r($data);'</pre>';exit();
		$this->load->view('admin/gift_card/list', $data);
	}
	
	public function form(){
		$this->load->view('admin/gift_card/form');
	}
	
	public function add(){
		if($this->input->get('id')){
			$id = $this->input->get('id');
			$query = $this->Gift_model->get_charge($id)->row();
            $data['voucher_id'] = $query->voucher_id;
            $data['voucher_name'] = $query->voucher_name;
            $data['voucher_code'] = $query->voucher_code;
            $data['expiry_date'] = $query->expiry_date;
            $data['voucher_value'] = $query->voucher_value;
            $data['status'] = $query->status;
            $data['is_used'] = $query->is_used;
		}
		else{
			$data['voucher_id'] = "";
			$data['voucher_name'] = "";
			$data['voucher_code'] = "";
			$data['expiry_date'] = "";
			$data['voucher_value'] = "";
			$data['status'] = "";
			$data['is_used'] = "";
		}
		$this->load->view('admin/gift_card/add',$data);
	}
	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Gift_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('admin/gift_card');
	}
	
	public function edit(){
		$this->form_validation->set_rules('voucher_name', 'Voucher Group Name', 'trim|required');
		$this->form_validation->set_rules('voucher_code', 'Voucher Code', 'trim|required');
		$this->form_validation->set_rules('voucher_value', 'Voucher Value', 'trim|required');
		$this->form_validation->set_rules('expiry_date', 'Voucher Expiry Date', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Gift_model->edit();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/voucher');
	}
	
	public function set_status(){
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('_from', 'Frrom', 'trim|required');
			$this->form_validation->set_rules('_to', 'To', 'trim|required');
			$this->form_validation->set_rules('status', 'Voucher Status', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$this->session->set_userdata('info', "2--".validation_errors());
			}
			if($this->input->post('status') == 1){
				$query = $this->Gift_model->setStatusEnable();
			}else{
				$query = $this->Gift_model->setStatusDisable();
			}
			if($query){
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/gift_card');
		}
		else{
			redirect('admin');
		}
	}
	
	public function deactivate_vouchers(){
		if($this->admin->isLogged()){
		    $query = $this->Gift_model->setStatusDisable();
			if($query){
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/gift_card');
		}
		else{
			redirect('admin');
		}
	}

}
