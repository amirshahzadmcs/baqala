<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Purchase Vat Report</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="3">
				<table class="table" width="100%" border="0" cellspacing="0" cellpadding="6" style="font-size: 12px;">
					<tr>
						<td valign="top" style="width: 10%;text-align:right;border-bottom:1px solid #000"><strong>Before VAT<br>Value</strong></td>
						<td valign="top" style="width: 6%;text-align:right;border-bottom:1px solid #000"><strong>QTY</strong></td>
						<td valign="top" style="width: 14%;border-bottom:1px solid #000"><strong>Supplier VAT No.</strong></td>
						<td valign="top" style="width: 27%;border-bottom:1px solid #000"><strong>Supplier Name</strong></td>
						<td valign="top" style="width: 9%;text-align:right;border-bottom:1px solid #000"><strong>After VAT<br>Value</strong></td>
						<td valign="top" style="width: 7%;border-bottom:1px solid #000"><strong>GRV #</strong></td>
						<td valign="top" style="width: 10%;border-bottom:1px solid #000"><strong>Sup Inv #</strong></td>
						<td valign="top" style="width: 6%;text-align:right;border-bottom:1px solid #000"><strong>VAT<br>Value</strong></td>
						<td valign="top" style="width: 10%;border-bottom:1px solid #000"><strong>Date</strong></td>
					</tr>
					<?php
						$sumSubTotal = 0;
						$sumAfterVat = 0;
						$sumVatValue = 0;
					?>
					<?php foreach($results as $report){
						$afterVat = $report->sub_total + $report->sale_tax_amt;
						$sumSubTotal += $report->sub_total;
						$sumAfterVat += $afterVat;
						$sumVatValue += $report->sale_tax_amt;
					?>
					<tr class="item-list">
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo $report->sub_total;?></td>
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo $report->total_qty;?></td>
						<td valign="top" style="border-bottom:1px dotted #000"><?php echo $report->vat_no;?></td>
						<td valign="top" style="border-bottom:1px dotted #000">00<?php echo $report->vendor_id;?> &nbsp;&nbsp;<?php echo $report->vendor_name;?></td>
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo number_format($afterVat, 2);?></td>
						<td valign="top" style="border-bottom:1px dotted #000"><?php echo $report->grv_no;?></td>
						<td valign="top" style="border-bottom:1px dotted #000"><?php echo $report->sup_invoice_no;?></td>
						<td valign="top" style="text-align:right;border-bottom:1px dotted #000"><?php echo $report->sale_tax_amt;?></td>
						<td valign="top" style="border-bottom:1px dotted #000"><?php echo date("d-M-Y", strtotime($report->invoice_date));?></td>
					</tr>
					<?php } ?>
					<tr><td colspan="9"></td></tr>
					<tr>
						<td valign="top" style="text-align:right;border-top: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($sumSubTotal, 2);?></td>
						<td valign="top"></td>
						<td valign="top"></td>
						<td valign="top"></td>
						<td valign="top" style="text-align:right;border-top: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($sumAfterVat, 2);?></td>
						<td valign="top"></td>
						<td valign="top"></td>
						<td valign="top" style="text-align:right;border-top: 1px solid #000;border-bottom: 1px solid #000;"><?php echo number_format($sumVatValue, 2);?></td>
						<td valign="top"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>