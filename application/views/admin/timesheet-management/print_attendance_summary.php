<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Rider Attendance Summary</title>
	<style>
		* {
			padding: 0px;
			margin: 0px
		}

		.text-danger td {
			color: red;
		}
	</style>
</head>

<body>
	<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
		<tr>
			<td style="border-top:30px solid #35aa59"></td>
		</tr>
		<tr>
			<td><img src="<?php echo base_url('admin_assets/images/vehicle-timesheet/header-top.jpg'); ?>" /></td>
		</tr>
	</table>
	<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;">
		<?php
		$from = $this->input->get('from', TRUE);
		$to = $this->input->get('to', TRUE);
		$total_row = 0;
		$present_row = 0;
		$absent_row = 0;
		$fromDate = (!empty($from)) ? DateTime::createFromFormat('d M, Y', $from)->format('Y-m-d') : null;
		$toDate = (!empty($to)) ? DateTime::createFromFormat('d M, Y', $to)->format('Y-m-d') : null;
		foreach ($timesheet as $data) {
			$total_row++;
			(!empty($data->out_time)) ? $present_row++ : $absent_row++;
		}
		if ($fromDate) { ?>
			<tr>
				<td width="11%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Department:</td>
				<td width="27%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Logistic</td>
				<td width="9%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Present:</td>
				<td width="12%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;"><?php echo $present_row . ' / ' . $total_row; ?></td>
				<td width="10%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Absent:</td>
				<td width="8%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;"><?php echo $absent_row . ' / ' . $total_row; ?></td>
				<td width="7%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Date:</td>
				<td width="15%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;"><?php echo date('d, M Y', strtotime($fromDate)); ?></td>
			</tr>
		<?php } else { ?>
			<tr>
				<td width="12%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Department:</td>
				<td width="26%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Logistic</td>
				<td width="12%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">Date:</td>
				<td width="40%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;">All</td>
			</tr>
		<?php } ?>
	</table>
	<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size: 10px; width: 100%;">
		<tr>
			<td valign="top" bgcolor="#c6efce" style="width: 4%; text-align: center;"><strong>#</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 7%; text-align: center;"><strong>Emp No</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 27%; text-align: center;"><strong>Employee Name</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 9%; text-align: center;"><strong>Vehicle No</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 12%; text-align: center;"><strong>Platform</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Out Time</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Km</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 7%; text-align: center;"><strong>Battery (%)</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Working Hours</strong></td>
			<td valign="top" bgcolor="#c6efce" style="width: 7%; text-align: center;"><strong>Final Delv.</strong></td>
		</tr>
		<?php $item_row = 1;
		foreach ($timesheet as $data) { ?>
			<tr class="<?php echo (!empty($data->out_time)) ? 'text-normal' : 'text-danger'; ?>">
				<td valign="top" style="text-align: center;"><?php echo $item_row; ?></td>
				<td valign="top" style="text-align: left; <?php echo $data->logs ? 'font-weight: bold:;' : ''; ?>"><?php echo $data->emp_no; ?></td>
				<td valign="top" style="text-align: left;"><?php echo $data->employee_name; ?></td>
				<td valign="top" style="text-align: center;"><?php echo strtoupper($data->vehicle_no); ?></td>
				<td valign="top" style="text-align: center;"><?php echo $data->company_name; ?></td>
				<td valign="top" style="text-align: center;"><?php echo (!empty($data->out_time)) ? date('d-m-Y', strtotime($data->out_time)) : date('d-m-Y', strtotime($fromDate)); ?></td>
				<td valign="top" style="text-align: center;"><?php echo (int)$data->out_km; ?></td>
				<td valign="top" style="text-align: center;"><?php echo $data->out_battery; ?></td>
				<td valign="top" style="text-align: center;"><?php echo $data->working_hours; ?></td>
				<td valign="top" style="text-align: center;"><?php echo $data->completed_deliveries; ?></td>
			</tr>
		<?php $item_row = $item_row + 1;
		} ?>
	</table>
</body>

</html>
