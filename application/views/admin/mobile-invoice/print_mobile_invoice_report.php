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
			<td colspan="3" style="padding-top:20px;">
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 8px;margin-top:25px;border-bottom:1px solid #000;">
					<!-- <tr>
						<td valign="top" height="20px" colspan="2" style="background-color: #000;color:#fff;"><strong>Billing details for month - <?php echo $period; ?></strong></td>
					</tr> -->
					<tr>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:5%;font-size: 10px;">S.No.</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Invoice Number</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Mobile Number</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:10%;font-size: 10px;">Bill Period</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:12%;font-size: 10px;">Sim Network</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:6%;font-size: 10px;">Is GPS</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:13%;font-size: 10px;">Sim Plan</td>
						<td valign="top" height="20px" style="text-align: left;border-bottom:1px solid #000;width:20%;font-size: 10px;">User</td>
						<td valign="top" height="20px" style="text-align: right;border-bottom:1px solid #000;width:13%;font-size: 10px;"><strong>Total Amount (Inc. 15% VAT)</strong></td>
					</tr>
					<?php $sum_total = 0; $i=1;foreach($invoice as $item) { ?>
						<?php
							$pre_bal = $item->previous_bal;
							$total = ($item->fee + $item->off_plan + $item->add_on) - ($item->adjustment + $item->discount);
							$final_amt = $total + (($total * 15) / 100) + $pre_bal;
							$sum_total += $final_amt;
						?>
						<tr>
							<td valign="top" height="20px" style="text-align: left;"><?php echo $i++; ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo !empty($item->invoice_no) ? $item->invoice_no : 'N/A'; ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo !empty($item->mobile) ? $item->mobile : 'N/A'; ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo !empty($item->period) ? date('M, Y', strtotime($item->period)) : 'N/A'; ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo !empty($item->network_name) ? $item->network_name : 'N/A'; ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo (($item->is_gps_sim == 'on') ? 'Yes' : 'No') .'<br>'. (($item->gps_installed_vehicle !== '') ? vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_no .' '. vehicleDetailHelper($item->gps_installed_vehicle)->vehicle_type : ''); ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo !empty($item->plan_name) ? $item->plan_name : 'N/A'; ?></td>
							<td valign="top" height="20px" style="text-align: left;"><?php echo !empty($item->first_name) ? (($item->first_name !=='') ? $item->first_name : ''). (($item->middle_name !=='') ? ' '.$item->middle_name : ''). (($item->third_name !=='') ? ' '.$item->third_name : ''). (($item->surname !=='') ? ' '.$item->surname : '') : 'N/A'; ?></td>
							<td valign="top" height="20px" style="text-align: right;"><strong><?php echo isset($final_amt) ? bcdiv($final_amt,1,2) : '0.00';?></strong></td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="9" style="border-bottom:1px solid #000;"></td>
					</tr>
					<tr>
						<td valign="top" colspan="8" height="20px" style="text-align: left;"><b>Total (Inc VAT 15%):</b></td>
						<td valign="top" height="20px" style="text-align: right;"><b><?php echo bcdiv($sum_total,1,2);?></b></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
