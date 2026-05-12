<?php
$search_month = $this->input->get('month_of');
?>

<!DOCTYPE html>
<html lang="ae">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Daily Suspended Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
    </style>
</head>
<body>
	<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;border-color:#000;">
		<tr style="background-color: #ccc;color:#000">
			<th width="37px">S.No.</th>
			<th width="50px">Emp ID</th>
			<th width="200px" align="center">Employee Name</th>
			<th width="75px" align="center">Aggregator ID</th>
			<th width="90px" align="center">Aggregator</th>
			<th width="60px" align="center">Aggregator Type</th>
			<th width="120px" align="center">Suspend From</th>
			<th width="120px" align="center">Suspend To</th>
			<th width="80px" align="center">Suspend Interval</th>
			<th width="180px">Reason</th>
		</tr>
		
		<?php if (!empty($reports)): ?>
			<?php $sno = 1; ?>
			<?php foreach ($reports as $data): ?>
				<tr>
					<td align="center"><?php echo $sno++; ?></td>
					<td><?php echo htmlspecialchars($data['emp_no']); ?></td>
					<td align="left"><?php echo htmlspecialchars($data['full_name']); ?></td>
					<td align="center"><?php echo htmlspecialchars($data['id_number']); ?></td>
					<td><?php echo htmlspecialchars($data['food_company']); ?></td>
					<td><?php echo htmlspecialchars($data['id_type']); ?></td>
					<?php $log_detail = json_decode($data['log_detail']);?>
					<td><?php echo htmlspecialchars(date('d-m-Y h:i A', strtotime($log_detail->suspend_from))); ?></td>
					<td><?php echo htmlspecialchars(date('d-m-Y h:i A', strtotime($log_detail->suspend_to))); ?></td>
					<?php
						$suspend_from = new DateTime($log_detail->suspend_from);
						$suspend_to = new DateTime($log_detail->suspend_to);
						$interval = $suspend_from->diff($suspend_to);
						$suspend_duration = $interval->format('%d days %h Hrs');
					?>
					<td><?php echo htmlspecialchars($suspend_duration); ?></td>
					<td><?php echo htmlspecialchars($data['reason']); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="8" align="center">No data found</td>
			</tr>
		<?php endif; ?>
	</table>
</body>
</html>
