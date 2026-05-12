<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model{
    
    function get_products_detail(){
    	$size_id = $this->input->post('id');
    	$this->db->select('s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku, p.status');
    	$this->db->from('product_size s');
    	$this->db->join('product p', 's.product_id = p.id', 'left');
    	$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
    	$this->db->where('s.id', $size_id);
    	$this->db->where('p.status', 1);
    	$query = $this->db->get();
    	return $query;
    }
    
    function get_category(){
    	$data = array();
    	$parent_categories = $this->db->query("select id, parent_id, name, arabic_name, status FROM category WHERE parent_id = '0' AND status = '1' ORDER BY name");
    	foreach($parent_categories->result() as $parent_category){
    		$child = array();
    		$child_categories = $this->db->query("select id, name, arabic_name, parent_id, status FROM category WHERE parent_id = '" . (int)$parent_category->id . "' AND status = '1' ORDER BY name");
    		foreach($child_categories->result() as $child_category){
    			$sub_child = $this->db->query("select id, arabic_name, name, status FROM category WHERE parent_id = '" . (int)$child_category->id . "' AND status = '1' ORDER BY name")->result_array();
    			$child[] = array("id" => $child_category->id,
    							 "name" => $child_category->name,
    							 "arabic_name" => $child_category->arabic_name,
    							 "status" => $child_category->status,
    							 "child" => $sub_child);
    		}
    	$data[] = array("id" => $parent_category->id,
    					"name" => $parent_category->name,
    					"arabic_name" => $parent_category->arabic_name,
    					"status" => $parent_category->status,
    					"child" => $child);
    	}
    	return $data;
    }
    
    function brand_list(){
    	$query = $this->db->query("SELECT * FROM master_brands WHERE deleted = '0' AND status = '1' ORDER BY brand_name ASC")->result();
    	return $query;
    }
    
    function get_list($keyword,$barcode,$cat_id,$brand){
    	
    	$this->db->select('s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku, p.status');
    	$this->db->from('product_size s');
    	// $this->db->where_not_in('store_inventory.product_id','s.product_id');
    	
    	if($keyword){
    	    $this->db->or_like('p.name', $this->db->escape_str($keyword));
    	}
    	if($barcode){
    	    $this->db->where('s.barcode', $this->db->escape_str($barcode));
    	}
    	if($cat_id){
    	    $this->db->where('p.main_category', $this->db->escape_str($cat_id));
    	}
    	if($brand){
    	    $this->db->where('p.brand_id', $this->db->escape_str($brand));
    	}
    	$this->db->where('p.status', 1);
    	$this->db->join('product p', 's.product_id = p.id', 'left');
    	$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
    	$query = $this->db->get()->result();
    	
    	//print_r($this->db->last_query());exit();
    	
    	return $query;
    }
    
    function isProductExist($product_id,$size_id){
    	$query=$this->db->query("select id FROM store_inventory WHERE product_id = '".$product_id."' AND size_id = '".$size_id."'");
    	return $query->num_rows();
    }
    
    function addinventory($product_id,$size_id)
    {
        $this->db->trans_start();
    	$query = $this->db->query("INSERT INTO store_inventory (product_id, size_id, store_id, quantity, rack_id, shelves_id, status)VALUES ('". $product_id ."', '". $size_id ."', '". (int)$this->store->getId() ."', '".$this->input->post('quantity')."', '".$this->input->post('rack_id')."', '".$this->input->post('shelf_id')."','1')");
    	if($query){
    	    $this->db->query("INSERT INTO store_inventory_log (product_id, size_id, store_id, quantity, status, comments, created_at)VALUES ('". $product_id ."', '". $size_id ."', '". (int)$this->store->getId() ."', '".$this->input->post('quantity')."', 'Stock In', 'New product added to store','". CURRENT_TIME ."')");
    	}
    	$this->db->trans_complete();
        return $query;
    }
    
    function allproduct()
    {
    	$this->db->select('i.*,s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name , p.name_ar, p.image, p.parent_sku');
    	$this->db->from('store_inventory i');
    	$this->db->where('i.status','1');
    	$this->db->join('product p', 'i.product_id = p.id', 'left');
    	$this->db->join('product_size s', 'i.product_id = s.product_id', 'left');
    	$this->db->join('master_unit mu', 's.size_unit = mu.id', 'left');
    	$query = $this->db->get()->result();
    	return $query;
    	
    }
    
    /*----- Rack Shelf ------*/
	function get_racks(){
		$query = $this->db->query("SELECT id,rack_name,store_id FROM store_rack WHERE status = 1 AND deleted = 0 AND store_id = '". (int)$this->store->getId() ."'");
		return $query->result_array();
	}
	
	function get_shelfs(){
		$query = $this->db->query("SELECT id,shelf_name,store_id FROM store_shelf WHERE status = 1 AND deleted = 0 AND store_id = '". (int)$this->store->getId() ."'");
		return $query->result_array();
	}
	
	function get_shelf_by_rack($rack_id){
		$query = $this->db->query("SELECT id,shelf_name,store_id FROM store_shelf WHERE rack_id = '" . (int)$rack_id . "' AND store_id = '". (int)$this->store->getId() ."'");
		return $query->result_array();
	}
	
	/*----- Manage Product -----*/
	
	function store_product_query($keyword,$barcode,$cat_id,$brand,$from,$to,$status){
		$a = "SELECT si.id, si.quantity, si.rack_id, si.shelves_id, si.status, si.created_at, s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name, p.name_ar, p.image, p.parent_sku,p.main_category,p.brand_id FROM store_inventory si LEFT JOIN product_size s ON (si.size_id = s.id) LEFT JOIN product p ON (si.product_id = p.id) LEFT JOIN master_unit mu ON (s.size_unit = mu.id) WHERE si.store_id = '". (int)$this->store->getId() ."'";
		if($keyword) {
			$a .= " AND (p.name LIKE '%".$keyword."%' OR p.name_ar LIKE '%".$keyword."%' OR p.parent_sku LIKE '%".$keyword."%')";
        }
		
		if($barcode) {
			$a .= " AND s.barcode = '" . $barcode . "'";
        }

		if($from AND $to){
			$v_from = $from;
			$v_to = $to;
			$d_to = date("Y-m-d", strtotime($v_to . ' +1 day'));
			if($v_from AND $v_to){
				$a .= " AND (si.created_at BETWEEN '". date("Y-m-d", strtotime($this->input->get('from'))) ."' AND '". $d_to ."')";
			}
		}

		if($cat_id) {
			$a .= " AND p.main_category = '" . $cat_id . "'";
        }

		if($brand) {
			$a .= " AND p.brand_id = '" . $brand . "'";
        }
        if($status){
			if($status == 'yes'){
				$a .= " AND status = '1'";
			}else{
				$a .= " AND status = '0'";
			}
		}
		return $a;
	}
	
	function get_store_product_list($keyword,$barcode,$cat_id,$brand,$from,$to,$status){
		$a = $this->store_product_query($keyword,$barcode,$cat_id,$brand,$from,$to,$status);

		// if(isset($_POST["search"]["value"])){
		// 	$a .= " AND cv.first_name LIKE '%".$_POST["search"]["value"]."%' OR cv.mobile LIKE '%".$_POST["search"]["value"]."%' OR cv.email LIKE '%".$_POST["search"]["value"]."%' OR pos.name LIKE '%".$_POST["search"]["value"]."%'";
		// }
		if(isset($_POST["order"])){             
			$a .= " ORDER BY si.id DESC";
		}  
        else{  
			$a .= " ORDER BY si.id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_store_product($keyword,$barcode,$cat_id,$brand,$from,$to,$status){
	   	$a = $this->store_product_query($keyword,$barcode,$cat_id,$brand,$from,$to,$status);
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_store_product(){
	   $this->db->select("*");  
	   $this->db->from('store_inventory');  
	   $this->db->where('store_id', (int)$this->store->getId());
	   return $this->db->count_all_results();
    }
    
    public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE store_inventory SET status = '1', updated_at = '". CURRENT_TIME ."' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE store_inventory SET status = '0', updated_at = '". CURRENT_TIME ."' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	function store_product_detail($id){
		$query = $this->db->query("SELECT si.id, si.quantity, si.rack_id, si.shelves_id, si.status, si.created_at, s.id as size_id, s.product_id, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.id as prod_id, p.name, p.name_ar, p.image, p.parent_sku,p.main_category,p.brand_id FROM store_inventory si LEFT JOIN product_size s ON (si.size_id = s.id) LEFT JOIN product p ON (si.product_id = p.id) LEFT JOIN master_unit mu ON (s.size_unit = mu.id) WHERE si.id = '". $id ."' AND si.store_id = '". (int)$this->store->getId() ."'");  
        return $query; 
	}
	
	function update_store_inventory(){
    	$query = $this->db->query("UPDATE store_inventory SET rack_id = '". $this->input->post('rack_id') ."', shelves_id = '". $this->input->post('shelf_id') ."' WHERE id = '" . $this->input->post('invntory_id') . "' LIMIT 1");
    	return $query;
    }
	
    function delete($id){
    	$query = $this->db->query("UPDATE store_inventory SET status = 0   WHERE id IN (" . $id . ")");
    	return $query;
    }
    
    function stock_out(){
        $quantity = $this->input->post('quantity');
        $inv_id = $this->input->post('inv_id');
        $remarks = $this->input->post('remarks');
        $stock_type = 'out';
        $update_query = FALSE;
		if($quantity > 0 && $inv_id > 0){
            $this->db->trans_start();
			$query = $this->db->query("SELECT * FROM store_inventory WHERE id = '" . (int)$inv_id . "' AND store_id = '". (int)$this->store->getId() ."'");
			if($query->num_rows() > 0){
			    $inv_detail = $query->row();
			    $previous_qty = $inv_detail->quantity;
    			$current_qty = $previous_qty - $quantity;
    			$update_query = $this->db->query("UPDATE store_inventory SET quantity =  '" . $current_qty . "', updated_at = '". CURRENT_TIME ."' WHERE id = '" . (int)$inv_id . "' AND store_id = '". (int)$this->store->getId() ."'");
                $update_query2 = $this->db->query("INSERT INTO store_inventory_log SET product_id =  '" . $inv_detail->product_id . "', size_id =  '" . $inv_detail->size_id . "', quantity =  '" . $quantity . "', store_id = '". (int)$this->store->getId() ."', status =  'out', comments =  'Stock Updated - Stock Out', remarks =  '" . $remarks . "', created_at = NOW()");
			}else{
			    return false;
			}
            $this->db->trans_complete();
		}
		return $update_query;
	}
	
	function stock_in(){
        $quantity = $this->input->post('quantity');
        $inv_id = $this->input->post('inv_id');
        $remarks = $this->input->post('remarks');
        $stock_type = 'in';
        $update_query = FALSE;
		if($quantity > 0 && $inv_id > 0){
            $this->db->trans_start();
			$query = $this->db->query("SELECT * FROM store_inventory WHERE id = '" . (int)$inv_id . "' AND store_id = '". (int)$this->store->getId() ."'");
			if($query->num_rows() > 0){
			    $inv_detail = $query->row();
			    $previous_qty = $inv_detail->quantity;
    			$current_qty = $previous_qty + $quantity;
    			$update_query = $this->db->query("UPDATE store_inventory SET quantity =  '" . $current_qty . "', updated_at = '". CURRENT_TIME ."' WHERE id = '" . (int)$inv_id . "' AND store_id = '". (int)$this->store->getId() ."'");
                $update_query2 = $this->db->query("INSERT INTO store_inventory_log SET product_id =  '" . $inv_detail->product_id . "', size_id =  '" . $inv_detail->size_id . "', quantity =  '" . $quantity . "', store_id = '". (int)$this->store->getId() ."', status =  'in', comments =  'Stock Updated - Stock In', remarks =  '" . $remarks . "', created_at = NOW()");
			}else{
			    return false;
			}
            $this->db->trans_complete();
		}
		return $update_query;
	}
	
	/*----- Inventory Logs -----*/
	
	function query_inventory_logs(){
		$a = "SELECT slg.*, s.size, s.size_unit, s.barcode, s.product_sku, s.seller_sku, mu.unit_name, p.name, p.name_ar, p.image, p.parent_sku,p.main_category,p.brand_id FROM store_inventory_log slg LEFT JOIN product_size s ON (slg.size_id = s.id) LEFT JOIN product p ON (slg.product_id = p.id) LEFT JOIN master_unit mu ON (s.size_unit = mu.id) WHERE slg.store_id = '". (int)$this->store->getId() ."'";
		return $a;
	}
	
	function get_inventory_logs(){
		$a = $this->query_inventory_logs();

		if(isset($_POST["search"]["value"])){
			$a .= " AND p.name LIKE '%".$_POST["search"]["value"]."%' OR s.barcode LIKE '%".$_POST["search"]["value"]."%' OR p.parent_sku LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY slg.id DESC";
		}  
        else{  
			$a .= " ORDER BY slg.id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }               
        $query = $this->db->query($a);  
        return $query->result();  
    }

    function get_filtered_get_inventory_logs(){
	   	$a = $this->query_inventory_logs();
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_get_inventory_logs(){
	   $this->db->select("*");  
	   $this->db->from('store_inventory_log');  
	   $this->db->where('store_id', (int)$this->store->getId());
	   return $this->db->count_all_results();
    }
	
}
