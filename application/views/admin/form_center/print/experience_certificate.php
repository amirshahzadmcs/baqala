<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Experience Certificate</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
	<table border="0" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
        <tr>
			<td valign="center" style="text-align: center;"></td>
		</tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
        <tr>
			<td valign="center" style="text-align: center;"><h3><strong> شهادة خربة </strong></h3></td>
		</tr>
		<tr>
			<td valign="center" style="text-align: center;"><h3><strong> Experience Certificate </strong></h3></td>
		</tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
        <tr>
			<td valign="center" style="text-align: center;"> اسم الموظ ف </td>
			<td valign="center" style="text-align: center;"> االدارة </td>
		</tr>
        <tr>
			<td valign="center" style="text-align: center;"> Employee Name </td>
			<td valign="center" style="text-align: center;"> Department </td>
		</tr>
        <tr>
			<td valign="center" style="text-align: center;"><strong> <?php echo (($employee_data['emp_detail']['full_name'] !=='') ? $employee_data['emp_detail']['full_name'] : 'NA');?> </strong></td>
			<td valign="center" style="text-align: center;"><strong> <?php echo (($employee_data['emp_detail']['department_name'] !=='') ? $employee_data['emp_detail']['department_name'] : 'NA');?> </strong></td>
		</tr>
    </table>
	<table border="1" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
        <tr>
            <td align="center" style="width:20%;line-height:10px;"> رقم الهوية/ اإلقامة </td>
			<td align="center" style="width:20%;line-height:10px;"> الجنسية </td>
			<td align="center" style="width:20%;line-height:10px;"> المسىم الوظيف ي </td>
			<td align="center" style="width:20%;line-height:10px;"> تاري خ البداية </td>
			<td align="center" style="width:20%;line-height:10px;"> آخر يوم عم ل </td>
        </tr>
		<tr>
			<td align="center" style="width:20%;line-height:10px;">ID / Iqama No.</td>
			<td align="center" style="width:20%;line-height:10px;">Nationality</td>
			<td align="center" style="width:20%;line-height:10px;">Job Title</td>
			<td align="center" style="width:20%;line-height:10px;">Joining Date</td>
			<td align="center" style="width:20%;line-height:10px;">Last Working Day</td>
		</tr>
        <tr>
			<td align="center"><strong><?php echo (($employee_data['emp_detail']['iqama_no'] !=='') ? $employee_data['emp_detail']['iqama_no'] : 'NA');?></strong></td>
			<td align="center"><strong><?php echo (($employee_data['emp_detail']['nationality_name'] !=='') ? $employee_data['emp_detail']['nationality_name'] : 'NA');?></strong></td>
			<td align="center"><strong><?php echo (($employee_data['emp_detail']['designation_name'] !=='') ? $employee_data['emp_detail']['designation_name'] : 'NA');?></strong></td>
			<td align="center"><strong><?php echo (($employee_data['emp_detail']['work_joining_date'] !=='') ? date('d-m-Y', strtotime($employee_data['emp_detail']['work_joining_date'])) : 'NA');?></strong></td>
			<td align="center"><strong><?php echo (($employee_data['emp_detail']['last_working_date'] !=='' && $employee_data['emp_detail']['last_working_date'] !=='0000:00:00' && $employee_data['emp_detail']['last_working_date'] !==NULL) ? date('d-m-Y', strtotime($employee_data['emp_detail']['last_working_date'])) : 'NA');?></strong></td>
        </tr>
	</table>
    <table border="1" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" align="left"><?= $employee_data['emp_detail']['sponsor_name'] ?? 'N/A' ?> Company certifies that Mr. <?= $employee_data['emp_detail']['full_name'] ?? 'N/A' ?> has worked for the company as described above, he was a good employee, and this certificate was awarded based on his request without any liability on the company.</td>
			<td valign="center" align="right">
                تشهد شركة <strong> <?= $employee_data['emp_detail']['sponsor_arabic_name'] ?? 'N/A' ?> </strong> أن السيد <strong> <?= $employee_data['emp_detail']['employee_arabic_name'] ?? 'N/A' ?> </strong> قد عمل في الشركة كما هو موضح أعلاه، وكان موظفًا جيدًا. وقد مُنحَت هذه الشهادة بناءً على طلبه دون أي مسؤولية على الشركة.
            </td>
		</tr>
	</table>

	<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 12px;">
		<tr>
			<td align="center"> مدير إدارة الموارد البشرية </td>
		</tr>
        <tr>
            <td align="center" style="height:150px;">Director of HR Department</td>
        </tr>
	</table>

</body>

</html>
