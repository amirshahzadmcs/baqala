<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Daily Fuel Consumption Report</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>

	<table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">

        <tr style="background-color:#f1f1f1;">
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:4%;" align="center">S.No.</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Vehicle No.</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Vehicle Type</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Allotment Status</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Vehicle Category</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Emp No.</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:22%;" align="left">Employee Name</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Date</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Fuel Consumption</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Order Completed</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Avg Per Order</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;" align="center">Avg Order Per Day</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:8%;" align="center">Aggregator</td>
            <td style="border-top:1px solid #000;border-bottom:1px solid #000;width:6%;" align="center">Aggregator ID</td>
        </tr>

        <?php if (!empty($fuel_reports)) {
            $count = 1;

            // Totals
            $total_fuel = 0.0;                // sum of cost (fuel consumption)
            $total_all_orders = 0;            // sum of all orders
            $total_avg_per_order_sum = 0.0;   // sum of avg_per_order values (for average-of-averages)
            $total_avg_per_order_count = 0;   // count of rows that have avg_per_order

            foreach ($fuel_reports as $item) {

                // Safe array values (use before display)
                $vehicle_no       = $item['vehicle_no'] ?? 'NA';
                $vehicle_type     = $item['vehicle_type'] ?? 'NA';
                $allotment_status = $item['allotment_status'] ?? 'NA';
                $vehicle_category = $item['vehicle_category'] ?? 'NA';
                $emp_no           = $item['emp_no'] ?? 'NA';
                $full_name        = $item['full_name'] ?? 'NA';
                $fuel_date        = $item['fuel_date'] ?? '';

                // Orders (define BEFORE using $total_orders)
                $hunger = isset($item['hunger_orders']) ? (int)$item['hunger_orders'] : 0;
                $jahez  = isset($item['jahez_orders']) ? (int)$item['jahez_orders'] : 0;
                $noon   = isset($item['noon_orders']) ? (int)$item['noon_orders'] : 0;

                // Fuel cost / consumption
                $total_cost = isset($item['cost']) ? (float)$item['cost'] : 0.0;

                // Compute orders & averages
                $total_orders = $hunger + $jahez + $noon;
                $avg_per_order = $total_orders > 0 ? round($total_cost / $total_orders, 2) : "-";
                $avg_order_day = "-"; // keep same placeholder

                // Accumulate totals
                $total_fuel += $total_cost;
                $total_all_orders += $total_orders;
                if ($avg_per_order !== "-") {
                    $total_avg_per_order_sum += $avg_per_order;
                    $total_avg_per_order_count++;
                }

                // Allotment label
                if ($allotment_status == "alloted")         $allot_txt = "Alloted";
                elseif ($allotment_status == "unalloted")  $allot_txt = "Unalloted";
                elseif ($allotment_status == "return")     $allot_txt = "Return";
                else $allot_txt = "NA";

                // Aggregator Fields
                $aggregator    = !empty($item['company_name']) ? ucfirst($item['company_name']) : '-';
                $aggregator_id = !empty($item['id_number']) ? $item['id_number'] : '-';
                ?>

                <tr>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $count++; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $vehicle_no; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= ucfirst($vehicle_type); ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $allot_txt; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= ucfirst($vehicle_category); ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $emp_no; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="left"><?= $full_name; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center">
                        <?= !empty($fuel_date) ? date("d-m-Y", strtotime($fuel_date)) : 'NA'; ?>
                    </td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= number_format($total_cost, 2); ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $total_orders; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $avg_per_order; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $avg_order_day; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;" align="center"><?= $aggregator; ?></td>
                    <td style="border-top:1px solid #000;border-bottom:1px solid #000;" align="center"><?= $aggregator_id; ?></td>
                </tr>

            <?php } // end foreach

            // Prepare final average for "Avg Per Order" column
            $final_avg_per_order = $total_avg_per_order_count > 0
                ? round($total_avg_per_order_sum / $total_avg_per_order_count, 2)
                : "-";
            ?>

            <tr style="background-color:#f1f1f1;">
                <td colspan="8" align="right" style="border-top:1px solid #000;border-bottom:1px solid #000;font-weight:600;">TOTAL</td>

                <!-- Total Fuel Consumption -->
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;" align="center">
                    <?= number_format($total_fuel, 2); ?>
                </td>

                <!-- Total Orders Completed -->
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;" align="center">
                    <?= $total_all_orders; ?>
                </td>

                <!-- Average of Avg Per Order -->
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;" align="center">
                    <?= $final_avg_per_order; ?>
                </td>

                <!-- Avg Order Per Day (placeholder) -->
                <td style="border-top:1px solid #000;border-bottom:1px solid #000;" align="center">-</td>

                <!-- Aggregator / ID (not applicable in totals) -->
                <td colspan="2" style="border-top:1px solid #000;border-bottom:1px solid #000;" align="center">-</td>
            </tr>

        <?php } else { ?>
            <tr>
                <td colspan="14" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
            </tr>
        <?php } ?>

    </table>

</body>

</html>
