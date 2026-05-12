<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spare_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO vehicle_spare_parts SET vehicle_make = '" . $this->db->escape_str((int)$this->input->post('vehicle_make')) . "', vehicle_model = '" . $this->db->escape_str($this->input->post('vehicle_model')) . "', item_code = '" . $this->db->escape_str($this->input->post('item_code')) . "', part_name_en = '" . $this->db->escape_str($this->input->post('part_name_en')) . "', part_name_ar = '" . $this->db->escape_str($this->input->post('part_name_ar')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE vehicle_spare_parts SET vehicle_make = '" . $this->db->escape_str((int)$this->input->post('vehicle_make')) . "', vehicle_model = '" . $this->db->escape_str($this->input->post('vehicle_model')) . "', item_code = '" . $this->db->escape_str($this->input->post('item_code')) . "', part_name_en = '" . $this->db->escape_str($this->input->post('part_name_en')) . "', part_name_ar = '" . $this->db->escape_str($this->input->post('part_name_ar')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT vsp.*, mvm.service_type, mvm.make_name FROM vehicle_spare_parts vsp LEFT JOIN mater_van_make mvm ON(vsp.vehicle_make = mvm.id) WHERE 1 = 1";
		return $a;
	}

	function get_data(){
		$a = "SELECT * FROM vehicle_spare_parts WHERE 1 = 1";
		$query = $this->db->query($a);  
		return $query->result();
	}
	
	function get_list($keyword,$startDate,$endDate,$status){
		$a = "SELECT vsp.*, mvm.service_type, mvm.make_name FROM vehicle_spare_parts vsp LEFT JOIN mater_van_make mvm ON(vsp.vehicle_make = mvm.id) WHERE 1=1";
		if($keyword){
			$a .= " AND (vsp.part_name_en LIKE '%".$keyword."%' OR vsp.item_code LIKE '%".$keyword."%')";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate . ' +1 day'));
			$a .= " AND vsp.created_at BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if($status){
			$a .= " AND vsp.status = '" . $status . "'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY vsp.part_name_en ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY vsp.created_at DESC";		   
		}		   
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}        
		$query = $this->db->query($a);  
		return $query->result();  
	}

	function get_filtered_data($keyword,$startDate,$endDate,$status){
		$a = $this->make_query();
		if($keyword){
			$a .= " AND (part_name_en LIKE '%".$keyword."%' OR item_code LIKE '%".$keyword."%')";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate . ' +1 day'));
			$a .= " AND created_at BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if($status){
			$a .= " AND status = '" . $status . "'";
		}
		$query = $this->db->query($a);  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('vehicle_spare_parts');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM vehicle_spare_parts WHERE id IN (" . $id . ")");
		$query2 = $this->db->query("DELETE FROM inventory_log WHERE product_type = 'spare' AND product_id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT vsp.*, mvm.service_type, mvm.make_name FROM vehicle_spare_parts vsp LEFT JOIN mater_van_make mvm ON(vsp.vehicle_make = mvm.id) WHERE vsp.id = '" . (int)$id . "'");
		return $query;
	}

	function stock_out(){
        $quantity = $this->input->post('quantity');
        $prod_id = $this->input->post('prod_id');
        $remarks = $this->input->post('remarks');
        $product_type = 'spare';
        $stock_type = 'out';
		if($quantity > 0 && $prod_id > 0){
            $this->db->trans_start();
			$query = $this->db->query("SELECT available_qty FROM vehicle_spare_parts WHERE id = '" . (int)$prod_id . "'")->row();
			$previous_qty = $query->available_qty;
			$current_qty = $previous_qty - $quantity;
			$update_query = $this->db->query("UPDATE vehicle_spare_parts SET available_qty =  '" . $current_qty . "', updated_at = NOW() WHERE id = '" . (int)$prod_id . "'");
            $update_query2 = $this->db->query("INSERT INTO inventory_log SET product_id =  '" . (int)$prod_id . "', quantity =  '" . $quantity . "', in_out =  '" . $stock_type . "', product_type =  '" . $product_type . "', remarks =  '" . $remarks . "', created_at = NOW()");
            $this->db->trans_complete();
		}
		return $update_query;
	}
	
	function stock_in(){
		$quantity = $this->input->post('quantity');
        $prod_id = $this->input->post('prod_id');
        $remarks = $this->input->post('remarks');
        $product_type = 'spare';
        $stock_type = 'in';
		if($quantity > 0 && $prod_id > 0){
            $this->db->trans_start();
			$query = $this->db->query("SELECT available_qty FROM vehicle_spare_parts WHERE id = '" . (int)$prod_id . "'")->row();
			$previous_qty = $query->available_qty;
			$current_qty = $previous_qty + $quantity;
			$update_query = $this->db->query("UPDATE vehicle_spare_parts SET available_qty =  '" . $current_qty . "', updated_at = NOW() WHERE id = '" . (int)$prod_id . "'");
            $update_query2 = $this->db->query("INSERT INTO inventory_log SET product_id =  '" . (int)$prod_id . "', quantity =  '" . $quantity . "', in_out =  '" . $stock_type . "', product_type =  '" . $product_type . "', remarks =  '" . $remarks . "', created_at = NOW()");
            $this->db->trans_complete();
		}
		return $update_query;
	}

	function get_quick_detail(){
		$id = $this->input->post("prod_id");
		$prod_info = $this->db->query("SELECT * FROM vehicle_spare_parts WHERE id = '". $id ."'");
		$summary_list = $this->db->query("SELECT * FROM inventory_log WHERE product_id = '". $id ."' ORDER BY id DESC")->result();
		if($prod_info->num_rows() > 0){
			$data['prod_info'] = $prod_info->row_array();
			$data['summary_list'] = $summary_list;
			return $data;  					
		}else{
			return false;
		}
	}

	function get_log_jobcard(){
		$id = $this->input->post("prod_id");
		$prod_info = $this->db->query("SELECT * FROM vehicle_spare_parts WHERE id = '". $id ."'");
		$summary_list = $this->db->query("SELECT jci.*, jc.bike_no, jc.job_type, jc.job_date, jc.status FROM job_card_items jci LEFT JOIN job_cards jc ON (jci.jobcard_id = jc.id) WHERE jci.item_id = '". $id ."' AND jc.status = 'closed'");
		if($prod_info->num_rows() > 0){
			$data['prod_info'] = $prod_info->row_array();
			$data['summary_list'] = $summary_list->result_array();
			return $data;  					
		}else{
			return false;
		}
	}
}
