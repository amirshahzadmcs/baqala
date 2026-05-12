<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct() {
		parent::__construct();									
		if($this->admin->isLogged()){			
			$this->load->model('admin/Contact_model');			
			$this->load->library('form_validation');			
		}			
		else{				
			redirect('admin');			
		}
	}
		
	public function index(){
		if ($this->admin->getInfo()){
			$info = explode('--', $this->admin->getInfo());
			$data['info'] = $info[1];
			$data['info_type'] = $info[0];
		} else {
			$data['info'] = '';
			$data['info_type'] = '';
		}
		$this->load->view('admin/contact/contact_list',$data);
	}
	
	public function get_list(){
		   $fetch_data = $this->Contact_model->get_list(); 
		//	$i = $_POST['start'] + 1 ;
           $data = array();  
           foreach($fetch_data as $contact){  
                $sub_array = array();
                $sub_array[] = '#';
				$sub_array[] = $contact->name;
				$sub_array[] = $contact->email;
				$sub_array[] = $contact->mobile;
				$sub_array[] = $contact->subject;
				$sub_array[] = $contact->message;
				$data[] = $sub_array;  
           }
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Contact_model->get_all_data(),  
                "recordsFiltered"     =>     $this->Contact_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);
	}

	
}
