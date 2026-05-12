<?php
	$requestDetails = $request_info['request_detail'];
	$requestDetailArray = json_decode($requestDetails);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
			<td colspan="3">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 11px;">
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 18px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong><?= $requestDetailArray->title_english;?></strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;">To,<br><strong><?= $request_info['emp_no'] .'_'. $request_info['employee_name']; ?></strong><br><?= $request_info['employee_iqama_no']; ?><br><?= $request_info['designation_name']; ?><br><?= $request_info['emp_department_name']; ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="line-height: 20px;"></td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;"><strong>Dear <?= $request_info['employee_name'];?>, </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="line-height: 0px;"></td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;"><?= nl2br($requestDetailArray->description_english); ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td></td>
					</tr>
				</table>
				
				<table>
					<tr>
						<td></td>
					</tr>
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" style="text-align: left;">Regards,</td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td valign="center" style="text-align: left;">
							<table width="100%" cellspacing="0" cellpadding="5" style="font-size: 11px;">
								<tr>
									<td valign="center" height="20px" style="text-align: left;"><strong>Amal Al Enazi</strong><br>HR Manager</td>
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
