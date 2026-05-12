<?php
class Home_admin_model extends CI_Model {
	
	public function edit(){
	
		$con['upload_path']   = './home_image/'; 
        $con['allowed_types'] = 'gif|jpg|png|jpeg'; 
		$con['maintain_ratio'] = TRUE;
        $con['max_filename'] = '30';
        $con['encrypt_name'] = TRUE;
        
		if(!empty($_FILES['home_image1']['name'])){
			$this->load->library('upload', $con);
			$this->upload->do_upload('home_image1');
			$image_data1 = $this->upload->data();
			$image1 = "home_image/".$image_data1['file_name'];
			$url1 = $this->input->post('url1');
			$alt1 = $this->input->post('alt1');
		}
		else{
			$image1 = $this->input->post('image1');
			$url1 = $this->input->post('url1');
			$alt1 = $this->input->post('alt1');
		}
		
		if(!empty($_FILES['home_image2']['name'])){
			$this->load->library('upload', $con);
			$this->upload->do_upload('home_image2');
			$image_data2 = $this->upload->data();
			$image2 = "home_image/".$image_data2['file_name'];
			$url2 = $this->input->post('url2');
			$alt2 = $this->input->post('alt2');
		}
		else{
			$image2 = $this->input->post('image2');
			$url2 = $this->input->post('url2');
			$alt2 = $this->input->post('alt2');
		}
		
		if(!empty($_FILES['home_image3']['name'])){
			$this->load->library('upload', $con);
			$this->upload->do_upload('home_image3');
			$image_data3 = $this->upload->data();
			$image3 = "home_image/".$image_data3['file_name'];
			$url3 = $this->input->post('url3');
			$alt3 = $this->input->post('alt3');
		}
		else{
			$image3 = $this->input->post('image3');
			$url3 = $this->input->post('url3');
			$alt3 = $this->input->post('alt3');
		}
		
		if(!empty($_FILES['home_image4']['name'])){
			$this->load->library('upload', $con);
			$this->upload->do_upload('home_image4');
			$image_data4 = $this->upload->data();
			$image4 = "home_image/".$image_data4['file_name'];
			$url4 = $this->input->post('url4');
			$alt4 = $this->input->post('alt4');
		}
		else{
			$image4 = $this->input->post('image4');
			$url4 = $this->input->post('url4');
			$alt4 = $this->input->post('alt4');
		}
		
		if(!empty($_FILES['home_image_sale']['name'])){
			$this->load->library('upload', $con);
			$this->upload->do_upload('home_image_sale');
			$image_dataSale = $this->upload->data();
			$sale_image = "home_image/".$image_dataSale['file_name'];
			$sale_url = $this->input->post('sale_url');
		}
		else{
			$sale_image = $this->input->post('sale_image');
			$sale_url = $this->input->post('sale_url');
		}
		
		$this->db->query("UPDATE home SET image1 = '" . $this->db->escape_str($image1) . "', url1 = '" . $this->db->escape_str($this->input->post('url1')) . "', alt1 = '" . $this->db->escape_str($this->input->post('alt1')) . "', image2 = '" . $this->db->escape_str($image2) . "', url2 = '" . $this->db->escape_str($this->input->post('url2')) . "', alt2 = '" . $this->db->escape_str($this->input->post('alt2')) . "', image3 = '" . $this->db->escape_str($image3) . "', url3 = '" . $this->db->escape_str($this->input->post('url3')) . "', alt3 = '" . $this->db->escape_str($this->input->post('alt3')) . "', image4 = '" . $this->db->escape_str($image4) . "', url4 = '" . $this->db->escape_str($this->input->post('url4')) . "', alt4 = '" . $this->db->escape_str($this->input->post('alt4')) . "', image_sale = '" . $this->db->escape_str($sale_image) . "', url_sale = '" . $this->db->escape_str($this->input->post('sale_url')) . "', metatitle = '" . $this->db->escape_str($this->input->post('metatitle')) . "', metadescription = '" . $this->db->escape_str($this->input->post('metadescription')) . "', description = '" . $this->db->escape_str($this->input->post('description')) . "', metakeyword = '" . $this->db->escape_str($this->input->post('metakeyword')) . "' WHERE home_id = '1'");
		
		$home_id = '1';
		
		$this->db->query("DELETE FROM home_banner WHERE home_id = '1'");
		if($this->input->post('home_banner_count')){
			$banner_count = count($_FILES['home_banner']['name']);
			for($i=0;$i<$banner_count;$i++){
				if(!empty($_FILES['home_banner']['name'][$i])){
					$_FILES['home_banners']['name']= $_FILES['home_banner']['name'][$i];
					$_FILES['home_banners']['type']= $_FILES['home_banner']['type'][$i];
					$_FILES['home_banners']['tmp_name']= $_FILES['home_banner']['tmp_name'][$i];
					$_FILES['home_banners']['error']= $_FILES['home_banner']['error'][$i];
					$_FILES['home_banners']['size']= $_FILES['home_banner']['size'][$i];    

					$this->load->library('upload', $con);
					$this->upload->do_upload('home_banners');
					$image_data = $this->upload->data();
					//$image = "home_image/".time().'_'.$image_data['file_name'];	
					$image = "home_image/".$image_data['file_name'];
					$sort_order = $_POST['home_banner_sort'][$i];
					$url = $_POST['home_banner_url'][$i];
				}
				else{
					$image = $_POST['old_home_banner'][$i];
					$sort_order = $_POST['home_banner_sort'][$i];
					$url = $_POST['home_banner_url'][$i];
				}
				
				$this->db->query("INSERT INTO home_banner SET home_id = '" . (int)$home_id . "', image = '" . $this->db->escape_str($image) . "', sort_order = '" . $sort_order . "', url = '" . $url . "'");
			}
		}
		
		return $home_id;
	}


	public function getHome($id) {
		$query = $this->db->query("SELECT * FROM home WHERE home_id = '" . (int)$id . "'");
		return $query;
	}
		
	function home_banner($d){
		$query = $this->db->query("SELECT * FROM home_banner WHERE home_id = '" . $d . "'");
		return $query;
	}
	
	function home_category(){
		$query = $this->db->query("SELECT * FROM home_category");
		return $query;
	}	
}
