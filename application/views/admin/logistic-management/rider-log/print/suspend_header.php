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
			<strong style="font-size: 14px;">Daily Suspended Report</strong><br>
			<span>Date Between: <?php echo $search_datefrom; ?> - <?php echo $search_dateto; ?></span><br>
			<span>Filter: <?php echo ($this->input->get('search_keyword') == '') ? 'All Data Available' : $search_keyword; ?></span><br>
		</td>
	</tr>
	<tr>
		<td colspan="2"></td>
	</tr>
</table>
