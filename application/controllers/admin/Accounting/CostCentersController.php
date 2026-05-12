<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CostCentersController extends CI_Controller {




	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){		
			$this->load->model('admin/Accounting/Costcenter');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin');
		}
	}
		
	public function index(){
		$data['chart_list'] = $this->Costcenter->main_accounts();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/accounting/costcenter/main_page',$data);
	}
	
	public function add_account_form()
    {
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('parent_id', 'Select Folder', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				$data = array("type"=>'error', "message"=>'Unauthorized request');
			}
			else{
				$result['parent_id'] = $this->input->post('parent_id');
				$result['centers'] = $this->db->query("SELECT * FROM cost_center WHERE is_parent='1'")->result_array();
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/costcenter/components/add-account',$result,TRUE));
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
    }
	
	public function ajax_check_code() {
		$folderid = $this->input->get('id');
		$code = $this->input->get('code');
		$account_type = $this->input->get('account_type');
		if($code !== '' && $account_type !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->Costcenter->check_duplicate_code($folderid, $code, $account_type);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<p style='display: block;' class='alert alert-danger'><b>". $code . "</b> This code already used. Try New.</p>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<p style='display: block;' class='alert alert-danger'>Account Type and Code field is required.</p>";
		}
		echo json_encode($data);
	}

	public function edit_account_form()
    {
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('id', 'Select Folder', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				$data = array("type"=>'error', "message"=>'Unauthorized request');
			}
			else{
				$result['detail'] = $this->Costcenter->account_detail($this->input->post('id'));
				$result['centers'] = $this->db->query("SELECT * FROM cost_center WHERE is_parent='1'")->result_array();
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/costcenter/components/edit-account',$result,TRUE));
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
    }

	public function save(){
		// echo"<pre>";
		// print_r($this->input->post());
		// exit;
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|callback_check_duplicate_code');
		$this->form_validation->set_message('check_duplicate_code','This %s already exists.');
		// $this->form_validation->set_rules('is_parent', 'Is Parent', 'trim|required');
		$this->form_validation->set_rules('parent_id', 'Parent Cost center', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->Costcenter->add();
    		if($query){
				// echo"<pre>";
				// echo"hii";
				// exit;
				$this->session->set_userdata('info', "1--Successfully created.");
				if($this->input->post('parent_id') > 0){
					redirect('admin/cost-center/cats/'. $this->input->post('parent_id'));
				}else{
					redirect('admin/cost-center');
				}
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/chart-of-accounts');
	}
	
	public function update_main(){
		// echo"<pre>";
		// print_r($this->input->post());
		// exit;
		
		$this->form_validation->set_rules('folderid', 'Request Id', 'trim|required',
											array(
													'required'      => 'Invalid request id.',
										));
		$this->form_validation->set_rules('code', 'Code', 'trim|required|callback_check_duplicate_code');
		$this->form_validation->set_message('check_duplicate_code','This %s already exists.');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->Costcenter->update_main_account();
    		if($query){
				$this->session->set_userdata('info', "1--Successfully updated.");
				if($this->input->post('parent_id') > 0){
					redirect('admin/cost-center/cats/'. $this->input->post('id'));
				}else{
					redirect('admin/cost-center');
				}
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/cost-center');
	}
	
	public function check_duplicate_code() {
		$folderid = $this->input->post('folderid');
		$code = $this->input->post('code');
		
		// do some database things you need to do e.g.
		$duplicate_check = $this->Costcenter->check_duplicate_code($folderid, $code);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	/*---- Sub Category -----*/
	public function categories($id = NULL){
		$data['chart_list'] = $this->Costcenter->main_accounts();
		$data['parent_detail'] = $this->Costcenter->account_detail($id);
		$data['category_list'] = $this->Costcenter->sub_branch($id);
		$data['current_detail'] = $this->Costcenter->account_detail($id);
		//$data['breadcrumb'] = $this->admin->getBreadcrumbTree($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/accounting/costcenter/category_page',$data);
	}

	public function add_sub_account_form()
    {
		
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('parent_id', 'Select Folder', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				$data = array("type"=>'error', "message"=>'Unauthorized request');
			}
			else{
				$parent_id = $this->input->post('parent_id');
				$result['parent_detail'] = $this->Costcenter->account_detail($parent_id);
				$result['centers'] = $this->db->query("SELECT * FROM cost_center WHERE is_parent='1'")->result_array();
				$maxid = $this->getMaxCatID($parent_id);
				$result['default_code'] = $parent_id . $maxid;
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/costcenter/components/add-sub-account',$result,TRUE));
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
    }

	public function getMaxCatID($parent_id) {
		$result = '0';
		$res1 = $this->db->query("SELECT * FROM chart_of_accounts WHERE main_account = '". $parent_id ."' ORDER BY branch_id DESC");
		if ($res1->num_rows() > 0)
		{
			$res2 = $res1->row_array();
			$result = $res2['branch_id'];
			return $result;
		}
		return $result;
	}

	public function edit_sub_account_form()
    {
		// echo"<pre>";
		// print_r($this->input->post());
		// exit;
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('id', 'Request id', 'trim|required');
			$this->form_validation->set_rules('parent_id', 'Main Folder', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				$data = array("type"=>'error', "message"=>'Unauthorized request');
			}
			else{
				$parent_id = $this->input->post('parent_id');
				$result['parent_detail'] = $this->Costcenter->account_detail($parent_id);
				$result['detail'] = $this->Costcenter->account_detail($this->input->post('id'));
				$result['centers'] = $this->db->query("SELECT * FROM cost_center WHERE is_parent='1'")->result_array();
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/costcenter/components/edit-sub-account',$result,TRUE));
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
    }

	public function get_sidebar_cat()
    {
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('id', 'Request id', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				$data = array("type"=>'error', "message"=>'Unauthorized request');
			}
			else{
				$parent_id = $this->input->post('id');
				$data['parent_detail'] = $this->Costcenter->account_detail($parent_id);
				$data['category_list'] = $this->Costcenter->sub_branch($parent_id);
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/accounting_chart/components/sidebar-sub-cat',$data,TRUE));
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
    }

	/*---- End Sub Category -----*/

	public function edit(){
		if($this->input->get('id')){
			$query = $this->Costcenter->get_category_by_id($this->input->get('id'));
			foreach($query->result() as $query){
				$data['id'] = $query->id;
				$data['seo'] = $query->slug;
				$data['name'] = $query->name;
				$data['arabic_name'] = $query->arabic_name;
				$data['sort_order'] = $query->sort_order;
				$data['heading_text'] = $query->heading_text;
				$data['description'] = $query->description;
				$data['arabic_desc'] = $query->arabic_desc;
				$data['metatitle'] = $query->metatitle;
				$data['metadescription'] = $query->metadescription;
				$data['metakeyword'] = $query->metakeyword;
				$data['o_img'] = $query->image;
				$data['o_icon'] = $query->icon;
				$data['parent_id'] = $query->parent_id;
				$data['status'] = $query->status;
			}
		}
		else{
			$data['id'] = "";
			$data['seo'] = "";
			$data['name'] = "";
			$data['arabic_name'] = "";
			$data['sort_order'] = "";
			$data['heading_text'] = "";
			$data['description'] = "";
			$data['arabic_desc'] = "";
			$data['metatitle'] = "";
			$data['metadescription'] = "";
			$data['o_img'] = "";
			$data['o_icon'] = "";
			$data['metakeyword'] = "";
			$data['parent_id'] = "";
			$data['status'] = "";
		}
		$data['parent'] = $this->Costcenter->get_category();
		$this->load->view('admin/accounting/category/category_form',$data);
	}
	
	public function delete($id){
		
		if($id > 0){
			$is_available = $this->Costcenter->check_branch_available($id);
			
			if($is_available->num_rows() > 0){

				$this->session->set_userdata('info', "2--First delete inner files!");
			}else{
				$query = $this->Costcenter->delete($id);
				if($query){
					$this->session->set_userdata('info', "1--Successfully deleted");
				}
				else{
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/cost-center');
	}

	public function costcenterview(){
		$this->load->view('admin/accounting/costcenter/costcenterview');
	}
	
}
// 	public function __construct() {
//         parent::__construct();			
// 		if($this->admin->isLogged()){		
// 			// $this->load->model('admin/assets_management/Category_model');	
// 			$this->load->library('form_validation');	
// 		}		
// 		else{		
// 			redirect('admin/login');			
// 		}
// 	}
	
//     public function index(){
// 		$this->load->view('admin/accounting/costcenter/costcenter_list');
// 	}

   
    

//     public function headofficeedit(){
// 		$this->load->view('admin/accounting/costcenter/headofficeedit');
// 	}

//     public function costcentertransactions(){
// 		$this->load->view('admin/accounting/costcenter/costcentertransactions');
// 	}
// 	public function costcenterreport(){
// 		$this->load->view('admin/accounting/costcenter/costcenterreport');
// 	}
    
// 	public function accountwithoutcostcenter(){
// 		$this->load->view('admin/accounting/costcenter/accountwithoutcostcenter');
// 	}

// 	public function accountwithcostcenter(){
// 		$this->load->view('admin/accounting/costcenter/accountwithcostcenter');
// 	}

// 	public function alltransaction(){
// 		$this->load->view('admin/accounting/costcenter/alltransaction');
// 	}
	
// 	public function managecostcenters(){
// 		$this->load->view('admin/accounting/costcenter/managecostcenters');
// 	}

// 	public function addcostcenter(){
// 		$this->load->view('admin/accounting/costcenter/addcostcenter');
// 	}

// 	public function editcostcenter(){
// 		$this->load->view('admin/accounting/costcenter/editcostcenter');
// 	}

// 	public function editwithoutcost(){
// 		$this->load->view('admin/accounting/costcenter/editwithoutcost');
// 	}

// 	public function assigncostcenter(){
// 		$this->load->view('admin/accounting/costcenter/assigncostcenter');
// 	}

// 	public function alltransactionedit(){
// 		$this->load->view('admin/accounting/costcenter/alltransactionedit');
// 	}
	
// }
