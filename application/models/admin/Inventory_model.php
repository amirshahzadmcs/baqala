<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_model extends CI_Model{
	
	function updateStock($id){
		$query = $this->db->query("SELECT * FROM grv WHERE id = '" . $id . "'")->row();
		if($query){
			$purchaseItems = $this->db->query("SELECT * FROM purchase_items WHERE p_order_id = '" . (int)$query->po_id . "'")->result_array();
			if(count($purchaseItems) > 0){
				foreach($purchaseItems as $item){
                    $exist_product = $this->db->query("SELECT * FROM product_stock WHERE size_id = '" . $item['size_id'] . "'");
                    if($exist_product->num_rows()){
                        $inv_product = $exist_product->row();

                        $product_id = $item['prod_id'];
                        $size_id = $item['size_id'];
                        $child_sku = $item['item_sku'];
                        $barcode = $item['barcode'];
                        $unit_price = $item['unit_price'];
                        $stock = $item['sellable_qty'];
                        $updated_by_id = $this->admin->getId();
                        $updated_by_name = $this->session->userdata('admin_name');
                        $avl_qty = $inv_product->stock;
                        $final_qty = $avl_qty + $stock;
                        $query2 = $this->db->query("UPDATE product_stock SET stock = '" . $final_qty . "', updated_by_name = '" . $this->db->escape_str($updated_by_name) . "', updated_by_id = '" . $this->db->escape_str($updated_by_id) . "' WHERE product_id = '" . $product_id . "' AND size_id = '" . $size_id . "'");
                    }else{
                        $product_id = $item['prod_id'];
                        $size_id = $item['size_id'];
                        $child_sku = $item['item_sku'];
                        $barcode = $item['barcode'];
                        $unit_price = $item['unit_price'];
                        $stock = $item['sellable_qty'];
                        $updated_by_id = $this->admin->getId();
                        $updated_by_name = $this->session->userdata('admin_name');
                        $final_qty = $stock;
                        $query2 = $this->db->query("INSERT INTO product_stock SET product_id = '" . $product_id . "', size_id = '" . $size_id . "', child_sku = '" . $child_sku . "', barcode = '" . $barcode . "', unit_price = '" . $unit_price . "', stock = '" . $stock . "', updated_by_name = '" . $this->db->escape_str($updated_by_name) . "', updated_by_id = '" . $this->db->escape_str($updated_by_id) . "'");
                    }
				}
			}
			return true;
		}else{
			return false;
		}
	}

	function updateReturnStock($id){
		$query = $this->db->query("SELECT * FROM purchase_return WHERE id = '" . $id . "'")->row();
		if($query){
			$returnItems = $this->db->query("SELECT * FROM purchase_return_items WHERE p_order_id = '" . (int)$query->po_id . "'")->result_array();
			//print_r($returnItems);exit();
			if(count($returnItems) > 0){
				foreach($returnItems as $item){
                    $exist_product = $this->db->query("SELECT * FROM product_stock WHERE size_id = '" . $item['size_id'] . "'");
                    if($exist_product->num_rows()){
                        $inv_product = $exist_product->row();

                        $product_id = $item['prod_id'];
                        $size_id = $item['size_id'];
                        $child_sku = $item['item_sku'];
                        $barcode = $item['barcode'];
                        $unit_price = $item['unit_price'];
                        $stock = $item['sellable_qty'];
                        $return_qty = $item['item_unit'];
                        $updated_by_id = $this->admin->getId();
                        $updated_by_name = $this->session->userdata('admin_name');
                        $avl_qty = $inv_product->stock;
                        $final_qty = $avl_qty - $return_qty;
                        $query2 = $this->db->query("UPDATE product_stock SET stock = '" . $final_qty . "', updated_by_name = '" . $this->db->escape_str($updated_by_name) . "', updated_by_id = '" . $this->db->escape_str($updated_by_id) . "' WHERE product_id = '" . $product_id . "' AND size_id = '" . $size_id . "'");
                    }
				}
			}
			return true;
		}else{
			return false;
		}
	}

	function total_value($cat_id,$brand,$status,$from,$to){
		$a = "SELECT ps.*, IF(ps.stock>0,sum(ps.stock*ps.unit_price),0) as total_price, p.id, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE ps.product_id > 0";
		if($cat_id){
			$a .= " AND p.main_category = '" . $cat_id . "'";
		}
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to. ' + 1 days'));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND ps.created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND ps.created_at <='" . $d_to . "'";
			}
		}
		if($status){
			if($status == 'yes'){
				$a .= " AND p.status = '1'";
			}else{
				$a .= " AND p.status = '0'";
			}
		}
		if($brand){
			$a .= " AND p.brand_id = '" . $brand . "'";
		}
		$query = $this->db->query($a);  
        return $query->row(); 
	}

	function make_query($cat_id,$brand,$status,$from,$to){
		$a = "SELECT ps.*, p.id, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE ps.product_id > 0";
		if($cat_id){
			$a .= " AND p.main_category = '" . $cat_id . "'";
		}
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to. ' + 1 days'));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND ps.created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND ps.created_at <='" . $d_to . "'";
			}
		}
		if($status){
			if($status == 'yes'){
				$a .= " AND p.status = '1'";
			}else{
				$a .= " AND p.status = '0'";
			}
		}
		if($brand){
			$a .= " AND p.brand_id = '" . $brand . "'";
		}
		return $a;
	}
	
	function get_list($cat_id,$brand,$status,$from,$to){
		$a = $this->make_query($cat_id,$brand,$status,$from,$to);
		//return $a;
		
		if(!empty($_POST["search"]["value"])){
			$a .= " AND ps.child_sku LIKE '%".$_POST["search"]["value"]."%' OR ps.barcode LIKE '%".$_POST["search"]["value"]."%' OR p.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		
		if(isset($_POST["order"])){             
			$a .= " ORDER BY ps.id ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY ps.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }     
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($cat_id,$brand,$status,$from,$to){
	   $a = $this->make_query($cat_id,$brand,$status,$from,$to);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('product_stock');  
	   return $this->db->count_all_results();
    }
	
	/*------ Filtered Inventory -----*/
	
	function get_filter_inventory($keyword,$cat_id,$brand,$status,$from,$to){
		if($keyword == 'instock'){
			$a = "SELECT ps.*, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE stock > 0";
		}else{
			$a = "SELECT ps.*, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE stock <= 0";
		}
		if($cat_id){
			$a .= " AND p.main_category = '" . $cat_id . "'";
		}
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to. ' + 1 days'));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND ps.created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND ps.created_at <='" . $d_to . "'";
			}
		}
		if($status){
			if($status == 'yes'){
				$a .= " AND p.status = '1'";
			}else{
				$a .= " AND p.status = '0'";
			}
		}
		if($brand){
			$a .= " AND p.brand_id = '" . $brand . "'";
		}
		if(!empty($_POST["search"]["value"])){
			$a .= " AND ps.child_sku LIKE '%".$_POST["search"]["value"]."%' OR ps.barcode LIKE '%".$_POST["search"]["value"]."%' OR p.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		
		if(isset($_POST["order"])){             
			$a .= " ORDER BY ps.id ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY ps.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }     
        $query = $this->db->query($a);  
        return $query->result();  
    }
	
    function get_filtered_stock($keyword,$cat_id,$brand,$status,$from,$to){
		if($keyword == 'instock'){
			$a = "SELECT ps.*, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE stock > 0";
		}else{
			$a = "SELECT ps.*, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE stock <= 0";
		}
		if($cat_id){
			$a .= " AND p.main_category = '" . $cat_id . "'";
		}
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to. ' + 1 days'));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND ps.created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND ps.created_at <='" . $d_to . "'";
			}
		}
		if($status){
			if($status == 'yes'){
				$a .= " AND p.status = '1'";
			}else{
				$a .= " AND p.status = '0'";
			}
		}
		if($brand){
			$a .= " AND p.brand_id = '" . $brand . "'";
		}
		if(!empty($_POST["search"]["value"])){
			$a .= " AND ps.child_sku LIKE '%".$_POST["search"]["value"]."%' OR ps.barcode LIKE '%".$_POST["search"]["value"]."%' OR p.name LIKE '%".$_POST["search"]["value"]."%'";
		}
		$query = $this->db->query($a);  
	   	return $query->num_rows();  
    }
     
    function get_all_stock($keyword){
		if($keyword == 'instock'){
			$query = $this->db->query("SELECT * FROM product_stock WHERE stock > 0");
		}else{
			$query = $this->db->query("SELECT * FROM product_stock WHERE stock <= 0");
		}
		return $query->num_rows();
    }

	function filter_total_value($keyword,$cat_id,$brand,$status,$from,$to){
		if($keyword == 'instock'){
			$a = "SELECT ps.*, IF(ps.stock>0,sum(ps.stock*ps.unit_price),0) as total_price, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE stock > 0";
		}else{
			$a = "SELECT ps.*, IF(ps.stock>0,sum(ps.stock*ps.unit_price),0) as total_price, p.parent_sku, p.brand_id, p.image, p.name as product_name, p.name_ar as product_arabic_name, p.status, p.main_category FROM product_stock ps LEFT JOIN product p ON (ps.product_id = p.id) WHERE stock <= 0";
		}
		if($cat_id){
			$a .= " AND p.main_category = '" . $cat_id . "'";
		}
		if($from && $to){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to. ' + 1 days'));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND ps.created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND ps.created_at <='" . $d_to . "'";
			}
		}
		if($status){
			if($status == 'yes'){
				$a .= " AND p.status = '1'";
			}else{
				$a .= " AND p.status = '0'";
			}
		}
		if($brand){
			$a .= " AND p.brand_id = '" . $brand . "'";
		}
		$query = $this->db->query($a);  
        return $query->row(); 
	}

	/*----- End ------*/

	function get_purchase_detail($id){
		$query = $this->db->query("SELECT po.*, v.vat_no, v.contact_person_name, v.country, gv.grv_no, gv.created_at as grv_date FROM purchase_order po LEFT JOIN vendors v ON (v.id = po.vendor_id) LEFT JOIN grv gv ON (gv.po_id = po.id) WHERE po.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM purchase_items WHERE p_order_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "products"=>$sql);
		return $data;
	}
	
	function order_items($id){
		$query = $this->db->query("SELECT * FROM purchase_return_items WHERE p_order_id = '" . $id . "'");
		return $query->result();
	}
	
	function get_order_detail($id){
		$query = $this->db->query("SELECT po.*, v.vat_no, v.vat_no, v.contact_person_name, v.country, gv.grv_no, gv.created_at as grv_date FROM purchase_return po LEFT JOIN vendors v ON (v.id = po.vendor_id) LEFT JOIN grv gv ON (gv.po_id = po.id) WHERE po.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM purchase_return_items WHERE p_order_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "products"=>$sql);
		return $data;
	}
	
	function get_vendors(){
		$query = $this->db->query("SELECT * FROM vendors WHERE 1=1");
		return $query->result();
	}
	
	function get_vendor_detail($id){
		$query = $this->db->query("SELECT v.*, mc.city_name FROM vendors v LEFT JOIN master_city mc ON(v.city = mc.id) WHERE v.id = '" . $id . "'");
		return $query->row();
	}
	
}
