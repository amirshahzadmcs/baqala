<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spare_po_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->table = 'spare_parts_po';
		$this->subtable = 'spare_parts_po_items';
	}
	
	function createPO(){
		$this->db->trans_start();
		$req_id = $this->input->post('requisition_no');
		$requisition_detail = $this->db->select('*')->from('spare_parts_requisition')->where('id',$req_id)->get()->row();
		$vendor_detail = $this->db->select('*')->from('vendors')->where('id',$requisition_detail->supplier_id)->get()->row();
		if(!empty($requisition_detail)){
			//print_r($requisition_detail);exit();
			$requisition_items = $this->db->select('*')->from('spare_parts_requisition_prod')->where('requisition_id',$req_id)->get()->result_array();
			$query = $this->db->query("INSERT INTO spare_parts_po SET 
				requisition_id = '" . $requisition_detail->id . "', 
				requisition_no = '" . $requisition_detail->requisition_no . "', 
				requisition_type = '" . $requisition_detail->requisition_type . "', 
				supplier_id = '" . $requisition_detail->supplier_id . "', 
				vendor_name = '" . $vendor_detail->vendor_name . "', 
				b_contact = '" . $vendor_detail->telephone . "', 
				b_short_address = '" . $vendor_detail->b_short_address . "', 
				b_building_no = '" . $vendor_detail->building_no . "', 
				b_street_name = '" . $vendor_detail->street_name . "', 
				b_district = '" . $vendor_detail->district . "', 
				b_additional_no = '" . $vendor_detail->additional_no . "', 
				b_unit_no = '" . $vendor_detail->unit_no . "', 
				b_city_name = '" . $vendor_detail->city . "', 
				b_zip_code = '" . $vendor_detail->postal_code . "', 
				vat_no = '" . $vendor_detail->vat_no . "', 
				po_date = '" . $this->db->escape_str($this->input->post('po_date')) . "', 
				total_fcy = 0, 
				total_item = 0, 
				total_qty = 0, 
				total_cost = 0, 
				vat_percent = 0, 
				total_vat_amt = 0, 
				status = 1, 
				created_at = '". CURRENT_TIME ."', 
				updated_at = '". CURRENT_TIME ."'");
			$insert_id = $this->db->insert_id();
			$this->db->query("UPDATE spare_parts_po SET po_no = '" . invoiceNmFormat($insert_id) . "' WHERE id = '". (int)$insert_id ."'");
			$spare_parts = [];
			if(count($requisition_items) > 0){
				foreach($requisition_items as $items){
					$part_id = $items['part_id'];
					$qty = $items['quantity'];
					$spare_parts[] = [
						'po_id' => $insert_id, 
    					'part_id' => $part_id, 
    					'qty' => $qty
					];
				}
				$this->db->insert_batch($this->subtable, $spare_parts);
			}
			$this->db->trans_complete();
			if($query){
				return $insert_id;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function requisition_list(){
	   $this->db->select('*');  
	   $this->db->from('spare_parts_requisition');  
	   $query = $this->db->get()->result();
	   return $query;
    }

    function edit(){
		$id = $this->input->post('po_id');
		if($id > 0){
			//echo '<pre>';print_r($this->input->post('sub_total'));exit();
			$this->db->query("DELETE FROM spare_parts_po_items WHERE po_id = '" . (int)$id . "'");
			if($this->input->post('part_id')){
				$item_count = count($this->input->post('part_id'));
				$spare_parts = [];
				$total_qty = 0;
				for($m=0;$m<$item_count;$m++){
					$po_id = $this->input->post('po_id');
					$part_id = $this->input->post('part_id')[$m];
					$item_code = $this->input->post('item_code')[$m];
					$qty = $this->input->post('qty')[$m];
					$fcy = 0;
					$price = $this->input->post('price')[$m];
					$total = $this->input->post('line_total')[$m];
					$total_qty += $qty;
					$spare_parts[] = [
						'po_id' => $po_id, 
    					'part_id' => $part_id, 
    					'qty' => $qty,
    					'fcy' => $fcy,
    					'price' => $price,
    					'total' => $total
					];
				}
				$query = $this->db->insert_batch($this->subtable, $spare_parts);
				if($query){
					$this->db->query("UPDATE spare_parts_po SET total_qty = '" . $total_qty . "', total_item = '" . count($this->input->post('part_id')) . "', total_fcy = 0, vat_percent = '" . $this->input->post('vat_percent') . "', total_vat_amt = '" . $this->input->post('total_vat_amt') . "', sub_total = '" . $this->input->post('sub_total') . "', total_cost = '" . $this->input->post('total') . "', updated_at = '". CURRENT_TIME ."' WHERE id = '". (int)$id ."'");
				}
			}
		}
		//print_r($id);exit();
		return $query;
	}
	
	function edit_international(){
		$id = $this->input->post('po_id');
		if($id > 0){
			//echo '<pre>';print_r($this->input->post('sub_total'));exit();
			$this->db->query("DELETE FROM spare_parts_po_items WHERE po_id = '" . (int)$id . "'");
			if($this->input->post('part_id')){
				$item_count = count($this->input->post('part_id'));
				$spare_parts = [];
				$total_qty = 0;
				for($m=0;$m<$item_count;$m++){
					$po_id = $this->input->post('po_id');
					$part_id = $this->input->post('part_id')[$m];
					$item_code = $this->input->post('item_code')[$m];
					$qty = $this->input->post('qty')[$m];
					$fcy = $this->input->post('fcy')[$m];
					$price = $this->input->post('price')[$m];
					$total = $this->input->post('line_total')[$m];
					$total_qty += $qty;
					$spare_parts[] = [
						'po_id' => $po_id, 
    					'part_id' => $part_id, 
    					'qty' => $qty,
    					'fcy' => $fcy,
    					'price' => $price,
    					'total' => $total
					];
				}
				$query = $this->db->insert_batch($this->subtable, $spare_parts);
				if($query){
					$this->db->query("UPDATE spare_parts_po SET total_qty = '" . $total_qty . "', total_item = '" . count($this->input->post('part_id')) . "', total_fcy = '" . $this->input->post('total_fcy') . "', total_vat_amt = 0, sub_total = '" . $this->input->post('sub_total') . "', total_cost = '" . $this->input->post('total') . "', updated_at = '". CURRENT_TIME ."' WHERE id = '". (int)$id ."'");
				}
			}
		}
		//print_r($id);exit();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT sppo.*, mc.city_name as billing_city_name FROM spare_parts_po sppo LEFT JOIN master_city mc ON(sppo.b_city_name = mc.id) WHERE 1=1";
	   return $a;
	}
	
	function get_list($po_no,$requisition_no,$startDate,$endDate,$requisition_type,$status){
		$a = $this->make_query();
		if($po_no){
			$a .= " AND sppo.po_no = '" . $po_no . "'";
		}
		if($requisition_no){
			$a .= " AND sppo.requisition_no = '" . $requisition_no . "'";
		}
		if($requisition_type){
			$a .= " AND sppo.requisition_type = '" . $requisition_type . "'";
		}
		if($status){
			$a .= " AND sppo.status = '" . $status . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND sppo.po_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY sppo.po_no ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY po_date DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($po_no,$requisition_no,$startDate,$endDate,$requisition_type,$status){
	   	$a = $this->make_query();
		if($po_no){
			$a .= " AND sppo.po_no = '" . $po_no . "'";
		}
	   	if($requisition_no){
			$a .= " AND sppo.requisition_no = '" . $requisition_no . "'";
		}
		if($requisition_type){
			$a .= " AND sppo.requisition_type = '" . $requisition_type . "'";
		}
		if($status){
			$a .= " AND sppo.status = '" . $status . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND sppo.po_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('spare_parts_po');  
	   return $this->db->count_all_results();
    }
	
	function delete($requisition_id) {
		$count = count($requisition_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM spare_parts_po WHERE id = '" . (int)$requisition_id[$i] . "'");
			$this->db->query("DELETE FROM spare_parts_po_items WHERE requisition_id = '" . (int)$requisition_id[$i] . "'");
		}
		return true;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT sppo.*, mc.city_name as billing_city_name FROM spare_parts_po sppo LEFT JOIN master_city mc ON(sppo.b_city_name = mc.id) WHERE sppo.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT sppoi.*, sp.id, sp.item_code, sp.part_name_en, sp.part_name_ar, sp.status, sp.vehicle_make, sp.vehicle_make, sp.vehicle_model, mvm.make_name FROM spare_parts_po_items sppoi LEFT JOIN vehicle_spare_parts sp ON (sppoi.part_id = sp.id) LEFT JOIN mater_van_make mvm ON (sp.vehicle_make = mvm.id) WHERE sppoi.po_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "items"=>$sql);
		return $data;
	}
	
	function get_search_hint($term){
		$data = array();
		$search_term = $this->db->escape_str($term);
		$this->db->select('sp.id, sp.item_code, sp.part_name_en, sp.part_name_ar, sp.status, sp.vehicle_make, sp.vehicle_make, sp.vehicle_model, mvm.make_name');
		$this->db->from('vehicle_spare_parts sp');
		$this->db->join('mater_van_make mvm', 'sp.vehicle_make = mvm.id', 'left');
		$this->db->where("(sp.item_code LIKE '%".$search_term."%' OR sp.part_name_en LIKE '%".$search_term."%')", NULL, FALSE);
		$query = $this->db->get()->result();
		
		foreach($query as $pdata){
			$data[] = array("id" => $pdata->id,
							"item_code" => $pdata->item_code,
							"part_name_en" => $pdata->part_name_en,
							"part_name_ar" => $pdata->part_name_ar,
							"vehicle_make" => $pdata->make_name,
							"vehicle_model" => $pdata->vehicle_model,
							"status" => $pdata->status);
		}
		return $data;
	}

}
