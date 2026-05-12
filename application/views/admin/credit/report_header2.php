<table border="0" cellspacing="0" cellpadding="1" style="width: 100%;">
	<tr><td colspan="3"></td></tr>	
	<tr>
		<td style="width: 15%;"></td>
		<td align="center" style="width: 70%;">
			<?php
				if($this->input->get('from') !== '' && $this->input->get('to') !== ''){
					$report_date = date("d-m-Y", strtotime($this->input->get('from'))) .' To '. date("d-m-Y", strtotime($this->input->get('to')));
				}else{
					$report_date = date("d-m-Y", strtotime(date('y-m-d')));
				}
			?>
			<h4 class="report-heading">STATEMENT OF ACCOUNT <br/>OUTSTANDING AS AT <?= $report_date;?></h4>
		</td>
		<td style="width: 15%;">
			<img src="<?php echo base_url('admin_assets/images/logo.png');?>" class="company-logo" height="50px" />
		</td>
	</tr>
	<tr><td colspan="3"></td></tr>
	<tr><td colspan="3"></td></tr>
</table>
