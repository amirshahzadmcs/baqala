<?php
$visibleTableColumns = $report_data['available_columns'];
$summaryDetails = $report_data['data'];

$uniqueRiders = [];
$completedDeliveries = 0;
$totalPaybleAmount = 0;

// Calculate required values
foreach ($summaryDetails as $detail) {
    if (!empty($detail['emp_no'])) {
        $uniqueRiders[$detail['emp_no']] = true;
    }
    $completedDeliveries += (int) ($detail['delivered_orders'] ?? 0);
	$totalPaybleAmount += (int) ($detail['total_payable_amount'] ?? 0);
}

$nosRiders = count($uniqueRiders);
$averagePerRider = $nosRiders > 0 ? round($completedDeliveries / $nosRiders, 2) : 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Monthly Sales Report</title>
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
					<table class="table" width="100%" border="0" cellspacing="1" cellpadding="3" style="font-size: 10px;">

						<tr><td colspan="8" style="line-height:0px;color:#aaaaaa;">*Note: Please select (Completed Orders and Basic Payment) columns to view calculation of Total Completed Orders, Average Per Rider and Total Basic Payments</td></tr>
						<tr><td colspan="8" style="border-bottom: 1px solid #000;line-height:0px;width:102%;"></td></tr>
						<tr>
							<td valign="middle" style="width: 13%;text-align:center;color:red;background-color:#ffc7ce;">No's Riders</td>
							<td valign="middle" style="width: 12%;text-align:center;color:red;"><?php echo $nosRiders; ?></td>
							<td valign="middle" style="width: 13%;text-align:center;color:green;background-color:#c6efce;">Total Completed Orders</td>
							<td valign="middle" style="width: 12%;text-align:center;color:green;"><?php echo $completedDeliveries; ?></td>
							<td valign="middle" style="width: 13%;text-align:center;color:red;background-color:#ffc7ce;">Average Per Rider</td>
							<td valign="middle" style="width: 12%;text-align:center;color:red;"><?php echo $averagePerRider; ?></td>
							<td valign="middle" style="width: 13%;text-align:center;color:green;background-color:#c6efce;">Total Payble Amount</td>
							<td valign="middle" style="width: 12%;text-align:center;color:green;"><?php echo $totalPaybleAmount; ?></td>
						</tr>
						<tr><td colspan="8" style="border-top: 1px solid #000;line-height:0px;width:102%;"></td></tr>
					</table>
					<table border="0" cellspacing="0" cellpadding="2">
						<thead>
							<tr style="background-color: #f5d880;">
								<th width="20px" align="center">#</th>
								<?php
									foreach ($visibleTableColumns as $column) {
										$cleanedHeader = str_replace(['mkss.', 'me.'], '', $column);
								?>
									<th <?php echo ($cleanedHeader == 'full_name') ? 'width="150px" align="left"' : ' width="65px" align="center"';?>><?php echo strtoupper(str_replace('_', ' ', $cleanedHeader)); ?></th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
							<?php 
								if (!empty($summaryDetails)) {
									$serialNumber = 1;
									foreach ($summaryDetails as $detail) {
							?>
								<tr>
									<td align="center" style="border-bottom:1px dashed #ddd"><?php echo $serialNumber++; ?></td>
									<?php
										foreach ($visibleTableColumns as $column) {
											$cleanedColumn = strtolower(str_replace(['mkss.', 'me.'], '', $column));
											$detailKeys = array_change_key_case($detail);

									?>
										<td <?php echo ($cleanedColumn == 'full_name') ? ' align="left" ' : (($cleanedColumn == 'emp_no' || $cleanedColumn == 'courier_id' || $cleanedColumn == 'id' || $cleanedColumn == 'emp_id') ? ' align="center" ' : ' align="right" ');?> style="border-bottom:1px dashed #ddd">
											<?php 
												$value = $detailKeys[$cleanedColumn] ?? '[NA]';
												echo (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : $value;
											?>
										</td>
									<?php } ?>
								</tr>
							<?php
									}
								} else {
									echo "<tr><td colspan='" . (count($visibleTableColumns) + 1) . "'>No data available</td></tr>";
								}
							?>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
