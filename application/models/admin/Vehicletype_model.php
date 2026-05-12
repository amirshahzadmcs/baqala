<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicletype_model extends CI_Model{

	function add(){
		$query = $this->db->query("INSERT INTO master_vehicle_type SET make_id = '" . $this->db->escape_str((int)$this->input->post('make_id')) . "', vehicle_type = '" . $this->db->escape_str($this->input->post('vehicle_type')) . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}
	
	function edit(){
		$query = $this->db->query("UPDATE master_vehicle_type SET make_id = '" . $this->db->escape_str((int)$this->input->post('make_id')) . "', vehicle_type = '" . $this->db->escape_str($this->input->post('vehicle_type')) . "', updated_at = now(), status = '" . $this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function make_query(){
		$a = "SELECT mvt.*, mvm.make_name FROM master_vehicle_type mvt LEFT JOIN mater_van_make mvm ON (mvt.make_id = mvm.id) WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = "SELECT mvt.*, mvm.make_name FROM master_vehicle_type mvt LEFT JOIN mater_van_make mvm ON (mvt.make_id = mvm.id) WHERE 1=1";
		if(isset($_POST["search"]["value"])){
			$a .= " AND mvm.make_name LIKE '%".$_POST["search"]["value"]."%' OR mvt.vehicle_type LIKE '%".$_POST["search"]["value"]."%'";
		}
		if(isset($_POST["order"])){             
			$a .= " ORDER BY mvt.vehicle_type ". $_POST['order']['0']['dir'] ."";
		}  
		else  
		{  
			$a .= " ORDER BY mvt.created_at DESC";		   
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
		$this->db->from('master_vehicle_type');  
		return $this->db->count_all_results();  
	}
	
	function delete($id){
		$query = $this->db->query("UPDATE master_vehicle_type SET deleted = 1 WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function detail($id){
		$query = $this->db->query("SELECT * FROM master_vehicle_type WHERE id = '" . (int)$id . "'");
		return $query;
	}

	function vehicle_make_list(){
		$query = $this->db->query("SELECT * FROM mater_van_make WHERE deleted = '0'");
		return $query->result();
	}
}
