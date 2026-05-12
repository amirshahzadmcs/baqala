<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Attendance Report</title>
		<style>
			* {padding:0px; margin:0px;}
			table {border-collapse:collapse; table-layout:fixed; width:100%;}
			table td, table th {word-wrap:break-word; border:1px solid #ddd;}
			th {background-color:#F7FF82;}
			td, th {padding:4px;}
		</style>
	</head>
	<body>

		<?php 
			$show_full_compliance = empty($filters['compliance_wise']) || $filters['compliance_wise'] == '';
			$show_present_26 = empty($filters['compliance_wise']) || $filters['compliance_wise'] == '1';
			$show_9_plus = empty($filters['compliance_wise']) || $filters['compliance_wise'] == '2';
			$show_no_week_off = empty($filters['compliance_wise']) || $filters['compliance_wise'] == '3';
			$show_no_last_week = empty($filters['compliance_wise']) || $filters['compliance_wise'] == '4';
			$show_450_plus = empty($filters['compliance_wise']) || $filters['compliance_wise'] == '5';
		?>
		<?php
			// Get first and last day of that month
			$month_start = date("Y-m-01", strtotime($search_month));
			$month_end   = date("Y-m-t",  strtotime($search_month));

			// Calculate last 10 days of the month
			$last_10_from = date("d", strtotime($month_end . " -9 days"));
			$last_10_to   = date("d", strtotime($month_end));
		?>
		<?php if ($show_full_compliance) { ?>
		<?php if (!empty($chart_path)) { ?>
			<table width="100%" cellspacing="5" cellpadding="3">
			<tr>
				<td align="center"><img src="<?= $chart_path ?>" width="250"><br><b>Overall Compliance</b></td>
				<td align="center"><img src="<?= $breakdown_chart_path ?>" width="250"><br><b>Compliance Breakdown</b></td>
				<td align="center"><img src="<?= $non_breakdown_chart_path ?>" width="250"><br><b>Non-Compliance Breakdown</b></td>
			</tr>
			</table>
			<table><tr><td style="height:20px;border:none;"></td></tr></table>
		<?php } ?>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; width:100%;">
			<tr style="background-color:#EC8D70;">
				<td colspan="14" style="font-size:10px;"><b>Attendance Compliance Summary - <?= count($compliance_summary);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:5%;text-align:center;">Emp ID</th>
				<th style="width:21%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No</th>
				<th style="width:7%;text-align:center;">Vehicle No</th>
				<th style="width:6%;text-align:center;">Vehicle Type</th>
				<th style="width:7%;text-align:center;">Aggregator ID</th>
				<th style="width:9%;text-align:center;">Aggregator Name</th>
				<th style="width:6%;text-align:center;">Team</th>
				<th style="width:6%;text-align:center;">26+ Present</th>
				<th style="width:6%;text-align:center;">No Week Off</th>
				<th style="width:5%;text-align:center;">No Off (<?= $last_10_from; ?> - <?= $last_10_to; ?>)</th>
				<th style="width:5%;text-align:center;">Avg >= 9 Hr</th>
				<th style="width:5%;text-align:center;">450+ Orders</th>
			</tr>

			<?php if (!empty($compliance_summary)) {
				$i = 1; 
				$total_26 = $total_weekoff = $total_9 = $total_lastweek = $total_450 = 0;
				foreach ($compliance_summary as $row) {

					$cond_26   = ($row->total_present_days >= 26);
					$cond_week = ($row->total_weekoffs == 0);
					$cond_9    = (isset($row->avg_working_hours) && $row->avg_working_hours >= 9);
					$cond_last = ($row->total_off_last_week == 0);
					$cond_450  = ($row->total_deliveries_in_month >= 450);

					if ($cond_26) $total_26++;
					if ($cond_week) $total_weekoff++;
					if ($cond_9) $total_9++;
					if ($cond_last) $total_lastweek++;
					if ($cond_450) $total_450++;

					// 🌤 Check if joining month == report month
					$joiningMonth = !empty($row->work_joining_date) ? date('Y-m', strtotime($row->work_joining_date)) : '';
					$rowMonth = date('Y-m', strtotime($search_month ?? date('Y-m')));
					$isNewJoiner = ($joiningMonth === $rowMonth);
			?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->team_name; ?></td>

				<?php
					// if new joiner, apply blue tint behind compliance background
					$bg_26   = $cond_26 ? '#B6E4A5' : '#F5B7B1';
					$bg_week = $cond_week ? '#B6E4A5' : '#F5B7B1';
					$bg_last = $cond_last ? '#B6E4A5' : '#F5B7B1';
					$bg_9    = $cond_9 ? '#B6E4A5' : '#F5B7B1';
					$bg_450  = $cond_450 ? '#B6E4A5' : '#F5B7B1';

					if ($isNewJoiner) {
						// blend sky blue overlay using table cell gradient-like logic
						$bg_26   = 'background-color:#D6EAF8;';
						$bg_week = 'background-color:#D6EAF8;';
						$bg_last = 'background-color:#D6EAF8;';
						$bg_9    = 'background-color:#D6EAF8;';
						$bg_450  = 'background-color:#D6EAF8;';
					}
				?>
				<td align="center" style="background-color:<?= $isNewJoiner ? '#D6EAF8' : $bg_26 ?>;"><?= $cond_26 ? 'Y' : 'N'; ?></td>
				<td align="center" style="background-color:<?= $isNewJoiner ? '#D6EAF8' : $bg_week ?>;"><?= $cond_week ? 'Y' : 'N'; ?></td>
				<td align="center" style="background-color:<?= $isNewJoiner ? '#D6EAF8' : $bg_last ?>;"><?= $cond_last ? 'Y' : 'N'; ?></td>
				<td align="center" style="background-color:<?= $isNewJoiner ? '#D6EAF8' : $bg_9 ?>;"><?= $cond_9 ? 'Y' : 'N'; ?></td>
				<td align="center" style="background-color:<?= $isNewJoiner ? '#D6EAF8' : $bg_450 ?>;"><?= $cond_450 ? 'Y' : 'N'; ?></td>
			</tr>
			<?php } ?>
			<tr style="font-weight:bold;">
				<td colspan="9" align="right">Total</td>
				<td align="center"><?= $total_26; ?></td>
				<td align="center"><?= $total_weekoff; ?></td>
				<td align="center"><?= $total_9; ?></td>
				<td align="center"><?= $total_lastweek; ?></td>
				<td align="center"><?= $total_450; ?></td>
			</tr>
			<?php } else { ?>
				<tr><td colspan="14" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<!-- ⬇ FORCE NEW PAGE ⬇ -->
		<div style="page-break-after: always;"></div>

		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Employees with Full Attendance Compliance - <?= count($all_compliance_data);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Presents</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($all_compliance_data)) { $i=1; foreach ($all_compliance_data as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_present_days ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<!-- ⬇ FORCE NEW PAGE ⬇ -->
		<div style="page-break-after: always;"></div>
		<?php } ?>
		<!-- SECTION 1: Riders With 26 Days Present -->
		<?php if ($show_present_26) { ?>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Riders With 26 Days Present - <?= count($present_days_26);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Presents</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($present_days_26)) { $i=1; foreach ($present_days_26 as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_present_days ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Riders With Less Than 26 Days Present - <?= count($present_days_less_26);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Presents</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($present_days_less_26)) { $i=1; foreach ($present_days_less_26 as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_present_days ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<?php } ?>

		<!-- SECTION 2: Riders With 9+ Hours -->
		<?php if (!empty($working_hours_9_plus)) { ?>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Riders With 9+ Hours - <?= count($working_hours_9_plus);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Hours</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($working_hours_9_plus)) { $i=1; foreach ($working_hours_9_plus as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center">
					<?php
					if (!empty($row->avg_working_hours)) {
						$hours = floor($row->avg_working_hours);
						$minutes = round(($row->avg_working_hours - $hours) * 60);
						printf('%02d:%02d', $hours, $minutes);
					} else {
						echo '-';
					}
					?>
				</td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="11" style="font-size:10px;"><b>Riders With Less Than 9 Hours - <?= count($working_hours_9_less);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:27%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:7%;text-align:center;">Total Hours</th>
				<th style="width:7%;text-align:center;">Less Hours</th>
				<th style="width:6%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($working_hours_9_less)) { $i=1; foreach ($working_hours_9_less as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center">
					<?php
					if (!empty($row->avg_working_hours)) {
						$hours = floor($row->avg_working_hours);
						$minutes = round(($row->avg_working_hours - $hours) * 60);
						printf('%02d:%02d', $hours, $minutes);
					} else {
						echo '-';
					}
					?>
				</td>
				<td align="center">
				<?php
				if (!empty($row->avg_working_hours)) {

					// Convert average hours to minutes
					$total_minutes = $row->avg_working_hours * 60;

					// Target 9 hours = 540 minutes
					$required_minutes = 9 * 60;

					if ($total_minutes < $required_minutes) {
						$less_minutes = $required_minutes - $total_minutes;
						$less_h = floor($less_minutes / 60);
						$less_m = $less_minutes % 60;
						printf('%02d:%02d', $less_h, $less_m);
					} else {
						echo "00:00";
					}

				} else {
					echo '-';
				}
				?>
				</td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="11" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<?php } ?>
		<!-- SECTION 3: No Week off (Thursday, Friday & Saturday) -->
		<?php if ($show_no_week_off) { ?>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>No Week off (Thursday, Friday & Saturday) - <?= count($no_week_off);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Week Offs</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($no_week_off)) { $i=1; foreach ($no_week_off as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_weekoffs ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Employee With Week off (Thursday, Friday & Saturday) - <?= count($total_week_off);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Week Offs</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($total_week_off)) { $i=1; foreach ($total_week_off as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_weekoffs ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<?php } ?>

		<!-- SECTION 3: No Off in Last Week -->
		<?php if ($show_no_last_week) { ?>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>No Off in Last 10 Days (<?= $last_10_from; ?> - <?= $last_10_to; ?>) - <?= count($total_last_week_off);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total No Off (Last 10 Days)</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($no_last_week_off)) { $i=1; foreach ($no_last_week_off as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_off_last_week ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Off in Last 10 Days (<?= $last_10_from; ?> - <?= $last_10_to; ?>) - <?= count($total_last_week_off);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Off (Last 10 Days)</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($total_last_week_off)) { $i=1; foreach ($total_last_week_off as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= $row->total_off_last_week ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<?php } ?>
		<!-- SECTION 2: Riders With 450+ Orders -->
		<?php if ($show_450_plus) { ?>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Riders With 450+ Orders - <?= count($orders_450_plus);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Orders</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($orders_450_plus)) { $i=1; foreach ($orders_450_plus as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= round($row->total_deliveries_in_month, 2) ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<!-- <table><tr><td style="height:20px;border:none;"></td></tr></table> -->
		<div style="page-break-after: always;"></div>
		<table border="0" cellspacing="0" cellpadding="3" style="font-size:9px; margin-bottom:15px;">
			<tr style="background-color:#EC8D70;">
				<td colspan="10" style="font-size:10px;"><b>Riders With Less Than 450 Orders - <?= count($total_orders_below_450);?></b></td>
			</tr>
			<tr style="background-color:#F7FF82;">
				<th style="width:4%;text-align:center;">Sr. No</th>
				<th style="width:6%;text-align:center;">Emp ID</th>
				<th style="width:28%;text-align:left;">Emp Name</th>
				<th style="width:8%;text-align:center;">Iqama No.</th>
				<th style="width:8%;text-align:center;">Vehicle No</th>
				<th style="width:8%;text-align:center;">Vehicle Type</th>
				<th style="width:9%;text-align:center;">Aggregator ID</th>
				<th style="width:10%;text-align:center;">Aggregator Name</th>
				<th style="width:10%;text-align:center;">Total Orders</th>
				<th style="width:9%;text-align:center;">Team</th>
			</tr>
			<?php if (!empty($total_orders_below_450)) { $i=1; foreach ($total_orders_below_450 as $row) { ?>
			<tr>
				<td align="center"><?= $i++; ?></td>
				<td align="center"><?= $row->emp_no; ?></td>
				<td><?= $row->emp_full_name; ?></td>
				<td align="center"><?= $row->iqama_no; ?></td>
				<td align="center"><?= $row->vehicle_no; ?></td>
				<td align="center"><?= ucfirst($row->vehicle_type); ?></td>
				<td align="center"><?= $row->aggregator_id; ?></td>
				<td align="center"><?= $row->aggregator_name; ?></td>
				<td align="center"><?= round($row->total_deliveries_in_month, 2) ?? '-'; ?></td>
				<td align="center"><?= $row->team_name; ?></td>
			</tr>
			<?php } } else { ?>
			<tr><td colspan="10" align="center">No records found.</td></tr>
			<?php } ?>
		</table>
		<?php } ?>
	</body>
</html>
