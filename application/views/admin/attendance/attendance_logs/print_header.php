<table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
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
			<strong style="font-size: 14px;">Employee Attendance - Logs</strong><br>
			<strong style="font-size: 12px;">Date From: - <?php echo ($this->input->get('from') !== '') ? date('M Y', strtotime($start)) : 'NA'; ?> To <?php echo ($this->input->get('to')) ? date('M Y', strtotime($end)) : 'NA'; ?></strong><br>
			<span>Filter: <?php echo ($this->input->get('keyword') == '') ? 'All Employee' : employeeDetailHelper($this->input->get('keyword'))->first_name; ?></span><br>
			<span>Department: <?php echo ($this->input->get('department') == '') ? 'All Department' : departmentsDetailHelper($this->input->get('department'))->name; ?></span><br>
		</td>
		
	</tr>
</table>
