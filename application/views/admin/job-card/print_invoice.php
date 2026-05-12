<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Job Card</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
		<tr>
			<td style="width: 5%;"></td>
			<td colspan="3" style="width: 90%;">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#c6efce" style="width: 6%; text-align: center;"><strong>Sr. No</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 15%; text-align: center;"><strong>Item Code</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 51%; text-align: center;"><strong>Spare Part Name</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Price</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Qty</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Line Total</strong></td>
					</tr>
					<?php $item_row = 1;foreach($items as $product){ ?>
					<tr>
						<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
						<td valign="top" style="text-align: center;"><?php echo strtoupper($product->item_code);?></td>
						<td valign="top">
						<?php echo $product->spare_part_name;?> - <?php echo $product->spare_part_name_ar;?>
						</td>
						<td valign="top" style="text-align: right;"><?php echo $product->cost;?></td>
						<td valign="top" style="text-align: center;"><?php echo $product->qty;?></td>
						<td valign="top" style="text-align: right;"><?php echo $product->line_amount;?></td>
					</tr>
					<?php $item_row = $item_row + 1;}?>
				</table>
			</td>
			<td style="width: 5%;"></td>
		</tr>
		
	</table>

</body>

</html>
