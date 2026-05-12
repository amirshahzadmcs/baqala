<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Hunger Station Driver Compliance Undertaking</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table border="0" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px;">
		<tr>
			<td></td>
		</tr>
        <tr>
			<td></td>
		</tr>
        <tr>
			<td></td>
		</tr>
		<!-- Row 1: Date and Empty Cell -->
		<tr>
			<td style="text-align: center;"><b>Hunger Station Driver Compliance Undertaking</b></td>
		</tr>
		<!-- Row 2: To and Employee Details -->
		<tr>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: justify;">I, <b><?= htmlspecialchars($interview_detail->applicant_name ?? '') ?></b>, holding Iqama No. <b><?= $interview_detail->iqama_number ?? '___________' ?></b>, am fully aware of the below-mentioned compliance points required to work with Hunger Station and agree to perform my duties accordingly. 
				I understand that if I fail to meet these standards, the company reserved the right to deduct penalties from my salary/earnings for non-compliance.</td>
		</tr>
		<!-- Row 3: Subject -->
		<tr>
			<td style="text-align:left"><b>Mandatory Compliance & Performance Points:</b></td>
		</tr>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td>
				<ul>
					<li><b>Minimum Order Threshold:</b> I understand that completing fewer than <b>200 orders</b> per month will result in ineligibility for a monthly salary payout.</li>
					<li><b>Performance Target:</b> I agree to meet the monthly target of <b>450 orders</b>.</li>
					<li><b>Non-Compliance Penalty:</b> I acknowledge that a penalty of <b>1000 SAR</b> may be applied for verified violations of these compliance terms.</li>
					<li><b>Working Hours:</b> I agree to remain online for a minimum of <b>10 hours daily</b>.</li>
					<li><b>Attendance:</b> I will work a minimum of <b>26 days</b> per month.</li>
					<li><b>Weekend Policy:</b> I understand that <b>no days off</b> are permitted on weekends (Thursday, Friday, and Saturday).</li>
					<li><b>Month-End Policy:</b> I agree that <b>no days</b> off are permitted during the last <b>10 days</b> of any month.</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td style="text-align:left"><b>Key Compliance Points:</b></td>
		</tr>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td>
				<ol>
					<li><b>Uniform & Hygiene:</b> Always wearing the Hunger Station vest/uniform and maintaining a professional appearance.</li>
					<li><b>Equipment:</b> Ensuring the thermal delivery bag is clean and used for every order.</li>
					<li><b>App Performance:</b> Maintaining a high acceptance rate and avoiding unnecessary order cancellations.</li>
					<li><b>Timeliness:</b> Adhering to estimated delivery times and marking statuses (Arrived, Picked Up, Delivered) accurately in real-time.</li>
					<li><b>Traffic Safety:</b> Strictly following Saudi Arabian traffic laws; any fines incurred are the sole responsibility of the driver.</li>
					<li><b>Customer Service:</b> Maintaining polite behavior with both merchants and customers.</li>
				</ol>
			</td>
		</tr>
	</table>
	<table border="0" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px; margin-top: 50px;">
		<tr>
			<td style="text-align: left;"><b>Acknowledgment:</b></td>
		</tr>
		<tr>
			<td style="text-align: left;">hereby confirm that I have read, understood, and voluntarily agreed to these terms as part of my engagement with Hunger Station.</td>
		</tr>
		<tr>
			<td style="text-align: left;"></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left;"><b>Signatures:</b> ___________________________________</td>
		</tr>
		<tr>
			<td style="text-align: left;"><b>Date:</b> <?php echo date('d / m / Y', strtotime($interview_detail->interview_date)); ?></td>
		</tr>
	</table>
</body>

</html>
