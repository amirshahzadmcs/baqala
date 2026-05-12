<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grv_model extends CI_Model{

	function add($po_id){
		$query = $this->db->query("SELECT * FROM purchase_order WHERE id = '" . (int)$po_id . "'")->row();
		if($query){
			$con['upload_path']   = './uploads/po/'; 
			$con['allowed_types'] = 'jpg|png|jpeg|pdf|docx'; 
			$con['maintain_ratio'] = TRUE;
			$con['max_filename'] = '50';
			$con['encrypt_name'] = TRUE;
			
			if($_FILES['image']['name']){
				$this->load->library('upload', $con);
				$this->upload->do_upload('image');
				$image_da = $this->upload->data();
				$imagef = "uploads/po/".$image_da['file_name'];
			}
			else{
				$imagef = "";
			}
			$grv_number = str_pad($query->id, 6, 0, STR_PAD_LEFT);
			$query2 = $this->db->query("INSERT INTO grv SET po_id = '" . (int)$query->id . "', grv_no = '" . $grv_number . "', po_no = '" . $query->invoice_prefix .'-'. $query->po_number . "', vendor = '" . $this->db->escape_str($query->vendor_name) . "', sup_invoice_no = '" . $this->db->escape_str($this->input->post('sup_invoice_no')) . "', invoice_date = '" . $this->db->escape_str($this->input->post('invoice_date')) . "', total_qty = '" . $this->db->escape_str($query->total_qty) . "', sub_total = '" . $this->db->escape_str($query->sub_total) . "', tax_percent = '" . $this->db->escape_str($query->sale_tax) . "', tax_amount = '" . $this->db->escape_str($query->sale_tax_amt) . "', shipping_charge = '" . $this->db->escape_str($query->shipping_handling) . "', grv_value = '" . $this->db->escape_str($query->total) . "', attachment = '" . $this->db->escape_str($imagef) . "', created_by = '" . $this->db->escape_str($this->session->userdata('admin_name')) . "', created_by_id = '" . $this->db->escape_str($this->admin->getId()) . "', grv_status = 'open', created_at = NOW(), updated_at = now()");
			$grv_id = $this->db->insert_id();
		}
		if($query2){
			return $grv_id;
		}else{
			return false;
		}
	}

	function make_query(){
		$a = "SELECT * FROM grv WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND vendor LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY po_no ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY po_no DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data(){
	   $a = $this->make_query();
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('grv');  
	   return $this->db->count_all_results();
    }
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM grv WHERE id = '" . $id . "'")->row();
		$order = $this->db->query("SELECT po.*, v.vat_no, v.contact_person_name, v.country FROM purchase_order po LEFT JOIN vendors v ON (v.id = po.vendor_id) WHERE po.id = '" . (int)$query->po_id . "'")->row();
		$product = $this->db->query("SELECT * FROM purchase_items WHERE p_order_id = '" . $query->po_id . "'")->result();
		$data = array("grv"=>$query,"order"=>$order, "products"=>$product);
		return $data;
	}
	
	function reject_grv($id){
		$query = $this->db->query("UPDATE grv SET grv_status = 'rejected' WHERE id= '" . $id . "'");
		return $query;
	}
	
	function close_grv($id){
		$query = $this->db->query("UPDATE grv SET grv_status = 'closed' WHERE id= '" . $id . "'");
		return $query;
	}
	
	function updateGrv(){
		$po_id = $this->input->post('po_id');
		$id = $this->input->post('id');
		$query = $this->db->query("SELECT * FROM purchase_order WHERE id = '" . $po_id . "'")->row();
		if($query){
			if($this->input->post('item_id')){
				//print_r($query);exit();
				$item_count = count($this->input->post('item_id'));
				for($m=0;$m<$item_count;$m++){
					$item_id = $this->input->post('item_id')[$m];
					$received_qty = $this->input->post('received_qty')[$m];
					$sellable_qty = $this->input->post('sellable_qty')[$m];
					$unsellable_qty = $this->input->post('unsellable_qty')[$m];
					$query = $this->db->query("UPDATE purchase_items SET received_qty = '" . (int)$received_qty . "', sellable_qty = '" . $this->db->escape_str((int)$sellable_qty) . "', unsellable_qty = '" . $this->db->escape_str((int)$unsellable_qty) . "', updated_at = NOW() WHERE id = '". $item_id ."' AND p_order_id = '". $po_id ."'");
				}
			}
			return true;
		}else{
			return false;
		}
	}

	function updateStock($id){
		$query = $this->db->query("SELECT * FROM grv WHERE id = '" . $id . "'")->row();
		if($query){
			$purchase = $this->db->query("SELECT item_sku,item_unit,unit_price FROM purchase_items WHERE p_order_id = '" . (int)$query->po_id . "'")->result_array();
			if(count($purchase) > 0){
				foreach($purchase as $order){
					$sku = $order['item_sku'];
					$quantity = $order['item_unit'];
					$product = $this->db->query("SELECT p.id, ps.id as size_id, ps.quantity FROM product p LEFT JOIN product_size ps ON(ps.product_id = p.id) WHERE sku = '" . $sku . "'")->row_array();
					$avl_qty = $product['quantity'];
					$size_id = $product['size_id'];
					$final_qty = $avl_qty + $quantity;
					$query2 = $this->db->query("UPDATE product_size SET quantity = '" . $final_qty . "' WHERE id = '" . $size_id . "'");
				}
			}
			return true;
		}else{
			return false;
		}
	}
}
