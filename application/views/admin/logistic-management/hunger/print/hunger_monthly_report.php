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
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 12px;">
						<tr>
							<?php
							if($search_start_date !== 'NA' && $search_start_date !== $search_end_date){
								$data_range = $search_start_date .' - '. $search_end_date;
							}elseif ($search_start_date !== 'NA' && $search_start_date == $search_end_date) {
								$data_range = $search_start_date;
							}else{
								$data_range = 'ALL';
							}
							?>
							<td valign="middle" style="text-align:right;color:red;"><?php echo ($team_name !== '') ? $team_name : 'ALL';?></td>
							<td colspan="4" valign="middle" style="text-align:right;color:red;">Hunger Station - Monthly Corporate ID Delivery Report - <?php echo $data_range;?></td>
							<td colspan="2" valign="middle" style="text-align:right;color:red;">Completed Deliveries</td>
							<td valign="middle" style="text-align:center;background-color:#c6efce;color:green;"><strong><?php echo $reports['totals']['total_completed_deliveries'];?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table class="table" width="100%" border="0" cellspacing="1" cellpadding="3" style="font-size: 10px;">
						<tr><td colspan="13" style="border-bottom: 1px solid #000;line-height:0px;"></td></tr>
						<tr>
							<td colspan="3" valign="middle" style="width: 17%;text-align:center;color:red;background-color:#ffc7ce;">No's Riders</td>
							<td colspan="2" valign="middle" style="width: 28%;text-align:center;color:red;"><?php echo $reports['totals']['total_riders'];?></td>
							<td colspan="2" valign="middle" style="width: 15%;text-align:center;color:red;background-color:#ffc7ce;">Total Delivery</td>
							<td colspan="2" valign="middle" style="width: 13%;text-align:center;color:red;"><?php echo $reports['totals']['total_completed_deliveries'];?></td>
							<td colspan="2" valign="middle" style="width: 14%;text-align:center;color:red;background-color:#ffc7ce;">Average Per Rider</td>
							<td colspan="2" valign="middle" style="width: 13%;text-align:center;color:red;"><?php echo round($reports['totals']['total_completed_deliveries'] / $reports['totals']['total_riders']);?></td>
						</tr>
						<tr><td colspan="13" style="border-top: 1px solid #000;line-height:0px;"></td></tr>
					</table>
					<table class="table" width="100%" border="0" cellspacing="0" cellpadding="2">
						<tr style="background-color: #f5d880;">
							<td valign="top" style="width: 5%;text-align:center;"><strong>No.</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Rider ID</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Emp. ID</strong></td>
							<td valign="top" style="width: 18%;text-align:left;"><strong>Rider Name</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Completed Deliveries</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Cancelled Deliveries</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Notified Deliveries</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Declined Deliveries</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Accepted Deliveries</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Not Accepted Deliveries</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Monthly Wallet Amount</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Total Working Hours</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Acceptance Rate</strong></td>
						</tr>
						<?php $i=1;foreach($reports['details'] as $report){
						?>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $i++;?>.</td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['rider_id'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['emp_no'];?></td>
							<td valign="bottom" style="text-align:left;line-height:10px;"><?php echo $report['full_name'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo ($report['total_completed_deliveries'] < 401) ? '<span style="color:red;"><b>'.$report['total_completed_deliveries'] .'</b></span>' : '<span style="color:green;"><b>'.$report['total_completed_deliveries'].'</b></span>';?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['total_cancelled_deliveries'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['total_notified_deliveries'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['total_declined_deliveries'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['total_accepted_deliveries'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['total_not_accepted_deliveries'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['monthly_wallet_balance'], 2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_working_hours'], 2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['average_acceptance_rate'], 2) .'%';?></td>
						</tr>
						<tr>
							<td valign="middle" colspan="13" style="border-top:1px dashed #ddd;line-height:0px;"></td>
						</tr>
						<?php } ?>
						<!-- <tr><td colspan="12"></td></tr>
						<tr><td colspan="12" style="border-top: 1px solid #000;line-height:-10px;"></td></tr> -->
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
