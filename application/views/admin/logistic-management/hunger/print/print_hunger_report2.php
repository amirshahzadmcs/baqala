<?php
// Assume $reports contains the result of the get_list function
// Determine the number of days in the selected month
$search_month = $this->input->get('month_of'); // Adjust to match how you get the search month

if ($search_month) {
    $date = DateTime::createFromFormat('M Y', $search_month);
    if ($date === false) {
        // Handle the error - invalid date format
        throw new Exception("Invalid date format: " . htmlspecialchars($search_month));
    }
    $start_date = $date->format('Y-m-01');
    $end_date = $date->format('Y-m-t');
    $num_days = (int) $date->format('t'); // Number of days in the month
} else {
    $num_days = 31; // Default to 31 days if no month is selected
}
?>

<!DOCTYPE html>
<html lang="ae">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Hunger Daily Performance Report</title>
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
            $daily_data = []; // Initialize an array to store data
            $dayTotals = array_fill(1, $num_days, 0); // Initialize daily totals
            $orderTotal = 0; // To store overall total deliveries
            $totalAvgDeliveries = 0; // To store total average deliveries
            $totalWorkingDays = 0; // To store total working days

            // Populate daily_data array
			foreach ($reports as $row) {
				$day = (int) date('j', strtotime($row->date_local));
				$rider_id = $row->rider_id; // Use rider_id as the key
				$emp_id = $row->emp_no; // Use emp_no if available, else set it to empty or placeholder
				$full_name = $row->full_name;

				if (!isset($daily_data[$rider_id])) { // Use rider_id as the key
					$daily_data[$rider_id] = [
						'emp_no' => $emp_id ?: 'N/A', // Handle missing emp_no (use 'N/A' or any placeholder)
						'full_name' => $full_name,
						'rider_id' => $rider_id,
						'total' => 0,
						'days_worked' => 0, // Track the number of unique days worked
						'worked_days' => [] // Track unique days worked to avoid duplicate day counting
					];
					for ($i = 1; $i <= $num_days; $i++) {
						$daily_data[$rider_id][$i] = 0;
					}
				}

				// Ensure completed deliveries are accumulated correctly for the day
				$daily_data[$rider_id][$day] = isset($daily_data[$rider_id][$day]) 
					? $daily_data[$rider_id][$day] + $row->completed_deliveries 
					: $row->completed_deliveries;

				// Increment total deliveries
				$daily_data[$rider_id]['total'] += $row->completed_deliveries;

				// Only increment 'days_worked' if this day hasn't been counted for this rider
				if ($row->completed_deliveries > 0 && !in_array($day, $daily_data[$rider_id]['worked_days'])) {
					$daily_data[$rider_id]['days_worked'] += 1;
					$daily_data[$rider_id]['worked_days'][] = $day; // Mark this day as counted
				}

				// Accumulate daily totals
				$dayTotals[$day] += $row->completed_deliveries;
			}

			// Sort daily_data array by 'total' in descending order
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
                        $avgDeliveries = round($data['total'] / $data['days_worked']);
                        $totalAvgDeliveries += $avgDeliveries;
                        $totalWorkingDays += $data['days_worked'];
                    ?>
                    <td><?php echo htmlspecialchars($avgDeliveries); ?></td>
                    <td><?php echo htmlspecialchars($data['days_worked']); ?></td>
                </tr>
            <?php endforeach; ?>

            <tr style="background-color: #f3ffdf;">
                <td colspan="4" align="right">Total</td>
                <td><?php echo array_sum(array_column($daily_data, 'total')); ?></td>
                <?php for ($i = 1; $i <= $num_days; $i++): ?>
                    <td><?php echo $dayTotals[$i]; ?></td> <!-- Output daily total -->
                <?php endfor; ?>
                <td><?php echo round($totalAvgDeliveries / count($daily_data)); ?></td> <!-- Total of Avg Deliveries -->
                <td><?php echo $totalWorkingDays; ?></td> <!-- Total of Working Days -->
            </tr>

        <?php else: ?>
            <tr>
                <td colspan="<?php echo $num_days + 6; ?>" align="center">No data found</td> <!-- Adjusted colspan -->
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
