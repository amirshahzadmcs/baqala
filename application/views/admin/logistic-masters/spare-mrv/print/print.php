<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - SP Requisition Master</title>
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
						<td valign="top" bgcolor="#c6efce" style="width: 12%; text-align: center;"><strong>Part No.</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 13%; text-align: center;"><strong>Make</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 15%; text-align: center;"><strong>Model</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 46%; text-align: center;"><strong>Particular Name</strong></td>
						<td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Qty</strong></td>
					</tr>
					<?php $item_row = 1;foreach($items as $product){ ?>
					<tr>
						<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
						<td valign="top" style="text-align: center;"><?php echo strtoupper($product->item_code);?></td>
						<td valign="top" style="text-align: left;"><?php echo strtoupper($product->make_name);?></td>
						<td valign="top" style="text-align: left;"><?php echo strtoupper($product->vehicle_model);?></td>
						<td valign="top">
						<?php echo $product->part_name_en;?> - <?php echo $product->part_name_ar;?>
						</td>
						<td valign="top" style="text-align: center;"><?php echo $product->quantity;?></td>
					</tr>
					<?php $item_row = $item_row + 1;}?>
				</table>
			</td>
			<td style="width: 5%;"></td>
		</tr>
		
	</table>

</body>

</html>
