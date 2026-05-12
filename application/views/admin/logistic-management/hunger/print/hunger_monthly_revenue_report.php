<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Monthly Performance Report</title>
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
					<table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
						<tr>
							<td>
								<table class="table" width="100%" border="1" cellspacing="0" cellpadding="3">
									<tr style="background-color: #ddd;">
										<td style="width: 3%;text-align:center;"><strong>No.</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Emp. ID</strong></td>
										<td style="width: 20%;text-align:left;"><strong>Employee Name</strong></td>
										<td style="width: 7%;text-align:center;"><strong>Iqama No.</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Rider ID</strong></td>
										<td style="width: 4%;text-align:center;"><strong>Vehicle Type</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Monthly Target</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Daily Target</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Salary</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Total Orders</strong></td>
										<td style="width: 6%;text-align:center;"><strong>Avg.<br>Deliveries</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Working Days</strong></td>
										<td style="width: 5%;text-align:center;"><strong>Slab Value</strong></td>
										<td style="width: 7%;text-align:center;"><strong>Revenue</strong></td>
										<td style="width: 6%;text-align:center;"><strong>Cost</strong></td>
										<td style="width: 7%;text-align:center;"><strong>Gross Revenue</strong></td>
									</tr>

									<?php
									$i = 1;
									$totals = [
										'monthly_target' => 0,
										'daily_target' => 0,
										'salary' => 0,
										'total_orders' => 0,
										'avg_deliveries_sum' => 0,
										'avg_deliveries_count' => 0,
										'working_days' => 0,
										'slab_value' => 0,
										'revenue' => 0,
										'cost' => 0,
										'net_revenue' => 0
									];

									if (!empty($reports['details'])) {
										foreach ($reports['details'] as $report) {
											$vehicle_type = strtolower(trim($report['vehicle_type']));
											$deliveries = (int) $report['total_completed_deliveries'];

											// Determine slab rate and cost
											if ($vehicle_type === 'car') {
												if ($deliveries <= 200) $rate = 10;
												elseif ($deliveries <= 300) $rate = 13;
												else $rate = 18;
												$cost = 6450.00;
											} else {
												if ($deliveries <= 200) $rate = 10;
												elseif ($deliveries <= 300) $rate = 13;
												elseif ($deliveries <= 400) $rate = 14;
												elseif ($deliveries <= 500) $rate = 16;
												else $rate = 17;
												$cost = 5589.00;
											}

											$revenue = $deliveries * $rate;
											$net_revenue = $revenue - $cost;

											// Update totals
											$totals['monthly_target'] += $report['monthly_target'];
											$totals['daily_target'] += $report['daily_target'];
											$totals['salary'] += $report['salary'];
											$totals['total_orders'] += $deliveries;
											$totals['avg_deliveries_sum'] += $report['avg_completed_deliveries'];
											$totals['avg_deliveries_count']++;
											$totals['working_days'] += $report['working_days'];
											$totals['slab_value'] += $rate;
											$totals['revenue'] += $revenue;
											$totals['cost'] += $cost;
											$totals['net_revenue'] += $net_revenue;
									?>
											<tr class="item-list">
												<td style="text-align:center;"><?php echo $i++; ?>.</td>
												<td style="text-align:center;"><?php echo $report['emp_no']; ?></td>
												<td style="text-align:left;"><?php echo $report['full_name']; ?></td>
												<td style="text-align:center;"><?php echo $report['iqama_no']; ?></td>
												<td style="text-align:center;"><?php echo $report['rider_id']; ?></td>
												<td style="text-align:center;"><?php echo ucfirst($report['vehicle_type']); ?></td>
												<td style="text-align:center;"><?php echo round($report['monthly_target']); ?></td>
												<td style="text-align:center;"><?php echo round($report['daily_target']); ?></td>
												<td style="text-align:center;"><?php echo number_format($report['salary'], 2); ?></td>
												<td style="text-align:center;"><?php echo $deliveries; ?></td>
												<td style="text-align:center;"><?php echo round($report['avg_completed_deliveries']); ?></td>
												<td style="text-align:center;"><?php echo $report['working_days']; ?></td>
												<td style="text-align:center;"><?php echo number_format($rate, 2); ?></td>
												<td style="text-align:center;"><?php echo number_format($revenue, 2); ?></td>
												<td style="text-align:center;"><?php echo number_format($cost, 2); ?></td>
												<td style="text-align:center;"><?php echo number_format($net_revenue, 2); ?></td>
											</tr>
									<?php }
										// Calculate average of avg deliveries
										$avg_of_avg = $totals['avg_deliveries_count'] > 0
											? $totals['avg_deliveries_sum'] / $totals['avg_deliveries_count']
											: 0;

									} else { ?>
										<tr>
											<td colspan="16" style="text-align:center; font-weight:bold; padding: 10px;">No data found</td>
										</tr>
									<?php } ?>

									<?php if (!empty($reports['details'])) { ?>
										<tr style="background-color:#f2f2f2; font-weight: bold;">
											<td colspan="6" style="text-align:right;">Total</td>
											<td style="text-align:center;"><?php echo round($totals['monthly_target']); ?></td>
											<td style="text-align:center;"><?php echo round($totals['daily_target']); ?></td>
											<td style="text-align:center;"><?php echo number_format($totals['salary'], 2); ?></td>
											<td style="text-align:center;"><?php echo $totals['total_orders']; ?></td>
											<td style="text-align:center;"><?php echo round($avg_of_avg); ?></td>
											<td style="text-align:center;"><?php echo $totals['working_days']; ?></td>
											<td style="text-align:center;"><?php echo number_format($totals['slab_value'], 2); ?></td>
											<td style="text-align:center;"><?php echo number_format($totals['revenue'], 2); ?></td>
											<td style="text-align:center;"><?php echo number_format($totals['cost'], 2); ?></td>
											<td style="text-align:center;"><?php echo number_format($totals['net_revenue'], 2); ?></td>
										</tr>
									<?php } ?>

								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
