<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Baqala Station - Job Card</title>
    <style>
        * {
            padding: 0px;
            margin: 0px
        }
    </style>
</head>

<body>
    <table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
        <tr>
            <td colspan="2" style="border-top:30px solid #35aa59"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="2"><img src="<?php echo base_url('admin_assets/images/vehicle-timesheet/header-top.jpg'); ?>" style="max-width: 100%;" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
                    <tr>
                        <td colspan="3" style="width: 97%;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                                <?php
                                $from = $this->input->get('from', TRUE);
                                $to = $this->input->get('to', TRUE);
                                if ($from && $to) { ?>
                                    <tr>
                                        <td width="14%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="2">Department:</td>
                                        <td width="34%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="3">Logistic</td>
                                        <td width="14%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="1">Date:</td>
                                        <td width="40%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="4">Date Range: <?php echo $from . ' - ' . $to; ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td width="14%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="2">Department:</td>
                                        <td width="34%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="3">Logistic</td>
                                        <td width="14%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="1">Date:</td>
                                        <td width="40%" valign="top" bgcolor="#c6efce" style="text-align: center; font-weight: bold;" colspan="4">All</td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <table width="100%" border="1" cellspacing="0" cellpadding="5">

                                <tr>
                                    <td valign="top" bgcolor="#c6efce" style="width: 6%; text-align: center;"><strong>Sr. No</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Emp No</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 24%; text-align: center;"><strong>Employee Name</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Vehicle No</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 14%; text-align: center;"><strong>Platform</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 9%; text-align: center;"><strong>Out Time</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Km</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 7%; text-align: center;"><strong>Battery (%)</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Working Hours</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>OTP Verified</strong></td>
                                </tr>
                                <?php $item_row = 1;
                                foreach ($timesheet as $data) { ?>
                                    <tr>
                                        <td valign="top" style="text-align: center;"><?php echo $item_row; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->emp_no; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->employee_name; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo strtoupper($data->vehicle_no); ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->company_name; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo date('H:i A', strtotime($data->out_time)); ?></td>
                                        <!-- <td valign="top" style="text-align: center;"><?php //echo $data->in_time != null ? date('H:i A', strtotime($data->in_time)) : ''; 
                                                                                            ?></td> -->
                                        <td valign="top" style="text-align: center;"><?php echo (int)$data->out_km; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->out_battery; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->working_hours; ?></td>
                                        <!-- <td valign="top" style="text-align: center;"><?php //echo $data->in_km != null ? $data->in_km - $data->out_km : ''; 
                                                                                            ?></td>
                                        <td valign="top" style="text-align: center;"><?php //echo $data->in_battery != null ? $data->out_battery - $data->in_battery : ''; 
                                                                                        ?></td> -->
                                        <td valign="top" style="text-align: center;"><?php echo $data->is_otp_verified; ?></td>
                                    </tr>
                                <?php $item_row = $item_row + 1;
                                } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>

</html>