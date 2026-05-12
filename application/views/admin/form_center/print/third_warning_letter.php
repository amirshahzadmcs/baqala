<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Performance Poor the for letter Warning 3rd</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: justify; line-height: 20px;">
		<!-- Row 1: Date and Empty Cell -->
		<tr>
			<td style="width: 50%;">Date: <?php echo $formattedDate = date('jS F Y', strtotime($form_center['date_of_issue'])); ?></td>
			<td style="width: 50%; text-align: right;">التاريخ: <?php echo Greg2Hijri($form_center['date_of_issue']); ?></td>
		</tr>
		
		<!-- Row 2: To and Employee Details -->
		<tr>
			<td style="width: 50%;">
				To<br>
				<?php echo ($employee_data['emp_detail']['full_name'] !== '' ? $employee_data['emp_detail']['full_name'] : 'NA'); ?>,<br>
				<?php echo ($employee_data['emp_detail']['emp_no'] !== '' ? $employee_data['emp_detail']['emp_no'] : 'NA'); ?>,<br>
				<?php echo ($employee_data['emp_detail']['designation_name'] !== '' ? $employee_data['emp_detail']['designation_name'] : 'NA'); ?>,<br>
				<?php echo ($employee_data['emp_detail']['department_name'] !== '' ? $employee_data['emp_detail']['department_name'] : 'NA'); ?>.
			</td>
			<td style="width: 50%; text-align: right;">
				اىل<br>
				<?php echo ($employee_data['emp_detail']['employee_arabic_name'] !== '' ? $employee_data['emp_detail']['employee_arabic_name'] : 'NA'); ?>,<br>
				<?php echo ($employee_data['emp_detail']['emp_no'] !== '' ? $employee_data['emp_detail']['emp_no'] : 'NA'); ?><br>
				<?php echo ($employee_data['emp_detail']['designation_arabic_name'] !== '' ? $employee_data['emp_detail']['designation_arabic_name'] : 'NA'); ?>,<br>
				<?php echo ($employee_data['emp_detail']['department_arabic_name'] !== '' ? $employee_data['emp_detail']['department_arabic_name'] : 'NA'); ?>.
			</td>
		</tr>
		
		<!-- Row 3: Subject -->
		<tr>
			<td style="width: 50%;">
				Sub: <b><u>Regarding Poor Performance - Final Warning Letter</u></b>
			</td>
			<td style="width: 50%; text-align: right;">
				<u>الموضوع: بخصوص ضعف الأداء - خطاب إنذار نهائي</u>
			</td>
		</tr>
		
		<!-- Row 4: Dear Employee Name -->
		<tr>
			<td style="width: 50%;">
				Dear Mr./Ms. <b><?php echo ($employee_data['emp_detail']['full_name'] !== '' ? $employee_data['emp_detail']['full_name'] : 'NA'); ?>,</b>
			</td>
			<td style="width: 50%; text-align: right;">
				عزيزي السيد/ السيدة <?php echo ($employee_data['emp_detail']['employee_arabic_name'] !== '' ? $employee_data['emp_detail']['employee_arabic_name'] : 'NA'); ?>,
			</td>
		</tr>
		
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td style="width: 50%;">
				This letter serves as an official warning due to insufficient progress in your performance despite multiple discussions.
			</td>
			<td style="width: 50%; text-align: right;">
				نحن نقوم بإصدار هذا الخطاب لإنذارك بسبب عدم تحقيق تقدم كافٍ في أدائك على الرغم من المناقشات المتعددة.
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td style="width: 50%;">
				This is a final warning. If there is no improvement in your performance within the next 30 days, your employment may be terminated without further notice.
			</td>
			<td style="width: 50%; text-align: right;">
				هذا هو الإنذار النهائي. إذا لم يحدث أي تحسين في أدائك خلال الثلاثين يومًا القادمة، قد يتم إنهاء عملك بدون إشعار إضافي.
			</td>
		</tr>
		
		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				Please contact the Human Resources department for any further queries and sign a copy of this letter as acknowledgment of receipt.
			</td>
			<td style="width: 50%; text-align: right;">
				يُرجى الاتصال بإدارة الموارد البشرية لأي استفسارات إضافية والتوقيع على نسخة من هذا الخطاب كإقرار بالاستلام.
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
