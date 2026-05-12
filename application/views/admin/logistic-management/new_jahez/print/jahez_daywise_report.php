<?php
$search_month = $this->input->get('month_of');
if ($search_month) {
    $date = DateTime::createFromFormat('M Y', $search_month);
    if ($date === false) {
        throw new Exception("Invalid date format: " . htmlspecialchars($search_month));
    }
    $start_date = $date->format('Y-m-01');
    $end_date = $date->format('Y-m-t');
    $num_days = (int) $date->format('t');
} else {
    $num_days = 31;
}
?>

<!DOCTYPE html>
<html lang="ae">
<head>
    <meta charset="UTF-8">
    <title>Maha Al Fala - Jahez Daily Performance Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #f5d880;
        }
    </style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
        <tr style="background-color: #dddddd;">
            <th width="37px">S.No.</th>
            <th width="50px">Emp ID</th>
            <th width="210px">Employee Name</th>
            <th width="50px">Rider ID</th>
            <th width="40px">Total</th>
            <?php for ($i = 1; $i <= $num_days; $i++): ?>
                <th width="31px"><?php echo $i; ?></th>
            <?php endfor; ?>
            <th width="54px">Avg Deliveries</th>
            <th width="48px">Working Days</th>
        </tr>

        <?php if (!empty($reports)): ?>
            <?php 
            $sno = 1; 
            $daily_data = [];
            $dayTotals = array_fill(1, $num_days, 0);
            $totalAvgDeliveries = 0;
            $totalWorkingDays = 0;

            foreach ($reports as $row) {
                $day = (int) date('j', strtotime($row->order_date));
                $rider_id = $row->driver_id;
                $emp_id = $row->emp_no;
                $full_name = $row->full_name;

                if (!isset($daily_data[$rider_id])) {
                    $daily_data[$rider_id] = [
                        'emp_no' => $emp_id ?: 'N/A',
                        'full_name' => $full_name,
                        'rider_id' => $rider_id,
                        'total' => 0,
                        'days_worked' => 0,
                        'worked_days' => []
                    ];
                    for ($i = 1; $i <= $num_days; $i++) {
                        $daily_data[$rider_id][$i] = 0;
                    }
                }

                $daily_data[$rider_id][$day] += $row->orders;
                $daily_data[$rider_id]['total'] += $row->orders;

                if ($row->orders > 0 && !in_array($day, $daily_data[$rider_id]['worked_days'])) {
                    $daily_data[$rider_id]['days_worked'] += 1;
                    $daily_data[$rider_id]['worked_days'][] = $day;
                }

                $dayTotals[$day] += $row->orders;
            }

            usort($daily_data, function($a, $b) {
                return $b['total'] - $a['total'];
            });
            ?>

            <?php foreach ($daily_data as $data): ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo htmlspecialchars($data['emp_no']); ?></td>
                    <td align="left"><?php echo htmlspecialchars($data['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($data['rider_id']); ?></td>
                    <td><?php echo htmlspecialchars($data['total']); ?></td>
                    <?php for ($i = 1; $i <= $num_days; $i++): ?>
                        <td><?php echo htmlspecialchars($data[$i]); ?></td>
                    <?php endfor; ?>
                    <?php 
                        $avgDeliveries = $data['days_worked'] > 0 ? round($data['total'] / $data['days_worked']) : 0;
                        $totalAvgDeliveries += $avgDeliveries;
                        $totalWorkingDays += $data['days_worked'];
                    ?>
                    <td><?php echo $avgDeliveries; ?></td>
                    <td><?php echo $data['days_worked']; ?></td>
                </tr>
            <?php endforeach; ?>

            <tr style="background-color: #f3ffdf;">
                <td colspan="4" align="right">Total</td>
                <td><?php echo array_sum(array_column($daily_data, 'total')); ?></td>
                <?php for ($i = 1; $i <= $num_days; $i++): ?>
                    <td><?php echo $dayTotals[$i]; ?></td>
                <?php endfor; ?>
                <td><?php echo round($totalAvgDeliveries / count($daily_data)); ?></td>
                <td><?php echo $totalWorkingDays; ?></td>
            </tr>

        <?php else: ?>
            <tr>
                <td colspan="<?php echo $num_days + 6; ?>" align="center">No data found</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
