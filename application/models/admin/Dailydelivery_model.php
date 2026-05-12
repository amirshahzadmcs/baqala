<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dailydelivery_model extends CI_Model{

	function add(){
		$created_at = CURRENT_TIME;
		$hrs = $this->input->post('online_hrs');
		$min = $this->input->post('online_min');
		$online_hrs = $hrs.':'.$min.':00';
        $this->db->trans_start();
		$query = $this->db->query("INSERT INTO food_deliv_companies_orders SET company_id = '" . $this->db->escape_str((int)$this->input->post('company_id')) . "', rider_id = '" . $this->db->escape_str((int)$this->input->post('rider_id')) . "', orders = '" . $this->db->escape_str((int)$this->input->post('orders')) . "', total_earning = '" . $this->db->escape_str($this->input->post('total_earning')) . "', traffic_fine = '" . $this->db->escape_str($this->input->post('traffic_fine')) . "', id_fine = '" . $this->db->escape_str($this->input->post('id_fine')) . "', wallet_received = '" . $this->db->escape_str($this->input->post('wallet_received')) . "', cash_received = '" . $this->db->escape_str($this->input->post('cash_received')) . "', pos_received = '" . $this->db->escape_str($this->input->post('pos_received')) . "', stcpay = '" . $this->db->escape_str($this->input->post('stcpay')) . "', stcpaym = '" . $this->db->escape_str($this->input->post('stcpaym')) . "', delivery_date = '" . $this->db->escape_str($this->input->post('delivery_date')) . "', fuel_topup = '" . $this->db->escape_str($this->input->post('fuel_topup')) . "', hunger_topup = '" . $this->db->escape_str($this->input->post('hunger_topup')) . "', online_hrs = '" . $this->db->escape_str($online_hrs) . "'");
		/*
		$insert_id = $this->db->insert_id();
		$order_count = (int)$this->input->post('orders');
        if($query){
			for ($i=0; $i < $order_count; $i++) { 
				$this->db->query("INSERT INTO fdc_order_detail SET fdc_order_id = '" . (int)$insert_id . "', settled_date = '" . $this->db->escape_str($this->input->post('delivery_date')) . "', created_at = '" . $created_at . "'");
			}
        }*/
        $this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$hrs = $this->input->post('online_hrs');
		$min = $this->input->post('online_min');
		$online_hrs = $hrs.':'.$min.':00';
		$created_at = CURRENT_TIME;
        $this->db->trans_start();
		$query = $this->db->query("UPDATE food_deliv_companies_orders SET total_earning = '" . $this->db->escape_str($this->input->post('total_earning')) . "', traffic_fine = '" . $this->db->escape_str($this->input->post('traffic_fine')) . "', id_fine = '" . $this->db->escape_str($this->input->post('id_fine')) . "', wallet_received = '" . $this->db->escape_str($this->input->post('wallet_received')) . "', cash_received = '" . $this->db->escape_str($this->input->post('cash_received')) . "', pos_received = '" . $this->db->escape_str($this->input->post('pos_received')) . "', stcpay = '" . $this->db->escape_str($this->input->post('stcpay')) . "', stcpaym = '" . $this->db->escape_str($this->input->post('stcpaym')) . "', fuel_topup = '" . $this->db->escape_str($this->input->post('fuel_topup')) . "', hunger_topup = '" . $this->db->escape_str($this->input->post('hunger_topup')) . "', online_hrs = '" . $this->db->escape_str($online_hrs) . "', updated_at = '". $created_at ."' WHERE id = '" . (int)$this->input->post('id') . "' LIMIT 1");
        $this->db->trans_complete();
		return $query;
	}

	function edit_detail(){
		$created_at = CURRENT_TIME;
        $this->db->trans_start();
		$query = $this->db->query("UPDATE fdc_order_detail SET 
						ref_id = '" . $this->db->escape_str($this->input->post('ref_id')) . "', 
						collection_amt = '" . $this->db->escape_str($this->input->post('collection_amt')) . "', 
						delivery_price = '" . $this->db->escape_str($this->input->post('delivery_price')) . "', 
						free_order_count = '" . $this->db->escape_str($this->input->post('free_order_count')) . "', 
						driver_credit = '" . $this->db->escape_str($this->input->post('driver_credit')) . "', 
						driver_debit = '" . $this->db->escape_str($this->input->post('driver_debit')) . "', 
						service_deduction = '" . $this->db->escape_str($this->input->post('service_deduction')) . "', 
						driver_tips = '" . $this->db->escape_str($this->input->post('driver_tips')) . "', 
						settled_by = '" . $this->db->escape_str($this->input->post('settled_by')) . "', 
						updated_at = '" . $created_at . "' WHERE id = '" . $this->input->post('id') . "' LIMIT 1");
        $this->db->trans_complete();
		return $query;
	}

	function add_detail(){
		$created_at = CURRENT_TIME;
        $this->db->trans_start();
		$fdco_id = $this->input->post('fdco_id');
		$query = $this->db->query("SELECT * FROM food_deliv_companies_orders WHERE id = '". $fdco_id ."' LIMIT 1");
		$query2 = FALSE;
		
		if($query->num_rows() > 0){
			$order_info = $query->row();
			$order_date = $order_info->delivery_date;
			$order_count = (int)$order_info->orders;
			if($order_count > 0){
				for ($i=0; $i < $order_count; $i++) { 
					$query2 = $this->db->query("INSERT INTO fdc_order_detail SET 
						fdc_order_id = '" . (int)$fdco_id . "', 
						ref_id = '" . $this->db->escape_str($this->input->post('ref_id')[$i]) . "', 
						collection_amt = '" . $this->db->escape_str($this->input->post('collection_amt')[$i]) . "', 
						delivery_price = '" . $this->db->escape_str($this->input->post('delivery_price')[$i]) . "', 
						free_order_count = '" . $this->db->escape_str($this->input->post('free_order_count')[$i]) . "', 
						driver_credit = '" . $this->db->escape_str($this->input->post('driver_credit')[$i]) . "', 
						driver_debit = '" . $this->db->escape_str($this->input->post('driver_debit')[$i]) . "', 
						service_deduction = '" . $this->db->escape_str($this->input->post('service_deduction')[$i]) . "', 
						driver_tips = '" . $this->db->escape_str($this->input->post('driver_tips')[$i]) . "', 
						settled_by = '" . $this->db->escape_str($this->input->post('settled_by')[$i]) . "', 
						settled_date = '" . $this->db->escape_str($order_date) . "', 
						created_at = '" . $created_at . "'");
				}
			}
		}
        $this->db->trans_complete();
		return $query2;
	}

	// function edit(){
	// 	$query = $this->db->query("UPDATE food_deliv_companies_orders SET company_id = '" . $this->db->escape_str((int)$this->input->post('company_id')) . "', rider_id = '" . $this->db->escape_str((int)$this->input->post('rider_id')) . "', orders = '" . $this->db->escape_str((int)$this->input->post('orders')) . "', total_earning = '" . $this->db->escape_str($this->input->post('total_earning')) . "', traffic_fine = '" . $this->db->escape_str($this->input->post('traffic_fine')) . "', wallet_received = '" . $this->db->escape_str($this->input->post('wallet_received')) . "', cash_received = '" . $this->db->escape_str($this->input->post('cash_received')) . "', pos_received = '" . $this->db->escape_str($this->input->post('pos_received')) . "', stcpay = '" . $this->db->escape_str($this->input->post('stcpay')) . "', stcpaym = '" . $this->db->escape_str($this->input->post('stcpaym')) . "', delivery_date = '" . $this->db->escape_str($this->input->post('delivery_date')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
	// 	return $query;
	// }
	
	function check_duplicate($company_id, $rider_id, $delivery_date){
		$this->db->select("*");  
		$this->db->from('food_deliv_companies_orders'); 
		$this->db->where('company_id =',$company_id);
		$this->db->where('rider_id =',$rider_id);
		$this->db->where('delivery_date =',$delivery_date);
		//$this->db->or_where('library.available_until =', "00-00-00 00:00:00");
		return $this->db->count_all_results();  
	}

	function get_list(){
		$a = "SELECT * FROM food_deliv_companies_orders fdco WHERE 1=1";
		if(isset($_POST["search"]["value"])){
			$a .= " AND fdco.rider_id LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY fdco.rider_id ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY fdco.id DESC";		   
		}       
		$query = $this->db->query($a);  
		return $query->result_array();  
	}

	function get_summary($riderFilter,$startDate,$endDate){
		$data = array();
		$db_orders = "SELECT DISTINCT rider_id FROM food_deliv_companies_orders WHERE 1=1";
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$db_orders .= " AND delivery_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		
		$a = "SELECT * FROM delivery_vehicles WHERE id IN ($db_orders)";
		if($riderFilter){
			$a .= " AND id = '" . $riderFilter . "'";
		}
		$a .= " ORDER BY name ASC";
		$inhouseDeliveryBoy = $this->db->query($a);

		$foodCompanies = $this->db->query("SELECT * FROM food_deliv_companies WHERE status = 'active' AND deleted = '0' ORDER BY company_name ASC");
		$countRider = $inhouseDeliveryBoy->num_rows();
		$countCompanies = $foodCompanies->num_rows();
		if($countRider > 0 && $countCompanies > 0){
			foreach ($inhouseDeliveryBoy->result() as $key => $value) {
				$child = array();
				$total_orders = 0;
				$total_earnings = 0;
				$total_cash = 0;
				$total_traffic_fine = 0;
				$total_id_fine = 0;
				$total_fuel_topup = 0;
				$total_hunger_topup = 0;
				$total_working_hrs = 0;
				$total_amount = 0;
				foreach($foodCompanies->result()  as $key1 => $value1){
					$b = "select id, rider_id, company_id, delivery_date, SUM(TIME_TO_SEC(online_hrs)) as total_working_hrs, SUM(orders) as total_orders, SUM(cash_received) as total_cash_received, SUM(pos_received) as total_pos_received, SUM(stcpay) as total_stc, SUM(stcpaym) as total_stcpaym, SUM(traffic_fine) as total_traffic, SUM(wallet_received) as total_wallet, SUM(total_earning) as total_earnings, SUM(hunger_topup) as total_hunger_topup, SUM(fuel_topup) as total_fuel_topup, SUM(id_fine) as total_id_fine FROM food_deliv_companies_orders WHERE (rider_id = '" . (int)$value->id . "' AND company_id = '" . (int)$value1->id . "')";
					if ($startDate && $endDate) {
						$period_start = date('Y-m-d', strtotime($startDate));
						$period_end = date('Y-m-d', strtotime($endDate));
						$b .= " AND delivery_date BETWEEN '".$period_start."' AND '".$period_end."'";
					}
					$sub_child = $this->db->query($b)->row_array();

					if(count($sub_child) > 0){
						$total_orders += $sub_child['total_orders'];
						$total_earnings += $sub_child['total_earnings'];
						$total_cash += $sub_child['total_cash_received'];
						$total_traffic_fine += $sub_child['total_traffic'];
						$total_id_fine += $sub_child['total_id_fine'];
						$total_fuel_topup += $sub_child['total_fuel_topup'];
						$total_hunger_topup += $sub_child['total_hunger_topup'];
						$total_working_hrs += $sub_child['total_working_hrs'];
						$total_amount += $sub_child['total_cash_received'] + $sub_child['total_pos_received'] + $sub_child['total_stc'] + $sub_child['total_stcpaym'] + $sub_child['total_wallet'];
						$child[] = array("id" => $sub_child['id'],
									"rider_id" => $value->id,
									"company_id" => $value1->id,
									"total_orders" => $sub_child['total_orders'],
									"total_earnings" => $sub_child['total_earnings'],
									"total_tfine" => $sub_child['total_traffic'],
									"total_wallet" => $sub_child['total_wallet'],
									"total_cash" => $sub_child['total_cash_received'],
									"total_pos" => $sub_child['total_pos_received'],
									"total_stc" => $sub_child['total_stc'],
									"total_stcpaym" => $sub_child['total_stcpaym']);
					}
				}
				$data[] = array("rider_id" => $value->id,
						"rider_name" => $value->name,
						"emp_id" => $value->driver_id,
						"total_orders" => $total_orders,
						"total_earnings" => $total_earnings,
						"total_cash" => $total_cash,
						"total_traffic_fine" => $total_traffic_fine,
						"total_id_fine" => $total_id_fine,
						"total_fuel_topup" => $total_fuel_topup,
						"total_hunger_topup" => $total_hunger_topup,
						"total_working_hrs" => $total_working_hrs,
						"total_amount" => $total_amount,
						"order_info" => $child);
			}
		}
		return $data;  
	}
	
	function get_summary_detail($rider_id,$startDate,$endDate){
		$data = array();
		$user_detail = $this->db->query("SELECT id, driver_id, name FROM delivery_vehicles WHERE id = '". $rider_id ."'")->row_array();

		$a = "SELECT * FROM food_deliv_companies WHERE status = 'active' AND deleted = '0'";
		/*
		if($companyFilter){
			$a .= " AND id = '" . $companyFilter . "'";
		}*/
		$a .= " ORDER BY company_name ASC";
		$foodCompanies = $this->db->query($a);
		$countCompanies = $foodCompanies->num_rows();

		if($countCompanies > 0){
			$child = array();
			foreach($foodCompanies->result_array()  as $key1 => $value1){
				$b = "select * FROM food_deliv_companies_orders WHERE (rider_id = '" . (int)$user_detail['id'] . "' AND company_id = '" . (int)$value1['id'] . "')";
				if ($startDate && $endDate) {
					$period_start = date('Y-m-d', strtotime($startDate));
					$period_end = date('Y-m-d', strtotime($endDate));
					$b .= " AND delivery_date BETWEEN '".$period_start."' AND '".$period_end."'";
				}
				$b .= " ORDER BY delivery_date DESC";
				$sub_child = $this->db->query($b)->result_array();

				if(count($sub_child) > 0){
					$order_info = array();
					foreach($sub_child as $order_list){
						$c = "select * FROM fdc_order_detail WHERE fdc_order_id = '" . (int)$order_list['id'] . "'";
						$order_detail = $this->db->query($c)->result_array();
						$order_info[] = array("order_info"=>$order_list,"order_detail"=>$order_detail);
					}
					$child[] = array("company_detail" => $value1,
								"orders" => $order_info);
				}
			}
			$data = array("rider_detail" => $user_detail,
					"order_info" => $child);
		}
		return $data;  
	}

	function get_quick_basic_detail(){
		$fds_id = $this->input->post("fdco_id");
		$set_date = date('Y-m-d', strtotime($this->input->post("entry_date")));
		$exit_date = date('Y-m-d', strtotime($this->input->post("exit_date")));
		$other_info = $this->db->query("SELECT fdco.*, fdc.company_name as company_name, dv.driver_id as driver_id, dv.name as driver_name FROM food_deliv_companies_orders fdco LEFT JOIN delivery_vehicles dv ON (fdco.rider_id = dv.id) LEFT JOIN food_deliv_companies fdc ON (fdco.company_id = fdc.id) WHERE fdco.id = '". $fds_id ."'");
		if($other_info->num_rows() > 0){
			$data['entry_date'] = $set_date;
			$data['exit_date'] = $exit_date;
			$data['other_info'] = $other_info->row_array();
			return $data;  					
		}else{
			return false;
		}
	}

	function get_quick_detail(){
		$fds_id = $this->input->post("fdco_id");
		$set_date = date('Y-m-d', strtotime($this->input->post("entry_date")));
		$exit_date = date('Y-m-d', strtotime($this->input->post("exit_date")));
		$other_info = $this->db->query("SELECT fdco.*, fdc.company_name as company_name, dv.driver_id as driver_id, dv.name as driver_name FROM food_deliv_companies_orders fdco LEFT JOIN delivery_vehicles dv ON (fdco.rider_id = dv.id) LEFT JOIN food_deliv_companies fdc ON (fdco.company_id = fdc.id) WHERE fdco.id = '". $fds_id ."'");
		$summary_list = $this->db->query("SELECT * FROM fdc_order_detail WHERE fdc_order_id = '". $fds_id ."' AND settled_date = '". $set_date ."'")->result();
		if($other_info->num_rows() > 0){
			$data['entry_date'] = $set_date;
			$data['exit_date'] = $exit_date;
			$data['other_info'] = $other_info->row_array();
			$data['summary_list'] = $summary_list;
			return $data;  					
		}else{
			return false;
		}
	}

	function single_summary_detail($fdc_id){
		$summary_info = $this->db->query("SELECT fdco.*, fdc.company_name as company_name, dv.driver_id as driver_id, dv.name as driver_name FROM food_deliv_companies_orders fdco LEFT JOIN delivery_vehicles dv ON (fdco.rider_id = dv.id) LEFT JOIN food_deliv_companies fdc ON (fdco.company_id = fdc.id) WHERE fdco.id = '". $fdc_id ."'");
		//print_r($summary_info->row_array());exit();
		if($summary_info->num_rows() > 0){
			$summary_list = $this->db->query("SELECT * FROM fdc_order_detail WHERE fdc_order_id = '". $fdc_id ."'")->result_array();
			$data['summary_info'] = $summary_info->row_array();
			$data['summary_list'] = $summary_list;
			return $data;  					
		}else{
			return false;
		}
	}

	function summary_detail_availbility(){
		$fds_id = $this->input->post("fdco_id");
		$set_date = date('Y-m-d', strtotime($this->input->post("entry_date")));
		$summary_list = $this->db->query("SELECT * FROM fdc_order_detail WHERE fdc_order_id = '". $fds_id ."' AND settled_date = '". $set_date ."'");
		if($summary_list->num_rows() > 0){
			return true;  					
		}else{
			return false;
		}
	}

	function delete($id){
		$query = $this->db->query("UPDATE food_deliv_companies_orders SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM food_deliv_companies_orders WHERE id = '" . (int)$id . "'");
		return $query;
	}

	function get_fdco_detail($rider_id,$company_id,$startDate,$endDate){
		$s_date = date('Y-m-d', strtotime($startDate));
		$e_date = date('Y-m-d', strtotime($endDate));
		$other_info = $this->db->query("SELECT fdco.*, fdc.company_name as company_name, dv.driver_id as driver_id, dv.name as driver_name FROM food_deliv_companies_orders fdco LEFT JOIN delivery_vehicles dv ON (fdco.rider_id = dv.id) LEFT JOIN food_deliv_companies fdc ON (fdco.company_id = fdc.id) WHERE fdco.rider_id = '". $rider_id ."' AND fdco.company_id = '". $company_id ."'");
		$order_result = $other_info->result_array();
		$order_ids = array_column($order_result, 'id');
		$final_order_ids = str_replace("'", "", implode(',', $order_ids));
		$summary_list = $this->db->query("SELECT * FROM fdc_order_detail WHERE (fdc_order_id IN (". $final_order_ids .") AND (settled_date BETWEEN '". $s_date ."' AND '". $e_date ."'))")->result();
		//print_r($summary_list);exit();
		if($other_info->num_rows() > 0){
			$data['entry_date'] = $s_date;
			$data['other_info'] = $other_info->row_array();
			$data['summary_list'] = $summary_list;
			return $data;  					
		}else{
			return false;
		}
	}
}
