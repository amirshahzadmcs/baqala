<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Purchase Return Voucher</title>
	<style>
	*{padding:0px;margin:0px}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
	<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>S. No.</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 9.5%;"><strong>CHILD SKU</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 10%;"><strong>SUPPLIER SKU</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 13%;"><strong>BARCODE</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 22%;"><strong>PRODUCT NAME/ DESCRIPTION</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 5%;"><strong>QTY</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>UNIT PRICE</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 9%;"><strong>AMT. EXCL. VAT</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 8.5%;text-align:right"><strong>VAT AMT.</strong></td>
						<td valign="top" bgcolor="#CCCCCC" style="width: 9%;text-align:right"><strong>AMT. INC. VAT</strong></td>
					</tr>
					<?php $item_row = 1;foreach($products as $product){ ?>
					<tr>
						<td valign="top" style="text-align: center;"><?php echo $item_row;?></td>
						<td valign="top"><?php echo strtoupper($product->item_sku);?></td>
						<td valign="top"><?php echo strtoupper($product->seller_sku);?></td>
						<td valign="top"><?php echo $product->barcode;?></td>
						<td valign="top">
							<?php echo $product->item_description; ?>
						</td>
						<td valign="top" style="text-align: center;"><?php echo $product->item_unit;?></td>
						<td valign="top" style="text-align: right;"><?php echo $product->unit_price;?></td>
						<td valign="top" style="text-align: right;"><?php echo $product->item_total;?></td>
						<td valign="top" align="right"><?php echo $product->vat_price;?></td>
						<td valign="top" align="right"><?php echo $product->amt_incl_vat;?></td>
					</tr>
					<?php $item_row = $item_row + 1;}?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table border="1" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
					<tbody>
						<tr>
							<td style="width: 59.5%;">
								<table border="0" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;border-top:none;">
									<tr>
										<td>
											<p style="line-height: 15px;">1. Please send two copies of your invoice.<br/>
											2. Enter this order in accordance with the prices, terms, delivery method, and specifications listed above.<br/>
											3. Please notify us immediately if you are unable to ship as specified.<br/>
											4. Send all correspondence to: sales@ixiana.com</p>
										</td>
									</tr>
								</table>
							</td>

							<td style="vertical-align: top; width: 40.5%;">
								<table border="1" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 100%;border-top:none;">
									<tr>
										<td colspan="2" style="text-align: right;">SUBTOTAL</td>
										<td style="text-align:right" class="amount subtotal"><?php echo $order->sub_total;?></td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: right;">VAT %</td>
										<td style="text-align:right" class="amount"><?php echo $order->sale_tax;?></td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: right;">VAT AMOUNT</td>
										<td style="text-align:right" class="amount"><?php echo $order->sale_tax_amt;?></td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: right;">SHIPPING &amp; HANDLING</td>
										<td style="text-align:right" class="amount"><?php echo $order->shipping_handling;?></td>
									</tr>
									<tr>
										<td colspan="2" style="text-align: right;">TOTAL SAR</td>
										<td class="total amount" align="right"><?php echo $order->total;?></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5">
					<tr>
						<td valign="top" bgcolor="#eee"><strong>Store Manager</strong></td>
						<td valign="top" bgcolor="#eee"><strong>Procurement Manager</strong></td>
						<td valign="top" bgcolor="#eee"><strong>Finance Manager</strong></td>
						<td valign="top" bgcolor="#eee"><strong>Authorized Manager</strong></td>
					</tr>
					<tr>
						<td valign="top" height="50px"></td>
						<td valign="top" height="50px"></td>
						<td valign="top" height="50px"></td>
						<td valign="top" height="50px"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>