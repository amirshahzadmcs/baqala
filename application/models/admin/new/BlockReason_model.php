<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BlockReason_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_block_reasons SET name = '" . $this->db->escape_str($this->input->post('name')) . "', name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_block_reasons SET name = '" . $this->db->escape_str($this->input->post('name')) . "', name_ar = '" . $this->db->escape_str($this->input->post('name_ar')) . "', status = '" . $this->db->escape_str($this->input->post('status')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT * FROM master_block_reasons WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND name LIKE '%".$_POST["search"]["value"]."%' OR name_ar LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY name ". $_POST['order']['0']['dir'] ."";
		}  
        else{  
			$a .= " ORDER BY created_at DESC";		   
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
	   $this->db->from('master_block_reasons');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_block_reasons WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_block_reasons WHERE id = '" . (int)$id . "'");
		// print_r($query->row());die();
		return $query->row();
	}

	
}
