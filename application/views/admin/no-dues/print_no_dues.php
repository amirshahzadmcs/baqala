<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - No Dues Certificate</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px; width: 100%;">

		<tr>
			<td style="width: 49%;text-align:left;">
				<p>To</p>
				<p style="line-height: 0px;">The HR Manager,</p>
				<p style="line-height: 0px;">Mala Al Fala Trading Company</p>
				<p style="line-height: 0px;">Riyadh Saudi Arabia.</p><br>
				<p>Subject: <strong>No Dues Certificate against outstanding salary and others dues.</strong></p><br><br>
				<p>Dear Sir / Madam,</p><br>
				<p align="justify">I Mr. <?php echo $name; ?>, <?php echo $nationality; ?> Passport No <?php echo $passport; ?> issued at <?php echo $passport_issued_city; ?> <?php echo $nationality; ?> and Saudi Iqama Number <?php echo $iqama_no; ?>, hereby confirm that I have received my Full Salary & Benefits for the month of <?php echo $this->input->post('month_of');?> towards all my dues for the supplies of services provided by me amounting to SAR. <?php echo number_format($this->input->post('salary'),2); ?>/-.</p>
				<p align="justify">It is further certified that I have received the above amount in Cash, I have no other outstanding demand against the Maha AL Fala Trading Establishment, having its office at Riyad, Kingdom of Saudi Arabia & its Branch’s or Operational Offices and declare that I have no further claim or demand for whatsoever against the Company.</p><br><br>
				<p>Yours faithfully</p>
				<p style="line-height: 0px;">Mr. <?php echo $name; ?> .</p>
				<p style="line-height: 0px;">Iqama No. <?php echo $iqama_no; ?></p>
				<p style="line-height: 0px;">Riyadh.</p><br><br>
				<p>Date:</p><br><br>
				<p>Signature:</p>
			</td>
			<td style="width: 2%;"></td>
			<td style="width: 49%;text-align:right;">
				<p> إلى </p>
				<p style="line-height: 0px;"> مدير الموارد البشرية , </p>
				<p style="line-height: 0px;"> مؤسسة مها الفلا التجارية </p>
				<p style="line-height: 0px;"> الرياض – المملكة العربية السعودية </p><br>
				<p> الموضوع : إقرار بعدم وجود مطالبات تجاه راتب معلق أو أي مستحقات أخرى معلقة  </p><br><br>
				<p></p>
				<p> السيد / السيدة المحترم/ة, </p><br>
				<p align="right"> أنا الأخ / <?php echo $arabic_name; ?>, <?php echo $nationality_arabic; ?> الجنسية وجواز سفر رقم : <?php echo $passport; ?> صادر من <?php echo $passport_issued_city_ar; ?> <?php echo $nationality_arabic; ?>  , وإقامة سعودية برقم : <?php echo $iqama_no; ?>, أقر بأنني استلمت راتبي ومستحقاتي المالية بالكامل لشهر <?php echo $this->input->post('month_of');?> لسنة م.  وذلك مقابل خدماتي التي قدمتها للشركة وبإجمالي <?php echo number_format($this->input->post('salary'),2); ?> ريال سعودي .</p>
				<p align="justify"> إضافة إلى أن هذا إقرار مني بأنني قد استلمت المبلغ المذكورأعلاه نقداً بالكامل , وأنه لا توجد بعد الآن أي مبالغ مالية أو مطالب أو مستحقات تخصني لا زالت معلقة لدى مؤسسة مها الفلا التجارية , والتي يقع مكتبها في الرياض , المملكة العربية السعودية و فروعها و مكاتبها العاملة . وعليه فإنني أتعهد بأنني لن أطالب الشركة بأي مستحقات تحت أي مسمى . </p><br><br>
				<p> مع فائق الاحترام والتقدير, </p>
				<p style="line-height: 0px;">السيد <?php echo $arabic_name; ?> .</p>
				<p style="line-height: 0px;">رقم الإقامة  <?php echo $iqama_no; ?></p>
				<p style="line-height: 0px;">الرياض.</p><br><br>
				<p>التاريخ :</p><br><br>
				<p>التوقيع :</p>
			</td>
		</tr>

	</table>

</body>

</html>
