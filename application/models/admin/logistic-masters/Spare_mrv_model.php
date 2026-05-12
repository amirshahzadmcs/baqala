<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spare_mrv_model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->table = 'spare_parts_mrv';
		$this->subtable = 'spare_parts_mrv_items';
	}
	
	function create(){
		$this->db->trans_start();
		$po_id = $this->input->post('po_no');
		$po_detail = $this->db->select('*')->from('spare_parts_po')->where('id',$po_id)->get()->row();
		if(!empty($po_detail)){
			//print_r($requisition_detail);exit();
			$po_items = $this->db->select('*')->from('spare_parts_po_items')->where('po_id',$po_id)->get()->result_array();
			if(count($po_items) > 0){
			
			$query = $this->db->query("INSERT INTO $this->table SET 
				po_id = '" . $po_detail->id . "', 
				mrv_date = '" . $this->db->escape_str($this->input->post('mrv_date')) . "', 
				status = 1, 
				created_at = '". CURRENT_TIME ."', 
				updated_at = '". CURRENT_TIME ."'");
			}
			$insert_id = $this->db->insert_id();
			$this->db->query("UPDATE $this->table SET mrv_no = '" . invoiceNmFormat($insert_id) . "' WHERE id = '". (int)$insert_id ."'");
			$spare_parts = [];
			if(count($po_items) > 0){
				foreach($po_items as $items){
					$part_id = $items['part_id'];
					$qty = $items['quantity'];
					$fcy = $items['fcy'];
					$price = $items['price'];
					$total = $items['total'];
					$spare_parts[] = [
						'mrv_id' => $insert_id, 
    					'part_id' => $part_id, 
    					'qty' => $qty,
    					'fcy' => $fcy,
    					'price' => $price,
    					'total' => $total
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
	
	function spare_po_list(){
	   $this->db->select('*');  
	   $this->db->from('spare_parts_po');  
	   $query = $this->db->get()->result();
	   return $query;
    }

    function edit(){
		$id = $this->input->post('mrv_id');
		if($id > 0){
			//echo '<pre>';print_r($this->input->post('sub_total'));exit();
			$this->db->query("DELETE FROM $this->subtable WHERE mrv_id = '" . (int)$id . "'");
			if($this->input->post('part_id')){
				$item_count = count($this->input->post('part_id'));
				$spare_parts = [];
				$total_qty = 0;
				$received_qty = 0;
				for($m=0;$m<$item_count;$m++){
					$mrv_id = $this->input->post('mrv_id');
					$part_id = $this->input->post('part_id')[$m];
					$item_code = $this->input->post('item_code')[$m];
					$qty = $this->input->post('qty')[$m];
					$received_qty = $this->input->post('received_qty')[$m];
					$fcy = 0;
					$price = $this->input->post('price')[$m];
					$total = $this->input->post('line_total')[$m];
					$total_qty += $qty;
					$received_qty += $received_qty;
					$spare_parts[] = [
						'mrv_id' => $mrv_id, 
    					'part_id' => $part_id, 
    					'qty' => $qty,
    					'received_qty' => $received_qty,
    					// 'fcy' => $fcy,
    					// 'price' => $price,
    					// 'total' => $total
					];
				}
				$query = $this->db->insert_batch($this->subtable, $spare_parts);
				if($query){
					$this->db->query("UPDATE $this->table SET total_qty = '" . $total_qty . "', total_item = '" . count($this->input->post('part_id')) . "', received_qty = '" . $received_qty . "', updated_at = '". CURRENT_TIME ."' WHERE id = '". (int)$id ."'");
				}
			}
		}
		//print_r($id);exit();
		return $query;
	}
	
	function make_query(){
		$a = "SELECT mrv.*, sppo.po_no, sppo.requisition_no, sppo.requisition_type, mc.city_name as billing_city_name FROM spare_parts_mrv mrv LEFT JOIN spare_parts_po sppo ON(mrv.po_id = sppo.id) LEFT JOIN master_city mc ON(sppo.b_city_name = mc.id) WHERE 1=1";
	   return $a;
	}
	
	function get_list($mrv_no,$po_no,$requisition_no,$startDate,$endDate,$requisition_type,$status){
		$a = $this->make_query();
		if($mrv_no){
			$a .= " AND mrv.mrv_no = '" . $mrv_no . "'";
		}
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
			$a .= " AND mrv.status = '" . $status . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND mrv.mrv_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY mrv.mrv_no ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY mrv_no DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($mrv_no,$po_no,$requisition_no,$startDate,$endDate,$requisition_type,$status){
	   	$a = $this->make_query();
		   if($mrv_no){
			$a .= " AND mrv.mrv_no = '" . $mrv_no . "'";
		}
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
			$a .= " AND mrv.status = '" . $status . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND mrv.mrv_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('spare_parts_mrv');  
	   return $this->db->count_all_results();
    }
	
	function delete($mrv_id) {
		$count = count($mrv_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM $this->table WHERE id = '" . (int)$mrv_id[$i] . "'");
			$this->db->query("DELETE FROM $this->subtable WHERE mrv_id = '" . (int)$mrv_id[$i] . "'");
		}
		return true;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT mrv.*, sppo.po_no, sppo.requisition_no, sppo.requisition_type, sppo.b_contact, sppo.b_contact,vat_no, sppo.b_short_address, sppo.b_building_no, sppo.b_street_name, sppo.b_district, sppo.b_additional_no, sppo.b_unit_no, sppo.b_city_name, sppo.b_zip_code, mc.city_name as billing_city_name FROM spare_parts_mrv mrv LEFT JOIN spare_parts_po sppo ON(mrv.po_id = sppo.id) LEFT JOIN master_city mc ON(sppo.b_city_name = mc.id) WHERE mrv.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT mrvi.*, sp.id, sp.item_code, sp.part_name_en, sp.part_name_ar, sp.status, sp.vehicle_make, sp.vehicle_make, sp.vehicle_model, mvm.make_name FROM spare_parts_mrv_items mrvi LEFT JOIN vehicle_spare_parts sp ON (mrvi.part_id = sp.id) LEFT JOIN mater_van_make mvm ON (sp.vehicle_make = mvm.id) WHERE mrvi.mrv_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "items"=>$sql);
		return $data;
	}
	
}
