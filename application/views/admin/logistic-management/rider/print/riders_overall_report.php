<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Maha Al Fala Delivery Report</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
		</style>
	</head>
	<body>
		
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
			<tr>
				<td>
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 12px;">
						<tr>
							<td valign="middle" style="text-align:center;color:#0c2d6b;"><h3>Maha Al Fala Delivery Report</h3></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5">
						<tr style="background-color: #0c2d6b;">
							<th valign="top" style="width:7%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>From</b></th>
							<th valign="top" style="width:8%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>To</b></th>
							<th valign="top" style="width:10%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Aggregator</b></th>
							<th valign="top" style="width:7%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total<br/>Deliveries</b></th>
							<th valign="top" style="width:7%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Notified<br/>Deliveries</b></th>
							<th valign="top" style="width:7%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Completed<br/>Deliveries</b></th>
							<th valign="top" style="width:8%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Operational<br>Riders</b></th>
							<th valign="top" style="width:6%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Active Riders</b></th>
							<th valign="top" style="width:8%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Planned<br/>Working Hrs</b></th>
							<th valign="top" style="width:8%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Avg Working<br/>Hrs Variance</b></th>
							<th valign="top" style="width:9%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Avg Deliveries<br>Per Rider</b></th>
							<th valign="top" style="width:7%;text-align:center;color:#ffffff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>%age<br/>Difference</b></th>
							<th valign="top" style="width:8%;text-align:center;color:#ffffff;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Riders Less Than 13 Orders</b></th>
						</tr>
						<?php //$i=1;foreach($reports['details'] as $report){
						?>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_from;?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_to;?></td>
							<td class="text-left"><?= $details['hunger_maha']['aggregator'];?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['total_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['notified_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['completed_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['total_ops_riders'];?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['active_riders'];?></td>
							<td style="text-align:center;"><?= round((float)$details['hunger_maha']['planned_hours'], 0);?></td>
							<td style="text-align:center;" class="negative"><?= round($details['hunger_maha']['avg_hours_variance'], 0);?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['avg_dlvy_per_rider'];?></td>
							<td style="text-align:center;" class="negative"><?= $details['hunger_maha']['percentage_difference'];?></td>
							<td style="text-align:center;"><?= $details['hunger_maha']['riders_lt_13_orders'] ?? 0;?></td>
						</tr>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_from;?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_to;?></td>
							<td class="text-left"><?= $details['hunger_wazer']['aggregator'];?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['total_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['notified_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['completed_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['total_ops_riders'];?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['active_riders'];?></td>
							<td style="text-align:center;"><?= round((float)$details['hunger_wazer']['planned_hours'], 0);?></td>
							<td style="text-align:center;" class="negative"><?= round($details['hunger_wazer']['avg_hours_variance'], 0);?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['avg_dlvy_per_rider'];?></td>
							<td style="text-align:center;" class="negative"><?= $details['hunger_wazer']['percentage_difference'];?></td>
							<td style="text-align:center;"><?= $details['hunger_wazer']['riders_lt_13_orders'] ?? 0;?></td>
						</tr>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_from;?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_to;?></td>
							<td class="text-left"><?= $details['hunger_outsource']['aggregator'];?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['total_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['notified_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['completed_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['total_ops_riders'];?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['active_riders'];?></td>
							<td style="text-align:center;"><?= round((float)$details['hunger_outsource']['planned_hours'], 0);?></td>
							<td style="text-align:center;" class="negative"><?= round($details['hunger_outsource']['avg_hours_variance'], 0);?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['avg_dlvy_per_rider'];?></td>
							<td style="text-align:center;" class="negative"><?= $details['hunger_outsource']['percentage_difference'];?></td>
							<td style="text-align:center;"><?= $details['hunger_outsource']['riders_lt_13_orders'] ?? 0;?></td>
						</tr>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_from;?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_to;?></td>
							<td class="text-left"><?= $details['jahez']['aggregator'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['total_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['notified_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['completed_deliveries'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['total_ops_riders'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['active_riders'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['planned_hours'];?></td>
							<td style="text-align:center;" class="negative"><?= $details['jahez']['avg_hours_variance'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['avg_dlvy_per_rider'];?></td>
							<td style="text-align:center;" class="negative"><?= $details['jahez']['percentage_difference'];?></td>
							<td style="text-align:center;"><?= $details['jahez']['riders_lt_13_orders'] ?? 0;?></td>
						</tr>
						<?php if($details['noon']['total_deliveries'] > 0){ ?>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_from;?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?= $date_to;?></td>
							<td class="text-left"><?= $details['noon']['aggregator'];?></td>
							<td style="text-align:center;"><?= $details['noon']['total_deliveries'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['notified_deliveries'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['completed_deliveries'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['total_ops_riders'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['active_riders'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['planned_hours'] ?? 0;?></td>
							<td style="text-align:center;" class="negative"><?= $details['noon']['avg_hours_variance'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['avg_dlvy_per_rider'] ?? 0;?></td>
							<td style="text-align:center;" class="negative"><?= $details['noon']['percentage_difference'] ?? 0;?></td>
							<td style="text-align:center;"><?= $details['noon']['riders_lt_13_orders'] ?? 0;?></td>
						</tr>
						<?php } ?>
						<?php
							$total_deliveries = 0;
							$total_notified = 0;
							$total_completed = 0;
							$total_ops_riders = 0;
							$total_active_riders = 0;
							$total_planned_hours = 0;
							$total_working_hours = 0;
							$total_target_dlvy_per_rider = 0;
							$total_riders_lt_13_orders = 0;
							$sum_avg_hours_variance = 0;
							$sum_riders_lt_13_orders = 0;

							// ✅ For averages only non-zero values
							$sum_avg_delv_riders = 0;
							$non_zero_avg_count = 0;

							$sum_per_age_diff = 0;
							$non_zero_percentage_count = 0;

							foreach (['hunger_maha', 'hunger_wazer', 'hunger_outsource', 'jahez', 'noon'] as $key) {
								$active_riders = (int)($details[$key]['active_riders'] ?? 0);
								$deliveries    = (int)($details[$key]['total_deliveries'] ?? 0);

								$total_deliveries    += $deliveries;
								$total_notified      += (int)($details[$key]['notified_deliveries'] ?? 0);
								$total_completed     += (int)($details[$key]['completed_deliveries'] ?? 0);
								$total_ops_riders    += (int)($details[$key]['total_ops_riders'] ?? 0);
								$total_riders_lt_13_orders    += (int)($details[$key]['riders_lt_13_orders'] ?? 0);
								$total_active_riders += $active_riders;
								$total_planned_hours += (float)($details[$key]['planned_hours'] ?? 0);

								$total_working_hours += (float)($details[$key]['actual_working_hours'] ?? 0);

								$sum_avg_hours_variance += (float)($details[$key]['avg_hours_variance'] ?? 0);

								// ✅ Avg deliveries per rider (only if >0)
								if (!empty($details[$key]['avg_dlvy_per_rider']) && $details[$key]['avg_dlvy_per_rider'] > 0) {
									$sum_avg_delv_riders += $details[$key]['avg_dlvy_per_rider'];
									$non_zero_avg_count++;
								}

								// ✅ Percentage difference (only if >0)
								if (is_numeric($details[$key]['percentage_difference'] ?? null) && (float)$details[$key]['percentage_difference'] > 0) {
									$sum_per_age_diff += (float)$details[$key]['percentage_difference'];
									$non_zero_percentage_count++;
								}
							}

							// ✅ Totals
							$hours_variance_total = round($sum_avg_hours_variance, 0);

							$avg_dlvy_per_rider_total = $non_zero_avg_count > 0 
								? round($sum_avg_delv_riders / $non_zero_avg_count, 2) 
								: 0;

							$percentage_difference_total = $non_zero_percentage_count > 0 
								? round($sum_per_age_diff / $non_zero_percentage_count, 2) 
								: 0;
						?>
						<tr class="totals-row">
							<td></td>
							<td></td>
							<td class="text-left"></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_deliveries;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_notified;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_completed;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_ops_riders;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_active_riders;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_planned_hours;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;" class="negative"><b><?= $hours_variance_total;?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= round($avg_dlvy_per_rider_total, 0);?></b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;" class="negative"><b><?= $percentage_difference_total;?>%</b></td>
							<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $total_riders_lt_13_orders;?></b></td>
						</tr>

						<tr>
							<td valign="middle" colspan="13"></td>
						</tr>
						<?php //} ?>
					</table>
				</td>
			</tr>

			<tr>
				<td>
					<?php
					// Columns
					$cols = [
						'Absent',
						'Leave',
						'Accident',
						'Annual_Leave',
						'Business_Trip',
						'Casual_Leave',
						'Compassionate_Leave',
						'Health_Issue',
						'ID_Issue',
						'Iqama_Issue',
						'Marriage_Leave',
						'Mobile_Issue',
						'Maternity_Leave',
						'Paternity_Leave',
						'Sponsorship_Issue',
						'Sick_Leave',
						'Unpaid_Leave',
						'Widow_Leave',
						'Week_Off'
					];

					// Labels
					$labels = [
						'hunger_maha'      => 'Hunger-Maha',
						'hunger_wazer'     => 'Hunger-Wazer',
						'hunger_outsource' => 'Hunger-Outsource',
						'jahez'            => 'Jahez',
						'nonoperational'   => 'Non-Operational',
					];

					// ---- Step 1: Filter out empty rows ----
					$filteredAttendance = [];
					foreach ($labels as $key => $label) {
						$row = isset($attendance[$key][0]) ? $attendance[$key][0] : [];
						$rowTotal = array_sum(array_intersect_key($row, array_flip($cols)));

						if ($rowTotal > 0) { // Only keep rows with data
							$filteredAttendance[$key] = $row;
						}
					}

					// ---- Step 2: Detect which columns have at least 1 non-zero value ----
					$activeCols = [];
					foreach ($cols as $c) {
						foreach ($filteredAttendance as $row) {
							if (!empty($row[$c])) {
								$activeCols[] = $c;
								break;
							}
						}
					}

					// Agar sab zero hain to kam se kam ek column "Absent" show ho
					if (empty($activeCols)) {
						$activeCols = ['Absent'];
					}

					// ---- Step 3: Init grand totals ----
					$grand = array_fill_keys($activeCols, 0);
					$grand_total = 0;
					?>

					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5">
						<tr style="background-color:#0c2d6b;">
							<th style="text-align:center;color:#fff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;width:110px;"><b>Aggregator</b></th>
							<?php foreach ($activeCols as $c): ?>
								<th style="text-align:center;color:#fff;border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">
									<b><?= str_replace('_',' ', $c) ?></b>
								</th>
							<?php endforeach; ?>
							<th style="text-align:center;color:#fff;border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total</b></th>
						</tr>

						<?php foreach ($filteredAttendance as $key => $row): ?>
							<?php
							$row_total = 0;
							?>
							<tr class="item-list">
								<td class="text-left"><?= $labels[$key] ?></td>
								<?php foreach ($activeCols as $c): ?>
									<?php
									$val = (int)($row[$c] ?? 0);
									$grand[$c] += $val;
									$row_total += $val;
									?>
									<td style="text-align:center;"><?= $val ?></td>
								<?php endforeach; ?>
								<td style="text-align:center;"><?= $row_total ?></td>
							</tr>
							<?php $grand_total += $row_total; ?>
						<?php endforeach; ?>

						<tr class="totals-row">
							<td style="background-color:#a0ffad;border-top:1px solid #000;border-bottom:1px solid #000;text-align:center;color:#0c2d6b;">
								<b>Total</b>
							</td>
							<?php foreach ($activeCols as $c): ?>
								<td style="background-color:#a0ffad;border-top:1px solid #000;border-bottom:1px solid #000;text-align:center;color:#0c2d6b;">
									<b><?= $grand[$c] ?></b>
								</td>
							<?php endforeach; ?>
							<td style="background-color:#a0ffad;border-top:1px solid #000;border-bottom:1px solid #000;text-align:center;color:#0c2d6b;">
								<b><?= $grand_total ?></b>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
