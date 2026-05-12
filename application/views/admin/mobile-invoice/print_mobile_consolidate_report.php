<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Postpaid Mobile Invoice</title>
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
			<td colspan="8" style="padding-top:20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 10px;margin-top:25px;border-bottom:1px solid #000;">
					<!-- <tr>
						<td valign="top" height="20px" colspan="2" style="background-color: #000;color:#fff;"><strong>Billing details for month - <?php echo $period; ?></strong></td>
					</tr> -->
					<tr>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:5%">Sr. No</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Employee UID</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:16%">Employee Name</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Designation</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Department</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Network</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%">Is GPS</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Mobile No</td>
						<!-- <td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;">Previous Balance</td> -->
						<td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;width:8%">Monthly Fees</td>
						<td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;width:10%">Off Plan Charges</td>
						<td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;width:5%">VAT (15%)</td>
						<td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;width:10%"><strong>Total Amount (Inc. VAT)</strong></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8" style="padding-top:20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 8px;margin-top:25px;border-bottom:1px solid #000;">
					<?php 
						$grand_total = 0; 
						$i = 1; 
						$total_monthly_fees = 0; 
						$total_plan_charge = 0; 
						$total_vat = 0; 
						$total_amount = 0; 
						foreach($invoice as $item) { ?>
						<?php
							// $pre_bal = $item->previous_bal;
							$total = ($item->fee + $item->off_plan + $item->add_on) - ($item->adjustment + $item->discount);
							$final_amt = $total + (($total * 15) / 100);
							$tax = (($total * 15) / 100);

							$total_monthly_fees += $item->fee; 
							$total_plan_charge += $item->off_plan; 
							$total_vat += $tax; 
						?>
						<tr>
							<td valign="top" height="20px" style="text-align: left;width:5%"><?php echo $i; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo ($item->emp_no != '' && $item->alloted_user > 0) ? $item->emp_no : 'NA' ?></td>
							<td valign="top" height="20px" style="text-align: left;width:16%"><?php echo ($item->alloted_user != '' && $item->alloted_user > 0) ? (($item->first_name !=='') ? $item->first_name : ''). (($item->middle_name !=='') ? ' '.$item->middle_name : ''). (($item->third_name !=='') ? ' '.$item->third_name : ''). (($item->surname !=='') ? ' '.$item->surname : '') : 'NA' ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->designation) ? $item->designation_name : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->department) ? $item->department_name : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->network_name) ? $item->network_name : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:6%"><?php echo (($item->is_gps_sim == 'on') ? 'Yes' : 'No') .'<br>'. (($item->gps_installed_vehicle !== '') ? vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_no .' '. vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_type : ''); ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->mobile) ? $item->mobile : 'NA'; ?></td>
							<!-- <td valign="top" height="20px" style="text-align: right;"><?php //echo !empty($item->previous_bal) ? number_format(bcdiv($item->previous_bal,1,2), 2, '.', ',') : 'N/A'; ?></td> -->
							<td valign="top" height="20px" style="text-align: right;width:8%"><?php echo !empty($item->fee) ? number_format(bcdiv($item->fee,1,2), 2, '.', ',') : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: right;width:10%"><?php echo !empty($item->off_plan) ? number_format(bcdiv($item->off_plan,1,2), 2, '.', ',') : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: right;width:5%"><?php echo !empty($tax) ? number_format(bcdiv($tax,1,2), 2, '.', ',') : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: right;width:10%"><strong><?php echo isset($final_amt) ? number_format(bcdiv($final_amt,1,2), 2, '.', ',') : '0.00';?></strong></td>
						</tr>
					<?php $grand_total += $final_amt; $i++;} ?>
					<tr>
						<td colspan="8" align="left" style="border-top:1px solid #000;">Total (SAR)</td>
						<td align="right" style="border-top:1px solid #000;"><?= number_format(bcdiv($total_monthly_fees,1,2), 2, '.', ',');?></td>
						<td align="right" style="border-top:1px solid #000;"><?= number_format(bcdiv($total_plan_charge,1,2), 2, '.', ',');?></td>
						<td align="right" style="border-top:1px solid #000;"><?= number_format(bcdiv($total_vat,1,2), 2, '.', ',');?></td>
						<td align="right" style="border-top:1px solid #000;"><?php echo number_format(bcdiv($grand_total,1,2), 2, '.', ',');?></td>
					</tr>
						<!-- <tr><td colspan="5" height="1px" style="border-bottom:1px solid #000;margin:0px"></td></tr> -->
						
				</table>
			</td>
		</tr>
		
		<!--
		<tr>
			<td colspan="8" style="padding-top:20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 10px;margin-top:25px;border-bottom:1px solid #000;">
					<tr>
						<td colspan="6" valign="top" height="20px" style="text-align: right;">Total (Inc VAT 15%):</td>
						<td valign="top" height="20px" style="text-align: right;"><strong>SAR <?php //echo number_format(bcdiv($grand_total,1,2), 2, '.', ',');?></strong></td>
					</tr>
				</table>
			</td>
		</tr>
		-->
	</table>

</body>

</html>
