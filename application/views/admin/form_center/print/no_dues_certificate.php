<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - No Dues Certificate against outstanding salary and others dues</title>
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
				Subject: <b><u>No Dues Certificate against outstanding salary and others dues</u></b>
			</td>
			<td style="width: 50%; text-align: right;"><u> الموضوع: شهادة عدم وجود مستحقات مالية أو أخرى </u></td>
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
		<?php
			$currdate = new DateTime('first day of last month');
			$previousMonth = $currdate->format('F Y');
			$clearanceMonth = !empty($form_center['clearance_month']) ? date('F Y', strtotime($form_center['clearance_month'])) : $previousMonth;
		?>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">I, <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?> holding Saudi Iqama Number <?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?> and <?php echo $employee_data['emp_detail']['nationality_name'];?> Passport Number <?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?>,  currently employed at Maha Al Fala Trading Company, hereby confirm that I have 
			received my Full Salary & Benefits for the month of <?php echo $clearanceMonth;?> towards all my dues for the supplies of services provided by me to the company.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: justify;">أنا، <?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : '');?> حامل الهوية السعودية رقم <?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?> وجواز السفر رقم <?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?>، أعمل حاليًا لدى شركة مها الفلا للتجارة، وأؤكد بموجب هذا أنني قد استلمت راتبي الكامل والفوائد لشهر <?php echo $clearanceMonth;?> تجاه جميع مستحقاتي عن الخدمات التي قدمتها للشركة.</p>
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">I hereby confirm that I have received my Full Salary & Benefits for the month of <?php echo $clearanceMonth;?> towards all my dues for the supplies of services provided by me to the company.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: right;"> أؤكد أنني قد استلمت كامل راتبي ومزاياي عن شهر <?php echo $clearanceMonth;?> لتغطية جميع المستحقات المترتبة على الخدمات التي قدمتها للشركة. </p>
			</td>
		</tr>

		
		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">It is further certified that I have received the above amount in Cash, I have no other outstanding demand against the Maha Al-Fala Trading Establishment, having its office at Riyadh, Kingdom of Saudi Arabia & its Branch’s or Operational Offices and declare that I have no further claim or demand for whatsoever against the Company.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: right;"> كما أقر أنني قد استلمت هذا المبلغ نقدًا، ولا يوجد لدي أي مطالبات مالية أخرى تجاه شركة مها الفلا للتجارة، والتي يقع مقرها في الرياض، المملكة العربية السعودية، أو أي من فروعها أو مكاتبها التشغيلية. وأعلن أنه ليس لدي أي مطالبات أخرى أو حقوق تجاه الشركة بأي شكل كان. </p>
			</td>
		</tr>
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">Thank you for your understanding and support.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: right;">شكرًا لتفهمكم ودعمكم.</p>
			</td>
		</tr>
		<!-- Row 8: Sincerely -->
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; text-align: right;"></td>
		</tr>
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
