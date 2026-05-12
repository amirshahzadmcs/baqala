<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO tax_settings SET title_en = '" . $this->db->escape_str($this->input->post('title_en')) . "', title_ar = '" . $this->db->escape_str($this->input->post('title_ar')) . "', tax_percent = '" . $this->db->escape_str($this->input->post('tax_percent')) . "', included = '" . $this->db->escape_str((int)$this->input->post('included')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE tax_settings SET title_en = '" . $this->db->escape_str($this->input->post('title_en')) . "', title_ar = '" . $this->db->escape_str($this->input->post('title_ar')) . "', tax_percent = '" . $this->db->escape_str($this->input->post('tax_percent')) . "', included = '" . $this->db->escape_str((int)$this->input->post('included')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT * FROM tax_settings WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND title_en LIKE '%".$_POST["search"]["value"]."%' OR title_ar LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY id ASC";
		}  
        else{  
			$a .= " ORDER BY id ASC";		   
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
	   $this->db->from('tax_settings');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM tax_settings WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM tax_settings WHERE id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}

	
}
