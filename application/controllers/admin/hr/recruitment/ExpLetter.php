<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ExpLetter extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/hr/master/Employee_model');
			$this->load->model('admin/hr/recruitment/Exp_letter_model');
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
		$this->load->view('admin/hr/recruitment/exp_letter/index',$data);
	}

	
	public function add(){
		if($this->input->get('id')){
			$query = $this->Exp_letter_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['emp_no'] = $query->emp_no;
			$data['ref_no'] = $query->ref_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['ref_date'] = $query->ref_date;
			$data['position'] = $query->position;
			$data['joining_date'] = $query->joining_date;
			$data['location'] = $query->location;
			$data['last_date'] = $query->last_date;
			$data['organization'] = $query->organization;
			$data['total_exp'] = $query->total_exp;
		}
		else{
			$data['id'] = "";
			$data['emp_no'] = "";
			$data['ref_no'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['ref_date'] = "";
			$data['position'] = "";
			$data['joining_date'] = "";
			$data['location'] = "";
			$data['last_date'] = "";
			$data['organization'] = "";
			$data['total_exp'] = "";
		}
		
		$data['employees'] = $this->Employee_model->get_data();

		$this->load->view('admin/hr/recruitment/exp_letter/form',$data);
	}

	public function save(){
		// print_r($this->input->post());die();
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if(empty($this->input->post('id'))){
			//$this->form_validation->set_rules('password', 'Password', 'trim|required');
			//$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Exp_letter_model->edit();
    		}
    		else{
    			$query = $this->Exp_letter_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/exp-letter');
	}

	public function detail(){
		if($this->input->get('id')){
			$query = $this->Exp_letter_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['emp_no'] = $query->emp_no;
			$data['ref_no'] = $query->ref_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['ref_date'] = $query->ref_date;
			$data['position'] = $query->position;
			$data['joining_date'] = $query->joining_date;
			$data['location'] = $query->location;
			$data['fname'] = $query->fname;
			$data['network'] = $query->network;
			$data['sim_no'] = $query->sim_no;

			$data['employees'] = $this->Employee_model->get_data();
			$data['networks'] = $this->Network_model->get_list()->result();
			// print_r($data['networks']);die();
			$data['sims'] = $this->Sim_model->get_list();
			$this->load->view('admin/hr/recruitment/exp_letter/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/exp-letter');
		}
	}

	public function get_list(){
		$fetch_data = $this->Exp_letter_model->get_list();
// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->ref_no;
			$sub_array[] = $store->emp_num;
			$sub_array[] = $store->name;
			$sub_array[] = $store->mobile;
			$sub_array[] = date('d-m-Y', strtotime($store->joining_date));
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/exp-letter/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';
// 			<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/exp-letter/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Exp_letter_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Exp_letter_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Exp_letter_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/exp-letter');
	}

	public function get_emp_detail()
	{
		$id = $this->input->get('id');
		$data = $this->Exp_letter_model->get_emp_detail($id);
		// $data['age'] = age_calculate($data['loi']->dob);
		$final = array(
			'name' => $data->name,
			'mobile' => $data->mobile_emp_saudi,
			'position' => $data->position,
			'joining_date' => $data->joining_date,
			'location' => $data->address_1 .' '. $data->address_2,
		);

		echo json_encode($final);
	}

}
