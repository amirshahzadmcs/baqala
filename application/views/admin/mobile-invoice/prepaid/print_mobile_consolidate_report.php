<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Prepaid Mobile Invoice</title>
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
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%">Employee UID</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:20%">Employee Name</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Designation</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Department</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Network</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Mobile No</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:8%">Source</td>
						<td valign="top" height="20px" style="text-align: center;border-bottom:1px solid #000;width:8%">Date</td>
						<td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;width:7%">VAT (15%)</td>
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
						$total_vat = 0; 
						$total_amount = 0; 
						foreach($invoice as $item) { ?>
						<?php
							$total_vat += $item->vat_percent; 
							$total_amount += $item->total_amount; 
						?>
						<tr>
							<td valign="top" height="20px" style="text-align: left;width:5%"><?php echo $i; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:10%"><?php echo ($item->emp_no != '' && $item->alloted_user > 0) ? $item->emp_no : 'NA' ?></td>
							<td valign="top" height="20px" style="text-align: left;width:20%"><?php echo ($item->alloted_user != '' && $item->alloted_user > 0) ? (($item->first_name !=='') ? $item->first_name : ''). (($item->middle_name !=='') ? ' '.$item->middle_name : ''). (($item->third_name !=='') ? ' '.$item->third_name : ''). (($item->surname !=='') ? ' '.$item->surname : '') : 'NA' ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->designation) ? $item->designation_name : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->department) ? $item->department_name : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->network_name) ? $item->network_name : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->mobile) ? $item->mobile : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: left;width:8%"><?php echo !empty($item->payment_source) ? $item->payment_source : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: center;width:8%"><?php echo !empty($item->recharge_date) ? date('d-m-Y', strtotime($item->recharge_date)) : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: right;width:7%"><?php echo !empty($item->vat_percent) ? number_format(bcdiv($item->vat_percent,1,2), 2, '.', ',') : 'NA'; ?></td>
							<td valign="top" height="20px" style="text-align: right;width:10%"><strong><?php echo isset($item->total_amount) ? number_format(bcdiv($item->total_amount,1,2), 2, '.', ',') : '0.00';?></strong></td>
						</tr>
					<?php $i++;} ?>
					<tr>
						<td colspan="9" align="left" style="border-top:1px solid #000;">Total (SAR)</td>
						<td align="right" style="border-top:1px solid #000;"><?= number_format(bcdiv($total_vat,1,2), 2, '.', ',');?></td>
						<td align="right" style="border-top:1px solid #000;"><?= number_format(bcdiv($total_amount,1,2), 2, '.', ',');?></td>
					</tr>
				</table>
			</td>
		</tr>
		
	</table>

</body>

</html>
