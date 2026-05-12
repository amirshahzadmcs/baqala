<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Maha Al Fala Trading Company - Absence from the Workplace Notification</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
	<?php
		$lastPresentDate = date('Y-m-d');
		$abscondedDate = date('Y-m-d');
		$total_absents = 0;
		// Check if $rider_order_summary is not 'null' and is an array with elements
		if (isset($rider_order_summary) && is_array($rider_order_summary) && count($rider_order_summary) > 0 && $rider_order_summary !== 'null') {
			$lastPresentDate = $rider_order_summary['date_local'];
		}

		if (isset($rider_order_summary) && is_array($rider_order_summary) && count($rider_order_summary) > 0 && $rider_order_summary !== 'null' && $emp_detail->status == 'Absconded') {
			$abscondedDate = $emp_detail->status_date;
		}
		$diff = date_diff(date_create($lastPresentDate), date_create($abscondedDate));
		$total_absents = $diff->format('%r%a');
	?>

    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 11px; width: 100%;">
		<tr>
			<td colspan="2" height="80px"></td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
								<tr>
									<td valign="center" height="30px" style="text-align: left;"><strong>Absence from the Workplace Notification</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
								<tr>
									<td valign="center" height="30px" style="text-align: center;"><strong> إشعار بخصوص التغيب عن مكان العمل </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong>Date: </strong> <?php $todayDate = date('Y-m-d'); echo date('M d, Y');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> <?php echo Greg2Hijri($todayDate);?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="line-height: 0px;"></td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong><?php echo $emp_detail->full_name;?></strong><br><?php echo $emp_detail->designation_name;?><br><?php echo $emp_detail->email;?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> <?php echo $emp_detail->employee_arabic_name;?> </strong><br> <?php echo $emp_detail->designation_name_ar;?> <br> <?php echo $emp_detail->email;?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong>Dear <?php echo $emp_detail->full_name;?>, </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> إلى السادة/  <?php echo $emp_detail->employee_arabic_name;?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="line-height: 0px;"></td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: justify;">We are writing this notice of concern due to your abrupt absence from the workplace. Your last day of attendance was on <?php echo $lastPresentDate;?> without any notice of leave, making it a total of <?php echo $total_absents;?> days of unnotified absence.</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><span> نكتب إليك هذا الإشعار لنبلغك بشعورنا بالقلق بسبب غيابك المفاجئ عن مكان العمل. كان آخر يوم لحضورك هو <?php echo $lastPresentDate;?> دون أي إشعار بالإجازة، مما يجعل مجموع أيام تغيبك بدون إشعار <?php echo $total_absents;?> يوماً.  </span></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: justify;">Your absenteeism has gravely disrupted the normal functioning of your team, causing inconvenience to other team members and the company at large. We request an immediate explanation for your prolonged absence.</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"> لقد أدى غيابك إلى تعطيل الأداء المعتاد والمنتظم لفريقك بشكل خطير، مما تسبب في ضيق وعدم راحة أعضاء الفريق الآخرين والشركة ككل. نطلب منك تقديم تفسير فوري لغيابك المطول عن العمل. . </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: justify;"><strong>If no response is received from your side within 3 days from the date of this letter, we will take it as an indication that you have resigned from your position at Maha Al Fala Trading Company.</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"> إذا لم نتسلم رداً من جانبك خلال ثلاثة يوماً من تاريخ هذا الخطاب فإننا سوف ننظر إلى هذا التصرف باعتباره إشارة إلى أنك قد استقلت من وظيفتك في شركة مها الفلا للتجارة .  </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: justify;">We hope to resolve this matter amicably and have you back working with us soon, in compliance with the company's guidelines and policies.</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"> نتمنى أن يتم حل هذه المسألة ودياً ونحظى برجوعك إلينا قريباً خلال التزامك بتوجيهات وسياسات الشركة.  </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="40px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;">Sincerely,</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="40px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: right;"> مخلصكم، </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="40px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong>Amal Al Anazi<br>HR Department</strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="40px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: right;"><strong> اسمك <br> اسم شركتك </strong></td>
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
