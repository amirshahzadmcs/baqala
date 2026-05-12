<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hunger_team extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->admin->isLogged()) {
            $this->load->library('form_validation');
            $this->load->helper('common_helper');
            $this->load->library('user_agent');
            require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $this->action = $this->router->method;
        } else {
            redirect('admin/common/login');
        }
    }

    public function index()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
            //dd($this->action);
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
        $data['team_leaders'] = $this->db->get_where('master_employee', ['status' => 'Active'])->result();
        $team_members = $this->db->select('team')->get('hunger_team')->result_array();
        $teams = array_column($team_members, 'team');
        // $all_team_ids = array_unique(array_merge(...array_map('json_decode', $teams)));
        $all_team_ids = array_unique(array_merge(...array_map(function ($json) {
            return is_string($json) && !empty($json) ? json_decode($json, true) : [];
        }, $teams)));
        $all_team_ids = array_filter($all_team_ids, function ($value) {
            return $value !== "";
        });
        $data['teams'] = $this->db->select('me.id,me.full_name,me.emp_no')->join('master_employee me', 'lr.employee_id=me.id', 'left')->where_not_in('lr.employee_id', empty($all_team_ids) ? [0] : $all_team_ids)->where('lr.rider_status', 'active')->where('me.status', 'Active')->get('logistic_rider lr')->result();
        return $this->load->view('admin/logistic-management/hunger/hunger_team', $data);
    }


    public function get_teams()
    {
        $name        = $this->input->get('name', TRUE);
        $team_leader = $this->input->get('team_leader', TRUE);
        $start_date  = $this->input->get('start_date', TRUE);
        $end_date    = $this->input->get('end_date', TRUE);

        /* -------------------------------
        | Base Query
        --------------------------------*/
        $this->db->select('hunger_team.*, me.full_name AS team_leader_name');
        $this->db->from('hunger_team');
        $this->db->join('master_employee me', 'hunger_team.team_leader = me.id', 'left');

        if ($name) {
            $this->db->where('hunger_team.name', $name);
        }

        if ($team_leader) {
            $this->db->where('hunger_team.team_leader', $team_leader);
        }

        if ($start_date && $end_date) {
            $this->db->where('DATE(hunger_team.created_at) >=', date('Y-m-d', strtotime($start_date)));
            $this->db->where('DATE(hunger_team.created_at) <=', date('Y-m-d', strtotime($end_date)));
        }

        if (!empty($_POST['search']['value'])) {
            $keyword = $_POST['search']['value'];
            $this->db->group_start()
                ->like('hunger_team.name', $keyword)
                ->or_like('me.full_name', $keyword)
                ->group_end();
        }

        /* -------------------------------
        | Clone query for filtered count
        --------------------------------*/
        $count_query = clone $this->db;
        $filtered_records = $count_query->count_all_results();

        /* -------------------------------
        | Pagination
        --------------------------------*/
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }

        $this->db->order_by('hunger_team.id', 'DESC');
        $fetch_data = $this->db->get()->result();

        $i = $_POST['start'] + 1;
        $data = [];

        /* -------------------------------
        | Row processing
        --------------------------------*/
        foreach ($fetch_data as $team) {
            $emp_ids = array_filter((array) json_decode($team->team, true));

            $member_count = 0;
            if (!empty($emp_ids)) {
                $row = $this->db
                    ->select('COUNT(DISTINCT me.id) AS total', false)
                    ->from('master_employee me')
                    ->join('logistic_rider lr', 'me.id = lr.employee_id', 'left')
                    ->join('sim_card sc', 'me.id = sc.alloted_user', 'left')
                    ->join('master_logistic_ids mli', 'lr.id_number = mli.id_number', 'left')
                    ->join('food_deliv_companies fdc', 'mli.platform_id = fdc.id', 'left')
                    ->where_in('me.id', $emp_ids)
                    ->get()
                    ->row();

                $member_count = (int) $row->total;
            }

            $data[] = [
                $i++,
                $team->name,
                $team->team_leader_name,
                $member_count,
                date('d/m/Y h:i A', strtotime($team->created_at)),
                '<div class="btn-group ms-2">
                    <button class="btn btn-light-grey btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="dripicons-dots-3"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">'

                    . (check_action_permission(get_user_role(), 'hunger_team', 'view_team') ?
                        '<a class="dropdown-item" href="' . base_url('admin/logistic-management/hunger/team-view?team_id=' . $team->id) . '">
                            <i class="mdi mdi-eye me-2"></i> View
                        </a>' : '')

                    . (check_action_permission(get_user_role(), 'hunger_team', 'delete_team') ?
                        '<a class="dropdown-item" href="javascript:void(0)"
                            onclick="deleteAlert(' . $team->id . ', \'admin/logistic-management/hunger/team-delete\')">
                            <i class="fas fa-trash-alt me-2"></i> Delete
                        </a>' : '')

                    . (check_action_permission(get_user_role(), 'hunger_team', 'print_hunger_team') ?
                        '<a class="dropdown-item" target="_blank"
                            href="' . base_url('admin/logistic-management/hunger/print-hunger-team?team_id=' . $team->id) . '">
                            <i class="mdi mdi-printer me-2"></i> Print Team
                        </a>' : '')

                    . (check_action_permission(get_user_role(), 'hunger_team', 'hungerTeamExport') ?
                        '<a class="dropdown-item" target="_blank"
                            href="' . base_url('admin/logistic-management/hunger/export-hunger-team/' . $team->id) . '">
                            <i class="mdi mdi-microsoft-excel me-2"></i> Export Excel
                        </a>' : '')

                    . (check_action_permission(get_user_role(), 'hunger_team', 'print_hunger_team_attendance') ?
                        '<a class="dropdown-item" target="_blank"
                            href="' . base_url('admin/logistic-management/hunger/print-hunger-team-attendance/' . $team->id) . '">
                            <i class="mdi mdi-printer me-2"></i> Print Attendance
                        </a>' : '')
                    . '</div>
                </div>'
            ];
        }

        /* -------------------------------
        | Total records
        --------------------------------*/
        $this->db->reset_query();
        $total_records = $this->db->count_all('hunger_team');

        echo json_encode([
            "draw"            => intval($_POST["draw"]),
            "recordsTotal"    => $total_records,
            "recordsFiltered" => $filtered_records,
            "data"            => $data
        ]);
    }

    public function create_team()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $insert = $this->db->insert('hunger_team', [
            'name' => $this->input->post('team_name'),
            'team_leader' => $this->input->post('team_leader'),
            'team' => json_encode($this->input->post('team'))
        ]);

        if ($insert) {
            echo json_encode(['status' => true, 'message' => 'Successfully Done']);
        }
    }

    public function delete_team()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $teamId = $this->input->get('id');
        $isDeleted = $this->db->delete('hunger_team', ['id' => $teamId]);

        if ($isDeleted) {
            $this->session->set_userdata('info', "1--Successfully done");
        } else {
            $this->session->set_userdata('info', "2--Something Went Wrong");
        }

        redirect($this->agent->referrer());
    }

    public function view_team()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        return $this->load->view('admin/logistic-management/hunger/hunger_team_view');
    }

    public function get_team_leader()
    {
        $team_leader_id = $this->input->get('id');

        $team_leader = $this->db->select('me.emp_no,me.full_name,me.mobile,me.employee_pic,me.designation,me.department,me.nationality,me.employee_arabic_name, mjt.name as job_title, md.name as department_name,mei.driving_license_number, mv.vehicle_type,mv.vehicle_no,mv.gps_device_serial,mn.name as nationality_name')
            ->from('master_employee me')
            ->join('master_job_title mjt', 'me.designation = mjt.id', 'left')
            ->join('master_department md', 'me.department = md.id', 'left')
            ->join('master_nationality mn', 'me.nationality = mn.id', 'left')
            ->join('master_employee_info mei', 'me.id = mei.employee_id', 'left')
            ->join('master_vehicles mv', 'me.id = mv.alloted_user', 'left')
            ->where('me.id', $team_leader_id)->get()->row();

        echo json_encode(['status' => true, 'team_leader' => $team_leader]);
        return;
    }


    public function get_team_member()
    {
        $team_id = $this->input->get('team_id');
        $team = $this->db->select('hunger_team.*,me.id as emp_id,me.full_name')->join('master_employee me', 'hunger_team.team_leader=me.id', 'left')->where('hunger_team.id', $team_id)->get('hunger_team')->row();
        $emp_ids = json_decode($team->team, true);

        if (!empty($emp_ids)) {
            //$riders = $this->db->where_in('id', $emp_ids)->get('master_employee')->result();
            $riders = $this->db->select('me.*,sc.mobile as sim_mobile,fdc.company_name,lr.rider_status,mli.id_number as aggregator_id')->from('master_employee me')
                ->join('logistic_rider lr', 'me.id=lr.employee_id', 'left')
                ->join('sim_card sc', 'me.id=sc.alloted_user', 'left')
                ->join('master_logistic_ids mli', 'lr.id_number=mli.id_number', 'left')
                ->join('food_deliv_companies fdc', 'mli.platform_id=fdc.id', 'left')
                ->where_in('me.id', $emp_ids)
                ->group_by('me.id')
                ->get()
                ->result();
        } else {
            $riders = array();
        }
        echo json_encode(['status' => true, 'team' => $team, 'team_data' => $riders]);
    }

    public function team_edit()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        $team_id = $this->input->get('team_id');
        $team = $this->db->select('hunger_team.*,me.id as leader_id,me.full_name as leader_name')
            ->join('master_employee me', 'hunger_team.team_leader=me.id', 'left')
            ->where('hunger_team.id', $team_id)->get('hunger_team')->row();
        $team_members = array_column($this->db->select('team')->get('hunger_team')->result_array(), 'team');
        $team_member_ids = array_unique(array_merge(...array_map(function ($json) {
            return is_string($json) && !empty($json) ? json_decode($json, true) : [];
        }, $team_members)));
        $teams = $this->db->select('me.id,me.full_name,me.emp_no,fdc.company_name')
            ->from('logistic_rider lr')
            ->join('master_employee me', 'lr.employee_id=me.id', 'left')
            ->join('master_logistic_ids mli', 'lr.id_number=mli.id_number', 'left')
            ->join('food_deliv_companies fdc', 'mli.platform_id=fdc.id', 'left')
            ->where_not_in('lr.employee_id', empty($team_member_ids) ? [0] : $team_member_ids)
            ->where('lr.rider_status', 'active')
            ->where('allotment_status', 1)
            ->get()->result();

        $team_leaders = $this->db->select('me.id, me.full_name')
            ->join('master_job_title mjt', 'me.designation = mjt.id', 'left')
            ->group_start()
            ->where('me.status', 'Active')
            ->or_where('me.id', $team->leader_id)
            ->group_end()
            ->where('mjt.name', 'Team Leader')
            ->or_where('me.id', $team->leader_id)
            ->get('master_employee me')
            ->result();

        echo json_encode(['status' => true, 'team' => $team, 'teams' => $teams, 'team_leaders' => $team_leaders]);
    }

    public function team_update()
    {

        $team_id = $this->input->post('teamId');
        $team = $this->db->get_where('hunger_team', ['id' => $team_id])->row();
        $existing_team_ids = json_decode($team->team, true);
        $new_team_ids = $this->input->post('team') ?? [];
        $merged_team_ids = array_merge($existing_team_ids, $new_team_ids);
        $unique_team_ids = array_unique($merged_team_ids);
        $unique_team_ids = array_filter($unique_team_ids, function ($value) {
            return $value !== "";
        });
        $update = $this->db->update(
            'hunger_team',
            [
                'name' => $this->input->post('team_name'),
                'team_leader' => $this->input->post('team_leader'),
                'team' => json_encode($unique_team_ids)
            ],
            ['id' => $team_id]
        );
        if ($update) {
            echo json_encode(['status' => true, 'message' => 'Successfully Updated Team']);
        }
    }

    public function team_member_remove()
    {
        // Retrieve and sanitize input
        $team_id_to_remove = $this->input->get('id', TRUE);
        $team_id = $this->input->get('team_id', TRUE);

        // Validate inputs
        if (!is_numeric($team_id_to_remove) || !is_numeric($team_id)) {
            $this->session->set_userdata('info', "2--Invalid team member or team ID");
            return redirect($this->agent->referrer());
        }

        // Fetch the current team JSON data
        $team_data = $this->db->select('team')
            ->where('id', $team_id)
            ->get('hunger_team')
            ->row_array();

        if (!$team_data || empty($team_data['team'])) {
            $this->session->set_userdata('info', "2--Team not found or empty");
            return redirect($this->agent->referrer());
        }

        // Decode JSON and remove the team member ID
        $team_array = json_decode($team_data['team'], true);
        if (!is_array($team_array)) {
            $this->session->set_userdata('info', "2--Invalid team data format");
            return redirect($this->agent->referrer());
        }

        // Remove the team member ID
        $team_array = array_filter($team_array, function ($id) use ($team_id_to_remove) {
            return (string) $id !== (string) $team_id_to_remove;
        });

        // Re-encode the updated team array
        $updated_team_json = json_encode(array_values($team_array));
        if ($updated_team_json === false) {
            $this->session->set_userdata('info', "2--Failed to encode updated team data");
            return redirect($this->agent->referrer());
        }

        // Update the database
        $remove = $this->db->set('team', $updated_team_json)
            ->where('id', $team_id)
            ->update('hunger_team');

        if ($remove) {
            $this->session->set_userdata('info', "1--Successfully removed the team member");
        } else {
            $error = $this->db->error();
            $this->session->set_userdata('info', "2--Something went wrong: " . $error['message']);
        }

        return redirect($this->agent->referrer());
    }


    public function team_member_move()
    {
        // Get the team ID from the GET request
        $team_id = $this->input->get('team_id');

        $this->db->where_not_in('id', $team_id);
        $teams = $this->db->get('hunger_team')->result();

        if ($teams !== false) {
            echo json_encode(['status' => true, 'teams' => $teams]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to retrieve teams']);
        }
    }


    public function team_member_moveUpdate()
    {
        // Retrieve and sanitize input
        $team_member_id = $this->input->post('teamMemberId', TRUE);
        $old_team_id = $this->input->post('fromTeamId', TRUE);
        $new_team_id = $this->input->post('move_to', TRUE);
        $move_reason = $this->input->post('memberMoveReason', TRUE);

        // Validate inputs
        if (!is_numeric($team_member_id) || !is_numeric($old_team_id) || !is_numeric($new_team_id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid team member or team ID']);
            return;
        }
        if (empty($move_reason)) {
            echo json_encode(['status' => false, 'message' => 'Move reason is required']);
            return;
        }
        if ($old_team_id == $new_team_id) {
            echo json_encode(['status' => false, 'message' => 'Source and target teams cannot be the same']);
            return;
        }

        // Start a transaction
        $this->db->trans_start();

        // Fetch team data for old and new teams
        $old_team_data = $this->db->select('team')
            ->where('id', $old_team_id)
            ->get('hunger_team')
            ->row_array();
        $new_team_data = $this->db->select('team')
            ->where('id', $new_team_id)
            ->get('hunger_team')
            ->row_array();

        // Validate team existence
        if (!$old_team_data || !$new_team_data) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'One or both teams not found']);
            return;
        }

        // Decode JSON data
        $old_team_array = $old_team_data['team'] ? json_decode($old_team_data['team'], true) : [];
        $new_team_array = $new_team_data['team'] ? json_decode($new_team_data['team'], true) : [];

        // Validate JSON format
        if (!is_array($old_team_array) || !is_array($new_team_array)) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Invalid team data format']);
            return;
        }

        // Check if the member is already in the new team
        if (in_array((string) $team_member_id, array_map('strval', $new_team_array))) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Team member is already in the target team']);
            return;
        }

        // Check if the member exists in the old team
        if (!in_array((string) $team_member_id, array_map('strval', $old_team_array))) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Team member not found in the source team']);
            return;
        }

        // Remove member from old team
        $old_team_array = array_filter($old_team_array, function ($id) use ($team_member_id) {
            return (string) $id !== (string) $team_member_id;
        });
        $old_team_json = json_encode(array_values($old_team_array));
        if ($old_team_json === false) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Failed to encode updated source team data']);
            return;
        }

        // Add member to new team
        $new_team_array[] = (string) $team_member_id;
        $new_team_json = json_encode(array_values($new_team_array));
        if ($new_team_json === false) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Failed to encode updated target team data']);
            return;
        }

        // Update old team
        $this->db->set('team', $old_team_json)
            ->where('id', $old_team_id)
            ->update('hunger_team');

        $this->db->set('team', $new_team_json)
            ->where('id', $new_team_id)
            ->update('hunger_team');

        // Log the move
        $log_data = [
            'team_id' => $old_team_id,
            'reason' => $move_reason,
            'remark' => 'Move',
            'log_detail' => json_encode([
                'member_id' => $team_member_id,
                'from_team_id' => $old_team_id,
                'to_team_id' => $new_team_id,
                'remark' => 'Move',
                'date' => date('d/m/Y')
            ])
        ];
        $this->db->insert('hunger_team_member_logs', $log_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Failed to move the team member']);
        } else {
            echo json_encode(['status' => true, 'message' => 'Successfully moved the team member to the new team']);
        }
    }


    public function print_hunger_team()
    {
        if ($this->action && !check_action_permission(get_user_role(), 'hunger_team', $this->action)) {
            redirect('admin/unauthorized-request');
        }
        list($team, $team_member) = $this->get_Team();
        $data['team'] = $team;
        $data['team_member'] = $team_member;
        $this->load->library('Pdf_hunger_team');
        $pdf = new Pdf_hunger_team(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Maha Al Fala');
        $pdf->SetTitle('Hunger Team Report');
        $pdf->SetSubject('Hunger Team Report');
        $pdf->SetKeywords('Maha Al Fala, PDF, Monthly Performance Report');

        $pdf->setPrintHeader(true);
        $pdf->SetPrintFooter(true);
        $htmlHeader = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_team_header', $data, true);
        $pdf->setHtmlHeader($htmlHeader);

        $lastFooter = $this->load->view('admin/logistic-management/hunger/print/footer', $data, true);
        $pdf->setHtmlFooter($lastFooter);

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(8);
        $pdf->SetMargins(0, 60, 4, true);

        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // add a page
        $pdf->AddPage('L', 'A4');
        // Arabic and English content
        // set LTR direction for english translation
        $pdf->setRTL(false);

        // print newline
        $pdf->Ln();
        // set font
        $pdf->SetFont('aealarabiya', '', 10);

        // Arabic and English content
        $htmlcontent = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_team_print', $data, true);
        $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
        $pdf->Output('Hunger Team.pdf', 'I');
    }

    public function get_Team()
    {
        $team_id = $this->input->get('team_id');

        $team = $this->db->select('hunger_team.*,me.id as emp_id,me.full_name,me.mobile')
            ->join('master_employee me', 'hunger_team.team_leader=me.id', 'left')
            ->where('hunger_team.id', $team_id)->get('hunger_team')->row();
        $emp_ids = json_decode($team->team, true);
        if (!empty($emp_ids)) {
            $riders = $this->db->where_in('master_employee.id', $emp_ids)
                ->select('master_employee.*,mli.id_number as hunger_id,mli.id_type,lr.rider_status,mv.vehicle_no,fdc.company_name')
                ->join('logistic_rider lr', 'lr.employee_id=master_employee.id', 'left')
                ->join('master_logistic_ids mli', 'lr.id_number = mli.id_number', 'left')
                ->join('food_deliv_companies fdc', 'mli.platform_id=fdc.id', 'left')
                ->join('master_vehicles mv', 'master_employee.id = mv.alloted_user', 'left')
                ->get('master_employee')->result();
        } else {
            $riders = array();
        }
        return [$team, $riders];
    }

    public function print_hunger_team_attendance($team_id = null)
    {
        // Check user permissions for the action
        if ($this->action && !check_action_permission(get_user_role(), 'timesheet', $this->action)) {
            redirect('admin/unauthorized-request');
            return; // Ensure function stops execution after redirect
        }

        // Fetch team data
        $team = $this->db->where('id', $team_id)
            ->get('hunger_team')
            ->row();

        if (!$team) {
            $this->session->set_userdata('info', "Invalid team selected.");
            redirect('admin/logistic-management/hunger/hunger-team');
            return; // Ensure function stops execution after redirect
        }
        $data = [
            'timesheet' => $this->get_all_data($team_id),
            'team' => $team
        ];

        // Create new PDF document
        $this->load->library('Pdf_hunger_team_timesheet');
        $pdf = new Pdf_hunger_team_timesheet(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Baqala Station');
        $pdf->SetTitle('BS - Hunger Station Weekly Report');
        $pdf->SetSubject('BS - Hunger Station Weekly Report');
        $pdf->SetKeywords('Baqala Station, PDF, Hunger Station Weekly Report');

        // print_r($data);exit();
        // remove default header/footer
        $pdf->setPrintHeader(true);
        $pdf->SetPrintFooter(true);
        $htmlHeader = $this->load->view('admin/logistic-management/hunger/print/hunger_team_banner', $data, true);
        $htmlHeader2 = $this->load->view('admin/logistic-management/hunger/print/hunger_team_banner', $data, true);
        $pdf->setHtmlHeader($htmlHeader);
        $pdf->setHtmlHeader2($htmlHeader2);

        $lastFooter = $this->load->view('admin/logistic-management/hunger/print/print_team_attendance_footer', $data, true);
        $pdf->setHtmlFooter($lastFooter);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' - 00'.$data['result']['order']['id'], PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetMargins(4, true, 4, true);
        $pdf->SetAutoPageBreak(TRUE, 14);
        // set auto page breaks
        // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        // add a page
        $pdf->AddPage('P', 'A4');
        $pdf->setRTL(false);


        // print newline
        $pdf->Ln();
        // set font
        $pdf->SetFont('aealarabiya', '', 10);

        $htmlcontent = $this->load->view('admin/logistic-management/hunger/print/print_team_attendance', $data, true);
        $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
        //Close and output PDF document
        $pdf->Output($team->name . '_Team.pdf', 'I');
    }


    public function get_all_data($team_id = null)
    {
        // Get input parameters and sanitize them
        $team = $this->db->where('hunger_team.id', $team_id)->get('hunger_team')->row();
        $emp_ids = json_decode($team->team, true);

        if (!empty($emp_ids)) {
            //$riders = $this->db->where_in('id', $emp_ids)->get('master_employee')->result();
            $fetch_data = $this->db->select('me.*,sc.mobile as alloted_mobile_no,fdc.company_name,lr.id_number,lr.rider_status,mli.id_number as aggregator_id, mv.vehicle_no, mv.vehicle_type')
                ->from('master_employee me')
                ->join('logistic_rider lr', 'me.id=lr.employee_id', 'left')
                ->join('sim_card sc', 'me.id=sc.alloted_user', 'left')
                ->join('master_vehicles mv', 'me.id=mv.alloted_user', 'left')
                ->join('master_logistic_ids mli', 'lr.id_number=mli.id_number', 'left')
                ->join('food_deliv_companies fdc', 'mli.platform_id=fdc.id', 'left')
                ->where_in('me.id', $emp_ids)
                ->group_by('me.id')
                ->order_by('me.emp_no', 'asc')
                ->get()
                ->result();
        } else {
            $fetch_data = array();
        }


        // $this->db->distinct();
        // $this->db->select('vt.*,mv.id as vehicle_id, mv.vehicle_no,me.id as employee_id,me.emp_no,me.full_name as employee_name,fdc.company_name,lr.id_number,hos.working_hours,hos.completed_deliveries,ma.new_status as logs');
        // $this->db->from('vehicle_timesheets vt');
        // $this->db->join('master_vehicles mv', 'vt.vehicle_id = mv.id', 'left');
        // $this->db->join('master_employee me', 'vt.driver_id = me.id', 'left');
        // $this->db->join('food_deliv_companies fdc', 'vt.delivery_platform = fdc.id', 'left');
        // $this->db->join('logistic_rider lr', 'vt.driver_id = lr.employee_id', 'left');
        // $this->db->join('hunger_order_summary hos', 'lr.id_number = hos.rider_id AND DATE(vt.created_at) = DATE(hos.date_local)', 'left');
        // $this->db->join('manage_attendance ma', 'DATE(vt.out_time) = ma.date AND vt.driver_id = ma.emp_id', 'left');
        // Apply filters

        return $fetch_data;
    }
}
