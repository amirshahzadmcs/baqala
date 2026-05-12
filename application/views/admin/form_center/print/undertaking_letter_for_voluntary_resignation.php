<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Undertaking Letter for Voluntary Resignation</title>
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
				Subject: <b><u>Undertaking Letter for Voluntary Resignation</u></b>
			</td>
			<td style="width: 50%; text-align: right;"><u> الموضوع: خطاب تعهد بالاستقالة الطوعية </u></td>
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
			<p style="text-align: justify;">I, <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : '');?> holding Saudi Iqama Number <?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?> and <?php echo $employee_data['emp_detail']['nationality_name'];?> Passport Number <?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?>, currently employed at Maha Al Fala Trading Company, hereby submit this letter to formally certify that I am resigning from my position as <?php echo $employee_data['emp_detail']['designation_name'];?> at my own will. This decision has been made independently, and I intend to return to <?php echo (($employee_data['emp_detail']['passport_country_name'] !=='') ? $employee_data['emp_detail']['passport_country_name'] : 'NA');?> on my own expenses.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: right;"> <?php echo (($employee_data['emp_detail']['employee_arabic_name'] !=='') ? $employee_data['emp_detail']['employee_arabic_name'] : '');?>، حامل إقامة سعودية رقم  <?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?>وجواز سفر <?php echo $employee_data['emp_detail']['designation_arabic_name'];?>رقم <?php echo (($employee_data['emp_detail']['passport_no'] !=='') ? $employee_data['emp_detail']['passport_no'] : 'NA');?>، أعمل حاليًا لدى شركة مها الفلا للتجارة. أقدم هذا الخطاب لأؤكد بشكل رسمي أنني أستقيل من منصبي كموظف توصيل - دراجة نارية بمحض إرادتي. تم اتخاذ هذا القرار بشكل مستقل، وأخطط للعودة إلى باكستان على نفقتي الشخصية. </p>
			</td>
		</tr>
		
		<!-- Row 6: Expectation -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">
					I confirm that neither Maha Al Fala Trading Company nor 
					<?php echo (($form_center['agency_name'] !== '') ? $form_center['agency_name'] : ''); ?> 
					bears any responsibility for any losses or inconveniences that I may incur as a result of my resignation and subsequent departure. I fully understand and accept that this resignation is initiated solely by me, and I absolve Maha Al Fala Trading Company and 
					<?php echo (($form_center['agency_name'] !== '') ? $form_center['agency_name'] : ''); ?> 
					of any liabilities or obligations related to this matter.
				</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: right;">
					أؤكد أن شركة مها الفلا للتجارة ولا 
					<?php echo (($form_center['agency_name'] !== '') ? $form_center['agency_name'] : ''); ?> 
					تتحمل أي مسؤولية عن أي خسائر أو إزعاج قد أتعرض له نتيجة لاستقالتي ورحيلي اللاحق. أنا أفهم تمامًا وأقبل أن هذه الاستقالة تمت بمبادرتي الخاصة، وأبرأ شركة مها الفلا للتجارة و 
					<?php echo (($form_center['agency_name'] !== '') ? $form_center['agency_name'] : ''); ?> 
					من أي التزامات أو التزامات تتعلق بهذه المسألة. </p>
			</td>
		</tr>

		
		<!-- Row 7: Reminder -->
		<tr>
			<td style="width: 50%;">
				<p style="text-align: justify;">Please consider this letter as my official resignation notice. I am committed to fulfilling my duties during the notice period as stipulated in my employment contract.</p>
			</td>
			<td style="width: 50%; text-align: right;">
				<p style="text-align: right;"> يرجى النظر في هذا الخطاب كإشعار استقالة رسمي مني. أنا ملتزم بأداء واجباتي خلال فترة الإشعار كما هو مبين في عقدي العمل. </p>
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
