<?php

function generate_dates_for_month($year, $month)
{
    $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dates = [];
    for ($day = 1; $day <= $num_days; $day++) {
        $dates[] = sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
    return $dates;
}

function merge_with_timesheet($dates, $timesheet)
{
    $timesheet_data = [];
    foreach ($timesheet as $entry) {
        $date = date('Y-m-d', strtotime($entry->created_at));
        $timesheet_data[$date] = $entry;
    }

    $final_report = [];
    foreach ($dates as $date) {
        if (isset($timesheet_data[$date])) {
            $final_report[] = $timesheet_data[$date];
        } else {
            $final_report[] = (object)[
                'date' => $date,
                'in_time' => null,
                'out_time' => null,
                'created_at' => $date
            ];
        }
    }
    return $final_report;
}

function calculate_total_working_hours($report)
{
    $total_hours = 0;
    foreach ($report as $entry) {
        if (!empty($entry->working_hours)) {
            $total_hours += $entry->working_hours;
        }
    }
    return $total_hours;
}

function calculate_presence_absence_days($report)
{
    $present_days = 0;
    $absent_days = 0;
    $total_leaves = 0;
    $sign_in_only_days = 0;
    $sign_out_only_days = 0;

    foreach ($report as $entry) {
        if (!empty($entry->in_time) && !empty($entry->out_time)) {
            $present_days++;
        } elseif (empty($entry->in_time) && !empty($entry->out_time)) {
            $sign_out_only_days++;
        } elseif (!empty($entry->in_time) && empty($entry->out_time)) {
            $sign_in_only_days++;
        } else {
            $absent_days++;
        }
    }

    return [$present_days, $absent_days, $total_leaves, $sign_in_only_days, $sign_out_only_days];
}
