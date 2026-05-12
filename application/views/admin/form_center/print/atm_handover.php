<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - ATM Card Handover Form</title>
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
				<h1>Maha Al Fala Trading Company</h1>
			</td>
		</tr>
		<tr>
			<td colspan="4" align="center">
				<p><u>ATM Card Handover Form</u></p>
			</td>
		</tr>
		<tr>
			<th><strong>Employee No</strong></th>
			<td><?php echo (($employee_data['emp_detail']['emp_no'] !=='') ? $employee_data['emp_detail']['emp_no'] : 'NA');?></td>
			<th><strong>Iqaama ID No</strong></th>
			<td><?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?></td>
		</tr>
		<tr>
			<th><strong>Employee Name</strong></th>
			<td><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></td>
			<th><strong>Nationality</strong></th>
			<td><?php echo (($employee_data['emp_detail']['nationality_name'] !=='') ? $employee_data['emp_detail']['nationality_name'] : 'NA');?></td>
		</tr>
		<tr>
			<th><strong>Job Title</strong></th>
			<td><?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?></td>
			<th><strong>Department</strong></th>
			<td><?php echo (($employee_data['emp_detail']['department_name'] !=='') ? $employee_data['emp_detail']['department_name'] : 'NA');?></td>
		</tr>
		<tr>
			<th><strong>Request Date</strong></th>
			<td><?php echo $data['issue_date']; ?></td>
			<th><strong>Requested by</strong></th>
			<td><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></td>
		</tr>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td colspan="4">
				<p>Dear Sir / Madam,</p>
				<p>We congratulate you for joining Maha Al Fala Trading Company!</p>
				<p>Please find the below Al Rajhi Bank ATM CARD, to support you in carrying out your assignment in a most proficient manner.</p>
			</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" border="1">
		<tr>
			<td colspan="5" align="center">
				<p>ATM Card Details</p>
			</td>
		</tr>
		<thead>
			<tr>
				<th width="50px" align="center">Sr. No.</th>
				<th align="center">Particulars</th>
				<th align="center">Last 4 Digits</th>
				<th width="50px" align="center">Qty</th>
				<th width="297px" align="center">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td width="50px" align="center">1.</td>
				<td>Employee ATM Card</td>
				<td><?php echo (($form_center['atm_card_no'] !=='') ? $form_center['atm_card_no'] : 'NA');?></td>
				<td width="50px" align="center">1</td>
				<td rowspan="2" width="297px" align="center">Personal ATM CARD</td>
			</tr>
			<tr>
				<td width="50px"></td>
				<td>Bank Name</td>
				<td colspan="2"><?php echo (($form_center['bank_name'] !=='') ? $form_center['bank_name'] : 'NA');?></td>
			</tr>
		</tbody>
	</table>
	<table cellpadding="5" cellspacing="0" border="1">
		<tr>
			<td height="150px"></td>
		</tr>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td>
				<p style="line-height: 20px;">I, Ms/Mr. <u><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></u> hereby acknowledge that I have received the above-mentioned assets. I understand that this asset belongs to Maha Al Fala Trading Company and is under my possession for carrying out my office work. I hereby assure that I will take care of the assets of the company to the best possible extend.</p>
			</td>
		</tr>
	</table>
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td></td>
		</tr>
	</table>
	<table cellpadding="15" cellspacing="0" border="1">
		<tr>
			<td align="right">Signature of Field Coordinator</td>
			<td></td>
			<td> توقيع المنسق الميدان</td>
		</tr>
		<tr>
			<td align="right">Signature of Operation</td>
			<td></td>
			<td> توقيع التشغيل</td>
		</tr>
		<tr>
			<td align="right">Signature of HR</td>
			<td></td>
			<td>توقيع الموارد البشرية</td>
		</tr>
	</table>
	<table cellpadding="5" cellspacing="0" border="1" style="line-height: 40px;">
		<tr>
			<td width="131.5px">Signature of Receiver</td>
			<td width="130px"></td>
			<td width="65px">توقيع المتلقي</td>
			<td width="136px">Signature of Handover</td>
			<td width="130px"></td>
			<td width="70px">توقيع التسليم</td>
		</tr>
		<tr>
			<td width="131.5px">Thump Impression</td>
			<td width="130px"></td>
			<td width="65px">بصمة اإلبهام</td>
			<td width="136px">Supervisor Signature</td>
			<td width="130px"></td>
			<td width="70px">توقيع الم رشف</td>
		</tr>
	</table>
</body>

</html>
