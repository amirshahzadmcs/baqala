<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Payment Request Form</title>
	<style>
	*{padding:0px;margin:0px;}
	table {border-collapse:collapse; table-layout:fixed;}
	table td {word-wrap:break-word;}
	.checkbox-text {
		font-size: 16px;
		line-height: 5px;
		vertical-align: bottom;
	}
	</style>
</head>
<body>
    <table cellpadding="1" cellspacing="0" border="0">
		<tr>
			<td align="left">
				<h2>PAYMENT REQUEST FORM</h2>
			</td>
		</tr>
		<tr>
			<td align="left">
				<p>Document No: <?php echo $payment->document_no; ?></p>
			</td>
		</tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 20%;"><strong>Method of Payment</strong></td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->method_of_payment == 'Bank Transfer') ? '&#9745;' : '&#9744;'; ?></span> Bank Transfer</td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->method_of_payment == 'Cash') ? '&#9745;' : '&#9744;'; ?></span> Cash</td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->method_of_payment == 'Wire Transfer') ? '&#9745;' : '&#9744;'; ?></span> Wire Transfer</td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->method_of_payment == 'Cheque') ? '&#9745;' : '&#9744;'; ?></span> Cheque</td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Type of Payment</strong></td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Advance Payment') ? '&#9745;' : '&#9744;'; ?></span> Advance Payment</td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Reimbursement') ? '&#9745;' : '&#9744;'; ?></span> Reimbursement</td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Invoice Due') ? '&#9745;' : '&#9744;'; ?></span> Invoice Due</td>
			<td style="width: 20%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Saddad Payment') ? '&#9745;' : '&#9744;'; ?></span> Saddad Payment</td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong></strong></td>
			<td style="width: 26%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Full') ? '&#9745;' : '&#9744;'; ?></span> Full</td>
			<td style="width: 26%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Partial') ? '&#9745;' : '&#9744;'; ?></span> <?php echo ($payment->type_of_payment == 'Partial') ? 'Partial '. $payment->partial_percentage .' %' : 'Partial ________%'; ?></td>
			<td style="width: 28%;"></td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong></strong></td>
			<td style="width: 26%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'Local') ? '&#9745;' : '&#9744;'; ?></span> Local</td>
			<td style="width: 26%;"><span class="checkbox-text"><?php echo ($payment->type_of_payment == 'International') ? '&#9745;' : '&#9744;'; ?></span> International</td>
			<td style="width: 28%;"></td>
		</tr>
		<tr>
			<td><strong><?php echo ($payment->request_for_type == 'vendor') ? 'Vendor Name' : 'Employee Name'; ?></strong></td>
			<td colspan="3"><?php echo ($payment->request_for_type == 'employee') ? 'MF'.str_pad($payment->request_for_id, 4, 0, STR_PAD_LEFT).'_'.$payment->request_name : $payment->request_name; ?></td>
		</tr>
		<?php
			if($payment->request_for_type == 'employee'){
				$deptDetail = departmentsDetailHelper($payment->department);
				$departName = $deptDetail->name;
			}else{
				$departName = 'NA';
			}
		?>
		<tr>
			<td style="width: 20%;"><strong>Department</strong></td>
			<td style="width: 38%;"><?php echo $departName; ?></td>
			<td style="width: 14%;">Cost Center</td>
			<td style="width: 28%;"><?php echo $payment->cost_center; ?></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 20%;line-height:30px;"><strong>Pay to</strong></td>
			<td rowspan="2" style="width: 38%;"></td>
			<td style="width: 14%;">Bank Name</td>
			<td style="width: 28%;"><?php echo $payment->bank_name; ?></td>
		</tr>
		<tr>
			<td style="width: 14%;">IBAN</td>
			<td style="width: 28%;"><?php echo $payment->iban_no; ?></td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Currency</strong></td>
			<td style="width: 26%;text-align:center;"><span class="checkbox-text"><?php echo ($payment->currency == 'sar') ? '&#9745;' : '&#9744;'; ?></span> SAR</td>
			<td style="width: 26%;text-align:center;"><span class="checkbox-text"><?php echo ($payment->currency == 'usd') ? '&#9745;' : '&#9744;'; ?></span> USD</td>
			<td style="width: 28%;text-align:center;"><span class="checkbox-text"><?php echo ($payment->currency == 'inr') ? '&#9745;' : '&#9744;'; ?></span> INR</td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Amount</strong></td>
			<td style="width: 26%;"><?php echo $payment->amount; ?></td>
			<td style="width: 26%;"></td>
			<td style="width: 28%;"></td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Vendor Reference</strong></td>
			<td style="width: 26%;"><?php echo $payment->vendor_reference; ?></td>
			<td style="width: 26%;">Quotation / PI / Invoice No</td>
			<td style="width: 28%;"><?php echo $payment->invoice_no; ?></td>
		</tr>
		<?php
			// Decode the instructions JSON into a PHP array
			$instructions = json_decode($payment->instructions, true);
		?>
		<?php for ($i = 0; $i < 3; $i++): ?>
		<tr>
			<?php if($i === 0){ ?>
			<td rowspan="3" style="width: 20%;"><strong>Comments/Further Instructions</strong></td>
			<?php } ?>
			<td style="width: 4%;text-align:center;"><?php echo $i + 1; ?>.</td>
			<td style="width: 76%;"><?php if (isset($instructions[$i])): ?><?php echo htmlspecialchars($instructions[$i]); ?><?php endif; ?></td>
		</tr>
		<?php endfor; ?>
	</table>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 20%;background-color:#000;color:#fff;text-align:center;"><strong>Workflow</strong></td>
			<td style="width: 26%;background-color:#000;color:#fff;text-align:center;"><strong>Requester</strong></td>
			<td style="width: 26%;background-color:#000;color:#fff;text-align:center;"><strong>Manager</strong></td>
			<td style="width: 28%;background-color:#000;color:#fff;text-align:center;"><strong>Department Head</strong></td>
		</tr>
		<tr>
			<td style="width: 20%;height:50px;line-height:50px;"><strong>Signature</strong></td>
			<td style="width: 26%;height:50px;"></td>
			<td style="width: 26%;height:50px;"></td>
			<td style="width: 28%;height:50px;"></td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Name</strong></td>
			<td style="width: 26%;"><?php echo employeeDetailHelper($payment->requester_id)->full_name;?></td>
			<td style="width: 26%;"><?php echo employeeDetailHelper($payment->manager_id)->full_name;?></td>
			<td style="width: 28%;"><?php echo employeeDetailHelper($payment->department_head)->full_name;?></td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Date</strong></td>
			<td style="width: 26%;"><?php echo $request_date;?></td>
			<td style="width: 26%;"><?php echo $request_date;?></td>
			<td style="width: 28%;"><?php echo $request_date;?></td>
		</tr>
	</table>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr><td></td></tr>
		<tr><td><u><strong>Finance Department</strong></u></td></tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td style="width: 20%;background-color:#000;color:#fff;text-align:center;"><strong>Workflow</strong></td>
			<td style="width: 21%;background-color:#000;color:#fff;text-align:center;"><strong>Accountant</strong></td>
			<td colspan="2" style="width: 34%;background-color:#000;color:#fff;text-align:center;"><strong>Finance Manager</strong></td>
			<td style="width: 25%;background-color:#000;color:#fff;text-align:center;"><strong>Payment Details</strong></td>
		</tr>
		<tr>
			<td rowspan="2" style="width: 20%;height:50px;line-height:50px;"><strong>Signature</strong></td>
			<td rowspan="2" style="width: 21%;height:50px;"></td>
			<td rowspan="2" style="width: 23%;height:50px;"></td>
			<td style="width: 12%;">Bank</td>
			<td style="width: 24%;"><span class="checkbox-text"><?php echo ($payment->finance_Payment_bank == 'Al Rajhi') ? '&#9745;' : '&#9744;'; ?></span> Al Rajhi &nbsp;&nbsp; <span class="checkbox-text"><?php echo ($payment->finance_Payment_bank == 'STC Bank') ? '&#9745;' : '&#9744;'; ?></span> STC Bank &nbsp;&nbsp; <br><span class="checkbox-text"><?php echo ($payment->finance_Payment_bank == 'Petty Cash') ? '&#9745;' : '&#9744;'; ?></span> Petty Cash</td>
		</tr>
		<tr>
			<td style="width: 12%;">Bank Ref. No</td>
			<td style="width: 24%;"><?php echo $payment->finance_bank_ref; ?></td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Emp Name</strong></td>
			<td style="width: 21%;"><?php echo employeeDetailHelper($payment->finance_accountant)->full_name;?></td>
			<td style="width: 23%;"><?php echo employeeDetailHelper($payment->finance_manager)->full_name;?></td>
			<td style="width: 12%;">Bank P.D</td>
			<td style="width: 24%;">
			<?php echo (!empty($payment->finance_payment_date) && $payment->finance_payment_date != '0000-00-00') 
    ? date('j-M-Y', strtotime($payment->finance_payment_date)) 
    : 'N/A'; ?>
			</td>
		</tr>
		<tr>
			<td style="width: 20%;"><strong>Date</strong></td>
			<td style="width: 21%;"><?php echo $request_date;?></td>
			<td style="width: 23%;"><?php echo $request_date;?></td>
			<td style="width: 12%;">Daftra Ref.</td>
			<td style="width: 24%;"><?php echo $payment->daftra_reference; ?></td>
		</tr>
	</table>
	<table cellpadding="1" cellspacing="0" border="0">
		<tr><td></td></tr>
		<tr><td><u><strong>Management Approval</strong></u></td></tr>
		<tr><td></td></tr>
	</table>
	<table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">
		<tr>
			<td rowspan="3" style="width: 20%;line-height:120px;text-align:center;"><strong>Authority</strong></td>
			<td style="width: 40%;text-align:center;height:40px;"></td>
			<td style="width: 40%;height:40px;"></td>
		</tr>
		<tr>
			<td style="width: 40%;text-align:center;">Deputy CEO<br>Faisal Saleem</td>
			<td style="width: 40%;text-align:center;">CEO<br>Abdulaziz Aldhoheyan</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;height:60px;"><p></p>Mohammed Aldhoheyan<br>Chairman</td>
		</tr>
	</table>
</body>

</html>
