<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Helper extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if($this->admin->isLogged()){
			$this->load->library('form_validation');
		}
		else{
			redirect('admin');
		}
	}
	
	function get_region_cities() {
		$id = $this->input->post('region_id');
		$query = $this->db->query("SELECT * FROM master_city where region_id='". $id ."'")->result();
		echo json_encode($query);
	}

	function vehicle_make_list()
	{
		$service_id = $this->input->post('service_id');
		$query = $this->db->query("SELECT * FROM mater_van_make WHERE service_type = '". $service_id ."' AND deleted = '0' AND status = '1'")->result();
		echo json_encode($query);
	}

	function get_vehicle_type() {
		$make_id = $this->input->post('make_id');
		$query = $this->db->query("SELECT * FROM master_vehicle_type WHERE make_id = '". $make_id ."' AND status = '1'")->result();
		echo json_encode($query);
	}

}
