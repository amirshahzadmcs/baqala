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
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b> الرقم التسلسلي </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 13%; text-align: right;"><b> الباركود </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 33%; text-align: right;"><b> وصف </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: right;"><b> السعر </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: right;"><b> الكمية </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: right;"><b> السعر قبل الضريبة </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: right;"><b> قيمة </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: right;"><b> الضريبة </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: right;"><b> الضريبة % </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: right;"><b> إنقاذ </b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 7%; text-align: right;"><b> الأجمالي </b></td>
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
						<?php echo $product['short_name']; ?><br />
						<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
						</td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$p_price); ?></td>
						<td valign="top" style="text-align: right;"><?php echo $product['quantity'];?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
						<td valign="top" style="text-align: right;"><?php echo $product['gst_rate'] .'%'; ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", ($real_price - $p_price)*$product['quantity']); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
					</tr>
					<?php } ?>
					
                </table>
				<table border="1" cellspacing="0" cellpadding="2" style="font-size: 10px; width: 99%;">
					<tr nobr="true">
						<td colspan="10">
							<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
								<tr>
									<td style="font-size: 10px; font-weight: 500;direction: rtl;">أجمالي الأصناف : <?php echo count($result['product']); ?></td>
									<td style="font-size: 10px; font-weight: 500;">الإجمالي بدون الضريبة : <?php echo sprintf("%.2f",$amt_exl_vat); ?> SAR</td>
									<td style="font-size: 10px; font-weight: 500;"><?php if($result['order']['promo_code_price'] > 0){ echo 'الخصم : '. $result['order']['promo_code_price'] .' ('. $result['order']['promo_code_name'] .')'; } ?></td>
									
								</tr>
								<tr>
									<td style="font-size: 10px; font-weight: 500;">أجمالي الكمية : <?php echo $total_qty; ?></td>
									<td style="font-size: 10px; font-weight: 500;">الضريبة : <?php echo sprintf("%.2f",$total_vat); ?>  SAR</td>
									
									<td style="font-size: 10px; font-weight: 500;">مدخرات : <?php echo $savings; ?></td>
									
								</tr>
								
								<tr>
									<td style="font-size: 10px; font-weight: 500;">مصاريف الشحن : <?php echo $result['order']['shipping_charge']; ?> SAR</td>
									<td></td>
									<td style="font-size: 10px; font-weight: 500;"><b> <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?> SAR</b> المبلغ شامل الضريبة : </td>
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
									صافي المبلغ المستحق : <?php $net_payble_amt = $result['order']['net_payble_amt']; echo sprintf("%.2f",$net_payble_amt);?> SAR
									<?php } ?>
									</td>
								</tr>
								<!-- Error End -->
							</table>
						</td>
						<td colspan="2" valign="top">
							<?php if($result['order']['net_payble_amt'] > 0 && $result['order']['payment_method'] !== 'Cash Advance'){ ?>
								<img src="admin_assets/images/stamps/unpaid.png" style="max-width: 90%;" />
							<?php }else{ ?>
								<img src="admin_assets/images/stamps/paid.png" style="max-width: 90%;" />
							<?php } ?>
						</td>
					</tr>
				</table>
            </td>
        </tr>
		
    </table>
</body>

</html>