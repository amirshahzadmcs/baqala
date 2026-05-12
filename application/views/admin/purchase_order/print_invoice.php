<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Purchase Invoice</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 95%;">
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#c6efce" style="width: 6%; text-align: center;"><strong>Sr. No</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 15%; text-align: center;"><strong>Barcode/SKU</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 51%; text-align: center;"><strong>Item Description</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Price</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Qty</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Line Total</strong></td>
					</tr>
					<?php $item_row = 1;foreach($products as $product){ ?>
					<tr>
						<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
						<td valign="top" style="text-align: center;"><?php echo ($product->barcode !== '') ? $product->barcode : strtoupper($product->item_sku);?></td>
						<td valign="top">
							<?php echo $product->item_description; ?>
						</td>
						<td valign="top" style="text-align: right;"><?php echo $product->unit_price;?></td>
						<td valign="top" style="text-align: center;"><?php echo $product->item_unit;?></td>
						<td valign="top" style="text-align: right;"><?php echo $product->item_total;?></td>
					</tr>
					<?php $item_row = $item_row + 1;}?>
				</table>
			</td>
		</tr>
		
	</table>

</body>

</html>
