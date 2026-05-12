<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Weekly Shift Allotment Sheet</title>
    <style>
        .red-strikethrough {
            color: red;
            text-decoration: line-through;
            text-decoration-color: red;
        }

        .area_color {
            color: red;
        }
    </style>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="2" style="font-size: 10px; width: 100%;">
        <tr>
            <td>

            </td>
        </tr>
        <tr>
            <td>
                <table class="table" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
                    <tr>
                        <td width="50px" align="center" rowspan="2" style="background-color:#231f20;color:#fff;font-size:12px;vertical-align: middle;">Emp. Code</td>
                        <td width="165px" align="center" rowspan="2" style="background-color:#231f20;color:#fff;font-size:12px;vertical-align: middle;">Rider's Name</td>
                        <td width="20px" align="center" rowspan="2" style="background-color:#231f20;color:#fff;vertical-align: middle;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/header/date-week.png'); ?>" style="height:30px;"></td>
                        <td width="120px" align="center" colspan="2" style="background-color:#231f20;color:#fff;font-size:12px;">Sunday</td>
                        <td width="100px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Monday</td>
                        <td width="100px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Tuesday</td>
                        <td width="100px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Wednesday</td>
                        <td width="100px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Thursday</td>
                        <td width="100px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Friday</td>
                        <td width="100px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Saturday</td>
                        <td width="60px" align="center" style="background-color:#231f20;color:#fff;font-size:12px;">Working Hours</td>
                    </tr>
                    <tr style="background-color:#231f20;color:#fff;font-size:12px;">
                        <?php foreach ($dateOfWeek as $key => $date): ?>
                            <td colspan="<?php echo $key == 0 ? '2' : '' ?>" align="center"><?php echo date('d-m-Y', strtotime($date)); ?></td>
                        <?php endforeach; ?>
                        <td></td>
                    </tr>

                    <?php foreach ($shiftsByEmployee as $employee) : ?>
                        <?php
                        $maxShifts = max(array_map('count', $employee['shifts']));
                        for ($i = 0; $i < $maxShifts; $i++) :
                            $rowClass = ($i % 2 == 0) ? 'even-row' : 'odd-row';
                        ?>
                            <tr>
                                <?php if ($i === 0) : ?>
                                    <td width="50px" rowspan="<?php echo $maxShifts; ?>"><?php echo $employee['emp_no']; ?></td>
                                    <td valign="middle" width="165px" rowspan="<?php echo $maxShifts; ?>"><?php echo $employee['rider_name']; ?></td>
                                    <td width="20px" rowspan="<?php echo $maxShifts; ?>" class="shift-cell" style="background-color:#e6e7e9;"><img src="<?php echo base_url('admin_assets/images/header/shift.png'); ?>"></td>
                                <?php endif; ?>
                                <td align="center" style="background-color:#e6e7e9;color:#000;width:20px;"><?php echo $i + 1; ?></td>

                                <?php $totalHours = '00:00';
                                foreach ($employee['shifts'] as $shifts) :
                                    if (isset($shifts[$i])) : ?>
                                        <td align="center" width="100px"><?php echo $shifts[$i]['shift_detail']; ?></td>
                                    <?php
                                        list($hours, $minutes) = explode(':', $shifts[$i]['working_hours']);
                                        $totalHours = sprintf('%02d:%02d', (int)$totalHours + (int)$hours, (int)$totalHours + (int)$minutes);
                                    else : ?>
                                        <td style="color:red" align="center" width="100px">No Shift</td> <?php
                                                                                                        endif;
                                                                                                    endforeach;
                                                                                                            ?>
                                <td align="center" width="60px"><?php echo $totalHours; ?></td>
                            </tr>
                        <?php endfor; ?>
                    <?php endforeach; ?>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>