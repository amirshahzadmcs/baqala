<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MobInvoice_model extends CI_Model{
	
	function add(){
		$con['upload_path']   = './uploads/invoice/'; 
		$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
		$this->db->trans_start();
		$period = date('Y-m-d', strtotime($this->db->escape_str($this->input->post('period'))));
		$sim_detail = $this->db->query("SELECT * FROM sim_card WHERE id = '" . (int)$this->input->post('sim_id') . "'")->row_array();
		if(count($sim_detail) > 0){
			$query = $this->db->query("INSERT INTO mobile_invoice SET 
				invoice_no = '" . $this->db->escape_str($this->input->post('invoice_no')) . "', 
				group_invoice = '" . $this->db->escape_str($this->input->post('group_invoice')) . "', 
				sim_id = '" . $this->db->escape_str($this->input->post('sim_id')) . "', 
				network = '" . $sim_detail['network'] . "', 
				alloted_user = '" . $sim_detail['alloted_user'] . "', 
				alloted_vehicle = '" . $sim_detail['gps_installed_vehicle'] . "', 
				period = '" . $this->db->escape_str($period) . "', 
				plan_id = '" . $sim_detail['plan'] . "', 
				previous_bal = '" . $this->db->escape_str($this->input->post('previous_bal')) . "', 
				fee = '" . $this->db->escape_str($this->input->post('fee')) . "', 
				off_plan = '" . $this->db->escape_str($this->input->post('off_plan')) . "', 
				add_on = '" . $this->db->escape_str($this->input->post('add_on')) . "', 
				offplan_deduct_payslip = '" . $this->db->escape_str($this->input->post('offplan_deduct_payslip')) . "', 
				addon_deduct_payslip = '" . $this->db->escape_str($this->input->post('addon_deduct_payslip')) . "', 
				adjustment = '" . $this->db->escape_str($this->input->post('adjustment')) . "', 
				discount = '" . $this->db->escape_str($this->input->post('discount')) . "', 
				installment = '" . $this->db->escape_str($this->input->post('installment')) . "', 
				vat_percent = '" . $this->db->escape_str($this->input->post('vat_percent')) . "', 
				total_amount = '" . $this->db->escape_str($this->input->post('total_amount')) . "', 
				payment_source = '" . $this->db->escape_str($this->input->post('payment_source')) . "', 
				created_at = NOW(), 
				updated_at = now()");
			$insert_id = $this->db->insert_id();
			if($query){
				if($_FILES['attachment']['name'][0] !== '' && count($_FILES['attachment']['tmp_name']) > 0){
					$image_count = count($_FILES['attachment']['name']);
					for($o=0;$o<$image_count;$o++){
						$_FILES['attachment']['name']= $_FILES['attachment']['name'][$o];
						$_FILES['attachment']['type']= $_FILES['attachment']['type'][$o];
						$_FILES['attachment']['tmp_name']= $_FILES['attachment']['tmp_name'][$o];
						$_FILES['attachment']['error']= $_FILES['attachment']['error'][$o];
						$_FILES['attachment']['size']= $_FILES['attachment']['size'][$o];    
						
						$this->load->library('upload', $con);
						$this->upload->do_upload('attachment');
						$image_da = $this->upload->data();
						$attachment = "uploads/invoice/".$image_da['file_name'];
						$this->db->query("INSERT INTO all_documents SET item_id = '" . (int)$insert_id . "', file_name = '" . $this->db->escape_str($attachment) . "', file_type = 'invoice', status = '1', created_at = NOW()");
					}
				}
			}
		}
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$con['upload_path']   = './uploads/invoice/'; 
		$con['allowed_types'] = 'jpg|png|jpeg|doc|docx|pdf'; 
		$con['maintain_ratio'] = TRUE;
		$con['max_filename'] = '50';
		$con['encrypt_name'] = TRUE;
		$this->db->trans_start();
		$period = date('Y-m-d', strtotime($this->db->escape_str($this->input->post('period'))));
		$sim_detail = $this->db->query("SELECT * FROM sim_card WHERE id = '" . (int)$this->input->post('sim_id') . "'")->row_array();
		if(count($sim_detail) > 0){
			$query = $this->db->query("UPDATE mobile_invoice SET 
				invoice_no = '" . $this->db->escape_str($this->input->post('invoice_no')) . "', 
				group_invoice = '" . $this->db->escape_str($this->input->post('group_invoice')) . "', 
				sim_id = '" . $this->db->escape_str($this->input->post('sim_id')) . "', 
				network = '" . $sim_detail['network'] . "', 
				alloted_user = '" . $sim_detail['alloted_user'] . "', 
				alloted_vehicle = '" . $sim_detail['gps_installed_vehicle'] . "', 
				period = '" . $this->db->escape_str($period) . "', 
				plan_id = '" . $sim_detail['plan'] . "', 
				previous_bal = '" . $this->db->escape_str($this->input->post('previous_bal')) . "', 
				fee = '" . $this->db->escape_str($this->input->post('fee')) . "', 
				off_plan = '" . $this->db->escape_str($this->input->post('off_plan')) . "', 
				add_on = '" . $this->db->escape_str($this->input->post('add_on')) . "', 
				offplan_deduct_payslip = '" . $this->db->escape_str($this->input->post('offplan_deduct_payslip')) . "', 
				addon_deduct_payslip = '" . $this->db->escape_str($this->input->post('addon_deduct_payslip')) . "', 
				adjustment = '" . $this->db->escape_str($this->input->post('adjustment')) . "', 
				discount = '" . $this->db->escape_str($this->input->post('discount')) . "', 
				installment = '" . $this->db->escape_str($this->input->post('installment')) . "', 
				vat_percent = '" . $this->db->escape_str($this->input->post('vat_percent')) . "', 
				total_amount = '" . $this->db->escape_str($this->input->post('total_amount')) . "', 
				payment_source = '" . $this->db->escape_str($this->input->post('payment_source')) . "', 
				updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
			$insert_id = $this->input->post('id');
			if($query){
				if($_FILES['attachment']['name'][0] !== '' && count($_FILES['attachment']['tmp_name']) > 0){
					$image_count = count($_FILES['attachment']['name']);
					for($o=0;$o<$image_count;$o++){
						$_FILES['attachment']['name']= $_FILES['attachment']['name'][$o];
						$_FILES['attachment']['type']= $_FILES['attachment']['type'][$o];
						$_FILES['attachment']['tmp_name']= $_FILES['attachment']['tmp_name'][$o];
						$_FILES['attachment']['error']= $_FILES['attachment']['error'][$o];
						$_FILES['attachment']['size']= $_FILES['attachment']['size'][$o];    
						
						$this->load->library('upload', $con);
						$this->upload->do_upload('attachment');
						$image_da = $this->upload->data();
						$attachment = "uploads/invoice/".$image_da['file_name'];
						$this->db->query("INSERT INTO all_documents SET item_id = '" . (int)$insert_id . "', file_name = '" . $this->db->escape_str($attachment) . "', file_type = 'invoice', status = '1', created_at = NOW()");
					}
				}
			}
		}
		$this->db->trans_complete();

		return $query;
	}
	
	function update_payment(){
		$query = $this->db->query("UPDATE mobile_invoice SET amount_paid = '" . $this->db->escape_str($this->input->post('amount_paid')) . "', payment_source = '" . $this->db->escape_str($this->input->post('payment_source')) . "', date_of_payment = '" . $this->db->escape_str($this->input->post('date_of_payment')) . "', status = '1', updated_at = now() WHERE id = '" . (int)$this->input->post('invoice_id') . "' LIMIT 1");
		return $query;
	}

	function make_query($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim){
		$a = "SELECT s.*, mp.plan_name, mn.network_name, me.full_name, sc.sim_no, sc.mobile, sc.owner_name, sc.is_gps_sim, sc.gps_installed_vehicle FROM mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network as mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) WHERE 1=1";
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
		if($is_gps_sim){
			$a .= " AND sc.is_gps_sim = '" . $is_gps_sim . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND s.period BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if($inv_no){
			$a .= " AND (s.invoice_no LIKE '%".$inv_no."%')";
		}
		return $a;
	}
	
	function get_list($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim){
		$a = $this->make_query($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim);
		
		// if(isset($_POST["order"])){             
		// 	$a .= " ORDER BY s.id ". $_POST['order']['0']['dir'] ."";
		// }  
        // else{  
		// 	$a .= " ORDER BY s.id DESC";		   
        // }	
		$a .= " ORDER BY s.id DESC";	   
        if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
        }        
        $query = $this->db->query($a);  
        return $query->result();  
    }
	  
    function get_filtered_data($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim){
	   $a = $this->make_query($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim);
	   $query = $this->db->query($a);  
	   return $query->num_rows();  
    }
     
    function get_all_data(){
	   $this->db->select("*");  
	   $this->db->from('mobile_invoice');  
	   return $this->db->count_all_results();
    }

	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM mobile_invoice WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	public function get_inv_emp_list()
	{
		$query = $this->db->query("SELECT me.* FROM master_employee me WHERE me.id IN (SELECT mi.alloted_user from mobile_invoice mi WHERE 1=1) AND 1=1");
		return $query->result();
	}

	public function get_inv_sim_list()
	{
		$query = $this->db->query("SELECT sc.* FROM sim_card sc WHERE sc.id IN (SELECT mi.sim_id from mobile_invoice mi WHERE 1=1) AND 1=1");
		return $query->result();
	}
	
	public function get_sims()
	{
		$a = "SELECT s.*, s.status as allot_status, me.full_name FROM sim_card s LEFT JOIN master_employee me ON (s.alloted_user = me.id) WHERE s.status = '1' AND s.sim_type = 'postpaid' ORDER BY s.mobile ASC";
		$query = $this->db->query($a);  
        return $query->result();
	}

	function get_sim_detail($id){
		$query = $this->db->query("SELECT s.*, mp.plan_name, mn.network_name, IF (s.allotment > 0, me.full_name, 'NA') emp_full_name, me.emp_no FROM sim_card s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN master_plans as mp ON (s.plan = mp.id) LEFT JOIN master_network as mn ON (s.network = mn.id) WHERE s.id = '" . (int)$id . "'");
		return $query->row();
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT s.*, mp.plan_name, me.full_name, sc.sim_no, sc.mobile, sc.is_gps_sim, sc.gps_installed_vehicle FROM mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) WHERE s.id = '" . (int)$id . "'");
		// print_r($query);die();
		return $query->row();
	}

	function get_docs($id){
		$this->db->select("*");  
		$this->db->from('all_documents');  
		$this->db->where('file_type', 'invoice');  
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
	
    public function get_consolidate_plans($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim)
	{
		$a = "SELECT s.*, mp.plan_name, mn.network_name, me.emp_no, me.full_name, me.department, me.designation, mjt.name as designation_name, md.name as department_name, sc.sim_no, sc.mobile, sc.owner_name, sc.is_gps_sim, sc.gps_installed_vehicle, SUM(s.fee) as fee, SUM(s.previous_bal) as previous_bal, SUM(s.off_plan) as off_plan, SUM(s.add_on) as add_on, SUM(s.adjustment) as adjustment, SUM(s.discount) as discount, SUM(s.installment) as installment FROM mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1";
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
		if($is_gps_sim){
			$a .= " AND sc.is_gps_sim = '" . $is_gps_sim . "'";
		}
		if ($startDate && $endDate) {
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND s.period BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if($inv_no){
			$a .= " AND (s.invoice_no LIKE '%".$inv_no."%')";
		}

		$a .= " GROUP BY s.sim_id";
		$a .= " ORDER BY me.first_name ASC";
		$query = $this->db->query($a);  
        return $query->result(); 
	}
	
	function print_report($inv_no,$sim_no,$network,$plan,$owner,$startDate,$endDate,$user,$is_gps_sim){
		$a = "SELECT s.*, sc.owner_name, mp.plan_name, mn.network_name, me.emp_no, me.full_name, me.department, me.designation, mjt.name as designation_name, md.name as department_name, sc.sim_no, sc.mobile, sc.is_gps_sim, sc.gps_installed_vehicle FROM mobile_invoice s LEFT JOIN master_employee me ON (s.alloted_user = me.id) LEFT JOIN sim_card sc ON (s.sim_id = sc.id) LEFT JOIN master_network mn ON (s.network = mn.id) LEFT JOIN master_plans as mp ON (s.plan_id = mp.id) LEFT JOIN master_department as md ON (me.department = md.id) LEFT JOIN master_job_title as mjt ON (me.designation = mjt.id) WHERE 1=1";
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
		if($is_gps_sim){
			$a .= " AND sc.is_gps_sim = '" . $is_gps_sim . "'";
		}
		if($startDate && $endDate){
			$period_start = date('Y-m-d', strtotime($startDate));
			$period_end = date('Y-m-d', strtotime($endDate));
			$a .= " AND s.period BETWEEN '".$period_start."' AND '".$period_end."'";
		}
		if($inv_no){
			$a .= " AND (s.invoice_no LIKE '%".$inv_no."%')";
		}
		$query = $this->db->query($a);  
		return $query->result();
	}

	/*---- Custom Validation Checks ----*/
	function check_invoice_exists($sim_id, $period, $id) {
        $this->db->where('period', $period);
        $this->db->where('sim_id', $sim_id);
        $this->db->where('id !=', $id);
        $query = $this->db->get('mobile_invoice');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

	function check_prevoius_paid($sim_id, $id) {
        $this->db->where('sim_id', $sim_id);
        $this->db->where('id !=', $id);
        $this->db->where('status =', '0');
        $query = $this->db->get('mobile_invoice');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

	function check_invoice_no_exists($invoice_no, $id) {
        $this->db->where('invoice_no', $invoice_no);
        $this->db->where('id !=', $id);
        $query = $this->db->get('mobile_invoice');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
}
