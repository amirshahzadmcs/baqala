<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Rider Agreement</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">

		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;">
					<tr>
						<td valign="top" height="20px" colspan="2" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>1st: First Party Data (Employer)</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;"><strong>Maha Al Fala Trading Est.</strong></td>
						<td valign="top" height="20px" style="text-align: right;"><strong>مؤسسة مها الفلا للتجارة</strong></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3"><br></td>
		</tr>
		<tr>
			<td colspan="3" style="padding-top:20px;">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;margin-top:15px;">
					
					<tr>
						<td valign="top" height="20px" colspan="3" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>2nd: Second Party Data (Employee)</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Date:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo date('d M Y');?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">التاريخ:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Name:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo $order->name;?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">الاسم:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Nationality:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo $order->nationality;?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">الجنسية:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Passport:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo $order->passport;?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">الجواز:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Id/Iqama:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo isset($order->iqama_no) ? $order->iqama_no : 'NA';?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">رقم الاقام:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Date Of Birth:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo date('d-m-Y', strtotime($order->dob));?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">تاريخ الميلاد:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Marital Status:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo ($order->marital_status == '1') ? 'Single' : 'Married';?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">الحالة الحالة الإجتماعية:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="3" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>Employment Terms:</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Date Of Joining:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?php echo date('d-m-Y', strtotime($order->doj));?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">تاريخ الانضمام:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Job Title:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>Food Delivery Associate</strong></td>
						<td valign="top" height="20px" style="text-align: left;">التاريخ:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Contract Status:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>Single Status</strong></td>
						<td valign="top" height="20px" style="text-align: left;">حالة التعاقد:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Emp. Term:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>Two (2) Year Renewable</strong></td>
						<td valign="top" height="20px" style="text-align: left;">شروط الموظف:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Working Hours:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>Open</strong></td>
						<td valign="top" height="20px" style="text-align: left;">ساعات العمل:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Probation Period:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>Three (3) Months</strong></td>
						<td valign="top" height="20px" style="text-align: left;">فترة اختبار:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Vacation:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong><?= $salary->annual_vacation;?></strong></td>
						<td valign="top" height="20px" style="text-align: left;">الاجازة:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">EOS:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>As Per Saudi Labor Law</strong></td>
						<td valign="top" height="20px" style="text-align: left;">نهاية الخدمة:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: right;">Medical:</td>
						<td valign="top" height="20px" style="text-align: center;"><strong>As Per Company Policy (Employee Only)</strong></td>
						<td valign="top" height="20px" style="text-align: left;">التامين الصحي:</td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="3" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>Work with E-Commerce Application</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="8">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="14%" style="border-right:1px solid #000;text-align:center;">Baqala Station</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Jahez</td>
									<td width="14%" style="border-right:1px solid #000;text-align:center;">Hunger Station</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Chefz</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Noon</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Faster</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Masrool</td>
									<td width="12%" style="text-align:center;">To You</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="3" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>Package (Monthly):</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="8">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="14%" style="border-right:1px solid #000;text-align:center;">Basic</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Housing</td>
									<td width="14%" style="border-right:1px solid #000;text-align:center;">Food</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Internet</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Bike</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Bike Maint.</td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;">Petrol</td>
									<td width="12%" style="text-align:center;">Insurance</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="8" style="background-color: #adc47f;color:#000;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="14%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->basic; ?></td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->housing; ?></td>
									<td width="14%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->food; ?></td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->internet; ?></td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->bike_allowance; ?></td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->bike_maintain; ?></td>
									<td width="12%" style="border-right:1px solid #000;text-align:center;"><?php echo $salary->petrol; ?></td>
									<td width="12%" style="text-align:center;"><?php echo $salary->medical_insurance; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" colspan="3" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>Commission</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" width="26.5%" style="text-align: left;">Daily</td>
						<td valign="top" height="20px" width="25.5%" style="text-align: left;"><?php echo $salary->daily_orders; ?> Delivery</td>
						<td valign="top" height="20px" width="48%" style="text-align: left;">SAR <?php echo number_format((float)$salary->daily_commision, 2, '.', ''); ?> Per Delivery after <?php echo $salary->daily_orders; ?> Deliveries Daily</td>
					</tr>
					<tr>
						<td valign="top" height="20px" width="26.5%" style="text-align: left;">Monthly</td>
						<td valign="top" height="20px" width="25.5%" style="text-align: left;"><?php echo $salary->monthly_orders; ?> Deliveries</td>
						<td valign="top" height="20px" width="48%" style="text-align: left;">Average Monthly <?php echo $salary->monthly_orders; ?> Delivers counted for Commission</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3"><br></td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;">
					<tr>
						<td valign="top" height="20px" style="background-color: #000;color:#fff;text-decoration:underline;"><strong>OTHER CONDITIONS (IF ANY):</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ul>
								<?php 
									$total_orders = $salary->monthly_orders * 95 / 100;
								?>
								<li valign="top" height="15px" style="text-align: left;line-height:1.5;">Minimum <?php echo $salary->monthly_orders; ?> orders per month with the orders acceptance rate of 95%. ( <?php echo $total_orders; ?> Orders)</li>
								<li valign="top" height="15px" style="text-align: left;line-height:1.5;">The rejection rate of orders will be strictly monitored so it does not exceed <?php echo $salary->rejection_rate; ?>%, and necessary action will be taken if it exceeds <?php echo $salary->rejection_rate; ?>%.</li>
								<li valign="top" height="15px" style="text-align: left;line-height:1.5;">Delivering more than <?php echo $salary->monthly_orders; ?> orders per month will pay <?php echo number_format((float)$salary->daily_commision, 2, '.', ''); ?> SAR bonus for additional delivered order.</li>
								<li valign="top" height="15px" style="text-align: left;line-height:1.5;">Probation period of three months after three months if less than <?php echo $salary->monthly_orders; ?> orders monthly action will be taken.</li>
								<li valign="top" height="15px" style="text-align: left;line-height:1.5;">Off days during weekdays not weekend.</li>
								<li valign="top" height="15px" style="text-align: right;line-height:1.5;">حد أدنى <?php echo $salary->monthly_orders; ?> طلب في الشهر مع معدل قبول 95٪. (<?php echo $total_orders; ?> طلبات)</li>
								<li valign="top" height="15px" style="text-align: right;line-height:1.5;">سيتم مراقبة معدل رفض الطلبات بدقة بحيث لا يتجاوز <?php echo $salary->rejection_rate; ?>٪، وسيتم اتخاذ الإجراءات اللازمة إذا تجاوزت <?php echo $salary->rejection_rate; ?>٪.</li>
								<li valign="top" height="15px" style="text-align: right;line-height:1.5;">تسليم أكثر من <?php echo $salary->monthly_orders; ?> طلبًا شهريًا سيدفع <?php echo number_format((float)$salary->daily_commision, 2, '.', ''); ?> ريال سعودي مكافأة للطلبات الإضافية التي تم تسليمها.</li>
								<li valign="top" height="15px" style="text-align: right;line-height:1.5;">فترة اختبار لمدة شهرين بعد شهرين إذا كان سيتم اتخاذ إجراء شهريًا أقل من <?php echo $salary->monthly_orders; ?> طلبًا.</li>
								<li valign="top" height="15px" style="text-align: right;line-height:1.5;">أيام الراحة خلال أيام الأسبوع وليس عطلة نهاية الأسبوع.</li>
							</ul>							
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 10px;">
					<tr>
						<td valign="top" colspan="2" height="20px" style="background-color: #5f7d22;color:#fff;text-decoration:underline;"><strong>TERMS AND CONDITIONS OF THE CONTRACT</strong></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (1)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (1)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">The Second Party works for the First Party under his management or supervision of his representative or anybody who replaces him in accordance with terms of this contract or any supplements that included above.</td>
						<td valign="top" height="20px" style="text-align: right;">يعمل الطرف الثاني لحساب الطرف الأول تحت إدارته أو إشراف ممثله أو أي شخص يحل محله وفقًا لبنود هذا العقد أو أي ملاحق واردة أعلاه.</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (2)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (2)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">The Company reserves right to redistribute or withdraw any of the above benefits at any time depending on the place of posting and Company policy.</td>
						<td valign="top" height="20px" style="text-align: right;">تحتفظ الشركة بالحق في إعادة توزيع أو سحب أي من المزايا المذكورة أعلاه في أي وقت حسب مكان النشر وسياسة الشركة.</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (3)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (3)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The type of contract if “definite” period contract, this contract shall be valid as per Article (1) above, and it will be automatically renewed for the same period unless one of the parties notify the other party in a written letter his desire not to renew it before ONE MONTH of the expiration date or his desire to make a new contract with new clauses decided by the two parties.
							<br><br>
							The Second Party shall serve this notice period without lacking in work progress and transfer with the knowledge of the First Party, all material, data in possession, status reports, and all that is required for smooth handover of responsibilities.
							<br><br>
							However, the First Party at its sole discretion reserves the right to pay salary in lieu of such notice period, and or to adjust this notice period from any leave due to the second party or recover such amount towards notice period shortfall.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						نوع العقد إذا كان العقد "محدد المدة"، يكون هذا العقد ساري المفعول وفقًا للمادة (1) أعلاه، ويتم تجديده تلقائيًا لنفس المدة ما لم يخطر أحد الطرفين الطرف الآخر بخطاب مكتوب برغبته في عدم رغبته في ذلك. لتجديده قبل شهر واحد من تاريخ انتهاء الصلاحية أو رغبته في إبرام عقد جديد ببنود جديدة يقررها الطرفان.
						<br><br>
						سيخدم الطرف الثاني فترة الإشعار هذه دون نقص في سير العمل ونقله بمعرفة الطرف الأول، وجميع المواد والبيانات الموجودة في حوزته وتقارير الحالة وكل ما هو مطلوب لتسليم المسؤوليات بسلاسة.
						<br><br>
						ومع ذلك، يحتفظ الطرف الأول وفقًا لتقديره الخاص بالحق في دفع الراتب بدلاً من فترة الإشعار هذه، و / أو تعديل فترة الإشعار هذه من أي إجازة مستحقة للطرف الثاني أو استرداد هذا المبلغ مقابل نقص فترة الإخطار.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (4)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (4)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The Second Party will be subjected to a probation period for (60) Days effective from the date of starting his work with the First Party, during which the two parties have the right to terminate this contract without pre-notification, compensation and/or entitlement and without obligation to mention the reasons. Second party will receive his rights until the date of termination.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							سيخضع الطرف الثاني لفترة اختبار لمدة (60) يومًا اعتبارًا من تاريخ بدء عمله مع الطرف الأول، والتي يحق <br> خلالها للطرفين إنهاء هذا العقد دون إشعار مسبق أو تعويض و / أو استحقاق. وبدون التزام بذكر الأسباب. يستلم الطرف الثاني حقوقه حتى تاريخ الإنهاء.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (5)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (5)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The Second Party shall be responsible to carry out all the activities as per safety norms of the First Party and it will be one of the points to consider in the renewal of the contract, and the Second Party is responsible for taking the required care to maintain the tools and the equipment he uses or controls regarding his work which are owned by the first party.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							يكون الطرف الثاني مسؤولاً عن تنفيذ جميع الأنشطة وفقًا لمعايير السلامة الخاصة بالطرف الأول وستكون <br> إحدى النقاط التي يجب مراعاتها عند تجديد العقد، ويكون الطرف الثاني مسؤولاً عن اتخاذ العناية اللازمة <br> للمحافظة الأدوات والمعدات التي يستخدمها أو يتحكم في عمله والتي يملكها الطرف الأول.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (6)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (6)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The company has the right to adjust the working hours and workdays in accordance with the company requirements and needs in a way that will not contradict with the Saudi Labor Law.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							يحق للشركة تعديل ساعات العمل وأيام العمل بما يتناسب مع متطلبات الشركة واحتياجاتها بما لا يتعارض <br> مع قانون العمل السعودي.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (7)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (7)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The Second Party acknowledges that all information and the submitted documents are correct and if proves false any one of the certificates or recommendation letter or any document or paper, the First Party has the right to cancel the contract without warning or notification, compensation or entitlement with reserving his full other rights.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يقر الطرف الثاني بأن جميع المعلومات والمستندات المقدمة صحيحة، وإذا ثبت عدم صحة أي من الشهادات أو خطاب التوصية أو أي مستند أو ورقة، يحق للطرف الأول إلغاء العقد دون إنذار أو إخطار أو تعويض أو استحقاق مع يحتفظ بكامل حقوقه الأخرى.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (8)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (8)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The Second Party commits to maintain all the data, information and the secrets of the company either administrative or professional and commits not to transfer or use it in a way that harm the interests of the First Party. The employee bears responsibility if harms resulted from utilizing these information, data or secrets and he subject to prosecution in Saudi Arabia and abroad.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يلتزم الطرف الثاني بالمحافظة على كافة البيانات والمعلومات وأسرار الشركة سواء الإدارية أو المهنية ويلتزم بعدم نقلها أو استخدامها بما يضر بمصالح الطرف الأول. يتحمل الموظف المسئولية في حالة حدوث أضرار <br> ناتجة عن استخدام هذه المعلومات أو البيانات أو الأسرار وخضوعه للملاحقة القضائية في المملكة العربية <br> السعودية وخارجها.
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">Article No (9)</td>
						<td valign="center" height="20px" style="text-align: right;">المادة رقم (9)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The Second Party commits to fully perform his duty satisfactory and obey the instruction of his supervisors/team leaders and obliges his personal behavior will not contradict the moral of true Islam and the common behavior and not to commit or to do anything that might offenses the Islamic belief and its sanctuaries and he commits to be honest and in case of violation the First Party has the right to cancel and terminated the contract with reserving his full other rights.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يلتزم الطرف الثاني بأداء واجبه بشكل كامل ومرضٍ وامتثال لتعليمات مشرفيه / قادة الفريق ويلتزم بأن <br> سلوكه الشخصي لا يتعارض مع أخلاقيات الإسلام الصحيح والسلوك الشائع وعدم ارتكاب أو فعل أي شيء <br> من شأنه أن يسيء إلى الشريعة الإسلامية. العقيدة ومقدساتها ويلتزم بالصدق وفي حالة المخالفة يحق للطرف الأول إلغاء العقد وفسخه مع الاحتفاظ بكامل حقوقه الأخرى.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (10)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (10)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The Second Party undertakes not to work with or without wage with any their employer whether directly or indirectly during the validity of this contract and that applies on working hours, rest hours and vacations.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يتعهد الطرف الثاني بعدم العمل بأجر أو بدون أجر مع أي صاحب عمل بشكل مباشر أو غير مباشر خلال سريان <br> هذا العقد وذلك في ساعات العمل وساعات الراحة والإجازات.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (11)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (11)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The First Party has the right to move the Second Party as work requires, from work agreed upon to any working position not essentially different from it, whether it is in his original working place or any other place inside or outside the Kingdom.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يحق للطرف الأول نقل الطرف الثاني حسب مقتضيات العمل، من العمل المتفق عليه إلى أي وظيفة عمل لا تختلف جوهريًا عنها، سواء كان ذلك في مكان عمله الأصلي أو في أي مكان آخر داخل المملكة أو خارجها.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (12)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (12)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						This contract will be cancelled if any amendment, crossing, or modification occurs, and any modification will be included in separate supplement which will be considered as part of the contract after signed by both parties. As this contract void any previous written agreements with the Second Party.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						سيتم إلغاء هذا العقد في حالة حدوث أي تعديل أو عبور أو تعديل، وسيتم تضمين أي تعديل في ملحق منفصل والذي سيتم اعتباره جزءًا من العقد بعد التوقيع عليه من قبل الطرفين. حيث أن هذا العقد يبطل أي اتفاقيات مكتوبة سابقة مع الطرف الثاني.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (13)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (13)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						In case of the Second Party is absent from work without permission in continuous period of (15) days or in non-continuous period of (30) days during one year, the First Party has the right to terminate his contract in accordance with Saudi Labor Law.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						في حال تغيب الطرف الثاني عن العمل دون إذن لمدة (15) يوماً متواصلة أو في فترة غير متصلة (30) يوماً خلال سنة واحدة، يحق للطرف الأول إنهاء عقده وفقاً للعمالة السعودية. قانون.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (14)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (14)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The First Party has the right to terminate this contract without pre-notification or compensation, if the Second Party commits any violation mentioned in article 80 from Saudi Labor Law.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يحق للطرف الأول إنهاء هذا العقد دون إخطار مسبق أو تعويض إذا ارتكب الطرف الثاني أي مخالفة واردة في المادة 80 من نظام العمل السعودي.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (15)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (15)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The Second Party obligates to provide help without requiring extra charges in case of disasters and dangers threat the work place or the workmen.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يلتزم الطرف الثاني بتقديم المساعدة دون الحاجة إلى رسوم إضافية في حالة الكوارث والأخطار التي تهدد مكان العمل أو العمال.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (16)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (16)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The Second Party obligates to register his attendance and leaving time the way the First Party requires.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يلتزم الطرف الثاني بتسجيل حضوره ووقت المغادرة بالطريقة التي يطلبها الطرف الأول.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (17)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (17)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						Upon termination of this contract, the company may withhold from employee's final settlement, such amounts to cover expenses paid or advances made by the company on Employee's behalf, and or fines and or debts that must be recovered according to judicial judgments. In the event the amount withheld does not cover the expenses or advances, employee shall pay the difference to the company within (30) days after receipt of the company's claim, otherwise the company shall be entitled to recover its rights by all valid legal procedures.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						عند إنهاء هذا العقد، يجوز للشركة أن تحجب من التسوية النهائية للموظف، مثل هذه المبالغ لتغطية النفقات المدفوعة أو السلف التي قدمتها الشركة نيابة عن الموظف، و / أو الغرامات و / أو الديون التي يجب استردادها وفقًا للأحكام القضائية. في حالة عدم تغطية المبلغ المحتجز المصاريف أو السلف، يجب على الموظف دفع الفرق للشركة في غضون (30) يومًا من استلام مطالبة الشركة، وإلا يحق للشركة استرداد حقوقها بجميع الإجراءات القانونية السارية.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (18)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (18)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						The First Party reserves the right to verify Second Party documents, written and verbal declarations submitted at the time of applying for this assignment and check background through internal or external agencies. These may include Second Party's current and previous employment history, educational and professional credentials, and other background checks. In the event of any discrepancies, inconsistencies, inaccuracies surface out of the above verification and background checks, the First Party has the right to terminate this contract without pre-notification or compensation.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						يحتفظ الطرف الأول بالحق في التحقق من مستندات الطرف الثاني والإعلانات المكتوبة والشفوية المقدمة في وقت التقدم لهذه المهمة والتحقق من الخلفية من خلال وكالات داخلية أو خارجية. قد تشمل هذه سجلات العمل الحالية والسابقة للطرف الثاني، وبيانات الاعتماد التعليمية والمهنية، وعمليات التحقق الأخرى من الخلفية. في حالة ظهور أي تناقضات أو تناقضات أو عدم دقة خارج التحقق أعلاه والتحقق من الخلفية، يحق للطرف <br> الأول إنهاء هذا العقد دون إشعار مسبق أو تعويض.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">Article No (19)</td>
						<td valign="top" height="20px" style="text-align: right;">المادة رقم (19)</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
						All dates and time periods referenced in this contract refer to the Gregorian calendar unless otherwise specified.
						<br><br>
						Two (2) original copies have been issued of this contract in (3) pages in Arabic and English Languages, each party signed both original copies after satisfaction and acceptance.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
						تشير جميع التواريخ والفترات الزمنية المشار إليها في هذا العقد إلى التقويم الميلادي ما لم ينص على خلاف ذلك.
						<br><br>
						تم إصدار نسختين أصليتين من هذا العقد في (3) صفحات باللغتين العربية والإنجليزية، ووقع كل طرف على النسخ الأصلية بعد الرضا والقبول.
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
