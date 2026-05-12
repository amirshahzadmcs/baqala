<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Baqala Station - Hunger Station Report</title>
		<style>
		*{padding:0px;margin:0px;}
		
		</style>
	</head>
	<body>
		<style>
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
		</style>
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
			<tr>
				<td colspan="2">
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5">
						<tr><td colspan="8" style="border-top: 1px solid #000;line-height:0px;"></td></tr>
						<tr style="background: #ffe9a9;">
							<td valign="top" style="width: 7%;text-align:center;"><strong>Sr. No.</strong></td>
							<td valign="top" style="width: 9%;"><strong>Emp No.</strong></td>
							<td valign="top" style="width: 23%;"><strong>Emp Name</strong></td>
							<td valign="top" style="width: 9%;"><strong>Rider ID</strong></td>
							<td valign="top" style="width: 9%;text-align:right;"><strong>Notified Delivery</strong></td>
							<td valign="top" style="width: 9%;text-align:right;"><strong>Completed Delivery</strong></td>
							<td valign="top" style="width: 9%;text-align:right;"><strong>Unattended Deliveries</strong></td>
							<td valign="top" style="width: 9%;text-align:right;"><strong>Average Delivery</strong></td>
							<td valign="top" style="width: 9%;text-align:right;"><strong>ID Fine</strong></td>
							<td valign="top" style="width: 7%;text-align:right;"><strong>Online Hours</strong></td>
						</tr>
						<tr><td colspan="10" style="border-bottom: 1px solid #000;line-height:0px;"></td></tr>
						<?php
							$sumTotalIds = 0;
							$sumTotalNotifiedDelv = 0;
							$sumTotalCompleteDelv = 0;
							$sumTotalCancelledDelv = 0;
							$sumTotalDeclinedDelv = 0;
							$sumTotalNotAcceptDelv = 0;
							$sumTotalAvgDelv = 0;
							$sumTotalIDF = 0;
							$sumTotalOH = 0;
						?>
						<?php $i=1;foreach($reports as $report){
							$sumTotalIds += $report['total_ids'];
							$sumTotalNotifiedDelv += $report['total_notified_deliveries'];
							$sumTotalCompleteDelv += $report['total_completed_deliveries'];
							$sumTotalCancelledDelv += $report['total_cancelled_deliveries'];
							$sumTotalDeclinedDelv += $report['total_declined_deliveries'];
							$sumTotalNotAcceptDelv += $report['total_not_accepted_deliveries'];
							$sumTotalAvgDelv += $report['total_avg_rider_acceptance_rate'];
							$sumTotalIDF += $report['total_fine'];
							$sumTotalOH += $report['total_working_hours'];
						?>
						<tr class="item-list">
							<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
							<td valign="top"><?php echo $report['emp_no'];?></td>
							<td valign="top"><?php echo $report['full_name'];?></td>
							<td valign="top"><?php echo $report['rider_id'];?></td>
							<td valign="top" style="text-align:right;"><?php echo $report['total_notified_deliveries'];?></td>
							<td valign="top" style="text-align:right;"><?php echo $report['total_completed_deliveries'];?></td>
							<td valign="top" style="text-align:right;"><?php echo ($report['total_cancelled_deliveries'] + $report['total_declined_deliveries'] + $report['total_not_accepted_deliveries']);?></td>
							<td valign="top" style="text-align:right;"><?php echo number_format(($report['total_avg_rider_acceptance_rate'] / $report['total_ids']),2) .'%';?></td>
							<td valign="top" style="text-align:right;"><?php echo number_format($report['total_fine'], 2);?></td>
							<td valign="top" style="text-align:right;"><?php echo $report['total_working_hours'];?></td>
						</tr>
						<?php } ?>
						<tr><td colspan="10"></td></tr>
						<tr><td colspan="10" style="border-top: 1px solid #000;line-height:-10px;"></td></tr>
						<tr>
							<td colspan="4" valign="top" align="right">Total</td>
							<td valign="top" style="text-align:right;"><?php echo $sumTotalNotifiedDelv;?></td>
							<td valign="top" style="text-align:right;"><?php echo $sumTotalCompleteDelv;?></td>
							<td valign="top" style="text-align:right;"><?php echo ($sumTotalCancelledDelv + $sumTotalDeclinedDelv + $sumTotalNotAcceptDelv);?></td>
							<td valign="top" style="text-align:right;"><?php echo number_format(($sumTotalAvgDelv/$sumTotalIds),2) .'%';?></td>
							<td valign="top" style="text-align:right;"><?php echo number_format($sumTotalIDF, 2);?></td>
							<td valign="top" style="text-align:right;"><?php echo number_format($sumTotalOH, 2);?></td>
						</tr>
						<tr><td colspan="10" style="border-top: 1px solid #000;line-height:5px;"></td></tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
