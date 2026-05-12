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
			<td valign="top" style="width:23%;text-align: left;font-size: 16px;line-height:15px;">
				<strong>CASH COLLECTION REPORT</strong><br><strong> تقرير تحصيل النقدية </strong>
			</td>
			<td valign="center" style="width:77%;">
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
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:3%;line-height:10px;">S.No<br>فرز</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:4%;line-height:10px;">Emp. ID<br>اسم الموظف</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;line-height:10px;">Employee Name<br>رقم الإقامة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Driver ID<br>معرف السائق</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">Date<br>التاريخ</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Delivery Price<br>سعر التوصيل</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Cash Collection<br>تحصيل النقدية</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Driver Credit<br>إئتمان السائق</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Driver Debit<br>خصم السائق</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Bonuses<br>المكافآت</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:4%;line-height:10px;">Tips<br>البقشيش</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:4%;line-height:10px;">Penalty<br>الغرامة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Service Deduction<br>خصم الخدمة</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Total Amount<br>إجمالي المبلغ</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">Collected Date<br>تاريخ التحصيل</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:5%;line-height:10px;">Collected Amount<br>المبلغ المحصل</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">Outstanding Bal.<br>التوقيع</td>
			<td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:5%;line-height:10px;">Collected By<br> بواسطة </td>
		</tr>
        <?php 
        $total_delivery_price = 0;
        $total_cash_collection = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_bonuses = 0;
        $total_tips = 0;
        $total_penalty = 0;
        $total_service_deduction = 0;
        $total_amount = 0;
        $total_paid = 0;
        $total_balance = 0;

        if(count($cash_reports) > 0){
            $count = 1;
            foreach ($cash_reports as $key => $value) { 
                $delivery_price = is_numeric($value['delivery_price']) ? (float)$value['delivery_price'] : 0;
                $cash_collection = is_numeric($value['cash_collection']) ? (float)$value['cash_collection'] : 0;
                $credit = is_numeric($value['driver_credit']) ? (float)$value['driver_credit'] : 0;
                $debit = is_numeric($value['driver_debit']) ? (float)$value['driver_debit'] : 0;
                $bonuses = is_numeric($value['bonuses']) ? (float)$value['bonuses'] : 0;
                $tips = is_numeric($value['tips']) ? (float)$value['tips'] : 0;
                $penalty = is_numeric($value['penalty']) ? (float)$value['penalty'] : 0;
                $service_deduction = is_numeric($value['service_deduction']) ? (float)$value['service_deduction'] : 0;
                $total_amount_val = is_numeric($value['total_amount']) ? (float)$value['total_amount'] : 0;
                $paid = is_numeric($value['paid_amount']) ? (float)$value['paid_amount'] : 0;
                $balance = is_numeric($value['balance_amount']) ? (float)$value['balance_amount'] : 0;

                // Add to totals
                $total_delivery_price += $delivery_price;
                $total_cash_collection += $cash_collection;
                $total_credit += $credit;
                $total_debit += $debit;
                $total_bonuses += $bonuses;
                $total_tips += $tips;
                $total_penalty += $penalty;
                $total_service_deduction += $service_deduction;
                $total_amount += $total_amount_val;
                $total_paid += $paid;
                $total_balance += $balance;
        ?>
        <tr>
            <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo $count++;?></td>
            <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['emp_no']) !== '') ? trim($value['emp_no']) : 'NA';?></td>
            <td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['full_name']) !== '') ? trim($value['full_name']) : 'NA';?></td>
            <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['driver_id']) !== '') ? trim($value['driver_id']) : 'NA';?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['summary_date']) !== '') ? date('d-m-Y', strtotime($value['summary_date'])) : 'NA';?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($delivery_price, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($cash_collection, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($credit, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($debit, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($bonuses, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($tips, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($penalty, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($service_deduction, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($total_amount_val, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['transaction_date']) !== '') ? date('d-m-Y', strtotime($value['transaction_date'])) : 'NA';?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($paid, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($balance, 2);?></td>
            <td align="right" style="border-bottom:1px solid #000;"><?= (trim($value['added_by_username']) !== '') ? ucfirst($value['added_by_username']) : 'NA';?></td>
            <td style="border-bottom:1px solid #000;"></td>
        </tr>
        <?php } ?>

        <!-- ✅ TOTAL ROW AT BOTTOM -->
        <tr style="background-color:#eaeaea;font-weight:bold;">
            <td colspan="5" align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;">Total</td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_delivery_price, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_cash_collection, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_credit, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_debit, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_bonuses, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_tips, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_penalty, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_service_deduction, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_amount, 2); ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;">-</td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_paid, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_balance, 2); ?></td>
            <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;">-</td>
        </tr>
        <?php } else { ?>
            <td colspan="18" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
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
