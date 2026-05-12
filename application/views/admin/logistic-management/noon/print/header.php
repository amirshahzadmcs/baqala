<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.3;">
			<p></p>
			<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
			<span>Riyadh, SA</span><br>
			<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
		</td>
		<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.3;">
			<p></p>
			<strong style="font-size: 14px;">Noon Daily Order Summary</strong><br>
			<span>Department: Logistic</span><br>
			<?php
				$filterText = 'All Records';
				if (!empty($start_date) && !empty($end_date)) {
					$filterText = ' (From ' . $start_date . ' to ' . $end_date .')';
				}
			?>
			<span>Filter: <?= $searched . $filterText; ?></span><br>
		</td>
	</tr>
</table>
