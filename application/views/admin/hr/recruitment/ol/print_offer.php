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
						<td valign="center" height="20px" style="text-align: left;"><strong><?php echo date('d M, Y', strtotime($open_date)); ?></strong></td>
						<td valign="center" height="20px" style="text-align: right;"><strong><?php echo date('d M, Y', strtotime($open_date)); ?></strong></td>
						<th valign="center" height="20px" style="text-align: right;"><strong>التاريخ</strong></th>
					</tr>
					<tr>
						<th valign="center" height="20px" style="text-align: left;"><strong>Name</strong></th>
						<td valign="center" height="20px" style="text-align: left;"><strong><?php echo $name; ?></strong></td>
						<td valign="center" height="20px" style="text-align: right;"><strong><?php echo $name; ?></strong></td>
						<th valign="center" height="20px" style="text-align: right;"><strong>الاسم</strong></th>
					</tr>
					<tr>
						<th valign="center" height="20px" style="text-align: left;"><strong>Nationality</strong></th>
						<td valign="center" height="20px" style="text-align: left;"><strong><?php echo $nationality; ?></strong></td>
						<td valign="center" height="20px" style="text-align: right;"><strong><?php echo $nationality; ?></strong></td>
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
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo $position; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Total Salary</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($ctc != '0.00') ? 'SAR '.$ctc : 'N/P'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Basic Salary</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($basic_pay != '0.00') ? 'SAR '.$basic_pay : 'N/P'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Housing Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($housing_allow != '0.00') ? 'SAR '.$housing_allow : 'Company Provided - Camp'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Transportation Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($add_allow != '0.00') ? 'SAR '.$add_allow : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Food Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($food_allow != '0.00') ? 'SAR '.$food_allow : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Internet Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($mobile_allow != '0.00') ? 'SAR '.$mobile_allow : 'Company Provided'; ?></td>
								</tr>
								<?php if(($position == 'Rider') || ($position == 'Driver') ) { ?>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Bike Allowance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($petrol_allow != '0.00') ? 'SAR '.$petrol_allow : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Bike Maintenance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($petrol_allow != '0.00') ? 'SAR '.$petrol_allow : 'Company Provided'; ?></td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Petrol</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left"><?php echo ($petrol_allow != '0.00') ? 'SAR '.$petrol_allow : 'Company Provided'; ?></td>
								</tr>

								<?php } ?>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Annual Vacation</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left">(30) Calendar days per 2 years</td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Medical Insurance</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left">As per the company policy</td>
								</tr>
								
								<?php if(($position == 'Rider') || ($position == 'Driver') ) { ?>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Contract Period</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left">Two Year</td>
								</tr>
								<tr>
									<td width="44%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:left">Monthly Target</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="border-bottom:1px solid #000;text-align:left">450 Deliveries</td>
								</tr>
								<tr>
									<td width="44%" style="border-right:1px solid #000;text-align:left">Bonus</td>
									<td width="6%" style="border-right:1px solid #000;text-align:center;">:</td>
									<td width="50%" style="text-align:left">SAR 7.00 per Delivery</td>
								</tr>
								<?php } else { ?>
    								<tr>
    									<td width="44%" style="border-right:1px solid #000;text-align:left">Contract Period</td>
    									<td width="6%" style="border-right:1px solid #000;text-align:center;">:</td>
    									<td width="50%" style="text-align:left">Two Year</td>
    								</tr>
								<?php } ?>
							</table>
						</td>
						<td valign="center" colspan="2" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo $position; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">المسمى الوظيفي</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($ctc != '0.00') ? $ctc.' ر.س.' : 'N/P'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الراتب الإجمالي</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($basic_pay != '0.00') ? $basic_pay.' ر.س.' : 'N/P'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الراتب الأساسي</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($housing_allow != '0.00') ? $housing_allow.' ر.س.' : 'قدمت الشركة - كامب'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل سكن</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($add_allow != '0.00') ? $add_allow.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل مواصلات</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($food_allow != '0.00') ? $food_allow.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل الطعام</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($mobile_allow != '0.00') ? $mobile_allow.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل الإنترنت</td>
								</tr>
								
								<?php if(($position == 'Rider') || ($position == 'Driver') ) { ?>

								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($petrol_allow != '0.00') ? $petrol_allow.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بدل الدراجة النارية</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($petrol_allow != '0.00') ? $petrol_allow.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">صيانة الدراجة النارية</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right"><?php echo ($petrol_allow != '0.00') ? $petrol_allow.' ر.س.' : 'قدمت الشركة'; ?></td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">بنزين</td>
								</tr>

								<?php } ?>
								
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right">(30) يوماً خلال سنتان</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الإجازة السنوية</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right">على حسب نظام وسياسة الشركة </td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">التأمين الصحي</td>
								</tr>
								<?php if(($position == 'Rider') || ($position == 'Driver') ) { ?>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right">سنتان</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">مدة العقد</td>
								</tr>
								<tr>
									<td width="50%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:right">450 التسليم</td>
									<td width="6%" style="border-bottom:1px solid #000;border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="border-bottom:1px solid #000;text-align:right">الهدف الشهري</td>
								</tr>
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right">7.00 ر.س. لكل توصيل</td>
									<td width="6%" style="border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="text-align:right">علاوة</td>
								</tr>
								<?php } else { ?>
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right">سنتان</td>
									<td width="6%" style="border-right:1px solid #000;text-align:center;">:</td>
									<td width="44%" style="text-align:right">مدة العقد</td>
								</tr>
								<?php } ?>
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
								<li>That all information provided to the company including education and work experience is true & accurate.</li>
							</ul>
						</td>
						<td valign="center" colspan="2" height="30px" style="text-align: right;">
							إبرام عقد التوظيف مع الشركة.
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
									<td width="70%" style="text-align:left"><?php echo $name; ?></td>
								</tr>
							</table>
						</td>
						<td width="28%" valign="bottom" colspan="2" height="20px" style="text-align: center;"></td>
						<td width="36%" valign="bottom" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="3" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $name; ?></td>
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
									<td width="40%" style="border-right:1px solid #000;"><?php echo date('d M, Y', strtotime($joining_date)); ?></td>
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
