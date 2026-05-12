<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requisition_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->table = 'spare_parts_requisition_prod';
	}
	
	function createRequisition(){
		$this->db->trans_start();
		$query = $this->db->query("INSERT INTO spare_parts_requisition SET 
			supplier_id = '" . $this->input->post('supplier_id') . "', 
			requisition_type = '" . $this->db->escape_str($this->input->post('requisition_type')) . "', 
			requisition_date = '" . $this->db->escape_str($this->input->post('requisition_date')) . "', 
			total_item = 0, 
			total_qty = 0, 
			status = 1, 
			created_at = '". CURRENT_TIME ."', 
			updated_at = '". CURRENT_TIME ."'");
		$insert_id = $this->db->insert_id();
		$this->db->query("UPDATE spare_parts_requisition SET requisition_no = '" . invoiceNmFormat($insert_id) . "' WHERE id = '". (int)$insert_id ."'");
		$this->db->trans_complete();
		if($query){
			return $insert_id;
		}else{
			return false;
		}
	}

    function edit(){
		$id = $this->input->post('requisition_id');
		if($id > 0){
			$query = $this->db->query("UPDATE spare_parts_requisition SET total_qty = '" . array_sum($this->input->post('quantity')) . "', total_item = '" . count($this->input->post('part_id')) . "', updated_at = '". CURRENT_TIME ."' WHERE id = '". (int)$id ."'");
			$this->db->query("DELETE FROM spare_parts_requisition_prod WHERE requisition_id = '" . (int)$id . "'");
			if($this->input->post('part_id')){
				$item_count = count($this->input->post('part_id'));
				$spare_parts = [];
				for($m=0;$m<$item_count;$m++){
					$requisition_id = $this->input->post('requisition_id');
					$part_id = $this->input->post('part_id')[$m];
					$item_code = $this->input->post('item_code')[$m];
					$qty = $this->input->post('quantity')[$m];
					$spare_parts[] = [
						'requisition_id' => $requisition_id, 
    					'part_id' => $part_id, 
    					'quantity' => $qty
					];
				}
				$this->db->insert_batch($this->table, $spare_parts);
				
			}
		}
		//print_r($id);exit();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT spr.*, v.vendor_name, v.vendor_arabic_name, v.cr_no, v.contact_person_name, v.vat_no FROM spare_parts_requisition spr LEFT JOIN vendors v ON(spr.supplier_id = v.id) WHERE 1=1";
	   return $a;
	}
	
	function get_list($requisition_no,$startDate,$endDate,$requisition_type,$status){
		$a = $this->make_query();
		if($requisition_no){
			$a .= " AND requisition_no = '" . $requisition_no . "'";
		}
		if($requisition_type){
			$a .= " AND requisition_type = '" . $requisition_type . "'";
		}
		if($status){
			$a .= " AND status = '" . $status . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND requisition_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY requisition_no ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY requisition_date DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($requisition_no,$startDate,$endDate,$requisition_type,$status){
	   	$a = $this->make_query();
	   	if($requisition_no){
			$a .= " AND requisition_no = '" . $requisition_no . "'";
		}
		if($requisition_type){
			$a .= " AND requisition_type = '" . $requisition_type . "'";
		}
		if($status){
			$a .= " AND status = '" . $status . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND requisition_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('spare_parts_requisition');  
	   return $this->db->count_all_results();
    }
	
	function delete($requisition_id) {
		$count = count($requisition_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM spare_parts_requisition WHERE id = '" . (int)$requisition_id[$i] . "'");
			$this->db->query("DELETE FROM spare_parts_requisition_prod WHERE requisition_id = '" . (int)$requisition_id[$i] . "'");
		}
		return true;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT spr.*, v.vendor_name, v.vendor_arabic_name, v.cr_no, v.contact_person_name, v.vat_no FROM spare_parts_requisition spr LEFT JOIN vendors v ON(spr.supplier_id = v.id) WHERE spr.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT sprp.*, sp.id, sp.item_code, sp.part_name_en, sp.part_name_ar, sp.status, sp.vehicle_make, sp.vehicle_make, sp.vehicle_model, mvm.make_name FROM spare_parts_requisition_prod sprp LEFT JOIN vehicle_spare_parts sp ON (sprp.part_id = sp.id) LEFT JOIN mater_van_make mvm ON (sp.vehicle_make = mvm.id) WHERE sprp.requisition_id = '" . $id . "'")->result();
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
