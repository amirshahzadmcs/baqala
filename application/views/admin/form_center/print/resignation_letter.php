<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Resignation Letter</title>
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
			Maha Al Fala Trading Company<br/>
			Riyadh, Saudi Arabia.</p>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<!-- Row 3: Subject -->
		<tr>
			<td>
				Subject: <b><u>Resignation</u></b>
			</td>
		</tr>
		
		<!-- Row 4: Dear Employee Name -->
		<tr>
			<td>
				Dear Sir/Madam,
			</td>
		</tr>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td>
				<p style="text-align: justify;">I, <b><?= $employee_data['emp_detail']['full_name'] ?></b>, holding Saudi Iqama Number <b><?= $employee_data['emp_detail']['iqama_no'] ?></b> and <b><?php echo $employee_data['emp_detail']['nationality_name'];?></b> Passport Number - <b><?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?></b>, working as <?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?> for <?php echo (($employee_data['emp_detail']['sponsor_name'] !=='') ? $employee_data['emp_detail']['sponsor_name'] : 'NA');?>. I would like to resign from my current job due to personal reasons.</p>
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td>
				<p style="text-align: justify;">I affirm that Maha Al Fala Trading Company holds NO responsibility for any losses or consequences arising from my decision to resign.</p>
			</td>
		</tr>
		
		<!-- Row 7: Reminder -->
		<tr>
			<td>
				<?php
					if (!empty($form_center['other_details'])) {
						$otherDetail = json_decode($form_center['other_details']);
						$last_working_date = $otherDetail->last_working_date ?? '';
					} else {
						$last_working_date = '';
					}
				?>
				<p style="text-align: justify;">Please accept my resignation and consider <?= date('d M Y', strtotime($last_working_date)) ?> as my last working day in the Company.</p>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px; margin-top: 50px;">
        <tr>
			<td style="text-align: left;">Sincerely</td>
		</tr>
		<tr>
			<td style="text-align: left; padding-top: 50px;">
				<b><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?></b><br>
				Date - <?= date('d M Y', strtotime($form_center['date_of_issue'])) ?>
			</td>
		</tr>
    </table>
</body>

</html>
