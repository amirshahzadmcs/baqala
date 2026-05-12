<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Employee Entitlements Schedule</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">

		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 10px;">
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="text-align:left;">Emp Name</td>
									<td width="70%" style="text-align:left;"><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="text-align:right;"><?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : 'NA');?></td>
									<td width="30%" style="text-align:right;"> اسم الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="text-align:left;">Emp ID</td>
									<td width="70%" style="text-align:left;"><?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="text-align:right;"><?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?></td>
									<td width="30%" style="text-align:right;"> رقم الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="text-align:left;">EMP Job Title</td>
									<td width="70%" style="text-align:left;"><?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="text-align:right;"><?php echo (($employee_data['emp_detail']['designation_arabic_name'] !=='') ? $employee_data['emp_detail']['designation_arabic_name'] : 'NA');?></td>
									<td width="30%" style="text-align:right;"> المسمى الوظيفي </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="text-align:left;">EMP Department</td>
									<td width="70%" style="text-align:left;"><?php echo (($employee_data['emp_detail']['department_name'] !=='') ? $employee_data['emp_detail']['department_name'] : 'NA');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="text-align:right;"><?php echo (($employee_data['emp_detail']['department_arabic_name'] !=='') ? $employee_data['emp_detail']['department_arabic_name'] : 'NA');?></td>
									<td width="30%" style="text-align:right;"> قسم الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="text-align:left;">EMP Iqama/ID No</td>
									<td width="70%" style="text-align:left;"><?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="text-align:right;"><?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?></td>
									<td width="30%" style="text-align:right;"> رقم الإقامة/ الهوية </td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td colspan="2" style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td colspan="2" style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					

					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;">Subject: Employee Entitlements Schedule</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;"> الموضوع:تنظيم صرف استحقاقات الموظف </td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 10px;">
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong>Dear <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;"><strong> عزيزي <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;">We would like to inform you of the following schedule for your salary:</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="5" cellpadding="" style="font-size: 10px;">
								<tr>
								<td valign="center" style="text-align: right;">نود إبلاغك بتنظيم صرف استحقاقاتك المالية حسب الجدول التالي:</td>
								</tr>
							</table>
						</td>
					</tr>

					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 10px;">
					<tr>
						<td width="20%" style="text-align:left;">1st Month</td>
						<td width="60%" style="text-align:center;">
							<p>Food allowance will be paid as Advance. <br> بدل الطعام سيتم دفعه كمقدم.</p>
						</td>
						<td width="20%" style="text-align:right;"> الشهر الأول </td>
					</tr>
					<tr>
						<td width="20%" style="text-align:left;">2nd Month</td>
						<td width="60%" style="text-align:center;">
							<p>Food allowance will be paid as Advance. <br>بدل الطعام سيتم دفعه كمقدم. </p>
						</td>
						<td width="20%" style="text-align:right;"> الشهر الثاني </td>
					</tr>
					<tr>
						<td width="20%" style="text-align:left;">3rd Month</td>
						<td width="60%" style="text-align:center;">
							<p>Food allowance will be paid as Advance, + basic salary. If Driving License is not Issued and salary is not started. <br>سيتم صرف بدل الطعام كمقدم، بالإضافة إلى الراتب الأساسي، إذا لم يتم إصدار رخصة القيادة لن يبدأ الراتب.</p>
						</td>
						<td width="20%" style="text-align:right;"> الشهر الثالث </td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 10px;">
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;">
									<p>Commencement of Salary:<br>Thesalary will start day after obtaining your driver’s license, yourfood allowance will be stopped from same date.</p>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;">
									<p><strong> بدء الراتب: </strong><br> سيبدأ الراتب بعد يوم من الحصول على رخصة القيادة الخاصة بك، وسيتم إيقاف بدل الطعام اعتبارًا من نفس التاريخ </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;">
									<p><strong>Additional Notes:</strong><br>Delivery Target will not the calculated for the 1st running month of receiving the driving license.</p>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;">
									<p><strong> ملاحظات إضافية: </strong><br> لن يتم احتساب هدف التوصيل للشهر الأول بعد الحصول علىرخصة القيادة.</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: justify;"><strong>We appreciate your adherence to the above conditions and look forward to your continued cooperation and excellent performance. Should you have any questions or concerns regarding these arrangements, please feel free to contact us at any time.</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;"> نرجو منك الالتزام بالشروط المذكورة أعلاه، ونتطلع إلى استمرار تعاونك وأدائك المتميز.
									إذا كان لديك أي استفسار أو ملاحظات حول هذا الترتيب، يرجى التواصل معنا في أي وقت.
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong>Best regards,</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;"><strong> أطيب التحيات، </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong>HR Manager</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="5" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;"><strong> مدير الموارد البشرية  </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong>Acceptance</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;"><strong> الموافقة </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
								<tr>
									<td style="text-align:right;"></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 10px;">
					<tr>
						<td width="20%" style="text-align:left;">Signature</td>
						<td width="60%" style="text-align:center;"></td>
						<td width="20%" style="text-align:right;"> التوقيع </td>
					</tr>
					<tr>
						<td width="20%" style="text-align:left;">Date</td>
						<td width="60%" style="text-align:center;"></td>
						<td width="20%" style="text-align:right;"> التاريخ </td>
					</tr>
					<tr>
						<td width="20%" style="text-align:left;">Fingerprint</td>
						<td width="60%" style="text-align:center;"></td>
						<td width="20%" style="text-align:right;"> البصمة </td>
					</tr>
					
				</table>
			</td>
		</tr>

	</table>

</body>

</html>
