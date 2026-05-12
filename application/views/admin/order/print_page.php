<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baqala Station - Invoice</title>
<style>
*{padding:0px;margin:0px}

</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="5" style="font-size: 10px; width: 96%;">
        <tr>
            <td colspan="2" style="width: 100%;">
                <table width="100%" border="0.3" cellspacing="0" cellpadding="5">
					<thead>
						<tr>
							<td valign="top" bgcolor="#c6efce" style="width: 6%; text-align: center;font-weight:900;"><strong>Sr. No</strong></td>
							<td valign="top" bgcolor="#c6efce" style="width: 15%; text-align: center;"><b>Barcode/SKU</b></td>
							<td valign="top" bgcolor="#c6efce" style="width: 51%; text-align: center;"><b>Item Description</b></td>
							<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><b>Price</b></td>
							<td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><b>Qty</b></td>
							<td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><b>Line Total</b></td>
						</tr>
					</thead>
					<?php 
						$total_qty =0;$i = 1;$amt_exl_vat = 0;$amt_incl_vat = 0;$total_vat = 0;$saving = 0;$ptotal = 0;$mrp = 0;$real_price = 0;$savings =0;
						foreach($result['product'] as $product){
						$real_price = $product['real_price']; 
						$p_price = ( $product['discounted_price'] == 0) ? $product['real_price'] : $product['discounted_price'];
						//$single_pvat = ($product['gst_rate'] / 100) * $p_price;
						$initial_price = $product['order_price'] - $product['vat_price'];
						$exc_vat_price = $initial_price/$product['quantity'];
						$total_qty += $product['quantity'];
						$total_vat += $product['vat_price'];
						$mrp += $real_price;
						$savings += ($real_price - $p_price)*$product['quantity'];
						$amt_exl_vat += $product['order_price'] - $product['vat_price'];
						$amt_incl_vat += $product['order_price'];
					?>
					<tr>
						<td valign="middle" style="text-align: center;"><?php echo $i++;?></td>
						<td valign="middle" style="text-align: center;"><?php echo $product['barcode'];?></td>
						<td valign="middle">
						<?php echo $product['product_name']; ?>
						</td>
						<td valign="middle" style="text-align: right;"><?php echo sprintf("%.2f",$exc_vat_price); ?></td>
						<td valign="middle" style="text-align: center;"><?php echo $product['quantity'];?></td>
						<td valign="middle" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
					</tr>
					<?php } ?>
					
                </table>
                
            </td>
        </tr>
    </table>
</body>

</html>
