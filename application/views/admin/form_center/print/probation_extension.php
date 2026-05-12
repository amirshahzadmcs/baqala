<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Extension of Probation Period</title>
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
									<td valign="center" style="text-align: left;">Subject: Extension of Probation Period</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;"> الموضوع: تمديد فترة التجربة </td>
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
					<?php
						if (!empty($form_center['other_details'])) {
							$otherDetail = json_decode($form_center['other_details']);
							$startDate = formatedDate($otherDetail->start_date) ?? '';
							$endDate = formatedDate($otherDetail->end_date) ?? '';
						} else {
							$startDate = '';
							$endDate = '';
						}
					?>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;">We would like to inform you that your probation period for the position of <?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?> (<?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?>) has been extended for an additional 90 days, starting from <?php echo $startDate;?> to <?php echo $endDate;?>.</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="5" cellpadding="" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;">
										<?php
										$designation = !empty($employee_data['emp_detail']['designation_name']) ? $employee_data['emp_detail']['designation_name'] : 'NA';
										$empNo = !empty($employee_data['emp_detail']['emp_no']) ? $employee_data['emp_detail']['emp_no'] : 'NA';
										?>

										نود إبلاغكم أنه قد تقرر تمديد فترة التجربة الخاصة بكم في وظيفة 
										<?php echo $designation; ?> 
										(رقم الوظيفة: 
										<?php echo $empNo; ?>) 
										وذلك ابتداءً من 
										<?php echo $startDate; ?> 
										وحتى <?php echo $endDate; ?>.
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
				</table>
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 10px;">
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: left;">
									<p>This extension is granted to allow us more time to assess your performance fully and ensure that you meet the job requirements and align with the work environment. We appreciate your continued efforts during this probationary period and look forward to more productive cooperation.</p>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;">
									<p>يأتي هذا التمديد بناءً على رغبتنا في إتاحة مزيد من الوقت لتقييم أدائكم بشكل كامل، وللتأكد من مدى توافقكم مع متطلبات الوظيفة واحتياجات بيئة العمل. نحن نقدر جهودكم المستمرة خلال هذه الفترة التجريبية ونتطلع إلى المزيد من التعاون المثمر.</p>
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
									<p>The probation period is an opportunity for skill development and performance improvement. We are confident that you will continue to work towards achieving the desired goals. We emphasize the importance of continuously improving your performance in line with the company’s standards and giving your best effort for success.</p>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;">
									<p>إن فترة التجربة هي فرصة لتطوير المهارات والعمل على تحسين الأداء. نحن واثقون بأنكم ستواصلون العمل لتحقيق الأهداف المطلوبة. نؤكد على أهمية الاستمرار في تحسين الأداء بما يتماشى مع معايير الشركة وبذل قصارى جهدكم لتحقيق النجاح.</p>
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
									<td valign="center" style="text-align: justify;">
									<p>Please continue to engage positively with your supervisor’s feedback and address any areas requiring improvement during this period. If you have any inquiries or feedback regarding this extension or any other work-related matter, please feel free to contact us.</p>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;">
									<p>يرجى منكم التفاعل الإيجابي مع ملاحظات مشرفكم المباشر والعمل على معالجة أي جوانب تحتاج إلى تحسين خلال هذه الفترة. إذا كانت لديكم أي استفسارات أو ملاحظات بخصوص هذا التمديد أو أي مسألة أخرى تتعلق بعملكم، فلا تترددوا في التواصل معنا.</p>
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
									<td valign="center" style="text-align: justify;">
									<p>We appreciate your commitment to the job and wish you continued success in your future tasks.</p>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" style="text-align: right;direction: rtl;">
									<p>نحن نقدر التزامكم بالعمل ونتمنى لكم التوفيق والنجاح المستمر في مهامكم المستقبلية.</p>
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
