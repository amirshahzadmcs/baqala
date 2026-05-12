<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RSdp_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if($this->logistic->isLogged()){
            $this->load->model('logistic/Sdp_model');
            $this->load->library('form_validation');
            $this->load->helper('cookie');
            $this->load->library('session');
            $this->load->helper('Common_helper');
        } else{
			redirect("logistic-partner/login");
		}
	}

	public function index(){
		$this->load->view('logistic/pages/sdp-report/index');
	}

    public function performance_list(){
        $fetch_data = $this->Sdp_model->sdp_report();
        $data = array();  
        foreach($fetch_data as $user){
            $sub_array = array();
            $sub_array[] = $user->driver_id;
            $sub_array[] = ($user->name !== '') ? '<div style="width: 200px;">'. $user->name .'</div>('. $user->arabic_name .')' : $user->email;
            $sub_array[] = $user->mobile;
            $sub_array[] = '';

            $data[] = $sub_array;
        }
        $output = array(  
            "draw"                =>     intval($_POST["draw"]),  
            "recordsTotal"        =>      $this->Sdp_model->all_sdp_report(),  
            "recordsFiltered"     =>     $this->Sdp_model->filter_sdp_report(),  
            "data"                =>     $data  
        );  
        echo json_encode($output);
     }
}
