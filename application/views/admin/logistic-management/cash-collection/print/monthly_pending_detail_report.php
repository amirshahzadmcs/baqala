<?php
    $cash_details = $cash_details ?? []; // Ensure it's at least an empty array
    if (!empty($cash_details)) { 
    ?>
    <table border="0" cellspacing="0" cellpadding="3" style="width: 90%;font-size: 10px;">
        <tr>
            <td align="center" colspan="5" style="background-color:#155f82;color:#fff;font-weight:bold;font-size:12px;">
                Employee List / قائمة الموظفين
            </td>
        </tr>
        <!-- Table Header -->
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:8%;">Sr. No.</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:10%;">EMP ID</td>
            <td align="left" style="border-top:1px solid #000;border-bottom:1px solid #000;width:37%;">EMP Name</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:15%;">Driver ID</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:15%;">Date</td>
            <td align="right" style="border-top:1px solid #000;border-bottom:1px solid #000;width:15%;">Amount</td>
        </tr>

        <?php
        $grand_total = 0;
        $sr_no = 1;

        // Group cash details by employee
        $grouped = [];
        foreach ($cash_details as $detail) {
            $grouped[$detail['emp_id']]['name'] = $detail['full_name'];
            $grouped[$detail['emp_id']]['emp_no'] = $detail['emp_no'];
            $grouped[$detail['emp_id']]['details'][] = $detail;
            $grouped[$detail['emp_id']]['total'] = ($grouped[$detail['emp_id']]['total'] ?? 0) + (float)$detail['pending_amount'];
            $grand_total += (float)$detail['pending_amount'];
        }

        // Loop through grouped employees
        foreach ($grouped as $emp_id => $emp_data) {
            $employee_total = $emp_data['total'];
            $bg_color = ($employee_total > 300) ? '#ffcccc' : '#ccffcc'; // red if >300 else green
        ?>
            <!-- Employee Total Row -->
            <tr style="background-color: <?= $bg_color; ?>;">
                <td align="center" style="font-weight:bold;"><?= $sr_no++; ?></td>
                <td align="center" style="font-weight:bold;"><?= $emp_data['emp_no']; ?></td>
                <td style="font-weight:bold;"><?= $emp_data['name']; ?></td>
                <td colspan="2" style="font-weight:bold;">&nbsp;</td>
                <td align="right" style="font-weight:bold;"><?= number_format($employee_total, 2); ?></td>
            </tr>

            <!-- Employee Details Rows -->
            <?php foreach ($emp_data['details'] as $d) { ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="center"><?= $d['driver_id']; ?></td>
                    <td align="center"><?= date('d-m-Y', strtotime($d['order_date'])); ?></td>
                    <td align="right"><?= number_format($d['pending_amount'], 2); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>

        <!-- Grand Total -->
        <tr>
            <td colspan="5" align="right" style="border-top:2px solid #000;font-weight:bold;">Grand Total:</td>
            <td align="right" style="border-top:2px solid #000;font-weight:bold;"><?= number_format($grand_total, 2); ?></td>
        </tr>
    </table>
<?php } ?>