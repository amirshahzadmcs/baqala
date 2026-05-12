<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        * {
            padding: 0px;
            margin: 0px;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px;
        }
    </style>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
        <tr>
            <td></td>
        </tr>
    </table>
    <table width="100%" border="1" cellspacing="0" cellpadding="5">
            <tr>
                <td width="23%" valign="top" style="text-align: left; font-weight: bold;">Department: Logistic</td>
                <td width="36%" valign="top" style="text-align: left; font-weight: bold;"><?php echo $team->id==9 ? 'Aggregator:' : 'Location:';?></td>
                <td width="18%" valign="top" style="text-align: left; font-weight: bold;">Team: <?php echo $team->name; ?></td>
                <td width="23%" valign="top" style="text-align: left; font-weight: bold;">Date: <?php echo date('d-m-Y'); ?></td>
            </tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="4">
        <tr>
            <td bgcolor="#000000" style="color: #ffffff; width: 5%; text-align: center;"><strong>S.No.</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Vehicle No.</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Emp.ID</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 24%; text-align: left;"><strong>Employee Name</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Platform ID</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 10%; text-align: center;"><strong>Timing</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 8%; text-align: center;"><strong>Km</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 8%; text-align: center;"><strong>Delivery</strong></td>
            <td bgcolor="#000000" style="color: #ffffff; width: 15%; text-align: center;"><strong>(Duty: P/A) and Signature</strong></td>
        </tr>
    </table>
</body>

</html>