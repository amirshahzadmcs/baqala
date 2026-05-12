<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_allot extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){
			$this->load->model('admin/Sim_allot_model');
			$this->load->model('admin/Sim_model');
			$this->load->model('admin/Deliveryvehicle_model');
			$this->load->model('admin/Common_model');
			$this->load->library('form_validation');
			$this->load->helper('text');
			$this->load->helper('common_helper');
		}			
		else{				
			redirect('admin/common/login');
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
		$this->load->view('admin/sim-allot/list',$data);
	}
	
	public function add_sim(){
		if($this->input->get('id')){
			$query = $this->Sim_allot_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['allotment_date'] = $query->allotment_date;
			$data['sim_no'] = $query->sim_no;
			$data['user_no'] = $query->user_no;
			$data['user_type'] = $query->user_type;
			$data['status'] = $query->status;
			$data['position'] = $query->position;
			$data['table_name'] = $query->table_name;
			$data['riders'] = $this->Deliveryvehicle_model->getRiders();
			$data['sim'] = $this->Sim_model->get_sims();
		}
		else{
			$data['id'] = "";
			$data['allotment_date'] = "";
			$data['sim_no'] = "";
			$data['user_no'] = "";
			$data['user_type'] = "";
			$data['status'] = "";
			$data['position'] = "";
			$data['table_name'] = "";
			$data['riders'] = $this->Deliveryvehicle_model->getUnallotedRiders();
			$data['sim'] = $this->Sim_model->getUnallotedSims();
		}
		// print_r($data['sim_no']);exit();
		$this->load->view('admin/sim-allot/form',$data);
	}

	public function save_sim(){
		$this->form_validation->set_rules('sim_no', 'Sim Number', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Sim_allot_model->edit();
    			if ($query) {
					//print_r($query);exit();
					$log_query = $this->Sim_allot_model->simLogs();
				}
    		}
    		else{
    			$query = $this->Sim_allot_model->add();
    			if ($query) {
					$log_query = $this->Sim_allot_model->simLogs();
				}
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/allot-sim/list');
	}

	public function sim_detail(){
		if($this->input->get('id')){
			$query = $this->Sim_allot_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['allotment_date'] = $query->allotment_date;
			$data['sim_no'] = $query->sim_no;
			$data['user_no'] = $query->user_no;
			$data['user_type'] = $query->user_type;
			$data['status'] = $query->status;
			$data['position'] = $query->position;
			$data['table_name'] = $query->table_name;
			
			$data['riders'] = $this->Deliveryvehicle_model->getRiders();
			$data['sim'] = $this->Sim_model->get_sims();
			$this->load->view('admin/sim-allot/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/allot-sim/list');
		}
	}

	public function get_list(){
		if(!empty($this->input->get('status'))){
			$status = $this->input->get('status');
		}
		else{
			$status = FALSE;
		}
		if(!empty($this->input->get('sim_type'))){
			$sim_type = $this->input->get('sim_type');
		}
		else{
			$sim_type = FALSE;
		}
		if(!empty($this->input->get('user_type'))){
			$user_type = $this->input->get('user_type');
		}
		else{
			$user_type = FALSE;
		}
		if(!empty($this->input->get('sim_network'))){
			$sim_network = $this->input->get('sim_network');
		}
		else{
			$sim_network = FALSE;
		}
		$fetch_data = $this->Sim_allot_model->get_list($status,$sim_type,$user_type,$sim_network);		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $store){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$store->id.'" />';
			$sub_array[] = date('d-m-Y', strtotime($store->allotment_date));
			$sub_array[] = $store->sim_no;
			$sub_array[] = $store->sim_type;
			$sub_array[] = $store->network_name;
 			$sub_array[] = $store->username;
			$sub_array[] = $store->user_type == 1 ? '<span class="font-size-13">Rider</span>':'<span class="font-size-13">Van Driver</span>';
			$sub_array[] = $store->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>': ($store->status == 2 ? '<span class="badge badge-pill badge-soft-warning font-size-13">Return</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>');
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" href="'.base_url().'admin/allot-sim/add?id='.$store->id.'"><i class="mdi mdi-pencil font-size-18"></i></a> <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" href="'.base_url().'admin/allot-sim/detail?id='.$store->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Sim_allot_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Sim_allot_model->get_filtered_data($status,$sim_type,$user_type,$sim_network),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}

	public function getPlans()
	{
		$query = $this->Sim_allot_model->get_plan($this->input->get('id'));
		// $p_data = $query;
		// print_r($this->input->get('plan_id'));exit();
		$data ='';
		foreach($query as $plan){
			if ($plan->id == $this->input->get('plan_id')) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$data .= '<option value="' . $plan->id . '" ' . $selected . '>' . $plan->plan_name . '</option>';
		}
		echo $data;
	}

	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Sim_allot_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/allot-sim/list');
	}
	
	public function getuser()
	{
		$id = $this->input->get('id');
		$user_id = $this->input->get('user_no');
		$data = '';
		if ($id === '1') {
			if($user_id != '') {
				$query = $this->db->query("SELECT dv.name,dv.id,dv.service_type FROM delivery_vehicles dv WHERE dv.status = '1' AND application_status = 'verified'")->result();
			} else {
				$query = $this->db->query("SELECT dv.name,dv.id,dv.service_type FROM delivery_vehicles dv WHERE dv.status = '1' AND dv.id NOT IN (SELECT sim.user_no from sim_allot as sim WHERE sim.status='1') AND application_status = 'verified'")->result();
			}
			$data .= '<option value="">-- select --</option>';
			foreach($query as $user){
				if ($user->id == $user_id) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$pos = ($user->service_type == "bike") ? "Rider" : "Driver";
				$data .= '<option data-position="' . $pos . '" value="' . $user->id . '" ' . $selected . '>' . $user->name . ' - ' . $pos .'</option>';
			}
		} else {
			$query = $this->db->query("SELECT id, name, position FROM master_employee WHERE 1=1")->result();
			$data = '<option value="">-- select --</option>';
			foreach($query as $user){
				if ($user->id == $user_id) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$pos = $user->position;
				$data .= '<option data-position="' . $pos . '" value="' . $user->id . '" ' . $selected . '>' . $user->name . ' - ' . $pos .'</option>';
			}
		}
		echo json_encode($data);
	}
	public function getalluser()
	{
		$id = $this->input->get('id');
		$user_id = $this->input->get('user_no');
		$data = '';
		if ($id === '1') {
			$query = $this->db->query("SELECT dv.name,dv.id,dv.service_type FROM delivery_vehicles dv WHERE dv.status = '1' AND application_status = 'verified'")->result();
			
			$data .= '<option value="">-- select --</option>';
			foreach($query as $user){
				if ($user->id == $user_id) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$pos = ($user->service_type == "bike") ? "Rider" : "Driver";
				$data .= '<option data-position="' . $pos . '" value="' . $user->id . '" ' . $selected . '>' . $user->name . ' - ' . $pos .'</option>';
			}
		} else {
			$query = $this->db->query("SELECT id, name, position FROM master_employee WHERE 1=1")->result();
			$data = '<option value="">-- select --</option>';
			foreach($query as $user){
				if ($user->id == $user_id) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$pos = $user->position;
				$data .= '<option data-position="' . $pos . '" value="' . $user->id . '" ' . $selected . '>' . $user->name . ' - ' . $pos .'</option>';
			}
		}
		echo json_encode($data);
	}
}
