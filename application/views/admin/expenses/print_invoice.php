<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Expenses Invoice</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
	<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
		<tr>
			<td colspan="3"><img src="build/images/expenses/header-top.jpg" style="max-width: 100%;" /></td>
		</tr>
		<tr>
			<td align="left" valign="top" style="width: 40%;">
				<strong>SUPPLIER DETAILS</strong><br/>
				<strong>Supplier Name:</strong> <?php echo $supplier_name; ?> <?php echo $supplier_arabic_name; ?><br />
				<strong>CR No.:</strong> <?php echo $cr_no; ?><br />
				<strong>Supplier VAT No:</strong> <?php echo $supplier_vat_no; ?>
			</td>
			<td valign="top" style="width: 60%; float: right;text-align: right;">
				<strong>Batch No. :</strong> #<?php echo $id; ?><br/>
				<strong>Branch Code :</strong> <?php echo $branch_code; ?><br/>
				<strong>Invoice Date :</strong> <?php echo date("d-m-Y", strtotime($date)); ?><br/>
				<strong>Invoice No.:</strong> <?php echo $invoice_number; ?>
			</td>
		</tr>
		<tr><td colspan="2"></td></tr>
	</table>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#CCCCCC" style="width: 6%;"><strong>S. No.</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 50%;"><strong>ITEM DESCRIPTION</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 20%;text-align:right"><strong>AMT WITHOUT VAT (SAR)</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 12%;text-align:right"><strong>TAX (SAR)</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 12%;text-align:right"><strong>TOTAL (SAR)</strong></td>
					</tr>
					
					<tr>
						<td valign="top" style="text-align: center;">1.</td>
						<td valign="top"><?php echo $item_description;?></td>
						<td valign="top" style="text-align: right;"><?php echo $amt_bef_vat;?></td>
						<td valign="top" style="text-align: right;"><?php echo $tax;?></td>
						<td valign="top" align="right"><?php echo $total;?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>