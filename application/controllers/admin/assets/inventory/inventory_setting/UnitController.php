<?php defined('BASEPATH') or exit('No direct script access allowed');

class unitController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if ($this->admin->isLogged()) {
            $this->load->library('form_validation');
            $this->load->library('user_agent');
            $action = $this->router->fetch_method();
            if ($action && !check_action_permission(get_user_role(), 'unit', $action)) {
                redirect('admin/unauthorized-request');
            }
        } else {
            redirect('admin/common/login');
        }
    }

    public function all_units()
    {
        $units = $this->db->get('inventory_units')->result();
        return $this->load->view('admin/assets-management/inventory/inventory_setting/unit_list', compact('units'));
    }

    public function create_unit()
    {
        $this->form_validation->set_rules('unit_name', 'unit Name', 'required|is_unique[inventory_units.unit_name]');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect($this->agent->referrer());
        } else {
            $this->db->insert(
                'inventory_units',
                [
                    'unit_name' => $this->input->post('unit_name'),
                    'unit_ar_name' => $this->input->post('unit_ar_name'),
                    'unit_description' => $this->input->post('unit_description'),
                    'unit_created_by' => $this->admin->getId(),
                ]
            );

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect($this->agent->referrer());
        }
    }

    public function update_unit()
    {
        $unit_id = $this->input->post('unit_id');
        $this->form_validation->set_rules('unit_id', 'Unit Id', 'required');
        $this->form_validation->set_rules('unit_name', 'Unit Name', 'trim|required|callback_check_name_duplicate');
        $this->form_validation->set_message('check_name_duplicate', 'Unit Name already Taken, Try new');

        if ($this->form_validation->run() == false) {
            $this->session->set_userdata('info', "2--" . validation_errors());
            return redirect('admin/asset/inventory/all-units');
        } else {
            $this->db->update(
                'inventory_units',
                [
                    'unit_name' => $this->input->post('unit_name'),
                    'unit_ar_name' => $this->input->post('unit_ar_name'),
                    'unit_description' => $this->input->post('unit_description'),
                    'unit_updated_at' => date('Y-m-d H:i:s')
                ],
                ['unit_id' => $this->input->post('unit_id')]
            );

            $this->session->set_userdata('info', "1--Successfully done");
            return redirect('admin/asset/inventory/all-units');
        }
    }

    public function delete_unit()
    {
        $id = $this->input->get('id');
        $this->db->delete('inventory_units', ['unit_id' => $id]);
        $this->session->set_userdata('info', "1--Successfully done");
        return redirect('admin/asset/inventory/all-units');
    }


    public function check_name_duplicate()
    {
        $id = $this->input->post('unit_id');
        $unit_name = $this->input->post('unit_name');
        $duplicate_check = $this->db->where('unit_id!=', $id)->where('unit_name', $unit_name)->get('inventory_units')->result();
        if (count($duplicate_check) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
