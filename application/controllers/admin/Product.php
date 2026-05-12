<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->admin->isLogged()) {
			redirect('admin/common/login');
		}
		$this->load->model('admin/Product_model');
		$this->load->model('admin/Category_model');
		$this->load->library('form_validation');
		$this->load->helper('file');
		$this->action = $this->router->method;
	}

	public function index()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			if ($this->admin->getInfo()) {
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			} else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
			$id = 12;
			if ($this->input->get('id')) {
				$id = $this->input->get('id');
			}
			$data['categories'] = $this->Category_model->get_category();
			$data['brand_list'] = $this->Product_model->brand_list();
			//$data['products'] = $this->Product_model->get_list($id);
			$data['total_products'] = $this->db->query("SELECT count(id) as total FROM product WHERE is_deleted = '0'")->result_array();
			$data['total_variation'] = $this->db->query("SELECT count(id) as total FROM product_size WHERE is_deleted = '0'")->result_array();
			$data['active_products'] = $this->db->query("SELECT count(id) as total FROM product WHERE status = '1' AND is_deleted = '0'")->result_array();
			$data['disable_products'] = $this->db->query("SELECT count(id) as total FROM product WHERE status = '0' AND is_deleted = '0'")->result_array();
			$data['image_missing'] = $this->db->query("SELECT count(id) as total FROM product WHERE (image = '' OR image IS NULL) AND is_deleted = '0'")->result_array();
			$data['arabic_missing'] = $this->db->query("SELECT count(id) as total FROM product WHERE name_ar = '' AND is_deleted = '0'")->result_array();
			$data['sku_missing'] = $this->db->query("SELECT count(id) as total FROM product WHERE parent_sku = '' AND is_deleted = '0'")->result_array();
			//echo '<pre>';print_r($data['image_missing']);'</pre>';exit();
			$this->load->view('admin/product/product_list', $data);
		} else {
			redirect('admin');
		}
	}

	public function filtered_product()
	{
		if ($this->admin->isLogged()) {
			if ($this->admin->getInfo()) {
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			} else {
				$data['info'] = '';
				$data['info_type'] = '';
			}

			$data['total_products'] = $this->db->query("SELECT count(id) as total FROM product WHERE is_deleted = '0'")->result_array();
			$data['total_variation'] = $this->db->query("SELECT count(id) as total FROM product_size WHERE is_deleted = '0'")->result_array();
			$data['active_products'] = $this->db->query("SELECT count(id) as total FROM product WHERE status = '1' AND is_deleted = '0'")->result_array();
			$data['disable_products'] = $this->db->query("SELECT count(id) as total FROM product WHERE status = '0' AND is_deleted = '0'")->result_array();
			$data['image_missing'] = $this->db->query("SELECT count(id) as total FROM product WHERE (image = '' OR image IS NULL) AND is_deleted = '0'")->result_array();
			$data['arabic_missing'] = $this->db->query("SELECT count(id) as total FROM product WHERE name_ar = '' AND is_deleted = '0'")->result_array();
			$data['sku_missing'] = $this->db->query("SELECT count(id) as total FROM product WHERE parent_sku = '' AND is_deleted = '0'")->result_array();
			//echo '<pre>';print_r($data['image_missing']);'</pre>';exit();
			$this->load->view('admin/product/filtered_product', $data);
		} else {
			redirect('admin');
		}
	}

	public function deleted_product()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'deleted_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			if ($this->admin->getInfo()) {
				$info = explode('--', $this->admin->getInfo());
				$data['info'] = $info[1];
				$data['info_type'] = $info[0];
			} else {
				$data['info'] = '';
				$data['info_type'] = '';
			}
			$data['products'] = $this->Product_model->get_deleted_product();
			$this->load->view('admin/product/deleted-product-list', $data);
		} else {
			redirect('admin');
		}
	}

	public function quan()
	{
		if ($this->admin->isLogged()) {
			//	$data['category'] = $this->Category_model->get_category();
			$data['product'] = $this->Product_model->get_list1();
			$this->load->view('admin/catalog/product_empty', $data);
		} else {
			redirect('admin');
		}
	}

	public function productSearch()
	{
		$product = $this->Product_model->getProductSearch();
		echo json_encode($product);
		//$this->load->view('admin/catalog/product_list', $data);
	}

	public function create_product()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$data['categories'] = $this->Category_model->get_category();
		$data['brand_list'] = $this->Product_model->brand_list();
		//echo '<pre>';print_r($data);exit();
		$this->load->view("admin/product/create_product", $data);
	}

	public function save_product()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('category_id', 'Select Category', 'trim|required');
			$this->form_validation->set_rules('brand_id', 'Select Brand', 'trim|required');
			$this->form_validation->set_rules('parent_sku', 'Parent SKU', 'trim|required|is_unique[product.parent_sku]');
			//$this->form_validation->set_rules('status', 'Select Status', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
				redirect('admin/product/create_product');
			} else {
				$product_id = $this->Product_model->create();
				//$product_id = $this->db->insert_id();
				//print_r($product_id);exit();
				if ($product_id > 0) {
					$this->db->query("INSERT INTO product_size SET product_id = '" . (int)$product_id . "'");
					$this->session->set_userdata('info', "1--Successfully created");
					redirect('admin/product/add?id=' . $product_id);
				} else {
					$this->session->set_userdata('info', "2--Error!!!");
					redirect('admin/product/create_product');
				}
			}
		} else {
			redirect('admin/product/create_product');
		}
	}

	public function update_product()
	{
		$this->form_validation->set_rules('main_id', 'Product ID', 'trim|required');
		$this->form_validation->set_rules('parent_sku', 'Main SKU', 'trim|required|callback_validate_sku');
		$this->form_validation->set_message('validate_sku', 'SKU already taken, Try new');
		$this->form_validation->set_rules('category_id', 'Select Category', 'trim|required');
		$this->form_validation->set_rules('brand_id', 'Select Brand', 'trim|required');
		//$this->form_validation->set_rules('status', 'Select Status', 'trim|required');
		$product_id = $this->input->post('main_id');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_userdata('info', "2--" . validation_errors());
		} else {
			$main_sku = $this->input->post('parent_sku');
			$query = $this->Product_model->update();
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error!!!");
			}
		}
		redirect('admin/product/add?id=' . $product_id);
	}

	public function validate_sku($parent_sku)
	{
		$id = $this->input->post('main_id');
		$sku_check = $this->Product_model->check_sku($parent_sku, $id);
		if ($sku_check > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function add()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->input->get('id')) {
			$tid = $this->input->get('id');
			$main = $this->Product_model->mainProduct($tid);
			if ($main) {
				$data['id'] = $main->id;
				$data['brand_id'] = $main->brand_id;
				$data['parent_sku'] = $main->parent_sku;
				$data['is_variation'] = $main->is_variation;
				$data['status'] = $main->status;
				$data['cod_available'] = $main->cod_available;
				$data['b2b_availability'] = $main->b2b_availability;
				$data['is_deleted'] = $main->is_deleted;
				$data['main_category'] = $main->main_category;
				$data['brand_name'] = $main->brand_name;
				$data['main_cat_name'] = $main->main_cat_name;
				//$data['product_id'] = $main->product_id;
				$data['name'] = $main->name;
				$data['name_ar'] = $main->name_ar;
				$data['description'] = $main->description;
				$data['description_ar'] = $main->description_ar;
				$data['country_id'] = $main->country_id;
				$data['country_id_ar'] = $main->country_id_ar;
				$data['main_image'] = $main->image;
				$data['moq'] = $main->moq;
				$data['meta_title'] = $main->meta_title;
				$data['meta_description'] = $main->meta_description;
				$data['meta_keyword'] = $main->meta_keyword;
			} else {
				$data['id'] = "";
				$data['brand_id'] = "";
				$data['parent_sku'] = "";
				$data['is_variation'] = "";
				$data['status'] = "";
				$data['cod_available'] = "";
				$data['b2b_availability'] = "";
				$data['is_deleted'] = "";
				$data['main_category'] = "";
				$data['brand_name'] = "";
				$data['main_cat_name'] = "";
				//$data['product_id'] = "";
				$data['name'] = "";
				$data['name_ar'] = "";
				$data['description'] = "";
				$data['description_ar'] = "";
				$data['country_id'] = "";
				$data['country_id_ar'] = "";
				$data['main_image'] = "";
				$data['moq'] = "";
				$data['meta_title'] = "";
				$data['meta_description'] = "";
				$data['meta_keyword'] = "";
			}
			$data['product_image'] = $this->Product_model->product_image($tid);
			$data['product_attribute'] = $this->Product_model->product_attribute($tid);
			$data['product_review'] = $this->Product_model->product_review($tid);
			$data['product_size'] = $this->Product_model->product_size($tid);
			$data['product_category'] = $this->Product_model->product_category($tid);
			$data['categories'] = $this->Category_model->get_category();
			$data['brand_list'] = $this->Product_model->brand_list();
			$data['unit_list'] = $this->Product_model->unit_list();
			$data['country_list'] = $this->Product_model->country_list();
			$data['racks'] = $this->Product_model->get_racks();
			$data['shelfs'] = $this->Product_model->get_shelfs();
			//print_r($data['product_image']);exit();
			$this->load->view('admin/product/product_form', $data);
		} else {
			redirect('admin/product/create_product');
		}
	}

	public function edit()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			//$this->form_validation->set_rules('main_image', 'Product Image', 'trim|required');
			$this->form_validation->set_rules('moq', 'Minimum order quantity', 'trim|required');
			$this->form_validation->set_rules('size[]', 'Product Size', 'trim|required');
			$this->form_validation->set_rules('size_unit[]', 'Size Unit', 'trim|required');
			$this->form_validation->set_rules('price[]', 'Product price', 'trim|required');
			//$this->form_validation->set_rules('product_sku[]', 'Product SKU', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
			} else {
				//print_r($this->input->post());exit();
				if ($this->input->post('product_id')) {
					$query = $this->Product_model->edit();
					if ($query) {
						$this->session->set_userdata('info', "1--Successfully done");
					} else {
						$this->session->set_userdata('info', "2--Error!!!");
					}
				} else {
					$this->session->set_userdata('info', "2--Product not valid!!!");
				}
			}
			if ($this->input->post('product_id')) {
				$product_id = $this->input->post('product_id');
				redirect('admin/product/add?id=' . $product_id);
			} else {
				redirect('admin/product');
			}
		} else {
			redirect('admin');
		}
	}

	public function add_bulk_product()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		$this->load->view("admin/product/bulk_product_form");
	}

	/*
	public function add_bulk(){
	    ini_set('memory_limit', '20M');
		if(is_uploaded_file($_FILES['csv_file']['tmp_name'])){
            $csvFile = fopen($_FILES['csv_file']['tmp_name'], 'r');
			//print_r(fgetcsv($csvFile));exit();
            //parse data from csv file line by line
			fgetcsv($csvFile);
            while(($line = fgetcsv($csvFile)) !== FALSE){
				//print_r($line);exit();
				$config['brand_id'] = $line[0];
				$config['parent_sku'] = $line[1];
				//$config['image1'] = "products_image/".$line[4];
				$config['is_variation'] = $line[2];
				$config['status'] = $line[3];
				$config['cod_available'] = $line[4];
				$config['category_id'] = $line[5];
				$config['name'] = $line[6];
				$config['name_ar'] = $line[7];
				$config['meta_title'] = $line[6];
				$config['meta_description'] = $line[6];
				$config['meta_keyword'] = $line[6];
				$config['description'] = $line[8];
				$config['description_ar'] = $line[9];
				$config['moq'] = $line[10];
				$config['size'] = $line[11];
				$config['size_arabic'] = $line[12];
				$config['size_unit'] = $line[13];
				$config['price'] = $line[14];
				$config['discounted_price'] = $line[15];
				//$config['category'][0] = $line[16];
				//if($line[17] != ""){ $config['category'][1] = $line[17];}
				$config['disc_expiry'] = $line[16];
				$config['barcode'] = $line[17];
				$config['cashback'] = $line[18];
				$config['cashback_expiry'] = $line[19];
				//$config['product_sku'] = $line[20];
				$config['seller_sku'] = $line[20];
				//print_r($config);exit();
				$this->Product_model->add_bulk($config);
			}
			//print_r($line);exit();
            fclose($csvFile);
		}
		$this->session->set_userdata('info', "1--Successfully done");
		redirect('admin/product');
	}
	
	public function download_sample_csv(){
		$this->load->helper('file'); // Load file helper
		$this->load->helper('download');
		$filename = 'bulk-upload-sample.csv';
		//$data = file_get_contents(base_url()."images/warehouse-bulk-sample.csv");
		//print_r($data);exit();
		//force_download($filename, "\xEF\xBB\xBF" . $data);
		force_download($filename);
	}
    */
	public function add_bulk()
	{
		$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
		$i = 1;
		foreach ($file_data as $row) {
			//print_r($row['Rack_ID']);exit();
			$config['brand_id'] = $row['Brand_ID'];
			$config['parent_sku'] = $row['Parent_SKU'];
			$config['is_variation'] = $row['Is_Variation'];
			$config['status'] = $row['Status'];
			$config['cod_available'] = $row['COD_Available'];
			$config['category_id'] = $row['Category_ID'];
			$config['name'] = $row['Name_English'];
			$config['name_ar'] = $row['Name_Arabic'];
			$config['meta_title'] = $row['Name_English'];
			$config['meta_description'] = $row['Name_English'];
			$config['meta_keyword'] = $row['Name_English'];
			$config['description'] = $row['Description_English'];
			$config['description_ar'] = $row['Description_Arabic'];
			$config['moq'] = $row['MOQ'];
			$config['size'] = $row['Size_English'];
			$config['size_arabic'] = $row['Size_Arabic'];
			$config['size_unit'] = $row['Size_Unit_ID'];
			$config['price'] = $row['Price'];
			$config['discounted_price'] = $row['Discounted_Price'];
			$config['disc_expiry'] = $row['Discount_Expiry'];
			$config['barcode'] = $row['Barcode'];
			$config['cashback'] = $row['Cashback'];
			$config['cashback_expiry'] = $row['Cashback_Expiry'];
			$config['seller_sku'] = $row['Seller_SKU'];
			$config['rack'] = $row['Rack_ID'];
			$config['shelf'] = $row['Shelf_ID'];
			//print_r($config);exit();
			$this->Product_model->add_bulk($config);
		}
		$this->session->set_userdata('info', "1--Successfully done");
		redirect('admin/product');
	}

	public function copy()
	{
		if ($this->input->get('id')) {
			$pid = $this->Product_model->copy();
			if ($pid > 0) {
				$main = $this->Product_model->mainProduct($pid);
				$data['id'] = $main->id;
				$data['brand_id'] = $main->brand_id;
				$data['parent_sku'] = $main->parent_sku;
				$data['is_variation'] = $main->is_variation;
				$data['status'] = $main->status;
				$data['cod_available'] = $main->cod_available;
				$data['b2b_availability'] = $main->b2b_availability;
				$data['is_deleted'] = $main->is_deleted;
				$data['main_category'] = $main->main_category;
				$data['brand_name'] = $main->brand_name;
				$data['main_cat_name'] = $main->main_cat_name;
				//$data['product_id'] = $main->product_id;
				$data['name'] = $main->name;
				$data['name_ar'] = $main->name_ar;
				$data['description'] = $main->description;
				$data['description_ar'] = $main->description_ar;
				$data['country_id'] = $main->country_id;
				$data['country_id_ar'] = $main->country_id_ar;
				$data['main_image'] = $main->image;
				$data['moq'] = $main->moq;
				$data['meta_title'] = $main->meta_title;
				$data['meta_description'] = $main->meta_description;
				$data['meta_keyword'] = $main->meta_keyword;

				$data['product_image'] = $this->Product_model->product_image($pid);
				$data['product_attribute'] = $this->Product_model->product_attribute($pid);
				$data['product_review'] = $this->Product_model->product_review($pid);
				$data['product_size'] = $this->Product_model->product_size($pid);
				$data['product_category'] = $this->Product_model->product_category($pid);
			}
			$data['categories'] = $this->Category_model->get_category();
			$data['brand_list'] = $this->Product_model->brand_list();
			$data['unit_list'] = $this->Product_model->unit_list();
			$data['country_list'] = $this->Product_model->country_list();
			$data['racks'] = $this->Product_model->get_racks();
			$data['shelfs'] = $this->Product_model->get_shelfs();
			//print_r($data['product_image']);exit();
			$this->session->set_userdata('info', "1--Successfully created duplicate product!");
			redirect('admin/product/add?id=' . $pid);
		} else {
			$this->session->set_userdata('info', "2--Something went wrong, try again!");
			redirect('admin/product/create_product');
		}
	}

	/*------ Get Rack and Shelf --------*/
	function getShelf()
	{
		$rack_id = $this->input->post("id");
		//$product_cat = $this->input->post("product_cat");
		$query = $this->Product_model->get_shelf_by_rack($rack_id);
		$data = '<option value="">Select Shelf</option>';
		foreach ($query as $shelf) {
			$data .= '<option value="' . $shelf['id'] . '">' . $shelf['shelf_name'] . '</option>';
		}
		echo $data;
	}

	function selectedShelf()
	{
		$rack_id = $this->input->post("id");
		$product_shelf = $this->input->post("shelf_id");
		$query = $this->Product_model->get_shelf_by_rack($rack_id);

		$data = '<option value="">Select Shelf</option>';
		foreach ($query as $shelf) {
			$data .= '<option value="' . $shelf['id'] . '" ' . (($shelf["id"] == $product_shelf) ? "selected" : "") . '>' . $shelf['shelf_name'] . '</option>';
		}
		//echo '<pre>'; print_r($data); echo '</pre>';
		echo $data;
	}

	/*------ Get Rack and Shelf End --------*/

	private function getIdBySku($sku)
	{
		$query = $this->db->query("SELECT id FROM product WHERE sku = '" . $sku . "'");
		if ($query->num_rows()) {
			$re = $query->row()->id;
		} else {
			$re = 0;
		}
		return $re;
	}

	public function imageUpload()
	{
		$this->load->view('admin/product/bulk_image');
	}

	public function imageUploadPost()
	{
		$config['upload_path']   = './products_image/';
		$config['allowed_types'] = 'gif|jpg|png|webp|jpeg';

		$this->load->library('upload', $config);
		$this->upload->do_upload('file');

		$image_data = $this->upload->data();

		print_r('Image Uploaded Successfully.');
	}

	public function soft_delete()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$query = $this->Product_model->soft_delete($this->input->post('check_list'));
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully deleted");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/product');
		} else {
			redirect('admin');
		}
	}

	public function permanent_delete()
	{
		if ($this->admin->isLogged()) {
			$query = $this->Product_model->permanent_delete($this->input->post('check_list'));
			if ($query) {
				$this->session->set_userdata('info', "1--Successfully deleted");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/product');
		} else {
			redirect('admin');
		}
	}

	public function restore_product()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'deleted_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			$query = $this->Product_model->restore_product($this->input->post('check_list'));
			if ($query) {
				$this->session->set_userdata('info', "1--Product successfully restored");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/product');
		} else {
			redirect('admin');
		}
	}

	public function setStatus()
	{
		$query = $this->Product_model->setStatus();
		if ($query) {
			$data = 'Status successfully changed.';
		} else {
			$data = 'Something went wrong, try again.';
		}
		echo $data;
	}

	public function setCOd()
	{
		$query = $this->Product_model->setCod();
		if ($query) {
			$data = 'COD successfully changed.';
		} else {
			$data = 'Something went wrong, try again.';
		}
		echo $data;
	}

	public function setB2B()
	{
		$query = $this->Product_model->setB2B();
		if ($query) {
			$data = 'B2B status successfully changed.';
		} else {
			$data = 'Something went wrong, try again.';
		}
		echo $data;
	}

	public function setStatusEnable()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			//$ids = implode(",", $this->input->post('check_list'));
			//echo '<pre>';print_r($this->input->post('check_list'));'</pre>';exit();
			$query = $this->Product_model->setStatusEnable($this->input->post('check_list'));
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/product');
		} else {
			redirect('admin');
		}
	}

	public function setStatusDisable()
	{
		if ($this->action && !check_action_permission(get_user_role(), 'manage_product', $this->action)) {
			redirect('admin/unauthorized-request');
		}
		if ($this->admin->isLogged()) {
			//$ids = implode(",", $this->input->post('check_list'));
			$query = $this->Product_model->setStatusDisable($this->input->post('check_list'));
			if ($query) {
				$this->session->set_userdata('info', "1--Status Successfully Updated");
			} else {
				$this->session->set_userdata('info', "2--Error");
			}
			redirect('admin/product');
		} else {
			redirect('admin');
		}
	}

	public function get_product()
	{
		$query = $this->Product_model->get_product($this->input->get('term'));
		$data = array();
		foreach ($query->result() as $query) {
			$data[] = array(
				"name" => $query->name,
				"product_id" => $query->id
			);
		}
		echo json_encode($data);
	}
	/*---- Old Code (Slow)
	public function get_list(){
		//echo '<pre>';print_r($_POST);exit();
		if($this->input->get('id')){
			$id = $this->input->get('id');
		}
		else{
			$id = FALSE;
		}
		$fetch_data = $this->Product_model->get_list($id);
        $data = array();
        $count = 1;
		foreach($fetch_data as $product){
			$size_id = $product['size_id'];
			$pro_id = $product['id'];
			$sub_array = array();
			$sub_array[] = $count++;
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$product['id'].'" />';
			$sub_array[] = '<span>Parent: '. $product['parent_sku'] .'<br/>Child: '. $product['parent_sku'] .'-'. $product['product_sku'] .'</span>';
			$sub_array[] = !empty($product['image']) ? '<div class="product-desc"><img class="avatar-sm" src="'.base_url().$product['image'].'" width="80px" /> <span class="ms-2">'.$product['name'].'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2">'.$product['name'].'</span></div>';
			$sub_array[] = $product['size'] .' '.$product['unit_name'];
			$sub_array[] = $product['price'];
			$cod = ($product['cod_available']) == '1' ? "checked":"";
			$sub_array[] = '<div><input type="checkbox" id="switchc'.$size_id.'" switch="bool" onclick="changeCod('. $product['id'] .', '. $size_id .')" name="cod_available" '. $cod .'/><label for="switchc'.$size_id.'" data-on-label="Yes" data-off-label="No"></label></div>';
			$status = ($product['status']) == '1' ? "checked":"";
			$sub_array[] = '<div><input type="checkbox" id="switchs'.$size_id.'" class="setStatus" switch="bool" onclick="changeStatus('. $product['id'] .', '. $size_id .')" name="status" '. $status .'/><label for="switchs'.$size_id.'" data-on-label="Yes" data-off-label="No"></label></div>';
			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/product/add?id='.$product['id'].'"><i class="mdi mdi-eye-outline font-size-18"></i></a>
			<div class="dropdown d-inline-block">
				<a class="btn btn-custom-light btn-sm edit dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="mdi mdi-dots-vertical ml-2 font-size-18"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="'.base_url().'admin/product/add?id='.$product['id'].'"><i class="mdi mdi-square-edit-outline font-size-18"></i> Edit</a>
					<a class="dropdown-item" href="#"><i class="mdi mdi-content-copy font-size-18"></i> Duplicate</a>
				</div>
			</div>';
			$data[] = $sub_array;  
			//<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/product/add?cid='.$product['id'].'"><i class="fa fa-files"></i></a>
		}
		$output = array(  
			"draw"  =>  intval($_POST["draw"]),  
			"recordsTotal" => $this->Product_model->get_all_data(),  
			"recordsFiltered"=> $this->Product_model->get_filtered_data(),  
			"data" => $data  
		);
		echo json_encode($output);
	}
	*/

	public function get_list()
	{
		//echo '<pre>';print_r($this->input->get('status'));exit();'</pre>';
		if (!empty($this->input->get('keyword'))) {
			$keyword = $this->input->get('keyword');
		} else {
			$keyword = FALSE;
		}
		if (!empty($this->input->get('barcode'))) {
			$barcode = $this->input->get('barcode');
		} else {
			$barcode = FALSE;
		}
		if (!empty($this->input->get('category_id'))) {
			$cat_id = $this->input->get('category_id');
		} else {
			$cat_id = FALSE;
		}
		if (!empty($this->input->get('brand'))) {
			$brand = $this->input->get('brand');
		} else {
			$brand = FALSE;
		}
		if (!empty($this->input->get('status'))) {
			$status = $this->input->get('status');
		} else {
			$status = FALSE;
		}
		if (!empty($this->input->get('cod'))) {
			$cod = $this->input->get('cod');
		} else {
			$cod = FALSE;
		}
		if (!empty($this->input->get('btob'))) {
			$btob = $this->input->get('btob');
		} else {
			$btob = FALSE;
		}
		if (!empty($this->input->get('from'))) {
			$from = $this->input->get('from');
		} else {
			$from = FALSE;
		}
		if (!empty($this->input->get('to'))) {
			$to = $this->input->get('to');
		} else {
			$to = FALSE;
		}
		$fetch_data = $this->Product_model->get_list($keyword, $barcode, $cat_id, $cod, $brand, $status, $from, $to, $btob);
		//echo '<pre>';print_r($fetch_data);exit();'</pre>';
		$i = $_POST['start'] + 1;
		$data = array();
		foreach ($fetch_data as $product) {
			//$size_id = $product['size_id'];
			$pro_id = $product->id;
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $product->id . '" />';
			$sub_array[] = '<span>Parent: <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Quick View" onClick="quickView(' . $product->id . ')" href="javascript:;">' . $product->parent_sku;
			'</a></span>';

			$sub_array[] = !empty($product->image) ? '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . $product->image . '" width="80px" /> <span class="ms-2">' . $product->name . '<br><pre>' . $product->name_ar . '</pre>' . '</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . 'images/notfound.jpg" width="80px" /> <span class="ms-2">' . $product->name . '<br><pre>' . $product->name_ar . '</pre></span></div>';

			$cod = ($product->cod_available) == '1' ? "checked" : "";
			$sub_array[] = '<div><input type="checkbox" id="switchc' . $pro_id . '" switch="bool" onclick="changeCod(' . $product->id . ', ' . $pro_id . ')" name="cod_available" ' . $cod . '/><label for="switchc' . $pro_id . '" data-on-label="Yes" data-off-label="No"></label></div>';

			$b2b = ($product->b2b_availability) == 'yes' ? "checked" : "";
			$sub_array[] = '<div><input type="checkbox" id="switchb' . $pro_id . '" switch="bool" onclick="changeB2b(' . $product->id . ', ' . $pro_id . ')" name="b2b_availability" ' . $b2b . '/><label for="switchb' . $pro_id . '" data-on-label="Yes" data-off-label="No"></label></div>';

			$sel_status = ($product->status) == '1' ? "checked" : "";
			$sub_array[] = '<div><input type="checkbox" id="switchs' . $pro_id . '" class="setStatus" switch="bool" onclick="changeStatus(' . $product->id . ', ' . $pro_id . ')" name="status" ' . $sel_status . '/><label for="switchs' . $pro_id . '" data-on-label="Yes" data-off-label="No"></label></div>';

			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Copy" onclick="return confirm(\'Are you sure want to create duplicate product?\')" href="' . base_url() . 'admin/product/copy?id=' . $product->id . '"><i class="mdi mdi-content-duplicate font-size-18"></i></a> 
			<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/product/add?id=' . $product->id . '"><i class="mdi mdi-pencil font-size-18"></i></a>';
			$data[] = $sub_array;
			//<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/product/add?cid='.$product['id'].'"><i class="fa fa-files"></i></a>

		}
		$output = array(
			"draw"                =>     intval($_POST["draw"]),
			"recordsTotal"        =>     $this->Product_model->get_all_data(),
			"recordsFiltered"     =>     $this->Product_model->get_filtered_data($keyword, $barcode, $cat_id, $cod, $brand, $status, $from, $to, $btob),
			"data"                =>     $data
		);
		echo json_encode($output);
	}

	/*------ Filtered Product ------*/

	public function get_product_list()
	{
		/* echo '<pre>';print_r($_POST);exit(); */
		if ($this->input->get('keyword')) {
			$keyword = $this->input->get('keyword');
			$value = $this->input->get('value');
		} else {
			$keyword = '';
			$value = '';
		}
		$fetch_data = $this->Product_model->get_filter_products($keyword, $value);
		$data = array();
		$count = $_POST['start'] + 1;
		foreach ($fetch_data as $product) {
			//$size_id = $product['size_id'];
			$pro_id = $product['id'];
			$sub_array = array();
			$sub_array[] = $count++;
			$sub_array[] = ' <input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="' . $product['id'] . '" />';
			$sub_array[] = '<span>Parent: <a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Quick View" onClick="quickView(' . $product['id'] . ')" href="javascript:;">' . $product['parent_sku'];
			'</a></span>';
			$sub_array[] = !empty($product['image']) ? '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . $product['image'] . '" width="80px" /> <span class="ms-2">' . $product['name'] . '<br><pre style="direction: rtl;">' . $product['name_ar'] . '</pre>' . '</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="' . base_url() . 'images/notfound.jpg" width="80px" /> <span class="ms-2">' . $product['name'] . '<br><pre style="direction: rtl;">' . $product['name_ar'] . '</pre></span></div>';

			$cod = ($product['cod_available']) == '1' ? "checked" : "";
			$sub_array[] = '<div><input type="checkbox" id="switchc' . $pro_id . '" switch="bool" onclick="changeCod(' . $product['id'] . ', ' . $pro_id . ')" name="cod_available" ' . $cod . '/><label for="switchc' . $pro_id . '" data-on-label="Yes" data-off-label="No"></label></div>';

			$b2b = ($product['b2b_availability']) == 'yes' ? "checked" : "";
			$sub_array[] = '<div><input type="checkbox" id="switchb' . $pro_id . '" switch="bool" onclick="changeB2b(' . $product['id'] . ', ' . $pro_id . ')" name="b2b_availability" ' . $b2b . '/><label for="switchb' . $pro_id . '" data-on-label="Yes" data-off-label="No"></label></div>';

			$status = ($product['status']) == '1' ? "checked" : "";
			$sub_array[] = '<div><input type="checkbox" id="switchs' . $pro_id . '" class="setStatus" switch="bool" onclick="changeStatus(' . $product['id'] . ', ' . $pro_id . ')" name="status" ' . $status . '/><label for="switchs' . $pro_id . '" data-on-label="Yes" data-off-label="No"></label></div>';

			$sub_array[] = '<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Copy" onclick="return confirm(\'Are you sure want to create duplicate product?\')" href="' . base_url() . 'admin/product/copy?id=' . $product['id'] . '"><i class="mdi mdi-content-duplicate font-size-18"></i></a> 
			<a class="btn btn-outline-secondary btn-custom-light btn-sm edit" data-toggle="tooltip" title="Edit" href="' . base_url() . 'admin/product/add?id=' . $product['id'] . '"><i class="mdi mdi-pencil font-size-18"></i></a>';
			$data[] = $sub_array;
			//<a class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" href="'.base_url().'admin/product/add?cid='.$product['id'].'"><i class="fa fa-files"></i></a>
		}
		$output = array(
			"draw"  =>  intval($_POST["draw"]),
			"recordsTotal" => $this->Product_model->get_all_product($keyword, $value),
			"recordsFiltered" => $this->Product_model->get_filtered_product($keyword, $value),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function checkSKU()
	{
		$sku = $this->input->get('parent_sku');
		$query = $this->db->query("SELECT id FROM product WHERE parent_sku = '" . $sku . "'");
		if ($query->num_rows()) {
			echo "<span style='color:red;'>This SKU already exists. Try new SKU</span>";
		} else {
			echo "<span style='color:green;'>Available.</span>";
		}
	}

	public function checkSEO()
	{
		$seo = $this->input->get('seo');
		if ($seo !== '') {
			$query = $this->db->query("SELECT id FROM product WHERE seo = '" . $seo . "'");
			if ($query->num_rows()) {
				echo "<span style='color:red;'>This SEO URL already exists. Use unique url.</span>";
			} else {
				echo "<span style='color:green;'>Available.</span>";
			}
		} else {
			echo "<span style='color:red;'>This field is required.</span>";
		}
	}

	public function delete_size()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('id', 'Size ID', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array("type" => 'error', "message" => validation_errors());
			} else {
				$query = $this->Product_model->delete_sizebyid();
				if ($query) {
					$data = array("type" => 'success', "message" => 'Size successfully deleted');
				} else {
					$data = array("type" => 'error', "message" => 'Something went wrong, Try again');
				}
			}
		} else {
			$data = array("type" => 'error', "message" => 'Session expired, Please login again. <a href="' . base_url('admin') . '" class="text-danger"> Login</a>');
		}
		//echo '<pre>';print_r($data);exit();
		echo json_encode($data);
		//echo $data;
	}

	function getSubCategory()
	{
		$parent_id = $this->input->post("parent_id");
		$query = $this->Product_model->getSubCategory($parent_id);
		$data = '<option value="">Choose sub category</option>';
		foreach ($query->result() as $query) {
			$data .= '<option value="' . $query->category_id . '">' . $query->name . '</option>';
		}
		echo $data;
	}

	function getSubSubCategory()
	{
		$parent_id = $this->input->post("parent_id");
		$query = $this->Product_model->getSubCategory($parent_id);
		$data = '<option value="">Choose sub category</option>';
		foreach ($query->result() as $query) {
			$data .= '<option value="' . $query->category_id . '">' . $query->name . '</option>';
		}
		echo $data;
	}

	function out_of_stock()
	{
		$data['category'] = $this->Category_model->get_category();
		$data['parent'] = $this->Product_model->get_parent_category();
		$data['result'] = $this->Product_model->get_out_of_stock();
		$this->load->view('admin/product/out_of_stock_list', $data);
	}

	public function manageStock()
	{
		//$product= $this->Product_model->getProductSearch($_GET['status']);
		//echo json_encode($product);
		$this->load->view('admin/product/manage_stock');
	}

	public function managestock_ajax()
	{
		$term = $this->input->post("term");
		$product['result'] = $this->Product_model->getProductSearch($term);
		$data = $this->load->view("admin/product/manage_stock_ajax", $product, true);
		echo $data;
	}

	public function updateStock()
	{
		$query = $this->Product_model->updateStock();
		if ($query) {
			$this->session->set_userdata('info', "1--Stock Successfully Updated");
		} else {
			$this->session->set_userdata('danger', "2--Error");
		}
		redirect('admin/product/manageStock');
	}

	public function purchaseProducts()
	{
		$data['results'] = $this->Product_model->get_purchase_order();
		//print_r($data);exit();
		$this->load->view('admin/product/purchase_list', $data);
	}

	public function quick_view()
	{
		$prod_id = $this->input->post("id");
		$main = $this->Product_model->mainProduct($prod_id);
		//$query = $this->Product_model->singleProduct($tid);
		if ($main) {
			$data['prod_id'] = $main->id;
			$data['brand_id'] = $main->brand_id;
			$data['parent_sku'] = $main->parent_sku;
			$data['is_variation'] = $main->is_variation;
			$data['status'] = $main->status;
			$data['cod_available'] = $main->cod_available;
			$data['is_deleted'] = $main->is_deleted;
			$data['main_category'] = $main->main_category;
			$data['brand_name'] = $main->brand_name;
			$data['main_cat_name'] = $main->main_cat_name;
			//$data['product_id'] = $main->product_id;
			$data['name'] = $main->name;
			$data['name_ar'] = $main->name_ar;
			$data['description'] = $main->description;
			$data['description_ar'] = $main->description_ar;
			$data['country_id'] = $main->country_id;
			$data['country_id_ar'] = $main->country_id_ar;
			$data['main_image'] = $main->image;
			$data['moq'] = $main->moq;
			$data['meta_title'] = $main->meta_title;
			$data['meta_description'] = $main->meta_description;
			$data['meta_keyword'] = $main->meta_keyword;
		}
		$data['product_size'] = $this->Product_model->product_size($prod_id);
		$data['unit_list'] = $this->Product_model->unit_list();
		$data['country_list'] = $this->Product_model->country_list();
		$data['racks'] = $this->Product_model->get_racks();
		$data['shelfs'] = $this->Product_model->get_shelfs();
		$result = $this->load->view('admin/product/quick-view', $data, TRUE);
		//echo '<pre>';print_r($data);exit();
		//echo json_encode($data);
		echo $result;
	}

	public function update_size()
	{
		if ($this->admin->isLogged()) {
			$this->form_validation->set_rules('product_id', 'Product ID', 'trim|required');
			$this->form_validation->set_rules('size_id[]', 'Size ID', 'trim|required');
			//$this->form_validation->set_rules('size[]', 'Product Size', 'trim|required');
			//$this->form_validation->set_rules('size_unit[]', 'Size Unit', 'trim|required');
			$this->form_validation->set_rules('price[]', 'Product price', 'trim|required');
			//$this->form_validation->set_rules('product_sku[]', 'Product SKU', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_userdata('info', "2--" . validation_errors());
			} else {
				//print_r($this->input->post());exit();
				if ($this->input->post('product_id')) {
					$query = $this->Product_model->update_size();
					if ($query) {
						$this->session->set_userdata('info', "1--Successfully Updated");
					} else {
						$this->session->set_userdata('info', "2--Error!!!");
					}
				} else {
					$this->session->set_userdata('info', "2--Product not valid!!!");
				}
			}
			redirect('admin/product');
		} else {
			redirect('admin');
		}
	}
}
