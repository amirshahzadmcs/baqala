<?php defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

	public function __construct(){
        parent::__construct();				
		if($this->admin->isLogged()){
			$this->load->model('admin/masters/City_model');
			$this->load->model('admin/masters/Country_model');
			$this->load->library('form_validation');
			$action = $this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'cities',$action) && !in_array($action, ['save','get_list'])):
				redirect('admin/common/permission');
			endif;
		}else{
			redirect('admin/common/login');
		}
	}

	public function index(){
		$data['cities'] = $this->City_model->get_cities()->result();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/masters/city/city_list',$data);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->City_model->get_city_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['city_name'] = $query->city_name;
				$data['arabic_name'] = $query->arabic_name;
				$data['country_id'] = $query->country_id;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['country_id'] = "";
			$data['city_name'] = "";
			$data['arabic_name'] = "";
			$data['status'] = "";
		}
		$data['countries'] = $this->Country_model->country_list()->result();
		return $this->load->view('admin/masters/city/city_form',$data);
	}

	public function save(){
		$this->form_validation->set_rules('city_name', 'City Name', 'trim|required');
		$this->form_validation->set_rules('country_id', 'Country', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->City_model->edit();
			}
			else{
				$query = $this->City_model->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/city');
	}

	
	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->City_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/city');
	}

}
