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
			<strong style="font-size: 14px;">Sim Card Database - Mobile Bills Summary</strong><br>
			<strong style="font-size: 12px;">Date From: - <?php echo ($this->input->get('period_start') !== '') ? date('M Y', strtotime($start)) : 'NA'; ?> To <?php echo ($this->input->get('period_end')) ? date('M Y', strtotime($end)) : 'NA'; ?></strong><br>
			<span><?php echo ($this->input->get('user') == '') ? 'All Data Available' : employeeDetailHelper($this->input->get('user'))->first_name; ?></span><br>
			<span>Department: <?php echo ($this->input->get('user') == '') ? 'NA' : employeeDetailHelper($this->input->get('user'))->department_name; ?></span><br>
		</td>
		
	</tr>
</table>
