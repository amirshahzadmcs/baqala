<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - <?= $announcement_detail['title_english'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--[if !mso]><!-->
	<meta content="IE=edge" http-equiv="X-UA-Compatible"/>
	<style>
		body {
			width: 100% !important;
			height: 100% !important;
			padding: 10px !important;
			margin: 10px !important;
			font-family: Arial, Helvetica, sans-serif;
			color: #000;
		}
		table {
			border-collapse: collapse;
			table-layout: fixed;
			line-height: 1.5;
			font-family: Arial, Helvetica, sans-serif;
		}
		td {
			word-wrap: break-word;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #000;
		}
	</style>

</head>
<body>
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
									<td valign="center" height="30px" style="text-align: left;"><strong><?= $announcement_detail['title_english'];?></strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
								<tr>
									<td valign="center" height="30px" style="text-align: right;"><strong> <?= $announcement_detail['title_arabic'];?> </strong></td>
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
									<td valign="center" height="20px" style="text-align: left;"><strong>Date: </strong> <?php echo date('d-m-Y');?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> <?php echo Greg2Hijri(date('Y-m-d'));?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="line-height: 0px;"></td>
					</tr>
					<tr>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong>Dear Colleague, </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><strong> الزملاء الأعزاء، </strong></td>
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
									<td valign="center" height="20px" style="text-align: left;"><?= nl2br($announcement_detail['body_english']); ?></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="20px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: right;"><span> <?= nl2br($announcement_detail['body_arabic']);?> </span></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2"></td>
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
									<td valign="center" style="text-align: left;">Best regards,</td>
								</tr>
							</table>
						</td>
						<td valign="center" height="30px" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: right;"> مع أطيب التحيات </td>
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
