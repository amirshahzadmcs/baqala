<?php defined('BASEPATH') or exit('No direct script access allowed');

class ShiftMaster extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->admin->isLogged()) {
            $this->load->library('form_validation');
            $this->load->helper('common_helper');
            $this->load->library('user_agent');
            $this->action = $this->router->method;
        } else {
            redirect('admin/common/login');
        }
    }

    public function index()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'shift_master', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        if ($this->admin->getInfo()) {

            $info = explode('--', $this->admin->getInfo());
            $data['info'] = $info[1];
            $data['info_type'] = $info[0];
        } else {
            $data['info'] = '';
            $data['info_type'] = '';
        }

        $data['shifts'] = $this->db->get_where('hunger_shift_master', ['status' => 'Active'])->result();

        $this->load->view('admin/logistic-management/hunger/shift_management/shift_master', $data);
    }


    public function get_shifts()
    {
        $name = $this->input->get('name', TRUE);
        $this->db->select('*');
        if ($name) {
            $this->db->where('hunger_shift_master.name', $name);
        }
        if (!empty($_POST['search']['value'])) {
            $keyword = $_POST['search']['value'];
            $this->db->group_start();
            $this->db->like('hunger_shift_master.name', $keyword);
            $this->db->group_end();
        }

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $this->db->order_by("hunger_shift_master.id", "desc");

        $fetch_data = $this->db->get('hunger_shift_master')->result();
        $i = $_POST['start'] + 1;

        $data = array();
        foreach ($fetch_data as $shift) {
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $shift->name;
            $sub_array[] = $shift->ar_name;
            $sub_array[] = date('d/m/Y h:i A', strtotime($shift->created_at));
            $sub_array[] = '<div class="d-flex">' . (check_action_permission(get_user_role(), 'shift_master', 'update_shift') ? '<a class="btn btn-outline-info btn-custom-light btn-sm edit" title="Edit" onclick="shiftEdit(this)" href="javascript:void(0)" shift_id="' . $shift->id . '" shift_name="' . $shift->name . '" shift_ar_name="' . $shift->ar_name . '"">
                <i class="mdi mdi-pencil font-size-18"></i>
            </a>' : '') . (check_action_permission(get_user_role(), 'shift_master', 'delete_shift') ? '<a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" onclick="deleteAlert(' . $shift->id . ', \'admin/logistic-management/hunger/delete-shift\')" href="javascript:void(0)">
                <i class="fas fa-trash-alt font-size-18"></i>
            </a>' : '') . '</div>';

            $data[] = $sub_array;
        }

        $total_records = $this->db->count_all_results('hunger_shift_master');
        $filtered_records = (!empty($_POST['search']['value'])) ? count($fetch_data) : $total_records;

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $filtered_records,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function create_shift()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'shift_master', $this->action)) {
            redirect('admin/unauthorized-request');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars|is_unique[hunger_shift_master.name]', [
            'is_unique' => 'The %s already exists.'
        ]);
        $this->form_validation->set_rules('ar_name', 'Arabic Name', 'required|trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => $errors]));
            return;
        }

        $name = $this->input->post('name', TRUE);
        $ar_name = $this->input->post('ar_name', TRUE);

        $data = [
            'name' => $name,
            'ar_name' => $ar_name
        ];

        $insert = $this->db->insert('hunger_shift_master', $data);

        if ($insert) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'message' => 'Successfully Done']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Something Went Wrong']));
        }
    }

    public function update_shift()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'shift_master', $this->action)) {
            redirect('admin/unauthorized-request');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars|callback_check_name_duplicate');
        $this->form_validation->set_message('check_name_duplicate', 'Name already exits, Try new');
        $this->form_validation->set_rules('ar_name', 'Arabic Name', 'required|trim|htmlspecialchars');

        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => $errors]));
            return;
        }
        $name = $this->input->post('name', TRUE);
        $ar_name = $this->input->post('ar_name', TRUE);

        $data = [
            'name' => $name,
            'ar_name' => $ar_name
        ];

        $update = $this->db->update('hunger_shift_master', $data, ['id' => $this->input->post('shift_id')]);

        if ($update) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'message' => 'Successfully Done']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Something Went Wrong']));
        }
    }

    public function delete_shift()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'shift_master', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $id = $this->input->get('id');
        if ($id) {
            $this->db->delete('hunger_shift_master', ['id' => $id]);
            $this->session->set_userdata('info', "1--Successfully done");
        }
        redirect($this->agent->referrer());
    }

    public function check_name_duplicate()
    {
        $id = $this->input->post('shift_id');
        $shift_name = $this->input->post('name');
        $shift_ar_name = $this->input->post('ar_name');

        $this->db->from('hunger_shift_master')
            ->group_start()
            ->where('name', $shift_name)
            ->or_where('ar_name', $shift_ar_name)
            ->group_end()
            ->where('id !=', $id);

        $duplicate_check = $this->db->count_all_results();

        return $duplicate_check > 0 ? false : true;
    }
}
