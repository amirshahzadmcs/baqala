<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Jahez Daily Summary Report</title>
	</head>
	<body>
		
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
			<tr>
				<td>
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 12px;">
						<tr>
							<?php
							if($search_start_date !== 'NA' && $search_start_date !== $search_end_date){
								$data_range = $search_start_date .' - '. $search_end_date;
							}elseif ($search_start_date !== 'NA' && $search_start_date == $search_end_date) {
								$data_range = $search_start_date;
							}else{
								$data_range = '';
							}
							?>
							<?php
								$total_deliveries = 0;
								if (!empty($reports)) {
									foreach ($reports as $report) {
										$total_deliveries += $report['total_deliveries'];
									}
								}
								$average_per_rider = count($reports) > 0 ? round($total_deliveries / count($reports), 2) : 0;
							?>
							<td valign="middle" style="text-align:right;color:red;"><?php echo ($search_keyword) ? $search_keyword : 'All Riders';?></td>
							<td colspan="4" valign="middle" style="text-align:right;color:red;">Jahez - Daily Delivery Detail Report <?php echo ($data_range !== '') ? '('. $data_range .')' : '';?></td>
							<td colspan="2" valign="middle" style="text-align:right;color:red;">Completed Deliveries </td>
							<td valign="middle" style="text-align:center;background-color:#c6efce;color:green;"><strong><?= $total_deliveries;?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<?php if(count($reports) > 0){ ?>
					<table class="table" width="100%" border="0" cellspacing="1" cellpadding="3" style="font-size: 10px;">
						<tr><td colspan="7" style="border-bottom: 1px solid #000;line-height:0px;"></td></tr>
						<tr>
							<td colspan="2" valign="middle" style="width: 17%;text-align:center;color:red;background-color:#ffc7ce;">No's Riders</td>
							<td valign="middle" style="width: 28%;text-align:center;color:red;"><?= count($reports);?></td>
							<td valign="middle" style="width: 15%;text-align:center;color:red;background-color:#ffc7ce;">Total Delivery</td>
							<td valign="middle" style="width: 13%;text-align:center;color:red;"><?= $total_deliveries;?></td>
							<td valign="middle" style="width: 14%;text-align:center;color:red;background-color:#ffc7ce;">Average Per Rider</td>
							<td valign="middle" style="width: 13%;text-align:center;color:red;"><?= $average_per_rider;?></td>
						</tr>
						<tr><td colspan="11" style="border-top: 1px solid #000;line-height:0px;"></td></tr>
					</table>
					<?php } ?>
					<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
						<tr style="background-color: #f5d880;">
							<td valign="top" style="width: 5%;text-align:center;"><strong>No.</strong></td>
							<td valign="top" style="width: 8%;text-align:center;"><strong>Rider ID</strong></td>
							<td valign="top" style="width: 8%;text-align:center;"><strong>Emp ID</strong></td>
							<td valign="top" style="width: 20%;text-align:center;"><strong>Employee Name</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Delivery Date</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Completed Deliveries</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>COD Amount</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Price</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Driver Debit Amt. / Penalty</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Driver Credit Amt. / Reversal</strong></td>
							<td valign="top" style="width: 5%;text-align:center;"><strong>Is Free Order</strong></td>
						</tr>
						<?php if(count($reports) > 0){ ?>
						<?php $i=1;foreach($reports as $report){
						?>
						<tr class="item-list">
							<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
							<td valign="top" style="text-align:center;"><?= $report['driver_id']; ?></td>
							<td valign="top" style="text-align:center;"><?= $report['emp_no']; ?></td>
							<td valign="top" style="text-align:left;"><?= $report['full_name']; ?></td>
							<td valign="top" style="text-align:center;"><?= ($report['order_date']) ? date("d-m-Y", strtotime($report['order_date'])) : 'NA'; ?></td>
							<td valign="top" style="text-align:center;">1</td>
							<td valign="top" style="text-align:right;"><?= $report['amount']; ?></td>
							<td valign="top" style="text-align:right;"><?= $report['price']; ?></td>
							<td valign="top" style="text-align:right;"><?= $report['driver_debit_amt']; ?></td>
							<td valign="top" style="text-align:right;"><?= $report['driver_credit_amt']; ?></td>
							<td valign="top" style="text-align:center;"><?= $report['is_free_order'] ? 'Yes' : 'No'; ?></td>
						</tr>
						<?php }}else{ ?>
						<tr><td colspan="11" align="center">No data found, Try another filter</td></tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
