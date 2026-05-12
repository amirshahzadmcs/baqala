<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model{
	
	function manage(){
		//echo $this->input->post('status');exit();
		$query = $this->db->query("UPDATE product SET company_id = '". (int)$this->company->getId() ."', name = '" . $this->input->post('name') . "', name_arabic = '" . $this->input->post('name_arabic') . "', sku = '" . $this->input->post('sku') . "', qty = '" . $this->input->post('qty') . "', cost_price = '" . (float)$this->input->post('cost_price') . "', selling_price = '" . (float)$this->input->post('selling_price') . "', updated_at = NOW(), status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "' AND company_id = '". (int)$this->company->getId() ."'");
		return $query;
	}
	
	function add(){
		$query = $this->db->query("INSERT INTO product SET company_id = '". (int)$this->company->getId() ."', name = '" . $this->input->post('name') . "', name_arabic = '" . $this->input->post('name_arabic') . "', sku = '" . $this->input->post('sku') . "', qty = '" . $this->input->post('qty') . "', cost_price = '" . (float)$this->input->post('cost_price') . "', selling_price = '" . (float)$this->input->post('selling_price') . "', updated_at = NOW(), created_at = NOW(), status = '" . (int)$this->input->post('status') . "'");
		return $query;
	}
	
	function get_product($id){
		$query = $this->db->query("SELECT * FROM product WHERE id = '" . (int)$id . "' AND company_id = '". (int)$this->company->getId() ."'");
		return $query;
	}

	function delete($id){
		$query = $this->db->query("DELETE FROM product WHERE company_id = '". (int)$this->company->getId() ."' AND id IN (" . $id . ")");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT * FROM product WHERE company_id = '". (int)$this->company->getId() ."'";
		return $a;
	}
	  
	function get_list(){
		$a = $this->make_query();      
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
		$this->db->from('product'); 
		$this->db->where('company_id', (int)$this->company->getId());  	   
		return $this->db->count_all_results();  
	}

	
}
