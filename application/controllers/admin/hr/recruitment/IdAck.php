<?php defined('BASEPATH') OR exit('No direct script access allowed');

class IdAck extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Cv_model');
			$this->load->model('admin/hr/recruitment/Id_ack_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
		}
	}

	public function index_id_ack()
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
		$this->load->view('admin/hr/recruitment/id_ack/index',$data);
	}

	
	public function add_id_ack(){
		if($this->input->get('id')){
			$query = $this->Id_ack_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['ack_no'] = $query->ack_no;
			$data['cv_no'] = $query->cv_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['open_date'] = $query->open_date;
			$data['position'] = $query->position;
			$data['id_no'] = $query->id_no;
			$data['card_type'] = $query->card_type;
		}
		else{
			$data['id'] = "";
			$data['ack_no'] = "";
			$data['cv_no'] = "";
			$data['name'] = "";
			$data['mobile'] = "";
			$data['open_date'] = "";
			$data['position'] = "";
			$data['id_no'] = "";
			$data['card_type'] = "";
		}
		
		$data['cvs'] = $this->Cv_model->get_data();
		$data['ack_id'] = $this->db->query("SELECT id FROM id_ack ORDER BY id desc limit 1")->row();
		// print_r($data['id_ack_no']);exit();
		$this->load->view('admin/hr/recruitment/id_ack/form',$data);
	}

	public function save_id_ack(){
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
    			$query = $this->Id_ack_model->edit();
    		}
    		else{
    			$query = $this->Id_ack_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/hr/recruitment/id_ack');
	}

	public function id_ack_detail(){
		if($this->input->get('id')){
			$query = $this->Id_ack_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['ack_no'] = $query->ack_no;
			$data['cv_no'] = $query->cv_no;
			$data['name'] = $query->name;
			$data['mobile'] = $query->mobile;
			$data['open_date'] = $query->open_date;
			$data['position'] = $query->position;
			$data['id_no'] = $query->id_no;
			$data['card_type'] = $query->card_type;
			
			$data['cvs'] = $this->Cv_model->get_data();
			$data['ack_id'] = $this->db->query("SELECT id FROM id_ack ORDER BY id desc limit 1")->row();
			$this->load->view('admin/hr/recruitment/id_ack/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/hr/recruitment/id_ack');
		}
	}

	public function get_id_ack_list(){
		$fetch_data = $this->Id_ack_model->get_list();
// print_r($fetch_data);die();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = $store->ack_no;
			$sub_array[] = $store->name;
			$sub_array[] = $store->mobile;
			$sub_array[] = $store->cv_num;
			$sub_array[] = $store->card_type;
			$sub_array[] = date('d-m-Y', strtotime($store->created_at));
			// $sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/hr/recruitment/id_ack/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/hr/recruitment/id_ack/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Id_ack_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Id_ack_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function delete_id_ack(){
		$ids = $this->input->post('checklist');
		$query = $this->Id_ack_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/hr/recruitment/id_ack');
	}

	public function get_cv_detail()
	{
		$id = $this->input->get('id');
		$data = $this->Cv_model->get_detail($id);
		// $data['age'] = age_calculate($data['loi']->dob);
		$final = array(
			'name' => $data->name,
			'mobile' => $data->mobile,
			'position' => $data->pos_name,
		);

		echo json_encode($final);
	}

}
