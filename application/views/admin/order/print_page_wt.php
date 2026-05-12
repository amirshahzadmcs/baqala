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
    <table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
        
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="2">
					<tr>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><b>S. NO</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 14%; text-align: center;"><b>BARCODE</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 28%; text-align: center;"><b>ITEM DESCRIPTION ENGLISH</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 28%; text-align: center;"><b>ITEM DESCRIPTION ARABIC</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 8%; text-align: center;"><b>PRICE</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><b>QTY</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 10%; text-align: center;"><b>LINE TOTAL</b></td>
                    </tr>
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
						<td valign="top" style="text-align: center;"><?php echo $i++;?></td>
						<td valign="top" style="text-align: right;"><?php echo $product['barcode'];?></td>
						<td valign="top"><?php echo $product['product_name']; ?></td>
						<td valign="top"><span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$exc_vat_price); ?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['quantity'];?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
					</tr>
					<?php } ?>
					
                </table>
				<table border="0" cellspacing="0" cellpadding="2" style="font-size: 10px; width: 100%; border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000">
					<tr nobr="true">
					    <td colspan="8" valign="top">
							<?php if($result['order']['net_payble_amt'] > 0 && $result['order']['payment_method'] !== 'Cash Advance'){ ?>
								<img src="<?= base_url('admin_assets/images/stamps/unpaid.png');?>" style="width:100px;max-width: 100px;" />
							<?php }else{ ?>
								<img src="<?= base_url('admin_assets/images/stamps/paid.png');?>" style="width:100px;max-width: 100px;" />
							<?php } ?>
						</td>
						<td colspan="4">
							<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
                                <tr>
            						<td colspan="4" style="text-align: right;border-bottom:1px solid #000">SUB TOTAL :<br><span>المجموع الفرعي</span> </td>
            						<td colspan="2" style="text-align: right;border-bottom:1px solid #000"><?php echo sprintf("%.2f",$amt_exl_vat); ?></td>
            					</tr>
            					<tr>
            						<td colspan="4" style="text-align: right;border-bottom:1px solid #000">DISCOUNT :<br><span>تخفيض</span> </td>
            						<td colspan="2" style="text-align: right;border-bottom:1px solid #000"><?php echo sprintf("%.2f",$savings); ?></td>
            					</tr>
            					<tr>
            						<td colspan="4" style="text-align: right;border-bottom:1px solid #000">VAT RATE :<br><span>قيمة الضريبة</span> </td>
            						<td colspan="2" style="text-align: right;border-bottom:1px solid #000">15%</td>
            					</tr>
            					<tr>
            						<td colspan="4" style="text-align: right;border-bottom:1px solid #000">TOTAL VAT :<br><span>إجمالي ضريبة القيمة المضافة</span> </td>
            						<td colspan="2" style="text-align: right;border-bottom:1px solid #000"><?php echo sprintf("%.2f",$total_vat); ?></td>
            					</tr>
            					<tr>
            						<td colspan="4" style="text-align: right;border-bottom:1px solid #000">SHIPPING/HANDLING :<br><span>شحن وتسليم</span> </td>
            						<td colspan="2" style="text-align: right;border-bottom:1px solid #000"><?php echo sprintf("%.2f",$result['order']['shipping_charge']); ?></td>
            					</tr>
            					<tr>
            						<td colspan="4" style="text-align: right;">TOTAL AFTER VAT :<br><span>المجموع بعد ضريبة القيمة المضافة</span> </td>
            						<td colspan="2" style="text-align: right;"><?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?></td>
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