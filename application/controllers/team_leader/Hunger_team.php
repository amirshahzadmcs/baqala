<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hunger_team extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->teamleader->isLogged()) {
            $this->load->library('form_validation');
            $this->load->helper('common_helper');
            $this->load->library('user_agent');
        } else {
            redirect('team-leader/login');
        }
    }

    public function index()
    {
        if ($this->teamleader->isLogged()) {
            $info = explode('--', $this->teamleader->getInfo());
        } else {
            return redirect('team-leader/login');
        }
        return $this->load->view('team_leader/hunger/hunger_team_view');
    }


    public function get_teams()
    {
        $name = $this->input->get('name', TRUE);
        $team_leader = $this->input->get('team_leader', TRUE);
        $start_date = $this->input->get('start_date', TRUE);
        $end_date = $this->input->get('end_date', TRUE);
        $this->db->select('hunger_team.*,me.full_name as team_leader_name');
        $this->db->join('master_employee me', 'hunger_team.team_leader=me.id', 'left');
        $this->db->where('hunger_team.team_leader', $this->teamleader->getId());
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
            $this->db->group_start();
            $this->db->like('hunger_team.name', $keyword);
            $this->db->or_like('me.full_name', $keyword);
            $this->db->group_end();
        }

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->order_by("hunger_team.id", "desc");

        $fetch_data = $this->db->get('hunger_team')->result();
        $i = $_POST['start'] + 1;

        $data = array();
        foreach ($fetch_data as $team) {
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $team->name;
            $sub_array[] = $team->team_leader_name;
            $sub_array[] = count(json_decode($team->team));
            $sub_array[] = date('d/m/Y h:i A', strtotime($team->created_at));
            $sub_array[] = '<div class="d-flex">
            <a class="btn btn-outline-info btn-custom-light btn-sm edit" title="View" href="' . base_url('team-leader/hunger/team-view?team_id=' . $team->id) . '">
                <i class="mdi mdi-eye font-size-18"></i>
            </a>
        </div>';

            $data[] = $sub_array;
        }

        $total_records = $this->db->where('team_leader', $this->teamleader->getId())->count_all_results('hunger_team');
        $filtered_records = (!empty($_POST['search']['value'])) ? count($fetch_data) : $total_records;

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $filtered_records,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function create_team()
    {
        $insert = $this->db->insert('hunger_team', [
            'name' => $this->input->post('team_name'),
            'team_leader' => $this->input->post('team_leader'),
            'team' => json_encode($this->input->post('team'))
        ]);

        if ($insert) {
            echo json_encode(['status' => true, 'message' => 'Successfully Done']);
        }
    }

    public function view_team()
    {
        return $this->load->view('team_leader/hunger/hunger_team_view');
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
        $team_leader = $this->input->get('team_leader');

        $team = $this->db->select('hunger_team.*,me.id as emp_id,me.full_name')->join('master_employee me', 'hunger_team.team_leader=me.id', 'left')->where('hunger_team.team_leader', $team_leader)->get('hunger_team')->row();
        $emp_ids = json_decode($team->team, true);

        if (!empty($emp_ids)) {
            $riders = $this->db->select('me.*,fdc.company_name,lr.rider_status')
            ->from('master_employee me')
            ->join('logistic_rider lr','me.id=lr.employee_id','left')
            ->join('master_logistic_ids mli','lr.id_number=mli.id_number','left')
            ->join('food_deliv_companies fdc','mli.platform_id=fdc.id','left')
            ->where_in('me.id', $emp_ids)->get()->result();
        } else {
            $riders = array();
        }

        echo json_encode(['status' => true, 'team' => $team, 'team_data' => $riders]);
    }

    public function team_edit()
    {
        $team_id = $this->input->get('team_id');
        $team = $this->db->select('hunger_team.*,me.id as leader_id,me.full_name as leader_name')
            ->join('master_employee me', 'hunger_team.team_leader=me.id', 'left')
            ->where('hunger_team.id', $team_id)->get('hunger_team')->row();
        $team_members = array_column($this->db->select('team')->get('hunger_team')->result_array(), 'team');
        $team_member_ids = array_unique(array_merge(...array_map('json_decode', $team_members)));
        $teams = $this->db->select('me.id,me.full_name,me.emp_no,lr.rider_status')
            ->from('logistic_rider lr')
            ->join('master_employee me', 'lr.employee_id=me.id', 'left')
            ->where_not_in('lr.employee_id', empty($team_member_ids) ? [0] : $team_member_ids)
            ->where('lr.rider_status','active')
            ->get()->result();


        echo json_encode(['status' => true, 'team' => $team, 'teams' => $teams]);
    }

    public function team_update()
    {

        $team_id = $this->input->post('teamId');
        $team = $this->db->get_where('hunger_team', ['id' => $team_id])->row();
        $existing_team_ids = json_decode($team->team, true);
        $new_team_ids = $this->input->post('team') ?? [];
        $merged_team_ids = array_merge($existing_team_ids, $new_team_ids);
        $unique_team_ids = array_unique($merged_team_ids);
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
        $team_id_to_remove = $this->input->get('id', TRUE);
        $team_id = $this->input->get('team_id', TRUE);

        if (!is_numeric($team_id_to_remove)) {
            $this->session->set_userdata('info', "2--Invalid team member ID");
            return redirect($this->agent->referrer());
        }

        $json_search = "JSON_SEARCH(team, 'one', '$team_id_to_remove')";
        $json_remove = "JSON_REMOVE(team, JSON_UNQUOTE($json_search))";

        $remove = $this->db->set('team', $json_remove, FALSE)
            ->where('id', $team_id)
            ->where("JSON_CONTAINS(team, '\"$team_id_to_remove\"')")
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
        $team_member_id = $this->input->post('teamMemberId', TRUE);
        $old_team_id = $this->input->post('fromTeamId', TRUE);
        $new_team_id = $this->input->post('move_to', TRUE);
        $move_reason = $this->input->post('memberMoveReason', TRUE);

        // Start a transaction
        $this->db->trans_start();

        // Step 1: Check if the team member is already in the new team
        $is_member_in_new_team = $this->db->select('id')
            ->from('hunger_team')
            ->where('id', $new_team_id)
            ->where("JSON_CONTAINS(team, '\"$team_member_id\"')")
            ->get()
            ->num_rows() > 0;

        if ($is_member_in_new_team) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Team member is already in the target team']);
            return;
        }

        // Step 2: Remove the team member from the current team
        $json_search_old = "JSON_SEARCH(team, 'one', '$team_member_id')";
        $json_remove_old = "JSON_REMOVE(team, JSON_UNQUOTE($json_search_old))";

        $this->db->set('team', $json_remove_old, FALSE)
            ->where('id', $old_team_id)
            ->where("JSON_CONTAINS(team, '\"$team_member_id\"')")
            ->update('hunger_team');

        // Check if the member was successfully removed
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_complete();
            echo json_encode(['status' => false, 'message' => 'Failed to remove the team member from the old team']);
            return;
        }

        // Step 3: Add the team member to the new team
        $json_add_new = "JSON_ARRAY_APPEND(team, '$', '$team_member_id')";

        $this->db->set('team', $json_add_new, FALSE)
            ->where('id', $new_team_id)
            ->update('hunger_team');

        // Complete the transaction
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Failed to move the team member to the new team']);
        } else {
            $this->db->insert(
                'hunger_team_member_logs',
                [
                    'team_id' => $old_team_id,
                    'reason' => $move_reason,
                    'remark' => 'Move',
                    'log_detail' => json_encode(
                        [
                            'member_id' => $team_member_id,
                            'form_team_id' => $old_team_id,
                            'to_team_id' => $new_team_id,
                            'remark' => 'Move',
                            'date' => date('d/m/Y')
                        ]
                    )
                ]
            );
            echo json_encode(['status' => true, 'message' => 'Successfully moved the team member to the new team']);
        }
    }


    public function print_hunger_team()
    {
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
                ->select('master_employee.*,lr.id_number as hunger_id,lr.id_type,lr.rider_status,mv.vehicle_no,fdc.company_name')
                ->join('logistic_rider lr', 'lr.employee_id=master_employee.id', 'left')
                ->join('food_deliv_companies fdc', 'lr.platform=fdc.id', 'left')
                ->join('master_vehicles mv', 'master_employee.id = mv.alloted_user', 'left')
                ->get('master_employee')->result();
        } else {
            $riders = array();
        }

        return [$team, $riders];
    }
}
