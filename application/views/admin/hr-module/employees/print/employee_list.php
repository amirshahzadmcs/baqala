<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Employee List</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
		</style>
	</head>
	<body>
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 8px; width: 98%;">
            <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="2">
                        <thead>
                            <tr style="background-color: #f5d880;">
                                <th width="20px" align="center">#</th>
                                <?php
                                foreach ($headers as $label => $key) {
                                    if (in_array($label, ['Payment Type Detail', 'Id', 'Employee Pic'])) continue;
                                    if($label == 'Full Name') {
                                ?>
                                    <th width="150px"><?php echo strtoupper($label);?></th>
                                <?php }else{ ?>
                                    <th><?php echo strtoupper($label);?></th>
                                <?php }} ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($emp_list)) {
                                    $serial = 1;
                                    foreach ($emp_list as $row) {
                                        echo "<tr>";
                                    ?>
                                        <td style="border-bottom:1px dashed #ddd"><?php echo $serial;?></td>
                                    <?php
                                        foreach ($headers as $label => $key) {
                                            if (in_array($label, ['Payment Type Detail', 'Id', 'Employee Pic'])) continue; // Skip the original JSON field

                                            // Handle payment_type_detail subfields
                                            if (in_array($label, ['Account Type', 'Bank Name', 'IBAN No'])) {
                                                $paymentData = json_decode($row['payment_type_detail'] ?? '{}', true);
                                                if (is_array($paymentData)) {
                                                    switch ($label) {
                                                        case 'Account Type':
                                                            $value = $paymentData['account_type'] ?? '-';
                                                            break;
                                                        case 'Bank Name':
                                                            $value = $paymentData['bank_name'] ?? '-';
                                                            break;
                                                        case 'IBAN No':
                                                            $value = $paymentData['iban_no'] ?? '-';
                                                            break;
                                                    }
                                                } else {
                                                    $value = '-';
                                                }
                                            } else {
                                                $value = isset($row[$key]) ? $row[$key] : '-';
                                                $value = ($value === null || $value === '') ? '-' : $value;
                                            
                                                // Format dates
                                                if ((stripos($key, 'date') !== false || stripos($key, 'dob') !== false) && strtotime($value)) 													{
                                                    $value = date('d-m-Y', strtotime($value));
                                                }
                                            }   
											
											// Apply terminate_reason condition
											if ($key == 'terminate_reason') {
												$value = ($row['status'] == 'Active') ? '' : $row['terminate_reason'];
												$value = ($value === null || $value === '') ? '-' : $value;
											} else {
												$value = ($value === null || $value === '') ? '-' : $value;
											}

                                            // Format dates
                                            if ((stripos($key, 'date') !== false || stripos($key, 'dob') !== false) && strtotime($value)) {
                                                $value = date('d-m-Y', strtotime($value));
                                            }
                                        ?>
                                            <td style="border-bottom:1px dashed #ddd"><?= $value;?></td>
                                        <?php
                                        }

                                        echo "</tr>";
                                        $serial++;
                                    }
                                } else {
                                    echo "<tr><td colspan='" . (count($headers) + 1) . "' align='center'>No data available</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

	</body>
</html>
