<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sim_card extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		if($this->admin->isLogged()){
			$this->load->model('admin/Sim_model');
			$this->load->model('admin/Sim_allot_model');
			$this->load->model('admin/Plan_model');
			$this->load->model('admin/Network_model');
			$this->load->model('admin/Common_model');
			$this->load->model('admin/masters/Sponsor_model');
			$this->load->library('form_validation');
			$this->load->helper('text');
			$this->load->library('Enc_lib');
			$this->load->library('Role');
			$this->load->helper('common_helper');
			$this->action = $this->router->fetch_method();
		} 
		else{ 
			redirect('admin/common/login');
		}
	}

	public function index(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['networks'] = $this->Network_model->get_list()->result();
		$data['plans'] = $this->Plan_model->get_list()->result();
		//print_r($data['employee_list']);exit();
		$this->load->view('admin/sim/list',$data);
	}

	public function add_sim(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$data['unalloted_vehicle'] = $this->Sim_model->get_unalloted_vehicle();
		$data['networks'] = $this->Network_model->networks();
		$data['plan'] = $this->Plan_model->plans();
		$data['sponsors'] = $this->Sponsor_model->get_all_sponsors(); 
		$this->load->view('admin/sim/form',$data);
	}

	public function edit_sim(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if($this->input->get('id')){
			$query = $this->Sim_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['date_of_purchase'] = $query->date_of_purchase;
			$data['activation_date'] = $query->activation_date;
			$data['network'] = $query->network;
			$data['plan_id'] = $query->plan;
			$data['internet_data'] = $query->internet_data;
			$data['sim_no'] = $query->sim_no;
			$data['mobile'] = $query->mobile;
			$data['ownership_type'] = $query->ownership_type;
			$data['owner_name'] = $query->owner_name;
			$data['owner_id'] = $query->owner_id;
			$data['status'] = $query->status;
			$data['sim_type'] = $query->sim_type;
			$data['is_gps_sim'] = $query->is_gps_sim;
			$data['gps_installed_vehicle'] = $query->gps_installed_vehicle;
			$data['allotment'] = $query->allotment;
			$data['alloted_user'] = $query->alloted_user;
			$data['date_of_discontinued'] = $query->date_of_discontinued;
			$data['discontinue_reason'] = $query->discontinue_reason;
				$data['logs'] = $this->Sim_model->getLogs($query->id);
			if($query->gps_installed_vehicle !== ''){
				$data['unalloted_vehicle'] = $this->Sim_model->get_unalloted_vehicle2($query->gps_installed_vehicle);
			}else{
				$data['unalloted_vehicle'] = $this->Sim_model->get_unalloted_vehicle();
			}
			$data['networks'] = $this->Network_model->networks();
			$data['plan'] = $this->Plan_model->plans();
			$data['sponsors'] = $this->Sponsor_model->get_all_sponsors(); 
			return $this->load->view('admin/sim/edit',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/sim/list');
		}
	}

	public function save_sim(){
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|callback_check_mobile_duplicate');
		$this->form_validation->set_message('check_mobile_duplicate','Mobile Number already registered, Try new');
		$this->form_validation->set_rules('sim_no', 'Sim Number', 'trim|required|callback_check_sim_duplicate');
		$this->form_validation->set_message('check_sim_duplicate','Sim Number already registered, Try new');
		$this->form_validation->set_rules('ownership_type', 'Ownership Type', 'trim|required');
		if($this->input->post('ownership_type') == 'corporate'){
			$this->form_validation->set_rules('owner_name_dropdown', 'Owner name', 'trim|required');
		}else{
			$this->form_validation->set_rules('owner_name_text', 'Owner name', 'trim|required');
		}
		$this->form_validation->set_rules('date_of_purchase', 'Date of Purchase', 'trim|required');
		$this->form_validation->set_rules('network', 'Network', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$query = $this->Sim_model->add();
			if($query){
			$this->session->set_userdata('info', "1--Successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/sim/list');
	}

	public function update_sim(){
		$this->form_validation->set_rules('id', 'Sim Id', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|callback_check_mobile_duplicate');
		$this->form_validation->set_message('check_mobile_duplicate','Mobile Number already registered, Try new');
		$this->form_validation->set_rules('sim_no', 'Sim Number', 'trim|required|callback_check_sim_duplicate');
		$this->form_validation->set_message('check_sim_duplicate','Sim Number already registered, Try new');
		$this->form_validation->set_rules('ownership_type', 'Ownership Type', 'trim|required');
		if($this->input->post('ownership_type') == 'corporate'){
			$this->form_validation->set_rules('owner_name_dropdown', 'Select Owner Name', 'trim|required');
		}else{
			$this->form_validation->set_rules('owner_name_text', 'Owner name', 'trim|required');
		}
		$this->form_validation->set_rules('date_of_purchase', 'Date of Purchase', 'trim|required');
		$this->form_validation->set_rules('network', 'Network', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$query = $this->Sim_model->edit();
			if($query){
			$this->session->set_userdata('info', "1--Successfully updated");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/sim/list');
	}

	public function update_status_form()
	{
		if($this->action && !check_action_permission(get_user_role(),'sim_card', 'update_status')){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			$result = array("type"=>'error', "message"=>$msg);
		}
		else{
			$query = $this->db->query("SELECT * FROM sim_card WHERE id = '". $this->input->post('id') ."'");
			if($query->num_rows() > 0){
				$sim_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['type'] = $this->input->post('type');
				$data['sim_detail'] = $this->Sim_model->get_sim_detail($sim_info->id);
				$output_data = $this->load->view('admin/sim/components/update-status',$data,TRUE);
				$result = array("type"=>'success', "message"=>'Sim detail successfully fetched.', "output_html"=> $output_data);
			}else{
				$result = array("type"=>'error', "message"=>'Unauthorized access');
			}
		}
		echo json_encode($result);
	}

	public function update_status()
	{
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('status', 'Sim Status', 'required');
		$this->form_validation->set_rules('id', 'Sim ID', 'required');

		// Additional validation for fields based on status
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		if ($status == '2') { // Discontinued status
			$this->form_validation->set_rules('date_of_discontinued', 'Discontinue Date', 'required');
			$this->form_validation->set_rules('discontinue_reason', 'Discontinue Reason', 'required');
		}

		if ($this->form_validation->run() == FALSE) {
			$result = array("type"=>'error', "message"=>validation_errors());
			echo json_encode($result);exit();
		} else {
			$sim_detail = $this->Sim_model->get_sim_status($id);
			$current_status = $sim_detail->status;
			$current_allotment = $sim_detail->allotment;
				// Check if the new status is the same as the current status
				if ($current_status == $status) {
				$result = array("type"=>'error', "message"=>'No changes were made. The status is already set to the selected value.');
				echo json_encode($result);exit();
			} else {
				// Fetch the current allotment value
				$sim_card = $this->Sim_model->get_detail($id);

				// Check if status is being set to "Discontinued" and allotment is not 0
				if ($status == '2' && $current_status == '2') {
					$result = array("type"=>'error', "message"=>'Cannot discontinue SIM as it is already discontinued.');
					echo json_encode($result);exit();
				}

				if ($status == '2' && $current_allotment == '1') {
					$result = array("type"=>'error', "message"=>'Cannot discontinue SIM if it is alloted to someone. Unallot first!');
					echo json_encode($result);exit();
				}

				$data = array(
					'status' => $this->input->post('status'),
					'updated_at' => date('Y-m-d H:i:s')
				);

				// If status is 2 (Discontinued), keep the date and reason; otherwise, clear them
				if ($status == '2') {
					$data['date_of_discontinued'] = $this->input->post('date_of_discontinued');
					$data['discontinue_reason'] = $this->input->post('discontinue_reason');
				} else {
					$data['date_of_discontinued'] = '';
					$data['discontinue_reason'] = '';
				}
				$alloted_user = $sim_card->alloted_user;
				$updated = $this->Sim_model->update_sim_status($id, $alloted_user, $data);

				if ($updated) {
					$result = array("type"=>'success', "message"=>'Sim status updated successfully.');
					echo json_encode($result);exit();
				} else {
					$result = array("type"=>'error', "message"=>'Failed to update sim status.');
					echo json_encode($result);exit();
				}
			}
		}
	}

	public function check_mobile_duplicate() {
		$id = $this->input->post('id');
		$mobile = $this->input->post('mobile');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Sim_model->check_duplicate_mobile($id, $mobile);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function ajax_check_mobile() {
		$mobile = $this->input->get('mobile');
		$id = $this->input->get('id');
		if($mobile !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Sim_model->check_duplicate_mobile($id, $mobile);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $mobile . "</b> This Mobile No. already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Checked, Ok.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Mobile No. is required.</span>";
		}
		echo json_encode($data);
	}

	public function ajax_check_simno() {
		$sim_no = $this->input->get('sim_no');
		$id = $this->input->get('id');
		if($sim_no !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Sim_model->check_duplicate_simno($id, $sim_no);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $sim_no . "</b> This Sim No. already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Checked, Ok.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Sim No. is required.</span>";
		}
		echo json_encode($data);
	}

	public function check_sim_duplicate() {
		$id = $this->input->post('id');
		$sim_no = $this->input->post('sim_no');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->Sim_model->check_duplicate_simno($id, $sim_no);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function sim_detail(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if($this->input->get('id')){
			$query = $this->Sim_model->get_detail($this->input->get('id'));
			$data['id'] = $query->id;
			$data['date_of_purchase'] = $query->date_of_purchase;
			$data['network'] = $query->network;
			$data['plan_id'] = $query->plan;
			$data['internet_data'] = $query->internet_data;
			$data['sim_no'] = $query->sim_no;
			$data['mobile'] = $query->mobile;
			$data['ownership_type'] = $query->ownership_type;
			$data['owner_name'] = $query->owner_name;
			$data['owner_id'] = $query->owner_id;
			$data['status'] = $query->status;
			$data['sim_type'] = $query->sim_type;
			$data['is_gps_sim'] = $query->is_gps_sim;
			$data['gps_installed_vehicle'] = $query->gps_installed_vehicle;
			$data['allotment'] = $query->allotment;
			$data['date_of_discontinued'] = $query->date_of_discontinued;
			$data['discontinue_reason'] = $query->discontinue_reason;

			$data['networks'] = $this->Network_model->networks();
			$data['plan'] = $this->Plan_model->plans();
			$data['logs'] = $this->Sim_model->getLogs($query->id);
			$data['replacement_logs'] = $this->Sim_model->get_log_history($query->id);
			$data['unalloted_vehicle'] = $this->Sim_model->get_unalloted_vehicle2($query->gps_installed_vehicle);
			$this->load->view('admin/sim/detail',$data);
		}else{
			$this->session->set_userdata('info', "2--Invalid Sim Card!!!");
			redirect('admin/sim/list');
		}
	}

	public function get_list(){
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('user'))){
			$user = $this->input->get('user');
		}
		else{
			$user = FALSE;
		}
		if(!empty($this->input->get('plan'))){
			$plan = $this->input->get('plan');
		}
		else{
			$plan = FALSE;
		}
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if(!empty($this->input->get('sim_type'))){
			$sim_type = $this->input->get('sim_type');
		}
		else{
			$sim_type = FALSE;
		}
		if(!empty($this->input->get('status'))){
			$status = $this->input->get('status');
		}
		else{
			$status = FALSE;
		}
		if(!empty($this->input->get('allot_status'))){
			$allot_status = $this->input->get('allot_status');
		}
		else{
			$allot_status = FALSE;
		}
		if(!empty($this->input->get('is_gps_sim'))){
			$is_gps_sim = $this->input->get('is_gps_sim');
		}
		else{
			$is_gps_sim = FALSE;
		}
		if(!empty($this->input->get('from'))){
			$startDate = $this->input->get('from');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('to'))){
			$endDate = $this->input->get('to');
		}
		else{
			$endDate = FALSE;
		}
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		$fetch_data = $this->Sim_model->get_list($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no); 
		$i = $_POST['start'] + 1 ;
		$data = array(); 
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="checklist[]" id="checkbox" class="checkbox" value="'.$item->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			$sub_array[] = ucfirst($item->ownership_type);
			$sub_array[] = $item->owner_id;
			$sub_array[] = $item->owner_name;
			$sub_array[] = $item->mobile;
			$sub_array[] = $item->sim_no;
			$sub_array[] = date('d-m-Y', strtotime($item->date_of_purchase));
			$sub_array[] = ucfirst($item->sim_type);
			$sub_array[] = (($item->is_gps_sim == 'on') ? '<span class="badge badge-pill badge-soft-success font-size-13">Yes</span><br>' : '<span class="badge badge-pill badge-soft-dark font-size-13">No</span>') .'<br>'. (($item->is_gps_sim == 'on' && isset($item->gps_installed_vehicle)) ? vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_no .' '. vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_type : '');
			$sub_array[] = $item->network_name;
			$sub_array[] = $item->plan_name;
			$sub_array[] = $item->emp_no;
			$sub_array[] = $item->emp_full_name;
			if($item->status == '0'){
				$status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
			}
			if($item->status == '1'){
				$status = '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>';
			}
			if($item->status == '2'){
				$status = '<span class="badge badge-pill badge-soft-warning font-size-13">Discontinued</span>';
			}
			if($item->status == '3'){
				$status = '<span class="badge badge-pill badge-soft-danger font-size-13">Port</span>';
			}
			$sub_array[] = $status;

			if($item->allotment == '0'){
				$allotment_status = '<span class="badge badge-pill badge-soft-primary font-size-13">New</span>';
			}
			if($item->allotment == '1'){
				$allotment_status = '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>';
			}
			if($item->allotment == '2'){
				$allotment_status = '<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';
			}
			$sub_array[] = $allotment_status;
			if(($item->allotment == '0' || $item->allotment == '2') && ($item->status == '0' || $item->status == '1')){
				$allot_button = check_action_permission(get_user_role(),'sim_card', 'updateAllotment') ? '<a href="javascript:;" class="dropdown-item" title="Allot" data-id="'. $item->id .'" data-type="allotment" onclick="allotmentPopup(this)"><i class="mdi mdi-hand-heart-outline font-size-18"></i> Allot SIM</a><div class="dropdown-divider"></div>' : '';
			}elseif($item->allotment == '1'){
				$allot_button = (check_action_permission(get_user_role(),'sim_card', 'updateAllotment') ? '<a href="javascript:;" class="dropdown-item" title="Unallotment" data-id="'. $item->id .'" data-type="unallotment" onclick="allotmentPopup(this)"><i class="mdi mdi-undo-variant font-size-18"></i> Unallot SIM</a><div class="dropdown-divider"></div>' : '').(check_action_permission(get_user_role(),'sim_card', 'print_handover_form') ? '<a href="'.base_url('admin/sim/print-handover-form?id='.$item->id).'" class="dropdown-item" title="Print Handover Form" target="_blank"><i class="mdi mdi-printer font-size-18"></i> Print Handover Form</a><div class="dropdown-divider"></div>' : '');
			}else{
				$allot_button = '';
			}
			if($item->status !== '3'){
				$edit_button = (check_action_permission(get_user_role(),'sim_card', 'edit_sim') ? '<a class="dropdown-item" title="Edit" href="'.base_url().'admin/sim/edit?id='.$item->id.'"><i class="mdi mdi-pencil font-size-18"></i> Edit</a><div class="dropdown-divider"></div>' : '').(check_action_permission(get_user_role(),'sim_card', 'replaceSim') ? '<a href="javascript:;" class="dropdown-item" title="Replace Sim" title="Replace" data-id="'. $item->id .'" data-type="replace" onclick="replacePopup(this)"><i class="mdi mdi-ballot-recount-outline font-size-18"></i> Replace Sim</a><div class="dropdown-divider"></div>' : '').(check_action_permission(get_user_role(),'sim_card', 'update_status') ? '<a href="javascript:;" class="dropdown-item" title="Change Status" data-id="'. $item->id .'" data-type="change_status" onclick="changeStatusPopup(this)"><i class="mdi mdi-account-reactivate font-size-18"></i> Change Status</a><div class="dropdown-divider"></div>' : '');
			}else{
				$edit_button = '';
			}
			$dropdown_actions = '<div class="btn-group ms-2 float-end">
                        <button class="btn btn-light-grey btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="dripicons-dots-3"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">'
							. $edit_button
							. $allot_button
							. (check_action_permission(get_user_role(),'sim_card','sim_detail') ? ' <a class="dropdown-item" title="Detail" href="'.base_url().'admin/sim/detail?id='.$item->id.'"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i> Detail</a> ' : '')
                        . '</div>
                    </div>';
			$sub_array[] = $dropdown_actions;

			$data[] = $sub_array;
		} 
		$output = array( 
			"draw" => intval($_POST["draw"]), 
			"recordsTotal" => $this->Sim_model->get_all_data(), 
			"recordsFiltered" => $this->Sim_model->get_filtered_data($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no), 
			"data" => $data 
		); 
		echo json_encode($output);
	}

	public function getPlans()
	{
		$id = $this->input->get('id');
		$sim_type = $this->input->get('sim_type');
		if($id > 0 && $sim_type !== ''){
			$query = $this->Sim_model->get_plan($id,$sim_type);
			// $p_data = $query;
			// print_r($this->input->get('plan_id'));exit();
			$data ='';
			$data .= '<option value="">---- Select Plan ---</option>';
			foreach($query as $plan){
				if ($plan->id == $this->input->get('plan_id')) {
					$selected = "selected";
				} else {
					$selected = "";
				}
				$data .= '<option value="' . $plan->id . '" ' . $selected . '>' . $plan->plan_name . '</option>';
			}
		}else{
			$data = '<option value="">---- Select Valid Network ---</option>';
		}
		echo $data;
	}

	public function updateAllotment()
	{
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';exit();
		}
		else{
			$query = $this->db->query("SELECT * FROM sim_card WHERE id = '". $this->input->post('id') ."'");
			if($query->num_rows() > 0){
				$sim_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['type'] = $this->input->post('type');
				$data['sim_detail'] = $sim_info;
				$data['employee_list'] = $this->Sim_model->get_unalloted_employees();
				if($data['type'] == 'allotment'){
					if($sim_info->status == '0'){
						echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>This sim card is not active, please activate first.</strong></div>';exit();
					}else{
						$output_data = $this->load->view('admin/partials/sim-allotment',$data,TRUE);
					}
				}elseif($data['type'] == 'unallotment'){
					$output_data = $this->load->view('admin/partials/sim-allotment',$data,TRUE);
				}
				echo $output_data;
			}else{
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Unauthorized access</strong></div>';exit();
			}
		}
	}

	public function simAllotment()
	{
		$this->form_validation->set_rules('sim_id', 'Sim ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Request Type', 'trim|required');
		$this->form_validation->set_rules('allot_status', 'Status', 'trim|required');
		$this->form_validation->set_rules('status_date', 'Date', 'trim|required');
		$this->form_validation->set_rules('alloted_user', 'Employee', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
			redirect('admin/sim/list');
		}

		$sim_id       = $this->input->post('sim_id');
		$type         = $this->input->post('type');
		$employee_id  = $this->input->post('alloted_user');

		// 🚫 Block if employee already has an active SIM
		if ($type == 'allotment') {
			$hasSim = $this->Sim_model->employeeHasActiveSim($employee_id, $sim_id);

			if ($hasSim) {
				$this->session->set_userdata(
					'info',
					"2--This employee already has an active SIM card. One employee can have only one SIM."
				);
				redirect('admin/sim/list');
			}
		}

		// Proceed with update
		$query = $this->Sim_model->update_allotment_status();

		if ($query) {
			$this->session->set_userdata('info', "1--Successfully updated.");
		} else {
			$this->session->set_userdata('info', "2--Something went wrong, try again!");
		}

		redirect('admin/sim/list');
	}

	public function delete(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$ids = $this->input->post('checklist');
		$query = $this->Sim_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/sim/list');
	}

	public function print_sim_list(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
			$this->load->library('Pdf_mobile_consolidate_report');
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('user'))){
			$user = $this->input->get('user');
		}
		else{
			$user = FALSE;
		}
		if(!empty($this->input->get('plan'))){
			$plan = $this->input->get('plan');
		}
		else{
			$plan = FALSE;
		}
		if(!empty($this->input->get('sim_no'))){
			$sim_no = $this->input->get('sim_no');
		}
		else{
			$sim_no = FALSE;
		}
		if(!empty($this->input->get('sim_type'))){
			$sim_type = $this->input->get('sim_type');
		}
		else{
			$sim_type = FALSE;
		}
		if(!empty($this->input->get('status'))){
			$status = $this->input->get('status');
		}
		else{
			$status = FALSE;
		}
		if(!empty($this->input->get('allot_status'))){
			$allot_status = $this->input->get('allot_status');
		}
		else{
			$allot_status = FALSE;
		}
		if(!empty($this->input->get('is_gps_sim'))){
			$is_gps_sim = $this->input->get('is_gps_sim');
		}
		else{
			$is_gps_sim = FALSE;
		}
		if(!empty($this->input->get('from'))){
			$startDate = $this->input->get('from');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('to'))){
			$endDate = $this->input->get('to');
		}
		else{
			$endDate = FALSE;
		}
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		$data['invoice'] = $this->Sim_model->print_list($network,$plan,$status,$sim_type,$allot_status,$is_gps_sim,$startDate,$endDate,$keyword,$user,$sim_no);
		//print_r($data['invoice']);exit();
		$data['start'] = $startDate;
		$data['end'] = $endDate;
		$data['user'] = $user;
		$data['admin'] = 'Amanullah Kazi';
		// create new PDF document
		ini_set('memory_limit', '-1');
		$pdf = new Pdf_mobile_consolidate_report(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Baqala Station');
		$pdf->SetTitle('Baqala Station - Sim Card List');
		$pdf->SetSubject('Baqala Station - Sim Card List');
		$pdf->SetKeywords('Baqala Station, PDF, Sim Card List');

		// print_r($data);exit();
		// remove default header/footer
		$pdf->setPrintHeader(true);
		$pdf->SetPrintFooter(true); 
		$htmlHeader = $this->load->view('admin/sim/print_header',$data, true);
		$htmlHeader2 = $this->load->view('admin/sim/print_header',$data, true);
		$pdf->setHtmlHeader($htmlHeader);
		$pdf->setHtmlHeader2($htmlHeader2);

		$lastFooter = $this->load->view('admin/sim/print_footer',$data, true);
		$pdf->setHtmlFooter($lastFooter);

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetMargins(1, 60, 4, true);

		// set auto page breaks
		//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------
		// add a page
		$pdf->AddPage('L', 'A4');
		// Arabic and English content
		// set LTR direction for english translation
		$pdf->setRTL(false);

		// print newline
		$pdf->Ln();
		// set font
		$pdf->SetFont('aealarabiya', '', 10);

		// Arabic and English content
		$htmlcontent = $this->load->view('admin/sim/print_sim_list',$data, true);
		$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
		//Close and output PDF document
		$date = date('d-m-y-'.substr((string)microtime(), 1, 8));
		$date = str_replace(".", "", $date);
		$filename = "export_sim_list_".$date.".pdf";
		$pdf->Output($filename, 'I');
	}

	public function print_handover_form(){
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$id = $this->input->get('id');
		if($id > 0){
			$this->load->library('Pdf_employee_offer');
			$data['sim_detail'] = $this->Sim_model->get_print_detail($id);
			// create new PDF document
			ini_set('memory_limit', '-1');
			$pdf = new Pdf_employee_offer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Baqala Station');
			$pdf->SetTitle('Baqala Station - SIM Card Handover Form');
			$pdf->SetSubject('Baqala Station - SIM Card Handover Form');
			$pdf->SetKeywords('Baqala Station, PDF, SIM Card Handover Form');

			// remove default header/footer
			$pdf->setPrintHeader(false);
			$pdf->SetPrintFooter(false);
			$htmlHeader = '';
			$htmlHeader2 = '';
			$pdf->setHtmlHeader($htmlHeader);
			$pdf->setHtmlHeader2($htmlHeader2);

			$lastFooter = '';
			$pdf->setHtmlFooter($lastFooter);

			// set default header data
			//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

			// set header and footer fonts
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			$pdf->SetMargins(6, 5, 8, true);
			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, 2);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			// ---------------------------------------------------------
			// add a page
			$pdf->AddPage('P', 'A4');
			// Arabic and English content
			// set LTR direction for english translation
			$pdf->setRTL(false);

			// print newline
			$pdf->Ln();
			// set font
			$pdf->SetFont('aealarabiya', '', 10);

			// Arabic and English content
			$htmlcontent = $this->load->view('admin/sim/print_handover_letter',$data, true);
			$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
			//Close and output PDF document
			$filename = "sim_card_handover_form_".$id.".pdf";
			$pdf->Output($filename, 'I');
		}else{
			$this->session->set_userdata('info', "2--Invalid request id!");
			redirect('admin/sim/list');
		}
	}

	/*------- Port Sim -------*/

	public function port_index(){
		if($this->action && !check_action_permission(get_user_role(),'port_inn_sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['networks'] = $this->Network_model->get_list()->result();
		$data['plans'] = $this->Plan_model->get_list()->result();
		$data['sim_list'] = $this->Sim_model->get_running_sims();
		$this->load->view('admin/sim/port-list',$data);
	}

	public function get_port_list(){
		if(!empty($this->input->get('network'))){
			$network = $this->input->get('network');
		}
		else{
			$network = FALSE;
		}
		if(!empty($this->input->get('from'))){
			$startDate = $this->input->get('from');
		}
		else{
			$startDate = FALSE;
		}
		if(!empty($this->input->get('to'))){
			$endDate = $this->input->get('to');
		}
		else{
			$endDate = FALSE;
		}
		if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		$fetch_data = $this->Sim_model->get_port_list($network,$startDate,$endDate,$keyword); 
		$i = $_POST['start'] + 1 ;
		$data = array(); 
		foreach($fetch_data as $item){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = date('d-m-Y', strtotime($item->port_date));
			$sub_array[] = $item->new_provider_name;
			$sub_array[] = $item->mobile_no;
			$sub_array[] = $item->old_provider_name;
			$sub_array[] = $item->plan_name;
			$sub_array[] = date('d-m-Y', strtotime($item->created_at));
			//$sub_array[] = (isset($item->updated_at)) ? date('d-m-Y', strtotime($item->updated_at)) : 'NA';
			$data[] = $sub_array;
		} 
		$output = array( 
			"draw" => intval($_POST["draw"]), 
			"recordsTotal" => $this->Sim_model->get_all_port_data(), 
			"recordsFiltered" => $this->Sim_model->get_filtered_port_data($network,$startDate,$endDate,$keyword), 
			"data" => $data 
		); 
		echo json_encode($output);
	}

	public function port_sim(){
		$data['sim_list'] = $this->Sim_model->get_running_sims();
		$data['networks'] = $this->Network_model->networks();
		$this->load->view('admin/sim/port-form',$data);
	}

	public function porting_sim_detail() {
		$this->form_validation->set_rules('id', 'Sim ID', 'trim|required');

		if($this->form_validation->run()==FALSE){
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Select valid sim card.</span>";
		}
		else{
			$id = $this->input->post('id');
			$sim_detail = $this->Sim_model->get_sim_detail($id);
			if(!empty($sim_detail)) {
				$data['status'] = 'success';
				$data['sim_detail'] = $sim_detail;
				$data['msg'] = "<span style='color:green;'>Sim detail successfully fetched.</span>";
			}else{
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'>Sim detail not available.</span>";
			}
		}
		echo json_encode($data);
	}

	public function save_port_detail(){
		if($this->action && !check_action_permission(get_user_role(),'port_inn_sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'Sim ID', 'trim|required');
		$this->form_validation->set_rules('network', 'Network', 'trim|required');
		$this->form_validation->set_rules('sim_type', 'Sim Type', 'trim|required');
		$this->form_validation->set_rules('sim_no', 'Sim Number', 'trim|required|callback_check_sim_duplicate');
		$this->form_validation->set_message('check_sim_duplicate','Sim Number already registered, Try new');
		$this->form_validation->set_rules('plan', 'Plan', 'trim|required');
		$this->form_validation->set_rules('port_date', 'Sim Port Date', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			//print_r($this->input->post());exit();
			$id = $this->input->post('id');
			$sim_detail = $this->Sim_model->get_sim_detail($id);
			if($sim_detail->allotment == '2'){
				$data = array(
					'sim_type' => $this->db->escape_str($this->input->post('sim_type')), 
					'is_gps_sim' => $this->db->escape_str($sim_detail->is_gps_sim), 
					'gps_installed_vehicle' => $this->db->escape_str($sim_detail->gps_installed_vehicle), 
					'date_of_purchase' => $this->db->escape_str($sim_detail->date_of_purchase), 
					'network' => $this->db->escape_str($this->input->post('network')), 
					'plan' => $this->db->escape_str($this->input->post('plan')), 
					'sim_no' => $this->db->escape_str($this->input->post('sim_no')), 
					'mobile' => $this->db->escape_str($sim_detail->mobile), 
					'ownership_type' => $this->db->escape_str($sim_detail->ownership_type), 
					'owner_name' => $this->db->escape_str($sim_detail->owner_name), 
					'owner_id' => $this->db->escape_str($sim_detail->owner_id), 
					'status' => '0'
				);
				if($sim_detail->network == $data['network'] && $sim_detail->sim_type == $data['sim_type']){
					$this->session->set_userdata('info', "2--Old sim service provider can't same as new provider!");
					return redirect('admin/sim/port-list');
				}else{
					$this->db->trans_begin();
					$this->db->insert('sim_card',$data);
					$new_sim_id = $this->db->insert_id();
					$this->db->query("UPDATE sim_card SET status = '3', updated_at = now() WHERE id = '" . (int)$id . "'");
					$this->db->query("INSERT INTO sim_logs SET status_date = now(), sim_id = '" . $this->db->escape_str($id) . "', user_id = '0', status = '3', created_at = NOW(), updated_at = now()");
					$this->db->query("INSERT INTO sim_port_history SET port_date = '" . $this->input->post('port_date') . "', old_sim_id = '" . $this->db->escape_str($id) . "', new_sim_id = '" . $this->db->escape_str($new_sim_id) . "', mobile_no = '" . $this->db->escape_str($sim_detail->mobile) . "', old_service_provider = '" . $this->db->escape_str($sim_detail->network) . "', new_service_provider = '" . $this->db->escape_str($data['network']) . "', new_plan = '" . $this->db->escape_str($data['plan']) . "', created_at = NOW(), updated_at = now()");
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$this->session->set_userdata('info', "2--Something went wrong!");
					}
					else
					{
						$this->db->trans_commit();
						$this->session->set_userdata('info', "1--Port successfully done.");
					}
				}
			}else{
				$this->session->set_userdata('info', "2--Please unallot sim first!");
			}
		}
		redirect('admin/sim/port-list');
	}

	public function replaceSim()
	{
		if($this->action && !check_action_permission(get_user_role(),'sim_card', $this->action)){
			redirect('admin/unauthorized-request');
		}
		$this->form_validation->set_rules('id', 'ID', 'trim|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			$result = array("type"=>'error', "message"=>$msg);
		}
		else{
			$query = $this->db->query("SELECT * FROM sim_card WHERE id = '". $this->input->post('id') ."'");
			if($query->num_rows() > 0){
				$sim_info = $query->row();
				$data['id'] = $this->input->post('id');
				$data['type'] = $this->input->post('type');
				$data['sim_detail'] = $this->Sim_model->get_sim_detail($sim_info->id);
				$output_data = $this->load->view('admin/sim/components/sim-replace',$data,TRUE);
				$result = array("type"=>'success', "message"=>'Sim detail successfully fetched.', "output_html"=> $output_data);
			}else{
				$result = array("type"=>'error', "message"=>'Unauthorized access');
			}
		}
		echo json_encode($result);
	}

	public function replace_save() {
		$this->form_validation->set_rules('sim_no', 'New Sim No.', 'required|min_length['.SIM_LENGTH.']|max_length['.SIM_LENGTH.']|is_unique[sim_card.sim_no]');
		$this->form_validation->set_rules('replacement_date', 'Replacement Date', 'required');
		$this->form_validation->set_rules('reason', 'Reason', 'required');
		$this->form_validation->set_rules('id', 'Sim ID', 'required');

		if ($this->form_validation->run() == FALSE) {
		$result = array("type"=>'error', "message"=>validation_errors());
		//$this->session->set_userdata('info', "2--".validation_errors());
			} else {
				$sim_id = $this->input->post('id');
				$new_sim_no = $this->input->post('sim_no');
				$replacement_date = $this->input->post('replacement_date');
				$reason = $this->input->post('reason');
				$message = $this->input->post('message');
		// Fetch old SIM number
			$old_sim_no = $this->db->select('sim_no')->where('id', $sim_id)->get('sim_card')->row()->sim_no;

			$update_data = array(
				'sim_no' => $new_sim_no,
			'updated_at' => date('Y-m-d H:i:s')
				);

				$log_data = array(
					'sim_id' => $sim_id,
					'old_sim_no' => $old_sim_no,
					'new_sim_no' => $new_sim_no,
					'replacement_date' => $replacement_date,
					'reason' => $reason,
					'message' => $message,
					'created_at' => date('Y-m-d H:i:s')
				);
		$query = $this->Sim_model->update_replace_sim($sim_id, $update_data);
			if ($query){
				$this->Sim_model->log_replacement($log_data);
			$result = array("type"=>'success', "message"=>'SIM card replaced successfully.');
			//$this->session->set_userdata('info', "1--SIM card replaced successfully.");
				} else {
			$result = array("type"=>'error', "message"=>'Failed to replace SIM card. Please try again.');
			//$this->session->set_userdata('info', "2--Failed to replace SIM card. Please try again.");
				}
				}
		echo json_encode($result);
		//redirect('admin/sim/list');
			}
}
