<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Vehicle Handover Form</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
	<style>
	*{padding:0px;margin:0px;}
	.roboto-medium {
		font-family: "Roboto", sans-serif;
		font-weight: 500;
		font-style: normal;
	}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">

		<tr>
			<td colspan="3" style="padding-top:18px;">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;margin-top:15px;">
					<tr>
						<td>
							<table cellspacing="0" cellpadding="5" border="1">
								<tr>
									<td valign="top" align="center" colspan="3">
										<table cellspacing="0" cellpadding="10" style="font-size: 16px;">
											<tr><td><strong> <span class="roboto-medium"> Vehicle Handover Form /</span> نموذج تسليم سيارة </strong></td></tr>
										</table>
									</td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Employee No</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $emp_detail->emp_no;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> رقم الموظف </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Employee Name</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $emp_detail->full_name;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> اسم الموظف </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Job Title</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $emp_detail->designation_name;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> المسمى الوظيفي  </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Iqama / ID Number</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $emp_detail->iqama_no .' / '. $vehicle_detail->passport_no;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> رقم الإقامة/ الهوية </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Nationality</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $emp_detail->nationality_name;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> الجنسية </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Vehicle Type</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo ucfirst($vehicle_detail->vehicle_type);?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> نوع السيارة </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Vehicle Plate No</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $vehicle_detail->vehicle_no;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> رقم لوحة السيار </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Vehicle Make</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $vehicle_detail->make_name;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> دولة صنع السيارة </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Vehicle Model</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $vehicle_detail->vehicle_model;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> موديل السيارة </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Vehicle Year</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo ucfirst($vehicle_detail->vehicle_year);?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> سنة صنع السيارة </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Gasoline Chip Status</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo ($vehicle_detail->gasoline_chip_status) ? 'Yes' : 'No';?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> حالة رقاقة البنزين </td>
								</tr>
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Purpose of Handover</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong>Work</strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> الغرض من التسليم </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" align="justify" height="18px" colspan="3">
							<table cellspacing="0" cellpadding="5" border="1" style="font-size: 10px;line-height:12px;">
								<tr>
									<td>
										<p>
										I received the above said Vehicle from the company to use it for business purposes, and I pledge to keep it and its accessories. and to always be in good condition, and to use it for business purposes and during daily work.
										</p>
									</td>
									<td>
										<p style="text-align: right;">
										أنا تسلمت السيارة المذكورة أعاله من ال رشكة ل ك استخدمها ًألغراض العمل وأتعهد بأن أحافظ عليها ه ومستلزماتها وأدواتها وأن تكون دائما . ف حالة جيدة وأن أستخدمها ألغراض العمل وخالل العمل اليو م.
										</p>
									</td>
								</tr>
								<tr>
									<td>
										<p>
										I acknowledge that in the event of any problems, I will inform the management immediately, and I also acknowledge my responsibility for any damage that occurs to the car/Motorcycle through misuse or lack of care. and not to hand over the car to anyone else or allow them to drive it, and not to go to other areas of the car that are not authorized and that as soon as the company requests the Vehicle from me, I will deliver it in the condition in which I received it in the event of a theft of the vehicle due to my negligence, I will compensate the company with another vehicle itself.
										</p>
									</td>
									<td>
										<p style="text-align: right;">
										أقر أنه  .  ف حالة حدوث أي مشاكل، فسوف أقوم بإبالغ اإلدارة عىل الفور، كما أقر بمسؤولي    ت عن أي   .ضر يحدث للسيارة/الدراجة النارية نتيجة لسوء االستخدام أو عدم  العناية. كما  أتعهد  بعدم  تسليم  السيارة  ألي  شخص  آخر  أو  السماح  له بقيادتها، وعدم الذهاب إىل مناطق أخرى بالسيارة غ  ي مرصح بها وأنه بمجرد أن ال رشكة م .  ت السيارة سأقوم بتسليمها  .  ف الحالة ال    ت استلمتها بها، و .  ف حالة المركبة  بسبب إهما  ىل سأعوض  ال رشكة بمركبة أخرى بنفس صفات  هذه تطلب شقة السيارة نفسها. 
										</p>
									</td>
								</tr>
								<tr>
									<td>
										<p>
										And I acknowledge that I consider the use of the laws and regulations of the work in which it operates in
										</p>
									</td>
									<td>
										<p style="text-align: right;">
										وأنا  أقر  بأن .  ت  أضع  اعتبار  الستخدام  أنظمة  ولوائح  العمل  ال    ت  تعمل  السيارة بموجبها. 
										</p>
									</td>
								</tr>
								<tr>
									<td>
										<p>
										I declare that I have read all of what is stated in the policy of using vehicle in the company: Maha Al Fala Trading Establishment and that I abide by it completely.
										</p>
									</td>
									<td>
										<p style="text-align: right;">
										أنا أقر بأن .  ت قد قمت بقراءة كل ما هو مب    .ي  .  ف سياسة استخدام السيارة  .  ف ال رشكة: مؤسسة مها الفال التجارية كما أل   .يم بهذه السياسة بصورة كاملة. 
										</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table cellspacing="0" cellpadding="5" border="1">
								<tr>
									<td valign="top" height="18px" style="text-align: left;width:30%;">Date of Receiving</td>
									<td valign="top" height="18px" style="text-align: center;width:40%;"><strong><?php echo $salary_detail->basic_salary;?></strong></td>
									<td valign="top" height="18px" style="text-align: right;width:30%;"> تاريخ الاستلام  </td>
								</tr>
								<tr>
									<td style="text-align:left;width:30%;"><br><br>Signature of Receiver<br></td>
									<td style="text-align:center;width:40%;"><strong><?php echo $salary_detail->housing_allow;?></strong></td>
									<td style="text-align:right;width:30%;"> توقيع المستلم </td>
								</tr>
								<tr>
									<td valign="top" style="text-align: left;width:30%;"><br><br>Thump Impression<br></td>
									<td valign="top" style="text-align: center;width:40%;"><strong><?php echo $salary_detail->transportation_allow;?></strong></td>
									<td valign="top" style="text-align: right;width:30%;"> بصمة الإبهام </td>
								</tr>
								<tr>
									<td valign="top" style="text-align: left;width:30%;"><br><br>Signature of Field Coordinator<br></td>
									<td valign="top" style="text-align: center;width:40%;"><strong><?php echo $salary_detail->food_allow;?></strong></td>
									<td valign="top" style="text-align: right;width:30%;"> توقيع المنسق الميداني </td>
								</tr>
								<tr>
									<td valign="top" style="text-align: left;width:30%;"><br><br>Signature of Operation<br></td>
									<td valign="top" style="text-align: center;width:40%;"><strong><?php echo $salary_detail->no_of_orders;?></strong></td>
									<td valign="top" style="text-align: right;width:30%;"> توقيع التشغيل  </td>
								</tr>
								<tr>
									<td valign="top" style="text-align: left;width:30%;"><br><br>Signature of HR<br></td>
									<td valign="top" style="text-align: center;width:40%;"><strong><?php echo $salary_detail->total_package;?></strong></td>
									<td valign="top" style="text-align: right;width:30%;"> توقيع الموارد البشرية </td>
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
