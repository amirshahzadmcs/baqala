<?php defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/assets_management/Product_model');
			$this->load->model('admin/assets_management/Subcategory_model');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->action = $this->router->method;
		} else {
			redirect('admin/login');
		}
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->getInfo()) {
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$data['categories'] = $this->Subcategory_model->get_categories();
		$this->load->view('admin/assets-products/list', $data);
	}

	public function get_list()
	{
		$fetch_data = $this->Product_model->get_list();
		//	$i = $_POST['start'] + 1 ;
		$data = array();
		foreach ($fetch_data as $cat) {
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" value="' . $cat->id . '" name="check_list[]" />';
			$sub_array[] = $cat->fa_code;
			$sub_array[] = $cat->description;
			$sub_array[] = $cat->category_name;
			$sub_array[] = $cat->sub_cat_name;
			$sub_array[] = $cat->prod_sr_no;
			$sub_array[] = $cat->model_no;
			$sub_array[] = date("d-m-Y", strtotime($cat->purchase_date));
			$sub_array[] = date("d-m-Y", strtotime($cat->warranty_exp));
			$sub_array[] = $cat->price;
			$sub_array[] = $cat->prod_condition;
			$sub_array[] = $cat->unit_value;
			$sub_array[] = $cat->qty;
			$sub_array[] = $cat->value;
			$sub_array[] = $cat->is_alloted == '1' ? '<span class="badge badge-pill badge-soft-success font-size-13">Alloted</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Unalloted</span>';
			$sub_array[] = $cat->status == 'active' ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = $cat->created_at;
			$sub_array[] = $cat->updated_at;
			if ($cat->is_alloted == '0' && check_action_permission(get_user_role(), 'fixed_assets', 'allot_prod')) {
				$allot_btn = '<a type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit ms-1" data-toggle="tooltip" title="Allot" onclick="allot(' . $cat->id . ')"><i class="dripicons-forward font-size-18"></i></a>';
			} elseif ($cat->is_alloted == '1' && check_action_permission(get_user_role(), 'fixed_assets', 'unallot_prod')) {
				$allot_btn = '<a type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit ms-1" data-toggle="tooltip" title="Unallot" onclick="unallot(' . $cat->id . ')"><i class="dripicons-time-reverse font-size-18"></i></a>';
			}
			$sub_array[] = (check_action_permission(get_user_role(), 'fixed_assets', 'add') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/assets/product/edit?id=' . $cat->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'fixed_assets', 'details') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit ms-1" data-toggle="tooltip" title="Detail" href="' . base_url() . 'admin/assets/product/detail?id=' . $cat->id . '" target="_blank"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'fixed_assets', 'copy') ? '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit ms-1" data-toggle="tooltip" title="Copy" href="' . base_url() . 'admin/assets/product/copy?id=' . $cat->id . '"><i class="mdi mdi-content-duplicate font-size-18"></i></a>' : '') . (check_action_permission(get_user_role(), 'fixed_assets', 'assets_log') ? '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit py-1 px-2 ms-1" onclick="asset_log(' . $cat->id . ')"><i class="ti-server font-size-16"></i></button>' : '') . $allot_btn;
			$data[] = $sub_array;
		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>      $this->Product_model->get_all_data(),
			"recordsFiltered"     =>     $this->Product_model->get_filtered_data(),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Product_model->get_detail($this->input->get('id'));
			foreach ($query->result() as $query) {
				$data['id'] = $query->id;
				$data['fa_category'] = $query->fa_category;
				$data['fa_subcategory'] = $query->fa_subcategory;
				$data['description'] = $query->description;
				$data['prod_sr_no'] = $query->prod_sr_no;
				$data['model_no'] = $query->model_no;
				$data['purchase_date'] = $query->purchase_date;
				$data['supplier_id'] = $query->supplier_id;
				$data['warranty_exp'] = $query->warranty_exp;
				$data['price'] = $query->price;
				$data['prod_condition'] = $query->prod_condition;
				$data['unit_value'] = $query->unit_value;
				$data['qty'] = $query->qty;
				$data['value'] = $query->value;
				$data['status'] = $query->status;
			}
		} else {
			$data['id'] = "";
			$data['fa_category'] = "";
			$data['fa_subcategory'] = "";
			$data['description'] = "";
			$data['prod_sr_no'] = "";
			$data['model_no'] = "";
			$data['purchase_date'] = "";
			$data['supplier_id'] = "";
			$data['warranty_exp'] = "";
			$data['price'] = "";
			$data['prod_condition'] = "";
			$data['unit_value'] = "";
			$data['qty'] = "";
			$data['value'] = "";
			$data['status'] = "";
		}
		$data['categories'] = $this->Subcategory_model->get_categories();
		$this->load->view('admin/assets-products/form', $data);
	}

	public function copy()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Product_model->get_detail($this->input->get('id'))->row();
			$data['id'] = "";
			$data['fa_category'] = $query->fa_category;
			$data['fa_subcategory'] = $query->fa_subcategory;
			$data['description'] = $query->description;
			$data['prod_sr_no'] = "";
			$data['model_no'] = $query->model_no;
			$data['purchase_date'] = $query->purchase_date;
			$data['supplier_id'] = $query->supplier_id;
			$data['warranty_exp'] = $query->warranty_exp;
			$data['price'] = $query->price;
			$data['prod_condition'] = $query->prod_condition;
			$data['unit_value'] = $query->unit_value;
			$data['qty'] = "1";
			$data['value'] = $query->value;
			$data['status'] = $query->status;
			$data['category_name'] = $query->category_name;
			$data['sub_cat_name'] = $query->sub_cat_name;
			$data['vendor_name'] = $query->vendor_name;
		} else {
			$this->session->set_userdata('info', "2--Invalid Product!!!");
			redirect('admin/assets/product/list');
		}
		$data['categories'] = $this->Subcategory_model->get_categories();
		$this->load->view('admin/assets-products/form', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('fa_category', 'Select Category', 'trim|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('prod_sr_no', 'Serial No', 'trim|required');
		$this->form_validation->set_rules('supplier_id', 'Supplier Name', 'trim|required');
		$this->form_validation->set_rules('model_no', 'Model No', 'trim|required');
		$this->form_validation->set_rules('purchase_date', 'Purchase Date', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('prod_condition', 'Product Condition', 'trim|required');
		$this->form_validation->set_rules('unit_value', 'Unit Value', 'trim|required');
		$this->form_validation->set_rules('value', 'Value', 'trim|required');
		$this->form_validation->set_rules('status', 'Status', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			if ($this->input->post('id')) {
				$query = $this->Product_model->edit();
			} else {
				$query = $this->Product_model->add();
			}
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully done");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/assets/product/list');
	}

	public function details()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->input->get('id')) {
			$query = $this->Product_model->get_detail($this->input->get('id'))->row();
			$data['id'] = $query->id;
			$data['fa_category'] = $query->fa_category;
			$data['fa_subcategory'] = $query->fa_subcategory;
			$data['description'] = $query->description;
			$data['prod_sr_no'] = $query->prod_sr_no;
			$data['model_no'] = $query->model_no;
			$data['purchase_date'] = $query->purchase_date;
			$data['supplier_id'] = $query->supplier_id;
			$data['warranty_exp'] = $query->warranty_exp;
			$data['price'] = $query->price;
			$data['prod_condition'] = $query->prod_condition;
			$data['unit_value'] = $query->unit_value;
			$data['qty'] = $query->qty;
			$data['value'] = $query->value;
			$data['status'] = $query->status;
			$data['category_name'] = $query->category_name;
			$data['sub_cat_name'] = $query->sub_cat_name;
			$data['vendor_name'] = $query->vendor_name;
			$data['emp_name'] = $query->emp_name;
			$data['emp_designation'] = $query->emp_designation;
			$data['ip'] = $query->ip;
		} else {
			$this->session->set_userdata('info', "2--Invalid Product!!!");
			redirect('admin/assets/product/list');
		}
		$this->load->view('admin/assets-products/detail', $data);
	}

	public function delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		$id = implode(',', $this->input->post('check_list'));
		$query = $this->Product_model->delete($id);
		if ($query) {
			$this->session->set_userdata('info', "1--Successfully deleted");
		} else {
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('admin/assets/product/list');
	}

	function get_subcategories()
	{
		$id = $this->input->post('category_id');
		$query = $this->db->query("SELECT * FROM assets_subcategory where parent_id=" . $id)->result();
		echo json_encode($query);
	}

	public function allot_prod_popup()
	{
		$this->form_validation->set_rules('prod_id', 'Product ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$prod_id = $this->input->post('prod_id');
			$data['prod_detail'] = $this->Product_model->get_detail($prod_id)->row();
			$output_data = $this->load->view('admin/assets-products/allotment-layout', $data, TRUE);
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}

	public function unallot_prod_popup()
	{
		$this->form_validation->set_rules('prod_id', 'Product ID', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$msg = validation_errors();
			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
			exit();
		} else {
			$prod_id = $this->input->post('prod_id');
			$data['prod_detail'] = $this->Product_model->get_detail($prod_id)->row();
			$output_data = $this->load->view('admin/assets-products/unallotment-layout', $data, TRUE);
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
	}

	public function allot_prod()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('assets_id', 'Asset ID', 'trim|required');
			$this->form_validation->set_rules('emp_id', 'Employee ID', 'trim|required');
			$this->form_validation->set_rules('emp_type', 'Employee Type', 'trim|required');
			$this->form_validation->set_rules('emp_designation', 'Employee Designation', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
			} else {
				$query = $this->Product_model->allot_assets();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully alloted!");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, try again.");
				}
			}
		} else {
			$this->session->set_userdata('info', "2--Session expired! Login again");
		}
		redirect('admin/assets/product/list');
	}

	public function unallot_prod()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('assets_id', 'Asset ID', 'trim|required');
			$this->form_validation->set_rules('remarks', 'Unallotment Remarks', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
			} else {
				$query = $this->Product_model->unallot_assets();
				if ($query) {
					$this->session->set_userdata('info', "1--Successfully unalloted!");
				} else {
					$this->session->set_userdata('info', "2--Something went wrong, try again.");
				}
			}
		} else {
			$this->session->set_userdata('info', "2--Session expired! Login again");
		}
		redirect('admin/assets/product/list');
	}

	public function assets_log()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'fixed_assets', $this->action)):
			redirect('admin/unauthorized-request');
		endif;
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('prod_id', 'Product ID', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$msg = validation_errors();
				echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>' . $msg . '</strong></div>';
				exit();
			} else {
				$prod_id = $this->input->post('prod_id');
				$query = $this->Product_model->assets_log($prod_id);
				if ($query) {
					$data['assets_log'] = $query;
					$data['assets_detail'] = $this->Product_model->get_detail($prod_id)->row_array();
				} else {
					$data['assets_log'] = $query;
					$data['assets_detail'] = $this->Product_model->get_detail($prod_id)->row_array();
					echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>No data found.</div>';
					exit();
				}
				$output_data = $this->load->view('admin/assets-products/assets-log', $data, TRUE);
				//echo '<pre>';print_r($data);exit();
				//echo json_encode($data);
				echo $output_data;
			}
		} else {
			$this->session->set_userdata('info', "2--Session expired! Login again");
			redirect('admin/assets/product/list');
		}
	}
}
