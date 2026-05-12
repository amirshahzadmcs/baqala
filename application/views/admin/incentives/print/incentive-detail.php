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
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table border="0" cellspacing="0" cellpadding="2" style="width: 100%;font-size: 12px;">
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td align="left" colspan="6" style="width:100%;font-size: 11px;">Incentive Information</td>
        </tr>
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:16%;font-size: 10px;">Incentive Name</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Incentive Period</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Monthly Target</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:16%;font-size: 10px;">Deduction (< Traget)</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Daily Bonus (30+)</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Monthly Bonus (700+)</td>
        </tr>
        <tr>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:16%;font-size: 10px;"><?php echo $incentive_info->incentive_name;?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;font-size: 10px;"><?php echo $incentive_info->incentive_period;?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;font-size: 10px;"><?php echo $incentive_info->target;?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:16%;font-size: 10px;"><?php echo $incentive_info->deduction;?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;font-size: 10px;"><?php echo $incentive_info->daily_bonus;?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;"><?php echo $incentive_info->monthly_bonus;?></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:16%;font-size: 10px;">Acceptance Rate Penalty (450)</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Acceptance Rate Penalty (-450)</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Contact Rate Penalty (450)</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:16%;font-size: 10px;">Acceptance Rate Penalty (-450)</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Decline Penalty</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;">Status</td>
        </tr>
        <tr>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:16%;font-size: 10px;"><?php echo ucfirst($incentive_info->acceptance_penalty_450);?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;font-size: 10px;"><?php echo ucfirst($incentive_info->acceptance_penalty_less_450);?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;font-size: 10px;"><?php echo ucfirst($incentive_info->contact_penalty_450);?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:16%;font-size: 10px;"><?php echo ucfirst($incentive_info->contact_penalty_less_450);?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:17%;font-size: 10px;"><?php echo ucfirst($incentive_info->decline_penalty);?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:17%;font-size: 10px;"><?php echo ucfirst($incentive_info->status);?></td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="2" style="width: 100%;font-size: 12px;">
        <tr><td></td></tr>
        <tr>
            <td align="left" style="width:100%;font-size: 11px;">Incentive Slabs</td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="width:6%;font-size:10px;">S.No.</td>
            <td align="center" style="width:47%;font-size:10px;">Slab</td>
            <td align="center" style="width:47%;font-size:10px;">Commission</td>
        </tr>
        <?php
        $i = 1;
        if(count($incentive_slabs) > 0){
            foreach($incentive_slabs as $slab){
        ?>
            <tr>
                <td align="center"><?php echo $i++; ?></td>
                <td align="center"><?php echo $slab['slab_start']; ?> -  <?php echo $slab['slab_end']; ?></td>
                <td align="center"><?php echo $slab['commission']; ?></td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="3" align="center" style="font-size: 11px;">No records found.</td>
            </tr>
        <?php
        }
        ?>
    </table>

    <table border="0" cellspacing="0" cellpadding="2" style="width: 100%;font-size: 12px;">
        <tr><td></td></tr>
        <tr>
            <td align="left" style="width:100%;font-size: 11px;">Employee List</td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="width:5%;font-size:10px;">S.No.</td>
            <td align="center" style="width:8%;font-size:10px;">Emp ID</td>
            <td align="center" style="width:32%;font-size:10px;">Employee Name</td>
            <td align="center" style="width:10%;font-size:10px;">Iqama No.</td>
            <td align="center" style="width:9%;font-size:10px;">Mobile</td>
            <td align="center" style="width:9%;font-size:10px;">Vehicle No.</td>
            <td align="center" style="width:7%;font-size:10px;">Type</td>
            <td align="center" style="width:9%;font-size:10px;">Rider ID</td>
            <td align="center" style="width:11%;font-size:10px;">Aggregator</td>
        </tr>
        <?php
        $i = 1;
        if(count($incentive_employees) > 0){
            foreach($incentive_employees as $employee){
        ?>
            <tr>
                <td align="center"><?php echo $i++; ?></td>
                <td align="center"><?php echo $employee['emp_no']; ?></td>
                <td align="left"><?php echo $employee['full_name']; ?></td>
                <td align="center"><?php echo $employee['iqama_no']; ?></td>
                <td align="center"><?php echo $employee['mobile']; ?></td>
                <td align="center"><?php echo $employee['vehicle_no']; ?></td>
                <td align="center"><?php echo $employee['vehicle_type']; ?></td>
                <td align="center"><?php echo $employee['id_number']; ?></td>
                <td align="center"><?php echo $employee['food_company']; ?></td>
            </tr>
        <?php
            }
        } else {
        ?>
            <tr>
                <td colspan="10" align="center" style="font-size: 11px;">No records found.</td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
