<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockrequest_model extends CI_Model{
	
	function make_query(){
		$a = "SELECT sr.*, srs.status_name, srs.status_type, s.store_id as storeid, s.store_name, w.name_english as target_store_name, w.partner_code FROM stock_request sr LEFT JOIN stock_request_status srs ON (srs.id = sr.status) LEFT JOIN stores s ON (sr.store_id = s.id) LEFT JOIN warehouse w ON (sr.target_store_id = w.id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		$store_id = $this->input->get('store_id');
		if($store_id AND $store_id !=""){
			$a .= " AND sr.store_id = '" . $this->input->get('store_id') . "'";
		}
		
		if(!empty($this->input->get('from')) AND !empty($this->input->get('to'))){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d h:i:s", strtotime($v_to));
			//print_r($v_from);exit();
			if($v_from AND $v_to){
				$a .= " AND created_at >= '" . date("Y-m-d h:i:s", strtotime($this->input->get('from'))) . "' AND created_at <='" . $d_to . "'";
			}
		}
		if(!empty($this->input->get('status'))){
			$a .= " AND sr.status = '" . $this->input->get('status') . "'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND s.store_id LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND s.store_name LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY id ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY created_at DESC";		   
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
		$this->db->from('stock_request');  
		return $this->db->count_all_results();  
	}
	
	function get_stores(){
		$query = $this->db->query("SELECT * FROM stores WHERE 1=1");
		return $query->result();
	}
	
	function get_request_detail($id){
		$query = $this->db->query("SELECT sr.*, srs.status_name, srs.status_type, s.store_id as storeid, s.store_name, s.store_incharge, s.email, s.contact_number, s.store_location FROM stock_request sr LEFT JOIN stock_request_status srs ON (srs.id = sr.status) LEFT JOIN stores s ON (s.id = sr.store_id) WHERE sr.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM stock_request_items WHERE request_id = '" . $id . "'")->result();
		$warehouse = $this->db->query("SELECT name_english, contact_person, warehouse_email, warehouse_phone, complete_address FROM warehouse WHERE 1")->row();
		$delivery_vehicle = $this->db->query("SELECT * FROM delivery_vehicles WHERE status = '1'")->result();
		$data = array("order"=>$query, "products"=>$sql, "warehouse_address"=>$warehouse, 'delv_vehicles'=>$delivery_vehicle);
		return $data;
	}
	
	function edit(){
		$total_qty = 0;
		$total_amt_excl_vat = 0;
		$total_vat_amt = 0;
		$total_tax_inclusive = 0;
		$shipping_handling = 0;
		$total_amount = 0;
		
		$req_id = $this->input->post('request_id');
		if($req_id > 0){
			//print_r($req_id);exit();
			if($this->input->post('item_req_id')){
				$item_count = count($this->input->post('item_req_id'));
				for($m=0;$m<$item_count;$m++){
					$item_req_id = $this->input->post('item_req_id')[$m];
					$size_id = $this->input->post('size_id')[$m];
					$approved_unit = $this->input->post('approved_unit')[$m];
					
					$product_size_detail = $this->db->query("SELECT ps.* FROM product_size ps WHERE ps.id = '" . $size_id . "'")->row();
					
					$unit_price = $product_size_detail->price;
					$amt_incl_vat = $unit_price * $approved_unit;
					
					$base_unit_price = round((($unit_price * 100) / 115),2);
					$vat_unit_price = round(($unit_price - $base_unit_price),2);
					$vat_amt = $vat_unit_price * $approved_unit;
					$amt_excl_vat = $amt_incl_vat - $vat_amt;
					$vat_percent = '15.00%';
					
					$query = $this->db->query("UPDATE stock_request_items SET approved_unit = '" . $approved_unit . "', unit_price = '" . $base_unit_price . "', amt_excl_vat = '" . $amt_excl_vat . "', vat_percent = '" . $vat_percent . "', vat_amt = '" . $vat_amt . "', amt_incl_vat = '" . $amt_incl_vat . "', updated_at = NOW() WHERE id = '" . $item_req_id . "'");
					
					$total_qty += $approved_unit;
					$total_amt_excl_vat += $amt_excl_vat;
					$total_vat_amt += $vat_amt;
					$total_tax_inclusive += $amt_incl_vat;
				}
				
				$total_amount = $total_tax_inclusive + $shipping_handling;
				
				$query = $this->db->query("UPDATE stock_request SET status='2', total_approved_qty = '" . (int)$total_qty . "', total_amt_excl_vat = '" . $total_amt_excl_vat . "', vat_amt = '" . $total_vat_amt . "', total_tax_inclusive = '" . $total_tax_inclusive . "', shipping_handling = '" . $shipping_handling . "', total_amount = '" . $total_amount . "', updated_at = now() WHERE id = '" . (int)$req_id . "'");
			}
		}
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	function assign_vehicle(){
		$query = $this->db->query("UPDATE stock_request SET status='3', vehicle_id = '" . (int)$this->input->post('vehicle_id') . "', updated_at = now() WHERE id = '" . (int)$this->input->post('request_id') . "'");
		return $query;
	}

	function update_status(){
		$query = $this->db->query("UPDATE stock_request SET status='" . (int)$this->input->post('status') . "', vehicle_id = '" . (int)$this->input->post('vehicle_id') . "', updated_at = now() WHERE id = '" . (int)$this->input->post('request_id') . "'");
		return $query;
	}
}
