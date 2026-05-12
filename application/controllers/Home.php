<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if($this->customer->isLogged()){
			$this->load->model('Home_model');
			$this->load->library('form_validation');
			$this->load->helper('cookie');
		}else{
			redirect('login');
		}
	}

	public function index(){
		$data['result'] = $this->Home_model->get_home();
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$this->load->view("front/home/home", $data);
	}

	/*
	public function getLocationEmail(){
		$query = $this->db->query("SELECT loc_email FROM location WHERE id = '" . (int)$this->input->get('id') . "'");
		if($query->num_rows()){
			$result = $query->row()->loc_email;
			echo $result; exit();
		} else{
			return 'mail@apnikirana.com';
		}
	}
	*/
	public function set_ad_popup(){
		$addpopup= array(
			'name'   => 'remember_me',
			'value'  => 'hide',
			'expire' => '3600',
			'secure' => FALSE
		);
		$this->input->set_cookie($addpopup);
		echo "Congratulation Cookie Set";
	}

	public function setSplash(){
		$CI =& get_instance();
		//$this->input->set_cookie($cookie);
		$CI->session->set_userdata("isSessionActive", true);
		echo $CI->session->userdata("isSessionActive");
	}

	public function setLang(){
		$lang = $this->input->post('lang');
		if($lang == 2){
			$this->session->set_userdata("isLangEn", true);
			$data = $this->session->userdata("isLangEn");
		}else{
			$this->session->set_userdata("isLangEn", false);
			$data = $this->session->userdata("isLangEn");
		}
		echo json_encode($data);
	}

	public function getcategory(){
	    $CI =& get_instance();
		$id = $this->input->post('id');
		$data['ids']=$id;
// 		$seo=$this->session->set_userdata("subid",$seo);
		$children = $this->db->query("SELECT c.id, c.parent_id, c.name, c.arabic_name, c.image, c.icon, c.slug FROM category c WHERE c.parent_id = '" .$id."' AND c.status = '1' AND c.id IN (SELECT pc.category_id FROM product_to_category pc WHERE pc.category_id = c.id AND pc.product_id IN (SELECT product.id from product WHERE product.b2b_availability = 'yes')) ORDER BY c.name")->result_array();
		$data['result']=$children;
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$output=$this->load->view("front/home/subcategory", $data);
		echo json_encode($output);
	}

	public function getcategory_new(){
		$id = $this->input->post('id');
		$start = 0;
		$limit = 30;
		$config = $this->customer->isCategory($id);
		$data['product_count'] = $this->Home_model->get_category_count($id);
		$data['is_append'] = $data['product_count'] > 30 ? true:false;
		$data['results'] = $this->Home_model->get_category($id, $start, $limit);
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$output=$this->load->view("front/home/cat_ajax",$data);
		echo json_encode($output);
	}

	function set_location(){
		$this->session->set_userdata("location", $this->input->post('location_id'));
		$query = $this->db->query("SELECT loc_email FROM location WHERE id = '" . (int)$this->input->post('location_id') . "'");
		if($query->num_rows()){
			$result = $query->row()->loc_email;
			$this->session->set_userdata("location_email", $result);
		} else{
		    $this->session->set_userdata("location_email", 'mail@apnikirana.com');
		}
	}

	public function search_page(){
		$this->load->view("front/home/search-list");
	}

	public function search(){
		$data['term'] = $this->input->get('term');
		$data['result'] = $this->Home_model->get_search($data['term']);
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$this->load->view("front/home/search", $data);
	}

	public function get_search_list(){
		$start = 0;
		$limit = 300;
		$data['term'] = $this->input->get('term');
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$data['results'] = $this->Home_model->get_search_hint($data['term'], $start, $limit);
		$output=$this->load->view("front/partials/search-hint", $data);
		echo json_encode($output);
	}

	public function category($cid){
		if($this->customer->isCategory($cid)){
			$config = $this->customer->isCategory($cid);
			//print_r($config);exit();
			$start = 0;
			$limit = 30;
			$data['offset'] = 1;
			$data['name'] = $config['name'];
			$data['arabic_name'] = $config['arabic_name'];
			$data['id'] = $config['id'];
			$data['slug'] = $config['slug'];
			$data['parent_id'] = $config['parent_id'];
			$data['image'] = $config['image'];
			$data['icon'] = $config['icon'];
			$data['heading_text'] = $config['heading_text'];
			$data['description'] = $config['description'];
			$data['metatitle'] = $config['metatitle'];
			$data['metakeyword'] = $config['metakeyword'];
			$data['metadescription'] = $config['metadescription'];

			$data['results'] = $this->Home_model->get_category($config['id'], $start, $limit);
			$data['product_count'] = $this->Home_model->get_category_count($config['id']);
			$data['is_append'] = $data['product_count'] > 30 ? true:false;
			//$data['categories'] = $this->customer->getCategoryTreenews($config['id']);

			$data['sub_categories'] = $this->customer->getSubCategory($config['id']);
			$data['sel_lang'] = $this->session->userdata("site_lang");
			//echo '<pre>';print_r($data);'</pre>';exit();
			$this->load->view("front/home/category", $data);
		} else{
			redirect('/');
		}
	}

	public function category_ajax(){
		$id = $this->input->post('id');
		$sort_by = $this->input->post('sort_by');
		$offset = $this->input->post('offset');
		$product_count = $this->input->post('product_count');
		$start = $offset * 30;
		$limit = 30;
		$data['results'] = $this->Home_model->get_category($id, $start, $limit, $sort_by);
		$config['newOffset'] = $offset + 1;
		$config['is_append'] = $product_count > 30 * $config['newOffset'] ? true:false;
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$config['result'] = $this->load->view("front/home/other_category_ajax", $data, true);
		echo json_encode($config);
	}

	/*---- Others category like featured, new etc ----*/
	public function other_category(){
		$type = $this->uri->segment(2);
		$sel_lang = $this->session->userdata("site_lang");
		if($type == 'featured'){
			$data['name'] = ($sel_lang == 'arabic') ? 'الأكثر مبيعًا':'Best Seller';
		}elseif($type == 'recommend'){
			$data['name'] = ($sel_lang == 'arabic') ? 'أفضل سعر':'Best Price';
		}elseif($type == 'popular'){
			$data['name'] = ($sel_lang == 'arabic') ? 'المنتجات الشعبية':'Popular Products';
		}elseif($type == 'new_item'){
			$data['name'] = ($sel_lang == 'arabic') ? 'عناصر جديدة':'New Items';
		}elseif($type == 'on_sale'){
			$data['name'] = ($sel_lang == 'arabic') ? 'بسعر مخفض':'On Sale';
		}
		if($type !== ''){
			$start = 0;
			$limit = 30;
			$data['result'] = $this->Home_model->get_other_category($type, $start, $limit);
			$data['product_count'] = $this->Home_model->get_other_category_count($type);
			$data['is_append'] = $data['product_count'] > 30 ? true:false;
			$data['offset'] = 1;
			//echo '<pre>';print_r($data);'</pre>';exit();
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/home/other_category", $data);
		} else{
			redirect('/');
		}
	}

	public function other_category_ajax(){
		$type = $this->uri->segment(2);
		$sort_by = $this->input->post('sort_by');
		$offset = $this->input->post('offset');
		$product_count = $this->input->post('product_count');
		$start = $offset * 30;
		$limit = 30;
		$data['result'] = $this->Home_model->get_other_category($type, $start, $limit, $sort_by);
		$config['newOffset'] = $offset + 1;
		$config['is_append'] = $product_count > 30 * $config['newOffset'] ? true:false;
		$data['sel_lang'] = $this->session->userdata("site_lang");
		$config['result'] = $this->load->view("front/home/other_category_ajax", $data, true);
		echo json_encode($config);
	}

	public function detail($sid){
		//print_r($slug);exit();
		if($this->customer->isProduct($sid)){
			$res = $this->customer->isProduct($sid);
			$id = $res['prod_id'];
			$data['metatitle'] = $res['metatitle'];
			$data['metakeyword'] = $res['metakeyword'];
			$data['metadescription'] = $res['metadescription'];
			$data['result'] = $this->Home_model->get_product($id,$sid);
			$data['sel_lang'] = $this->session->userdata("site_lang");
			//echo '<pre>';print_r($data);exit();
			$this->load->view("front/home/product", $data);
		} else{
			redirect('/');
		}
	}

	public function gift_card(){
		$slug1 = $this->uri->segment(2);
		$slug2 = $this->uri->segment(3);
		$slug = $slug1.'/'.$slug2;
		//print_r($slug);exit();
		if($this->customer->isProduct($slug)){
			$res = $this->customer->isProduct($slug);
			$id = $res['id'];
			$data['metatitle'] = $res['metatitle'];
			$data['metakeyword'] = $res['metakeyword'];
			$data['metadescription'] = $res['metadescription'];
			$data['result'] = $this->Home_model->get_product($id);
			//echo '<pre>';print_r($data);exit();
			$this->load->view("front/home/gift-card", $data);
		} else{
			redirect('/');
		}
	}

	public function page(){
		$slug = $this->uri->segment(1);
		$id = $this->customer->isPage($slug);
		if($id){
			$data['result'] = $this->Home_model->get_page($id)->row();
			$data['metatitle'] = $data['result']->metatitle;
			$data['metakeyword'] = $data['result']->metakeyword;
			$data['metadescription'] = $data['result']->metadescription;
			$data['sel_lang'] = $this->session->userdata("site_lang");
			$this->load->view("front/home/page", $data);
		} else{
			redirect('/');
		}
	}

	public function blogs(){
		$data['result'] = $this->Home_model->get_blogs();
		$data['more'] = $this->Home_model->recent_blogs();
		$this->load->view("front/home/blogs", $data);
	}

	public function blog(){
		$slug = $this->uri->segment(2);
		$id = $this->customer->isBlog($slug);
		if($id){
			$data['result'] = $this->Home_model->get_blog($id)->row();
			$data['metatitle'] = $data['result']->meta_title;
			$data['metakeyword'] = $data['result']->meta_keyword;
			$data['metadescription'] = $data['result']->meta_description;
			$data['more'] = $this->Home_model->recent_blogs();
			$this->load->view("front/home/blog", $data);
		} else{
			redirect('/');
		}
	}

	public function contact_us(){
		$data['result'] = true;
		$this->load->view("front/account/contact-us", $data);
	}

	public function help_ticket(){
		$this->load->view("front/home/help-ticket");
	}

	public function notification(){
		$data['result'] = $this->Home_model->get_notification();
		$this->load->view("front/home/notification", $data);
	}

	public function submit_contact_us(){
		$this->form_validation->set_rules('email', 'Contact Email', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg',validation_errors());
			$this->session->set_flashdata('is_success','0');
		}
		else{
			$query = $this->Home_model->submit_contact_us();
			if($query){
				$this->session->set_flashdata('msg','Thank you to contact with us. We will contact you soon.');
				$this->session->set_flashdata('is_success','1');
			}
			else{
				$this->session->set_flashdata('msg','Some error occured.');
				$this->session->set_flashdata('is_success','0');
			}
		}
		redirect("contact-us");
	}

	public function submit_newsletter(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[newsletter.email]');
		if($this->form_validation->run()==FALSE){
			$data['success'] = "0";
			$data['message'] = validation_errors();
		}
		else{
			$query = $this->Home_model->submit_newsletter();
			if($query){
				$data['success'] = "1";
				$data['message'] = 'Thankyou to subscribe with us.';
			}
			else{
				$data['success'] = "0";
				$data['message'] = 'Some error occure.';
			}
		}
		echo json_encode($data);
	}


	public function return_product(){
		$data['result'] = true;
		$this->load->view("front/home/return_product", $data);
	}

	public function unsubscribe_newsletter(){
		$this->load->view("front/home/unsubscribe");
	}

	public function submit_return(){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Contact Number', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('msg',validation_errors());
			$this->session->set_flashdata('is_success','0');
		}
		else{
			$query = $this->Home_model->submit_return();
			if($query){
				$this->session->set_flashdata('msg','Thank you for submitting your return request. Your request has been sent to the relevant department for processing.<br/>You will be notified via e-mail as to the status of your request.');
				$this->session->set_flashdata('is_success','1');
				redirect("contact-us");
			}
			else{
				$this->session->set_flashdata('msg','Some error occure.');
				$this->session->set_flashdata('is_success','0');
				redirect('contact-us');
			}
		}
	}

	function set_zipcode(){
		$this->form_validation->set_rules('zip_code', 'Pin Code', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$data['success'] = "0";
			$data['message'] = validation_errors();
		}
		else{
			$this->session->set_userdata("pincode", $this->input->post('zip_code'));
		}
		echo json_encode($data);
	}

	public function check_delivery(){
		$this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|min_length[6]|max_length[7]');
		if($this->form_validation->run()==FALSE){
			$data['success'] = "0";
			$data['message'] = validation_errors();
		}
		else{
			$query = $this->Home_model->pin_exists();
			if($query){
				$data['success'] = "1";
				$data['result'] = $query;
				$data['message'] = 'Delivery available on this location';
			}
			else{
				$data['success'] = "0";
				$data['message'] = 'Delivery not available on this location';
			}
		}
		echo json_encode($data);
	}

	public function unsubscribe(){
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		if($this->form_validation->run()==FALSE){
			$data['success'] = "0";
			$data['message'] = validation_errors();
		}
		else{
			$query = $this->Home_model->email_exists();
			if($query){
			    $query1 = $this->Home_model->unsubscribe_newsletter();
				$this->session->set_flashdata('msg','Successfully unsubscribed our newsletter');
				$this->session->set_flashdata('is_success','1');
				redirect('unsubscribe-newsletter');
			}
			else{
				$this->session->set_flashdata('msg','You are subscribed our newsletter, Please subscribe first');
				$this->session->set_flashdata('is_success','0');
				redirect('unsubscribe-newsletter');
			}
		}
	}

	public function browsingHistory(){
		$this->load->view('front/browsing/history');
	}

	public function browse_ajax(){
		$data['results'] = json_decode($this->input->post('id'));
		//echo '<pre>';print_r($data);'</pre>';exit();
		$this->load->view('front/browsing/browse_ajax',$data);
	}

	public function browse_ajax_home(){
		$data['results'] = json_decode($this->input->post('id'));
		$this->load->view('front/browsing/browse_ajax_home',$data);
	}

	function error_404() {
		$this->load->view("front/home/error_404");
	}
}
