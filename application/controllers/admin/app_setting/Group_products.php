<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Group_products extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->admin->isLogged()){
			redirect('admin/common/login');
		}
		$this->load->model('admin/app_management/Product_group_model', 'product_group');
		$this->load->library('form_validation');
	}

	public function index(){
		$data['results'] = $this->product_group->list();
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		//print_r($data['results']);exit();
		$this->load->view('admin/app_setting/product-groups/list',$data);
	}

	public function add(){
		$this->load->view('admin/app_setting/product-groups/form');
	}
	
	public function edit(){
		$query = $this->product_group->detail($this->input->get('id'));
		if($query->num_rows() > 0){
			$products = array();
			$group_info = $query->row_array();
			$prod_array = json_decode($group_info['products']);
			if(count($prod_array) > 0){
				foreach($prod_array as $prod){
					$this->db->select('s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku');
					$this->db->from('product_size s');
					$this->db->join('product p', 's.product_id = p.id', 'left');
					$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
					$this->db->where("(s.id = '".$prod->s_id."')", NULL, FALSE);
					$query_prod = $this->db->get()->row_array();
					$products[] = array("id" => $query_prod['size_id'],
							"prod_id" => $query_prod['prod_id'],
							"name" => $query_prod['name'],
							"name_arabic" => $query_prod['name_ar'],
							"image" => $query_prod['image'],
							"sku" => $query_prod['product_sku'],
							"parent_sku" => $query_prod['parent_sku'],
							"seller_sku" => $query_prod['seller_sku'],
							"size_id" => $query_prod['size_id'],
							"unit" => $query_prod['size_unit'],
							"unit_name" => $query_prod['unit_name'],
							"sort_order" => $prod->sort,
							"barcode" => $query_prod['barcode']);
				}
			}
			//echo '<pre>';print_r($products);exit();
			$data['id'] = $group_info['group_id'];
			$data['group_name'] = $group_info['group_name'];
			$data['group_name_arabic'] = $group_info['group_name_arabic'];
			$data['group_title'] = $group_info['group_title'];
			$data['group_title_arabic'] = $group_info['group_title_arabic'];
			$data['group_url'] = $group_info['group_url'];
			$data['products'] = $products;
			$data['status'] = $group_info['status'];
			$data['sort_order'] = $group_info['sort_order'];
		}
		$this->load->view('admin/app_setting/product-groups/edit',$data);
	}

	public function save(){
		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('group_title', 'Group Title', 'trim|required');
		$this->form_validation->set_rules('products[]', 'Products', 'trim|required');
		$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('group_url', 'Group URL', 'trim|required|callback_check_url_duplicate');
		$this->form_validation->set_message('check_url_duplicate','Url already used, Try new');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$query = $this->product_group->add();
			if($query){
				$this->session->set_userdata('info', "1--Successfully added");
			}
			else{
				$this->session->set_userdata('info', "2--Something went wrong, try again.");
			}
		}
		redirect('admin/app/product-groups/list');
	}
	
	public function update(){
		$this->form_validation->set_rules('group_name', 'Group Name', 'trim|required');
		$this->form_validation->set_rules('group_title', 'Group Title', 'trim|required');
		$this->form_validation->set_rules('products[]', 'Products', 'trim|required');
		$this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		$this->form_validation->set_rules('group_url', 'Group URL', 'trim|required|callback_check_url_duplicate');
		$this->form_validation->set_message('check_url_duplicate','Url already used, Try new');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			if($this->input->post('id')){
				$query = $this->product_group->edit();
				if($query){
					$this->session->set_userdata('info', "1--Successfully updated.");
				}
				else{
					$this->session->set_userdata('info', "2--Something went wrong, try again.");
				}
			}
		}
		redirect('admin/app/product-groups/list');
	}

	public function check_url_duplicate() {
		$id = $this->input->post('id');
		$group_url = $this->input->post('group_url');
		//print_r($passport_no);exit();
		// do some database things you need to do e.g.
		$duplicate_check = $this->product_group->check_duplicate_url($id, $group_url);
		if($duplicate_check > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function ajax_check_url() {
		$group_url = $this->input->get('group_url');
		$id = '';
		if($group_url !== ''){
			// do some database things you need to do e.g.
			$duplicate_check = $this->product_group->check_duplicate_url($id, $group_url);
			if($duplicate_check > 0) {
				$data['status'] = 'error';
				$data['msg'] = "<span style='color:red;'><b>". $group_url . "</b> This url already exists. Try New.</span>";
			}else{
				$data['status'] = 'success';
				$data['msg'] = "<span style='color:green;'>Url Available.</span>";
			}
		}else{
			$data['status'] = 'error';
			$data['msg'] = "<span style='color:red;'>Url is required.</span>";
		}
		echo json_encode($data);
	}

	public function delete(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->product_group->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}else{
			$this->session->set_userdata('info', "2--Something went wrong, try again.");
		}
		redirect('admin/app/product-groups/list');
	}
	
	public function get_search_list(){
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['result'] = $this->product_group->get_search_hint($data['term']);
		echo json_encode($data);
	}
}
