<?php
$visibleTableColumns = $report_data['visible_columns'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Noon Daily COD Summary</title>
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
		$fixedColumns = ['full_name', 'vendor_name'];
		$fixedWidthPx = 150;
		$totalFixed = 0;

		// count fixed columns
		foreach ($visibleTableColumns as $col) {
			if (in_array($col, $fixedColumns)) {
				$totalFixed += $fixedWidthPx;
			}
		}

		// remaining width for dynamic columns
		$remainingCols = array_filter($visibleTableColumns, fn($col) => !in_array($col, $fixedColumns));
		$dynamicWidth = (count($remainingCols) > 0) ? round((1000 - $totalFixed) / count($remainingCols)) : 60; // 980px ≈ 98% of A4 width
		?>
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 8px; width: 98%;">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="2" width="100%">
						<thead>
							<tr style="background-color: #f5d880;">
								<th width="20px" align="center">#</th>
								<?php foreach ($visibleTableColumns as $column): 
									$isFixed = in_array($column, $fixedColumns);
									$width = $isFixed ? $fixedWidthPx : $dynamicWidth;
									$align = ($isFixed || $column == 'emp_no') ? 'left' : 'center';
								?>
									<th width="<?php echo $width; ?>px" align="<?php echo $align; ?>"<?php echo $isFixed ? ' nowrap="nowrap"' : ''; ?>>
										<?php echo strtoupper(str_replace('_', ' ', $column)); ?>
									</th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php 
							if (!empty($report_data['data'])) {
								$serialNumber = 1;
								foreach ($report_data['data'] as $detail): ?>
									<tr>
										<td align="center" style="border-bottom:1px dashed #ddd;"><?php echo $serialNumber++; ?></td>
										<?php foreach ($visibleTableColumns as $column): 
											$isFixed = in_array($column, $fixedColumns);
											$width = $isFixed ? $fixedWidthPx : $dynamicWidth;
											$align = ($isFixed || $column == 'emp_no') ? 'left' : 'center';
										?>
											<td width="<?php echo $width; ?>px" align="<?php echo $align; ?>" style="border-bottom:1px dashed #ddd;"<?php echo $isFixed ? ' nowrap="nowrap"' : ''; ?>>
												<?php
													if (!empty($detail[$column])) {
														if (in_array($column, ['ops_date', 'created_at', 'updated_at'])) {
															echo date("d-m-Y", strtotime($detail[$column]));
														} else {
															echo htmlspecialchars($detail[$column]);
														}
													}
												?>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>

								<?php if (!empty($report_data['totals'])): ?>
									<tr style="background-color:#f9f9f9; font-weight:bold;">
										<td align="center">#</td>
										<?php foreach ($visibleTableColumns as $index => $column): 
											$isFixed = in_array($column, $fixedColumns);
											$width = $isFixed ? $fixedWidthPx : $dynamicWidth;
											$align = ($isFixed || $column == 'emp_no') ? 'left' : 'center';
										?>
											<td width="<?php echo $width; ?>px" align="<?php echo $align; ?>"<?php echo $isFixed ? ' nowrap="nowrap"' : ''; ?>>
												<?php
													if ($index === 0) {
														echo "Total";
													} elseif (in_array($column, ['ops_date', 'created_at', 'updated_at'])) {
														echo '';
													} elseif (isset($report_data['totals'][$column])) {
														echo number_format($report_data['totals'][$column], 2);
													}
												?>
											</td>
										<?php endforeach; ?>
									</tr>
								<?php endif; ?>

							<?php } else { ?>
								<tr>
									<td colspan="<?php echo count($visibleTableColumns) + 1; ?>" align="center">No data available</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

				</td>
			</tr>
		</table>

	</body>
</html>
