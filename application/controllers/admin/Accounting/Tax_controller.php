<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tax_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Accounting/Tax_model', 'tax_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index()
	{
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['reports']);exit();
		$this->load->view('admin/accounting/tax_setting/index',$data);
	}

	
	public function add(){
		if($this->input->get('id')){
			$query = $this->tax_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['title_en'] = $query->title_en;
			$data['title_ar'] = $query->title_ar;
			$data['tax_percent'] = $query->tax_percent;
			$data['included'] = $query->included;
		}
		else{
			$data['id'] = "";
			$data['title_en'] = "";
			$data['title_ar'] = "";
			$data['tax_percent'] = "";
			$data['included'] = "";
		}
		// print_r($data['nationality_no']);exit();
		$this->load->view('admin/accounting/tax_setting/form',$data);
	}

	public function save(){
		$this->form_validation->set_rules('title_en', 'Tile', 'trim|required');
		$this->form_validation->set_rules('tax_percent', 'Tax Percent', 'trim|required');
		$this->form_validation->set_rules('included', 'Included', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->tax_model->edit();
    		}
    		else{
    			$query = $this->tax_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/tax-setting/list');
	}

	public function detail(){
		if($this->input->get('id')){
			$query = $this->tax_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['title_en'] = $query->title_en;
			$data['title_ar'] = $query->title_ar;
			$data['tax_percent'] = $query->tax_percent;
			$data['included'] = $query->included;
			$this->load->view('admin/accounting/tax_setting/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid request id!!");
			redirect('admin/tax-setting/list');
		}
	}

	public function get_list(){
		$fetch_data = $this->tax_model->get_list();
		// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $tax){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$tax->id.'" />';
			$sub_array[] = $tax->title_en;
			$sub_array[] = $tax->title_ar;
			$sub_array[] = $tax->tax_percent;
			$sub_array[] = $tax->included == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Inclusive</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Exclusive</span>';
			$sub_array[] = date('d-m-Y H:i A', strtotime($tax->created_at));
			$sub_array[] = isset($tax->updated_at) ? date('d-m-Y', strtotime($tax->updated_at)) : '';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/tax-setting/add?id='.$tax->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->tax_model->get_all_data(),  
			"recordsFiltered"     =>     $this->tax_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->tax_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/tax-setting/list');
	}

}
