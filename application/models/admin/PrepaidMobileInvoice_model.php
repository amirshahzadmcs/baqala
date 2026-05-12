<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PrepaidMobileInvoice_model extends CI_Model{
	
	function add(){
		$this->db->trans_start();
		$sim_id = $this->input->post('sim_id');
		$voucher_id = $this->input->post('voucher_id');
		$sim_detail = $this->db->query("SELECT * FROM sim_card WHERE id = '" . (int)$sim_id . "'")->row_array();
		$voucher_detail = $this->db->query("SELECT srvl.*, srv.id as main_id, srv.sim_network, srv.voucher_value as unit_price, srv.voucher_vat as unit_vat FROM sim_recharge_vouchers_list srvl LEFT JOIN sim_recharge_vouchers srv ON (srvl.group_id = srv.id) WHERE srvl.id = '" . $voucher_id . "' AND srvl.status='0'")->row_array();
		//print_r($voucher_detail);exit();
		if(count($sim_detail) > 0 && count($voucher_detail) > 0){
			$total_value = $voucher_detail['unit_price'] + $voucher_detail['unit_vat'];
			$query = $this->db->query("INSERT INTO prepaid_mobile_invoice SET 
				sim_id = '" . $sim_detail['id'] . "', 
				invoice_no = '" . $sim_detail['network'] . "', 
				network = '" . $sim_detail['network'] . "', 
				alloted_user = '" . $sim_detail['alloted_user'] . "', 
				alloted_vehicle = '" . $sim_detail['gps_installed_vehicle'] . "', 
				recharge_date = '" . $this->db->escape_str($this->input->post('recharge_date')) . "', 
				plan_id = '" . $sim_detail['plan'] . "', 
				voucher_value = '" . $voucher_detail['unit_price'] . "', 
				voucher_vat = '" . $voucher_detail['unit_vat'] . "', 
				total_amount = '" . $total_value . "', 
				voucher_id = '" . $voucher_detail['id'] . "', 
				payment_source = 'Recharge Card', 
				created_at = '" . CURRENT_TIME . "'");
			$insert_id = $this->db->insert_id();
			if($query){
				$query = $this->db->query("UPDATE sim_recharge_vouchers_list SET status = '1', sim_id = '". $sim_detail['id'] ."', invoice_id = '". $insert_id ."', used_date = '". $this->db->escape_str($this->input->post('recharge_date')) ."' WHERE id = '". $voucher_detail['id'] ."' LIMIT 1");
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function make_query($sim_no,$network,$plan,$owner,$startDate,$endDate,$user){
		$a = "SELECT s.*, mp.plan_name, mn.network_name, srvl.serial_no, me.full_name, me.emp_no, sc.sim_no, sc.mobile, sc.owner_name FROM prepaid_mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network as mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) LEFT JOIN sim_recharge_vouchers_list as srvl ON (s.voucher_id = srvl.id) WHERE 1=1";
		if($user){
			$a .= " AND s.alloted_user = '" . $user . "'";
		}
		if($sim_no){
			$a .= " AND s.sim_id = '" . $sim_no . "'";
		}
		if($network){
			$a .= " AND s.network = '" . $network . "'";
		}
		if($plan){
			$a .= " AND s.plan_id = '" . $plan . "'";
		}
		if($owner){
			$a .= " AND sc.owner_name = '" . $owner . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate . ' +1 day'));
			$a .= " AND s.recharge_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		return $a;
	}
	
	function get_list($sim_no,$network,$plan,$owner,$startDate,$endDate,$user){
		$a = $this->make_query($sim_no,$network,$plan,$owner,$startDate,$endDate,$user);
		
		if(isset($_POST["order"])){             
			$a .= " ORDER BY s.id ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY s.id DESC";		   
        }		   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($sim_no,$network,$plan,$owner,$startDate,$endDate,$user){
	   $a = $this->make_query($sim_no,$network,$plan,$owner,$startDate,$endDate,$user);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('prepaid_mobile_invoice');  
	   return $this->db->count_all_results();
    }

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM prepaid_mobile_invoice WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	public function get_inv_emp_list()
	{
		$query = $this->db->query("SELECT me.* FROM master_employee me WHERE me.id IN (SELECT mi.alloted_user from prepaid_mobile_invoice mi WHERE 1=1) AND 1=1");
		return $query->result();
	}

	public function get_inv_sim_list()
	{
		$query = $this->db->query("SELECT sc.* FROM sim_card sc WHERE sc.id IN (SELECT mi.sim_id from prepaid_mobile_invoice mi WHERE 1=1) AND 1=1");
		return $query->result();
	}

	public function get_sims()
	{
		$a = "SELECT s.*, s.status as allot_status, me.full_name FROM sim_card s LEFT JOIN master_employee me ON (s.alloted_user = me.id) WHERE s.status = '1' AND s.sim_type = 'prepaid' ORDER BY s.mobile ASC";
		$query = $this->db->query($a);  
        return $query->result();
	}

	function get_detail($id){
		$query = $this->db->query("SELECT s.*, mp.plan_name, mn.network_name, srvl.serial_no, me.full_name, me.emp_no, sc.sim_no, sc.mobile, sc.owner_name FROM prepaid_mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network as mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) LEFT JOIN sim_recharge_vouchers_list as srvl ON (s.voucher_id = srvl.id) WHERE s.id = '" . (int)$id . "'");
		// print_r($query);die();
		return $query->row();
	}

	function get_sim_detail($id){
		$query = $this->db->query("SELECT s.*, mp.plan_name, mn.network_name, IF (s.allotment > 0, me.full_name, 'NA') emp_full_name, me.emp_no FROM sim_card s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN master_plans as mp ON (s.plan = mp.id) LEFT JOIN master_network as mn ON (s.network = mn.id) WHERE s.id = '" . (int)$id . "'");
		return $query->row();
	}

	function last_recharge_detail($sim_id){
		$query = $this->db->query("SELECT s.* FROM prepaid_mobile_invoice s WHERE s.sim_id = '" . (int)$sim_id . "' ORDER BY recharge_date DESC");
		return $query->row();
	}

	function get_docs($id){
		$this->db->select("*");  
		$this->db->from('all_documents');  
		$this->db->where('file_type', 'prepaid_invoice');  
		$this->db->where('item_id', (int)$id);  
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function delete_image(){
		$id = $this->input->post('img_id');
		$item_id = $this->input->post('item_id');
		$query = $this->db->query("DELETE FROM all_documents WHERE id = '" . (int)$id . "' AND item_id = '". (int)$item_id ."' LIMIT 1");
		return $query;
	}
	
    public function get_consolidate_plans($sim_no,$network,$plan,$owner,$startDate,$endDate,$user)
	{
		$a = "SELECT s.*, mp.plan_name, mn.network_name, me.emp_no, me.first_name, me.second_name, me.third_name, me.last_name, me.full_name, me.department, me.designation, mjt.name as designation_name, md.name as department_name, sc.sim_no, sc.mobile, sc.owner_name FROM prepaid_mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1";
		if($user){
			$a .= " AND s.alloted_user = '" . $user . "'";
		}
		if($sim_no){
			$a .= " AND s.sim_id = '" . $sim_no . "'";
		}
		if($network){
			$a .= " AND s.network = '" . $network . "'";
		}
		if($plan){
			$a .= " AND s.plan_id = '" . $plan . "'";
		}
		if($owner){
			$a .= " AND sc.owner_name = '" . $owner . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate . ' +1 day'));
			$a .= " AND s.recharge_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		$a .= " GROUP BY s.sim_id";
		$a .= " ORDER BY me.first_name ASC";
		$query = $this->db->query($a);  
        return $query->result(); 
	}
	
	function print_report($sim_no,$network,$plan,$owner,$startDate,$endDate,$user){
		$a = "SELECT s.*, mp.plan_name, mn.network_name, srvl.serial_no, me.full_name, me.emp_no, sc.sim_no, sc.mobile, sc.owner_name FROM prepaid_mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network as mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) LEFT JOIN sim_recharge_vouchers_list as srvl ON (s.voucher_id = srvl.id) WHERE 1=1";
		if($user){
			$a .= " AND s.alloted_user = '" . $user . "'";
		}
		if($sim_no){
			$a .= " AND s.sim_id = '" . $sim_no . "'";
		}
		if($network){
			$a .= " AND s.network = '" . $network . "'";
		}
		if($plan){
			$a .= " AND s.plan_id = '" . $plan . "'";
		}
		if($owner){
			$a .= " AND sc.owner_name = '" . $owner . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate . ' +1 day'));
			$a .= " AND s.recharge_date BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		$query = $this->db->query($a);  
		return $query->result();
	}

	/*---- Custom Validation Checks ----*/
	function check_invoice_exists($voucher_id, $id) {
        $this->db->where('voucher_id', $voucher_id);
        $this->db->where('id !=', $id);
        $query = $this->db->get('prepaid_mobile_invoice');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

	function check_invoice_no_exists($invoice_no, $id) {
        $this->db->where('invoice_no', $invoice_no);
        $this->db->where('id !=', $id);
        $query = $this->db->get('prepaid_mobile_invoice');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
}
