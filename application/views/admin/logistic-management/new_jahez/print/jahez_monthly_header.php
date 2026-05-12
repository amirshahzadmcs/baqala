<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<tr>
		<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
			<span>Riyadh, SA</span><br>
			<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
		</td>
		<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<?php
			if($search_month !== ''){
				$data_range = date('M Y', strtotime($search_month));
			}else{
				$data_range = 'ALL';
			}
			?>
			<strong style="font-size: 14px;">Monthly Delivery Report</strong><br>
			<span>Filter: <?php echo ($this->input->get('keyword') == '') ? 'All Data Available' : $this->input->get('keyword'); ?></span><br>
			<span>Department: Logistic</span><br>
		</td>
	</tr>
</table>
