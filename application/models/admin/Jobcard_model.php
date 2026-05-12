<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobcard_model extends CI_Model{
	
	public function createJob($alloted_user){
		$query = $this->db->query("INSERT INTO job_cards SET 
			job_date = '" . $this->input->post('job_date') . "', 
			job_type = '" . $this->db->escape_str($this->input->post('job_type')) . "', 
			bike_no = '" . $this->db->escape_str($this->input->post('bike_no')) . "', 
			vehicle_year = '" . $this->db->escape_str($this->input->post('vehicle_year')) . "', 
			vehicle_p_date = '" . $this->db->escape_str($this->input->post('vehicle_p_date')) . "', 
			vehicle_make = '" . $this->db->escape_str($this->input->post('vehicle_make')) . "', 
			vehicle_type = '" . $this->db->escape_str($this->input->post('vehicle_type')) . "', 
			vehicle_color = '" . $this->db->escape_str($this->input->post('vehicle_color')) . "', 
			meter_reading = '" . $this->db->escape_str($this->input->post('meter_reading')) . "', 
			alloted_to = '" . $this->db->escape_str($alloted_user) . "', 
			created_at = '". CURRENT_TIME ."', 
			updated_at = '". CURRENT_TIME ."'");
		
		return $query;
	}

	function add(){
		$id = $this->input->post('job_id');
		if($id > 0){
			$this->db->query("UPDATE job_cards SET sub_total = '" . $this->db->escape_str($this->input->post('sub_total')) . "', sale_tax = '" . $this->db->escape_str((int)$this->input->post('sale_tax')) . "', sale_tax_amt = '" . $this->db->escape_str($this->input->post('sale_tax_amt')) . "', shipping_handling = '" . $this->db->escape_str($this->input->post('shipping_handling')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', total_qty = '" . count($this->input->post('item_code')) . "', updated_at = '". CURRENT_TIME ."' WHERE id = '". (int)$id ."'");
			
			if($this->input->post('item_code')){
				$item_count = count($this->input->post('item_code'));
				for($m=0;$m<$item_count;$m++){
					$jobcard_id = $this->input->post('job_id');
					$item_id = $this->input->post('item_id');
					$item_code = $this->input->post('item_code');
					$spare_part_name = $this->input->post('spare_part_name');
					$spare_part_name_ar = $this->input->post('spare_part_name_ar');
					$qty = $this->input->post('qty');
					$cost = $this->input->post('cost');
					$line_amount = $this->input->post('line_amount');
					$tax_sum = ($line_amount[$m] / 100) * (int)$this->input->post('sale_tax');
					$vat_price = $tax_sum;
					$final_amount = $line_amount[$m]+$vat_price;
					
					$query = $this->db->query("INSERT INTO job_card_items SET 
						item_code = '" . $this->db->escape_str($item_code[$m]) . "', 
						item_id = '" . $this->db->escape_str($item_id[$m]) . "', 
						spare_part_name = '" . $this->db->escape_str($spare_part_name[$m]) . "', 
						spare_part_name_ar = '" . $this->db->escape_str($spare_part_name_ar[$m]) . "', 
						qty = '" . $qty[$m] . "', 
						jobcard_id = '" . $jobcard_id . "', 
						cost = '" . $cost[$m] . "', 
						line_amount = '" . $line_amount[$m] . "', 
						vat_price = '" . $vat_price . "', 
						amt_incl_vat = '" . $final_amount . "', 
						created_at = '". CURRENT_TIME ."', 
						updated_at = '". CURRENT_TIME ."'"
					);
				}
			}
		}
		if($query){
			return true;
		}else{
			return false;
		}
	}
    
    function edit(){
		$id = $this->input->post('job_id');
		if($id > 0){
			$query = $this->db->query("UPDATE job_cards SET sub_total = '" . $this->db->escape_str($this->input->post('sub_total')) . "', sale_tax = '" . $this->db->escape_str((int)$this->input->post('sale_tax')) . "', sale_tax_amt = '" . $this->db->escape_str($this->input->post('sale_tax_amt')) . "', shipping_handling = '" . $this->db->escape_str($this->input->post('shipping_handling')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', total_qty = '" . count($this->input->post('item_code')) . "', updated_at = '". CURRENT_TIME ."' WHERE id = '". (int)$id ."'");
			$this->db->query("DELETE FROM job_card_items WHERE jobcard_id = '" . (int)$id . "'");
			if($this->input->post('item_code')){
				$item_count = count($this->input->post('item_code'));
				for($m=0;$m<$item_count;$m++){
					$jobcard_id = $this->input->post('job_id');
					$item_id = $this->input->post('item_id');
					$item_code = $this->input->post('item_code');
					$spare_part_name = $this->input->post('spare_part_name');
					$spare_part_name_ar = $this->input->post('spare_part_name_ar');
					$qty = $this->input->post('qty');
					$cost = $this->input->post('cost');
					$line_amount = $this->input->post('line_amount');
					$tax_sum = ($line_amount[$m] / 100) * (int)$this->input->post('sale_tax');
					$vat_price = $tax_sum;
					$final_amount = $line_amount[$m]+$vat_price;
					
					$query = $this->db->query("INSERT INTO job_card_items SET 
						item_code = '" . $this->db->escape_str($item_code[$m]) . "', 
						item_id = '" . $this->db->escape_str($item_id[$m]) . "', 
						spare_part_name = '" . $this->db->escape_str($spare_part_name[$m]) . "', 
						spare_part_name_ar = '" . $this->db->escape_str($spare_part_name_ar[$m]) . "', 
						qty = '" . $qty[$m] . "', 
						jobcard_id = '" . $jobcard_id . "', 
						cost = '" . $cost[$m] . "', 
						line_amount = '" . $line_amount[$m] . "', 
						vat_price = '" . $vat_price . "', 
						amt_incl_vat = '" . $final_amount . "', 
						created_at = '". CURRENT_TIME ."', 
						updated_at = '". CURRENT_TIME ."'"
					);
				}
			}
		}
		return $query;
	}
	
	function make_query(){
		$a = "SELECT jc.*, me.full_name as rider_name FROM job_cards jc LEFT JOIN master_employee me ON (jc.alloted_to = me.id) WHERE 1=1";
	   return $a;
	}
	
	function get_list($vehicleFilter,$job_number,$startDate,$endDate,$job_type,$rider_name,$status){
		$a = $this->make_query();
		if($vehicleFilter){
			$a .= " AND jc.bike_no = '" . $vehicleFilter . "'";
		}
		if($job_number){
			$a .= " AND jc.id = '" . ltrim($job_number, '0') . "'";
		}
		if($job_type){
			$a .= " AND jc.job_type = '" . $job_type . "'";
		}
		if($status){
			$a .= " AND jc.status = '" . $status . "'";
		}
		if($rider_name){
			$a .= " AND (me.full_name LIKE '%".$rider_name."%')"; 
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND jc.job_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND jc.bike_no LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY jc.bike_no ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY jc.created_at DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($vehicleFilter,$job_number,$startDate,$endDate,$job_type,$rider_name,$status){
	   	$a = $this->make_query();
	   	if($vehicleFilter){
			$a .= " AND jc.bike_no = '" . $vehicleFilter . "'";
		}
		if($job_number){
			$a .= " AND jc.id = '" . ltrim($job_number, '0') . "'";
		}
		if($job_type){
			$a .= " AND jc.job_type = '" . $job_type . "'";
		}
		if($status){
			$a .= " AND jc.status = '" . $status . "'";
		}
		if($rider_name){
			$a .= " AND jc.alloted_to = '" . $rider_name . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND jc.job_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('job_cards');  
	   return $this->db->count_all_results();
    }
	
	function delete($order_id) {
		$count = count($order_id);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM job_cards WHERE id = '" . (int)$order_id[$i] . "'");
			$this->db->query("DELETE FROM job_card_items WHERE jobcard_id = '" . (int)$order_id[$i] . "'");
		}
		return true;
	}
	
	function order_items($id){
		$query = $this->db->query("SELECT * FROM job_card_items WHERE jobcard_id = '" . $id . "'");
		return $query->result();
	}
	
	function get_job_detail($id){
		$query = $this->db->query("SELECT job_cards.*, me.full_name as rider_name FROM job_cards LEFT JOIN master_employee me ON (job_cards.alloted_to = me.id) WHERE job_cards.id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM job_card_items WHERE jobcard_id = '" . $id . "'")->result();
		$data = array("order"=>$query, "items"=>$sql);
		return $data;
	}
	
	function lockJob($id){
		$this->db->trans_start();
		$query = $this->db->query("SELECT * FROM job_cards WHERE id = '" . (int)$id . "'")->row();
		$sql = $this->db->query("SELECT * FROM job_card_items WHERE jobcard_id = '" . $id . "'")->result_array();
		if(count($sql) > 0){
			foreach ($sql as $key => $value) {
				$part = $this->db->query("SELECT * FROM vehicle_spare_parts WHERE id = '" . (int)$value['item_id'] . "'")->row();
				$available_qty = $part->available_qty;
				$used_qty = $value['qty'];
				$qty_left = $available_qty - $used_qty;
				$product_type = 'spare';
        		$stock_type = 'out';
				$update_qty = $this->db->query("UPDATE vehicle_spare_parts SET available_qty = '" . $qty_left . "', updated_at = NOW() WHERE id = '" . (int)$value['item_id'] . "' LIMIT 1");
				if($update_qty){
					$this->db->query("UPDATE job_cards SET status = 'closed' WHERE id = '" . (int)$id . "'");
					$this->db->query("INSERT INTO inventory_log SET product_id =  '" . (int)$value['item_id'] . "', quantity =  '" . $used_qty . "', in_out =  '" . $stock_type . "', product_type =  '" . $product_type . "', remarks =  'Repair/Maintenance', created_at = NOW()");
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}

	function get_vehicles(){
		$query = $this->db->query("SELECT vehicle_no, id FROM master_vehicles WHERE vehicle_type='bike' ORDER BY vehicle_no ASC");
		return $query->result();
	}
	
	function get_vehicle_detail($id)
    {
        $query = $this->db->query("SELECT db.*, mc.color_name, mvk.make_name FROM master_vehicles db LEFT JOIN master_color mc ON (mc.id = db.vehicle_color) LEFT JOIN mater_van_make mvk ON (mvk.id = db.vehicle_make) WHERE db.id = '" . (int) $id . "'");
        return $query->row();
    }

	function get_search_hint($term){
		$data = array();
		$this->db->select('sp.id, sp.item_code, sp.part_name_en, sp.part_name_ar, sp.quantity, sp.cost_price, sp.available_qty, sp.status');
		$this->db->from('vehicle_spare_parts sp');
		$this->db->like('sp.item_code', $this->db->escape_str($term));
		$this->db->or_like('sp.part_name_en', $this->db->escape_str($term));
		$this->db->or_like('sp.part_name_ar', $this->db->escape_str($term));
		$query = $this->db->get()->result();
		foreach($query as $pdata){
			//$sql = $this->db->query("SELECT ps.barcode FROM product_size ps WHERE ps.product_id = '" . (int)$pdata->id . "'")->row();
			$data[] = array("id" => $pdata->id,
							"item_code" => $pdata->item_code,
							"part_name_en" => $pdata->part_name_en,
							"part_name_ar" => $pdata->part_name_ar,
							"quantity" => $pdata->quantity,
							"cost_price" => $pdata->cost_price,
							"available_qty" => $pdata->available_qty,
							"status" => $pdata->status);
		}
		return $data;
	}

	function get_jobcard_vehicles(){
		$query = $this->db->query("SELECT bike_no, vehicle_type FROM job_cards GROUP BY bike_no ASC");
		return $query->result();
	}

	function get_report($vehicleFilter,$job_number,$startDate,$endDate){
		$a = "SELECT * FROM job_cards WHERE 1=1";
		if($vehicleFilter){
			$a .= " AND bike_no = '" . $vehicleFilter . "'";
		}
		if($job_number){
			$a .= " AND id = '" . ltrim($job_number, '0') . "'";
		}
		if($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND job_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		$a .= " ORDER BY job_date DESC";
		$job_cards = $this->db->query($a);
		//print_r($job_cards->result_array());exit();
		//$job_ids = array_column($job_cards->result_array(), 'id');
		//$final_job_ids = str_replace("'", "", implode(',', $job_ids));
		
		$data = array();
		$data['start_date'] = $startDate;
		$data['end_date'] = $endDate;
		$data['job_info'] = $job_cards->row_array();
		$data['job_cards'] = array();
		if($job_cards->num_rows() > 0){
    		foreach($job_cards->result_array() as $jobs){
    		    $summary_list = $this->db->query("SELECT * FROM job_card_items WHERE jobcard_id = '". $jobs['id'] ."'")->result_array();
    		    $data['job_cards'][] = array("job_date" => $jobs['job_date'],
								"job_items" => $summary_list
								);
    		}
			return $data;  					
		}else{
			return false;
		}
		
	}
}
