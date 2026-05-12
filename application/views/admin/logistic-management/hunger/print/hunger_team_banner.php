<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        * {
            padding: 0px;
            margin: 0px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <table border="0" cellspacing="0" cellpadding="1" style="width: 100%;">
        <tr>
            <td><img src="<?php echo base_url('admin_assets/images/vehicle-timesheet/header-top.jpg'); ?>" style="max-width: 100%;" /></td>
        </tr>
    </table>
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
        <tr>
            <td width="22%" valign="top" style="text-align: left; font-weight: bold;">Department: Logistic</td>
            <td width="36%" valign="top" style="text-align: left; font-weight: bold;"><?php echo $team->id==9 ? 'Aggregator:' : 'Location:';?></td>
            <td width="18%" valign="top" style="text-align: left; font-weight: bold;">Team: <?php echo $team->name; ?></td>
            <td width="24%" valign="top" style="text-align: left; font-weight: bold;">Date:</td>
        </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="4">
        <tr>
            <td bgcolor="#000000" style="color: #ffffff; width: 5%; text-align: center;"><strong>S.No.</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 7%; text-align: center;"><strong>Emp. ID</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 30%; text-align: left;"><strong>Employee Name</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Mobile No.</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 9%; text-align: center;"><strong>Platform ID</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 9%; text-align: center;"><strong>Vehicle No.</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Vehicle Type</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Delivery</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Remark</strong></td>
        </tr>
    </table>
</body>

</html>