<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Maha Al Fala Trading Company - Salary Certificate</title>
	<style>
	*{padding:0px;margin:0px;}
	
	</style>
</head>
<body>
	<style>
		table {border-collapse:collapse; table-layout:fixed;line-height:1.5;}
        table td {word-wrap:break-word;}
	</style>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
        <tr>
			<td valign="center" style="text-align: left;width:15%;"><h3><strong>Date</strong></h3></td>
			<td valign="center" style="text-align: left;width:35%;"><h3><strong><?php echo date('d-m-Y', strtotime($form_center['date_of_issue'])); ?></strong></h3></td>
			<td valign="center" style="text-align: right;width:35%;"><h3><strong><?php echo Greg2Hijri($form_center['date_of_issue']); ?></strong></h3></td>
			<td valign="center" style="text-align: right;width:15%;"><h3><strong>التاريخ</strong></h3></td>
		</tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
        <tr>
			<td valign="center" style="text-align: center;"><h3><strong> شهادة خربة </strong></h3></td>
		</tr>
		<tr>
			<td valign="center" style="text-align: center;"><h3><strong> Salary Certificate </strong></h3></td>
		</tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
        <tr>
			<td valign="center" style="text-align: left;">To: </td>
			<td valign="center" style="text-align: right;"> إلى: </td>
		</tr>
        <tr>
			<td valign="center" style="text-align: left;">Maha Al Fala Trading Company hereby certifies that the below mentioned employee is working at the company as follows:</td>
			<td valign="center" style="text-align: right;"> : رشكة، وذلككما يتشـهد رشكة أن المذكور بيان </td>
		</tr>
    </table>
    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" style="text-align: center;"><h3><strong><u> المعلومات الشخصية Personal Details </u></strong></h3></td>
		</tr>
    </table>
	<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
		<tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Emp. Name</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['full_name'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['employee_arabic_name'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> االسم </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Nationality</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['nationality_name'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['nationality_name_arabic'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> الجنسية </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">ID No.</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['iqama_no'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['iqama_no'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> رقم الهوية </td>
		</tr>
	</table>

    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" style="text-align: center;"><h3><strong><u> معلومات الوظيفة Job Details </u></strong></h3></td>
		</tr>
    </table>
	<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
		<tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Job Title</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['designation_name'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['designation_arabic_name'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> المسمى الوظيفي </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Date of Joining</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?php echo (($employee_data['emp_detail']['work_joining_date'] !=='' && $employee_data['emp_detail']['work_joining_date'] !=='0000:00:00' && $employee_data['emp_detail']['work_joining_date'] !==NULL) ? date('d-m-Y', strtotime($employee_data['emp_detail']['work_joining_date'])) : 'NA');?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?php echo (($employee_data['emp_detail']['work_joining_date'] !=='' && $employee_data['emp_detail']['work_joining_date'] !=='0000:00:00' && $employee_data['emp_detail']['work_joining_date'] !==NULL) ? Greg2Hijri($employee_data['emp_detail']['work_joining_date']) : 'NA');?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> تاريخ الالتحاق بالعمل </td>
		</tr>
	</table>

    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" style="text-align: center;"><h3><strong><u> تفاصيل الراتب Salary Details </u></strong></h3></td>
		</tr>
    </table>
	<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
		<tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Basic Salary</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['basic_salary'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['basic_salary'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> الراتب الأساسي </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Housing Allowance</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['housing_allowance'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['housing_allowance'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> بدل السكن </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Transport Allowance</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['transport_allowance'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['transport_allowance'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> بدل المواصلات </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Food Allowance</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['food_allowance'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['food_allowance'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> بدل الطعام </td>
		</tr>
        <tr>
			<td valign="center" style="width:15%;line-height:10px;text-align:left;">Gross Salary</td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:32%;line-height:10px;text-align:left;"><?= $employee_data['emp_detail']['total_package'] ?? 'N/A' ?></td>
			<td valign="center" style="width:32%;line-height:10px;text-align:right;"><?= $employee_data['emp_detail']['total_package'] ?? 'N/A' ?></td>
			<td valign="center" style="width:3%;line-height:10px;text-align:center;">:</td>
			<td valign="center" style="width:15%;line-height:10px;text-align:right;"> الراتب الإجمالي </td>
		</tr>
	</table>

    <table border="1" cellspacing="0" cellpadding="7" style="width: 100%;font-size: 10px;">
		<tr>
			<td valign="center" align="left">This certificate has been issued to his request without any financial liability to the company. </td>
			<td valign="center" align="right">
                لقد تم إصدار هذه الشهادة بناءً على طلبه دون أي مسؤولية مالية على الشركة.
            </td>
		</tr>
        <tr>
			<td valign="center" align="left">Best Regards,</td>
			<td valign="center" align="right">
                مع أطيب التحيات،
            </td>
		</tr>
	</table>

	<table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
        <tr>
            <td></td>
            <td align="center">
                <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 12px;">
                    <tr><td></td></tr>
                    <tr><td style="border-bottom: 1px solid #000;"></td></tr>
                    <tr>
                        <td> مؤسسة مها الفال للتجارة  <br>Maha Al Fala Trading Company</td>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
	</table>

    <table border="0" cellspacing="0" cellpadding="5" style="width: 100%;font-size: 9px;">
        <tr>
            <td><u>Any alteration on this certificate renders it null and void.</u></td>
        </tr>
	</table>

</body>

</html>
