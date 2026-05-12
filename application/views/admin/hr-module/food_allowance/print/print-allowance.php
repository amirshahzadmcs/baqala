<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Food Allowance Distribution</title>
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
				<h2>FOOD ALLOWANCE DISTRIBUTION LIST</h2>
			</td>
		</tr>
		<tr>
			<td align="left">
				<p style="font-size:10px;"><strong>Batch No: <?php echo $batch_list['batch_no'];?></strong></p>
			</td>
		</tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 17%;"><strong>Arrival Date</strong></td>
			<td style="width: 21%;"><?php echo date('d-m-Y', strtotime($batch_list['arrival_date']));?></td>
			<td style="width: 13%;"><strong>Batch No.</strong></td>
			<td style="width: 15%;"><?php echo $batch_list['batch_no'];?></td>
			<td style="width: 13%;"><strong>Total Cv's</strong></td>
			<td style="width: 21%;"><?php echo $batch_list['total_cvs'];?></td>
		</tr>
	</table>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr><td></td></tr>
		<tr><td><u><strong>CV Numbers</strong></u></td></tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="4" cellspacing="0" style="width: 100%;font-size:8px;">
		<tr>
			<td style="width: 3%;background-color:#000;color:#fff;text-align:center;"><strong>#</strong></td>
			<td style="width: 6%;background-color:#000;color:#fff;text-align:center;"><strong>CV No.</strong></td>
			<td style="width: 5%;background-color:#000;color:#fff;text-align:center;"><strong>Country</strong></td>
			<td style="width: 4%;background-color:#000;color:#fff;text-align:center;"><strong>H. Type</strong></td>
			<td style="width: 7%;background-color:#000;color:#fff;text-align:center;"><strong>Aggregator</strong></td>
			<td style="width: 7%;background-color:#000;color:#fff;text-align:center;"><strong>Pos. Applied</strong></td>
			<td style="width: 12%;background-color:#000;color:#fff;text-align:center;"><strong>Full Name</strong></td>
			<td style="width: 6%;background-color:#000;color:#fff;text-align:center;"><strong>Passport No.</strong></td>
			<td style="width: 7%;background-color:#000;color:#fff;text-align:center;"><strong>Salary Package</strong></td>
			<td style="width: 6%;background-color:#000;color:#fff;text-align:center;"><strong>Food Allowance</strong></td>
			<td colspan="2" style="width: 11%;background-color:#000;color:#fff;text-align:center;"><strong>1st Initial Cash Payment</strong></td>
			<td colspan="2" style="width: 11%;background-color:#000;color:#fff;text-align:center;"><strong>2nd Payment</strong></td>
			<td colspan="2" style="width: 11%;background-color:#000;color:#fff;text-align:center;"><strong>3rd Payment</strong></td>
			<td style="width: 4%;background-color:#000;color:#fff;text-align:center;"><strong>Total</strong></td>
		</tr>
		<?php 
			if(count($batch_detail) > 0){ 
			$count = 1;
			$total_first_payment = 0;
			$total_second_payment = 0;
			$total_third_payment = 0;
			$grand_total_payment = 0;
			foreach ($batch_detail as $key => $value) {
			$first_payment = isset($value['first_payment']) ? json_decode($value['first_payment'])->payment_amt : 0;
            $second_payment = isset($value['second_payment']) ? json_decode($value['second_payment'])->payment_amt : 0;
            $third_payment = isset($value['third_payment']) ? json_decode($value['third_payment'])->payment_amt : 0;
            $total_payment = $first_payment + $second_payment + $third_payment;

			// Add to running totals
			$total_first_payment += $first_payment;
			$total_second_payment += $second_payment;
			$total_third_payment += $third_payment;
			$grand_total_payment += $total_payment;
		?>
			<tr>
				<td align="center"><?php echo $count++;?>.</td>
				<td align="center"><?php echo $value['cv_no'];?></td>
				<td align="center"><?php echo $value['country_name'];?></td>
				<td align="center"><?php echo $value['hiring_type'];?></td>
				<td><?php echo $value['project_name'];?></td>
				<td><?php echo $value['applied_for_job'];?></td>
				<td><?php echo implode(' ', array_filter([$value['first_name'], $value['middle_name'], $value['third_name'], $value['surname']])); ?></td>
				<td align="center"><?php echo $value['passport_no'];?></td>
				<td align="center"><?php echo $value['salary_package'];?></td>
				<td align="center"><?php echo $value['food_allowance'];?></td>
				<!-- First Payment -->
				<td align="center"><?php echo isset($value['first_payment']) ? date('d-m-Y', strtotime(json_decode($value['first_payment'])->payment_date)) : '-'; ?></td>
				<td align="center"><?php echo isset($value['first_payment']) ? json_decode($value['first_payment'])->payment_amt : '-'; ?></td>

				<!-- Second Payment -->
				<td align="center"><?php echo isset($value['second_payment']) ? date('d-m-Y', strtotime(json_decode($value['second_payment'])->payment_date)) : '-'; ?></td>
				<td align="center"><?php echo isset($value['second_payment']) ? json_decode($value['second_payment'])->payment_amt : '-'; ?></td>

				<!-- Third Payment -->
				<td align="center"><?php echo isset($value['third_payment']) ? date('d-m-Y', strtotime(json_decode($value['third_payment'])->payment_date)) : '-'; ?></td>
				<td align="center"><?php echo isset($value['third_payment']) ? json_decode($value['third_payment'])->payment_amt : '-'; ?></td>
				<!-- Total Payment -->
				<td align="center"><?php echo $total_payment ? $total_payment : '-'; ?></td>
			</tr>
		<?php 
			}
		?>
		<!-- Totals Row -->
		<tr style="background-color: #f0f0f0;">
			<td colspan="10" align="right"><strong>Total:</strong></td>
			<td colspan="1"></td>
			<td align="center"><strong><?php echo $total_first_payment;?></strong></td>
			<td colspan="1"></td>
			<td align="center"><strong><?php echo $total_second_payment;?></strong></td>
			<td colspan="1"></td>
			<td align="center"><strong><?php echo $total_third_payment;?></strong></td>
			<td align="center"><strong><?php echo $grand_total_payment;?></strong></td>
		</tr>
		<?php }else{ ?>
		<tr>
			<td colspan="16" align="center">Data not available</td>
		</tr>
		<?php } ?>
	</table>
</body>

</html>
