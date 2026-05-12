<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Baqala Station - Team Attendance</title>
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
            padding: 4px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <?php 
    $item_row = 1;
    $perPage = 40;
    $totalRows = count($timesheet);
    $counter = 0;

    foreach ($timesheet as $data) {
        // Open table on first row OR when starting new page
        if ($counter % $perPage == 0) {
            echo '<table width="100%" border="1" cellspacing="0" cellpadding="4" style="font-size:9px;">';
        }
    ?>
        <tr>
            <td valign="top" style="text-align: center; width: 5%;"><?php echo $item_row; ?></td>
            <td valign="top" style="text-align: center; width: 7%; <?php echo $data->logs ? 'font-weight: bold;' : ''; ?>"><?php echo $data->emp_no; ?></td>
            <td valign="top" style="text-align: left; width: 30%;"><?php echo $data->full_name; ?></td>
            <td valign="top" style="text-align: center; width: 10%;"><?php echo $data->alloted_mobile_no; ?></td>
            <td valign="top" style="text-align: center; width: 9%;"><?php echo $data->id_number; ?></td>
            <td valign="top" style="text-align: center; width: 9%;"><?php echo strtoupper($data->vehicle_no ?? ''); ?></td>
            <td valign="top" style="text-align: center; width: 10%;"><?php echo strtoupper($data->vehicle_type ?? ''); ?></td>
            <td valign="top" style="text-align: center; width: 10%;"></td>
            <td valign="top" style="text-align: center; width: 10%;"></td>
        </tr>
    <?php
        $item_row++;
        $counter++;

        // Close table after 40 rows OR last row
        if ($counter % $perPage == 0 || $counter == $totalRows) {
            echo '</table>';

            // Add page break except on last page
            if ($counter < $totalRows) {
                echo '<div class="page-break"></div>';
            }
        }
    }
    ?>

</body>
</html>
