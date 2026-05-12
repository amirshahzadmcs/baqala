<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inhouse_van extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if($this->admin->isLogged()){
			//$this->load->model('admin/Deliveryvehicle_model');
			$this->load->model('admin/Inhouse_van_model');
			$this->load->model('admin/Common_model');
			$this->load->helper('Common_helper');
			$this->load->library('form_validation');
			
			$this->load->library('Enc_lib');
			$this->load->library('Role');
		}
		else{
			redirect('admin');
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
		$this->load->view('admin/inhouse-vehicles/list',$data);
	}
	
    public function form(){
		if($this->input->get('id')){
			$query = $this->Inhouse_van_model->get_detail($this->input->get('id'))->row();
			$data['id'] = $query->id;
			$data['application_status'] = $query->application_status;
			$data['region_id'] = $query->region_id;
			$data['city'] = $query->city;
			$data['district'] = $query->district;
			$data['partner_id'] = $query->partner_id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['email'] = $query->email;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['iqama_exp'] = $query->iqama_exp;
			$data['dl_no'] = $query->dl_no;
			$data['dl_expiry'] = $query->dl_expiry;
			$data['service_area'] = $query->service_area;
			$data['van_no'] = $query->van_no;
			$data['van_color'] = $query->van_color;
			$data['van_model'] = $query->van_model;
			$data['van_make'] = $query->van_make;
			$data['vehicle_expiry'] = $query->vehicle_expiry;
			$data['vehicle_year'] = $query->vehicle_year;
			$data['profession'] = $query->profession;
			$data['status'] = $query->status;
			$data['created_at'] = $query->created_at;
			$data['block_reason'] = $query->block_reason;
			$data['nationality'] = $query->nationality;
			$data['doj'] = $query->doj;
			$data['profile_info_status'] = $query->profile_info_status;
			$data['vehicle_info_status'] = $query->vehicle_info_status;
			$data['bank_info_status'] = $query->bank_info_status;
			$data['doc_info_status'] = $query->doc_info_status;
		}else{
			$data['id'] = "";
			$data['application_status'] = "";
			$data['region_id'] = "";
			$data['city'] = "";
			$data['district'] = "";
			$data['partner_id'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['email'] = "";
			$data['mobile'] = "";
			$data['iqama_no'] = "";
			$data['iqama_exp'] = "";
			$data['dl_no'] = "";
			$data['dl_expiry'] = "";
			$data['service_area'] = "";
			$data['van_no'] = "";
			$data['van_color'] = "";
			$data['van_model'] = "";
			$data['van_make'] = "";
			$data['vehicle_expiry'] = "";
			$data['vehicle_year'] = "";
			$data['profession'] = "";
			$data['status'] = "";
			$data['created_at'] = "";
			$data['block_reason'] = "";
			$data['nationality'] = "";
			$data['doj'] = "";
			$data['profile_info_status'] = "";
			$data['vehicle_info_status'] = "";
			$data['bank_info_status'] = "";
			$data['doc_info_status'] = "";
		}
		$this->load->view('admin/inhouse-vehicles/form',$data);
	}

	public function save_info(){
		$this->form_validation->set_rules('region_id', 'Region', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('district', 'District', 'trim|required');
		$this->form_validation->set_rules('name', 'Driver Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
		$this->form_validation->set_rules('profession', 'Profession', 'trim|required');
		$this->form_validation->set_rules('service_area', 'service Area', 'trim|required');
		$this->form_validation->set_rules('doj', 'Date of Joining', 'trim|required');
		$this->form_validation->set_rules('iqama_no', 'Iqama Number', 'trim|required');
		$this->form_validation->set_rules('iqama_exp', 'Iqama Expiry', 'trim|required');
		$this->form_validation->set_rules('dl_no', 'Driving Licence Number', 'trim|required');
		$this->form_validation->set_rules('dl_expiry', 'Driving Licence Expiry', 'trim|required');
		$this->form_validation->set_rules('vehicle_expiry', 'Van Expiry Date', 'trim|required');
		$this->form_validation->set_rules('vehicle_year', 'Van Year', 'trim|required');
		$this->form_validation->set_rules('van_color', 'Van Color', 'trim|required');
		$this->form_validation->set_rules('van_make', 'Van Make', 'trim|required');
		$this->form_validation->set_rules('van_model', 'Van Type', 'trim|required');
		$this->form_validation->set_rules('status', 'Rider Status', 'trim|required');
		if($this->input->post('id')){
			$this->form_validation->set_rules('van_no', 'Van Number', 'trim|required');
		}else{
			$this->form_validation->set_rules('van_no', 'Van Number', 'trim|required|is_unique[delivery_vehicles.van_no]', array('is_unique' => 'This van number is already added, try another.'));
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->Inhouse_van_model->update();
				if($query){
					$this->session->set_userdata('info', "1--Van detail successfully updated");
				}
				else{
					$this->session->set_userdata('info', "2--Error!!!");
				}
				redirect('admin/in-house-vehicle/form?id='. $this->input->post('id'));
			}else{
				$hashpassword = $this->enc_lib->encrypt(uniqid());
				$query = $this->Inhouse_van_model->add($hashpassword);
			}
			if($query){
				$this->session->set_userdata('info', "1--Van detail successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/in-house-vehicle/list');
	}

	public function delete(){
		$id_array = $this->input->post('check_list');
		if(!empty($id_array)){
			$id = implode(',',$id_array);
			$query = $this->Inhouse_van_model->delete($id);
			if($query){
				$this->session->set_userdata('info', "1--Successfully deleted");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}else{
			$this->session->set_userdata('info', "2--Select atleast one item");
		}
		redirect('admin/in-house-vehicle/list');
	}

	public function detail(){
		$id = $this->input->get('id');
		if($id > 0){
			$query = $this->Inhouse_van_model->get_detail($this->input->get('id'))->row();
			$data['id'] = $query->id;
			$data['application_status'] = $query->application_status;
			$data['region_id'] = $query->region_id;
			$data['city'] = $query->city;
			$data['district'] = $query->district;
			$data['partner_id'] = $query->partner_id;
			$data['name'] = $query->name;
			$data['arabic_name'] = $query->arabic_name;
			$data['email'] = $query->email;
			$data['mobile'] = $query->mobile;
			$data['iqama_no'] = $query->iqama_no;
			$data['iqama_exp'] = $query->iqama_exp;
			$data['dl_no'] = $query->dl_no;
			$data['dl_expiry'] = $query->dl_expiry;
			$data['service_area'] = $query->service_area;
			$data['van_no'] = $query->van_no;
			$data['van_color'] = $query->van_color;
			$data['van_model'] = $query->van_model;
			$data['van_make'] = $query->van_make;
			$data['vehicle_expiry'] = $query->vehicle_expiry;
			$data['vehicle_year'] = $query->vehicle_year;
			$data['profession'] = $query->profession;
			$data['status'] = $query->status;
			$data['created_at'] = $query->created_at;
			$data['block_reason'] = $query->block_reason;
			$data['nationality'] = $query->nationality;
			$data['doj'] = $query->doj;
			$data['profile_info_status'] = $query->profile_info_status;
			$data['vehicle_info_status'] = $query->vehicle_info_status;
			$data['bank_info_status'] = $query->bank_info_status;
			$data['doc_info_status'] = $query->doc_info_status;
		}else{
			$this->session->set_userdata('info', "2--Invalid Rider!!!");
			redirect('admin/inhouse-vehicles/list');
		}
		$this->load->view('admin/inhouse-vehicles/detail',$data);
	}

	public function get_list(){
		$fetch_data = $this->Inhouse_van_model->get_list();		   
	 //	$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $user){
			$sub_array = array();
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$user->id.'" />';
			$sub_array[] = $user->driver_id;
			$sub_array[] = ($user->name !== '') ? $user->name . docAlertHelper($user->iqama_exp, 'Iqama') . docAlertHelper($user->dl_expiry, 'Driving Licence') .' <br>('. $user->arabic_name .')' : 'N/A';
			$sub_array[] = $user->van_no;
			$sub_array[] = $user->iqama_no;
			$sub_array[] = $user->dl_no;
			$sub_array[] = (!empty($user->last_login_at)) ? '<div style="width: 130px;">'. date("d-m-y h:i A", strtotime($user->last_login_at)) .'</div>' : 'N/A';
			$sub_array[] = '<div style="width: 130px;">'. date("d-m-y h:i A", strtotime($user->created_at)) .'</div>';
			$sub_array[] = ($user->status == '0') ? '<span class="badge badge-pill badge-soft-secondary font-size-13">Deactive</span>' : (($user->status == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : (($user->status == '2') ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-info font-size-13">NULL</span>'));
			$sub_array[] = ($user->application_status == 'verified') ? '<span class="badge badge-pill badge-soft-success font-size-13">Verified</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Unverified</span>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/in-house-vehicle/form?id='.$user->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>';			 
			
			$data[] = $sub_array;
		}
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Inhouse_van_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Inhouse_van_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
}
