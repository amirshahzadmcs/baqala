<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->admin->isLogged()){		
			$this->load->model('admin/Modules_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('admin/login');			
		}
	}

	public function index(){
		$data['category_list'] = $this->Modules_model->get_modules();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/modules/list',$data);
	}
	
	public function quick_edit()
    {
		$this->form_validation->set_rules('module_id', 'Module ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>'. $msg .'</strong></div>';exit();
		}
		else{
			$data['result'] = $this->Modules_model->get_detail($this->input->post('module_id'))->row();
			$data['category_list'] = $this->Modules_model->get_modules();
			$output_data = $this->load->view('admin/modules/edit-form',$data,TRUE);
			 echo json_encode(['status'=>true,'html'=>$output_data,'data'=>$data['result']]);
		}
    }

	public function add(){
		$this->form_validation->set_rules('name', 'Module Name', 'trim|required');
		$this->form_validation->set_rules('perm_group_id', 'Select Group', 'trim|required');
		$this->form_validation->set_rules('short_code', 'Module Code', 'trim|required|callback_valid_check_exists');
    	$this->form_validation->set_message('valid_check_exists','Record already exists, Try new');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Modules_model->edit();
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated");
				}
				else{
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
			else{
				$query = $this->Modules_model->add();
				if($query){
					$this->session->set_userdata('info', "1--Successfully added");
				}
				else{
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/modules/list');
	}

	public function valid_check_exists($str) {
        $name = $this->input->post('short_code');
        $id = $this->input->post('id');

        if (!isset($id)) {
            $id = 0;
        }
        if ($this->Modules_model->check_data_exists($name, $id)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function delete(){
		$id = implode(',',$this->input->post('checklist'));
		$query = $this->Modules_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/modules/list');
	}
}
