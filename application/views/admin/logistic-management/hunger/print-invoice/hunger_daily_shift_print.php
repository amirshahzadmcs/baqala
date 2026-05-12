<?php
function ordinal($number)
{
    $last_digit = $number % 10;
    $last_two_digits = $number % 100;

    if ($last_digit == 1 && $last_two_digits != 11) {
        return $number . 'st';
    } elseif ($last_digit == 2 && $last_two_digits != 12) {
        return $number . 'nd';
    } elseif ($last_digit == 3 && $last_two_digits != 13) {
        return $number . 'rd';
    } else {
        return $number . 'th';
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Weekly Shift Allotment Sheet</title>

</head>

<body>

    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
        <tr>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <table class="table" width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
                    <tr>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px;vertical-align: middle;width:4%;">SL.No</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px;vertical-align: middle;width:8%;">Car/Bike No.</th>
                        <th align="left" style="background-color:#231f20;color:#fff;font-size:12px;width:16%;">Rider's Name</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px;width:6%;">Out Time</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px; width:17%">1st Shift</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px; width:17%">2nd Shift</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px; width:17%">3rd Shift</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px; width:7%">Km</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px; width:3%">B.%</th>
                        <th align="center" style="background-color:#231f20;color:#fff;font-size:12px; width:5%;">Sign.</th>
                    </tr>

                    <?php $index = 1;
                    foreach ($timesheets as $ts): ?>
                        <tr>
                            <td style="text-align:center;vertical-align:middle;"><?php echo $index++; ?></td>
                            <td style="text-align:center;vertical-align:middle;"><?php echo $ts->vehicle_no; ?></td>
                            <td style="text-align:left;vertical-align:middle;"><?php echo $ts->rider_name; ?></td>
                            <td style="text-align:center;vertical-align:middle;"><?php echo date('g:i A', strtotime($ts->out_time)); ?></td>
                            <?php for ($j = 0; $j < 3; $j++): ?>
                                <td style="text-align:center;vertical-align:middle;"><?= $j < count($ts->hunger_shifts) ? $ts->hunger_shifts[$j]->time : ' -- ' ?></td>
                            <?php endfor; ?>
                            <td style="text-align:center;vertical-align:middle;"><?php echo (int)$ts->out_km; ?></td>
                            <td style="text-align:center;vertical-align:middle;"><?php echo $ts->out_battery; ?></td>
                            <td style="text-align:center;vertical-align:middle;"></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>