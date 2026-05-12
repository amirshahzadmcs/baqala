<?php
if ($search_month) {
    $date = DateTime::createFromFormat('M Y', $search_month);
    if ($date === false) {
        throw new Exception("Invalid date format: " . htmlspecialchars($search_month));
    }
    $start_date = $date->format('Y-m-01');
    $end_date = $date->format('Y-m-t');
    $num_days = (int) $date->format('t'); // Number of days in the month

    $current_date = new DateTime();
    $is_current_month = $date->format('Y-m') === $current_date->format('Y-m');
    $current_day = $is_current_month ? (int) $current_date->format('j') : $num_days;
} else {
    $num_days = 31;
    $current_day = 31;
}

// Process attendance data
$attendance_data = []; // Initialize array to store attendance data
$presents = ['P', 'WO', 'AL', 'SL', 'ML', 'PL', 'COL', 'BT', 'MAR', 'WL'];
$absents = ['L', 'A', 'CL', 'UL'];

foreach ($reports as $row) {
    $employee_id = $row->employee_id;
    $emp_id = $row->emp_no;
    $employee_name = strtoupper($row->employee_name);

    // Initialize attendance data if not already present
    if (!isset($attendance_data[$emp_id])) {
        $attendance_data[$emp_id] = [
            'employee_id' => $employee_id,
            'emp_no' => $emp_id,
            'employee_name' => $employee_name,
            'total_present' => 0, // Track total days present
            'total_absent' => 0, // Track total days absent
            'attendance' => array_fill(1, $num_days, 'NA') // Default to 'NA' for all days
        ];
    }

    // Get the day from out_time
    if ($row->out_time) {
        $day = (int) date('j', strtotime($row->out_time));

        if ($day <= $current_day) { // Only update if the day is up to today's date
            $logs = $row->logs;
            $attendance_data[$emp_id]['attendance'][$day] = ['mark' => 'P', 'logs' => $logs]; // Mark as Present
            if (is_null($logs) || (!is_null($logs) && !in_array($logs, $absents))) {
                $attendance_data[$emp_id]['total_present'] += 1;
            } else {
                $attendance_data[$emp_id]['total_absent'] += 1;
            }
        }
    }
}

// Final calculation for absent days
foreach ($attendance_data as &$data) {
    $data['total_absent'] = 0; // Reset absent count
    for ($i = 1; $i <= $current_day; $i++) {
        if (!isset($data['attendance'][$i]) || $data['attendance'][$i] === 'NA') {
            $complete_date = $date->format('Y-m-') . str_pad($i, 2, '0', STR_PAD_LEFT);
            $new_status = $this->db->select('new_status')
                ->from('manage_attendance')
                ->where('emp_id', (int) $data['employee_id'])
                ->where('DATE(date)', $complete_date)
                ->get()
                ->row()
                ->new_status ?? null;

            $data['attendance'][$i] = ['mark' => 'A', 'logs' => $new_status];

            if (empty($new_status) || (!empty($new_status) && !in_array($new_status, $presents))) {
                $data['total_absent']++;
            } else {
                $data['total_present']++;
            }
        }
    }
}


unset($data); // Clear reference
?>

<!DOCTYPE html>
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Monthly Attendance Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f5d880;
        }

        .absent {
            color: red;
            font-weight: bold;
        }

        .mark_bold {
            font-weight: bold;
        }

        .na {
            color: gray;
            font-style: italic;
        }

        .grey-background {
            background-color: #eeeeee;
            /* Light gray background for Thursday, Friday, Saturday */
        }
    </style>
</head>

<body>
    <table border="0" cellspacing="0" cellpadding="4" style="font-size: 9px; width: 100%;">
        <tr style="background-color: #dddddd;">
            <th width="37px">S.No.</th>
            <th width="45px">Emp ID</th>
            <th width="190px">Employee Name</th>
            <?php for ($i = 1; $i <= $num_days; $i++): ?>
                <?php
                $dateObj = DateTime::createFromFormat('Y-m-d', $start_date);
                $dateObj->setDate((int) $dateObj->format('Y'), (int) $dateObj->format('m'), $i);
                $dayName = $dateObj->format('D'); // Get the day name (e.g., Thu, Fri, Sat)
                $formattedDate = $dateObj->format('D d M'); // Format: Thu 01 Jul
                ?>
                <th width="35px">
                    <?php echo $formattedDate; ?>
                </th>
            <?php endfor; ?>
            <th width="42px">Absent Days</th>
            <th width="42px">Working Days</th>
        </tr>

        <?php if (!empty($attendance_data)): ?>
            <?php
            $sno = 1;
            foreach ($attendance_data as $data): ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo htmlspecialchars($data['emp_no']); ?></td>
                    <td align="left"><?php echo htmlspecialchars($data['employee_name']); ?></td>
                    <?php for ($i = 1; $i <= $num_days; $i++): ?>
                        <?php
                        $dateObj = DateTime::createFromFormat('Y-m-d', $start_date);
                        $dateObj->setDate((int) $dateObj->format('Y'), (int) $dateObj->format('m'), $i);
                        $dayName = $dateObj->format('D'); // Get the day name (e.g., Thu, Fri, Sat)
                        $isGreyDay = in_array($dayName, ['Thu', 'Fri', 'Sat']);
                        ?>
                        <td class="<?php echo $isGreyDay ? 'grey-background' : ''; ?>">
                            <?php if ($i > $current_day): ?>
                                <span class="na">NA</span>
                            <?php elseif ($data['attendance'][$i]['mark'] === 'A'): ?>
                                <span class="<?php echo isset($data['attendance'][$i]['logs']) ? 'mark_bold' : 'absent'; ?>"><?php echo isset($data['attendance'][$i]['logs']) ? $data['attendance'][$i]['logs'] : 'A'; ?></span>
                            <?php elseif ($data['attendance'][$i]['mark'] === 'P'): ?>
                                <span class="<?php echo isset($data['attendance'][$i]['logs']) ? 'mark_bold' : ''; ?>"><?php echo isset($data['attendance'][$i]['logs']) ? $data['attendance'][$i]['logs'] : 'P'; ?></span>
                            <?php endif; ?>
                        </td>

                    <?php endfor; ?>
                    <td><?php echo htmlspecialchars($data['total_absent']); ?></td> <!-- Absent Days -->
                    <td><?php echo htmlspecialchars($data['total_present']); ?></td> <!-- Working Days -->
                </tr>
            <?php endforeach; ?>

            <tr style="background-color: #f3ffdf;">
                <td colspan="3" align="right">Total</td>
                <?php for ($i = 1; $i <= $num_days; $i++): ?>
                    <td>
                        <?php
                        if ($i > $current_day) {
                            echo '<span class="na">NA</span>';
                        } else {
                            $daily_present = array_sum(array_map(function ($data) use ($i, $presents, $absents) {
                                if ($data['attendance'][$i]['mark'] === 'P') {
                                    if (is_null($data['attendance'][$i]['logs']) || (!is_null($data['attendance'][$i]['logs']) && !in_array($data['attendance'][$i]['logs'], $absents))) {
                                        return 1;
                                    } else {
                                        return 0;
                                    }
                                } else {
                                    if (is_null($data['attendance'][$i]['logs']) || (!is_null($data['attendance'][$i]['logs']) && !in_array($data['attendance'][$i]['logs'], $presents))) {
                                        return 0;
                                    } else {
                                        return 1;
                                    }
                                }
                            }, $attendance_data));
                            echo $daily_present;
                        }
                        ?>
                    </td>
                <?php endfor; ?>
                <td><?php echo array_sum(array_column($attendance_data, 'total_absent')); ?></td> <!-- Total Absent -->
                <td><?php echo array_sum(array_column($attendance_data, 'total_present')); ?></td> <!-- Total Present -->
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo $num_days + 4; ?>" align="center">No data found</td> <!-- Adjusted colspan -->
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>