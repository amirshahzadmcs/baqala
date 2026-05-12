<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala Trading Company - Iqama Renewal List</title>
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
            <td valign="top" style="width:20%; text-align: left; font-size: 20px; line-height: 20px;">
                <strong>Iqama Renewal List</strong><br>
                <strong> قائمة تجديد الإقامة </strong>
            </td>
            <td valign="center" style="width:80%;">
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
    <?php
    // Initialize counters
    $totalEmployee = 0;
    $totalExpired = 0;
    $totalExpiringSoon = 0;
    $totalValid = 0;
    $totalPolicyExpired = 0;
    $totalPolicyValid = 0;

    // Loop through data and count
    if (!empty($detail['data'])) {
        foreach ($detail['data'] as $row) {
            $totalEmployee++;

            // Iqama Status
            if ($row->iqama_status_category == 'Expired') {
                $totalExpired++;
            } elseif ($row->iqama_status_category == 'Expiring Soon') {
                $totalExpiringSoon++;
            } elseif (strpos($row->iqama_status_category, 'Valid') !== false) {
                $totalValid++;
            }

            // Policy Status
            if ($row->insurance_status_category == 'Expired') {
                $totalPolicyExpired++;
            } elseif (strpos($row->insurance_status_category, 'Valid') !== false) {
                $totalPolicyValid++;
            }
        }
    }
    ?>

    <table border="0" cellspacing="0" cellpadding="2" style="width: 100%;font-size: 12px;">
        <tr>
            <td colspan="7"></td>
        </tr>
        <?php
            //Filters applied
            $filter_applied = isset($filter_applied) ? $filter_applied : [];
            if (!empty($filter_applied['employeer_id'])) {
                $employer_name = $this->db->get_where('sponsors', ['id' => $filter_applied['employeer_id']])->row()->employer_name ?? 'All Employers';
            } else {
                $employer_name = 'All Employers';

            }
        ?>
        <tr style="background-color:#f1f1f1;">
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:20%;font-size: 11px;">Employer Name</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:13%;font-size: 11px;">Total Employee</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:14%;font-size: 11px;">Total Expired Iqama</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:14%;font-size: 11px;">Total Expiring Iqama</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:13%;font-size: 11px;">Total Valid Iqama</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:13%;font-size: 11px;">Total Expired Policy</td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:13%;font-size: 11px;">Total Valid Policy</td>
        </tr>
        <tr>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:20%;font-size: 11px;"><?php echo $employer_name; ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:13%;font-size: 11px;"><?php echo $totalEmployee; ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:14%;font-size: 11px;"><?php echo $totalExpired; ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:14%;font-size: 11px;"><?php echo $totalExpiringSoon; ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:13%;font-size: 11px;"><?php echo $totalValid; ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;width:13%;font-size: 11px;"><?php echo $totalPolicyExpired; ?></td>
            <td align="center" style="border-top:1px solid #000;border-bottom:1px solid #000;width:13%;font-size: 11px;"><?php echo $totalPolicyValid; ?></td>
        </tr>
        <tr>
            <td colspan="7"></td>
        </tr>
    </table>

    <table border="1" cellspacing="0" cellpadding="3" style="width: 100%;">
        <tr style="background-color: #f1f1f1;">
            <td align="center" style="width:4%;font-size:11px;">S.No.</td>
            <td align="center" style="width:6%;font-size:11px;">Emp. No.</td>
            <td align="center" style="width:19%;font-size:11px;">Employee Name</td>
            <td align="center" style="width:11%;font-size:11px;">Job Title</td>
            <td align="center" style="width:7%;font-size:11px;">Iqama No.</td>
            <td align="center" style="width:7%;font-size:11px;">Nationality</td>
			<td align="center" style="width:7%;font-size:11px;">Employeer ID</td>
            <td align="center" style="width:7%;font-size:11px;">Iqama Expiry Date</td>
            <td align="center" style="width:7%;font-size:11px;">Iqama Status</td>
            <td align="center" style="width:8%;font-size:11px;">Policy Expiry Date</td>
            <td align="center" style="width:7%;font-size:11px;">Policy Status</td>
            <td align="center" style="width:10%;font-size:11px;">DL Status</td>
        </tr>

        <?php
        $i = 1;
        $dl_status_map = [
            '0' => 'DL Appointment',
            '1' => 'DL File',
            '2' => 'DL Class 1',
            '3' => 'DL Class 2',
            '4' => 'DL Computer Exam',
            '5' => 'DL Final Test',
            '6' => 'DL Repeat Exam',
            '7' => 'DL Medical',
            '8' => 'DL Basma',
            '9' => 'DL Issued',
        ];
        if (!empty($detail['data'])) {
            foreach ($detail['data'] as $row) {

                // Determine row color
                $bgcolor = '';
                if ($row->iqama_status_category == 'Expired') {
                    $bgcolor = '#f8d7da'; // light red
                } elseif ($row->iqama_status_category == 'Expiring Soon') {
                    $bgcolor = '#ffe8bd'; // light yellow
                } elseif (strpos($row->iqama_status_category, 'Valid') !== false) {
                    $bgcolor = '#d4edda'; // light green
                }
        ?>
        <tr style="background-color: <?php echo $bgcolor; ?>;">
            <td align="center"><?php echo $i++; ?></td>
            <td align="center"><?php echo $row->emp_no; ?></td>
            <td align="left"><?php echo $row->full_name; ?></td>
            <td align="center"><?php echo $row->designation_name; ?></td>
            <td align="center"><?php echo $row->iqama_no; ?></td>
            <td align="center"><?php echo $row->nationality_name; ?></td>
			<td align="center"><?php echo $row->employer_id; ?></td>
            <td align="center">
                <?php echo !empty($row->iqama_expiry_date) ? date('d-m-Y', strtotime($row->iqama_expiry_date)) : ''; ?>
            </td>
            <td align="center"><?php echo $row->iqama_status_category; ?></td>
            <td align="center">
                <?php echo !empty($row->policy_expiry) ? date('d-m-Y', strtotime($row->policy_expiry)) : ''; ?>
            </td>
            <td align="center"><?php echo $row->insurance_status_category; ?></td>
            <td align="center">
                <?php
                    if (!empty($row->driving_license_number)) {
                        echo 'DL Issued';
                    }else{
                        if ($row->dl_status2 == 'Cancelled') {
                            echo 'Cancelled';
                        } else {
                            echo isset($dl_status_map[$row->dl_status]) ? $dl_status_map[$row->dl_status] : 'NA';
                        }
                    }
                ?>
            </td>
        </tr>
        <?php
            }
        } else {
        ?>
        <tr>
            <td colspan="11" align="center">No records found.</td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>
