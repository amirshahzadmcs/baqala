<?php
	$requestDetails = $request_info['request_detail'];
	$requestDetailArray = json_decode($requestDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - <?= $requestDetailArray->title_english;?></title>
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
			<td colspan="2" height="40px"></td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
								<tr>
									<td valign="center" height="30px" style="text-align: left;"><strong><?= $requestDetailArray->title_english;?></strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
								<tr>
									<td valign="center" height="30px" style="text-align: right;"><strong> <?= $requestDetailArray->title_arabic;?> </strong></td>
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
									<td valign="center" height="20px" style="text-align: left;"><strong>Date: </strong> <?php echo formatedDate($requestDetailArray->request_date);?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> <?php echo Greg2Hijri($requestDetailArray->request_date);?> </strong></td>
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
									<td valign="center" height="20px" style="text-align: left;"><strong>HR Manager</strong><br>Maha Al Fala Trading Company<br>Riyadh Saudi Arabia</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> مدير الموارد البشرية </strong><br> شركة مها الفلا للتجارة  <br> المملكة العربية السعودية</td>
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
									<td valign="center" height="20px" style="text-align: left;"><strong>Dear Sir/ Madam, </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> إلى السادة/ السيدات الأعزاء </strong></td>
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
									<td valign="center" height="20px" style="text-align: left;"><?= nl2br($requestDetailArray->description_english); ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><span> <?= nl2br($requestDetailArray->description_arabic);?> </span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
				</table>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:left;">Emp ID</td>
									<td width="50%" style="text-align:left;"><?= $request_info['emp_no']; ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right;"><?= $request_info['emp_no']; ?></td>
									<td width="50%" style="text-align:right;"> رقم هوية الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:left;">EMP Name</td>
									<td width="50%" style="text-align:left;"><?= $request_info['employee_name']; ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right;"><?= $request_info['employee_arabic_name']; ?></td>
									<td width="50%" style="text-align:right;"> اسم الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:left;">EMP Iqama No</td>
									<td width="50%" style="text-align:left;"><?= $request_info['employee_iqama_no']; ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right;"><?= $request_info['employee_iqama_no']; ?></td>
									<td width="50%" style="text-align:right;"> رقم إقامة الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:left;">Emp Nationality</td>
									<td width="50%" style="text-align:left;"><?= $request_info['employee_nationality']; ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right;"><?= $request_info['employee_nationality_arabic']; ?></td>
									<td width="50%" style="text-align:right;"> جنسية الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:left;">Emp Position</td>
									<td width="50%" style="text-align:left;"><?= $request_info['designation_name']; ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: right;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td width="50%" style="border-right:1px solid #000;text-align:right;"><?= $request_info['designation_name_arabic']; ?></td>
									<td width="50%" style="text-align:right;"> منصب الموظف </td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					
					<tr>
						<td valign="center" height="30px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;">Sincerely,</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="30px" style="text-align: left;">
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
									<td valign="center" height="20px" style="text-align: left;"><strong>HR Manager</strong><br>Maha Al Fala Trading Company<br>Riyadh Saudi Arabia</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="40px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> مدير الموارد البشرية </strong><br> شركة مها الفلا للتجارة  <br> المملكة العربية السعودية</td>
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
