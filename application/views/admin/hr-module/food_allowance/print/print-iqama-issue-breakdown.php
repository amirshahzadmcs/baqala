<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Iqama Issue Cost Breakdown</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;}
	table td {word-wrap:break-word;}
	.checkbox-text {
		font-size: 16px;
		line-height: 5px;
		vertical-align: bottom;
	}
	</style>
</head>
<body>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr>
			<td align="left">
				<h2>NEW IQAMA ISSUE COST BREAKDOWN</h2>
			</td>
		</tr>
		<tr>
			<td align="left">
				<p style="font-size:10px;"><strong>Batch No: <?php echo $batch_list['batch_no'];?></strong></p>
			</td>
		</tr>
		<tr><td style="border-bottom: 1px solid #ddd;"></td></tr>
	</table>
	
	<table border="1" cellpadding="4" cellspacing="0" style="width: 100%;font-size:8px;">
		<tr>
			<td style="width: 5%;background-color:#000;color:#fff;text-align:center;"><strong>S.No.</strong></td>
			<td style="width: 10%;background-color:#000;color:#fff;text-align:center;"><strong>Border No.</strong></td>
			<td style="width: 10%;background-color:#000;color:#fff;text-align:center;"><strong>Visa No.</strong></td>
			<td style="width: 25%;background-color:#000;color:#fff;text-align:center;"><strong>Employee Name</strong></td>
			<td style="width: 13%;background-color:#000;color:#fff;text-align:center;"><strong>Designation</strong></td>
			<td style="width: 8%;background-color:#000;color:#fff;text-align:center;"><strong>Duration</strong></td>
			<td style="width: 9%;background-color:#000;color:#fff;text-align:center;"><strong>MOL</strong></td>
			<td style="width: 10%;background-color:#000;color:#fff;text-align:center;"><strong>Jawazzat</strong></td>
			<td style="width: 10%;background-color:#000;color:#fff;text-align:center;"><strong>Total Cost</strong></td>
		</tr>
		<?php 
			if(count($batch_detail) > 0){ 
			$count = 1;
			$total_mol = 0;
			$total_jawazzat = 0;
			$grand_total_payment = 0;
			foreach ($batch_detail as $key => $value) {
			$mol = 2425;
            $jawazzat = 163;
            $total_payment = $mol + $jawazzat;
			$duration = "3 Months";

			// Add to running totals
			$total_mol += $mol;
			$total_jawazzat += $jawazzat;
			$grand_total_payment += $total_payment;
		?>
			<tr>
				<td align="center"><?php echo $count++;?>.</td>
				<td align="center"><?php echo $value['border_entry_no'];?></td>
				<td align="center"><?php echo $value['visa_no'];?></td>
				<td><?php echo implode(' ', array_filter([$value['first_name'], $value['middle_name'], $value['third_name'], $value['surname']])); ?></td>
				<td align="center"><?php echo $value['applied_for_job'];?></td>
				<td align="center"><?php echo $duration;?></td>
				<td align="center"><?php echo number_format($mol, 2);?></td>
				<td align="center"><?php echo number_format($jawazzat, 2);?></td>
				<!-- Total Payment -->
				<td align="center"><?php echo $total_payment ? number_format($total_payment, 2) : '-'; ?></td>
			</tr>
		<?php 
			}
		?>
		<!-- Totals Row -->
		<tr style="background-color: #f0f0f0;">
			<td colspan="6" align="right"><strong>Total:</strong></td>
			<td align="center"><strong><?php echo number_format($total_mol, 2);?></strong></td>
			<td align="center"><strong><?php echo number_format($total_jawazzat, 2);?></strong></td>
			<td align="center"><strong><?php echo number_format($grand_total_payment, 2);?></strong></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td colspan="9" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</table>
</body>

</html>
