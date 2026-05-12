<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Job Offer</title>
	<style>
	*{padding:0px;margin:0px;}
	ul {
    margin: 0;
		padding-left: 0;
	}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
		<tr>
			<td colspan="3" align="center" style="font-size: 16px;font-weight:700">
				<h3 style="line-height: 0px;">عرض عمل</h3>
				<h3>Job offer</h3>
			</td>
		</tr>
		<tr><td colspan="3"></td></tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;">
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="30%" style="text-align: left;"><strong> Date </strong></td>
									<td valign="center" height="10px" width="70%" style="text-align: left;"><strong> <?php echo date('d-M-Y');?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="70%" style="text-align: right;"><span style="direction: rtl;"><strong> <?php echo date('d-M-Y');?> </strong></span> </td>
									<td valign="center" height="10px" width="30%" style="text-align: right;"><span><strong> </strong></span><span style="direction: rtl;"><strong> التاريخ :</strong></span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="30%" style="text-align: left;"><strong> Name </strong></td>
									<td valign="center" height="10px" width="70%" style="text-align: left;"><strong> <?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="70%" style="text-align: right;"><span style="direction: rtl;"><strong> <?php echo $cv_detail->candidate_arabic_name;?> </strong></span> </td>
									<td valign="center" height="10px" width="30%" style="text-align: right;"><span><strong> </strong></span><span style="direction: rtl;"><strong> الاسم :</strong></span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="30%" style="text-align: left;"><strong> Nationality </strong></td>
									<td valign="center" height="10px" width="70%" style="text-align: left;"><strong> <?php echo $cv_detail->nationality;?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="70%" style="text-align: right;"><span style="direction: rtl;"><strong> <?php echo $cv_detail->arabic_nationality;?> </strong></span> </td>
									<td valign="center" height="10px" width="30%" style="text-align: right;"><span><strong> </strong></span><span style="direction: rtl;"><strong> الجنسية :</strong></span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="30%" style="text-align: left;"><strong> Passport No </strong></td>
									<td valign="center" height="10px" width="70%" style="text-align: left;"><strong> <?php echo $cv_detail->passport_no;?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="70%" style="text-align: right;"><span style="direction: rtl;"><strong> <?php echo $cv_detail->passport_no;?> </strong></span> </td>
									<td valign="center" height="10px" width="30%" style="text-align: right;"><span><strong> </strong></span><span style="direction: rtl;"><strong> </strong></span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong> Maha Al Fala Trading Company </strong>is pleased to offer you employment on the following terms and conditions: </td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> يسر مؤسسة مها الفلا للتجارة أن تقدم لكم هذا العرض الوظيفي وفق البنود والشروط التالية: </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="38%" style="text-align: left;"><strong> Job Title </strong></td>
									<td valign="center" height="10px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="10px" width="56%" style="text-align: left;"><strong> <?php echo $cv_detail->pos_name;?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="10px" width="56%" style="text-align: right;"><strong> <?php echo $cv_detail->pos_arabic_name;?> </strong></td>
									<td valign="center" height="10px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="10px" width="38%" style="text-align: right;"><strong> المسمى الوظيفي </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Total Salary </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['total_salary_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['total_salary_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> الراتب الإجمالي </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Basic Salary </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['basic_salary_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['basic_salary_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> الراتب الأساسي </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Housing Allowance </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['housing_allowance_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['housing_allowance_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> بدل سكن </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Food Allowance </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['order_allowance_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['order_allowance_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong>  بدل الغذاء </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Transportation Allowance </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['transport_allowance_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['transport_allowance_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> بدل مواصلات </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Other Allowances </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['other_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['other_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> أخرى </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Annual Vacation </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['annual_vacation_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['annual_vacation_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> الإجازة السنوية </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Medical Insurance </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['medical_insurance_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['medical_insurance_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> التأمين الصحي </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="38%" style="text-align: left;"><strong> Contract Period </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="56%" style="text-align: left;"><strong> <?php echo $package_detail['contract_period_en'];?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" width="56%" style="text-align: right;"><strong> <?php echo $package_detail['contract_period_ar'];?> </strong></td>
									<td valign="center" height="20px" width="6%" style="text-align: center;"><strong> : </strong></td>
									<td valign="center" height="20px" width="38%" style="text-align: right;"><strong> مدة العقد </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- <tr>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							
						</td>
					</tr> -->
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong><u>This offer is further subjected to the following conditions:</u></strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong><u> هذا العرض خاضع للشروط التالية: </u></strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;">
										<ul><li>That the Saudi Arabian authorities do not object to the employee working for the company.</li></ul>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;">
										<p style="direction: rtl;">	أن لا يكون لدى السلطات الرسمية أي اعتراض على عملكم لدى الشركة </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;">
										<ul>
											<li>That the employee is in satisfactory physical condition to perform the work that will be assigned thereto (you will be required to obtain a medical exam clearance).</li>
										</ul>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> أن يبين الكشف الطبي أن حالتكم الصحية والجسدية تؤهلكم للقيام بمهام العمل الوظيفية </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;">
										<ul>
											<li>That all information provided to the company including education and work experience is true & accurate.</li>
										</ul>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> صحة المعلومات والشهادات والبيانات التي تقدمتم بها للشركة والتي تشكل عنصرا جوهريا في اختياركم للعمل. </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;">
										<ul>
											<li>Execution of and employment contract with the company.</li>
										</ul>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> إبرام عقد التوظيف مع الشركة </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;">
										<ul>
											<li>A 3 months prior notification for resignation is required If resigned before completion of contracted 2 years period, recruitment charges (SAR 10,000) will be back charged as applicable.</li>
											<li>Must be ready to work in any area in the kingdom with various projects with the job which will be assigned to you.</li>
											<li>I am accepting the usual practice and company policy about the loss or damage of any kind of tools or materials by myself.</li>
											<li>I am promising to develop my knowledge in the field and can utilize for my company development.</li>
										</ul>
									</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="2" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;">
										<p style="direction: rtl;line-height:10px;"> مطلوب إشعار مسبق بالاستقالة لمدة 3 أشهر في حالة الاستقالة قبل إكمال فترة العقد، سيتم إعادة رسوم التأشيرة (3،500 ريال سعودي) ورسوم التوظيف (10000ريال سعودي) حسب الاقتضاء. </p>
										<p style="direction: rtl;line-height:10px;"> يجب أن تكون جاهزًا للعمل في أي منطقة في المملكة بمشاريع مختلفة مع الوظيفة التي سيتم تكليفك بها. </p>
										<p style="direction: rtl;line-height:10px;"> أوافق على الممارسة المعتادة وسياسة الشركة بشأن فقدان أو تلف أي نوع من الأدوات أو المواد بنفسي. </p>
										<p style="direction: rtl;line-height:10px;"> أتعهد بتطوير معرفتي في هذا المجال ويمكنني الاستفادة منها في تطوير شركتي. </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong>Should you find the above offer acceptable, please sign, date and return this letter as soon as possible together with a clear copy of your latest Passport/ Saudi ID/Iqama. This offer is valid for period of (2) days from its date.</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> في حال قبولكم للعرض الوظيفي أعلاه، يرجى التوقيع بالإشارة بالقبول مع ذكر التاريخ أدناه وإعادته لنا بأسرع وقت ممكن مع صورة واضحة من بطاقة أحوال / جواز السفر / اقامة.يسري هذا العرض الوظيفي لمدة (2) أيام من تاريخه. </strong></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table><tr><td height="200px"></td></tr></table>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 10px;">
					<tr style="background-color: #eee;">
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong>A formal contractelectronic of employment by <i>Maha Al Fala Trading Company</i> and yourself, upon your acceptance of this offer, and completion of the above conditions. Your (90) days period of employment will be treated as a probationary periodwhich can be extended for a similar period for another (90) days. All the items mentioned above are subject to the Saudi Labor and Workers Law and all rules and regulations related to it, as well as the regulations, policies and instructions of the company.</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> سوف يتم إصدار عقد توظيف الكتروني رسمي بينكم وبين مؤسسة مها الفلا للتجارةبعد الحصول على قبولكم لهذا العرض الوظيفي، وإنهاء كافة الشروط الوارد ذكرها أعلاه. كما أن توظيفكم سوف يخضع لفترة تجربة لمدة (90) يوما. قابلة لتمديد لـ(90) يوماً اخرى.
تخضع كافة البنود الواردة أعلاه لنظام العمل والعمال السعودي وكافة القواعد والأنظمة المتعلقة به، واللوائح والسياسات والتعليمات الخاصة بالشركة.
 </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong> Many thanks and looking forward to receiving your consent. </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> شكراً لكم وعلى أمل أن نتلقى ردكم قريبا تفضلوا بقبول التحية والتقدير، </strong></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<table>
					<tr style="background-color: #eee;">
						<td colspan="2" valign="center" height="40px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr><td colspan="3" height="50px"></td></tr>
								<tr>
									<td></td>
									<td valign="center" width="38%" style="text-align: center;border-bottom:3px solid #000;"></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="3" valign="center" style="text-align: center;font-size:20px;">
										مؤسسة مها الفلا للتجارة 
									</td>
								</tr>
								<tr>
									<td colspan="3" valign="center" style="text-align: center;font-size:18px;">
										<strong>Maha Al Fala Trading Company</strong>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;"><u>I accept this Offer:</u></td>
									<td style="text-align:center;"></td>
									<td style="text-align:right;direction: rtl;"><u> أوافق على هذا العرض: </u></td>
								</tr>
								<tr style="background-color: #eee;">
									<td style="text-align:left;">Name: </td>
									<td style="text-align:center;"><?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?></td>
									<td style="text-align:right;direction: rtl;"> عبير عبداللهالقبيشي	الاسم: </td>
								</tr>
							</table>
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td style="text-align:left;">Signature:</td>
									<td style="text-align:center;"><strong>Joining Date:</strong></td>
									<td style="text-align:center;"><strong></strong></td>
									<td style="text-align:center;direction: rtl;"> تاريخ المباشرة </td>
									<td style="text-align:right;direction: rtl;">  التوقيع </td>
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
