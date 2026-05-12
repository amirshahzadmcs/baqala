<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Cash Collection Report</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:33%;text-align: left;font-size: 16px;line-height:15px;">
				<strong>CASH COLLECTION REPORT</strong><br><strong> تقرير تحصيل النقدية </strong>
			</td>
			<td valign="center" style="width:67%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
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
			<td colspan="4" valign="center" style="text-align: right;border-bottom:1px solid #000;"><strong>Collection Date: From <?=$start_date;?> To <?=$end_date;?></strong></td>
		</tr>
		<tr style="background-color:#f1f1f1;">
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:4%;line-height:10px;">S.No<br>فرز</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:8%;line-height:10px;">Emp. ID<br>اسم الموظف</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:34%;line-height:10px;">Employee Name<br>رقم الإقامة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:9%;line-height:10px;">Aggregator ID<br>معرف المجمع</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:9%;line-height:10px;">COD Amnt.<br>رقم الوثيقة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:9%;line-height:10px;">Driver Debit<br>خصم السائق</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:9%;line-height:10px;">Driver Credit<br>إئتمان السائق</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:9%;line-height:10px;">Collection<br>تحصيل</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:9%;line-height:10px;">Outstanding Bal.<br>التوقيع</td>
		</tr>
        <?php 
		$total_due = 0;
		$total_debit = 0;
		$total_credit = 0;
		$total_paid = 0;
		$total_balance = 0;
        if(count($cash_reports) > 0){
        $count = 1;
        foreach ($cash_reports as $key => $value) { 
			$due = is_numeric($value['total_due']) ? (float)$value['total_due'] : 0;
			$debit = is_numeric($value['driver_debit']) ? (float)$value['driver_debit'] : 0;
			$credit = is_numeric($value['driver_credit']) ? (float)$value['driver_credit'] : 0;
            $paid = is_numeric($value['total_paid']) ? (float)$value['total_paid'] : 0;
            $balance = is_numeric($value['total_balance']) ? (float)$value['total_balance'] : 0;

            $total_due += $due;
			$total_debit += $debit;
            $total_credit += $credit;
            $total_paid += $paid;
            $total_balance += $balance;
        ?>
        <tr>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo $count++;?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['emp_no']) !== '') ? trim($value['emp_no']) : 'NA';?></td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['full_name']) !== '') ? trim($value['full_name']) : 'NA';?></td>
			<td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['driver_id']) !== '') ? trim($value['driver_id']) : 'NA';?></td>
			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($due, 2);?></td>
			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($debit, 2);?></td>
			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($credit, 2);?></td>
			<td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($paid, 2);?></td>
			<td align="right" style="border-bottom:1px solid #000;"><?= number_format($balance, 2);?></td>
			<td style="border-bottom:1px solid #000;"></td>
        </tr>
        <?php } ?>
		<!-- Total Row -->
		<tr style="background-color:#eaeaea;font-weight:bold;">
			<td colspan="4" align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;">Total</td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_due, 2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_debit, 2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_credit, 2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_paid, 2); ?></td>
			<td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;"><?= number_format($total_balance, 2); ?></td>
		</tr>
	<?php }else{ ?>
            <td colspan="7" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
        <?php } ?>
	</table>

    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
		<tr>
			<td align="center" valign="center">I acknowledge the receipt and ensure to take complete responsibility for the cash accepted.</td>
		</tr>
	</table>

	<table cellspacing="2" cellpadding="5" style="width: 100%;font-size: 12px;border-top:1px solid #000;border-bottom:1px solid #000;">
        <tr><td></td></tr>
        <tr><td></td></tr>
		<tr>
            <td>
                <table cellspacing="0" cellpadding="5" style="width: 100%;font-size: 12px;">
                    <tr>
                        <td align="center" style="line-height:10px;">Cash Receiver's Signature</td>
                        <td align="center" style="line-height:10px;">Finance Department<br>(Cash Accepted Signature)</td>
                    </tr>
                </table>
            </td>
        </tr>
	</table>

</body>

</html>
