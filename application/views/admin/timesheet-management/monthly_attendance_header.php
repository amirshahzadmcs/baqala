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
			<strong style="font-size: 14px;">Monthly Attendance Report Days Wise</strong><br>
			<strong style="font-size: 12px;">Month of: <?php $date = DateTime::createFromFormat('M Y', $search_month); $attendanceMonth = $date->format('F Y'); echo $attendanceMonth; ?></strong><br>
			<?php if($search_team_id){ ?>
			<strong style="font-size: 12px;">Team: <?= $search_team_name; ?></strong>
			<?php } ?>
		</td>
	</tr>
</table>
