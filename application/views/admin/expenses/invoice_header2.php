<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td colspan="3"><img src="build/images/expenses/header-top.jpg" style="max-width: 100%;" /></td>
	</tr>
	<tr>
		<td align="left" valign="top" style="width: 40%;">
			<strong>SUPPLIER DETAILS</strong><br/>
			<strong>Supplier Name:</strong> <?php echo $supplier_name; ?> (<?php echo $supplier_arabic_name; ?>)<br />
			<strong>CR No.:</strong> <?php echo $cr_no; ?><br />
			<strong>Supplier VAT No:</strong> <?php echo $supplier_vat_no; ?>
		</td>
		<td valign="top" style="width: 60%; float: right;text-align: right;">
			<strong>Batch No. :</strong> <?php echo $id; ?><br/>
			<strong>Branch Code :</strong> <?php echo $branch_code; ?><br/>
			<strong>Invoice Date :</strong> <?php echo date("d-m-Y", strtotime($date)); ?><br/>
			<strong>Invoice No.:</strong> <?php echo $invoice_number; ?>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>
</table>