<?php
$visibleTableColumns = $report_data['visible_columns'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Jahez Daily Order Summary</title>
		<style>
			*{padding:0px;margin:0px;}
			table th, table td {
				white-space: nowrap; /* Prevent word breaking */
				overflow: hidden;
				text-overflow: ellipsis; /* Optional: adds "..." if content is too long */
			}
			table {
				border-collapse: collapse;
				table-layout: auto; /* Changed from fixed */
				width: 98%;
			}
		</style>
	</head>
	<body>
		<?php
		$visibleTableColumns = $report_data['visible_columns'];
		$hasFullName = in_array('full_name', $visibleTableColumns);
		$totalCols = count($visibleTableColumns);
		$fixedFullNameWidth = 15; // % width
		$remainingCols = $hasFullName ? $totalCols - 1 : $totalCols;
		$dynamicColWidth = $remainingCols > 0 ? round((99 - ($hasFullName ? $fixedFullNameWidth : 0)) / $remainingCols, 2) : 0;
		?>
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 8px; width: 98%;">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="2" width="100%">
						<thead>
							<tr style="background-color: #f5d880;">
								<th width="25px" align="center">#</th>
								<?php foreach ($visibleTableColumns as $column): 
									$width = ($column == 'full_name') ? $fixedFullNameWidth : $dynamicColWidth;
									$align = ($column == 'full_name') ? 'left' : 'center';
									$label = strtoupper(str_replace('_', ' ', $column));
								?>
									<th width="<?php echo $width; ?>%" align="<?php echo $align; ?>"<?php echo ($column == 'full_name') ? ' nowrap="nowrap"' : ''; ?>>
										<?php echo $label; ?>
									</th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($report_data['data'])): 
								$serialNumber = 1;
								foreach ($report_data['data'] as $detail): ?>
									<tr>
										<td align="center" style="border-bottom:1px dashed #ddd;"><?php echo $serialNumber; ?></td>
										<?php foreach ($visibleTableColumns as $column): 
											$width = ($column == 'full_name') ? $fixedFullNameWidth : $dynamicColWidth;
											$align = ($column == 'full_name') ? 'left' : 'center';
											$value = '';
											if (!empty($detail[$column])) {
												if (in_array($column, ['order_date', 'date', 'created_at', 'updated_at'])) {
													$value = date('d-m-Y', strtotime($detail[$column]));
												} else {
													$value = htmlspecialchars($detail[$column]);
												}
											}else {
												$value = htmlspecialchars($detail[$column]);
											}
										?>
											<td width="<?php echo $width; ?>%" align="<?php echo $align; ?>"<?php echo ($column == 'full_name') ? ' nowrap="nowrap"' : ''; ?> style="border-bottom:1px dashed #ddd;">
												<?php echo $value; ?>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php 
									$serialNumber++;
								endforeach; 
								if (!empty($report_data['totals'])): ?>
									<tr style="background-color:#f9f9f9; font-weight:bold;">
										<td align="center">#</td>
										<?php foreach ($visibleTableColumns as $index => $column): 
											$width = ($column == 'full_name') ? $fixedFullNameWidth : $dynamicColWidth;
											$align = ($column == 'full_name') ? 'left' : 'center';
										?>
											<td width="<?php echo $width; ?>%" align="<?php echo $align; ?>"<?php echo ($column == 'full_name') ? ' nowrap="nowrap"' : ''; ?>>
												<?php
													if ($index === 0) {
														echo 'Total';
													} elseif (in_array($column, ['order_date', 'date', 'created_at', 'updated_at'])) {
														echo '';
													} elseif (isset($report_data['totals'][$column])) {
														$value = $report_data['totals'][$column];
            											echo (floor($value) == $value) ? number_format($value, 0) : number_format($value, 2);
													} else {
														echo '';
													}
												?>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endif;
							else: ?>
								<tr>
									<td colspan="<?php echo ($totalCols + 1); ?>" align="center">No data available</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</td>
			</tr>
		</table>

	</body>
</html>
