<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<!-- <tr>
		<td colspan="2"><img src="<?php //echo base_url('admin_assets/images/quotation/header-top.jpg');?>" style="max-width: 100%;" /></td>
	</tr> -->
	<tr>
		<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
			<span>Riyadh, SA</span><br>
			<span></span><br>
			<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
		</td>
		<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;">Delivery Summary of Period - <?php echo $start; ?> to <?php echo $end; ?></strong><br>
			<span>Driver's ID: <?= $results['other_info']['driver_id'];?></span><br>
			<span>Driver Name: <?= $results['other_info']['driver_name'];?></span><br>
			<span>Company Name: <?= $results['other_info']['company_name'];?></span><br>
		</td>
		
	</tr>
</table>
