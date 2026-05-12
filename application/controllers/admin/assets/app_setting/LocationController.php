<?php defined('BASEPATH') or exit('No direct script access allowed');

class LocationController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if ($this->admin->isLogged()) {
            $this->load->library('form_validation');
        } else {
             redirect('admin/common/login');
        }
    }

    public function get_location(){
        $locations = $this->db->select(['location_id as id', 'parent_location_id', 'location_name as text'])->get('asset_locations2')->result_array();
		$locationTree = $this->loacationTree($locations);
        echo json_encode($locationTree);
    }

    public function create_location()
    {
        $this->form_validation->set_rules('locationName', 'Location Name', 'required');
        $this->form_validation->set_rules('locationArabicName', 'Location Arabic Name', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset-manage/add-asset');
        } else {

            $this->db->insert(
                'asset_locations2',
                [
                    'parent_location_id' => $this->input->post('parentLocationId'),
                    'location_name' => $this->input->post('locationName'),
                    'location_ar_name' => $this->input->post('locationArabicName'),
                    'location_code' => $this->input->post('locationCode'),
                    'stock_reorderemail' => $this->input->post('stock_reorderemail'),
                    'location_latitude' => $this->input->post('locationLatitude'),
                    'location_longitude' => $this->input->post('locationLongitude'),
                    'location_description' => $this->input->post('locationDescription'),
                    'alternate_location_head' => $this->input->post('endOfLife'),
                    'is_inventory_location' => $this->input->post('isInventoryLocation')==true ? 1 : 0,
                    'is_cascade' => $this->input->post('is_cascade'),
                    'additionaltvp' => json_encode($this->input->post('additionaltvp')),
                ]
            );
            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset-manage/add-asset');
        }
    }

    private function loacationTree($locations, $parent_id = 0)
	{
		$tree = array();
		foreach ($locations as $location) {
			if ($location['parent_location_id'] == $parent_id) {
				$location['children'] = $this->loacationTree($locations, $location['id']);
				$tree[] = $location;
			}
		}
		return $tree;
	}
}
