<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Performance Poor the for letter Warning 1st</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px;">
		<!-- Row 1: Date and Empty Cell -->
		<tr>
			<td style="width: 50%;">Date: <?php echo $formattedDate = date('jS F Y', strtotime($form_center['date_of_issue'])); ?></td>
			<td style="width: 50%; text-align: right;">التاريخ: <?php echo Greg2Hijri($form_center['date_of_issue']); ?></td>
		</tr>
		
		<!-- Row 2: To and Employee Details -->
		<tr>
			<td style="width: 50%;">
				To<br>
				<?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?>,<br>
				<?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?>,<br>
				<?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?>,<br>
				<?php echo (($employee_data['emp_detail']['department_name'] !=='') ? $employee_data['emp_detail']['department_name'] : 'NA');?>.
			</td>
			<td style="width: 50%; text-align: right;">
				اىل<br>
				<?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : 'NA');?>,<br>
				<?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?><br>
				<?php echo (($employee_data['emp_detail']['designation_arabic_name'] !=='') ? $employee_data['emp_detail']['designation_arabic_name'] : 'NA');?>,<br>
				<?php echo (($employee_data['emp_detail']['department_arabic_name'] !=='') ? $employee_data['emp_detail']['department_arabic_name'] : 'NA');?>.
			</td>
		</tr>
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; text-align: right;"></td>
		</tr>
		<!-- Row 3: Subject -->
		<tr>
			<td style="width: 50%;">
				Sub: <b><u>1st Warning letter for the Poor Performance.</u></b>
			</td>
			<td style="width: 50%; text-align: right;"><u> الموضوع: خطاب إنذار أول بشأن الأداء الضعيف للعمل </u></td>
		</tr>
		
		<!-- Row 4: Dear Employee Name -->
		<tr>
			<td style="width: 50%;">
				Dear Mr./Ms. <b><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?>,</b>
			</td>
			<td style="width: 50%; text-align: right;">
				عزيزي السيد/ السيدة <?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : 'NA');?>,
			</td>
		</tr>
		
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td style="width: 50%;">
				We are issuing this letter to warn you about your underperformance of work. After assessment, we noticed that your performance is not up to the mark.
			</td>
			<td style="width: 50%; text-align: right;">
				نحن نقوم بإصدار هذا الخطاب لإنذارك حول ضعف أدائك في العمل، ونحن نقوم بمتابعتك بعد التقييم بأن أدائك لا يصل إلى المستوى المحدد للأداء.
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td style="width: 50%;">
				We hereby expect you to take necessary actions to improve your performance; otherwise, it leads to strict action against you.
			</td>
			<td style="width: 50%; text-align: right;">
				بهذا فإننا نتوقع منك أن تقوم باتخاذ الإجراءات الضرورية من أجل تحسين أدائك، وفي حال عدم القيام بذلك فإن هذا يمكن أن يؤدي إلى اتخاذ إجراء صارم ضدك.
			</td>
		</tr>
		
		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				Consider this as the first reminder regarding your poor performance and provide your written explanation within 48 hours after receiving this letter.
			</td>
			<td style="width: 50%; text-align: right;">
				نرجو اعتبار هذا بمثابة التذكير الأول بخصوص أدائك الضعيف ونرجو أن تقوم بتوضيح الأسباب كتابيًا خلال 48 ساعة بعد استلام هذا الخطاب.
			</td>
		</tr>
		
		<!-- Row 8: Sincerely -->
		<tr>
			<td style="width: 50%;">
				Sincerely,<br><br><br><br>
				HR Officer,<br>
				HR Department.
			</td>
			<td style="width: 50%; text-align: right;">
				مخلصكم<br><br><br><br>
				مسؤول الموارد البشرية<br>
				قسم الموارد البشرية
			</td>
		</tr>
		<tr>
			<td style="width: 50%;"></td>
			<td style="width: 50%; text-align: right;"></td>
		</tr>
	</table>

</body>

</html>
