<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionTypes extends CI_Controller {

	public function __construct() {
		parent::__construct(); 
		if($this->admin->isLogged()){ 
			$this->load->model('admin/masters/TransactionTypes_model', 'transaction_type'); 
			$this->load->library('form_validation'); 
			$action=$this->router->fetch_method();
			if($action && !check_action_permission(get_user_role(),'transaction_types',$action) && !in_array($action, ['save','get_list'])):
				redirect('admin/unauthorized-request');
			endif;
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
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		return $this->load->view('admin/masters/transaction-types/list',$data);
	}

	public function get_list(){
		$fetch_data = $this->transaction_type->get_list(); 
		// $i = $_POST['start'] + 1 ;
		$data = array(); 
		foreach($fetch_data as $brand){ 
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="'. $brand->id .'" name="check_list[]" />';
			$sub_array[] = $brand->id;
			$sub_array[] = $brand->transaction_name;
			$sub_array[] = $brand->transaction_name_ar;
			$sub_array[] = $brand->created_at;
			$sub_array[] = $brand->updated_at;
			$sub_array[] = check_action_permission(get_user_role(),'transaction_types','add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/master/transaction-type/add?id='.$brand->id.'"><i class="mdi mdi-pencil font-size-18"></i></a>' : '';
			$data[] = $sub_array; 
		}
		$output = array( 
			"draw" => intval($_POST["draw"]), 
			"recordsTotal" => $this->transaction_type->get_all_data(), 
			"recordsFiltered" => $this->transaction_type->get_filtered_data(), 
			"data" => $data 
		); 
		echo json_encode($output);
	}

	public function add(){
		if($this->input->get('id')){
			$query = $this->transaction_type->detail($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['transaction_name'] = $query->transaction_name;
				$data['transaction_name_ar'] = $query->transaction_name_ar;
			}
		}
		else{
			$data['id'] = "";
			$data['transaction_name'] = "";
			$data['transaction_name_ar'] = "";
		}
		return $this->load->view('admin/masters/transaction-types/form',$data);
	}

	public function save(){
		if($this->input->post('id')){
			$this->form_validation->set_rules('transaction_name', 'Transaction Type', 'trim|required');
		}else{
			$this->form_validation->set_rules('transaction_name', 'Transaction Type', 'trim|required|is_unique[master_transaction_types.transaction_name]', array('is_unique' => 'Duplicate Name.'));
		}
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->transaction_type->edit();
			}
			else{
				$query = $this->transaction_type->add();
			}
			if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/master/transaction-type');
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->transaction_type->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/master/transaction-type');
	}
}
