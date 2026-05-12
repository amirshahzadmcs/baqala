<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Average Rider Acceptance Report</title>
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
					<table class="table" width="100%" border="1" cellspacing="0" cellpadding="4">
						<tr style="background-color: #f5d880;">
							<td valign="top" style="width: 4%;text-align:center;"><strong>Sr.No.</strong></td>
							<td valign="top" style="width: 5%;text-align:center;"><strong>Emp. ID</strong></td>
							<td valign="top" style="width: 19%;text-align:center;"><strong>Rider Name</strong></td>
							<td valign="top" style="width: 9%;text-align:center;"><strong>Rider ID - رقم المعرف</strong></td>
							<td valign="top" style="width: 5%;text-align:center;"><strong>Team</strong></td>
							<td valign="top" style="width: 7%;text-align:center;"><strong>Orders - عدد الطلبات</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Stacking Deduction (excl vat) - خصم الطلبات المتعددة قبل الضريبة</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>AVG Rider Acceptance Rate - متوسط نسبة معدل القبول</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Acceptance Rate Deduction Amount - مبلغ خصم نسبة معدل القبول</strong></td>
							<td valign="top" style="width: 10%;text-align:center;"><strong>Rider Contact Rate - نسبة تواصل المندوب مع الدعم</strong></td>
							<td valign="top" style="width: 11%;text-align:center;"><strong>Rider Contact Rate Amount - مبلغ خصم نسبة تواصل المندوب مع الدعم</strong></td>
						</tr>
						<?php 
							if(count($avg_report) > 0){
							$i=1;
							foreach($avg_report as $report){
						?>
						<tr class="item-list">
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $i++;?>.</td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['emp_no'];?></td>
							<td valign="bottom" style="text-align:left;line-height:10px;"><?php echo $report['full_name'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['rider_id'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['Team Name'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo $report['total_orders'];?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_stacking_deduction'],2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['average_acceptance_rate'],2) .'%';?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_acceptance_rate_deduction_amt'],2);?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['average_rider_contact_rate'],2) .'%';?></td>
							<td valign="bottom" style="text-align:center;line-height:10px;"><?php echo number_format($report['total_rider_contact_rate_amt'], 2);?></td>
						</tr>
						<?php }}else{ ?>
						<tr><td colspan="10" align="center">No Data Found</td></tr>
						<?php } ?>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
