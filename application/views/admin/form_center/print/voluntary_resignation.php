<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Resignation</title>
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
		
		<!-- Row 2: To and Employee Details -->
		<tr>
			<td style="width: 50%;">
			<p>To,<br/>
			The HR Manager<br/>
			Maha Al Fala Trading Est.<br/>
			Riyadh<br>
			Kingdom of Saudi Arabia.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p>اىل<br>
				مدير الموارد البشرية<br>
				شركة مها الفلا للتجارة<br>
				الرياض، المملكة العربية السعودية </p>
			</td>
		</tr>
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; text-align: right;"></td>
		</tr>
		<!-- Row 3: Subject -->
		<tr>
			<td style="width: 50%;">
				Subject: <b><u>Resignation</u></b>
			</td>
			<td style="width: 50%; text-align: right;"><u> الموضوع: استقالة </u></td>
		</tr>
		
		<!-- Row 4: Dear Employee Name -->
		<tr>
			<td style="width: 50%;">
				Dear Sir/Madam,
			</td>
			<td style="width: 50%; text-align: right;">
				السيد/السيدة المحترم/ـة،
			</td>
		</tr>
		
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">I, <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?> holding Saudi Iqama Number <?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?> and <?php echo $employee_data['emp_detail']['nationality_name'];?> Passport Number <?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?>, working as <?php echo $employee_data['emp_detail']['designation_name'];?> for Maha Al Fala Trading Company. I would like to resign from my current job due to personal reason. I'm requesting you to proceed my Final Exit.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: justify;">أنا، <?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : '');?> حامل الهوية السعودية رقم <?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?> وجواز السفر رقم <?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?>، والعامل كـ <?php echo $employee_data['emp_detail']['designation_arabic_name'];?> في شركة مها الفلا للتجارة. أود أن أقدم استقالتي من وظيفتي الحالية بسبب أسباب شخصية. أطلب منكم ترتيب خروجي النهائي. </p>
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">I affirm that Maha Al Fala Trading Company holds No responsibility for any losses or consequences arising from my decision to resign and return to <?php echo (($employee_data['emp_detail']['passport_country_name'] !=='') ? $employee_data['emp_detail']['passport_country_name'] : 'NA');?></p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: justify;">أؤكد أن شركة مها الفلا للتجارة ليس لها أي مسؤولية عن أي خسائر أو عواقب تنشأ عن قراري بالاستقالة والعودة إلى <?php echo (($employee_data['emp_detail']['passport_country_arabic'] !=='') ? $employee_data['emp_detail']['passport_country_arabic'] : 'NA');?></p>
			</td>
		</tr>
		
		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">Please accept my resignation and consider <?php echo $data['issue_date']; ?> as my last working day in the Company.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: justify;">يرجى قبول استقالتي والنظر في <?php echo $data['issue_date']; ?> كآخر يوم عمل لي في الشركة.</p>
			</td>
		</tr>
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; text-align: right;"></td>
		</tr>
		<!-- Row 8: Sincerely -->
		<tr>
			<td style="width: 50%;">
				<p> Sincerely,<br><br><br>
				 <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?>,<br>
				 Date - <?php echo $data['issue_date']; ?></p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p> مخلصكم<br><br><br>
				 <?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : '');?> <br>
				 التاريخ - <?php echo $data['issue_date']; ?> </p>
			</td>
		</tr>
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; text-align: right;"></td>
		</tr>
	</table>

</body>

</html>
