<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Offer Letter </title>
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
			<td width="5%"></td>
			<td width="90%" colspan="4">
				<table width="100%" border="1" cellspacing="0" cellpadding="3" style="font-size: 10px;border-color:#999;" class="table-bordered">
					<tr>
						<th valign="center" height="20px" style="text-align: left;"><strong>Date</strong></th>
						<td valign="center" height="20px" style="text-align: left;"><strong><?php echo date('d M, Y', strtotime($order->doj)); ?></strong></td>
						<td valign="center" height="20px" style="text-align: right;"><strong><?php echo date('d M, Y', strtotime($order->doj)); ?></strong></td>
						<th valign="center" height="20px" style="text-align: right;"><strong>التاريخ</strong></th>
					</tr>
					<tr>
						<th valign="center" height="20px" style="text-align: left;"><strong>Name</strong></th>
						<td valign="center" height="20px" style="text-align: left;"><strong><?php echo $order->name; ?></strong></td>
						<td valign="center" height="20px" style="text-align: right;"><strong><?php echo $order->arabic_name; ?></strong></td>
						<th valign="center" height="20px" style="text-align: right;"><strong>الاسم</strong></th>
					</tr>
					<tr>
						<th valign="center" height="20px" style="text-align: left;"><strong>Nationality</strong></th>
						<td valign="center" height="20px" style="text-align: left;"><strong><?php echo $order->nationality; ?></strong></td>
						<td valign="center" height="20px" style="text-align: right;"><strong><?php echo $order->nationality; ?></strong></td>
						<th valign="center" height="20px" style="text-align: right;"><strong>الجنسية</strong></th>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="20px" style="text-align: left;"><strong></strong></td>
						<td valign="center" colspan="2" height="20px" style="text-align: right;"><strong></strong></td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="20px" style="text-align: left;"><strong><b>Maha Al Fala Trading Company</b></strong> is pleased to offer you employment on the following terms and conditions:</td>
						<td valign="center" colspan="2" height="20px" style="text-align: right;"><strong>يسر مؤسسة مها الفلا للتجارة أن تقدم لكم هذا العرض الوظيفي وفق البنود والشروط التالية:</strong></td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Job Title</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left">Delivery Rider</td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Total Salary</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->total_salary != '') ? $salary->total_salary : 'NA'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Basic Salary</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->basic != '') ? $salary->basic : 'NS'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Housing Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->housing != '') ? $salary->housing : 'Company Provided - Camp'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Transportation Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->transport_allowance != '') ? $salary->transport_allowance : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Food Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->food != '') ? $salary->food : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Internet Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->internet != '') ? $salary->internet : 'Company Provided'; ?></td>
								</tr>
						
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Bike Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->bike_allowance != '') ? $salary->bike_allowance : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Bike Maintenance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->bike_allowance != '') ? $salary->bike_allowance : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Petrol</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->petrol != '') ? $salary->petrol : 'Company Provided'; ?></td>
								</tr>

								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Annual Vacation</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->annual_vacation != '') ? $salary->annual_vacation : 'NA'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Medical Insurance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->medical_insurance != '') ? $salary->medical_insurance : 'NA'; ?></td>
								</tr>
								
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Contract Period</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->contract_period != '') ? $salary->contract_period : 'NA'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Monthly Target</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->monthly_orders != '') ? $salary->monthly_orders : 'NA'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Bonus</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($salary->daily_commision != '') ? $salary->daily_commision.' per Delivery' : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-right:1px solid #000;text-align:left">Deduction</td>
									<td width="6%" style="border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="text-align:left"><?php echo ($salary->deduction != '') ? $salary->deduction : 'NA'; ?></td>
								</tr>
								
							</table>
						</td>
						<td valign="center" colspan="2" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"> راكب التسليم </td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">المسمى الوظيفي</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->total_salary != '') ? $salary->total_salary.' ر.س.' : 'NA'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الراتب الإجمالي</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->basic != '') ? $salary->basic.' ر.س.' : 'NA'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الراتب الأساسي</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->housing_ar != '') ? $salary->housing_ar : 'قدمت الشركة - كامب'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل سكن</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->transport_allowance_ar != '') ? $salary->transport_allowance_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل مواصلات</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->food != '') ? $salary->food.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل الطعام</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->internet_ar != '') ? $salary->internet_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل الإنترنت</td>
								</tr>
								
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->bike_allowance_ar != '') ? $salary->bike_allowance_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل الدراجة النارية</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->bike_maintain_ar != '') ? $salary->bike_maintain_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">صيانة الدراجة النارية</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->petrol_ar != '') ? $salary->petrol_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بنزين</td>
								</tr>

								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->annual_vacation_ar != '') ? $salary->annual_vacation_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الإجازة السنوية</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->medical_insurance_ar != '') ? $salary->medical_insurance_ar : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">التأمين الصحي</td>
								</tr>
								
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->contract_period_ar != '') ? $salary->contract_period_ar : 'NA'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">مدة العقد</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->monthly_orders != '') ? $salary->monthly_orders .'التسلي م' : 'NA'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الهدف الشهري</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($salary->daily_commision != '') ? $salary->daily_commision.' ر.س.' : 'NA'; ?> ر.س. لكل توصيل</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">علاوة</td>
								</tr>
								
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right"><?php echo ($salary->deduction_ar != '') ? $salary->deduction_ar : 'NA'; ?></td>
									<td width="6%" style="border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="text-align:right">الاستقطاع</td>
								</tr>
								
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="20px" style="text-align: left;text-decoration:underline;"><strong><b>This offer is further subjected to the following conditions:</b></strong></td>
						<td valign="center" colspan="2" height="20px" style="text-align: right;text-decoration:underline;"><strong>هذا العرض خاضع للشروط التالية:</strong></td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">
							<ul>
								<li>That the Saudi Arabian authorities do not object to the employee working for the company.</li>
							</ul>
						</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">
							أن لا يكون لدى السلطات الرسمية أي اعتراض على عملكم لدى الشركة.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">
							<ul>
								<li>That the employee is in satisfactory physical condition to perform the work that will be assigned thereto (you will be required to obtain a medical exam clearance).</li>
							</ul>
						</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">
							أن يبين الكشف الطبي أن حالتكم الصحية والجسدية تؤهلكم للقيام بهمام العمل الوظيفية.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">
							<ul>
								<li>That all information provided to the company including education and work experience is true & accurate.</li>
							</ul>
						</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">
							صحة المعلومات والشهادات والبيانات التي تقدمتم بها للشركة والتي تشكل عنصرا جوهريا في اختياركم للعمل.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">
							<ul>
								<li>Execution of and employment contract with the company.</li>
							</ul>
						</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">
							إبرام عقد التوظيف مع ال ر شكة .
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">
							<ul>
								<li>A 3 months prior notification for resignation is required If resigned before completion of contracted period, Visa Fees (SAR 3,500) and recruitment charges (SAR 3,750) will be back charged as applicable.</li>
								<li>Must be ready to work in any area in the kingdom with various projects with the job which will be assigned to you.</li>
								<li>I am accepting the usual practice and company policy about the loss or damage of any kind of tools or materials by myself.</li>
								<li>I am promising to develop my knowledge in the field and can utilize for my company development.</li>
								<li>Due to non-achieving of daily delivery target of 12 Deliveries, I agree that company is eligible for the deduction as per company policy.</li>
								
							</ul>
						</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">
							مطلوب إشعار مسبق بالاستقالة لمدة 3 أشهر في حالة الاستقالة قبل إكمال فترة العقد ، سيتم إعادة رسوم التأشيرة (3،500 ريال سعودي) ورسوم التوظيف (3،750 ريال سعودي) حسب الاقتضاء. <br>
							يجب أن تكون جاهزًا للعمل في أي منطقة في المملكة بمشاريع مختلفة مع الوظيفة التي سيتم تكليفك بها. <br>
							أوافق على الممارسة المعتادة وسياسة الشركة بشأن فقدان أو تلف أي نوع من الأدوات أو المواد بنفسي. <br>
							أتعهد بتطوير معرفتي في هذا المجال ويمكنني الاستفادة منها في تطوير شركتي. <br>
							نظرًا لعدم تحقيق هدف التوصيل اليومي البالغ 12 عملية توصيل ، أوافق على أن الشركة مؤهلة للخصم وفقًا لسياسة الشركة
							
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (1)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 1</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							The Second Party works for the First Party under his management or supervision of his representative or anybody who replaces him in accordance with terms of this contract or any supplements that included above.
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يعمل الطرف الثاني لحساب الطرف الأول تحت إدارته أو إشراف ممثله أو أي شخص يحل محله وفقًا لبنود هذا العقد أو أي ملاحق واردة أعلاه.
						</td>
					</tr>

					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (2)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 2</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							The Company reserves right to redistribute or withdraw any of the above benefits at any time depending on the place of posting and Company policy.
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						تحتفظ الشركة بالحق في إعادة توزيع أو سحب أي من المزايا المذكورة أعلاه في أي وقت حسب مكان النشر وسياسة الشركة.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (3)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 3</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The type of contract if “definite” period contract, this contract shall be valid as per Article (1) above, and it will be automatically renewed for the same period unless one of the parties notify the other party in a written letter his desire not to renew it before ONE MONTH of the expiration date or his desire to make a new contract with new clauses decided by the two parties.<br><br>
							The Second Party shall serve this notice period without lacking in work progress and transfer with the knowledge of the First Party, all material, data in possession, status reports, and all that is required for smooth handover of responsibilities.<br><br>
							However, the First Party at its sole discretion reserves the right to pay salary in lieu of such notice period, and or to adjust this notice period from any leave due to the second party or recover such amount towards notice period shortfall.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<p>
							نوع العقد إذا كان العقد "محدد المدة"، يكون هذا العقد ساري المفعول وفقًا للمادة (1) أعلاه، ويتم تجديده تلقائيًا لنفس المدة ما لم يخطر أحد الطرفين الطرف الآخر بخطاب مكتوب برغبته في عدم رغبته في ذلك. لتجديده قبل شهر واحد من تاريخ انتهاء الصلاحية أو رغبته في إبرام عقد جديد ببنود جديدة يقررها الطرفان.
							</p>
							<p>
							سيخدم الطرف الثاني فترة الإشعار هذه دون نقص في سير العمل ونقله بمعرفة الطرف الأول، وجميع المواد والبيانات الموجودة في حوزته وتقارير الحالة وكل ما هو مطلوب لتسليم المسؤوليات بسلاسة.
							</p>
							<p>
							ومع ذلك، يحتفظ الطرف الأول وفقًا لتقديره الخاص بالحق في دفع الراتب بدلاً من فترة الإشعار هذه، و / أو تعديل فترة الإشعار هذه من أي إجازة مستحقة للطرف الثاني أو استرداد هذا المبلغ مقابل نقص فترة الإخطار.
							</p>
						</td>
					</tr>

					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (4)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 4</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party will be subjected to a probation period for (60) Days effective from the date of starting his work with the First Party, during which the two parties have the right to terminate this contract without pre-notification, compensation and/or entitlement and without obligation to mention the reasons. Second party will receive his rights until the date of termination.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						سيخضع الطرف الثاني لفترة اختبار لمدة (60) يومًا اعتبارًا من تاريخ بدء عمله مع الطرف الأول، والتي يحق خلالها للطرفين إنهاء هذا العقد دون إشعار مسبق أو تعويض و / أو استحقاق. وبدون التزام بذكر الأسباب. يستلم الطرف الثاني حقوقه حتى تاريخ الإنهاء..
						</td>
					</tr>

					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (5)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 5</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party shall be responsible to carry out all the activities as per safety norms of the First Party and it will be one of the points to consider in the renewal of the contract, and the Second Party is responsible for taking the required care to maintain the tools and the equipment he uses or controls regarding his work which are owned by the first party.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يكون الطرف الثاني مسؤولاً عن تنفيذ جميع الأنشطة وفقًا لمعايير السلامة الخاصة بالطرف الأول وستكون إحدى النقاط التي يجب مراعاتها عند تجديد العقد، ويكون الطرف الثاني مسؤولاً عن اتخاذ العناية اللازمة للمحافظة الأدوات والمعدات التي يستخدمها أو يتحكم في عمله والتي يملكها الطرف الأول.
						</td>
					</tr>

					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (6)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 6</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The company has the right to adjust the working hours and workdays in accordance with the company requirements and needs in a way that will not contradict with the Saudi Labor Law.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يحق للشركة تعديل ساعات العمل وأيام العمل بما يتناسب مع متطلبات الشركة واحتياجاتها بما لا يتعارض مع قانون العمل السعودي.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (7)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 7</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party acknowledges that all information and the submitted documents are correct and if proves false any one of the certificates or recommendation letter or any document or paper, the First Party has the right to cancel the contract without warning or notification, compensation or entitlement with reserving his full other rights.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يقر الطرف الثاني بأن جميع المعلومات والمستندات المقدمة صحيحة، وإذا ثبت عدم صحة أي من الشهادات أو خطاب التوصية أو أي مستند أو ورقة، يحق للطرف الأول إلغاء العقد دون إنذار أو إخطار أو تعويض أو استحقاق مع يحتفظ بكامل حقوقه الأخرى.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (8)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 8</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party commits to maintain all the data, information and the secrets of the company either administrative or professional and commits not to transfer or use it in a way that harm the interests of the First Party. The employee bears responsibility if harms resulted from utilizing these information, data or secrets and he subject to prosecution in Saudi Arabia and abroad.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يلتزم الطرف الثاني بالمحافظة على كافة البيانات والمعلومات وأسرار الشركة سواء الإدارية أو المهنية ويلتزم بعدم نقلها أو استخدامها بما يضر بمصالح الطرف الأول. يتحمل الموظف المسئولية في حالة حدوث أضرار ناتجة عن استخدام هذه المعلومات أو البيانات أو الأسرار وخضوعه للملاحقة القضائية في المملكة العربية السعودية وخارجها.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (9)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 9</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party commits to fully perform his duty satisfactory and obey the instruction of his supervisors/team leaders and obliges his personal behavior will not contradict the moral of true Islam and the common behavior and not to commit or to do anything that might offenses the Islamic belief and its sanctuaries and he commits to be honest and in case of violation the First Party has the right to cancel and terminated the contract with reserving his full other rights.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يلتزم الطرف الثاني بأداء واجبه بشكل كامل ومرضٍ وامتثال لتعليمات مشرفيه / قادة الفريق ويلتزم بأن سلوكه الشخصي لا يتعارض مع أخلاقيات الإسلام الصحيح والسلوك الشائع وعدم ارتكاب أو فعل أي شيء من شأنه أن يسيء إلى الشريعة الإسلامية. العقيدة ومقدساتها ويلتزم بالصدق وفي حالة المخالفة يحق للطرف الأول إلغاء العقد وفسخه مع الاحتفاظ بكامل حقوقه الأخرى.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (10)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 10</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party undertakes not to work with or without wage with any their employer whether directly or indirectly during the validity of this contract and that applies on working hours, rest hours and vacations.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يتعهد الطرف الثاني بعدم العمل بأجر أو بدون أجر مع أي صاحب عمل بشكل مباشر أو غير مباشر خلال سريان هذا العقد وذلك في ساعات العمل وساعات الراحة والإجازات.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (11)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 11</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The First Party has the right to move the Second Party as work requires, from work agreed upon to any working position not essentially different from it, whether it is in his original working place or any other place inside or outside the Kingdom.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يحق للطرف الأول نقل الطرف الثاني حسب مقتضيات العمل، من العمل المتفق عليه إلى أي وظيفة عمل لا تختلف جوهريًا عنها، سواء كان ذلك في مكان عمله الأصلي أو في أي مكان آخر داخل المملكة أو خارجها.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (12)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 12</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							This contract will be cancelled if any amendment, crossing, or modification occurs, and any modification will be included in separate supplement which will be considered as part of the contract after signed by both parties. As this contract void any previous written agreements with the Second Party.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						سيتم إلغاء هذا العقد في حالة حدوث أي تعديل أو عبور أو تعديل، وسيتم تضمين أي تعديل في ملحق منفصل والذي سيتم اعتباره جزءًا من العقد بعد التوقيع عليه من قبل الطرفين. حيث أن هذا العقد يبطل أي اتفاقيات مكتوبة سابقة مع الطرف الثاني.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (13)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 13</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							In case of the Second Party is absent from work without permission in continuous period of (15) days or in non-continuous period of (30) days during one year, the First Party has the right to terminate his contract in accordance with Saudi Labor Law.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						في حال تغيب الطرف الثاني عن العمل دون إذن لمدة (15) يوماً متواصلة أو في فترة غير متصلة (30) يوماً خلال سنة واحدة، يحق للطرف الأول إنهاء عقده وفقاً للعمالة السعودية. قانون.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (14)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 14</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The First Party has the right to terminate this contract without pre-notification or compensation, if the Second Party commits any violation mentioned in article 80 from Saudi Labor Law.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يحق للطرف الأول إنهاء هذا العقد دون إخطار مسبق أو تعويض إذا ارتكب الطرف الثاني أي مخالفة واردة في المادة 80 من نظام العمل السعودي.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (15)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 15</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party obligates to provide help without requiring extra charges in case of disasters and dangers threat the work place or the workmen.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يلتزم الطرف الثاني بتقديم المساعدة دون الحاجة إلى رسوم إضافية في حالة الكوارث والأخطار التي تهدد مكان العمل أو العمال.
						</td>
					</tr>

					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (16)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 16</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The Second Party obligates to register his attendance and leaving time the way the First Party requires.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يلتزم الطرف الثاني بتسجيل حضوره ووقت المغادرة بالطريقة التي يطلبها الطرف الأول.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (17)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 17</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							Upon termination of this contract, the company may withhold from employee’s final settlement, such amounts to cover expenses paid or advances made by the company on Employee’s behalf, and or fines and or debts that must be recovered according to judicial judgments. In the event the amount withheld does not cover the expenses or advances, employee shall pay the difference to the company within (30) days after receipt of the company’s claim, otherwise the company shall be entitled to recover its rights by all valid legal procedures.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						عند إنهاء هذا العقد، يجوز للشركة أن تحجب من التسوية النهائية للموظف، مثل هذه المبالغ لتغطية النفقات المدفوعة أو السلف التي قدمتها الشركة نيابة عن الموظف، و / أو الغرامات و / أو الديون التي يجب استردادها وفقًا للأحكام القضائية. في حالة عدم تغطية المبلغ المحتجز المصاريف أو السلف، يجب على الموظف دفع الفرق للشركة في غضون (30) يومًا من استلام مطالبة الشركة، وإلا يحق للشركة استرداد حقوقها بجميع الإجراءات القانونية السارية.
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (18)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 18</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							The First Party reserves the right to verify Second Party documents, written and verbal declarations submitted at the time of applying for this assignment and check background through internal or external agencies. These may include Second Party’s current and previous employment history, educational and professional credentials, and other background checks. In the event of any discrepancies, inconsistencies, inaccuracies surface out of the above verification and background checks, the First Party has the right to terminate this contract without pre-notification or compensation.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
						يحتفظ الطرف الأول بالحق في التحقق من مستندات الطرف الثاني والإعلانات المكتوبة والشفوية المقدمة في وقت التقدم لهذه المهمة والتحقق من الخلفية من خلال وكالات داخلية أو خارجية. قد تشمل هذه سجلات العمل الحالية والسابقة للطرف الثاني، وبيانات الاعتماد التعليمية والمهنية، وعمليات التحقق الأخرى من الخلفية. في حالة ظهور أي تناقضات أو تناقضات أو عدم دقة خارج التحقق أعلاه والتحقق من الخلفية، يحق للطرف الأول إنهاء هذا العقد دون إشعار مسبق أو تعويض.
						</td>
					</tr>

					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<h4>Article No (19)</h4>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<h4>المادة رقم ) 19</h4>
						</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" style="text-align: left;">
							<p>
							All dates and time periods referenced in this contract refer to the Gregorian calendar unless otherwise specified.
							</p>
						</td>
						<td valign="center" colspan="2" style="text-align: right;">
							<p>
							تشير جميع التواريخ والفترات الزمنية المشار إليها في هذا العقد إلى التقويم الميلادي ما لم ينص على خلاف ذلك.
							</p>
							<p>
							تم إصدار نسختين أصليتين من هذا العقد في (3) صفحات باللغتين العربية والإنجليزية، ووقع كل طرف على النسخ الأصلية بعد الرضا والقبول.
							</p>
						</td>
					</tr>
					
					<!--- Articles --->
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">Should you find the above offer acceptable, please sign, date and return this letter as soon as possible together with a clear copy of your latest Passport/ Saudi ID/Iqama. This offer is valid for period of (2) days from its date.</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">في حال قبولكم للعرض الوظيفي أعلاه يرجى التوقيع بالإشارة بالقبول مع ذكر التاريخ أدناه وإعادته <br> لنا بأسرع وقت ممكن مع صورة واضحة من بطاقة أحوال / جواز السفر / اقامة.   يسري هذا العرض الوظيفي لمدة (2) أيام من تاريخه.</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">A formal contract electronic of employment by Maha Al Fala Trading Company and yourself, upon your acceptance of this offer, and completion of the above conditions. Your (90) days period of employment will be treated as a probationary period which can be extended for a similar period for another (90) days. All the items mentioned above are subject to the Saudi Labor and Workers Law and all rules and regulations related to it, as well as the regulations, policies and instructions of the company.</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">سوف يتم إصدار عقد توظيف الكتروني رسمي بينكم وبين مؤسسة مها الفلا للتجارة بعد الحصول <br> على قبولكم لهذا العرض الوظيفي، وإنهاء كافة الشروط الوارد ذكرها أعلاه. كما أن توظيفكم <br> سوف يخضع لفترة تجربة لمدة (90) يوما. قابلة لتمديد لـ( 90 ) يوماً اخرى . <br>
تخضع كافة البنود الواردة أعلاه لنظام العمل والعمال السعودي وكافة القواعد والأنظمة المتعلقة <br> به، واللوائح والسياسات والتعليمات الخاصة بالشركة.</td>
					</tr>
					<tr>
						<td valign="center" colspan="2" height="30px" style="text-align: left;">Many thanks and looking forward to receiving your consent.</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">شكراً لكم وعلى أمل أن نتلقى ردكم قريبا تفضلوا بقبول التحية والتقدير،</td>
					</tr>
					<tr>
						<td width="36%"></td>
						<td width="28%" valign="bottom" colspan="2" height="60px" style="text-align: center;align:bottom;">
						<br><br> <strong>
							مؤسسة مها الفلا للتجارة<br>
							Maha Al Fala Trading company </strong>
						</td>
						<td width="36%" valign="bottom" height="60px" style="text-align: right;"></td>
					</tr>
					<tr>
						<td width="36%">I accept this Offer:</td>
						<td width="28%" valign="bottom" colspan="2" height="20px" style="text-align: center;align:bottom;"></td>
						<td width="36%" valign="bottom" height="20px" style="text-align: right;">أوافق على هذا العرض:</td>
					</tr>
					<tr>
						<td width="36%">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Name</td>
									<td width="70%" style="text-align:left"><?php echo $order->name; ?></td>
								</tr>
							</table>
						</td>
						<td width="28%" valign="bottom" colspan="2" height="20px" style="text-align: center;"></td>
						<td width="36%" valign="bottom" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $order->arabic_name; ?></td>
									<td width="30%" style="text-align:right">الاسم:</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width="30%" colspan="2">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="36%" style="border-right:1px solid #000;">Signature:</td>
									<td width="64%" style="text-align:right"></td>
								</tr>
							</table>
						</td>
						<td width="40%" valign="bottom" colspan="3" height="20px" style="text-align: center;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Joining Date:</td>
									<td width="40%" style="border-right:1px solid #000;"><?php echo date('d M, Y', strtotime($order->doj)); ?></td>
									<td width="30%" style="text-align:right">تاريخ المباشرة:</td>
								</tr>
							</table>
						</td>
						<td width="30%" colspan="2" valign="bottom" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="64%" style="border-right:1px solid #000;"></td>
									<td width="36%" style="text-align:right">التوقيع:</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td width="5%"></td>
		</tr>
	</table>
</body>

</html>
