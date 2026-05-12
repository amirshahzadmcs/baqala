<?php
$search_month = $this->input->get('month_of'); // Adjust to match how you get the search month
?>

<!DOCTYPE html>
<html lang="ae">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Monthly Suspended Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
    </style>
</head>
<body>
	<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
		<tr>
			<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
				<p></p>
				<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
				<span>Riyadh, SA</span><br>
				<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
			</td>
			<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
				<p></p>
				<strong style="font-size: 14px;">Monthly Suspended Report</strong><br>
				<span>Month of: <?php echo $search_month; ?></span><br>
				<span>Filter: <?php echo ($this->input->get('search_keyword') == '') ? 'All Data Available' : $search_keyword; ?></span><br>
			</td>
		</tr>
		<tr>
			<td colspan="2"></td>
		</tr>
	</table>
	<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;border-color:#000;">
		<tr style="background-color: #ccc;color:#000">
			<th width="37px">S.No.</th>
			<th width="50px">Emp ID</th>
			<th width="200px">Employee Name</th>
			<th width="80px">Aggregator ID</th>
			<th width="100px">Aggregator</th>
			<th width="70px">ID Type</th>
			<th width="70px">Suspend Days</th>
			<th width="100px">No. of Suspend Marked</th>
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
					<td align="center"><?php echo htmlspecialchars($data['total_suspended_days']); ?></td>
					<td align="center"><?php echo htmlspecialchars($data['suspend_count']); ?></td>
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
