<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if ($search_month) {
    $date = DateTime::createFromFormat('Y-m', $search_month);
    $num_days = (int) $date->format('t'); // number of days in month
} else {
    echo "<p>Invalid month format</p>";
    return;
}
?>
<html lang="ae">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Monthly Fuel Report</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td, table th {word-wrap:break-word;}
            .mark_bold { font-weight:bold; }
            .grey-background { background:#eee; }
		</style>
	</head>
	<body>
		<h3 align="center">
            Monthly Fuel Report — <?= date('F Y', strtotime($search_month . '-01')) ?>
        </h3>
		<table border="1" cellspacing="0" cellpadding="3" style="font-size: 9px; width: 100%;">
			<tr>
                <td align="center" class="mark_bold" style="width:25px;">#</td>
                <td align="center" class="mark_bold" style="width:50px;">Emp ID</td>
                <td align="center" class="mark_bold" style="width:200px;">Name</td>
                <td align="center" class="mark_bold" style="width:55px;">Vehicle No</td>
                <td align="center" class="mark_bold" style="width:50px;">V. Type</td>
                <td align="center" class="mark_bold" style="width:65px;">Fuel Consumption</td>
                <td align="center" class="mark_bold" style="width:65px;">Order Completed</td>
                <?php for ($day = 1; $day <= $num_days; $day++): ?>
                <td align="center" colspan="2" style="width:81px;background-color:#99CC66;"><?= $day .' '. date('M', strtotime($search_month . '-01')) ?></td>
                <?php endfor; ?>
            </tr>
            <tr>
                <td colspan="7"></td>
                <?php for ($day = 1; $day <= $num_days; $day++): ?>
                    <td align="center" class="mark_bold" style="background-color:#66CCCC;">F</td>
                    <td align="center" class="mark_bold" style="background-color:#FFCC33;">O</td>
                <?php endfor; ?>
            </tr>
            <?php if (!empty($employees)): ?>
                <?php 
                $grand_total_cost = 0;
                $grand_total_orders = 0;
                $daily_totals = [];
                $i = 1;
                ?>
                <?php foreach ($employees as $emp): ?>
                    <?php 
                    $total_cost = 0;
                    $total_orders = 0;
                    ?>
                    <tr>
                        <td align="center"><?= $i++; ?></td>
                        <td align="center"><?= $emp['emp_no'] ?? '-' ?></td>
                        <td style="text-align:left;"><?= $emp['full_name'] ?? '-' ?></td>
                        <td align="center"><?= $emp['vehicle_no'] ?? '-' ?></td>
                        <td align="center"><?= ucfirst($emp['vehicle_type']) ?? '-' ?></td>
                        <td align="center" class="mark_bold"><?= number_format(array_sum(array_column($emp['days'], 'cost')), 2) ?></td>
                        <td align="center" class="mark_bold"><?= array_sum(array_column($emp['days'], 'orders')) ?></td>

                        <?php for ($day = 1; $day <= $num_days; $day++): ?>
                            <?php 
                            $cost   = $emp['days'][$day]['cost'] ?? 0;
                            $orders = $emp['days'][$day]['orders'] ?? 0;

                            // add to daily totals
                            if (!isset($daily_totals[$day])) {
                                $daily_totals[$day] = ['cost' => 0, 'orders' => 0];
                            }
                            $daily_totals[$day]['cost']   += $cost;
                            $daily_totals[$day]['orders'] += $orders;

                            $weekday = date('N', strtotime($search_month . '-' . sprintf('%02d',$day)));
                            $isWeekend = ($weekday >= 5);
                            ?>
                            <td align="center" class="<?= $isWeekend ? 'grey-background' : '' ?>"><?= $cost > 0 ? number_format($cost, 2) : '-' ?></td>
                            <td align="center" class="<?= $isWeekend ? 'grey-background' : '' ?>"><?= $orders > 0 ? $orders : '-' ?></td>
                            <?php 
                            $total_cost   += $cost;
                            $total_orders += $orders;
                            ?>
                        <?php endfor; ?>

                    </tr>
                    <?php 
                    $grand_total_cost += $total_cost;
                    $grand_total_orders += $total_orders;
                    ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?= ($num_days * 2) + 7 ?>" align="center">
                        No fuel consumption data available
                    </td>
                </tr>
            <?php endif; ?>

            <?php if (!empty($employees)): ?>
            <tfoot>
                <tr style="background-color:#f3ffdf; font-weight:bold;">
                    <td colspan="5" align="right">Grand Total</td>
                    <td align="center"><?= number_format($grand_total_cost, 2) ?></td>
                    <td align="center"><?= $grand_total_orders ?></td>
                    <?php for ($day = 1; $day <= $num_days; $day++): ?>
                        <td align="center"><?= number_format($daily_totals[$day]['cost'], 2) ?></td>
                        <td align="center"><?= $daily_totals[$day]['orders'] ?></td>
                    <?php endfor; ?>
                </tr>
            </tfoot>
            <?php endif; ?>
		</table>
	</body>
</html>
