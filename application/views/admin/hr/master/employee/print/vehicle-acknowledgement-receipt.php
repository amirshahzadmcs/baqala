<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Vehicle Acknowledgement Receipt</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;">

		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 14px;">
								<tr>
									<td valign="center" height="30px" style="text-align: center;"><strong><u>Vehicle Acknowledgement Receipt</u></strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 14px;">
								<tr>
									<td valign="center" height="30px" style="text-align: center;"><strong><u>  إقرار  استلام سيارة </u></strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
					</tr>
				</table>
				<table width="100%" cellspacing="0" cellpadding="0" border="1" style="font-size: 11px;">
					<tr>
						<td>
							<table width="100%" cellspacing="5" cellpadding="0" border="0" style="font-size: 11px;">
								<tr>
									<td width="30%" valign="center" height="20px" style="text-align: left;">Motorcycle</td>
									<td width="70%" valign="center" height="20px" style="text-align: left;">
										<table border="1" width="16px">
											<tr><td align="center"><?php echo ($vehicle_type == 'bike') ? '<span style="font-family:zapfdingbats;">4</span>' : '';?></td></tr>
										</table>
									</td>
								</tr>
								<tr>
									<td width="30%" valign="center" height="20px" style="text-align: left;">Car</td>
									<td width="70%" valign="center" height="20px" style="text-align: left;">
										<table border="1" width="16px">
											<tr><td align="center"><?php echo ($vehicle_type == 'car') ? '<span style="font-family:zapfdingbats;">4</span>' : '';?></td></tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
						<td>
							<table width="100%" cellspacing="5" cellpadding="0" border="0" style="font-size: 11px;">
								<tr>
									<td width="60%"></td>
									<td width="10%" valign="center" height="20px">
										<table border="1" width="16px">
											<tr><td align="center"><?php echo ($vehicle_type == 'bike') ? '<span style="font-family:zapfdingbats;">4</span>' : '';?></td></tr>
										</table>
									</td>
									<td width="30%" valign="center" height="20px" style="text-align: right;"> دراجة بخارية </td>
								</tr>
								<tr>
									<td width="60%"></td>
									<td width="10%" valign="center" height="20px" style="float:right">
										<table border="1" width="16px">
											<tr><td align="center"><?php echo ($vehicle_type == 'car') ? '<span style="font-family:zapfdingbats;">4</span>' : '';?></td></tr>
										</table>
									</td>
									<td width="30%" valign="center" height="20px" style="text-align: right;"> سيارة </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;">
									<strong>I Mr. <?php echo $full_name;?> holding (<?php echo $nationality;?>) National Passport No (<?php echo $passport_no;?>) Iqama/ National ID No <?php echo !empty($iqama_no) ? $iqama_no : '.................';?> I hereby confirm that I have received a <?php echo ucfirst($vehicle_type);?> Brand: <?php echo vehicleDetailHelper($vehicle_id)->make_name;?> Model: <?php echo $vehicle_model;?> Plate Number: <?php echo $vehicle_no;?> from Maha AL Fala Trading Est. (the company) to use it for business purposes, and I pledge to keep it and its accessories, and to always be in good condition, and to use it for business purposes and during daily work.</strong>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="5" cellpadding="0" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;direction: rtl;"><strong> أنا السيد <?php echo $employee_arabic_name;?> أحمل جواز سفر (<?php echo nationalityArabic($nationality);?>) رقم (<?php echo $passport_no;?>)، رقم الهوية الوطنية <?php echo !empty($iqama_no) ? $iqama_no : '.................';?> أؤكد بموجب هذا أنني حصلت على <?php echo ($vehicle_type == 'bike') ? 'دراجة بخارية' : 'سيارة';?> : رقم: <?php echo vehicleDetailHelper($vehicle_id)->make_name;?> موديل: <?php echo $vehicle_model;?> رقم اللوحة: <?php echo $vehicle_no;?> من مؤسسة مها الفلا التجارية. ( الشركة ) لاستخدامها لأغراض تجارية، وأتعهد بالحفاظ عليها هي وملحقاتها. وأن تكون دائمًا في حالة جيدة، وأن أستخدمها لأغراض العمل وأثناء العمل اليومي. </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong> I acknowledge that in the event of any problems, I will inform the management immediately, and I also acknowledge my responsibility for any damages that occur to the <?php echo ucfirst($vehicle_type);?> through misuse or lack of care and not to handover the <?php echo ucfirst($vehicle_type);?> to anyone else or allow them to drive it, and not to go to other areas of the <?php echo ucfirst($vehicle_type);?> that are not authorized and that as soon as the company requests the <?php echo ucfirst($vehicle_type);?> from me, I will deliver it in the condition in which I received it in the event of a theft of the vehicle, I will compensate the company with another vehicle itself. </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="5" cellpadding="0" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> أقر بأنني سأقوم بإبلاغ الإدارة على الفور في حالة وقوع أي مشاكل، كما أقر بمسؤوليتي عن أي أضرار تحدث  <?php echo ($vehicle_type == 'bike') ? 'دراجة بخارية' : 'سيارة';?> نتيجة سوء الاستخدام أو عدم العناية كما أتعهد بأن لا أسلم السيارة لأي شخص آخر أو أسمح لأي شخص بقيادتها، وعدم الذهاب إلى مناطق أخرى غير مصرحة بالنسبة لاستخدام <?php echo ($vehicle_type == 'bike') ? 'دراجة بخارية' : 'سيارة';?>  ، وبمجرد أن تطلب الشركة مني <?php echo ($vehicle_type == 'bike') ? 'دراجة بخارية' : 'سيارة';?>  فسوف أقوم بتسليمها بالحالة التي استلمتها بها في وفي حالة سرقة السيارة، سأقوم بتعويض الشركة بمركبة أخرى. </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong> And I acknowledge that I take into account the use of the laws and regulations of the work in which it operates in kingdom of Saudi Arabia. </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> وأقر بأن أضع في الحسبان اتباع وتطبيق أنظمة ولوائح العمل التي تعمل السيارة بموجبها في المملكة العربية السعودية.  </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong> I declare that I have read all of what is stated in the policy of using <?php echo ucfirst($vehicle_type);?> in the company Maha AL Fala Trading Est and that I abide by it completely. </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> أنا أقر بأنني قد قرأت جميع ما تم بيانه في السياسة الخاصة <?php echo ($vehicle_type == 'bike') ? 'دراجة بخارية' : 'سيارة';?> في مؤسسة مها الفلا وأن ألتزم بهذه السياسة بشكل كامل.  </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;text-align:left;">Name</td>
									<td width="80%" style="text-align:left;"><?php echo $full_name;?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="80%" style="border-right:1px solid #000;text-align:right;"><?php echo $employee_arabic_name;?></td>
									<td width="20%" style="text-align:right;">الاسم</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;text-align:left;">Date</td>
									<td width="80%" style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="80%" style="border-right:1px solid #000;text-align:right;"></td>
									<td width="20%" style="text-align:right;">التاريخ</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;text-align:left;">Place</td>
									<td width="80%" style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="80%" style="border-right:1px solid #000;text-align:right;"></td>
									<td width="20%" style="text-align:right;">المكان</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td height="60px" style="border-right:1px solid #000;text-align:left;">Signature</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td height="60px" style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td height="60px" style="text-align:right;">التوقيع</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td height="60px" style="border-right:1px solid #000;text-align:left;">Thumb</td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td height="60px" style="text-align:left;"></td>
								</tr>
							</table>
						</td>
						<td valign="center" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td height="60px" style="text-align:right;">البصمة</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>

	</table>

</body>

</html>
