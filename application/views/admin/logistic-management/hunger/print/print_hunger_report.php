<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Daily Performance Report</title>
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
							<td valign="middle" style="text-align:right;color:red;"><?php echo ($team_name !== '') ? $team_name : 'ALL';?></td>
							<td colspan="4" valign="middle" style="text-align:right;color:red;">Hunger Station - Delivery Report <?php echo ($data_range !== '') ? '('. $data_range .')' : '';?></td>
							<td colspan="2" valign="middle" style="text-align:right;color:red;">Completed Deliveries</td>
							<td valign="middle" style="text-align:center;background-color:#c6efce;color:green;"><strong><?php echo $reports['all_delv_count']['total_completed_deliveries'];?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<?php if(!empty($reports['details'])){ ?>
					<table class="table" width="100%" border="0" cellspacing="1" cellpadding="3" style="font-size: 10px;">
						<tr><td colspan="7" style="border-bottom: 1px solid #000;line-height:0px;"></td></tr>
						<tr>
							<td colspan="2" valign="middle" style="width: 17%;text-align:center;color:red;background-color:#ffc7ce;">No's Riders</td>
							<td valign="middle" style="width: 28%;text-align:center;color:red;"><?php echo $reports['totals']['total_riders'];?></td>
							<td valign="middle" style="width: 15%;text-align:center;color:red;background-color:#ffc7ce;">Total Delivery</td>
							<td valign="middle" style="width: 13%;text-align:center;color:red;"><?php echo $reports['totals']['total_completed_deliveries'];?></td>
							<td valign="middle" style="width: 14%;text-align:center;color:red;background-color:#ffc7ce;">Average Per Rider</td>
							<td valign="middle" style="width: 13%;text-align:center;color:red;"><?php echo round($reports['totals']['total_completed_deliveries'] / $reports['totals']['total_riders']);?></td>
						</tr>
						<tr><td colspan="7" style="border-top: 1px solid #000;line-height:0px;"></td></tr>
					</table>
					<?php } ?>
					<table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
						<tr style="background-color: #f5d880;">
							<td valign="top" style="width: 7%;text-align:center;"><strong>No.</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Rider ID</strong></td>
							<td valign="top" style="width: 8%;text-align:center;"><strong>Emp ID</strong></td>
							<td valign="top" style="width: 26%;text-align:center;"><strong>Employee Name</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Local Date</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Completed Deliveries</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Online Hours</strong></td>
							<!-- <td valign="top" style="width: 10%;text-align:center;"><strong>Wallet Minus Amount</strong></td> -->
							<td valign="top" style="width: 10%;text-align:center;"><strong>Vehicle Type</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Acceptance Rate</strong></td>
						</tr>
						<?php if(!empty($reports['details'])){ ?>
						<?php $i=1;foreach($reports['details'] as $report){
						?>
						<tr class="item-list">
							<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
							<td valign="top" style="text-align:center;"><?php echo $report['rider_id'];?></td>
							<td valign="top" style="text-align:center;"><?php echo $report['emp_no'];?></td>
							<td valign="top" style="text-align:left;"><?php echo $report['full_name'];?></td>
							<td valign="top" style="text-align:center;"><?php echo date('d-m-Y', strtotime($report['date_local']));?></td>
							<td valign="top" style="text-align:center;"><?php echo ($report['completed_deliveries'] < 15) ? '<span style="color:red;"><b>'.$report['completed_deliveries'] .'</b></span>' : '<span style="color:green;"><b>'.$report['completed_deliveries'].'</b></span>';?></td>
							<td valign="top" style="text-align:center;"><?php echo $report['working_hours'];?></td>
							<!-- <td valign="top" style="text-align:center;"><?php echo number_format($report['monthly_wallet_balance'], 2);?></td> -->
							<td valign="top" style="text-align:center;"><?php echo (!empty($report['vehicle_type'])) ? ucfirst($report['vehicle_type']) : 'NA';?></td>
							<td valign="top" style="text-align:center;"><?php echo $report['acceptance_rate'] .'%';?></td>
						</tr>
						<?php }}else{ ?>
						<tr><td colspan="9" align="center">No data found, Try another filter</td></tr>
						<?php } ?>
						<!--<tr><td colspan="7" style="border-top: 1px solid #000;line-height:-10px;"></td></tr> -->
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
