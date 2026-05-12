<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stockrequest extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->store->isLogged()){		
			$this->load->model('store/Stockreq_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('store/login');			
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
		$this->load->view('stores/stock_request/list',$data);
	}
	
	public function request_form(){
		$data['warehouse_info'] = $this->db->query("SELECT * FROM `warehouse` WHERE status = '1'")->result();
		$this->load->view('stores/stock_request/form',$data);
	}
	
	public function edit_form(){
		if($this->input->get('id')){
			$data = $this->Purchase_model->get_order_detail($this->input->get('id'));
			$this->load->view('stores/stock_request/edit-form',$data);
		}else{
			$this->load->view('stores/stock_request/list');
		}
	}
	
	public function request_list(){
		$fetch_data = $this->Stockreq_model->get_list();		   
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $request){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $request->request_id;
			$sub_array[] = $request->store_name;
			$sub_array[] = $request->target_store_name;
			$sub_array[] = date("d-m-Y h:i A", strtotime($request->created_at));
			$sub_array[] = date("d-m-Y", strtotime($request->expected_date));
			$sub_array[] = '<span class="badge badge-pill badge-soft-'.$request->status_type.' font-size-13">'.$request->status_name.'</span>';
			$sub_array[] = $request->total_sku;
			$sub_array[] = $request->total_qty;
			$sub_array[] = $request->reason;
			$sub_array[] = $request->store_name;
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Detail" href="'.base_url().'store/stockrequest/request_detail?id='.$request->id.'"><i class="mdi mdi-eye-outline font-size-18"></i></a>';	
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>     $this->Stockreq_model->get_all_data(),  
			"recordsFiltered"     =>     $this->Stockreq_model->get_filtered_data(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function request_detail(){
		$id = $this->input->get('id');
		$data = $this->Stockreq_model->get_request_detail($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('stores/stock_request/detail',$data);
	}
	
	public function save_request(){
		$this->form_validation->set_rules('target_store_id', 'Select Target Store', 'trim|required');
		$this->form_validation->set_rules('expected_date', 'Expected Delivery Date', 'trim|required');
		$this->form_validation->set_rules('size_id[]', 'Size', 'trim|required');
		$this->form_validation->set_rules('item_parentsku[]', 'Parent SKU', 'trim|required');
		$this->form_validation->set_rules('item_sku[]', 'Item SKU', 'trim|required');
		$this->form_validation->set_rules('item_unit[]', 'Item Unit', 'trim|required');
		$this->form_validation->set_rules('item_size[]', 'Item Size', 'trim|required');
		$this->form_validation->set_rules('item_description[]', 'Items Description', 'trim|required');
		if($this->form_validation->run()==FALSE){
			 $this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		if($this->input->post('id')){
    			$query = $this->Stockreq_model->edit();
    		}
    		else{
    			$query = $this->Stockreq_model->add();
    		}
    		if($query){
				$this->session->set_userdata('info', "1--Successfully done");
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		
		}
		redirect('store/warehouse/stock-request');
	}
	
	public function delete(){
		$ids = $this->input->post('checklist');
		$query = $this->Stockreq_model->delete($ids);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('store/warehouse/stock-request');
	}
	
	
	/*------ Search product -----*/
	public function get_search_list(){
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->Stockreq_model->get_search_list($data['term']);
		echo json_encode($data);
	}
}
