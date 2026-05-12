<?php defined('BASEPATH') or exit('No direct script access allowed');

class ShiftController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->teamleader->isLogged()) {
            $this->load->library('form_validation');
            $this->load->helper('common_helper');
            $this->load->helper('shift_management_helper');
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
        $team_members = array_column($this->db->select('team')->where('team_leader',$this->teamleader->getId())->get('hunger_team')->result_array(), 'team');
        $team_member_ids = array_unique(array_merge(...array_map('json_decode', $team_members)));
        $data['riders'] = $this->db->select('me.id,me.full_name,me.emp_no')
        ->join('master_employee me', 'lr.employee_id=me.id', 'left')
        ->join('master_logistic_ids mli','lr.id_number=mli.id_number','left')
        ->where_in('lr.employee_id', empty($team_member_ids) ? [0] : $team_member_ids)
        ->where('mli.platform_id!=',0)
        ->where('lr.rider_status','active')
        ->get('logistic_rider lr')->result();
        $this->load->view('team_leader/hunger/shift_management', $data);
    }

    public function get_riders_shift()
    {
        $name = $this->input->get('name', TRUE);
        $team_leader = $this->input->get('team_leader', TRUE);
        $this->db->select('hunger_shift.*, me.emp_no, me.full_name as rider_name, hsm.name as shift_name, ham.name as area_name,ht.name as team_name');
        $this->db->join('hunger_shift_master hsm', 'hunger_shift.shift_id=hsm.id', 'left');
        $this->db->join('hunger_area_master ham', 'hunger_shift.area_id=ham.id', 'left');
        $this->db->join('master_employee me', 'hunger_shift.rider_id=me.id', 'left');
        $this->db->join('hunger_team ht', 'JSON_SEARCH(ht.team, \'one\', CAST(hunger_shift.rider_id AS CHAR)) IS NOT NULL', 'left');
        if ($name) {

            $this->db->where('me.emp_no', $name);
        }
        if ($team_leader) {
            $this->db->like('hunger_shift.rdier_id', $team_leader);
        }

        if (!empty($_POST['search']['value'])) {
            $keyword = $_POST['search']['value'];
            $this->db->group_start();
            $this->db->like('hunger_shift.name', $keyword);
            $this->db->or_like('me.rdier_id', $keyword);
            $this->db->group_end();
        }

        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('ht.team_leader', $this->teamleader->getId());
        $this->db->order_by("hunger_shift.id", "desc");

        $fetch_data = $this->db->get('hunger_shift')->result();
        $i = $_POST['start'] + 1;

        $data = array();
        foreach ($fetch_data as $shift) {
            $start = new DateTime($shift->start_time);
            $end = new DateTime($shift->end_time);
            $interval = $start->diff($end);
            $time_difference = $interval->format('%H:%I:%S');
            $sub_array = array();
            $sub_array[] = $i++;
            $sub_array[] = $shift->emp_no;
            $sub_array[] = $shift->rider_name;
            $sub_array[] = $shift->team_name;
            $sub_array[] = '<div style="width:100px;">' . date('d-m-Y', strtotime($shift->date)) . '</div>';
            $sub_array[] = $shift->shift_name;
            $sub_array[] = date('h:i A', strtotime($shift->start_time));
            $sub_array[] = date('h:i A', strtotime($shift->end_time));
            $sub_array[] = $time_difference;
            $sub_array[] = $shift->area_name;
            $sub_array[] = '<div class="d-flex">
            <a class="btn btn-outline-info btn-custom-light btn-sm edit" title="View" onclick="admin_view_riderShift(this)" href="javascript:void(0)" shift_name="' . $shift->shift_name . '" rider_name="' . $shift->rider_name . '" shift_date="' . date('d/m/Y', strtotime($shift->created_at)) . '" shift_time="' . date('h:i A', strtotime($shift->start_time)) . ' - ' . date('h:i A', strtotime($shift->end_time)) . '" shift_duration="' . $time_difference . '" area_name="' . $shift->area_name . '">
            <i class="mdi mdi-eye font-size-18"></i>
            </a>
            <a class="btn btn-outline-info btn-custom-light btn-sm edit ' . ($shift->is_swap ? 'disabled' : '') . '" title="Swap" href="javascript:void(0)" onclick="swapShift(' . $shift->id . ', \'admin/logistic-management/hunger/rider-shift-swap\')">
            <i class="mdi ' . ($shift->is_swap ? 'mdi-repeat-off' : 'mdi-swap-horizontal-bold') . ' font-size-18"></i>
            </a>
            <a class="btn btn-outline-danger btn-custom-light btn-sm edit pt-1 pb-1 pr-2 pl-2" title="Delete" onclick="deleteAlert(' . $shift->id . ', \'admin/logistic-management/hunger/rider-shift-delete\')" href="javascript:void(0)">
            <i class="fas fa-trash-alt font-size-18"></i>
            </a>
            </div>';
            // <a class="btn btn-outline-info btn-custom-light btn-sm edit" title="Copy" onclick="copyShift(this)" href="javascript:void(0)" shift_id="' . $shift->shift_id . '" rider_id="' . $shift->rider_id . '" shift_date="' . date('Y-m-d', strtotime($shift->created_at)) . '" start_time="' . date('h:i', strtotime($shift->start_time)) . '" end_time="' . date('h:i', strtotime($shift->end_time)) . '" area_id="' . $shift->area_id . '">
            //  <i class="mdi mdi-vector-arrange-above font-size-18"></i>
            //  </a>

            $data[] = $sub_array;
        }

        $total_records = $this->db->join('hunger_team ht', 'JSON_SEARCH(ht.team, \'one\', CAST(hunger_shift.rider_id AS CHAR)) IS NOT NULL', 'left')->where('ht.team_leader', $this->teamleader->getId())->count_all_results('hunger_shift');
        $filtered_records = (!empty($_POST['search']['value'])) ? count($fetch_data) : $total_records;

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $total_records,
            "recordsFiltered" => $filtered_records,
            "data" => $data
        );
        echo json_encode($output);
    }

    public function search_rider()
    {

        $team_leader_id = $this->input->get('rider_id');
        $profile = $this->db->select('me.id as emp_id,me.emp_no, me.full_name, me.mobile, me.employee_pic, me.designation, me.department, me.nationality, me.employee_arabic_name, mjt.name as job_title, md.name as department_name, mei.driving_license_number, mv.vehicle_type, mv.vehicle_no,mv.vehicle_model, mv.gps_device_serial,mvm.make_name, mn.name as nationality_name')
            ->from('master_employee me')
            ->join('master_job_title mjt', 'me.designation = mjt.id', 'left')
            ->join('master_department md', 'me.department = md.id', 'left')
            ->join('master_nationality mn', 'me.nationality = mn.id', 'left')
            ->join('master_employee_info mei', 'me.id = mei.employee_id', 'left')
            ->join('master_vehicles mv', 'me.id = mv.alloted_user', 'left')
            ->join('mater_van_make mvm', 'mv.vehicle_make = mvm.id', 'left')
            ->where('me.id', $team_leader_id)
            ->get()
            ->row();
        $data['shifts'] = $this->db->get('hunger_shift_master')->result();
        $data['areas'] = $this->db->where('status', '1')->get('hunger_area_master')->result();
        $data['profile'] = $profile;
        if ($profile) {
            $profile_html = $this->load->view('admin/logistic-management/hunger/components/rider_profile', $data, true);
            echo json_encode(['status' => true, 'message' => 'Rider Profile Fatched', 'profile' => $profile_html]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Profile not found']);
        }
    }


    public function shiftAssign()
    {
        $rider_id = $this->input->post('rider_id');
        $shiftData = array_values($this->input->post('shiftData'));
        $uniqueShifts = [];
        foreach ($shiftData as $shift) {
            $uniqueKey = $shift['shift_date'] . '_' . $shift['shift_id'];
            if (isset($uniqueShifts[$uniqueKey])) {
                echo json_encode(['status' => false, 'message' => "Duplicate Shift Found for Date: " . $shift['shift_date']]);
                return;
            } else {
                if (!check_shiftAssign($shift['shift_id'], $shift['shift_date'])) {
                    echo json_encode(['status' => false, 'message' => 'Shift Already Assigned for ' . $shift['shift_date']]);
                    return;
                } else {
                    if (!check_availability($shift['shift_date'], $shift['shift_id'], $shift['start_time'], $shift['end_time'])) {
                        echo json_encode(['status' => false, 'message' => 'Rider Not Availlable For Selected Timing of' . $shift['shift_date']]);
                        return;
                    }
                }
            }
            $uniqueShifts[$uniqueKey] = true;
        }

        try {
            foreach ($shiftData as $shift) {
                $start = new DateTime($shift['start_time']);
                $end = new DateTime($shift['end_time']);
                $interval = $start->diff($end);
                $time_difference = $interval->format('%H:%I:%S');
                $this->db->insert(
                    'hunger_shift',
                    [
                        'shift_id' => $shift['shift_id'],
                        'rider_id' => $rider_id,
                        'area_id' => $shift['area_id'],
                        'date' => $shift['shift_date'],
                        'start_time' => $shift['start_time'],
                        'end_time' => $shift['end_time'],
                        'working_hours' => $time_difference
                    ]
                );
            }
            echo json_encode(['status' => true, 'message' => 'Shift Assigned to Rider']);
            return;
        } catch (Exception $e) {

            echo json_encode(['status' => false, 'message' => 'Error' . $e]);
            return;
        }
    }

    public function shiftSwap()
    {
        $id = $this->input->get('id');
        if ($id) {
            $this->db->update('hunger_shift', ['is_swap' => '1'], ['id' => $id]);
            $this->session->set_userdata('info', "1--Successfully done");
        }
        return redirect($this->agent->referrer());
    }

    public function shiftDelete()
    {
        $id = $this->input->get('id');
        if ($id) {
            $this->db->delete('hunger_shift', ['id' => $id]);
            $this->session->set_userdata('info', "1--Successfully Swaped");
        }
        return redirect($this->agent->referrer());
    }

    public function rider_check_availability()
    {
        $shift_type = (int)$this->input->post('shift_type');
        $shift_id = $this->input->post('shift_id');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $date = $this->input->post('shift_date');
        $dates = getWeekDates($shift_type, $date);
        foreach ($dates as $dt) {
            if (!check_shiftAssign($shift_id, $dt)) {
                echo json_encode(['status' => false, 'message' => 'Shift Already Assigned for ' . $dt]);
                return;
            } else {
                if (!check_availability($dt, $shift_id, $start_time, $end_time)) {
                    echo json_encode(['status' => false, 'message' => 'Rider Not Availlable For Selected Timing of' . $dt]);
                    return;
                }
            }
        }
        echo json_encode(['status' => true, 'message' => 'Available to Assing Shift']);
        return;
    }

    public function searchTeamLeader()
    {
        $teamLeader = $this->input->get('team_leaderId');
        if ($teamLeader) {
            $team = json_decode($this->db->get_where('hunger_team', ['team_leader' => $teamLeader])->row()->team);
            $riders = $this->db->select('me.id,me.full_name,me.emp_no')->from('master_employee me')->where_in('id', empty($team) ? [0] : $team)->get()->result();
            echo json_encode(['status' => true, 'riders' => $riders]);
            return;
        } else {
            echo json_encode(['status' => false, 'message' => 'Team Leader Not Found']);
            return;
        }
    }


    public function print_weeklyShiftReport()
    {
        list($shiftsByEmployee, $dateOfWeek) = $this->getShiftWeeklyData();

        $data['shiftsByEmployee'] = $shiftsByEmployee;
        $data['dateOfWeek'] = $dateOfWeek;
        $this->load->library('Pdf_hunger_shift_print');
        $pdf = new Pdf_hunger_shift_print(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Maha Al Fala');
        $pdf->SetTitle('Hunger Team Report');
        $pdf->SetSubject('Hunger Team Report');
        $pdf->SetKeywords('Maha Al Fala, PDF, Monthly Performance Report');

        $pdf->setPrintHeader(true);
        $pdf->SetPrintFooter(true);
        $htmlHeader = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_shift_header', [], true);
        $pdf->setHtmlHeader($htmlHeader);

        $lastFooter = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_shift_footer', [], true);
        $pdf->setHtmlFooter($lastFooter);

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(0);
        $pdf->SetMargins(2, 60, 4, true);

        $pdf->SetAutoPageBreak(TRUE, 22);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        $pdf->AddPage('L', 'A4');
        // Arabic and English content
        // set LTR direction for english translation
        $pdf->setRTL(false);

        // print newline
        $pdf->Ln();
        $pdf->SetFont('aealarabiya', '', 10);

        // Arabic and English content
        $htmlcontent = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_shift_print', $data, true);
        $pdf->WriteHTML($htmlcontent, true, 0, true, 0);

        $pdf->Output('Hunger Shift Timehseet.pdf', 'I');
    }

    public function print_dailyShiftReport()
    {

        list($timesheets, $maxShifts) = $this->getShiftDailyData();


        $data['timesheets'] = $timesheets;
        $data['maxShifts'] = $maxShifts;
        //dd($data);
        $this->load->library('Pdf_hunger_daily_shift');
        $pdf = new Pdf_hunger_daily_shift(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Maha Al Fala');
        $pdf->SetTitle('Hunger Shift Report');
        $pdf->SetSubject('Hunger Shift Report');
        $pdf->SetKeywords('Maha Al Fala, PDF, Daily Shift Report');

        $pdf->setPrintHeader(true);
        $pdf->SetPrintFooter(true);
        $htmlHeader = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_daily_shift_header', [], true);
        $pdf->setHtmlHeader($htmlHeader);

        $lastFooter = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_shift_footer', [], true);
        $pdf->setHtmlFooter($lastFooter);

        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(8);
        $pdf->SetMargins(1, 60, 4, true);

        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------
        $pdf->AddPage('L', 'A4');
        // Arabic and English content
        // set LTR direction for english translation
        $pdf->setRTL(false);

        // print newline
        $pdf->Ln();
        $pdf->SetFont('aealarabiya', '', 10);

        // Arabic and English content
        $htmlcontent = $this->load->view('admin/logistic-management/hunger/print-invoice/hunger_daily_shift_print', $data, true);
        $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
        $pdf->Output('Hunger Daily Shift Timehseet.pdf', 'I');
    }


    public function getShiftWeeklyData()
    {
        $team_leader = $this->input->post('team_leaderId', TRUE);
        $rider_id = $this->input->post('rider_id');
        $all_rider = $this->input->post('all_rider', TRUE);
        $week = $this->input->post('week');

        // Validate week format
        if (!preg_match('/^(\d{4})-W(\d{2})$/', $week, $matches)) {
            echo 'Invalid week identifier format.';
            return;
        }

        $year = $matches[1];
        $week_number = $matches[2];

        $dto = new DateTime();
        $startOfWeek = $dto->setISODate($year, $week_number)->format('Y-m-d');
        $endOfWeek = $dto->modify('+6 days')->format('Y-m-d');

        // Fetch team members
        if ($all_rider) {
            $team_member_ids = array_column($this->db->select('team')->get('hunger_team')->result_array(), 'team');
            $team_members = array_unique(array_merge(...array_map('json_decode', $team_member_ids)));
        } else {
            $team = $this->db->where('team_leader', $team_leader)->where("JSON_CONTAINS(team, '\"$rider_id\"')")->get('hunger_team')->row();
            if (!$team) {
                echo 'Team leader not found.';
                return;
            } else {
                $team_members = json_decode($rider_id);
            }
        }

        // Fetch shifts
        $this->db->select('me.emp_no, me.full_name as rider_name, hs.date as shift_date, hs.start_time, hs.end_time,hs.is_swap, hsm.name as shift_name,ham.name as area_name');
        $this->db->from('master_employee me');
        $this->db->where_in('me.id', empty($team_members) ? [0] : $team_members);
        $this->db->join('hunger_shift hs', 'me.id = hs.rider_id', 'left');
        $this->db->join('hunger_shift_master hsm', 'hs.shift_id = hsm.id', 'left');
        $this->db->join('hunger_area_master ham', 'hs.area_id=ham.id', 'left');
        $this->db->where('hs.date >=', $startOfWeek);
        $this->db->where('hs.date <=', $endOfWeek);
        $result = $this->db->get()->result();

        // Prepare data
        $shiftsByEmployee = [];
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $dateOfWeek = getWeekDates(1, $week);
        foreach ($result as $row) {
            $date = $row->shift_date;
            $dayIndex = date('w', strtotime($date));
            $key = $row->emp_no;

            if (!isset($shiftsByEmployee[$key])) {
                $shiftsByEmployee[$key] = [
                    'emp_no' => $row->emp_no,
                    'rider_name' => $row->rider_name,
                    'shifts' => array_fill(0, 7, [])
                ];
            }

            $startTime = new DateTime($row->start_time);
            $endTime = new DateTime($row->end_time);
            $workingHours = $startTime->diff($endTime)->format('%h:%I');

            $startTime12Hr = $startTime->format('g:i A');
            $endTime12Hr = $endTime->format('g:i A');

            $shiftDetail = '<span class="' . ($row->is_swap == '1' ? 'red-strikethrough' : '') . '">' . $startTime12Hr . '-' . $endTime12Hr . '</span><br><span class="' . ($row->is_swap == '1' ? 'area_color' : '') . '">(' . $row->area_name . ')</span>';
            $shiftsByEmployee[$key]['shifts'][$dayIndex][] = [
                'shift_detail' => $shiftDetail,
                'working_hours' => $workingHours
            ];
        }
        return [$shiftsByEmployee, $dateOfWeek];
    }


    public function getShiftDailyData()
    {
        $leader_id = $this->input->post('team_leaderId', TRUE);
        $rider_id = $this->input->post('rider_id', TRUE);
        $all_rider = $this->input->post('all_rider', TRUE);
        $date = $this->input->post('date');
        if ($all_rider) {
            $team_member_ids = array_column($this->db->select('team')->get('hunger_team')->result_array(), 'team');
            $riders_id = array_unique(array_merge(...array_map('json_decode', $team_member_ids)));
        } else {
            $team = $this->db->where('team_leader', $leader_id)->where("JSON_CONTAINS(team, '\"$rider_id\"')")->get('hunger_team')->row();
            if (!$team) {
                echo 'Team leader not found.';
                return;
            } else {
                $riders_id = json_decode($rider_id);
            }
        }

        $this->db->select('vt.*,me.emp_no,me.full_name as rider_name, mv.vehicle_no, hs.rider_id,ham.name as area_name, hs.start_time, hs.end_time');
        $this->db->from('vehicle_timesheets vt');
        $this->db->join('master_employee me', 'vt.driver_id = me.id', 'left');
        $this->db->join('master_vehicles mv', 'vt.vehicle_id = mv.id', 'left');
        $this->db->join('hunger_shift hs', 'vt.driver_id = hs.rider_id AND DATE(hs.date) = DATE(vt.created_at)', 'left');
        $this->db->join('hunger_area_master ham', 'hs.area_id = ham.id', 'left');
        $this->db->where_in('vt.driver_id', empty($riders_id) ? [0] : $riders_id);
        $this->db->where('DATE(vt.created_at)', $date);
        $query = $this->db->get();
        $results = $query->result();

        $timesheets = [];
        $maxShifts = 0;

        foreach ($results as $row) {
            if (!isset($timesheets[$row->time_id])) {
                $timesheets[$row->time_id] = (object)$row;
            }

            if (!empty($row->rider_id) && !empty($row->start_time)) {
                $startTime = new DateTime($row->start_time);
                $endTime = new DateTime($row->end_time);
                $timesheets[$row->time_id]->hunger_shifts[] = (object)[
                    'rider_id' => $row->rider_id,
                    'time' => $startTime->format('g:i A') . ' - ' . $endTime->format('g:i A') . '( ' . $row->area_name . ' )',
                ];
            }
            $maxShifts = max($maxShifts, count($timesheets[$row->time_id]->hunger_shifts));
        }

        $timesheets = array_values($timesheets);
        $max_shifts = $maxShifts;

        return [$timesheets, $max_shifts];
    }
}
