<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Performance Poor the for letter Warning 2nd</title>
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
				Sub: <b><u>2nd Warning letter for the Poor Performance.</u></b>
			</td>
			<td style="width: 50%; text-align: right;"><u>الموضوع: خطاب إنذار ثانٍ بخصوص الأداء الضعيف في العمل</u></td>
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
		<?php
			// Ensure the database library is loaded
			$CI =& get_instance();
			$CI->load->database();

			// Perform a query
			$firstDateQuery = $CI->db->query("SELECT date_of_issue FROM form_centers WHERE (employee_id = '". $employee_data['emp_detail']['id'] ."' AND document_type = 'warning_letter' AND letter_type = 'first')")->row()->date_of_issue;
			$formatedFirstDate = date('d-m-Y', strtotime($firstDateQuery));
			$arabicFirstDate = ReturnGreg2Hijri($firstDateQuery);
		?>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td style="width: 50%;">
				It has been observed that you haven't improved your performance even after issuing an earlier warning letter dated <?php echo $formatedFirstDate;?>, this shows your negligence towards your work.
			</td>
			<td style="width: 50%; text-align: right;">
				لقد لوحظ بأنك لم تقم بتحسين أدائك حتى بعد إصدار خطاب إنذار من قبل صدر بتاريخ <?php echo $arabicFirstDate;?>، وهذا يدل على إهمالك نحو عملك.
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td style="width: 50%;">
				The management couldn't tolerate such behaviour, we want employees who work with diligence and dedication.
			</td>
			<td style="width: 50%; text-align: right;">
				لا يمكن للإدارة أن تتسامح مع مثل هذا السلوك حيث أننا نرغب في موظفين يعملون باجتهاد وتفاني.
			</td>
		</tr>
		
		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				Your continuous failure to comply with the project guidelines and requirements led to a loss to the company.
			</td>
			<td style="width: 50%; text-align: right;">
				إن فشلك المستمر في الامتثال لإرشادات ومتطلبات المشروع أدى إلى خسارة الشركة.
			</td>
		</tr>

		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				This should be a final opportunity for you to improve your performance. If you fail to show any progress, then it will lead to the termination of your employment.
			</td>
			<td style="width: 50%; text-align: right;">
				يجب أن تكون هذه الفرصة الأخيرة لتحسين أدائك، وإذا لم تظهر أي تحسن فإن هذا سوف يؤدي إلى إنهاء خدمتك.
			</td>
		</tr>

		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				Kindly treat this as an extremely urgent matter, and kindly sign a copy of this letter as an acknowledgment.
			</td>
			<td style="width: 50%; text-align: right;">
				يرجى التعامل مع هذا الموضوع باعتباره مسألة عاجلة جدًا، ونرجو التكرم بالتوقيع على نسخة من هذا الخطاب كإقرار.
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
