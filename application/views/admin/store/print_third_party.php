<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Baqala Station - Franchisee Store Agreement</title>
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
						<td valign="top" height="20px" style="text-align: center;text-decoration:underline;">
							<strong>Subscription Contract</strong>
							<!-- <div style="vertical-align: bottom;border-top:1px solid #000000;">
								<br><span style="vertical-align: middle;"></span>
							</div> -->
						</td>
						<td valign="top" height="20px" style="text-align: center;text-decoration:underline;">
							<strong>عقد اشتراك</strong>
							<!-- <div style="vertical-align: bottom;border-top:1px solid #000000;">
								<br><span style="vertical-align: middle;">CC: SUPPLIER , LOGISTIC, ACCOUNT DEPT,<br>WAREHOUSE, SITE FILE</span>
							</div> -->
						</td>
					</tr>
					<tr>
					<?php
						$year = date("Y");
						$OldDate = $created_at;
						$oldDateUnix = strtotime($OldDate);
						if (date("Y", $oldDateUnix) < $year) {
							$year = date("Y", $oldDateUnix);
						} else {
							$year = $year;
						}
						if (($agrement_num > 0) && ($agrement_num <= 9)) {
							$final_num = 'FSA' . $year . '-00' . $agrement_num;
						} else if (($agrement_num > 9) && ($agrement_num <= 99)) {
							$final_num = 'FSA' . $year . '-0' . $agrement_num;
						} else {
							$final_num = 'FSA' . $year . '-' . $agrement_num;
						}
						;
						?>
						<td valign="top" height="40px" style="text-align: left;">
							This Contract has been made and entered into in Riyadh City, Kingdom of Saudi Arabia on <?php echo date('d/m/Y', strtotime($agrement_start)); ?>, under No. <?php echo $final_num; ?> BY AND BETWEEN:
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							تم إبرام هذا العقد بمدينة الرياض بالمملكة العربية السعودية بتاريخ <?php echo date('Y/m/d', strtotime($agrement_start)); ?> وبرقم <?php echo $final_num; ?> بين كلٍ من:
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							First: Maha Al Fala Trading Establishment, CR No. 1010758117, with head office located in 2571 Prince sultan Bin Abdulaziz Street, North Al Mather District, King Abdulaziz Road, Sultan Business Center, Riyadh, KSA, herein represented by Mr. Mohammed Aldhoheyan Saudi National, ID No. 1004605224, Director, and hereinafter referred to as the "First Party".
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							أولا- شركة: مؤسسة مها الفلا للتجارة تجاري رقم1010758117، مكتب مسجل في حي الياسمين - طريق الملك عبد العزيز - مجمع باك يارد. الرياض، المملكة العربية السعودية، ويمثلها في هذا العقد السيد/ محمد ضحيان عبد العزيز الضحيان، سعودي الجنسية، بهوية رقم 1004605224 بصفته الرئيس التنفيذي، والمُشار إليه فيما بعد بـ "الطرف الأول".
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							Second: <?php echo $store_name; ?>, whose details are shown as follows:
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							ثانياً <?php echo $store_name_arabic; ?> والمبينة معلوماتها أدناه:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Store Contact Details
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							تفاصيل جهة اتصال المطعم/المتجر
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Store Name</td>
									<td width="70%"><?php echo $store_name; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $store_name_arabic; ?></td>
									<td width="30%">المتجر /المطعم أس</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Trademark</td>
									<td width="70%"><?php echo $brand_name; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $brand_name; ?></td>
									<td width="30%">السم التجاري</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">CR Number</td>
									<td width="70%"><?php echo $cr_no; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $cr_no; ?></td>
									<td width="30%">التجاري السجل رق</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Address</td>
									<td width="70%"><?php echo $store_location; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $store_location; ?></td>
									<td width="30%">العنوان</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Name of the Owner</td>
									<td width="70%"><?php echo $other_name; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $other_name; ?></td>
									<td width="30%">أسم المالك/المدير</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Position</td>
									<td width="70%"><?php echo $other_position; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $other_position; ?></td>
									<td width="30%">المنصب</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">ID Number</td>
									<td width="70%"><?php echo $other_id; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $other_id; ?></td>
									<td width="30%">رقم الهوية</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">E-mail</td>
									<td width="70%"><?php echo $other_email; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $other_email; ?></td>
									<td width="30%">اللكتروني البريد</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Contact No</td>
									<td width="70%"><?php echo $other_mobile; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $other_mobile; ?></td>
									<td width="30%">التلفون</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Store Bill Details
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							تفاصيل فاتورة المطعم /المتجر
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Bank Account Name</td>
									<td width="70%"><?php echo $account_holder_name; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $account_holder_name; ?></td>
									<td width="30%">المصرفي الحساب مالك</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">IBAN NO</td>
									<td width="70%"><?php echo $iban_number; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $iban_number; ?></td>
									<td width="30%">رقم اليبان</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Bank Name</td>
									<td width="70%"><?php echo $bank_name; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $bank_name; ?></td>
									<td width="30%">البنك اس</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Email for Invoicing</td>
									<td width="70%"><?php echo $email_invoice; ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;">
								<tr>
									<td width="70%" style="border-right:1px solid #000;"><?php echo $email_invoice; ?></td>
									<td width="30%">البريد اإللكتروني للفاتورة</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							Hereinafter referred to as the <b>"Second Party/Subscriber"</b>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							والمشار إليه لاحقاً "بالطرف الثاني أو المشترك"
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							<strong>Introduction:</strong><br>
							Whereas the first party is a leading company in the field of online order delivery and owns the "Baqala Station" platform, and whereas the second party is an institution bearing the brand name <?php echo $brand_name; ?> and wishes to subscribe to the first party's platform and benefit from its services.
							<br><br>
							NOW THEREFORE, it has been agreed between the two parties, who are of full and legal capacity, to the following terms and conditions:
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							التمهيد:<br>
							حيث أن الطرف الأول هو شركة رائدة في مجال توصيل الطلبات عبر الإنترنت وتملك منصة "بقالة ستيشن" وحيث أن الطرف   الثاني مؤسسة تحمل أسم العلامة التجارية <?php echo $brand_name; ?> وترغب في الاشتراك بمنصة <br> الطرف الأول والاستفادة من خدماته. عليه فقد تم الاتفاق بين
							<br><br>
							الطرفين وهما بكامل أهليتهما المعتبرة شرعاً ونظاماً على البنود التالية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							First - Enforceability of the Introduction:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							اولاً - صفة التمهيد:
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							The above preamble is an integral part hereof, complementing and interpreting hereto.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							يعتبر التمهيد أعلاه جزءاً لا يتجزأ من هذا العقد مكملاً ومفسراً له.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Second - Definitions:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							ثانياً- التعاريف:
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							"Platform" means the website and application of the first party that bears the "Baqala Station" brand name.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							"المنصة" الموقع والتطبيق الإلكتروني للطرف الأول الذين يحملون اسم العلامة التجارية "بقالة ستيشن"
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							"User or Customer" Individuals who use the Platform to make orders and purchases from Stores.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							"المستخدم أو العميل" الأفراد الذين يقومون باستخدام المنصة لإجراء عمليات الطلب والشراء من المتاجر.
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							"Confidential Information" Confidential information constitutes all information received by the Second Party from the First Party or as a cause of it in any way whether oral or written, including, but not limited to, contracts, agreements, discussions and negotiations with him or with other parties, strategies, methodologies, processes, data, research, reports, development plans, business, finance, patents, trade secrets, information, financial, technical, technical and information data The personal information of the employees of the first party and the information of its customers, partners and suppliers.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							"المعلومات السرية" تشكل المعلومات السرية جميع المعلومات التي يتلقاها الطرف الثاني من الطرف الأول أو سبباً منه بأي وسيلة كانت، شفهية أو كتابية، والتي تشمل على سبيل المثال لا الحصر، العقود والاتفاقيات والمناقشات والمفاوضات التي تجره معه أو مع أطراف أخرى أو الإستراتيجيات والمنهجيات والعمليات والبيانات والأبحاث والتقارير وخطط التطوير و الأعمال التجارية والشؤون المالية وبراءات الاختراع والأسرار التجارية <br> والمعلومات والبيانات المالية والفنية والتقنية والمعلومات الشخصية لموظفي الطرف الأول ومعلومات عملاءه أو شركاه ومورديه.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Third - Obligations and Rights of the First Party
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							ثالثاً - التزامات وحقوق الطرف الأول:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The First Party shall:
						</td>
						<td valign="top" height="20px" style="text-align: right;">

						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							<ol>
								<li>Activate a "portal" web page for the second party and explain the mechanism of its use to enable it to receive and track requests.</li>
							</ol>
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							1.يلتزم بتفعيل صفحة إلكترونية “بورتال" للطرف الثاني وشرح ألية استخدامها لتمكينه من استقبال وتتبع الطلبات.
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							<ol start="2">
								<li>Provide the services of receiving, delivering, and handing over the orders of the customers of the second party to the users</li>
							</ol>
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							2.يلتزم الطرف الأول بتقديم خدمات استلام وتسليم وتوصيل الطلبات الخاصة بعملاء الطرف الثاني إلى المستخدمين.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol start="3">
								<li>Be responsible for the collection of money from the customers.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							3.يتحمل الطرف الأول مسئولية التحصيل من العملاء المستخدمين.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							<ol start="4">
								<li>Have the right to determine or change the delivery amount at any time and to offer discounts to its customers, without referring to the second party.</li>
							</ol>
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							4.يكون للطرف الأول الحق في تحديد أو تغيير مبلغ التوصيل في أي وقت وتقديم الخصومات لعملائه وذلك <br> دون رجوعه للطرف الثاني.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							<ol start="5">
								<li>Have the right to stop the service for the second party in the event of non-payment or delay in payment for a period of 14 days "Fourteen Days" from the date of receipt of the invoice, and it has the right to stop it when needed in cases of system update or technical and operational malfunctions.</li>
							</ol>
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							5.يكون للطرف الأول الحق في إيقاف الخدمة عن الطرف الثاني في حالة عدم سداده أو تأخره عن السداد لمدة 14 يوما "أربعة عشر يوماً" من تاريخ استلام الفاتورة، كما ويحق له إيقافها عند الحاجة في حالات تحديث النظام أو الأعطال الفنية.
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							<ol start="6">
								<li>Compensate the second party, up to a maximum of 150 riyals, for the value of order that is prepared without the driver arriving to receive it.</li>
							</ol>
						</td>
						<td valign="top" height="30px" style="text-align: right;word-wrap: break-word !important;">
							6.والتشغيلية.يقوم الطرف الأول بتعويض الطرف الثاني وبحد اقصى 150 ريال وذلك عن قيمة تكلفة الطلب الذي يتم تحضيره دون وصول السائق لاستلامه.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Fourth: Obligations of the Second Party:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							رابعاً- التزامات الطرف الثاني:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The Second Party shall:
						</td>
						<td valign="top" height="20px" style="text-align: right;">

						</td>
					</tr>
					<tr>
						<td valign="top" height="80px" style="text-align: left;">
							<ol>
								<li>Provide the first party with the details of the branches, their locations, and a list of its products with their prices for display on the platform. It also shall ensure that all its data is true and correct and updates it immediately to match what is available and approved by the branch and is committed to informing the first party of any change or modification to it at least two working days in advance.</li>
							</ol>
						</td>
						<td valign="top" height="80px" style="text-align: right;">
							1.يلتزم الطرف الثاني بتزويد الطرف الأول ببيانات الفروع ومواقعها وقائمة منتجاته بأسعارها لعرضها في <br> المنصة. كما ويقوم بالتأكد من أن كافة البيانات الخاصة به مطابقة لواقعها وصحيحة ويقوم بتحديثها بشكل فوري لتطابق ما هو متوفر ومعتمد بالفرع، ويلتزم بإبلاغ الطرف الأول عن أي تغيير أو تعديل عليها قبل يومين <br> عمل على الأقل.
						</td>
					</tr>
					<tr>
						<td valign="top" height="60px" style="text-align: left;">
							<ol start="2">
								<li>Pay the value of the printers for receiving applications for each of its branches to the first party and to provide the necessary internet to receive requests and to secure sufficient resources to ensure that they are met and delivered to the representative of the first party on time.</li>
							</ol>
						</td>
						<td valign="top" height="60px" style="text-align: right;">
							2.يلتزم الطرف الثاني بدفع قيمة طابعات استقبال الطلبات عن كل فرع من فروعه للطرف الأول وتوفير شبكة الإنترنت اللازمة لتلقي الطلبات وتأمين الموارد الكافية لضمان تلبيتها وتسليمها الى مندوب الطرف الأول في الوقت المحدد.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							<ol start="3">
								<li>Match the invoice, within seven days from the date of receiving it, and verify its validity and pay its value, and may not object to its validity after this period.</li>
							</ol>
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							3.يلتزم الطرف الثاني خلال سبعة أيام من تاريخ استلام الفاتورة بمطابقتها والتأكد من صحتها ودفع قيمتها ولا يجوز له الاعتراض على صحتها بعد هذه المدة.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol start="4">
								<li>Be fully responsible for the orders in the following cases:</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							4.يتحمل الطرف الثاني كامل المسؤولية عن الطلبات في الحالات الآتية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">

						</td>
						<td valign="top" height="20px" style="text-align: right;">
							يتحمل الطرف الثاني مسؤولية تعويض
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							The second party shall compensate the customer and hold it harmless against the delivery value in case the second party delays delivering the order to the driver for more than 15 minutes, as it is deducted from the monthly dues of the second party.
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							العميل عن قيمة التوصيل وذلك في حالة تأخر الطرف الثاني تسليم الطلب للسائق لأكثر من 15 دقيقة، حيث يتم خصمُها من المستحقات الشهرية الخاصة بالطرف الثاني.
						</td>
					</tr>
					<tr>
						<td valign="top" height="60px" style="text-align: left;">
							The second party shall compensate the customer for the value of the orders that are rejected, or a complaint is filed against them by the customer due to the non-conformity of the order, its completeness, its cleanliness, or the customer's dissatisfaction with it, as it is deducted from the monthly dues of the second party.
						</td>
						<td valign="top" height="60px" style="text-align: right;">
							يقوم الطرف الثاني بتعويض العميل عن قيمة الطلبات التي يتم رفضها أو رفع شكوى عليها من قبل العميل بسبب عدم مطابقة الطلب أو اكتماله أو نظافته أو عدم رضى العميل عنه حيث يتم خصمُها من المستحقات الشهرية الخاصة بالطرف الثاني.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The second party shall bear the monthly percentage prescribed in cases of requests that it refuses to receive or is unable to implement due to its failure to stop the printer receiving device while it is closing the branch for any reason whatsoever.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							يتحمل الطرف الثاني النسبة الشهرية المقررة في حالات الطلبات التي يقوم برفض استقبالها أو لا يتمكن من تنفيذها بسبب عدم إيقافه لجهاز استقبال الطلبات الطابعة أثناء إقفاله للفرع لأي سبب كان.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The Second Party undertakes to abide by all the rules and regulations applicable in the Kingdom of Saudi Arabia, with all terms and conditions related to the quality and safety of foods and products provided by him and acknowledge his full responsibility for them.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							ويتعهد بالتزامه بكافة اللوائح والأنظمة المتبعة بالمملكة العربية السعودية بكافة الشروط والاحكام المتعلقة بجودة وسلامة الأطعمة والمنتجات المقدمة من قبله ويقر بمسؤوليته الكاملة عنها.
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							The second party undertakes that the prices it provides on the platform of the first party are the approved and announced prices for all its customers and acknowledges its responsibility to match the prices mentioned in the platform and inform the first party of any differences that it responds to immediately and bears the amounts of those differences until the amendment thereto.
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							يتعهد الطرف الثاني بأن الأسعار التي يُقدمها في منصة الطرف الأول هي الأسعار المعتمدة والمُعلنة لكافة عملائه، ويقر بمسؤوليته عن مطابقة الأسعار الواردة في المنصة وإبلاغ الطرف الأول عن أي فروقات ترد عليها فوراً ويتحمل مبالغ تلك الفروقات الى حين التعديل عليها.
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							The second party undertakes to disclose all the discounts and promotions that he wishes to establish and to provide the first party with a clear explanation of them at least two working days in advance. to be included in the platform.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							يتعهد الطرف الثاني بالإفصاح عن جميع الخصومات والعروض الترويجية التي يرغب في إقامتها وتزويد الطرف <br> الأول بشرح واضح لها قبل يومين عمل على الاقل. ليتم إدراجها في المنصة.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Fifth: Fees, Payment, Invoices, Commission and Additional Services:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							خامساً: الرسوم والسداد والفواتير والعمولة والخدمات الإضافية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							The Second Party shall pay the first party the following fees:
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							يلتزم الطرف الثاني بالدفع للطرف الأول الرسوم التالية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol>
								<li>Monthly Service Fees:</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							1.رسوم الخدمة الشهرية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="50%" colspan="2" style="border-right:1px solid #000;text-decoration:underline;">Type of Fees</td>
									<td width="20%" style="border-right:1px solid #000;text-decoration:underline;">Value</td>
									<td width="30%" style="text-decoration:underline;">Start Date</td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;text-decoration:underline;">تاريخ البدء</td>
									<td width="20%" style="border-right:1px solid #000;text-decoration:underline;">قيمة الرسوم</td>
									<td width="50%" colspan="2" style="text-decoration:underline;">نوع الرسوم</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="15%" style="border-right:1px solid #000;"><?php echo $cat_name_1; ?></td>
									<td width="35%" style="border-right:1px solid #000;">Monthly Subscription</td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_1 ?>%</td>
									<td width="30%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;"></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_1 ?>%</td>
									<td width="35%">رسوم الخدمة الشهرية - توصيل</td>
									<td width="15%" style="border-left:1px solid #000;"><?php echo $cat_name_1; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="15%" style="border-right:1px solid #000;"><?php echo $cat_name_2; ?></td>
									<td width="35%" style="border-right:1px solid #000;">Monthly Subscription</td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_2 ?>%</td>
									<td width="30%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;"></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_2 ?>%</td>
									<td width="35%">رسوم الخدمة الشهرية - توصيل</td>
									<td width="15%" style="border-left:1px solid #000;"><?php echo $cat_name_2; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="15%" style="border-right:1px solid #000;"><?php echo $cat_name_3; ?></td>
									<td width="35%" style="border-right:1px solid #000;">Monthly Subscription</td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_3 ?>%</td>
									<td width="30%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;"></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_3 ?>%</td>
									<td width="35%">رسوم الخدمة الشهرية - توصيل</td>
									<td width="15%" style="border-left:1px solid #000;"><?php echo $cat_name_3; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="15%" style="border-right:1px solid #000;"><?php echo $cat_name_4; ?></td>
									<td width="35%" style="border-right:1px solid #000;">Monthly Subscription</td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_4 ?>%</td>
									<td width="30%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;"></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $monthly_sub_4 ?>%</td>
									<td width="35%">رسوم الخدمة الشهرية - توصيل</td>
									<td width="15%" style="border-left:1px solid #000;"><?php echo $cat_name_4; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;">Online Payment Fees</td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $online_payment_fee_1 ?>%</td>
									<td width="30%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;"></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo $online_payment_fee_1 ?>%</td>
									<td width="50%">عمولة الدفع الإلكتروني</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol start="2">
								<li>The percentage is calculated from the total value of orders.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							2.يتم احتساب النسبة من إجمالي قيمة الطلبات.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol start="3">
								<li>The fees continue for the duration of the contract.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							3.تستمر الرسوم باستمرار مدة العقد.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol start="4">
								<li>Registration Printers and Copy Services Fees:</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							4.رسوم التسجيل والطابعات وخدمات التصوير:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="30%" style="border-right:1px solid #000;text-decoration:underline;">Product name</td>
									<td width="25%" style="border-right:1px solid #000;text-decoration:underline;">Price</td>
									<td width="20%" style="border-right:1px solid #000;text-decoration:underline;">Discount</td>
									<td width="25%" style="text-decoration:underline;">Total</td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="25%" style="border-right:1px solid #000;text-decoration:underline;">المجموع</td>
									<td width="20%" style="border-right:1px solid #000;text-decoration:underline;">الخصم</td>
									<td width="25%" style="border-right:1px solid #000;text-decoration:underline;">السعر</td>
									<td width="30%" style="text-decoration:underline;">اسم المنتج</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<?php $total = $price - $discount; ?>
								<tr>
									<td width="30%" style="border-right:1px solid #000;">Printer</td>
									<td width="25%" style="border-right:1px solid #000;"><?php echo number_format((float)$price, 2, '.', ''); ?></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo number_format((float)$discount, 2, '.', ''); ?></td>
									<td width="25%"><?php echo number_format((float)$total, 2, '.', '') ?></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="25%" style="border-right:1px solid #000;"><?php echo number_format((float)$total, 2, '.', '') ?></td>
									<td width="20%" style="border-right:1px solid #000;"><?php echo number_format((float)$discount, 2, '.', ''); ?></td>
									<td width="25%" style="border-right:1px solid #000;"><?php echo number_format((float)$price, 2, '.', ''); ?></td>
									<td width="30%">رسوم الطابعة</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;"></td>
						<td valign="top" height="20px" style="text-align: right;"></td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol>
								<li>The first party sends the invoices due from the second party within three working days from the end of each month through e-mail or any of the means specified by the first party. These invoices include all stores and branches registered under the second party's commercial registry with the ability to review requests through the system.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							1.يقوم الطرف الأول بإرسال الفواتير المستحقة على الطرف الثاني خلال ثلاث أيام عمل من نهاية كل شهر من خلال البريد الإلكتروني أو أي من الوسائل التي يحددها الطرف الأول وتشمل تلك الفواتير جميع المتاجر والفروع المُسجلة تحت سجل الطرف الثاني التجاري مع إتاحة إمكانية مراجعة الطلبات عبر النظام.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol start="2">
								<li>Cases of payment of the order value by the customer:</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							2.حالات دفع قيمة الطلب من قبل العميل:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol type="A">
								<li>If the customer pays in cash, the representative of the first party pays the value of the order upon receiving it from the branch</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							1.إذا تم الدفع نقداً من قبل العميل فيقوم مندوب الطرف الأول بدفع قيمة الطلب عند استلامه من الفرع
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol type="A" start="2">
								<li>If the customer pays electronically, a monthly matching and authentication is done, and the value of the electronically paid requests is deducted from the invoice due on the second party. Due to the second party, the first party will transfer it after matching with the second party within two weeks from the end of the month subject of the settlement.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							2.إذا تم الدفع إلكترونياً من قبل العميل فيتم عمل مُطابقة ومصادقة شهرية وخصم قيمة الطلبات المدفوعة إلكترونياً من الفاتورة المُستحقة على الطرف الثاني ويتحمل الطرف الثاني مسؤولية سداد قيم الرسوم البنكية المقدرة بنسبة (2.5%) من قيمة كل عملية دفع الكترونية وفي حالة وجود رصيد دائن مُستحق للطرف الثاني يقوم الطرف الأول بتحويله بعد المطابقة مع الطرف الثاني في خلال أسبوعين من نهاية الشهر موضوع <br> التسوية.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol type="A" start="3">
								<li>If the payment is made using the “wallet” balance: the first party deducts the values of those requests from the total balance due on the second party after the arithmetic and matching settlement within two weeks from the settlement date.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							3.إذا تم الدفع باستخدام الرصيد "المحفظة": فيقوم الطرف الأول بخصم قيم تلك الطلبات من مجموع الرصيد المُستحق على الطرف الثاني بعد التسوية الحسابية والمطابقة خلال أسبوعين من تاريخ التسوية.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;text-decoration:underline;">
							4. Government Taxes:
						</td>
						<td valign="top" height="20px" style="text-align: right;text-decoration:underline;">
							4.الضرائب الحكومية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol type="A">
								<li>The provisions of value added tax shall be applied in accordance with the rules and regulations in force in the Kingdom of Saudi Arabia.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							1.تطبق أحكام ضريبة القيمة المضافة وفقاً للوائح والأنظمة المتبعة بالمملكة العربية السعودية.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<ol type="A" start="2">
								<li>The second party is obligated to submit the tax number registered to him to the first party immediately upon contracting and bear the consequences of not submitting it.</li>
							</ol>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							2.يلتزم الطرف الثاني بتقديم الرقم الضريبي المسجل له للطرف الأول فور التعاقد ويتحمل تبعات عدم تقديمها.
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							<ol type="A" start="3">
								<li>The second party undertakes, if it is not required to be "exempt", to issue a tax number in accordance with the rules and regulations applicable in the Kingdom of Saudi Arabia, with its full responsibility to inform the first party as soon as this changes; He bears all the consequences of not submitting the tax number immediately after the date of its issuance.</li>
							</ol>
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							3.يتعهد الطرف الثاني في حال كان غير مطالب "معفياً" بإصدار رقم ضريبي وفقاً للوائح والأنظمة المطبقة بالمملكة العربية السعودية بمسؤوليته التامة عن إبلاغ الطرف الأول فور تغير ذلك؛ ويتحمل كافة تبعات عدم تقديمه الرقم الضريبي فور تاريخ إصداره.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;text-decoration:underline;">
							5. Other Services:
						</td>
						<td valign="top" height="20px" style="text-align: right;text-decoration:underline;">
							5. الخدمات الأخرى:
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The first party provides its subscribers with additional services such as marketing, advertising, and photographing services for the products displayed on the platform; This is in return for additional prices and fees to be agreed upon between the two parties, which are determined according to the service.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							يقدم الطرف الأول لمشتركيه خدمات إضافية كالتسويق والدعاية وخدمات التصوير للمنتجات المعروضة على المنصة؛ وذلك مُقابل أسعار ورسوم إضافية يتم الاتفاق عليها بين الطرفين تُحدد حسب الخدمة.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Sixth: Duration and Termination:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							سادساً: المدة والإنهاء:
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The term of this contract is a one Gregorian year starting from the date of its signing and renewed for a similar period(s) unless one of the parties notifies the other of its unwillingness to renew a month prior to the date of termination. Not less than 30 days from the date of termination.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							مدة هذا العقد هي سنة ميلادية تبدأ من تاريخ توقيعه وتتجدد لمدة أو مدد مماثلة ما لم يخطر أحد الطرفين <br> الأخر بعدم رغبته في التجديد قبل شهر من تاريخ الإنهاء» كما ويحق لأي من الطرفين إنهاء العقد قبل انتهاء مدته بموجب إشعار كتابي يُرسل بالبريد المسجل للطرف الآخر بمدة لا تقل عن 30 يومأ من تاريخ الإنهاء.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Seventh - General Provisions:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							سابعاً - الأحكام العامة:
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The two parties acknowledge that this contract is the only contract signed between them and replaces all previous agreements and correspondence, whether written or oral, if any.” In the event of any amendment or addition of any clause, that amendment must be in writing and with the consent of both parties.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							يقر الطرفين بأن هذا العقد هو العقد الوحيد الموقع بينهما ويحل محل كافة الاتفاقيات والمراسلات السابقة سواء الكتابية منها أو الشفهية إن وجدت» وفي حالة تعديل أو إضافة أي بند فيلزم أن يكون ذلك التعديل خطياً وبموافقة من الطرفين.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							This contract may not be assigned or transferred to a third party without the prior written consent of the other party.
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							لا يجوز التنازل عن هذا العقد أو نقله لطرف ثالث دون الموافقة الخطية المسبقة من الطرف الآخر.
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							All official notifications and correspondences between the two parties shall be made through the data and addresses stated in the commercial registers of the two parties and the addresses set in the introduction above and shall be delivered by hand” or by mail, e-mail, and if either party changes its address, it shall immediately notify the other party in writing.
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							تتم جميع الإشعارات والمخاطبات الرسمية بين الطرفين من خلال البيانات والعناوين المسجلة بالسجلات التجارية الخاصة بالطرفين و العناوين المسجلة في مقدمة هذا العقد عبر التسليم باليد» أو عن طريق البريد. أو عن طريق البريد الإلكتروني وفي حالة تغيير أي من الطرفين عنوانه يقوم فوراً بإشعار الطرف الآخر خطياً.
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							This contract shall be subject to the applicable laws and regulations in force in the Kingdom of Saudi Arabia. Any dispute arising out of or related to it shall be referred and settled amicably within a period of thirty days. If no amicable settlement is reached, it shall be referred to the competent courts in Riyadh that have the authority to resolve it.
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							يخضع هذا العقد بشكل كامل الى الأنظمة واللوائح المتبعة والمعمول بها في المملكة العربية السعودية. أي <br> نزاع ينشأ عنها أو يتعلق بها تتم إحالته وتسويته وديا خلال مدة ثلاثين يومأ وفي حال تعذر الوصول الى تسوية ودية فإن المحاكم المختصة بمدينة الرياض في المملكة العربية السعودية هي صاحبة الاختصاص بفض النزاع
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							5. Intellectual Property Rights:
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							5. حقوق الملكية الفكرية:
						</td>
					</tr>
					<tr>
						<td valign="top" height="60px" style="text-align: left;">
							The second party agrees under this contract to give the first party the right to use its intellectual property rights such as logos, images, names and trademarks, and undertakes to provide the first party with any documents and take any measures that enable the first party to use it in Baha's marketing and promotional campaigns, and he also pledges that he owns all those intellectual rights and no one can dispute them and guarantees their ownership throughout the term of this contract, and he is responsible for the emergence of any dispute related to them.
						</td>
						<td valign="top" height="60px" style="text-align: right;">
							يوافق الطرف الثاني بموجب هذا العقد على إعطاء الحق الطرف الأول باستخدام حقوق الملكية الفكرية الخاصة به مثل الشعارات والصور والأسماء والعلامات التجارية» ويتعهد بتزويد الطرف الأول بأي مستندات والقيام بأي إجراءات تمكن الطرف الأول من استخدامها في الحملات التسويقية والترويجية التي يقوم بهاء كما يتعهد بأنه يملك كافة تلك الحقوق الفكرية ولا ينازعه أحد فيها ويضمن سريان ملكيتها طوال مدة هذا العقد، ويتحمل مسؤولية نشوء أي نزاع يتعلق بها.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The second party is subject to the instructions and instructions of the first party regarding its use of the logo of the first party or any of its intellectual property rights and must obtain the written consent of the first party before using it, whether in its advertising campaigns or any promotional materials it makes such as posters, publications or what is included in the Websites and social media platforms.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							ب- يخضع الطرف الثاني لإرشادات وتعاليم الطرف الأول فيما يتعلق باستعماله الشعار الخاص بالطرف الأول أو <br> أي من حقوق ملكيته الفكرية وعليه أخذ موافقة الطرف الأول الخطية قبل استعمالها سواءً كان في حملاته الدعائية أو أي مواد دعائية يقوم بها مثل الملصقات أو المنشورات أو ما يتم إدراجه في المواقع الإلكترونية <br> ومواقع التواصل الاجتماعي.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							6. Confidentiality and non-disclosure:
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							6. السرية وعدم الإفشاء:
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							The second party is obligated throughout the validity period of this contract and for a period of ten years from its termination to maintain the confidentiality of all confidential data and information received through or because of the first party, and not to disclose or share it with any other party or parties without obtaining the prior written consent of the first party.
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							يلتزم الطرف الثاني طوال فترة سريان هذا العقد ولمدة عشر سنوات من انتهاؤه بالمحافظة على سرية كافة البيانات والمعلومات السرية التي تلقاها من خلال الطرف الأول أو بسببه» وعدم إفشاؤها أو مشاركتها مع أي <br> طرف أو أطراف أخرى دون الحصول على الموافقة الخطية المسبقة من الطرف الأول.
						</td>
					</tr>
					<tr>
						<td valign="top" height="40px" style="text-align: left;">
							The second party must abide not to disclose any confidential information belonging to the first party or the external parties it deals with, such as customers, suppliers, experts, etc., and not to disclose the details of commercial, technical and financial agreements and contracts.
						</td>
						<td valign="top" height="40px" style="text-align: right;">
							يجب على الطرف الثاني الالتزام بعدم إفشاء أي معلومات سرية تعود للطرف الأول أو الجهات الخارجية التي <br> يتعامل معها كالعملاء والموردين والخبراء وخلافه، وعدم إفشاء تفاصيل الاتفاقيات والعقود التجارية والفنية والمالية.
						</td>
					</tr>
					<tr>
						<td valign="top" height="50px" style="text-align: left;">
							The first party has the right to take all judicial, penal, and preventive measures if the second party breaches the obligation to maintain the confidentiality of the information of the first party. He also has the right to claim compensation for any damage resulting from the second party's non-compliance with the terms of confidentiality and non-disclosure.
						</td>
						<td valign="top" height="50px" style="text-align: right;">
							يحق للطرف الأول اتخاذ كافة الإجراءات القضائية والجزائية والوقائية في حال إخلال الطرف الثاني بالالتزام بالمحافظة على سرية معلومات الطرف الأول. كما له الحق له المطالبة بالتعويض عن أي ضرر ينجم عن عدم <br> التزام الطرف الثاني ببنود السرية وعدم الإفشاء.
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left; background-color:#FFFDD0;text-decoration:underline;">
							Eighth: Counterparts:
						</td>
						<td valign="top" height="20px" style="text-align: right; background-color:#FFFDD0;text-decoration:underline;">
							ثامناً: نسخ العقد:
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							The two parties acknowledge the validity of their signature of the contract, whether that signature was manually or electronically.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							يقر الطرفان بصحة توقيعهما للعقد سواءً كان ذلك التوقيع بشكل يدوي أو إلكتروني.
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							This contract has been drawn up electronically and signed by the legally authorized representatives of each party, each party has received an electronic copy of it to act accordingly.
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							تم تحرير هذا العقد بشكل إلكتروني وتم توقيعه من قبل المفوضين نظاماً عن كل طرف. كما وقام كل طرف <br> من طرفي العقد باستلام نسخة إلكترونية منه للعمل بموجبها.
						</td>
					</tr>
					<tr>
						<td valign="top" height="30px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;"></td>
									<td width="40%" style="border-right:1px solid #000;">Signed on behalf of the First Party</td>
									<td width="40%">Signed on behalf of the Second Party</td>
								</tr>
							</table>
						</td>
						<td valign="top" height="30px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="40%" style="border-right:1px solid #000;">وقع عن الطرف الثاني</td>
									<td width="40%" style="border-right:1px solid #000;">وقع عن الطرف الأول</td>
									<td width="20%"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;">Name</td>
									<td width="40%" style="border-right:1px solid #000;">Mohammed Aldhoheyan</td>
									<td width="40%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="40%" style="border-right:1px solid #000;">محمد الضحيان</td>
									<td width="20%">الاسم</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;">Title</td>
									<td width="40%" style="border-right:1px solid #000;">Director</td>
									<td width="40%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="40%" style="border-right:1px solid #000;">الرئيس التنفيذي</td>
									<td width="20%">المنصب</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;">Signature</td>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="40%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="20%">التوقيع</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="top" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="20%" style="border-right:1px solid #000;">Date</td>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="40%"></td>
								</tr>
							</table>
						</td>
						<td valign="top" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 10px;text-align:center;">
								<tr>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="40%" style="border-right:1px solid #000;"></td>
									<td width="20%">التاريخ</td>
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
