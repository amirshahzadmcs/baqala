<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

function getWeekDates($shiftType, $week)
{
    $dates = [];
    if ($shiftType) {
        list($year, $weekNumber) = explode('-W', $week);
        $startDate = new DateTime();
        $startDate->setISODate($year, $weekNumber);

        for ($i = 0; $i < 7; $i++) {
            $dates[] = $startDate->format('Y-m-d');
            $startDate->modify('+1 day');
        }
        return $dates;
    } else {
        $dates[]= $week;
        return $dates;
    }
}


function check_shiftAssign($shift_id, $date)
{
    $ci = &get_instance();
    $shiftId = $ci->input->post('shiftId', TRUE);
    $rider_id = $ci->input->post('rider_id', TRUE);

    $ci->db->where('rider_id', $rider_id);
    $ci->db->where('date', $date);
    $ci->db->where('shift_id', $shift_id);

    if ($shiftId) {
        $ci->db->where('id !=', $shiftId);
    }

    $query = $ci->db->get('hunger_shift');

    return $query->num_rows() == 0;
}

function check_availability($date,$shift_id,$start_time,$end_time)
{   
    $ci = &get_instance();
    $shiftId = $ci->input->post('shiftId', TRUE);
    $rider_id = $ci->input->post('rider_id');
    $shift_id = $ci->input->post('shift_id');

    // Check if the rider is already assigned to this shift on this date
    if (check_shiftAssign($shift_id, $date)) {
        $ci->db->where('rider_id', $rider_id);
        $ci->db->where('date', $date);
        $ci->db->where('shift_id !=', $shift_id);
        if ($shiftId) {
            $ci->db->where('id !=', $shiftId);
        }

        $ci->db->group_start()
            ->group_start()
            ->where('start_time <=', $end_time)
            ->where('end_time >=', $start_time)
            ->group_end()
            ->or_group_start()
            ->where('start_time <=', $start_time)
            ->where('end_time >=', $end_time)
            ->group_end()
            ->group_end();

        $query = $ci->db->get('hunger_shift');
        return $query->num_rows() == 0;
    } else {
        return false;
    }
}
