<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - New Arrival Food Advance Request Form</title>
	<style>
	*{padding:0px;margin:0px;}
	ul {
    margin: 0;
		padding-left: 0;
	}
	table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
    table td {word-wrap:break-word;}
	</style>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
		<!-- <tr>
			<td align="center" style="font-size: 16px;font-weight:700;">
				<h3>Maha Al Fala Trading Est.</h3>
			</td>
		</tr> -->
		<tr>
			<td align="center" style="font-size: 16px;font-weight:700;">
				<h5><u>New Arrival Food Advance Request Form</u></h5>
			</td>
		</tr>
	</table>
	<table border="1" cellspacing="0" cellpadding="0" style="font-size: 12px; width: 100%;">
		<tr>
			<td>
				<table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-size: 12px;">
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr>
									<td valign="center" height="10px" width="40%" style="text-align: right;"><strong> Date </strong></td>
									<td valign="center" height="10px" width="60%" style="text-align: left;"><strong> <?php echo date('d-M-Y');?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr>
									<td valign="center" height="10px" width="40%" style="text-align: right;"><strong> Visa No </strong> </td>
									<td valign="center" height="10px" width="60%" style="text-align: left;"><strong> <?php echo $cv_detail->visa_no;?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr>
									<td valign="center" height="10px" width="40%" style="text-align: right;"><strong> Name of Employee </strong></td>
									<td valign="center" height="10px" width="60%" style="text-align: left;"><strong> <?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr>
									<td valign="center" height="10px" width="40%" style="text-align: right;"><strong> Border No </strong> </td>
									<td valign="center" height="10px" width="60%" style="text-align: left;"><strong> <?php echo $cv_detail->border_entry_no;?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr>
									<td valign="center" height="10px" width="40%" style="text-align: right;"><strong> Passport No </strong></td>
									<td valign="center" height="10px" width="60%" style="text-align: left;"><strong> <?php echo $cv_detail->passport_no;?> </strong></td>
								</tr>
							</table>
						</td>
						<td valign="center" height="10px" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr>
									<td valign="center" height="10px" width="40%" style="text-align: right;"><strong> Department </strong> </td>
									<td valign="center" height="10px" width="60%" style="text-align: left;"><strong> <?php echo $package_detail->department_name;?> </strong></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<table width="100%" border="1" cellspacing="0" cellpadding="5" style="font-size: 12px;">
								<tr style="background-color: #000;">
									<td valign="center" height="20px" width="10%" style="text-align: center;color:#fff">Sr. No</td>
									<td valign="center" height="20px" width="30%" style="text-align: center;color:#fff">Amount Requested</td>
									<td valign="center" height="20px" width="60%" style="text-align: center;color:#fff">Amount In Word</td>
								</tr>
								<tr>
									<td valign="center" height="20px" width="10%" style="text-align: center;">1.</td>
									<td valign="center" height="20px" width="30%" style="text-align: center;">SAR 100/-</td>
									<td valign="center" height="20px" width="60%" style="text-align: center;">One Hundred Saudi Riyals</td>
								</tr>
								<tr>
									<td valign="center" height="20px" style="text-align: center;">Purpose</td>
									<td colspan="2" valign="center" height="20px" style="text-align: left;">Food Allowance - [  &nbsp;&nbsp; ] Deductible &nbsp;&nbsp;&nbsp;&nbsp; [  &nbsp;&nbsp; ] Non-Deductible </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" valign="center" height="20px">
							<table width="100%" border="1" cellspacing="0" cellpadding="10" style="font-size: 12px;">
								<tr>
									<td valign="center" style="text-align: left;">I, Ms/Mr. <u><?php echo (($cv_detail->first_name !=='') ? $cv_detail->first_name : ''). (($cv_detail->middle_name !=='') ? ' '.$cv_detail->middle_name : ''). (($cv_detail->third_name !=='') ? ' '.$cv_detail->third_name : ''). (($cv_detail->surname !=='') ? ' '.$cv_detail->surname : '');?></u> hereby acknowledge that I have received the above-mentioned cash advance.</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" valign="center" style="text-align: left;">
							<table width="100%" border="1" cellspacing="0" cellpadding="15">
								<tr>
									<td valign="center" height="80px" style="text-align: center;">
									</td>
									<td valign="center" height="80px" style="text-align: center;">
									</td>
									<td valign="center" height="80px" style="text-align: center;">
									</td>
								</tr>
								<tr>
									<td valign="center" style="text-align: center;">
										<h6 style="font-size: 14px;line-height:0px;">Requestor Signature</h6>
										<p style="font-size: 10px;">Person who requested Cash Advance</p>
									</td>
									<td valign="center" style="text-align: center;">
										<h6 style="font-size: 14px;line-height:0px;">Manager/Supervisor Signature</h6>
										<p style="font-size: 10px;">Person who is supporting the request</p>
									</td>
									<td valign="center" style="text-align: center;">
										<h6 style="font-size: 14px;line-height:0px;">Authorized Signatory</h6>
										<p style="font-size: 10px;">Approver</p>
									</td>
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
