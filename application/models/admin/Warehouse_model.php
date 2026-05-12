<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO warehouse SET name_english = '" . $this->db->escape_str($this->input->post('name_english')) . "', name_arabic = '" . $this->db->escape_str($this->input->post('name_arabic')) . "', contact_person = '" . $this->db->escape_str($this->input->post('contact_person')) . "', warehouse_email = '" . $this->db->escape_str($this->input->post('warehouse_email')) . "', warehouse_phone = '" . $this->db->escape_str($this->input->post('warehouse_phone')) . "', partner_code = '" . $this->db->escape_str($this->input->post('partner_code')) . "', processing_time = '" . $this->db->escape_str($this->input->post('processing_time')) . "', warehouse_map = '" . $this->db->escape_str($this->input->post('warehouse_map')) . "', complete_address = '" . $this->db->escape_str($this->input->post('complete_address')) . "', status = 1, created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE warehouse SET name_english = '" . $this->db->escape_str($this->input->post('name_english')) . "', name_arabic = '" . $this->db->escape_str($this->input->post('name_arabic')) . "', contact_person = '" . $this->db->escape_str($this->input->post('contact_person')) . "', warehouse_email = '" . $this->db->escape_str($this->input->post('warehouse_email')) . "', warehouse_phone = '" . $this->db->escape_str($this->input->post('warehouse_phone')) . "', partner_code = '" . $this->db->escape_str($this->input->post('partner_code')) . "', processing_time = '" . $this->db->escape_str($this->input->post('processing_time')) . "', warehouse_map = '" . $this->db->escape_str($this->input->post('warehouse_map')) . "', complete_address = '" . $this->db->escape_str($this->input->post('complete_address')) . "', status = '" . $this->db->escape_str((int)$this->input->post('status')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		
		return $query;
	}
	
	function make_query(){
		$a = "SELECT w.* FROM warehouse w WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND w.name_english LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["search"]["value"])){
			$a .= " AND w.name_arabic LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY w.name_english ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY w.created_at DESC";		   
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
	   $this->db->from('warehouse');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM warehouse WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	function get_detail($id){
		$query = $this->db->query("SELECT * FROM warehouse WHERE id = '" . (int)$id . "'");
		return $query->row();
	}
	
	public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE warehouse SET status = '1' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE warehouse SET status = '0' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
}
