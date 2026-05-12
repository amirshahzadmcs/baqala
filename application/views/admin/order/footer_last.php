<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">	
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
		}
	?>
	<tr>
		<td style="width: 5%;"></td>
		<td colspan="3" style="border-top:2px solid #e0b500;border-bottom:2px solid #e0b500;width: 90%;">
			<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 2px; border-top: none;font-size:13px;">
				<tr><td colspan="7" style="line-height:5px;"></td></tr>
				<tr>
					<td colspan="2" style="text-align: left;font-size:11px;">
						<table cellpadding="2">
							<tr>
								<td>Delivery Instructions: <?php echo $result['order']['shipping_instruction']; ?></td>
							</tr>
							<tr>
								<td>Contact Person: <?php echo $result['order']['shipping_person_name']; ?></td>
							</tr>
							<tr>
								<td>Mobile No: <?php echo $result['order']['shipping_mobile']; ?></td>
							</tr>
						</table>
					</td>
					<td colspan="3" valign="top" style="text-align: center;">
						<table cellpadding="0">
							<tr>
								<td>
									<?php if(!empty($result['order']['delivery_date']) || $result['order']['order_status_id'] == '6'){ ?>
									<?php $qrimg = base_url().'uploads/qrcodes/'.$result['order']['trans_id'].'-Qrcode.png'; ?>
									<img src="<?php echo $qrimg;?>" style="width:120px;">
									<?php } ?>
								</td>
							</tr>
						</table>
					</td>
					<td colspan="2" style="text-align: right;">
						<table cellpadding="5">
							<tr>
								<td style="text-align: right;border-top:1px solid #2fa55d;"><strong>Sub Total</strong></td>
								<td style="text-align: right;border-top:1px solid #2fa55d;">SAR <?php echo sprintf("%.2f",$amt_exl_vat); ?></td>
							</tr>
							<tr>
								<td style="text-align: right;font-size:10px;line-height:5px;">(excl. VAT)</td>
								<td style="line-height: 5px;"></td>
							</tr>
							<tr>
								<td style="text-align: right;"><strong>Shipping</strong></td>
								<td style="text-align: right;">SAR <?php echo sprintf("%.2f", $result['order']['shipping_charge']); ?></td>
							</tr>
							<tr>
								<td style="text-align: right;background-color:#f8f8f8;border-bottom:1px solid #2fa55d;"><strong>VAT (15%)</strong></td>
								<td style="text-align: right;background-color:#f8f8f8;border-bottom:1px solid #2fa55d;">SAR <?php echo sprintf("%.2f",$total_vat); ?></td>
							</tr>
							<tr>
								<td style="text-align: right;"><strong>TOTAL</strong></td>
								<td style="text-align: right;"><b>SAR <?php $net_amt = $result['order']['order_total']; echo sprintf("%.2f",$net_amt);?></b></td>
							</tr>
						</table>
					</td>
				</tr>
				
			</table>
		</td>
		<td style="width: 5%;"></td>
	</tr>
	<tr>
		<td style="width: 5%;"></td>
		<td colspan="5" valign="top" style=" width: 60%;">
			<p>baqalastation.com’s Conditions of Use and Sale apply.</p>
			<p style="color:#818181;">Maha Al Fala Trading Company<br>
			2751 Prince Sultan bin Abdulaziz Street<br>
			Sultan Business Center, Riyadh 12312<br>
			Kingdom of Saudi Arabia<br>
			Commercial Licence Number: 1010758117<br>
			VAT Number: 300034911400003</p>
		</td>
		<td colspan="5" valign="bottom" align="right" style=" width: 30%;"><br><br><img src="<?php $bcode = $result['order']['invoice_prefix'] . $result['order']['order_no']; echo generate_barcode($bcode)['barcode'];?>"></td>
		<td style="width: 5%;"></td>
	</tr>
</table>
