<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcements_model extends CI_Model{

	public function save_announcement_data($data) {
        $this->db->insert('announcements', $data);
        return $this->db->insert_id();
    }

	public function update_announcement_data($id, $data) {
		$this->db->where('id', $id);
		$this->db->update('announcements', $data);
		return $this->db->affected_rows() >= 0;
	}

	function make_query(){
		$a = "SELECT a.* FROM announcements a WHERE 1=1";
		return $a;
	}

	function get_list(){
		$a = $this->make_query();
		if(isset($_POST["order"])){
			$a .= " ORDER BY a.id DESC";
		}
        else{
			$a .= " ORDER BY a.created_at DESC";		   
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
	   $this->db->from('announcements');  
	   return $this->db->count_all_results();
    }
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
			$this->db->select('file_path');
			$this->db->from('announcements');
			$this->db->where('id', $ids[$i]);
			$images = $this->db->get()->row();
			$query = $this->db->query("DELETE FROM announcements WHERE id = '" . $ids[$i] . "'");
			if ($query) {
				if (!empty($images->file_path) && file_exists(FCPATH . $images->file_path)) {
					unlink(FCPATH . $images->file_path);
				}
			}
		}
		return true;
	}

	function get_detail($id){
		$query = $this->db->query("SELECT * FROM announcements WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
}
