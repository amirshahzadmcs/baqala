<table border="0" cellspacing="0" cellpadding="1" style="font-size: 12px; width: 100%;">
	<tr>
		<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
			<span>Riyadh, SA</span><br>
			<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
		</td>
		<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;">Monthly Fuel Summary</strong><br>
			<?php
				$date = DateTime::createFromFormat('Y-m', $search_month);
				$fuelMonth = $date ? $date->format('F Y') : 'Invalid Month';
			?>

			<strong style="font-size: 12px;">Month of: <?php echo $fuelMonth; ?></strong>
		</td>
	</tr>
</table>
