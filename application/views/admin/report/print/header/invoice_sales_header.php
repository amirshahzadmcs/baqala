<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
	<!-- <tr>
		<td colspan="2"><img src="<?php //echo base_url('admin_assets/images/quotation/header-top.jpg');?>" style="max-width: 100%;" /></td>
	</tr> -->
	<tr>
		<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
			<span>Riyadh</span><br>
			<span></span><br>
			<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
		</td>
		<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;line-height:1.5;">
			<p></p>
			<strong style="font-size: 14px;"><?php echo $this->input->get('page') ?></strong><br>
			<span>Date From: <?php 
								if(!empty($this->input->get('start')) && !empty($this->input->get('end'))){
									echo $this->input->get('start'); ?> To <?php echo $this->input->get('end');
								} else {
									echo 'All Data Available';
								}								 
							 ?></span><br>
			<span><?php echo $order[0]->cus_name; ?></span><br>
			<span>VAT No: <?php echo $order[0]->c_vat; ?></span><br>
		</td>
		
	</tr>
</table>
