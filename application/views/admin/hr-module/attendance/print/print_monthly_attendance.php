<?php
$attendance_data = [];
$absent_codes = ['A', 'UL', 'L'];

if ($search_month) {
    $date = DateTime::createFromFormat('Y-m', $search_month);
    $start_date = $date->format('Y-m-01');
    $end_date = $date->format('Y-m-t');
    $num_days = (int) $date->format('t');
    $current_day = $num_days;
} else {
    echo "<p>Invalid month format</p>";
    return;
}

// Group attendance per employee
foreach ($reports as $row) {
    $emp_id = $row->emp_no;
    $employee_id = $row->emp_id;
    $employee_name = $row->emp_full_name;
    $attend_date = $row->date_of_attend;
    $attend_type = $row->attend_type;

    $day = (int) date('j', strtotime($attend_date)); // Day of the month (1–31)

    if (!isset($attendance_data[$emp_id])) {
        $attendance_data[$emp_id] = [
            'employee_id'    => $employee_id,
            'emp_no'         => $emp_id,
            'employee_name'  => $employee_name,
            'total_present'  => 0,
            'total_absent'   => 0,
            'attendance'     => array_fill(1, $num_days, 'NA')
        ];
    }

    $attendance_data[$emp_id]['attendance'][$day] = $attend_type;

    if (in_array($attend_type, $absent_codes)) {
        $attendance_data[$emp_id]['total_absent']++;
    } else {
        $attendance_data[$emp_id]['total_present']++;
    }
}
?>

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

<h3 align="center">Monthly Attendance Report — <?= date('F Y', strtotime($search_month . '-01')) ?></h3>

<table border="0" cellspacing="0" cellpadding="4" style="font-size: 9px; width: 100%;">
    <thead>
        <tr style="background-color: #dddddd;">
            <th width="37px">S.No</th>
            <th width="45px">Emp ID</th>
            <th width="190px">Employee Name</th>
            <?php for ($i = 1; $i <= $num_days; $i++): ?>
                <?php
                $dayObj = DateTime::createFromFormat('Y-m-d', $start_date);
                $dayObj->setDate($dayObj->format('Y'), $dayObj->format('m'), $i);
                $dayName = $dayObj->format('D');
                ?>
                <th class="<?= in_array($dayName, ['Thu', 'Fri', 'Sat']) ? 'grey-background' : '' ?>" width="35px">
                    <?= $dayObj->format('D') ?><br>
                    <?= $dayObj->format('d M') ?>
                </th>

            <?php endfor; ?>
            <th width="42px">Absent</th>
            <th width="42px">Present</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($attendance_data)): ?>
            <?php 
                usort($attendance_data, function($a, $b) {
                    return $b['total_present'] <=> $a['total_present'];
                });
                $sno = 1; foreach ($attendance_data as $data): 
            ?>
                <tr>
                    <td width="37px"><?= $sno++ ?></td>
                    <td width="45px"><?= $data['emp_no'] ?></td>
                    <td width="190px" style="text-align: left;"><?= $data['employee_name'] ?></td>
                    <?php for ($i = 1; $i <= $num_days; $i++): ?>
                        <?php
                        $mark = $data['attendance'][$i];
                        $class = ($mark === 'NA') ? 'na' : (in_array($mark, $absent_codes) ? 'absent' : 'present');

                        $dayObj = DateTime::createFromFormat('Y-m-d', $start_date);
                        $dayObj->setDate($dayObj->format('Y'), $dayObj->format('m'), $i);
                        $dayName = $dayObj->format('D');
                        $isGrey = in_array($dayName, ['Thu', 'Fri', 'Sat']);
                        ?>
                        <td class="<?= $class ?> <?= $isGrey ? 'grey-background' : '' ?>"  width="35px"><?= $mark ?></td>
                    <?php endfor; ?>
                    <td width="42px"><?= $data['total_absent'] ?></td>
                    <td width="42px"><?= $data['total_present'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?= $num_days + 4 ?>" align="center">No attendance data available</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr style="background-color: #f3ffdf;">
            <td colspan="3" align="right"><strong>Total</strong></td>
            <?php for ($i = 1; $i <= $num_days; $i++): ?>
                <td>
                    <?php
                    $daily_present = array_sum(array_map(function ($data) use ($i, $absent_codes) {
                        return (isset($data['attendance'][$i]) && !in_array($data['attendance'][$i], $absent_codes) && $data['attendance'][$i] !== 'NA') ? 1 : 0;
                    }, $attendance_data));
                    echo $daily_present;
                    ?>
                </td>
            <?php endfor; ?>
            <td><strong><?= array_sum(array_column($attendance_data, 'total_absent')) ?></strong></td>
            <td><strong><?= array_sum(array_column($attendance_data, 'total_present')) ?></strong></td>
        </tr>
    </tfoot>

</table>
