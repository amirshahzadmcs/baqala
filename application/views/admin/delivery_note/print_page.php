<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baqala Station - Delivery Note</title>
<style>
*{padding:0px;margin:0px}
</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
        
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="3">
					<tr>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><b>S. No</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 15%; text-align: center;"><b>Barcode</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 36%; text-align: center;"><b>Description English</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 36%; text-align: center;"><b>Description Arabic</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><b>Qty</b></td>
                    </tr>
					<?php 
						$total_qty =0;$i = 1;$amt_exl_vat = 0;$amt_incl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;$mrp = 0;$real_price = 0;$savings =0;
						foreach($result['product'] as $product){
						$real_price = $product['real_price']; 
						$p_price = ($product['discounted_price'] == 0) ? $product['real_price'] : $product['discounted_price'];
						//$vat_initial = ($product['gst_rate'] / 100) * $p_price;
						$initial_price = $product['order_price'] - $product['vat_price'];
						$total_qty += $product['quantity'];
						$total_vat += $product['vat_price'];
						$mrp += $real_price;
						$savings += ($real_price - $p_price)*$product['quantity'];
						$amt_exl_vat += $product['order_price'] - $product['vat_price'];
						$amt_incl_vat += $product['order_price'];
					?>
					<tr>
						<td valign="top" style="text-align: center;"><?php echo $i++;?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['barcode'];?></td>
						<td valign="top">
						<?php echo $product['product_name']; ?>
						</td>
						<td valign="top">
						<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
						</td>
						<td valign="top" style="text-align: center;"><?php echo $product['quantity'];?></td>
					</tr>
					<?php } ?>
					<tr>
					    <td colspan="3">Total Items: <?php echo count($result['product']); ?><span style="text-align: right;">Total Qty:</span></td>
					    <td style="text-align: right;">Total Qty:</td>
					    <td style="text-align: center;"><?php echo $total_qty; ?></td>
					</tr>
                </table>
				<table border="1" cellspacing="0" cellpadding="1" style="font-size: 11px; width: 100%;">
					<tr nobr="true">
						<td colspan="12">
							<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
								<tr>
									<td><br/><br/><br/><b>Received By</b> &nbsp;&nbsp;&nbsp;: _____________________________</td>
								</tr>
								<tr>
									<td><br/><br/><br/><b>Received Date</b> : _____________________________</td>
								</tr>
								<tr>
									<td><br/><br/><br/><b>Stamp</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <br/><br/><br/></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
            </td>
        </tr>
		
    </table>
</body>

</html>