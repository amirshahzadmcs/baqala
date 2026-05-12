<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala Trading Company - Pending Cash Collection Report</title>
    <style>
        * {
            padding: 0px;
            margin: 0px;
        }
    </style>
</head>

<body>
    <style>
        table {
            border-collapse: collapse;
            table-layout: fixed;
            line-height: 1.5;
        }

        table td {
            word-wrap: break-word;
        }
    </style>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg'); ?>" height="50px"></td>
        </tr>
        <tr>
            <td valign="top" style="width:43%;text-align: left;font-size: 14px;line-height:15px;"><strong>PENDING CASH COLLECTION REPORT</strong><br><strong> تقرير تحصيل النقدية المعلقة </strong></td>
            <td valign="center" style="width:57%;">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
                    <tr>
                        <td style="border-bottom:1px solid #ddd;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
        <tr>
            <td colspan="2" valign="center" style="text-align: right;"><strong>DATE / تاريخ :</strong> <?= ($print_date) ? $print_date : 'NA'; ?></td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
        <tr>
            <td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>CASH COLLECTION DETAILS / تفاصيل تحصيل النقدية</strong></td>
            <td colspan="3" valign="center" style="text-align: right;border-bottom:1px solid #000;"><strong>Date of: <?= date('d-m-Y', strtotime($search_start_date)) .' - '. date('d-m-Y', strtotime($search_end_date)); ?></strong></td>
        </tr>
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:6%;line-height:10px;">S.No<br>فرز</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:8%;line-height:10px;">Emp. ID<br>اسم الموظف</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:35%;line-height:10px;">Employee Name<br>رقم الإقامة</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:8%;line-height:10px;">Driver ID<br>معرف السائق</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:10%;line-height:10px;">COD Amount<br> المبلغ المستحق</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:33%;line-height:10px;">Team Leader<br> قائد الفريق</td>
        </tr>
        <?php
        $total_cash_collection = 0;
        $cash_reports = $cash_reports ?? [];
        if (!empty($cash_reports)) {
        if (count($cash_reports) > 0) {
            $count = 1;
            foreach ($cash_reports as $key => $value) {
                $cash_collection = is_numeric($value['total_pending']) ? (float)$value['total_pending'] : 0;

                // Add to totals
                $total_cash_collection += $cash_collection;
        ?>
                <tr>
                    <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?php echo $count++; ?></td>
                    <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['emp_no']) !== '') ? trim($value['emp_no']) : 'NA'; ?></td>
                    <td style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['full_name']) !== '') ? trim($value['full_name']) : 'NA'; ?></td>
                    <td align="center" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= (trim($value['driver_id']) !== '') ? trim($value['driver_id']) : 'NA'; ?></td>
                    <td align="right" style="border-bottom:1px solid #000;border-right:1px solid #000;"><?= number_format($cash_collection, 2); ?></td>
                    <td align="left" style="border-bottom:1px solid #000;"><?= (trim($value['team_leader_emp_no']) !== '') ? ucfirst($value['team_leader_emp_no']) . ' - ' . ucfirst($value['team_leader_name']) : 'NA'; ?></td>
                    <td style="border-bottom:1px solid #000;"></td>
                </tr>
            <?php } ?>

            <!-- ✅ TOTAL ROW AT BOTTOM -->
            <tr style="background-color:#eaeaea;font-weight:bold;">
                <td colspan="4" align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;">Total</td>
                <td align="right" style="border-top:1px solid #000;border-bottom:2px solid #000;border-right:1px solid #000;"><?= number_format($total_cash_collection, 2); ?></td>
                <td align="center" style="border-top:1px solid #000;border-bottom:2px solid #000;">-</td>
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="6" align="center" style="border-bottom:1px solid #ddd;">No data found</td>
            </tr>
        <?php }}else{ ?>
            <tr>
                <td colspan="6" align="center" style="border-bottom:1px solid #ddd;">No data found, change filter and try again.</td>
            </tr>
        <?php } ?>
    </table>

</body>

</html>