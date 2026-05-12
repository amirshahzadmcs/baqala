<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E Basket - Invoice</title>
<style>
*{padding:0px;margin:0px}
</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
        <tr>
            <td colspan="2"><img src="build/images/invoice/corporate/header-top.jpg" style="max-width: 100%;" /></td>
        </tr>
        <tr>
            <td style="width: 80%;">
                <table style="font-size: 10px; width: 100%;">
                <tr><br>
                    <td align="left" valign="top" style="width: 50%;"><b>Customer Name:</b> <?php echo $result['order']['name'];?><br />
                    <?php if(!empty($result['order']['c_company'])) { ?>
                    <b>Company Name:</b> <?php echo $result['order']['c_company'];?><br />
                    <?php } ?>
                    <?php if($result['order']['c_role'] == 2){ echo '<b>Customer VAT:</b> ' .$result['order']['c_vat'];  ?><br/><?php } ?>
        			<b>Mobile Number:</b> <?php echo $result['order']['mobile'];?>
        			
                    </td>
        			<td valign="top" style="width: 50%; float: right;text-align:right;"><?php if(!empty($result['order']['payment_code'])){?><b>TransRef ID :</b> <?php echo $result['order']['payment_code']; ?><br/><?php } ?>
        			<b>Invoice Number :</b> #<?php echo $result['order']['invoice_prefix'] .'-'. $result['order']['id'];?><br/>
        			<b>Invoice Date :</b> <?php echo date('Y-m-d H:i:s'); ?><br/>
        			<b>Order Date:</b> <?php echo $result['order']['date_added']; ?>
        			</td>
                </tr>
                <tr><td colspan="2"></td></tr>
                <tr>
                    <br>
        			<td valign="top"><b>Shipping Address :</b><br /><?php echo $result['order']['shipping_firstname'];?><br/><?php echo $result['order']['villa_building'];?>, <?php echo $result['order']['shipping_complete_address'];?>
        			</td>
        			<td valign="top" style="width: 50%; float: right;text-align:right;">
        			<b>Payments:</b> <?php echo $result['order']['payment_method']; ?><br />
        			<b>Delivery Date:</b> <?php echo $result['order']['shipping_date_slot']; ?><br/>
        			<b>Delivery Time:</b> <?php echo $result['order']['shipping_time_slot']; ?>
        			</td>
                </tr>
                <tr><td colspan="2"></td></tr>
                </table>
            </td>
            <td>
                <?php $qrimg = 'https://www.baqalastation.com/app/uploads/qrcodes/'.$result['order']['trans_id'].'-Qrcode.png'; ?><img width='100px' src="<?php echo $qrimg;?>">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="5">
                    <tr>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 3%; text-align: center;"><b>S. No</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 10%; text-align: center;"><b>Barcode</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 20%; text-align: center;"><b>Description</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>RSP</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>Price</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: center;"><b>Qty</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>Value</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>Net</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>VAT</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 4%; text-align: center;"><b>VAT %</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 5%; text-align: center;"><b>Saving <br/>(SAR)</b></td>
                        <td valign="top" bgcolor="#CCCCCC" style="width: 6%; text-align: center;"><b>Total <br/>(in SAR)</b></td>
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
						$savings += ($real_price - $p_price);
						$amt_exl_vat += $product['order_price'] - $product['vat_price'];
						$amt_incl_vat += $product['order_price'];
					?>
					<tr>
						<td valign="top" style="text-align: center;"><?php echo $i++;?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['barcode'];?></td>
						<td valign="top">
						<?php echo $product['short_name']; ?><br />
						<span style="display: block; text-align: right;"><?php echo $product['arabic_name']; ?> </span>
						</td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$real_price); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f",$p_price); ?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['quantity'];?></td>
						<td valign="top" style="text-align: right;"><?php echo  sprintf("%.2f", $product['order_price']); ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $initial_price); ?></td>
						<td valign="top" style="text-align: center;"><?php echo sprintf("%.2f", $product['vat_price']); ?></td>
						<td valign="top" style="text-align: center;"><?php echo $product['gst_rate'] .'%'; ?></td>
						<td valign="top" style="text-align: right;"><?php echo $real_price - $p_price; ?></td>
						<td valign="top" style="text-align: right;"><?php echo sprintf("%.2f", $product['order_price']); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td colspan="10">
							<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 5px; border-top: none;">
								<tr>
									<td style="font-size: 10px; font-weight: 500;direction: rtl;">Total Items: <?php echo count($result['product']); ?><br/>أجمالي الأصناف</td>
									<td style="font-size: 10px; font-weight: 500;">Total Excluding VAT: <?php echo sprintf("%.2f",$amt_exl_vat); ?> SAR<br/>الإجمالي بدون الضريبة</td>
									<td style="font-size: 10px; font-weight: 500;"><?php if($result['order']['promo_code_price'] > 0){ echo 'Discount: '. $result['order']['promo_code_price'] .' ('. $result['order']['promo_code_name'] .')<br/>الخصم'; } ?></td>
									
								</tr>
								<tr>
									<td style="font-size: 10px; font-weight: 500;">Total Qty: <?php echo $total_qty; ?><br/>أجمالي الكمية</td>
									<td style="font-size: 10px; font-weight: 500;">VAT: <?php echo sprintf("%.2f",$total_vat); ?>  SAR<br/>الضريبة</td>
									
									<td style="font-size: 10px; font-weight: 500;">Savings: <?php echo $savings; ?><br/>مدخرات</td>
									
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
									Net Payable Amount: <?php $net_payble_amt = $result['order']['net_payble_amt']; echo sprintf("%.2f",$net_payble_amt);?> SAR
									<?php } ?>
									</td>
								</tr>
								<!-- Error End -->
							</table>
						</td>
						<td colspan="2">
							<?php if($result['order']['net_payble_amt'] > 0){ ?>
								<img src="build/images/stamps/unpaid.png" style="max-width: 100%;" />
							<?php }else{ ?>
								<img src="build/images/stamps/paid.png" style="max-width: 100%;" />
							<?php } ?>
						</td>
					</tr>
					
                </table>
            </td>
        </tr>
		<tr>
            <td colspan="2" valign="top" style=" width: 100%;">
				<img src="build/images/invoice/corporate/footer.jpg" style="max-width: 100%;" />
			</td>
        </tr>
    </table>
</body>

</html>