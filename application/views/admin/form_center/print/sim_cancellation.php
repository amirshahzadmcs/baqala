<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Baqala Station - SIM Card Cancellation Request Form</title>
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
				<p><u>SIM Card Cancellation Request Form</u></p>
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
			<td><?php echo $data['signature_date']; ?></td>
			<th><strong>Requested by</strong></th>
			<td><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></td>
		</tr>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td colspan="4">
				<p>Dear Sir / Madam,</p>
				<p>We kindly request you to terminate the SIM card Connection as per below details provided.</p>
			</td>
		</tr>
	</table>
	<?php 
		$sim_id = ($form_center['sim_id'] !=='') ? $form_center['sim_id'] : 0;
		$sim_info = simDetailHelper($sim_id);
	?>
	<table cellpadding="5" cellspacing="0" border="1">
		<thead>
			<tr>
				<th colspan="3" align="center"><p>Ownership Details</p></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th width="6%" align="center">1</th>
				<td width="34%">Ownership Type</td>
				<td width="60%"><?php echo (($sim_info->ownership_type !=='') ? ucfirst($sim_info->ownership_type) : 'NA');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">2</th>
				<td width="34%">Owner I'd</td>
				<td width="60%"><?php echo (($sim_info->owner_id !=='') ? $sim_info->owner_id : 'NA');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">3</th>
				<td width="34%">Owner Name</td>
				<td width="60%"><?php echo (($sim_info->owner_name !=='') ? $sim_info->owner_name : 'NA');?></td>
			</tr>
		</tbody>
	</table>
	<table cellpadding="5" cellspacing="0" border="1">
		<thead>
			<tr>
				<th colspan="3" align="center"><p>SIM Card Details</p></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th width="6%" align="center">1</th>
				<td width="34%">Service Provider</td>
				<td width="60%"><?php echo (($sim_info->network_name !=='') ? $sim_info->network_name : 'NA');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">2</th>
				<td width="34%">Service Type</td>
				<td width="60%"><?php echo (($sim_info->sim_type !=='') ? ucfirst($sim_info->sim_type) : 'NA');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">3</th>
				<td width="34%">Plan</td>
				<td width="60%"><?php echo (($sim_info->plan_name !=='') ? $sim_info->plan_name : 'NA');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">4</th>
				<td width="34%">Is GPS Sim (for Postpaid Sim)</td>
				<td width="60%"><?php echo (($sim_info->is_gps_sim =='on') ? 'Yes' : 'No');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">5</th>
				<td width="34%">Mobile No</td>
				<td width="60%"><?php echo (($sim_info->mobile !=='') ? $sim_info->mobile : 'NA');?></td>
			</tr>
			<tr>
				<th width="6%" align="center">6</th>
				<td width="34%">Sim Card No</td>
				<td width="60%"><?php echo (($sim_info->sim_no !=='') ? $sim_info->sim_no : 'NA');?></td>
			</tr>
		</tbody>
	</table>
	<table cellpadding="10" cellspacing="0" border="1">
		<tr>
			<td>
				<p style="line-height: 20px;">I, Ms/Mr. <u><?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?></u> hereby acknowledge that I have request to cancel the above-mentioned assets. I understand that this asset belongs to Maha Al Fala Trading Company and is no more required for carrying out my office work.</p>
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
