<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - New Arrival Food Advance Request Form</title>
	<style>
	*{padding:0px;margin:0px;}
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;}
        table td {word-wrap:break-word;}
	</style>
    <table cellpadding="5" cellspacing="0" border="1">
		<tr>
			<td colspan="4" align="center">
				<p><u>New Arrival Food Advance Request Form</u></p>
			</td>
		</tr>
		<tr>
			<th align="right"><strong>Date</strong></th>
			<td><?php echo (($issue_date !=='') ? $issue_date : 'NA');?></td>
			<th align="right"><strong>Visa No</strong></th>
			<td><?php echo (($batch_detail['visa_no'] !=='') ? $batch_detail['visa_no'] : 'NA');?></td>
		</tr>
		<tr>
			<th align="right"><strong>Name of Employee</strong></th>
			<td><?php echo implode(' ', array_filter([$batch_detail['first_name'], $batch_detail['middle_name'], $batch_detail['third_name'], $batch_detail['surname']])); ?></td>
			<th align="right"><strong>Border No</strong></th>
			<td><?php echo (($batch_detail['border_entry_no'] !=='') ? $batch_detail['border_entry_no'] : 'NA');?></td>
		</tr>
		<tr>
			<th align="right"><strong>Passport No</strong></th>
			<td><?php echo (($batch_detail['passport_no'] !=='') ? $batch_detail['passport_no'] : 'NA');?></td>
			<th align="right"><strong>Position Applied</strong></th>
			<td><?php echo (($batch_detail['applied_for_job'] !=='') ? $batch_detail['applied_for_job'] : 'NA');?></td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" border="1" style="width: 100%;">
		<thead>
			<tr style="background-color: #000;color:#fff;">
				<th width="10%" align="center">Sr. No.</th>
				<th width="40%" align="center">Amount Requested</th>
				<th width="50%" align="center">Amount In Word</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="10%" align="center">1.</td>
				<?php
					$firstPaymentAmount = json_decode($batch_detail['first_payment'])->payment_amt;
				?>
				<td width="40%" align="center"><?php echo isset($batch_detail['first_payment']) ? 'SAR '. $firstPaymentAmount : '-'; ?></td>
				<td width="50%" align="center"><?php echo convert_sar_to_words($firstPaymentAmount);?></td>
			</tr>
			<tr>
				<td align="center" width="10%">Purpose</td>
				<td width="90%" colspan="2">Food Allowance - [ &nbsp;&nbsp; ] Deductible [ <?php echo html_entity_decode('&#x2713;', ENT_XHTML,"ISO-8859-1");?> ] Non-Deductible</td>
			</tr>
		</tbody>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td>
				<p style="line-height: 20px;">I, Ms/Mr. <u><?php echo implode(' ', array_filter([$batch_detail['first_name'], $batch_detail['middle_name'], $batch_detail['third_name'], $batch_detail['surname']])); ?></u> hereby acknowledge that I have received the above-mentioned cash advance.</p>
			</td>
		</tr>
	</table>
	<table cellpadding="15" cellspacing="0" border="1">
		<tr>
			<td style="height:70px;"></td>
			<td style="height:70px;"></td>
			<td style="height:70px;"></td>
		</tr>
		<tr>
			<td align="center">Requestor Signature<br><small>Person who requested Cash Advance</small></td>
			<td align="center">Manager/Supervisor Signature<br><small>Person who is supporting the request</small></td>
			<td align="center">Authorized Signatory<br><small>Approver</small></td>
		</tr>
	</table>
</body>

</html>
