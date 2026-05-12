<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_of_accounts extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){		
			$this->load->model('admin/Accounting/ChartAccount_model');
			$this->load->library('form_validation');
		}			
		else{				
			redirect('admin');
		}
	}
		
	public function index(){
		$data['chart_list'] = $this->ChartAccount_model->main_accounts();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/accounting/accounting_chart/main_page',$data);
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
				$data['parent_id'] = $this->input->post('parent_id');
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/accounting_chart/components/add-account',$data,TRUE));
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
			$duplicate_check = $this->ChartAccount_model->check_duplicate_code($folderid, $code, $account_type);
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
				$data['detail'] = $this->ChartAccount_model->account_detail($this->input->post('id'));
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/accounting_chart/components/edit-account',$data,TRUE));
			}
		}else{
			$data = array("type"=>'error', "message"=>'Session expired, Please login again. <a href="'. base_url('admin') .'" class="text-danger"> Login</a>');
		}
		echo json_encode($data);
    }

	public function save(){
		$this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|callback_check_duplicate_code');
		$this->form_validation->set_message('check_duplicate_code','This %s already exists.');
		$this->form_validation->set_rules('branch_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('main_account', 'Main Account', 'trim|required');
		$this->form_validation->set_rules('journal_cat_type', 'Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->ChartAccount_model->add();
    		if($query){
				$this->session->set_userdata('info', "1--Successfully created.");
				if($this->input->post('main_account') > 0){
					redirect('admin/chart-of-accounts/cats/'. $this->input->post('main_account'));
				}else{
					redirect('admin/chart-of-accounts');
				}
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/chart-of-accounts');
	}
	
	public function update_main(){
		$this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
		$this->form_validation->set_rules('folderid', 'Request Id', 'trim|required',
											array(
													'required'      => 'Invalid request id.',
										));
		$this->form_validation->set_rules('code', 'Code', 'trim|required|callback_check_duplicate_code');
		$this->form_validation->set_message('check_duplicate_code','This %s already exists.');
		$this->form_validation->set_rules('branch_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('main_account', 'Main Account', 'trim|required');
		$this->form_validation->set_rules('journal_cat_type', 'Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
    		$query = $this->ChartAccount_model->update_main_account();
    		if($query){
				$this->session->set_userdata('info', "1--Successfully updated.");
				if($this->input->post('main_account') > 0){
					redirect('admin/chart-of-accounts/cats/'. $this->input->post('main_account'));
				}else{
					redirect('admin/chart-of-accounts');
				}
			}
			else{
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/chart-of-accounts');
	}
	
	public function check_duplicate_code() {
		$folderid = $this->input->post('folderid');
		$code = $this->input->post('code');
		$account_type = $this->input->post('account_type');
		// do some database things you need to do e.g.
		$duplicate_check = $this->ChartAccount_model->check_duplicate_code($folderid, $code, $account_type);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	/*---- Sub Category -----*/
	public function categories($id = NULL){
		$data['chart_list'] = $this->ChartAccount_model->main_accounts();
		$data['parent_detail'] = $this->ChartAccount_model->account_detail($id);
		$data['category_list'] = $this->ChartAccount_model->sub_branch($id);
		$data['current_detail'] = $this->ChartAccount_model->account_detail($id);
		//$data['breadcrumb'] = $this->admin->getBreadcrumbTree($id);
		//echo '<pre>';print_r($data);exit();
		$this->load->view('admin/accounting/accounting_chart/category_page',$data);
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
				$data['parent_detail'] = $this->ChartAccount_model->account_detail($parent_id);
				$maxid = $this->getMaxCatID($parent_id);
				$data['default_code'] = $parent_id . $maxid;
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/accounting_chart/components/add-sub-account',$data,TRUE));
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
		if($this->admin->isLogged()){
			$this->form_validation->set_rules('id', 'Request id', 'trim|required');
			$this->form_validation->set_rules('parent_id', 'Main Folder', 'trim|required');
			if($this->form_validation->run()==FALSE){
				$msg = validation_errors();
				$data = array("type"=>'error', "message"=>'Unauthorized request');
			}
			else{
				$parent_id = $this->input->post('parent_id');
				$data['parent_detail'] = $this->ChartAccount_model->account_detail($parent_id);
				$data['detail'] = $this->ChartAccount_model->account_detail($this->input->post('id'));
				$data = array("type"=>'success', "message"=>$this->load->view('admin/accounting/accounting_chart/components/edit-sub-account',$data,TRUE));
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
				$data['parent_detail'] = $this->ChartAccount_model->account_detail($parent_id);
				$data['category_list'] = $this->ChartAccount_model->sub_branch($parent_id);
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
			$query = $this->ChartAccount_model->get_category_by_id($this->input->get('id'));
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
		$data['parent'] = $this->ChartAccount_model->get_category();
		$this->load->view('admin/accounting/category/category_form',$data);
	}
	
	public function delete($id){
		if($id > 0){
			$is_available = $this->ChartAccount_model->check_branch_available($id);
			if($is_available->num_rows() > 0){
				$this->session->set_userdata('info', "2--First delete inner files!");
			}else{
				$query = $this->ChartAccount_model->delete($id);
				if($query){
					$this->session->set_userdata('info', "1--Successfully deleted");
				}
				else{
					$this->session->set_userdata('info', "2--Error!!!");
				}
			}
		}
		redirect('admin/chart-of-accounts');
	}
	
}
