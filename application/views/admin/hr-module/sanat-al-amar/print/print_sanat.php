<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Maha Al Fala - Sanat Al Amar</title>
		<style>
			*{padding:0px;margin:0px;}
			table {border-collapse:collapse; table-layout:fixed;}
			table td {word-wrap:break-word;}
		</style>
	</head>
	<body>
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 8px; width: 100%;">
            <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="2">
                        <thead>
                            <tr style="background-color: #f5d880;">
                                <th width="20px" align="center">#</th>
                                <th width="80px" align="left">Sanat No.</th>
                                <th width="40px" align="left">Emp No.</th>
                                <th width="200px" align="left">Employee Name</th>
                                <th width="60px" align="left">Iqama No.</th>
                                <th width="60px" align="left">Sanat Date</th>
                                <th width="60px" align="left">Sanat Amount</th>
                                <th width="120px" align="left">Sanat Owner</th>
                                <th width="60px" align="center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($sanat_list)) {
                                    $serial = 1;
                                    foreach ($sanat_list as $row) {
                                ?>
                                <tr>
                                    <td style="border-bottom:1px dashed #ddd;text-align:center;"><?php echo $serial++;?>.</td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo $row['sanat_no'];?></td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo $row['emp_no'];?></td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo $row['full_name'];?></td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo $row['iqama_no'];?></td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo date('d-m-Y', strtotime($row['sanat_date']));?></td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo number_format($row['sanat_amount'], 2);?></td>
                                    <td style="border-bottom:1px dashed #ddd"><?php echo $row['sanat_owner'];?></td>
                                    <td style="border-bottom:1px dashed #ddd;text-align:center;"><?php echo ucfirst($row['status']);?></td>
                                </tr>
                                <?php }} else {
                                    echo "<tr><td colspan='9' align='center'>No data available</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

	</body>
</html>
