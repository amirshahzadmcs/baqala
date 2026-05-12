<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timeslot_model extends CI_Model{
	
	function add(){
		$query = $this->db->query("INSERT INTO delivery_time_slots SET name = '" . $this->input->post('name') . "', short_name = '" . $this->input->post('short_name') . "', time_from = '" . $this->input->post('time_from') . "', time_to = '" . $this->input->post('time_to') . "', slot_order = '" . $this->input->post('slot_order') . "', status = '" . $this->input->post('status') . "'");
		return $query;
	}

	function edit(){
		$query = $this->db->query("UPDATE delivery_time_slots SET name = '" . $this->input->post('name') . "', short_name = '" . $this->input->post('short_name') . "', time_from = '" . $this->input->post('time_from') . "', time_to = '" . $this->input->post('time_to') . "', slot_order = '" . $this->input->post('slot_order') . "', status = '" . $this->input->post('status') . "', updated_at = now() WHERE id = '" . $this->input->post('id') . "'");
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM delivery_time_slots WHERE id = '" . $id . "'");
		return $query;
	}
	
	function get_slot($id){
		$query = $this->db->query("SELECT * FROM delivery_time_slots WHERE id = '" . $id . "'");
		return $query->row();
	}
	
	function get_timeslots(){
		$query = $this->db->query("SELECT * FROM delivery_time_slots WHERE id != 1");
		return $query;
	}
	
}

