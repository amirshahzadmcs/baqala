<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Acknowledgment of Receipt of Cash Advance | Transfer of Sponsorship</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <?php
        $transferOption = $interview_detail->no_of_transfer ?? '';
        // Default values
        $amount = 0;

		$transferAmounts = [
			'2nd - 4000' => 2000,
			'3rd - 6000' => 4000,
		];

		$amount = $transferAmounts[$transferOption] ?? 0;

        // Convert amount to words
        if (!function_exists('amountToWords')) {
			function amountToWords($number)
			{
				$formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				return ucwords($formatter->format($number));
			}
		}
        $amountWords = $amount > 0 ? amountToWords($amount) : '';
    ?>

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
		<!-- <tr>
			<td style="text-align: left;"><?php echo date('l, d F, Y'); ?></td>
		</tr> -->
		<!-- Row 2: To and Employee Details -->
		<tr>
			<td>
			<p>To,<br/>
			The HR Manager<br/>
			Maha Al Fala Trading Company<br/>
			Riyadh, Saudi Arabia.</p>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<!-- Row 3: Subject -->
		<tr>
			<td>
				<b>Subject: Acknowledgment of Receipt of Cash Advance</b>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<!-- Row 5: Main Content - Warning -->
		<tr>
			<td>
				<p style="text-align: justify;">
					I, Mr. <b><?= htmlspecialchars($interview_detail->applicant_name ?? '') ?></b>,
					Iqama/ID Number <b><?= $interview_detail->iqama_number ?? '___________' ?></b>,
					the undersigned, certify that I have received an amount of
					<b>SAR <?= number_format($amount, 2) ?></b>,
					and in writing:
					<b><?= $amountWords ?> Saudi Riyals Only</b>,
					as an advance to be paid according to the pledge above or according
					to the company's bylaws and the authorization of the authorized person.
				</p>

				<p style="text-align: justify;"><b>Agreement and Repayment Terms:</b></p>

				<p style="text-align: justify;">
					By signing below, I acknowledge this amount is a debt owed to
					<b>Maha Al Fala Trading Est</b> and authorize the company to recover
					this amount via deductions from my future salaries, according to the
					terms specified in the attached pledge/company bylaws.
				</p>
			</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
	<table border="0" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;text-align:justify;line-height:20px; margin-top: 50px;">
		<tr>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Field</b></td>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Details</b></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Recipient Name:</b></td>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><?php echo htmlspecialchars($interview_detail->applicant_name ?? ''); ?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Iqama/ID No.:</b></td>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><?= $interview_detail->iqama_number ?? '___________'; ?></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Amount Received:</b></td>
			<td style="text-align: left;border-bottom: 1px solid #bbb;">SAR <?= number_format($amount, 2); ?></td>
		</tr>
		<tr>
			<td style="text-align: left;"><b>Date of Receipt:</b></td>
			<td style="text-align: left;"><?php echo $data['issue_date']; ?></td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: left;"><b>Signatures:</b></td>
		</tr>
		<tr>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Recipient Signature (<?php echo htmlspecialchars($interview_detail->applicant_name ?? ''); ?>)</b></td>
			<td style="text-align: left;border-bottom: 1px solid #bbb;"><b>Company Representative Signature</b></td>
		</tr>
	</table>
</body>

</html>
