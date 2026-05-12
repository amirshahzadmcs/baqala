<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - SIM Card Handover Form</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	</style>
</head>
<body>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
		<tr>
			<td valign="top" style="width:38%;text-align: left;font-size: 18px;line-height:15px;">
				<strong>SIM CARD HANDOVER FORM</strong><br><strong>نموذج تسليم شريحة هاتف</strong>
			</td>
			<td valign="center" style="width:62%;">
				<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;font-size: 11px;">
					<tr>
						<td style="border-bottom:1px solid #ddd;"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center"></td>
		</tr>
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;text-transform: uppercase;"><strong>EMPLOYEE NO & NAME / رقم الموظف واسم الموظف :</strong> <?= ($sim_detail->emp_no !== '') ? $sim_detail->emp_no : 'NA';?> - <?= $sim_detail->emp_full_name;?></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;width:20%;">DL No. / رقم رخصة القيادة <br><strong><?= (trim($sim_detail->driving_license_number)) ? trim($sim_detail->driving_license_number) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:26%;">Designation / المسمى الوظيفي <br><strong><?= (trim($sim_detail->designation_name)) ? trim($sim_detail->designation_name) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:22%;">Department / القسم <br><strong><?= (trim($sim_detail->department_name)) ? trim($sim_detail->department_name) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;width:32%;">Aggregator Name & ID No. / اسم المجمع ورقم الهوية <br><strong><?= (trim($sim_detail->aggregator_name)) ? trim($sim_detail->aggregator_name) .' - '. trim($sim_detail->aggregator_id_number) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="3" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>SIM CARD HANDOVER DETAILS / تفاصيل تسليم شريحة الاتصال </strong></td>
		</tr>
		<tr style="background-color:#f2f2f2;">
			<td style="border-bottom:1px solid #ddd;width:33%;text-align: center;">Mobile No. / رقم الجوال</td>
			<td style="border-bottom:1px solid #ddd;width:34%;text-align: center;">Sim Card No / رقم شريحة الاتصال</td>
			<td style="border-bottom:1px solid #ddd;width:33%;text-align: center;">Sim Network / شبكة الاتصال</td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:33%;text-align: center;"><strong><?= ($sim_detail->mobile !== '') ? $sim_detail->mobile : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #000;border-right:1px solid #ddd;width:34%;text-align: center;"><strong><?= ($sim_detail->sim_no !== '') ? $sim_detail->sim_no : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #000;width:33%;text-align: center;"><strong><?= (trim($sim_detail->network_name) !== '') ? trim($sim_detail->network_name) : 'NA';?></strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;text-align:center;">
		<tr style="background-color:#f2f2f2;">
			<td style="border-bottom:1px solid #ddd;">Plan / الخطة</td>
			<td style="border-bottom:1px solid #ddd;">Service Type / نوع الخدمة</td>
			<td style="border-bottom:1px solid #ddd;">Payment Type /<br> نوع السداد</td>
			<td style="border-bottom:1px solid #ddd;">Purpose of Handover /<br> الغرض من التسليم</td>
			<td style="border-bottom:1px solid #ddd;">Internet Data /<br> بيانات الإنترنت</td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><strong><?= (trim($sim_detail->plan_name) !== '') ? trim($sim_detail->plan_name) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><strong><?= (trim($sim_detail->sim_type) !== '') ? trim(ucfirst($sim_detail->sim_type)) : 'NA';?></strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><strong>Online</strong></td>
			<td style="border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><strong>Work</strong></td>
			<td style="border-bottom:1px solid #ddd;"><strong>..................</strong></td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="6" style="width: 100%;font-size: 10px;border:1px solid #bbb;">
		<tr>
			<td colspan="2" valign="center" style="text-align: center;border-bottom:1px solid #bbb;"><strong>ACKNOWLEDGMENT OF RECEIPT / إقرار الاستلام </strong></td>
		</tr>
		<tr>
			<td style="text-align: justify;border-right:1px solid #bbb;">
				<p>&#183; I have received the Mobile Sim Card as per the information stated in this form above. for the use of delivery application on the field and will return it after completion of the job/ upon instruction of the Company. </p>
				<p>&#183; I take the responsibility of the proper use of the allotted Internet Data and Calling Minutes. </p>
				<p>&#183; Any Extra cost other than allotted plan; I authorized the Company to deduct it from my salary without any question asked.</p>
			</td>
			<td>
				<p style="text-align: right;"> لقد استلمت شريحة الهاتف المحمول حسب المعلومات المذكورة في هذا النموذج أعلاه، وذلك لغرض استخدام تطبيق التوصيل في الميدان وسيتم إعادتها8 بعد الانتهاء من المهمة/ بناء على تعليمات الشركة.</p>
				<p style="text-align: right;"> أتحمل مسؤولية الاستخدام السليم لبيانات الإنترنت ودقائق الاتصال المخصصة.</p>
				<p style="text-align: right;"> في حالة وجود أي تكلفة إضافية غير الخطة المخصصة فإنني أفوض الشركة بخصمها من راتبي دون طرح أي أسئلة.</p>
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br>----------------------------------------<br>Receiving Date / تاريخ الاستلام <br></td>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Employee Signature / توقيع الموظف</td>
			<td><br><br><br><br>Thumb Impression / بصمة الإبهام </td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="10" style="width: 100%;font-size: 10px;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #000;"><strong>SIM CARD RETURNING DETAILS / تفاصيل إعادة شريحة الاتصال </strong></td>
		</tr>
		<tr style="background-color:#f2f2f2;">
			<td style="width:25%;border-bottom:1px solid #bbb;text-align:center;">Handover Date / تاريخ التسليم </td>
			<td style="width:25%;border-bottom:1px solid #bbb;text-align:center;">Handover Reason / سبب التسليم </td>
			<td style="width:25%;border-bottom:1px solid #bbb;text-align:center;">Handover To / تسليم إلى </td>
			<td style="width:25%;border-bottom:1px solid #bbb;text-align:center;">Balance Data / بيانات الرصيد </td>
		</tr>
		<tr>
			<td style="width:25%;border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br>-----------------------------------------</td>
			<td style="width:25%;border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br>-----------------------------------------</td>
			<td style="width:25%;border-bottom:1px solid #bbb;border-right:1px solid #bbb;text-align:center;"><br><br>-----------------------------------------</td>
			<td style="width:25%;border-bottom:1px solid #bbb;text-align:center;"><br><br>-----------------------------------------</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Employee Signature / توقيع الموظف</td>
			<td style="border-right:1px solid #bbb;"><br><br><br><br>Thumb Impression / بصمة الإبهام </td>
			<td><br><br><br><br>SIM Receiver's Signature / توقيع مستلم الشريحة</td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;border:1px solid #bbb;text-align:center;">
		<tr>
			<td colspan="4" valign="center" style="text-align: left;border-bottom:1px solid #bbb;font-size:10px;"><strong>APPROVED BY / تمت الموافقة من قبل </strong></td>
		</tr>
		<tr>
			<td style="width:16%;text-align:center;"><br><br><br>------------------------------<br>TL Signature <br> توقيع قائد الفريق </td>
			<td style="width:16.6%;text-align:center;"><br><br><br>------------------------------<br>Supervisor Signature <br> توقيع المشرف </td>
			<td style="width:18%;text-align:center;"><br><br><br>------------------------------<br>Operation Head Signature <br> توقيع رئيس العمليات </td>
			<td style="width:16.6%;text-align:center;"><br><br><br>------------------------------<br>HR Signature <br> توقيع قسم الموارد البشرية </td>
			<td style="width:16.6%;text-align:center;"><br><br><br>------------------------------<br>COO Signature <br> توقيع المدير التنفيذي للعمليات </td>
			<td style="width:16%;text-align:center;"><br><br><br>------------------------------<br>CEO Signature <br> توقيع الرئيس التنفيذي </td>
		</tr>
	</table>
</body>

</html>
