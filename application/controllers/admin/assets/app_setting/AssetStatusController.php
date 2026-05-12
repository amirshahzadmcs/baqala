<?php defined('BASEPATH') or exit('No direct script access allowed');

class AssetStatusController extends CI_Controller
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

    public function get_status()
    {
        $status = $this->db->get_where('assets_status', ['status_type' => $this->input->get('statusType')])->result();
        echo json_encode(['status' => true, 'data' => $status]);
    }
    public function create_status()
    {
        // echo '<pre>';
        // print_r($_POST);
        // die();
        $this->form_validation->set_rules('statusName', 'Status Name', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset-manage/add-asset');
        } else {
            $insert = $this->db->insert(
                'assets_status',
                [
                    'status_type' => $this->input->post('status_type'),
                    'status_name' => $this->input->post('statusName'),
                    'next_status_ids' => json_encode($this->input->post('nextStatusIds')),
                    'category_ids' => json_encode($this->input->post('categoryIds')),
                    'status_hold_activity' => $this->input->post('isHoldActivity') == true ? 1 : 0,
                ]
            );
            if ($insert) {
                $this->session->set_userdata('info', "1--Successfully done");
            } else {
                $this->session->set_userdata('info', "2--Something Went Wrong");
            }
            return redirect('admin/asset-manage/add-asset');
        }
    }
}
