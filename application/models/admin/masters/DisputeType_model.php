<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DisputeType_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_dispute_types SET dispute_type_en = '" . $this->db->escape_str($this->input->post('dispute_type_en')) . "', dispute_type_ar = '" . $this->db->escape_str($this->input->post('dispute_type_ar')) . "', created_at = NOW(), updated_at = now()");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_dispute_types SET dispute_type_en = '" . $this->db->escape_str($this->input->post('dispute_type_en')) . "', dispute_type_ar = '" . $this->db->escape_str($this->input->post('dispute_type_ar')) . "', updated_at = now() WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	public function get_data()
	{
		$a = $this->make_query();
		$query = $this->db->query($a);  
        return $query->result(); 
	}

	function make_query(){
		$a = "SELECT * FROM master_dispute_types WHERE 1=1";
		return $a;
	}
	
	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["search"]["value"])){
			$a .= " AND dispute_type_en LIKE '%".$_POST["search"]["value"]."%' OR dispute_type_ar LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY dispute_type_en ". $_POST['order']['0']['dir'] ."";
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
	   $this->db->from('master_dispute_types');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->query("DELETE FROM master_dispute_types WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM master_dispute_types WHERE id = '" . (int)$id . "'");
		return $query->row();
	}

	
}
