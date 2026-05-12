<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">	
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
		}
	?>
	<tr>
		<td style="width: 5%;"></td>
		<td colspan="3" style="border-top:2px solid #e0b500;border-bottom:2px solid #e0b500;width: 90%;">
			<table cellpadding="2" style="width: 100%; margin-top: 0px; padding: 2px; border-top: none;font-size:13px;">
				<tr><td colspan="7" style="line-height:5px;"></td></tr>
				<tr>
					<td colspan="5" style="text-align: left;font-size:11px;">Received By:</td>
					<td colspan="1" style="text-align: right;border-top:1px solid #2fa55d;"><strong>Total Items</strong></td>
					<td colspan="1" style="text-align: right;border-top:1px solid #2fa55d;"><?php echo count($result['product']); ?></td>
				</tr>
				<tr>
					<td colspan="5" style="text-align: left;line-height:10px;font-size:11px;">Received Date:</td>
					<td colspan="1" style="text-align: right;line-height:8px;font-size:10px;"></td>
					<td colspan="1" style="text-align: right;"></td>
				</tr>
				<tr>
					<td colspan="5" style="text-align: left;line-height:8px;font-size:11px;">Stamp:</td>
					<td colspan="1" style="text-align: right;line-height:28px;background-color:#f8f8f8;border-bottom:1px solid #2fa55d;"><strong>Total Qty</strong></td>
					<td colspan="1" style="text-align: right;line-height:28px;background-color:#f8f8f8;border-bottom:1px solid #2fa55d;"><?php echo $total_qty; ?></td>
				</tr>
				<tr><td colspan="5"></td><td colspan="2" style="line-height:0px;"></td></tr>
				<tr>
					<td colspan="5" style="text-align: right;"></td>
					<td colspan="1" style="text-align: right;line-height:-10px;"><strong></strong></td>
					<td colspan="1" style="text-align: right;line-height:-10px;"><b></b></td>
				</tr>
			</table>
		</td>
		<td style="width: 5%;"></td>
	</tr>
	<tr>
		<td style="width: 5%;"></td>
		<td colspan="7" valign="top" style=" width: 90%;">
			<p>baqalastation.com’s Conditions of Use and Sale apply.</p>
			<p style="color:#818181;">Maha Al Fala Trading Company<br>
			2751 Prince Sultan bin Abdulaziz Street<br>
			Sultan Business Center, Riyadh 12312<br>
			Kingdom of Saudi Arabia<br>
			Commercial Licence Number: 1010758117<br>
			VAT Number: 300034911400003</p>
		</td>
		<td style="width: 5%;"></td>
	</tr>
</table>
