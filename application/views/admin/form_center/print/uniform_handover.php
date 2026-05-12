<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - Uniform Handover Form</title>
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
				<p><u>Uniform Handover Form</u></p>
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
			<th><strong>Handover Date</strong></th>
			<td><?php echo $data['issue_date']; ?></td>
			<th><strong>Handover by</strong></th>
			<td><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></td>
		</tr>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td colspan="4">
				<p>Dear Sir / Madam,</p>
				<p>We congratulate you for joining Maha Al Fala Trading Company!</p>
				<p>Please find the below as the assets handed over to you, to support you in carrying out your assignment in a most Proficient manner.</p>
			</td>
		</tr>
	</table>
	<?php
		$uniformItemsJson = $form_center['uniform_items'];
		$uniformItems = json_decode($uniformItemsJson, true);
	?>
	<table cellpadding="5" cellspacing="0" border="1">
		<thead>
			<tr>
				<th align="center" width="8%">Sr. No.</th>
				<th align="center" width="35%">Particulars</th>
				<th align="center" width="14%">Size</th>
				<th align="center" width="8%">Qty</th>
				<th align="center" width="35%">Remarks</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($uniformItems as $index => $uniform){ ?>
			<tr>
				<td align="center" width="8%"><?php echo $index + 1; ?></td>
				<td width="35%"><?php echo htmlspecialchars($uniform['item_name']); ?></td>
				<td width="14%"></td>
				<td align="center" width="8%"><?php echo htmlspecialchars($uniform['quantity']); ?></td>
				<td width="35%"></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td>
				<p style="line-height: 20px;text-align:justify;">I, Ms/Mr. <u><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></u> hereby acknowledge that I have Received the above-mentioned 
assets. I understand that this asset belongs to Maha Al Fala Trading Company and is under my possession for 
carrying out my office work. I hereby assure that I will take care of the assets of the company to the best possible 
extend.</p>
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
