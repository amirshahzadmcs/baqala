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
							<td colspan="4" valign="middle" style="text-align:right;color:red;">Jahez - Monthly Delivery Report - <?php echo $data_range;?></td>
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
							<td valign="top" style="width: 4%;text-align:center;"><strong>No.</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Driver ID</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Emp. ID</strong></td>
							<td valign="top" style="width: 35%;text-align:left;"><strong>Rider Name</strong></td>
							<td valign="top" style="width: 11%;text-align:center;"><strong>Total Deliveries</strong></td>
							<td valign="top" style="width: 8%;text-align:center;"><strong>Amount</strong></td>
							<td valign="top" style="width: 8%;text-align:center;"><strong>Price</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Debit Amount</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Credit Amount</strong></td>
						</tr>
						<?php $i=1;foreach($reports['details'] as $report){
						?>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $i++;?>.</td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['driver_id'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['emp_no'];?></td>
							<td valign="bottom" style="text-align:left;line-height:10px;"><?php echo $report['full_name'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo ($report['total_completed_deliveries'] < 401) ? '<span style="color:red;"><b>'.$report['total_completed_deliveries'] .'</b></span>' : '<span style="color:green;"><b>'.$report['total_completed_deliveries'].'</b></span>';?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_amount'], 2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_price'], 2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_driver_debit_amt'], 2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_driver_credit_amt'], 2);?></td>
						</tr>
						<tr>
							<td valign="middle" colspan="9" style="border-top:1px dashed #ddd;line-height:0px;"></td>
						</tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
