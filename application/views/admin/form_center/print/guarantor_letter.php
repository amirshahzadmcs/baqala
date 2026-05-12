<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Guarantee the Payment</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px;">
		<!-- Row 1: Date and Empty Cell -->
		<tr>
			<td style="text-align: right;"><?php echo date('l, d F, Y', strtotime($form_center['date_of_issue'])); ?></td>
		</tr>
		<!-- Row 2: To and Employee Details -->
		<tr>
			<td>
			<p>To,<br/>
			The HR Manager<br/>
			Maha Al Fala Trading Est.<br/>
			Riyadh<br>
			Kingdom of Saudi Arabia.</p>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<!-- Row 3: Subject -->
		<tr>
			<td>
				Subject: <b><u>Guarantee the Payment</u></b>
			</td>
		</tr>
		
		<!-- Row 4: Dear Employee Name -->
		<tr>
			<td>
				Dear Sir,
			</td>
		</tr>
		<tr>
			<td>
				Peace be upon you,
			</td>
		</tr>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td>
				<p style="text-align: justify;">I, <b><?= $guarantor_data['emp_no'] ?> <?= $guarantor_data['full_name'] ?>, <?= $guarantor_data['nationality'] ?></b> National, holding Saudi Iqama/ID Number <b><?= $guarantor_data['iqama_no'] ?></b>, hereby issue this Guarantee Letter in favor of Employee <b><?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : '');?> <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?>, <?php echo $employee_data['emp_detail']['nationality_name'];?></b> National, holding Saudi Iqama/ID Number <b><?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?></b>, in relation to his balance dues in Maha Al Fala Trading Company amounting to <b>SAR <?= number_format($due_amount, 2) ?> (<?= convert_sar_to_words($due_amount) ?>)</b>.</p>
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td>
				<p style="text-align: justify;">I unconditionally and irrevocably guarantee the payment of all dues from <?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : '');?> <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?>. I undertake full responsibility to cover any outstanding payments up to the amount of <b>SAR <?= number_format($guarantor_data['amount'], 2) ?> (<?= convert_sar_to_words($guarantor_data['amount']) ?>)</b>.</p>
			</td>
		</tr>
		
		<!-- Row 7: Reminder -->
		<tr>
			<td>
				<p style="text-align: justify;">This guarantee shall remain valid and enforceable until <b><?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : '');?> <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?></b> fully pays all his dues to Maha Al Fala Trading Company.</p>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<!-- Row 8: Sincerely -->
		<tr>
			<td>
				<p> Regards,<br><br><br>
				<?= $guarantor_data['emp_no'] ?>_<?= $guarantor_data['full_name'] ?><br>
				ID No: - <?= $guarantor_data['iqama_no'] ?><br>
				Mobile No: - <?= $guarantor_data['contact_no'] ?></p>
			</td>
		</tr>
	</table>
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px; margin-top: 50px;">
        <tr>
            <td>
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px;">
                    <tr>
                        <td style="width: 50%; text-align: left;">Signature</td>
                        <td style="width: 50%; text-align: left;">Thumb Impression</td>
                    </tr>
                    <tr>
                        <td style="width: 50%; text-align: left;height:80px;">
                        
                        </td>
                        <td style="width: 50%; text-align: left;height:80px;">
                        
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
