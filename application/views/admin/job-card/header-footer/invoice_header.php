<table border="0" cellspacing="0" cellpadding="1" style="font-size: 11px; width: 100%;">
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
			<strong style="font-size: 14px;">Job Report of Period - <?php echo ($this->input->get('start_filter') !== '') ? $this->input->get('start_filter') : 'NA';?> to <?php echo ($this->input->get('end_filter') !== '') ? $this->input->get('end_filter') : 'NA';?></strong><br>
			<table>
				<?php if($this->input->get('vehicle_filter') !== ''){ ?>
				<tr>
					<td style="width:30%;">Vehicle No </td>
					<td> : <?= $results['job_info']['bike_no']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;">Vehicle Make </td>
					<td> : <?= $results['job_info']['vehicle_make']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;">Vehicle Type </td>
					<td> : <?= $results['job_info']['vehicle_type']; ?></td>
				</tr>
				<tr>
					<td style="width:30%;">Vehicle Color </td>
					<td> : <?= $results['job_info']['vehicle_color']; ?></td>
				</tr>
				<?php }else{ ?>
				<tr>
					<td style="width:20%;"><b>Search for </b></td>
					<td> : All Vehicle</td>
				</tr>
				<?php } ?>
			</table>
		</td>
		
	</tr>
</table>
