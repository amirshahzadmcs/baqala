<?php
class Blog_model extends CI_Model {
	public function saveBlog($data=array()){
		return $this->db->insert("blog",$data);
	}
	public function getBlog(){
		$this->db->select("*");
		$this->db->from("blog");
		return $this->db->get()->result();
	}
	public function editBlog($id=''){
		$this->db->select("*");
		$this->db->from("blog");
		$this->db->where("id",$id);
		return $this->db->get()->row();
	}
	public function updateBlog($data=array(),$id){
		$this->db->where("id",$id);
		return $this->db->update("blog",$data);
	}
	public function deleteBlog($id=''){
		$this->db->where("id",$id);
		return $this->db->delete("blog");
	}
}
?>