<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model{

	function add(){
		$created_at = CURRENT_TIME;
        $this->db->trans_start();
		$query = $this->db->query("INSERT INTO fixed_assets SET 
		fa_category = '" . $this->db->escape_str($this->input->post('fa_category')) . "', 
		fa_subcategory = '" . $this->db->escape_str($this->input->post('fa_subcategory')) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		prod_sr_no = '" . $this->db->escape_str($this->input->post('prod_sr_no')) . "', 
		model_no = '" . $this->db->escape_str($this->input->post('model_no')) . "', 
		purchase_date = '" . $this->db->escape_str($this->input->post('purchase_date')) . "', 
		supplier_id = '" . $this->db->escape_str($this->input->post('supplier_id')) . "', 
		warranty_exp = '" . $this->db->escape_str($this->input->post('warranty_exp')) . "', 
		price = '" . $this->db->escape_str($this->input->post('price')) . "', 
		prod_condition = '" . $this->db->escape_str($this->input->post('prod_condition')) . "', 
		unit_value = '" . $this->db->escape_str($this->input->post('unit_value')) . "', 
		qty = '1', 
		value = '" . $this->db->escape_str($this->input->post('value')) . "', 
		ip = '" . $this->input->ip_address() . "', 
		status = '" . $this->input->post('status') . "'");
		$insert_id = $this->db->insert_id();
		if($query){
            $fa_code = $insert_id + 100;
		    $final_code = str_pad($fa_code, 6, 0, STR_PAD_LEFT);
		    $this->db->query("UPDATE fixed_assets SET fa_code = '" . $final_code . "' WHERE id = '" . (int)$insert_id . "'");
        }
		$this->db->trans_complete();
		return $query;
	}
	
	function edit(){
		$created_at = CURRENT_TIME;
        $this->db->trans_start();
		$query = $this->db->query("UPDATE fixed_assets SET 
		fa_category = '" . $this->db->escape_str($this->input->post('fa_category')) . "', 
		fa_subcategory = '" . $this->db->escape_str($this->input->post('fa_subcategory')) . "', 
		description = '" . $this->db->escape_str($this->input->post('description')) . "', 
		prod_sr_no = '" . $this->db->escape_str($this->input->post('prod_sr_no')) . "', 
		model_no = '" . $this->db->escape_str($this->input->post('model_no')) . "', 
		purchase_date = '" . $this->db->escape_str($this->input->post('purchase_date')) . "', 
		supplier_id = '" . $this->db->escape_str($this->input->post('supplier_id')) . "', 
		warranty_exp = '" . $this->db->escape_str($this->input->post('warranty_exp')) . "', 
		price = '" . $this->db->escape_str($this->input->post('price')) . "', 
		prod_condition = '" . $this->db->escape_str($this->input->post('prod_condition')) . "', 
		unit_value = '" . $this->db->escape_str($this->input->post('unit_value')) . "', 
		qty = '1', 
		value = '" . $this->db->escape_str($this->input->post('value')) . "', 
		ip = '" . $this->input->ip_address() . "', 
		status = '" . $this->input->post('status') . "', 
		updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		$this->db->trans_complete();
		return $query;
	}
	
	function allot_assets(){
		$created_at = CURRENT_TIME;
		$assets_id = $this->input->post('assets_id');
		$emp_id = $this->input->post('emp_id');
		$emp_type = $this->input->post('emp_type');
		$emp_name = $this->input->post('emp_name');
		$emp_designation = $this->input->post('emp_designation');
		$remarks = $this->input->post('remarks');
		$status = 'allot';
		$is_alloted = '1';
        $this->db->trans_start();
		$query = $this->db->query("UPDATE fixed_assets SET is_alloted = '" . $is_alloted . "', 
		emp_id = '" . $emp_id . "', 
		emp_type = '" . $emp_type . "', 
		emp_designation = '" . $emp_designation . "', 
		emp_name = '" . $emp_name . "', 
		allotment_date = '" . $created_at . "', 
		ip = '" . $this->input->ip_address() . "', 
		updated_at = now() WHERE id = '" . (int)$assets_id . "'");
		if($query){
		    $this->db->query("INSERT INTO assets_allot_log SET assets_id = '" . $assets_id . "', employee_id = '" . $emp_id . "', emp_name = '" . $emp_name . "', desig_location = '" . $emp_designation . "', emp_table = '" . $emp_type . "', status = '" . $status . "', remarks = '" . $remarks . "',  created_at = '" . $created_at . "'");
        }
		$this->db->trans_complete();
		return $query;
	}

	function unallot_assets(){
		$created_at = CURRENT_TIME;
		$assets_id = $this->input->post('assets_id');
		$remarks = $this->input->post('remarks');
		$old_data = $this->db->query("SELECT * FROM fixed_assets WHERE id ='". $assets_id ."'")->row();
		
		$emp_id = $old_data->emp_id;
		$emp_type = $old_data->emp_type;
		$emp_designation = $old_data->emp_designation;
		$emp_name = $old_data->emp_name;
		$status = 'unallot';
		$is_alloted = '0';

        $this->db->trans_start();
		$query = $this->db->query("UPDATE fixed_assets SET is_alloted = '" . $is_alloted . "', 
		emp_id = '', 
		emp_type = '', 
		emp_designation = '', 
		allotment_date = '', 
		emp_name = '', 
		ip = '" . $this->input->ip_address() . "', 
		updated_at = now() WHERE id = '" . (int)$assets_id . "'");
		if($query){
		    $this->db->query("INSERT INTO assets_allot_log SET assets_id = '" . $assets_id . "', employee_id = '" . $emp_id . "', emp_name = '" . $emp_name . "', desig_location = '" . $emp_designation . "', emp_table = '" . $emp_type . "', status = '" . $status . "', remarks = '" . $remarks . "', created_at = '" . $created_at . "'");
        }
		$this->db->trans_complete();
		return $query;
	}

	function make_query(){
		$a = "SELECT fa.*, v.vendor_name, ac.category_name, (SELECT asub.subcategory_name FROM assets_subcategory asub WHERE fa.fa_subcategory = asub.id) as sub_cat_name FROM fixed_assets fa LEFT JOIN assets_category ac ON (fa.fa_category = ac.id) LEFT JOIN vendors v ON (fa.supplier_id = v.id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND (fa.description LIKE '%".$_POST["search"]["value"]."%' OR fa.fa_code LIKE '%".$_POST["search"]["value"]."%')";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY fa.description ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY fa.description ASC";		   
		}		   
		if($_POST["length"] != -1){
			$a .= " LIMIT ".$_POST['start']." ,".$_POST['length']."";
		}        
		$query = $this->db->query($a);  
		return $query->result();  
	}

	function get_filtered_data(){
		$a = $this->make_query();
		$query = $this->db->query($a);  
		return $query->num_rows();  
	}

	function get_all_data(){
		$this->db->select("*");  
		$this->db->from('fixed_assets');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM fixed_assets WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT fa.*, v.vendor_name, ac.category_name, (SELECT asub.subcategory_name FROM assets_subcategory asub WHERE fa.fa_subcategory = asub.id) as sub_cat_name FROM fixed_assets fa LEFT JOIN assets_category ac ON (fa.fa_category = ac.id) LEFT JOIN vendors v ON (fa.supplier_id = v.id) WHERE fa.id = '" . (int)$id . "'");
		return $query;
	}
	
	function assets_log($id){
		$query = $this->db->query("SELECT asl.* FROM assets_allot_log asl WHERE asl.assets_id = '" . (int)$id . "'");
		return $query->result_array();
	}

}
