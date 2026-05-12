<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sdp_controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
        if($this->logistic->isLogged()){
            $this->load->model('logistic/Rider_model');
            $this->load->library('form_validation');
            $this->load->helper('cookie');
            $this->load->library('session');
            $this->load->helper('Common_helper');
        } else{
			redirect("logistic-partner/login");
		}
	}

	public function index(){
		$this->load->view('logistic/pages/dashboard-sdp/index');
	}

    public function driver_list(){
        $fetch_data = $this->Rider_model->verified_driver_list();		   
     //	$i = $_POST['start'] + 1 ;
        $data = array();  
        foreach($fetch_data as $user){
            $sub_array = array();
            $sub_array[] = $user->driver_id;
            if($user->profile_info_status > 0 && $user->vehicle_info_status > 0 && $user->bank_info_status > 0){
                $profile_status = '';
            }else{
                $profile_status = '<span class="badge badge-pill badge-soft-warning font-size-13">Incomplete</span>';
            }
            $sub_array[] = ($user->name !== '') ? '<div style="width: 200px;">'. $user->name . docAlertHelper($user->iqama_exp, 'Iqama') . docAlertHelper($user->dl_expiry, 'Driving Licence') .'</div>('. $user->arabic_name .')' : $user->email .'<br>'. $profile_status;
            $sub_array[] = $user->mobile;
            $sub_array[] = $user->iqama_no;
            $sub_array[] = (!empty($user->last_login_at)) ? '<div style="width: 130px;">'. date("d-m-y h:i A", strtotime($user->last_login_at)) .'</div>' : 'N/A';
            $sub_array[] = ($user->status == '0') ? '<span class="badge badge-pill badge-soft-secondary font-size-13">Deactive</span>' : (($user->status == '1') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : (($user->status == '2') ? '<span class="badge badge-pill badge-soft-danger font-size-13">Blocked</span>' : '<span class="badge badge-pill badge-soft-info font-size-13">NULL</span>'));

            $data[] = $sub_array;
        }
        $output = array(  
            "draw"                =>     intval($_POST["draw"]),  
            "recordsTotal"        =>      $this->Rider_model->get_all_verified_driver(),  
            "recordsFiltered"     =>     $this->Rider_model->filter_verified_driver(),  
            "data"                =>     $data  
        );  
        echo json_encode($output);
     }
}
