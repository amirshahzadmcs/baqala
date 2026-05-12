<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_model extends CI_Model{

	function add($image, $icon){
		$query = $this->db->query("INSERT INTO category SET icon = '" . $icon . "', sort_order = '" . (int)$this->input->post('sort_order') . "', name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', heading_text = '" . $this->db->escape_str($this->input->post('heading_text')) . "', slug = '" . $this->db->escape_str($this->input->post('seo')) . "', parent_id = '" . (int)$this->input->post('parent_id') . "', image = '" . $this->db->escape_str($image) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', arabic_desc = '" . $this->db->escape_str($this->input->post('arabic_desc')) . "', metatitle = '" . $this->db->escape_str($this->input->post('metatitle')) . "', metadescription = '" . $this->db->escape_str($this->input->post('metadescription')) . "', metakeyword = '" . $this->db->escape_str($this->input->post('metakeyword')) . "', status = '" . (int)$this->input->post('status') . "', created = NOW()");
		return $query;
	}
	
	function edit($image, $icon){
		$query = $this->db->query("UPDATE category SET icon = '" . $icon . "', sort_order = '" . (int)$this->input->post('sort_order') . "', name = '" . $this->db->escape_str($this->input->post('name')) . "', arabic_name = '" . $this->db->escape_str($this->input->post('arabic_name')) . "', heading_text = '" . $this->db->escape_str($this->input->post('heading_text')) . "', slug = '" . $this->db->escape_str($this->input->post('seo')) . "', parent_id = '" . (int)$this->input->post('parent_id') . "', image = '" . $this->db->escape_str($image) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', arabic_desc = '" . $this->db->escape_str($this->input->post('arabic_desc')) . "', metatitle = '" . $this->db->escape_str($this->input->post('metatitle')) . "', metadescription = '" . $this->db->escape_str($this->input->post('metadescription')) . "', metakeyword = '" . $this->db->escape_str($this->input->post('metakeyword')) . "', status = '" . (int)$this->input->post('status') . "' WHERE id = '" . (int)$this->input->post('id') . "'");
		return $query;
	}
	
	function get_category(){
		$data = array();
		$parent_categories = $this->db->query("select id, parent_id, name, arabic_name, image, status FROM category WHERE parent_id = '0' ORDER BY name");
		foreach($parent_categories->result() as $parent_category){
			$child = array();
			$child_categories = $this->db->query("select id, name, arabic_name, parent_id, image, status FROM category WHERE parent_id = '" . (int)$parent_category->id . "' ORDER BY name");
			foreach($child_categories->result() as $child_category){
				$sub_child = $this->db->query("select id, arabic_name, name, image, status FROM category WHERE parent_id = '" . (int)$child_category->id . "' ORDER BY name")->result_array();
				$child[] = array("id" => $child_category->id,
								 "name" => $child_category->name,
								 "arabic_name" => $child_category->arabic_name,
								 "status" => $child_category->status,
								 "image" => $child_category->image,
								 "child" => $sub_child);
			}
		$data[] = array("id" => $parent_category->id,
						"name" => $parent_category->name,
						"arabic_name" => $parent_category->arabic_name,
						"status" => $parent_category->status,
						"image" => $parent_category->image,
						"child" => $child);
		}
		return $data;
	}
	
	function delete($ids){
		$count = count($ids);
		for($i=0;$i<$count;$i++){
		$this->db->query("DELETE FROM category WHERE id = '" . $ids[$i] . "'");
		}
		return true;
	}
	
	function get_category_by_id($id){
		$query = $this->db->query("SELECT * FROM category WHERE id = '" . (int)$id . "'");
		return $query;
	}
	
	function get_id($id){
		$query = $this->db->query("select node.name as node_name, node.arabic_name as arabic_name, node.id as node_id 
		, up1.name as up1_name
		, up2.name as up2_name
		, up3.name as up3_name  from category as node
		left outer 
		  join category as up1 
			on up1.id = node.parent_id  
		left outer 
		  join category as up2
			on up2.id = up1.parent_id  
		left outer 
		  join category as up3
			on up3.id = up2.parent_id
		WHERE node.id = '".$id."'
		order
		by node_name");
		return $query;
	}
	
	public function setStatusEnable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE category SET status = '1' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
	public function setStatusDisable($ids) {
	    foreach($ids as $id){
	        $this->db->query("UPDATE category SET status = '0' WHERE id IN ('" . $id . "')");
	    }
	    return true;
	}
	
}
