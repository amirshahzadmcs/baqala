<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses_model extends CI_Model{

	function add($image){
		$query = $this->db->query("INSERT INTO expenses_vat_entry SET branch_code = '" . $this->db->escape_str($this->input->post('branch_code')) . "', date = '" . $this->db->escape_str($this->input->post('date')) . "', invoice_number = '" . $this->db->escape_str($this->input->post('invoice_number')) . "', item_description = '" . $this->db->escape_str($this->input->post('item_description')) . "', supplier_name = '" . $this->db->escape_str($this->input->post('supplier_name')) . "', supplier_arabic_name = '" . $this->db->escape_str($this->input->post('supplier_arabic_name')) . "', supplier_vat_no = '" . $this->db->escape_str($this->input->post('supplier_vat_no')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', image = '" . $this->db->escape_str($image) . "', amt_bef_vat = '" . $this->db->escape_str($this->input->post('amt_bef_vat')) . "', tax = '" . $this->db->escape_str($this->input->post('tax')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit($image){
		$query = $this->db->query("UPDATE expenses_vat_entry SET branch_code = '" . $this->db->escape_str($this->input->post('branch_code')) . "', date = '" . $this->db->escape_str($this->input->post('date')) . "', invoice_number = '" . $this->db->escape_str($this->input->post('invoice_number')) . "', item_description = '" . $this->db->escape_str($this->input->post('item_description')) . "', supplier_name = '" . $this->db->escape_str($this->input->post('supplier_name')) . "', supplier_arabic_name = '" . $this->db->escape_str($this->input->post('supplier_arabic_name')) . "', supplier_vat_no = '" . $this->db->escape_str($this->input->post('supplier_vat_no')) . "', cr_no = '" . $this->db->escape_str($this->input->post('cr_no')) . "', image = '" . $this->db->escape_str($image) . "', amt_bef_vat = '" . $this->db->escape_str($this->input->post('amt_bef_vat')) . "', tax = '" . $this->db->escape_str($this->input->post('tax')) . "', total = '" . $this->db->escape_str($this->input->post('total')) . "', created_at = NOW(), updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		
		return $query;
	}
	
	function get_list(){
		$a = "SELECT * from expenses_vat_entry WHERE 1=1";
		if($this->input->get('from') AND $this->input->get('to')){
			$v_from = $this->input->get('from');
			$v_to = $this->input->get('to');
			$d_to = date("Y-m-d", strtotime($v_to));
			if($v_from AND $v_to){
				$a .= " AND date >= '" . date("Y-m-d", strtotime($this->input->get('from'))) . "' AND date <='" . $d_to . "'";
			}
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND invoice_number LIKE '%".$_POST["search"]["value"]."%'";
		}
		$a .= " ORDER BY id ASC";       
        $query = $this->db->query($a);  
        return $query->result();  
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM expenses_vat_entry WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	function get_expenses_by_id($id){
		$query = $this->db->query("SELECT * FROM expenses_vat_entry WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
}
