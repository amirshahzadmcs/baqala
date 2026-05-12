<?php defined('BASEPATH') or exit('No direct script access allowed');

class movementController extends CI_Controller
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

    public function all_movements()
    {
        $movements = $this->db->get('inventory_movement_status')->result();
        return $this->load->view('admin/assets-management/inventory/inventory_setting/movement_list', compact('movements'));
    }

    public function create_movement()
    {
        $this->form_validation->set_rules('movement_name', 'Movement Name', 'required|is_unique[inventory_movement_status.movement_name]');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset/inventory/all-movements');
        } else {
            $this->db->insert(
                'inventory_movement_status',
                [
                    'movement_name' => $this->input->post('movement_name'),
                    'movement_ar_name' => $this->input->post('movement_ar_name'),
                    'movement_type' => $this->input->post('movement_type'),
                    'movement_created_by' => $this->admin->getId(),
                ]
            );

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset/inventory/all-movements');
        }
    }

    public function update_movement()
    {
        $movement_id = $this->input->post('movement_id');
        $this->form_validation->set_rules('movement_id', 'Unit Id', 'required');
        $this->form_validation->set_rules('movement_name', 'Unit Name', 'trim|required|callback_check_name_duplicate');
        $this->form_validation->set_message('check_name_duplicate', 'Unit Name already Taken, Try new');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset/inventory/all-movements');
        } else {
            $this->db->update(
                'inventory_movement_status',
                [
                    'movement_name' => $this->input->post('movement_name'),
                    'movement_ar_name' => $this->input->post('movement_ar_name'),
                    'movement_type' => $this->input->post('movement_type'),
                    'movement_updated_at' => date('Y-m-d H:i:s')
                ],
                ['movement_id' => $this->input->post('movement_id')]
            );

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset/inventory/all-movements');
        }
    }

    public function delete_movement()
    {
        $id = $this->input->get('id');
        $this->db->delete('inventory_movement_status', ['movement_id' => $id]);
        $this->session->set_userdata('info', "1--Successfully done");
        return redirect('admin/asset/inventory/all-movements');
    }


    public function check_name_duplicate()
    {
        $id = $this->input->post('movement_id');
        $movement_name = $this->input->post('movement_name');
        $duplicate_check = $this->db->where('movement_id!=', $id)->where('movement_name', $movement_name)->get('inventory_movement_status')->result();
        if (count($duplicate_check) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
