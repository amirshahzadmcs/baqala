<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Jahez Cash Report</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
			.remark-good {
				color: green;
			}

			.remark-needs-focus {
				color: #E26310;
			}

			.remark-low-performer {
				color: red;
			}

		</style>
	</head>
	<body>
		<?php
        // ensure variables exist
        $reports = isset($reports) && is_array($reports) ? $reports : [];
        $cod_report = isset($reports['cod_report']) && is_array($reports['cod_report']) ? $reports['cod_report'] : [];
        $debit_report = isset($reports['debit_report']) && is_array($reports['debit_report']) ? $reports['debit_report'] : [];
        $total_cod = isset($reports['total_cod']) ? (float)$reports['total_cod'] : 0;
        $total_debit = isset($reports['total_debit']) ? (float)$reports['total_debit'] : 0;
        // if model returned total_deliveries (from cod side) use it, otherwise compute from arrays
        $total_deliveries_cod = isset($reports['total_deliveries']) ? (int)$reports['total_deliveries'] : array_sum(array_column($cod_report, 'total_deliveries'));
        $total_deliveries_debit = array_sum(array_column($debit_report, 'total_deliveries'));
        ?>
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
            <tr>
                <td>
                    <table class="table" width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 12px;">
                        <tr>
                            <?php
                            if ($search_start_date !== 'NA' && $search_start_date !== $search_end_date) {
                                $date_range = $search_start_date . ' - ' . $search_end_date;
                            } elseif ($search_start_date !== 'NA' && $search_start_date == $search_end_date) {
                                $date_range = $search_start_date;
                            } else {
                                $date_range = 'ALL';
                            }
                            ?>
                            <td valign="middle" style="text-align:left;color:#000;">
                                <?= ($team_name !== '') ? $team_name : 'Team - ALL'; ?>
                            </td>
                            <td colspan="6" valign="middle" style="text-align:right;color:#000;">
                                Jahez - Cash Summary Report - <?= $date_range; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!-- ============ COD TABLE ============ -->
        <table class="table" width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size: 10px;margin-top:10px;">
            <tr>
                <th colspan="9" style="background-color:#fbe5d6; text-align:left;">Jahez Rider with COD Amount</th>
            </tr>
            <tr>
                <th width="33px" align="center" style="background-color: #feec90;color:#8b600b;">Sr. No</th>
                <th width="53px" align="center" style="background-color: #feec90;color:#8b600b;">Emp ID</th>
                <th width="211px" style="background-color: #feec90;color:#8b600b;">Emp Name</th>
                <th width="60px" align="center" style="background-color: #feec90;color:#8b600b;">Rider ID</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">Vehicle Type</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">Completed Deliveries</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">COD</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">Driver Debit</th>
                <th width="72px" align="center" style="background-color: #feec90;color:#8b600b;">Driver Credit</th>
            </tr>

            <?php if (!empty($cod_report)) : ?>
                <?php $count = 1; foreach ($cod_report as $row): ?>
                    <tr>
                        <td align="center"><?= $count++; ?></td>
                        <td align="center"><?= htmlspecialchars($row['emp_no'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['full_name'] ?? '') ?></td>
                        <td align="center"><?= htmlspecialchars($row['driver_id'] ?? '') ?></td>
                        <td align="center"><?= htmlspecialchars($row['vehicle_type'] ? ucfirst($row['vehicle_type']) : '') ?></td>
                        <td align="center"><?= number_format((float)($row['total_deliveries'] ?? 0)) ?></td>
                        <td align="center"><?= number_format((float)($row['total_cod'] ?? 0), 2) ?></td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                    </tr>
                <?php endforeach; ?>

                <tr style="font-weight:bold;">
                    <td colspan="5" align="right">Total COD</td>
                    <td align="center"><?= number_format($total_deliveries_cod) ?></td>
                    <td align="center"><?= number_format($total_cod, 2) ?></td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="9" align="center">No data available</td>
                </tr>
            <?php endif; ?>
        </table>  
        <!-- ============ DEBIT TABLE ============ -->
        <table class="table" width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size: 10px;margin-top:20px;">
            <tr>
                <th colspan="9" style="background-color:#fbe5d6; text-align:left;">Jahez Rider with Debit</th>
            </tr>
            <tr>
                <th width="33px" align="center" style="background-color: #feec90;color:#8b600b;">Sr. No</th>
                <th width="53px" align="center" style="background-color: #feec90;color:#8b600b;">Emp ID</th>
                <th width="211px" style="background-color: #feec90;color:#8b600b;">Emp Name</th>
                <th width="60px" align="center" style="background-color: #feec90;color:#8b600b;">Rider ID</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">Vehicle Type</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">Completed Deliveries</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">COD</th>
                <th width="70px" align="center" style="background-color: #feec90;color:#8b600b;">Driver Debit</th>
                <th width="72px" align="center" style="background-color: #feec90;color:#8b600b;">Driver Credit</th>
            </tr>

            <?php if (!empty($debit_report)) : ?>
                <?php $count = 1; foreach ($debit_report as $row): ?>
                    <tr>
                        <td align="center"><?= $count++; ?></td>
                        <td align="center"><?= htmlspecialchars($row['emp_id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['full_name'] ?? '') ?></td>
                        <td align="center"><?= htmlspecialchars($row['driver_id'] ?? '') ?></td>
                        <td align="center"><?= htmlspecialchars($row['vehicle_type'] ? ucfirst($row['vehicle_type']) : '') ?></td>
                        <td align="center"><?= number_format((float)($row['total_deliveries'] ?? 0)) ?></td>
                        <td align="center">-</td>
                        <td align="center"><?= number_format((float)($row['total_debit'] ?? 0), 2) ?></td>
                        <td align="center">-</td>
                    </tr>
                <?php endforeach; ?>

                <tr style="font-weight:bold;">
                    <td colspan="5" align="right">Total Debits</td>
                    <td align="center"><?= number_format($total_deliveries_debit) ?></td>
                    <td align="center">-</td>
                    <td align="center"><?= number_format($total_debit, 2) ?></td>
                    <td align="center">-</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="9" align="center">No data available</td>
                </tr>
            <?php endif; ?>
        </table>

	</body>
</html>
