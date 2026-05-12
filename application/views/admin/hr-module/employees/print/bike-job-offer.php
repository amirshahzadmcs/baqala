<?php
$joiningDate = $emp_detail->work_joining_date;

// Set your correct timezone here, for example 'Asia/Riyadh' or 'Asia/Dubai'
$timezone = 'Asia/Riyadh';

$fmt = new IntlDateFormatter(
    'ar_SA', // Arabic locale
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    $timezone,
    IntlDateFormatter::GREGORIAN,
    'dd MMMM yyyy' // Day Month Year
);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Job Offer</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
	<!--
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td colspan="2" valign="center" style="text-align: right;font-size: 24px;line-height:0px;"><img src="<?php echo base_url('admin_assets/images/maha-al-fala.jpg');?>" height="50px"></td>
		</tr>
	</table>
	-->
	<!-- <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center"></td>
		</tr>
	</table> -->

	<table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
		<tr>
			<td align="left" colspan="2">Date: <?= date('F j, Y', strtotime($emp_detail->work_joining_date)); ?></td>
			<td align="right" colspan="2">التاريخ: <?php echo $fmt->format(strtotime($joiningDate));?></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><h2><u>Job Offer</u></h2></td>
			<td align="center" colspan="2"><h2><u>عرض الوظيف</u></h2></td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td align="left">Name</td>
			<td align="left"><?= $emp_detail->full_name;?></td>
			<td align="right"><?= $emp_detail->employee_arabic_name ;?></td>
			<td align="right">الاسم</td>
		</tr>
		<tr>
			<td align="left">ID/Iqama</td>
			<td align="left"><?= $emp_detail->iqama_no;?></td>
			<td align="right"><?= $emp_detail->iqama_no;?></td>
			<td align="right">رقم الهوية / الإقامة </td>
		</tr>
		<tr>
			<td align="left">Nationality</td>
			<td align="left"><?= $emp_detail->nationality_name ;?></td>
			<td align="right"><?= $emp_detail->nationality_name_ar ;?></td>
			<td align="right">الجنسية</td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2" align="left">
				We are pleased to offer you an appointment in our organization as Delivery Associate - Bike, you will be based in our Riyadh office.
			</td>
			<td colspan="2" align="right">
				يسعدنا أن نعرض عليك عرض وظيفة ضمن شركتنا بمسمى "مندوب توصيل - سيارة". وستكون مكان عملك في شركتنا بمدينة الرياض.
			</td>
		</tr>
	</table>

	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr><td></td></tr>
	</table>

	<table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
		<tr style="background-color:#000000;color:#ffffff;">
			<td align="left">Job Title</td>
			<td align="left">Delivery Associate - Bike</td>
			<td align="right">مندوب توصيل - دراجة نارية</td>
			<td align="right">لمسمى الوظيفي</td>
		</tr>
		<tr>
			<td>Basic Salary</td>
			<td>SAR 500.00</td>
			<td align="right">500.00 رس</td>
			<td align="right">الراتب الأساسي</td>
		</tr>
		<tr>
			<td>Housing</td>
			<td>Provided by Company</td>
			<td align="right">يتم توفيره من قبل الشركة</td>
			<td align="right">السكن</td>
		</tr>
		<tr>
			<td>Transportation</td>
			<td>Provided by Company</td>
			<td align="right">يتم توفيره من قبل الشركة</td>
			<td align="right">النقل</td>
		</tr>
		<tr>
			<td>Medical Insurance</td>
			<td>Provided by Company</td>
			<td align="right">يتم توفيره من قبل الشركة</td>
			<td align="right">التأمين الطبي</td>
		</tr>
		<tr>
			<td>Motorbike</td>
			<td>Provided by Company</td>
			<td align="right">يتم توفيرها من قبل الشركة</td>
			<td align="right">دراجة نارية</td>
		</tr>
		<tr>
			<td>Fuel/Petrol</td>
			<td>Provided by Company</td>
			<td align="right">يتم توفيره من قبل الشركة</td>
			<td align="right">الوقود/ البترول</td>
		</tr>
		<tr>
			<td>Internet SIM</td>
			<td>25GB Provided by Company</td>
			<td align="right">25 جيجابايت مقدمة من الشركة</td>
			<td align="right">بطاقة الاتصال بالانترنت </td>
		</tr>
		<tr>
			<td>Working Hours (Excl Lunch)</td>
			<td>15 Delivery per day</td>
			<td align="right">15 ساعات في اليوم</td>
			<td align="right">ساعات العمل (باستثناء فترة الغداء)</td>
		</tr>
		<tr>
			<td>AVG Rider Acceptance Rate</td>
			<td>95%</td>
			<td align="right">95%</td>
			<td align="right">متوسط نسبة قبول قائد الدراجة</td>
		</tr>
		<tr>
			<td>Cancel Delivery Fine</td>
			<td>SAR 50 per Delivery</td>
			<td align="right">50 ريال لكل عملية توصيل</td>
			<td align="right">إلغاء غرامة التوصيل</td>
		</tr>
		<tr>
			<td>Probation Period</td>
			<td>180 Days</td>
			<td align="right">180 يوماً</td>
			<td align="right">فترة التجربه</td>
		</tr>
	</table>

	<table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
		<tr style="background-color:#000000;color:#ffffff;">
			<td align="left" colspan="2">Target & Incentive</td>
			<td align="right" colspan="2">الهدف والحافز</td>
		</tr>
		<tr>
			<td align="right">0-449 Delivery</td>
			<td align="center">SAR 4/-</td>
			<td align="center">SAR 1,796/-</td>
			<td align="right">توصيل 0-449</td>
		</tr>
		<tr>
			<td align="right">0-450 Delivery</td>
			<td align="center">SAR 6/-</td>
			<td align="center">SAR 2,700/-</td>
			<td align="right">توصيل 0-450</td>
		</tr>
		<tr>
			<td align="right">451-550 Delivery</td>
			<td align="center">SAR 10/-</td>
			<td align="center">SAR 1,000/-</td>
			<td align="right">توصيل 451-550</td>
		</tr>
		<tr>
			<td align="right">551-700 Delivery</td>
			<td align="center">SAR 12/-</td>
			<td align="center">SAR 1,800/-</td>
			<td align="right">توصيل 551-700</td>
		</tr>
		<tr>
			<td align="right">Bonus of 700 Delivery</td>
			<td align="center">SAR 200/-</td>
			<td align="center">SAR 200/-</td>
			<td align="right">مكافئة توصيل 700</td>
		</tr>
		<tr>
			<td align="center" colspan="2" style="color:red">Total on 700 Completed Delivery</td>
			<td align="center" style="color:red">Up to 5,700/-</td>
			<td align="right" style="color:red">الإجمالي على 700 توصيل مكتملة</td>
		</tr>
		<tr>
			<td rowspan="3"><br><br><br>Remarks*</td>
			<td align="center" colspan="2">DA should work at least 26 days per month with minimum 15 delivery each day</td>
			<td rowspan="3" align="right"><br><br><br> ملاحظات*</td>
		</tr>
		<tr>
			<td align="center" colspan="2">DAs should work on Thursday, Friday and Saturday and coordinate leaves from Sunday to Wednesday and during the last week of the month only one day of leave is allowed</td>
		</tr>
		<tr>
			<td align="center" colspan="2">Driving License fees paid by the company are fully deductible</td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr><td></td></tr>
	</table>
	<table border="1" cellspacing="0" cellpadding="3" style="width: 100%;font-size: 9px;">
		<tr>
			<td align="center"><h2><u> You should be able to use Google MAP </u></h2></td>
			<td align="center"><h2><u> يُفترض أن تتمكن من استخدام خرائط جوجل. </u></h2></td>
		</tr>
		<tr>
			<td align="center" valign="center"><h2><u> You must have 5G Mobile with 12GB RAM 516GB </u></h2></td>
			<td align="center"><h2><u> يجب أن يكون لديك هاتف يدعم شبكة 5G، ويحتوي على ذاكرة RAM بسعة 12 جيجابايت وسعة تخزين 516 جيجابايت. </u></h2></td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr><td></td></tr>
		<tr><td></td></tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr>
			<td>
				<table>
					<tr><td align="center"></td></tr>
					<tr>
						<td align="center"></td>
					</tr>
					<tr><td align="center"><p>Amal Al Anazi</p></td></tr>
					<tr><td align="center"><p style="font-size: 10px;">HR Specialist</p></td></tr>
				</table>
			</td>
			<td>
				<table>
					<tr><td align="center"><h4><u>Accepted by</u></h4></td></tr>
					<tr><td align="center"></td></tr>
					<tr><td align="center"><p><?= $emp_detail->full_name;?></p></td></tr>
					<tr><td align="center"><h3></h3></td></tr>
				</table>
			</td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
		<tr><td></td></tr>
		<tr><td></td></tr>
	</table>

</body>

</html>
