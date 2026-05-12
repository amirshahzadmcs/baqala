<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala Trading Company - Delivery Incentive Slab</title>
    <style>
        * { padding: 0px; margin: 0px; }
        table { border-collapse: collapse; table-layout: fixed; line-height: 1.5; }
        table td { word-wrap: break-word; font-size: 9px; }
    </style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <td colspan="2" valign="center" style="text-align: right; font-size: 24px; line-height: 0px;">
                <img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg'); ?>" height="50px">
            </td>
        </tr>
        <tr>
            <td valign="top" style="width:32%; text-align: left; font-size: 20px; line-height: 20px;">
                <strong>Delivery Incentive Slab</strong><br>
                <strong> قائمة حوافز التوصيل </strong>
            </td>
            <td valign="center" style="width:68%;">
                <table border="0" cellspacing="0" cellpadding="5" style="width: 100%; font-size: 11px;">
                    <tr>
                        <td style="border-bottom:1px solid #ddd;"></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr style="background-color: #f1f1f1;">
            <td align="center" style="width:5%;font-size:10px;">S.No.</td>
            <td align="center" style="width:22%;font-size:10px;">Incentive Name</td>
            <td align="center" style="width:12%;font-size:10px;">Incentive Period</td>
            <td align="center" style="width:7%;font-size:10px;">Target</td>
            <td align="center" style="width:8%;font-size:10px;">Deduction</td>
            <td align="center" style="width:9%;font-size:10px;">Daily Bonus</td>
            <td align="center" style="width:11%;font-size:10px;">Monthly Bonus</td>
            <td align="center" style="width:10%;font-size:10px;">No. of Riders</td>
            <td align="center" style="width:8%;font-size:10px;">Status</td>
            <td align="center" style="width:9%;font-size:10px;">Date</td>
        </tr>

        <?php
        $i = 1;
        if (!empty($detail)) {
            foreach ($detail as $row) {
        ?>
            <tr>
                <td align="center"><?php echo $i++; ?></td>
                <td align="center"><?php echo htmlspecialchars($row->incentive_name); ?></td>
                <td align="center"><?php echo htmlspecialchars($row->incentive_period); ?></td>
                <td align="center"><?php echo htmlspecialchars($row->target); ?></td>
                <td align="center"><?php echo htmlspecialchars($row->deduction); ?></td>
                <td align="center"><?php echo htmlspecialchars($row->daily_bonus); ?></td>
                <td align="center"><?php echo htmlspecialchars($row->monthly_bonus); ?></td>
                <td align="center"><?php echo htmlspecialchars($row->total_riders); ?></td>
                <td align="center"><?php echo ($row->status == 'active') ? 'Active' : 'Inactive'; ?></td>
                <td align="center"><?php echo date('d-m-Y', strtotime($row->created_at)); ?></td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="10" align="center" style="font-size: 12px;">No records found.</td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
