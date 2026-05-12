<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends CI_Model{

	function get_summary($riderFilter,$attendanceMonth){
		$data = array();
		$a = "SELECT * FROM delivery_vehicles WHERE status = '1' AND application_status = 'verified'";
		if($riderFilter){
			$a .= " AND id = '" . $riderFilter . "'";
		}
		$a .= " ORDER BY name ASC";
		$inhouseDeliveryBoy = $this->db->query($a);

        $pass_date = strtotime($attendanceMonth);
        $total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));

		$countRider = $inhouseDeliveryBoy->num_rows();
		if($countRider > 0){
			foreach ($inhouseDeliveryBoy->result() as $key => $value) {
				$child = array();
				for ($i=0; $i < $total_days; $i++) {
					
					$b = "select id, rider_id, attend_type, date_of_attend, remarks FROM rider_attendance WHERE rider_id = '" . (int)$value->id . "'";
					if ($attendanceMonth) {
						$attend_date = date('Y-m-d', strtotime($attendanceMonth. ' + '. $i .' days'));
						$attend_day = date('D', strtotime($attend_date));
						$b .= " AND DATE(date_of_attend) = '". DATE($attend_date) ."'";
					}
					$countAttend = $this->db->query($b)->num_rows();
					$sub_child = $this->db->query($b)->row_array();
					if($countAttend > 0){
						$child[] = array("id" => $sub_child['id'],
										"rider_id" => $value->id,
										"date" => $attend_date,
										"day" => $attend_day,
										"remarks" => $sub_child['remarks'],
										"attend_type" => $sub_child['attend_type']);
					}else{
						$child[] = array("id" => 'NA',
										"rider_id" => $value->id,
										"date" => $attend_date,
										"day" => $attend_day,
										"remarks" => 'NA',
										"attend_type" => 'NA');
					}
				}
				//echo '<pre>';print_r($child);exit();
				$data[] = array("rider_id" => $value->id,
						"rider_name" => $value->name,
						"emp_id" => $value->driver_id,
						"order_info" => $child);
			}
		}
        //echo '<pre>';print_r($data);exit();
		return $data;  
	}

	
	//old code
	function get_summary_old($riderFilter,$attendanceMonth){
		$data = array();
		$db_orders = "SELECT DISTINCT rider_id FROM food_deliv_companies_orders WHERE 1=1";
		/*
        if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$db_orders .= " AND delivery_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		*/
		
		$a = "SELECT * FROM delivery_vehicles WHERE id IN ($db_orders)";
		if($riderFilter){
			$a .= " AND id = '" . $riderFilter . "'";
		}
		$a .= " ORDER BY name ASC";
		$inhouseDeliveryBoy = $this->db->query($a);

        $pass_date = strtotime($attendanceMonth);
        $total_days = cal_days_in_month(CAL_GREGORIAN, date('m', $pass_date), date('Y', $pass_date));
        //print_r($total_days);exit();

		$countRider = $inhouseDeliveryBoy->num_rows();

		$order_array = array();
		for ($ij=0; $ij < $total_days; $ij++) {
			$c_date = date('Y-m-d', strtotime($attendanceMonth. ' + '. $ij .' days'));
			$order_array[] = $this->db->query("SELECT DISTINCT COUNT(rider_id) as aval_rider, delivery_date FROM food_deliv_companies_orders WHERE (orders > 0 AND DATE(delivery_date) = '". DATE($c_date) ."')")->row();
		}

		if($countRider > 0){
			foreach ($inhouseDeliveryBoy->result() as $key => $value) {
				$child = array();
				$total_orders = 0;
				$total_earnings = 0;
				$total_amount = 0;
				for ($i=0; $i < $total_days; $i++) {
					$b = "select id, rider_id, company_id, delivery_date, IF(SUM(orders) > 0, 1, 0) as total_orders FROM food_deliv_companies_orders WHERE rider_id = '" . (int)$value->id . "'";
					if ($attendanceMonth) {
						$attend_date = date('Y-m-d', strtotime($attendanceMonth. ' + '. $i .' days'));
						$attend_day = date('D', strtotime($attend_date));
						$b .= " AND DATE(delivery_date) = '". DATE($attend_date) ."'";
					}
					$sub_child = $this->db->query($b)->row_array();
					$child[] = array("id" => $sub_child['id'],
									"rider_id" => $value->id,
									"date" => $attend_date,
									"day" => $attend_day,
									"total_orders" => $sub_child['total_orders']);
				}
				$data[] = array("rider_id" => $value->id,
						"rider_name" => $value->name,
						"emp_id" => $value->driver_id,
						"sum_total" => $order_array,
						"order_info" => $child);
			}
		}
        //echo '<pre>';print_r($data);exit();
		return $data;  
	}
	
	function add_attendance(){
		if ($this->input->post('rider_id')){
			$attendance_date = $this->input->post('attend_date');
			$rider_count = count($this->input->post('rider_id'));
			$orderitem = array();
			for($l=0;$l<$rider_count;$l++){
				$rider_id = $this->input->post('rider_id')[$l];
				$mark_attend = $this->input->post('mark_attend')[$l];
				$remarks = $this->input->post('remarks')[$l];
				$orderitem[] = array('rider_id' =>$rider_id,'attend_type' =>$mark_attend,'date_of_attend' =>$attendance_date,'remarks' =>$remarks);
			}
			$this->db->insert_batch('rider_attendance', $orderitem); 
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) 
			{
				$this->db->trans_rollback();
				return FALSE;
			} 
			else 
			{
				$this->db->trans_commit();
				return TRUE;
			}
		}
	}
	
	function check_data_exists($attend_date) {
		$this->db->where('date_of_attend', $attend_date);
		$query = $this->db->get('rider_attendance');
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
