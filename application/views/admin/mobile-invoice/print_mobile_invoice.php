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
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;margin-top:25px;">
					<!-- <tr>
						<td valign="top" height="20px" colspan="2" style="background-color: #000;color:#fff;"><strong>Billing details for month - <?php echo $period; ?></strong></td>
					</tr> -->
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Invoice Number:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($invoice_no) ? $invoice_no : 'N/A';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">User:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($username) ? $username : 'N/A';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Sim Number:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($sim_no) ? $sim_no : 'N/A';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Period:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($period) ? date('M Y', strtotime($period)) : 'N/A';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Previous Balance:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($previous_bal) ? $previous_bal : '0.00';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Monthly Fees:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($fee) ? $fee : '0.00';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Off Plan:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($off_plan) ? $off_plan : '0.00';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Add On:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($add_on) ? $add_on : '0.00';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Adjustment:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($adjustment) ? $adjustment : '0.00';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Discount:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($discount) ? $discount : '0.00';?></strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Installment:</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($installment) ? $installment : '0.00';?></strong></td>
					</tr>
					<?php
						$pre_bal = $previous_bal;
						$total = ($fee + $off_plan + $add_on) - ($adjustment + $discount);
						$final_amt = $total + (($total * 15) / 100) + $pre_bal;
					?>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Total (Inc VAT 15%):</td>
						<td valign="top" height="20px" style="text-align: left;"><strong><?php echo isset($final_amt) ? bcdiv($final_amt,1,2) : '0.00';?></strong></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
