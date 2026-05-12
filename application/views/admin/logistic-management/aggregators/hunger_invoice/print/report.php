<?php
$visibleTableColumns = $report_data['visible_columns'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Monthly Sales Invoice</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
		</style>
	</head>
	<body>
		<table border="0" cellspacing="0" cellpadding="0" style="font-size: 8px; width: 98%;">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="2">
						<thead>
							<tr style="background-color: #f5d880;">
								<th width="20px" align="center">#</th>
								<?php
									if (!empty($visibleTableColumns)) {
										foreach ($visibleTableColumns as $column) {
											$styleSet = ($column == 'iban_no') ? 'width="115px" align="left"' : (($column == 'vat_no') ? 'width="72px" align="center"' : 'width="60px" align="center"');
											echo "<th {$styleSet}>" . strtoupper(str_replace('_', ' ', $column)) . "</th>";
										}
									}
								?>
							</tr>
						</thead>
						<tbody>
							<?php 
								if (!empty($report_data['data'])) {
									$serialNumber = 1;
									foreach ($report_data['data'] as $detail) {
								?>
									<tr>
										<td align="center" style="border-bottom:1px dashed #ddd"><?= $serialNumber;?></td>
										<?php
											foreach ($visibleTableColumns as $column) {
										?>
											<td <?php echo ($column == 'iban_no') ? 'width="115px" align="left"' : (($column == 'vat_no') ? 'width="72px" align="center"' : 'width="60px" align="center"');?> style="border-bottom:1px dashed #ddd">
											<?php	
												if ($column == 'invoice_month' && !empty($detail[$column])) {
													echo date("M Y", strtotime($detail[$column]));
												} 
												// Format from_date and to_date
												elseif (in_array($column, ['from_date', 'to_date']) && !empty($detail[$column])) {
													echo date("d M Y", strtotime($detail[$column]));
												} 
												else {
													echo htmlspecialchars($detail[$column]);
												}
											?>
											</td>
										<?php }
										?>
									</tr>
								<?php
										$serialNumber++;
									}
								} else {
									echo "<tr><td colspan='" . (count($visibleTableColumns) + 1) . "' align='center'>No data available</td></tr>";
								}
							?>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
