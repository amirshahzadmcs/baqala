<?php defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryController extends CI_Controller {

	public function __construct() {
		parent::__construct();
		

		if($this->store->isLogged()){
			$this->load->model('store/Inventory_model');
			$this->load->library('form_validation');
			$this->load->model('admin/Category_model');
			$this->load->model('admin/Product_model');
			$this->load->model('store/Account_model');
			$this->load->helper('store_helper');
		}
		else{
			 redirect('store/login');
		}
	}


	public function index()
	{
		if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		if(!empty($this->input->get()))
		{
			
			if(!empty($this->input->get('keyword'))){
				$keyword = $this->input->get('keyword');
			}
			else{
				$keyword = FALSE;
			}
			if(!empty($this->input->get('barcode'))){
				$barcode = $this->input->get('barcode');
			}
			else{
				$barcode = FALSE;
			}
			if(!empty($this->input->get('category_id'))){
				$cat_id = $this->input->get('category_id');
			}
			else{
				$cat_id = FALSE;
			}
			if(!empty($this->input->get('brand'))){
				$brand = $this->input->get('brand');
			}
			else{
				$brand = FALSE;
			}
			
			$data['productlist'] = $this->Inventory_model->get_list($keyword,$barcode,$cat_id,$brand);
			$data['searchingdata'] = [$keyword,$barcode,$cat_id,$brand];
			// echo"<pre>";
			// print_r($data['productlist']);
			// exit;
			//$data['sqlquery']=$this->db->query("Select * From store_inventory")->result();
				
		}
		$data['storedet'] = $this->Account_model->get_profile();
		$data['categories'] = $this->Inventory_model->get_category();
		$data['brand_list'] = $this->Inventory_model->brand_list();
		$this->load->view('stores/inventory/list',$data);
		
	}
	
	/*------ Get Rack and Shelf --------*/
	function getShelf(){
		$rack_id = $this->input->post("id");
		//$product_cat = $this->input->post("product_cat");
		$query = $this->Inventory_model->get_shelf_by_rack($rack_id);
		$data ='<option value="">Select Shelf</option>';
		foreach($query as $shelf){
			$data .= '<option value="' . $shelf['id'] . '">' . $shelf['shelf_name'] . '</option>';
		}
		echo $data;
	}
	
	function selectedShelf(){
		$rack_id = $this->input->post("id");
		$product_shelf = $this->input->post("shelf_id");
		$query = $this->Inventory_model->get_shelf_by_rack($rack_id);
		
		$data ='<option value="">Select Shelf</option>';
		foreach($query as $shelf){
			$data .= '<option value="' . $shelf['id'] . '" '. (($shelf["id"] == $product_shelf) ? "selected":"") .'>' . $shelf['shelf_name'] . '</option>';
		}
		//echo '<pre>'; print_r($data); echo '</pre>';
		echo $data;
	}
	
	/*------ Get Rack and Shelf End --------*/
	
	public function addproductmodal()
    {
		$this->form_validation->set_rules('id', 'Product ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			echo '<div class="modal-body"><div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid request!</strong></div></div>';exit();
		}
		else{
			$prod_detail = $this->Inventory_model->get_products_detail();
			if($prod_detail->num_rows() > 0){
				$data['quick_detail'] = $prod_detail->row();
				$data['racks'] = $this->Inventory_model->get_racks();
    	        $data['shelfs'] = $this->Inventory_model->get_shelfs();
				$output_data = $this->load->view('stores/inventory/partials/add-inventory',$data,TRUE);
			}else{
				$output_data = '<div class="modal-body"><h6 class="text-center">No data found</h6></div>';
			}
			
			//echo '<pre>';print_r($data);exit();
			//echo json_encode($data);
			echo $output_data;
		}
    }
    
	public function addproduct()
	{
	    $this->form_validation->set_rules('id', 'Product ID', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_userdata('info', "2--".validation_errors());
		}
		else{
			$prod_detail = $this->Inventory_model->get_products_detail();
			if($prod_detail->num_rows() > 0){
			    $prod_info = $prod_detail->row();
			    $product_id = $prod_info->prod_id;
			    $size_id = $prod_info->size_id;
			    $inv_prod = $this->Inventory_model->isProductExist($product_id,$size_id);
			    if($inv_prod > 0){
    				$this->session->set_userdata('info', "2--Already exist in store!!!");
			    }else{
			        $query = $this->Inventory_model->addinventory($product_id,$size_id);
    				if($query){
    					$this->session->set_userdata('info', "1--Successfully added");
    				}
    				else{
    					$this->session->set_userdata('info', "2--Error!!!");
    				}
			    }
			}else{
				$this->session->set_userdata('info', "2--Product does not available!!!");
			}
		}
		redirect('store/inventory');
	}
	
	/*---- Manage Inventory ----*/
	
	public function inventory_manage()
	{
	    if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		
		$data['categories'] = $this->Inventory_model->get_category();
		$data['brand_list'] = $this->Inventory_model->brand_list();
		$this->load->view('stores/inventory/manageinventory',$data);
	}

	public function get_store_product(){
	    if(!empty($this->input->get('keyword'))){
			$keyword = $this->input->get('keyword');
		}
		else{
			$keyword = FALSE;
		}
		if(!empty($this->input->get('barcode'))){
			$barcode = $this->input->get('barcode');
		}
		else{
			$barcode = FALSE;
		}
		if(!empty($this->input->get('category_id'))){
			$cat_id = $this->input->get('category_id');
		}
		else{
			$cat_id = FALSE;
		}
		if(!empty($this->input->get('brand'))){
			$brand = $this->input->get('brand');
		}
		else{
			$brand = FALSE;
		}
		if(!empty($this->input->get('from'))){
			$from = $this->input->get('from');
		}
		else{
			$from = FALSE;
		}
		if(!empty($this->input->get('to'))){
			$to = $this->input->get('to');
		}
		else{
			$to = FALSE;
		}
		if(!empty($this->input->get('status'))){
			$status = $this->input->get('status');
		}
		else{
			$status = FALSE;
		}
		$fetch_data = $this->Inventory_model->get_store_product_list($keyword,$barcode,$cat_id,$brand,$from,$to,$status);
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = '<input type="checkbox" name="check_list[]" id="checkbox" class="checkbox" value="'.$key_data->id.'" />';
			$sub_array[] = $i++;
			$sub_array[] = $key_data->parent_sku.'-'.$key_data->product_sku;
			$sub_array[] = $key_data->barcode;
			$sub_array[] = !empty($key_data->image) ? '<div class="product-desc"><a class="image-popup-vertical-fit" href="'.$key_data->image.'" title="'.$key_data->name.'" target="_blank"><img class="avatar-sm" src="'.base_url().$key_data->image.'" width="80px" /></a> <span class="ms-2 w-100">'.$key_data->name.'<br><pre>'. $key_data->name_ar .'</pre>'.'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2 w-100">'.$key_data->name.'<br><pre>'. $key_data->name_ar .'</pre></span></div>';
			$sub_array[] = $key_data->size .' '. $key_data->unit_name;
			$sub_array[] = $key_data->quantity;
			$sub_array[] = getRackName($key_data->rack_id);
			$sub_array[] = getShelfName($key_data->shelves_id);
			$sub_array[] = $key_data->status == 1 ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>';
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			$sub_array[] = '<button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Edit" onclick="editProduct('. $key_data->id .')"><i class="mdi mdi-pencil font-size-18"></i></button> <button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Detail" onclick="productDetail('. $key_data->id .')"><i class="mdi mdi-stretch-to-page-outline font-size-18"></i></button> <button type="button" class="btn btn-outline-secondary btn-custom-light btn-sm edit" title="Stock Update" onclick="stockUpdate('. $key_data->id .')"><i class="mdi mdi-database-edit-outline font-size-18"></i></button>';
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Inventory_model->get_all_store_product(),  
			"recordsFiltered"     =>     $this->Inventory_model->get_filtered_store_product($keyword,$barcode,$cat_id,$brand,$from,$to,$status),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
	public function setStatusEnable(){
		$query = $this->Inventory_model->setStatusEnable($this->input->post('check_list'));
		if($query){
			$this->session->set_userdata('info', "1--Status Successfully Updated");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('store/inventory/manage-inventory');
	}
	
	public function setStatusDisable(){
		$query = $this->Inventory_model->setStatusDisable($this->input->post('check_list'));
		if($query){
			$this->session->set_userdata('info', "1--Status Successfully Updated");
		}
		else{
			$this->session->set_userdata('info', "2--Error");
		}
		redirect('store/inventory/manage-inventory');
	}
	
	public function productremove(){
		$id = implode(',',$this->input->post('check_list'));
		$query = $this->Inventory_model->delete($id);
		if($query){
			$this->session->set_userdata('info', "1--Successfully deleted");
		}
		else{
			$this->session->set_userdata('info', "2--Error!!!");
		}
		redirect('store/inventory/manage-inventory');
	}
	
	public function product_detail_modal()
    {
        if($this->store->isLogged()){
    		$this->form_validation->set_rules('id', 'Inventory ID', 'trim|required');
    		if($this->form_validation->run()==FALSE){
    			$msg = validation_errors();
    			echo '<div class="modal-body"><div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid request!</strong></div></div>';exit();
    		}
    		else{
    		    $inv_id = $this->input->post('id');
    			$prod_detail = $this->Inventory_model->store_product_detail($inv_id);
    			if($prod_detail->num_rows() > 0){
    				$data['quick_detail'] = $prod_detail->row();
    				$output_data = $this->load->view('stores/inventory/partials/inventory-detail',$data,TRUE);
    			}else{
    				$output_data = '<div class="modal-body"><h6 class="text-center">No data found</h6></div>';
    			}
    			
    			//echo '<pre>';print_r($data);exit();
    			//echo json_encode($data);
    			echo $output_data;
    		}
        }else{
            redirect('store/login');
        }
    }
    
    public function product_update_modal()
    {
        if($this->store->isLogged()){
    		$this->form_validation->set_rules('id', 'Inventory ID', 'trim|required');
    		if($this->form_validation->run()==FALSE){
    			$msg = validation_errors();
    			echo '<div class="modal-body"><div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid request!</strong></div></div>';exit();
    		}
    		else{
    		    $inv_id = $this->input->post('id');
    			$prod_detail = $this->Inventory_model->store_product_detail($inv_id);
    			if($prod_detail->num_rows() > 0){
    				$data['quick_detail'] = $prod_detail->row();
    				$data['racks'] = $this->Inventory_model->get_racks();
        	        $data['shelfs'] = $this->Inventory_model->get_shelfs();
    				$output_data = $this->load->view('stores/inventory/partials/edit-inventory',$data,TRUE);
    			}else{
    				$output_data = '<div class="modal-body"><h6 class="text-center">No data found</h6></div>';
    			}
    			
    			//echo '<pre>';print_r($data);exit();
    			//echo json_encode($data);
    			echo $output_data;
    		}
        }else{
            redirect('store/login');
        }
    }
    
    public function stock_update_modal()
    {
        if($this->store->isLogged()){
    		$this->form_validation->set_rules('id', 'Inventory ID', 'trim|required');
    		if($this->form_validation->run()==FALSE){
    			$msg = validation_errors();
    			echo '<div class="modal-body"><div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Invalid request!</strong></div></div>';exit();
    		}
    		else{
    		    $inv_id = $this->input->post('id');
    			$prod_detail = $this->Inventory_model->store_product_detail($inv_id);
    			if($prod_detail->num_rows() > 0){
    				$data['quick_detail'] = $prod_detail->row();
    				$output_data = $this->load->view('stores/inventory/partials/update-stock',$data,TRUE);
    			}else{
    				$output_data = '<div class="modal-body"><h6 class="text-center">No data found</h6></div>';
    			}
    			
    			//echo '<pre>';print_r($data);exit();
    			//echo json_encode($data);
    			echo $output_data;
    		}
        }else{
            redirect('store/login');
        }
    }
    
    public function store_product_update()
    {
        if($this->store->isLogged()){
    		$this->form_validation->set_rules('invntory_id', 'Inventory ID', 'trim|required');
    		$this->form_validation->set_rules('rack_id', 'Rack ID', 'trim|required');
    		$this->form_validation->set_rules('shelf_id', 'Shelf ID', 'trim|required');
    		if($this->form_validation->run()==FALSE){
    			$msg = validation_errors();
    			$this->session->set_userdata('info', "1--Invalid request");
    		}
    		else{
    		    $inv_id = $this->input->post('invntory_id');
    			$prod_detail = $this->Inventory_model->store_product_detail($inv_id);
    			if($prod_detail->num_rows() > 0){
    				$data['quick_detail'] = $prod_detail->row();
    				$query = $this->Inventory_model->update_store_inventory();
    				if($query){
    					$this->session->set_userdata('info', "1--Successfully added");
    				}
    				else{
    					$this->session->set_userdata('info', "2--Error when updating, try again!");
    				}
    			}else{
    				$this->session->set_userdata('info', "2--Something went wrong, try again");
    			}
    		}
    		redirect('store/inventory/manage-inventory');
        }else{
            redirect('store/login');
        }
    }
    
    public function update_stock(){
		$this->form_validation->set_rules('inv_id', 'Item Id', 'trim|required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required');
		$this->form_validation->set_rules('stock_type', 'Stock Type', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$msg = validation_errors();
			$this->session->set_userdata('info', '2--'.$msg);
		}
		else{
            if($this->input->post('stock_type') == 'in'){
                $query = $this->Inventory_model->stock_in();
                if($query){
                    $this->session->set_userdata('info', "1--Stock successfully In.");
                }else{
                    $this->session->set_userdata('info', "2--Error!!!");
                }
            }else{
                $query = $this->Inventory_model->stock_out();
                if($query){
                    $this->session->set_userdata('info', "1--Stock successfully Out.");
                }else{
                    $this->session->set_userdata('info', "2--Error!!!");
                }
            }
		}
		redirect('store/inventory/manage-inventory');
	}
	
	/*--- Inventory Logs ---*/
	public function inventory_logs()
	{
	    if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('stores/inventory/logs',$data);
	}

	public function inventory_logs_ajax(){
		$fetch_data = $this->Inventory_model->get_inventory_logs();
		$i = $_POST['start'] + 1 ;
		$data = array();  
		foreach($fetch_data as $key_data){
			$sub_array = array();
			$sub_array[] = $i++;
			$sub_array[] = $key_data->parent_sku.'-'.$key_data->product_sku;
			$sub_array[] = $key_data->barcode;
			$sub_array[] = !empty($key_data->image) ? '<div class="product-desc"><a class="image-popup-vertical-fit" href="'.$key_data->image.'" title="'.$key_data->name.'" target="_blank"><img class="avatar-sm" src="'.base_url().$key_data->image.'" width="80px" /></a> <span class="ms-2 w-100">'.$key_data->name.'<br><pre>'. $key_data->name_ar .'</pre>'.'</span></div>' : '<div class="product-desc"><img class="avatar-sm" src="'.base_url().'images/notfound.jpg" width="80px" /> <span class="ms-2 w-100">'.$key_data->name.'<br><pre>'. $key_data->name_ar .'</pre></span></div>';
			$sub_array[] = $key_data->size .' '. $key_data->unit_name;
			$sub_array[] = $key_data->quantity;
			$sub_array[] = $key_data->status == 'in' ? '<span class="badge badge-pill badge-soft-success font-size-13">Stock In</span>':'<span class="badge badge-pill badge-soft-danger font-size-13">Stock Out</span>';
			$sub_array[] = $key_data->comments;
			$sub_array[] = $key_data->remarks;
			$sub_array[] = date('d-m-Y h:i A', strtotime($key_data->created_at));
			
			$data[] = $sub_array;
		}						
		$output = array(  
			"draw"                =>     intval($_POST["draw"]),  
			"recordsTotal"        =>      $this->Inventory_model->get_all_get_inventory_logs(),  
			"recordsFiltered"     =>     $this->Inventory_model->get_filtered_get_inventory_logs(),  
			"data"                =>     $data  
		);  
		echo json_encode($output);
	}
	
}
