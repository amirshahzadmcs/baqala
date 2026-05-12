<table border="0" cellspacing="0" cellpadding="1" style="font-size: 11px; width: 100%;">
	<tr><td colspan="2"></td></tr>
	<tr><td colspan="2"></td></tr>
	<tr>
		<td align="left" valign="top" style="width: 50%;border-bottom: 1px solid #000;">
			<strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br>
			<span>Riyadh, SA</span><br>
			<span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
		</td>
		<td align="left" valign="center" style="width: 50%;border-bottom: 1px solid #000;">
			<strong style="font-size: 14px;">Monthly Compliance Report</strong><br>

			<?php
				$date = DateTime::createFromFormat('Y-m', $search_month);
				$attendanceMonth = $date ? $date->format('F Y') : 'Invalid Month';
				$hasDateFilter = !empty($filters['date_from']) || !empty($filters['date_to']);
			?>
			
			<strong style="font-size: 11px;">Month of: <?php echo $attendanceMonth; ?></strong>
			
			<?php if ($hasDateFilter): ?>
			<br>
			<span style="font-size: 10px;"><?php if (!empty($filters['date_from']) && !empty($filters['date_to'])): ?>(Filtered From: <?= date('d M Y', strtotime($filters['date_from'])) ?> 
				to <?= date('d M Y', strtotime($filters['date_to'])) ?>)
				<?php elseif (!empty($filters['date_from'])): ?>
				(Filtered From: <?= date('d M Y', strtotime($filters['date_from'])) ?>)
				<?php elseif (!empty($filters['date_to'])): ?>
				(Up To: <?= date('d M Y', strtotime($filters['date_to'])) ?>)
			<?php endif; ?>
			</span>
			<?php endif; ?>
		</td>
	</tr>
</table>
