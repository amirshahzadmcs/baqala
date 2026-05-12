<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Marshalling_model extends CI_Model{
	
	function get_van(){
		$this->db->select('o.delivery_boy, db.*');
		$this->db->from('orders AS o');
		$this->db->where('o.order_status_id = 4');
		$this->db->join('deliveryboy db', 'db.id = o.delivery_boy', 'left'); 
		$this->db->group_by('o.delivery_boy');
		$this->db->order_by('db.name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function ready_to_dispatch(){
		$this->db->select('o.delivery_boy, db.*');
		$this->db->from('orders AS o');
		$this->db->where('o.order_status_id = 5');
		$this->db->join('deliveryboy db', 'db.id = o.delivery_boy', 'left'); 
		$this->db->group_by('o.delivery_boy');
		$this->db->order_by('db.name', 'asc');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_order($id, $dbid){
		$query = $this->db->query("SELECT o.*, db.name as db_name, db.mobile as db_mob FROM `orders` o LEFT JOIN deliveryboy db ON(o.delivery_boy = db.id) WHERE o.id = '" . (int)$id . "' AND o.delivery_boy = '" . (int)$dbid . "'")->row_array();
		$sql = $this->db->query("SELECT * FROM order_product WHERE order_id = '" . (int)$id . "'")->result_array();
		$data = array("order"=>$query, "product"=>$sql);
		return $data;
	}
	
	function get_pending_by_dboy($id){
		$query = "SELECT * FROM `orders` WHERE delivery_boy = '" . (int)$id . "' AND order_status_id = '" . 4 . "'";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_from = date("Y-m-d", strtotime($v_from));
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			//print_r($d_to);exit();
			if($d_from AND $v_to){
				$query .= " AND `shipping_date_slot` >= '".$d_from."' AND shipping_date_slot <= '".$d_to."'";
			}
		}
        $query .= " ORDER BY shipping_date_slot DESC";
        $result = $this->db->query($query);
		return $result->result();
	}
	
	function get_dboy_by_id($id){
		$query = $this->db->query("SELECT id,name,mobile,arabic_name,van_no FROM deliveryboy WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	public function setStatusDispatch($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE orders SET order_status_id = '5', date_modified = NOW() WHERE id ='" . $id . "'");
	    }
	    return true;
	}
	
	public function addConsignments($ids) {
		$query = $this->db->query("SELECT SUM(packets) as total_packets, shipping_date_slot, shipping_time_slot, shipping_type FROM orders WHERE ID IN (" .$ids. ")")->result_array();
		$total_box = $query[0]['total_packets'];
		$date_slot = $query[0]['shipping_date_slot'];
		$time_slot = $query[0]['shipping_type'];
		$shipping_type = 'null';
		if($time_slot == 1){
			$shipping_type = 'ED';
		}else{
			$shipping_type = $time_slot;
		}
	    $query1 = $this->db->query("INSERT INTO consignments SET van_id = '" . $this->input->post('did') . "', van_no = '" . $this->input->post('van_no') . "', order_ids = '" . $ids . "', total_packets = '" . $total_box . "',  delivery_date = '" . $date_slot . "', delivery_time = '" . $shipping_type . "', delivery_executive = '" . $this->input->post('dname') . "', updated_at = NOW()");	
	    return $query1;
	}
	
	function get_order_by_ids($ids){
		$query = $this->db->query("SELECT id,invoice_prefix,name,email,mobile,tracking,shipping_time_slot,shipping_sector,shipping_complete_address,payment_method,order_total,packets,shipping_type FROM orders WHERE ID IN (" .$ids. ")");
		return $query->result();
	}
	
	function total_shipment_box($ids){
		$query = $this->db->query("SELECT SUM(packets) as total_packets FROM orders WHERE ID IN (" .$ids. ")");
		return $query->result();
	}

	function get_marshalling_list(){
		$sql = "SELECT * FROM consignments WHERE 1=1";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to. ' + 1 days'));
			if($v_from AND $v_to){
				$sql .= " AND `created_at` >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND `created_at` <='" . $d_to . "'";
			}
		}
		
		if($this->input->get('refFilter')) {
			$delvBoy = $this->input->get('refFilter');
            if($delvBoy != ''){
                $sql .= " AND `van_id` = '" . $delvBoy . "'";
            }
        }
        
        $sql .= " ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	function get_marshalling_list_by_id($id){
		$query = $this->db->query("SELECT * FROM `consignments` WHERE id ='" . $id . "'");	
		return $query->row();
	}
}
