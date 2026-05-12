<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct() {
        parent::__construct();			
		if($this->store->isLogged()){		
			$this->load->model('store/Orders_model');	
			$this->load->library('form_validation');	
		}		
		else{		
			redirect('store/login');			
		}
	}

	public function index(){
		if ($this->store->getInfo()){
			$info = explode('--', $this->store->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		}
		else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('stores/orders/dashboard',$data);
	}
	
	public function order_list(){
		$url_seg = $this->uri->segment(3);
		//print_r($url_seg);exit();
		if($url_seg == 'new-orders'){
			$data['page_name'] = 'New Orders';
		}elseif ($url_seg == 'in-process') {
			$data['page_name'] = 'In Progress';
		}elseif ($url_seg == 'delivered-orders') {
			$data['page_name'] = 'Delivered Orders';
		}elseif ($url_seg == 'cancelled-orders') {
			$data['page_name'] = 'Cancelled Orders';
		}elseif ($url_seg == 'returned-orders') {
			$data['page_name'] = 'Returned Orders';
		}elseif ($url_seg == 'all-orders') {
			$data['page_name'] = 'All Orders';
		}else{
			$data['page_name'] = '';
		}
		$this->load->view('stores/orders/list',$data);
	}

	public function order_detail(){
		$this->load->view('stores/orders/order_detail');
	}
}
