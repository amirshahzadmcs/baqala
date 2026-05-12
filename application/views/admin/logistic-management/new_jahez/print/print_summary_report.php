<?php
// Sample placeholders if not already defined
$search_keyword = $search_keyword ?? '';
$search_start_date = $search_start_date ?? 'NA';
$search_end_date = $search_end_date ?? 'NA';
$reports = $reports ?? [];
?>

<!DOCTYPE html>
<html lang="ae">
<head>
    <meta charset="UTF-8" />
    <title>Maha Al Fala - Jahez Daily Summary Report</title>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
        <tr>
            <td>
                <table class="table" width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 12px;">
                    <tr>
                        <?php
                        if ($search_start_date !== 'NA' && $search_start_date !== $search_end_date) {
                            $data_range = $search_start_date . ' - ' . $search_end_date;
                        } elseif ($search_start_date !== 'NA') {
                            $data_range = $search_start_date;
                        } else {
                            $data_range = '';
                        }

                        $total_deliveries = isset($reports['total_deliveries']) ? $reports['total_deliveries'] : 0;
                        $total_riders = isset($reports['total_riders']) ? $reports['total_riders'] : 0;
                        $average_per_rider = ($total_riders > 0) ? round($total_deliveries / $total_riders, 2) : 0;
                        ?>
                        <td valign="middle" style="text-align:right;color:red;"><?php echo ($search_keyword) ? $search_keyword : 'All Riders'; ?></td>
                        <td colspan="4" valign="middle" style="text-align:right;color:red;">Jahez - Delivery Report <?php echo ($data_range !== '') ? '(' . $data_range . ')' : ''; ?></td>
                        <td colspan="2" valign="middle" style="text-align:right;color:red;">Completed Deliveries</td>
                        <td valign="middle" style="text-align:center;background-color:#c6efce;color:green;"><strong><?= $total_deliveries; ?></strong></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <?php if (!empty($reports['details'])) { ?>
                    <table class="table" width="100%" border="0" cellspacing="1" cellpadding="3" style="font-size: 10px;">
                        <tr><td colspan="7" style="border-bottom: 1px solid #000;line-height:0px;"></td></tr>
                        <tr>
                            <td colspan="2" style="width: 17%;text-align:center;color:red;background-color:#ffc7ce;">No's Riders</td>
                            <td style="width: 28%;text-align:center;color:red;"><?= $total_riders; ?></td>
                            <td style="width: 15%;text-align:center;color:red;background-color:#ffc7ce;">Total Delivery</td>
                            <td style="width: 13%;text-align:center;color:red;"><?= $total_deliveries; ?></td>
                            <td style="width: 14%;text-align:center;color:red;background-color:#ffc7ce;">Average Per Rider</td>
                            <td style="width: 13%;text-align:center;color:red;"><?= round($average_per_rider); ?></td>
                        </tr>
                        <tr><td colspan="7" style="border-top: 1px solid #000;line-height:0px;"></td></tr>
                    </table>
                <?php } ?>

                <table class="table" width="100%" border="1" cellspacing="0" cellpadding="5">
                    <tr style="background-color: #f5d880;">
                        <td style="width: 5%;text-align:center;"><strong>No.</strong></td>
                        <td style="width: 9%;text-align:center;"><strong>Rider ID</strong></td>
                        <td style="width: 8%;text-align:center;"><strong>Emp ID</strong></td>
                        <td style="width: 39%;text-align:center;"><strong>Employee Name</strong></td>
                        <td style="width: 9%;text-align:center;"><strong>Delivery Date</strong></td>
                        <td style="width: 11%;text-align:center;"><strong>Completed Deliveries</strong></td>
						<td style="width: 10%;text-align:center;"><strong>Vehicle Type</strong></td>
						<td style="width: 9%;text-align:center;"><strong>Vehicle No.</strong></td>
						<!--
                        <td style="width: 9%;text-align:center;"><strong>COD Amount</strong></td>
                        <td style="width: 9%;text-align:center;"><strong>Price</strong></td>
                        <td style="width: 9%;text-align:center;"><strong>Driver Debit Amt. / Penalty</strong></td>
                        <td style="width: 9%;text-align:center;"><strong>Driver Credit Amt. / Reversal</strong></td>
						-->
                    </tr>

                    <?php if (!empty($reports['details'])) {
                        $i = 1;
                        foreach ($reports['details'] as $report) {
                            $fine = floatval($report['fine'] ?? 0);
                            $penalty = floatval($report['penalty'] ?? 0);
                            $deduction = floatval($report['service_deduction'] ?? 0);
                            $credit = floatval($report['driver_credit'] ?? 0);
                            $cod = $report['cash_collection'] ?? $report['total_cash_collection'] ?? '0.00';
                            $total_amount = $report['total_amount'] ?? '0.00';
                            $deliveries = $report['deliveries'] ?? $report['total_deliveries'] ?? '0';
                            ?>
                            <tr>
                                <td style="text-align:center;"><?= $i++; ?>.</td>
                                <td style="text-align:center;"><?= $report['driver_id'] ?? '[NA]'; ?></td>
                                <td style="text-align:center;"><?= $report['emp_no'] ?? '[NA]'; ?></td>
                                <td><?= $report['full_name'] ?? '[NA]'; ?></td>
                                <td style="text-align:center;"><?= isset($report['order_date']) ? date("d-m-Y", strtotime($report['order_date'])) : 'NA'; ?></td>
                                <td valign="top" style="text-align:center;"><?php echo ($report['deliveries'] < 15) ? '<span style="color:red;"><b>'.$report['deliveries'] .'</b></span>' : '<span style="color:green;"><b>'.$report['deliveries'].'</b></span>';?></td>
								<td style="text-align:center;"><?= ($report['vehicle_type']) ? ucfirst($report['vehicle_type']) : 'NA'; ?></td>
								<td style="text-align:center;"><?= ($report['vehicle_no']) ? $report['vehicle_no'] : 'NA'; ?></td>
                                <!--
								<td style="text-align:right;"><?= number_format((float)$cod, 2); ?></td>
                                <td style="text-align:right;"><?= number_format((float)$total_amount, 2); ?></td>
                                <td style="text-align:right;"><?= number_format($fine + $penalty + $deduction, 2); ?></td>
                                <td style="text-align:right;"><?= number_format($credit, 2); ?></td>
								-->
                            </tr>
                        <?php }
                    } else { ?>
                        <tr><td colspan="10" align="center">No data found, Try another filter</td></tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
