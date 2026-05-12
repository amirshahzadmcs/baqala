<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Monthly Performance Report</title>
    <style>
        * {
            padding: 0px;
            margin: 0px;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
        }

        table td {
            word-wrap: break-word;
        }
    </style>
</head>

<body>

    <table border="0" cellspacing="0" cellpadding="2" style="font-size: 11px; width: 100%;">
        <tr>
            <td>
                <table class="table" width="100%" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td colspan="11" style="border-bottom:1px solid #000"></td>
                    </tr>
                    <tr style="background-color: #f8cbad;">
                        <td valign="top" style="width: 5%;text-align:center;"><strong>Sr.No.</strong></td>
                        <td valign="top" style="width: 8%;text-align:center;"><strong>Emp No.</strong></td>
                        <td valign="top" style="width: 21%;text-align:left;"><strong>Employee Name</strong></td>
                        <td valign="top" style="width: 10%;text-align:center;"><strong>Iqama Number</strong></td>
                        <td valign="top" style="width: 10%;text-align:center;"><strong>Iqama Expiry</strong></td>
                        <td valign="top" style="width: 7%;text-align:center;"><strong>Mobile No</strong></td>
                        <td valign="top" style="width: 7%;text-align:center;"><strong>Id Number</strong></td>
                        <td valign="top" style="width: 11%;text-align:center;"><strong>Platform</strong></td>
                        <td valign="top" style="width: 7%;text-align:center;"><strong>ID Type</strong></td>
                        <td valign="top" style="width: 7%;text-align:center;"><strong>Vehicle No</strong></td>
                        <td valign="top" style="width: 7%;text-align:center;"><strong>Status</strong></td>
                    </tr>
                    <tr>
                        <td colspan="11" style="border-top:3px solid #000;line-height:2px;"></td>
                    </tr>
                    <?php $i = 1;
                    foreach ($team_member as $member) {
                    ?>
                        <tr class="item-list">
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $i++; ?>.</td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->emp_no; ?></td>
                            <td valign="bottom" style="text-align:left;line-height:15px;"><?php echo $member->full_name; ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->iqama_no; ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo date('d-m-Y', strtotime($member->iqama_expiry_date)); ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->mobile; ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->hunger_id; ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->company_name; ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->id_type; ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->vehicle_no; 
                                                                                            ?></td>
                            <td valign="bottom" style="text-align:center;line-height:15px;"><?php echo $member->rider_status; ?></td>
                        </tr>
                        <!-- <tr>
                            <td valign="middle" colspan="13" style="border-top:1px dashed #ddd;line-height:0px;"></td>
                        </tr> -->
                    <?php } ?>
                    <!-- <tr><td colspan="12"></td></tr>
						<tr><td colspan="12" style="border-top: 1px solid #000;line-height:-10px;"></td></tr> -->
                </table>
            </td>
        </tr>
    </table>
</body>

</html>