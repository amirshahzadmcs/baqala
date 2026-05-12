<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_model extends CI_Model{
	
	function get_images($user){
		$sql = "SELECT i.*,c.username as user_name FROM images i LEFT JOIN customer c ON(i.customer_id = c.id)";
		if($user != ''){
		$sql .= " WHERE i.customer_id = '" . (int)$user . "'";	
		}
		$sql .= " ORDER BY i.id DESC";
		$query = $this->db->query($sql);
		return $query;
	}
	
	function delete($id){
		$query = $this->db->query("DELETE FROM images WHERE id IN (" . $id . ")");
		return $query;
	}
	
	function get_users(){
		$query = $this->db->query("SELECT * FROM customer WHERE role_id = '3' OR role_id = '4'");
		return $query;
	}
}
