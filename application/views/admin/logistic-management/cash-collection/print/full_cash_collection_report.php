<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Full Cash Collection Report</title>
	<style>
		*{padding:0px;margin:0px;}
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
</head>
<body>

	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;">
				<img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px">
			</td>
		</tr>
		<tr>
			<td valign="top" style="width:40%;text-align: left;font-size: 16px;line-height:15px;">
				<strong>FULL CASH COLLECTION REPORT</strong><br><strong> تقرير تحصيل النقدية الكامل </strong>
			</td>
			<td valign="center" style="width:60%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr><td style="border-bottom:1px solid #ddd;"></td></tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;"><strong>DATE / تاريخ :</strong> <?= ($print_date) ? $print_date : 'NA';?></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>CASH COLLECTION DETAILS / تفاصيل تحصيل النقدية</strong></td>
			<td colspan="4" valign="center" style="text-align: right;border-bottom:1px solid #000;">
				<strong>Collection Date: From <?=$start_date;?> To <?=$end_date;?></strong>
			</td>
		</tr>

		<tr style="background-color:#f1f1f1;">
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:4%;">S.No</td>
			<td align="center" style="border:1px solid #000;width:7%;">Emp. ID</td>
			<td align="center" style="border:1px solid #000;width:29%;">Employee Name</td>
			<td align="center" style="border:1px solid #000;width:8%;">Aggregator ID</td>
			<td align="center" style="border:1px solid #000;width:7%;">Deliveries</td>

			<td align="center" style="border:1px solid #000;width:8%;">Delivery Price</td>
			<td align="center" style="border:1px solid #000;width:7%;">COD Amnt.</td>

			<td align="center" style="border:1px solid #000;width:7%;">Driver Debit</td>
			<td align="center" style="border:1px solid #000;width:7%;">Driver Credit</td>

			<td align="center" style="border:1px solid #000;width:8%;">Collection</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:8%;">Outstanding Bal.</td>
		</tr>

        <?php 
		$total_delivery = 0;
		$total_cod = 0;
		$total_debit = 0;
		$total_credit = 0;
		$total_collection = 0;
		$total_balance = 0;
		$total_os_balance = 0;
		$total_orders = 0;

        if(count($cash_reports) > 0){
        $count = 1;
        foreach ($cash_reports as $value) {

			$delivery_price = (float)$value['total_delivery_price'];
			$cod_amount = (float)$value['total_cash_collection'];
			$driver_debit = (float)$value['total_driver_debit'];
			$driver_credit = (float)$value['total_driver_credit'];
			$collection = (float)$value['total_paid'];
			$balance = (float)$value['total_balance'];
			$orders = $value['total_orders'];
			$os_balance = $cod_amount - $driver_credit - $collection;

			$total_delivery += $delivery_price;
			$total_cod += $cod_amount;
			$total_debit += $driver_debit;
			$total_credit += $driver_credit;
			$total_collection += $collection;
			$total_balance += $balance;
			$total_os_balance += $os_balance;
			$total_orders += $orders;
        ?>
        <tr>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= $count++; ?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= $value['emp_no']; ?></td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= $value['full_name']; ?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= $value['driver_id']; ?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= $orders; ?></td>

			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($delivery_price,2); ?></td>
			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($cod_amount,2); ?></td>

			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($driver_debit,2); ?></td>
			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($driver_credit,2); ?></td>

			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($collection,2); ?></td>
			<td align="right" style="border-bottom:1px solid #000;"><?= number_format($os_balance,2); ?></td>
        </tr>
        <?php } ?>

		<!-- Total Row -->
		<tr style="background-color:#eaeaea;font-weight:bold;">
			<td colspan="4" align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;">Total</td>

			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= $total_orders; ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_delivery,2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_cod,2); ?></td>

			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_debit,2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_credit,2); ?></td>

			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_collection,2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;"><?= number_format($total_os_balance,2); ?></td>
		</tr>

	<?php } else { ?>
		<tr><td colspan="11" align="center" style="border-bottom:1px solid #ddd;">No Data Found</td></tr>
	<?php } ?>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;margin-top:20px;">
		<tr>
			<td align="center">I acknowledge the receipt and ensure to take complete responsibility for the cash accepted.</td>
		</tr>
	</table>

	<table cellspacing="2" cellpadding="5" style="width: 100%;font-size: 12px;border-top:1px solid #000;border-bottom:1px solid #000;">
        <tr><td><br><br></td></tr>

		<tr>
			<td>
				<table cellspacing="0" cellpadding="5" style="width: 100%;font-size: 12px;">
					<tr>
						<td align="center">Cash Receiver's Signature</td>
						<td align="center">Finance Department<br>(Cash Accepted Signature)</td>
					</tr>
				</table>
			</td>
        </tr>
	</table>

</body>
</html>
