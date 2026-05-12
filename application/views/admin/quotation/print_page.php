<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Baqala Station - Quotation</title>
<style>
*{padding:0px;margin:0px}
</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
        <tr>
            <td colspan="2" style="width: 100%;">
                <table width="100%" border="1" cellspacing="0" cellpadding="5">
                    <tr>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>S. NO</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 13%; text-align: center;"><b>BARCODE</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 33%; text-align: center;"><b>PRODUCT NAME / DESCRIPTION</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><b>PRICE</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>QTY</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><b>VALUE</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 9%; text-align: center;"><b>AMT. EXCL. VAT</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: center;"><b>VAT AMT.</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><b>VAT %</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><b>AMT. INC. VAT</b></td>
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
						<td valign="top" style="text-align: right;"><?php echo $product['barcode'];?></td>
						<td valign="top">
						<?php echo $product['product_name']; ?><br />
						<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
						</td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$p_price); ?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['quantity'];?></td>
						<td valign="top" style="text-align: right;"><?php echo  sprintf("%.2f", $product['order_price']); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['gst_rate']; ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="12" style="width: 100%;">
							<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
								<tr>
									<td style="font-size: 10px; font-weight: 500;direction: rtl;">Total Items: <?php echo count($result['product']); ?><br/>أجمالي الأصناف</td>
									<td style="font-size: 10px; font-weight: 500;">Total Excluding VAT: <?php echo round($amt_exl_vat,2); ?> SAR<br/>الإجمالي بدون الضريبة</td>
									<td style="font-size: 10px; font-weight: 500;"><?php if($result['order']['promo_code_price'] > 0){ echo 'Discount: '. $result['order']['promo_code_price'] .' ('. $result['order']['promo_code_name'] .')<br/>الخصم'; } ?></td>
									
								</tr>
								<tr>
									<td style="font-size: 10px; font-weight: 500;">Total Qty: <?php echo $total_qty; ?><br/>أجمالي الكمية</td>
									<td style="font-size: 10px; font-weight: 500;">VAT: <?php echo sprintf("%.2f",$total_vat); ?>  SAR<br/>الضريبة</td>
									
									
								</tr>
								
								<tr>
									<td style="font-size: 10px; font-weight: 500;">Shipping Charge: <?php echo $result['order']['shipping_charge']; ?> SAR<br/>مصاريف الشحن</td>
									<td></td>
									<td style="font-size: 10px; font-weight: 500;">Total Amount:<b> <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?> SAR</b><br/>المبلغ شامل الضريبة</td>
								</tr>
								
								<!--- Error here --->
								<tr>
									<td style="font-size: 10px; font-weight: 500;">
										<?php if($result['order']['cashback_applied'] > 0){ ?>
										Rewards Applied: <?php echo $result['order']['cashback_applied']; ?> SAR<br/>
										<?php } ?>
									</td>
									<td style="font-size: 10px; font-weight: 500;">
									<?php if($result['order']['wallet_applied'] > 0){ ?>
									Wallet Applied:<b> <?php $net_amt = $result['order']['wallet_applied']; echo sprintf("%.2f",$net_amt);?> SAR</b>
									<?php } ?>
									</td>
									<td style="font-size: 10px; font-weight: 500;">
									<?php if($result['order']['net_payble_amt'] > 0){ ?>
									Net Payable Amount: <strong><?php $net_payble_amt = $result['order']['net_payble_amt'] + $result['order']['shipping_charge']; echo sprintf("%.2f",$net_payble_amt);?> SAR</strong>
									<?php } ?>
									</td>
								</tr>
								<!-- Error End -->
							</table>
						</td>
					</tr>
					
                </table>
            </td>
        </tr>
    </table>
</body>

</html>