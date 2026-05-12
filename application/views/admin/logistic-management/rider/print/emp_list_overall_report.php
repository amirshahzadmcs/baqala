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
		<table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #2DB8DB;">
				<td style="font-size:10px;"><b>Hunger Station - Maha Al Fala</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Online Hours</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$maha_total_orders = 0; 
				$maha_total_hours = 0; 
				foreach($maha_employees as $key => $emp){ 
					$maha_total_orders += $emp['completed_deliveries'];
					$maha_total_hours += $emp['online_hours'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_id'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']);?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']) >= 9 ? 'OK' : '-';?></td>
				<td style="text-align:center;"><?= round((float)$emp['acceptance_rate'], 0);?>%</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Deliveries</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $maha_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= round($maha_total_hours);?></b></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #2DB8DB;">
				<td style="font-size:10px;"><b>Hunger Station - Wazer Logistics</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Online Hours</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$wazer_total_orders = 0; 
				$wazer_total_hours = 0; 
				foreach($wazer_employees as $key => $emp){ 
					$wazer_total_orders += $emp['completed_deliveries'];
					$wazer_total_hours += $emp['online_hours'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_id'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']);?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']) >= 9 ? 'OK' : '-';?></td>
				<td style="text-align:center;"><?= round((float)$emp['acceptance_rate'], 0);?>%</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Deliveries</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $wazer_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= round($wazer_total_hours);?></b></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #2DB8DB;">
				<td style="font-size:10px;"><b>Hunger Station - Outsource</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Online Hours</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$outsource_total_orders = 0; 
				$outsource_total_hours = 0; 
				foreach($outsource_employees as $key => $emp){ 
					$outsource_total_orders += $emp['completed_deliveries'];
					$outsource_total_hours += $emp['online_hours'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_no'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']);?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']) >= 9 ? 'OK' : '-';?></td>
				<td style="text-align:center;"><?= round((float)$emp['acceptance_rate'], 0);?>%</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Deliveries</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $outsource_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= round($outsource_total_hours);?></b></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #2DB8DB;">
				<td style="font-size:10px;"><b>Jahez</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>COD</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Debit</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Credit</b></th>
			</tr>
			<?php 
				$jahez_total_orders = 0; 
				$jahez_total_cash = 0; 
				$jahez_total_credit = 0; 
				$jahez_total_debit = 0; 
				foreach($jahez_employees as $key => $emp){ 
					$jahez_total_orders += $emp['completed_deliveries'];
					$jahez_total_cash += $emp['last_cash_collection'];
					$jahez_total_credit += $emp['last_driver_credit'];
					$jahez_total_debit += $emp['last_driver_debit'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_no'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= $emp['last_cash_collection'];?></td>
				<td style="text-align:center;"><?= $emp['last_driver_debit'];?></td>
				<td style="text-align:center;"><?= $emp['last_driver_credit'];?></td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Deliveries</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $jahez_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $jahez_total_cash;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $jahez_total_debit;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $jahez_total_credit;?></b></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>
        
        <!-- Less than 13 deliveries (Hunger) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Hunger Station - Riders Less Than 13 Orders</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Online Hours</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$low_hunger_total_orders = 0; 
				$low_hunger_total_hours = 0; 
				foreach($low_hunger as $key => $emp){ 
					$low_hunger_total_orders += $emp['completed_deliveries'];
					$low_hunger_total_hours += $emp['online_hours'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_no'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']);?></td>
				<td style="text-align:center;"><?= round($emp['online_hours']) >= 9 ? 'OK' : '-';?></td>
				<td style="text-align:center;"><?= round((float)$emp['acceptance_rate'], 0);?>%</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Deliveries</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $low_hunger_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= round($low_hunger_total_hours);?></b></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

        <!-- Less than 13 deliveries (Jahez) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Jahez - Riders Less Than 13 Orders</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>COD</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Debit</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Credit</b></th>
			</tr>
			<?php 
				$low_jahez_total_orders = 0; 
				$low_jahez_total_cash = 0; 
				$low_jahez_total_credit = 0;
				$low_jahez_total_debit = 0;
				foreach($low_jahez as $key => $emp){ 
					$low_jahez_total_orders += $emp['completed_deliveries'];
					$low_jahez_total_cash += $emp['cash_collection'];
					$low_jahez_total_credit += $emp['driver_credit'];
					$low_jahez_total_debit += $emp['driver_debit'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_no'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= $emp['cash_collection'];?></td>
				<td style="text-align:center;"><?= $emp['driver_debit'];?></td>
				<td style="text-align:center;"><?= $emp['driver_credit'];?></td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Deliveries</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $low_jahez_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $low_jahez_total_cash;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $low_jahez_total_debit;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $low_jahez_total_credit;?></b></td>
			</tr>
			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

		<!-- Hunger Attendance (Maha) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Hunger Station Absent - Maha Al Fala</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Attendance</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Reason</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$sr_no = 1;
				foreach($hunger_maha_attend as $key => $attend){ 
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $sr_no++;?></td>
				<td style="text-align:center;"><?= $attend['emp_code'];?></td>
				<td style="text-align:left;"><?= $attend['emp_name'];?></td>
				<td style="text-align:center;"><?= $attend['rider_id'];?></td>
				<td style="text-align:center;"><?= $attend['vehicle_type'] ? ucfirst($attend['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $attend['attendance'];?></td>
				<td style="text-align:center;"><?= $attend['reason'];?></td>
				<td style="text-align:center;">-</td>
				<td style="text-align:center;">-</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Absent</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= count($hunger_maha_attend);?></b></td>
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

		<!-- Hunger Attendance (Wazer) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Hunger Station Absent - Wazer Logistics</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Attendance</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Reason</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$sr_no = 1;
				foreach($hunger_wazer_attend as $key => $attend){ 
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $sr_no++;?></td>
				<td style="text-align:center;"><?= $attend['emp_code'];?></td>
				<td style="text-align:left;"><?= $attend['emp_name'];?></td>
				<td style="text-align:center;"><?= $attend['rider_id'];?></td>
				<td style="text-align:center;"><?= $attend['vehicle_type'] ? ucfirst($attend['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $attend['attendance'];?></td>
				<td style="text-align:center;"><?= $attend['reason'];?></td>
				<td style="text-align:center;">-</td>
				<td style="text-align:center;">-</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Absent</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= count($hunger_wazer_attend);?></b></td>
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

		<!-- Hunger Attendance (Outsourced) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Hunger Station Absent - Outsourced</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Attendance</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Reason</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$sr_no = 1;
				foreach($outsource_attend as $key => $attend){ 
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $sr_no++;?></td>
				<td style="text-align:center;"><?= $attend['emp_code'];?></td>
				<td style="text-align:left;"><?= $attend['emp_name'];?></td>
				<td style="text-align:center;"><?= $attend['rider_id'];?></td>
				<td style="text-align:center;"><?= $attend['vehicle_type'] ? ucfirst($attend['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $attend['attendance'];?></td>
				<td style="text-align:center;"><?= $attend['reason'];?></td>
				<td style="text-align:center;">-</td>
				<td style="text-align:center;">-</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Absent</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= count($outsource_attend);?></b></td>
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

		<!-- Jahez Attendance -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Jahez Absent</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Attendance</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Reason</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$sr_no = 1;
				foreach($jahez_attend as $key => $attend){ 
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $sr_no++;?></td>
				<td style="text-align:center;"><?= $attend['emp_code'];?></td>
				<td style="text-align:left;"><?= $attend['emp_name'];?></td>
				<td style="text-align:center;"><?= $attend['rider_id'];?></td>
				<td style="text-align:center;"><?= $attend['vehicle_type'] ? ucfirst($attend['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $attend['attendance'];?></td>
				<td style="text-align:center;"><?= $attend['reason'];?></td>
				<td style="text-align:center;">-</td>
				<td style="text-align:center;">-</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Absent</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= count($jahez_attend);?></b></td>
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>
		
		<!-- Cash Employees (Jahez) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Jahez Rider with COD Amount</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Date</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:28%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Aggregator ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Cash Collection</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Credit</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Debit</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>COD Collection</b></th>
			</tr>
			<?php 
				$cash_jahez_total_orders = 0; 
				$cash_jahez_total_cash = 0; 
				$cash_jahez_total_credit = 0;
				$cash_jahez_total_debit = 0;
				$total_cod_collection = 0; 
				foreach($jahez_cash_employees as $key => $emp){ 
					$cod_collection = $emp['cash_collection'] - $emp['driver_credit'];

					// Skip row if COD Collection is 0
					if ($cod_collection == 0) {
						continue;
					}

					$cash_jahez_total_orders += $emp['completed_deliveries'];
					$cash_jahez_total_cash += $emp['cash_collection'];
					$cash_jahez_total_credit += $emp['driver_credit'];
					$cash_jahez_total_debit += $emp['driver_debit'];
					$total_cod_collection += $cod_collection;
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $date_to;?></td>
				<td style="text-align:center;"><?= $emp['emp_no'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= number_format($emp['cash_collection'], 2);?></td>
				<td style="text-align:center;"><?= number_format($emp['driver_credit'], 2);?></td>
				<td style="text-align:center;"><?= number_format($emp['driver_debit'], 2);?></td>
				<td style="text-align:center;"><?= number_format($emp['cash_collection'] - $emp['driver_credit'], 2);?></td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" align="right" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total COD</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= number_format($cash_jahez_total_cash, 2);?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= number_format($cash_jahez_total_credit, 2);?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= number_format($cash_jahez_total_debit, 2);?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= number_format($total_cod_collection, 2);?></b></td>
			</tr>
			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>

		<!-- Jahez Debit Employees (Jahez) -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Jahez Rider with Debit</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Completed Deliveries</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>COD</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Debit</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Driver Credit</b></th>
			</tr>
			<?php 
				$debit_jahez_total_orders = 0; 
				$debit_jahez_total_cash = 0; 
				$debit_jahez_total_credit = 0;
				$debit_jahez_total_debit = 0;
				foreach($jahez_debit_employees as $key => $emp){ 
					$debit_jahez_total_orders += $emp['completed_deliveries'];
					$debit_jahez_total_cash += $emp['cash_collection'];
					$debit_jahez_total_credit += $emp['driver_credit'];
					$debit_jahez_total_debit += $emp['driver_debit'];
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $emp['sr_no'];?></td>
				<td style="text-align:center;"><?= $emp['emp_no'];?></td>
				<td style="text-align:left;"><?= $emp['emp_name'];?></td>
				<td style="text-align:center;"><?= $emp['rider_id'];?></td>
				<td style="text-align:center;"><?= $emp['vehicle_type'] ? ucfirst($emp['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $emp['completed_deliveries'];?></td>
				<td style="text-align:center;"><?= $emp['cash_collection'];?></td>
				<td style="text-align:center;"><?= $emp['driver_debit'];?></td>
				<td style="text-align:center;"><?= $emp['driver_credit'];?></td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Debits</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $debit_jahez_total_orders;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $debit_jahez_total_cash;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $debit_jahez_total_debit;?></b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= $debit_jahez_total_credit;?></b></td>
			</tr>
			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>
		
		<!-- Non Operational Attendance -->
        <table class="table" width="100%" border="0" cellspacing="0" cellpadding="3" style="font-size: 9px;">
			<tr style="background-color: #EC8D70;">
				<td style="font-size:10px;"><b>Non Operational Absent</b></td>
			</tr>
			<tr style="background-color: #F7FF82;">
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Sr. No</b></th>
				<th valign="top" style="width:8%;text-align:center;color:#AA6908;font-size:10px;"><b>Emp ID</b></th>
				<th valign="top" style="width:30%;text-align:left;color:#AA6908;font-size:10px;"><b>Emp Name</b></th>
				<th valign="top" style="width:6%;text-align:center;color:#AA6908;font-size:10px;"><b>Rider ID</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Vehicle Type</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Attendance</b></th>
				<th valign="top" style="width:10%;text-align:center;color:#AA6908;font-size:10px;"><b>Reason</b></th>
				<th valign="top" style="width:9%;text-align:center;color:#AA6908;font-size:10px;"><b>Compliance</b></th>
				<th valign="top" style="width:11%;text-align:center;color:#AA6908;font-size:10px;"><b>Acceptance Rate</b></th>
			</tr>
			<?php 
				$sr_no = 1;
				foreach($nonoperational_attend as $key => $attend){ 
			?>
			<tr class="item-list">
				<td style="text-align:center;"><?= $sr_no++;?></td>
				<td style="text-align:center;"><?= $attend['emp_code'];?></td>
				<td style="text-align:left;"><?= $attend['emp_name'];?></td>
				<td style="text-align:center;"><?= $attend['rider_id'];?></td>
				<td style="text-align:center;"><?= $attend['vehicle_type'] ? ucfirst($attend['vehicle_type']) : '';?></td>
				<td style="text-align:center;"><?= $attend['attendance'];?></td>
				<td style="text-align:center;"><?= $attend['reason'];?></td>
				<td style="text-align:center;">-</td>
				<td style="text-align:center;">-</td>
			</tr>
			<?php } ?>
			<tr class="totals-row">
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
				<td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;"><b>Total Absent</b></td>
				<td style="background-color:#a0ffad;text-align:center;color:#0c2d6b;border-top:1px solid #000;border-bottom:1px solid #000;"><b><?= count($nonoperational_attend);?></b></td>
				<td colspan="3" style="border-top:1px solid #000;border-bottom:1px solid #000;"></td>
			</tr>

			<tr>
				<td valign="middle" colspan="9"></td>
			</tr>
		</table>
	</body>
</html>
