<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - VAT Summary (SA - SR) Customer Wise</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2">
				<table class="table" width="100%" border="0" cellspacing="0" cellpadding="6" style="font-size: 12px;">
					<tr>
						<td valign="top" style="width: 10%;text-align:left;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Sale<br>Type</strong></td>
						<td valign="top" style="width: 14%;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Customer VAT No.</strong></td>
						<td valign="top" style="width: 30%;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Customer Name</strong></td>
						<td valign="top" style="width: 6%;text-align:right;border-bottom:2px solid #000;border-top:2px solid #000"><strong>VAT<br>Value</strong></td>
						<td valign="top" style="width: 10%;text-align:right;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Inv. Value<br>After VAT</strong></td>
						<td valign="top" style="width: 10%;text-align:right;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Inv. Value<br>Before VAT</strong></td>
						<td valign="top" style="width: 10%;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Date</strong></td>
						<td valign="top" style="width: 10%;border-bottom:2px solid #000;border-top:2px solid #000"><strong>Inv. #</strong></td>
					</tr>
					<tr><td colspan="9" style="line-height:0px;"></td></tr>
					<tr>
						<td colspan="3" valign="top" style="text-align:left;border-top: 1px solid #000;border-bottom: 1px solid #000;">Sales</td>
						<td colspan="5" valign="top"></td>
					</tr>
					<?php
						$sumBeforeVat = 0;
						$sumAfterVat = 0;
						$sumVatValue = 0;
					?>
					<?php foreach($reports as $report){
						$vatValue = $report->item_total_price - $report->total_vat;
						$sumBeforeVat += $report->total_vat;
						$sumAfterVat += $report->item_total_price;
						$sumVatValue += $vatValue;
						$payment_method = $report->payment_method;
						if($payment_method == 'Credit Wallet' || $payment_method == 'Credit'){
							$payment_method = 'Credit';
						}else{
							$payment_method = 'Cash';
						}
					?>
					<tr class="item-list">
						<td valign="top" style="text-align:left;border-bottom:1px dotted #000"><?php echo $payment_method;?></td>
						<td valign="top" style="border-bottom:1px dotted #000"><?php echo $report->c_vat;?></td>
						<td valign="top">00<?php echo $report->customer_id;?> &nbsp;&nbsp;<?php echo $report->c_role == 1 ? $report->name : $report->c_company;?></td>
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo number_format($vatValue, 2);?></td>
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo number_format($report->item_total_price, 2);?></td>
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo number_format($report->total_vat, 2);?></td>
						<td valign="top" style="border-bottom:1px dotted #000"><?php echo date("d-M-Y", strtotime($report->date_modified));?></td>
						<td valign="top" style="text-align:left;border-bottom:1px dotted #000"><?php echo $report->invoice_prefix .'-'. $report->id;?></td>
					</tr>
					<?php } ?>
					<tr><td colspan="9"></td></tr>
					<tr>
						<td valign="top"></td>
						<td valign="top"></td>
						<td valign="top"></td>
						<td valign="top" style="text-align:right;"><p style="border-top: 2px solid #000;border-bottom: 2px solid #000;"><?php echo number_format($sumVatValue, 2);?></p></td>
						<td valign="top" style="text-align:right;"><p style="border-top: 2px solid #000;border-bottom: 2px solid #000;"><?php echo number_format($sumAfterVat, 2);?></p></td>
						<td valign="top" style="text-align:right;"><p style="border-top: 2px solid #000;border-bottom: 2px solid #000;"><?php echo number_format($sumBeforeVat, 2);?></p></td>
						<td valign="top"></td>
						<td valign="top"></td>
						<td valign="top"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>