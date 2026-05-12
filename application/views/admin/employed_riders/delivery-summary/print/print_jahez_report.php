<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Baqala Station - Jahez Report</title>
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
						<tr><td colspan="8" style="border-top: 1px solid #000;line-height:5px;"></td></tr>
						<tr style="background: #ffe9a9;">
							<td valign="top" style="width: 7%;text-align:center;line-height:-10px;"><strong>Sr. No.</strong></td>
							<td valign="top" style="width: 10%;line-height:-10px;"><strong>Emp No.</strong></td>
							<td valign="top" style="width: 29%;line-height:-10px;"><strong>Emp Name</strong></td>
							<td valign="top" style="width: 10%;line-height:-10px;"><strong>Driver ID</strong></td>
							<td valign="top" style="width: 12%;text-align:right;line-height:-10px;"><strong>Total Delivery</strong></td>
							<td valign="top" style="width: 10%;text-align:right;line-height:-10px;"><strong>Traffic Fine</strong></td>
							<td valign="top" style="width: 10%;text-align:right;line-height:-10px;"><strong>ID Fine</strong></td>
							<td valign="top" style="width: 12%;text-align:right;line-height:-10px;"><strong>Online Hours</strong></td>
						</tr>
						<tr><td colspan="8" style="border-bottom: 1px solid #000;"></td></tr>
						<?php
							$sumTotalDelv = 0;
							$sumTotalTF = 0;
							$sumTotalIDF = 0;
							$sumTotalOH = 0;
						?>
						<?php $i=1;foreach($reports as $report){
							$sumTotalDelv += $report['total_deliveries'];
							$sumTotalTF += 0;
							$sumTotalIDF += $report['total_fine'];
							$sumTotalOH += 0;
						?>
						<tr class="item-list">
							<td valign="top" style="text-align:center;"><?php echo $i++;?>.</td>
							<td valign="top"><?php echo $report['emp_no'];?></td>
							<td valign="top"><?php echo $report['full_name'];?></td>
							<td valign="top"><?php echo $report['driver_id'];?></td>
							<td valign="top" style="text-align:right;"><?php echo $report['total_deliveries'];?></td>
							<td valign="top" style="text-align:right;">0</td>
							<td valign="top" style="text-align:right;"><?php echo number_format($report['total_fine'], 2);?></td>
							<td valign="top" style="text-align:right;">0</td>
						</tr>
						<?php } ?>
						<tr><td colspan="8"></td></tr>
						<tr><td colspan="8" style="border-top: 1px solid #000;line-height:-10px;"></td></tr>
						<tr>
							<td colspan="4" valign="top" align="right"><strong>Total</strong></td>
							<td valign="top" style="text-align:right;"><p><?php echo $sumTotalDelv;?></p></td>
							<td valign="top" style="text-align:right;"><p><?php echo number_format($sumTotalTF, 2);?></p></td>
							<td valign="top" style="text-align:right;"><p><?php echo number_format($sumTotalIDF, 2);?></p></td>
							<td valign="top" style="text-align:right;"><p><?php echo number_format($sumTotalOH, 2);?></p></td>
						</tr>
						<tr><td colspan="8" style="border-top: 1px solid #000;line-height:5px;"></td></tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
