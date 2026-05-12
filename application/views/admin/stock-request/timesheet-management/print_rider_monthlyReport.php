<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <!-- first page start here -->
    <table cellpadding="5" cellspacing="10">
        <tr>
            <td>
                <table>
                    <tr>
                        <td style="width:50%;">
                            <table cellpadding="5">
                                <tr>
                                    <td style="background-color: black; color:#fff;">
                                        Amanullah Z Kazi
                                    </td>
                                </tr>
                                <tr>
                                    <td><span>COO<br />Management<br />Main Branch</span></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%;">
                            <table cellpadding="5">
                                <tr>
                                    <th style="background-color: black; color:#fff; ">
                                        Start Date
                                    </th>
                                    <th style="background-color: black; color:#fff; ">
                                        End Date
                                    </th>
                                    <th style="background-color: black; color:#fff; ">
                                        Status
                                    </th>
                                </tr>
                                <tr>
                                    <td><?php echo $start_date; ?></td>
                                    <td><?php echo $end_date; ?></td>
                                    <td>Pending</td>
                                </tr>
                            </table>
                            <!-- <table cellpadding="5">
                                <tr>
                                    <th style="background-color: black; color:#fff; ">
                                        Fiscal Year Start Date
                                    </th>
                                </tr>
                                <tr>
                                    <td><?php //echo $financial_year_start_date; 
                                        ?></td>
                                </tr>
                            </table> -->
                        </td>
                    </tr>

                </table>


                <table>
                    <tr>
                        <td hspace="7" vspace="10">
                            <h3 style="margin-bottom: 10px;">Attendance Information</h3>
                        </td>
                    </tr>
                </table>


                <table cellpadding="10">
                    <tr>
                        <td></td>
                    </tr>
                </table>



                <table cellpadding="5">
                    <tr style="background-color: black; color:#fff;">
                        <th style="padding:7px 8px;">
                            Total Working Days
                        </th>
                        <th hspace="5">
                            Expected Working Hours
                        </th>
                        <th>
                            Actual Working Hours
                        </th>
                    </tr>

                    <tr>
                        <td>0</td>
                        <td><?php echo 12 * 26; ?></td>
                        <td><?php echo $total_working_hours; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="line-height:0px;"></td>
                    </tr>
                </table>


                <table cellpadding="5">
                    <tr style="background-color: black; color:#fff;">
                        <th>
                            Total Present Days
                        </th>
                        <th>
                            Total Absence Days
                        </th>
                        <th>
                            Total Leaves
                        </th>
                    </tr>
                    <tr>
                        <td><?php echo $present_days; ?></td>
                        <td><?php echo $absent_days; ?></td>
                        <td><?php echo $total_leaves; ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="line-height:0px;"></td>
                    </tr>
                </table>



                <table cellpadding="5">
                    <tr>
                        <td style="background-color: black; color:#fff; width:46%;">
                            Total Sign In Only
                        </td>
                        <!-- <td style="background-color: black; color:#fff; width:23%;">
                            Total Sign Out Only
                        </td> -->
                        <td style="width:8%;"></td>
                        <td style="background-color: black; color:#fff; width:23%;">
                            Total Delay
                        </td>
                        <td style="background-color: black; color:#fff; width:23%;">
                            Total Early Leave
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $sign_in_only_days; ?></td>
                        <!-- <td><?php //echo $sign_out_only_days; 
                                    ?></td> -->
                        <td></td>
                        <td>0 Day(s) (0 Min(s))</td>
                        <td>0 Day(s) (0 Min(s))</td>
                    </tr>
                </table>
                <table cellpadding="5">
                    <tr>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    <!-- first page end here -->
    <table>
        <tr>
            <td style="height: 300px;"></td>
        </tr>
    </table>
    <!-- second page start here -->

    <table cellpadding="5" cellspacing="10">
        <tr>
            <td>
                <table cellpadding="5">
                    <tr>
                        <th style="background-color: black; color:#fff; width:35%;">
                            Employee
                        </th>
                        <th style="background-color: black; color:#fff; width:25%;">
                            Attendance Sheet
                        </th>
                        <th style="width:10%;"></th>
                        <th style="width:14%;"></th>
                        <th style="width:16%;"></th>
                    </tr>
                    <tr>
                        <td><?php echo $rider_name; ?></td>
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <table cellpadding="5">
                    <tr>
                        <td hspace="7" vspace="0">
                            <h3>Attendance Information</h3>
                        </td>
                    </tr>
                </table>

                <table cellpadding="5">
                    <tr>
                        <th style="background-color: black; color:#fff; width:25%;">
                            Date
                        </th>
                        <th style="background-color: black; color:#fff; width:30%;">
                            Sign In
                        </th>
                        <th style="background-color: black; color:#fff; width:30%;">
                            Total Working Hours
                        </th>
                        <th style="background-color: black; color:#fff; width:15%;">
                            Status
                        </th>
                    </tr>
                </table>

                <table cellpadding="2" style="font-size:10px;">

                    <?php foreach ($final_report as $entry) { ?>
                        <tr>
                            <td style="width:25%;"><?php echo date('d/m/Y', strtotime($entry->created_at)); ?></td>
                            <td style="width:30%;"><?php echo !empty($entry->in_time) ? date('h:i:s A', strtotime($entry->in_time)) : '-'; ?></td>
                            <!-- <td><?php //echo !empty($entry->out_time) ? date('h:i:s A',strtotime($entry->out_time)) : '-'; 
                                        ?></td> -->
                            <td style="width:30%;"><?php echo !empty($entry->working_hours) ? $entry->working_hours : '-'; ?></td>
                            <td style="width:15%;"><?php echo (empty($entry->in_time) && empty($entry->out_time)) ? '-' : 'Working'; ?></td>
                        </tr>
                        <!-- <tr style="border-bottom:1px dashed #ccc"><td colspan="5"></td></tr> -->
                    <?php } ?>
                </table>
            </td>
        </tr>

    </table>


    <!-- third table end -->
</body>

</html>